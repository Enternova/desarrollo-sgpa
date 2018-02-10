	<?php

/***************************************************/
/**** Enternova SAS - 2015                     *****/
/**** funciones_general_2015.php               *****/
/**** Segundo Archivo de funciones generales   *****/
/**** Este archivo se incluira como libreria   *****/
/**** general                                  *****/
/**** Archivo principal: funciones_general.php *****/
/***************************************************/


/*Variable del valor maximo anual para los servicios menores*/
$_SESSION["valor_maximo_ser_menor"] = 24999;
/*Variable del valor maximo anual para los servicios menores*/

function configuracion_de_firmas($id_item_pecc, $tipo_adj_permiso){
	global $pi2, $pi14, $pi15, $pi16, $pi17, $vpeec13, $vpeec14, $trae_id_insrte, $presidente, $co1, $pi8, $pi8, $g15, $pi12, $fecha;//el presidente esta en la hoja db_tablas.php
	
		$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	/*para calcular las aprobacion*/
	$gerente_solicitante = $sel_item[3];
	if($sel_item[6] == 8 and $sel_item[42] != ""){
		$gerente_solicitante = $sel_item[42];
		}	
	/*FIN para calcular las aprobacion*/
	
	// verifica si hay accion del profesional de C&C
	

								
									
			$sel_para_eliminar = query_db("select * from $pi14 where id_item_pecc=".$id_item_pecc." and tipo_adj_permiso = ".$tipo_adj_permiso);
			while($elim1 = traer_fila_db($sel_para_eliminar)){// si hay algo creado eliminar las firmas
				$dele_pro_sistem_us = query_db("delete from $pi15 where id_secuencia_solicitud =".$elim1[0]);
				$dele_pro_sistem_us = query_db("delete from $pi16 where id_secuencia_solicitud =".$elim1[0]);		
				}
				$aprobacion_us = "";
			$dele_pro_sistem = query_db("delete from $pi14 where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso = ".$tipo_adj_permiso);
			
			
			
//configura jefaturas

if($_SESSION["id_us_session"] == 32){
	//echo "select count(*) from tseg14_relacion_usuario_superintendente where id_us=".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5])." ";
	}

			$sele_si_aplica_jefatura = traer_fila_row(query_db("select count(*) from tseg14_relacion_usuario_superintendente where id_us=".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5])." "));
			$sel_si_tiene_comite_vice_direc = traer_fila_row(query_db("select count(*) from $vpeec13 where id_item = ".$id_item_pecc." and id_rol_permiso in (10,45,43,20)"));	
			if($sele_si_aplica_jefatura[0] > 0){		
			$sel_valor_solicitud = traer_fila_row(query_db("select sum (eq_usd) from v_pecc_n_servicio_2 where id_item = ".$id_item_pecc));
			$rol_jefe_no_aplica="";
			
				if(($sel_valor_solicitud[0]<=30000 and $sel_item[6] != 1) or ($sel_item[6] == 8)){
						$rol_jefe_no_aplica = " and id_rol_permiso not in (9)";	
				}
						$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 45,6,1,1,".$tipo_adj_permiso.")";
						$sql_ex=query_db($insert.$trae_id_insrte);
						$id_ingreso = id_insert($sql_ex);	
						$sele_pro_sistem_usuarios = query_db("select id_superintendente from tseg14_relacion_usuario_superintendente where id_us=".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5])." group by id_superintendente");	
						while($sel_p_sist_us = traer_fila_db($sele_pro_sistem_usuarios)){	
			$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado, id_usuario_original) values (".$id_ingreso.", ".cual_es_el_reemplazo($sel_p_sist_us[0]).",1, '".$sel_p_sist_us[0]."')");
						$agrego_jefatura = "SI";
						}				
			}
//-----Fin------ si tiene jefaturas
/*SI TIENE AREAS/PROYECTO UNA DIFERENTE DE CORPORATIVO DEBE SELECCIONAR OBLIGATORIO GERENTE DE ACTIVO*/
			$sel_proyectos = traer_fila_row(query_db("select count(*) from t2_presupuesto where t1_campo_id != 1 and t2_item_pecc_id = ".$id_item_pecc));
			if($sel_proyectos[0] >=1 and $sel_item[6] != 8){//si tiene campos diferentes a corporativo incluya gerente de activo
		$insert = query_db("insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 16,8,1,1,".$tipo_adj_permiso.")");
				}
/*-----FIN---- SI TIENE AREAS/PROYECTO UNA DIFERENTE DE CORPORATIVO DEBE SELECCIONAR OBLIGATORIO GERENTE DE ACTIVO*/
/*SI ES NEG. DIRECTA, LICIACION ADJUDICACION DIRECTA PIDA OBLIGATORIO EL PAR TECNICO*/
if($sel_item[6]==1 or $sel_item[6]==2 or $sel_item[6]==3 or $sel_item[6]==6){
	$insert = query_db("insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 17,8,1,1,".$tipo_adj_permiso.")");
	}

/*-+-----FIN-----SI ES NEG. DIRECTA, LICIACION ADJUDICACION DIRECTA PIDA OBLIGATORIO EL PAR TECNICO*/
/*AGREGA FIRMAS EXCLUCIVAS DE ADJUDICACION - OTROSI, OT, AMPLIACIONES*/
if($tipo_adj_permiso == 2){
/*si es una OT la cual es a un contrato que tambien tiene bienes y la tiene el rol de paula, este debe conllevar la aprobacion del profesional cyc2*/
if($sel_item[6] == 8 and $sel_item[23] == 18433){
$selec_tipo_contras = traer_fila_row(query_db("select count(*) from t7_contratos_contrato where id_item = ".$sel_item[26]." and tipo_bien_servicio = 'Bienes'"));
	
	if($selec_tipo_contras[0] > 0){
			$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 39,3,1,1,2)";
			$sql_ex=query_db($insert.$trae_id_insrte);
			$id_ingreso = id_insert($sql_ex);
		}
	}
/*si es una OT la cual es a un contrato que tambien tiene bienes y la tiene el rol de paula, este debe conllevar la aprobacion del profesional cyc2*/

/*SI TIENE tiene evaluacion en la urna*/
			/*SI TIENE tiene evaluacion en la urna virtual evaluador tecnico*/
if($sel_item[28] == 1){
	$sel_gestion_tecnico_urna = traer_fila_row(query_db("select id_usua from t2_nivel_servicio_gestiones where id_item = ".$id_item_pecc." and t2_nivel_servicio_actividad_id = '12.2' and estado = 1 and id_usua not in (19, 18131, 18463, 51, 18433, 9, 3, 4, 30, 7)"));
	if($sel_gestion_tecnico_urna[0] > 0){
			$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 47,2,1,1,2)";
			$sql_ex=query_db($insert.$trae_id_insrte);
			$id_ingreso = id_insert($sql_ex);
			$insert_us = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_gestion_tecnico_urna[0].",1)");
		}
	}

		if($sel_item[6] == 4 or $sel_item[6] == 5){	//aprobacion de otrosi si no es el gerente			
				$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$sel_item[21]));				
				if($sel_si_es_gerente[0] != $sel_item[3]){	
					$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 23,3,1,1,2)";
						$sql_ex=query_db($insert.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);				
				$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_si_es_gerente[0].",1)");					
					}
				}// FINaprobacion de otrosi si no es el gerente			
			if($sel_item[6] == 8 ){//si es ot
				$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));				
				$sel_contr = query_db("select t1.t7_contrato_id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
				$sel_apl = traer_fila_db($sel_contr);				
				$id_contrato = $sel_apl[0];				
				$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$id_contrato));				
				if($sel_si_es_gerente[0] != $sel_item[42]){		
				$permite_eliminar_gerente_contrato="NO";			
					$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 23,3,1,1,2)";
						$sql_ex=query_db($insert.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);				
				$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_si_es_gerente[0].",1)");
					}
				}//FIN si es ot
			if($sel_item[6] == 7 ){//si es ampliacion 
				$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));				
				$sel_contr = query_db("select t1.t7_contrato_id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
				$sel_apl = traer_fila_db($sel_contr);				
			$id_contrato = $sel_apl[0];				
				$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$id_contrato));				
				if($sel_si_es_gerente[0] != $sel_item[3]){		
				$permite_eliminar_gerente_contrato="NO";			
					$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 23,3,1,1,2)";
						$sql_ex=query_db($insert.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_si_es_gerente[0].",1)");
					
					}
				}//FIN si es ampliacion
			
}
/*FIN AGREGA FIRMAS EXCLUCIVAS DE ADJUDICACION - OTROSI, OT, AMPLIACIONES*/			
// RECORRE LAS FIRMAS SEGUN LA VISTA

			$sele_pro_sistem = query_db("select id_rol_permiso, orden from $vpeec13 where id_item = ".$id_item_pecc." ".$rol_jefe_no_aplica." and id_rol_permiso not in (0) group by id_rol_permiso, orden order by orden");
			while($sel_p_sist = traer_fila_db($sele_pro_sistem)){
				$id_ingreso=0;	
				
				$sel_si_ya_tiene_rol= traer_fila_row(query_db("select id_secuencia_solicitud from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_sist[0]." and tipo_adj_permiso = ".$tipo_adj_permiso));
				if($sel_si_ya_tiene_rol[0]==0){
				$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", ".$sel_p_sist[0].",".$sel_p_sist[1].",1,1,".$tipo_adj_permiso.")";
				
				$sql_ex=query_db($insert.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				}else{
					$id_ingreso = $sel_si_ya_tiene_rol[0];
					}
				
				if($sel_p_sist[0] == 31){//SI ES profesional de compras- HASTA EL MOMENTO ESTE ROL SE ELIMINO
					$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", 17967,1)");
					}
				$sele_pro_sistem_usuarios = query_db("select us_id from $vpeec14 where id_item = ".$id_item_pecc." and id_rol_permiso = '".$sel_p_sist[0]."' group by us_id");	
				if($sel_p_sist[0] == 15){//SI ES EL ROL GERENTE CREAR, EL GERENTE EN EL ROL
					$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_item[3].",1)");					
					if($aprobacion_us == ""){
					$sele_gestion_para_aprobacion_usuario = traer_fila_row(query_db("select fecha_real from $pi17 where id_item = ".$id_item_pecc." and t2_nivel_servicio_actividad_id < 6 and estado = 1"));
					$aprobacion_us = $sele_gestion_para_aprobacion_usuario[0];
					$sele_usuario_ulti_poen_firme = traer_fila_row(query_db("select id_usua from t2_nivel_servicio_gestiones where id_item = ".$sel_item[0]." and t2_nivel_servicio_actividad_id = 1 and estado = 1 order by t2_gestion desc"));					
					$insert_aprobacion = query_db("insert into $pi16 (id_secuencia_solicitud,id_us,fecha,aprobado, observacion) values (".$id_ingreso.",".$sele_usuario_ulti_poen_firme[0].",'".$aprobacion_us."', 1, 'Declaro que no tengo conflicto de intereses')");			
					}					
					}// FIN SI ES EL ROL GERENTE CREAR, EL GERENTE EN EL ROL
				if($sel_p_sist[0] == 8 and $sel_item[23] <> ""){//SI ES EL ROL profesional
					$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_item[23].",1)");			
					}	
					
					
			if($sel_p_sist[0] == 20){//SI ES EL ROL viceprecidente
			$secuencia_viceprecidente = $id_ingreso;
			$sel_si_ya_tiene_vice = traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = 20 and tipo_adj_permiso = ".$tipo_adj_permiso));
				if($sel_si_ya_tiene_vice[0]<=1){
					$sele_pro_sistem_usuarios = query_db("select id_vicepresidente from tseg15_relacion_usuario_vicepresidente where id_us = ".$sel_item[3]." and area = ".$sel_item[5]." group by id_vicepresidente");	
						while($sel_p_sist_us = traer_fila_db($sele_pro_sistem_usuarios)){	
						$dele_us_director = query_db("delete from $pi15  where id_secuencia_solicitud = ".$id_ingreso);
						$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado, id_usuario_original) values (".$id_ingreso.", ".cual_es_el_reemplazo($sel_p_sist_us[0]).",1,'".$sel_p_sist_us[0]."')");		
						$tiene_usuario_vice="SI";
						}
				}						
				}			
				
				if($sel_p_sist[0] == 43){//SI ES EL ROL director
				$secuencia_director = $id_ingreso;
				$sel_si_ya_tiene_director = traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = 43 and tipo_adj_permiso = ".$tipo_adj_permiso));
				if($sel_si_ya_tiene_director[0] <= 1){
					$sele_pro_sistem_usuarios = query_db("select id_director from tseg15_relacion_usuario_director where us_id = ".$sel_item[3]." and id_area = ".$sel_item[5]." group by id_director");	
						while($sel_p_sist_us = traer_fila_db($sele_pro_sistem_usuarios)){	
						$dele_us_director = query_db("delete from $pi15  where id_secuencia_solicitud = ".$id_ingreso);
						$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado, id_usuario_original) values (".$id_ingreso.", ".cual_es_el_reemplazo($sel_p_sist_us[0]).",1, '".$sel_p_sist_us[0]."')");	
						$tiene_usuario_director="SI";	
						}
				}
				}
				
				if($sel_p_sist[0] == 43 ){
				if($sel_item[5]==37  or $sel_item[5]==38 or $sel_item[5]==36 or $sel_item[5]==52){//IDENTIFICA SI ES VICE O DIRECTOR SEGUN EL AREA
								$dele_rol_vicepres = query_db("delete from t2_agl_secuencia_solicitud where id_secuencia_solicitud=".$secuencia_viceprecidente);
								}else{//segun el area aplica vicepresidente, debe eliminar director 
								$dele_rol_director = query_db("delete from t2_agl_secuencia_solicitud where id_secuencia_solicitud=".$secuencia_director);	
									}//IDENTIFICA SI ES VICE O DIRECTOR	
									
									/*pone firma del precidente*/
					if($tiene_usuario_vice == "" and $tiene_usuario_director==""){
					$dele_rol_vicepres = query_db("delete from t2_agl_secuencia_solicitud where id_secuencia_solicitud in (".$secuencia_viceprecidente.",".$secuencia_director.")");					
					$dele_rol_vicepres = query_db("delete from t2_agl_secuencia_solicitud where id_rol = 48 and id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso= ".$tipo_adj_permiso );	
									
					$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 48,10,1,1,".$tipo_adj_permiso.")";
					$sql_ex=query_db($insert.$trae_id_insrte);
					$id_ingreso_president = id_insert($sql_ex);
					
					$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado, id_usuario_original) values (".$id_ingreso_president.", ".cual_es_el_reemplazo($presidente).",1, '".$presidente."')");
							
							
								
						}
									/*FIN pone firma del precidente*/
									
				}
				
				if($sel_p_sist[0] == 42 and $sel_item[23] <> ""){//SI ES EL ROL PREAPROVAR sap
					$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_item[23].",1)");			
					}
					if($sel_p_sist[0] == 11 and $sel_item[23] <> ""){//SI ES EL ROL Socios
					//$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_item[23].",1)");			
//					$sele_pro_sistem_usuarios = query_db("select us_id from $v_seg1 where id_premiso = 11");
					}
					if($sel_p_sist[0] == 10){//SI ES EL ROL comite
					$sele_pro_sistem_usuarios = query_db("select us_id from $v_seg1 where id_premiso = 10 and us_id <> 32  group by us_id");
					}					
