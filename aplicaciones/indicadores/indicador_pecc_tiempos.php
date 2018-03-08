<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	$filtro_aplica = "Todos";
if($_GET["id_us_profesional_asignado"] <>0 and $_GET["id_us_profesional_asignado"] <>""){
	if($_GET["id_us_profesional_asignado"] ==1){
		$comple_filtro =" and (id_us_profesional_asignado is null or id_us_profesional_asignado =0)";
		}else{
			$comple_filtro =" and id_us_profesional_asignado = ".$_GET["id_us_profesional_asignado"];
			}
			
$_SESSION["comple_filtro4"] = $_SESSION["comple_filtro3"]." ".$comple_filtro;
$filtro_aplica = traer_nombre_muestra($_GET["id_us_profesional_asignado"], "t1_us_usuarios","nombre_administrador","us_id");

}elseif($_GET["id_area"] <>0 and $_GET["id_area"] <>""){
	if($_GET["id_area"] ==1){
		$comple_filtro =" and (t1_area_id is null or t1_area_id =0)";
		}else{
			$comple_filtro =" and t1_area_id = ".$_GET["id_area"];
			}
			
$_SESSION["comple_filtro4"] = $_SESSION["comple_filtro3"]." ".$comple_filtro;
$filtro_aplica = traer_nombre_muestra($_GET["id_us_profesional_asignado"], "t1_us_usuarios","nombre_administrador","us_id");

	}elseif($_GET["t1_tipo_proceso_id"] <>0 and $_GET["t1_tipo_proceso_id"] <>""){
		$comple_filtro =" and t1_tipo_proceso_id =".$_GET["t1_tipo_proceso_id"]."";
		$_SESSION["comple_filtro4"] = $_SESSION["comple_filtro3"]." ".$comple_filtro;
		}else{
	$_SESSION["comple_filtro4"] = $_SESSION["comple_filtro3"];
	}
	
	

	//INDICADOR 12

	$sele_ind_12 = traer_fila_row(query_db("select count(*) from " . $_SESSION["version_2_indi_estado_procesos"] . " ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo = 'A tiempo'  and (estado >= 20 and estado <=32 and estado <> 31) and (solicitud_rechazada is null or solicitud_rechazada = 0 or solicitud_rechazada = 2) and solicitud_desierta is null"));
		
	$sele_ind_12_12 = traer_fila_row(query_db("select count(*) from " . $_SESSION["version_2_indi_estado_procesos"] . " ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo in ('Atrazado', 'Atrasado')  and (estado >= 20 and estado <=32 and estado <> 31)  and (solicitud_rechazada is null or solicitud_rechazada = 0 or solicitud_rechazada = 2) and solicitud_desierta is null"));
	
	$sele_ind_12_rechaza = traer_fila_row(query_db("select count(*) from " . $_SESSION["version_2_indi_estado_procesos"] . " ".$_SESSION["comple_filtro4"]."  and (estado >= 20 and estado <=32 and estado <> 31)  and solicitud_rechazada =1"));
	
	$sele_ind_12_desierto = traer_fila_row(query_db("select count(*) from " . $_SESSION["version_2_indi_estado_procesos"] . " ".$_SESSION["comple_filtro4"]."   and (estado >= 20 and estado <=32 and estado <> 31)  and solicitud_desierta =1"));
	
	
	
	$sele_ind_12_12_sin_fechas = traer_fila_row(query_db("select count(*) from " . $_SESSION["version_2_indi_estado_procesos"] . " ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo = ''  and (estado >= 20 and estado <=32 and estado <> 31)"));
	
	
	$porcentaje_12 = number_format($sele_ind_12[0]/($sele_ind_12[0]+$sele_ind_12_12[0])*100,$decimal);
	$porcentaje_12_12 = number_format($sele_ind_12_12[0]/($sele_ind_12[0]+$sele_ind_12_12[0])*100,$decimal);
	//FIN INDICADOR 12 
	

	//INDICADOR 13
	$sele_ind_13=0;
	$sele_ind_13_13=0;


