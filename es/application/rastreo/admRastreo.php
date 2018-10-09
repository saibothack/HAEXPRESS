<?php
session_start();
if (!isset($_SESSION["USUARIO"])) {
	header( 'Location: ../../../index.php' );
}
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>.:: Haexpress ::.</title>
	<link rel="icon" href="../../../img/logoHeader.png">
	<link rel="stylesheet" type="text/css" href="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.css">
	<style>
		html,
		body {
			height: 100% !important;
			width: 100% !important;
		}

		#map {
			height: 100% !important;
			width: 100% !important;
		}
	</style>
</head>

<body>
	<input type="hidden" id="dv" name="dv" value="<?php 
		if (isset($_REQUEST["dv"])) {
			if ($_REQUEST["dv"] != "0") {
				echo $_REQUEST["dv"];
			} else {
				echo "0";
			}
		} else {
			echo "0";
		}
	?>">
	<div id="map"></div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../script/rastreo/funciones.js"></script>
	<script>
		var map;
		function initMap() {
			var uluru = {
				lat: 45.502226,
				lng: -73.568606
			};

			map = new google.maps.Map( document.getElementById('map'), {
				zoom: 10,
				center: uluru
			} );

			inicializaPantalla();
		}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTnsnKvxxRd1UE1ZeC1qnuIRcC_WdEIyo&callback=initMap">
	</script>
</body>

</html>