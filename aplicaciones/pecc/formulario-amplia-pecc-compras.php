<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$num_ale= rand(0,99);
	$num_ale.= rand(0,99);
	$aleatorio = $fecha.$num_ale.$hora;
	
	if($id_pecc == 1){
			$titulo_1 = "";
		}else{
			$titulo_1 = " - PECC";
			}
			
$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]));			

	
	$select_data_item = traer_fila_row(query_db("select t2.t1_area_id, t2.nombre, CAST(t1.ob_contrato_adjudica AS text), CAST(t1.objeto_contrato AS text) from $pi2 as t1, $g12 as t2 where t1.id_item=".$id_item_pecc." and t1.t1_area_id = t2.t1_area_id"));
	

    	if($id_tipo_proceso_pecc == 2){
				$valor = 7;
				$titulo_principal = "Informaci&oacute;n General de la Ampliaci&oacute;n";
				$titulo_fecha = "Fecha para cuando se requiere la Ampliaci&oacute;n";
				$tipo_proceso_item =  "Ampliaci&oacute;n Contrato Marco";
				$titulo_presupuesto = "Valor de los Contratos Marco para la Ampliaci&oacute;n";
			}
		if($id_tipo_proceso_pecc == 3){
				$valor = 8;
				$titulo_principal = "Informaci&oacute;n General de las Ordenes de Trabajo";
				$titulo_fecha = "Fecha en la que se Requiere los Bienes";
				$tipo_proceso_item =  "Orden de Pedido Contrato Marco / Lista de Precios";
				$titulo_presupuesto = "Asignaci&oacute;n Presupuestal de Ordenes de Pedido";
			}

//verifica si es administrador de ordenes de trabajo
$sel_si_es_administrador_de_ots = traer_fila_row(query_db("select * from v_seg1 where us_id =".$_SESSION["id_us_session"]." and id_premiso = 33"));
$es_admin_ot = "NO";
 if($sel_si_es_administrador_de_ots[0] > 0 and $id_tipo_proceso_pecc == 3){
	 $es_admin_ot = "SI";
 }

	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<table width="100%" border="0">
  <tr>
    <td width="90%" align="right"><img src="../imagenes/botones/aviso_observaciones.png" alt="" width="16" height="16" /> <span class="titulos_resumen_alertas">&iquest;No es la solictud que estaba buscando ?</span></td>
    <td width="10%"><input name="volver_buscar" type="button" value="Volver a Buscar" onclick="document.getElementById('buscardor_solicitud_contrato_marco').style.display='';document.getElementById('carga_formulario_solicitud').style.display='none'" class="boton_buscar" /></td>
  </tr>
</table>

