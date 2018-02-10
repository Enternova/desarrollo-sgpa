<? include("../../librerias/lib/@session.php");

$comple_alert = "";

if($_GET["filtro_modulo"] <> "" and $_GET["filtro_modulo"] <> "0" ){
		$comple_alert = $comple_alert." and modulo = '".$_GET["filtro_modulo"]."'";
	}
if($_GET["filtro_consecutivo"] <> "" and $_GET["filtro_consecutivo"] <> "0" ){
		$comple_alert = $comple_alert." and consecutivo like '%".$_GET["filtro_consecutivo"]."%'";
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
	

	      
	
	$crea_tempo = "CREATE TABLE #alertas (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int, id_usuario int, nivel_aprobacion varchar(1000))";
	$sql_te = query_db($crea_tempo);


	//alertas item


if($_SESSION["id_us_session"] == 18591){
	
	$comple_sql_almace=" and t1_area_id in (17,24,21)";
	}

	$sele_pecc_item = query_db("select  id_item, num1, num2, num3, fecha_cuando_se_agendo, descrip1, descrip2, descrip3, id_pecc, estado, congelado, t2_nivel_servicio_encargado_id, nombre, id_us,id_us_profesional_asignado, contrato_id, t1_tipo_proceso_id, t1_area_id, t1_tipo_contratacion_id from v_alertas_pecc_item where id_pecc = 1 and estado < 21 $comple_sql_almace");
	while($sel_item = traer_fila_db($sele_pecc_item)){
			$numero = numero_item_pecc($sel_item[1],$sel_item[2],$sel_item[3]);
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
		$sel_us_bodega = traer_fila_row(query_db("select  us_id, usuario, id_modulo, modulo, id_premiso, permiso, id_tipo_permiso, tipo_permiso, id_area, nombre_administrador from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 29"));
			if($sel_us_bodega[0]>0){
				$es_encargado = "SI";
			}
		}
						
						//FIN BODEGA
		if($sel_item[11] == 1){
				if($sel_item[13] == $_SESSION["id_us_session"]){
					$es_encargado = "SI";
					}
		}
		
		if($sel_item[11] == 2){
				if($sel_item[14] == $_SESSION["id_us_session"]){
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
			if($_SESSION["id_us_session"] == "18041" and $sel_item[18]<>1){
			$rol_no_aplica = ",9,35";		
			}
				
$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$_SESSION["id_us_session"]." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol not in (10,11 ".$rol_no_aplica.")"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
			
			
			
		}
		
				
		if($sel_item[11] == 4){

			$sel_rol_comite = traer_fila_row(query_db("select count(*) from $v_seg1 where id_modulo = 1 and id_premiso = 10 and	us_id=".$_SESSION["id_us_session"]));
				if($sel_rol_comite[0] > 0){
					$es_encargado = "SI";
					$modulo_aplica = "MODULO COMITE";
					
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
		

			$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$_SESSION["id_us_session"]." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol = 11"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
		}
		
		if($sel_item[11] == 11){//estado elaboracion de contrato
				
				
		if($sel_item[16] == 8){//si es OT en elaboracion de contrato
			if($_SESSION["id_us_session"] == 18245 and $sel_item[13] == 18245){// si es tatiana
			$es_encargado = "SI";				
			}
			
			if($_SESSION["id_us_session"] == 57 and $sel_item[13] <> 18245){// si es amparo

			$es_encargado = "SI";				
			}
			
			}else{// si es elaboracion de contrato de cualquier otro tipo de solicitud
				$sel_us_elaboracion_contra = traer_fila_row(query_db("select us_id, usuario, id_modulo, modulo, id_premiso, permiso, id_tipo_permiso, tipo_permiso, id_area, nombre_administrador
 from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 32"));
					if($sel_us_elaboracion_contra[0]>0){
					$es_encargado = "SI";
					}		
				}
			
		
					
					
					
					
		}
		
		$contras_solic = "";
		$aprobacion_nivel="";
		if($sel_item[9] ==20 ){
		$modulo_aplica = "MODULO CONTRATOS";
		$sele_contras_elab = query_db("select consecutivo,creacion_sistema,apellido, id from t7_contratos_contrato where id_item = ".$sel_item[0]);
					
					while($sel_cont = traer_fila_db($sele_contras_elab)){
						
							$numero_contrato1 = "C";			
							$separa_fecha_crea = explode("-",$sel_cont[1]);
							$ano_contra = $separa_fecha_crea[0];					
							$numero_contrato2 = substr($ano_contra,2,2);
							$numero_contrato3 = $sel_cont[0];
							$numero_contrato4 = $sel_cont[2];
							$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont[3]);

						}
				if($contras_solic == ""){		//si es orden de trabajo o ampliacion y la solicitud estado 20	
				$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));
				
				$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_apl[3]);
				
			}
				}
			
	if($sel_item["contrato_id"] != "" and $sel_item["contrato_id"] > 0 and $contras_solic == ""){	//si es otro si y la solicitud estado 20
		$sele_contras_elab_otro_si = traer_fila_row(query_db("select consecutivo,creacion_sistema,apellido from t7_contratos_contrato where id = ".$sel_item["contrato_id"]));
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sele_contras_elab_otro_si[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sele_contras_elab_otro_si[0];
					$numero_contrato4 = $sele_contras_elab_otro_si[2];
					$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_item["contrato_id"]);
	}
	
	$aprobacion_nivel =  nivel_aprobacion_solicitud($sel_item[0], "adjudicacion");
	
					$cuantos_caracteres = strlen($aprobacion_nivel);
					$cuantos_caracteres = $cuantos_caracteres - 13;
					$aprobacion_nivel_su = substr($aprobacion_nivel,0,$cuantos_caracteres);
					
					$aprobacion_nivel_expl = explode("-",$aprobacion_nivel);
					$aprobacion_nivel_expl_comite = explode(". ",$aprobacion_nivel);
					//echo "-".$aprobacion_nivel_expl[0]."-";
					if($aprobacion_nivel_expl[0] == "Vicepresidente "){
						
						if($sel_item[17]==24 or $sel_item[17]==25){
							$aprobacion_nivel = "Vp. Producci&oacute;n y  Operaciones";
							}elseif($sel_item[17]==17 or $sel_item[17]==18){
								$aprobacion_nivel = "V.p. Exploraci&oacute;n y Desarrollo de Negocios";
								}elseif($sel_item[17]==26 or $sel_item[17]==20 or $sel_item[17]==21 or $sel_item[17]==22){
								$aprobacion_nivel = "Vp. T&eacute;cnica";
								}elseif($sel_item[17]==1 or $sel_item[17]==14 or $sel_item[17]==2 or $sel_item[17]==30 or $sel_item[17]==13 or $sel_item[17]==12){
								$aprobacion_nivel = "Vp. Financiera y Administrativa";
								}elseif($sel_item[17]==4 or $sel_item[17]==5 or $sel_item[17]==6 or $sel_item[17]==7 or $sel_item[17]==3 or $sel_item[17]==8 or $sel_item[17]==9 or $sel_item[17]==15 or $sel_item[17]==23 or $sel_item[17]==19){
								$aprobacion_nivel = "Presidente";
								}else{
								$aprobacion_nivel = "Vicepresidente";
							}
						
						}elseif($aprobacion_nivel_expl[0] == "Comit&eacute; "){
							$aprobacion_nivel = "Comit&eacute; ".$aprobacion_nivel_expl_comite[1];
							}else{
							$aprobacion_nivel=$aprobacion_nivel_su;
							}
		
		}

				
				if($es_encargado == "SI"){
					
	
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$sel_item[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','".$modulo_aplica."','".$numero."','Sección: ".$sel_item[6].". Tarea: ".$sel_item[7].$contras_solic."', '".$sel_item[4]."',2, '".$sel_item[13]."','".$aprobacion_nivel."')");
				}
				
		}	
		//VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				$sel_usu_emulan = query_db("select  id, id_us, id_us_emula from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]);
				$cuantos = 0;
				while($us_emunlados = traer_fila_db($sel_usu_emulan)){
						$strin_emulado = $strin_emulado.$us_emunlados[2].",";
						$cuantos = 1;
					}
					
					if($cuantos == 1){
						$id_us_alerta = $strin_emulado."0";
						}else{
								$id_us_alerta = $_SESSION["id_us_session"];
							}
				$sel_item_en_preparacion_devuelto = query_db("select id_item, num1,num2,num3, t1_tipo_proceso_id,id_us from $pi2 where num1 <> '' and id_us in (".$id_us_alerta.") and estado = 31");
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

					$sel_item_en_preparacion_preparacion = query_db("select id_item, num1,num2,num3, t1_tipo_proceso_id,id_us from $pi2 where (num1 is null or num1 = '') and id_us in (".$id_us_alerta.") and estado = 31");
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
				
				//estado de informativo de procesos OTs
