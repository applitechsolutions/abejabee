$(document).ready(function() {
    $('.listarStock').on('click', function(e) {

        e.preventDefault();
        $('#contenidoExp').html("");
        $('#nombre-producto').html("");

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
                var nombreproducto;
                $.each(data, function(key, registro) {
                    nombreproducto = "<h3 class='box-title'>" + registro.code + " " + registro.name + "</h3>";
                    var nuevaFila = "<tr>";
                    nuevaFila += "<td>" + registro.stock + "</td>";
                    nuevaFila += "<td>" + convertirDate(registro.dateExp) + "</td>";
                    nuevaFila += "</tr>";
                    $("#contenidoExp").append(nuevaFila);
                });
                $('#nombre-producto').append(nombreproducto);
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

function convertirDate(dateString) {

    if (dateString === null) {
        return dateString;
    } else {
        var p = dateString.split(/\D/g)
        return [p[2], p[1], p[0]].join("-");
    }

}