<?
		
			
			
		$sel_pecc = traer_fila_row(query_db("select $pi1.id_pecc,$pi1.ano,$pi1.objeto,$g1.nombre_administrador, $g10.valor, $pi1.nombre, $g10.id_trm from $pi1, $g1, $g10 where $pi1.id_pecc = ".$id_pecc." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
?>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones"><?=$titulo_principal.$titulo_1?></td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2">
  <tr >
      <td align="right">Tipo de contrataci&oacute;n:</td>
      <td width="27%"><select name="id_tipo_contratacion" id="id_tipo_contratacion">
      	<option value="2">MRO Proyectos</option>
        <?
        $sel_us_bodega = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 29"));
		if($sel_us_bodega[0]>0){
		?>
        <option value="3">MRO Stok</option>
        <?
		}
		?>
        <option value="4">MRO Corporativo</option>
      </select></td>
    <td width="37%" rowspan="7" valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td height="25" align="left" class=""><?=$sel_pecc[2]?></td>
        </tr>
        <?
if($id_pecc != 1){
?>
        <tr>
          <td align="left">Encargado del PECC:
          <?=$sel_pecc[3]?></td>
        </tr>
        <tr class="">
          <td align="left">A&ntilde;o: <?=$sel_pecc[1]?></td>
        </tr>
        <?
}
		?>
        <tr class="">
          <td align="left">TRM:
          <?=$sel_pecc[4]?></td>
        </tr>
    </table></td>
  </tr>
   <?
  
  
  if($sel_usu_emulan[0]>0){
  ?>
  <tr >
    <td align="right">Preparador:</td>
    <td><?=$_SESSION["us_nombre_session"]?></td>
  </tr>
  <?
  }
  ?>
  <tr >
      <td align="right">
      <?
        if($es_admin_ot == "SI"){
			echo "Solicitante de la OT:";
		}else{
			echo "Gerente del ITEM: ";
	  	}
	  ?>
      </td>
      <td> <?
	  if($sel_usu_emulan[0]>0){
		  ?>
		  <select name="gerente_contra" id="gerente_contra">
          <option value="0">Seleccione el Gerente</option>
          <?
          $sel_usu_emula = query_db("select t1.us_id,t1.nombre_administrador from t1_us_usuarios as t1, t2_relacion_usuarios_emulan as t2 where t2.id_us_emula = t1.us_id and t2.id_us = ".$_SESSION["id_us_session"]);
		  while($sel_us_emu = traer_fila_row($sel_usu_emula)){
		  ?>
          <option value="<?=$sel_us_emu[0]?>"><?=$sel_us_emu[1]?></option>
          <?
		  }
		  ?>
          </select>
		  <?
	  }else{
       echo $_SESSION["us_nombre_session"]?><input type="hidden" name="gerente_contra" id="gerente_contra" value="<?=$_SESSION["id_us_session"]?>" /><?
	  }
	  ?></td>
  </tr>
  <?

  if($es_admin_ot == "SI"){
 
  ?>
  <tr >
    <td align="right">Gerente de la OT:</td>
    <td><input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()"/></td>
  </tr>
  <?
  }else{
	  ?><input type="hidden" name="usuario_permiso" id="usuario_permiso" value="<?="es----,".$_SESSION["id_us_session"]."----,"?>"/><?
	  }
  ?>
  <tr >
    <td width="36%" align="right">Tipo de Proceso:</td>
    <td>
      <?=$tipo_proceso_item?>
      <input type="hidden" name="tipo_proceso" id="tipo_proceso" value="<?=$valor?>" />
    </td>
  </tr>
  <tr>
    <td align="right">&Aacute;rea Usuaria:</td>
    <td><?=$select_data_item[1]?>
      <input type="hidden" value="<?=$select_data_item[0]?>" name="area_usuaria" id="area_usuaria" />
    </td>
  </tr>
  <tr>
    <td align="right"><?=$titulo_fecha?>
      :<img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
    <td><input name="fecha" type="text" id="fecha" size="5" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha')"/></td>
  </tr>
  <tr>
    <td align="right">Objeto del Contrato:</td>
    <td colspan="2"><? if($select_data_item[2]=="") echo $select_data_item[3]; else echo $select_data_item[2];?><input type="hidden" name="objeto_contrato" id="objeto_contrato" value="<? if($select_data_item[2]=="") echo $select_data_item[3]; else echo $select_data_item[2];?>" /></td>
  </tr>
  <tr>
    <td align="right">Alcance:<img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
    <td colspan="2"><textarea name="alcance" id="alcance" cols="25" rows="4"></textarea></td>
  </tr>
  <tr>
    <td align="right"><? if ($valor == 8){ echo "Trabajo a Realizarse Mediante esta Orden de Pedido Contrato Marco"; $texto_ayuda = "El Contratista se obliga para con la Compa&ntilde;&iacute;a a  ejecutar bajo su exclusivo riesgo y como persona natural o jur&iacute;dica  independiente, con plena autonom&iacute;a administrativa, t&eacute;cnica y directiva y  utilizando sus propios medios, los servicios de ...";}else{ echo "Objeto de la Solicitud";}?>:<img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
    <td colspan="2"><textarea name="objeto_solicitud" id="objeto_solicitud" cols="25" rows="5"><?=$texto_ayuda?></textarea></td>
  </tr>
  <tr>
    <td align="right">Justificaci&oacute;n :<img src="../imagenes/botones/help.gif" alt="Sistema donde se Utilizara (PIA, CENTRO DE GENERACION O GENERADORES CUMINS)" title="Sistema donde se Utilizara (PIA, CENTRO DE GENERACION O GENERADORES CUMINS)" width="20" height="20" /></td>
    <td colspan="2"><textarea name="justificacion" id="justificacion" cols="25" rows="4"></textarea>
      <input type="hidden" name="proveedores_sugeridos" id="proveedores_sugeridos" value="N/A" />
      <!--input type="hidden" name="alcance" id="alcance" value="N/A" /></td -->
  </tr>
  <tr>
    <td align="right">Recomendaci&oacute;n:<img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
    <td colspan="2"><textarea name="recomendacion" id="recomendacion" cols="25" rows="4"></textarea></td>
  </tr>
  <tr>
    <td align="right">Elementos Requeridos:</td>
    <td colspan="2">Descargue aqu&iacute; la plantilla donde podrá relacionar los materiales de esta solicitud <a href="../imagenes/Copia de plantilla compras.xlsx" target="_blank"><img src="../imagenes/mime/xls.gif" alt="" /></a>
      <input type="hidden" name="alcance2" id="alcance2" value="N/A"/></td>
  </tr>
  <?
  if ($valor == 8){
  ?>
  <tr>
    <td align="right">Destino:</td>
    <td colspan="2"><input name="destino_orden_trabajo" type="text" id="destino_orden_trabajo" value="" size="25" /></td>
  </tr>
  <tr>
    <td align="right">Duraci&oacute;n de la Orden de Trabajo:</td>
    <td colspan="2"><input name="duracion_orden_trabajo" type="text" id="duracion_orden_trabajo" value="" size="25" /></td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right">
    
  
    </td>
  </tr>
  <tr>
    <td colspan="3" align="right">
    
    <table width="100%" border="0" class="tabla_lista_resultados">
  
  <tr >
    <td width="17%" rowspan="2" align="center" class="fondo_3">Numero del Contrato Marco</td>
    <td width="12%" rowspan="2" align="center" class="fondo_3">Contratista</td>
    <td width="12%" rowspan="2" align="center" class="fondo_3">&Aacute;rea</td>
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
	
	$delete = query_db("delete from t2_marco_temporal where id_usuario = ".$_SESSION["id_us_session"]." and id_item = ".$id_item_pecc);
	
	$sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio where id_item =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
	
	while($sel_inio = traer_fila_db($sel_valor_inicial)){
			$eq = $sel_inio[0] + ($sel_inio[1] / $sel_inio[2]);
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_inio[5].", ".$sel_inio[3].", ".$sel_inio[4].", ".$sel_inio[0].", ".$sel_inio[1].", $eq, 'NO', ".$sel_inio[6]." )");
			
		}
	
	
	$ampliacion = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
		  
		  while($sel_ampl = traer_fila_db($ampliacion)){
			  $eq = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
			  $valor_usd_queda_si = 0;
			$valor_cop_queda_si = 0;
			$valor_eq_queda_si =  0;
						
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
						//verifica si ya hay linea en temporal
						$sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
						$sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));
						/*if($sel_temp[0] > 0){//si hay lineas iguales sumar valor
								$valor_usd_upda =$sel_ampl[0]+$sel_temp[6];
								$valor_cop_upda =$sel_ampl[1]+$sel_temp[7];
								$eq_upda = $valor_usd_upda + ($valor_cop_upda / $sel_ampl[2]);
								$updat_valor = query_db("update t2_marco_temporal set valor_usd = ".$valor_usd_upda." , valor_cop = ".$valor_cop_upda.", eq_usd = ".$eq_upda." $sql_comple");
							}else{*/
						//	echo "insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )<br />";
							
								$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
								//}
						//fin verifica si ya hay linea en temporal
						
					}else{// ampliaciones presupuesto especifico o no compartido	
					$sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";
					
					$sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
					if($sele_si_ya_tiene_especifico > 0){
						$valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
						$valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
						$valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];
						
						$udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
						}else{
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
					}
			
						}
			  }
	
	
	//order de trabajo
	$valor_que_falta_restar = 0;
		$sel_orden = query_db("select * from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc);
		while($or_ot = traer_fila_db($sel_orden)){
			$comple_we = "where  id_item =".$id_item_pecc." and id_contrato = ".$or_ot[8]." and   ano = ".$or_ot[7]." and campo = ".$or_ot[6]." and id_usuario = ".$_SESSION["id_us_session"]."";
			$sel_va_esp = traer_fila_row(query_db("select sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'SI'"));
			
			$valo_solicitado = $or_ot[9];
			$valor_disponible = $sel_va_esp[0];

			if($valo_solicitado > $valor_disponible){// si es menor el disponible que las OTS
					$update = query_db("update t2_marco_temporal set valor_usd = 0, valor_cop = 0, eq_usd = 0 $comple_we  and especifico = 'SI'");
					
					$valo_solicitado = $valo_solicitado - $valor_disponible;
					
						$sel_agrupo_presupuesto = query_db("select id_presupuesto, sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'NO' group by id_presupuesto order by id_presupuesto");
					while($sel_presu_ag = traer_fila_db($sel_agrupo_presupuesto)){
		
					$valor_disponible_liinea = $sel_presu_ag[1];
					if($valor_disponible_liinea > 0 and $valor_disponible_liinea >= $valo_solicitado and $valo_solicitado > 0){
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
    $sele_contratos = query_db("select id_contrato, ano, campo from t2_marco_temporal where id_item =".$id_item_pecc." and id_usuario = ".$_SESSION["id_us_session"]." group by id_contrato, ano, campo order by id_contrato");
				while($sel_cont = traer_fila_db($sele_contratos)){
					
		 
		  
		  $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, contratista, vigencia_mes from $co1 where id = ".$sel_cont[0]));
		  
		  $fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			$mensaje_alerta="";
			if($sel_contrato[4] <= $fecha_vence){
				$mensaje_alerta = "Este Contrato esta Proximo a Vencer ".$sel_contra[14];
				}

				
		  
		  $sel_proveedor_nombre = traer_fila_row(query_db("select razon_social from $g6 where t1_proveedor_id = ".$sel_contrato[3]));
		  
		  $numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_contrato[0]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[1];
					$numero_contrato4 = $sel_contrato[2];
					
		$sel_valor_especifico = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where  id_item =".$id_item_pecc." and id_contrato = ".$sel_cont[0]." and   ano = ".$sel_cont[1]." and campo = ".$sel_cont[2]." and especifico = 'SI' and id_usuario = ".$_SESSION["id_us_session"].""));
		
		$sel_valor_compartido = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where id_item =".$id_item_pecc." and  id_contrato = ".$sel_cont[0]." and   ano = ".$sel_cont[1]." and campo = ".$sel_cont[2]." and especifico = 'NO' and id_usuario = ".$_SESSION["id_us_session"].""));
					
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
    <td align="center"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)?> <span class="titulos_resumen_alertas"><?=$mensaje_alerta?></span></td>
    <td align="center"><?=$sel_proveedor_nombre[0]?></td>
    <td align="center"><?=saca_nombre_lista($g15,$sel_cont[2],'nombre','t1_campo_id')?></td>
    <td align="center"><?=$sel_cont[1]?></td>
    <td><?=number_format($eq_especifico,0)?></td>
    <td><?=number_format($eq_compartido,0)?></td>
    </tr>
   <?
				}
   ?>
   
</table></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="6" align="center"  class="fondo_3"><?=$titulo_presupuesto?> <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
      </tr>
      <tr>
        <td width="20%"><select name="aplica_contrato" id="aplica_contrato" onchange="carga_contratos_sin_valores(this.value,<?=$id_item_pecc?>)">
        	<option value="">Selecci&oacute;n de Contratos</option>
           
           <?
           if($id_tipo_proceso_pecc == 2){
		   ?>
            <option value="0">Uno &oacute; Varios SIN Valores Especificos</option>
            
            <?
		   }
            	$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc." and t1_tipo_documento_id = 2");
				while($sel_cont = traer_fila_db($sele_contratos)){
					$numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					$numero_contrato4 = $sel_cont[3];
			?>
            <option value="<?=$sel_cont[0]?>"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)?></option>
            <?
				}
			?>
        </select></td>
        <td width="12%" align="center">
        
          <select name="ano" id="ano">
          
            <option value="0">A&Ntilde;O</option>
			
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
          </select>
          
          </td>
        <td width="16%"><select name="campo" id="campo">
          <option value="">&Aacute;rea</option>
          <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
        </select></td>
        <td width="16%" align="right">Valor USD$:</td>
        <td width="27%"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        <td width="9%" rowspan="5"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar" onclick="graba_presupuesto_nuevo()" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="right">Adjunto:</td>
        <td><div id="resetea_presus"><input name="adj_presupuesto" type="file" id="adj_presupuesto" size="5" /></div></td>
        <td align="right">Valor COP$:</td>
        <td><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
      </tr>
      
      <?
      if($id_tipo_proceso_pecc ==3){
	  ?>
      <tr>
        <td align="right">Seleccione la Solicitud a la Cual Aplica:</td>
        <td colspan="4" align="left">
        <?
          $sel_sql = "select t2_item_pecc.id_item, t2_item_pecc.num1, t2_item_pecc.num2, t2_item_pecc.num3, t2_item_pecc.objeto_solicitud,t1_trm.valor  from t2_item_pecc, t1_trm where t2_item_pecc.id_item_peec_aplica = ".$id_item_pecc." and t2_item_pecc.t1_tipo_proceso_id = 7 and t2_item_pecc.estado >=20 and t2_item_pecc.t1_trm_id = t1_trm.id_trm";
		?>
        
        <select name="solicitud_aplica_ots" id="solicitud_aplica_ots">
          <option value="0">Al Valor General del Contrato</option>
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
        <tr>
          <td align="right">Destino:<img src="../imagenes/botones/help.gif" alt="Validar Sitio de Entrega, Operador Logistico o Campo" title="Validar Sitio de Entrega, Operador Logistico o Campo" width="20" height="20" /></td>
          <td colspan="2"><input type="text" name="destino_presu" id="destino_presu" /></td>
          <td align="right">Cargo Contable:</td>
          <td><input type="text" name="cargo_cota_presu" id="cargo_cota_presu" /></td>
        </tr>
        <tr>
        <td colspan="4" align="right"><div id="carga_contratos_aplica"></div></td>
        <td>&nbsp;</td>
        </tr>
    </table>
    <div id="carga_presupuesto"><input type="hidden" name="valor_total_js_valida" id="valor_total_js_valida" value="0" /></div>
      </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td colspan="2" align="center" class="fondo_3">Lista de Materiales <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
        <td width="54%" valign="top"></td>
      </tr>
      <tr>
        <td width="21%" align="right">Detalle del Anexo:</td>
        <td width="25%" align="left"><textarea name="anexo" cols="25" id="anexo"></textarea></td>
        <td width="54%" rowspan="3" valign="top"><div id="carga_anexos"></div></td>
      </tr>
      <tr>
        <td align="right">Seleccionar Archivo Adjunto:</td>
        <td align="left"><input name="adj_anexo" type="file" id="adj_anexo" size="5" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onclick="graba_anexo(8)" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td width="54%" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td colspan="2" align="center" class="fondo_3">Otros Anexos <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
        <td width="54%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="right" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
          <tr>
            <td width="21%" align="right">Detalle del Anexo:</td>
            <td width="25%" align="left"><textarea name="ancedente" cols="25" rows="5" id="ancedente"></textarea></td>
          </tr>
          <tr>
            <td align="right">Seleccionar Archivo Adjunto:</td>
            <td align="left"><input name="adj_antecedente" type="file" id="adj_antecedente" size="5" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="center"><input name="button3" type="button" class="boton_grabar" id="button3" value="Agregar Antecedente"  onclick="graba_anexo(9)"/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td valign="top"><div id="carga_antecedentes"></div>
          
          
          
          <?
		  
          $id_contrato_carr = $id_item_pecc;
		  if($id_tipo_proceso_pecc == 3 or $id_tipo_proceso_pecc == 2){
	$solicitudes_antecedentes = 0;

	$sele_otros_si = query_db("select id_item from $pi2 where id_item_peec_aplica = ".$id_item_pecc);
	while($sel_item_otros = traer_fila_db($sele_otros_si)){
		$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$sel_item_otros[0];
		}
	
	$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$id_item_pecc;
		  ?>
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="3" align="center"  class="fondo_3">Antecedentes de Otras Solicitudes Relacionadas</td>
              </tr>
            <tr>
              <td width="16%" align="center" class="fondo_3">No.</td>
              <td width="57%" align="center" class="fondo_3">Detalle</td>
              <td width="27%" align="center" class="fondo_3">Archivo Adjunto</td>
              </tr>
            <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id in (".$solicitudes_antecedentes.") and estado = 1 and tipo = 'antecedente' order by t2_item_pecc_id desc, t2_anexo_id desc");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  
	  $sel_numero_item = traer_fila_row(query_db("select num1,num2,num3 from $pi2 where id_item = ".$sl_anexos[1]));
	  
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
            <tr class="<?=$clase?>">
              <td align="center" ><?=numero_item_pecc($sel_numero_item[0],$sel_numero_item[1],$sel_numero_item[2])?></td>
              <td align="center" ><?=$sl_anexos[4]?></td>
              <td align="center" >
                <? if($sl_anexos[5] != " "){?>
                <?=saca_nombre_anexo($sl_anexos[5])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
                <?
	}
	?>
                </td>
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
    </table></td>
  </tr>
   <?
  if($sel_usu_emulan[0] > 0){
	  $testos = "Temporalmente - Debera ponerse en contacto con el gerente del contrato para ponerlo en firme";
	  }else{
		  $testos = "temporalmente";
		  }
  ?>
  <tr>
    <td colspan="2" align="right"><input name="button" type="button" class="boton_grabar" id="button" value="Grabar este proceso en <?=$sel_pecc[5]?> - <?=$testos?>" onclick="valida_graba_item(1)" /></td>
    <td>
    
<?    if($sel_usu_emulan[0] == 0){?>
    <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar este proceso en <?=$sel_pecc[5]?> y poner en firme" onclick="valida_graba_item(2)"/>
    <?
}
	?>
    
    </td>
  </tr>
</table>

<input type="hidden" name="aleatorio" id="aleatorio" value="<?=$aleatorio?>" />
<input type="hidden" name="id_pecc" id="id_pecc" value="<?=$id_pecc?>" />
<input type="hidden" name="tipo_anexo" id="tipo_anexo" />
<input type="hidden" name="tipo_graba" id="tipo_graba" />
<input type="hidden" name="id_trm_aplica" id="id_trm_aplica" value="<?=$sel_pecc[6]?>" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_item_pecc_real" id="id_item_pecc_real" value="0" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_presupuesto_elimina" id="id_presupuesto_elimina" value="" />
<input type="hidden" name="id_anexo_elimina" id="id_anexo_elimina" value="" />
<input type="hidden" name="solicitud_que_carga" id="solicitud_que_carga" />
</body>
</html>
