<?php require '../../../plugs/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;
	session_start();
	//require 'getCommandDetailPDF.php';

	require '../../../application/commands/getCommandDetail.php';

//print_r($command);
//exit();

if ($command['sDateConfirm'] != "") {  
	$dateConfirm = date('H:i', strtotime($command['sDateConfirm']));
}
if ($command['sDatePickup'] != "") {  
	$datePickup = date('H:i', strtotime($command['sDatePickup']));
}
if ($command['sDateDelivery'] != "") { 
	$dateDelivery = date('H:i', strtotime($command['sDateDelivery']));
}
if ($command['SGSCORE'] != "") { 
	$SGSCORE = '<div class="col-sm-12 text-center">';
	if ($command['SGSCORE'] == "1") {
		$SGSCORE = $SGSCORE . '<img alt="1" src="../../../img/bueno.png">';
	}
 	if ($command['SGSCORE'] == "2") {
		$SGSCORE = $SGSCORE . '<img alt="1" src="../../../img/regular.png">';
	}
	if ($command['SGSCORE'] == "3") {
		$SGSCORE = $SGSCORE . '<img alt="1" src="../../../img/malo.png">';
	}
	$SGSCORE = $SGSCORE . '</div>';
}

if ($command['oImgPickup'] != "") { 
	$oImgPickup = '<div ';
	if ($command['oImgDelivery'] != "") { 
		$oImgPickup = $oImgPickup . 'class="col-sm-6"';
	} else { 
		$oImgPickup = $oImgPickup . 'class="col-sm-12"';
	} 
	$oImgPickup = $oImgPickup . '><img alt="Foto" id="imgFoto" height="200px" src="../../../application/tracing/images/'. $command['oImgPickup'] .'"></div>';
}

if ($command['oImgDelivery'] != "") {
	$ImgDelivery = '<div ';
	if ($command['oImgPickup'] != "") { 
		$ImgDelivery = $ImgDelivery . 'class="col-sm-6"';
	} else { 
		$ImgDelivery = $ImgDelivery . 'class="col-sm-12"';
	} 
	$ImgDelivery = $ImgDelivery . '><img alt="Foto" id="imgFoto" height="200px" src="../../../application/tracing/images/'. $command['oImgDelivery'] .'"></div>';
}
if ($command['SGIMAGESIGNATURE'] != "") {
	$SGIMAGESIGNATURE = '<img alt="Foto" id="imgFoto" style="width:100px;" height="100px" src="../../../application/tracing/images/'. $command['SGIMAGESIGNATURE'] .'">';
}


$code = '<div>
			<table border="0" style="width: 330px; !important; ">
				<tr>
					<th style="width:110px !Important;"></th>
					<th style="width:110px !Important;"></th>
					<th style="width:110px !Important;"></th>
				</tr>
				<tr>
					<td rowspan="2">
						<img src="../../../img/logoHeader.png" alt="logo" style="width:300px;margin: 10px;">
					</td>
					<td style="text-align:right;">
						<label style="font-size: 20px;">Fecha de entrega</label>
					</td>
					<td></td>
				</tr>
				<tr>
					<td style="text-align:right;">
						<label style="font-size: 25px;">' . date("d/m/Y", strtotime( $command['sFechaRegistro'])) . '</label>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<label style="font-size: 20px;font-weight: bold;"># Orden:</label>
						<label style="font-size: 20px;">'. $command['iComanda'] .'</label><br><br>
						<label style="font-size: 20px;font-weight: bold;">Tipo:</label>
						<label style="font-size: 20px;">'. $command['sTipoComanda'] .'</label><br><br>
						<label style="font-size: 20px;font-weight: bold;">Estatus:</label>
						<label style="font-size: 20px;">'. $command['sEstatus'] .'</label><br><br>
						<label style="font-size: 20px;font-weight: bold;">Chofer:</label>
						<label style="font-size: 20px;">'. $command['NameChofer'] .'</label><br><br>
					</td>
					<td rowspan="2">
						<div class="form-group row" style="margin-left: 15px;">
							<label style="font-size: 20px;">Satisfacción del cliente:</label><br>
							'. $SGSCORE .'
						</div><br>
						<div class="form-group row text-left" style="margin-left: 15px;">
							<label style="font-size: 20px;">Fotograf&iacute;as:</label><br>
							<!--imagen de pickup-->
							'. $oImgPickup .'<br>
							<!--imagen de delivery-->
							'. $ImgDelivery .'
						</div><br>

						<div class="form-group row" style="margin-left: 15px;">
							<label style="font-size: 20px;">Instrucciones especiales:</label><br><br>
							<div style="border: 1px solid;">'. $command['sInstrucciones'] .'</div>
						</div>
					</td>
					<td rowspan="2" >
						<div style="text-align:center;">
							<label style="font-size: 20px;">Nombre:</label><br>
							<div>'. $command['sNombre'] .'</div>
						</div><br><br>
						<div style="text-align:center;">
							<label style="font-size: 20px;">Firma:</label><br>
							'. $SGIMAGESIGNATURE .'
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<hr style="border-top:2px dotted">
						<div class="form-group row" style="margin-left: 15px;">
							<label style="font-size: 20px;font-weight: bold;">Despachada:</label>
							<label>'. date('H:i', strtotime($command['sDespachada'])) .'</label><br><br>
							<label style="font-size: 20px;font-weight: bold;">Confirmada:</label>
							<label>'. $dateConfirm .'</label><br>
						</div><br>
						<hr style="border-top:2px dotted"><br>
						<div class="form-group row" style="margin-left: 15px;">
							<label style="font-size: 20px;font-weight: bold;">Recogida a:</label>
							<label>'. $datePickup .'</label><br><br>
							<label>'. $command['sDireccion'] .','. $command['sCiudad'] . $command['sCP'] .'</label>
						</div><br>
						<div class="form-group row" style="margin-left: 15px;">
							<label style="font-size: 20px;font-weight: bold;">Entregada a:</label>
							<label>'. $dateDelivery .'</label><br><br>
							<label>'. $command['sDireccionEntrega'] .','. $command['sCiudadEntrega'] . $command['sCPEntrega'] .'</label>
						</div>
					</td>
				</tr>
			</table>
		</div>';

//$code="";
try
{
	//echo $code;
    $html2pdf = new Html2Pdf('L', 'letter', 'en');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($code);
    $html2pdf->Output('Impresiondetalle_' . $command["iComanda"] . '.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
