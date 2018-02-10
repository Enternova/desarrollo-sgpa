<? include("../../librerias/lib/@include.php");
//include("../../librerias/lib/@session.php");

function esprofesionalcompras_alertas_mail($id_item, $id_us_alerta){
	$devuelve="NO";
	global $pi2;	
	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item));	
	
	if($sel_item[14]== 7){$permiso_ad=1;}
	if($sel_item[14]== 16){$permiso_ad=2;}
	
	
	$sel_secuencia = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item." and id_rol = 30 and tipo_adj_permiso = ".$permiso_ad." and estado = 1"));
	$sel_usuario = traer_fila_row(query_db("select id_usuario from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = ".$sel_secuencia[0]." and id_usuario = 9 "));
	$sel_aprobacion = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_secuencia[0]." and aprobado = 1"));

	

	 if($id_us_alerta==$sel_usuario[0] and $sel_aprobacion[0]==0 and ($sel_item[14]==7 or $sel_item[14]==16)){
		 $devuelve="SI";
	 }
	 return $devuelve;
	}


if($_GET["frac_carga"] ==""){
	echo "<br /><br />no hay fracmento seleccionado<br /><br />";
	//exit;	
	//$comple_us_carga = " and  us_id =18084 ";
	}
	
if($_GET["frac_carga"] == 1){ $comple_us_carga = " and  us_id > 0 and us_id <= 100";}
if($_GET["frac_carga"] == 2){ $comple_us_carga = " and  us_id > 100 and us_id <= 17935";}
if($_GET["frac_carga"] == 3){ $comple_us_carga = " and  us_id > 17935 and us_id <= 17976";}
if($_GET["frac_carga"] == 4){ $comple_us_carga = " and  us_id > 17976 and us_id <= 18024";}
if($_GET["frac_carga"] == 5){ $comple_us_carga = " and  us_id > 18024 and us_id <= 18041";}
if($_GET["frac_carga"] == 6){ $comple_us_carga = " and  us_id > 18041 and us_id <= 18076";}
if($_GET["frac_carga"] == 7){ $comple_us_carga = " and  us_id > 18076 and us_id <= 18592";}
if($_GET["frac_carga"] == 8){ $comple_us_carga = " and  us_id > 18592 ";}




      
/*
	//$dropta = query_db("drop table alertas_email");
	$crea_tempo = "CREATE TABLE alertas_email (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int, id_us_alerta int)";
	$sql_te = query_db($crea_tempo);
*/

	//alertas item
	$trucate = query_db("truncate table alertas_email");
$usuarios_alertas = ",57";


$usuarios_alestras1 = query_db("select us_id from v_alertas_pecc_firmas group by us_id");
	while($sel_item2 = traer_fila_db($usuarios_alestras1)){
		if($sel_item2[0] != "") {$usuarios_alertas.= ",".$sel_item2[0];}
	}
$usuarios_alestras = query_db("select id_us from $valer_1 where id_pecc = 1 and estado < 21 and id_us not in (0".$usuarios_alertas.")  group by id_us");
	while($sel_item = traer_fila_db($usuarios_alestras)){
		if($sel_item[0] != "") {$usuarios_alertas.= ",".$sel_item[0];}
	}
$usuarios_alestras = query_db("select id_us_profesional_asignado from $valer_1 where id_pecc = 1 and estado < 21 and id_us_profesional_asignado not in (0".$usuarios_alertas.") group by id_us_profesional_asignado");
	while($sel_item = traer_fila_db($usuarios_alestras)){
		if($sel_item[0] != "") {$usuarios_alertas.= ",".$sel_item[0];}
	}
	
$usuarios_alestras = query_db("select us_id from v_seg1 where us_id not in (0".$usuarios_alertas.") and id_premiso in (26,12, 8, 27) group by us_id");
	while($sel_item = traer_fila_db($usuarios_alestras)){
		if($sel_item[0] != "") {$usuarios_alertas.= ",".$sel_item[0];}
	}


