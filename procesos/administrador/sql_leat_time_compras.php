<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

//$update = query_db("update tseg10_usuarios_profesional set id_us_prof_compras_corp='0', id_us_prof_compras_mro='0', id_us_prof_compras_stok='0'");


/*
$sel = query_db("select * from tseg10_usuarios_profesional");
while($se = traer_fila_db($sel)){
	
	$sel_compras = traer_fila_row(query_db("select * from eliminar_esta_tabla where id_usuario= ".$se[1]." and area = ".$se[3]));
	
	$update = query_db("update tseg10_usuarios_profesional set id_us_prof_compras_corp='".$sel_compras[3]."', id_us_prof_compras_mro='".$sel_compras[4]."', id_us_prof_compras_stok='".$sel_compras[5]."' where id_relacion = ".$se[0]);
	
	}
*/

//$del = query_db("delete from t2_nivel_servicio where t1_tipo_contratacion_id <> 1");
/*
$sel_niveles_sql = query_db("select * from t2_nivel_servicio where  t1_tipo_proceso_id in (1,2,3,6,8,9,10,11) and t1_tipo_contratacion_id = 1");	
$tipo_contratacion = 4;
while($sel_niveles = traer_fila_db($sel_niveles_sql)){
	
	$insert = "insert into t2_nivel_servicio ( t1_tipo_contratacion_id, t1_tipo_proceso_id, aprobacion_socios, aprobacion_comite, aplica_sondeo, monto_minimo, monto_maximo, estado) values ($tipo_contratacion,'".$sel_niveles[2]."','".$sel_niveles[3]."','".$sel_niveles[4]."','".$sel_niveles[5]."','".$sel_niveles[6]."','".$sel_niveles[7]."','".$sel_niveles[8]."')";
	$sql_ex=query_db($insert.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);
	
	$sel_tiempo_sql = query_db("select * from  t2_nivel_servicio_tiempos where t2_nivel_servicio_id = ".$sel_niveles[0]." and t2_nivel_servicio_actividad_id < 19");
	while($sel_tiempo = traer_fila_db($sel_tiempo_sql)){
		
		$sql ="insert into t2_nivel_servicio_tiempos (t2_nivel_servicio_id, t2_nivel_servicio_actividad_id, tiempo) values (".$id_ingreso.",".$sel_tiempo[2].",".number_format($sel_tiempo[3],0).")";
		$insert_tiempo = query_db($sql);
		
		if($sel_tiempo[2]==1 and $tipo_contratacion == 2){
			$insert_tiempo_bodega = query_db("insert into t2_nivel_servicio_tiempos (t2_nivel_servicio_id, t2_nivel_servicio_actividad_id, tiempo) values (".$id_ingreso.",2,".number_format($sel_tiempo[3],1).")");
			}
		
		
		}
	
	
	}
	

*/
	
	
//	$delete=query_db("delete from t2_agl where t1_tipo_contratacion_id in (2,3,4)");
	
	$sel_agl_sql = query_db("select * from t2_agl where (t1_tipo_contratacion_id = 1) AND (t1_tipo_proceso_id IN (1,2,3,6,8, 9, 10, 11))");
	while($sel_agl = traer_fila_db($sel_agl_sql)){
		
		$insert = "insert into t2_agl ( t1_tipo_contratacion_id, t1_tipo_proceso_id, aprobacion_socios, aprobacion_comite, monto_minimo, monto_maximo, estado,sondeo_adicional
) values (4,".$sel_agl[2].",".$sel_agl[3].",".$sel_agl[4].",".$sel_agl[5].",".$sel_agl[6].",1,".$sel_agl[8].")";
	$sql_ex=query_db($insert.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);
	
	$en_donde_poner_rol_preaprobador=0;
	
	
	$sel_secu_sql = query_db("select * from t2_agl_secuencia where  id_agl = ".$sel_agl[0]." order by orden");
	$sel_cuantos = traer_fila_row(query_db("select count(*) from t2_agl_secuencia where  id_agl = ".$sel_agl[0]." "));
	
	$en_donde_poner_rol_preaprobador = $sel_cuantos[0]+1;
	
	$orden=1;
	while($sel_sec = traer_fila_db($sel_secu_sql)){
			if($orden == 3){
				$insert_sec = query_db("insert into t2_agl_secuencia ( id_agl, id_agl_aprobadores, orden) values ($id_ingreso,7,3)");
				$orden=$orden+1;
				}
			
		/*	if($orden == $en_donde_poner_rol_preaprobador){//NO APLICA PARA CORPORATIVO
				$insert_sec = query_db("insert into t2_agl_secuencia ( id_agl, id_agl_aprobadores, orden) values ($id_ingreso,10,$orden)");
				$orden=$orden+1;
				}
			*/
			$insert_sec = query_db("insert into t2_agl_secuencia ( id_agl, id_agl_aprobadores, orden) values ($id_ingreso,".$sel_sec[2].",".$orden.")");
			
			$orden=$orden+1;
		}
	
	
		}	
		
		
		/* PARA LOS OTRO SI SOLO SERVICIOS
		$sel_agl_sql = query_db("select * from t2_agl where t1_tipo_proceso_id in (4,5)");
	while($sel_agl = traer_fila_db($sel_agl_sql)){
		
		$insert = "insert into t2_agl ( t1_tipo_contratacion_id, t1_tipo_proceso_id, aprobacion_socios, aprobacion_comite, monto_minimo, monto_maximo, estado
) values (1,".$sel_agl[2].",".$sel_agl[3].",3,".$sel_agl[5].",".$sel_agl[6].",1)";
	$sql_ex=query_db($insert.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);
	
	$sel_secu_sql = query_db("select * from t2_agl_secuencia where  id_agl = ".$sel_agl[0]);
	while($sel_sec = traer_fila_db($sel_secu_sql)){
		
			$insert_sec = query_db("insert into t2_agl_secuencia ( id_agl, id_agl_aprobadores, orden) values ($id_ingreso,".$sel_sec[2].",".$sel_sec[3].")");
		}
	
	
		}
*/		
?>

