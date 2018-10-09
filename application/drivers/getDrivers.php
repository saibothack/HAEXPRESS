<?php

	include '../../../application/configuration/config.php';
	include '../../../application/configuration/opendb.php';	


	$rows = array();
	$whereIdDriver = "";

	if(isset($_POST["idDriver"])) {
		$whereIdDriver = " AND `DRIVERS`.`IDDRIVER` = {$_POST["idDriver"]}";
	}

	$sql = "SELECT `DRIVERS`.`IDDRIVER`,
				`DRIVERS`.`DNUMBER`,
				`DRIVERS`.`DNAME`,
				`DRIVERS`.`DADDRESS`,
				`DRIVERS`.`DPHONE`,
				`DRIVERS`.`DLICENCE`,
				`DRIVERS`.`DEMAIL`
			FROM `syswareo_haxpres`.`DRIVERS`
			WHERE `DRIVERS`.`STATUS` = 1
			{$whereIdDriver};";

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