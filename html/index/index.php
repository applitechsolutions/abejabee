<?php include(HTML_DIR.'overall/header.php')?>
<?php
     if (!isset($_SESSION['app_id'])){
      include(HTML_DIR.'public/login.php');
     }
   else { ?>

   <body onload="openLink('inicio-item', 'inicio')">
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Schlenker Pharma S.A.</a>
            </div>
            
            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <?php
                        echo '<li><a href="#"><i class="fa fa-user fa-fw"></i>'. strtoupper($users[$_SESSION['app_id']]['userName']) . '</a> </li>';
                        ?>
                        <li class="divider"></li>
                        <li><a href="?view=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">                
                <div class="sidebar-nav navbar-collapse">                
                    <ul class="nav" id="side-menu">
                        <li>
                        <button id="inicio-item" onclick="openLink('inicio-item', 'inicio')" class="btn btn-outline btn-primary btn-lg btn-block">
                        <div class="w3-col" style="width: 30px">    
                        <i class="tablink fa fa-home fa-fw"></i>
                        </div>  
                             Inicio</button>
                        </li>
                        <li>
                            <button id="venta-item" onclick="openLink('venta-item','venta')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-shopping-cart fa-fw"></i> 
					  			</div>                               
                                Ventas</button>
                        </li>
                        <li>
                            <button id="ruta-item" onclick="openLink('ruta-item','ruta')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-truck fa-fw"></i> 
					  			</div>                               
                                Rutas</button>
                        </li>
                        <li>
                        <button id="cliente-item" onclick="openLink('cliente-item','cliente')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-hospital-o fa-fw"></i> 
					  			</div>                               
                                Clientes</button>
                        </li>
                        <li>
                             <button id="catalogo-item" onclick="openLink('catalogo-item','catalogo')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-th-list fa-fw"></i> 
					  			</div>                               
                                Catalogo</button>                            
                        </li>
                        <li>
                            <button id="compra-item" onclick="openLink('compra-item','compra')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-medkit fa-fw"></i> 
					  			</div>                               
                                Compras</button>
                        </li>
                        <li>
                            <button id="proveedor-item" onclick="openLink('proveedor-item','proveedor')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-sitemap  fa-fw"></i> 
					  			</div>                               
                                Proveedores</button>
                        </li>
                        <li>
                            <button id="vendedor-item" onclick="openLink('vendedor-item','vendedor')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-users fa-fw"></i> 
					  			</div>                               
                                Vendedores</button>
                        </li>
                        <li>
                            <button id="usuario-item" onclick="openLink('usuario-item','usuario')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-user fa-fw"></i> 
					  			</div>                               
                                Usuarios</button>
                        </li>
                        <li>
                            <button id="reporte-item" onclick="openLink('reporte-item','reporte')" class="btn btn-outline btn-primary btn-lg btn-block">
                            <div class="w3-col" style="width: 30px">
                            <i class="tablink fa fa-bar-chart-o fa-fw"></i> 
					  			</div>                               
                                Reportes</button>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
                    <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div id="inicio" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Inventario</h2>
		                <?php include 'inventario.php'; ?>
	                    </div>

                        <div id="venta" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Ventas</h2>
		                <?php include 'venta.php'; ?>
                        </div>
                        
                        <div id="ruta" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Rutas</h2>
		                <?php include 'ruta.php'; ?>
                        </div>
                        
                        <div id="cliente" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Clientes</h2>
		                <?php include 'cliente.php'; ?>
                        </div>
                        
                        <div id="catalogo" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Catalogo</h2>
		                <?php include 'catalogo.php'; ?>
                        </div>
                        
                        <div id="compra" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Compras</h2>
		                <?php include 'compra.php'; ?>
                        </div>
                        
                        <div id="proveedor" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Proveedores</h2>
		                <?php include 'proveedor.php'; ?>
                        </div>
                        
                        <div id="vendedor" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Vendedores</h2>
		                <?php include 'vendedor.php'; ?>
                        </div>
                        
                        <div id="usuario" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Usuarios</h2>
		                <?php include 'usuario.php'; ?>
                        </div>
                        
                        <div id="reporte" class="city w3-animate-left hidden-section">
                        <h2 class="page-header">Reportes</h2>
		                <?php include 'reporte.php'; ?>
	                    </div>
                    <!-- /.col-lg-12 -->
                     </div>                
                <!-- /.row -->
               
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
                        <!-- /.panel-body -->
    <?php include(HTML_DIR.'overall/footer.php'); ?>    
</body>
</html>   
  <?php 
   }
  ?>


