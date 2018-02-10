<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	

	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_item_pecc_marco =$sel_item[26];
	$sel_item_marco = traer_fila_row(query_db("select * from $pi2 where id_item='".$id_item_pecc_marco."'"));
	$id_tipo_proceso_pecc = $sel_item[20];
	
	
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));



if($sel_item[17]==""){
$trm_actual=trm_presupuestal(2015);	
	}else{
$trm_actual=trm_presupuestal($sel_item[17]);
	}
	
	$sel_pecc[0] = $trm_actual;
	
	
		
	$edicion_datos_generales = "NO";
	if(verifica_permiso_pecc($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
		
	
		$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
		
		if($sel_usu_emulan[0]>0 and ($sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
		
		
		if($sel_item[6]== 8){
			$id_tipo_proceso_pecc=3;
			}
		if($sel_item[6]== 7){
			$id_tipo_proceso_pecc=2;
			}

$t1_tipo_proceso_id = $sel_item[6];


 //si es nanky
 if((esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==7) or (esprofesionalcompras($id_item_pecc)=="SI" and $id_tipo_proceso_pecc == 3 and $sel_item[14]==16) or (esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[6]==11 and $sel_item[14]==16 )){
	 $edicion_datos_generales = "SI";
	 }
	
	
	/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
if($sel_item[6]==16 and ($sel_item[14] < 16) and $sel_item[23] == $_SESSION["id_us_session"]){
	$edicion_datos_generales = "SI";	
	}
/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
		
	?>
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top">
    
    <?
    /*-------------------------------------*/
	
	if(($sel_item[6]==4 or $sel_item[6]==5 or $sel_item[6]==13 or $sel_item[6]==14) and $sel_item[21]>0 and $edicion_datos_generales == "SI"){
		
		
			
				$id_contrato_carr = $sel_item[21];

				?>
                
				
                <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="3" align="center"  class="fondo_3">Valor Inicial del Contrato</td>
        </tr>
      <tr>
    
        <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="24%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
        <td width="19%" align="center" class="fondo_3">Valor Equivalente USD$</td>
        </tr>
      <?
	  $sele_presupuesto = query_db("select ano, nombre_campo,eq_usd from $vpeec19 where id_contrato =".$id_contrato_carr);
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[2];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
      <tr class="<?=$clase?>">
       
        <td align="center"><?=$sel_presu[0]?></td>
        <td align="center"><?=$sel_presu[1]?></td>
        <td align="center" ><?=number_format($sel_presu[2],0)?></td>
        </tr><?
			}
			$total_equivale_usd = $total_equivale_usd +$valor_total_usd ;
		?>
      <tr>
        <td colspan="2" align="left"><img src="../imagenes/botones/aviso_observaciones.png" alt="" width="16" height="16" /><strong>ATENCION: </strong><span class="titulos_resumen_alertas">El valor actual del contrato se sumara a esta solicitud para generar el camino que debe tomar en cuanto a firmas en el sistema, firma del comit&eacute; interno y firma de los socios entre otros.	</span></td>
        <td align="center" class="titulos_resumen_alertas"><?=number_format($total_equivale_usd)?></td>
        </tr>
      
    </table>
    <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="3" align="center"  class="fondo_3">Valor de los Otro Si</td>
        </tr>
      <tr>
    
        <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="24%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
        <td width="19%" align="center" class="fondo_3">Valor Equivalente USD$</td>
        </tr>
      <?
	  $sele_presupuesto = query_db("select ano, nombre_campo,eq_usd from $vpeec24 where id_contrato =".$id_contrato_carr);
	$valor_total_usd = 0;
	$valor_total_cop = 0;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[2];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
      <tr class="<?=$clase?>">
       
        <td align="center"><?=$sel_presu[0]?></td>
        <td align="center"><?=$sel_presu[1]?></td>
        <td align="center" ><?=number_format($sel_presu[2],0)?></td>
        </tr><?
			}
			$total_equivale_usd = $total_equivale_usd +$valor_total_usd ;
		?>
      <tr>
        <td colspan="2" align="left">&nbsp;</td>
        <td align="center" class="titulos_resumen_alertas"><?=number_format($total_equivale_usd)?></td>
        </tr>
      
    </table>
                
                
				<?

		
		
		}
	
	/*-----------------------------------*/
	?>
    
    <?
    
	if(($sel_item[6]== 8 or $sel_item[6]== 7) and $sel_item[26] == 0 and $edicion_datos_generales == "SI"){
		
		
	?><table width="99%" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td width="15%" align="right">Numero de la Solicitud:</td>
  <td width="8%"><select name="numero1_pecc" id="numero1_pecc">
    <?				
                	$sele_numero1=query_db("select num1 from $vpeec4 where t1_tipo_documento_id = 2 group by num1 order by num1");
					while($sel_num = traer_fila_db($sele_numero1)){
				?>
    <option value="<?=$sel_num[0]?>">
      <?=$sel_num[0]?>
      </option>
    <?
					}
				?>
  </select></td>
  <td width="9%"><select name="numero2_pecc" id="numero2_pecc">
    <?				
                	$sele_numero1=query_db("select num2 from $vpeec4 where t1_tipo_documento_id = 2 group by num2 order by num2");
					while($sel_num = traer_fila_db($sele_numero1)){
				?>
    <option value="<?=$sel_num[0]?>">
      <?=$sel_num[0]?>
      </option>
    <?
					}
				?>
  </select></td>
  <td width="10%"><input name="numero3_pecc" type="text" id="numero3_pecc" maxlength="4" /></td>
  <td width="58%" rowspan="9" align="right"><table width="99%" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="31%" align="right">Alcance:</td>
      <td width="69%"><textarea name="bus_text1" id="bus_text1" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Justificaci&oacute;n:</td>
      <td><textarea name="bus_text2" id="bus_text2" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Recomendaci&oacute;n:</td>
      <td><textarea name="bus_text3" id="bus_text3" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Objeto del Contrato:</td>
      <td><textarea name="bus_text4" id="bus_text4" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Objeto de la Solicitud:</td>
      <td><textarea name="bus_text5" id="bus_text5" cols="25" rows="2"></textarea></td>
      </tr>
  </table></td>
  </tr>
<tr>
  <td align="right">Numero de Contrato:</td>
  <td align="center">C</td>
  <td><select name="n_contrato_ano" id="n_contrato_ano">
    <option value="">Todos</option>
  
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
  </select></td>
  <td><input name="n_contrato" type="text" id="n_contrato" maxlength="4" /></td>
  </tr>
<tr>
  <td align="right">&Aacute;rea Usuaria:</td>
  <td colspan="3"><select name="bus_area" id="bus_area">
    <?=listas($g12, " estado = 1",0 ,'nombre', 1);?>
  </select></td>
  </tr>
<tr>
  <td align="right">Contratista:</td>
  <td colspan="3"><input name="contra_busca" id="contra_busca" /></td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td colspan="5" align="center"><input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=busqueda_compras_en_edicion&id_pecc=<?=$id_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&numero1_pecc='+document.principal.numero1_pecc.value+'&numero2_pecc='+document.principal.numero2_pecc.value+'&numero3_pecc='+document.principal.numero3_pecc.value+'&n_contrato='+document.principal.n_contrato.value+'&n_contrato_ano='+document.principal.n_contrato_ano.value+'&bus_area='+document.principal.bus_area.value+'&bus_text1='+document.principal.bus_text1.value+'&bus_text2='+document.principal.bus_text2.value+'&bus_text3='+document.principal.bus_text3.value+'&bus_text4='+document.principal.bus_text4.value+'&bus_text5='+document.principal.bus_text5.value+'&contra_busca='+document.principal.contra_busca.value,'carga_lista_contratos_marco')" /></td>
</tr>
<tr>
  <td colspan="5" align="center"><div id="carga_lista_contratos_marco"></div></td>
</tr>

</table><?
	
		}else{
		//si es con solicitudes, OT o Ampliacion y no tienen solicitud relacionada
    $id_item_aplica_contrato_marco = $id_item_pecc_marco;
	//si es orden de trabajo o ampliacion
	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
	?>
    <table width="100%" border="0"><tr><td>
    <?
    if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
    <input type="button" name="" id="" value="Desvincular esta Solcitud de Contratos Marco" onclick="quita_solicitud_de_la_relacion()" />
    <?
    }
    ?>
	
    </td></tr></table>
    <?
    if( ($sel_item[14] == 6 or $sel_item[14] == 31 ) and $edicion_datos_generales == "SI"){
    ?>
    
    <table width="100%" border="0" class="tabla_lista_resultados">
  
  <tr >
    <td width="17%" rowspan="2" align="center" class="fondo_3">Numero del Contrato Marco</td>
    <td width="12%" rowspan="2" align="center" class="fondo_3">Contratista</td>
    <td width="12%" rowspan="2" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    <td width="12%" rowspan="2" align="center" class="fondo_3">A&ntilde;o</td>
    <td align="center" class="fondo_3">Valor Disponible Especifico</td>
    <td align="center" class="fondo_3">Valor Disponible Compartido</td>
    </tr>
  <tr >
    <td width="12%" align="center" class="fondo_3">Valor Equivalente USD$</td>
    <td width="18%" align="center" class="fondo_3">Valor Equivalente USD$</td>
    </tr>
    
    <?
	$cont = 0;

	
	$delete = query_db("delete from t2_marco_temporal where id_usuario = ".$_SESSION["id_us_session"]." and id_item = ".$id_item_aplica_contrato_marco);
	
	$sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio where id_item =".$id_item_aplica_contrato_marco." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
	
	while($sel_inio = traer_fila_db($sel_valor_inicial)){
			$eq = $sel_inio[0] + ($sel_inio[1] / trm_presupuestal($sel_inio[3]));
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_aplica_contrato_marco, ".$sel_inio[5].", ".$sel_inio[3].", ".$sel_inio[4].", ".$sel_inio[0].", ".$sel_inio[1].", $eq, 'NO', ".$sel_inio[6]." )");
			
		}
	
	
	$ampliacion = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_aplica_contrato_marco." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
		  
		  while($sel_ampl = traer_fila_db($ampliacion)){
			  $eq = $sel_ampl[0] + ($sel_ampl[1] / trm_presupuestal($sel_ampl[3]));
			  $valor_usd_queda_si = 0;
			$valor_cop_queda_si = 0;
			$valor_eq_queda_si =  0;
						
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
						//verifica si ya hay linea en temporal
						$sql_comple = "where id_item =".$id_item_aplica_contrato_marco." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
						$sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));
						/*if($sel_temp[0] > 0){//si hay lineas iguales sumar valor
								$valor_usd_upda =$sel_ampl[0]+$sel_temp[6];
								$valor_cop_upda =$sel_ampl[1]+$sel_temp[7];
								$eq_upda = $valor_usd_upda + ($valor_cop_upda / $sel_ampl[2]);
								$updat_valor = query_db("update t2_marco_temporal set valor_usd = ".$valor_usd_upda." , valor_cop = ".$valor_cop_upda.", eq_usd = ".$eq_upda." $sql_comple");
							}else{*/
						//	echo "insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )<br />";
							
								$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_aplica_contrato_marco, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
								//}
						//fin verifica si ya hay linea en temporal
						
					}else{// ampliaciones presupuesto especifico o no compartido	
					$sql_comple = "where id_item =".$id_item_aplica_contrato_marco." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";
					
					$sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
					if($sele_si_ya_tiene_especifico > 0){
						$valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
						$valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
						$valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];
						
						$udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
						}else{
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_aplica_contrato_marco, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
					}
			
						}
			  }
	
	/*-------------------------AMPLIACIONES QUE ESTAN EN ESTADO SOCIOS --------------------*/
	
	$ampliacion_en_socios = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_en_socios where id_item_peec_aplica =".$id_item_aplica_contrato_marco." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
		  
		  while($sel_ampl = traer_fila_db($ampliacion_en_socios)){
			  $eq = $sel_ampl[0] + ($sel_ampl[1] / trm_presupuestal($sel_ampl[3]));
			  $valor_usd_queda_si = 0;
			$valor_cop_queda_si = 0;
			$valor_eq_queda_si =  0;
						
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
						//verifica si ya hay linea en temporal
						$sql_comple = "where id_item =".$id_item_aplica_contrato_marco." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
						$sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));
						/*if($sel_temp[0] > 0){//si hay lineas iguales sumar valor
								$valor_usd_upda =$sel_ampl[0]+$sel_temp[6];
								$valor_cop_upda =$sel_ampl[1]+$sel_temp[7];
								$eq_upda = $valor_usd_upda + ($valor_cop_upda / $sel_ampl[2]);
								$updat_valor = query_db("update t2_marco_temporal set valor_usd = ".$valor_usd_upda." , valor_cop = ".$valor_cop_upda.", eq_usd = ".$eq_upda." $sql_comple");
							}else{*/
						//	echo "insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )<br />";
							
								$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_aplica_contrato_marco, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
								//}
						//fin verifica si ya hay linea en temporal
						
					}else{// ampliaciones presupuesto especifico o no compartido	
					$sql_comple = "where id_item =".$id_item_aplica_contrato_marco." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";
					
					$sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
					if($sele_si_ya_tiene_especifico > 0){
						$valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
						$valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
						$valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];
						
						$udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
						}else{
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_aplica_contrato_marco, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
					}
			
						}
			  }
	/*-------------------------AMPLIACIONES QUE ESTAN EN ESTADO SOCIOS --------------------*/
	
	//order de trabajo
	$valor_que_falta_restar = 0;
		//$sel_orden = query_db("select * from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_aplica_contrato_marco);
		$sel_orden = query_db("select  trm, sum(valor_usd), sum(valor_cop), t1_campo_id, ano, t7_contrato_id from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_aplica_contrato_marco." group by trm,  t1_campo_id, ano, t7_contrato_id");

		while($or_ot = traer_fila_db($sel_orden)){
			//$comple_we = "where  id_item =".$id_item_aplica_contrato_marco." and id_contrato = ".$or_ot[8]." and   ano = ".$or_ot[7]." and campo = ".$or_ot[6]." and id_usuario = ".$_SESSION["id_us_session"]."";
			$comple_we = "where  id_item =".$id_item_aplica_contrato_marco." and id_contrato = ".$or_ot[5]." and   ano = ".$or_ot[4]." and campo = ".$or_ot[3]." and id_usuario = ".$_SESSION["id_us_session"]."";

			$sel_va_esp = traer_fila_row(query_db("select sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'SI'"));
			
			//$valo_solicitado = $or_ot[9];
			$valo_solicitado = $or_ot[1]+($or_ot[2]/trm_presupuestal($or_ot[4]));
			$valor_disponible = $sel_va_esp[0];
			
			$valo_solicitado = number_format($valo_solicitado,9,'.','');
			$valor_disponible = number_format($valor_disponible,9,'.','');
			$valor_solicitado1 = explode(".",$valo_solicitado);
			$decimal = trim(substr("00".substr($valor_solicitado1[1], 0,2),-2));
			$valor_solicitado2 = $valor_solicitado1[0].".".$decimal."0000000";
			$valo_solicitado = number_format($valor_solicitado2,9,'.','');

			

			if($valo_solicitado > $valor_disponible){// si es menor el disponible que las OTS
					$update = query_db("update t2_marco_temporal set valor_usd = 0, valor_cop = 0, eq_usd = 0 $comple_we  and especifico = 'SI'");
					
					$valo_solicitado = $valo_solicitado - $valor_disponible;
					
						$sel_agrupo_presupuesto = query_db("select id_presupuesto, sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'NO' group by id_presupuesto order by id_presupuesto");
					while($sel_presu_ag = traer_fila_db($sel_agrupo_presupuesto)){
		
		
					$valor_disponible_liinea = $sel_presu_ag[1];
				
					
					if($valor_disponible_liinea> 0 and $valor_disponible_liinea >= $valo_solicitado and $valo_solicitado > 0){
						
						
						$nuevo_valor_disponible = $valor_disponible_liinea - $valo_solicitado;
						$update = query_db("update t2_marco_temporal set eq_usd = $nuevo_valor_disponible where  id_presupuesto =".$sel_presu_ag[0]);
						$valo_solicitado = $valo_solicitado - $valor_disponible_liinea;
					}					
			
						
					}
					
					//arriba de despapaya los valores origenes
				}else{// Si mayor el disponible que las ots
					$valor_que_disponible_esp = $valor_disponible - $valo_solicitado;
					$update = query_db("update t2_marco_temporal set eq_usd = $valor_que_disponible_esp $comple_we  and especifico = 'SI'");
					}
			
			}
	//FIN ordenes de trabjado
	
	$fecha_hoy = date("Y-m-d");
	$cont = 0;
    $sele_contratos = query_db("select id_contrato, ano, campo from t2_marco_temporal where id_item =".$id_item_aplica_contrato_marco." and id_usuario = ".$_SESSION["id_us_session"]." group by id_contrato, ano, campo order by id_contrato");
				while($sel_cont = traer_fila_db($sele_contratos)){
					
		  
		
		  
		  $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, contratista, vigencia_mes from $co1 where id = ".$sel_cont[0]));
		  
		  $fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			$mensaje_alerta="";
			if($sel_contrato[4] <= $fecha_vence){
				$mensaje_alerta = "Este Contrato esta Proximo a Vencer ".$sel_contrato[4];
				}
				
				
			 $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, contratista, vigencia_mes,analista_deloitte from $co1 where id = ".$sel_cont[0]));
					 
					 $mustra_contrato = "SI";
			$fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			if($sel_contrato[4] < $fecha_hoy or $sel_contrato[5] == 1){// si el contrato esta vencido
				$mustra_contrato = "NO";
				}
				
				if($mustra_contrato == "SI"){
					
		  
		  $sel_proveedor_nombre = traer_fila_row(query_db("select razon_social from $g6 where t1_proveedor_id = ".$sel_contrato[3]));
		  
		  $numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_contrato[0]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[1];
					$numero_contrato4 = $sel_contrato[2];
					
		$sel_valor_especifico = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where  id_item =".$id_item_aplica_contrato_marco." and id_contrato = ".$sel_cont[0]." and   ano = ".$sel_cont[1]." and campo = ".$sel_cont[2]." and especifico = 'SI' and id_usuario = ".$_SESSION["id_us_session"].""));
		
		$sel_valor_compartido = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where id_item =".$id_item_aplica_contrato_marco." and  id_contrato = ".$sel_cont[0]." and   ano = ".$sel_cont[1]." and campo = ".$sel_cont[2]." and especifico = 'NO' and id_usuario = ".$_SESSION["id_us_session"].""));
					
		  $espesifico_usd = $sel_valor_especifico[0];
		  $espesifico_cop = $sel_valor_especifico[1];
		  $eq_especifico = $sel_valor_especifico[2];
		  $compartido_usd =$sel_valor_compartido[0];
		  $compartido_cop = $sel_valor_compartido[1];
          $eq_compartido = $sel_valor_compartido[2];
		 
		 if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
	?>
    
  <tr class="<?=$clase?>">
    <td align="center"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont[0])?><span class="titulos_resumen_alertas"><?=$mensaje_alerta?></span></td>
    <td align="center"><?=$sel_proveedor_nombre[0]?></td>
    <td align="center"><?=saca_nombre_lista($g15,$sel_cont[2],'nombre','t1_campo_id')?></td>
    <td align="center"><?=$sel_cont[1]?></td>
    <td><?=number_format($eq_especifico,0)?></td>
    <td><?=number_format($eq_compartido,0)?></td>
    </tr>
  
   <?
				}
	}
   ?>
   <tr class="<?=$clase?>">
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td colspan="3" align="right"><? if($id_item_aplica_contrato_marco == 2984) {?><strong><a href="../imagenes/adicional_documentos/Presupuesto contrato C15-0004 - Antek.xlsx" target="_blank">Ver el disponible del contrato C15-0004 por lineas</a></strong><? }?></td>
    </tr>
