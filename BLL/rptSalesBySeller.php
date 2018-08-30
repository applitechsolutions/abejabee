<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idSeller = $_POST['sellerReporte'];

    $result = $conn->query("SELECT S.*,
    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer
    FROM sale S WHERE S.cancel = 1 AND S._idSeller = $idSeller");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>