<?php
include ('pdfclass/mpdf.php');//Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML

$idCliente = $_GET['idCliente'];

try{
    $sql = "SELECT serie, noBill, noDeliver, dateStart,
    (SELECT customerName FROM customer WHERE idCustomer = S._idCustomer) as customer,
    (SELECT balance FROM balance WHERE _idSale = idSale ORDER BY idBalance DESC LIMIT 1) AS saldo
    FROM sale S WHERE _idCustomer = $idCliente AND cancel = 0";

    $resultado = $conn->query($sql);
    $res = $conn->query($sql);
} catch (Exception $e){
    $error= $e->getMessage();
    echo $error;
}

while ($nombre = $res->fetch_assoc()) {
    $client = $nombre['customer'];
}



$pagina='
<!DOCTYPE html>
<html>
    <head>
        <title>Balance de un cliente</title>
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
                    <h3>Balance de '. $client .'</h3>
                </div>
            </div>
            <div id="contenido">
                <table class="w3-table-all">
                    <thead style="background-color: black;">
                        <tr>
                            <th style="background-color: #1d2128; color: white">Documento</th>
                            <th style="background-color: #1d2128; color: white">Fecha de Pago</th>
                            <th style="background-color: #1d2128; color: white">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="w3-white">';
            while ($cliente = $resultado->fetch_assoc()) {
                $pagina.='
                        <tr>
                            <td><small class="w3-deep-orange">Factura No°</small><br><small>'.$cliente['serie'].' '.$cliente['noBill'].'</small><br><small class="w3-indigo">Remision No°</small><br><small>'.$cliente['noDeliver'].'</small></td>
                            <td>'.$cliente['dateStart'].'</td>
                            <td>'.$cliente['saldo'].'</td>
                        </tr>';
                    }
        $pagina .= '</tbody>
                </table>
            </div>
        </div>
    </body>
</html>';

    

$file = "Balancedeuncliente.pdf"; //Se nombra el archivo

$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0);//se define el tamaño de pagina y los margenes
$mpdf->WriteHTML($pagina); //se escribe la variable pagina

$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador
?>