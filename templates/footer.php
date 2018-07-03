<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2018 <a href="#">Applitech Solutions</a>.</strong> All rights
    reserved.
</footer>


</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>

<script src="js/demo.js"></script>
<script src="js/sweetalert2.min.js"></script>
<!-- AJAX FOR SCHLENKER PHARMA -->
<script src="js/ajax/seller-ajax.js"></script>
<script src="js/ajax/provider-ajax.js"></script>
<script src="js/ajax/user-ajax.js"></script>
<script src="js/ajax/login.js"></script>

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/icheck.min.js"></script>
<script src="js/select2.full.min.js"></script>


<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()

    $('.select2').select2()

    $('#datepicker').datepicker({
      autoclose: true
    });
    

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })


    $('#registros').DataTable({
      'paging'      : true,
      'lengthChange': true,
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
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
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
  })
</script>
</body>
</html>