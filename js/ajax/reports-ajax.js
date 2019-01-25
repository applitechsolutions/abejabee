$(document).ready(function () {

    $('#form-SalesBySeller').on('submit', function (e) {
        e.preventDefault();
        $("#listadoReporte1").html("");
        $("#listadoReporte2").html("");
        $("#listadoReporte3").html("");
        
        var tabla = '<div class="box-body table-responsive no-padding">'+
            '<table id="registros" class="table table-bordered table-striped">'+
                '<thead>'+
                    '<tr>'+
                        '<th>Fecha</th>'+
                        '<th>Factura No°</th>'+
                        '<th>Fecha de pago</th>'+
                        '<th>Método de pago</th>'+
                        '<th>Producto</th>'+
                        '<th>Cantidad</th>'+
                        '<th>Precio</th>'+
                        '<th>Descuento</th>'+
                        '<th>Subtotal</th>'+
                        '<th>Comisión</th>'+
                    '</tr>'+
                '</thead>'+
                '<tbody class="contenidoRPT"></tbody>'+
                '<tfoot>'+
                    '<tr>'+
                        '<th>Fecha</th>'+
                        '<th>Factura No°</th>'+
                        '<th>Fecha de pago</th>'+
                        '<th>Método de pago</th>'+
                        '<th>Producto</th>'+
                        '<th>Cantidad</th>'+
                        '<th>Precio</th>'+
                        '<th>Descuento</th>'+
                        '<th>Subtotal</th>'+
                        '<th>Comisión</th>'+
                    '</tr>'+
                '</tfoot>'+
            '</table>'+
        '</div><div class="row"><button type="button" onclick="printReport2()" class="btn bg-teal-active btn-md"><i class="fa fa-print"></i>'+
            ' Imprimir</button>'+
            '</div><div class="row"><div class="form-group col-lg-6 pull-right"><div class="input-group"><span class="input-group-addon"><span class="text-danger text-uppercase">*</span><label for="totalComision" class="control-label">Total:</label><span><h5 id="totalComision" class="text-bold">Q.0.00</h5></span></span></div></div></div>';

        $("#listadoReporte2").append(tabla);
        
        var datos = $(this).serializeArray();

        swal({
            title: 'Generando el reporte...'
        });

        swal.showLoading();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function (data) {
                console.log(data);
                var totalCom = 0;
                $.each(data, function (key, registro) {
                    var fecha1 = registro.fechapago;
                    var fecha2 = registro.dateEnd;
                    var date1 = new Date(fecha1);
                    var date2 = new Date(fecha2);          
                    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    var sub = registro.quantity * (parseFloat(Math.round(registro.priceS * 100) / 100).toFixed(2) - parseFloat(Math.round(registro.discount * 100) / 100).toFixed(2));
                    console.log((registro.s60/100));
                    var comi = comision(diffDays, registro.marca, sub.toFixed(2), registro.s30, registro.s60, registro.s90, registro.o30, registro.o60, registro.sd30, registro.sd60, registro.sd90, registro.od30, registro.od60);
                    totalCom = parseFloat(totalCom) + parseFloat(comi);
                    var contenido = "<tr>";
                    contenido += "<td><input class='idVen' type='hidden' value='" + registro._idSeller + "'>" + convertDate(registro.dateStart); + "</td>";
                    contenido += '<td><small class="text-orange text-muted">Factura No°</small><br><small>'+ registro.serie +' '+ registro.noBill +'</small><br><small class="text-olive text-muted">Remision No°</small><br><small>'+ registro.noDeliver +'</small></td>';
                    contenido += "<td>" + convertDate(registro.fechapago) + "</td>";
                    contenido += "<td>" + registro.paymentMethod + "</td>";
                    contenido += "<td>" + registro.codigo +" " + registro.nombre + "</td>";
                    contenido += "<td>" + registro.quantity + "</td>";
                    contenido += "<td>Q." + registro.priceS + "</td>";
                    contenido += "<td>Q." + registro.discount + "</td>";
                    contenido += "<td>Q." + sub.toFixed(2) + "</td>";
                    contenido += "<td>Q." + comision(diffDays, registro.marca, sub.toFixed(2), registro.s30, registro.s60, registro.s90, registro.o30, registro.o60, registro.sd30, registro.sd60, registro.sd90, registro.od30, registro.od60) + "</td>";
                    contenido += '</tr>';
                    $(".contenidoRPT").append(contenido);
                });
                $('#totalComision').html('Q.'+ totalCom.toFixed(2));
                swal.close();
                funciones();                
            },
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Algo ha salido mal, intentalo más tarde',
                })
            }

        });
    });

    $('#form-rpt1').on('submit', function (e) {
        e.preventDefault();

        $("#listadoReporte1").html("");
        $("#listadoReporte2").html("");
        $("#listadoReporte3").html("");

        var datos = $(this).serializeArray();

        swal({
            title: 'Generando el reporte...'
        });

        swal.showLoading();

        var tabla = '<div class="box-body table-responsive no-padding"><table id="registros" class="table table-bordered table-striped"><thead><tr><th>Ruta</th><th>Vendedor</th><th>Cliente</th><th>Factura No°</th><th>Adelanto</th><th>Total</th><th>Fecha de Venta</th><th>Fecha de Vencimiento</th><th>Envío No°</th><th>Días</th><th>30 días</th><th>60 días</th><th>90 días</th></tr></thead><tbody class="contenidoRPT1"></tbody><tfoot><tr><th>Ruta</th><th>Vendedor</th><th>Cliente</th><th>Factura No°</th><th>Adelanto</th><th>Total</th><th>Fecha de Venta</th><th>Fecha de Vencimiento</th><th>Envío No°</th><th>Días</th><th>30 días</th><th>60 días</th><th>90 días</th></tr></tfoot></table></div><button type="button" onclick="printReport1()" class="btn bg-teal-active btn-sm"><i class="fa fa-print"></i> Imprimir</button>';

        $("#listadoReporte1").append(tabla);

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function (data) {
                console.log(data);
                $.each(data, function (key, registro) {
                    var contenido = "<tr>";
                    contenido += "<td>" + registro.route + "</td>";
                    contenido += "<td>" + registro.seller + "</td>";
                    contenido += "<td>" + registro.customer + "</td>";
                    contenido += '<td><small class="text-orange text-muted">Factura No°</small><br><small>'+ registro.serie +' '+ registro.noBill +'</small><br><small class="text-olive text-muted">Remision No°</small><br><small>'+ registro.noDeliver +'</small></td>';
                    contenido += "<td>Q." + registro.advance + "</td>";
                    contenido += "<td>Q." + registro.totalSale + "</td>";
                    contenido += "<td>" + convertDate(registro.dateStart); + "</td>";
                    contenido += "<td>" + convertDate(registro.dateEnd) + "</td>";
                    contenido += "<td>" + registro.noShipment + "</td>";
                    contenido += "<td>" + registro.days + "</td>";
                    contenido += "<td>Q." + registro.mora30 + "</td>";
                    contenido += "<td>Q." + registro.mora60 + "</td>";
                    contenido += "<td>Q." + registro.mora90 + "</td>";
                    contenido += '</tr>';
                    $(".contenidoRPT1").append(contenido);
                });
                
                swal.close();
                funciones();
            },
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Algo ha salido mal, intentalo más tarde',
                })
            }
        });
    });

    $('#form-rptCustomByDep').on('submit', function (e) {
        e.preventDefault();

        $("#listadoReporte1").html("");
        $("#listadoReporte2").html("");
        $("#listadoReporte3").html("");

        var tabla = '<div class="box-body table-responsive no-padding"><table id="registros" class="table table-bordered table-striped"><thead><tr><th>Código</th><th>Cliente</th><th>Teléfono</th><th>Total</th><th><i class="fa fa-cogs"></i> Detalle</th></tr></thead><tbody class="contenidoRPT3"></tbody><tfoot><tr><th>Código</th><th>Cliente</th><th>Teléfono</th><th>Total</th><th><span class="fa fa-cogs"></span></th></tr></tfoot></table></div><button type="button" onclick="printReport3()" class="btn bg-teal-active btn-sm"><i class="fa fa-print"></i> Imprimir</button><a id="btn_avanzar" href="#tab_5" data-toggle="tab" class="btn btn-flat pull-right text-bold btn_avanzar3" hidden><i class="glyphicon glyphicon-forward"></i> Avanzar al detalle seleccionado...</a>';

        $("#listadoReporte3").append(tabla);
        
        var datos = $(this).serializeArray();

        swal({
            title: 'Generando el reporte...'
        });

        swal.showLoading();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function (data) {
                console.log(data);
                $.each(data, function (key, registro) {
                    var contenido = "<tr>";
                    contenido += "<td>" + registro.customerCode + "</td>";
                    contenido += "<td>" + registro.customerName + "</td>";
                    contenido += "<td>" + registro.customerTel + "</td>";
                    contenido += "<td>Q " + registro.total + "</td>";
                    contenido += '<td><div class="btn-group-vertical"><a href="#tab_5" onclick="listarDetallerpt3('+ registro.idCustomer +')" data-toggle="tab" class="btn bg-teal btn-flat margin detalle_rpt3"><i class="fa fa-info"></i></a></div></td>';
                    contenido += '</tr>';
                    $(".contenidoRPT3").append(contenido);
                });
                swal.close();
                funciones();
            },
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Algo ha salido mal, intentalo más tarde',
                })
            }

        });

    });

    $('#form-ComBySeller').on('submit', function (e) {
        e.preventDefault();
        $("#listadoReporte1").html("");
        $("#listadoReporte2").html("");
        $("#listadoReporte3").html("");
        $("#listadoReporte4").html("");
        
        var tabla = '<div class="box-body table-responsive no-padding">'+
            '<table id="registros" class="table table-bordered table-striped">'+
                '<thead>'+
                    '<tr>'+
                        '<th>Fecha Inicio</th>'+
                        '<th>Método de pago</th>'+
                        '<th>Producto</th>'+
                        '<th>Marca</th>'+
                        '<th>Cantidad</th>'+
                        '<th>Subtotal</th>'+
                    '</tr>'+
                '</thead>'+
                '<tbody class="contenidoRPT4"></tbody>'+
                '<tfoot>'+
                    '<tr>'+
                        '<th>Fecha Inicio</th>'+
                        '<th>Método de pago</th>'+
                        '<th>Producto</th>'+
                        '<th>Marca</th>'+
                        '<th>Cantidad</th>'+
                        '<th>Subtotal</th>'+
                    '</tr>'+
                '</tfoot>'+
            '</table>'+
        '</div><div class="row"><button type="button" onclick="printReport4()" class="btn bg-teal-active btn-md"><i class="fa fa-print"></i>'+
            ' Imprimir</button>'+
            '</div><div class="row"><div class="form-group col-lg-6 pull-right"><div class="input-group"><span class="input-group-addon"><span class="text-danger text-uppercase">*</span><label for="totalVentas" class="control-label">Total:</label><span><h5 id="totalVentas" class="text-bold">Q.0.00</h5></span></span></div></div></div>';

        $("#listadoReporte4").append(tabla);
        
        var datos = $(this).serializeArray();

        swal({
            title: 'Generando el reporte...'
        });

        swal.showLoading();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function (data) {
                console.log(data);
                var totalCom = 0;
                $.each(data, function (key, registro) {
                    totalCom = parseFloat(totalCom) + parseFloat(registro.subtotal);
                    var contenido = "<tr>";
                    contenido += "<td>" + convertDate(registro.dateStart); + "</td>";
                    contenido += "<td>" + registro.paymentMethod + "</td>";
                    contenido += "<td>" + registro.codigo +" " + registro.nombre + "</td>";
                    contenido += "<td>" + registro.marca + "</td>";
                    contenido += "<td>" + registro.cantidad + "</td>";
                    contenido += "<td>Q." + registro.subtotal + "</td>";
                    contenido += '</tr>';
                    $(".contenidoRPT4").append(contenido);
                });
                $('#totalVentas').html('Q.'+ totalCom.toFixed(2));
                swal.close();
                funciones();                
            },
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Algo ha salido mal, intentalo más tarde',
                })
            }

        });
    });

    $('#form-dailyStock').on('submit', function (e) {
        e.preventDefault();
        $("#listadoReporte1").html("");
        $("#listadoReporte2").html("");
        $("#listadoReporte3").html("");
        $("#listadoReporte4").html("");
        $("#listadoReporte5").html("");
        
        var tabla = '<div class="box-body table-responsive no-padding">'+
            '<table id="registros" class="table table-bordered table-striped">'+
                '<thead>'+
                    '<tr>'+
                        '<th>Código</th>'+
                        '<th>Nombre</th>'+
                        '<th>Marca</th>'+
                        '<th>Categoría</th>'+
                        '<th>Unidad</th>'+
                        '<th>Costo</th>'+
                        '<th>Existencia</th>'+
                    '</tr>'+
                '</thead>'+
                '<tbody class="contenidoRPT5"></tbody>'+
                '<tfoot>'+
                    '<tr>'+
                        '<th>Código</th>'+
                        '<th>Nombre</th>'+
                        '<th>Marca</th>'+
                        '<th>Categoría</th>'+
                        '<th>Unidad</th>'+
                        '<th>Costo</th>'+
                        '<th>Existencia</th>'+
                    '</tr>'+
                '</tfoot>'+
            '</table>'+
        '</div><div class="row"><button type="button" onclick="printReport5()" class="btn bg-teal-active btn-md"><i class="fa fa-print"></i>'+
            ' Imprimir</button>'+
            '</div>';

        $("#listadoReporte5").append(tabla);
        
        var datos = $(this).serializeArray();

        swal({
            title: 'Generando el reporte...'
        });

        swal.showLoading();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function (data) {
                console.log(data);
                
                $.each(data, function (key, registro) {
                    if (registro.ventas != null && registro.compras != null) {
                        if (parseInt(registro.ventas) < parseInt(registro.compras)) {
                            var difS = parseInt(registro.compras) - parseInt(registro.ventas);
                        }else {
                            var difS = parseInt(registro.ventas) - parseInt(registro.compras);
                        }
                        var stock = parseInt(registro.stock) - parseInt(difS);
                    } else if (registro.ventas != null && registro.compras == null) {
                        var stock = parseInt(registro.stock) + parseInt(registro.ventas);
                    } else if (registro.ventas == null && registro.compras != null) {
                        if (parseInt(registro.compras) > parseInt(registro.stock)) {
                            var stock = parseInt(registro.compras) - parseInt(registro.stock);
                        } else {
                            var stock = parseInt(registro.stock) - parseInt(registro.compras);
                        }
                    } else {
                        var stock = registro.stock;;
                    }
                    var contenido = "<tr>";
                    contenido += "<td>" + registro.productCode + "</td>";
                    contenido += "<td>" + registro.productName + "</td>";
                    contenido += "<td>" + registro.make + "</td>";
                    contenido += "<td>" + registro.category + "</td>";
                    contenido += "<td>" + registro.unity + "</td>";
                    contenido += "<td>Q." + registro.cost + "</td>";
                    contenido += "<td>" + stock + "</td>";
                    contenido += '</tr>';
                    $(".contenidoRPT5").append(contenido);
                });
                swal.close();
                funciones();                
            },
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Algo ha salido mal, intentalo más tarde',
                })
            }

        });
    });
});