</table>
    <?
    }//fin muestra disponible actual
	//fin si es orden de trabajao o ampliacion
	}
	?>
    
    
    
    
    
    
    
    <?
    	if($sel_item[6] == 4 or $sel_item[6] == 5){
			
				$id_contrato_carr = $sel_item[21];
				if($id_contrato_carr != ""){
				?>
    <?
    $sele_si_a_tenido_otro_si = traer_fila_row(query_db("select count(*) from $vpeec24 where id_contrato =".$id_contrato_carr." and t2_item_pecc_id < ".$id_item_pecc));
	
	if($sele_si_a_tenido_otro_si[0] > 0){
	?>
    <?
	}//verifica si a tenido otros si
				?>
<br />
                
                
				<?
				}
		}
?>
    <?
	 if($sel_item[49]==1){
				  $titilo="Distribuci&oacute;n del Valor para Agregar al Disponible para Crear OTs";
				   $titilo2="Lista del Disponible para Agregar al Contrato";
				  }else{
					   $titilo="Seleccione el Valor - Desde aqu&iacute; podr&aacute; distribuir los valores de la solicitud en varios proyectos";
					   $titilo2="Lista de Valores de esta Solictud";
					  }
          if ($edicion_datos_generales == "SI"){
			  
			 
		  ?>	<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="6" align="center"  class="fondo_3"><?=$titilo?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="left"><strong class='letra-descuentos'>El valor debe ser incluido únicamente en la moneda de pago</strong> <img src='../imagenes/botones/aler-interro.gif' width='5'/></td>
        <td width="8%" rowspan="3"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar" onclick="graba_presupuesto_nuevo_edicion()" /></td>
      </tr>
      <tr>
        <td width="24%">
         <?
		 if($id_tipo_proceso_pecc == 3){
			 $numero_contra_ot="";
			 
			 $sl_contra_ot ="select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id";
			 
		 $sele_contrato = traer_fila_row(query_db($sl_contra_ot));
		 
		 	$sel_apl_cota = traer_fila_row(query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_contrato[0]));

					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl_cota[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl_cota[0];
					$numero_contrato4 = $sel_apl_cota[2];
					if($numero_contrato3!=""){
					$numero_contra_ot = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl_cota[3])."<br />";
					}
		
		 }
		 if($numero_contra_ot!=""){
		 echo "Contrato de OT: ".$numero_contra_ot."<input type='hidden' name='aplica_contrato' id='aplica_contrato' value ='".$sel_apl_cota[3]."' />";
		 }else{
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
        <select name="aplica_contrato" id="aplica_contrato" onchange="carga_contratos_sin_valores(this.value,<?=$id_item_pecc_marco?>)">
        	<option value="">Selecci&oacute;n de Contratos</option>
           
           <?
           if($id_tipo_proceso_pecc == 2){
		   ?>
            <option value="0">Uno &oacute; Varios SIN Valores Especificos</option>
            
            <?
		   }
		   
		   if ($sel_item[6] == 8){
		   if($id_tipo_proceso_pecc == 3 and $sel_item[4] <> 1){// si es de bienes solo despliega opcion de bienes
										 $comple_sql = " and tipo_bien_servicio = 'Bienes'";
										 }else{//si es servicios solo despliega contratos de servicios
										 $comple_sql = " and (tipo_bien_servicio <> 'Bienes' or tipo_bien_servicio is null)";
										 }
		   }
			
										 
										 
            	$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc_marco." and t1_tipo_documento_id = 2 $comple_sql");
				while($sel_cont = traer_fila_db($sele_contratos)){
					$numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					$numero_contrato4 = $sel_cont[3];
					
					 $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, contratista, vigencia_mes,analista_deloitte from $co1 where id = ".$sel_cont[0]));
					 
					 $mustra_contrato = "SI";
			$fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			if($sel_contrato[4] < $fecha_hoy or $sel_contrato[5] == 1){// si el contrato esta vencido
				$mustra_contrato = "NO";
				}
				
				if($mustra_contrato == "SI"){
			?>
            <option value="<?=$sel_cont[0]?>"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont[0])?></option>
            <?
				}
				}
			?>
        </select>
        <?
			}
		 }
		?>
        </td>
        <td width="9%" align="center">
        
          <select name="ano" id="ano">
          
            <option value="0">A&Ntilde;O</option>
			
						
					
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
              <option value="2018">2018</option>
               <option value="2019">2019</option>
                <option value="2020">2020</option>
          </select>
         
          </td>
        <td width="16%"><select name="campo" id="campo">
          <option value="">&Aacute;rea/Proyecto</option>
          <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
        </select></td>
        <td width="13%" align="right">Valor USD$:</td>
        <td width="30%"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        </tr>
      <tr>
        <td colspan="2" align="right">Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
        <td><input name="adjunt_presu" type="file" id="adjunt_presu" size="5" /></td>
        <td align="right">Valor COP$:</td>
        <td><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        </tr>
       <?
       if($id_tipo_proceso_pecc ==3){
	   ?>
        <tr>
          <td align="right">Seleccione la Solicitud a la Cual Aplica:</td>
          <td colspan="5" align="right"> <?
		  
		  if($id_item_pecc_marco==312 ){
			  $sl_com="or t2_item_pecc.id_item_peec_aplica = 350";
			  }
		  
          $sel_sql = "select t2_item_pecc.id_item, t2_item_pecc.num1, t2_item_pecc.num2, t2_item_pecc.num3, t2_item_pecc.objeto_solicitud,t1_trm.valor  from t2_item_pecc, t1_trm where (t2_item_pecc.id_item_peec_aplica = ".$id_item_pecc_marco." $sl_com ) and t2_item_pecc.t1_tipo_proceso_id = 7 and t2_item_pecc.estado >=18 and t2_item_pecc.estado <> 31 and t2_item_pecc.estado <> 33 and t2_item_pecc.t1_trm_id = t1_trm.id_trm order by t2_item_pecc.id_item desc";
		  

		?>
        
        <select name="solicitud_aplica_ots" id="solicitud_aplica_ots">
          <option value="0">A la solicitud que genero los contratos <?=numero_item_pecc($sel_item_marco[16],$sel_item_marco[17],$sel_item_marco[18]);?></option>
          <?
		
          	$sel_ampliaciones = query_db($sel_sql);
			while($sel_apl = traer_fila_db($sel_ampliaciones)){
				
			$sel_valor_sol = traer_fila_db(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$sel_apl[0]." and permiso_o_adjudica = 2"));	
			
			$valor_eq = $sel_valor_sol[0] + ($sel_valor_sol[1] / $sel_apl[5])
				
				
          ?>
          <option value="<?=$sel_apl[0]?>"><?=numero_item_pecc($sel_apl[1],$sel_apl[2],$sel_apl[3])?> - <?=$sel_apl[4]?> - Valor Eq USD$: <?=number_format($valor_eq,0)?></option>
          <?
			}
		  ?>
        </select></td>
        </tr>
		 <?
        }else{
			?><input type="hidden" name="solicitud_aplica_ots" id="solicitud_aplica_ots" value="0" /><?
			}
		?>
		<?
		
		 
		if($sel_item[4] <> 1){
        ?>
        <tr>
        <td colspan="4" align="right">Destino:<img src="../imagenes/botones/help.gif" alt="Validar Sitio de Entrega, Operador Logistico o Campo" title="Validar Sitio de Entrega, Operador Logistico o Campo" width="20" height="20" /></td>
        <td><input type="text" name="destino_presu" id="destino_presu" /></td>
        <td width="8%">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="4" align="right">Cargo Contable:</td>
        <td><input type="text" name="cargo_cota_presu" id="cargo_cota_presu" /></td>
        <td>&nbsp;</td>
      </tr><?
		}
	  ?>
      <tr>
        <td colspan="4" align="right"><div id="carga_contratos_aplica"></div></td>
        <td>&nbsp;</td>
        <td width="8%">&nbsp;</td>
        </tr>
    </table>
      <div id="carga_presupuesto">
