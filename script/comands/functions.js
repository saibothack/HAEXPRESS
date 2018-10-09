"use strict";
var rowNewCommands = [];
var bNnewCommands = false;
var btnToDay = false;
var btnCompleted = false;
var idDriverSelect = 0;
var iValueSelect = "";
var sNewCommands = "";
var sNotifications = "";
var wNC;
var wDrivers;
var wNot;
var w;
var sDrivers = "";

function createItemDriver(idDriver, sName, bStatus) {
    if (idDriver != undefined) {
		var bSstatuClass = "driverDisabled";
		if (bStatus == 1) {
			bSstatuClass = "driverEnabled";
		}
		
		var btn = '<div class="col-sm-6 text-left btnDrivers">' +
			'<a href="#">' +
				'<div style="display: block;">' + 
					'<div class="' + bSstatuClass + '">' +
					'</div>' +
					'<input type="button" value="' + sName + '" class="btnDefault" name="btnChoferesSelect" data-id="' + idDriver + '" onClick="fnClickDriver(' + idDriver + ')">' +
				'</div>' +
			'</a>' +
		'</div>';
		
        $("#divChoferes").append(btn);
    }
}
var oDriver;

function fnDblKNewRow(idComanda) {
    cleanForm();
    var id = "#trNewCommand_" + idComanda;
    if ($(id).hasClass('selectRowD')) {
        $(id).removeClass('selectRowD');
		enabledForm(true);
		enabledAsignar(true);
    } else {
        $(".selectRow").removeClass("selectRow")
        $(".selectRowD").removeClass("selectRowD")
        $(id).addClass('selectRowD');
        getInfoCommand(idComanda);
    }
}

function cleanForm() {
	$("#lblNoOrden").text("");
	$("#lblCliente").text("");
	
    $("#txtCompanty").val("");
    $("#txtAddress").val("");
    $("#txtSuite").val("");
    $("#txtCity").val("");
	$("#txtProv").val("");
    $("#txtContact").val("");
    $("#txtPhone").val("");
	
    $("#txtCompantyDelivery").val("");
    $("#txtAddressDelivery").val("");
    $("#txtSuiteDelivery").val("");
    $("#txtCityDelivery").val("");
	$("#txtProvDelivery").val("");
    $("#txtContactDelivery").val("");
    $("#txtPhoneDelivery").val("");
    
	$("#cmbEstatus").val("");
    $("#cmbVehiculo").val("");
    $("#txtInstructions").val("");
    $("#cmbService").val("");
    $("#txtQuanty").val("");
    $("#txtWeight").val("");
	$("#txtReference").val("");
	$("#txtTransfer").val("");
	
	$("#txtDriver").val("");
	$("#txtNombre").val("");
	$("#txtNotas").val("");
	$("#txtPrecio").val("");
	$("#iCommand").val("0");
	
	$("#cmbTypeCommand").val("");
	$("#cmbMerchandise").val("");

	$("#slat").val("");
	$("#slon").val("");

	$("#slat1").val("");
	$("#slon1").val("");
	
	$("#divTransfer").hide(1000);
	$('#cmbTypeCommand').css("color", "#000000");
	$("#cmbEstatus").css("color", "#000000");
	
	$("#cmbService").css("color", "#000000");
	
	$("#txtFecha").val("");
	$("#txtHora").val("");
	
}

function enabledAsignar(bEnabled) {
	"use strict";
	$("#txtNombre").prop('disabled', bEnabled);
	$("#txtFirma").prop('disabled', bEnabled);
	$("#btnAsignar").prop('disabled', bEnabled);
	$("#txtNotas").prop('disabled', bEnabled);
	$("#txtPrecio").prop('disabled', bEnabled);
	
	if(!btnCompleted) {
		$("#txtDriver").prop('disabled', bEnabled);
	} else {
		$("#txtDriver").prop('disabled', true);
	}
}

function enabledForm(bEnabled) {
	$("#txtCompanty").prop('disabled', bEnabled);
	$("#txtAddress").prop('disabled', bEnabled);
	$("#txtSuite").prop('disabled', bEnabled);
	$("#txtCity").prop('disabled', bEnabled);
	$("#txtProv").prop('disabled', bEnabled);
	$("#txtContact").prop('disabled', bEnabled);
	$("#txtPhone").prop('disabled', bEnabled);

	$("#btnCambiar").prop('disabled', bEnabled);
	
	$("#txtCompantyDelivery").prop('disabled', bEnabled);
	$("#txtAddressDelivery").prop('disabled', bEnabled);
	$("#txtSuiteDelivery").prop('disabled', bEnabled);
	$("#txtCityDelivery").prop('disabled', bEnabled);
	$("#txtProvDelivery").prop('disabled', bEnabled);
	$("#txtContactDelivery").prop('disabled', bEnabled);
	$("#txtPhoneDelivery").prop('disabled', bEnabled);
	
	$("#cmbEstatus").prop('disabled', bEnabled);
	$("#cmbVehiculo").prop('disabled', bEnabled);
	$("#txtInstructions").prop('disabled', bEnabled);
	$("#cmbService").prop('disabled', bEnabled);
	$("#txtQuanty").prop('disabled', bEnabled);
	$("#txtWeight").prop('disabled', bEnabled);
	$("#txtReference").prop('disabled', bEnabled);
	$("#txtTransfer").prop('disabled', bEnabled);
	
	$("#btnMap").prop('disabled', bEnabled);
	$("#btnEditar").prop('disabled', bEnabled);
	$("#btnImprimir").prop('disabled', bEnabled);
	$("#btnCancelar").prop('disabled', bEnabled);
	
	$("#cmbTypeCommand").prop('disabled', true);
	$("#cmbMerchandise").prop('disabled', bEnabled);
	
	$("#txtHora").prop('disabled', bEnabled);
	$("#txtFecha").prop('disabled', bEnabled);
}

