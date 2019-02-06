$(document).ready(function () {

    $('#form-factura').on('submit', function (e) {
        e.preventDefault();

        swal({
            title: '¿Estás Seguro?',
            text: "Crear una factura altera al correlativo actual",
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
});

function eliminarDetalle_Factura(id) {
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

        if (idprod == id) {
            precion = parseFloat(precion) - parseFloat(descuento);
            updateTotalS(cantn, precion, 1);
        }
    }
    jQuery('[data-id-detalle="' + id + '"]').parents('#detalleF').remove();
}