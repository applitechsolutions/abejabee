<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idSeller = $_POST['sellerReporte9'];
$fechainicio = strtr($_POST['dateSrpt9'], '/', '-');
$fechafinal = strtr($_POST['dateErpt9'], '/', '-');

$fi = date('Y-m-d', strtotime($fechainicio));
$ff = date('Y-m-d', strtotime($fechafinal));

$result = $conn->query("SELECT SUM(amount) as total FROM balance B INNER JOIN sale S ON B._idSale = S.idSale WHERE S.state = 0 AND B.state = 0 AND B.balpay = 1 AND S._idSeller = $idSeller");

$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);