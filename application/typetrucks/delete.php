<?php

if(isset($_POST["aTypeTruck"])) {
	
	include '../configuration/config.php';
	include '../configuration/opendb.php';	
	
	$success = false;
	$error = "";
	$sql = "DELETE FROM `syswareo_haxpres`.`TYPETRUCK`
			WHERE `TYPETRUCK`.`IDTYPETRUCK` in ({$_POST["aTypeTruck"]});";

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