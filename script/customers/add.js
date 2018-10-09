$(function() {
	"use strict";
	
	function validaEmail(txtEmail, divElement) {
		
		var datos = {
			txtUser : txtEmail
		};
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '../../../application/customers/validaEmail.php',
			data: datos,
			success: function (data) {
				if (data.success) {
					$(divElement).show(1000);
				} else {
					$(divElement).hide(1000);
				}
			}
		});
	}
	
	function regresar() {
		jConfirm('¿Esta seguro que desea regresar? Se eliminaran los datos ingresados.', 'Notificación', function(r) {
			if (r) {
				window.location.href = "index.php";
			} 
		});
	}
	
	function inicializa() {
		$('#errResponsible').hide();
		$('#errUser1').hide();
		$('#errUser2').hide();
		$('#errUser3').hide();
		$('#errUser4').hide();
		
		$("#btnRegresar").click(regresar);
		
		$("#txtEmail").keyup(function() {
			if ($("#txtEmail").val().length > 5) {
				validaEmail($("#txtEmail").val(), "#errResponsible");
			}
		});
		$("#txtEmail1").keyup(function() {
			console.log($("#txtEmail1").val().length);
			if ($("#txtEmail1").val().length > 5) { 
				validaEmail($("#txtEmail1").val(), "#errUser1");
			}
		});
		$("#txtEmail2").keyup(function() {
			if ($("#txtEmail2").val().length > 5) { 
				validaEmail($("#txtEmail2").val(), "#errUser2");
			}
		});
		$("#txtEmail3").keyup(function() {
			if ($("#txtEmail3").val().length > 5) { 
				validaEmail($("#txtEmail3").val(), "#errUser3");
			}
		});
		$("#txtEmail4").keyup(function() {
			if ($("#txtEmail4").val().length > 5) { 
				validaEmail($("#txtEmail4").val(), "#errUser4");
			}
		});

		$('#frmAlta').validator().on('submit', function (e) {
			if (!e.isDefaultPrevented()) {
				var sLat = $("#sLat").val();
				var sLon = $("#sLon").val();
				var bReturn = true;
				if((sLat == "") || (sLon == "")) {
					bReturn = false;
					jAlert('Por favor seleccione una dirección de la lista desplegable', 'Error');
				} 

				return bReturn;
  			}
		})
	}
	
	$(document).ready(inicializa);
});
