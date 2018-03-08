<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$num_ale= rand(0,99);
	$num_ale.= rand(0,99);
	$aleatorio = $fecha.$num_ale.$hora;
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">Creaci&oacute;n de Comit&eacute; de Solicitudes</td>
  </tr>
</table>
<br />
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="41%" align="right">Fecha:</td>
    <td width="24%"><input type="text" name="fecha_comite" id="fecha_comite" onmousedown="calendario_sin_hora('fecha_comite')" /></td>
    <td width="35%" colspan="-5"><label for="fecha_comite">
      <input type="hidden" name="lugar" id="lugar" value="" />
      <input type="hidden" name="tipo_comite_virtual_presencial" id="tipo_comite_virtual_presencial" value="virtual" />
    </label></td>
  </tr>
  <tr>
    <td align="right">Tipo de Comit&eacute;:</td>
    <td><select name="extra_comite" id="extra_comite">
    	<option value="2">Normal</option>
        <option value="1">Extraordinario</option>
    </select></td>
    <td colspan="-5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button" name="button" id="button" value="Crear Comit&eacute;" class="boton_grabar" onclick="crear_comite()" /></td>
  </tr>
</table>
<input type="hidden" name="aleatorio" id="aleatorio" value="<?=$aleatorio?>" />
</body>
</html>
