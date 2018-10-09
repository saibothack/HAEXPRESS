<?php

	include '../../../application/configuration/config.php';
	include '../../../application/configuration/opendb.php';

	$where = "";

	if(isset($_POST["noServicio"])) {
		if ($_POST["noServicio"] != "") {
			$where = " AND `TYPECOMMAND`.`IDTYPECOMAMAND` = {$_POST["noServicio"]}";
		}
	}

	$rows = array();
	$sql = "SELECT `TYPECOMMAND`.`IDTYPECOMAMAND`,
			    `TYPECOMMAND`.`TCNAME`,
				`TYPECOMMAND`.`TCCOLOR`,
			    `TYPECOMMAND`.`TCCHANGECOLLECTIONPLACE`,
			    `TYPECOMMAND`.`TCCREATIONDATE`,
			    `TYPECOMMAND`.`CHDIRSALIDA`,
			    `TYPECOMMAND`.`CHDIRENTREGA`,
			    `TYPECOMMAND`.`CHDIRRETORNO`,
			    `TYPECOMMAND`.`TCSTATUS`
			FROM `syswareo_haxpres`.`TYPECOMMAND`
			WHERE  `TYPECOMMAND`.`TCSTATUS` = 1 
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