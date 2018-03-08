<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	



?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">Crear una Nueva</td>
  </tr>
</table>
<br>


<table width="100%" border="0">
  <tr>
    <td align="right">Nombre:</td>
    <td><input type="text" name="nombre" id="nombre" /></td>
  </tr>
  <tr>
    <td align="right">Naturaleza:</td>
    <td><select name="naturaleza" id="naturaleza">
    <option value="2">Corporativo</option>
    <option value="1">Socios</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">Autonomia Socios en USD$:</td>
    <td><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="28%">&nbsp;</td>
    <td width="72%"><input type="button" name="s" value="Crear una Nueva" class="boton_grabar" onClick="graba_area_proyecto()" style="cursor:pointer" /></td>
  </tr>
</table>
<br />
<input type="hidden" name="accion_correo_ot" id="accion_correo_ot"/>  
  

</p>
</body>
</html>
