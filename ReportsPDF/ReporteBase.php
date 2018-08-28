<?php
	include ('pdfclass/mpdf.php');//Se importa la librería de PDF
	
	//Se indica lo que se va a imprimir en formato HTML
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
					<th>Qty</th>
					<th>Product</th>
					<th>Serial #</th>
					<th>Description</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody>
			
			</tbody>
		</table>
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->

</body>
</html>';

				

	
	$file = "NombreReporte.pdf"; //Se nombra el archivo

	$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0);//se define el tamaño de pagina y los margenes
	$mpdf->WriteHTML($pagina); //se escribe la variable pagina
	
	$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador
?>
