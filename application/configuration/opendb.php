<?php
	$conexion=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	
	if ($conexion->connect_error) {
		die("Connection failed: " . $conexion->connect_error);

		print($conexion->connect_error);
		exit();
	} 
?>