<?
    }
	
$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco is null");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
	
	
?>
<div id="carga_edita_presupuesto"></div>

<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="10"><div id="carga_edita_presupuesto"></div></td>
  </tr>
  <tr>
    <td colspan="10" align="center"  class="fondo_3"><?=$titilo2?></td>
  </tr>
  <tr>
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td width="13%" align="center" class="fondo_3">Contrato(s) Marco</td>
    <?
			}
		  ?>
    <td width="13%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="16%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    
    <?
    if ($sel_item[4]<>1){
	?>
    <td width="16%" align="center" class="fondo_3">Destino</td>
    <td width="16%" align="center" class="fondo_3">Cago Contable</td>
    <?
	}
	?>
    <td width="16%" align="center" class="fondo_3">Valor USD$</td>
    <td width="16%" align="center" class="fondo_3">Valor COP$</td>
    <td width="15%" align="center" class="fondo_3">Ver Adjunto</td>
    <?
      if($id_tipo_proceso_pecc ==3){
	  ?><td width="11%" align="center" class="fondo_3">Solicitud a la Cual Aplica la OT</td><? }?>
    <td width="11%" align="center" class="fondo_3">Acciones</td>
  </tr>
  <?
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				
				if($sel_presu[7] == 0){
					$num_sol_aplica = "A la solicitud que genero los contratos ".numero_item_pecc($sel_item_marco[16],$sel_item_marco[17],$sel_item_marco[18]);
					}else{
							$sel_sol_aplica_ot = traer_fila_row(query_db("select id_item, num1, num2, num3 from t2_item_pecc where id_item = ".$sel_presu[7].""));		
							$num_sol_aplica = numero_item_pecc($sel_sol_aplica_ot[1],$sel_sol_aplica_ot[2],$sel_sol_aplica_ot[3]);
						}
						
						
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
  <tr class="<?=$clase?>">
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td align="center"><?
          	$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					echo "* ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[3])."<br />";
			}
		  ?></td>
    <?
			}
		  ?>
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?=$sel_presu[2]?></td>
    
     <?
    if ($sel_item[4]<>1){
	?>
    <td align="center" ><?=$sel_presu[6]?></td>
    <td align="center" ><?=$sel_presu[8]?></td>
    <?
	}
	?>
    <td align="center" ><?=number_format($sel_presu[4],0)?></td>
    <td align="center"><?=number_format($sel_presu[5],0)?></td>
    <td align="center"> <? if($sel_presu[3] != " "){?><?=saca_nombre_anexo($sel_presu[3])?>
                  <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" />
                  </a><? }?></td>
   <?
      if($id_tipo_proceso_pecc ==3){
	  ?> <td align="center"><?=$num_sol_aplica?></td><? }?>
    <td align="center">
    <?
    if ($edicion_datos_generales == "SI"){
		
		if($id_tipo_proceso_pecc <>3){
	?>
    <img src="../imagenes/botones/editar.jpg" width="14" height="15" alt="Editar" title="Editar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?id_tipo_proceso_pecc='+document.principal.id_tipo_proceso_pecc.value+'&tipo_ajax=6&id_presupuesto=<?=$sel_presu[0]?>&id_item_pecc_marco='+document.principal.id_item_pecc_marco.value,'carga_edita_presupuesto')" style="cursor:pointer">
    <?
		}
	?>
    
    <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto(<?=$sel_presu[0]?>)" />
    <?
	}
	
     if(($sel_item[14] > 18 and $sel_item[14] <> 31) and $sel_item[6] == 8){
			?>
			<div align='right' onclick="abrir_ventana('../aplicaciones/comite/pecc/impresion-ots.php?id_item_pecc=<?=$sel_item[0]?>&id_presupuesto=<?=$sel_presu[0]?>')"><img src='../imagenes/mime/pdf.gif'  /> Imprimir OT</div>
            <?
			}
    ?>
    </td>
  </tr>
  <?
  $total_equivale_usd = ($sel_presu[5] / trm_presupuestal($sel_presu[1])) + $sel_presu[4] + $total_equivale_usd;
			}

			
		?>
