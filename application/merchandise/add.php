<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$iRegistro = htmlspecialchars($_POST["iMerchandise"]);
$sRegistro = htmlspecialchars($_POST["txtMerchandise"]);

$bCambio = 0;
if (isset($_POST["chkCambio"])) {
	$bCambio = 1;
}

$success = false;

if($iRegistro != 0){
	$sql = "UPDATE `syswareo_haxpres`.`MERCHANDISE`
			SET
				`NAME` = '{$sRegistro}'
			WHERE `IDMERCHANDISE` = {$iRegistro};";
} else {
	$sql = "INSERT INTO `syswareo_haxpres`.`MERCHANDISE`
				(`NAME`)
			VALUES
				('{$sRegistro}');";
}


if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';	

if ($success) {
	header("Location:../../es/application/merchandise/index.php"); 
}

ob_end_flush();
?>