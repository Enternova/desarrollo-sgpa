<? include("../../lib/@session.php"); 
	

?>

<graph caption='' subcaption='' hovercapbg='' hovercapborder='cccccc' formatNumberScale='0' decimalPrecision='0' showvalues='0' numdivlines='5' numVdivlines='0' yaxisminvalue='0' yaxismaxvalue=''  rotateNames='1' yAxisName='Numero de Dias' xAxisName='Encargados' baseFontSize="10">
<categories >
		<category name='' />
        <?
	$ano_rq = $_SESSION["ses_ano"];
	if($_SESSION["mes_requiere"] <> 0){
			$ano_rq= $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere"];
			}
		
		$comple_ano_sql =" and t2.fecha_se_requiere like '%".$ano_rq."%'";
		
$sel_actividades = query_db("select t2_nivel_servicio_actividad_id, nombre from t2_nivel_servicio_actividades where t2_nivel_servicio_actividad_id not in (2,3,4,5) order by t2_nivel_servicio_actividad_id");
$cuantos = 0;
while($sel_activi = traer_fila_db($sel_actividades)){
	$actividad = $sel_activi[1];	
	
	echo "<category name='".$actividad."' />";
	
	if($sel_activi[0] == 1){
			$scrip_1.= "<set value='0' />";//Estimados
			$scrip_3.= "<set value='0' />";//reales
		}
	
	if($sel_activi[0] == 6){
			$scrip_1.= "<set value='2' />";//Estimados
			$scrip_3.= "<set value='0' />";//reales
		}
	if($sel_activi[0] == 7){
			$scrip_1.= "<set value='1' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 8){
			$scrip_1.= "<set value='7' />";//Estimados
			$scrip_3.= "<set value='9' />";//reales
		}
	if($sel_activi[0] == 9){
			$scrip_1.= "<set value='10' />";//Estimados
			$scrip_3.= "<set value='13' />";//reales
		}
	if($sel_activi[0] == 10){
			$scrip_1.= "<set value='10' />";//Estimados
			$scrip_3.= "<set value='11' />";//reales
		}
	if($sel_activi[0] == 11){
			$scrip_1.= "<set value='2' />";//Estimados
			$scrip_3.= "<set value='0' />";//reales
		}
	if($sel_activi[0] == 12){
			$scrip_1.= "<set value='2' />";//Estimados
			$scrip_3.= "<set value='0' />";//reales
		}
	if($sel_activi[0] == 13){
			$scrip_1.= "<set value='15' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 14){
			$scrip_1.= "<set value='2' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 15){
			$scrip_1.= "<set value='1' />";//Estimados
			$scrip_3.= "<set value='6' />";//reales
		}
	if($sel_activi[0] == 16){
			$scrip_1.= "<set value='1' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 17){
			$scrip_1.= "<set value='7' />";//Estimados
			$scrip_3.= "<set value='7' />";//reales
		}
	if($sel_activi[0] == 18){
			$scrip_1.= "<set value='10' />";//Estimados
			$scrip_3.= "<set value='9' />";//reales
		}
	if($sel_activi[0] == 19){
			$scrip_1.= "<set value='0' />";//Estimados
			$scrip_3.= "<set value='0' />";//reales
		}
	if($sel_activi[0] == 20){
			$scrip_1.= "<set value='5' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 21){
			$scrip_1.= "<set value='0' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 22){
			$scrip_1.= "<set value='2' />";//Estimados
			$scrip_3.= "<set value='6' />";//reales
		}
	if($sel_activi[0] == 23){
			$scrip_1.= "<set value='3' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 24){
			$scrip_1.= "<set value='3' />";//Estimados
			$scrip_3.= "<set value='6' />";//reales
		}
	if($sel_activi[0] == 25){
			$scrip_1.= "<set value='5' />";//Estimados
			$scrip_3.= "<set value='11' />";//reales
		}
	if($sel_activi[0] == 26){
			$scrip_1.= "<set value='1' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
		}
	if($sel_activi[0] == 27){
			$scrip_1.= "<set value='1' />";//Estimados
			$scrip_3.= "<set value='4' />";//reales
		}
	if($sel_activi[0] == 28){
			$scrip_1.= "<set value='0' />";//Estimados
			$scrip_3.= "<set value='0' />";//reales
		}
	if($sel_activi[0] == 29){
			$scrip_1.= "<set value='5' />";//Estimados
			$scrip_3.= "<set value='3' />";//reales
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
