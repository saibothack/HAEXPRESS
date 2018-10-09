<?php
ob_start();
session_start();
session_destroy();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';

 
$response = array();

$sUsuario = htmlspecialchars($_POST["txtEmail"]);
$sPassword = htmlspecialchars($_POST["txtPassword"]);

if (($sUsuario == "") && ($sPassword == "")) {
	$response = array(
        'success' => false,
        'message' => 'Por favor ingrese los datos obligatorios'
    );
} else {
	$sql = "SELECT `USERS`.`IDUSER`,
				`USERS`.`IDROLES`,
				`USERS`.`IDCUSTOMER`,
				`USERS`.`UNAME`,
				`USERS`.`UEMAIL`,
				`USERS`.`UPASSWORD`,
				`USERS`.`UCREATIONDATE`
			FROM `syswareo_haxpres`.`USERS`
			WHERE `USERS`.`UEMAIL` = '{$sUsuario}' AND
				`USERS`.`UPASSWORD` = '{$sPassword}';";	
	
	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);
	
	while($row = mysqli_fetch_assoc($registros)) {
		$_SESSION["USUARIO"][] = $row;
	}
	
	mysqli_free_result($registros);
	
	if ($rowCount > 0) {
		$response = array(
			'success' => true,
			'message' => ''
		);
	} else {
		$response = array(
			'success' => false,
			'message' => 'Por favor ingrese los datos obligatorios'
		);
	}
}
include '../configuration/closedb.php';

header("Content-Type: application/json");	
echo json_encode($response);
ob_end_flush();
?>