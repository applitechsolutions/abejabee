<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idSeller = $_POST['sellerReporte'];
    $fechainicio = strtr($_POST['dateSrpt2'], '/', '-');
    $fechafinal = strtr($_POST['dateErpt2'], '/', '-');

    $fi = date('Y-m-d', strtotime($fechainicio));
    $ff = date('Y-m-d', strtotime($fechafinal));

    $result = $conn->query("SELECT S.dateStart, S.noDeliver, B.noDocument, B.date, B.amount, B.noReceipt, B.totalS, B.totalO
    FROM sale S INNER JOIN balance B ON S.idSale = B._idSale WHERE S.state = 0 AND B.balpay = 1 AND B.state = 0 AND 
    B.date BETWEEN $fi AND $ff AND S._idSeller = $idSeller ORDER BY B.date ASC;");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);