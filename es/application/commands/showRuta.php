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
		#right-panel {
		  font-family: 'Roboto','sans-serif';
		  line-height: 30px;
		  padding-left: 10px;
		}

		#right-panel select, #right-panel input {
		  font-size: 15px;
		}

		#right-panel select {
		  width: 100%;
		}

		#right-panel i {
		  font-size: 12px;
		}
		html, body {
		  height: 100%;
		  margin: 0;
		  padding: 0;
		}

		#map {
		  height: 100%;
		  float: left;
		  width: 63%;
		  height: 100%;
		}
		#right-panel {
		  float: right;
		  width: 34%;
		  height: 100%;
		}
		.panel {
		  height: 100%;
		  overflow: auto;
		}
	</style>
</head>

<body>
	<div id="map"></div>
	<div id="right-panel">
		<p>Total Distance: <span id="total"></span></p>
	</div>
	<input type="hidden" name="idCommand" id="idCommand" value="<?php echo $_REQUEST['iCommand']; ?>">
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../script/comands/showRuta.js"></script>
	
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

			initMapLocation();
		}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTnsnKvxxRd1UE1ZeC1qnuIRcC_WdEIyo&callback=initMap">
	</script>
</body>

</html>