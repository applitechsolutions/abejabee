<?php
$idSale = $_GET['idSale'];
require 'Libreria/fpdf.php';
require "NumeroALetras.php";
include_once '../funciones/bd_conexion.php';

class PDF extends FPDF
{

} // FIN Class PDF

try {
    $sql = "SELECT dateStart, dateEnd, totalSale, noDeliver, paymentMethod, note, type,
                    (select sellerCode from seller where idSeller = S._idSeller) as sellercode,
                    (select CONCAT(sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as sellername,
                    (select sellerMobile from seller where idSeller = S._idSeller) as sellermobile,
                    (select name from town where idTown = C._idTown) as municipio,
                    (select name from village where idVillage = C._idVillage) as aldea,
                    (select name from deparment where idDeparment = C._idDeparment) as departamento,
                    C.customerCode, C.customerName, C.customerNit, C.customerAddress, C.customerTel, C.inCharge
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
    $str = iconv('UTF-8', 'windows-1252', NumeroALetras::convertir($sale['totalSale'], 'QUETZALES', 'CENTAVOS'));

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->SetXY(140, 20);
    $pdf->Cell(60, 10, 'GUIA DE REMISION', 1, 1, 'C');
    $pdf->SetXY(140, 30);
    if ($sale['type'] == 0) {
        $pdf->Cell(60, 10, $sale['noDeliver'] . ' Dist.', 1, 1, 'C');
    } else {
        $pdf->Cell(60, 10, $sale['noDeliver'] . ' Schl.', 1, 1, 'C');
    }

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Rect(10, 42, 90, 45);
    $pdf->SetXY(13, 44);
    $pdf->Cell(15, 4, 'Cliente:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $Ccode = iconv('UTF-8', 'windows-1252', $sale['customerCode']);
    $CName = iconv('UTF-8', 'windows-1252', $sale['customerName']);
    $CinCharge = iconv('UTF-8', 'windows-1252', $sale['inCharge']);
    $pdf->Cell(10, 4, $Ccode, 0, 1, 'L');
    $pdf->Cell(13);
    $pdf->Cell(120, 4, $CName, 0, 1, 'L');
    $pdf->Cell(13);
    $pdf->Cell(120, 4, $CinCharge, 0, 1, 'L');
    $pdf->Cell(13);
    $CAddress = iconv('UTF-8', 'windows-1252', $sale['customerAddress'] . ' ' . $sale['aldea'] . ' ' . $sale['municipio'] . ' ' . $sale['departamento']);
    $pdf->MultiCell(90, 4, $CAddress, 0, 'L', 0);
    $pdf->Cell(13);
    $pdf->Cell(30, 4, $sale['customerTel'], 0, 1, 'L');
    $pdf->Cell(13);
    $pdf->Cell(30, 4, $sale['customerNit'], 0, 0, 'L');

    $pdf->Rect(101, 42, 99, 45);
    $pdf->Rect(101, 42, 50, 14);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(101, 44);
    $strL = iconv('UTF-8', 'windows-1252', 'Lugar, fecha de expedición:');
    $pdf->Cell(15, 4, $strL, 0, 1, 'L');
    $pdf->SetXY(101, 50);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(15, 4, date_format($fechaS, 'd/m/Y'), 0, 1, 'L');
    $pdf->Rect(151, 42, 49, 14);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(151, 44);
    $pdf->Cell(15, 4, 'Vencimiento:', 0, 1, 'L');
    $pdf->SetXY(151, 50);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(15, 4, date_format($fecha, 'd/m/Y'), 0, 1, 'L');
    // $pdf->Rect(101, 56, 50, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(101, 58);
    $pdf->Cell(15, 4, 'Vendedor:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(5);
    $sellerC = iconv('UTF-8', 'windows-1252', $sale['sellercode']);
    $sellerN = iconv('UTF-8', 'windows-1252', $sale['sellername']);
    $pdf->Cell(15, 4, $sellerC, 0, 0, 'L');
    // $pdf->Rect(101, 65, 50, 9);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(101, 64);
    $pdf->Cell(15, 4, $sellerN, 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(101, 70);
    $pdf->Cell(15, 4, $sale['sellermobile'], 0, 0, 'L');
    $pdf->Rect(151, 56, 49, 9);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(151, 58);
    $pdf->Cell(15, 4, 'Condiciones:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $payment = iconv('UTF-8', 'windows-1252', $sale['paymentMethod']);
    $pdf->Cell(9);
    $pdf->Cell(15, 4, $payment, 0, 0, 'L');
    // $pdf->Rect(151, 65, 49, 9);
    // $pdf->SetFont('Arial', 'B', 10);
    // $envio = iconv('UTF-8', 'windows-1252', 'Envío:');
    // $pdf->SetXY(151, 67);
    // $pdf->Cell(15, 4, $envio, 0, 0, 'L');

//DETALLE DE FACTURA
    $pdf->SetXY(10, 90);
    $pdf->SetFont('Arial', 'B', 10);
    $codigo = iconv('UTF-8', 'windows-1252', 'Código Producto');
    $descrip = iconv('UTF-8', 'windows-1252', 'Descripción del producto');
    $pdf->Cell(30, 5, $codigo, 1, 0, 'L');
    $pdf->Cell(75, 5, $descrip, 1, 0, 'C');
    $pdf->Cell(18, 5, 'Cantidad', 1, 0, 'L');
    $pdf->Cell(33, 5, 'Precio Unit.', 1, 0, 'R');
    $pdf->Cell(34, 5, 'Subtotal Q.', 1, 0, 'R');
    try {
        $sql = "SELECT D.quantity, TRUNCATE((D.priceS - D.discount) ,2) as precio,
    TRUNCATE((TRUNCATE((D.priceS - D.discount) ,2) * D.quantity) ,2) as total,
    (select productCode from product where idProduct = D._idProduct) as codigo,
    (select productName from product where idProduct = D._idProduct) as nombre,
    (select catName from category where idCategory = (select _idCategory from product where idProduct = D._idProduct)) as categoria,
    (select makeName from make where idMake = (select _idMake from product where idProduct = D._idProduct)) as marca,
    (select description from product where idProduct = D._idProduct) as descripcion
    from details D WHERE _idSale = $idSale";
        $resultado = $conn->query($sql);
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }
    $pdf->SetXY(0, 97);
    $pdf->SetFont('Arial', '', 10);
    $Contador = 95;
    while ($detailS = $resultado->fetch_assoc()) {
        $COD = iconv('UTF-8', 'windows-1252', $detailS['codigo']);
        $NOMBRE = iconv('UTF-8', 'windows-1252', $detailS['nombre']);
        $CATEGORIA = iconv('UTF-8', 'windows-1252', $detailS['categoria']);
        $DESC = iconv('UTF-8', 'windows-1252', $detailS['descripcion']);
        $Contador = $Contador + 4;
        $pdf->Cell(10);
        $pdf->Cell(30, 4, $COD, 0, 0, 'L');
        if ($detailS['marca'] == 'SCHLENKER') {
            $pdf->Cell(75, 4, $DESC, 0, 0, 'L');
        } else {
            $pdf->Cell(75, 4, $NOMBRE . ' ' . $CATEGORIA, 0, 0, 'L');
        }
        $pdf->Cell(18, 4, $detailS['quantity'], 0, 0, 'R');
        $pdf->Cell(33, 4, 'Q.' . $detailS['precio'], 0, 0, 'R');
        $pdf->Cell(34, 4, $detailS['total'], 0, 1, 'R');
    }

    //TOTAL
    $pdf->SetXY(161, $Contador + 10);
    $pdf->Cell(40, 5, 'TOTAL Q__' . $sale['totalSale'], 1, 0, 'C');

    //TOTAL-LETRAS
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(10, $Contador + 10);
    $pdf->MultiCell(150, 5, $str, 0, 'L', 0);

    //TOTAL-LETRAS
    $note = iconv('UTF-8', 'windows-1252', $sale['note']);
    $pdf->SetXY(10, $Contador + 20);
    $pdf->MultiCell(85, 5, $note, 1, 'L', 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(136, 0, 27);
    $pdf->SetXY(10, $Contador + 28);
    $nota = 'No se aceptaran reclamos por producto dañado o incompleto despues de 3 dias de haber recibido su pedido. En el momento que reciba su pedido revisar que este completo, de no ser asi, tomar fotografia y enviarla a su visitador para informarle y poder darle la solucion respectiva.';
    $pdf->MultiCell(190, 5, iconv('UTF-8', 'windows-1252', $nota), 0, 'C', 0);
}
$pdf->Output(); //Salida al navegador