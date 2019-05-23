<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['compra'] == 'nueva') {
    $fecha_compra = strtr($_POST['date'], '/', '-');
    $proveedor = $_POST['provider'];
    $factura = $_POST['noBill'];
    $serie = $_POST['serie'];
    $documento = $_POST['noDocument'];
    $total = $_POST['total'];
    $fc = date('Y-m-d', strtotime($fecha_compra));

    $MyArray = json_decode($_POST['json']);

    try {
        if ($fecha_compra == "" || $proveedor == "" || $total == "0" || $MyArray == null) {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        } else {
            /* Switch off auto commit to allow transactions*/
            mysqli_autocommit($conn, false);
            $query_success = true;

            //Insert Purchase
            $stmt = $conn->prepare("INSERT INTO purchase (datePurchase, _idProvider, noBill, serie, noDocument, totalPurchase) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sisssd", $fc, $proveedor, $factura, $serie, $documento, $total);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            $id_registro = $stmt->insert_id;
            mysqli_stmt_close($stmt);

            if ($id_registro > 0) {

                foreach ($MyArray->detailP as $detail) {
                    //Insert DETAILS
                    $stmt = $conn->prepare("INSERT INTO detailP (_idPurchase, _idProduct, quantity, costP) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("iiid", $id_registro, $detail->idproduct, $detail->cantdet, $detail->costodet);
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
                        $idStorage = 0;
                    }
                    $stock = $storage + $detail->cantdet;
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
                        'idCompra' => $id_registro
                    );
                } else {
                    mysqli_rollback($conn);
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idCompra' => $id_registro
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idCompra' => $id_registro
                );
            }
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}