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

  <div class="titulos_secciones">SECCION: Reportes - Auditor</div>
  <br />
  <table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="fondo_3">Filtrar por:</td>
    </tr>
  <tr>
    <td width="19%" align="right">Numero de Proceso:</td>
    <td width="25%"><input type="text" name="busca_solicitud2" id="busca_solicitud2" /></td>
    <td width="16%" align="right">Fecha:</td>
    <td width="40%"><input name="fecha" type="text" id="fecha" size="5" onmousedown="calendario_sin_hora('fecha')"  /></td>
    </tr>
  <tr>
    <td align="right">Usuario:</td>
    <td><input type="text" name="usuario_permiso" id="usuario_permiso_auditor" onkeypress="selecciona_lista()"/></td>
    <td align="right">Modulo:</td>
    <td><select name="modulo" id="modulo">
          <?=listas("tseg1_modulo", " estado = 1 and id_modulo in (2,4, 5, 11)",0 ,'nombre', 1);?>
        </select></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="button" name="" id="" onclick="ajax_carga('../aplicaciones/reportes/auditor_lista_general_frame.php?busca_solicitud='+document.getElementById('busca_solicitud2').value+'&fecha='+document.getElementById('fecha').value+'&usuario_permiso='+document.getElementById('usuario_permiso_auditor').value+'&modulo='+document.getElementById('modulo').value,'carga_auditor_1')" value="Generar Reporte" /></td>
    <td align="right"><input type="button" name="input2" id="input2" onclick="abrir_ventana('../aplicaciones/reportes/auditor_lista_general_excel.php?busca_solicitud='+document.getElementById('busca_solicitud2').value+'&fecha='+document.getElementById('fecha').value+'&usuario_permiso='+document.getElementById('usuario_permiso_auditor').value+'&modulo='+document.getElementById('modulo').value)" value="Generar Reporte a Excel"/></td>
  </tr>
</table>

<div id="carga_auditor_1">

</div>


</body>
</html>
