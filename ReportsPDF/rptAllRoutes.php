<?php
include ('pdfclass/mpdf.php');//Se importa la librería de PDF
include_once '../funciones/bd_conexion.php';
//Se indica lo que se va a imprimir en formato HTML

try{
    $sql = "SELECT idRoute, codeRoute, routeName,
    (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = _idSeller) as Seller, details FROM route WHERE state = 0";
    $resultado = $conn->query($sql);
} catch (Exception $e){
    $error= $e->getMessage();
    echo $error;
}

$pagina='
    <!DOCTYPE html>
    <html>
    <head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
    <div class="row">
        <div class="col-xs-12">
            <h3 class="page-header">
            <i class="fa fa-globe"></i> Schlenker, Pharma.
            <small class="pull-right">Fecha: '.date("d/m/Y").'</small>
            </h3>
        </div>
    <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Código de Ruta</th>
                        <th>Ruta</th>
                        <th>Vendedor</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>';
                while ($route = $resultado->fetch_assoc()) {
            $pagina.='
                    <tr>
                    <td>'.$route['codeRoute'].'</td>
                    <td>'.$route['routeName'].'</td>
                    <td>'.$route['Seller'].'</td>
                    <td>'.$route['details'].'</td>
                    </tr>';
                }
    $pagina .= '</tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    </body>
    </html>';

    $file = "AllCellar.pdf"; //Se nombra el archivo

    $mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0);//se define el tamaño de pagina y los margenes
    $mpdf->WriteHTML($pagina); //se escribe la variable pagina

    $mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador
?>