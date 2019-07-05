<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idProduct = $_POST['id'];

    $result = $conn->query("SELECT S.stock, S.dateExp, 
    (SELECT productName FROM product WHERE idProduct = S._idProduct) as name,
    (SELECT productCode FROM product WHERE idProduct = S._idProduct) as code
    FROM storage S WHERE S._idProduct = $idProduct AND S._idCellar = 1;");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>
