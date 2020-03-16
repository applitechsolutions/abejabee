<?php
include 'pdfclass/mpdf.php'; //Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$fechainicio = strtr($_GET['fecha1'], '/', '-');
$fechafinal = strtr($_GET['fecha2'], '/', '-');
$idSeller = $_GET['idSeller'];
$typeS = $_GET['type'];

$fi = date('Y-m-d', strtotime($fechainicio));
$ff = date('Y-m-d', strtotime($fechafinal));

try {
    $sql = "SELECT B.*, S.noDeliver, (select CONCAT(sellerFirstName, ' ', sellerLastName) from seller where idSeller =
    S._idSeller) as seller FROM balance B INNER JOIN sale S ON B._idSale = S.idSale WHERE S.state = 0 AND B.state = 0
    AND B.balpay = 1
    AND S._idSeller = $idSeller AND S.type = $typeS AND B.date BETWEEN '$fi' AND '$ff' ORDER BY B.date ASC";

    $resultado = $conn->query($sql);
     $res = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($nombre = $res->fetch_assoc()) {
    $vendedor = $nombre['seller'];
    if ($nombre[type] == 0) {
        $type = 'Distribución';
    } else{
        $type = 'Schlenker';
    }
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
    $mensaje = 'Del ' . $dia1 . ' de ' . mes($mes1) . ' al ' . $dia2 . ' de ' . mes($mes2) . ' de ' . $year1;
} else {
    $mensaje = 'Del ' . $dia1 . ' de ' . mes($mes1) . ' del ' . $year1 . ' al ' . $dia2 . ' de ' . mes($mes2) . ' de ' . $year2;
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
                    <h3>Cobros realizados por ' . $vendedor . '</h3>
                    <h4>' . $mensaje . '</h4>
                    <h5>'. $type .'</h5>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">Remisión</th>
                            <th style="background-color: #1d2128; color: white">Documento</th>
                            <th style="background-color: #1d2128; color: white">Recibo</th>
                            <th style="background-color: #1d2128; color: white">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
$totalCobrado = 0;
while ($balance = $resultado->fetch_assoc()) {
    $date = date_create($balance['date']);
    $totalCobrado += $balance['amount'];
    $pagina .= '
                        <tr>
                            <td>' . date_format($date, 'd/m/y') . '</td>
                            <td>' . $balance['noDeliver'] . '</td>
                            <td>' . $balance['noDocument'] . '</td>
                            <td>' . $balance['noReceipt'] . '</td>
                            <td>Q. '.$balance['amount'].'</td>
                        </tr>';
}
$pagina .= '</tbody>
   <tfoot>
       <tr>
           <th></th>
           <th></th>
           <th style="text-align: right;" colspan="2">Total :</th>
           <td>Q. '. $totalCobrado .'</td>
       </tr>
   </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>';

$file = "CobrosPorVendedor.pdf"; //Se nombra el archivo

$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0); //se define el tamaño de pagina y los margenes
$mpdf->WriteHTML($pagina); //se escribe la variable pagina

$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador