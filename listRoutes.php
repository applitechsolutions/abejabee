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
            <div class="box-body">
              <table id="registros" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Vendedor</th>
                  <th>Detalles</th>
                  <th>Fecha de Inicio</th>
                  <th>Fecha Final</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  try{
                    $sql = "SELECT idRoute, codeRoute, routeName,
                    (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = _idSeller) as Seller, details, dateStart, dateEnd FROM route WHERE state = 0;";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($route = $resultado->fetch_assoc()) {
                    $dateS = date_create($route['dateStart']);
                    $dateE = date_create($route['dateEnd']);
                ?>
                    <tr>
                      <td><?php echo $route['codeRoute']; ?></td>
                      <td><?php echo $route['routeName']; ?></td>
                      <td><?php echo $route['Seller']; ?></td>
                      <td><?php echo $route['details']; ?></td>
                      <td><?php echo date_format($dateS, 'd/m/y'); ?></td>
                      <td><?php echo date_format($dateE, 'd/m/y'); ?></td>
                      <td>
                        <a class="btn bg-green btn-flat margin" href="editRoute.php?id=<?php echo $route['idRoute'] ?>"><i class="fa fa-pencil"></i></a>
                        <a href="#" data-id="<?php echo $route['idRoute']; ?>" data-tipo="route" class="btn bg-maroon btn-flat margin borrar_ruta"><i class="fa fa-trash"></i></a>
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
                  <th>Fecha de Inicio</th>
                  <th>Fecha Final</th>
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