/*  *******------------ ***************--------------Niveles de JEFE DE AREA*******------------ ***************--------------*/	

							
					if($sel_p_sist[0]==9){
						$sele_si_gerente_area = traer_fila_row(query_db("select count(*) from tseg13_relacion_usuario_jefe where id_us=".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5])." "));					
					if($sele_si_gerente_area[0]>0){//SI EN LA RELACION EL USUARIO TIENE GERENTE/JEFE DE AREA
					$sele_pro_sistem_usuarios = query_db("select id_jefe_area from tseg13_relacion_usuario_jefe where id_us = ".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5])." group by id_jefe_area");	
						while($sel_p_sist_us = traer_fila_db($sele_pro_sistem_usuarios)){	
			$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado, id_usuario_original) values (".$id_ingreso.", ".cual_es_el_reemplazo($sel_p_sist_us[0]).",1, '".$sel_p_sist_us[0]."')");		
							}						
					}else{//SI EL USUARIO EN EL A REALCXAION NO TIENE JEFE/GEREMNTE DE AREA
							$dele_no_aplica = query_db("delete from t2_agl_secuencia_solicitud where id_secuencia_solicitud = ".$id_ingreso);//elimina la firma de gerentede area por que el usuarion no la tiene relacionada para el area
							/* --------- VICEPRESIDENTE  ------------------*/							
							$sele_si_vice = traer_fila_row(query_db("select count(*) from tseg15_relacion_usuario_vicepresidente where id_us=".$gerente_solicitante." and area = ".antiguo_area_emula($sel_item[5])." "));
							if($sele_si_vice[0]>0){
							$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 20,10,1,1,".$tipo_adj_permiso.")";
							$sql_ex=query_db($insert.$trae_id_insrte);
							$id_ingreso_vice = id_insert($sql_ex);	
							$secuencia_viceprecidente=$id_ingreso_vice;
							$sele_pro_sistem_usuarios = query_db("select id_vicepresidente from tseg15_relacion_usuario_vicepresidente where id_us = ".$gerente_solicitante." and area = ".antiguo_area_emula($sel_item[5])." group by id_vicepresidente");	
							while($sel_p_sist_us = traer_fila_db($sele_pro_sistem_usuarios)){	
				$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado, id_usuario_original) values (".$id_ingreso_vice.", ".cual_es_el_reemplazo($sel_p_sist_us[0]).",1, '".$sel_p_sist_us[0]."')");
				$tiene_usuario_vice = "SI-v";		
					}					
								}/* --------- FIN  VICEPRESIDENTE  ------------------*/
								/* --------- DIRECTOR ------------------*/
							$sele_si_director = traer_fila_row(query_db("select count(*) from tseg15_relacion_usuario_director where us_id=".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5])." "));
							
						if($sele_si_director[0]>0){//si el usuario tiene director
							$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 43,10,1,1,".$tipo_adj_permiso.")";
								$sql_ex=query_db($insert.$trae_id_insrte);
								$id_ingreso_director = id_insert($sql_ex);						
								$secuencia_director = $id_ingreso_director;
						$sele_pro_sistem_usuarios = query_db("select id_director from tseg15_relacion_usuario_director where us_id = ".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5])." group by id_director");	
								while($sel_p_sist_us = traer_fila_db($sele_pro_sistem_usuarios)){	
					$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado, id_usuario_original) values (".$id_ingreso_director.", ".cual_es_el_reemplazo($sel_p_sist_us[0]).",1, '".$sel_p_sist_us[0]."')");	
					$tiene_usuario_director = "SI-d";
							}
						}	/* --------- fin DIRECTOR ------------------*/
				}
		}			
	/* *******------------ ***************--------------FIN Niveles de Aprobacion JEFE DE AREA*******------------ ***************--------------*/								
/*AGREGA FIRMAS EXCLUCIVAS DE ADJUDICACION - OTROSI, OT, AMPLIACIONES, SM*/	
if($tipo_adj_permiso == 2){
$sele_pro_sistem_usuarios = query_db("select us_id from $vpeec14 where id_item = ".$id_item_pecc." and id_rol_permiso = '".$sel_p_sist[0]."' group by us_id");	
	$sel_si_es_administrador_de_ots = traer_fila_row(query_db("select count(*) from v_seg1 where us_id =".$sel_item[3]." and id_premiso = 33"));
	if($sel_p_sist[0] == 34){
				if($sel_si_es_administrador_de_ots[0]>0){//SI ES EL ROL GERENTE CREAR, EL GERENTE de la ot EN EL ROL
					$insert52 = query_db("insert into t2_agl_secuencia_solicitud_usuario (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_item[42].",1)");					
					}else{
						$delete_secuencia_gerente_ot = query_db("delete from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item_pecc." and id_rol = 34");
						}// FIN SI ES EL ROL GERENTE CREAR, EL GERENTE dela ot EN EL ROL
	}
}
if($sel_p_sist[0] == 46){//SI ES EL ROL GERENTE de item 2
					$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_item[3].",1)");					
					}// FIN //SI ES EL ROL GERENTE de item 2
/*FIN AGREGA FIRMAS EXCLUCIVAS DE ADJUDICACION - OTROSI, OT, AMPLIACIONES*/	
				
					if(($sel_p_sist[0] <> 15  and $sel_p_sist[0] <> 31) and ($sel_p_sist[0] <> 8 or $sel_item[23] == "") and $sel_p_sist[0] <> 42 and $sel_p_sist[0] <> 43 and $sel_p_sist[0] <> 20 and $sel_p_sist[0] <> 9){	//CREA LOS USUARIOS ENCARGADOS		
			while($sel_p_sist_us = traer_fila_db($sele_pro_sistem_usuarios)){	
			$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sel_p_sist_us[0].",1)");
			}//fin while permiso
		}// fin CREA LOS USUARIOS ENCARGADOS
	
			
			}
//---FIN--- RECORRE LAS FIRMAS SEGUN LA VISTA

			/*valida si es vice, director o comite que tenga o Gerente o Jefatura*/
			$sele_si_tiena_vic_dir_com= traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc =".$sel_item[0]." and id_rol in (20, 43) AND tipo_adj_permiso = ".$tipo_adj_permiso));
			if($sele_si_tiena_vic_dir_com[0] > 0){
				$sele_si_tiene_jeftura= traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc =".$sel_item[0]." and id_rol in (45) AND tipo_adj_permiso = ".$tipo_adj_permiso));
				if($sele_si_tiene_jeftura[0]>0){
					$del = query_db("delete from t2_agl_secuencia_solicitud where id_item_pecc =".$sel_item[0]." and id_rol in (9) AND tipo_adj_permiso = ".$tipo_adj_permiso);
					}
				}
				
			$sele_si_tiena_comite= traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc =".$sel_item[0]." and id_rol in (10) AND tipo_adj_permiso = ".$tipo_adj_permiso));
			if($sele_si_tiena_comite[0] > 0){
				$sele_si_tiene_jeftura= traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc =".$sel_item[0]." and id_rol in (45) AND tipo_adj_permiso = ".$tipo_adj_permiso));
				$sele_si_tiene_gerente_area= traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc =".$sel_item[0]." and id_rol in (9) AND tipo_adj_permiso = ".$tipo_adj_permiso));
				
				if($sele_si_tiene_jeftura[0]>0){
					$del = query_db("delete from t2_agl_secuencia_solicitud where id_item_pecc =".$sel_item[0]." and id_rol in (9, 20, 43) AND tipo_adj_permiso = ".$tipo_adj_permiso);
					}
				if($sele_si_tiene_gerente_area[0]>0){
					$del = query_db("delete from t2_agl_secuencia_solicitud where id_item_pecc =".$sel_item[0]." and id_rol in (20, 43) AND tipo_adj_permiso = ".$tipo_adj_permiso);
					}
					
				}

			/*FIN valida si es vice, director o comite que tenga o Gerente o Jefatura*/
			
		
	
	
	}
function cual_es_el_reemplazo($id_usuario){
global $fecha;
	$sel_reemplazo = traer_fila_row(query_db("select id_reemplazo from tseg_reemplazos where estado = 1 and id_us = ".$id_usuario." and hasta_cuando >= '".$fecha."'" ));
	if($sel_reemplazo[0]>0){
		$id_usuario = $sel_reemplazo[0];
		}
	return $id_usuario;
		
	}
	
