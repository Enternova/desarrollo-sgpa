<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	$edicion_datos_generales = "NO";
	if(verifica_permiso_pecc($sel_item[14], $sel_item[0]) == "SI"){
			$edicion_datos_generales = "SI";
		}
	$edicion_datos_doc_basica = "NO";
	if(verifica_permiso_doc_basica($sel_item[14], $sel_item[0]) == "SI"){
			$edicion_datos_doc_basica = "SI";
		}
	$edicion_ensamble_doc = "NO";
	if(verifica_permiso_ensamble_doc($sel_item[14], $sel_item[0]) == "SI"){
			$edicion_ensamble_doc = "SI";
		}
	$edicion_negociacion = "NO";
	if(verifica_permiso_negociacion($sel_item[14], $sel_item[0]) == "SI"){
			$edicion_negociacion = "SI";
		}
		
		
	$es_profesional_designado = verifica_usuario_indicado_solo_si(8,$sel_item[0]);
		
	
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
    <td width="71%" valign="top">
    
    <table width="100%" border="0" align="center" class="tabla_lista_resultados">
        <tr>
          <td width="79%">
          <?
          if ($edicion_datos_doc_basica == "SI"){
		  ?>
          <table width="100%" border="0" align="center" class="tabla_lista_resultados">
            <tr>
              <td colspan="2" align="center" class="fondo_3">Agregar Documentaci&oacute;n B&aacute;sica de la Negociaci&oacute;n<img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
            </tr>
            <tr>
              <td width="21%" align="right">Detalle del Documento:</td>
              <td width="25%" align="left"><textarea name="doc_basico" cols="25" id="doc_basico"></textarea></td>
            </tr>
            <tr>
              <td align="right">Seleccionar Archivo Adjunto:</td>
              <td align="left"><input name="adj_doc_basico" type="file" id="adj_doc_basico" size="5" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="center"><input name="button3" type="button" class="boton_grabar" id="button3" value="Agregar Documentaci&oacute;n B&aacute;sica de la Negociaci&oacute;n"  onclick="graba_anexo_edicion(10)"/></td>
            </tr>
          </table>
          <?
		  }
		  ?>
          <?
        $cuantos_doc_basico = traer_fila_row(query_db("select count(*) from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'doc_basico'"));
		if($cuantos_doc_basico[0]>0){
		?>
        
            
            <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
              <tr>
                <td colspan="3" align="center"  class="fondo_3">Lista de Documentaci&oacute;n B&aacute;sica de la Negociaci&oacute;n</td>
              </tr>
              <tr>
                <td width="54%" align="center" class="fondo_3">Detalle de los Documentos</td>
                <td width="36%" align="center" class="fondo_3">Archivo Adjunto</td>
                <td width="10%" align="center" class="fondo_3">Eliminar</td>
              </tr>
              <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'doc_basico'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
              <tr class="<?=$clase?>">
                <td align="center" ><?=nl2br($sl_anexos[4])?></td>
                <td align="center" >
                  <?=saca_nombre_anexo($sl_anexos[5])?>
                  <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
                </td>
                <td align="center" >
                  <?
          if ($edicion_datos_doc_basica == "SI"){
		  ?>
                  <img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onclick="eliminar_anexo_edicion(10, <?=$sl_anexos[0]?>)">
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
        }//SI HAY DOCUMENTACION BASICA
		?>
        <table width="100%" border="0" align="center" class="tabla_lista_resultados">
    <tr>
      <td colspan="2">
        <?
          if ($edicion_ensamble_doc == "SI"){
		  ?>
        <table width="100%" border="0" align="center" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center" class="fondo_3">Agregar Ensamble de Documentaci&oacute;n<img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
            </tr>
          <tr>
            <td width="21%" align="right">Detalle del Documento:</td>
            <td width="25%" align="left"><textarea name="doc_ensamble" cols="25" id="doc_ensamble"></textarea></td>
            </tr>
          <tr>
            <td align="right">Seleccionar Archivo Adjunto:</td>
            <td align="left"><input name="adj_doc_ensamble" type="file" id="adj_doc_ensamble" size="5" /></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="center"><input name="button3" type="button" class="boton_grabar" id="button3" value="Agregar Documentaci&oacute;n B&aacute;sica de Ensamble"  onclick="graba_anexo_edicion(11)"/></td>
            </tr>
          </table>
        <?
		  }
		  ?>
        </td>
      </tr>
    <?
        $cuantos_doc_basico = traer_fila_row(query_db("select count(*) from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'doc_ensamble'"));
		if($cuantos_doc_basico[0]>0){
		?>
    <tr>
      <td colspan="2" valign="top">
        
        <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="3" align="center"  class="fondo_3">Lista de Documentaci&oacute;n de Ensamble de la Negociaci&oacute;n</td>
            </tr>
          <tr>
            <td width="54%" align="center" class="fondo_3">Detalle de los Documentos</td>
            <td width="36%" align="center" class="fondo_3">Archivo Adjunto</td>
            <td width="10%" align="center" class="fondo_3">Eliminar</td>
            </tr>
          <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'doc_ensamble'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
          <tr class="<?=$clase?>">
            <td align="center" ><?=nl2br($sl_anexos[4])?></td>
            <td align="center" >
              <?=saca_nombre_anexo($sl_anexos[5])?>
              <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                </a>
              </td>
            <td align="center" >
              <?
          if ($edicion_ensamble_doc == "SI"){
		  ?>
              <img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onclick="eliminar_anexo_edicion(11, <?=$sl_anexos[0]?>)">
              <?
		  }
			  ?>
              </td>
            </tr>
          <?
}
		}
  ?>
  </table>
  </td>
      </tr>
    
    <tr>
      <td width="50%" align="center" valign="top">
        
        </td>
      <td width="50%" align="center" valign="top">
        
        </td>
      </tr>
    
  </table>
          </td>
          <td width="21%" rowspan="3" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
        </tr>
        <br />
       
  <tr>
    <td valign="top" >
      <?
          if ($edicion_datos_doc_basica == "SI" or $edicion_ensamble_doc == "SI" or $edicion_negociacion == "SI"){
			  
			  if($sel_item[14] == 11 or $sel_item[14] == 10){
				  	$titulo_botom = "Terminar el cargue de la documentaci&oacute;n b&aacute;sica";
				  }
				 if($sel_item[14] == 12){
				  	$titulo_botom = "Comenzar con la negociaci&oacute;n";
					
				  }
				  if($sel_item[14] == 13){
				  	$titulo_botom = "Terminar la negociaci&oacute;n / Evaluaci&oacute;n Econ&oacute;mica";
				  }
		  ?>
      <table width="100%" align="left" cellpadding="2" cellspacing="2" border="0">
      <tr>
        <td width="12%" align="right">
        <?
          if ($es_profesional_designado == "SI" and ($sel_item[6] <> 2  or $sel_item[14] <> 12)){
		  ?>
          Observaci&oacute;n de la Devoluci&oacute;n:
          <?
		  }
		  ?></td>
        <td width="38%">
          <?
          if ($es_profesional_designado == "SI" and ($sel_item[6] <> 2  or $sel_item[14] <> 12) ){
		  ?>
          <textarea name="observa_atras" rows="5" id="observa_atras"></textarea>
          <?
		  }
		?>
        </td>
        <td width="50%" align="center">
		Control Coso-Sox C.4.1.8
		<?
          if ($es_profesional_designado == "SI" and $sel_item[14] == 12){
			  
		  ?><select name="aplica_procurement" id="aplica_procurement">
          <option value="1" <? if($sel_item[28] == 1) echo 'selected="selected"'?> >SI, Crearlo en la Urna Virtual</option>
         
          </select>
        <?
		// <option value="2" <? if($sel_item[28] == 2) echo 'selected="selected"'? >>NO Lo voy a Crear en la Urna Virtual</option>
		  }else{
			  
			  if($sel_item[14] > 12){
			  if($sel_item[28] == 1) echo 'Este Proceso se Creo en la Urna Virtual';
			  if($sel_item[28] == 2) echo 'Este Proceso NO se ha Creo en la Urna Virtual';
			  }
			  
			  }
		  ?>
          
          </td>
      </tr>
        <tr>
          <td colspan="2"><?
          if ($es_profesional_designado == "SI" and ($sel_item[6] <> 2  or $sel_item[14] <> 12)){
		  ?>
            <input type="button" name="button2" id="button2" value="Devolver al Nivel Anterior" class="boton_grabar_cancelar" onclick="devolver_item_negociacion()" />
            <?
		  }
		  ?></td>
          <td width="50%" align="center"><input type="button" name="button" id="button" value="<?=$titulo_botom ?>" class="boton_grabar" onclick="siguiente_nivel_servicio('Esta Seguro de Enviar al Siguiente Nivel de Servicio?')" /></td>
          </tr>
        </table>
      <?
		  }
		  ?></td>
      </tr>
      

</table>
</td></tr>
</table>

<input type="hidden" name="id_anexo_elimina" id="id_anexo_elimina" value="" />
<input type="hidden" name="tipo_anexo" id="tipo_anexo" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
</body>
</html>
