<? include("../../librerias/lib/@session.php"); 

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Soporte 1 - Tiempos de Legalizacion.xls");


?><head>
<style>
.fondo_3{ background:#E4E4E4;}
</style>
</head>


<table width="100%" border="1">
  <tr bgcolor="#E4E4E4">
              <td width="13%" align="center">Contrato</td>
              <td width="13%" align="center">Tipo de Evento</td>
              <td width="13%" align="center">Tipo de Otros&iacute;</td>
              <td width="13%" align="center">N&uacute;mero</td>
              <td width="13%" align="center">Solicitud SGPA</td>
              <td width="13%" align="center">Fecha de Creaci&oacute;n</td>
              <td width="13%" align="center">Gerente</td>
              <td width="13%" align="center">Profesional de C&amp;C</td>
              <td width="13%" align="center">Gestor de Abastecimiento</td>
              <td  align="center">Detalle</td>
              <td width="7%" align="center">Fecha Inicio</td>
              <td width="7%" align="center">Fecha Fin</td>
              <td width="11%" align="center">Rol Encargado Fecha Inicio</td>
              <td width="11%" align="center">Rol Encargado Fecha Fin</td>
              <td width="5%" align="center">Usuario que realiz&oacute; la Gesti&oacute;n Fecha Fin</td>
              <td width="5%" align="center">D&iacute;as Estimados</td>
              <td width="3%" align="center">D&iacute;as Reales</td>
              <td width="4%" align="center">D&iacute;as  Retraso</td>
              <td width="4%" align="center">Tipo de Proceso de la Solicitud</td>
              <td width="4%" align="center">Profesional de la Solicitud</td>

              </tr>
  <?
	
	  
$lista_contrato = "select * from (select ROW_NUMBER()Over(Order by id desc) As RowNum, * from $co1 where estado not in (50, 1) ".$_SESSION["comple_filtro"].") as resultado_paginado";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
	
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$lista_contrato[20]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $lista_contrato[3];//consecutivo
		$numero_contrato4 = $lista_contrato[44];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$id_contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[1]);
		$gestor_ab = "";
		if($_SESSION["gestor_abste"] > 0){
			$gestor_ab = saca_nombre_lista($g1,$_SESSION["gestor_abste"],'nombre_administrador','us_id');
			}else{
				$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$lista_contrato[10]));
				$gestor_ab = saca_nombre_lista($g1,$sel_quien_es_gestor[0],'nombre_administrador','us_id');
				
				}
		$sel_item_aprueba_contrato = traer_fila_row(query_db("select num1, num2, num3, t1_tipo_proceso_id, id_us_profesional_asignado from t2_item_pecc where id_item = ".$lista_contrato[2]));
		$numero_sol_aprueba=numero_item_pecc($sel_item_aprueba_contrato[0], $sel_item_aprueba_contrato[1], $sel_item_aprueba_contrato[2]);
		legalizaciones_de_contratos_indicador("contrato", $lista_contrato[1], 0, $id_contrato_ajus, $lista_contrato[20], saca_nombre_lista($g1,$lista_contrato[17],'nombre_administrador','us_id'), $gestor_ab, saca_nombre_lista($g1,$lista_contrato[10],'nombre_administrador','us_id'),$tp_modificacion, $tp_otro_si, $num_otro_si, $numero_sol_aprueba, $sel_item_aprueba_contrato[3], $sel_item_aprueba_contrato[4] );
		
		
	$sel_comple = "SELECT   id, id_contrato, tp_complemento, tp_otro_si, numero_otrosi, creacion_sistema, analista_deloitte, especialista, tipo_bien_servicio, gerente, id_item_modificacion, num1_modificacion, num2_modificacion, num3_modificacion, t1_tipo_proceso_id_modificacion, id_us_profesional_asignado_modificacion from v_contratos_indiador_legalizacion where id_contrato = ".$lista_contrato[1].$_SESSION["comple_filtro"];
	$sel_complemento = query_db($sel_comple);
	
	while($sel_complemento = traer_fila_db($sel_complemento)){
	$id_complemento_acumulado = $id_complemento_acumulado.",".$sel_complemento[0];
		$gestor_ab = "";
		if($_SESSION["gestor_abste"] > 0){
			$gestor_ab = saca_nombre_lista($g1,$_SESSION["gestor_abste"],'nombre_administrador','us_id');
			}else{
				$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_complemento[9]));
				$gestor_ab = saca_nombre_lista($g1,$sel_quien_es_gestor[0],'nombre_administrador','us_id');
				
				}
		
		$numero_sol_aprueba=numero_item_pecc($sel_complemento[11], $sel_complemento[12], $sel_complemento[13]);
		legalizaciones_de_contratos_indicador("modificacion", $sel_complemento[0], 0, $id_contrato_ajus, $sel_complemento[5], saca_nombre_lista($g1,$lista_contrato[17],'nombre_administrador','us_id'), $gestor_ab, saca_nombre_lista($g1,$sel_complemento[9],'nombre_administrador','us_id'),$sel_complemento[2],$sel_complemento[3], $sel_complemento[4], $numero_sol_aprueba, $sel_complemento[14], $sel_complemento[15] );
		}
		
	}
	/*SOLO MODIFICACIONES*/
	$sel_comple = "SELECT   id, id_contrato, tp_complemento, tp_otro_si, numero_otrosi, creacion_sistema, analista_deloitte, especialista, tipo_bien_servicio, gerente, id_item_modificacion, num1_modificacion, num2_modificacion, num3_modificacion, t1_tipo_proceso_id_modificacion, id_us_profesional_asignado_modificacion from v_contratos_indiador_legalizacion where id not in (0 $id_complemento_acumulado) ".$_SESSION["comple_filtro"];
	$sel_complemento_2 = query_db($sel_comple);
	while($sel_complemento = traer_fila_db($sel_complemento_2)){
		
		
		/**/
		$sel_contrato_modifi = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, especialista, gerente from t7_contratos_contrato where id = ".$sel_complemento[1]));
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sel_contrato_modifi[0]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sel_contrato_modifi[1];//consecutivo
		$numero_contrato4 = $sel_contrato_modifi[2];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$id_contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_complemento[1]);
		/**/
		
		$gestor_ab = "";
		if($_SESSION["gestor_abste"] > 0){
			$gestor_ab = saca_nombre_lista($g1,$_SESSION["gestor_abste"],'nombre_administrador','us_id');
			}else{
				$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_complemento[9]));
				$gestor_ab = saca_nombre_lista($g1,$sel_quien_es_gestor[0],'nombre_administrador','us_id');
				
				}
		
		$numero_sol_aprueba=numero_item_pecc($sel_complemento[11], $sel_complemento[12], $sel_complemento[13]);
		legalizaciones_de_contratos_indicador("modificacion", $sel_complemento[0], 0, $id_contrato_ajus, $sel_complemento[5], saca_nombre_lista($g1,$sel_contrato_modifi[3],'nombre_administrador','us_id'), $gestor_ab, saca_nombre_lista($g1,$sel_complemento[9],'nombre_administrador','us_id'),$sel_complemento[2],$sel_complemento[3], $sel_complemento[4], $numero_sol_aprueba, $sel_complemento[14], $sel_complemento[15] );
		}
	/* fin SOLO MODIFICACIONES*/
  ?>