$sel_si_es = traer_fila_row(query_db("select  us_id, usuario, id_modulo, modulo, id_premiso, permiso, id_tipo_permiso, tipo_permiso, id_area, nombre_administrador from v_seg1 where us_id =".$_SESSION["id_us_session"]." and id_premiso = 38")); // verifica si tiene el permiso necesario

 if($sel_si_es[0] > 0 or $_SESSION["id_us_session"]==69){//si es admin OTs le imprime las solicitudes de OT que se encuentran en firmas

	 $sel_items_firmas_ots = query_db("select id_item, num1,num2,num3, id_gerente_ot from t2_item_pecc where estado = 16 and t1_tipo_proceso_id = 8 and (congelado = 2 or congelado is null) and t1_tipo_contratacion_id = 1");
	 
	 while($ots_sel = traer_fila_db($sel_items_firmas_ots)){
		 $numero = numero_item_pecc($ots_sel[1],$ots_sel[2],$ots_sel[3]);

					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$ots_sel[0].",'../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$ots_sel[0]."&id_tipo_proceso_pecc=3','MODULO SOLICITUDES','".$numero."',' Tarea: Verificar Firmas en el sistema', '2012-01-01',2, '".$ots_sel[4]."','')");
		 
		 
		 }
	 }


if($_SESSION["id_us_session"]==69){ //si es viviana - le pone en su inbox las OT que se enviaron al contratista
 $sel_items_ots = query_db("select id_item, num1,num2,num3, id_gerente_ot from t2_item_pecc where estado = 22 and t1_tipo_proceso_id = 8 and (congelado = 2 or congelado is null)");
 
 while($ots_sel = traer_fila_db($sel_items_ots)){
		 $numero = numero_item_pecc($ots_sel[1],$ots_sel[2],$ots_sel[3]);

					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (".$ots_sel[0].",'../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$ots_sel[0]."&id_tipo_proceso_pecc=3','MODULO SOLICITUDES','".$numero."',' Tarea: Se envio la OT al Contratista', '2012-01-01',2, '".$ots_sel[4]."','')");
		 
		 
		 }
}

