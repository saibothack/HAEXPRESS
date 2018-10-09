var arratMarkers = [];
var arrayRastreo = [];
var arrayGeocerca = [];
var WorkerGeocercas;
var WorkerRastreo;

var strRastreo = "";
var strGeocercas = "";

/**
 * Función que inicia el Worker para obtener los datos de las geocercas.
 * La obtencion de datos se realiza cada 5 segundos.
 * 
 */
function startWorkerGeocercas() {
	if (typeof(Worker) !== "undefined") {
		var data = {
			dv: $("#dv").val()
		}
		if (typeof(WorkerGeocercas) == "undefined") {
			WorkerGeocercas = new Worker("../../../script/workers/getGeocercas.js");
			WorkerGeocercas.postMessage(data)
		}

		WorkerGeocercas.onmessage = function(event) {
			if (strGeocercas != event.data) {
				var obj = $.parseJSON(event.data);
				createGeocercasAndMarkers(obj);
				strGeocercas = event.data;
			}
		};
	} else {
		console.log("Sorry! No Web Worker support.");
	}

}

/**
 * Función que para el worker de geoceracas.
 */
function stopWorkerGeocercas() {
	WorkerGeocercas.terminate();
	WorkerGeocercas = undefined;
}

/**
 * Funcion que inicia el Worker para obtener los datos de los autos en rastreo.
 * Los datos se obtienen cada 5 segundos.
 */
function startWorkerRastreo() {
	if (typeof(Worker) !== "undefined") {
		var data = {
			dv: $("#dv").val()
		}
		if (typeof(WorkerRastreo) == "undefined") {
			WorkerRastreo = new Worker("../../../script/workers/getRastreoAutos.js");
			WorkerRastreo.postMessage(data)
		}
		WorkerRastreo.onmessage = function(event) {
			if (strRastreo != event.data) {
				var obj = $.parseJSON(event.data);
				createMarkerRastreo(obj);
				strRastreo = event.data;
			}
		};
	} else {
		console.log("Sorry! No Web Worker support.");
	}
}

/**
 * Funcion para parar el worker de rastreo.
 */
function stopWorkerRastreo() {
	WorkerRastreo.terminate();
	WorkerRastreo = undefined;
}

/**
 * Funcion que crea los markers y geocercas para en el mapa.
 * @param {JSON} objJsonData Información sobre los markers y geocercas
 */
function createGeocercasAndMarkers(oGeocercas) {
	$.each(arratMarkers, function(index, value) {
		value.setMap(null);
	});

	arratMarkers = [];

	$.each(arrayGeocerca, function(index, value) {
		value.geocerca.setMap(null);
	});

	arrayGeocerca = [];

	$.each(oGeocercas, function(i, item) { 
		var geoLat = { 
			lat: parseFloat(item.LATITUD), 
			lng: parseFloat(item.LONGITUD) 
		}; 

		var contentString = '<div id="content">'+
								'<div id="siteNotice">'+
								'</div>'+
								'<h1 id="firstHeading" class="firstHeading">Comanda # ' + item.IDCOMMAND + '</h1>'+
								'<div id="bodyContent">'+
								'<label>Conductor: ' + item.DNAME + '</label> <br>' + 
								'<label>Compañia: ' + item.CMCOMPANY + '</label> <br>' + 
								'<label>Contacto: ' + item.CMCONTAC + ', ' + item.CMPHONE + '</label> <br>' + 
								'<label>Salida: ' + item.CMADDRESS + ', ' + item.CMCITY + '</label> <br>' + 
								'<label>Compañia: ' + item.CMCOMPANYDELIVERY + '</label> <br>' + 
								'<label>Contacto: ' + item.CMCONTACDELIVERY + ', ' + item.CMPHONEDELIVERY + '</label> <br>' + 
								'<label>Entrega: ' + item.CMADDRESSDELIVERY + ', ' + item.CMCITYDELIVERY + '</label> <br>' + 
								'</div>'+
							'</div>';


		var marker = new google.maps.Marker( { 
			position: geoLat,
			map: map 
		});

		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});

		marker.addListener('click', function() {
			infowindow.open(map, marker);
		});
		
		arratMarkers.push(marker);

		var cityCircle = new google.maps.Circle({ 
			strokeColor: '#FF0000', 
			strokeOpacity: 0.8, 
			strokeWeight: 2, 
			fillColor: '#FF0000', 
			fillOpacity: 0.10, 
			//map: map, 
			//center: geoLat, 
			radius: 1000 
		}); 

		arrayGeocerca.push({idCommanda : item.IDCOMMAND, geocerca : cityCircle, marker : marker})	;
	}); 
}

function createMarkerRastreo(oGeocercas) {
	var iconBase = 'http://sysware.online/haexpress/img/camion.png';

	$.each(arrayRastreo, function(index, value) {
		value.setMap(null);
	});
	
	$.each(oGeocercas, function(i, item) { 
		var geoLat = { 
			lat: parseFloat(item.LATITUD), 
			lng: parseFloat(item.LOGITUD) 
		}; 

		var marker = new google.maps.Marker( { 
			position: geoLat,
			icon: iconBase,
			label: {
				text: item.DNAME,
				color: "#ffffff",
				fontSize: "16px",
				fontWeight: "bold"
			}, 
			map: map 
		}); 

		arrayRastreo.push(marker);

		/*$.each(arrayGeocerca, function(index, value) {
			if (isMarkerInArea(value.geocerca, marker)) {
				chekSendSms(value, geoLat);
				return false; 
			}
		});*/
	}); 
}

function chekSendSms(oMarker, geoLat) {
	var data = {iCommand : oMarker.idCommanda};

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: '../../../application/rastreo/getSendSms.php',
		data: data,
		success: function (data) {
			if (data.success) {
				sendSms(oMarker, geoLat);
			} 
		}
	});
}

function sendSms(oMarker, geoLat) {
	var lat = oMarker.marker.getPosition().lat();
	var lng = oMarker.marker.getPosition().lng();

	var origin1 = new google.maps.LatLng(lat, lng);
	var destinationA = new google.maps.LatLng(geoLat.lat, geoLat.lng);

	var service = new google.maps.DistanceMatrixService();
	service.getDistanceMatrix(
	{
		origins: [origin1],
		destinations: [destinationA],
		travelMode: 'DRIVING',
	}, callback);

	function callback(response, status) {

		var sMensaje = "Haexpress, su comanda esta aproximadamente a " + response.rows[0].elements[0].duration.text;
		var xhr = new XMLHttpRequest(),
		body = JSON.stringify({"content": sMensaje, "to": ["522211603201"]});
		xhr.open("POST",'https://platform.clickatell.com/messages',true);
		xhr.setRequestHeader("Content-Type", "application/json");
		xhr.setRequestHeader("Authorization", "tmZIla3mScK2iCqhN7efuA==");
		xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			console.log('success');
		}};
		xhr.send(body);
									


	}

}

function isMarkerInArea(circle, marker){
	return (circle.getBounds().contains(marker.getPosition()));
 };

function inicializaPantalla() {
	startWorkerGeocercas();
	startWorkerRastreo();

	$("#map").css({ 'position' : ''});
}