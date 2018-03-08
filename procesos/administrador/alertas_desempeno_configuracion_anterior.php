<? 
    error_reporting(E_ALL);  // Líneas para mostart errores
	ini_set('display_errors', '1');  // Líneas para mostart errores
	include("../../librerias/lib/@include.php");
	require_once("../../librerias/php/desempeno/correos_solicitud_todos.php");
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$vigencia=date("Y-m-d");
	$ano_actual=date("y");
	$mes_actual=date("n");
	$dia_actual=date("j");
	$un_ano_antes =strtotime ( '-1 year' , strtotime ($vigencia) );
	$un_ano_antes=date('Y-m-d', $un_ano_antes);
	$ano_cuatro_digitos=date("Y");
	$mes_dos_digitos=date("m");
	$dia_dos_digitos=date("d");
	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and fecha_inicio<'2018-01-01' order by mes, dia");
	while($ls=traer_fila_db($query)){
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and id_criterio=2 and fecha_solicitud='".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$ls[9].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 2, '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 2, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=2 and tipo_servicio=1 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=2 and tipo_servicio=2 and estado=1");
				}
				solicitud_evaluacion_puntual($id_ingreso);
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES QUE YA ESTÁN LEGALIZADOS ***/

	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and fecha_inicio<'2018-01-01' order by mes, dia");
	while($ls=traer_fila_db($query)){
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and id_criterio=3 and fecha_solicitud='".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$ls[9].", 99, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 3, '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 3, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=3 and tipo_servicio=1 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=3 and tipo_servicio=2 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO QUE YA ESTÁN LEGALIZADOS ***/
	

	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES QUE YA ESTÁN LEGALIZADOS NUEVOS ***/
	$query=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and fecha_inicio>='2018-01-01' order by mes, dia");
	while($ls=traer_fila_db($query)){
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and id_criterio=2 and fecha_solicitud='".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$ls[9].", 1, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 2, '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 2, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=2 and tipo_servicio=1 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=2 and tipo_servicio=2 and estado=1");
				}
				define_aspecto_puntual($id_ingreso);
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES QUE YA ESTÁN LEGALIZADOS NUEVOS ***/

	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO QUE YA ESTÁN LEGALIZADOS NUEVOS ***/
	$query=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49  and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and fecha_inicio>='2018-01-01' order by mes, dia");
	while($ls=traer_fila_db($query)){
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and id_criterio=3 and fecha_solicitud='".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$ls[9].", 1, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 3, '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 3, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=3 and tipo_servicio=1 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=3 and tipo_servicio=2 and estado=1");
				}
				definir_aspecto_marco($id_ingreso);
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO QUE YA ESTÁN LEGALIZADOS NUEVOS***/
	echo "SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) group by id_proveedor<br>";
	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES EVALUACIÓN HSSE QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) group by id_proveedor");
	while($lz=traer_fila_db($query)){
		echo "SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC<br><br>";
		$query5=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC");
		$ls=traer_fila_row($query5);
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_criterio=4 and  id_proveedor=".$lz[0]." and fecha_solicitud LIKE '%".($ano_cuatro_digitos-1)."%'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$evaluador=traer_fila_row(query_db("select id_usuario FROM tseg12_relacion_usuario_rol where id_rol_general =37"));
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$evaluador[0].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 4, '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 2, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=4 and tipo_servicio=0 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=4 and tipo_servicio=0 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES EVALUACIÓN HSSE QUE YA ESTÁN LEGALIZADOS ***/

	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO EVALUACIÓN HSSE QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) group by id_proveedor");
	while($lz=traer_fila_db($query)){
		$query5=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC");
		$ls=traer_fila_row($query5);
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_criterio=5 and  id_proveedor=".$lz[0]." and fecha_solicitud LIKE '%".($ano_cuatro_digitos-1)."%'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$evaluador=traer_fila_row(query_db("select id_usuario FROM tseg12_relacion_usuario_rol where id_rol_general =37"));
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$evaluador[0].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 5, '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 3, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=5 and tipo_servicio=0 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=5 and tipo_servicio=0 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO EVALUACIÓN HSSE QUE YA ESTÁN LEGALIZADOS ***/

	



	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES EVALUACIÓN ADMINISTRATIVA QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) group by id_proveedor");
	while($lz=traer_fila_db($query)){
		$query5=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC");
		$ls=traer_fila_row($query5);
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_criterio=6 and  id_proveedor=".$lz[0]." and fecha_solicitud LIKE '%".($ano_cuatro_digitos-1)."%'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$evaluador=traer_fila_row(query_db("select id_usuario FROM tseg12_relacion_usuario_rol where id_rol_general =24"));
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$evaluador[0].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 6, '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 2, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=6 and tipo_servicio=0 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=6 and tipo_servicio=0 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES EVALUACIÓN ADMINISTRATIVA QUE YA ESTÁN LEGALIZADOS ***/

	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO EVALUACIÓN ADMINISTRATIVA QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) group by id_proveedor");
	while($lz=traer_fila_db($query)){
		$query5=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC");
		$ls=traer_fila_row($query5);
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_criterio=7 and  id_proveedor=".$lz[0]." and fecha_solicitud LIKE '%".($ano_cuatro_digitos-1)."%'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$evaluador=traer_fila_row(query_db("select id_usuario FROM tseg12_relacion_usuario_rol where id_rol_general =24"));
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$evaluador[0].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 7, '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos-1)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 3, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=7 and tipo_servicio=0 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=7 and tipo_servicio=0 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO EVALUACIÓN ADMINISTRATIVA QUE YA ESTÁN LEGALIZADOS ***/

?>