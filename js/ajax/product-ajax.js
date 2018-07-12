$(document).ready(function () {
    getCategory();
    getUnity();
    getMake();

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

    
function getCategory(){
    $.ajax({
      type: "GET",
      url: 'BLL/listCategory.php', 
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

  function getUnity(){
    $.ajax({
      type: "GET",
      url: 'BLL/listUnity.php', 
      dataType: "json",
      success: function(data){
        console.log(data);
        $.each(data,function(key, registro) {
          $("#unity").append('<option value='+registro.idUnity+'>'+registro.unityName+'</option>');
        });        
      },
      error: function(data) {
        alert('error');
      }
    });
  }

  function getMake(){
    $.ajax({
      type: "GET",
      url: 'BLL/listMake.php', 
      dataType: "json",
      success: function(data){
        console.log(data);
        $.each(data,function(key, registro) {
          $("#make").append('<option value='+registro.idMake+'>'+registro.makeName+'</option>');
        });        
      },
      error: function(data) {
        alert('error');
      }
    });
  }