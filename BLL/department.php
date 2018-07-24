<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['departamento'] == 'nuevo') {

    $nombre = $_POST['name'];
    
    try{
        if ($nombre == '') {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("INSERT INTO deparment (name) VALUES (?)");
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idDepartment' => $id_registro,
                    'mensaje' => 'Departamento creado correctamente!'
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