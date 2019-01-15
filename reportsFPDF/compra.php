<?php
$idPurchase = $_GET['idPurchase'];
require 'Libreria/fpdf.php';
require "NumeroALetras.php";
include_once '../funciones/bd_conexion.php';

class PDF extends FPDF
{

} // FIN Class PDF

try {
    $sql = "SELECT P.*, (select providerName from provider where idProvider = P._idProvider) as provider
                    FROM purchase P WHERE P.idPurchase = $idPurchase";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($purchase = $resultado->fetch_assoc()) {
    $fecha = date_create($purchase['datePurchase']);

    $pdf = new PDF('P', 'mm', 'Letter');
#Establecemos los márgenes izquierda, arriba y derecha:
    $pdf->SetMargins(0, 0, 0);

#Establecemos el margen inferior:
    $pdf->SetAutoPageBreak(true, 0);
    $str = iconv('UTF-8', 'windows-1252', NumeroALetras::convertir($purchase['totalPurchase'], 'QUETZALES', 'CENTAVOS'));

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->SetXY(140, 20);
    $pdf->Cell(60, 10, 'GUIA DE COMPRA', 1, 1, 'C');
    $pdf->SetXY(140, 30);
    $pdf->Cell(60, 10, date_format($fecha, 'd/m/Y'), 1, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Rect(10, 42, 90, 32);
    $pdf->SetXY(13, 44);
    $pdf->Cell(15, 4, 'Proveedor:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    //$Ccode = iconv('UTF-8', 'windows-1252', $purchase['provider']);
    //$pdf->Cell(10, 4, $Ccode, 0, 1, 'L');
    $pdf->Cell(13);
    $CName = iconv('UTF-8', 'windows-1252', $purchase['provider']);
    $pdf->Cell(120, 4, $CName, 0, 1, 'L');
    $pdf->Cell(13);
    // $CAddress = iconv('UTF-8', 'windows-1252', $sale['customerAddress'] . ' ' . $sale['aldea'] . ' ' . $sale['municipio'] . ' ' . $sale['departamento']);
    // $pdf->MultiCell(90, 4, $CAddress, 0, 'L', 0);
    $pdf->Cell(13);
    // $pdf->Cell(30, 4, $sale['customerTel'], 0, 1, 'L');
    $pdf->Cell(13);
    // $pdf->Cell(30, 4, $sale['customerNit'], 0, 0, 'L');

    $pdf->Rect(101, 42, 99, 32);
    $pdf->Rect(101, 42, 50, 14);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(101, 44);
    $strL = iconv('UTF-8', 'windows-1252', 'No. de factura:');
    $pdf->Cell(15, 4, $strL, 0, 1, 'L');
    $pdf->SetXY(101, 50);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(15, 4, $purchase['noBill'], 0, 1, 'L');
    $pdf->Rect(151, 42, 49, 14);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(151, 44);
    $pdf->Cell(15, 4, 'Serie:', 0, 1, 'L');
    $pdf->SetXY(151, 50);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(15, 4, $purchase['serie'], 0, 1, 'L');
    $pdf->Rect(101, 56, 50, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(101, 58);
    $pdf->Cell(15, 4, 'No. de Documento:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(5);
    //$pdf->Cell(15, 4, $sellerC, 0, 0, 'L');
    $pdf->Rect(101, 65, 50, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(101, 67);
    $sellerC = iconv('UTF-8', 'windows-1252', $purchase['noDocument']);
    $pdf->Cell(15, 4, $sellerC, 0, 0, 'L');
    $pdf->Rect(151, 56, 49, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(151, 58);
    $pdf->Cell(15, 4, 'Detalles:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    //$payment = iconv('UTF-8', 'windows-1252', $sale['paymentMethod']);
    $pdf->Cell(9);
    //$pdf->Cell(15, 4, $payment, 0, 0, 'L');
    $pdf->Rect(151, 65, 49, 9);
    $pdf->SetFont('Arial', 'B', 10);
    //$envio = iconv('UTF-8', 'windows-1252', 'Envío:');
    $pdf->SetXY(151, 67);
    //$pdf->Cell(15, 4, $envio, 0, 0, 'L');

//DETALLE DE FACTURA
    $pdf->SetXY(10, 77);
    $pdf->SetFont('Arial', 'B', 10);
    $codigo = iconv('UTF-8', 'windows-1252', 'Código Producto');
    $descrip = iconv('UTF-8', 'windows-1252', 'Descripción del producto');
    $pdf->Cell(30, 5, $codigo, 1, 0, 'L');
    $pdf->Cell(75, 5, $descrip, 1, 0, 'C');
    $pdf->Cell(18, 5, 'Cantidad', 1, 0, 'L');
    $pdf->Cell(33, 5, 'Precio Unit.', 1, 0, 'R');
    $pdf->Cell(34, 5, 'Subtotal Q.', 1, 0, 'R');
    try {
        $sql = "SELECT D.quantity, TRUNCATE((D.costP) ,2) as precio,
    TRUNCATE((TRUNCATE((D.costP) ,2) * D.quantity) ,2) as total,
    (select productCode from product where idProduct = D._idProduct) as codigo,
    (select productName from product where idProduct = D._idProduct) as nombre,
    (select catName from category where idCategory = (select _idCategory from product where idProduct = D._idProduct)) as categoria
    from detailp D WHERE _idPurchase = $idPurchase";
        $resultado = $conn->query($sql);
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }
    $pdf->SetXY(0, 84);
    $pdf->SetFont('Arial', '', 10);
    $Contador = 82;
    while ($detailP = $resultado->fetch_assoc()) {
        $COD = iconv('UTF-8', 'windows-1252', $detailP['codigo']);
        $NOMBRE = iconv('UTF-8', 'windows-1252', $detailP['nombre']);
        $CATEGORIA = iconv('UTF-8', 'windows-1252', $detailP['categoria']);
        $Contador = $Contador + 4;
        $pdf->Cell(10);
        $pdf->Cell(30, 4, $COD, 0, 0, 'L');
        $pdf->Cell(75, 4, $NOMBRE . ' ' . $CATEGORIA, 0, 0, 'L');
        $pdf->Cell(18, 4, $detailP['quantity'], 0, 0, 'R');
        $pdf->Cell(33, 4, 'Q.' . $detailP['precio'], 0, 0, 'R');
        $pdf->Cell(34, 4, $detailP['total'], 0, 1, 'R');
    }

    //TOTAL
    $pdf->SetXY(161, $Contador + 10);
    $pdf->Cell(40, 5, 'TOTAL Q__' . $purchase['totalPurchase'], 1, 0, 'C');

    //TOTAL-LETRAS
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(10, $Contador + 10);
    $pdf->MultiCell(150, 5, $str, 0, 'L', 0);

    //TOTAL-LETRAS
    // $note = iconv('UTF-8', 'windows-1252', $sale['note']);
    //$pdf->SetXY(10, $Contador + 20);
    //$pdf->MultiCell(85, 5, $note, 1, 'L', 0);
}
$pdf->Output(); //Salida al navegador