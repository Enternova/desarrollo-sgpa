<?
include("../../librerias/chart/Functions.php");
	include("../../librerias/chart/PageLayout.php");
	include("../../librerias/chart/FusionCharts.php");
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<SCRIPT LANGUAGE="Javascript" SRC="../../librerias/chart/FusionCharts.js"></SCRIPT>	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width='400' align="center"  cellspacing='0' cellpadding='0' border="0">
	<tr>
	<td align="right">
	
	<?
	$strXMLd.= "<set label='Aprobadas' value='100' />";	
	$strXMLd.= "<set label='Tarifas nuevas' value='10' />";	
	$strXMLd.= "<set label='Tarifas nuevas aprobadas' value='5' />";		
	$strXMLd.= "<set label='Tarifas modificadas' value='80' />";	
	$strXMLd.= "<set label='Tarifas modificadas aprobadas' value='80' />";		
	
	$strXML  = "<chart caption='Reporte de comportamiento de tarifas en este contrato' palette='" . getPalette() . "' animation='" . getAnimationState() . "' formatNumberScale='0' numberPrefix='' seriesNameInToolTip='0' sNumberSuffix=' pcs.' showValues='1' plotSpacePercent='0' labelDisplay='Rotate' slantLabels='1'>";
	$strXML .= $strXMLd;
	//Add some styles to increase caption font size
	$strXML .= "<styles><definition><style type='font' name='CaptionFont' size='12' color='" . getCaptionFontColor() . "' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
	$strXML .= "</chart>";
		
	echo renderChart("../../librerias/chart/Line.swf", "", $strXML, "TopCities", 900,400, false, true);
	?>
	</td>
	</tr>
</table>
</body>
</html>
