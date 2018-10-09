<?php
session_start();
header("Content-Type: application/json");	

include '../configuration/config.php';
include '../configuration/opendb.php';

$idDriver = $_REQUEST["dv"];

$response = array();

if (!(isset($_SESSION["USUARIO"])) && ($_SESSION["USUARIO"] <> "")) {
	echo json_encode($response);
	exit();
}

$sWhere = "";
if ($idDriver != "0") {
	$sWhere = " AND `DRIVERS`.`IDDRIVER` = " . $idDriver . " "; 
}

if ($_SESSION["USUARIO"][0]['IDROLES'] == 1) { 
    $sql = "SELECT `DRIVERS`.`IDDRIVER`,
                `DRIVERS`.`DNAME`,
                (SELECT	`RASTREO`.`LOGITUD`
                    FROM `syswareo_haxpres`.`RASTREO`
                    WHERE `RASTREO`.`DRIVERS_IDDRIVER` = `DRIVERS`.`IDDRIVER`
                    ORDER BY `RASTREO`.`ID_RASTREO` DESC LIMIT 0, 1) AS LOGITUD,
                (SELECT	`RASTREO`.`LATITUD`
                    FROM `syswareo_haxpres`.`RASTREO`
                    WHERE `RASTREO`.`DRIVERS_IDDRIVER` = `DRIVERS`.`IDDRIVER`
                    ORDER BY `RASTREO`.`ID_RASTREO` DESC LIMIT 0, 1) AS LATITUD
            FROM `syswareo_haxpres`.`DRIVERS`
            WHERE `DRIVERS`.`DRIVERSTATUS` = 1  {$sWhere};";

}

$registros = mysqli_query($conexion,$sql);
$error = mysqli_error($conexion);
	
while($row = mysqli_fetch_assoc($registros)) {
	$response[] = $row;
}
	
mysqli_free_result($registros);
	
include '../configuration/closedb.php';


echo html_entity_decode(json_encode($response));

?>