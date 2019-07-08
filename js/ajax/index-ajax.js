$(document).ready(function() {
    $('.listarStock').on('click', function(e) {

        e.preventDefault();
        $('#contenidoExp').html("");
        $('#nombre-producto').html("");

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Cargando detalle de existencia...'
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
                    nuevaFila += "<td class='text-center'><h5>" + registro.stock + "</h5></td>";
                    if (registro.dateExp === null) {
                        nuevaFila += "<td><input type='text' class='form-control margin datepicker datepick' id='new_" + registro.idStorage + "_date' name='date' style='width: 70%;'></input></td>";
                    } else {
                        nuevaFila += "<td><input type='text' class='form-control margin datepicker datepick' id='new_" + registro.idStorage + "_date' name='date' style='width: 70%;' value='" + convertDate(registro.dateExp) + "'></input></td>";
                    }
                    nuevaFila += '<td><a id="boton" href="#" onclick="editarStorage(' + registro.idStorage + '); return false;" class="btn bg-green btn-lg margin"><i class="fa fa-pen-square"></i></a></td>';
                    nuevaFila += "</tr>";
                    $("#contenidoExp").append(nuevaFila);
                });
                $('#nombre-producto').append(nombreproducto);
                swal.close();
                $('#modal-stock').modal('show');
                $('.datepick').datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true
                });
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

function editarStorage(id) {

    var dateV = $('#new_' + id + '_date').val();

    if (dateV === "") {
        swal({
            type: 'error',
            title: 'Error',
            text: 'Ingrese una fecha valida',
        });
    } else {
        $.ajax({
            type: 'POST',
            data: {
                'id': id,
                'dateV': dateV,
                'storage': 'editar'
            },
            url: 'BLL/storage.php',
            success(data) {
                console.log(data);
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: '¡Fecha actualizada con éxito!',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Error en la base de datos',
                });
            }
        });
    }
}