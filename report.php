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
                <i class="glyphicon glyphicon-list-alt"></i>
                Reportes
                <small>Aquí puede generar los reportes necesarios</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Listados generales</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="modal fade" id="modal-reporte">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">
                                            <li class="glyphicon glyphicon-print"></li> Imprimir
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="box box-info">
                                            <div class="box-header">
                                            </div>
                                            <!-- /.box-header -->
                                            <div id="divreporte" class="w3-rest">
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

                        <div class="col-md-12">
                            <!-- Custom Tabs (Pulled to the right) -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a id="comisiones" href="#tab_1" data-toggle="tab"><i
                                                class="fa fa-user-plus"></i> Comisiones por vendedor</a>
                                    </li>
                                    <li>
                                        <a href="#tab_3" data-toggle="tab"><i class="fa fa-paper-plane"></i> Ventas
                                            vencidas o atrasadas</a>
                                    </li>
                                    <li>
                                        <a href="#tab_4" data-toggle="tab"><i class="fa fa-address-card"></i> Clientes
                                            por Ruta</a>
                                    </li>
                                    <li>
                                        <a href="#tab_6" data-toggle="tab"><i class="fa fa-line-chart"></i> Ventas por
                                            vendedor</a>
                                    </li>
                                    <li>
                                        <a href="#tab_7" data-toggle="tab"><i class="fa fa-archive"></i> Inventario por
                                            fechas</a>
                                    </li>
                                    <li>
                                        <a href="#tab_8" data-toggle="tab"><i class="fab fa-opencart"></i> Compras y
                                            ventas por producto</a>
                                    </li>
                                    <li>
                                        <a href="#tab_9" data-toggle="tab"><i class="fa fa-balance-scale"></i> Estado de
                                            cuenta por cliente</a>
                                    </li>
                                    <li>
                                        <a href="#tab_10" data-toggle="tab"><i class="fas fa-search-dollar"></i> Ventas
                                            por producto</a>
                                    </li>
                                    <li>
                                        <a href="#tab_11" data-toggle="tab"><i class="fas fa-hand-holding-usd"></i>
                                            Total cobrado por vendedor </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane" id="tab_1">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->

                                                <h4 class="box-title">Listado de ventas culminadas en rango de
                                                    fechas</h4>
                                                <div class="box-body">
                                                    <form role="form" id="form-SalesBySeller" name="form-SalesBySeller"
                                                        method="post" action="BLL/rptSalesBySeller.php">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Vendedor</label>
                                                                    <select id="sellerReporte" name="sellerReporte"
                                                                        class="form-control select2"
                                                                        style="width: 100%;">
                                                                        <option value="" disabled selected>Seleccione a
                                                                            un
                                                                            vendedor</option>
                                                                        <!-- PHP CONSULTA -->
                                                                        <?php