</table>

<?
if($sel_item[6]!= 16){
?>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr class="titulos_resumen_alertas">
          <td width="23%" align="right">Total Equivalente USD$:</td>
          <td width="13%" align="left"><?=number_format($total_equivale_usd)?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
</table>
<? } ?>
<?php if($id_tipo_proceso_pecc != 2){ // Para solicitudes diferentes de apliacion?>


<table width="100%">
	<tr>
    	<td width="50%" valign="top">
        	<table width="100%" border="0" class="tabla_lista_resultados">
                <tr>
                    <td colspan="4" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n de valores por AÑO</td>
                <tr>
                <tr>
                    <td align="center"  class="fondo_3" width="40%">Año<td>
                    <td align="center"  class="fondo_3">Total USD</td>
                    <td align="center"  class="fondo_3">Total COP</td>
                </tr>
                <?php $group_presupuesto_ano = query_db("select $pi8.ano,sum($pi8.valor_usd) as valor_usd,sum($pi8.valor_cop) as valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco is null group by $pi8.ano");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_ano)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
              <tr class="<?=$clase?>">
                    <td><?= $rowGPA['ano']?></td>
                    <td></td>
                    <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
                    <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
                </tr>
                <?php }?>
            </table>
        </td>
        <td width="50%" valign="top">
        	<table width="100%" border="0" class="tabla_lista_resultados">
                <tr>
                    <td colspan="4" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n por Area/Proyecto</td>
                <tr>
                <tr>
                    <td align="center"  class="fondo_3" width="40%">Area/Proyecto<td>
                    <td align="center"  class="fondo_3">Total USD</td>
                    <td align="center"  class="fondo_3">Total COP</td>
                </tr>
                <?php 
                $group_presupuesto_area = query_db("select $g15.nombre,sum($pi8.valor_usd) as valor_usd,sum($pi8.valor_cop) as valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco is null group by $g15.nombre");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_area)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
              <tr class="<?=$clase?>">
                    <td><?= $rowGPA['nombre']?></td>
                    <td></td>
                    <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
                    <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
                </tr>
                <?php }?>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="right"><A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/pecc/reporte_solicitud_excel.php?id_item_pecc=<?=$id_item_pecc?>&amp;id_item_pecc_marco=<?= $id_item_pecc_marco?>'">Generar Reporte en EXCEL <img src="../imagenes/mime/xlsx.gif"  /></A><br />
