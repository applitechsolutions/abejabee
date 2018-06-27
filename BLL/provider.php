<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['registro'] == 'nuevo') {

    $name = $_POST['name'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $account1 = $_POST['account1'];
    $account2 = $_POST['account2'];
    $details = $_POST['details'];

    try{
        $stmt = $conn->prepare("INSERT INTO provider (providerName, providerAddress, providerTel, providerMobile, providerEmail, account1, account2, details) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $address, $tel, $mobile, $email, $account1, $account2, $details);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        if ($id_registro > 0) {
            $respuesta = array(
                'respuesta' => 'exito',
                'idProvider' => $id_registro,
                'mensaje' => 'Proveedor creado correctamente!'
            );
            
        }else {
            $respuesta = array(
                'respuesta' => 'error',
                'idProvider' => $id_registro
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['registro'] == 'actualizar') {

    $name = $_POST['name'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $account1 = $_POST['account1'];
    $account2 = $_POST['account2'];
    $details = $_POST['details'];
    $id_registro = $_POST['id_registro'];

    try {
        $stmt = $conn->prepare('UPDATE provider SET providerName = ?, providerAddress = ?, providerTel = ?, providerMobile = ?, providerEmail = ?, account1 = ?, account2 = ?, details = ? WHERE idProvider = ?');
        $stmt->bind_param("ssssssss", $name, $address, $tel, $mobile, $email, $account1, $account2, $details, $id_registro);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $stmt->insert_id,
                'mensaje' => 'Proveedor actualizado correctamente!'
            );
        }else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }

    die(json_encode($respuesta));
}

if ($_POST['registro'] == 'eliminar') {
    $id_eliminar = $_POST['id'];

    try {
        $stmt = $conn->prepare('UPDATE provider SET state = 1 WHERE idProvider = ?');
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