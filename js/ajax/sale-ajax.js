$(document).ready(function () {

    $('.agregar_productoS').on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var cantidad = $('#new_' + id + '_cantidadS').val();
        var max_stock = $('.max_' + id + '_stock').val();
        var descuento = $('#new_' + id + '_descuentoS').val();
        var prec = $('#SelectPrice' + id).val();

        console.log(max_stock);
        if (isNaN(cantidad) || cantidad < 1 || cantidad > max_stock || isNaN(descuento) || descuento < 0) {
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
                                var subtotal = (registro.public - descuento) * cantidad;
                                var precio = registro.public;
                            } else if (prec == 'plus-square') {
                                var subtotal = (registro.pharma - descuento) * cantidad;
                                var precio = registro.pharma;
                            } else if (prec == 'briefcase') {
                                var subtotal = (registro.business - descuento) * cantidad;
                                var precio = registro.business;
                            }
                        } else {
                            var subtotal = (registro.bonus - descuento) * cantidad;
                            var precio = registro.bonus;
                        }
                        nuevaFila += "<td><img src='img/products/" + registro.picture + "'width='80' onerror='ImgError(this);'></td>";
                        nuevaFila += "<td><input class='idproducto_class' type='hidden' value='" + registro.idProduct + "'>" + registro.productName + "</td>";
                        nuevaFila += "<td>" + registro.productCode + "</td>";
                        nuevaFila += "<td>" + registro.make + "</td>";
                        nuevaFila += "<td>" + registro.category + "</td>";
                        nuevaFila += "<td>" + registro.unity + "</td>";
                        nuevaFila += "<td><input type='hidden' value='" + registro.cost + "'>Q." + registro.cost + "</td>";
                        nuevaFila += "<td><input class='precio_class' type='hidden' value='" + precio + "'>Q." + precio + "</td>";
                        nuevaFila += "<td><input class='cantidad_class' type='hidden' value='" + cantidad + "'>" + cantidad + "</td>";
                        nuevaFila += "<td><input class='descuento_class' type='hidden' value='" + descuento + "'>Q." + parseFloat(Math.round(descuento * 100) / 100).toFixed(2) + "</td>";
                        nuevaFila += "<td>Q." + subtotal.toFixed(2) + "</td>";
                        nuevaFila += "<td><a id='quitar' onclick='eliminarS(" + registro.idProduct + ");' data-id-detalle='" + registro.idProduct + "' class='btn bg-maroon btn-flat margin quitar_product'><i class='fa fa-remove'></i></a></td>";
                        precio = parseFloat(precio) - parseFloat(descuento);
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

        swal({
            title: 'Generando la venta...'
        });
        swal.showLoading();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function (data) {
                console.log(data);
                var resultado = JSON.parse(data);
                if (resultado.respuesta == 'exito') {
                    saveBalanceS(resultado.idVenta, resultado.adelanto, resultado.total, resultado.fecha, resultado.factura, resultado.serie, resultado.nofactura);
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

    $('#form-envio').on('submit', function (e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        swal({
            title: 'Generando el envío...'
        });
        swal.showLoading();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function (data) {
                console.log(data);
                var resultado = JSON.parse(data);
                if (resultado.respuesta == 'exito') {
                    changeReportE('guia.php?idSale='+resultado.idSale);
                    swal.close();
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: '¡' + resultado.mensaje,
                        showConfirmButton: false,
                        timer: 1000
                    })
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
                        title: '¡' + resultado.mensaje,
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

    $('#form-correlative-guia').on('submit', function (e) {
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
                        title: '¡' + resultado.mensaje,
                        showConfirmButton: false,
                        timer: 1000
                    })

                    $("#correlativeCloseGuia").click();
                    $("#noRemi").val(resultado.noBill);
                    $("#noRemi1").val(resultado.noBill);
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

function updateCorrelativo(correlative, serie, last) {

    $.ajax({
        type: 'POST',
        data: {
            'correlative': correlative,
            'serieC': serie,
            'last': last
        },
        url: 'BLL/correlative.php',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var resultado = data;
            if (resultado.respuesta == 'exito') {
              
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
}

function saveBalanceS(idEnc, adelanto, total, fecha, factura, serie, nofactura) {
    var monto = parseFloat(total) - parseFloat(adelanto);

    $.ajax({
        type: 'POST',
        data: {
            'tipo': 'saldo',
            'id_sale': idEnc,
            'monto': monto,
            'fecha': fecha
        },
        url: 'BLL/balance.php',
        datatype: 'json',
        success: function (data) {
            console.log(data);
            resultado = JSON.parse(data);
            if (resultado.respuesta == 'exito') {
                saveDetailS(resultado.idVenta, factura, serie, nofactura);
            }
        }
    })
}

function saveDetailS(idEnc, factura, serie, nofactura) {

    var id_product = document.getElementsByClassName("idproducto_class");
    var precio_detalle = document.getElementsByClassName("precio_class");
    var cantidad_detalle = document.getElementsByClassName("cantidad_class");
    var descuento_detalle = document.getElementsByClassName("descuento_class");

    var i;
    for (i = 0; i < id_product.length; i++) {

        idproduct = id_product[i].value;
        preciodet = precio_detalle[i].value;
        cantdet = cantidad_detalle[i].value;
        descudet = descuento_detalle[i].value;

        $.ajax({
            type: 'POST',
            data: {
                'id_sale': idEnc,
                'id_producto': idproduct,
                'precio_detalle': preciodet,
                'cantidad_detalle': cantdet,
                'descuento_detalle': descudet
            },
            url: 'BLL/detailS.php',
            datatype: 'json',
            success: function (data) {
                console.log(data);
                resultado = JSON.parse(data);
                if (resultado.respuesta == 'exito') {
                    saveStockS(resultado.idProducto, resultado.cantidad);
                }
            }
        })
    }
    if (factura == 'si') {
        changeReport('factura.php?idSale='+idEnc);
        updateCorrelativo('factura', serie, nofactura);
    }else if (factura == 'no') {
        changeReport('remision.php?idSale='+idEnc);
        updateCorrelativo('guia', 'A', nofactura);
    }
    $("#idSale").val(idEnc);
    swal.close();
    swal({
        title: 'Exito!',
        text: '¡Venta creada exitosamente!',
        timer: 2000,
        type: 'success'
    })
    tab3();
}

function saveStockS(id_product, cantidad_detalle) {

    $.ajax({
        type: 'POST',
        data: {
            'tipo': 'venta',
            'cantidad': cantidad_detalle,
            'id_product': id_product
        },
        url: 'BLL/storage.php',
        datatype: 'json',
        success: function (data) {
            console.log(data);
            resultado = JSON.parse(data);
            if (resultado.respuesta == 'exito') {
            }
        }
    })
}

function changeReport(report) {
    $('#divreporte').html('<iframe src="reportsFPDF/' + report + '" style="width: 100%; min-width: 300px; height: 700px"></iframe>');
}

function changeReportE(report) {
    $('#divreporteE').html('<iframe src="reportsFPDF/' + report + '" style="width: 100%; min-width: 300px; height: 380px"></iframe>');
}

function eliminarS(idp) {

    $('#registros_length select').val('-1').trigger("change");
    jQuery('[data-id="' + idp + '"]').attr('hidden', false);
    $('#registros_length select').val('10').trigger("change");

    var idproduct = document.getElementsByClassName("idproducto_class");
    var nprecio = document.getElementsByClassName("precio_class");
    var ncantidad = document.getElementsByClassName("cantidad_class");
    var descuento_detalle = document.getElementsByClassName("descuento_class");

    var x;

    for (x = 0; x < idproduct.length; x++) {

        idprod = idproduct[x].value;
        precion = nprecio[x].value;
        cantn = ncantidad[x].value;
        descuento = descuento_detalle[x].value;

        if (idprod == idp) {
            precion = parseFloat(precion) - parseFloat(descuento);
            updateTotalS(cantn, precion, 1);
        }
    }

    jQuery('[data-id-detalle="' + idp + '"]').parents('#detalleS').remove();

}

function tab2() {
    $('#a').click();
    $('#serieS').attr('disabled', false);
}

function tab3() {
    $('#b').click();
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