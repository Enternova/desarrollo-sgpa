<? include("../../librerias/lib/@include.php");

$desde_cuando = 0;//primer id item del 2016
$sel_item_ini = query_db("select id_item, num3, estado from t2_item_pecc where estado <> 33 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and id_item >=$desde_cuando order by id_item ");
/*Este es para actualizar todos los procesos desde el 2103



while($sel_it = traer_fila_db($sel_item_ini)){


	
	$id_item_pecc = $sel_it[0];
	
	
	$comple_sql = " and aplica_item = 1";
			
	//$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	
	$tipo_para_funcion="";
	$id_para_funcion="";
	$muestra_legalizacion ="NO";

$dias_congelado = 0;
		$fecha_real_anterior="";
		echo "<br /><br />ID de solicitud: ".$sel_it[0];
	?>

<table width="100%" border="0">
      <tr class="fondo_3">
        <td width="2%" align="center">No.</td>
        <td width="62%" align="center">Actividad</td>
        <td width="4%" align="center">Dias Ideales</td>
        <td width="4%" align="center">Fecha_Ideal</td>
        <td width="8%" align="center">Fecha Reprogramada</td>
        <td width="4%" align="center">Fecha_Real</td>
        <td width="4%" align="center">Dias Reales</td>
        <td width="6%" align="center">Dias Congelado</td>
        <td width="6%" align="center">Dias Retrasados</td>
      </tr>
      <?
		  $selec_tiempo_proceso = traer_fila_row(query_db("select sum(tiempo),fecha_se_requiere from $vpeec3 where id_item =".$id_item_pecc."".$comple_sql." group by fecha_se_requiere"));
	$tiempo_proceso=number_format($selec_tiempo_proceso[0],0);
	$fecha_requiere = $selec_tiempo_proceso[1];
	$fecha_empiesa = restar_fechas($fecha_requiere, $tiempo_proceso);
	

	 	  $sel_actividades_resumen = query_db("select actividad_estado,tiempo,fecha_se_requiere,fecha_real,tiempo_para_actividad,actividad_estado_id,dias_reales, estado,encargado, t2_gestion from $vpeec3 where id_item =".$id_item_pecc."  ".$comple_sql." and actividad_estado_id <= 20 order by actividad_estado_id");
	$cont = 0;
  	$clase="";
  	$numero_acti = 1;
	$dias_ideales_total =0;
	$primera_actividad = 0;
      while($ac_resum = traer_fila_db($sel_actividades_resumen)){
		  $dias_reales =$ac_resum[6];
		  
		  if($fecha_reprograma != ""){
					$fecha_reprograma = sumar_fechas($fecha_reprograma, $ac_resum[1]);
					}

		  if($primera_actividad == 0){
			  	$primera_actividad = $ac_resum[5];
				$fecha_ideal = $fecha_empiesa;
				if($ac_resum[3] != ""){
					$dias_reales =0;
					$fecha_reprograma = $ac_resum[3];
				}
			  }else{
				 $fecha_ideal = restar_fechas($ac_resum[2], $ac_resum[4]);
				  }
		  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  $dias_ideales_total = $dias_ideales_total + $ac_resum[1];
		  
		  if($ac_resum[3] <= $fecha_ideal){
				$clase_real ="titulo_calendario_real_bien";
				}else{
					$clase_real ="titulo_calendario_real_mal";
					}
		 if($dias_reales <= $ac_resum[1]){
				$clase_real_dias ="titulo_calendario_real_bien";
				}else{
					$clase_real_dias ="titulo_calendario_real_mal";
					}
		  
		  //congelado
		   $sel_congelado = "SELECT min(fecha) FROM           t2_acciones_admin WHERE (id_item = ".$id_item_pecc." and fecha >= '".$fecha_real_anterior."' and fecha <= '".$ac_resum[3]."' and detalle ='5. Cambiar el Estado del Proceso' and accion = 'Congelado')";
		   
			$sel_reactiva = "SELECT Max(fecha) FROM           t2_acciones_admin WHERE (id_item = ".$id_item_pecc." and fecha >= '".$fecha_real_anterior."' and fecha <= '".$ac_resum[3]."' and detalle ='5. Cambiar el Estado del Proceso' and accion = 'Activo')";
			
			
			
				
				
		$fecha_congelado = traer_fila_row(query_db($sel_congelado));	
		$fecha_reactivo = traer_fila_row(query_db($sel_reactiva));
		
		if($fecha_congelado[0]!="" and $fecha_reactivo[0]!="" and $fecha_congelado[0] <$fecha_reactivo[0]){
		$dias_congelado = dias_habiles_entre_fechas($fecha_congelado[0],$fecha_reactivo[0]);
		}else{
			$dias_congelado = 0;
		}
		  
		  
		  if($ac_resum[3] !="" and $ac_resum[3] != " "){
			  if($fecha_real_anterior==""){//si es la primera gestion
				$dias=0;  
				  }else{
			  $dias = dias_habiles_entre_fechas($fecha_real_anterior,$ac_resum[3]);
				  }
			//  $update_congelado = query_db("update t2_nivel_servicio_gestiones set dias = ".$dias." where id_item = ".$id_item_pecc." and t2_gestion=".$ac_resum[9]);
		  }
		  
		  if($dias_congelado >0){
			  $update_congelado = query_db("update t2_nivel_servicio_gestiones set dias_congelado = ".$dias_congelado." where id_item = ".$id_item_pecc." and t2_gestion=".$ac_resum[9]);
		  }
					
				
	if ($ac_resum[7] <> 2){
		  $dias_retrazados="";
		  
		  $resta_dias_retraza=$dias_reales-$ac_resum[1]-$dias_congelado;
		  
		  if($resta_dias_retraza>0){
			  $dias_retrazados=$resta_dias_retraza;
			  }
		  
	  ?>
      <tr class="<?=$clase?>">
        <td align="center"><?=$numero_acti;?> </td>
        <td><?=$ac_resum[0].", <strong>Encargado:</strong> <strong  style='font-size:10px'><font color='#005395'>".$ac_resum[8]."</font></strong>"?></td>
        <td align="center" class=""><?=number_format($ac_resum[1],0)?></td>
        <td align="center"><?=$fecha_ideal?></td>
        <td align="center" ><strong><?=$fecha_reprograma?></strong></td>
        <td align="center" class="<?=$clase_real?>">
          <?=$ac_resum[3]?>
        </td>
        <td align="center" class="<?=$clase_real_dias?>"><?=$dias_reales?></td>
        <td align="center" class="<?=$clase_real_dias?>">
		  
       <?
		  
		
		$fecha_real_anterior=$ac_resum[3];
			?>
       </td>
        <td align="center" class="<?=$clase_real_dias?>"><?=$dias_retrazados?></td>
      </tr>
      
      <?
	  $numero_acti = $numero_acti+1;
	  
	  $tt_valor_di_re = $dias_reales + $tt_valor_di_re;
	}
	
      }
	  $update_fecha_repro = query_db("update t2_item_pecc set fecha_fin_reprogramada = '".$fecha_reprograma."', fecha_ultima_gestion='".$ac_resum[3]."' where id_item =  ".$sel_it[0]);
	  $fecha_fin_ideal = $fecha_ideal;
	  
}
	

	  ?>
      
    </table>
	
	<? */?>