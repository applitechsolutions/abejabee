<?php
include_once '../funciones/bd_conexion.php';

$idSale = $_POST['idSale'];
$MyArray = json_decode($_POST['json']);

try {
    /* Switch off auto commit to allow transactions*/
    mysqli_autocommit($conn, false);
    $query_success = true;

    $stmt = $conn->prepare('UPDATE sale SET state = 1 WHERE idSale = ?');
    $stmt->bind_param("i", $idSale);
    if (!mysqli_stmt_execute($stmt)) {
        $query_success = false;
    }
    mysqli_stmt_close($stmt);

    foreach ($MyArray->detailNULL as $detail) {

        //Update STORAGE
        //Selecciona los STORAGES que pertenecen a este producto
        try {
            $sql = "SELECT idStorage, stock, dateExp FROM storage WHERE _idProduct = $detail->idproduct AND _idCellar = 1 ORDER BY dateExp ASC";
            $resultado2 = $conn->query($sql);
        } catch (Exception $e) {
            $query_success = false;
        }
        // Esta es una bandera para condicionar que actualiza el primer registro del listado
        $primer_registro = 0;
        while ($storage = $resultado2->fetch_assoc()) {

            if ($primer_registro == 0) {
                $primer_registro = 1;
                $stock = $storage['stock'] + $detail->cantdet;

                $stmt = $conn->prepare("UPDATE storage SET stock = ? WHERE idStorage = ?");
                $stmt->bind_param("ii", $stock, $storage['idStorage']);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);
            }
        }

        if ($primer_registro == 0) {
            $id_cellar = 1;
            $stmt = $conn->prepare("INSERT INTO storage (stock, _idProduct, _idCellar) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $detail->cantdet, $detail->idproduct, $id_cellar);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            mysqli_stmt_close($stmt);
        }
        if ($query_success) {
            mysqli_commit($conn);
            $respuesta = array(
                'respuesta' => 'exito',
            );
        } else {
            mysqli_rollback($conn);
            $respuesta = array(
                'respuesta' => 'error',
            );
        }
    }
    $conn->close();
} catch (Exception $e) {
    echo 'Error: ' . $e . getMessage();
}
die(json_encode($respuesta));
