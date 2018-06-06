<?php include(HTML_DIR.'overall/header.php')?>

<body>
    <div class="container">
        <div id="_AJAX_LOGIN_">
            <div class="alert alert-dismissible alert-warning">
                <button class="close" type="button" data-dismiss="alert">&times;</button>
                <h4 class="alert-heading">Warning!</h4>
                <p class="mb-0">Best check yo self, you're not looking too good. Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, <a class="alert-link" href="#">vel scelerisque nisl consectetur et</a>.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" onkeypress="return runScriptLogin(event)" >
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
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