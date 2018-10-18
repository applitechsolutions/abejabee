<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idCliente = $_POST['idCliente'];

    $result = $conn->query("SELECT serie, noBill, noDeliver, dateStart, (SELECT balance FROM balance WHERE _idSale = idSale ORDER BY idBalance DESC LIMIT 1) AS saldo
    FROM sale WHERE _idCustomer = $idCliente AND cancel = 0 AND state = 0");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>