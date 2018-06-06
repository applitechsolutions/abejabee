<?php
/*
  EL NUCLUEO DE LA APLICACIÓN
*/

#CONSTANTES DE LA APLICACION
define('DB_HOST', 'us-cdbr-gcp-east-01.cleardb.net');
define('DB_USER', 'bce3db991ab40c');
define('DB_PASS', 'b553d955');
define('DB_NAME', 'gcp_7991657fa35342e92d26');

define('HTML_DIR','html/');
define('APP_TITLE','Schlenker Pharma');
//define('APP_URL', 'https://schlenker.azurewebsites.net/');
define('APP_COPY','Copyright &copy; ' . date('Y',time()) . ' Applitech Solutions. ');

require('core/models/classConnection.php');
require('core/bin/functions/Encrypt.php');

?>