<?php
include 'pdfclass/mpdf.php'; //Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML
$product = $_GET['idProducto'];
$fecha1 = strtr($_GET['fecha1'], '/', '-');

$fi = date('Y-m-d', strtotime($fecha1));

try {
    $sqlC = "SELECT P.datePurchase, (select providerName from provider where idProvider = P._idProvider) as provider,
    P.noBill, P.serie, noDocument, D.costP, D.quantity
    FROM `detailp` D INNER JOIN purchase P ON D._idPurchase = p.idPurchase where D._idProduct = $product AND P.datePurchase >= '$fi'";

    $sqlV = "SELECT S.dateStart, S.noBill, S.serie, S.noDeliver, S.note, (D.priceS - D.discount) as price, D.quantity, 
    (select stock from storage WHERE _idProduct = D._idProduct) as stock
    FROM `details` D INNER JOIN sale S ON D._idSale = S.idSale WHERE D._idProduct = $product AND S.dateStart >= '$fi' AND S.state = 0";

    $resultadoC = $conn->query($sqlC);
    $resultadoV = $conn->query($sqlV);
    $res = $conn->query($sqlV);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($stock = $res->fetch_assoc()) {
    $existencia = $stock['stock'];
}

$dia1 = strftime("%d", strtotime($fi));
$mes1 = strftime("%B", strtotime($fi));
$year1 = strftime("%Y", strtotime($fi));

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

$mensaje = $dia1 . ' de ' . mes($mes1) . ' del ' . $year1; 


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
                <div>
                    <h3 style="text-align: left;">Listado de Compras y Ventas en la fecha: <h4>' . $mensaje . '</h4></h3>
                    <h3 style="text-align: right;">Existencia Actual: ' . $existencia . '</h3>
                </div>
                <div>
                    
                </div>
            </div>
            <div>
                <h3>COMPRAS</h3>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">Proveedor</th>
                            <th style="background-color: #1d2128; color: white">Factura</th>
                            <th style="background-color: #1d2128; color: white">Serie</th>
                            <th style="background-color: #1d2128; color: white">No. Documento</th>
                            <th style="background-color: #1d2128; color: white">Costo</th>
                            <th style="background-color: #1d2128; color: white">Total</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
while ($stockC = $resultadoC->fetch_assoc()) {
    $dateP = date_create($stockC['datePurchase']);
    $totalC = $totalC + $stockC['quantity'];
    $pagina .= '
                        <tr>
                            <td>' . date_format($dateP, 'd/m/y') . '</td>
                            <td>' . $stockC['provider'] . '</td>
                            <td>' . $stockC['noBill'] . '</td>
                            <td>' . $stockC['serie'] . '</td>
                            <td>' . $stockC['noDocument'] . '</td>
                            <td>Q. ' . $stockC['costP'] . '</td>
                            <td>' . $stockC['quantity'] . '</td>
                        </tr>';
}
        $pagina .= '</tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;" colspan="2">Total comprado:</th>
                            <td><small>' . $totalC . '</small></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                <h3>VENTAS</h3>
            </div>
            <div id="contenido2">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">Factura</th>
                            <th style="background-color: #1d2128; color: white">Remisión</th>
                            <th style="background-color: #1d2128; color: white">Detalles</th>
                            <th style="background-color: #1d2128; color: white">Precio</th>
                            <th style="background-color: #1d2128; color: white">Total</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
while ($stockV = $resultadoV->fetch_assoc()) {
    $dateS = date_create($stockV['dateStart']);
    $totalV = $totalV + $stockV['quantity'];
    $pagina .= '
                        <tr>
                            <td>' . date_format($dateS, 'd/m/y') . '</td>
                            <td>' . $stockV['serie'] . ' ' . $stockV['noBill'] . '</td>
                            <td>' . $stockV['noDeliver'] . '</td>
                            <td>' . $stockV['note'] . '</td>
                            <td>Q. ' . $stockV['price'] . '</td>
                            <td>' . $stockV['quantity'] . '</td>
                        </tr>';
}
        $pagina .= '</tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;" colspan="2">Total vendido:</th>
                            <td><small>' . $totalV . '</small></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>';

$file = "InventarioporFecha.pdf"; //Se nombra el archivo

$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0); //se define el tamaño de pagina y los margenes
$mpdf->WriteHTML($pagina); //se escribe la variable pagina

$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador

?>