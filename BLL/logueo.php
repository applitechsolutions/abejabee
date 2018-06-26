<?php

if (isset($_POST['ingresar'])) {
    $usuario = $_POST['usaurio-login'];
    $password = $_POST['pass-login'];

    //die(json_encode($_POST));

    try{
        include_once '../funciones/bd_conexion.php';
        $stmt = $conn->prepare("SELECT U.idUser, U.firstName, U.lastName, U.userName, U.passWord, U.permissions FROM user U WHERE U.userName = ?;");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($id_log, $nombre_log, $apellido_log, $usuario_log, $pass_log, $permiso_log);
        if ($stmt->affected_rows) {
            $existe = $stmt->fetch();
            if ($existe) {
                if (password_verify($password, $pass_log)) {
                    session_start();
                    $_SESSION['idusuario'] = $id_log;
                    $_SESSION['usuario'] = $usuario_log;
                    $_SESSION['nombre'] = $nombre_log;
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $nombre_log
                    );
                }else {
                    $respuesta = array(
                        'respuesta' => 'error'
                    );
                }
            }else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
        }/*else {
            $respuesta = array(
                'respuesta' => 'error_select'
            );
        }*/
        $stmt->close();
        $conn->close();
    }catch(Exception $e) {
        echo 'Error: '. $e.getMessage();
    }
    
    die(json_encode($respuesta));
}

?>
