<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catAdd.css">
	<?php include "../../../application/holidays/getHolidaysAdd.php"; ?>
</head>

<body>
	<br>
	<div class="container">
		<form data-toggle="validator" role="form" method="post" action="../../../application/holidays/add.php">
			<div class="form-group row">
				<label for="txtDate" class="col-sm-2 col-form-label">Fecha:</label>
				<div class="col-sm-10">
					<input type="text" readonly="readonly" class="form-control" id="txtDate" name="txtDate" placeholder="Ingrese su d&iacute;a festivo" required="required" value="<?php if(isset($rows)) echo $rows['HNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-12">
					<input type="hidden" value="<?php if(isset($rows)) echo $rows['IDHOLIDAY']; else echo '0'; ?>" name="idHoliday">	
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
				<div class="col-sm-6 text-center	">
					<button type="submit" id="btnAgregar"><?php if(isset($rows)) echo 'Editar'; else echo 'Agregar'; ?></button>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/holidays/add.js"></script>
</body>

</html>