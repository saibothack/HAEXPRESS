<?php

if(isset($_POST["aSchedules"])) {
	
	include '../configuration/config.php';
	include '../configuration/opendb.php';	
	
	$success = false;
	$error = "";
	$sql = "UPDATE `syswareo_haxpres`.`SCHEDULES`
				SET `SCHEDULES`.`STATUS` = 0
			WHERE `SCHEDULES`.`IDSCHEDULE` in ({$_POST["aSchedules"]});";

	if (mysqli_query($conexion, $sql)) {
    	$success = true;
	} else {
		$error = mysqli_error($conexion);
	}
	
	$response = array('success' => $success, 'message' => $error);

	include '../configuration/closedb.php';	

	header("Content-Type: application/json");	
	echo json_encode($response);
}

?>