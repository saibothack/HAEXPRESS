<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';

$iCommand = 0;
$iCommand1 = 0;
$error = "";

$cmbMerchandise = htmlentities($_POST["cmbMerchandise"]);
$cmbHorario = htmlentities($_POST["cmbHorario"]);
$cmbService = htmlentities($_POST["cmbService"]);
$cmbTypeTruck = htmlentities($_POST["cmbTypeTruck"]);
$idTipoOrden = htmlentities($_POST["idTipoOrden"]);

$time = strtotime(htmlentities($_POST["sDate"]));
$sDate = date('Y-m-d',$time);

$txtAddress = str_replace("'", "\'", htmlentities($_POST["txtAddress"]));
$txtAddress1 = str_replace("'", "\'", htmlentities($_POST["txtAddress1"]));
$txtAddress2 = str_replace("'", "\'", htmlentities($_POST["txtAddress2"]));
$txtCantidad = str_replace("'", "\'", htmlentities($_POST["txtCantidad"]));

$txtCellPhone = "";
$txtCellPhone1 = "";
$txtCellPhone2 = "";

$txtCity = str_replace("'", "\'", htmlentities($_POST["txtCity"]));
$txtCity1 = str_replace("'", "\'", htmlentities($_POST["txtCity1"]));
$txtCity2 = str_replace("'", "\'", htmlentities($_POST["txtCity2"]));

$txtCompany = str_replace("'", "\'", htmlentities($_POST["txtCompany"]));
$txtCompany1 = str_replace("'", "\'", htmlentities($_POST["txtCompany1"]));
$txtCompany2 = str_replace("'", "\'", htmlentities($_POST["txtCompany2"]));

$txtContact = str_replace("'", "\'", htmlentities($_POST["txtContact"]));
$txtContact1 = str_replace("'", "\'", htmlentities($_POST["txtContact1"]));
$txtContact2 = str_replace("'", "\'", htmlentities($_POST["txtContact2"]));

$txtCp = str_replace("'", "\'", htmlentities($_POST["txtCp"]));
$txtCp1 = str_replace("'", "\'", htmlentities($_POST["txtCp1"]));
$txtCp2 = str_replace("'", "\'", htmlentities($_POST["txtCp2"]));

$txtDescription = str_replace("'", "\'", htmlentities($_POST["txtDescription"]));
$txtInstructions = str_replace("'", "\'", htmlentities($_POST["txtInstructions"]));
$txtNoTransfer = str_replace("'", "\'", htmlentities($_POST["txtNoTransfer"]));
$txtPeso = str_replace("'", "\'", htmlentities($_POST["txtPeso"]));

$txtPhone = str_replace("'", "\'", htmlentities($_POST["txtPhone"]));
$txtPhone1 = str_replace("'", "\'", htmlentities($_POST["txtPhone1"]));
$txtPhone2 = str_replace("'", "\'", htmlentities($_POST["txtPhone2"]));

$txtProv = str_replace("'", "\'", htmlentities($_POST["txtProv"]));
$txtProv1 = str_replace("'", "\'", htmlentities($_POST["txtProv1"]));
$txtProv2 = str_replace("'", "\'", htmlentities($_POST["txtProv2"]));
$txtReference = str_replace("'", "\'", htmlentities($_POST["txtReference"]));
$txtSuite = str_replace("'", "\'", htmlentities($_POST["txtSuite"]));
$txtSuite1 = str_replace("'", "\'", htmlentities($_POST["txtSuite1"]));
$txtSuite2 = str_replace("'", "\'", htmlentities($_POST["txtSuite2"]));

$sLat = str_replace("'", "\'", htmlentities($_POST["sLat"]));
$sLon = str_replace("'", "\'", htmlentities($_POST["sLon"]));

$sLat1 = str_replace("'", "\'", htmlentities($_POST["sLat1"]));
$sLon1 = str_replace("'", "\'", htmlentities($_POST["sLon1"]));

$sLat2 = str_replace("'", "\'", htmlentities($_POST["sLat2"]));
$sLon2 = str_replace("'", "\'", htmlentities($_POST["sLon2"]));


$success = false;

$sql = "INSERT INTO `syswareo_haxpres`.`COMMANDS`
			(`IDTYPECOMAMAND`,
			`IDSCHEDULE`,
			`IDTYPETRUCK`,
			`IDCUSTOMER`,
			`IDSTATUS`,
			`IDUSER`,
			`CMCOMPANY`,
			`CMCONTAC`,
			`CMADDRESS`,
			`CMSUITE`,
			`CMCITY`,
			`CMPC`,
			`CMPHONE`,
			`CMCELLPHONE`,
			`CMCOMPANYDELIVERY`,
			`CMCONTACDELIVERY`,
			`CMADDRESSDELIVERY`,
			`CMSUITEDELIVERY`,
			`CMCITYDELIVERY`,
			`CMPCDELIVERY`,
			`CMPHONEDELIVERY`,
			`CMCELLPHONEDELIVERY`,
			`CMQUANTITY`,
			`CMWEIGHT`,
			`CMDESCRIPTION`,
			`CMREFERENCE`,
			`CMTRANSFER`,
			`CMINSTRUCTIONS`,
			`CMDATE`,
			`SUBSERVICES_IDSUBSERVICES`,
			`PROV`,
			`PROVDELIVERY`,
			`MERCHANDISE_IDMERCHANDISE`,
			`LATITUD`,
			`LONGITUD`,
			`LATITUDENT`,
			`LONGITUDENT`)
		VALUES
			({$idTipoOrden},
			{$cmbHorario},
			{$cmbTypeTruck},
			{$_SESSION["USUARIO"][0]['IDCUSTOMER']},
			(SELECT `STATUS`.`IDSTATUS`
			FROM `syswareo_haxpres`.`STATUS`
			WHERE `STATUS`.`INICIA` = 1 AND `STATUS`.`STATUS` = 1
			LIMIT 0, 1),
			{$_SESSION["USUARIO"][0]['IDUSER']},
			'{$txtCompany}',
			'{$txtContact}',
			'{$txtAddress}',
			'{$txtSuite}',
			'{$txtCity}',
			'{$txtCp}',
			'{$txtPhone}',
			'{$txtCellPhone}',
			'{$txtCompany1}',
			'{$txtContact1}',
			'{$txtAddress1}',
			'{$txtSuite1}',
			'{$txtCity1}',
			'{$txtCp1}',
			'{$txtPhone1}',
			'{$txtCellPhone1}',
			'{$txtCantidad}',
			'{$txtPeso}',
			'{$txtDescription}',
			'{$txtReference}',
			'{$txtNoTransfer}',
			'{$txtInstructions}',
			'{$sDate}',
			{$cmbService},
			'{$txtProv}',
			'{$txtProv1}',
			{$cmbMerchandise},
			'{$sLat}',
			'{$sLon}',
			'{$sLat1}',
			'{$sLon1}');";