$sele_ind_13 = traer_fila_row(query_db("select count(*) from " . $_SESSION["version_2_indi_estado_procesos"] . " ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo = 'A tiempo'  and estado < 20"));
		
	$sele_ind_13_13 = traer_fila_row(query_db("select count(*) from " . $_SESSION["version_2_indi_estado_procesos"] . " ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo in ('Atrazado', 'Atrasado')  and estado < 20"));
	
	$sele_ind_13_13_sin_fechas = traer_fila_row(query_db("select count(*) from " . $_SESSION["version_2_indi_estado_procesos"] . " ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo = ''  and estado < 20"));
	
	$sele_ind_13=$sele_ind_13[0];
	$sele_ind_13_13=$sele_ind_13_13[0];
	
	$porcentaje_13 = number_format($sele_ind_13/($sele_ind_13+$sele_ind_13_13)*100,$decimal);
	$porcentaje_13_13 = number_format($sele_ind_13_13/($sele_ind_13+$sele_ind_13_13)*100,$decimal);
	
	//
	//FIN INDICADOR 13
	
	
	
	//INDICADOR valor permiso VS valor Adjudica
$sql_comple_pres3 = str_replace("estado not in (33,31)","t1.estado not in (33,31)",$_SESSION["comple_filtro4"]);
$sql_comple_pres2 = str_replace("estado < 20","t1.estado not in (33,31)",$sql_comple_pres3);
$sql_comple_pres = str_replace("estado >= 20 and estado <= 32 and estado <> 31","t1.estado not in (33,31)",$sql_comple_pres2);


 $sql_pre = "select sum(t2.valor_usd + (t2.valor_cop/t3.valor)) as permiso from " . $_SESSION["version_2_indi_1"] . " as t1, $pi8 as t2, $g10 as t3 ".$sql_comple_pres." and t1.id_item = t2.t2_item_pecc_id and t1.t1_trm_id = t3.id_trm and t2.permiso_o_adjudica = 1 and t1_tipo_proceso_id not in (6,9,10,11, 12, 15, 16) ";
	$sel_presupuesto = traer_fila_row(query_db($sql_pre));
	
	$sel_adju = traer_fila_row(query_db("select sum(t2.valor_usd + (t2.valor_cop/t3.valor)) as permiso from " . $_SESSION["version_2_indi_1"] . " as t1, $pi8 as t2, $g10 as t3 ".$sql_comple_pres." and t1.id_item = t2.t2_item_pecc_id and t1.t1_trm_id = t3.id_trm and t2.permiso_o_adjudica = 2   and (t1.estado >= 20 and t1.estado <=32 and t1.estado <> 31)"));
	
	$v_per_v_adj=$sel_presupuesto[0]+0;//valor presupuesto
	$v_per_v_adj_1=$sel_adju[0]+0;//valor adjudicacion
	
		$porcentaje_v_per_v_adj = number_format($v_per_v_adj/($v_per_v_adj+$v_per_v_adj_1)*100,2);
		$porcentaje_v_per_v_adj_1 = number_format($v_per_v_adj_1/($v_per_v_adj+$v_per_v_adj_1)*100,2);
	//
	//FIN INDICADOR valor permiso VS valor Adjudica
	

	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	
</head>

<body>

<table width="100%" border="0" class="tabla_lista_resultados">
<tr><td colspan="2"><font color="#FF0000">Filtro anterior: <?=$filtro_aplica?></font></td></tr>
<tr>
  <td colspan="2"><a href="soporte_4.php" target="_blank"><img src="../../imagenes/mime/xlsx.gif" />Descargar el soporte de este indicador consolidado de procesos activos y retrasados</a></td>
</tr>
<tr>
  <td colspan="2"><a href="soporte_5.php" target="_blank"><img src="../../imagenes/mime/xlsx.gif" alt="" />Descargar el soporte de este indicador detallado de procesos activos y retrasados</a></td>
