<?php
include_once 'funciones/sesiones.php';
include_once 'templates/header.php';
?>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
<?php
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
          <i class="glyphicon glyphicon-tags"></i>
          Ventas
          <small>Llene el formulario para editar la venta seleccionada</small>
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Editar Venta</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <?php
              $sql = "SELECT * FROM `sale` WHERE `idSale` = $id ";
              $resultado = $conn->query($sql);
              $sale = $resultado->fetch_assoc();
              ?>

            <!-- MODAL CORRELATIVO -->
            <div class="modal fade" id="modal-correlative">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                      <i class="glyphicon glyphicon-print" aria-hidden="true"></i> Correlativo de facturación</h4>
                  </div>
                  <div class="modal-body">
                    <form role="form" id="form-correlative" name="form-correlative" method="post" action="BLL/correlative.php">
                      <div class="row">
                        <?php
try {
    $sql = "SELECT * FROM correlative WHERE idCorrelative = 1";
    $resultado = $conn->query($sql);
    while ($correlative = $resultado->fetch_assoc()) {?>
                          <div class="form-group col-lg-6">
                            <span class="text-danger text-uppercase">*</span>
                            <label for="serieC">Serie</label>
                            <input type="text" class="form-control" id="serieC" name="serieC" value="<?php echo $correlative['serie']; ?>">
                          </div>
                          <div class="form-group col-lg-6">
                            <span class="text-danger text-uppercase">*</span>
                            <label for="last">Última factura ingresada</label>
                            <input type="text" class="form-control" id="last" name="last" value="<?php echo $correlative['last']; ?>">
                          </div>
                          <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="correlative" value="factura">
                        <button type="submit" class="btn btn-info pull-left" id="crear-correlativo">
                          <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                        <span class="text-warning w3-small w3-padding-small pull-left">*Debe llenar los campos obligatorios</span>
                        <button id="correlativeClose" type="button" class="btn btn-danger w3-round-medium pull-right" data-dismiss="modal">Cerrar</button>
                      </div>
                  </div>
                  </form>
                </div>
              </div>
              <!-- /.modal-dialog -->
            </div>

            <!-- /.modal-REMISION -->
            <div class="modal fade" id="modal-remi">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                      <i class="glyphicon glyphicon-print" aria-hidden="true"></i> Correlativo de guías de remision</h4>
                  </div>
                  <div class="modal-body">
                    <form role="form" id="form-correlative-guia" name="form-correlative-guia" method="post" action="BLL/correlative.php">
                      <div class="row">
                        <?php
try {
    $sql = "SELECT * FROM correlative WHERE idCorrelative = 11";
    $resultado = $conn->query($sql);
    while ($correlative = $resultado->fetch_assoc()) {?>
                          <div class="form-group col-lg-8">
                            <span class="text-danger text-uppercase">*</span>
                            <label for="last">Última guía de remision ingresada</label>
                            <input type="text" class="form-control" id="last" name="last" value="<?php echo $correlative['last']; ?>">
                          </div>
                          <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="correlative" value="guia">
                        <button type="submit" class="btn btn-info pull-left" id="crear-correlativo">
                          <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                        <span class="text-warning w3-small w3-padding-small pull-left">*Debe llenar los campos obligatorios</span>
                        <button id="correlativeCloseGuia" type="button" class="btn btn-danger w3-round-medium pull-right" data-dismiss="modal">Cerrar</button>
                      </div>
                  </div>
                  </form>
                </div>
              </div>
              <!-- /.modal-dialog -->
            </div>

            <!-- /.modal-noShipment -->
            <div class="modal fade" id="modal-noShipment">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                      <i class="glyphicon glyphicon-print" aria-hidden="true"></i> Correlativo de guías GuateEx</h4>
                  </div>
                  <div class="modal-body">
                    <form role="form" id="form-correlative-envio" name="form-correlative-envio" method="post" action="BLL/correlative.php">
                      <div class="row">
                        <?php
  try {
      $sql = "SELECT * FROM correlative WHERE idCorrelative = 21";
      $resultado = $conn->query($sql);
      while ($correlative = $resultado->fetch_assoc()) {?>
                          <div class="form-group col-lg-8">
                            <span class="text-danger text-uppercase">*</span>
                            <label for="last">Última guía de GuateEx generada</label>
                            <input type="text" class="form-control" id="last" name="last" value="<?php echo $correlative['last']; ?>">
                          </div>
                          <?php
  }
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
  }
  ?>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="correlative" value="envio">
                        <button type="submit" class="btn btn-info pull-left" id="crear-correlativo">
                          <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                        <span class="text-warning w3-small w3-padding-small pull-left">*Debe llenar los campos obligatorios</span>
                        <button id="correlativeCloseEnvio" type="button" class="btn btn-danger w3-round-medium pull-right" data-dismiss="modal">Cerrar</button>
                      </div>
                  </div>
                  </form>
                </div>
              </div>
              <!-- /.modal-dialog -->
            </div>

            <div class="row">
              <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active">
                      <a href="#tab_1" data-toggle="tab">
                        <i class="glyphicon glyphicon-shopping-cart"></i> Agregar</a>
                    </li>
                    <li>
                      <a id="a" href="#tab_2" data-toggle="tab">
                        <i class="glyphicon glyphicon-list-alt"></i> Detalles</a>
                    </li>
                    <li>
                      <a id="b" href="#tab_3" data-toggle="tab">
                        <i class="glyphicon glyphicon-download-alt"></i> Factura y Envío</a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                      <form role="form" id="form-sale" name="form-sale" method="post" action="BLL/sale.php">
                        <div class="box-body">
                          <div class="row">

                            <div class="col-lg-2">
                              <div class="form-group">
                                <span class="text-danger text-uppercase">*</span>
                                <label>Fecha</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <?php  $dateStar = date_create($sale['dateStart']); ?>
                                  <input type="text" class="form-control pull-right datepicker" id="datepicker" name="dateSale" value="<?php echo date_format($dateStar, 'd/m/Y'); ?>">
                                </div>
                              </div>
                            </div>

                            <div class="col-lg-3">
                              <div class="form-group">
                                <span class="text-danger text-uppercase">*</span>
                                <label>Fecha de vencimiento</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <?php  $dateEnd = date_create($sale['dateEnd']); ?>
                                  <input type="text" class="form-control pull-right datepicker" id="datepicker2" name="dateSaleEnd" value="<?php echo date_format($dateEnd, 'd/m/Y'); ?>">
                                </div>
                              </div>
                            </div>
                              <div class="form-group col-lg-1">
                                <label for="serie">Serie</label>
                                <input type="hidden" class="form-control" id="serieS1" name="serieS" value="<?php echo $sale['serie']; ?>">
                                <input type="text" class="form-control" id="serieS" name="serie" value="<?php echo $sale['serie']; ?>" disabled>
                              </div>

                              <div class="form-group col-lg-3">
                                <label for="noBill">No. de factura</label>
                                <div class="input-group">

                                  <input type="text" class="form-control" id="noBillS" name="noBill" value="<?php echo $sale['noBill']; ?>" disabled>
                                  <input type="hidden" class="form-control" id="noBillS1" name="noBillS" value="<?php echo $sale['noBill']; ?>">
                                  <div class="input-group-btn">
                                    <button type="button" class="btn bg-info" data-toggle="modal" data-target="#modal-correlative">
                                      <i class="glyphicon glyphicon-print" aria-hidden="true"></i>
                                      Correlativo
                                    </button>
                                  </div>
                                  <!-- /btn-group -->
                                </div>
                              </div>
                                  <div class="form-group col-lg-3">
                                    <label for="noRemi">No. de Guía de remision</label>
                                    <div class="input-group">
                                      <input type="text" class="form-control" id="noRemi1" name="noRemi1" value="<?php echo $sale['noDeliver']; ?>" disabled>
                                      <input type="hidden" class="form-control" id="noRemi" name="noRemi" value="<?php echo $sale['noDeliver']; ?>">
                                      <div class="input-group-btn">
                                        <button type="button" class="btn bg-info" data-toggle="modal" data-target="#modal-remi">
                                          <i class="glyphicon glyphicon-print" aria-hidden="true"></i>
                                          Correlativo
                                        </button>
                                      </div>
                                      <!-- /btn-group -->
                                    </div>
                                  </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-5">
                              <div class="form-group">
                                <span class="text-danger text-uppercase">*</span>
                                <label>Cliente</label>
                                <select id="customerS" name="customerS" class="form-control select2" style="width: 100%;" value="0">
                                  <option value="" selected>Seleccione un cliente</option>
                                  <?php
try {
    $cliente_actual = $sale['_idCustomer'];
    $sql = "SELECT idCustomer, customerName, customerCode FROM customer WHERE state = 0";
    $resultado = $conn->query($sql);
    while ($client_sale = $resultado->fetch_assoc()) {
     if ($client_sale['idCustomer'] == $cliente_actual) {?>
                                    <option value="<?php echo $client_sale['idCustomer']; ?>" selected>
                                      <?php echo $client_sale['customerCode'] . " " . $client_sale['customerName']; ?>
                                    </option>
                                    <?php
                            } else {?>
                            <option value="<?php echo $client_sale['idCustomer']; ?>">
                                      <?php echo $client_sale['customerCode'] . " " . $client_sale['customerName']; ?>
                                    </option>
                                    <?php
                                      }
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                </select>
                              </div>
                            </div>

                            <div class="col-lg-5">
                              <div class="form-group">
                                <span class="text-danger text-uppercase">*</span>
                                <label>Vendedor</label>
                                <select id="sellerS" name="sellerS" class="form-control select2" style="width: 100%;" value="0">
                                  <option value="" selected>Seleccione un vendedor</option>
                                  <?php
try {
    $vendedor_actual = $sale['_idSeller'];
    $sql = "SELECT idSeller, sellerCode, sellerFirstName, sellerLastName FROM seller WHERE state = 0";
    $resultado = $conn->query($sql);
    while ($seller_sale = $resultado->fetch_assoc()) {
    if ($seller_sale['idSeller'] == $vendedor_actual) {?>
                                    <option value="<?php echo $seller_sale['idSeller']; ?>" selected>
                                      <?php echo $seller_sale['sellerCode'] . " " . $seller_sale['sellerFirstName'] . " " . $seller_sale['sellerLastName']; ?>
                                    </option>
                                    <?php
                            } else {?>
                             <option value="<?php echo $seller_sale['idSeller']; ?>">
                                      <?php echo $seller_sale['sellerCode'] . " " . $seller_sale['sellerFirstName'] . " " . $seller_sale['sellerLastName']; ?>
                                    </option>
                                    <?php
                            }
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <br>


                        </div>
                        <div class="box box-success collapsed-box" id="box">
                          <div class="box-header with-border">

                            <h3 class="box-title">
                              <i class="glyphicon glyphicon-shopping-cart"></i> Productos en inventario</h3>

                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-info" data-widget="collapse">
                                <i class="fa fa-plus"></i> Buscar Productos
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <br>
                          <div class="box-body table-responsive no-padding">
                            <table id="registros" class="table table-bordered table-striped product-add">
                              <thead>
                                <tr>
                                  <th>Imagen</th>
                                  <th>Nombre</th>
                                  <th>Código</th>
                                  <th>Marca</th>
                                  <th>Unidad</th>
                                  <th>Costo Aprox.</th>
                                  <th>Precios de venta</th>
                                  <th>Desct.°</th>
                                  <th>
                                    <span class="pull-right">Cant.</span>
                                  </th>
                                  <th>Agregar</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
try {
    $sql = "SELECT idProduct, productName, productCode, cost, description, picture, S.stock,
    (select makeName from make where idMake = P._idMake and state = 0) as make,
    (select catName from category where idCategory = P._idCategory and state = 0) as category,
    (select unityName from unity where idUnity = P._idUnity and state = 0) as unity,
    (select price from priceSale where _idProduct = P.idProduct and _idPrice = 1) as public,
    (select price from priceSale where _idProduct = P.idProduct and _idPrice = 11) as pharma,
    (select price from priceSale where _idProduct = P.idProduct and _idPrice = 21) as business,
    (select price from priceSale where _idProduct = P.idProduct and _idPrice = 31) as bonus
    FROM product P INNER JOIN storage S ON S._idProduct = P.idProduct
    WHERE state = 0";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($product = $resultado->fetch_assoc()) {
    ?>
                                  <tr id="catalogo">
                                    <td>
                                      <img src="img/products/<?php echo $product['picture']; ?>" width="80" onerror="this.src='img/products/notfound.jpg';">
                                    </td>
                                    <td>
                                      <div class="margin">
                                        <?php echo $product['productName']." ".$product['description']; ?>
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
                                      <div class="margin">
                                        Q.
                                        <?php echo $product['cost'] ?>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="form-group margin">
                                        <input id="SelectPrecio<?php echo $product['idProduct']; ?>" class="form-control input-sm" type="number" min="0.00" step="0.01" value="<?php echo $product['pharma']; ?>" style="width: 50%;">
                                        <select id="SelectPrice<?php echo $product['idProduct']; ?>"  class="form-control select2 SelectPrice" style="width: 100%;" id-data="<?php echo $product['idProduct']; ?>">
                                         <option value="plus-square" selected="selected">Farmacia: Q.
                                            <?php echo $product['pharma']; ?>
                                          </option>
                                          <option value="users"> Público: Q.
                                            <?php echo $product['public']; ?>
                                          </option>
                                          <option value="briefcase">Negocio: Q.
                                            <?php echo $product['business']; ?>
                                          </option>
                                          <option value="money">Bono: Q.
                                            <?php echo $product['bonus']; ?>
                                          </option>
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <input class="form-control input-sm" type="number" id="new_<?php echo $product['idProduct']; ?>_descuentoS" name="descuento"
                                        min="0.00" step="0.01" value="0.00" style="width: 50%;">
                                    </td>
                                    <td>
                                      <input class="form-control input-sm" type="number" id="new_<?php echo $product['idProduct']; ?>_cantidadS" name="cantidadXD"
                                        min="1" step="1" value="1" max="<?php echo $product['stock']; ?>" style="width: 65%;">
                                      <p class="text-green max_<?php echo $product['idProduct']; ?>_stockP">Disp.
                                        <?php echo $product['stock']; ?>
                                      </p>
                                      <input class="max_<?php echo $product['idProduct']; ?>_stock" type="hidden" value="<?php echo $product['stock']; ?>">
                                    </td>
                                    <td>
                                      <input class="id_producto_agregar" type="hidden" value="<?php echo $product['idProduct']; ?>">
                                      <a id="boton" href="#" cost="" data-id="<?php echo $product['idProduct']; ?>" data-tipo="product" class="btn bg-green btn-lg margin agregar_productoS">
                                        <i class="fa fa-shopping-cart"></i>
                                      </a>
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
                                  <th>Costo Aprox.</th>
                                  <th>Precios de venta</th>
                                  <th>desct.°</th>
                                  <th>Cantidad</th>
                                  <th>Agregar</th>
                                </tr>
                              </tfoot>
                            </table>
                            <!-- /.box-body -->
                          </div>

                        </div>
                        <div class="box-footer">
                          <a onclick="tab2()" data-toggle="tab" class="btn btn-flat pull-right text-bold">
                            <i class="glyphicon glyphicon-forward"></i> Continuar con la venta...</a>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                      <br>
                      <div class="box box-success">
                        <div class="box-header with-border">
                          <h3 class="box-title">
                            <i class="glyphicon glyphicon-list-alt"></i> Detalle de venta</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                          <table id="agregadosS" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Marca</th>
                                <th>Categoría</th>
                                <th>Unidad</th>
                                <th>Costo/u</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                                <th>Quitar</th>
                              </tr> 
                              </thead>
                              <tbody>
                              <?php
                                try {
                                    $sql = "SELECT P.picture, P.idProduct, P.productName, P.productCode, P.cost,
                                      (select makeName from make where idMake = P._idMake and state = 0) as make,
                                      (select catName from category where idCategory = P._idCategory and state = 0) as category,
                                      (select unityName from unity where idUnity = P._idUnity and state = 0) as unity,
                                      (select price from priceSale where _idProduct = P.idProduct and _idPrice = 1) as public,
                                      (select price from priceSale where _idProduct = P.idProduct and _idPrice = 11) as pharma,
                                      (select price from priceSale where _idProduct = P.idProduct and _idPrice = 21) as business,
                                      (select price from priceSale where _idProduct = P.idProduct and _idPrice = 31) as bonus,
                                      D.priceS, D.quantity, D.discount
                                    from detailS D INNER JOIN product P ON D._idProduct = P.idProduct
                                    where _idSale = $id";
                                    $resultado = $conn->query($sql);                              
                                while ($detailS = $resultado->fetch_assoc()) {
                                  $subtotal = ($detailS['priceS'] - $detailS['discount']) * $detailS['quantity']; ?>
                              <tr id="detalleS">
                                <td><img src="img/products/<?php echo $detailS['picture']; ?>" width="80" onerror="this.src='img/products/notfound.jpg';"></td>
                                <td><input class="idproducto_class" type="hidden" value="<?php echo $detailS['idProduct']; ?>"><?php echo $detailS['productName']; ?></td>
                                <td><?php echo $detailS['productCode']; ?></td>
                                <td><?php echo $detailS['make']; ?></td>
                                <td><?php echo $detailS['category']; ?></td>
                                <td><?php echo $detailS['unity']; ?></td>
                                <td><input type="hidden" value="<?php echo $detailS['cost']; ?>">Q.<?php echo $detailS['cost']; ?></td>
                                <td><input class="precio_class" type="hidden" value="<?php echo $detailS['priceS']; ?>">Q.<?php echo $detailS['priceS']; ?></td>
                                <td><input class="cantidad_class" type="hidden" value="<?php echo $detailS['quantity']; ?>"><?php echo $detailS['quantity']; ?></td>
                                <td><input class="descuento_class" type="hidden" value="<?php echo $detailS['discount']; ?>">Q.<?php echo $detailS['discount']; ?></td>
                                <td>Q.<?php echo $subtotal; ?></td>
                                <td><a id="quitar" onclick="eliminarS(<?php echo $detailS['idProduct']; ?>);" data-id-detalle="<?php echo $detailS['idProduct']; ?>"
                                    class="btn bg-maroon btn-flat margin quitar_product"><i class="fa fa-remove"></i></a></td>
                              </tr>
                              <?php
                                }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>                       
                            </tbody>
                          </table>
                        </div>
                        <br>
                        <div class="box-footer">
                          <div class="row">
                            <div class="form-group col-lg-6 pull-right">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <span class="text-danger text-uppercase">*</span>
                                  <label for="totalSale" class="control-label">Total:</label>
                                  <span>
                                    <h5 id="totalSale" class="text-bold">Q.<?php echo $sale['totalSale']; ?></h5>
                                  </span>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-3">
                              <span class="text-danger text-uppercase">*</span>
                              <label for="noBill">Método de pago</label>
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="glyphicon glyphicon-credit-card"></i>
                                </span>
                                <input type="text" class="form-control" id="payment" name="payment" value="<?php echo $sale['paymentMethod']; ?>">
                              </div>
                            </div>
                            <div class="form-group col-lg-3">
                              <label for="costo">Anticipo</label>
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-money"></i>
                                </span>
                                <input type="number" id="advance" name="advance" placeholder="0.00" min="0.00" step="0.01" class="form-control" value="<?php echo $sale['advance']; ?>">
                              </div>
                            </div>
                            <div class="form-group col-lg-6">
                              <span class="text-danger text-uppercase">*</span>
                              <label for="note">Nota: </label>
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-sticky-note"></i>
                                </span>
                                <input type="text" class="form-control" id="note" name="note" value="<?php echo $sale['note']; ?>">
                              </div>
                            </div>
                            <div class="form-group col-lg-6 pull-right">
                              <input type="hidden" name="venta" value="editar">
                              <input type="hidden" name="id_sale" value="<?php echo $id; ?>">
                              <input type="hidden" id="totalS" name="totalS" value="<?php echo $sale['totalSale']; ?>">
                              <span class="text-warning">Debe llenar los campos obligatorios* </span>
                              <button type="button" class="btn btn-primary" id="crear-venta">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Confirmar venta</button>
                            </div>
                          </div>                 
                        </div>
                        </form>
                        <!-- /.box-body -->
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                      <br>
                      <div class="row">
                        <div class="col-md-6">

                          <div class="box box-warning">
                            <div class="box-header">
                              <h3 class="box-title">
                                <i class="fa fa-print"></i> Factura y Guía de remision</h3>
                                <a class="btn btn-app pull-right" href="#" onclick="generarFactura();">
                                <i class="glyphicon glyphicon-save-file"></i> Generar Factura
                              </a>
                            </div>
                            <div class="box-body">
                              <div id="divreporteF" class="w3-rest">
                                <iframe src="" style="width: 100%; height: 640px; min-width: 300px;"></iframe>
                              </div>                              
                            </div>
                            <!-- /.box-body -->
                          </div>
                        </div>
                        <div class="col-md-6">

                          <div class="box box-warning">
                            <div class="box-header">
                              <h3 class="box-title">
                                <i class="fa fa-truck"></i> Envío</h3>
                            </div>
                            <div class="box-body">
                              <form role="form" id="form-envio" name="form-envio" method="post" action="BLL/sale.php">
                              <div class="row">
                                <div class="form-group col-md-6">
                                  <label for="transport">Transporte</label>
                                  <input type="text" class="form-control" id="transport" name="transport" placeholder="Escriba un transporte" value="<?php echo $sale['transport']; ?>" autofocus>
                                </div>
                                  <div class="form-group col-md-6">
                                    <label for="noShipment">No. de envío</label>
                                    <div class="input-group">
                                      <input type="text" class="form-control" id="noShipment1" name="noShipment1" value="<?php echo $sale['noShipment']; ?>"
                                        disabled>
                                      <input type="hidden" class="form-control" id="noShipment" name="noShipment" value="<?php echo $sale['noShipment']; ?>">
                                      <div class="input-group-btn">
                                        <button type="button" class="btn bg-info" data-toggle="modal" data-target="#modal-noShipment">
                                          <i class="glyphicon glyphicon-print" aria-hidden="true"></i>
                                          Correlativo
                                        </button>
                                      </div>
                                      <!-- /btn-group -->
                                    </div>
                                  </div>
                                    <div class="form-group col-md-6">
                                      <label for="noDeliver">No. de entrega</label>
                                      <input type="text" class="form-control" id="noDeliver" name="noDeliver" placeholder="Escriba un número de entrega" value="<?php echo $sale['noShipment']; ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                      <label for="">Tipo de envío:</label>
                                      <br>
                                      <span class="text-warning"><small>*Si no ingresa un número de entrega se almacenará el número de envio</small></span>
                                    </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                      <input type="hidden" name="venta" value="envio">
                                      <input type="hidden" id="idSale" name="idSale" value="">
                                      <button type="submit" class="btn btn-primary pull-left" id="crear-envio">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                                      <span class="text-warning"> *Debe llenar los campos obligatorios </span>
                                    </div>
                              </form>
                            </div>
                            <div id="divreporteE" class="w3-rest">
                              <iframe src="" style="width: 100%; height: 470px; min-width: 300px;"></iframe>
                            </div>
                          </div>
                          <!-- /.box-body -->
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- nav-tabs-custom -->
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php
include_once 'templates/footer.php';
?>