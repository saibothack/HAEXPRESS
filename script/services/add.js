$(function() {


	function regresar() {
		jConfirm('¿Esta seguro que desea regresar? Se eliminaran los datos ingresados.', 'Notificación', function(r) {
			if (r) {
				window.location.href = "index.php";
			} 
		});
	}

	function changeTransferencia() {
		if($("#chkCambio").is(":checked")) {
			$("#chkRetorno").prop("disabled", false);
		} else {
			$("#chkRetorno").prop("checked", false);
			$("#chkRetorno").prop("disabled", true);
		}
	};

	function inicializaPantalla() {
		$("#btnRegresar").click(regresar);
		$("#chkCambio").click(changeTransferencia);

		changeTransferencia();
	}

	$(document).ready(inicializaPantalla);

})