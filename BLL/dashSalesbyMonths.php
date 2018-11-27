<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");

    $conn->query("SET lc_time_names = 'es_ES'");
    $result = $conn->query("SELECT MONTHNAME(dateStart) as month, COUNT(idSale) AS ventasT FROM sale WHERE cancel = 0 AND state = 0 AND YEAR(dateStart) =  YEAR(CURDATE()) GROUP BY MONTH(dateStart) ORDER BY MONTH(dateStart)");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>