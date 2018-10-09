<?php

include '../configuration/config.php';
include '../configuration/opendb.php';

$success = false;
$error   = "";
$sql     = "SELECT `COMMANDS`.`IDCOMMAND`,
				    `COMMANDS`.`IDTYPECOMAMAND`,
                    `TYPECOMMAND`.`TCNAME`,
                    `TYPECOMMAND`.`TCCHANGECOLLECTIONPLACE`,
					`TYPECOMMAND`.`TCCOLOR`,
				    `COMMANDS`.`IDSCHEDULE`,
				    `COMMANDS`.`IDTYPETRUCK`,
				    `COMMANDS`.`IDCUSTOMER`,
				    `COMMANDS`.`IDSTATUS`,
                    `STATUS`.`SNAME`,
					`STATUS`.`COLOR`,
				    `COMMANDS`.`IDUSER`,
				    `COMMANDS`.`CMCOMPANY`,
				    `COMMANDS`.`CMCONTAC`,
				    `COMMANDS`.`CMADDRESS`,
				    `COMMANDS`.`CMSUITE`,
				    `COMMANDS`.`CMCITY`,
				    `COMMANDS`.`CMPC`,
				    `COMMANDS`.`CMPHONE`,
				    `COMMANDS`.`CMCELLPHONE`,
				    `COMMANDS`.`CMCOMPANYDELIVERY`,
				    `COMMANDS`.`CMCONTACDELIVERY`,
				    `COMMANDS`.`CMADDRESSDELIVERY`,
				    `COMMANDS`.`CMSUITEDELIVERY`,
				    `COMMANDS`.`CMCITYDELIVERY`,
				    `COMMANDS`.`CMPCDELIVERY`,
				    `COMMANDS`.`CMPHONEDELIVERY`,
				    `COMMANDS`.`CMCELLPHONEDELIVERY`,
				    `COMMANDS`.`CMQUANTITY`,
				    `COMMANDS`.`CMWEIGHT`,
				    `COMMANDS`.`CMDESCRIPTION`,
				    `COMMANDS`.`CMREFERENCE`,
				    `COMMANDS`.`CMTRANSFER`,
				    `COMMANDS`.`CMINSTRUCTIONS`,
					DATE_FORMAT(`COMMANDS`.`CMDATE`,'%d-%m-%Y') AS CMDATE,
				    `COMMANDS`.`CMCREATIONDATE`,
				 	`DRIVERS`.`DNAME`,
                    `DRIVERS`.`IDDRIVER`,
                    `CUSTOMERS`.`CNAME`,
					`COMMANDS`.`SUBSERVICES_IDSUBSERVICES`,
    				`COMMANDS`.`PROV`,
    				`COMMANDS`.`PROVDELIVERY`,
					`COMMANDS`.`NOTAS`,
					`COMMANDS`.`PRECIO`,
					`COMMANDS`.`MERCHANDISE_IDMERCHANDISE`,
					`COMMANDS`.`LATITUD`,
				    `COMMANDS`.`LONGITUD`,
				    `COMMANDS`.`LATITUDENT`,
				    `COMMANDS`.`LONGITUDENT`,
					`COMMANDS`.`HORA`
				FROM `syswareo_haxpres`.`COMMANDS`
					LEFT JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`	
						ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
					LEFT JOIN `syswareo_haxpres`.`DRIVERS`
						ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
					INNER JOIN `syswareo_haxpres`.`CUSTOMERS`
						ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
					INNER JOIN `syswareo_haxpres`.`STATUS`
						ON `COMMANDS`.`IDSTATUS` = `STATUS`.`IDSTATUS`
					INNER JOIN `syswareo_haxpres`.`TYPECOMMAND` 
						ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				WHERE `COMMANDS`.`IDCOMMAND` = {$_POST['idCommand']};";

$registros = mysqli_query($conexion, $sql);
$error     = mysqli_error($conexion);

while ($row = mysqli_fetch_assoc($registros)) {
    $response[] = $row;
}

include '../configuration/closedb.php';

header("Content-Type: application/json");
echo json_encode($response);

?>