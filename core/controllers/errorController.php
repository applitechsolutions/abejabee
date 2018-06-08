<?php
     if (!isset($_SESSION['app_id'])){
      include(HTML_DIR.'public/login.php');
     }
   else { 

   echo "Error";
   }
  ?>