<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$iRegistro = htmlspecialchars($_POST["cmbServices"]);
$iSubRegistro = htmlspecialchars($_POST["iSubService"]);
$btnColor = htmlspecialchars($_POST["btnColor"]);
$cmbSchedules = "NULL";

if (htmlspecialchars($_POST["cmbSchedules"]) != "") {
	$cmbSchedules = htmlspecialchars($_POST["cmbSchedules"]);
}

$sSubRegistro = htmlspecialchars($_POST["txtSubService"]);

$success = false;

if($iSubRegistro != 0){
	$sql = "UPDATE `syswareo_haxpres`.`SUBSERVICES`
			SET
				`NAME` = '{$sSubRegistro}',
				`COLOR` = '{$btnColor}',
				`SCHEDULES_IDSCHEDULE` = '{$cmbSchedules}',
				`TYPECOMMAND_IDTYPECOMAMAND` = {$iRegistro}
			WHERE `IDSUBSERVICES` = {$iSubRegistro};";
} else {
	$sql = "INSERT INTO `syswareo_haxpres`.`SUBSERVICES`
				(`NAME`,
				`COLOR`,
				`SCHEDULES_IDSCHEDULE`,
				`TYPECOMMAND_IDTYPECOMAMAND`)
			VALUES
				('{$sSubRegistro}',
				'{$btnColor}',
				{$cmbSchedules},
				{$iRegistro});";
}


if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';	

if ($success) {
	header("Location:../../es/application/subservices/index.php"); 
}

ob_end_flush();
?>