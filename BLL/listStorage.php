<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idProduct = $_POST['id'];

    $result = $conn->query("SELECT stock, dateExp FROM storage WHERE _idProduct = $idProduct AND _idCellar = 1;");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>
