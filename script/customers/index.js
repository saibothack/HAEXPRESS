var rowCustomers = [];

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
		rowCustomers.push(id);
	} else  {
		rowCustomers.remove(id);
	}
}

$(function() {
	"use strict";
	
	function add() {
		window.location.href = "add.php";
	}
	
	function delet(){
		if (rowCustomers.length <= 0) {
			jAlert('Por favor seleccione al menos un cliente para eliminar.', 'Notificación');
		} else  {
			jConfirm('¿Esta seguro que desea eliminar los clientes selecionados?', 'Borra Clientes', function(r) {
				if (r) {
					var datos = rowCustomers.join(',');
					var data = {
						aCustomers : datos
					}
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: '../../../application/customers/delete.php',
						data: data,
						success: function (data) {
							if (data.success) {
								console.log("Redirect");
								window.location.href = "index.php";
							} else {
								jAlert(data.message, 'Error');
							}
						}
					});
					rowCustomers = [];
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