$usuarios_gestor_abaste= query_db("SELECT  t1.id_usuario, t2.nombre_administrador FROM tseg12_relacion_usuario_rol as t1, t1_us_usuarios as t2 WHERE  t1.id_usuario= t2.us_id and  t1.id_rol_general = 21 and t2.estado = 1 and  t1.id_usuario not in (0".$usuarios_alertas.")");
	while($sel_item = traer_fila_db($usuarios_gestor_abaste)){
		if($sel_item[0] != "") {$usuarios_alertas.= ",".$sel_item[0];}
	}
	
	
$usuarios_admon_tarifas = query_db("SELECT  t1.id_usuario, t2.nombre_administrador FROM tseg12_relacion_usuario_rol as t1, t1_us_usuarios as t2 WHERE  t1.id_usuario= t2.us_id and  t1.id_rol_general = 1 and t2.estado = 1 and  t1.id_usuario not in (0".$usuarios_alertas.")");
	while($sel_item = traer_fila_db($usuarios_admon_tarifas)){
		if($sel_item[0] != "") {$usuarios_alertas.= ",".$sel_item[0];}
	}

	
         
$busca_arta_tarifas = query_db("select us_id from v_tarifas_responsable_aprobacion_2 where us_id not in (0".$usuarios_alertas.") ");
while($sel_item = traer_fila_db($busca_arta_tarifas)){
		if($sel_item[0] != "") {$usuarios_alertas.= ",".$sel_item[0];}
	}

	
	$usuarios_alertas = str_replace(",,", ",",$usuarios_alertas);
	
	$usuarios_alertas_sql = str_replace(",,", ",",$usuarios_alertas);


	$sel_usuario_inicial = query_db("select us_id from t1_us_usuarios where us_id in (0 $usuarios_alertas_sql ) and estado = 1 and email <> '' $comple_us_carga");
	
	$usuarios_alertas = explode (",",$usuarios_alertas);
	
	while($sel_usu_ini = traer_fila_db($sel_usuario_inicial)){
//	for ($i = 1; $i<count($usuarios_alertas); $i++){
			

	//$id_us_alerta = $usuarios_alertas[$i];
	$id_us_alerta = $sel_usu_ini[0];
	
	
	if($id_us_alerta == 18591){
	
	$comple_sql_almace=" and t1_area_id in (17,24, 21)";
	}
	
	

/*Verifica REEMPLAZO*/
$buscar_reemplazos = query_db("select id, id_us, id_reemplazo, observacion, desde_cuando, hasta_cuando, usuario_crea, estado, fecha_creacion from tseg_reemplazos where id_reemplazo=".$id_us_alerta." and estado = 1");
	 
	 $usuarios_con_reemplazo = $id_us_alerta;
	 $usuarios_array= array($id_us_alerta);
	 $i = 1; 
	 while($b_reempla = traer_fila_db($buscar_reemplazos))  {
	  
	  $usuarios_con_reemplazo.= ",".$b_reempla[1];
	  $usuarios_array[$i]=$b_reempla[1];
		$i++;
	 }
	 
	
/*FIN verifica REEMPLAZOS*/
	
	$sele_pecc_item = query_db("select id_item, num1, num2, num3, fecha_cuando_se_agendo, descrip1, descrip2, descrip3, id_pecc, estado, congelado, t2_nivel_servicio_encargado_id, nombre, id_us, id_us_profesional_asignado, contrato_id, t1_tipo_proceso_id, t1_area_id, t1_tipo_contratacion_id from $valer_1 where id_pecc = 1 and estado not in (12.1, 12.2) and (estado < 21 or estado = 34) $comple_sql_almace");
	
	
	while($sel_item = traer_fila_db($sele_pecc_item)){
			$numero = numero_item_pecc($sel_item[1],$sel_item[2],$sel_item[3]);
			$modulo_aplica = "MODULO SOLICITUDES";
			$link_aplica_modulo = "pecc/edicion-item-pecc";
		$id_tipo_proceso_pecc = 1;
		$es_encargado = "NO";
			if($sel_item[10] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_item[10] == 8){
					$id_tipo_proceso_pecc = 3;
				}
		
		
		//BODEGA
		if($sel_item[11] == 10){
		$sel_us_bodega = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$id_us_alerta." and id_premiso = 29"));
			if($sel_us_bodega[0]>0){
				$es_encargado = "SI";
			}
		}
						
						//FIN BODEGA
						
				
		if($sel_item[11] == 1){
				if($sel_item[13] == $id_us_alerta){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 2){
				if($sel_item[14] == $id_us_alerta){
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
			if($id_us_alerta == "18041" and $sel_item[18]<>1){
			$rol_no_aplica = ",9,35";
			
			}


$sel_aprobadores_de_firmas = traer_fila_row(query_db("select id_item_pecc,id_rol from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$id_us_alerta." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol not in (10,11 ".$rol_no_aplica.")"));

		//$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$id_us_alerta." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol not in (10,11 ".$rol_no_aplica.")"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					
					if(permite_firmar_proceso_de_bienes($sel_item[0]) == "SI"){//si es diferente a servicios o es servicios menores
					
					
			$sel_si_comite = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and id_rol = 10 and tipo_adj_permiso = ".$permiso_asdj." and estado = 1"));
			
			$sel_si_vicepresidente = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and id_rol in (20, 43) and tipo_adj_permiso = ".$permiso_asdj." and estado = 1"));		
			
			$sel_si_gernte_area = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and id_rol in( 9) and tipo_adj_permiso = ".$permiso_asdj." and estado = 1"));	
									if($sel_aprobadores_de_firmas[1]==9 and  ($sel_si_comite[0]==0 and $sel_si_vicepresidente[0]==0)){		// si es jefe de area y no tiene comite	 ni viceprecidente						
										
										$sel_si_tiene_jefe_area_2 = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$id_us_alerta." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol  = 40"));
										
										if($sel_si_tiene_jefe_area_2[0] == 0){
										$es_encargado = "NO";
										}
										
										}
									
									if(($sel_aprobadores_de_firmas[1]==35 or $sel_aprobadores_de_firmas[1]==45) and  ($sel_si_vicepresidente[0]==0 and $sel_si_comite[0]==0 and $sel_si_gernte_area[0]==0)){		// si es superintendente y no tiene comite	 ni viceprecidente					
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
		//	echo "<br /><br /><br />".$sel_item[0]."-".$id_us_alerta." es el encargado".$es_encargado." es el profesional ".esprofesionalcompras_alertas_mail($sel_item[0]);			 					
						}//fin si es diferente a servicios	
					}
		}
		if($sel_item[11] == 4){

			$sel_rol_comite = traer_fila_row(query_db("select count(*) from $v_seg1 where id_modulo = 1 and id_premiso = 10 and	us_id=".$id_us_alerta));
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
		
		
			$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$id_us_alerta." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol = 11"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
		}
		
		
		if($sel_item[11] == 11){//estado elaboracion de contrato
				
				
		if($sel_item[16] == 8){//si es OT en elaboracion de contrato
			if($id_us_alerta == 18245 and $sel_item[13] == 18245){// si es tatiana
			$es_encargado = "SI";				
			}
			
			if($id_us_alerta == 57 and $sel_item[13] <> 18245){// si es amparo

			//$es_encargado = "SI";				
			}
			
			}else{// si es elaboracion de contrato de cualquier otro tipo de solicitud
				$sel_us_elaboracion_contra = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$id_us_alerta." and id_premiso = 32"));
					if($sel_us_elaboracion_contra[0]>0){
					$es_encargado = "SI";
					}		
				}
			
		
					
					
					
					
		}
		
		
		
		
		
		$contras_solic = "";
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
		
		}
		
		
		if($sel_item[9] == 34 ){
			$sel_aprobaciones_cargue_manual = traer_fila_row(query_db("select id, us_aprueba1,aprobacion1, us_aprueba2,aprobacion2, us_aprueba3, aprobacion3 from t2_verificacion_modificacion_manual where id_item = ".$sel_item[0]." "));
			if($sel_aprobaciones_cargue_manual[0]>0){//si el usuario esta en alguna de las firmas
					if($sel_aprobaciones_cargue_manual[1]==$id_us_alerta and ($sel_aprobaciones_cargue_manual[2] == "" or $sel_aprobaciones_cargue_manual[2] == "0")){//si es el primer validador
					$es_encargado = "SI";
					}
					if($sel_aprobaciones_cargue_manual[3]==$id_us_alerta and ($sel_aprobaciones_cargue_manual[4] == "" or $sel_aprobaciones_cargue_manual[4] == "0") and ($sel_aprobaciones_cargue_manual[2] != "" and $sel_aprobaciones_cargue_manual[2] != "0")){//si es el segundo validador
					$es_encargado = "SI";
					}
					if($sel_aprobaciones_cargue_manual[5]==$id_us_alerta and ($sel_aprobaciones_cargue_manual[6] == "" or $sel_aprobaciones_cargue_manual[6] == "0") and ($sel_aprobaciones_cargue_manual[2] != "" and $sel_aprobaciones_cargue_manual[2] != "0") and ($sel_aprobaciones_cargue_manual[4] != "" and $sel_aprobaciones_cargue_manual[4] != "0") ){//si es el tercero validador
					$es_encargado = "SI";
					}
				
				}
//			
			}
		
				if($es_encargado == "SI"){
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (".$sel_item[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','".$modulo_aplica."','".$numero."','Sección: ".$sel_item[6].". Tarea: ".$sel_item[7].$contras_solic."', '".$sel_item[4]."',2,'$id_us_alerta')");
				}
				
		}	
		//VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				$sel_usu_emulan = query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$id_us_alerta);
				$cuantos = 0;
				while($us_emunlados = traer_fila_db($sel_usu_emulan)){
						$strin_emulado = $strin_emulado.$us_emunlados[2].",";
						$cuantos = 1;
					}
					
					if($cuantos == 1){
						$id_us_alerta = $strin_emulado."0";
						}else{
								$id_us_alerta = $id_us_alerta;
							}
				$sel_item_en_preparacion_devuelto = query_db("select id_item, num1,num2,num3 from $pi2 where num1 <> '' and id_us in (".$id_us_alerta.") and estado = 31");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_devuelto)){
					$numero = numero_item_pecc($sel_devueltos_31[1],$sel_devueltos_31[2],$sel_devueltos_31[3]);
					$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','".$numero."','Sección: Solicitud de Permiso. Tarea: Ajustar por Devolución', '2012-01-01',2,'$id_us_alerta')");
					}
						
					$sel_item_en_preparacion_preparacion = query_db("select id_item, num1,num2,num3 from $pi2 where (num1 is null or num1 = '') and id_us in (".$id_us_alerta.") and estado = 31");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_preparacion)){
					
					
					
					$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','','Sección: Solicitud de Permiso. Tarea: En Preparación', '2012-01-01',2,'$id_us_alerta')");
					}
					
				//Fin VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				
				
	//Fin Alertas item
	

	// comite
	$sel_comites_activos = query_db("select id_comite, id_item, num1,num2,num3, fecha from v_alertas_comite where id_us = ".$id_us_alerta." group by id_comite, id_item, num1,num2,num3, fecha  ");
	while($comit_pendientes = traer_fila_db($sel_comites_activos)){
		
		$numero_comite = numero_item_pecc($comit_pendientes[2],$comit_pendientes[3],$comit_pendientes[4]);
		
		$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (	".$comit_pendientes[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$comit_pendientes[0]."','MODULO COMITE','".$numero_comite."','Tiene Solicitudes pendientes por aprobacion', '".$comit_pendientes[5]."',3,'$id_us_alerta')");
		
		}
	//fin comite
	
	//ratificacion presidente
	
	if($id_us_alerta == $presidente){
		$sel_comites = query_db("select id_comite, num1,num2,num3, fecha from t3_comite where (presidente is null or presidente =0) and estado = 1");
		
		while($sel_com = traer_fila_db($sel_comites)){
			$numero_comite = numero_item_pecc($sel_com[1],$sel_com[2],$sel_com[3]);
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (	".$sel_com[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$sel_com[0]."','MODULO COMITE','".$numero_comite."','Este Comit&eacute; esta Pendiente por Verificar', '".$sel_com[4]."',3,'$id_us_alerta')");
			}
	}
	//FIN ratificacion presidente
	
	//urna virtual
	
if( $id_us_alerta != 0){//NO aplica urna para los usuarios	para vicky
	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);
	
	$concate_id_urna="";
	$apariciurna="";
	$comple_invotad_urna="";
	 $busca_invitaciones = "select distinct pro1_id from v_vista_invitados_observadores where us_id = ".$id_us_alerta." and estado = 1 and tipo = 2";	
$sql_invitados = mysql_query($busca_invitaciones);
while($bus_invo=mysql_fetch_row($sql_invitados))
		{
			$apariciurna+=1;
			$concate_id_urna.=",".$bus_invo[0];
		}
		if($apariciurna>=1){
		
		$comple_invotad_urna = "  or pro1_proceso.pro1_id in (0 $concate_id_urna)";
		
		}
	 $complemento_bus_inbox_urna= "  (pro1_proceso.us_id_contacto = ".$id_us_alerta." or pro1_proceso.us_id = ".$id_us_alerta."   $comple_invotad_urna) " ;
		
	
	
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
$muestra_proceso = 1;
 			
            
			$textr_alert = "Estado del proceso: $ls[9] fecha de cierre $ls[5]";
			
			$busca_invitaciones_tecnco = "select count(*) from v_vista_invitados_observadores where pro1_id = $ls[0] and us_id in (".$_SESSION["usuarios_con_reemplazo"].") and estado = 1";	
				$sql_invitados_tec = mysql_fetch_row(mysql_query($busca_invitaciones_tecnco));

				
				if($sql_invitados_tec[0]>=1){
					$textr_alert = "Tarea: Evaluar ofertas t&eacute;cnicas";
					}
							
			if($muestra_proceso==1){ //si se debe mostrar
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) 
			values (	".$ls[0].",'carga_urna(".$ls[0].")','MODULO URNA VIRTUAL','".$ls[7]."','$textr_alert', '".$ls[5]."',4,'$id_us_alerta')");
				
				}//si se debe mostrar
				
				}
				
				mysql_close();
}//NO aplica urna para los usuarios	
	// urna virtual
	
	
	//*************************--------inicio contratos--------****************************
	$arr_estado = 'null';
	
	
	
	
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$contratos_por_usario="0";
	$sel_contratos_gestiona = query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$id_us_alerta);
	while($sel_con = traer_fila_db($sel_contratos_gestiona)){
				$contratos_por_usario.= ",".$sel_con[2];		
		}
		
		
	$contratos_por_usario_soport_des ="0";
	$sel_contratos_gestiona_sopo = query_db("select id_gerente from v_relacion_soportedes_gerente where id_soporte_des = ".$id_us_alerta);
	while($sel_con_sop = traer_fila_db($sel_contratos_gestiona_sopo)){
				$contratos_por_usario_soport_des.= ",".$sel_con_sop[0];		
		}
		
		
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
		
		
	$detalle_pendiente="";
		
