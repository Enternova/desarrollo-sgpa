<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	

		$muestra_consolidado = "NO";
	



if($_GET["comite_ano"] <> 0){
//	$ano_c = $_GET["comite_ano"][2].$_GET["comite_ano"][3];
/*	if($_GET["comite_ano"]==2014) $ano_c = "14";
	if($_GET["comite_ano"]==2013) $ano_c = "13";
	*/
	$comple_sql = " and fecha_creacion like '%".$_GET["comite_ano"]."%'";
	}
	$comple_sql.=" and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and (congelado is null or congelado = 2 or congelado = '') and (estado >= 20 and estado <= 32 and estado <> 31)  and (solicitud_rechazada is null or solicitud_rechazada =2 or solicitud_rechazada =0)";
	
	$comple_sql_vista.=" and t1_tipo_proceso_id <> 8 and fecha_creacion like '%".$_GET["comite_ano"]."%' and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and (congelado is null or congelado = 2 or congelado = '') and (t1.estado >= 20 and t1.estado <= 32 and t1.estado <> 31) and (solicitud_rechazada is null or solicitud_rechazada =2 or solicitud_rechazada =0) ";
	


	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	

<script>
function carga_areas_ind_nivel(tipo_grafica, id, num_valor){//tipo grafica: proceso, nivel de aprobacion - id: id_proceso o nivel (comite, socios, etc) - num_valor : numero_procesos o us_valor
document.getElementById('numero_de_procesos_por_area').width='0'
document.getElementById('numero_de_procesos_por_area').height='0'
document.getElementById('valor_adjudica_por_area').width='0'
document.getElementById('valor_adjudica_por_area').height='0'

document.getElementById('numero_de_procesos_por_area_us').width='0'
document.getElementById('numero_de_procesos_por_area_us').height='0'
document.getElementById('valor_adjudica_por_area_us').width='0'
document.getElementById('valor_adjudica_por_area_us').height='0'
			
if(tipo_grafica == 1){ // si es de procesos
	if(num_valor==1){// numeros de procesos
			document.getElementById('numero_de_procesos_por_area').width='100%'
			document.getElementById('numero_de_procesos_por_area').height='600px'
			window.numero_de_procesos_por_area.location.href="indicador_reporte_general_areas.php?id_tipo_proceso="+id+"&comite_ano=<?=$_GET["comite_ano"]?>&muestra_grafica=1"			
		}
	if(num_valor==2){// valor adjudicacon 
		
			document.getElementById('valor_adjudica_por_area').width='100%'
			document.getElementById('valor_adjudica_por_area').height='600px'
			window.valor_adjudica_por_area.location.href="indicador_reporte_general_areas.php?id_tipo_proceso="+id+"&comite_ano=<?=$_GET["comite_ano"]?>&muestra_grafica=2&nivel_aprobacion=0"
		}
			
	}

if(tipo_grafica == 2){// si es de niveles de aprobacion
		if(num_valor==1){// numeros de procesos
			document.getElementById('numero_de_procesos_por_area_us').width='100%'
			document.getElementById('numero_de_procesos_por_area_us').height='600px'
			window.numero_de_procesos_por_area_us.location.href="indicador_reporte_general_areas.php?nivel_aprobacion="+id+"&id_tipo_proceso=0&comite_ano=<?=$_GET["comite_ano"]?>&muestra_grafica=3"
		}
	if(num_valor==2){// valor adjudicacon 
		
			document.getElementById('valor_adjudica_por_area_us').width='100%'
			document.getElementById('valor_adjudica_por_area_us').height='600px'
			window.valor_adjudica_por_area_us.location.href="indicador_reporte_general_areas.php?nivel_aprobacion="+id+"&id_tipo_proceso=0&comite_ano=<?=$_GET["comite_ano"]?>&muestra_grafica=4"
			
		}
	}

}
</script>	


</head>

<body>

<table width="100%" border="0" class="tabla_lista_resultados">
<tr>
  <td><table width="100%" border="0" class="tabla_blanca">
    <tr>
      <td class="fondo_3" bgcolor="">1. NUMERO DE PROCESOS APROBADOS POR TIPO DE PROCESO</td>
      </tr>
    <tr>
      <td align="center">
	      
	  <?
	  
	

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";


  $sql="select tipo_proceso, Count(*), t1_tipo_proceso_id from indicador_reporte_niveles_aprobacion_adjudicacion where id_item>0 and t1_tipo_proceso_id <> 8 $comple_sql group by tipo_proceso, t1_tipo_proceso_id";

$selec_t_pro = query_db($sql);

	
while($sel_pro = traer_fila_db($selec_t_pro)){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$sel_pro[1]."' color = '006633' />";	
	$va_total = $sel_pro[1] +$va_total;

	}

$strXML .= "<set label = 'Numero Total de Procesos' value ='".$va_total."' color = '0033CC' />";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885", 800, 500, false, false);

	?></td>
    </tr>
    <tr>
      <td align="center"><iframe name="numero_de_procesos_por_area" width="0" height="0" frameborder="0" ></iframe></td>
    </tr>
    </table></td>
