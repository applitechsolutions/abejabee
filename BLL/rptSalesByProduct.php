<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$fechainicio = strtr($_POST['dateSrpt8'], '/', '-');
$fechafinal = strtr($_POST['dateErpt8'], '/', '-');

$fi = date('Y-m-d', strtotime($fechainicio));
$ff = date('Y-m-d', strtotime($fechafinal));

$result = $conn->query("SELECT
(select productCode from product where idProduct = _idProduct) as code,
(select productName from product where idProduct = `_idProduct` ) as name,
(select makeName from make where idMake = (select _idMake from product where idProduct = _idProduct)) as make,
(select catName from category where idCategory = (select _idCategory from product where idProduct = _idProduct)) as category,
(select unityName from unity where idUnity = (select _idUnity from product where idProduct = _idProduct)) as unity,
(select description from product where idProduct = `_idProduct` ) as description,
SUM(quantity) as ventas FROM `details` D INNER JOIN sale S ON D._idSale = S.idSale
WHERE state = 0 AND (select state from product where idProduct = _idProduct) = 0 AND S.dateStart BETWEEN '$fi' AND '$ff'
GROUP BY `_idProduct`ORDER BY SUM(quantity) DESC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);