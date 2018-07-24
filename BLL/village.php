<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['aldea'] == 'nuevo') {

    $nombre = $_POST['name'];
    
    try{
        if ($nombre == '') {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("INSERT INTO village (name) VALUES (?)");
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idAldea' => $id_registro,
                    'mensaje' => 'Aldea creada correctamente!'
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idAldea' => $id_registro
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