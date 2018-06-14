<?php include(HTML_DIR.'overall/header.php')?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Iniciar Sesión</h3>
                    </div>
                    <div class="panel-body">
                        <div id="_AJAX_LOGIN_">                            
                        </div>
                        <form role="form" onkeypress="return runScriptLogin(event)" >
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" id="user_login" placeholder="Nombre de Usuario" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="pass_login" placeholder="Contraseña" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" id="session" type="checkbox" value="Remember Me">Recordarme
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="button" class="btn btn-default btn-success btn-block" onclick="goLogin()"><span class="fa fa-power-off"> Ingresar</span></button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include(HTML_DIR.'overall/footer.php'); ?>

</body>