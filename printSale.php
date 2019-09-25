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
                <small>Complete el formulario para Imprimir la venta seleccionada</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Imprimir Venta</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php
                    $sql = "SELECT dateEnd, totalSale,
              (select sellerCode from seller where idSeller = S._idSeller) as sellercode,
              (select name from town where idTown = C._idTown) as municipio,
              (select name from village where idVillage = C._idVillage) as aldea,
              (select name from deparment where idDeparment = C._idDeparment) as departamento,
              C.customerCode, C.customerName, C.customerNit, C.customerAddress, C.customerTel
              FROM sale S INNER JOIN customer C ON C.idCustomer = S._idCustomer WHERE idSale = $id";
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
                                        <i class="glyphicon glyphicon-print" aria-hidden="true"></i> Correlativo de
                                        facturación</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" id="form-correlative" name="form-correlative" method="post" action="BLL/correlative.php">
                                        <div class="row">
                                            <?php
                                            try {
                                                $sql = "SELECT * FROM correlative WHERE idCorrelative = 1";
                                                $resultado = $conn->query($sql);
                                                while ($correlative = $resultado->fetch_assoc()) { ?>
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
                                            <span class="text-warning w3-small w3-padding-small pull-left">*Debe llenar
                                                los campos obligatorios</span>
                                            <button id="correlativeClose" type="button" class="btn btn-danger w3-round-medium pull-right" data-dismiss="modal">Cerrar</button>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <!-- MODAL IMPRIMIR -->
                    <div class="modal fade" id="modal-printS">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button onclick="recargarPagina();" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                            <iframe src="" style="width: 100%; height: 700px; min-width: 300px;"></iframe>
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
                            <form role="form" id="form-factura" name="form-factura" method="post" action="BLL/bill.php" novalidate>
                                <div class="box-body">
                                    <div class="row">
                                        <?php
                                        try {
                                            $sql = "SELECT * FROM correlative WHERE idCorrelative = 1";
                                            $resultado = $conn->query($sql);
                                            while ($correlative = $resultado->fetch_assoc()) { ?>
                                                <div class="form-group col-lg-1">
                                                    <label for="serie">Serie</label>
                                                    <input type="hidden" class="form-control" id="serieS1" name="serieS" value="<?php echo $correlative['serie']; ?>">
                                                    <input type="text" class="form-control" id="serieS" name="serie" value="<?php echo $correlative['serie']; ?>" disabled>
                                                </div>

                                                <div class="form-group col-lg-3 ">
                                                    <label for="noBill">No. de factura</label>
                                                    <div class="input-group">

                                                        <input type="text" class="form-control" id="noBillS" name="noBill" value="<?php echo $correlative['last'] + 1; ?>" disabled>
                                                        <input type="hidden" class="form-control" id="noBillS1" name="noBillS" value="<?php echo $correlative['last'] + 1; ?>">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn bg-info" data-toggle="modal" data-target="#modal-correlative">
                                                                <i class="glyphicon glyphicon-print" aria-hidden="true"></i>
                                                                Correlativo
                                                            </button>
                                                        </div>
                                                        <!-- /btn-group -->
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        } catch (Exception $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        ?>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Código de vendedor</label>
                                                <input type="text" class="form-control" id="sellerCode" name="sellerCode" value="<?php echo $sale['sellercode']; ?>" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Código del cliente</label>
                                                <input type="text" class="form-control" id="customerCode" name="customerCode" value="<?php echo $sale['customerCode']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Municipio</label>
                                                <input type="text" class="form-control" id="municipio" name="municipio" value="<?php echo $sale['municipio']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Teléfono</label>
                                                <input type="text" class="form-control pull-right" id="customerTel" name="customerTel" value="<?php echo $sale['customerTel']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Fecha</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right datepicker" id="datepicker" name="date" value="<?php echo date('d/m/Y'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Fecha de vencimiento</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <?php $dateEnd = date_create($sale['dateEnd']); ?>
                                                    <input type="text" class="form-control pull-right datepicker" id="datepicker2" name="dateSaleEnd" value="<?php echo date_format($dateEnd, 'd/m/Y'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Nombre del cliente</label>
                                                <input type="text" class="form-control" id="customerName" name="customerName" value="<?php echo $sale['customerName']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>NIT</label>
                                                <input type="text" class="form-control" id="customerNit" name="customerNit" value="<?php echo $sale['customerNit']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <span class="text-danger text-uppercase">*</span>
                                                <label>Dirección</label>
                                                <input type="text" class="form-control" id="customerAddress" name="customerAddress" value="<?php echo $sale['customerAddress'] . ' ' . $sale['aldea'] . ' ' . $sale['municipio'] . ' ' . $sale['departamento']; ?>">
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
                                                    <th style="min-width:360px">Nombre</th>
                                                    <th>Código</th>
                                                    <th>Marca</th>
                                                    <th>Categoría</th>
                                                    <th>Unidad</th>
                                                    <th>Costo/u</th>
                                                    <th>Precio Q.</th>
                                                    <th>Cantidad</th>
                                                    <th>Descuento Q.</th>
                                                    <th>Quitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                try {
                                                    $sql = "SELECT P.picture, P.idProduct, P.productName, P.productCode, P.cost, P.description,
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
                                                    $id_detalle = 0;
                                                    while ($detailS = $resultado->fetch_assoc()) {
                                                        $subtotal = ($detailS['priceS'] - $detailS['discount']) * $detailS['quantity']; ?>
                                                        <tr id="detalleF">
                                                            <td><img src="img/products/<?php echo $detailS['picture']; ?>" width="80" onerror="this.src='img/products/notfound.jpg';">
                                                            </td>
                                                            <td><input class="idproducto_class" type="hidden" value="<?php echo $detailS['idProduct']; ?>">
                                                                <input class="id_detalle_class" type="hidden" value="<?php echo $id_detalle; ?>">
                                                                <?php if ($detailS['make'] == 'SCHLENKER') { ?>
                                                                    <input type="text" class="form-control description_class" value="<?php echo $detailS['description']; ?>">
                                                                <?php } else { ?>
                                                                    <input type="text" class="form-control description_class" value="<?php echo $detailS['productName']; ?>">
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $detailS['productCode']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $detailS['make']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $detailS['category']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $detailS['unity']; ?>
                                                            </td>
                                                            <td><input type="hidden" value="<?php echo $detailS['cost']; ?>">Q.
                                                                <?php echo $detailS['cost']; ?>
                                                            </td>
                                                            <td><input type="number" step="0.01" class="form-control precio_class" value="<?php echo $detailS['priceS']; ?>">
                                                            </td>
                                                            <td><input type="number" step="0.01" class="form-control cantidad_class" value="<?php echo $detailS['quantity']; ?>">
                                                            </td>
                                                            <td><input type="number" step="0.01" class="form-control descuento_class" value="<?php echo $detailS['discount']; ?>">
                                                            </td>
                                                            <td><a id="quitar" onclick="eliminarDetalle_Factura(<?php echo $id_detalle; ?>);" data-id-detalle="<?php echo $id_detalle; ?>" class="btn bg-maroon btn-flat margin quitar_product"><i class="fa fa-remove"></i></a></td>
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
                                                <input type="hidden" id="factura" name="factura" value="nueva">
                                                <input type="hidden" name="id_sale" value="<?php echo $id; ?>">
                                                <button type="submit" class="btn btn-primary" id="crear-factura">
                                                    <i class="fa fa-print" aria-hidden="true"></i> Imprimir
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