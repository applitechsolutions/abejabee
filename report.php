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
                        <div class="col-md-12">
                            <!-- Custom Tabs (Pulled to the right) -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            Reportes de Ventas
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li role="presentation">
                                                <a href="#tab_1" data-toggle="tab">Ejemplo de reporte</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#tab_2" data-toggle="tab">Tab 2</a>
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
                                        <div>
                                            <header class="w3-container w3-padding-small"> 
                                                <h4>Producciones entre fechas</h4>
                                            </header>
                                            <div class="w3-container w3-padding-bottom">
                                                <div class="w3-padding-bottom w3-margin-bottom">
                                                    <label>Fecha inicial</label>
                                                    <input type="date" class="w3-input w3-light-gray w3-round w3-border-light-gray" name="rptP1fecha1">
                                                    <label>Fecha final</label>
                                                    <input type="date" class="w3-input w3-light-gray w3-round w3-border-light-gray" name="rptP1fecha2">
                                                </div>
                                                
                                                <a onclick="listAllRoutes()" class="w3-btn w3-blue w3-round w3-right  w3-small">
                                                    Ver reporte <i class="fa fa-arrow-circle-right"></i> 
                                                </a>
                                            </div>
                                        </div>
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
                            <div id="divreporte" class="w3-rest">
                                <iframe src="ReportsPDF/ReporteBase.php" style="width: 100%; height: 810px; min-width: 300px;"></iframe>
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