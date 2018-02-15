<?
<<<<<<< HEAD
/** PARA EL DES011-18 **/
=======
<<<<<<< HEAD
/** PARA EL DES011-18 **/
=======
<<<<<<< HEAD
/** PARA EL DES011-18 **/ 
=======
/** PARA EL DES011-18 **/
>>>>>>> jeison
>>>>>>> cd55fdf13d0b6e096fb3a8f12ec7a37d374ddac2
>>>>>>> 858fa811433ba23131cb372a3028e26364c21c65
if($sel_item[78]==1 or $_SESSION["estilo_reajustes"]==1){//si tiene reajustes
	$estilo_reajustes1='';
	$estilo_reajustes2='';
}else{//si no tiene reajustes
	$estilo_reajustes1='style="display:none"';
	$estilo_reajustes2='style="display:none"';
}
if($sel_item[80]==1 or $_SESSION["estilo_reembolsable"]==1){//si tiene reembolsables
	$estilo_reembolsables1='';
	$estilo_reembolsables2='';
}else{//si no tiene reembolsables
	$estilo_reembolsables1='style="display:none"';
	$estilo_reembolsables2='style="display:none"';
}
/** PARA EL DES011-18 **/

$sel_suario_par_tecnico = traer_fila_row(query_db("select us_id , nombre_administrador from t1_us_usuarios where us_id =".$sel_item[66]));

	if($sel_suario_par_tecnico[0]>0){$nombre_par_tecnico = "-".$sel_suario_par_tecnico[1]."----,".$sel_suario_par_tecnico[0];}
	
	$sel_suario_ger_contrato = traer_fila_row(query_db("select us_id , nombre_administrador from t1_us_usuarios where us_id =".$sel_item[67]));
	
	if($sel_suario_ger_contrato[0]>0){$nombre_ger_contrato = "-".$sel_suario_ger_contrato[1]."----,".$sel_suario_ger_contrato[0];}
