<?php
  
  if ($_GET) {
    session_start();
    $cerrar_sesion = $_GET['cerrar_sesion'];
  } else {
    $cerrar_sesion = false;
  }
 
  if ($cerrar_sesion) {
    session_destroy();
  }
  include_once 'templates/header.php';
  include_once 'funciones/bd_conexion.php';
?>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <div class="pull-left image">
      <img src="img/Schlenker.jpeg" class="img-circle" alt="Login Image"><a href="login.php"><b>Schlenker</b>Pharma</a>
      </div>      
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Inicia Sesión Aquí</p>

      <form id="form-login" name="form-login" action="BLL/logueo.php" method="post">
        <div class="form-group has-feedback">
          <input id="usaurio-login" name="usaurio-login" type="text" class="form-control" placeholder="Usuario">
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input id="pass-login" name="pass-login"type="password" class="form-control" placeholder="Contraseña">
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <input type="hidden" name="ingresar" value="1">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

<?php
  include_once 'templates/footer.php';

?>