$sel_permisos_par_cotnratos = query_db("select id_rol_general from tseg12_relacion_usuario_rol where id_usuario=".$id_us_alerta." and id_rol_general in (21, 24, 1026, 25, 26, 7)");
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
	$complet.= " OR (f_fin_garantia_fir_rep = ' ' or f_fin_garantia_fir_rep = '' or f_fin_garantia_fir_rep is null) and (f_ini_garantia_fir_rep is not null and f_ini_garantia_fir_rep <> '' and f_ini_garantia_fir_rep <> ' '))";
	
	$detalle_pendiente = "Aseguramiento Administrativo:";
	}
	if($rec_cont[0]==1026){//si es el rol profesional de aseguramoento
	$complet = " and (f_fin_garantia_sol_inf = ' ' or f_fin_garantia_sol_inf = '' or f_fin_garantia_sol_inf is null) and (f_ini_garantia_sol_inf is not null and f_ini_garantia_sol_inf <> '' and f_ini_garantia_sol_inf <> ' ')";
	$detalle_pendiente = "Solicitar/Confirmar la creacion de la Fiducia en Par Servicios y SAP.";
	}
	if($rec_cont[0]==7){//si es el rol gestion polizas
	$complet = " and (f_fin_revision_polizas = ' ' or f_fin_revision_polizas = '' or f_fin_revision_polizas is null) and (f_ini_revision_polizas is not null and f_ini_revision_polizas <> '' and f_ini_revision_polizas <> ' ')";
		$complet_polizas_contr.= " and garantia_seguro in (1, 0, NULL) ";
		$complet_polizas_modi.= " and ((tipo_complemento = 1 and garantia_seguro in (1, 0, NULL)) or (tipo_complemento = 2 and garantia_seguro = 2))";
		$detalle_pendiente = "Revisión de Polizas";
	}
	if($rec_cont[0]==25){//si es el rol soporte descentralizado
	
	$sel_si_prof_compras = query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario=".$id_us_alerta." and id_rol_general in (17)");
	if($sel_si_prof_compras[0]>0){
	$complet.= " and especialista =".$id_us_alerta;	
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
	}
	if($i == 2){
		$vista = "v_contratos_alerta_modificaciones";
		$comple_modificacion = ", id_modificacion";
	}

$lista_contrato_sql ="select id,creacion_sistema,consecutivo, apellido, f_ini_firma_rep_legal, f_fin_firma_rep_legal, f_fin_entrega_doc_contrac, f_fin_elabora_pedido, f_fin_aproba_sap, f_fin_garantia_dili_form, f_fin_garantia_fir_rep, f_ini_rev_estrategia,f_fin_rev_estrategia".$comple_modificacion." from ".$vista." where id = id ".$complet;


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
				
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) 
			values (	".$lista_contrato[0].",'','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[0])."','".$detalle_pendiente_inicio.$detalle_pendiente.$detalle_pendiente_comple.$detalle_pendiente2."', '',5,$id_us_alerta)");
	}
	}//fin FOR Contrato Modificacion
	}//si tiene pendientes de legalizacion
}//fin while
	

