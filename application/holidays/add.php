<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$sDate = htmlspecialchars($_POST["txtDate"]);
$idDate = htmlspecialchars($_POST["idHoliday"]);

$success = false;

if($idDate != 0){
	$sql = "UPDATE `syswareo_haxpres`.`HOLIDAYS`
			SET
				`HNAME` = '{$sDate}'
			WHERE `IDHOLIDAY` = {$idDate};";
} else {
	$sql = "INSERT INTO `syswareo_haxpres`.`HOLIDAYS`
				(`HNAME`)
			VALUES
				('{$sDate}');";
}


if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';	

if ($success) {
	header("Location:../../es/application/holidays/index.php"); 
}

ob_end_flush();
?>