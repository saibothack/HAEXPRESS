<?php

	include '../configuration/config.php';
    include '../configuration/opendb.php';	

    $jsondata = "php://input";

    $phpjsonstring = file_get_contents($jsondata);

    $data = json_decode($phpjsonstring, true);

    $iConductor = $data["idConductor"];
    $sToken = $data["indConnect"];
	
    $response = array();
    $success = false;
    $message = "";
    
	$sql = "UPDATE `syswareo_haxpres`.`DRIVERS`
            SET
                `TOKENFIREBASE` = '{$sToken}'
            WHERE `IDDRIVER` = {$iConductor};";	

    $success = mysqli_query($conexion,$sql);
    $message = mysqli_error($conexion);

    $response = array("success" => $success, "message" => $message);

	include '../configuration/closedb.php';	

	header("Content-Type: application/json");	
	echo json_encode($response);
?>