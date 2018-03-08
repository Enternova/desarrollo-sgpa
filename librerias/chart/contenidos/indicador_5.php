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
	/** PARA EL DES002-18 **/
	$ano=$_SESSION["ses_ano"];
	$actividados_no_muesstra="";
	if($ano>=2017){
		$count_ano=traer_fila_row(query_db("SELECT COUNT(*) FROM v_pecc_estado_actividad_v2 WHERE ano=".$ano));
		if($count_ano[0]==0){
			$ano=traer_fila_row(query_db("SELECT MAX(ano) FROM v_pecc_estado_actividad_v2"));
			$actividados_no_muesstra.=" and t1.ano=".$ano[0];
		}else{
			$actividados_no_muesstra.=" and t1.ano=".$ano;
		}
		$vpeec_aplica="v_pecc_estado_actividad_v2";
	}else{
		$vpeec_aplica=$vpeec3;
	}
	/** PARA EL DES002-18 **/
$sel_actividades = query_db("select sum(t1.tiempo), sum(t1.dias_reales),count(*), t1.encargado, t1.t2_nivel_servicio_encargado_id from ".$vpeec_aplica." as t1, $vin_0 as t2 where t1.id_item = t2.id_item and t1.id_pecc <> 1 and t1.dias_reales is not null $comple_ano_sql ".$_SESSION["comple_filtro"]." ".$actividados_no_muesstra." group by t1.encargado,t1.t2_nivel_servicio_encargado_id order by t1.t2_nivel_servicio_encargado_id asc");
$cuantos = 0;
while($sel_activi = traer_fila_db($sel_actividades)){
	$actividad = $sel_activi[3];	
	if($sel_activi[4] == 4){
		$actividad ="Comite";
		}
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
