<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	$tipo_ajax = $_GET["tipo_ajax"];
	
	
	
	if($tipo_ajax == "carga_observaciones_inabilita"){
		?>
        <table width="200" border="0" align="center">
  <tr>
    <td align="center">Observaci&oacute;n para inhabilitaci&oacute;n:</td>
    </tr>
  <tr>
    <td align="left"><textarea name="inhabilita_tarifa_text_<?=$_GET["t6_tarifas_lista_id"];?>" rows="3" id="inhabilita_tarifa_text_<?=$_GET["t6_tarifas_lista_id"];?>"></textarea></td>
    </tr>
  <tr>
    <td><input type="file" name="inhabilta_adjunto_<?=$_GET["t6_tarifas_lista_id"];?>" id="inhabilta_adjunto_<?=$_GET["t6_tarifas_lista_id"];?>" /></td>
  </tr>
  <tr>
    <td>
      <input type="button" name="button" id="button" value="Inhabilitar Tarifa" onclick="valida_inhabilita_tarifa(<?=$_GET["t6_tarifas_lista_id"];?>, document.principal.inhabilita_tarifa_text_<?=$_GET["t6_tarifas_lista_id"];?>.value, document.principal.inhabilta_adjunto_<?=$_GET["t6_tarifas_lista_id"];?>.value )" /> 
      
      <input type="button" name="button" id="button" value="Cancelar" class="boton_grabar_cancelar" onclick="ajax_carga('../aplicaciones/tarifas/ajax.php','observacion_inabilita_<?=$_GET["t6_tarifas_lista_id"];?>')" /> 
      
      
    </td>
    </tr>
</table>

		<?
		}		
?>
