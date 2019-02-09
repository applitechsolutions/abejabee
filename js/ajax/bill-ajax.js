$(document).ready(function () {

    $('#form-factura').on('submit', function (e) {
        e.preventDefault();
        var tipo = $('#factura').val();
        var texto;
        if (tipo == 'nueva') {
            texto = "Crear una factura altera al correlativo actual";
        }else if (tipo == "editar") {
            texto = "Desea editar la factura actual, no se altera el correlativo";            
        }
        swal({
            title: '¿Estás Seguro?',
            text: texto,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Generar!',
            cancelButtonText: 'Cancelar'
        }).then(() => {
            var datos = $(this).serializeArray();

            var id_product = document.getElementsByClassName("idproducto_class");
            var precio_detalle = document.getElementsByClassName("precio_class");
            var cantidad_detalle = document.getElementsByClassName("cantidad_class");
            var descuento_detalle = document.getElementsByClassName("descuento_class");

            var json = "";
            var i;
            for (i = 0; i < id_product.length; i++) {
                json += ',{"idproduct":"' + id_product[i].value + '"'
                json += ',"precio_det":"' + precio_detalle[i].value + '"'
                json += ',"cantdet":"' + cantidad_detalle[i].value + '"'
                json += ',"descudet":"' + descuento_detalle[i].value + '"}'
            }
            obj = JSON.parse('{ "detailS" : [' + json.substr(1) + ']}');
            datos.push({ name: 'json', value: JSON.stringify(obj) });

            $.ajax({
                type: $(this).attr('method'),
                data: datos,
                url: $(this).attr('action'),
                datatype: 'json',
                success: function (data) {
                    console.log(data);
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        if (resultado.proceso == 'nuevo') {
                            changeReportL('factura.php?idBill=' + resultado.idBill);
                            swal.close();                            
                            $('#modal-printS').modal({backdrop: 'static', keyboard: false});
                        }else if (resultado.proceso == 'editado') {
                            changeReportL('factura.php?idBill=' + resultado.idBill);
                            swal.close();                            
                            $('#modal-printS').modal({backdrop: 'static', keyboard: false});
                        }
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

    $('.detalle_bill').on('click', function (e) {
        e.preventDefault();
        $("#detalles").find('tbody').html("");
        $("#editarF").html("");
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Cargando detalle de Factura...'
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
                    var sub = registro.quantity * (parseFloat(Math.round(registro.priceB * 100) / 100).toFixed(2) - parseFloat(Math.round(registro.discount * 100) / 100).toFixed(2));
                    nuevaFila += "<td><img src='img/products/" + registro.imagen + "'width='80' onerror='ImgError(this);'></td>";
                    nuevaFila += "<td><input class='idproducto_class' type='hidden' value='" + registro._idProduct + "'>" + registro.nombre + "</td>";
                    nuevaFila += "<td>" + registro.codigo + "</td>";
                    nuevaFila += "<td><input class='cantidad_class' type='hidden' value='" + registro.quantity + "'>" + registro.quantity + "</td>";
                    nuevaFila += "<td>Q." + registro.priceB + "</td>";
                    nuevaFila += "<td>Q." + registro.discount + "</td>";
                    nuevaFila += "<td>Q." + sub.toFixed(2) + "</td>";
                    nuevaFila += "</tr>";
                    $("#detalles").append(nuevaFila);
                });
                var btnEditar = "<a href='editBill.php?id=" + id + "' class='btn bg-green btn-lg btn-flat pull-left'>";
                btnEditar += "<i class='fas fa-pen-square'></i> Editar Factura";
                btnEditar += "</a>";
                $("#editarF").append(btnEditar);
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
});

function eliminarDetalle_Factura(id) {
    var idproduct = document.getElementsByClassName("id_detalle_class");
    var nprecio = document.getElementsByClassName("precio_class");
    var ncantidad = document.getElementsByClassName("cantidad_class");
    var descuento_detalle = document.getElementsByClassName("descuento_class");

    var x;

    for (x = 0; x < idproduct.length; x++) {

        idprod = idproduct[x].value;
        precion = nprecio[x].value;
        cantn = ncantidad[x].value;
        descuento = descuento_detalle[x].value;

        if (idprod == id) {
            precion = parseFloat(precion) - parseFloat(descuento);
            updateTotalS(cantn, precion, 1);
        }
    }
    jQuery('[data-id-detalle="' + id + '"]').parents('#detalleF').remove();
}