</tr>
<tr>
  <td><table width="100%" border="0" class="tabla_blanca">
    <tr class="tabla_blanca">
      <td class="fondo_3" bgcolor="">1.1 VALOR ADJUDICADO POR TIPO DE PROCESO </td>
    </tr>
    <tr class="tabla_blanca">
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='US$' seriesNameInToolTip='0'  showValues='0' labelDisplay='rotate' slantLabels='1' decimalPrecision='0' formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$selec_valor_ad = query_db("select sum(t2.valor_usd + (t2.valor_cop/t3.valor)) as permiso, t1.tipo_proceso from version_2_indi_1 as t1, $pi8 as t2, $g10 as t3 where t1.id_item = t2.t2_item_pecc_id and t1.t1_trm_id = t3.id_trm and t2.permiso_o_adjudica = 2  $comple_sql_vista group by t1.tipo_proceso");


$convierte_a_us=0;
$valor_adfer=0;
while($sel_val = traer_fila_db($selec_valor_ad)){

	$va_total_valor_ad = $sel_val[0] +$va_total_valor_ad;
	
$strXML .= "<set label = '".$sel_val[1]."' value ='".$sel_val[0]."' color = 'FF000' />";	


	}

$strXML .= "<set label = 'Total Valor Adjudicado' value ='".$va_total_valor_ad."' color = '0033CC' />";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "3asdas", 800, 500, false, false);

	?></td>
    </tr>
    <tr class="tabla_blanca">
      <td align="center"><iframe name="valor_adjudica_por_area" width="0" height="0"  frameborder="0" id="valor_adjudica_por_area"></iframe></td>
    </tr>
  </table></td></tr>
<tr>
  <td><table width="100%" border="0" class="tabla_blanca">
    <tr>
      <td class="fondo_3" bgcolor="">2. NUMERO DE PROCESOS APROBADOS POR NIVEL DE APROBACION</td>
      </tr>
    <tr>
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";


$va_total=0;

 $sql_1 = "select id_item from " . $_SESSION["version_2_indi_nivel_aprobacion_max_aprobacion"] . " ".$_SESSION["comple_filtro2"]."  group by id_item ";

//$sql="select nivel_adjudicacion, Count(*) from indicador_reporte_niveles_aprobacion_adjudicacion where id_item>0 and t1_tipo_proceso_id <> 8 $comple_sql group by nivel_adjudicacion order by nivel_adjudicacion";

  $sql="select max_id_nivel_aprobacion, Count(*) from version_2_indi_nivel_aprobacion_max_aprobacion where id_item>0 and t1_tipo_proceso_id <> 8 and max_id_nivel_aprobacion not in (5) $comple_sql group by max_id_nivel_aprobacion order by max_id_nivel_aprobacion";
 
$selec_t_pro = query_db($sql);

	
while($sel_pro = traer_fila_db($selec_t_pro)){
	
	$nombre_nivel=traer_fila_row(query_db("select nombre, id from t2_nivel_aprobacion where id = ".$sel_pro[0]));
		
$strXML .= "<set label = '".$nombre_nivel[0]."' value ='".$sel_pro[1]."' color = '006633' />";	
	$va_total = $sel_pro[1] +$va_total;

	}

$strXML .= "<set label = 'Numero Total de Procesos' value ='".$va_total."' color = '0033CC' />";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "12indicador25885", 800, 500, false, false);

	?></td>
    </tr>
    <tr>
      <td align="center"><iframe name="numero_de_procesos_por_area_us"  frameborder="0" width="0" height="0" id="numero_de_procesos_por_area_us"></iframe></td>
    </tr>
    </table></td>
</tr>
<tr>
  <td><table width="100%" border="0" class="tabla_blanca">
    <tr class="tabla_blanca">
      <td class="fondo_3" bgcolor="">2.1 VALOR ADJUDICADO POR NIVEL DE APROBACION</td>
    </tr>
    <tr class="tabla_blanca">
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='US$' seriesNameInToolTip='0'  labelDisplay='rotate' slantLabels='1' decimalPrecision='0' formatNumberScale='0' showValues='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$selec_valor_ad = query_db("select sum(t2.valor_usd + (t2.valor_cop/t3.valor)) as permiso, t1.nivel_aprobacion from version_2_indi_1 as t1, $pi8 as t2, $g10 as t3 where t1.id_item = t2.t2_item_pecc_id and t1.t1_trm_id = t3.id_trm and t2.permiso_o_adjudica = 2  $comple_sql_vista group by t1.nivel_aprobacion");


$convierte_a_us=0;
$valor_adfer=0;
$va_total_valor_ad=0;
while($sel_val = traer_fila_db($selec_valor_ad)){
$nombre_nivel=traer_fila_row(query_db("select nombre, id from t2_nivel_aprobacion where id = ".$sel_val[1]));

	$va_total_valor_ad = $sel_val[0] +$va_total_valor_ad;
	
$strXML .= "<set label = '".$nombre_nivel[0]."' value ='".$sel_val[0]."' color = 'FF000' />";	


	}

$strXML .= "<set label = 'Total Valor Adjudicado' value ='".$va_total_valor_ad."' color = '0033CC' />";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "34indicador25885123", 800, 500, false, false);

	?></td>
    </tr>
    <tr class="tabla_blanca">
      <td align="center"><iframe name="valor_adjudica_por_area_us" width="0"  frameborder="0" height="0" id="valor_adjudica_por_area_us"></iframe></td>
    </tr>
  </table></td>
</tr>
</table>
</body>
</html>

