<?php

	include '../../../application/configuration/config.php';
	include '../../../application/configuration/opendb.php';	

	$where = "";

	if(isset($_POST["noServicio"])) {
		if ($_POST["noServicio"] != "") {
			$where = " AND `STATUS`.`IDSTATUS` = {$_POST["noServicio"]}";
		}
	}

	$rowsStatus = array();
	$sql = "SELECT `STATUS`.`IDSTATUS`,
				`STATUS`.`SNAME`,
				`STATUS`.`SCREATIONDATE`,
				`STATUS`.`COLOR`,
				`STATUS`.`FINALIZA`,
				`STATUS`.`HORAS`,
				`STATUS`.`INICIA`,
				`STATUS`.`STATUS`,
				`STATUS`.`GEOCERCA`
			FROM `syswareo_haxpres`.`STATUS`
			WHERE `STATUS`.`STATUS` = 1
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

	include '../../../application/configuration/closedb.php';	

?>