</tr>
<tr>
  <td colspan="2">
  
  
  
  
  <table width="100%" border="0" class="tabla_blanca">
  
  <?
  		$resultado = strpos($_SESSION["comple_filtro4"], "nivel_aprobacion = 2");//si esta filtrado el jefe de area
	  $resultado2 = strpos($_SESSION["comple_filtro4"], "nivel_aprobacion = 1");//si esta filtrado el superintendente
	  $resultado3 = strpos($_SESSION["comple_filtro4"], "nivel_aprobacion = 3");//si esta filtrado el viceprecidente
	  
	  if($resultado !== FALSE or $resultado2 !== FALSE){
    			$carga_indi_areas="SI";
			}
	if($resultado3 !== FALSE ){
    			$carga_indi_areas_vicepresidentes="SI";
			}
			
			if($carga_indi_areas=="nunk cargue esto" or $carga_indi_areas_vicepresidentes=="nunk cargue esto"){
  ?>
  
    <tr>
      <td colspan="3" class="fondo_3">4. Procesos por Area del rol Seleccionado</td>
    </tr>
    <tr>
      <td width="56%" align="right">Procesos Activos a Tiempo:</td>
      <td width="11%" align="left"><?=$porcentaje_13?>
        %</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Procesos Activos Retrasados:</td>
      <td align="left"><?=$porcentaje_13_13?>
        %</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center"><?

	  

if($carga_indi_areas_vicepresidentes=="SI"){
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";


$selec_t_pro = query_db("select vicepresidente, Count(*),id_vp from version_2_indi_1 ".$_SESSION["comple_filtro4"]." group by vicepresidente,id_vp  order by id_vp");
while($sel_pro = traer_fila_db($selec_t_pro)){
	
	if($sel_pro[2]==0){
		$label="Sin Area";
		$valor_pasa="1";
		}else{
			$label=$sel_pro[0];
			$valor_pasa=$sel_pro[2];
			}
	
$strXML .= "<set label = '".$label."' value ='".$sel_pro[1]."' color = '006633' />";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' link='F-genera_indica_tiempos-indicador_pecc_tiempos.php?id_us_profesional_asignado=0'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885_areas_vices", 750, 300, false, false);


}

if($carga_indi_areas=="SI"){
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";


$selec_t_pro = query_db("select area, Count(*),t1_area_id from " . $_SESSION["version_2_indi_1"] . " ".$_SESSION["comple_filtro4"]." group by area,t1_area_id  order by area");
while($sel_pro = traer_fila_db($selec_t_pro)){
	
	if($sel_pro[2]==0){
		$label="Sin Area";
		$valor_pasa="1";
		}else{
			$label=$sel_pro[0];
			$valor_pasa=$sel_pro[2];
			}
	
$strXML .= "<set label = '".$label."' value ='".$sel_pro[1]."' color = '006633' />";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' link='F-genera_indica_tiempos-indicador_pecc_tiempos.php?id_us_profesional_asignado=0'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885_areas", 750, 300, false, false);


}
	?></td>
    </tr>
  </table>
  <?
}
  ?>
  </td>
</tr>

  
  <tr>
    <td width="49%" align="center" valign="top" ><table width="100%" border="0" class="tabla_blanca">
      <tr>
        <td colspan="3" class="fondo_3">5. Procesos de Solicitudes Finalizados</td>
      </tr>
      <tr>
        <td width="56%" align="right">Procesos Finalizados a Tiempo:</td>
        <td width="11%" align="left"><?=$porcentaje_12?>
          %</td>
        <td width="33%">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">Procesos Finalizados Retrasados:</td>
        <td align="left"><?=$porcentaje_12_12?>
          %</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center"><?
      
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "<set label = 'Finalizados a tiempo' value ='".$sele_ind_12[0]."' color = '006633' />";
$strXML .= "<set label = 'Finalizados retrasados' value ='".$sele_ind_12_12[0]."' color = 'EA1000' />";
$strXML .= "<set label = 'Sin Fechas' value ='".$sele_ind_12_12_sin_fechas[0]."' color = 'CC33FF' />";
$strXML .= "<set label = 'Rechazados' value ='".$sele_ind_12_rechaza[0]."' color = 'CC33FF' />";
$strXML .= "<set label = 'Declarados Desiertos' value ='".$sele_ind_12_desierto[0]."' color = 'CC33FF' />";
$strXML .= "<set label = 'Total de procesos finalizados' value ='".($sele_ind_12[0]+$sele_ind_12_12[0]+$sele_ind_12_12_sin_fechas[0]+$sele_ind_12_desierto[0]+$sele_ind_12_rechaza[0])."' color = '0033CC' />";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador4_1", 400, 300, false, false);

	?></td>
      </tr>
    </table></td>
    <td width="51%" align="center" ><table width="100%" border="0" class="tabla_blanca">
      <tr>
        <td colspan="3" class="fondo_3">6. Procesos de Solicitudes Activos</td>
      </tr>
      <tr>
        <td width="56%" align="right">Procesos Activos a Tiempo:</td>
        <td width="11%" align="left"><?=$porcentaje_13?>
          %</td>
        <td width="33%">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">Procesos Activos Retrasados:</td>
        <td align="left"><?=$porcentaje_13_13?>
          %</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center"><?
      
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "<set label = 'Activos a tiempo' value ='".$sele_ind_13."' color = '006633' />";
$strXML .= "<set label = 'Activos retrasados' value ='".$sele_ind_13_13."' color = 'EA1000' />";
//$strXML .= "<set label = 'En Firmas' value ='".$sele_ind_13_13_sin_fechas[0]."' color = 'CC33FF' />";
$strXML .= "<set label = 'Total de procesos activos' value ='".($sele_ind_13+$sele_ind_13_13+$sele_ind_13_13_sin_fechas[0])."' color = '0033CC' />";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador4_4", 400, 300, false, false);

	?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" ><table width="100%" border="0" class="tabla_blanca">
      <tr>
        <td width="100%" class="fondo_3">9. Tiempo real Vs. Ideal, por Etapas</td>
      </tr>
      <tr>
        <td align="center"><div id="indicador_4" align="center"> Etapas </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" class="titulo_afe_ceco" >TIEMPOS SOLO DE ABASTECIMIENTO</td>
  </tr>
  <tr>
    <td colspan="2"><a href="soporte_4_solo_abastecimiento.php" target="_blank"><img src="../../imagenes/mime/xlsx.gif" />Descargar el soporte de este indicador (Solo de Abastecimiento) consolidado de procesos activos y retrasados</a></td>
  </tr>
  <tr>
    <td colspan="2"><a href="soporte_5_solo_abastecimiento.php" target="_blank"><img src="../../imagenes/mime/xlsx.gif" alt="" />Descargar el soporte de este indicador (Solo de Abastecimiento)  detallado de procesos activos y retrasados</a></td>
  </tr>
  <tr>
    <td align="center" valign="top" ><table width="100%" border="0" class="tabla_blanca">
      <tr>
        <td colspan="3" class="fondo_3">10. Procesos de Solicitudes Aprobados <strong>SOLO DE ABASTECIMIENTO</strong></td>
      </tr>
      <?
      //INDICADOR 12
$ult_act_aba = 32;

if($_SESSION["id_us_session"] == 32){
//echo "select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = 'A tiempo'  and (estado = $ult_act_aba) and (solicitud_rechazada is null or solicitud_rechazada = 0 or solicitud_rechazada = 2) and solicitud_desierta is null";
}
		
		
		/*
		
	$sele_ind_12 = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = 'A tiempo'  and (estado = $ult_act_aba) and (solicitud_rechazada is null or solicitud_rechazada = 0 or solicitud_rechazada = 2) and solicitud_desierta is null"));
		
	$sele_ind_12_12 = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento in ('Atrazado', 'Atrasado')  and (estado = $ult_act_aba)  and (solicitud_rechazada is null or solicitud_rechazada = 0 or solicitud_rechazada = 2) and solicitud_desierta is null"));
	
	$sele_ind_12_rechaza = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]."  and (estado = $ult_act_aba)  and solicitud_rechazada =1"));
	
	$sele_ind_12_desierto = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]."   and (estado = $ult_act_aba)  and solicitud_desierta =1"));
	
	
	
	$sele_ind_12_12_sin_fechas = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = ''  and (estado = $ult_act_aba)"));
	
	*/
	
		
	$sele_ind_12 = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = 'A tiempo'  and (estado >= 20 and estado <=32 and estado <> 31) and (solicitud_rechazada is null or solicitud_rechazada = 0 or solicitud_rechazada = 2) and solicitud_desierta is null"));
		
	$sele_ind_12_12 = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento in ('Atrazado', 'Atrasado')  and (estado >= 20 and estado <=32 and estado <> 31)  and (solicitud_rechazada is null or solicitud_rechazada = 0 or solicitud_rechazada = 2) and solicitud_desierta is null"));
	
	$sele_ind_12_rechaza = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]."  and (estado >= 20 and estado <=32 and estado <> 31)  and solicitud_rechazada =1"));
	
	$sele_ind_12_desierto = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]."   and (estado >= 20 and estado <=32 and estado <> 31)  and solicitud_desierta =1"));
	
	
	
	$sele_ind_12_12_sin_fechas = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = ''  and (estado >= 20 and estado <=32 and estado <> 31)"));
	$porcentaje_12 = number_format($sele_ind_12[0]/($sele_ind_12[0]+$sele_ind_12_12[0])*100,$decimal);
	$porcentaje_12_12 = number_format($sele_ind_12_12[0]/($sele_ind_12[0]+$sele_ind_12_12[0])*100,$decimal);
	//FIN INDICADOR 12 
	

	//INDICADOR 13
	$sele_ind_13=0;
	$sele_ind_13_13=0;