function fnDblKRow(idComanda) {
    cleanForm();
    var id = "#trCommand_" + idComanda;
    if ($(id).hasClass('selectRowD')) {
        $(id).removeClass('selectRowD');
		enabledForm(true);
		enabledAsignar(true);
    } else {
        $(".selectRow").removeClass("selectRow")
        $(".selectRowD").removeClass("selectRowD")
        $(id).addClass('selectRowD');
        getInfoCommand(idComanda);
    }
}

var IDSUBSERVICES = 0;

function getInfoCommand(iComand) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../../../application/commands/getCommandDetailList.php',
        data: {
            idCommand: iComand
        },
        success: function(data) {
			
			var params = {
				idService : data[0]['IDTYPECOMAMAND']
			};
			
			IDSUBSERVICES = data[0]['SUBSERVICES_IDSUBSERVICES'];
			
			$('#cmbService')
					.find('option')
					.remove()
					.end()
					.append('<option value="">Seleccione</option>')
					.val('Seleccione');
			
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '../../../application/subservices/getServicesList.php',
				data: params,
				success: function(oServices) {
					for (var i in oServices) {
						var ckt = "";
						
						if (oServices[i]["IDSUBSERVICES"] == IDSUBSERVICES) {
							ckt = 'selected="selected"';
							$("#cmbService").css("color", oServices[i]["COLOR"]);
						}
						
						$("#cmbService").append("<option value='" + oServices[i]["IDSUBSERVICES"] + "' data-color='" + oServices[i]["COLOR"] + "' style='color:" + oServices[i]["COLOR"] + "' " + ckt + ">" + oServices[i]["NAME"] + "</option>");
					}
					
					IDSUBSERVICES = 0;
				}
			});
			
			
			$("#cmbTypeCommand").val($('<div>').html(data[0]['IDTYPECOMAMAND']).text());
			$('#cmbTypeCommand').css("color", $('<div>').html(data[0]['TCCOLOR']).text());
			
            $("#iCommand").val($('<div>').html(data[0]['IDCOMMAND']).text());
			
            $("#lblNoOrden").text($('<div>').html(data[0]['IDCOMMAND']).text());
            $("#lblCliente").text($('<div>').html(data[0]['CNAME']).text());
			
            //$("#lblCliente").val($('<div>').html(data[0]['IDCOMMAND']).text());
			
            $("#txtCompanty").val($('<div>').html(data[0]['CMCOMPANY']).text());
            $("#txtAddress").val($('<div>').html(data[0]['CMADDRESS']).text());
            $("#txtSuite").val($('<div>').html(data[0]['CMSUITE']).text());
            $("#txtCity").val($('<div>').html(data[0]['CMCITY']).text());
            $("#txtContact").val($('<div>').html(data[0]['CMCONTAC']).text());
            $("#txtPhone").val($('<div>').html(data[0]['CMPHONE']).text());
			$("#txtProv").val($('<div>').html(data[0]['PROV']).text());
            
            $("#txtCompantyDelivery").val($('<div>').html(data[0]['CMCOMPANYDELIVERY']).text());
            $("#txtAddressDelivery").val($('<div>').html(data[0]['CMADDRESSDELIVERY']).text());
            $("#txtSuiteDelivery").val($('<div>').html(data[0]['CMSUITEDELIVERY']).text());
            $("#txtCityDelivery").val($('<div>').html(data[0]['CMCITYDELIVERY']).text());
            $("#txtContactDelivery").val($('<div>').html(data[0]['CMCONTACDELIVERY']).text());
            $("#txtPhoneDelivery").val($('<div>').html(data[0]['CMPHONEDELIVERY']).text());
			$("#txtProvDelivery").val($('<div>').html(data[0]['PROVDELIVERY']).text());
            
			$("#cmbEstatus").val($('<div>').html(data[0]['IDSTATUS']).text());
			$("#cmbEstatus").css("color", $('<div>').html(data[0]['COLOR']).text());
			
			$("#cmbService").val($('<div>').html(data[0]['CMQUANTITY']).text());
			$("#cmbVehiculo").val($('<div>').html(data[0]['IDTYPETRUCK']).text());
			$("#txtInstructions").val($('<div>').html(data[0]['CMINSTRUCTIONS']).text());
			$("#txtQuanty").val($('<div>').html(data[0]['CMQUANTITY']).text());
            $("#txtWeight").val($('<div>').html(data[0]['CMWEIGHT']).text());
			$("#txtReference").val($('<div>').html(data[0]['CMREFERENCE']).text());
			
			$("#cmbMerchandise").val($('<div>').html(data[0]['MERCHANDISE_IDMERCHANDISE']).text());
			
			if (data[0]['TCCHANGECOLLECTIONPLACE'] == 1) {
				$("#txtTransfer").val($('<div>').html(data[0]['CMTRANSFER']).text());	
				$("#divTransfer").show(1000);
			} else {
				$("#divTransfer").hide(1000);
			}
			
			$("#txtNotas").val($('<div>').html(data[0]['NOTAS']).text());
			$("#txtPrecio").val($('<div>').html(data[0]['PRECIO']).text());
			
            $("#txtDriver").val($('<div>').html(data[0]['DNAME']).text());
            $("#idDriver").val($('<div>').html(data[0]['IDDRIVER']).text());
			
			$("#txtFecha").val($('<div>').html(data[0]['CMDATE']).text());
			$("#txtHora").val($('<div>').html(data[0]['HORA']).text());

			$("#slat").val($('<div>').html(data[0]['LATITUD']).text());
			$("#slon").val($('<div>').html(data[0]['LONGITUD']).text());

			$("#slat1").val($('<div>').html(data[0]['LATITUDENT']).text());
			$("#slon1").val($('<div>').html(data[0]['LONGITUDENT']).text());
			
			enabledForm(false);
			enabledAsignar(false);
        }
    });
}

