$(document).ready(function() {

    $('#form-departamento').on('submit', function (e) {
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
                    
                    document.getElementById("form-departamento").reset();
                    $("#depClose").click();
                    getDepartment();
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

    $('#form-muni').on('submit', function (e) {
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
                    
                    document.getElementById("form-muni").reset();
                    $("#muniClose").click();
                    getTown();
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

    $('#form-aldea').on('submit', function (e) {
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
                    
                    document.getElementById("form-aldea").reset();
                    $("#aldClose").click();
                    getVillage();
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

function getDepartment() {
    $("#departamento").html("");
    $("#departamento").append('<option value="">Seleccione un departamento</option>');
    $.ajax({
        type: "GET",
        url: 'BLL/listDepartment.php',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#departamento").append('<option value=' + registro.idDeparment + ' selected>' + registro.name + '</option>');
            });
        },
        error: function (data) {
            alert('error');
        }
    });
}

function getTown() {
    $("#muni").html("");
    $("#muni").append('<option value="">Seleccione un municipio</option>');
    $.ajax({
        type: "GET",
        url: 'BLL/listTown.php',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#muni").append('<option value=' + registro.idTown + ' selected>' + registro.name + '</option>');
            });
        },
        error: function (data) {
            alert('error');
        }
    });
}

function getVillage() {
    $("#aldea").html("");
    $("#aldea").append('<option value="">Seleccione una aldea</option>');
    $.ajax({
        type: "GET",
        url: 'BLL/listVillage.php',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#aldea").append('<option value=' + registro.idVillage + ' selected>' + registro.name + '</option>');
            });
        },
        error: function (data) {
            alert('error');
        }
    });
}