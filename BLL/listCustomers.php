<?php
	include_once '../funciones/bd_conexion.php';
	header("Content-Type: application/json; charset=UTF-8");

    $result = $conn->query("SELECT idCustomer, customerName, customerCode, customerTel, customerNit, customerAddress, owner, inCharge,
    (SELECT name FROM deparment WHERE idDeparment = C._idDeparment) as depName,
    (SELECT name FROM town WHERE idTown = C._idTown) as townName,
    (SELECT name FROM village WHERE idVillage = C._idVillage) as villaName,
    (SELECT routeName FROM route WHERE idRoute = C._idRoute and state = 0) as roName
    FROM customer C WHERE state = 0 ORDER BY customerCode ASC");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
?>