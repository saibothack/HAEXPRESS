<?php
session_start();
header("Content-Type: application/json");	

$iComanda = $_REQUEST["iCommand"];

include '../configuration/config.php';
include '../configuration/opendb.php';

$response = array();
$error = "";

$sql = "SELECT `SEND_SMS`.`ID_SEND_SMS`,
    `SEND_SMS`.`COMMANDS_IDCOMMAND`
    FROM `syswareo_haxpres`.`SEND_SMS`
    WHERE `SEND_SMS`.`COMMANDS_IDCOMMAND` = {$iComanda};";

$registros = mysqli_query($conexion,$sql);
$row_cnt = mysqli_num_rows($registros);
$success = false;

if ($row_cnt <= 0) {
    $sql = "INSERT INTO `syswareo_haxpres`.`SEND_SMS`
                (`COMMANDS_IDCOMMAND`)
            VALUES
                ({$iComanda});";

    if (mysqli_query($conexion, $sql)) {
        $success = true;
    } else {
        $error = mysqli_error($conexion);
    }
}

$response = array(
    "success" => $success,
    "message" => $error
);
	
mysqli_free_result($registros);
	
include '../configuration/closedb.php';

echo json_encode($response);

?>