?>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <?
        if($sel_item[1] != 1){
		?>
  <?
        }else{
	?>

  <input type="hidden" name="id_pecc_seleccion" id="id_pecc_seleccion" value="1" />
  <?
	}
		
		
		?>
  <?
        	if (($sel_item[6] == 2 or $sel_item[6] == 5 or $sel_item[6] == 7) and $es_profesional_designado == "SI"){
		?>
  <?
			}
        	if ($sel_item[6] == 8 and $es_profesional_designado == "SI"){
		?>
  <?
			}
	  ?>
  <?
      if(($sel_item[6] == 4 or $sel_item[6] == 5)){
	  ?>
  <?
      }else{
				
				?>
  <input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value="0"/>
  <?
				
				}
				
				
				$sel_textos_adjudicacion = traer_fila_row(query_db("select CAST(ob_solicitud_adjudica AS text), CAST(ob_contrato_adjudica AS text), CAST(alcance_adjudica AS text), CAST(justificacion_adjudica AS text), CAST(recomendacion_adjudica AS text),CAST(justificacion_tecnica_ad AS text),CAST(antecedentes_adjudicacion AS text) from $pi2 where id_item=".$id_item_pecc));
				
				$sel_textos_permiso = traer_fila_row(query_db("select CAST(objeto_solicitud AS text), CAST(objeto_contrato AS text), CAST(alcance AS text), CAST(justificacion AS text), CAST(recomendacion AS text),CAST(justificacion_tecnica AS text), CAST(antecedentes_permiso AS text) from $pi2 where id_item=".$id_item_pecc));
				
			/*	
				
				if($sel_item[6]==15 and $la_solicitud_que_modifica!="adjudicacion" and $sel_item[21]==0){//si es permiso y modificaciones
				$sel_textos_permiso_anterior = traer_fila_row(query_db("select CAST(objeto_solicitud AS text), CAST(objeto_contrato AS text), CAST(alcance AS text), CAST(justificacion AS text), CAST(recomendacion AS text),CAST(justificacion_tecnica AS text), CAST(antecedentes_permiso AS text) from $pi2 where id_item=".$sel_item[43]));				
					if($sel_textos_permiso[0]=="" or $sel_textos_permiso[0]==" " or $sel_textos_permiso[0]=="  "){ $sel_textos_permiso[0] = $sel_textos_permiso_anterior[0];}
					if($sel_textos_permiso[1]=="" or $sel_textos_permiso[1]==" " or $sel_textos_permiso[1]=="  "){ $sel_textos_permiso[1] = $sel_textos_permiso_anterior[1];}
					if($sel_textos_permiso[2]=="" or $sel_textos_permiso[2]==" " or $sel_textos_permiso[2]=="  "){ $sel_textos_permiso[2] = $sel_textos_permiso_anterior[2];}
					if($sel_textos_permiso[3]=="" or $sel_textos_permiso[3]==" " or $sel_textos_permiso[3]=="  "){ $sel_textos_permiso[3] = $sel_textos_permiso_anterior[3];}
					if($sel_textos_permiso[4]=="" or $sel_textos_permiso[4]==" " or $sel_textos_permiso[4]=="  "){ $sel_textos_permiso[4] = $sel_textos_permiso_anterior[4];}
					if($sel_textos_permiso[5]=="" or $sel_textos_permiso[5]==" " or $sel_textos_permiso[5]=="  "){ $sel_textos_permiso[5] = $sel_textos_permiso_anterior[5];}
					if($sel_textos_permiso[6]=="" or $sel_textos_permiso[6]==" " or $sel_textos_permiso[6]=="  "){ $sel_textos_permiso[6] = $sel_textos_permiso_anterior[6];}
				}
				
				if($sel_item[6]==15 and $la_solicitud_que_modifica=="adjudicacion" or $sel_item[21]!=0){//si es adjudicacion y modificaciones
				$sel_textos_adjudicacion_anterior = traer_fila_row(query_db("select CAST(ob_solicitud_adjudica AS text), CAST(ob_contrato_adjudica AS text), CAST(alcance_adjudica AS text), CAST(justificacion_adjudica AS text), CAST(recomendacion_adjudica AS text),CAST(justificacion_tecnica_ad AS text),CAST(antecedentes_adjudicacion AS text) from $pi2 where id_item=".$sel_item[43]));				
					if($sel_textos_adjudicacion[0]=="" or $sel_textos_adjudicacion[0]==" " or $sel_textos_adjudicacion[0]=="  "){ $sel_textos_adjudicacion[0] = $sel_textos_adjudicacion_anterior[0];}
					if($sel_textos_adjudicacion[1]=="" or $sel_textos_adjudicacion[1]==" " or $sel_textos_adjudicacion[1]=="  "){ $sel_textos_adjudicacion[1] = $sel_textos_adjudicacion_anterior[1];}
					if($sel_textos_adjudicacion[2]=="" or $sel_textos_adjudicacion[2]==" " or $sel_textos_adjudicacion[2]=="  "){ $sel_textos_adjudicacion[2] = $sel_textos_adjudicacion_anterior[2];}
					if($sel_textos_adjudicacion[3]=="" or $sel_textos_adjudicacion[3]==" " or $sel_textos_adjudicacion[3]=="  "){ $sel_textos_adjudicacion[3] = $sel_textos_adjudicacion_anterior[3];}
					if($sel_textos_adjudicacion[4]=="" or $sel_textos_adjudicacion[4]==" " or $sel_textos_adjudicacion[4]=="  "){ $sel_textos_adjudicacion[4] = $sel_textos_adjudicacion_anterior[4];}
					if($sel_textos_adjudicacion[5]=="" or $sel_textos_adjudicacion[5]==" " or $sel_textos_adjudicacion[5]=="  "){ $sel_textos_adjudicacion[5] = $sel_textos_adjudicacion_anterior[5];}
					if($sel_textos_adjudicacion[6]=="" or $sel_textos_adjudicacion[6]==" " or $sel_textos_adjudicacion[6]=="  "){ $sel_textos_adjudicacion[6] = $sel_textos_adjudicacion_anterior[6];}
				}
				*/
				
			//sin numero de incidente pecc inicio	
				$edicion_datos_generales=="SI";
				
			
				
	  ?>
	  
  <tr>
    <td colspan="3" align="center"  class="fondo_3">Informaci&oacute;n de la Adjudicaci&oacute;n</td>
  </tr>
  <tr>
    <td align="right"  class="letra-descuentos">Tipo de Solicitud:<?=$_GET['pecc']?></td>
    <td   class="letra-descuentos"><? echo traer_nombre_muestra($sel_item[4], $g11,"nombre","t1_tipo_contratacion_id");?></td>
    <td>&nbsp;</td>
  </tr>
  <?
  if($sel_item[14]>=6){
	  ?>
  <tr class="columna_subtitulo_resultados">
    <td align="right">PECC de origen de esta solicitud:</td>
    <td>
	<? if($sel_item[56]==1){ ?>
	
	  
	  <select name="origen_pecc" id="origen_pecc" onchange="activa_linea_pecc(this.value, '<?=$sel_item[0]?>','<?=$sel_item[71]?>','<?=$edicion_datos_generales?>')">
        <option value="1">Ninguno</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
      </select>
      <?
	  $edicion_datos_generales=="";
  }else{
	  
	  ?>
	  <select name="origen_pecc" id="origen_pecc" onchange="activa_linea_pecc(this.value, '<?=$sel_item[0]?>','<?=$sel_item[71]?>','<?=$edicion_datos_generales?>')">
       <option value="">Seleccione el origen de PECC</option>
        <option value="1" >Ninguno</option>
		<option value="2017"<? if($sel_item[56] == 2017) echo 'selected="selected"';?>>2017</option>
        <option value="2018"<? if($sel_item[56] == 2018) echo 'selected="selected"';?>>2018</option>
      </select>
	 
  <? }
  ?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
    <?//sin numero de incidente pecc fin?>
  <?
  
  $oculata_no_aplica_pecc= 'style="display:none"';
  $oculta_modificacion_pecc = 'style="display:none"';
  $oculata_no_aplica_sub_categoria = 'style="display:none"';
  
  //sin numero de incidente pecc inicio
  $oculata_linapecc3 = '';
  $oculata_modificapec3 = '';
//sin numero de incidente pecc fin

if($sel_item[72] == 1){//si se modifico el PECC
	$oculta_modificacion_pecc = '';
	}
	
if($sel_item[71] > 0){//si se modifico el PECC
	$sel_si_tiene_sub = traer_fila_row(query_db("select count(*) from t1_lineas_pecc_sub where id_linea_pecc = ".$sel_item[71]." and estado = 1"));
	if($sel_si_tiene_sub[0]>0){
		 $oculata_no_aplica_sub_categoria = '';
		}
	}
		
	
	//subir arriba de los dos if cuando se pase a productivo
//	$oculata_no_aplica_pecc= 'style="display:none"';
 // $oculta_modificacion_pecc = 'style="display:none"';
  
  ?>
 
   <?//sin numero de incidente pecc inicio?>
   
    <tr  class="columna_subtitulo_resultados" <?=$oculata_linapecc3;?> id="carga_liena_pecc3" >
 <?
 if($sel_item[56]==1){
	 $oculata_linapecc3 = 'style="display:none"';
  $oculata_modificapec3 = 'style="display:none"';
	$oculata_no_aplica_sub_categoria='style="display:none"';
 }else{
  
  ?>
 
   <td align="right">L&iacute;nea de la Subcategor&iacute;a Registrada en el PECC:</td>
    <td><? if($edicion_datos_generales == "SI"){ 
	
	if($sel_item[71] > 0){
	$sel_linea = traer_fila_row(query_db("select codigo, detalle from t1_lineas_pecc where id = '".$sel_item[71]."' and origen_pec=".$sel_item[56]));
	echo $sel_linea[0]." - ".$sel_linea[1];
	}
	?>
       <input type="hidden" name="linea_pecc" id="linea_pecc" value="<?=$sel_item[71]?>" />
      <?
}else{
	if($sel_item[71] > 0){
	$sel_linea = traer_fila_row(query_db("select codigo, detalle from t1_lineas_pecc where id = '".$sel_item[71]."' and origen_pec=".$sel_item[56]));
	echo $sel_linea[0]." - ".$sel_linea[1];
	}
	?>
      <input type="hidden" name="linea_pecc" id="linea_pecc" value="<?=$sel_item[71]?>" />
      <?
	}
	?></td>
    <td colspan="2">&nbsp;</td>
  
  
  <?
  
} ?>

  
	
	
</tr>
	
  
  <tr  class="columna_subtitulo_resultados" <?=$oculata_no_aplica_pecc;?> id="carga_liena_pecc" >
	
 </tr> 
  <tr  class="columna_subtitulo_resultados" <?=$oculata_no_aplica_sub_categoria;?> id="id_fila_deallesubcategoria">
    <td align="right">Detalle de la Subcategor&iacute;a Registrada en el PECC:</td>
    <td><div id="carga_detalle_subcategoria">
      <table width="200" border="0">
        <?
	if($edicion_datos_generales == "SI"){
    $sel_si_tiene_sub = query_db("select id, codigo, nombre from t1_lineas_pecc_sub where id_linea_pecc = ".$sel_item[71]." and estado = 1");
	}else{
		$sel_si_tiene_sub = query_db("select t1.id, t1.codigo, t1.nombre from t1_lineas_pecc_sub t1,t2_relacion_item_sub_linea_pecc t2  where t1.id = t2.id_sub_linea_pecc and t1.id_linea_pecc = ".$sel_item[71]." and t1.estado = 1 and id_item = ".$sel_item[0]."");
		}
	while($sel_sub_lineas = traer_fila_db($sel_si_tiene_sub)){
		$check = "";
		$sel_sub_relacionadas = traer_fila_row(query_db("select count(*) from t2_relacion_item_sub_linea_pecc where id_item = ".$sel_item[0]." and id_sub_linea_pecc = ".$sel_sub_lineas[0]));
		if($sel_sub_relacionadas[0] >0){
			$check = "checked='checked'";
			}
	?>
        <tr>
          <td width="<? if($edicion_datos_generales == "SI") echo "20"; else echo "1"; ?>"><? if($edicion_datos_generales == "SI"){ ?>
            <input name="linea_sub_<?=$sel_sub_lineas[0]?>" id="linea_sub_<?=$sel_sub_lineas[0]?>" type="checkbox" <?=$check?> value="<?=$sel_sub_lineas[0]?>" />
            <? } ?></td>
          <td width="170"><?=$sel_sub_lineas[1]?></td>
        </tr>
        <?
	}
	 ?>
      </table>
    </div></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr  class="columna_subtitulo_resultados" <?=$oculata_modificapec3;?> id="carga_modificacion_pecc3">
    <td align="right">Requiere Modificaci&oacute;n:</td>
    <td>
	 <?
	if($sel_item[72] == 1){
		echo "SI";
	}
	if($sel_item[72] == 2){
		echo "NO";
	}
	
	?>
      
      <?
	
	?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr  class="columna_subtitulo_resultados" <?=$oculata_no_aplica_pecc;?> id="carga_modificacion_pecc">
    <td align="right">Requiere Modificaci&oacute;n:</td>
    <td><? if($edicion_datos_generales == "SI"){ ?>
      <select name="pecc_modificado" id="pecc_modificado" onchange="activa_filas_modifiaciones(this.value)">
        <option value="0" >Seleccione si la linea del PECC fue modificada</option>
        <option value="2" <? if($sel_item[72] == 2) echo 'selected="selected"'?>  >NO</option>
        <option value="1" <? if($sel_item[72] == 1) echo 'selected="selected"'?>>SI</option>
      </select>
      <? $dto="1";
}else{
	 $dto="2";
	if($sel_item[72] == 1) echo "SI";
	if($sel_item[72] == 2) echo "NO";
	?>
      <input type="hidden" name="pecc_modificado" id="pecc_modificado" value="<?=$sel_item[72]?>" />
      <?
	}
	?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <?//sin numero de incidente pecc fin?>
  <tr class="columna_subtitulo_resultados" <?=$oculta_modificacion_pecc?> id="carga_observacion_modifica_pecc">
    <td align="right">Justificaci&oacute;n  de la Modificaci&oacute;n <img src="../imagenes/botones/help.gif" alt="Cu&aacute;l es la raz&oacute;n de la modificaci&oacute;n?" title="Cu&aacute;l es la raz&oacute;n de la modificaci&oacute;n?" width="20" height="20" /></td>
    <td colspan="3"><?
    $sel_item_relacionado_ob_modifica = traer_fila_row(query_db("select CAST(pecc_modificado_observacion AS TEXT) from $pi2 where id_item=".$sel_item[0]));
	?>
      <input name="pecc_id_sol_modifica" type="hidden" id="pecc_id_sol_modifica" size="25" value="<?=$sel_item[74]?>"/>
      <? if($edicion_datos_generales == "SI"){ ?>
      <textarea name="pecc_observacion_modificacion" id="pecc_observacion_modificacion" cols="45" rows="5"><?=$sel_item_relacionado_ob_modifica[0]?>
  </textarea>
      <?
}else{
	echo $sel_item_relacionado_ob_modifica[0];
	?>
      <input type="hidden" name="pecc_observacion_modificacion" id="pecc_observacion_modificacion" value="<?=$sel_item_relacionado_ob_modifica[0]?>" />
      <?
	}
	?></td>
    <?
  }else{
	  ?>
    <input type="hidden" name="origen_pecc" id="origen_pecc" value="<? if($sel_item[56]!="" and $sel_item[56]!="0") echo $sel_item[56]; else echo "1";?>" />
    <?
	  }
	  if($sel_item[6] == 6){
	  ?>
  <tr>
    <td align="right">Justificaci&oacute;n de la Adjudicaci&oacute;n Directa:</td>
    <td><select name="cat_nego_requiere_sondeo" id="cat_nego_requiere_sondeo">
      <option value="0">Seleccione</option>
      <?
          $sql_cat_req_sondeo = query_db("select * from t1_categoria_requiere_sondeo as t1 where estado = 1");
		  while($ct_r = traer_fila_row($sql_cat_req_sondeo)){
		  ?>
      <option value="<?=$ct_r[0]?>" <? if($ct_r[0] == $sel_item[77]) echo 'selected="selected"'?> >
        <?=$ct_r[1]?>
        </option>
      <?
		  }
		  ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <?
		}else{
			?>
  <input type="hidden" name="cat_nego_requiere_sondeo" id="cat_nego_requiere_sondeo" value="<?=$sel_item[75]?>"/>
  <?
			}
		
		 if ($sel_item[6] == 6 ){
?>
  <tr>
    <td align="right">Relacione el Numero de Sondeo de Mercado:</td>
    <td><?
	
if($edicion_datos_generales == "SI"){
	?>
      <strong class="windowPopup" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/pecc/busca_sondeos_urna.php","div_carga_busca_sol")' style="cursor:p">Buscar sondeos para relacionar a esta solicitud <img src="../imagenes/botones/aler-interro.gif" width="3"/></strong>
      <?
	$tipo_campo_sondeo = "hidden";
	if($sel_item[75] > 0){
		$tipo_campo_sondeo = "text";
		}
?>
      <input name="llena_lista_sondeos_l" type="hidden" id="llena_lista_sondeos_l" size="50" value="<?=$sel_item[75]?>" />
      <input name="llena_lista_sondeos_2" type="<?=$tipo_campo_sondeo?>" readonly id="llena_lista_sondeos_2" size="50" value="<?=$sel_item[76]?>" />
      <?
}else{


			}
		  ?></td>
    <td><strong class="letra-descuentos" >
      <? if($sel_item[75] == "" or $sel_item[75] == 0 ) {?>
      Recuerde que usted puede relacionar un sondeo de mercado
      <? }?>
    </strong></td>
  </tr>
  <?
	}else{
		?><input name="llena_lista_sondeos_2" type="hidden" readonly id="llena_lista_sondeos_2" size="50" value="<?=$sel_item[76]?>" /><?
		}
  ?>
  <tr>
    <td align="right">Proceso Especial o Anticipo, Requiere Aprobaci&oacute;n Extra del Comit&eacute; <img src="../imagenes/botones/help.gif" alt="Seleccione 'SI' si desea que este item vaya al comit&eacute;" title="Seleccione 'SI' si desea que este item vaya al comit&eacute;" width="20" height="20" /></td>
    <td width="36%"><?
        
		$sel_si_es_comite = traer_fila_row(query_db("select COUNT(*) from t2_nivel_servicio, t2_nivel_servicio_tiempos where t2_nivel_servicio.t2_nivel_servicio_id = t2_nivel_servicio_tiempos.t2_nivel_servicio_id and t2_nivel_servicio.t2_nivel_servicio_id = '".$sel_item[2]."' and t2_nivel_servicio_tiempos.t2_nivel_servicio_actividad_id in (8,17)"));
		
		if($sel_si_es_comite[0] > 0 and ($sel_item[24] == 2 or $sel_item[24] == 3)){
			echo "Esta solicitud debe ir a comit&eacute; obligatoriamente";
			?>
      <input type="hidden" name="req_comite" id="req_comite" value="2" />
      <?
			}else{
		
		if($edicion_datos_generales == "SI"){
		?>
      <select name="req_comite" id="req_comite">
        <option value="2" <? if($sel_item[24] == 2) echo 'selected="selected"'?>>NO</option>
        <option value="1" <? if($sel_item[24] == 1) echo 'selected="selected"'?>>SI</option>
      </select>
      <?
		}else{
			if($sel_item[24] == 2) echo "NO";
			if($sel_item[24] == 1) echo "SI";
			}
			}
			
		  ?></td>
    <td width="33%"><?
        $sel_si_tiene_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc));
			if($sel_si_tiene_presu[0]<=0){
			echo  "<span class='letra-descuentos'>ALERTA: Para poder ingresar la aprobacion extra de comit&eacute; se debe ingresar el presupuesto, SGPA tambien recibe valores en cero (0)</span>";
            
			}
		?></td>
  </tr>
  <tr>
    <td align="right"> Par T&eacute;cnico <img src="../imagenes/botones/help.gif" alt="Acá debe ingresar el nombre del profesional que apoyará la evaluación técnica del proceso, Este requisito aplica para los procesos que requieren aprobación de comité." title="Acá debe ingresar el nombre del profesional que apoyará la evaluación técnica del proceso, Este requisito aplica para los procesos que requieren aprobación de comité." width="20" height="20" /></td>
    <td colspan="2"><? if($edicion_datos_generales == "SI") {?>
      <input type="text" name="partecnico_bus_us" id="partecnico_bus_us" onkeypress="selecciona_lista()" value="<?=$nombre_par_tecnico?>"/>
      <? }else{
			echo traer_nombre_muestra($sel_item[66], $g1,"nombre_administrador","us_id");
			} ?></td>
  </tr>
  <tr>
    <td align="right">Gerente de Contrato <img src="../imagenes/botones/help.gif" alt="Acá debe ingresar el nombre del profesional que administrará el contrato." title="Acá debe ingresar el nombre del profesional que administrará el contrato." width="20" height="20" /></td>
    <td colspan="2"><? if($edicion_datos_generales == "SI") {?>
      <input type="text" name="gerente_contrato_bus_us" id="gerente_contrato_bus_us" onkeypress="selecciona_lista()" value="<?=$nombre_ger_contrato?>"/>
      <? }else{
			echo traer_nombre_muestra($sel_item[67], $g1,"nombre_administrador","us_id");
			} ?></td>
  </tr>
  <tr>
    <td align="right">Requiere Contrataci&oacute;n de Mano de Obra Local:</td>
    <td colspan="3"><? if($edicion_datos_generales == "SI"){if($sel_item[59] == 1) echo "Selecci&oacute;n en el Permiso SI<br />"; else echo "Selecci&oacute;n en el Permiso NO<br />";?>
      <select name="req_contra_mano_obra_local" id="req_contra_mano_obra_local">
        <option value="0" >Seleccione</option>
        <option value="2" <? if($sel_item[62] == 2) echo 'selected="selected"'?>  >NO</option>
        <option value="1" <? if($sel_item[62] == 1) echo 'selected="selected"'?>>SI</option>
      </select>
      <? }else{ if($sel_item[62] == 1) echo "SI"; else echo "NO";}?></td>
  </tr>
  <tr>
    <td align="right">Requiere Contrataci&oacute;n de Bienes y Servicios Local:</td>
    <td colspan="3"><? if($edicion_datos_generales == "SI"){ if($sel_item[60] == 1) echo "Selecci&oacute;n en el Permiso SI<br />"; else echo "Selecci&oacute;n en el Permiso NO<br />";?>
      <select name="req_cont_bien_ser_local" id="req_cont_bien_ser_local">
        <option value="0" >Seleccione</option>
        <option value="2" <? if($sel_item[63] == 2) echo 'selected="selected"'?>>NO</option>
        <option value="1" <? if($sel_item[63] == 1) echo 'selected="selected"'?>>SI</option>
      </select>
      <? }else{ if($sel_item[63] == 1) echo "SI"; else echo "NO";}?></td>
  </tr>
  <?
    $query="SELECT tiene_reajuste, tiene_retencion, tiene_reembolsable, como_reembolsable FROM $pi2 WHERE id_item=".$id_item_pecc;
    $tiene=traer_fila_row(query_db($query));?>
    <tr>
    <td align="right">Tiene Reajustes:</td>
    <td align="left">
    <?php if($edicion_datos_generales == "SI"){ 
		/** PARA EL DES011-18 **/
		if($_SESSION["estilo_reajustes"]==1){
			$tiene[0]=1;	
		}
		/** PARA EL DES011-18 **/
	?>
    <select name="reajuste" id="reajuste" onChange="muestra_reajuste_adj()">
      <option value="0">Seleccione</option>
      <option value="1" <? if($tiene[0] == 1) echo 'selected="selected"'?>>SI</option>
      <option value="2" <? if($tiene[0] == 2) echo 'selected="selected"'?>>NO</option>
    </select>
    <?php }else{
        if($tiene[0] == 1){
			/** PARA EL DES011-18 **/
			$estilo_reajustes1='style="display:none"';
			$estilo_reajustes2='';
			/** PARA EL DES011-18 **/
          echo "SI";
        }else if($tiene[0] == 2){
			/** PARA EL DES011-18 **/
			$estilo_reajustes1='style="display:none"';
			$estilo_reajustes2='style="display:none"';
			/** PARA EL DES011-18 **/
          echo "NO";
        }
      } ?>
    </td>
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    </tr>
    <tr class="observacion_reajuste" <?=$estilo_reajustes1?> id="observacion_reajuste1">
    	<td colspan="4">
			<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" style="">
				<tr>
					<td align="right">Observaci&oacute;n de Reajustes:</td>
					<td align="left">
						<textarea rows="4" cols="50" name="observacion_reajuste" id="observacion_reajuste"></textarea>
					</td>
					<td>
						<input type="button" value="Grabar" onClick="guarda_coment_reajuste()">
					</td>
				</tr>
			</table>
		</td>
    </tr>
    <tr class="observacion_reajuste" <?=$estilo_reajustes2?> id="observacion_reajuste2">
    	<td colspan="4">
			<table width="70%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
				<tr>
					<td colspan="4" align="center"  class="fondo_3">Observaciones Reajustes.</td>
				</tr>
				<tr>
					<td align="center"  class="fondo_3" width="80%">Observaci&oacute;n</td>
					<td align="center"  class="fondo_3" width="20%">Acci&oacute;n</td>
				</tr>
				<?
				$query_rejustes="SELECT id, CAST(observacion AS text) as observacion FROM t2_item_pecc_reembolsables_reajustes WHERE t2_item_pecc_id=".$sel_item[0]." AND estado=1 and tipo_observacion=1";
	  			$cont=0;
	  			$rs=query_db($query_rejustes);
	  			while($ls=traer_fila_db($rs)){
					if($cont == 0){
						$clase= "filas_resultados";
						$cont = 1;
					}else{
						$clase= "";
						$cont = 0;
					}
					?>
				<tr class="<?=$clase?>">
					<td align="center"><?=$ls[1]?></td>
					<td align="center"><img src="../imagenes/botones/icono_X.gif" alt="Eliminar" width="14" height="15" onclick="elimina_coment_reajuste_reembolsable('<?=arreglo_pasa_variables($ls[0])?>', 1, '')"></td>
				</tr>
					<?
					$cont++;
				}
				?>
			</table>
            
		</td>
    </tr>
  <tr>
  <tr>
   	<input type="hidden" name="reembolsable_reajuste_pasa" id="reembolsable_reajuste_pasa"/>
    <td align="right">Tiene Reembolsables:</td>
    <td align="left">
    <?php if($edicion_datos_generales == "SI"){
		/** PARA EL DES011-18 **/
		if($_SESSION["estilo_reembolsable"]==1){
			$tiene[2]=1;	
		}
<<<<<<< HEAD
		/** PARA EL DES011-18 **/	
	?>
      <select name="reembolsable" id="reembolsable">
=======
<<<<<<< HEAD
		/** PARA EL DES011-18 **/	
	?>
      <select name="reembolsable" id="reembolsable">
=======
<<<<<<< HEAD
		/** PARA EL DES011-18 **/
	?>
      <select name="reembolsable" id="reembolsable" onChange="muestra_reembolsable_adj()">
=======
		/** PARA EL DES011-18 **/	
	?>
      <select name="reembolsable" id="reembolsable">
>>>>>>> jeison
>>>>>>> cd55fdf13d0b6e096fb3a8f12ec7a37d374ddac2
>>>>>>> 858fa811433ba23131cb372a3028e26364c21c65
        <option value="0">Seleccione</option>
        <option value="1" <? if($tiene[2] == 1) echo 'selected="selected"'?>>SI</option>
        <option value="2" <? if($tiene[2] == 2) echo 'selected="selected"'?>>NO</option>
      </select>
    <?php }else{
        //echo $query;
         if($tiene[2] == 1){
			/** PARA EL DES011-18 **/
			$estilo_reembolsables1='style="display:none"';
			$estilo_reembolsables2='';
			/** PARA EL DES011-18 **/
          echo "SI";
        }else if($tiene[2] == 2){
			/** PARA EL DES011-18 **/
			$estilo_reembolsables1='style="display:none"';
			$estilo_reembolsables2='style="display:none"';
			/** PARA EL DES011-18 **/
          echo "NO";
        }
      } ?>
    </td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr class="observacion_reembolsable" <?=$estilo_reembolsables1?> id="observacion_reembolsable1">
    	<td colspan="4">
			<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" style="">
				<tr>
					<td align="right">Observaci&oacute;n de Reembolsables:</td>
					<td align="left">
						<textarea rows="4" cols="50" name="observacion_reembolsable" id="observacion_reembolsable"></textarea>
					</td>
					<td>
						<input type="button" value="Grabar" onClick="guarda_coment_reembolsable()">
					</td>
				</tr>
			</table>
		</td>
    </tr>
    <tr class="observacion_reembolsable" <?=$estilo_reembolsables2?> id="observacion_reembolsable2">
    	<td colspan="4">
			<table width="70%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
				<tr>
					<td colspan="4" align="center"  class="fondo_3">Observaciones Reembolsables.</td>
				</tr>
				<tr>
					<td align="center"  class="fondo_3" width="80%">Observaci&oacute;n</td>
					<td align="center"  class="fondo_3" width="20%">Acci&oacute;n</td>
				</tr>
				<?
				 $query_rejustes="SELECT id, CAST(observacion AS text) as observacion FROM t2_item_pecc_reembolsables_reajustes WHERE t2_item_pecc_id=".$sel_item[0]." AND estado=1 and tipo_observacion=2";
	  			$cont=0;
	  			$rs=query_db($query_rejustes);
	  			while($ls=traer_fila_db($rs)){
					if($cont == 0){
						$clase= "filas_resultados";
						$cont = 1;
					}else{
						$clase= "";
						$cont = 0;
					}
					?>
				<tr class="<?=$clase?>">
					<td align="center"><?=$ls[1]?></td>
					<td align="center"><img src="../imagenes/botones/icono_X.gif" alt="Eliminar" width="14" height="15" onclick="elimina_coment_reajuste_reembolsable('<?=arreglo_pasa_variables($ls[0])?>', 2, '')"></td>
				</tr>
					<?
					$cont++;
				}
				?>
			</table>
		</td>
    </tr>
      <input type="hidden" name="como_valida" id="como_valida" value="<?=$tiene[2]?>">
      <input type="hidden" name="tipo_remmbolsable_reajuste" id="tipo_remmbolsable_reajuste" value="<?=$tiene[2]?>">
  <?
    if($tiene[2] == 1){//SI APLICA REEMBOLSABLE MUESTRA LA OPCCIÓN PARA ESCOGER COMO AGRUPAR LA SOLICITUD
  ?>
    <tr>
      <td align="right">Como Aplica Reembolsable:</td>
      <td align="left">
      <?php if($edicion_datos_generales == "SI"){ ?>
        <select name="como_reembolsable" id="como_reembolsable">
          <option value="0">Seleccione</option>
          <option value="1" <? if($tiene[3] == 1) echo 'selected="selected"'?>>Cosolidado</option>
          <option value="2" <? if($tiene[3] == 2) echo 'selected="selected"'?>>Proveedor</option>
        </select>
      <?php }else{
           if($tiene[3] == 1){
            echo "Cosolidado";
          }else if($tiene[3] == 2){
            echo "Proveedor";
          }
        } ?>
      </td>
      <td align="right">&nbsp;</td>
    </tr>
  <?
    }//SI APLICA REEMBOLSABLE MUESTRA LA OPCCIÓN PARA ESCOGER COMO AGRUPAR LA SOLICITUD
    if(($sel_item[6] == 6 or $sel_item[6] == 15)  /*and $tiene_rol_profesional == "SI"*/){
    
  ?>
  
  <tr>
    <td align="right">Preparador:</td>
    <td colspan="2"><? echo traer_nombre_muestra($sel_item[36], $g1,"nombre_administrador","us_id");?></td>
  </tr>
  <tr>
    <td align="right">Gerente del ITEM:</td>
    <td colspan="2"><? echo traer_nombre_muestra($sel_item[3], $g1,"nombre_administrador","us_id");?></td>
  </tr>
  <tr>
    <td align="right"><? 
		
		if($sel_si_es_soporte_abas[0] > 0){
			echo "Gestion Abastecimiento";
			}else{
		if($sel_item[4] == 2 or $sel_item[4] == 3 or $sel_item[4] == 4) echo "Comprador"; else echo "Profesional de C&amp;C";
			}
		
		
		?>
      :</td>
    <td colspan="2"><?
		 		
			echo saca_nombre_lista($g1,$sel_item[23],'nombre_administrador','us_id');
				?>
      <input type="hidden" name="us_prof" id="us_prof" value="<?=$sel_item[23]?>" /></td>
  </tr>
  <tr>
    <td align="right">Tipo de Proceso <img src="../imagenes/botones/help.gif" alt="Indica el tipo de proceso que utilizara para la solicitud." title="Indica el tipo de proceso que utilizara para la solicitud." width="20" height="20" /></td>
    <td colspan="2"><?
        	if(($sel_item[6] <> 7 and $sel_item[6] <> 8) and $edicion_datos_generales == "SI"){
				
				if($sel_item[4]<>2 and $sel_item[4]<>3 and $sel_item[4]<>4){
					$funti = 'onchange="valida_tipo_proceso_edicion(this)"';
				}
		
		?>
      <select name="tipo_proceso" id="tipo_proceso" <?=$funti?>>
        <?
			$quita_pone_adjudica_directo = "6,";
            if($tiene_rol_profesional == "SI"){
				$quita_pone_adjudica_directo = "";
				}
			?>
        <? 
			if($sel_item[4]==2 or $sel_item[4]==3 or $sel_item[4]==4){
			echo listas($g13, " estado = 1 and t1_tipo_proceso_id not in (".$quita_pone_adjudica_directo."7,8,5)",$sel_item[6] ,'nombre', 1);
				}else{
				if($sel_item[85] == 'SI'){//si alguna vez a sido SM
						echo listas($g13, " estado = 1 and t1_tipo_proceso_id in (2, 16, 6, 2, 5)",$sel_item[6] ,'nombre', 1);
						}else{
							echo listas($g13, " estado = 1 and t1_tipo_proceso_id not in (".$quita_pone_adjudica_directo."7,8)",$sel_item[6] ,'nombre', 1);
						}
			
				}
			?>
      </select>
      <?
			}else{
				?>
      <input type="hidden" name="tipo_proceso" id="tipo_proceso" value="<?=$sel_item[6]?>"/>
      <?	
				if($sel_item[6] == 8 and $sel_item[4] <> 1){
				echo "Orden de Pedido Contrato Marco/Lista de Precios";
				}else{
				echo saca_nombre_lista($g13,$sel_item[6],'nombre','t1_tipo_proceso_id');	
					}
				if($sel_item[6] == 7 or $sel_item[6] == 8){
					
						$sel_item_ot_apl = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[26]));
						
						echo "<strong> de la solicitud: ".numero_item_pecc($sel_item_ot_apl[0],$sel_item_ot_apl[1],$sel_item_ot_apl[2])." </strong>";
					}
				}
				
				
		?></td>
  </tr>
  <?

  if($sel_item[6] == 15){// si es modificacion.

	  ?>
  <tr>
    <td align="right">Contrato  Relacionado:</td>
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
					
					if($sel_item[43]==0){
						if($sel_item[6]==11){							
							$completa_auto="infomativo";
							}
							
				
						
						
		?>
      <table width="100%">
        <tr>
          <td width="56%"><?
 	?>
            <input name="contratos_normales" type="text" id="contratos_normales" size="25"  onkeypress="selecciona_lista('<?=$completa_auto?>')" value="<?=$nombr_contrta?>"/>
            <?

	?></td>
          <td width="44%"><?
     if(($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 11 or $sel_item[6] == 12 or $sel_item[6] == 10 or $sel_item[6] == 15 or $sel_item[69]==1)){
	?>
            <span onclick="pone_datos_contrato_edicion(document.principal.contratos_normales.value)">Cargar Informaci&oacute;n del Contrato <img src="../imagenes/botones/2.gif"  /></span> <img src='../imagenes/botones/eliminada_temporal.gif' onClick='valida_tipo_proceso(11)' />
            <?
	 }
	?></td>
        </tr>
      </table>
      <?
					}else{
						?>
      <input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value=""/>
      <?
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
				
				
			  ?>
      <input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value="<?=$sel_item[21]?>"/>
      <?
			  }
	?>
    </div></td>
  </tr>
  <? } ?>
  <tr class="columna_subtitulo_resultados">
    <td align="right">Solicitud Relacionada:</td>
    <td colspan="3"><div id="informativo_solicitud">
      <?
        if($sel_item[69]==1 or $sel_item[43]>0){
		
		        
			if($sel_item[69]==1){
				$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[43]));
				echo "<font color ='#ff0000'> Atenci&oacute;n: Esta solicitud es una modificaci&oacute;n a la solicitud ".numero_item_pecc($sel_item_relacionado[0],$sel_item_relacionado[1],$sel_item_relacionado[2])."</font>";
				}else{
					$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[43]));
				echo numero_item_pecc($sel_item_relacionado[0],$sel_item_relacionado[1],$sel_item_relacionado[2]);
					}
		
		
		}
		?>
    </div></td>
  </tr>
  <tr>
    <td align="right">Area Usuaria <img src="../imagenes/botones/help.gif" alt="&aacute;rea de este proceso." width="20" height="20"  title="&aacute;rea de este proceso."/></td>
    <td colspan="2"><?
    if($edicion_datos_generales == "SI"){
	?>
      <select name="area_usuaria" id="area_usuaria">
        <?
	  $verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 8 and us_id =".$_SESSION["id_us_session"]));
if($verifica_permiso[0]>0){
	echo listas($g12, " estado = 1",$sel_item[5] ,'nombre', 1);
}else{
      $sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$_SESSION["id_us_session"]." and t1.estado = 1");
	  while($sel_a_usuario = traer_fila_db($sel_areas)){
	  ?>
        <option value="<?=$sel_a_usuario[0]?>" <? if($sel_item[5] == $sel_a_usuario[0]) echo 'selected="selected"'?> >
          <?=$sel_a_usuario[1]?>
        </option>
        <?
      }
	  
}
	  ?>
      </select>
      <?
	}else{
		echo saca_nombre_lista($g12,$sel_item[5],'nombre','t1_area_id');
		}
	   ?></td>
  </tr>
  <tr>
    <td align="right">Fecha en la que se Requiere el Servicio <img src="../imagenes/botones/help.gif" alt="Fecha estimada en la cual requiere la solicitud." title="Fecha estimada en la cual requiere la solicitud." width="20" height="20" /></td>
    <td colspan="2"><?
