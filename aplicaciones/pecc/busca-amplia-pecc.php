<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<div id="buscardor_solicitud_contrato_marco">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">B&uacute;squeda de Solicitudes de Contratos Marco</td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td width="15%" align="right">N&uacute;mero de la Solicitud:</td>
  <td width="8%"><select name="numero1_pecc" id="numero1_pecc">
  
    <?				
                	$sele_numero1=query_db("select num1 from $vpeec4 where t1_tipo_documento_id = 2 group by num1 order by num1");
					while($sel_num = traer_fila_db($sele_numero1)){
				?>
    <option value="<?=$sel_num[0]?>">
      <?=$sel_num[0]?>
      </option>
    <?
					}
				?>
  </select></td>
  <td width="9%"><select name="numero2_pecc" id="numero2_pecc">
  <option value="">Todos</option>
    <?=anos_consulta_ulti_numeros(0)?>
  </select></td>
  <td width="10%"><input name="numero3_pecc" type="text" id="numero3_pecc" maxlength="4" /></td>
  <td width="58%" rowspan="9" align="right"><table width="99%" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="31%" align="right">Alcance:</td>
      <td width="69%"><textarea name="bus_text1" id="bus_text1" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Justificaci&oacute;n:</td>
      <td><textarea name="bus_text2" id="bus_text2" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Recomendaci&oacute;n:</td>
      <td><textarea name="bus_text3" id="bus_text3" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Objeto del Contrato:</td>
      <td><textarea name="bus_text4" id="bus_text4" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Objeto de la Solicitud:</td>
      <td><textarea name="bus_text5" id="bus_text5" cols="25" rows="2"></textarea></td>
      </tr>
  </table></td>
  </tr>
<tr>
  <td align="right">N&uacute;mero de Contrato:</td>
  <td align="center">C</td>
  <td><select name="n_contrato_ano" id="n_contrato_ano">
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
  <td><input name="n_contrato" type="text" id="n_contrato" maxlength="4" /></td>
  </tr>
<tr>
  <td align="right">&Aacute;rea Usuaria:</td>
  <td colspan="3"><select name="bus_area" id="bus_area">
    <?=listas($g12, " estado = 1",0 ,'nombre', 1);?>
  </select></td>
  </tr>
<tr>
  <td align="right">Contratista:</td>
  <td colspan="3"><input name="contra_busca" id="contra_busca" /></td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td colspan="5" align="center"><input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=1&id_pecc=<?=$id_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&numero1_pecc='+document.principal.numero1_pecc.value+'&numero2_pecc='+document.principal.numero2_pecc.value+'&numero3_pecc='+document.principal.numero3_pecc.value+'&n_contrato='+document.principal.n_contrato.value+'&n_contrato_ano='+document.principal.n_contrato_ano.value+'&bus_area='+document.principal.bus_area.value+'&bus_text1='+document.principal.bus_text1.value+'&bus_text2='+document.principal.bus_text2.value+'&bus_text3='+document.principal.bus_text3.value+'&bus_text4='+document.principal.bus_text4.value+'&bus_text5='+document.principal.bus_text5.value+'&contra_busca='+document.principal.contra_busca.value,'carga_lista_contratos_marco')" /></td>
</tr>
<tr>
  <td colspan="5" align="center"><div id="carga_lista_contratos_marco"></div></td>
</tr>

</table>
</div>

		<div id="carga_formulario_solicitud"></div>

</body>
</html>
