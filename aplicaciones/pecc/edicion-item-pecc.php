<? include("../../librerias/lib/@session.php"); 
/**** PARA EL DES086 ****/
if($_GET["tipo_carga"] or $_SESSION["tipo_carga"]=="1"){
	$_SESSION["tipo_carga"]="1";
}else{
	$div_carga="carga_modal_pecc";
}
/**** PARA EL DES086 ****/
verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
//require("../../librerias/php/mail_pecc.php");../../librerias/php/mail_pecc.php
// echo $id_tipo_proceso_pecc;	
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
if($_GET["aplica_log"] != "4"){//cuando graba y entre aca no aplique el log
$id_log = log_de_procesos_sgpa(1, 4, 0, $id_item_pecc , "0", "0");//inserta consulta
}

$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
$id_item_pecc_aplica=$sel_item[26];

$id_item_contra_marco_relacionado = $sel_item[26];

if($sel_item[6] == 1 or $sel_item[6] == 2 or $sel_item[6] == 3 or $sel_item[6] == 5 or $sel_item[6] == 7 or $sel_item[6] == 15){
$aplica_objetivos_pro ="SI";
}


$id_tipo_proceso_pecc =1;
if($sel_item[6] == 7){
$id_tipo_proceso_pecc =2;
}
if($sel_item[6] == 8){
		$id_tipo_proceso_pecc =3;
		}

	$sel_suario_gerente_ot = traer_fila_row(query_db("select us_id , nombre_administrador from t1_us_usuarios where us_id =".$sel_item[42]));
	if($sel_suario_gerente_ot[0]>0){$nombre_gerente_ot = "-".$sel_suario_gerente_ot[1]."----,".$sel_suario_gerente_ot[0];}
	
	$sel_suario_par_tecnico = traer_fila_row(query_db("select us_id , nombre_administrador from t1_us_usuarios where us_id =".$sel_item[64]));
	if($sel_suario_par_tecnico[0]>0){$nombre_par_tecnico = "-".$sel_suario_par_tecnico[1]."----,".$sel_suario_par_tecnico[0];}
	
	$sel_suario_ger_contrato = traer_fila_row(query_db("select us_id , nombre_administrador from t1_us_usuarios where us_id =".$sel_item[65]));
	if($sel_suario_ger_contrato[0]>0){$nombre_ger_contrato = "-".$sel_suario_ger_contrato[1]."----,".$sel_suario_ger_contrato[0];}
	
	
	
	
	$lt = traer_fila_row(query_db("select t1_proveedor_id , razon_social, nit from t1_proveedor where t1_proveedor_id =".$sel_item[52]));
	$nombre_proveedor = "-".$lt[1]." ".$lt[2]."----,".$lt[0]."----,";
	
	if($sel_item[6] == 16 and $sel_item[3] == $_SESSION["id_us_session"]){
	$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]));			
		}else{
	$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
		}
	
	
	if($sel_item[6] == 6 and $sel_item[35] != ""){

$sel_item_obs = traer_fila_db(query_db("select CAST(ob_solicitud_adjudica AS text), CAST(ob_contrato_adjudica AS text), CAST(alcance_adjudica AS text), CAST(proveedores_sugeridos AS text), CAST(justificacion_adjudica AS text), CAST(recomendacion_adjudica AS text), CAST(destino_ots AS text), CAST(duracion_ots AS text), CAST(cargo_contable AS text),  CAST(justificacion_tecnica AS text), CAST(criterios_evaluacion AS text), CAST(conflicto_intereses AS text), DATALENGTH(objeto_solicitud), CAST(antecedentes_adjudicacion AS text), CAST(equipo_negociador AS text) from $pi2 where id_item=".$id_item_pecc));	
}else{
	//$sel_item_obs = traer_fila_db(query_db("select CAST(objeto_solicitud AS text), CAST(objeto_contrato AS text), CAST(alcance AS text), CAST(proveedores_sugeridos AS text), CAST(justificacion AS text), CAST(recomendacion AS text), CAST(destino_ots AS text), CAST(duracion_ots AS text), CAST(cargo_contable AS text),  CAST(justificacion_tecnica AS text) , CAST(criterios_evaluacion AS text), CAST(conflicto_intereses AS text) from $pi2 where id_item=".$id_item_pecc));

$variable_sql = "select CAST(objeto_solicitud AS TEXT), CAST(objeto_contrato AS text), CAST(alcance AS text), CAST(proveedores_sugeridos AS text), CAST(justificacion AS text), CAST(recomendacion AS text), CAST(destino_ots AS text), CAST(duracion_ots AS text), CAST(cargo_contable AS text),  CAST(justificacion_tecnica AS text) , CAST(criterios_evaluacion AS text), CAST(conflicto_intereses AS text), DATALENGTH(objeto_solicitud), CAST(antecedentes_permiso AS text), CAST(equipo_negociador AS text) from $pi2 where id_item=".$id_item_pecc;

$sel_item_obs = traer_fila_row(query_db($variable_sql));


//echo strlen($sel_item_obs[0])." - real: ".$sel_item_obs[12];

		}
	
	
	
	$sel_pecc = traer_fila_row(query_db("select $pi1.id_pecc,$pi1.ano,$pi1.objeto,$g1.nombre_administrador, $g10.valor, $pi1.nombre, $g10.id_trm from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	
	$edicion_datos_generales = "NO";
	if(verifica_permiso_pecc($sel_item[14], $sel_item[0]) == "SI" and ($sel_item[14] < 14 or $sel_item[14] == 31) and $sel_item[6] != 15){
			$edicion_datos_generales = "SI";
		}
		

		
		
	$es_profesional_designado = verifica_usuario_indicado(8,$sel_item[0]);
	
	if($sel_item[30] == 1){//si esta congelado
	$tiene_rol_profesional == "NO";
	}else{
	$tiene_rol_profesional = verifica_usuario_si_tiene_el_permiso(8);
	}
	
	if($sel_usu_emulan[0]>0 and ($sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
			$es_preparador = "SI";
		}
	
	/*
	echo "ID del proceso: ".$sel_item[0]."<br />";
	echo "ID Nivel de Servicio: ".$sel_item[2]."<br />";
	echo "ID Estado del Proceso: ".$sel_item[14]."<br />";
	echo "Es el Profesional designado ".$es_profesional_designado."<br />";
	echo "Tiene Permiso de Edicion ".$edicion_datos_generales."<br />";
	*/

	$activa_bodega = "NO";
	
	$sel_us_bodega = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 29"));
		if($sel_us_bodega[0]>0 and $sel_item[14] == 2){
			$activa_bodega = "SI";
		}
	$sel_us_revisa_sap = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 36"));
		if($sel_us_revisa_sap[0]>0 and $sel_item[14] > 19 and $sel_item[14] <> 31){
			$activa_revision_sap = "SI";
		}
		
	 //verifica si es administrador de ordenes de trabajo
$sel_si_es_administrador_de_ots = traer_fila_row(query_db("select * from v_seg1 where us_id =".$_SESSION["id_us_session"]." and id_premiso = 33"));
$es_admin_ot = "NO";
 if($sel_si_es_administrador_de_ots[0] > 0 and $id_tipo_proceso_pecc == 3){
	 $es_admin_ot = "SI";
 }
 
 //si es nanky

if((esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==7) or (esprofesionalcompras($id_item_pecc)=="SI" and $id_tipo_proceso_pecc == 3 and $sel_item[14]==16) or (esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[6]==11 and $sel_item[14]==16 )){
	 $edicion_datos_generales = "SI";
	 $edita_conflicto="SI";
	 }
	
	
	/*SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO*/

/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
if($sel_item[6]==16 and ($sel_item[14] <= 12) and $sel_item[23] == $_SESSION["id_us_session"]){
	$edicion_datos_generales = "SI";	
	}
/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/



	if($sel_item[14]!= 31){
		$permiso_mayor_creacion ="SI";
		}
	
	$busvca_tex = traer_fila_row(query_db("select CAST(p_oportunidad as TEXT), CAST(p_costo AS TEXT), CAST(p_calidad AS TEXT), CAST(p_optimizar AS TEXT), CAST(p_trazabilidad AS TEXT), CAST(p_transparencia AS TEXT), CAST(p_sostenibilidad AS TEXT) from t2_objetivos_proceso where id_item = ".$id_item_pecc));
	$p_oportunidad="";
	$p_costo="";
	$p_calidad="";
	$p_optimizar="";
	$p_trazabilidad="";
	$p_transparencia="";
	$p_sostenibilidad="";
	
		    if($busvca_tex[0]!="" and $busvca_tex[0]!=" " and $busvca_tex[0]!="  "){$p_oportunidad=$busvca_tex[0];}
			if($busvca_tex[1]!="" and $busvca_tex[1]!=" " and $busvca_tex[1]!="  "){$p_costo=$busvca_tex[1];}
			if($busvca_tex[2]!="" and $busvca_tex[2]!=" " and $busvca_tex[2]!="  "){$p_calidad=$busvca_tex[2];}
			if($busvca_tex[3]!="" and $busvca_tex[3]!=" " and $busvca_tex[3]!="  "){$p_optimizar=$busvca_tex[3];}
			if($busvca_tex[4]!="" and $busvca_tex[4]!=" " and $busvca_tex[4]!="  "){$p_trazabilidad=$busvca_tex[4];}
			if($busvca_tex[5]!="" and $busvca_tex[5]!=" " and $busvca_tex[5]!="  "){$p_transparencia=$busvca_tex[5];}
			if($busvca_tex[6]!="" and $busvca_tex[6]!=" " and $busvca_tex[6]!="  "){$p_sostenibilidad=$busvca_tex[6];}
			
	/*FIN SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO*/

$sel_si_es_soporte_abas = traer_fila_row(query_db("select count(*) from v_seg1 where id_premiso = 44 and us_id = ".$sel_item[23]));	


	 /*----------------- PERMISO PARA SERVICIOS MENORES ---------------------*/
$campos_no_habilita_en_completamiento="SI";
if($sel_item[6]==16 and $sel_item[14]!=31){
	$campos_no_habilita_en_completamiento="NO";
}
/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
	
	
	
/*validacion de anexos obligatorios*/
$falta_alguna_categoria = "NO";
$campos_falta = "";
$alertas_modal="";
$seleccione_categorias_obligatorias = query_db("select * from t1_categoria_anexos where obligatorio_permiso = 1 and estado = 1 and obligatorio_solicitante = 1 and t1_tipo_proceso = ".$sel_item[6]);
while($sel_ct_obligatorio = traer_fila_db($seleccione_categorias_obligatorias)){
	$busca_en_anexos = traer_fila_row(query_db("select count(*) from t2_anexo where t2_item_pecc_id = ".$id_item_pecc." and estado = 1 and id_categoria = ".$sel_ct_obligatorio[0]));
	if($busca_en_anexos[0]==0){
	$falta_alguna_categoria = "SI";
	$campos_falta.= " - ".$sel_ct_obligatorio[1];
	}
	}
	if($falta_alguna_categoria == "SI"){
		
		$alertas_modal = "* Por favor agregar en los anexos, los correspondientes a las categorías ".$campos_falta;

		}
/*validacion de anexos obligatorios*/	

$edita_info_ad_sm = "NO";
if($sel_item[14]==13 and $sel_item[6] == 16 and $sel_item[23] == $_SESSION["id_us_session"]){
	if($es_profesional_designado == "SI"){
	$edita_info_ad_sm = "SI";
	}
}

$sel_datos_sm_adjudica = traer_fila_row(query_db("select cast(ob_solicitud_adjudica as TEXT), cast(ob_contrato_adjudica as TEXT), cast(alcance_adjudica as text), cast(justificacion_adjudica as TEXT), cast(equipo_negociador as TEXT), cast(recomendacion_adjudica as text), tiene_reajuste from t2_item_pecc where id_item = ".$id_item_pecc));
	$objeto = $sel_datos_sm_adjudica[0];
	$objeto_orden_servicio = $sel_datos_sm_adjudica[1];
	$alcance = $sel_datos_sm_adjudica[2];
	$justificacion_adjudica = $sel_datos_sm_adjudica[3];
	$equipo_nego = $sel_datos_sm_adjudica[4];
	$recomendacion = $sel_datos_sm_adjudica[5];
	$tiene_reajustes = $sel_datos_sm_adjudica[6];

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?>
    
    </td>
  </tr>
  <tr>
    <td width="77%" valign="top">
    <?
	if($sel_item[0] ==8348 or $sel_item[0] ==8349 or $sel_item[0] ==8350 or $sel_item[0] ==8352 or $sel_item[0] ==8353 or $sel_item[0] ==8354 or $sel_item[0] ==8355 or $sel_item[0] ==8356 or $sel_item[0] ==8357 or $sel_item[0] ==8358 or $sel_item[0] ==8359 or $sel_item[0] ==8360 or $sel_item[0] ==8361 or $sel_item[0] ==8362 or $sel_item[0] ==8363  ){
	?>
    <iframe name="" src="../aplicaciones/pecc/info_permiso_pecc.php" width="100%" height="350px" frameborder="0"></iframe>
     <?
	}
	?>
    <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr >
        <td align="right"  class="letra-descuentos">Tipo de Solicitud:</td>
        <td colspan="2" class="letra-descuentos"><? echo traer_nombre_muestra($sel_item[4], $g11,"nombre","t1_tipo_contratacion_id");?></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr >
        <td align="right">Preparador:</td>
        <td colspan="2"><? echo traer_nombre_muestra($sel_item[36], $g1,"nombre_administrador","us_id");?></td>
        <td align="center">&nbsp;</td>
      </tr>
      
      <tr class="<?=$colum_clase1?>" >
        <td width="33%" align="right">
		
		<? if($id_tipo_proceso_pecc == 3) echo "Solicitante de la OT:"; else echo "Gerente del ITEM:";?></td>
        <td colspan="2">
		
		<? 
		if($es_preparador == "SI"){
			?>
			<select name="gerente_contra" id="gerente_contra">
          <option value="0">Seleccione el Gerente</option>
          <?
          $sel_usu_emula = query_db("select t1.us_id,t1.nombre_administrador from t1_us_usuarios as t1, t2_relacion_usuarios_emulan as t2 where t2.id_us_emula = t1.us_id and t2.id_us = ".$_SESSION["id_us_session"]);
		  while($sel_us_emu = traer_fila_row($sel_usu_emula)){
		  ?>
          <option value="<?=$sel_us_emu[0]?>" <? if($sel_us_emu[0] == $sel_item[3]) echo 'selected="selected"'?> ><?=$sel_us_emu[1]?></option>
          <?
		  }
		  ?>
          </select>
			<?
		}else{
		echo traer_nombre_muestra($sel_item[3], $g1,"nombre_administrador","us_id");
		?><input type="hidden" name="gerente_contra" id="gerente_contra" value="<?=$sel_item[3]?>" /><?
        }
		?>
        </td>
        <td width="29%" align="center">Fecha de Creaci&oacute;n:
          <?=$sel_item[22]?></td>
</tr>
        <?
		
if($id_tipo_proceso_pecc == 3){
		?>
        <tr class="<?=$colum_clase2?>" >
          <td align="right">Gerente de la OT:</td>
          <td colspan="2"><?
		  
		 
 
        if($edicion_datos_generales == "SI" and $es_admin_ot == "SI"){
		?>
        <input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?=$nombre_gerente_ot?>"/>
        <?
		}else{
			?> <input type="hidden" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?="es----,".$sel_item[42].""?>"/><?
			echo traer_nombre_muestra($sel_item[42], $g1,"nombre_administrador","us_id");
			}
		?></td>
          <td align="right">&nbsp;</td>
</tr>
        
        <?
		}else{//si no es una OT graba el mismo gerente de contrato
			?>
            <input type="hidden" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?=$sel_item[3]?>"/>
			<?
			}
        if($sel_item[1] != 1){
		?>
        <tr class="<?=$colum_clase2?>" >
        <td align="right">PECC</td>
        <td colspan="2">
        <?
        if($edicion_datos_generales == "SI"){
		?>
        <select name="id_pecc_seleccion" id="id_pecc_seleccion">
        
          <?=listas($pi1, " estado = 1 and ano <> 0",$sel_item[1] ,'ano', 3);?>
        </select>
       <?
		}else{
			echo saca_nombre_lista($pi1,$sel_item[1],'nombre','id_pecc');
			}
	   ?>
        </td>
        <td align="right">&nbsp;</td>
      </tr>
       <?
        }else{
	?><input type="hidden" name="id_pecc_seleccion" id="id_pecc_seleccion" value="1" /><?
	}
		
		
		?>
      
      <tr class="<?=$colum_clase3?>">
        <td align="right"><? 
		
		if($sel_si_es_soporte_abas[0] > 0){
			echo "Gestion Abastecimiento";
			}else{
		if($sel_item[4] == 2 or $sel_item[4] == 3 or $sel_item[4] == 4) echo "Comprador"; else echo "Profesional de Abastecimiento";
			}
		
		
		?>:</td>
        <td colspan="3">
          <?
		  /*
        if ($es_profesional_designado == "SI" and $edicion_datos_generales == "SI"){
		?>
          <select name="us_prof" id="us_prof">
            <option value="">Seleccione el Profesional de C&C Designado</option>
            <?
          $sel_profss = query_db("select us_id, nombre_administrador from $v_seg1 where id_premiso = 8  group by us_id, nombre_administrador");
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
            <option value="<?=$se_prof[0]?>" <? if( $sel_item[23] ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$se_prof[1]?></option>
            <?
		  }
		  ?>
            </select>
          <?
		}else{*/
		
		if(is_numeric($sel_item[23])) {   echo ver_si_tiene_reemplazo($sel_item[23]);  }
		
		//	echo saca_nombre_lista($g1,$sel_item[23],'nombre_administrador','us_id');
			
			//}
		?>
        <input type="hidden" name="us_prof" id="us_prof" value="<?=$sel_item[23]?>" />
        </td>
</tr>
  <?
  if(($sel_item[14]>=6 and $sel_item[14]!= 31) or es_profesional_cyc($_SESSION["id_us_session"]) == "SI" or $sel_item[56] > 1){
	  $edicion_datos_generales_pecc = "NO";

	  if(es_profesional_cyc($_SESSION["id_us_session"]) == "SI" and $edicion_datos_generales == "SI" and es_profesional_cyc($sel_item[36]) == "SI"){
		  $edicion_datos_generales_pecc = "SI";
		  }
  ?>      
  
  <tr class="columna_subtitulo_resultados">
  <td align="right">PECC de Origen de Esta Solicitud:</td>
  <td>
  
  <? if($edicion_datos_generales_pecc == "SI"){ ?>
  <select name="origen_pecc" id="origen_pecc" onchange="activa_linea_pecc(this.value)">
  <!-- <option value="">Seleccione el origen de PECC</option> -->
    <option value="1" <? if($sel_item[56] == 1) echo 'selected="selected"';?>>Ninguno</option>
     <?=solo_anos_actual($sel_item[56])?>
  </select>
  <?
  }else{
	  
	  if($sel_item[56]==0 or $sel_item[56]==1) echo "Ninguno"; else echo $sel_item[56];
	  
	  ?><input type="hidden" name="origen_pecc" id="origen_pecc" value="<?=$sel_item[56]?>" /><? }
  ?></td>
  <td colspan="2">&nbsp;</td>
  </tr>
  <?
  
  $oculata_no_aplica_pecc= 'style="display:none"';
  $oculta_modificacion_pecc = 'style="display:none"';
  $oculata_no_aplica_sub_categoria = 'style="display:none"';
  
if($sel_item[56] >1 ){//aplica PECC
	$oculata_no_aplica_pecc= '';
	}
if($sel_item[72] == 1){//si se modifico el PECC
	$oculta_modificacion_pecc = '';
	}
	
if($sel_item[71] > 0){//si se modifico el PECC
	$sel_si_tiene_sub = traer_fila_row(query_db("select count(*) from t1_lineas_pecc_sub where id_linea_pecc = ".$sel_item[71]." and estado = 1 and origen_pec=".$sel_item[56]));
	if($sel_si_tiene_sub[0]>0){
		 $oculata_no_aplica_sub_categoria = '';
		}
	}

	//subir arriba de los dos if cuando se pase a productivo
//	$oculata_no_aplica_pecc= 'style="display:none"';
 // $oculta_modificacion_pecc = 'style="display:none"';
  
  ?>
  <tr  class="columna_subtitulo_resultados" <?=$oculata_no_aplica_pecc;?> id="carga_liena_pecc" >
    <td align="right">L&iacute;nea de la Subcategor&iacute;a Registrada en el PECC:</td>
    <td>
    
<? if($edicion_datos_generales_pecc == "SI"){ ?>
        <select name="linea_pecc" id="linea_pecc" onchange="carga_detalle_subcategoria(this.value, '<?=$sel_item[0]?>')">
      <option value="0">Seleccione</option>
     
       <?
          $lineas_pecc = query_db("select * from t1_lineas_pecc as t1 where estado = 1 and origen_pec=".$sel_item[56]);
		  while($ln_pecc = traer_fila_row($lineas_pecc)){
		  ?>
          <option value="<?=$ln_pecc[0]?>" <? if($ln_pecc[0] == $sel_item[71]) echo 'selected="selected"'?> ><?=$ln_pecc[1]?> - <?=$ln_pecc[2]?></option>
          <?
		  }
		  ?>
          
      </select>
   
    <?
}else{
	if($sel_item[71] > 0){
	$sel_linea = traer_fila_row(query_db("select codigo, detalle from t1_lineas_pecc where id = '".$sel_item[71]."' and origen_pec=".$sel_item[56]));
	echo $sel_linea[0]." - ".$sel_linea[1];
	}
	?><input type="hidden" name="linea_pecc" id="linea_pecc" value="<?=$sel_item[71]?>" /><?
	}
	?>  
      
      </td>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr  class="columna_subtitulo_resultados" <?=$oculata_no_aplica_sub_categoria;?> id="id_fila_deallesubcategoria">
    <td align="right">Detalle de la Subcategor&iacute;a Registrada en el PECC:</td>
    <td>
     <div id="carga_detalle_subcategoria">  
    <table width="200" border="0">
    <?
	if($edicion_datos_generales_pecc == "SI"){
    $sel_si_tiene_sub = query_db("select id, codigo, nombre from t1_lineas_pecc_sub where id_linea_pecc = ".$sel_item[71]." and estado = 1 and origen_pec=".$sel_item[56]);
	}else{
		$sel_si_tiene_sub = query_db("select t1.id, t1.codigo, t1.nombre from t1_lineas_pecc_sub t1,t2_relacion_item_sub_linea_pecc t2  where t1.id = t2.id_sub_linea_pecc and t1.id_linea_pecc = ".$sel_item[71]." and t1.estado = 1 and id_item = ".$sel_item[0]." and t1.origen_pec=".$sel_item[56]);
		}
	while($sel_sub_lineas = traer_fila_db($sel_si_tiene_sub)){
		$check = "";
		$sel_sub_relacionadas = traer_fila_row(query_db("select count(*) from t2_relacion_item_sub_linea_pecc where id_item = ".$sel_item[0]." and id_sub_linea_pecc = ".$sel_sub_lineas[0]));
		if($sel_sub_relacionadas[0] >0){
			$check = "checked='checked'";
			}
	?>
      <tr>
        <td width="<? if($edicion_datos_generales_pecc == "SI") echo "20"; else echo "1"; ?>"><? if($edicion_datos_generales_pecc == "SI"){ ?><input name="linea_sub_<?=$sel_sub_lineas[0]?>" id="linea_sub_<?=$sel_sub_lineas[0]?>" type="checkbox" <?=$check?> value="<?=$sel_sub_lineas[0]?>" /><? } ?></td>
        <td width="170"><?=$sel_sub_lineas[1]?></td>
      </tr>
     <?
	}
	 ?>
    </table>
    </div>
    </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr  class="columna_subtitulo_resultados" <?=$oculata_no_aplica_pecc;?> id="carga_modificacion_pecc">
    <td align="right">Requiere Modificaci&oacute;n:</td>
    <td>
    <? if($edicion_datos_generales_pecc == "SI"){ ?>
    <select name="pecc_modificado" id="pecc_modificado" onchange="activa_filas_modifiaciones(this.value)">
      <option value="0" >Seleccione si la linea del PECC fue modificada</option>
      <option value="2" <? if($sel_item[72] == 2) echo 'selected="selected"'?>>NO</option>
      <option value="1" <? if($sel_item[72] == 1) echo 'selected="selected"'?>>SI</option>
    </select>
    <?
}else{
	if($sel_item[72] == 1) echo "SI";
	if($sel_item[72] == 2) echo "NO";
	?><input type="hidden" name="pecc_modificado" id="pecc_modificado" value="<?=$sel_item[72]?>" /><?
	}
	?>  
    </td>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr class="columna_subtitulo_resultados" <?=$oculta_modificacion_pecc?> id="carga_observacion_modifica_pecc">
    <td align="right">Justificaci&oacute;n  de la Modificaci&oacute;n <img src="../imagenes/botones/help.gif" alt="Cu&aacute;l es la raz&oacute;n de la modificaci&oacute;n?" title="Cu&aacute;l es la raz&oacute;n de la modificaci&oacute;n?" width="20" height="20" /></td>
    <td colspan="3">
    <?
    $sel_item_relacionado_ob_modifica = traer_fila_row(query_db("select CAST(pecc_modificado_observacion AS TEXT) from $pi2 where id_item=".$sel_item[0]));
	?>
    <input name="pecc_id_sol_modifica" type="hidden" id="pecc_id_sol_modifica" size="25" value="<?=$sel_item[74]?>"/>
    
    <? if($edicion_datos_generales_pecc == "SI"){ ?>
      <textarea name="pecc_observacion_modificacion" id="pecc_observacion_modificacion" cols="45" rows="5"><?=$sel_item_relacionado_ob_modifica[0]?></textarea>
       <?
}else{
	echo nl2br($sel_item_relacionado_ob_modifica[0]);
	?><input type="hidden" name="pecc_observacion_modificacion" id="pecc_observacion_modificacion" value="<?=$sel_item_relacionado_ob_modifica[0]?>" /><?
	}
	?>  
    
    
    </td>
  
<?
  }else{
	  ?><input type="hidden" name="origen_pecc" id="origen_pecc" value="<?=$sel_item[56]?>" />
	  <input type="hidden" name="linea_pecc" id="linea_pecc" value="<?=$sel_item[71]?>" />
	  <input type="hidden" name="pecc_modificado" id="pecc_modificado" value="<?=$sel_item[72]?>" />
	  <input type="hidden" name="pecc_observacion_modificacion" id="pecc_observacion_modificacion" value="<?=$sel_item_relacionado_ob_modifica[0]?>" /><?
	  }
	  



if (($sel_item[6] == 2 or $sel_item[6] == 5 or $sel_item[6] == 7) and $es_profesional_designado == "no aplica"){
?>



<tr class="<?=$colum_clase5?>">
<td align="right">Requiere  Sondeo:</td>
<td colspan="3">
<?
if($edicion_datos_generales == "SI"){
?>
<select name="req_sondeo" id="req_sondeo">
<option value="2" <? if($sel_item[25] == 2) echo 'selected="selected"'?>  >NO</option>
<option value="1" <? if($sel_item[25] == 1) echo 'selected="selected"'?>>SI</option>

</select>
<?
}else{
if($sel_item[25] == 2) echo "NO";
if($sel_item[25] == 1) echo "SI";
			}
		  ?>
          </td>
      </tr>
        <?
			}
if (($sel_item[6] == 2 or $sel_item[6] == 5 or $sel_item[6] == 6) and $es_profesional_designado == "SI" ){//and $auno_noaplica == "borrar este fracmento del if"
	$tipo_campo_sondeo = "hidden";
	if($sel_item[75] > 0){
		$tipo_campo_sondeo = "text";
		}
		
		

		?>
       
        <tr>
          <td align="right">Relacione el n&uacute;mero de Sondeo de Mercado:</td>
          <td colspan="2"><?
if($edicion_datos_generales == "SI"){
	?><strong style="cursor:pointer" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/pecc/busca_sondeos_urna.php","div_carga_busca_sol")' >Buscar sondeos para relacionar a esta solicitud <img src="../imagenes/botones/aler-interro.gif" width="3"/></strong> <?
	
?><input name="llena_lista_sondeos_l" type="hidden" id="llena_lista_sondeos_l" size="50" value="<?=$sel_item[75]?>" />
<input name="llena_lista_sondeos_2" type="<?=$tipo_campo_sondeo?>" readonly="readonly" id="llena_lista_sondeos_2" size="50" value="<?=$sel_item[76]?>"/>

<?
}else{
?>
<input name="llena_lista_sondeos_l" type="hidden" id="llena_lista_sondeos_l" size="50" value="<?=$sel_item[75]?>" />
<input name="llena_lista_sondeos_2" type="hidden" readonly="readonly" id="llena_lista_sondeos_2" size="50" value="<?=$sel_item[76]?>"/>
<?
echo $sel_item[76];
			}
		  ?>
          
          </td>
          <td><strong class="letra-descuentos"><?

if($edicion_datos_generales == "SI" and ($sel_item[75] == "" or $sel_item[75] == 0 )){
	if($sel_item[6] == 5){
		echo "Recuerde que usted puede relacionar un sondeo de mercado";
		}else{
			echo "Debe relacionar el numero del sondeo que se manejo en la urna virtual";
			}
?><? }?></strong></td>
        </tr>
        <?


}
		?>
        <tr>
        <td align="right">Proceso Especial o Anticipo, Requiere Aprobaci&oacute;n Extra del Comit&eacute;<img src="../imagenes/botones/help.gif" alt="Seleccione 'SI' si desea que este item vaya al comit&eacute;" title="Seleccione 'SI' si desea que este item vaya al comit&eacute;" width="20" height="20" /></td>
        <td width="31%">
        <?
        
		$sel_si_es_comite = traer_fila_row(query_db("select COUNT(*) from t2_nivel_servicio, t2_nivel_servicio_tiempos where t2_nivel_servicio.t2_nivel_servicio_id = t2_nivel_servicio_tiempos.t2_nivel_servicio_id and t2_nivel_servicio.t2_nivel_servicio_id = '".$sel_item[2]."' and t2_nivel_servicio_tiempos.t2_nivel_servicio_actividad_id in (8,17)"));
		
		if($sel_si_es_comite[0] > 0 and ($sel_item[24] == 2 or $sel_item[24] == 3)){
			echo "Esta solicitud debe ir a comit&eacute; obligatoriamente";
			?><input type="hidden" name="req_comite" id="req_comite" value="2" /><?
			}else{
		
		if($edicion_datos_generales == "SI"){
		?>
        <select name="req_comite" id="req_comite">
          	<option value="2" <? if($sel_item[24] == 2) echo 'selected="selected"'?>  >NO</option>
            <option value="1" <? if($sel_item[24] == 1) echo 'selected="selected"'?>>SI</option>
            
          </select>
          <?
		}else{
			if($sel_item[24] == 2) echo "NO";
			if($sel_item[24] == 1) echo "SI";
			}
			}
			
		  ?>
          </td>
        <td colspan="2"><?
        $sel_si_tiene_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc));
			if($sel_si_tiene_presu[0]<=0){
			echo  "<span class='letra-descuentos'>ALERTA: Para poder ingresar la aprobacion extra de comit&eacute; se debe ingresar el presupuesto, SGPA tambien recibe valores en cero (0)</span>";
            
			}
		?></td>
        </tr>
      <?
			
	  ?>
      <tr>
        <td align="right">Tipo de Proceso<img src="../imagenes/botones/help.gif" alt="Indica el tipo de proceso que utilizara para la solicitud." title="Indica el tipo de proceso que utilizara para la solicitud." width="20" height="20" /></td>
        <td colspan="3">
        
        
        <?
			
			if($sel_item[85] == "SI" and $sel_item[6]!=16){
			echo "<span class='letra-descuentos'> Este proceso naci&oacute; como Servicio Menor</span><br />";
			}
		
        	if(($sel_item[6] <> 8) and ($sel_item[6] <> 7) and $edicion_datos_generales == "SI" or ($sel_item[6] == 16 and $sel_item[14] == 13 and $edita_info_ad_sm == "SI")){
				
				if($sel_item[4]<>2 and $sel_item[4]<>3 and $sel_item[4]<>4){
					$funti = 'onchange="valida_tipo_proceso_edicion(this)"';
					
				}
		
		if($sel_item[6] == 16){//es solo para saber si alguna vez fue SM asi solo habilita las opciones de NG y SM
						$update = query_db("update t2_item_pecc set fue_sm = 'SI' where id_item= ".$sel_item[0]);
			}
		?>
          <select name="tipo_proceso" id="tipo_proceso"  <?=$funti ?>>
            <?
			$quita_pone_adjudica_directo = "6,";
            if($tiene_rol_profesional == "SI"){
				$quita_pone_adjudica_directo = "";
				}
			?>
            
            <? 
			
			if($sel_item[4]==2 or $sel_item[4]==3 or $sel_item[4]==4){
			echo listas($g13, " estado = 1 and t1_tipo_proceso_id  not in (".$quita_pone_adjudica_directo." 7, 8, 5, 15, 12, 16)",$sel_item[6] ,'nombre', 1);	
			?><option value="8">Contrato Marco / Lista de Precios</option><?
				}else{
					if($sel_item[85] == 'SI'){//si alguna vez a sido SM
						echo listas($g13, " estado = 1 and t1_tipo_proceso_id in (2, 16, 6, 2, 5)",$sel_item[6] ,'nombre', 1);
						}else{
							echo listas($g13, " estado = 1 and t1_tipo_proceso_id not in (".$quita_pone_adjudica_directo." 7,8, 15)",$sel_item[6] ,'nombre', 1);
						}
				}
			?>
            
            
           
          </select>
          
          
          
        <?
			}else{
				if($sel_item[6] == 8 and $sel_item[4] <> 1){
				echo "Orden de Pedido Contrato Marco/Lista de Precios";
				}else{
				echo saca_nombre_lista($g13,$sel_item[6],'nombre','t1_tipo_proceso_id',$sel_item[0]);	
					}
				if($sel_item[6] == 7 or $sel_item[6] == 8){
					
						$sel_item_ot_apl = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[26]));
						
						echo "<strong> de la solicitud: ".numero_item_pecc($sel_item_ot_apl[0],$sel_item_ot_apl[1],$sel_item_ot_apl[2])." </strong>";
					}
				}
				
				if($sel_item[56] > 1 and ($sel_item[14] == 31 or $sel_item[14] == 6 ) ){
					if($sel_item[72] == 1 or $sel_item[65] == 1){
						echo "<strong class='letra-descuentos'> Esta solicitud de PECC requiere firmas seg&uacute;n nivel de aprobaci&oacute;n</strong>";
						}else{
					$sel_estado_resultado_pecc = traer_fila_row(query_db("select t2.nombre from t1_estado_resultado_pecc t1, t2_nivel_servicio_actividades t2 where id_tipo_proceso = ".$sel_item[6]." and t1.id_actividad_resultado = t2.id"));
					echo " <div id='estado_resultado_pecc'><strong class='letra-descuentos'> Estado en el que quedar&aacute; la solicitud: ".$sel_estado_resultado_pecc[0]."</strong></div>";
						}
					}
		?>  
          </td>
      </tr>
      <tr>
      			<td colspan="" align="right"></td>
      			<td colspan="2" align="right">
      <?
      	if($sel_item[6]==7 and ($sel_item[14]<20 or $sel_item[14] ==31)){//PARA EL INC-009 2017 SI ES AMPLIACIÓN CONTRATO MARCO
      		if($sel_item[14]<20){/*
	      		$tabla='';
				$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
				if($id_contras == ""){
				$id_contras = "0";
				}
					$cont=0;
				while($sel_presu = traer_fila_db($sele_presupuesto)){
				//echo"select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id, t2.vigencia_mes from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." and t2.id not in ($id_contras) group by t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id, t2.vigencia_mes order by t2.id asc <br><br>";
				$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id, t2.vigencia_mes from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." and t2.id not in ($id_contras) group by t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id, t2.vigencia_mes order by t2.id asc");
				//if($_SESSION["id_us_session"] == 32 ){ echo "select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." and t2.id not in ($id_contras) group by t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id order by t2.id asc";}
					while($sel_apl = traer_fila_db($sel_contr)){
						
						if($cont == 0){
						  	$clase= "filas_resultados";
							$cont = 1;
						}else{
						  	$clase= "";
							$cont = 0;
						}
						$id_contras = $id_contras.",".$sel_apl[4];
						
						if($id_contra_bandera == ""){
							$id_contra_bandera=$sel_apl[4];
							$entra_bandera = 1;
						}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
							}else{
								$entra_bandera = 2;
							}
						}

						$numero_contrato1 = "C";			
						$separa_fecha_crea = explode("-",$sel_apl[1]);
						$ano_contra = $separa_fecha_crea[0];
						
						$numero_contrato2 = substr($ano_contra,2,2);
						$numero_contrato3 = $sel_apl[0];
						$numero_contrato4 = $sel_apl[2];
							
							if($entra_bandera == 1){
								$num_contrato=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4]);
								$query="Select count(*) from $co14 where t7_contrato_id= $sel_apl[4] and t2_item_id=$sel_item[0]";
								$total=traer_fila_row(query_db("Select count(*) from $co14 where t7_contrato_id= $sel_apl[4] and t2_item_id=$sel_item[0]"));
								if($total[0]==0){
									$query="INSERT INTO $co14(numero_contrato, vigencia, t7_contrato_id, t2_item_id) VALUES ('$num_contrato', '$sel_apl[5]', $sel_apl[4], $sel_item[0])";
									$result=query_db($query);
								}else{
									$query="UPDATE $co14 SET vigencia='$sel_apl[5]' WHERE t7_contrato_id= $sel_apl[4] and t2_item_id=$sel_item[0]";
									$result=query_db($query);
								}
							$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));
							$caontras_rel.= "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4])." </strong> ".$sel_contratista[0]." ";

							$tabla=$tabla.'<tr class="'.$clase.'">
							<td width="50%" align="right">'.numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4]).'</td>
	      						<td width="50%" align="left">'.$sel_apl[5].'</td></tr>';
							}
					}
				}
			*/}
      	?>
      		
                
                <?	
				
      			$vigencia_ampliaciones='<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      					<tr><td colspan="2" align="center"  class="fondo_3">Vigencia de Contratos Relacionados</td></tr>';
  										
					$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and ($pi8.al_valor_inicial_para_marco is null or $pi8.al_valor_inicial_para_marco =0)");
					$ids_contratos_relas = "0";
					  while($sel_apl = traer_fila_db($sele_presupuesto)){

					$sel_contr = traer_fila_row(query_db("select t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_apl[0]));
					$ids_contratos_relas.= ",".$sel_contr[0];
						}
						
					$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id, t2.vigencia_mes from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2.id in (".$ids_contratos_relas.") group by t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id, t2.vigencia_mes");
					
  						$cont=0;
  						while($sel_apl = traer_fila_db($sel_contr)){
  							if($cont == 0){
							  	$clase= "filas_resultados";
								$cont = 1;
							}else{
							  	$clase= "";
								$cont = 0;
							}
							
							

							$numero_contrato1 = "C";			
							$separa_fecha_crea = explode("-",$sel_apl[1]);
							$ano_contra = $separa_fecha_crea[0];
							
							$numero_contrato2 = substr($ano_contra,2,2);
							$numero_contrato3 = $sel_apl[0];
							$numero_contrato4 = $sel_apl[2];

					$vigencia_ampliaciones.='
							
							<tr class="'.$clase.'">
								<td align="center">'.numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[3]).'</td>
								<td align="center">'.$sel_apl[4].'</td>
							</tr>';
  						}
  					
      			$vigencia_ampliaciones.='	</table>';
			?>
      
			
      	<?
		echo $vigencia_ampliaciones;
	$uodate_terminacion = query_db("update t2_item_pecc set vencimiento_contrato = '".$vigencia_ampliaciones."' where id_item = ".$sel_item[0]);									
	//echo "<br /><br />".$sel_item[70];
        }elseif($sel_item[6]==7){
				$sel_vencimiento_ampli = traer_fila_row(query_db("select CAST(vencimiento_contrato AS text) from t2_item_pecc where id_item = ".$sel_item[0]));
			echo $sel_vencimiento_ampli[0];
			//echo 'aba';

			
			}else{
				
				}//PARA EL INC-009 2017 SI ES AMPLIACIÓN CONTRATO MARCO
      ?>
      </td>
      		</tr>
      <?
      if(($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 13 or $sel_item[6] == 14) and $sel_item[49]==1){// solo se muestra para los procesos que ya se les selecciono que si aplica.

	  ?>
     
      <tr class="columna_subtitulo_resultados">
        <td align="right">Seleccione si Desea que Este Otro Si Convierta el Contrato a Marco <img src="../imagenes/botones/aler-interro.gif" height="15"/> <img src="../imagenes/botones/help.gif" alt="Si selecciona que si, debera incluir el valor disponible para crear OTs" width="20" height="20"  title="Si selecciona que si, debera incluir el valor disponible para crear OTs"/></td>
        <td colspan="3"><div id="contra_otro_si_convierte_marco">
        <?
        if($edicion_datos_generales == "SI"){
		?>
        <input type="hidden" name="conbierte_a_marco" id="conbierte_a_marco" value="2"  />
       NO
        <?
		}else{
			if($sel_item[49]==1) echo 'SI'; else echo "NO";
			}
		?>
        
        </div></td>
      </tr>
        
            <?
	  }
      if(($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 11 or $sel_item[6] == 12 or $sel_item[6] == 10 or $sel_item[6] == 15)){

	  ?>

      <tr>
        <td align="right">Contrato Relacionado:</td>
        <td colspan="3"><div id="contra_otro_si">  
          <? if($edicion_datos_generales == "SI"){
		$select_contra = traer_fila_row(query_db("select  id , razon_social, nit, numero_contrato, apellido, consecutivo,ano, vigencia_mes  from $v_contra1  where id = ".$sel_item[21]));
		
		$fecha_hoy = date("Y-m-d");
		$fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			$mensaje_alerta="";

			if($select_contra[7] <= $fecha_vence){
				$mensaje_alerta = " * Este Contrato esta Proximo a Vencer ".$select_contra[7]." * ";
				}
		
				$numero_contrato = numero_item_pecc_contrato("C",$select_contra[6],$select_contra[5], $select_contra[4], $select_contra[0]);
				
				$nombr_contrta = "-".$numero_contrato." Contratista: ".$select_contra[1]."----,".$select_contra[0]."----,".$mensaje_alerta;
				
				if($select_contra[5]==""){
					
					$nombr_contrta="";
					}
					
					if($sel_item[69]==1 or $sel_item[43]==0 or $sel_item[6]==12){
						if($sel_item[6]==11 or $sel_item[6]==12){							
							$completa_auto="infomativo";
							}
							
				
						
						
		?>
    <table width="100%"><tr><td width="56%">

    <input name="contratos_normales" type="text" id="contratos_normales" size="25"  onkeypress="selecciona_lista('<?=$completa_auto?>')" value="<?=$nombr_contrta?>"/>
    
    </td>
    <td width="44%">
    <?
     if(($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 11 or $sel_item[6] == 12 or $sel_item[6] == 10 or $sel_item[6] == 15)){
		 
	?>
    <span onclick="pone_datos_contrato_edicion(document.principal.contratos_normales.value)">Cargar Informaci&oacute;n del Contrato <img src="../imagenes/botones/2.gif"  /></span>
    
    <img src='../imagenes/botones/eliminada_temporal.gif' onClick='valida_tipo_proceso(11)' />
    
    <?
	if($sel_item[21] > 0){
			  echo "<br />".$imprimir_de_funcion = vencimieno_contratos($sel_item[0], 2);
			  if($sel_item[14] < 20){
	$uodate_terminacion = query_db("update t2_item_pecc set vencimiento_contrato = '".$imprimir_de_funcion."' where id_item = ".$sel_item[0]);									
											}else{
												echo $sel_item[70];
												}
		 		 }
	 }
	?>
    </td></tr></table>
    
    <?
					}else{
						?><input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value=""/><?
						}
		  }else{
			  
			  
			  $select_contra = traer_fila_row(query_db("select  id , razon_social, nit, numero_contrato, apellido, consecutivo,ano  from $v_contra1  where id = ".$sel_item[21]));
			  
			  
				$numero_contrato = numero_item_pecc_contrato("C",$select_contra[6],$select_contra[5], $select_contra[4], $select_contra[0]);
				if($sel_item[21]>0){
				echo $numero_contrato." Contratista: ".$select_contra[1];
				}else if($sel_item[52]>0){
					echo saca_nombre_lista("t1_proveedor",$sel_item[52],'razon_social','t1_proveedor_id',0);
					}else{
						echo "";
						}
				
				
			  ?><input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value="<?=$sel_item[21]?>"/><?
			  if($sel_item[21] > 0 and $sel_item[14] < 20){
			  
				  echo $imprimir_de_funcion = vencimieno_contratos($sel_item[0], 2);
	$uodate_terminacion = query_db("update t2_item_pecc set vencimiento_contrato = '".$imprimir_de_funcion."' where id_item = ".$sel_item[0]);									
											}else{
												echo $sel_item[70];
												}
		 		}
			  
	?>

</div></td>
      </tr>
      <?
      }else{
				
				?><input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value="0"/><?
				
				}
		if($sel_item[6]!=12){
				
	  ?>
      <tr class="columna_subtitulo_resultados">
        <td align="right">Solicitud Relacionada:</td>
        <td colspan="3"><div id="informativo_solicitud">
        <?
        if($sel_item[6]==11 or $sel_item[6]==15 or $sel_item[49]==3 or $sel_item[69]==1){
			if($edicion_datos_generales == "SI" and $select_contra[5]==""){
				if($sel_item[43]>0 and $sel_item[69]==1){
				$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[43]));
				echo "<font color ='#ff0000'> Atenci&oacute;n: Esta solicitud es una modificaci&oacute;n a la solicitud ".numero_item_pecc($sel_item_relacionado[0],$sel_item_relacionado[1],$sel_item_relacionado[2])."</font>";
				}else{
		?>
        <strong class="windowPopup" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/pecc/busca-solicitudes.php","div_carga_busca_sol")'>Buscar solicitud para relacionar a este informativo <img src="../imagenes/botones/aler-interro.gif" width="3"/></strong> <span id="solicitud_relacionada_actual">
        <?
        
			if($sel_item[43]>0){
				$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[43]));
				echo "<font color ='#ff0000'> - Actualmente esta relacionada la Solicitud ".numero_item_pecc($sel_item_relacionado[0],$sel_item_relacionado[1],$sel_item_relacionado[2])."</font><img src='../imagenes/botones/eliminada_temporal.gif' onClick='valida_tipo_proceso(11)' />";
				}
				}
		?>
        
        </span>
        <?
		}else{
			if($sel_item[43]>0 and $sel_item[69]!=1){
				$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[43]));
				echo numero_item_pecc($sel_item_relacionado[0],$sel_item_relacionado[1],$sel_item_relacionado[2]);
			}elseif($sel_item[43]>0 and $sel_item[69]==1){
				//se modifica para el des066
				/*$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[43]));
				echo "<font color ='#ff0000'> Atenci&oacute;n: Esta solicitud es una modificaci&oacute;n a la solicitud ".numero_item_pecc($sel_item_relacionado[0],$sel_item_relacionado[1],$sel_item_relacionado[2])."</font>";*/
				$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3, id_item from $pi2 where id_item=".$sel_item[43]));
				echo "<font color ='#ff0000'> Atenci&oacute;n: Esta solicitud es una modificaci&oacute;n a la solicitud <a onclick='document.getElementById(&quot;carga_modal_pecc&quot;).style.display=&quot;block&quot;;ajax_carga(&quot;../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$sel_item_relacionado[3]."&id_tipo_proceso_pecc=1&tipo_carga=99&quot;,&quot;carga_modal_pecc&quot;)' style='cursor:pointer;' > ".numero_item_pecc($sel_item_relacionado[0],$sel_item_relacionado[1],$sel_item_relacionado[2])." </a></font>";
				}
			}
		}
		?>
        
        </div></td>
      </tr>
      <?
	  }
      if($sel_item[4] == 2 or $sel_item[4] == 3 or $sel_item[4] == 4){
	  ?>
      <tr>
        <td align="right">Número de SolPed:</td>
        <td colspan="3">
        <?
        if($activa_bodega == "SI" or (($sel_item[4] == 4 or $sel_item[4] == 3) and ($sel_item[14]==31 or $sel_item[14]==6))){
		?>
        <input type="text" name="num_solped" id="num_solped" value="<?=$sel_item[37]?>" />
        <?
				}else{
					echo $sel_item[37];
					?>
					<input type="hidden" name="num_solped" id="num_solped" value="<?=$sel_item[37]?>" />
                    <?
					}
		?>
        </td>
      </tr>
      <?
				}
	  ?>
      <tr>
        <td align="right">&Aacute;rea Usuaria<img src="../imagenes/botones/help.gif" alt="&aacute;rea de este proceso." width="20" height="20"  title="&aacute;rea de este proceso."/></td>
        <td colspan="3">
        <?