//*************************--------FIN contratos--------****************************		
			
	
	
	
	
	
	
	/********************tarifas*/

//	$crea_tempo = "CREATE TABLE #alertas (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int, id_usuario int, nivel_aprobacion varchar(1000))";

$busca_arta_tarifas = "select distinct tarifas_contrato_id, consecutivo,usua_rio_proveedor from v_tarifas_responsable_aprobacion_2 where us_id = ".$id_us_alerta." ";
$query_alerta_tarifas = query_db($busca_arta_tarifas );
while($lista_al_tar=traer_fila_row($query_alerta_tarifas))
	{
					$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) 
			values (	".$lista_al_tar[0].",'../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=".arreglo_pasa_variables($lista_al_tar[0])."&apro_pasa=1','TARIFAS','".$lista_al_tar[1]."','Tarifas pendientes de su aprobacion', '',6,".$id_us_alerta.")");

		}

$busca_tarifas_parciales = "select distinct tarifas_contrato_id, consecutivo,especialista from v_tarifas_contratos_parcial where especialista = ".$id_us_alerta." ";
$sqlbusca_tarifas_parciales = query_db($busca_tarifas_parciales );
while($tarifa_parcial=traer_fila_row($sqlbusca_tarifas_parciales))
	{
					$inserta_datos = query_db("insert into alertas_email(id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) 
			values (	".$tarifa_parcial[0].",'','TARIFAS','".$tarifa_parcial[1]."','Contrato Pendiente de Poner en Firme', '',6,".$id_us_alerta.")");

		}



/*tarifas - contratos sin trifas*/

$sel_si_es_admon_tartifas = traer_fila_row(query_db("SELECT  count(*) FROM tseg12_relacion_usuario_rol WHERE    id_rol_general = 1 and  id_usuario = ".$id_us_alerta));
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
			
			
					$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) 
			values (	".$lista_al_tar[0].",'','TARIFAS','".$consecutivo_contrato."','Contrato Sin Tarifas', '',6,'".$id_us_alerta."')");

		}
}/*tarifas - contratos sin trifas*/

