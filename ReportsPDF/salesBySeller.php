<?php
include ('pdfclass/mpdf.php');//Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$idVendedor = $_GET['idVendedor'];
$fecha1 = strtr($_GET['fecha1'], '/', '-');
$fecha2 = strtr($_GET['fecha2'], '/', '-');

$fi = date('Y-m-d', strtotime($fecha1));
$ff = date('Y-m-d', strtotime($fecha2));

try{
    $sql = "SELECT S.*,
    (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
    (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) as fechapago,
    D.quantity, D.priceS, D.discount,
    (SELECT productName FROM product WHERE idProduct = D._idProduct) as nombre,
    (SELECT productCode FROM product WHERE idProduct = D._idProduct) as codigo,
    (SELECT s30 FROM commission WHERE _idSeller = $idVendedor) as s30,
    (SELECT s60 FROM commission WHERE _idSeller = $idVendedor) as s60,
    (SELECT s90 FROM commission WHERE _idSeller = $idVendedor) as s90,
    (SELECT o30 FROM commission WHERE _idSeller = $idVendedor) as o30,
    (SELECT o60 FROM commission WHERE _idSeller = $idVendedor) as o60,
    (SELECT sd30 FROM commission WHERE _idSeller = $idVendedor) as sd30,
    (SELECT sd60 FROM commission WHERE _idSeller = $idVendedor) as sd60,
    (SELECT sd90 FROM commission WHERE _idSeller = $idVendedor) as sd90,
    (SELECT od30 FROM commission WHERE _idSeller = $idVendedor) as od30,
    (SELECT od60 FROM commission WHERE _idSeller = $idVendedor) as od60,
    (SELECT makeName FROM make WHERE idMake = (SELECT _idMake FROM product WHERE idProduct = D._idProduct)) as marca
    FROM sale S 
    INNER JOIN detailS D ON S.idSale = D._idSale
    WHERE S.cancel = 1 AND S._idSeller = $idVendedor AND (SELECT date FROM balance WHERE _idSale = S.idSale ORDER BY idBalance DESC LIMIT 1) BETWEEN '$fi' AND '$ff' ORDER BY S.dateStart ASC";

    $resultado = $conn->query($sql);
    $res = $conn->query($sql);
} catch (Exception $e){
    $error= $e->getMessage();
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
                            <th style="background-color: #1d2128; color: white">Fecha de pago</th>
                            <th style="background-color: #1d2128; color: white">Método de pago</th>
                            <th style="background-color: #1d2128; color: white">Producto</th>
                            <th style="background-color: #1d2128; color: white">Cantidad</th>
                            <th style="background-color: #1d2128; color: white">Precio</th>
                            <th style="background-color: #1d2128; color: white">Descuento</th>
                            <th style="background-color: #1d2128; color: white">Subtotal</th>
                            <th style="background-color: #1d2128; color: white">Comisión</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
            $subtotalComision = 0;
            while ($sale = $resultado->fetch_assoc()) {
                $datetime1 = date_create($sale['fechapago']);
                $datetime2 = date_create($sale['dateEnd']);
                $interval = date_diff($datetime2, $datetime1);
                $diferencia = $interval->format('%a');

                $sub = $sale['quantity'] * ($sale['priceS'] - 
                $sale['discount']);
                $subtotal = $sub;
                if ($sale['marca'] == 'SCHLENKER') {
                    if ($diferencia <= $sale['sd30']) {
                        $comision = $subtotal * ($sale['s30'] / 100);
                    } else if ($diferencia > $sale['sd30'] && $diferencia <= $sale['sd60']) {
                        $comision = $subtotal * ($sale['s60'] / 100);
                    } else if ($diferencia > $sale['sd60'] && $diferencia <= $sale['sd90']) {
                        $comision = $subtotal * ($sale['s90'] / 100);
                    } else {
                        $comision = 0;
                    }
                } else {
                    if ($diferencia <= $sale['od30']) {
                        $comision = $subtotal * ($sale['o30'] / 100);
                    } else if ($diferencia > $sale['od30'] && $diferencia <= $sale['od60']) {
                        $comision = $subtotal * ($sale['o60'] / 100);
                    } else {
                        $comision = 0;
                    }
                }
                $subtotalComision += $comision;
                $dateStar = date_create($sale['dateStart']);
                $fechapago = date_create($sale['fechapago']);
                $pagina.='
                        <tr>
                            <td>'.date_format($dateStar, 'd/m/y').'</td>
                            <td><small class="w3-deep-orange">Factura No°</small><br><small>'.$sale['serie'].' '.$sale['noBill'].'</small><br><small class="w3-indigo">Remision No°</small><br><small>'.$sale['noDeliver'].'</small></td>
                            <td>'.date_format($fechapago, 'd/m/y').'</td>
                            <td>'.$sale['paymentMethod'].'</td>
                            <td>'.$sale['codigo'].' '.$sale['nombre'].'</td>
                            <td>'.$sale['quantity'].'</td>
                            <td>Q. '.$sale['priceS'].'</td>
                            <td>Q. '.$sale['discount'].'</td>
                            <td>Q. '.$subtotal.'</td>
                            <td>Q. '.number_format($comision, 2, '.', ',').'</td>
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
                        <th></th>
                        <th style="text-align: right;" colspan="2">Total Comisiones :</th>
                        <td>Q. <small>'. number_format($subtotalComision, 2, '.', ',') .'</small></td>
                        </tr>
                    </tfoot>
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