<?php
  include_once 'funciones/sesiones.php';
  include_once 'templates/header.php';
  include_once 'templates/navBar.php';
  include_once 'templates/sideBar.php';
  include_once 'funciones/bd_conexion.php';

  function porcentaje($total, $parte, $redondear = 2) {
    return round($parte / $total * 100, $redondear);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-line-chart"></i>
      Dashboard
      <small>Estadísticas de Schlenker Pharma</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
            $sql = "SELECT COUNT(idProduct) AS productos FROM product P INNER JOIN storage S ON P.idProduct = S._idProduct";
            $resultado = $conn->query($sql);
            $productos = $resultado->fetch_assoc();
            ?>
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>
              <?php echo $productos['productos']; ?>
            </h3>

            <p>Total de productos</p>
          </div>
          <div class="icon">
            <i class="glyphicon glyphicon-book"></i>
          </div>
          <a href="index.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
            $sql = "SELECT COUNT(idProduct) AS productos FROM product P INNER JOIN storage S ON P.idProduct = S._idProduct WHERE S.stock > P.minStock";
            $resultado = $conn->query($sql);
            $productos = $resultado->fetch_assoc();
            ?>
        <div class="small-box bg-green">
          <div class="inner">
            <h3>
              <?php echo $productos['productos']; ?>
            </h3>

            <p>En existencia</p>
          </div>
          <div class="icon">
            <i class="glyphicon glyphicon-th-large"></i>
          </div>
          <a href="index.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
            $sql = "SELECT COUNT(idProduct) AS productos FROM product P INNER JOIN storage S ON P.idProduct = S._idProduct WHERE S.stock = P.minStock";
            $resultado = $conn->query($sql);
            $productos = $resultado->fetch_assoc();
            ?>
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>
              <?php echo $productos['productos']; ?>
            </h3>

            <p>En límite de existencia</p>
          </div>
          <div class="icon">
            <i class="fa fa-exclamation-triangle"></i>
          </div>
          <a href="index.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <?php
            $sql = "SELECT COUNT(idProduct) AS productos FROM product P INNER JOIN storage S ON P.idProduct = S._idProduct WHERE S.stock < P.minStock";
            $resultado = $conn->query($sql);
            $productos = $resultado->fetch_assoc();
            ?>
        <div class="small-box bg-red">
          <div class="inner">
            <h3>
              <?php echo $productos['productos']; ?>
            </h3>

            <p>Sin existencia</p>
          </div>
          <div class="icon">
            <i class="fa fa-exclamation"></i>
          </div>
          <a href="index.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>

    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Reporte de ventas</h3>
  
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <h6>Total de ventas en un rango de fechas:</h6>
              <div class="row">
                <form role="form" id="form-DASH" name="form-DASH" method="post" action="BLL/dashTotalSales.php">
                  <div class="col-md-offset-1 col-md-2">
                    <div class="form-group">
                      <span class="text-danger text-uppercase"></span>
                      <label>Fecha Inicial</label>
                      <div class="input-group date">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="datepicker" name="dateDASHS">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <span class="text-danger text-uppercase"></span>
                      <label>Fecha Final</label>
                      <div class="input-group date">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="datepicker2" name="dateDASHE">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <button style="margin-top:27px;" type="submit" class="btn btn-primary pull-right" id="rpt4"><i class="fa fa-list-alt" aria-hidden="true"></i> Generar Total</button>
                  </div>
                  <div class="col-md-4 pull-left">
                    <div class="info-box bg-secondary">
                        <span class="info-box-icon"><i class="fas fa-money"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Total:</span>
                          <span class="info-box-number"><label for="totalS" id="totalVentasDASH">0</label></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                  </div>
                </form>
              </div>
              <h6>Ventas en el año en curso</h6>
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Ventas:
                      <?php echo date("01/01/Y"); ?> -
                      <?php echo date("d/m/Y"); ?> </strong>
                  </p>
  
                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="areaChart" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Estado actual</strong>
                  </p>                 
                  <?php
                   //ventas activas vencidas:
                      $sql = "SELECT COUNT(idSale) AS ventasV, sum(totalSale) as total FROM sale WHERE dateEnd <= CURDATE() AND cancel = 0 AND state = 0";
                      $resultado = $conn->query($sql);
                      $ventasV = $resultado->fetch_assoc();
                      ?>
                  <?php
                  //total de ventas:
                      $sql = "SELECT COUNT(idSale) AS ventasT, sum(totalSale) as total FROM sale WHERE state = 0 AND YEAR(dateEnd) = YEAR(CURDATE()) AND dateEnd > CURDATE()";
                      $resultado = $conn->query($sql);
                      $ventasT = $resultado->fetch_assoc();
                      $ventasTotal = $ventasT['ventasT'] + $ventasV['ventasV'];
                      $total = $ventasT['total'] + $ventasV['total'];
                      ?>
                  <div class="progress-group">
                    <?php
                      $sql = "SELECT COUNT(idSale) AS ventas, sum(totalSale) as total FROM sale WHERE dateEnd >= CURDATE() AND cancel = 0 AND state = 0";
                      $resultado = $conn->query($sql);
                      $ventas = $resultado->fetch_assoc();
                      ?>
                    <span class="progress-text">Ventas activas</span>
                    <span class="progress-number"><b>
                        <?php echo $ventas['ventas']; ?></b>/
                      <?php echo $ventasTotal; ?></span>
  
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo porcentaje($ventasTotal,$ventas['ventas'],2); ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Ventas vencidas</span>
                    <span class="progress-number"><b>
                        <?php echo $ventasV['ventasV']; ?></b>/
                      <?php echo $ventasTotal; ?></span>
  
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?php echo porcentaje($ventasTotal,$ventasV['ventasV'],2); ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <?php
                      $sql = "SELECT COUNT(idSale) AS ventasPT, sum(totalSale) as total FROM sale WHERE cancel = 1 AND state = 0 AND YEAR(dateStart) = YEAR(CURDATE())";
                      $resultado = $conn->query($sql);
                      $ventasPT = $resultado->fetch_assoc();
                      ?>
                    <span class="progress-text">Ventas pagadas</span>
                    <span class="progress-number"><b>
                        <?php echo $ventasPT['ventasPT']; ?>/
                        <?php echo $ventasTotal; ?></span>
  
                    <div class="progress sm">
                      <div class="progress-bar progress-bar" style="width: <?php echo porcentaje($ventasTotal,$ventasPT['ventasPT'],2); ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <?php
                      $sql = "SELECT COUNT(idSale) AS ventasPV FROM sale WHERE state = 1";
                      $resultado = $conn->query($sql);
                      $ventasPV = $resultado->fetch_assoc();
                      ?>
                    <span class="progress-text">Ventas anuladas</span>
                    <span class="progress-number"><b>
                        <?php echo $ventasPV['ventasPV']; ?></b>/--- </span>
  
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo porcentaje($ventasT['ventasT']+ $ventasPV['ventasPV'],$ventasPV['ventasPV'],2); ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-ye"><i class="fa fa-caret-left"></i>
                      <?php echo $ventasTotal; ?></b></span>
                    <h5 class="description-header">Q
                      <?php echo number_format($total, 2, '.', ','); ?>
                    </h5>
                    <span class="description-text">TOTAL VENTAS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i>
                      <?php echo porcentaje($ventasTotal,$ventas['ventas'],2); ?>%</b></span>
                    <h5 class="description-header">Q
                      <?php echo number_format($ventas['total'], 2, '.', ','); ?>
                    </h5>
                    <span class="description-text">TOTAL ACTIVO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i>
                      <?php echo porcentaje($ventasTotal,$ventasV['ventasV'],2); ?>%</span>
                    <h5 class="description-header">Q
                      <?php echo number_format($ventasV['total'], 2, '.', ','); ?>
                    </h5>
                    <span class="description-text">TOTAL ATRASADO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-blue"><i class="fa fa-caret-up"></i>
                      <?php echo porcentaje($ventasTotal,$ventasPT['ventasPT'],2); ?>%</span>
                    <h5 class="description-header">Q
                      <?php echo number_format($ventasPT['total'], 2, '.', ','); ?>
                    </h5>
                    <span class="description-text">TOTAL CANCELADO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>

    <div class="row">
      <div class="col-md-8">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Ultimas ventas</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Remision No°</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Envío No°</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                        try {
                            $sql = "SELECT S.*,
                                            (select concat(sellerFirstName, ' ', sellerLastName) from seller where idSeller = S._idSeller) as seller,
                                            (select concat(customerCode, ' ', customerName) from customer where idCustomer = S._idCustomer) as customer
                                            FROM sale S WHERE S.cancel = 0 AND S.state = 0 ORDER BY idSale DESC LIMIT 5";
                            $resultado = $conn->query($sql);
                        } catch (Exception $e) {
                            $error = $e->getMessage();
                            echo $error;
                        }
                        
                        while ($sale = $resultado->fetch_assoc()) {
                            $dateStar = date_create($sale['dateStart']);
                            ?>
                  <tr>
                    <td>
                      <?php echo date_format($dateStar, 'd/m/y'); ?>
                    </td>
                    <td>
                        <span class="label label-success"><?php echo $sale['noDeliver']; ?></span>
                    </td>
                    <td>
                      <?php echo $sale['seller']; ?>
                    </td>
                    <td>
                      <?php echo $sale['customer']; ?>
                    </td>
                    <td>
                      <?php echo $sale['noShipment']."___ ".$sale['note']; ?>
                    </td>
                    <td>Q.
                      <?php echo $sale['totalSale']; ?>
                    </td>
                  </tr>
                  <?php }
                        ?>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <a href="newSale.php" class="btn btn-sm btn-info btn-flat pull-left">Crear Nueva Venta</a>
            <a href="listSalesA.php" class="btn btn-sm btn-default btn-flat pull-right">Ver TODAS</a>
          </div>
          <!-- /.box-footer -->
        </div>
      </div>
      <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Productos más vendidos</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              <?php
                try{
                  $sql = "SELECT (select CONCAT(productCode, ' ', productName) from product where idProduct = `_idProduct` ) as product,
                  (select description from product where idProduct = `_idProduct` ) as description,
                  (select picture from product where idProduct = `_idProduct` ) as picture,
                  SUM(quantity) FROM `details` D GROUP BY `_idProduct`ORDER BY SUM(quantity) DESC LIMIT 5";
                  $resultado = $conn->query($sql);
                } catch (Exception $e){
                  $error= $e->getMessage();
                  echo $error;
                }
                
                while ($product = $resultado->fetch_assoc()) {
              ?>
              <li class="item">
                <div class="product-img">
                  <img src="img/products/<?php echo $product['picture']; ?>" alt="Product Image" onerror="this.src='img/products/notfound.jpg';">
                </div>
                <div class="product-info">
                  <a href="javascript:void(0)" class="product-title">
                    <?php echo $product['product']; ?>
                    <span class="label label-primary pull-right">Cant:
                      <?php echo $product['SUM(quantity)']; ?></span></a>
                  <span class="product-description">
                    <?php echo $product['description']; ?>
                  </span>
                </div>
              </li>
              <!-- /.item -->
              <?php }
              ?>
            </ul>
          </div>
          <!-- /.box-body -->
          <div class="box-footer text-center">
            <a href="listProducts.php" class="uppercase">Ver TODOS los Productos</a>
          </div>
          <!-- /.box-footer -->
        </div>
      </div>
      <!-- /.col -->
    </div>
        
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
  include_once 'templates/footer.php';
?>
<script>
$(document).ready(function () {
  $('#form-DASH').on('submit', function (e) {
    e.preventDefault();
    var datos = $(this).serializeArray();
    $.ajax({
      type: $(this).attr('method'),
      data: datos,
      url: $(this).attr('action'),
      datatype: 'json',
      success: function (data) {
        console.log(data);
        var totalDash = 0;
        $.each(data, function (key, registro) {
          totalDash = parseFloat(registro.totalSale);
        });
        $('#totalVentasDASH').html('Q.'+ totalDash.toFixed(2));
      },
      error: function (data) {
          swal({
              type: 'error',
              title: 'Error',
              text: 'Algo ha salido mal, intentalo más tarde',
          })
      }
    });  
  });
});
//TOTAL DE VENTAS



// Get context with jQuery - using jQuery's .get() method.
var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
// This will get the first returned node in the jQuery collection.
var areaChart = new Chart(areaChartCanvas)

$.getJSON('BLL/dashSalesbyMonths.php', function(data) {
    var months = [];
    var count = [];
    var i = 0;
    for (i = 0; i < data.length; i++) {
        months[i] = [String(data[i].month)];
        count[i] = [String(data[i].ventasT)];
    }

    $.getJSON('BLL/dashSalesPbyMonths.php', function(data2) {
        var count2 = [];
        var i = 0;
        for (i = 0; i < data2.length; i++) {
            count2[i] = [String(data2[i].ventasT)];
        }

        var areaChartData = {
            labels: months,
            datasets: [{
                    label: 'Electronics',
                    fillColor: 'rgba(210, 214, 222, 1)',
                    strokeColor: 'rgba(210, 214, 222, 1)',
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: count
                },
                {
                    label: 'Digital Goods',
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: count2
                }
            ]
        }

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        }

        //Create the line chart
        areaChart.Line(areaChartData, areaChartOptions)
    });
});
</script>