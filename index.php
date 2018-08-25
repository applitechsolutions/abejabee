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
          <i class="fa fa-archive"></i>
          Productos
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
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table id="registros" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Mínimo</th>
                      <th>Marca</th>
                      <th>Categoría</th>
                      <th>Unidad</th>
                      <th>Costo</th>
                      <th>Existencia</th>
                      <th>Imagen</th>
                      <th><span class="fa fa-cogs"></span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                  try{
                    $sql = "SELECT P.idProduct, P.productName, P.productCode, P.cost, P.minStock, P.picture, S.stock,
                    (select makeName from make where idMake = P._idMake and state = 0) as make,
                    (select catName from category where idCategory = P._idCategory and state = 0) as category,
                    (select unityName from unity where idUnity = P._idUnity and state = 0) as unity
                    FROM storage S INNER JOIN product P ON P.idProduct = S._idProduct WHERE P.state = 0";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($product = $resultado->fetch_assoc()) {
                ?>
                      <tr>
                        <td>
                          <?php echo $product['productCode']; ?>
                        </td>
                        <td>
                          <?php echo $product['productName']; ?>
                        </td>
                        <td class="text-center">
                        <?php
                        if ($product['minStock'] == $product['stock']) {?>
                          <span class="label label-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span><?php
                        }else if ($product['minStock'] > $product['stock']) {?>
                          <span class="label label-danger"><i class="fa fa-exclamation" aria-hidden="true"></i></span><?php
                        }?>
                        <?php echo $product['minStock']; ?>
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
                          <?php echo $product['stock']; ?>
                        </td>
                        <td>
                          <img src="img/products/<?php echo $product['picture']; ?>" width="100" onerror="this.src='img/products/notfound.jpg';">
                        </td>
                        <td>
                          <a class="btn bg-green btn-flat margin" href="newPurchase.php">
                            <i class="fa fa-shopping-cart"></i>
                          </a>
                        </td>
                      </tr>
                      <?php }
                ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Mínimo</th>
                      <th>Marca</th>
                      <th>Categoría</th>
                      <th>Unidad</th>
                      <th>Costo</th>
                      <th>Existencia</th>
                      <th>Imagen</th>
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
