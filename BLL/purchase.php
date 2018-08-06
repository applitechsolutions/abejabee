<?php
include_once '../funciones/bd_conexion.php';
if ($_POST['compra'] == 'nueva') {
    $fecha_compra = $_POST['date'];
    $proveedor = $_POST['provider'];
    $factura = $_POST['noBill'];
    $serie = $_POST['serie'];
    $documento = $_POST['noDocument'];
    $total = $_POST['total'];

    $fc = date('Y-m-d', strtotime($fecha_compra));

    try {
        if ($fecha_compra == "" || $proveedor == "" || $total == "0") {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO purchase (datePurchase, _idProvider, noBill, serie, noDocument, totalPurchase) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sisssd", $fc, $proveedor, $factura, $serie, $documento, $total);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idCompra' => $id_registro,
                    'proceso' => 'nuevo'
                );
                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idCompra' => $id_registro
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