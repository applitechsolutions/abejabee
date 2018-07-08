<?php
  include_once 'funciones/sesiones.php';
  include_once 'templates/header.php';
  include_once 'templates/navBar.php';
  include_once 'templates/sideBar.php';
  include_once 'funciones/bd_conexion.php';
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Productos
        <small>llena el formulario para crear un nuevo producto</small>
      </h1>
    </section>

    <div class="row">
      <div class="col-md-8">
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Productos</h3>
            </div>
            <div class="box-body">
            
              <form role="form" id="form-usuario" name="form-usuario" method="post" action="BLL/user.php">
                <div class="box-body">
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe tu nombre" autofocus>
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="apellido">Código</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Escribe tu apellido">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="usuario">Costo</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Escribe tu nombre de Usuario">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="usuario">Descripción</label>
                    <input type="textarea" class="form-control" id="usuario" name="usuario" placeholder="Escribe tu nombre de Usuario">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label>Categoría</label>
                    <select id="rol" name="rol" class="form-control select2" style="width: 100%;">
                      <option value="" disabled selected>Seleccione el Rol</option>
                      <option value="0">+ Nueva Categoría</option>
                      <option value=2>Consultor</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label>Unidad</label>
                    <select id="rol" name="rol" class="form-control select2" style="width: 100%;">
                      <option value="" disabled selected>Seleccione el Rol</option>
                      <option value=1>Administrador</option>
                      <option value=2>Consultor</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label>Marca</label>
                    <select id="rol" name="rol" class="form-control select2" style="width: 100%;">
                      <option value="" disabled selected>Seleccione el Rol</option>
                      <option value=1>Administrador</option>
                      <option value=2>Consultor</option>
                    </select>
                  </div>
                <div class="box-footer">
                  <input type="hidden" name="registro" value="nuevo">
                  <button type="submit" class="btn btn-info" id="crear-usuario"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button><span class="text-warning"> Debe llenar los campos obligatorios *</span>
                </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </section>
        <!-- /.content -->
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

<?php
  include_once 'templates/footer.php';

?>
