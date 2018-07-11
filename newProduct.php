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
        Productos
        <small>llena el formulario para crear un nuevo producto</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Crear Producto</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <div class="modal fade" id="modal-category">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Nueva Categoría</h4>
                </div>
                <div class="modal-body">
                  <form role="form" id="form-category" name="form-category" method="post" action="BLL/category.php">
                    <div class="form-group">
                      <span class="text-danger text-uppercase">*</span>
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Escriba el nombre" autofocus>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="categoria" value="nueva">
                      <button id="catClose" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                      <span class="text-warning"> Debe llenar los campos obligatorios *</span>
                      <button type="submit" class="btn btn-primary" id="crear-categoria">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>

          <div class="row">
            <div class="col-md-6">
              <form role="form" id="form-product" name="form-product" method="post" action="BLL/product.php">
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Escriba un nombre..." autofocus>
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="codigo">Código</label>
                  <input type="text" class="form-control" id="code" name="code" placeholder="Escriba un código...">
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="costo">Costo</label>
                  <input type="text" class="form-control" id="cost" name="cost" placeholder="Escriba un costo...">
                </div>
                <div class="form-group">
                  <span class="text-danger text-uppercase">*</span>
                  <label for="descripcion">Descripción</label>
                  <textarea class="form-control" rows="3" id="description" name="description" placeholder="Escriba la descripción del producto... "></textarea>
                </div>
            </div>
            <!-- /.form-group -->
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">

                <span class="text-danger text-uppercase">*</span>
                <label>Categoría</label>
                <li class="pull-right">
                  <button type="button" class="btn btn-Normal bg-teal-active btn-xs" data-toggle="modal" data-target="#modal-category">+ Crear Nueva</button>
                </li>
                <select id="category" name="category" class="form-control select2" style="width: 100%;">
                    <option value="" disabled selected>Seleccione una categoría</option>
                  </select>
              </div>
              <div class="form-group">
                <span class="text-danger text-uppercase">*</span>
                <label>Unidad</label>
                <select id="rol" name="rol" class="form-control select2" style="width: 100%;">
                  <option value="" disabled selected>Seleccione el Rol</option>
                  <option value=1>Administrador</option>
                  <option value=2>Consultor</option>
                </select>
              </div>
              <div class="form-group">
                <span class="text-danger text-uppercase">*</span>
                <label>Marca</label>
                <select id="rol" name="rol" class="form-control select2" style="width: 100%;">
                  <option value="" disabled selected>Seleccione el Rol</option>
                  <option value=1>Administrador</option>
                  <option value=2>Consultor</option>
                </select>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="producto" value="nuevo">
                <button type="submit" class="btn btn-info" id="crear-producto">
                  <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                <span class="text-warning"> Debe llenar los campos obligatorios *</span>
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