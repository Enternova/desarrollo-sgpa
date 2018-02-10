<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
function llena_tabla_temporal_reporte_marco($tipo, $id_contrato){
	if($tipo == "Ejecucion"){
		$tabla_temporal = "t2_reporte_marco_temporal_ejecuciones_excel";
		}
	if($tipo == "saldos"){
		$tabla_temporal = "t2_reporte_marco_temporal";
		}
		
		
		
		
		
		
	}
	
	$delete = query_db("delete from t2_reporte_marco_temporal where id_us=".$_SESSION["id_us_session"]);

$sel_contratos_que_viene = traer_fila_row(query_db("select consecutivo,creacion_sistema,apellido from $co1 where id = ".$_GET["id_contrato"]." "));
$contratos_que_viene=numero_item_pecc_contrato_antes_formato("C",$sel_contratos_que_viene[1],$sel_contratos_que_viene[0],$sel_contratos_que_viene[2], $_GET["id_contrato"]);
	$sel_item= traer_fila_row(query_db("select id_item from t7_contratos_contrato where id=".$_GET["id_contrato"]));
	$id_solicitud=$sel_item[0];
	/*Inicial*/
	$numero_solicitud="";
/*selecciona vista para solicitud inicial*/
$seleccion_si_es_de_antiguos = traer_fila_row(query_db("select count(*) from vista_reporte_saldos_marco_3_crea_inicial where id_item = $id_solicitud"));
if($seleccion_si_es_de_antiguos[0]>0){
	$vista_inicial = "vista_reporte_saldos_marco_3_crea_inicial";
	}else{
		$vista_inicial = "vista_reporte_saldos_marco_2_crea_inicial";
		}
/*selecciona vista*/
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3 from ".$vista_inicial." where id_item = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3";
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la creacion de los contratos pero sin los contratos
		$contratos="";
		$contratista="";
		if($numero_solicitud==""){//como es un solo numero se llena la variable una ves para no cargar el sistema
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		}
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from ".$vista_inicial." where id_item = $id_solicitud and t2_presupuesto_id=".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos creados en la creacion
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])){
				$num_contra_while="<font color=blue>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4]);
				}
		 if($cont == 0){
		  	$clase= "class=filas_resultados_reporte_saldos1";
			$cont = 1;
		  }else{
		  	$clase= "class=filas_resultados_reporte_saldos2";
		  }
					$contratos.="<div ".$clase.">".$num_contra_while."</div>";
					$contratista.="<div ".$clase.">".substr($s_contras[3],0,47)."</div>";
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'inicial', $id_solicitud, '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		}
	/*Inicial*/
	/*Ampliaciones*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item from vista_reporte_saldos_marco_3_ampliaciones where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item";
	
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from vista_reporte_saldos_marco_3_ampliaciones where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])){
				$num_contra_while="<font color=#0000FF>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4]);
				}
				if($cont == 0){
		  	$clase= "class=filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
				if($contratos==""){
				$contratos.="<span >".$num_contra_while."</span>";
				$contratista.="<span >".$s_contras[3]."</span>";
				}else{
					$contratos.=",<br /><span >".$num_contra_while."</span>";
					$contratista.=",<br /><span >".$s_contras[3]."</span>";
					}
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'ampliacion', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		}
	/*Ampliaciones*/
	/*RECLASIFICACIONES AUMENTA VALOR*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item from vista_reporte_saldos_marco_3_ampliaciones_reclasificacion where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item";
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from vista_reporte_saldos_marco_3_ampliaciones_reclasificacion where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])){
				$num_contra_while="<font color=#0000FF>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4]);
				}
				if($cont == 0){
		  	$clase= "class=filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
				if($contratos==""){
				$contratos.="<span >".$num_contra_while."</span>";
				$contratista.="<span >".$s_contras[3]."</span>";
				}else{
					$contratos.=",<br /><span >".$num_contra_while."</span>";
					$contratista.=",<br /><span >".$s_contras[3]."</span>";
					}
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'reclasificacion', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		}
	/*RECLASIFICACIONES AUMENTA VALOR*/
	/*OTS*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica from vista_reporte_saldos_marco_4_ots where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica";
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from vista_reporte_saldos_marco_4_ots where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
				if($contratos==""){
				$contratos.=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4]);
				$contratista.=substr($s_contras[3], 0, 47);
				}else{
					$contratos.=",<br />".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4]);
					$contratista.=",<br />".substr($s_contras[3],0,47);
					}
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista,id_item_ots_aplica) values (".$_SESSION["id_us_session"].", 'ots', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."','".$v_ini[10]."')");
		}
	/*OTS*/
	
	
	
	
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
      <td width="9%" align="center"><strong>Numero</strong></td>
      <td width="14%" align="center"><strong>Estado</strong></td>
      <td width="10%" align="center"><strong>Es de Carga Masiva</strong></td>
      <td width="10%" align="center"><strong>Fecha de Creaci&oacute;n</strong></td>
      <td width="13%" align="center"><strong>Ver en Equivalentes USD</strong></td>
      <td width="14%" align="center"><strong>Ver en Equivalentes COP</strong></td>
      <td width="9%" align="center"><strong>Ver Solicitud</strong></td>
      </tr>
      <?
  
  $cuantos_solicitudes="select num_item,tipo,id_item from ".$tabla_temporal." where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_cuantos=query_db($cuantos_solicitudes);
  $cuantos =0;
  while($sel_temp = traer_fila_db($sel_cuantos)){
	   $cuantos =$cuantos+1;
  }
  
  $sel_temporal_sql="select num_item,tipo,id_item from ".$tabla_temporal." where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico, estado, solicitud_rechazada, fecha_creacion from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  $estado= traer_fila_row(query_db("select nombre from t2_nivel_servicio_actividades where t2_nivel_servicio_actividad_id = ".$sel_item_masivo[1]));
	  
	  
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	 
	
	 
		 
	  
	 $cuanta_cuantos_registros=traer_fila_row(query_db("select count(*) from ".$tabla_temporal." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]));
	 
	 
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
      <td><? if($sel_temp[1]=="ampliacion") echo "Solicitud de Ampliaci&oacute;n"; if($sel_temp[1]=="inicial"){ echo "Solicitud Inicial";  $id_item_pecc=$sel_temp[2];} if($sel_temp[1]=="reclasificacion"){ echo "Solicitud de Reclasificaci&oacute;n"; $permiso_o_adjudica=1;}?></td>
      <td align="center"><?=$sel_temp[0]?></td>
      <td align="center"><? if($sel_item_masivo[2]==1){$estado[0] = "Finalizado - Rechazado";} else echo $estado[0];?></td>
      <td align="center"><?  if($sel_item_masivo[0] == "si") echo "SI"; else echo "NO";?></td>
      <td align="center"><?=$sel_item_masivo[3]?></td>
      <td align="center"><strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos.php?id_contrato=<?=$_GET["id_contrato"]?>&id_solicitud=<?=$sel_temp[2]?>&eq_moneda=1','carga_detalle_marcos')">Ver Reporte en USD$</strong></td>
      <td align="center"><strong  style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos.php?id_contrato=<?=$_GET["id_contrato"]?>&id_solicitud=<?=$sel_temp[2]?>&eq_moneda=2','carga_detalle_marcos')">Ver Reporte en COP$</strong></td>
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
      <td align="center"><strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc=<?=$id_item_pecc?>&eq_moneda=1','carga_detalle_marcos')">Ver Reporte en USD$</strong></td>
      <td align="center"><strong  style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc=<?=$id_item_pecc?>&eq_moneda=2','carga_detalle_marcos')">Ver Reporte en COP$</strong></td>
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
