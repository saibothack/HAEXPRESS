<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';

$sUsuario = htmlspecialchars($_POST["txtUser"]);

$sql = "SELECT `USERS`.`IDUSER`
	FROM `syswareo_haxpres`.`USERS`
	WHERE `USERS`.`UEMAIL` = '{$sUsuario}';";

$registros = mysqli_query($conexion, $sql);
$error     = mysqli_error($conexion);
$rowCount  = mysqli_num_rows($registros);

mysqli_free_result($registros);

if ($rowCount > 0) {
    $response = array(
        'success' => true,
    );
} else {
    $response = array(
        'success' => false,
    );
}

include '../configuration/closedb.php';

header("Content-Type: application/json");
echo json_encode($response);

ob_end_flush();
