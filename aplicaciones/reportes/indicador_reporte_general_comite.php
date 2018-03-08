<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	

		$muestra_consolidado = "NO";
	



if($_GET["comite_numero"] <> 0){
	$comple_sql = " and id_comite = ".$_GET["comite_numero"];
	}

	$mes="";
if($_GET["comite_mes"] <> 0){
		$mes = $_GET["comite_mes"];
		if($mes<10){
			$mes = "0".$mes;
			}	
			$mes = "-".$mes."-";



		if($_GET["comite_ano"] <> 0){
			$mes = $_GET["comite_ano"].$mes;
			}	
			
		$comple_sql.= " and fecha like '%-".$mes."-%' ";
	}
	
if($_GET["comite_ano"] <> 0 and $mes==""){

			$comple_sql.= " and fecha like '%".$_GET["comite_ano"]."%' ";
			}		

	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	

<script>
function carga_areas_ind_nivel(tipo_grafica, id, num_valor){//tipo grafica: proceso, nivel de aprobacion - id: id_proceso o nivel (comite, socios, etc) - num_valor : numero_procesos o us_valor
document.getElementById('numero_de_procesos_por_area').width='0'//este
document.getElementById('numero_de_procesos_por_area').height='0'
document.getElementById('valor_adjudica_por_area').width='0'//este
document.getElementById('valor_adjudica_por_area').height='0'

/*document.getElementById('numero_de_procesos_por_area_us').width='0'
document.getElementById('numero_de_procesos_por_area_us').height='0'
document.getElementById('valor_adjudica_por_area_us').width='0'
document.getElementById('valor_adjudica_por_area_us').height='0'
	*/		
if(tipo_grafica == 1){ // si es de procesos
	if(num_valor==1){// numeros de procesos
			document.getElementById('numero_de_procesos_por_area').width='100%'
			document.getElementById('numero_de_procesos_por_area').height='600px'
			window.numero_de_procesos_por_area.location.href="indicador_reporte_general_areas_comite.php?id_tipo_proceso="+id+"&comite_numero=<?=$_GET["comite_numero"]?>&comite_mes=<?=$_GET["comite_mes"]?>&comite_ano=<?=$_GET["comite_ano"]?>&muestra_grafica=1"			
		}
	if(num_valor==2){// valor adjudicacon 
		
			document.getElementById('valor_adjudica_por_area').width='100%'
			document.getElementById('valor_adjudica_por_area').height='600px'
			window.valor_adjudica_por_area.location.href="indicador_reporte_general_areas_comite.php?id_tipo_proceso="+id+"&comite_numero=<?=$_GET["comite_numero"]?>&comite_mes=<?=$_GET["comite_mes"]?>&comite_ano=<?=$_GET["comite_ano"]?>&muestra_grafica=2&nivel_aprobacion=0"
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
      <td class="fondo_3" bgcolor="">1. Numero de Procesos aprobados por tipo de proceso</td>
      </tr>
    <tr>
      <td align="left"><img src="../../imagenes/botones/alerta.png" alt="" /> <font color="#005395"><strong>Con un Click en cualquier Barra podra ver las areas usuarias relacionadas</strong></font></td>
    </tr>
    <tr>
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";



$selec_t_pro = query_db("select tipo_proceso, Count(*), t1_tipo_proceso_id from indicador_reporte_niveles_aprobacion_adjudicacion_comite where id_item>0 and t1_tipo_proceso_id <> 8 $comple_sql group by tipo_proceso, t1_tipo_proceso_id");

	
while($sel_pro = traer_fila_db($selec_t_pro)){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$sel_pro[1]."' color = '006633' link='javascript:carga_areas_ind_nivel(1, ".$sel_pro[2].", 1)'/>";	
	$va_total = $sel_pro[1] +$va_total;

	}

$strXML .= "<set label = 'Numero Total de Procesos' value ='".$va_total."' color = '0033CC' link='javascript:carga_areas_ind_nivel(1, 0, 1)'/>";
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
      <td class="fondo_3" bgcolor="">1.1 Valor adjudicado por tipo de procesos adjudicados</td>
    </tr>
    <tr class="tabla_blanca">
      <td align="left"><img src="../../imagenes/botones/alerta.png" alt="" /> <font color="#005395"><strong>Con un Click en cualquier Barra podra ver las areas usuarias relacionadas</strong></font></td>
    </tr>
    <tr class="tabla_blanca">
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='US$' seriesNameInToolTip='0'  showValues='1' rotateValues='1' labelDisplay='rotate' slantLabels='1' decimalPrecision='0' formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";



$selec_t_pro = query_db("select tipo_proceso, t1_tipo_proceso_id from indicador_reporte_niveles_aprobacion_adjudicacion_comite where id_item>0  and t1_tipo_proceso_id <> 8 $comple_sql group by tipo_proceso, t1_tipo_proceso_id");

	
while($sel_pro = traer_fila_db($selec_t_pro)){

$selec_valor_ad = query_db("select id_item from indicador_reporte_niveles_aprobacion_adjudicacion_comite where id_item>0 $comple_sql and t1_tipo_proceso_id = ".$sel_pro[1]." group by id_item");

$convierte_a_us=0;
$valor_adfer=0;
while($sel_val = traer_fila_db($selec_valor_ad)){
	
	$sel_valor_sol_fer = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from  t2_presupuesto where  t2_item_pecc_id = ".$sel_val[0]." and permiso_o_adjudica = 2"));
	

	
	$valor_adfer = $valor_adfer+$sel_valor_sol_fer[0]+($sel_valor_sol_fer[1]/1780);
	
		

}

	$va_total_valor_ad = $valor_adfer +$va_total_valor_ad;
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$valor_adfer."' color = 'FF000' link='javascript:carga_areas_ind_nivel(1, ".$sel_pro[1].", 2)'/>";	


	}

$strXML .= "<set label = 'Total Valor Adjudicado' value ='".$va_total_valor_ad."' color = 'FF000' link='javascript:carga_areas_ind_nivel(1, 0, 2)'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885123", 800, 500, false, false);

	?></td>
    </tr>
    <tr class="tabla_blanca">
      <td align="center"><iframe name="valor_adjudica_por_area" width="0" height="0"  frameborder="0" id="valor_adjudica_por_area"></iframe></td>
    </tr>
  </table></td></tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
</table>
</body>
</html>

