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
        $sql = 'SELECT idStorage, stock FROM storage WHERE _idProduct = ? AND _idCellar = 1';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $detail->idproduct);
        if (!mysqli_stmt_execute($stmt)) {
            $query_success = false;
        }
        mysqli_stmt_bind_result($stmt, $idStorage, $storage);
        if (!mysqli_stmt_fetch($stmt)) {
            $idStorage = 0;
        }
        $stock = $storage + $detail->cantdet;
        mysqli_stmt_close($stmt);

        if ($idStorage > 0) {
            $stmt = $conn->prepare("UPDATE storage SET stock = ? WHERE idStorage = ?");
            $stmt->bind_param("ii", $stock, $idStorage);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            mysqli_stmt_close($stmt);
        } else {
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

?>