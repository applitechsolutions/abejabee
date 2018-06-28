<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['reg-vendedor' == 'nuevo']) {
    $nombre = $_POST['nombre-vendedor'];
    $apellido = $_POST['apel-vendedor'];
    $direccion = $_POST['direc-vendedor'];
    $telefono = $_POST['tel-vendedor'];
    $dpi = $_POST['dpi-vendedor'];
    $bday = $_POST['bday-vendedor'];
    $genero = $_POST['gen-vendedor'];
    
    try{
        $stmt = $conn->prepare("INSERT INTO seller (sellerFirstName, sellerLastName, selllerAddress, sellerMobile, DPI, birthDate, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $nombre, $apellido, $direccion, $telefono, $dpi, $bday, $genero);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        if ($id_registro > 0) {
            $respuesta = array(
                'respuesta' => 'exito',
                'idSeller' => $id_registro,
                'mensaje' => 'Vendedor creado correctamente!'
            );
            
        }else {
            $respuesta = array(
                'respuesta' => 'error',
                'idSeller' => $id_registro
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
}
?>