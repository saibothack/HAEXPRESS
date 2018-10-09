<?php
session_start();
header("Content-Type: application/json");	

include '../configuration/config.php';
include '../configuration/opendb.php';

$response = array();

if (!(isset($_SESSION["USUARIO"])) && ($_SESSION["USUARIO"] <> "")) {
	echo json_encode($response);
	exit();
}

$sql = "SELECT `COMMANDS`.`IDCOMMAND` AS idCommand,
				`COMMANDS`.`CMADDRESS` AS sAddress,
				`COMMANDS`.`CMADDRESSDELIVERY` AS sAddressDelivery,
				DATE_FORMAT(`COMMANDS`.`CMDATE`,'%d-%m-%Y') AS sDate,
				DATE_FORMAT(`COMMANDS`.`CMCREATIONDATE`,'%d-%m-%Y') AS sDateIngreso
			FROM `syswareo_haxpres`.`COMMANDS`	
				INNER JOIN`syswareo_haxpres`.`STATUS` ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND` ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES` ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				INNER JOIN `syswareo_haxpres`.`CUSTOMERS` ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
			WHERE `TYPECOMMAND`.`TCSTATUS` = 1 AND `SCHEDULES`.`STATUS` = 1 AND `STATUS`.`STATUS` = 1 
				AND `COMMANDS`.`IDSTATUS` = (SELECT `STATUS`.`IDSTATUS`
					FROM `syswareo_haxpres`.`STATUS`
					WHERE `STATUS`.`INICIA` = 1 AND `STATUS`.`STATUS` = 1
					LIMIT 0, 1) 
				AND `COMMANDS`.`IDCOMMAND` NOT IN (SELECT `FK_COMMANDS_DRIVERS`.`IDCOMMAND`
					FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`) 
				AND `COMMANDS`.`IDCOMMANDCHILD` IS NULL AND `CUSTOMERS`.`STATUS` = 1 ;";

$registros = mysqli_query($conexion,$sql);
$error = mysqli_error($conexion);
	
while($row = mysqli_fetch_assoc($registros)) {
	$response[] = $row;
}
	
mysqli_free_result($registros);
	
include '../configuration/closedb.php';


echo html_entity_decode(json_encode($response));
?>