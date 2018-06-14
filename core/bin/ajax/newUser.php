<?php
    if (!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['nombre']) && !empty($_POST['apel'])) {
        $db = new Conexion();
        $nombre = $db->real_escape_string($_POST['nombre']);
        $apel = $db->real_escape_string($_POST['apel']);
        $user = $db->real_escape_string($_POST['user']);
        $pass = Encrypt($_POST['pass']);
        $permisos = 0;
        $sql = $db->query("INSERT INTO user(firstName, lastName, userName, passWord, permissions) VALUES('$nombre', '$apel', '$user', '$pass', '$permisos');");

        if ($sql) {
            echo 1;
        }else{
            echo '<div class="alert alert-dismissible alert-danger">
            <button class="close" type="button" data-dismiss="alert">&times;</button>
            <strong>ERROR!</strong> Error al insertar
            </div>';
        }
        //$db->liberar($sql);
        $db->close();
    } else {
        echo '<div class="alert alert-dismissible alert-warning">
            <button class="close" type="button" data-dismiss="alert">&times;</button>
            <strong>ERROR!</strong> Todos los campos deben de estar llenos.
            </div>';
    }
    

    
?>