if($edicion_datos_generales == "SI"){
//$sel_suario_gerente_ot 

$usuario_para_traer_areas=$_SESSION["id_us_session"];


if($sel_item[3] <> "" and $sel_item[3] <> 0){
	$usuario_para_traer_areas = $sel_item[3];
	}
	
if($sel_suario_gerente_ot[0] <> "" and $sel_suario_gerente_ot[0] <> 0){
	$usuario_para_traer_areas = $sel_suario_gerente_ot[0];

	}


if($id_tipo_proceso_pecc <> 3){
	
?>
       <div id="area_usuaria_div">
        <select name="area_usuaria" id="area_usuaria">
          <?
	  $verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 8 and us_id =".$usuario_para_traer_areas));
if($verifica_permiso[0]>0){
	echo listas($g12, " estado = 1",$sel_item[5] ,'nombre', 1);
}else{
      $sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$usuario_para_traer_areas." and t1.estado = 1");
	  while($sel_a_usuario = traer_fila_db($sel_areas)){
	  ?>
      <option value="<?=$sel_a_usuario[0]?>" <? if($sel_item[5] == $sel_a_usuario[0]) echo 'selected="selected"'?> ><?=$sel_a_usuario[1]?></option>
      <?
      }
	  
}
	  ?>
        </select>
        
        </div>
  <?
}else{

	?>
	<select name="area_usuaria" id="area_usuaria">
          <?
		  	if($id_tipo_proceso_pecc == 3 and $sel_item[4]==1){//Si es ORden de trabajo a contrato marco***************
			
			/*------------------------PARA QUE FUNCIONE DEBE TENER UN CONTRATO RELACIONADO EN EL VALOR------------------------*/

$sel_contrato_del_presupuesto = traer_fila_row(query_db("SELECT dbo.t2_presupuesto_aplica_contrato.t7_contrato_id FROM dbo.t2_presupuesto INNER JOIN dbo.t2_presupuesto_aplica_contrato ON dbo.t2_presupuesto.t2_presupuesto_id = dbo.t2_presupuesto_aplica_contrato.t2_presupuesto_id WHERE (dbo.t2_presupuesto.t2_item_pecc_id = ".$id_item_pecc.")"));
$id_gerente=traer_fila_row(query_db("SELECT DISTINCT gerente FROM $co1 WHERE id=".$sel_contrato_del_presupuesto[0]));


                    $area_default="";
                    $area_default2="";
                    $contador=0;
                    $sel_v_usuario_area="SELECT * FROM $v_contra3 WHERE id_usuario=".$id_gerente[0];
                    $usuario_area=query_db($sel_v_usuario_area);
                    while($area=traer_fila_row($usuario_area)){//selecciona todas la areas del gerente de contrato
                        $area_default=$area_default."'".$area[2]."'";
                    }
                    $busca_area_pecc=query_db("SELECT * FROM tabla_contrato_area($id_item_contra_marco_relacionado)");
                    while($area=traer_fila_row($busca_area_pecc)){//Selecciona las areas de las solicitudes relacionadas
                        $area_default=$area_default."'".$area[0]."'";
                      }
					  
					  
					 $sel_area_confi_ger="SELECT * FROM $v_contra4 WHERE estado=1 AND id_contrato=".$sel_contrato_del_presupuesto[0]." ORDER BY NOMBRE ASC";
					$area_confi_g=query_db($sel_area_confi_ger);
					while($area=traer_fila_row($area_confi_g)){//Selecciona las areas configuradas por el gerente de contrato
					 $area_default=$area_default."'".$area[2]."'";
					}
                   if ($area_default!=""){
                        $area_default=str_replace("''", ", ", $area_default);
                        $area_default=str_replace("'", "", $area_default);
                    }
                    $sel_v_usuario_area="SELECT * FROM $v_contra3 WHERE id_usuario=".$usuario_para_traer_areas." AND id_area IN($area_default)";
                    $usuario_area=query_db($sel_v_usuario_area);
                    while($area=traer_fila_row($usuario_area)){//Busca las areas del gerente de ot / solicitante
                        $contador=$contador+1;
                        ?> <option value="<?=$area[2]?>" <? if($area[2] == $sel_item[5]) echo 'selected="selected"'?> ><?=$area[3] ?></option><?
                    }//FIN WHILE USUARIO_AREA
					
                                        if($contador==0){//SI EL USUARIOI NO PERTENECE A LAS AREAS ASSIGNADAS A LA SOLICITUD  ?>
                        <option value='0'>No Tiene Ninguna Area Relacionada para este contrato</option>
                <?  }//SI EL USUARIOI NO PERTENECE A LAS AREAS ASSIGNADAS A LA SOLICITUD
				//FIN Si es ORden de trabajo a contrato marco*************************
				
				}else{
		  
		  $sel_areas_contra_inicial = traer_fila_row(query_db("select t1.t1_area_id,t1.nombre from $g12 as t1, t2_item_pecc as t2  where t1.t1_area_id = t2.t1_area_id and  t2.id_item = ".$sel_item[26]." group by t1.t1_area_id,t1.nombre"));

					$areas_aplica_ot = $sel_areas_contra_inicial[0];
					
					/*SELECCIONAR SI EL USUARIO LOGUEADO ES UN GERENTE DE LOS CONTRATOS RELACIONADOS.*/
					
					$sel_si_gerente = traer_fila_row(query_db("select count(*) from  t7_contratos_contrato where id_item = ".$sel_item[26]." and gerente = '".$usuario_para_traer_areas."'"));
					if($sel_si_gerente[0]>0){
						$sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$usuario_para_traer_areas." and t1.estado = 1");
                    while($sel_a_usuario = traer_fila_db($sel_areas)){//selecciona las areas del gerente de contrto
						$areas_aplica_ot = $areas_aplica_ot.",".$sel_a_usuario[0];
						}
						}
					/*SELECCIONAR SI EL USUARIO LOGUEADO ES UN GERENTE DE LOS CONTRATOS RELACIONADOS.*/
					
					
				  if( $sel_areas_contra_inicial[0] == 16){							
						$areas_aplica_ot = $areas_aplica_ot.",40,41";						                   
                        $no_in = " and t1.t1_area_id not in (40,41)";
                  }elseif($areas_aplica_ot == 24){
 					    $areas_aplica_ot = $areas_aplica_ot.",34";						                   
                        $no_in = " and t1.t1_area_id not in (34)";
			  	  }elseif($areas_aplica_ot == 25 or $areas_aplica_ot == 20){
		   			   $areas_aplica_ot = $areas_aplica_ot.",35";						                   
                        $no_in = " and t1.t1_area_id not in (35)";
				  }elseif($areas_aplica_ot == 22 or $areas_aplica_ot == 26 or $areas_aplica_ot == 32){
					  $areas_aplica_ot = $areas_aplica_ot.",36";						                   
                        $no_in = " and t1.t1_area_id not in (36)";
				  }elseif($areas_aplica_ot == 6){
					  $areas_aplica_ot = $areas_aplica_ot.",37";						                   
                        $no_in = " and t1.t1_area_id not in (37)";				  
				  }elseif($areas_aplica_ot == 21 or $areas_aplica_ot == 29){
					  $areas_aplica_ot = $areas_aplica_ot.",38";						                   
                        $no_in = " and t1.t1_area_id not in (38)";
				  }elseif($areas_aplica_ot == 12){
				  		$areas_aplica_ot = $areas_aplica_ot.",39";						                   
                        $no_in = " and t1.t1_area_id not in (39)";
				  }elseif($areas_aplica_ot == 17){
					  $areas_aplica_ot = $areas_aplica_ot.",40";						                   
                        $no_in = " and t1.t1_area_id not in (40)";
				  }elseif($areas_aplica_ot == 18){
					  $areas_aplica_ot = $areas_aplica_ot.",41";						                   
                        $no_in = " and t1.t1_area_id not in (41)";
				  }elseif($areas_aplica_ot == 1){
					  $areas_aplica_ot = $areas_aplica_ot.",44";						                   
                        $no_in = " and t1.t1_area_id not in (44)";
				  }elseif($areas_aplica_ot == 31){
				  		$areas_aplica_ot = $areas_aplica_ot.",46";						                   
                        $no_in = " and t1.t1_area_id not in (46)";
				 }elseif($areas_aplica_ot == 13){
					   $areas_aplica_ot = $areas_aplica_ot.",47";						                   
                        $no_in = " and t1.t1_area_id not in (47)";
				  }elseif($areas_aplica_ot == 7){
					  	$areas_aplica_ot = $areas_aplica_ot.",48";						                   
                        $no_in = " and t1.t1_area_id not in (48)";
				  }elseif($areas_aplica_ot == 8){
					  	$areas_aplica_ot = $areas_aplica_ot.",49";						                   
                        $no_in = " and t1.t1_area_id not in (49)";
				  }elseif($areas_aplica_ot == 5){
				  		$areas_aplica_ot = $areas_aplica_ot.",55";						                   
                        $no_in = " and t1.t1_area_id not in (55)";
				  }elseif($areas_aplica_ot == 14){
				  		$areas_aplica_ot = $areas_aplica_ot.",50";						                   
                        $no_in = " and t1.t1_area_id not in (50)";
				  }elseif($areas_aplica_ot == 53){
				  		$areas_aplica_ot = $areas_aplica_ot.",60";						                   
                        $no_in = " and t1.t1_area_id not in (60)";
				  }else{
					  $areas_aplica_ot = $areas_aplica_ot.",".$areas_aplica_ot;						                   
                        $no_in = " and t1.t1_area_id not in (".$areas_aplica_ot.")";
					}

                        $sel_areas = query_db("select t1.t1_area_id,t1.nombre from $g12 as t1, t2_item_pecc as t2  where t1.t1_area_id = t2.t1_area_id and  t2.id_item_peec_aplica = ".$sel_item[26]."  and t1.t1_area_id <> '".$sel_areas_contra_inicial[0]."' $no_in and t2.t1_tipo_proceso_id IN (7,12)	 group by t1.t1_area_id,t1.nombre");

                        while($sel_a_usuario = traer_fila_db($sel_areas)){
							
				  if( $sel_a_usuario[0] == 16){							
						$areas_aplica_ot = $areas_aplica_ot.",40,41,".$sel_a_usuario[0];
                  }elseif($sel_a_usuario[0] == 24){
 					    $areas_aplica_ot = $areas_aplica_ot.",34,".$sel_a_usuario[0];						                   
			  	  }elseif($sel_a_usuario[0] == 25 or $sel_a_usuario[0] == 20){
		   			   $areas_aplica_ot = $areas_aplica_ot.",35,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 22 or $sel_a_usuario[0] == 26 or $sel_a_usuario[0] == 32){
					  $areas_aplica_ot = $areas_aplica_ot.",36,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 6){
					  $areas_aplica_ot = $areas_aplica_ot.",37,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 21 or $sel_a_usuario[0] == 29){
					  $areas_aplica_ot = $areas_aplica_ot.",38,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 12){
				  		$areas_aplica_ot = $areas_aplica_ot.",39,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 17){
					  $areas_aplica_ot = $areas_aplica_ot.",40,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 18){
					  $areas_aplica_ot = $areas_aplica_ot.",41,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 1){
					  $areas_aplica_ot = $areas_aplica_ot.",44,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 31){
				  		$areas_aplica_ot = $areas_aplica_ot.",46,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 13){
					   $areas_aplica_ot = $areas_aplica_ot.",47,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 7){
					  	$areas_aplica_ot = $areas_aplica_ot.",48,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 8){
					  	$areas_aplica_ot = $areas_aplica_ot.",49,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 5){
					  	$areas_aplica_ot = $areas_aplica_ot.",55,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 14){
					  	$areas_aplica_ot = $areas_aplica_ot.",50,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 53){
					  	$areas_aplica_ot = $areas_aplica_ot.",60,".$sel_a_usuario[0];						                   
				  }else{
					  $areas_aplica_ot = $areas_aplica_ot.",".$sel_a_usuario[0];
					}
				}
			$imprime =	"select count(*) from t7_contratos_contrato where id_item = ".$sel_item[26]." and tipo_bien_servicio like '%Bienes%'";
	$selec_tipo_contras = traer_fila_row(query_db("select count(*) from t7_contratos_contrato where id_item = ".$sel_item[26]." and tipo_bien_servicio like '%Bienes%'"));
	
	if($selec_tipo_contras[0]>0 ){//si es solicitud con contratos de bienes
	$imprime =  "select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$usuario_para_traer_areas." and t1.estado = 1";
		$sel_areas_ot = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$usuario_para_traer_areas." and t1.estado = 1");
		}else{	
		
		
						//$sel_areas_ot = query_db("select * from  t1_area where t1_area_id in (0".$areas_aplica_ot.") and estado= 1");
		if($es_admin_ot == "SI"){						
						$sel_areas_ot = query_db("select t1_area_id, nombre from t1_area where estado= 1 and (t1_area_id IN (".$areas_aplica_ot."))");
						}else{
							
							  $sel_areas_ot = query_db("select t1.t1_area_id, t1.nombre from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$usuario_para_traer_areas." and t1.estado = 1 and t1.t1_area_id in (".$areas_aplica_ot.")");
							  
							//$sel_areas_ot = query_db("select t1_area_id, nombre from t1_area where estado= 1 and (t1_area_id IN (".$areas_aplica_ot."))");
							}
		
		}
		$si_no_tiene_areas = "<option value='0'>No Tiene Ninguna Area Relacionada para este contrato</option>";
		while($s_a = traer_fila_db($sel_areas_ot)){	
		$si_no_tiene_areas ="";			
	  ?>
	  <option value="<?=$s_a[0]?>" <? if($sel_item[5] == $s_a[0]) echo 'selected="selected"'?> ><?=$s_a[1]?></option>
<?
		}
		echo $si_no_tiene_areas;
		
		
		
	}
		
	  ?>
        </select>
	
	<?
	//echo $imprime;
	}
}else{
		echo saca_nombre_lista($g12,$sel_item[5],'nombre','t1_area_id');
	}
  ?>      
        <input type="hidden" name="anexo_importante_comite" id="anexo_importante_comite" /></td>
      </tr>
      
      <tr>
        <td align="right">Fecha en la que se Requiere el Servicio<img src="../imagenes/botones/help.gif" alt="Fecha estimada en la cual requiere la solicitud." title="Fecha estimada en la cual requiere la solicitud." width="20" height="20" /></td>
        <td colspan="3">
         <?
