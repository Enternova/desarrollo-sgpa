<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

/* Este es para actualizar todos los procesos desde el 2103
$dele = query_db("truncate table t2_finalizacion_item_pecc_solo_abastecimiento");
$fecha_hoy = date("Y-m-d");
$ult_act_aba = 14;
$sel_item = query_db("select id_item, num3, estado from t2_item_pecc where estado <> 33 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) order by id_item ");
*/

/* Este es para actualizar todos los procesos desde el 2016
$desde_cuando = 5906;//primer id item del 2016
$dele = query_db("delete from t2_finalizacion_item_pecc_solo_abastecimiento  where id_item >=".$desde_cuando);
$fecha_hoy = date("Y-m-d");
$ult_act_aba = 14;



$sel_item = query_db("select id_item, num3, estado from t2_item_pecc where estado <> 33 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and id_item >= ".$desde_cuando." order by id_item ");




while($sel_it = traer_fila_row($sel_item)){
	$id_item_pecc = $sel_it[0];
	
	$fecha_reprograma="";
	//$sql_query = "select actividad_estado,tiempo,fecha_se_requiere,fecha_real,tiempo_para_actividad,actividad_estado_id,dias_reales, estado from $vpeec3 where id_item =".$id_item_pecc." and actividad_estado_id IN (4,5,6, 11,12,13,14) and   aplica_item = 1 order by actividad_estado_id";
	$sql_query = "select sum(tiempo), sum(dias_reales), sum(dias_congelado) from $vpeec3 where id_item =".$id_item_pecc." and actividad_estado_id IN (4,5,6,11,12,13,14) and   aplica_item = 1";
	
$sel_actividades_resumen = query_db($sql_query);

$dias_estimados=0;
$dias_reales=0;
	$primera_actividad = 0;
	$dias_congelado=0;
      while($ac_resum = traer_fila_db($sel_actividades_resumen)){
			$dias_congelado=$ac_resum[2]+0;
			$dias_estimados=$ac_resum[0];
		  
			$dias_reales=$ac_resum[1]-$dias_congelado;
		  if($dias_reales<0){
			  
			  $dias_reales=0;
		  }
					

      }
	  $estado_at="";
	  $sel_ultima_gestion="";
	  
	  
	   if($dias_estimados >= $dias_reales){ $estado_at = "A tiempo";}
		if($dias_estimados <$dias_reales){ $estado_at = "Atrasado";}	
		  
	  
	  $insert = query_db("insert into t2_finalizacion_item_pecc_solo_abastecimiento (id_item, fecha_reprograma_fin, fecha_finalizacion, estado_atrazado_atiempo_solo_abastecimiento) values ($id_item_pecc, '','','$estado_at')");
}
?><script>
function CloseWin(){
window.open('','_parent','');
window.close(); 
}
CloseWin()
</script>
<?
*/
?>