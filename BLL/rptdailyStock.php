<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$fechainicio = strtr($_POST['dateSrpt5'], '/', '-');

$fi = date('Y-m-d', strtotime($fechainicio));

$result = $conn->query("SELECT P.idProduct, P.productName, P.productCode, P.cost, P.minStock, P.picture, S.stock,
(select SUM(quantity) from detailP DP INNER JOIN purchase PU ON DP._idPurchase = PU.idPurchase where _idProduct = P.idProduct AND PU.datePurchase > '$fi' AND PU.datePurchase <= CURDATE()) as compras,
(select SUM(quantity) from detailS DS INNER JOIN sale S ON DS._idSale = S.idSale where _idProduct = P.idProduct AND S.dateStart > '$fi' AND S.dateStart <= CURDATE() AND state = 0) as ventas,
(select makeName from make where idMake = P._idMake and state = 0) as make,
(select catName from category where idCategory = P._idCategory and state = 0) as category,
(select unityName from unity where idUnity = P._idUnity and state = 0) as unity
FROM storage S INNER JOIN product P ON P.idProduct = S._idProduct WHERE P.state = 0");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);

?>