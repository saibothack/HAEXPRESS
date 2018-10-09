<?php
session_start();
if (!isset($_SESSION["USUARIO"])) {
	header( 'Location: ../../../index.php' );
}
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>.:: Haexpress ::.</title>
	<link rel="icon" href="../../../img/logoHeader.png">
	<link rel="stylesheet" type="text/css" href="../../../plugs/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-3.3.7/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/fonts.css">
	<link rel="stylesheet" type="text/css" href="../../../css/styles.css">
	<link rel="stylesheet" type="text/css" href="../../../css/comandasNew.css">
	<style>
		html,
		body {
			height: 99%;
			width: 99.8%;
			font-size: 17px;	
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<form action="../../../application/user/endSession.php">
			<header>
				<div class="row">
					<div class="col-md-2">
						<img alt="logo" src="../../../img/logoHeader.png" style="width: 100%;">
					</div>
					<div class="col-md-2">
						<div class="row" style="color: white;">
							<div class="col-sm-6">
								<h1 style="font-size: 25px;">Bienvenido</h1>
								<h3 style="font-size: 15px;">
									<?php echo $_SESSION["USUARIO"][0]["UNAME"] ?>
								</h3>
							</div>
							<div class="col-sm-6">
								<a href="#" id="idNotification">
									<div style="display: block; margin-top: 5px !important;">
										<div class="notificationNumber" id="idRedNotification">
											<label id="idNumberNotification"></label>
										</div>
										<img src="../../../img/mail.png" alt="MailBox" style="width: 60px"/>
									</div>
								</a>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
					</div>
					<div class="col-sm-2 text-right">
						<input type="submit" class="navButton" style="width: 80px;" value="Salir" id="btnSalir"/>
					</div>
				</div>
			</header>
			<nav>
				<div class="row">
					<div class="col-sm-2">
						<input type="button" class="navButton" value="Ordenes del día" id="btnOrdenDia" />
					</div>
					<div class="col-sm-10" id="divClientes">
						<div class="row">
							<div class="col-sm-2">
								<input type="button" class="navButton" value="Ordenes completadas" id="btnOrdenesCompletas"/>
							</div>
							<div class="col-sm-2">
								<input type="button" class="navButton" value="Agregar nueva orden" id="addComanda"/>
							</div>
							<div class="col-sm-5">
							</div>
						</div>
					</div>
					<div class="col-sm-10" id="divFiltros">
						<div class="form-group row">
							<div class="col-md-1 text-right">
								<input type="radio" name="btnSearch" value="1">
							</div>
							<label for="dateFilterWeekend" class="col-md-1 form-label"  style="font-size: 17px; color: white;">Vista semanal</label>
							<div class="col-md-5">
								<input class="form-control" type="text" id="dateFilterWeekend" name="dateFilterWeekend" placeholder="Ingrese una semana">
							</div>
							<div class="col-md-2">
								<input type="button" class="navButton" value="Buscar" id="btnBuscar">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-1 text-right">
								<input type="radio" name="btnSearch" value="2">
							</div>
							<label for="cmbTipoFiltro" class="col-md-1 form-label"  style="font-size: 17px; color: white;">Avanzado</label>
							<div class="col-md-2">
								<select name="cmbTipoFiltro" id="cmbTipoFiltro" class="form-control">
									<option value="">Seleccione</option>
									<option value="1">Fechas</option>
									<option value="2">Nombre de chofer</option>
									<option value="3">Nombre de cliente</option>
									<option value="4">Referencia</option>
									<option value="5">Contacto</option>
								</select>
							</div>
							<div class="col-md-3" id="divFechasSearch">
								<div class="row">
									<div class="col-sm-6">
										<input type="text" id="dateStart" name="dateStart" class="form-control" placeholder="Fecha inicial">
									</div>
									<div class="col-sm-6">
										<input type="text" id="dateEnd" name="dateEnd" class="form-control" placeholder="Fecha final">
									</div>
								</div>
							</div>
							<div class="col-md-3" id="divSearch">
								<input type="text" id="txtSearch" name="txtSearch" class="form-control" placeholder="Ingrese su busqueda">
							</div>
						</div>
					</div>
				</div>
		</form>
		<div class="row bodyPage">
			<div class="col-sm-12 divTransicion" style="height: 789px !important;" id="divCenter">
				<div class="row">
					<div class="col-sm-1 titulo">
						<label>Ordenes</label>
					</div>
					<div class="col-sm-1 titulo">
						<label>Estatus</label>
					</div>
					<div class="col-sm-2 titulo">
						<label>Tipo</label>
					</div>
					<div class="col-sm-5" id="divDireccion">
						<div class="row">
							<div class="col-sm-6 titulo">
								<label>Recoger</label>
							</div>
							<div class="col-sm-6 titulo">
								<label>Entregar</label>
							</div>
						</div>
					</div>
					<div class="col-sm-1 titulo">
						<label id="lblAntes">Hora</label>
					</div>
					<div class="col-sm-1 titulo">
						<label>Chofer</label>
					</div>
                    <div class="col-sm-1 titulo" id="divDetalles">
						<label>Detalles</label>
					</div>
					<div class="col-sm-1 titulo">
						<label>Impresion</label>
					</div>
				</div>
				<div class="row border">
					<div class="col-sm-12">
						<div class="row" style="height: 765px !important;">
							<div class="col-sm-12" id="gridCommands" style="overflow-y: auto; height: 100% !important;">

							</div>
						</div>
					</div>
				</div>
			</div>
			<!--<div id="divDerecho" class="col-sm-3 border" style="background-color: rgb(208, 209, 211); height: 789px !important;">
				<form action="#" data-toggle="validator" role="form" method="post" id="frmEditar">
					<div class="row">
						<div class="col-sm-6 titulo text-left">
							<label>Ordenes:</label>
							<label id="lblNoOrden" name="lblNoOrden"></label>
						</div>
						<div class="col-sm-6 titulo text-left">
							<label>Cliente:</label>
							<label id="lblCliente" name="lblCliente"></label>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 border">
							<div class="form-group">
								<label for="txtCompanty" class="col-form-label">Compañia</label>
								<input type="text" class="form-control" id="txtCompanty" name="txtCompanty" placeholder="Ingrese Compañia" required="required">
							</div>
							<div class="form-group">
								<label for="txtContact" class="col-form-label">Contacto</label>
								<input type="text" class="form-control" id="txtContact" name="txtContact" placeholder="Ingrese Contacto" required="required">
							</div>
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group">
										<label for="txtAddress" class="col-form-label">Dirección</label>
										<input type="text" class="form-control" id="txtAddress" name="txtAddress" placeholder="Ingrese Dirección" required="required">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="txtSuite" class="col-form-label">Apt</label>
										<input type="text" class="form-control" id="txtSuite" name="txtSuite" placeholder="Apt">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group">
										<label for="txtCity" class="col-form-label">Ciudad</label>
										<input type="text" class="form-control" id="txtCity" name="txtCity" placeholder="Ingrese Ciudad" required="required">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="txtProv" class="col-form-label">Prov</label>
										<input type="text" class="form-control" id="txtProv" name="txtProv" placeholder="Prov">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="txtPhone" class="col-form-label">Teléfono</label>
								<input type="text" class="form-control" id="txtPhone" name="txtPhone" placeholder="Ingrese teléfono" required="required">
							</div>
							<div class="form-group">
								&nbsp;
							</div>
						</div>
						<div class="col-sm-6 border">
							<div class="form-group">
								<label for="txtCompantyDelivery" class="col-form-label">Compañia</label>
								<input type="text" class="form-control" id="txtCompantyDelivery" name="txtCompantyDelivery" placeholder="Ingrese Compañia" required="required">
							</div>
							<div class="form-group">
								<label for="txtContactDelivery" class="col-form-label">Contacto</label>
								<input type="text" class="form-control" id="txtContactDelivery" name="txtContactDelivery" placeholder="Ingrese Contacto" required="required">
							</div>
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group">
										<label for="txtAddressDelivery" class="col-form-label">Dirección</label>
										<input type="text" class="form-control" id="txtAddressDelivery" name="txtAddressDelivery" placeholder="Ingrese Dirección" required="required">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="txtSuiteDelivery" class="col-form-label">Apt</label>
										<input type="text" class="form-control" id="txtSuiteDelivery" name="txtSuiteDelivery" placeholder="Apt">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group">
										<label for="txtCityDelivery" class="col-form-label">Ciudad</label>
										<input type="text" class="form-control" id="txtCityDelivery" name="txtCityDelivery" placeholder="Ingrese Ciudad" required="required">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="txtProvDelivery" class="col-form-label">Prov</label>
										<input type="text" class="form-control" id="txtProvDelivery" name="txtProvDelivery" placeholder="Prov">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="txtPhoneDelivery" class="col-form-label">Teléfono</label>
								<input type="text" class="form-control" id="txtPhoneDelivery" name="txtPhoneDelivery" placeholder="Ingrese teléfono" required="required">
							</div>
							<div class="form-group">
								&nbsp;
							</div>
						</div>
					</div>
					<div class="row border" style="border-bottom: 0px;">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="cmbTypeCommand" class="col-form-label">Tipo de orden</label>
								<select class="form-control" id="cmbTypeCommand" name="cmbTypeCommand" required="required">
									<option value="">Seleccione</option>
									<?php 
										include "../../../application/services/getServices.php";
										foreach ($rows as &$valor) {
											echo "<option data-color='{$valor["TCCOLOR"]}' style='color:{$valor["TCCOLOR"]}' value='{$valor["IDTYPECOMAMAND"]}'>{$valor["TCNAME"]}</option>";
										}

										unset($valor);
										unset($rows);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="cmbVehiculo" class="col-form-label">Tipo de Vehículo</label>
								<select class="form-control" id="cmbVehiculo" name="cmbVehiculo" required="required">
									<option value="">Seleccione</option>
									<?php 
										include "../../../application/typetrucks/getTypeTruckList.php";
										foreach ($rowsTypeTruck as &$valor) {
											echo "<option value='{$valor["IDTYPETRUCK"]}'>{$valor["TTNAME"]}</option>";
										}

										unset($valor);
										unset($rowsTypeTruck);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="cmbEstatus" class="col-form-label">Estatus</label>
								<select class="form-control" id="cmbEstatus" name="cmbEstatus" required="required">
									<option value="">Seleccione</option>
									<?php 
										include "../../../application/status/getStatus.php";
										foreach ($rowsStatus as &$valor) {
											echo "<option data-color='{$valor["COLOR"]}' style='color:{$valor["COLOR"]}' value='{$valor["IDSTATUS"]}'>{$valor["SNAME"]}</option>";
										}

										unset($valor);
										unset($rowsStatus);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtInstructions" class="col-form-label">Instrucciones especiales</label>
								<textarea class="form-control" name="txtInstructions" id="txtInstructions" rows="3" cols="23" style="height: 85px !important;"></textarea>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="cmbService" class="col-form-label">Tipo de Servicio</label>
								<select class="form-control" id="cmbService" name="cmbService" required="required">
									<option value="">Seleccione</option>
								</select>
							</div>
							<div class="form-group">
								<label for="cmbMerchandise" class="col-form-label">Mercancia</label>
								<select class="form-control" id="cmbMerchandise" name="cmbMerchandise" required="required">
									<option value="">Seleccione</option>
									<?php 
										include "../../../application/merchandise/getMerchandise.php";
										foreach ($rows as &$valor) {
											echo "<option value='{$valor["IDMERCHANDISE"]}'>{$valor["NAME"]}</option>";
										}

										unset($valor);
										unset($rows);
									?>
								</select>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="txtQuanty" class="col-form-label">Cantidad</label>
											<input type="text" class="form-control" id="txtQuanty" name="txtQuanty" placeholder="Ingrese cantidad" required="required">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="txtWeight" class="col-form-label">Peso</label>
											<input type="text" class="form-control" id="txtWeight" name="txtWeight" placeholder="Ingrese Peso" required="required">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="txtReference" class="col-form-label">Referencia/SKU</label>
								<input type="text" class="form-control" id="txtReference" name="txtReference" placeholder="Ingrese Referencia/SKU">
							</div>
							<div class="form-group" id="divTransfer">
								<label for="txtTransfer" class="col-form-label">No. Transferencia</label>
								<input type="text" class="form-control" id="txtTransfer" name="txtTransfer" placeholder="Ingrese transferencia">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-6">
									<input type="button" class="btnDefaultAjust" id="btnImprimir" style="min-width: 75px; width: 100%;" value="Imprimir">
								</div>
								<div class="col-sm-6">
									<input type="button" class="btnDefaultAjust" id="btnCancelar" style="min-width: 75px; width: 100%;" value="Cancelar">
								</div>
							</div>

						</div>
						<input type="hidden" id="iCommand" name="iCommand" value="0">
					</div>
				</form>
			</div>-->
		</div>
		<div id="dialog">
			<iframe id="frmDialog" src=""></iframe>
		</div>
	</div>
	<script type="text/javascript" src="../../../plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery-ui-1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../../../plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="../../../plugs/validator.js"></script>
	<script type="text/javascript" src="../../../script/comands/functionsClient.js"></script>
	</script>
	<style>
		label {
		    font-weight: normal !important;
		}
		
		#map {
			height: 330px;
		}
	</style>
</body>

</html>