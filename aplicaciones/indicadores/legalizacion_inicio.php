<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" align="center"  class="fondo_3">Filtros para Generar los Indicadores</td>
  </tr>
  <tr>
    <td align="right">Bienes / Servicios:</td>
    <td><select name="bien_servicio" id="bien_servicio">
    <option value="0">Todos</option>
    <option value="1">Servicios</option>
    <option value="2">Bienes</option>
    </select></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="29%" align="right">Profesional de C&amp;C:</td>
    <td width="30%"><select name="us_prof" id="us_prof">
      <option value="0">Seleccione el Profesional de C&amp;C Designado</option>
      <?
          $sel_profss = query_db("select us_id, nombre_administrador from $v_seg1 where id_premiso = 8  group by us_id, nombre_administrador");
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
      <option value="<?=$se_prof[0]?>" <? if( $sel_item[23] ==$se_prof[0]) echo 'selected="selected"'?>  >
        <?=$se_prof[1]?>
        </option>
         
      <?
		  }
		  ?>
          <option value="53"  >
        INFANTE, DIEGO
        </option>
    </select></td>
    <td width="16%" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Gestor de Abastecimiento</td>
    <td><select name="gestor_abste" id="gestor_abste" >
              <option value="0">Seleccione</option>
              
              <?
			  $sel_usuarios_gestores = query_db("select t1.us_id, t1.nombre_administrador from t1_us_usuarios t1, tseg12_relacion_usuario_rol t2 where t1.us_id = t2.id_usuario and t2.id_rol_general = 21 and t1.estado = 1");
			  while($sel_us_g = traer_fila_db($sel_usuarios_gestores)){
              ?>
              <option value="<?=$sel_us_g[0]?>" <? if($sel_us_g[0]==$gestor_abste){ echo "selected='selected'";} ?>><?=$sel_us_g[1]?></option>
              <?
			  }
			  ?>
              </select></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Tener en cuenta los Contratos Congelados:</td>
    <td><select name="congelados" id="congelados">
      <option value="2">NO</option>
      <option value="1">SI</option>
      
    </select></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">A&ntilde;o de creacion en SGPA:</td>
    <td><select name="ano" id="ano">
          <?=anos_consulta();?>
          </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Desde el Mes:</td>
    <td><select name="mes_requiere" id="mes_requiere">
      <option value="0">Todos</option>
      <option value="01">Enero</option>
      <option value="02">Febrero</option>
      <option value="03">Marzo</option>
      <option value="04">Abril</option>
      <option value="05">Mayo</option>
      <option value="06">Junio</option>
      <option value="07">Julio</option>
      <option value="08">Agosto</option>
      <option value="09">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>
    </select></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Hasta el Mes:</td>
    <td><select name="mes_requiere2" id="mes_requiere2">
      <option value="0">Todos</option>
      <option value="01">Enero</option>
      <option value="02">Febrero</option>
      <option value="03">Marzo</option>
      <option value="04">Abril</option>
      <option value="05">Mayo</option>
      <option value="06">Junio</option>
      <option value="07">Julio</option>
      <option value="08">Agosto</option>
      <option value="09">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td align="right">&nbsp;</td>
    <td>
    </td>
    <td><input name="fecha_rep" type="hidden" id="fecha_rep" size="5" onmousedown="calendario_sin_hora('fecha_rep')"  /> <input type="button" name="button" id="button" value="Generar Indicador" onclick="genera_indicador_legalizacion()" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<iframe name="genera_indica_1" id="genera_indica_1" frameborder="0" width="100%" height="9000px"></iframe>
</body>
</html>
