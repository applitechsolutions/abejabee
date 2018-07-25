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
      <i class="fa fa-users"></i>
        Clientes
        <small>Todos</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado general de los clientes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="registros" class="table table-bordered table-striped w3-small">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Código</th>
                  <th>Teléfono</th>
                  <th>Nit</th>
                  <th>Dirección</th>
                  <th>Departamento</th>
                  <th>Municipio</th>
                  <th>Aldea</th>
                  <th>Ruta</th>
                  <th>Dueño</th>
                  <th>Encargado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  try{
                    $sql = "SELECT idCustomer, customerName, customerCode, customerTel, customerNit, customerAddress, owner, inCharge,
                    (SELECT name FROM deparment WHERE idDeparment = C._idDeparment) as depName,
                    (SELECT name FROM town WHERE idTown = C._idTown) as townName,
                    (SELECT name FROM village WHERE idVillage = C._idVillage) as villaName,
                    (SELECT routeName FROM route WHERE idRoute = C._idRoute and state = 0) as roName
                    FROM customer C WHERE state = 0";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($customer = $resultado->fetch_assoc()) {
                ?>
                    <tr>
                      <td><?php echo $customer['customerName']; ?></td>
                      <td><?php echo $customer['customerCode']; ?></td>
                      <td><?php echo $customer['customerTel']; ?></td>
                      <td><?php echo $customer['customerNit']; ?></td>
                      <td><?php echo $customer['customerAddress']; ?></td>
                      <td><?php echo $customer['depName']; ?></td>
                      <td><?php echo $customer['townName']; ?></td>
                      <td><?php echo $customer['villaName']; ?></td>
                      <td><?php echo $customer['roName']; ?></td>
                      <td><?php echo $customer['owner']; ?></td>
                      <td><?php echo $customer['inCharge']; ?></td>
                      <td>
                        <a class="btn bg-green btn-flat margin" href="editCustomer.php?id=<?php echo $customer['idCustomer'] ?>"><i class="fa fa-pencil"></i></a>
                        <a href="#" data-id="<?php echo $customer['idCustomer']; ?>" data-tipo="customer" class="btn bg-maroon btn-flat margin borrar_customer"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                <?php }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Código</th>
                  <th>Teléfono</th>
                  <th>Nit</th>
                  <th>Dirección</th>
                  <th>Departamento</th>
                  <th>Municipio</th>
                  <th>Aldea</th>
                  <th>Ruta</th>
                  <th>Dueño</th>
                  <th>Encargado</th>
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
