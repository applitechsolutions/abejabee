<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['correlative'] == 'factura') {

    $serie = $_POST['serieC'];
    $ultimo = $_POST['last'];
    
    try{
        if ($serie == '' || $ultimo == '' ) {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("UPDATE correlative set serie = ?, last = ? WHERE idCorrelative = 1");
            $stmt->bind_param("si", $serie, $ultimo);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idCorrelative' => $id_registro,
                    'mensaje' => 'Correlativo actualizado',
                    'serie' => $serie,
                    'noBill' => $ultimo + 1
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idDepartment' => $id_registro
                );
            }
            $stmt->close();
            $conn->close();
        }
        
    }catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['correlative'] == 'guia') {

    $ultimo = $_POST['last'];
    
    try{
        if ($ultimo == '' ) {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("UPDATE correlative set last = ? WHERE idCorrelative = 11");
            $stmt->bind_param("i",$ultimo);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idCorrelative' => $id_registro,
                    'mensaje' => 'Correlativo actualizado',
                    'noBill' => $ultimo + 1
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idDepartment' => $id_registro
                );
            }
            $stmt->close();
            $conn->close();
        }
        
    }catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['correlative'] == 'envio') {

    $ultimo = $_POST['last'];
    
    try{
        if ($ultimo == '' ) {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("UPDATE correlative set last = ? WHERE idCorrelative = 21");
            $stmt->bind_param("i",$ultimo);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idCorrelative' => $id_registro,
                    'mensaje' => 'Correlativo actualizado',
                    'noBill' => $ultimo + 1
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idDepartment' => $id_registro
                );
            }
            $stmt->close();
            $conn->close();
        }
        
    }catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
}

?>