<?php
include_once '../funciones/bd_conexion.php';
include_once '../funciones/sesiones.php';
header("Content-Type: application/json; charset=UTF-8");

if (!empty($_FILES['csv_file']['name'])) {
    try {
        //ABRIMOS EL ARCHIVOS
        $file_data = fopen($_FILES['csv_file']['tmp_name'], 'r');
        fgetcsv($file_data);
        mysqli_autocommit($conn, false);

        //RECORREMOS LAS COLUMNAS DEL ARCHIVO
        while ($row = fgetcsv($file_data)) {
                $query_success = true;

                $codigo = str_replace(' ', '', $row[0]);

                //Selecciona el id del producto
                try {
                    $sql = "SELECT idProduct FROM product WHERE  REPLACE( `productCode` , ' ' , '' ) = '$codigo';";
                    $resultado = $conn->query($sql);
                    $product = $resultado->fetch_assoc();
                } catch (Exception $e) {
                    $query_success = false;
                }
                $idProduct = $product['idProduct'];
                $stock = $row[2];
                $idCellar = 1; //id del tipo de saldo

                //Ingresar Pago
                $stmt = $conn->prepare("INSERT INTO storage(stock, _idProduct, _idCellar) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $stock, $idProduct, $idCellar);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                if ($query_success) {
                    mysqli_commit($conn);
                    //CREAMOS EL ARRAY QUE VA A DEVOLVER EL ARCHIVO AL JS
                    $data = 'OK';
                } else {
                    mysqli_rollback($conn);
                    $data = 'ERROR';
                }
        }
        $conn->close();
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    echo json_encode($data);
}