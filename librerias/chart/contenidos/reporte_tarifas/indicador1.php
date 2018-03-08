<? include("../../../lib/@session.php"); 
	



$sql="select t1_area_id, area from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]."  group by t1_area_id, area order by area";

$categorias ="";
$barra1="";
$barra2="";

$selec_t_pro = query_db($sql);
while($sel_pro = traer_fila_db($selec_t_pro)){
	$categorias.="<category name='".$sel_pro[1]."' hoverText='cat2'/>";
	
	$sql_barra_1 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]." and  t1_area_id = ".$sel_pro[0]." and t6_tarifas_estados_contratos_id <> 6"));
	//$barra1.="<set value='".($sql_barra_1[0])."' link='F-grafica_detalle_area-variacion_tarifas_detalle_area.php?id_area=".$sel_pro[0]."'/>";
	$barra1.="<set value='".($sql_barra_1[0])."' link='JavaScript:carga_grafica_detalle_area(".$sel_pro[0].")'/>";
	
	$sql_barra_2 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas where t1_area_id = ".$sel_pro[0]." and t6_tarifas_estados_contratos_id = 6"));
	$barra2.="<set value='".($sql_barra_2[0])."' link='JavaScript:contratos_exepcion_graf(".$sel_pro[0].")' />";
}




?>

<graph xaxisname='' yaxisname='' hovercapbg='FFFFFF' hovercapborder='000000' rotateNames='1' yAxisMaxValue='0' numdivlines='10' divLineColor='999999' divLineAlpha='10' decimalPrecision='0' showAlternateHGridColor='1' AlternateHGridAlpha='10' AlternateHGridColor='FFFFFF' caption='' subcaption='' >
   <categories font='Roboto' fontSize='12' fontColor='000000'>
    
     <? echo $categorias;?>
	 
   </categories>
   <dataset seriesname='Contratos Sin Excepción' color='99C754' >
     
      <? echo $barra1?>
      
   </dataset>
    <dataset seriesname='Contratos Excepcin' color='54C7C5'>
     
      <? echo $barra2?>>
     
   </dataset>
    
</graph>

