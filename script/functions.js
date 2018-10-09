$(function() {
	"use stric";
	
	function login() {
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: 'application/user/login.php',
			data: $('#fLogin').serialize(),
			success: function (data) {
				if (data.success) {
					window.location.href = "es/application/index.php";
				} else {
					jAlert(data.message, 'Error');
				}
			}
		});
	}
	
	function inicializa() {
		
		$('#fLogin').validator().on('submit', function (e) {
			if (e.isDefaultPrevented()) {
				$('#fLogin').validator();
				return false;
			} else {
				return false;
			}
		});
		
		$("#bLogin").click(login);
	}
	
	$(document).ready(inicializa);
	
});
