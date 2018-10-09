<?php 
	
	header("Access-Control-Allow-Origin: *");
    header('Content-Type: text/html; charset=utf-8');

    $jsondata = "php://input";
    $phpjsonstring = file_get_contents($jsondata);
    $data = json_decode($phpjsonstring, true);
		
	include '../configuration/config.php';
	include '../configuration/opendb.php';	

	$rows = array();
	$sql = "SELECT `DRIVERS`.`IDDRIVER` as iDriver,
			    `DRIVERS`.`DNUMBER`  as sNumber,
			    `DRIVERS`.`DNAME` as sName,
			    `DRIVERS`.`DADDRESS` as sAddress,
			    `DRIVERS`.`DPHONE` as sPhone,
			    `DRIVERS`.`DEMAIL` as sEmail
			FROM `syswareo_haxpres`.`DRIVERS`
			WHERE `DRIVERS`.`DEMAIL` = '{$data["sEmail"]}'
				AND `DRIVERS`.`DPHONE` = '{$data["sPhone"]}';";

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