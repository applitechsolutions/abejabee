<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.1.0
    </div>
    <strong>Copyright &copy; 2018 - <?php echo date("Y"); ?> <a href="#">Applitech Software Solutions</a>.</strong>
    Todos Los
    Derechos Reservados.
</footer>


</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="js/jquery.min.js">
</script>
<!-- Bootstrap 3.3.7 -->
<script src="js/bootstrap.min.js">
</script>
<!-- SlimScroll -->
<script src="js/jquery.slimscroll.min.js">
</script>
<!-- FastClick -->
<script src="js/fastclick.js">
</script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js">
</script>

<script>
function convertDate(dateString) {
    var p = dateString.split(/\D/g)
    return [p[2], p[1], p[0]].join("/")
}
</script>
<script src="js/demo.js">
</script>
<script src="js/sweetalert2.min.js">
</script>
<script src="js/moment.min.js">
</script>
<script src="js/raphael.min.js">
</script>
<script src="js/morris.min.js">
</script>
<script src="js/Chart.min.js">
</script>
<!-- AJAX FOR SCHLENKER PHARMA -->
<script src="js/ajax/bill-ajax.js">
</script>
<script src="js/ajax/reports-ajax.js">
</script>
<script src="js/ajax/sale-ajax.js">
</script>
<script src="js/ajax/customer-ajax.js">
</script>
<script src="js/ajax/purchase-ajax.js">
</script>
<script src="js/ajax/route-ajax.js">
</script>
<script src="js/ajax/product-ajax.js">
</script>
<script src="js/ajax/seller-ajax.js">
</script>
<script src="js/ajax/provider-ajax.js">
</script>
<script src="js/ajax/user-ajax.js">
</script>
<script src="js/ajax/login.js">
</script>
<script src="js/jquery.dataTables.min.js">
</script>
<script src="js/dataTables.bootstrap.min.js">
</script>
<script src="js/bootstrap-datepicker.min.js">
</script>
<script src="js/icheck.min.js">
</script>
<script src="js/select2.full.min.js">
</script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>


<script>
$(document).ready(function() {

    $('.sidebar-menu').tree()

    $('.select2').select2()

    $(".SelectPrice").select2({
        minimumResultsForSearch: -1,
        templateResult: formatState,
        templateSelection: formatState
    });

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $('<span ><i class="fa fa-' + state.id + '"> ' + ' ' + state.text + '</span>');
        return $state;
    }

    $('#datepicker, #datepicker5, #datepicker6, #datepicker6').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('#datepicker2').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('#datepicker3').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('#datepicker4').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    })


    $('#registros').DataTable({
        "order": [],
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false,
        }],
        'paging': true,
        'lengthChange': true,
        "aLengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'language': {
            paginate: {
                next: 'Siguiente',
                previous: 'Anterior',
                first: 'Primero',
                last: 'Último'
            },
            info: 'Mostrando _START_-_END_ de _TOTAL_ registros',
            empyTable: 'No hay registros',
            infoEmpty: '0 registros',
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

function changeReport(report) {
    $('#divreporte').html('<iframe src="ReportsPDF/' + report +
        '" style="width: 100%; min-width: 300px; height: 810px"></iframe>');
}
</script>
</body>

</html>