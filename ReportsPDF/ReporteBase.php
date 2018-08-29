<?php
	include ('pdfclass/mpdf.php');//Se importa la librería de PDF
	
	//Se indica lo que se va a imprimir en formato HTML
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
					<div>
						<h4 class="w3-center"><b>Schlenker Pharma</b></h4>
						<h5 class="w3-right">'.date("d/m/Y").'</h5>
					</div>
					<div style="text-align: center;">
						<h2>TITULO DEL REPORTE</h2>
					</div>
				</div>
				<div id="contenido">
					<table class="w3-table-all">
						<thead style="background-color: black;">
							<tr>
								<th style="background-color: #1d2128; color: white">Descripcion</th>
								<th style="background-color: #1d2128; color: white">Fecha</th>
								<th style="background-color: #1d2128; color: white">Producto</th>
								<th style="background-color: #1d2128; color: white">Cantidad</th>
								<th style="background-color: #1d2128; color: white">Costo</th>
								<th style="background-color: #1d2128; color: white">Bodega</th>
							</tr>
						</thead>
						<tbody class="w3-white">
						</tbody>
					</table>
				</div>
			</div>
		</body>
	</html>';

				

	
	$file = "NombreReporte.pdf"; //Se nombra el archivo

	$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0);//se define el tamaño de pagina y los margenes
	$mpdf->WriteHTML($pagina); //se escribe la variable pagina
	
	$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador
?>
