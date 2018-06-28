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

    // ///////////ELIMINAR USUARIO//////////////////
    // $('.borrar_usuario').on('click', function(e) {
    //     e.preventDefault();

    //     var id = $(this).attr('data-id');
    //     var tipo = $(this).attr('data-tipo');

    //     swal({
    //         title: '¿Estás Seguro?',
    //         text: "Un registro eliminado no puede recuperarse",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Sí, Eliminar!',
    //         cancelButtonText: 'Cancelar'
    //       }).then((result) => {
    //             $.ajax({
    //                 type: 'POST',
    //                 data: {
    //                     'id': id,
    //                     'registro': 'eliminar'
    //                 },
    //                 url: 'BLL/'+tipo+'.php',
    //                 success(data){
    //                     console.log(data);
    //                     var resultado = JSON.parse(data);
    //                     if (resultado.respuesta == 'exito') {
    //                         swal(
    //                             'Eliminado!',
    //                             'El usuario ha sido borrado con exito.',
    //                             'success'
    //                           )
    //                         jQuery('[data-id="'+resultado.id_eliminado+'"]').parents('tr').remove(); 
    //                     }else {
    //                         swal({
    //                             type: 'error',
    //                             title: 'Error!',
    //                             text: 'No se pudo eliminar el usuario.'
    //                           })
    //                     }
                        
    //                 }
    //             });
    //         });
    // });

    // $('#nombre').on('blur', function(){
    //     if ($(this).val() !== null && $(this).val() !== '') {
    //         $('#nombre').parents('.form-group').addClass('has-success').removeClass('has-error');
    //         validacion();
    //     }else {
    //         $('#nombre').parents('.form-group').addClass('has-error').removeClass('has-success');
    //     }
    // });
    // $('#apellido').on('blur', function(){
    //     if ($(this).val() !== null && $(this).val() !== '') {
    //         $('#apellido').parents('.form-group').addClass('has-success').removeClass('has-error');
    //         validacion();
    //     }else {
    //         $('#apellido').parents('.form-group').addClass('has-error').removeClass('has-success');
    //     }
    // });
    // $('#usuario').on('blur', function(){
    //     if ($(this).val() !== null && $(this).val() !== '') {
    //         $('#usuario').parents('.form-group').addClass('has-success').removeClass('has-error');
    //         validacion();
    //     }else {
    //         $('#usuario').parents('.form-group').addClass('has-error').removeClass('has-success');
    //     }
    // });
    // $('#confirmar_password').on('input', function(){
    //     var password_nuevo = $('#password').val();

    //     if ($(this).val() == password_nuevo) {
    //         $('#resultado-password').text('Correcto!');
    //         $('#resultado-password').parents('.form-group').addClass('has-success').removeClass('has-error');
    //         $('input#password').parents('.form-group').addClass('has-success').removeClass('has-error');
    //         validacion();
    //     }else {
    //         $('#resultado-password').text('No coinciden!');
    //         $('#resultado-password').parents('.form-group').addClass('has-error').removeClass('has-success');
    //         $('input#password').parents('.form-group').addClass('has-error').removeClass('has-success');
    //         $('#crear-usuario').attr('disabled', true);
    //     }
    // });
    // $('#rol').on('blur', function(){
    //     if ($(this).val() !== null && $(this).val() !== '') {
    //         $('#rol').parents('.form-group').addClass('has-success').removeClass('has-error');
    //         validacion();
    //     }else {
    //         $('#rol').parents('.form-group').addClass('has-error').removeClass('has-success');
    //     }
    // });

    //////VALIDACIONES/////////////////////
    


});