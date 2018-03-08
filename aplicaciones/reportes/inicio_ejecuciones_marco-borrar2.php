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

  <div class="titulos_secciones">SECCION: Reportes - Ejecuciones Contrato Marco - <strong class="letra-descuentos">REPORTE ADMINISTRATIVO TENER EN CUENTA LOS FILTROS</strong></div>
  <br />
  <table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="fondo_3">Filtrar por:</td>
    </tr>
  <tr>
    <td width="28%" align="right">Numero de Contrato:</td>
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
    <td width="41%">&nbsp;</td>
  </tr>
  <tr>
    <td width="28%" align="right">Numero de la Solicitud:</td> 
          <td width="7%">
          <select name="numero1_pecc" id="numero1_pecc">
            <option value="0"  selected='selected'>Todos</option>
            <option value="S" >S</option>
            <option value="B" >B</option>
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
    <td align="right">Gerente del Contrato:</td>
    <td colspan="3"><input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?=$_GET["usuario_permiso"]?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Responsable Abastecimiento:</td>
    <td colspan="3"><select name="profesional_cyc" id="profesional_cyc">
      <option value="">Seleccione el Profesional de C&amp;C Designado</option>
      <?
          $sel_profss = query_db("select us_id, nombre_administrador from $v_seg1 where id_premiso = 8  group by us_id, nombre_administrador");
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
      <option value="<?=$se_prof[0]?>" <? if( $_GET["profesional_cyc"] ==$se_prof[0]) echo 'selected="selected"'?>  >
        <?=$se_prof[1]?>
        </option>
      <?
		  }
		  ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Area Usuaria:</td>
    <td colspan="3"><select name="bus_area" id="bus_area">
      <?=listas($g12, " estado = 1",$_GET["bus_area"] ,'nombre', 1);?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Contratista:</td>
    <td colspan="3"><input name="proveedores_busca" type="text" id="proveedores_busca" size="5"  onkeypress="selecciona_lista()"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Vigentes / Finalizados:</td>
    <td colspan="3"><select name="vigentes_finalizados" id="vigentes_finalizados">
    <option value="1">Vigentes</option>
    <option value="2">Finalizados y Vencidos</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Mostrar Equivalencia en:</td>
    <td colspan="3"><select name="eq_moneda" id="eq_moneda"><option value="1">USD</option><option value="2">COP</option></select></td>
    <td>
      
      <input type="button" name="xx" value="Buscar y Generar a Excel el Reporte" class="boton_buscar"  onclick="window.ifra_re.location.href='../aplicaciones/reportes/reporte_ejecuciones_marco_excel.php?numero1_pecc='+document.getElementById('numero1_pecc').value+'&numero2_pecc='+document.getElementById('numero2_pecc').value+'&numero3_pecc='+document.getElementById('numero3_pecc').value+'&n_contrato_ano='+document.getElementById('n_contrato_ano').value+'&n_contrato='+document.getElementById('n_contrato').value+'&id_us_session_get=<?=$_SESSION["id_us_session"]?>&usuario_permiso='+document.getElementById('usuario_permiso').value+'&profesional_cyc='+document.getElementById('profesional_cyc').value+'&bus_area='+document.getElementById('bus_area').value+'&proveedores_busca='+document.getElementById('proveedores_busca').value+'&vigentes_finalizados='+document.getElementById('vigentes_finalizados').value+'&eq_moneda='+document.getElementById('eq_moneda').value"/>
      
      
      
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
