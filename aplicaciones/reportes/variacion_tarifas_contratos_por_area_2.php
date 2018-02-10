<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	
$_SESSION["comple_filtro"] = " where fecha_inicio_vigencia >= '".$_GET["fecha_inicial"]."' and (fecha_fin_vigencia <= '".$_GET["fecha_hasta"]."' or fecha_fin_vigencia ='')";
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	
</head>
<style>

body {
	
	background:#FFFFFF;
}

</style>
<body>

<table width="100%" border="0" class="tabla_blanca">

  <tr>
    <td align="center">
    
          <?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$sql="select t1_area_id, area from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]."  group by t1_area_id, area order by area";


$selec_t_pro = query_db($sql);
while($sel_pro = traer_fila_db($selec_t_pro)){
$color = "FF0000";	
if($sel_pro[0]==1){	$color = "33FF99";	}
if($sel_pro[0]==2){	$color = "CC3333";	}
if($sel_pro[0]==3){	$color = "FFFF00";	}
if($sel_pro[0]==4){	$color = "9900FF";	}
if($sel_pro[0]==5){	$color = "FF00FF";	}
if($sel_pro[0]==6){	$color = "33FF99";	}
if($sel_pro[0]==7){	$color = "CC3333";	}
if($sel_pro[0]==8){	$color = "FFFF00";	}
if($sel_pro[0]==9){	$color = "9900FF";	}
if($sel_pro[0]==10){	$color = "FF00FF";	}
if($sel_pro[0]==11){	$color = "33FF99";	}
if($sel_pro[0]==12){	$color = "CC3333";	}
if($sel_pro[0]==13){	$color = "FFFF00";	}
if($sel_pro[0]==14){	$color = "9900FF";	}
if($sel_pro[0]==15){	$color = "FF00FF";	}
if($sel_pro[0]==16){	$color = "33FF99";	}
if($sel_pro[0]==17){	$color = "CC3333";	}
if($sel_pro[0]==18){	$color = "FFFF00";	}
if($sel_pro[0]==19){	$color = "9900FF";	}
if($sel_pro[0]==20){	$color = "FF00FF";	}
if($sel_pro[0]==21){	$color = "33FF99";	}
if($sel_pro[0]==22){	$color = "CC3333";	}
if($sel_pro[0]==23){	$color = "FFFF00";	}
if($sel_pro[0]==24){	$color = "9900FF";	}
if($sel_pro[0]==25){	$color = "FF00FF";	}
if($sel_pro[0]==26){	$color = "FF00FF";	}
if($sel_pro[0]==27){	$color = "33FF99";	}
if($sel_pro[0]==28){	$color = "CC3333";	}
if($sel_pro[0]==29){	$color = "FFFF00";	}
if($sel_pro[0]==30){	$color = "9900FF";	}
if($sel_pro[0]==31){	$color = "FF00FF";	}




$sql_1 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]." and  t1_area_id = ".$sel_pro[0]." and t6_tarifas_estados_contratos_id <> 6"));

$sql_2_excep = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]." and  t1_area_id = ".$sel_pro[0]." and t6_tarifas_estados_contratos_id = 6"));

$cuantos=$sql_1[0];
$cuantos2=$sql_2_excep[0];


if($cuantos>0){
$strXML .= "<set label = '".$sel_pro[1]."' value ='".$cuantos."' color = '$color' link='F-genera_indica_profecinal_real-indicador_pecc_profecional.php?nivel_aprobacion=".$sel_pro[0]."'/>";	
}

	$va_total = $cuantos +$va_total;
	}
		
	
$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' link='F-genera_indica_profecinal_real-indicador_pecc_profecional.php?nivel_aprobacion=0'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador232221", 1000, 600, false, false);

	?>
          
    </td>
  </tr>
  <tr>
    <td align="center"><iframe name="genera_indica_profecinal_real" id="genera_indica_profecinal_real" frameborder="0" width="100%" height="0px"></iframe></td>
  </tr>
</table>


</body>
</html>

