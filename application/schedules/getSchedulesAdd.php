<?php

if(isset($_POST["idSchedule"])) {
	
	include '../../../application/configuration/config.php';
	include '../../../application/configuration/opendb.php';	

	$rows = array();
	$sql = "SELECT `SCHEDULES`.`IDSCHEDULE`,
			    `SCHEDULES`.`SHDESCRIPTION`
			FROM `syswareo_haxpres`.`SCHEDULES`
			WHERE `SCHEDULES`.`IDSCHEDULE` = {$_POST["idSchedule"]}
				AND `SCHEDULES`.`STATUS` = 1;";

	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);

	while($row = mysqli_fetch_assoc($registros)) {
		$rows = $row;
	}

	mysqli_free_result($registros);

	if($error != "") {
		print($error);
	}

	include '../../../application/configuration/closedb.php';	
}

?>