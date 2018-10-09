var rowHoliday = [];

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
		rowHoliday.push(id);
	} else  {
		rowHoliday.remove(id);
	}
}

$(function() {
	"use strict";
	
	function add() {
		window.location.href = "add.php";
	}
	
	function delet(){
		if (rowHoliday.length <= 0) {
			jAlert('Por favor seleccione al menos un día festivo para eliminar.', 'Notificación');
		} else  {
			jConfirm('¿Esta seguro que desea eliminar los días festivos selecionados?', 'Borra festivos', function(r) {
				if (r) {
					var datos = rowHoliday.join(',');
					
					var data = {
						aHolidays : datos
					};
					
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: '../../../application/holidays/delete.php',
						data: data,
						success: function (data) {
							if (data.success) {
								window.location.href = "index.php";
							} else {
								jAlert(data.message, 'Error');
							}
						}
					});
					rowHoliday = [];
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