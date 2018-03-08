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
    <td class="titulos_secciones">ADMINISTRACION DE MAESTRAS</td>
  </tr>
</table>
<p>&nbsp;</p>

<table width="95%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
 
  <tr>
    <td width="24%" height="34" onClick="ajax_carga('../aplicaciones/administracion/maestra_area_proyecto.php','carga_admin')" style="cursor:pointer">&gt;&gt; Maestra de Areas / Proyectos</td>
    <td width="27%">&nbsp;</td>
  </tr>
  <tr>
    <td height="34">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div id="carga_admin"></div>

<input type="hidden" name="accion_correo_ot" id="accion_correo_ot"/>  
  

</p>
</body>
</html>
