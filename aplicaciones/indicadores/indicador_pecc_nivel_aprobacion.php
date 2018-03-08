<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	
	$filtro_aplica = "Todos";
	
	$filtro_aplica = "Todos";
	

	$explode_tipo_proceso = explode("*",$_GET["t1_tipo_proceso_id"]);
	
if($explode_tipo_proceso[0] <>0){
$_SESSION["comple_filtro2"] = $_SESSION["comple_filtro"]." and t1_tipo_proceso_id = ".$explode_tipo_proceso[0];
$filtro_aplica = traer_nombre_muestra($explode_tipo_proceso[0], "t1_tipo_proceso","nombre","t1_tipo_proceso_id");

}else{
	$_SESSION["comple_filtro2"] = $_SESSION["comple_filtro"];
	}
	
	
	

	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	
</head>

<body>

<table width="100%" border="0" class="tabla_lista_resultados">

  <tr>
    <td align="center"><table width="100%" border="0" class="tabla_blanca">
      <tr>
        <td width="100%" class="fondo_3">2. Numero de procesos por nivel de aprobacion</td>
        </tr>
      <tr>
        <td colspan="2" bgcolor="" class="" align="left"><a href="soporte_2.php" target="_blank"><img src="../../imagenes/mime/xlsx.gif" />Descargar el soporte de este indicador</a></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="" class="" align="left"><font color="#FF0000">Filtro anterior: <?=$filtro_aplica?></font></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="" class="" align="left"><img src="../../imagenes/botones/alerta.png" /> <font color="#005395"><strong>Con un Click en cualquier Barra podra seguir desendiendo en la secuencia del indicador</strong></font></td>
      </tr>
      <tr>
        <td align="center">
		
		<?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$sql="select nombre, id from t2_nivel_aprobacion where estado = 1 order by id desc";


$selec_t_pro = query_db($sql);
while($sel_pro = traer_fila_db($selec_t_pro)){
$color = "FF0000";	
if($sel_pro[1]==1){	$color = "33FF99";	}
if($sel_pro[1]==2){	$color = "CC3333";	}
if($sel_pro[1]==3){	$color = "FFFF00";	}
if($sel_pro[1]==4){	$color = "9900FF";	}
if($sel_pro[1]==5){	$color = "FF00FF";	}

 $sql_1 = "select id_item from " . $_SESSION["version_2_indi_nivel_aprobacion_max_aprobacion"] . " ".$_SESSION["comple_filtro2"]." and max_id_nivel_aprobacion = ".$sel_pro[1]." group by id_item ";


$sel_aproba=query_db($sql_1);
$cuantos=0;
while($sel_cuanos = traer_fila_db($sel_aproba)){
	$cuantos=$cuantos+1;
	}

if($cuantos>0){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$cuantos."' color = '$color' link='F-genera_indica_profecinal_real-indicador_pecc_profecional.php?nivel_aprobacion=".$sel_pro[1]."'/>";	
}

	$va_total = $cuantos +$va_total;
	}
	
	$faltan = $explode_tipo_proceso[1] - $va_total;
	
	$va_total = $va_total + $faltan;
	if($faltan>0){
	$strXML .= "<set label = 'Sin Firmas' value ='".$faltan."' color = 'FF0000' link='F-genera_indica_profecinal_real-indicador_pecc_profecional.php?nivel_aprobacion=100'/>";	
	}
$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' link='F-genera_indica_profecinal_real-indicador_pecc_profecional.php?nivel_aprobacion=0'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador232221", 800, 400, false, false);

	?>
    
    </td>
      </tr>
      <tr>
        <td align="left"><strong>Nota del indicador "2. Numero de procesos por nivel de aprobacion":</strong> este indicador cuenta los procesos por cada nivel de aprobacion, la barra de "procesos sin aprobaciones" se refiera a los procesos que aun no han llegado o aun no se han aprobado en el SGPA</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><iframe name="genera_indica_profecinal_real" id="genera_indica_profecinal_real" frameborder="0" width="100%" height="4500px"></iframe></td>
  </tr>
</table>


</body>
</html>

