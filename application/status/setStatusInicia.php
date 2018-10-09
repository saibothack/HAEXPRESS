<?php

	include '../configuration/config.php';
	include '../configuration/opendb.php';	

	$where = "";

	if(isset($_POST["noServicio"])) {
		if ($_POST["noServicio"] != "") {
			$where = " AND `STATUS`.`IDSTATUS` != {$_POST["noServicio"]}";
		}
	}

	$rowsStatus = array();
	$sql = "SELECT COUNT(`STATUS`.`IDSTATUS`) AS SUMA
			FROM `syswareo_haxpres`.`STATUS`
			WHERE `STATUS`.`STATUS` = 1
				AND `STATUS`.`INICIA` = 1
			{$where};";

	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);

	while($row = mysqli_fetch_assoc($registros)) {
		$rowsStatus[] = $row;
	}

	mysqli_free_result($registros);

	if($error != "") {
		print($error);
	}

	include '../configuration/closedb.php';	

	header("Content-Type: application/json");
	echo json_encode($rowsStatus);

?>