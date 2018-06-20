<?php

$conn = new mysqli('us-cdbr-gcp-east-01.cleardb.net', 'bce3db991ab40c', 'b553d955', 'gcp_7991657fa35342e92d26');

if ($conn->connect_error) {
    echo $error -> $conn->connect_error;
}

?>