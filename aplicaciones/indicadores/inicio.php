<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	if($_GET['ano']){
		$ano=$_GET['ano'];
	}else{
		$ano=2017;
	}
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
    <td align="right">A&ntilde;o de Puesta en Firme en SGPA:</td>
    <td><select name="ano" id="ano" onChange="ajax_carga('../aplicaciones/indicadores/inicio.php?ano='+this.value,'contenidos')">
          <?=anos_consulta_defecto($ano);?>
          </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="29%" align="right">Profesional de C&amp;C:</td>
    <td width="30%"><select multiple="multiple" name="us_prof[]" id="us_prof" size="14">
      <option value="0" selected>Buscar Todos Los Profesionales de C&amp;C</option>
      <?
          $sel_profss = query_db("select id_us_profesional_asignado, profesional from version_2_indi_1 where profesional is not null and estado <> 33 and fecha_en_firme like '%$ano%' group by id_us_profesional_asignado, profesional order by profesional");
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
      <option value="<?=$se_prof[0]?>" <? if( $sel_item[23] ==$se_prof[0]) echo 'selected="selected"'?>  >
        <?=$se_prof[1]?>
        </option>
         
      <?
		  }
		  ?>
    </select></td>
    <td width="16%" align="left" style="font-weight: 900; font-size: 14px;">	
        				<i><img src="../imagenes/botones/icono_ayuda.png"></i><font face="roboto" color="#229BFF">&nbsp;Para seleccionar varios profesionales mantega oprimida la tecla CTRL y de click izquierdo
        			</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Tener en Cuenta los Procesos Congelados:</td>
    <td><select name="congelados" id="congelados">
      <option value="2">NO</option>
      <option value="1">SI</option>
      
    </select></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&Aacute;rea Usuaria:</td>
    <td><select name="area_usuaria[]" id="area_usuaria" multiple="multiple" size="14">
    	<option value="0" selected>Buscar Todos Las &Aacute;reas</option>
    	<?
          $sel_profss = query_db("select t1_area_id, nombre_html from t1_area where estado=1 order by nombre_html asc");
		  while($se_area =traer_fila_db($sel_profss)){
		  ?>
      <option value="<?=$se_area[0]?>" <? if( $sel_item[5] ==$se_area[0]) echo 'selected="selected"'?>  >
        <?=$se_area[1]?>
        </option>
         
      <?
		  }
		  ?>
        </select></td>
    <td style="font-weight: 900; font-size: 14px;">	
        				<i><img src="../imagenes/botones/icono_ayuda.png"></i><font face="roboto" color="#229BFF">&nbsp;Para seleccionar varias &aacute;reas usuarias mantega oprimida la tecla CTRL y de click izquierdo
        			</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Sondeos:</td>
    <td><select name="consulta_sondeo" id="consulta_sondeo">
    <option value="1">Si</option>
    <option value="2">No</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">En Aprobaci&oacute;n / Aprobados:</td>
    <td><select name="fin_activos" id="fin_activos">
    <option value="0">Todos</option>
    <option value="1">En Aprobaci&oacute;n</option>
    <option value="2">Aprobados</option>
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
    <td></td>
    <td><input name="fecha_rep" type="hidden" id="fecha_rep" size="5" onmousedown="calendario_sin_hora('fecha_rep')"  /></td>
    <td><input type="button" name="button" id="button" value="Generar Indicador de Tiempos" onclick="genera_indicador('tiempo')" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="button" name="button2" id="button2" value="Generar Indicador de Procesos en Curso" onclick="genera_indicador('carga')" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="bien_servicio" id="bien_servicio" value="0">
<div id="carga_indicador_procesos_encurso">
<iframe name="genera_indica_1" id="genera_indica_1" frameborder="0" width="100%" height="9000px"></iframe>
</div>
</body>
</html>
