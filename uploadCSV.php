<?php
include_once 'funciones/sesiones.php';
include_once 'templates/header.php';
include_once 'templates/navBar.php';
include_once 'templates/sideBar.php';
include_once 'funciones/bd_conexion.php';
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="content-page">

            <!-- Start content -->
            <div class="content">

                <div class="container-fluid">


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="breadcrumb-holder">
                                <h1 class="main-title float-left">INGRESO DE INVENTARIO</h1>
                                <ol class="breadcrumb float-right">
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3><i class="fa fa-file-excel-o"></i> Ingreso del archivo (.CSV)</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <form id="upload_csv" method="post" enctype="multipart/form-data">
                                                <div class="col-lg-12">
                                                    <br />
                                                    <h6>Seleccione el archivo</h6>
                                                    <input type="file" name="csv_file" id="csv_file" accept=".csv" />
                                                    <button type="submit" class="btn btn-primary btn-block"><i
                                                            class="fa fa-upload"></i>
                                                        Cargar pagos</button>
                                                </div>
                                                <div style="clear:both"></div>
                                            </form>
                                        </div>
                                        <br />
                                        <br />
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" id="data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Nombre</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- end card-->
                            </div>
                        </div>
                    </div>

                </div>
                <!-- END container-fluid -->

            </div>
            <!-- END content -->

        </div>
        <!-- END content-page -->
    </section>
</div>

<?php
include_once 'templates/footer.php';
?>