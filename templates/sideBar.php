  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
      <div class="pull-left image">
          <img src="img/user.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['nombre']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Enlinea</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

       <!-- MODAL correlativo -->
       <div class="modal fade" id="modal-correlativo">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title"><i class="glyphicon glyphicon-cog"></i> Correlativo de facturas</h4>
                </div>
                <div class="modal-body">
                  <form role="form" id="form-departamento" name="form-departamento" method="post" action="BLL/department.php">
                    <div class="form-group">
                      <span class="text-danger text-uppercase">*</span>
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Escriba un nombre" autofocus>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="departamento" value="nuevo">
                      <button type="submit" class="btn btn-info" id="crear-departamento">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                      <span class="text-warning w3-small w3-padding">*Debe llenar los campos obligatorios</span>
                      <button id="depClose" type="button" class="btn btn-danger w3-round-medium pull-right" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menú de Administración</li>
        <li class="treeview">
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
          <i class="glyphicon glyphicon-tags" aria-hidden="true"></i>
            <span>Ventas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listSalesC.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Ver Todas</a></li>
            <?php 
            if ($_SESSION['rol'] == 1) {?>
            <li><a href="newSale.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nueva Venta</a></li><?php
            }
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
          <i class="fa fa-users" aria-hidden="true"></i>
            <span>Clientes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listCustomers.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Ver Todos</a></li>
            <?php 
            if ($_SESSION['rol'] == 1) {?>
            <li><a href="newCostumer.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Cliente</a></li><?php
            }
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
          <i class="fa fa-truck" aria-hidden="true"></i>
          <span>Rutas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listRoutes.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Ver Todas</a></li>
            <?php 
            if ($_SESSION['rol'] == 1) {?>
            <li><a href="newRoute.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nueva Ruta</a></li><?php
            }
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
          <i class="fa fa-th" aria-hidden="true"></i>
            <span>Productos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listProducts.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Ver Todos</a></li>
            <?php 
            if ($_SESSION['rol'] == 1) {?>
            <li><a href="newProduct.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Producto</a></li><?php
            }
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
          <i class="fa fa-male" aria-hidden="true"></i>
            <span>Proveedores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listProviders.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Ver Todos</a></li>
            <?php 
            if ($_SESSION['rol'] == 1) {?>
            <li><a href="newProvider.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Proveedor</a></li><?php
            }
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
          <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <span>Compras</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listPurchase.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Ver Todas</a></li>
            <?php 
            if ($_SESSION['rol'] == 1) {?>
            <li><a href="newPurchase.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nueva Compra</a></li><?php
            }
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
          <i class="fa fa-briefcase" aria-hidden="true"></i>
            <span>Vendedores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listSellers.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Ver Todos</a></li>
            <?php 
            if ($_SESSION['rol'] == 1) {?>
            <li><a href="newSeller.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Vendedor</a></li><?php
            }
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
          <i class="fa fa-user" aria-hidden="true"></i>
            <span>Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listUsers.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Ver Todos</a></li>
            <?php 
            if ($_SESSION['rol'] == 1) {?>
            <li><a href="newUser.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Usuario</a></li><?php
            }
            ?>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->