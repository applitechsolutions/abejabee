<?php
include ('pdfclass/mpdf.php');//Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$idVendedor = $_GET['idVendedor'];
$fecha1 = $_GET['fecha1'];
$fecha2 = $_GET['fecha2'];

$fi = date('Y-m-d', strtotime($fecha1));
$ff = date('Y-m-d', strtotime($fecha2));

echo $fecha1;

try{
    $sql = "SELECT S.*,
    (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
    (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) as fechapago,
    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer
    FROM sale S WHERE S.cancel = 1 AND S._idSeller = $idVendedor AND (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) BETWEEN '$fi' AND '$ff'";

    $resultado = $conn->query($sql);
    $res = $conn->query($sql);
} catch (Exception $e){
    $error= $e->getMessage();
    echo $error;
}

while ($nombre = $res->fetch_assoc()) {
    $vendedor = $nombre['seller'];
}


$dia1 = strftime("%d", strtotime($fecha1));
$mes1 = strftime("%B", strtotime($fecha1));
$year1 = strftime("%Y", strtotime($fecha1));
$dia2 = strftime("%d", strtotime($fecha2));
$mes2 = strftime("%B", strtotime($fecha2));
$year2 = strftime("%Y", strtotime($fecha2));

function mes($mes){
    if ($mes == 'January') {
        $mes = 'enero';
    } else if ($mes == 'February') {
        $mes = 'febrero';
    } else if ($mes == 'March') {
        $mes = 'marzo';
    } else if ($mes == 'April') {
        $mes = 'abril';
    } else if ($mes == 'May') {
        $mes = 'mayo';
    } else if ($mes == 'June') {
        $mes = 'junio';
    } else if ($mes == 'July') {
        $mes = 'julio';
    } else if ($mes == 'August') {
        $mes = 'agosto';
    } else if ($mes == 'September') {
        $mes = 'septiembre';
    } else if ($mes == 'October') {
        $mes = 'octubre';
    } else if ($mes == 'November') {
        $mes = 'noviembre';
    } else if ($mes == 'December') {
        $mes = 'diciembre';
    }

    return $mes;
}

if ($year1 == $year2) {
    $mensaje = 'Del '.$dia1.' de '.mes($mes1).' al '.$dia2.' de '.mes($mes2).' del '.$year1;
} else $mensaje = 'Del '.$dia1.' de '.mes($mes1).' del '.$year1.' al '.$dia2.' de '.mes($mes2).' del '.$year2;


$pagina='
<!DOCTYPE html>
<html>
    <head>
        <title>NOMBRE DEL REPORTE</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body class="w3-padding">
        <div class="w3-container">
            <div id="Encabezado">
                <div class="login-logo w3-center w3-light-grey w3-round-medium">
                    <div class="image">
                    <img src="../img/Schlenker.jpeg" class="w3-round-medium" alt="Login Image">
                    </div>      
                </div>
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> Schlenker, Pharma.
                        <small class="pull-right w3-right">Fecha: '.date("d/m/Y").'</small>
                    </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <div style="text-align: center;">
                    <h3>Ventas realizadas por '. $vendedor .'</h3>
                    <h4>'.$mensaje.'</h4>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">Factura No°</th>
                            <th style="background-color: #1d2128; color: white">Cliente</th>
                            <th style="background-color: #1d2128; color: white">Fecha de vencimiento</th>
                            <th style="background-color: #1d2128; color: white">Método de pago</th>
                            <th style="background-color: #1d2128; color: white">Envío No°</th>
                            <th style="background-color: #1d2128; color: white">Anticipo</th>
                            <th style="background-color: #1d2128; color: white">Total</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
            while ($sale = $resultado->fetch_assoc()) {
                $pagina.='
                        <tr>
                            <td>'.$sale['dateStart'].'</td>
                            <td><small class="w3-deep-orange">Factura No°</small><br><small>'.$sale['serie'].' '.$sale['noBill'].'</small><br><small class="w3-indigo">Remision No°</small><br><small>'.$sale['noDeliver'].'</small></td>
                            <td>'.$sale['customer'].'</td>
                            <td>'.$sale['dateEnd'].'</td>
                            <td>'.$sale['paymentMethod'].'</td>
                            <td>'.$sale['noShipment'].'</td>
                            <td>'.$sale['advance'].'</td>
                            <td>'.$sale['totalSale'].'</td>
                        </tr>';
                    }
        $pagina .= '</tbody>
                </table>
            </div>
        </div>
    </body>
</html>';

    

    $file = "VentasporVendedor.pdf"; //Se nombra el archivo

    $mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0);//se define el tamaño de pagina y los margenes
    $mpdf->WriteHTML($pagina); //se escribe la variable pagina

    $mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador
?>