function showCommandDetail(idCommand) {
    $('#frmDialog').css("height", "595px");
    $('#frmDialog').css("width", "899px");
    $('#frmDialog').attr('src', '../commands/details.php?iCommand=' + idCommand);
    $("#dialog").dialog({
        title: 'Detalle de la orden',
        height: '650',
        width: '900',
    });
    $("#dialog").dialog("open");
    return false;
}

function fnClickDriver(idDriver) {
	idDriverSelect = idDriver;
	$("#dv").val(idDriverSelect);


	stopCommandWorker();
	startCommandWorker();

	stopWorkerGeocercas();
	stopWorkerRastreo();
	

	startWorkerGeocercas();
	startWorkerGeocercas();


}

function onOpenWindowRastreo() {
	var sUrl = "../rastreo/admRastreo.php?dv=" + idDriverSelect;
	window.open(sUrl, "Rastreo", "menubar=no,location=no,resizable=yes,scrollbars=no,status=yes,toolbar=no");
}

function closeToWindow(idCommand) {
	$("#dialog").dialog("close");
	stopWorkerNewCommands();
	startWorkerNewCommands();

	jConfirm('¿Desea imprimir su comanda?', 'Impresión', function(r) {
		if(r) {
			btnImpresion(idCommand);
		}
	});
}

function startWorkerNewCommands() {
	if (typeof(Worker) !== "undefined") {
		if (typeof(wNC) == "undefined") {
			wNC = new Worker("../../../script/workers/getNewCommands.js");
		}
		wNC.onmessage = function(event) {
			if (sNewCommands != event.data) {
				var obj = $.parseJSON(event.data);
				createRowsNewCommands(obj);
				sNewCommands = event.data;
			}
		};
	} else {
		console.log("Sorry! No Web Worker support.");
	}
}

function startWorkerDrivers() {
	if (typeof(Worker) !== "undefined") {
		if (typeof(wDrivers) == "undefined") {
			wDrivers = new Worker("../../../script/workers/getDrivers.js");
		}
		wDrivers.onmessage = function(event) {
			if (oDriver != event.data) {
				$(".btnDrivers").remove();
                oDriver = event.data;
				var obj = $.parseJSON(event.data);
                for (var i in obj) {
                    createItemDriver(obj[i]["IDDRIVER"], obj[i]["DNAME"], obj[i]["ESTATUS"])
                }
            }
		};
	} else {
		console.log("Sorry! No Web Worker support.");
	}
}

function stopWorkerDrivers() {
	wDrivers.terminate();
	wDrivers = undefined;
}

function startWorkerNotification() {
	if (typeof(Worker) !== "undefined") {
		if (typeof(wNot) == "undefined") {
			wNot = new Worker("../../../script/workers/getCommandsNotification.js");
		}
		wNot.onmessage = function(event) {
			if (sNotifications != event.data) {
				var obj = $.parseJSON(event.data);
				if (obj[0]["iNotifications"] == "0") {
					$("#idRedNotification").hide();	
				} else {
					$("#idRedNotification").show();
				}
				
				$("#idNumberNotification").text(obj[0]["iNotifications"]);
				
				sNotifications = event.data;
			}
		};
	} else {
		console.log("Sorry! No Web Worker support.");
	}
}

function stopWorkerNewCommands() {
	wNC.terminate();
	wNC = undefined;
}

