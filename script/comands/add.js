function loadSubServices(idServicio) {
	var params = {
		idService : idServicio
	};
	
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
				$("#cmbService").append("<option value='" + oServices[i]["IDSUBSERVICES"] + "' data-id='" + oServices[i]["SCHEDULES_IDSCHEDULE"] + "' data-color='" + oServices[i]["COLOR"] + "' style='color:" + oServices[i]["COLOR"] + "'>" + oServices[i]["NAME"] + "</option>");
			}
		}
	});
}

function setTipoOrden(sNombre, sTipo, bChange, sColor, element) {
	"use strict";
	loadSubServices(sTipo);
	$("#lblTipoOrden").text(sNombre);
	$("#lblTipoOrden").css("color", sColor);
	
	$("#idTipoOrden").val(sTipo);

	$("#changeAddress").prop('checked', false);
	$("#changeAddress1").prop('checked', false);
	$("#changeAddress2").prop('checked', false);

	if ($(element).data("salida") == "0") {
		$("#changeAddressLbl").hide();
		$("#changeAddress").hide();
	} else {
		$("#changeAddressLbl").show();
		$("#changeAddress").show();
	}

	if ($(element).data("entrega") == "0") {
		$("#changeAddressLbl1").hide();
		$("#changeAddress1").hide();
	} else {
		$("#changeAddressLbl1").show();
		$("#changeAddress1").show();
	}

	if ($(element).data("retorno") == "0") {
		$("#changeAddressLbl2").hide();
		$("#changeAddress2").hide();
	} else {
		$("#changeAddressLbl2").show();
		$("#changeAddress2").show();
	}
	
	if(bChange == 1) { 
		$("#divSalidaTit").removeClass("col-sm-6");
		$("#divSalidaTit").addClass("col-sm-4");
		$("#divCambioTit").removeClass("col-sm-6");
		$("#divCambioTit").addClass("col-sm-4");
		$("#divRetornoTit").show();
		
		$("#divSalida").removeClass("col-sm-6");
		$("#divSalida").addClass("col-sm-4");
		$("#divCambio").removeClass("col-sm-6");
		$("#divCambio").addClass("col-sm-4");
		$("#divRetorno").show();
		$("#rowTransfer").show();
	} else {
		$("#divSalidaTit").addClass("col-sm-6");
		$("#divSalidaTit").removeClass("col-sm-4");
		$("#divCambioTit").addClass("col-sm-6");
		$("#divCambioTit").removeClass("col-sm-4");
		$("#divRetornoTit").hide();
		
		$("#divSalida").addClass("col-sm-6");
		$("#divSalida").removeClass("col-sm-4");
		$("#divCambio").addClass("col-sm-6");
		$("#divCambio").removeClass("col-sm-4");
		$("#divRetorno").hide();

		if (sTipo == 47) {
			$("#rowTransfer").show();
		} else {
			$("#rowTransfer").hide();
		}
	}
}

