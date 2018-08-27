<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['reg-vendedor'] == 'nuevo') {

    //die(json_encode($_POST));
    $codigo = $_POST['codigo-vendedor'];
    $nombre = $_POST['nombre-vendedor'];
    $apellido = $_POST['apel-vendedor'];
    $direccion = $_POST['direc-vendedor'];
    $telefono = $_POST['tel-vendedor'];
    $dpi = $_POST['dpi-vendedor'];
    $bday = $_POST['bday-vendedor'];

    $fecha_formateada = date('Y-m-d', strtotime($bday));
    $genero = $_POST['gen-vendedor'];
   // die(json_encode($fecha_formateada));
    
    try{
        if ($codigo == '' || $nombre == '' || $apellido == '' || $telefono == '' || $dpi == '' || $genero == '') {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("INSERT INTO seller (sellerCode, sellerFirstName, sellerLastName, sellerAddress, sellerMobile, DPI, birthDate, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssi", $codigo, $nombre, $apellido, $direccion, $telefono, $dpi, $fecha_formateada, $genero);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idSeller' => $id_registro,
                    'mensaje' => 'Vendedor creado correctamente!',
                    'proceso' => 'nuevo'
                );
                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idSeller' => $id_registro
                );
            }
            $stmt->close();
            $conn->close();
        }
        
    }catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['reg-vendedor'] == 'actualizar') {

    $id_seller = $_POST['id-reg-vendedor'];
    $codigo = $_POST['codigo-vendedor'];
    $nombre = $_POST['nombre-vendedor'];
    $apellido = $_POST['apel-vendedor'];
    $direccion = $_POST['direc-vendedor'];
    $telefono = $_POST['tel-vendedor'];
    $dpi = $_POST['dpi-vendedor'];
    $bday = $_POST['bday-vendedor'];

    $fecha_formateada = date('Y-m-d', strtotime($bday));
    $genero = $_POST['gen-vendedor'];

    try {
        $stmt = $conn->prepare("UPDATE seller SET sellerCode = ?, sellerFirstName = ?, sellerLastName = ?, sellerAddress = ?, sellerMobile = ?, DPI = ?, birthDate = ?, gender = ? WHERE idSeller = ?");
        $stmt->bind_param("sssssssii", $codigo, $nombre, $apellido, $direccion, $telefono, $dpi, $fecha_formateada, $genero, $id_seller);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $stmt->insert_id,
                'mensaje' => 'Vendedor actualizado correctamente!',
                'proceso' => 'editado'
            );
            
        }else {
            $respuesta = array(
                'respuesta' => 'error',
                'idSeller' => $id_registro
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e) {
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['reg-vendedor'] == 'eliminar') {
    $id_eliminar = $_POST['id'];

    try {
        $stmt = $conn->prepare('UPDATE seller SET state = 1 WHERE idSeller = ?');
        $stmt->bind_param("i", $id_eliminar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_eliminar
            );
        }else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}
?>