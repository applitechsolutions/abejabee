$(document).ready(function() {
    $('#crear-usuario').attr('disabled', true);
    function validacion() {
        var nombre = $('#nombre').val();
        var apellido = $('#apellido').val();
        var usuario = $('#usuario').val();
        var password = $('#password').val();
        var conf_pass = $('#confirmar_password').val();
        var rol = $('#rol').val();

        if (nombre == '' || apellido == '' || usuario == '' || rol == '' || password == '' || conf_pass == '') {
            $('#crear-usuario').attr('disabled', true);
        } else {
            $('#crear-usuario').attr('disabled', false);
        }
    }

    $('#form-usuario').on('submit', function(e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data){
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal(
                        'Exito!',
                        '¡'+resultado.mensaje,
                        'success'
                      )
                } else {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar en la base de datos',
                      })
                }
            }
        })
        
    });

    $('#nombre').on('blur', function(){
        if ($(this).val() !== null && $(this).val() !== '') {
            $('#nombre').parents('.form-group').addClass('has-success').removeClass('has-error');
            validacion();
        }else {
            $('#nombre').parents('.form-group').addClass('has-error').removeClass('has-success');
        }
    });
    $('#apellido').on('blur', function(){
        if ($(this).val() !== null && $(this).val() !== '') {
            $('#apellido').parents('.form-group').addClass('has-success').removeClass('has-error');
            validacion();
        }else {
            $('#apellido').parents('.form-group').addClass('has-error').removeClass('has-success');
        }
    });
    $('#usuario').on('blur', function(){
        if ($(this).val() !== null && $(this).val() !== '') {
            $('#usuario').parents('.form-group').addClass('has-success').removeClass('has-error');
            validacion();
        }else {
            $('#usuario').parents('.form-group').addClass('has-error').removeClass('has-success');
        }
    });
    $('#confirmar_password').on('input', function(){
        var password_nuevo = $('#password').val();

        if ($(this).val() == password_nuevo) {
            $('#resultado-password').text('Correcto!');
            $('#resultado-password').parents('.form-group').addClass('has-success').removeClass('has-error');
            $('input#password').parents('.form-group').addClass('has-success').removeClass('has-error');
            validacion();
        }else {
            $('#resultado-password').text('No coinciden!');
            $('#resultado-password').parents('.form-group').addClass('has-error').removeClass('has-success');
            $('input#password').parents('.form-group').addClass('has-error').removeClass('has-success');
            $('#crear-usuario').attr('disabled', true);
        }
    });
    $('#rol').on('blur', function(){
        if ($(this).val() !== null && $(this).val() !== '') {
            $('#rol').parents('.form-group').addClass('has-success').removeClass('has-error');
            validacion();
        }else {
            $('#rol').parents('.form-group').addClass('has-error').removeClass('has-success');
        }
    });

    //////VALIDACIONES/////////////////////
    


});