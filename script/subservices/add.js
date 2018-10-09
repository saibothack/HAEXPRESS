$(function() {

	function regresar() {
		jConfirm('¿Esta seguro que desea regresar? Se eliminaran los datos ingresados.', 'Notificación', function(r) {
			if (r) {
				window.location.href = "index.php";
			} 
		});
	}

	function inicializaPantalla() {
		$("#btnRegresar").click(regresar);
	}

	$(document).ready(inicializaPantalla);

})