function createRowsNewCommands(jsonNewCommands) {
	$("#gridNewCommands").empty();
	var sClass = new Array("rowClaro", "rowObscuro");
	var x = 0;
	var i = 0;
	var y = 0;
	var prueba = 0;
	for (i in jsonNewCommands) {
		if (i != "remove") {
			var sAdress = jsonNewCommands[i].sAddress;
			var sAdressDelivery = jsonNewCommands[i].sAddressDelivery;

			if (jsonNewCommands[i].sAddress.length > 40) {
				sAdress = sAdress.substr(0, 40);
				sAdress = sAdress + "...";
			}

			if (jsonNewCommands[i].sAddressDelivery.length > 40) {
				sAdressDelivery = sAdressDelivery.substr(0, 40);
				sAdressDelivery = sAdressDelivery + "...";
			}

			var newRow = '<div class="row ' + sClass[x] + '" id="trNewCommand_' + jsonNewCommands[i].idCommand + '" onDblClick="fnDblKNewRow(' + jsonNewCommands[i].idCommand + ')">' +
				'<div class="col-sm-1" data-tip="Comanda número #' + jsonNewCommands[i].idCommand + '">' +
					'<label class="col-form-label">' + jsonNewCommands[i].idCommand + '</label>' +
				'</div>' +
				'<div class="col-sm-9">' +
					'<div class="row">' +
						'<div class="col-sm-2" data-tip="Fecha de ingreso ' + jsonNewCommands[i].sDateIngreso + '">' +
							'<label class="col-form-label">' + jsonNewCommands[i].sDateIngreso + '</label>' +
						'</div>' +
						'<div class="col-sm-5" data-tip="Salida ' + jsonNewCommands[i].sAddress + '">' +
							'<label class="col-form-label">' + sAdress + '</label>' +
						'</div>' +
						'<div class="col-sm-5" data-tip="Entrega ' + jsonNewCommands[i].sAddressDelivery + '">' +
							'<label class="col-form-label">' + sAdressDelivery + '</label>' +
						'</div>' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-2" data-tip="Fecha ' + jsonNewCommands[i].sDate + '">' +
					'<label class="col-form-label">' + jsonNewCommands[i].sDate + '</label>' +
				'</div>' +
			'</div>';

			$("#gridNewCommands").append(newRow);
			x++;
			if (x == 2) {
				x = 0;
			}
			y++;
		}
	}
	i = y;
	i++;
	for (i; i <= 13; i++) {
		var newRowDefault = '<div class="row ' + sClass[x] + '">' +
						'&nbsp;' +
					'</div>';
		$("#gridNewCommands").append(newRowDefault);
		x++;
		if (x == 2) {
			x = 0;
		}
	}

	$('label').disableSelection();
}

function startCommandWorker() {
	if (typeof(Worker) !== "undefined") {
		if (typeof(w) == "undefined") {
			var params = {
				btnToDay: btnToDay,
				btnCompleted : btnCompleted,
				iTipoFiltro : iValueSelect,
				dFechaSemana : $("#dateFilterWeekend").val(),
				iSelectFiltro : $("#cmbTipoFiltro").val(),
				dFechaInicio : $("#dateStart").val(),
				dFechaFinal : $("#dateEnd").val(),
				txtBusqueda : $("#txtSearch").val(),
				idDriverSelect: idDriverSelect
			}
			w = new Worker("../../../script/workers/getCommands.js");
			w.postMessage(params);
		}
		w.onmessage = function(event) {
			if (sDrivers != event.data) {
				sDrivers = event.data;
				var obj = $.parseJSON(event.data);
				createRowsCommands(obj);
			}
		};
	} else {
		console.log("Sorry! No Web Worker support.");
	}
}

function stopCommandWorker() {
	w.terminate();
	w = undefined;
}

