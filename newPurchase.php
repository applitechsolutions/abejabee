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
        <i class="fa fa-shopping-cart"></i>
        Compras
        <small>Llene el formulario para realizar una nueva compra a los proveedores</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Nueva compra</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <!-- MODAL PRODUCTS -->
          <div class="modal fade" id="modal-products">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Catálogo Disponible</h4>
                </div>
                <div class="modal-body">
                  <div class="box box-success">
                    <div class="box-header">
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                      <table id="registros" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Marca</th>
                            <th>Unidad</th>
                            <th>Costo/u</th>
                            <th>Cantidad</th>
                            <th>Agregar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                              try{
                                $sql = "SELECT idProduct, productName, productCode, cost, description, picture,
                                (select makeName from make where idMake = P._idMake and state = 0) as make,
                                (select catName from category where idCategory = P._idCategory and state = 0) as category,
                                (select unityName from unity where idUnity = P._idUnity and state = 0) as unity
                                FROM product P WHERE state = 0";
                                $resultado = $conn->query($sql);
                              } catch (Exception $e){
                                $error= $e->getMessage();
                                echo $error;
                              }
                              
                              while ($product = $resultado->fetch_assoc()) {
                            ?>
                            <tr>
                              <td>
                                <img src="img/products/<?php echo $product['picture']; ?>" width="80" onerror="this.src='img/products/notfound.jpg';">
                              </td>
                              <td>
                                <div class="margin">
                                  <?php echo $product['productName']; ?>
                                </div>
                              </td>
                              <td>
                                <div class="margin">
                                  <?php echo $product['productCode']; ?>
                                </div>
                              </td>
                              <td>
                                <div class="margin">
                                  <?php echo $product['make']; ?>
                                </div>
                              </td>
                              <td>
                                <div class="margin">
                                  <?php echo $product['unity']; ?>
                                </div>
                              </td>
                              <td>
                                <div class="margin">Q
                                  <?php echo $product['cost']; ?>
                                </div>
                              </td>
                              <td>
                                <input class="col-xs-4 margin" type="text">
                              </td>
                              <td>
                                <a href="#" data-id="<?php echo $product['idProduct']; ?>" data-tipo="product" class="btn bg-green btn-flat margin agregar_producto"><i class="fa fa-shopping-cart"></i></a>
                              </td>
                            </tr>
                            <?php }
                            ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Marca</th>
                            <th>Unidad</th>
                            <th>Costo</th>
                            <th>Cantidad</th>
                            <th>Agregar</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <div class="modal-footer">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>

          <div class="row">
            <div class="col-md-12">
              <form role="form" id="form-purchase" name="form-purchase" method="post" action="BLL/purchase.php">
                <div class="box-body">
                  <div class="row">

                    <div class="col-lg-3">
                      <div class="form-group">
                        <span class="text-danger text-uppercase">*</span>
                        <label>Fecha</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="datepicker" name="date">
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <span class="text-danger text-uppercase">*</span>
                        <label>Proveedor</label>
                        <select id="provider" name="provider" class="form-control select2" style="width: 100%;" value="0">
                          <option value="" selected>Seleccione un proveedor</option>
                          <?php
                                try {
                                  $sql = "SELECT * FROM provider";
                                  $resultado = $conn->query($sql);
                                  while ($pro_purchase = $resultado->fetch_assoc()) {?>
                            <option value="<?php echo $pro_purchase['idProvider']; ?>">
                              <?php echo $pro_purchase['providerName']; ?>
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

                  <div class="row">

                    <div class="form-group col-lg-3">
                      <label for="noBill">No. de factura</label>
                      <input type="text" class="form-control" id="noBill" name="noBill" placeholder="Escriba un número de factura">
                    </div>

                    <div class="form-group col-lg-2">
                      <label for="serie">Serie</label>
                      <input type="text" class="form-control" id="serie" name="serie" placeholder="Escriba una serie">
                    </div>

                    <div class="form-group col-lg-4">
                      <label for="noDocument">No. de documento</label>
                      <input type="text" class="form-control" id="noDocument" name="noDocument" placeholder="Escriba un número de documento">
                    </div>

                    <div class="form-group col-lg-3">
                      <label for="addProducts">Productos</label>
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-products">
                        <i class="fa fa-search" aria-hidden="true"></i> Buscar Productos</button>
                    </div>
                  </div>
                  <div class="box box-primary">
                    <div class="box-header">
                      <h3 class="box-title">Detalle de compra</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                      <table id="agregados" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Marca</th>
                            <th>Categoría</th>
                            <th>Unidad</th>
                            <th>Costo/u</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Quitar</th>
                          </tr>
                        </thead>
                        <tbody>
                        <td><a href="#" data-id="11" class="btn bg-maroon btn-flat margin quitar_product"><i class="fa fa-remove"></i></a></td>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <div class="box-footer">
                    <div class="row">
                      <div class="form-group col-lg-3 pull-right">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <span class="text-danger text-uppercase">*</span>
                            <label for="totalPurchase" class="control-label">Total: Q </label>
                          </span>
                          <input type="number" id="totalPurchase" name="totalPurchase" placeholder="0.00" min="0.00" step="0.01" class="form-control">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-lg-6 pull-right">
                        <input type="hidden" name="producto" value="nuevo">
                        <span class="text-warning">Debe llenar los campos obligatorios *</span>
                        <button type="submit" class="btn btn-primary pull-right" id="crear-producto">
                          <i class="fa fa-floppy-o" aria-hidden="true"></i> Confirmar compra</button>
                      </div>
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