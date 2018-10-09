<?php 
	
	header("Access-Control-Allow-Origin: *");
    header('Content-Type: text/html; charset=utf-8');
	
    $jsondata = "php://input";
    $phpjsonstring = file_get_contents($jsondata);
    $data = json_decode($phpjsonstring, true);

	$name = "";
    if ($data["oImagen"] != "") {
	    $date = date_create();
		$name = $data["iCommand"] . $data["iAction"] . date_timestamp_get($date) . ".jpg";
		$uri = "images/" . $name;

	    $dataImage = base64_decode($data["oImagen"]);
	    file_put_contents($uri, $dataImage);
	}

	include '../configuration/config.php';
	include '../configuration/opendb.php';	

	$rows = array();
	$success = false;
	$error = "";
	$sql = "UPDATE `syswareo_haxpres`.`COMMANDS`
			SET `IDSTATUS` = {$data["iAction"]}
			WHERE `IDCOMMAND` = {$data["iCommand"]};";
	
	if (mysqli_query($conexion, $sql)) {
    	$success = true;
	} else {
	    $error =  "Error: " . $sql . "<br>" . mysqli_error($conexion);
	}


	$sql = "INSERT INTO `syswareo_haxpres`.`TRACINGS`
				(`IDCOMMAND`,
				`IDSTATUS`,
				`TNOMBRE`,
				`TNOTAS`,
				`TIMAGEN`,
				`TDATE`)
				VALUES
				({$data["iCommand"]},
				{$data["iAction"]},
				'{$data["sNombre"]}',
				'{$data["sNotas"]}',
				'{$name}',
				'{$data["sDate"]}');";

	if (mysqli_query($conexion, $sql)) {
		$idTrancing = mysqli_insert_id($conexion);
    	$success = true;
		
		if ($data["iAction"] >= 5) {
			
			$sql = "SELECT `IDCUSTOMER` FROM `COMMANDS` WHERE `IDCOMMAND` = {$data["iCommand"]};";
			$registros = mysqli_query($conexion, $sql);
			$error     = mysqli_error($conexion);

			$rowCommands = array(); 

			while ($row = mysqli_fetch_assoc($registros)) {
				$rowCommands[] = $row;
			}

			$rowCustomers = array();
			foreach ($rowCommands as &$valor) {

			    $sqlNotification = "SELECT `IDUSER` FROM `USERS` WHERE `IDCUSTOMER` = 1 AND `UEMAIL` != '' 
									UNION
									SELECT `IDUSER` FROM `USERS` WHERE `IDCUSTOMER` = {$valor["IDCUSTOMER"]} AND `UEMAIL` != '';";
				$registrosNotification = mysqli_query($conexion, $sqlNotification);

				while ($rowNotification = mysqli_fetch_assoc($registrosNotification)) {
					$rowCustomers[] = $rowNotification;
				}
			}

			foreach ($rowCustomers as &$valor) {

			    $sqlInsertNotification = "INSERT INTO `NOTIFICATIONS`(`TRACINGS_IDTRACING`, `USERS_IDUSER`) VALUES ({$idTrancing}, {$valor["IDUSER"]});";
				mysqli_query($conexion, $sqlInsertNotification);
			}

		}
	} else {
	    $error =  "Error: " . $sql . "<br>" . mysqli_error($conexion);
	}

	$rows = array(
		'success' => $success,
		'message' => $error
	);

	header("Content-Type: application/json");	
	echo json_encode($rows);
?>