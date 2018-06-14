<!--////////////////////////MODAL USUARIO////////////////////////////////////////////////////////-->
    <div class="w3-container">
    <button onclick="document.getElementById('modal_new_user').style.display='block'" class="w3-button w3-blue w3-large w3-round-large w3-right fa fa-plus"> Nuevo</button>
        <div id="modal_new_user" class="w3-modal">
    
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                <div id="form" class="w3-card-2 w3-white col-lg-12 col-md-8 col-sm-8 col-xs-10">
                    <header>
                        <h3><i class="fa fa-user"></i> Agregar Usuario</h3>
                        <span onclick="document.getElementById('modal_new_user').style.display='none'" class="w3-closebtn fa fa-times fa-2x"</span>
                    </header>
                    <div id="_AJAX_INSERT_">                            
                        </div>
                    <div class="w3-container">
                        <div class="w3-half w3-padding-small">
                            <br>
                            <label class="w3-left">Nombre</label>
                            <input id="nombre_usuario" name="nombre" class="w3-input" type="text" placeholder="Ingrese su nombre">
                            <br>
                            <label class="w3-left">Apellido</label>
                            <input id="apel_usuario" name="apel" class="w3-input" type="text" placeholder="Ingrese su apellido">
                        </div>
                        <div class="w3-half w3-padding-small">
                            <br>
                            <label class="w3-left">Nombre de Usuario</label>
                            <input id="username" name="user" class="w3-input" type="text" placeholder="Ingrese su nombre de usuario">
                            <br>
                            <label class="w3-left">Contraseña</label>
                            <input id="password" name="pass" class="w3-input" type="password" placeholder="Ingrese una contraseña">
                        </div>
                    </div>
                    <footer class="modal-footer">
                        <button class="w3-btn w3-round w3-light-gray w3-hover-red" id="cancel-add-empleado" onclick="document.getElementById('modal_new_user').style.display='none'"> Cancelar</button>
                        <button class="w3-btn w3-round w3-green" onclick="newUser()"><i class="fa fa-floppy-o"></i> Guardar</button>
                    </footer>
                </div>
            </div>
        </div>
    </div>
<!--////////////////////////MODAL USUARIO////////////////////////////////////////////////////////-->