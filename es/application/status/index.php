<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catalogos.css">
	<?php include "../../../application/status/getStatus.php"; ?>

</head>

<body>
	<div class="container-fluid">
		<div class="row titulo">
			<div class="col-sm-2">
				<label>Número</label>
			</div>
			<div class="col-sm-2">
				<label>Estatus</label>
			</div>
			<div class="col-sm-2">
				<label>Finaliza</label>
			</div>
			<div class="col-sm-2">
				<label>Horas</label>
			</div>
			<div class="col-sm-2">
				<label>Inicial</label>
			</div>
			<div class="col-sm-2">
				<label>Geocerca</label>
			</div>
		</div>
		<?php 
			$sClass = array("rowClaro", "rowObscuro");
			$rowCount = 0;
			$i = 0;
			$iClas = 0;

			foreach ($rowsStatus as &$valor) {
				$rowCount++;
			?>
				<form action='add.php' method='post' id='frm_<?php echo $valor["IDSTATUS"]; ?>' style="color: <?php echo $valor["COLOR"]; ?>;">
					<div class="row <?php echo $sClass[$iClas]; ?> onRow" onDblClick='dbClick(<?php echo $valor["IDSTATUS"]; ?>)'>
						<input type="hidden" value="<?php echo $valor["IDSTATUS"]; ?>" name="noServicio" id="noServicio">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-2 text-center">
									<input type='checkbox' id='ck_<?php echo $valor["IDSTATUS"]; ?>' onclick="dbClickNumero(<?php echo $valor["IDSTATUS"]; ?>, this)">
									<label><?php echo $valor["IDSTATUS"]; ?></label>
								</div>
								<div class="col-sm-2">
									<label><?php echo $valor["SNAME"]; ?></label>
								</div>
								<div class="col-sm-2">
									<label><?php if ($valor["FINALIZA"] == 0) { echo "No"; } else { echo "Si"; } ?></label>
								</div>
								<div class="col-sm-2">
									<label><?php echo $valor["HORAS"]; ?></label>
								</div>
								<div class="col-sm-2">
									<label><?php if ($valor["INICIA"] == 0) { echo "No"; } else { echo "Si"; } ?></label>
								</div>
								<div class="col-sm-2">
									<label><?php if ($valor["GEOCERCA"] == 0) { echo "No"; } else { echo "Si"; } ?></label>
								</div>
							</div>
						</div>
					</div>	
				</form>
			<?php

				$iClas++;
				if($iClas == 2) {
					$iClas = 0;
				}
			}
		
			unset($valor);
			unset($rowsStatus);

			?>

		<?php

			for($i = $rowCount; $i <= 11; $i++) {			
		?>
			<div class="row <?php echo $sClass[$iClas] ?>">
				<div class="col-sm-12 text-center">
					&nbsp;
				</div>
			</div>	
		<?php 
				$iClas++;
				if($iClas == 2) {
					$iClas = 0;
				}
			}
		?>
		<div class="row <?php echo $sClass[$iClas] ?>">
			<div class="col-sm-6 text-center">
				<input type="button" value="Agregar" class="btnDef" id="btnAdd">
			</div>
			<div class="col-sm-6 text-center">
				<input type="button" value="Borrar" class="btnDef" id="btnDelete">
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/status/function.js"></script>
	
</body>

</html>