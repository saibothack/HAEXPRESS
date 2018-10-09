<?php session_start();
    if (!(isset($_SESSION["USUARIO"])) && ($_SESSION["USUARIO"] <> "")) {
        header('Location: ../../index.php');
    }
?>
<!doctype html>
<html><head>
	<meta charset="utf-8">
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/commands/add.css">
	<style>
		html {
			width: 99.70%;
		}
	</style>
</head>
<body class="dBody">
	<form action="../../../application/commands/add.php" method="post" data-toggle="validator" role="form" id="frmAlta">
		<div class="container-fluid">
			<div class="nav row">
				<label class="col-sm-2">Tipos de orden:</label>
				<div class="col-sm-10">
					<div class="row">
						<?php include "../../../application/services/getServices.php"; 
							$iValor = round((12 / count($rows)), 0, PHP_ROUND_HALF_UP);
							foreach ($rows as &$valor) {
								?>
									<div class="col-sm-<?php echo $iValor; ?>">
										<button type="button" class="btn btn-primary navButton" id="btn_<?php echo $valor["IDTYPECOMAMAND"]; ?>" onclick="setTipoOrden('<?php echo $valor["TCNAME"]; ?>', <?php echo $valor["IDTYPECOMAMAND"]; ?>, <?php echo $valor["TCCHANGECOLLECTIONPLACE"]; ?>, '<?php echo $valor["TCCOLOR"]; ?>', this)" data-salida="<?php echo $valor["CHDIRSALIDA"]; ?>" data-entrega="<?php echo $valor["CHDIRENTREGA"]; ?>" data-retorno="<?php echo $valor["CHDIRRETORNO"]; ?>"><?php echo $valor["TCNAME"]; ?></button>
									</div>
								<?php
							}
							unset($valor);
							unset($rows);
						?>
					</div>
				</div>
			</div>
			<div class="row">
				<h3 class="col-sm-2" style="margin-top: 15px;" id="lblTipoOrden"></h3>
				<input type="hidden" name="idTipoOrden" id="idTipoOrden" value="0">
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-5">
							<div class="form-group row" style="margin-top: 15px;">
								<label for="cmbService" class="col-sm-5 col-form-label">Tipos de servicio</label>
								<div class="col-sm-7">
									<select class="form-control" id="cmbService" name="cmbService" required="required">
										<option value="">Seleccione</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group row" style="margin-top: 15px;">
								<label for="cmbHorario" class="col-sm-3 col-form-label">Horario</label>
								<div class="col-sm-9">
									<select class="form-control" name="cmbHorario1" id="cmbHorario1" disabled="disabled">
										<option value="">Seleccione</option>
										<?php include "../../../application/schedules/getSchedulesList.php";
											foreach ($rowsSchedules as &$valor) {
												echo "<option value='{$valor["IDSCHEDULE"]}'>{$valor["SHDESCRIPTION"]}</option>";
											}

											unset($valor);
											unset($rowsSchedules);
										?>
									</select>
									<input type="hidden" name="cmbHorario" id="cmbHorario" value="" />
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group row" style="margin-top: 15px;">
								<label for="cmbService" class="col-sm-3 col-form-label">Fecha</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="sDate" name="sDate" required="required">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-1">
					<input type="button" class="btn btn-primary navButton" id="btnLimpiar" value="Limpiar">
				</div>
				<div class="col-sm-1">
					<input type="submit" class="btn btn-primary navButton" value="Guardar">
				</div>
			</div>
			<div class="row nav">
				<div class="col-sm-6 text-center" id="divSalidaTit">
					<label>Salida:</label>
				</div>
				<div class="col-sm-6 text-center" id="divCambioTit">
					<label>Entrega:</label>
				</div>
				<div class="col-sm-4 text-center" id="divRetornoTit">
					<label>Retorno:</label>
				</div>
			</div>
			<div class="row">
				<?php 
				if($_SESSION["USUARIO"][0]['IDROLES'] != 1) {
					include "../../../application/commands/getDataCustomerAdd.php";
				}?>
				<div class="col-sm-6" id="divSalida">
					<div class="form-group row" style="margin-top: 15px;">
						<label for="changeAddress" class="col-sm-6 col-form-label" id="changeAddressLbl">Cambio de dirección:</label> &nbsp;
						<div class="col-sm-1">
							<input type="checkbox" name="changeAddress" id="changeAddress">
						</div>

					</div>
					<div class="form-group row" style="margin-top: 15px;">
						<label for="txtCompany" class="col-sm-2 col-form-label">Compañia:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtCompany" name="txtCompany" required="required" placeholder="Ingrese compañia" value="<?php if(isset($response)) echo $response['CNAME']; ?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="txtContact" class="col-sm-2 col-form-label">Contacto:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtContact" name="txtContact" required="required" placeholder="Ingrese contacto" value="<?php if(isset($response)) echo $response['UNAME']; ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group row">
								<label for="txtAddress" class="col-sm-3 col-form-label">Direcci&oacute;n:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtAddress" name="txtAddress" required="required" placeholder="Ingrese direcci&oacute;n" value="<?php if(isset($response)) echo $response['CADDRESS']; ?>">
									<input type="hidden" name="sLat" id="sLat" value="<?php if(isset($response)) echo $response['LATITUD']; ?>">
									<input type="hidden" name="sLon" id="sLon" value="<?php if(isset($response)) echo $response['LONGITUD']; ?>">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group row">
								<label for="txtSuite" class="col-sm-3 col-form-label">Suite:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtSuite" name="txtSuite" placeholder="Ingrese suite" value="<?php if(isset($response)) echo $response['CSUITE']; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group row">
								<label for="txtCity" class="col-sm-3 col-form-label">Ciudad:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtCity" name="txtCity" required="required" placeholder="Ingrese ciudad" value="<?php if(isset($response)) echo $response['CCITY']; ?>">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group row">
								<label for="txtProv" class="col-sm-3 col-form-label">Prov:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtProv" name="txtProv" placeholder="Ingrese prov" value="QC">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="txtCp" class="col-sm-2 col-form-label">C.P.:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtCp" name="txtCp" required="required" placeholder="Ingrese C.P." value="<?php if(isset($response)) echo $response['CCP']; ?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="txtPhone" class="col-sm-2 col-form-label">Tel&eacute;fono:</label>
						<div class="col-sm-10">
							<input type="tel" class="form-control" id="txtPhone" name="txtPhone" required="required" placeholder="Ingrese tel&eacute;fono" value="<?php if(isset($response)) echo $response['CPHONE']; ?>">
						</div>
					</div>
					<div class="form-group row" hidden="hidden">
						<label for="txtCellPhone" class="col-sm-2 col-form-label">Celular:</label>
						<div class="col-sm-10">
							<input type="tel" class="form-control" id="txtCellPhone" name="txtCellPhone" placeholder="Ingrese tel&eacute;fono celular">
						</div>
					</div>
				</div>
				<div class="col-sm-6" id="divCambio">
					<div class="form-group row" style="margin-top: 15px;">
						<label for="changeAddress1" class="col-sm-6 col-form-label" id="changeAddressLbl1">Cambio de dirección:</label> &nbsp;
						<div class="col-sm-1">
							<input type="checkbox" name="changeAddress1" id="changeAddress1">
						</div>
					</div>
					<div class="form-group row" style="margin-top: 15px;">
						<label for="txtCompany1" class="col-sm-2 col-form-label">Compañia:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtCompany1" name="txtCompany1" required="required" placeholder="Ingrese compañia">
						</div>
					</div>
					<div class="form-group row">
						<label for="txtContact1" class="col-sm-2 col-form-label">Contacto:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtContact1" name="txtContact1" required="required" placeholder="Ingrese contacto">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group row">
								<label for="txtAddress1" class="col-sm-3 col-form-label">Direcci&oacute;n:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtAddress1" name="txtAddress1" required="required" placeholder="Ingrese direcci&oacute;n">
									<input type="hidden" name="sLat1" id="sLat1" value="">
									<input type="hidden" name="sLon1" id="sLon1" value="">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group row">
								<label for="txtSuite1" class="col-sm-3 col-form-label">Suite:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtSuite1" name="txtSuite1" placeholder="Ingrese suite">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group row">
								<label for="txtCity1" class="col-sm-3 col-form-label">Ciudad:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtCity1" name="txtCity1" required="required" placeholder="Ingrese ciudad">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group row">
								<label for="txtProv1" class="col-sm-3 col-form-label">Prov:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtProv1" name="txtProv1" placeholder="Ingrese prov" value="QC">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="txtCp1" class="col-sm-2 col-form-label">C.P.:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtCp1" name="txtCp1" required="required" placeholder="Ingrese C.P.">
						</div>
					</div>
					<div class="form-group row">
						<label for="txtPhone1" class="col-sm-2 col-form-label">Tel&eacute;fono:</label>
						<div class="col-sm-10">
							<input type="tel" class="form-control" id="txtPhone1" name="txtPhone1" required="required" placeholder="Ingrese tel&eacute;fono">
						</div>
					</div>
					<div class="form-group row" hidden="hidden">
						<label for="txtCellPhone1" class="col-sm-2 col-form-label">Celular:</label>
						<div class="col-sm-10">
							<cinput type="tel" class="form-control" id="txtCellPhone1" name="txtCellPhone1" placeholder="Ingrese tel&eacute;fono celular">
						</div>
					</div>
				</div>
				<div class="col-sm-4" id="divRetorno">
					<div class="form-group row" style="margin-top: 15px;">
						<label for="changeAddress2" class="col-sm-6 col-form-label" id="changeAddressLbl2">Cambio de dirección:</label> &nbsp;
						<div class="col-sm-1">
							<input type="checkbox" name="changeAddress2" id="changeAddress2">
						</div>
					</div>
					<div class="form-group row" style="margin-top: 15px;">
						<label for="txtCompany2" class="col-sm-2 col-form-label">Compañia:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtCompany2" name="txtCompany2" placeholder="Ingrese compañia">
						</div>
					</div>
					<div class="form-group row">
						<label for="txtContact2" class="col-sm-2 col-form-label">Contacto:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtContact2" name="txtContact2" placeholder="Ingrese contacto">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group row">
								<label for="txtAddress2" class="col-sm-3 col-form-label">Direcci&oacute;n:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtAddress2" name="txtAddress2" placeholder="Ingrese direcci&oacute;n">
									<input type="hidden" name="sLat2" id="sLat2" value="">
									<input type="hidden" name="sLon2" id="sLon2" value="">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group row">
								<label for="txtSuite2" class="col-sm-3 col-form-label">Suite:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtSuite2" name="txtSuite2" placeholder="Ingrese suite">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group row">
								<label for="txtCity2" class="col-sm-3 col-form-label">Ciudad:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtCity2" name="txtCity2" placeholder="Ingrese ciudad">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group row">
								<label for="txtProv2" class="col-sm-3 col-form-label">Prov:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="txtProv2" name="txtProv2" placeholder="Ingrese prov" value="QC">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="txtCp2" class="col-sm-2 col-form-label">C.P.:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="txtCp2" name="txtCp2" placeholder="Ingrese C.P.">
						</div>
					</div>
					<div class="form-group row">
						<label for="txtPhone2" class="col-sm-2 col-form-label">Tel&eacute;fono:</label>
						<div class="col-sm-10">
							<input type="tel" class="form-control" id="txtPhone2" name="txtPhone2" placeholder="Ingrese tel&eacute;fono">
						</div>
					</div>
					<div class="form-group row" hidden="hidden">
						<label for="txtCellPhone2" class="col-sm-2 col-form-label">Celular:</label>
						<div class="col-sm-10">
							<input type="tel" class="form-control" id="txtCellPhone2" name="txtCellPhone2" placeholder="Ingrese tel&eacute;fono celular">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<h4>Detalles</h4>
				</div>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group row">
								<label for="cmbMerchandise" class="col-sm-2 col-form-label">Mercancia:</label>
								<div class="col-sm-10">
									<select class="form-control" id="cmbMerchandise" name="cmbMerchandise" required="required">
										<option value="">Seleccione</option>
										<?php include "../../../application/merchandise/getMerchandise.php";
											foreach ($rows as &$valor) {
												echo "<option value='{$valor["IDMERCHANDISE"]}'>{$valor["NAME"]}</option>";
											}

											unset($valor);
											unset($rows);
										?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="cmbTypeTruck" class="col-sm-2 col-form-label">Camion:</label>
								<div class="col-sm-10">
									<select class="form-control" id="cmbTypeTruck" name="cmbTypeTruck" required="required">
										<option value="">Seleccione</option>
										<?php include "../../../application/typetrucks/getTypeTruckList.php";
											foreach ($rowsTypeTruck as &$valor) {
												echo "<option value='{$valor["IDTYPETRUCK"]}'>{$valor["TTNAME"]}</option>";
											}

											unset($valor);
											unset($rowsTypeTruck);
										?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group row">
										<label for="txtCantidad" class="col-sm-4 col-form-label">Cantidad:</label>
										<div class="col-sm-8">
											<input  class="form-control" type="number" id="txtCantidad" name="txtCantidad" placeholder="Cantidad" required="required">
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group row">
										<label for="txtPeso" class="col-sm-4 col-form-label">Peso:</label>
										<div class="col-sm-8">
											<input  class="form-control" type="number" id="txtPeso" name="txtPeso" placeholder="Peso" required="required">
										</div>
									</div>
								</div>
							</div>
							<label class="col-sm-8 col-form-label text-left">Ingrese la informaci&oacute;n obligatoria:</label>
						</div>
						<div class="col-sm-4">
							<div class="form-group row">
								<label for="txtReference" class="col-sm-2 col-form-label">Ref./SKU:</label>
								<div class="col-sm-10">
									<input  class="form-control" type="text" id="txtReference" name="txtReference" placeholder="Ingrese referencia o SKU" required="required">
								</div>
							</div>
							<div class="form-group row" id="rowTransfer">
								<label for="txtNoTransfer	" class="col-sm-2 col-form-label">Transferencia:</label>
								<div class="col-sm-10">
									<input  class="form-control" type="text" id="txtNoTransfer" name="txtNoTransfer" placeholder="Ingrese transferencia">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="txtDescription" class="col-sm-4 col-form-label">Descripci&oacute;n:</label>
										<div class="col-sm-12">
											<textarea name="txtDescription" id="txtDescription" rows="3" style="width: 100%" class="form-control" required="required"></textarea>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="txtPeso" class="col-sm-4 col-form-label text-left">Instrucciones:</label>
										<div class="col-sm-12">
											<textarea name="txtInstructions" id="txtInstructions" rows="3" style="width: 100%" class="form-control" required="required"></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idCommand" name="idCommand" value="0">
			
		</div>
	</form>
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
				$("#sDate").datepicker({ 
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					dateFormat: 'dd-mm-yy',  
					minDate: new Date(),  
					beforeShowDay: $.datepicker.noWeekends 
				});
				
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