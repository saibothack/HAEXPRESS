var datos = null;

function getCommands(){
    var Httpreq = new XMLHttpRequest(); // a new request
	Httpreq.open("POST","../../application/commands/getCommands.php", false);
	var params = "btnToDay=" + datos.btnToDay + "&btnCompleted=" + datos.btnCompleted + "&iDriver=" + datos.idDriverSelect + "&iTipoFiltro=" + datos.iTipoFiltro +
	"&dFechaSemana=" + datos.dFechaSemana +
	"&iSelectFiltro=" + datos.iSelectFiltro +
	"&dFechaInicio=" + datos.dFechaInicio +
	"&dFechaFinal=" + datos.dFechaFinal +
	"&txtBusqueda=" + datos.txtBusqueda;
	Httpreq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	Httpreq.send(params);
	postMessage(Httpreq.responseText);
}

self.onmessage = function (msg) {
    datos = msg.data;
	getCommands();
	setInterval('getCommands()', 60000);
}