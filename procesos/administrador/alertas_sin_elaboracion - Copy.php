<? 
	//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
include("../../librerias/lib/@session.php");
	$_SESSION["usuarios_array"] = "";
	$_SESSION["usuarios_con_reemplazo"] = "";
	$usuarios_con_reemplazo="";
	$usuarios_array="";

$comple_alert = "";

if($_GET["filtro_modulo"] <> "" and $_GET["filtro_modulo"] <> "0" ){
		if($_GET["filtro_modulo"]=="MODULO DESEMPEÑO"){//para el módulo de desempeño
			$comple_alert = $comple_alert." and modulo = 'MODULO DESEMPE&Ntilde;O'";
		}else{
			$comple_alert = $comple_alert." and modulo = '".$_GET["filtro_modulo"]."'";
		}
			
	}
if($_GET["filtro_consecutivo"] <> "" and $_GET["filtro_consecutivo"] <> "0" ){
		$comple_alert = $comple_alert." and consecutivo like '%".$_GET["filtro_consecutivo"]."%'";
	}
if($_GET["filtro_congenlado"] == "1"){
		$comple_alert = $comple_alert." and consecutivo like '%Congelado%'";
	}
if($_GET["filtro_congenlado"] == "2"){
		$comple_alert = $comple_alert." and consecutivo not like '%Congelado%'";
	}
if($_GET["filtro_usuario"] <> "" and $_GET["filtro_usuario"] <> "0" ){
		$comple_alert = $comple_alert." and id_usuario = '".$_GET["filtro_usuario"]."'";
	}
if($_GET["filtro_descripcion"] <> "" and $_GET["filtro_descripcion"] <> "0" ){
		$comple_alert = $comple_alert." and detalle = '".$_GET["filtro_descripcion"]."'";
	}
if($_GET["filtro_nivel"] <> "0" and $_GET["filtro_nivel"] <> "" ){
	$filtro_res_tilde = str_replace("é", "&eacute;", $_GET["filtro_nivel"]);
	$filtro_res_tilde = str_replace("á", "&aacute;", $filtro_res_tilde);
	$filtro_res_tilde = str_replace("í", "&iacute;", $filtro_res_tilde);
	$filtro_res_tilde = str_replace("ó", "&oacute;", $filtro_res_tilde);
	$filtro_res_tilde = str_replace("ú", "&uacute;", $filtro_res_tilde);
	
		$comple_alert = $comple_alert." and nivel_aprobacion like '%".$filtro_res_tilde."%'";
	}
	

$sel_rol_usuario = traer_fila_row(query_db("select count(*) from  tseg12_relacion_usuario_rol where id_usuario =".$_SESSION["id_us_session"]." and id_rol_general in (13,17)"));

	 $buscar_reemplazos = query_db("select id, id_us, id_reemplazo, observacion, desde_cuando, hasta_cuando, usuario_crea, estado, fecha_creacion from tseg_reemplazos where id_reemplazo=".$_SESSION["id_us_session"]." and estado = 1 and desde_cuando <='".$fecha."'");
	 
	 $usuarios_con_reemplazo = $_SESSION["id_us_session"];
	 $usuarios_array= array($_SESSION["id_us_session"]);
	 $i = 1; 
	 while($b_reempla = traer_fila_db($buscar_reemplazos))  {
	  
	  $usuarios_con_reemplazo.= ",".$b_reempla[1];
	  $usuarios_array[$i]=$b_reempla[1];
		$i++;
	 }
	 
	$_SESSION["usuarios_array"] = $usuarios_array;
	$_SESSION["usuarios_con_reemplazo"] = $usuarios_con_reemplazo;
	
	$crea_tempo = "CREATE TABLE #alertas (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int, id_usuario int, nivel_aprobacion varchar(1000))";
	$sql_te = query_db($crea_tempo);


	//alertas item


if($_SESSION["id_us_session"] == 18591){
	
	$comple_sql_almace=" and t1_area_id in (17,24,21,40,34,38)";
	}
//PARA EL DES 065

	
$num_va = 0;

