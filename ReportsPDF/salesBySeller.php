<?php
include 'pdfclass/mpdf.php'; //Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$idVendedor = $_GET['idVendedor'];
$fecha1 = strtr($_GET['fecha1'], '/', '-');
$fecha2 = strtr($_GET['fecha2'], '/', '-');

$fi = date('Y-m-d', strtotime($fecha1));
$ff = date('Y-m-d', strtotime($fecha2));

try {
    $sql = "SELECT S.dateStart, S.noDeliver, S.type, B.noDocument, B.date, B.amount, B.noReceipt, B.totalS, B.totalO, (SELECT concat(sellerFirstName, ' ', sellerLastName) FROM seller WHERE idSeller = S._idSeller) as seller
    FROM sale S INNER JOIN balance B ON S.idSale = B._idSale WHERE S.state = 0 AND B.balpay = 1 AND B.state = 0 AND
    B.date BETWEEN '$fi' AND '$ff' AND S._idSeller = $idVendedor ORDER BY B.date ASC;";

    $resultado = $conn->query($sql);
    $res = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

try {
    $sql = "SELECT S.dateStart, S.noDeliver, S.type, B.noDocument, B.date, B.amount, B.noReceipt, B.totalS, B.totalO, (SELECT concat(sellerFirstName, ' ', sellerLastName) FROM seller WHERE idSeller = S._idSeller) as seller
    FROM sale S INNER JOIN balance B ON S.idSale = B._idSale WHERE S.state = 0 AND B.balpay = 1 AND B.state = 0 AND
    B.date BETWEEN '$fi' AND '$ff' AND B._idSeller = $idVendedor ORDER BY B.date ASC;";

    $resultado2 = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($nombre = $res->fetch_assoc()) {
    $vendedor = $nombre['seller'];
}

$dia1 = strftime("%d", strtotime($fi));
$mes1 = strftime("%B", strtotime($fi));
$year1 = strftime("%Y", strtotime($fi));
$dia2 = strftime("%d", strtotime($ff));
$mes2 = strftime("%B", strtotime($ff));
$year2 = strftime("%Y", strtotime($ff));

function mes($mes)
{
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
    $mensaje = 'Del ' . $dia1 . ' de ' . mes($mes1) . ' al ' . $dia2 . ' de ' . mes($mes2) . ' del ' . $year1;
} else {
    $mensaje = 'Del ' . $dia1 . ' de ' . mes($mes1) . ' del ' . $year1 . ' al ' . $dia2 . ' de ' . mes($mes2) . ' del ' . $year2;
}

$pagina = '
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
                        <small class="pull-right w3-right">Fecha: ' . date("d/m/Y") . '</small>
                    </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <div style="text-align: center;">
                    <h3>Ventas realizadas por ' . $vendedor . '</h3>
                    <h4>' . $mensaje . '</h4>
                </div>
            </div>
            <div id="contenido">
                                                                    <h5>Comisiones por cobros</h5>
                                                        <h6>Funciona a partir del 24/06/2020</h6>
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">Remision No°</th>
                            <th style="background-color: #1d2128; color: white">Fecha de pago</th>
                            <th style="background-color: #1d2128; color: white">Recibo</th>
                            <th style="background-color: #1d2128; color: white">Documento No°</th>
                            <th style="background-color: #1d2128; color: white">Monto</th>
                            <th style="background-color: #1d2128; color: white">Comisión SCH</th>
                            <th style="background-color: #1d2128; color: white">Comisión Distribución</th>
                            <th style="background-color: #1d2128; color: white">Comisión</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
$totalComision = 0;
while ($sale = $resultado2->fetch_assoc()) {
    $subtotal = $sale['totalS'] + $sale['totalO'];
    $totalComision = $totalComision + $subtotal;
    $dateStar = date_create($sale['dateStart']);
    $fechapago = date_create($sale['date']);
    if ($sale['type'] == 0) {
        $type = 'Dist.';
    } else {
        $type = 'Schl.';
    }
    $pagina .= '
                        <tr>
                            <td>' . date_format($dateStar, 'd/m/y') . '</td>
                            <td>' . $sale['noDeliver'] . ' ' . $type . '</td>
                            <td>' . date_format($fechapago, 'd/m/y') . '</td>
                            <td>' . $sale['noReceipt'] . '</td>
                            <td>' . $sale['noDocument'] . '</td>
                            <td>Q.' . $sale['amount'] . '</td>
                            <td>Q. ' . $sale['totalS'] . '</td>
                            <td>Q. ' . $sale['totalO'] . '</td>
                            <td>Q. ' . number_format($subtotal, 2, '.', ',') . '</td>
                        </tr>';
}
$pagina .= '</tbody>
                    <tfoot>
                        <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right;" colspan="2">Total Comisiones :</th>
                        <td>Q. <small>' . number_format($totalComision, 2, '.', ',') . '</small></td>
                        </tr>
                    </tfoot>
                    </table>
                    <hr>
                <h5>Comisiones génerales</h5>
                <h6>Funciona antes del 24/06/2020</h6>
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">Remision No°</th>
                            <th style="background-color: #1d2128; color: white">Fecha de pago</th>
                            <th style="background-color: #1d2128; color: white">Recibo</th>
                            <th style="background-color: #1d2128; color: white">Documento No°</th>
                            <th style="background-color: #1d2128; color: white">Monto</th>
                            <th style="background-color: #1d2128; color: white">Comisión SCH</th>
                            <th style="background-color: #1d2128; color: white">Comisión Distribución</th>
                            <th style="background-color: #1d2128; color: white">Comisión</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
$totalComision = 0;
while ($sale = $resultado->fetch_assoc()) {
    $subtotal = $sale['totalS'] + $sale['totalO'];
    $totalComision = $totalComision + $subtotal;
    $dateStar = date_create($sale['dateStart']);
    $fechapago = date_create($sale['date']);
    if ($sale['type'] == 0) {
        $type = 'Dist.';
    } else {
        $type = 'Schl.';
    }
    $pagina .= '
                        <tr>
                            <td>' . date_format($dateStar, 'd/m/y') . '</td>
                            <td>' . $sale['noDeliver'] . ' ' . $type . '</td>
                            <td>' . date_format($fechapago, 'd/m/y') . '</td>
                            <td>' . $sale['noReceipt'] . '</td>
                            <td>' . $sale['noDocument'] . '</td>
                            <td>Q.' . $sale['amount'] . '</td>
                            <td>Q. ' . $sale['totalS'] . '</td>
                            <td>Q. ' . $sale['totalO'] . '</td>
                            <td>Q. ' . number_format($subtotal, 2, '.', ',') . '</td>
                        </tr>';
}
$pagina .= '</tbody>
                    <tfoot>
                        <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right;" colspan="2">Total Comisiones :</th>
                        <td>Q. <small>' . number_format($totalComision, 2, '.', ',') . '</small></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>';

$file = "VentasporVendedor.pdf"; //Se nombra el archivo

$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0); //se define el tamaño de pagina y los margenes
$mpdf->WriteHTML($pagina); //se escribe la variable pagina

$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador