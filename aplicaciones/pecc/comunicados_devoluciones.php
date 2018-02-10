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
	if(verifica_permiso_pecc($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
	$edicion_datos_doc_basica = "NO";
	if(verifica_permiso_doc_basica($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_doc_basica = "SI";
		}
	$es_profesional_designado = verifica_usuario_indicado_solo_si(8,$sel_item[0]);
		
		
		$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
		
		if($sel_usu_emulan[0]>0 and ($sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
	
	?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
          <td width="54%">
          <?
          if ($edicion_datos_generales == "SI"){
		  ?>
          <table width="100%" border="0" align="center" class="tabla_lista_resultados">
            <tr>
              <td colspan="2" align="center" class="fondo_3">Agregar Comunicado de la Devoluci&oacute;n</td>
            </tr>
            <tr>
              <td width="21%" align="right">Comunicado:</td>
              <td width="25%" align="left"><textarea name="comunicados" cols="25" rows="5" id="comunicados"></textarea></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="center"><input name="button3" type="button" class="boton_grabar" id="button3" value="Agregar Comunicado"  onclick="graba_anexo_edicion(15)"/></td>
            </tr>
          </table>
          <?
		  }
		  ?>
          </td>
        </tr>
        <tr>
          <td valign="top"><div id="carga_comunicados"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="2" align="center"  class="fondo_3">Lista de Comunicados</td>
              </tr>
            <tr>
              <td width="54%" align="center" class="fondo_3">Detalle de los Antecedentes</td>
              <td width="36%" align="center" class="fondo_3">Usuario que lo Realizo</td>
              </tr>
            <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us
 from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'comu_devol_emuladores'");
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
              <td align="center" ><?=$sl_anexos[4]?></td>
              <td align="center" ><? echo traer_nombre_muestra($sl_anexos[7], $g1,"nombre_administrador","us_id");?></td>
              </tr>
            <?
}
  ?>
</table>
              
          </div>
          </td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
        </tr>
      </table>      
      </td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_anexo_elimina" id="id_anexo_elimina" value="" />
<input type="hidden" name="tipo_anexo" id="tipo_anexo" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
</body>
</html>