if($sel_rol_usuario[0]==0){
	$sql_no_congelados = " and (congelado is null or congelado = 2)";
	
}
	$sele_pecc_item = query_db("select  id_item, num1, num2, num3, fecha_cuando_se_agendo, descrip1, descrip2, descrip3, id_pecc, estado, congelado, t2_nivel_servicio_encargado_id, nombre, id_us,id_us_profesional_asignado, contrato_id, t1_tipo_proceso_id, t1_area_id, t1_tipo_contratacion_id from v_alertas_pecc_item where id_pecc = 1 and estado not in (12.1, 12.2) and (estado < 21 or estado = 34) $comple_sql_almace $sql_no_congelados");
	while($sel_item = traer_fila_db($sele_pecc_item)){
		$si_congelado="";
			$numero = numero_item_pecc($sel_item[1],$sel_item[2],$sel_item[3]);
			if($sel_item[10]==1){
				$numero = $numero."---Congelado";
				
			}
			$modulo_aplica = "MODULO SOLICITUDES";
			$link_aplica_modulo = "pecc/edicion-item-pecc";
		$id_tipo_proceso_pecc = 1;
		$es_encargado = "NO";

			if($sel_item[15] == 7){

					$id_tipo_proceso_pecc = 2;
				}
			if($sel_item[15] == 8){
					$id_tipo_proceso_pecc = 3;
				}

						//BODEGA
		if($sel_item[11] == 10){
		$sel_us_bodega = traer_fila_row(query_db("select  us_id, usuario, id_modulo, modulo, id_premiso, permiso, id_tipo_permiso, tipo_permiso, id_area, nombre_administrador from v_seg1 where us_id in  (".$_SESSION["usuarios_con_reemplazo"].") and id_premiso = 29"));
			if($sel_us_bodega[0]>0){
				$es_encargado = "SI";
			}
		}						
						//FIN BODEGA
						
						
		if($sel_item[11] == 1){
			if(vari_si_reempla($sel_item[13]) == "SI"){
//				if($sel_item[13] == $_SESSION["id_us_session"]){
					$es_encargado = "SI";
					}
		}
		
		
		
		
		
		if($sel_item[11] == 2){
			
			
			if(vari_si_reempla($sel_item[14]) == "SI"){
				//if($sel_item[14] == $_SESSION["id_us_session"]){
					$es_encargado = "SI";
					}
		}
		
		
		
		if($sel_item[11] == 3){
	
	
	if($sel_item[9] ==7 ){
		$permiso_asdj =1;
		}
	if($sel_item[9] ==16 ){
		$permiso_asdj =2;
		}
		
		
		$rol_no_aplica="";
				

$sel_aprobadores_de_firmas = traer_fila_row(query_db("select id_item_pecc,id_rol from $valer_2 where id_item_pecc = ".$sel_item[0]." and (id_usuario in (".$_SESSION["usuarios_con_reemplazo"].") or id_usuario_original in (".$_SESSION["usuarios_con_reemplazo"].")) and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol not in (10,11 ".$rol_no_aplica.")"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";

					if(permite_firmar_proceso_de_bienes($sel_item[0]) == "SI" or $sel_item[16]==16){//si es diferente a servicios o si es servicios menores
					
					
			$sel_si_comite = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and id_rol = 10 and tipo_adj_permiso = ".$permiso_asdj." and estado = 1"));
			
			$sel_si_vicepresidente = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and id_rol in( 20, 43) and tipo_adj_permiso = ".$permiso_asdj." and estado = 1"));
			
			$sel_si_gernte_area = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and id_rol in( 9) and tipo_adj_permiso = ".$permiso_asdj." and estado = 1"));		
					
									if($sel_aprobadores_de_firmas[1]==9 and  ($sel_si_comite[0]==0 and $sel_si_vicepresidente[0]==0)){		// si es jefe de area y no tiene comite	 ni viceprecidente						
										
										$sel_si_tiene_jefe_area_2 = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario in (".$_SESSION["usuarios_con_reemplazo"].") and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol  = 40"));
										
										if($sel_si_tiene_jefe_area_2[0] == 0){
										$es_encargado = "NO";
										}
										
										}
										
										
									if(($sel_aprobadores_de_firmas[1]==35 or $sel_aprobadores_de_firmas[1]==45) and  ($sel_si_vicepresidente[0]==0 and $sel_si_comite[0]==0 and $sel_si_gernte_area[0] == 0) ){		// si es superintendente y no tiene comite	 ni viceprecidente					
										$es_encargado = "NO";
										}
									if(($sel_aprobadores_de_firmas[1]==20 or $sel_aprobadores_de_firmas[1]==43) and  $sel_si_comite[0]==0){		// si es vicepresidente y no tiene comite							
										$es_encargado = "NO";
										}
										
					
					
											
		 if(faltaprofesionalcompras($sel_item[0])=="SI" ){
							 $es_encargado = "NO";
							 if(esprofesionalcompras($sel_item[0])=="SI"){//si es nanky
								$es_encargado = "SI";
							 }
						 }
					}//fin si es diferente a servicios
	 
					
					}
			
			
								



		}
		
$texto_comite_incluido="";				
		if($sel_item[11] == 4){

			$sel_rol_comite = traer_fila_row(query_db("select count(*) from $v_seg1 where id_modulo = 1 and id_premiso = 10 and	us_id in (".$_SESSION["usuarios_con_reemplazo"].")"));
				if($sel_rol_comite[0] > 0){
					$es_encargado = "SI";
					$modulo_aplica = "MODULO COMITE";
					
					$select_si_ya_esta_en_otro_comite = traer_fila_row(query_db("select count(*) from t3_comite_relacion_item as t1, t3_comite as t2 where t1.id_item = ".$sel_item[0]." and t1.id_comite = t2.id_comite and t2.estado <> 1 "));
					if($select_si_ya_esta_en_otro_comite[0] > 0 ){
						$sel_dt_comi = traer_fila_Row(query_db("select num1, num2, num3 from t3_comite_relacion_item as t1, t3_comite as t2 where t1.id_item = ".$sel_item[0]." and t1.id_comite = t2.id_comite and t2.estado <> 1 "));
					$texto_comite_incluido=" (Incluido - ".numero_item_pecc($sel_dt_comi[0], $sel_dt_comi[1], $sel_dt_comi[2]).")";
					}else{
						$texto_comite_incluido=" (NO Incluido)";
						}
					
					//$select_item_en_comites = query_db("select * from v_comite_item_ultimo_estado_pendiente where id_item = ".$sel_item[0]);
					
					}
					
					
		}
		
		if($sel_item[11] == 5){//SOCIOS
		
	if($sel_item[9] == 9 ){
		$permiso_asdj =1;
		}
	if($sel_item[9] == 18 ){
		$permiso_asdj =2;
		}
		

			$sel_aprobadores_de_firmas = traer_fila_row(query_db("select id_item_pecc from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario in (".$_SESSION["usuarios_con_reemplazo"].") and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol = 11"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
		}
		
		if($sel_item[11] == 11){//estado elaboracion de contrato
				
				
		if($sel_item[16] == 8){//si es OT en elaboracion de contrato
			if($_SESSION["id_us_session"] == 18245 and $sel_item[13] == 18245){// si es tatiana
			$es_encargado = "SI";				
			}
			
			/*if($_SESSION["id_us_session"] == 57 and $sel_item[13] <> 18245){// si es amparo

			$es_encargado = "SI";				
			}*/
			
			}else{// si es elaboracion de contrato de cualquier otro tipo de solicitud
				$sel_us_elaboracion_contra = traer_fila_row(query_db("select us_id, usuario, id_modulo, modulo, id_premiso, permiso, id_tipo_permiso, tipo_permiso, id_area, nombre_administrador
 from v_seg1 where us_id in (".$_SESSION["usuarios_con_reemplazo"].") and id_premiso = 32"));
					if($sel_us_elaboracion_contra[0]>0){
					$es_encargado = "SI";
					}		
				}
			
		
					
					
					
					
		}
		
		$contras_solic = "";
		$aprobacion_nivel="";
		if($sel_item[9] == 34 ){
			$sel_aprobaciones_cargue_manual = traer_fila_row(query_db("select id, us_aprueba1,aprobacion1, us_aprueba2,aprobacion2, us_aprueba3, aprobacion3 from t2_verificacion_modificacion_manual where id_item = ".$sel_item[0]." "));
			if($sel_aprobaciones_cargue_manual[0]>0){//si el usuario esta en alguna de las firmas
					if($sel_aprobaciones_cargue_manual[1]==$_SESSION["id_us_session"] and ($sel_aprobaciones_cargue_manual[2] == "" or $sel_aprobaciones_cargue_manual[2] == "0")){//si es el primer validador
					$es_encargado = "SI";
					}
					if($sel_aprobaciones_cargue_manual[3]==$_SESSION["id_us_session"] and ($sel_aprobaciones_cargue_manual[4] == "" or $sel_aprobaciones_cargue_manual[4] == "0") and ($sel_aprobaciones_cargue_manual[2] != "" and $sel_aprobaciones_cargue_manual[2] != "0")){//si es el segundo validador
					$es_encargado = "SI";
					}
					if($sel_aprobaciones_cargue_manual[5]==$_SESSION["id_us_session"] and ($sel_aprobaciones_cargue_manual[6] == "" or $sel_aprobaciones_cargue_manual[6] == "0") and ($sel_aprobaciones_cargue_manual[2] != "" and $sel_aprobaciones_cargue_manual[2] != "0") and ($sel_aprobaciones_cargue_manual[4] != "" and $sel_aprobaciones_cargue_manual[4] != "0") ){//si es el tercero validador
					$es_encargado = "SI";
					}
				
				}
				if(($sel_aprobaciones_cargue_manual[1] == 2 or $sel_aprobaciones_cargue_manual[2] == 2 or $sel_aprobaciones_cargue_manual[3] == 2) and $_SESSION["id_us_session"] == 32 ){//agrega alerta de devoluviones de cargues manuales, para el admin del SGPA
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$sel_item[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','".$modulo_aplica."','".$numero."','Sección: Validación de Cargue Manual. Tarea: Un usuario aprobador devolvió este cargue manual', '".$sel_item[4]."',2, '".$sel_item[13]."','".$aprobacion_nivel."')");
					}
//			if()
			}

				
			if($es_encargado == "SI"){
					
				/*if($sel_item[7]=="Evaluacion Tecnica"){//PARA EL DES-054-17
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$sel_item[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','".$modulo_aplica."','".$numero."','Sección: ".$sel_item[6].". Este proceso se encuentra en evaluación Técnica.', '".$sel_item[4]."',2, '".$sel_item[13]."','".$aprobacion_nivel."')");
				}else{*/
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$sel_item[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','".$modulo_aplica."','".$numero."','Sección: ".$sel_item[6].". Tarea: ".$sel_item[7].$contras_solic.$texto_comite_incluido."', '".$sel_item[4]."',2, '".$sel_item[13]."','".$aprobacion_nivel."')");
				//}FIN PARA EL DES-054-17
			}
				
		}	
		//VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				$sel_usu_emulan = query_db("select  id, id_us, id_us_emula from t2_relacion_usuarios_emulan where id_us in (".$_SESSION["usuarios_con_reemplazo"].") ");
				$cuantos = 0;
				while($us_emunlados = traer_fila_db($sel_usu_emulan)){
						$strin_emulado = $strin_emulado.$us_emunlados[2].",";
						$cuantos = 1;
					}
					
					if($cuantos == 1){
						$id_us_alerta = $strin_emulado."0";
						}else{
								$id_us_alerta = $_SESSION["usuarios_con_reemplazo"];
							}
							
				
							

				$sel_item_en_preparacion_devuelto = query_db("select id_item, num1,num2,num3, t1_tipo_proceso_id,id_us from $pi2 where num1 <> '' and id_us in (".$id_us_alerta.") and estado = 31 and (congelado <> 1 or congelado is null)  and (id_us_preparador in (".$_SESSION["usuarios_con_reemplazo"].") or id_us in (".$_SESSION["usuarios_con_reemplazo"]."))");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_devuelto)){
					
					$numero = numero_item_pecc($sel_devueltos_31[1],$sel_devueltos_31[2],$sel_devueltos_31[3]);
					
					if($sel_devueltos_31[4] == 7){

					$id_tipo_proceso_pecc = 2;
				}
			if($sel_devueltos_31[4] == 8){
					$id_tipo_proceso_pecc = 3;
				}

						
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','".$numero."','Sección: Solicitud de Permiso. Tarea: Ajustar por Devolución', '2012-01-01',2, '".$sel_devueltos_31[5]."','')");
					}

					$sel_item_en_preparacion_preparacion = query_db("select id_item, num1,num2,num3, t1_tipo_proceso_id,id_us from $pi2 where (num1 is null or num1 = '') and id_us in (".$id_us_alerta.") and estado = 31 and (congelado <> 1 or congelado is null)  and (id_us_preparador in (".$_SESSION["usuarios_con_reemplazo"].") or id_us in (".$_SESSION["usuarios_con_reemplazo"]."))");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_preparacion)){
					
					if($sel_devueltos_31[4] == 7){

					$id_tipo_proceso_pecc = 2;
				}
			if($sel_devueltos_31[4] == 8){
					$id_tipo_proceso_pecc = 3;
				}
				
				
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','','Sección: Solicitud de Permiso. Tarea: En Preparación', '2012-01-01',2, '".$sel_devueltos_31[5]."','')");
					}
					
				//Fin VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
			

//estado de informativo de procesos OTs*/
				
	//Fin Alertas item
	
	
	// comite
	$sel_comites_activos = query_db("select id_comite, num1,num2,num3, fecha,id_us from v_alertas_comite where id_us = ".$_SESSION["id_us_session"]." group by id_comite,  num1,num2,num3, fecha,id_us  ");
	while($comit_pendientes = traer_fila_db($sel_comites_activos)){
		$numero_comite = numero_item_pecc($comit_pendientes[1],$comit_pendientes[2],$comit_pendientes[3]);
		
		
		
		$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$comit_pendientes[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$comit_pendientes[0]."','MODULO COMITE','".$numero_comite."','Tiene Solicitudes pendientes por aprobacion', '".$comit_pendientes[5]."',3, 0,'')");
		
	}
		
	/*Alertas Tareas Del comite*/
	//PARA LAS ALERTAS DEL MODULO DE DESEMPEÑO
	if($_SESSION["id_us_session"]==17){//SI EL USUARIO ES IRMA FERNANDEZ SE LOTIFICAN TODAS LAS EVALUACIONES
		$tipo_evaluacion=query_db("select tipo_documento, id_evaluacion, numero_documento, id_estado_criterio, estado_evaluacion, id_evaluador, id_crea_aspectos, id_jefe from dbo.historico_desempeno() WHERE id_estado_criterio<9");
	}else{
		$tipo_evaluacion=query_db("select tipo_documento, id_evaluacion, numero_documento, id_estado_criterio, estado_evaluacion, id_evaluador, id_crea_aspectos, id_jefe from dbo.historico_desempeno() WHERE (id_evaluador=".$_SESSION["id_us_session"]." or id_crea_aspectos= ".$_SESSION["id_us_session"]." or id_jefe=".$_SESSION["id_us_session"].")");
	}
	while($lt=traer_fila_db($tipo_evaluacion)){
		$id_consulta=0;
		$titulo="";
		if($lt[3]==2 and $lt[7]==$_SESSION["id_us_session"]){
			$id_consulta=$lt[7];
			$titulo="Tiene Criterios Pendientes por Aprobaci&oacute;n";
			if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
				$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
			}
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
		}elseif($lt[3]==6 and $lt[7]==$_SESSION["id_us_session"]){
			$id_consulta=$lt[7];
			$titulo="Tiene Evaluaciones Pendientes por Aprobaci&oacute;n";
			if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
				$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
			}
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
		}elseif($lt[3]==5 and $lt[5]==$_SESSION["id_us_session"]){
			$id_consulta=$lt[5];
			$titulo="Tiene Evaluaciones Pendientes por Ralizar";
			if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
				$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
			}
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
		}elseif($lt[3]==1 and $lt[6]==$_SESSION["id_us_session"]){
			$id_consulta=$lt[6];
			$titulo="Tiene Criterios Pendientes por Definir";
			if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
				$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
			}
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
		}elseif($lt[3]==3 and $lt[6]==$_SESSION["id_us_session"]){
			$id_consulta=$lt[6];
			$titulo="Criterios Rechazados";
			if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
				$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
			}
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
		}elseif($lt[3]==7 and $lt[6]==$_SESSION["id_us_session"]){
			$id_consulta=$lt[6];
			$titulo="Evaluaci&oacute;n Rechazada";
			if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
				$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
			}
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
		}
		if($_SESSION["id_us_session"]==17){//SI EL USUARIO ES IRMA FERNANDEZ SE LOTIFICAN TODAS LAS EVALUACIONES
			if($lt[3]==2){
					$id_consulta=$lt[7];
					$titulo="Tiene Criterios Pendientes por Aprobaci&oacute;n";
					if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
						$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
					}
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
				}elseif($lt[3]==6){
					$id_consulta=$lt[7];
					$titulo="Tiene Evaluaciones Pendientes por Aprobaci&oacute;n";
					if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
						$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
					}
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
				}elseif($lt[3]==5){
					$id_consulta=$lt[5];
					$titulo="Tiene Evaluaciones Pendientes por Ralizar";
					if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
						$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
					}
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
				}elseif($lt[3]==1){
					$id_consulta=$lt[6];
					$titulo="Tiene Criterios Pendientes por Definir";
					if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
						$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
					}
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
				}elseif($lt[3]==3 and $lt[6]==$_SESSION["id_us_session"]){
					$id_consulta=$lt[6];
					$titulo="Criterios Rechazados";
					if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
						$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
					}
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
				}elseif($lt[3]==7){
					$id_consulta=$lt[6];
					$titulo="Evaluaci&oacute;n Rechazada";
					if($id_consulta!="" and $id_consulta!=" " and $id_consulta!=NULL and $id_consulta!=0){
						$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
					}
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$lt[1].",'../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=".arreglo_pasa_variables($lt[1])."','MODULO DESEMPE&Ntilde;O','".$lt[2]."','".$titulo."', '".$id_consulta."',3, 0,'')");
				}
		}
		
	}
	//FIN PARA LAS ALERTAS DEL MODULO DE DESEMPEÑO
	$valida_permiso="select * from $ts6 where id_usuario=".$_SESSION["id_us_session"]." and id_rol_general=6";
  	$resultado=traer_fila_row(query_db($valida_permiso));
  	if($resultado[1]==6){
  		$sel_proce=query_db("select id_tarea, responsable, cierre, cast(titulo as text) as titulo, num1, num2, num3, fecha_cierre, nums1, nums2, muns3, id_responsable, id_cierre, estado, numt1, numt2, numt3 from $vcomite3 where estado <> 3 order by fecha_cierre asc");
	}else{
		
		$sel_proce=query_db("select id_tarea, responsable, cierre, cast(titulo as text) as titulo, num1, num2, num3, fecha_cierre, nums1, nums2, muns3, id_responsable, id_cierre, estado, numt1, numt2, numt3 from $vcomite3 where estado <> 3 and id_responsable=".$_SESSION['id_us_session']." order by fecha_cierre asc");
	}
	while($sele_tareas = traer_fila_db($sel_proce)){
  		$numero_tarea=numero_item_pecc($sele_tareas[14],$sele_tareas[15],$sele_tareas[16]);
  		//calcular la diferencia de días entre la fecha de hoy y la fecha en la bd
  		$date1=date('Y-m-d');
  		$date2= date('Y-m-d', strtotime("".$sele_tareas[7]));
  		$segundos=strtotime($date2) - strtotime($date1);
		$diferencia_dias=intval($segundos/60/60/24);
  		$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$sele_tareas[0].",'../aplicaciones/comite/edicion-comite-tarea.php?id_comite=".$sele_tareas[0]."','MODULO COMITE','".$numero_tarea."','$sele_tareas[3], por gestionar, faltan: $diferencia_dias días para el cierre', '".$sele_tareas[7]."',3, 0,'')");
  	}
		/*FIN Alertas Tareas*/
	//fin comite
	
	//ratificacion presidente
	
	if($_SESSION["id_us_session"] == $presidente){
		$sel_comites = query_db("select id_comite, num1,num2,num3, fecha from t3_comite where (presidente is null or presidente = 0) and estado = 1");
		
		while($sel_com = traer_fila_db($sel_comites)){
			$numero_comite = numero_item_pecc($sel_com[1],$sel_com[2],$sel_com[3]);
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$sel_com[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$sel_com[0]."','MODULO COMITE','".$numero_comite."','Este Comité esta Pendiente por Verificar', '".$sel_com[4]."',3,0,'')");
			}
	}
	//FIN ratificacion presidente


	//urna virtual
