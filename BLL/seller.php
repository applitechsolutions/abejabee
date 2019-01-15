<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['reg-vendedor'] == 'nuevo') {

    $codigo = $_POST['codigo-vendedor'];
    $nombre = $_POST['nombre-vendedor'];
    $apellido = $_POST['apel-vendedor'];
    $direccion = $_POST['direc-vendedor'];
    $telefono = $_POST['tel-vendedor'];
    $dpi = $_POST['dpi-vendedor'];
    $bday = strtr($_POST['bday-vendedor'], '/', '-');

    $fecha_formateada = date('Y-m-d', strtotime($bday));
    $genero = $_POST['gen-vendedor'];
    // die(json_encode($fecha_formateada));

    $s30 = $_POST['s30'];
    $sd30 = $_POST['s30'];
    $s60 = $_POST['s60'];
    $sd60 = $_POST['s60'];
    $s90 = $_POST['s90'];
    $sd90 = $_POST['s90'];
    $o30 = $_POST['o30'];
    $od30 = $_POST['o30'];
    $o60 = $_POST['o60'];
    $od60 = $_POST['o60'];

    try {
        if ($codigo == '' || $nombre == '' || $apellido == '' || $telefono == '' || $dpi == '' || $genero == '' || $s30 == '' || $s60 == '' || $s90 == '' || $o30 == '' || $o60 == '' || $sd30 == '' || $sd60 == '' || $sd90 == '' || $od30 == '' || $od60 == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            /* Switch off auto commit to allow transactions*/
            mysqli_autocommit($conn, false);
            $query_success = true;

            $stmt = $conn->prepare("INSERT INTO seller (sellerCode, sellerFirstName, sellerLastName, sellerAddress, sellerMobile, DPI, birthDate, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssi", $codigo, $nombre, $apellido, $direccion, $telefono, $dpi, $fecha_formateada, $genero);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            $id_registro = $stmt->insert_id;
            mysqli_stmt_close($stmt);

            if ($id_registro > 0) {
                $stmt = $conn->prepare("INSERT INTO commission(_idSeller, s30, s60, s90, o30, o60, sd30, sd60, sd90, od30, od60) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiiiiiiiiii", $id_registro, $s30, $s60, $s90, $o30, $o60, $sd30, $sd60, $sd90, $od30, $od60);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                if ($query_success) {
                    mysqli_commit($conn);
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idSeller' => $id_registro,
                        'mensaje' => 'Vendedor creado correctamente!',
                        'proceso' => 'nuevo',
                    );
                } else {
                    mysqli_rollback($conn);
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idSeller' => $id_registro,
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idSeller' => $id_registro,
                );
            }
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['reg-vendedor'] == 'actualizar') {

    $id_seller = $_POST['id-reg-vendedor'];
    $codigo = $_POST['codigo-vendedor'];
    $nombre = $_POST['nombre-vendedor'];
    $apellido = $_POST['apel-vendedor'];
    $direccion = $_POST['direc-vendedor'];
    $telefono = $_POST['tel-vendedor'];
    $dpi = $_POST['dpi-vendedor'];
    $bday = strtr($_POST['bday-vendedor'], '/', '-');

    $fecha_formateada = date('Y-m-d', strtotime($bday));
    $genero = $_POST['gen-vendedor'];

    $s30 = $_POST['s30'];
    $sd30 = $_POST['s30'];
    $s60 = $_POST['s60'];
    $sd60 = $_POST['s60'];
    $s90 = $_POST['s90'];
    $sd90 = $_POST['s90'];
    $o30 = $_POST['o30'];
    $od30 = $_POST['o30'];
    $o60 = $_POST['o60'];
    $od60 = $_POST['o60'];

    try {
        if ($codigo == '' || $nombre == '' || $apellido == '' || $telefono == '' || $dpi == '' || $genero == '' || $s30 == '' || $s60 == '' || $s90 == '' || $o30 == '' || $o60 == '' || $sd30 == '' || $sd60 == '' || $sd90 == '' || $od30 == '' || $od60 == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            /* Switch off auto commit to allow transactions*/
            mysqli_autocommit($conn, false);
            $query_success = true;

            $stmt = $conn->prepare("UPDATE seller SET sellerCode = ?, sellerFirstName = ?, sellerLastName = ?, sellerAddress = ?, sellerMobile = ?, DPI = ?, birthDate = ?, gender = ? WHERE idSeller = ?");
            $stmt->bind_param("sssssssii", $codigo, $nombre, $apellido, $direccion, $telefono, $dpi, $fecha_formateada, $genero, $id_seller);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            mysqli_stmt_close($stmt);

            if ($query_success) {
                $stmt = $conn->prepare("UPDATE commission SET s30 = ?, s60 = ?, s90 = ?, o30 = ?, o60 = ?, sd30 = ?, sd60 = ?, sd90 = ?, od30 = ?, od60 = ? WHERE _idSeller = ?");
                $stmt->bind_param("iiiiiiiiiii", $s30, $s60, $s90, $o30, $o60, $sd30, $sd60, $sd90, $od30, $od60, $id_seller);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);
                if ($query_success) {
                    mysqli_commit($conn);
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'id_actualizado' => $id_seller,
                        'mensaje' => 'Vendedor actualizado correctamente!',
                        'proceso' => 'editado',
                    );
                } else {
                    mysqli_rollback($conn);
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idSeller' => $id_registro,
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idSeller' => $id_registro,
                );
            }
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['reg-vendedor'] == 'eliminar') {
    $id_eliminar = $_POST['id'];

    try {
        $stmt = $conn->prepare('UPDATE seller SET state = 1 WHERE idSeller = ?');
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