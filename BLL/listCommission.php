<?php
	include_once '../funciones/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idSeller = $_POST['id'];

    $result = $conn->query("SELECT C.s30, C.s60, C.s90, C.o30, C.o60, C.sd30, C.sd60, C.sd90, C.od30, C.od60, 
    (SELECT sellerFirstName FROM seller WHERE idSeller = C._idSeller) as nombre,
    (SELECT sellerLastName FROM seller WHERE idSeller = C._idSeller) as apellido
    FROM commission C WHERE _idSeller = $idSeller");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>