if( $_SESSION["id_us_session"] != 0){//NO aplica urna para los usuarios	par aponer a vivk.
	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);
	
	
		
 $busca_invitaciones = "select distinct pro1_id from v_vista_invitados_observadores where us_id in (".$_SESSION["usuarios_con_reemplazo"].") and estado = 1";	
$sql_invitados = mysql_query($busca_invitaciones);
while($bus_invo=mysql_fetch_row($sql_invitados))
		{
			$apariciurna+=1;
			$concate_id_urna.=",".$bus_invo[0];
		}
		if($apariciurna>=1){
		
		$comple_invotad_urna = "  or pro1_proceso.pro1_id in (0 $concate_id_urna)";
		
		}
		
//		$complemento.= " and	( $t5.us_id_contacto =  ".$_SESSION["id_us_session"]." or $t5.us_id =  ".$_SESSION["id_us_session"]."  $comple_invotad) ";	
		
		
		
		 $complemento_bus_inbox_urna= "  ((pro1_proceso.us_id_contacto in (".$_SESSION["usuarios_con_reemplazo"].") or pro1_proceso.us_id in (".$_SESSION["usuarios_con_reemplazo"]."))   $comple_invotad_urna) " ;
		
	
	
	
 $query_usr = "select pro1_proceso.pro1_id, tp2_tipo_proceso.nombre, tp6_tipo_objetos.nombre, tp5_tipo_contrato.nombre, pro1_proceso.fecha_apertura, pro1_proceso.fecha_cierre, us_usuarios.nombre_administrador, pro1_proceso.consecutivo, pro1_proceso.detalle_objeto , tp1_estado_proceso.nombre estado_procesos , pro1_proceso.us_id, pro1_proceso.cuantia,pro1_proceso.tp7_tipo_moneda,pro1_proceso.us_id_contacto
	from tp2_tipo_proceso, tp6_tipo_objetos, tp5_tipo_contrato, us_usuarios, pro1_proceso, tp1_estado_proceso 
	where $complemento_bus_inbox_urna and tp2_tipo_proceso.tp2_id = pro1_proceso.tp2_id 
	and tp6_tipo_objetos.tp6_id = pro1_proceso.tp6_id 
	and tp5_tipo_contrato.tp5_id = pro1_proceso.tp5_id 
	and us_usuarios.us_id = pro1_proceso.us_id_contacto 
	and tp1_estado_proceso.tp1_id = pro1_proceso.tp1_id 
	and pro1_proceso.tp1_id not in (5, 7, 8,11, 10) order by pro1_proceso.pro1_id desc ";
	
	 $sql_ex = mysql_query($query_usr);
                while($ls=mysql_fetch_row($sql_ex)){
$muestra_proceso = 0;
 			//	if($ls[10]==$_SESSION["id_us_session"]){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
              /*      } //SI ES EL DUEÑO DEL PROCESO
            
                if($ls[13]==$_SESSION["id_us_session"]){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    } //SI ES EL DUEÑO DEL PROCESO
            	*/
				$textr_alert = "Estado del proceso: $ls[9] fecha de cierre $ls[5]";
				
				$busca_invitaciones_tecnco = "select count(*) from v_vista_invitados_observadores where pro1_id = $ls[0] and us_id in (".$_SESSION["usuarios_con_reemplazo"].") and estado = 1";	
				$sql_invitados_tec = mysql_fetch_row(mysql_query($busca_invitaciones_tecnco));

				
				if($sql_invitados_tec[0]>=1){
					$textr_alert = "Tarea: Evaluar ofertas t&eacute;cnicas";
					}
							
			if($muestra_proceso==1){ //si se debe mostrar
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$ls[0].",'carga_urna(".$ls[0].")','MODULO URNA VIRTUAL','".$ls[7]."','$textr_alert', '".$ls[5]."',4,0,'')");
				
				}//si se debe mostrar
				
				}
				
				mysql_close();
	
	// urna virtual
}//NO aplica urna para los usuarios	