</table>
<?


function legalizaciones_de_contratos_indicador($tipo, $id, $edita, $contrato, $fecha_creacion, $profesional, $gestor_abas, $gerente,$tp_modificacion, $tp_otro_si, $num_otro_si, $num_sol_genero_documento, $tp_proceso_sol, $prof_abas_soli){
	
	?>
    
	<table width="100%" align="center" class="tabla_lista_resultados" border="1" >
            <?
        	$entro = 0;
			?>
            
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
					if($_GET["genera_excel"]!="si"){ 
					//$comple_num_ayuda = '<img src="../imagenes/botones/help.gif" alt="'.$s_cam[5].'" width="20" height="20" title="'.$s_cam[5].'" />';
					 }
					 
					  if($expo[1]==0 or $expo[1]==""){
							  $conteo1=$conteo1+1;
							  //CON EL NUMERO ----- $num_imprime =  $comple_num_ayuda." ".$conteo1.". ".$s_cam[2];				  
							  $num_imprime =  $s_cam[2];//SIN EL NUMERO VER LINEA SUPERIOR
									 if($clase==""){
										  $clase="class='filas_resultados'";
										  }else{
											  $clase="";
											  }
							$conteo2=1;
						  }else{	
			 	  //CON EL NUMERO ----- $num_imprime =  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$comple_num_ayuda." ".$conteo1.".".$conteo2.". ".$s_cam[2];
							  $num_imprime =  $s_cam[2];//SIN EL NUMERO VER LINEA SUPERIOR
							  $conteo2 = $conteo2+1;
							  } 
					  
					 
						  
						  
						  
						  $alerta="";
						  if($s_cam[12]!=""){
						 // $alerta='<br /><strong class="letra-descuentos"><img src="../imagenes/botones/aler-interro.gif" height="20" /> '.$s_cam[12].'</strong>';
                          }
                          $bloquea_check="";
						  if($_GET["da"] == 1 and $s_cam[0]!=3){//solo si es el perfil de legal oculta todo menos la fila 3 del la tabla legalizacion_contrato
							   $bloquea_check = $display;
							   }
			  ?>
            <tr >
              <td valign="top"><?=$contrato?></td>
              <td valign="top"><?=$tp_modificacion?></td>
              <td valign="top"><?=$tp_otro_si?></td>
              <td valign="top"><?=$num_otro_si?></td>
              <td valign="top"><?=$num_sol_genero_documento?></td>
              <td valign="top"><?=$fecha_creacion?></td>
              <td valign="top"><?=$gerente?></td>
              <td valign="top"><?=$profesional?></td>
              <td valign="top"><?=$gestor_abas?></td>
              <td  valign="top"><? ?> 
			  <?
             echo $num_imprime;
			  ?> 
              
              
              </td>
              <td align="center" valign="top"> 
			  
  <? if($edita_fecha_1 == 1){?>
  
     
			  
  <? }else{ echo $sel_campos_contra[$s_cam[3]]; ?> <? }?>
              
              
              
              </td>
              <td align="center" valign="top">
	<? 
	
	if($sel_campos_contra[$s_cam[3]] == "" or $sel_campos_contra[$s_cam[3]] == " "){
				$edita_fecha_2 = 0;
			}
			
	if($edita_fecha_2 == 1){
		
		?>
       
        
        
	<? } else{ echo $sel_campos_contra[$s_cam[4]]; ?><? }?>
    
    
     
    
    
              </td>
              <td valign="top"><?
			  
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

              <td valign="top"><? 
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
		 global $g13, $g1;
			  ?></td>
              <td align="center" valign="top"><? if($tipo == "contrato"){//
				   $sel_ultima_gestion = traer_fila_row(query_db("select t1_us_usuarios.nombre_administrador from  t7_relacion_campos_legalizacion_gestiones, t1_us_usuarios where t7_relacion_campos_legalizacion_gestiones.id_us = t1_us_usuarios.us_id and t7_relacion_campos_legalizacion_gestiones.id_contrato = ".$id." and t7_relacion_campos_legalizacion_gestiones.id_t7_relacion_campos_legalizacion = ".$s_cam[0]));
				  echo $sel_ultima_gestion[0];
				  }
				  
				  if($tipo == "modificacion"){//
				   $sel_ultima_gestion = traer_fila_row(query_db("select t1_us_usuarios.nombre_administrador from  t7_relacion_campos_legalizacion_gestiones, t1_us_usuarios where t7_relacion_campos_legalizacion_gestiones.id_us = t1_us_usuarios.us_id and t7_relacion_campos_legalizacion_gestiones.id_contrato = ".$id." and t7_relacion_campos_legalizacion_gestiones.id_modificacion = ".$s_cam[0]));
				  echo $sel_ultima_gestion[0];
				  }
			  
			  ?></td>
              <td align="center" valign="top"><?=$s_cam[11]?></td>
              <td align="center" valign="top"><?=$dias_reales?></td>
              <td align="center" valign="top"><?=$dias_retraso?></td>
              <td align="center" valign="top"><?=saca_nombre_lista($g13,$tp_proceso_sol,'nombre','t1_tipo_proceso_id')?></td>
              <td align="center" valign="top"><?=saca_nombre_lista($g1,$prof_abas_soli,'nombre_administrador','us_id')?></td>
           
              </tr>
              
              
            <?
		
		
			  }
			?></table> <?  
			  
	}
?>

	</html>