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
	
	function chekFinal() {
		$("#txtHorasVisibles").val("");
		if(this.checked) {
            $("#txtHorasVisibles").prop('disabled', false);
        } else {
			$("#txtHorasVisibles").prop('disabled', true);
		}
	}
	
	function chekInicial() {
		if(this.checked) { 
			if(checkStatusInicial()) {
				return false;
			} else {
				if($('#chkFinal').is(':checked'))  {
					jConfirm('Usted tiene seleccionado el estatus como final si desea utilizarlo como inicial, se deseleccionara el check de final y las horas activas, ¿desea continuar?', 'Notificación', function(r) {
						if(r) {
							$('#chkFinal').prop('checked', false);
							$("#txtHorasVisibles").val("");
							$("#txtHorasVisibles").prop('disabled', true);
						} else {
							$('#chkInicia').prop('checked', false);
						}
					});	
				} 
			}
		}
	}
	
	function checkStatusInicial() {
		var sStatus = false;
		
		var data = {
			noServicio : $("#iStatus").val()
		}
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '../../../application/status/setStatusInicia.php',
			data: data,
			async: false,
			success: function (data) {
				if(data[0].SUMA != 0) {
					$('#chkInicia').prop('checked', false);
					jAlert('Usted tiene seleccionado otro estatus como inicial, por favor eliminelo o modifiquelo para poder seleccionar este estatus como principal.', 'Notificación');
					sStatus = true;
				}
			}
		});
		
		return sStatus;
	}

	function regresar() {
		jConfirm('¿Esta seguro que desea regresar? Se eliminaran los datos ingresados.', 'Notificación', function(r) {
			if (r) {
				window.location.href = "index.php";
			} 
		});
	}

	function inicializaPantalla() {
		$("#btnRegresar").click(regresar);
		$("#txtHorasVisibles").keydown(onlyNumbers);
		$("#chkFinal").change(chekFinal);
		$("#chkInicia").change(chekInicial);
		$("#txtHorasVisibles").prop('disabled', true);
	}

	$(document).ready(inicializaPantalla);

})