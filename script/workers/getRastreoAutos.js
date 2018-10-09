
var data  = "";

onmessage = function(e) {   
    data = "dv=" + e.data.dv;
    getRastreoAutos();
};  

function getRastreoAutos(){
    var Httpreq = new XMLHttpRequest(); // a new request
    Httpreq.open("POST","../../application/rastreo/getRastreo.php",false);
    Httpreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    Httpreq.send(data);
    postMessage(Httpreq.responseText);
}

setInterval('getRastreoAutos()', 5000);