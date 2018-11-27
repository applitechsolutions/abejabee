<?php
include ('pdfclass/mpdf.php');//Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$idVenta = $_GET['idVenta'];
$fecha1 = $_GET['fecha1'];
$fecha2 = $_GET['fecha2'];

$f1 = date('Y-m-d', strtotime($fecha1));
$f2 = date('Y-m-d', strtotime($fecha2));
echo $f1;
echo $f2;

$datetime1 = date_create($f1);
$datetime2 = date_create($f2);
$interval = date_diff($datetime2, $datetime1);
$diferencia = $interval->format('%a');

try{
    $sql = "SELECT quantity, priceS, discount,
    (SELECT productName FROM product WHERE idProduct = D._idProduct) as nombre,
    (SELECT productCode FROM product WHERE idProduct = D._idProduct) as codigo,
    (SELECT makeName FROM make WHERE idMake = (SELECT _idMake FROM product WHERE idProduct = D._idProduct)) as marca
    FROM detailS D WHERE _idSale = $idVenta";

    $resultado = $conn->query($sql);
    $res = $conn->query($sql);
} catch (Exception $e){
    $error= $e->getMessage();
    echo $error;
}


$pagina='
<!DOCTYPE html>
<html>
    <head>
        <title>Detalle Comisiones</title>
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
                    <h3>Detalle de Comisiones</h3>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Código</th>
                            <th style="background-color: #1d2128; color: white">Nombre</th>
                            <th style="background-color: #1d2128; color: white">Marca</th>
                            <th style="background-color: #1d2128; color: white">Cantidad</th>
                            <th style="background-color: #1d2128; color: white">Precio de Venta</th>
                            <th style="background-color: #1d2128; color: white">Descuento</th>
                            <th style="background-color: #1d2128; color: white">Subtotal</th>
                            <th style="background-color: #1d2128; color: white">Comisión</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
            while ($sale = $resultado->fetch_assoc()) {
                $sub = $sale['quantity'] * $sale['priceS'];
                $subtotal = number_format($sub, 2, '.', ',');
                if ($sale['marca'] == 'SCHLENKER') {
                    if ($diferencia <= '30') {
                        $comision = $subtotal * 0.1;
                    } else if ($diferencia > '30' && $diferencia <= '60') {
                        $comision = $subtotal * 0.08;
                    } else if ($diferencia > '60' && $diferencia <= '90') {
                        $comision = $subtotal * 0.05;
                    } else {
                        $comision = 0;
                    }
                } else {
                    if ($diferencia <= '30') {
                        $comision = $subtotal * 0.05;
                    } else if ($diferencia > '30' && $diferencia <= '60') {
                        $comision = $subtotal * 0.03;
                    } else {
                        $comision = 0;
                    }
                }
                $subtotalComision += $comision;
                $pagina.='
                        <tr>
                            <td>'.$sale['codigo'].'</td>
                            <td>'.$sale['nombre'].'</td>
                            <td>'.$sale['marca'].'</td>
                            <td>'.$sale['quantity'].'</td>
                            <td>Q. '.$sale['priceS'].'</td>
                            <td>Q. '.$sale['discount'].'</td>
                            <td>Q. '.$subtotal.'</td>
                            <td>Q. '.$comision.'</td>
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
                        <th style="text-align: right;" colspan="2">Total Comisiones :</th>
                        <td>Q. '. $subtotalComision .'</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>';

    

    $file = "Comisiones.pdf"; //Se nombra el archivo

    $mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0);//se define el tamaño de pagina y los margenes
    $mpdf->WriteHTML($pagina); //se escribe la variable pagina

    $mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador
?>