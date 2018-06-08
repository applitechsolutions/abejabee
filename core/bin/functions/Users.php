<?php
    function Users(){
        $db = new Conexion();
        $sql = $db->query("SELECT * FROM users;");
        if ($db->rows($sql)>0) {
            while ($d = $db->recorrer($sql)) {
                $users[$d['id']] = array(
                    'idUser' => $d['idUser'],
                    'firstName' => $d['firstName'],
                    'lastName' => $d['lastName'],
                    'userName' => $d['userName'],
                    'passWord' => $d['passWord']
                );
            }
        }else {
            $user = false;
        }
        return $user;
        $db->liberar($sql);
        $db->close();
    }
?>