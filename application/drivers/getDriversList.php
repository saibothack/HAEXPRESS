<?php

	include '../configuration/config.php';
	include '../configuration/opendb.php';	

	$whereTerm = "";
	if(isset($_GET["term"])) {
		$whereTerm = " AND `DRIVERS`.`DNAME` LIKE '%{$_GET["term"]}%'";
	}

	$rows = array();
	$sql = "SELECT `DRIVERS`.`IDDRIVER`,
				CASE SUBSTRING(IFNULL(`DRIVERS`.`DNAME`, ''), 1, LOCATE(' ', IFNULL(`DRIVERS`.`DNAME`, ''))) WHEN '' THEN IFNULL(`DRIVERS`.`DNAME`, '') ELSE SUBSTRING(IFNULL(`DRIVERS`.`DNAME`, ''), 1, LOCATE(' ', IFNULL(`DRIVERS`.`DNAME`, ''))) END AS DNAME,
				`DRIVERS`.`DRIVERSTATUS` AS ESTATUS
			FROM `syswareo_haxpres`.`DRIVERS`
			WHERE `DRIVERS`.`STATUS` = 1
			{$whereTerm};";	

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

	include '../configuration/closedb.php';	

	header("Content-Type: application/json");	
	echo json_encode($rows);
?>