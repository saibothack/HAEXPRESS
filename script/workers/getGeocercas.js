var data = "";
onmessage = function(e) {
    data = "dv=" + e.data.dv;
    getGeocercas();
};

function getGeocercas(){
    var Httpreq = new XMLHttpRequest();
    Httpreq.open("POST","../../application/rastreo/getGeocercas.php",false);
    Httpreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    Httpreq.send(data);
    postMessage(Httpreq.responseText);
}

setInterval('getGeocercas()', 5000);