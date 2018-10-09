<?php session_start();?>
<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/commands/details.css">
	<style type="text/css">
		.btnDef {
			cursor: pointer;
		}
	</style>
	<?php include "../../../application/commands/getCommandDetail.php";?>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">

				<img src="../../../img/logoHeader.png" alt="logo" width="300px" style="margin: 10px;">
			</div>
			<div class="col-md-3">
				<input type="button" id="btnImprimir" class="btnDef" value="Imprimir">
			</div>
			<div class="col-md-3">
				<label for="sFechaEntrega" class="col-sm-12 col-form-label labls"><?php echo date("d/m/Y", strtotime($command['sFechaRegistro'])); ?></label>
			</div>
			<div class="col-md-5">
				<div class="form-group row">
					<label for="sNoOrden" class="col-sm-4 col-form-label"># Orden:</label>
					<label class="col-sm-8 text-left col-form-label labls" id="sNoOrden"><?php echo $command['iComanda']; ?></label>
					<label for="sTipoOrden" class="col-sm-4 col-form-label">Tipo:</label>
					<label class="col-sm-8 text-left col-form-label labls" id="sTipoOrden"><?php echo $command['sTipoComanda']; ?></label>
					<label for="sEstatus" class="col-sm-4 col-form-label">Estatus</label>
					<label class="col-sm-8 text-left col-form-label labls" id="sEstatus"><?php echo $command['sEstatus']; ?></label>
				</div>
				<hr style="border-top:2px dotted">
				<div class="form-group row">
					<label for="sDespachada" class="col-sm-4 col-form-label">Despachada:</label>
					<label class="col-sm-8 text-left labls" id="sDespachada"><?php echo date('H:i', strtotime($command['sDespachada'])); ?></label>
					<label for="sConfimada" class="col-sm-4 col-form-label">Confirmada:</label>
					<label class="col-sm-8 text-left col-form-label labls" id="sConfimada"><?php if ($command['sDateConfirm'] != "") { echo date('H:i', strtotime($command['sDateConfirm'])); } ?></label>
				</div>
				<div class="form-group row">
					<label for="sRecogida" class="col-sm-4 col-form-label">Recogida:</label>
					<label class="col-sm-8 text-left col-form-label labls" id="sRecogida"><?php if ($command['sDatePickup'] != "") { echo date('H:i', strtotime($command['sDatePickup'])); } ?></label>
					<label class="col-sm-12 text-left col-form-label" id="sRecogida1"><?php echo $command['sDireccion']; ?>, <?php echo $command['sCiudad']; ?> <?php echo $command['sCP']; ?></label>
				</div>
				<div class="form-group row">
					<label for="sEntregada" class="col-sm-4 col-form-label">Entregada:</label>
					<label class="col-sm-8 text-left col-form-label labls" id="sEntregada1"><?php if ($command['sDateDelivery'] != "") { echo date('H:i', strtotime($command['sDateDelivery'])); } ?></label>
					<label class="col-sm-12 text-left col-form-label" id="sEntregada2"><?php echo $command['sDireccionEntrega']; ?>, <?php echo $command['sCiudadEntrega']; ?> <?php echo $command['sCPEntrega']; ?></label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group row">
					<label for="sInstrucciones" class="col-sm-12 col-form-label">Instrucciones especiales:</label>
					<div class="col-sm-12">
						<textarea readonly class="form-control-plaintext" id="sInstrucciones" value=""></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="sInstrucciones" class="col-sm-12 col-form-label">Instrucciones especiales:</label>
					<div class="col-sm-12">
						<textarea readonly class="form-control-plaintext" id="sInstrucciones"><?php echo $command['sInstrucciones']; ?></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="sInstrucciones" class="col-sm-12 col-form-label">Satisfacción del cliente:</label>
					<?php if ($command['SGSCORE'] != "") { ?>
						<div class="col-sm-12 text-center">
							<?php if ($command['SGSCORE'] == "1") { ?>
								<img alt="1" src="../../../img/bueno.png">
							<?php } ?>
							<?php if ($command['SGSCORE'] == "2") { ?>
								<img alt="1" src="../../../img/regular.png">
							<?php } ?>
							<?php if ($command['SGSCORE'] == "3") { ?>
								<img alt="1" src="../../../img/malo.png">
							<?php } ?>
						</div>
					<?php }; ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group row text-center">
					<label for="sEntregada" class="col-sm-12 col-form-label">Fotograf&iacute;as:</label>
						<!--imagen de pickup-->
						<?php if ($command['oImgPickup'] != "") { ?>
							<div <?php if ($command['oImgDelivery'] != "") { echo 'class="col-sm-6"'; } else { echo 'class="col-sm-12"'; }?>>
								<img alt="Foto" id="imgFoto" width="100%" src="../../../application/tracing/images/<?php echo $command['oImgPickup']; ?>">
							</div>
						<?php }; ?>

						<!--imagen de delivery-->
						<?php if ($command['oImgDelivery'] != "") { ?>
							<div <?php if ($command['oImgPickup'] != "") { echo 'class="col-sm-6"'; } else { echo 'class="col-sm-12"'; }?>>
								<img alt="Foto" id="imgFoto" width="100%" src="../../../application/tracing/images/<?php echo $command['oImgDelivery']; ?>">
							</div>
						<?php }; ?>
				</div>
				<div class="form-group row text-center">
					<label for="sFirma" class="col-sm-12 col-form-label">Firma:</label>
					<div class="col-sm-12">
						<input type="text" readonly class="form-control-plaintext" id="sFirma" value="<?php echo $command['sNombre']; ?>">
					</div>
				</div>
				<div class="form-group row text-center">
					<?php if ($command['SGIMAGESIGNATURE'] != "") { ?>
						<div class="col-sm-12">
							<img alt="Foto" id="imgFoto" width="100%" src="../../../application/tracing/images/<?php echo $command['SGIMAGESIGNATURE']; ?>">
						</div>
					<?php }; ?>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>

	<script type="text/javascript">
		function btnImpresion(idCommand) {
			//createDetallePdf.php
			var sUrl = "";

			//if (idCommand == "") {
				//sUrl = "details_print.php?iCommand=" + $("#iCommand").val();
				sUrl = "details_print.php?iCommand=" + <?php echo $_REQUEST["iCommand"] ?>
			//} else {
				//sUrl = "details_print.php?iCommand=" + idCommand;
			//}

			window.open(sUrl, "Impresión", "_blank","menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes");
		}

		function inicializaPantalla() {
			$("#btnImprimir").click(btnImpresion);
		}

		$(document).ready(inicializaPantalla);
	</script>
</body>

</html>
