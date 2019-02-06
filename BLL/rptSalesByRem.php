<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idSeller = $_POST['sellerReporte4'];
$fechainicio = strtr($_POST['dateSrpt4'], '/', '-');
$fechafinal = strtr($_POST['dateErpt4'], '/', '-');

$fi = date('Y-m-d', strtotime($fechainicio));
$ff = date('Y-m-d', strtotime($fechafinal));

$result = $conn->query("SELECT S.*, 
(select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
(select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer
FROM sale S WHERE S._idSeller = $idSeller AND S.dateStart BETWEEN '$fi' AND '$ff' ORDER BY S.dateStart ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);

?>