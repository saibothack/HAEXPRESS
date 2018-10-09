<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$iRegistro = htmlspecialchars($_POST["iStatus"]);
$sRegistro = htmlspecialchars($_POST["txtStatus"]);
$sColor = htmlspecialchars($_POST["btnColor"]);
$sHoras = htmlspecialchars($_POST["txtHorasVisibles"]);
$sFinaliza = 0;
$sInicia = 0;
$sGeocerca = 0;

if(isset($_POST["chkFinal"])) {
	if($_POST["chkFinal"] == "on") {
		$sFinaliza = 1;	
	}
}

if(isset($_POST["chkInicia"])) {
	if($_POST["chkInicia"] == "on") {
		$sInicia = 1;	
	}
}

if(isset($_POST["chkGeocerca"])) {
	if($_POST["chkGeocerca"] == "on") {
		$sGeocerca = 1;	
	}
}

$success = false;

if($iRegistro != 0){
	$sql = "UPDATE `syswareo_haxpres`.`STATUS`
			SET
				`SNAME` = '{$sRegistro}',
				`COLOR` = '{$sColor}',
				`HORAS` = '{$sHoras}',
				`FINALIZA` = {$sFinaliza},
				`INICIA` = {$sInicia},
				`GEOCERCA` = {$sGeocerca}
			WHERE `IDSTATUS` = {$iRegistro};";
} else {
	$sql = "INSERT INTO `syswareo_haxpres`.`STATUS`
				(`SNAME`,
				`COLOR`,
				`HORAS`,
				`FINALIZA`,
				`INICIA`,
				`GEOCERCA`)
			VALUES
				('{$sRegistro}',
				'{$sColor}',
				'{$sHoras}',
				{$sFinaliza},
				{$sInicia},
				{$sGeocerca});";
	
}


if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';	

if ($success) {
	header("Location:../../es/application/status/index.php"); 
}

ob_end_flush();
?>