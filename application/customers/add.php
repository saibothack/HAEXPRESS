<?php
ob_start();
session_start();
include '../configuration/config.php';
include '../configuration/opendb.php';

$iCustomer = htmlentities($_POST["idCustomers"]);
$sName     = htmlentities($_POST["txtName"]);
$sAddress  = htmlentities($_POST["txtAddress"]);
$sSuite    = htmlentities($_POST["txtSuite"]);
$sCity     = htmlentities($_POST["txtCity"]);
$sCP       = htmlentities($_POST["txtCP"]);
$sPhone    = htmlentities($_POST["txtPhone"]);

$sLat = htmlentities($_POST["sLat"]);
$sLon = htmlentities($_POST["sLon"]);

$sResponsible = htmlentities($_POST["txtResponsible"]);
$sEmail       = htmlentities($_POST["txtEmail"]);
$sPassword    = htmlentities($_POST["txtPassword"]);
$iResponsible = htmlentities($_POST["idResponsible"]);

$sName1     = htmlentities($_POST["txtName1"]);
$sEmail1    = htmlentities($_POST["txtEmail1"]);
$sPassword1 = htmlentities($_POST["txtPassword1"]);
$idUser1    = htmlentities($_POST["idUser1"]);

$sName2     = htmlentities($_POST["txtName2"]);
$sEmail2    = htmlentities($_POST["txtEmail2"]);
$sPassword2 = htmlentities($_POST["txtPassword2"]);
$idUser2    = htmlentities($_POST["idUser2"]);

$sName3     = htmlentities($_POST["txtName3"]);
$sEmail3    = htmlentities($_POST["txtEmail3"]);
$sPassword3 = htmlentities($_POST["txtPassword3"]);
$idUser3    = htmlentities($_POST["idUser3"]);

$sName4     = htmlentities($_POST["txtName4"]);
$sEmail4    = htmlentities($_POST["txtEmail4"]);
$sPassword4 = htmlentities($_POST["txtPassword4"]);
$idUser4    = htmlentities($_POST["idUser4"]);

$success = false;

if ($iCustomer != 0) {
    $sql = "UPDATE `syswareo_haxpres`.`CUSTOMERS`
			SET
				`CNAME` = '{$sName}',
				`CADDRESS` = '{$sAddress}',
				`CPHONE` = '{$sPhone}',
				`CSUITE` = '{$sSuite}',
				`CCITY` = '{$sCity}',
				`CCP` = '{$sCP}',
				`LATITUD` = '{$sLat}',
				`LONGITUD` = '{$sLon}'
			WHERE `IDCUSTOMER` = {$iCustomer};";
} else {
    $sql = "INSERT INTO `syswareo_haxpres`.`CUSTOMERS`
			(`CNAME`,
				`CADDRESS`,
				`CSUITE`,
				`CCITY`,
				`CCP`,
				`CPHONE`,
				`LATITUD`,
				`LONGITUD`)
			VALUES
			('{$sName}',
				'{$sAddress}',
				'{$sSuite}',
				'{$sCity}',
				'{$sCP}',
				'{$sPhone}',
				'{$sLat}',
				'{$sLon}');";
}

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

if ($iCustomer == 0) {
    $iCustomer = mysqli_insert_id($conexion);
}

if ($iResponsible != 0) {
    $sql = "UPDATE `syswareo_haxpres`.`USERS`
			SET `UNAME` = '{$sResponsible}',
				`UEMAIL` = '{$sEmail}',
				`UPASSWORD` = '{$sPassword}'
			WHERE `IDUSER` = {$iResponsible};";
} else {
    $sql = "INSERT INTO `syswareo_haxpres`.`USERS`
			(`IDROLES`,
				`IDCUSTOMER`,
				`UNAME`,
				`UEMAIL`,
				`UPASSWORD`,
				`URESPONSIBLE`)
			VALUES
			(2,
				{$iCustomer},
				'{$sResponsible}',
				'{$sEmail}',
				'{$sPassword}',
				1);";
}

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

if ($idUser1 != 0) {
    $sql = "UPDATE `syswareo_haxpres`.`USERS`
			SET `UNAME` = '{$sName1}',
				`UEMAIL` = '{$sEmail1}',
				`UPASSWORD` = '{$sPassword1}'
			WHERE `IDUSER` = {$idUser1};";
} else {
    $sql = "INSERT INTO `syswareo_haxpres`.`USERS`
			(`IDROLES`,
				`IDCUSTOMER`,
				`UNAME`,
				`UEMAIL`,
				`UPASSWORD`)
			VALUES
			(2,
				{$iCustomer},
				'{$sName1}',
				'{$sEmail1}',
				'{$sPassword1}');";
}

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

if ($idUser2 != 0) {
    $sql = "UPDATE `syswareo_haxpres`.`USERS`
			SET `UNAME` = '{$sName2}',
				`UEMAIL` = '{$sEmail2}',
				`UPASSWORD` = '{$sPassword2}'
			WHERE `IDUSER` = {$idUser2};";
} else {
    $sql = "INSERT INTO `syswareo_haxpres`.`USERS`
			(`IDROLES`,
				`IDCUSTOMER`,
				`UNAME`,
				`UEMAIL`,
				`UPASSWORD`)
			VALUES
			(2,
				{$iCustomer},
				'{$sName2}',
				'{$sEmail2}',
				'{$sPassword2}');";
}

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

if ($idUser3 != 0) {
    $sql = "UPDATE `syswareo_haxpres`.`USERS`
			SET `UNAME` = '{$sName3}',
				`UEMAIL` = '{$sEmail3}',
				`UPASSWORD` = '{$sPassword3}'
			WHERE `IDUSER` = {$idUser3};";
} else {
    $sql = "INSERT INTO `syswareo_haxpres`.`USERS`
			(`IDROLES`,
				`IDCUSTOMER`,
				`UNAME`,
				`UEMAIL`,
				`UPASSWORD`)
			VALUES
			(2,
				{$iCustomer},
				'{$sName3}',
				'{$sEmail3}',
				'{$sPassword3}');";
}

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

if ($idUser4 != 0) {
    $sql = "UPDATE `syswareo_haxpres`.`USERS`
			SET `UNAME` = '{$sName4}',
				`UEMAIL` = '{$sEmail4}',
				`UPASSWORD` = '{$sPassword4}'
			WHERE `IDUSER` = {$idUser4};";
} else {
    $sql = "INSERT INTO `syswareo_haxpres`.`USERS`
			(`IDROLES`,
				`IDCUSTOMER`,
				`UNAME`,
				`UEMAIL`,
				`UPASSWORD`)
			VALUES
			(2,
				{$iCustomer},
				'{$sName4}',
				'{$sEmail4}',
				'{$sPassword4}');";
}

if (mysqli_query($conexion, $sql)) {
    $success = true;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

include '../configuration/closedb.php';

if ($success) {
    header("Location:../../es/application/customers/index.php");
}

ob_end_flush();
