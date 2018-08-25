<?php
include_once 'funciones/sesiones.php';
include_once 'templates/header.php';
include_once 'templates/navBar.php';
include_once 'templates/sideBar.php';
include_once 'funciones/bd_conexion.php';
?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
        <div class="row">
            <div class="col-xs-4">
                <table style="width:100%">
                    <tr>
                        <th>Lugar:</th>
                        <td>Ejemplo</td>
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td>Ejemplo</td>
                    </tr>
                    <tr>
                        <th>Nit:</th>
                        <td>Ejemplo</td>
                    </tr>
                    <tr>
                        <th rowspan="4" style="text-align:left;margin-top:-30px">Direccion:</th>
                        <td>Ejemplo</td>
                    </tr>
                    <tr>
                        <td>Ejemplo</td>
                    </tr>
                    <tr>
                        <td>Ejemplo</td>
                    </tr>
                    <tr>
                        <td>Ejemplo</td>
                    </tr>
                    <tr>
                        <th rowspan="2">Telefono:</th>
                        <td>Ejemplo</td>
                    </tr>
                    <tr>
                        <td>""</td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-2">
                <table style="width:100%">
                    <tr>
                        <th>Cod Vendedor:</th>
                        <td>Ejemplo</td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-2">
                <table style="width:100%">
                    <tr>
                        <th>Cod Cliente:</th>
                        <td>Ejemplo</td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-3">
                <table style="width:100%">
                    <tr>
                        <th>Fecha de Vencimiento:</th>
                        <td>Ejemplo</td>
                    </tr>
                </table>
            </div>
            <!-- /.col -->
        </div>

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive tabla">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Product</th>
              <th>Serial #</th>
              <th>Description</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1</td>
              <td>Call of Duty</td>
              <td>455-981-221</td>
              <td>El snort testosterone trophy driving gloves handsome</td>
              <td>$64.50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Need for Speed IV</td>
              <td>247-925-726</td>
              <td>Wes Anderson umami biodiesel</td>
              <td>$50.00</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Monsters DVD</td>
              <td>735-845-642</td>
              <td>Terry Richardson helvetica tousled street art master</td>
              <td>$10.70</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Grown Ups Blue Ray</td>
              <td>422-568-642</td>
              <td>Tousled lomo letterpress</td>
              <td>$25.99</td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>

<?php
include_once 'templates/footer.php';
?>