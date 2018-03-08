<?  include("../lib/@session.php");
$hora_log = date("G:i:s");
	verifica_menu("administracion.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER



	if($_POST["accion"]=="devuelve_proceso_legalizacion"){
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id	

	$id_campo_legalizacion = elimina_comillas(arreglo_recibe_variables($_POST["id_campo_legalizacion"]));
	
	$campo_fecha_ini = elimina_comillas_2($_POST["fecha_inicial_campo"]);
	$valor_fecha_ini = elimina_comillas_2($_POST["fecha_inicial"]);
	
	$campo_observacion = elimina_comillas_2($_POST["observacion_campo"]);
	$valor_observacion = elimina_comillas_2($_POST["observacion"]);
	$campo_observacion_rol2 = elimina_comillas_2($_POST["observacion_campo_rol2"]);
	$valor_observacion_rol2 = elimina_comillas_2($_POST["observacion_rol2"]);
	
	if($_POST["tipo_check_list"] == "contrato"){
		$id_campo_aplica = " id_contrato ";
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id	
		$link_devuelve = "window.parent.ajax_carga('../aplicaciones/contratos/v_contratos.php?id=".$_POST["id_contrato_arr_envia"]."','carga_acciones_permitidas');";
	}
	if($_POST["tipo_check_list"] == "modificacion"){
			$id_campo_aplica = " id_modificacion ";
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_complemento"]));//recibe id	
			$link_devuelve = "window.parent.ajax_carga('../aplicaciones/contratos/c_complemento.php?id=".$_POST["id_contrato_arr_envia"]."&id_complemento=".$_POST["id_complemento"]."','carga_acciones_permitidas');";
	}
	
	

		$insert_dev = query_db("insert into t7_relacion_campos_legalizacion_datos_devoluciones (".$id_campo_aplica.", id_campo_legalizacion, inicio, fin, ob1, ob2, rol1, rol2) values (".$id_contrato_arr.", ".$id_campo_legalizacion.", '".$valor_fecha_ini."', '".$fecha."','".$valor_observacion."', '".$valor_observacion_rol2."', '".$_POST["id_rol_fecha1"]."', '".$_POST["id_rol_fecha2"]."' )");		
		$updta = query_db("update t7_relacion_campos_legalizacion_datos set $campo_fecha_ini = '', $campo_observacion='' where ".$id_campo_aplica." = ".$id_contrato_arr);
		
		if($id_campo_legalizacion == 17){
			$sel_campo_16 = traer_fila_row(query_db("select f_ini_elabora_pedido, f_fin_elabora_pedido, elabora_pedido_ob2 from t7_relacion_campos_legalizacion_datos where ".$id_campo_aplica." = ".$id_contrato_arr));
			$insert_dev = query_db("insert into t7_relacion_campos_legalizacion_datos_devoluciones (".$id_campo_aplica.", id_campo_legalizacion, inicio, fin, ob1, ob2, rol1, rol2) values (".$id_contrato_arr.",16, '".$sel_campo_16[0]."', '".$sel_campo_16[1]."','".$sel_campo_16[2]."', '', '25', '25' )");		
			
			
			$updta = query_db("update t7_relacion_campos_legalizacion_datos set f_ini_elabora_pedido = '".$fecha."', f_fin_elabora_pedido='', elabora_pedido_ob2 ='' where ".$id_campo_aplica." = ".$id_contrato_arr);//actualiza el campo id 16
			
			
			}
		
		
	?>
		<script> 
		<?=$link_devuelve?>
        </script>
		<?	
	}
	
	
	
	
	
	
	if($_POST["accion"]=="graba_fecha_legalizacion"){
		
		
		$campo_fecha_ini = elimina_comillas_2($_POST["fecha_inicial_campo"]);
		$campo_fecha_fin = elimina_comillas_2($_POST["fecha_final_campo"]);
		$campo_observacion = elimina_comillas_2($_POST["observacion_campo"]);
		$campo_observacion_rol2 = elimina_comillas_2($_POST["observacion_campo_rol2"]);
		
		$valor_fecha_ini = elimina_comillas_2($_POST["fecha_inicial"]);
		$valor_fecha_fin = elimina_comillas_2($_POST["fecha_final"]);
		$valor_observacion = elimina_comillas_2($_POST["observacion"]);
		$valor_observacion_rol2 = elimina_comillas_2($_POST["observacion_rol2"]);
		
	
	
	if($_POST["tipo_check_list"] == "contrato"){
		$id_campo_aplica = " id_contrato ";
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id	
		$update_ult_gestion = query_db("update t7_relacion_campos_legalizacion_gestiones set estado = 2 where id_contrato = ".$id_contrato_arr);
		$insert_ult_gestion = query_db("insert into t7_relacion_campos_legalizacion_gestiones (id_contrato, id_t7_relacion_campos_legalizacion, id_us, ob, fecha, hora, estado) values (".$id_contrato_arr.", ".elimina_comillas_2($_POST["id_actividad_guarda"]).", ".$_SESSION["id_us_session"].", '".$valor_observacion." ".$valor_observacion_rol2."', '".$fecha."', '".$hora_log."', 1)");
	}
	if($_POST["tipo_check_list"] == "modificacion"){
			$id_campo_aplica = " id_modificacion ";
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_complemento"]));//recibe id	
			$sel_modifica = traer_fila_row(query_db("select tipo_complemento, id_contrato, numero_otrosi, id_item_pecc from t7_contratos_complemento where id = ".elimina_comillas(arreglo_recibe_variables($_POST["id_complemento"]))));
			$update_ult_gestion = query_db("update t7_relacion_campos_legalizacion_gestiones set estado = 2 where id_modificacion = ".$id_contrato_arr);
		$insert_ult_gestion = query_db("insert into t7_relacion_campos_legalizacion_gestiones (id_modificacion, id_t7_relacion_campos_legalizacion, id_us, ob, fecha, hora, estado) values (".$id_contrato_arr.", ".elimina_comillas_2($_POST["id_actividad_guarda"]).", ".$_SESSION["id_us_session"].", '".$valor_observacion." ".$valor_observacion_rol2."', '".$fecha."', '".$hora_log."', 1)");
	}

	$updta = query_db("update t7_relacion_campos_legalizacion_datos set $campo_fecha_ini = '$valor_fecha_ini', $campo_fecha_fin='$valor_fecha_fin', $campo_observacion='$valor_observacion', $campo_observacion_rol2='$valor_observacion_rol2' where $id_campo_aplica = ".$id_contrato_arr);
	
	
	

	if(($campo_fecha_fin == "f_fin_firma_hocol" and elimina_comillas_2($_POST["f_fin_firma_hocol"]) != "" and elimina_comillas_2($_POST["f_fin_firma_hocol"]) != " ") or ($sel_modifica[0] == 2 and ($campo_fecha_fin == "f_fin_aprob_sap" and elimina_comillas_2($_POST["f_fin_aprob_sap"]) != "" and elimina_comillas_2($_POST["f_fin_aprob_sap"]) != " ") )){
		
		$tipo_id='';
		$id_busca='';
		$id_modifica='';
		if($sel_modifica[0] == 2){
			$tipo_id=2;//OT
			$id_busca=$sel_modifica[1];//id_contrato
			$id_modifica=$id_contrato_arr;
			//$update_estado_cotrato = query_db("update t7_contratos_complemento set estado = 25 where id = ".$id_contrato_arr);//actualiza estado de la modificacion
			$sel_co_mod = traer_fila_row(query_db("select gerente, especialista from t7_contratos_contrato where id = ".$sel_modifica[1]));
			/************* INICIO PARA EL DES-009-2017*************/
		}else{
			if($sel_modifica[0] != 0 and $sel_modifica[0] != ""){
				$tipo_id=1;//OTROSI
				$id_busca=$sel_modifica[1];//id_contrato
				$id_modifica=$id_contrato_arr;
				//$update_estado_cotrato = query_db("update t7_contratos_complemento set estado = 25 where id = ".$id_contrato_arr);//actualiza estado de la modificacion
				$sel_co_mod = traer_fila_row(query_db("select gerente, especialista from t7_contratos_contrato where id = ".$sel_modifica[1]));
				}else{
			$tipo_id=0;//CONTRATO
			$id_busca=$id_contrato_arr;//id_contrato
			//$update_estado_cotrato = query_db("update t7_contratos_contrato set estado = 25 where id = ".$id_contrato_arr);
			$sel_co_mod = traer_fila_row(query_db("select gerente, especialista from t7_contratos_contrato where id = ".$id_contrato_arr));
				}
		}
		
		/*ENVIO DE CORREO ELECTRONICO legalizado*/
			
			$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento, nombre_gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_co_mod[0]));
			/************* PARA EL DES-009-2017*************/
			$query="select CAST(objeto as text) from $co1 where id=$id_busca";
			$objeto_contrato=traer_fila_row(query_db($query));
			$query="select * from $co1 where id=$id_busca";
			$lista_contrato=traer_fila_row(query_db($query));
			$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$lista_contrato[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			$contratista=$sel_pro_q[3];
			$fecha_fin=$lista_contrato[11];
			$numero_modificacion="";
			$objeto_modificacion="";
			$id_gerente="";
			if($tipo_id==2 or $tipo_id==1){
				$queryot="select gerente, valor, valor_cop, fecha_inicio, numero_otrosi, CAST(alcance AS text), tiempo, id_item_pecc from $co4 where id_contrato=$id_busca AND id=$id_modifica";
				$id_gerente_antiguo=traer_fila_row(query_db($queryot));
				$id_item_pecc=$id_gerente_antiguo[7];;
				$monto_cop=valida_numero_imp($id_gerente_antiguo[2]);
				$monto_usd=valida_numero_imp($id_gerente_antiguo[1]);
				$fecha_inicio=$id_gerente_antiguo[3];
				$fecha_fin=$id_gerente_antiguo[6];
				if( $tipo_id==1){
					$id_gerente=$lista_contrato[9];
				}else{
				$id_gerente=$id_gerente_antiguo[0];
				}
				$numero_modificacion=$id_gerente_antiguo[4];
				$objeto_modificacion=$id_gerente_antiguo[5];
				if($fecha_inicio=="" or $fecha_inicio==null){
					$fecha_inicio=$lista_contrato[10];
				}
				if($fecha_fin=="" or $fecha_fin==null){
					$fecha_fin=$lista_contrato[11];
				}
				if($tipo_id==1){
					$fecha_fin=$lista_contrato[11];
					$fecha_inicio=$lista_contrato[10];
				}
			}else{				
				$monto_cop=valida_numero_imp($lista_contrato[18]);
				$monto_usd=valida_numero_imp($lista_contrato[17]);
				$fecha_inicio=$lista_contrato[10];
				$id_gerente=$lista_contrato[9];
			}
			if($lista_contrato[34]==1){
			 	
				if($sql_con[57]==1){
					echo $tipo_contrato="ACEPTACION DE OFERTA MERCANTIL";
				}else{
					echo $tipo_contrato="CONTRATO PUNTUAL";
				}

			 }else{
				echo $tipo_contrato="CONTRATO MARCO";
			 }
			$moneda_pago="";
			if($monto_cop!=0){
				$moneda_pago=$moneda_pago." COP";
			}elseif($monto_uds!=0){
				if($moneda_pago!=""){
					$moneda_pago=$moneda_pago.", USD";
				}else{
					$moneda_pago=$moneda_pago." USD";
				}
			}else{
				$moneda_pago="No Aplica";
			}
			$aplica_garantia=$lista_contrato[55];
			$garantia="";
			if($aplica_garantia==1){
				$garantia="Si ";
				if($lista_contrato[56]==5){
					$garantia=$garantia."5% ";
				}
				if($lista_contrato[56]==1){
					$garantia=$garantia."1% ";
				}
				if($lista_contrato[57]==1){
					$garantia=$garantia."Parcial.";
				}
				if($lista_contrato[57]==2){
					$garantia=$garantia."Al Liquidar el contrato.";
				}
			}else{
				$garantia="No Aplica";
			}
			$correos_gestores="";
			$query="select nombre_gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$lista_contrato[9];
			$para_actualiza2 = query_db($query);//	Profesional de aseguramiento
			while ($s_actual = traer_fila_db($para_actualiza2)) {
				//sent_mail_with_signature(''.$s_actual[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
				$correos_gestores=$correos_gestores.$s_actual[1].",,";
			}
			$gestor_abastecimiento = traer_fila_row(query_db("select nombre_gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$lista_contrato[9]));//$gestor_abastecimiento[0]nombre $gestor_abastecimiento[1]email
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[19]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[2];//consecutivo
			$numero_contrato4 = $lista_contrato[43];//apellido
			//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
			$numero_contrato = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[1]);
			$hse=$lista_contrato[58];
			if($hse=="NO")$hse="No Aplica";
			$id_aseguramiento=$lista_contrato[53];
			$query="select nombre from t1_tipo_aseguramiento_admin where id=$id_aseguramiento";
			$aseguramiento=$gerente_antiguo=traer_fila_row(query_db($query));
			$query="select nombre_administrador, email from $g1 where us_id=$id_gerente";
			$gerente_anterior=traer_fila_row(query_db($query));
			$query="select nombre_administrador, email from $g1 where us_id=$lista_contrato[16];";
			$profesional_abastecimiento=traer_fila_row(query_db($query));
			$query="select email from $g1 where us_id=$id_gerente";
			$correo_gerente=traer_fila_row(query_db($query));
		
			$id_contrato_tarifas=traer_fila_row(query_db("select * from t6_tarifas_contratos where id_contrato = ".$lista_contrato[0]));
			$id_reajustes=traer_fila_row(query_db("select count(*) from t6_tarifas_ipc_contrato where t6_tarifas_contratos_id=$id_contrato_tarifas[0] and ipc_administracion = 1 and estado = 1"));
			$reajustes='';
			if($id_reajustes[0]>=1){
				$reajustes=$reajustes."IPC";
			}else{
				$reajustes=$reajustes."No Aplica";
			}
			$busca_reembolsable = traer_fila_row(query_db("select t6_tarifas_reembosables1_contrato_id, porcentaje_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_reemblsable_principal where t6_tarifas_contratos_id = $id_contrato_tarifas[0]  and estado = 1 and porcentaje_administracion >=0"));
			$reembolsables='';
			if($busca_reembolsable[0]>=1){
				$reembolsables=$reembolsables."SI ".$busca_reembolsable[1]."%";
			}else{
				$reembolsables=$reembolsables."No Aplica";
			}
			if($tipo_id==2){//OT
				$inicio_tabla="<font font-size='10' face='arial'><table style='width: 80%; border: solid 1px #CCC; alignment-adjust:central; margin-left: 100px;' ><tr  style='background: #1f497d; color:#FFFFFF; font-family: arial;'><td  style='width: 13%;' align='center'><strong>A&ntilde;o</strong></td><td  style='width: 41%' align='center'><strong>&Aacute;rea</strong></td><td style='width: 22%' align='center'><strong>Valor USD$</strong></td><td  style='width: 24%' align='center'><strong>Valor COP$</strong></td></tr>";
				  $sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
					$valor_total_usd = 0;
					$valor_total_cop = 0;
					$total_equivale_usd = 0 ;
					$cont = 0;
				  $clase="";
				  while($sel_presu = traer_fila_db($sele_presupuesto)){
								$valor_total_usd = $valor_total_usd + $sel_presu[4];
								$valor_total_cop = $valor_total_cop + $sel_presu[5];
								
								if($cont == 0){
						  	$clase= "filas_resultados";
							$cont = 1;
						  }else{
						  	$clase= "";
							$cont = 0;
						  }
				  
				    $inicio_tabla=$inicio_tabla."<tr style='font-family: arial;'><td style='width: 13%'>".$sel_presu[1]."</td><td style='width: 41%'>".$sel_presu[2]."</td><td style='width: 22%'>".number_format($sel_presu[4],0)."</td><td style='width: 24%'>".number_format($sel_presu[5],0)."</td></tr>";
				    
					}
							
					$total_equivale_usd = ($valor_total_cop / trm_presupuestal($sel_item[17])) +$valor_total_usd ;
				  
				  $inicio_tabla=$inicio_tabla."<tr><td align='right'>&nbsp;</td><td align='right'  style='background: #1f497d; color:#FFFFFF; font-family: arial;' align='center'><strong>Totales:</strong></td><td style='font-family: arial;'><strong>".number_format($valor_total_usd)."</strong></td><td style='font-family: arial;'><strong>".number_format($valor_total_cop)."</strong></td></tr></table></font>";
				$email_cambio_gerente="<font font-size='10' face='arial'>Apreciado Gerente de Contrato<br><br>Le informamos que la orden de trabajo N° <strong><numero_ot></strong>  cuyo objeto es <objeto> que está bajo el contrato N°  <strong><numero_contrato></strong>, se encuentra totalmente legalizado, usted puede dar inicio a las actividades relacionadas en dicha orden:<br><br><table border='1' width='80%' style='margin-left: 100px;'><tr><td colspan='2' style='color: #FFFFFF; background: #1f497d; font-family: Arial;' align='center'><strong>Datos Generales de la Orden de Trabajo</strong></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Contratista:</strong></td><td style='font-family: Arial;'><contratista></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gerente de la Orden de Trabajo:</strong></td><td style='font-family: Arial;'><gerente_contrato></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Profesional / Comprador de Abastecimiento:</strong></td><td style='font-family: Arial;'><profesional_abastecimiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gestor de Abastecimiento:</strong></td><td style='font-family: Arial;'><gestor_abastecimiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Inicio de la Orden de Trabajo:</strong></td><td style='font-family: Arial;'><fecha_inicio></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Fin de la Orden de Trabajo:</strong></td><td style='font-family: Arial;'><fecha_fin></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Monto:</strong></td><td style='font-family: Arial;'><monto></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Moneda de Pago:</strong></td><td style='font-family: Arial;'><moneda_pago></td></tr></table><br><br>".$inicio_tabla."<br><br>Toda la información relacionada con cláusulas contractuales, anexos técnicos y comerciales del mismo puede encontrarlos en la memoria corporativa de Hocol, <a href='http://intranet.hocol.com.co/'>http://intranet.hocol.com.co/</a><br>Para temas relacionados con incumplimiento contractual y retención en garantía puede contactarse con <a href='mailto:maria.cock@hocol.com.co'>maria.cock@hocol.com.co</a> Coordinadora de Aseguramiento Administrativo y Control.<br>A continuación les presentamos los puntos de control que usted debe tener en cuenta como Gerente de contrato:<br><br><strong>1.	Tarifas</strong><br>Si en la cláusula cuarta de la minuta del contrato está establecido que puede incluir tarifas relacionadas con el objeto y alcance del contrato sin afectar el valor del contrato. Recuerde que el Contratista debe hacer el trámite a través la herramienta SGPA módulo de tarifas y estas deben estar soportadas por un documento firmado por el Contratista, el Gerente del Contrato.<br><br>Toda negociación o inclusión debe estar acompañada por el  Profesional de Abastecimiento.<br><br><strong>2.	Ejecución y seguimiento</strong><br>Mensualmente usted recibirá el reporte de ejecución de su  contrato, vigencia, saldos y detalle de ejecución, sobre el cual en caso de requerir extensión o aumento de monto  podrá registrarla en SGPA  y ponerse en contacto con el profesional de abastecimiento para solicitar las inclusiones de  manera oportuna y dentro de los tiempos de proceso la aprobación al respectivo nivel.<br><br><strong>3.	Documentación</strong><br>Es importante que todas las comunicaciones físicas, electrónicas, informes y documentos relacionados con la gestión y ejecución del contrato las hagan llegar al soporte de aseguramiento administrativo para que estas sean documentadas en la carpeta respectiva del contrato.<br><br>Toda esta información la pueden hacer llegar al siguiente correo: <a href='mailto:Vedelibeth.Ruiz@hcl.com.co'>Vedelibeth.Ruiz@hcl.com.co</a><br><br><strong>4.	Aseguramiento Administrativo de Contrato</strong><br>Hocol S.A. cuenta con un outsourcing de Aseguramiento Administrativo de Contratos, donde usted va a tener un apoyo en la revisión en temas laborales y contractuales del Contratista. Este aseguramiento se realiza de acuerdo de cómo quede el tipo de contrato y este aseguramiento es mes vencido.<br><br>Usted podrá consultar el estado del contratista y de este contrato en el siguiente link: <a href='http://www.controlar2.com/Login.aspx'>http://www.controlar2.com/Login.aspx</a>.<br><br><strong>5.	Requisitos para  Elaboración de Aceptaciones de Servicio</strong><br>Para la elaboración de las aceptaciones de servicio se debe hacer entrega al outsourcing contable de la siguiente información:<br><br><table border='0' style='margin-left: 10px;'><tr><td valign='top' style='font-family: Arial;'>a.</td><td style='font-family: Arial;'>Tiquete SGPA autorizado</td></tr><tr><td valign='top' style='font-family: Arial;'>b.</td><td style='font-family: Arial;'>Indicación de CeCo o AFE</td></tr><tr><td valign='top' style='font-family: Arial;'>c.</td><td style='font-family: Arial;'>Acta o tiquete de avance que soporte la recepción del servicio objeto del contrato</td></tr><tr><td valign='top' style='font-family: Arial;'>d.</td><td style='font-family: Arial;'>Prefactura en los casos en que se requiere validar temas fiscales (bases para IVA, exentos, etc).</td></tr><tr><td valign='top' style='font-family: Arial;'>e.</td><td style='font-family: Arial;'>Certificación del revisor fiscal y representante legal que están al día con todos los pagos de parafiscales (Sena, Caja de Compensación, ARL), pago de nómina y pago a proveedores.</td></tr></table><br><br><strong>6.	Requisitos para facturación</strong><br><br>Las áreas financiera y de abastecimiento hemos informado a todos los proveedores acerca de los requisitos mínimos y no subsanables para la presentación de facturas, el proveedor debe radicar sus facturas únicamente en las oficinas de Carvajal, en Hocol no se deben recibir facturas.<br><br>Se adjunta los requisitos de facturación.<br><br>A continuación referenciamos algunos de los documentos mínimos requeridos para facturar:<br><table border='0' style='margin-left: 10px;'><tr><td valign='top' style='font-family: Arial;'>a.</td><td style='font-family: Arial;'>Para el caso de prestación de servicios la factura debe indicar el municipio donde se prestó  el servicio y para la compra de bienes el municipio dónde se realizó la negociación de compra, incluyendo tarifa de ICA a la cual se grava(n) la(s) actividad(es), el Código de la actividad económica según los acuerdos municipales.</td></tr><tr><td valign='top' style='font-family: Arial;'>b.</td><td style='font-family: Arial;'>Expedir la factura en la misma moneda en la que se haya elaborado la entrada de materiales o la aceptación del servicio</td></tr><tr><td valign='top' style='font-family: Arial;'>c.</td><td style='font-family: Arial;'>Certificación firmada por el Representante Legal  a través de la cual manifieste, bajo la gravedad del juramento, que se encuentra a paz y salvo en relación con los pagos a proveedores y contratistas de la región donde presta los servicios prestados en Colombia (mes actual o inmediatamente anterior), en los casos que sea aplicable.</td></tr><tr><td valign='top' style='font-family: Arial;'>d.</td><td style='font-family: Arial;'>Tener adjunto una certificación firmada por el Representante Legal y Revisor fiscal   o contador cuando no exista la obligación de tener  Revisor Fiscal a través de la cual manifieste, bajo la gravedad del juramento, que se encuentra a paz y salvo por el pago de salarios, liquidaciones, aportes al Sistema Integral de Seguridad Social, aportes parafiscales de todos sus empleados y todas las obligaciones laborales a cargo. ( mes actual o inmediatamente anterior)</td></tr><tr><td valign='top' style='font-family: Arial;'>e.</td><td style='font-family: Arial;'>Documentación soporte EN ORIGINAL según el tipo de servicio prestado debidamente firmada. Ej: Planillas, Relación de Horas, Reporte de ejecución de obra etc.</td></tr></table><br><br>NOTA: Recuerden que no deben entregar las aceptaciones de servicio hasta que el contratista le entregue todas las certificaciones.<br><br>Cordial saludo,<br><firma><br><br>He leído, entendido y recibido la información relacionada con el contrato, así como las responsabilidades asociadas al rol Gerente de Contrato en cumplimiento de la Norma de Contratación, Controles de Auditoria, Norma de &Eacute;tica y Cumplimiento.</font>";
				$asunto_cambio_gerente="LEGALIZACION DE ORDEN DE TRABAJO ".$numero_modificacion." DEL CONTRATO ".strtoupper($numero_contrato);
				$email_cambio_gerente=str_replace('<numero_ot>', $numero_modificacion, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<numero_contrato>', strtoupper($numero_contrato), $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<objeto>', $objeto_modificacion, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<contratista>', $contratista, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gerente_contrato>', $gerente_anterior[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<tipo_contrato>', $tipo_contrato, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<moneda_pago>', $moneda_pago, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<profesional_abastecimiento>', $profesional_abastecimiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gestor_abastecimiento>', $gestor_abastecimiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<fecha_inicio>', $fecha_inicio, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<fecha_fin>', $fecha_fin, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<monto>', "COP $".$monto_cop."<br>USD $".$monto_usd, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<hsse>', $hse, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<tipo_aseguramiento>', $aseguramiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<retencion>', $garantia, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gerente_anterior>', $gerente_anterior[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<reajustes>', $reajustes, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gastos>', $reembolsables, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<firma>', 'Jefatura de Abastecimiento', $email_cambio_gerente);
				$query="select u.nombre_administrador, u.email from $g1 as u, $ts6 as t where t.id_usuario=u.us_id AND t.id_rol_general=24 AND u.estado=1 and u.us_id <> 32";
				$para_actualiza = query_db($query);//	Profesional de aseguramiento
				$para_actualiza2 = query_db($query);//	Profesional de aseguramiento
				$nombre_aseguramiento=traer_fila_db($para_actualiza);
				$correos="";
				//sent_mail_with_signature(''.$nombre_aseguramiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
				while ($s_actual = traer_fila_db($para_actualiza2)) {
					//sent_mail_with_signature(''.$s_actual[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
					$correos=$correos.$s_actual[1].",,";
				}
				//sent_mail_with_signature(''.$gestor_abastecimiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//gestor de abastecimiento@hcl.com.co
				//$correos=$correos.$gestor_abastecimiento[1].",,";
				//sent_mail_with_signature(''.$gerente_anterior[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//gerente nuevo
				$correos=$correos.$gerente_anterior[1].",,";
				//sent_mail_with_signature(''.$profesional_abastecimiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//gerente nuevo
				$correos=$correos.$profesional_abastecimiento[1].",,";
				$correos=$correos.$correos_gestores;
				//sent_mail_with_signature('jeison.rivera@enternova.net',$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);
				sent_mail_with_signature($correos,$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);
			}
			if($tipo_id==1){//OTROSI
				$email_cambio_gerente="<font font-size='10' face='arial'>Apreciado Gerente de Contrato<br><br>Le informamos que el Otrosí N° <strong><numero_otrosi></strong> del contrato N°  <strong><numero_contrato></strong>, para <objeto>, se encuentra totalmente legalizado usted puede dar inicio a las actividades relacionadas con el mismo:<br><br><table border='1' width='80%' style='margin-left: 100px;'><tr><td colspan='2' style='color: #FFFFFF; background: #1f497d; font-family: Arial;' align='center'><strong>Datos Generales Del Contrato</strong></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Tipo de Contrato:</strong></td><td style='font-family: Arial;'><tipo_contrato></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Contratista:</strong></td><td style='font-family: Arial;'><contratista></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gerente del Contrato:</strong></td><td style='font-family: Arial;'><gerente_contrato></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Profesional / Comprador de Abastecimiento:</strong></td><td style='font-family: Arial;'><profesional_abastecimiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gestor de Abastecimiento:</strong></td><td style='font-family: Arial;'><gestor_abastecimiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Inicio:</strong></td><td style='font-family: Arial;'><fecha_inicio></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Fin:</strong></td><td style='font-family: Arial;'><fecha_fin></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Monto:</strong></td><td style='font-family: Arial;'><monto></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Moneda de Pago:</strong></td><td style='font-family: Arial;'><moneda_pago></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Informe de HSSE:</strong></td><td style='font-family: Arial;'><hsse></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Tipo de Aseguramiento:</strong></td><td style='font-family: Arial;'><tipo_aseguramiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Retención en Garantía:</strong></td><td style='font-family: Arial;'><retencion></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Reajustes:</strong></td><td style='font-family: Arial;'><reajustes></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gastos Reembolsables:</strong></td><td style='font-family: Arial;'><gastos></td></tr></table><br><br>Toda la información relacionada con cláusulas contractuales, anexos técnicos y comerciales del mismo puede encontrarlos en la memoria corporativa de Hocol, <a href='http://intranet.hocol.com.co/'>http://intranet.hocol.com.co/</a><br>Para temas relacionados con incumplimiento contractual y retención en garantía puede contactarse con <a href='mailto:maria.cock@hocol.com.co'>maria.cock@hocol.com.co</a> Coordinadora de Aseguramiento Administrativo y Control.<br>A continuación les presentamos los puntos de control que usted debe tener en cuenta como Gerente de contrato:<br><br><strong>1.	Tarifas</strong><br>Si en la cláusula cuarta de la minuta del contrato está establecido que puede incluir tarifas relacionadas con el objeto y alcance del contrato sin afectar el valor del contrato. Recuerde que el Contratista debe hacer el trámite a través la herramienta SGPA módulo de tarifas y estas deben estar soportadas por un documento firmado por el Contratista, el Gerente del Contrato.<br><br>Toda negociación o inclusión debe estar acompañada por el  Profesional de Abastecimiento.<br><br><strong>2.	Ejecución y seguimiento</strong><br>Mensualmente usted recibirá el reporte de ejecución de su  contrato, vigencia, saldos y detalle de ejecución, sobre el cual en caso de requerir extensión o aumento de monto  podrá registrarla en SGPA  y ponerse en contacto con el profesional de abastecimiento para solicitar las inclusiones de  manera oportuna y dentro de los tiempos de proceso la aprobación al respectivo nivel.<br><br><strong>3.	Documentación</strong><br>Es importante que todas las comunicaciones físicas, electrónicas, informes y documentos relacionados con la gestión y ejecución del contrato las hagan llegar al soporte de aseguramiento administrativo para que estas sean documentadas en la carpeta respectiva del contrato.<br><br>Toda esta información la pueden hacer llegar al siguiente correo: <a href='mailto:Vedelibeth.Ruiz@hcl.com.co'>Vedelibeth.Ruiz@hcl.com.co</a><br><br><strong>4.	Aseguramiento Administrativo de Contrato</strong><br>Hocol S.A. cuenta con un outsourcing de Aseguramiento Administrativo de Contratos, donde usted va a tener un apoyo en la revisión en temas laborales y contractuales del Contratista. Este aseguramiento se realiza de acuerdo de cómo quede el tipo de contrato y este aseguramiento es mes vencido.<br><br>Usted podrá consultar el estado del contratista y de este contrato en el siguiente link: <a href='http://www.controlar2.com/Login.aspx'>http://www.controlar2.com/Login.aspx</a>.<br><br><strong>5.	Requisitos para  Elaboración de Aceptaciones de Servicio</strong><br>Para la elaboración de las aceptaciones de servicio se debe hacer entrega al outsourcing contable de la siguiente información:<br><br><table border='0' style='margin-left: 10px;'><tr><td valign='top' style='font-family: Arial;'>a.</td><td style='font-family: Arial;'>Tiquete SGPA autorizado</td></tr><tr><td valign='top' style='font-family: Arial;'>b.</td><td style='font-family: Arial;'>Indicación de CeCo o AFE</td></tr><tr><td valign='top' style='font-family: Arial;'>c.</td><td style='font-family: Arial;'>Acta o tiquete de avance que soporte la recepción del servicio objeto del contrato</td></tr><tr><td valign='top' style='font-family: Arial;'>d.</td><td style='font-family: Arial;'>Prefactura en los casos en que se requiere validar temas fiscales (bases para IVA, exentos, etc).</td></tr><tr><td valign='top' style='font-family: Arial;'>e.</td><td style='font-family: Arial;'>Certificación del revisor fiscal y representante legal que están al día con todos los pagos de parafiscales (Sena, Caja de Compensación, ARL), pago de nómina y pago a proveedores.</td></tr></table><br><br><strong>6.	Requisitos para facturación</strong><br><br>Las áreas financiera y de abastecimiento hemos informado a todos los proveedores acerca de los requisitos mínimos y no subsanables para la presentación de facturas, el proveedor debe radicar sus facturas únicamente en las oficinas de Carvajal, en Hocol no se deben recibir facturas.<br><br>Se adjunta los requisitos de facturación.<br><br>A continuación referenciamos algunos de los documentos mínimos requeridos para facturar:<br><table border='0' style='margin-left: 10px;'><tr><td valign='top' style='font-family: Arial;'>a.</td><td style='font-family: Arial;'>Para el caso de prestación de servicios la factura debe indicar el municipio donde se prestó  el servicio y para la compra de bienes el municipio dónde se realizó la negociación de compra, incluyendo tarifa de ICA a la cual se grava(n) la(s) actividad(es), el Código de la actividad económica según los acuerdos municipales.</td></tr><tr><td valign='top' style='font-family: Arial;'>b.</td><td style='font-family: Arial;'>Expedir la factura en la misma moneda en la que se haya elaborado la entrada de materiales o la aceptación del servicio</td></tr><tr><td valign='top' style='font-family: Arial;'>c.</td><td style='font-family: Arial;'>Certificación firmada por el Representante Legal  a través de la cual manifieste, bajo la gravedad del juramento, que se encuentra a paz y salvo en relación con los pagos a proveedores y contratistas de la región donde presta los servicios prestados en Colombia (mes actual o inmediatamente anterior), en los casos que sea aplicable.</td></tr><tr><td valign='top' style='font-family: Arial;'>d.</td><td style='font-family: Arial;'>Tener adjunto una certificación firmada por el Representante Legal y Revisor fiscal   o contador cuando no exista la obligación de tener  Revisor Fiscal a través de la cual manifieste, bajo la gravedad del juramento, que se encuentra a paz y salvo por el pago de salarios, liquidaciones, aportes al Sistema Integral de Seguridad Social, aportes parafiscales de todos sus empleados y todas las obligaciones laborales a cargo. ( mes actual o inmediatamente anterior)</td></tr><tr><td valign='top' style='font-family: Arial;'>e.</td><td style='font-family: Arial;'>Documentación soporte EN ORIGINAL según el tipo de servicio prestado debidamente firmada. Ej: Planillas, Relación de Horas, Reporte de ejecución de obra etc.</td></tr></table><br><br>NOTA: Recuerden que no deben entregar las aceptaciones de servicio hasta que el contratista le entregue todas las certificaciones.<br><br>Cordial saludo,<br><firma><br><br>He leído, entendido y recibido la información relacionada con el contrato, así como las responsabilidades asociadas al rol Gerente de Contrato en cumplimiento de la Norma de Contratación, Controles de Auditoria, Norma de &Eacute;tica y Cumplimiento.</font>";
				$asunto_cambio_gerente="LEGALIZACION DE OTROSI ".$numero_modificacion." DEL CONTRATO ".strtoupper($numero_contrato);
				/** INICIO PARA EL INC021-18 **
				$nombre_otrosi_gerente=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$lista_contrato[9]));
				/** FIN PARA EL INC021-18 **/
				$email_cambio_gerente=str_replace('<numero_otrosi>', $numero_modificacion, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<numero_contrato>', strtoupper($numero_contrato), $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<objeto>', $objeto_contrato[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<contratista>', $contratista, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gerente_contrato>', $gerente_anterior[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<tipo_contrato>', $tipo_contrato, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<moneda_pago>', $moneda_pago, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<profesional_abastecimiento>', $profesional_abastecimiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gestor_abastecimiento>', $gestor_abastecimiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<fecha_inicio>', $fecha_inicio, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<fecha_fin>', $fecha_fin, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<monto>', "COP $".$monto_cop."<br>USD $".$monto_usd, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<hsse>', $hse, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<tipo_aseguramiento>', $aseguramiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<retencion>', $garantia, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gerente_anterior>', $gerente_anterior[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<reajustes>', $reajustes, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gastos>', $reembolsables, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<firma>', 'Jefatura de Abastecimiento', $email_cambio_gerente);
				$query="select u.nombre_administrador, u.email from $g1 as u, $ts6 as t where t.id_usuario=u.us_id AND t.id_rol_general=24 AND u.estado=1 and u.us_id <> 32";
				$para_actualiza = query_db($query);//	Profesional de aseguramiento
				$para_actualiza2 = query_db($query);//	Profesional de aseguramiento
				$nombre_aseguramiento=traer_fila_db($para_actualiza);
				$correos="";
				//sent_mail_with_signature(''.$nombre_aseguramiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
				while ($s_actual = traer_fila_db($para_actualiza2)) {
					//sent_mail_with_signature(''.$s_actual[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
					$correos=$correos.$s_actual[1].",,";
				}
				//sent_mail_with_signature(''.$gestor_abastecimiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//gestor de abastecimiento
				//$correos=$correos.$gestor_abastecimiento[1].",,";
				//sent_mail_with_signature(''.$gerente_anterior[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//gerente nuevo
				$correos=$correos.$gerente_anterior[1].",,";
				//sent_mail_with_signature(''.$profesional_abastecimiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//gerente nuevo
				$correos=$correos.$profesional_abastecimiento[1].",,";
				$correos=$correos.$correos_gestores;
				//sent_mail_with_signature('jeison.rivera@enternova.net',$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);
				sent_mail_with_signature($correos,$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);
			}if($tipo_id==0){//CONTRATO
				$email_cambio_gerente="<font font-size='10' face='arial'>Apreciado Gerente de Contrato<br><br>Le informamos que el contrato N°  <strong><numero_contrato></strong>, para <objeto>, se encuentra totalmente legalizado usted puede dar inicio a las actividades relacionadas con el mismo:<br><br><table border='1' width='80%' style='margin-left: 100px;'><tr><td colspan='2' style='color: #FFFFFF; background: #1f497d; font-family: Arial;' align='center'><strong>Datos Generales Del Contrato</strong></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Tipo de Contrato:</strong></td><td style='font-family: Arial;'><tipo_contrato></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Contratista:</strong></td><td style='font-family: Arial;'><contratista></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gerente del Contrato:</strong></td><td style='font-family: Arial;'><gerente_contrato></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Profesional / Comprador de Abastecimiento:</strong></td><td style='font-family: Arial;'><profesional_abastecimiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gestor de Abastecimiento:</strong></td><td style='font-family: Arial;'><gestor_abastecimiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Inicio:</strong></td><td style='font-family: Arial;'><fecha_inicio></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Fin:</strong></td><td style='font-family: Arial;'><fecha_fin></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Monto:</strong></td><td style='font-family: Arial;'><monto></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Moneda de Pago:</strong></td><td style='font-family: Arial;'><moneda_pago></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Informe de HSSE:</strong></td><td style='font-family: Arial;'><hsse></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Tipo de Aseguramiento:</strong></td><td style='font-family: Arial;'><tipo_aseguramiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Retención en Garantía:</strong></td><td style='font-family: Arial;'><retencion></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Reajustes:</strong></td><td style='font-family: Arial;'><reajustes></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gastos Reembolsables:</strong></td><td style='font-family: Arial;'><gastos></td></tr></table><br><br>Toda la información relacionada con cláusulas contractuales, anexos técnicos y comerciales del mismo puede encontrarlos en la memoria corporativa de Hocol, <a href='http://intranet.hocol.com.co/'>http://intranet.hocol.com.co/</a><br>Para temas relacionados con incumplimiento contractual y retención en garantía puede contactarse con <a href='mailto:maria.cock@hocol.com.co'>maria.cock@hocol.com.co</a> Coordinadora de Aseguramiento Administrativo y Control.<br>A continuación les presentamos los puntos de control que usted debe tener en cuenta como Gerente de contrato:<br><br><strong>1.	Tarifas</strong><br><br>Si en la cláusula cuarta de la minuta del contrato está establecido que puede incluir tarifas relacionadas con el objeto y alcance del contrato sin afectar el valor del contrato. Recuerde que el Contratista debe hacer el trámite a través la herramienta SGPA módulo de tarifas y estas deben estar soportadas por un documento firmado por el Contratista, el Gerente del Contrato.<br><br>Toda negociación o inclusión debe estar acompañada por el  Profesional de Abastecimiento.<br><br><strong>2.	Ejecución y seguimiento</strong><br><br>Mensualmente usted recibirá el reporte de ejecución de su  contrato, vigencia, saldos y detalle de ejecución, sobre el cual en caso de requerir extensión o aumento de monto  podrá registrarla en SGPA  y ponerse en contacto con el profesional de abastecimiento para solicitar las inclusiones de  manera oportuna y dentro de los tiempos de proceso la aprobación al respectivo nivel.<br><br><strong>3.	Documentación</strong><br><br>Es importante que todas las comunicaciones físicas, electrónicas, informes y documentos relacionados con la gestión y ejecución del contrato las hagan llegar al soporte de aseguramiento administrativo para que estas sean documentadas en la carpeta respectiva del contrato.<br>Toda esta información la pueden hacer llegar al siguiente correo: <a href='mailto:Vedelibeth.Ruiz@hcl.com.co'>Vedelibeth.Ruiz@hcl.com.co</a><br><br><strong>4.	Aseguramiento Administrativo de Contrato</strong><br><br>Hocol S.A. cuenta con un outsourcing de Aseguramiento Administrativo de Contratos, donde usted va a tener un apoyo en la revisión en temas laborales y contractuales del Contratista. Este aseguramiento se realiza de acuerdo de cómo quede el tipo de contrato y este aseguramiento es mes vencido.<br>Usted podrá consultar el estado del contratista y de este contrato en el siguiente link: <a href='http://www.controlar2.com/Login.aspx'>http://www.controlar2.com/Login.aspx</a>.<br><br><strong>5.	Requisitos para  Elaboración de Aceptaciones de Servicio</strong><br><br>Para la elaboración de las aceptaciones de servicio se debe hacer entrega al outsourcing contable de la siguiente información:<br><table border='0' style='margin-left: 10px;'><tr><td valign='top' style='font-family: Arial;'>a.</td><td style='font-family: Arial;'>Tiquete SGPA autorizado</td></tr><tr><td valign='top' style='font-family: Arial;'>b.</td><td style='font-family: Arial;'>Indicación de CeCo o AFE</td></tr><tr><td valign='top' style='font-family: Arial;'>c.</td><td style='font-family: Arial;'>Acta o tiquete de avance que soporte la recepción del servicio objeto del contrato</td></tr><tr><td valign='top' style='font-family: Arial;'>d.</td><td style='font-family: Arial;'>Prefactura en los casos en que se requiere validar temas fiscales (bases para IVA, exentos, etc).</td></tr><tr><td valign='top' style='font-family: Arial;'>e.</td><td style='font-family: Arial;'>Certificación del revisor fiscal y representante legal que están al día con todos los pagos de parafiscales (Sena, Caja de Compensación, ARL), pago de nómina y pago a proveedores.</td></tr></table><br><br><strong>6.	Requisitos para facturación</strong><br><br>Las áreas financiera y de abastecimiento hemos informado a todos los proveedores acerca de los requisitos mínimos y no subsanables para la presentación de facturas, el proveedor debe radicar sus facturas únicamente en las oficinas de Carvajal, en Hocol no se deben recibir facturas.<br>A continuación referenciamos algunos de los documentos mínimos requeridos para facturar:<br><br><table border='0' style='margin-left: 10px;'><tr><td valign='top' style='font-family: Arial;'>a.</td><td style='font-family: Arial;'>Para el caso de prestación de servicios la factura debe indicar el municipio donde se prestó  el servicio y para la compra de bienes el municipio dónde se realizó la negociación de compra, incluyendo tarifa de ICA a la cual se grava(n) la(s) actividad(es), el Código de la actividad económica según los acuerdos municipales</td></tr><tr><td valign='top' style='font-family: Arial;'>b.</td><td style='font-family: Arial;'>Expedir la factura en la misma moneda en la que se haya elaborado la entrada de materiales o la aceptación del servicio</td></tr><tr><td valign='top' style='font-family: Arial;'>c.</td><td style='font-family: Arial;'>Certificación firmada por el Representante Legal  a través de la cual manifieste, bajo la gravedad del juramento, que se encuentra a paz y salvo en relación con los pagos a proveedores y contratistas de la región donde presta los servicios prestados en Colombia (mes actual o inmediatamente anterior), en los casos que sea aplicable</td></tr><tr><td valign='top' style='font-family: Arial;'>d.</td><td style='font-family: Arial;'>Tener adjunto una certificación firmada por el Representante Legal y Revisor fiscal   o contador cuando no exista la obligación de tener  Revisor Fiscal a través de la cual manifieste, bajo la gravedad del juramento, que se encuentra a paz y salvo por el pago de salarios, liquidaciones, aportes al Sistema Integral de Seguridad Social, aportes parafiscales de todos sus empleados y todas las obligaciones laborales a cargo. ( mes actual o inmediatamente anterior)</td></tr><tr><td valign='top' style='font-family: Arial;'>e.</td><td style='font-family: Arial;'>Documentación soporte EN ORIGINAL según el tipo de servicio prestado debidamente firmada. Ej: Planillas, Relación de Horas, Reporte de ejecución de obra etc</td></tr></table><br><br>NOTA: Recuerden que no deben entregar las aceptaciones de servicio hasta que el contratista le entregue todas las certificaciones.<br><br>Cordial saludo,<br><firma><br><br>He leído, entendido y recibido la información relacionada con el contrato, así como las responsabilidades asociadas al rol Gerente de Contrato en cumplimiento de la Norma de Contratación, Controles de Auditoria, Norma de &Eacute;tica y Cumplimiento.</font>";
				$asunto_cambio_gerente="LEGALIZACION DE CONTRATO ".strtoupper($numero_contrato)." ".$contratista;
				$email_cambio_gerente=str_replace('<numero_contrato>', strtoupper($numero_contrato), $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<objeto>', $objeto_contrato[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<contratista>', $contratista, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gerente_contrato>', $gerente_anterior[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<tipo_contrato>', $tipo_contrato, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<moneda_pago>', $moneda_pago, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<profesional_abastecimiento>', $profesional_abastecimiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gestor_abastecimiento>', $gestor_abastecimiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<fecha_inicio>', $fecha_inicio, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<fecha_fin>', $fecha_fin, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<monto>', "COP $".$monto_cop."<br>USD $".$monto_usd, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<hsse>', $hse, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<tipo_aseguramiento>', $aseguramiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<retencion>', $garantia, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gerente_anterior>', $gerente_anterior[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<reajustes>', $reajustes, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gastos>', $reembolsables, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<firma>', $profesional_abastecimiento[0], $email_cambio_gerente);
				$query="select u.nombre_administrador, u.email from $g1 as u, $ts6 as t where t.id_usuario=u.us_id AND t.id_rol_general=24 AND u.estado=1 and u.us_id <> 32";
				$para_actualiza = query_db($query);//	Profesional de aseguramiento
				$para_actualiza2 = query_db($query);//	Profesional de aseguramiento
				$nombre_aseguramiento=traer_fila_db($para_actualiza);
				$correos="";
				//$correos=$correos.$nombre_aseguramiento[1].",,";
				//sent_mail_with_signature(''.$nombre_aseguramiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $profesional_abastecimiento[1], $profesional_abastecimiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
				while ($s_actual = traer_fila_db($para_actualiza2)) {
					//sent_mail_with_signature(''.$s_actual[1],$asunto_cambio_gerente,$email_cambio_gerente, $gestor_abastecimiento[1], $gestor_abastecimiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
					$correos=$correos.$s_actual[1].",,";
				}
				//sent_mail_with_signature(''.$gestor_abastecimiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $profesional_abastecimiento[1], $profesional_abastecimiento[0]);//gestor de abastecimiento
				//$correos=$correos.$gestor_abastecimiento[1].",,";
				//sent_mail_with_signature(''.$gerente_anterior[1],$asunto_cambio_gerente,$email_cambio_gerente, $profesional_abastecimiento[1], $profesional_abastecimiento[0]);//gerente nuevo
				$correos=$correos.$gerente_anterior[1].",,";
				//sent_mail_with_signature(''.$profesional_abastecimiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $profesional_abastecimiento[1], $profesional_abastecimiento[0]);//gerente nuevo
				$correos=$correos.$profesional_abastecimiento[1].",,";
				$correos=$correos.$correos_gestores;
				//LINEA DONDE SE INCLUYE EL CORREO DE DIANA DÁVILA
				$correos=$correos."diana.davila@hocol.com.co,,";
				sent_mail_with_signature($correos,$asunto_cambio_gerente,$email_cambio_gerente, $profesional_abastecimiento[1], $profesional_abastecimiento[0]);
				//sent_mail_with_signature('abastecimiento@hcl.com.co',$asunto_cambio_gerente,$email_cambio_gerente, $profesional_abastecimiento[1], $profesional_abastecimiento[0]);
				//modulo desempeño inicio
				include("desempeno/correos_solicitud_todos.php");
				
				
					$busca_datos_contrato = traer_fila_row(query_db("select * from vista_t9_contratos_definicion_criterios where id_contrato = ".$lista_contrato[0]));
					$ano=date($busca_datos_contrato[2]);
					$ano_cuatro_digitos =strtotime ($ano);
					$ano_cuatro_digitos=date('Y', $ano_cuatro_digitos);
					$mes=strtotime ($ano);
					$mes=date('m', $mes);
					$dia=strtotime ($ano);
					$dia=date('d', $dia);
					if($mes==2 and $dia==29){//si es biciesto
						$busca_datos_contrato[2]=$ano_cuatro_digitos."-".$mes."-28";
					}
					$jefe=busca_jefe_area_contrato_id_contrato_mc($busca_datos_contrato[0]);
					//puntual
					if($busca_datos_contrato[6]==1){
					//tipo servicio 1
						if($busca_datos_contrato[7]==1){
					
						$busca_num3 = traer_fila_row(query_db("select MAX(num3) from t9_criterios_evaluacion"));
						
						if($busca_num3[0]=="NULL" or $busca_num3[0]=="0"){
							
							$num3_agregado="1";
						}else{
						
							
							$num3_agregado=$busca_num3[0]+1;
						}
					$anno=date('y');
					$fecha_solicitud=date('Y-m-d');
					
							$insert = query_db("insert into t9_criterios_evaluacion (id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) values ('".$busca_datos_contrato[9]."','1','E','".$anno."','".$num3_agregado."','2','".$busca_datos_contrato[2]."','".$busca_datos_contrato[12]."','".$busca_datos_contrato[0]."','2','".$busca_datos_contrato[9]."','".$jefe."')".$trae_id_insrte);
							
							$id_buscado=id_insert($insert);
							
							$insert1 = query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, ".$id_buscado.", NULL from t9_aspectos_criterio where id_criterio=2 and tipo_servicio=1 and estado=1");
					
								define_aspecto_puntual($id_buscado);
						}
						//tipo servicio 2
						if($busca_datos_contrato[7]==2){
					
						$busca_num3 = traer_fila_row(query_db("select MAX(num3) from t9_criterios_evaluacion"));
						
						if($busca_num3[0]=="NULL" or $busca_num3[0]=="0"){
							
							$num3_agregado="1";
						}else{
						
							
							$num3_agregado=$busca_num3[0]+1;
						}
					$anno=date('y');
					$fecha_solicitud=date('Y-m-d');
					
							$insert = query_db("insert into t9_criterios_evaluacion (id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) values ('".$busca_datos_contrato[9]."','1','E','".$anno."','".$num3_agregado."','2','".$busca_datos_contrato[2]."','".$busca_datos_contrato[12]."','".$busca_datos_contrato[0]."','2','".$busca_datos_contrato[9]."','".$jefe."')".$trae_id_insrte);
					
							$id_buscado=id_insert($insert);
							
							$insert1 = query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, '".$id_buscado."', NULL from t9_aspectos_criterio where id_criterio=2 and tipo_servicio=2 and estado=1");
					
								define_aspecto_puntual($id_buscado);
						}
					}
					//marco
					if($busca_datos_contrato[6]==2){
					//tipo servicio 1
						if($busca_datos_contrato[7]==1){
					
						$busca_num3 = traer_fila_row(query_db("select MAX(num3) from t9_criterios_evaluacion"));
						
						if($busca_num3[0]=="NULL" or $busca_num3[0]=="0"){
							
							$num3_agregado="1";
						}else{
						
							
							$num3_agregado=$busca_num3[0]+1;
						}
					$anno=date('y');
					$fecha_solicitud=date('Y-m-d');
					
							$insert = query_db("insert into t9_criterios_evaluacion (id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) values ('".$busca_datos_contrato[9]."','1','E','".$anno."','".$num3_agregado."','2','".$busca_datos_contrato[2]."','".$busca_datos_contrato[12]."','".$busca_datos_contrato[0]."','3','".$busca_datos_contrato[9]."','".$jefe."')".$trae_id_insrte);
					
							$id_buscado=id_insert($insert);
							$insert1 = query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, '".$id_buscado."', NULL from t9_aspectos_criterio where id_criterio=2 and tipo_servicio=1 and estado=1");
					
								definir_aspecto_marco($id_buscado);
						}
						//tipo servicio 2
						if($busca_datos_contrato[7]==2){
					
						$busca_num3 = traer_fila_row(query_db("select MAX(num3) from t9_criterios_evaluacion"));
						
						if($busca_num3[0]=="NULL" or $busca_num3[0]=="0"){
							
							$num3_agregado="1";
						}else{
						
							
							$num3_agregado=$busca_num3[0]+1;
						}
					$anno=date('y');
					$fecha_solicitud=date('Y-m-d');
					
							$insert = query_db("insert into t9_criterios_evaluacion (id_estado,num1,num2,num3,id_criterio,fecha_solicitud,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) values ('".$busca_datos_contrato[9]."','E','".$anno."','".$num3_agregado."','2','".$busca_datos_contrato[2]."','".$busca_datos_contrato[12]."','".$busca_datos_contrato[0]."','3','".$busca_datos_contrato[9]."','".$jefe."')".$trae_id_insrte);
					
					$id_buscado=id_insert($insert);
							
							$insert1 = query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, '".$id_buscado."', NULL from t9_aspectos_criterio where id_criterio=2 and tipo_servicio=2 and estado=1");
					
								definir_aspecto_marco($id_buscado);
						}
					}
					//modulo desempeño fin
			}
			/************* PARA EL DES-009-2017*************/
			if($sel_quien_es_gestor[0] == 0 or $sel_quien_es_gestor[0] == ""){
				$sel_quien_es_gestor[0] = 32;
				}
				
			$sel_datos_gestor_envia_email = traer_fila_row(query_db("select nombre_administrador, email from t1_us_usuarios where us_id = ".$sel_quien_es_gestor[0]));
							$mail = new PHPMailer();
								$mail->IsSMTP(); $mail->SMTPAuth = false; $mail->SMTPSecure = ""; $mail->Port = 25; $mail->Username = $correo_autentica_phpmailer; $mail->Password = $contrasena_autentica_phpmailer; $mail->Host = $servidor_phpmailer;	$mail->From = $sel_datos_gestor_envia_email[1];	$mail->FromName = $sel_datos_gestor_envia_email[0];
								
							$mail = new PHPMailer();
								$mail->IsSMTP(); $mail->SMTPAuth = false; $mail->SMTPSecure = ""; $mail->Port = 25; $mail->Username = $correo_autentica_phpmailer; $mail->Password = $contrasena_autentica_phpmailer; $mail->Host = $servidor_phpmailer;	$mail->From = "abastecimiento@hcl.com.co";	$mail->FromName = "Bogota, Abastecimiento";

							
							$gerente = 0;$profesional=0;$gestor_abastecimiento = 0;							
							if($sel_co_mod[0] > 0){$gerente = $sel_co_mod[0];}
							if($sel_co_mod[1] > 0){$profesional=$sel_co_mod[1];}
							if($sel_quien_es_gestor[0] > 0){ $gestor_abastecimiento=$sel_quien_es_gestor[0];}
							
							$sele_email_usurios = query_db("select email,nombre_administrador from t1_us_usuarios where us_id in (7,".$gerente.", ".$profesional.", '".$gestor_abastecimiento."') group by email,nombre_administrador");
								  while($sl_correo = traer_fila_db($sele_email_usurios)){$mail->AddAddress($sl_correo[0],$sl_correo[1]); 
								  $correos_envia_impri = $sl_correo[0]."-".$correos_envia_impri;}
								  
								  /*contrato */
								  if($sel_modifica[0] != 0 and $sel_modifica[0] != ""){
			$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista, vigencia_mes, id, CAST(objeto as text) from t7_contratos_contrato where id=".$sel_modifica[1]));
		}else{
			$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista, vigencia_mes, id, CAST(objeto as text) from t7_contratos_contrato where id=".$id_contrato_arr));
		}
		
					
					 $numero_contrato1 = "C";
					 $separa_fecha_crea = explode("-",$sel_contrato[1]);$ano_contra = $separa_fecha_crea[0];					
						$numero_contrato2 = substr($ano_contra,2,2);
						$numero_contrato3 = $sel_contrato[0];
						$numero_contrato4 = $sel_contrato[2];
					
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contrato[5]);
							  /*contrato*/
					
					if($sel_modifica[0] != 0 and $sel_modifica[0] != ""){
						$asunto = " Legalizacion de ".saca_nombre_lista("t1_tipo_complemento",$sel_modifica[0],'nombre','id')." ".$sel_modifica[2]." del contrato ".$num_impri;
						$texto_correo = 'Cordial saludo,<br /><br />Se informa que, '.saca_nombre_lista("t1_tipo_complemento",$sel_modifica[0],'nombre','id').' '.$sel_modifica[2].' del contrato '.$num_impri.' '.$sel_contratista[0].', '.$sel_contrato[6].'.<br /> Ya se encuentra legalizado en el SGPA.<br /><br /><br />Gestor Abastecimiento<br />'.$sel_datos_gestor_envia_email[0];
					}else{
						$asunto = " Legalizacion del contrato ".$num_impri." ".$sel_contratista[0];
						$texto_correo = 'Cordial saludo,<br /><br />Se informa que el contrato '.$num_impri.' '.$sel_contratista[0].', '.$sel_contrato[6].'.<br /> Ya se encuentra legalizado en el SGPA.<br /><br /><br />Gestor Abastecimiento<br />'.$sel_datos_gestor_envia_email[0];
						}
								
								

								//echo "Se envia :".$correos_envia_impri;
								//echo "<br /> Asunto: ".$asunto;
								//echo "<br /> Texto: ".$texto_correo;
								$mail->Subject = $asunto;
								$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
								$mail->Body = $texto_correo;
								$mail->AltBody = "SGPA Informaciones";
								//$mail->Send();

		/*ENVIO DE CORREO ELECTRONICO legalizado*/
		
		}
		
	if($campo_fecha_fin == "f_fin_garantia_en_cont_for"  and elimina_comillas_2($_POST["f_fin_garantia_en_cont_for"]) != "" and elimina_comillas_2($_POST["f_fin_garantia_en_cont_for"]) != " "){
		
		$updta = query_db("update t7_relacion_campos_legalizacion_datos set f_fin_garantia_tramite='$valor_fecha_fin' where $id_campo_aplica = ".$id_contrato_arr);//actualiza el paso de fin tramite garantia
		
		
		/*ENVIO DE CORREO ELECTRONICO legalizado*/
     		$sel_co_mod = traer_fila_row(query_db("select gerente, especialista from t7_contratos_contrato where id = ".$id_contrato_arr));
			$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_co_mod[0]));
							
							
							$gerente = 0;$profesional=0;$gestor_abastecimiento = 0;							
							if($sel_co_mod[0] > 0){$gerente = $sel_co_mod[0];}
							if($sel_co_mod[1] > 0){$profesional=$sel_co_mod[1];}
							if($sel_quien_es_gestor[0] > 0){ $gestor_abastecimiento=$sel_quien_es_gestor[0];}
							
							
			$sel_datos_gestor_envia_email = traer_fila_row(query_db("select nombre_administrador, email from t1_us_usuarios where us_id = ".$gestor_abastecimiento));
							$mail = new PHPMailer();
								$mail->IsSMTP(); $mail->SMTPAuth = false; $mail->SMTPSecure = ""; $mail->Port = 25; $mail->Username = $correo_autentica_phpmailer; $mail->Password = $contrasena_autentica_phpmailer; $mail->Host = $servidor_phpmailer;	$mail->From = $sel_datos_gestor_envia_email[1];	$mail->FromName = $sel_datos_gestor_envia_email[0];

														
							
							$gerente = 0;$profesional=0;$gestor_abastecimiento = 0;							
							if($sel_co_mod[0] > 0){$gerente = $sel_co_mod[0];}
							if($sel_co_mod[1] > 0){$profesional=$sel_co_mod[1];}
							if($sel_quien_es_gestor[0] > 0){ $gestor_abastecimiento=$sel_quien_es_gestor[0];}
							
							$sele_email_usurios = query_db("select email,nombre_administrador from t1_us_usuarios where us_id in (7,$gestor_abastecimiento, $gerente, $profesional) group by email,nombre_administrador");
								  while($sl_correo = traer_fila_db($sele_email_usurios)){$mail->AddAddress($sl_correo[0],$sl_correo[1]); 
								  $correos_envia_impri = $sl_correo[0]."-".$correos_envia_impri;}
								  
								  /*contrato */
					$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista, vigencia_mes, id, CAST(objeto as text) from t7_contratos_contrato where id=".$id_contrato_arr));
					 $numero_contrato1 = "C";
					 $separa_fecha_crea = explode("-",$sel_contrato[1]);$ano_contra = $separa_fecha_crea[0];					
						$numero_contrato2 = substr($ano_contra,2,2);
						$numero_contrato3 = $sel_contrato[0];
						$numero_contrato4 = $sel_contrato[2];
					
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contrato[5]);
							  /*contrato*/
								  
								$asunto = " Contrato ".$num_impri." ".$sel_contratista[0]." - Retencion de Garantias";
								$texto_correo = 'Cordial Saludo,<br /><br />De acuerdo a la cláusula sexta del contrato en referencia, se informa que la Fiducia ya se encuentra totalmente legalizada tanto en Par Servicios como en SAP.<br /><br /> Por favor tener en cuenta al momento de realizar los pagos de las facturas.<br /><br /> Sin otro particular, <br /><br /><br /> Gestor Abastecimiento<br />'.$sel_datos_gestor_envia_email[0];

								//echo "Se envia :".$correos_envia_impri;
								//echo "<br /> Asunto: ".$asunto;
								//echo "<br /> Texto: ".$texto_correo;
								$mail->Subject = $asunto;
								$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
								$mail->Body = $texto_correo;
								$mail->AltBody = "SGPA Informaciones";
								//$mail->Send();
						
		/*ENVIO DE CORREO ELECTRONICO legalizado*/
		
		}
		
	if($campo_fecha_fin == "f_fin_entrega_todo" and elimina_comillas_2($_POST["f_fin_entrega_todo"]) != "" and elimina_comillas_2($_POST["f_fin_entrega_todo"]) != " "){
		if($sel_modifica[0]!=0 and $sel_modifica[0]!= ""){
				$update_estado_cotrato = query_db("update t7_contratos_complemento set estado = 48 where id = ".$id_contrato_arr);
				if($sel_modifica[3]!=0 and $sel_modifica[3]!= ""){
					$update_estado_cotrato = query_db("update t2_item_pecc set estado = 32 where id_item = ".$sel_modifica[3]);
					}
					$sel_solicitud_aprobacion = traer_fila_row(query_db("select count(*) from t7_contratos_complemento where id_item_pecc = ".$sel_modifica[3]." and estado not in (48,49,50)"));
					if($sel_solicitud_aprobacion[0] == 0 and $sel_modifica[3] > 0){// si no falta ninguno finaliza la solicitud de aprobacion del contrato
					//$update_estado_cotrato = query_db("update t2_item_pecc set estado = 32 where id_item = ".$sel_modifica[3]);
					}
			}else{
				$update_estado_cotrato = query_db("update t7_contratos_contrato set estado = 48 where id = ".$id_contrato_arr);
				//selecciona la solicitud del contrato
				$sel_solicitud_contrato = traer_fila_row(query_db("select id_item from t7_contratos_contrato where id = ".$id_contrato_arr));
				//busca otros contratos relacionados y cuanta cuantos faltan
				$sel_contratos_relacionados=traer_fila_row(query_db("select count(*) from t7_contratos_contrato where id_item = ".$sel_solicitud_contrato[0]." and estado not in (48,49,50)"));
				if($sel_contratos_relacionados[0] == 0){// si no falta ninguno finaliza la solicitud de aprobacion del contrato
					$update_estado_cotrato = query_db("update t2_item_pecc set estado = 32 where id_item = ".$sel_solicitud_contrato[0]);
					}
				
			}
		}	
	
	if($_POST["da"] == 1){//si viene desde el inbox de legal 
		?><script> 
		parent.window.location.reload();
        </script><?
		}else{
			
		if($_POST["tipo_check_list"] == "modificacion"){	
	?><script> window.parent.ajax_carga('../aplicaciones/contratos/c_complemento.php?id=<?=$_POST["id_contrato_arr_envia"];?>&id_complemento=<?=$_POST["id_complemento"];?>','carga_acciones_permitidas');</script><?	
		}else{
				?><script> window.parent.ajax_carga('../aplicaciones/contratos/v_contratos.php?id=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');</script><?	
			}
	}
	}
	
	
/*validacion para que el valor del contrato sea igual a las aprobaciones*/
if(($_POST["accion"]=="graba_contrato" or $_POST["accion"]=="graba_contrato_admin_aseguramiento") and $_POST["tipo_contrato"] == 1){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id		
		$id_contratista = elimina_comillas_2($_POST["contratista"]);
		
	$alert_validacion_valor_contra="";

//$query_reporte_validacion = traer_fila_row(query_db("select valor_usd,valor_cop, monto_usd, monto_cop from reporte_juan_david where id =".$id_contrato_arr." "));
//$query_reporte_validacion = traer_fila_row(query_db("select SUM(isnull(valor_usd,0) + isnull(usd_otrosi,0)) as usd, SUM(isnull(valor_cop,0) + isnull(cop_otrosi,0)) as cop from v_reporte_valor_contrato_puntual where id =".$id_contrato_arr." "));

	$query_reporte_validacion = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from v_validacion_final_contrato_puntual where id_contrato=".$id_contrato_arr));
		
$total_aprobaciones = $query_reporte_validacion[0]+($query_reporte_validacion[1]/3000); 
$total_modulo_contratos =elimina_comillas_2(valida_numero_db($_POST["monto_usd"]))+(elimina_comillas_2(valida_numero_db($_POST["monto_cop"]))/3000);

echo "Aprobaciones: ".$total_aprobaciones." - Valor_contrato".$total_modulo_contratos;
if($total_aprobaciones != $total_modulo_contratos){
	
		?><script> //alert("ATENCION: El valor del contrato no coincide con el valor de las aprobaciones")
        //window.parent.document.getElementById("cargando_pecc").style.display = "none";
        	//window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El valor del contrato no coincide con el valor de las aprobaciones<br>', 20, 10, 18)
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El valor del contrato no coincide con el valor de las aprobaciones Aprobaciones:<?=$total_aprobaciones?> - Valor_contrato<?=$total_modulo_contratos?>', 20, 10, 18)
        </script><?
		exit;
		
	}



}/*FIN validacion*/

	
if($_POST["accion"]=="graba_contrato_admin_aseguramiento"){
	
	//INC010-18 INICIO
	$busca_ase="select nombre from t1_tipo_aseguramiento_admin where id=".$_POST['aseguramiento_admin'];
	$nombre_aseg=traer_fila_row(query_db($busca_ase));
	
		if($notifica_email=="0"){
			?><script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', '*El Envió de Notificaciones Es Obligatorio' , 40, 5, 12);
			</script>
			<?
			exit();
			}
	//INC010-18 FIN
$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id		
	$explode = explode("----,",elimina_comillas_2($_POST["gerente_confirma_asegu"]));
		$id_gerente = $explode[1];
		$nombre_gerente = str_replace('-', '',$explode[0]);
		
		//echo "update $co1 set aseguramiento_admin ='".elimina_comillas_2($_POST["aseguramiento_admin"])."', informe_hse = '".elimina_comillas_2($_POST["info_hse"])."', gerente_por_aseguramiento ='".$id_gerente."', gerente ='".$id_gerente."' where id = ".$id_contrato_arr;
$update_sql = query_db("update $co1 set aseguramiento_admin ='".elimina_comillas_2($_POST["aseguramiento_admin"])."', informe_hse = '".elimina_comillas_2($_POST["info_hse"])."', gerente_por_aseguramiento ='".$id_gerente."', gerente ='".$id_gerente."' where id = ".$id_contrato_arr);

		/** INICIO PARA EL DES-017-17*****/		
			$query="select CAST(objeto as text) from $co1 where id=$id_contrato_arr";
			$objeto_contrato=traer_fila_row(query_db($query));
			$query="select * from $co1 where id=$id_contrato_arr";
			$lista_contrato=traer_fila_row(query_db($query));
			$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$lista_contrato[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			$contratista=$sel_pro_q[3];
			$fecha_inicio=$lista_contrato[10];
			$fecha_fin=$lista_contrato[11];
			$monto_cop=valida_numero_imp($lista_contrato[18]);
			$monto_usd=valida_numero_imp($lista_contrato[17]);
			$moneda_pago="";
			if($monto_cop!=0){
				$moneda_pago=$moneda_pago." COP";
			}elseif($monto_uds!=0){
				if($moneda_pago!=""){
					$moneda_pago=$moneda_pago.", USD";
				}else{
					$moneda_pago=$moneda_pago." USD";
				}
			}else{
				$moneda_pago="No Aplica";
			}
			$aplica_garantia=$lista_contrato[55];
			$garantia="";
			if($aplica_garantia==1){
				$garantia="Si ";
				if($lista_contrato[56]==5){
					$garantia=$garantia."5% ";
				}
				if($lista_contrato[56]==1){
					$garantia=$garantia."1% ";
				}
				if($lista_contrato[57]==1){
					$garantia=$garantia."Parcial.";
				}
				if($lista_contrato[57]==2){
					$garantia=$garantia."Al Liquidar el contrato.";
				}
			}else{
				$garantia="No Aplica";
			}
			$gestor_abastecimiento = traer_fila_row(query_db("select nombre_gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$lista_contrato[9]));//$gestor_abastecimiento[0]nombre $gestor_abastecimiento[1]email
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[19]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[2];//consecutivo
			$numero_contrato4 = $lista_contrato[43];//apellido
			//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
			$numero_contrato = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[1]);
			$tipo_contrato=$_POST['tipo_contrato_nombre'];
			$id_gerente_antiguo=$_POST['gerente_antiguo'];
			$hse=$_POST['info_hse'];
			if($hse=="NO")$hse="No Aplica";
			$id_aseguramiento=$_POST['aseguramiento_admin'];
			$query1="select nombre from t1_tipo_aseguramiento_admin where id=$id_aseguramiento";
			$aseguramiento=traer_fila_row(query_db($query1));
			$query="select nombre_administrador, email from $g1 where us_id=$id_gerente_antiguo";
			$gerente_anterior=traer_fila_row(query_db($query));
			$query="select nombre_administrador, email from $g1 where us_id=$lista_contrato[16];";
			$profesional_abastecimiento=traer_fila_row(query_db($query));
			$query="select email from $g1 where us_id=$id_gerente";
			$correo_gerente=traer_fila_row(query_db($query));
	
			$id_contrato_tarifas=traer_fila_row(query_db("select * from t6_tarifas_contratos where id_contrato = ".$lista_contrato[0]));
			$id_reajustes=traer_fila_row(query_db("select count(*) from t6_tarifas_ipc_contrato where t6_tarifas_contratos_id=$id_contrato_tarifas[0] and ipc_administracion = 1 and estado = 1"));
			$reajustes='';
			if($id_reajustes[0]>=1){
				$reajustes=$reajustes."IPC";
			}else{
				$reajustes=$reajustes."No Aplica";
			}
			$busca_reembolsable = traer_fila_row(query_db("select t6_tarifas_reembosables1_contrato_id, porcentaje_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_reemblsable_principal where t6_tarifas_contratos_id = $id_contrato_tarifas[0]  and estado = 1 and porcentaje_administracion >=0"));
			$reembolsables='';
			if($busca_reembolsable[0]>=1){
				$reembolsables=$reembolsables."SI ".$busca_reembolsable[1]."%";
			}else{
				$reembolsables=$reembolsables."No Aplica";
			}
			if($_POST['notifica_email']==1){
				$email_cambio_gerente="<font font-size='10' face='arial'>Apreciado Gerente de Contrato<br><br>Le informamos que usted fue asignado como nuevo Gerente de Contrato N° <strong><numero_contrato></strong>, para <objeto>. A continuación le damos un resumen del contrato:<br><br><table border='1' width='80%' style='margin-left: 100px;'><tr><td colspan='2' style='color: #FFFFFF; background: #1f497d; font-family: Arial;' align='center'><strong>Datos Generales Del Contrato</strong></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Tipo de Contrato:</strong></td><td style='font-family: Arial;'><tipo_contrato></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Contratista:</strong></td><td style='font-family: Arial;'><contratista></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gerente del Contrato:</strong></td><td style='font-family: Arial;'><gerente_contrato></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Profesional / Comprador de Abastecimiento:</strong></td><td style='font-family: Arial;'><profesional_abastecimiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gestor de Abastecimiento:</strong></td><td style='font-family: Arial;'><gestor_abastecimiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Inicio:</strong></td><td style='font-family: Arial;'><fecha_inicio></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Fin:</strong></td><td style='font-family: Arial;'><fecha_fin></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Monto:</strong></td><td style='font-family: Arial;'><monto></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Moneda de Pago:</strong></td><td style='font-family: Arial;'><moneda_pago></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Informe de HSSE:</strong></td><td style='font-family: Arial;'><hsse></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Tipo de Aseguramiento:</strong></td><td style='font-family: Arial;'><tipo_aseguramiento></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Retención en Garantía:</strong></td><td style='font-family: Arial;'><retencion></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Reajustes:</strong></td><td style='font-family: Arial;'><reajustes></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gastos Reembolsables:</strong></td><td style='font-family: Arial;'><gastos></td></tr></table><br><br>Es importante que usted se ponga en contacto con el anterior gerente de contrato <strong><gerente_anterior></strong>, para que le informe los aspectos técnicos que debe tener en cuenta  en la ejecución del contrato.<br><br>Toda la información relacionada con cláusulas contractuales, anexos técnicos y comerciales del mismo puede encontrarlos en la memoria corporativa de Hocol, <a href='http://intranet.hocol.com.co/'>http://intranet.hocol.com.co/</a><br>Para temas relacionados con incumplimiento contractual y retención en garantía puede contactarse con <a href='mailto:maria.cock@hocol.com.co'>maria.cock@hocol.com.co</a> Coordinadora de Aseguramiento Administrativo y Control.<br>A continuación les presentamos los puntos de control que usted debe tener en cuenta como Gerente de contrato:<br><br><strong>1.	Tarifas</strong><br><br>Si en la cláusula cuarta de la minuta del contrato está establecido que puede incluir tarifas relacionadas con el objeto y alcance del contrato sin afectar el valor del contrato. Recuerde que el Contratista debe hacer el trámite a través la herramienta SGPA módulo de tarifas y estas deben estar soportadas por un documento firmado por el Contratista, el Gerente del Contrato.<br><br>Toda negociación o inclusión debe estar acompañada por el  Profesional de Abastecimiento.<br><br><strong>2.	Ejecución y seguimiento</strong><br><br>Mensualmente usted recibirá el reporte de ejecución de su  contrato, vigencia, saldos y detalle de ejecución, sobre el cual en caso de requerir extensión o aumento de monto  podrá registrarla en SGPA  y ponerse en contacto con el profesional de abastecimiento para solicitar las inclusiones de  manera oportuna y dentro de los tiempos de proceso la aprobación al respectivo nivel.<br><br><strong>3.	Documentación</strong><br><br>Es importante que todas las comunicaciones físicas, electrónicas, informes y documentos relacionados con la gestión y ejecución del contrato las hagan llegar al soporte de aseguramiento administrativo para que estas sean documentadas en la carpeta respectiva del contrato.<br><br>Toda esta información la pueden hacer llegar al siguiente correo: <a href='mailto:Vedelibeth.Ruiz@hcl.com.co'>Vedelibeth.Ruiz@hcl.com.co</a><br><br><strong>4.	Aseguramiento Administrativo de Contrato</strong><br><br>Hocol S.A. cuenta con un outsourcing de Aseguramiento Administrativo de Contratos, donde usted va a tener un apoyo en la revisión en temas laborales y contractuales del Contratista. Este aseguramiento se realiza de acuerdo de cómo quede el tipo de contrato y este aseguramiento es mes vencido.<br><br>Usted podrá consultar el estado del contratista y de este contrato en el siguiente link: <a href='http://www.controlar2.com/Login.aspx'>http://www.controlar2.com/Login.aspx</a>.<br><br><strong>5.	Requisitos para  Elaboración de Aceptaciones de Servicio</strong><br><br>Para la elaboración de las aceptaciones de servicio se debe hacer entrega al outsourcing contable de la siguiente información:<br><table border='0' style='margin-left: 10px;'><tr><td valign='top' style='font-family: Arial;'>a.</td><td style='font-family: Arial;'>Tiquete SGPA autorizado</td></tr><tr><td valign='top' style='font-family: Arial;'>b.</td><td style='font-family: Arial;'>Indicación de CeCo o AFE</td></tr><tr><td valign='top' style='font-family: Arial;'>c.</td><td style='font-family: Arial;'>Acta o tiquete de avance que soporte la recepción del servicio objeto del contrato</td></tr><tr><td valign='top' style='font-family: Arial;'>d.</td><td style='font-family: Arial;'>Prefactura en los casos en que se requiere validar temas fiscales (bases para IVA, exentos, etc).</td></tr><tr><td valign='top' style='font-family: Arial;'>e.</td><td style='font-family: Arial;'>Certificación del revisor fiscal y representante legal que están al día con todos los pagos de parafiscales (Sena, Caja de Compensación, ARL), pago de nómina y pago a proveedores.</td></tr></table><br><br><strong>6.	Requisitos para facturación</strong><br><br>Las áreas financiera y de abastecimiento hemos informado a todos los proveedores acerca de los requisitos mínimos y no subsanables para la presentación de facturas, el proveedor debe radicar sus facturas únicamente en las oficinas de Carvajal, en Hocol no se deben recibir facturas.<br><br>Se adjunta los requisitos de facturación.<br><br>A continuación referenciamos algunos de los documentos mínimos requeridos para facturar:<br><table border='0' style='margin-left: 10px;'><tr><td valign='top' style='font-family: Arial;'>a.</td><td style='font-family: Arial;'>Para el caso de prestación de servicios la factura debe indicar el municipio donde se prestó  el servicio y para la compra de bienes el municipio dónde se realizó la negociación de compra, incluyendo tarifa de ICA a la cual se grava(n) la(s) actividad(es), el Código de la actividad económica según los acuerdos municipales.</td></tr><tr><td valign='top' style='font-family: Arial;'>b.</td><td style='font-family: Arial;'>Expedir la factura en la misma moneda en la que se haya elaborado la entrada de materiales o la aceptación del servicio</td></tr><tr><td valign='top' style='font-family: Arial;'>c.</td><td style='font-family: Arial;'>Certificación firmada por el Representante Legal  a través de la cual manifieste, bajo la gravedad del juramento, que se encuentra a paz y salvo en relación con los pagos a proveedores y contratistas de la región donde presta los servicios prestados en Colombia (mes actual o inmediatamente anterior), en los casos que sea aplicable.</td></tr><tr><td valign='top' style='font-family: Arial;'>d.</td><td style='font-family: Arial;'>Tener adjunto una certificación firmada por el Representante Legal y Revisor fiscal   o contador cuando no exista la obligación de tener  Revisor Fiscal a través de la cual manifieste, bajo la gravedad del juramento, que se encuentra a paz y salvo por el pago de salarios, liquidaciones, aportes al Sistema Integral de Seguridad Social, aportes parafiscales de todos sus empleados y todas las obligaciones laborales a cargo. ( mes actual o inmediatamente anterior)</td></tr><tr><td valign='top' style='font-family: Arial;'>e.</td><td style='font-family: Arial;'>Documentación soporte EN ORIGINAL según el tipo de servicio prestado debidamente firmada. Ej: Planillas, Relación de Horas, Reporte de ejecución de obra etc.</td></tr></table><br><br>NOTA: Recuerden que no deben entregar las aceptaciones de servicio hasta que el contratista le entregue todas las certificaciones.<br><br>Cordial saludo,<br><firma><br><br>He leído, entendido y recibido la información relacionada con el contrato, así como las responsabilidades asociadas al rol Gerente de Contrato en cumplimiento de la Norma de Contratación, Controles de Auditoria, Norma de &Eacute;tica y Cumplimiento.</font>";
				$asunto_cambio_gerente="ASIGNACION COMO GERENTE DE CONTRATO ".strtoupper($numero_contrato);
				$email_cambio_gerente=str_replace('<numero_contrato>', strtoupper($numero_contrato), $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<objeto>', $objeto_contrato[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<contratista>', $contratista, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gerente_contrato>', $nombre_gerente, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<tipo_contrato>', $tipo_contrato, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<moneda_pago>', $moneda_pago, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<profesional_abastecimiento>', $profesional_abastecimiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gestor_abastecimiento>', $gestor_abastecimiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<fecha_inicio>', $fecha_inicio, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<fecha_fin>', $fecha_fin, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<monto>', "COP $".$monto_cop."<br>USD $".$monto_usd, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<hsse>', $hse, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<tipo_aseguramiento>', $aseguramiento[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<retencion>', $garantia, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gerente_anterior>', $gerente_anterior[0], $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<reajustes>', $reajustes, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<gastos>', $reembolsables, $email_cambio_gerente);
				$email_cambio_gerente=str_replace('<firma>', 'Jefatura de Abastecimiento', $email_cambio_gerente);
				$query="select u.nombre_administrador, u.email from $g1 as u, $ts6 as t where t.id_usuario=u.us_id AND t.id_rol_general in (24,26) AND u.estado=1";
				
				$para_actualiza = query_db($query);//	Profesional y analista  de aseguramiento
				
				//saca nombre de la firma
				$query2="select u.nombre_administrador, u.email from $g1 as u, $ts6 as t where t.id_usuario=u.us_id AND t.id_rol_general in (24) AND u.estado=1";
				$para_actualiza2 = query_db($query2);//	Profesional de aseguramiento
				$nombre_aseguramiento=traer_fila_db($para_actualiza2);
				//saca nombre de la firma
				
				$correos="";
				//sent_mail_with_signature(''.$nombre_aseguramiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
				while ($s_actual = traer_fila_db($para_actualiza)) {
					//sent_mail_with_signature(''.$s_actual[1],$asunto_cambio_gerente,$email_cambio_gerente, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
					$correos=$correos.$s_actual[1].",,";
				}
				
				$id_us=$_SESSION["id_us_session"];
				$query="insert into $co13(id_gerente, id_modifica, id_contrato, fecha_modifica) values($id_gerente, $id_us, $lista_contrato[0], '$fecha')";
				$para_actualiza = query_db($query);
				//sent_mail_with_signature(''.$gestor_abastecimiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//gestor de abastecimiento
				$correos=$correos.$gestor_abastecimiento[1].",,";
				//sent_mail_with_signature(''.$profesional_abastecimiento[1],$asunto_cambio_gerente,$email_cambio_gerente, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//profesional de abastecimiento
				$correos=$correos.$profesional_abastecimiento[1].",,";
				//sent_mail_with_signature(''.$correo_gerente[0],$asunto_cambio_gerente,$email_cambio_gerente, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//gerente nuevo
				$correos=$correos.$correo_gerente[0].",,";
				//sent_mail_with_signature(''.$gerente_anterior[1],$asunto_cambio_gerente,$email_cambio_gerente, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//gerente antiguo
				$correos=$correos.$gerente_anterior[1].",,";
				
				sent_mail_with_signature($correos,$asunto_cambio_gerente,$email_cambio_gerente, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);
				//sent_mail_with_signature('abastecimiento@hcl.com.co',$asunto_cambio_gerente,$email_cambio_gerente, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);
				
				
				
				
				//INC010-18 INICIO
				$id_log = log_de_procesos_sgpa(4, 24, 44, $id_contrato_arr, 0, 0);//actualiza general
				
			    log_agrega_detalle ($id_log, "Gerente de Contrato", $nombre_gerente, "",1);
				log_agrega_detalle ($id_log, "Envia Notificación", "Cambio de Gerente", "",1);
				log_agrega_detalle ($id_log, "Gerente de Contrato Anterior", $gerente_anterior[0], "",1);
				log_agrega_detalle ($id_log, "Informe HSE", $_POST['info_hse'], "",1);
				log_agrega_detalle ($id_log, "Aseguramiento Administrativo", $nombre_aseg[0], "",1);
				
				//INC010-18 FIN
				
				
				
			}
			if($_POST['notifica_email']==2){
				$email_contrato="<font font-size='10' face='arial' color='#000000'>Bogotá D.C.<br><br>Señores<br><contratista><br>Atn. <representante><br><br>Ref:	Contrato <strong><numero_contrato></strong>, <objeto_contrato><br><br>Cordial Saludo.<br><br>Por medio de la presente informamos que el Contrato <strong><numero_contrato></strong>, suscrito entre HOCOL y <contratista> y HOCOL designó a <strong><gerente></strong> como Gerente del Contrato, quien será su representante directo y punto focal frente al Contratista en lo concerniente a la ejecución del Contrato.<br><br>Para efectos de notificaciones, la correspondencia deberá ser dirigida a<br><br><strong><gerente></strong><br>Carrera 7 No. 113-43 piso 16 - Bogotá<br>Teléfono: 4884000 – fax: 4884099<br>Correo electrónico: <email_gerente><br><br><span style='color: #000000;'>Sin otro particular<br><br><strong><nombre_aseguramiento></strong><br>Coordinadora de Aseguramiento Administrativo y Control<br>Jefatura de Abastecimiento, Logistica y Administración</span></font>";
				$asunto_contrato="CONTRATO N° ".strtoupper($numero_contrato)." - ASIGNACION GERENTE DE CONTRATO";//ontrato nuevo a Contratista
				$email_contrato=str_replace('<numero_contrato>', strtoupper($numero_contrato), $email_contrato);
				$email_contrato=str_replace('<contratista>', $contratista, $email_contrato);
				$email_contrato=str_replace('<objeto_contrato>', $lista_contrato[3], $email_contrato);
				$email_contrato=str_replace('<gerente>', $nombre_gerente, $email_contrato);
				$email_contrato=str_replace('<representante>', $lista_contrato[13], $email_contrato);
				$email_contrato=str_replace('<email_gerente>', "<a href='mailto:".$correo_gerente[0]."'>".$correo_gerente[0]."</a>", $email_contrato);
				$email_contratista=$lista_contrato[7];
				$email_contratista=str_replace("&#64;","@",$email_contratista);
				$query="select u.nombre_administrador, u.email from $g1 as u, $ts6 as t where t.id_usuario=u.us_id AND t.id_rol_general=24 AND u.estado=1";
				$para_actualiza = query_db($query);//	Profesional de aseguramiento
				$para_actualiza2 = query_db($query);//	Profesional de aseguramiento
				$nombre_aseguramiento=traer_fila_db($para_actualiza);
				$correos="";
				$email_contrato=str_replace('<nombre_aseguramiento>', $nombre_aseguramiento[0], $email_contrato);
				//sent_mail_with_signature(''.$nombre_aseguramiento[1],$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
				//$email_contrato=str_replace('<firma>', $nombre_aseguramiento[0], $email_contrato);
				while ($s_actual = traer_fila_db($para_actualiza2)) {
					//sent_mail_with_signature(''.$s_actual[1],$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Profesional de aseguramiento
					$correos=$correos.$s_actual[1].",,";
				}
				$query="select u.nombre_administrador, u.email from $g1 as u, $ts6 as t where t.id_usuario=u.us_id AND t.id_rol_general=26";
				$para_actualiza = query_db($query);//	Analista de aseguramiento
				while ($s_actual = traer_fila_db($para_actualiza)) {
					//sent_mail_with_signature(''.$s_actual[1],$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A Analista de aseguramiento
					$correos=$correos.$s_actual[1].",,";
				}
				//sent_mail_with_signature(''.$gestor_abastecimiento[1],$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//gestor de abastecimiento
				$correos=$correos.$gestor_abastecimiento[1].",,";
				//sent_mail_with_signature(''.$profesional_abastecimiento[1],$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//profesional de abastecimiento

				$correos=$correos.$profesional_abastecimiento[1].",,";
				//sent_mail_with_signature(''.$correo_gerente[0],$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//gerente nuevo
				$correos=$correos.$correo_gerente[0].",,";
				//sent_mail_with_signature(''.$email_contratista,$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//gerente nuevo
				$correos=$correos.$email_contratista.",,";
				sent_mail_with_signature($correos,$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);
				//sent_mail_with_signature('jeison.rivera@enternova.net',$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);//gerente nuevo
				//sent_mail_with_signature('abastecimiento@hcl.com.co',$asunto_contrato,$email_contrato, $nombre_aseguramiento[1], $nombre_aseguramiento[0]);
				
				//INC010-18 INICIO
				$id_log = log_de_procesos_sgpa(4, 24, 44, $id_contrato_arr, 0, 0);//actualiza general
				
			    log_agrega_detalle ($id_log, "Gerente de Contrato", $nombre_gerente, "",1);
				log_agrega_detalle ($id_log, "Envia Notificación", "Contrato Nuevo", "",1);
				log_agrega_detalle ($id_log, "Informe HSE", $_POST['info_hse'], "",1);
				log_agrega_detalle ($id_log, "Aseguramiento Administrativo", $nombre_aseg[0], "",1);
				//INC010-18 FIN
			}
		/** FIN PARA EL DES-017-17*****/
	
	if($_POST["notifica_email"] == 1){
		$tt_notificacion = "Se Envio Notificación de Cambio de Gerente";
		
	}
	if($_POST["notifica_email"] == 2){
		$tt_notificacion = "Se Envio Notificación de Contrato Nuevo";
		
	}
		?>
		<script>
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Contrato se Grabó con Exito <?=$tt_notificacion?>', 20, 10, 18);
        //alert("El Contrato se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/v_contratos.php?id=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
}




	if($_POST["accion"]=="graba_contrato"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id		
		$id_contratista = elimina_comillas_2($_POST["contratista"]);
		
		
		
		
		$explode = explode("----,",elimina_comillas_2($_POST["gerente"]));
		$id_gerente = $explode[1];
		$nombre_gerente = $explode[0];
		
		$explode = explode("----,",elimina_comillas_2($_POST["especialista"]));
		$id_especialista = $explode[1];
		$nombre_especialista = $explode[0];
		
		//Registro Congelado********************************
		$busca_congelado = "select analista_deloitte,estado, aplica_garantia, garantia_seguro from $co1 where id = $id_contrato_arr";
		$sql_busca_congelado = traer_fila_row(query_db($busca_congelado));
		if($sql_busca_congelado[0]=="NULL" or trim($sql_busca_congelado[0])==""){
			$congelado_actual = 0;
		}else{
			$congelado_actual = $sql_busca_congelado[0];
		}
		
		if($congelado_actual!=elimina_comillas_2($_POST["analista_deloitte"])){
			if(elimina_comillas_2($_POST["analista_deloitte"])==1){
				$inser_registro = "insert into $co11 values (".$id_contrato_arr.",0,".elimina_comillas_2($_POST["analista_deloitte"]).",'".date("Y-m-d")."','".$sql_busca_congelado[1]."')";
				$sql_ex=query_db($inser_registro);
				//echo "si congelado";
			}else{
				if(elimina_comillas_2($_POST["analista_deloitte"])==0){
					$inser_registro = query_db("insert into $co11 values (".$id_contrato_arr.",0,".elimina_comillas_2($_POST["analista_deloitte"]).",'".date("Y-m-d")."','".$sql_busca_congelado[1]."')");
					//echo "no congelado";
				}
			}
		}else{
			//echo "No hubo cambios";
		}
		//Registro Congelado********************************
		
		/*graba fecha si seleccionan retencion en garantia*/
		if($sql_busca_congelado[2] != "SI" and elimina_comillas_2($_POST["retencion_garantia"]) == 1){
			$update = query_db("update t7_relacion_campos_legalizacion_datos set f_ini_garantia_recibo = '".$fecha."' where id_contrato = ".$id_contrato_arr);
			}
			
		$aplica_manejo_especial_de_polizas = "NO";

			if(elimina_comillas_2($_POST["garantia_seguros"]) == 1){
				echo "delete from t7_contratos_poliza_aplica where id_contrato = ".$id_contrato_arr." and id_poliza in (6, 15)";
				$sel_si_tiene = query_db("delete from t7_contratos_poliza_aplica where id_contrato = ".$id_contrato_arr." and id_poliza in (6, 15)");
			}
			
			if($sql_busca_congelado[3]<> elimina_comillas_2($_POST["garantia_seguros"]) and elimina_comillas_2($_POST["garantia_seguros"]) == 2){
				$sel_si_tiene = traer_fila_row(query_db("select count(*) from t7_contratos_poliza_aplica where id_contrato = ".$id_contrato_arr." and id_poliza = 15"));
				if($sel_si_tiene[0] ==0){
				$insert = query_db("insert into t7_contratos_poliza_aplica (id_contrato, id_poliza) values (".$id_contrato_arr.", 15)");
				$sel_si_tiene = query_db("delete from t7_contratos_poliza_aplica where id_contrato = ".$id_contrato_arr." and id_poliza in (6)");
				$aplica_manejo_especial_de_polizas = "SI";
				}
			}
			if($sql_busca_congelado[3]<> elimina_comillas_2($_POST["garantia_seguros"]) and  (elimina_comillas_2($_POST["garantia_seguros"]) == 3 or elimina_comillas_2($_POST["garantia_seguros"]) == 4)){
				$sel_si_tiene = traer_fila_row(query_db("select count(*) from t7_contratos_poliza_aplica where id_contrato = ".$id_contrato_arr." and id_poliza = 6"));
				if($sel_si_tiene[0] ==0){
				$delete_polizas = query_db("delete from t7_contratos_poliza_aplica where id_contrato = ".$id_contrato_arr);
				$insert = query_db("insert into t7_contratos_poliza_aplica (id_contrato, id_poliza) values (".$id_contrato_arr.", 6)");
				$aplica_manejo_especial_de_polizas = "SI";
				}
			}
		//VALIDACION PARA EL DESARROLO DE DESEMPENO
			if($_POST["tipo_servicio"]==0){
				?><script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione el tipo de servicio', 40, 5, 12);
				window.parent.document.getElementById("tipo_servicio").className = "select_faltantes"
				</script>
				<?
				exit();
			}
		//FIN VALIDACION PARA EL DESARROLO DE DESEMPENO
		$email1="";
		$email2="";
		$email = elimina_comillas_2($_POST["email1"]);
		$email = str_replace("&#64;", "@",$email);
		if($email <> ""){
			$verifica_email = comprobar_email($email);
			if($verifica_email=="0"){				
			?><script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el Campo Email Contacto Principal', 40, 5, 12);
			//alert("Verifique el e-mail")</script>
			<script>//window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
			<?
			exit();
			}else{
				if(preg_match("/;/i", $email)){
					?><script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el Campo Email Contacto Principal*El campo no puede llevar caracteres especiales como (;,/:+[]^^{}¡?¿!|°)', 40, 5, 12);
					//alert("Verifique el e-mail")</script>
					<script>//window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
					<?
					exit();
				}elseif(preg_match("/,/i", $email)){
					?><script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el Campo Email Contacto Principal*El campo no puede llevar caracteres especiales como (;,/:+[]^^{}¡?¿!|°)', 40, 5, 12);
					//alert("Verifique el e-mail")</script>
					<script>//window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
					<?
					exit();
				}elseif(preg_match("/(/i", $email)){
					?><script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el Campo Email Contacto Principal*El campo no puede llevar caracteres especiales como (;,/:+[]^^{}¡?¿!|°)', 40, 5, 12);
					//alert("Verifique el e-mail")</script>
					<script>//window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
					<?
					exit();
				}
				$email1=$email = str_replace(";", "",$email);
				$email1=$email = str_replace(",", "",$email1);
				$email1=$email = str_replace("(", "",$email1);
				$email1=$email = str_replace(")", "",$email1);
			}
		}
		$email = elimina_comillas_2($_POST["email2"]);
		$email = str_replace("&#64;", "@",$email);
		if($email <> ""){
			$verifica_email = comprobar_email($email);
			if($verifica_email=="0"){
			?><script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el Campo Email Representante Legal', 40, 5, 12);
			//alert("Verifique el e-mail")</script>
			<script>//window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
			<?
			exit();
			}else{
				if(preg_match("/;/i", $email)){
					?><script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el Campo Email Representante Legal*El campo no puede llevar caracteres especiales como (;,/:+[]^^{}¡?¿!|°)', 40, 5, 12);
					//alert("Verifique el e-mail")</script>
					<script>//window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
					<?
					exit();
				}elseif(preg_match("/,/i", $email)){
					?><script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el Campo Email Representante Legal*El campo no puede llevar caracteres especiales como (;,/:+[]^^{}¡?¿!|°)', 40, 5, 12);
					//alert("Verifique el e-mail")</script>
					<script>//window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
					<?
					exit();
				}elseif(preg_match("/(/i", $email)){
					?><script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el Campo Email Representante Legal*El campo no puede llevar caracteres especiales como (;,/:+[]^^{}¡?¿!|°)', 40, 5, 12);
					//alert("Verifique el e-mail")</script>
					<script>//window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
					<?
					exit();
				}
				$email2=$email = str_replace(";", "",$email);
				$email2=$email = str_replace(",", "",$email2);
				$email2=$email = str_replace("(", "",$email2);
				$email2=$email = str_replace(")", "",$email2);
			}
		}
		
		$update_sql = "update $co1 set objeto = '".elimina_comillas_2($_POST["objeto"])."',nit = '".elimina_comillas_2($_POST["nit"])."',contratista = '".$id_contratista."',contacto_principal = '".elimina_comillas_2($_POST["contacto_principal"])."',email1 = '".$email1."',telefono1 = '".elimina_comillas_2($_POST["telefono1"])."',gerente = '".$id_gerente."',fecha_inicio = '".elimina_comillas_2($_POST["fecha_inicio"])."',vigencia_mes = '".elimina_comillas_2($_POST["fecha_fin"])."',aplica_acta_inicio = '".elimina_comillas_2($_POST["aplica_acta_inicio"])."',representante_legal = '".elimina_comillas_2($_POST["representante_legal"])."',email2 = '".$email2."',telefono2 = '".elimina_comillas_2($_POST["telefono2"])."',especialista = '".$id_especialista."',monto_usd = '".elimina_comillas_2(valida_numero_db($_POST["monto_usd"]))."',monto_cop = '".elimina_comillas_2(valida_numero_db($_POST["monto_cop"]))."',ok_fecha=1,analista_deloitte = '".elimina_comillas_2($_POST["analista_deloitte"])."',area_ejecucion='".elimina_comillas_2($_POST["area_ejecucion"])."',obs_congelado='".elimina_comillas_2($_POST["obs_congelado"])."',aplica_portales='".elimina_comillas_2($_POST["aplica_portales"])."',destino ='".elimina_comillas_2($_POST["destino"])."',aseguramiento_admin ='".elimina_comillas_2($_POST["aseguramiento_admin"])."', aplica_garantia='".elimina_comillas_2($_POST["retencion_garantia"])."', porcentaje='".elimina_comillas_2($_POST["porcen_garantia"])."', en_que_momento='".elimina_comillas_2($_POST["parcial_final_garantia"])."', informe_hse = '".elimina_comillas_2($_POST["info_hse"])."', garantia_seguro = '".elimina_comillas_2($_POST["garantia_seguros"])."', tipo_servicio='".$_POST["tipo_servicio"]."' where id = ".$id_contrato_arr;
		$sql_ex=query_db($update_sql);
		
		
		
		if(elimina_comillas_2($_POST["fecha_inicio"]) != elimina_comillas_2($_POST["fecha_inicio_antes_de_modificacion"])){//actualiza la fecha de inicio de las tarifas contractuales
			$sel_id_contrato_tarifas = traer_fila_row(query_db("SELECT tarifas_contrato_id FROM t6_tarifas_contratos WHERE (id_contrato = ".$id_contrato_arr.")"));
			$update_tarifas = query_db("update t6_tarifas_lista set fecha_inicio_vigencia = '".elimina_comillas_2($_POST["fecha_inicio"])."' where  (tarifas_contrato_id = ".$sel_id_contrato_tarifas[0].") and tipo_creacion_modifica = 1 and creada_luego_firme = 1 and tipo_creacion = 1");
			
			}
		
		//Inicio Poliza Aplica
		
	if($aplica_manejo_especial_de_polizas == "NO"){
		$delete_sql = "delete from $co2 where id_contrato = $id_contrato_arr";
		$sql_ex=query_db($delete_sql);
		
		foreach($_POST["poliza_aplica"] as $poliza){
			$insert_sql = "insert into $co2 values ($id_contrato_arr,".elimina_comillas_2($poliza).")";
			$sql_ex=query_db($insert_sql );
		}
		
		$array_pol_tex = "";
		$coma = "";
		$sql_lis_pol=query_db("select t1t.nombre from $co2 t7c left join $g7 t1t on t1t.id = t7c.id_poliza where id_contrato =".$id_contrato_arr);
		while($lista_poliza_int_tec=traer_fila_row($sql_lis_pol)){
			if($array_pol_tex!="")
				$coma = ",";
			$array_pol_tex = $array_pol_tex.$coma.$lista_poliza_int_tec[0];
		}
	}
		//Fin Poliza Aplica

		$id_log = log_de_procesos_sgpa(4, 24, 44, $id_contrato_arr, 0, 0);//actualiza general
		log_agrega_detalle ($id_log, "Objeto", elimina_comillas_2($_POST["objeto"]), "",1);
		$text_congelado = "NO";
		if($_POST["analista_deloitte"]==1){
			$text_congelado = "SI";
			log_agrega_detalle ($id_log, "Observaciones Congelado",elimina_comillas_2($_POST["obs_congelado"]) , "",3);
		}
		log_agrega_detalle ($id_log, "Congelado",$text_congelado , "",2);
		log_agrega_detalle ($id_log, "Contacto Principal",elimina_comillas_2($_POST["contacto_principal"]) , "",4);
		log_agrega_detalle ($id_log, "Email",elimina_comillas_2($_POST["email1"]) , "",5);
		log_agrega_detalle ($id_log, "Telefono",elimina_comillas_2($_POST["telefono1"]) , "",6);
		log_agrega_detalle ($id_log, "Representante Legal",elimina_comillas_2($_POST["representante_legal"]) , "",7);
		log_agrega_detalle ($id_log, "Email",elimina_comillas_2($_POST["email2"]) , "",8);
		log_agrega_detalle ($id_log, "Telefono",elimina_comillas_2($_POST["telefono2"]) , "",9);
		log_agrega_detalle ($id_log, "Gerente",$nombre_gerente , "",10);
		log_agrega_detalle ($id_log, "Especialista",$nombre_especialista , "",11);
		log_agrega_detalle ($id_log, "Fecha Inicio",elimina_comillas_2($_POST["fecha_inicio"]) , "",12);
		log_agrega_detalle ($id_log, "Fecha Fin",elimina_comillas_2($_POST["fecha_fin"]), "",13);
		log_agrega_detalle ($id_log, "Area Ejecucion",elimina_comillas_2($_POST["area_ejecucion"]), $g24,14);
		$text_aplica_acta = "";
		if($_POST["aplica_acta_inicio"]==1){
			$text_aplica_acta = "SI";
		}
		log_agrega_detalle ($id_log, "Aplica Acta Inicio",$text_aplica_acta, "",15);
		log_agrega_detalle ($id_log, "Polizas Aplicables",$array_pol_tex, "",16);
		
		?>
		<script> 
        //alert("El Contrato se Grabó con Exito")
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Contrato se Grabó con Exito', 20, 10, 18);
		window.parent.ajax_carga('../aplicaciones/contratos/v_contratos.php?id=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}

	if($_POST["accion"]=="graba_fecha"){
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		
		$busca_contrato = "select id_item from $co1 where id = $id_contrato_arr";
		$sql_con=traer_fila_row(query_db($busca_contrato));
		
		$id_item = $sql_con[0];
		$id_contrato = $id_contrato_arr;
		
		//Fecha Entrega abastecimiento
		$busca_contrato_esta = "select estado from $co1 where id = ".$id_contrato;
		$sql_con_esta=traer_fila_row(query_db($busca_contrato_esta));
		$estado_contrato_actual = $sql_con_esta[0];

		$fecha_real_e_abas = trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]));
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="recibido_abastecimiento" and $fecha_real_e_abas !="" and $estado_contrato_actual == $est_creacion){
			
			$actividad=20;
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real_e_abas);		
			
//			$update_sql = "update $co1 set estado = $est_abastecimiento  where id = ".$id_contrato;
			$update_sql = "update $co1 set estado = 15  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
			
		}
		//Fecha Entrega abastecimiento
				
		$fecha_real = trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]));
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="recibido_abastecimiento" and $fecha_real !=""){
			
			$actividad=21;
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co1 set estado = $est_sap  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
			
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="sap" and $fecha_real !=""){
			

			$actividad=22;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co1 set estado = $est_revision  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="revision_legal" and $fecha_real !=""){
			

			$actividad=23;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co1 set estado = $est_firma_hocol   where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="firma_hocol" and $fecha_real !=""){
			

			$actividad=24;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co1 set estado = $est_firma_contratista  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="firma_contratista" and $fecha_real !=""){
			

			$actividad=25;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co1 set estado = $est_poliza  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="revision_poliza" and $fecha_real !=""){
			

			$actividad=26;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co1 set estado = $est_gerente_contrato  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="legalizacion_final_par" and $fecha_real !=""){	//gerente contrato
			
					
			$actividad=27;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co1 set estado = $est_legalizacion  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
					
			
		}//gerente contrato
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="legalizacion_final" and $fecha_real !=""){
						
			$update_sql = "update $co1 set estado = $est_finalizado  where id = ".$id_contrato;		
			$sql_ex=query_db($update_sql);
			
			$actividad=28;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);

			
			$actividad=29;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			envia_email_contrato_legalizacion($id_contrato_arr,0);
			
		}
		
		
		
		
		/*
		if(elimina_comillas_2($_POST["campo_fecha"])=="recibido_abastecimiento"){
			$update_sql = "update $co1 set ".elimina_comillas_2($_POST["campo_fecha"])." = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]))."'  where id = ".$id_contrato_arr;
		}else{
			$update_sql = "update $co1 set ".elimina_comillas_2($_POST["campo_fecha"])." = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]))."' ,".elimina_comillas_2($_POST["campo_fecha"])."_e = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))."'   where id = ".$id_contrato_arr;
		}
		*/
		$update_sql = "update $co1 set ".elimina_comillas_2($_POST["campo_fecha"])." = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]))."' ,".elimina_comillas_2($_POST["campo_fecha"])."_e = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))."'   where id = ".$id_contrato_arr;
		$sql_ex=query_db($update_sql);
		
		$insert_sql_ob = "insert into $co8 (id_contrato,id_complemento,campo,observacion,estado)values(".$id_contrato_arr.",0,'".elimina_comillas_2($_POST["campo_fecha"])."','".elimina_comillas_2($_POST[$_POST["campo_fecha"]."_obs"])."',1)";
		$sql_ex=query_db($insert_sql_ob);
		$si_var_com = 0;
		if(elimina_comillas_2($_POST["campo_fecha"])=="firma_hocol" && trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))!=""){
			if($_POST["sel_representante"]==1){
				$si_var_com = 1;
				$update_sql = "update $co1 set acta_socios ='".$_POST["acta_socios"]."' ,recibido_poliza='".$_POST["recibido_poliza"]."',camara_comercio='".$_POST["camara_comercio"]."',aplica_acta='".$_POST["aplica_acta"]."',recibo_poliza='".$_POST["recibo_poliza"]."' ,sel_representante='".$_POST["sel_representante"]."'  where id = ".$id_contrato_arr;		
				$sql_ex=query_db($update_sql);	
			}else{
				$update_sql = "update $co1 set sel_representante='".$_POST["sel_representante"]."'  where id = ".$id_contrato_arr;	
				$sql_ex=query_db($update_sql);	
			}
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="firma_contratista" && trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))!=""){
			if($_POST["sel_representante"]==2){
				$si_var_com = 1;
				$update_sql = "update $co1 set acta_socios ='".$_POST["acta_socios"]."' ,recibido_poliza='".$_POST["recibido_poliza"]."',camara_comercio='".$_POST["camara_comercio"]."',aplica_acta='".$_POST["aplica_acta"]."',recibo_poliza='".$_POST["recibo_poliza"]."',sel_representante='".$_POST["sel_representante"]."'  where id = ".$id_contrato_arr;	
				$sql_ex=query_db($update_sql);	
			}
		}
		//INicio Log fechas*********************************************
		$campo_graba_fecha = str_replace("_"," ",elimina_comillas_2($_POST["campo_fecha"]));
		$campo_graba_fecha = ucwords($campo_graba_fecha);
		$id_log = log_de_procesos_sgpa(4, 24, 58, $id_contrato_arr, 0, 0);//Crea general
		if($si_var_com ==1 and (elimina_comillas_2($_POST["campo_fecha"])=="firma_contratista" or elimina_comillas_2($_POST["campo_fecha"])=="firma_hocol")){
			log_agrega_detalle ($id_log, "Registro Fechas","Firma Contratista","",1);
		}else{
			if($si_var_com ==0 and (elimina_comillas_2($_POST["campo_fecha"])=="firma_contratista" or elimina_comillas_2($_POST["campo_fecha"])=="firma_hocol")){
			log_agrega_detalle ($id_log, "Registro Fechas","Firma Hocol","",1);
			}else{
				if(elimina_comillas_2($_POST["campo_fecha"])=="legalizacion_final_par"){
					log_agrega_detalle ($id_log, "Registro Fechas","Gerente Contrato","",1);
				}else{
					if(elimina_comillas_2($_POST["campo_fecha"])=="legalizacion_final"){
						log_agrega_detalle ($id_log, "Registro Fechas","Legalizacion Final Contrato","",1);
					}else{
						log_agrega_detalle ($id_log, "Registro Fechas",$campo_graba_fecha,"",1);
					}
				}
			}
		}
		
		log_agrega_detalle ($id_log, $campo_graba_fecha." Entrega",trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"])),"",1);
		log_agrega_detalle ($id_log, $campo_graba_fecha,trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]])),"",1);		
		if($si_var_com ==1){
			$text1="";
			if($_POST["aplica_acta"]==1) $text1="SI";				
			if($_POST["aplica_acta"]==2) $text1="NO";				
			log_agrega_detalle ($id_log, "Aplica Acta Socios",$text1,"",1);
			if($_POST["aplica_acta"]==1){
				$text2="";
				if($_POST["acta_socios"]==1) $text2="SI";	
				log_agrega_detalle ($id_log, "Acta Socios",$text2,"",1);
			}
			$text3="";
			if($_POST["recibido_poliza"]==1) $text3="SI";	
			log_agrega_detalle ($id_log, "Recibido Polizas",$text3,"",1);
			$text4="";
			if($_POST["camara_comercio"]==1) $text4="SI";	
			log_agrega_detalle ($id_log, "Camara y Comercio",$text4,"",1);
			$text5="";
			if($_POST["recibo_poliza"]==1) $text5="SI";	
			log_agrega_detalle ($id_log, "Recibo de Polizas",$text5,"",1);
		}
		log_agrega_detalle ($id_log, "Observaciones",elimina_comillas_2($_POST[$_POST["campo_fecha"]."_obs"]),"",1);
		//Fin Log fechas*********************************************
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La fecha se Grabó con Exito', 20, 10, 18);
        //alert("La fecha se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/v_contratos.php?id=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_fecha_co"){
		$id_complemento_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_complemento"]));//recibe id
		$id_contrato = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_contrato_real = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		
		$busca_contrato = "select id_item_pecc,tipo_complemento,numero_otrosi from $co4 where id = $id_complemento_arr";
		$sql_con=traer_fila_row(query_db($busca_contrato));
		
		$id_item = $sql_con[0];
		$id_contrato = $id_complemento_arr;
		$tipo_complemento_sql = $sql_con[1]; 
		$numero_otrosi_sql = $sql_con[2]; 
		//Fecha Entrega abastecimiento
		$busca_contrato_esta = "select estado from $co4 where id = ".$id_contrato;
		$sql_con_esta=traer_fila_row(query_db($busca_contrato_esta));
		$estado_contrato_actual = $sql_con_esta[0];

		$fecha_real_e_abas = trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]));
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="recibido_abastecimiento" and $fecha_real_e_abas !="" and $estado_contrato_actual == $est_creacion){
			
			$actividad=20;
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real_e_abas);		
			
			$update_sql = "update $co4 set estado = 15  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
			
		}
		//Fecha Entrega abastecimiento
		
		$fecha_real = trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]));
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="recibido_abastecimiento" and $fecha_real !=""){
		
			$actividad=21;
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co4 set estado = $est_sap  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		if(elimina_comillas_2($_POST["campo_fecha"])=="sap" and $fecha_real !=""){
			
			$actividad=22;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co4 set estado = $est_revision  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);

		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="revision_legal" and $fecha_real !=""){
			

			$actividad=23;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co4 set estado = $est_firma_hocol   where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="firma_hocol" and $fecha_real !=""){
			

			$actividad=24;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co4 set estado = $est_firma_contratista  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="firma_contratista" and $fecha_real !=""){
			

			$actividad=25;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co4 set estado = $est_poliza  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="revision_poliza" and $fecha_real !=""){
			

			$actividad=26;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			$update_sql = "update $co4 set estado = $est_gerente_contrato  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="legalizacion_final_par" and $fecha_real !=""){	// gerente contrato
			
			$actividad=27;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);

			$update_sql = "update $co4 set estado = $est_legalizacion  where id = ".$id_contrato;
			$sql_ex=query_db($update_sql);
			
					
			
		}// gerente contrato
		if(elimina_comillas_2($_POST["campo_fecha"])=="legalizacion_final" and $fecha_real !=""){
			
			$update_sql = "update $co4 set estado = $est_finalizado  where id = ".$id_contrato;		
			$sql_ex=query_db($update_sql);
			
			$actividad=28;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);	
			$actividad=29;			
			agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real);
			
			envia_email_contrato_legalizacion($id_contrato_real,$id_complemento_arr);
						
		}
		
		
		
		/*
		$id_contrato = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		if(elimina_comillas_2($_POST["campo_fecha"])=="recibido_abastecimiento"){
			$update_sql = "update $co4 set ".elimina_comillas_2($_POST["campo_fecha"])." = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]))."'    where id = ".$id_complemento_arr;
		}else{
			$update_sql = "update $co4 set ".elimina_comillas_2($_POST["campo_fecha"])." = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]))."' ,".elimina_comillas_2($_POST["campo_fecha"])."_e = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))."'   where id = ".$id_complemento_arr;
		}
		*/
		$update_sql = "update $co4 set ".elimina_comillas_2($_POST["campo_fecha"])." = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]))."' ,".elimina_comillas_2($_POST["campo_fecha"])."_e = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))."'   where id = ".$id_complemento_arr;
		$sql_ex=query_db($update_sql);	
		
		$insert_sql_ob = "insert into $co8 (id_contrato,id_complemento,campo,observacion,estado)values(".$id_contrato_real.",".$id_complemento_arr.",'".elimina_comillas_2($_POST["campo_fecha"])."','".elimina_comillas_2($_POST[$_POST["campo_fecha"]."_obs"])."',1)";
		$sql_ex=query_db($insert_sql_ob);
		$si_var_com = 0;
		if(elimina_comillas_2($_POST["campo_fecha"])=="firma_hocol" && trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))!=""){
			if($_POST["sel_representante"]==1){
				$si_var_com = 1;
				$update_sql = "update $co4 set acta_socios ='".$_POST["acta_socios"]."' ,recibido_poliza='".$_POST["recibido_poliza"]."',camara_comercio='".$_POST["camara_comercio"]."',sel_representante='".$_POST["sel_representante"]."',aplica_acta='".$_POST["aplica_acta"]."',recibo_poliza='".$_POST["recibo_poliza"]."'  where id = ".$id_complemento_arr;
				$sql_ex=query_db($update_sql);	
			}else{
				$update_sql = "update $co4 set sel_representante='".$_POST["sel_representante"]."'  where  id = ".$id_complemento_arr;
				$sql_ex=query_db($update_sql);	
			}
		}
		
		if(elimina_comillas_2($_POST["campo_fecha"])=="firma_contratista" && trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))!=""){
			if($_POST["sel_representante"]==2){
				$si_var_com = 1;
				$update_sql = "update $co4 set acta_socios ='".$_POST["acta_socios"]."' ,recibido_poliza='".$_POST["recibido_poliza"]."',camara_comercio='".$_POST["camara_comercio"]."',aplica_acta='".$_POST["aplica_acta"]."',recibo_poliza='".$_POST["recibo_poliza"]."',sel_representante='".$_POST["sel_representante"]."'  where  id = ".$id_complemento_arr;
				$sql_ex=query_db($update_sql);	
			}
		}

		//INicio Log fechas*********************************************
		$campo_graba_fecha = str_replace("_"," ",elimina_comillas_2($_POST["campo_fecha"]));
		$campo_graba_fecha = ucwords($campo_graba_fecha);
		$id_log = log_de_procesos_sgpa(4, 30, 59, $id_contrato_real, 0, 0);//Crea general
		if($tipo_complemento_sql==1)
			log_agrega_detalle ($id_log, "Numero OtroSI",$numero_otrosi_sql,"",1);
		if($tipo_complemento_sql==2)
			log_agrega_detalle ($id_log, "Orden de Trabajo",$numero_otrosi_sql,"",1);
			
		if($si_var_com ==1 and (elimina_comillas_2($_POST["campo_fecha"])=="firma_contratista" or elimina_comillas_2($_POST["campo_fecha"])=="firma_hocol")){
			log_agrega_detalle ($id_log, "Registro Fechas","Firma Contratista","",1);
		}else{
			if($si_var_com ==0 and (elimina_comillas_2($_POST["campo_fecha"])=="firma_contratista" or elimina_comillas_2($_POST["campo_fecha"])=="firma_hocol")){
			log_agrega_detalle ($id_log, "Registro Fechas","Firma Hocol","",1);
			}else{
				if(elimina_comillas_2($_POST["campo_fecha"])=="legalizacion_final_par"){
					log_agrega_detalle ($id_log, "Registro Fechas","Gerente Contrato","",1);
				}else{
					if(elimina_comillas_2($_POST["campo_fecha"])=="legalizacion_final"){
						log_agrega_detalle ($id_log, "Registro Fechas","Legalizacion Final Contrato","",1);
					}else{
						log_agrega_detalle ($id_log, "Registro Fechas",$campo_graba_fecha,"",1);
					}
				}
			}
		}
		
		log_agrega_detalle ($id_log, $campo_graba_fecha." Entrega",trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"])),"",1);
		log_agrega_detalle ($id_log, $campo_graba_fecha,trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]])),"",1);		
		if($si_var_com ==1){
			$text1="";
			if($_POST["aplica_acta"]==1) $text1="SI";				
			if($_POST["aplica_acta"]==2) $text1="NO";				
			log_agrega_detalle ($id_log, "Aplica Acta Socios",$text1,"",1);
			if($_POST["aplica_acta"]==1){
				$text2="";
				if($_POST["acta_socios"]==1) $text2="SI";	
				log_agrega_detalle ($id_log, "Acta Socios",$text2,"",1);
			}
			$text3="";
			if($_POST["recibido_poliza"]==1) $text3="SI";	
			log_agrega_detalle ($id_log, "Recibido Polizas",$text3,"",1);
			$text4="";
			if($_POST["camara_comercio"]==1) $text4="SI";	
			log_agrega_detalle ($id_log, "Camara y Comercio",$text4,"",1);
			$text5="";
			if($_POST["recibo_poliza"]==1) $text5="SI";	
			log_agrega_detalle ($id_log, "Recibo de Polizas",$text5,"",1);
		}
		log_agrega_detalle ($id_log, "Observaciones",elimina_comillas_2($_POST[$_POST["campo_fecha"]."_obs"]),"",1);
		//Fin Log fechas*********************************************
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La fecha se Grabó con Exito', 20, 10, 18);
        //alert("La fecha se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_complemento.php?id=<?=$_POST["id_contrato_arr_envia"];?>&id_complemento=<?=$_POST["id_complemento"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	
	if($_POST["accion"]=="graba_poliza_nueva"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$update_sql = "insert into $co3 (id_contrato,tipo_poliza,tipo_moneda,valor,fecha_inicio,fecha_fin,aseguradora,estado,tipo_aseguradora,numero_modificacion)values(".$id_contrato_arr.",'".elimina_comillas_2($_POST["tipo_poliza"])."','".elimina_comillas_2($_POST["tipo_moneda"])."','".elimina_comillas_2(valida_numero_db($_POST["valor"]))."','".elimina_comillas_2($_POST["fecha_inicio"])."','".elimina_comillas_2($_POST["fecha_fin"])."','".elimina_comillas_2($_POST["aseguradora"])."',1,'".elimina_comillas_2($_POST["tipo_aseguradora"])."','".elimina_comillas_2($_POST["numero_modificacion"])."')";
		$sql_ex=query_db($update_sql);
		
		//inicio identifica si tiene todas las polizas
	  	$count_poliza_llena = traer_fila_row(query_db("select count(distinct(tipo_poliza)) from $co3 where id_contrato = $id_contrato_arr"));

	  	$count_poliza_aplica = traer_fila_row(query_db("select count(distinct(id_poliza)) from $co2 where id_contrato = $id_contrato_arr and id_poliza <> 6"));
		$ok_poliza = 0;
		//echo $count_poliza_llena[0]." ".$count_poliza_aplica[0];
	  	if($count_poliza_llena[0] >=$count_poliza_aplica[0]){
			$count_poliza_llena = traer_fila_row(query_db("select count(tipo_poliza) from $co3 where id_contrato = $id_contrato_arr"));			
			$count_poliza_aplica = traer_fila_row(query_db("select count(distinct(id_poliza)) from $co2 where id_contrato = $id_contrato_arr and id_poliza <> 6"));
				//echo $count_poliza_llena[0]." ".$count_poliza_aplica[0];
				if($count_poliza_llena[0] == $count_poliza_aplica[0]){			
				 	envia_email_polizas_completas($_POST["id_contrato_arr_envia"]);
				}
		}
		
		//fin identifica si tiene todas las polizas
		
		$id_log = log_de_procesos_sgpa(4, 25, 45, $id_contrato_arr, 0, 0);//Crea general
		log_agrega_detalle ($id_log, "Tipo Poliza", elimina_comillas_2($_POST["tipo_poliza"]), $g7,1);
		log_agrega_detalle ($id_log, "Numero Modificacion", elimina_comillas_2($_POST["numero_modificacion"]), $co4,2);
		log_agrega_detalle ($id_log, "Tipo Moneda", elimina_comillas_2($_POST["tipo_moneda"]), $g5,3);
		log_agrega_detalle ($id_log, "Valor Asegurado", elimina_comillas_2($_POST["valor"]), "",4);
		log_agrega_detalle ($id_log, "Fecha Inicio", elimina_comillas_2($_POST["fecha_inicio"]), "",5);
		log_agrega_detalle ($id_log, "Fecha Fin", elimina_comillas_2($_POST["fecha_fin"]), "",6);
		log_agrega_detalle ($id_log, "Aseguradora", elimina_comillas_2($_POST["tipo_aseguradora"]), $g23,7);
		if($_POST["tipo_aseguradora"]==5){
		log_agrega_detalle ($id_log, "Otra Aseguradora", elimina_comillas_2($_POST["aseguradora"]), "",8);
		}
		
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Poliza se Grabó con Exito', 20, 10, 18);
        //alert("La Poliza se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_poliza.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_poliza_edita"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_poliza_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_poliza"]));//recibe id_pokliza
		
		$update_sql = "update $co3 set tipo_poliza='".elimina_comillas_2($_POST["tipo_poliza"])."',tipo_moneda='".elimina_comillas_2($_POST["tipo_moneda"])."',valor='".elimina_comillas_2(valida_numero_db($_POST["valor"]))."',fecha_inicio='".elimina_comillas_2($_POST["fecha_inicio"])."',fecha_fin='".elimina_comillas_2($_POST["fecha_fin"])."',aseguradora='".elimina_comillas_2($_POST["aseguradora"])."',tipo_aseguradora='".elimina_comillas_2($_POST["tipo_aseguradora"])."',numero_modificacion='".elimina_comillas_2($_POST["numero_modificacion"])."' where id = $id_poliza_arr";
		$sql_ex=query_db($update_sql);
		
		$id_log = log_de_procesos_sgpa(4, 26, 46, $id_contrato_arr, 0, 0);//actualiza general
		log_agrega_detalle ($id_log, "Tipo Poliza", elimina_comillas_2($_POST["tipo_poliza"]), $g7,1);
		log_agrega_detalle ($id_log, "Numero Modificacion", elimina_comillas_2($_POST["numero_modificacion"]), $co4,2);
		log_agrega_detalle ($id_log, "Tipo Moneda", elimina_comillas_2($_POST["tipo_moneda"]), $g5,3);
		log_agrega_detalle ($id_log, "Valor Asegurado", elimina_comillas_2($_POST["valor"]), "",4);
		log_agrega_detalle ($id_log, "Fecha Inicio", elimina_comillas_2($_POST["fecha_inicio"]), "",5);
		log_agrega_detalle ($id_log, "Fecha Fin", elimina_comillas_2($_POST["fecha_fin"]), "",6);
		log_agrega_detalle ($id_log, "Aseguradora", elimina_comillas_2($_POST["tipo_aseguradora"]), $g23,7);
		if($_POST["tipo_aseguradora"]==5){
		log_agrega_detalle ($id_log, "Otra Aseguradora", elimina_comillas_2($_POST["aseguradora"]), "",8);
		}
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Poliza se Grabó con Exito', 20, 10, 18);
        //alert("La Poliza se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_poliza.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="eliminar_poliza"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_poliza_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_poliza"]));//recibe id_pokliza
		
		$update_sql = "update $co3 set estado=2 where id = $id_poliza_arr";
		$sql_ex=query_db($update_sql);
		
		$sel_poliza = "select tipo_poliza,numero_modificacion,tipo_moneda,valor,fecha_inicio,fecha_fin,tipo_aseguradora,aseguradora from $co3 where id = $id_poliza_arr";
		$sel_poliza_text=traer_fila_row(query_db($sel_poliza));
		
		$id_log = log_de_procesos_sgpa(4, 27, 47, $id_contrato_arr, 0, 0);//Elimina general
		log_agrega_detalle ($id_log, "Tipo Poliza",$sel_poliza_text[0], $g7,1);
		log_agrega_detalle ($id_log, "Numero Modificacion", $sel_poliza_text[1], $co4,2);
		log_agrega_detalle ($id_log, "Tipo Moneda", $sel_poliza_text[2], $g5,3);
		log_agrega_detalle ($id_log, "Valor Asegurado", $sel_poliza_text[3], "",4);
		log_agrega_detalle ($id_log, "Fecha Inicio", $sel_poliza_text[4], "",5);
		log_agrega_detalle ($id_log, "Fecha Fin", $sel_poliza_text[5], "",6);
		log_agrega_detalle ($id_log, "Aseguradora", $sel_poliza_text[6], $g23,7);
		if($sel_poliza_text[6]==5){
		log_agrega_detalle ($id_log, "Otra Aseguradora", $sel_poliza_text[7], "",8);
		}
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Poliza se Elimino con Exito', 20, 10, 18);
        //alert("La Poliza se Elimino con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_poliza.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_poliza_observacion"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$update_sql = "insert into $co5 (id_contrato,fecha_observacion,observacion,estado)values(".$id_contrato_arr.",'".date("Y-m-d")."','".elimina_comillas_2($_POST["observaciones"])."',1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);
		$id_ingreso_e = id_insert($sql_ex);
				
		envia_email_polizas_observacion($_POST["id_contrato_arr_envia"],$id_ingreso_e);
		
		$id_log = log_de_procesos_sgpa(4, 28, 48, $id_contrato_arr, 0, 0);//graba general
		log_agrega_detalle ($id_log, "Fecha Observacion",date("Y-m-d"), "",1);
		log_agrega_detalle ($id_log, "Observacion",elimina_comillas_2($_POST["observaciones"]), "",2);
		
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Observacion de la Poliza se Grabó con Exito', 20, 10, 18);
        //alert("La Observacion de la Poliza se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_poliza.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_complemento_nueva"){
		
		$explode = explode("----,",elimina_comillas_2($_POST["gerente"]));
		$id_gerente = $explode[1];
		$nombre_gerente = $explode[0];
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$numero_otrosi = 0;
		if(elimina_comillas_2($_POST["tipo_complemento"])==1){
			$numero_otro_si = "select MAX(numero_otrosi) from $co4 where id_contrato=".$id_contrato_arr." and tipo_complemento = 1";
			$sql_con=traer_fila_row(query_db($numero_otro_si));
			$numero_otrosi = ($sql_con[0]*1)+1;
			
			if(elimina_comillas_2($_POST["tipo_otrosi"])==8){
				$update_sql = "update $co1 set gerente = ".$id_gerente." where id = ".$id_contrato_arr;
				$sql_ex=query_db($update_sql);			
			}
		}
		
		if(elimina_comillas_2($_POST["tipo_complemento"])==2){
			$numero_otro_si = "select MAX(numero_otrosi) from $co4 where id_contrato=".$id_contrato_arr." and tipo_complemento = 2";
			$sql_con=traer_fila_row(query_db($numero_otro_si));
			$numero_otrosi = ($sql_con[0]*1)+1;
		}
		//Inicio temporar mientras el numero otro si puede ser manual
		$numero_otrosi = elimina_comillas_2(valida_numero_db($_POST["numero_modificacion"]));
		//Fin temporar mientras el numero otro si puede ser manual
		
		if(elimina_comillas_2($_POST["valor"])<>""){
			$valor=elimina_comillas_2(valida_numero_db($_POST["valor"]));
		}else{
			$valor=0;
			}
		if(elimina_comillas_2($_POST["valor2"])<>""){
			$valor2=elimina_comillas_2(valida_numero_db($_POST["valor2"]));
		}else{
			$valor2=0;
			}
			
		if($_POST["tipo_complemento"]==1){
			$tiempo = elimina_comillas_2($_POST["tiempo"]);
		}else{
			$tiempo = elimina_comillas_2($_POST["fecha_fin"]);
		}
		
		
				$estado = 15;
	
		
	   if(elimina_comillas_2($_POST["tipo_otrosi"])==14){
				$update_sql = "update $co1 set gerente = ".$id_gerente." where id = ".$id_contrato_arr;
				$sql_ex=query_db($update_sql);			
			}
		
		
		
		$update_sql = "insert into $co4 (id_contrato,tipo_complemento,tipo_otrosi,gerente,alcance,tiempo,tipo_moneda,valor,clausula,
estado,creacion_sistema,numero_otrosi,observaciones,fecha_inicio,valor_cop,eliminado,congelado,obs_congelado,recibido_abastecimiento, recibido_abastecimiento_e, creacion_por_gestor)values(".$id_contrato_arr.",'".elimina_comillas_2($_POST["tipo_complemento"])."','".elimina_comillas_2($_POST["tipo_otrosi"])."','".$id_gerente."','".elimina_comillas_2($_POST["alcance"])."','".$tiempo."','".elimina_comillas_2($_POST["tipo_moneda"])."','".$valor."','".elimina_comillas_2($_POST["clausula"])."',".$estado.",'". date("Y-m-d")."','".$numero_otrosi."','".elimina_comillas_2($_POST["observaciones"])."','".elimina_comillas_2($_POST["fecha_inicio"])."','".$valor2."',0,'".elimina_comillas_2($_POST["congelado"])."','".elimina_comillas_2($_POST["obs_congelado"])."', '". date("Y-m-d")."', '". date("Y-m-d")."', 1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);
		$id_ingreso = id_insert($sql_ex);

	if($_POST["sol_aprobacion"] != "" and $_POST["sol_aprobacion"] != 0){		
	
		$upda = query_db("update $co4 set id_item_pecc = ".$_POST["sol_aprobacion"]." where id = ".$id_ingreso);
		}


		//Registro Congelado********************************
		$congelado_actual = 0;
		if($congelado_actual!=elimina_comillas_2($_POST["congelado"])){
			if(elimina_comillas_2($_POST["congelado"])==1){
				$inser_registro = "insert into $co11 values (".$id_contrato_arr.",".$id_ingreso.",".elimina_comillas_2($_POST["congelado"]).",'".date("Y-m-d")."','1')";
				$sql_ex=query_db($inser_registro);
				//echo "si congelado";
			}else{
				if(elimina_comillas_2($_POST["congelado"])==0){
					$inser_registro = query_db("insert into $co11 values (".$id_contrato_arr.",".$id_ingreso.",".elimina_comillas_2($_POST["congelado"]).",'".date("Y-m-d")."','1')");
					//echo "no congelado";
				}
			}
		}else{
			//echo "No hubo cambios";
		}
		//Registro Congelado********************************
		
		$id_log = log_de_procesos_sgpa(4, 29, 49, $id_contrato_arr, 0, 0);//graba general
		if($_POST["tipo_complemento"]==1){
			log_agrega_detalle ($id_log, "Numero Modificacion",$numero_otrosi, "",1);
			log_agrega_detalle ($id_log, "Tipo Modificacion",elimina_comillas_2($_POST["tipo_complemento"]), $g8,2);
			log_agrega_detalle ($id_log, "Tipo Otrosi",elimina_comillas_2($_POST["tipo_otrosi"]), $g9,3);
			log_agrega_detalle ($id_log, "Gerente",$nombre_gerente, "",4);
			log_agrega_detalle ($id_log, "Alcance",elimina_comillas_2($_POST["alcance"]), "",5);
			log_agrega_detalle ($id_log, "Tiempo Dias",$tiempo, "",6);
			log_agrega_detalle ($id_log, "Valor COP",$valor2, "",7);
			log_agrega_detalle ($id_log, "Valor USD",$valor, "",8);
			log_agrega_detalle ($id_log, "Clausula",elimina_comillas_2($_POST["clausula"]), "",9);
			log_agrega_detalle ($id_log, "Observaciones",elimina_comillas_2($_POST["observaciones"]), "",10);
			$text_congelado = "NO";
			if($_POST["congelado"]==1){
				$text_congelado = "SI";
				log_agrega_detalle ($id_log, "Observaciones Congelado",elimina_comillas_2($_POST["obs_congelado"]) , "",12);
			}
			log_agrega_detalle ($id_log, "Congelado",$text_congelado , "",11);
		}
		
		if($_POST["tipo_complemento"]==2){
			log_agrega_detalle ($id_log, "Numero Modificacion",$numero_otrosi, "",1);
			log_agrega_detalle ($id_log, "Tipo Modificacion",elimina_comillas_2($_POST["tipo_complemento"]), $g8,2);
			log_agrega_detalle ($id_log, "Gerente",$nombre_gerente, "",3);
			log_agrega_detalle ($id_log, "Objeto",elimina_comillas_2($_POST["alcance"]), "",4);
			log_agrega_detalle ($id_log, "Fecha Inicio",elimina_comillas_2($_POST["fecha_inicio"]), "",5);
			log_agrega_detalle ($id_log, "Fecha Fin",$tiempo, "",6);
			log_agrega_detalle ($id_log, "Valor COP",$valor2, "",7);
			log_agrega_detalle ($id_log, "Valor USD",$valor, "",8);
			log_agrega_detalle ($id_log, "Clausula",elimina_comillas_2($_POST["clausula"]), "",9);
			log_agrega_detalle ($id_log, "Observaciones",elimina_comillas_2($_POST["observaciones"]), "",10);
			$text_congelado = "NO";
			if($_POST["congelado"]==1){
				$text_congelado = "SI";
				log_agrega_detalle ($id_log, "Observaciones Congelado",elimina_comillas_2($_POST["obs_congelado"]) , "",12);
			}
			log_agrega_detalle ($id_log, "Congelado",$text_congelado , "",11);
		}
		
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El complemento se Grabó con Exito', 20, 10, 18);
        //alert("El complemento se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_complemento.php?id=<?=$_POST["id_contrato_arr_envia"];?>&id_complemento=<?=$id_ingreso?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_complemento_edita"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_complemento_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_complemento"]));//recibe id_complemento
		
		$explode = explode("----,",elimina_comillas_2($_POST["gerente"]));
		$id_gerente = $explode[1];
		$nombre_gerente = $explode[0];
		
		if($_POST["tipo_complemento"]==1){
			$tiempo = elimina_comillas_2($_POST["tiempo"]);
		}else{
			$tiempo = elimina_comillas_2($_POST["fecha_fin"]);
		}
		
		
		//Inicio temporar mientras el numero otro si puede ser manual
		$numero_otrosi = elimina_comillas_2($_POST["numero_modificacion"]);
		//Fin temporar mientras el numero otro si puede ser manual
		
		//Registro Congelado********************************
		$busca_congelado = "select congelado,estado from $co4 where id = $id_complemento_arr";
		$sql_busca_congelado = traer_fila_row(query_db($busca_congelado));
		if($sql_busca_congelado[0]=="NULL" or trim($sql_busca_congelado[0])==""){
			$congelado_actual = 0;
		}else{
			$congelado_actual = $sql_busca_congelado[0];
		}
		if($congelado_actual!=elimina_comillas_2($_POST["congelado"])){
			if(elimina_comillas_2($_POST["congelado"])==1){
				$inser_registro = "insert into $co11 values (".$id_contrato_arr.",".$id_complemento_arr.",".elimina_comillas_2($_POST["congelado"]).",'".date("Y-m-d")."','".$sql_busca_congelado[1]."')";
				$sql_ex=query_db($inser_registro);
				//echo "si congelado";
			}else{
				if(elimina_comillas_2($_POST["congelado"])==0){
					$inser_registro = query_db("insert into $co11 values (".$id_contrato_arr.",".$id_complemento_arr.",".elimina_comillas_2($_POST["congelado"]).",'".date("Y-m-d")."','".$sql_busca_congelado[1]."')");
					//echo "no congelado";
				}
			}
		}else{
			//echo "No hubo cambios";
		}
		//Registro Congelado********************************
		
		$update_sql = "update $co4  set tipo_complemento='".elimina_comillas_2($_POST["tipo_complemento"])."',tipo_otrosi='".elimina_comillas_2($_POST["tipo_otrosi"])."',gerente='".$id_gerente."',alcance='".elimina_comillas_2($_POST["alcance"])."',tiempo='".$tiempo."',valor_cop='".elimina_comillas_2(valida_numero_db($_POST["valor2"]))."',valor='".elimina_comillas_2(valida_numero_db($_POST["valor"]))."',clausula='".elimina_comillas_2($_POST["clausula"])."',observaciones='".elimina_comillas_2($_POST["observaciones"])."',fecha_inicio='".elimina_comillas_2($_POST["fecha_inicio"])."',numero_otrosi='".$numero_otrosi."',congelado='".elimina_comillas_2($_POST["congelado"])."',obs_congelado='".elimina_comillas_2($_POST["obs_congelado"])."', fecha_suspencion='".elimina_comillas_2($_POST["fecha_suspencion"])."', fecha_reinicio='".elimina_comillas_2($_POST["fecha_reinicio"])."' where id = $id_complemento_arr";
		
	if($_POST["sol_aprobacion"] != "" and $_POST["sol_aprobacion"] != 0){		
		$upda = query_db("update $co4 set id_item_pecc = ".$_POST["sol_aprobacion"].", creacion_por_gestor = 1 where id = ".$id_complemento_arr);
		}

		
		$sql_ex=query_db($update_sql);
			
		$id_log = log_de_procesos_sgpa(4, 30, 50, $id_contrato_arr, 0, 0);//graba general
		if($_POST["tipo_complemento"]==1){
			log_agrega_detalle ($id_log, "Numero Modificacion",$numero_otrosi, "",1);
			log_agrega_detalle ($id_log, "Tipo Modificacion",elimina_comillas_2($_POST["tipo_complemento"]), $g8,2);
			log_agrega_detalle ($id_log, "Tipo Otrosi",elimina_comillas_2($_POST["tipo_otrosi"]), $g9,3);
			log_agrega_detalle ($id_log, "Gerente",$nombre_gerente, "",4);
			log_agrega_detalle ($id_log, "Alcance",elimina_comillas_2($_POST["alcance"]), "",5);
			log_agrega_detalle ($id_log, "Tiempo Dias",$tiempo, "",6);
			log_agrega_detalle ($id_log, "Valor COP",$valor2, "",7);
			log_agrega_detalle ($id_log, "Valor USD",$valor, "",8);
			log_agrega_detalle ($id_log, "Clausula",elimina_comillas_2($_POST["clausula"]), "",9);
			log_agrega_detalle ($id_log, "Observaciones",elimina_comillas_2($_POST["observaciones"]), "",10);
			$text_congelado = "NO";
			if($_POST["congelado"]==1){
				$text_congelado = "SI";
				log_agrega_detalle ($id_log, "Observaciones Congelado",elimina_comillas_2($_POST["obs_congelado"]) , "",12);
			}
			log_agrega_detalle ($id_log, "Congelado",$text_congelado , "",11);
		}
		
		if($_POST["tipo_complemento"]==2){
			log_agrega_detalle ($id_log, "Numero Modificacion",$numero_otrosi, "",1);
			log_agrega_detalle ($id_log, "Tipo Modificacion",elimina_comillas_2($_POST["tipo_complemento"]), $g8,2);
			log_agrega_detalle ($id_log, "Gerente",$nombre_gerente, "",3);
			log_agrega_detalle ($id_log, "Objeto",elimina_comillas_2($_POST["alcance"]), "",4);
			log_agrega_detalle ($id_log, "Fecha Inicio",elimina_comillas_2($_POST["fecha_inicio"]), "",5);
			log_agrega_detalle ($id_log, "Fecha Fin",$tiempo, "",6);
			log_agrega_detalle ($id_log, "Valor COP",$valor2, "",7);
			log_agrega_detalle ($id_log, "Valor USD",$valor, "",8);
			log_agrega_detalle ($id_log, "Clausula",elimina_comillas_2($_POST["clausula"]), "",9);
			log_agrega_detalle ($id_log, "Observaciones",elimina_comillas_2($_POST["observaciones"]), "",10);
			$text_congelado = "NO";
			if($_POST["congelado"]==1){
				$text_congelado = "SI";
				log_agrega_detalle ($id_log, "Observaciones Congelado",elimina_comillas_2($_POST["obs_congelado"]) , "",12);
			}
			log_agrega_detalle ($id_log, "Congelado",$text_congelado , "",11);
		}
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El complemento se Grabó con Exito', 20, 10, 18);
        //alert("El complemento se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_complemento.php?id=<?=$_POST["id_contrato_arr_envia"];?>&id_complemento=<?=$id_complemento_arr;?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	
	if($_POST["accion"]=="eliminar_complemento"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_complemento_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_complemento"]));//recibe id_pokliza
		
		$update_sql = "update $co4 set eliminado=1 where id = $id_complemento_arr";
		$sql_ex=query_db($update_sql);
		
		$sel_poliza = "select id_contrato,tipo_complemento,tipo_otrosi,gerente,alcance,tiempo,tipo_moneda,valor,clausula,
estado,creacion_sistema,numero_otrosi,observaciones,fecha_inicio,valor_cop,eliminado from $co4 where id = $id_complemento_arr";
		$sel_poliza_text=traer_fila_row(query_db($sel_poliza));
		
		$id_log = log_de_procesos_sgpa(4, 31, 51, $id_contrato_arr, 0, 0);//graba general
		if($sel_poliza_text[1]==1){
			log_agrega_detalle ($id_log, "Numero Modificacion",$sel_poliza_text[11], "",1);
			log_agrega_detalle ($id_log, "Tipo Modificacion",$sel_poliza_text[1], $g8,2);
			log_agrega_detalle ($id_log, "Tipo Otrosi",$sel_poliza_text[2], $g9,3);
			log_agrega_detalle ($id_log, "Gerente",$sel_poliza_text[3], $g1,4);
			log_agrega_detalle ($id_log, "Alcance",$sel_poliza_text[4], "",5);
			log_agrega_detalle ($id_log, "Tiempo Dias",$sel_poliza_text[5], "",6);
			log_agrega_detalle ($id_log, "Valor COP",$sel_poliza_text[14], "",7);
			log_agrega_detalle ($id_log, "Valor USD",$sel_poliza_text[7], "",8);
			log_agrega_detalle ($id_log, "Clausula",$sel_poliza_text[8], "",9);
			log_agrega_detalle ($id_log, "Observaciones",$sel_poliza_text[12], "",10);
		}
		
		if($sel_poliza_text[1]==2){
			log_agrega_detalle ($id_log, "Numero Modificacion",$sel_poliza_text[11], "",1);
			log_agrega_detalle ($id_log, "Tipo Modificacion",$sel_poliza_text[1], $g8,2);
			log_agrega_detalle ($id_log, "Gerente",$sel_poliza_text[3], $g1,4);
			log_agrega_detalle ($id_log, "Objeto",$sel_poliza_text[4], "",5);
			log_agrega_detalle ($id_log, "Fecha Incio",$sel_poliza_text[13], "",5);
			log_agrega_detalle ($id_log, "Fecha Fin",$sel_poliza_text[5], "",6);
			log_agrega_detalle ($id_log, "Valor COP",$sel_poliza_text[14], "",7);
			log_agrega_detalle ($id_log, "Valor USD",$sel_poliza_text[7], "",8);
			log_agrega_detalle ($id_log, "Clausula",$sel_poliza_text[8], "",9);
			log_agrega_detalle ($id_log, "Observaciones",$sel_poliza_text[12], "",10);
		}
		
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Complemento se Elimino con Exito', 20, 10, 18);
        //alert("El Complemento se Elimino con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/h_complemento.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	
	
	if($_POST["accion"]=="graba_contacto_nueva"){
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		
		$update_sql = "insert into $co6 (id_contrato,tipo_contacto,cual,nombre,celular,fijo,email,area_geografica,estado,id_usuario_creador)values(".$id_contrato_arr.",'".elimina_comillas_2($_POST["tipo_contacto"])."','".elimina_comillas_2($_POST["cual"])."','".elimina_comillas_2($_POST["nombre"])."','".elimina_comillas_2($_POST["celular"])."','".elimina_comillas_2($_POST["fijo"])."','".elimina_comillas_2($_POST["email"])."','".elimina_comillas_2($_POST["area_geografica"])."',1,".$_SESSION["id_us_session"].")";
		$sql_ex=query_db($update_sql);
		
		$id_log = log_de_procesos_sgpa(4, 32, 52, $id_contrato_arr, 0, 0);//graba general
		log_agrega_detalle ($id_log, "Tipo Contacto",elimina_comillas_2($_POST["tipo_contacto"]), $g18,1);
		log_agrega_detalle ($id_log, "Nombre",elimina_comillas_2($_POST["nombre"]), "",2);
		log_agrega_detalle ($id_log, "Email",elimina_comillas_2($_POST["email"]), "",3);
		log_agrega_detalle ($id_log, "Celular",elimina_comillas_2($_POST["celular"]), "",4);
		log_agrega_detalle ($id_log, "Area Geografica",elimina_comillas_2($_POST["area_geografica"]), "",5);
		log_agrega_detalle ($id_log, "Fijo",elimina_comillas_2($_POST["fijo"]), "",6);

		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Contacto se Grabó con Exito', 20, 10, 18);
        //alert("El Contacto se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/contacto.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	if($_POST["accion"]=="graba_contacto_edita"){
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_contacto_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contacto"]));//recibe id_complemento
		
		$update_sql = "update $co6 set tipo_contacto='".elimina_comillas_2($_POST["tipo_contacto"])."',cual='".elimina_comillas_2($_POST["cual"])."',nombre='".elimina_comillas_2($_POST["nombre"])."',celular='".elimina_comillas_2($_POST["celular"])."',fijo='".elimina_comillas_2($_POST["fijo"])."',email='".elimina_comillas_2($_POST["email"])."',area_geografica='".elimina_comillas_2($_POST["area_geografica"])."' where id = ".$id_contacto_arr;
		$sql_ex=query_db($update_sql);
		
		$id_log = log_de_procesos_sgpa(4, 33, 53, $id_contrato_arr, 0, 0);//graba general
		log_agrega_detalle ($id_log, "Tipo Contacto",elimina_comillas_2($_POST["tipo_contacto"]), $g18,1);
		log_agrega_detalle ($id_log, "Nombre",elimina_comillas_2($_POST["nombre"]), "",2);
		log_agrega_detalle ($id_log, "Email",elimina_comillas_2($_POST["email"]), "",3);
		log_agrega_detalle ($id_log, "Celular",elimina_comillas_2($_POST["celular"]), "",4);
		log_agrega_detalle ($id_log, "Area Geografica",elimina_comillas_2($_POST["area_geografica"]), "",5);
		log_agrega_detalle ($id_log, "Fijo",elimina_comillas_2($_POST["fijo"]), "",6);
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Contacto se Grabó con Exito', 20, 10, 18);
        //alert("El Contacto se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/contacto.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
if($_POST["accion"]=="eliminar_contacto"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_contacto_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contacto"]));//recibe id_complemento
		
		$update_sql = "update $co6 set estado=2 where id = $id_contacto_arr";
		$sql_ex=query_db($update_sql);
		
		$sel_poliza = "select tipo_contacto,nombre,email,celular,area_geografica,fijo from $co6 where id = $id_contacto_arr";
		$sel_poliza_text=traer_fila_row(query_db($sel_poliza));
		
		$id_log = log_de_procesos_sgpa(4, 34, 54, $id_contrato_arr, 0, 0);//graba general
		log_agrega_detalle ($id_log, "Tipo Contacto",$sel_poliza_text[0], $g18,1);
		log_agrega_detalle ($id_log, "Nombre",$sel_poliza_text[1], "",2);
		log_agrega_detalle ($id_log, "Email",$sel_poliza_text[2], "",3);
		log_agrega_detalle ($id_log, "Celular",$sel_poliza_text[3], "",4);
		log_agrega_detalle ($id_log, "Area Geografica",$sel_poliza_text[4], "",5);
		log_agrega_detalle ($id_log, "Fijo",$sel_poliza_text[5], "",6);
		
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Complemento se Elimino con Exito', 20, 10, 18);
        //alert("El Complemento se Elimino con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/contacto.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}	
	
	if($_POST["accion"]=="graba_documento_nueva"){
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		
				$campo_file_nombre = $_FILES["archivo"]["name"];
				$campo_file_temp = $_FILES["archivo"]["tmp_name"];
				
				$update_sql = "insert into $co7 (id_contrato,tipo_documento,id_p8,estado,archivo)values(".$id_contrato_arr.",'".elimina_comillas_2($_POST["tipo_documento"])."','".elimina_comillas_2($_POST["id_p8"])."',1,'".$campo_file_nombre."')";
				$sql_ex=query_db($update_sql.$trae_id_insrte);
				
				$id_ingreso_e = id_insert($sql_ex);
				$campo_file_nombre_ant = $campo_file_nombre;
				if($campo_file_nombre != ""){
						$campo_file_nombre = str_replace("á","a",$campo_file_nombre);
						$campo_file_nombre = str_replace("Á","a",$campo_file_nombre);
						$campo_file_nombre = str_replace("é","e",$campo_file_nombre);
						$campo_file_nombre = str_replace("É","e",$campo_file_nombre);
						$campo_file_nombre = str_replace("í","i",$campo_file_nombre);
						$campo_file_nombre = str_replace("Í","i",$campo_file_nombre);
						$campo_file_nombre = str_replace("ó","o",$campo_file_nombre);
						$campo_file_nombre = str_replace("Ó","o",$campo_file_nombre);
						$campo_file_nombre = str_replace("ú","u",$campo_file_nombre);
						$campo_file_nombre = str_replace("Ú","u",$campo_file_nombre);
						$campo_file_nombre = str_replace("ñ","n",$campo_file_nombre);
						$campo_file_nombre = str_replace("Ñ","n",$campo_file_nombre);
								
						$copiar = carga_archivo($campo_file_temp,'procesos_contrato/doc_'.$id_ingreso_e."_7");
				}
		$id_log = log_de_procesos_sgpa(4, 35, 55, $id_contrato_arr, 0, 0);//graba general
		log_agrega_detalle ($id_log, "Tipo Documento",elimina_comillas_2($_POST["tipo_documento"]), $g19,1);
		log_agrega_detalle ($id_log, "ID",elimina_comillas_2($_POST["id_p8"]), "",2);
		log_agrega_detalle ($id_log, "Archivo",$campo_file_nombre_ant, "",3);
			
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Contacto se Grabó con Exito', 20, 10, 18);
        //alert("El Contacto se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/documento.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_documento_edita"){
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_documento_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_documento"]));//recibe id_complemento
		
		
				
				
				$update_sql = "update $co7 set tipo_documento='".elimina_comillas_2($_POST["tipo_documento"])."',id_p8='".elimina_comillas_2($_POST["id_p8"])."' where id = ".$id_documento_arr;
				$sql_ex=query_db($update_sql);
		
				$campo_file_nombre = $_FILES["archivo"]["name"];
				$campo_file_temp = $_FILES["archivo"]["tmp_name"];
				$campo_file_nombre_ant = $campo_file_nombre;
				if($campo_file_nombre!=""){					
					$id_ingreso_e = $id_documento_arr;
				
					if($campo_file_nombre != ""){
							$campo_file_nombre = str_replace("á","a",$campo_file_nombre);
							$campo_file_nombre = str_replace("Á","a",$campo_file_nombre);
							$campo_file_nombre = str_replace("é","e",$campo_file_nombre);
							$campo_file_nombre = str_replace("É","e",$campo_file_nombre);
							$campo_file_nombre = str_replace("í","i",$campo_file_nombre);
							$campo_file_nombre = str_replace("Í","i",$campo_file_nombre);
							$campo_file_nombre = str_replace("ó","o",$campo_file_nombre);
							$campo_file_nombre = str_replace("Ó","o",$campo_file_nombre);
							$campo_file_nombre = str_replace("ú","u",$campo_file_nombre);
							$campo_file_nombre = str_replace("Ú","u",$campo_file_nombre);
							$campo_file_nombre = str_replace("ñ","n",$campo_file_nombre);
							$campo_file_nombre = str_replace("Ñ","n",$campo_file_nombre);
									
							$copiar = carga_archivo($campo_file_temp,'procesos_contrato/doc_'.$id_ingreso_e."_7");
					}
					$update_sql = "update $co7 set archivo='".$campo_file_nombre."' where id = ".$id_documento_arr;
					$sql_ex=query_db($update_sql);
				}
				
		$id_log = log_de_procesos_sgpa(4, 36, 56, $id_contrato_arr, 0, 0);//graba general
		log_agrega_detalle ($id_log, "Tipo Documento",elimina_comillas_2($_POST["tipo_documento"]), $g19,1);
		log_agrega_detalle ($id_log, "ID",elimina_comillas_2($_POST["id_p8"]), "",2);
		log_agrega_detalle ($id_log, "Archivo",$campo_file_nombre_ant, "",3);
		?>
		<script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Contacto se Grabó con Exito', 20, 10, 18);
        //alert("El Contacto se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/documento.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}

	if($_POST["accion"]=="graba_contrato_area"){
		$fecha=date("Y-m-d");
		$hora=date("H:i:s");
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato"]));//recibe id
		$id_area = elimina_comillas(arreglo_recibe_variables($_POST["id_area"]));//recibe id_complemento
		$id_item = elimina_comillas(arreglo_recibe_variables($_POST["id_item"]));//recibe id_complemento
		$id_sesion=$_SESSION["id_us_session"];
		$busca_area=traer_fila_row(query_db("SELECT COUNT(*) FROM $co12 WHERE id_contrato=$id_contrato_arr AND id_area=$id_area"));
		if($busca_area[0]==0){
			$insert="INSERT INTO $co12(id_contrato, id_area, id_usuario, estado, fecha, hora, id_item) VALUES($id_contrato_arr, $id_area, $id_sesion, 1, '$fecha', '$hora', $id_item)";
			$resultado=query_db($insert);
			if($resultado){
				?>
				<script> 
				window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'Area agregada con éxito', 20, 10, 18);
		        //alert("Area agregada con éxito")
				window.parent.ajax_carga('../aplicaciones/contratos/contrato_area.php?id_contrato=<?=$id_contrato_arr;?>','carga_acciones_permitidas');
		        </script>
				<?
			}
		}else{
			$sel_estado=traer_fila_row(query_db("SELECT estado FROM $co12 WHERE id_contrato=$id_contrato_arr AND id_area=$id_area"));
			if ($sel_estado[0]!=1){
				$update="UPDATE $co12 SET estado=1 WHERE id_contrato=$id_contrato_arr AND id_area=$id_area";
				$resultado=query_db($update);
				if($resultado){
					?>
					<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'Area agregada con éxito', 20, 10, 18);
			        //alert("Area agregada con éxito")
					window.parent.ajax_carga('../aplicaciones/contratos/contrato_area.php?id_contrato=<?=$id_contrato_arr;?>','carga_acciones_permitidas');
			        </script>
					<?
				}
			}
		}
	}
	
	if($_POST["accion"]=="elimina_contrato_area"){
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato"]));//recibe id
		$id_area = elimina_comillas(arreglo_recibe_variables($_POST["id_elimina"]));//recibe id_complemento
		$update="UPDATE $co12 SET estado=2 WHERE id=$id_area";
		$resultado=query_db($update);
		if($resultado){
			?>
			<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'Area eliminada con éxito', 20, 10, 18);
	        //alert("Area eliminada con éxito")
			window.parent.ajax_carga('../aplicaciones/contratos/contrato_area.php?id_contrato=<?=$id_contrato_arr;?>','carga_acciones_permitidas');
	        </script>
			<?
		}
	}

	if($_POST["accion"]=="eliminar_documento"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$id_documento_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_documento"]));//recibe id_complemento
		
		$update_sql = "update $co7 set estado=2 where id = $id_documento_arr";
		$sql_ex=query_db($update_sql);
		
		$sel_poliza = "select tipo_documento,id_p8,archivo from $co7 where id = $id_documento_arr";
		$sel_poliza_text=traer_fila_row(query_db($sel_poliza));
		
		$id_log = log_de_procesos_sgpa(4, 37, 57, $id_contrato_arr, 0, 0);//graba general
		log_agrega_detalle ($id_log, "Tipo Documento",$sel_poliza_text[0], $g19,1);
		log_agrega_detalle ($id_log, "ID",$sel_poliza_text[1], "",2);
		log_agrega_detalle ($id_log, "Archivo",$sel_poliza_text[2], "",3);
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Complemento se Elimino con Exito', 20, 10, 18);
        //alert("El Complemento se Elimino con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/documento.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
	}	
	
	if($_POST["accion"]=="graba_fecha_pa"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id

		$insert_sql_ob = "insert into $co8 (id_contrato,id_complemento,campo,observacion,estado)values(".$id_contrato_arr.",0,'".elimina_comillas_2($_POST["campo_fecha"])."','".elimina_comillas_2($_POST[$_POST["campo_fecha"]."_obs"])."',1)";
		$sql_ex=query_db($insert_sql_ob);
		
		$update_sql = "update $co1 set ".elimina_comillas_2($_POST["campo_fecha"])." = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]))."' ,".elimina_comillas_2($_POST["campo_fecha"])."_e = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))."'   where id = ".$id_contrato_arr;
		
		$sql_ex=query_db($update_sql);
		
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La fecha se Grabó con Exito', 20, 10, 18);
        //alert("La fecha se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/v_contratos.php?id=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?
		
	}
	if($_POST["accion"]=="graba_fecha_co_pa"){

		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id

		$id_complemento_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_complemento"]));//recibe id
		$id_contrato = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		
		$insert_sql_ob = "insert into $co8 (id_contrato,id_complemento,campo,observacion,estado)values(".$id_contrato.",".$id_complemento_arr.",'".elimina_comillas_2($_POST["campo_fecha"])."','".elimina_comillas_2($_POST[$_POST["campo_fecha"]."_obs"])."',1)";
		$sql_ex=query_db($insert_sql_ob);
		
		$update_sql = "update $co4 set ".elimina_comillas_2($_POST["campo_fecha"])." = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]]))."' ,".elimina_comillas_2($_POST["campo_fecha"])."_e = '".trim(elimina_comillas_2($_POST[$_POST["campo_fecha"]."_e"]))."'   where id = ".$id_contrato_arr;
		
		$sql_ex=query_db($update_sql);
		
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La fecha se Grabó con Exito', 20, 10, 18);
        //alert("La fecha se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_complemento.php?id=<?=$_POST["id_contrato_arr_envia"];?>&id_complemento=<?=$_POST["id_complemento"];?>','carga_acciones_permitidas');
        </script>
		<?
		
	}
	
	
	
//**************************Evaluador***********************************************************
	if($_POST["accion"]=="graba_tipo_pregunta_nuevo"){
		
		$id_tipo_pregunta_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_pregunta"]));//recibe id
		$update_sql = "insert into $ev1 (nombre,estado)values('".elimina_comillas_2($_POST["nombre"])."',1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);
		$id_ingreso = id_insert($sql_ex);
			
		for($i=1;$i<=5;$i++){
			if(elimina_comillas_2($_POST["puntaje_".$i])!="" && elimina_comillas_2($_POST["texto_".$i])!=""){
				$update_sql = "insert into $ev2 (tipo_pregunta,puntaje,texto,estado)values(".$id_ingreso.",'".elimina_comillas_2($_POST["puntaje_".$i])."','".elimina_comillas_2($_POST["texto_".$i])."',1)";
				$sql_ex=query_db($update_sql);	
			}
		}
		
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_tipo_pregunta.php','carga_acciones_permitidas');
        </script>
		<?
	}
		if($_POST["accion"]=="graba_tipo_pregunta_edita"){
		
		$id_tipo_pregunta_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_pregunta"]));//recibe id
		$update_sql = "update $ev1 set nombre = '".elimina_comillas_2($_POST["nombre"])."' where id = ".$id_tipo_pregunta_arr;
		$sql_ex=query_db($update_sql);

		$id_ingreso = $id_tipo_pregunta_arr;
		
		$update_sql = "delete from $ev2 where tipo_pregunta = ".$id_tipo_pregunta_arr;
		$sql_ex=query_db($update_sql);
		for($i=1;$i<=5;$i++){
			if(elimina_comillas_2($_POST["puntaje_".$i])!="" && elimina_comillas_2($_POST["texto_".$i])!=""){
				$update_sql = "insert into $ev2 (tipo_pregunta,puntaje,texto,estado)values(".$id_ingreso.",'".elimina_comillas_2($_POST["puntaje_".$i])."','".elimina_comillas_2($_POST["texto_".$i])."',1)";
				$sql_ex=query_db($update_sql);	
			}
		}
		
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_tipo_pregunta.php','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_grupo_nuevo"){
		
		$id_grupo_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_grupo"]));//recibe id
		$update_sql = "insert into $ev3 (nombre,estado)values('".elimina_comillas_2($_POST["nombre"])."',1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);
		$id_ingreso = id_insert($sql_ex);
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_grupo.php','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_grupo_edita"){
		
		$id_grupo_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_grupo"]));//recibe id
		$update_sql = "update $ev3 set nombre = '".elimina_comillas_2($_POST["nombre"])."' where id = ".$id_grupo_arr;
		$sql_ex=query_db($update_sql);

		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_grupo.php','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_pregunta_nuevo"){
		
		$update_sql = "insert into $ev4 (grupo,tipo_pregunta,pregunta,estado)values('".elimina_comillas_2($_POST["grupo"])."','0','".elimina_comillas_2($_POST["pregunta"])."',1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);
		$id_ingreso = id_insert($sql_ex);
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_pregunta.php','carga_acciones_permitidas');
        </script>
		<?
	}
	if($_POST["accion"]=="graba_pregunta_edita"){
		
		$id_pregunta_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_pregunta"]));//recibe id
		$update_sql = "update $ev4 set grupo = '".elimina_comillas_2($_POST["grupo"])."',pregunta = '".elimina_comillas_2($_POST["pregunta"])."' where id = ".$id_pregunta_arr;
		$sql_ex=query_db($update_sql);

		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_pregunta.php','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_plantilla_nuevo"){
		

		$update_sql = "insert into $ev5 (nombre,estado)values('".elimina_comillas_2($_POST["nombre"])."',1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);		
		$id_ingreso = id_insert($sql_ex);
		
		$lista_poliza_int = "select * from ".$ev3."  where estado = 1 order by id";
		$sql_poliza_int=query_db($lista_poliza_int);
		while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
			$lista_preguntas = "select t8ep.id,t8ep.grupo,t8ep.tipo_pregunta,t8ep.pregunta,t8ep.estado,t8eg.nombre  from ".$ev4." t8ep left join ".$ev3." t8eg on t8ep.grupo=t8eg.id  where  t8ep.grupo = ".$lista_poliza_int[0]." order by t8ep.pregunta ";
			$sql_lista_preguntas=query_db($lista_preguntas);
			while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){
				$insert_sql = "insert into $ev6 values (".$id_ingreso.",".elimina_comillas_2($re_lista_preguntas[0]).",".elimina_comillas_2($_POST["puntaje_grupo_".$lista_poliza_int[0]]).",".elimina_comillas_2($_POST["aplica_pregunta_".$re_lista_preguntas[0]])." )";
				$sql_ex=query_db($insert_sql);
			}
					
		}
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_plantilla.php','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_plantilla_edita"){
		
		$id_plantilla_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_plantilla"]));//recibe id
		
		$update_sql = "update $ev5 set nombre = '".elimina_comillas_2($_POST["nombre"])."' where id = ".$id_plantilla_arr;
		$sql_ex=query_db($update_sql);
		
		$update_sql = "delete from $ev6  where plantilla = ".$id_plantilla_arr;
		$sql_ex=query_db($update_sql);
		
		$id_ingreso = id_insert($sql_ex);
		
		$lista_poliza_int = "select * from ".$ev3."  where estado = 1 order by id";
		$sql_poliza_int=query_db($lista_poliza_int);
		while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
			$lista_preguntas = "select t8ep.id,t8ep.grupo,t8ep.tipo_pregunta,t8ep.pregunta,t8ep.estado,t8eg.nombre  from ".$ev4." t8ep left join ".$ev3." t8eg on t8ep.grupo=t8eg.id  where  t8ep.grupo = ".$lista_poliza_int[0]." order by t8ep.pregunta ";
			$sql_lista_preguntas=query_db($lista_preguntas);
			while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){
				$insert_sql = "insert into $ev6 values (".$id_plantilla_arr.",".elimina_comillas_2($re_lista_preguntas[0]).",".elimina_comillas_2($_POST["puntaje_grupo_".$lista_poliza_int[0]]).",".elimina_comillas_2($_POST["aplica_pregunta_".$re_lista_preguntas[0]])." )";
				$sql_ex=query_db($insert_sql);
			}
					
		}
		
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_plantilla.php','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_pregunta_nuevo2"){
		
		$id_grupo_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_grupo"]));//recibe id
		$update_sql = "insert into $ev7 (nombre,estado)values('".elimina_comillas_2($_POST["nombre"])."',1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);
		$id_ingreso = id_insert($sql_ex);
		
		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/evaluador/h_pregunta_informativa.php','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_pregunta_edita2"){
		
		$id_grupo_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_grupo"]));//recibe id
		$update_sql = "update $ev7 set nombre = '".elimina_comillas_2($_POST["nombre"])."' where id = ".$id_grupo_arr;
		$sql_ex=query_db($update_sql);

		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/h_evaluacion.php','carga_acciones_permitidas');
        </script>
		<?
	}
	
	if($_POST["accion"]=="graba_plantilla_final"){
		$msn1 = "";
		$msn2 = "";
		foreach($_POST["aplica_pregunta"] as $id_pregunta){
				$campo = "";
				$campo = "calificacion_".$id_pregunta;
			if($_POST["calificacion_".$id_pregunta]==""){
				$msn1 = "*Debe Digitar una calificacion";
				?>
				<script>
				window.parent.document.getElementById("<?=$campo?>").className = "campos_faltantes"				
				</script>
				<?                            
			}else{
				?>
				<script>
				window.parent.document.getElementById("<?=$campo?>").className = ""				
				</script>
				<?                            
			}
			$campo2 = "";
			$campo2 = "observacion_".$id_pregunta;
			$campo3 = "";
			$campo3 = "adjunto_".$id_pregunta;
			
			if($_POST["observacion_".$id_pregunta]==""){
				$msn2 = "*Debe Digitar la Observación";
				?>
				<script>
				window.parent.document.getElementById("<?=$campo2?>").className = "textarea_faltantes"
				</script>
				<?                            
			}else{
				?>
				<script>
				window.parent.document.getElementById("<?=$campo2?>").className = ""	
				</script>
				<?                            
			}
		}
		foreach($_POST["aplica_pregunta_tbg"] as $id_pregunta){
				$campo = "";
				$campo = "calificacion_tbg_".$id_pregunta;
			if($_POST["calificacion_tbg_".$id_pregunta]=="0"){
				$msn1 = "*Debe Seleccionar una calificacion";
				?>
				<script>
				window.parent.document.getElementById("<?=$campo?>").className = "select_faltantes"				
				</script>
				<?                            
			}else{
				?>
				<script>
				window.parent.document.getElementById("<?=$campo?>").className = ""				
				</script>
				<?                            
			}
			$campo2 = "";
			$campo2 = "observacion_tbg_".$id_pregunta;
			$campo3 = "";
			$campo3 = "adjunto_tbg_".$id_pregunta;
			
			if($_POST["observacion_tbg_".$id_pregunta]==""){
				$msn2 = "*Debe Digitar la Observación";
				?>
				<script>
				window.parent.document.getElementById("<?=$campo2?>").className = "textarea_faltantes"
				</script>
				<?                            
			}else{
				?>
				<script>
				window.parent.document.getElementById("<?=$campo2?>").className = ""	
				</script>
				<?                            
			}
		}

		if($msn1!="" or $msn2!=""){
			?>
            <script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:<br>'+msg, 60, 5, 10)
			//alert("Verifique el formulario\n\n<?=$msn1?>\n<?=$msn2;?>")
			</script>
            <?
		}else{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		
		$update_sql = "insert into $ev8 (id_contrato,id_orden_trabajo,id_usuario,nombre,estado)values($id_contrato_arr,".elimina_comillas($_POST["orden_trabajo"]).",".$_SESSION["id_us_session"].",'Evaluacion',1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);
		$id_ingreso = id_insert($sql_ex);
		
		foreach($_POST["aplica_pregunta"] as $id_pregunta){
			$pregunta_qu = traer_fila_row(query_db("select * from ".$ev4."  where id =".elimina_comillas_2($id_pregunta)));
			
				$campo_file_nombre = $_FILES["adjunto_".$id_pregunta]["name"];
				$campo_file_temp = $_FILES["adjunto_".$id_pregunta]["tmp_name"];
				$insert_sql1 = "insert into $ev9 values (".$id_ingreso.",".elimina_comillas_2($_POST["id_plantilla"]).",".elimina_comillas_2($id_pregunta).",'".elimina_comillas_2($_POST["puntaje_grupo_".$pregunta_qu[1]])."','".elimina_comillas_2($_POST["calificacion_".$id_pregunta])."','".$campo_file_nombre."','".elimina_comillas_2($_POST["observacion_".$id_pregunta])."')";
				$sql_ex1=query_db($insert_sql1.$trae_id_insrte);
				$id_ingreso_e = id_insert($sql_ex1);
			
				if($campo_file_nombre != ""){
						$campo_file_nombre = str_replace("á","a",$campo_file_nombre);
						$campo_file_nombre = str_replace("Á","a",$campo_file_nombre);
						$campo_file_nombre = str_replace("é","e",$campo_file_nombre);
						$campo_file_nombre = str_replace("É","e",$campo_file_nombre);
						$campo_file_nombre = str_replace("í","i",$campo_file_nombre);
						$campo_file_nombre = str_replace("Í","i",$campo_file_nombre);
						$campo_file_nombre = str_replace("ó","o",$campo_file_nombre);
						$campo_file_nombre = str_replace("Ó","o",$campo_file_nombre);
						$campo_file_nombre = str_replace("ú","u",$campo_file_nombre);
						$campo_file_nombre = str_replace("Ú","u",$campo_file_nombre);
						$campo_file_nombre = str_replace("ñ","n",$campo_file_nombre);
						$campo_file_nombre = str_replace("Ñ","n",$campo_file_nombre);
								
						$copiar = carga_archivo($campo_file_temp,'procesos_contrato/eva_'.$id_ingreso_e."_7");
				}
		}
		
		foreach($_POST["aplica_pregunta_tbg"] as $id_pregunta){

			$campo_file_nombre = $_FILES["adjunto_tbg_".$id_pregunta]["name"];
			$campo_file_temp = $_FILES["adjunto_tbg_".$id_pregunta]["tmp_name"];
				
				
			$insert_sql1 = "insert into $ev12 values (".$id_ingreso.",".elimina_comillas_2($_POST["id_plantilla"]).",".elimina_comillas_2($id_pregunta).",'".elimina_comillas_2($_POST["puntaje_grupo_tbg"])."','".elimina_comillas_2($_POST["calificacion_tbg_".$id_pregunta])."','".$campo_file_nombre."','".elimina_comillas_2($_POST["observacion_tbg_".$id_pregunta])."')";
			$sql_ex1=query_db($insert_sql1.$trae_id_insrte);
			$id_ingreso_e = id_insert($sql_ex1);
			
			if($campo_file_nombre != ""){
				$campo_file_nombre = str_replace("á","a",$campo_file_nombre);
				$campo_file_nombre = str_replace("Á","a",$campo_file_nombre);
				$campo_file_nombre = str_replace("é","e",$campo_file_nombre);
				$campo_file_nombre = str_replace("É","e",$campo_file_nombre);
				$campo_file_nombre = str_replace("í","i",$campo_file_nombre);
				$campo_file_nombre = str_replace("Í","i",$campo_file_nombre);
				$campo_file_nombre = str_replace("ó","o",$campo_file_nombre);
				$campo_file_nombre = str_replace("Ó","o",$campo_file_nombre);
				$campo_file_nombre = str_replace("ú","u",$campo_file_nombre);
				$campo_file_nombre = str_replace("Ú","u",$campo_file_nombre);
				$campo_file_nombre = str_replace("ñ","n",$campo_file_nombre);
				$campo_file_nombre = str_replace("Ñ","n",$campo_file_nombre);
						
				$copiar = carga_archivo($campo_file_temp,'procesos_contrato/tbg_'.$id_ingreso_e."_7");
			}
		
		}
			
			?>
			<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        	//alert("La Información se Grabó con Exito")
			window.parent.ajax_carga('../aplicaciones/contratos/h_evaluacion.php','carga_acciones_permitidas');
        	</script>
			<?	
		}
		
		
					
		
	}
	
	
	if($_POST["accion"]=="graba_plantilla_tbg"){
		//Graba Plantilla*****************************************************************************		
		
		$update_sql = "insert into $ev5 (nombre,estado)values('".$_SESSION["id_us_session"]."',3)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);		
		$id_ingreso = id_insert($sql_ex);
		
		$lista_poliza_int = "select * from ".$ev3."  where estado = 1 order by id";
		$sql_poliza_int=query_db($lista_poliza_int);
		while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
			$lista_preguntas = "select t8ep.id,t8ep.grupo,t8ep.tipo_pregunta,t8ep.pregunta,t8ep.estado,t8eg.nombre  from ".$ev4." t8ep left join ".$ev3." t8eg on t8ep.grupo=t8eg.id  where  t8ep.grupo = ".$lista_poliza_int[0]." order by t8ep.pregunta ";
			$sql_lista_preguntas=query_db($lista_preguntas);
			while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){
				$insert_sql = "insert into $ev6 values (".$id_ingreso.",".elimina_comillas_2($re_lista_preguntas[0]).",".elimina_comillas_2($_POST["puntaje_grupo_".$lista_poliza_int[0]]).",".elimina_comillas_2($_POST["aplica_pregunta_".$re_lista_preguntas[0]])." )";
				$sql_ex=query_db($insert_sql);
			}
					
		}
		$id_plantilla_editada = $id_ingreso;
		//Graba Plantilla*****************************************************************************
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));//recibe id
		$con_pregunta = elimina_comillas($_POST["con_pregunta"]);
		$orden_trabajo = elimina_comillas($_POST["orden_trabajo"]);
		$tipo_plantilla = elimina_comillas($_POST["tipo_plantilla"]);
		$requiere_edicion = elimina_comillas($_POST["requiere_edicion"]);
		$puntaje_final = $_POST["puntaje_final"];
		
		$update_sql = "insert into $ev10 (id_contrato,id_orden_trabajo,id_creador,tbg,estado)values($id_contrato_arr,".elimina_comillas($_POST["orden_trabajo"]).",".$_SESSION["id_us_session"].",'TBG',1)";
		$sql_ex=query_db($update_sql.$trae_id_insrte);
		$id_ingreso = id_insert($sql_ex);
		
		
		for($i=1;$i<=$con_pregunta;$i++){
			if(elimina_comillas_2($_POST["pregunta_".$i])!=""){
			$insert_sql = "insert into $ev11 values (".$id_ingreso.",'".elimina_comillas_2($_POST["pregunta_".$i])."','".elimina_comillas_2($_POST["tipo_pregunta_".$i])."',1)";			
			$sql_ex=query_db($insert_sql );
			}
		}

		?>
		<script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/c_evaluacion_final.php?id_evaluacion=<?=$tipo_plantilla;?>&requiere_edicion=SI&id_plantilla_editada=<?=$id_plantilla_editada;?>&id_contrato=<?=$id_contrato_arr;?>&puntaje_final=<?=$puntaje_final;?>','carga_plantilla_evaluador');
		
        </script>
		<?
	}
	
	
	if($_POST["accion"]=="acciones_admin_contratos"){
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato_arr_envia"]));
		
		if($_POST['acci1'] == 1){
			//Se elimina
			$observacion = $_POST['ob1'];
			$campo_file_nombre = $_FILES["file_delete"]["name"];
			$campo_file_temp = $_FILES["file_delete"]["tmp_name"];
			
			if($campo_file_nombre != ""){
				$campo_file_nombre = str_replace("á","a",$campo_file_nombre);
				$campo_file_nombre = str_replace("Á","a",$campo_file_nombre);
				$campo_file_nombre = str_replace("é","e",$campo_file_nombre);
				$campo_file_nombre = str_replace("É","e",$campo_file_nombre);
				$campo_file_nombre = str_replace("í","i",$campo_file_nombre);
				$campo_file_nombre = str_replace("Í","i",$campo_file_nombre);
				$campo_file_nombre = str_replace("ó","o",$campo_file_nombre);
				$campo_file_nombre = str_replace("Ó","o",$campo_file_nombre);
				$campo_file_nombre = str_replace("ú","u",$campo_file_nombre);
				$campo_file_nombre = str_replace("Ú","u",$campo_file_nombre);
				$campo_file_nombre = str_replace("ñ","n",$campo_file_nombre);
				$campo_file_nombre = str_replace("Ñ","n",$campo_file_nombre);
				
				$insert_sql1 = "insert into t7_acciones_admin (id_contrato,id_usuario, adjunto, observacion,fecha,detalle) values ($id_contrato_arr,'".$_SESSION['id_us_session']."','$campo_file_nombre','$observacion','$fecha $hora','1. Eliminar Contrato')";
				$sql_ex1=query_db($insert_sql1.$trae_id_insrte);
				$id_ingreso_e = id_insert($sql_ex1);	
				$copiar = carga_archivo($campo_file_temp,'procesos_contrato/admin_'.$id_ingreso_e."_7");
				
				//Query actualizacion de registro en contratos (Se eliminan contratos => Estado 33).
				$update_contratos = query_db("update $co1 set estado = 50 where id = $id_contrato_arr ");
				
				// Se eliminan tarifas => Estado 8
				$query_tarifas = "select tarifas_contrato_id from t6_tarifas_contratos where id_contrato = $id_contrato_arr";
				$info_tarifa = traer_fila_db(query_db($query_tarifas));
				if($info_tarifa['tarifas_contrato_id'] > 1){
				$update_tarifas = query_db("update t6_tarifas_lista set t6_tarifas_estados_tarifas_id = 8 where tarifas_contrato_id = ".$info_tarifa['tarifas_contrato_id']);
				}
				
			}
		}
		
		?>
        <script> 
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La Información se Grabó con Exito', 20, 10, 18);
        //alert("La Información se Grabó con Exito")
		window.parent.ajax_carga('../aplicaciones/contratos/admin_contratos.php?id_contrato=<?=$_POST["id_contrato_arr_envia"];?>','carga_acciones_permitidas');
        </script>
		<?php
	}
	
?>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