if($edicion_datos_generales == "SI"){
?>
      <input name="fecha" type="text" id="fecha" size="5" value="<?=$sel_item[7]?>"  onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha')"  />
      <?
}else{
		echo $sel_item[7];
	}
?></td>
  </tr>
  <?
  }else{
	  ?>
	  <input type="hidden" name="tipo_proceso" id="tipo_proceso" value="<?=$sel_item[6]?>"/>
	  <?
	  }
  ?>
  <tr>
    <td align="right">Objeto de la Solicitud <img src="../imagenes/botones/help.gif" alt="Actividad o servicio que se desea realizar a trav&eacute;s del contrato." title="Actividad o servicio que se desea realizar a trav&eacute;s del contrato." width="20" height="20" /></td>
    <td colspan="2" class="linea_campo_sol"><?
        	if(($sel_item[6] <> 7 and $sel_item[6] <> 8) and $edicion_datos_generales == "SI"){
		?>
      <textarea name="objeto_solicitud" id="objeto_solicitud" cols="25" rows="5"><? if($sel_textos_adjudicacion[0] == "") echo $sel_textos_permiso[0]; else echo $sel_textos_adjudicacion[0];?>
  </textarea>
      <?
			}else{
				if($sel_textos_adjudicacion[0] == "") echo nl2br($sel_textos_permiso[0]); else echo nl2br($sel_textos_adjudicacion[0]);
				}
		?></td>
  </tr>
  <tr>
    <td width="31%" align="right">Objeto del Contrato <img src="../imagenes/botones/help.gif" alt="Describe el objeto conciso del contrato." width="20" height="20" title="Describe el objeto conciso del contrato." /></td>
    <td colspan="2" class="linea_campo_sol"><?
        	if(($sel_item[6] <> 7 and $sel_item[6] <> 8) and $edicion_datos_generales == "SI"){
		?>
      <textarea name="objeto_contrato" id="objeto_contrato" cols="25" rows="5"><? if($sel_textos_adjudicacion[1] == "") echo $sel_textos_permiso[1]; else echo $sel_textos_adjudicacion[1];?>
  </textarea>
      <?
			}else{
				if($sel_textos_adjudicacion[1] == "") echo nl2br($sel_textos_permiso[1]); else echo nl2br($sel_textos_adjudicacion[1]);
				}
		?></td>
  </tr>
  <tr>
    <td align="right"><?
    /*if($sel_item[4] <> 1){ //ESTAS LIEAS SE COMENTAREAN PORQUE EL ALCANCE YA ESTÁ HABILITAQDO TAMBÍEN PARA BIENSE
		
		echo "Si esta Adjudicaci&oacute;n Hace Parte de Otro Proceso, Relacionelo Aqu&iacute;";
	}else{
		echo "Alcance";
		}*/
    echo "Alcance";
	?>
      <img src="../imagenes/botones/help.gif" alt="Alcance detallado donde se indique el &aacute;rea o &aacute;reas en las cuales se utilizar&aacute; el contrato." title="Alcance detallado donde se indique el &aacute;rea o &aacute;reas en las cuales se utilizar&aacute; el contrato." width="20" height="20" /></td>
    <td colspan="2" class="linea_campo_sol"><?
        	if(($sel_item[6] <> 7 and $sel_item[6] <> 8) and $edicion_datos_generales == "SI"){
		?>
      <textarea name="alcance" id="alcance" cols="25" rows="5"><? if($sel_textos_adjudicacion[2] == "") echo $sel_textos_permiso[2]; else echo $sel_textos_adjudicacion[2];?>
  </textarea>
      <?
        }else{
				if($sel_textos_adjudicacion[2] == "") echo nl2br($sel_textos_permiso[2]); else echo nl2br($sel_textos_adjudicacion[2]);
				}
		?></td>
  </tr>
  <tr>
    <td align="right">Justificaci&oacute;n T&eacute;cnica <strong><img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
