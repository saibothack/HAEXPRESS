var placeSearch, autocomplete;
var sAddress = "";
var sLocality = "";
var sProv = "";
var sCP = "";

var placeSearchDel, autocompleteDel;
var sAddressDel = "";
var sLocalityDel = "";
var sProvDel = "";
var sCPDel = "";

var placeSearchChg, autocompleteChg;
var sAddressChg = "";
var sLocalityChg = "";
var sProvChg = "";
var sCPChg = "";

function initAutocomplete() {
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */
		(document.getElementById('txtAddress')), {
			types: ['geocode']
		});

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocomplete.addListener('place_changed', fillInAddress);
	
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	autocompleteDel = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */
		(document.getElementById('txtAddress1')), {
			types: ['geocode']
		});

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocompleteDel.addListener('place_changed', fillInAddressDel);
	
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	autocompleteChg = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */
		(document.getElementById('txtAddress2')), {
			types: ['geocode']
		});

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocompleteChg.addListener('place_changed', fillInAddressChg);
}

function fillInAddress() {
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();
	$("#txtAddress").val("");
	$("#txtCity").val("");
	$("#txtCp").val("");
	$("#txtProv").val("");

	var xComa = "";
	sAddress = "";

	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];

		if (addressType == "street_number") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sAddress = val + ' ';
				xComa = "";
			}
		}

		if (addressType == "route") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sAddress += xComa + val;
				xComa = '';
			}
		}

		if (addressType == "sublocality_level_1") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				sLocality = val;
				xComa = ", ";
			}
		}

		if (addressType == "locality") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				$("#txtCity").val(val);
			}
		}

		if (addressType == "administrative_area_level_1") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sProv = val;
			}
		}

		if (addressType == "postal_code_prefix") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				$("#txtCp").val(val);
			}
		}
		
		if (addressType == "postal_code") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				sCP = val;
			}
		}
	}

	$("#sLat").val(place.geometry.location.lat());
	$("#sLon").val(place.geometry.location.lng());

	if ($("#txtCp").val() == "") {
		$("#txtCp").val(sCP);
	}
	
	$("#txtAddress").val(sAddress);
	$("#txtProv").val(sProv);
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
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

$("#txtAddress").focusin(geolocate);

function fillInAddressDel() {
	// Get the place details from the autocomplete object.
	var place = autocompleteDel.getPlace();
	$("#txtAddress1").val("");
	$("#txtCity1").val("");
	$("#txtCp1").val("");
	$("#txtProv1").val("");
	sAddress = "";

	var xComa = "";

	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];

		if (addressType == "street_number") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sAddress = val + ' ';
				xComa = "";
			}
		}

		if (addressType == "route") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sAddress += xComa + val;
				xComa = '';
			}
		}

		if (addressType == "sublocality_level_1") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				sLocality = val;
				xComa = ", ";
			}
		}

		if (addressType == "locality") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				$("#txtCity1").val(val);
			}
		}

		if (addressType == "administrative_area_level_1") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sProv = val;
			}
		}

		if (addressType == "postal_code_prefix") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				$("#txtCp1").val(val);
			}
		}
		
		if (addressType == "postal_code") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				sCP = val;
			}
		}
	}

	$("#sLat1").val(place.geometry.location.lat());
	$("#sLon1").val(place.geometry.location.lng());

	if ($("#txtCp1").val() == "") {
		$("#txtCp1").val(sCP);
	}
	
	$("#txtAddress1").val(sAddress);
	$("#txtProv1").val(sProv);
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocateDel() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position.coords.accuracy
			});
			autocompleteDel.setBounds(circle.getBounds());
		});
	}
}

$("#txtAddress1").focusin(geolocateDel);

function fillInAddressChg() {
	// Get the place details from the autocomplete object.
	var place = initAutocompleteChg.getPlace();
	$("#txtAddress2").val("");
	$("#txtCity2").val("");
	$("#txtCp2").val("");
	$("#txtProv2").val("");

	sAddress = "";

	var xComa = "";

	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];

		if (addressType == "street_number") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sAddress = val + ' ';
				xComa = "";
			}
		}

		if (addressType == "route") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sAddress += xComa + val;
				xComa = '';
			}
		}

		if (addressType == "sublocality_level_1") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				sLocality = val;
				xComa = ", ";
			}
		}

		if (addressType == "locality") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				$("#txtCity2").val(val);
			}
		}

		if (addressType == "administrative_area_level_1") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sProv = val;
			}
		}

		if (addressType == "postal_code_prefix") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				$("#txtCp2").val(val);
			}
		}
		
		if (addressType == "postal_code") {
			var val = place.address_components[i]['long_name'];
			if (val != "undefined") {
				sCP = val;
			}
		}
	}

	if ($("#txtCp2").val() == "") {
		$("#txtCp2").val(sCP);
	}

	$("#sLat2").val(place.geometry.location.lat());
	$("#sLon2").val(place.geometry.location.lng());
	
	$("#txtAddress2").val(sAddress);
	$("#txtProv2").val(sProv);
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocateChg() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position.coords.accuracy
			});
			autocompleteChg.setBounds(circle.getBounds());
		});
	}
}

$("#txtAddress2").focusin(geolocateChg);