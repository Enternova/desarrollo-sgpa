<?
include("../../librerias/lib/@include.php");
include("../../librerias/php/desempeno/correos_solicitud_todos.php");
$mes1= date('Y-m-d', strtotime('2018-01-01'));
$mes3= date('Y-m-d', strtotime ( '+6 month' ,strtotime($mes1)));
$mes2= date('Y-m-d', strtotime ( '-1 day' ,strtotime($mes3)));
$mes4= date('Y-m-d', strtotime ( '+6 month' ,strtotime($mes3)));
$mes4= date('Y-m-d', strtotime ( '-1 day' ,strtotime($mes4)));
$hoy=date('Y-m-d');
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
/*** TAREA PARA LAS EVALUACIONES TÉCNICAS CONTRATOS PUNTUALES ***/
$contrato_puntual=query_db("select id, fecha_inicio, vigencia_mes, estado, t1_tipo_documento_id, gerente, contratista, tipo_servicio from  t7_contratos_contrato where t1_tipo_documento_id=1 and estado=48 and tipo_servicio in (1,2) and convert(DATE, vigencia_mes)>='".$hoy."'");
while($lt=traer_fila_db($contrato_puntual)){
	$tota_existentes=traer_fila_row(query_db("select count(*) from vista_t9_contrato_puntual where id_documento=".$lt[0]));
	$fecha_inicio_contrato= date('Y-m-d', strtotime($lt[1]));
	$id_jefe=busca_jefe_area_contrato_id_contrato_mc($lt[0]);//PARA OBTENER EL JEFE QUE APRUEBA LA EVALUACIÓN
	if($tota_existentes[0]==0){//NO HAY NI LA PRIMERA EVALUACIÓN
		if($fecha_inicio_contrato<=$hoy){
			$ano=explode('-',$hoy);
			$num2=substr($ano[0], 2, 3);
			$num3=traer_fila_row(query_db("select num3 from t9_criterios_evaluacion"));
			$num3[0]=$num3[0]+1;
			$ano_anterior=explode('-',$fecha_inicio_contrato);
			$inserta_evaluacion="insert t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) values(".$lt[5].", 5, 'E', '".$num2."', '".$num3[0]."', 2, '".$ano[0]."-".$ano_anterior[1]."-".$ano_anterior[2]."', NULL, ".$lt[6].", ".$lt[0].", 2, ".$lt[5].", ".$id_jefe.")";
			$id=query_db($inserta_evaluacion.$trae_id_insrte);
			$id_insertado = id_insert($id);
			
				echo $id_insertado."<br>";
			if($id_insertado>0){
				$query_aspectos="INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, ".$id_insertado.", NULL from t9_aspectos_criterio where id_criterio=2 AND tipo_servicio=".$lt[7]." and estado=1";
				$id2=query_db($query_aspectos.$trae_id_insrte);
				$id_insertado2 = id_insert($id2);
				if($id_insertado2>0){
					solicitud_evaluacion_puntual($id_insertado);
				}
				
			}
		}
		
	}
}
/*** FIN TAREA PARA LAS EVALUACIONES TÉCNICAS CONTRATOS PUNTUALES ***/
/*** TAREA PARA LAS EVALUACIONES TÉCNICAS CONTRATOS MARCO ***/
$contrato_puntual=query_db("select id, fecha_inicio, vigencia_mes, estado, t1_tipo_documento_id, gerente, contratista, tipo_servicio from  t7_contratos_contrato where t1_tipo_documento_id=2 and estado=48 and tipo_servicio in (1,2) and convert(DATE, vigencia_mes)>='".$hoy."'");
while($lt=traer_fila_db($contrato_puntual)){
	$tota_existentes=traer_fila_row(query_db("select count(*) from vista_t9_contrato_marco where id_documento=".$lt[0]));
	$fecha_inicio_contrato= date('Y-m-d', strtotime($lt[1]));
	$id_jefe=busca_jefe_area_contrato_id_contrato_mc($lt[0]);//PARA OBTENER EL JEFE QUE APRUEBA LA EVALUACIÓN
	if($tota_existentes[0]==0){//NO HAY NI LA PRIMERA EVALUACIÓN
		if($fecha_inicio_contrato<=$hoy){
			$ano=explode('-',$hoy);
			$num2=substr($ano[0], 2, 3);
			$num3=traer_fila_row(query_db("select num3 from t9_criterios_evaluacion"));
			$num3[0]=$num3[0]+1;
			$ano_anterior=explode('-',$fecha_inicio_contrato);
			$inserta_evaluacion="insert t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) values(".$lt[5].", 5, 'E', '".$num2."', '".$num3[0]."', 3, '".$ano[0]."-".$ano_anterior[1]."-".$ano_anterior[2]."', NULL, ".$lt[6].", ".$lt[0].", 2, ".$lt[5].", ".$id_jefe.")";
			$id=query_db($inserta_evaluacion.$trae_id_insrte);
			$id_insertado = id_insert($id);
			
				echo $id_insertado."<br>";
			if($id_insertado>0){
				$query_aspectos="INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, ".$id_insertado.", NULL from t9_aspectos_criterio where id_criterio=2 AND tipo_servicio=".$lt[7]." and estado=1";
				$id2=query_db($query_aspectos.$trae_id_insrte);
				$id_insertado2 = id_insert($id2);
				if($id_insertado2>0){
					solicitud_evaluacion_puntual($id_insertado);
				}
				
			}
		}
		
	}
}
/*** FIN TAREA PARA LAS EVALUACIONES TÉCNICAS CONTRATOS MARCO ***/
?>