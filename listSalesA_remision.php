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
                <i class="fas fa-receipt"></i> Remisiones
                <small>Listado de ventas activas con saldo pendiente de cancelar</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Listado de ventas activas</h3>
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
                                        <?php
if ($_SESSION['rol'] == 1) {?>
                                        <div id="anularV" class="modal-footer">
                                        </div>
                                        <?php
}?>

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
                                        <button id="correlativeCloseB" type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title"><i class="fa fa-balance-scale"></i> Balance de Saldos
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" id="form-pay" name="form-pay" method="post"
                                            action="BLL/balance.php" autocomplete="off">
                                            <div class="row">
                                                <div class="alert alert-info alert-dismissible col-md-5 pull-left">
                                                    <div id="days"></div>
                                                    <p id="infoComi"></p>
                                                </div>
                                                <div class="col-md-3 pull-left">
                                                    <br>
                                                    <br>
                                                    <div class="form-group">
                                                        <span class="text-danger text-uppercase">*</span>
                                                        <label>Fecha</label>
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="text"
                                                                class="form-control pull-right datepicker"
                                                                id="datepicker" name="dateB">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 pull-left">
                                                    <br>
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="noDocument">No. de documento</label>
                                                        <input type="text" class="form-control" id="noDocument"
                                                            name="noDocument" placeholder="Escriba un número">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 pull-left">
                                                    <div class="info-box bg-green">
                                                        <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Saldo actual:</span>
                                                            <span class="info-box-number"><label for="totalB"
                                                                    id="totalBal"></label></span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="noReceipt">No. de recibo</label>
                                                        <input type="text" class="form-control" id="noReceipt"
                                                            name="noReceipt" placeholder="Escriba un número">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <br>
                                                    <div class="form-group">
                                                        <span class="text-danger text-uppercase">*</span>
                                                        <label for="amount">Monto</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                Q.
                                                            </span>
                                                            <input type="number" id="amount" name="amount"
                                                                placeholder="0.00" min="0.00" step="0.01"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <br>
                                                    <div class="form-group">
                                                        <span
                                                            class="text-danger text-uppercase">*</span><label>Tipo</label>
                                                        <label for="cheque">
                                                            <input type="checkbox" id="cheque" name="cheque"
                                                                class="minimal" value="0">
                                                            Cheque
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 pull-left">
                                                    <div class="info-box bg-yellow">
                                                        <span class="info-box-icon"><i
                                                                class="fa fa- fa-hourglass-half"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Pagos retenidos:</span>
                                                            <span class="info-box-number"><label for="totalP"
                                                                    id="totalPal">Q.
                                                                    0.00</label></span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <br>
                                                    <div class="form-group">
                                                        <span class="text-danger text-uppercase">*</span>
                                                        <label for="amount">Comisión Schlenker</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                %
                                                            </span>
                                                            <input type="number" id="comiS" name="comiS" placeholder="0"
                                                                min="0" step="1" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <br>
                                                    <div class="form-group">
                                                        <span class="text-danger text-uppercase">*</span>
                                                        <label for="amount">Comisión Distribución</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                %
                                                            </span>
                                                            <input type="number" id="comiD" name="comiD" placeholder="0"
                                                                min="0" step="1" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="modal-footer">
                                                <input type="hidden" name="tipo" value="pago">
                                                <input type="hidden" id="idSale" name="idSale" value="0">
                                                <input type="hidden" id="idSeller" name="idSeller" value="0">
                                                <input type="hidden" id="dateStart" name="dateStart" value="0">
                                                <input type="hidden" id="totalB" name="totalB" value="0">
                                                <input type="hidden" id="totalP" name="totalP" value="0">
                                                <input type="hidden" id="schlenkerP" name="schlenkerP" value="0">
                                                <input type="hidden" id="distribucionP" name="distribucionP" value="0">
                                                <div class="col-lg-6">
                                                    <select id="sellerS" name="sellerS" class="form-control select2"
                                                        style="width: 100%;" value="0">
                                                        <option value="" selected>Seleccione un vendedor
                                                        </option>
                                                        <?php
try {
    $sql = "SELECT idSeller, sellerCode, sellerFirstName, sellerLastName FROM seller WHERE state = 0";
    $resultado = $conn->query($sql);
    while ($seller_sale = $resultado->fetch_assoc()) {?>
                                                        <option value="<?php echo $seller_sale['idSeller']; ?>">
                                                            <?php echo $seller_sale['sellerCode'] . " " . $seller_sale['sellerFirstName'] . " " . $seller_sale['sellerLastName']; ?>
                                                        </option>
                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                    </select>
                                                </div>
                                                <?php
if ($_SESSION['rol'] == 1) {?>
                                                <button type="submit" class="btn btn-primary" id="crear-pago">
                                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                                                <span class="text-warning"> *Debe llenar los campos
                                                    obligatorios
                                                </span>
                                                <?php
} elseif ($_SESSION['rol'] == 2) {?>
                                                <span class="text-warning pull-right"> *No tiene permisos para ingresar
                                                    pagos </span>
                                                <?php
}
?>
                                            </div>
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
                                                                <th>Comisiones</th>
                                                                <th>Monto</th>
                                                                <th>Saldo</th>
                                                                <th>Acciones</th>
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
                                        </form>
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
                    (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer,
                    (select SUM((priceS-discount)*quantity) from detailS WHERE (select _idMake from product where idProduct = _idProduct) = 171 AND _idSale = idSale) as schlenker
                    FROM sale S WHERE S.cancel = 0 AND S.state = 0 ORDER BY S.idSale DESC";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($sale = $resultado->fetch_assoc()) {
    $dateStar = date_create($sale['dateStart']);
    $dateEnd = date_create($sale['dateEnd']);
    $SchlenkerP = number_format(((100 * $sale['schlenker']) / $sale['totalSale']), 2);
    $distribucionP = number_format((100 - $SchlenkerP), 2);
    ?>
                                    <tr>
                                        <td>
                                            <?php echo date_format($dateStar, 'd/m/y'); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $sale['noDeliver']; ?>
                                            <?php if ($sale['type'] == 0) {?>
                                            <span class="badge bg-light-blue">Dist.</span>
                                            <?php } else {?>
                                            <span class="badge bg-purple">Schl.</span>
                                            <?php }?>
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
                                        <td>Q.
                                            <?php echo $sale['advance']; ?>
                                        </td>
                                        <td>
                                            <?php echo 'Q.' . $sale['totalSale']; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical col-xs-8">
                                                <button type="button" class="btn btn-success btn-sm detalle_sale"
                                                    data-id="<?php echo $sale['idSale']; ?>" data-tipo="listDetailS"><i
                                                        class="fa fa-info"></i> Detalles</button>
                                                <button type="button" class="btn btn-primary btn-sm detalle_balance"
                                                    data-id="<?php echo $sale['idSale']; ?>" data-tipo="listBalance"
                                                    vendedor="<?php echo $sale['seller']; ?>"
                                                    schlenkerP="<?php echo $SchlenkerP; ?>"
                                                    distribucionP="<?php echo $distribucionP; ?>"><i
                                                        class="fa fa-balance-scale"></i> Balance</button>
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn bg-teal-active btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="true">
                                                        <span><i class="fa fa-print"></i> Imprimir</span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="printSale.php?id=<?php echo $sale['idSale']; ?>">
                                                                Factura</a>
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