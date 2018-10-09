<?php session_start(); ?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/catalogos.css">
	<?php include "../../../application/commands/getCommandsNotificationDetail.php"; ?>
</head>

<body>
	<div class="container-fluid">
		<div class="row titulo">
			<div class="col-sm-3">
				<label>Cliente</label>
			</div>
			<div class="col-sm-1">
				<label>#</label>
			</div>
			<div class="col-sm-2">
				<label>Estatus</label>
			</div>
			<div class="col-sm-3">
				<label>Hora</label>
			</div>
			<div class="col-sm-3">
				<label>Chofer</label>
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
				<form action='add.php' method='post' id='frm_<?php echo $valor["IDNOTIFICATION"]; ?>'>
					<div class="row <?php echo $sClass[$iClas]; ?> onRow" onDblClick='dbClick(<?php echo $valor["IDNOTIFICATION"]; ?>)'>
						<input type="hidden" value="<?php echo $valor["IDNOTIFICATION"]; ?>" name="iNotification" id="iNotification">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-3">
									<input type="hidden" value="<?php echo $valor["IDNOTIFICATION"];?>" id="idRow_<?php echo $a; ?>">
									<label><?php echo $valor["CNAME"]; ?></label>
								</div>
								<div class="col-sm-1">
									<label><?php echo $valor["IDCOMMAND"]; ?></label>
								</div>
								<div class="col-sm-2">
									<label><?php echo $valor["SNAME"]; ?></label>
								</div>
								<div class="col-sm-3">
									<label><?php echo $valor["TDATE"]; ?></label>
								</div>
								<div class="col-sm-3">
									<label><?php echo $valor["DNAME"]; ?></label>
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

			for($i = $rowCount; $i <= 12; $i++) {			
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
	</div>

	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
</body>
</html>