<br />
<?
if(solicitud_bienes($sel_item[26]) == "SI" and ($sel_item[6] == 7 or $sel_item[6] == 8)){
?>
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" align="center" class="fondo_3">Justificaci&oacute;n del Presupuesto</td>
    </tr>
  <tr>
    <td width="50%" align="right">Detalle de la distribucion del presupuesto de esta solicitud <img src="../imagenes/botones/help.gif" alt="En este campo el comprador con base en el detalle del estimado justifica, si se encuentra dentro de lo solicitado ó si a pesar de no estar estimado puede gastarse y porque? Ejemplo : No se hará ya el suministro estimado en el pozo x por lo que se puede usar en el pozo" title="En este campo el comprador con base en el detalle del estimado justifica, si se encuentra dentro de lo solicitado ó si a pesar de no estar estimado puede gastarse y porque? Ejemplo : No se hará ya el suministro estimado en el pozo x por lo que se puede usar en el pozo" width="20" height="20" />:</td>
    <td width="50%">
    <?
	
	
	
    if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
    <textarea name="detalle_presupuesto" id="detalle_presupuesto" cols="25" rows="5"><?=$sel_item[53]?></textarea>
    <?
    }else{
		echo $sel_item[53];
		}
	?>
    
    </td>
  </tr>
   <?
   if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input name="button" type="button" class="boton_grabar" id="button" value="Grabar la Justificaci&oacute;n" onclick="graba_justificacion_del_presupuesto()" /></td>
  </tr>
  <?
    }
	?>
