<? 
	error_reporting(E_ALL);  // Líneas para mostart errores
ini_set('display_errors', '1');  // Líneas para mostart errores
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
	//echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=2  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=2  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas==$vigencia){
			//echo "se evalúa ".$cont."<br>";
			solicitud_evaluacion_puntual($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES QUE YA ESTÁN LEGALIZADOS ***/

	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES HSSE QUE YA ESTÁN LEGALIZADOS ***/
	//echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=4  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=4  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas==$vigencia){
			//echo "se evalúa ".$ls[0]."<br>";
			evaluacion_puntual_hsse($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES HSSE QUE YA ESTÁN LEGALIZADOS ***/
	
	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES ADMINISTRATIVO QUE YA ESTÁN LEGALIZADOS ***/
	//echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=6  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=6  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas==$vigencia){
			//echo "se evalúa ".$ls[0]."<br>";
			evaluacion_puntual_adm($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES ADMINISTRATIVO QUE YA ESTÁN LEGALIZADOS ***/
	

	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO HSSE QUE YA ESTÁN LEGALIZADOS ***/
	//echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=5  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=5  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas==$vigencia){
			//echo "se evalúa ".$ls[0]."<br>";
			evaluacion_marco_hsse($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO HSSE QUE YA ESTÁN LEGALIZADOS ***/
	
	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO ADMINISTRATIVO QUE YA ESTÁN LEGALIZADOS ***/
	//echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=7  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=7  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas==$vigencia){
			//echo "se evalúa ".$ls[0]."<br>";
			evaluacion_marco_adm($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO ADMINISTRATIVO QUE YA ESTÁN LEGALIZADOS ***/
	
	$ano_actual2_cuatro_digitos=date("Y");
	$enero=date($ano_actual2_cuatro_digitos."-01-01");
	$ano_actual2=date("y");
	$mes_actual2=date("n");
	$dia_actual2=date("j");
	$julio =strtotime ( '+6 months' , strtotime ($enero) );
	$julio=date('Y-m-d', $julio);
	$junio =strtotime ( '-1 day' , strtotime ($julio) );
	$junio=date('Y-m-d', $junio);
	$diciembre =strtotime ( '+6 months' , strtotime ($julio) );
	$diciembre=date('Y-m-d', $diciembre);
	$diciembre =strtotime ( '-1 day' , strtotime ($diciembre) );
	$diciembre=date('Y-m-d', $diciembre);
	/*** INICIO PARA BUSCAR LOS SERVICIOS MENORES QUE YA ESTÁN LEGALIZADOS ***/
	/*** DE ENERO A JUNIO ***/
	//echo "SELECT id_gerente, id_proveedor FROM vista_t9_servicio_menor_correo WHERE fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_solicitud=32 AND fecha_fin_ot between '".$enero."' and '".$junio."' group by id_gerente, id_proveedor<br><br>";
	$query=query_db("SELECT id_gerente, id_proveedor FROM vista_t9_servicio_menor_correo WHERE fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_solicitud=32 AND fecha_fin_ot between '".$enero."' and '".$junio."' group by id_gerente, id_proveedor");
	$cont=0;
	while($lz=traer_fila_db($query)){
		$query5=query_db("SELECT * FROM vista_t9_servicio_menor_correo WHERE id_gerente=".$lz[0]." AND id_proveedor=".$lz[1]." AND fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_solicitud=32 AND fecha_fin_ot between '".$enero."' and '".$junio."' order by fecha_fin_ot ASC");
		$ls=traer_fila_row($query5);
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		$jefe=busca_jefe_area_servicio_menor($ls[11], $lz[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[11]." AND id_crea_aspectos=".$lz[0]." AND id_proveedor=".$lz[1]." and id_criterio=1 and fecha_solicitud='".$junio."'"));
		if($valida[0]==0){//evita repetir registros
			if(($mes_actual==6 and $dia_actual==30) or ($mes_actual==12 and $dia_actual==31)){//verifica si cumple los 6 meses
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$lz[0].", 1, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 1, '".$junio."', '".$junio."', ".$lz[1].", ".$ls[11].", 1, ".$lz[0].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=1 and tipo_servicio=0 and estado=1");
				definir_aspecto_menor($id_ingreso);
			}
		}
		$cont++;
	}

	/*** DE JULIO A DICIEMBRE ***/
	//echo "SELECT id_gerente, id_proveedor FROM vista_t9_servicio_menor_correo WHERE fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_solicitud=32 AND fecha_fin_ot between '".$julio."' and '".$diciembre."' group by id_gerente, id_proveedor<br><br>";
	$query=query_db("SELECT id_gerente, id_proveedor FROM vista_t9_servicio_menor_correo WHERE fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_solicitud=32 AND fecha_fin_ot between '".$julio."' and '".$diciembre."' group by id_gerente, id_proveedor");
	$cont=0;
	while($lz=traer_fila_db($query)){
		$query5=query_db("SELECT * FROM vista_t9_servicio_menor_correo WHERE id_gerente=".$lz[0]." AND id_proveedor=".$lz[1]." AND fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_solicitud=32 AND fecha_fin_ot between '".$julio."' and '".$diciembre."' order by fecha_fin_ot ASC");
		$ls=traer_fila_row($query5);
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		$id_item=0;$id_solicitante=0;
		$jefe=busca_jefe_area_servicio_menor($ls[11], $lz[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[11]." AND id_crea_aspectos=".$lz[0]." AND id_proveedor=".$lz[1]." and id_criterio=1 and fecha_solicitud='".$diciembre."'"));
		if($valida[0]==0){//evita repetir registros
			if(($mes_actual==6 and $dia_actual==30) or ($mes_actual==12 and $dia_actual==31)){//verifica si cumple los 6 meses
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$lz[0].", 1, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 1, '".$diciembre."', '".$diciembre."', ".$lz[1].", ".$ls[11].", 1, ".$lz[0].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del servicio menor
				$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=1 and tipo_servicio=0 and estado=1");
				definir_aspecto_menor($id_ingreso);
			}
		}
		$cont++;
	}
	/*** INICIO PARA BUSCAR LOS SERVICIOS MENORES QUE YA ESTÁN LEGALIZADOS ***
	echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=1 and id_estado>4 and id_estado<9 and id_criterio=1  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=1 and id_estado>4 and id_estado<9 and id_criterio=1  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$fecha_inicio_seis =strtotime ( '-6 months' , strtotime ($ls[7]) );
		$fecha_inicio_seis=date('Y-m-d', $fecha_inicio_seis);
		$fecha_inicio_seis =strtotime ( '+1 day' , strtotime ($fecha_inicio_seis) );
		$fecha_inicio_seis=date('Y-m-d', $fecha_inicio_seis);
		//if($un_ano_mas<=$vigencia){
			//echo "se evalúa ".$cont."<br>";
			solicitud_evaluacion_menor($ls[0],$fecha_inicio_seis,$ls[7]);
			//solicitud_evaluacion_puntual($ls[0]);
			//$cont++;
		//}
	}
	/*** FIN PARA BUSCAR LOS SERVICIOS MENORES QUE QUE YA ESTÁN LEGALIZADOS ***/
	/*** FIN PARA BUSCAR LOS SERVICIOS MENORES QUE YA ESTÁN LEGALIZADOS ***/

	/*** INICIO PARA BUSCAR LAS ORDENES DE TRABAJO QUE YA ESTÁN LEGALIZADOS ***/
	/*** DE ENERO A JUNIO ***/
	//echo "select id_evaluacion, fecha_periodo_evaluado, id_criterio, id_documento, id_proveedor, id_crea_aspectos, tipo_servicio from vista_t9_contratos_definicion_criterios2  where t1_tipo_documento_id=2 AND id_estado_criterio=99 and vigencia_mes>='".$vigencia."' group by id_evaluacion, fecha_periodo_evaluado, id_criterio, id_documento, id_proveedor, id_crea_aspectos, tipo_servicio<br><br>";
	$query=query_db("select id_evaluacion, fecha_periodo_evaluado, id_criterio, id_documento, id_proveedor, id_crea_aspectos, tipo_servicio from vista_t9_contratos_definicion_criterios2  where t1_tipo_documento_id=2 AND id_estado_criterio=99 and vigencia_mes>='".$vigencia."' group by id_evaluacion, fecha_periodo_evaluado, id_criterio, id_documento, id_proveedor, id_crea_aspectos, tipo_servicio");
	$cont=0;
	while($lz=traer_fila_db($query)){
		//echo "<br>SELECT * FROM vista_t9_ordenes_de_trabajo_evaluacion WHERE id_gerente_contrato=".$lz[5]." AND id_proveedor=".$lz[4]." AND fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_ot>=25 AND estado_ot<49 AND fecha_fin_ot between '".$enero."' and '".$junio."' AND id_contrato=".$lz[3]." order by fecha_fin_ot ASC<br>";
		$query5=query_db("SELECT * FROM vista_t9_ordenes_de_trabajo_evaluacion WHERE id_gerente_contrato=".$lz[5]." AND id_proveedor=".$lz[4]." AND fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_ot>=25 AND estado_ot<49 AND fecha_fin_ot between '".$enero."' and '".$junio."' AND id_contrato=".$lz[3]." order by fecha_fin_ot ASC");
		$ls=traer_fila_row($query5);
		if($ls[0]>0){
			$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
			if($consecutivo_num3[0]==""){
				$consecutivo_num3[0]=1;
			}else{
				$consecutivo_num3[0]=$consecutivo_num3[0]+1;
			}
			$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
			if(($mes_actual==6 and $dia_actual==30) or ($mes_actual==12 and $dia_actual==31)){//verifica si cumple los 6 meses
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe, id_ot) VALUES(".$ls[15].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 3, '".$junio."', '".$junio."', ".$ls[12].", ".$ls[0].", 3, ".$ls[9].", ".$jefe.", ".$ls[15].")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido)  select nombre_aspectos, puntaje_maximo, nombre_descripcion, estado_cirterio, ".$id_ingreso.", NULL from vista_t9_contratos_definicion_criterios2 where id_evaluacion=".$lz[0]);
				//$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=1 and tipo_servicio=0 and estado=1");
				solicitud_evaluacion_marco($id_ingreso);
			}
		}
		$cont++;
	}

	/*** DE JULIO A DICIEMBRE ***/
	//echo "select id_evaluacion, fecha_periodo_evaluado, id_criterio, id_documento, id_proveedor, id_crea_aspectos, tipo_servicio from vista_t9_contratos_definicion_criterios2  where t1_tipo_documento_id=2 AND id_estado_criterio=99 and vigencia_mes>='".$vigencia."' group by id_evaluacion, fecha_periodo_evaluado, id_criterio, id_documento, id_proveedor, id_crea_aspectos, tipo_servicio<br><br>";
	$query=query_db("select id_evaluacion, fecha_periodo_evaluado, id_criterio, id_documento, id_proveedor, id_crea_aspectos, tipo_servicio from vista_t9_contratos_definicion_criterios2  where t1_tipo_documento_id=2 AND id_estado_criterio=99 and vigencia_mes>='".$vigencia."' group by id_evaluacion, fecha_periodo_evaluado, id_criterio, id_documento, id_proveedor, id_crea_aspectos, tipo_servicio");
	$cont=0;
	while($lz=traer_fila_db($query)){
		//echo "<br>SELECT * FROM vista_t9_ordenes_de_trabajo_evaluacion WHERE id_gerente_contrato=".$lz[5]." AND id_proveedor=".$lz[4]." AND fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_ot>=25 AND estado_ot<49 AND fecha_fin_ot between '".$enero."' and '".$junio."' AND id_contrato=".$lz[3]." order by fecha_fin_ot ASC<br>";
		$query5=query_db("SELECT * FROM vista_t9_ordenes_de_trabajo_evaluacion WHERE id_gerente_contrato=".$lz[5]." AND id_proveedor=".$lz[4]." AND fecha_inicio_ot IS NOT NULL AND fecha_fin_ot IS NOT NULL AND estado_ot>=25 AND estado_ot<49 AND fecha_fin_ot between '".$julio."' and '".$diciembre."' AND id_contrato=".$lz[3]." order by fecha_fin_ot ASC");
		$ls=traer_fila_row($query5);
		if($ls[0]>0){
			$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
			if($consecutivo_num3[0]==""){
				$consecutivo_num3[0]=1;
			}else{
				$consecutivo_num3[0]=$consecutivo_num3[0]+1;
			}
			$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
			if(($mes_actual==6 and $dia_actual==30) or ($mes_actual==12 and $dia_actual==31)){//verifica si cumple los 6 meses
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe, id_ot) VALUES(".$ls[15].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 3, '".$diciembre."', '".$diciembre."', ".$ls[12].", ".$ls[0].", 3, ".$ls[9].", ".$jefe.", ".$ls[15].")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido)  select nombre_aspectos, puntaje_maximo, nombre_descripcion, estado_cirterio, ".$id_ingreso.", NULL from vista_t9_contratos_definicion_criterios2 where id_evaluacion=".$lz[0]);
				//$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=1 and tipo_servicio=0 and estado=1");
				solicitud_evaluacion_marco($id_ingreso);
			}
		}
		$cont++;
	}
	/*** INICIO PARA BUSCAR LAS ORDENES DE TRABAJO QUE YA ESTÁN LEGALIZADOS ***
	echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=3  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=3  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas<=$vigencia){
			//echo "se evalúa ".$cont."<br>";
			//solicitud_evaluacion_puntual($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LAS ORDENES DE TRABAJO QUE QUE YA ESTÁN LEGALIZADOS ***/
	/*** FIN PARA BUSCAR LAS ORDENES DE TRABAJO QUE YA ESTÁN LEGALIZADOS ***/
?>