function listarDetallerpt2(idv) {
    jQuery('.btn_avanzar').attr('hidden', false);
    $("#listadoDetalle2").html("");
    $("#listadoDetalle3").html("");
    
    var tabla = '<div class="box-body table-responsive no-padding"><table id="registros2" class="table table-bordered table-striped"><thead><tr><th>Codigo de Product</th><th>Nombre</th><th>Marca</th><th>Cantidad</th><th>Precio</th><th>Descuento</th><th>SubTotal</th><th>Comisión</th></tr></thead><tbody class="contenidorptDetalle2"></tbody><tfoot><tr><th>Codigo de Product</th><th>Nombre</th><th>Marca</th><th>Cantidad</th><th>Precio</th><th>Descuento</th><th>SubTotal</th><th>Comisión</th></tr></tfoot></table></div><button type="button" onclick="printrptDetail2('+idv+')" class="btn bg-teal-active btn-sm"><i class="fa fa-print"></i> Imprimir</button><div class="row"><div class="form-group col-lg-6 pull-right"><div class="input-group"><span class="input-group-addon"><span class="text-danger text-uppercase">*</span><label for="totalComision" class="control-label">Total:</label><span><h5 id="totalComision" class="text-bold">Q.0.00</h5></span></span></div></div></div>';

    $("#listadoDetalle2").append(tabla);
    
    
    var fecha1 = $('.fp'+idv).val();
    var fecha2 = $('.fv'+idv).val();
    var date1 = new Date(fecha1);
    var date2 = new Date(fecha2);
    console.log(date1);
    console.log(date2);

    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
    console.log(diffDays);

    swal({
        title: 'Generando el reporte...'
    });

    swal.showLoading();

    $.ajax({
        type: 'POST',
        data: {
            'idVenta': idv
        },
        url: 'BLL/rptDetailSalesBySeller.php',
        success(data) {
            console.log(data);
            var totalCom = 0;
            $.each(data, function (key, registro) {
                var sub = registro.quantity * (parseFloat(Math.round(registro.priceS * 100) / 100).toFixed(2) - parseFloat(Math.round(registro.discount * 100) / 100).toFixed(2));
                var comi = comision(diffDays, registro.marca, sub.toFixed(2));
                totalCom = parseFloat(totalCom) + parseFloat(comi);
                var contenido = "<tr>";
                contenido += "<td>" + registro.codigo + "</td>";
                contenido += "<td>" + registro.nombre + "</td>";
                contenido += "<td>" + registro.marca + "</td>";
                contenido += "<td>" + registro.quantity + "</td>";
                contenido += "<td>Q." + registro.priceS + "</td>";
                contenido += "<td>Q." + registro.discount + "</td>";
                contenido += "<td>Q." + sub.toFixed(2) + "</td>";
                contenido += "<td>Q." + comision(diffDays, registro.marca, sub.toFixed(2)) + "</td>";
                contenido += '</tr>';
                $(".contenidorptDetalle2").append(contenido);
            });
            $('#totalComision').html('Q.'+ totalCom.toFixed(2));
            swal.close();
            funciones2();
        },
        error: function (data) {
            swal({
                type: 'error',
                title: 'Error',
                text: 'Algo ha salido mal, intentalo más tarde',
            })
        }
    })
}

