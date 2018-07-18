<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['ruta'] == 'nueva') {

    $code = $_POST['codeR'];
    $name = $_POST['nameR'];
    $details = $_POST['detailsR'];
    $Start = $_POST['dateStart'];
    $End = $_POST['dateEnd'];
    $idSeller = $_POST['sellerR'];

    $dateStart = date('Y-m-d', strtotime($Start));
    $dateEnd = date('Y-m-d', strtotime($End));
    // die(json_encode($fecha_formateada));

    try {
        if ($code == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO route (codeRoute, routeName, details, dateStart, dateEnd, _idSeller) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $code, $name, $details, $dateStart, $dateEnd, $idSeller);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $id_registro,
                    'mensaje' => 'Ruta creada correctamente!',
                    'proceso' => 'nuevo',
                );

            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idRoute' => $id_registro,
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

if ($_POST['ruta'] == 'editar') {

    $idRoute = $_POST['id_ruta'];
    $code = $_POST['codeR'];
    $name = $_POST['nameR'];
    $details = $_POST['detailsR'];
    $Start = $_POST['dateStart'];
    $End = $_POST['dateEnd'];
    $idSeller = $_POST['sellerR'];

    $dateStart = date('Y-m-d', strtotime($Start));
    $dateEnd = date('Y-m-d', strtotime($End));

    try {
        if ($code == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE route SET codeRoute = ?, routeName = ?, details = ?, dateStart = ?,dateEnd = ?, _idSeller = ? WHERE idRoute = ?");
            $stmt->bind_param("sssssii", $code, $name, $details, $dateStart, $dateEnd, $idSeller, $idRoute);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $stmt->insert_id,
                    'mensaje' => 'Ruta Editada correctamente!',
                    'proceso' => 'editado',
                );

            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idRoute' => $id_registro,
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

if ($_POST['ruta'] == 'eliminar') {
    $id_eliminar = $_POST['id'];
    
    try {
        $stmt = $conn->prepare('UPDATE route SET state = 1 WHERE idRoute = ?');
        $stmt->bind_param("i", $id_eliminar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_eliminar
            );
        }else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}
