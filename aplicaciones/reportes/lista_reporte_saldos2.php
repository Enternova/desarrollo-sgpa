<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	

	
$sel_contratos_que_viene = traer_fila_row(query_db("select consecutivo,creacion_sistema,apellido from $co1 where id = ".$_GET["id_contrato"]." "));

$contratos_que_viene=numero_item_pecc_contrato_antes_formato("C",$sel_contratos_que_viene[1],$sel_contratos_que_viene[0],$sel_contratos_que_viene[2], $_GET["id_contrato"]);

		
	$sel_item= traer_fila_row(query_db("select id_item from t7_contratos_contrato where id=".$_GET["id_contrato"]));
		
	$id_solicitud=$sel_item[0];
	
	$delete = query_db("delete from t2_reporte_marco_temporal where id_us=".$_SESSION["id_us_session"]);
	
	
	/*Inicial*/
	$numero_solicitud="";
	
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3 from vista_reporte_saldos_marco_2_crea_inicial where id_item = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3";
	

	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la creacion de los contratos pero sin los contratos
		$contratos="";
		$contratista="";
		if($numero_solicitud==""){//como es un solo numero se llena la variable una ves para no cargar el sistema
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		}

		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from vista_reporte_saldos_marco_2_crea_inicial where id_item = $id_solicitud group by consecutivo, creacion_sistema, apellido, contratista");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos creados en la creacion
		
		
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4])){
				$num_contra_while="<font color=blue>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4]);
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
		
		
		
		$insert = query_db("insert into t2_reporte_marco_temporal (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'inicial', $id_solicitud, '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		
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

		
	
		
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista from vista_reporte_saldos_marco_3_ampliaciones where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
		
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2])){
				$num_contra_while="<font color=#0000FF>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2]);
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
		
		
		
		$insert = query_db("insert into t2_reporte_marco_temporal (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'ampliacion', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		
		}
	
	
	/*Ampliaciones*/
	
	
	/*OTS*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica from vista_reporte_saldos_marco_4_ots where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica";
	
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";

		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);

		
	
		
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista from vista_reporte_saldos_marco_4_ots where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista");
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
				if($contratos==""){
				$contratos.=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2]);
				$contratista.=substr($s_contras[3], 0, 47);
				}else{
					$contratos.=",<br />".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2]);
					$contratista.=",<br />".substr($s_contras[3],0,47);
					}
		}
		
		
		
		$insert = query_db("insert into t2_reporte_marco_temporal (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista,id_item_ots_aplica) values (".$_SESSION["id_us_session"].", 'ots', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."','".$v_ini[10]."')");
		
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
  <td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  
  <table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  
  <?
  
  $cuantos_solicitudes="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_cuantos=query_db($cuantos_solicitudes);
  $cuantos =0;
  while($sel_temp = traer_fila_db($sel_cuantos)){
	   $cuantos =$cuantos+1;
  }
  
  $sel_temporal_sql="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	
	  if($sel_temp[1]=="inicial"){	  
	  $titulo = "SOLICITUD INICIAL - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD INICIAL - ".$sel_temp[0]."</strong>";
	  }
	  if($sel_temp[1]=="ampliacion"){	  
	  $titulo = "SOLICITUD DE AMPLIACION - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD DE AMPLIACION - ".$sel_temp[0]."</strong>";
	  }
	  
	 $cuanta_cuantos_registros=traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]));
	 
	 
	 $convina_rowspan_columna_1=$cuanta_cuantos_registros[0];////la columna donde estan los numeros de la solucitud
  
  ?>
  <tr class="" id="fila_2-<?=$consecutivo?>" >
    <td colspan="10" align="left" class="estilo_reporte_fondo_titulo_soli"> <strong onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos.php?id_contrato=<?=$_GET["id_contrato"]?>&id_solicitud=<?=$sel_temp[2]?>','carga_detalle_marcos')">&raquo;&raquo; <?=$titulo?> </strong></td>
    </tr>
    <?
      }//fin while principal temporal
	?>
    
  </table></td>
</tr>


</table>


<div id="carga_detalle_marcos"></div>

</body>
</html>
