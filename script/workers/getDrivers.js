
function getDrivers(){
    var Httpreq = new XMLHttpRequest(); // a new request
    Httpreq.open("GET","../../application/drivers/getDriversList.php", false);
    Httpreq.send(null);
    postMessage(Httpreq.responseText);
	
}

getDrivers();
setInterval('getDrivers()', 60000);