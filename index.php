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
                <i class="fa fa-archive"></i>
                Inventario de Productos
                <small>Existencia de los productos en la bodega principal</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Listado general de la existencia de productos</h3>
                        </div>

                        <!-- MODAL DETALLE DE EXISTENCIAS -->
                        <div class="modal fade" id="modal-stock">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Existencia de Productos</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="box">
                                            <div id="nombre-producto" class="box-header">

                                            </div>
                                            <div class="box-body table-responsive no-padding">
                                                <table id="expiracion" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Existencia</th>
                                                            <th>Fecha de Vencimiento</th>
                                                            <th>Editar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="contenidoExp">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- MODAL DETALLE DE EXISTENCIAS -->

                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table id="registros" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Categoría</th>
                                    <th>Unidad</th>
                                    <th>Costo</th>
                                    <th>Precios</th>
                                    <th>Existencia</th>
                                    <th><span class="fa fa-cogs"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    if ($_SESSION['rol'] == 1) {
                                        $sql = "SELECT P.idProduct, P.productName, P.productCode, P.cost, P.minStock, P.picture,
                                        (select SUM(stock) from storage where _idProduct = P.idProduct and _idCellar = 1) as stock,
                                        (select makeName from make where idMake = P._idMake and state = 0) as make,
                                        (select catName from category where idCategory = P._idCategory and state = 0) as category,
                                        (select unityName from unity where idUnity = P._idUnity and state = 0) as unity,
                                        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 1) as public,
                                        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 11) as pharma,
                                        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 21) as business,
                                        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 31) as bonus
                                        FROM product P WHERE P.state = 0 ORDER BY P.productCode ASC";
                                    } else {
                                        $sql = "SELECT P.idProduct, P.productName, P.productCode, P.cost, P.minStock, P.picture,
                                        (select SUM(stock) from storage where _idProduct = P.idProduct and _idCellar = 1) as stock,
                                        (select makeName from make where idMake = P._idMake and state = 0) as make,
                                        (select catName from category where idCategory = P._idCategory and state = 0) as category,
                                        (select unityName from unity where idUnity = P._idUnity and state = 0) as unity,
                                        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 1) as public,
                                        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 11) as pharma,
                                        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 21) as business,
                                        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 31) as bonus
                                        FROM product P WHERE (select makeName from make where idMake = P._idMake and state = 0) != 'SCHLENKER' AND
                                        (select makeName from make where idMake = P._idMake and state = 0) != 'DIFPER' AND
                                        (select makeName from make where idMake = P._idMake and state = 0) != 'PFIZER' AND
                                        P.state = 0 ORDER BY P.productCode ASC";
                                    }
                                    $resultado = $conn->query($sql);
                                } catch (Exception $e) {
                                    $error = $e->getMessage();
                                    echo $error;
                                }

                                while ($product = $resultado->fetch_assoc()) {
                                    $idProduct = $product['idProduct'];
                                    ?>
                                    <tr>
                                        <td>
                                            <img src="img/products/<?php echo $product['picture']; ?>" width="100" onerror="this.src='img/products/notfound.jpg';">
                                        </td>
                                        <td>
                                            <?php echo $product['productCode']; ?>
                                        </td>
                                        <td>
                                            <?php echo $product['productName']; ?>
                                        </td>
                                        <td>
                                            <?php echo $product['make']; ?>
                                        </td>
                                        <td>
                                            <?php echo $product['category']; ?>
                                        </td>
                                        <td>
                                            <?php echo $product['unity']; ?>
                                        </td>
                                        <td>
                                            Q.<?php echo $product['cost']; ?>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <small>Público:</small><span class="label label-default">Q.<?php echo $product['public']; ?></span>
                                                </li>
                                                <li>
                                                    <small> Farmacia:</small><span class="label label-default">Q.<?php echo $product['pharma']; ?></span>
                                                </li>
                                                <li>
                                                    <small>Negocio:</small><span class="label label-default">Q.<?php echo $product['business']; ?></span>
                                                </li>
                                                <li>
                                                    <small>Bono:</small><span class="label label-default">Q.<?php echo $product['bonus']; ?></span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <small>Mínima:</small><span class="label label-default"><?php echo $product['minStock']; ?></span>
                                                </li>
                                                <li>
                                                    <small>Actual:</small>
                                                    <?php
                                                        if ($product['minStock'] == $product['stock']) { ?>
                                                        <span class="label label-warning"><?php echo $product['stock']; ?>
                                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                        </span><?php
                                                                    } else if ($product['minStock'] > $product['stock']) { ?>
                                                        <span class="label label-danger"><?php echo $product['stock']; ?> <i class="fa fa-exclamation" aria-hidden="true"></i>
                                                        </span><?php
                                                                    } else { ?>
                                                        <span class="label label-primary"><?php echo $product['stock']; ?></span><?php
                                                                                                                                        } ?>
                                                </li>
                                            </ul>
                                        </td>
                                        <td>
                                            <a class="btn bg-green btn-flat margin" href="newPurchase.php">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                            <a href="#" data-id="<?php echo $product['idProduct'] ?>" data-tipo="listStorage" class="btn  btn-primary btn-flat margin listarStock"><i class="fas fa-archive"></i></a>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Categoría</th>
                                    <th>Unidad</th>
                                    <th>Costo</th>
                                    <th>Existencia</th>
                                    <th><span class="fa fa-cogs"></span></th>
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