//estado de informativo de procesos OTs
				
	//Fin Alertas item
	
	
	// comite
	$sel_comites_activos = query_db("select id_comite, num1,num2,num3, fecha,id_us from v_alertas_comite where id_us = ".$_SESSION["id_us_session"]." group by id_comite,  num1,num2,num3, fecha,id_us  ");
	while($comit_pendientes = traer_fila_db($sel_comites_activos)){
		$numero_comite = numero_item_pecc($comit_pendientes[1],$comit_pendientes[2],$comit_pendientes[3]);
		
		
		
		$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$comit_pendientes[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$comit_pendientes[0]."','MODULO COMITE','".$numero_comite."','Tiene Solicitudes pendientes por aprobacion', '".$comit_pendientes[5]."',3, 0,'')");
		
		}
	//fin comite
	
	//ratificacion presidente
	
	if($_SESSION["id_us_session"] == $presidente){
		$sel_comites = query_db("select id_comite, num1,num2,num3, fecha from t3_comite where presidente <> 1 and estado = 1");
		
		while($sel_com = traer_fila_db($sel_comites)){
			$numero_comite = numero_item_pecc($sel_com[1],$sel_com[2],$sel_com[3]);
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) values (	".$sel_com[0].",'../aplicaciones/comite/edicion-comite.php?id_comite=".$sel_com[0]."','MODULO COMITE','".$numero_comite."','Este Comité esta Pendiente por Verificar', '".$sel_com[4]."',3,0,'')");
			}
	}
	//FIN ratificacion presidente
	
	//urna virtual
	
	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);
	
	 $query_usr = "select pro1_proceso.pro1_id, tp2_tipo_proceso.nombre, tp6_tipo_objetos.nombre, tp5_tipo_contrato.nombre, pro1_proceso.fecha_apertura, pro1_proceso.fecha_cierre, us_usuarios.nombre_administrador, pro1_proceso.consecutivo, pro1_proceso.detalle_objeto , tp1_estado_proceso.nombre estado_procesos , pro1_proceso.us_id, pro1_proceso.cuantia,pro1_proceso.tp7_tipo_moneda,pro1_proceso.us_id_contacto 
	from tp2_tipo_proceso, tp6_tipo_objetos, tp5_tipo_contrato, us_usuarios, pro1_proceso, tp1_estado_proceso 
	where pro1_proceso.us_id_contacto = ".$_SESSION["id_us_session"]." and tp2_tipo_proceso.tp2_id = pro1_proceso.tp2_id 
	and tp6_tipo_objetos.tp6_id = pro1_proceso.tp6_id 
	and tp5_tipo_contrato.tp5_id = pro1_proceso.tp5_id 
	and us_usuarios.us_id = pro1_proceso.us_id_contacto 
	and tp1_estado_proceso.tp1_id = pro1_proceso.tp1_id 
	and pro1_proceso.tp1_id not in (5, 7, 8) order by pro1_proceso.pro1_id desc ";
	
	 $sql_ex = mysql_query($query_usr);
                while($ls=mysql_fetch_row($sql_ex)){
$muestra_proceso = 0;
 				if($ls[10]==$_SESSION["id_us_session"]){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    } //SI ES EL DUEÑO DEL PROCESO
            
                if($ls[13]==$_SESSION["id_us_session"]){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    } //SI ES EL DUEÑO DEL PROCESO
            				
			if($muestra_proceso==1){ //si se debe mostrar
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$ls[0].",'carga_urna(".$ls[0].")','MODULO URNA VIRTUAL','".$ls[7]."','Estado del proceso: $ls[9] fecha de cierre $ls[5]', '".$ls[5]."',4,0,'')");
				
				}//si se debe mostrar
				
				}
				
				mysql_close();
	
	// urna virtual
	//inicio contratos
	$arr_estado = 'null';
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$arr_estado = $arr_estado.",".$est_abastecimiento.",".$est_sap.",".$est_revision.",".$est_firma_hocol.",".$est_firma_contratista.",".$est_gerente_contrato.",".$est_legalizacion.",".$est_poliza;
	}
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=12";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$arr_estado = $arr_estado.",".$est_poliza;
	}
	
	$lista_contrato = "select * from $co1 where (analista_deloitte <> 1 or analista_deloitte IS NULL) and estado <> $est_finalizado and estado in ($arr_estado)";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[19]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[2];//consecutivo
			$numero_contrato4 = $lista_contrato[43];//apellido
			
			
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$lista_contrato[0].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0])."','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[0])."','Estado del proceso:".estado_contrato_retu(arreglo_pasa_variables($lista_contrato[0]),$co1)."', '',5,0,'')");
	}
	/* inicio modificaciones con estado individual
	$lista_contrato = "select t7c.id,t7c.id_contrato,t1t.nombre from $co4 t7c left join t1_tipo_complemento t1t on t7c.tipo_complemento=t1t.id where t7c.estado <> $est_finalizado and t7c.estado in ($arr_estado)";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) 
			values (	".$lista_contrato[1].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[1])."','CONTRATOS','".consecutivo_bl($lista_contrato[1])."','Estado del proceso:".$lista_contrato[2]." ".estado_contrato_retu(arreglo_pasa_variables($lista_contrato[0]),$co4)."', '',5)");
	}
	 fin modificaciones con estado individual*/
	 $lista_contrato = "select t7c.id_contrato,t1t.nombre,t7co.creacion_sistema,t7co.consecutivo,t7co.apellido from $co4 t7c left join t1_tipo_complemento t1t on t7c.tipo_complemento=t1t.id left join t7_contratos_contrato t7co on t7c.id_contrato=t7co.id where (congelado <> 1 or congelado IS NULL) and t7c.estado <> $est_finalizado and t7c.estado in ($arr_estado) group by t7c.id_contrato,t1t.nombre,t7co.creacion_sistema,t7co.consecutivo,t7co.apellido";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[2]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[3];//consecutivo
			$numero_contrato4 = $lista_contrato[4];//apellido
			
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$lista_contrato[0].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0])."','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[0])."','Estado del proceso:".$lista_contrato[1]." Pendiente Modificaciones', '',5,0,'')");
	}
	//fin contratos
	
	//$inserta_datos = query_db("insert into #alertas (id_proceso,destion,modulo,consecutivo,detalle) values (	1,2,'MODULO TARIFAS','C-2012-001','Tiene tarifas pendientes de aprobación')");

