<?  include("../../lib/@session.php");
require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));

$buscar_datos_ap = traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion"));
$busca_us_sox = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[2]"));
$busca_us_comprador = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[3]"));

function detalle_aspecto($aspecto,$campo){
	global $id_invitacion,$v4;
	$busca_detalle_apertura = traer_fila_row(query_db("select pro1_id, $campo from $v4 where pro1_id = $id_invitacion and aspecto = $aspecto"));
	if($busca_detalle_apertura[0]>=1)
	return $busca_detalle_apertura[1];
	else
	return "Sin apertura";
}


function arregla_texto_ti($valor){
		$id_subastas_arrglo = str_replace("'", "", $valor );
		$id_subastas_arrglo = str_replace('"', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('/', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('*', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('.', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('ñ', 'n', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('-', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('Ñ', 'N', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('@', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('&ntilde;', 'n', $id_subastas_arrglo);
		return $id_subastas_arrglo;
}

$arregla_conse_01 = arregla_texto_ti(htmlentities($linvi[22]));
$arregla_conse = arregla_texto_ti($arregla_conse_01);

$oferta_vista = 1;   
$valor_apertura_auditor=100000;

             /* CALCULO DEL VALOR DEL PROCESO PASARLO A DOLARES*/
			 
                    if($linvi[13]==1)
                        $cuantia=$linvi[14];
                    elseif($linvi[13]==2)
                    $cuantia=($linvi[14]+1) / 1800;
                    elseif($linvi[13]==3)
                        $cuantia=( ($linvi[14]+1) * 2700 ) / 1800;			
                
                $cuantia_arr = explode(".",$cuantia);		
                $cuantia =$cuantia_arr[0];		
                
				

        $busca_firma=traer_fila_row(query_db("select * from v_apertura_proceso_grantierra where pro1_id = $id_invitacion"));



$text.='
<table width="100%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td style="font-size:40px; border-bottom-color:#C7422F 2px;"><strong>Informaci&oacute;n General del Proceso</strong></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Consecutivo del proceso:</strong>'.$arregla_conse.'</div></td>
  </tr>
  <tr>
    <td ><strong>Fecha y hora de apertura:</strong>'.fecha_for_hora($linvi[17]).'</td>
  </tr>
  <tr>
    <td><strong>Fecha y hora de cierre:</strong>'.fecha_for_hora($linvi[18]).'</td>
  </tr>
  <tr>
    <td><div align="left"><strong>Detalle y cantidad del objeto a contratar:</strong>'.htmlentities($linvi[12]).'</div></td>
  </tr>
</table>

<br>
			

<table width="100%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td style="font-size:40px; border-bottom-color:#C7422F 2px;" ><div align="left"><strong>Informaci&oacute;n de apertura de ofertas</strong></div></td>
  </tr>
  <tr>
    <td ><div align="left"><strong>Fecha de apertura:</strong>'.$buscar_datos_ap[5].'</div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Hora de apertura:</strong>'.$buscar_datos_ap[6].'</div></td>
	 </tr>

  <tr>
    <td><strong>Usuario Apertura: '.htmlentities($busca_firma[2]).'</strong></td>
  </tr>
  <tr>
    <td><strong>Usuario Compras: '.htmlentities($busca_firma[3]).'</strong></td>
  </tr>  
</table>

<br>
           

<table width="100%" border="0" cellspacing="4" cellpadding="4">
  <tr>
		<td colspan="3" style="font-size:40px; border-bottom-color:#C7422F 2px;"><strong>APERTURA EVALUACION DE REQUERIMIENTOS SOLICITADOS EN EL PROCESO</strong></td>
  </tr>

  <tr>
    <td width="30%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Criterio</td>
    <td width="40%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Usuario de apertura</td>
    <td width="30%" bgcolor="#9FC2FD"  style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Fecha de apertura</td>
  </tr>

  <tr >
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC" ><div align="right"><strong>Apertura t&eacute;cnica</strong></div></td>
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.detalle_aspecto(2,"nombre_administrador").'</td>
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.detalle_aspecto(2,"fecha_apertura").'</td>
  </tr>
  <tr>
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="right"><strong>Apertura comercial </strong></div></td>
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.detalle_aspecto(1,"nombre_administrador").'</td>
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.detalle_aspecto(1,"fecha_apertura").'</td>
  </tr>

  <tr>
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="right"><strong>Apertura lista de precios</strong></div></td>
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.detalle_aspecto(3,"nombre_administrador").'</td>
    <td style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.detalle_aspecto(3,"fecha_apertura").'</td>
  </tr>

</table>


<table width="100%" border="0" cellspacing="4" cellpadding="4">
  <tr>
		<td colspan="5" style="font-size:40px; border-bottom-color:#C7422F 2px;"><strong>Proponentes</strong></td>
  </tr>

  <tr>
    <td width="10%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">NIT</td>
    <td width="40%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">proveedor</td>
    <td width="10%" bgcolor="#9FC2FD"  style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Confirma</td>
    <td width="10%" bgcolor="#9FC2FD"  style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Fecha</td>
    <td width="30%" bgcolor="#9FC2FD"  style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Justificaci&oacute;n</td>
  </tr>

';

	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup, $t7.observaciones  ,$t7.observaciones_2 from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t8.pv_id <> 1 ");
				while($lp = traer_fila_row($busca_provee)){
 				$busca_confirmacion = traer_fila_row(query_db("select * from v_confirmacion where pro1_id = $id_invitacion and pv_id = $lp[0] order by  fecha desc"));

	if($num_fila%2==0)
				$class=" bgcolor=\"#CCCCCC\" ";
			else
				$class="";
$text.='<tr>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[1]).'</td>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="left">'.htmlentities($lp[2]).'&nbsp;</div></td>
	<td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.$busca_confirmacion[2].'</td>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.fecha_for_hora($busca_confirmacion[3]).'&nbsp;</td>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"></td>    
  </tr>';
  
$num_fila++;   
   
   } 


   
$text.='</table>


<br>


			<table width="100%" border="0" cellspacing="4" cellpadding="4">
              <tr>
                <td colspan="5" style="font-size:40px; border-bottom-color:#C7422F 2px;">Resumen de acciones y ofertas enviadas por el proveedor.</td>
              </tr>
              <tr>
                <td width="49%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Nombre</div></td>
                <td width="13%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Fecha de visualiza proceso</div></td>
                <td width="14%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Envio ofertas t&eacute;cnicas</div></td>
                <td width="11%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Envio ofertas comerciales</div></td>
                <td width="13%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Envio ofertas ec&oacute;nomicas</div></td>
              </tr>';
              
			  
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
			
		  	if($num_fila%2==0)
				$class=" bgcolor=\"#CCCCCC\" ";
			else
				$class="";
			$documentos_faltantes = 0;
			$busca_ingresos = traer_fila_row(query_db("select * from $t36 where pro1_id = $id_invitacion and pv_id = ".$lp[0]));
			$busca_confirmacion = traer_fila_row(query_db("select confirmacion  from v_confirmacion where pro1_id = $id_invitacion and pv_id = $lp[0] order by pro4_id desc"));
			$busca_ofertas_tecnicas=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v10 where pro1_id = $id_invitacion and pv_id = $lp[0] and termino = 2  "));
			$busca_ofertas_comercial=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v10 where pro1_id = $id_invitacion and pv_id = $lp[0] and termino = 1  "));
			$busca_ofertas_economica=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v11 where in_id  = $id_invitacion and pv_id = $lp[0] and w_valor != ''  "));
			$busca_comuniocados_faltantes = traer_fila_row(query_db("select count(*) from $t29 where pro1_id = $id_invitacion and pv_id = $lp[0] and tp13_id  in (1,2,3,4) and estado = 1 and quien_ingresa != 'Proveedor'"));
			$busca_docuemntos_anexos=traer_fila_row(query_db("select count(*) from $t6 where pro1_id = $id_invitacion"));
			$busca_docuemntos_descagados=traer_fila_row(query_db("select count(distinct detalle) from $v5 where pro1_id = $id_invitacion and auditor_categoria_id = 3 and pv_id = $lp[0]"));
			$documentos_faltantes = ($busca_docuemntos_anexos[0]-$busca_docuemntos_descagados[0]);
							
			if($busca_confirmacion[0]=='')	$estado_conf="N / C";
			else $estado_conf=$busca_confirmacion[0];

             $text.='<tr class="'.$class.'">
                <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[2]).'</td>
                <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.$busca_ingresos[4].'</td>
                <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="center">'.$busca_ofertas_tecnicas[0].'</div></td>
                <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="center">'.$busca_ofertas_comercial[0].'</div></td>
                <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="center">'.$busca_ofertas_economica[0].'</div></td>
              </tr>';
               $num_fila++;
			  
			  } 
            $text.='</table>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td colspan="5" style="font-size:40px; border-bottom-color:#C7422F 2px;">Auditoria del proceso.</td>
       </tr>

  <tr>
    <td width="18%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Accion</td>
    <td width="17%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Nombre usuario</td>
    <td width="15%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Fecha</td>
    <td width="38%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Comentarios</td>
    <td width="12%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">IP de conexion</td>
  </tr>';
 
			  	
			  	$busca_provee = query_db("select * from $v5 where pro1_id =  $id_invitacion  order by fecha_hora desc ");
				while($lp = traer_fila_row($busca_provee)){
				  
				 if($lp[0]==3){
				 	$detalle2=traer_fila_row(query_db("select * from $t6 where pro2_id = $lp[9]"));
					$detalle=$detalle2[3];
					}
				else $detalle=$lp[9];
				
	  	if($num_fila%2==0)
				$class=" bgcolor=\"#CCCCCC\" ";
			else
				$class="";

	if( ($lp[0]==37) || ($lp[0]==38) )
		$comple=$lp[9];
	else $comple="";
				

$text.='<tr class="'.$class.'">
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[1]).'</td>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[5]).'</td>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[8]).'</td>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"></td>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[10]).'</td>
  </tr>';
   $num_fila++;
			 
			  } 
$text.='</table>
';







$text.='<table width="100%" border="0" cellspacing="4" cellpadding="4">
              <tr>
				<td colspan="3" style="font-size:40px; border-bottom-color:#C7422F 2px;"><strong>Firmas</strong></td>
              </tr>
              <tr>
                <td width="47%">&nbsp;</td>
                <td width="6%">&nbsp;</td>
                <td width="47%">&nbsp;</td>
              </tr>			  
              <tr>
                <td class="titulos_procesos">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="titulos_procesos">&nbsp;</td>
              </tr>
              <tr>
                <td><strong>'.$busca_firma[3].'</strong></td>
                <td>&nbsp;</td>
                <td><strong>
                  '.$busca_firma[2].'
                </strong></td>
              </tr>
              <tr>
                <td><strong>Delegado Compras</strong></td>
                <td>&nbsp;</td>
                <td><strong>Delegado Apertura</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
';

$texto=$text;
$titulo = "ACTA DE APERTURA DEL PROCESO";
$consecutivo_proceso=$arregla_conse;



$fecha_hora_generacion=htmlentities("Fecha de generacion del reporte: ").fecha_for_hora($fecha." ".$hora);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($sql_e[1]);
$pdf->SetTitle('Solicitud de Oferta de Servicios');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');



// set default header data
$pdf->SetHeaderData("logo_cliente_email.png", PDF_HEADER_LOGO_WIDTH, $titulo, "consecutivo: ".$arregla_conse." \n".$fecha_hora_generacion);
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
$pdf->Output('Acta_proceso_'.$consecutivo_proceso.'.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+

?>




</body>
</html>
