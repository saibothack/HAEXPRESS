<?php

	include '../../../application/configuration/config.php';
	include '../../../application/configuration/opendb.php';

	$where = "";

	if(isset($_POST["noServicio"])) {
		if ($_POST["noServicio"] != "") {
			$where = " AND `MERCHANDISE`.`IDMERCHANDISE` = {$_POST["noServicio"]}";
		}
	}

	$rows = array();
	$sql = "SELECT `MERCHANDISE`.`IDMERCHANDISE`,
				`MERCHANDISE`.`NAME`,
				`MERCHANDISE`.`STATUS`,
				`MERCHANDISE`.`CREATIONDATE`
			FROM `syswareo_haxpres`.`MERCHANDISE`
			WHERE `MERCHANDISE`.`STATUS` = 1
				{$where};";

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