//crear_en_e_procurement(2);

/********************tarifas*/

//	$crea_tempo = "CREATE TABLE #alertas (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int, id_usuario int, nivel_aprobacion varchar(1000))";

$busca_arta_tarifas = "select distinct tarifas_contrato_id, consecutivo,usua_rio_proveedor from v_tarifas_responsable_aprobacion where us_id = ".$_SESSION["id_us_session"]." and estado = 1";
$query_alerta_tarifas = query_db($busca_arta_tarifas );
while($lista_al_tar=traer_fila_row($query_alerta_tarifas))
	{
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion) 
			values (	".$lista_al_tar[0].",'../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=".arreglo_pasa_variables($lista_al_tar[0])."&apro_pasa=1','TARIFAS','".$lista_al_tar[1]."','Tarifas pendientes de su aprobacion', '',6,".$lista_al_tar[2].",'')");

		
		
		}

/********************tarifas*/

$usuario_elaboracion_contrato = traer_fila_row(query_db("select count(*)  from v_seg1 where us_id=".$_SESSION["id_us_session"]. " and id_premiso=32"));
			  if($usuario_elaboracion_contrato[0]>0){// rol de tatiana
					 $muestra_columnas_nivel_aprobacion = "SI";
			 
			 }
			 
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
		
		

