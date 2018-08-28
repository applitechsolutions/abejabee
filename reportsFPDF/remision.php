<?php
$idSale = $_GET['idSale'];
require 'Libreria/fpdf.php';
require "conversor.php";
include_once '../funciones/bd_conexion.php';

class PDF extends FPDF
{

} // FIN Class PDF

try {
    $sql = "SELECT dateStart, dateEnd, totalSale, noBill, paymentMethod,
                    (select sellerCode from seller where idSeller = S._idSeller) as sellercode,
                    (select name from town where idTown = C._idTown) as municipio,
                    (select name from village where idVillage = C._idVillage) as aldea,
                    (select name from deparment where idDeparment = C._idDeparment) as departamento,
                    C.customerCode, C.customerName, C.customerNit, C.customerAddress, C.customerTel
                    FROM sale S INNER JOIN customer C ON C.idCustomer = S._idCustomer WHERE idSale = $idSale";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($sale = $resultado->fetch_assoc()) {
    $fechaS = date_create($sale['dateStart']);
    $fecha = date_create($sale['dateEnd']);

    $pdf = new PDF('P', 'mm', 'Letter');
#Establecemos los márgenes izquierda, arriba y derecha:
    $pdf->SetMargins(0, 0, 0);

#Establecemos el margen inferior:
    $pdf->SetAutoPageBreak(true, 0);
    $str = iconv('UTF-8', 'windows-1252', convertir($sale['totalSale']));

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->SetXY(150, 20);
    $pdf->Cell(60, 10, 'GUIA DE REMISION', 1, 1, 'C');
    $pdf->SetXY(150, 30);
    $pdf->Cell(60, 10, $sale['noBill'], 1, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Rect(15, 42, 95, 32);
    $pdf->SetXY(18, 44);
    $pdf->Cell(15, 4, 'Cliente:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $Ccode = iconv('UTF-8', 'windows-1252', $sale['customerCode']);
    $pdf->Cell(10, 4,$Ccode , 0, 1, 'L');
    $pdf->Cell(18);
    $CName = iconv('UTF-8', 'windows-1252', $sale['customerName']);
    $pdf->Cell(120, 4,$CName , 0, 1, 'L');
    $pdf->Cell(18);
    $CAddress = iconv('UTF-8', 'windows-1252',$sale['customerAddress'] . ' ' . $sale['aldea'] . ' ' . $sale['municipio'] . ' ' . $sale['departamento']);
    $pdf->MultiCell(90, 4,$CAddress , 0, 'L', 0);
    $pdf->Cell(18);
    $pdf->Cell(30, 4, $sale['customerTel'], 0, 1, 'L');
    $pdf->Cell(18);
    $pdf->Cell(30, 4, $sale['customerNit'], 0, 0, 'L');
    

    $pdf->Rect(111, 42, 99, 32);
    $pdf->Rect(111, 42, 50, 14);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(111, 44);
    $strL = iconv('UTF-8', 'windows-1252', 'Lugar, fecha de expedición:');
    $pdf->Cell(15, 4,$strL , 0, 1, 'L');
    $pdf->SetXY(111, 50);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(15, 4,  date_format($fechaS, 'd/m/Y'), 0, 1, 'L');
    $pdf->Rect(161, 42, 49, 14);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(161, 44);
    $pdf->Cell(15, 4, 'Vencimiento:' , 0, 1, 'L');
    $pdf->SetXY(161, 50);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(15, 4, date_format($fecha, 'd/m/Y') , 0, 1, 'L');
    $pdf->Rect(111, 56, 50, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(111, 58);
    $pdf->Cell(15, 4, 'Vendedor:' , 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(5);
    $pdf->Cell(15, 4, $sale['sellercode'] , 0, 0, 'L');
    $pdf->Rect(111, 65, 50, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(111, 67);
    $pdf->Cell(15, 4, 'Refer.:' , 0, 0, 'L');
    $pdf->Rect(161, 56, 49, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(161, 58);
    $pdf->Cell(15, 4, 'Condiciones:' , 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(9);
    $pdf->Cell(15, 4, $sale['paymentMethod'] , 0, 0, 'L');
    $pdf->Rect(161, 65, 49, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $envio = iconv('UTF-8', 'windows-1252', 'Envío:');
    $pdf->SetXY(161, 67);
    $pdf->Cell(15, 4, $envio , 0, 0, 'L');


//DETALLE DE FACTURA
    $pdf->SetXY(15, 75);
    $pdf->SetFont('Arial', 'B', 10);
    $codigo = iconv('UTF-8', 'windows-1252', 'Código Producto');
    $descrip = iconv('UTF-8', 'windows-1252', 'Descripción del producto');
    $pdf->Cell(30, 5, $codigo , 1, 0, 'L');
    $pdf->Cell(75, 5, $descrip , 1, 0, 'C');
    $pdf->Cell(18, 5, 'Cantidad' , 1, 0, 'L');
    $pdf->Cell(33, 5, 'Precio Unit.' , 1, 0, 'R');
    $pdf->Cell(40, 5, 'Subtotal Q.' , 1, 0, 'R');
    try {
        $sql = "SELECT D.quantity, TRUNCATE((D.priceS - D.discount) ,2) as precio,
    TRUNCATE((TRUNCATE((D.priceS - D.discount) ,2) * D.quantity) ,2) as total,
    (select productCode from product where idProduct = D._idProduct) as codigo,
    (select productName from product where idProduct = D._idProduct) as nombre
    from details D WHERE _idSale = $idSale";
        $resultado = $conn->query($sql);
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }
    $pdf->SetXY(0, 82);
    $pdf->SetFont('Arial', '', 10);
    $Contador = 82;
    while ($detailS = $resultado->fetch_assoc()) {
        $COD = iconv('UTF-8', 'windows-1252', $detailS['codigo']);
        $NOMBRE = iconv('UTF-8', 'windows-1252', $detailS['nombre']);
        $Contador = $Contador + 4;
        $pdf->Cell(15);
        $pdf->Cell(30, 4, $COD , 0, 0, 'L');
        $pdf->Cell(75, 4, $NOMBRE, 0, 0, 'L');
        $pdf->Cell(18, 4, $detailS['quantity'], 0, 0, 'R');
        $pdf->Cell(33, 4, 'Q.'.$detailS['precio'], 0, 0, 'R');
        $pdf->Cell(40, 4, $detailS['total'], 0, 1, 'R');
    }

    //TOTAL-LETRAS
    $pdf->SetXY(26, $Contador+ 10);
    $pdf->MultiCell(120, 5, $str, 0,'L',0);

    //TOTAL
    $pdf->SetXY(171, $Contador+ 10);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 5, 'TOTAL Q__'.$sale['totalSale'], 1, 0, 'C');

    //TOTAL-LETRAS
    $pdf->SetXY(26,  $Contador+ 15);
    $pdf->MultiCell(85, 5, 'SE ENTREGA LA OTRA VISITA', 0,'L',0);
}
$pdf->Output(); //Salida al navegador
