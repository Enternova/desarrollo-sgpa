<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";
?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Indicador General</title>
<SCRIPT LANGUAGE="Javascript" SRC="../../librerias/chart/FusionCharts.js"></SCRIPT>	
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
  
<table width='100%' align="center"  cellspacing='2' cellpadding='2' border="0" class="tabla_lista_resultados">
<tr >
  <td colspan="3" align="center" class="fondo_3">Indicadores de Planeaci&oacute;n</td>
  </tr>
	<tr>
	  <td colspan="2" align="center"><?
      $intTotalAnio1 = 310;
$intTotalAnio2 = 440;
$strXML = "";
$strXML = "<chart caption='1. Numero de procesos en el PECC sobre el total de los procesos'  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='line' slantLabels='1'>";
$strXML .= "<set label = 'Procesos creados en el PEEC' value ='".$intTotalAnio1."' color = 'EA1000' />";
$strXML .= "<set label = 'Total de Procesos' value ='".$intTotalAnio2."' color = '6D8D16' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador1", 500, 400, false, false);

	?></td>
	<td width="50%" align="center" bgcolor="">
	  <?
      $intTotalAnio1 = "152088";
$intTotalAnio2 = 1587452;
$strXML = "";
$strXML = "<chart caption='2. Valor de los procesos en el PECC sobre el valor total de los procesos (USD)'  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='line' slantLabels='1'>";
$strXML .= "<set label = 'Valor de los procesos creados en el PEEC' value ='".$intTotalAnio1."' color = 'EA1000' />";
$strXML .= "<set label = 'Valor total de Procesos' value ='".$intTotalAnio2."' color = '6D8D16' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador2", 500, 400, false, false);

	?>
	  
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">&nbsp;</td>
	  <td align="center" bgcolor="">&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="3" align="center"  class="fondo_3">Indicador de tiempos de procesos finalizados Vs ideal</td>
  </tr>
	<tr>
	  <td width="26%" align="right">Tener en cuenta los procesos con tiempos especiales:</td>
	  <td width="24%" align="left"><select name="especiales" id="especiales">
	    <option value="SI">SI</option>
	    <option value="NO">NO</option>
      </select></td>
	  <td align="center" bgcolor="">&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="2" align="center"><?
      $intTotalAnio1 = 310;
$intTotalAnio2 = 440;
$strXML = "";
$strXML = "<chart caption='3. Numero de procesos en el PECC sobre el total de los procesos'  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='line' slantLabels='1'>";
$strXML .= "<set label = 'Procesos creados en el PEEC' value ='".$intTotalAnio1."' color = 'EA1000' />";
$strXML .= "<set label = 'Total de Procesos' value ='".$intTotalAnio2."' color = '6D8D16' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador3", 500, 400, false, false);

	?></td>
	  <td align="center" bgcolor="">&nbsp;</td>
  </tr>
</table>
  <?

		

$intTotalAnio1 = 310;
$intTotalAnio2 = 440;
$intTotalAnio3 = 118;
$intTotalAnio4 = 145;
$strXML = "";
$strXML = "<chart caption='Numero de procesos en el PECC sobre el total de los procesos' palette='" . getPalette() . "' animation='" . getAnimationState() . "' formatNumberScale='0' numberPrefix='' seriesNameInToolTip='0' sNumberSuffix=' pcs.' showValues='1' plotSpacePercent='0' labelDisplay='Rotate' slantLabels='1'>";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "<set label = 'Anio 1' value ='".$intTotalAnio1."' color = 'EA1000' />";
$strXML .= "<set label = 'Anio 2' value ='".$intTotalAnio2."' color = '6D8D16' />";
$strXML .= "<set label = 'Anio 3' value ='".$intTotalAnio3."' color = 'FFBA00' />";
$strXML .= "<set label = 'Anio 4' value ='".$intTotalAnio4."' color = '0000FF' />";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "ejemplo1", 500, 400, false, false);

	?>
  
</body>
</html>
