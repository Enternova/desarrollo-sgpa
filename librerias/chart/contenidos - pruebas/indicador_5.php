<? include("../../lib/@session.php"); 
	

?>

<graph caption='' subcaption='' hovercapbg='' hovercapborder='cccccc' formatNumberScale='0' decimalPrecision='0' showvalues='0' numdivlines='5' numVdivlines='0' yaxisminvalue='0' yaxismaxvalue=''  rotateNames='1' yAxisName='Numero de Dias' xAxisName='Encargados' baseFontSize="10">
<categories >
		<category name='' />
        <?
		
$sel_actividades = query_db("select t2_nivel_servicio_encargado_id, nombre from t2_nivel_servicio_encargado order by nombre");
$cuantos = 0;
$scrip_1="";
$scrip_3="";
while($sel_activi = traer_fila_db($sel_actividades)){
	$actividad = $sel_activi[1];	
	echo "<category name='".$actividad."' />";
	
	if($sel_activi[0] == 1){
			$scrip_1.= "<set value='11' />";//Estimados
			$scrip_3.= "<set value='9' />";//reales
		}
	if($sel_activi[0] == 2){
			$scrip_1.= "<set value='23' />";//Estimados
			$scrip_3.= "<set value='18' />";//reales
		}
	if($sel_activi[0] == 3){
			$scrip_1.= "<set value='2' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 4){
			$scrip_1.= "<set value='14' />";//Estimados
			$scrip_3.= "<set value='16' />";//reales
		}
	if($sel_activi[0] == 5){
			$scrip_1.= "<set value='20' />";//Estimados
			$scrip_3.= "<set value='23' />";//reales
		}
	if($sel_activi[0] == 6){
			$scrip_1.= "<set value='0' />";//Estimados
			$scrip_3.= "<set value='0' />";//reales
		}
	if($sel_activi[0] == 7){
			$scrip_1.= "<set value='1' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 8){
			$scrip_1.= "<set value='19' />";//Estimados
			$scrip_3.= "<set value='23' />";//reales
		}
	if($sel_activi[0] == 9){
			$scrip_1.= "<set value='5' />";//Estimados
			$scrip_3.= "<set value='6' />";//reales
		}
	
	
	
	
	
}
?> 
<category name='' />
</categories>
<dataset seriesName='Promedio de Dias Estimado' color='000000' anchorBorderColor='000000' anchorBgColor='000000'>
	<set value='' />
	<?
    echo $scrip_1;
	?>
	  <set value='' /> 
	</dataset>
    

<dataset seriesName='Promedio de Dias Reales' color='0033FF' anchorBorderColor='0033FF' anchorBgColor='FFFFFF'>
	<set value='' />
	<?
    echo $scrip_3;
	?>
	  <set value='' /> 
      
</dataset>





</graph>
