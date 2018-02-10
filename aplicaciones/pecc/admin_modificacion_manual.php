<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$sel_gerente = traer_fila_row(query_db("select * from $g1 where us_id =".$sel_item[3]));	
	
	$gerente_contrato = "-".$sel_gerente[1]."----,".$sel_gerente[0]."----, ";
	
	
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
    <td width="76%" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      
      <tr>
        <td width="54%" valign="top">
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td height="43" colspan="3" align="center"  class="fondo_3">Lista de Administraciones Permitidas con su Perfil y Relaci&oacute;n con el Proceso</td>
              </tr>
            <tr>
              <td width="28%" align="center" class="fondo_3">Detalle</td>
              <td width="28%" align="center" class="fondo_3">Observaci&oacute;n</td>
              <td width="24%" align="center" class="fondo_3">Acci&oacute;n</td>
              </tr>
        <?
        if($id_tipo_proceso_pecc <> 3){
		?>
         <?
		 }else{
        ?>
         
         <input type="hidden" name="usuario_permiso" id="usuario_permiso" value="<?=$gerente_contrato ?>"/>
         
         <?
		 }
         
		 ?>
            <tr class="<?=$clase?>">
              <td align="left" >1. Cambiar Area Usuaria de la Solicitud</td>
              <td align="center" >
               
                
                <textarea name="ob_area" id="ob_area" cols="45" rows="3"></textarea></td>
              <td align="center" ><select name="acci_area" id="acci_area">
              <?
              $sel_areas = query_db("select * from t1_area where estado =1");
			  while($s_area = traer_fila_db($sel_areas)){
			  ?>
              <option value="<?=$s_area[0]?>" <? if($sel_item[5] == $s_area[0]) echo 'selected="selected"'?> ><?=$s_area[1]?></option>
               
                <?
			  }
				?>
                </select></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="center" >&nbsp;</td>
              <td colspan="2" align="center" ><input type="button" name="button2" id="button2" value="Grabar Cambios" class="boton_grabar" onclick="acciones_administrativas_modifica_cargue_manual()" /></td>
            </tr>
           
  </table> 
          
      </td>
      </tr>
      
    </table></td>
    <td width="24%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
</body>
</html>