function legalizaciones_de_contratos($tipo, $id, $edita){
	
	?>
    <input type="hidden" name="tipo_check_list" id="tipo_check_list" value="<?=$tipo?>" />
    
	<table width="100%" align="center" class="tabla_lista_resultados" <? if($_GET["genera_excel"]=="si"){?> border="1" <? }?>>
            <?
        	$entro = 0;
			?>
            <tr class="fondo_3">
              <td colspan="9" align="center">LISTA DE CHEQUEO DE LA LEGALIZACION</td>
              </tr>
            <tr class="fondo_3">
              <td colspan="2" align="center">Detalle</td>
              <td width="10%" align="center">Inicio<strong style="font-size:10px"><br />
                Rol Encargado
              </strong></td>
              <td width="10%" align="center">Fin<strong style="font-size:10px"><br />
                Rol Encargado
              </strong></td>
              <td width="42%" align="center"><strong>Observaciones</strong></td>
              <td width="5%" align="center">&nbsp;</td>
              <td width="3%" align="center">Dias Estimados</td>
              <td width="2%" align="center">Dias Reales</td>
              <td width="3%" align="center">Dias  Retraso</td>
              </tr>
			  <?
	global $co1, $fecha;
	if($tipo == "contrato"){
		$id_campo_aplica = " id_contrato ";
		
		
		$busca_contrato = "select aplica_garantia, t1_tipo_documento_id, creacion_sistema, recibido_abastecimiento_e, estado, aseguramiento_admin, informe_hse, id, id, garantia_seguro, gerente_por_aseguramiento from $co1 where id =". $id;
		
		
		$sql_con=traer_fila_row(query_db($busca_contrato));
		$sql_con[7]="";//esto es por que no aplican los campos aseguramiento admin ni hse
		$sql_con[8]="";//esto es por que no aplican los campos aseguramiento admin ni hse
			
		//$busca_contrato = "select id,id_item,consecutivo,objeto,nit,contratista,contacto_principal,email1,telefono1,gerente,fecha_inicio,vigencia_mes,aplica_acta_inicio,representante_legal,email2,telefono2,especialista,monto_usd,monto_cop,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,t1_tipo_documento_id,acta_socios,recibido_poliza,camara_comercio,ok_fecha,sel_representante,legalizacion_final_par,legalizacion_final_par_e,analista_deloitte,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,area_ejecucion,obs_congelado,aplica_portales,destino,aseguramiento_admin, aplica_garantia, porcentaje, en_que_momento, informe_hse, oferta_mercantil from $co1 where id =". $id;
 		
		}
		
		if($tipo == "modificacion"){
			$id_campo_aplica = " id_modificacion ";
			$busca_contrato = "select t1.id_contrato, t1.id_contrato, t1.creacion_sistema, t1.recibido_abastecimiento_e, t1.estado,t1.id_contrato, t1.id_contrato, t1.tipo_complemento, t1.tipo_otrosi, t2.garantia_seguro  from t7_contratos_complemento as t1, $co1 as t2 where t1.id_contrato = t2.id and t1.id =".$id." ";
			$sql_con=traer_fila_row(query_db($busca_contrato));
			$sel_modifica = traer_fila_row(query_db("select tipo_complemento, id_contrato, numero_otrosi from t7_contratos_complemento where id = ".$id));
			
			
			$sql_con[0]="";//esto es por que no aplican los campos aseguramiento admin ni hse
			$sql_con[1]="";//esto es por que no aplican los campos aseguramiento admin ni hse
			$sql_con[5]="";//esto es por que no aplican los campos aseguramiento admin ni hse
			$sql_con[6]="";//esto es por que no aplican los campos aseguramiento admin ni hse
		}
		
		


		
		
		
		$id_contrato_arr=$id;
	
	
	
	$campos_tabla = " id, ".$id_campo_aplica.", f_ini_creacion_sistema, f_fin_creacion_sistema, CONVERT(text,creacion_sistema_ob), f_ini_elaboracion, f_fin_elaboracion, CONVERT(text,elaboracion_ob) as elaboracion_ob, 
                         f_ini_recibido_ini_proceso, f_fin_recibido_ini_proceso, CONVERT(text,recibido_ini_proceso_ob) as recibido_ini_proceso_ob, f_ini_firma_rep_legal, f_fin_firma_rep_legal, CONVERT(text,firma_rep_legal_ob) as firma_rep_legal_ob, 
                         f_ini_capacida_contratis, f_fin_capacida_contratis, CONVERT(text,capacida_contratis_ob) as capacida_contratis_ob, f_ini_recibido_pol, f_fin_recibido_pol, CONVERT(text,recibido_pol_ob) as recibido_pol_ob, f_ini_pago_pol,
						 f_fin_pago_pol, CONVERT(text,pago_pol_ob) as pago_pol_ob, f_ini_rev_legal, f_fin_rev_legal, CONVERT(text,rev_legal_ob) as rev_legal_ob, f_ini_ver_rut, f_fin_ver_rut, CONVERT(text,ver_rut_ob) as ver_rut_ob, f_ini_rev_estrategia, f_fin_rev_estrategia, CONVERT(text,rev_estrategia_ob) as rev_estrategia_ob, 
                         f_ini_aprob_sap, f_fin_aprob_sap, CONVERT(text,aprob_sap_ob) as aprob_sap_ob, f_ini_firma_hocol, f_fin_firma_hocol, CONVERT(text,firma_hocol_ob) as firma_hocol_ob, f_ini_envio_ej_firma, f_fin_envio_ej_firma, 
                         CONVERT(text,envio_ej_firma_ob) as envio_ej_firma_ob, f_ini_inscrip_dian, f_fin_inscrip_dian, CONVERT(text,inscrip_dian_ob) as inscrip_dian_ob, f_ini_entrega_doc_contrac, f_fin_entrega_doc_contrac, CONVERT(text,entrega_doc_contrac_ob) as entrega_doc_contrac_ob, 
                         f_ini_elabora_pedido, f_fin_elabora_pedido, CONVERT(text,elabora_pedido_ob) as elabora_pedido_ob, f_ini_aproba_sap, f_fin_aproba_sap, CONVERT(text,aproba_sap_ob) as aproba_sap_ob, f_ini_entrega_doc, f_fin_entrega_doc, 
                         CONVERT(text,entrega_doc_ob) as entrega_doc_ob, f_ini_entrega_todo, f_fin_entrega_todo, CONVERT(text,entrega_todo_ob) as entrega_todo_ob, f_ini_entre_doc_cont, f_fin_entre_doc_cont, CONVERT(text,f_ini_entre_doc_cont_ob) as f_ini_entre_doc_cont_ob,f_ini_revision_polizas, f_fin_revision_polizas, CONVERT(text,revision_polizas_ob) as revision_polizas_ob, f_ini_entreg_vobo_poliz, f_fin_entreg_vobo_poliz, CONVERT(text,entreg_vobo_poliz_ob) as entreg_vobo_poliz_ob, f_ini_garantia_recibo, f_fin_garantia_recibo, CONVERT(text,garantia_recibo_ob) as garantia_recibo_ob, 
                        CONVERT(text,garantia_recibo_ob2) as garantia_recibo_ob2, f_ini_garantia_rev_leg, f_fin_garantia_rev_leg, CONVERT(text,garantia_rev_leg_ob) as garantia_rev_leg_ob, CONVERT(text,garantia_rev_leg_ob2) as garantia_rev_leg_ob2, f_ini_garantia_env_reci, f_fin_garantia_env_reci, 
                         CONVERT(text,garantia_env_reci_ob) as garantia_env_reci_ob, CONVERT(text,garantia_env_reci_ob2) as garantia_env_reci_ob2, f_ini_garantia_dili_form, f_fin_garantia_dili_form, CONVERT(text,garantia_dili_form_ob) as garantia_dili_form_ob, CONVERT(text,garantia_dili_form_ob2) as garantia_dili_form_ob2, 
                         f_ini_garantia_fir_rep, f_fin_garantia_fir_rep, CONVERT(text,garantia_fir_rep_ob) as garantia_fir_rep_ob, CONVERT(text,garantia_fir_rep_ob2) as garantia_fir_rep_ob2, f_ini_garantia_en_cont_for, f_fin_garantia_en_cont_for, CONVERT(text,garantia_en_cont_for_ob) as garantia_en_cont_for_ob, CONVERT(text,garantia_en_cont_for_ob2) as garantia_en_cont_for_ob2";
						 
$campos_tabla.=", CONVERT(text, elaboracion_ob2) as elaboracion_ob2,
CONVERT(text, recibido_ini_proceso_ob2) as recibido_ini_proceso_ob2,
CONVERT(text, firma_rep_legal_ob2) as firma_rep_legal_ob2,
CONVERT(text, capacida_contratis_ob2) as capacida_contratis_ob2,
CONVERT(text, recibido_pol_ob2) as recibido_pol_ob2,
CONVERT(text, pago_pol_ob2) as pago_pol_ob2,
CONVERT(text, rev_legal_ob2) as rev_legal_ob2,
CONVERT(text, ver_rut_ob2) as ver_rut_ob2,
CONVERT(text, rev_estrategia_ob2) as rev_estrategia_ob2,
CONVERT(text, aprob_sap_ob2) as aprob_sap_ob2,
CONVERT(text, firma_hocol_ob2) as firma_hocol_ob2,
CONVERT(text, envio_ej_firma_ob2) as envio_ej_firma_ob2,
CONVERT(text, inscrip_dian_ob2) as inscrip_dian_ob2,
CONVERT(text, entrega_doc_contrac_ob2) as entrega_doc_contrac_ob2,
CONVERT(text, elabora_pedido_ob2) as elabora_pedido_ob2,
CONVERT(text, aproba_sap_ob2) as aproba_sap_ob2,
CONVERT(text, entrega_doc_ob2) as entrega_doc_ob2,
CONVERT(text, entrega_todo_ob2) as entrega_todo_ob2,
CONVERT(text, f_ini_entre_doc_cont_ob2) as f_ini_entre_doc_cont_ob2,
CONVERT(text, revision_polizas_ob2) as revision_polizas_ob2,
CONVERT(text, entreg_vobo_poliz_ob2) as entreg_vobo_poliz_ob2,
f_ini_garantia_tramite, f_fin_garantia_tramite,
CONVERT(text, garantia_tramite_ob) as garantia_tramite_ob,
CONVERT(text, garantia_tramite_ob2) as garantia_tramite_ob2,
f_ini_garantia_sol_inf, f_fin_garantia_sol_inf,
CONVERT(text, garantia_sol_inf_ob) as garantia_sol_inf_ob,
CONVERT(text, garantia_sol_inf_ob2) as garantia_sol_inf_ob2,
f_ini_gar_banc, f_fin_gar_banc,
CONVERT(text, gar_banc_ob) as gar_banc_ob,
CONVERT(text, gar_banc_ob2) as gar_banc_ob2,
f_ini_garantia_legal, f_fin_garantia_legal,
CONVERT(text, garantia_legal_ob) as garantia_legal_ob,
CONVERT(text, garantia_legal_ob2) as garantia_legal_ob2,

f_ini_rs_notifi, f_fin_rs_notifi,
CONVERT(text, rs_notifi_ob) as rs_notifi_ob,
CONVERT(text, rs_notifi_ob2) as rs_notifi_ob2,

f_ini_rs_elab, f_fin_rs_elab,
CONVERT(text, rs_elab_ob) as rs_elab_ob,
CONVERT(text, rs_elab_ob2) as rs_elab_ob2,

f_ini_rs_ajust_fec, f_fin_rs_ajust_fec,
CONVERT(text, rs_ajust_fec_ob) as rs_ajust_fec_ob,
CONVERT(text, rs_ajust_fec_ob2) as rs_ajust_fec_ob2,

f_ini_rs_recibi, f_fin_rs_recibi,
CONVERT(text, rs_recibi_ob) as rs_recibi_ob,
CONVERT(text, rs_recibi_ob2) as rs_recibi_ob2,

f_ini_rs_firm_hoco, f_fin_rs_firm_hoco,
CONVERT(text, rs_firm_hoco_ob) as rs_firm_hoco_ob,
CONVERT(text, rs_firm_hoco_ob2) as rs_firm_hoco_ob2,

f_ini_creacion_carp, f_fin_creacion_carp,
CONVERT(text, creacion_carp_ob) as creacion_carp_ob,
CONVERT(text, creacion_carp_ob2) as creacion_carp_ob2


";
						 
						 
			  $alerta_incompletos ="";

			  if($sql_con[0]!=1){//si aplica retencion en garantias
				  $comple_sql_leg.= " and id not in (20,1023, 1024, 1025, 1026, 1027, 1028, 1029, 2030)";
					  }
					  
				if($sql_con[1]==2){//si es un contrato marco
					  $comple_sql_leg.= " and id not in (15, 16, 17, 21)";
				}
/***********************CONVINACION DE CAMPOS QUE APLICAN PARA EL CAMPO SEGUROS Y GARANTIAS POLIZAS ************************/
				
				if(($sql_con[9]==3 or $sql_con[9]==4 or $sql_con[9]==2)){//si no aplica polizas
						if($sql_con[9]!=4){//si diferente a garantia bancarias
								$comple_sql_leg.= " and id not in (1030)";
							}			
								
						if($sel_modifica[0] == 2 and $sql_con[9]==2){//si es OT
							$comple_sql_leg.= "";
							}else{
							  $comple_sql_leg.= " and id not in (6, 7, 1021, 1022)";
							}
				}else{
					//no incluya revision de garantias
					$comple_sql_leg.= " and id not in (1030)";
					
					if($sel_modifica[0] == 2 and $sql_con[9]==1){//si es OT y es polizas no aplica para las OTs
							  $comple_sql_leg.= " and id not in (6, 7, 1021, 1022)";
							}
					
					}
/***********************CONVINACION DE CAMPOS QUE APLICAN PARA EL CAMPO SEGUROS Y GARANTIAS POLIZAS ************************/
				
				if($sql_con[7]==1 ){//si es Otro Si.
					$comple_sql_leg.= " and id not in (2036)";//campos que no aplican para ningun otrosi
					if($sql_con[8] == 4 or $sql_con[8] == 12 or $sql_con[8] == 8 or $sql_con[8] == 2 or $sql_con[8] == 15 or $sql_con[8] == 16){//si son los tipos de otros si Alcance * Alcance / Tiempo * Alcance / Tiempo / Valor * Gerente * Tiempo *Tarifas * Tarifas / Tiempo / Alcance
					  $comple_sql_leg.= " and id not in (15, 16, 17, 21, 2036)";
					}
					
					
				}
				if($sql_con[7]==2 ){//si es OW.
					  $comple_sql_leg.= " and id not in (8, 12, 13, 14, 2036)";
				}
				
				$campo_nombre="";
				$campo_ayuda="";
				$campo_dias_esti="";
				if($sql_con[7]==3){//si es SUSPENCION. use los campos exluxivos para suepenciones nombre_en_suspencion, ayuda_en_suspencion, dias_estimados_suspencion y solo muestre la lista pasos que aplica
						$campo_nombre="nombre_en_suspencion";
						$campo_ayuda="ayuda_en_suspencion";
						$campo_dias_esti="dias_estimados_suspencion";
					  $comple_sql_leg.= " and id in (1,2031,2032,2035,2034,4,5,6,7,1021,1022,2033,13,18,19)";
				}elseif($sql_con[7]==4){//si es REINIICIO.  use los campos exluxivos para suepenciones nombre_en_reinicio, ayuda_en_reinicio, dias_estimados_reinicio y solo muestre la lista pasos que aplica
						$campo_nombre="nombre_en_reinicio";
						$campo_ayuda="ayuda_en_reinicio";
						$campo_dias_esti="dias_estimados_reinicio";

						$comple_sql_leg.= " and id in (1,2031,2032,3,2034,4,5,6,7,1021,1022,2033,13,18,19)";
					
					}else{//si es un otrosi OW o contrato oculte campos exclucivos de las suspenciones y reinicios y use los campos de nombres, dias estimados y ayudas normales
						$campo_nombre="nombre";
						$campo_ayuda="ayuda";
						$campo_dias_esti="dias_estimados";
  					  $comple_sql_leg.= " and id not in (2031, 2032, 2033, 2034, 2035)";//campos exlucivos de reinicio y/o Suspencion
					}
					
			

              $sel_campos = query_db("select id, id_actividad_nivel_servicio, ".$campo_nombre.", campo_fecha_inicial, campo_fecha_final, CAST(".$campo_ayuda." AS TEXT), orden, rol_edita_fecha_ini, rol_edita_fecha_fin, fecha_inicial_igual_a_id_relacion_campo, campo_ob, ".$campo_dias_esti.", alerta, ob_obligatoria, Devolucion, campo_ob_fin_si_aplicara, edita_fecha_inicial, edita_fecha_final from t7_relacion_campos_legalizacion where id > 0 ".$comple_sql_leg." order by orden");
			  $conteo1=0;
			  $conteo2=1;
		
/*-------------define si creo o actualiza en la tabla de los datos. -------------*/	  

$sel_campos_contra = traer_fila_db(query_db("select count(*) from t7_relacion_campos_legalizacion_datos where ".$id_campo_aplica." =".$id_contrato_arr));			
if($sel_campos_contra[0]==0){//si tiene creado en la tabla de la relacion de los campos
$insert = query_db("insert into t7_relacion_campos_legalizacion_datos (".$id_campo_aplica.", f_fin_creacion_sistema, f_ini_elaboracion,f_fin_elaboracion) values (".$id_contrato_arr.", '".$sql_con[2]."', '".$sql_con[2]."', '".$sql_con[3]."')");
}else{
	if($sql_con[4] <48){
$update = query_db("update t7_relacion_campos_legalizacion_datos set f_fin_elaboracion='".$sql_con[3]."' where ".$id_campo_aplica." = ".$id_contrato_arr);
	}
	}
/*-------------define si creo o actualiza en la tabla de los datos. -------------*/	  


$sel_campos_contra = traer_fila_db(query_db("select ".$campos_tabla." from t7_relacion_campos_legalizacion_datos where ".$id_campo_aplica." =".$id_contrato_arr));


			  while($s_cam = traer_fila_db($sel_campos)){
				  	$edita_fecha_1=0;
					$edita_fecha_2=0;
					$edita_ob=0;
					
					
/*ACTUALIZA CAMPOS QUE SE ALIMENTEN DE OTRAS FECHAS fecha_inicial_igual_a_id_relacion_campo*/
if($s_cam[9] != "" and $s_cam[9] != "0" and $sql_con[4] <48){
	$sel_si_tiene_devol = traer_fila_row(query_db("select count(*) from t7_relacion_campos_legalizacion_datos_devoluciones where ".$id_campo_aplica." = ".$id_contrato_arr." and id_campo_legalizacion = ".$s_cam[0],""));

	if(($sel_si_tiene_devol[0]==0 or $s_cam[0] == 17) and ($sel_campos_contra[$s_cam[4]]=="" or $sel_campos_contra[$s_cam[4]]==" ")){
		
	$update =query_db("update t7_relacion_campos_legalizacion_datos set ".$s_cam[3]." = '".$sel_campos_contra[$s_cam[9]]."' where ".$id_campo_aplica." =".$id_contrato_arr);
		
	$sel_campos_contra = traer_fila_db(query_db("select ".$campos_tabla." from t7_relacion_campos_legalizacion_datos where ".$id_campo_aplica." =".$id_contrato_arr));
	}
	}
/*ACTUALIZA CAMPOS QUE SE ALIMENTEN DE OTRAS FECHAS fecha_inicial_igual_a_id_relacion_campo*/



			/*INICIO PERMISOS DE EDICION*/
			

			$sel_permiso_edita_fecha_ini = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (".$s_cam[7].")"));
			$sel_permiso_edita_fecha_fin = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (".$s_cam[8].")"));

				  if($s_cam[7] != 0 and $sel_permiso_edita_fecha_ini[0]>0 and ($sel_campos_contra[$s_cam[3]] =="" or $sel_campos_contra[$s_cam[3]] ==" ") and $sql_con[4] <48 and $s_cam[16] == 1){$edita_fecha_1=1; if($s_cam[7] == 21 and $edita != 1) $edita_fecha_1=0; }
				  if($s_cam[8] != 0 and $sel_permiso_edita_fecha_fin[0]>0 and ($sel_campos_contra[$s_cam[4]] =="" or $sel_campos_contra[$s_cam[4]] ==" ") and $sql_con[4] <48 and $s_cam[17] == 1){$edita_fecha_2=1; if($s_cam[8] == 21 and $edita != 1) $edita_fecha_2=0;}


				if($_SESSION["id_us_session"] == 32){//solo para el usuario admin
					//$edita_fecha_2 = 2;
					//$edita_fecha_2 = 1;					
					}
					
									  
				  if($edita_fecha_1 != 0 or $edita_fecha_2 != 0){
					  $edita_ob=1; 
					  
					   }
					   
		

		   /*FIN PERMISOS DE EDICION*/  
			   
			   			   
			   
		   
$dias_reales="";
$dias_retraso="";	
			if($sel_campos_contra[$s_cam[3]] != "" and $sel_campos_contra[$s_cam[3]] != " " and $sel_campos_contra[$s_cam[3]] != "  " and $sel_campos_contra[$s_cam[4]] != "" and $sel_campos_contra[$s_cam[4]] != " " and $sel_campos_contra[$s_cam[4]] != "  "){

				if($sel_campos_contra[$s_cam[3]] <= $sel_campos_contra[$s_cam[4]])
						$dias_retraso=0;
						$dias_reales = dias_habiles_entre_fechas($sel_campos_contra[$s_cam[3]],$sel_campos_contra[$s_cam[4]]);
			}
			
			if($dias_reales!=""){
					$dias_retraso = $dias_reales-$s_cam[11];
					if($dias_retraso <=0) {$dias_retraso=0;}else{ $dias_retraso="<strong class='letra-descuentos'>".$dias_retraso."</strong>";}
				}
				  
				  $expo = explode(".", $s_cam[6]);
				//  if($expo[1]==0 or $expo[1]==""){
					if($_GET["genera_excel"]!="si"){ $comple_num_ayuda = '<img src="../imagenes/botones/help.gif" alt="'.$s_cam[5].'" width="20" height="20" title="'.$s_cam[5].'" />'; }
					 
					  if($expo[1]==0 or $expo[1]==""){
							  $conteo1=$conteo1+1;
							  $num_imprime =  $comple_num_ayuda." ".$conteo1.". ".$s_cam[2];				  
									 if($clase==""){
										  $clase="class='filas_resultados'";
										  }else{
											  $clase="";
											  }
							$conteo2=1;
						  }else{	
						 	  $num_imprime =  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$comple_num_ayuda." ".$conteo1.".".$conteo2.". ".$s_cam[2];
							  $conteo2 = $conteo2+1;
							  } 
					  
					 
						  
						  
						  
						  $alerta="";
						  if($s_cam[12]!=""){
						  $alerta='<br /><strong class="letra-descuentos"><img src="../imagenes/botones/aler-interro.gif" height="20" /> '.$s_cam[12].'</strong>';
                          }
                          $bloquea_check="";
						  if($_GET["da"] == 1 and $s_cam[0]!=3){//solo si es el perfil de legal oculta todo menos la fila 3 del la tabla legalizacion_contrato
							   $bloquea_check = $display;
							   }
			  ?>
            <tr <?=$clase?> <?=$bloquea_check?>>
              <td colspan="2" valign="top"><? ?> 
			  <?
             echo $num_imprime;
			  ?> 
              
              
              </td>
              <td align="center" valign="top"> 
			  
  <? if($edita_fecha_1 == 1){?>
     <input name="<?=$s_cam[3]?>" type="text" id="<?=$s_cam[3]?>" value="<?=$sel_campos_contra[$s_cam[3]]?>" size="10" maxlength="10" onclick="this.value='<?=$fecha;?>'" readonly="readonly" />
     
<!--     <input name="< ?=$s_cam[3]?>" type="text" id="< ?=$s_cam[3]?>" value="< ?=$sel_campos_contra[$s_cam[3]]?>" size="10" maxlength="10" onclick="" onmouseover="calendario_sin_hora('< ?=$s_cam[3]?>')" readonly="readonly" onchange="valida_fecha_ideal_legalizacion_contrato(this, 'ini')"/>-->
			  
  <? }else{ echo $sel_campos_contra[$s_cam[3]]; ?> <input name="<?=$s_cam[3]?>" type="hidden" id="<?=$s_cam[3]?>" value="<?=$sel_campos_contra[$s_cam[3]]?>"/><? }?>
              
              <? 
			  
			   /* SELECCIONA ROL LA UNICA DIFERENCIA A TODOS LOS OTROS ES $s_cam[8]*/
			   $rol_encargado_inicial = "";
			   $rol_encargado_inicial_id = 0;
			  $sel_rol_encargado = traer_fila_row(query_db("select nombre from tseg11_roles_general where id_rol = ".$s_cam[7]));
			  if($sel_rol_encargado[0]!= ""){
				  echo "<br /><strong style='font-size:10px'>".$sel_rol_encargado[0]."</strong>";
				  $rol_encargado_inicial = "<strong style='font-size:10px'>".$sel_rol_encargado[0]."</strong>";
				  $rol_encargado_inicial_id=$s_cam[7];
				  }else{
					  $id_rol_si_aplica_otro_campo=0;
					  $sel_segun_campo_alimenta = traer_fila_row(query_db("select rol_edita_fecha_ini from t7_relacion_campos_legalizacion where campo_fecha_inicial = '".$s_cam[9]."'"));
					  if($sel_segun_campo_alimenta[0] <> 0){
						  $id_rol_si_aplica_otro_campo = $sel_segun_campo_alimenta[0];
						  }else{
							  $sel_segun_campo_alimenta = traer_fila_row(query_db("select rol_edita_fecha_fin from t7_relacion_campos_legalizacion where campo_fecha_final = '".$s_cam[9]."'"));
							  $id_rol_si_aplica_otro_campo = $sel_segun_campo_alimenta[0];
							  }
							  
							  $sel_rol_encargado = traer_fila_row(query_db("select nombre from tseg11_roles_general where id_rol = ".$id_rol_si_aplica_otro_campo));
								  if($sel_rol_encargado[0]!= ""){
									  echo "<br /><strong style='font-size:10px'>".$sel_rol_encargado[0]."</strong>";
									  $rol_encargado_inicial = "<strong style='font-size:10px'>".$sel_rol_encargado[0]."</strong>";
									  $rol_encargado_inicial_id=$id_rol_si_aplica_otro_campo;
									  }
					  }
					  
					   /* SELECCIONA ROL LA UNICA DIFERENCIA A TODOS LOS OTROS ES $s_cam[8]*/
			  ?>
              
              </td>
              <td align="center" valign="top">
	<? 
	
	if($sel_campos_contra[$s_cam[3]] == "" or $sel_campos_contra[$s_cam[3]] == " "){
				$edita_fecha_2 = 0;
			}
			
	if($edita_fecha_2 == 1){
		
		?>
        <input name="<?=$s_cam[4]?>" type="text" id="<?=$s_cam[4]?>" value="<?=$sel_campos_contra[$s_cam[4]]?>" size="10" maxlength="10" onclick="pone_fecha_fin(this, document.principal.<?=$s_cam[3]?>, '<?=$fecha?>')" readonly="readonly"/>
        
        <!-- <input name="< ?=$s_cam[4]?>" type="text" id="< ?=$s_cam[4]?>" value="< ?=$sel_campos_contra[$s_cam[4]]?>" size="10" maxlength="10" onmouseover="calendario_sin_hora('< ?=$s_cam[4]?>')" readonly="readonly" onchange="valida_fecha_ideal_legalizacion_contrato(this, 'fin', document.principal.< ?=$s_cam[3]?>)"/> -->
        
	<? } else{ echo $sel_campos_contra[$s_cam[4]]; ?><input name="<?=$s_cam[4]?>" type="hidden" id="<?=$s_cam[4]?>" value="<?=$sel_campos_contra[$s_cam[4]]?>"/><? }?>
    
    
     <? 
	  /* SELECCIONA ROL LA UNICA DIFERENCIA A TODOS LOS OTROS ES $s_cam[8]*/
	  $rol_encargado_final="";
	  $rol_encargado_final_id=0;
			  $sel_rol_encargado = traer_fila_row(query_db("select nombre from tseg11_roles_general where id_rol = ".$s_cam[8]));
			  if($sel_rol_encargado[0]!= ""){
				  echo "<br /><strong style='font-size:10px'>".$sel_rol_encargado[0]."</strong>";
				  $rol_encargado_final = "<strong style='font-size:10px'>".$sel_rol_encargado[0]."</strong>";
				  $rol_encargado_final_id=$s_cam[8];
				  }else{
					  $id_rol_si_aplica_otro_campo=0;
					  $sel_segun_campo_alimenta = traer_fila_row(query_db("select rol_edita_fecha_ini from t7_relacion_campos_legalizacion where campo_fecha_inicial = '".$s_cam[9]."'"));
					  if($sel_segun_campo_alimenta[0] <> 0){
						  $id_rol_si_aplica_otro_campo = $sel_segun_campo_alimenta[0];
						  }else{
							  $sel_segun_campo_alimenta = traer_fila_row(query_db("select rol_edita_fecha_fin from t7_relacion_campos_legalizacion where campo_fecha_final = '".$s_cam[9]."'"));
							  $id_rol_si_aplica_otro_campo = $sel_segun_campo_alimenta[0];
							  }
							  
							  $sel_rol_encargado = traer_fila_row(query_db("select nombre from tseg11_roles_general where id_rol = ".$id_rol_si_aplica_otro_campo));
								  if($sel_rol_encargado[0]!= ""){
									  echo "<br /><strong style='font-size:10px'>".$sel_rol_encargado[0]."</strong>";
									  $rol_encargado_final = "<strong style='font-size:10px'>".$sel_rol_encargado[0]."</strong>";
									   $rol_encargado_final_id=$id_rol_si_aplica_otro_campo;
									  }
					  }
		 /* SELECCIONA ROL LA UNICA DIFERENCIA A TODOS LOS OTROS ES $s_cam[8]*/
			  ?>
    
    
              </td>
              <td valign="top">
			  <? 
			  
			  if($edita_ob == 1){
				  
				  if($edita_fecha_2 != 1){
				  ?>
              
              <textarea name="<?=$s_cam[10]?>" id="<?=$s_cam[10]?>" cols="5" rows="3"><?=$sel_campos_contra[$s_cam[10]]?></textarea>
              <input type="hidden" name="<?=$s_cam[15]?>" id="<?=$s_cam[15]?>" value="<?=$sel_campos_contra[$s_cam[15]]?>" />
              <?
				  }else{
					  ?><input type="hidden" name="<?=$s_cam[10]?>" id="<?=$s_cam[10]?>" value="<?=$sel_campos_contra[$s_cam[10]]?>" /><?
					  }
				  
				  if($edita_fecha_2 == 1){
					  if($sel_campos_contra[$s_cam[10]] <> " " and $sel_campos_contra[$s_cam[10]] <> ""){?><strong><?=$rol_encargado_inicial?>:</strong> <?=$sel_campos_contra[$s_cam[10]]?><? }
			  ?>
              <textarea name="<?=$s_cam[15]?>" id="<?=$s_cam[15]?>" cols="5" rows="3"><?=$sel_campos_contra[$s_cam[15]]?></textarea> 
              
              <?
				  }
			  ?>
			  
			  
			  
			  <? echo $alerta;} else{ 
			  
			  
				if($sel_campos_contra[$s_cam[10]] <> " " and $sel_campos_contra[$s_cam[10]] <> ""){?><strong><?=$rol_encargado_inicial?>:</strong> <?=$sel_campos_contra[$s_cam[10]]?><? }
				  
			 if($sel_campos_contra[$s_cam[15]] <> " " and $sel_campos_contra[$s_cam[15]] <> ""){?><br /><strong><?=$rol_encargado_final?>:</strong> <?=$sel_campos_contra[$s_cam[15]]?><? }
			  
			  
			  
			  }?>
              
              
              </td>
              <td valign="top">
			  
<? 
$es_profesional_aseguramiento = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (24)"));
if($edita_fecha_1 ==1 or $edita_fecha_2 ==1){
	if($alerta_incompletos !="" and $s_cam[0] == 12){
		$alerta_incompletos_alerta = "alert('No puede completar este paso hasta que complete: ".$alerta_incompletos."')";
		
	}elseif($s_cam[0] == 10 and $es_profesional_aseguramiento[0] > 0 and $tipo == "contrato" and  ($sql_con[6] == "" or $sql_con[6] == " " or $sql_con[6] == "0" or $sql_con[5] == "" or $sql_con[5] == " " or $sql_con[5] == "0" or $sql_con[10] == " " or $sql_con[10] == "0")){

		$alerta_incompletos_alerta = "alert('No puede completar este paso hasta que complete el aseguramiento Administrativo, el informe de HSE y Confirmar el Gerente de Contrato')";

	}else{
		$ob_obligatoria = "NO";
		if($s_cam[13] == 1){
			$ob_obligatoria = "SI";
			}
		$alerta_incompletos_alerta = "graba_fecha_leg(document.principal.".$s_cam[3].", document.principal.".$s_cam[4].", document.principal.".$s_cam[10].", '".$s_cam[3]."', '".$s_cam[4]."', '".$s_cam[10]."','".$ob_obligatoria."', document.principal.".$s_cam[15].", '".$s_cam[15]."', '".$rol_encargado_inicial_id."', '".$rol_encargado_final_id."', '".$edita_fecha_2."', document.principal.id_actividad_".$s_cam[0].")";
		}
		
	
	?><input type="hidden" name="id_actividad_<?=$s_cam[0]?>" id="id_actividad_<?=$s_cam[0]?>" value="<?=$s_cam[0]?>" />
    <input name="button" type="button" class="boton_grabar" id="button" value="Grabar" onclick="<?=$alerta_incompletos_alerta?>;"/>
    <?
			 if($s_cam[14] == 1 and $edita_fecha_2 != 0){
				 $devuelve_paso = "devolver_anterior(document.principal.".$s_cam[3].", document.principal.".$s_cam[10].", ".$s_cam[0].", '".$s_cam[3]."', '".$s_cam[10]."','".$rol_encargado_inicial_id."', '".$rol_encargado_final_id."', document.principal.".$s_cam[15].", '".$s_cam[15]."')";
			?>
            
			<br /><input name="button" type="button" class="boton_grabar_cancelar" id="button" value="<? if ($s_cam[0] == 17) echo "Rechazar"; else echo "Devolver";?>" onclick="<?=$devuelve_paso?>"/>
			
			<? 
			 }
	}?>
              
              </td>
              <td align="center" valign="top"><?=$s_cam[11]?></td>
              <td align="center" valign="top"><?=$dias_reales?></td>
              <td align="center" valign="top"><?=$dias_retraso?></td>
              </tr>
              
              
            <?
			$total_dias_reales =0;
			$total_dias_reales = $total_dias_reales +$dias_reales;
			  
			  if($s_cam[14] == 1 or $s_cam[0] == 16){	
	  $cont_devoluciones = traer_fila_row(query_db("select count(*) from t7_relacion_campos_legalizacion_datos_devoluciones where ".$id_campo_aplica." = ".$id_contrato_arr." and id_campo_legalizacion=".$s_cam[0]));  
	  $sel_devoluciones = query_db("select inicio, fin, ob1, ob2 from t7_relacion_campos_legalizacion_datos_devoluciones where ".$id_campo_aplica." = ".$id_contrato_arr." and id_campo_legalizacion=".$s_cam[0]." order by id desc");  
			  
			  $cual_fila = 1;
			  $muestra_total="NO";
			  while($sel_dev = traer_fila_db($sel_devoluciones)){
				  $muestra_total="SI";
				  if($cual_fila == 1){
			  ?>
            
            <tr >
              <td align="right" valign="top" >&nbsp;</td>
              <td rowspan="<?=$cont_devoluciones[0]?>" align="right" valign="middle"  <?=$clase?>><?=$conteo1?>.1. <? if($s_cam[0] == 16) echo "Historico de Modificaciones"; elseif ($s_cam[0] == 17) echo "Historico de Rechazos"; else echo "Historico de Devoluciones";?>
              </td>
              <td align="center" valign="top" class="filas_sub_resultados"><?=$sel_dev[0]?></td>
              <td align="center" valign="top"  class="filas_sub_resultados"><?=$sel_dev[1]?></td>
              <td valign="top" colspan="2"  class="filas_sub_resultados">
			  

			  
			 <?
			 
			 if($sel_dev[2]<>"" and $sel_dev[2]<>" " and $sel_dev[2]<>"  "){
			  echo $rol_encargado_inicial.": ".$sel_dev[2];
			 }
			  
              if($sel_dev[3]<>"" and $sel_dev[3]<>" " and $sel_dev[3]<>"  "){
			  echo "<br />".$rol_encargado_final.": ".$sel_dev[3];
              
              }
			  
			  $dias_reales_dev = dias_habiles_entre_fechas($sel_dev[0],$sel_dev[1]);
			  
              ?>
              
              </td>
              <td align="center" valign="top"  class="filas_sub_resultados">&nbsp;</td>
              <td align="center" valign="top"  class="filas_sub_resultados"><?=$dias_reales_dev?></td>
              <td align="center" valign="top"  class="filas_sub_resultados">&nbsp;</td>
            </tr>
            <?
			$total_dias_reales = $total_dias_reales +$dias_reales_dev;
			$total_dias_reales_dev=0;
				  }else{//si es mayor a la primera fila
				   $dias_reales_dev = dias_habiles_entre_fechas($sel_dev[0],$sel_dev[1]);
			$total_dias_reales = $total_dias_reales +$dias_reales_dev;
			$total_dias_reales_dev = $total_dias_reales_dev +$dias_reales_dev;
			?>
             <tr >
   			<td valign="top"  >&nbsp;</td>
              <td align="center" valign="top" class="filas_sub_resultados"><?=$sel_dev[0]?></td>
              <td align="center" valign="top"  class="filas_sub_resultados"><?=$sel_dev[1]?></td>
              <td valign="top" colspan="2"  class="filas_sub_resultados"><?
			 
			 if($sel_dev[2]<>"" and $sel_dev[2]<>" " and $sel_dev[2]<>"  "){
			  echo $rol_encargado_inicial.": ".$sel_dev[2];
			 }
			  
              if($sel_dev[3]<>"" and $sel_dev[3]<>" " and $sel_dev[3]<>"  "){
			  echo $rol_encargado_final.": ".$sel_dev[3];
              
              }
              ?></td>

              <td align="center" valign="top"  class="filas_sub_resultados">&nbsp;</td>
              <td align="center" valign="top"  class="filas_sub_resultados"><?=$dias_reales_dev?></td>
              <td align="center" valign="top"  class="filas_sub_resultados">&nbsp;</td>
            </tr>
            <?
				 
				  }//fin si no es la primera fila
				  $cual_fila = $cual_fila+1; 
			  }//fin while quwe recorre las devoluciones
			  $dias_retraso_total=0;
			  if($muestra_total=="SI"){
				  
				  $dias_retraso_to = $total_dias_reales-$s_cam[11];
				  
				  if($total_dias_reales!=""){
					$dias_retraso_total = $total_dias_reales-$s_cam[11];
					if($dias_retraso_to <=0) {$dias_retraso=0;}else{ $dias_retraso_total="<strong class='letra-descuentos'>".$dias_retraso_to."</strong>";}
				}
			  ?>
              
			  <tr  >
              <td colspan="2" valign="top">
              </td>
              <td align="center" valign="top"> 
              </td>
              <td align="center" valign="top">
    
              </td>
              <td colspan="2" valign="top" align="right" class="filas_sub_resultados"><strong>Total de dias de <? if($s_cam[0] == 16) echo "Modificaciones"; elseif ($s_cam[0] == 17) echo "Rechazos"; else echo "Devoluciones";?>: </strong>
              </td>
              <td align="center" valign="top" class="filas_sub_resultados"></td>
              <td align="center" valign="top" class="filas_sub_resultados"><?=$total_dias_reales_dev?></td>
              <td align="center" valign="top" class="filas_sub_resultados"></td>
              </tr>
			  <tr  >
              <td colspan="2" valign="top">
              </td>
              <td align="center" valign="top"> 
              </td>
              <td align="center" valign="top">
    
              </td>
              <td colspan="2" valign="top" align="right" <?=$clase?>><strong>Total de dias de Gesti&oacute;n: </strong>
              </td>
              <td align="center" valign="top" <?=$clase?>><?=$s_cam[11]?></td>
              <td align="center" valign="top" <?=$clase?>><?=$total_dias_reales?></td>
              <td align="center" valign="top" <?=$clase?>><?=$dias_retraso_total?></td>
              </tr>
			  <?
			  }
				}
				if ($s_cam[0] <> 1 and $s_cam[0] <> 12 and ($sel_campos_contra[$s_cam[3]] =="" or $sel_campos_contra[$s_cam[3]] ==" " or $sel_campos_contra[$s_cam[4]] =="" or $sel_campos_contra[$s_cam[4]] ==" ")){ if($s_cam[0] != 12) $alerta_incompletos.= "\\n * ".$conteo1.". ".$s_cam[2];
			}
			  }
			?></table> <?  
			  
	}

