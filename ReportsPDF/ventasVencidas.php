<?php
include 'pdfclass/mpdf.php'; //Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

try {
    $sql = "SELECT
    	(select (select concat(codeRoute, ' ', routeName) from route where idRoute = _idRoute) as route from customer where idCustomer = S._idCustomer) as route,
    (select concat(sellerCode, ' ', sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer,
    S.idSale, S.noDeliver, S.advance, S.totalSale, S.dateStart, S.dateEnd, S.noShipment, S.type,
    DATEDIFF(curdate(), S.dateEnd) as days,
    CASE WHEN DATEDIFF(curdate(), S.dateEnd) > 29 AND DATEDIFF(curdate(), S.dateEnd) < 60 THEN
    (SELECT balance FROM balance where _idSale = S.idSale order by idBalance desc limit 1) END as mora30,
    CASE WHEN DATEDIFF(curdate(), S.dateEnd) > 59 AND DATEDIFF(curdate(), S.dateEnd) < 90 THEN     (SELECT balance FROM balance where _idSale = S.idSale order by idBalance desc limit 1) END as mora60,
    CASE WHEN DATEDIFF(curdate(), S.dateEnd) > 89 THEN
    (SELECT balance FROM balance where _idSale = S.idSale order by idBalance desc limit 1) END as mora90
    FROM sale S WHERE cancel = 0 AND state = 0 AND DATEDIFF(curdate(), S.dateEnd) > 29";

    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

$pagina = '
<!DOCTYPE html>
<html>
    <head>
        <title>Ventas vencidas</title>
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
                    <h3>Ventas vencidas con sus respectivas moras</h3>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Ruta</th>
                            <th style="background-color: #1d2128; color: white">Vendedor</th>
                            <th style="background-color: #1d2128; color: white">Cliente</th>
                            <th style="background-color: #1d2128; color: white">Remision No°</th>
                            <th style="background-color: #1d2128; color: white">Adelanto</th>
                            <th style="background-color: #1d2128; color: white">Total</th>
                            <th style="background-color: #1d2128; color: white">Fecha de Venta</th>
                            <th style="background-color: #1d2128; color: white">Fecha de Vencimiento</th>
                            <th style="background-color: #1d2128; color: white">Envío No°</th>
                            <th style="background-color: #1d2128; color: white">Días</th>
                            <th style="background-color: #1d2128; color: white">30 días</th>
                            <th style="background-color: #1d2128; color: white">60 días</th>
                            <th style="background-color: #1d2128; color: white">90 días</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
while ($sale = $resultado->fetch_assoc()) {
    if ($sale['type'] == 0) {
        $type = 'Dist.';
    } else {
        $type = 'Schl.';
    }
    $pagina .= '
                        <tr>
                            <td>' . $sale['route'] . '</td>
                            <td>' . $sale['seller'] . '</td>
                            <td>' . $sale['customer'] . '</td>
                            <td>' . $sale['noDeliver'] . ' ' . $type . '</td>
                            <td>' . $sale['advance'] . '</td>
                            <td>' . $sale['totalSale'] . '</td>
                            <td>' . $sale['dateStart'] . '</td>
                            <td>' . $sale['dateEnd'] . '</td>
                            <td>' . $sale['noShipment'] . '</td>
                            <td>' . $sale['days'] . '</th>
                            <td>' . $sale['mora30'] . '</td>
                            <td>' . $sale['mora60'] . '</td>
                            <td>' . $sale['mora90'] . '</td>
                        </tr>';
}
$pagina .= '</tbody>
                </table>
            </div>
        </div>
    </body>
</html>';

$file = "VentasporVendedor.pdf"; //Se nombra el archivo

$mpdf = new mPDF('utf-8', 'A4-L', 0, '', 10, 10, 10, 10, 0, 0); //se define el tamaño de pagina y los margenes
$mpdf->WriteHTML($pagina); //se escribe la variable pagina

$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador