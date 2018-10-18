<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");

    $result = $conn->query("SELECT 
    (select (select concat(codeRoute, ' ', routeName) from route where idRoute = _idRoute) as route from customer where idCustomer = S._idCustomer) as route,
    (select concat(sellerCode, ' ', sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer,
    S.idSale, S.noBill, S.serie, S.noDeliver, S.advance, S.totalSale, S.dateStart, S.dateEnd, S.noShipment,
    DATEDIFF(curdate(), S.dateEnd) as days,
    CASE WHEN DATEDIFF(curdate(), S.dateEnd) > 29 AND DATEDIFF(curdate(), S.dateEnd) < 60 THEN 
    (SELECT balance FROM balance where _idSale = S.idSale order by idBalance desc limit 1) END as mora30,
    CASE WHEN DATEDIFF(curdate(), S.dateEnd) > 59 AND DATEDIFF(curdate(), S.dateEnd) < 90 THEN 
    (SELECT balance FROM balance where _idSale = S.idSale order by idBalance desc limit 1) END as mora60,
    CASE WHEN DATEDIFF(curdate(), S.dateEnd) > 89 THEN 
    (SELECT balance FROM balance where _idSale = S.idSale order by idBalance desc limit 1) END as mora90
    FROM sale S WHERE cancel = 0 AND state = 0 AND DATEDIFF(curdate(), S.dateEnd) > 29");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>