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

  <div class="titulos_secciones">SECCION: Reportes - Reemplazos y Ausencias</div>
  <br />
  <table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="fondo_3">Filtrar por:</td>
    </tr>
  <tr>
    <td width="50%" align="right">Funcionario Ausente:</td>
    <td colspan="2"><input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()"/></td>
    </tr>
  <tr>
    <td align="right">Funcionario que lo Reemplaza:</td>
    <td colspan="2"><input type="text" name="usuario_permiso2" id="usuario_permiso2" onkeypress="selecciona_lista()"/></td>
  </tr>
  <tr>
    <td align="right">Rango inicial de creacion del reemplazo:</td>
    <td colspan="2"><input type="text" name="fecha1" id="fecha1"  onmousedown="calendario_sin_hora('fecha1')" /></td>
    </tr>
  <tr>
    <td align="right">Rango Final de creacion del reemplazo:</td>
    <td colspan="2"><input type="text" name="fecha2" id="fecha2"  onmousedown="calendario_sin_hora('fecha2')" /></td>
    </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="35%"><input type="button" onclick="abrir_ventana('../aplicaciones/reportes/reemplazos.php?usuario_permiso='+document.getElementById('usuario_permiso').value+'&usuario_permiso2='+document.getElementById('usuario_permiso2').value+'&fecha1='+document.getElementById('fecha1').value+'&fecha2='+document.getElementById('fecha2').value)" value="Generar Reporte a Excel" /></td>
    </tr>
</table>

<div id="carga_auditor_1">

</div>


</body>
</html>
