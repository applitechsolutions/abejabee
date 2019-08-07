<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idCustomer = $_POST['idCustomer'];

$result = $conn->query("SELECT idCustomer, customerCode, customerName, customerTel, customerNit, customerAddress, owner, inCharge,
(SELECT name FROM deparment where idDeparment = C._idDeparment) as deparment,
(SELECT routeName FROM route WHERE idRoute = C._idRoute) as route, S.noDeliver, S.dateStart, S.advance, S.dateEnd, S.cancel, S.totalSale,
(SELECT concat(sellerFirstName, ' ', sellerLastName) FROM seller where idSeller = S._idSeller) as seller,
(SELECT balance FROM balance WHERE _idSale = idSale ORDER BY idBalance DESC LIMIT 1) AS saldo,
(SELECT SUM(amount) FROM balance WHERE _idSale = idSale AND cheque = 1 AND state = 1) AS abono
FROM customer C INNER JOIN sale S ON C.idCustomer = S._idCustomer
WHERE C.idCustomer = $idCustomer AND S.state = 0 ORDER BY S.dateStart DESC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
