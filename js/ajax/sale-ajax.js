$(document).ready(function () {

    $('.agregar_productoS').on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var cantidad = parseInt($('#new_' + id + '_cantidadS').val());
        var max_stock = parseInt($('.max_' + id + '_stock').val());
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
            // $(this).attr('hidden', true);

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
                        if (prec == 'users') {
                            var subtotal = (registro.public - descuento) * cantidad;
                            var precio = registro.public;
                        } else if (prec == 'plus-square') {
                            var subtotal = (registro.pharma - descuento) * cantidad;
                            var precio = registro.pharma;
                        } else if (prec == 'briefcase') {
                            var subtotal = (registro.business - descuento) * cantidad;
                            var precio = registro.business;
                        } else if (prec == 'money') {
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
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: '¡Agregado al detalle!',
                        showConfirmButton: false,
                        timer: 1000
                    })
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
                    saveBalanceS(resultado.idVenta, resultado.adelanto, resultado.total, resultado.fecha, resultado.remision);
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
                    changeReportE('guia.php?idSale=' + resultado.idSale);
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
                        text: 'No se ha generado ninguna venta',
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

    $('#form-pay').on('submit', function (e) {
        e.preventDefault();

        var datos = $(this).serializeArray();
        console.log(datos);

        swal({
            title: 'Ingresando pago...'
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
                    if (resultado.new_totalB == '0') {
                        cancelSale(resultado.idSale);
                    }
                    document.getElementById("form-pay").reset();
                    $("#correlativeCloseB").click();
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
                        text: 'No se han podido procesar los datos',
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

    $('#form-correlative-envio').on('submit', function (e) {
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

                    $("#correlativeCloseEnvio").click();
                    $("#noShipment").val(resultado.noBill);
                    $("#noShipment1").val(resultado.noBill);
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

    $('.detalle_sale').on('click', function (e) {
        e.preventDefault();
        $("#detalles").find('tbody').html("");
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Cargando detalle de Venta...'
        });
        swal.showLoading();
        $.ajax({
            type: 'POST',
            data: {
                'id': id
            },
            url: 'BLL/' + tipo + '.php',
            success(data) {
                console.log(data);
                $.each(data, function (key, registro) {
                    var nuevaFila = "<tr>";
                    var sub = registro.quantity * (parseFloat(Math.round(registro.priceS * 100) / 100).toFixed(2) - parseFloat(Math.round(registro.discount * 100) / 100).toFixed(2));
                    nuevaFila += "<td><img src='img/products/" + registro.imagen + "'width='80' onerror='ImgError(this);'></td>";
                    nuevaFila += "<td>" + registro.nombre + "</td>";
                    nuevaFila += "<td>" + registro.codigo + "</td>";
                    nuevaFila += "<td>" + registro.quantity + "</td>";
                    nuevaFila += "<td>Q." + registro.priceS + "</td>";
                    nuevaFila += "<td>Q." + registro.discount + "</td>";
                    nuevaFila += "<td>Q." + sub.toFixed(2) + "</td>";
                    nuevaFila += "</tr>";
                    $("#detalles").append(nuevaFila);
                });
                swal.close();
                $('#modal-detailS').modal('show');
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

    $('.detalle_balance').on('click', function (e) {
        e.preventDefault();
        $("#detallesB").find('tbody').html("");
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Cargando balance de saldos...'
        });
        swal.showLoading();
        $.ajax({
            type: 'POST',
            data: {
                'id': id
            },
            url: 'BLL/' + tipo + '.php',
            success(data) {
                console.log(data);
                $.each(data, function (key, registro) {
                    var nuevaFila = "<tr>";
                    var tipo = registro.balpay;
                    if (tipo == 0) {
                        nuevaFila += "<td><small>-</small></td>";
                    } else if (tipo == 1) {
                        nuevaFila += "<td>" + registro.noDocument + "</td>";
                    }
                    nuevaFila += "<td>" + convertDate(registro.date); + "</td>";
                    if (tipo == 0) {
                        nuevaFila += "<td><small class='label label-danger'><i class='fa fa-database'></i> Saldo</small></td>";
                    } else if (tipo == 1) {
                        nuevaFila += "<td><small class='label label-primary'><i class='fa fa-credit-card'></i> Pago</small></td>";
                    }
                    nuevaFila += "<td>Q." + registro.amount + "</td>";
                    if (tipo == 0) {
                        nuevaFila += "<td><small>-</small></td>";
                    } else if (tipo == 1) {
                        nuevaFila += "<td>" + registro.noReceipt + "</td>";
                    }
                    nuevaFila += "<td>Q." + registro.balance + "</td>";
                    nuevaFila += "</tr>";
                    $("#detallesB").append(nuevaFila);
                });
                balance(id);
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

function recargarPagina() {
    location.reload();
}

function generarFactura() {
    var serie = $("#serieS").val();
    var last = parseInt($("#noBillS").val());
    var idSale = $("#idSale").val();

    updateCorrelativo('factura', serie, last);
    $.ajax({
        type: "POST",
        data: {
            'venta': 'editarCorrelativo',
            'idSale': idSale,
            'serie': serie,
            'last': last
        },
        url: 'BLL/sale.php',
        datatype: 'json',
        success: function (data) {
            console.log(data);
            var resultado = JSON.parse(data);
            if (resultado.respuesta == 'exito') {
                changeReportF('factura.php?idSale=' + idSale);
            } else if (resultado.respuesta == 'vacio') {} else if (resultado.respuesta == 'error') {}
        }
    })
}

function imprimir(tipo, idSale) {
        if (tipo == 'factura') {
            swal({
                title: '¿Estás Seguro?',
                text: "Generar una impresión altera al correlativo actual",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Generar!',
                cancelButtonText: 'Cancelar'
            }).then(() => {
            $.ajax({
                type: "GET",
                url: 'BLL/correlativeFactura.php',
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    $.each(data, function (key, registro) {
                        var serie = registro.serie;
                        var last = parseInt(registro.last) + parseInt(1);

                        updateCorrelativo('factura', serie, last);
                        $.ajax({
                            type: "POST",
                            data: {
                                'venta': 'editarCorrelativo',
                                'idSale': idSale,
                                'serie': serie,
                                'last': last
                            },
                            url: 'BLL/sale.php',
                            datatype: 'json',
                            success: function (data) {
                                console.log(data);
                                var resultado = JSON.parse(data);
                                if (resultado.respuesta == 'exito') {} else if (resultado.respuesta == 'vacio') {} else if (resultado.respuesta == 'error') {}
                            }
                        })
                    });
                },
                error: function (data) {
                    alert('error');
                }
            });
            changeReportL(tipo + '.php?idSale=' + idSale);
            $('#modal-printS').modal('show');
        });
        } else if (tipo == 'guia') {
            swal({
                title: '¿Estás Seguro?',
                text: "Generar una impresión altera al correlativo actual",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Generar!',
                cancelButtonText: 'Cancelar'
            }).then(() => {
            $.ajax({
                type: "GET",
                url: 'BLL/correlativeGuia.php',
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    $.each(data, function (key, registro) {
                        var last = parseInt(registro.last) + parseInt(1);
                        updateCorrelativo('envio', 'A', last);
                        $.ajax({
                            type: "POST",
                            data: {
                                'venta': 'editarShipment',
                                'idSale': idSale,
                                'last': last
                            },
                            url: 'BLL/sale.php',
                            datatype: 'json',
                            success: function (data) {
                                console.log(data);
                                var resultado = JSON.parse(data);
                                if (resultado.respuesta == 'exito') {} else if (resultado.respuesta == 'vacio') {} else if (resultado.respuesta == 'error') {}
                            }
                        })
                    });
                },
                error: function (data) {
                    alert('error');
                }
            });
            changeReportL(tipo + '.php?idSale=' + idSale);
            $('#modal-printS').modal('show');
        });
        }else{
            changeReportL(tipo + '.php?idSale=' + idSale);
            $('#modal-printS').modal('show');
        }        
}

function convertDate(dateString) {
    var p = dateString.split(/\D/g)
    return [p[2], p[1], p[0]].join("/")
}

function cancelSale(idSale) {
    $.ajax({
        type: 'POST',
        data: {
            'venta': 'cancel',
            'idSale': idSale
        },
        url: 'BLL/sale.php',
        success(data) {
            console.log(data);
            var resultado = JSON.parse(data);
            if (resultado.respuesta == 'exito') {
                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
                swal({
                    type: 'error',
                    title: 'Error!',
                    text: 'No se pudo eliminar la ruta.'
                })
            }
        }
    });
}

function balance(idSale) {
    $.ajax({
        type: 'POST',
        data: {
            'id': idSale
        },
        url: 'BLL/listBalanceT.php',
        success(data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#totalBal").text('Q. ' + registro.balance);
                $("#totalB").val(parseFloat(registro.balance));
                $("#idSale").val(idSale);
            });
            swal.close();
            $('#modal-balance').modal('show');
        },
        error: function (data) {
            swal({
                type: 'error',
                title: 'Error',
                text: 'No se puede mostrar balance de saldos',
            })
        }
    });
}

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

function saveBalanceS(idEnc, adelanto, total, fecha, remision) {
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
                saveDetailS(resultado.idVenta, remision);
            }
        }
    })
}

function saveDetailS(idEnc, remision) {

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
                    //saveStockS(resultado.idProducto, resultado.cantidad);
                }
            }
        })
    }
    changeReportF('remision.php?idSale=' + idEnc);
    updateCorrelativo('guia', 'A', remision);
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
            if (resultado.respuesta == 'exito') {}
        }
    })
}

function changeReportF(report) {
    $('#divreporteF').html('<iframe src="reportsFPDF/' + report + '" style="width: 100%; min-width: 300px; height: 640px"></iframe>');
}

function changeReportE(report) {
    $('#divreporteE').html('<iframe src="reportsFPDF/' + report + '" style="width: 100%; min-width: 300px; height: 390px"></iframe>');
}

function changeReportL(report) {
    $('#divreporteL').html('<iframe src="reportsFPDF/' + report + '" style="width: 100%; min-width: 300px; height: 500px"></iframe>');
}

function eliminarS(idp) {

    $('#registros_length select').val('-1').trigger("change");
    //jQuery('[data-id="' + idp + '"]').attr('hidden', false);
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