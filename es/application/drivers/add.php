<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catAdd.css">
	<?php include "../../../application/drivers/getDriversAdd.php"; ?>
</head>

<body>
	<br>
	<div class="container">
		<form data-toggle="validator" role="form" method="post" action="../../../application/drivers/add.php">
			<div class="form-group row">
				<label for="txtNumber" class="col-sm-2 col-form-label">N&uacute;mero:</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="txtNumber" name="txtNumber" placeholder="Ingrese su n&uacute;mero" required="required" value="<?php if(isset($rows)) echo $rows['DNUMBER']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtName" class="col-sm-2 col-form-label">Nombre:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtName" name="txtName" placeholder="Ingrese su nombre" required="required" value="<?php if(isset($rows)) echo $rows['DNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtAddress" class="col-sm-2 col-form-label">Direcci&oacute;n:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtAddress" name="txtAddress" placeholder="Ingrese su direcci&oacute;n" required="required" value="<?php if(isset($rows)) echo $rows['DADDRESS']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtPhone" class="col-sm-2 col-form-label">Tel&eacute;fono:</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" id="txtPhone" name="txtPhone" placeholder="Ingrese su n&uacute;mero de tel&eacute;fono" required="required" value="<?php if(isset($rows)) echo $rows['DPHONE']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtLincense" class="col-sm-2 col-form-label">#Licencia:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtLincense" name="txtLincense" placeholder="Ingrese su n&uacute;mero de licencia" required="required" value="<?php if(isset($rows)) echo $rows['DLICENCE']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtEmail" class="col-sm-2 col-form-label">E-mail:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Ingrese su e-mail" required="required" value="<?php if(isset($rows)) echo $rows['DEMAIL']; ?>">
				</div>
			</div>
			<input type="hidden" value="<?php if(isset($rows)) echo $rows['IDDRIVER']; else echo '0'; ?>" name="idDriver">
			<div class="form-group row">
				<div class="col-sm-6 text-center">
					<button type="button" id="btnRegresar">Regresar</button>
				</div>
				<div class="col-sm-6 text-center">
					<button type="submit" id="btnAgregar"><?php if(isset($rows)) echo 'Editar'; else echo 'Agregar'; ?> chofer</button>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/drivers/add.js"></script>
	<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete, sAddress = "", xComa = "";
      
      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('txtAddress')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
		document.getElementById('txtAddress').value = '';

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
			
			if (addressType == "street_number") {
				var val = place.address_components[i]['short_name'];
				if(val != "undefined") {
					sAddress += xComa + val;
					xComa = ", ";
				}
			}
			
			if (addressType == "route") {
				var val = place.address_components[i]['long_name'];
				if(val != "undefined") {
					sAddress += xComa + val;
					xComa = ", ";
				}
			}
			
			if (addressType == "sublocality_level_1") {
				var val = place.address_components[i]['long_name'];
				if(val != "undefined") {
					sAddress += xComa + val;
					xComa = ", ";
				}
			}
			
			if (addressType == "locality") {
				var val = place.address_components[i]['long_name'];
				if(val != "undefined") {
					sAddress += xComa + val;
					xComa = ", ";
				}
			}
			
			if (addressType == "administrative_area_level_1") {
				var val = place.address_components[i]['short_name'];
				if(val != "undefined") {
					sAddress += xComa + val;
					xComa = ", ";
				}
			}
			
			if (addressType == "postal_code") {
				var val = place.address_components[i]['short_name'];
				if(val != "undefined") {
					sAddress += xComa + val;
					xComa = ", ";
				}
			}
        }
		  
	  	document.getElementById('txtAddress').value = sAddress;
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
		
	$(".pac-container pac-logo").css('width', '500px');
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTnsnKvxxRd1UE1ZeC1qnuIRcC_WdEIyo&libraries=places&callback=initAutocomplete"></script>
</body>

</html>