$sql_cuenta = traer_fila_row(query_db("select count(*) from #alertas where id_proceso >=1  $comple_alert "));
$cunatas_paginas = ($sql_cuenta[0] / $registros_pagina) +1;


?>






</head>

<body >


  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
          <td width="2%" class="esquina_s_iz">&nbsp;</td>
          <td width="95%" class="linea_sup">&nbsp;</td>
          <td width="3%"  class="esquina_s_der">&nbsp;</td>
        </tr>
        <tr>
          <td class="linea_iz">&nbsp;</td>
          <td id="contenidos" align="left"><table width="100%" border="0"  cellspacing="2" cellpadding="2">
            <tr class="titulos_secciones">
              <td class="titulos_secciones">SECCION: ALERTAS GENERALES DE LOS MODULOS</td>
            </tr>
          </table>
            <br />
            <?

?>
 <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="7" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="39%"><div align="left">Tareas pendientes encontradas:
                      <?=$sql_cuenta[0];?>

                    </div></td>
                    <td width="39%" align="right"><table width="100%" border="0">
                      <tr>
                        <td width="84%" align="right">Paginas:</td>
                        <td width="16%"><select name="paginas" id="paginas" onchange="ajax_carga('../procesos/administrador/alertas.php?paginas='+this.value+'&filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value,'carga_alertas')">
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
                <td width="15%" class="columna_subtitulo_resultados"><div align="center">Modulo</div></td>
                <td colspan="2" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
               <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?>
                <td width="15%" align="center" class="columna_subtitulo_resultados">Nivel de Aprobaci&oacute;n</td>
                <?
			   }
				?>
                <td width="15%" align="center" class="columna_subtitulo_resultados">Usuario Solicitante</td>
                <td width="27%" class="columna_subtitulo_resultados"><div align="center">Descripci&oacute;n</div></td>
                <td width="9%" class="columna_subtitulo_resultados"><div align="center">Ingresar</div></td>
              </tr>
              <tr class="filas_resultados">
                <td class="filas_resultados"><select name="filtro_modulo" id="filtro_modulo" onchange="ajax_carga('../procesos/administrador/alertas.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value,'carga_alertas')">
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
                <td width="14%" class="filas_resultados"><input type="text" name="filtro_consecutivo" id="filtro_consecutivo" value="<?=$_GET["filtro_consecutivo"]?>"  /></td>
                <td width="5%" class="filas_resultados"><img src="../imagenes/botones/busqueda.gif" style="cursor:pointer" onclick="ajax_carga('../procesos/administrador/alertas.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value,'carga_alertas');" /></td>
                <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?><td class="filas_resultados"><select name="filtro_nivel" id="filtro_nivel" onchange="ajax_carga('../procesos/administrador/alertas.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value,'carga_alertas')"><option value="0">Filtro: Todos</option>
               
               <?
                $busca_item = query_db("select nivel_aprobacion from #alertas where id_proceso >=1  group by nivel_aprobacion");	
				while($sel_niveles = traer_fila_row($busca_item)){
					
					
					?><option value="<?=$sel_niveles[0]?>" <? if($_GET["filtro_nivel"] == $sel_niveles[0]) echo 'selected="selected"';?> ><?=$sel_niveles[0]?></option><?
					}
			   ?>
               
               
               </select></td><? }else{
				   ?><input type="hidden" name="filtro_nivel" id="filtro_nivel" /><?
				   }?>
                <td class="filas_resultados"><select name="filtro_usuario" id="filtro_usuario" onchange="ajax_carga('../procesos/administrador/alertas.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value,'carga_alertas')">
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
                <td class="filas_resultados"><select name="filtro_descripcion" id="filtro_descripcion" onchange="ajax_carga('../procesos/administrador/alertas.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value,'carga_alertas')">
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
select id_proceso,destino,modulo,consecutivo,detalle, ROW_NUMBER() OVER(ORDER BY numero_modulo) AS rownum,numero_modulo,id_usuario,nivel_aprobacion from #alertas where id_proceso >=1  $comple_alert  ) as sub where rownum > $regis_inicial and rownum <= $regis_final 
order by numero_modulo asc, modulo desc";	  



	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		$usuario_solicita ="";
		$link =$ls_mr[1];
		
		if($ls_mr[2] == "MODULO SOLICITUDES" or $ls_mr[2] == "MODULO PECC" or  $ls_mr[2] == "MODULO COMITE"){
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
			}



?>

       
              <tr class="filas_resultados">
                <td class="filas_resultados"><?=$ls_mr[2];?></td>
                <td colspan="2" class="filas_resultados"><?=$ls_mr[3];?></td>
                <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?><td class="filas_resultados"><?=$ls_mr[8]?></td><?
			   }
			   ?>
                <td class="filas_resultados"><? echo $usuario_solicita;?></td>
                <td class="filas_resultados"><?=htmlentities($ls_mr[4]);?></td>
                <td class="titulos_resumen_alertas"><div align="center"> <img src="../imagenes/botones/editar.jpg" alt="" width="14" height="15" onclick='<?=$link;?>' /></div></td>
              </tr>
              <? } ?>
              <tr>
                <td colspan="7" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="78%"><div align="left">Tareas pendientes:
                      <?=$sql_cuenta[0];?>
                    </div></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          <td class="linea_der">&nbsp;</td>
        </tr>
        <tr>
          <td  class="esquina_i_iz">&nbsp;</td>
          <td  class="linea_infe">&nbsp;</td>
          <td   class="esquina_i_der">&nbsp;</td>
        </tr>
      </table>

</body>
</html>
