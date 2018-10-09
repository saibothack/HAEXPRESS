<?php

if(isset($_POST["aCustomers"])) {
	
	include '../configuration/config.php';
	include '../configuration/opendb.php';	

	$success = false;
	$error = "";
	
	$sql = "UPDATE `syswareo_haxpres`.`CUSTOMERS`
			SET
				`STATUS` = 0
			WHERE `CUSTOMERS`.`IDCUSTOMER` in ({$_POST["aCustomers"]});";


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