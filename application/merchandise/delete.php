<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$iRegistro = htmlspecialchars($_POST["aRecords"]);

$bCambio = 0;
if (isset($_POST["chkCambio"])) {
	$bCambio = 1;
}

$success = false;
$error = "";

$sql = "UPDATE `syswareo_haxpres`.`TYPECOMMAND`
		SET
			`TCSTATUS` = 0
		WHERE `IDTYPECOMAMAND` in ({$iRegistro});";

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    $error = "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';	

$response = array('success' => $success, 'message' => $error);
header("Content-Type: application/json");	
echo json_encode($response);

ob_end_flush();
?>