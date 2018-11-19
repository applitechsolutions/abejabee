<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['venta'] == 'nueva') {
    $fecha_venta = strtr($_POST['dateSale'], '/', '-');
    $fecha_venc = strtr($_POST['dateSaleEnd'], '/', '-');
    $cliente = $_POST['customerS'];
    $vendedor = $_POST['sellerS'];
    $pago = $_POST['payment'];
    $adelanto = $_POST['advance'];
    $total = $_POST['totalS'];
    $remision = $_POST['noRemi'];
    $note = $_POST['note'];
    $fc = date('Y-m-d', strtotime($fecha_venta));
    $fv = date('Y-m-d', strtotime($fecha_venc));

    $MyArray = json_decode($_POST['json']);

    try {
        if ($fecha_venta == "" || $fecha_venc == "" || $cliente == "" || $total == "0" || $vendedor == "" || $remision == "" || $pago == "" || $MyArray == null) {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            /* Switch off auto commit to allow transactions*/
            mysqli_autocommit($conn, false);
            $query_success = true;

            //Insert Sale
            $stmt = $conn->prepare("INSERT INTO sale (_idSeller, _idCustomer, totalSale, advance, dateStart, dateEnd, paymentMethod, noDeliver, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiddsssss", $vendedor, $cliente, $total, $adelanto, $fc, $fv, $pago, $remision, $note);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            $id_registro = $stmt->insert_id;
            mysqli_stmt_close($stmt);

            if ($id_registro > 0) {
                
                $bal = 0;
                $monto = $total - $adelanto;
                //Insert BALANCE
                $stmt = $conn->prepare("INSERT INTO balance(_idSale, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isidd", $id_registro, $fc, $bal, $monto, $monto);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                foreach ($MyArray->detailS as $detail) {
                    //Insert DETAILS
                    $stmt = $conn->prepare("INSERT INTO detailS(_idSale, _idProduct, quantity, priceS, discount) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("iiidd", $id_registro, $detail->idproduct, $detail->cantdet, $detail->precio_det, $detail->descudet);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);

                    //Update STORAGE
                    $sql = 'SELECT idStorage, stock FROM storage WHERE _idProduct = ? AND _idCellar = 1';
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'i', $detail->idproduct);
                    if (!mysqli_stmt_execute($stmt)) {
                    $query_success = FALSE;
                    }
                    mysqli_stmt_bind_result($stmt, $idStorage, $storage);
                    if (!mysqli_stmt_fetch($stmt)) {
                    $query_success = FALSE;
                    }
                    $stock = $storage - $detail->cantdet;
                    mysqli_stmt_close($stmt);

                    if ($idStorage > 0) {
                        $stmt = $conn->prepare("UPDATE storage SET stock = ? WHERE idStorage = ?");
                        $stmt->bind_param("ii", $stock, $idStorage);
                        if (!mysqli_stmt_execute($stmt)) {
                            $query_success = false;
                        }
                        mysqli_stmt_close($stmt);
                    }else {
                        $id_cellar = 1;
                        $stmt = $conn->prepare("INSERT INTO storage (stock, _idProduct, _idCellar) VALUES (?, ?, ?)");
                        $stmt->bind_param("iii", $detail->cantdet, $detail->idproduct, $id_cellar);
                        if (!mysqli_stmt_execute($stmt)) {
                            $query_success = false;
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
                if ($query_success) {
                    mysqli_commit($conn);
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idVenta' => $id_registro,
                        'proceso' => 'nuevo',
                        'remision' => $remision,
                    );
                } else {
                    mysqli_rollback($conn);
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idVenta' => $id_registro,
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idVenta' => $id_registro,
                );
            }
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['venta'] == 'editar') {
    $id_sale = $_POST['id_sale'];
    $fecha_venta = strtr($_POST['dateSale'], '/', '-');
    $fecha_venc = strtr($_POST['dateSaleEnd'], '/', '-');
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
            $stmt = $conn->prepare("UPDATE sale SET  _idSeller = ?, _idCustomer = ?, totalSale = ?, advance = ?, dateStart = ?, dateEnd = ?, paymentMethod = ?, noDeliver = ?, note = ? WHERE idSale = ?");
            $stmt->bind_param("iiddsssssi", $vendedor, $cliente, $total, $adelanto, $fc, $fv, $pago, $remision, $note, $id_sale);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idVenta' => $stmt->insert_id,
                    'proceso' => 'editado',
                    'adelanto' => $adelanto,
                    'total' => $total,
                    'fecha' => $fecha_venta,
                    'remision' => $remision,
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
                'id_eliminado' => $idSale,
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage(),
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
                    'mensaje' => 'Envio generado correctamente!',
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
                    'mensaje' => 'Envio generado correctamente!',
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
                'id_eliminado' => $idSale,
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage(),
        );
    }
    die(json_encode($respuesta));
}
