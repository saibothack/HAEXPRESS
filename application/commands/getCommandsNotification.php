<?php 
	session_start();

		
	include '../configuration/config.php';
	include '../configuration/opendb.php';

	$rows = array();
	$sql = "SELECT COUNT(`NOTIFICATIONS`.`IDNOTIFICATION`) AS iNotifications
			FROM `syswareo_haxpres`.`NOTIFICATIONS`
				INNER JOIN `syswareo_haxpres`.`TRACINGS` ON `NOTIFICATIONS`.`TRACINGS_IDTRACING` = `TRACINGS`.`IDTRACING`
			    INNER JOIN `syswareo_haxpres`.`COMMANDS` ON `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
			    INNER JOIN `syswareo_haxpres`.`STATUS` ON `STATUS`.`IDSTATUS` = `TRACINGS`.`IDSTATUS`
			    INNER JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
			    INNER JOIN `syswareo_haxpres`.`DRIVERS` ON  `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
			    INNER JOIN `syswareo_haxpres`.`CUSTOMERS` ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
			WHERE `NOTIFICATIONS`.`USERS_IDUSER` = {$_SESSION["USUARIO"][0]["IDUSER"]} AND `NOTIFICATIONS`.`SHOW` = 0 AND `CUSTOMERS`.`STATUS` = 1;";

	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);

	while($row = mysqli_fetch_assoc($registros)) {
		$rows[] = $row;
	}

	mysqli_free_result($registros);

	include '../configuration/closedb.php';

	header("Content-Type: application/json");	
	echo html_entity_decode(json_encode($rows));
?>	