</table>

<?
    }
	?>
</td>
    </tr>
</table>	

<?php } // Fin if diferente de ampliacion?>

</div>
<?


}//fin si es con solicitudes, OT o Ampliacion y no tienen solicitud relacionada


if($sel_item[6]==5 and $sel_item[49]==1){

if ($edicion_datos_generales == "SI"){
?>


<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="6" align="center"  class="fondo_3">Seleccione el Valor Disponible Actual del Contrato que se Convertira a Marco</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="left"><strong class='letra-descuentos'>El valor debe ser incluido &uacute;nicamente en la moneda de pago</strong> <img src='../imagenes/botones/aler-interro.gif' width='5'/></td>
    <td width="9%" rowspan="3"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar" onclick="graba_presupuesto_nuevo_edicion_ini_contrato()" /></td>
  </tr>
  <tr>
    <td width="24%"><?
		 if($id_tipo_proceso_pecc == 3){
			 $numero_contra_ot="";
			 
			 $sl_contra_ot ="select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id";
			 
		 $sele_contrato = traer_fila_row(query_db($sl_contra_ot));
		 
		 	$sel_apl_cota = traer_fila_row(query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_contrato[0]));

					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl_cota[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl_cota[0];
					$numero_contrato4 = $sel_apl_cota[2];
					if($numero_contrato3!=""){
					$numero_contra_ot = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl_cota[3])."<br />";
					}
		
		 }
		 if($numero_contra_ot!=""){
		 echo "Contrato de OT: ".$numero_contra_ot."<input type='hidden' name='aplica_contrato' id='aplica_contrato' value ='".$sel_apl_cota[3]."' />";
		 }else{
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
      <select name="aplica_contrato2" id="aplica_contrato2" onchange="carga_contratos_sin_valores(this.value,<?=$id_item_pecc_marco?>)">
        <option value="">Selecci&oacute;n de Contratos</option>
        <?
           if($id_tipo_proceso_pecc == 2){
		   ?>
        <option value="0">Uno &oacute; Varios SIN Valores Especificos</option>
        <?
		   }
            	$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc_marco." and t1_tipo_documento_id = 2");
				while($sel_cont = traer_fila_db($sele_contratos)){
					$numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					$numero_contrato4 = $sel_cont[3];
			?>
        <option value="<?=$sel_cont[0]?>">
          <?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont[0])?>
          </option>
        <?
				}
			?>
      </select>
      <?
			}
		 }
		?></td>
    <td width="9%" align="center"><select name="ano2" id="ano2">
      <option value="0">A&Ntilde;O</option>
      <option value="2013">2013</option>
      <option value="2014">2014</option>
      <option value="2015">2015</option>
      <option value="2016">2016</option>
      <option value="2017">2017</option>
      <option value="2018">2018</option>
      <option value="2019">2019</option>
      <option value="2020">2020</option>
    </select></td>
    <td width="16%"><select name="campo2" id="campo2">
      <option value="">&Aacute;rea/Proyecto</option>
      <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
    </select></td>
    <td width="13%" align="right">Valor USD$:</td>
    <td width="29%"><input name="valor_usd2" type="text" id="valor_usd2" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
    </tr>
  <tr>
    <td colspan="2" align="right">Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
    <td><input name="adjunt_presu2" type="file" id="adjunt_presu2" size="5" /></td>
    <td align="right">Valor COP$:</td>
    <td><input name="valor_cop2" type="text" id="valor_cop2" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
  </tr>
  <?
       if($id_tipo_proceso_pecc ==3){
	   ?>
  <?
        }else{
			?>
  <input type="hidden" name="solicitud_aplica_ots2" id="solicitud_aplica_ots2" value="0" />
  <?
			}
		?>
  <?
		
		 
		if($sel_item[4] <> 1){
        ?>
  <?
		}
	  ?>
