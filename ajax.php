<?php

    if ($_POST) {
        require('core/core.php');
        
        switch (isset($_GET['mode']) ? $_GET['mode'] : null) {
            case 'login':
                require('core/bin/ajax/goLogin.php');
                break;
            case 'newUser':
                require('core/bin/ajax/newUser.php');
                break;
                            
            default:
                header('location: login.php');
                break;
        }
    } else {
        header('location: login.php');
    }
    

?>