function llena_tabla_temporal_reporte_marco($tipo, $id_contrato){
	
	if($tipo == "ejecucion"){
		$tabla_temporal = "t2_reporte_marco_temporal_ejecuciones_excel";
		}
	if($tipo == "saldos"){
		$tabla_temporal = "t2_reporte_marco_temporal";
		}
	$truncate_table = query_db("delete from ".$tabla_temporal." where id_us = ".$_SESSION["id_us_session"]);

	$sel_contratos_que_viene = traer_fila_row(query_db("select consecutivo,creacion_sistema,apellido, id_item from t7_contratos_contrato where id = ".$id_contrato." "));
$contratos_que_viene=numero_item_pecc_contrato_antes_formato("C",$sel_contratos_que_viene[1],$sel_contratos_que_viene[0],$sel_contratos_que_viene[2], $id_contrato);
$id_solicitud=$sel_contratos_que_viene[3];

	/*Inicial*/
	$numero_solicitud="";
/*selecciona vista para solicitud inicial*/
if($_SESSION["id_us_session"] == 32){
//echo "select count(*) from vista_reporte_saldos_marco_3_crea_inicial where id_item = $id_solicitud";
}
$seleccion_si_es_de_antiguos = traer_fila_row(query_db("select count(*) from vista_reporte_saldos_marco_3_crea_inicial where id_item = $id_solicitud"));
if($seleccion_si_es_de_antiguos[0]>0){
	$vista_inicial = "vista_reporte_saldos_marco_3_crea_inicial";
	}else{
		$vista_inicial = "vista_reporte_saldos_marco_2_crea_inicial";
		}
/*selecciona vista*/
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3 from ".$vista_inicial." where id_item = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3";
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la creacion de los contratos pero sin los contratos
		$contratos="";
		$contratista="";
		if($numero_solicitud==""){//como es un solo numero se llena la variable una ves para no cargar el sistema
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		}
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from ".$vista_inicial." where id_item = $id_solicitud and t2_presupuesto_id=".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos creados en la creacion
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])){
				$num_contra_while="<font color=blue>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4]);
				}
		 if($cont == 0){
		  	$clase= "class=filas_resultados_reporte_saldos1";
			$cont = 1;
		  }else{
		  	$clase= "class=filas_resultados_reporte_saldos2";
		  }
					$contratos.="<div ".$clase.">".$num_contra_while."</div>";
					$contratista.="<div ".$clase.">".substr($s_contras[3],0,47)."</div>";
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'inicial', $id_solicitud, '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		}
	/*Inicial*/
	/*Ampliaciones*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item from vista_reporte_saldos_marco_3_ampliaciones where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item";
	
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from vista_reporte_saldos_marco_3_ampliaciones where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])){
				$num_contra_while="<font color=#0000FF>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4]);
				}
				if($cont == 0){
		  	$clase= "class=filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
				if($contratos==""){
				$contratos.="<span >".$num_contra_while."</span>";
				$contratista.="<span >".$s_contras[3]."</span>";
				}else{
					$contratos.=",<br /><span >".$num_contra_while."</span>";
					$contratista.=",<br /><span >".$s_contras[3]."</span>";
					}
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'ampliacion', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		}
	/*Ampliaciones*/
	/*RECLASIFICACIONES AUMENTA VALOR*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item from vista_reporte_saldos_marco_3_ampliaciones_reclasificacion where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item";
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from vista_reporte_saldos_marco_3_ampliaciones_reclasificacion where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])){
				$num_contra_while="<font color=#0000FF>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2], $s_contras[4]);
				}
				if($cont == 0){
		  	$clase= "class=filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
				if($contratos==""){
				$contratos.="<span >".$num_contra_while."</span>";
				$contratista.="<span >".$s_contras[3]."</span>";
				}else{
					$contratos.=",<br /><span >".$num_contra_while."</span>";
					$contratista.=",<br /><span >".$s_contras[3]."</span>";
					}
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'reclasificacion', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		}
	/*RECLASIFICACIONES AUMENTA VALOR*/
	
	/*OTROS TIPOS DE PROCESO*/
	if($tipo == "saldos"){
	$numero_solicitud="";
	$sel_contratos = query_db("select id from t7_contratos_contrato where id_item = ".$id_solicitud." and estado <> 50");
	$ids_contras = "";
	while($sel_contras = traer_fila_db($sel_contratos)){
		$ids_contras.= ",".$sel_contras[0]; 
		}
		$ids_contras = "0".$ids_contras;
		$ids_contras = str_replace("0,","", $ids_contras);//es fundamental quitar el 0 para que no traiga datos errdos
		
		global $pi2, $g13;
 $sel_valor_inicial_sq = "select $pi2.id_item, num1,num2,num3 from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (9,10,11,15) and (id_solicitud_relacionada in (".$id_solicitud.") or contrato_id in (".$ids_contras.") or id_item_peec_aplica in (".$id_solicitud."))  and $pi2.estado <> 33";
	
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){
		$numero_solicitud=numero_item_pecc($v_ini[1], $v_ini[2], $v_ini[3]);
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, num_item) values (".$_SESSION["id_us_session"].", 'otros','".$v_ini[0]."', '".$numero_solicitud."' )");
		}
	}
	/*FIN OTROS TIPOS DE PROCESO*/
	/*RECLASIFICACION RESTA VALOR*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica from vista_reporte_saldos_marco_4_ots_reclasificacion where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica";
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from vista_reporte_saldos_marco_4_ots_reclasificacion where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
				if($contratos==""){
				$contratos.=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4]);
				$contratista.=substr($s_contras[3], 0, 47);
				}else{
					$contratos.=",<br />".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4]);
					$contratista.=",<br />".substr($s_contras[3],0,47);
					}
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista,id_item_ots_aplica) values (".$_SESSION["id_us_session"].", 'ots', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."','".$v_ini[10]."')");
		}
	/*FIN RECLASIFICACION RESTA VALOR*/	
	
	/*OTS*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica from vista_reporte_saldos_marco_4_ots where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica";
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista, id_contrato from vista_reporte_saldos_marco_4_ots where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista, id_contrato");
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
				if($contratos==""){
				$contratos.=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4]);
				$contratista.=substr($s_contras[3], 0, 47);
				}else{
					$contratos.=",<br />".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2],$s_contras[4]);
					$contratista.=",<br />".substr($s_contras[3],0,47);
					}
		}
		$insert = query_db("insert into ".$tabla_temporal." (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista,id_item_ots_aplica) values (".$_SESSION["id_us_session"].", 'ots', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."','".$v_ini[10]."')");
		}
	/*OTS*/	
		
		
		
		
	}

