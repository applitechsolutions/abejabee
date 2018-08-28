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
        <i class="glyphicon glyphicon-tags"></i>
        ventas
        <small>Listado de ventas</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de ventas</h3>
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
                    <th>No. de factura</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Fecha de vencimiento</th>
                    <th>Método de pago</th>
                    <th>Transporte</th>
                    <th>No. de envio</th>
                    <th>No. de entrega</th>
                    <th>Anticipo</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  try{
                    $sql = "SELECT S.*,
                    (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
                    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer
                    FROM sale S WHERE S.cancel = 0";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
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
                        <?php echo $sale['serie'].' '.$sale['noBill']; ?>
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
                        <?php echo $sale['transport']; ?>
                      </td>
                      <td>
                        <?php echo $sale['noShipment']; ?>
                      </td>
                      <td>
                        <?php echo $sale['noDeliver']; ?>
                      </td>
                      <td>Q
                        <?php echo $sale['advance']; ?>
                      </td>
                      <td>Q
                        <?php echo $sale['totalSale']; ?>
                      </td>
                    </tr>
                    <?php }
                ?>
                </tbody>
                <tfoot>
                  <tr>
                  <th>Fecha de inicio</th>
                    <th>No. de factura</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Fecha de vencimiento</th>
                    <th>Método de pago</th>
                    <th>Transporte</th>
                    <th>No. de envio</th>
                    <th>No. de entrega</th>
                    <th>Anticipo</th>
                    <th>Total</th>
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