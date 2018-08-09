$(document).ready(function () {

    $('#form-product').on('submit', function (e) {
        e.preventDefault();

        var datos = new FormData(this);

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            cache: false,
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    if (resultado.proceso == 'nuevo') {
                        priceSale(resultado.idProduct, 1, resultado.public),
                        priceSale(resultado.idProduct, 11, resultado.pharma),
                        priceSale(resultado.idProduct, 21, resultado.business),
                        priceSale(resultado.idProduct, 31, resultado.bonus)
                        swal({                            
                            title: 'Exito!',
                            text: '¡' + resultado.mensaje,
                            timer: 2000,
                            type: 'success'
                          }).then(
                            setTimeout(function () {
                                location.reload();
                            }, 1500))
                       
                    } else if (resultado.proceso == 'editado') {
                        priceSale_edit(resultado.idProduct, 1, resultado.public),
                        priceSale_edit(resultado.idProduct, 11, resultado.pharma),
                        priceSale_edit(resultado.idProduct, 21, resultado.business),
                        priceSale_edit(resultado.idProduct, 31, resultado.bonus)
                        swal({                            
                            title: 'Exito!',
                            text: '¡' + resultado.mensaje,
                            timer: 2000,
                            type: 'success'
                          }).then(
                            setTimeout(function () {
                                //window.location.href = 'listProducts.php';
                            }, 1500))                       
                    }
                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Debe llenar todos los campos obligatorios',
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

    $('.borrar_product').on('click', function(e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: '¿Estás Seguro?',
            text: "Un registro eliminado no puede recuperarse",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Eliminar!',
            cancelButtonText: 'Cancelar'
          }).then(() => {
                  $.ajax({
                      type: 'POST',
                      data: {
                          'id': id,
                          'producto': 'eliminar'
                      },
                      url: 'BLL/' + tipo + '.php',
                      success(data) {
                          console.log(data);
                          var resultado = JSON.parse(data);
                          if (resultado.respuesta == 'exito') {
                              swal('Eliminado!', 'El producto ha sido borrado con exito.', 'success');
                              jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                          }
                          else {
                              swal({
                                  type: 'error',
                                  title: 'Error!',
                                  text: 'No se pudo eliminar el producto.'
                              });
                          }
                      }
                  });
              });
    });

    $('#form-category').on('submit', function (e) {
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
                    swal(
                        'Exito!',
                        '¡' + resultado.mensaje,
                        'success'
                    )
                    if (resultado.proceso == 'nuevo') {
                        getCategory();
                        document.getElementById("form-category").reset();
                        $("#catClose").click();

                    } else if (resultado.proceso == 'editado') {
                        setTimeout(function () {
                            window.location.href = 'listSellers.php';
                        }, 1500);
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

    $('#form-unity').on('submit', function (e) {
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
                    swal(
                        'Exito!',
                        '¡' + resultado.mensaje,
                        'success'
                    )
                    if (resultado.proceso == 'nuevo') {
                        getUnity();
                        document.getElementById("form-unity").reset();
                        $("#uniClose").click();

                    } else if (resultado.proceso == 'editado') {
                        setTimeout(function () {
                            window.location.href = 'listSellers.php';
                        }, 1500);
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

    $('#form-make').on('submit', function (e) {
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
                    swal(
                        'Exito!',
                        '¡' + resultado.mensaje,
                        'success'
                    )
                    if (resultado.proceso == 'nuevo') {
                        getMake();
                        document.getElementById("form-make").reset();
                        $("#makeClose").click();

                    } else if (resultado.proceso == 'editado') {
                        setTimeout(function () {
                            window.location.href = 'listSellers.php';
                        }, 1500);
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

function priceSale(idProduct, idPrice, price) {

    $.ajax({
        type: 'POST',
        data: {
            'priceSale': 'nuevo',
            'id_product': idProduct,
            'id_price' : idPrice,
            'price' : price
        },
        url: 'BLL/priceSale.php',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var resultado = data;
            if (resultado.respuesta == 'exito') {
            } else if (resultado.respuesta == 'error') {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'No se pudo guardar en la base de datos',
                })
            }
        }
    })
}

function priceSale_edit(idProduct, idPrice, price) {

    $.ajax({
        type: 'POST',
        data: {
            'priceSale': 'editar',
            'id_product': idProduct,
            'id_price' : idPrice,
            'price' : price
        },
        url: 'BLL/priceSale.php',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var resultado = data;
            if (resultado.respuesta == 'exito') {
            } else if (resultado.respuesta == 'error') {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'No se pudo guardar en la base de datos',
                })
            }
        }
    })
}

function getCategory() {
    $("#category").html("");
    $.ajax({
        type: "GET",
        url: 'BLL/listCategory.php',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#category").append('<option value=' + registro.idCategory + '>' + registro.catName + '</option>');
            });
        },
        error: function (data) {
            alert('error');
        }
    });
}

function getUnity() {
    $("#unity").html("");
    $.ajax({
        type: "GET",
        url: 'BLL/listUnity.php',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#unity").append('<option value=' + registro.idUnity + '>' + registro.unityName + '</option>');
            });
        },
        error: function (data) {
            alert('error');
        }
    });
}

function getMake() {
    $("#make").html("");
    $.ajax({
        type: "GET",
        url: 'BLL/listMake.php',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#make").append('<option value=' + registro.idMake + '>' + registro.makeName + '</option>');
            });
        },
        error: function (data) {
            alert('error');
        }
    });
}