//*************************--------inicio contratos--------****************************
	$arr_estado = 'null';
	
		
	
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$contratos_por_usario="0";
	$sel_contratos_gestiona = query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]);
	while($sel_con = traer_fila_db($sel_contratos_gestiona)){
				$contratos_por_usario.= ",".$sel_con[2];		
		}
		
		
	$contratos_por_usario_soport_des ="0";
	$sel_contratos_gestiona_sopo = query_db("select id_gerente from v_relacion_soportedes_gerente where id_soporte_des = ".$_SESSION["id_us_session"]);
	while($sel_con_sop = traer_fila_db($sel_contratos_gestiona_sopo)){
				$contratos_por_usario_soport_des.= ",".$sel_con_sop[0];		
		}
		
		
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
		
		
	$detalle_pendiente="";
		
$sel_permisos_par_cotnratos = query_db("select id_rol_general from tseg12_relacion_usuario_rol where id_usuario=".$_SESSION["id_us_session"]." and id_rol_general in (21, 24, 1026, 25, 26, 7)");
while($rec_cont = traer_fila_db($sel_permisos_par_cotnratos)){
	$detalle_pendiente ="";
		
	if($rec_cont[0]==21){//si es el rol gestion de abastecimiento
	$complet = " and gerente in (".$contratos_por_usario.")";
	$complet_2 = " and t7c.gerente in (".$contratos_por_usario.")";	
	$complet.= " AND (f_ini_entrega_doc = '' or f_ini_entrega_doc = ' ' or f_ini_entrega_doc is null)";
	$detalle_pendiente = "Legalización";
	
	}
	
	if($rec_cont[0]==24){//si es el rol profesional de aseguramoento
	$complet = " AND ((f_fin_rev_estrategia = ' ' or f_fin_rev_estrategia = '' or f_fin_rev_estrategia is null) and (f_ini_rev_estrategia is not null and f_ini_rev_estrategia <> '' and f_ini_rev_estrategia <> ' ')";
	$complet.= " OR (f_fin_garantia_dili_form = ' ' or f_fin_garantia_dili_form = '' or f_fin_garantia_dili_form is null) and (f_ini_garantia_dili_form is not null and f_ini_garantia_dili_form <> '' and f_ini_garantia_dili_form <> ' ')";
	$complet.= " OR (f_fin_garantia_fir_rep = ' ' or f_fin_garantia_fir_rep = '' or f_fin_garantia_fir_rep is null) and (f_ini_garantia_fir_rep is not null and f_ini_garantia_fir_rep <> '' and f_ini_garantia_fir_rep <> ' ')";	
	$complet.= " OR (f_fin_rs_notifi = ' ' or f_fin_rs_notifi = '' or f_fin_rs_notifi is null) and (f_ini_rs_notifi is not null and f_ini_rs_notifi <> '' and f_ini_rs_notifi <> ' '))";
	
	$detalle_pendiente = "Aseguramiento Administrativo:";
	}
	if($rec_cont[0]==1026){//si es el rol profesional de aseguramoento
	$complet = " and (f_fin_garantia_sol_inf = ' ' or f_fin_garantia_sol_inf = '' or f_fin_garantia_sol_inf is null) and (f_ini_garantia_sol_inf is not null and f_ini_garantia_sol_inf <> '' and f_ini_garantia_sol_inf <> ' ')";
	$detalle_pendiente = "Solicitar/Confirmar la creacion de la Fiducia en Par Servicios y SAP.";
	}
	$complet_polizas_contr="";
	$complet_polizas_modi="";
	if($rec_cont[0]==7){//si es el rol gestion polizas
	$complet = " and (f_fin_revision_polizas = ' ' or f_fin_revision_polizas = '' or f_fin_revision_polizas is null) and (f_ini_revision_polizas is not null and f_ini_revision_polizas <> '' and f_ini_revision_polizas <> ' ')";
		$complet_polizas_contr.= " and garantia_seguro in (1, 0, NULL) ";
		$complet_polizas_modi.= " and ((tipo_complemento = 1 and garantia_seguro in (1, 0, NULL)) or (tipo_complemento = 2 and garantia_seguro = 2))";
		$detalle_pendiente = "Revisión de Polizas";
	}
	if($rec_cont[0]==25){//si es el rol soporte descentralizado

	$sel_si_prof_compras = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario=".$_SESSION["id_us_session"]." and id_rol_general in (17)"));
	if($sel_si_prof_compras[0]>0){
	$complet.= " and especialista =".$_SESSION["id_us_session"];	
		}else{	
	$complet.= " and gerente in (".$contratos_por_usario_soport_des.")";
		}
	
	$complet.= " AND ((f_ini_entrega_doc_contrac <> '' and f_ini_entrega_doc_contrac <> ' ' and f_ini_entrega_doc_contrac is not null) and (f_fin_entrega_doc_contrac = '' or f_fin_entrega_doc_contrac = ' ' or f_fin_entrega_doc_contrac is null )  ";
	$complet.= " OR (f_ini_elabora_pedido <> '' and f_ini_elabora_pedido <> ' ' and f_ini_elabora_pedido is not null) and (f_fin_elabora_pedido = '' or f_fin_elabora_pedido = ' ' or f_fin_elabora_pedido is null )  ";
	$complet.= " OR (f_ini_aproba_sap <> '' and f_ini_aproba_sap <> ' ' and f_ini_aproba_sap is not null) and (f_fin_aproba_sap = '' or f_fin_aproba_sap = ' ' or f_fin_aproba_sap is null ) ) ";
	$detalle_pendiente = "legzalizacion_por_desecentralizado";
	}
	if($rec_cont[0]==26){//si es el rol soporte de aseguramiento
	$complet = " AND ((f_ini_entrega_doc <> '' and f_ini_entrega_doc <> ' ' and f_ini_entrega_doc is not null) and (f_fin_entrega_doc = '' or f_fin_entrega_doc = ' ' or f_fin_entrega_doc is null )  ";
	$complet.= " OR (f_ini_entrega_todo <> '' and f_ini_entrega_todo <> ' ' and f_ini_entrega_todo is not null) and (f_fin_entrega_todo = '' or f_fin_entrega_todo = ' ' or f_fin_entrega_todo is null ) ) ";
	$detalle_pendiente = "Contrato en Aseguramiento Administrativo";
	}
	
	if($detalle_pendiente <> ""){
	
	for($i=1;$i<=2;$i++){//solo son dos pasadas, una para contratos y otra para modificaciones
	
	if($i == 1){
		$vista = "v_contratos_alerta_contratos";
		$comple_modificacion = "";
		$complet_polizas=$complet_polizas_contr;
	}
	if($i == 2){
		$vista = "v_contratos_alerta_modificaciones";
		$comple_modificacion = ", id_modificacion";
		$complet_polizas=$complet_polizas_modi;
	}


$lista_contrato_sql ="select id,creacion_sistema,consecutivo, apellido, f_ini_firma_rep_legal, f_fin_firma_rep_legal, f_fin_entrega_doc_contrac, f_fin_elabora_pedido, f_fin_aproba_sap, f_fin_garantia_dili_form, f_fin_garantia_fir_rep, f_ini_rev_estrategia,f_fin_rev_estrategia".$comple_modificacion." from ".$vista." where id = id ".$complet.$complet_polizas;

if($_SESSION["id_us_session"] == 7){
//echo $lista_contrato_sql;
}

	$sql_contrato=query_db($lista_contrato_sql);
	
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[1]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[2];//consecutivo
			$numero_contrato4 = $lista_contrato[3];//apellido
			$detalle_pendiente_comple="";
			$sel_datos_modificaicon="";
			$id_modificacion=0;
			if($i == 2){//si es modificacoin
			$id_modificacion = $lista_contrato[13];
				$sel_datos_modificaicon  = traer_fila_row(query_db("select t2.nombre, t1.numero_otrosi from t7_contratos_complemento as t1, t1_tipo_complemento as t2 where t1.tipo_complemento = t2.id and t1.id = ".$id_modificacion));
				}
				
			if($detalle_pendiente == "Legalización"){
						if(($lista_contrato[4] <> "" and $lista_contrato[4] <> " ") and ($lista_contrato[5]=="" or $lista_contrato[5]==" ")){
						$dias_desde_firma_representanto = dias_habiles_entre_fechas($lista_contrato[4],$fecha);
						if($dias_desde_firma_representanto >= 5){
//						$detalle_pendiente_comple =' ';
							}
							
						$detalle_pendiente_comple = ' Dias desde el inicio de Firma de Representante Legal Contratista '.$dias_desde_firma_representanto.' Dias';
						}
				}
				$detalle_pendiente2 ="";
			if($detalle_pendiente == "Aseguramiento Administrativo:"){
				$entro = 0;
				
				if( ($lista_contrato[12] == "" or $lista_contrato[12] == " ") and ($lista_contrato[11] != "" and $lista_contrato[11] != " ")){
				$detalle_pendiente2 = " Contrato en Revisión, aprobación, estrategia / adjudicaciones (Fechas y Montos VS Minutas SAP y SGPA)";
				$entro = 1;
				}
				if(($lista_contrato[9] == "" or $lista_contrato[9] == " ") and ($entro == 0)){
				$detalle_pendiente2 = " Diligenciamiento del formato de condiciones de manejo de los recursos del Fideicomiso. ";
				}
				if(($lista_contrato[10] == "" or $lista_contrato[10] == " ") and ($entro == 0)){
				$detalle_pendiente2 = " Firma del Representante Legal de Hocol en el formato de condiciones de manejo de los recursos del Fideicomiso";
				}
			}
			if($detalle_pendiente == "legzalizacion_por_desecentralizado"){//si lo tiene soporte descentralizado, valida que fechas tiene llenas para porbner la alerta
			
						if(($lista_contrato[6] == "" or $lista_contrato[6] == " ")){
							$detalle_pendiente = "Entrega de documento contractual para la elaboración / modificación de pedido en SAP";
						}elseif($lista_contrato[7] == "" or $lista_contrato[7] == " "){
							$sel_si_tiene_devol = traer_fila_row(query_db("select count(*) from t7_relacion_campos_legalizacion_datos_devoluciones where id_contrato = ".$lista_contrato[0]." and id_campo_legalizacion = 17"));
							if($sel_si_tiene_devol[0]!= 0){
							$detalle_pendiente = "Elaboración / Modificación de pedido en SAP  - Ajustar por devolucion";
							}else{ $detalle_pendiente = "Elaboración / Modificación de pedido en SAP";}
						}else{
							$detalle_pendiente = "Aprobación en SAP por el profesional de C&C";
							}
				}
				if($i == 1){$detalle_pendiente_inicio = " Contrato en: "; $link ="../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0]);}
				if($i == 2){$detalle_pendiente_inicio = $sel_datos_modificaicon[0]." ".$sel_datos_modificaicon[1]." en: "; $link="../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0])."&id_complemento=".$id_modificacion;}
				
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$lista_contrato[0].",'".$link."','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[0])."','".$detalle_pendiente_inicio.$detalle_pendiente.$detalle_pendiente_comple.$detalle_pendiente2."', '',5,0,'')");
	}
	}//fin FOR Contrato Modificacion
	}//si tiene pendientes de legalizacion
}//fin while
	

//*************************--------FIN contratos--------****************************
	
	
	
	//$inserta_datos = query_db("insert into #alertas (id_proceso,destion,modulo,consecutivo,detalle) values (	1,2,'MODULO TARIFAS','C-2012-001','Tiene tarifas pendientes de aprobación')");

//crear_en_e_procurement(2);

/********************tarifas*/

//	$crea_tempo = "CREATE TABLE #alertas (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int, id_usuario int, nivel_aprobacion varchar(1000))";

$busca_arta_tarifas = "select distinct tarifas_contrato_id, consecutivo,usua_rio_proveedor from v_tarifas_responsable_aprobacion_2 where us_id in (".$_SESSION["usuarios_con_reemplazo"].") ";
$query_alerta_tarifas = query_db($busca_arta_tarifas );
while($lista_al_tar=traer_fila_row($query_alerta_tarifas))
	{
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$lista_al_tar[0].",'../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=".arreglo_pasa_variables($lista_al_tar[0])."&apro_pasa=1','TARIFAS','".$lista_al_tar[1]."','Tarifas pendientes de su aprobacion', '',6,".$lista_al_tar[2].",'')");

		}

