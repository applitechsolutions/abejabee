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
      <i class="fa fa-truck"></i>
        Rutas
        <small>Llene el formulario para editar una nueva ruta</small>
      </h1>
    </section>

    <div class="row">
      <div class="col-md-6">
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Ruta</h3>
            </div>
            <div class="box-body">
              <?php
              $sql = "SELECT * FROM `route` WHERE `idRoute` = $id ";
              $resultado = $conn->query($sql);
              $route = $resultado->fetch_assoc();
              ?>
              <form role="form" id="form-ruta" name="form-ruta" method="post" action="BLL/route.php">
                <div class="box-body">
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span>
                    <label for="codeR">Código</label>
                    <input type="text" class="form-control" id="codeR" name="codeR" placeholder="Escriba un código" autofocus
                    value="<?php echo $route['codeRoute']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="nameR">Nombre</label>
                    <input type="text" class="form-control" id="nameR" name="nameR" placeholder="Escriba un nombre"
                    value="<?php echo $route['routeName']; ?>">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span>
                    <label>Vendedor</label>
                    <select id="sellerR" name="sellerR" class="form-control select2" style="width: 100%;">
                      <option value="" disabled selected>Seleccione a un vendedor</option>
                      <?php
                        try {
                            $vendedor_actual = $route['_idSeller'];
                            $sql = "SELECT * FROM seller";
                            $resultado = $conn->query($sql);
                            while ($seller_route = $resultado->fetch_assoc()) {
                                if ($seller_route['idSeller'] == $vendedor_actual) {?>
                        <option value="<?php echo $seller_route['idSeller']; ?>" selected>
                          <?php echo $seller_route['sellerFirstName']. ' '.$seller_route['sellerLastName']; ?>
                        </option>
                        <?php
                            } else {?>
                        <option value="<?php echo $seller_route['idSeller']; ?>">
                        <?php echo $seller_route['sellerFirstName'].' '.$seller_route['sellerLastName']; ?>
                        </option>
                        <?php
                            }
                                }
                            } catch (Exception $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="detailsR">Detalles: </label>
                    <textarea class="form-control" rows="2" id="detailsR" name="detailsR" placeholder="Escriba todos los detalles sobre esta ruta... "><?php echo $route['details'];?></textarea>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <input type="hidden" name="ruta" value="editar">
                    <input type="hidden" name="id_ruta" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-info" id="editar-ruta">
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