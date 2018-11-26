<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");

    $sql = "SELECT COUNT(idSale) AS ventasT FROM sale WHERE cancel = 0 AND state = 0 GROUP BY ";
    $resultado = $conn->query($sql);
    $ventasT = $resultado->fetch_assoc();

?>