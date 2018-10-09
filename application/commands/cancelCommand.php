<?php

include '../configuration/config.php';
include '../configuration/opendb.php';

$success = false;
$error   = "";
$sql     = "UPDATE `syswareo_haxpres`.`COMMANDS`
			SET
				`IDSTATUS` = 2
			WHERE `IDCOMMAND` = {$_POST['idCommand']};";

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    $error = mysqli_error($conexion);
}

$response = array('success' => $success, 'message' => $error);

include '../configuration/closedb.php';

header("Content-Type: application/json");
echo json_encode($response);
