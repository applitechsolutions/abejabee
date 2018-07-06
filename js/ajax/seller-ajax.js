$(document).ready(function() {
    //$('#crear-vendedor').attr('disabled', false);
    // function validacion() {
    //     var nombre = $('#nombre-vendedor').val();
    //     var apellido = $_POST['apel-vendedor'];
    //     var direccion = $_POST['direc-vendedor'];
    //     var telefono = $_POST['tel-vendedor'];
    //     var dpi = $_POST['dpi-vendedor'];
    //     var bday = $_POST['bday-vendedor'];
    //     var genero = $_POST['gen-vendedor'];

    //     if (nombre == '' || apellido == '' || usuario == '' || rol == '' || password == '' || conf_pass == '') {
    //         $('#crear-usuario').attr('disabled', true);
    //     } else {
    //         $('#crear-usuario').attr('disabled', false);
    //     }
    // }

    $('#form-vendedor').on('submit', function(e) {
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
                            window.location.href = 'listSellers.php';
                        }, 1500);
                    }
                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Debe llenar todos los campos',
                      })
                }else if (resultado.respuesta == 'error'){
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
    $('.borrar_vendedor').on('click', function(e) {
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
                        'reg-vendedor': 'eliminar'
                    },
                    url: 'BLL/'+tipo+'.php',
                    success(data){
                        console.log(data);
                        var resultado = JSON.parse(data);
                        if (resultado.respuesta == 'exito') {
                            swal(
                                'Eliminado!',
                                'El vendedor ha sido borrado con exito.',
                                'success'
                              )
                            jQuery('[data-id="'+resultado.id_eliminado+'"]').parents('tr').remove(); 
                        }else {
                            swal({
                                type: 'error',
                                title: 'Error!',
                                text: 'No se pudo eliminar el vendedor.'
                              })
                        }
                        
                    }
                });
            });
    });
});