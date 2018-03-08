<? 
	error_reporting(E_ALL);  // Líneas para mostart errores
ini_set('display_errors', '1');  // Líneas para mostart errores
	//echo "sadfsadf0";
    include("../../librerias/lib/@include.php");
//echo "sadfsadf0";
	require_once("../../librerias/php/desempeno/correos_solicitud_todos.php");
//echo "sadfsadf0";
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

	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES HSSE QUE YA ESTÁN LEGALIZADOS ***/
	echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=4  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=4  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas<="2018-03-05"){
			echo "se evalúa ".$ls[0]."--".$ls[7]."<br>";
			evaluacion_puntual_hsse($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES HSSE QUE YA ESTÁN LEGALIZADOS ***/
	
	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES ADMINISTRATIVO QUE YA ESTÁN LEGALIZADOS ***/
	echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=6  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=2 and id_estado>4 and id_estado<9 and id_criterio=6  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas<"2018-02-28"){
			echo "se evalúa ".$ls[0]."--".$ls[7]."<br>";
			evaluacion_puntual_adm($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES ADMINISTRATIVO QUE YA ESTÁN LEGALIZADOS ***/
	

	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO HSSE QUE YA ESTÁN LEGALIZADOS ***/
	echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=5  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=5  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas<="2018-03-05"){
			echo "se evalúa ".$ls[0]."--".$ls[7]."<br>";
			evaluacion_marco_hsse($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO HSSE QUE YA ESTÁN LEGALIZADOS ***/
	
	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO ADMINISTRATIVO QUE YA ESTÁN LEGALIZADOS ***/
	echo "SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=7  order by fecha_solicitud<br><br>";
	$query=query_db("SELECT id_agregar_criterio,id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe,id_ot  FROM t9_criterios_evaluacion where tipo_documento=3 and id_estado>4 and id_estado<9 and id_criterio=7  order by fecha_solicitud");
	//$cont=0;
	while($ls=traer_fila_db($query)){
		$un_ano_mas =strtotime ( '+1 year' , strtotime ($ls[7]) );
		$un_ano_mas=date('Y-m-d', $un_ano_mas);
		if($un_ano_mas<"2018-02-28"){
			echo "se evalúa ".$ls[0]."--".$ls[7]."<br>";
			evaluacion_marco_adm($ls[0]);
			//$cont++;
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO ADMINISTRATIVO QUE YA ESTÁN LEGALIZADOS ***/
?>