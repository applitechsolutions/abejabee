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
                            <a></a>
                        </li>
                        <li>
                        <a id="inicio-item" onclick="openLink('inicio-item', 'inicio')"><i class="tablink fa fa-home fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a></a>
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-shopping-cart fa-fw"></i> Ventas</a>
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-truck fa-fw"></i> Rutas</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-hospital-o fa-fw"></i> Clientes</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-th-list fa-fw"></i> Catalogo</a>                            
                        </li>
                        <li>
                            <a><i class=""></i></a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-medkit fa-fw"></i> Compras</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa  fa-sitemap fa-fw"></i> Proveedores</a>
                        </li>
                        <li>
                            <a><i class=""></i></a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-users fa-fw"></i> Vendedores</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-user fa-fw"></i> Usuarios</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-bar-chart-o fa-fw"></i> Reportes</a>
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
                        <h1 class="page-header">Inventario</h1>
		                <?php include 'usuarios.php'; ?>
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


