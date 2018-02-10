<? include("../../lib/@session.php"); 
	

?>

<graph caption='' subcaption='' xAxisName='' yAxisMinValue='' yAxisName='Numero de Procesos' decimalPrecision='1' formatNumberScale='' numberPrefix='' showNames='1' showValues='0'  showAlternateHGridColor='1' AlternateHGridColor='ff5904' divLineColor='cccccc' divLineAlpha='20' alternateHGridAlpha='5' rotateNames='1' anchorBorderColor='009900' baseFontSize="10">
<set name='' value='' hoverText='' color="000000"/>
<?
$sel_actividades = query_db("select t2_nivel_servicio_actividad_id, nombre from t2_nivel_servicio_actividades where t2_nivel_servicio_actividad_id not in (2,3,4,5) order by t2_nivel_servicio_actividad_id");
while($sel_activi = traer_fila_db($sel_actividades)){
	
	if($sel_activi[0] == 32){
			$valor_123=0;
		}
	
	if($sel_activi[0] == 6){
			$valor_123=0;
		}
	if($sel_activi[0] == 7){
			$valor_123=10;
		}
	if($sel_activi[0] == 8){
			$valor_123=0;
		}
	if($sel_activi[0] == 9){
			$valor_123=25;
		}
	if($sel_activi[0] == 10){
			$valor_123=0;
		}
	if($sel_activi[0] == 11){
			$valor_123=0;
		}
	if($sel_activi[0] == 12){
			$valor_123=9;
		}
	if($sel_activi[0] == 13){
			$valor_123=0;
		}
	if($sel_activi[0] == 14){
			$valor_123=5;
		}
	if($sel_activi[0] == 15){
			$valor_123=5;
		}
	if($sel_activi[0] == 16){
			$valor_123=0;
		}
	if($sel_activi[0] == 17){
			$valor_123=0;
		}
	if($sel_activi[0] == 18){
			$valor_123=9;
		}
	if($sel_activi[0] == 19){
			$valor_123=0;
		}
	if($sel_activi[0] == 20){
			$valor_123=0;
		}
	if($sel_activi[0] == 21){
			$valor_123=0;
		}
	if($sel_activi[0] == 22){
			$valor_123=0;
		}
	if($sel_activi[0] == 23){
			$valor_123=8;
		}
	if($sel_activi[0] == 24){
			$valor_123=0;
		}
	if($sel_activi[0] == 25){
			$valor_123=0;
		}
	if($sel_activi[0] == 26){
			$valor_123=7;
		}
	if($sel_activi[0] == 27){
			$valor_123=0;
		}
	if($sel_activi[0] == 28){
			$valor_123=0;
		}
	if($sel_activi[0] == 29){
			$valor_123=0;
		}
?>
<set name='<?=$sel_activi[1]?>' value='<?=$valor_123?>' color="000000"/>
<?

}
?>
<set name='' value='' hoverText='' color="000000"/>
</graph>