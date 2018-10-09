<?php
session_start();
header("Content-Type: application/json");	

include '../configuration/config.php';
include '../configuration/opendb.php';

$response = array();

if (!(isset($_SESSION["USUARIO"])) && ($_SESSION["USUARIO"] <> "")) {
	echo json_encode($response);
	exit();
}

$whereAll = "";

$limit = "";

$sJoinComplete = "";
$selectComplete = "";

$iTipoFiltro = htmlentities($_POST["iTipoFiltro"]);
$dFechaSemana = htmlentities($_POST["dFechaSemana"]);
$iSelectFiltro = htmlentities($_POST["iSelectFiltro"]);
$dFechaInicio = htmlentities($_POST["dFechaInicio"]);
$dFechaFinal = htmlentities($_POST["dFechaFinal"]);
$txtBusqueda = htmlentities($_POST["txtBusqueda"]);
$whereAllOtro = "";
$sOrderBy = "";
$bFiltroFechas = false;



if($_POST["btnCompleted"] == "true") {
	$whereAll = $whereAll . " AND (`STATUS`.`IDSTATUS` IN (SELECT `STATUS`.`IDSTATUS`
										FROM `syswareo_haxpres`.`STATUS`
										WHERE `STATUS`.`FINALIZA` = 1 AND `STATUS`.`STATUS` = 1)) ";
    $whereAllOtro = "";
	
	$limit = "";
	

	if($iTipoFiltro == 1) {
		if($dFechaSemana != "") {
			$time = strtotime(htmlentities($dFechaSemana));
			$sDateIni = date('Y-m-d',$time);
			$sDateEnd= date('Y-m-d', strtotime($sDateIni. ' + 7 days'));;
			//date_add($date, date_interval_create_from_date_string('7 days'));	

			//print($date);
			//$sDateEnd = $date->format('Y-m-d H:i:s');
			
			$whereAll = $whereAll . " AND ((SELECT `TRACINGS`.`TDATE`
										FROM `syswareo_haxpres`.`TRACINGS`
										WHERE `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
										ORDER BY `TRACINGS`.`IDTRACING` DESC
										LIMIT 0, 1) BETWEEN '{$sDateIni}' AND '{$sDateEnd}') ";
			$limit = "";
			$bFiltroFechas = true;
		}
	} else if($iTipoFiltro == 2) { 
		if($iSelectFiltro != "") {
			switch ($iSelectFiltro) {
				case "1":
					if ($dFechaInicio != "" || $dFechaFinal != "") {
						$sDateIni = date('Y-m-d', strtotime($dFechaInicio));	
						$sDateEnd = date('Y-m-d', strtotime($dFechaFinal));
						$whereAll = $whereAll . " AND ((SELECT `TRACINGS`.`TDATE`
														FROM `syswareo_haxpres`.`TRACINGS`
														WHERE `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
														ORDER BY `TRACINGS`.`IDTRACING` DESC
														LIMIT 0, 1) BETWEEN '{$sDateIni}' AND '{$sDateEnd}') ";
						$limit = "";
						$bFiltroFechas = true;
					}
					break;
				case "2":
					if ($txtBusqueda != "") {
						$whereAll = $whereAll . " AND (`DRIVERS`.`DNAME` LIKE '%{$txtBusqueda}%') ";
						$limit = "";
					}
					break;
				case "3":
					if ($txtBusqueda != "") {
						$whereAll = $whereAll . " AND (`CUSTOMERS`.`CNAME` LIKE '%{$txtBusqueda}%') ";
						$limit = "";
					}
					break;
				case "4":
					if ($txtBusqueda != "") {
						$whereAll = $whereAll . " AND (`COMMANDS`.`CMREFERENCE` LIKE '%{$txtBusqueda}%') ";
						$limit = "";
					}
					break;
				case "5":
					if ($txtBusqueda != "") {
						$whereAll = $whereAll . " AND ((`COMMANDS`.`CMCONTAC` LIKE '%{$txtBusqueda}%') OR (`COMMANDS`.`CMCONTACDELIVERY` LIKE '%{$txtBusqueda}%'))";
						$limit = "";
					}
					break;
			}
			
			
		}
	}
	
	if(!$bFiltroFechas) {
		
		$whereAll = $whereAll . " AND ((SELECT `TRACINGS`.`TDATE`
										FROM `syswareo_haxpres`.`TRACINGS`
										WHERE `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
										ORDER BY `TRACINGS`.`IDTRACING` DESC
										LIMIT 0, 1) BETWEEN (CASE WEEKDAY(NOW()) WHEN 0 THEN NOW() WHEN 1 THEN DATE_ADD(NOW(), INTERVAL -1 DAY) 
																	WHEN 2 THEN DATE_ADD(NOW(), INTERVAL -2 DAY) WHEN 3 THEN DATE_ADD(NOW(), INTERVAL -3 DAY)
																	WHEN 4 THEN DATE_ADD(NOW(), INTERVAL -4 DAY) WHEN 5 THEN DATE_ADD(NOW(), INTERVAL -5 DAY)
																	WHEN 6 THEN DATE_ADD(NOW(), INTERVAL -6 DAY) END) 
																AND (CASE WEEKDAY(NOW()) WHEN 6 THEN NOW() WHEN 5 THEN DATE_ADD(NOW(), INTERVAL 1 DAY)
																	WHEN 4 THEN DATE_ADD(NOW(), INTERVAL 2 DAY) WHEN 3 THEN DATE_ADD(NOW(), INTERVAL 3 DAY)
																	WHEN 2 THEN DATE_ADD(NOW(), INTERVAL 4 DAY) WHEN 1 THEN DATE_ADD(NOW(), INTERVAL 5 DAY)
																	WHEN 0 THEN DATE_ADD(NOW(), INTERVAL 6 DAY) END)) ";
		
		$limit = "";
	}
    
    $whereAllOtro = $whereAll;
	
	//$sJoinComplete = "LEFT JOIN `syswareo_haxpres`.`TRACINGS`					ON `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND `TRACINGS`.`IDSTATUS` = `STATUS`.`IDSTATUS`";
	
	$selectComplete = ",
                DATE_FORMAT(IFNULL((SELECT `TRACINGS`.`TDATE`
							FROM `syswareo_haxpres`.`TRACINGS`
							WHERE `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
							ORDER BY `TRACINGS`.`IDTRACING` DESC
							LIMIT 0, 1), `COMMANDS`.`CMDATE`), '%m/%d/%Y %H:%i') AS ENTREGA";
} else {

	$selectComplete = ",
						(SELECT `TRACINGS`.`TDATE`
							FROM `syswareo_haxpres`.`TRACINGS`
							WHERE `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
							ORDER BY `TRACINGS`.`IDTRACING` DESC
							LIMIT 0, 1) AS ENTREGA ";

	$whereAllOtro  = $whereAll . " AND (`STATUS`.`IDSTATUS` IN (SELECT `STATUS`.`IDSTATUS`
										FROM `syswareo_haxpres`.`STATUS`
										WHERE `STATUS`.`FINALIZA` = 1 AND `STATUS`.`STATUS` = 1)) 
			AND DATE_ADD((SELECT `TRACINGS`.`TDATE`
							FROM `syswareo_haxpres`.`TRACINGS`
							WHERE `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
							ORDER BY `TRACINGS`.`IDTRACING` DESC
							LIMIT 0, 1), INTERVAL (SELECT IFNULL(SSTATUS.`HORAS`, 0)
										FROM `syswareo_haxpres`.`STATUS` AS SSTATUS
										WHERE SSTATUS.`FINALIZA` = 1 AND SSTATUS.`STATUS` = 1 AND SSTATUS.`IDSTATUS` = `STATUS`.`IDSTATUS`) HOUR) > NOW()";
    $whereAll = $whereAll . " AND (`STATUS`.`IDSTATUS` IN (SELECT `STATUS`.`IDSTATUS`
					FROM `syswareo_haxpres`.`STATUS`
					WHERE `STATUS`.`FINALIZA` != 1 AND `STATUS`.`STATUS` = 1))";

	$sOrderBy = " ORDER BY (SELECT `TRACINGS`.`TDATE`
							FROM `syswareo_haxpres`.`TRACINGS`
							WHERE `TRACINGS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
							ORDER BY `TRACINGS`.`IDTRACING` DESC
							LIMIT 0, 1)";
}

if($_POST["iDriver"] != "0") { 
	$whereAll = $whereAll . " AND (`DRIVERS`.`IDDRIVER` = {$_POST["iDriver"]})";
}

if ($_SESSION["USUARIO"][0]['IDROLES'] == 1) {
	$sql = "SELECT * FROM (SELECT `COMMANDS`.`IDCOMMAND` AS iCommand,
				`CUSTOMERS`.`CNAME`,
				`SUBSERVICES`.`NAME`,
				`SUBSERVICES`.`COLOR` AS SCOLOR,
				`STATUS`.`SNAME` AS sStatus,
				`STATUS`.`COLOR`,
			    `TYPECOMMAND`.`TCNAME` AS sTypeCommand,
				`TYPECOMMAND`.`TCCOLOR`,
			    `COMMANDS`.`CMADDRESS` AS sAdress,
			    `COMMANDS`.`CMADDRESSDELIVERY`  AS sAdressDelivery,
				CASE 1 WHEN (
					SELECT SSTATUSDATA.`FINALIZA`
					FROM `syswareo_haxpres`.`STATUS` AS SSTATUSDATA
					WHERE SSTATUSDATA.`FINALIZA` = 1 AND SSTATUSDATA.`STATUS` = 1 
						AND SSTATUSDATA.`IDSTATUS` = `STATUS`.`IDSTATUS`) THEN DATE_FORMAT(`COMMANDS`.`CMDATE`, '%d-%m-%Y') 
				ELSE `SCHEDULES`.`SHDESCRIPTION` END AS sSchedule,
				CONCAT('$', FORMAT(IFNULL(`COMMANDS`.`PRECIO`, '0'), 2)) AS sPrecio,
				SUBSTRING(IFNULL(`DRIVERS`.`DNAME`, ''), LOCATE(' ', IFNULL(`DRIVERS`.`DNAME`, '')) + 1, LENGTH(IFNULL(`DRIVERS`.`DNAME`, ''))) AS sDriver,
				`COMMANDS`.`CMDATE`
				{$selectComplete}
			FROM `syswareo_haxpres`.`COMMANDS`	
				INNER JOIN`syswareo_haxpres`.`STATUS`
					ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`
					ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				INNER JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				INNER JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				INNER JOIN `syswareo_haxpres`.`CUSTOMERS` 
					ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
				INNER JOIN `syswareo_haxpres`.`SUBSERVICES` 
					ON `SUBSERVICES`.`IDSUBSERVICES` = `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`
				{$sJoinComplete}
			WHERE `TYPECOMMAND`.`TCSTATUS` = 1 AND `SCHEDULES`.`STATUS` = 1 AND `STATUS`.`STATUS` = 1 AND `SUBSERVICES`.`STATUS` = 1
				AND IFNULL(`DRIVERS`.`STATUS`, 1) = 1 AND `CUSTOMERS`.`STATUS` = 1
			{$whereAll}
			{$limit} 
            UNION 
            SELECT `COMMANDS`.`IDCOMMAND` AS iCommand,
				`CUSTOMERS`.`CNAME`,
				`SUBSERVICES`.`NAME`,
				`SUBSERVICES`.`COLOR` AS SCOLOR,
				`STATUS`.`SNAME` AS sStatus,
				`STATUS`.`COLOR`,
			    `TYPECOMMAND`.`TCNAME` AS sTypeCommand,
				`TYPECOMMAND`.`TCCOLOR`,
			    `COMMANDS`.`CMADDRESS` AS sAdress,
			    `COMMANDS`.`CMADDRESSDELIVERY`  AS sAdressDelivery,
			    CASE 1 WHEN (
					SELECT SSTATUSDATA.`FINALIZA`
					FROM `syswareo_haxpres`.`STATUS` AS SSTATUSDATA
					WHERE SSTATUSDATA.`FINALIZA` = 1 AND SSTATUSDATA.`STATUS` = 1 
						AND SSTATUSDATA.`IDSTATUS` = `STATUS`.`IDSTATUS`) THEN DATE_FORMAT(`COMMANDS`.`CMDATE`, '%d-%m-%Y') 
				ELSE `SCHEDULES`.`SHDESCRIPTION` END AS sSchedule,
				CONCAT('$', FORMAT(IFNULL(`COMMANDS`.`PRECIO`, '0'), 2)) AS sPrecio,
				SUBSTRING(IFNULL(`DRIVERS`.`DNAME`, ''), LOCATE(' ', IFNULL(`DRIVERS`.`DNAME`, '')) + 1, LENGTH(IFNULL(`DRIVERS`.`DNAME`, ''))) AS sDriver,
				`COMMANDS`.`CMDATE`
				{$selectComplete}
			FROM `syswareo_haxpres`.`COMMANDS`	
				INNER JOIN`syswareo_haxpres`.`STATUS`
					ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`
					ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				INNER JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				INNER JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				INNER JOIN `syswareo_haxpres`.`CUSTOMERS` 
					ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
				INNER JOIN `syswareo_haxpres`.`SUBSERVICES` 
					ON `SUBSERVICES`.`IDSUBSERVICES` = `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`
				{$sJoinComplete}
			WHERE `TYPECOMMAND`.`TCSTATUS` = 1 AND `SCHEDULES`.`STATUS` = 1 AND `STATUS`.`STATUS` = 1 AND `SUBSERVICES`.`STATUS` = 1
				AND IFNULL(`DRIVERS`.`STATUS`, 1) = 1 AND `CUSTOMERS`.`STATUS` = 1
			{$whereAllOtro}
			{$limit}) AS A
			ORDER BY CMDATE DESC;";
            
        
    
} else {
	$sql = "SELECT * FROM (SELECT `COMMANDS`.`IDCOMMAND` AS iCommand,
				`CUSTOMERS`.`CNAME`,
				`SUBSERVICES`.`NAME`,
				`SUBSERVICES`.`COLOR` AS SCOLOR,
				`STATUS`.`SNAME` AS sStatus,
				`STATUS`.`COLOR`,
			    `TYPECOMMAND`.`TCNAME` AS sTypeCommand,
				`TYPECOMMAND`.`TCCOLOR`,
			    `COMMANDS`.`CMADDRESS` AS sAdress,
			    `COMMANDS`.`CMADDRESSDELIVERY`  AS sAdressDelivery,
			    `SCHEDULES`.`SHDESCRIPTION` AS sReady,
			    CASE 1 WHEN (
					SELECT SSTATUSDATA.`FINALIZA`
					FROM `syswareo_haxpres`.`STATUS` AS SSTATUSDATA
					WHERE SSTATUSDATA.`FINALIZA` = 1 AND SSTATUSDATA.`STATUS` = 1 
						AND SSTATUSDATA.`IDSTATUS` = `STATUS`.`IDSTATUS`) THEN DATE_FORMAT(`COMMANDS`.`CMDATE`, '%d-%m-%Y') 
				ELSE SUBSTRING(`SCHEDULES`.`SHDESCRIPTION`, LOCATE(' ', `SCHEDULES`.`SHDESCRIPTION`) + 1, LENGTH(`SCHEDULES`.`SHDESCRIPTION`)) END AS sSchedule,
				CONCAT('$', FORMAT(IFNULL(`COMMANDS`.`PRECIO`, '0'), 2)) AS sPrecio,
				SUBSTRING(IFNULL(`DRIVERS`.`DNAME`, ''), LOCATE(' ', IFNULL(`DRIVERS`.`DNAME`, '')) + 1, LENGTH(IFNULL(`DRIVERS`.`DNAME`, ''))) AS sDriver,
				`COMMANDS`.`CMDATE`
				{$selectComplete}
			FROM `syswareo_haxpres`.`COMMANDS`
				INNER JOIN`syswareo_haxpres`.`STATUS`
					ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`
					ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				LEFT JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				LEFT JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				INNER JOIN `syswareo_haxpres`.`CUSTOMERS` 
					ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
				INNER JOIN `syswareo_haxpres`.`SUBSERVICES` 
					ON `SUBSERVICES`.`IDSUBSERVICES` = `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`
				{$sJoinComplete}
			WHERE `TYPECOMMAND`.`TCSTATUS` = 1 AND `SCHEDULES`.`STATUS` = 1  AND `STATUS`.`STATUS` = 1 AND `SUBSERVICES`.`STATUS` = 1
				AND `COMMANDS`.`IDCUSTOMER` = {$_SESSION["USUARIO"][0]['IDCUSTOMER']}
				AND IFNULL(`DRIVERS`.`STATUS`, 1) = 1 AND `CUSTOMERS`.`STATUS` = 1
				{$whereAll}
				{$limit}
            UNION
            SELECT `COMMANDS`.`IDCOMMAND` AS iCommand,
				`CUSTOMERS`.`CNAME`,
				`SUBSERVICES`.`NAME`,
				`SUBSERVICES`.`COLOR` AS SCOLOR,
				`STATUS`.`SNAME` AS sStatus,
				`STATUS`.`COLOR`,
			    `TYPECOMMAND`.`TCNAME` AS sTypeCommand,
				`TYPECOMMAND`.`TCCOLOR`,
			    `COMMANDS`.`CMADDRESS` AS sAdress,
			    `COMMANDS`.`CMADDRESSDELIVERY`  AS sAdressDelivery,
			    `SCHEDULES`.`SHDESCRIPTION` AS sReady,
			    CASE 1 WHEN (
					SELECT SSTATUSDATA.`FINALIZA`
					FROM `syswareo_haxpres`.`STATUS` AS SSTATUSDATA
					WHERE SSTATUSDATA.`FINALIZA` = 1 AND SSTATUSDATA.`STATUS` = 1 
						AND SSTATUSDATA.`IDSTATUS` = `STATUS`.`IDSTATUS`) THEN DATE_FORMAT(`COMMANDS`.`CMDATE`, '%d-%m-%Y') 
				ELSE SUBSTRING(`SCHEDULES`.`SHDESCRIPTION`, LOCATE(' ', `SCHEDULES`.`SHDESCRIPTION`) + 1, LENGTH(`SCHEDULES`.`SHDESCRIPTION`)) END AS sSchedule,
				CONCAT('$', FORMAT(IFNULL(`COMMANDS`.`PRECIO`, '0'), 2)) AS sPrecio,
				SUBSTRING(IFNULL(`DRIVERS`.`DNAME`, ''), LOCATE(' ', IFNULL(`DRIVERS`.`DNAME`, '')) + 1, LENGTH(IFNULL(`DRIVERS`.`DNAME`, ''))) AS sDriver,
				`COMMANDS`.`CMDATE`
				{$selectComplete}
			FROM `syswareo_haxpres`.`COMMANDS`
				INNER JOIN`syswareo_haxpres`.`STATUS`
					ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`
					ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				LEFT JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				LEFT JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				INNER JOIN `syswareo_haxpres`.`CUSTOMERS` 
					ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
				INNER JOIN `syswareo_haxpres`.`SUBSERVICES` 
					ON `SUBSERVICES`.`IDSUBSERVICES` = `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`
				{$sJoinComplete}
			WHERE `TYPECOMMAND`.`TCSTATUS` = 1 AND `SCHEDULES`.`STATUS` = 1 AND `STATUS`.`STATUS` = 1 AND `SUBSERVICES`.`STATUS` = 1
				AND `COMMANDS`.`IDCUSTOMER` = {$_SESSION["USUARIO"][0]['IDCUSTOMER']}
				AND IFNULL(`DRIVERS`.`STATUS`, 1) = 1 AND `CUSTOMERS`.`STATUS` = 1
				{$whereAllOtro}
				{$limit}) AS A
				ORDER BY ENTREGA DESC;";
}

$registros = mysqli_query($conexion,$sql);
$error = mysqli_error($conexion);
	
while($row = mysqli_fetch_assoc($registros)) {
	$response[] = $row;
}
	
mysqli_free_result($registros);
	
include '../configuration/closedb.php';


echo html_entity_decode(json_encode($response));

?>