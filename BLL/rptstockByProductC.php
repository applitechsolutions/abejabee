<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$product = $_POST['prodReporte'];
$fechainicio = strtr($_POST['dateSrpt6'], '/', '-');

$fi = date('Y-m-d', strtotime($fechainicio));

$result = $conn->query("SELECT P.datePurchase, (select providerName from provider where idProvider = P._idProvider) as provider,
P.noBill, P.serie, noDocument, D.costP, D.quantity
FROM `detailp` D INNER JOIN purchase P ON D._idPurchase = p.idPurchase where D._idProduct = $product AND P.datePurchase >= '$fi'");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);

?>