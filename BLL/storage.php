<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['storage'] == 'editar') {

    $id = $_POST['id'];
    $fecha_vencimiento = strtr($_POST['dateV'], '/', '-');
    $fv = date('Y-m-d', strtotime($fecha_vencimiento));

    try {
        $stmt = $conn->prepare('UPDATE storage SET dateExp = ? WHERE idStorage = ?');
        $stmt->bind_param("si", $fv, $id);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $stmt->insert_id,
                'proceso' => 'editado'
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }

    die(json_encode($respuesta));
}
