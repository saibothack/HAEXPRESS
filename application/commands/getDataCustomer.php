<?php
session_start();
header("Content-Type: application/json");	

include '../configuration/config.php';
include '../configuration/opendb.php';

$response = array();

$search = htmlspecialchars($_REQUEST["term"]);

$changeAddress = "false";

if(isset($_REQUEST["changeAddress"])) {
	$changeAddress = htmlspecialchars($_REQUEST["changeAddress"]);
}

if (!(isset($_SESSION["USUARIO"])) && ($_SESSION["USUARIO"] <> "")) {
	echo json_encode($response);
	exit();
}

if ($_SESSION["USUARIO"][0]['IDROLES'] == 1) {
	$sql = "SELECT IFNULL(A.COMPANY, '') AS COMPANY, 
				IFNULL(A.ADDRESS, '') AS ADDRESS, 
				IFNULL(A.SUITE, '') AS SUITE, 
				IFNULL(A.CITY, '') AS CITY, 
				IFNULL(A.CP, '') AS CP, 
				IFNULL(A.LATITUD, '') AS LATITUD, 
				IFNULL(A.LONGITUD, '') AS LONGITUD 
			FROM (SELECT `COMMANDS`.`CMCOMPANY` AS COMPANY,
				`COMMANDS`.`CMADDRESS` AS ADDRESS,
				`COMMANDS`.`CMSUITE` AS SUITE,
				`COMMANDS`.`CMCITY` AS CITY,
				`COMMANDS`.`CMPC` AS CP,
				`COMMANDS`.`LATITUD` AS LATITUD,
				`COMMANDS`.`LONGITUD` AS LONGITUD
			FROM `syswareo_haxpres`.`COMMANDS`
			UNION 
			SELECT `COMMANDS`.`CMCOMPANYDELIVERY`,
				`COMMANDS`.`CMADDRESSDELIVERY`,
				`COMMANDS`.`CMSUITEDELIVERY`,
				`COMMANDS`.`CMCITYDELIVERY`,
				`COMMANDS`.`CMPCDELIVERY`,
				`COMMANDS`.`LATITUDENT`,
				`COMMANDS`.`LONGITUDENT`
			FROM `syswareo_haxpres`.`COMMANDS`
			UNION 
			SELECT `CUSTOMERS`.`CNAME`,
				`CUSTOMERS`.`CADDRESS`,
				`CUSTOMERS`.`CSUITE`,
				`CUSTOMERS`.`CCITY`,
				`CUSTOMERS`.`CCP`,
				`CUSTOMERS`.`LATITUD`,
				`CUSTOMERS`.`LONGITUD`
			FROM `syswareo_haxpres`.`CUSTOMERS`
			WHERE `CUSTOMERS`.`STATUS` = 1) AS A
			WHERE (A.COMPANY LIKE '%{$search}%') 
				OR (A.ADDRESS LIKE '%{$search}%') 
				OR (A.SUITE LIKE '%{$search}%') 
				OR (A.CITY LIKE '%{$search}%') 
				OR (A.CP LIKE '%{$search}%') 
			GROUP BY A.COMPANY, A.ADDRESS, A.SUITE, A.CITY, A.CP;";
} else {
	$sql = "SELECT IFNULL(A.COMPANY, '') AS COMPANY, 
				IFNULL(A.ADDRESS, '') AS ADDRESS, 
				IFNULL(A.SUITE, '') AS SUITE, 
				IFNULL(A.CITY, '') AS CITY, 
				IFNULL(A.CP, '') AS CP,
				IFNULL(A.LATITUD, '') AS LATITUD, 
				IFNULL(A.LONGITUD, '') AS LONGITUD 
			FROM (SELECT `COMMANDS`.`CMCOMPANY` AS COMPANY,
				`COMMANDS`.`CMADDRESS` AS ADDRESS,
				`COMMANDS`.`CMSUITE` AS SUITE,
				`COMMANDS`.`CMCITY` AS CITY,
				`COMMANDS`.`CMPC` AS CP,
				`COMMANDS`.`LATITUD` AS LATITUD,
				`COMMANDS`.`LONGITUD` AS LONGITUD
			FROM `syswareo_haxpres`.`COMMANDS`
			WHERE `COMMANDS`.`IDUSER` = {$_SESSION["USUARIO"][0]['IDUSER']}
			UNION 
			SELECT `COMMANDS`.`CMCOMPANYDELIVERY`,
				`COMMANDS`.`CMADDRESSDELIVERY`,
				`COMMANDS`.`CMSUITEDELIVERY`,
				`COMMANDS`.`CMCITYDELIVERY`,
				`COMMANDS`.`CMPCDELIVERY`,
				`COMMANDS`.`LATITUDENT`,
				`COMMANDS`.`LONGITUDENT`
			FROM `syswareo_haxpres`.`COMMANDS`
			WHERE `COMMANDS`.`IDUSER` = {$_SESSION["USUARIO"][0]['IDUSER']}
			UNION 
			SELECT `CUSTOMERS`.`CNAME`,
				`CUSTOMERS`.`CADDRESS`,
				`CUSTOMERS`.`CSUITE`,
				`CUSTOMERS`.`CCITY`,
				`CUSTOMERS`.`CCP`,
				`CUSTOMERS`.`LATITUD`,
				`CUSTOMERS`.`LONGITUD`
			FROM `syswareo_haxpres`.`CUSTOMERS`
			WHERE `CUSTOMERS`.`IDCUSTOMER` = {$_SESSION["USUARIO"][0]['IDCUSTOMER']} AND `CUSTOMERS`.`STATUS` = 1) AS A
			WHERE (A.COMPANY LIKE '%{$search}%') 
				OR (A.ADDRESS LIKE '%{$search}%') 
				OR (A.SUITE LIKE '%{$search}%') 
				OR (A.CITY LIKE '%{$search}%') 
				OR (A.CP LIKE '%{$search}%') 
			GROUP BY A.COMPANY, A.ADDRESS, A.SUITE, A.CITY, A.CP;";
	
}

if ($changeAddress == "true") {
	$sql = "SELECT IFNULL(A.CNAME, '') AS COMPANY, 
				IFNULL(A.CADDRESS, '') AS ADDRESS, 
				IFNULL(A.CSUITE, '') AS SUITE, 
				IFNULL(A.CCITY, '') AS CITY, 
				IFNULL(A.CCP, '') AS CP,
				IFNULL(A.LATITUD, '') AS LATITUD, 
				IFNULL(A.LONGITUD, '') AS LONGITUD 
			FROM (SELECT `CUSTOMERS`.`CNAME`,
				`CUSTOMERS`.`CADDRESS`,
				`CUSTOMERS`.`CSUITE`,
				`CUSTOMERS`.`CCITY`,
				`CUSTOMERS`.`CCP`,
				`CUSTOMERS`.`LATITUD`,
				`CUSTOMERS`.`LONGITUD`
			FROM `syswareo_haxpres`.`CUSTOMERS`
			WHERE `CUSTOMERS`.`STATUS` = 1) AS A
			WHERE (A.CNAME LIKE '%{$search}%') 
				OR (A.CADDRESS LIKE '%{$search}%') 
				OR (A.CSUITE LIKE '%{$search}%') 
				OR (A.CCITY LIKE '%{$search}%') 
				OR (A.CCP LIKE '%{$search}%') 
			GROUP BY A.CNAME, A.CADDRESS, A.CSUITE, A.CCITY, A.CCP;";
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