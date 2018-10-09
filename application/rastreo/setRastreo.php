<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');

include '../configuration/config.php';
include '../configuration/opendb.php';

$jsondata = "php://input";

$phpjsonstring = file_get_contents($jsondata);

$data = json_decode($phpjsonstring, true);

$iConductor = $data["idConductor"];
$indConnect = $data["indConnect"];
$sLat = $data["Lat"];
$sLong = $data["Long"];
$time = $data["time"];
$sToken = $data["sToken"];

$response = array();
$error = "";
$success = false;

$sql = "UPDATE `syswareo_haxpres`.`DRIVERS`
        SET
            `DRIVERSTATUS` = {$indConnect},
            `TOKENFIREBASE` = '{$sToken}'
        WHERE `IDDRIVER` = {$iConductor};";

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    $error = mysqli_error($conexion);
}

if ($indConnect == "0") {
    $sql = "UPDATE `syswareo_haxpres`.`DRIVERS`
            SET
                `TOKENFIREBASE` = ''
            WHERE `IDDRIVER` = {$iConductor};"; 

    $success = mysqli_query($conexion,$sql);
    $message = mysqli_error($conexion);
}


$sql = "INSERT INTO `syswareo_haxpres`.`RASTREO`
            (`LOGITUD`,
            `LATITUD`,
            `DRIVERS_IDDRIVER`)
        VALUES
            ('{$sLong}',
            '{$sLat}',
            {$iConductor});";

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    $error = mysqli_error($conexion);
}


$response = array(
    "success" => $success,
    "message" => $error
);
	
include '../configuration/closedb.php';

header("Content-Type: application/json");	
echo json_encode($response);


?>