if (mysqli_query($conexion, $sql)) {

	$iCommand = mysqli_insert_id($conexion);
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    exit();
}

$sql = "SELECT `TYPECOMMAND`.`TCCHANGECOLLECTIONPLACE`
		FROM `syswareo_haxpres`.`TYPECOMMAND`
		WHERE `TYPECOMMAND`.`IDTYPECOMAMAND` = {$idTipoOrden} AND `TYPECOMMAND`.`TCSTATUS` = 1;";

$registros = mysqli_query($conexion, $sql);
$error = mysqli_error($conexion);
echo $error;
if($error != "") {
	exit();
}

while($row = mysqli_fetch_assoc($registros)) {
	$rows[] = $row;
}
mysqli_free_result($registros);

if ($rows[0]["TCCHANGECOLLECTIONPLACE"] == 1) {
	$sql = "INSERT INTO `syswareo_haxpres`.`COMMANDS`
			(`IDTYPECOMAMAND`,
			`IDSCHEDULE`,
			`IDTYPETRUCK`,
			`IDCUSTOMER`,
			`IDSTATUS`,
			`IDUSER`,
			`CMCOMPANY`,
			`CMCONTAC`,
			`CMADDRESS`,
			`CMSUITE`,
			`CMCITY`,
			`CMPC`,
			`CMPHONE`,
			`CMCELLPHONE`,
			`CMCOMPANYDELIVERY`,
			`CMCONTACDELIVERY`,
			`CMADDRESSDELIVERY`,
			`CMSUITEDELIVERY`,
			`CMCITYDELIVERY`,
			`CMPCDELIVERY`,
			`CMPHONEDELIVERY`,
			`CMCELLPHONEDELIVERY`,
			`CMQUANTITY`,
			`CMWEIGHT`,
			`CMDESCRIPTION`,
			`CMREFERENCE`,
			`CMTRANSFER`,
			`CMINSTRUCTIONS`,
			`CMDATE`,
			`SUBSERVICES_IDSUBSERVICES`,
			`PROV`,
			`PROVDELIVERY`,
			`MERCHANDISE_IDMERCHANDISE`,
			`IDCOMMANDCHILD`,
			`LATITUD`,
			`LONGITUD`,
			`LATITUDENT`,
			`LONGITUDENT`)
		VALUES
			({$idTipoOrden},
			{$cmbHorario},
			{$cmbTypeTruck},
			{$_SESSION["USUARIO"][0]['IDCUSTOMER']},
			(SELECT `STATUS`.`IDSTATUS`
			FROM `syswareo_haxpres`.`STATUS`
			WHERE `STATUS`.`INICIA` = 1 AND `STATUS`.`STATUS` = 1
			LIMIT 0, 1),
			{$_SESSION["USUARIO"][0]['IDUSER']},
			'{$txtCompany1}',
			'{$txtContact1}',
			'{$txtAddress1}',
			'{$txtSuite1}',
			'{$txtCity1}',
			'{$txtCp1}',
			'{$txtPhone1}',
			'{$txtCellPhone1}',
			'{$txtCompany2}',
			'{$txtContact2}',
			'{$txtAddress2}',
			'{$txtSuite2}',
			'{$txtCity2}',
			'{$txtCp2}',
			'{$txtPhone2}',
			'{$txtCellPhone2}',
			'{$txtCantidad}',
			'{$txtPeso}',
			'{$txtDescription}',
			'{$txtReference}',
			'{$txtNoTransfer}',
			'{$txtInstructions}',
			'{$sDate}',
			{$cmbService},
			'{$txtProv1}',
			'{$txtProv2}',
			{$cmbMerchandise},
			{$iCommand},
			'{$sLat1}',
			'{$sLon1}',
			'{$sLat2}',
			'{$sLon2}');";
}

if (mysqli_query($conexion, $sql)) {
	if ($iCommand1 == 0) {
		$iCommand1 = mysqli_insert_id($conexion);
	}

    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    exit();
}

include '../configuration/closedb.php';

if ($success) {
	echo "<script type='text/javascript'>parent.closeToWindow({$iCommand});</script>";
}

ob_end_flush();
?>
