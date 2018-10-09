<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catAdd.css">
	<?php include "../../../application/customers/getCustomersAdd.php"; ?>
</head>
<body>
	<br>
	<div class="container">
		<form data-toggle="validator" role="form" method="post" action="../../../application/customers/add.php" id="frmAlta">
			<div class="form-group row">
				<label for="txtName" class="col-sm-2 col-form-label">Nombre:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtName" name="txtName" placeholder="Ingrese su nombre" required="required" value="<?php if(isset($rows)) echo $rows['CNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtAddress" class="col-sm-2 col-form-label">Direcci&oacute;n:</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="txtAddress" name="txtAddress" placeholder="Ingrese su direcci&oacute;n" required="required" value="<?php if(isset($rows)) echo $rows['CADDRESS']; ?>" onFocus="geolocate()">
					<input type="hidden" name="sLat" id="sLat" value="">
					<input type="hidden" name="sLon" id="sLon" value="">
				</div>
				<label for="txtSuite" class="col-sm-2 col-form-label">Suite:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="txtSuite" name="txtSuite" placeholder="Suite" required="required" value="<?php if(isset($rows)) echo $rows['CSUITE']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtCity" class="col-sm-2 col-form-label">Ciudad:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtCity" name="txtCity" placeholder="Ingrese su ciudad" required="required" value="<?php if(isset($rows)) echo $rows['CCITY']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtCP" class="col-sm-2 col-form-label">C.P.:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtCP" name="txtCP" placeholder="Ingrese su CP" required="required" value="<?php if(isset($rows)) echo $rows['CCP']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtPhone" class="col-sm-2 col-form-label">Tel&eacute;fono:</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" id="txtPhone" name="txtPhone" placeholder="Ingrese su n&uacute;mero de tel&eacute;fono" required="required" value="<?php if(isset($rows)) echo $rows['CPHONE']; ?>">
				</div>
			</div>
			<hr style="border-top: dotted 3px;">
			<div class="form-group row">
				<div class="col-sm-10">
					<label class="col-form-label offset-3">Por favor ingrese los siguientes datos (maximo 5)</label>
				</div>
			</div>
			<div class="form-group row">
				<label for="txtResponsible" class="col-sm-2 col-form-label">Responsable:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtResponsible" name="txtResponsible" placeholder="Ingrese su responsable" required="required" value="<?php if(isset($rowsUser)) echo $rowsUser[0]['UNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtEmail" class="col-sm-2 col-form-label">E-mail:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Ingrese su email" required="required" value="<?php if(isset($rowsUser)) echo $rowsUser[0]['UEMAIL']; ?>">
				</div>
			</div>
			<div class="alert alert-danger" role="alert" id="errResponsible">
			  <strong>Ocurrio un error!</strong> El correo ya fue utilizado.
			</div>
			<div class="form-group row">
				<label for="txtPassword" class="col-sm-2 col-form-label">Contraseña:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtPassword" name="txtPassword" placeholder="Ingrese su contraseña" required="required" value="<?php if(isset($rowsUser)) echo $rowsUser[0]['UPASSWORD']; ?>">
				</div>
			</div>
			<div>
				<input type="hidden" value="<?php if(isset($rowsUser)) echo $rowsUser[0]['IDUSER']; else echo '0'; ?>" name="idResponsible">
			</div>
			<div class="form-group row">
				<label for="txtName1" class="col-sm-2 col-form-label">Nombre:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtName1" name="txtName1" placeholder="Ingrese su Nombre" value="<?php if(isset($rowsUser)) echo $rowsUser[1]['UNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtEmail1" class="col-sm-2 col-form-label">E-mail:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="txtEmail1" name="txtEmail1" placeholder="Ingrese su email" value="<?php if(isset($rowsUser)) echo $rowsUser[1]['UEMAIL']; ?>">
				</div>
			</div>
			<div class="alert alert-danger" role="alert" id="errUser1">
			  <strong>Ocurrio un error!</strong> El correo ya fue utilizado.
			</div>
			<div class="form-group row">
				<label for="txtPassword1" class="col-sm-2 col-form-label">Contraseña:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtPassword1" name="txtPassword1" placeholder="Ingrese su contraseña" value="<?php if(isset($rowsUser)) echo $rowsUser[1]['UPASSWORD']; ?>">
				</div>
			</div>
			<div>
				<input type="hidden" value="<?php if(isset($rowsUser)) echo $rowsUser[1]['IDUSER']; else echo '0'; ?>" name="idUser1">
			</div>
			<div class="form-group row">
				<label for="txtName2" class="col-sm-2 col-form-label">Nombre:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtName2" name="txtName2" placeholder="Ingrese su Nombre" value="<?php if(isset($rowsUser)) echo $rowsUser[2]['UNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtEmail2" class="col-sm-2 col-form-label">E-mail:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="txtEmail2" name="txtEmail2" placeholder="Ingrese su email" value="<?php if(isset($rowsUser)) echo $rowsUser[2]['UEMAIL']; ?>">
				</div>
			</div>
			<div class="alert alert-danger" role="alert" id="errUser2">
			  <strong>Ocurrio un error!</strong> El correo ya fue utilizado.
			</div>
			<div class="form-group row">
				<label for="txtPassword2" class="col-sm-2 col-form-label">Contraseña:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtPassword2" name="txtPassword2" placeholder="Ingrese su contraseña" value="<?php if(isset($rowsUser)) echo $rowsUser[2]['UPASSWORD']; ?>">
				</div>
			</div>
			<div>
				<input type="hidden" value="<?php if(isset($rowsUser)) echo $rowsUser[2]['IDUSER']; else echo '0'; ?>" name="idUser2">
			</div>
			<div class="form-group row">
				<label for="txtName3" class="col-sm-2 col-form-label">Nombre:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtName3" name="txtName3" placeholder="Ingrese su Nombre" value="<?php if(isset($rowsUser)) echo $rowsUser[3]['UNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtEmail3" class="col-sm-2 col-form-label">E-mail:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="txtEmail3" name="txtEmail3" placeholder="Ingrese su email" value="<?php if(isset($rowsUser)) echo $rowsUser[3]['UEMAIL']; ?>">
				</div>
			</div>
			<div class="alert alert-danger" role="alert" id="errUser3">
			  <strong>Ocurrio un error!</strong> El correo ya fue utilizado.
			</div>
			<div class="form-group row">
				<label for="txtPassword3" class="col-sm-2 col-form-label">Contraseña:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtPassword3" name="txtPassword3" placeholder="Ingrese su contraseña" value="<?php if(isset($rowsUser)) echo $rowsUser[3]['UPASSWORD']; ?>">
				</div>
			</div>
			<div>
				<input type="hidden" value="<?php if(isset($rowsUser)) echo $rowsUser[3]['IDUSER']; else echo '0'; ?>" name="idUser3">
			</div>
			<div class="form-group row">
				<label for="txtName4" class="col-sm-2 col-form-label">Nombre:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtName4" name="txtName4" placeholder="Ingrese su Nombre" value="<?php if(isset($rowsUser)) echo $rowsUser[4]['UNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="txtEmail4" class="col-sm-2 col-form-label">E-mail:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="txtEmail4" name="txtEmail4" placeholder="Ingrese su email" value="<?php if(isset($rowsUser)) echo $rowsUser[4]['UEMAIL']; ?>">
				</div>
			</div>
			<div class="alert alert-danger" role="alert" id="errUser4">
			  <strong>Ocurrio un error!</strong> El correo ya fue utilizado.
			</div>
			<div class="form-group row">
				<label for="txtPassword4" class="col-sm-2 col-form-label">Contraseña:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtPassword4" name="txtPassword4" placeholder="Ingrese su contraseña" value="<?php if(isset($rowsUser)) echo $rowsUser[4]['UPASSWORD']; ?>">
				</div>
			</div>
			<div>
				<input type="hidden" value="<?php if(isset($rowsUser)) echo $rowsUser[4]['IDUSER']; else echo '0'; ?>" name="idUser4">
			</div>
			<div>
				&nbsp;
				<input type="hidden" value="<?php if(isset($rows)) echo $rows['IDCUSTOMER']; else echo '0'; ?>" name="idCustomers">
			</div>
			<div class="form-group row">
				<div class="col-sm-6 text-center">
					<button type="button" id="btnRegresar">Regresar</button>
				</div>
				<div class="col-sm-6 text-center">
					<button type="submit" id="btnAgregar"><?php if(isset($rows)) echo 'Editar'; else echo 'Agregar'; ?> Cliente</button>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/customers/add.js"></script>
	<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
	  var sAddress = "";
	  var sLocality = "";

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
		document.getElementById('txtCity').value = '';
		document.getElementById('txtCP').value = '';
		  
		var xComa = "";

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
			
			if (addressType == "street_number") {
				var val = place.address_components[i]['short_name'];
				if(val != "undefined") {
					sAddress = val + ' ';
					xComa = ", ";
				}
			}
			
			if (addressType == "route") {
				var val = place.address_components[i]['long_name'];
				if(val != "undefined") {
					sAddress += xComa + val;
					xComa = '';
				}
			}
			
			if (addressType == "sublocality_level_1") {
				var val = place.address_components[i]['long_name'];
				if(val != "undefined") {
					sLocality = val;
					xComa = ", ";
				}
			}
			
			if (addressType == "locality") {
				var val = place.address_components[i]['long_name'];
				if(val != "undefined") {
					sLocality +=  xComa + val;
					xComa = ", ";
				}
			}
			
			if (addressType == "administrative_area_level_1") {
				var val = place.address_components[i]['short_name'];
				if(val != "undefined") {
					sLocality +=  xComa + val;
					xComa = "";
				}
			}
			
			if (addressType == "postal_code") {
				var val = place.address_components[i]['short_name'];
				if(val != "undefined") {
					document.getElementById('txtCP').value = val;
				}
			}
        }

        $("#sLat").val(place.geometry.location.lat());
		$("#sLon").val(place.geometry.location.lng());
		  
		document.getElementById('txtCity').value = sLocality;
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
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTnsnKvxxRd1UE1ZeC1qnuIRcC_WdEIyo&libraries=places&callback=initAutocomplete"></script>
</body>
</html>
