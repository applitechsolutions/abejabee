<?php
include_once '../funciones/bd_conexion.php';
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$rol = $_POST['rol'];


if ($_POST['registro'] == 'nuevo') {
    
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $pass_hashed = password_hash($password, PASSWORD_BCRYPT);


    try{
        $stmt = $conn->prepare("INSERT INTO user (firstName, lastName, userName, passWord, permissions) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nombre, $apellido, $usuario, $pass_hashed, $rol);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        if ($id_registro > 0) {
            $respuesta = array(
                'respuesta' => 'exito',
                'idUser' => $id_registro,
                'mensaje' => 'Usuario creado correctamente!'
            );
            
        }else {
            $respuesta = array(
                'respuesta' => 'error',
                'idUser' => $id_registro
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
    $id_registro = $_POST['id_registro'];
    try {
        $stmt = $conn->prepare('UPDATE user SET firstName = ?, lastName = ?, permissions = ? WHERE idUser = ?');
        $stmt->bind_param("ssii", $nombre, $apellido, $rol, $id_registro);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $stmt->insert_id,
                'mensaje' => 'Usuario actualizado correctamente!'
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
?>