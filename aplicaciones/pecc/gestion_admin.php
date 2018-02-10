<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	


$sel_areas_usuario = traer_fila_row(query_db("select count(*) from tseg3_usuario_areas where id_area = 44 and id_usuario = ".$_SESSION["id_us_session"]));	
	
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
    <td width="77%" valign="top">
    
    
    <table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td width="54%" valign="top">
        
        <?
		
		
          if ($sel_areas_usuario[0] >0){
		  ?>
        <table width="100%" border="0" align="center" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center" class="fondo_3">Agregar Gestion Administrativa</td>
          </tr>
          <tr>
            <td width="21%" align="right">Detalle de Gestion:</td>
            <td width="25%" align="left"><textarea name="anexo" cols="25" rows="5" id="anexo"></textarea></td>
          </tr>
          <tr>
            <td align="right">Seleccionar Archivo Adjunto:</td>
            <td align="left"><input name="adj_anexo" type="file" id="adj_anexo" size="5" /></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Gestion" onClick="graba_anexo_edicion(20)" /></td>
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
              <td colspan="3" align="center"  class="fondo_3">Lista de Gestiones</td>
              </tr>
            <tr>
              <td width="54%" align="center" class="fondo_3">Detalle de Gestion</td>
              <td width="36%" align="center" class="fondo_3">Usuario que lo cargo</td>
              <td width="36%" align="center" class="fondo_3">Archivo Adjunto</td>
              </tr>
            <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST (detalle AS text), adjunto, estado, id_us from t2_anexo_admin where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'gestion_admin'");
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
              <td align="center" ><? echo traer_nombre_muestra($sl_anexos[7], $g1,"nombre_administrador","us_id");?></td>
              <td align="center" >
                <?=saca_nombre_anexo($sl_anexos[5])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
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
<input type="hidden" name="estado_actual_del_proceso" id="estado_actual_del_proceso" value="<?=$sel_item[14]?>" />
</body>
</html>