function listarDetallerpt3(idc) {
    jQuery('.btn_avanzar3').attr('hidden', false);
    $("#listadoDetalle2").html("");
    $("#listadoDetalle3").html("");


    var tabla = '<div class="box-body table-responsive no-padding"><table id="registros2" class="table table-bordered table-striped"><thead><tr><th>Documento</th><th>Fecha</th><th>Saldo</th></tr></thead><tbody class="contenidorptDetalle3"></tbody><tfoot><tr><th>Documento</th><th>Fecha de Pago</th><th>Saldo</th></tr></tfoot></table></div><button type="button" onclick="printrptDetail3('+idc+')" class="btn bg-teal-active btn-sm"><i class="fa fa-print"></i> Imprimir</button>';

    $("#listadoDetalle3").append(tabla);

    swal({
        title: 'Generando el reporte...'
    });

    swal.showLoading();

    $.ajax({
        type: 'POST',
        data: {
            'idCliente': idc
        },
        url: 'BLL/rptDetailCustomByDep.php',
        success(data) {
            console.log(data);
            $.each(data, function (key, registro) {
                var contenido = "<tr>";
                contenido += '<td><small class="text-orange text-muted">Factura No°</small><br><small>'+ registro.serie +' '+ registro.noBill +'</small><br><small class="text-olive text-muted">Remision No°</small><br><small>'+ registro.noDeliver +'</small></td>';
                contenido += "<td>" + convertDate(registro.dateStart); + "</td>";
                contenido += "<td>Q " + registro.saldo + "</td>";
                contenido += '</tr>';
                $(".contenidorptDetalle3").append(contenido);
            });
            swal.close();
            funciones2();
        },
        error: function (data) {
            swal({
                type: 'error',
                title: 'Error',
                text: 'Algo ha salido mal, intentalo más tarde',
            })
        }
    })
}

