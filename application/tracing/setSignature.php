<?php 
	
	header("Access-Control-Allow-Origin: *");
    header('Content-Type: text/html; charset=utf-8');
	
    $jsondata = "php://input";
    $phpjsonstring = file_get_contents($jsondata);
    $data = json_decode($phpjsonstring, true);

	$name = "";
    if ($data["oImagen"] != "") {
	    $date = date_create();
		$name = $data["iCommand"] . date_timestamp_get($date) . ".jpg";
		$uri = "images/" . $name;

	    $dataImage = base64_decode($data["oImagen"]);
	    file_put_contents($uri, $dataImage);
	}

	include '../configuration/config.php';
	include '../configuration/opendb.php';		
	
	$sql = "INSERT INTO `syswareo_haxpres`.`SIGNATURES`
				(`IDCOMMAND`,
				`SGSCORE`,
				`SGIMAGESIGNATURE`,
				`SGNAME`)
					VALUES
				({$data["iCommand"]},
				{$data["iCalifica"]},
				'{$name}',
				'');";

	if (mysqli_query($conexion, $sql)) {
    	$success = true;
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