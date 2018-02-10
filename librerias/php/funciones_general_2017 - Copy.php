	<?php
	
	function selecciona_profesional($id_usuario_gerente_funct, $area_funct, $id_item_pecc_funct, $id_tipo_contratacion_funct){
		
		//BUSCA Y SELEECIONA EL PROFESIONAL ENCARGADO
global $v_seg1;
		
		

$sel_profss_especifico_usuario_area = traer_fila_row(query_db("select id_us_profesional, id_us_prof_compras_corp, id_us_prof_compras_mro, id_us_prof_compras_stok, id_us_prof_servicios_menores from tseg10_usuarios_profesional where id_area = ".$area_funct." and id_us =  '$id_usuario_gerente_funct'"));
$profesional_asig=0;

if($id_tipo_contratacion_funct==1){//profesional de servicios
$profesional_asig= $sel_profss_especifico_usuario_area[0];
}else{//profesional de compras
if($id_tipo_contratacion_funct==2){
$profesional_asig= $sel_profss_especifico_usuario_area[2];
}
if($id_tipo_contratacion_funct==3){
$profesional_asig= $sel_profss_especifico_usuario_area[3];
}
if($id_tipo_contratacion_funct==4){
$profesional_asig= $sel_profss_especifico_usuario_area[1];
}
}
if($id_tipo_contratacion_funct==16){//Si es servicios_menores
	$profesional_asig= $sel_profss_especifico_usuario_area[1];
	}
	
		$el_gerente = saber_gerente_cotrato($id_item_pecc_funct);
$sele_permiso = traer_fila_row(query_db("select * from $v_seg1 where us_id = ".$el_gerente." and id_premiso = 30"));//verificar si es el profesioanl de compras nanky
if($sel_item[6]==8){
	$sel_prfesional_contrato=traer_fila_row(query_db("select t3.especialista from t2_presupuesto as t1, t2_presupuesto_aplica_contrato as t2, t7_contratos_contrato as t3 where t1.t2_item_pecc_id = ".$id_item_pecc." and t1.permiso_o_adjudica =1 and t2.t2_presupuesto_id =t1.t2_presupuesto_id and t2.t7_contrato_id = t3.id"));
	$profesional_asig= $sel_prfesional_contrato[0];
	}
if($profesional_asig>0){
$profesional_seleccionado = $profesional_asig;
}else{
$sele_si_es_profesional = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos where id_usuario=".$id_usuario_gerente_funct." and id_permiso = 8"));
	if($sele_si_es_profesional[0] > 0){//si el solicitante tiene permiso de profesional
		$profesional_seleccionado = $id_usuario_gerente_funct;
	}
}
if( $sele_permiso[0] > 0){//si el gerente es el mismo profesional de compras nanky
$profesional_seleccionado = $el_gerente;
}
		
return $profesional_seleccionado;

// FIN BUSCA Y ASIGAN PROFESIONAL


}
function ayuda_alerta_pequena_sin_img($texto_ayuda){
	$ayuda_carga='
	<table width="100%" cellpadding="0" cellspacing="0" >	
    	<tr >
        	<td colspan="4" align="left">
        		<table border="0" width="100%">
        			
        			<td width="99%" align="left" font-size: 10px;">	
        				<font  color="#229BFF">&nbsp;'.$texto_ayuda.'
        			</td>
        		</table>
        	</td>
        </tr>

    
</table>';
	return $ayuda_carga;

}
function ayuda_alerta_pequena($texto_ayuda){
	$ayuda_carga='
	<table width="100%" cellpadding="0" cellspacing="0" >	
    	<tr >
        	<td colspan="4" align="right">
        		<table border="0" width="100%">
        			
        			<td width="99%" align="right" style="font-weight: 900; font-size: 14px;">	
        				<i><img src="../imagenes/botones/icono_ayuda.png" ></i><font face="roboto" color="#229BFF">&nbsp;'.$texto_ayuda.'
        			</td>
        		</table>
        	</td>
        </tr>

    
</table>';
	return $ayuda_carga;

}
function ayuda_alerta_pequenaaling_izq_in_iframe($texto_ayuda){
	$ayuda_carga='
	<table width="100%" cellpadding="0" cellspacing="0" >	
    	<tr >
        	<td colspan="4" align="left">
        		<table border="0" width="100%">
        			
        			<td width="99%" align="left" style="font-weight: 900; font-size: 14px;">	
        				<i><img src="../../../../imagenes/botones/icono_ayuda.png" ></i><font face="roboto" color="#229BFF">&nbsp;'.$texto_ayuda.'
        			</td>
        		</table>
        	</td>
        </tr>

    
</table>';
	return $ayuda_carga;

}
function ayuda_alerta($texto_ayuda){
	$ayuda_carga='
	<table width="100%" cellpadding="2" cellspacing="2" style="border-radius: 10px; border-color: #229BFF; border-bottom: 1px solid #229BFF; border-top: 1px solid #229BFF; border-left: 1px solid #229BFF; border-right: 1px solid #229BFF; margin-bottom: -0px;">	
     	<tr >
        	<td colspan="4" align="left" >
        		<table border="0" width="100%">
        			<td width="1%" align="left"><i class="material-icons md-1" style="color: #229BFF;">&#xE8FD;</i></td>
        			<td width="99%" align="left" style="font-weight: 900;">	
        				<font size="3" face="roboto" color="#999999" >'.$texto_ayuda.'
        			</td>
        		</table>
        	</td>
        </tr>

    
</table>';
	return $ayuda_carga;

}
function verifica_rol_usuario($id_usuario, $id_roles){//id_roles pueden venir separados por comas
		$sel_rol_usuario = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$id_usuario." and id_rol_general in (".$id_roles.")"));
		$tiene_rol = "NO";
		if($sel_rol_usuario[0]>0){
			$tiene_rol = "SI";
			}
			return $tiene_rol;
		
		}

