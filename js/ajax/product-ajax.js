$(document).ready(function () {
    getData();

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
                        $("#catClose").click();
                        getData();
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

    
function getData(){
    $.ajax({
      type: "GET",
      url: 'BLL/listProduct.php', 
      dataType: "json",
      success: function(data){
        console.log(data);
        $.each(data,function(key, registro) {
          $("#category").append('<option value='+registro.idCategory+'>'+registro.catName+'</option>');
        });        
      },
      error: function(data) {
        alert('error');
      }
    });
  }