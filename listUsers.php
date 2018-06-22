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
        Blank page
        <small>it all starts here</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="registros" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Nombre de Usuario</th>
                  <th>Permisos</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  try{
                    $sql = "SELECT idUser, firstName, lastName, userName, permissions FROM user";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($user = $resultado->fetch_assoc()) {
                ?>
                    <tr>
                      <td><?php echo $user['firstName']; ?></td>
                      <td><?php echo $user['lastName']; ?></td>
                      <td><?php echo $user['userName']; ?></td>
                      <?php if ($user['permissions'] == '1') {
                        ?><td>Administrador</td><?php
                      }else if ($user['permissions'] == '2'){
                        ?><td>Consultor</td><?php
                      }   ?>
                      <td>
                        <a class="btn bg-green btn-flat margin" href="editUser.php?id=<?php echo $user['idUser'] ?>"><i class="fa fa-pencil"></i></a>
                        <a href="#" data-id="<?php echo $user['idUser']; ?>" data-tipo="admin" class="btn bg-maroon btn-flat margin borrar_registro"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                <?php }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Nombre de Usuario</th>
                  <th>Permisos</th>
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
