<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$sName = htmlspecialchars($_POST["txtName"]);
$idTypeTruck = htmlspecialchars($_POST["idTupeTruck"]);

$success = false;

if($idTypeTruck != 0){
	$sql = "UPDATE `syswareo_haxpres`.`TYPETRUCK`
			SET
				`TTNAME` = '{$sName}'
			WHERE `IDTYPETRUCK` = {$idTypeTruck};";
} else {
	$sql = "INSERT INTO `syswareo_haxpres`.`TYPETRUCK`
				(`TTNAME`)
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
	header("Location:../../es/application/typetrucks/index.php"); 
}

ob_end_flush();
?>