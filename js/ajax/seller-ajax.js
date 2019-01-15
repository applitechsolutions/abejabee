$(document).ready(function() {

    $('#form-vendedor').on('submit', function(e) {
        e.preventDefault();
        
        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data){
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal(
                        'Exito!',
                        '¡'+resultado.mensaje,
                        'success'
                      )
                      if (resultado.proceso == 'nuevo') {
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                    } else if (resultado.proceso == 'editado'){
                        setTimeout(function() {
                            window.location.href = 'listSellers.php';
                        }, 1500);
                    }
                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Debe llenar todos los campos',
                      })
                }else if (resultado.respuesta == 'error'){
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar en la base de datos',
                      })
                }
            }
        })
        
    });

    $('.borrar_vendedor').on('click', function(e) {
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
          }).then((result) => {
                $.ajax({
                    type: 'POST',
                    data: {
                        'id': id,
                        'reg-vendedor': 'eliminar'
                    },
                    url: 'BLL/'+tipo+'.php',
                    success(data){
                        console.log(data);
                        var resultado = JSON.parse(data);
                        if (resultado.respuesta == 'exito') {
                            swal(
                                'Eliminado!',
                                'El vendedor ha sido borrado con exito.',
                                'success'
                              )
                            jQuery('[data-id="'+resultado.id_eliminado+'"]').parents('tr').remove(); 
                        }else {
                            swal({
                                type: 'error',
                                title: 'Error!',
                                text: 'No se pudo eliminar el vendedor.'
                              })
                        }
                        
                    }
                });
            });
    });

    $('.listarcomision').on('click', function (e) {
        e.preventDefault();
        $('#contenido-comision').html("");
        $('#nombre-vendedor').html("");
        $('#encabezado-comision').html("");
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Cargando comisiones...'
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
                    var nombredetalle = "<h3 class='box-title'>"+ registro.nombre +" "+ registro.apellido +"</h3>";  
                    $('#nombre-vendedor').append(nombredetalle);
                    var encabezado = "<th style='width: 10px; color: MidnightBlue;'><small>Propio</small></th>";
                    encabezado += "<th>" + registro.sd30 + "/d</th>";
                    encabezado += "<th>" + registro.sd60 + "/d</th>";
                    encabezado += "<th>" + registro.sd90 + "/d</th>";
                    encabezado += "<th style='width: 10px; color: MidnightBlue;'><small>Otros</small></th>";
                    encabezado += "<th>" + registro.od30 + "/d</th>";
                    encabezado += "<th>" + registro.od60 + "/d</th>"; 
                    $("#encabezado-comision").append(encabezado);
                    var nuevaFila = "<td></td>";
                    nuevaFila += "<td>" + registro.s30 + "%</td>";
                    nuevaFila += "<td>" + registro.s60 + "%</td>";
                    nuevaFila += "<td>" + registro.s90 + "%</td>";
                    nuevaFila += "<td></td>";
                    nuevaFila += "<td>" + registro.o30 + "%</td>";
                    nuevaFila += "<td>" + registro.o60 + "%</td>";
                    $("#contenido-comision").append(nuevaFila);
                });
                swal.close();
                $('#modal-commission').modal('show');
            },
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error, intente más tarde :(',
                })
            }
        });
    });
});