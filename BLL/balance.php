<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['tipo'] == 'saldo') {
    $id_sale = $_POST['id_sale'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha']; 
    $bal = 0;  

    $fc = date('Y-m-d', strtotime($fecha));

    try {
        if ($id_sale == "" || $monto == "" || $fecha == "") {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO balance(_idSale, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isidd", $id_sale, $fc, $bal, $monto, $monto);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idBalance' => $id_registro,
                    'proceso' => 'nuevo',
                    'idVenta'=> $id_sale,
                );
                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idVenta' => $id_registro
                );
            }
            $stmt->close();
            $conn->close();
        }

    } catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }

    die(json_encode($respuesta));
}

if ($_POST['tipo'] == 'pago') {
    $id_sale = $_POST['idSale'];
    $noDocument = $_POST['noDocument'];
    $dateB = $_POST['dateB']; 
    $amount = $_POST['amount'];
    $noReceipt = $_POST['noReceipt'];
    $totalB = $_POST['totalB'];
    $bal = 1;  
    $new_totalB = number_format($totalB, 2) - number_format($amount, 2);
    $fc = date('Y-m-d', strtotime($dateB));
    
    try {
        if ($id_sale == "" || $amount == "" || $dateB == "" || $new_totalB < 0) {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO balance(_idSale, noDocument, date, balpay, amount, noReceipt, balance) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issidsd", $id_sale, $noDocument, $fc, $bal, $amount, $noReceipt, $new_totalB);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idBalance' => $id_registro,
                    'proceso' => 'nuevo',
                    'mensaje' => 'Pago ingresado con correctamente!',
                    'idSale'=> $id_sale,
                    'new_totalB' => $new_totalB
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idVenta' => $id_registro
                );
            }
            $stmt->close();
            $conn->close();
        }

    } catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }

    die(json_encode($respuesta));
}
?>