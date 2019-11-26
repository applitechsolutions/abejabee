<?php

if (isset($_POST['ingresar'])) {
    $usuario = $_POST['usaurio-login'];
    $password = $_POST['pass-login'];

    //die(json_encode($_POST));

    try {
        include_once '../funciones/bd_conexion.php';
        /* Switch off auto commit to allow transactions*/
        mysqli_autocommit($conn, false);
        $query_success = true;

        $stmt = $conn->prepare("SELECT U.idUser, U.firstName, U.lastName, U.userName, U.passWord, U.permissions FROM user U WHERE U.userName = ?;");
        $stmt->bind_param("s", $usuario);
        if (!mysqli_stmt_execute($stmt)) {
            $query_success = false;
        }
        $stmt->bind_result($id_log, $nombre_log, $apellido_log, $usuario_log, $pass_log, $permiso_log);
        if ($stmt->affected_rows) {
            $existe = $stmt->fetch();
            mysqli_stmt_close($stmt);
            if ($existe) {
                if (password_verify($password, $pass_log)) {
                    session_start();
                    $_SESSION['idusuario'] = $id_log;
                    $_SESSION['usuario'] = $usuario_log;
                    $_SESSION['nombre'] = $nombre_log;
                    $_SESSION['rol'] = $permiso_log;
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $nombre_log,
                        'permiso' => $permiso_log,
                    );

                    //Selecciona CHEQUES ATRASADOS EN 10 DIAS O MAS.
                    try {
                        $sql = "SELECT B.idBalance, B._idSale FROM balance B WHERE DATE_ADD(B.date, INTERVAL 10 DAY) <= CURDATE() AND state = 1";
                        $resultado = $conn->query($sql);
                    } catch (Exception $e) {
                        $query_success = false;
                    }
                    while ($cheques = $resultado->fetch_assoc()) {

                        $idBalance = $cheques['idBalance'];
                        $id_sale = $cheques['_idSale'];
                        //Update BALANCE
                        $state = 0;
                        $stmt = $conn->prepare("UPDATE balance SET date = CURDATE(), state = ? WHERE idBalance = ?");
                        $stmt->bind_param("ii", $state, $idBalance);
                        if (!mysqli_stmt_execute($stmt)) {
                            $query_success = false;
                        }
                        mysqli_stmt_close($stmt);

                        //Selecciona los pagos realizados
                        try {
                            $sql = "SELECT idBalance, amount, state FROM balance WHERE _idSale = $id_sale AND state != 2 ORDER BY idBalance ASC;";
                            $resultado2 = $conn->query($sql);
                        } catch (Exception $e) {
                            $query_success = false;
                        }
                        $bandera = 0;
                        while ($balance = $resultado2->fetch_assoc()) {
                            //Update PAY'S
                            if ($bandera == 0) {
                                $nuevo_balance = $balance['amount'];
                                $bandera = 1;
                            } else {
                                if ($balance['state'] != 1) {
                                    $nuevo_balance = $nuevo_balance - $balance['amount'];
                                }

                                $stmt = $conn->prepare("UPDATE balance SET balance = ? WHERE idBalance = ?");
                                $stmt->bind_param("di", $nuevo_balance, $balance['idBalance']);
                                if (!mysqli_stmt_execute($stmt)) {
                                    $query_success = false;
                                }
                                mysqli_stmt_close($stmt);
                            }
                        }

                        if ($nuevo_balance == 0) {
                            $stmt = $conn->prepare('UPDATE sale SET cancel = 1 WHERE idSale = ?');
                            $stmt->bind_param("i", $id_sale);
                            if (!mysqli_stmt_execute($stmt)) {
                                $query_success = false;
                            }
                            mysqli_stmt_close($stmt);
                        }
                    }
                    if ($query_success) {
                        mysqli_commit($conn);
                    } else {
                        mysqli_rollback($conn);
                    }
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error_select',
            );
        }
        $conn->close();
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }

    die(json_encode($respuesta));
}