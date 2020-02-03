<?php
$idBill = $_GET['idBill'];
require 'Libreria/fpdf.php';
require "NumeroALetras.php";
include_once '../funciones/bd_conexion.php';

class PDF extends FPDF
{} // FIN Class PDF

try {
    $sql = "SELECT dateEnd, date, total, codeSeller, town, codeCustomer, custName, custNit, address, mobile
                    FROM bill WHERE idBill = $idBill";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($sale = $resultado->fetch_assoc()) {
    $fechaF = date_create($sale['date']);
    $fecha = date_create($sale['dateEnd']);

    $pdf = new PDF('P', 'mm', array(215.9, 279.4));
    #Establecemos los márgenes izquierda, arriba y derecha:
    $pdf->SetMargins(0, 0, 0);

    #Establecemos el margen inferior:
    $pdf->SetAutoPageBreak(true, 0);
    $str = iconv('UTF-8', 'windows-1252', NumeroALetras::convertir($sale['total'], 'QUETZALES', 'CENTAVOS'));

    $pdf->AddFont('MicrosoftYaHeiUILight', '', 'MicrosoftYaHeiUILight-02.php');
    $pdf->AddPage();
    $pdf->SetFont('MicrosoftYaHeiUILight', '', 12);

    $pdf->SetXY(35, 48);
    //primera linea de factura
    $cMuni = iconv('UTF-8', 'windows-1252', $sale['town'] . ' ' . date_format($fechaF, 'd/m/Y'));
    $pdf->Cell(51, 5, $cMuni, 0, 0, 'L');
    $pdf->SetFont('MicrosoftYaHeiUILight', '', 10);
    $pdf->Cell(15);
    $cSeller = iconv('UTF-8', 'windows-1252', $sale['codeSeller']);
    $pdf->Cell(23, 5, $cSeller, 0, 0, 'L');
    $pdf->Cell(12);
    $cCode = iconv('UTF-8', 'windows-1252', $sale['codeCustomer']);
    $pdf->Cell(20, 5, $cCode, 0, 0, 'L');
    $pdf->SetFont('MicrosoftYaHeiUILight', '', 11);
    $pdf->Cell(22);
    $pdf->Cell(22, 5, date_format($fecha, 'd/m/Y'), 0, 1, 'L');

    $pdf->SetXY(29, 54);
    //Nombre
    $cName = iconv('UTF-8', 'windows-1252', $sale['custName']);
    $pdf->Cell(172, 5, $cName, 0, 0, 'L');

    $pdf->SetXY(23, 65);
    //NIT
    $pdf->Cell(50, 5, $sale['custNit'], 0, 0, 'L');

    $pdf->SetXY(30, 70);
    //Direccion
    $cAddress = iconv('UTF-8', 'windows-1252', $sale['address']);
    $pdf->MultiCell(171, 5, $cAddress, 0, 'L', 0);

    $pdf->SetXY(29, 88);
    //Telefono
    $pdf->Cell(50, 5, $sale['mobile'], 0, 0, 'L');

    //DETALLE DE FACTURA
    $pdf->SetXY(0, 102);
    $pdf->SetFont('MicrosoftYaHeiUILight', '', 12);
    try {
        $sql = "SELECT D.quantity, D.description, TRUNCATE((D.priceB - D.discount) ,2) as precio,
    TRUNCATE((TRUNCATE((D.priceB - D.discount) ,2) * D.quantity) ,2) as total,
    (select productCode from product where idProduct = D._idProduct) as codigo,
    (select productName from product where idProduct = D._idProduct) as nombre,
    (select makeName from make where idMake = (select _idMake from product where idProduct = D._idProduct)) as marca,
    (select description from product where idProduct = D._idProduct) as descripcion
    from detailB D WHERE _idBill = $idBill";
        $resultado = $conn->query($sql);
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }
    while ($detailB = $resultado->fetch_assoc()) {
        $COD = iconv('UTF-8', 'windows-1252', $detailB['codigo']);
        $NOMBRE = iconv('UTF-8', 'windows-1252', $detailB['nombre']);
        $DESC = iconv('UTF-8', 'windows-1252', $detailB['descripcion']);
        $DESCRIPTION = iconv('UTF-8', 'windows-1252', $detailB['description']);
        $pdf->Cell(15);
        $pdf->Cell(18, 5, $detailB['quantity'], 0, 0, 'C');
        $pdf->Cell(18, 5, $COD, 0, 0, 'L');
        if ($DESCRIPTION == '') {
            if ($detailB['marca'] == 'SCHLENKER') {
                $pdf->Cell(96, 5, $DESC, 0, 0, 'L');
            } else {
                $pdf->Cell(96, 5, $NOMBRE, 0, 0, 'L');
            }
        } else {
            $pdf->Cell(96, 5, $DESCRIPTION, 0, 0, 'L');
        }
        $pdf->Cell(23, 5, 'Q.' . $detailB['precio'], 0, 0, 'C');
        $pdf->Cell(30, 5, $detailB['total'], 0, 1, 'C');
    }

    //TOTAL-LETRAS
    $pdf->SetXY(15, 242);
    $pdf->MultiCell(132, 5, $str, 0, 'L', 0);

    //TOTAL
    $pdf->SetXY(173, 248);
    $pdf->SetFont('MicrosoftYaHeiUILight', '', 12);
    $pdf->Cell(30, 5, $sale['total'], 0, 0, 'L');
}

$pdf->Output(); //Salida al navegador