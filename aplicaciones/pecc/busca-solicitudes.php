<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>


<body>


  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table width="50%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
    <tr>
  <td width="15%" align="right"> Solicitud::</td>
  <td width="8%"><select name="numero1_pecc" id="numero1_pecc">
    <option value="S">S</option>
    <option value="B">B</option>
   
  </select></td>
  <td width="9%"><select name="numero2_pecc" id="numero2_pecc">
    <option value="">Todos</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <?=anos_consulta_ulti_numeros(0);?>
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
  <td align="right">&Aacute;rea Usuaria:</td>
  <td colspan="3"><select name="bus_area" id="bus_area">
    <?=listas($g12, " estado = 1",0 ,'nombre', 1);?>
  </select></td>
  </tr>
<tr>
  <td align="right">Tipo de Proceso:</td>
  <td colspan="3">
  
  <?
  if($_GET["modificacion"] == 1){
	  $comple_filtro_sol = "estado = 1 and t1_tipo_proceso_id in (1,2,3,6, 5)";
	  }else{
		  $comple_filtro_sol = "estado = 1 and t1_tipo_proceso_id in (1,2,3,6, 5, 7)";
		  }
  ?>
  
  <select name="tp_proceso_busca" id="tp_proceso_busca">
        <?=listas("t1_tipo_proceso", $comple_filtro_sol,$_GET["tp_proceso_busca"] ,'nombre', 1);?>
      </select></td>
  </tr>
<tr>
  <td align="right">Responsable en Abastecimiento:</td>
  <td colspan="3"><select name="profesional_cyc" id="profesional_cyc">
    <option value="">Seleccione</option>
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
  </tr>
<tr>
  <td align="right">Solicitante:</td>
  <td colspan="3"><input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?=$_GET["usuario_permiso"]?>"/></td>
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
  <td colspan="4" align="center"><input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=busca_solicitud_informativo&numero1_pecc='+document.getElementById('numero1_pecc').value+'&numero2_pecc='+document.getElementById('numero2_pecc').value+'&numero3_pecc='+document.getElementById('numero3_pecc').value+'&bus_area='+document.getElementById('bus_area').value+'&bus_text1='+document.getElementById('bus_text1').value+'&bus_text2='+document.getElementById('bus_text2').value+'&bus_text3='+document.getElementById('bus_text3').value+'&bus_text4='+document.getElementById('bus_text4').value+'&bus_text5='+document.getElementById('bus_text5').value+'&tp_proceso_busca='+document.getElementById('tp_proceso_busca').value+'&profesional_cyc='+document.getElementById('profesional_cyc').value+'&usuario_permiso='+document.getElementById('usuario_permiso').value+'&tipo_proceso='+document.getElementById('tipo_proceso').value,'carga_lista_contratos_marco12'); " /></td>
  <td align="right"><input type="button" value="Cancelar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"; body.style.overflow = "visible"' /></td>
</tr>
<tr>
  <td colspan="5" align="center"><div id="carga_lista_contratos_marco12"></div></td>
</tr>

</table>




</body>
</html>
