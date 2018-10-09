<?php

if(isset($_POST["idCustomers"])) {
	
	include '../../../application/configuration/config.php';
	include '../../../application/configuration/opendb.php';	


	$rows = array();

	$sql = "SELECT `CUSTOMERS`.`IDCUSTOMER`,
				`CUSTOMERS`.`CNAME`,
				`CUSTOMERS`.`CADDRESS`,
				`CUSTOMERS`.`CSUITE`,
				`CUSTOMERS`.`CCITY`,
				`CUSTOMERS`.`CCP`,
				`CUSTOMERS`.`CPHONE`
			FROM `syswareo_haxpres`.`CUSTOMERS`
			WHERE `CUSTOMERS`.`IDCUSTOMER` = {$_POST["idCustomers"]} AND `CUSTOMERS`.`STATUS` = 1;";

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
	
	$rowsUser = array();

	$sql = "SELECT `USERS`.`IDUSER`,
				`USERS`.`UNAME`,
				`USERS`.`UEMAIL`,
				`USERS`.`UPASSWORD`,
				`USERS`.`URESPONSIBLE`
			FROM `syswareo_haxpres`.`USERS` 
			WHERE `USERS`.`IDCUSTOMER` = {$_POST["idCustomers"]}
			ORDER BY `USERS`.`URESPONSIBLE` DESC;";

	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);

	while($row = mysqli_fetch_assoc($registros)) {
		$rowsUser[] = $row;
	}

	mysqli_free_result($registros);


	include '../../../application/configuration/closedb.php';	
}

?>