function printReport1() {
    
    changeReport('ventasVencidas.php');
    $('#modal-reporte').modal('show');
}

function printReport2() {
    
    var idSeller = $('.idVen').val();
    var f1 = $("[name='dateSrpt2']").val();
    var f2 = $("[name='dateErpt2']").val();
    changeReport('salesBySeller.php?idVendedor='+idSeller+'&fecha1='+f1+'&fecha2='+f2);
    $('#modal-reporte').modal('show');
}

function printrptDetail2(idVent) {
    
    var fec1 = $('.fp'+idVent).val();
    var fec2 = $('.fv'+idVent).val();
    changeReport('salesBySellerDetail.php?idVenta='+idVent+'&fecha1='+fec1+'&fecha2='+fec2);
    $('#modal-reporte').modal('show');
}

function printReport3() {
    var idDep = $("[name='depReporte']").val();
    changeReport('CustomByDep.php?idDepartamento='+idDep);
    $('#modal-reporte').modal('show');
}

function printrptDetail3(idCliente) {
    
    changeReport('CustomByDepDetail.php?idCliente='+idCliente);
    $('#modal-reporte').modal('show');
}

function printReport4() {
    
    var idSeller = $("[name='sellerReporte4']").val();
    var f1 = $("[name='dateSrpt4']").val();
    var f2 = $("[name='dateErpt4']").val();
    changeReport('ComBySeller.php?idVendedor='+idSeller+'&fecha1='+f1+'&fecha2='+f2);
    $('#modal-reporte').modal('show');
}

