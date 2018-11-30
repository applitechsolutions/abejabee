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
    (SELECT makeName FROM make WHERE idMake = (SELECT _idMake FROM product WHERE idProduct = D._idProduct)) as marca
     FROM sale S INNER JOIN detailS D ON S.idSale = D._idSale
     WHERE S.cancel = 1 AND S._idSeller = $idSeller AND (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) BETWEEN '$fi' AND '$ff'");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>