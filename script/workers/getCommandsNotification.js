
function getCommandsNotification(){
    var Httpreq = new XMLHttpRequest();
	Httpreq.open("GET","../../application/commands/getCommandsNotification.php", false);
	Httpreq.send(null);
	postMessage(Httpreq.responseText);
}

getCommandsNotification();
setInterval('getCommandsNotification()', 60000);