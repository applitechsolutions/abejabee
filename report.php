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
            Reportes
            <small>Aquí puede generar los reportes</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">No sé</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="modal fade" id="modal-reporte">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"><li class="glyphicon glyphicon-print"></li> Imprimir</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="box box-info">
                                    <div class="box-header">
                                    </div>
                                    <!-- /.box-header -->
                                    <div id="divreporte" class="w3-rest">
                                        <iframe src="" style="width: 100%; height: 700px; min-width: 300px;"></iframe>
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
                                    <a href="#tab_1" data-toggle="tab">Ventas Terminas por Vendedor</a>
                                </li>
                                <li>
                                    <a href="#tab_3" data-toggle="tab">Tab 3</a>
                                </li>
                                
                                <li class="pull-right">
                                    <a href="#" class="text-muted">
                                        <i class="fa fa-gear"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <!-- Main content -->
                                            <section class="content">
                                            <!-- Default box -->
                                                <div class="box">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Crear Ruta</h3>
                                                    </div>
                                                    <div class="box-body">
                                                        <form role="form" id="form-SalesBySeller" name="form-SalesBySeller" method="post" action="BLL/rptSalesBySeller.php">
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <span class="text-danger text-uppercase">*</span>
                                                                    <label>Vendedor</label>
                                                                    <select id="sellerReporte" name="sellerReporte" class="form-control select2" style="width: 100%;">
                                                                    <option value="" disabled selected>Seleccione a un vendedor</option>
                                                                    <?php
                                                                        try {
                                                                        $sql = "SELECT * FROM seller";
                                                                        $resultado = $conn->query($sql);
                                                                        while ($seller_route = $resultado->fetch_assoc()) {?>
                                                                        <option value="<?php echo $seller_route['idSeller']; ?>">
                                                                        <?php echo $seller_route['sellerFirstName']. " " .$seller_route['sellerLastName']; ?>
                                                                        </option>
                                                                        <?php 
                                                                        }
                                                                        } catch (Exception $e) {
                                                                            echo "Error: " . $e->getMessage();
                                                                        }
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                                <!-- /.box-body -->
                                                                <div class="box-footer">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="rpt1">
                                                                    <i class="fa fa-list-alt" aria-hidden="true"></i> Generar Listado</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                                <!-- /.box -->
                                            </section>
                                            <!-- /.content -->
                                        </div>
                                    </div>
                                <!-- TABLA DEL LISTADO DE REPORTES -->
                                    <div id="listadoReporte" class="modal-body">
                                        
                                    </div>
                                <!-- TABLA DEL LISTADO DE REPORTES -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
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