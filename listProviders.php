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
        <small>Activos</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado general de proveedores</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="registros" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>Móvil</th>
                  <th>Correo Electrónico</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  try{
                    $sql = "SELECT idProvider, providerName, providerAddress, providerTel, providerMobile, providerEmail FROM provider WHERE state = 0";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($provider = $resultado->fetch_assoc()) {
                ?>
                    <tr>
                      <td><?php echo $provider['providerName']; ?></td>
                      <td><?php echo $provider['providerAddress']; ?></td>
                      <td><?php echo $provider['providerTel']; ?></td>
                      <td><?php echo $provider['providerMobile']; ?></td>
                      <td><?php echo $provider['providerEmail']; ?></td>
                      <td>
                        <a class="btn bg-green btn-flat margin" href="editProvider.php?id=<?php echo $provider['idProvider'] ?>"><i class="fa fa-pencil"></i></a>
                        <a href="#" data-id="<?php echo $provider['idProvider']; ?>" data-tipo="provider" class="btn bg-maroon btn-flat margin borrar_usuario"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                <?php }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>Móvil</th>
                  <th>Correo Electrónico</th>
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
