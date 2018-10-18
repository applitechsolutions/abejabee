<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['venta'] == 'nueva') {
    $fecha_venta = $_POST['dateSale'];
    $fecha_venc = $_POST['dateSaleEnd'];
    $cliente = $_POST['customerS'];
    $vendedor = $_POST['sellerS'];
    $pago = $_POST['payment'];
    $adelanto = $_POST['advance'];
    $total = $_POST['totalS'];
    $remision = $_POST['noRemi'];
    $note = $_POST['note'];
    $fc = date('Y-m-d', strtotime($fecha_venta));
    $fv = date('Y-m-d', strtotime($fecha_venc));

    try {
        if ($fecha_venta == "" || $fecha_venc == "" || $cliente == "" || $total == "0" || $vendedor == "" || $remision == "" || $pago == "") {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO sale (_idSeller, _idCustomer, totalSale, advance, dateStart, dateEnd, paymentMethod, noDeliver, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiddsssss", $vendedor, $cliente, $total, $adelanto, $fc, $fv, $pago, $remision, $note);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idVenta' => $id_registro,
                    'proceso' => 'nuevo',
                    'adelanto' => $adelanto,
                    'total' => $total,
                    'fecha' => $fecha_venta,
                    'remision' => $remision
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
    $idSale = $_POST['idSale'];

    if ($_POST['noDeliver'] != "") {
        $noShipment = $_POST['noDeliver'];
    }

    try {
        if ($idSale == "") {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE sale set transport = ?, noShipment = ? WHERE idSale = ?");
            $stmt->bind_param("ssi", $transport, $noShipment, $idSale);
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

if ($_POST['venta'] == 'editarCorrelativo') {
    $serie = $_POST['serie'];
    $last = $_POST['last'];
    $idSale = $_POST['idSale'];

    try {
        if ($idSale == "") {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE sale set noBill = ?, serie = ? WHERE idSale = ?");
            $stmt->bind_param("ssi", $last, $serie, $idSale);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idSale' => $id_registro,
                    'mensaje' => 'Envio generado correctamente!'
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

if ($_POST['venta'] == 'editarShipment') {
    $last = $_POST['last'];
    $idSale = $_POST['idSale'];

    try {
        if ($idSale == "") {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE sale set noShipment = ?  WHERE idSale = ?");
            $stmt->bind_param("si", $last, $idSale);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idSale' => $id_registro,
                    'mensaje' => 'Envio generado correctamente!'
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

if ($_POST['venta'] == 'anular') {
    $idSale = $_POST['idSale'];

    try {
        $stmt = $conn->prepare('UPDATE sale SET state = 1 WHERE idSale = ?');
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