function fecha_en_firme($id_item_requiere){
	$select_minmima_gestion = traer_fila_row(query_db("select MIN(fecha_real) from t2_nivel_servicio_gestiones where id_item=".$id_item_requiere." and estado = 1"));
$fecha_puso_firme="";
if($select_minmima_gestion[0]!=""){$fecha_puso_firme = $select_minmima_gestion[0];}
return $fecha_puso_firme;
	}

function actualiza_fecha_en_firme($id_item_requiere){	
	$fecha_en_firme = fecha_en_firme($sel_sol[0]);
	$update = query_db("update t2_item_pecc set fecha_en_firme = '".$fecha_en_firme."' where id_item =  ".$id_item_requiere);
}
	
function vari_si_reempla($id_us_original){
	if(in_array($id_us_original, $_SESSION["usuarios_array"] , true)){
		return "SI";
		}else{
			return "NO";
			}
	}
	function es_profesional_cyc($id_us_para_compra){
		$sel_rol_proefesional = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario =".$id_us_para_compra." and id_rol_general in (13, 17) ")); 
		if($sel_rol_proefesional[0]>0) return "SI"; else return "NO";
		}
function traer_anexos_pecc($ano){
	
	if($ano == "2016"){
	$comple_anexos_pecc = " or t2_anexo_id in (49334, 49335, 49336, 49337)";
	}elseif($ano == "2017"){
	 $comple_anexos_pecc = " or t2_anexo_id in (58608,58607,58606,58605,58604,58603,58602,58601,58600)";
	}elseif($ano == "2018"){
	 $comple_anexos_pecc = " or t2_anexo_id in (74564, 74565, 74566, 74567)";
	}else{
		$comple_anexos_pecc = "";
	}
	return $comple_anexos_pecc;	

}
function configuracion_de_firmas($id_item_pecc, $tipo_adj_permiso, $pecc){
	global $pi2, $pi14, $pi15, $pi16, $pi17, $vpeec13, $vpeec14, $trae_id_insrte, $presidente, $co1, $pi8, $pi8, $g15, $pi12, $fecha,$v_seg1;//el presidente esta en la hoja db_tablas.php
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
		
if($pecc == ""){//si no es PECC*--------------------------------*************************************************--------------------------------------*****************
			
//configura jefaturas

			$sele_si_aplica_jefatura = traer_fila_row(query_db("select count(*) from tseg14_relacion_usuario_superintendente where id_us=".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5])." "));
			$sel_si_tiene_comite_vice_direc = traer_fila_row(query_db("select count(*) from $vpeec13 where id_item = ".$id_item_pecc." and id_rol_permiso in (10,45,43,20)"));	
			if($sele_si_aplica_jefatura[0] > 0){		
			$sel_valor_solicitud = traer_fila_row(query_db("select sum (eq_usd) from v_pecc_n_servicio_2 where id_item = ".$id_item_pecc));
			$rol_jefe_no_aplica="";
			
				if(($sel_valor_solicitud[0]< 30000 and $sel_item[6] != 1) or ($sel_item[6] == 8) or ($sel_valor_solicitud[0]< 100000 and $sel_item[6] == 1)){
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
				if($sel_item[6] == 12 ){//si es reclasificacion
				$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $pi8.al_valor_inicial_para_marco = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));				
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
				}//FIN si es reclasificacion
			
}
/*FIN AGREGA FIRMAS EXCLUCIVAS DE ADJUDICACION - OTROSI, OT, AMPLIACIONES*/			

}//fin si no es PECC*--------------------------------*************************************************--------------------------------------*****************/
// RECORRE LAS FIRMAS SEGUN LA VISTA