function printReport5() {
    var f1 = $("[name='dateSrpt5']").val();
    changeReport('dailyStock.php?fecha1='+f1);
    $('#modal-reporte').modal('show');
}

function convertDate(dateString) {
    var p = dateString.split(/\D/g)
    return [p[2], p[1], p[0]].join("-")
}

function comision(dif, marca, subtotal, s30, s60, s90, o30, o60, sd30, sd60, sd90, od30, od60) {
    var comision;
    if (marca == 'SCHLENKER') {
        if (dif <= sd30) {
            comision = subtotal * (s30/100);
        } else if (dif > sd30 && dif <= sd60) {
            comision = subtotal * (s60/100);
        } else if (dif > sd60 && dif <= sd90) {
            comision = subtotal * (s90/100);
        } else {
            comision = 0;
        }
    } else {
        if (dif <= od30) {
            comision = subtotal * (o30/100);
        } else if (dif > od30 && dif <= od60) {
            comision = subtotal * (o60/100);
        } else {
            comision = 0;
        }
    }

    return comision.toFixed(2);
}

function funciones() {
    $('#registros').DataTable({
        'paging'      : true,
        'lengthChange': true,
        "aLengthMenu" : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'language'    : {
          paginate: {
            next:     'Siguiente',
            previous: 'Anterior',
            first:    'Primero',
            last:     'Último'
          },
          info: 'Mostrando _START_-_END_ de _TOTAL_ registros',
          empyTable:  'No hay registros',
          infoEmpty:  '0 registros',
          lengthChange: 'Mostrar ',
          infoFiltered: "(Filtrado de _MAX_ total de registros)",
          lengthMenu: "Mostrar _MENU_ registros",
          loadingRecords: "Cargando...",
          processing: "Procesando...",
          search: "Buscar:",
          zeroRecords: "Sin resultados encontrados"
        }
    });
}

function funciones2() {
    $('#registros2').DataTable({
        'paging'      : true,
        'lengthChange': true,
        "aLengthMenu" : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'language'    : {
          paginate: {
            next:     'Siguiente',
            previous: 'Anterior',
            first:    'Primero',
            last:     'Último'
          },
          info: 'Mostrando _START_-_END_ de _TOTAL_ registros',
          empyTable:  'No hay registros',
          infoEmpty:  '0 registros',
          lengthChange: 'Mostrar ',
          infoFiltered: "(Filtrado de _MAX_ total de registros)",
          lengthMenu: "Mostrar _MENU_ registros",
          loadingRecords: "Cargando...",
          processing: "Procesando...",
          search: "Buscar:",
          zeroRecords: "Sin resultados encontrados"
        }
    });
}