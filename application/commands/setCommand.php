<?php
ob_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$cmbEstatus = str_replace("'", "\'", htmlentities($_POST["cmbEstatus"]));
$cmbService = str_replace("'", "\'", htmlentities($_POST["cmbService"]));
$cmbVehiculo = str_replace("'", "\'", htmlentities($_POST["cmbVehiculo"]));
$iCommand = str_replace("'", "\'", htmlentities($_POST["iCommand"]));
$txtAddress = str_replace("'", "\'", htmlentities($_POST["txtAddress"]));
$txtAddressDelivery = str_replace("'", "\'", htmlentities($_POST["txtAddressDelivery"]));
$txtCity = str_replace("'", "\'", htmlentities($_POST["txtCity"]));
$txtCityDelivery = str_replace("'", "\'", htmlentities($_POST["txtCityDelivery"]));
$txtCompanty = str_replace("'", "\'", htmlentities($_POST["txtCompanty"]));
$txtCompantyDelivery = str_replace("'", "\'", htmlentities($_POST["txtCompantyDelivery"]));
$txtContact = str_replace("'", "\'", htmlentities($_POST["txtContact"]));
$txtContactDelivery = str_replace("'", "\'", htmlentities($_POST["txtContactDelivery"]));
$txtInstructions = str_replace("'", "\'", htmlentities($_POST["txtInstructions"]));
$txtNombre = str_replace("'", "\'", htmlentities($_POST["txtNombre"]));
$txtNotas = str_replace("'", "\'", htmlentities($_POST["txtNotas"]));
$txtPhone = str_replace("'", "\'", htmlentities($_POST["txtPhone"]));
$txtPhoneDelivery = str_replace("'", "\'", htmlentities($_POST["txtPhoneDelivery"]));
$txtPrecio = str_replace("'", "\'", htmlentities($_POST["txtPrecio"]));
$txtProv = str_replace("'", "\'", htmlentities($_POST["txtProv"]));
$txtProvDelivery = str_replace("'", "\'", htmlentities($_POST["txtProvDelivery"]));
$txtQuanty = str_replace("'", "\'", htmlentities($_POST["txtQuanty"]));
$txtReference = str_replace("'", "\'", htmlentities($_POST["txtReference"]));
$txtSuite = str_replace("'", "\'", htmlentities($_POST["txtSuite"]));
$txtSuiteDelivery = str_replace("'", "\'", htmlentities($_POST["txtSuiteDelivery"]));
$txtTransfer = str_replace("'", "\'", htmlentities($_POST["txtTransfer"]));
$txtWeight = str_replace("'", "\'", htmlentities($_POST["txtWeight"]));
$idDriver = str_replace("'", "\'", htmlentities($_POST["idDriver"]));

$time = strtotime(htmlentities($_POST["txtFecha"]));
$txtFecha = date('Y-m-d',$time);
$txtHora = htmlentities($_POST["txtHora"]);

$enviaPushNotification = false;
$keyToken = "";

$success  = false;
$response = array();
$error    = "";

$sql = "UPDATE `syswareo_haxpres`.`COMMANDS`
		SET
			`IDTYPETRUCK` = {$cmbVehiculo},
			`IDSTATUS` = {$cmbEstatus},
			`CMCOMPANY` = '{$txtCompanty}',
			`CMCONTAC` = '{$txtContact}',
			`CMADDRESS` = '{$txtAddress}',
			`CMSUITE` = '{$txtSuite}',
			`CMCITY` = '{$txtCity}',
			`CMPHONE` = '{$txtPhone}',
			`CMCOMPANYDELIVERY` = '{$txtCompantyDelivery}',
			`CMCONTACDELIVERY` = '{$txtContactDelivery}',
			`CMADDRESSDELIVERY` = '{$txtAddressDelivery}',
			`CMSUITEDELIVERY` = '{$txtSuiteDelivery}',
			`CMCITYDELIVERY` = '{$txtCityDelivery}',
			`CMPHONEDELIVERY` = '{$txtPhoneDelivery}',
			`CMQUANTITY` = '{$txtQuanty}',
			`CMWEIGHT` = '{$txtWeight}',
			`CMREFERENCE` = '{$txtReference}',
			`CMTRANSFER` = '{$txtTransfer}',
			`CMINSTRUCTIONS` = '{$txtInstructions}',
			`SUBSERVICES_IDSUBSERVICES` = {$cmbService},
			`PROV` = '{$txtProv}',
			`PROVDELIVERY` = '{$txtProvDelivery}',
			`NOTAS` = '{$txtNotas}',
			`PRECIO` = '{$txtPrecio}',
			`CMDATE` = '{$txtFecha}',
			`HORA` = '{$txtHora}'
		WHERE `IDCOMMAND` = {$iCommand};";

if (mysqli_query($conexion, $sql)) {	
    $success = true;
} else {
    $error = "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

if ($idDriver == 0) {
	$sqlNotification = "SELECT `FK_COMMANDS_DRIVERS`.`IDDRIVER`,
				IFNULL(`DRIVERS`.`TOKENFIREBASE`, '') AS TOKENFIREBASE
			FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
				INNER JOIN `syswareo_haxpres`.`DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDDRIVER` = `DRIVERS`.`IDDRIVER`
			WHERE `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = {$iCommand}
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
			WHERE `FK_COMMANDS_DRIVERS`.`IDCOMMAND` in({$iCommand});";
} else {

	$sql = "SELECT `FK_COMMANDS_DRIVERS`.`IDDRIVER`,
				IFNULL(`DRIVERS`.`TOKENFIREBASE`, '') AS TOKENFIREBASE
			FROM `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
				INNER JOIN `syswareo_haxpres`.`DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDDRIVER` = `DRIVERS`.`IDDRIVER`
			WHERE `FK_COMMANDS_DRIVERS`.`IDDRIVER` = {$idDriver}
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
			WHERE `FK_COMMANDS_DRIVERS`.`IDCOMMAND` in({$iCommand});";

    if (mysqli_query($conexion, $sql)) {
        $success = true;
    } else {
        $error = "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }

    $sql = "INSERT INTO `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
				(`IDDRIVER`,
				`IDCOMMAND`)
			SELECT $idDriver, `COMMANDS`.`IDCOMMAND`
			FROM `syswareo_haxpres`.`COMMANDS`
			WHERE `COMMANDS`.`IDCOMMAND` IN({$iCommand});";
}

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    $error = "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

if ($enviaPushNotification && ($keyToken != "")) {
	$server_key = 'AAAAmvAB3ik:APA91bF04FEVsnWwtuz85F71bNTtyOr8IF4z6ygFvbyQLfluJHDWKBTWxm6PAP8KOVVYLDwSAG26fEakkU5kjLIL-foBhkL45onKH3ldvpDmUknqRce-Hi24UgUxMosSzveVZlUi3YS1';

	$header = array();
	$header[] = 'Content-type: application/json';
	$header[] = 'Authorization: key=' . $server_key;

	$message = '';
	$title  = 'Comanda #' . $aCommand;
	$message = 'Su comanda se modifico, favor de revisar.';

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
?>