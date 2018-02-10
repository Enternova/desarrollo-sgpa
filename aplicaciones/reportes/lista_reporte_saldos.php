<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	

	
	$delete = query_db("delete from t2_reporte_marco_temporal where id_us=".$_SESSION["id_us_session"]);
	$delete = query_db("delete from t2_reporte_marco_temporal_menos_reclasificaciones where id_us=".$_SESSION["id_us_session"]);


	llena_tabla_temporal_reporte_marco("saldos", $_GET["id_contrato"]);
	
	$saber_si_tiene_reclasificaciones = traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 12 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo in ('ots') "));


/*resta de las reclasificaciones*/	
	if($saber_si_tiene_reclasificaciones[0]>0){//crea registros para descontar las reclasificaciones.
		$consulta_tabla_reporte_suman_valor = query_db("select id_us, tipo, id_item, CAST(contratos AS TEXT), ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, contratista, id_item_ots_aplica from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'");
		while($c_t_r_s = traer_fila_db($consulta_tabla_reporte_suman_valor)){			
			$trm = trm_presupuestal($c_t_r_s[4]);		
			
			$saldo_equ_usd=$c_t_r_s[6] + ($c_t_r_s[7]/$trm);
			$saldo_equ_cop=$c_t_r_s[7] + ($c_t_r_s[6]*$trm);
			
			$contrato = str_replace("<div class=filas_resultados_reporte_saldos1>","",$c_t_r_s[3]);
			$contrato = str_replace("</div>","",$contrato);
			$contrato = str_replace("<font color=blue>","",$contrato);
			$contrato = str_replace("</font>","",$contrato);
			$contrato = str_replace("<font color=#0000FF>","",$contrato);
			$contrato = str_replace("<span >","",$contrato);
			$contrato = str_replace("</span>","",$contrato);
			$contrato = str_replace(" ","",$contrato);
			
			
			$saldo_equ_usd=number_format($c_t_r_s[6] + ($c_t_r_s[7]/$trm),0,"","");
			$saldo_equ_cop=number_format($c_t_r_s[7] + ($c_t_r_s[6]*$trm),0,"","");
			
			
				$insert_tabla_para_descontar = query_db("insert into t2_reporte_marco_temporal_menos_reclasificaciones (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, contratista, id_item_ots_aplica, saldo_eq_usd, saldo_eq_cop) values ('".$c_t_r_s[0]."', '".$c_t_r_s[1]."', '".$c_t_r_s[2]."', '".$contrato."', '".$c_t_r_s[4]."', '".$c_t_r_s[5]."', 0, 0, '".$c_t_r_s[8]."', '".$c_t_r_s[9]."', '".$c_t_r_s[10]."', '".$c_t_r_s[11]."', '".$c_t_r_s[12]."', '".$saldo_equ_usd."', '".$saldo_equ_cop."')");
			}
			
			$sql_descuenta_reclasificaciones = "select  t1.ano, t1.id_campo, CAST(contratos as TEXT), sum(t1.saldo_eq_usd), sum(t1.saldo_eq_cop) from t2_reporte_marco_temporal_menos_reclasificaciones as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 12 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo in ('ots') and t2.estado >= 20 and t2.estado <=32 and t2.estado <> 31 group by t1.ano, t1.id_campo, contratos";
			 
						 
			 
     $sql_descuenta = query_db($sql_descuenta_reclasificaciones);
	 		while($descuenta = traer_fila_db($sql_descuenta)){
				$trm = trm_presupuestal($descuenta[0]);
				$valor_por_descontar_eq_usd = $descuenta[3];
				$valor_por_descontar_eq_cop = $descuenta[4];
				
				
				
					$sql_ampli_inicial = query_db("select id_us, tipo, id_item, contratos, ano, campo, saldo_eq_usd, saldo_eq_cop, id_campo, t2_presupuesto_id, num_item, contratista, id_item_ots_aplica from t2_reporte_marco_temporal_menos_reclasificaciones where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial','ampliacion', 'reclasificacion') and ano=".$descuenta[0]." and id_campo=".$descuenta[1]." and contratos like '%".$descuenta[2]."%' order by id_item");
					while($c_t_r_s = traer_fila_db($sql_ampli_inicial)){
							$nuevo_valor_ampli_eq_usd=0;
							$nuevo_valor_ampli_eq_cop=0;
							
						if($c_t_r_s[6]>=$valor_por_descontar_eq_usd){//descuenta completo de la ampliacion o de la solicitud inicial
							$nuevo_valor_ampli_eq_usd=$c_t_r_s[6]-$valor_por_descontar_eq_usd;
							$nuevo_valor_ampli_eq_cop=$c_t_r_s[7]-$valor_por_descontar_eq_cop;
							
							$update = query_db("update t2_reporte_marco_temporal_menos_reclasificaciones set saldo_eq_usd='".$nuevo_valor_ampli_eq_usd."', saldo_eq_cop=".$nuevo_valor_ampli_eq_cop." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$c_t_r_s[2]." and t2_presupuesto_id = ".$c_t_r_s[9]." and ano=".$c_t_r_s[4]." and id_campo=".$c_t_r_s[8]." and contratos like '%".$c_t_r_s[3]."%'");
							$valor_por_descontar_eq_usd = 0;
							$valor_por_descontar_eq_cop = 0;
							}else{// descuenta parcial de la ampliacion o de la solicitud inicial
							$nuevo_valor_ampli_eq_usd=0;
							$nuevo_valor_ampli_eq_cop=0;
							
							$update = query_db("update t2_reporte_marco_temporal_menos_reclasificaciones set saldo_eq_usd='".$nuevo_valor_ampli_eq_usd."', saldo_eq_cop=".$nuevo_valor_ampli_eq_cop." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$c_t_r_s[2]." and t2_presupuesto_id = ".$c_t_r_s[9]." and ano=".$c_t_r_s[4]." and  id_campo=".$c_t_r_s[8]." and contratos like '%".$c_t_r_s[3]."%'");
							$valor_por_descontar_eq_usd = $valor_por_descontar_eq_usd-$c_t_r_s[6];
							$valor_por_descontar_eq_cop = $valor_por_descontar_eq_cop-$c_t_r_s[7];
								
								}
						
					}
					
				}
		}
	/*FIN resta de las reclasificaciones*/
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

<body>


  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr>
  <td width="93%" align="center">&nbsp;</td>
  <td width="7%" align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"' /></td>
</tr>
<tr>
  <td colspan="2" align="center"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr class="fondo_3">
      <td width="21%" align="center"><strong>Tipo</strong></td>
      <td width="9%" align="center"><strong>N&uacute;mero</strong></td>
      <td width="14%" align="center"><strong>Estado</strong></td>
      <td width="10%" align="center"><strong>Es de Carga Masiva</strong></td>
      <td width="10%" align="center"><strong>Fecha de Creaci&oacute;n</strong></td>
      <td width="13%" align="center"><strong>Ver en Equivalentes USD</strong></td>
      <td width="14%" align="center"><strong>Ver en Equivalentes COP</strong></td>
      <td width="9%" align="center"><strong>Ver Solicitud</strong></td>
      </tr>
      <?
  
  $cuantos_solicitudes="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_cuantos=query_db($cuantos_solicitudes);
  $cuantos =0;
  while($sel_temp = traer_fila_db($sel_cuantos)){
	   $cuantos =$cuantos+1;
  }
  
  $sel_temporal_sql="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion', 'otros') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico, estado, solicitud_rechazada, fecha_creacion, t1_tipo_proceso_id from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  $estado= traer_fila_row(query_db("select nombre from t2_nivel_servicio_actividades where t2_nivel_servicio_actividad_id = ".$sel_item_masivo[1]));
	  
	  
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	 
	
	 
		 
	  
	 $cuanta_cuantos_registros=traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]));
	 
	 
	 $convina_rowspan_columna_1=$cuanta_cuantos_registros[0];////la columna donde estan los numeros de la solucitud

	if($cont_estilo != 1){
	$classe = "filas_resultados";
	$cont_estilo = 1;
	}else{
		$classe = "";
		$cont_estilo = 2;
		}
		$permiso_o_adjudica=2;
  ?>
    <tr class="<?=$classe?>">
      <td><? if($sel_temp[1]=="ampliacion") echo "Solicitud de Ampliaci&oacute;n"; if($sel_temp[1]=="inicial"){ echo "Solicitud Inicial";  $id_item_pecc=$sel_temp[2];} if($sel_temp[1]=="reclasificacion"){ echo "Solicitud de Reclasificaci&oacute;n"; $permiso_o_adjudica=1;} if($sel_temp[1]=="otros"){ echo saca_nombre_lista($g13,$sel_item_masivo[4],'nombre','t1_tipo_proceso_id',$sel_temp[2]);; $permiso_o_adjudica=1;}?></td>
      <td align="center"><?=$sel_temp[0]?></td>
      <td align="center"><? if($sel_item_masivo[2]==1){$estado[0] = "Finalizado - Rechazado";} else echo $estado[0];?></td>
      <td align="center"><?  if($sel_item_masivo[0] == "si") echo "SI"; else echo "NO";?></td>
      <td align="center"><?=$sel_item_masivo[3]?></td>
      <td align="center"><? if($sel_temp[1]!="otros"){?><strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos.php?id_contrato=<?=$_GET["id_contrato"]?>&id_solicitud=<?=$sel_temp[2]?>&eq_moneda=1','carga_detalle_marcos')">Ver Reporte en USD$</strong><? } ?></td>
      <td align="center"><? if($sel_temp[1]!="otros"){?><strong  style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos.php?id_contrato=<?=$_GET["id_contrato"]?>&id_solicitud=<?=$sel_temp[2]?>&eq_moneda=2','carga_detalle_marcos')">Ver Reporte en COP$</strong> <? } ?></td>
      <td align="center"><img src="../imagenes/botones/detalle.png" width="20" height="20" onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sel_temp[2]?>&permiso_o_adjudica=<?=$permiso_o_adjudica?>')" class="titulo_calendario_real_bien" style="cursor:pointer" /></td>
    </tr>
    <?
      }//fin while principal temporal
	?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr class="fondo_3" height="1">
      <td colspan="8"></td>
      </tr>
    <tr class="filas_resultados">
      <td>Valor Total de las Aprobaciones</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">
      <strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/valor_total_ampliaciones.php?eq_moneda=1','carga_detalle_marcos')">Ver Reporte en USD$</strong></td>
      <td align="center"><strong  style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/valor_total_ampliaciones.php?eq_moneda=2','carga_detalle_marcos')">Ver Reporte en COP$</strong></td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Valor Total de las OTs y OPs Creadas</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/valor_total_ots.php?eq_moneda=1','carga_detalle_marcos')">Ver Reporte en USD$</strong></td>
      <td align="center"><strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/valor_total_ots.php?eq_moneda=2','carga_detalle_marcos')">Ver Reporte en COP$</strong></td>
      <td>&nbsp;</td>
      </tr>
    <tr  class="filas_resultados">
      <td>Saldo del Contrato para Crear Ots</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc_para_reporte=<?=$id_item_pecc?>&eq_moneda=1','carga_detalle_marcos')">Ver Reporte en USD$</strong></td>
      <td align="center"><strong  style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc_para_reporte=<?=$id_item_pecc?>&eq_moneda=2','carga_detalle_marcos')">Ver Reporte en COP$</strong></td>
      <td>&nbsp;</td>
      </tr>
  </table></td>
