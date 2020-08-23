<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idCustomer = $_POST['idCustomer'];

$result = $conn->query("SELECT S.dateStart, S.dateEnd,  S.noDeliver, S.type,  S.advance, S.cancel, B.date, B.noDocument, B.amount, B.balance, B.balpay, B.cheque,
 C.customerCode, C.customerName, C.customerTel, C.customerNit, C.customerAddress, C.owner, C.inCharge,
 (SELECT name FROM deparment where idDeparment = C._idDeparment) as deparment,
(SELECT routeName FROM route WHERE idRoute = C._idRoute) as route,
(SELECT concat(sellerFirstName, ' ', sellerLastName) FROM seller where idSeller = S._idSeller) as seller
FROM sale S INNER JOIN balance B ON B._idSale = S.idSale INNER JOIN customer C ON C.idCustomer = S._idCustomer WHERE S._idCustomer = $idCustomer AND S.state = 0 AND B.state = 0 ORDER BY S.dateStart DESC, B.date ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);