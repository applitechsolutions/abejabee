<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2018 <a href="#">Applitech Solutions</a>.</strong> Todos Los Derechos Reservados.
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
<script src="js/raphael.min.js"></script>
<script src="js/morris.min.js"></script>
<script src="js/Chart.min.js"></script>
<!-- AJAX FOR SCHLENKER PHARMA -->
<script src="js/ajax/reports-ajax.js"></script>
<script src="js/ajax/sale-ajax.js"></script>
<script src="js/ajax/customer-ajax.js"></script>
<script src="js/ajax/purchase-ajax.js"></script>
<script src="js/ajax/route-ajax.js"></script>
<script src="js/ajax/product-ajax.js"></script>
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

    $(".SelectPrice").select2({
        minimumResultsForSearch: -1,
        templateResult: formatState,
        templateSelection: formatState
    });

    function formatState (state) {
      if (!state.id) { return state.text; }
      var $state = $('<span ><i class="fa fa-'+ state.id +'"> ' + ' '+state.text + '</span>');
      return $state;
    }

    $('#datepicker').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
    });

    $('#datepicker2').datepicker({
      format: 'dd/mm/yyyy',
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
  })
  function valListados() {
    swal({
      position: 'top-end',
      type: 'warning',
      title: 'No estas autorizado a realizar esta operación :(',
      showConfirmButton: false,
      timer: 1500
    })
  }

  function changeReport(report){
    $('#divreporte').html('<iframe src="ReportsPDF/'+report+'" style="width: 100%; min-width: 300px; height: 810px"></iframe>');
  }

     // Get context with jQuery - using jQuery's .get() method.
     var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

   $.getJSON('BLL/dashSalesbyMonths.php', function(data) {
    var months = [];
    var count = [];
    var i=0;
         for(i=0;i<data.length;i++){
            months[i]=[String(data[i].month)];
            count[i]=[String(data[i].ventasT)];
        }
      var areaChartData = {
      labels  : months,
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : count
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)
    });

</script>
</body>
</html>
