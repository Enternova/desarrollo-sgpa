<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>

<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="div_contenidos_carga">
  <div class="titulos_secciones">SECCION: Reportes - Nivel aprobaciones - Usuarios<br />
    <br />
  </div>
  <table width="100%" border="0" class="tabla_lista_resultados">
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><input type="button" name="input2" id="input2" onclick="abrir_ventana('../aplicaciones/reportes/usuario_montos_aprovacion_excel.php')" value="Generar Reporte de Montos de Aprobacion por Areas a Excel"/></td>
    </tr>
</table>
  <p>&nbsp;</p>
<table width="100%" border="0">
    <tr>
      <td align="center"><iframe name="carga_lita" src="../aplicaciones/reportes/usuario_montos_aprovacion.php?consulta=si" frameborder="0" width="100%" height="2000"></iframe></td>
  </tr>
</table>
<p>&nbsp;</p>
<div id="carga_auditor_1">

</div>


</body>
</html>