" title="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
"  width="20" height="20" /></strong></td>
    <td colspan="2" class="linea_campo_sol"><?
if($edicion_datos_generales == "SI"){
?>
      <textarea name="justificacion2" id="justificacion2" cols="25" rows="5"><? if($sel_textos_adjudicacion[5] == "") echo $sel_textos_permiso[5]; else echo $sel_textos_adjudicacion[5];?>
      </textarea>
      <?
}else{
			if($sel_textos_adjudicacion[5] == "") echo nl2br($sel_textos_permiso[5]); else echo nl2br($sel_textos_adjudicacion[5]);
			}
		?></td>
  </tr>
  <?
         if($sel_textos_adjudicacion[3] != "" and $sel_textos_adjudicacion[3] != " " and $sel_textos_adjudicacion[3] != "   "){
         ?>
  <tr>
    <td align="right">Justificaci&oacute;n Comercial <img src="../imagenes/botones/help.gif" alt="Indica el porqué se realiza la solicitud y porqué sugiere el Tipo de Proceso solicitado. Principal campo de consulta." title="Indica el porqué se realiza la solicitud y porqué sugiere el Tipo de Proceso solicitado. Principal campo de consulta." width="20" height="20" /></td>
    <td colspan="2" class="linea_campo_sol"><?
			echo $sel_textos_adjudicacion[3];
			
		?></td>
  </tr>
  <?
		 }
      ?>
  <input type="hidden" name="justificacion" id="justificacion" value="<?=$sel_textos_adjudicacion[3]?>" />
  <?
      
	  ?>
  <tr>
    <td align="right">Antecedentes <img src="../imagenes/botones/help.gif" alt="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" title="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" width="20" height="20" /></td>
    <td colspan="2" class="linea_campo_sol"><?
