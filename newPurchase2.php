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
    <div id="app" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-shopping-cart"></i>
                Compras
                <small>Complete el formulario para realizar una nueva compra a los proveedores</small>
            </h1>
        </section>
        <purchase></purchase>
    </div>
    <!-- /.\VUE -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.1.0
        </div>
        <strong>Copyright &copy; 2018 - <?php echo date("Y"); ?> <a href="#">Applitech Software Solutions</a>.</strong>
        Todos Los
        Derechos Reservados.
    </footer>


    </div>
    <!-- ./wrapper -->

    <script>
    Vue.component('purchase', {
        template: /*html*/ `
            <div>
                <!-- Main content -->
                <section class="content">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Nueva Compra</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <form autocomplete="off">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <span class="text-danger text-uppercase">*</span>
                                                    <label>Fecha</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker"
                                                            id="datepicker" name="date">
                                                    </div>
                                                </div>
                                            </div>
                                            <providers></providers>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="noBill">No.
                                                        de factura</label>
                                                    <input type="text" class="form-control" id="noBill" name="noBill"
                                                        placeholder="Escriba un número de factura">
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="serie">Serie</label>
                                                    <input type="text" class="form-control" id="serie" name="serie"
                                                        placeholder="Escriba la serie">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="noDocument">No. de documento</label>
                                                    <input type="text" class="form-control" id="noDocument"
                                                        name="noDocument" placeholder="Escriba un número de documento">
                                                </div>
                                            </div>
                                              <div class="col-lg-4">
                                                  <div class="form-group">
                                                      <span class="text-danger text-uppercase">*</span>
                                                      <label>Forma de pago</label>
                                                      <select name="payment" class="form-control">
                                                          <option value="">Seleccione una forma de pago</option>
                                                          <option value="0" selected>Contado </option>
                                                          <option value="1">Crédito </option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-lg-4">
                                                    <div class="form-group">
                                                      <label>Fecha de
                                                          vencimiento</label>
                                                      <div class="input-group date">
                                                          <div class="input-group-addon">
                                                              <i class="fa fa-calendar"></i>
                                                          </div>
                                                          <input type="text" class="form-control datepicker"
                                                              id="datepicker2" name="date">
                                                      </div>
                                                  </div>
                                              </div>
                                        </div>
                                        <hr class="my-4">
                                                                        <div class="box box-success">
                                    <div class="box-header margin-bottom">
                                        <h3 class="box-title">Detalle de compra</h3>
                                                                                <!-- tools box -->
              <div class="pull-right box-tools">
                                                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-products">
                                            <i class="fa fa-search" aria-hidden="true"></i> Buscar Productos</button>
              </div>
              <!-- /. tools -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                    <div class="table-responsive no-padding">
                                        <table id="agregados" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Marca</th>
                                                    <th>Categoría</th>
                                                    <th>Unidad</th>
                                                    <th>Fecha de Vencimiento</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo/u</th>
                                                    <th>Subtotal</th>
                                                    <th>Quitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <div class="box-footer">
  <div class="row">
              <!-- .col -->
              <div class="col-lg-offset-9 col-lg-3 text-center">
                  <p class=" text-muted"> Total </p>
                  <h5 class="text-bold">Q 0.00</h5>
                <p class="text-sm"> *Debe llenar los campos obligatorios</p>
              </div>
              <!-- /.col -->
            </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 pull-left">
                                            <input type="hidden" name="compra" value="nueva">
                                            <input type="hidden" id="total" name="total" value="0">
                                            <button type="submit" class="btn btn-primary pull-left" id="crear-compra">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Confirmar compra</button>
                                        </div>
                                    </div>

                                </div>
                                    </form>

                                </div>
                                <!-- /.box-body -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            `,
        data() {
            return {
                message: 'Hello Vue!'
            };
        },
        computed: {},
        methods: {

        },
        mounted() {
            // CUANDO SE MONTA LA APP
            $.fn.datepicker.defaults.language = 'es';

            $('#datepicker, #datepicker2')
                .datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true
                })
                .datepicker('setDate', moment(new Date()).format('DD/MM/YYYY'));
        }
    });
    </script>

    <!-- Vue Components -->
    <script src="vue/components/selects/providers.js"></script>
    <!-- Vue Components -->

    <?php
include_once 'vue/templates/footer.html';
?>