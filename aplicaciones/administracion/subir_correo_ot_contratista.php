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
    <td class="titulos_secciones">ADMINISTRACION DE CORREOS DE LAS OTS</td>
  </tr>
</table>
<p>&nbsp;</p>

<table width="95%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="24%" height="34">&nbsp;</td>
    <td width="27%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="29%"><a target="_blank" href="../aplicaciones/administracion/lista correo proveedores.xls">Descargar el formato</a></td>
  </tr>
  <tr>
    <td height="35"><div align="right">Seleccione el archivo :</div></td>
    <td><div align="left">
      <input name="sele_arch" type="file" id="sele_arch" size="50">
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="32" colspan="4"><label>
      <div align="center">
        <input name="button" type="button" class="boton_grabar" id="button" value="Subir correos de los contratistas de las OTs" onClick="subir_archivo_cargue_ot_correos()"></div>
    </label></td>
  </tr>
</table>
<br>


<br />
<input type="hidden" name="accion_correo_ot" id="accion_correo_ot"/>  
  

</p>
</body>
</html>
