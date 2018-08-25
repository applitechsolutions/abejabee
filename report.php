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
                Ventas
                <small>Llene el formulario para realizar una nueva venta</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Nueva Venta</h3>
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
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="#">Another action</a>
                                            </li>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="#">Something else here</a>
                                            </li>
                                            <li role="presentation" class="divider"></li>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="#">Separated link</a>
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
                                                
                                                <a onclick="getProduccionesPorFecha()" class="w3-btn w3-blue w3-round w3-right  w3-small">
                                                    Ver reporte <i class="fa fa-arrow-circle-right"></i> 
                                                </a>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="divreporte" class="w3-rest">
                                            <iframe src="ReportsPDF/ReporteBase.php" style="width: 100%; height: 810px; min-width: 300px;"></iframe>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
                                        The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc,
                                        Europe uses the same vocabulary. The languages only differ in their grammar, their
                                        pronunciation and their most common words. Everyone realizes why a new common language
                                        would be desirable: one could refuse to pay expensive translators. To achieve this,
                                        it would be necessary to have uniform grammar, pronunciation and more common words.
                                        If several languages coalesce, the grammar of the resulting language is more simple
                                        and regular than that of the individual languages.
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                        text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                        it to make a type specimen book. It has survived not only five centuries, but also
                                        the leap into electronic typesetting, remaining essentially unchanged. It was popularised
                                        in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                                        and more recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum.
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