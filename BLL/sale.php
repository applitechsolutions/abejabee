<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['venta'] == 'nueva') {
    $fecha_venta = $_POST['dateSale'];
    $fecha_venc = $_POST['dateSaleEnd'];
    $cliente = $_POST['customerS'];
    $vendedor = $_POST['sellerS'];
    $facturaV = $_POST['noBillS'];
    $serieV = $_POST['serieS'];
    $pago = $_POST['payment'];
    $adelanto = $_POST['advance'];
    $total = $_POST['totalS'];
    $factura = "si";

    $fc = date('Y-m-d', strtotime($fecha_venta));
    $fv = date('Y-m-d', strtotime($fecha_venc));

    if ($total < 700.00) {
        $facturaV = $_POST['noRemi'];
        $serieV = "GUIA/REMISION";
        $factura = "no";
    }

    try {
        if ($fecha_venta == "" || $fecha_venc == "" || $cliente == "" || $total == "0" || $vendedor == "" || $facturaV == "" || $serieV == "" || $pago == "") {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO sale(_idSeller, _idCustomer, noBill, serie, totalSale, advance, dateStart, dateEnd, paymentMethod) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissddsss", $vendedor, $cliente, $facturaV, $serieV, $total, $adelanto, $fc, $fv, $pago);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idVenta' => $id_registro,
                    'proceso' => 'nuevo',
                    'factura' => $factura,
                    'adelanto' => $adelanto,
                    'total' => $total,
                    'fecha' => $fecha_venta,
                    'serie' => $serieV,
                    'nofactura' => $facturaV,
                );

            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idVenta' => $id_registro,
                );
            }
            $stmt->close();
            $conn->close();
        }

    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }

    die(json_encode($respuesta));
}

if ($_POST['venta'] == 'envio') {

    $transport = $_POST['transport'];
    $noShipment = $_POST['noShipment'];
    $noDeliver = $_POST['noDeliver'];
    $idSale = $_POST['idSale'];

    try {
        if ($idSale == "") {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE sale set transport = ?, noShipment = ?, noDeliver = ? WHERE idSale = ?");
            $stmt->bind_param("sssi", $transport, $noShipment, $noDeliver, $idSale);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idSale' => $id_registro,
                    'mensaje' => 'Envio generado correctamente!',
                    'idSale' => $idSale,
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idSale' => $id_registro,
                );
            }
            $stmt->close();
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['venta'] == 'cancel') {
    $idSale = $_POST['idSale'];

    try {
        $stmt = $conn->prepare('UPDATE sale SET cancel = 1 WHERE idSale = ?');
        $stmt->bind_param("i", $idSale);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $idSale
            );
        }else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}

?>