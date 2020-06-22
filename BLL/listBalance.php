<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");

    $idSale = $_POST['id'];

    $result = $conn->query("SELECT idBalance, _idSale, noDocument, date, balpay, amount, noReceipt, balance, cheque, state, commissionS, totalS, commissionO, totalO, (select CONCAT(sellerFirstName, ' ', sellerLastName) from seller where idSeller = _idSeller) as _idSeller FROM balance where _idSale = $idSale order by idBalance desc");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
?>