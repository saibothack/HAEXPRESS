var rowSchedule = [];

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

function dbClickNumero(id, chk) {
	"use strict";
	
	if (chk.checked) {
		rowSchedule.push(id);
	} else  {
		rowSchedule.remove(id);
	}
}

$(function() {
	"use strict";
	
	function add() {
		window.location.href = "add.php";
	}
	
	function delet(){
		if (rowSchedule.length <= 0) {
			jAlert('Por favor seleccione al menos un horario para eliminar.', 'Notificación');
		} else  {
			jConfirm('¿Esta seguro que desea eliminar los horarios selecionados?', 'Borra Vehículos', function(r) {
				if (r) {
					var datos = rowSchedule.join(',');
					var data = {
						aSchedules : datos
					}
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: '../../../application/schedules/delete.php',
						data: data,
						success: function (data) {
							if (data.success) {
								window.location.href = "index.php";
							} else {
								jAlert(data.message, 'Error');
							}
						}
					});
					rowSchedule = [];
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