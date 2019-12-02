<?php
include 'pdfclass/mpdf.php'; //Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$fecha1 = strtr($_GET['fecha1'], '/', '-');
$fecha2 = strtr($_GET['fecha2'], '/', '-');

$fi = date('Y-m-d', strtotime($fecha1));
$ff = date('Y-m-d', strtotime($fecha2));

try {
    $sql = "SELECT
    (select productCode from product where idProduct = _idProduct) as code,
    (select productName from product where idProduct = `_idProduct` ) as name,
    (select makeName from make where idMake = (select _idMake from product where idProduct = _idProduct)) as make,
    (select catName from category where idCategory = (select _idCategory from product where idProduct = _idProduct)) as category,
    (select unityName from unity where idUnity = (select _idUnity from product where idProduct = _idProduct)) as unity,
    (select description from product where idProduct = `_idProduct` ) as description,
    SUM(quantity) as ventas FROM `details` D INNER JOIN sale S ON D._idSale = S.idSale
    WHERE state = 0 AND (select state from product where idProduct = _idProduct) = 0 AND S.dateStart BETWEEN '$fi' AND '$ff'
    GROUP BY `_idProduct`ORDER BY SUM(quantity) DESC";

    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

// while ($nombre = $res->fetch_assoc()) {
//     $vendedor = $nombre['seller'];
//     $subtotal = $nombre['subtotal'];
//     $Total += $subtotal;
// }

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
                    <h3>Ventas por producto</h3>
                    <h4>' . $mensaje . '</h4>
                </div>
            </div>
            <div id="contenido">
                <h3>Ventas por Producto</h3>
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Código</th>
                            <th style="background-color: #1d2128; color: white">Producto</th>
                            <th style="background-color: #1d2128; color: white">Marca</th>
                            <th style="background-color: #1d2128; color: white">Categoría</th>
                            <th style="background-color: #1d2128; color: white">Unidad</th>
                            <th style="background-color: #1d2128; color: white">Descripción</th>
                            <th style="background-color: #1d2128; color: white">Ventas</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
while ($product = $resultado->fetch_assoc()) {
    $dateStar = date_create($sale['dateStart']);
    $pagina .= '
                        <tr>
                            <td>' . $product['code'] . '</td>
                            <td>' . $product['name'] . '</td>
                            <td>' . $product['make'] . '</td>
                            <td>' . $product['category'] . '</td>
                            <td>' . $product['unity'] . '</td>
                            <td>' . $product['description'] . '</td>
                            <td>' . $product['ventas'] . '</td>
                        </tr>';
}
$pagina .= '</tbody>
                </table>
            </div>
        </div>
    </body>
</html>';

$file = "VentasporProducto.pdf"; //Se nombra el archivo

$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0); //se define el tamaño de pagina y los margenes
$mpdf->WriteHTML($pagina); //se escribe la variable pagina

$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador