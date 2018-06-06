function goLogin() {
    var connect, form, response, result;
    form = 'variable-contenido';
    connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    connect.onreadystatechange = function(){
        if (connect.readyState == 4 && connect.status == 200) {
            
        } else if(connect.readyState != 4 ){

        }
    }  

    connect.open('POST', 'Ajax.php?mode=login', true);
    connect.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    connect.send(form);
    
}

function runScriptLogin(e) {
    if (e.keyCode == 13) {
        goLogin();
    }
}