if($edicion_datos_generales == "SI"){
?>
        <input name="fecha" type="text" id="fecha" size="5" value="<?=$sel_item[7]?>"  onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha')"  />
<?
}else{
		echo $sel_item[7];
	}
?>
</td>
      </tr>
      <? if($sel_item[6] == 16){
		  
		  if($sel_item[14] >=13){
		  ?>
	
      <tr>
        <td align="right">Tiene Reajustes:</td>
        <td colspan="3"><?php if($edita_info_ad_sm == "SI"){ ?>
    <select name="reajuste" id="reajuste">
      <option value="0">Seleccione</option>
      <option value="1" <? if($sel_item[78] == 1) echo 'selected="selected"'?>>SI</option>
      <option value="2" <? if($sel_item[78] == 2) echo 'selected="selected"'?>>NO</option>
    </select>
    <?php }else{
        if($sel_item[78] == 1){
          echo "SI";
        }else if($sel_item[78] == 2){
          echo "NO";
        }
		?><input type="hidden" name="reajuste" id="reajuste" value="<?=$sel_item[78]?>"  /><?
      } ?>
      
      </td>
      </tr>
      <?
	  }
      
	  ?>
      <tr>
        <td align="right">Tiene Reembolsables:</td>
        <td colspan="3"><?php if($edicion_datos_generales == "SI" and $sel_item[14] == 31){ ?>
      <select name="reembolsable" id="reembolsable">
        <option value="0">Seleccione</option>
        <option value="1" <? if($sel_item[80] == 1) echo 'selected="selected"'?>>SI</option>
        <option value="2" <? if($sel_item[80] == 2) echo 'selected="selected"'?>>NO</option>
      </select>
    <?php }else{
        //echo $query;
         if($sel_item[80] == 1){
          echo "SI";
        }else if($sel_item[80] == 2){
          echo "NO";
        }
		?><input type="hidden" name="reembolsable" id="reembolsable" value="<?=$sel_item[80]?>"  /><?
      } ?></td>
      </tr>
      <?
	  
		}
		
      if($sel_item[4]<>1 and $yano_aplica == "esta inactivo"){
	  ?>
      
      
      <tr>
        <td align="right">Cargo Contable:</td>
        <td colspan="3">
         <?
if($edicion_datos_generales == "SI"){
?>
          <input name="cargo_contable" type="text" id="cargo_contable" value="<?=$sel_item_obs[8]?>"/>
          <?
}else{
		echo $sel_item_obs[8];
	}
		?>
        
        </td>
      </tr>
      <?
	  }else{
		  ?><input name="cargo_contable" type="hidden" id="cargo_contable" value="<?=$sel_item_obs[8]?>"/><?
		  }
		  if($sel_item[6] == 12)  {
	  ?>
      <tr>
        <td align="right">Esta Reclasificacion Generara Otros&iacute;:</td>
        <td colspan="3">
          <? if($edicion_datos_generales == "SI"){?>
          
          <?
        $sel_si_tiene_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc));
			if($sel_si_tiene_presu[0]<=0){
			echo  "<span class='letra-descuentos'>ALERTA: Para poder seleccionar si la reclasificaci&oacute;n genera otros&iacute; se debe ingresar el presupuesto, SGPA tambien recibe valores en cero (0)</span>";
            ?><input type="hidden" name="req_crear_otro_si" id="req_crear_otro_si" value="2" /><?
			}else{
				
				if($sel_item[2]==522 or $sel_item[2]==525 or $sel_item[2]==528 or $sel_item[2]==531){
					echo "El campo no est&aacute; habilitado en &eacute;ste tipo de proceso ya que la aprobaci&oacute;n de otros&iacute; debe ir a comit&eacute; de contratos";
					?><input type="hidden" name="req_crear_otro_si" id="req_crear_otro_si" value="2" /><?
					}else{
		?>
          <select name="req_crear_otro_si" id="req_crear_otro_si">
            <option value="0" >Seleccione</option>
            <option value="2" <? if($sel_item[61] == 2) echo 'selected="selected"'?>>NO</option>
            <option value="1" <? if($sel_item[61] == 1) echo 'selected="selected"'?>>SI</option>
            </select>
          <?
					}
	} 
	}else{ if($sel_item[61] == 1){ echo "SI";} else {echo "NO"; } }?>
        </td>
        </tr>
      <?
		  }else{ ?><input type="hidden" name="req_crear_otro_si" id="req_crear_otro_si" value="0" /><? }
      if($sel_item[6]==1 or $sel_item[6]==2){
	  ?>
      
      <tr>
        <td align="right">Par T&eacute;cnico <img src="../imagenes/botones/help.gif" alt="Ac&aacute; debe ingresar el nombre del profesional que apoyar&aacute; la evaluaci&oacute;n t&eacute;cnica del proceso, Este requisito aplica para los procesos que requieren aprobaci&oacute;n de comit&eacute;." title="Ac&aacute; debe ingresar el nombre del profesional que apoyar&aacute; la evaluaci&oacute;n t&eacute;cnica del proceso, Este requisito aplica para los procesos que requieren aprobaci&oacute;n de comit&eacute;." width="20" height="20" /></td>
        <td colspan="3"><? if($edicion_datos_generales == "SI"){?>
        <input type="text" name="partecnico_bus_us" id="partecnico_bus_us" onkeypress="selecciona_lista()" value="<?=$nombre_par_tecnico?>"/>
		<? }else{
			echo traer_nombre_muestra($sel_item[64], $g1,"nombre_administrador","us_id");
			} ?> </td>
      </tr>
      <tr>
        <td align="right">Gerente de Contrato <img src="../imagenes/botones/help.gif" alt="Ac&aacute; debe ingresar el nombre del profesional que administrar&aacute; el contrato." title="Ac&aacute; debe ingresar el nombre del profesional que administrar&aacute; el contrato." width="20" height="20" /></td>
        <td colspan="3"><? if($edicion_datos_generales == "SI"){?><input type="text" name="gerente_contrato_bus_us" id="gerente_contrato_bus_us" onkeypress="selecciona_lista()" value="<?=$nombre_ger_contrato?>"/><? }else{
			echo traer_nombre_muestra($sel_item[65], $g1,"nombre_administrador","us_id");
			} ?></td>
      </tr>
      <tr>
        <td align="right">Requiere Contrataci&oacute;n de Mano de Obra Local:</td>
        <td colspan="3"><? if($edicion_datos_generales == "SI"){?><select name="req_contra_mano_obra_local" id="req_contra_mano_obra_local">
          <option value="0" >Seleccione</option>
          <option value="2" <? if($sel_item[59] == 2) echo 'selected="selected"'?>  >NO</option>
          <option value="1" <? if($sel_item[59] == 1) echo 'selected="selected"'?>>SI</option>
        </select><? }else{ if($sel_item[59] == 1) echo "SI"; if($sel_item[59] == 2) echo "NO";}?></td>
      </tr>
      <tr>
        <td align="right">Requiere contrataci&oacute;n de Bienes y Servicios Local:</td>
        <td colspan="3"><? if($edicion_datos_generales == "SI"){?><select name="req_cont_bien_ser_local" id="req_cont_bien_ser_local">
          <option value="0" >Seleccione</option>
          <option value="2" <? if($sel_item[60] == 2) echo 'selected="selected"'?>>NO</option>
          <option value="1" <? if($sel_item[60] == 1) echo 'selected="selected"'?>>SI</option>
        </select><? }else{ if($sel_item[60] == 1) echo "SI"; if($sel_item[60] == 2) echo "NO";}?></td>
      </tr>
      <?
	  }
	  ?>
      <tr >
        <td align="right" ><? 
		
		if ($id_tipo_proceso_pecc == 3){ 
		if($sel_item[4] <> 1){
		echo "Trabajo a Realizarse Mediante esta Orden de Pedido Contrato Marco/Lista de Precios";
		}else{
		echo "Trabajo a Realizarse Mediante esta Orden de Trabajo"; 	
			}
		
		}else{ echo "Objeto de la Solicitud"; }
		
		
		?>          <img src="../imagenes/botones/help.gif" alt="Actividad o servicio que se desea realizar a trav&eacute;s del contrato." title="Actividad o servicio que se desea realizar a trav&eacute;s del contrato." width="20" height="20" /></td>
        <td colspan="3" class="linea_campo_sol">
          <?
