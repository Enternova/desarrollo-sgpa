<?  include("../../lib/@session.php");
require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));


//$buscar_datos_ap = traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion"));
//$busca_us_sox = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[2]"));
//$busca_us_comprador = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[3]"));


$text.='
<table width="100%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td style="font-size:40px; border-bottom-color:#C7422F 2px;"><strong>Informaci&oacute;n General del Proceso</strong></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Consecutivo del proceso:</strong>'.$linvi[22].'</div></td>
  </tr>
  <tr>
    <td ><strong>Estado del proceso:</strong>'.fecha_for_hora($linvi[17]).'</td>
  </tr>
  <tr>
    <td><div align="left"><strong>'.$lenguaje_0.':</strong>'.$linvi[12].'</div></td>
  </tr>
</table>


<br>';

	$busca_provee_ad = traer_fila_row(query_db("select count(*) from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social "));
	if($busca_provee_ad[0]>=1){//si exiten adjudicados

           

$text.='<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" ><strong>Proveedores adjudicados</strong></td>
  </tr>
  <tr>
    <td width="60%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center"><strong>Proveedor </strong></div>      <div align="center"></div>      <div align="center"></div></td>
    <td width="20%"bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC" ><strong>Fecha envi&oacute;</strong></td>
    <td width="20%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC" ><div align="center"><strong>Visualizaci&oacute;n</strong></div></td>
  </tr>
';
 

			  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado, acepta_terminos,fecha_envio from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado_a="";
				$estado_acep="";
				 $buscar_notificaciones_a = "select * from $t46 where pro1_id = $id_invitacion and tipo_adj_no_adj  = 1 and pv_id = $lp[2] and pro27_id = $lp[0]";
			  	$sql_ex_adjudicados=traer_fila_row(query_db($buscar_notificaciones_a));

					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $sql_ex_adjudicados[0] order by fecha_lectura"));
				
				if($lp[9]==0) $estado_acep="Pendiente";
				elseif($lp[9]==1) $estado_acep="Si acepta";
				elseif($lp[9]==2) $estado_acep="No acepta";		
				
				$busca_hi_com = traer_fila_row(query_db("select count(*) from $vt16 where pro27_id = $lp[0]"));		

			if($num_fila%2==0)
							$class=" bgcolor=\"#CCCCCC\" ";
						else
							$class="";				
  
  $text.='<tr>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[3]).'</td>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.fecha_for_hora($lp[10]).'</td>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="center">'.fecha_for_hora($visualizacion[0]).'</div></td>
  </tr>';
  $num_fila++;} 
$text.='</table>';
 } // si existen adjudicados
$text.='<br>';


		  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];
			
	
			  	$busca_provee_noad = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social "));
if($busca_provee_noad[0]>=1){//si exiten no adjudicados			


$text.='<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_subtitulo_resultados"><strong>Proveedores NO adjudicados y con envi&oacute; de notificaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="30%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Nombre proveedor</strong></td>
    <td width="30%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="left"><strong>Comentarios</strong></div></td>
    <td width="20%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Fecha Envi&oacute;</strong></td>
    <td width="20%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Visualizaci&oacute;n</strong></td>
  </tr>';

			
			$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";

 			if($num_fila%2==0)
							$class=" bgcolor=\"#CCCCCC\" ";
						else
							$class="";	
			  
    $text.='<tr>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[2]).'</td>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[4]).'</td>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.fecha_for_hora($lp[3]).'</td>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="center">'.fecha_for_hora($visualizacion[0]).'</div></td>
  </tr>';
   $num_fila++;} 
$text.='</table><br>';


} //si exiten no adjudicados	

$busca_provee_noad_sin_en = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado = 3  order by razon_social "));
				
if($busca_provee_noad_sin_en[0]>=1){//si no exiten sin envios	

$text.='<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_subtitulo_resultados"><strong>Proveedores NO adjudicados y con envi&oacute; de notificaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="30%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Nombre proveedor</strong></td>
    <td width="70%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="left"><strong>Comentarios</strong></div></td>
  </tr>';


			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado = 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

    $text.='<tr>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[2]).'</td>
    <td '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[4]).'</td>
  </tr>';
   $num_fila++;} 
$text.='</table> <br>';


}//si no exiten sin envios	


		  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];
			
	
			  	$busca_provee_noad = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 4 and notificado <> 3  order by razon_social "));
if($busca_provee_noad[0]>=1){//si exiten no adjudicados			

$text.='<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_subtitulo_resultados">
      '.listas_sin_select($tp1,$sql_e[1],1).'
    </td>
  </tr>
  <tr>
    <td width="30%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Nombre proveedor</strong></td>
    <td width="30%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="left"><strong>Comentarios</strong></div></td>
    <td width="20%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Fecha Envi&oacute;</strong></td>
    <td width="20%" bgcolor="#9FC2FD" style="height:20px;font-size:30px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Visualizaci&oacute;n</strong></td>

  </tr>';
  
  $num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 4 and notificado <> 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

 			if($num_fila%2==0)
							$class=" bgcolor=\"#CCCCCC\" ";
						else
							$class="";	
							
   $text.=' <tr >

    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[2]).'</td>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[4]).'</td>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities(fecha_for_hora($lp[3])).'</td>
    <td  '.$class.' style="font-size:25px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="center">'.htmlentities(fecha_for_hora($visualizacion[0])).'</div></td>

  </tr>';
  $num_fila++;} 
$text.='</table>';

						

}//si exiten OTROS ESTADO			





