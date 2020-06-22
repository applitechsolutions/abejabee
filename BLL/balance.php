<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['tipo'] == 'pago') {
    $id_sale = $_POST['idSale'];
    $noDocument = $_POST['noDocument'];
    $dateB = strtr($_POST['dateB'], '/', '-');
    $amount = $_POST['amount'];
    $noReceipt = $_POST['noReceipt'];
    $totalB = $_POST['totalB'];
    $comiS = $_POST['comiS'];
    $comiD = $_POST['comiD'];
    $schlenkerP = $_POST['schlenkerP'];
    $distribucionP = $_POST['distribucionP'];
    $vendedor = $_POST['sellerS'];
    $bal = 1;
    $new_totalB = $totalB - $amount;
    $totalS = ($amount * ($schlenkerP / 100)) * ($comiS / 100);
    $totalD = ($amount * ($distribucionP / 100)) * ($comiD / 100);
    $fc = date('Y-m-d', strtotime($dateB));

    try {
        if ($id_sale == '' || $amount == '' || $dateB == '' || $new_totalB < 0 || $comiS == '' || $comiD == '' || $vendedor == "") {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $cheque = 0;
            if (isset($_POST['cheque'])) {
                $cheque = 1;
                $stmt = $conn->prepare("INSERT INTO balance(_idSale, noDocument, date, balpay, amount, noReceipt, balance, cheque, state, commissionS, totalS, commissionO, totalO, _idSeller) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("issidsdiiididi", $id_sale, $noDocument, $fc, $bal, $amount, $noReceipt, $totalB, $cheque, $cheque, $comiS, $totalS, $comiD, $totalD, $vendedor);
                $stmt->execute();
                $id_registro = $stmt->insert_id;
                if ($id_registro > 0) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idBalance' => $id_registro,
                        'proceso' => 'nuevo',
                        'mensaje' => 'Pago ingresado con correctamente!',
                        'idSale' => $id_sale,
                        'new_totalB' => $new_totalB,
                        'cheque' => $cheque,
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idVenta' => $id_registro,
                    );
                }
                $stmt->close();
                $conn->close();
            } else {
                $stmt = $conn->prepare("INSERT INTO balance(_idSale, noDocument, date, balpay, amount, noReceipt, balance, commissionS, totalS, commissionO, totalO, _idSeller) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("issidsdididi", $id_sale, $noDocument, $fc, $bal, $amount, $noReceipt, $new_totalB, $comiS, $totalS, $comiD, $totalD, $vendedor);
                $stmt->execute();
                $id_registro = $stmt->insert_id;
                if ($id_registro > 0) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idBalance' => $id_registro,
                        'proceso' => 'nuevo',
                        'mensaje' => 'Pago ingresado con correctamente!',
                        'idSale' => $id_sale,
                        'new_totalB' => $new_totalB,
                        'cheque' => $cheque,
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
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }

    die(json_encode($respuesta));
}

if ($_POST['tipo'] == 'anular') {
    $id_sale = $_POST['idSale'];
    $idBalance = $_POST['idBalance'];

    try {
        /* Switch off auto commit to allow transactions*/
        mysqli_autocommit($conn, false);
        $query_success = true;

        //Update BALANCE
        $state = 2;
        $stmt = $conn->prepare("UPDATE balance SET state = ? WHERE idBalance = ?");
        $stmt->bind_param("ii", $state, $idBalance);
        if (!mysqli_stmt_execute($stmt)) {
            $query_success = false;
        }
        mysqli_stmt_close($stmt);

        //Selecciona los pagos realizados
        try {
            $sql = "SELECT idBalance, amount, state FROM balance WHERE _idSale = $id_sale AND state != 2 ORDER BY idBalance ASC;";
            $resultado = $conn->query($sql);
        } catch (Exception $e) {
            $query_success = false;
        }
        $bandera = 0;
        while ($balance = $resultado->fetch_assoc()) {
            //Update PAY'S
            if ($bandera == 0) {
                $nuevo_balance = $balance['amount'];
                $bandera = 1;
            } else {
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
        }

        if ($nuevo_balance > 0) {
            $stmt = $conn->prepare('UPDATE sale SET cancel = 0 WHERE idSale = ?');
            $stmt->bind_param("i", $id_sale);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            mysqli_stmt_close($stmt);
        }

        if ($query_success) {
            mysqli_commit($conn);
            $respuesta = array(
                'respuesta' => 'exito',
                'idBalance' => $idBalance,
                'activa' => 'true',
            );
        } else {
            mysqli_rollback($conn);
            $respuesta = array(
                'respuesta' => 'error',
                'idBalance' => $idBalance,
            );
        }
        $conn->close();
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['tipo'] == 'confirmar') {
    $id_sale = $_POST['idSale'];
    $idBalance = $_POST['idBalance'];

    try {
        /* Switch off auto commit to allow transactions*/
        mysqli_autocommit($conn, false);
        $query_success = true;

        //Update BALANCE

        $state = 0;
        $stmt = $conn->prepare("UPDATE balance SET date = CURDATE(), state = ? WHERE idBalance = ?");
        $stmt->bind_param("ii", $state, $idBalance);
        if (!mysqli_stmt_execute($stmt)) {
            $query_success = false;
        }
        mysqli_stmt_close($stmt);

        //Selecciona los pagos realizados
        try {
            $sql = "SELECT idBalance, amount, state FROM balance WHERE _idSale = $id_sale AND state != 2 ORDER BY idBalance ASC;";
            $resultado = $conn->query($sql);
        } catch (Exception $e) {
            $query_success = false;
        }
        $bandera = 0;
        while ($balance = $resultado->fetch_assoc()) {
            //Update PAY'S
            if ($bandera == 0) {
                $nuevo_balance = $balance['amount'];
                $bandera = 1;
            } else {
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
        }

        if ($query_success) {
            mysqli_commit($conn);
            $respuesta = array(
                'respuesta' => 'exito',
                'idBalance' => $idBalance,
            );
        } else {
            mysqli_rollback($conn);
            $respuesta = array(
                'respuesta' => 'error',
                'idBalance' => $idBalance,
            );
        }
        $conn->close();
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}