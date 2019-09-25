<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idBill = $_POST['id'];

    $result = $conn->query("SELECT _idProduct, quantity, priceB, discount, description,
    (SELECT productName FROM product WHERE idProduct = D._idProduct) as nombre,
    (SELECT productCode FROM product WHERE idProduct = D._idProduct) as codigo,
    (SELECT picture FROM product WHERE idProduct = D._idProduct) as imagen
    FROM detailB D WHERE _idBill = $idBill");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
