<? include("../../lib/@session.php");
	
$busca_procesos = "select tp3_id,consecutivo,fecha_creacion,detalle_objeto,fecha_apertura,fecha_cierre,tp6_id,fecha_informativa  from $t5 where pro1_id =".$id_proceso;
$sql_e=traer_fila_row(query_db($busca_procesos));

if($sql_e[0]==1)
$titulo="Solicitud de Oferta de Materiales";
if($sql_e[0]==2)
$titulo="Solicitud de Oferta de Servicios";


$busca_documento = "select * from $tp16 where tipo = $sql_e[0]";
$sql_documento=traer_fila_row(query_db($busca_documento));

$busca_objeto = "select nombre from $tp6 where tp6_id = $sql_e[6]";
$b_o=traer_fila_row(query_db($busca_objeto));
$vari=strtolower($b_o[0]);

$busa_eje=query_db("select * from $v9 where pro1_id = ".$id_proceso);
while($ej=traer_fila_row($busa_eje))
	$ejecu.="<li>".htmlentities($ej[2])."; ".htmlentities($ej[3])."</li>";

$busca_provee = query_db("select $t6.pro2_id, $tp8.nombre, $t6.archivo,$t6.peso,$t6.fecha_carga from $t6, $tp8 where
				$t6.pro1_id =  $id_proceso and $tp8.tp8_id = $t6.tp8_id ");
				while($lp = traer_fila_row($busca_provee))
			   $documento.="<li>".htmlentities($lp[2])."</li>";	

									$text = $sql_documento[1];
									$text = str_replace("(funcion---consecutivo---)",htmlentities($sql_e[1]),$text);
									$text = str_replace("(funcion---fecha_ceracion---)",fecha_forsin_hora($sql_e[2]),$text);
									$text = str_replace("(funcion---alcance---)",htmlentities($sql_e[3]),$text);	
									$text = str_replace("(funcion---objeto---)",htmlentities($b_o[0]),$text);
									$text = str_replace("(funcion---lugar---)",$ejecu,$text);
									$text = str_replace("(funcion---documentos---)",$documento,$text);
									$text = str_replace("(funcion---apertura---)",fecha_for_hora($sql_e[4]),$text);
									$text = str_replace("(funcion---aclarciones---)",fecha_for_hora($sql_e[7]),$text);
									$text = str_replace("(funcion---cierre---)",fecha_for_hora($sql_e[5]),$text);																											
									
																	
$texto=$text;

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($sql_e[1]);
$pdf->SetTitle('Solicitud de Oferta de Servicios');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData("logo_cliente_email.png", PDF_HEADER_LOGO_WIDTH, $titulo, $sql_e[1]." - Versión  001 \nFecha ".fecha_forsin_hora($sql_e[2]));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)




// output some RTL HTML content
//$html.= '<div style="text-align:center">The words &#8220;<span dir="rtl">&#1502;&#1494;&#1500; [mazel] &#1496;&#1493;&#1489; [tov]</span>&#8221; mean &#8220;Congratulations!&#8221;</div>';
$html=$texto;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// test pre tag


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('solicitud_'.$sql_e[1].'.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
