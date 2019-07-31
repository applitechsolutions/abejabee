<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$product = $_POST['prodReporte'];
$fechainicio = strtr($_POST['dateSrpt6'], '/', '-');

$fi = date('Y-m-d', strtotime($fechainicio));

$result = $conn->query("SELECT S.dateStart, S.noDeliver, S.note, (D.priceS - D.discount) as price, D.quantity, 
(select sum(stock) from storage where _idProduct = D._idProduct) as stock
FROM `details` D INNER JOIN sale S ON D._idSale = S.idSale WHERE D._idProduct = $product AND S.dateStart >= '$fi' AND S.state = 0");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
