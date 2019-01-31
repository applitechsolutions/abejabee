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
        <small>Listado de Compras</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de compras</h3>
            </div>

<!-- MODAL IMPRIMIR COMPRA -->
<div class="modal fade" id="modal-printP">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">
                                    <li class="glyphicon glyphicon-print"></li> Imprimir
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="box box-info">
                                    <div class="box-header">
                                    </div>
                                    <!-- /.box-header -->
                                    <div id="divreporteP" class="w3-rest">
                                        <iframe src="" style="width: 100%; height: 700px; min-width: 300px;"></iframe>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>

            <!-- MODAL PRODUCTS -->
            <div class="modal fade" id="modal-detail">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Detalle de la Compra</h4>
                  </div>
                  <div class="modal-body">
                    <div class="box box-success">
                      <div class="box-header">
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body table-responsive no-padding">
                        <table id="detalles" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Imagen</th>
                              <th>Nombre</th>
                              <th>Código</th>
                              <th>Cantidad</th>
                              <th>Costo/u</th>
                              <th>SubTotal</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>Imagen</th>
                              <th>Nombre</th>
                              <th>Código</th>
                              <th>Cantidad</th>
                              <th>Costo/u</th>
                              <th>SubTotal</th>
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

            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="registros" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Factura</th>
                    <th>Serie</th>
                    <th>Documento de Pago</th>
                    <th>Total</th>
                    <th>Detalle</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  try{
                    $sql = "SELECT idPurchase, datePurchase, noBill, serie, noDocument, totalPurchase,
                    (SELECT providerName FROM provider WHERE idProvider = P._idProvider and state = 0) as proveedor FROM purchase P ORDER BY datePurchase DESC";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($purchase = $resultado->fetch_assoc()) {
                    $fecha = date_create($purchase['datePurchase']);
                ?>
                    <tr>
                      <td>
                        <?php echo date_format($fecha, 'd/m/Y'); ?>
                      </td>
                      <td>
                        <?php echo $purchase['proveedor']; ?>
                      </td>
                      <td>
                        <?php echo $purchase['noBill']; ?>
                      </td>
                      <td>
                        <?php echo $purchase['serie']; ?>
                      </td>
                      <td>
                        <?php echo $purchase['noDocument']; ?>
                      </td>
                      <td>Q.
                        <?php echo $purchase['totalPurchase']; ?>
                      </td>
                      <td>
                        <a href="#" data-id="<?php echo $purchase['idPurchase']; ?>" data-tipo="listDetailP" class="btn bg-orange btn-flat margin detalle_purchase">
                          <i class="fa fa-info"></i>
                        </a>
                        <a onclick="imprimirP('compra',<?php echo $purchase['idPurchase']; ?>);" class="btn btn-info btn-flat margin">
                        <i class="fas fa-print"></i>
                        </a>
                      </td>
                    </tr>
                    <?php }
                ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Factura</th>
                    <th>Serie</th>
                    <th>Documento de Pago</th>
                    <th>Total</th>
                    <th>Detalle</th>
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