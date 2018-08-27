<?php
include_once '../funciones/bd_conexion.php';

    $id_cellar = 1;
    $id_product = $_POST['id_product'];
    $cantidad = $_POST['cantidad'];
    $tipo = $_POST['tipo'];

    $sql = "SELECT * FROM storage WHERE _idProduct = $id_product AND _idCellar = 1";
    $resultado = $conn->query($sql);
    $rows = mysqli_num_rows($resultado);
    while ($storage = $resultado->fetch_assoc()) {
        if ($tipo == 'compra') {
            $stock = $storage['stock'] + $cantidad;
        }elseif ($tipo == 'venta') {
            $stock = $storage['stock'] - $cantidad;
        }        
        $id_storage = $storage['idStorage'];
    }

    try {
        if ($id_product == "") {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        } else {
            if ($rows > 0) {
                $stmt = $conn->prepare("UPDATE storage SET stock = ? WHERE idStorage = ?");
                $stmt->bind_param("ii", $stock, $id_storage);
                $stmt->execute();
                if ($stmt->affected_rows) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'mensaje' => 'Compra realizada correctamente!'
                    );                
                }else {
                    $respuesta = array(
                        'respuesta' => 'error'
                    );
                }
                $stmt->close();
                $conn->close();
            }else {
                $stmt = $conn->prepare("INSERT INTO storage (stock, _idProduct, _idCellar) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $cantidad, $id_product, $id_cellar);
                $stmt->execute();
                $id_registro = $stmt->insert_id;
                if ($id_registro > 0) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'mensaje' => 'Compra realizada correctamente!'
                    );                
                }else {
                    $respuesta = array(
                        'respuesta' => 'error'
                    );
                }
                $stmt->close();
                $conn->close();
            }
        }
    } catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
?>