</table>
<? } ?>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="10"><div id="carga_edita_presupuesto2"></div></td>
  </tr>
  <tr>
    <td colspan="10" align="center"  class="fondo_3">Valor disponible Actual del Contrato</td>
  </tr>
  <tr>
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td width="13%" align="center" class="fondo_3">Contrato(s) Marco</td>
    <?
			}
		  ?>
    <td width="13%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="16%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    <?
    if ($sel_item[4]<>1){
	?>
    <td width="16%" align="center" class="fondo_3">Destino</td>
    <td width="16%" align="center" class="fondo_3">Cago Contable</td>
    <?
	}
	?>
    <td width="16%" align="center" class="fondo_3">Valor USD$</td>
    <td width="16%" align="center" class="fondo_3">Valor COP$</td>
    <td width="15%" align="center" class="fondo_3">Ver Adjunto</td>
    <?
      if($id_tipo_proceso_pecc ==3){
	  ?>
    <td width="11%" align="center" class="fondo_3">Solicitud a la Cual Aplica la OT</td>
    <? }?>
    <td width="11%" align="center" class="fondo_3">Acciones</td>
  </tr>
  <?
  
  $sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco =1");
	


		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				
				if($sel_presu[7] == 0){
					$num_sol_aplica = "Al Valor General del Contrato";
					}else{
							$sel_sol_aplica_ot = traer_fila_row(query_db("select id_item, num1, num2, num3 from t2_item_pecc where id_item = ".$sel_presu[7].""));		
							$num_sol_aplica = numero_item_pecc($sel_sol_aplica_ot[1],$sel_sol_aplica_ot[2],$sel_sol_aplica_ot[3]);
						}
						
						
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
  <tr class="<?=$clase?>">
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td align="center"><?
          	$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					echo "* ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[3])."<br />";
			}
		  ?></td>
    <?
			}
		  ?>
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?=$sel_presu[2]?></td>
    <?
    if ($sel_item[4]<>1){
	?>
    <td align="center" ><?=$sel_presu[6]?></td>
    <td align="center" ><?=$sel_presu[8]?></td>
    <?
	}
	?>
    <td align="center" ><?=number_format($sel_presu[4],0)?></td>
    <td align="center"><?=number_format($sel_presu[5],0)?></td>
    <td align="center"><? if($sel_presu[3] != " "){?>
      <?=saca_nombre_anexo($sel_presu[3])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&amp;n1=<?=$sel_presu[0]?>&amp;n3=3" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" /> </a>
      <? }?></td>
    <?
      if($id_tipo_proceso_pecc ==3){
	  ?>
    <td align="center"><?=$num_sol_aplica?></td>
    <? }?>
    <td align="center"><?
    if ($edicion_datos_generales == "SI"){
		
		if($id_tipo_proceso_pecc <>3){
	?>
      <img src="../imagenes/botones/editar.jpg" width="14" height="15" alt="Editar" title="Editar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?id_tipo_proceso_pecc='+document.principal.id_tipo_proceso_pecc.value+'&amp;tipo_ajax=6&amp;id_presupuesto=<?=$sel_presu[0]?>&amp;id_item_pecc_marco='+document.principal.id_item_pecc_marco.value,'carga_edita_presupuesto')" style="cursor:pointer" />
      <?
		}
	?>
      <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto(<?=$sel_presu[0]?>)" />
      <?
	}
	
     if(($sel_item[14] > 18 and $sel_item[14] <> 31) and $sel_item[6] == 8){
			?>
      <div align='right' onclick="abrir_ventana('../aplicaciones/comite/pecc/impresion-ots.php?id_item_pecc=<?=$sel_item[0]?>&amp;id_presupuesto=<?=$sel_presu[0]?>')"><img src='../imagenes/mime/pdf.gif'  /> Imprimir OT</div>
      <?
			}
    ?></td>
  </tr>
  <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