$busca_tarifas_parciales = "select distinct tarifas_contrato_id, consecutivo,especialista from v_tarifas_contratos_parcial where especialista in (".$_SESSION["usuarios_con_reemplazo"].") ";
$sqlbusca_tarifas_parciales = query_db($busca_tarifas_parciales );
while($tarifa_parcial=traer_fila_row($sqlbusca_tarifas_parciales))
	{
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$tarifa_parcial[0].",'../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=".arreglo_pasa_variables($tarifa_parcial[0])."','TARIFAS','".$tarifa_parcial[1]."','Contrato Pendiente de Poner en Firme', '',6,".$tarifa_parcial[2].",'')");

		}



/*tarifas - contratos sin trifas*/
$sel_si_es_admon_tartifas = traer_fila_row(query_db("SELECT  count(*) FROM tseg12_relacion_usuario_rol WHERE    id_rol_general = 1 and  id_usuario in (".$_SESSION["usuarios_con_reemplazo"].")"));
if($sel_si_es_admon_tartifas[0]>0){
$sel_contratos_sin_tarifas = query_db("select tarifas_contrato_id, consecutivo, creacion_sistema, consecutivo_contrato, apellido, id from v_tarifas_contratos_sin_tarifas where vigencia_mes > '".$fecha."' or vigencia_mes = '' and (analista_deloitte is null or analista_deloitte = 0) order by tarifas_contrato_id desc");

while($lista_al_tar=traer_fila_row($sel_contratos_sin_tarifas))
	{
		
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_al_tar[2]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_al_tar[3];//consecutivo
			$numero_contrato4 = $lista_al_tar[4];//apellido
			$consecutivo_contrato = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_al_tar[5]);
			
			
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$lista_al_tar[0].",'../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=".arreglo_pasa_variables($lista_al_tar[0])."','TARIFAS','".$consecutivo_contrato."','Contrato Sin Tarifas', '',6,'','')");

		}
}/*tarifas - contratos sin trifas*/

