<?php
     if (!isset($_SESSION['app_id'])){
      include(HTML_DIR.'public/login.php');
     }
   else {
   
      $_SESSION['app_id'] == NULL ;
      unset($_SESSION['app_id']);
      session_destroy();                  
      include(HTML_DIR.'public/login.php');
   }
?>