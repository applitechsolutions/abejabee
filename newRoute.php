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
      <i class="fa fa-truck"></i>
        Rutas
        <small>Llene el formulario para crear una nueva ruta</small>
      </h1>
    </section>

    <div class="row">
      <div class="col-md-6">
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Ruta</h3>
            </div>
            <div class="box-body">
              <form role="form" id="form-ruta" name="form-ruta" method="post" action="BLL/route.php">
                <div class="box-body">
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span>
                    <label for="codeR">Código</label>
                    <input type="text" class="form-control" id="codeR" name="codeR" placeholder="Escriba un código" autofocus>
                  </div>
                  <div class="form-group">
                    <label for="nameR">Nombre</label>
                    <input type="text" class="form-control" id="nameR" name="nameR" placeholder="Escriba un nombre">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span>
                    <label>Vendedor</label>
                    <select id="sellerR" name="sellerR" class="form-control select2" style="width: 100%;">
                      <option value="" disabled selected>Seleccione a un vendedor</option>
                      <?php
                        try {
                          $sql = "SELECT * FROM seller";
                          $resultado = $conn->query($sql);
                          while ($seller_route = $resultado->fetch_assoc()) {?>
                        <option value="<?php echo $seller_route['idSeller']; ?>">
                          <?php echo $seller_route['sellerFirstName']. " " .$seller_route['sellerLastName']; ?>
                        </option>
                        <?php 
                          }
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="detailsR">Detalles: </label>
                    <textarea class="form-control" rows="2" id="detailsR" name="detailsR" placeholder="Escriba todos los detalles sobre esta ruta... "></textarea>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Fecha de Inicio</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="datepicker" name="dateStart">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Fecha final</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="datepicker2" name="dateEnd">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <input type="hidden" name="ruta" value="nueva">
                    <button type="submit" class="btn btn-info" id="crear-ruta">
                      <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    <span class="text-warning"> Debe llenar los campos obligatorios *</span>
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