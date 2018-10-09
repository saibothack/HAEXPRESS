<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$sNumber = htmlspecialchars($_POST["txtNumber"]);
$sName = htmlspecialchars($_POST["txtName"]);
$sAddress = htmlspecialchars($_POST["txtAddress"]);
$sPhone = htmlspecialchars($_POST["txtPhone"]);
$sLicense = htmlspecialchars($_POST["txtLincense"]);
$sEmail = htmlspecialchars($_POST["txtEmail"]);
$idDriver = htmlspecialchars($_POST["idDriver"]);

$success = false;

if($idDriver != 0){
	$sql = "UPDATE `syswareo_haxpres`.`DRIVERS`
			SET
				`DNUMBER` = '{$sNumber}',
				`DNAME` = '{$sName}',
				`DADDRESS` = '{$sAddress}',
				`DPHONE` = '{$sPhone}',
				`DLICENCE` = '{$sLicense}',
				`DEMAIL` = '{$sEmail}'
			WHERE `IDDRIVER` = {$idDriver};";
} else {
	$sql = "INSERT INTO `syswareo_haxpres`.`DRIVERS`
				(`DNUMBER`,
				`DNAME`,
				`DADDRESS`,
				`DPHONE`,
				`DLICENCE`,
				`DEMAIL`)
				VALUES
				('{$sNumber}',
				'{$sName}',
				'{$sAddress}',
				'{$sPhone}',
				'{$sLicense}',
				'{$sEmail}');";
}


if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';	

if ($success) {
	header("Location:../../es/application/drivers/index.php"); 
}

ob_end_flush();
?>