if($edicion_datos_generales == "SI"){
?>
      <textarea name="antecedentes_texto" id="antecedentes_texto" cols="25" rows="5"><? if($sel_textos_adjudicacion[6] == "") echo $sel_textos_permiso[6]; else echo $sel_textos_adjudicacion[6];?>
  </textarea>
      <br />
      Adjuntar antecedente:
      <input type="file" name="antecedente_anexo" id="antecedente_anexo" />
      <?

		$sl_anexos = traer_fila_row(query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us, antecedente_comite
 from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'antecedente' and antecedente_comite = 1"));
 
 if($sl_anexos[0]>0 and $sl_anexos[5] != " "){
	 echo " <br /><strong>Antecedente Adjunto:</strong> ";
			  ?>
      <?=saca_nombre_anexo($sl_anexos[5])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" /> </a>
      <?
	 }
      
}else{
	if($sel_textos_adjudicacion[6] == "") echo $sel_textos_permiso[6]; else echo $sel_textos_adjudicacion[6];
	
	$sl_anexos = traer_fila_row(query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us, antecedente_comite
 from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'antecedente' and antecedente_comite = 1"));
 
 if($sl_anexos[0]>0 and $sl_anexos[5] != " "){
	 echo " <br /> <strong>Antecedente Adjunto:</strong> ";
			  ?>
      <?=saca_nombre_anexo($sl_anexos[5])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" /> </a>
      <?
 }
 
	}
		?>
      <input type="hidden" name="con_anexo_antecedente" id="con_anexo_antecedente" value="<?=$sl_anexos[0]?>" /></td>
  </tr>
  <?
    
	?>
  <tr>
    <td align="right">Recomendaci&oacute;n <img src="../imagenes/botones/help.gif" alt="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." width="20" height="20" title="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." /></td>
    <td colspan="2" class="linea_campo_sol"><?
if($edicion_datos_generales == "SI"){
	
?>
      <textarea name="recomendacion" id="recomendacion" cols="25" rows="5"><? if($sel_textos_adjudicacion[4] == "") echo $sel_textos_permiso[4]; else echo $sel_textos_adjudicacion[4];?>
  </textarea>
      <?
}else{
	if($sel_textos_adjudicacion[4] == "") echo nl2br($sel_textos_permiso[4]); else echo nl2br($sel_textos_adjudicacion[4]);
	}
		?></td>
  </tr>
  <?
  /*OBJETIVOS DEL PROCESO*/
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
  /*FIN OBJETIVOS DEL PROCESOS*/
  ?>
  <tr>
    <td colspan="3" align="right"><table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF"   class="tabla_lista_resultados">
      <tr>
        <td align="center"  class="fondo_3"><?=$titulo_principal?></td>
        <td align="center" class="fondo_3">Descripci&oacute;n</td>
      </tr>
      <?

	  ?>
      <tr>
        <td width="31%" align="right"><?=$titulo1?>
          <img src="../imagenes/botones/help.gif" alt="<?=$ayuda1?>" width="20" height="20" title="<?=$ayuda1?>" /></td>
        <td width="69%" align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
          <textarea name="campos1" id="campos1"><?=$p_oportunidad?>
  </textarea>
          <? } else {echo $p_oportunidad; }?></td>
      </tr>
      <?
      if($titulo2!="NO aplica"){
	  ?>
      <tr>
        <td align="right"><?=$titulo2?>
          <img src="../imagenes/botones/help.gif" alt="<?=$ayuda2?>" width="20" height="20" title="<?=$ayuda2?>" /></td>
        <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
          <textarea name="campos2" id="campos2"><?=$p_costo?>
  </textarea>
          <? } else echo $p_costo; ?></td>
      </tr>
      <?
	  }else{?>
      <input type="hidden" name="campos2" id="campos2" value="<?=$p_costo?>" />
      <? }
	  ?>
      <tr>
        <td align="right"><?=$titulo3?>
          <img src="../imagenes/botones/help.gif" alt="<?=$ayuda3?>" width="20" height="20" title="<?=$ayuda3?>" /></td>
        <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
          <textarea name="campos3" id="campos3"><?=$p_calidad?>
  </textarea>
          <? } else echo $p_calidad; ?></td>
      </tr>
      <tr>
        <td align="right"><?=$titulo4?>
          <img src="../imagenes/botones/help.gif" alt="<?=$ayuda4?>" width="20" height="20" title="<?=$ayuda4?>" /></td>
        <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
          <textarea name="campos4" id="campos4"><?=$p_optimizar?>
  </textarea>
          <? } else echo $p_optimizar; ?></td>
      </tr>
      <tr>
        <td align="right"><?=$titulo5?>
          <img src="../imagenes/botones/help.gif" alt="<?=$ayuda5?>" width="20" height="20" title="<?=$ayuda5?>" /></td>
        <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
          <textarea name="campos5" id="campos5"><?=$p_trazabilidad?>
  </textarea>
          <? } else echo $p_trazabilidad; ?></td>
      </tr>
      <tr>
        <td align="right"><?=$titulo6?>
          <img src="../imagenes/botones/help.gif" alt="<?=$ayuda6?>" width="20" height="20" title="<?=$ayuda6?>" /></td>
        <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
          <textarea name="campos6" id="campos6"><?=$p_transparencia?>
  </textarea>
          <? } else echo $p_transparencia; ?></td>
      </tr>
      <tr>
        <td align="right"><?=$titulo7?>
          <img src="../imagenes/botones/help.gif" alt="<?=$ayuda7?>" width="20" height="20" title="<?=$ayuda7?>" /></td>
        <td align="left" class="linea_campo_sol"><? if($edicion_datos_generales=="SI") { ?>
          <textarea name="campos7" id="campos7"><?=$p_sostenibilidad?>
  </textarea>
          <? } else echo $p_sostenibilidad; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="center"><?
