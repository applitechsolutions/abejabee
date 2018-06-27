$(document).ready(function() {
    $('#crear-proveedor').attr('disabled', true);
    function validacion() {
        var name = $('#name').val();
        var address = $('#address').val();
        var tel = $('#tel').val();
        var mobile = $('#mobile').val();
        var email = $('#email').val();
        var account1 = $('#account1').val();
        var account2 = $('#account2').val();
        var details = $('#details').val();

        if (name == '' || address == '' || tel == '') {
            $('#crear-proveedor').attr('disabled', true);
        } else {
            $('#crear-proveedor').attr('disabled', false);
        }
    }

    $('#form-provider').on('submit', function(e) {
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
                    if (resultado.proceso == 'nuevo') {
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else if (resultado.proceso == 'editado'){
                        setTimeout(function() {
                            window.location.href = 'listProviders.php';
                        }, 1500);
                    }
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

    ///////////ELIMINAR USUARIO//////////////////
    $('.borrar_proveedor').on('click', function(e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: '¿Estás Seguro?',
            text: "Un registro eliminado no puede recuperarse",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Eliminar!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
                $.ajax({
                    type: 'POST',
                    data: {
                        'id': id,
                        'registro': 'eliminar'
                    },
                    url: 'BLL/'+tipo+'.php',
                    success(data){
                        console.log(data);
                        var resultado = JSON.parse(data);
                        if (resultado.respuesta == 'exito') {
                            swal(
                                'Eliminado!',
                                'El proveedor ha sido borrado con exito.',
                                'success'
                              )
                            jQuery('[data-id="'+resultado.id_eliminado+'"]').parents('tr').remove(); 
                        }else {
                            swal({
                                type: 'error',
                                title: 'Error!',
                                text: 'No se pudo eliminar el proveedor.'
                              })
                        }
                        
                    }
                });
            });
    });

    $('#name').on('blur', function(){
        if ($(this).val() !== null && $(this).val() !== '') {
            $('#name').parents('.form-group').addClass('has-success').removeClass('has-error');
            validacion();
        }else {
            $('#name').parents('.form-group').addClass('has-error').removeClass('has-success');
        }
    });
    $('#address').on('blur', function(){
        if ($(this).val() !== null && $(this).val() !== '') {
            $('#address').parents('.form-group').addClass('has-success').removeClass('has-error');
            validacion();
        }else {
            $('#address').parents('.form-group').addClass('has-error').removeClass('has-success');
        }
    });
    $('#tel').on('blur', function(){
        if ($(this).val() !== null && $(this).val() !== '') {
            $('#tel').parents('.form-group').addClass('has-success').removeClass('has-error');
            validacion();
        }else {
            $('#tel').parents('.form-group').addClass('has-error').removeClass('has-success');
        }
    });
    //////VALIDACIONES/////////////////////
});