<?php

include '../configuration/config.php';
include '../configuration/opendb.php';

$success = false;
$error   = "";
$sql     = "SELECT `COMMANDS`.`IDCOMMAND`,
				`COMMANDS`.`CMADDRESS`,
				`COMMANDS`.`CMADDRESSDELIVERY`,
				`COMMANDS`.`LATITUD`,
				`COMMANDS`.`LONGITUD`,
				`COMMANDS`.`LATITUDENT`,
				`COMMANDS`.`LONGITUDENT`
			FROM `syswareo_haxpres`.`COMMANDS`
			WHERE `COMMANDS`.`IDCOMMAND` = {$_REQUEST['idCommand']};";

$registros = mysqli_query($conexion, $sql);
$error     = mysqli_error($conexion);

while ($row = mysqli_fetch_assoc($registros)) {
    $response[] = $row;
}

include '../configuration/closedb.php';

header("Content-Type: application/json");
echo json_encode($response);

?>