/**************IMPRIME LAS CRTAS********************/
	$busca_provee_ad = traer_fila_row(query_db("select count(*) from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social "));
	if($busca_provee_ad[0]>=1){//si exiten adjudicados CARTA
	
	$text.='<table width="100%" border="0" cellspacing="2" cellpadding="2" >
				  <tr>
					<td width="83%" class="titulos_evaluacion">CARTA DE ADJUDICACION</td>
				  </tr>
				</table>';
	
		  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado, acepta_terminos,fecha_envio from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){//IMPORIME VUSCA AUDUJIDACOS
				
				$text.='<table width="100%" border="1" cellpadding="2" cellspacing="2" >';

 
$cambia_estado_carta = traer_fila_row(query_db("select * from $t45 where pro1_id = $id_invitacion and pv_id = $lp[2] and acepta_terminos = 1")); 
$text.=' <tr>
    <td style="font-size:25px;">'.$cambia_estado_carta[4].'</td>
  </tr>
</table><br>';
				
				}//IMPORIME VUSCA AUDUJIDACOS
	
	
	} //si exiten adjudicados CARTA
	
	
  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];
			
	
			  	$busca_provee_noad = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social "));
				if($busca_provee_noad[0]>=1){//si exiten no adjudicados	

	$text.='<table width="100%" border="0" cellspacing="2" cellpadding="2" >
				  <tr>
					<td width="83%" class="titulos_evaluacion">CARTA DE NO ADJUDICACION</td>
				  </tr>
				</table>';

			$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){//IMPRIME BUSCA NO ADJUDICADOS
				$icono_enviado="";
				$cambia_estado_carta = traer_fila_row(query_db("select fecha_envio from $t46 where pro30_id =  $lp[0] "));
				$busca_proveedor = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $lp[1]"));
				
				$text.='<table width="100%" border="1" cellpadding="2" cellspacing="2" >';

			$text.=' <tr>
				<td style="font-size:25px;"><p>Bogot&aacute;,'.fecha_for_sin_hora($cambia_estado_carta[0]).'
    </p>
        <p>&nbsp;</p>
      <p>Se&ntilde;ores<br>
            <strong>
              '.$busca_proveedor[0].'
          </strong></p>
      <p>&nbsp;</p>
      <p><strong>REFERENCIA:   NO ADJUDICACION | CONSECUTIVO '.$linvi[22].'
        </strong></p>
      <p>&nbsp;</p>
      <p>Cordial   Saludo,</p>
      <p>&nbsp;</p>
      <p align="justify">HOCOL S.A.   agradece su participaci&oacute;n en la invitaci&oacute;n de la referencia.  Le informamos que   de acuerdo con los an&aacute;lisis de las propuestas recibidas se decidi&oacute; adjudicarle   el pedido a otra compa&ntilde;&iacute;a. </p>
      <p align="justify">&nbsp;</p>
      <p align="justify">Esperamos   seguir contando con su inter&eacute;s para futuros procesos. </p></td>
			  </tr>
			</table><br>';



			}//IMPRIME BUSCA NO ADJUDICADOS

}//si exiten no adjudicados			


	  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];
			
	
			  	$busca_provee_noad = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 4 and notificado <> 3  order by razon_social "));
						if($busca_provee_noad[0]>=1){//si exiten OTROS ESTADO
						
				$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
								pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 4 and notificado <> 3  order by razon_social ");
								while($lp = traer_fila_row($busca_provee)){//BUSCA CARTAS
								$icono_enviado="";		
				$cambia_estado_carta = traer_fila_row(query_db("select fecha_envio from $t46 where pro30_id =  $lp[0] "));
				$busca_proveedor = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $lp[1]"));
												
								
							$text.='<table width="100%" border="1" cellpadding="2" cellspacing="2" >';
							$text.=' <tr>
											<td style="font-size:25px;"><p>Bogot&aacute;,'.fecha_for_sin_hora($cambia_estado_carta[0]).'
								</p>
									<p>&nbsp;</p>
								  <p>Se&ntilde;ores<br>
										<strong>
										  '.htmlentities($busca_proveedor[0]).'
									  </strong></p>
								  <p>&nbsp;</p>
								  <p><strong>REFERENCIA:   NO ADJUDICACION | CONSECUTIVO '.$linvi[22].'
									</strong></p>
								  <p>&nbsp;</p>
								  <p>Cordial   Saludo,</p>
								  <p>&nbsp;</p>
								  <p align="justify">HOCOL S.A.   agradece su participaci&oacute;n en la invitaci&oacute;n de la referencia.  Le informamos que se decidi&oacute; que el proceso en referencia se diera como '.htmlentities(listas_sin_select($tp1,$linvi[1],1)).'</p>
								  <p align="justify">&nbsp;</p>
								  <p align="justify">Esperamos   seguir contando con su inter&eacute;s para futuros procesos. </p></td>
										  </tr>
										</table><br>';								
								
								}//BUSCA CARTAS
						
						}	


$texto=$text;
$titulo = "Acta de  ".listas_sin_select($tp1,$linvi[1],1);
$consecutivo_proceso=$linvi[22];
$fecha_hora_generacion=htmlentities("Fecha del Acta: ").fecha_for_hora($fecha." ".$hora);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($sql_e[1]);
$pdf->SetTitle('Solicitud de Oferta de Servicios');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData("logo_cliente_email.png", PDF_HEADER_LOGO_WIDTH, $titulo, "consecutivo: ".$consecutivo_proceso." \n".$fecha_hora_generacion);
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
