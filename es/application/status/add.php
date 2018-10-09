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
				include "../../../application/status/getStatus.php";
			}
		}
	?>

</head>
<body>
	<br>
	<form role="form" action="../../../application/status/add.php" class="container" method="post">
		<div class="form-group row">
			<label for="txtStatus" class="col-sm-4 col-form-label">Estatus</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="txtStatus" name="txtStatus" placeholder="Ingrese su estatus" required="required" value="<?php 
					if (isset($rowsStatus)) { 
						echo $rowsStatus[0]["SNAME"]; 
					} 
				?>">
			</div>
		</div>
		<div class="form-group row">
			<label for="btnColor" class="col-sm-4 col-form-label">Color</label>
			<div class="col-sm-8">
				<input class="form-control" type="color" value="<?php 
					if (isset($rowsStatus)) { 
						echo $rowsStatus[0]["COLOR"]; 
					} else {
						echo "#000000" ;
					}
				?>" id="btnColor" name="btnColor">
			</div>
		</div>
		<div class="form-group row">
			<label for="chkFinal" class="col-sm-4 col-form-label">Finalizado</label>
			<div class="col-sm-8">
				<input type="checkbox" id="chkFinal" name="chkFinal" <?php 
					if (isset($rowsStatus)) { 
						if ($rowsStatus[0]["FINALIZA"] == 1) {
							echo 'checked="checked"';
						}
					} 
				?>>
			</div>
		</div>
		<div class="form-group row">
			<label for="txtHorasVisibles" class="col-sm-4 col-form-label">¿Horas visibles?</label>
			<div class="col-sm-8">
				<input type="number" class="form-control" id="txtHorasVisibles" name="txtHorasVisibles" placeholder="Ingrese las horas que sera visible" value="<?php 
					if (isset($rowsStatus)) { 
						echo $rowsStatus[0]["HORAS"]; 
					} 
				?>">
			</div>
		</div>
		<div class="form-group row">
			<label for="chkInicia" class="col-sm-4 col-form-label">Inicia comanda</label>
			<div class="col-sm-8">
				<input type="checkbox" id="chkInicia" name="chkInicia" <?php 
					if (isset($rowsStatus)) { 
						if ($rowsStatus[0]["INICIA"] == 1) {
							echo 'checked="checked"';
						}
					} 
				?>>
			</div>
		</div>
		<div class="form-group row">
			<label for="chkGeocerca" class="col-sm-4 col-form-label">Ve geocerca</label>
			<div class="col-sm-8">
				<input type="checkbox" id="chkGeocerca" name="chkGeocerca" <?php 
					if (isset($rowsStatus)) { 
						if ($rowsStatus[0]["GEOCERCA"] == 1) {
							echo 'checked="checked"';
						}
					} 
				?>>
			</div>
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
						if (isset($rowsStatus)) { 
							echo $rowsStatus[0]["IDSTATUS"];
						} else {
							echo "0";
						}
					?>" id="iStatus" name="iStatus">
	</form>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/status/add.js"></script>
</body>

</html>