/********************tarifas*/
			 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="0" />
 <meta http-equiv="Pragma" content="no-cache" />
<title><?=TITULO;?></title>







<?
	if($_GET["paginas"] > 0){
		$pagina = $_GET["paginas"];
		}else{
			$pagina = 1;
			}
		$registros_pagina=30;		
		$regis_final = $pagina * $registros_pagina;		
		$regis_inicial = ($pagina - 1) * $registros_pagina;
		
		

$sql_cuenta = traer_fila_row(query_db("select count(*) from #alertas where id_proceso >=1  $comple_alert"));
$cunatas_paginas = ($sql_cuenta[0] / $registros_pagina) +1;


?>






</head>

<body >


  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="95%" align="left" id="contenidos"><table width="100%" border="0"  cellspacing="2" cellpadding="2">
            <tr class="titulos_secciones">
              <td class="titulos_secciones">SECCION: ALERTAS GENERALES DE LOS MODULOS</td>
            </tr>
          </table>
            <br />
            <?

?>
 <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="8" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="39%"><div align="left">Tareas pendientes encontradas:
                      <?=$sql_cuenta[0];?>

                    </div></td>
                    <td width="39%" align="right"><table width="100%" border="0">
                      <tr>
                        <td width="84%" align="right">Paginas:</td>
                        <td width="16%"><select name="paginas" id="paginas" onchange="ajax_carga('../procesos/administrador/alertas_sin_elaboracion.php?paginas='+this.value+'&filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&filtro_congenlado='+document.principal.filtro_congenlado.value,'carga_alertas')">
                          <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
                          <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
                            <?=$i?>
                          </option>
                          <? }?>
                        </select></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td width="11%" class="columna_subtitulo_resultados"><div align="center">M&oacute;dulo</div></td>
                <td colspan="2" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
                <? if($sel_rol_usuario[0] > 0){ ?> <td width="6%" align="center" class="columna_subtitulo_resultados">Congelados</td><? } ?>
                <? 
                	/*if($si_congelado=="SI"){ PARA EL DES 065
                ?>
               	<td colspan="2" class="columna_subtitulo_resultados"><div align="center">Congelado</div></td>
	      <?
                	}*/
                ?>
               <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?>
                <td width="11%" align="center" class="columna_subtitulo_resultados">Nivel de Aprobaci&oacute;n</td>
                <?
			   }
				?>
                <td width="14%" align="center" class="columna_subtitulo_resultados">Usuario Solicitante</td>
                <td width="36%" class="columna_subtitulo_resultados"><div align="center">Descripci&oacute;n</div></td>
                <td width="4%" class="columna_subtitulo_resultados"><div align="center">Ingresar</div></td>
              </tr>
              <tr >
                <td ><select name="filtro_modulo" id="filtro_modulo" onchange="ajax_carga('../procesos/administrador/alertas_sin_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&filtro_congenlado='+document.principal.filtro_congenlado.value,'carga_alertas')">
                  <option value="0">Filtro: Todos</option>
                  <?
    $busca_item = query_db("select modulo from #alertas where id_proceso >=1  group by modulo");
	while($sel_filtro = traer_fila_row($busca_item)){
		?>
                  <option value="<?=$sel_filtro[0]?>" <? if($_GET["filtro_modulo"] == $sel_filtro[0]) echo 'selected="selected"';?>>
                    <?=$sel_filtro[0]?>
                  </option>
                  <?
		}
	?>
                </select></td>
                <td width="13%" ><input type="text" name="filtro_consecutivo" id="filtro_consecutivo" value="<?=$_GET["filtro_consecutivo"]?>"  /></td>
                <td width="5%" ><img src="../imagenes/botones/busqueda.gif" style="cursor:pointer" onclick="ajax_carga('../procesos/administrador/alertas_sin_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&filtro_congenlado='+document.principal.filtro_congenlado.value,'carga_alertas');" /></td>
               <? if($sel_rol_usuario[0] > 0){ ?> <td >
                
                <select name="filtro_congenlado" id="filtro_congenlado" onchange="ajax_carga('../procesos/administrador/alertas_sin_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&amp;filtro_usuario='+document.principal.filtro_usuario.value+'&amp;filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&amp;filtro_modulo='+document.principal.filtro_modulo.value+'&amp;filtro_nivel='+document.principal.filtro_nivel.value+'&filtro_congenlado='+document.principal.filtro_congenlado.value,'carga_alertas')">
                  <option value="0">Todos</option>
                 
                  <option value="1" <? if($_GET["filtro_congenlado"] == 1) echo 'selected="selected"';?> >Congelados</option>
                  <option value="2" <? if($_GET["filtro_congenlado"] == 2) echo 'selected="selected"';?> >Activos</option>
                 
                </select>
               
                </td>
                 <? }else{ ?>
                <input type="hidden" name="filtro_congenlado" id="filtro_congenlado" value="0"  />
                <? }?>
                <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?><td ><select name="filtro_nivel" id="filtro_nivel" onchange="ajax_carga('../procesos/administrador/alertas_sin_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&filtro_congenlado='+document.principal.filtro_congenlado.value,'carga_alertas')"><option value="0">Filtro: Todos</option>
               
               <?
                $busca_item = query_db("select nivel_aprobacion from #alertas where id_proceso >=1  group by nivel_aprobacion");	
				while($sel_niveles = traer_fila_row($busca_item)){
					
					
					?><option value="<?=$sel_niveles[0]?>" <? if($_GET["filtro_nivel"] == $sel_niveles[0]) echo 'selected="selected"';?> ><?=$sel_niveles[0]?></option><?
					}
			   ?>
               
               
               </select></td><? }else{
				   ?><input type="hidden" name="filtro_nivel" id="filtro_nivel" /><?
				   }?>
                <td ><select name="filtro_usuario" id="filtro_usuario" onchange="ajax_carga('../procesos/administrador/alertas_sin_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&filtro_congenlado='+document.principal.filtro_congenlado.value,'carga_alertas')">
                  <option value="0">Filtro: Todos</option>
                  <?
    $busca_item = query_db("select id_usuario from #alertas where id_proceso >=1  group by id_usuario");
	while($sel_filtro = traer_fila_row($busca_item)){
		?>
                  <option value="<?=$sel_filtro[0]?>" <? if($_GET["filtro_usuario"] == $sel_filtro[0]) echo 'selected="selected"';?>>
                    <?=traer_nombre_muestra($sel_filtro[0], $g1,"nombre_administrador","us_id")?>
                  </option>
                  <?
		}
	?>
                </select></td>
                <td ><select name="filtro_descripcion" id="filtro_descripcion" onchange="ajax_carga('../procesos/administrador/alertas_sin_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&filtro_congenlado='+document.principal.filtro_congenlado.value,'carga_alertas')">
                  <option value="0">Filtro: Todos</option>
                  <?
    $busca_item = query_db("select detalle from #alertas where id_proceso >=1  group by detalle");
	while($sel_filtro = traer_fila_row($busca_item)){
		?>
                  <option value="<?=$sel_filtro[0]?>" <? if($_GET["filtro_descripcion"] == $sel_filtro[0]) echo 'selected="selected"';?>>
                    <?=$sel_filtro[0]?>
                  </option>
                  <?
		}
	?>
                </select></td>
                <td class="titulos_resumen_alertas">&nbsp;</td>
              </tr>
              <?


	



 $busca_item = "select * from (
