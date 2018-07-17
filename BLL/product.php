<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['producto'] == 'nuevo') {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $cost = $_POST['cost'];
    $description = $_POST['description'];
    $make = $_POST['make'];
    $category = $_POST['category'];
    $unity = $_POST['unity'];
    
    $respuesta = array(
        'post' => $_POST,
        'file' => $_FILES
    );

    //die(json_encode($respuesta));
    $directorio = "../img/products/";

    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }
    if (move_uploaded_file($_FILES['file']['tmp_name'], $directorio . $_FILES['file']['name'])) {
        $picture_url = $_FILES['file']['name'];
    } else {
        $respuesta = array(
            'respuesta' => error_get_last(),
        );
    }

    try {
        if ($name == '' || $code == '' || $cost == '' || $make == '' || $category == '' || $unity == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO product (productName, productCode, cost, description, picture, _idUnity, _idCategory, _idMake) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssiii", $name, $code, $cost, $description, $picture_url, $unity, $category, $make);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idProduct' => $id_registro,
                    'mensaje' => 'Producto creado correctamente!',
                    'proceso' => 'nuevo',
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idProduct' => $id_registro,
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

if ($_POST['producto'] == 'actualizar') {
    $id_product = $_POST['id_producto'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $cost = $_POST['cost'];
    $description = $_POST['description'];
    $make = $_POST['make'];
    $category = $_POST['category'];
    $unity = $_POST['unity'];
    // $respuesta = array(
    //     'post' => $_POST,
    //     'file' => $_FILES
    // );

    // die(json_encode($respuesta));
    $directorio = "../img/products/";

    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }
    if (move_uploaded_file($_FILES['file']['tmp_name'], $directorio . $_FILES['file']['name'])) {
        $picture_url = $_FILES['file']['name'];
    } else {
        $respuesta = array(
            'respuesta' => error_get_last(),
        );
    }

    try {
        if ($_FILES['file']['size'] > 0) {
            //con imagen
            $stmt = $conn->prepare("UPDATE product SET productName = ?, productCode = ?, cost = ?, description = ?, picture = ?, _idUnity = ?, _idCategory = ?, _idMake = ? WHERE idProduct = ?");
            $stmt->bind_param("ssdssiiii", $name, $code, $cost, $description, $picture_url, $unity, $category, $make, $id_product);
        } else {
            //sin imagen
            $stmt = $conn->prepare("UPDATE product SET productName = ?, productCode = ?, cost = ?, description = ?, _idUnity = ?, _idCategory = ?, _idMake = ? WHERE idProduct = ?");
            $stmt->bind_param("ssdsiiii", $name, $code, $cost, $description, $unity, $category, $make, $id_product);
        }
        $estado = $stmt->execute();

        if ($estado ==  true) {
            $respuesta = array(
                'respuesta' => 'exito',
                'idProduct' => $id_product,
                'mensaje' => 'Producto actualizado correctamente!',
                'proceso' => 'editado',
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'idProduct' => $id_product,
            );
        }
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}
