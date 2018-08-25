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
        <i class="fa fa-briefcase"></i>
        Vendedores
        <small>llena el formulario para crear un vendedor</small>
      </h1>
    </section>

    <div class="row">
      <div class="col-md-6">
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Vendedores</h3>
            </div>
            <div class="box-body">
              <form role="form" id="form-vendedor" name="form-vendedor" method="post" action="BLL/seller.php">
                <div class="box-body">
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre-vendedor" name="nombre-vendedor" placeholder="Escribe el nombre del vendedor" autofocus>
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apel-vendedor" name="apel-vendedor" placeholder="Escribe el apellido del vendedor">
                  </div>
                  <div class="form-group">
                    <label for="usuario">Dirección</label>
                    <input type="text" class="form-control" id="direc-vendedor" name="direc-vendedor" placeholder="Escribe la dirección del vendedor">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label>Teléfono</label>
                    <input type="text" class="form-control" id="tel-vendedor" name="tel-vendedor" placeholder="Escribe el teléfono del vendedor">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label>DPI</label>
                    <input type="text" class="form-control" id="dpi-vendedor" name="dpi-vendedor" placeholder="Escribe el dpi del vendendor">
                  </div>
                  <div class="form-group">
                    <label>Fecha de nacimiento</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="datepicker" name="bday-vendedor">
                    </div>
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span><label>Masculino</label>
                    <input type="radio" id="gen-vendedor" name="gen-vendedor" class="flat-red" value="0" checked>
                    <span class="text-danger text-uppercase">*</span><label>Femenino</label>
                    <input type="radio" id="gen-vendedor" name="gen-vendedor" class="flat-red" value="1">
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <input type="hidden" name="reg-vendedor" value="nuevo">
                  <button type="submit" class="btn btn-info" id="crear-vendedor"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button><span class="text-warning">  *Debe llenar los campos obligatorios</span>
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
