<?php
include_once 'funciones/sesiones.php';
include_once 'templates/header.php';
include_once 'templates/navBar.php';
include_once 'templates/sideBar.php';
include_once 'funciones/bd_conexion.php';
$id = $_GET['id'];
if (!filter_var($id, FILTER_VALIDATE_INT)) {
  die("Error!");
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proveedores
        <small>Puede realizar cualquier edición en los datos</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Proveedor</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <?php
              $sql = "SELECT * FROM `provider` WHERE `idProvider` = $id ";
              $resultado = $conn->query($sql);
              $provider = $resultado->fetch_assoc();
            ?>
          <div class="row">
            <div class="col-md-6">
              <form role="form" id="form-provider" name="form-provider" method="post" action="BLL/provider.php">
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="name">Nombre</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Escriba el nombre del proveedor" 
                  value="<?php echo $provider['providerName']; ?>" autofocus>
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="address">Dirección</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Escriba la dirección"
                  value="<?php echo $provider['providerAddress']; ?>">
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="tel">Teléfono</label>
                  <input type="text" class="form-control" id="tel" name="tel" placeholder="Escriba el número de teléfono"
                  value="<?php echo $provider['providerTel']; ?>">
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase"></span>
                  <label for="mobile">Móvil</label>
                  <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Escriba el teléfono móvil"
                  value="<?php echo $provider['providerMobile']; ?>">
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase"></span>
                  <label for="email">Correo electrónico</label>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Escriba el correo electrónico"
                    value="<?php echo $provider['providerEmail']; ?>">
                    </div>                  
                </div>
            </div>
            <!-- /.form-group -->
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <span class="text-danger text-uppercase"></span>
                <label for="account">Cuenta Bancaria #1</label>
                <input type="text" class="form-control" id="account1" name="account1" placeholder="Escriba el número de la cuenta"
                value="<?php echo $provider['account1']; ?>">
              </div>
              <div class="form-group">
                <span class="text-danger text-uppercase"></span>
                <label for="account">Cuenta Bancaria #2</label>
                <input type="text" class="form-control" id="account2" name="account2" placeholder="Escriba el número de la cuenta"
                value="<?php echo $provider['account2']; ?>">
              </div>
              <div class="form-group">
                <span class="text-danger text-uppercase"></span>
                <label for="details">Detalles: </label>
                <textarea class="form-control" rows="3" id="details" name="details" placeholder="Escriba todos los detalles sobre este proveedor... "
                value="<?php echo $provider['details']; ?>"></textarea>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="registro" value="actualizar">
                <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-info">
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