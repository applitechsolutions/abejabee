<div class="w3-border-bottom w3-margin-bottom">
	<h3><i class="fa fa-users" aria-hidden="true"></i> Empleados</h3>
</div>
<div id="empleados-contenido" class="w3-container w3-margin-top">
	<!--ADD EMPLEADO/////////////////////////////////////////////////////////////////////////////////////-->
		<div id="agregar-empleado" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 w3-margin-bottom" >
			<div >
				<a id="add-empleado" class="w3-btn w3-blue w3-round" onclick="document.getElementById('add-empleado').style.display='none';">
					<i class="fa fa-plus"></i> Agregar Empleado 
				</a>
				<div id="form-empleado" class="w3-card-2 w3-white col-lg-8 col-md-8 col-sm-10 col-xs-12 hidden-section">
					<header>
						<i id="close-add-empleado" class="w3-closebtn fa fa-times fa-2x"></i>
						<h3>Agregar Empleado</h3>
					</header>
					<div class="w3-container">
						<div class="w3-half w3-padding-small">
							<label>Nombre</label>
                            <input type="text" class="w3-input w3-large" placeholder="Ingrese el nombre">
                            <label>Seleccione el Género</label>
							<select class="w3-select" name="genero_empleado">
								<option value="m">Masculino</option>
								<option value="f">Femenino</option>
							</select>
							<label>Seleccione el puesto</label>
							<select id="jobselect" onchange="newJob()" class="w3-input w3-round w3-light-gray w3-border-light-gray" name="puesto_empleado">
								<option value="" disabled selected>Elige un Puesto</option>
								<option value="0">+ Nuevo Puesto</option>
								
								
							</select>	
						</div>
						<div class="w3-half w3-padding-small">
							<label>Apellido</label>
							<input type="text" class="w3-input w3-round w3-light-gray w3-border-light-gray" placeholder="ingrese el apellido del nuevo empleado" name="apellido_empleado">	
							<label>Fecha de nacimiento</label>
							<input type="date" class="w3-select" placeholder="ingrese la fecha de nacimiento del nuevo empleado" name="fecha_empleado">	
						</div>
						<footer class="modal-footer">
							<button class="w3-btn w3-round-large w3-light-gray w3-hover-red w3-medium" id="cancel-add-empleado"> Cancelar</button>
							<button class="w3-btn w3-round-large w3-green w3-large" onclick="saveEmployee()"><i class="fa fa-floppy-o"></i> Agregar</button>
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
</div>

