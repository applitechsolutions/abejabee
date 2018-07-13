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
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}
?>
