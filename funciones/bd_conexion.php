<?php

$conn = new mysqli('us-cdbr-azure-central-a.cloudapp.net', 'b4ca207be675e3', '45d554a4', 'schlenker');

if ($conn->connect_error) {
    echo $error -> $conn->connect_error;
}

?>