$sele_ind_13 = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = 'A tiempo'  and (estado < $ult_act_aba and estado <> 31)"));
		
	$sele_ind_13_13 = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento in ('Atrazado', 'Atrasado')  and (estado < $ult_act_aba and estado <> 31)"));
	
	$sele_ind_13_13_sin_fechas = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = ''  and (estado < $ult_act_aba and estado <> 31)"));
	
	$sele_ind_13 = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = 'A tiempo'  and estado < 20"));
		
	$sele_ind_13_13 = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento in ('Atrazado', 'Atrasado')  and estado < 20"));
	
	$sele_ind_13_13_sin_fechas = traer_fila_row(query_db("select count(*) from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." and estado_atrazado_atiempo_solo_abastecimiento = ''  and estado < 20"));
	
	$sele_ind_13=$sele_ind_13[0];
	$sele_ind_13_13=$sele_ind_13_13[0];
	
	$porcentaje_13 = number_format($sele_ind_13/($sele_ind_13+$sele_ind_13_13)*100,$decimal);
	$porcentaje_13_13 = number_format($sele_ind_13_13/($sele_ind_13+$sele_ind_13_13)*100,$decimal);
	
	//
	//FIN INDICADOR 13
	  ?>
      
      <tr>
        <td width="56%" align="right">Procesos Finalizados a Tiempo:</td>
        <td width="11%" align="left"><?=$porcentaje_12?>
          %</td>
        <td width="33%">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">Procesos Finalizados Retrasados:</td>
        <td align="left"><?=$porcentaje_12_12?>
          %</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center"><?
      
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "<set label = 'Finalizados a tiempo' value ='".$sele_ind_12[0]."' color = '006633' />";
$strXML .= "<set label = 'Finalizados retrasados' value ='".$sele_ind_12_12[0]."' color = 'EA1000' />";
//$strXML .= "<set label = 'Sin Fechas' value ='".$sele_ind_12_12_sin_fechas[0]."' color = 'CC33FF' />";
$strXML .= "<set label = 'Rechazados' value ='".$sele_ind_12_rechaza[0]."' color = 'CC33FF' />";
$strXML .= "<set label = 'Declarados Desiertos' value ='".$sele_ind_12_desierto[0]."' color = 'CC33FF' />";
$strXML .= "<set label = 'Total de procesos finalizados' value ='".($sele_ind_12[0]+$sele_ind_12_12[0]+$sele_ind_12_12_sin_fechas[0]+$sele_ind_12_desierto[0]+$sele_ind_12_rechaza[0])."' color = '0033CC' />";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador4_1_solo_abastecimiento", 400, 300, false, false);

	?></td>
      </tr>
    </table></td>
    <td align="center" valign="top" ><table width="100%" border="0" class="tabla_blanca">
      <tr>
        <td colspan="3" class="fondo_3">11. Procesos de Solicitudes Activos <strong>SOLO DE ABASTECIMIENTO</strong></td>
      </tr>
      <tr>
        <td width="56%" align="right">Procesos Activos a Tiempo:</td>
        <td width="11%" align="left"><?=$porcentaje_13?>
          %</td>
        <td width="33%">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">Procesos Activos Retrasados:</td>
        <td align="left"><?=$porcentaje_13_13?>
          %</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center"><?
      
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "<set label = 'Activos a tiempo' value ='".$sele_ind_13."' color = '006633' />";
$strXML .= "<set label = 'Activos retrasados' value ='".$sele_ind_13_13."' color = 'EA1000' />";
//$strXML .= "<set label = 'En Firmas' value ='".$sele_ind_13_13_sin_fechas[0]."' color = 'CC33FF' />";
$strXML .= "<set label = 'Total de procesos activos' value ='".($sele_ind_13+$sele_ind_13_13+$sele_ind_13_13_sin_fechas[0])."' color = '0033CC' />";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador4_4_solo_abastecimiento",400, 300, false, false);

	?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" ><table width="100%" border="0" class="tabla_blanca">
      <tr>
        <td width="100%" class="fondo_3">12. Tiempo real Vs. Ideal, por Etapas <strong>SOLO DE ABASTECIMIENTO</strong></td>
      </tr>
      <tr>
        <td align="center"><div id="indicador_11" align="center"> Etapas </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" ><table width="100%" border="0" class="tabla_blanca">
      <tr>
        <td colspan="3" class="fondo_3">13. Valor Presupuestado Vs. Adjudicado - Solo Finalizados</td>
      </tr>
      <tr>
        <td width="57%" align="right">Valor Presupuestado</td>
        <td width="10%" align="left"><?=$porcentaje_v_per_v_adj?>
          %</td>
        <td width="33%">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">Valor Adjudicado</td>
        <td align="left"><?=$porcentaje_v_per_v_adj_1?>
          %</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center"><?
      
$strXML = "";
$strXML = "<chart caption=''  numberPrefix='US$' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='1' decimalPrecision='0' formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "<set label = 'Valor Presupuestado' value ='".$v_per_v_adj."' color = '006633' />";
$strXML .= "<set label = 'Valor Adjudicado' value ='".$v_per_v_adj_1."' color = 'EA1000' />";
$strXML .= "<set label = 'Diferencia' value ='".($v_per_v_adj_1-$v_per_v_adj)."' color = '0033CC' />";
$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador258", 600, 355, false, false);

	?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" ></td>
  </tr>
</table>
<?=$link_complt?>
      <script type="text/javascript">
		   
		   
		   
		   
		   
		   /*
		   var chart = new FusionCharts("../../librerias/chart/FCF_MSLine.swf", "ChartId", "800", "500");
		   chart.setDataURL("../../librerias/chart/contenidos/indicador_2.php");		   
		   chart.render("indicador_2");
		 
		    
		   
		   var chart = new FusionCharts("../../librerias/chart/FCF_MSLine.swf", "ChartId", "410", "400");
		   chart.setDataURL("../../librerias/chart/contenidos/indicador_6.php");		   
		   chart.render("indicador_6");
		   
		   /*
		   var chart = new FusionCharts("../../librerias/chart/FCF_Line.swf", "ChartId", "400", "400");
		   chart.setDataURL("../../librerias/chart/contenidos/indicador_7.php");		   
		   chart.render("indicador_7");

		    

		   var chart = new FusionCharts("../../librerias/chart/FCF_Line.swf", "ChartId", "800", "600");
		   chart.setDataURL("../../librerias/chart/contenidos/indicador_9.php");		   
		   chart.render("indicador_9");
		   */		   
			var chart = new FusionCharts("../../librerias/chart/FCF_MSLine.swf", "ChartId", "800", "500");
		   chart.setDataURL("../../librerias/chart/contenidos/indicador_4.php");		   
		   chart.render("indicador_4");
		   
		   var chart = new FusionCharts("../../librerias/chart/FCF_MSLine.swf", "ChartId", "900", "450");
		   chart.setDataURL("../../librerias/chart/contenidos/indicador_11.php");		   
		   chart.render("indicador_11");
		   
		  
		   
		   
		</script>	
       

</body>
</html>

