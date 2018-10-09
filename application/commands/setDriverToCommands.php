<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';

$aCommand = htmlentities($_POST["idCommand"]);
$iDriver  = htmlentities($_POST["iDriver"]);
$sNombre  = htmlentities($_POST["sNombre"]);
$sNotas  = htmlentities($_POST["sNotas"]);
$sPrecio  = htmlentities($_POST["sPrecio"]);

$enviaPushNotification = false;
$keyToken = "";

$success  = false;
$response = array();
$error    = "";

if ($iDriver == 0) {
	$sqlNotification = "SELECT `FK_COMMANDS_DRIVERS`.`IDDRIVER`,
				IFNULL(`DRIVERS`.`TOKENFIREBASE`, '') AS TOKENFIREBASE
			FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
				INNER JOIN `syswareo_haxpres`.`DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDDRIVER` = `DRIVERS`.`IDDRIVER`
			WHERE `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = {$aCommand}
			LIMIT 0, 1;;";

	$registros = mysqli_query($conexion, $sqlNotification);
	$row_cnt = mysqli_num_rows($registros);

	if ($row_cnt > 0) {
		$enviaPushNotification = true;
	}

	while($row = mysqli_fetch_assoc($registros)) {
		$keyToken = $row["TOKENFIREBASE"];
	}

	$sql = "DELETE FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
			WHERE `FK_COMMANDS_DRIVERS`.`IDCOMMAND` in({$aCommand});";

} else {

	$sql = "SELECT `FK_COMMANDS_DRIVERS`.`IDDRIVER`,
				IFNULL(`DRIVERS`.`TOKENFIREBASE`, '') AS TOKENFIREBASE
			FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
				INNER JOIN `syswareo_haxpres`.`DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDDRIVER` = `DRIVERS`.`IDDRIVER`
			WHERE `FK_COMMANDS_DRIVERS`.`IDDRIVER` = {$iDriver}
			LIMIT 0, 1;";

	$registros = mysqli_query($conexion, $sql);
	$row_cnt = mysqli_num_rows($registros);

	if ($row_cnt > 0) {
		$enviaPushNotification = true;
	}


	while($row = mysqli_fetch_assoc($registros)) {
		$keyToken = $row["TOKENFIREBASE"];
	}

    $sql = "DELETE FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
			WHERE `FK_COMMANDS_DRIVERS`.`IDCOMMAND` in({$aCommand});";

    if (mysqli_query($conexion, $sql)) {
        $success = true;
    } else {
        $error = "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }

    $sql = "INSERT INTO `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
				(`IDDRIVER`,
				`IDCOMMAND`)
			SELECT {$iDriver}, 
				`COMMANDS`.`IDCOMMAND`
			FROM `syswareo_haxpres`.`COMMANDS`
			WHERE `COMMANDS`.`IDCOMMAND` IN({$aCommand});";
}

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    $error = "Error: " . $sql . "<br>" . mysqli_error($conexion);
}


$sql = "UPDATE `syswareo_haxpres`.`COMMANDS`
		SET
			`NOTAS` = '{$sNotas}',
			`PRECIO` = '{$sPrecio}'
		WHERE `IDCOMMAND` = {$aCommand};";

mysqli_query($conexion, $sql);

$sql = "SELECT `COMMANDS`.`IDCOMMAND`
		FROM `syswareo_haxpres`.`COMMANDS`
		WHERE `COMMANDS`.`IDCOMMANDCHILD` = {$aCommand};";

$registros = mysqli_query($conexion, $sql);
$error = mysqli_error($conexion);

while($row = mysqli_fetch_assoc($registros)) {
	$aCommand = $row["IDCOMMAND"];
	
	if ($iDriver == 0) {
		$sql = "DELETE FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
				WHERE `FK_COMMANDS_DRIVERS`.`IDCOMMAND` in({$aCommand});";
	} else {

		$sql = "DELETE FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
				WHERE `FK_COMMANDS_DRIVERS`.`IDCOMMAND` in({$aCommand});";

		if (mysqli_query($conexion, $sql)) {
			$success = true;
		} else {
			$error = "Error: " . $sql . "<br>" . mysqli_error($conexion);
		}

		$sql = "INSERT INTO `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					(`IDDRIVER`,
					`IDCOMMAND`)
				SELECT {$iDriver}, 
					`COMMANDS`.`IDCOMMAND`
				FROM `syswareo_haxpres`.`COMMANDS`
				WHERE `COMMANDS`.`IDCOMMAND` IN({$aCommand});";
	}

	if (mysqli_query($conexion, $sql)) {
		$success = true;
	} else {
		$error = "Error: " . $sql . "<br>" . mysqli_error($conexion);
	}
}

if ($enviaPushNotification && ($keyToken != "")) {
	$server_key = 'AAAAmvAB3ik:APA91bF04FEVsnWwtuz85F71bNTtyOr8IF4z6ygFvbyQLfluJHDWKBTWxm6PAP8KOVVYLDwSAG26fEakkU5kjLIL-foBhkL45onKH3ldvpDmUknqRce-Hi24UgUxMosSzveVZlUi3YS1';

	$header = array();
	$header[] = 'Content-type: application/json';
	$header[] = 'Authorization: key=' . $server_key;

	$message = '';
	$title  = 'Comanda #' . $aCommand;
	
	if ($iDriver == 0) {
		$message = 'La comanda #' . $aCommand . ' se elimino.';
	} else {
		$message = 'La comanda #' . $aCommand . ' se le asigno.';
	}

	$payload = [
		'to' => $keyToken,
		'notification' => [
			'title' => $title,
			'body' => $message
		]
	];

	$crl = curl_init();
	curl_setopt($crl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($crl, CURLOPT_POST, true);
	curl_setopt($crl, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	curl_setopt($crl, CURLOPT_POSTFIELDS, json_encode($payload));

	curl_setopt($crl, CURLOPT_RETURNTRANSFER, true );

	$rest = curl_exec($crl);
	if ($rest === false) {
	    print(curl_error($crl));
	    exit();
	}
	//print($rest);
	curl_close($crl);
}



include '../configuration/closedb.php';

$response = array('success' => $success, 'message' => $error);
if ($success) {
    header("Content-Type: application/json");
    echo json_encode($response);
}

ob_end_flush();
