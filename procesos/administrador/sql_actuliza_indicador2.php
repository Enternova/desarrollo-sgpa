<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

//$desde_cuando = " id_item >= 5040";//primer id item del 2015
$desde_cuando = " id_item >= 5906";//primer id item del 2016
//$desde_cuando = " id_item >= 9000";//primer id item del 2017
//$desde_cuando = " (id_item IN (11802))";//item especificos
	
/*----------------------------------------------- tiempos congelados ----------------------------------------*/

$sel_item_ini = query_db("select id_item, num3, estado, fecha_en_firme from t2_item_pecc where estado <> 33 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and $desde_cuando order by id_item ");
//Este es para actualizar todos los procesos desde el 2103



while($sel_it = traer_fila_db($sel_item_ini)){
	$id_item_pecc = $sel_it[0];
	$fecha_creacion=$sel_it[3];
	$fecha_creacion=explode('-',$fecha_creacion);
	if($fecha_creacion[0]>=2017){
		$count_ano=traer_fila_row(query_db("SELECT COUNT(*) FROM v_pecc_estado_actividad_v2 WHERE ano=".$fecha_creacion[0]));
		if($count_ano[0]==0){
			$ano=traer_fila_row(query_db("SELECT MAX(ano) FROM v_pecc_estado_actividad_v2"));
			$comple_sql.=" and ano=".$ano[0];
		}else{
			$comple_sql.=" and ano=".$fecha_creacion[0];
		}
		$vpeec_aplica="v_pecc_estado_actividad_v2";
	}else{
		$vpeec_aplica=$vpeec3;
	}
	
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
		  $selec_tiempo_proceso = traer_fila_row(query_db("select sum(tiempo),fecha_se_requiere from $vpeec_aplica where id_item =".$id_item_pecc."".$comple_sql." group by fecha_se_requiere"));
	$tiempo_proceso=number_format($selec_tiempo_proceso[0],0);
	$fecha_requiere = $selec_tiempo_proceso[1];
	$fecha_empiesa = restar_fechas($fecha_requiere, $tiempo_proceso);
	

	 	  $sel_actividades_resumen = query_db("select actividad_estado,tiempo,fecha_se_requiere,fecha_real,tiempo_para_actividad,actividad_estado_id,dias_reales, estado,encargado, t2_gestion from $vpeec_aplica where id_item =".$id_item_pecc."  ".$comple_sql." and actividad_estado_id <= 20 order by actividad_estado_id");
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
			//  $update_congelado = query_db("update t2_nivel_servicio_gestiones set dias = ".$dias." where id_item = ".$id_item_pecc." and t2_gestion=".$ac_resum[9]);//este fue para actualizar a los nuevos campos.
		  }
		 
		  if($dias_congelado >0){
			   
			  if($dias_congelado >$dias_reales){
				  $dias_congelado = $dias_reales;
				  
			  }

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
        <td align="center"><?=$numero_acti;?></td>
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
    <?

/*----------------------------------------------- FIN tiempos congelados ----------------------------------------*/


/* Atiempo retrazado TODO*/
$dele = query_db("delete from t2_finalizacion_item_pecc where ".$desde_cuando);
$fecha_hoy = date("Y-m-d");
$sel_item = query_db("select id_item, num3, estado, fecha_fin_reprogramada, fecha_ultima_gestion, fecha_en_firme from t2_item_pecc where estado <> 33 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and ".$desde_cuando." order by id_item ");



while($sel_it = traer_fila_row($sel_item)){
	
	
	  
	  
	$id_item_pecc = $sel_it[0];
	$fecha_creacion=$sel_it[5];
	$fecha_creacion=explode('-',$fecha_creacion);
	if($fecha_creacion[0]>=2017){
		$count_ano=traer_fila_row(query_db("SELECT COUNT(*) FROM v_pecc_estado_actividad_v2 WHERE ano=".$fecha_creacion[0]));
		if($count_ano[0]==0){
			$ano=traer_fila_row(query_db("SELECT MAX(ano) FROM v_pecc_estado_actividad_v2"));
			$comple_sql.=" and ano=".$ano[0];
		}else{
			$comple_sql.=" and ano=".$fecha_creacion[0];
		}
		$vpeec_aplica="v_pecc_estado_actividad_v2";
	}else{
		$vpeec_aplica=$vpeec3;
	}
	$fecha_ultima_gestion="";
	$fecha_reprograma="";
	$sql_query = "select sum(tiempo), sum(dias_reales), sum(dias_congelado) from $vpeec_aplica where id_item =".$id_item_pecc." and actividad_estado_id NOT IN (12.1, 19) and   aplica_item = 1";
	
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
		  
	 //$insert = query_db("insert into t2_finalizacion_item_pecc (id_item, fecha_reprograma_fin, fecha_finalizacion, estado_atrazado_atiempo) values ($id_item_pecc, '$fecha_reprograma','".$sel_ultima_gestion[0]."','$estado_at')");
	 $fecha_ultima_gestion = $sel_it[4];
	 if($sel_it[2]>=20){
		 $fecha_ultima_gestion = "";
		 }
	  $insert = query_db("insert into t2_finalizacion_item_pecc (id_item, fecha_reprograma_fin, fecha_finalizacion, estado_atrazado_atiempo) values ($id_item_pecc, '".$sel_it[3]."','".$fecha_ultima_gestion."','$estado_at')");

}

/* Atiempo retrazado TODO*/

/* a Tiempo retrazado SOLO ABASTECIMIENTO*/
echo "SOLO ABASTECIMIENTO";
/* Este es para actualizar todos los procesos desde el 2016*/
$dele = query_db("delete from t2_finalizacion_item_pecc_solo_abastecimiento  where ".$desde_cuando);
$fecha_hoy = date("Y-m-d");
$ult_act_aba = 14;



$sel_item = query_db("select id_item, num3, estado, fecha_en_firme from t2_item_pecc where estado <> 33 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and ".$desde_cuando." order by id_item ");
/*Este es para actualizar todos los procesos desde el 2103*/



while($sel_it = traer_fila_row($sel_item)){
	$id_item_pecc = $sel_it[0];
	$fecha_creacion=$sel_it[3];
	$fecha_creacion=explode('-',$fecha_creacion);
	if($fecha_creacion[0]>=2017){
		$count_ano=traer_fila_row(query_db("SELECT COUNT(*) FROM v_pecc_estado_actividad_v2 WHERE ano=".$fecha_creacion[0]));
		if($count_ano[0]==0){
			$ano=traer_fila_row(query_db("SELECT MAX(ano) FROM v_pecc_estado_actividad_v2"));
			$comple_sql.=" and ano=".$ano[0];
		}else{
			$comple_sql.=" and ano=".$fecha_creacion[0];
		}
		$vpeec_aplica="v_pecc_estado_actividad_v2";
	}else{
		$vpeec_aplica=$vpeec3;
	}
	$fecha_reprograma="";
	$sql_query = "select sum(tiempo), sum(dias_reales), sum(dias_congelado) from $vpeec_aplica where id_item =".$id_item_pecc." and actividad_estado_id IN (4,5,6,11,12,13,14) and   aplica_item = 1";
	
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
/*FIN SOLO ABASTECIMIENTO*/


/*****************-----------------------------Actualiza niveles de aprobacion ----------------------------------*/
$delete_aprobaciones = query_db("delete from t2_nivel_aprobacion_relacion where ".$desde_cuando);
$sql = "select id_item, num3 from t2_item_pecc where ".$desde_cuando." and (estado <> 31 and estado <> 33) and estado >= 7 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and t1_tipo_proceso_id > 0 and id_us_profesional_asignado > 0";

//Este es para actualizar los procesos desde el 2016

$sel_solicitudes = query_db($sql);
$conte=1;
while($sel_soli = traer_fila_db($sel_solicitudes)){

$nivel_perm = "";
$usuario_perm = "";
$fecha_perm = "";
$nivel_ad = "";
$usuario_ad = "";
$fecha_ad = "";
	
$aprobacion_nivel =  nivel_aprobacion_sol($sel_soli[0], "");

$explo_aprobacion = explode("*",$aprobacion_nivel);

$nivel_perm = $explo_aprobacion[0];
$usuario_perm = $explo_aprobacion[1];
$fecha_perm = $explo_aprobacion[2];

$nivel_ad = $explo_aprobacion[3];
$usuario_ad = $explo_aprobacion[4];
$fecha_ad = $explo_aprobacion[5];

//echo $conte." : ".$sel_soli[1]." - PERMISO nivel: $nivel_perm, usuario: $usuario_perm, fecha: $fecha_perm ADJUDICACION nivel: $nivel_ad, usuario: $usuario_ad, fecha: $fecha_ad";

if($nivel_perm <> "" or $usuario_perm<>"" or $fecha_perm<>""){
	//echo " ********crea Permiso";	
$conte=$conte+1;
	$insert_atecedente = query_db("insert into t2_nivel_aprobacion_relacion (id_item, id_nivel_aprobacion_permiso, fecha_aprobacion_permiso, id_usuario_aprueba_permiso) values (".$sel_soli[0].",'$nivel_perm','$fecha_perm','$usuario_perm')");

	}
if($nivel_ad <> "" or $usuario_ad<>"" or $fecha_ad<>""){
	//echo "********crea Adjudicacion";
	$conte=$conte+1;
	$insert_atecedente = query_db("insert into t2_nivel_aprobacion_relacion (id_item, id_nivel_aprobacion_adjudicacion, fecha_aprobacion_adjudicacion, id_usuario_aprueba_adjudicacion) values (".$sel_soli[0].",'$nivel_ad','$fecha_ad','$usuario_ad')");	
	}
	

//echo "<br />";
}


	

function nivel_aprobacion_sol($id_item_pecc, $ad_permiso){
	global $g1;
	$sel_repor = query_db("select * from reporte_general_1 where id_item = $id_item_pecc $comple_sql");
  while($sel_r = traer_fila_db($sel_repor)){

		$tipo_proceso_while=$sel_r[22];
		$id_item_while = $sel_r[0];
		$estado_item_while = $sel_r[20];
		
		
	
		
		$nivel_aprueba_ad = "";
		$usuario_aprueba_ad="";
		$fecha_aprueba_ad="";
		
		$nivel_aprueba_perm="";
		$usuario_aprueba_perm="";
		$fecha_aprueba_perm="";
		
		if($estado_item_while > 18 and $estado_item_while <> 31){// aprobacion adjudicacion
		
		
		
		
		if($nivel_aprueba_ad == ""){			
		$sel_aprobacion_permiso_comite = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.observacion, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 10"));  
			if($sel_aprobacion_permiso_comite[0]!= ""){
			$nivel_aprueba_ad = 4;
			$usuario_aprueba_ad=$cadena = substr($sel_aprobacion_permiso_comite[0],35,43);
			$fecha_aprueba_ad = $sel_aprobacion_permiso_comite[1];		
			}
		}
		
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_presidente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 48"));  
			if($sel_aprobacion_permiso_presidente[0]>0){
			$nivel_aprueba_ad = 8;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_presidente[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_presidente[1];	
			}			
		}
		
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 43"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = 6;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 20"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = 3;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_jefe_area = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 9"));  
			if($sel_aprobacion_permiso_jefe_area[0]>0){
			$nivel_aprueba_ad = 2;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_jefe_area[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_jefe_area[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 45"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_ad = 7;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_superintendente[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 35"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_ad = 7;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_superintendente[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		
	}//FIN APROBACION DE adjudicacion
	
	if($estado_item_while > 7 and $estado_item_while <> 31 and ($tipo_proceso_while == 1 or $tipo_proceso_while == 2 or $tipo_proceso_while == 3)){// aprobacion permiso
		
		if($nivel_aprueba_perm == ""){
			
		$sel_aprobacion_permiso_comite = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.observacion, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 10"));  
			if($sel_aprobacion_permiso_comite[0]!= ""){
			$nivel_aprueba_perm = 4;
			$usuario_aprueba_perm=$cadena = substr($sel_aprobacion_permiso_comite[0],35,43);
			$fecha_aprueba_perm = $sel_aprobacion_permiso_comite[1];		
			}
		}
		
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 48"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_perm = 8;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 43"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_perm = 6;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		
		
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 20"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_perm = 3;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_jefe_area = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 9"));  
			if($sel_aprobacion_permiso_jefe_area[0]>0){
			$nivel_aprueba_perm = 2;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_jefe_area[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_jefe_area[1];	
			}
			
		}
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 45"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_perm = 1;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_superintendente[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 35"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_perm = 1;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_superintendente[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		
	}//FIN APROBACION DE permiso
	
  }//fin while
  

  
  	$aprobaciones_adjudicacion = $nivel_aprueba_ad."*".$usuario_aprueba_ad."*".$fecha_aprueba_ad;
	$aprobaciones_permiso = $nivel_aprueba_perm."*".$usuario_aprueba_perm."*".$fecha_aprueba_perm;

		return $aprobaciones_permiso."*".$aprobaciones_adjudicacion;	
	  
	}
	
	/*ACTUALIZACION DE ANTECEDENTES NIVELES DE APROBACION*/	


/*****************-----------------------------FIN Actualiza niveles de aprobacion ----------------------------------*/
?><script>
function CloseWin(){
//window.open('','_parent','');
//window.close(); 
}
//CloseWin()
</script>