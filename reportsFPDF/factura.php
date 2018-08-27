<?php
$idSale = $_GET['idSale'];
require('Libreria/fpdf.php');
 
class PDF extends FPDF
{
 
} // FIN Class PDF
 
$pdf = new PDF('P', 'mm', array(163,212));
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(0, 0 , 0);

#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,0);  
$str = iconv('UTF-8', 'windows-1252', 'Titleñ');
 
$pdf->AddPage();
$pdf->SetFont('Arial','',8);

$pdf->SetXY(20, 39);
//primera linea de factura
$pdf->Cell(50,3,'Quetzaltenango, guatemala',1,0,'L');
$pdf->Cell(15);
$pdf->Cell(9,3,'Vn01',1,0,'L');
$pdf->Cell(12);
$pdf->Cell(10,3,'C1023',1,0,'L');
$pdf->Cell(22);
$pdf->Cell(17,3,'27-08-2018',1,1,'L');

$pdf->SetXY(23, 45);
//Nombre
$pdf->Cell(120,3,'Luis Pedro Chaves Calderon',1,0,'L');

$pdf->SetXY(17, 51);
//NIT
$pdf->Cell(30,3,$idSale,1,0,'L');

$pdf->SetXY(25, 57);
//Direccion
$pdf->MultiCell(120,3,'Septima calle 31-25 zona 1, Quetzaltenango Guatemala Septima calle 31-25 zona 1, Quetzaltenango GuatemalaSeptima calle 31-25 zona 1, Quetzaltenango Guatemala',1,'L',0);

$pdf->SetXY(23, 73);
//Telefono
$pdf->Cell(30,3,'7377-2231',1,0,'L');

//DETALLE DE FACTURA
$pdf->SetXY(7, 81);
//Nombre
$pdf->Cell(17,4,'CANT',1,0,'L');
$pdf->Cell(15,4,'CODIGO',1,0,'L');
$pdf->Cell(69,4,'DESCRIPCION',1,0,'L');
$pdf->Cell(21,4,'P. UNITARIO',1,0,'L');
$pdf->Cell(28,4,'TOTAL Q.',1,0,'L');

//TOTAL
$pdf->SetXY(130, 195);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(28,5,'99,999.00',1,0,'L');
 
$pdf->Output(); //Salida al navegador
?>