if($edicion_datos_generales == "SI"){
?>
          <textarea name="objeto_solicitud" id="objeto_solicitud" cols="25" rows="5"><?=$sel_item_obs[0]?></textarea>
          <?
}else{
	if($sel_item[6] == 16 and $sel_item[14] >= 13 and $sel_item[14] != 31){
		 echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Anterior al proceso de Urna Virtual (Solicitante / Abastecimiento):");
		 echo nl2br($sel_item_obs[0]);
		 if($sel_item[14] > 13){echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Posterior al proceso de Urna Virtual (Abastecimiento):");}
		 if($edita_info_ad_sm == "SI"){?><textarea name="objeto_solicitud_ad_sm" rows="5" id="objeto_solicitud_ad_sm"><?=$objeto;?></textarea><? }else{echo nl2br($objeto); }		 
		}else{
			echo nl2br($sel_item_obs[0]);	
			}
		
	}
		?>
        
        <?	 

		 ?>
          </td>
      </tr>
      
      <tr>
        <td align="right">
      <?
      if($sel_item[6] <> 16){
		  $tex_ayuda_ob_con = "Describe el Objeto Conciso del Contrato.";
	  ?>  
        Objeto del Contrato
      <?
      }else{
		  $tex_ayuda_ob_con = "Describe el Objeto Conciso de la Orden de Servicio";
		  echo "Objeto de la Orden de Servicio";
		  }
	  ?>  
        <img src="../imagenes/botones/help.gif" alt="" width="20" height="20" title="<?=$tex_ayuda_ob_con?>" /></td>
        <td colspan="3" class="linea_campo_sol">
         <?
        	if($edicion_datos_generales == "SI" and $campos_no_habilita_en_completamiento=="SI"){
				
		?>
        <textarea name="objeto_contrato" id="objeto_contrato" cols="25" rows="5"><?=$sel_item_obs[1]?></textarea>
        <?
			}else{
				
				if($sel_item[6] == 16 and $sel_item[14] >= 13 and $sel_item[14] != 31){
		 echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Anterior al proceso de Urna Virtual (Solicitante):");
		 echo nl2br($sel_item_obs[1]);
		 if($sel_item[14] > 13){echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Posterior al proceso de Urna Virtual (Abastecimiento):");}
		 if($edita_info_ad_sm == "SI"){?><textarea name="objeto_contrato_ad_sm" rows="5" id="objeto_contrato_ad_sm"><?=$objeto_orden_servicio;?></textarea><? }else{echo nl2br($objeto_orden_servicio); }		 
		}else{
			echo nl2br($sel_item_obs[1])."<input type='hidden' id='objeto_contrato' name='objeto_contrato' value='".$sel_item_obs[1]."' />" ;	
			}
				
				
				}
				
		?>
         
        </td>
      </tr>
      <?
	  
      //if($sel_item[4] == 1){ //se comentarea porque el alcance ahora tambíen se pide para bienes
	  ?>
      <tr>
        <td align="right">Alcance<img src="../imagenes/botones/help.gif" alt="Alcance detallado donde se indique el &Aacute;rea o &aacute;reas en las cuales se utilizar&aacute; el contrato." title="Alcance detallado donde se indique el &Aacute;rea o &aacute;reas en las cuales se utilizar&aacute; el contrato." width="20" height="20" /></td>
        <td colspan="3" class="linea_campo_sol">
        <?
        	if(($sel_item[6] <> 8) and $edicion_datos_generales == "SI" and $campos_no_habilita_en_completamiento=="SI"){
		?>
        <textarea name="alcance" id="alcance" cols="25" rows="5"><?=$sel_item_obs[2]?></textarea>
        <?
        }else{
			
			if($sel_item[6] == 16 and $sel_item[14] >= 13 and $sel_item[14] != 31){
		 echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Anterior al proceso de Urna Virtual (Solicitante):");
		 echo nl2br($sel_item_obs[2]);
		 if($sel_item[14] > 13){echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Posterior al proceso de Urna Virtual (Abastecimiento):");}
		 if($edita_info_ad_sm == "SI"){?><textarea name="alcance_ad_sm" rows="5" id="alcance_ad_sm"><?=$alcance;?></textarea><? }else{echo nl2br($alcance); }		 
		}else{
			echo nl2br($sel_item_obs[2]);	
			}
				
				

				?><input type="hidden" name="alcance" id="alcance" value="<?=$sel_item_obs[2]?>"/><?
				}
		?>
         
        </td>
      </tr>
      <?
	  /*}	else{
		  ?><input type="hidden" name="alcance" id="alcance" value="N/A" /><?
		  }*/
		  
		if($sel_item[6] <> 8){  
	  ?>
      <tr>
        <td align="right">Justificaci&oacute;n T&eacute;cnica<strong><img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
" title="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
"  width="20" height="20" /></strong></td>
        <td colspan="3" class="linea_campo_sol"><?
if($edicion_datos_generales == "SI" and $campos_no_habilita_en_completamiento=="SI"){
?>
          <textarea name="justificacion2" id="justificacion2" cols="25" rows="4"><?=$sel_item_obs[9]?></textarea>
          <?
}else{
			echo nl2br($sel_item_obs[9]).'<input type="hidden" name="justificacion2" id="justificacion2" value="'.$sel_item_obs[9].'" />';
			
			}
		?></td>
      </tr>
      <?
	  $tex_titulo_justifi = " Comercial";
		}else{
			?><input type="hidden" name="justificacion2" id="justificacion2" value="<?=$sel_item_obs[9]?>"/><?
			}
	  ?>
      <?
         if(($sel_item_obs[4]!= "" and $sel_item_obs[4] != " " and $sel_item_obs[4] != "   "  ) or ($sel_item[6]==8 or $sel_item[6]==16)){
         ?>
      <tr>
        <td align="right">Justificaci&oacute;n<?=$tex_titulo_justifi?>          <img src="../imagenes/botones/help.gif" alt="Indica el porqu&eacute; se realiza la solicitud y porqu&eacute; sugiere el Tipo de Proceso solicitado. Principal campo de consulta." title="Indica el porqu&eacute; se realiza la solicitud y porqu&eacute; sugiere el Tipo de Proceso solicitado. Principal campo de consulta." width="20" height="20" /></td>
        <td colspan="3" class="linea_campo_sol">
        
        
          <?
		  
if($sel_item[6]==8 or $sel_item[6]==16){
	if($edicion_datos_generales == "SI"){
	
?>
          <textarea name="justificacion" id="justificacion" cols="25" rows="4"><?=$sel_item_obs[4]?></textarea>
          <?
	}else{
		
		if($sel_item[6] == 16 and $sel_item[14] >= 13 and $sel_item[14] != 31){
		 echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Anterior al proceso de Urna Virtual (Solicitante / Abastecimiento):");
		 echo nl2br($sel_item_obs[4]);
		 if($sel_item[14] > 13){echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Posterior al proceso de Urna Virtual (Solicitante / Abastecimiento):");}
		 if($edita_info_ad_sm == "SI"){?><textarea name="justificacion_ad_sm" rows="5" id="justificacion_ad_sm"><?=$justificacion_adjudica;?></textarea><? }else{echo nl2br($justificacion_adjudica); }		 
		}else{
			echo nl2br($sel_item_obs[4]);	
			}
			
		?><input type="hidden" name="justificacion" id="justificacion" value="<?=$sel_item_obs[4]?>"/><?
		
		}
}else{
			echo nl2br($sel_item_obs[4]);
			?>
            <input type="hidden" name="justificacion" id="justificacion" value="<?=$sel_item_obs[4]?>"/>
			<?
			}
		 ?>
          </td>
      </tr>
      <?
		 }
      ?>

      <?
	  
   if( ($sel_item[14] >= 6 and $sel_item[14] <> 31)  and ($sel_item[6] == 7 or $sel_item[6] == 5 or $sel_item[6] == 15  or $sel_item[6] == 6) or ($sel_item[6] == 16 and $sel_item[14] >= 13 and $sel_item[14] != 31) or $edita_info_ad_sm == "SI"){ 
	  ?>
      <tr>
        <td align="right">Antecedentes <img src="../imagenes/botones/help.gif" alt="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" title="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" width="20" height="20" /></td>
        <td colspan="3" class="linea_campo_sol"><?
if($edicion_datos_generales == "SI" or $edita_info_ad_sm == "SI"){
?>
          <textarea name="antecedentes_texto" id="antecedentes_texto" cols="25" rows="4"><?=$sel_item_obs[13]?></textarea><br />
Adjuntar antecedente: <input type="file" name="antecedente_anexo" id="antecedente_anexo" /><?

		$sl_anexos = traer_fila_row(query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us, antecedente_comite
 from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'antecedente' and antecedente_comite = 1"));
 
 if($sl_anexos[0]>0 and $sl_anexos[5] != " "){
	 echo " <br /><strong>Antecedente Adjunto:</strong> ";
			  ?>
                <?=saca_nombre_anexo($sl_anexos[5])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
                <?
	 }
 
}else{
			echo nl2br($sel_item_obs[13]);
			
			$sl_anexos = traer_fila_row(query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us, antecedente_comite
 from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'antecedente' and antecedente_comite = 1"));
 
 if($sl_anexos[0]>0 and $sl_anexos[5] != " "){
	 echo " <br /> <strong>Antecedente Adjunto:</strong> ";
			  ?>
                <?=saca_nombre_anexo($sl_anexos[5])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
                <?
 }
			}
		?>
        <input type="hidden" name="con_anexo_antecedente" id="con_anexo_antecedente" value="<?=$sl_anexos[0]?>" />
        </td>
      </tr>
    
    <?
	  }
	  
	  if($sel_item[14]<>31 and $sel_item[6] != 16 or ($sel_item[6] == 16 and $sel_item[14] >= 13 and $sel_item[14] != 31) or $edita_info_ad_sm == "SI"){
	  ?>
	  <tr>
        <td align="right">Equipo Negociador:</td>
        <td colspan="3" class="linea_campo_sol"><?
if($edicion_datos_generales == "SI" or $edita_info_ad_sm == "SI"){
?>
          <textarea name="equipo_negociador" id="equipo_negociador" cols="25" rows="4"><?=$sel_item_obs[14]?></textarea>          <?
}else{
			echo nl2br($sel_item_obs[14]);
			}
		?></td>
      </tr>
	  <?
	  }else{//cuando se active eliminar el else
	  ?><input type="hidden" name="equipo_negociador" id="equipo_negociador" value="                                             " /><?
		  
		  }
      if($sel_item[6] <> 8 and $sel_item[6] <> 16){ 
	  ?>
      
      <tr>
        <td align="right">Criterios de Evaluaci&oacute;n<img src="../imagenes/botones/help.gif" alt="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico
" title="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico
" width="20" height="20" /></td>
        <td colspan="3" class="linea_campo_sol"><?
if($edicion_datos_generales == "SI"){
?>
          <textarea name="criterios_evaluacion" id="criterios_evaluacion" cols="25" rows="4"><?=$sel_item_obs[10]?></textarea>          <?
}else{
			echo nl2br($sel_item_obs[10]);
			}
		?></td>
      </tr>
      <?
	  }else{
		  ?><input type="hidden" name="criterios_evaluacion" id="criterios_evaluacion" value="<?=$sel_item_obs[10]?>"/><?
		  }
	  if($sel_item[4] <> 1){
	  ?>
      <tr>
        <td align="right">Elementos Requeridos:</td>
        <td colspan="3">Descargue Aqu&iacute; la Plantilla Donde Podr&aacute; Relacionar los Materiales de Esta Solicitud <a href="../imagenes/Copia de plantilla compras.xlsx" target="_blank"><img src="../imagenes/mime/xls.gif" alt="" /></a>
          </td>
      </tr>
      <?
	  }
	  ?>
      <tr>
        <td align="right">Recomendaci&oacute;n<img src="../imagenes/botones/help.gif" alt="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." width="20" height="20" title="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." /></td>
        <td colspan="3" class="linea_campo_sol">
         <?

if($edicion_datos_generales == "SI" and $campos_no_habilita_en_completamiento=="SI"){
?>
        <textarea name="recomendacion" id="recomendacion" cols="25" rows="4"><?=$sel_item_obs[5]?></textarea>
        <?
}else{
	if($sel_item[6] == 16 and $sel_item[14] >= 13 and $sel_item[14] != 31){
		 echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Anterior al proceso de Urna Virtual (Solicitante):");
		 echo nl2br($sel_item_obs[5]);
		 if($sel_item[14] > 13){echo ayuda_alerta_pequena_sin_img("Informaci&oacute;n Ingresada Posterior al proceso de Urna Virtual (Abastecimiento):");}
		 if($edita_info_ad_sm == "SI"){?><textarea name="recomendacion_ad_sm" rows="5" id="recomendacion_ad_sm"><?=$recomendacion;?></textarea><? }else{echo nl2br($recomendacion); }		 
		}else{
			echo nl2br($sel_item_obs[5]);	
			}
			
			
	echo '<input type="hidden" name="recomendacion" id="recomendacion" value="'.$sel_item_obs[5].'"/>';
	}
		?>
        
        </td>
      </tr>
      
     		 <? 
		
	  			if( $sel_item[14]!=31 and ($sel_item_obs[11] !="" and $sel_item_obs[11]!=" " and $sel_item_obs[11]!="  ")){
		  
		  	 ?>    
		  <tr>
			<td align='right'>
				Conflicto de intereses<img src="../imagenes/botones/help.gif" alt="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." width="20" height="20" title="Conflicto de Intereses." />
			</td>
			<td colspan='3'>
     		 <? 
		
					echo nl2br($sel_item_obs[11]);
					?>
                    <input type="hidden" name="conflicto_intereses" id="conflicto_intereses" value="<?=$sel_item_obs[11]?>" />
					<?
				
			 ?>                
			</td>
		  </tr>
		  

          
      
      
      <?
      
	  }
	  // comentariado las fechas de inicio y fin del servicio menor   inicio
	 /* if($sel_item[6] == 16){// PARA EL DESARROLLO DE MODULO DE DESEMPEÑO si es servicio menor se piden las fechas de inicio y fin
		$fecha_actualizacion=date("Y-m-d", strtotime('2017-12-29'));
		$fecha_actual=date("Y-m-d");
		if($fecha_actualizacion<=$fecha_actual){
		?>
		<tr>
            <td align="right">Fecha de Inicio del Servicio Menor<img src="../imagenes/botones/help.gif" alt="Seleccionar la fecha de inicio estimada del servicio menor." title="Seleccionar la fecha de inicio estimada del servicio menor." width="20" height="20" /></td>
            <td>
            <?
			if($edicion_datos_generales == "SI"){
			?>
            	<input name="fecha_inicio_ot" type="text" id="fecha_inicio_ot" size="5" value="<?=$sel_item[86];?>" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha_inicio_ot')"/>
			<?
			}else{
					echo $sel_item[86];
				}
			?>
       		</td>
        </tr>
        <tr>
            <td align="right">Fecha de Finalizaci&oacute;n del Servicio Menor<img src="../imagenes/botones/help.gif" alt="Seleccionar la fecha de finalizaci&oacute;n estimada del servicio menor." title="Seleccionar la fecha de finalizaci&oacute;n estimada del servicio menor." width="20" height="20" /></td>
            <td>
            <?
			if($edicion_datos_generales == "SI"){
			?>
            	<input name="fecha_fin_ot" type="text" id="fecha_fin_ot" size="5" value="<?=$sel_item[87];?>" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha_fin_ot')"/>
			<?
			}else{
					echo $sel_item[87];
				}
			?>
       		</td>
        </tr>
        <?
		}else{
		?>
		<input name="fecha_inicio_ot" type="hidden" id="fecha_inicio_ot" size="5" value="<?=date('Y-m-d');?>"/>
        <input name="fecha_fin_ot" type="hidden" id="fecha_fin_ot" size="5" value="<?=date('Y-m-d');?>"/>
		<?
		}
	  }  */
	  // comentariado las fechas de inicio y fin del servicio menor   fin
	  
	  
      if($sel_item[6] == 8){//si es orden de trabajo
	  ?>
      <tr>
        <td align="right">Destino:</td>
        <td colspan="3">
           <?
if($edicion_datos_generales == "SI"){
?>
        <input name="destino_orden_trabajo" type="text" id="destino_orden_trabajo" value="<?=$sel_item_obs[6]?>" size="25" maxlength="55" />
        <?
}else{
	echo $sel_item_obs[6];
	}
		?>
        </td>

       
      </tr>
      
     <?
		if($sel_item[4]==1 and $sel_item[6]==8){ //si es ot de servicios se piden dos fechas => fecha inicio, fecha fin 
			if($sel_item[41]!=NULL or $sel_item[41]!=""){//para las que ya han sido creadas antes de la actulaizaciÃ³n ?>
			 <tr>
					<td align="right">Duraci&oacute;n de la Orden de Trabajo:</td>
					<td colspan="3">
						 <?
			if($edicion_datos_generales == "SI"){
			?>
					<input name="duracion_orden_trabajo" type="text" id="duracion_orden_trabajo" value="<?=$sel_item_obs[7]?>" size="25" maxlength="55" />
					<?
			}else{
				echo $sel_item_obs[7];
				}
					?>
					</td>
			  </tr>
        <input name="fecha_inicio_ot" type="hidden" id="fecha_inicio_ot" size="5" value="<?=date('Y-m-d');?>"/>
        <input name="fecha_fin_ot" type="hidden" id="fecha_fin_ot" size="5" value="<?=date('Y-m-d');?>"/>
		<?	}else{//para las que se crean despues de la actualizaciÃ³n ?>
		<?
			if($edicion_datos_generales == "SI"){
		?>
		<tr>
			<td align="right" ></td>
			<td align="left" colspan="3"><p><img src="../imagenes/botones/icono_ayuda.png"></img>&nbsp;<span style="color: #229BFF; font-family: roboto; font-size: 11pt; font-weight: 900;">Por favor diligenciar la fecha de finalizaciÃ³n de los trabajos, recuerde que esta no <br />
			</span><span style="color: #229BFF; font-family: roboto; font-size: 11pt; font-weight: 900;">debe ser superior a la fecha de finalizaciÃ³n del contrato</span></p></td>
		</tr>
		<?
			}
		?>
		<tr>
            <td align="right">Fecha de Inicio de la OT<img src="../imagenes/botones/help.gif" alt="Seleccionar la fecha de inicio estimada de la ot." title="Seleccionar la fecha de inicio estimada de la ot." width="20" height="20" /></td>
            <td>
            <?
			if($edicion_datos_generales == "SI"){
			?>
            	<input name="fecha_inicio_ot" type="text" id="fecha_inicio_ot" size="5" value="<?=$sel_item[86];?>" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha_inicio_ot')"/>
			<?
			}else{
					echo $sel_item[86];
				}
			?>
       		</td>
        </tr>
        <tr>
            <td align="right">Fecha de Finalizaci&oacute;n de la OT<img src="../imagenes/botones/help.gif" alt="Seleccionar la fecha de finalizaci&oacute;n estimada de la ot." title="Seleccionar la fecha de finalizaci&oacute;n estimada de la ot." width="20" height="20" /></td>
            <td>
            <?
			if($edicion_datos_generales == "SI"){
			?>
            	<input name="fecha_fin_ot" type="text" id="fecha_fin_ot" size="5" value="<?=$sel_item[87];?>" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha_fin_ot')"/>
			<?
			}else{
					echo $sel_item[87];
				}
			?>
       		</td>
        </tr>
		<?	}// fin para las que se crean despues de la actualizaciÃ³n
		}else{ //si no es ot de servicios sigue normal
		?>
			  <tr>
				<td align="right">Duraci&oacute;n de la Orden de Trabajo:</td>
				<td colspan="3">
					 <?
		if($edicion_datos_generales == "SI"){
		?>
				<input name="duracion_orden_trabajo" type="text" id="duracion_orden_trabajo" value="<?=$sel_item_obs[7]?>" size="25" maxlength="55" />
				<?
		}else{
			echo $sel_item_obs[7];
			}
				?>
				</td>
			  </tr>
      
      <?
		}// fin si no es ot de servicios sigue normal
	  }
	  ?>

          <?
	  if($aplica_objetivos_pro =="SI"){
		  
		  $titulo_principal = "Objetivos del Proceso";
		  $titulo1="Oportunidad";
		  $ayuda1="Para cuando se requiere el servicio y que estamos proponiendo para cumplir con la fecha de entrega, y la estrategia que estamos proponiendo nos sirve para cumplir con el objetivo";
		  $titulo2="Costo-Beneficio";
		  $ayuda2="Cual es el criterio que me genera el mejor costo beneficio Ejemplo Tiempo, Evaluaci&oacute;n T&eacute;cnica, otros, Precio.";
		  
		  $titulo3="Calidad";
		  $ayuda3="Que significa calidad para el proceso en espec&iacute;fico?  combinaci&oacute;n de tiempo? Entregable?";
		  
		  $titulo4="Optimizar Transferencia Riesgos";
		  $ayuda4="Identificar los riesgos y escribir como se aseguran o cuales se transfieren y por que medio.  Si no se transfieren explicar el porque";
		  
		  $titulo5="Trazabilidad";// no tiene cambio
		  $ayuda5="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones.";
		  
		  $titulo6="Transparencia";// no tiene cambio
		  $ayuda6="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)";
		  
		  $titulo7="Sostenibilidad";
		  $ayuda7="Como nos estamos asegurando que los compromisos con las comunidades se van a tener encuentra en el proceso";
		  
		  
		  if($id_item_pecc > $id_item_empieza_nuevos_objetivos_proceso){
		  $titulo_principal = "Lineamientos Operador de Bajo Costo + R+S";
		  $titulo1="Bajo Costo";
		  $ayuda1="Est&aacute;ndares acordes a las necesidades del negocio que aseguren rentabilidad y excelencia operacional. Actividades justo lo necesario -fitforpurpose. Proceso de abastecimiento que obtiene el mayor valor posible del mercado.";
		  $titulo2="NO aplica";
		  $ayuda2="NO aplica";
		  
		  $titulo3="Capacidad T&eacute;cnica";
		  $ayuda3="Competencias integrales y aplicaci&oacute;n de tecnolog&iacute;as conectadas con el negocio y fortalecidas a trav&eacute;s de alianzas estrat&eacute;gicas. Informaci&oacute;n como recurso";
		  
		  $titulo4="Gesti&oacute;n de Entorno";
		  $ayuda4="Foco en el desarrollo regional sostenible, alineando intereses de largo plazo. Vinculaci&oacute;n del entorno en los resultados. Operaci&oacute;n sana, limpia, segura y transparente.";
		  
		  $titulo5="Trazabilidad";// no tiene cambio
		  $ayuda5="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones.";
		  
		  $titulo6="Transparencia";// no tiene cambio
		  $ayuda6="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)";
		  
		  $titulo7="Agilidad";
		  $ayuda7="Procesos simplificados y estandarizados. Personal integral y m&oacute;vil, seg&uacute;n los requerimientos del negocio. Oportunidad en adquisici&oacute;n de B&S.";
		  }
		  
	  ?>
      
      
		<tr>
        <td colspan="4" align="right"><table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF"   class="tabla_lista_resultados">
          <tr>
            <td align="center"  class="fondo_3">
               <?=$titulo_principal ?></td>
            <td align="center" class="fondo_3">Descripci&oacute;n</td>
          </tr>
          <?
	  ?>
          <tr>
            <td width="31%" align="right"><?=$titulo1?>  <img src="../imagenes/botones/help.gif" alt="<?=$ayuda1?>" width="20" height="20" title="<?=$ayuda1?>" /></td>
            <td width="69%" align="left" class="linea_campo_sol">
			
			<? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos1" id="campos1"><?=$p_oportunidad?></textarea>
              <? } else {echo nl2br($p_oportunidad); }?>
              
              </td>
          </tr>
         <?
         if($permiso_mayor_creacion == "SI" and $titulo2 != "NO aplica"){
		 ?> 
          <tr>
            <td align="right"><?=$titulo2?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda2?>" width="20" height="20" title="<?=$ayuda2?>" /></td>
            <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos2" id="campos2"><?=$p_costo?></textarea>
              <? } else echo nl2br($p_costo); ?></td>
          </tr>
          <?
		 }else{
			 ?><input type="hidden" name="campos2" id="campos2" value="<?=$p_costo?>" /><?
			 }
			 
			 
		  ?>
          <tr>
            <td align="right"><?=$titulo3?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda3?>" width="20" height="20" title="<?=$ayuda3?>" /></td>
            <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos3" id="campos3"><?=$p_calidad?></textarea>
              <? } else echo nl2br($p_calidad); ?></td>
          </tr>
          
          <tr>
            <td align="right"><?=$titulo4?>  <img src="../imagenes/botones/help.gif" alt="<?=$ayuda4?>" width="20" height="20" title="<?=$ayuda4?>" /></td>
            <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos4" id="campos4"><?=$p_optimizar?></textarea>
              <? } else echo nl2br($p_optimizar); ?></td>
          </tr>
          <?
         if($permiso_mayor_creacion == "SI"){
		 ?> 
          <tr>
            <td align="right"><?=$titulo5?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda5?>" width="20" height="20" title="<?=$ayuda5?>" /></td>
            <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos5" id="campos5"><?=$p_trazabilidad?></textarea>
              <? } else echo nl2br($p_trazabilidad); ?></td>
          </tr>
          <tr>
            <td align="right"><?=$titulo6?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda6?>" width="20" height="20" title="<?=$ayuda6?>" /></td>
            <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos6" id="campos6"><?=$p_transparencia?></textarea>
              <? } else echo nl2br($p_transparencia); ?></td>
          </tr>
          <?
		 }else{
			 ?>
             
			 <input type="hidden" name="campos5" id="campos5" value="<?=$p_trazabilidad?>" />
			 <input type="hidden" name="campos6" id="campos6" value="<?=$p_transparencia?>" />
			 
			 <?
			 }
		  ?>
          <tr>
            <td align="right"> <?=$titulo7?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda7?>" width="20" height="20" title="<?=$ayuda7?>" /></td>
            <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos7" id="campos7"><?=$p_sostenibilidad?></textarea>
              <? } else echo nl2br($p_sostenibilidad); ?></td>
          </tr>
           
        </table></td>
        </tr>
	  <?
	  }else{
	  ?>
      <input type="hidden" name="campos1" id="campos1" value=""/>
        <input type="hidden" name="campos2" id="campos2" value=""/>
        <input type="hidden" name="campos3" id="campos3" value=""/>
        <input type="hidden" name="campos4" id="campos4" value=""/>
        <input type="hidden" name="campos5" id="campos5" value=""/>
        <input type="hidden" name="campos6" id="campos6" value=""/>
        <input type="hidden" name="campos7" id="campos7" value=""/>
	  <?
	  }
	  ?>
      <tr>
        <td colspan="4" align="center">
        <?
        $sel_relacionada_cuenta = traer_fila_row(query_db("select count(*) from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where id_solicitud_relacionada = $id_item_pecc"));
		if($sel_relacionada_cuenta[0]>0){
		?>
        <table width="100%" border="0" class="tabla_lista_resultados">
    	  <tr>
    	    <td colspan="5" align="center"  class="fondo_3" style="height:30px"> Esta Solicitud ha Sido Modificada por las Siguientes Solicitudes</td>
  	    </tr>
    	  <tr></tr>
    	  <tr>
    	    <td align="center"  class="fondo_3" width="20%">N. Solicitud</td>
    	    <td align="center"  class="fondo_3" width="60%">Objeto</td>
    	    <td align="center"  class="fondo_3" width="20%">Estado</td>
    	    <td align="center"  class="fondo_3" width="20%">Tipo Proceso</td>
  	    </tr>
    	  <?php $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where id_solicitud_relacionada = $id_item_pecc");
				while ($rowSR = traer_fila_db($sel_relacionada)){?>
    	  <tr>
    	    <td><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3'])?></td>
    	    <td><?= $rowSR['objeto_solicitud']?></td>
    	    <td><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
    	    <td><?= $rowSR['nombre']?></td>
  	    </tr>
    	  <?php }
				?>
  	  </table>
      <?
		}
	  ?>
      </td>
      </tr>
      <tr>
        <td colspan="4" align="center">
        <?
        if($sel_item[14] > 6 and $sel_item[14] <> 31 and ($sel_item[6] <> 16 and $sel_item[6] <> 6 and $sel_item[6] <> 7 and $sel_item[6] <> 8 and $sel_item[6] <> 9 and $sel_item[6] <> 10 and $sel_item[6] <> 11 and $sel_item[6] <> 4 and $sel_item[6] <> 5 )){
		?>
        <strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sel_item[0]?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>&permiso_o_adjudica=1')" class="titulo_calendario_real_bien" style="cursor:pointer">Imprimir la Solicitud  </strong> 
        <?
        }
		if(($sel_item[6] <> 12) and ($sel_item[14] > 14 and $sel_item[14] <> 31) or ($sel_item[6] == 6 or $sel_item[6] == 16) or ($sel_item[6]==8 and $sel_item[14]==6)){
			
			?>
        <strong>-</strong> <strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sel_item[0]?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>&permiso_o_adjudica=2')" class="titulo_calendario_real_bien" style="cursor:pointer"> Imprimir la Solicitud  de Adjudicaci&oacute;n</strong>
        <?
		}
		?>
        
        <?

       
		?>
        </td>
        </tr>
        
        <?
	 
		?>
    </table></td>
    <td width="23%" valign="top" ><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?>
    </td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas">
    
    <table width="100%" border="0">
      <tr>
        
        <?
		
		if($es_preparador == "SI"){
	  $testos = "Temporalmente - Debera ponerse en contacto con el gerente del contrato para ponerlo en firme";
	  }else{
		  $testos = "temporalmente";
		  }
			
            
        	if($edicion_datos_generales == "SI" and $sel_item[14] == 31){				
							
		?><td align="center">
        <input name="button" type="button" class="boton_grabar" id="button" value="Grabar este proceso en <?=$sel_pecc[5]?>  - <?=$testos?>" onclick="valida_graba_item_edita(1)" /> </td>
        <?
			}
		?>
       
       
        <?



        if( ($sel_item[14] == 31 ) and $edicion_datos_generales == "SI" and ($es_preparador <> "SI" or ($sel_item[3]==$sel_item[36] and $sel_item[3] == $_SESSION["id_us_session"])) ){
			
			if($sel_item[6] == 1 or $sel_item[6] == 2 or $sel_item[6] == 5 or $sel_item[6] == 6 or $sel_item[6] == 7){
			/*verifica que tenga todos los AFE*/
			$sele_proyectos = query_db("select $g15.nombre, $g15.t1_campo_id from $pi8, $g15 where $pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and  (valor_usd > 0 or valor_cop > 0)   group by $g15.nombre, $g15.t1_campo_id");
  $falta_algun_afe_ceco = 0;
  while($sel_pro = traer_fila_db($sele_proyectos)){
	  $sel_afe_ceco = traer_fila_row(query_db("select id, afe_ceco, adjunto from  t2_relacion_afe_ceco where id_item = '".$id_item_pecc."' and id_campo = '".$sel_pro[1]."' and estado = 1 and permiso_adjudica = 1"));
	  if($sel_afe_ceco[2] != ""){}else{
				  $falta_algun_afe_ceco = $falta_algun_afe_ceco +1;
				  }
  }
  /*FIN verifica que tenga todos los AFE*/
  }else{//si aplica AFE CECO
	$falta_algun_afe_ceco = 0;
	}
/***************************************************************************************
********* INICIO PARA LAS ORDENES DE TRABAJO DEL CONTRATO SERVICIOS TEMPORALES*********
			
	if($edicion_datos_generales == "SI" and $id_item_pecc_aplica == 316){
			//verifica que tenga todos los AFE
			$sele_proyectos = query_db("SELECT $g15.nombre, $g15.t1_campo_id, CASE WHEN($pi8.valor_cop)<> 0.00 THEN $pi8.valor_cop ELSE $pi8.valor_usd END AS valor, CASE WHEN($pi8.valor_cop)<> 0.00 THEN 'COP' ELSE 'USD' END AS moneda FROM $pi8, $g15 WHERE $pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and (valor_usd > 0 or valor_cop > 0)");
  $falta_algun_afe_ceco = 0;
  while($sel_pro = traer_fila_db($sele_proyectos)){
	  $sel_afe_ceco = traer_fila_row(query_db("select id, afe_ceco, adjunto from  t2_relacion_afe_ceco where id_item = '".$id_item_pecc."' and id_campo = '".$sel_pro[1]."' and estado = 1 and permiso_adjudica = 1"));
	  if($sel_afe_ceco[2] != ""){}else{
				  $falta_algun_afe_ceco = $falta_algun_afe_ceco +1;
				  }
  }
  //FIN verifica que tenga todos los AFE
  }else{//si aplica AFE CECO
	$falta_algun_afe_ceco = 0;
	}
**************************************************************************************
********* FIN PARA LAS ORDENES DE TRABAJO DEL CONTRATO SERVICIOS TEMPORALES************/
if($_SESSION["id_us_session"] == 32){
	$falta_algun_afe_ceco = 0;
	}
		?> 
        
        <td align="center">
           <input type="hidden" name="falta_algun_afe_ceco" id="falta_algun_afe_ceco" value="<?=$falta_algun_afe_ceco?>" />
        <select name="conflito_intere_sel" id="conflito_intere_sel">
      <option value="0">Seleccione si Tiene Conflicto de Intereses</option>
      <option value="1">SI Tiene Conflicto de Intereses</option>
      <option value="2">NO Tiene Conflicto de Intereses</option>
    </select>
        <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar este proceso en <?=$sel_pecc[5]?> y poner en firme" onclick="valida_graba_item_edita(2)"/></td>
        <?
		}
		
		?>
        <td align="center">
         <?	 
		 if($edita_info_ad_sm == "SI"){	
		 ?>
        <input name="boton" id="boton" type="button" class="boton_grabar" value="Grabar la información posterior a la Urna Virtual " onclick="valida_graba_item_info_sm()" /> 
         <?
		 }
        	if($edicion_datos_generales == "SI" and $sel_item[14] < 31){				
		?>
        <input name="boton" id="boton" type="button" class="boton_grabar" value="Grabar este proceso" onclick="valida_graba_item_edita(3)" /> 
        <?
			}
		?>
        
        <?
        if($activa_bodega == "SI"){
		?>
        <table width="100%">
        <tr><td colspan="2" align="center">
        <input name="button" type="button" class="boton_grabar" id="button" value="Grabar Número de SolPed y Enviar MRO al Completamiento" onclick="graba_solped_compras()" />
        </td></tr>
        <tr>
          <td width="51%"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td width="12%" align="right">Observaci&oacute;n de la Devoluci&oacute;n:</td>
              <td width="42%" align="center"><textarea name="observa_atras" rows="5" id="observa_atras"></textarea></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><input type="button" name="button2" id="button2" value="Devolver al Gerente del Contrato" class="boton_grabar_cancelar" onclick="devolver_item_a_gerente_contrato()" /></td>
            </tr>
          </table>
          <?
		}
		?>
          </td>
          <td width="49%">&nbsp;</td>
        </tr>
        </table>
        </td>
      </tr>
      <?
      if($activa_revision_sap == "SI"){
	  ?>
      <tr>
        <td colspan="3" align="center">
        
        <table width="968" border="0" class="tabla_lista_resultados">
          <tr class="fondo_3">
            <td colspan="3">Grabar Revisiones SAP</td>

            </tr>
          <tr>
            <td align="center" class="fondo_3">Observaci&oacute;n</td>
            <td align="center" class="fondo_3">Estado</td>
            <td>&nbsp;</td>
          </tr>
		  <? $sel_si_tiene_revision_sap = traer_fila_row(query_db("select  id, id_item, accion_sap, CAST(ob AS text) from t2_revision_sap where id_item = ".$id_item_pecc));?>
          <tr>
            <td width="370"><textarea name="ob_sap<?=$id_item_pecc?>" id="ob_sap<?=$id_item_pecc?>"><?=$sel_si_tiene_revision_sap[3]?></textarea></td>
            <td width="370">
            
            <select name="resicion_SAP<?=$id_item_pecc?>" id="resicion_SAP<?=$id_item_pecc?>">
              <option value="NO Revisado" <? if ($sel_si_tiene_revision_sap[2] == "NO Revisado") echo 'selected="selected"'?>>NO Revisado en SAP</option>
              <option value="Revisado" <? if ($sel_si_tiene_revision_sap[2] == "Revisado") echo 'selected="selected"'?> >Revisado en SAP</option>
              
              <option value="No Aplica" <? if ($sel_si_tiene_revision_sap[2] == "No Aplica") echo 'selected="selected"'?>>NO Aplica Revisi&oacute;n en SAP</option>
              </select></td>
            <td width="214"><input type="button" name="asd" value="Grabar la Revisión SAP" onclick="graba_revision_sap(<?=$id_item_pecc?>)" /><input type="hidden" id="id_item_graba_revision" name="id_item_graba_revision" /></td>
            
            </tr>
          
</table></td>
        </tr>
        
        <?
	  }// fin si es activa sap
		?>
        
    </table></td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="tipo_graba" id="tipo_graba" />

