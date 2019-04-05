<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$fechainicio = strtr($_POST['dateDASHS'], '/', '-');
$fechafinal = strtr($_POST['dateDASHE'], '/', '-');

$fi = date('Y-m-d', strtotime($fechainicio));
$ff = date('Y-m-d', strtotime($fechafinal));
$result = $conn->query("SELECT SUM(totalSale) FROM sale WHERE state = 0 AND dateStart BETWEEN '$fi' AND '$ff'");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);