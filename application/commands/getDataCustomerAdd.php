<?php

include '../../../application/configuration/config.php';
include '../../../application/configuration/opendb.php';

$response = array();

if (!(isset($_SESSION["USUARIO"])) && ($_SESSION["USUARIO"] <> "")) {
	echo json_encode($response);
	exit();
}

	$sql = "SELECT `CUSTOMERS`.`CNAME`,
				`CUSTOMERS`.`CADDRESS`,
				`CUSTOMERS`.`CSUITE`,
				`CUSTOMERS`.`CCITY`,
				`CUSTOMERS`.`CCP`,
				`CUSTOMERS`.`LATITUD`,
				`CUSTOMERS`.`LONGITUD`,
                `CUSTOMERS`.`CPHONE`,
                `USERS`.`UNAME`
			FROM `syswareo_haxpres`.`CUSTOMERS`
				INNER JOIN `syswareo_haxpres`.`USERS` ON `USERS`.`IDCUSTOMER` = `CUSTOMERS`.`IDCUSTOMER`
			WHERE `CUSTOMERS`.`IDCUSTOMER` = {$_SESSION["USUARIO"][0]['IDCUSTOMER']} 
				AND `CUSTOMERS`.`STATUS` = 1 AND `USERS`.`IDUSER` = {$_SESSION["USUARIO"][0]['IDUSER']};";

$registros = mysqli_query($conexion,$sql);
$error = mysqli_error($conexion);
	
while($row = mysqli_fetch_assoc($registros)) {
	$response = $row;
}
	
mysqli_free_result($registros);
	
include '../../../application/configuration/closedb.php';

?>