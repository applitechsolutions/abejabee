<?php
    function Users(){
        $db = new Conexion();
        $sql = $db->query("SELECT * FROM user;");
        if ($db->rows($sql)>0) {
            while ($d = $db->recorrer($sql)) {
                $users[$d['idUser']] = array(
                    'idUser' => $d['idUser'],
                    'firstName' => $d['firstName'],
                    'lastName' => $d['lastName'],
                    'userName' => $d['userName'],
                    'passWord' => $d['passWord'],
                    'permissions' => $d['permissions']
                );
            }
        }else {
            $users = false;
        }
        return $users;
        $db->liberar($sql);
        $db->close();
    }
?>