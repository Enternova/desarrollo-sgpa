<? include("../../lib/@session.php"); ?>

<graph caption='' subcaption='' xAxisName='' yAxisMinValue='15000' yAxisName='Numero de Procesos' decimalPrecision='' formatNumberScale='0' numberPrefix='' showNames='1' showValues='0'  showAlternateHGridColor='1' AlternateHGridColor='ff5904' divLineColor='cccccc' divLineAlpha='20' alternateHGridAlpha='5' rotateNames='1' anchorBorderColor='009900' baseFontSize="10">
<set name='' value='' hoverText='' color="000000"/>
<?
$sel_actividades = query_db("select t2_nivel_servicio_encargado_id, nombre from t2_nivel_servicio_encargado order by nombre");

while($sel_activi = traer_fila_db($sel_actividades)){
	
	if($sel_activi[0] == 1){
			$valor_123=0;
		}
	if($sel_activi[0] == 2){
			$valor_123=5;
		}
	if($sel_activi[0] == 3){
			$valor_123=10;
		}
	if($sel_activi[0] == 4){
			$valor_123=0;
		}
	if($sel_activi[0] == 5){
			$valor_123=34;
		}
	if($sel_activi[0] == 6){
			$valor_123=0;
		}
	if($sel_activi[0] == 7){
			$valor_123=7;
		}
	if($sel_activi[0] == 8){
			$valor_123=8;
		}
	if($sel_activi[0] == 9){
			$valor_123=0;
		}

?>

<set name='<?=$sel_activi[1]?>' value='<?=$sel_activi[0]?>' hoverText='<?=$sel_activi[0]?>' color="000000"/>
<?

}
?>
<set name='' value='' hoverText='' color="000000"/>
</graph>