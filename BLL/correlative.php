<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['correlative'] == 'editar') {

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
                    'noBill' => $ultimo
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