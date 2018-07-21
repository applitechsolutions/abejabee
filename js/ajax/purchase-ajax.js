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
                    
                    nuevaFila += "<td>" + registro.idProduct + "</td>";
                    
                });      
                nuevaFila += "</tr>";         
                $("#agregados").append(nuevaFila);
            },
            error: function (data) {
                alert('error');
            }
        });
    });
});