$comple_sql_pecc = " and id_rol_permiso not in (0)";
if($pecc == "PECC"){
	$comple_sql_pecc = " and id_rol_permiso in (8)";//para que solo traiga al profesional
	/*para incluir el gerente de solciitud*/
	$insert = "insert into $pi14 (id_item_pecc, id_rol, orden, estado,por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", 51,6,1,2,".$tipo_adj_permiso.")";
	$sql_ex=query_db($insert.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);	
	$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado, id_usuario_original) values (".$id_ingreso.", ".cual_es_el_reemplazo($sel_item[3]).",1, '".$sel_item[3]."')");
	/*para incluir el gerente de solciitud*/
	}

	
			$sele_pro_sistem = query_db("select id_rol_permiso, orden from $vpeec13 where id_item = ".$id_item_pecc." ".$rol_jefe_no_aplica." ".$comple_sql_pecc."  group by id_rol_permiso, orden order by orden");
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
					echo "select us_id from $v_seg1 where id_premiso = 11";
					$sele_pro_sistem_usuarios_socios = traer_fila_row(query_db("select us_id from $v_seg1 where id_premiso = 11"));
					$insert52 = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario, estado) values (".$id_ingreso.", ".$sele_pro_sistem_usuarios_socios[0].",1)");			
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
							// --------- VICEPRESIDENTE  ------------------							
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
								}// --------- FIN  VICEPRESIDENTE  ------------------
								// --------- DIRECTOR ------------------
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
						}	// --------- fin DIRECTOR ------------------
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
				
					if(($sel_p_sist[0] <> 15 and $sel_p_sist[0] <> 11  and $sel_p_sist[0] <> 31) and ($sel_p_sist[0] <> 8 or $sel_item[23] == "") and $sel_p_sist[0] <> 42 and $sel_p_sist[0] <> 43 and $sel_p_sist[0] <> 20 and $sel_p_sist[0] <> 9){	//CREA LOS USUARIOS ENCARGADOS		
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
			
		
	/*validacion si despues de configurar las firmas incluso con los reemplazos el solicitante queda en alguna instancia de aprobacion*/
	$sel_algun_rol_que_sea_el_msmo_sql = "select t1.id_secuencia_solicitud, t1.id_rol from t2_agl_secuencia_solicitud as t1, t2_agl_secuencia_solicitud_usuario as t2 where t1.id_secuencia_solicitud = t2.id_secuencia_solicitud and t1.id_rol in (45,9,20,43) and t2.id_usuario = ".$gerente_solicitante." and t2.estado = 1 and t1.estado = 1 and tipo_adj_permiso = ".$tipo_adj_permiso." and por_sistema = 1";
	$sel_algun_rol_que_sea_el_msmo = query_db($sel_algun_rol_que_sea_el_msmo_sql);
	
	while($sel_roles_aplica = traer_fila_db($sel_algun_rol_que_sea_el_msmo)){
			echo "ROL".$sel_roles_aplica[0]." - ".$sel_roles_aplica[1];
			$nuevo_rol="";
			$nuevo_usuario_rol="";
			
			if($sel_roles_aplica[1] == 45){//si se repite en la jefatura.
			$sele_si_gerente_area = traer_fila_row(query_db("select id_jefe_area from tseg13_relacion_usuario_jefe where id_us = ".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5]).""));					
					if($sele_si_gerente_area[0]>0){//SI EN LA RELACION EL USUARIO TIENE GERENTE/JEFE DE AREA					
					$nuevo_rol=9;
					$nuevo_usuario_rol=$sele_si_gerente_area[0];		
					}	
					if($nuevo_rol == ""){// verifica si tiene Vicepresidente
						$sele_si_vicepresidente = traer_fila_row(query_db("select id_vicepresidente from tseg15_relacion_usuario_vicepresidente where id_us = ".$gerente_solicitante." and area = ".antiguo_area_emula($sel_item[5]).""));
						if($sele_si_vicepresidente[0]>0){//SI EN LA RELACION EL USUARIO TIENE vicepresidente				
						$nuevo_rol=20;
						$nuevo_usuario_rol=$sele_si_vicepresidente[0];		
						}	
					}
					if($nuevo_rol == ""){// verifica si tiene director
						$sele_si_vicepresidente = traer_fila_row(query_db("select id_director from tseg15_relacion_usuario_director where us_id = ".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5]).""));
						if($sele_si_vicepresidente[0]>0){//SI EN LA RELACION EL USUARIO TIENE Director					
						$nuevo_rol=20;
						$nuevo_usuario_rol=$sele_si_vicepresidente[0];		
						}	
					}
					if($nuevo_rol == ""){// asigna el presidente
						$nuevo_rol=48;
						$nuevo_usuario_rol=$presidente;
					}
				}
			if($sel_roles_aplica[1] == 9){//si se repite en la gerencia.
						$sele_si_vicepresidente = traer_fila_row(query_db("select id_vicepresidente from tseg15_relacion_usuario_vicepresidente where id_us = ".$gerente_solicitante." and area = ".antiguo_area_emula($sel_item[5]).""));
						if($sele_si_vicepresidente[0]>0){//SI EN LA RELACION EL USUARIO TIENE vicepresidente					
						$nuevo_rol=20;
						$nuevo_usuario_rol=$sele_si_vicepresidente[0];		
						}	
					if($nuevo_rol == ""){// verifica si tiene director
						$sele_si_vicepresidente = traer_fila_row(query_db("select id_director from tseg15_relacion_usuario_director where us_id = ".$gerente_solicitante." and id_area = ".antiguo_area_emula($sel_item[5]).""));
						if($sele_si_vicepresidente[0]>0){//SI EN LA RELACION EL USUARIO TIENE Director				
						$nuevo_rol=20;
						$nuevo_usuario_rol=$sele_si_vicepresidente[0];		
						}	
					}
					if($nuevo_rol == ""){// asigna el presidente
						$nuevo_rol=48;
						$nuevo_usuario_rol=$presidente;
					}
				}
			if($sel_roles_aplica[1] == 20 or $sel_roles_aplica[1] == 43){//si se repite en la gerencia.
						// asigna el presidente
						$nuevo_rol=48;
						$nuevo_usuario_rol=$presidente;
					
				}
				
				/*Actualiza Nuevo ROL*/
				if($nuevo_rol != ""){
					$update_secuencia = query_db("update t2_agl_secuencia_solicitud set id_rol = ".$nuevo_rol." where id_secuencia_solicitud = ".$sel_roles_aplica[0]);
					$update_usuario = query_db("update t2_agl_secuencia_solicitud_usuario set id_usuario = ".cual_es_el_reemplazo($nuevo_usuario_rol).", id_usuario_original= ".$nuevo_usuario_rol." where id_secuencia_solicitud = ".$sel_roles_aplica[0]);
					}
				/*FiN Actualiza Nuevo ROL*/
				
		}
	
	
	/* FIN validacion si despues de configurar las firmas incluso con los reemplazos el solicitante queda en alguna instancia de aprobacion*/
	
	/*Valida si es una reclasificacion cambia al Viceprecidente por Andres Montoya.*/
	if($sel_item[6] == 12 and ($sel_item[2]==522 or $sel_item[2]==525 or $sel_item[2]==528 or $sel_item[2]==531) ){//si es reclasificacion y va para comite, se sabe por el ANs que toma
	$id_vp_finanzas = 17935;

	$sel_rol_vicepresidente_director = query_db("update t2_agl_secuencia_solicitud set id_rol = 20, orden = 15 where  id_item_pecc = ".$sel_item[0]." and id_rol in (43,20)");			
	$sel_rol_vicepresidente_director = query_db("select id_secuencia_solicitud from t2_agl_secuencia_solicitud where  id_item_pecc = ".$sel_item[0]." and id_rol in (20)");
	while($sel_aproba = traer_fila_db($sel_rol_vicepresidente_director )){
		$update = query_db("update t2_agl_secuencia_solicitud_usuario set estado = 3 where id_secuencia_solicitud = ".$sel_aproba[0]);
		$update = query_db("insert into t2_agl_secuencia_solicitud_usuario (id_secuencia_solicitud, id_usuario, estado, id_usuario_original) values ('".$sel_aproba[0]."','".cual_es_el_reemplazo($id_vp_finanzas)."', 1, '".$id_vp_finanzas."')");
		
		//$update_jefe_otras_areas = traer_fila_row(query_db("update t2_agl_secuencia_solicitud set id_rol = 49 where id_item_pecc = ".$sel_item[0]." and tipo_adj_permiso = 2 and id_rol = 45"));
		
		global $trae_id_insrte,$id_jefe_abastecimiento;
		//$insert_jefe_abas = "insert into t2_agl_secuencia_solicitud (id_item_pecc, id_rol, orden, estado, por_sistema, tipo_adj_permiso) values (".$sel_item[0].", 45, 12, 1,1,2)";
		//$sql_ex=query_db($insert_jefe_abas.$trae_id_insrte);
		//$id_secuencia_jefe = id_insert($sql_ex);//id del contrato
		
		//$update = query_db("insert into t2_agl_secuencia_solicitud_usuario (id_secuencia_solicitud, id_usuario, estado, id_usuario_original) values ('".$id_secuencia_jefe."','".cual_es_el_reemplazo($id_jefe_abastecimiento)."', 1, '".$id_jefe_abastecimiento."')");
		
		}
	}
	/*Valida si es una reclasificacion cambia al Viceprecidente por Andres Montoya.*/
