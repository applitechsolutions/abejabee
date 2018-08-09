<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idPurchase = $_POST['id'];

    $result = $conn->query("SELECT quantity, costP,
    (SELECT productName FROM product WHERE idProduct = D._idProduct) as nombre,
    (SELECT productCode FROM product WHERE idProduct = D._idProduct) as codigo,
    (SELECT picture FROM product WHERE idProduct = D._idProduct) as imagen
    FROM detailP D WHERE _idPurchase = $idPurchase");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
?>