<?php

    function Encrypt($string){
        $long = strlen($string);
        $str = '';
        for ($i=0; $i <$long; $i++) { 
            $str .= ($i % 2) != 0 ? md5($string[$i]) : $i;
        }
        return md5($str);
    }

?>