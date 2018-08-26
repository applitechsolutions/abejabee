$(document).ready(function () {

    $('.agregar_productoS').on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var cantidad = $('#new_' + id + '_cantidadS').val();
        
        var prec = $('#SelectPrice'+id).val();
        console.log(prec);
        if (isNaN(cantidad) || cantidad < 1) {
            swal({
                type: 'error',
                title: 'Error',
                text: 'No se puede agregar al carrito',
            })
        } else {        
        var tipo = $(this).attr('data-tipo');
        $(this).attr('hidden', true);   

        $.ajax({
            type: 'POST',
            data: {
                'id': id,
                'producto': 'agregarS'
            },
            url: 'BLL/' + tipo + '.php',
            success(data) {
                console.log(data);

                var nuevaFila = "<tr id='detalleS'>";
                $.each(data, function (key, registro) {
                    if (cantidad >= 20) {
                        if (prec == 'users') {
                            var subtotal = registro.public * cantidad;
                            var precio = registro.public;
                        } else if (prec == 'plus-square') {
                            var subtotal = registro.pharma * cantidad;
                            var precio = registro.pharma;
                        } else if (prec == 'briefcase') {
                            var subtotal = registro.business * cantidad;
                            var precio = registro.business;
                        } 
                    } else {
                        var subtotal = registro.bonus * cantidad;
                        var precio = registro.bonus;
                    }

                    console.log(precio);
                   
                    nuevaFila += "<td><img src='img/products/" + registro.picture + "'width='80' onerror='ImgError(this);'></td>";
                    nuevaFila += "<td><input class='idproducto_class' type='hidden' value='" + registro.idProduct + "'>" + registro.productName + "</td>";
                    nuevaFila += "<td>" + registro.productCode + "</td>";
                    nuevaFila += "<td>" + registro.make + "</td>";
                    nuevaFila += "<td>" + registro.category + "</td>";
                    nuevaFila += "<td>" + registro.unity + "</td>";
                    nuevaFila += "<td><input class='costo_class' type='hidden' value='" + registro.cost + "'>Q." + registro.cost + "</td>";
                    nuevaFila += "<td><input class='precio_class' type='hidden' value='" + precio + "'>Q." + precio + "</td>";
                    nuevaFila += "<td><input class='cantidad_class' type='hidden' value='" + cantidad + "'>" + cantidad + "</td>";
                    nuevaFila += "<td>Q." + subtotal.toFixed(2) + "</td>";
                    nuevaFila += "<td><a id='quitar' onclick='eliminarS(" + registro.idProduct + ");' data-id-detalle='" + registro.idProduct + "' class='btn bg-maroon btn-flat margin quitar_product'><i class='fa fa-remove'></i></a></td>";
                    updateTotalS(cantidad, precio, 0);
                });
                nuevaFila += "</tr>";
                $("#agregadosS").append(nuevaFila);
            },
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'No se puede agregar al carrito',
                })
            }
        });
        } 
    });

    $('#form-sale').on('submit', function (e) {
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


    $('#form-correlative').on('submit', function (e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: '¡'+ resultado.mensaje,
                        showConfirmButton: false,
                        timer: 1000
                      })
                    
                    $("#correlativeClose").click();
                    $("#serieS").val(resultado.serie);
                    $("#noBillS").val(resultado.noBill);
                    $("#serieS1").val(resultado.serie);
                    $("#noBillS1").val(resultado.noBill);
                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        position: 'top-end',
                        type: 'warning',
                        title: 'Debes llenar los campos obligatorios :/',
                        showConfirmButton: false,
                        timer: 1500
                      })
                } else if (resultado.respuesta == 'error') {
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Algo salió mal, intenta de nuevo',
                        showConfirmButton: false,
                        timer: 1500
                      })
                }
            },
            error: function (data) {
                swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Algo salió mal, intenta de nuevo',
                    showConfirmButton: false,
                    timer: 1500
                  })
            }
        })

    });
});

function eliminarS(idp) {

    $('#registros_length select').val('-1').trigger("change");
    jQuery('[data-id="' + idp + '"]').attr('hidden', false);
    $('#registros_length select').val('10').trigger("change");

    var idproduct = document.getElementsByClassName("idproducto_class");
    var nprecio = document.getElementsByClassName("precio_class");
    var ncantidad = document.getElementsByClassName("cantidad_class");

    var x;

    for (x = 0; x < idproduct.length; x++) {

        idprod = idproduct[x].value;
        precion = nprecio[x].value;
        cantn = ncantidad[x].value;

        if (idprod == idp) {
            updateTotalS(cantn, precion, 1);
        }
    }

    jQuery('[data-id-detalle="' + idp + '"]').parents('#detalleS').remove();

}



function tab2() {
    $('#a').click();
    $('#serieS').attr('disabled', false);
}
function updateTotalS(cant, cost, proc) {

    var Total = $("#totalS").val();

    var subTotal = 0;


    subTotal = cant * cost;

    if (proc == 0) {
        Total = parseFloat(Total) + parseFloat(subTotal);
    } else if (proc == 1) {
        Total = parseFloat(Total) - parseFloat(subTotal);
    }

    $("#totalSale").text('Q. ' + Total.toFixed(2));
    $("#totalS").val(parseFloat(Total));
}