if($edicion_datos_generales == "SI"){
?>
      <?
        if( ($sel_item[14] == 31 and $sel_item[6]==15) and $edicion_datos_generales == "SI" and $sel_usu_emulan[0] == 0){
		?>
      <table>
        <tr>
          <td><input type="button" name="button4" id="button4" value="Grabar Informaci&oacute;n Temporalmente" class="boton_grabar" onclick="grabar_informacion_adjudicacion()" /></td>
          <td><select name="conflito_intere_sel" id="conflito_intere_sel">
            <option value="0">Seleccione si Tiene Conflicto de Intereses</option>
            <option value="1">SI Tiene Conflicto de Intereses</option>
            <option value="2">NO Tiene Conflicto de Intereses</option>
          </select>
            <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar este proceso y poner en firme" onclick="siguiente_nivel_agl('Esta Seguro de firmar y declarar que no tiene conflicto de intereses?','0')"/></td>
        </tr>
      </table>
      <?
		}else{
		?>
      <input type="button" name="button4" id="button4" value="Grabar Informaci&oacute;n de la Adjudicaci&oacute;n" class="boton_grabar" onclick="grabar_informacion_adjudicacion()" />
      <?
		}
}
?>
<input type="hidden" name="solicitud_que_carga" id="solicitud_que_carga" value="<?=$sel_item[43]?>" />
</td>
  </tr>
</table>
