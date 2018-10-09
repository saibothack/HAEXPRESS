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
		if(isset($_POST["noSubServicio"])) {
			if ($_POST["noSubServicio"] != "") {
				include "../../../application/subservices/getServices.php";
				$arrServicios = $rows;
				unset($rows);
			}
		}
	?>

</head>
<body>
	<br>
	<form role="form" action="../../../application/subservices/add.php" class="container" method="post">
		<div class="form-group row">
			<label for="txtService" class="col-sm-3 col-form-label">Servicio</label>
			<div class="col-sm-9">
				<select name="cmbServices" id="cmbServices" class="form-control" required="required">
					<option value="">Seleccione</option>
					<?php include "../../../application/services/getServices.php";
						print_r($rows);
						foreach ($rows as &$valor) { 
							$chlk = "";
							if (isset($arrServicios)) {
								if ($arrServicios[0]["IDTYPECOMAMAND"] == $valor["IDTYPECOMAMAND"]) {
									$chlk = 'selected="selected"';
								}
							}
							echo "<option value='" . $valor["IDTYPECOMAMAND"] . "' " . $chlk . ">". $valor["TCNAME"] ."</option>";
						}
						unset($rows);
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="txtService" class="col-sm-3 col-form-label">Sub Servicio</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="txtSubService" name="txtSubService" placeholder="Ingrese su servicio" required="required" value="<?php 
					if (isset($arrServicios)) { 
						echo $arrServicios[0]["NAME"]; 
					} 
				?>">
			</div>
		</div>
		<div class="form-group row">
			<label for="cmbSchedules" class="col-sm-3 col-form-label">Horarios</label>
			<div class="col-sm-9">
				<select name="cmbSchedules" id="cmbSchedules" class="form-control">
					<option value="">Seleccione</option>
					<?php include "../../../application/schedules/getSchedules.php";
						foreach ($rows as &$valor) { 
							$chlk = "";
							if (isset($arrServicios)) {
								if ($arrServicios[0]["SCHEDULES_IDSCHEDULE"] == $valor["IDSCHEDULE"]) {
									$chlk = 'selected="selected"';
								}
							}
							echo "<option value='" . $valor["IDSCHEDULE"] . "' " . $chlk . ">". $valor["SHDESCRIPTION"] ."</option>";
						}
						unset($rows);
						unset($valor);
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="btnColor" class="col-sm-3 col-form-label">Color</label>
			<div class="col-sm-9">
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
			<div class="col-sm-12">
				&nbsp;
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				&nbsp;
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				&nbsp;
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
						if (isset($arrServicios)) { 
							echo $arrServicios[0]["IDSUBSERVICES"];
						} else {
							echo "0";
						}
					?>" id="iSubService" name="iSubService">
	</form>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/subservices/add.js"></script>
</body>

</html>