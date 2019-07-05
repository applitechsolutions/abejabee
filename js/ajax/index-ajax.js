$(document).ready(function() {
    $('.listarStock').on('click', function(e) {

        e.preventDefault();
        $('#contenidoExp').html("");

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Cargando comisiones...'
        });

        swal.showLoading();
        $.ajax({
            type: "POST",
            data: {
                "id": id
            },
            url: "BLL/" + tipo + ".php",
            success: function(data) {
                console.log(data);
                $.each(data, function(key, registro) {
                    var nombredetalle = "<h3 class='box-title'>" + registro.nombre + " " + registro.apellido + "</h3>";
                    $('#nombre-vendedor').append(nombredetalle);
                    var nuevaFila = "<tr>";
                    nuevaFila += "<td>" + registro.stock + "</td>";
                    nuevaFila += "<td>" + registro.dateExp + "</td>";
                    nuevaFila += "</tr>";
                    $("#contenidoExp").append(nuevaFila);
                });
                swal.close();
                $('#modal-stock').modal('show');
            },
            error: function(data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error, intente más tarde :(' + data.responseText,
                });
            }
        });

    });
});