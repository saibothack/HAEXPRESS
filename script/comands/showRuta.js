var origin;
var destination;

var originAddress = "";
var destinationAddress = "";

function initMapLocation() {
	getLocationCommands()

	console.log(origin);
	console.log(destination);

	var directionsService = new google.maps.DirectionsService;
	var directionsDisplay = new google.maps.DirectionsRenderer({
		draggable: false,
		map: map,
		panel: document.getElementById('right-panel')
	});

	directionsDisplay.addListener('directions_changed', function() {
		computeTotalDistance(directionsDisplay.getDirections());
	});

	displayRoute(origin, destination, directionsService, directionsDisplay)
}

function getLocationCommands() {
	var params = {
		idCommand: $("#idCommand").val()
	}
	$.ajax({
		type: 'POST',
		async: false,
		dataType: 'json',
		url: '../../../application/commands/getLocationLatLog.php',
		data: params,
		success: function(data) {
			origin = new google.maps.LatLng(data[0].LATITUD, data[0].LONGITUD);
			destination = new google.maps.LatLng(data[0].LATITUDENT, data[0].LONGITUDENT);

			originAddress = data[0].CMADDRESS;
			destinationAddress = data[0].CMADDRESSDELIVERY;

			console.log(originAddress);
			console.log(destinationAddress);

			var marker = new google.maps.Marker( { 
				position: origin,
				map: map 
			});

			var marker = new google.maps.Marker( { 
				position: destination,
				map: map 
			});
			
		}
	});
}

function displayRoute(origen, destino, service, display) {
	service.route({
		origin: origen,
		destination: destino,
		//waypoints: [{location: originAddress}, {location: destinationAddress}],
		travelMode: 'DRIVING',
		avoidTolls: true
	}, function(response, status) {
		if (status === 'OK') {
			display.setDirections(response);
		} else {
			alert('Could not display directions due to: ' + status);
		}
	});
}

function computeTotalDistance(result) {
	var total = 0;
	var myroute = result.routes[0];

	for (var i = 0; i < myroute.legs.length; i++) {
		total += myroute.legs[i].distance.value;
	}

	total = total / 1000;
	document.getElementById('total').innerHTML = total + ' km';
}