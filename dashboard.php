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
              <h3><?php echo $productos['productos']; ?></h3>

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
              <h3><?php echo $productos['productos']; ?></h3>

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
              <h3><?php echo $productos['productos']; ?></h3>

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
              <h3><?php echo $productos['productos']; ?></h3>

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
              <h3 class="box-title">Reporte anual de ventas</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Ventas: <?php echo date("01/01/Y"); ?>  - <?php echo date("d/m/Y"); ?> </strong>
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
                    $sql = "SELECT COUNT(idSale) AS ventasT, sum(totalSale) as total FROM sale WHERE state = 0 AND YEAR(dateEnd) = YEAR(CURDATE())";
                    $resultado = $conn->query($sql);
                    $ventasT = $resultado->fetch_assoc();
                    ?>
                  <div class="progress-group">
                  <?php
                    $sql = "SELECT COUNT(idSale) AS ventas, sum(totalSale) as total FROM sale WHERE dateEnd >= CURDATE() AND cancel = 0 AND state = 0";
                    $resultado = $conn->query($sql);
                    $ventas = $resultado->fetch_assoc();
                    ?>
                    <span class="progress-text">Ventas activas</span>
                    <span class="progress-number"><b><?php echo $ventas['ventas']; ?></b>/<?php echo $ventasT['ventasT']; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                  <?php
                    $sql = "SELECT COUNT(idSale) AS ventasV, sum(totalSale) as total FROM sale WHERE dateEnd <= CURDATE() AND cancel = 0 AND state = 0 AND YEAR(dateEnd) = YEAR(CURDATE())";
                    $resultado = $conn->query($sql);
                    $ventasV = $resultado->fetch_assoc();
                    ?>
                    <span class="progress-text">Ventas activas vencidas</span>
                    <span class="progress-number"><b><?php echo $ventasV['ventasV']; ?></b>/<?php echo $ventasT['ventasT']; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: 80%"></div>
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
                    <span class="progress-number"><b><?php echo $ventasPT['ventasPT']; ?>/<?php echo $ventasT['ventasT']; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-info" style="width: 80%"></div>
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
                    <span class="progress-number"><b><?php echo $ventasPV['ventasPV']; ?></b>/---  </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
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
                    <span class="description-percentage text-ye"><i class="fa fa-caret-left"></i> <?php echo $ventasT['ventasT']; ?></b></span>
                    <h5 class="description-header">Q<?php echo number_format($ventasT['total'], 2, '.', ','); ?></h5>
                    <span class="description-text">TOTAL VENTAS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?php echo porcentaje($ventasT['ventasT'],$ventas['ventas'],2); ?>%</b></span>
                    <h5 class="description-header">Q<?php echo number_format($ventas['total'], 2, '.', ','); ?></h5>
                    <span class="description-text">TOTAL ACTIVO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?php echo porcentaje($ventasT['ventasT'],$ventasV['ventasV'],2); ?>%</span>
                    <h5 class="description-header">Q<?php echo number_format($ventasV['total'], 2, '.', ','); ?></h5>
                    <span class="description-text">TOTAL ATRASADO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-aqua"><i class="fa fa-caret-up"></i> <?php echo porcentaje($ventasT['ventasT'],$ventasPT['ventasPT'],2); ?>%</span>
                    <h5 class="description-header">Q<?php echo number_format($ventasPT['total'], 2, '.', ','); ?></h5>
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
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php
  include_once 'templates/footer.php';

?>