function anos_consulta_ulti_numeros($por_defecto){
	global $fecha;
	$fecha_explode = explode("-",$fecha);
	$ano_actual = $fecha_explode[0];
	$ano_actual = $ano_actual[2].$ano_actual[3];
	
	for($i = 13; $i <=$ano_actual; $i ++ ){
		
		if($por_defecto == $i){
			$seleccionar = "selected='selected'";
		}else{
			$seleccionar="";
			}
        
		$text_funcion = $text_funcion."<option value='".$i."' $seleccionar>".$i."</option>";
		}
		return $text_funcion;
	}


function anos_consulta($incluye_actual){
	global $fecha;
	$fecha_explode = explode("-",$fecha);
	$ano_actual = $fecha_explode[0];
	if($incluye_actual=="NO"){
		$ano_actual = $ano_actual -1;
		}
	for($i = $ano_actual; $i >=2012; $i -- ){
		$text_funcion = $text_funcion."<option value='".$i."'>".$i."</option>";
		}
		return $text_funcion;
	}
	
function anos_consulta_defecto_pecc($por_defecto){
	global $fecha;
	$fecha_explode = explode("-",$fecha);
	$ano_actual = $fecha_explode[0];
	
	for($i = 2015; $i <=$ano_actual; $i ++ ){
	
		if($por_defecto == $i){
			$seleccionar = "selected='selected'";
		}else{
			$seleccionar = "";
			}
		
		$text_funcion = $text_funcion."<option value='".$i."' $seleccionar>".$i."</option>";
		}
		return $text_funcion;
	}
	
