<?php session_start();
    if (!(isset($_SESSION["USUARIO"])) && ($_SESSION["USUARIO"] <> "")) {
        header('Location: ../../index.php');
    }
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/styles.css">
	<link rel="stylesheet" type="text/css" href="../../../css/commands/add.css">
	<style>
		body {
			color: black !important;
		}
	</style>
</head>
<body>
	<div class="container">
  		<div class="row nav">
			<label for="txtTiposOrden" class="col-sm-2 col-form-label col-form-label-sm text-center" style="font-size: 18px;">Tipos de orden:</label>

  			<?php include "../../../application/services/getServices.php"; ?>
  			<?php 
				$sClass = array("rowClaro", "rowObscuro");
				$rowCount = 0;
				$i = 0;
				$iClas = 0;

				foreach ($rows as &$valor) {
					$rowCount++;
				?>
					<div class="col-sm-2">
						<button type="button" class="btn btn-primary navButton" id="btn_<?php echo $valor["IDTYPECOMAMAND"]; ?>" onclick="setTipoOrden('<?php echo $valor["TCNAME"]; ?>', <?php echo $valor["IDTYPECOMAMAND"]; ?>, <?php echo $valor["TCCHANGECOLLECTIONPLACE"]; ?>)"><?php echo $valor["TCNAME"]; ?></button>
					</div>
				<?php

					$iClas++;
					if($iClas == 2) {
						$iClas = 0;
					}
				}
			
				unset($valor);
				unset($rows);

			?>
			<?php include "../../../application/typetrucks/getTypeTruckList.php"; ?>
			<?php include "../../../application/holidays/getHolidaysList.php"; ?>	
			<?php include "../../../application/schedules/getSchedulesList.php"; ?>
		</div>
  		<form data-toggle="validator" role="form" method="post" action="../../../application/commands/add.php" id="frmFormulario">
  			<div style="margin: 0 auto;">
				<div class="form-group row clsHeader" style="margin-bottom: 0px !important;">
					<label for="txtTipo" class="col-sm-3 col-form-label col-form-label-sm" style="font-size: 30px; margin: 15px;" id="lblTipoOrden">&nbsp;</label>
					<input type="hidden" id="idTipoOrden" name="idTipoOrden" value="0">
					<input type="hidden" value="0" id="cmbTipo" name="cmbTipo">
					<label for="sDate" class="col-form-label text-center" style="font-size: 20px; margin: 20px; margin-right: 0px;">Servicio:</label>
					<div class="col-sm-2" style="padding: 1px; max-width: 130px !important; width: 150px !important;">
						<select class="form-control" id="cmbServicio" name="cmbServicio" style="margin: 20px; margin-left: 0px;" required>
							<option value="">Seleccion</option>
							<option value="">Urgente</option>
							<option value="">Regular</option>
						</select>
					</div>
					<label for="sDate" class="col-form-label text-center" style="font-size: 20px; margin: 20px; margin-right: 0px;">Fecha:</label>
					<div class="col-sm-2" style="padding: 1px; max-width: 130px !important; width: 150px !important;">
						<input type="text" class="form-control" id="sDate" name="sDate" style="margin: 20px; margin-left: 0px;" required="required" readonly>
					</div>
					<label for="txtTiposOrden" class="col-form-label text-center" style="font-size: 20px; margin: 20px; margin-right: 0px;">Horario:</label>
					<div class="col-sm-2" style="padding: 1px; max-width: 130px !important; width: 150px !important;">
						<select class="form-control" id="cmbHorario" name="cmbHorario" style="margin: 20px; margin-left: 0px;" required>
							<?php 
								foreach ($rowsSchedules as &$valor) {
									echo "<option value='{$valor["IDSCHEDULE"]}'>{$valor["SHDESCRIPTION"]}</option>";
								}

								unset($valor);
								unset($rowsSchedules);
							?>
						</select>
					</div>
					<div class="col-sm-2" style="padding: 10px; max-width: 119px !important; width: 150px !important;">
						<button type="button" class="btn btn-primary navButton" id="btnLimpiar">Limpiar</button>
					</div>
					<div class="col-sm-2" style="padding: 10px; max-width: 119px !important; width: 150px !important;">
						<button type="submit" class="btn btn-primary navButton">Guardar</button>
					</div>
					<div class="col-sm-2" style="padding: 10px; max-width: 119px !important; width: 150px !important;">
						<button type="button" class="btn btn-primary navButton" id="btnCancelar">Cancelar</button>
					</div>
				</div>
				<div class="form-group row dtitulos" style="margin-bottom: 0px !important;">
					<label class="col-sm-6 col-form-label col-form-label-sm text-center" id="divSalida">Salida:</label>
					<label class="col-sm-6 col-form-label col-form-label-sm text-center" id="divCambio">Cambio:</label>
					<label class="col-sm-4 col-form-label col-form-label-sm text-center" id="divRetorno">Retorno:</label>
				</div>
				<div class="form-group row dBody">
					<div class="col-md-12 row">
						<label for="chkChangeColecta" class="col-sm-3 col-form-label col-form-label-sm" style="margin-top: 10px">¿Desea cambiar el lugar de colecta?</label>
						<div class="form-check" style="margin-top: 10px">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" id="chkChangeColecta" name="chkChangeColecta">
							</label>
						</div>
					</div>
					<div class="col-md-12 row">
						<div class="col-md-6" id="frmDefault1">
							<div class="form-group row">
								<label for="txtCompany" class="col-sm-2 col-form-label col-form-label-sm">Compañia:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCompany" name="txtCompany" placeholder="Ingrese la compañia" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-6" id="frmDefault2">
							<div class="form-group row">
								<label for="txtCompany1" class="col-sm-2 col-form-label col-form-label-sm">Compañia:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCompany1" name="txtCompany1" placeholder="Ingrese la compañia" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-4" id="divCambio1">
							<div class="form-group row">
								<label for="txtCompany2" class="col-sm-2 col-form-label col-form-label-sm">Compañia:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCompany2" name="txtCompany2" placeholder="Ingrese la compañia">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<div class="col-md-6" id="frmDefault3">
							<div class="form-group row">
								<label for="txtContact" class="col-sm-2 col-form-label col-form-label-sm">Contacto:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtContact" name="txtContact" placeholder="Ingrese el contacto" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-6" id="frmDefault4">
							<div class="form-group row">
								<label for="txtContact1" class="col-sm-2 col-form-label col-form-label-sm">Contacto:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtContact1" name="txtContact1" placeholder="Ingrese el contacto" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-4" id="divCambio2">
							<div class="form-group row">
								<label for="txtContact2" class="col-sm-2 col-form-label col-form-label-sm">Contacto:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtContact2" name="txtContact2" placeholder="Ingrese el contacto">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<div class="noPadding noMargin col-md-6" id="frmDefault5">
							<div class="noPadding noMargin  col-md-12 row">
								<div class="noPadding noMargin col-md-8 form-group row">
									<label for="txtAddress" class="col-sm-3 col-form-label col-form-label-sm">Direcci&oacute;n:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control form-control-sm" id="txtAddress" name="txtAddress" placeholder="Ingrese la dirección" required="required" >
									</div>
								</div>
								<div class="noPadding noMargin col-md-4 form-group row">
									<label for="txtSuite" class="col-sm-4 col-form-label col-form-label-sm text-left">Suite:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" id="txtSuite" name="txtSuite" placeholder="Suite">
									</div>
								</div>
							</div>
						</div>
						<div class="noPadding noMargin col-md-6" id="frmDefault6">
							<div class="noPadding noMargin  col-md-12 row">
								<div class="noPadding noMargin col-md-8 form-group row">
									<label for="txtAddress1" class="col-sm-3 col-form-label col-form-label-sm">Direcci&oacute;n:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control form-control-sm" id="txtAddress1" name="txtAddress1" placeholder="Ingrese la dirección" required="required">
									</div>
								</div>
								<div class="noPadding noMargin col-md-4 form-group row">
									<label for="txtSuite1" class="col-sm-4 col-form-label col-form-label-sm text-left">Suite:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" id="txtSuite1" name="txtSuite1" placeholder="Suite">
									</div>
								</div>
							</div>
						</div>
						<div class="noPadding noMargin col-md-4" id="divCambio3">
							<div class="noPadding noMargin  col-md-12 row">
								<div class="noPadding noMargin col-md-8 form-group row">
									<label for="txtAddress2" class="col-sm-3 col-form-label col-form-label-sm">Direcci&oacute;n:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control form-control-sm" id="txtAddress2" name="txtAddress2" placeholder="Ingrese la dirección">
									</div>
								</div>
								<div class="noPadding noMargin col-md-4 form-group row">
									<label for="txtSuite2" class="col-sm-4 col-form-label col-form-label-sm text-left">Suite:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control form-control-sm" id="txtSuite2" name="txtSuite2">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<div class="col-md-6" id="frmDefault7">
							<div class="form-group row">
								<label for="txtCity" class="col-sm-2 col-form-label col-form-label-sm">Ciudad:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCity" name="txtCity" placeholder="Ingrese la ciudad" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-6" id="frmDefault8">
							<div class="form-group row">
								<label for="txtCity1" class="col-sm-2 col-form-label col-form-label-sm">Ciudad:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCity1" name="txtCity1" placeholder="Ingrese la ciudad" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-4" id="divCambio4">
							<div class="form-group row">
								<label for="txtCity2" class="col-sm-2 col-form-label col-form-label-sm">Ciudad:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCity2" name="txtCity2" placeholder="Ingrese la ciudad">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<div class="col-md-6" id="frmDefault9">
							<div class="form-group row">
								<label for="txtCp" class="col-sm-2 col-form-label col-form-label-sm">C.P.:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCp" name="txtCp" placeholder="Ingrese la ciudad" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-6" id="frmDefault10">
							<div class="form-group row">
								<label for="txtCp1" class="col-sm-2 col-form-label col-form-label-sm">C.P.:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCp1" name="txtCp1" placeholder="Ingrese la ciudad" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-4" id="divCambio5">
							<div class="form-group row">
								<label for="txtCp2" class="col-sm-2 col-form-label col-form-label-sm">C.P.:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCp2" name="txtCp2" placeholder="Ingrese la ciudad">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<div class="col-md-6" id="frmDefault11">
							<div class="form-group row">
								<label for="txtPhone" class="col-sm-2 col-form-label col-form-label-sm">Tel&eacute;fono:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtPhone" name="txtPhone" placeholder="Ingrese el teléfono" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-6" id="frmDefault12">
							<div class="form-group row">
								<label for="txtPhone1" class="col-sm-2 col-form-label col-form-label-sm">Tel&eacute;fono:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtPhone1" name="txtPhone1" placeholder="Ingrese el teléfono" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-4" id="divCambio6">
							<div class="form-group row">
								<label for="txtPhone2" class="col-sm-2 col-form-label col-form-label-sm">Tel&eacute;fono:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtPhone2" name="txtPhone2" placeholder="Ingrese el teléfono">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<div class="col-md-6" id="frmDefault13">
							<div class="form-group row">
								<label for="txtCellPhone" class="col-sm-2 col-form-label col-form-label-sm">Celular:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCellPhone" name="txtCellPhone" placeholder="Ingrese el celular">
								</div>
							</div>
						</div>
						<div class="col-md-6" id="frmDefault14">
							<div class="form-group row">
								<label for="txtCellPhone1" class="col-sm-2 col-form-label col-form-label-sm">Celular:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCellPhone1" name="txtCellPhone1" placeholder="Ingrese el celular">
								</div>
							</div>
						</div>
						<div class="col-md-4" id="divCambio7">
							<div class="form-group row">
								<label for="txtCellPhone2" class="col-sm-2 col-form-label col-form-label-sm">Celular:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" id="txtCellPhone2" name="txtCellPhone2" placeholder="Ingrese el celular">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<label class="col-sm-3 col-form-label col-form-label-sm" style="font-size: 20px !important; margin-bottom: 10px;">Detalles</label>
					</div>
					<div class="col-md-12 row">
						<div class="col-md-4">
							<div class="form-group row">
								<label for="txtCantidad" class="col-sm-2 col-form-label col-form-label-sm">Cantidad:</label>
								<div class="col-sm-10">
									<input type="number" class="form-control form-control-sm" id="txtCantidad" name="txtCantidad" placeholder="Ingrese la cantidad" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<label for="txtPeso" class="col-sm-2 col-form-label col-form-label-sm">Peso:</label>
								<div class="col-sm-10">
									<input type="number" class="form-control form-control-sm" id="txtPeso" name="txtPeso" placeholder="Ingrese el peso" required="required">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<div class="col-md-3 dCampos">
							<div class="form-group">
								<label for="cmbTypeTruck" class="col-sm-12 col-form-label col-form-label-sm">Tipo de camion:</label>
								<div class="col-sm-12">
									<select class="form-control form-control-sm" id="cmbTypeTruck" name="cmbTypeTruck"  required="required">
										<?php 
											foreach ($rowsTypeTruck as &$valor) {
												echo "<option value='{$valor["IDTYPETRUCK"]}'>{$valor["TTNAME"]}</option>";
											}

											unset($valor);
											unset($rowsTypeTruck);
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-3 dCampos">
							<div class="form-group">
								<label for="txtDescription" class="col-sm-12 col-form-label col-form-label-sm">Descripci&oacute;n:</label>
								<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" id="txtDescription" name="txtDescription" placeholder="Ingrese la descripci&oacute;n" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-3 dCampos">
							<div class="form-group">
								<label for="txtReference" class="col-sm-12 col-form-label col-form-label-sm">Referencia o SKU:</label>
								<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" id="txtReference" name="txtReference" placeholder="Ingrese la referencia o SKU" required="required">
								</div>
							</div>
						</div>
						<div class="col-md-3 dCampos" id="divCambio8">
							<div class="form-group">
								<label for="txtNoTransfer" class="col-sm-12 col-form-label col-form-label-sm">No. de transferencia:</label>
								<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" id="txtNoTransfer" name="txtNoTransfer" placeholder="Ingrese el número de transferencia">
								</div>
							</div>
						</div>
						<div class="col-md-3 dCampos">
							<div class="form-group">
								<label for="txtInstructions" class="col-sm-12 col-form-label col-form-label-sm">Instrucciones:</label>
								<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" id="txtInstructions" name="txtInstructions" placeholder="Ingrese las instrucciones">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 row">
						<input type="hidden" id="idCommand" name="idCommand" value="0">
						<label class="col-sm-4 col-form-label col-form-label-sm" style="font-size: 20px !important; margin-bottom: 10px;">Ingrese la informaci&oacute;n obligatoria</label>
					</div>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../../../plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/comands/add.js"></script>
	<script type="text/javascript" src="../../../script/comands/location.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTnsnKvxxRd1UE1ZeC1qnuIRcC_WdEIyo&libraries=places&callback=initAutocomplete"></script>
	<script type="text/javascript">
		$(function() {
			var array = [<?php
				include "../../../application/holidays/getHolidays.php";
				$sDescription = "";
				$xComa = "";
				foreach ($rows as &$valor) { 
					$sDescription = $sDescription . $xComa . '"' . $valor["HNAME"] . '"';
					$xComa = ", ";
				}

				echo $sDescription;
			?>];


			function iniPag() {
				$('#sDate').datepicker({
				    beforeShowDay: function(date){
				        var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
				        return [ array.indexOf(string) == -1 ]
				    }
				});
			}

			$(document).ready(iniPag);
		})
	</script>
</body>
</html>
</html>