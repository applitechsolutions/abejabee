<?php
if ($_POST['guardar-usuario'] == 'nuevo') {
    
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];
    $pass_hashed = password_hash($password, PASSWORD_BCRYPT);


    try{
        include_once '../funciones/bd_conexion.php';
        $stmt = $conn->prepare("INSERT INTO user (firstName, lastName, userName, passWord, permissions) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nombre, $apellido, $usuario, $pass_hashed, $rol);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        if ($id_registro > 0) {
            $respuesta = array(
                'respuesta' => 'exito',
                'idUser' => $id_registro
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
    # code...
}
?>