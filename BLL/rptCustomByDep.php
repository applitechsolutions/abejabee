<?php
include_once '../funciones/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idRut = $_POST['depReporte'];

$result = $conn->query("SELECT idCustomer, customerCode, customerName, customerTel, customerAddress,
    (select name from town where idTown = _idTown) as municipio,
    (select name from village where idVillage = _idVillage) as aldea,
    (select name from deparment where idDeparment = _idDeparment) as departamento,
    (select Sum((SELECT balance FROM balance where _idSale = idSale order by idBalance desc limit 1))
    from sale where _idCustomer = idCustomer and cancel = 0 and state = 0) as total
    FROM customer WHERE _idRoute = $idRut AND state = 0");

// $result = $conn->query("SELECT C.idCustomer, C.customerCode, C.customerName, C.customerTel, (SELECT balance FROM balance where _idSale = S.idSale order by idBalance desc limit 1) as total FROM customer C INNER JOIN sale S ON C.idCustomer = S._idCustomer WHERE C._idRoute = $idRut AND C.state = 0 AND S.state = 0 AND S.cancel = 0 GROUP BY S.idSale");

$outp = array();
// while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
//     $outp[] = $result->fetch_array(MYSQLI_ASSOC);
// }
while ($row = $result->fetch_assoc()) {
    $outp[] = $row;
}
//$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);