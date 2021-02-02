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
    <style>
    #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Add animation to "page content" */
    .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }

        to {
            bottom: 0px;
            opacity: 1
        }
    }

    @keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }

        to {
            bottom: 0;
            opacity: 1
        }
    }

    #myDiv {
        display: none;
        text-align: center;
    }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div id="app" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            <i class="fa fa-users"></i>
        Clientes
        <small>Todos</small>
            </h1>
        </section>
        <customers></customers>
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
    Vue.component('customers', {
        template: /*html*/ `
            <div>
                   <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
              <h3 class="box-title">Listado general de los clientes</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table id="registros" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Nit</th>
                    <th>Ruta</th>
                    <th>Dirección</th>
                    <th>Departamento</th>
                    <th>Municipio</th>
                    <th>Aldea</th>
                    <th>Dueño</th>
                    <th>Encargado</th>
                      <th><span class="fa fa-cogs"></span></th>
                    </tr>
                  </thead>
                  <tbody>
   <tr v-for="customer of customers">
                        <td>
                        <span class=" text-muted text-sm">{{ customer.customerCode }}</span>
                            <input @change="editCustomer(customer)" v-model="customer.customerCode" class="form-control input-sm" type="text" :value="customer.customerCode">
                        </td>
                        <td>
                        <span class=" text-muted text-sm">{{ customer.customerName }}</span>
                        <textarea @change="editCustomer(customer)" v-model="customer.customerName" class="form-control" rows="3" type="text" :value="customer.customerName"></textarea>
                        </td>
                        <td>
                            <input @change="editCustomer(customer)" v-model="customer.customerTel" class="form-control input-sm" type="text" :value="customer.customerTel">
                        </td>
                        <td>
                            <input @change="editCustomer(customer)" v-model="customer.customerNit" class="form-control input-sm" type="text" :value="customer.customerNit">
                        </td>
                        <td>
                        {{customer.roName}}
                        </td>
                        <td>
                        <span class=" text-muted text-sm">{{ customer.customerAddress }}</span>
                        <textarea @change="editCustomer(customer)" v-model="customer.customerAddress" class="form-control" rows="3" type="text" :value="customer.customerAddress"></textarea>
                        </td>
                        <td>
                        {{customer.depName}}
                        </td>
                        <td>
                        {{customer.townName}}
                        </td>
                        <td>
                        {{customer.villaName}}
                        </td>
                        <td>
                        {{customer.owner}}
                        </td>
                        <td>
                        {{customer.inCharge}}
                        </td>
                        <td>
                                                <?php
                        if ($_SESSION['rol'] == 1) {?>
                          <a class="btn bg-green btn-flat margin" :href="'editCustomer.php?id=' + customer.idCustomer">
                          <i class="fas fa-pen-square"></i>
                          </a>
                          <a @click="deleteCustomer(customer.idCustomer)" :data-id="customer.idCustomer" href="#" class="btn bg-maroon btn-flat margin">
                            <i class="fa fa-trash"></i>
                          </a><?php
                        }else if ($_SESSION['rol'] == 2) {?>
                        -
                          <?php
                        }
                        ?>
                        </td>
                      </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Nit</th>
                    <th>Ruta</th>
                    <th>Dirección</th>
                    <th>Departamento</th>
                    <th>Municipio</th>
                    <th>Aldea</th>
                    <th>Dueño</th>
                    <th>Encargado</th>
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
            `,
        data() {
            return {};
        },
        computed: {
            ...Vuex.mapState(['customers'])
        },
        methods: {
            ...Vuex.mapActions(['getCustomers', 'editCustomer']),
            deleteCustomer(id) {
                // console.log('OK');
                // console.log(id);
                swal({
                    title: '¿Estás Seguro?',
                    text: "Un registro eliminado no puede recuperarse",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, Eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then(() => {
                    $.ajax({
                        type: 'POST',
                        data: {
                            'id': id,
                            'customer': 'eliminar'
                        },
                        url: 'BLL/customer.php',
                        success(data) {
                            // console.log(data);
                            var resultado = JSON.parse(data);
                            if (resultado.respuesta == 'exito') {
                                swal('Eliminado!', 'El cliente ha sido borrado con exito.',
                                    'success');
                                jQuery('[data-id="' + resultado.id_eliminado + '"]').parents(
                                    'tr').remove();
                            } else {
                                swal({
                                    type: 'error',
                                    title: 'Error!',
                                    text: 'No se pudo eliminar el cliente.'
                                });
                            }
                        }
                    });
                })
            }
        },
        created() {
            // CUANDO SE MONTA LA APP
            this.getCustomers();
        },
    });
    </script>

    <?php
include_once 'vue/templates/footer.html';
?>