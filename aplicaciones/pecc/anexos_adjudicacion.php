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
	$datosExtemporaneos = "NO";
	if(verifica_permiso_pecc($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] == 14 or $sel_item[14] == 15)){
			$edicion_datos_generales = "SI";
		}
		/*
	$edicion_datos_doc_basica = "NO";
	if(verifica_permiso_doc_basica($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_doc_basica = "SI";
		}
		*/
	$es_profesional_designado = verifica_usuario_indicado_solo_si(8,$sel_item[0]);
		
		if(esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==16){
	 $edicion_datos_generales = "SI";
	 }
	 
	 if($edicion_datos_generales == "NO" and ($es_profesional_designado == "SI" and $sel_item[14] > 14)){
		 $datosExtemporaneos = "SI";
		 }
	
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
    <td width="77%" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td width="54%" valign="top">
        <?
          if ($edicion_datos_generales == "SI" or $datosExtemporaneos == "SI"){
		  ?>
        <table width="100%" border="0" align="center" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center" class="fondo_3">Agregar Anexos <?= ($datosExtemporaneos == "SI")?"Extemporaneos":"";?> <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
          </tr>
          <tr>
            <td align="right">Categor&iacute;a del Anexo</td>
            <td align="left">
            <select name="ct_anexo" id="ct_anexo">
      <option value="0">Seleccione</option>
     
       <?
          $categorias_anexos = query_db("select * from t1_categoria_anexos as t1 where estado = 1 and t1_tipo_proceso in (0,".$sel_item[6].")");
		  while($ct_anexo = traer_fila_db($categorias_anexos)){
		  ?>
          <option value="<?=$ct_anexo[0]?>" ><?=$ct_anexo[1]?></option>
          <?
		  }
		  ?>
          
      </select>
            </td>
          </tr>
          <tr>
            <td width="21%" align="right">Detalle del Anexo:</td>
            <td width="25%" align="left"><textarea name="anexo" cols="25" id="anexo"></textarea></td>
          </tr>
          <tr>
            <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
            <td align="left"><input name="adj_anexo" type="file" id="adj_anexo" size="5" /></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <input type="hidden" name="datosExtemporaneos" value="<?=$datosExtemporaneos?>" />
            <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onclick="graba_anexo_edicion(14)" /></td>
          </tr>
        </table>
        <?
		  }
		?>
        </td>
      </tr>
      <tr>
        <td width="54%" valign="top"><div id="carga_anexos">
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="4" align="center"  class="fondo_3">Lista de Anexos</td>
              </tr>
            <tr>
              <td width="25%" align="center" class="fondo_3">Categor&iacute;a</td>
              <td width="36%" align="center" class="fondo_3">Detalle de los Anexos</td>
              <td width="32%" align="center" class="fondo_3">Archivo Adjunto</td>
              <td width="7%" align="center" class="fondo_3">Eliminar</td>
              </tr>
            <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle as text), adjunto, estado, id_us, id_categoria from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'anexo_adjudicacion'");
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
              <td align="center" ><?
              $sel_catergoria = traer_fila_row(query_db("select * from t1_categoria_anexos where id = ".$sl_anexos[8]));
			  echo $sel_catergoria[1];
			  ?></td>
              <td align="center" ><?=nl2br($sl_anexos[4])?></td>
              <td align="center" >
                <?=saca_nombre_anexo($sl_anexos[5])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
                </td>
              <td align="center" >
              <?
          if ($edicion_datos_generales == "SI"){
		  ?>
              <img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onclick="eliminar_anexo_edicion(14, <?=$sl_anexos[0]?>)">
              <?
		  }
			  ?>
              </td>
              </tr>
            <?
}
  ?>
  </table> 
          
        </div></td>
      </tr>
      
    </table></td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_anexo_elimina" id="id_anexo_elimina" value="" />
<input type="hidden" name="tipo_anexo" id="tipo_anexo" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
</body>
</html>
