<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	

		$muestra_consolidado = "NO";
	



if($_GET["comite_ano"] <> 0){
	
	if($_GET["comite_ano"]==2014) $ano_c = "14";
	if($_GET["comite_ano"]==2013) $ano_c = "13";
	
	$comple_sql = " and num2 = ".$ano_c;
	}
	
	
if($_GET["id_tipo_proceso"] <> 0){
	$comple_sql = " and t1_tipo_proceso_id = ".$_GET["id_tipo_proceso"];
	}
	
	
if($_GET["nivel_aprobacion"] <> 0){

	if($_GET["nivel_aprobacion"] == 1){
		$id_ni = "1. Superintendente";
		}
	if($_GET["nivel_aprobacion"] == 2){
		$id_ni = "2. Jefe de Area";
		}
	if($_GET["nivel_aprobacion"] == 3){
		$id_ni = "3. Vicepresidente";
	}
	if($_GET["nivel_aprobacion"] == 4){
		$id_ni = "4. Comite";
		}
	if($_GET["nivel_aprobacion"] == 5){
		$id_ni = "5. Socios";
		}
	
	$comple_sql = " and nivel_adjudicacion = '".$id_ni."'";
	}

	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	




</head>

<body>

<?
if($_GET["muestra_grafica"]==1){
?>
<table width="100%" border="0" class="tabla_blanca">
    <tr>
      <td class="fondo_4" bgcolor="">Numero de procesos por area del tipo de proceso <font color="#FF0000"><?
	  if($_GET["id_tipo_proceso"]==0){
		  echo "Todos";
		  }else{
	  echo saca_nombre_lista($g13,$_GET["id_tipo_proceso"],'nombre','t1_tipo_proceso_id');
      }?></font></td>
      </tr>
    <tr>
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";



$selec_t_pro = query_db("select area, Count(*), t1_area_id from indicador_reporte_niveles_aprobacion_adjudicacion where id_item>0 and t1_tipo_proceso_id <> 8 $comple_sql group by area, t1_area_id");

	
while($sel_pro = traer_fila_db($selec_t_pro)){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$sel_pro[1]."' color = 'FFFFD2' />";	
	$va_total = $sel_pro[1] +$va_total;

	}

$strXML .= "<set label = '' value ='".$va_total."' color = 'FFFFD2'/>";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885", 800, 500, false, false);

	?></td>
    </tr>
    </table>
    
  <?
}
  ?>
  
  <?

  
if($_GET["muestra_grafica"]==2){
?>
<table width="100%" border="0" class="tabla_lista_resultados">
    <tr class="tabla_blanca">
      <td class="fondo_4" bgcolor="">Valor adjudicado por area por el tipo de proceso <font color="#FF0000">
        <?
	  if($_GET["id_tipo_proceso"]==0){
		  echo "Todos";
		  }else{
	  echo saca_nombre_lista($g13,$_GET["id_tipo_proceso"],'nombre','t1_tipo_proceso_id');
      }?>
      </font></td>
    </tr>
    <tr class="tabla_blanca">
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='US$' seriesNameInToolTip='0'  showValues='1' rotateValues='1' labelDisplay='rotate' slantLabels='1' decimalPrecision='0' formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";



$selec_t_pro = query_db("select area, t1_area_id from indicador_reporte_niveles_aprobacion_adjudicacion where id_item>0  and t1_tipo_proceso_id <> 8 $comple_sql group by area, t1_area_id");

	
while($sel_pro = traer_fila_db($selec_t_pro)){

$selec_valor_ad = query_db("select id_item from indicador_reporte_niveles_aprobacion_adjudicacion where id_item>0 $comple_sql and t1_area_id = ".$sel_pro[1]." and t1_tipo_proceso_id <> 8  group by id_item");

$convierte_a_us=0;
$valor_adfer=0;
while($sel_val = traer_fila_db($selec_valor_ad)){
	
	$sel_valor_sol_fer = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from  t2_presupuesto where  t2_item_pecc_id = ".$sel_val[0]." and permiso_o_adjudica = 2"));
	

	
	$valor_adfer = $valor_adfer+$sel_valor_sol_fer[0]+($sel_valor_sol_fer[1]/1780);
	
		

}

	$va_total_valor_ad = $valor_adfer +$va_total_valor_ad;
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$valor_adfer."' color = 'FFFFD2' />";	


	}

$strXML .= "<set label = 'Total Valor Adjudicado' value ='".$va_total_valor_ad."' color = 'FFFFD2'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885123", 800, 500, false, false);

	?></td>
    </tr>
  </table>


  <?
}
  ?>
  
  <?
if($_GET["muestra_grafica"]==3){
?>
<table width="100%" border="0" class="tabla_blanca">
    <tr>
      <td class="fondo_4" bgcolor=""> Numero de Procesos por area por nivel de aprobaci&oacute;n <font color="#FF0000"><?=$id_ni?></font></td>
      </tr>
    <tr>
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";




$selec_t_pro = query_db("select area, Count(*), t1_area_id from indicador_reporte_niveles_aprobacion_adjudicacion where id_item>0 and t1_tipo_proceso_id <> 8 $comple_sql group by area, t1_area_id");

	
while($sel_pro = traer_fila_db($selec_t_pro)){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$sel_pro[1]."' color = 'FFFFD2' />";	
	$va_total = $sel_pro[1] +$va_total;

	}

$strXML .= "<set label = '' value ='".$va_total."' color = 'FFFFD2'/>";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885", 800, 500, false, false);

	?></td>
      </tr>
    </table>
  <?
}
  ?>
  
  
  <?

  
if($_GET["muestra_grafica"]==4){
?>
<table width="100%" border="0" class="tabla_lista_resultados">
    <tr class="tabla_blanca">
      <td class="fondo_4" bgcolor="">Valor adjudicado por area por nivel de aprobaci&oacute;n <font color="#FF0000"><?=$id_ni?></font></td>
    </tr>
    <tr class="tabla_blanca">
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='US$' seriesNameInToolTip='0'  showValues='1' rotateValues='1' labelDisplay='rotate' slantLabels='1' decimalPrecision='0' formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";



$selec_t_pro = query_db("select area, t1_area_id from indicador_reporte_niveles_aprobacion_adjudicacion where id_item>0  and t1_tipo_proceso_id <> 8 $comple_sql group by area, t1_area_id");

	
while($sel_pro = traer_fila_db($selec_t_pro)){



$selec_valor_ad = query_db("select id_item from indicador_reporte_niveles_aprobacion_adjudicacion where id_item>0 $comple_sql and t1_tipo_proceso_id <> 8 and t1_area_id = ".$sel_pro[1]." group by id_item");

$convierte_a_us=0;
$valor_adfer=0;
while($sel_val = traer_fila_db($selec_valor_ad)){
	
	$sel_valor_sol_fer = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from  t2_presupuesto where  t2_item_pecc_id = ".$sel_val[0]." and permiso_o_adjudica = 2"));
	

	
	$valor_adfer = $valor_adfer+$sel_valor_sol_fer[0]+($sel_valor_sol_fer[1]/1780);
	
		

}

	$va_total_valor_ad = $valor_adfer +$va_total_valor_ad;
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$valor_adfer."' color = 'FFFFD2' />";	


	}

$strXML .= "<set label = 'Total Valor Adjudicado' value ='".$va_total_valor_ad."' color = 'FFFFD2'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885123", 800, 500, false, false);

	?></td>
    </tr>
  </table>


  <?
}
  ?>
</body>
</html>

