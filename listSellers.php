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
        Vendedores
        <small>Listado de Vendedores</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado general de vendedores en el sistema</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="registros" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>DPI</th>
                  <th>Fecha de Nacimiento</th>
                  <th>Género</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  try{
                    $sql = "SELECT idSeller, sellerFirstName, sellerLastName, sellerAddress, sellerMobile, DPI, birthDate, gender FROM seller WHERE state = 0";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($seller = $resultado->fetch_assoc()) {
                    $date = date_create($seller['birthDate']);
                ?>
                    <tr>
                      <td><?php echo $seller['sellerFirstName']; ?></td>
                      <td><?php echo $seller['sellerLastName']; ?></td>
                      <td><?php echo $seller['sellerAddress']; ?></td>
                      <td><?php echo $seller['sellerMobile']; ?></td>
                      <td><?php echo $seller['DPI']; ?></td>
                      <td><?php echo date_format($date, 'd/m/y'); ?></td>
                      <?php if ($seller['gender'] == '0') {
                        ?><td>Masculino</td><?php
                      }else if ($seller['gender'] == '1'){
                        ?><td>Femenino</td><?php
                      }   ?>
                      <td>
                        <a class="btn bg-green btn-flat margin" href="editSeller.php?id=<?php echo $seller['idSeller'] ?>"><i class="fa fa-pencil"></i></a>
                        <a href="#" data-id="<?php echo $seller['idSeller']; ?>" data-tipo="seller" class="btn bg-maroon btn-flat margin borrar_vendedor"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                <?php }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>DPI</th>
                  <th>Fecha de Nacimiento</th>
                  <th>Género</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  include_once 'templates/footer.php';

?>
