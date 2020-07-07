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
                <i class="fa fa-th"></i>
                Productos
                <small>Catálogo de productos</small>
            </h1>
        </section>
        <products></products>
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
    Vue.component('products', {
        template: /*html*/ `
            <div>
                   <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Listado general de productos en catálogo</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table id="registros" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Marca</th>
                      <th>Categoría</th>
                      <th>Unidad</th>
                      <th>Costo (Q.)</th>
                      <th>Exist. mín.</th>
                      <th>Descripción</th>
                      <th>Precios (Q.)</th>
                      <th><span class="fa fa-cogs"></span></th>
                    </tr>
                  </thead>
                  <tbody>
   <tr v-for="product of products">
                        <td>
                        {{ product.productCode }}
                        </td>
                        <td>
                        {{ product.productName }}
                        </td>
                        <td>
                        {{ product.make }}
                        </td>
                        <td>
                        {{ product.category }}
                        </td>
                        <td>
                        {{ product.unity }}
                        </td>
                        <td>
                        <input @change="editCostProduct(product)" v-model="product.cost" class="form-control input-sm" type="number" min="0.00" step="0.01" :value="product.cost">
                        </td>
                        <td class="text-center">
                        {{ product.minStock }}
                        </td>
                        <td>
                        {{ product.description }}
                        </td>
                        <td>
                        <table class="table table-striped">
                        <tbody>
                        <tr>
                        <td>Público</td>
                        <td><input v-model="product.public" @change="editPrice(product, 1)" class="form-control input-sm" type="number" min="0.00" step="0.01" :value="product.public"></td>
                        </tr>
                        <tr>
                        <td>Farmacia</td>
                        <td><input v-model="product.pharma" @change="editPrice(product, 11)" class="form-control input-sm" type="number" min="0.00" step="0.01" :value="product.pharma"></td>
                        </tr>
                        <tr>
                        <td>Negocio</td>
                        <td><input v-model="product.business" @change="editPrice(product, 21)" class="form-control input-sm" type="number" min="0.00" step="0.01" :value="product.business"></td>
                        </tr>
                        <tr>
                        <td>Bono</td>
                        <td><input v-model="product.bonus" @change="editPrice(product, 31)" class="form-control input-sm" type="number" min="0.00" step="0.01" :value="product.bonus"></td>
                        </tr>
                        </tbody>
                        </table>
                        </td>
                        <td>
                                                <?php
                        if ($_SESSION['rol'] == 1) {?>
                          <a class="btn bg-green btn-flat margin" :href="'editProduct.php?id=' + product.idProduct">
                          <i class="fas fa-pen-square"></i>
                          </a>
                          <a @click="deleteProduct(product.idProduct)" :data-id="product.idProduct" href="#" class="btn bg-maroon btn-flat margin">
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
                      <th>Marca</th>
                      <th>Categoría</th>
                      <th>Unidad</th>
                      <th>Costo (Q.)</th>
                      <th>Exist. mín.</th>
                      <th>Descripción</th>
                      <th>Precios (Q.)</th>
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
            ...Vuex.mapState(['products'])
        },
        methods: {
            ...Vuex.mapActions(['getProducts', 'editCostProduct', 'editPricesProduct']),
            editPrice(product, idPrice) {
                product.id_price = idPrice;
                switch (idPrice) {
                    case 1:
                        product.price = product.public;
                        break;
                    case 11:
                        product.price = product.pharma;
                        break;
                    case 21:
                        product.price = product.business;
                        break;
                    case 31:
                        product.price = product.bonus;
                        break;
                    default:
                        break;
                }
                this.editPricesProduct(product);
            },
            deleteProduct(id) {
                console.log('OK');
                console.log(id);
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
                            'producto': 'eliminar'
                        },
                        url: 'BLL/product.php',
                        success(data) {
                            // console.log(data);
                            var resultado = JSON.parse(data);
                            if (resultado.respuesta == 'exito') {
                                swal('Eliminado!', 'El producto ha sido borrado con exito.',
                                    'success');
                                jQuery('[data-id="' + resultado.id_eliminado + '"]').parents(
                                    'tr').remove();
                            } else {
                                swal({
                                    type: 'error',
                                    title: 'Error!',
                                    text: 'No se pudo eliminar el producto.'
                                });
                            }
                        }
                    });
                })
            }
        },
        created() {
            // CUANDO SE MONTA LA APP
            this.getProducts();
        },
    });
    </script>

    <?php
include_once 'vue/templates/footer.html';
?>