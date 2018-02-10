<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	
$_SESSION["comple_filtro"]="";


	$congelados = $_POST["congelados"];
	$_SESSION["ses_congelados"] = $congelados;	
	$area_usuaria = $_POST["area_usuaria"];	
	$_SESSION["ses_area_usuaria"] = $area_usuaria;
	$ano = $_POST["ano"];
	$_SESSION["ses_ano"] = $ano;
	$mes_requiere = $_POST["mes_requiere"];
	$_SESSION["mes_requiere"] = $mes_requiere;
	$mes_requiere2 = $_POST["mes_requiere2"];
	$_SESSION["mes_requiere2"] = $mes_requiere2;
	
	$bien_servicio = $_POST["bien_servicio"];
	$_SESSION["bien_servicio"] = $bien_servicio;
	$us_prof = $_POST["us_prof"];
	$_SESSION["ses_us_prof"] = $us_prof;
	$fecha_rep = $_POST["fecha_rep"];
	$_SESSION["fecha_rep"] = $fecha_rep;
	
	$fecha_rep = $_POST["fin_activos"];
	$_SESSION["fin_activos"] = $fecha_rep;
	
	$_SESSION["gestor_abste"] = $_POST["gestor_abste"];
	
	
		
		
	if($_SESSION["ses_us_prof"] <> 0 and $_SESSION["ses_us_prof"] <> ''){
		$comple_sql.= " and especialista = ".$_SESSION["ses_us_prof"];				
		}
	if($_SESSION["ses_congelados"] == 2){
			$comple_sql.= " and (analista_deloitte is null or analista_deloitte = 2 or analista_deloitte = '' or analista_deloitte = 0)";
			}
	if($_SESSION["bien_servicio"] == 1){
			$comple_sql.= " and (tipo_bien_servicio like '%Servicios%' or tipo_bien_servicio is null)";
			}
	if($_SESSION["bien_servicio"] == 2){
			$comple_sql.= " and (tipo_bien_servicio like '%Bienes%')";
			}
						

			
	//echo $comple_sql;
			
	$ano_req = $_SESSION["ses_ano"];
	
	if($_SESSION["mes_requiere"] <> "0"){
			$ano_req = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere"];
			$comple_sql_meses =" and creacion_sistema like '%".$ano_req."%'";
			}else{
				$comple_sql_meses =" and creacion_sistema like '%".$ano_req."%'";
				}
	
	
	if($_SESSION["mes_requiere2"] <> "0"){
			$ano_req = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere"]."-01";
			$ano_req2 = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere2"]."-31";
			
			$comple_sql_meses=" and creacion_sistema >= '".$ano_req."' and creacion_sistema  <= '".$ano_req2."'";
			}		
		$comple_sql.=$comple_sql_meses;

		
		
	$decimal = "0";
	
	
		if($_POST["gestor_abste"]!="0" and $_POST["gestor_abste"] !=""){
		
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

$sel_contratos_gestiona = query_db("select usuario_gerente from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_POST["gestor_abste"]);
$aplica_gerentes = "0";
while($aplica_gere = traer_fila_db($sel_contratos_gestiona)){
	$aplica_gerentes.=",".$aplica_gere[0];
	}
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$query_comple = $query_comple." and gerente in (".$aplica_gerentes.")";
	}
	
$_SESSION["comple_filtro"]=$query_comple." ".$comple_sql;	

function legalizaciones_de_contratos_tiempos($tipo, $id, $edita){
	
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
		
$sel_campos_contra = traer_fila_db(query_db("select ".$campos_tabla." from t7_relacion_campos_legalizacion_datos where ".$id_campo_aplica." =".$id_contrato_arr));


			  while($s_cam = traer_fila_db($sel_campos)){
				  	$edita_fecha_1=0;
					$edita_fecha_2=0;
					$edita_ob=0;
					
					
			   
		   
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
						 
			  ?>
            <tr <?=$clase?> <?=$bloquea_check?>>
              <td colspan="2" valign="top"><? ?> 
			  <?
             echo $num_imprime;
			  ?> 
              
              
              </td>
              <td align="center" valign="top"> 
			  
  <? if($edita_fecha_1 == 1){?>
     <input name="<?=$s_cam[3]?>" type="text" id="<?=$s_cam[3]?>" value="<?=$sel_campos_contra[$s_cam[3]]?>" size="10" maxlength="10" onClick="this.value='<?=$fecha;?>'" readonly="readonly" />
     
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
        <input name="<?=$s_cam[4]?>" type="text" id="<?=$s_cam[4]?>" value="<?=$sel_campos_contra[$s_cam[4]]?>" size="10" maxlength="10" onClick="pone_fecha_fin(this, document.principal.<?=$s_cam[3]?>, '<?=$fecha?>')" readonly="readonly"/>
        
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
    <input name="button" type="button" class="boton_grabar" id="button" value="Grabar" onClick="<?=$alerta_incompletos_alerta?>;"/>
    <?
			 if($s_cam[14] == 1 and $edita_fecha_2 != 0){
				 $devuelve_paso = "devolver_anterior(document.principal.".$s_cam[3].", document.principal.".$s_cam[10].", ".$s_cam[0].", '".$s_cam[3]."', '".$s_cam[10]."','".$rol_encargado_inicial_id."', '".$rol_encargado_final_id."', document.principal.".$s_cam[15].", '".$s_cam[15]."')";
			?>
            
			<br /><input name="button" type="button" class="boton_grabar_cancelar" id="button" value="<? if ($s_cam[0] == 17) echo "Rechazar"; else echo "Devolver";?>" onClick="<?=$devuelve_paso?>"/>
			
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

	
		
	

	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	
</head>

<body>

<table width="100%" border="0" class="tabla_lista_resultados">
<tr>
  <td align="center"><table width="100%" border="0" class="tabla_blanca">
    <tr>
      <td class="fondo_3" bgcolor="">1. Indicador de tiempo de legalizacion</td>
      </tr>
    <tr>
      <td class="" bgcolor="" align="left"><a href="soporte_1_legalicacion.php" target="_blank"><img src="../../imagenes/mime/xlsx.gif" />Descargar el soporte de este indicador</a></td>
    </tr>
    <tr>
      <td class="" bgcolor="" align="left"><img src="../../imagenes/botones/alerta.png" /> <font color="#005395"><strong>Con un Click en cualquier Barra podra seguir desendiendo en la secuencia del indicador</strong></font></td>
      </tr>
    <tr>
      <td align="center"></td>
      </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    </table></td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
</tr>
</table>
     
       

</body>
</html>

