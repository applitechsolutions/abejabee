$(document).ready(function () {

    $('.agregar_producto').on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        

        $(this).attr('disabled', true);

        $.ajax({
            type: 'POST',
            data: {
                'id': id,
                'producto': 'agregar'
            },
            url: 'BLL/' + tipo + '.php',
            success(data) {
                console.log(data);

                var nuevaFila = "<tr>";
                $.each(data, function (key, registro) {
                    var costo = $('#new_'+ registro.idProduct + '_costo').val();
                    var cantidad = $('#new_'+ registro.idProduct + '_cantidad').val();
                    var subtotal = costo * cantidad;
                    nuevaFila += "<td><img src='img/products/" + registro.picture + "'width='80' onerror='ImgError(this);'></td>";
                    nuevaFila += "<td><input type='hidden' value='"+ registro.idProduct +"'>" + registro.productName + "</td>";
                    nuevaFila += "<td>" + registro.productCode + "</td>";
                    nuevaFila += "<td>" + registro.make + "</td>";
                    nuevaFila += "<td>" + registro.category + "</td>";
                    nuevaFila += "<td>" + registro.unity + "</td>";
                    nuevaFila += "<td>Q." + costo +"</td>";
                    nuevaFila += "<td>" + cantidad +"</td>";
                    nuevaFila += "<td>Q." + subtotal +"</td>";
                    nuevaFila += "<td><a id='quitar' onclick='eliminar();' data-id='"+ registro.idProduct + "' class='btn bg-maroon btn-flat margin quitar_product'><i class='fa fa-remove'></i></a></td>";
                });
                nuevaFila += "</tr>";
                $("#agregados").append(nuevaFila);
            },
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'No se puede agregar al carrito',
                })
            }
        });
    });
});


function ImgError(source) {
    source.src = "img/products/notfound.jpg";
    source.onerror = "";
    return true;
}

function eliminar(id) {
    id = $('#quitar').attr('data-id');
    jQuery('[data-id="' + id + '"]').parents('tr').remove();
    
    $('.agregar_producto').jQuery('[data-id="' + id + '"]').attr('disabled', false);
}