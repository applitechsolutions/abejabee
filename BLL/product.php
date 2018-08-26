<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['producto'] == 'nuevo') {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $make = $_POST['make'];
    $category = $_POST['category'];
    $unity = $_POST['unity'];
    $cost = $_POST['cost'];
    $minStock = $_POST['minStock'];
    $description = $_POST['description'];
    $public = $_POST['public'];
    $pharma = $_POST['pharma'];
    $business = $_POST['business'];
    $bonus = $_POST['bonus'];

    $respuesta = array(
        'post' => $_POST,
        'file' => $_FILES,
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
        if ($name == "" || $code == '' || $cost == '' || $make == '' || $category == '' || $unity == '' || $minStock == '' || $public == '' || $pharma == '' || $business == '' || $bonus == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO product (productName, productCode, cost, description, picture, minStock, _idUnity, _idCategory, _idMake) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssiiii", $name, $code, $cost, $description, $picture_url, $minStock, $unity, $category, $make);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idProduct' => $id_registro,
                    'public' => $public,
                    'pharma' => $pharma,
                    'business' => $business,
                    'bonus' => $bonus,
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
    $minStock = $_POST['minStock'];
    $description = $_POST['description'];
    $make = $_POST['make'];
    $category = $_POST['category'];
    $unity = $_POST['unity'];
    $public = $_POST['public'];
    $pharma = $_POST['pharma'];
    $business = $_POST['business'];
    $bonus = $_POST['bonus'];
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
        if ($name == "" || $code == '' || $cost == '' || $make == '' || $category == '' || $unity == '' || $minStock == '' || $public == '' || $pharma == '' || $business == '' || $bonus == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            if ($_FILES['file']['size'] > 0) {
                //con imagen
                $stmt = $conn->prepare("UPDATE product SET productName = ?, productCode = ?, cost = ?, minStock = ?, description = ?, picture = ?, _idUnity = ?, _idCategory = ?, _idMake = ? WHERE idProduct = ?");
                $stmt->bind_param("ssdissiiii", $name, $code, $cost, $minStock, $description, $picture_url, $unity, $category, $make, $id_product);
            } else {
                //sin imagen
                $stmt = $conn->prepare("UPDATE product SET productName = ?, productCode = ?, cost = ?, minStock = ?, description = ?, _idUnity = ?, _idCategory = ?, _idMake = ? WHERE idProduct = ?");
                $stmt->bind_param("ssdisiiii", $name, $code, $cost, $minStock, $description, $unity, $category, $make, $id_product);
            }
            $estado = $stmt->execute();

            if ($estado == true) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idProduct' => $id_product,
                    'public' => $public,
                    'pharma' => $pharma,
                    'business' => $business,
                    'bonus' => $bonus,
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
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['producto'] == 'eliminar') {
    $id_eliminar = $_POST['id'];

    try {
        $stmt = $conn->prepare('UPDATE product SET state = 1 WHERE idProduct = ?');
        $stmt->bind_param("i", $id_eliminar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_eliminar,
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage(),
        );
    }
    die(json_encode($respuesta));
}

if ($_POST['producto'] == 'agregar') {
    header("Content-Type: application/json; charset=UTF-8");
    $id_agregar = $_POST['id'];

    try {
        $result = $conn->query("SELECT idProduct, productName, productCode, cost, picture,
        (select makeName from make where idMake = P._idMake and state = 0) as make,
        (select catName from category where idCategory = P._idCategory and state = 0) as category,
        (select unityName from unity where idUnity = P._idUnity and state = 0) as unity
        FROM product P WHERE idProduct = $id_agregar");
        $outp = array();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

    } catch (Exception $e) {
        $outp = array(
            'respuesta' => $e->getMessage(),
        );
    }
    echo json_encode($outp);
}


if ($_POST['producto'] == 'agregarS') {
    header("Content-Type: application/json; charset=UTF-8");
    $id_agregar = $_POST['id'];

    try {
        $result = $conn->query("SELECT idProduct, productName, productCode, cost, picture,
        (select makeName from make where idMake = P._idMake and state = 0) as make,
        (select catName from category where idCategory = P._idCategory and state = 0) as category,
        (select unityName from unity where idUnity = P._idUnity and state = 0) as unity,
        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 1) as public,
        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 11) as pharma,
        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 21) as business,
        (select price from priceSale where _idProduct = P.idProduct and _idPrice = 31) as bonus
        FROM product P WHERE idProduct = $id_agregar");
        $outp = array();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

    } catch (Exception $e) {
        $outp = array(
            'respuesta' => $e->getMessage(),
        );
    }
    echo json_encode($outp);
}