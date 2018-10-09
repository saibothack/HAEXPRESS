<?php 
	ob_start();
	session_start();
	if ($_SESSION["USUARIO"][0]["IDROLES"] == 1) {
		header("Location:commands/commandsAdmNew.php"); 
	} else if ($_SESSION["USUARIO"][0]["IDROLES"] == 2) {
		header("Location:commands/commands.php"); 
	}

	ob_end_flush();
?>