select id_proceso,destino,modulo,consecutivo,detalle, ROW_NUMBER() OVER(ORDER BY numero_modulo) AS rownum,numero_modulo,id_usuario,nivel_aprobacion from #alertas where id_proceso >=1  $comple_alert ) as sub where rownum > $regis_inicial and rownum <= $regis_final  
order by numero_modulo asc, modulo desc";	  



	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		$usuario_solicita ="";
		$link =$ls_mr[1];
		if($ls_mr[2] == "MODULO SOLICITUDES"){
/*SELECCIONA VENTANA A DONDE SE DIRIGE LA SOLICITUD*/
			$sel_item_inbox = traer_fila_row(query_db("select t1_tipo_proceso_id, estado from t2_item_pecc where id_item = ".$ls_mr[0]));
		
		if($sel_item_inbox[0] == 15){ 
	$link_envia = "adjudicacion";
	}elseif(($sel_item_inbox[0] == 1 or $sel_item_inbox[0] == 2 or $sel_item_inbox[0] == 3 or $sel_item_inbox[0] == 6) and ($sel_item_inbox[1] >=14 and $sel_item_inbox[1] !=31 and $sel_item_inbox[1] !=33)){ 
	
	$sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$ls_mr[0].""));
	$sele_validacion_adicional_marco = traer_fila_row(query_db("SELECT count(*) FROM t2_presupuesto_proveedor_adjudica WHERE        (t2_item_pecc_id_marco = ".$ls_mr[0]." and t1_tipo_documento_id = 2)"));
			if($sele_tipo_doc[0]>0 or $sele_validacion_adicional_marco[0]>0){
				$link_envia = "adjudicacion-marco";
				}else{
					$sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$ls_mr[0]."'"));
					if($sele_tipo_doc_desierto[13]==4 or $sele_tipo_doc_desierto[13]==7){
						$link_envia = "adjudicacion-desierto";
						}else{			
						$link_envia = "adjudicacion";
						}
				}
}else {$link_envia = "edicion-item-pecc";}