function createRowsCommands(jsonCommands) {

	$("#gridCommands").empty();
	var sClass = new Array("rowClaro", "rowObscuro");
	var x = 0;
	var i = 0;
	var y = 0;
	for (i in jsonCommands) {
		if (i != "remove") {

			var newRow = '';

			var sHorario = jsonCommands[i].sSchedule;
			var sEntrega = jsonCommands[i].ENTREGA;
			var sAdress = jsonCommands[i].sAdress;
			var sAdressDelivery = jsonCommands[i].sAdressDelivery;

			if (!btnCompleted) {

				if (jsonCommands[i].sSchedule.length > 10) {
					sHorario = sHorario.substr(0, 7);
					sHorario = sHorario + "...";
				}
	
				if (sEntrega != undefined) {
					if (jsonCommands[i].ENTREGA.length > 10) {
						sEntrega = sEntrega.substr(0, 7);
						sEntrega = sEntrega + "...";
					}
				}
	
				if (sAdress.length > 35) {
					sAdress = sAdress.substr(0, 35);
					sAdress = sAdress + "...";
				}
	
				if (sAdressDelivery.length > 35) {
					sAdressDelivery = sAdressDelivery.substr(0, 35);
					sAdressDelivery = sAdressDelivery + "...";
				}
	


				var newRow = '<div class="row ' + sClass[x] + '" id="trCommand_' + jsonCommands[i].iCommand + '" onDblClick="fnDblKRow(' + jsonCommands[i].iCommand + ')">' +
					'<div class="col-sm-1" data-tip="Comanda número #' + jsonCommands[i].iCommand + '">' +
						'<label class="col-form-label">' + jsonCommands[i].iCommand + '</label>' +
					'</div>' +
					'<div class="col-sm-1" data-tip="Estatus ' + jsonCommands[i].sStatus + '">' +
						'<label class="col-form-label" style="color:' + jsonCommands[i].COLOR + ';">' + jsonCommands[i].sStatus + '</label>' +
					'</div>' +
					'<div class="col-sm-2">' +
						'<div class="row" data-tip="Tipo de comanda ' + jsonCommands[i].sTypeCommand + ' - ' + jsonCommands[i].NAME + '">' +
							'<div class="col-sm-6">' +
								'<label class="col-form-label" style="color:' + jsonCommands[i].TCCOLOR + ';" >' + jsonCommands[i].sTypeCommand + '</label>' +
							'</div>' +
							'<div class="col-sm-6">' +
								'<label class="col-form-label" style="color:' + jsonCommands[i].SCOLOR + ';" >' + jsonCommands[i].NAME + '</label>' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-6">' + 
						'<div class="row">' + 
							'<div class="col-sm-6" data-tip="Salida ' + jsonCommands[i].sAdress + '">' + 
								'<label class="col-form-label">' + sAdress + '</label>' +
							'</div>' +
							'<div class="col-sm-6" data-tip="Entrega ' + jsonCommands[i].sAdressDelivery + '">' + 
								'<label class="col-form-label">' + sAdressDelivery + '</label>' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-1" data-tip="' + jsonCommands[i].sSchedule + '">' +
						'<label class="col-form-label" style="font-size: 11px;">' + sHorario + '</label>' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<label class="col-form-label">' + jsonCommands[i].sDriver + '</label>' +
					'</div>' +
				'</div>';
			} else {

				if (jsonCommands[i].sSchedule.length > 10) {
					sHorario = sHorario.substr(0, 7);
					sHorario = sHorario + "...";
				}
	
				if (sEntrega != undefined) {
					if (jsonCommands[i].ENTREGA.length > 10) {
						sEntrega = sEntrega.substr(0, 7);
						sEntrega = sEntrega + "...";
					}
				}
	
				if (sAdress.length > 25) {
					sAdress = sAdress.substr(0, 25);
					sAdress = sAdress + "...";
				}
	
				if (sAdressDelivery.length > 25) {
					sAdressDelivery = sAdressDelivery.substr(0, 25);
					sAdressDelivery = sAdressDelivery + "...";
				}
	
				var newRow = '<div class="row ' + sClass[x] + '" id="trCommand_' + jsonCommands[i].iCommand + '" onDblClick="fnDblKRow(' + jsonCommands[i].iCommand + ')">' +
					'<div class="col-sm-1" data-tip="Comanda número #' + jsonCommands[i].iCommand + '">' +
						'<label class="col-form-label">' + jsonCommands[i].iCommand + '</label>' +
					'</div>' +
					'<div class="col-sm-1" data-tip="Estatus ' + jsonCommands[i].sStatus + '">' +
						'<label class="col-form-label" style="color:' + jsonCommands[i].COLOR + ';">' + jsonCommands[i].sStatus + '</label>' +
					'</div>' +
					'<div class="col-sm-2">' +
						'<div class="row" data-tip="Tipo de comanda ' + jsonCommands[i].sTypeCommand + ' - ' + jsonCommands[i].NAME + '">' +
							'<div class="col-sm-6">' +
								'<label class="col-form-label" style="color:' + jsonCommands[i].TCCOLOR + ';" >' + jsonCommands[i].sTypeCommand + '</label>' +
							'</div>' +
							'<div class="col-sm-6">' +
								'<label class="col-form-label" style="color:' + jsonCommands[i].SCOLOR + ';" >' + jsonCommands[i].NAME + '</label>' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-4">' + 
						'<div class="row">' + 
							'<div class="col-sm-6" data-tip="Salida ' + jsonCommands[i].sAdress + '">' + 
								'<label class="col-form-label">' + sAdress + '</label>' +
							'</div>' +
							'<div class="col-sm-6" data-tip="Entrega ' + jsonCommands[i].sAdressDelivery + '">' + 
								'<label class="col-form-label">' + sAdressDelivery + '</label>' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-1" data-tip="' + jsonCommands[i].ENTREGA + '">' +
						'<label class="col-form-label" style="margin: 0px;padding: 0px;">' + sEntrega + '</label>' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<label class="col-form-label">' + jsonCommands[i].sDriver + '</label>' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<label class="col-form-label">' + jsonCommands[i].sPrecio + '</label>' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<button class="btnDefaultAjust" style="min-width: 50px; width: 100%; height: 20px; font-size: 11px;" onclick="showCommandDetail(' + jsonCommands[i].iCommand + ')">Detalles</button>' +
					'</div>' +
				'</div>';
			}

			$("#gridCommands").append(newRow);
			x++;
			if (x == 2) {
				x = 0;
			}
			y++;
		}
	}
	i = y;
	i++;

	var nRows = 20;
	if (btnCompleted) {
		nRows = 33;
	}

	for (i; i <= nRows; i++) {
		var newRowDefault = '<div class="row ' + sClass[x] + '">' +
						'&nbsp;' +
					'</div>';
		$("#gridCommands").append(newRowDefault);
		x++;
		if (x == 2) {
			x = 0; 
		}
	}
}

function btnImpresion(idCommand) {
	var sUrl = "";

	if (idCommand == "") {
		sUrl = "../../../application/commands/createPdf.php?iCommand=" + $("#iCommand").val();
	} else {
		sUrl = "../../../application/commands/createPdf.php?iCommand=" + idCommand;
	}

	window.open(sUrl, "Impresión", "menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes");
}

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
	console.log("esa");
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
		(document.getElementById('txtAddressDelivery')), {
			types: ['geocode']
		});

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocompleteDel.addListener('place_changed', fillInAddressDel);
}

