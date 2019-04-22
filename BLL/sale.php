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

            //Si el anticipo es igual al total se marca la venta como pagada.
            $cancel = 0;
            $monto = $total - $adelanto;
            if ($monto == 0) {
                $cancel = 1;
            }

            //Insert Sale
            $stmt = $conn->prepare("INSERT INTO sale (_idSeller, _idCustomer, totalSale, advance, dateStart, dateEnd, paymentMethod, noDeliver, note, cancel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiddsssssi", $vendedor, $cliente, $total, $adelanto, $fc, $fv, $pago, $remision, $note, $cancel);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            $id_registro = $stmt->insert_id;
            mysqli_stmt_close($stmt);

            if ($id_registro > 0) {

                $bal = 0;
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
                        $query_success = false;
                    }
                    mysqli_stmt_bind_result($stmt, $idStorage, $storage);
                    if (!mysqli_stmt_fetch($stmt)) {
                        $query_success = false;
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
                    } else {
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

            //Si el anticipo es igual al total se marca la venta como pagada.
            $cancel = 0;
            $monto = $total - $adelanto;
            if ($monto == 0) {
                $cancel = 1;
            }

            //Update Sale
            $stmt = $conn->prepare("UPDATE sale SET  _idSeller = ?, _idCustomer = ?, totalSale = ?, advance = ?, dateStart = ?, dateEnd = ?, paymentMethod = ?, noDeliver = ?, note = ?, cancel = ? WHERE idSale = ?");
            $stmt->bind_param("iiddsssssii", $vendedor, $cliente, $total, $adelanto, $fc, $fv, $pago, $remision, $note, $cancel, $id_sale);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            mysqli_stmt_close($stmt);

            //Update BALANCE
            $bal = 0;
            $nuevo_balance = $monto;
            $stmt = $conn->prepare("UPDATE balance SET date = ?, amount = ?, balance = ? WHERE _idSale = ? AND balpay = ?");
            $stmt->bind_param("sddii", $fc, $monto, $monto, $id_sale, $bal);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            mysqli_stmt_close($stmt);

            //Selecciona los pagos realizados
            try {
                $sql = "SELECT idBalance, amount, state FROM balance WHERE _idSale = $id_sale AND balpay = 1 AND state !=2 ORDER BY idBalance ASC;";
                $resultado = $conn->query($sql);
            } catch (Exception $e) {
                $query_success = false;
            }
            while ($balance = $resultado->fetch_assoc()) {
                //Update PAY'S
                if ($balance['state'] != 1) {
                    $nuevo_balance = $nuevo_balance - $balance['amount'];
                }

                $stmt = $conn->prepare("UPDATE balance SET balance = ? WHERE idBalance = ?");
                $stmt->bind_param("di", $nuevo_balance, $balance['idBalance']);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);
            }

            //Regresa todo el stock inicial
            try {
                $sql = "SELECT _idProduct, quantity FROM detailS WHERE _idSale = $id_sale;";
                $resultado = $conn->query($sql);
            } catch (Exception $e) {
                $query_success = false;
            }
            while ($det = $resultado->fetch_assoc()) {
                //Update STORAGE
                $sql = 'SELECT idStorage, stock FROM storage WHERE _idProduct = ? AND _idCellar = 1';
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'i', $det['_idProduct']);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_bind_result($stmt, $idStorage, $storage);
                if (!mysqli_stmt_fetch($stmt)) {
                    $idStorage = 0;
                }
                $stock = $storage + $det['quantity'];
                mysqli_stmt_close($stmt);

                if ($idStorage > 0) {
                    $stmt = $conn->prepare("UPDATE storage SET stock = ? WHERE idStorage = ?");
                    $stmt->bind_param("ii", $stock, $idStorage);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $id_cellar = 1;
                    $stmt = $conn->prepare("INSERT INTO storage (stock, _idProduct, _idCellar) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $det['quantity'], $det['_idProduct'], $id_cellar);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);
                }
            }

            //Elimina el detailS inicial
            $stmt = $conn->prepare("DELETE FROM detailS WHERE _idSale = ?");
            $stmt->bind_param("i", $id_sale);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            mysqli_stmt_close($stmt);

            foreach ($MyArray->detailS as $detail) {
                //Insert DETAILS
                $stmt = $conn->prepare("INSERT INTO detailS(_idSale, _idProduct, quantity, priceS, discount) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("iiidd", $id_sale, $detail->idproduct, $detail->cantdet, $detail->precio_det, $detail->descudet);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                //Update STORAGE
                $sql = 'SELECT idStorage, stock FROM storage WHERE _idProduct = ? AND _idCellar = 1';
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'i', $detail->idproduct);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_bind_result($stmt, $idStorage, $storage);
                if (!mysqli_stmt_fetch($stmt)) {
                    $query_success = false;
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
                } else {
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
                    'idVenta' => $id_sale,
                    'proceso' => 'editado',
                    'remision' => $remision,
                );
            } else {
                mysqli_rollback($conn);
                $respuesta = array(
                    'respuesta' => 'error',
                    'idVenta' => $id_sale,
                );
            }
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

if ($_POST['venta'] == 'editarComision') {

    $schlenker = $_POST['schlenker'];
    $otros = $_POST['otros'];
    $idSale = $_POST['idSale'];

    try {
        if ($idSale == "" || $schlenker == "" || $otros == "") {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE sale set commissionS = ?, commissionO = ? WHERE idSale = ?");
            $stmt->bind_param("iii", $schlenker, $otros, $idSale);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idSale' => $id_registro,
                    'mensaje' => 'Comisiones modificadas correctamente!',
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