<?php
include ('../appRoot.php');
//Incluimos la clase TCPDF
include_once($appRoot."/Common/php/utils/tcpdf/tcpdf.php");
require ($appRoot.'/Autentificacion/Usuarios.php');

if($permisos->lectura){
/* El proceso a seguir es:
 * 
 * 	- Obtener la lista de tareas del usuario (realizado en el objeto de tipo imprimirFacturaPDF
 *  - Para cada tarea obtener las horas para día del mes
 */
include ('_imprimirFacturaPDF.php');
$var = new ImprimirFacturaPDF($_GET);
$Cliente = $var->Factura->get_Cliente();
$Factura = $var->Factura;

	$tcpdf = new TCPDF();
	$textfont = 'freesans';
	
	//Configuracion datos del documento
	$tcpdf->SetCreator("SN");
	$tcpdf->SetAuthor("SN");
	$tcpdf->SetTitle("Factura");
	$tcpdf->SetSubject("Facturas");
	$tcpdf->SetKeywords("SN, facturacion");
	
	//configuraciones de la pagína (margenes)
	$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	 
	$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$tcpdf->setLanguageArray($l);
	$tcpdf->AliasNbPages();
	
	// set header fonts
	$tcpdf->setPrintHeader(true);
	$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN)); 
	$tcpdf->SetHeaderData(null, PDF_HEADER_LOGO_WIDTH, $Cliente->get_Razon_Social(), "Factura ".$Factura->get_Numero_Factura()); 
	
	//set footer font
	$tcpdf->setPrintFooter(true);
	$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 
	
	//Añado una nueva pagina
	$tcpdf->AddPage();
	
	//Seteo la fuente a usar
	$tcpdf->SetFont($textfont, "", 10);
	
	
	/********** COMENZAMOS A DIBUJAR **********/
	
	//Estilos para los datos
	//Los monto porque no admite CSS
	$styletabla = "width:500px;font-family:'verdana';";
	$stylezona = "padding:4px;background-color:#555;border-bottom: 1px solid #fff;";
	$styletitulo = "margin:0px;color:#FFF;font-size:x-small;";
	$stylecabecera = "text-align:left;background-color:#4A627D;border-top: 1px solid #ececec;color:#fff;font-size:x-small;";
	$styledatos1 = "color:#5f5f75;padding:4px;background-color:#ededed;border-bottom: 1px solid #e2e2e2;font-size:x-small;";
	$styledatos2 = "color:#5f5f75;padding:4px;background-color:#fff;border-bottom: 1px solid #f5f5f5;font-size:x-small;";//Fila blanca
	$stylepie1 = "text-align:left;background-color:#4A627D;border-top: 1px solid #ececec;color:#fff;font-size:x-small;";
	$stylepie2 = "text-align:right;background-color:#4A627D;border-top: 1px solid #ececec;color:#fff;font-size:x-small;";
	
	$lista_tareas = array();
	
	$htmlcontent .= '<table style="'.$styletabla.'" border="0" cellspacing="0" cellpadding="0">';
	
	
	// START IMPRESIÓN DE LA CABECERA
		$cabecera = '<tr>
						<td  style="'.$styledatos.'"> 
						</td>
					</tr>
					<tr>
						<td  style="'.$styledatos.'"> 
						</td>
					</tr>
					<tr>
						<td  style="'.$styledatos.'"> 
						</td>
					</tr>
					<tr>
						  <td style="'.$stylecabecera.'">Factura numero '.$Factura->get_Numero_Factura().'</td>';
		$cabecera .= '</tr>';
	// END IMPRESIÓN DE LA CABECERA
	
	// START IMPRESIÓN DEL CUERPO
		$cuerpo = '';
		$par = false;
		
			
		$styledatos='text-align:left;';
		$cuerpo .= '<tr><td  style="'.$styledatos.'"> 
						</td></tr>
					<tr>
						<td>
							Cliente: '.$Cliente->get_Razon_Social().'
						</td>
					</tr>
					<tr>
						<td>
							'.$Cliente->get_NIF().'
						</td>
					</tr>
					<tr>
						<td>
							'.$Cliente->get_Domicilio().'
						</td>
					</tr>
					<tr>
						<td  style="'.$styledatos.'"> 
						</td>
					</tr>
					';
		$cuerpo .= '<tr>
						<td>
							Fecha de facturacion: '.timestamp2date($var->Factura->get_Fecha_Facturacion()).'
						</td>
					</tr>';
		$cuerpo .= '<tr>
						<td>
							Fecha de pago: '.timestamp2date($var->Factura->get_Fecha_Pago()).'
						</td>
					</tr>';
		$cuerpo .= '<tr>
						<td>
							Base imponible: '.$var->Factura->get_Base_Imponible().' &euro;
						</td>
					</tr>';
		$cuerpo .= '<tr>
						<td>
							IVA: '.$var->Factura->get_IVA().' %
						</td>
					</tr>';
		$cuerpo .= '<tr>
						<td>
							Total: '.$var->Factura->get_Total().' &euro;
						</td>
					</tr>
					
					<tr>
						<td  style="'.$styledatos.'"> 
						</td>
					</tr>';
					
		$cuerpo.=' <tr>
					  <td style="'.$stylepie1.'">Fecha: '.date("d-m-Y").' 
					  </td>
					</tr>';
	//END IMPRESIÓN DEL CUERPO
		
	$htmlcontent .= $cabecera.$cuerpo.'</table>';
	
	//Escribo el HTML generado
	$tcpdf->writeHTML($htmlcontent, true, 0, true, 0); 
		
	//Fichero de Salida
	$tcpdf->Output("Factura_".$Factura->get_Numero_Factura()."pdf", "I");
}?>