function fillInAddress() {
	console.log("esa1");
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();
	$("#txtAddress").val("");
	$("#txtCity").val("");
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
	}

	$("#slat").val(place.geometry.location.lat());
	$("#slon").val(place.geometry.location.lng());
	
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

function fillInAddressDel() {
	console.log("esa2");
	// Get the place details from the autocomplete object.
	var place = autocompleteDel.getPlace();
	$("#txtAddressDelivery").val("");
	$("#txtCityDelivery").val("");
	$("#txtProvDelivery").val("");
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
				$("#txtCityDelivery").val(val);
			}
		}

		if (addressType == "administrative_area_level_1") {
			var val = place.address_components[i]['short_name'];
			if (val != "undefined") {
				sProv = val;
			}
		}
	}

	$("#slat1").val(place.geometry.location.lat());
	$("#slon1").val(place.geometry.location.lng());
	
	$("#txtAddressDelivery").val(sAddress);
	$("#txtProvDelivery").val(sProv);
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

$(function() {
    "use strict";
    var onlyToday = false;
    var onlyCompleted = false;
    var onlyIdDriver = 0;

    function autocompleteDrivers() {
        $("#txtDriver").autocomplete({
            source: '../../../application/drivers/getDriversList.php',
            minLength: 2,
            select: function(event, ui) {
                $("#txtDriver").val(ui.item.DNAME);
                $("#idDriver").val(ui.item.IDDRIVER);
                return false;
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>").append("<div>" + item.DNAME + "</div>").appendTo(ul);
        };
        $("#txtDriver").change(function() {
            if ($("#txtDriver").val() == "") {
                $("#idDriver").val("0");
            } else {
                if ($("#idDriver").val() == "0") {
                    $("#txtDriver").val("");
                }
            }
        });
    }
	
	function showNewCommand(idCommand) {
		var w = (window.innerWidth - 200);
		$('#frmDialog').css("height", "840px");
		$('#frmDialog').css("width", (w - 10));
		$('#frmDialog').attr('src', '../commands/add.php');
		$("#dialog").dialog({
			title: 'Detalle de la orden',
			height: '902',
			width: w,
		});
		$("#dialog").dialog("open");
		return false;
	}

    function showDrivers() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../drivers/index.php');
        $("#dialog").dialog({
            title: 'Gestión de conductores',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }
	
	function showMerchandise() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../merchandise/index.php');
        $("#dialog").dialog({
            title: 'Gestión de mercancias',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }
	
	function showStatus() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../status/index.php');
        $("#dialog").dialog({
            title: 'Gestión de Estatus',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }

    function showCustomers() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../customers/index.php');
        $("#dialog").dialog({
            title: 'Gestión de clientes',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }

    function showTypeTrucks() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../typetrucks/index.php');
        $("#dialog").dialog({
            title: 'Gestión de Vehículos',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }

    function showScheduler() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../schedules/index.php');
        $("#dialog").dialog({
            title: 'Gestión de Horarios',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }

    function showHolidays() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../holidays/index.php');
        $("#dialog").dialog({
            title: 'Gestión de días festivos',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }

    function showServices() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../services/index.php');
        $("#dialog").dialog({
            title: 'Gestión de servicios',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }
	
	function showSubServices() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../subservices/index.php');
        $("#dialog").dialog({
            title: 'Gestión de servicios',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }
	
	function showNotification() {
        $('#frmDialog').css("height", "422px");
        $('#frmDialog').css("width", "590px");
        $('#frmDialog').attr('src', '../commands/commandsNotification.php');
        $("#dialog").dialog({
            title: 'Notificaciones',
            height: '485',
            width: '600',
        });
        $("#dialog").dialog("open");
        return false;
    }

    function addCommand() {
        window.location.href = "add.php";
    }

    function setDriverToCommand() {
        if ($("#iCommand").val() != "0") {
            var datos = {
                idCommand: $("#iCommand").val(),
				sNombre: $("#txtNombre").val(),
				sNotas: $("#txtNotas").val(),
				sPrecio: $("#txtPrecio").val(),
                iDriver: $("#idDriver").val()
				
            }
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../../../application/commands/setDriverToCommands.php',
                data: datos,
                success: function(data) {
                    if (data.success) {
                        cleanForm();
                        rowNewCommands = [];
                        $(".selectRow").removeClass("selectRow");
                        $("#idDriver").val("0");
                        $("#txtDriver").val("");
                        stopCommandWorker();
                        startCommandWorker();
                        stopWorkerNewCommands()
                        startWorkerNewCommands();
						enabledForm(true);
						enabledAsignar(true);
                    }
                }
            });
        } else {
            jAlert('Por favor seleccione por lo menos una comanda nueva a asignar.', 'Notificación');
        }
    }

    function cancelCommand() {
		cleanForm();
		enabledForm(true);
		enabledAsignar(true);
		$(".selectRow").removeClass("selectRow")
        $(".selectRowD").removeClass("selectRowD")
		$("#divTransfer").hide(1000);
    }
	
	function btnOrdenesDia() {
        $("#lblAntes").text("Hora");
		iValueSelect = "";
		cancelCommand();
		$("#divCenter").removeClass("col-sm-9");
		$("#divCenter").addClass("col-sm-7");
		$("#divLeft").show(1000);
		$("#divClientes").show(1000);
		$("#divFiltros").hide(1000);
		
		$("#divFechasSearch").hide(1000);
		$("#divSearch").hide(1000);
		$('#dateEnd').datepicker("option", "minDate", null);
		$('#dateStart').datepicker("option", "maxDate", null);
		$("#dateFilterWeekend").prop('disabled', true);
		$("#cmbTipoFiltro").prop('disabled', true);
		
		$("#dateFilterWeekend").val("");
		$("#cmbTipoFiltro").val("");
		$("#dateStart").val("");
		$("#dateEnd").val("");
		$("#txtSearch").val("");

		var $radios = $('input:radio[name=btnSearch]');
		if($radios.is(':checked') === true) {
			$radios.prop('checked', false);
		}
		
		setTimeout(function() {	
			$("#divBottom").show(1000);
			
			$(".sectionUp").css("height", "513px");
			
			$("#divDireccion").removeClass("col-sm-4")
			$("#divDireccion").addClass("col-sm-6")
			$("#divPrecio").hide(1000);
			$("#divDetalles").hide(1000);
		}, 1000);
		btnCompleted = false;
		stopCommandWorker();
		startCommandWorker();
	}

	function btnCompletadas() {
        $("#lblAntes").text("Fecha");
		iValueSelect = "";
		cancelCommand();
		$("#divLeft").hide(1000);
		$("#divClientes").hide(1000);
		setTimeout(function() {
			$("#divCenter").removeClass("col-sm-7");
			$("#divCenter").addClass("col-sm-9");
			
			$("#divBottom").hide(1000);
			$("#divFiltros").show(1000);
			
			$(".sectionUp").css("height", "868px");
			
			$("#divDireccion").removeClass("col-sm-6")
			$("#divDireccion").addClass("col-sm-4")
			$("#divPrecio").show(1000);
			$("#divDetalles").show(1000);
		}, 1000);
		btnCompleted = true;
		stopCommandWorker();
		startCommandWorker();
	}
	
	function btnSearch() {
		stopCommandWorker();
		startCommandWorker();
	}
	
	function btnTodas() {
		btnToDay = false;
		btnCompleted = false;
		stopCommandWorker();
		startCommandWorker();
	}
	
	function editaCommand() {
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '../../../application/commands/setCommand.php',
			data: $("#frmEditar").serialize(),
			success: function(data) {
				cancelCommand();
				rowNewCommands = [];
				$(".selectRow").removeClass("selectRow");
				$("#idDriver").val("0");
				$("#txtDriver").val("");
				stopCommandWorker();
				startCommandWorker();
				stopWorkerNewCommands()
				startWorkerNewCommands();
			}
		});
	}

	function changeDireccion() {
		var sCompania = $("#txtCompanty").val();
		var sContacto = $("#txtContact").val();
		var sDireccion = $("#txtAddress").val();
		var sLat = $("#slat").val();
		var sLong = $("#slon").val();
		var sApt = $("#txtSuite").val();
		var sCiudad = $("#txtCity").val();
		var sProv = $("#txtProv").val();
		var sTelefono = $("#txtPhone").val();
		
		var sCompaniaDelivery = $("#txtCompantyDelivery").val();
		var sContactoDelivery = $("#txtContactDelivery").val();
		var sDireccionDelivery = $("#txtAddressDelivery").val();
		var sLatDelivery = $("#slat1").val();
		var sLongDelivery = $("#slon1").val();
		var sAptDelivery = $("#txtSuiteDelivery").val();
		var sCiudadDelivery = $("#txtCityDelivery").val();
		var sProvDelivery = $("#txtProvDelivery").val();
		var sTelefonoDelivery = $("#txtPhoneDelivery").val();

		$("#txtCompanty").val(sCompaniaDelivery);
		$("#txtContact").val(sContactoDelivery);
		$("#txtAddress").val(sDireccionDelivery);
		$("#slat").val(sLatDelivery);
		$("#slon").val(sLongDelivery);
		$("#txtSuite").val(sAptDelivery);
		$("#txtCity").val(sCiudadDelivery);
		$("#txtProv").val(sProvDelivery);
		$("#txtPhone").val(sTelefonoDelivery);
		
		$("#txtCompantyDelivery").val(sCompania);
		$("#txtContactDelivery").val(sContacto);
		$("#txtAddressDelivery").val(sDireccion);
		$("#slat1").val(sLat);
		$("#slon1").val(sLong);
		$("#txtSuiteDelivery").val(sApt);
		$("#txtCityDelivery").val(sCiudad);
		$("#txtProvDelivery").val(sProv);
		$("#txtPhoneDelivery").val(sTelefono);


	}
	
    function inicializa() {
		$("#divCatalogos").hide();
		$("#divPrecio").hide();
		$("#divDetalles").hide();
		$("#divFiltros").hide();
		$("#divFechasSearch").hide();
		$("#divSearch").hide();
		
		$("#dateFilterWeekend").prop('disabled', true);
		$("#cmbTipoFiltro").prop('disabled', true);
		
		$("#btnCatalogos").click(function() {
			if($("#divCatalogos").is(":visible")) {
				$("#divCatalogos").hide(1000);
			} else {
				$("#divCatalogos").show(1000);	
			}
		});
		
		$('#cmbTypeCommand').change(function(){
			var dataColor = $(this).find(':selected').attr('data-color');
			if ((dataColor != "") && (dataColor != undefined)) {
				$('#cmbTypeCommand').css("color", dataColor);
			} else {
				$('#cmbTypeCommand').css("color", "#000000");;
			}
		});
		
		$('#cmbService').change(function(){
			var dataColor = $(this).find(':selected').attr('data-color');
			if ((dataColor != "") && (dataColor != undefined)) {
				$('#cmbService').css("color", dataColor);
			} else {
				$('#cmbService').css("color", "#000000");;
			}
		});
		
		$('#cmbEstatus').change(function(){
			var dataColor = $(this).find(':selected').attr('data-color');
			if ((dataColor != "") && (dataColor != undefined)) {
				$('#cmbEstatus').css("color", dataColor);
			} else {
				$('#cmbEstatus').css("color", "#000000");;
			}
		});
		
		$('input[type=radio][name=btnSearch]').change(function() {
			$("#dateFilterWeekend").prop('disabled', true);
			$("#cmbTipoFiltro").prop('disabled', true);
			
			$("#divFechasSearch").hide(1000);
			$("#divSearch").hide(1000);
			
			$("#dateFilterWeekend").val("");
			$("#cmbTipoFiltro").val("");
			$("#dateStart").val("");
			$("#dateEnd").val("");
			$("#txtSearch").val("");
			
			iValueSelect = this.value;
			
			if (this.value == '1') {
				$("#dateFilterWeekend").prop('disabled', false);
			}
			else if (this.value == '2') {
				$("#cmbTipoFiltro").prop('disabled', false);
			}
		});
		
		$('#cmbTipoFiltro').change(function(){
			
			$("#divFechasSearch").hide(1000);
			$("#divSearch").hide(1000);
			$('#dateEnd').datepicker("option", "minDate", null);
			$('#dateStart').datepicker("option", "maxDate", null);
			
			var idSelect = $(this).val();
			
			setTimeout(function() {
				if (idSelect == 1) {
					$("#divFechasSearch").show(1000);
				} else {
					$("#divSearch").show(1000);
				}
			}, 1000)
		});
		
		if($("#txtDriver").length != 0) {
			autocompleteDrivers();
        	startWorkerDrivers();	
			$("#btnChoferes").click(showDrivers);
			$("#btnClientes").click(showCustomers);
			$("#btnVehiculos").click(showTypeTrucks);
			$("#btnHorarios").click(showScheduler);
			$("#btnFestivos").click(showHolidays);
			$("#btnAsignar").click(setDriverToCommand);
			$("#btnServicios").click(showServices);
			$("#btnSubServicios").click(showSubServices);
			$("#btnMercancia").click(showMerchandise);
			$("#btnStatus").click(showStatus);
		}

		$("#btnCambiar").click(changeDireccion);

		$("#btnRastreo").click(function() {
			onOpenWindowRastreo();
		});	
		
		$("#btnImprimir").click(function() {
			btnImpresion("");
		});
		
        $("#dialog").dialog({
            autoOpen: false,
            show: "fade",
            hide: "fade",
            modal: true,
            resizable: false,
            close: function(event, ui) {
                $('#frmDialog').attr('src', '');	
            }
        });
		
       
        $("#addComanda").click(showNewCommand);
        $("#btnCancelar").click(cancelCommand);
		$("#idNotification").click(showNotification);
		
		$("#btnOrdenDia").click(btnOrdenesDia);
		$("#btnOrdenesCompletas").click(btnCompletadas);
		$("#divTransfer").hide();
		
		$("#btnBuscar").click(btnSearch);
		
		$("#dateFilterWeekend").datepicker({
			beforeShowDay: function(date){ 
			  var day = date.getDay(); 
			  return [day == 1, ""];
			}
		});
		
		$("#dateStart").datepicker({ 
			dateFormat: 'dd-mm-yy',  
			beforeShowDay: $.datepicker.noWeekends 
		});
		
		$("#dateEnd").datepicker({ 
			dateFormat: 'dd-mm-yy',  
			beforeShowDay: $.datepicker.noWeekends 
		});
		
		$('#dateStart').change(function() {
			$('#dateEnd').datepicker("option", "minDate", $('#dateStart').val());
		});
		
		$('#dateEnd').change(function() {
			$('#dateStart').datepicker("option", "maxDate", $('#dateEnd').val());
		});

		$("#btnMap").click(function() {
			var sUrl = "";

			sUrl = "../../application/commands/showRuta.php?iCommand=" + $("#iCommand").val();

			window.open(sUrl, "Ruta", "menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes");
		})
		
        startCommandWorker();
        startWorkerNewCommands();
		startWorkerNotification();
		
		enabledForm(true);
		enabledAsignar(true);
		
		
		
		$('#frmEditar').validator().on('submit', function (e) {
			if (!e.isDefaultPrevented()) {
				editaCommand();
				return false;
			}
		});
    }

    $(document).ready(inicializa);
	
});