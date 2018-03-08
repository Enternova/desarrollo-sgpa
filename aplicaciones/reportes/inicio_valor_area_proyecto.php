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

  <div class="titulos_secciones">SECCION: Reportes - Valor Aprobado por Area/Proyecto de Contratos Vigentes</div>
  <p><br />
  </p>
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
   <? $sel_fecha_actualiza_reporte = traer_fila_row(query_db("select * from t2_reporte_marco_temporal_actualizacion_reporte_valores order by id desc"))?>
    <td colspan="4" align="right" class="letra-descuentos"><strong>Ultima vez que se actualizo este reporte:</strong> <?=$sel_fecha_actualiza_reporte[1]?> <?=$sel_fecha_actualiza_reporte[2]?> </td>
    <td width="20%" align="center"><input type="button" value="Click Aqu&iacute; para Actualizar este Reporte " onClick="carga_reporte_valor_area_proyecto()" class="boton_edicion" /><br />Esta Acci&oacute;n Tardar&aacute; alrededor de 10 minutos</td>
    <td width="21%" align="left">&nbsp;</td>
  </tr>
    <tr>
      <td colspan="6" >&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" class="fondo_3">Filtrar por:</td>
    </tr>
    <tr>
      <td width="28%" align="right">N&uacute;mero de la Solicitud (La que genero los Contratos):</td>
      <td width="7%"><select name="numero1_pecc" id="numero1_pecc">
        <option value="S" >S</option>
      </select></td>
      <td width="10%"><select name="numero2_pecc" id="numero2_pecc">
        <option value="0" selected='selected' > Todos</option>
        <?=anos_consulta_ulti_numeros()?>
      </select></td>
      <td width="15%"><input name="numero3_pecc" type="text" id="numero3_pecc" size="5" maxlength="4" value="<?=$_GET["numero3_pecc"]?>" /></td>
    </tr>
    <tr>
      <td align="right">A&ntilde;o de los Valores:</td>
      <td colspan="3"><select name="ano_valores" id="ano_valores">
        <option value="0" selected='selected' > Todos</option>
        <?=anos_consulta_ulti_numeros()?>
      </select></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&Aacute;rea / Proyecto de los Valores:</td>
      <td colspan="3"><select name="campo" id="campo">
        <option value="">Todos</option>
        <?=listas_sin_seleccione($g15, " estado = 1 ".$query_comple,0 ,'nombre', 2);?>
      </select></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Mostrar Valores Equivalencia en:</td>
      <td colspan="3"><select name="eq_moneda" id="eq_moneda">
        <option value="1"  selected="selected">USD</option>
        <option value="2">COP</option>
      </select></td>
      <td colspan="2"><input type="button" name="xx" value="Buscar Contratos" class="boton_buscar"  onclick="genera_indicador_valor_solicitudes()"/></td>
    </tr>
  </table>
  <p>&nbsp;</p>
<iframe name="genera_indica_1" id="genera_indica_1" frameborder="0" width="100%" height="9000px"></iframe>


</body>
</html>
