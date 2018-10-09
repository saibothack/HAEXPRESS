$(function() {
	
	function add() {
		window.location.href = "add.php";
	}
	
	function delet(){
		jConfirm('¿Esta seguro que desea eliminar los Clientes selecionados?', 'Borra Clientes', function(r) {
			if (r) {
				jAlert('Confirmed: ' + r, 'Confirmation Results');
			} else {
				jAlert('no Confirmed: ' + r, 'Confirmation Results');	
			}
		});
	}
	
	function inicializa() {
		$("#btnAgregar").click(add);
		$("#btnBorrar").click(delet);
	}
	
	$(document).ready(inicializa);
})