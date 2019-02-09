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
                <i class="fas fa-file-invoice"></i>
                Facturas
                <small>Complete el formulario para Editar la factura seleccionada</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Editar Factura</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php
$sql = "SELECT dateEnd, total, codeSeller, town, codeCustomer, custName, custNit, address, mobile, serie, noBill
              FROM bill WHERE idBill = $id";
$resultado = $conn->query($sql);
$bill = $resultado->fetch_assoc();
?>

                    <!-- MODAL IMPRIMIR -->
                    <div class="modal fade" id="modal-printS">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button onclick="recargarPagina();" type="button" class="close" data-dismiss="modal"
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

                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" id="form-factura" name="form-factura" method="post" action="BLL/bill.php"
                                novalidate>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-lg-1">
                                            <label for="serie">Serie</label>
                                            <input type="text" class="form-control" id="serieS" name="serie"
                                                value="<?php echo $bill['serie']; ?>">
                                        </div>

                                        <div class="form-group col-lg-3 ">
                                            <label for="noBill">No. de factura</label>
                                            <div class="input-group">

                                                <input type="text" class="form-control" id="noBillS" name="noBill"
                                                    value="<?php echo $bill['noBill']; ?>">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn bg-info" data-toggle="modal"
                                                        data-target="#modal-correlative" disabled>
                                                        <i class="glyphicon glyphicon-print" aria-hidden="true"></i>
                                                        Correlativo
                                                    </button>
                                                </div>
                                                <!-- /btn-group -->
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Código de vendedor</label>
                                                <input type="text" class="form-control" id="sellerCode"
                                                    name="sellerCode" value="<?php echo $bill['codeSeller']; ?>"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Código del cliente</label>
                                                <input type="text" class="form-control" id="customerCode"
                                                    name="customerCode" value="<?php echo $bill['codeCustomer']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Municipio</label>
                                                <input type="text" class="form-control" id="municipio" name="municipio"
                                                    value="<?php echo $bill['town']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Teléfono</label>
                                                <input type="text" class="form-control pull-right" id="customerTel"
                                                    name="customerTel" value="<?php echo $bill['mobile']; ?>">
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
                                                    <?php $dateEnd = date_create($bill['dateEnd']);?>
                                                    <input type="text" class="form-control pull-right datepicker"
                                                        id="datepicker2" name="dateSaleEnd"
                                                        value="<?php echo date_format($dateEnd, 'd/m/Y'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Nombre del cliente</label>
                                                <input type="text" class="form-control" id="customerName"
                                                    name="customerName" value="<?php echo $bill['custName']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>NIT</label>
                                                <input type="text" class="form-control" id="customerNit"
                                                    name="customerNit" value="<?php echo $bill['custNit']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Dirección</label>
                                                <input type="text" class="form-control" id="customerAddress"
                                                    name="customerAddress" value="<?php echo $bill['address']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <i class="glyphicon glyphicon-list-alt"></i> Detalle de factura</h3>
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
                                      D.priceB, D.quantity, D.discount
                                    from detailB D INNER JOIN product P ON D._idProduct = P.idProduct
                                    where _idBill = $id";
    $resultado = $conn->query($sql);
    $id_detalle = 0;
    while ($detailB = $resultado->fetch_assoc()) {
        $subtotal = ($detailB['priceB'] - $detailB['discount']) * $detailB['quantity'];?>
                                                <tr id="detalleF">
                                                    <td><img src="img/products/<?php echo $detailB['picture']; ?>"
                                                            width="80" onerror="this.src='img/products/notfound.jpg';">
                                                    </td>
                                                    <td><input class="idproducto_class" type="hidden"
                                                            value="<?php echo $detailB['idProduct']; ?>">
                                                        <input class="id_detalle_class" type="hidden"
                                                            value="<?php echo $id_detalle; ?>">
                                                        <?php echo $detailB['productName']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $detailB['productCode']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $detailB['make']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $detailB['category']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $detailB['unity']; ?>
                                                    </td>
                                                    <td><input type="hidden" value="<?php echo $detailB['cost']; ?>">Q.
                                                        <?php echo $detailB['cost']; ?>
                                                    </td>
                                                    <td><input class="precio_class" type="hidden"
                                                            value="<?php echo $detailB['priceB']; ?>">Q.
                                                        <?php echo $detailB['priceB']; ?>
                                                    </td>
                                                    <td><input class="cantidad_class" type="hidden"
                                                            value="<?php echo $detailB['quantity']; ?>">
                                                        <?php echo $detailB['quantity']; ?>
                                                    </td>
                                                    <td><input class="descuento_class" type="hidden"
                                                            value="<?php echo $detailB['discount']; ?>">Q.
                                                        <?php echo $detailB['discount']; ?>
                                                    </td>
                                                    <td>Q.
                                                        <?php echo $subtotal; ?>
                                                    </td>
                                                    <td><a id="quitar"
                                                            onclick="eliminarDetalle_Factura(<?php echo $id_detalle; ?>);"
                                                            data-id-detalle="<?php echo $id_detalle; ?>"
                                                            class="btn bg-maroon btn-flat margin quitar_product"><i
                                                                class="fa fa-remove"></i></a></td>
                                                </tr>
                                                <?php
$id_detalle = $id_detalle + 1;
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
                                            <div class="form-group col-lg-7">
                                            </div>
                                            <div class="form-group col-lg-5">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <span class="text-danger text-uppercase">*</span>
                                                        <label for="totalSale" class="control-label">Total:</label>
                                                        <span>
                                                            <h5 id="totalSale" class="text-bold">
                                                                Q.
                                                                <?php echo $bill['total']; ?>
                                                            </h5>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-7">
                                            </div>
                                            <div class="form-group col-lg-5">
                                                <input type="hidden" id="factura" name="factura" value="editar">
                                                <input type="hidden" name="id_bill" value="<?php echo $id; ?>">
                                                <input type="hidden" id="totalS" name="totalS"
                                                    value="<?php echo $bill['total']; ?>">
                                                <button type="submit" class="btn btn-primary" id="crear-factura">
                                                    <i class="fa fa-print" aria-hidden="true"></i> Editar
                                                    Factura</button>
                                                <span class="text-warning"> *Debe llenar los campos obligatorios</span>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                            <!-- /.box-body -->
                        </div>
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