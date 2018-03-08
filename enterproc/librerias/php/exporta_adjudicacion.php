<?  

function elimina_comillas_2_prueba($valor){
	

		//$id_subastas_arrglo = str_replace( "ó", "renes", $id_subastas_arrglo ); 
	
$i= addslashes($valor);
$codificado = utf8_encode($i);


		return $codificado;
}
?>

<style>
body {
	color:#fff;
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
	font-size:8px;
	

}
.tabla_lista_resultados{
	font-size:12px;
	width:100%;
 margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;	
	}
.titulos_tabla{
 text-align:center; background:#9FC2FD;
	}

.resultados_lista_g{
 	background:#CCCCCC;
	font-size:10px;
	
	}	

.resultados_lista_b{
 	background:#FFFFF;
	font-size:10px;
	
	}		
	
</style>

<?
$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));


//$buscar_datos_ap = traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion"));
//$busca_us_sox = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[2]"));
//$busca_us_comprador = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[3]"));


$text.='
<table width="90%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td style="font-size:40px; border-bottom-color:#C7422F 2px;"><strong>Informaci&oacute;n General del Proceso</strong></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Consecutivo del proceso:</strong>'.htmlentities($linvi[22]).'</div></td>
  </tr>
  <tr>
    <td ><strong>Estado del proceso:</strong>'.fecha_for_hora($linvi[17]).'</td>
  </tr>
  <tr>
    <td><div align="left"><strong>'.$lenguaje_0.':</strong>'.htmlentities($linvi[12]).'</div></td>
  </tr>
</table>


<br>';

	$busca_provee_ad = traer_fila_row(query_db("select count(*) from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social "));
	if($busca_provee_ad[0]>=1){//si exiten adjudicados

           

$text.='
<table><tr><td><strong>Proveedores adjudicados</strong></td></tr></table>

<table class="tabla_lista_resultados">
  <tr class="titulos_tabla">
    <td style="width: 42%;"><strong>Proveedor </strong>  </td>
    <td  style="width: 20%;"><strong>Fecha env&iacute;o</strong></td>
    <td  style="width: 20%;"><strong>Visualizaci&oacute;n</strong></td>
<td  style="width: 18%;"><strong>Aceptaci&oacute;n</strong></td>	
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
							$class=" resultados_lista_g";
						else
							$class=" resultados_lista_b";				
  
  $text.='<tr class="'.$class.'">
    <td>'.htmlentities($lp[3]).'</td>
    <td style="text-align:center">'.fecha_for_hora($lp[10]).'</td>
    <td style="text-align:center">'.fecha_for_hora($visualizacion[0]).'</td>
	<td style="text-align:center">'.$estado_acep.'</td>	
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


$text.='
<table><tr><td><strong>Proveedores NO adjudicados y con env&iacute;o de notificaci&oacute;n</strong></td></tr></table>

<table class="tabla_lista_resultados">
  <tr class="titulos_tabla">
    <td style="width: 30%;" ><strong>Nombre proveedor</strong></td>
    <td style="width: 30%;" ><strong>Comentarios</strong></td>
    <td style="width: 20%;" ><strong>Fecha env&iacute;o</strong></td>
    <td style="width: 20%;" ><strong>Visualizaci&oacute;n</strong></td>
  </tr>';

			
			$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

 			if($num_fila%2==0)
									$class=" resultados_lista_g";
						else
							$class=" resultados_lista_b";	
			  
    $text.='<tr class="'.$class.'">
    <td style="width: 30px;"  >'.htmlentities($lp[2]).'</td>
    <td >'.htmlentities($lp[4]).'</td>
    <td style="text-align:center">'.fecha_for_hora($lp[3]).'</td>
    <td style="text-align:center">'.fecha_for_hora($visualizacion[0]).'</td>
  </tr>';
   $num_fila++;} 
$text.='</table><br>';


} //si exiten no adjudicados	

$busca_provee_noad_sin_en = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado = 3  order by razon_social "));
				
if($busca_provee_noad_sin_en[0]>=1){//si no exiten sin envios	

$text.='<table width="90%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_subtitulo_resultados"><strong>Proveedores NO adjudicados y sin env&iacute;o de notificaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="30%" align="center" bgcolor="#9FC2FD" style="font-size:12px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Nombre proveedor</strong></td>
    <td width="70%" align="center" bgcolor="#9FC2FD" style="font-size:12px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="left"><strong>Comentarios</strong></div></td>
  </tr>';


			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado = 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

    $text.='<tr>
    <td '.$class.' style="font-size:11px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[2]).'</td>
    <td '.$class.' style="font-size:11px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[4]).'</td>
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
    <td width="30%" align="center" bgcolor="#9FC2FD" style="font-size:12px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Nombre proveedor</strong></td>
    <td width="30%"align="center" bgcolor="#9FC2FD" style="font-size:12px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="left"><strong>Comentarios</strong></div></td>
    <td width="20%" align="center" bgcolor="#9FC2FD" style="font-size:12px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Fecha env&iacute;o</strong></td>
    <td width="20%" align="center" bgcolor="#9FC2FD" style="font-size:12px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><strong>Visualizaci&oacute;n</strong></td>

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

    <td  '.$class.'  align="center" style="font-size:11px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[2]).'</td>
    <td  '.$class.'  align="center" style="font-size:11px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lp[4]).'</td>
    <td  '.$class.'  align="center" style="font-size:11px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities(fecha_for_hora($lp[3])).'</td>
    <td  '.$class.'  align="center" style="font-size:11px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities(fecha_for_hora($visualizacion[0])).'</td>

  </tr>';
  $num_fila++;} 
$text.='</table><br>';

						

}//si exiten OTROS ESTADO			





/**************IMPRIME LAS CRTAS********************/
	$busca_provee_ad = traer_fila_row(query_db("select count(*) from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social "));
	if($busca_provee_ad[0]>=1){//si exiten adjudicados CARTA
	
	$text.='<table width="90%" border="0" cellspacing="2" cellpadding="2" >
				  <tr>
					<td width="83%" class="titulos_evaluacion">CARTA DE ADJUDICACION</td>
				  </tr>
				</table>';
	
		  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado, acepta_terminos,fecha_envio from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){//IMPORIME VUSCA AUDUJIDACOS
				
				$text.='<table width="80%" border="1" cellpadding="2" cellspacing="2" >';

$contenido_carta_adju="";
$cambia_estado_carta = traer_fila_row(query_db("select * from $t45 where pro1_id = $id_invitacion and pv_id = $lp[2] and acepta_terminos = 1")); 
$contenido_carta_adju = elimina_comillas_2_prueba($cambia_estado_carta[4]);
$text.=' <tr>
    <td style="font-size:10px;">'.strip_tags($contenido_carta_adju,'<UL><LI><tr><td><table><br><strong><style><div><spam>&Oacute;').'</td>
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
				<td style="font-size:11px;"><p>Bogot&aacute;,'.fecha_for_sin_hora($cambia_estado_carta[0]).'
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
											<td style="font-size:11px;"><p>Bogot&aacute;,'.fecha_for_sin_hora($cambia_estado_carta[0]).'
								</p>
									<p>&nbsp;</p>
								  <p>Se&ntilde;ores<br>
										<strong>
										  '.htmlentities($busca_proveedor[0]).'
									  </strong></p>
								  <p>&nbsp;</p>
								  <p><strong>REFERENCIA:   '.htmlentities(listas_sin_select($tp1,$linvi[1],1)).' | CONSECUTIVO '.$linvi[22].'
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

echo $texto;