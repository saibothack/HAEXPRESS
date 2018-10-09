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
	
	$("#iCommand").val("0");
	
	$("#cmbTypeCommand").val("");
	$("#cmbMerchandise").val("");
	
	$("#cmbService").css("color", "#000000");
	
	$("#divTransfer").hide(1000);
	$('#cmbTypeCommand').css("color", "#000000");
	$("#cmbEstatus").css("color", "#000000");
	
}

function enabledForm(bEnabled) {
	$("#btnImprimir").prop('disabled', bEnabled);
	$("#btnCancelar").prop('disabled', bEnabled);
}

function fnDblKRow(idComanda) {
    cleanForm();
    var id = "#trCommand_" + idComanda;
    if ($(id).hasClass('selectRowD')) {
        $(id).removeClass('selectRowD');
		enabledForm(true);
    } else {
        $(".selectRow").removeClass("selectRow");
        $(".selectRowD").removeClass("selectRowD");
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
			
			enabledForm(false);
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
				if (jsonCommands[i].sSchedule.length > 20) {
					sHorario = sHorario.substr(0, 20);
					sHorario = sHorario + "...";
				}
	
				if (sEntrega != undefined) {
					if (jsonCommands[i].ENTREGA.length > 20) {
						sEntrega = sEntrega.substr(0, 20);
						sEntrega = sEntrega + "...";
					}
				}
	
				if (sAdress.length > 50) {
					sAdress = sAdress.substr(0, 50);
					sAdress = sAdress + "...";
				}
	
				if (sAdressDelivery.length > 50) {
					sAdressDelivery = sAdressDelivery.substr(0, 50);
					sAdressDelivery = sAdressDelivery + "...";
				}

				var newRow = '<div class="row ' + sClass[x] + '" id="trCommand_' + jsonCommands[i].iCommand + '">' +
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
					'<div class="col-sm-5">' + 
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
					'<div class="col-sm-1">' +
						'<button type="button" class="btnDefaultAjust" style="min-width: 50px; width: 100%; height: 20px; font-size: 11px;" onclick="btnImpresion(' + jsonCommands[i].iCommand + ')">Imprimir</button>' +
					'</div>' +
				'</div>';
			} else {
				if (jsonCommands[i].sSchedule.length > 10) {
					sHorario = sHorario.substr(0, 7);
					sHorario = sHorario + "...";
				}
	
				if (sEntrega != undefined) {
					if (jsonCommands[i].ENTREGA.length > 20) {
						sEntrega = sEntrega.substr(0, 20);
						sEntrega = sEntrega + "...";
					}
				}
	
				if (sAdress.length > 60) {
					sAdress = sAdress.substr(0, 60);
					sAdress = sAdress + "...";
				}
	
				if (sAdressDelivery.length > 60) {
					sAdressDelivery = sAdressDelivery.substr(0, 60);
					sAdressDelivery = sAdressDelivery + "...";
				}

				var newRow = '<div class="row ' + sClass[x] + '" id="trCommand_' + jsonCommands[i].iCommand + '">' +
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
						'<button type="button" class="btnDefaultAjust" style="min-width: 50px; width: 100%; height: 20px; font-size: 11px;" onclick="showCommandDetail(' + jsonCommands[i].iCommand + ')">Detalles</button>' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<button type="button" class="btnDefaultAjust" style="min-width: 50px; width: 100%; height: 20px; font-size: 11px;" onclick="btnImpresion(' + jsonCommands[i].iCommand + ')">Imprimir</button>' +
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

	var nRows = 30;
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

function closeToWindow(idCommand) {
	$("#dialog").dialog("close");
	stopCommandWorker();
	startCommandWorker();

	jConfirm('¿Desea imprimir su comanda?', 'Impresión', function(r) {
		if(r) {
			btnImpresion(idCommand);
		}
	});
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

$(function() {
    "use strict";
    var onlyToday = false;
    var onlyCompleted = false;
    var onlyIdDriver = 0;
	
	$("#txtCompanty").prop('disabled', true);
	$("#txtAddress").prop('disabled', true);
	$("#txtSuite").prop('disabled', true);
	$("#txtCity").prop('disabled', true);
	$("#txtProv").prop('disabled', true);
	$("#txtContact").prop('disabled', true);
	$("#txtPhone").prop('disabled', true);
	
	$("#txtCompantyDelivery").prop('disabled', true);
	$("#txtAddressDelivery").prop('disabled', true);
	$("#txtSuiteDelivery").prop('disabled', true);
	$("#txtCityDelivery").prop('disabled', true);
	$("#txtProvDelivery").prop('disabled', true);
	$("#txtContactDelivery").prop('disabled', true);
	$("#txtPhoneDelivery").prop('disabled', true);
	
	$("#cmbEstatus").prop('disabled', true);
	$("#cmbVehiculo").prop('disabled', true);
	$("#txtInstructions").prop('disabled', true);
	$("#cmbService").prop('disabled', true);
	$("#txtQuanty").prop('disabled', true);
	$("#txtWeight").prop('disabled', true);
	$("#txtReference").prop('disabled', true);
	$("#txtTransfer").prop('disabled', true);

	$("#cmbTypeCommand").prop('disabled', true);
	$("#cmbMerchandise").prop('disabled', true);
	
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

    function cancelCommand() {
		cleanForm();
		enabledForm(true);
		$(".selectRow").removeClass("selectRow")
        $(".selectRowD").removeClass("selectRowD")
		$("#divTransfer").hide(1000);
    }
	
	function btnOrdenesDia() {
        $("#lblAntes").text("Antes");
		iValueSelect = "";
		cancelCommand();
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
			$("#divClientes").show(1000);
			$("#divBottom").show(1000);
			$("#divPrecio").hide(1000);
			$("#divDetalles").hide(1000);
            $("#divDireccion").removeClass("col-sm-4")
			$("#divDireccion").addClass("col-sm-5")
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
			$("#divBottom").hide(1000);
			$("#divFiltros").show(1000);
            $("#divDireccion").removeClass("col-sm-5")
			$("#divDireccion").addClass("col-sm-4")
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
	
    function inicializa() {
		$("#divFiltros").hide();
		$("#divFechasSearch").hide();
		$("#divSearch").hide();
        $("#divDetalles").hide();
		
		$("#dateFilterWeekend").prop('disabled', true);
		$("#cmbTipoFiltro").prop('disabled', true);
		
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

		$("#btnImprimir").click(function() {
			btnImpresion("");
		});
		
        startCommandWorker();
		startWorkerNotification();
		
		enabledForm(true);
    }

    $(document).ready(inicializa);
	
});