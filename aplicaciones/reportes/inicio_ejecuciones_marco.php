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

  <div class="titulos_secciones">SECCION: Reportes - Ejecuciones Contrato Marco</div>
  <br />
  <table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="fondo_3">Filtrar por:</td>
    </tr>
  <tr>
    <td width="28%" align="right">N&uacute;mero de Contrato:</td>
    <td width="7%" align="center">C</td>
    <td width="10%"><select name="n_contrato_ano" id="n_contrato_ano">
      <option value="">Todos</option>
      <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <?=anos_consulta_ulti_numeros()?>
    </select></td>
    <td width="15%"><input name="n_contrato" type="text" id="n_contrato" maxlength="4" /></td>
    <td width="41%">
    
    <?
    if($_SESSION["id_us_session"] == 32 and $nomostrar == "no mostrar"){
	?>
    <input type="button" name="xx2" value="Exportar reporte Andrea" class="boton_buscar"  onclick="window.ifra_re.location.href='../aplicaciones/reportes/reporte_ejecuciones_marco_excel_andrea.php?numero1_pecc='+document.getElementById('numero1_pecc').value+'&amp;numero2_pecc='+document.getElementById('numero2_pecc').value+'&amp;numero3_pecc='+document.getElementById('numero3_pecc').value+'&amp;n_contrato_ano='+document.getElementById('n_contrato_ano').value+'&amp;n_contrato='+document.getElementById('n_contrato').value+'&amp;usuario_permiso='+document.getElementById('usuario_permiso').value+'&amp;profesional_cyc='+document.getElementById('profesional_cyc').value+'&amp;bus_area='+document.getElementById('bus_area').value+'&amp;proveedores_busca='+document.getElementById('proveedores_busca').value+'&amp;vigentes_finalizados='+document.getElementById('vigentes_finalizados').value+'&amp;eq_moneda='+document.getElementById('eq_moneda').value"/>
    <?
	}
	?>
    
    
    </td>
  </tr>
  <tr>
    <td width="28%" align="right">N&uacute;mero de la Solicitud (Bolsa de Aprobaci&oacute;n):</td> 
          <td width="7%">
          <select name="numero1_pecc" id="numero1_pecc">
            <option value="S" >S</option>
    </select></td>
             <td width="10%">    
      <select name="numero2_pecc" id="numero2_pecc">
      <option value="0" selected='selected' > Todos</option>
      <?=anos_consulta_ulti_numeros()?>        
      </select></td> 
        <td>
            <input name="numero3_pecc" type="text" id="numero3_pecc" size="5" maxlength="4" value="<?=$_GET["numero3_pecc"]?>" /></td>
  </tr>
  <tr>
    <td align="right">Mostrar Equivalencia en:</td>
    <td colspan="3"><select name="eq_moneda" id="eq_moneda"><option value="1">USD</option><option value="2" selected="selected">COP</option></select></td>
    <td>
      
      <input type="button" name="xx" value="Buscar y Generar a Excel el Reporte" class="boton_buscar"  onclick="window.ifra_re.location.href='../aplicaciones/reportes/reporte_ejecuciones_marco_excel.php?numero1_pecc='+document.getElementById('numero1_pecc').value+'&numero2_pecc='+document.getElementById('numero2_pecc').value+'&numero3_pecc='+document.getElementById('numero3_pecc').value+'&n_contrato_ano='+document.getElementById('n_contrato_ano').value+'&n_contrato='+document.getElementById('n_contrato').value+'&usuario_permiso='+document.getElementById('usuario_permiso').value+'&profesional_cyc='+document.getElementById('profesional_cyc').value+'&bus_area='+document.getElementById('bus_area').value+'&proveedores_busca='+document.getElementById('proveedores_busca').value+'&vigentes_finalizados='+document.getElementById('vigentes_finalizados').value+'&eq_moneda='+document.getElementById('eq_moneda').value"/>
      
      
      
    </td>
  </tr>
</table>
<input type="hidden" name="numero1_pecc" id="numero1_pecc" value="" />
    <input type="hidden" name="numero2_pecc" id="numero2_pecc" value="" />
    <input type="hidden" name="numero3_pecc" id="numero3_pecc" value="" />
<div id="carga_auditor_1">

</div>

<iframe id="ifra_re" name="ifra_re" width="100%" height="3800" frameborder="0"></iframe>
</body>
</html>

<input type="hidden" name="vigentes_finalizados" id="vigentes_finalizados" value="2" /><input type="hidden" name="proveedores_busca" id="proveedores_busca" value="" /><input type="hidden" name="bus_area" id="bus_area" value="0" /><input type="hidden" name="profesional_cyc" id="profesional_cyc" value="0" /><input type="hidden" name="usuario_permiso" id="usuario_permiso" value="0" />
