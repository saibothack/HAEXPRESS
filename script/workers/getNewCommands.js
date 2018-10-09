
function getNewCommands(){
    var Httpreq = new XMLHttpRequest(); // a new request
    Httpreq.open("GET","../../application/commands/getNewCommands.php",false);
    Httpreq.send(null);
    postMessage(Httpreq.responseText);
}

getNewCommands();
setInterval('getNewCommands()', 60000);