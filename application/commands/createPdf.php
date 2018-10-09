<?php require '../../plugs/vendor/autoload.php';

	use Spipu\Html2Pdf\Html2Pdf;
	session_start();

	include '../configuration/config.php';
	include '../configuration/opendb.php';

	//require 'getCommandDetailPDF.php';
$cuenta = 0;
$cuentaOt = 0;
$labTransfer = "";
$code = "";
$codeTr = "";
$codeT = "";

//$command = array();
$sql = "SELECT `COMMANDS`.`IDCOMMAND` AS iComanda,
				`TYPECOMMAND`.`TCNAME` AS sTipoComanda,
				`STATUS`.`SNAME` AS sEstatus,
				`FK_COMMANDS_DRIVERS`.`FCDDATE` AS sDespachada,
				`COMMANDS`.`CMCREATIONDATE` AS sFechaRegistro,
				`COMMANDS`.`CMCONTAC`,
				`COMMANDS`.`CMTRANSFER`,
				`COMMANDS`.`PROV`,
				`COMMANDS`.`CMCONTACDELIVERY`,
				`COMMANDS`.`PROVDELIVERY`,
				`COMMANDS`.`CMQUANTITY`,
				`COMMANDS`.`CMADDRESS` AS sDireccion,
				`COMMANDS`.`CMSUITE` AS sSuite,		
				`COMMANDS`.`CMCITY` AS sCiudad,
				`COMMANDS`.`CMPC` AS sCP,
				`COMMANDS`.`CMADDRESSDELIVERY` AS sDireccionEntrega,
				`COMMANDS`.`CMSUITEDELIVERY` AS sSuiteEntrega,
				`COMMANDS`.`CMCITYDELIVERY` AS sCiudadEntrega,
				`COMMANDS`.`CMPCDELIVERY` AS sCPEntrega,
				`COMMANDS`.`CMINSTRUCTIONS` AS sInstrucciones,
				TRACINGCONFIRM.`TDATE` AS sDateConfirm,
				TRACINGPICKUP.`TDATE` AS sDatePickup,
				TRACINGDELIVERY.`TDATE` AS sDateDelivery,
				TRACINGPICKUP.`TIMAGEN` AS oImgPickup,
				TRACINGDELIVERY.`TIMAGEN` AS oImgDelivery,
				TRACINGDELIVERY.`TNOMBRE` AS sNombre,
				`SIGNATURES`.`SGSCORE`,
				`SIGNATURES`.`SGIMAGESIGNATURE`,
				CONCAT (
					DATE_FORMAT(`COMMANDS`.`CMDATE`, '%d'), ' de ',
					CASE MONTH(`COMMANDS`.`CMDATE`)
						WHEN 1 THEN 'Enero'
						WHEN 2 THEN 'Febrero'
						WHEN 3 THEN 'Marzo'
						WHEN 4 THEN 'Abril'
						WHEN 5 THEN 'Mayo'
						WHEN 6 THEN 'Junio'
						WHEN 7 THEN 'Julio'
						WHEN 8 THEN 'Agosto'
						WHEN 9 THEN 'Septiembre'
						WHEN 10 THEN 'Octubre'
						WHEN 11 THEN 'Noviembre'
						WHEN 12 THEN 'Diciembre'
					END, ' de ', DATE_FORMAT(`COMMANDS`.`CMDATE`, '%Y')) AS fecha_completa
			FROM `syswareo_haxpres`.`COMMANDS`
				INNER JOIN`syswareo_haxpres`.`STATUS`
					ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`
					ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				LEFT JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				LEFT JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGCONFIRM
					ON TRACINGCONFIRM.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGCONFIRM.`IDSTATUS` = 2
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGPICKUP
					ON TRACINGPICKUP.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGPICKUP.`IDSTATUS` = 3
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGDELIVERY
					ON TRACINGDELIVERY.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGDELIVERY.`IDSTATUS` = 4
				LEFT JOIN `syswareo_haxpres`.`SIGNATURES`
					ON `SIGNATURES`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
			WHERE `COMMANDS`.`IDCOMMANDCHILD` = {$_REQUEST['iCommand']};";

	$registros = mysqli_query($conexion, $sql);
	$error     = mysqli_error($conexion);

	while ($row = mysqli_fetch_assoc($registros)) {
	    //$commandTransfer = $row;
	    $labTransfer = '<div style="width: 100%;margin-left: 15px;">
							<label style="font-weight: bold; font-size: 20px">Numero de transferencia:</label>
							<label style="font-weight: bold; font-size: 30px">' .  $row["CMTRANSFER"]  . '</label>
						</div>';
	    $codeTr =	'<br>
					<div>
						<div style="width: 450px; margin-top: 10px; position: relative;">
							<label style="font-weight: bold; font-size: 20px">Retorno en:</label>
							<br>
							<div style="border: 1px solid black;">
								<label style="font-size: 20px">' .  $row["CMCONTACDELIVERY"]  . '</label><br>
								<label style="font-size: 20px">' .  $row["sDireccionEntrega"]  . ' ' .  $row["sSuiteEntrega"]  . '</label><br>
								<label style="font-size: 20px">' .  $row["sCiudadEntrega"]  . ' (' .  $row["PROVDELIVERY"]  . ') ' .  $row["sCPEntrega"]  . '</label><br>
							</div>
						</div>
					</div>';
	}

	mysqli_free_result($registros);


if ($_SESSION["USUARIO"][0]['IDROLES'] == 1) {
	$sql = "SELECT `COMMANDS`.`IDCOMMAND` AS iComanda,`TYPECOMMAND`.`TCNAME` AS sTipoComanda,`STATUS`.`SNAME` AS sEstatus,`FK_COMMANDS_DRIVERS`.`FCDDATE` AS sDespachada,`COMMANDS`.`CMCREATIONDATE` AS sFechaRegistro,`COMMANDS`.`CMCONTAC`,`COMMANDS`.`PROV`,`COMMANDS`.`CMQUANTITY`,`COMMANDS`.`CMCONTACDELIVERY`,`COMMANDS`.`PROVDELIVERY`,`COMMANDS`.`CMADDRESS` AS sDireccion,`COMMANDS`.`CMSUITE` AS sSuite,	`COMMANDS`.`CMCITY` AS sCiudad,`COMMANDS`.`CMPC` AS sCP,`COMMANDS`.`CMADDRESSDELIVERY` AS sDireccionEntrega,`COMMANDS`.`CMSUITEDELIVERY` AS sSuiteEntrega,`COMMANDS`.`CMCITYDELIVERY` AS sCiudadEntrega,`COMMANDS`.`CMPCDELIVERY` AS sCPEntrega,`COMMANDS`.`CMINSTRUCTIONS` AS sInstrucciones,
				`SUBSERVICES`.`NAME` AS nService,TRACINGCONFIRM.`TDATE` AS sDateConfirm,TRACINGPICKUP.`TDATE` AS sDatePickup, TRACINGDELIVERY.`TDATE` AS sDateDelivery,
				TRACINGPICKUP.`TIMAGEN` AS oImgPickup,	TRACINGDELIVERY.`TIMAGEN` AS oImgDelivery,	TRACINGDELIVERY.`TNOMBRE` AS sNombre,`SIGNATURES`.`SGSCORE`,
				`SIGNATURES`.`SGIMAGESIGNATURE`,CONCAT (DATE_FORMAT(`COMMANDS`.`CMDATE`, '%d'), ' de ',	CASE MONTH(`COMMANDS`.`CMDATE`)	WHEN 1 THEN 'Enero'
						WHEN 2 THEN 'Febrero'
						WHEN 3 THEN 'Marzo'
						WHEN 4 THEN 'Abril'
						WHEN 5 THEN 'Mayo'
						WHEN 6 THEN 'Junio'
						WHEN 7 THEN 'Julio'
						WHEN 8 THEN 'Agosto'
						WHEN 9 THEN 'Septiembre'
						WHEN 10 THEN 'Octubre'
						WHEN 11 THEN 'Noviembre'
						WHEN 12 THEN 'Diciembre'
		END, ' de ', DATE_FORMAT(`COMMANDS`.`CMDATE`, '%Y')) AS fecha_completa FROM `syswareo_haxpres`.`COMMANDS` INNER JOIN`syswareo_haxpres`.`STATUS`	ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`	INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`	ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`	INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`	INNER JOIN `syswareo_haxpres`.`SUBSERVICES`	ON `SUBSERVICES`.`IDSUBSERVICES` = `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`	LEFT JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				LEFT JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGCONFIRM
					ON TRACINGCONFIRM.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGCONFIRM.`IDSTATUS` = 2
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGPICKUP
					ON TRACINGPICKUP.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGPICKUP.`IDSTATUS` = 3
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGDELIVERY
					ON TRACINGDELIVERY.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGDELIVERY.`IDSTATUS` = 4
				LEFT JOIN `syswareo_haxpres`.`SIGNATURES`
					ON `SIGNATURES`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
			WHERE `COMMANDS`.`IDCOMMAND` = {$_REQUEST['iCommand']};";
} else {
	$sql = "SELECT `COMMANDS`.`IDCOMMAND` AS iComanda,
				`TYPECOMMAND`.`TCNAME` AS sTipoComanda,
				`STATUS`.`SNAME` AS sEstatus,
				`FK_COMMANDS_DRIVERS`.`FCDDATE` AS sDespachada,
				`COMMANDS`.`CMCREATIONDATE` AS sFechaRegistro,
				`COMMANDS`.`CMCONTAC`,
				`COMMANDS`.`PROV`,
				`COMMANDS`.`CMQUANTITY`,
				`COMMANDS`.`CMCONTACDELIVERY`,
				`COMMANDS`.`PROVDELIVERY`,
				`COMMANDS`.`CMADDRESS` AS sDireccion,
				`COMMANDS`.`CMSUITE` AS sSuite,		
				`COMMANDS`.`CMCITY` AS sCiudad,
				`COMMANDS`.`CMPC` AS sCP,
				`COMMANDS`.`CMADDRESSDELIVERY` AS sDireccionEntrega,
				`COMMANDS`.`CMSUITEDELIVERY` AS sSuiteEntrega,
				`COMMANDS`.`CMCITYDELIVERY` AS sCiudadEntrega,
				`COMMANDS`.`CMPCDELIVERY` AS sCPEntrega,
				`COMMANDS`.`CMINSTRUCTIONS` AS sInstrucciones,
				`SUBSERVICES`.`NAME` AS nService,
				TRACINGCONFIRM.`TDATE` AS sDateConfirm,
				TRACINGPICKUP.`TDATE` AS sDatePickup,
				TRACINGDELIVERY.`TDATE` AS sDateDelivery,
				TRACINGPICKUP.`TIMAGEN` AS oImgPickup,
				TRACINGDELIVERY.`TIMAGEN` AS oImgDelivery,
				TRACINGDELIVERY.`TNOMBRE` AS sNombre,
				`SIGNATURES`.`SGSCORE`,
				`SIGNATURES`.`SGIMAGESIGNATURE`,
				CONCAT (
					DATE_FORMAT(`COMMANDS`.`CMDATE`, '%d'), ' de ',
					CASE MONTH(`COMMANDS`.`CMDATE`)
						WHEN 1 THEN 'Enero'
						WHEN 2 THEN 'Febrero'
						WHEN 3 THEN 'Marzo'
						WHEN 4 THEN 'Abril'
						WHEN 5 THEN 'Mayo'
						WHEN 6 THEN 'Junio'
						WHEN 7 THEN 'Julio'
						WHEN 8 THEN 'Agosto'
						WHEN 9 THEN 'Septiembre'
						WHEN 10 THEN 'Octubre'
						WHEN 11 THEN 'Noviembre'
						WHEN 12 THEN 'Diciembre'
					END, ' de ', DATE_FORMAT(`COMMANDS`.`CMDATE`, '%Y')) AS fecha_completa
			FROM `syswareo_haxpres`.`COMMANDS`
				INNER JOIN`syswareo_haxpres`.`STATUS`
					ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`
					ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`

				INNER JOIN `syswareo_haxpres`.`SUBSERVICES`
					ON `SUBSERVICES`.`IDSUBSERVICES` = `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`
					
				LEFT JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				LEFT JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGCONFIRM
					ON TRACINGCONFIRM.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGCONFIRM.`IDSTATUS` = 2
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGPICKUP
					ON TRACINGPICKUP.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGPICKUP.`IDSTATUS` = 3
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGDELIVERY
					ON TRACINGDELIVERY.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGDELIVERY.`IDSTATUS` = 4
				LEFT JOIN `syswareo_haxpres`.`SIGNATURES`
					ON `SIGNATURES`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
			WHERE `COMMANDS`.`IDCOMMAND` = {$_REQUEST['iCommand']}
				AND `COMMANDS`.`IDCUSTOMER` = {$_SESSION["USUARIO"][0]['IDCUSTOMER']};";
}

$registros = mysqli_query($conexion, $sql);
$error     = mysqli_error($conexion);

while ($row = mysqli_fetch_assoc($registros)) {
    //$command = $row;
    
    //$row["CMQUANTITY"]

    $CMQUANTITY = $row["CMQUANTITY"];
    //$CMQUANTITY = 10;

    for ($i = 1; $i <= $CMQUANTITY; $i++) {
		$code = $code . '<td>
				<div style="width: 520px;height:570px; float:left;">
					<div style="width: 400px !important;  border: 2px solid; ">
						<img src="../../img/logoHeader.png" alt="Logo" style="width: 50px !important;">
						<div style="height: 10px;">
							&nbsp;
						</div>
						<br>
						<div>
							<div style="width: 450px; margin-top: 10px; position: relative;  margin-left: 25px; ">
								<div style="border: 1px solid black;text-align:center;">
									<label style="font-size: 15px">Fecha de entrega</label><br>
									<label style="font-size: 25px; font-weight: bold; ">' .  $row["fecha_completa"]  . '</label>
								</div>
							</div>
						</div>
						<br>
						<table border="0" style="width: 100% !important;">
							<tr>
								<td style="width: 350px;">
									<div style="width: 100%;margin-left: 15px;">
										<label style="font-weight: bold; font-size: 15px">Orden No.:</label>
										<label style="font-weight: bold; font-size: 25px">' .  $row["iComanda"]  . '</label>
									</div>
									<div style="width: 100%;margin-left: 15px;">
										<label style="font-weight: bold; font-size: 15px">Tipo de orden:</label>
										<label style="font-weight: bold; font-size: 25px">' .  $row["sTipoComanda"]  . '</label>
									</div>

									<div style="width: 100%;margin-left: 15px;">
										<label style="font-weight: bold; font-size: 15px">Tipo de servicio:</label>
										<label style="font-weight: bold; font-size: 25px">' .  $row["nService"]  . '</label>
									</div>
									'. $labTransfer .'
								</td>
							</tr>
						</table>
						<br>
						<div>
							<div style="width: 450px; margin-top: 10px; position: relative;  margin-left: 15px;">
								<label style="font-weight: bold; font-size: 20px">Salida de:</label>
								<br>
								<div style="border: 1px solid black;">
									<label style="font-size: 20px">' .  $row["CMCONTAC"]  . '</label><br>
									<label style="font-size: 20px">' .  $row["sDireccion"]  . ' ' .  $row["sSuite"]  . '</label><br>
									<label style="font-size: 20px">' .  $row["sCiudad"]  . ' (' .  $row["PROV"]  . ') ' .  $row["sCP"]  . '</label><br>
								</div>
							</div>
						</div>';

			$code =	$code .	$codeTr;

			$code =	$code . '<div style="font-size: 20px;margin-top:200px;margin-left:420px;">' . $i . '/' . $CMQUANTITY .'</div>
			</div>
				</div>
				</td>';

		$cuenta = $cuenta + 1;
		
		if ($CMQUANTITY%2==0){
	    	if($cuenta==2){
				$cuenta = 0;
				$codeT = $codeT . '<div><table><tr>' . $code . '</tr></table></div>';
				$code = "";
			}
		}else{
			
			if (intval($CMQUANTITY/2)<= $cuentaOt){
		    	if($cuenta==1){
		    		$cuentaOt = $cuentaOt + 1;
					$cuenta = 0;
					$codeT = $codeT . '<div><table><tr>' . $code . '</tr></table></div>';
					$code = "";
				
				}
			}else{
				if($cuenta==2){
					$cuentaOt = $cuentaOt + 1;
					$cuenta = 0;
					$codeT = $codeT . '<div><table><tr>' . $code . '</tr></table></div>';
					$code = "";
				}	
			}
		}
		
	}
    
}



mysqli_free_result($registros);
include '../configuration/closedb.php';


try
{
	//echo $codeT;
	//exit();
    //$html2pdf = new Html2Pdf('L', 'letter', 'en');
    $html2pdf = new Html2Pdf('L','letter','es','true','UTF-8');
    //$html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($codeT);
    $html2pdf->Output('Impresioncomanda_' . $_REQUEST['iCommand'] . '.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}	