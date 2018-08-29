<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idSale = $_POST['id'];

    $result = $conn->query("SELECT balance FROM balance where _idSale = $idSale order by idBalance desc limit 1");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
?>