$(document).ready(function() {
    $('#form-login').on('submit', function(e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        swal({
            title: 'Iniciando sesión...'
        });
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data){
                console.log(data);
                var resultado = data;
                swal.close();
                if (resultado.respuesta == 'exitoso') {
                    swal(
                        'Login Correcto!',
                        'Bienvenid@ '+resultado.usuario+'!!'
                      )
                      setTimeout(function() {
                          window.location.href = 'index.php';
                      }, 1000);
                } else {
                    swal({
                        type: 'error',
                        title: 'Error!',
                        text: 'Usuario o Contraseña incorrectos, intente de nuevo',
                      })
                }
            }
        })
        
    });
});