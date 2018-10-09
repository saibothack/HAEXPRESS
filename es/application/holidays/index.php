<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catalogos.css">
	<?php include "../../../application/holidays/getHolidays.php"; ?>
</head>

<body>
	<div class="container-fluid">
		<div class="row titulo">
			<div class="col-sm-3">
				<label>Número</label>
			</div>
			<div class="col-sm-9">
				<label>Día festivo</label>
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
				<form action='add.php' method='post' id='frm_<?php echo $valor["IDHOLIDAY"]; ?>'>
					<div class="row <?php echo $sClass[$iClas]; ?> onRow" onDblClick='dbClick(<?php echo $valor["IDHOLIDAY"]; ?>)'>
						<input type="hidden" value="<?php echo $valor["IDHOLIDAY"]; ?>" name="idHoliday" id="idHoliday">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-3 text-center">
									<input type='checkbox' id='ck_<?php echo $valor["IDHOLIDAY"]; ?>' onclick="dbClickNumero(<?php echo $valor["IDHOLIDAY"]; ?>, this)">
									<label><?php echo $valor["IDHOLIDAY"]; ?></label>
								</div>
								<div class="col-sm-9">
									<label><?php echo $valor["HNAME"]; ?></label>
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

			for($i = $rowCount; $i <= 11; $i++) {			
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
				<input type="button" value="Agregar" class="btnDef" id="btnAgregar">
			</div>
			<div class="col-sm-6 text-center">
				<input type="button" value="Borrar" class="btnDef" id="btnBorrar">
			</div>
		</div>
	</div>

	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/holidays/funciones.js"></script>
</body>
</html>