$id_vp_finanzas = 17935;	
	
	/*validacion si es una solicitud de abastecimiento o de Logistica, agrega al vice si solo esta el jefe*/
//or $sel_item[5]==39
if($sel_item[5]==1 or $sel_item[5]==44 ){//si corresponden a las areas de la jefatura de abasteimiento

		$sel_si_comite = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and tipo_adj_permiso=".$tipo_adj_permiso." and estado = 1 and id_rol = 10"));
		if($sel_si_comite[0]<=0){//solo si NO va a comite de contratos valide que tenga al vice.
		$sel_si_vice = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and tipo_adj_permiso=".$tipo_adj_permiso." and estado = 1 and id_rol = 20"));
		
		if($sel_si_vice[0]<=0){//si no tiene el vice presidente, insertelo
		$insert_vice = "insert into t2_agl_secuencia_solicitud (id_item_pecc, id_rol, orden, estado, por_sistema, tipo_adj_permiso) values (".$sel_item[0].", 20, 12, 1,1,".$tipo_adj_permiso.")";
		$sql_ex_vice=query_db($insert_vice.$trae_id_insrte);
		$id_secuencia_vice = id_insert($sql_ex_vice);//id del contrato
		
		$update = query_db("insert into t2_agl_secuencia_solicitud_usuario (id_secuencia_solicitud, id_usuario, estado, id_usuario_original) values ('".$id_secuencia_vice."','".cual_es_el_reemplazo($id_vp_finanzas)."', 1, '".$id_vp_finanzas."')");
			}
		}
}
	/*FIN validacion si es una solicitud de abastecimiento o de Logistica, agrega al vice si solo esta el jefe*/
	
	/*validacion si es comprador asigna obligatorio al rol coordinador de compras*/
	if(verifica_rol_usuario($sel_item[23], 17) == "SI"){
		$sel_si_comite = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_item[0]." and tipo_adj_permiso=".$tipo_adj_permiso." and estado = 1 and id_rol = 10"));
		if($sel_si_comite[0]>0){//solo si va a comite de contratos agregue la firma del coordinador.
		$insert_coor_compras = "insert into t2_agl_secuencia_solicitud (id_item_pecc, id_rol, orden, estado, por_sistema, tipo_adj_permiso) values (".$sel_item[0].", 50, 5, 1,1,".$tipo_adj_permiso.")";
		$sql_ex=query_db($insert_coor_compras.$trae_id_insrte);
		$id_secuencia_coor_com = id_insert($sql_ex);//id del contrato
		$sel_coordinador_compras = traer_fila_row(query_db("select id_usuario from tseg12_relacion_usuario_rol where id_rol_general=30 "));
		$update = query_db("insert into t2_agl_secuencia_solicitud_usuario (id_secuencia_solicitud, id_usuario, estado, id_usuario_original) values ('".$id_secuencia_coor_com."','".cual_es_el_reemplazo($sel_coordinador_compras[0])."', 1, '".$sel_coordinador_compras[0]."')");
		}
	}
	/*FIN validacion si es comprador asigna obligatorio al rol coordinador de compras*/
	
	}
	

function cual_es_el_reemplazo($id_usuario){
global $fecha;
	$sel_reemplazo = traer_fila_row(query_db("select id_reemplazo from tseg_reemplazos where estado = 1 and id_us = ".$id_usuario." and  desde_cuando <='".$fecha."' and hasta_cuando >= '".$fecha."'" ));
	if($sel_reemplazo[0]>0){
		$id_usuario = $sel_reemplazo[0];
		}
	return $id_usuario;
		
	}
	
function codifica_md5($cadena){
	//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
	$encrypted = $cadena;
	return $encrypted;
}
?>