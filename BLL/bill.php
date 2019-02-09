<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['factura'] == 'nueva') {

    $idSale = $_POST['id_sale'];
    $serie = $_POST['serieS'];
    $noBill = $_POST['noBillS'];
    $codeSeller = $_POST['sellerCode'];
    $codeCustomer = $_POST['customerCode'];
    $town = $_POST['municipio'];
    $mobile = $_POST['customerTel'];
    $dateEnd = strtr($_POST['dateSaleEnd'], '/', '-');
    $custName = $_POST['customerName'];
    $custNit = $_POST['customerNit'];
    $address = $_POST['customerAddress'];
    $total = $_POST['totalS'];

    $fv = date('Y-m-d', strtotime($dateEnd));

    $MyArray = json_decode($_POST['json']);

    try {
        if ($serie == "" || $noBill == "" || $total == "0" || $MyArray == null) {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            /* Switch off auto commit to allow transactions*/
            mysqli_autocommit($conn, false);
            $query_success = true;

            //Insert Bill
            $stmt = $conn->prepare("INSERT INTO bill (_idSale, serie, noBill, codeSeller, codeCustomer, town, mobile, dateEnd, custName, custNit, address, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssssssssd", $idSale, $serie, $noBill, $codeSeller, $codeCustomer, $town, $mobile, $fv, $custName, $custNit, $address, $total);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            $id_registro = $stmt->insert_id;
            mysqli_stmt_close($stmt);

            if ($id_registro > 0) {

                foreach ($MyArray->detailS as $detail) {
                    //Insert DETAILS
                    $stmt = $conn->prepare("INSERT INTO detailB(_idBill, _idProduct, quantity, priceB, discount) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("iiidd", $id_registro, $detail->idproduct, $detail->cantdet, $detail->precio_det, $detail->descudet);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);
                }

                $stmt = $conn->prepare("UPDATE correlative set serie = ?, last = ? WHERE idCorrelative = 1");
                $stmt->bind_param("si", $serie, $noBill);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                if ($query_success) {
                    mysqli_commit($conn);
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idBill' => $id_registro,
                        'proceso' => 'nuevo',
                    );
                } else {
                    mysqli_rollback($conn);
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idBill' => $id_registro,
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idBill' => $id_registro,
                );
            }
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['factura'] == 'editar') {

    $idBill = $_POST['id_bill'];
    $serie = $_POST['serie'];
    $noBill = $_POST['noBill'];
    $codeSeller = $_POST['sellerCode'];
    $codeCustomer = $_POST['customerCode'];
    $town = $_POST['municipio'];
    $mobile = $_POST['customerTel'];
    $dateEnd = strtr($_POST['dateSaleEnd'], '/', '-');
    $custName = $_POST['customerName'];
    $custNit = $_POST['customerNit'];
    $address = $_POST['customerAddress'];
    $total = $_POST['totalS'];

    $fv = date('Y-m-d', strtotime($dateEnd));

    $MyArray = json_decode($_POST['json']);

    try {
        if ($serie == "" || $noBill == "" || $total == "0" || $MyArray == null) {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            /* Switch off auto commit to allow transactions*/
            mysqli_autocommit($conn, false);
            $query_success = true;

            //Insert Bill
            $stmt = $conn->prepare("UPDATE bill SET serie = ?, noBill = ?, codeSeller = ?, codeCustomer = ?, town = ?, mobile = ?, dateEnd = ?, custName = ?, custNit = ?, address = ?, total = ? WHERE idBill = ?");
            $stmt->bind_param("ssssssssssdi", $serie, $noBill, $codeSeller, $codeCustomer, $town, $mobile, $fv, $custName, $custNit, $address, $total, $idBill);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            mysqli_stmt_close($stmt);

            if ($query_success) {

                //Elimina el detailB inicial
                $stmt = $conn->prepare("DELETE FROM detailB WHERE _idBill = ?");
                $stmt->bind_param("i", $idBill);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                foreach ($MyArray->detailS as $detail) {
                    //Insert DETAILS
                    $stmt = $conn->prepare("INSERT INTO detailB(_idBill, _idProduct, quantity, priceB, discount) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("iiidd", $idBill, $detail->idproduct, $detail->cantdet, $detail->precio_det, $detail->descudet);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);
                }

                if ($query_success) {
                    mysqli_commit($conn);
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idBill' => $idBill,
                        'proceso' => 'editado',
                    );
                } else {
                    mysqli_rollback($conn);
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idBill' => $idBill,
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idBill' => $idBill,
                );
            }
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}