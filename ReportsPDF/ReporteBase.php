<?php
	include ('pdfclass/mpdf.php');//Se importa la librería de PDF
	
	//Se indica lo que se va a imprimir en formato HTML
$pagina='
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
table#space > tr#direccion {
	border-collapse: separate;
	border-spacing: 10px 10px;
  }
</style>
</head>
<body>
<div class="row">
	<div class="col-xs-4">
		<table id="space" style="width:100%">
			<tr>
				<th style="text-align:left">Lugar:</th>
				<td>Ejemplo</td>
			</tr>
			<tr>
				<th style="text-align:left">Nombre:</th>
				<td>Ejemplo</td>
			</tr>
			<tr>
				<th style="text-align:left">Nit:</th>
				<td>Ejemplo</td>
			</tr>
			<tr>
				<th style="text-align:left;">Direccion:</th>
				<td>Ejemplo</td>
			</tr>
			<tr id="direccion">
				<th style="text-align:left; border-collapse: separate; border-spacing: 10px 10px;">Telefono:</th>
				<td>Ejemplo</td>
			</tr>
		</table>
	</div>
	<div class="col-xs-2">
		<table style="width:100%">
			<tr>
				<th>Cod Vendedor:</th>
				<td>Ejemplo</td>
			</tr>
		</table>
	</div>
	<div class="col-xs-2">
		<table style="width:100%">
			<tr>
				<th>Cod Cliente:</th>
				<td>Ejemplo</td>
			</tr>
		</table>
	</div>
	<div class="col-xs-2">
		<table style="width:100%">
			<tr>
				<th>Fecha de Vencimiento:</th>
				<td>Ejemplo</td>
			</tr>
		</table>
	</div>
	<!-- /.col -->
</div>

</body>
</html>';

				

	
	$file = "NombreReporte.pdf"; //Se nombra el archivo

	$mpdf = new mPDF('utf-8', 'LETTER', 5, '', 10, 10, 35, 10, 0, 0);//se define el tamaño de pagina y los margenes
	$mpdf->WriteHTML($pagina); //se escribe la variable pagina
	
	$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador
?>
