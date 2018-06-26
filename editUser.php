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
        Usuarios
        <small>cambia los datos del usuario</small>
      </h1>
    </section>

    <div class="row">
      <div class="col-md-8">
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Usuario</h3>
            </div>
            <div class="box-body">
            <?php
              $sql = "SELECT * FROM `user` WHERE `idUser` = $id ";
              $resultado = $conn->query($sql);
              $user = $resultado->fetch_assoc();
            ?>
              <form role="form" id="form-usuario" name="form-usuario" method="post" action="BLL/user.php">
                <div class="box-body">
                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe tu nombre" value="<?php echo $user['firstName']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Escribe tu apellido" value="<?php echo $user['lastName']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Rol</label>
                    <select id="rol" name="rol" class="form-control">
                      <option value="" disabled selected>Seleccione el Rol</option>
                      <?php 
                        if ($user['permissions'] == '1') {?>
                          <option selected value=1>Administrador</option>
                          <option value=2>Consultor</option><?php 
                        }else if ($user['permissions'] == '2') {?>
                          <option value=1>Administrador</option>
                          <option selected value=2>Consultor</option><?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <input type="hidden" name="registro" value="actualizar">
                  <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                  <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
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
