<?php
include 'pdfclass/mpdf.php'; //Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$idRoute = $_GET['idDepartamento'];

try {
    $sql = "SELECT idCustomer, customerCode, customerName, customerTel,
    (SELECT routeName FROM route WHERE idRoute = C._idRoute) as depName, S.serie, S.noBill, S.noDeliver, S.dateStart,
    (SELECT balance FROM balance WHERE _idSale = idSale ORDER BY idBalance DESC LIMIT 1) AS saldo,
    (SELECT SUM(amount) FROM balance WHERE _idSale = idSale AND cheque = 1 AND state = 1) AS abono
    FROM customer C INNER JOIN sale S ON C.idCustomer = S._idCustomer
    WHERE _idRoute = $idRoute AND S.cancel = 0 AND S.state = 0 ORDER BY C.idCustomer ASC";

    $sql2 = "SELECT S.serie, S.noBill, S.noDeliver, B.noDocument, B.date, B.amount, B.noReceipt, B.balance
FROM customer C INNER JOIN sale S ON C.idCustomer = S._idCustomer INNER JOIN balance B ON S.idSale = B._idSale
WHERE _idRoute = $idRoute AND S.cancel = 0 AND S.state = 0 AND B.cheque = 1 AND B.state = 1 ORDER BY C.idCustomer ASC";

    $resultado = $conn->query($sql);
    $resultadoCheques = $conn->query($sql2);
    $res = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($nombre = $res->fetch_assoc()) {
    $depart = $nombre['depName'];
}

$pagina = '
<!DOCTYPE html>
<html>
    <head>
        <title>Clientes Por Ruta</title>
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
                    <h3>Clientes de ' . $depart . '</h3>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Código</th>
                            <th style="background-color: #1d2128; color: white">Nombre</th>
                            <th style="background-color: #1d2128; color: white">Télefono</th>
                            <th style="background-color: #1d2128; color: white">Documento</th>
                            <th style="background-color: #1d2128; color: white">Fecha de inicio</th>
                            <th style="background-color: #1d2128; color: white">Saldo</th>
                            <th style="background-color: #1d2128; color: white">Abonos con cheque</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
while ($cliente = $resultado->fetch_assoc()) {
    $dateStart = date_create($cliente['dateStart']);
    if ($cliente['abono'] == null) {
        $abono = '0.00';
        $saldo = $cliente['saldo'];
    } else {
        $abono = $cliente['abono'];
        $saldo = $cliente['saldo'] - $cliente['abono'];
    }
    $pagina .= '
                        <tr>
                            <td>' . $cliente['customerCode'] . '</td>
                            <td>' . $cliente['customerName'] . '</td>
                            <td>' . $cliente['customerTel'] . '</td>
                            <td><small class="w3-deep-orange">Factura No°</small><br><small>' . $cliente['serie'] . ' ' . $cliente['noBill'] . '</small><br><small class="w3-indigo">Remision No°</small><br><small>' . $cliente['noDeliver'] . '</small></td>
                            <td>' . date_format($dateStart, 'd/m/y') . '</td>
                            <td>' . 'Q.' . $cliente['saldo'] . '</td>
                            <td><small class="w3-text-gray">Abono: </small><br><small>' . 'Q.' . $abono . '</small><br><small class="w3-text-green">Saldo: </small><br><small>' . 'Q.' . number_format($saldo, 2, '.', ',') . '</small></td>
                        </tr>';
}
$pagina .= '</tbody>
                </table>
            </div>
            <div>
                <h3>Detalles de abonos con cheques</h3>
            </div>
            <div id="contenido2">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Factura/Remision</th>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">Documento</th>
                            <th style="background-color: #1d2128; color: white">Recibo</th>
                            <th style="background-color: #1d2128; color: white">Monto</th>
                            <th style="background-color: #1d2128; color: white">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
while ($cheque = $resultadoCheques->fetch_assoc()) {
    $date = date_create($cheque['date']);
    $pagina .= '
                        <tr>
                            <td><small class="w3-deep-orange">Factura No°</small><br><small>' . $cheque['serie'] . ' ' . $cheque['noBill'] . '</small><br><small class="w3-indigo">Remision No°</small><br><small>' . $cheque['noDeliver'] . '</small></td>
                            <td>' . date_format($date, 'd/m/y') . '</td>
                            <td>' . $cheque['noDocument'] . '</td>
                            <td>' . $cheque['noReceipt'] . '</td>
                            <td>Q.' . $cheque['amount'] . '</td>
                            <td>Q. ' . $cheque['balance'] . '</td>
                        </tr>';
}
$pagina .= '</tbody>
                </table>
            </div>
        </div>
    </body>
</html>';

$file = "ClientesporDepartamento.pdf"; //Se nombra el archivo

$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0); //se define el tamaño de pagina y los margenes
$mpdf->WriteHTML($pagina); //se escribe la variable pagina

$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador