<?php require '../../plugs/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;
	session_start();
	//include 'getCommandDetailPDF.php';
$cuenta = 0;
$cuentaOt = 0;
$labTransfer = "";
$labTransfer = '<div style="width: 100%;margin-left: 15px;">
					<label style="font-weight: bold; font-size: 20px">Numero de transferencia:</label>
					<label style="font-weight: bold; font-size: 30px"></label>
				</div>';
//print_r($command);
//echo(int intval 3/2);
//exit();
$CMQUANTITY=10;
$code1 = '<td>
			<div>
				<div>
					<img src="../../img/logoHeader.png" alt="Logo">
					<div>
						&nbsp;
					</div>
					<br>
					<div>
						<div>
							<div>
								<label>Fecha de entrega</label><br>
								<label></label>
							</div>
						</div>
					</div>
					<br>
					<table border="0" >
						<tr>
							<td>
								<div>
									<label >Orden No.:</label>
									<label ></label>
								</div>
								<div >
									<label >Tipo de orden:</label>
									<label ></label>
								</div>

								<div >
									<label >Tipo de servicio:</label>
									<label ></label>
								</div>
							</td>
						</tr>
					</table>
					<br>
					<div>
						<div >
							<label >Salida de:</label>
							<br>
							<div >
								<label ></label><br>
								<label ></label><br>
								<label ></label><br>
							</div>
						</div>
					</div>';
for ($i = 1; $i <= $CMQUANTITY; $i++) {
	$code =	$code1 . '<div >' . $i . '/' . $CMQUANTITY .'</div>
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

try
{
	//echo $codeT;
	//exit();
    //$html2pdf = new Html2Pdf('L', 'letter', 'en');
    $html2pdf = new Html2Pdf('L','letter','en');
    //$html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($codeT);
    $html2pdf->Output('Impresioncomanda_' . $iComanda . '.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}	