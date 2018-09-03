<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idSeller = $_POST['sellerReporte'];
    $fechainicio = $_POST['dateSrpt2'];
    $fechafinal = $_POST['dateErpt2'];

    $fi = date('Y-m-d', strtotime($fechainicio));
    $ff = date('Y-m-d', strtotime($fechafinal));

    //die(json_encode($fi));

    $result = $conn->query("SELECT S.*,
    (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) as fechapago,
    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer
    FROM sale S WHERE S.cancel = 1 AND S._idSeller = $idSeller AND (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) BETWEEN '$fi' AND '$ff'");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>