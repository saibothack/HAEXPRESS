<?php

include '../../../application/configuration/config.php';
include '../../../application/configuration/opendb.php';

$rows = array();

$sql = "SELECT * FROM (SELECT `NOTIFICATIONS`.`IDNOTIFICATION`,
			`CUSTOMERS`.`CNAME`,
			`STATUS`.`IDSTATUS`,
		    `STATUS`.`SNAME`,
			`COMMANDS`.`IDCOMMAND`,
			DATE_FORMAT(`TRACINGS`.`TDATE`,'%d/%m/%Y') AS TDATE,
		    `DRIVERS`.`DNAME`
		FROM `syswareo_haxpres`.`NOTIFICATIONS`
			INNER JOIN `syswareo_haxpres`.`TRACINGS` ON `NOTIFICATIONS`.`TRACINGS_IDTRACING` = `TRACINGS`.`IDTRACING`
		    INNER JOIN `syswareo_haxpres`.`COMMANDS` ON `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
		    INNER JOIN `syswareo_haxpres`.`STATUS` ON `STATUS`.`IDSTATUS` = `TRACINGS`.`IDSTATUS`
		    INNER JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
		    INNER JOIN `syswareo_haxpres`.`DRIVERS` ON  `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
		    INNER JOIN `syswareo_haxpres`.`CUSTOMERS` ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
		WHERE `NOTIFICATIONS`.`USERS_IDUSER` = {$_SESSION["USUARIO"][0]["IDUSER"]} 
			AND `CUSTOMERS`.`STATUS` = 1 AND `NOTIFICATIONS`.`SHOW` = 0 
		UNION 
		SELECT `NOTIFICATIONS`.`IDNOTIFICATION`,
			`CUSTOMERS`.`CNAME`,
			`STATUS`.`IDSTATUS`,
		    `STATUS`.`SNAME`,
			`COMMANDS`.`IDCOMMAND`,
			DATE_FORMAT(`TRACINGS`.`TDATE`,'%d/%m/%Y') AS TDATE,
		    `DRIVERS`.`DNAME`
		FROM `syswareo_haxpres`.`NOTIFICATIONS`
			INNER JOIN `syswareo_haxpres`.`TRACINGS` ON `NOTIFICATIONS`.`TRACINGS_IDTRACING` = `TRACINGS`.`IDTRACING`
		    INNER JOIN `syswareo_haxpres`.`COMMANDS` ON `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
		    INNER JOIN `syswareo_haxpres`.`STATUS` ON `STATUS`.`IDSTATUS` = `TRACINGS`.`IDSTATUS`
		    INNER JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
		    INNER JOIN `syswareo_haxpres`.`DRIVERS` ON  `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
		    INNER JOIN `syswareo_haxpres`.`CUSTOMERS` ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
		WHERE `NOTIFICATIONS`.`USERS_IDUSER` = {$_SESSION["USUARIO"][0]["IDUSER"]} 
			AND (DATE_FORMAT(`NOTIFICATIONS`.`CREATIONDATE`, '%d/%m/%Y') BETWEEN DATE_FORMAT(CURRENT_TIMESTAMP(), '%d/%m/%Y') AND DATE_FORMAT(DATE_ADD(CURRENT_TIMESTAMP() ,INTERVAL 1 DAY), '%d/%m/%Y')) AND `CUSTOMERS`.`STATUS` = 1 AND `NOTIFICATIONS`.`SHOW` = 1) AS A
		ORDER BY IDNOTIFICATION DESC;";

$registros = mysqli_query($conexion, $sql);
$error     = mysqli_error($conexion);

while ($row = mysqli_fetch_assoc($registros)) {
    $rows[] = $row;
}

$sqlInsertNotification = "UPDATE `syswareo_haxpres`.`NOTIFICATIONS` SET `SHOW` = 1 WHERE `NOTIFICATIONS`.`USERS_IDUSER` = {$_SESSION["USUARIO"][0]["IDUSER"]}";
mysqli_query($conexion, $sqlInsertNotification);
$error = mysqli_error($conexion);
if ($error != "") {
	print($error);
	exit();
}

mysqli_free_result($registros);

include '../../../application/configuration/closedb.php';

?>