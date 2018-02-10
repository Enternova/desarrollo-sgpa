<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	
	
$filtro_aplica = "Todos";
if($_GET["nivel_aprobacion"] <>0 and $_GET["nivel_aprobacion"] <> 100){
$_SESSION["comple_filtro3"] = $_SESSION["comple_filtro2"]." and nivel_aprobacion = ".$_GET["nivel_aprobacion"];
$filtro_aplica = traer_nombre_muestra($_GET["nivel_aprobacion"], "t2_nivel_aprobacion","nombre","id");

}elseif($_GET["nivel_aprobacion"] == 100){
	$_SESSION["comple_filtro3"] = $_SESSION["comple_filtro2"]." and nivel_aprobacion is null";
$filtro_aplica = "Procesos Sin Aprobaciones";
	}else{
	$_SESSION["comple_filtro3"] = $_SESSION["comple_filtro2"];
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
      <td colspan="2" bgcolor="" class="fondo_3">3. Numero de Procesos por Profesional de Compras y Contratacion</td>
      </tr>
    <tr>
      <td colspan="2" bgcolor="" class="fondo_3">Numero de procesos actualmente asignados</td>
      </tr>
    <td colspan="2" bgcolor="" class="" align="left"><font color="#FF0000">Filtro anterior: <?=$filtro_aplica?></font></td>
      </tr>	
    <tr>
      <td colspan="2" bgcolor="" class="" align="left"><a href="soporte_3.php" target="_blank"><img src="../../imagenes/mime/xlsx.gif" />Descargar el soporte de este indicador</a></td>
    </tr>
    <tr>
      <td width="50%" align="left"><img src="../../imagenes/botones/alerta.png" /> <font color="#005395"><strong>Con un Click en cualquier Barra podra seguir desendiendo en la secuencia del indicador</strong></font></td>
      <td width="50%" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$selec_t_pro = query_db("select profesional, Count(*),id_us_profesional_asignado from " . $_SESSION["version_2_indi_1"] . " ".$_SESSION["comple_filtro3"]." group by profesional,id_us_profesional_asignado  order by profesional");
while($sel_pro = traer_fila_db($selec_t_pro)){
	
	if($sel_pro[2]==0){
		$label="Sin Profesional Asignado";
		$valor_pasa="1";
		}else{
			$label=$sel_pro[0];
			$valor_pasa=$sel_pro[2];
			}
	
$strXML .= "<set label = '".$label."' value ='".$sel_pro[1]."' color = '006633' link='F-genera_indica_tiempos-indicador_pecc_tiempos.php?id_us_profesional_asignado=".$valor_pasa."'/>";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' link='F-genera_indica_tiempos-indicador_pecc_tiempos.php?id_us_profesional_asignado=0'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885", 800, 400, false, false);

	?></td>
      </tr>
    <tr>
      <td align="left">Nota: Este indicador cuenta todos los procesos que se encuentran actualmente asignados a cada profesional de compras y contratacion</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>

    <tr>
      <td colspan="2" align="left" class="fondo_3">3.1 Numero de procesos por Area</td>
      </tr>
    <tr>
      <td colspan="2" align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML.= "<set label = '' value ='' color = '' />";
$va_total=0;

$sql = "select nombre_sin_acentos, Count(*),t1_area_id from " . $_SESSION["version_2_indi_1"] . " ".$_SESSION["comple_filtro3"]." group by nombre_sin_acentos,t1_area_id  order by nombre_sin_acentos";


$selec_tarea = query_db($sql);
while($sel_pro_area = traer_fila_db($selec_tarea)){
	
	if($sel_pro_area[2]==0){
		$label="Sin Area Asignada";
		$valor_pasa="1";
		}else{
			$label=$sel_pro_area[0];
			$valor_pasa=$sel_pro_area[2];
			}
	
$strXML.= "<set label = '".$label."' value ='".$sel_pro_area[1]."' color = '006633' link='F-genera_indica_tiempos-indicador_pecc_tiempos.php?id_area=".$valor_pasa."'/>";	
	$va_total = $sel_pro_area[1] +$va_total;
	}

$strXML.= "<set label = 'Total' value ='".$va_total."' color = '0033CC' link='F-genera_indica_tiempos-indicador_pecc_tiempos.php?id_area=0'/>";

$strXML.= "<set label = '' value ='' color = '' />";
$strXML.= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "id_indi_areas", 800, 400, false, false);

	?></td>
      </tr>
      
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    
 <?  
	  
	  
	  if($_GET["nivel_aprobacion"] == "oculta por ahora"){?> 
    <tr>
      <td colspan="2" align="left" class="fondo_3">3.2 Numero de procesos por Jefatura</td>
      </tr>
    <tr>
      <td colspan="2" align="center"><?
	  
$va_total=0;
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

		  
$selec_t_pro = query_db("select nombre_jefatura, Count(*),id_jefe from v_pecc_n_servicio_1_jefes ".$_SESSION["comple_filtro"]." ".str_replace("where", "and", $_SESSION["comple_filtro3"])."  group by nombre_jefatura,id_jefe  order by nombre_jefatura");

while($sel_pro = traer_fila_db($selec_t_pro)){
	$label=$sel_pro[0];
	
	$valor_gr=0;
	if($sel_pro[2]==3 or $sel_pro[2]==14 or $sel_pro[2]==4 or $sel_pro[2]==5 or $sel_pro[2]==6 or $sel_pro[2]==7){
			if($sel_pro[2]==3){$valor_gr=7;}
		if($sel_pro[2]==14){$valor_gr=30;}
		if($sel_pro[2]==4){$valor_gr=7;}
		if($sel_pro[2]==5){$valor_gr=27;}
		if($sel_pro[2]==6){$valor_gr=3;}
		if($sel_pro[2]==7){$valor_gr=7;}
			
		}else{
			$valor_gr=$sel_pro[1];
			}
			
$strXML .= "<set label = '".$sel_pro[2]." ".$label."' value ='".$valor_gr."' color = '006633' />";	
	$va_total = $valor_gr +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' />";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "ind5fexx", 800, 400, false, false);

	?></td>
    </tr>
 <? } ?> 
 <?  if($_GET["nivel_aprobacion"] == 2){?> 
    <tr>
      <td colspan="2" align="left" class="fondo_3">3.2 Numero de procesos por Gerencia</td>
      </tr>
    <tr>
      <td colspan="2" align="center"><?
	  
$va_total=0;
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$selec_t_pro = query_db("select nombre_ger, Count(*),nombre_gerencia_id from v_pecc_n_servicio_1_gerencias ".$_SESSION["comple_filtro"]." ".str_replace("where", "and", $_SESSION["comple_filtro3"])."  group by nombre_ger,nombre_gerencia_id  order by nombre_ger");

while($sel_pro = traer_fila_db($selec_t_pro)){
	if($sel_pro[0]==""){
		$label="VP Financiera y Administrativa";
		$valor_pasa="1";
		}else{
			$label=$sel_pro[0];
			$valor_pasa=$sel_pro[2];
			}
			
$strXML .= "<set label = '".$label."' value ='".$sel_pro[1]."' color = '006633' />";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' />";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "ind5fexx", 800, 400, false, false);

	?></td>
    </tr>
 <? } ?>   
    <?  
if($_GET["nivel_aprobacion"] == 6 or $_GET["nivel_aprobacion"] == 3){
?>
    <tr>
      <td colspan="2" align="left" class="fondo_3">3.3 Numero de procesos por Vicepresidencia / Director</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><?
	  
$va_total=0;
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";


$selec_t_pro = query_db("select nombre_vicepresidencia, Count(*),nombre_vicepresidencia_id from v_pecc_n_servicio_1_vices ".$_SESSION["comple_filtro"]." ".str_replace("where", "and", $_SESSION["comple_filtro3"])."  group by nombre_vicepresidencia,nombre_vicepresidencia_id  order by nombre_vicepresidencia");

while($sel_pro = traer_fila_db($selec_t_pro)){
	if($sel_pro[0]==""){
		$label="Presidencia";
		$valor_pasa="1";
		}else{
			$label=$sel_pro[0];
			$valor_pasa=$sel_pro[2];
			}
			
$strXML .= "<set label = '".$label."' value ='".$sel_pro[1]."' color = '006633' />";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' />";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "ind5fexx11", 800, 400, false, false);

	?></td>
    </tr>
    
    <? } ?>
    
    <?
    if($_GET["nivel_aprobacion"] <> 0){
	?>
    <tr>
      <td colspan="2" align="left" class="fondo_3">3.2 Numero de procesos por tipo de proceso</td>
    </tr>
    
    <tr>
      <td align="left"><img src="../../imagenes/botones/alerta.png" alt="" /> Estas Graficas aplican solo cuando se filtra por nivel de aprobacion</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><?
	  
$va_total=0;
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='0'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$selec_t_pro = query_db("select tipo_proceso, Count(*),t1_tipo_proceso_id from $version_2_indi_1 ".$_SESSION["comple_filtro"]." ".str_replace("where", "and", $_SESSION["comple_filtro3"])." group by tipo_proceso,t1_tipo_proceso_id  order by tipo_proceso");
while($sel_pro = traer_fila_db($selec_t_pro)){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$sel_pro[1]."' color = '006633' link='F-genera_indica_tiempos-indicador_pecc_tiempos.php?t1_tipo_proceso_id=".$sel_pro[2]."'/>";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' link='F-genera_indica_tiempos-indicador_pecc_tiempos.php?t1_tipo_proceso_id=0'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885fer", 800, 400, false, false);

	?></td>
    </tr>
      <?
	}
	  ?>
    </table></td>
</tr>
<tr>
  <td align="center"> <iframe name="genera_indica_tiempos" id="genera_indica_tiempos" frameborder="0" width="100%" height="2500"></iframe></td>
</tr>
</table>
     
       

</body>
</html>

