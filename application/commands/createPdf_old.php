<?php require '../../plugs/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;
	session_start();
	require 'getCommandDetailPDF.php';

	$code = '<div style="width: 541px;">
				<div style="width: 541px !important;">
					<img src="../../img/logoHeader.png" alt="Logo" style="width: 50px !important;">
					<div style="height: 10px;">
						&nbsp;
					</div>
					<br>
					<table border="0" style="width: 400px !important;">
						<tr>
							<td style="width: 337px;">
								<div style="width: 90%;">
									<label style="font-weight: bold; font-size: 20px">Orden No.:</label>
									<label style="font-weight: bold; font-size: 30px">' .  $command["iComanda"]  . '</label>
								</div>
								<div>
									<label style="font-size: 25px">Tipo de orden:</label>
									<label style="font-weight: bold; font-size: 25px">' .  $command["sTipoComanda"]  . '</label>
								</div>
							</td>
							<td style="width: 190px;">
								<div style="border: 1px solid black;">
									<div style="margin: 10px;">
										<label style="font-size: 20px">Fecha de entrega</label><br>
										<label style="font-size: 15px; font-weight: bold; ">' .  $command["fecha_completa"]  . '</label>
									</div>
								</div>
							</td>
						</tr>
					</table>
					<br>
					<div>
						<div style="width: 100%; margin-top: 10px; position: relative; ">
							<label style="font-weight: bold; font-size: 25px">Salida de:</label>
							<br>
							<div style="border: 1px solid black;">
								<label style="font-size: 25px">' .  $command["CMCONTAC"]  . '</label><br>
								<label style="font-size: 25px">' .  $command["sDireccion"]  . ' ' .  $command["sSuite"]  . '</label><br>
								<label style="font-size: 25px">' .  $command["sCiudad"]  . ' (' .  $command["PROV"]  . ') ' .  $command["sCP"]  . '</label><br>
							</div>
						</div>
					</div>
					<br>
					<div>
						<div style="width: 100%; margin-top: 10px; position: relative;">
							<label style="font-weight: bold; font-size: 25px">Entrega en:</label>
							<br>
							<div style="border: 1px solid black;">
								<label style="font-size: 25px">' .  $command["CMCONTACDELIVERY"]  . '</label><br>
								<label style="font-size: 25px">' .  $command["sDireccionEntrega"]  . ' ' .  $command["sSuiteEntrega"]  . '</label><br>
								<label style="font-size: 25px">' .  $command["sCiudadEntrega"]  . ' (' .  $command["PROVDELIVERY"]  . ') ' .  $command["sCPEntrega"]  . '</label><br>
							</div>
						</div>
					</div>';

	if(isset($commandTransfer)) {
		$code =	$code .	'
					<br>
					<div>
						<div style="width: 100%; margin-top: 10px; position: relative;">
							<label style="font-weight: bold; font-size: 25px">Retorno en:</label>
							<br>
							<div style="border: 1px solid black;">
								<label style="font-size: 25px">' .  $commandTransfer["CMCONTACDELIVERY"]  . '</label><br>
								<label style="font-size: 25px">' .  $commandTransfer["sDireccionEntrega"]  . ' ' .  $commandTransfer["sSuiteEntrega"]  . '</label><br>
								<label style="font-size: 25px">' .  $commandTransfer["sCiudadEntrega"]  . ' (' .  $commandTransfer["PROVDELIVERY"]  . ') ' .  $commandTransfer["sCPEntrega"]  . '</label><br>
							</div>
						</div>
					</div>';

	}

		$code =	$code . '</div>
			</div>';


try
{
    $html2pdf = new Html2Pdf('L', 'A4', 'en');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($code);
    $html2pdf->Output('Impresioncomanda_' . $command["iComanda"] . '.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}