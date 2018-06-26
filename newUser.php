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
        Usuarios
        <small>llena el formulario para crear un usuario</small>
      </h1>
    </section>

    <div class="row">
      <div class="col-md-8">
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Usuario</h3>
            </div>
            <div class="box-body">
              <form role="form" id="form-usuario" name="form-usuario" method="post" action="BLL/user.php">
                <div class="box-body">
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe tu nombre" autofocus>
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Escribe tu apellido">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="usuario">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Escribe tu nombre de Usuario">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label>Rol</label>
                    <select id="rol" name="rol" class="form-control">
                      <option value="" disabled selected>Seleccione el Rol</option>
                      <option value=1>Administrador</option>
                      <option value=2>Consultor</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Escribe tu contraseña de acceso">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="password">Confirmar Constraseña</label>
                    <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" placeholder="Escribe tu contraseña de nuevo">
                    <span id="resultado-password" class="help-block"></span>
                  </div>
                </div>
                <!-- /.box-body -->
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
