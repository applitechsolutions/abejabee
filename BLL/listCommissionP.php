<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idSale = $_POST['id'];

$result = $conn->query("SELECT S.commissionS, S.commissionO, (select s30 from commission where _idSeller = S._idSeller) as s30,
        (select s60 from commission where _idSeller = S._idSeller) as s60, (select s90 from commission where _idSeller = S._idSeller) as s90,
        (select o30 from commission where _idSeller = S._idSeller) as o30, (select o60 from commission where _idSeller = S._idSeller) as o60,
        (select sd30 from commission where _idSeller = S._idSeller) as sd30, (select sd60 from commission where _idSeller = S._idSeller) as sd60,
        (select sd90 from commission where _idSeller = S._idSeller) as sd90, (select od30 from commission where _idSeller = S._idSeller) as od30,
        (select od60 from commission where _idSeller = S._idSeller) as od60
        FROM sale S WHERE idSale = $idSale");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);