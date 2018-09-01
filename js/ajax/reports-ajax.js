$(document).ready(function () {

    $('#form-SalesBySeller').on('submit', function (e) {
        e.preventDefault();
        $("#listadoReporte").html("");
        
        var tabla = '<div class="box-body table-responsive no-padding"><table id="registros" class="table table-bordered table-striped"><thead><tr><th>Fecha</th><th>Factura No°</th><th>Cliente</th><th>Fecha de vencimiento</th><th>Método de pago</th><th>Envío No°</th><th>Entrega No°</th><th>Anticipo</th><th>Total</th><th><i class="fa fa-cogs"></i> Acciones</th></tr></thead><tbody class="contenidoRPT"></tbody><tfoot><tr><th>Fecha</th><th>Factura No°</th><th>Cliente</th><th>Fecha de vencimiento</th><th>Método de pago</th><th>Envío No°</th><th>Entrega No°</th><th>Anticipo</th><th>Total</th><th><span class="fa fa-cogs"></span></th></tr></tfoot></table></div><button type="button" onclick="printReport2()" class="btn bg-teal-active btn-sm"><i class="fa fa-print"></i> Imprimir</button>';

        $("#listadoReporte").append(tabla);
        
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
                    contenido += "<td><input class='idVen' type='hidden' value='" + registro._idSeller + "'>" + registro.dateStart + "</td>";
                    contenido += "<td>" + registro.noBill + "</td>";
                    contenido += "<td>" + registro.customer + "</td>";
                    contenido += "<td>" + registro.dateEnd + "</td>";
                    contenido += "<td>" + registro.paymentMethod + "</td>";
                    contenido += "<td>" + registro.noShipment + "</td>";
                    contenido += "<td>" + registro.noDeliver + "</td>";
                    contenido += "<td>" + registro.advance + "</td>";
                    contenido += "<td>" + registro.totalSale + "</td>";
                    contenido += '<td><div class="btn-group-vertical"><a href="#tab_2" data-toggle="tab" class="btn bg-maroon btn-flat margin quitar_product"><i class="fa fa-remove"></i></a><button type="button" class="btn btn-success btn-sm detalle_rpt1" data-id="'+ registro.idSale +'" data-tipo="listDetailS"><i class="fa fa-info"></i> Detalles</button></div></td>';
                    contenido += '</tr>';
                    $(".contenidoRPT").append(contenido);
                });
                swal.close();
                funciones();
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

function listAllRoutes() {

    changeReport('rptAllRoutes.php');
}

function printReport2() {
    
    var idSeller = $('.idVen').val();
    changeReport('salesBySeller.php?idVendedor='+idSeller);
    $('#modal-reporte').modal('show');
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