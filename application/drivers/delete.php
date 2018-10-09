<?php

if(isset($_POST["aConductores"])) {
	
	include '../configuration/config.php';
	include '../configuration/opendb.php';	
	
	$success = false;
	$error = "";
	$sql = "UPDATE `syswareo_haxpres`.`DRIVERS`
			SET
				`STATUS` = 0
			WHERE `IDDRIVER` in ({$_POST["aConductores"]});";

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