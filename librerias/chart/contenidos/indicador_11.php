<? include("../../lib/@session.php"); 
	

?>

<graph caption='' subcaption='' hovercapbg='' hovercapborder='cccccc' formatNumberScale='0' decimalPrecision='0' showvalues='0' numdivlines='5' numVdivlines='0' yaxisminvalue='0' yaxismaxvalue=''  rotateNames='1' yAxisName='Numero de Dias' xAxisName='Encargados' baseFontSize="10">
<categories >
		<category name='' />
        <?

//$sel_actividades = query_db("select sum(t1.tiempo), sum(t1.dias_reales),count(*), t1.actividad_estado,t1. actividad_estado_id from $vpeec3 as t1, $vin_0 as t2 where t1.id_item = t2.id_item and t1.id_pecc = 1 and t1.dias_reales is not null $comple_ano_sql ".$_SESSION["comple_filtro"]." group by t1.actividad_estado,t1.actividad_estado_id order by t1.actividad_estado_id asc");
	/** PARA EL DES002-18 **/
	$ano=$_SESSION["ses_ano"];
	$actividados_no_muesstra="";
	if($ano>=2017){
		$count_ano=traer_fila_row(query_db("SELECT COUNT(*) FROM version_2_indi_soporte_3_v2 WHERE ano=".$ano));
		if($count_ano[0]==0){
			$ano=traer_fila_row(query_db("SELECT MAX(ano) FROM version_2_indi_soporte_3_v2"));
			$actividados_no_muesstra.=" and ano=".$ano[0];
		}else{
			$actividados_no_muesstra.=" and ano=".$ano;
		}
		$vpeec_aplica="version_2_indi_soporte_3_v2";
	}else{
		$vpeec_aplica="version_2_indi_soporte_3";
	}
	/** PARA EL DES002-18 **/
	$sel_actividades = query_db("select sum(tiempo), sum(dias_realas)-sum(dias_congelados),count(*), nombre,t2_nivel_servicio_actividad_id from ".$vpeec_aplica." ".$_SESSION["comple_filtro4"]." ".$actividados_no_muesstra." and dias_realas <> '100000' and t2_nivel_servicio_actividad_id IN (4,5,6,11,12,13,14)  group by  nombre,t2_nivel_servicio_actividad_id order by t2_nivel_servicio_actividad_id asc");
	
$cuantos = 0;
while($sel_activi = traer_fila_db($sel_actividades)){
	$actividad = $sel_activi[3];	
if($sel_activi[1] < 0){ $sel_activi[1] =0;}
	echo "<category name='".$actividad."' />";
	
	$scrip_1.= "<set value='".($sel_activi[0]/$sel_activi[2])."' />";//Estimados
	$scrip_3.= "<set value='".($sel_activi[1]/$sel_activi[2])."' />";//reales
	
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
