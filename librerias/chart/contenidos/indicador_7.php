<? include("../../lib/@session.php"); ?>

<graph caption='' subcaption='' xAxisName='' yAxisMinValue='15000' yAxisName='Numero de Procesos' decimalPrecision='' formatNumberScale='0' numberPrefix='' showNames='1' showValues='0'  showAlternateHGridColor='1' AlternateHGridColor='ff5904' divLineColor='cccccc' divLineAlpha='20' alternateHGridAlpha='5' rotateNames='1' anchorBorderColor='009900' baseFontSize="10">
<set name='' value='' hoverText='' color="000000"/>
<?
$sel_actividades = query_db("select t3.nombre, count(*) from $vin_0 as t1, $pi4 as t2, $pi6 as t3 where t1.estado = t2.t2_nivel_servicio_actividad_id and t2.t2_nivel_servicio_encargado_id = t3.t2_nivel_servicio_encargado_id ".$_SESSION["comple_filtro_ano_gen"]." ".$_SESSION["comple_filtro"]." group by t3.nombre");

while($sel_activi = traer_fila_db($sel_actividades)){

?>

<set name='<?=$sel_activi[0]?>' value='<?=$sel_activi[1]?>' hoverText='<?=$sel_activi[0]?>' color="000000"/>
<?

}
?>
<set name='' value='' hoverText='' color="000000"/>
</graph>