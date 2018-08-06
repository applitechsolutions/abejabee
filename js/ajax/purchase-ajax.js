$(document).ready(function () {
    var total = 0;

    $('.agregar_producto').on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');



        $(this).attr('hidden', true);

        $.ajax({
            type: 'POST',
            data: {
                'id': id,
                'producto': 'agregar'
            },
            url: 'BLL/' + tipo + '.php',
            success(data) {
                console.log(data);

                var nuevaFila = "<tr id='detalle'>";
                $.each(data, function (key, registro) {
                    var costo = $('#new_' + registro.idProduct + '_costo').val();
                    var cantidad = $('#new_' + registro.idProduct + '_cantidad').val();
                    var subtotal = costo * cantidad;
                    total = total + subtotal;
                    nuevaFila += "<td><img src='img/products/" + registro.picture + "'width='80' onerror='ImgError(this);'></td>";
                    nuevaFila += "<td><input class='idproducto_class' type='hidden' value='" + registro.idProduct + "'>" + registro.productName + "</td>";
                    nuevaFila += "<td>" + registro.productCode + "</td>";
                    nuevaFila += "<td>" + registro.make + "</td>";
                    nuevaFila += "<td>" + registro.category + "</td>";
                    nuevaFila += "<td>" + registro.unity + "</td>";
                    nuevaFila += "<td><input class='costo_class' type='hidden' value='" + costo + "'>Q." + costo + "</td>";
                    nuevaFila += "<td><input class='cantidad_class' type='hidden' value='" + cantidad + "'>" + cantidad + "</td>";
                    nuevaFila += "<td>Q." + subtotal + "</td>";
                    nuevaFila += "<td><a id='quitar' onclick='eliminar("+registro.idProduct+");' data-id-detalle='" + registro.idProduct + "' class='btn bg-maroon btn-flat margin quitar_product'><i class='fa fa-remove'></i></a></td>";
                    console.log(total);
                    $("#totalPurchase").text('Q. '+total);
                    $("#total").val(total);
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

    $('#form-purchase').on('submit', function (e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function (data) {
                console.log(data);
                var resultado = JSON.parse(data);
                if (resultado.respuesta == 'exito') {

                    saveDetail(resultado.idCompra);
                    /*if (resultado.proceso == 'nuevo') {
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }*/

                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Debe llenar todos los campos',
                    })
                } else if (resultado.respuesta == 'error') {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar en la base de datos',
                    })
                }
            }                
        })
    });
});


function ImgError(source) {
    source.src = "img/products/notfound.jpg";
    source.onerror = "";
    return true;
}

function eliminar(idp) {

    $('#registros_length select').val('-1').trigger("change");
    jQuery('[data-id="' + idp + '"]').attr('hidden', false);
    $('#registros_length select').val('10').trigger("change");

    jQuery('[data-id-detalle="' + idp + '"]').parents('#detalle').remove();
}

function saveDetail(idEnc) {

    var id_product = document.getElementsByClassName("idproducto_class");
    var costo_detalle = document.getElementsByClassName("costo_class");
    var cantidad_detalle = document.getElementsByClassName("cantidad_class");

    var i;
    for (i = 0; i < id_product.length; i++) {

        idproduct = id_product[i].value;
        costodet = costo_detalle[i].value;
        cantdet = cantidad_detalle[i].value;

        $.ajax({
            type: 'POST',
            data: {
                'id_purchase': idEnc,
                'id_producto': idproduct,
                'costo_detalle': costodet,
                'cantidad_detalle': cantdet
            },
            url: 'BLL/detailP.php',
            datatype: 'json',
            success: function (data) {
                console.log(data);
                resultado = JSON.parse(data);
                if (resultado.respuesta == 'exito') {
                    saveStock(resultado.idProducto, resultado.cantidad);
                }
            }                
        })
    }    
}

function saveStock(id_product, cantidad_detalle) {

    $.ajax({
        type: 'POST',
        data: {
            'cantidad': cantidad_detalle,
            'id_product': id_product
        },
        url: 'BLL/storage.php',
        datatype: 'json',
        success: function (data) {
            console.log(data);
            resultado = JSON.parse(data);
            if (resultado.respuesta == 'exito') {
                swal(
                    'Exito!',
                    '¡' + resultado.mensaje,
                    'success'
                )
            }
        }                
    })
}
