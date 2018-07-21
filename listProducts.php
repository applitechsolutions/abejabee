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
      <i class="fa fa-th"></i>
        Productos
        <small>Catálogo</small>
      </h1>
    </section>

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
                  <th>Nombre</th>
                  <th>Código</th>
                  <th>Costo</th>
                  <th>Descripción</th>
                  <th>Marca</th>
                  <th>Categoría</th>
                  <th>Unidad</th>
                  <th>Imagen</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  try{
                    $sql = "SELECT idProduct, productName, productCode, cost, description, picture,
                    (select makeName from make where idMake = P._idMake and state = 0) as make,
                    (select catName from category where idCategory = P._idCategory and state = 0) as category,
                    (select unityName from unity where idUnity = P._idUnity and state = 0) as unity
                    FROM product P WHERE state = 0";
                    $resultado = $conn->query($sql);
                  } catch (Exception $e){
                    $error= $e->getMessage();
                    echo $error;
                  }
                  
                  while ($product = $resultado->fetch_assoc()) {
                ?>
                    <tr>
                      <td><?php echo $product['productName']; ?></td>
                      <td><?php echo $product['productCode']; ?></td>
                      <td>Q <?php echo $product['cost']; ?></td>
                      <td><?php echo $product['description']; ?></td>
                      <td><?php echo $product['make']; ?></td>
                      <td><?php echo $product['category']; ?></td>
                      <td><?php echo $product['unity']; ?></td>
                      <td><img src="img/products/<?php echo $product['picture']; ?>" width="100" onerror="this.src='img/products/notfound.jpg';"></td>
                      <td>
                        <a class="btn bg-green btn-flat margin" href="editProduct.php?id=<?php echo $product['idProduct'] ?>"><i class="fa fa-pencil"></i></a>
                        <a href="#" data-id="<?php echo $product['idProduct']; ?>" data-tipo="product" class="btn bg-maroon btn-flat margin borrar_product"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                <?php }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Código</th>
                  <th>Costo</th>
                  <th>Descripción</th>
                  <th>Marca</th>
                  <th>Categoría</th>
                  <th>Unidad</th>
                  <th>Imagen</th>
                  <th>Acciones</th>
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
