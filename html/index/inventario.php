<div class="w3-container">
  <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-blue w3-large w3-round-large w3-right fa fa-plus"> Nuevo</button>
  	<div id="id01" class="w3-modal">
  
		<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
			<div class="w3-card-2 w3-white col-lg-12 col-md-8 col-sm-8 col-xs-10">
				<header>
					<h3>Agregar Producto</h3>
					<span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn fa fa-times fa-2x"</span>
				</header>
				<div class="w3-container">
					<div class="w3-half w3-padding-small">
						<br>
						<label class="w3-left">Nombre</label>
						<input class="w3-input" type="text" placeholder="Ingrese el nombre del producto">
						<br>
						<label class="w3-left">Costo</label>
						<input class="w3-input" type="text" placeholder="Ingrese el costo del producto">
						<br>
						<label class="w3-left">Imagen</label>
						<input class="inputFile" type="file">
						<br>
						<select class="w3-select" name="option">
							<option value="" disabled selected>Seleccione la Categoría</option>
							<option value="1">Option 1</option>
							<option value="2">Option 2</option>
							<option value="3">Option 3</option>
						</select>
					</div>
					<div class="w3-half w3-padding-small">
						<br>
						<label class="w3-left">Código</label>
						<input class="w3-input" type="text" placeholder="Ingrese el código del producto">
						<br>
						<label class="w3-left">Descripción</label>
						<input class="w3-input" type="textarea" placeholder="Ingrese una descripción">
						<br>
						<select class="w3-select" name="option">
							<option value="" disabled selected>Seleccione la Unidad</option>
							<option value="1">Option 1</option>
							<option value="2">Option 2</option>
							<option value="3">Option 3</option>
						</select>

						<br>
						<select class="w3-select" name="option">
							<option value="" disabled selected>Seleccione la Marca</option>
							<option value="1">Option 1</option>
							<option value="2">Option 2</option>
							<option value="3">Option 3</option>
						</select>
					</div>
				</div>
				<footer class="modal-footer">
					<button class="w3-btn w3-round w3-light-gray w3-hover-red" id="cancel-add-empleado" onclick="document.getElementById('id01').style.display='none'"> Cancelar</button>
					<button class="w3-btn w3-round w3-green" onclick=""><i class="fa fa-floppy-o"></i> Guardar</button>
				</footer>
			</div>
		</div>
  	</div>
</div>
	<h1 class="page-header">Tables</h1>
	<div class="panel panel-default">
		<div class="panel-heading">
			DataTables Advanced Tables
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
						<th>Rendering engine</th>
						<th>Browser</th>
						<th>Platform(s)</th>
						<th>Engine version</th>
						<th>CSS grade</th>
					</tr>
				</thead>
				<tbody>
					<tr class="odd gradeX">
						<td>Trident</td>
						<td>Internet Explorer 4.0</td>
						<td>Win 95+</td>
						<td class="center">4</td>
						<td class="center">X</td>
					</tr>
					<tr class="even gradeC">
						<td>Trident</td>
						<td>Internet Explorer 5.0</td>
						<td>Win 95+</td>
						<td class="center">5</td>
						<td class="center">C</td>
					</tr>
					<tr class="odd gradeA">
						<td>Trident</td>
						<td>Internet Explorer 5.5</td>
						<td>Win 95+</td>
						<td class="center">5.5</td>
						<td class="center">A</td>
					</tr>
					<tr class="even gradeA">
						<td>Trident</td>
						<td>Internet Explorer 6</td>
						<td>Win 98+</td>
						<td class="center">6</td>
						<td class="center">A</td>
					</tr>
					<tr class="odd gradeA">
						<td>Trident</td>
						<td>Internet Explorer 7</td>
						<td>Win XP SP2+</td>
						<td class="center">7</td>
						<td class="center">A</td>
					</tr>
					<tr class="even gradeA">
						<td>Trident</td>
						<td>AOL browser (AOL desktop)</td>
						<td>Win XP</td>
						<td class="center">6</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Firefox 1.0</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center">1.7</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Firefox 1.5</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center">1.8</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Firefox 2.0</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center">1.8</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Firefox 3.0</td>
						<td>Win 2k+ / OSX.3+</td>
						<td class="center">1.9</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Camino 1.0</td>
						<td>OSX.2+</td>
						<td class="center">1.8</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Camino 1.5</td>
						<td>OSX.3+</td>
						<td class="center">1.8</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Netscape 7.2</td>
						<td>Win 95+ / Mac OS 8.6-9.2</td>
						<td class="center">1.7</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Netscape Browser 8</td>
						<td>Win 98SE+</td>
						<td class="center">1.7</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Netscape Navigator 9</td>
						<td>Win 98+ / OSX.2+</td>
						<td class="center">1.8</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.0</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center">1</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.1</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center">1.1</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.2</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center">1.2</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeA">
						<td>Gecko</td>
						<td>Mozilla 1.3</td>
						<td>Win 95+ / OSX.1+</td>
						<td class="center">1.3</td>
						<td class="center">A</td>
					</tr>
					<tr class="gradeU">
						<td>Other browsers</td>
						<td>All others</td>
						<td>-</td>
						<td class="center">-</td>
						<td class="center">U</td>
					</tr>
				</tbody>
			</table>
			<!-- /.table-responsive -->
			<div class="well">
				<h4>DataTables Usage Information</h4>
				<p>DataTables is a very flexible, advanced tables plugin for jQuery. In SB Admin, we are using a specialized version of DataTables built for Bootstrap 3. We have also customized the table headings to use Font Awesome icons in place of images. For complete documentation on DataTables, visit their website at <a target="_blank" href="https://datatables.net/">https://datatables.net/</a>.</p>
				<a class="btn btn-default btn-lg btn-block" target="_blank" href="https://datatables.net/">View DataTables Documentation</a>
			</div>
		</div>
	</div>

