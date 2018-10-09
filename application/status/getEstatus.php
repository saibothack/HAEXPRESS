<?php 
	include '../configuration/config.php';
	include '../configuration/opendb.php';	

	$rows = array();
	$sql = "SELECT `STATUS`.`IDSTATUS` AS iEstatus,
			    `STATUS`.`SNAME` AS sNombre,
			    `STATUS`.`COLOR` AS sColor,
			    CASE `STATUS`.`FINALIZA` WHEN 0 THEN 'false' WHEN 1 THEN 'true' END AS Finaliza,
			    CASE `STATUS`.`INICIA` WHEN 0 THEN 'false' WHEN 1 THEN 'true' END AS Inicia
			FROM `syswareo_haxpres`.`STATUS`
			WHERE STATUS = 1;";

	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);

	while($row = mysqli_fetch_assoc($registros)) {
		$rows[] = $row;
	}

	mysqli_free_result($registros);

	header("Content-Type: application/json");	
	echo json_encode($rows);

?>	