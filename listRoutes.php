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
        <small>Listado de rutas</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de rutas vigentes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="registros" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Vendedor</th>
                  <th>Detalles</th>
                  <th><span class="fa fa-cogs"></span></th>
                </tr>
                </thead>
                <tbody>
                <?php
                  try{
                    $sql = "SELECT idRoute, codeRoute, routeName,
                    (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = _idSeller) as Seller, details FROM route WHERE state = 0 ORDER BY codeRoute ASC";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($route = $resultado->fetch_assoc()) {
                ?>
                    <tr>
                      <td><?php echo $route['codeRoute']; ?></td>
                      <td><?php echo $route['routeName']; ?></td>
                      <td><?php echo $route['Seller']; ?></td>
                      <td><?php echo $route['details']; ?></td>
                      <td>
                      <?php
                      if ($_SESSION['rol'] == 1) {?>
                        <a class="btn bg-green btn-flat margin" href="editRoute.php?id=<?php echo $route['idRoute'] ?>"><i class="fas fa-pen-square"></i></a>
                        <a href="#" data-id="<?php echo $route['idRoute'];?>" data-tipo="route" class="btn bg-maroon btn-flat margin borrar_ruta"><i class="fa fa-trash"></i></a><?php
                      }elseif ($_SESSION['rol'] == 2) {?>
                        <a class="btn bg-green btn-flat margin" onclick="valListados()"><i class="fas fa-pen-square"></i></a>
                        <a href="#" class="btn bg-maroon btn-flat margin" onclick="valListados()"><i class="fa fa-trash"></i></a><?php
                      }
                      ?>
                      </td>
                    </tr>
                <?php }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Vendedor</th>
                  <th>Detalles</th>
                  <th><span class="fa fa-cogs"></span></th>
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
