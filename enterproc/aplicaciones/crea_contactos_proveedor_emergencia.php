<? 
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
?>

<input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion_pasa;?>','contenidos')">

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td><div align="right"><strong>* E-mail principal: </strong></div></td>
    <td><input type="text" name="email_contacto" id="email_contacto" /></td>
  </tr>
  <tr>
    <td><div align="right"><strong>* Raz&oacute;n social</strong></div></td>
    <td><input type="text" name="bp" id="bp" /> </td>
  </tr>
  <tr>
    <td><div align="right"><strong>NIT:</strong></div></td>
    <td><input type="text" name="ap" id="ap" /></td>
    <input type="hidden" name="cp" id="cp" value="N/D"/>
    <input type="hidden" name="ep" id="ep" value="N/D"/>
    <input type="hidden" name="g" id="g" value="N/D"/>
    <input type="hidden" name="ciuadad" id="ciuadad" value="878"/>
<input type="hidden" name="conta_1" id="conta_1" value="1" />
<input type="hidden" name="conta_2" id="conta_2" value="1"/>    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"> <input name="button" type="button" class="guardar" id="button" value="Grabar proveedor" onclick="crea_proveedor_adentro()" /> </div></td>
  </tr>
</table>
<input type="hidden" name="id_invitacion_pasa_final" value="<?=$id_invitacion_pasa;?>">
