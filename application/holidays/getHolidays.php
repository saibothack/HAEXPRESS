<?php

	include '../../../application/configuration/config.php';
	include '../../../application/configuration/opendb.php';	


	$rows = array();
	$sql = "SELECT `HOLIDAYS`.`IDHOLIDAY`,
			    `HOLIDAYS`.`HNAME`
			FROM `syswareo_haxpres`.`HOLIDAYS`;";

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