var rowTypeTruck = [];

Array.prototype.remove = function() {
	"use strict";
	var what, a = arguments, L = a.length, ax;
	while (L && this.length) {
		what = a[--L];
		while ((ax = this.indexOf(what)) !== -1) {
			this.splice(ax, 1);
		}
	}
	return this;
};

function dbClick(id) {
	"use strict";
	var idDiv = "#frm_" + id;
	$(idDiv).submit();
}

function dbClickNumero(id) {
	"use strict";
	var idChek = "#ck_" + id;
	if ($(idChek).prop('checked')) {
		$(idChek).prop('checked', false);	
		rowTypeTruck.remove(id);
	} else  {
		$(idChek).prop('checked', true);
		rowTypeTruck.push(id);
	}
}

$(function() {
	"use strict";
	
	function add() {
		window.location.href = "add.php";
	}
	
	function delet(){
		if (rowTypeTruck.length <= 0) {
			jAlert('Por favor seleccione al menos un vehiculo para eliminar.', 'Notificación');
		} else  {
			jConfirm('¿Esta seguro que desea eliminar los vehiculos selecionados?', 'Borra Vehículos', function(r) {
				if (r) {
					var datos = rowTypeTruck.join(',');
					var data = {
						aTypeTruck : datos
					}
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: '../../../application/typetrucks/delete.php',
						data: data,
						success: function (data) {
							if (data.success) {
								window.location.href = "index.php";
							} else {
								jAlert(data.message, 'Error');
							}
						}
					});
					rowTypeTruck = [];
				} 
			});
		}
	}
	
	function inicializa() {
		$("#btnAgregar").click(add);
		$("#btnBorrar").click(delet);
	}
	
	$(document).ready(inicializa);
});