</tr>
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr> <?
 /*
 ?> 
<tr>
  <td colspan="2" align="center">
  

  <table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  
  <?
  
  $cuantos_solicitudes="select num_item,tipo,id_item from ".$tabla_temporal." where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_cuantos=query_db($cuantos_solicitudes);
  $cuantos =0;
  while($sel_temp = traer_fila_db($sel_cuantos)){
	   $cuantos =$cuantos+1;
  }
  
  $sel_temporal_sql="select num_item,tipo,id_item from ".$tabla_temporal." where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico, estado, solicitud_rechazada from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  $estado= traer_fila_row(query_db("select nombre from t2_nivel_servicio_actividades where t2_nivel_servicio_actividad_id = ".$sel_item_masivo[1]));
	  
	  if($sel_item_masivo[2]==1){
		  $estado[0] = "Finalizado - Rechazado";
		  }
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	 
	
	 
	  if($sel_temp[1]=="inicial"){	  
	  $titulo = "SOLICITUD INICIAL - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD INICIAL - ".$sel_temp[0]."</strong>";
	   $id_item_pecc=$sel_temp[2];
	   
	  }
	  if($sel_temp[1]=="ampliacion"){	  
	  $titulo = "SOLICITUD DE AMPLIACION - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD DE AMPLIACION - ".$sel_temp[0]."</strong>";
	  }
	  
	  
	  if($sel_item_masivo[0] == "si"){
		   $titulo.= " Cargue Masivo ";
	 	   $titulo2.= " Cargue Masivo ";
		  }
	  
	 $cuanta_cuantos_registros=traer_fila_row(query_db("select count(*) from ".$tabla_temporal." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]));
	 
	 
	 $convina_rowspan_columna_1=$cuanta_cuantos_registros[0];////la columna donde estan los numeros de la solucitud

  ?>
  <tr class="" id="fila_2-<?=$consecutivo?>" >
    <td colspan="10" align="left" class="estilo_reporte_fondo_titulo_soli"> <strong onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos.php?id_contrato=<?=$_GET["id_contrato"]?>&id_solicitud=<?=$sel_temp[2]?>','carga_detalle_marcos')">&raquo;&raquo; <?=$titulo?> - Estado: <?=$estado[0]?></strong></td>
    </tr>
    <?
      }//fin while principal temporal
	?>
    <tr class="" >
      <td colspan="10" align="left" class="estilo_reporte_fondo_titulo_soli"><strong onclick="ajax_carga('../aplicaciones/reportes/valor_total_ampliaciones.php','carga_detalle_marcos')">&raquo;&raquo; Valor total de todas las ampliaciones </strong></td>
    </tr>
    <tr class="" id="fila_2-<?=$consecutivo?>" >
    <td colspan="10" align="left" class="estilo_reporte_fondo_titulo_soli"> <strong onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc=<?=$id_item_pecc?>','carga_detalle_marcos')">&raquo;&raquo; SALDO REAL DE LOS CONTRATOS </strong></td>
    </tr>
  </table></td>
</tr>

<?
*/
?>
</table>


<div id="carga_detalle_marcos"></div>

</body>
</html>
