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
				include "../../../application/merchandise/getMerchandise.php";
			}
		}
	?>

</head>
<body>
	<br>
	<form role="form" action="../../../application/merchandise/add.php" class="container" method="post">
		<div class="form-group row">
			<label for="txtMerchandise" class="col-sm-2 col-form-label">Mercancia</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="txtMerchandise" name="txtMerchandise" placeholder="Ingrese su mercancia" required="required" value="<?php 
					if (isset($rows)) { 
						echo $rows[0]["NAME"]; 
					} 
				?>">
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
						if (isset($rows)) { 
							echo $rows[0]["IDMERCHANDISE"];
						} else {
							echo "0";
						}
					?>" id="iMerchandise" name="iMerchandise">
	</form>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/services/add.js"></script>
</body>

</html>