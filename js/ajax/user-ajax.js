$(document).ready(function() {
    $('#nuevo-usuario').on('submit', function(e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data){
                var resultado = data;
                if (resultado.respuesta = 'exito') {
                    swal(
                        'Exito!',
                        'Usuario creado correctamente!',
                        'success'
                      )
                }
            }
        })
        
    });
});