<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$sName = htmlspecialchars($_POST["txtName"]);
$idSchedule = htmlspecialchars($_POST["idSchedule"]);

$success = false;

if($idSchedule != 0){
	$sql = "UPDATE `syswareo_haxpres`.`SCHEDULES`
			SET
				`SHDESCRIPTION` = '{$sName}'
			WHERE `IDSCHEDULE` = {$idSchedule};";
} else {
	$sql = "INSERT INTO `syswareo_haxpres`.`SCHEDULES`
				(`SHDESCRIPTION`)
			VALUES
				('{$sName}');";
}


if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';	

if ($success) {
	header("Location:../../es/application/schedules/index.php"); 
}

ob_end_flush();
?>