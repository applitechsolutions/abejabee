<?php
$idSale = $_GET['idSale'];
require 'Libreria/fpdf.php';
require "NumeroALetras.php";
include_once '../funciones/bd_conexion.php';

class PDF extends FPDF
{

} // FIN Class PDF

try {
    $sql = "SELECT
                    (select name from town where idTown = C._idTown) as municipio,
                    (select name from village where idVillage = C._idVillage) as aldea,
                    (select name from deparment where idDeparment = C._idDeparment) as departamento,
                    C.customerName, C.customerAddress, C.customerTel
                    FROM sale S INNER JOIN customer C ON C.idCustomer = S._idCustomer WHERE idSale = $idSale";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($sale = $resultado->fetch_assoc()) {
    $pdf = new PDF('L', 'mm', array(191, 70));
#Establecemos los márgenes izquierda, arriba y derecha:
    $pdf->SetMargins(0, 0, 0);

#Establecemos el margen inferior:
    $pdf->SetAutoPageBreak(true, 0);
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 8);

    $pdf->SetXY(90, 25);
//Direccion
    $pdf->MultiCell(83, 3, $sale['customerName'].' '.$sale['customerAddress'].' '.$sale['customerAddress'] . ' ' . $sale['aldea'] . ' ' . $sale['municipio'] . ' ' . $sale['departamento'].' '.$sale['customerTel'], 0, 'L', 0);
}

$pdf->Output(); //Salida al navegador
