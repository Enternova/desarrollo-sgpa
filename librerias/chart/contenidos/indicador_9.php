<? include("../../lib/@session.php"); 
	

?>

<graph caption='' subcaption='' xAxisName='' yAxisMinValue='' yAxisName='Numero de Procesos' decimalPrecision='0' formatNumberScale='' numberPrefix='' showNames='1' showValues='1'  showAlternateHGridColor='1' AlternateHGridColor='ff5904' divLineColor='cccccc' divLineAlpha='20' alternateHGridAlpha='5' rotateNames='1'  anchorBorderColor='009900' baseFontSize="10" slantLabels='1' labelDisplay='rotate'>
<set name='' value='' hoverText='' color="000000"/>
<?
//$sel_actividades = query_db("select t2.nombre, count(*) from $vin_0 as t1, $pi4 as t2, $pi6 as t3 where t1.estado = t2.t2_nivel_servicio_actividad_id and t2.t2_nivel_servicio_encargado_id = t3.t2_nivel_servicio_encargado_id ".$_SESSION["comple_filtro_ano_gen"]." ".$_SESSION["comple_filtro"]." group by t2.nombre");


$sel_actividades = query_db("select actividad,count(*),encargado from version_2_indi_estado_procesos ".$_SESSION["comple_filtro4"]." and estado <> 32 group by actividad,encargado");


while($sel_activi = traer_fila_db($sel_actividades)){
?>
<set name='<?=$sel_activi[2]."  - ".$sel_activi[0]?>' value='<?=$sel_activi[1]?>' color="000000"/>
<?

}
?>
<set name='' value='' hoverText='' color="000000"/>
</graph>