$arregla_link = str_replace("edicion-item-pecc",$link_envia,$ls_mr[1]);
/*FIN SELECCIONA VENTANA A DONDE SE DIRIGE LA SOLICITUD*/

			
			$link='ajax_carga("'.$arregla_link.'","contenidos")';
			
			$usuario_solicita = traer_nombre_muestra($ls_mr[7], $g1,"nombre_administrador","us_id");
						
			}
			
		if($ls_mr[2] == "MODULO PECC" or  $ls_mr[2] == "MODULO COMITE"){
			$link='ajax_carga("'.$ls_mr[1].'","contenidos")';
			
			$usuario_solicita = traer_nombre_muestra($ls_mr[7], $g1,"nombre_administrador","us_id");
						
			}
		//PARA EL MODULO DE DESEMPEÑO
		if($ls_mr[2] == "MODULO DESEMPE&Ntilde;O"){
			$link='ajax_carga("'.$ls_mr[1].'","contenidos")';
			
			$usuario_solicita = traer_nombre_muestra($ls_mr[7], $g1,"nombre_administrador","us_id");
						
			}
		if($ls_mr[2] == "MODULO CONTRATOS"){//para los que son elaboracion de contratos
			$link='ajax_carga("'.$ls_mr[1].'","contenidos")';
			$usuario_solicita = traer_nombre_muestra($ls_mr[7], $g1,"nombre_administrador","us_id");
			}
			
			
			
		if($ls_mr[2] == "CONTRATOS"){
			$link='taer_menu("'.$ls_mr[1].'","contenido_menu")';
			}
			
				if($ls_mr[2] == "TARIFAS"){
			$link='taer_menu("'.$ls_mr[1].'","contenido_menu");ajax_carga("../aplicaciones/tarifas/c_aprobaciones.php?id_contrato='.$ls_mr[0].'","carga_acciones_permitidas")';
			//$link = 'alert("En este momento nos encontramos trabajando en este modulo. Para mejorar la velocidad. Este servicio se restaurara el dia 11 de marzo de 2015 a las 8 am.")';
			}

			if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		
		$numero=explode("---",$ls_mr[3]);
		
		

?>

       
              <tr class="<?=$clase?>">
                <td ><?=$ls_mr[2];?></td>
                <td colspan="2" ><? if($numero[0]=="") echo $ls_mr[3]; else  echo $numero[0];?></td>
                <? if($sel_rol_usuario[0] > 0){ ?><td ><?=$numero[1];?></td><? }?>
                <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?><td ><?=$ls_mr[8]?></td><?
			   }
			   ?>
                <td ><? echo $usuario_solicita;?></td>
                <td ><?
                if($ls_mr[2] == "MODULO COMITE"){
                	//echo $ls_mr[4];
					$falta="";
               		$negrita=split('faltan:', $ls_mr[4]);
					if($negrita[1]!= "" and $negrita[1]!= " "){
						$falta = "Faltan: ";
						}
               		echo $negrita[0]."<font size='2'><b><strong> ".$falta." ".$negrita[1]."</strong></b></font>";
                }else{
                	echo $ls_mr[4];
                }?>
                	
                </td>
                <td class="titulos_resumen_alertas"><div align="center"> <img src="../imagenes/botones/editar.jpg" alt="" width="14" height="15" onclick='<?=$link;?>' /></div></td>
              </tr>
              <? } ?>
              <tr>
                <td colspan="8" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="78%"><div align="left">Tareas pendientes:
                      <?=$sql_cuenta[0];?>
                    </div></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
        </tr>
        
      </table>

</body>
</html>
