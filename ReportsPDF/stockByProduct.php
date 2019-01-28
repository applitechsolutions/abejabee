<?php
include 'pdfclass/mpdf.php'; //Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML
$fecha1 = strtr($_GET['fecha1'], '/', '-');

$fi = date('Y-m-d', strtotime($fecha1));

try {
    $sql = "SELECT P.idProduct, P.productName, P.productCode, P.cost, P.minStock, P.picture, S.stock,
    (select SUM(quantity) from detailP DP INNER JOIN purchase PU ON DP._idPurchase = PU.idPurchase where _idProduct = P.idProduct AND PU.datePurchase > '2019-01-01' AND PU.datePurchase <= CURDATE()) as compras,
    (select SUM(quantity) from detailS DS INNER JOIN sale S ON DS._idSale = S.idSale where _idProduct = P.idProduct AND S.dateStart > '$fi' AND S.dateStart <= CURDATE() AND state = 0) as ventas,
    (select makeName from make where idMake = P._idMake and state = 0) as make,
    (select catName from category where idCategory = P._idCategory and state = 0) as category,
    (select unityName from unity where idUnity = P._idUnity and state = 0) as unity
    FROM storage S INNER JOIN product P ON P.idProduct = S._idProduct WHERE P.state = 0 ORDER BY P.productCode";

    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
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
                <div style="text-align: center;">
                    <h3>Listado de Inventario en la fecha: </h3>
                    <h4>' . $mensaje . '</h4>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Código</th>
                            <th style="background-color: #1d2128; color: white">Nombre</th>
                            <th style="background-color: #1d2128; color: white">Marca</th>
                            <th style="background-color: #1d2128; color: white">Categoría</th>
                            <th style="background-color: #1d2128; color: white">Unidad</th>
                            <th style="background-color: #1d2128; color: white">Costo</th>
                            <th style="background-color: #1d2128; color: white">Existencia</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
while ($stock = $resultado->fetch_assoc()) {
    if ($stock['ventas'] != null && $stock['compras'] != null) {
        $inv = $stock['stock'] + $stock['ventas'] - $stock['compras'];
    } else if ($stock['ventas'] != null && $stock['compras'] == null) {
        $inv = $stock['stock'] + $stock['ventas'];
    } else if ($stock['ventas'] == null && $stock['compras']!= null) {
        $inv = $stock['stock'] - $stock['compras'];
    } else {
        $inv = $stock['stock'];
    }
    $pagina .= '
                        <tr>
                            <td>' . $stock['productCode'] . '</td>
                            <td>' . $stock['productName'] . '</td>
                            <td>' . $stock['make'] . '</td>
                            <td>' . $stock['category'] . '</td>
                            <td>' . $stock['unity'] . '</td>
                            <td>Q. ' . $stock['cost'] . '</td>
                            <td>' . $inv . '</td>
                        </tr>';
}
        $pagina .= '</tbody>
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