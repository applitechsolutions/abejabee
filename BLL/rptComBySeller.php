<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idSeller = $_POST['sellerReporte4'];
$fechainicio = strtr($_POST['dateSrpt4'], '/', '-');
$fechafinal = strtr($_POST['dateErpt4'], '/', '-');

$fi = date('Y-m-d', strtotime($fechainicio));
$ff = date('Y-m-d', strtotime($fechafinal));

$result = $conn->query("SELECT S.idSale, S.dateStart, S.paymentMethod,
    (SELECT productCode FROM product WHERE idProduct = D._idProduct) as codigo,
    (SELECT productName FROM product WHERE idProduct = D._idProduct) as nombre,
    (SELECT makeName FROM make WHERE idMake = (SELECT _idMake FROM product WHERE idProduct = D._idProduct)) as marca,
    SUM(quantity) AS cantidad, SUM((priceS-discount)*quantity) AS subtotal
    FROM sale S INNER JOIN detailS D ON S.idSale = D._idSale
    WHERE S._idSeller = $idSeller AND S.dateStart BETWEEN '$fi' AND '$ff' GROUP BY (SELECT idProduct FROM product WHERE idProduct = D._idProduct) ORDER BY S.dateStart ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);

?>