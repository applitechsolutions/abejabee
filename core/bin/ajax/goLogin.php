<?php
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $db = new Conexion();
        $user = $db->real_escape_string($_POST['username']);
        $pass = Encrypt($_POST['password']);
        $sql = $db->query("SELECT * FROM user WHERE userName = '$user' AND passWord = '$pass' LIMIT 1;");
        if ($db->rows($sql) > 0) {
            if ($_POST['remember']) { ini_set('session.cookie_lifetime', time() + (60*60*24));}
            $_SESSION['app_id'] = $db->recorrer($sql)[0];
            echo 1;
        } else{
            echo '<div class="alert alert-dismissible alert-danger">
            <button class="close" type="button" data-dismiss="alert">&times;</button>
            <strong>ERROR!</strong> Las credenciales son incorrectas.
            </div>';
        }
        $db->liberar($sql);
        $db->close();
    } else {
        echo '<div class="alert alert-dismissible alert-warning">
            <button class="close" type="button" data-dismiss="alert">&times;</button>
            <strong>ERROR!</strong> Todos los campos deben de estar llenos.
            </div>';
    }
    

    
?>