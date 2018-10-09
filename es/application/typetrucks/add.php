<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catAdd.css">
	<?php include "../../../application/typetrucks/getTypeTruckAdd.php"; ?>
</head>

<body>
	<br>
	<div class="container">
		<form data-toggle="validator" role="form" method="post" action="../../../application/typetrucks/add.php">
			<div class="form-group row">
				<label for="txtName" class="col-sm-2 col-form-label">Nombre:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="txtName" name="txtName" placeholder="Ingrese el tipo de vehiculo" required="required" value="<?php if(isset($rows)) echo $rows['TTNAME']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-12">
					<input type="hidden" value="<?php if(isset($rows)) echo $rows['IDTYPETRUCK']; else echo '0'; ?>" name="idTupeTruck">	
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
					<button type="submit" id="btnAgregar"><?php if(isset($rows)) echo 'Editar'; else echo 'Agregar'; ?> veh&iacute;culo</button>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/typetrucks/add.js"></script>
</body>

</html>