function anos_consulta_defecto($por_defecto){
	global $fecha;
	$fecha_explode = explode("-",$fecha);
	$ano_actual = $fecha_explode[0];
	
	for($i = 2013; $i <=$ano_actual; $i ++ ){
	
		if($por_defecto == $i){
			$seleccionar = "selected='selected'";
		}else{
			$seleccionar = "";
			}
		
		$text_funcion = $text_funcion."<option value='".$i."' $seleccionar>".$i."</option>";
		}
		return $text_funcion;
	}
function anos_presupuesto($por_defecto){
	global $fecha;
	$fecha_explode = explode("-",$fecha);
	$ano_actual = $fecha_explode[0];
	$text_funcion = "<option value='".$ano_actual."'>".$ano_actual."</option>";
	for($i = 1; $i <=10; $i ++ ){
		$ano_valor = $ano_actual + $i;
		
		if($por_defecto == $ano_valor){
			$seleccionar = "selected='selected'";
		}else{
			$seleccionar = "";
			}
		
		$text_funcion = $text_funcion."<option value='".$ano_valor."' $seleccionar>".$ano_valor."</option>";
		}
		return $text_funcion;
	}

function agrega_firmas_urna_virtual($id_item, $etapa, $dias){
if($id_item > 0){
	global $fecha;
	if($dias == ""){
		$dias=0;
		}
agrega_gestion_pecc($id_item, $etapa,$fecha, $dias);

if($etapa == "12.1"){
	$etapa_siguiente = "12.2";
	}
if($etapa == "12.2"){
	$etapa_siguiente = "13";
	}

$updta_estado = query_db("update t2_item_pecc set estado = '".$etapa_siguiente."' where id_item = ".$id_item);

}

	}
	