$(function() {
	"use strict";
	
	function onlyNumbers(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }
	
	function regresar() {
		jConfirm('¿Esta seguro que desea regresar? Se eliminaran los datos ingresados.', 'Notificación', function(r) {
			if (r) {
				window.location.href = "commandsAdm.php";
			} 
		});
	}

	function cleanForms() {
		$('#frmFormulario')[0].reset();
	}
	
	function fnautocomplete() {
		$("#txtCompany").autocomplete({
			source: function (request, response) {
				request.changeAddress = $("#changeAddress").is(":checked");
				$.post('../../../application/commands/getDataCustomer.php', request, response);
			},
			minLength: 2,
			select: function( event, ui ) {
				$("#txtCompany").val(ui.item.COMPANY);
				$("#txtAddress").val(ui.item.ADDRESS);
				$("#txtSuite").val(ui.item.SUITE);
				$("#txtCity").val(ui.item.CITY);
				$("#txtCp").val(ui.item.CP);
				$("#sLat").val(ui.item.LATITUD);
				$("#sLon").val(ui.item.LONGITUD);
				
				return false;
			}
		}).autocomplete("instance")._renderItem = function (ul, item) {
			var sDescripcion = "<div>"
			var xComa = "";
			
			if(item.COMPANY != "") {
				sDescripcion += xComa + item.COMPANY;
				xComa = ", ";
			}

			if (!$("#changeAddress").is(":checked")) { 
				if(item.ADDRESS != "") {
					sDescripcion += xComa + item.ADDRESS;
					xComa = ", ";
				}

				sDescripcion += "<br>";
				if(item.CITY != "") {
					sDescripcion += xComa + item.CITY;
					xComa = ", ";
				}

				if(item.CP != "") {
					sDescripcion += xComa + item.CP;
					xComa = ", ";
				}
			}
			
			sDescripcion += "</div>";
			xComa = "";

			return $("<li>")
				.append(sDescripcion)
				.appendTo(ul);
		};
	}
	
	function autocompleteDelivery() {
		$("#txtCompany1").autocomplete({
			source: function (request, response) {
				request.changeAddress = $("#changeAddress1").is(":checked");
				$.post('../../../application/commands/getDataCustomer.php', request, response);
			},
			minLength: 2,
			select: function( event, ui ) {
				$("#txtCompany1").val(ui.item.COMPANY);
				$("#txtAddress1").val(ui.item.ADDRESS);
				$("#txtSuite1").val(ui.item.SUITE);
				$("#txtCity1").val(ui.item.CITY);
				$("#txtCp1").val(ui.item.CP);
				$("#sLat1").val(ui.item.LATITUD);
				$("#sLon1").val(ui.item.LONGITUD);
				
				return false;
			}
		}).autocomplete("instance")._renderItem = function (ul, item) {
			var sDescripcion = "<div>"
			var xComa = "";
			
			if(item.COMPANY != "") {
				sDescripcion += xComa + item.COMPANY;
				xComa = ", ";
			}
			
			if (!$("#changeAddress1").is(":checked")) { 
				if(item.ADDRESS != "") {
					sDescripcion += xComa + item.ADDRESS;
					xComa = ", ";
				}

				sDescripcion += "<br>";
				if(item.CITY != "") {
					sDescripcion += xComa + item.CITY;
					xComa = ", ";
				}

				if(item.CP != "") {
					sDescripcion += xComa + item.CP;
					xComa = ", ";
				}
			}
			
			sDescripcion += "</div>";
			xComa = "";

			return $("<li>")
				.append(sDescripcion)
				.appendTo(ul);
		};
	}
	
	function autocompleteChange() {
		$("#txtCompany2").autocomplete({
			source: function (request, response) {
				request.changeAddress = $("#changeAddress2").is(":checked");
				$.post('../../../application/commands/getDataCustomer.php', request, response);
			},
			minLength: 2,
			select: function( event, ui ) {
				$("#txtCompany2").val(ui.item.COMPANY);
				$("#txtAddress2").val(ui.item.ADDRESS);
				$("#txtSuite2").val(ui.item.SUITE);
				$("#txtCity2").val(ui.item.CITY);
				$("#txtCp2").val(ui.item.CP);
				$("#sLat2").val(ui.item.LATITUD);
				$("#sLon2").val(ui.item.LONGITUD);

				return false;
			}
		}).autocomplete("instance")._renderItem = function (ul, item) {
			var sDescripcion = "<div>"
			var xComa = "";
			
			if(item.COMPANY != "") {
				sDescripcion += xComa + item.COMPANY;
				xComa = ", ";
			}

			if (!$("#changeAddress2").is(":checked")) { 
				if(item.ADDRESS != "") {
					sDescripcion += xComa + item.ADDRESS;
					xComa = ", ";
				}

				sDescripcion += "<br>";
				if(item.CITY != "") {
					sDescripcion += xComa + item.CITY;
					xComa = ", ";
				}

				if(item.CP != "") {
					sDescripcion += xComa + item.CP;
					xComa = ", ";
				}
			}
			
			sDescripcion += "</div>";
			xComa = "";

			return $("<li>")
				.append(sDescripcion)
				.appendTo(ul);
		};
	}
	
	function validaForm() {
		if ($("#idTipoOrden").val() == "0") {
			jAlert('Por favor seleccione el tipo de comanda a realizar.', 'Notificación');
			return false;
		} 
		
		return true;
	}

	function changeAddress() {
		$("#txtCompany").val("");
		$("#txtContact").val("");
		$("#txtAddress").val("");
		$("#sLat").val("");
		$("#sLon").val("");
		$("#txtSuite").val("");
		$("#txtCity").val("");
		$("#txtCp").val("");
		$("#txtPhone").val("");

		// if($("#changeAddress").is(":checked")) { 
		// 	$("#divSalidaTit").removeClass("col-sm-6");
		// 	$("#divSalidaTit").addClass("col-sm-4");
		// 	$("#divCambioTit").removeClass("col-sm-6");
		// 	$("#divCambioTit").addClass("col-sm-4");
		// 	$("#divRetornoTit").show();
			
		// 	$("#divSalida").removeClass("col-sm-6");
		// 	$("#divSalida").addClass("col-sm-4");
		// 	$("#divCambio").removeClass("col-sm-6");
		// 	$("#divCambio").addClass("col-sm-4");
		// 	$("#divRetorno").show();
		// 	$("#rowTransfer").show();
		// } else {
		// 	$("#divSalidaTit").addClass("col-sm-6");
		// 	$("#divSalidaTit").removeClass("col-sm-4");
		// 	$("#divCambioTit").addClass("col-sm-6");
		// 	$("#divCambioTit").removeClass("col-sm-4");
		// 	$("#divRetornoTit").hide();
			
		// 	$("#divSalida").addClass("col-sm-6");
		// 	$("#divSalida").removeClass("col-sm-4");
		// 	$("#divCambio").addClass("col-sm-6");
		// 	$("#divCambio").removeClass("col-sm-4");
		// 	$("#divRetorno").hide();
		// 	$("#rowTransfer").hide();
		// }
	}

	function changeAddress2() {
		$("#txtCompany2").val("");
		$("#txtContact2").val("");
		$("#txtAddress2").val("");
		$("#sLat2").val("");
		$("#sLon2").val("");
		$("#txtSuite2").val("");
		$("#txtCity2").val("");
		$("#txtCp2").val("");
		$("#txtPhone2").val("");
	}

	function cleanFormsLimpiar() {
		$("#changeAddressLbl1").val("");
		$("#txtCompany1").val("");
		$("#txtContact1").val("");
		$("#txtAddress1").val("");
		$("#txtSuite1").val("");
		$("#txtCity1").val("");
		$("#txtProv1").val("");
		$("#txtCp1").val("");
		$("#sLat1").val("");
		$("#sLon1").val("");
		$("#txtPhone1").val("");
		$("#txtCellPhone1").val("");

		/*$("#txtCompany2").text("");
		$("#txtContact2").text("");
		$("#txtAddress2").text("");
		$("#sLat2").text("");
		$("#sLon2").text("");
		$("#txtSuite2").text("");
		$("#txtCity2").text("");
		$("#txtProv2").text("");
		$("#txtCp2").text("");
		$("#txtPhone2").text("");
		$("#txtCellPhone2").text("");*/

		$("#cmbMerchandise").val("");
		$("#cmbTypeTruck").val("");
		$("#txtCantidad").val("");
		$("#txtPeso").val("");
		$("#txtReference").val("");
		$("#txtNoTransfer").val("");
		$("#txtDescription").val("");
		$("#txtInstructions").val("");
	}
	
	function inicializa() {
		$("#divRetornoTit").hide();
		$("#divRetorno").hide();
		
		$('#cmbService').change(function(){
			var dataColor = $(this).find(':selected').attr('data-color');
			if ((dataColor != "") && (dataColor != undefined)) {
				$('#cmbService').css("color", dataColor);
			} else {
				$('#cmbService').css("color", "#000000");;
			}
		});

		$("#changeAddressLbl").hide();
		$("#changeAddress").hide();

		$("#changeAddressLbl1").hide();
		$("#changeAddress1").hide();

		$("#changeAddressLbl2").hide();
		$("#changeAddress2").hide();
		
		$("#txtPhone").keydown(onlyNumbers);
		$("#txtCellPhone").keydown(onlyNumbers);
		
		$("#txtPhone1").keydown(onlyNumbers);
		$("#txtCellPhone1").keydown(onlyNumbers);
		
		$("#txtPhone1").keydown(onlyNumbers);
		$("#txtCellPhone1").keydown(onlyNumbers);
		
		$("#txtCantidad").keydown(onlyNumbers);
		$("#txtPeso").keydown(onlyNumbers);

		$("#btnLimpiar").click(cleanFormsLimpiar);
		
		$("#sDate").keydown(function(e) {
			e.preventDefault();
		});

		$("#changeAddress").change(changeAddress);
		$("#changeAddress2").change(changeAddress2);

		
		$('#cmbService').change(function(){
			var dataId = $(this).find(':selected').attr('data-id');
			if ((dataId != "") && (dataId != undefined)) {
				$('#cmbHorario1').val(dataId);
				$('#cmbHorario').val(dataId);
			} else {
				$('#cmbHorario1').val(0);
				$('#cmbHorario').val(0);
			}
		});

		$('#frmAlta').validator().on('submit', function (e) {
			if (!e.isDefaultPrevented()) {
				var sLat = $("#sLat").val();
				var sLon = $("#sLon").val();

				var sLat1 = $("#sLat1").val();
				var sLon1 = $("#sLon1").val();

				var sLat2 = $("#sLat2").val();
				var sLon2 = $("#sLon2").val();	

				if((sLat == "") || (sLon == "")) {
					bReturn = false;
					jAlert('Por favor en los campos de salida seleccione su direción de la lista desplegable', 'Error');
					return bReturn;
				} 

				if((sLat1 == "") || (sLon1 == "")) {
					bReturn = false;
					jAlert('Por favor en los campos de entrega seleccione su direción de la lista desplegable', 'Error');
					return bReturn;
				} 

				if($("#divRetorno").is(":visible")) {
					if((sLat2 == "") || (sLon2 == "")) {
						bReturn = false;
						jAlert('Por favor en los campos de retorno seleccione su direción de la lista desplegable', 'Error');
						return bReturn;
					} 
				}

				var bReturn = true;
				return bReturn;
  			}
		})
		
		$("#rowTransfer").hide();
		
		fnautocomplete();
		autocompleteDelivery();
		autocompleteChange();
	}
	
	$(document).ready(inicializa);
});