/********************tarifas*/
	
	
	
	

	}// fin FOR que selecciona los usuarios con alertas

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="0" />
 <meta http-equiv="Pragma" content="no-cache" />
<title><?=TITULO;?></title>





</head>

<body >

<div id="cargando_pecc"  style="display:none"><table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/cargando2.gif" width="320" height="250" /></td></table></div>

<?


//$hasta_donde = count($usuarios_alertas);
//$hasta_donde = 2;//comentrarisr este

$sel_usuario_fin = query_db("select us_id from t1_us_usuarios where us_id in (0 $usuarios_alertas_sql ) and estado = 1 and email <> '' $comple_us_carga");
	
while($sel_usu_fin = traer_fila_db($sel_usuario_fin)){

//for ($i = 1; $i<$hasta_donde; $i++){
	$us_aletr = $sel_usu_fin[0];
	//$us_aletr = 17977;//comentariar este
	
	$conte_tex="";
	 $busca_si_tiene = traer_fila_row(query_db("select count(*) from alertas_email where id_us_alerta = '".$us_aletr."'  $complemento "));
	if($busca_si_tiene[0]>0){
	
	$sel_us = traer_fila_row(query_db("select * from t1_us_usuarios where us_id = ".$us_aletr));

$conte_tex = '
Cordial Saludo, '.$sel_us[1].'.<br><br> 
Ud,  tiene tareas por completar en la Herramienta de Abastecimiento SGPA, por favor ingrese desde el escritorio de su PC  o a trav&eacute;s de www.abastecimiento.hocol.com.co; a continuaci&oacute;n resumen de Tareas por completar: 


<table width="100%" border="0" cellpadding="2" cellspacing="2" style=" margin:10px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;">
  <tr>
    <td width="20%" style=" height:20px;font-size:14px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#DDDDDD"><div align="center">Modulo</div></td>
    <td width="15%" style=" height:20px;font-size:14px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#DDDDDD"><div align="center">Consecutivo</div></td>
    <td width="58%" style=" height:20px;font-size:14px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#DDDDDD"><div align="center">Descripci&oacute;n</div></td>
  </tr>';



 $busca_item = "
select id_proceso,destino,modulo,consecutivo,detalle, ROW_NUMBER() OVER(ORDER BY numero_modulo) AS rownum,numero_modulo from alertas_email where id_proceso >=1  and id_us_alerta = '".$us_aletr."'  $complemento   order by numero_modulo asc, modulo desc";	  


	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		
$conte_tex.= '<tr style="background:#DBFBDC">
    <td style="background:#DBFBDC">'.$ls_mr[2].'</td>
    <td style="background:#DBFBDC">'.$ls_mr[3].'</td>
    <td style="background:#DBFBDC">'.htmlentities($ls_mr[4]).'</td>
  </tr>';
  
   } 
 $conte_tex.='</table>';

//Envio_email
$correo_destino=$sel_us[4];
//$correo_destino="abastecimiento@hcl.com.co";
$asunto_msn="SGPA Notificaciones $fecha";
$cuerpo =$conte_tex;
echo $correo_destino;
echo $cuerpo;
$mail = new PHPMailer();
$mail->IsSMTP(); 
$mail->SMTPAuth = false; 
$mail->SMTPSecure = "";
$mail->Port       = 25; 
$mail->Username = $correo_autentica_phpmailer; 
$mail->Password = $contrasena_autentica_phpmailer; 
$mail->Host = $servidor_phpmailer;
$mail->From = $correo_from_phpmiler;
$mail->FromName = $nombre_from_phpmiler;


$mail->Subject = $asunto_msn;
$mail->AddAddress($correo_destino,$nombre);
//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
//$mail->AddCC("ferney.sterling@enternova.net");
$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
//$mail->AddBCC($correo_dvrnet2);//copia oculta
//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
//$mail->AddAttachment("files/demo.zip", "demo.zip");
$mail->Body = $cuerpo;
$mail->AltBody = "SGPA Informaciones";
$mail->Send();//JEISON comentariar para no enviar ningun email de prueba
// FIN Envio_email




	}
}//for
?>
</body>
</html>
<script>
function CloseWin(){
window.open('','_parent','');
window.close(); 
}
CloseWin()
</script>