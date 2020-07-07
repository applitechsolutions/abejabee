<?php
	include_once '../funciones/bd_conexion.php';
	header("Content-Type: application/json; charset=UTF-8");

    $result = $conn->query("SELECT idProduct, productName, productCode, cost, minStock, description, picture,
                    (select makeName from make where idMake = P._idMake and state = 0) as make,
                    (select catName from category where idCategory = P._idCategory and state = 0) as category,
                    (select unityName from unity where idUnity = P._idUnity and state = 0) as unity,
                    (select price from priceSale where _idProduct = idProduct and _idPrice = 1) as public,
                    (select price from priceSale where _idProduct = idProduct and _idPrice = 11) as pharma,
                    (select price from priceSale where _idProduct = idProduct and _idPrice = 21) as business,
                    (select price from priceSale where _idProduct = idProduct and _idPrice = 31) as bonus
                    FROM product P WHERE state = 0 ORDER BY productCode");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
?>