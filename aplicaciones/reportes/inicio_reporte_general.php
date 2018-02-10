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
  <div class="titulos_secciones">SECCION: Reportes</div>
  <br />
  <table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_3">Filtrar por:</td>
    </tr>
  <tr style="display:none">
    <td width="42%" align="right">Mes de Aprobacion en SGPA:</td>
    <td width="58%"><select name="comite_mes" id="comite_mes">
    <option value="0">Todos</option>
    <option value="1">Enero</option>
    <option value="2">Febrero</option>
    <option value="3">Marzo</option>
    <option value="4">Abril</option>
    <option value="5">Mayo</option>
    <option value="6">Junio</option>
    <option value="7">Julio</option>
    <option value="8">Agosto</option>
    <option value="9">Septiembre</option>
    <option value="10">Octubre</option>
    <option value="11">Noviembre</option>
    <option value="12">Diciembre</option>
    </select></td>
    </tr>
  <tr>
    <td align="right">A&ntilde;o  de Aprobacion en SGPA:</td>
    <td><select name="comite_ano" id="comite_ano">
    <option value="0">Todos</option>
    <?=anos_consulta()?>
    
    </select></td>
    </tr>
  <tr>
    <td align="center">
    
    <strong onclick="window.ifra_re.location.href='../aplicaciones/reportes/indicador_reporte_general.php?comite_ano='+document.getElementById('comite_ano').value">Generar Graficas <img src="../imagenes/mime/gif.gif" style="cursor:pointer" /></strong>
    </td>
    <td align="right"><div onclick="abrir_ventana('../aplicaciones/reportes/reporte_general.php?comite_mes='+document.getElementById('comite_mes').value+'&comite_ano='+document.getElementById('comite_ano').value)">Generar Reporte en EXCEL <img src="../imagenes/mime/xlsx.gif" style="cursor:pointer" /></div></td>
  </tr>
</table>

<iframe id="ifra_re" name="ifra_re" width="100%" height="3800" frameborder="0"></iframe>


</body>
</html>
