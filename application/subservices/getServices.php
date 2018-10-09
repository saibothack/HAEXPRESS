<?php

	include '../../../application/configuration/config.php';
	include '../../../application/configuration/opendb.php';

	$where = "";

	if(isset($_POST["noSubServicio"])) {
		if ($_POST["noSubServicio"] != "") {
			$where = " AND `SUBSERVICES`.`IDSUBSERVICES` = {$_POST["noSubServicio"]}";
		}
	}
	
	$rows = array();
	$sql = "SELECT `SUBSERVICES`.`IDSUBSERVICES`,
				`SUBSERVICES`.`NAME`,
				`SUBSERVICES`.`STATUS`,
				`SUBSERVICES`.`CREATIONDATE`,
				`SUBSERVICES`.`TYPECOMMAND_IDTYPECOMAMAND`,
				`SUBSERVICES`.`SCHEDULES_IDSCHEDULE`,
				`SUBSERVICES`.`COLOR`,
				IFNULL(`SCHEDULES`.`SHDESCRIPTION`, '') AS SHDESCRIPTION,
				`TYPECOMMAND`.`IDTYPECOMAMAND`,
				`TYPECOMMAND`.`TCNAME`
			FROM `syswareo_haxpres`.`SUBSERVICES`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND` ON `SUBSERVICES`.`TYPECOMMAND_IDTYPECOMAMAND` = `TYPECOMMAND`.`IDTYPECOMAMAND`
				LEFT JOIN `syswareo_haxpres`.`SCHEDULES` ON `SUBSERVICES`.`SCHEDULES_IDSCHEDULE` = `SCHEDULES`.`IDSCHEDULE`
			WHERE `SUBSERVICES`.`STATUS` = 1 AND `TYPECOMMAND`.`TCSTATUS` = 1 AND `SCHEDULES`.`STATUS` = 1
				{$where};";

	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);

	while($row = mysqli_fetch_assoc($registros)) {
		$rows[] = $row;
	}

	mysqli_free_result($registros);

	if($error != "") {
		print($error);
	}

	include '../../../application/configuration/closedb.php';
?>