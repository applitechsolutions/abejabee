<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['reg-vendedor'] == 'nuevo') {

    //die(json_encode($_POST));
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
        if ($nombre == '' || $apellido == '' || $telefono == '' || $dpi == '' || $genero == '') {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("INSERT INTO seller (sellerFirstName, sellerLastName, sellerAddress, sellerMobile, DPI, birthDate, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $nombre, $apellido, $direccion, $telefono, $dpi, $fecha_formateada, $genero);
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
?>