<?

//if (($sel_item[6] <> 2 and $sel_item[6] <> 5 and $sel_item[6] <> 7 or $es_profesional_designado == "NO") or $edicion_datos_generales == "NO"){
	?><input type="hidden" name="req_sondeo" id="req_sondeo" value="<?=$sel_item[25]?>"/><?
	//}

	
	
if(($sel_item[6] == 7 or $sel_item[6] == 8) or ($edicion_datos_generales == "NO" and $edita_info_ad_sm == "NO")){
?>
<input type="hidden" name="tipo_proceso" id="tipo_proceso" value="<?=$sel_item[6]?>"/>


<?
}

if(($sel_item[6] == 8) and $edicion_datos_generales == "NO"){
?>

<?
}



if($edicion_datos_generales == "NO"){
?>

<input type="hidden" name="area_usuaria" id="area_usuaria" value="<?=$sel_item[5]?>" />
<input type="hidden" name="fecha" id="fecha" value="<?=$sel_item[7]?>"/>
<input type="hidden" name="objeto_solicitud" id="objeto_solicitud" value="<?=$sel_item[8]?>" />
<input type="hidden" name="justificacion" id="justificacion" value="<?=$sel_item[12]?>"/>
<!--<input type="hidden" name="recomendacion" id="recomendacion" value="<? //=$sel_item[13]?>"/>-->

<?
}
if ($es_profesional_designado == "NO"){
?>
<input type="hidden" name="us_prof" id="us_prof" value="<?=$sel_item[23]?>"/>
<?
}
?>
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>"/>
<input type="hidden" name="id_contrato_otro_si" id="id_contrato_otro_si" value="" />
<input type="hidden" name="id_tipo_contratacion" id="id_tipo_contratacion" value="<?=$sel_item[4]?>" />
<input type="hidden" name="id_preparador_solicitud" id="id_preparador_solicitud" value="<?=$sel_item[36]?>" />
<input type="hidden" name="estado_actual_del_proceso" id="estado_actual_del_proceso" value="<?=$sel_item[14]?>" />
<input type="hidden" name="solicitud_que_carga" id="solicitud_que_carga" value="<?=$sel_item[43]?>" />

<input type="hidden" name="campo_ob_proceso1" id="campo_ob_proceso1"/>
<input type="hidden" name="campo_ob_proceso2" id="campo_ob_proceso2"/>
<input type="hidden" name="campo_ob_proceso3" id="campo_ob_proceso3"/>
<input type="hidden" name="campo_ob_proceso4" id="campo_ob_proceso4"/>
<input type="hidden" name="campo_ob_proceso5" id="campo_ob_proceso5"/>
<input type="hidden" name="campo_ob_proceso6" id="campo_ob_proceso6"/>
<input type="hidden" name="campo_ob_proceso7" id="campo_ob_proceso7"/>
    <input type="hidden" name="es_admin_ot" id="es_admin_ot" value="<?=$es_admin_ot?>" />
<input type="hidden" name="permiso_ad_ob_proceso" id="permiso_ad_ob_proceso" value="1"/>

<input type="hidden" name="alertas_modal" id="alertas_modal" value="<?=$alertas_modal?>" />
<input type="hidden" name="tipo_proceso_anterior" id="tipo_proceso_anterior" value="<?=$sel_item[6]?>" />



</body>
</html>
