<? include("../../librerias/lib/@session.php");
	include("../../librerias/chart/Functions.php");
	include("../../librerias/chart/PageLayout.php");
	include("../../librerias/chart/FusionCharts.php");
	


?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
<SCRIPT LANGUAGE="Javascript" SRC="../../librerias/chart/FusionCharts.js"></SCRIPT>	

<script>





</script>

</head>
<body >
  
  
<table width='400' align="center"  cellspacing='0' cellpadding='0' border="0">
	<tr>
	<td align="right">
	
	<?

				 $sql_detalle = "select distinct $t8.razon_social,  $t20.w_valor, $t20.pv_id from $t8, $t20 where $t20.evaluador5_id = $evaluador5_id and $t20.evaluador4_id = $evaluador4_id and $t8.pv_id = $t20.pv_id order by $t20.w_fecha_creacion ";
				$sql_exq = query_db($sql_detalle);				
				while($lp = traer_fila_row($sql_exq)){	
					$strXMLd.= "<set label='".$lp[0]."' value='".$lp[1]."' />";	
					}
	
	$strXML  = "<chart caption=' Evaluación promedio de desempeño".$busca_actividad[0]."' palette='" . getPalette() . "' animation='" . getAnimationState() . "' formatNumberScale='0' numberPrefix='' seriesNameInToolTip='0' sNumberSuffix=' pcs.' showValues='1' plotSpacePercent='0' labelDisplay='Rotate' slantLabels='1'>";
	$strXML .= $strXMLd;
	//Add some styles to increase caption font size
	$strXML .= "<styles><definition><style type='font' name='CaptionFont' size='15' color='" . getCaptionFontColor() . "' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
	$strXML .= "</chart>";
		
	echo renderChart("../../librerias/chart/Line.swf", "", $strXML, "TopCities", 600,400, false, true);
	?>
	</td>
	</tr>
</table>
  
  
</body>
</html>
