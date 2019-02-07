  <?php
include_once 'funciones/sesiones.php';
include_once 'templates/header.php';
?>

  <body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
      <?php
include_once 'templates/navBar.php';
include_once 'templates/sideBar.php';
include_once 'funciones/bd_conexion.php';
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  <i class="glyphicon glyphicon-tags"></i> Ventas
                  <small>Listado de ventas canceladas en su totalidad</small>
              </h1>
          </section>

          <!-- Main content -->
          <section class="content">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="box">
                          <div class="box-header">
                              <h3 class="box-title">Listado de ventas canceladas</h3>
                          </div>

                          <!-- MODAL DETALLES -->
                          <div class="modal fade" id="modal-detailS">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          <h4 class="modal-title">
                                              <li class="glyphicon glyphicon-list-alt"></li> Detalle de la Venta
                                          </h4>
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
                                                              <th>Precio/u</th>
                                                              <th>Descuento</th>
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
                                                              <th>Precio/u</th>
                                                              <th>Descuento</th>
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

                          <!-- MODAL BALANCES -->
                          <div class="modal fade" id="modal-balance">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button id="correlativeCloseB" type="button" class="close"
                                              data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          <h4 class="modal-title"><i class="fa fa-balance-scale"></i> Balance de Saldos
                                          </h4>
                                      </div>
                                      <div class="modal-body">
                                          <!-- /.box-body -->
                                          <div class="box box-primary">
                                              <div class="box-header">
                                                  <h3 class="box-title">
                                                      <i class="fa fa-history"></i> Historial</h3>
                                              </div>
                                              <!-- /.box-header -->
                                              <div class="box-body table-responsive no-padding">
                                                  <table id="detallesB"
                                                      class="table table-bordered table-striped product-add">
                                                      <thead>
                                                          <tr>
                                                              <th>Fecha</th>
                                                              <th>Recibo No°</th>
                                                              <th>Tipo</th>
                                                              <th>Documento No°</th>
                                                              <th>Monto</th>
                                                              <th>Saldo</th>
                                                              <th>Anular</th>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>

                                                  </table>
                                                  <!-- /.box-body -->
                                              </div>
                                          </div>
                                          <br>
                                          <div class="box box-danger">
                                              <div class="box-header">
                                                  <h3 class="box-title">
                                                      <i class="fa fa-ban"></i> Pagos Anulados</h3>
                                              </div>
                                              <!-- /.box-header -->
                                              <div class="box-body table-responsive no-padding">
                                                  <table id="anuladosB"
                                                      class="table table-bordered table-striped product-add">
                                                      <thead>
                                                          <tr>
                                                              <th>Fecha</th>
                                                              <th>Recibo No°</th>
                                                              <th>Tipo</th>
                                                              <th>Documento No°</th>
                                                              <th>Monto</th>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>
                                                  </table>
                                                  <!-- /.box-body -->
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- /.modal-content -->

                          <!-- MODAL IMPRIMIR -->
                          <div class="modal fade" id="modal-printS">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button onclick="recargarPagina();" type="button" class="close"
                                              data-dismiss="modal" aria-label="Close">
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
                                              <div id="divreporteL" class="w3-rest">
                                                  <iframe src=""
                                                      style="width: 100%; height: 700px; min-width: 300px;"></iframe>
                                              </div>
                                              <!-- /.box-body -->
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
                                          <th>Remision No°</th>
                                          <th>Vendedor</th>
                                          <th>Cliente</th>
                                          <th>Fecha de vencimiento</th>
                                          <th>Método de pago</th>
                                          <th>Envío No°</th>
                                          <th>Anticipo</th>
                                          <th>Total</th>
                                          <th>Acciones <i class="fa fa-cogs"></i></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
try {
    $sql = "SELECT S.*,
                    (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
                    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer
                    FROM sale S WHERE S.cancel = 1 ORDER BY S.dateStart DESC";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($sale = $resultado->fetch_assoc()) {
    $dateStar = date_create($sale['dateStart']);
    $dateEnd = date_create($sale['dateEnd']);
    ?>
                                      <tr>
                                          <td>
                                              <?php echo date_format($dateStar, 'd/m/y'); ?>
                                          </td>
                                          <td>
                                                <?php echo $sale['noDeliver']; ?>
                                          </td>
                                          <td>
                                              <?php echo $sale['seller']; ?>
                                          </td>
                                          <td>
                                              <?php echo $sale['customer']; ?>
                                          </td>
                                          <td>
                                              <?php echo date_format($dateEnd, 'd/m/y'); ?>
                                          </td>
                                          <td>
                                              <?php echo $sale['paymentMethod']; ?>
                                          </td>
                                          <td>
                                              <?php echo $sale['noShipment'] . "___ " . $sale['note']; ?>
                                          </td>
                                          <td>Q.<?php echo $sale['advance']; ?>
                                          </td>
                                          <td>Q.<?php echo $sale['totalSale']; ?>
                                          </td>
                                          <td>
                                              <div class="btn-group-vertical no-margin">
                                                  <button type="button" class="btn btn-success btn-sm detalle_sale"
                                                      data-id="<?php echo $sale['idSale']; ?>"
                                                      data-tipo="listDetailS"><i class="fa fa-info"></i>
                                                      Detalles</button>
                                                  <button type="button" class="btn btn-primary btn-sm detalle_balanceC"
                                                      data-id="<?php echo $sale['idSale']; ?>"
                                                      data-tipo="listBalance"><i class="fa fa-balance-scale"></i>
                                                      Balance</button>
                                                  <div class="btn-group">
                                                      <button type="button"
                                                          class="btn bg-teal-active btn-sm dropdown-toggle"
                                                          data-toggle="dropdown" aria-expanded="true">
                                                          <span><i class="fa fa-print"></i> Imprimir</span>
                                                      </button>
                                                      <ul class="dropdown-menu">
                                                          <li><a
                                                                  href="printSale.php?id=<?php echo $sale['idSale']; ?>">Factura</a>
                                                          </li>
                                                          <?php
if ($_SESSION['rol'] == 1) {?>
                                                          <li><a href="#"
                                                                  onclick="imprimir('remision',<?php echo $sale['idSale']; ?>);">Remision</a>
                                                          </li>
                                                          <?php }?>
                                                          <li><a href="#"
                                                                  onclick="imprimir('guia',<?php echo $sale['idSale']; ?>);">Guía</a>
                                                          </li>
                                                      </ul>
                                                  </div>
                                              </div>
                                          </td>
                                      </tr>
                                      <?php }
?>
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Fecha</th>
                                          <th>Remision No°</th>
                                          <th>Vendedor</th>
                                          <th>Cliente</th>
                                          <th>Fecha de vencimiento</th>
                                          <th>Método de pago</th>
                                          <th>Envío No°</th>
                                          <th>Anticipo</th>
                                          <th>Total</th>
                                          <th>Acciones <i class="fa fa-cogs"></i></th>
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