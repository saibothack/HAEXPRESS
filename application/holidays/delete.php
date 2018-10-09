<?php

if(isset($_POST["aHolidays"])) {
	
	include '../configuration/config.php';
	include '../configuration/opendb.php';	
	
	$success = false;
	$error = "";
	$sql = "DELETE FROM `syswareo_haxpres`.`HOLIDAYS`
			WHERE `HOLIDAYS`.`IDHOLIDAY` in ({$_POST["aHolidays"]});";

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