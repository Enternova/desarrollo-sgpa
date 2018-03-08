<? 
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
?>

<input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="volver_listado('muestra_cootactos','carga_detalle_pro');">

<?
readfile('http://www.parservicios.com/parservi/ficha_tecnica_gt_2.php?ref=principal.html&pv_nit='.$pv_nit);
?>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="28%"><div align="right"><strong>E-mail principal: </strong></div></td>
    <td width="72%"><input type="text" name="email_contacto" id="email_contacto" /><input type="hidden" name="conta_1" id="conta_1" value="1" /><input type="hidden" name="nombre_contacto" id="nombre_contacto" /><input type="hidden" name="conta_2" id="conta_2" value="1"/><input type="hidden" name="telefono_contacto" id="telefono_contacto" /></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"> <input name="button" type="button" class="guardar" id="button" value="Grabar proveedor" onclick="crea_proveedor_adentro()" /> </div></td>
  </tr>
</table>
<input type="hidden" name="id_invitacion_pasa_final" value="<?=$id_invitacion_pasa;?>">
