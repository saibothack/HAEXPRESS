<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catAdd.css">
	<?php 
		if(isset($_POST["noServicio"])) {
			if ($_POST["noServicio"] != "") {
				include "../../../application/services/getServices.php";
			}
		}
	?>

</head>
<body>
	<br>
	<form role="form" action="../../../application/services/add.php" class="container" method="post">
		<div class="form-group row">
			<label for="txtService" class="col-sm-2 col-form-label">Servicio</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="txtService" name="txtService" placeholder="Ingrese su servicio" required="required" value="<?php 
					if (isset($rows)) { 
						echo $rows[0]["TCNAME"]; 
					} 
				?>">
			</div>
		</div>
		<div class="form-group row">
			<label for="btnColor" class="col-sm-2 col-form-label">Color</label>
			<div class="col-10">
				<input class="form-control" type="color" value="<?php 
					if (isset($rows)) { 
						echo $rows[0]["TCCOLOR"]; 
					} else {
						echo "#000000" ;
					}
				?>" id="btnColor" name="btnColor">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2">
				<input type="checkbox" id="chkCambio" name="chkCambio" 
					<?php 
						if (isset($rows)) { 
							if ($rows[0]["TCCHANGECOLLECTIONPLACE"] == 1) {
								echo 'checked="checked"';
							} 
						} 
					?>
				>
			</div>
			<label for="txtService" class="col-sm-10 col-form-label">Cambio de transferencia</label>
		</div>
		<div class="form-group row">
			<div class="col-sm-2">
				<input type="checkbox" id="chkSalida" name="chkSalida" 
					<?php 
						if (isset($rows)) { 
							if ($rows[0]["CHDIRSALIDA"] == 1) {
								echo 'checked="checked"';
							} 
						} 
					?>
				>
			</div>
			<label for="chkSalida" class="col-sm-10 col-form-label">Cambio de Ubicaci&oacute;n salida</label>
		</div>
		<div class="form-group row">
			<div class="col-sm-2">
				<input type="checkbox" id="chkEntrega" name="chkEntrega" 
					<?php 
						if (isset($rows)) { 
							if ($rows[0]["CHDIRENTREGA"] == 1) {
								echo 'checked="checked"';
							} 
						} 
					?>
				>
			</div>
			<label for="chkEntrega" class="col-sm-10 col-form-label">Cambio de Ubicación Entrega</label>
		</div>
		<div class="form-group row">
			<div class="col-sm-2">
				<input type="checkbox" id="chkRetorno" name="chkRetorno" 
					<?php 
						if (isset($rows)) { 
							if ($rows[0]["CHDIRRETORNO"] == 1) {
								echo 'checked="checked"';
							} 
						} 
					?>
				>
			</div>
			<label for="chkRetorno" class="col-sm-10 col-form-label">Cambio de Ubicación Retorno</label>
		</div>
		<div class="form-group row">
			<div class="col-sm-6 text-center">
				<button type="button" id="btnRegresar">Regresar</button>
			</div>
			<div class="col-sm-6 text-center">
				<button type="submit">Guardar</button>
			</div>
		</div>
		<input type="hidden" value="<?php 
						if (isset($rows)) { 
							echo $rows[0]["IDTYPECOMAMAND"];
						} else {
							echo "0";
						}
					?>" id="iService" name="iService">
	</form>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/services/add.js"></script>
</body>

</html>