<?php
include_once '../funciones/bd_conexion.php';

    $id_sale = $_POST['id_sale'];
    $id_product = $_POST['id_producto'];
    $precio_detalle = $_POST['precio_detalle'];
    $cantidad_detalle = $_POST['cantidad_detalle'];
    $descuento_detalle = $_POST['descuento_detalle'];

    try {
        if ($id_sale == "" || $id_product == "") {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO detailS(_idSale, _idProduct, quantity, priceS, discount) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiidd", $id_sale, $id_product, $cantidad_detalle, $precio_detalle, $descuento_detalle);
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