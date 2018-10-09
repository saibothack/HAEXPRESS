var arrSelRecors = [];

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
		arrSelRecors.push(id);
	} else  {
		arrSelRecors.remove(id);
	}
}

$(function() {

	function add() {
		window.location.href = "add.php";
	}

	function delet(){
		if (arrSelRecors.length <= 0) {
			jAlert('Por favor seleccione al menos un registro para eliminar.', 'Notificación');
		} else  {
			jConfirm('¿Esta seguro que desea eliminar los registros selecionados?', 'Borrar', function(r) {
				if (r) {
					var datos = arrSelRecors.join(',');
					var data = {
						aRecords : datos
					}
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: '../../../application/status/delete.php',
						data: data,
						success: function (data) {
							if (data.success) {
								window.location.href = "index.php";
							} else {
								jAlert(data.message, 'Error');
							}
						}
					});
					arrSelRecors = [];
				} 
			});
		}
	}

	function inicializaPantalla() {
		$("#btnAdd").click(add);
		$("#btnDelete").click(delet);
	}

	$(document).ready(inicializaPantalla);

});