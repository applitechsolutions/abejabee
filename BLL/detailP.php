<?php
include_once '../funciones/bd_conexion.php';

    $id_purchase = $_POST['id_purchase'];
    $id_product = $_POST['id_producto'];
    $costo_detalle = $_POST['costo_detalle'];
    $cantidad_detalle = $_POST['cantidad_detalle'];

    try {
        if ($id_purchase == "" || $id_product == "") {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO detailP (_idPurchase, _idProduct, quantity, costP) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $id_purchase, $id_product, $cantidad_detalle, $costo_detalle);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idProducto' => $id_product,
                    'cantidad' => $cantidad_detalle
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        }
    } catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
?>