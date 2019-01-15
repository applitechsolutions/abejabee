<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idSeller = $_POST['sellerReporte'];
    $fechainicio = strtr($_POST['dateSrpt2'], '/', '-');
    $fechafinal = strtr($_POST['dateErpt2'], '/', '-');

    $fi = date('Y-m-d', strtotime($fechainicio));
    $ff = date('Y-m-d', strtotime($fechafinal));

    $result = $conn->query("SELECT S.*, 
    (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) as fechapago,
    quantity, priceS, discount,
    (SELECT productName FROM product WHERE idProduct = D._idProduct) as nombre,
    (SELECT productCode FROM product WHERE idProduct = D._idProduct) as codigo,
    (SELECT s30 FROM commission WHERE _idSeller = $idSeller) as s30,
    (SELECT s60 FROM commission WHERE _idSeller = $idSeller) as s60,
    (SELECT s90 FROM commission WHERE _idSeller = $idSeller) as s90,
    (SELECT o30 FROM commission WHERE _idSeller = $idSeller) as o30,
    (SELECT o60 FROM commission WHERE _idSeller = $idSeller) as o60,
    (SELECT sd30 FROM commission WHERE _idSeller = $idSeller) as sd30,
    (SELECT sd60 FROM commission WHERE _idSeller = $idSeller) as sd60,
    (SELECT sd90 FROM commission WHERE _idSeller = $idSeller) as sd90,
    (SELECT od30 FROM commission WHERE _idSeller = $idSeller) as od30,
    (SELECT od60 FROM commission WHERE _idSeller = $idSeller) as od60,
    (SELECT makeName FROM make WHERE idMake = (SELECT _idMake FROM product WHERE idProduct = D._idProduct)) as marca
     FROM sale S INNER JOIN detailS D ON S.idSale = D._idSale
     WHERE S.cancel = 1 AND S._idSeller = $idSeller AND (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) BETWEEN '$fi' AND '$ff' ORDER BY S.dateStart ASC");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>