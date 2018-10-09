<?php 
	
	header("Access-Control-Allow-Origin: *");
    header('Content-Type: text/html; charset=utf-8');

    $jsondata = "php://input";
    $phpjsonstring = file_get_contents($jsondata);
    $data = json_decode($phpjsonstring, true);
		
	include '../configuration/config.php';
	include '../configuration/opendb.php';	

	$rows = array();
	$sql = "SELECT `COMMANDS`.`IDCOMMAND` AS iCommand,
			    `TYPECOMMAND`.`TCNAME` AS sTypeCommand,
                `TYPECOMMAND`.`TCCOLOR` AS sTypeCommandColor,
                `SUBSERVICES`.`NAME` AS sSubservices,
                `SUBSERVICES`.`COLOR` AS sSubservicesColor,
			    `SCHEDULES`.`SHDESCRIPTION` AS sSchedule,
			    `TYPETRUCK`.`TTNAME` AS sTypeTruck,
			    `CUSTOMERS`.`CNAME` AS sCustomer,
			    `COMMANDS`.`IDSTATUS` AS iEstatus,
			    `COMMANDS`.`CMCOMPANY` AS sCompany,
			    `COMMANDS`.`CMCONTAC` AS sContact,
			    `COMMANDS`.`CMADDRESS` AS sAddress,
			    `COMMANDS`.`CMSUITE` AS sSuite,
			    `COMMANDS`.`CMCITY` AS sCity,
			    `COMMANDS`.`CMPC` AS sCP,
			    `COMMANDS`.`CMPHONE` AS sPhone,
			    `COMMANDS`.`CMCELLPHONE` AS sCellPhone,
			    `COMMANDS`.`CMCOMPANYDELIVERY` AS sCompanyDelivery,
			    `COMMANDS`.`CMCONTACDELIVERY` AS sContactDelivery,
			    `COMMANDS`.`CMADDRESSDELIVERY` AS sAddressDelivery,
			    `COMMANDS`.`CMSUITEDELIVERY` AS sSuiteDelivery,
			    `COMMANDS`.`CMCITYDELIVERY` AS sCityDelivery,
			    `COMMANDS`.`CMPCDELIVERY` AS sCPDelivery,
			    `COMMANDS`.`CMPHONEDELIVERY` AS sPhoneDelivery,
			    `COMMANDS`.`CMCELLPHONEDELIVERY` AS sCellPhoneDelivery,
			    `COMMANDS`.`CMQUANTITY` AS sQuanty,
			    `COMMANDS`.`CMWEIGHT` AS sWeight,
			    `COMMANDS`.`CMDESCRIPTION` AS sDescription,
			    `COMMANDS`.`CMREFERENCE` AS sReference,
			    `COMMANDS`.`CMTRANSFER` AS sTransfer,
			    `COMMANDS`.`CMINSTRUCTIONS` AS sInstruction,
			    DATE_FORMAT(`COMMANDS`.`CMDATE`,'%d/%m/%Y') AS sDate,
                `STATUS`.`COLOR` AS sColor,
                `STATUS`.`SNAME` AS sStatus
			FROM `syswareo_haxpres`.`COMMANDS`	
				INNER JOIN`syswareo_haxpres`.`STATUS` ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND` ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES` ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				INNER JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				INNER JOIN `syswareo_haxpres`.`DRIVERS` ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				INNER JOIN `syswareo_haxpres`.`CUSTOMERS` ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
				INNER JOIN `syswareo_haxpres`.`SUBSERVICES` ON `SUBSERVICES`.`IDSUBSERVICES` = `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`
                INNER JOIN `syswareo_haxpres`.`TYPETRUCK` ON `TYPETRUCK`.`IDTYPETRUCK` = `COMMANDS`.`IDTYPETRUCK`
	WHERE `CUSTOMERS`.`STATUS` = 1 AND `TYPECOMMAND`.`TCSTATUS` = 1 AND `SCHEDULES`.`STATUS` = 1 AND `STATUS`.`STATUS` = 1 AND `SUBSERVICES`.`STATUS` = 1
				AND `DRIVERS`.`STATUS` = 1 AND `STATUS`.`IDSTATUS` IN(SELECT `STATUS`.`IDSTATUS` FROM `syswareo_haxpres`.`STATUS` WHERE `STATUS`.`STATUS` = 1 AND `STATUS`.`FINALIZA` = 0)  
				AND `FK_COMMANDS_DRIVERS`.`IDDRIVER` = '{$data["iDriver"]}';";

	$registros = mysqli_query($conexion,$sql);
	$error = mysqli_error($conexion);
	$rowCount = mysqli_num_rows($registros);

	while($row = mysqli_fetch_assoc($registros)) {
		$rows[] = $row;
	}

	mysqli_free_result($registros);
	
	include '../configuration/closedb.php';

	header("Content-Type: application/json");	
	echo html_entity_decode(json_encode($rows));

?>	