try {
    $sql = "SELECT * FROM seller where state = 0";
    $resultado = $conn->query($sql);
    while ($seller_route = $resultado->fetch_assoc()) {
        ?>
                                                                        <!-- PHP CONSULTA -->
                                                                        <option
                                                                            value="<?php echo $seller_route['idSeller']; ?>">
                                                                            <?php echo $seller_route['sellerFirstName'] . " " . $seller_route['sellerLastName']; ?>
                                                                        </option>
                                                                        <!-- FIN PHP -->
                                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                                        <!-- FIN PHP -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Inicial</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker" name="dateSrpt2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Final</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker2" name="dateErpt2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-primary pull-right"
                                                                id="rpt1">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                Generar Listado</button>
                                                        </div>
                                                        <h5>Comisiones por cobros</h5>
                                                        <h6>Funciona a partir del 24/06/2020</h6>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte2-1" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <hr>
                                                        <h5>Comisiones génerales</h5>
                                                        <h6>Funciona antes del 24/06/2020</h6>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte2" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
                                        <div class="row">
                                            <a href="#tab_1" data-toggle="tab"
                                                class="btn btn-flat pull-right text-bold">
                                                <i class="glyphicon glyphicon-backward"></i> Regresar al listado
                                                anterior...</a>
                                        </div>
                                        <div id="listadoDetalle2" class="modal-body">

                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->
                                                <h5 class="box-title">Listado de ventas sin terminar y su respectiva
                                                    mora</h5>
                                                <div class="box-body">
                                                    <form role="form" id="form-rpt1" name="form-rpt1" method="post"
                                                        action="BLL/rptVentasVencidas.php">
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-primary pull-left"
                                                                id="rpt1">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                Generar Listado</button>
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte1" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_4">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->
                                                <h4 class="box-title">Listado de clientes con ventas activas por ruta
                                                </h4>
                                                <div class="box-body">
                                                    <form role="form" id="form-rptCustomByDep"
                                                        name="form-rptCustomByDep" method="post"
                                                        action="BLL/rptCustomByDep.php">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Ruta</label>
                                                                    <select id="depReporte" name="depReporte"
                                                                        class="form-control select2"
                                                                        style="width: 100%;">
                                                                        <option value="" disabled selected>Seleccione
                                                                            una
                                                                            Ruta</option>
                                                                        <!-- PHP CONSULTA -->
                                                                        <?php
try {
    $sql = "SELECT idRoute, codeRoute, routeName FROM route where state = 0";
    $resultado = $conn->query($sql);
    while ($seller_route = $resultado->fetch_assoc()) {
        ?>
                                                                        <!-- PHP CONSULTA -->
                                                                        <option
                                                                            value="<?php echo $seller_route['idRoute']; ?>">
                                                                            <?php echo $seller_route['codeRoute'] . " " . $seller_route['routeName']; ?>
                                                                        </option>
                                                                        <!-- FIN PHP -->
                                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                                        <!-- FIN PHP -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-primary pull-right"
                                                                id="rpt1">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                Generar Listado</button>
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte3" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_5">
                                        <div class="row">
                                            <a href="#tab_4" data-toggle="tab"
                                                class="btn btn-flat pull-right text-bold">
                                                <i class="glyphicon glyphicon-backward"></i> Regresar al listado
                                                anterior...</a>
                                        </div>
                                        <div id="listadoDetalle3" class="modal-body">

                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_6">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->

                                                <h4 class="box-title">Listado de ventas realizadas en rango de
                                                    fechas</h4>
                                                <div class="box-body">
                                                    <form role="form" id="form-ComBySeller" name="form-ComBySeller"
                                                        method="post" action="BLL/rptComBySeller.php">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Vendedor</label>
                                                                    <select id="sellerReporte4" name="sellerReporte4"
                                                                        class="form-control select2"
                                                                        style="width: 100%;">
                                                                        <option value="" disabled selected>Seleccione a
                                                                            un vendedor</option>
                                                                        <!-- PHP CONSULTA -->
                                                                        <?php
try {
    $sql = "SELECT * FROM seller where state = 0";
    $resultado = $conn->query($sql);
    while ($seller_route = $resultado->fetch_assoc()) {
        ?>
                                                                        <!-- PHP CONSULTA -->
                                                                        <option
                                                                            value="<?php echo $seller_route['idSeller']; ?>">
                                                                            <?php echo $seller_route['sellerFirstName'] . " " . $seller_route['sellerLastName']; ?>
                                                                        </option>
                                                                        <!-- FIN PHP -->
                                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                                        <!-- FIN PHP -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Inicial</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker3" name="dateSrpt4">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Final</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker4" name="dateErpt4">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-primary pull-right"
                                                                id="rpt4">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                Generar Listado</button>
                                                            <div class="row">
                                                                <button type="button" onclick="printReport4()"
                                                                    id="btnImprimir"
                                                                    class="btn bg-teal-active btn-md pull-right"
                                                                    hidden><i class="fas fa-print"></i>
                                                                    Imprimir</button>
                                                            </div>
                                                            <div class="col-md-3 pull-left">
                                                                <div class="info-box bg-secondary">
                                                                    <span class="info-box-icon"><i
                                                                            class="fas fa-store"></i></span>
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Total:</span>
                                                                        <span class="info-box-number"><label
                                                                                for="totalS"
                                                                                id="totalVentas">0</label></span>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte4" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte4-1" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte4-2" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_7">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->

                                                <h4 class="box-title">Listado de inventario en una fecha</h4>
                                                <div class="box-body">
                                                    <form role="form" id="form-dailyStock" name="form-dailyStock"
                                                        method="post" action="BLL/rptdailyStock.php">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker5" name="dateSrpt5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-primary pull-right"
                                                                id="rpt4">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                Generar Listado</button>
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte5" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_8">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->
                                                <h4 class="box-title">Ventas y compras de un producto a partir de una
                                                    fecha</h4>
                                                <div class="box-body">
                                                    <form role="form" id="form-stockByProd" name="form-stockByProd"
                                                        method="post" action="BLL/rptstockByProductC.php">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Producto</label>
                                                                    <select id="prodReporte" name="prodReporte"
                                                                        class="form-control select2"
                                                                        style="width: 100%;">
                                                                        <option value="" disabled selected>Seleccione a
                                                                            un
                                                                            producto</option>
                                                                        <!-- CONSULTA PHP -->
                                                                        <?php
try {
    $sql = "SELECT P.*, (SELECT catName FROM category WHERE idCategory = P._idCategory) as category FROM product P WHERE state = 0";
    $resultado = $conn->query($sql);
    while ($productName = $resultado->fetch_assoc()) {
        ?>
                                                                        <!-- CONSULTA PHP -->
                                                                        <option
                                                                            value="<?php echo $productName['idProduct']; ?>">
                                                                            <?php echo $productName['productCode'] . " " . $productName['productName'] . " " . $productName['category']; ?>
                                                                        </option>
                                                                        <!-- FIN PHP -->
                                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                                        <!-- FIN PHP -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Inicial</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker6" name="dateSrpt6">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 pull-right">
                                                                <div class="info-box bg-blue">
                                                                    <span class="info-box-icon"><i
                                                                            class="fas fa-store"></i></span>
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Existencia
                                                                            actual:</span>
                                                                        <span class="info-box-number"><label
                                                                                for="totalS"
                                                                                id="totalStock">0</label></span>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button type="submit"
                                                                        class="btn btn-primary pull-right" id="rpt1">
                                                                        <i class="fa fa-list-alt"
                                                                            aria-hidden="true"></i>
                                                                        Generar Listado</button>
                                                                </div>
                                                                <div class="col-md-3 pull-right">
                                                                </div>

                                                            </div>
                                                            <!-- TABLA DEL LISTADO DE REPORTES -->
                                                            <div id="listadoReporte6" class="modal-body">
                                                            </div>
                                                            <!-- TABLA DEL LISTADO DE REPORTES -->
                                                            <!-- TABLA DEL LISTADO DE REPORTES -->
                                                            <div id="listadoReporte6-5" class="modal-body">
                                                            </div>
                                                            <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_9">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->
                                                <h4 class="box-title"> Información del cliente y estado de cuenta actual
                                                </h4>
                                                <div class="box-body">
                                                    <form role="form" id="form-stateCustomer" name="form-stateCustomer"
                                                        method="post" action="BLL/rptstateByCustomer.php">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Cliente</label>
                                                                    <select id="idCustomer" name="idCustomer"
                                                                        class="form-control select2"
                                                                        style="width: 100%;">
                                                                        <option value="" disabled selected>Seleccione un
                                                                            cliente</option>
                                                                        <!-- CONSULTA PHP -->
                                                                        <?php
try {
    $sql = "SELECT idCustomer, customerCode, customerName FROM customer WHERE state = 0 ORDER BY customerCode ASC";
    $resultado = $conn->query($sql);
    while ($customer = $resultado->fetch_assoc()) {
        ?>
                                                                        <!-- CONSULTA PHP -->
                                                                        <option
                                                                            value="<?php echo $customer['idCustomer']; ?>">
                                                                            <?php echo $customer['customerCode'] . " " . $customer['customerName']; ?>
                                                                        </option>
                                                                        <!-- FIN PHP -->
                                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                                        <!-- FIN PHP -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button type="submit"
                                                                        class="btn btn-primary pull-right" id="rpt1">
                                                                        <i class="fa fa-list-alt"
                                                                            aria-hidden="true"></i>
                                                                        Generar Listado</button>
                                                                </div>
                                                                <div class="col-md-3 pull-right">
                                                                </div>

                                                            </div>
                                                            <!-- TABLA DEL LISTADO DE REPORTES -->
                                                            <div id="listadoReporte7" class="modal-body">
                                                            </div>
                                                            <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_10">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->
                                                <h4 class="box-title">Listado del total de ventas por producto en un
                                                    rango de tiempo</h4>
                                                <div class="box-body">
                                                    <form role="form" id="form-SalesByProduct"
                                                        name="form-SalesByProduct" method="post"
                                                        action="BLL/rptSalesByProduct.php">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Inicial</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker7" name="dateSrpt8">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Final</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker8" name="dateErpt8">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-primary pull-right"
                                                                id="rpt10">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                Generar Listado</button>
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte8" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_11">
                                        <div class="row">
                                            <!-- Main content -->
                                            <section class="content">
                                                <!-- Default box -->

                                                <h4 class="box-title">Total cobrado por vendedor en un rango de tiempo
                                                </h4>
                                                <div class="box-body">
                                                    <form role="form" id="form-TotalCollected"
                                                        name="form-TotalCollected" method="post"
                                                        action="BLL/rptTotalCollected.php">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Vendedor</label>
                                                                    <select id="sellerReporte9" name="sellerReporte9"
                                                                        class="form-control select2"
                                                                        style="width: 100%;">
                                                                        <option value="" disabled selected>Seleccione a
                                                                            un
                                                                            vendedor</option>
                                                                        <!-- PHP CONSULTA -->
                                                                        <?php
try {
    $sql = "SELECT * FROM seller where state = 0";
    $resultado = $conn->query($sql);
    while ($seller_route = $resultado->fetch_assoc()) {
        ?>
                                                                        <!-- PHP CONSULTA -->
                                                                        <option
                                                                            value="<?php echo $seller_route['idSeller']; ?>">
                                                                            <?php echo $seller_route['sellerFirstName'] . " " . $seller_route['sellerLastName']; ?>
                                                                        </option>
                                                                        <!-- FIN PHP -->
                                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                                        <!-- FIN PHP -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Tipo de venta</label>
                                                                    <select id="typeS" name="typeS"
                                                                        class="form-control select2"
                                                                        style="width: 100%;" value="0">
                                                                        <option value="0">Distribución</option>
                                                                        <option value="1">Schlenker</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Inicial</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker9" name="dateSrpt9">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Fecha Final</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control pull-right datepicker"
                                                                            id="datepicker10" name="dateErpt9">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-4 pull-left">
                                                            <div class="info-box bg-green">
                                                                <span class="info-box-icon"><i
                                                                        class="fas fa-hand-holding-usd"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total:</span>
                                                                    <span class="info-box-number"><label for="totalS"
                                                                            id="totalCobrado">0</label></span>
                                                                </div>
                                                                <!-- /.info-box-content -->
                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-primary pull-right"
                                                                id="rpt11">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                                Generar Total</button>
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                        <div id="listadoReporte9" class="modal-body">
                                                        </div>
                                                        <!-- TABLA DEL LISTADO DE REPORTES -->
                                                    </form>
                                                </div>
                                                <!-- /.box-body -->
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
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