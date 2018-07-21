$(document).ready(function () {
    $('.agregar_producto').on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

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
                    nuevaFila += "<td><img src='img/products/" + registro.picture  + "'width='80' onerror='ImgError(this);'></td>";
                    nuevaFila +="<td>" + registro.productName +"</td>";
                    nuevaFila +="<td>" + registro.productCode +"</td>";
                    nuevaFila +="<td>" + +"</td>";
                    nuevaFila +="<td>" + +"</td>";
                    nuevaFila +="<td>" + +"</td>";
                    nuevaFila +="<td>" + +"</td>";
                    nuevaFila +="<td>" + +"</td>";
                    nuevaFila +="<td>" + +"</td>";
                    nuevaFila +="<td>" + +"</td>";
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
    source.src="img/products/notfound.jpg";
    source.onerror = "";
    return true;
}