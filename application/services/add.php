<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';	

$iRegistro = htmlspecialchars($_POST["iService"]);
$sRegistro = htmlspecialchars($_POST["txtService"]);
$btnColor = htmlspecialchars($_POST["btnColor"]);

$bCambio = 0;
if (isset($_POST["chkCambio"])) {
	$bCambio = 1;
}

$chkSalida = 0;
if (isset($_POST["chkSalida"])) {
	$chkSalida = 1;
}

$chkEntrega = 0;
if (isset($_POST["chkEntrega"])) {
	$chkEntrega = 1;
}

$chkRetorno = 0;
if (isset($_POST["chkRetorno"])) {
	$chkRetorno = 1;
}

$success = false;

if($iRegistro != 0){
	$sql = "UPDATE `syswareo_haxpres`.`TYPECOMMAND`
			SET
				`TCNAME` = '{$sRegistro}',
				`TCCOLOR` = '{$btnColor}',
				`TCCHANGECOLLECTIONPLACE` = '{$bCambio}',
				`CHDIRSALIDA` = '{$chkSalida}',
				`CHDIRENTREGA` = '{$chkEntrega}',
				`CHDIRRETORNO` = '{$chkRetorno}'
			WHERE `IDTYPECOMAMAND` = {$iRegistro};";
} else {
	$sql = "INSERT INTO `syswareo_haxpres`.`TYPECOMMAND`
				(`TCNAME`,
				`TCCOLOR`,
				`TCCHANGECOLLECTIONPLACE`,
				`CHDIRSALIDA`,
				`CHDIRENTREGA`,
				`CHDIRRETORNO`)
			VALUES
				('{$sRegistro}',
				'{$btnColor}',
				'{$bCambio}',
				'{$chkSalida}',
				'{$chkEntrega}',
				'{$chkRetorno}');";
}


if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';	

if ($success) {
	header("Location:../../es/application/services/index.php"); 
}

ob_end_flush();
?>