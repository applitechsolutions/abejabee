<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['customer'] == 'nuevo') {

    $nombre = $_POST['name'];
    $codigo = $_POST['code'];
    $telefono = $_POST['tel'];
    $nit = $_POST['nit'];
    $direccion = $_POST['dir'];
    $owner = $_POST['owner'];
    $departamento = $_POST['departamento'];
    $muni = $_POST['muni'];
    $aldea = $_POST['aldea'];
    $ruta = $_POST['ruta'];
    $encargado = $_POST['incharge'];
    
    try{
        if ($nombre == '' || $codigo == '' || $direccion == '' || $departamento == '' || $muni == '' || $aldea == '' || $ruta == '') {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("INSERT INTO customer (customerName, customerCode, customerTel, customerNit, _idDeparment, _idTown, _idVillage, customerAddress, _idRoute, owner, inCharge) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssiiisiss", $nombre, $codigo, $telefono, $nit, $departamento, $muni, $aldea, $direccion, $ruta, $owner, $encargado);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idCliente' => $id_registro,
                    'mensaje' => 'Cliente creado correctamente!',
                    'proceso' => 'nuevo'
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idCliente' => $id_registro
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

if ($_POST['customer'] == 'actualizar') {
    $id_customer = $_POST['id_customer'];
    $nombre = $_POST['name'];
    $codigo = $_POST['code'];
    $telefono = $_POST['tel'];
    $nit = $_POST['nit'];
    $direccion = $_POST['dir'];
    $owner = $_POST['owner'];
    $departamento = $_POST['departamento'];
    $muni = $_POST['muni'];
    $aldea = $_POST['aldea'];
    $ruta = $_POST['ruta'];
    $encargado = $_POST['incharge'];

    try{
        if ($nombre == '' || $codigo == '' || $direccion == '' || $departamento == '' || $muni == '' || $aldea == '' || $ruta == '') {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("UPDATE customer SET customerName = ?, customerCode = ?, customerTel = ?, customerNit = ?, _idDeparment = ?, _idTown = ?, _idVillage = ?, customerAddress = ?, _idRoute = ?, owner = ?, inCharge = ? WHERE idCustomer = ?");
            $stmt->bind_param("ssssiiisissi", $nombre, $codigo, $telefono, $nit, $departamento, $muni, $aldea, $direccion, $ruta, $owner, $encargado, $id_customer);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idCliente' => $stmt->insert_id,
                    'mensaje' => 'Cliente actualizado correctamente!',
                    'proceso' => 'editado'
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error'
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