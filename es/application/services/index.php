<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catalogos.css">
	<?php include "../../../application/services/getServices.php"; ?>

</head>

<body>
	<div class="container-fluid">
		<div class="row titulo" id="divTitulos">
			<div class="col-sm-2">
				<label>Número</label>
			</div>
			<div class="col-sm-5">
				<label>Servicio</label>
			</div>
			<div class="col-sm-2">
				<label>Transferencia</label>
			</div>
			<div class="col-sm-3">
				<label>Cambio de dir.</label>
				<div class="row">
					<div class="col-sm-4">
						Sal
					</div>
					<div class="col-sm-4">
						Ent
					</div>
					<div class="col-sm-4">
						Ret
					</div>
				</div>
			</div>
		</div>
		<?php 
			$sClass = array("rowClaro", "rowObscuro");
			$rowCount = 0;
			$i = 0;
			$iClas = 0;

			foreach ($rows as &$valor) {
				$rowCount++;
			?>
				<form action='add.php' method='post' id='frm_<?php echo $valor["IDTYPECOMAMAND"]; ?>' style="color: <?php echo $valor["TCCOLOR"]; ?>;">
					<div class="row <?php echo $sClass[$iClas]; ?> onRow" onDblClick='dbClick(<?php echo $valor["IDTYPECOMAMAND"]; ?>)'>
						<input type="hidden" value="<?php echo $valor["IDTYPECOMAMAND"]; ?>" name="noServicio" id="noServicio">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-2 text-center">
									<input type='checkbox' id='ck_<?php echo $valor["IDTYPECOMAMAND"]; ?>' onclick="dbClickNumero(<?php echo $valor["IDTYPECOMAMAND"]; ?>, this)">
									<label><?php echo $valor["IDTYPECOMAMAND"]; ?></label>
								</div>
								<div class="col-sm-5">
									<label><?php echo $valor["TCNAME"]; ?></label>
								</div>
								<div class="col-sm-2">
									<label><?php if($valor["TCCHANGECOLLECTIONPLACE"] == 0) { echo 'No'; } else { echo 'Si'; } ?></label>
								</div>
								<div class="col-sm-3">
									<div class="row">
										<div class="col-sm-4">
											<label><?php if($valor["CHDIRSALIDA"] == 0) { echo 'No'; } else { echo 'Si'; } ?></label>
										</div>
										<div class="col-sm-4">
											<label><?php if($valor["CHDIRENTREGA"] == 0) { echo 'No'; } else { echo 'Si'; } ?></label>
										</div>
										<div class="col-sm-4">
											<label><?php if($valor["CHDIRRETORNO"] == 0) { echo 'No'; } else { echo 'Si'; } ?></label>
										</div>
									</div>
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

			?>

		<?php

			for($i = $rowCount; $i <= 10; $i++) {			
		?>
			<div class="row <?php echo $sClass[$iClas] ?>">
				<div class="col-sm-4 text-center">
					&nbsp;
				</div>
				<div class="col-sm-8">
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
	<script type="text/javascript" src="../../../script/services/function.js"></script>
</body>

</html>