function encabezado_contrato_tarifas($id_contrato_tarifas){
global $v_t_9, $v_t_2;
	$buscar_datos_contrato = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id =". $id_contrato_tarifas));
	$id_contrato_modulo = $buscar_datos_contrato[0];
	$busca_datos_contrato = traer_fila_row(query_db("select CAST(objeto AS TEXT), contratista,  tipo_bien_servicio,  monto_usd, monto_cop, fecha_inicio, vigencia_mes, gerente, especialista, t1_tipo_documento_id from t7_contratos_contrato where id=".$id_contrato_modulo));
	$busca_reembolsable = traer_fila_row(query_db("select t6_tarifas_reembosables1_contrato_id, porcentaje_administracion, nombre_administrador, fecha_creacion, estado from $v_t_9 where t6_tarifas_contratos_id = $id_contrato_tarifas  and estado = 1 and porcentaje_administracion >=0"));
	
	$busca_tarifas_ipc = traer_fila_row(query_db("select count(*) from t6_tarifas_ipc_contrato where t6_tarifas_contratos_id = $id_contrato_tarifas and ipc_administracion = 1 and estado = 1 "));	
	$cuenta_descuentos = traer_fila_row(query_db("select count(*) from $v_t_2 where tarifas_contrato_id = $id_contrato_tarifas and estado = 1"));
	$busca_tarifas_uni = traer_fila_row(query_db("select count(*) from v_tarifas_con_descuentos where tarifas_contrato_id = $id_contrato_tarifas  "));	
	?>
	<table width="100%" border="0">
	  <tr>
	    <td colspan="3"><table width="100%" border="0" cellpadding="2" cellspacing="2"  class="tabla_lista_resultados">
	      <tr>
	        <td width="12%" align="right" ><strong>Proveedor:</strong></td>
	        <td width="88%" colspan="2" ><?=saca_nombre_lista("t1_proveedor",$busca_datos_contrato[1],'razon_social','t1_proveedor_id');?></td>
          </tr>
	      <tr>
	        <td align="right" valign="top" ><strong>Objeto del contrato:</strong></td>
	        <td colspan="2" ><?=htmlentities($busca_datos_contrato[0]);?></td>
          </tr>
        </table></td>
      </tr>
	  <tr>
	    <td width="32%" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2"  class="tabla_lista_resultados">
	      <tr>
	        <td width="40%" align="right" valign="top" ><strong>Tipo de contrato:</strong></td>
	        <td width="60%" colspan="2" ><? if ($busca_datos_contrato[2] == "Bienes") echo "Bienes"; else echo "Servicios"; ?></td>
          </tr>
          
  <? if ($busca_datos_contrato[9] <> 2){ ?>
	      <tr>
	        <td align="right" ><strong>Valor del contrato USD$: </strong></td>
	        <td colspan="2" ><?=number_format($busca_datos_contrato[3],0)?></td>
          </tr>
	      <tr>
	        <td align="right" valign="top" ><strong>Valor del contrato COP$: </strong></td>
	        <td colspan="2" ><?=number_format($busca_datos_contrato[4],0)?></td>
          </tr>
           <?
	  }else{
		  ?>
		  <tr>
        <td align="right"  valign="top"><strong>Monto:</strong></td>
        <td colspan="2" valign="top"><strong onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display=&quot;block&quot;;ajax_carga(&quot;../aplicaciones/reportes/lista_reporte_saldos.php?id_contrato=<?=$id_contrato_modulo?>&quot;,&quot;div_carga_busca_sol&quot;)' style="cursor:pointer">Ver rerpote de contrato Marco</strong></td>
        <tr>
	        <td align="right" valign="top" ><strong>Valor del contrato COP$: </strong></td>
	        <td colspan="2" ><?=number_format($busca_datos_contrato[4],0)?></td>
          </tr>
      </tr>
		  <?
		  }
	  ?>
          
	      <tr>
	        <td align="right" valign="top" ><strong>Fecha de inicio:</strong></td>
	        <td colspan="2" ><?=$busca_datos_contrato[5]?></td>
          </tr>
	      <tr>
	        <td align="right" valign="top" ><strong>Fecha de finalizaci&oacute;n:</strong></td>
	        <td colspan="2" ><?=$busca_datos_contrato[6]?></td>
          </tr>
	      
        </table></td>
	    <td width="30%" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2"  class="tabla_lista_resultados">
        <? if(busca_tarifas_aiu($id_contrato_tarifas,4) == ""){?>
	      <tr>
	        <td width="49%" align="right" valign="top" ><strong>Aplica AIU:</strong></td>
	        <td width="51%" colspan="2" >NO</td>
          </tr>
         <? }else{?><tr><td width="51%" colspan="2" align="center" ><?=busca_tarifas_aiu($id_contrato_tarifas,4)?></td></tr><? }
		 
		 if(busca_tarifas_convenciones($id_contrato_tarifas,4) == ""){
		 ?>
          <tr>
	        <td align="right" valign="top" ><strong>Aplica convenci&oacute;n:</strong></td>
	        <td colspan="2" >NO</td>
          </tr>
          <?
		 }else{?><tr><td width="51%" colspan="2" align="center" ><?=busca_tarifas_convenciones($id_contrato_tarifas,4)?></td></tr><? }
		  ?>
	      <tr>
	        <td align="right" valign="top" ><strong>Aplica IPC:</strong></td>
	        <td colspan="2" ><? if($busca_tarifas_ipc[0]>=1) echo "Si";	else echo "NO";
			
			?></td>
          </tr>
	     
	      <tr>
	        <td align="right" valign="top" ><strong>Aplica descuentos:</strong></td>
	        <td colspan="2" ><? 
			
			if($cuenta_descuentos[0]>=1 or $busca_tarifas_uni[0]>=1){ 
			echo "SI, ";
					if($cuenta_descuentos[0]>=1){?><a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/tarifas/detalle_descuentos.php?id_contrato=<?=$id_contrato_tarifas;?>','carga_acciones_permitidas')">Configurado por Abastecimiento</a><? }
					if($busca_tarifas_uni[0]>=1){?><a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/tarifas/detalle_descuentos.php?id_contrato=<?=$id_contrato_tarifas;?>','carga_acciones_permitidas')">Configurado por el Proveedor</a> <? }
			}else {echo "NO"; }?></td>
          </tr>
	      <tr>
	        <td align="right" valign="top" ><strong>Aplica Reembolsables:</strong></td>
	        <td colspan="2" ><? if($busca_reembolsable[0]>=1) echo "Si, administracion: ".number_format($busca_reembolsable[1],0)."%";	else echo "No";
			
			?></td>
          </tr>
	     

        </table></td>
	    <td width="38%" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2"  class="tabla_lista_resultados">
	      
	      <tr>
	        <td width="53%" align="right" valign="top" ><strong>Gerente del contrato:</strong></td>
	        <td width="47%" colspan="2" ><?=saca_nombre_lista("t1_us_usuarios",$busca_datos_contrato[7],'nombre_administrador','us_id');?></td>
          </tr>
	      <tr>
	        <td width="53%" align="right" valign="top" ><strong>Profesional de C&amp;C asignado:</strong></td>
	        <td colspan="2" ><?=saca_nombre_lista("t1_us_usuarios",$busca_datos_contrato[8],'nombre_administrador','us_id');?></td>
          </tr>
	      <tr>
	        <td width="53%" align="right" valign="top" ><strong>Jefe del gerente de contrato:</strong></td>
	        <td colspan="2" ><?=saca_nombre_lista("t1_us_usuarios",busca_jefe_area_contrato($id_contrato_tarifas),'nombre_administrador','us_id');?></td>
          </tr>
	      <tr>
	        <td align="right" valign="top" >&nbsp;</td>
	        <td colspan="2" >&nbsp;</td>
          </tr>
	      <tr>
	        <td align="right" valign="top" >&nbsp;</td>
	        <td colspan="2" >&nbsp;</td>
          </tr>
	      
	      
	      
        </table></td>
      </tr>
</table>
	<?
	}


function permite_firmar_proceso_de_bienes($id_item_funct){//esta funcion lo que hace es validar si habilita o no la firma o la alerta de una solicitud de bienes la cual es traida desde SAP


	$sel_item_fun = traer_fila_row(query_db("select t1_tipo_contratacion_id from t2_item_pecc where id_item = ".$id_item_funct));
	
	
$es_de_bienes = "NO";
	if($sel_item_fun[0] <> 1){//si es una solicitud de bienes
	
	$sel_si_desierta = traer_fila_row(query_db("SELECT count(*)  FROM t2_presupuesto as t1, t2_presupuesto_proveedor_adjudica as t2 WHERE t1.t2_item_pecc_id = ".$id_item_funct." and t1.t2_presupuesto_id = t2.t2_presupuesto_id and t1_tipo_documento_id = 4"));
		if($sel_si_desierta[0] == 0){//Si no es declarada decierta
			$es_de_bienes = "SI";
		}
		}
		return $es_de_bienes;
	}
function solicitud_bienes($id_solicitud){

	$selec_tipo_contras = traer_fila_row(query_db("select count(*) from t7_contratos_contrato where id_item = ".$id_solicitud." and tipo_bien_servicio = 'Bienes'"));
	
	if($selec_tipo_contras[0] > 0){
			return "SI";
		}else{ return "NO";}
	
	
	}

function saber_si_solicitud_tiene_contratos_de_bienes($id_item_bienes){
	
	$busca_contratos_bienes = traer_fila_row(query_db("select count(*) from t7_contratos_contrato where tipo_bien_servicio = 'Bienes' and id_item = ".$id_item_bienes));
	$es_de_bienes = "NO";
	if($busca_contratos_bienes[0] > 0){ $es_de_bienes = "SI"; }
	return $es_de_bienes;
	}
	
function busca_tarifas_aiu($id_contrato_tarifa,$ubicacion)
	{
//echo "select t6_tarifas_aiu_contrato_id, aiu_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_aiu_contrato where t6_tarifas_contratos_id = $id_contrato_tarifa  and estado = 1";
			$busca_descuneto = traer_fila_row(query_db("select t6_tarifas_aiu_contrato_id, aiu_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_aiu_contrato where t6_tarifas_contratos_id = $id_contrato_tarifa  and estado = 1"));
			if($busca_descuneto[1]==1) $mustra_aiu=1;
			else $mustra_aiu=2;
			//tipo ubicacion 1= para creacion, 2 para listas, 3 para menu
			if( ($ubicacion==1) && ($mustra_aiu==1) ){//if 1
				
			$imp = "<table width='100%' border='0' cellspacing='2' cellpadding='2'>
  <tr>
    <td class='letra-descuentos'><strong>ATENCION: Las  tarifas que esta apunto de registrar deben incluir el AIU.</strong></td>
  </tr>
</table>";
			} //if 1

			if( ($ubicacion==2) && ($mustra_aiu==1) ){//if 2
				
			$imp = "<table width='100%' border='0' cellspacing='2' cellpadding='2'>
  <tr>
    <td class='letra-descuentos'><strong>ATENCION: Estas tarifas ya tiene AIU incluido.</strong></td>
  </tr>
</table>";
			} //if 2

			if( ($ubicacion==3) && ($mustra_aiu==1) ){//if 2
				
			$imp = $mustra_aiu;
			} //if 2
			
			if( ($ubicacion==4) && ($mustra_aiu==1) ){//if 4
				
			$imp = "<strong class='letra-descuentos'>ATENCION: El contrato aplica AIU.</strong>";
			} //if 4
			
			return $imp;
			
		}
		
function busca_tarifas_convenciones($id_contrato_tarifa,$ubicacion)
	{
//echo "select t6_tarifas_convencion_contrato_id, convencion_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_conveciones_contrato where t6_tarifas_contratos_id = $id_contrato_tarifa  and estado = 1";
			$busca_descuneto = traer_fila_row(query_db("select t6_tarifas_convencion_contrato_id, convencion_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_conveciones_contrato where t6_tarifas_contratos_id = $id_contrato_tarifa  and estado = 1"));
			if($busca_descuneto[1]==1) $mustra_aiu=1;
			else $mustra_aiu=2;
			//tipo ubicacion 1= para creacion, 2 para listas, 3 para menu
			if( ($ubicacion==1) && ($mustra_aiu==1) ){//if 1
				
			$imp = "<table width='100%' border='0' cellspacing='2' cellpadding='2'>
  <tr>
    <td class='letra-descuentos'><strong>ATENCION: El contrato tiene habilitada la opci&oacute;n de modificaci&oacute;n de tarifas por Convenci&oacute;n.</strong></td>
  </tr>
</table>";
			} //if 1

			if( ($ubicacion==2) && ($mustra_aiu==1) ){//if 2
				
			$imp = "<table width='100%' border='0' cellspacing='2' cellpadding='2'>
  <tr>
    <td class='letra-descuentos'><strong>ATENCION: Estas tarifas ya tiene la convencion incluida.</strong></td>
  </tr>
</table>";
			} //if 2

			if( ($ubicacion==3) && ($mustra_aiu==1) ){//if 2
				
			$imp = $mustra_aiu;
			} //if 2
			
			if( ($ubicacion==4) && ($mustra_aiu==1) ){//if 4
				
			$imp = "<strong class='letra-descuentos'>ATENCION: El contrato aplica convenci&oacute;n.</strong>";
			} //if 4
			
			return $imp;
			
		}		
	
function busca_jefe_area_contrato($id_contrato_tarifas){ 

	$sel_tarifas_contrato = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id = ".$id_contrato_tarifas));
	$sel_contrato = traer_fila_row(query_db("select id_item, gerente from t7_contratos_contrato where id=".$sel_tarifas_contrato[0]));
	$sel_item_area = traer_fila_row(query_db("select t1_area_id from t2_item_pecc where id_item=".$sel_contrato[0]));
	$id_ger_cont_fun = $sel_contrato[1];
	if($sel_contrato[1] == 63){//este if es temporal, mientras agrego una forma para que aparezcan las areas de los gerentes
	$id_area_fun = 39;
		}else{
	$id_area_fun = $sel_item_area[0];
		}
if($_SESSION["id_us_session"] == 32){

	}
/* Busca Super intendente o jefatura operacional*/	
	$sele_jefe_area = traer_fila_row(query_db("select t1.id_superintendente from tseg14_relacion_usuario_superintendente as t1, t1_us_usuarios as t2, t1_area as t3 where t1.id_superintendente = t2.us_id and t2.estado = 1 and t1.id_us = ".$id_ger_cont_fun." and t1.id_area = ".$id_area_fun." and t3.t1_area_id = t1.id_area and t3.estado = 1"));//busca super intendentes y area
	if($sele_jefe_area[0]=="" or $sele_jefe_area[0]==0 ){ // Si no encuentra la relacion gerente area superintendente, entonces solo busca gerente super intendente.
		$sele_jefe_area = traer_fila_row(query_db("select t1.id_superintendente  from tseg14_relacion_usuario_superintendente as t1, t1_us_usuarios as t2, t1_area as t3 where t1.id_superintendente = t2.us_id and t2.estado = 1 and t1.id_us = ".$id_ger_cont_fun." and t3.t1_area_id = t1.id_area and t3.estado =1"));
	}
/* Busca Super intendente o jefatura operacional*/		
	
/*Busca Jefe de Area si no encuentra super*/	
if($sele_jefe_area[0] == ""){	

	$sele_jefe_area = traer_fila_row(query_db("select t1.id_jefe_area from tseg13_relacion_usuario_jefe as t1, t1_us_usuarios as t2, t1_area as t3 where t1.id_jefe_area = t2.us_id and t2.estado = 1 and t1.id_us = ".$sel_contrato[1]." and t1.id_area = ".$sel_item_area[0]." and t1.id_area = t3.t1_area_id and t3.estado = 1"));
	if($sele_jefe_area[0]=="" or $sele_jefe_area[0]==0 ){ // Si no encuentra la relacion gerente area jefe, entonces solo busca gerente jefe.
		$sele_jefe_area = traer_fila_row(query_db("select t1.id_jefe_area  from tseg13_relacion_usuario_jefe as t1, t1_us_usuarios as t2, t1_area as t3 where t1.id_jefe_area = t2.us_id and t2.estado = 1 and t1.id_us = ".$sel_contrato[1]." and t3.t1_area_id = t1.id_area and t3.estado =1"));
	}
}
/*Busca Jefe de Area si no encuentra super*/	

/*Busca vice o director si no encuentra super ni gerente*/	
if($sele_jefe_area[0] == ""){	//vicepresidente

	$sele_jefe_area = traer_fila_row(query_db("select t1.id_vicepresidente from tseg15_relacion_usuario_vicepresidente as t1, t1_us_usuarios as t2, t1_area as t3 where t1.id_vicepresidente = t2.us_id and t2.estado = 1 and t1.id_us = ".$sel_contrato[1]." and t1.area = ".$sel_item_area[0]." and t1.area = t3.t1_area_id and t3.estado = 1"));
	if($sele_jefe_area[0]=="" or $sele_jefe_area[0]==0 ){ // Si no encuentra la relacion gerente area jefe, entonces solo busca gerente jefe.
		$sele_jefe_area = traer_fila_row(query_db("select t1.id_vicepresidente  from tseg15_relacion_usuario_vicepresidente as t1, t1_us_usuarios as t2, t1_area as t3 where t1.id_vicepresidente = t2.us_id and t2.estado = 1 and t1.id_us = ".$sel_contrato[1]." and t3.t1_area_id = t1.area and t3.estado =1"));
	}
}
if($sele_jefe_area[0] == ""){	//director
	$sele_jefe_area = traer_fila_row(query_db("select t1.id_director from tseg15_relacion_usuario_director as t1, t1_us_usuarios as t2, t1_area as t3 where t1.id_director = t2.us_id and t2.estado = 1 and t1.us_id = ".$sel_contrato[1]." and t1.id_area = ".$sel_item_area[0]." and t1.area = t3.t1_area_id and t3.estado = 1"));
	if($sele_jefe_area[0]=="" or $sele_jefe_area[0]==0 ){ // Si no encuentra la relacion gerente area jefe, entonces solo busca gerente jefe.
		$sele_jefe_area = traer_fila_row(query_db("select t1.id_director  from tseg15_relacion_usuario_director as t1, t1_us_usuarios as t2, t1_area as t3 where t1.id_director = t2.us_id and t2.estado = 1 and t1.us_id = ".$sel_contrato[1]." and t3.t1_area_id = t1.id_area and t3.estado =1"));
	}
}

/*Busca vice o director si no encuentra super ni gerente*/		

/*Busca Presidente*/	
if($sele_jefe_area[0] == ""){	
	$sele_jefe_area[0] = 18428;
}
/*Busca Presidente*/	

	
	
	
 return $sele_jefe_area[0];		


}

function tipo_bien_servicio_sin_contrato($complemento){ 
if($complemento == "B" or $complemento == "BS" or $complemento == "M"){ return " Bienes";} else { return " Servicios";} 
}

function tipo_bien_servicio_con_contrato($id_contratro_para_complemento){ 
if($id_contratro_para_complemento > 0 and $id_contratro_para_complemento != ""){ 
if($_SESSION["id_us_session"]==32){
	//echo $id_contratro_para_complemento;
	}
$sel_contrato = traer_fila_row(query_db("select tipo_bien_servicio from t7_contratos_contrato where id=".$id_contratro_para_complemento));
if($sel_contrato[0] == "Bienes" or $sel_contrato[0] == " Bienes" or $sel_contrato[0] == "Bienes "){ return " Bienes";} else { return " Servicios";}
}
}


function comprobar_nit_en_par($nit){ 
$esta_en_par = $nit;
   //compruebo que los caracteres sean los permitidos 
   $permitidos = "0123456789-., "; 
   for ($i=0; $i<strlen($nit); $i++){ 
      if (strpos($permitidos, substr($nit,$i,1))===false){ 
         $esta_en_par = " NO esta en Par Servicios"; 
      } 
   } 

   return $esta_en_par; 
}

function trm_presupuestal($anio){
	$valor_trm =3000;
/*	if($anio == 18 or $anio == 2018){return 2300; }
	if($anio == 17 or $anio == 2017){return 2300; }
	if($anio == 16 or $anio == 2016){return 2300; }
	*/
	if($anio == 16 or $anio == 2016){$valor_trm =3000; }
	if($anio == 15 or $anio == 2015){$valor_trm =2300; }
	if($anio == 14 or $anio == 2014){$valor_trm =1900; }
	if($anio == 13 or $anio == 2013){$valor_trm =1780; }
	return $valor_trm;
}

function trm_actual (){
	$sel_trm_diaria = traer_fila_row(query_db("select top(1)  valor_trm_cop from t1_trm_diaria order by id desc"));
	return $sel_trm_diaria[0];
	}

function disponible_serv_menor_ano_atras($id_proveedor_funcion, $id_item_fun_actual){
	global $fecha;
	$comprometido_total_usd_sm = 0;
	$v_sm_sap = 0;
	$v_sm_no_sap = 0;
	$v_sm_item_actual = 0;
	
$fecha_menos_un_ano = strtotime ( '-1 year' , strtotime ( $fecha ) ) ; 
$fecha_menos_un_ano = date ( 'Y-m-j' , $fecha_menos_un_ano ); 
$sel_valores_sm_sap=traer_fila_row(query_db("select sum (sum_valor_usd) as valor_total from vista_servicios_menores_valores_sap where id_proveedor ='".$id_proveedor_funcion." '  and Convert(char, fecha_doc, 103) >= Convert(char, '".$fecha_menos_un_ano."', 103)"));// suma de servicios_menores		
$sel_valores_sm_no_sap=traer_fila_row(query_db("select sum (valor_usd) as valor_total from vista_servicios_menores_valores_sin_aprobar_sgpa where id_proveedor ='".$id_proveedor_funcion." ' and id_item <> ".$id_item_fun_actual." and estado not in (32,33)"));//  Valor de Las solicitudes donde esta relacionado el proveedor excepto la actual
$sel_valores_sm_item_actual=traer_fila_row(query_db("select sum (valor_usd) as valor_total from vista_servicios_menores_valores_sin_aprobar_sgpa where id_proveedor ='".$id_proveedor_funcion." ' and id_item = ".$id_item_fun_actual));//  Valor solicitud actual
		
		
		$v_sm_sap =  $sel_valores_sm_sap[0] * 1;
		$v_sm_no_sap =  $sel_valores_sm_no_sap[0] * 1;
		$v_sm_item_actual =  $sel_valores_sm_item_actual[0] * 1;		
		$comprometido_total_usd_sm = 	$v_sm_sap + $v_sm_no_sap + $v_sm_item_actual;
		$disponible_total_usd_sm = 	$_SESSION["valor_maximo_ser_menor"] - ($v_sm_sap + $v_sm_no_sap + $v_sm_item_actual);
		
		return $comprometido_total_usd_sm."*".$v_sm_sap."*".$v_sm_no_sap."*".$v_sm_item_actual."*".$disponible_total_usd_sm;


	}

function busca_area_emula($campo_bd,$bus_area){
	
	switch($bus_area){
		case 34: $areas_in = $bus_area.", 24"; break;
		case 35: $areas_in = $bus_area.", 25,20";break;
		case 36: $areas_in = $bus_area.", 22,26,32";break;
		case 37: $areas_in = $bus_area.", 6";break;
		case 38: $areas_in = $bus_area.", 21, 29";break;
		case 39: $areas_in = $bus_area.", 12";break;
		case 40: $areas_in = $bus_area.", 17";break;
		case 41: $areas_in = $bus_area.", 18";break;
		case 44: $areas_in = $bus_area.", 1";break;
		case 46: $areas_in = $bus_area.", 31";break;
		case 47: $areas_in = $bus_area.", 13";break;
		case 48: $areas_in = $bus_area.", 7";break;
		case 49: $areas_in = $bus_area.", 8";break;
		case 50: $areas_in = $bus_area.", 14";break;
		case 55: $areas_in = $bus_area.", 5";break;
		default: $areas_in = $bus_area;
		}
		$query =" and $campo_bd in ($areas_in) ";
	
		return $query;
	}

function antiguo_area_emula($bus_area){
	
	switch($bus_area){
		case 24: $areas_in = 34; break;
		case ($bus_area==25 || $bus_area == 20): $areas_in = 35;break;
		case ($bus_area == 22 || $bus_area == 26 || $bus_area == 32): $areas_in = 36;break;
		case  6: $areas_in = 37;break;
		case ($bus_area == 21 || $bus_area == 29): $areas_in = 38;break;
		case 12: $areas_in = 39;break;
		case 17: $areas_in = 40;break;
		case 18: $areas_in = 41;break;
		case  1: $areas_in = 44;break;
		case 31: $areas_in = 46;break;
		case 13: $areas_in = 47;break;
		case  7: $areas_in = 48;break;
		case  8: $areas_in = 49;break;
		case 15: $areas_in = 50;break;
		case  5: $areas_in = 55;break;
		default: $areas_in = $bus_area;
		}
		$query = $areas_in;
	
		return $query;
	}
function aprobaciones_por_area($is_area){
	global $g1;
	$comple_rep_apro = " and t1_area_id = ".$is_area;
		$_GET["consulta"] =  "si";
	
	?>
	<table width="100%" border="<? if($_GET["consulta"] ==  "si") echo "0"; else echo "1";?>" class="tabla_lista_resultados">
      <tr bgcolor="#005395">
        <td width="16%" align="center"><font color="#FFFFFF"><strong>Norma de actos y transacciones</strong></font></td>
        <td width="18%" align="center"><font color="#FFFFFF"><strong>Proceso de Selecci&oacute;n para Bienes y Servicios</strong></font></td>
        <td width="19%" align="center"><font color="#FFFFFF"><strong>Nivel que Puede Realizar la Aprobaci&oacute;n</strong></font></td>
        <td width="47%" align="center"><font color="#FFFFFF"><strong>Nombre del Responsable Aprobaci&oacute;n</strong></font></td>
      </tr>
      <?
$separacion = "<br />";
  $sel_areas = query_db("select t1_area_id, nombre_html from t1_area where estado = 1 $comple_rep_apro order by nombre_html");
  while($s_a = traer_fila_db($sel_areas)){
	  
	  $nivel_1 = "";
	  $nivel_2 = "";
	  $nivel_3 = "";
	  $nivel_4 = "";
	  $nivel_1_us = "";
	  $nivel_2_us = "";
	  $nivel_3_us = "";
	  $nivel_4_us = "";
	  
$es_reemplazo_jefe="";
$es_reemplazo_gerente="";
$es_reemplazo_vice="";
$es_reemplazo_director="";
$es_reemplazo_presidente="";

	  $sel_usuar_nivel_4 = query_db("select t2.us_id, t2.nombre_administrador from tseg3_usuario_areas as t1, t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t1.id_area = ".$s_a[0]." and t1.id_usuario = t2.us_id and t2.us_id = t3.id_usuario and t3.id_rol_general = 23 and t2.estado = 1");
	  while ($sel_n_4 = traer_fila_db($sel_usuar_nivel_4)){
	 
	 if(cual_es_el_reemplazo($sel_n_4[0]) != $sel_n_4[0]){
		  $es_reemplazo_jefe =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_4[0],'nombre_administrador','us_id')."</strong>";
		 $nivel_4_us = $nivel_4_us." IV. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_4[0]),'nombre_administrador','us_id').$es_reemplazo_jefe." $separacion ";
	 }else{
		  			$nivel_4_us = $nivel_4_us." IV. ". $sel_n_4[1]." $separacion ";
	 }
				 
			$nivel_4 = " IV. Jefatura $separacion ";
			$id_rol_4 = "45";
			$id_us_rol_4 = $sel_n_4[0];
		  }
		  
	$sel_usuar_nivel_3 = query_db("select t2.us_id, t2.nombre_administrador from tseg3_usuario_areas as t1, t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t1.id_area = ".$s_a[0]." and t1.id_usuario = t2.us_id and t2.us_id = t3.id_usuario and t3.id_rol_general = 10 and t2.estado = 1");
	  while ($sel_n_3 = traer_fila_db($sel_usuar_nivel_3)){
		  
	if(cual_es_el_reemplazo($sel_n_3[0]) != $sel_n_3[0]){
		  $es_reemplazo_gerente =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_3[0],'nombre_administrador','us_id')."</strong>";
		 $nivel_3_us = $nivel_3_us." III. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_3[0]),'nombre_administrador','us_id').$es_reemplazo_gerente." $separacion ";
	 }else{
		  			$nivel_3_us = $nivel_3_us." III. ". $sel_n_3[1]." $separacion ";
	 }
	 
		  	//$nivel_3_us = $nivel_3_us." 3. ". $sel_n_3[1]." / ";
			$nivel_3 = " III. Gerente de Area $separacion ";
			$id_rol_3 = "9";
			$id_us_rol_3 = $sel_n_4[0];
		  }
	
	$sel_usuar_nivel_2 = query_db("select t2.us_id, t2.nombre_administrador from tseg3_usuario_areas as t1, t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t1.id_area = ".$s_a[0]." and t1.id_usuario = t2.us_id and t2.us_id = t3.id_usuario and t3.id_rol_general = 22 and t2.estado = 1");
	  while ($sel_n_2 = traer_fila_db($sel_usuar_nivel_2)){
	if(cual_es_el_reemplazo($sel_n_2[0]) != $sel_n_2[0]){
		  $es_reemplazo_vice =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_2[0],'nombre_administrador','us_id')."</strong>";
		$nivel_2_us = $nivel_2_us." II. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_2[0]),'nombre_administrador','us_id').$es_reemplazo_vice." $separacion ";
	 }else{
		  			$nivel_2_us = $nivel_2_us." II. ". $sel_n_2[1]." $separacion ";
	 }
		  	//$nivel_2_us = $nivel_2_us." 2. ". $sel_n_2[1]." / ";
			$nivel_2 = " II. Vicepresidencia $separacion ";
			$id_rol_2 = "20";
			$id_us_rol_2 = $sel_n_4[0];
		  }
	$sel_usuar_nivel_2 = query_db("select t2.us_id, t2.nombre_administrador from tseg3_usuario_areas as t1, t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t1.id_area = ".$s_a[0]." and t1.id_usuario = t2.us_id and t2.us_id = t3.id_usuario and t3.id_rol_general = 28 and t2.estado = 1");
	  while ($sel_n_2 = traer_fila_db($sel_usuar_nivel_2)){
		  if(cual_es_el_reemplazo($sel_n_2[0]) != $sel_n_2[0]){
		  $es_reemplazo_director =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_2[0],'nombre_administrador','us_id')."</strong>";
		 $nivel_2_us = $nivel_2_us." II. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_2[0]),'nombre_administrador','us_id').$es_reemplazo_director." $separacion ";
	 }else{
		  			$nivel_2_us = $nivel_2_us." II. ". $sel_n_2[1]." $separacion ";
	 }
		  //	$nivel_2_us = $nivel__us2." 2. ". $sel_n_2[1]." / ";
			$nivel_2 = " II. Director $separacion ";
			$id_rol_2 = "43";
			$id_us_rol_2 = $sel_n_4[0];
		  }
		  
	$sel_usuar_nivel_1 = query_db("select t2.us_id, t2.nombre_administrador from t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t2.us_id = t3.id_usuario and t3.id_rol_general = 12 and  t2.estado = 1");
	  while ($sel_n_1 = traer_fila_db($sel_usuar_nivel_1)){
		  if(cual_es_el_reemplazo($sel_n_1[0]) != $sel_n_1[0]){
		  $es_reemplazo_presidente =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_1[0],'nombre_administrador','us_id')."</strong>";
		 $nivel_1_us = $nivel_1_us." I. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_1[0]),'nombre_administrador','us_id').$es_reemplazo_presidente."  ";
	 }else{
		  			$nivel_1_us = $nivel_1_us." I. ". $sel_n_1[1]." ";
	 }
		//  	$nivel_1_us = $nivel_1_us." 1. ". $sel_n_1[1]."";
			$nivel_1 = " I. Presidente";
			$id_rol_1 = "48";
			$id_us_rol_1 = $sel_n_4[0];
		  }
	  
	  
	  if($color_principal == ""){
		  $bg_color_p = "#E8E8E8";
		  $color_principal = 1;
		  }else{
			  $bg_color_p = "";
			  $color_principal = "";
			  }
		$sel_valor_solicitud = traer_fila_row(query_db("select sum (eq_usd) from v_pecc_n_servicio_2 where id_item = ".$id_item_pecc));	  
	
  ?>
      <tr bgcolor="<?=$bg_color_p?>">
        <td align="center">0  &lt;= 24.999</td>
        <td>Servicio Menor</td>
        <td><?=$nivel_4?>
          <?=$nivel_3?>
          <?=$nivel_2?>
          <?=$nivel_1?></td>
        <td><?=$nivel_4_us?>
          <?=$nivel_3_us?>
          <?=$nivel_2_us?>
          <?=$nivel_1_us?></td>
      </tr>
      <tr bgcolor="<?=$bg_color_p?>">
        <td align="center"> 0 &lt;= 30.000</td>
        <td>Negociaci&oacute;n Directa</td>
        <td><?=$nivel_4?>
          <?=$nivel_3?>
          <?=$nivel_2?>
          <?=$nivel_1?></td>
        <td><?=$nivel_4_us?>
          <?=$nivel_3_us?>
          <?=$nivel_2_us?>
          <?=$nivel_1_us?></td>
      </tr>
      <? 
	  
			
	?>
      <tr bgcolor="<?=$bg_color_p?>">
        <td align="center"> 30.001 &lt;= 40.000 </td>
        <td>Negociaci&oacute;n Directa</td>
        <td><?=$nivel_3?>
          <?=$nivel_2?>
          <?=$nivel_1?></td>
        <td><?=$nivel_3_us?>
          <?=$nivel_2_us?>
          <?=$nivel_1_us?></td>
      </tr>
      <tr bgcolor="<?=$bg_color_p?>">
        <td align="center"> 40.001 &lt;=  200.000</td>
        <td>Negociaci&oacute;n Directa</td>
        <td><?=$nivel_2?>
          <?=$nivel_1?></td>
        <td><?=$nivel_2_us?>
          <?=$nivel_1_us?></td>
      </tr>
      <tr bgcolor="<?=$bg_color_p?>">
        <td align="center">&gt;   200.001</td>
        <td>Negociaci&oacute;n Directa</td>
        <td>Comit&eacute;</td>
        <td>COMITE DE CONTRATACION</td>
      </tr>
      <tr bgcolor="<?=$bg_color_p?>">
        <td align="center">0 &lt;= 200.000</td>
        <td>Licitaci&oacute;n</td>
        <td><?=$nivel_3?>
          <?=$nivel_2?>
          <?=$nivel_1?></td>
        <td><?=$nivel_3_us?>
          <?=$nivel_2_us?>
          <?=$nivel_1_us?></td>
      </tr>
      <tr bgcolor="<?=$bg_color_p?>">
        <td align="center">200.001 &lt;= 500.000 </td>
        <td>Licitaci&oacute;n</td>
        <td><?=$nivel_2?>
          <?=$nivel_1?></td>
        <td><?=$nivel_2_us?>
          <?=$nivel_1_us?></td>
      </tr>
      <tr bgcolor="<?=$bg_color_p?>">
        <td align="center">&gt; 500.001</td>
        <td>Licitaci&oacute;n</td>
        <td>Comit&eacute;</td>
        <td>COMITE DE CONTRATACION</td>
      </tr>
     
      <?
  }
  ?>
   <tr>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><font color="#0033FF">Descargar Norma de Actos y Transacciones</font></td>
      </tr>
    </table>
	<?
	}
	
function nombre_archivo_adjunto($archivo){
		$archivo = str_replace(".","_", $archivo);
		$archivo = str_replace("#","_", $archivo);
		$archivo = str_replace("*","_", $archivo);
		$archivo = str_replace(",","_", $archivo);
		$archivo = str_replace(";","_", $archivo);
		$archivo = str_replace("&","y", $archivo);
		return $archivo;
	}
	
function extencion_archivos_sgpa($archivo){
	$busca_archi = explode(".",$archivo);
	$cua = count($busca_archi);
	$extencion = $busca_archi[$cua-1]; 
	$largo = strlen($archivo);
	$comienzo = ($largo-3);
	$ext = substr($archivo, $comienzo , 3);
	
	return $extencion;
	}
	
?>