</table>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr class="titulos_resumen_alertas">
    <td width="34%" align="right">Total de Toda la Solicitud Equivalente USD$:</td>
    <td width="10%" align="left"><?=number_format($total_equivale_usd)?></td>
    <td width="11%" align="right">Total USD$:</td>
    <td width="14%" align="left"><?=number_format($valor_total_usd)?></td>
    <td width="11%" align="right">Total COP$:</td>
    <td width="20%" align="left"><?=number_format($valor_total_cop)?></td>
  </tr>
</table>

<?
}
?>
<br />


</td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
  <tr>
    <td valign="top"><?
if(solicitud_bienes($sel_item[26]) == "SI" and ($sel_item[6] == 7 or $sel_item[6] == 8)){
?>
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" align="center" class="fondo_3">Justificaci&oacute;n del Presupuesto</td>
    </tr>
  <tr>
    <td width="50%" align="right">Detalle de la distribucion del presupuesto de esta solicitud <img src="../imagenes/botones/help.gif" alt="En este campo el comprador con base en el detalle del estimado justifica, si se encuentra dentro de lo solicitado ó si a pesar de no estar estimado puede gastarse y porque? Ejemplo : No se hará ya el suministro estimado en el pozo x por lo que se puede usar en el pozo" title="En este campo el comprador con base en el detalle del estimado justifica, si se encuentra dentro de lo solicitado ó si a pesar de no estar estimado puede gastarse y porque? Ejemplo : No se hará ya el suministro estimado en el pozo x por lo que se puede usar en el pozo" width="20" height="20" />:</td>
    <td width="50%">
    <?
	
	
	
    if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
    <textarea name="detalle_presupuesto" id="detalle_presupuesto" cols="25" rows="5"><?=$sel_item[53]?></textarea>
    <?
    }else{
		echo $sel_item[53];
		}
	?>
    
    </td>
  </tr>
   <?
   if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input name="button" type="button" class="boton_grabar" id="button" value="Grabar la Justificaci&oacute;n" onclick="graba_justificacion_del_presupuesto()" /></td>
  </tr>
  <?
    }
	?>
</table>

<?
    }
	?></td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_item_pecc_real" id="id_item_pecc_real" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc_marco" id="id_item_pecc_marco" value="<?=$id_item_pecc_marco?>" />
<input type="hidden" name="id_trm_aplica" id="id_trm_aplica" value="<?=$sel_item[15]?>" />
<input type="hidden" name="id_presupuesto_elimina" id="id_presupuesto_elimina" value="" />
<input type="hidden" name="id_pecc" id="id_pecc" value="<?=$id_pecc?>" />
<input type="hidden" name="estado_actual_del_proceso" id="estado_actual_del_proceso" value="<?=$sel_item[14]?>" />
<input type="hidden" name="id_tipo_contratacion" id="id_tipo_contratacion" value="<?=$sel_item[4]?>" />
<input type="hidden" name="tipo_proceso" value="<?= $t1_tipo_proceso_id?>"/>
<?
//imprime_para_comparar();
?>
<div align='right' ><strong onclick="abrir_ventana('../aplicaciones/comite/pecc/impresion-ots.php?id_item_pecc=<?=$sel_item[0]?>&id_presupuesto=<?=$sel_presu[0]?>')">-</strong></div>
</body>
</html>
