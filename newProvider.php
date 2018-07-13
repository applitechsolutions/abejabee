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
        Proveedores
        <small>Complete el formulario para crear un nuevo proveedor</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Crear Proveedor</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <form role="form" id="form-provider" name="form-provider" method="post" action="BLL/provider.php">
              <div class="box-body">
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="name">Nombre</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Escriba el nombre del proveedor" autofocus>
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="address">Dirección</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Escriba la dirección">
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="tel">Teléfono</label>
                  <input type="text" class="form-control" id="tel" name="tel" placeholder="Escriba el número de teléfono">
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase"></span>
                  <label for="mobile">Móvil</label>
                  <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Escriba el teléfono móvil">
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase"></span>
                  <label for="email">Correo electrónico</label>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Escriba el correo electrónico">
                    </div>                  
                </div>
            </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
            <div class="box-body">
              <div class="form-group">
                <span class="text-danger text-uppercase"></span>
                <label for="account">Cuenta Bancaria #1</label>
                <input type="text" class="form-control" id="account1" name="account1" placeholder="Escriba el número de la cuenta">
              </div>
              <div class="form-group">
                <span class="text-danger text-uppercase"></span>
                <label for="account">Cuenta Bancaria #2</label>
                <input type="text" class="form-control" id="account2" name="account2" placeholder="Escriba el número de la cuenta">
              </div>
              <div class="form-group">
                <span class="text-danger text-uppercase"></span>
                <label for="details">Detalles: </label>
                <textarea class="form-control" rows="3" id="details" name="details" placeholder="Escriba todos los detalles sobre este proveedor... "></textarea>
              </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="registro" value="nuevo">
                <button type="submit" class="btn btn-info" id="crear-proveedor">
                  <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                <span class="text-warning"> Debe llenar los campos obligatorios *</span>
              </div>
            </div>
            </form>
            <!-- /.form-group -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
include_once 'templates/footer.php';

?>