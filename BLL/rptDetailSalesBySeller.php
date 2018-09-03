<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idVenta = $_POST['idVenta'];

    //die(json_encode($fi));

    $result = $conn->query("SELECT quantity, priceS, discount,
    (SELECT productName FROM product WHERE idProduct = D._idProduct) as nombre,
    (SELECT productCode FROM product WHERE idProduct = D._idProduct) as codigo,
    (SELECT makeName FROM make WHERE idMake = (SELECT _idMake FROM product WHERE idProduct = D._idProduct)) as marca
    FROM detailS D WHERE _idSale = $idVenta");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>