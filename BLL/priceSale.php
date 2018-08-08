<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['priceSale'] == 'nuevo') {

    $id_Product = $_POST['id_product'];
    $id_price = $_POST['id_price'];
    $price = $_POST['price'];

    try {
        $stmt = $conn->prepare("INSERT INTO priceSale (price, _idProduct, _idPrice) VALUES (?, ?, ?)");
        $stmt->bind_param("dii", $price, $id_Product, $id_price);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        if ($id_registro > 0) {
            $respuesta = array(
                'respuesta' => 'exito'            
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

?>
