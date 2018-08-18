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
        <small>llene el formulario para crear un nuevo cliente</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Crear Clientes</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <!-- MODAL departamento -->
          <div class="modal fade" id="modal-departamento">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Nuevo Departamento</h4>
                </div>
                <div class="modal-body">
                  <form role="form" id="form-departament" name="form-departamento" method="post" action="BLL/department.php">
                    <div class="form-group">
                      <span class="text-danger text-uppercase">*</span>
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Escriba un nombre" autofocus>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="departamento" value="nuevo">
                      <button type="submit" class="btn btn-info" id="crear-departamento">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                      <span class="text-warning w3-small w3-padding">*Debe llenar los campos obligatorios</span>
                      <button id="depaClose" type="button" class="btn btn-danger w3-round-medium pull-right" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>

          <!-- MODAL municipio -->
          <div class="modal fade" id="modal-muni">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Nuevo Municipio</h4>
                </div>
                <div class="modal-body">
                  <form role="form" id="form-muni" name="form-muni" method="post" action="BLL/town.php">
                    <div class="form-group">
                      <span class="text-danger text-uppercase">*</span>
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Escriba el nombre del municipio" autofocus>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="muni" value="nuevo">
                      <button type="submit" class="btn btn-info" id="crear-muni">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                      <span class="text-warning w3-small w3-padding-small">*Debe llenar los campos obligatorios</span>
                      <button id="muniClose" type="button" class="btn btn-danger w3-round-medium pull-right" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>

          <!-- MODAL aldea -->
          <div class="modal fade" id="modal-aldea">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Nueva aldea</h4>
                </div>
                <div class="modal-body">
                  <form role="form" id="form-aldea" name="form-aldea" method="post" action="BLL/village.php">
                    <div class="form-group">
                      <span class="text-danger text-uppercase">*</span>
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Escriba el nombre de la aldea" autofocus>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="aldea" value="nuevo">
                      <button type="submit" class="btn btn-info" id="crear-aldea">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                      <span class="text-warning w3-small w3-padding-small">*Debe llenar los campos obligatorios</span>
                      <button id="aldClose" type="button" class="btn btn-danger w3-round-medium pull-right" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>

          <div class="row">
            <div class="col-md-6">
              <form role="form" id="form-cliente" name="form-cliente" method="post" action="BLL/customer.php" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span>
                    <label for="codigo">Código</label>
                    <input type="text" class="form-control" id="code" name="code" placeholder="Escriba un código">
                  </div>
                  <div class="form-group">
                    <span class="text-danger text-uppercase">*</span>
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Escriba un nombre" autofocus>
                  </div>
                  <div class="form-group">
                    <label for="tel">Teléfono</label>
                    <input type="text" class="form-control" id="tel" name="tel" placeholder="Escriba el número de teléfono">
                  </div>
                  <div class="form-group">
                    <label for="nit">Nit</label>
                    <input type="text" class="form-control" id="nit" name="nit" placeholder="Escriba el número de Nit">
                  </div>
                  <div class="form-group">
                    <label for="owner">Dueño</label>
                    <input type="text" class="form-control" id="owner" name="owner" placeholder="Escriba el nombre del dueño">
                  </div>
                  <div class="form-group">
                    <label for="incharge">Encargado</label>
                    <input type="text" class="form-control" id="incharge" name="incharge" placeholder="Escriba el nombre del encargado">
                  </div>
                </div>
            </div>
            <!-- /.form-group -->
            <!-- /.col -->
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label>Ruta</label>
                  <select id="ruta" name="ruta" class="form-control select2" style="width: 100%;">
                    <option value="" selected>Seleccione una ruta</option>
                    <?php
                    try {
                        $sql = "SELECT * FROM route WHERE state = 0";
                        $resultado = $conn->query($sql);
                        while ($rut_customer = $resultado->fetch_assoc()) {?>
                                      <option value="<?php echo $rut_customer['idRoute']; ?>">
                                        <?php echo $rut_customer['routeName']; ?>
                                      </option>
                                      <?php
                    }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                  </select>
                </div>
                <br>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <span class="text-danger text-uppercase">*</span>
                    <h4 class="box-title">Dirección del Cliente</h4>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="form-group">
                        <input type="text" class="form-control" id="dir" name="dir" placeholder="Escriba la dirección del cliente">
                      </div>
                      <div class="form-group">
                        <span class="text-danger text-uppercase">*</span>
                        <label>Departamento</label>
                        <button type="button" class="btn btn-Normal bg-teal-active btn-xs pull-right" data-toggle="modal" data-target="#modal-departamento">+ Crear Nuevo</button>
                        <select id="departamento" name="departamento" class="form-control select2" style="width: 100%;">
                          <option value="" selected>Seleccione un departamento</option>
                          <?php
      try {
          $sql = "SELECT * FROM deparment";
          $resultado = $conn->query($sql);
          while ($depa_customer = $resultado->fetch_assoc()) {?>
                            <option value="<?php echo $depa_customer['idDeparment']; ?>">
                              <?php echo $depa_customer['name']; ?>
                            </option>
                            <?php
      }
      } catch (Exception $e) {
          echo "Error: " . $e->getMessage();
      }
      ?>
                        </select>
                      </div>
                      <br>
                      <div class="form-group">
                        <span class="text-danger text-uppercase">*</span>
                        <label>Municipio</label>
                        <button type="button" class="btn btn-Normal bg-teal-active btn-xs pull-right" data-toggle="modal" data-target="#modal-muni">+ Crear Nuevo</button>
                        <select id="muni" name="muni" class="form-control select2" style="width: 100%;">
                          <option value="" selected>Seleccione un municipio</option>
                          <?php
      try {
          $sql = "SELECT * FROM town";
          $resultado = $conn->query($sql);
          while ($town_customer = $resultado->fetch_assoc()) {?>
                            <option value="<?php echo $town_customer['idTown']; ?>">
                              <?php echo $town_customer['name']; ?>
                            </option>
                            <?php
      }
      } catch (Exception $e) {
          echo "Error: " . $e->getMessage();
      }
      ?>
                        </select>
                      </div>
                      <br>
                      <div class="form-group">
                        <span class="text-danger text-uppercase">*</span>
                        <label>Aldea</label>
                        <button type="button" class="btn btn-Normal bg-teal-active btn-xs pull-right" data-toggle="modal" data-target="#modal-aldea">+ Crear Nueva</button>
                        <select id="aldea" name="aldea" class="form-control select2" style="width: 100%;">
                          <option value="" selected>Seleccione una aldea</option>
                          <?php
      try {
          $sql = "SELECT * FROM village";
          $resultado = $conn->query($sql);
          while ($villa_customer = $resultado->fetch_assoc()) {?>
                            <option value="<?php echo $villa_customer['idVillage']; ?>">
                              <?php echo $villa_customer['name']; ?>
                            </option>
                            <?php
      }
      } catch (Exception $e) {
          echo "Error: " . $e->getMessage();
      }
      ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="customer" value="nuevo">
                <button type="submit" class="btn btn-primary" id="crear-customer">
                  <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                <span class="w3-text-orange w3-padding">*Debe llenar los campos obligatorios</span>
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