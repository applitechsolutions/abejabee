<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idRut = $_POST['depReporte'];


    $result = $conn->query("SELECT idCustomer, customerCode, customerName, customerTel, 
    (select Sum((SELECT balance FROM balance where _idSale = idSale order by idBalance desc limit 1))
    from sale where _idCustomer = idCustomer and cancel = 0) as total
    FROM customer WHERE _idRoute = $idRut");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode($outp);
?>