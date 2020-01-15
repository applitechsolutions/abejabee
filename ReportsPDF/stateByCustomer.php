<?php
include 'pdfclass/mpdf.php'; //Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$idCustomer = $_GET['idCustomer'];

try {
    $sql = "SELECT idCustomer, customerCode, customerName, customerTel, customerNit, customerAddress, owner, inCharge,
    (SELECT name FROM deparment where idDeparment = C._idDeparment) as deparment,
    (SELECT routeName FROM route WHERE idRoute = C._idRoute) as route, S.noDeliver, S.dateStart, S.advance, S.dateEnd, S.type, S.cancel, S.totalSale,
    (SELECT concat(sellerFirstName, ' ', sellerLastName) FROM seller where idSeller = S._idSeller) as seller,
    (SELECT balance FROM balance WHERE _idSale = idSale AND state != 2 ORDER BY idBalance DESC LIMIT 1) AS saldo,
    (SELECT SUM(amount) FROM balance WHERE _idSale = idSale AND cheque = 1 AND state = 1) AS abono
    FROM customer C INNER JOIN sale S ON C.idCustomer = S._idCustomer
    WHERE C.idCustomer = $idCustomer AND S.state = 0 ORDER BY S.dateStart DESC";

    $resultado = $conn->query($sql);
    $res = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($customer = $res->fetch_assoc()) {
    $codeName = $customer['customerCode'] . ' ' . $customer['customerName'];
    $route = $customer['route'];
    $telNit = $customer['customerTel'] . ' ' . $customer['customerNit'];
    $direccion = $customer['customerAddress'] . ' ' . $customer['deparment'];
    $owner = $customer['owner'] . ' ' . $customer['inCharge'];
}

$pagina = '
<!DOCTYPE html>
<html>
    <head>
        <title>Estado de cuenta</title>
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
                <div style="text-align: left;">
                    <h4>Cliente: ' . $codeName . '</h4>
                    <p>Ruta: ' . $route . '</p>
                    <p>Teléfono / Nit: ' . $telNit . '</p>
                    <p>Dirección: ' . $direccion . '</p>
                    <p>Dueño / Encargado: ' . $owner . '</p>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">No. de remisión</th>
                            <th style="background-color: #1d2128; color: white">Vendedor</th>
                            <th style="background-color: #1d2128; color: white">Fecha de vencimiento</th>
                            <th style="background-color: #1d2128; color: white">Anticipo</th>
                            <th style="background-color: #1d2128; color: white">Total</th>
                            <th style="background-color: #1d2128; color: white">Abono</th>
                            <th style="background-color: #1d2128; color: white">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
while ($cliente = $resultado->fetch_assoc()) {
    $dateStart = date_create($cliente['dateStart']);
    $dateEnd = date_create($cliente['dateEnd']);
    if ($cliente['abono'] == null) {
        $abono = '0.00';
        $saldo = $cliente['saldo'];
    } else {
        $abono = $cliente['abono'];
        $saldo = $cliente['saldo'] - $cliente['abono'];
    }
    if ($cliente['type'] == 0) {
        $type = 'Dist.';
    } else {
        $type = 'Schl.';
    }
    $pagina .= '
                        <tr>
                        <td>' . date_format($dateStart, 'd/m/y') . '</td>
                        <td>' . $cliente['noDeliver'] . ' ' . $type . '</td>
                        <td>' . $cliente['seller'] . '</td>
                        <td>' . date_format($dateEnd, 'd/m/y') . '</td>
                        <td>' . 'Q.' . $cliente['advance'] . '</td>
                        <td>' . 'Q.' . $cliente['totalSale'] . '</td>
                        <td>' . 'Q.' . $abono . '</td>
                        <td>' . 'Q.' . number_format($saldo, 2, '.', ',') . '</td>
                        </tr>';
}
$pagina .= '</tbody>
                </table>
            </div>
        </div>
    </body>
</html>';

$file = "EstadodeCuenta.pdf"; //Se nombra el archivo

$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0); //se define el tamaño de pagina y los margenes
$mpdf->WriteHTML($pagina); //se escribe la variable pagina

$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador