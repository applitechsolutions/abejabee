<?php
include ('pdfclass/mpdf.php');//Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';
//Se indica lo que se va a imprimir en formato HTML

$idVendedor = $_GET['idVendedor'];
echo $idVendedor;

try{
    $sql = "SELECT S.*,
    (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer
    FROM sale S WHERE S.cancel = 1 AND S._idSeller = $idVendedor";
    $resultado = $conn->query($sql);
    $res = $conn->query($sql);
} catch (Exception $e){
    $error= $e->getMessage();
    echo $error;
}

while ($nombre = $res->fetch_assoc()) {
    $vendedor = $nombre['seller'];
}


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
                        <small class="pull-right w3-display-right">Fecha: '.date("d/m/Y").'</small>
                    </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <div style="text-align: center;">
                    <h3>Ventas realizadas por '. $vendedor .'</h3>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Fecha</th>
                            <th style="background-color: #1d2128; color: white">Factura No°</th>
                            <th style="background-color: #1d2128; color: white">Cliente</th>
                            <th style="background-color: #1d2128; color: white">Fecha de vencimiento</th>
                            <th style="background-color: #1d2128; color: white">Método de pago</th>
                            <th style="background-color: #1d2128; color: white">Envío No°</th>
                            <th style="background-color: #1d2128; color: white">Entrega No°</th>
                            <th style="background-color: #1d2128; color: white">Anticipo</th>
                            <th style="background-color: #1d2128; color: white">Total</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
            while ($sale = $resultado->fetch_assoc()) {
                $pagina.='
                        <tr>
                            <td>'.$sale['dateStart'].'</td>
                            <td>'.$sale['noBill'].'</td>
                            <td>'.$sale['customer'].'</td>
                            <td>'.$sale['dateEnd'].'</td>
                            <td>'.$sale['paymentMethod'].'</td>
                            <td>'.$sale['noShipment'].'</td>
                            <td>'.$sale['noDeliver'].'</td>
                            <td>'.$sale['advance'].'</td>
                            <td>'.$sale['totalSale'].'</td>
                        </tr>';
                    }
        $pagina .= '</tbody>
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