function newUser() {
    var connect, form, response, result, firstName, lastName, userName, passWord;
    firstName = __('nombre_usuario').value;
    lastName = __('apel_usuario').value;
    userName = __('username').value;
    passWord = __('password').value;

    form = 'nombre=' + firstName + '&apel=' + lastName + '&user=' + userName + '&pass=' + passWord;
    connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    connect.onreadystatechange = function(){
        if (connect.readyState == 4 && connect.status == 200) {
            if (connect.responseText == 1) {
                result = '<div class="alert alert-dismissible alert-success">';
                result += '<button class="close" type="button" data-dismiss="alert">&times;</button>';
                result += '<h4 class="alert-heading">Ingreso Exitoso!</h4>';
                result += '<p class="mb-0"><strong>Estamos actualizando los registros</strong></p>';
                result += '</div>';
                __('_AJAX_INSERT_').innerHTML = result;
                __('modal_new_user').style.display = 'none';
                $("[name='nombre']").val('');
                $("[name='apel']").val('');
                $("[name='user']").val('');
                $("[name='pass']").val('');
                result = '';
                __('_AJAX_INSERT_').innerHTML = result;
            }else {
                __('_AJAX_INSERT_').innerHTML = connect.responseText;
            }
            
        } else if(connect.readyState != 4 ){
            result = '<div class="alert alert-dismissible alert-warning">';
            result += '<button class="close" type="button" data-dismiss="alert">&times;</button>';
            result += '<h4 class="alert-heading">Procesando...</h4>';
            result += '<p class="mb-0"><strong>Estamos intentando ingresar el registro...</strong></p>';
            result += '</div>';
            __('_AJAX_INSERT_').innerHTML = result;
        }
    }  

    connect.open('POST', 'ajax.php?mode=newUser', true);
    connect.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    connect.send(form);    
}
function runScriptLogin(e) {
    if (e.keyCode == 13) {
        goLogin();
    }
}