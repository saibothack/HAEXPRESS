<?php
	session_start();
	include '../configuration/config.php';
	include '../configuration/opendb.php';	

	$rowsUser = array();

	$sql = "SELECT `USERS`.`IDUSER`,
				`USERS`.`UNAME`,
				`USERS`.`UEMAIL`,
				`USERS`.`UPASSWORD`,
				`USERS`.`URESPONSIBLE`,
				`USERS`.`IDCUSTOMER`
			FROM `syswareo_haxpres`.`USERS` 
			WHERE `USERS`.`IDUSER` = {$_SESSION["USUARIO"][0]['IDUSER']}
			ORDER BY `USERS`.`URESPONSIBLE` DESC;";

	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);

	while($row = mysqli_fetch_assoc($registros)) {
		$rowsUser = $row;
	}

	mysqli_free_result($registros);


	$rows = array();

	$sql = "SELECT `CUSTOMERS`.`IDCUSTOMER`,
				`CUSTOMERS`.`CNAME`,
				`CUSTOMERS`.`CADDRESS`,
				`CUSTOMERS`.`CSUITE`,
				`CUSTOMERS`.`CCITY`,
				`CUSTOMERS`.`CCP`,
				`CUSTOMERS`.`CPHONE`
			FROM `syswareo_haxpres`.`CUSTOMERS`
			WHERE `CUSTOMERS`.`IDCUSTOMER` = {$rowsUser['IDCUSTOMER']} AND `CUSTOMERS`.`STATUS` = 1;";

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

	include '../configuration/closedb.php';	

	$response = array(
		'rowsUser' => array($rowsUser),
		'rowsCustomer' => array($rows)
	);

	header("Content-Type: application/json");	
	echo json_encode($response);	

?>