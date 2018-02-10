<?
$es_local="NO";
$verifica_url_local = $_SERVER["REQUEST_URI"];
	$sitio = explode("/",$verifica_url_local);
	if($sitio[1] == "sgpa_local"){
		$es_local="SI";
	}
$id_usuario_profesional = 9;//nanky 9, maria cock 7


$trm_actual = 3000;

function valor_solicitud($id_solicitud_busca, $tp_permiso_ad){
			global $pi8;
			$sel_item_funt_b = traer_fila_row(query_db("select convirte_marco, estado, t1_tipo_proceso_id from t2_item_pecc where id_item = ".$id_solicitud_busca));
			
			if ($sel_item_funt_b[2] == 11) {
                           $sql_presupuesto_fin = "select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $id_solicitud_busca. " and permiso_o_adjudica = 1";
                        } elseif ($sel_item_funt_b[2] == 5 or $sel_item_funt_b[2] == 7 or $sel_item_funt_b[2] == 10) {
							$sql_presupuesto_fin="select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $id_solicitud_busca. " and permiso_o_adjudica = 1";
			
                        	}elseif ($sel_item_funt_b[2] == 12 and $sel_item_funt_b[0] == 3){//si es reclasificacion de contrato marco							
							$sql_presupuesto_fin= "select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $id_solicitud_busca . " and permiso_o_adjudica = 1 and al_valor_inicial_para_marco = 1";		
							}elseif ($sel_item_funt_b[2] == 12 and $sel_item_funt_b[0] != 3){//si es reclasificacion de contrato puntual							
							$sql_presupuesto_fin = "select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $id_solicitud_busca . " and permiso_o_adjudica = 1";		
							}elseif (($sel_item_funt_b[2] == 1  or $sel_item_funt_b[2] == 2) and ($sel_item_funt_b[1] == 8 or $tp_permiso_ad ==1)){//neg lic permiso				
							$sql_presupuesto_fin = "select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $id_solicitud_busca . " and permiso_o_adjudica = 1";		
							}elseif (($sel_item_funt_b[2] == 1  or $sel_item_funt_b[2] == 2 or $sel_item_funt_b[2] == 6) and ($sel_item_funt_b[1] == 17  or $tp_permiso_ad ==2)){//neg lic adjundi				
							$sql_presupuesto_fin = "select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $id_solicitud_busca . " and permiso_o_adjudica = 2";
						}else{
							if($sel_item_funt_b[1]>=17 and $sel_item_funt_b[1] <> 31){
								$permiso_o_adjudica_sql=2;
							}else{
								$permiso_o_adjudica_sql=1;									
						}
							$sql_presupuesto_fin = "select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $id_solicitud_busca . " and permiso_o_adjudica = $tp_permiso_ad";
							}
	
	$sel_presupuesto = traer_fila_row(query_db($sql_presupuesto_fin));
			
			$valor_usd_de_funct = $sel_presupuesto[0];
			$valor_cop_de_funct = $sel_presupuesto[1];
	
		$v_retorna = $valor_usd_de_funct."---".$valor_cop_de_funct;
			
	return $v_retorna;
		}


function permiso_ingreso($req_ingreso){
	
	$sel_permisos = traer_fila_row(query_db("SELECT        count(*) FROM           dbo.tseg12_relacion_usuario_rol INNER JOIN dbo.tseg20_relacion_permisos_modulo_rol ON dbo.tseg12_relacion_usuario_rol.id = dbo.tseg20_relacion_permisos_modulo_rol.id_relacion_usuario INNER JOIN   dbo.tseg21_permisos_modulo ON dbo.tseg20_relacion_permisos_modulo_rol.id_permisos_modulo = dbo.tseg21_permisos_modulo.id_permisos_modulo where dbo.tseg21_permisos_modulo.id_permisos_modulo =".$req_ingreso." and  dbo.tseg12_relacion_usuario_rol.id_usuario = ".$_SESSION["id_us_session"]));
	if($sel_permisos[0] >0){
		
		return "SI";
	}
	
}

function ver_si_tiene_reemplazo_asignado_ids($id_us){
	$ids_reempla = $id_us;
	global $fecha;
	$sel_reemlpazo_sql = query_db("select id_us from tseg_reemplazos where id_reemplazo in (".$id_us.") and estado = 1 and  desde_cuando <='".$fecha."'");
	
	
	
	while($sel_reemlpazo = traer_fila_db($sel_reemlpazo_sql)){
	if($sel_reemlpazo[0]>0){
		$ids_reempla.= ",".$sel_reemlpazo[0];	  
		}
	}
		return $ids_reempla;
	
	
	}

function ver_si_tiene_reemplazo($id_us){
	$id_us_reemplazo = $id_us;
	global $fecha;
	$sel_reemlpazo = traer_fila_row(query_db("select id_reemplazo from tseg_reemplazos where id_us = ".$id_us." and estado = 1 and  desde_cuando <='".$fecha."'"));
	
	if($sel_reemlpazo[0]>0){
		$id_us_reemplazo = $sel_reemlpazo[0];
			   $imprime = saca_nombre_lista("t1_us_usuarios",$sel_reemlpazo[0],'nombre_administrador','us_id')."<br /><font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista("t1_us_usuarios",$id_us,'nombre_administrador','us_id')."</strong>";
			  
				  
		}else{
			$imprime =saca_nombre_lista("t1_us_usuarios",$id_us,'nombre_administrador','us_id');
			}
		return $imprime;
	
	
	}
	
function numero_cotnrato_tarifas($id_contrato_tarifas){

$sel_contrato_tarifas = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id=".$id_contrato_tarifas));
	$sel_contrato_modulo = traer_fila_row(query_db("select consecutivo, creacion_sistema, apellido, tipo_bien_servicio from t7_contratos_contrato where id = ".$sel_contrato_tarifas[0]));
$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sel_contrato_modulo[1]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sel_contrato_modulo[0];//consecutivo
		$numero_contrato4 = $sel_contrato_modulo[2];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contrato_tarifas[0]);
		echo $contrato_ajus;
	}

function declarar_desierto_rene($id_item){
	global $host_mys,$usr_mys, $pwd_mys, $dbbase_mys;
	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);
	
		$cambia_stado_mysql_procesos = "update pro1_proceso set tp1_id = 7 where cd_id_entrega_documentos = $id_item";
		$sql_cabia_estado = mysql_query($cambia_stado_mysql_procesos);
	
	}
/* Funciones para el envio de correos al rechazar firmas Solicitudes.*/
function envia_email_solicitudes($id_item, $quien_rechaza) {
    global $pi2, $g1;

    $infoItemPec = traer_fila_row(query_db("select id_item,id_us,id_us_profesional_asignado,id_us_preparador,id_gerente_ot,num1,num2,num3,cast(objeto_solicitud AS text) from $pi2 where id_item = $id_item"));

    if ($infoItemPec[1] == $infoItemPec[3]) {
        $usuario = traer_fila_row(query_db("select nombre_administrador,email from $g1 where us_id = $infoItemPec[1]"));
       // sendMail($usuario[1], $usuario[0], $asunto_msn, $conte_tex);
    } else {
        $usuario = traer_fila_row(query_db("select nombre_administrador,email from $g1 where us_id = $infoItemPec[1]"));
        $usuarioPreparador = traer_fila_row(query_db("select nombre_administrador,email from $g1 where us_id = $infoItemPec[3]"));
      /*  sendMail($usuario[1], $usuario[0], $asunto_msn, $conte_tex);
        sendMail($usuarioPreparador[1], $usuarioPreparador[0], $asunto_msn, $conte_tex);*/
    }

    $usuarioProfesional = traer_fila_row(query_db("select nombre_administrador,email from $g1 where us_id = $infoItemPec[2]"));
    $usuarioGerente = traer_fila_row(query_db("select nombre_administrador,email from $g1 where us_id = $infoItemPec[4]"));
	$usuarioGerente_item = traer_fila_row(query_db("select nombre_administrador,email from $g1 where us_id = $infoItemPec[1]"));


	if($quien_rechaza == "usuario"){
		
		$text_rechaza = "Les informamos que el usuario ".traer_nombre_muestra($_SESSION["id_us_session"], $g1,"nombre_administrador","us_id") ;
		}else{
			$sel_comite_num = traer_fila_row(query_db("select num1,num2,num3 from t3_comite where id_comite = ".$quien_rechaza));
			$text_rechaza = "Les informamos que el comite de contratos No ".numero_item_pecc($sel_comite_num[0], $sel_comite_num[1], $sel_comite_num[2]);
			}
		

    $conte_tex = $text_rechaza.", ha rechazado la solicitud ".numero_item_pecc($infoItemPec[5], $infoItemPec[6], $infoItemPec[7])." la cual tiene por objeto ".$infoItemPec[8];
    $asunto_msn = "INFORME RECHAZO DE SOLICITUD ";
	
	$conte_tex = $conte_tex."<br /> Por favor revisar en SGPA los detalles del rechazo o contactarse con el Equipo de Abastecimiento.<br /><br />Cordialmente <br />Equipo de Abastecimiento";
if($infoItemPec[2]>0 and $infoItemPec[2] !=""){
    sendMail($usuarioProfesional[1], $usuarioProfesional[0], $asunto_msn, $conte_tex);
}
if($infoItemPec[4]>0 and $infoItemPec[4] !="" and $infoItemPec[4] <> $infoItemPec[1]){
    sendMail($usuarioGerente[1], $usuarioGerente[0], $asunto_msn, $conte_tex);
}
if($infoItemPec[1]>0 and $infoItemPec[1] !=""){
	sendMail($usuarioGerente_item[1], $usuarioGerente_item[0], $asunto_msn, $conte_tex);
}
    
}

function sendMail($correo_destino, $nombre, $asunto_msn, $conte_tex) {
    global $correo_autentica_phpmailer, $contrasena_autentica_phpmailer, $servidor_phpmailer, $correo_from_phpmiler, $nombre_from_phpmiler;
    //Envio_email
//    $correo_destino = "leonardo.molina@enternova.net";

    $cuerpo = $conte_tex;
	
	echo "Correo Destino: ".$correo_destino."<br />";
    echo "Asunto: ".$asunto_msn."<br>";
    echo "Cuerpo del Mensaje: ".$cuerpo."<br /><br /><br />";
	
   /* $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = false;
    $mail->SMTPSecure = "";
    $mail->Port = 25;

    $mail->Username = $correo_autentica_phpmailer;
    $mail->Password = $contrasena_autentica_phpmailer;
    $mail->Host = $servidor_phpmailer;
    $mail->From = $correo_from_phpmiler;
    $mail->FromName = $nombre_from_phpmiler;
    $mail->Subject = $asunto_msn;
    $mail->AddAddress($correo_destino, $nombre);
    //$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
    //$mail->AddCC("ferney.sterling@enternova.net");
    $mail->AddBCC("sgpa-notificaciones@enternova.net"); //copia oculta
    //$mail->AddBCC($correo_dvrnet2);//copia oculta
    //$mail->AddAttachment("images/foto.jpg", "foto.jpg");
    //$mail->AddAttachment("files/demo.zip", "demo.zip");
    $mail->Body = $cuerpo;
    $mail->AltBody = "SGPA Informaciones";
    $mail->Send();
*/
    // FIN Envio_email
}


/* Fin Funciones para el envio de correos al rechazar firmas Solicitudes.*/
function faltaprofesionalcompras($id_item){
	$devuelve_falta="NO";
	global $pi2,$id_usuario_profesional;	
	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item));	
	
	if($sel_item[14]== 7){$permiso_ad=1;}
	if($sel_item[14]== 16){$permiso_ad=2;}
	
	$sel_secuencia = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item." and id_rol = 30 and tipo_adj_permiso = ".$permiso_ad." and estado = 1"));
	$sel_usuario = traer_fila_row(query_db("select id_usuario from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = ".$sel_secuencia[0]." and id_usuario =  ".$id_usuario_profesional));
	if($sel_secuencia[0]>0){
	$sel_aprobacion = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_secuencia[0]." and aprobado = 1"));
	}else{
		$sel_aprobacion[0]=1;
	}
	
	
	

	 if($sel_aprobacion[0]==0 and ($sel_item[14]==7 or $sel_item[14]==16) and $sel_item[6] <> 16){
		 $devuelve_falta="SI";
	 }
	 return $devuelve_falta;
	}
	
function esprofesionalcompras($id_item){
	$devuelve="NO";
	global $pi2,$id_usuario_profesional;	
	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item));	
	
	if($sel_item[14]== 7){$permiso_ad=1;}
	if($sel_item[14]== 16){$permiso_ad=2;}
	
	$sel_secuencia = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item." and id_rol = 50 and tipo_adj_permiso = ".$permiso_ad." and estado = 1"));
	$sel_usuario = traer_fila_row(query_db("select id_usuario from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = ".$sel_secuencia[0]." and id_usuario =".$_SESSION["id_us_session"]));
	$sel_aprobacion = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_secuencia[0]." and aprobado = 1"));
	

	 if($_SESSION["id_us_session"]==$sel_usuario[0] and $sel_aprobacion[0]==0 and ($sel_item[14]==7 or $sel_item[14]==16)){
		 $devuelve="SI";
	 }
	 return $devuelve;
	}

function saber_gerente_cotrato($id_item){
$gerente_contrato=0;	
global $pi8,$g15,$pi12,$co1,$pi2;
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item));	

if($sel_item[6]==5){	
	$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$sel_item[21]));		
	$gerente_contrato = $sel_si_es_gerente[0];
	}
if($sel_item[6]==7){
	
	$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));				
				
				$sel_contr = query_db("select t1.t7_contrato_id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
				$sel_apl = traer_fila_db($sel_contr);				
				$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$sel_apl[0]));	
				$gerente_contrato = $sel_si_es_gerente[0];			
	
}
if($sel_item[6]==8){
	
	
	$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));				
				$sel_contr = query_db("select t1.t7_contrato_id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
				$sel_apl = traer_fila_db($sel_contr);				
				$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$sel_apl[0]));
				$gerente_contrato = $sel_si_es_gerente[0];	
}

	return $gerente_contrato;
	}
function numero_item_pecc_contrato_antes_formato($letra, $fecha_crea, $consecutivo,$apellido, $id_contrato_apra_bios_ser){

					$numero_contrato1 = $letra;
					$separa_fecha_crea = explode("-",$fecha_crea);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $consecutivo;
					$numero_contrato4 = $apellido;
	
	return numero_item_pecc_contrato($numero_contrato1, $numero_contrato2, $numero_contrato3, $numero_contrato4, $id_contrato_apra_bios_ser);
	}

function contratos_relacionados_comite_solo_proveedores($id_item_para_relacionados,$permiso_o_adjudica){
	global $pi2,$vpeec18,$pi18,$g6, $pi8, $g15, $pi12, $co1;


	$sel_item_funttt = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada, num1, num2, num3, convirte_marco from $pi2 where id_item=".$id_item_para_relacionados));
	

	if($sel_item_funttt[3] == 4 or $sel_item_funttt[3] == 5 or $sel_item_funttt[3] == 11 or $sel_item_funttt[3] == 12 or $sel_item_funttt[3] == 13 or $sel_item_funttt[3] == 14){

		
		$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista, id from t7_contratos_contrato where id=".$sel_item_funttt[15]));
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[0];
					$numero_contrato4 = tipo_bien_servicio_con_contrato($sel_contrato[4]);
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					$imprime_contratista = $sel_contratista[0];
				
				/*SOLO PARA RECLASIFICACIONES*/
					if($sel_item_funttt[3] == 12 and $sel_item_funttt[22] == 3){
						$imprime_contratista = "";
					$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item_funttt[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco = 1");
		
		while($sel_presu = traer_fila_db($sele_presupuesto)){

		$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." order by t2.id asc");
			while($sel_apl = traer_fila_db($sel_contr)){
				
				if($id_contra_bandera == ""){
					$id_contra_bandera=$sel_apl[4];
					$entra_bandera = 1;
					}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
								}else{
									$entra_bandera = 2;
									}
						}
					
					
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					if($entra_bandera == 1){
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));
					//$caontras_rel.= "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4])." </strong> ".$sel_contratista[0]." ";
					$imprime_contratista.= "* ".$sel_contratista[0]." ";
					}
			}
		}
					}
					/*fin SOLO PARA RECLASIFICACIONES*/	
					
					echo $imprime_contratista;
					
		//
	
	
	}elseif($sel_item_funttt[3] == 7 or $sel_item_funttt[3] == 8){
		echo contratos_relacionados_solicitud_para_campos_solo_proveedores($sel_item_funttt[0]);
		
		}elseif(($sel_item_funttt[3] == 1 or $sel_item_funttt[3] == 2 or $sel_item_funttt[3] == 3 or $sel_item_funttt[3] == 6) and $permiso_o_adjudica == 2){

	$sele_presupuesto = query_db("select razon_social  from $vpeec18 where t2_item_pecc_id ='".$sel_item_funttt[0]."' group by razon_social");
			 $tiene_contratos_normales = "NO";
			  $algun_contra="NO";
			 while($sel_presu = traer_fila_db($sele_presupuesto)){
			 
			 if($sel_presu[0]<>"" and $sel_presu[0]<>" " and $sel_presu[0] <>"  "){
			 echo " * ".$sel_presu[0];
			  $algun_contra="SI";
			 }
			 
			 $tiene_contratos_normales = "SI";
			 }
			 
			 if($tiene_contratos_normales == "NO"){
			 $sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$sel_item_funttt[0]."' and t1.t1_proveedor_id =  t2.t1_proveedor_id group by t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id");
			 
			  while($sel_presu = traer_fila_db($sele_presupuesto)){
			 echo " * ".$sel_presu[1];
			 $algun_contra="SI";
			 }
			 }
			}elseif(($sel_item_funttt[3] == 1 or $sel_item_funttt[3] == 2 or $sel_item_funttt[3] == 3 or $sel_item_funttt[3] == 6 or $sel_item_funttt[3] == 10 or $sel_item_funttt[3] == 9) and $permiso_o_adjudica == 1){
			
			
				$sel_proveedore_permiso = query_db("select t2.razon_social from t2_relacion_proveedor as t1, t1_proveedor as t2 where t1.id_item = ".$sel_item_funttt[0]." and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1 and t1.estado = 1 group by t2.razon_social");
				$provee_permi = "";
				while($sel_pro_permiso = traer_fila_db($sel_proveedore_permiso)){
						$provee_permi.=" * ".$sel_pro_permiso[0];
					}
					
				if($provee_permi == ""){
					$provee_permi = $sel_item_funttt[16];
					}
				echo $provee_permi;
				
				
			}elseif($sel_item_funttt[3] == 10 or $sel_item_funttt[3] == 9){
				
				$sel_proveedore_permiso = query_db("select t2.razon_social from t2_relacion_proveedor as t1, t1_proveedor as t2 where t1.id_item = ".$sel_item_funttt[0]." and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1 and t1.estado = 1 group by t2.razon_social");
				$provee_permi = "";
				while($sel_pro_permiso = traer_fila_db($sel_proveedore_permiso)){
						$provee_permi.=" * ".$sel_pro_permiso[0];
					}
					
				if($provee_permi == ""){
					$provee_permi = $sel_item_funttt[16];
					}
				echo $provee_permi;
				
			}else{
			echo "N/A";
			}
			
			if($algun_contra=="NO"){
				echo "N/A";
				}
	}
function vencimieno_contratos($id_item_para_relacionados,$permiso_o_adjudica, $id_item_para_relacionados_actual){
	
	
	global $pi2,$vpeec18,$pi18,$g6, $pi8, $g15, $pi12, $co1;
	$imprimir_de_funcion = "";
	
	$sel_item_funttt_item_actual = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada, num1, num2, num3, convirte_marco from $pi2 where id_item=".$id_item_para_relacionados_actual));
	if($sel_item_funttt_item_actual[3] == 12){
		$id_item_para_relacionados = $id_item_para_relacionados_actual;//si es una reclasificacion no tome la solicitusd relacionada, lo correcto es que tome la solicitud actuial
	}
	
	$sel_item_funttt = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada, num1, num2, num3, convirte_marco from $pi2 where id_item=".$id_item_para_relacionados));
	

	if($sel_item_funttt[3] == 4 or $sel_item_funttt[3] == 5 or $sel_item_funttt[3] == 11 or $sel_item_funttt[3] == 12 or $sel_item_funttt[3] == 13 or $sel_item_funttt[3] == 14){

		
		$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista, vigencia_mes from t7_contratos_contrato where id=".$sel_item_funttt[15]));
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[0];
					$numero_contrato4 = $sel_contrato[2];
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					
					 $imprimir_de_funcion.= " Fecha terminaci&oacute;n ".$sel_contrato[4];
				
				/*SOLO PARA RECLASIFICACIONES*/
					if($sel_item_funttt[3] == 12 and $sel_item_funttt[22] == 3){
						$imprimir_de_funcion = "";

					$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item_funttt[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco = 1");
		
		while($sel_presu = traer_fila_db($sele_presupuesto)){

		$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id,t2.vigencia_mes from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." order by t2.id asc");
			while($sel_apl = traer_fila_db($sel_contr)){
				
				if($id_contra_bandera == ""){
					$id_contra_bandera=$sel_apl[4];
					$entra_bandera = 1;
					}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
								}else{
									$entra_bandera = 2;
									}
						}
					
					
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					if($entra_bandera == 1){
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));
					$imprimir_de_funcion.= " * ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4])."  "." Fecha terminaci&oacute;n ".$sel_contrato[4];
					
					}
			}
		}
					}
					/*fin SOLO PARA RECLASIFICACIONES*/		
					
		//
	
	
	}elseif($sel_item_funttt[3] == 7 or $sel_item_funttt[3] == 8){
		 $imprimir_de_funcion.=  contratos_relacionados_solicitud_para_campos_solo_contratos($sel_item_funttt[0]);
		
		}elseif(($sel_item_funttt[3] == 1 or $sel_item_funttt[3] == 2 or $sel_item_funttt[3] == 3 or $sel_item_funttt[3] == 6) and $permiso_o_adjudica == 2){

	$sele_presupuesto = query_db("select razon_social  from $vpeec18 where t2_item_pecc_id ='".$sel_item_funttt[0]."' group by razon_social");
			 $tiene_contratos_normales = "NO";
			 $algun_contra="NO";
			 while($sel_presu = traer_fila_db($sele_presupuesto)){
			 if($sel_presu[0]<>"" and $sel_presu[0]<>" " and $sel_presu[0]<>" "){
			  $imprimir_de_funcion.= " * ".$sel_presu[0];
			 $algun_contra="SI";
		}
			 
			 $tiene_contratos_normales = "SI";
			 }
			 
			 if($tiene_contratos_normales == "NO"){
			 $sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$sel_item_funttt[0]."' and t1.t1_proveedor_id =  t2.t1_proveedor_id group by t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id");
			 
			  while($sel_presu = traer_fila_db($sele_presupuesto)){
			  $imprimir_de_funcion.=  " * ".$sel_presu[1];
			 $algun_contra="SI";
			 }
			 }
			}elseif(($sel_item_funttt[3] == 1 or $sel_item_funttt[3] == 2 or $sel_item_funttt[3] == 3 or $sel_item_funttt[3] == 6 or $sel_item_funttt[3] == 10 or $sel_item_funttt[3] == 9) and $permiso_o_adjudica == 1){
			
			 $imprimir_de_funcion.=  " N/A ";
				
				
			}elseif($sel_item_funttt[3] == 10 or $sel_item_funttt[3] == 9){
				
				 $imprimir_de_funcion.=  " N/A ";
				
			}else{
			 $imprimir_de_funcion.=  " N/A ";
			}
			
			if($algun_contra=="NO"){
			 $imprimir_de_funcion.=  " N/A ";
				}
				
				return $imprimir_de_funcion;
	
	}
function contratos_relacionados_comite_solo_contratos($id_item_para_relacionados,$permiso_o_adjudica, $id_item_para_relacionados_actual){
	
	global $pi2,$vpeec18,$pi18,$g6, $pi8, $g15, $pi12, $co1;
	$imprimir_de_funcion = "";
	
	$sel_item_funttt_item_actual = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada, num1, num2, num3, convirte_marco from $pi2 where id_item=".$id_item_para_relacionados_actual));
	if($sel_item_funttt_item_actual[3] == 12){
		$id_item_para_relacionados = $id_item_para_relacionados_actual;//si es una reclasificacion no tome la solicitusd relacionada, lo correcto es que tome la solicitud actuial
	}
	
	$sel_item_funttt = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada, num1, num2, num3, convirte_marco from $pi2 where id_item=".$id_item_para_relacionados));
	

	if($sel_item_funttt[3] == 4 or $sel_item_funttt[3] == 5 or $sel_item_funttt[3] == 11 or $sel_item_funttt[3] == 12 or $sel_item_funttt[3] == 13 or $sel_item_funttt[3] == 14){

		
		$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista, vigencia_mes from t7_contratos_contrato where id=".$sel_item_funttt[15]));
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[0];
					$numero_contrato4 = $sel_contrato[2];
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					
					 $imprimir_de_funcion.= numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_item_funttt[15])." Fecha terminaci&oacute;n ".$sel_contrato[4];
				
				/*SOLO PARA RECLASIFICACIONES*/
					if($sel_item_funttt[3] == 12 and $sel_item_funttt[22] == 3){
						$imprimir_de_funcion = "";

					$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item_funttt[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco = 1");
					
		
		while($sel_presu = traer_fila_db($sele_presupuesto)){

		$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id,t2.vigencia_mes from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." order by t2.id asc");
			while($sel_apl = traer_fila_db($sel_contr)){
				
				if($id_contra_bandera == ""){
					$id_contra_bandera=$sel_apl[4];
					$entra_bandera = 1;
					}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
								}else{
									$entra_bandera = 2;
									}
						}
					
					
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					if($entra_bandera == 1){
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));
					$imprimir_de_funcion.= " * ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4])."  "." Fecha terminaci&oacute;n ".$sel_contrato[4];
					
					}
			}
		}
					}
					/*fin SOLO PARA RECLASIFICACIONES*/		
					
		//
	
	
	}elseif($sel_item_funttt[3] == 7 or $sel_item_funttt[3] == 8){
		 $imprimir_de_funcion.=  contratos_relacionados_solicitud_para_campos_solo_contratos($sel_item_funttt[0]);
		
		}elseif(($sel_item_funttt[3] == 1 or $sel_item_funttt[3] == 2 or $sel_item_funttt[3] == 3 or $sel_item_funttt[3] == 6) and $permiso_o_adjudica == 2){

	$sele_presupuesto = query_db("select razon_social  from $vpeec18 where t2_item_pecc_id ='".$sel_item_funttt[0]."' group by razon_social");
			 $tiene_contratos_normales = "NO";
			 $algun_contra="NO";
			 while($sel_presu = traer_fila_db($sele_presupuesto)){
			 if($sel_presu[0]<>"" and $sel_presu[0]<>" " and $sel_presu[0]<>" "){
			  $imprimir_de_funcion.= " * ".$sel_presu[0];
			 $algun_contra="SI";
		}
			 
			 $tiene_contratos_normales = "SI";
			 }
			 
			 if($tiene_contratos_normales == "NO"){
			 $sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$sel_item_funttt[0]."' and t1.t1_proveedor_id =  t2.t1_proveedor_id group by t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id");
			 
			  while($sel_presu = traer_fila_db($sele_presupuesto)){
			  $imprimir_de_funcion.=  " * ".$sel_presu[1];
			 $algun_contra="SI";
			 }
			 }
			}elseif(($sel_item_funttt[3] == 1 or $sel_item_funttt[3] == 2 or $sel_item_funttt[3] == 3 or $sel_item_funttt[3] == 6 or $sel_item_funttt[3] == 10 or $sel_item_funttt[3] == 9) and $permiso_o_adjudica == 1){
			
			 $imprimir_de_funcion.=  " N/A ";
				
				
			}elseif($sel_item_funttt[3] == 10 or $sel_item_funttt[3] == 9){
				
				 $imprimir_de_funcion.=  " N/A ";
				
			}else{
			 $imprimir_de_funcion.=  " N/A ";
			}
			
			if($algun_contra=="NO"){
			 $imprimir_de_funcion.=  " N/A ";
				}
				
				return $imprimir_de_funcion;
	}
	
	
	
function contratos_relacionados_comite($id_item_para_relacionados,$permiso_o_adjudica){
	global $pi2,$vpeec18,$pi18,$g6;
	$sel_item_funttt = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada, num1, num2, num3 from $pi2 where id_item=".$id_item_para_relacionados));
	

	if($sel_item_funttt[3] == 4 or $sel_item_funttt[3] == 5 or $sel_item_funttt[3] == 11 or $sel_item_funttt[3] == 12 or $sel_item_funttt[3] == 13 or $sel_item_funttt[3] == 14){

		
		$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista from t7_contratos_contrato where id=".$sel_item_funttt[15]));
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[0];
					$numero_contrato4 = $sel_contrato[2];
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_item_funttt[15])." ".$sel_contratista[0];
		
					
		//
	
	
	}elseif($sel_item_funttt[3] == 7 or $sel_item_funttt[3] == 8){
		echo contratos_relacionados_solicitud_para_campos($sel_item_funttt[0]);
		
		}elseif(($sel_item_funttt[3] == 1 or $sel_item_funttt[3] == 2 or $sel_item_funttt[3] == 3 or $sel_item_funttt[3] == 6) and $permiso_o_adjudica == 2){

	$sele_presupuesto = query_db("select razon_social  from $vpeec18 where t2_item_pecc_id ='".$sel_item_funttt[0]."' group by razon_social");
			 $tiene_contratos_normales = "NO";
			 while($sel_presu = traer_fila_db($sele_presupuesto)){
			 echo " * ".$sel_presu[0];
			 $tiene_contratos_normales = "SI";
			 }
			 
			 if($tiene_contratos_normales == "NO"){
			 $sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$sel_item_funttt[0]."' and t1.t1_proveedor_id =  t2.t1_proveedor_id group by t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id");
			 
			  while($sel_presu = traer_fila_db($sele_presupuesto)){
			 echo " * ".$sel_presu[1];
			 }
			 }
			}elseif(($sel_item_funttt[3] == 1 or $sel_item_funttt[3] == 2 or $sel_item_funttt[3] == 3 or $sel_item_funttt[3] == 6 or $sel_item_funttt[3] == 10 or $sel_item_funttt[3] == 9) and $permiso_o_adjudica == 1){
			
			
				$sel_proveedore_permiso = query_db("select t2.razon_social from t2_relacion_proveedor as t1, t1_proveedor as t2 where t1.id_item = ".$sel_item_funttt[0]." and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1 and t1.estado = 1 group by t2.razon_social");
				$provee_permi = "";
				while($sel_pro_permiso = traer_fila_db($sel_proveedore_permiso)){
						$provee_permi.=" * ".$sel_pro_permiso[0];
					}
					
				if($provee_permi == ""){
					$provee_permi = $sel_item_funttt[16];
					}
				echo $provee_permi;
				
				
			}elseif($sel_item_funttt[3] == 10 or $sel_item_funttt[3] == 9){
				
				$sel_proveedore_permiso = query_db("select t2.razon_social from t2_relacion_proveedor as t1, t1_proveedor as t2 where t1.id_item = ".$sel_item_funttt[0]." and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1 and t1.estado = 1 group by t2.razon_social");
				$provee_permi = "";
				while($sel_pro_permiso = traer_fila_db($sel_proveedore_permiso)){
						$provee_permi.=" * ".$sel_pro_permiso[0];
					}
					
				if($provee_permi == ""){
					$provee_permi = $sel_item_funttt[16];
					}
				echo $provee_permi;
				
			}else{
			echo "N/A";
			}
	}
	
	
function imprime_texo_a_js($valor){
		$id_subastas_arrglo = str_replace("'", "", $valor );
		$id_subastas_arrglo = ereg_replace( "&aacute;", "\u00e1", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Aacute;", "\u00c1 ", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&eacute;", "\u00e9",$id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Eacute;", "\u00c9", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&iacute;", "\u00ed",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Iacute;", "\u00cd",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&oacute;", "\u00f3", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Oacute;", "\u00d3",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&uacute;",  "\u00fa",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Uacute;",  "\u00da", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&ntilde;",  "\u00f1", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Ntilde;", "\u00d1", $id_subastas_arrglo ); 
		
		$id_subastas_arrglo = ereg_replace( "ü", "\u00FC", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Ü", "\u00DC", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "ç", "\u00E7", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Ç", "\u00C7", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "¿", "\u00BF", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "¡", "\u00A1", $id_subastas_arrglo ); 
		
		 $content = $id_subastas_arrglo;
    $sustituye = array("\r\n", "\n\r", "\n", "\r");
    $content = str_replace($sustituye, " ", $content);  
		
		return $content;
}


function nivel_aprobacion_solicitud_solo_usuario($id_item_pecc, $ad_permiso){
	global $g1;
	$sel_repor = query_db("select * from reporte_general_1 where id_item = $id_item_pecc $comple_sql");
  while($sel_r = traer_fila_db($sel_repor)){
	  $numero_consecut = numero_item_pecc($sel_r[1],$sel_r[2],$sel_r[3]);
		
		$id_item_while = $sel_r[0];
		$estado_item_while = $sel_r[20];
		
	
		
		$nivel_aprueba_ad = "";
		$usuario_aprueba_ad="";
		
		
		if($estado_item_while > 14 and $estado_item_while <> 31 and $estado_item_while <> 33){// aprobacion adjudicacion
		
		$sel_aprobacion_permiso_socios = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 11"));  
			if($sel_aprobacion_permiso_socios[0]>0){
			//$nivel_aprueba_ad = "Socios";
			$usuario_aprueba_ad=$sel_aprobacion_permiso_socios[0];	
			//$fecha_aprueba = $sel_aprobacion_permiso_socios[1];
			}
		if($nivel_aprueba_ad == ""){
			
		$sel_aprobacion_permiso_comite = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.observacion, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 10"));  
			if($sel_aprobacion_permiso_comite[0]!= ""){
			$nivel_aprueba_ad = "Comit&eacute;";
			$usuario_aprueba_ad=$sel_aprobacion_permiso_comite[0];
			$fecha_aprueba = $sel_aprobacion_permiso_comite[1];		
			}
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 20"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = "Vicepresidente";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_vicepre[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 43"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = "Director";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_vicepre[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 48"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = "Presidente";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_vicepre[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_jefe_area = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 9"));  
			if($sel_aprobacion_permiso_jefe_area[0]>0){
			$nivel_aprueba_ad = "Gerente de Area";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_jefe_area[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_jefe_area[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol in (35, 45)"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_ad = "Jefatura";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_superintendente[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		
		if($nivel_aprueba_ad == ""){
			$nivel_aprueba_ad ="N/A";
			$usuario_aprueba_ad="N/A";
		}
		
			

		}//FIN APROBACION DE adjudicacion
  }//fin while
  
  
if($ad_permiso == "adjudicacion"){
	  	return $nivel_aprueba_ad." - ".$usuario_aprueba_ad." - ".$fecha_aprueba;

		
	  }
	}
function nivel_aprobacion_solicitud($id_item_pecc, $ad_permiso){
	global $g1;
	
	$sel_repor = query_db("select * from reporte_general_1 where id_item = $id_item_pecc $comple_sql");
  while($sel_r = traer_fila_db($sel_repor)){
	  $numero_consecut = numero_item_pecc($sel_r[1],$sel_r[2],$sel_r[3]);
		
		$id_item_while = $sel_r[0];
		$estado_item_while = $sel_r[20];
		
	
		
		$nivel_aprueba_ad = "";
		$usuario_aprueba_ad="";
		
		
		if($estado_item_while > 14 and $estado_item_while <> 31){// aprobacion adjudicacion
		
		$sel_aprobacion_permiso_socios = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 11"));  
			if($sel_aprobacion_permiso_socios[0]>0){
			$nivel_aprueba_ad = "Socios";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_socios[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_socios[1];
			}
		if($nivel_aprueba_ad == ""){
			
		$sel_aprobacion_permiso_comite = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.observacion, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 10"));  
			if($sel_aprobacion_permiso_comite[0]!= ""){
			$nivel_aprueba_ad = "Comit&eacute;";
			$usuario_aprueba_ad=$sel_aprobacion_permiso_comite[0];
			$fecha_aprueba = $sel_aprobacion_permiso_comite[1];		
			}
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 20"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = "II. Vicepresidente";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_vicepre[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 43"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = "II. Director";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_vicepre[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 48"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = "I. Presidente";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_vicepre[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_jefe_area = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 9"));  
			if($sel_aprobacion_permiso_jefe_area[0]>0){
			$nivel_aprueba_ad = "III. Gerente de Área";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_jefe_area[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_jefe_area[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol in (35, 45)"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_ad = "IV. Jefatura";
			$usuario_aprueba_ad=traer_nombre_muestra($sel_aprobacion_permiso_superintendente[0], $g1,"nombre_administrador","us_id");	
			$fecha_aprueba = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		
		if($nivel_aprueba_ad == ""){
			$nivel_aprueba_ad ="";
			$usuario_aprueba_ad="";
		}
		
			

		}//FIN APROBACION DE adjudicacion
	  
	    if($nivel_aprueba_ad =="" and ($sel_r[20] == 7 or $sel_r[20] == 16)){//si aun no esta aprobado, no se tiene el nivele de aprobacion final, por lo que con este if se consulta en la tabla de los pendientes de aprobacion o que aun no han aprobado.
	  if($sel_r[20] == 7){
		  $perm_ad = 1;		  
	  }
	  if($sel_r[20] == 16){
		  $perm_ad = 2;		  
	  }
			
			
	  $sel_max_nivel = query_db("select id_rol, id_usuario_original, rol,us_id from v_peec_agl_real_item where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso=".$perm_ad." and id_rol in (9, 20, 43, 48) and estado = 1 order by id_rol");
	  while($sel_niveles = traer_fila_db($sel_max_nivel)){
		   	  	$nivel_aprueba_ad =$sel_niveles[2];
		  		if($sel_niveles[1]>0){
				$usuario_aprueba_ad=traer_nombre_muestra($sel_niveles[1], $g1,"nombre_administrador","us_id");		  
	  			}else{
					$usuario_aprueba_ad=traer_nombre_muestra($sel_niveles[3], $g1,"nombre_administrador","us_id");		  
				}
		  		$fecha_aprueba ="0000-00-00";
		}
	  if($nivel_aprueba_ad ==""){//consulta las jefaturas
		  $sel_max_nivel_jefatura = traer_fila_row(query_db("select id_rol, id_usuario_original, rol,us_id from v_peec_agl_real_item where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso=".$perm_ad." and id_rol =45  and estado = 1 order by id_rol"));
		  	$nivel_aprueba_ad =$sel_max_nivel_jefatura[2];
			if($sel_niveles[1]>0){
				$usuario_aprueba_ad=traer_nombre_muestra($sel_max_nivel_jefatura[1], $g1,"nombre_administrador","us_id");		  
	  			}else{
					$usuario_aprueba_ad=traer_nombre_muestra($sel_max_nivel_jefatura[3], $g1,"nombre_administrador","us_id");		  
				}
		  	$fecha_aprueba ="0000-00-00";
		  
	  }
	  
	  
  }
  }//fin while
  
	

	
if($ad_permiso == "adjudicacion"){
	  	return $nivel_aprueba_ad." - ".$usuario_aprueba_ad." - ".$fecha_aprueba;

		
	  }
	}

function traer_nombre_muestra_log($id, $tabla){
	global $v_contra1;
			if($tabla == "t1_us_usuarios"){
				$campo_nombre="nombre_administrador";
				$campo_id="us_id";
				}
			if($tabla == "t1_tipo_proceso"){
				$campo_nombre="nombre";
				$campo_id="t1_tipo_proceso_id";
				}
			if($tabla == "t1_area"){
				$campo_nombre="nombre";
				$campo_id="t1_area_id";
				}
			if($tabla == "t1_proveedor"){
				$campo_nombre="razon_social";
				$campo_id="t1_proveedor_id";
				}
			if($tabla == "tseg2_permisos"){
				$campo_nombre="nombre";
				$campo_id="id_premiso";
				}
			if($tabla == "t6_tarifas_listas_lista"){
				$campo_nombre="nombre";
				$campo_id="t6_tarifas_listas_lista_id";
				}
			if($tabla == "t1_tipo_documento"){
				$campo_nombre="nombre";
				$campo_id="t1_tipo_documento_id";
				}
			
			
			
				
			if($tabla == "t1_tipo_area_ejecucion" or $tabla == "t1_tipo_poliza" or $tabla == "t1_tipo_aseguradora" or $tabla == "t1_tipo_complemento" or $tabla == "t1_tipo_otro_si" or $tabla == "t1_tipo_contacto" or $tabla == "t1_tipo_archivo"){
				$campo_nombre="nombre";
				$campo_id="id";
				}
			if($tabla == "t7_contratos_complemento"){
				$campo_nombre="numero_otrosi";
				$campo_id="id";
				}
			if($tabla == "t1_moneda"){
				$campo_nombre="nombre";
				$campo_id="t1_moneda_id";
				}
				if($campo_id <> ""){
				$select_usu = traer_fila_row(query_db("select ".$campo_nombre." from ".$tabla." where ".$campo_id." =".$id));
				return $select_usu[0];
				}
				
				
				$numero_item="";
					if($tabla == "t2_item_pecc"){
					$select_usu_item= query_db("select id_item , num1, num2, num3 from t2_item_pecc where id_item in ($id)");
					while($sel_it= traer_fila_db($select_usu_item)){
						
						
						$numero_item.= numero_item_pecc($sel_it[1],$sel_it[2], $sel_it[3]);
							
						}
				
				
					return $numero_item;

				}
				
					
					$numero_contrato="";
					if($tabla == "t7_contratos_contrato"){
					$select_usu_contras = query_db("select id , razon_social, nit, numero_contrato, apellido, consecutivo,ano from $v_contra1 where id in ($id)");
					while($sel_cont = traer_fila_db($select_usu_contras)){
						
						
						$numero_contrato.= numero_item_pecc_contrato("C",$sel_cont[6],$sel_cont[5], $sel_cont[4], $sel_cont[0]);
							
						}
				
				
					return $numero_contrato;

				}
				
				
	}
	
	//$modulo "tabla modulo", $tipo_log "tabla tipo log", $tipo_log_sub_ventana "tabla log tipo sub ventana" , $id_proceso "id del proceso solicitud contrato urna etc", $estado_proceso_actual " si palica estado actual", $estado_proceso_queda "Si aplica estado nuevo"
function log_de_procesos_sgpa($modulo, $tipo_log, $tipo_log_sub_ventana, $id_proceso, $estado_proceso_actual, $estado_proceso_queda){
$fecha_log = date("Y-m-d");
$hora_log = date("G:i:s");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

	$insert = "insert into tseg8_log (id_tipo_log, id_tipo_log_sub_ventana, id_proceso, estado_actual_proceso, estado_resultado, id_us, fecha, hora_seg) values ($tipo_log, $tipo_log_sub_ventana,$id_proceso, '$estado_proceso_actual', '$estado_proceso_queda', ".$_SESSION["id_us_session"].", '".$fecha_log."', '".$hora_log."')";
	//echo $insert;
	
$sql_ex=query_db($insert.$trae_id_insrte);
	  $id_log = id_insert($sql_ex);
	  
return $id_log;	
	}
	
function log_agrega_detalle ($id_log, $campo_imprime, $detalle, $tabla_id, $orden){

		$insert = query_db("insert into tseg9_log_detalle (id_log, campo_imprime, detalle, tabla_id, orden) values ($id_log, '$campo_imprime', '$detalle', '$tabla_id', $orden)");
	}
	
function contratos_relacionados_solicitud_para_campos_solo_proveedores($id_item, $muestra_con_coma){
	global $pi2,$pi18, $g6, $g15,$pi8,$vpeec18,$pi12,$co1;
	$sel_item_functio = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id from $pi2 where id_item=".$id_item));
	

	$caontras_rel = "";
	
    if($sel_item_functio[3] == 4 or $sel_item_functio[3] == 5 or $sel_item_functio[3] == 11 or $sel_item_functio[3] == 12 or $sel_item_functio[3] == 13 or $sel_item_functio[3] == 14){
		
		$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista from t7_contratos_contrato where id=".$sel_item_functio[15]));
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[0];
					$numero_contrato4 = $sel_contrato[2];
					
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_item_functio[15]);
					if($num_impri == "C-"){
						$num_impri="";
						}
					
					$caontras_rel.= "* <strong>".$num_impri." </strong>".$sel_contratista[0];
					
					
		//
	}elseif($sel_item_functio[3] == 7 or $sel_item_functio[3] == 8){
		
		$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
		
		while($sel_presu = traer_fila_db($sele_presupuesto)){
		$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." order by t2.id asc");
		$primera_coma = 0;
			while($sel_apl = traer_fila_db($sel_contr)){
				
				if($id_contra_bandera == ""){
					$id_contra_bandera=$sel_apl[4];
					$entra_bandera = 1;
					}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
								}else{
									$entra_bandera = 2;
									}
						}
					
					
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					
					$fecha_termi = "";
					$separador = "* ";
					
					
					if($muestra_con_coma=="NO"){
						$separador = ", ";
							if($primera_coma ==0){
								$separador = "";
								$primera_coma = 1;
								}						
						}
					if($entra_bandera == 1){
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));
					$caontras_rel.= $separador.$sel_contratista[0]." ";
					}
			}
		}
			
		}elseif(($sel_item_functio[3] == 1 or $sel_item_functio[3] == 2 or $sel_item_functio[3] == 3 or $sel_item_functio[3] == 6) and $sel_item_functio[2] > 17){
			
	
			$sel_contrato = query_db("select consecutivo,creacion_sistema, apellido,contratista, id from t7_contratos_contrato where id_item=".$sel_item_functio[0]);
			
			while($sel_contra_rel = traer_fila_db($sel_contrato)){
				
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contra_rel[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contra_rel[0];
					$numero_contrato4 = $sel_contra_rel[2];
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contra_rel[3]));
					
					$caontras_rel.= "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra_rel[4])." </strong>".$sel_contratista[0]."";
			}
			
			}else{
			
			}
			
			return $caontras_rel;
	}
	
function contratos_relacionados_solicitud_para_campos_solo_contratos($id_item, $muestra_fecha_vence){

	global $pi2,$pi18, $g6, $g15,$pi8,$vpeec18,$pi12,$co1;
	$sel_item_functio = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id from $pi2 where id_item=".$id_item));
	


	$caontras_rel = "";
	
    if($sel_item_functio[3] == 4 or $sel_item_functio[3] == 5 or $sel_item_functio[3] == 11 or $sel_item_functio[3] == 12 or $sel_item_functio[3] == 13 or $sel_item_functio[3] == 14){
		
		$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista, vigencia_mes, id from t7_contratos_contrato where id=".$sel_item_functio[15]));
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[0];
					$numero_contrato4 = $sel_contrato[2];
					
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contrato[5]);
					if($num_impri == "C-"){
						$num_impri="";
						}
					
					$caontras_rel.= "* <strong>".$num_impri." </strong>".$sel_contratista[0];
					
					
		//
	}elseif($sel_item_functio[3] == 7 or $sel_item_functio[3] == 8){
		
		$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
		

		
		while($sel_presu = traer_fila_db($sele_presupuesto)){
		$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id, t2.vigencia_mes from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." order by t2.id asc");
			while($sel_apl = traer_fila_db($sel_contr)){
				
				if($id_contra_bandera == ""){
					$id_contra_bandera=$sel_apl[4];
					$entra_bandera = 1;
					}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
								}else{
									$entra_bandera = 2;
									}
						}
					
					
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					if($entra_bandera == 1){
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));

					//$caontras_rel.= "* ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4])." Fecha terminaci&oacute;n ".$sel_apl[5];
					$fecha_termi = "";
					$separador = " ";
					if($muestra_fecha_vence==""){
						$fecha_termi = " Fecha terminaci&oacute;n ".$sel_apl[5];
						$separador = " * ";
						}
					$caontras_rel.= $separador.numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4]).$fecha_termi;
					}
			}
		}
			
		}elseif(($sel_item_functio[3] == 1 or $sel_item_functio[3] == 2 or $sel_item_functio[3] == 3 or $sel_item_functio[3] == 6) and $sel_item_functio[2] > 17){
			

			$sel_contrato = query_db("select consecutivo,creacion_sistema, apellido,contratista, id from t7_contratos_contrato where id_item=".$sel_item_functio[0]);
			
			while($sel_contra_rel = traer_fila_db($sel_contrato)){
				
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contra_rel[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contra_rel[0];
					$numero_contrato4 = $sel_contra_rel[2];
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contra_rel[3]));
					
					$caontras_rel.= "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra_rel[4])." </strong>".$sel_contratista[0]."";
			}
			
			}else{
			
			}
			
			return $caontras_rel;
	}
	
function contratos_relacionados_solicitud_para_campos($id_item){
	
	global $pi2,$pi18, $g6, $g15,$pi8,$vpeec18,$pi12,$co1;
	$sel_item_functio = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id from $pi2 where id_item=".$id_item));
	

	$caontras_rel = "";
	
    if($sel_item_functio[3] == 4 or $sel_item_functio[3] == 5 or $sel_item_functio[3] == 11 or $sel_item_functio[3] == 12 or $sel_item_functio[3] == 13 or $sel_item_functio[3] == 14){
		
		$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista, estado from t7_contratos_contrato where id=".$sel_item_functio[15]));
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[0];
					$numero_contrato4 = $sel_contrato[2];
					$estado_eliminado="";
					if($sel_contrato[4]==50){
						$estado_eliminado = "<strong>Eliminado</strong>";
						}
					
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_item_functio[15]);
					if($num_impri == "C-"){
						$num_impri="";
						}
					
					$caontras_rel.= "* <strong>".$num_impri." </strong>".$sel_contratista[0]." ".$estado_eliminado;
					
					/*SOLO PARA RECLASIFICACIONES*/
					if($sel_item_functio[3] == 12){
					$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco = 1");
		
		while($sel_presu = traer_fila_db($sele_presupuesto)){
		$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." and t2.id <> ".$sel_item_functio[15]." order by t2.id asc");
			while($sel_apl = traer_fila_db($sel_contr)){
				
				if($id_contra_bandera == ""){
					$id_contra_bandera=$sel_apl[4];
					$entra_bandera = 1;
					}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
								}else{
									$entra_bandera = 2;
									}
						}
					
					
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					if($entra_bandera == 1){
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));
					$caontras_rel.= "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4])." </strong> ".$sel_contratista[0]." ";
					}
			}
		}
					}
					/*fin SOLO PARA RECLASIFICACIONES*/
					
					
		//
	}elseif($sel_item_functio[3] == 15){
			
			$sel_contrato = query_db("select consecutivo,creacion_sistema, apellido,contratista, estado, id from t7_contratos_contrato where id_item=".$sel_item_functio[0]);
			
			while($sel_contra_rel = traer_fila_db($sel_contrato)){
				
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contra_rel[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contra_rel[0];
					$numero_contrato4 = $sel_contra_rel[2];
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contra_rel[3]));
					$estado_eliminado="";
					if($sel_contra_rel[4]==50){
						$estado_eliminado = "<strong> - Eliminado</strong>";
						}
					
					$caontras_rel.= "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra_rel[5])."".$estado_eliminado." </strong>".$sel_contratista[0]."";
			}
			 	
		
		
		}elseif($sel_item_functio[3] == 7 or $sel_item_functio[3] == 8){
		
		
		
		$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
		if($id_contras == ""){
		$id_contras = "0";
		}
		while($sel_presu = traer_fila_db($sele_presupuesto)){
		
		$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." and t2.id not in ($id_contras) group by t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id order by t2.id asc");
		
		//if($_SESSION["id_us_session"] == 32 ){ echo "select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." and t2.id not in ($id_contras) group by t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id order by t2.id asc";}
		
			while($sel_apl = traer_fila_db($sel_contr)){
				
				
				$id_contras = $id_contras.",".$sel_apl[4];
				
				if($id_contra_bandera == ""){
					$id_contra_bandera=$sel_apl[4];
					$entra_bandera = 1;
					}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
								}else{
									$entra_bandera = 2;
									}
						}
					
					
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					if($entra_bandera == 1){
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));
					$caontras_rel.= "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4])." </strong> ".$sel_contratista[0]." ";
					}
			}
		}
			
		}elseif(($sel_item_functio[3] == 1 or $sel_item_functio[3] == 2 or $sel_item_functio[3] == 3 or $sel_item_functio[3] == 6) and $sel_item_functio[2] > 17){
			
	
			$sel_contrato = query_db("select consecutivo,creacion_sistema, apellido,contratista, estado, id from t7_contratos_contrato where id_item=".$sel_item_functio[0]." and estado <> 50");
			
			while($sel_contra_rel = traer_fila_db($sel_contrato)){
				
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contra_rel[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contra_rel[0];
					$numero_contrato4 = $sel_contra_rel[2];
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contra_rel[3]));
					$estado_eliminado="";
					if($sel_contra_rel[4]==50){
						$estado_eliminado = "<strong> - Eliminado</strong>";
						}
					
					$caontras_rel.= "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra_rel[5])."".$estado_eliminado." </strong>".$sel_contratista[0]."";
			}
			
			}else{
			
			}
			
			return $caontras_rel;
	}
	
	
function contratos_relacionados_solicitud($id_item){
	global $pi2,$pi18, $g6, $g15,$pi8,$vpeec18,$pi12,$co1;
	$sel_item_functio = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id from $pi2 where id_item=".$id_item));
	

	
	
    if($sel_item_functio[3] == 4 or $sel_item_functio[3] == 5 or $sel_item_functio[3] == 11 or $sel_item_functio[3] == 12){
		
		$sel_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido,contratista from t7_contratos_contrato where id=".$sel_item_functio[15]));
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[0];
					$numero_contrato4 = $sel_contrato[2];
					
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contrato[3]));
					$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_item_functio[15]);
					if($num_impri == "C-"){
						$num_impri="";
						}
					
					echo "* <strong>".$num_impri." </strong>".$sel_contratista[0];
					
					
		//
	}elseif($sel_item_functio[3] == 7 or $sel_item_functio[3] == 8){
		
		$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
		
		while($sel_presu = traer_fila_db($sele_presupuesto)){
		$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista,t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." order by t2.id asc");
			while($sel_apl = traer_fila_db($sel_contr)){
				
				if($id_contra_bandera == ""){
					$id_contra_bandera=$sel_apl[4];
					$entra_bandera = 1;
					}else{
							if($id_contra_bandera <> $sel_apl[4]){
								$entra_bandera = 1;
								}else{
									$entra_bandera = 2;
									}
						}
					
					
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					if($entra_bandera == 1){
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_apl[3]));
					echo "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[4])." </strong> ".$sel_contratista[0]." ";
					}
			}
		}
			
		}elseif(($sel_item_functio[3] == 1 or $sel_item_functio[3] == 2 or $sel_item_functio[3] == 3 or $sel_item_functio[3] == 6) and $sel_item_functio[2] > 17){
			
	
			$sel_contrato = query_db("select consecutivo,creacion_sistema, apellido,contratista, id from t7_contratos_contrato where id_item=".$sel_item_functio[0]);
			
			while($sel_contra_rel = traer_fila_db($sel_contrato)){
				
					 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contra_rel[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contra_rel[0];
					$numero_contrato4 = $sel_contra_rel[2];
					$sel_contratista = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$sel_contra_rel[3]));
					
					echo "* <strong>".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra_rel[4])." </strong>".$sel_contratista[0]."";
			}
			
			}else{
			echo "";
			}
			
			
	}
function valida_firmas_que_estan_creadas_permiso($id_item){
	
	
	global $pi2;

$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item));

if($sel_item[14] <> 31 and $sel_item[14] <> 7 and $sel_item[14] <> 16){


if($sel_item[6] == 7 or $sel_item[6] == 8 or $sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 9 or $sel_item[6] == 10 or $sel_item[6] == 11 or $sel_item[6] == 12){
	
	$update = query_db("update  t2_agl_secuencia_solicitud set  por_sistema = 1 where id_item_pecc = ".$id_item." and tipo_adj_permiso = 2");
	}elseif($sel_item[14] == 14 and ($sel_item[6] ==1 or $sel_item[6] ==2 or $sel_item[6] == 6) ){
	
	$update = query_db("update  t2_agl_secuencia_solicitud set  por_sistema = 1 where id_item_pecc = ".$id_item." and tipo_adj_permiso = 2");
	
}else{
		
	if($sel_item[14] == 6){	
		$update = query_db("update  t2_agl_secuencia_solicitud set  por_sistema = 1 where id_item_pecc = ".$id_item." and tipo_adj_permiso = 1");
	}
		
		
		}
		
}


		if($sel_item[24] <> 1){// si NO requiere aprobacion extra del comite
		if($sel_item[6] == 4 or $sel_item[6] == 5){
			
			$sel_contrato = traer_fila_row(query_db("select id_item from t7_contratos_contrato where id =".$sel_item[21]));
			$sel_item_contrato = traer_fila_row(query_db("select t1_tipo_proceso_id from $pi2 where id_item=".$sel_contrato[0]));
			
			if($sel_item_contrato[0] == 1){//si es invitacion a proponer el otro si debe tener comite adicional, para que cambie el nivel de servicio
					$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 3 where id_item = ".$id_item);
				}else{
					$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 2 where id_item = ".$id_item);
					}
			
			}
			
			if($sel_item[6] == 7){
			$sel_item_contrato = traer_fila_row(query_db("select t1_tipo_proceso_id from $pi2 where id_item=".$sel_item[26]));
			if($sel_item_contrato[0] == 1){//si es invitacion a proponer el otro si debe tener dondeo_adicional , para que cambie el nivel de servicio
					$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 3 where id_item = ".$id_item);
				}else{
					$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 2 where id_item = ".$id_item);
					}
			
			}
			if($sel_item[6] == 12){// reclasificaciones de contratos marco
			$sel_item_contrato = traer_fila_row(query_db("select t1_tipo_proceso_id from $pi2 where id_item=".$sel_item[26]));
			if($sel_item_contrato[0] == 1){//si es invitacion a proponer
					$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 3 where id_item = ".$id_item);
				}else{
					$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 2 where id_item = ".$id_item);
					}
			
			}
			
		if($sel_item[6] == 11){
			
			$sel_contrato = traer_fila_row(query_db("select id_item from t7_contratos_contrato where id =".$sel_item[21]));
			$sel_item_contrato = traer_fila_row(query_db("select t1_tipo_proceso_id from $pi2 where id_item=".$sel_contrato[0]));
			
			if($sel_item_contrato[0] == 1){//si es invitacion a proponer el otro si debe tener comite adicional, para que cambie el nivel de servicio
					$update_solictud = query_db("update  t2_item_pecc set  dondeo_adicional = 3 where id_item = ".$id_item);
				}else{
					$update_solictud = query_db("update  t2_item_pecc set  dondeo_adicional = 2 where id_item = ".$id_item);
					}
			
			}
			
		}
		
				

		$sel_nivel = traer_fila_row(query_db("select t2_nivel_servicio_id from v_pecc_n_servicio_3 where id_item = ".$id_item));

		if($sel_nivel[0] == 0){//si no tiene nivel de sercio es por que requiere comite obligatorio
			if($sel_item[6] == 4 or $sel_item[6] == 5){			
			$sel_contrato = traer_fila_row(query_db("select id_item from t7_contratos_contrato where id =".$sel_item[21]));
			$sel_item_contrato = traer_fila_row(query_db("select t1_tipo_proceso_id from $pi2 where id_item=".$sel_contrato[0]));			
			if($sel_item_contrato[0] == 1){//si es invitacion a proponer el otro si debe tener comite adicional, para que cambie el nivel de servicio
			$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 3 where id_item = ".$id_item);
				}else{

					$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 2 where id_item = ".$id_item);

					}
			
			}elseif($sel_item[6] == 11){
					$update_solictud = query_db("update  t2_item_pecc set dondeo_adicional = 2 where id_item = ".$id_item);
				}elseif($sel_item[6] == 7){
					$sel_item_contrato = traer_fila_row(query_db("select t1_tipo_proceso_id from $pi2 where id_item=".$sel_item[26]));
					if($sel_item_contrato[0] == 1){//si es invitacion a proponer el otro si debe tener dondeo_adicional , para que cambie el nivel de servicio
							$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 3 where id_item = ".$id_item);
						}else{
							$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 2 where id_item = ".$id_item);
							}
					if($aprobacion_socios_ampliacion == 1){//
							$update_solictud = query_db("update  t2_item_pecc set  t2_nivel_servicio_id = $ans_socios_lici where id_item = ".$id_item);
						}else{
							$update_solictud = query_db("update  t2_item_pecc set  t2_nivel_servicio_id = $ans_socios_nego where id_item = ".$id_item);
							}
					
			}else{
				$update_solictud = query_db("update  t2_item_pecc set  aprobacion_comite_adicional = 2 where id_item = ".$id_item);
				}				
				
				$sel_nivel = traer_fila_row(query_db("select t2_nivel_servicio_id from v_pecc_n_servicio_3 where id_item = ".$id_item));//vuleve a buscar el nivel
			}
			

		
		$update_solictud = query_db("update  t2_item_pecc set  t2_nivel_servicio_id = '".$sel_nivel[0]."' where id_item = ".$id_item);
		
		echo "<br />Actualiza con Funcion1<br />";
		echo "Nivel de servicio ID: ".$sel_nivel[0];
}

function crea_contratos($id_item_pecc){
	global $pi2;
	global $v_contra1;	
	global $fecha;
	global $vpeec18;
	global $co1;
	global $pi8;
	global $pi18;
	global $pi12;

	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc." and id_item <> 1604"));
	
	$saca_ano = explode("-",$fecha);
	$saca_ano_tarifas = $saca_ano[0];
	$saca_ano = $saca_ano[0];
	$saca_ano = $saca_ano[2].$saca_ano[3];
	
	$sele_max_contrato = traer_fila_row(query_db("select max(consecutivo) from $v_contra1 where ano = ".$saca_ano));
	$consecutivo = $sele_max_contrato[0];
		
	
	$sel_contratos = query_db("select t1_proveedor_id,t1_tipo_documento_id, sum(valor_usd), sum(valor_cop), Expr1 from $vpeec18 where t2_item_pecc_id = ".$id_item_pecc." group by t1_proveedor_id,t1_tipo_documento_id, Expr1 order by t1_proveedor_id");
$proveedor=0;
$id_log = log_de_procesos_sgpa(1, 18, 0, $id_item_pecc, $sel_item[14], 20);//agrega valores
	while ($sel_contras = traer_fila_db($sel_contratos)){
		
		if($sel_contras[1] == 1 or $sel_contras[1] == 6){//contrato puntual o aceptacion de oferta mercantil
			
		if($proveedor != $sel_contras[0]){
		$proveedor = $sel_contras[0];
		$consecutivo = $consecutivo+1;
		}
		
		if($sel_contras[1] == 6){
			$oferta_mercantil=1;
			}else{		
				$oferta_mercantil=0;
			}
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	
			echo "select * from $co1 where contratista='".$sel_contras[0]."' and apellido='".$sel_contras[4]."' and id_item = ".$sel_item[43];
	$sel_contratos_sol_original = traer_fila_row(query_db("select * from $co1 where contratista='".$sel_contras[0]."' and apellido='".$sel_contras[4]."' and id_item = ".$sel_item[43]));
	
	if($sel_item[69]==1 and $sel_contratos_sol_original[0]>0){//*************************si es una modificacion de adjudicacion***********************
			$updta = query_db("update $co1 set id_item = ".$id_item_pecc.", objeto='".$sel_item[9]."', monto_usd=".$sel_contras[2].", monto_cop=".$sel_contras[3].", gerente=".$sel_item[3].", t1_tipo_documento_id = 1, oferta_mercantil='".$oferta_mercantil."'  where id = ".$sel_contratos_sol_original[0]);
			$id_ingreso = $sel_contratos_sol_original[0];

		}else{/******************************si no es una modificacion***************************/
		
	$insert_contrato = "insert into $co1 (id_item, consecutivo, objeto, contratista, gerente, monto_usd, monto_cop, creacion_sistema, estado,t1_tipo_documento_id,vigencia_mes, apellido, tipo_bien_servicio, oferta_mercantil) values ($id_item_pecc,$consecutivo, '".$sel_item[9]."',".$sel_contras[0].",".$sel_item[3].",".$sel_contras[2].",".$sel_contras[3].", '$fecha', 1,1,'','".$sel_contras[4]."', '".str_replace(" ", "", tipo_bien_servicio_sin_contrato($sel_contras[4]))."', '".$oferta_mercantil."')";
	$sql_ex=query_db($insert_contrato.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);//id del contrato
	//CREACION DE TARIFAS
	$consecutivo_con_apellido = $consecutivo.$sel_contras[4];
    	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$fecha);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $consecutivo;//consecutivo
		$numero_contrato4 = $sel_contras[4];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$id_contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $id_ingreso);
	
	$insert_tarifa_contrato = "insert t6_tarifas_contratos (t1_moneda_id, t1_proveedor_id,consecutivo,valor, objeto_contarto,id_contrato) values (1,".$sel_contras[0].",'".$id_contrato_ajus."',0,'".$sel_item[9]."',".$id_ingreso." )";
	$sql_ex=query_db($insert_tarifa_contrato.$trae_id_insrte);
	$id_trifas = id_insert($sql_ex);//id del tarifas
	
	$insert_caomplemento_tarifas = query_db("insert into t6_tarifas_complemento_contrato (tarifas_contrato_id, t6_tarifas_estados_contratos_id) values ($id_trifas,1)");
	//FIN CREACION DE TARIFAS
		}
	
	$sele_presu = query_db("select t1.t2_presupuesto_id, t2.id_relacion from $pi8 as t1, $pi18 as t2 where t1.t2_item_pecc_id = $id_item_pecc and t1.permiso_o_adjudica = 2 and t1.t2_presupuesto_id = t2.t2_presupuesto_id and t1_proveedor_id=".$sel_contras[0]." and t2.apellido = '".$sel_contras[4]."'");
	while($s_pres = traer_fila_db($sele_presu)){
	$insert_contra = query_db("insert into $pi12 (t2_presupuesto_id, t7_contrato_id,t2_proveedor_adjudica) values ('".$s_pres[0]."','".$id_ingreso."', '".$s_pres[1]."')");
		}
		
	log_agrega_detalle ($id_log, "Contrato No.", $id_ingreso , "t7_contratos_contrato",1);
	
	
	
 	
	

	
	
		}
		
		
	
	}
	
	if($sel_item[69]==1){
			
	$sel_contras_para_eliminar_sol_original = query_db("select * from $co1 where id_item = ".$sel_item[43]);
	while($sel_con_elim = traer_fila_db($sel_contras_para_eliminar_sol_original)){
			$insert_gestion = query_db("insert into  t7_acciones_admin (id_contrato, id_usuario, observacion, fecha, detalle) values (".$sel_con_elim[0].", ".$_SESSION["id_us_session"].", '".date("G:i:s")."', 'Se elimina por que la solicitud original se modifico con la solicitud ".numero_item_pecc($sel_item[16],$sel_item[17],$sel_item[18])." y no se relaciono este contrato')");
			$id_log = log_de_procesos_sgpa(1, 65, 0, $id_item_pecc, 0, 20);//agrega valores
			log_agrega_detalle ($id_log, "Contrato No.", $sel_con_elim[0] , "t7_contratos_contrato",1);
			$id_log = log_de_procesos_sgpa(1, 65, 0, $sel_item[43], 0, 20);//agrega valores
			log_agrega_detalle ($id_log, "Contrato No.", $sel_con_elim[0] , "t7_contratos_contrato",1);
			$update_estado_contrato = query_db("update $co1 set estado = 50 where id = ".$sel_con_elim[0]);
			
		}
		
	}
		
	
	$upda = query_db("update $pi2 set aprobado = 1 where id_item=".$id_item_pecc);
	
	
	
	}

function crea_proveedor_en_dos_db($nit, $nombre, $correo){
	
	global $host_mys,$usr_mys,$pwd_mys,$dbbase_mys;
	
	$ap = $nit;
	$bp = $nombre;
	$email_contacto=$correo;
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	
	
	
	
	if($email_contacto<>""){
$verifica_email = comprobar_email($email_contacto);
		if($verifica_email=="0"){
			?>
            	<script>
					alert("Verifique el e-mail<?= $email_contacto?>")
					 window.parent.document.getElementById("cargando").style.display="none"
		 				window.parent.document.getElementById("cargando_pecc").style.display="none"
					
				</script>
            <?
			exit();
			}
				
			
	}
	
$cifra_c=md5("321654");

//arma el nit
 $alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");

for($i=0;$i<=3;$i++){
$generador = rand(0,34);
$fuente2.= $alfabeto[$generador];
}
// fin arma el nit

$comple_nit2 = rand(1000,9000);
if($ap=="" or $ap==" " or $ap=="  " or $ap=="0"){
	$ap = $fuente2.$comple_nit2;
}else{			
		$bsca_si_exi=traer_fila_row(query_db("select * from $g6 where nit='$ap'"));
		if($bsca_si_exi[0]>=1){
			?>
            	<script>
					alert("El proveedor ya existe")
					 window.parent.document.getElementById("cargando").style.display="none"
					
				</script>
            <?
			exit();
			}		
			
}

$inserta_us = "insert into t1_proveedor (nit, digito_verificacion , razon_social , estado)	values ('$ap', 0, '$bp',1)";
echo $inserta_us;

$sql_ex=query_db($inserta_us.$trae_id_insrte);
$id_ingreso_pro = id_insert($sql_ex);

$id_pv_return = $id_ingreso_pro;



if($id_ingreso_pro>=1){//si se creo el proveedor


$insert_correo = query_db("insert into t1_proveedor_email(t1_proveedor_id, email, estado) values ($id_ingreso_pro,'$email_contacto',1)");




	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);

		$cambia_cali="insert into  pv_proveedores (pv_id,cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
		 $id_ingreso_pro,1, '$ap', '$bp', '$cp','$email_contacto', 0, 1, 0 )";
		 $sql_ex = mysql_query($cambia_cali);
		 
		

$inserta_email_sgpa=query_db("insert into t1_proveedor_email (t1_proveedor_id, nombre_responsable, email, tipo, estado) values ($id_ingreso_pro, 
'PRINCIPAL','$email_contacto',1,1)");

	
	
	
			
}// fin si se creo el proveedor

	return $id_pv_return;

	}

function verifica_solicitud_marcos($id_item_pecc){
	global $vpeec25;
	$es_marco = "NO";
		$sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$id_item_pecc.""));
			if($sele_tipo_doc[0]>0){
				$es_marco = "SI";
				}
		return $es_marco;
				
					
	}
	
function crea_antecedente_auto($id_item_pecc, $tipo, $consecutivo){
		/*global $pi9, $fecha;
		$saca_ano = "13";
		
		$numero_ot = $consecutivo;
		$numero_otto = "Ots".$saca_ano."-".$consecutivo;
		$numero_contrato = "C".$saca_ano."-".$consecutivo;
		
		
		
		
		
		$insert_atecedente = query_db("insert into $pi9 (tipo, estado, t2_item_pecc_id, detalle, id_us, adjunto) values ('antecedente', 1, $id_item_pecc, '$detalle', ".$_SESSION["id_us_session"].", '')");
		
		
		$aprobacion_nivel =  nivel_aprobacion_solicitud($id_item_pecc, "adjudicacion");
		
		$insert_atecedente = query_db("insert into $pi9 (tipo, estado, t2_item_pecc_id, detalle, id_us, adjunto) values ('antecedente', 1, $id_item_pecc, 'Aprobaci&oacute;n de la Adjudicaci&oacute;n por ".$aprobacion_nivel."', ".$_SESSION["id_us_session"].", '')");
		
		
		return;*/
	}

function elimina_e_procurement($id_item_pecc){
	global $pi2,$pi9 ,$pi13,$host_mys,$usr_mys,$pwd_mys,$dbbase_mys,$fecha, $hora;
	
	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);

		$inserta_procesos="update pro1_proceso set  tp1_id=1000 where cd_id_entrega_documentos = $id_item_pecc";
		$sql_e = mysql_query($inserta_procesos);
	
	}
		
function crear_en_e_procurement($id_item_pecc){
	global $pi2,$pi9 ,$pi13,$host_mys,$usr_mys,$pwd_mys,$dbbase_mys,$fecha, $hora;
	
	$sel_item = traer_fila_row(query_db("select t1_tipo_proceso_id, t1_tipo_contratacion_id, CAST(objeto_contrato AS text), id_us_profesional_asignado
	,num1,num2,num3  from $pi2 where id_item=".$id_item_pecc));// principal numero, objeto, etc
	$sel_docu = query_db("select adjunto,tipo,t2_anexo_id from $pi9 where t2_item_pecc_id=".$id_item_pecc." and tipo not in ('firma-sistema-adjudica', 'firma_sistema', 'presupuesto-adjudica', 'presupuesto-permiso')");//documentos menos ()
	$sel_provee = query_db("select id_proveedor from $pi13 where id_item=".$id_item_pecc." and estado = 1");//proveedores

$numero_consecut = numero_item_pecc($sel_item[4],$sel_item[5],$sel_item[6]);
			//crea_antecedente_auto($id_item_pecc, "crea_urna",0);
	
	
	if($sel_item[1]<>1){
		$tp3_id = 1;//es bienes
		}else{
			$tp3_id = 2;//es servicios
			}
			
	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);

		$inserta_procesos="insert into pro1_proceso (tp1_id,tp2_id,tp3_id,tp4_id,tp5_id,cd_id_ejecucion,cd_id_entrega_documentos,
		direccion_entrega_documentos, cd_id_entrega_ofertas, direccion_entrega_ofertas, tp6_id, detalle_objeto, 
		tp7_tipo_moneda, cuantia, us_id_contacto, fecha_publicacion, fecha_apertura, fecha_cierre, peso_tecnico, 
		minimo_tecnico_solicitado, peso_economico,consecutivo,apertura_juridica,cierre_juridica, apertura_tecnica, cierre_tecnica,apertura_economica, cierre_economica, fecha_informativa, lugar, fecha_creacion, us_id, fecha_informativa_final, fecha_aclaraciones_2_inicial, fecha_aclaraciones_2_final, fecha_aclaraciones_3_inicial, fecha_aclaraciones_3_final, fecha_preconomica_inicial, fecha_preconomica_final, nueva_fecha_informativa, trm_actual,origen_duplicidad,us_id_otro_contacto )
		 values (9, $sel_item[0] ,".$tp3_id.", $sel_item[1] , 6, 0,".$id_item_pecc.",'No',0,'',1, '$sel_item[2]', 0,  0, $sel_item[3],
		 '','','N/D',100,100,0,'".$numero_consecut."' ,'','','','','','', '','' , '$fecha $hora', ".$_SESSION["id_us_session"].", '','','','','','', '', '', '1800',0,0)";
		 
		 echo $inserta_procesos;
		$sql_e = mysql_query($inserta_procesos);
		 $id_proceso = mysql_insert_id($link);
		
		while($l_pro=traer_fila_row($sel_provee))
			{
					 $inserta_prov="insert into pro3_invitaciones (pro1_id,pv_id,lectura_proceso,aceptacion_participacion,estado,observaciones, observaciones_2)
		  values ($id_proceso, $l_pro[0],'', 'N/A', 1, '','' )";
		  $sql_pr= mysql_query($inserta_prov);
			
			}
			

		while($l_docu=traer_fila_row($sel_docu))
			{
				//$inserta_docu="insert into pro2_documentos (pro1_id,tp8_id,archivo,peso,fecha_carga,estado,origen,tipo_archivo,id_origen)		  values ($id_proceso, 4,'$l_docu[0]', '0', '$fecha $hora',1 ,2 ,'$l_docu[1]',$l_docu[2])";		 $sql_pr= mysql_query($inserta_docu);
			
			}			
		
mysql_close();


	return;
	}
	
function crea_otro_si($id_item_pecc){
	global $pi2,$co4;
	global $v_contra1;	
	global $fecha;
	global $vpeec18;
	global $co1;
	global $pi8;
	global $pi18;
	global $pi12;
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	$saca_ano = explode("-",$fecha);
	$saca_ano = $saca_ano[0];
	
	$sele_max_otro_si= traer_fila_row(query_db("select max(numero_otrosi) from $co4  where tipo_complemento = 1"));
	$consecutivo = $sele_max_contrato[0]+1;
		
		
	if($sel_item[6]==7){	# Tipo de proceso
	$sel_valor_adjudicacion = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1"));
	}else{
	$sel_valor_adjudicacion = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2"));
		}
	
if($sel_item[69]==1){
$sel_si_tiene_otro_si = traer_fila_row(query_db("select * from $co4 where id_item_pecc = ".$sel_item[43]));		
	}else{
$sel_si_tiene_otro_si = traer_fila_row(query_db("select * from $co4 where id_item_pecc = ".$id_item_pecc));	
	}
if($sel_si_tiene_otro_si[0]>0){
	$update = query_db("update $co4 set id_item_pecc='".$id_item_pecc."', valor=".$sel_valor_adjudicacion[0].",valor_cop=".$sel_valor_adjudicacion[1]." where id = ".$sel_si_tiene_otro_si[0]);
	}else{
	$crea_otro_si = "insert into $co4 (id_item_pecc,id_contrato, tipo_complemento,alcance,valor,valor_cop,creacion_sistema,estado, numero_otrosi, gerente,eliminado) values ($id_item_pecc,".$sel_item[21].",1,'".$sel_item[10]."', ".$sel_valor_adjudicacion[0].",".$sel_valor_adjudicacion[1].",'$fecha',1,".$consecutivo.",".$sel_item[3].",0)";
	}
	
	$sql_ex=query_db($crea_otro_si.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);//id del contrato
	
	
	$id_log = log_de_procesos_sgpa(1, 21, 0, $id_item_pecc, $sel_item[14], 20);//agrega valores
	log_agrega_detalle ($id_log, "Otro Si", $id_ingreso , $co4,1);
	
	
	$sele_presu = query_db("select * from $pi8 as t1 where t2_item_pecc_id = $id_item_pecc and permiso_o_adjudica = 2 ");
	while($s_pres = traer_fila_db($sele_presu)){
			$insert_contra = query_db("insert into $pi12 (t2_presupuesto_id, t7_contrato_id) values (".$s_pres[0].",".$sel_item[21].")");
		}
		
		
		$upda = query_db("update $pi2 set aprobado = 1, estado = 20 where id_item=".$id_item_pecc);
		
			//crea_antecedente_auto($id_item_pecc, "crea_otro_si", $consecutivo);
	return;
	}
function crea_ots($id_item_pecc){
	global $pi2,$co4, $g15;
	global $v_contra1;	
	global $fecha;
	global $vpeec18;
	global $co1;
	global $pi8;
	global $pi18;
	global $pi12;
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$saca_ano = explode("-",$fecha);
	$saca_ano = $saca_ano[0];

	//$sele_max_otro_si= traer_fila_row(query_db("select max(numero_otrosi) from $co4  where creacion_sistema like '%".$saca_ano."%' and tipo_complemento = 2"));
	
		$consecutivo = numero_item_pecc($sel_item[16],$sel_item[17],$sel_item[18]);
		
$id_log = log_de_procesos_sgpa(1, 20, 0, $id_item_pecc, $sel_item[14], 20);//agrega valores
		
				
			$sel_valor_adjudicacion = query_db("select t7_contrato_id, sum(valor_usd), sum(valor_cop) from v_peec_valor_ot_real where id_item ='".$id_item_pecc."' group by t7_contrato_id");
			while($sel_ots = traer_fila_db($sel_valor_adjudicacion)){
				
				$id_contrato_envia_email = $sel_ots[0];
			
			$sel_si_es_administrador_de_ots = traer_fila_row(query_db("select * from v_seg1 where us_id =".$sel_item[3]." and id_premiso = 33"));//verifica si el usuario es administrador de OTS
		if($sel_si_es_administrador_de_ots[0] > 0){
			$id_gerente = $sel_item[42];
		}else{
			$id_gerente = $sel_item[3];
			}
			
			
			$crea_otro_si = "insert into $co4 (id_item_pecc,id_contrato, tipo_complemento,alcance,valor,valor_cop,creacion_sistema,estado, numero_otrosi,gerente, eliminado) values ($id_item_pecc,".$sel_ots[0].",2,'".$sel_item[10]."', ".$sel_ots[1].",".$sel_ots[2].",'$fecha',15,'".$consecutivo."',".$id_gerente.",0)";
			crea_antecedente_auto($id_item_pecc, "crea_ot", $consecutivo);
			
			$sql_ex=query_db($crea_otro_si.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);//id del contrato
	
	log_agrega_detalle ($id_log, "Orden de Trabajo", $id_ingreso , $co4,1);
	
	
			}
			
$sel_para_actualizar_ampliacion = query_db("select id_item_ots_aplica from v_peec_valor_ot_real where id_item ='".$id_item_pecc."' group by id_item_ots_aplica");

			while($Sel_ac_ampl = traer_fila_db($sel_para_actualizar_ampliacion)){
			if($Sel_ac_ampl[0]>0){//actualiza a finalizado la ampliacion
		$upda = query_db("update $pi2 set estado = 32 where id_item=".$Sel_ac_ampl[0]);
		}	
			}

	
	
	$update_ots = query_db("update t7_contratos_complemento set recibido_abastecimiento = '', recibido_abastecimiento_e = '$fecha' where id_item_pecc = ".$id_item_pecc);
	
		
		$upda = query_db("update $pi2 set aprobado = 1, estado = 22 where id_item=".$id_item_pecc);
		
		$hora_log = date("G:i:s");
		$insrt_gestion_elabora_contra = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado, id_contrato,hora) values ($id_item_pecc,20,18463, '$fecha',0,1,$id_ingreso, '$hora_log')");
		
		
		envio_correo_ot($id_item_pecc);
		
		
	
		
	return;
	}

function envio_correo_ot($id_item){

	$sel_valor_adjudicacion = traer_fila_row(query_db("select t7_contrato_id from v_peec_valor_ot_real where id_item ='".$id_item."' group by t7_contrato_id"));
	
	$id_contrato=$sel_valor_adjudicacion[0];

	
	global $correo_autentica_phpmailer,$contrasena_autentica_phpmailer,$servidor_phpmailer,$correo_from_phpmiler,$nombre_from_phpmiler;
	
	echo $id_item." - ".$id_contrato."<br />";
	$mail = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; 
	$mail->SMTPSecure = "";
	$mail->Port = 25; 
	$mail->Username = $correo_autentica_phpmailer; 
	$mail->Password = $contrasena_autentica_phpmailer; 
	$mail->Host = $servidor_phpmailer;
	
	
	

	$sel_contrato = traer_fila_row(query_db("select gerente,contratista from t7_contratos_contrato where id=".$id_contrato));
	
	$sel_proveedor = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id =  ".$sel_contrato[1]));
	$sel_item = traer_fila_row(query_db("select id_us, id_us_profesional_asignado,id_gerente_ot,id_us_preparador, num1, num2, num3,t1_area_id from t2_item_pecc where id_item=".$id_item));
	$num_item_ot = numero_item_pecc($sel_item[4],$sel_item[5],$sel_item[6]);
	

	$sel_item_ob = traer_fila_row(query_db("select CAST(objeto_solicitud AS TEXT) from t2_item_pecc where id_item=".$id_item));
	
	
	$sele_solicitante_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item." and t2_agl_secuencia_solicitud.id_rol = 15 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));
  
  if($sele_solicitante_fecha[1]>0){
	  	$us_solicitante = $sele_solicitante_fecha[1];
	  }else{
		  $us_solicitante = $sel_item[0];
		  }

	$rol_gerente_ot_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item." and t2_agl_secuencia_solicitud.id_rol = 34 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));	
	if($rol_gerente_ot_fecha[1]>0){
	  	$us_ot_gerente = $rol_gerente_ot_fecha[1];
	  }else{
		  $us_ot_gerente = $sel_item[2];
		  }
		  
$rol_gerente_ot_contrato = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item." and t2_agl_secuencia_solicitud.id_rol = 23 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));	
	if($rol_gerente_ot_contrato[1]>0){
	  	$us_gerente_contrato = $rol_gerente_ot_contrato[1];
	  }else{
		  $us_gerente_contrato = $sel_contrato[0];
		  }



$rol_gerente_ot_solicitud = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item." and t2_agl_secuencia_solicitud.id_rol = 34 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));	
	if($rol_gerente_ot_solicitud[1]>0){
	  	$us_gerente_ot_solicitu = "'".$rol_gerente_ot_solicitud[1]."','".$sel_item[2]."'";
	  }else{
		  $us_gerente_ot_solicitu = $sel_item[2];
		  }
		  
	
	/**/
	/*--------- SELECCIONAR LAS PERSONAS DE GESTION ABASTECIMIENTO ----------------*/
$sel_contratos_gestiona = query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente in (".$us_gerente_ot_solicitu.") group by gestor_abastecimiento");
$concatena_gestor =",0";
$id_gestor_abastecimiento="0";
while($sel_gestores = traer_fila_db($sel_contratos_gestiona)){

$sel_areas_gerente = traer_fila_row(query_db("select count(*) from tseg3_usuario_areas where id_area in (1,44) and id_usuario=".$us_gerente_ot_solicitu));
	
	if($sel_areas_gerente[0]>0){
				if($sel_gestores[0] == 20296){
				$concatena_gestor.=",".$sel_gestores[0];
				$id_gestor_abastecimiento=$sel_gestores[0];
				}
			}else{
				
				$concatena_gestor.=",".$sel_gestores[0];		
				$id_gestor_abastecimiento=$sel_gestores[0];
				
			}
			
	}
		
	/*--------- SELECCIONAR LAS PERSONAS DE GESTION ABASTECIMIENTO ----------------*/
	
	$sel_usaurio_gestor_nom_email = traer_fila_row(query_db("select us_id,nombre_administrador, email from t1_us_usuarios where us_id = ".$id_gestor_abastecimiento. " and estado = 1"));
	if($sel_usaurio_gestor_nom_email[0] > 0){	
	$gestor_abas_email = $sel_usaurio_gestor_nom_email[2];
	$gestor_abas_nom = $sel_usaurio_gestor_nom_email[1];
	}else{
	$gestor_abas_email = "abastecimient@hcl.com.co";
	$gestor_abas_nom = "Abastecimiento, Bogota";
		}

	$mail->From = $gestor_abas_email;
	$mail->FromName = $gestor_abas_nom;
	
	
	
	$id_usuario_sgpa= "'".$us_gerente_contrato."','".$us_solicitante."','".$sel_item[1]."','".$us_ot_gerente."','".$sel_item[3]."'".$concatena_gestor;//se selecciona a diana castaño castano, para que se le envie el correo 19927
	

	
/*CREA EL ARCHIVO PARA ENVIAR*/
$_GET["id_item_pecc"] = $id_item;
	include('../../aplicaciones/comite/pecc/guarda-para-enviar-ots.php');
/*CREA EL ARCHIVO PARA ENVIAR*/

 $sele_email_usurios = query_db("select email,nombre_administrador from t1_us_usuarios where us_id in ($id_usuario_sgpa)");
  while($sl_correo = traer_fila_db($sele_email_usurios)){
	  $mail->AddAddress($sl_correo[0],$sl_correo[1]);
	  echo $sl_correo[0]."-<br />";
  }

	echo "<br />Email Contratista:<br />";
	$sel_email_contratista = query_db("select correo from t2_item_ot_correo_relacion_item, t2_item_ot_correo where id_item = $id_item and id_correo_envio_ot =  t2_item_ot_correo.t2_correo_ot_id");
	
	while($sel_contratista = traer_fila_row($sel_email_contratista)){
		echo $sel_contratista[0]."<br />";
			$mail->AddAddress($sel_contratista[0],$sel_proveedor[0]);
		}

/*validacion antes de enviar*/

$sel_si_el_gerente_esta_mal = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos where id_usuario = ".$id_gerente_validacion." and  id_permiso in (8, 33, 32)"));
if($valida_nivel == "N/A - N/A - "){//estas variables bien desde la hoja "impresion-ots-html"
		$sin_nivel_aprobacion = "sin";		
		}else{
			$sin_nivel_aprobacion = "tiene";
			}
if($sin_nivel_aprobacion == "sin" or $id_gerente_validacion == "" or $sel_si_el_gerente_esta_mal[0] > 0){
	echo "esta mal<br /> nivel de aprobacion:".$sin_nivel_aprobacion."<br /> Gerente:".$id_gerente_validacion."<br /> el gerente tiene rol mal:".$sel_si_el_gerente_esta_mal[0];
	$mail->AddAddress("abastecimiento@hcl.com.co","Bogota, Abastecimiento");
	}
/*fin validacion antes de enviar*/
	
$mail->Subject = "Envio de OT ".$num_item_ot." al Contratista ".$sel_proveedor[0];
//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
//$mail->AddCC("ferney.sterling@enternova.net");
$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
//$mail->AddBCC($correo_dvrnet2);//copia oculta
$mail->AddAttachment("../ots_envio_email/".$num_item_ot.".pdf", $num_item_ot.".pdf");
//$mail->AddAttachment("files/demo.zip", "demo.zip");
$texto_correo = 'Respetados Señores,.<br />
<br />
Para HOCOL S.A. es un requisito indispensable la formalización de los documentos contractuales, previa a la iniciación de los trabajos, puesto que este constituye el único instrumento válido para autorizar el inicio de su ejecución.
<br />
La Compañía se reserva el derecho de aceptar facturas por compromisos no adquiridos con anticipación, a través del respectivo documento contractual, por lo cual  agradecemos de antemano asegurarse de haber enviado estos documentos antes de  la iniciación de los trabajos solicitados por el Gerente de la Orden de Trabajo.
<br />
<p>A continuaci&oacute;n enviamos  adjunto la orden de trabajo '.$num_item_ot.' proveedor '.$sel_proveedor[0].'  para cubrir los servicios de '.$sel_item_ob[0].', para que por favor se sirva a enviarla con los siguientes requisitos:.
<br />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-	Devolución de 1 ejemplar del documento original firmado por el Representante Legal con nombre completo y número de cedula.<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-	Fotocopia de la cedula del Representante Legal que firme el documento contractual.<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-	Certificado de Cámara de Comercio con una vigencia no mayor a 30 días.<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-	Pólizas requeridas con su respectivo recibo de pago original, en caso de que aplique para ésta orden de trabajo<br /><br />


Favor enviarnos los documentos antes mencionados en un plazo no superior a cinco (5) días después del recibo de esta comunicación. En caso de no poder cumplir con esta fecha, favor contactarnos en el teléfono 4884000  en el correo electrónico '.$gestor_abas_email.'
<br /><br /><br />


Cordial saludo, <br />
'.$gestor_abas_nom.' ';

//echo $texto_correo;
$mail->Body = $texto_correo;

			  
$mail->AltBody = "SGPA Informaciones";


$mail->Send();


	}

	
function crea_ampliacion($id_item_pecc){
	global $pi2;
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$upda = query_db("update $pi2 set aprobado = 1, estado = 20 where id_item=".$id_item_pecc);
	crea_antecedente_auto($id_item_pecc, "amplia_soli",0);
	return;
	
	}
	
function crea_contratos_marco($id_item_pecc){
	global $pi2;
	global $v_contra1;	
	global $fecha;
	global $vpeec18;
	global $co1;
	global $pi8;
	global $pi18;
	global $pi12;
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	$saca_ano = explode("-",$fecha);
	$saca_ano_tarifas = $saca_ano[0];
	$saca_ano = $saca_ano[0];
	$saca_ano = $saca_ano[2].$saca_ano[3];
	
	$sele_max_contrato = traer_fila_row(query_db("select max(consecutivo) from $v_contra1 where ano = ".$saca_ano));
	$consecutivo = $sele_max_contrato[0];
	
		$id_log = log_de_procesos_sgpa(1, 19, 0, $id_item_pecc, $sel_item[14], 20);//agrega valores
	
	$sel_contratos = query_db("select t1_proveedor_id,vigencia_mes, apellido from $pi18 where t2_item_pecc_id_marco = ".$id_item_pecc." order by t1_proveedor_id");
	
		
	if ($consecutivo < 100){
	//	$consecutivo = 99;
		}
		
		$id_prove = 0;
	while ($sel_contras = traer_fila_db($sel_contratos)){
		if($sel_contras[0] == $id_prove){
			
			}else{
				$consecutivo = $consecutivo+1;		
				$id_prove = $sel_contras[0];
				}
		
		
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$sel_contratos_sol_original = traer_fila_row(query_db("select * from $co1 where contratista='".$sel_contras[0]."' and apellido='".$sel_contras[4]."' and id_item = ".$sel_item[43]));
	
	if($sel_item[69]==1 and $sel_contratos_sol_original[0]>0){//*************************si es una modificacion de adjudicacion***********************
			$updta = query_db("update $co1 set id_item = ".$id_item_pecc.", objeto='".$sel_item[9]."', monto_usd=0, monto_cop=0, gerente=".$sel_item[3].", t1_tipo_documento_id = 2 where id = ".$sel_contratos_sol_original[0]);
			
			
			
			$id_ingreso = $sel_contratos_sol_original[0];

		}else{/******************************si no es una modificacion***************************/
	$insert_contrato = "insert into $co1 (id_item, consecutivo, objeto, contratista, gerente, monto_usd, monto_cop, creacion_sistema, estado,t1_tipo_documento_id,vigencia_mes, apellido, tipo_bien_servicio) values ($id_item_pecc,$consecutivo, '".$sel_item[9]."',".$sel_contras[0].",".$sel_item[3].",0,0, '$fecha', 1,2,'', '".$sel_contras[2]."', '".str_replace(" ", "", tipo_bien_servicio_sin_contrato($sel_contras[2]))."')";
	$sql_ex=query_db($insert_contrato.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);//id del contrato
	$consecutivo_con_apellido = $consecutivo.$sel_contras[2];


    	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$fecha);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $consecutivo;//consecutivo
		$numero_contrato4 = $sel_contras[2];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$id_contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $id_ingreso);


	//CREACION DE TARIFAS
	//$t1,$t4
	$insert_tarifa_contrato = "insert t6_tarifas_contratos (t1_moneda_id, t1_proveedor_id,consecutivo,valor, objeto_contarto,id_contrato) values (1,".$sel_contras[0].",'".$id_contrato_ajus."',0,'".$sel_item[9]."',".$id_ingreso." )";
	$sql_ex=query_db($insert_tarifa_contrato.$trae_id_insrte);
	$id_trifas = id_insert($sql_ex);//id del tarifas
	
	$insert_caomplemento_tarifas = query_db("insert into t6_tarifas_complemento_contrato (tarifas_contrato_id, t6_tarifas_estados_contratos_id) values ($id_trifas,1)");
	//FIN CREACION DE TARIFAS
	
	//FIN CREACION DE TARIFAS
		}
		
		$sel_pro_ad = query_db("select  t1_proveedor_id, apellido, id_relacion FROM t2_presupuesto_proveedor_adjudica WHERE (t2_item_pecc_id_marco = ".$id_item_pecc.")");
		while($sel_p_ad = traer_fila_db($sel_pro_ad)){
			$sel_contra_corresponde = traer_fila_row(query_db("select id from t7_contratos_contrato where contratista = ".$sel_p_ad[0]." and apellido = '".$sel_p_ad[1]."'"));
			$update_aplica_contra = query_db("update  t2_presupuesto_aplica_contrato set t7_contrato_id = '".$sel_contra_corresponde[0]."' where t2_proveedor_adjudica=".$sel_p_ad[2]);
			}
	
	// crea_antecedente_auto($id_item_pecc, "crea_contrato",$consecutivo_con_apellido);
 log_agrega_detalle ($id_log, "Contrato No.", $id_ingreso , "t7_contratos_contrato",1);
	}
	
	if($sel_item[69]==1){
	$sel_contras_para_eliminar_sol_original = query_db("select * from $co1 where id_item = ".$sel_item[43]);
	while($sel_con_elim = traer_fila_db($sel_contras_para_eliminar_sol_original)){

			$insert_gestion = query_db("insert into  t7_acciones_admin (id_contrato, id_usuario, observacion, fecha, detalle) values (".$sel_con_elim[0].", ".$_SESSION["id_us_session"].", 'Se elimina por que la solicitud original se modifico con la solicitud ".numero_item_pecc($sel_item[16],$sel_item[17],$sel_item[18])." y no se relaciono este contrato', '".$fecha." ".date("G:i:s")."', '1. Eliminar Contrato')");
			$id_log = log_de_procesos_sgpa(1, 65, 0, $id_item_pecc, 0, 20);//agrega valores
			log_agrega_detalle ($id_log, "Contrato No.", $sel_con_elim[0] , "t7_contratos_contrato",1);
			$id_log = log_de_procesos_sgpa(1, 65, 0, $sel_item[43], 0, 20);//agrega valores
			log_agrega_detalle ($id_log, "Contrato No.", $sel_con_elim[0] , "t7_contratos_contrato",1);
			$update_estado_contrato = query_db("update $co1 set estado = 50 where id = ".$sel_con_elim[0]);
			
		}
		
	}
	/*
	//SI ES AMPLIACION
	if($sel_item[6] == 7){// SI CREA CONTRATOS
	$upda_presupuesto = query_db("update $pi8 set permiso_o_adjudica = 2 where t2_item_pecc_id = $id_item_pecc");
	echo "update $pi8 set permiso_o_adjudica = 2 where t2_item_pecc_id = $id_item_pecc";
	}
	// FIN SI ES AMPLIACION
	*/
	$upda = query_db("update $pi2 set aprobado = 1 where id_item=".$id_item_pecc);
	
	
	
	}	


function arregla_numero_db1($valor1){

	if($valor1>=0 and $valor1 <> ""){
		$valor_arrglo1 = str_replace(",", "", $valor1 );
	}else{
		$valor_arrglo1 = 0;
	}
	
	return $valor_arrglo1;
}
function saca_nombre_anexo($anexo_nombre){
		$explode_nombre = explode("_",$anexo_nombre);
		$indicativo_archivo = $explode_nombre[0]."_".$explode_nombre[1]."_";
		$nombre_archivo_real = str_replace($indicativo_archivo,"",$anexo_nombre);
		
		$explode_nombre = explode(".",$nombre_archivo_real);
		$cuantos_array = count($explode_nombre);
		$posicion = $cuantos_array-1;
		$extencion = ".".$explode_nombre[$posicion];
		$nombre_archivo_real = str_replace($extencion,"",$nombre_archivo_real);
		
		return $nombre_archivo_real;		
	}
function saca_extencion_archivo($anexo_nombre){
		$explode_nombre = explode(".",$anexo_nombre);
		$cuantos_array = count($explode_nombre);
		$posicion = $cuantos_array-1;
		$extencion = $explode_nombre[$posicion];
		
		return $extencion;		
	}
function saca_nombre_lista ($tabla, $seleccion, $columna_trae, $columna_compara, $id_item){			
$sel_ls = "select ".$columna_trae." from ".$tabla." where ".$columna_compara." = '".$seleccion."'";			
			$sql_ex_ls=traer_fila_row(query_db($sel_ls));
				
				if($tabla == "t1_tipo_proceso" and $id_item <= 5393 and ($seleccion==6 or $seleccion==1)){
					//if($seleccion==1) return "Invitacion a Proponer";
					//if($seleccion==6) return "Adjudicacion Directa Sondeo";
					return $sql_ex_ls[0];
					}else{
					
						if($sql_ex_ls[0] == "" and $tabla != $g13){
							return "Aun NO se ha seleccionado";
							}else{
							return $sql_ex_ls[0];
							}
					}
		
	}
	
function saca_nombre_lista_ot_pdf ($tabla, $seleccion, $columna_trae, $columna_compara){			
			$sel_ls = "select ".$columna_trae." from ".$tabla." where ".$columna_compara." = '".$seleccion."'";			
			$sql_ex_ls=traer_fila_row(query_db($sel_ls));
			if($sql_ex_ls[0] == ""){
				return "Aun NO se ha seleccionado";
				}else{
				return utf8_encode($sql_ex_ls[0]);
				}
		
	}
	
function verifica_usuario_si_tiene_el_permiso($id_permiso){
	global $v_seg1;
	global $pi2;
	$permiso = "NO";
			$sele_permiso = traer_fila_row(query_db("select * from $v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = ".$id_permiso));
			
		if( $sele_permiso[0] > 0){
					$permiso = "SI";
				}
		return $permiso;
	
	}
	
	
function verifica_usuario_indicado_solo_si($id_permiso,$id_item){
	global $v_seg1;
	global $pi2;
	$permiso = "NO";
			$sele_permiso = traer_fila_row(query_db("select * from $v_seg1 where us_id in (".$_SESSION["usuarios_con_reemplazo"].") and id_premiso = ".$id_permiso));
			
	$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sele_permiso[0] > 0 and (vari_si_reempla($sel_item_permiso[1]) == "SI")){
					$permiso = "SI";
				}
		return $permiso;
	
	}
function verifica_usuario_indicado($id_permiso,$id_item){
	global $v_seg1;
	global $pi2;
	$permiso = "NO";

			$sele_permiso = traer_fila_row(query_db("select * from $v_seg1 where us_id in (".$_SESSION["usuarios_con_reemplazo"].") and id_premiso = ".$id_permiso));
			
			if( $sele_permiso[4] == 8){
	$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado, congelado from $pi2 where id_item=".$id_item));
			if( $sele_permiso[0] > 0 and (vari_si_reempla($sel_item_permiso[1]) == "SI" or $sel_item_permiso[1] == "" and $sel_item_permiso[2] <> 1)){
					$permiso = "SI";
				}
			}else{
				if( $sele_permiso[0] > 0){
					$permiso = "SI";
				}
				}
		return $permiso;
	
	}
	
	
function verifica_permiso_adjudicacion_usuario($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

	if($id_permiso == 15){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
		if(vari_si_reempla($sel_item_permiso[0]) == "SI"){	
		//if( $sel_item_permiso[0] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}
				return $permiso;
	}
	
	
function verifica_permiso_firmas_adjudicacion($id_permiso, $id_item){
	global $vpeec5,$vpeec3 ;
	global $pi2;
	$permiso = "NO";
	
	$sele_si_aplica_permiso = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item." and actividad_estado_id = 7"));
	$sele_si_aplica = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item." and actividad_estado_id = 16"));
	$muestra = "NO";
	if($sele_si_aplica_permiso[0] <=0 and $sele_si_aplica[0]>=0 and $id_permiso == 6){
		$muestra = "SI";
		}

	if($id_permiso == 14 or $muestra == "SI"){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if(vari_si_reempla($sel_item_permiso[1]) == "SI"){
					$permiso = "SI";
				}			
	}
				return $permiso;
	}
function verifica_permiso_adjudicacion($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

	if($id_permiso == 14){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( (vari_si_reempla($sel_item_permiso[1]) == "SI")	){
					$permiso = "SI";
				}			
	}
				return $permiso;
	}
	
function verifica_permiso_sondeo($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

	if($id_permiso == 5){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sel_item_permiso[1] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}
				return $permiso;
	}
function verifica_permiso_negociacion($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

	if($id_permiso == 13){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sel_item_permiso[1] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}
				return $permiso;
	}
	
	
function verifica_permiso_sondeo_doc_basica($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

	if($id_permiso == 3){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sel_item_permiso[0] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}
/*	if($id_permiso == 3){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sel_item_permiso[1] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}*/
				return $permiso;
	}	
	
function verifica_permiso_sondeo_ensamble_doc($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

	if($id_permiso == 4){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sel_item_permiso[1] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}
				return $permiso;
	}	
function verifica_permiso_ensamble_doc($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

	if($id_permiso == 12){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sel_item_permiso[1] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}
				return $permiso;
	}	
	
function verifica_permiso_doc_basica($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

	if($id_permiso == 10){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sel_item_permiso[0] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}
	if($id_permiso == 11){				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado from $pi2 where id_item=".$id_item));
			if( $sel_item_permiso[1] == $_SESSION["id_us_session"]){
					$permiso = "SI";
				}			
	}
				return $permiso;
	}	
	
function verifica_permiso_pecc($id_permiso, $id_item){
	global $vpeec5;
	global $pi2;
	$permiso = "NO";

if($id_permiso == 31 or $id_permiso == 6 or $id_permiso == 14){

			$sele_permiso = traer_fila_row(query_db("select id_encargado from $vpeec5 where us_id in (".$_SESSION["usuarios_con_reemplazo"].") and t2_nivel_servicio_actividad_id = ".$id_permiso));
				
			$sel_item_permiso = traer_fila_row(query_db("select id_us,id_us_profesional_asignado, congelado from $pi2 where id_item=".$id_item));

			if( ($sele_permiso[0] == 1 or $id_permiso == 31) and vari_si_reempla($sel_item_permiso[0]) == "SI"){
					$permiso = "SI";

				}

			
			if( $sele_permiso[0] == 2 and (vari_si_reempla($sel_item_permiso[1]) == "SI" or $sel_item_permiso[1] == "" or $sel_item_permiso[1] == 0)){
					$permiso = "SI";
				}
}
	if($sel_item_permiso[2] == 1){
			$permiso = "NO";
		}
			
				return $permiso;
	}	

function agrega_gestion_pecc_atras_solicita($id_item, $actividad, $fecha_real, $dias, $ob){
	global $vpeec3;

			if($actividad == 15){
				$desactiva_superior = query_db("update t2_nivel_servicio_gestiones set estado = 2 where id_item = $id_item and t2_nivel_servicio_actividad_id >=14");	
				}else{
			$desactiva_superior = query_db("update t2_nivel_servicio_gestiones set estado = 2 where id_item = $id_item and t2_nivel_servicio_actividad_id >=1");
				}
			$hora_log = date("G:i:s");
			$agrega_acti_gestion = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado,observacion,devolucion, hora) values ($id_item, $actividad, ".$_SESSION["id_us_session"].", '".$fecha_real."', $dias,2,'".$ob."',1,'$hora_log')");

	}
function agrega_gestion_pecc_atras($id_item, $actividad, $fecha_real, $dias, $ob){
	global $vpeec3;
	
	$sel_estado_anterior = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3 where id_item=".$id_item." and actividad_estado_id < ".$actividad." and (t2_nivel_servicio_encargado_id = 1 or t2_nivel_servicio_encargado_id = 2)"));

			$desactiva_superior = query_db("update t2_nivel_servicio_gestiones set estado = 2 where id_item = $id_item and t2_nivel_servicio_actividad_id >=".$sel_estado_anterior[0]);
			$hora_log = date("G:i:s");
			$agrega_acti_gestion = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado,observacion,devolucion, hora) values ($id_item, $actividad, ".$_SESSION["id_us_session"].", '".$fecha_real."', $dias,2,'".$ob."',1,'$hora_log')");



	}
	
	
	function dias_habiles_entre_fechas($fecha_ini,$fecha_fin){
		global $fecha;
			
	if($fecha_ini == "" or $fecha_ini == " " or $fecha_ini == "  "){
		$fecha_ini = $fecha;
		}
	$fecha_ini_ini = $fecha_ini;
		
		
		if($fecha_ini > $fecha_fin){
			?>
            <script>
			//alert("*Error \n Fecha Anterior: < ?=$fecha_ini;?> \n Fecha Ingresada: < ?=$fecha_fin;?>")
			</script>
            <?
			echo "Fecha Anterior: ".$fecha_ini."<br /> Fecha Actual: ".$fecha_fin;
			echo ('<br /><strong><font color="FF0000">Error de fechas</font></strong>!');
			$dias_habiles=0;
			}else{
	$dias_habiles = -1;
			
	//RECORRE FECHAS
	
	for($i=strtotime($fecha_ini); $i<=strtotime($fecha_fin); $i+=86400){

		//if($i > 132703560){
		    $fecha_rer =  date("y-m-d", $i);
			$separa_fecha = explode("-",$fecha_rer);
			$accion = accion_fecha($separa_fecha[0],$separa_fecha[1],$separa_fecha[2]);					 
			
			 if($accion != "NA"){
				$dias_habiles = $dias_habiles +1; 
						//echo date("y-m-d", $i)."<br />";
				}else{
				
				}
	}
		//}
}
	
	//FIN RECORRE FECHAS
			
			
			if($fecha_ini_ini == $fecha_fin){
				$dias_habiles=0;
				}
				//echo $dias_habiles;
			return $dias_habiles;
			
		}
		
function agrega_gestion_contratos($id_item, $id_contrato, $actividad, $fecha_real){
	global $pi17,$vpeec3,$pi2,$co1,$est_finalizado;
			if ($actividad==20){
				$sel_gestiones_max = traer_fila_row(query_db("select max(t2_gestion) from $pi17 where id_item = $id_item and id_contrato is null and estado = 1"));
				$sel_gestiones = traer_fila_row(query_db("select fecha_real from $pi17 where t2_gestion = ".$sel_gestiones_max[0]));
				$fecha_ini = $sel_gestiones[0];
				$fecha_fin = $fecha_real;
			}else{
				$sel_gestiones_max = traer_fila_row(query_db("select max(t2_gestion) from $pi17 where id_item = $id_item and id_contrato=$id_contrato and estado = 1"));			
				$sel_gestiones = traer_fila_row(query_db("select fecha_real from $pi17 where t2_gestion = ".$sel_gestiones_max[0]));
				$fecha_ini = $sel_gestiones[0];
				echo $fecha_ini." ".$fecha_real;
				$fecha_fin = $fecha_real;
			}
			
			//echo $fecha_ini." ".$fecha_fin;
			$dias = dias_habiles_entre_fechas($fecha_ini,$fecha_fin);
			//$desactiva_anteriorer = query_db("update $pi17 set estado = 2 where id_item = $id_item and t2_nivel_servicio_actividad_id =".$actividad);
			$hora_log = date("G:i:s");
			$select_usu = query_db("insert into $pi17 (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado, id_contrato, hora) values ($id_item, $actividad, ".$_SESSION["id_us_session"].", '".$fecha_real."', $dias,1,".$id_contrato.", '$hora_log')");
			/*
			if($actividad == 29){
				$estado_prx = 32;
				}else{
				$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item." and id_contrato=$id_contrato and actividad_estado_id > ".$actividad." and actividad_estado_id <> 31 and actividad_estado_id <> 33"));
				$estado_prx = $sel_estado[0];		
					}
			
			
			
			$upda_item = query_db("update $pi2 set estado=".$estado_prx." where id_item=".$id_item);
			*/
			if($actividad==20){
				$estado_prx = 21;
				$sel_contrato_activo = traer_fila_row(query_db("select count(*) from $co1 where id_item = $id_item and estado = ".$est_creacion));
				if($sel_contrato_activo[0]==0)
					$upda_item = query_db("update $pi2 set estado=".$estado_prx." where id_item=".$id_item);
			}
			
			if($actividad==29){
				$estado_prx = 32;
				$sel_contrato_activo = traer_fila_row(query_db("select count(*) from $co1 where id_item = $id_item and  estado <> ".$est_finalizado));
				if($sel_contrato_activo[0]==0)
					$upda_item = query_db("update $pi2 set estado=".$estado_prx." where id_item=".$id_item);
			}

}
	
function agrega_gestion_pecc($id_item, $actividad, $fecha_real, $dias){
	global $pi17, $vpeec3,$pi2,$valer_3, $g13;
	$dias_gia=$dias;
	$fecha_actual= date('Y-m-d');
	$siete_dias = strtotime ( '+7 days' , strtotime ($fecha_actual) );
	$siete_dias=date('Y-m-d',$siete_dias);
	$time=date('G:i:s');
	
	if($actividad==13){//si es finalizacion de evaluacion comercial
			//$no_incluya = " and t2_nivel_servicio_actividad_id not in (12.2)";//no incluya la gestion de la evaluacion comercial para que cuente desde la apertura
		}
			$sel_gestiones_max = traer_fila_row(query_db("select max(t2_gestion) from $pi17 where id_item = $id_item and estado = 1 $no_incluya"));
			if($sel_gestiones_max[0] != ""){
			$sel_gestiones = traer_fila_row(query_db("select fecha_real from $pi17 where t2_gestion = ".$sel_gestiones_max[0]));			
			$fecha_ini = $sel_gestiones[0];
			$fecha_fin = $fecha_real;
			$dias = dias_habiles_entre_fechas($fecha_ini,$fecha_fin);
			}else{
				$dias = 0;
				}
			$desactiva_anteriorer = query_db("update $pi17 set estado = 2 where id_item = $id_item and t2_nivel_servicio_actividad_id =".$actividad);
			

			if($dias_gia==1500){//es gestion automatica por que salta el cargue de documentacion
				$id_usuario_gestion=18463; 
				$ob_ini="Gestion Automatica por el Sistema";
				}else{
					$id_usuario_gestion=$_SESSION["id_us_session"];
					$ob_ini="";
					}
				$hora_log = date("G:i:s");
	
	$validacion_pasa_etapa = "SI";
	/*
	if($actividad == 7){//si la etapa que se va a culminar es la de firmas para el permiso 
		
		$sel_firmas_faltantes = query_db("select id_secuencia_solicitud from t2_agl_secuencia_solicitud where estado = 1 and tipo_adj_permiso = 1");
		
		while($sel_firmas = traer_fila_db($sel_firmas_faltantes)){//se recorren todas las firmas configuradas
			$sel_aprobaciones = traer_fila_row(query_db("Select count(*) from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_firmas [0]." and aprobado = 1"));
			if($sel_aprobaciones[0] >= 0){
				//$validacion_pasa_etapa = "NO";
				
			}
		}
		
	}
	if($actividad == 16){//si la etapa que se va a culminar es la de firmas para la adjudicacion 
		
		$sel_firmas_faltantes = query_db("select id_secuencia_solicitud from t2_agl_secuencia_solicitud where estado = 1 and tipo_adj_permiso = 2");
		
		while($sel_firmas = traer_fila_db($sel_firmas_faltantes)){//se recorren todas las firmas configuradas
			$sel_aprobaciones = traer_fila_row(query_db("Select count(*) from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_firmas [0]." and aprobado = 1"));
			if($sel_aprobaciones[0] >= 0){
				//$validacion_pasa_etapa = "NO";
				
			}
		}
		
	}
	*/
	
	if($validacion_pasa_etapa== "SI"){//validacion pasa etapa
			$select_usu = query_db("insert into $pi17 (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado,observacion, hora) values ($id_item, $actividad, ".$id_usuario_gestion.", '".$fecha_real."', $dias,1,'$ob_ini','$hora_log')");
			
			
			
			//echo "select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item." and actividad_estado_id > ".$actividad." and actividad_estado_id <> 31 and actividad_estado_id <> 33";
			//SELECCIONA ESTADO SIGUIENTE
			$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item." and actividad_estado_id > ".$actividad." and actividad_estado_id <> 31 and actividad_estado_id <> 33"));
				$estado_prx = $sel_estado[0];		
			$select_pec = traer_fila_row(query_db("select id_us, id_us_profesional_asignado, t1_tipo_proceso_id, CAST(objeto_solicitud AS text) as objeto_solicitud, num1, num2, num3, t2_pecc_proceso_id, id_us_preparador from $pi2 where id_item=".$id_item));
			$pec_objeto=utf8_encode($select_pec[3]);
			$numero2=numero_item_pecc($select_pec[4], $select_pec[5], $select_pec[6]);
			$tipo_pro=traer_fila_row(query_db("SELECT nombre FROM $g13 where t1_tipo_proceso_id=".$select_pec[2]));
			$tipo_pro=utf8_encode($tipo_pro[0]);
			if($estado_prx!=19){
				$nombre_actvidad=traer_fila_row(query_db("SELECT nombre from t2_nivel_servicio_actividades where t2_nivel_servicio_actividad_id =".$estado_prx));
				$nombre_actvidad=utf8_encode($nombre_actvidad[0]);
			}else{
				$nombre_actvidad=traer_fila_row(query_db("SELECT nombre from t2_nivel_servicio_actividades where t2_nivel_servicio_actividad_id =20"));
				$nombre_actvidad=utf8_encode($nombre_actvidad[0]);
			}
			if($estado_prx==7){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[0]." and id_solicitud=".$id_item." and dias=7"));
				if($res[0]==0){//PARA EL SOLICITANTE
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 7)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[0]." and id_solicitud = ".$id_item." and dias < 7");
				}
			}elseif($estado_prx==8){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[0]." and id_solicitud=".$id_item." and dias=8"));
				if($res[0]==0){//PARA EL SOLICITANTE
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 8)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[0]." and id_solicitud = ".$id_item." and dias < 8");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[1]." and id_solicitud=".$id_item." and dias=8"));
				if($res[0]==0){//PARA EL PROFESIONAL ASIGNADO
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[1].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 8)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[1]." and id_solicitud = ".$id_item." and dias < 8");
				}
			}elseif($estado_prx==9){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[0]." and id_solicitud=".$id_item." and dias=9"));
				if($res[0]==0){//PARA EL SOLICITANTE
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 9)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[0]." and id_solicitud = ".$id_item." and dias < 9");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[1]." and id_solicitud=".$id_item." and dias=9"));
				if($res[0]==0){//PARA EL PROFESIONAL
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[1].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 9)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[1]." and id_solicitud = ".$id_item." and dias < 9");
				}
			}elseif($estado_prx==11){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[1]." and id_solicitud=".$id_item." and dias=11"));
				if($res[0]==0){//PARA EL PROFESIONAL ASIGNADO
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[1].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 11)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[1]." and id_solicitud = ".$id_item." and dias < 11");
				}
			}elseif($estado_prx==12.2){//para llenar las notificaciones push
				global $host_mys,$usr_mys, $pwd_mys, $dbbase_mys;
				$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
				mysql_select_db($dbbase_mys, $link);	
				$query_tecnico = mysql_query("select distinct t1.us_id from pro6_observadores_procesos as t1, pro1_proceso as t2 where t1.pro1_id = t2.pro1_id and t1.tipo=2 and t2.cd_id_entrega_documentos = ".$id_item);
				$busca_tecnico=mysql_fetch_row($query_tecnico);
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$busca_tecnico[0]." and id_solicitud=".$id_item." and dias=12.2"));
				if($res[0]==0){//PARA EL EVALUADOR TECNICO
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$busca_tecnico[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 12.2)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$busca_tecnico[0]." and id_solicitud = ".$id_item." and dias < 12.2");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[1]." and id_solicitud=".$id_item." and dias=12.2"));
				if($res[0]==0){//PARA EL PROFESIONAL
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[1].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 12.2)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[1]." and id_solicitud = ".$id_item." and dias < 12.2");
				}
			}elseif($estado_prx==15){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[0]." and id_solicitud=".$id_item." and dias=15"));
				if($res[0]==0){//PARA EL SOLICITANTE
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 15)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[0]." and id_solicitud = ".$id_item." and dias < 15");
				}
			}elseif($estado_prx==16){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[0]." and id_solicitud=".$id_item." and dias=16"));
				if($res[0]==0){//PARA EL SOLICITANTE
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 16)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[0]." and id_solicitud = ".$id_item." and dias < 16");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[1]." and id_solicitud=".$id_item." and dias=16"));
				if($res[0]==0){//PARA EL PROFESIONAL
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[1].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 16)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[1]." and id_solicitud = ".$id_item." and dias < 16");
				}
			}elseif($estado_prx==17){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[0]." and id_solicitud=".$id_item." and dias=17"));
				if($res[0]==0){//PARA EL SOLICITANTE
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 17)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[0]." and id_solicitud = ".$id_item." and dias < 17");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[1]." and id_solicitud=".$id_item." and dias=17"));
				if($res[0]==0){//PARA EL PROFESIONAL ASIGNADO
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[1].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 17)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[1]." and id_solicitud = ".$id_item." and dias < 17");
				}
			}elseif($estado_prx==18){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[0]." and id_solicitud=".$id_item." and dias=18"));
				if($res[0]==0){//PARA EL SOLICITANTE
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 18)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[0]." and id_solicitud = ".$id_item." and dias < 18");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[1]." and id_solicitud=".$id_item." and dias=18"));
				if($res[0]==0){//PARA EL PROFESIONAL
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[1].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 18)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[1]." and id_solicitud = ".$id_item." and dias < 18");
				}
			}elseif($estado_prx==19){//para llenar las notificaciones push
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[0]." and id_solicitud=".$id_item." and dias=20"));
				if($res[0]==0){//PARA EL SOLICITANTE
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[0].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 20)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[0]." and id_solicitud = ".$id_item." and dias < 20");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$select_pec[1]." and id_solicitud=".$id_item." and dias=20"));
				if($res[0]==0){//PARA EL PROFESIONAL
					
					$ruta="ajax_carga(''../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$select_pec[7]."'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_solicitud, dias) values(".$select_pec[1].", 1, '".$ruta."', 1, '".$nombre_actvidad." <br>".$numero2." - ".$tipo_pro."  <br> ".$pec_objeto."', 'custom-green-border',".$id_item.", '".$fecha_actual."', '".$time."', $id_item, 20)");
					//PARA ACTUALIZAR EL ESTADO ANTERTIOR PARA QUE NO VUELVA A APARECER EN LAS NOTIFICACIONES
					$update=query_db("update ".$valer_3." set estado = 4 where id_usuario=".$select_pec[1]." and id_solicitud = ".$id_item." and dias < 20");
				}
			}
			$sel_item_pe = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item));		
			if($actividad <= 9 and $estado_prx > 9 and $sel_item_pe[6] <> 7 and $sel_item_pe[6] <> 8){// agrega antecedente automatico
					//crea_antecedente_auto($id_item, "aprueba_permiso",0);				
				
				}	
			if($estado_prx == 19){//SI ES SOLICITUD PAR
			$hora_log = date("G:i:s");
			$select_usu = query_db("insert into $pi17 (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado, observacion, hora) values ($id_item, 19, 18463, '".$fecha_real."', 0,1,'Gestion Automatica por el Sistema','$hora_log')"); // INSERTA GESTION DE SOLICTUD PAR
			
				$upda_item = query_db("update $pi2 set estado= 20 where id_item=".$id_item);//aCTUALIZA A PRIMER ESTADO DE CONTRATOS
			}//FIN SI ES SOLICITUD PAR
			
			
}else{//fin validacion pasa etapa
	
	exit;//retorna el proceso si no pasa la validacion.
	}
	}
	
	


	
function traer_nombre_muestra($id, $tabla, $campo_nombre, $campo_id){
	if($tabla == "t2_nivel_servicio_actividades" and ($id > 20 and $id < 31)){
		$select_usu[0] = "En Legalizaci&oacute;n";
		}else{
			$select_usu = traer_fila_row(query_db("select ".$campo_nombre." from ".$tabla." where ".$campo_id." =".$id));
		}
			return $select_usu[0];
	}
function accion_fecha($ano,$mes,$dia){
	if($dia == "01" and $mes == "01"){ $accion = "NA"; }
	 if($dia == "01" and $mes == "05"){ $accion = "NA"; }
	 if($dia == "20" and $mes == "07"){ $accion = "NA"; }
     if($dia == "07" and $mes == "08"){ $accion = "NA"; }
	 if($dia == "08" and $mes == "12"){ $accion = "NA"; }
	 if($dia == "25" and $mes == "12"){ $accion = "NA"; }
	 if($ano=="13"){
		 if($dia == "07" and $mes == "01"){ $accion = "NA"; }
		 if($dia == "24" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "25" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "28" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "29" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "31" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "13" and $mes == "05"){ $accion = "NA"; }
		 if($dia == "03" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "10" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "01" and $mes == "07"){ $accion = "NA"; }
		 if($dia == "19" and $mes == "08"){ $accion = "NA"; }
		 if($dia == "14" and $mes == "10"){ $accion = "NA"; }
		 if($dia == "04" and $mes == "11"){ $accion = "NA"; }
		 if($dia == "11" and $mes == "11"){ $accion = "NA"; }
		 }
	if($ano=="14"){
		 if($dia == "06" and $mes == "01"){ $accion = "NA"; }
		 if($dia == "24" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "13" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "17" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "18" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "20" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "02" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "23" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "30" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "18" and $mes == "08"){ $accion = "NA"; }
		 if($dia == "13" and $mes == "10"){ $accion = "NA"; }
		 if($dia == "03" and $mes == "11"){ $accion = "NA"; }
		 if($dia == "17" and $mes == "11"){ $accion = "NA"; }
		 }
	if($ano=="15"){
		 if($dia == "12" and $mes == "01"){ $accion = "NA"; }
		 if($dia == "23" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "29" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "02" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "03" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "05" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "18" and $mes == "05"){ $accion = "NA"; }
		 if($dia == "08" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "15" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "29" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "17" and $mes == "08"){ $accion = "NA"; }
		 if($dia == "12" and $mes == "10"){ $accion = "NA"; }
		 if($dia == "02" and $mes == "11"){ $accion = "NA"; }
		 if($dia == "16" and $mes == "11"){ $accion = "NA"; }
		 }
	if($ano=="16"){
		 if($dia == "11" and $mes == "01"){ $accion = "NA"; }
		 if($dia == "20" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "21" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "24" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "25" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "27" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "09" and $mes == "05"){ $accion = "NA"; }
		 if($dia == "30" and $mes == "05"){ $accion = "NA"; }
		 if($dia == "06" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "04" and $mes == "07"){ $accion = "NA"; }
		 if($dia == "15" and $mes == "08"){ $accion = "NA"; }
		 if($dia == "17" and $mes == "10"){ $accion = "NA"; }
		 if($dia == "07" and $mes == "11"){ $accion = "NA"; }
		 if($dia == "14" and $mes == "11"){ $accion = "NA"; }
		 }
		 
	if($ano=="17"){
		 if($dia == "09" and $mes == "01"){ $accion = "NA";}
		 if($dia == "20" and $mes == "03"){ $accion = "NA"; }
		 if($dia == "09" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "13" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "14" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "16" and $mes == "04"){ $accion = "NA"; }
		 if($dia == "29" and $mes == "05"){ $accion = "NA"; }
		 if($dia == "19" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "26" and $mes == "06"){ $accion = "NA"; }
		 if($dia == "03" and $mes == "07"){ $accion = "NA"; }
		 if($dia == "21" and $mes == "08"){ $accion = "NA"; }
		 if($dia == "16" and $mes == "10"){ $accion = "NA"; }
		 if($dia == "06" and $mes == "11"){ $accion = "NA"; }
		 if($dia == "13" and $mes == "11"){ $accion = "NA"; }
		 }
	 
	$dia= date("w",mktime(0, 0, 0, $mes, $dia, $ano));
	 if($dia == 6 || $dia == 0){
	 		$accion = "NA";
		}
		return $accion;
}

function sumar_fechas($fechaInicial, $MaxDias){
        for ($i=0; $i<$MaxDias; $i++) {  
			 $accion ="";
			 $fechaInicial = date("y-m-d", strtotime("$fechaInicial +1 day"));  
			 $separa_fecha = explode("-",$fechaInicial);
			 $accion = accion_fecha($separa_fecha[0],$separa_fecha[1],$separa_fecha[2]);
			 
			 if($accion == "NA"){
				// echo "sabado-domingo - ";
				$i--; 
				//echo "festivo:".date("Y-m-d", strtotime($fechaInicial))."<br />";
				} else{
					//echo date("Y-m-d", strtotime($fechaInicial))."<br />";
					}
			//echo $i." - ".$fechaInicial." - "." - ".$accion."<br />";  
    }  
	return date("Y-m-d", strtotime($fechaInicial));
	
}


function restar_fechas($fechaInicial, $MaxDias){
    
	    for ($i=0; $i<$MaxDias; $i++) {  
			 $accion ="";
			 $fechaInicial = date("y-m-d", strtotime("$fechaInicial -1 day"));  
			 $separa_fecha = explode("-",$fechaInicial);
			 $accion = accion_fecha($separa_fecha[0],$separa_fecha[1],$separa_fecha[2]);
			 
			 if($accion == "NA"){
				// echo "sabado-domingo - ";
				$i--; 
				} 
			//echo $i." - ".$fechaInicial." - "." - ".$accion."<br />";  
    }  
	
	return date("Y-m-d", strtotime($fechaInicial));
}

function carga_sub_menu_comite($id_comite){
	global $c1;
	$selec_comite = traer_fila_row(query_db("select * from $c1 where id_comite =".$id_comite));
	$edicion_datos_generales = "NO";
	if(verifica_usuario_indicado(10,0)=="SI"){
	$edicion_datos_generales = "SI";
	}
		
	?>
	<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td class="fondo_3" align="center">Acciones del Comit&eacute; </td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/comite/edicion-comite.php?id_comite=<?=$id_comite?>','contenidos')" style="cursor:pointer">&gt;&gt; Informaci&oacute;n General</td>
        </tr>
        <?
        if($selec_comite[4] != 1 and $edicion_datos_generales  == "SI"){
		?>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/comite/agrega-items.php?id_comite=<?=$id_comite?>','contenidos')" style="cursor:pointer">&gt;&gt; Agregar Solicitudes </td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/comite/organiza-items.php?id_comite=<?=$id_comite?>','contenidos')" style="cursor:pointer">&gt;&gt; Organizar Solicitudes</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/comite/asistentes.php?id_comite=<?=$id_comite?>','contenidos')" style="cursor:pointer">&gt;&gt; Asistentes y Aprobadores</td>
        </tr>
        <tr>
          <td onclick="muestra_alerta_general_solo_texto('finalizacion_comite()', 'Advertencia', 'Está seguro de finalizar este comité, se enviará a los interesados vía E-mail el acta de cierre del comité.', 40, 5, 12);window.parent.document.getElementById('cargando_pecc').style.display = 'block';"><font color="#FF0000" style="cursor:pointer">&gt;&gt; Finalizaci&oacute;n del Comit&eacute;</font></td>
        </tr>
        <?
		}
		?>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite=<?=$id_comite?>','contenidos')" style="cursor:pointer">&gt;&gt; Puntos del Comit&eacute;</td>
        </tr>
    </table>  
	<?
	}
	function carga_sub_menu_comite_peec($id_item_pecc,$id_tipo_proceso_pecc,$conse_div){
	global $pi2,$vpeec3,$pi8,$g15;
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$titulo_presupuesto = "Valor de la Solicitud para el Permiso";
	
	
	if ($sel_item[6] == 4 or $sel_item[6] == 5){
			$titulo_presupuesto = "Valor de la Solicitud para el Otro S&iacute;";
		}
		
	if ($sel_item[6] == 7){
			$titulo_presupuesto = "Contratos Marco y Valor de la Solicitud";
		}
	if ($sel_item[6] == 8){
			$titulo_presupuesto = "Contratos Marco, Valor y Ordenes de Trabajo";
		}
	if ($sel_item[49] == 1){
		$titulo_presupuesto = "Disponible para Crear OTs";
	}
	
	?>
	<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td align="center" class="fondo_3">Menu</td>
        </tr>
     
        <tr>
          <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>&aplica_log=no','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt; Informaci&oacute;n General</td>
      </tr>
        <?
		
		$sele_presupuesto_si_tiene_creado = traer_fila_row(query_db("select count(*) from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));

        if($sel_item[6] != 6 or ($sele_presupuesto_si_tiene_creado[0]>0 and ($sel_item[14] == 6 or $sel_item[14] == 14))){
		?>
        <tr>
          <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/asignacion-presupuestal.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt;      <?=$titulo_presupuesto?>  </td>
        </tr>
        <?
		}
        if ($sel_item[6] != 6 and $sel_item[6] != 7 and $sel_item[6] != 8 or ($sele_presupuesto_si_tiene_creado[0]>0 and ($sel_item[14] == 6 or $sel_item[14] == 14))){
		?>
         <tr>
           <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/proveedores.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt; Proveedores - proponentes</td>
         </tr>
         <?
		}
		 ?>
         <tr>
           <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/antecedentes.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt; Anexos</td>
         </tr>
         <?
         	if ($sel_item[25] == 1){
		 ?>
         <tr>
           <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/sondeo.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt; Sondeo y Documentaci&oacute;n</td>
         </tr>
          <?
		 		 }
				 
				 
				 $sele_si_aplica_permiso = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item_pecc." and actividad_estado_id = 7"));
				 
				 
if($sel_item[14] != 31 and $sele_si_aplica_permiso[0] > 0){
	
	if($sel_item[14] > 7){
					 	$sel_si_tiene_firmas = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2  and tipo_adj_permiso = 1"));
					 }
					 
		if($sel_si_tiene_firmas[0]>1 or $sel_item[14] <= 7){//verifica si es de historico, si no tiene firmas no muestra el menu
					 
	
		 ?>
         
         <tr>
           <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/aprobaciones.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt; Firmas en el Sistema para el Permiso</td>
         </tr>
         <?
		}
}
         
		 ?>
         
          <?
         if($sel_item[14] >= 10 and $sel_item[14] != 31 and ($sel_item[6] ==1 or $sel_item[6] ==2 or $sel_item[6] ==3)){
		 ?>
         <tr>
           <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/negociacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt; Negociaci&oacute;n - Documentaci&oacute;n</td>
         </tr>
         <?
		 }
         if($sel_item[14] >= 14 and $sel_item[14] != 31 and $id_tipo_proceso_pecc == 1 and $sel_item[6] != 4 and $sel_item[6] != 5){
		 ?>
         <tr>
           <td align="center"  class="fondo_3">Menu de la Adjudicaci&oacute;n</td>
      </tr>
         <tr>
           <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/adjudicacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt; Adjudicaci&oacute;n</td>
         </tr>
         <?
		 		 }
	$sele_si_aplica = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item_pecc." and actividad_estado_id = 16"));
	$muestra = "NO";
	if($sele_si_aplica_permiso[0] <=0 and $sele_si_aplica[0]>=0 and $sel_item[14] >= 6){
		$muestra = "SI";
		}else{
			if($sele_si_aplica[0]>=0 and $sel_item[14] >= 14){
				$muestra = "SI";
				}
			}

if($sel_item[14] != 31 and $muestra == "SI"){
	
	if($sel_item[14] > 7){
					 	$sel_si_tiene_firmas = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2  and tipo_adj_permiso = 2"));
					 }
					 
		if(($sel_si_tiene_firmas[0]>1 or $sel_item[14] <= 14) and $sel_item[39] == ""){//verifica si es de historico, si no tiene firmas no muestra el menu
		 ?>
         
         <tr>
           <td align="left" onclick="ajax_carga('../aplicaciones/comite/pecc/aprobaciones_adjudicacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>','carga_detalle_sol_<?=$conse_div;?>')" style="cursor:pointer">&gt;&gt; Firmas en el Sistema para la Adjudicaci&oacute;n</td>
         </tr>
         <?
		}
}
 				 ?>
        
    </table>  
	<?
	}

/******* PARA EL CAMBIO DE APROBACIOENS DE LA OT******/
function carga_sub_menu_peec_ot($id_item_pecc,$id_tipo_proceso_pecc){
	global $pi2,$vpeec3, $vpeec25,$pi8, $g15,$vpeec18;
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$titulo_presupuesto = "Valor de la Solicitud para el Permiso";
	
	$sel_permisos = "select count(*) from tseg5_usuario_permisos where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=32";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	$elaboracion_contrato = 0;
	if($sql_sel_permisos[0] > 0){
		$elaboracion_contrato = 1;
		}
	
	if ($sel_item[6] == 4 or $sel_item[6] == 5){
			$titulo_presupuesto = "Valor de la Solicitud para el Otro S&iacute;";
		}
		
	if ($sel_item[6] == 7){
			$titulo_presupuesto = "Contratos Marco y Valor de la Solicitud";
		}
	if ($sel_item[6] == 8){
			$titulo_presupuesto = "Valor Ordenes de Trabajo";
		}
	if ($sel_item[6] == 16){
			$titulo_presupuesto = "Valor del Servicio Menor";
		}
	
	if($sel_item[4] <> 1 and $sel_item[6] == 8){
			$titulo_presupuesto = "Valor Ordenes de Pedido";
		}
		
	if ($sel_item[49] == 1){
	//	$titulo_presupuesto = "Disponible para Crear OTs";
	}
	
	?>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td align="center" class="fondo_3">Menu</td>
        </tr>
         <?
	if($sel_item[0] ==8348 or $sel_item[0] ==8349 or $sel_item[0] ==8350 or $sel_item[0] ==8352 or $sel_item[0] ==8353 or $sel_item[0] ==8354 or $sel_item[0] ==8355 or $sel_item[0] ==8356 or $sel_item[0] ==8357 or $sel_item[0] ==8358 or $sel_item[0] ==8359 or $sel_item[0] ==8360 or $sel_item[0] ==8361 or $sel_item[0] ==8362 or $sel_item[0] ==8363  ){
	?>
      <?
	}
	  ?>
        <tr>
        <?
		$sel_presupuesto = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$sel_item[0]." and permiso_o_adjudica = 1"));
		$sel_proveedores = traer_fila_row(query_db("select count(*) from t2_relacion_proveedor where id_item = ".$sel_item[0]." and estado = 1"));
        if($sel_item[6] == 16 and ($sel_presupuesto[0]<=0 )){
			echo "<td>Por favor diligencie el valor y los proveedores</td>";
			}else{
				
				
				if($sel_item[6] == 15){
				$link_info_genneral = "adjudicacion.php";
				}else{
				$link_info_genneral = "edicion-item-pecc.php";	
					}
		?>
          <td onclick="ajax_carga('../aplicaciones/pecc/<?=$link_info_genneral?>?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')" style="cursor:pointer">&gt;&gt; <? if($sel_item[6] == 15){ echo "Datos y Valores de la Modificaci&oacute;n"; }else{ echo "Informaci&oacute;n General";}?></td>
          <?
			}
		  ?>
        </tr>
        <?
		
        if($sel_item[6] == 8){
			$img_parpadea="";
			 $sel_si_tiene_correos = traer_fila_row(query_db("select count(*) from t2_item_ot_correo_relacion_item where id_item = $id_item_pecc "));
			 if($sel_si_tiene_correos[0]==0){
				 $img_parpadea = '<img src="../imagenes/botones/aler-interro.gif" height="15"/>';
				 }
				 
		?>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/pecc/correos_ot.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')" style="cursor:pointer">&gt;&gt; Correos Electronicos del Contratista <?=$img_parpadea?></td>
        </tr>
        
        
        <?
		}
		 if($sel_item[6] == 7 and $sel_item[14]==20){
		?>
		<tr>
          <td onclick="ajax_carga('../aplicaciones/pecc/elabaracion_ampliacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')" style="cursor:pointer">&gt;&gt; Acciones de elaboracion de contrato</td>
        </tr>
		
		<?
		 }
		 
		 
		$sele_presupuesto_si_tiene_creado = traer_fila_row(query_db("select count(*) from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));

        if(($sel_item[6] != 6 and $sel_item[6] != 15) or ($sele_presupuesto_si_tiene_creado[0]>0 and (($sel_item[14] == 6 and $sel_item[6] != 15) or $sel_item[14] == 14))){
		?>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt;      <?=$titulo_presupuesto?></td>
        </tr>
        
        <?
        if ($sel_item[6] == 8 and $sel_item[14] == "no se muestra nunk"){
			?>
			 <tr>
          <td onclick="ajax_carga('../aplicaciones/pecc/asignacion-presupuestal-devolucion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt;      Devolucion de Dinero no Gastado  </td>
        </tr>
			<?
		}
		 if($sel_item[6] == 7 and $sel_item[14]>=20 and $sel_item[14]<>31){
		?>
		<tr>
          <td onclick="ajax_carga('../aplicaciones/pecc/ordenes_de_trabajo_relacionadas.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')" style="cursor:pointer">&gt;&gt; Ordenes de Trabajo Relacionadas</td>
        </tr>
		
		<?
		 }
		?>
        <?
		}
        if ($sel_item[6] != 6  and $sel_item[6] != 7 and $sel_item[6] != 8 and $sel_item[6] != 15 or ($sele_presupuesto_si_tiene_creado[0]>0 and (($sel_item[14] == 6 and $sel_item[6] != 16) or $sel_item[14] == 14))){
		?>
         <tr>
           <td  onclick="ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')"  valign="middle" style="cursor:pointer">&gt;&gt; Proveedores - <? if ($sel_item[6] == 16) echo "Reporte Servicios Menores <img src='../imagenes/botones/aler-interro.gif' height='18' >"; else echo "proponentes";?></td>
         </tr>
         <?
		}
		 if($sel_item[6] == 16 and ($sel_presupuesto[0]<=0)){
		 }else{
		 ?>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/antecedentes.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; <? if($sel_item[4] == 1) echo "Anexos"; else echo "Lista de Materiales y Otros Anexos"; ?></td>
         </tr>
         <?
		 }
         if($sel_item[4] == 2 and $sel_item[14] == 31){
		 ?>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/comunicados_devoluciones.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Comunicados de Devoluciones con el Contratista</td>
         </tr>
         <?
		 }
		 ?>
         
         <?
         	if ($sel_item[25] == 1){
		 ?>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/sondeo.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Sondeo y Documentaci&oacute;n</td>
         </tr>
          <?
		 		 }
				 $sele_si_aplica_permiso = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item_pecc." and actividad_estado_id = 7"));
if($sel_item[14] != 31 and $sele_si_aplica_permiso[0] > 0){
	
	
	if($sel_item[14] > 7){
					 	$sel_si_tiene_firmas = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2 and tipo_adj_permiso = 1"));
					 }
					 
		if($sel_si_tiene_firmas[0]>0 or $sel_item[14] <= 7  and ($sel_item[39] == "" or ($sel_item[14]==6 or $sel_item[14]==7 or $sel_item[14] ==8)) ){//verifica si es de historico, si no tiene firmas no muestra el menu
		 ?>
         
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/aprobaciones.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Firmas en el Sistema para el Permiso</td>
         </tr>
         <?
		}
}
 /* if($sel_item[14] >= 20 and $sel_item[14] != 31 and ($sel_item[6] ==8)){        
		 ?>
          <tr>
            <td onclick="ajax_carga('../aplicaciones/pecc/ob_ots.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Observaciones de la Orden de Trabajo</td>
  </tr>
          <?
}*/
         if($sel_item[14] >= 10 and $sel_item[14] != 31 and ($sel_item[6] ==1 or $sel_item[6] ==2 or $sel_item[6] ==3 or $sel_item[6] ==16)){
		 ?>
        
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/negociacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Negociaci&oacute;n - Documentaci&oacute;n</td>
         </tr>
         <?
		 }

		 if($sel_item[4] <> 1){
		 ?>
		 <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/lista_materiales_sap.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Lista de Materiales SAP</td>
         </tr>
         	 <tr>
           <td onclick="ajax_carga('../enterproc/aplicaciones/evaluacion/resumen_adjudicacion_urna.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')" style="cursor:pointer">&gt;&gt; Resumen adjudicaci&oacute;n Urna</td>
         </tr> 
         <?
		 
		
         
		 $sel_pedido = traer_fila_row(query_db("select count(*) from t2_archivo_sap_pdf where id_item=".$id_item_pecc." "));
		 if( $sel_pedido[0]>0){
		 ?>
         
          <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/pdf_sap.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; PDF SAP</td>
         </tr>
		 <?
		 }
		 
         
		 $sel_entregas= traer_fila_row(query_db("select count(*) from t2_archivo_sap_entregas where id_item=".$id_item_pecc." "));
		 if( $sel_entregas[0]>0){
		 ?>
         
          <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/lista_entregas.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Entregas SAP</td>
         </tr>
		 <?
		 }
		 }
		  if($sel_item[6]==16 and $sel_item[14] == 32){
			  ?>
		 <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/lista_servicios_sap.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Lista del Servicio Menor en SAP</td>
         </tr>
         <?
			 }
		 
		 
		 
		 
         if(($sel_item[14] >= 14 and $sel_item[14] != 31 and $id_tipo_proceso_pecc == 1 and $sel_item[6] != 4 and $sel_item[6] != 5 and $sel_item[6] != 8 and $sel_item[6] != 7 and ($sel_item[6]<> 9 and $sel_item[6]<> 10 and $sel_item[6]<> 11 and $sel_item[6]<> 12 and $sel_item[6]<> 13 and $sel_item[6]<> 14 and $sel_item[6]<> 4 and $sel_item[6]<> 5 and $sel_item[6]<> 16)) ){
		 
		
		 ?>
         
         <tr>
           <td align="center" class="fondo_3">Menu de la Adjudicaci&oacute;n</td>
  </tr>
  <?
		 
  $sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$sel_item[0].""));
$sele_validacion_adicional_marco = traer_fila_row(query_db("SELECT count(*) FROM t2_presupuesto_proveedor_adjudica WHERE        (t2_item_pecc_id_marco = ".$sel_item[0]." and t1_tipo_documento_id = 2)"));
			if($sele_tipo_doc[0]>0 or $sele_validacion_adicional_marco[0]>0){
				$link_adjudicacion = "adjudicacion-marco";
				}else{

					$sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$sel_item[0]."'"));

					if($sele_tipo_doc_desierto[13]==4){
						$link_adjudicacion = "adjudicacion-desierto";
						}else{			
						$link_adjudicacion = "adjudicacion";
						}
				}
  ?>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/<?=$link_adjudicacion?>.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Adjudicaci&oacute;n o Declarar Desierto</td>
         </tr>
  <?
		 		 }
	$sele_si_aplica = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item_pecc." and actividad_estado_id = 16"));
	$muestra = "NO";
	if($sele_si_aplica_permiso[0] <=0 and $sele_si_aplica[0]>=0 and ($sel_item[14] >= 6 or $sel_item[14]==31)){
		$muestra = "SI";
		}else{
			if($sele_si_aplica[0]>=0 and $sel_item[14] >= 14){
				$muestra = "SI";
				}
			
			}
		

if($muestra == "SI" ){
	
	
	
		if($sel_item[6] <> 4 and $sel_item[6] <> 5 and $sel_item[6] <> 8  and $sel_item[6] <> 7 and ($sel_item[6]<> 9 and $sel_item[6]<> 10 and $sel_item[6]<> 11 and $sel_item[6]<> 12  and $sel_item[6]<> 13 and $sel_item[6]<> 14 and $sel_item[6]<> 4 and $sel_item[6]<> 5  and $sel_item[6] <> 15 and $sel_item[6] != 16)){
		 ?>
         
         <tr>
           <td height="26" onclick="ajax_carga('../aplicaciones/pecc/anexos_adjudicacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Anexos de la Adjudicaci&oacute;n</td>
         </tr>
  <?
		}

		if($sel_item[14] > 7){
					 	$sel_si_tiene_firmas = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2  and tipo_adj_permiso = 2"));
					 }
					 
					 $musetra_si_es_historico="SI";
					 
					 if($sel_item[39] <> ""){
						 $musetra_si_es_historico="NO";
						 
						 	if( $sel_item[14] <> 31 and $sel_item[14] > 18){
								//$musetra_si_es_historico="SI";								
									
	$sel_todas_las_secuencias = query_db("select * from t2_agl_secuencia_solicitud where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol not in (8,15, 10, 11)  and estado =1 and por_sistema=2");
							$acabo_firmas="SI";
						while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){
							$sele_aprobar = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_sucun[0]." and aprobado = 1"));
							if($sele_aprobar[0] == 0){
								$acabo_firmas="NO";
								
								}
						}
						if($acabo_firmas=="SI"){
							$musetra_si_es_historico="SI";
							}

									
								}else{
									if($sel_item[14] == 14 or $sel_item[14] == 15 or $sel_item[14] == 16 or $sel_item[14] == 17 or $sel_item[14] == 18 or $sel_item[14] == 6 or $sel_item[14] == 31){
										$musetra_si_es_historico="SI";
										}
									}
								
							
									
										
						 }
			
					 
		if((($sel_si_tiene_firmas[0]>0 or $sel_item[14] <= 14) and ($musetra_si_es_historico=="SI"))  ){//verifica si es de historico, si no tiene firmas no muestra el menu
		 ?>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/aprobaciones_adjudicacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Firmas en el Sistema para la Adjudicaci&oacute;n</td>
         </tr>
         
         <?
		}
}
 		   if($sel_item[29] <> 1){     
		 ?>
         <tr>
           <td align="center" class="fondo_3" >Administraci&oacute;n</td>
  </tr>
  <?
  if($sel_item[14] > 1 and $sel_item[14] <> 31  and $sel_item[39] == ""){
  ?>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/cronograma.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Cronograma e Indicador de Tiempo</td>
         </tr>
         <?
  }
		   }
		  
		 ?>
         <tr style="display:none">
           <td onclick="ajax_carga('../aplicaciones/pecc/check_list.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Check List Completo</td>
         </tr>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/gestion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Gesti&oacute;n</td>
         </tr>
 		<?
         //if ($_SESSION["id_us_session"] == 32){
		 ?>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/gestion_admin.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Gesti&oacute;n Administrativa</td>
         </tr>
         
         <?
//}
		 ?>         
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/log_proceso.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Ver el LOG</td>
         </tr>
         
         <?
		    if($sel_item[39] <> ""){
				$estado_carga_masiva = "Esta solicitud se creo por carga manual";
				
				$sel_si_tiene_firmas_per = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2  and tipo_adj_permiso = 1"));
				$sel_si_tiene_firmas_adj = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2  and tipo_adj_permiso = 2"));
				
				if($sel_si_tiene_firmas_per[0]>0 or $sel_si_tiene_firmas_adj[0]>0){
					$estado_carga_masiva = "Éste permiso se realizó como cargue manual";
					}
				
			   ?>
         <tr>
           <td class="titulos_resumen_alertas" >&lt;&lt; <?=$estado_carga_masiva?> &gt;&gt;</td>
         </tr>
         
         <?
			   
			   }
			   $sel_si_tiene_modificacion = traer_fila_row(query_db("select * from t2_verificacion_modificacion_manual where id_item =".$id_item_pecc));
			   if($sel_si_tiene_modificacion[0]>0){
			   ?>
		  <tr>
           <td class="titulos_resumen_alertas" onclick="ajax_carga('../aplicaciones/pecc/validacion_modificacion_manual.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&lt;&lt; Validaci&oacute;n de Modificaci&oacute;n Manual</td>
         </tr>
			   <?
			   }

         if($elaboracion_contrato == 1){
		 ?>
          <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/admin_solo_congelar.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Congelar el proceso</td>
         </tr>
         
         <?
		 
}

//		 if($_SESSION["id_us_session"] == $sel_item[23] or $_SESSION["id_us_session"] == 32 ){
	
	if(vari_si_reempla($sel_item[23]) == "SI"){
		 ?>
          <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/admin_profesionales.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Administraci&oacute;n de Este Proceso</td>
         </tr>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/reemplazos.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Reemplazos</td>
         </tr>
         
         <?
		 
}
         if($_SESSION["id_us_session"] == 32 or (esprofesionalcompras($id_item_pecc)=="SI" and ($sel_item[14]==7 or $sel_item[14]==16))){
			 
			 if($_SESSION["id_us_session"] == 32){
		 ?>
         <tr>
           <td onclick="ajax_carga('../aplicaciones/pecc/admin.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Administraci&oacute;n de Este Proceso</td>
         </tr>
          
         <?
			 }
         if($_SESSION["id_us_session"] == 32){
		 ?>
         <tr>
          <td onclick="ajax_carga('../aplicaciones/pecc/admin_aprobaciones_adjudicacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Administraci&oacute;n de Firmas de Adjudicacion</td>
          <tr>
            <td onclick="ajax_carga('../aplicaciones/pecc/admin_aprobaciones.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Administraci&oacute;n de Firmas para el Permiso</td>
         </tr>
         <?
				  }
		 }
		 
		 $muestra = "NO";
		 if($sel_item[14] >= 20 and $sel_item[14] != 31){  
		 
		 
		 
		 

		 if($sel_item[6] == 8){//ordenes de trabajo			 
			 
		 
		 if($_SESSION["id_us_session"] == 18245 and $sel_item[3] == 18245){// rol de tatiana
			 $muestra = "SI";
			 
			 }
		
		if($muestra == "NO" and $_SESSION["id_us_session"] == 32){// rol de admin
			 $muestra = "SI";
			}
			
			
		 }else{
			 
			 $usuario_elaboracion_contrato = traer_fila_row(query_db("select count(*)  from v_seg1 where us_id=".$_SESSION["id_us_session"]. " and id_premiso=32"));
			  if($usuario_elaboracion_contrato[0]>0 and $sel_item[6] <> 7){// rol de tatiana
					 $muestra = "SI";
			 
			 }
			 }

		 
		 if( $muestra == "SI"){
		 ?>
         
         </tr>
            <td onclick="ajax_carga('../aplicaciones/pecc/documentos_generados.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')" style="cursor:pointer">&gt;&gt; Documentos Generados</td>
         </tr>
         <?
		 }
		 }
		 ?>
         
    </table>  
	<?
	}
/******* PARA EL CAMBIO DE APROBACIOENS DE LA OT*****/

function carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc){
	/**** PARA EL DESARROLLO DE MOSTRAR LAS MODIFICACIONES *****/
	if($_SESSION["tipo_carga"]!="1"){
		$div_carga="contenidos";
	}else{
		$div_carga="carga_modal_pecc";
	}
	/**** FIN PARA EL DESARROLLO DE MOSTRAR LAS MODIFICACIONES *****/
	global $pi2,$vpeec3, $vpeec25,$pi8, $g15,$vpeec18;
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$titulo_presupuesto = "Valor de la Solicitud para el Permiso";
	
	$sel_permisos = "select count(*) from tseg5_usuario_permisos where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=32";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	$elaboracion_contrato = 0;
	if($sql_sel_permisos[0] > 0){
		$elaboracion_contrato = 1;
		}
	
	if ($sel_item[6] == 4 or $sel_item[6] == 5){
			$titulo_presupuesto = "Valor de la Solicitud para el Otro S&iacute;";
		}
		
	if ($sel_item[6] == 7){
			$titulo_presupuesto = "Contratos Marco y Valor de la Solicitud";
		}
	if ($sel_item[6] == 8){
			$titulo_presupuesto = "Valor Ordenes de Trabajo";
		}
	if ($sel_item[6] == 16){
			$titulo_presupuesto = "Valor del Servicio Menor";
		}
	
	if($sel_item[4] <> 1 and $sel_item[6] == 8){
			$titulo_presupuesto = "Valor Ordenes de Pedido";
		}
		
	if ($sel_item[49] == 1){
	//	$titulo_presupuesto = "Disponible para Crear OTs";
	}
	
	?>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td align="center" class="fondo_3">Menu</td>
        </tr>
         <?
	if($sel_item[0] ==8348 or $sel_item[0] ==8349 or $sel_item[0] ==8350 or $sel_item[0] ==8352 or $sel_item[0] ==8353 or $sel_item[0] ==8354 or $sel_item[0] ==8355 or $sel_item[0] ==8356 or $sel_item[0] ==8357 or $sel_item[0] ==8358 or $sel_item[0] ==8359 or $sel_item[0] ==8360 or $sel_item[0] ==8361 or $sel_item[0] ==8362 or $sel_item[0] ==8363  ){
	?>
      <?
	}
	  ?>
        <tr>
        <?
		$sel_presupuesto = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$sel_item[0]." and permiso_o_adjudica = 1"));
		$sel_proveedores = traer_fila_row(query_db("select count(*) from t2_relacion_proveedor where id_item = ".$sel_item[0]." and estado = 1"));
        if($sel_item[6] == 16 and ($sel_presupuesto[0]<=0 )){
			echo "<td>Por favor diligencie el valor y los proveedores</td>";
			}else{
				
				
				if($sel_item[6] == 15){
				$link_info_genneral = "adjudicacion.php";
				}else{
				$link_info_genneral = "edicion-item-pecc.php";	
					}
		?>
          <td onclick="carga_menu_pecc('../aplicaciones/pecc/<?=$link_info_genneral?>?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; <? if($sel_item[6] == 15){ echo "Datos y Valores de la Modificaci&oacute;n"; }else{ echo "Informaci&oacute;n General";}?></td>
          <?
			}
		  ?>
        </tr>
        <?
		
        if($sel_item[6] == 8){
			$img_parpadea="";
			 $sel_si_tiene_correos = traer_fila_row(query_db("select count(*) from t2_item_ot_correo_relacion_item where id_item = $id_item_pecc "));
			 if($sel_si_tiene_correos[0]==0){
				 $img_parpadea = '<img src="../imagenes/botones/aler-interro.gif" height="15"/>';
				 }
				 
		?>
        <tr>
          <td onclick="carga_menu_pecc('../aplicaciones/pecc/correos_ot.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Correos Electronicos del Contratista <?=$img_parpadea?></td>
        </tr>
        
        
        <?
		}
		 if($sel_item[6] == 7 and $sel_item[14]==20){
		?>
		<tr>
          <td onclick="carga_menu_pecc('../aplicaciones/pecc/elabaracion_ampliacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Acciones de elaboracion de contrato</td>
        </tr>
		
		<?
		 }
		 
		 
		$sele_presupuesto_si_tiene_creado = traer_fila_row(query_db("select count(*) from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));

        if(($sel_item[6] != 6 and $sel_item[6] != 15) or ($sele_presupuesto_si_tiene_creado[0]>0 and (($sel_item[14] == 6 and $sel_item[6] != 15) or $sel_item[14] == 14))){
		?>
        <tr>
          <td onclick="carga_menu_pecc('../aplicaciones/pecc/asignacion-presupuestal.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt;      <?=$titulo_presupuesto?></td>
        </tr>
        
        <?
        if ($sel_item[6] == 8 and $sel_item[14] == "no se muestra nunk"){
			?>
			 <tr>
          <td onclick="carga_menu_pecc('../aplicaciones/pecc/asignacion-presupuestal-devolucion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt;      Devolucion de Dinero no Gastado  </td>
        </tr>
			<?
		}
		 if($sel_item[6] == 7 and $sel_item[14]>=20 and $sel_item[14]<>31){
		?>
		<tr>
          <td onclick="carga_menu_pecc('../aplicaciones/pecc/ordenes_de_trabajo_relacionadas.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Ordenes de Trabajo Relacionadas</td>
        </tr>
		
		<?
		 }
		?>
        <?
		}
        if ($sel_item[6] != 6  and $sel_item[6] != 7 and $sel_item[6] != 8 and $sel_item[6] != 15 or ($sele_presupuesto_si_tiene_creado[0]>0 and (($sel_item[14] == 6 and $sel_item[6] != 16) or $sel_item[14] == 14))){
		?>
         <tr>
           <td  onclick="carga_menu_pecc('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')"  valign="middle" style="cursor:pointer">&gt;&gt; Proveedores - <? if ($sel_item[6] == 16) echo "Reporte Servicios Menores <img src='../imagenes/botones/aler-interro.gif' height='18' >"; else echo "proponentes";?></td>
         </tr>
         <?
		}
		 if($sel_item[6] == 16 and ($sel_presupuesto[0]<=0)){
		 }else{
		 ?>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/antecedentes.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; <? if($sel_item[4] == 1) echo "Anexos"; else echo "Lista de Materiales y Otros Anexos"; ?></td>
         </tr>
         <?
		 }
         if($sel_item[4] == 2 and $sel_item[14] == 31){
		 ?>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/comunicados_devoluciones.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Comunicados de Devoluciones con el Contratista</td>
         </tr>
         <?
		 }
		 ?>
         
         <?
         	if ($sel_item[25] == 1){
		 ?>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/sondeo.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Sondeo y Documentaci&oacute;n</td>
         </tr>
          <?
		 		 }
				 $sele_si_aplica_permiso = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item_pecc." and actividad_estado_id = 7"));
if($sel_item[14] != 31 and $sele_si_aplica_permiso[0] > 0){
	
	
	if($sel_item[14] > 7){
					 	$sel_si_tiene_firmas = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2 and tipo_adj_permiso = 1"));
					 }
					 
		if($sel_si_tiene_firmas[0]>0 or $sel_item[14] <= 7  and ($sel_item[39] == "" or ($sel_item[14]==6 or $sel_item[14]==7 or $sel_item[14] ==8)) ){//verifica si es de historico, si no tiene firmas no muestra el menu
		 ?>
         
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/aprobaciones.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Firmas en el Sistema para el Permiso</td>
         </tr>
         <?
		}
}
 /* if($sel_item[14] >= 20 and $sel_item[14] != 31 and ($sel_item[6] ==8)){        
		 ?>
          <tr>
            <td onclick="carga_menu_pecc('../aplicaciones/pecc/ob_ots.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Observaciones de la Orden de Trabajo</td>
  </tr>
          <?
}*/
         if($sel_item[14] >= 10 and $sel_item[14] != 31 and ($sel_item[6] ==1 or $sel_item[6] ==2 or $sel_item[6] ==3 or $sel_item[6] ==16)){
		 ?>
        
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/negociacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Negociaci&oacute;n - Documentaci&oacute;n</td>
         </tr>
         <?
		 }
	?>
	<?
         /**** PARA EL DESARROLLO DE MOSTRAR LAS MODIFICACIONES *****/
	$id_modifiacion=traer_fila_row(query_db("select * from ".$pi2." where id_item=".$id_item_pecc));
	$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3, id_item from $pi2 where id_item=".$id_modifiacion[43]));
		if($id_modifiacion[43]>0 and $id_modifiacion[69]==1){//si la solicitud tiene modificaciones

	?>
	</tr>
            <td onclick="document.getElementById('carga_modal_pecc').style.display='block';ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sel_item_relacionado[3]?>&id_tipo_proceso_pecc=1&tipo_carga=99','carga_modal_pecc')" style="cursor:pointer">&gt;&gt; Ver Solicitud Original</td>
         </tr>

		<?

		}
	/**** FIN PARA EL DESARROLLO DE MOSTRAR LAS MODIFICACIONES *****/
	
		

		 if($sel_item[4] <> 1){
		 ?>
		 <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/lista_materiales_sap.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Lista de Materiales SAP</td>
         </tr>
         	 <tr>
           <td onclick="carga_menu_pecc('../enterproc/aplicaciones/evaluacion/resumen_adjudicacion_urna.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Resumen adjudicaci&oacute;n Urna</td>
         </tr> 
         <?
		 
		
         
		 $sel_pedido = traer_fila_row(query_db("select count(*) from t2_archivo_sap_pdf where id_item=".$id_item_pecc." "));
		 if( $sel_pedido[0]>0){
		 ?>
         
          <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/pdf_sap.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; PDF SAP</td>
         </tr>
		 <?
		 }
		 
         
		 $sel_entregas= traer_fila_row(query_db("select count(*) from t2_archivo_sap_entregas where id_item=".$id_item_pecc." "));
		 if( $sel_entregas[0]>0){
		 ?>
         
          <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/lista_entregas.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Entregas SAP</td>
         </tr>
		 <?
		 }
		 }
		  if($sel_item[6]==16 and $sel_item[14] == 32){
			  ?>
		 <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/lista_servicios_sap.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Lista del Servicio Menor en SAP</td>
         </tr>
         <?
			 }
		 
		 
		 
		 
         if(($sel_item[14] >= 14 and $sel_item[14] != 31 and $id_tipo_proceso_pecc == 1 and $sel_item[6] != 4 and $sel_item[6] != 5 and $sel_item[6] != 8 and $sel_item[6] != 7 and ($sel_item[6]<> 9 and $sel_item[6]<> 10 and $sel_item[6]<> 11 and $sel_item[6]<> 12 and $sel_item[6]<> 13 and $sel_item[6]<> 14 and $sel_item[6]<> 4 and $sel_item[6]<> 5 and $sel_item[6]<> 16)) ){
		 
		
		 ?>
         
         <tr>
           <td align="center" class="fondo_3">Menu de la Adjudicaci&oacute;n</td>
  </tr>
  <?
		 
  $sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$sel_item[0].""));
$sele_validacion_adicional_marco = traer_fila_row(query_db("SELECT count(*) FROM t2_presupuesto_proveedor_adjudica WHERE        (t2_item_pecc_id_marco = ".$sel_item[0]." and t1_tipo_documento_id = 2)"));
			if($sele_tipo_doc[0]>0 or $sele_validacion_adicional_marco[0]>0){
				$link_adjudicacion = "adjudicacion-marco";
				}else{

					$sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$sel_item[0]."'"));

					if($sele_tipo_doc_desierto[13]==4){
						$link_adjudicacion = "adjudicacion-desierto";
						}else{			
						$link_adjudicacion = "adjudicacion";
						}
				}
  ?>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/<?=$link_adjudicacion?>.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Adjudicaci&oacute;n o Declarar Desierto</td>
         </tr>
  <?
		 		 }
	$sele_si_aplica = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item_pecc." and actividad_estado_id = 16"));
	$muestra = "NO";
	if($sele_si_aplica_permiso[0] <=0 and $sele_si_aplica[0]>=0 and $sel_item[14] >= 6){
		$muestra = "SI";
		}else{
			if(($sele_si_aplica[0]>=0 and $sel_item[14] >= 14) ){
				$muestra = "SI";
				}
			}
		
if(($sel_item[14] <> 31 and $muestra == "SI" ) ){
	
	
	
		if($sel_item[6] <> 4 and $sel_item[6] <> 5 and $sel_item[6] <> 8  and $sel_item[6] <> 7 and ($sel_item[6]<> 9 and $sel_item[6]<> 10 and $sel_item[6]<> 11 and $sel_item[6]<> 12  and $sel_item[6]<> 13 and $sel_item[6]<> 14 and $sel_item[6]<> 4 and $sel_item[6]<> 5  and $sel_item[6] <> 15 and $sel_item[6] != 16)){
		 ?>
         
         <tr>
           <td height="26" onclick="carga_menu_pecc('../aplicaciones/pecc/anexos_adjudicacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Anexos de la Adjudicaci&oacute;n</td>
         </tr>
  <?
		}

		if($sel_item[14] > 7){
					 	$sel_si_tiene_firmas = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2  and tipo_adj_permiso = 2"));
					 }
					 
					 $musetra_si_es_historico="SI";
					 
					 if($sel_item[39] <> ""){
						 $musetra_si_es_historico="NO";
						 
						 	if( $sel_item[14] <> 31 and $sel_item[14] > 18){
								//$musetra_si_es_historico="SI";								
									
	$sel_todas_las_secuencias = query_db("select * from t2_agl_secuencia_solicitud where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol not in (8,15, 10, 11)  and estado =1 and por_sistema=2");
							$acabo_firmas="SI";
						while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){
							$sele_aprobar = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_sucun[0]." and aprobado = 1"));
							if($sele_aprobar[0] == 0){
								$acabo_firmas="NO";
								
								}
						}
						if($acabo_firmas=="SI"){
							$musetra_si_es_historico="SI";
							}

									
								}else{
									if($sel_item[14] == 14 or $sel_item[14] == 15 or $sel_item[14] == 16 or $sel_item[14] == 17 or $sel_item[14] == 18 or $sel_item[14] == 6){
										$musetra_si_es_historico="SI";
										}
									}
								
							
									
										
						 }
			
					 
if((($sel_si_tiene_firmas[0]>0 or $sel_item[14] <= 14) and ($musetra_si_es_historico=="SI"))  ){//verifica si es de historico, si no tiene firmas no muestra el menu
		 ?>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/aprobaciones_adjudicacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Firmas en el Sistema para la Adjudicaci&oacute;n</td>
         </tr>
         
         <?
		}
}
 		   if($sel_item[29] <> 1){     
		 ?>
         <tr>
           <td align="center" class="fondo_3" >Administraci&oacute;n</td>
  </tr>
  <?
  if($sel_item[14] > 1 and $sel_item[14] <> 31  and $sel_item[39] == ""){
  ?>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/cronograma.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Cronograma e Indicador de Tiempo</td>
         </tr>
         <?
  }
		   }
		  
		 ?>
         <tr style="display:none">
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/check_list.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Check List Completo</td>
         </tr>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/gestion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Gesti&oacute;n</td>
         </tr>
 		<?
         //if ($_SESSION["id_us_session"] == 32){
		 ?>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/gestion_admin.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Gesti&oacute;n Administrativa</td>
         </tr>
         
         <?
//}
		 ?>         
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/log_proceso.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Ver el LOG</td>
         </tr>
         
         <?
		    if($sel_item[39] <> ""){
				$estado_carga_masiva = "Esta solicitud se creo por carga manual";
				
				$sel_si_tiene_firmas_per = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2  and tipo_adj_permiso = 1"));
				$sel_si_tiene_firmas_adj = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where  id_item_pecc = ".$id_item_pecc." and por_sistema = 2  and tipo_adj_permiso = 2"));
				
				if($sel_si_tiene_firmas_per[0]>0 or $sel_si_tiene_firmas_adj[0]>0){
					$estado_carga_masiva = "Éste permiso se realizó como cargue manual";
					}
				
				
				
			   ?>
         <tr>
           <td class="titulos_resumen_alertas" >&lt;&lt; <?=$estado_carga_masiva?> &gt;&gt;</td>
         </tr>
         
         <?
			   
				   if($_SESSION["id_us_session"] == "inactivo este permiso para todos los usaurios"){
					
					?><tr>
           <td class="titulos_resumen_alertas" onclick="carga_menu_pecc('../aplicaciones/pecc/admin_modificacion_manual.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&lt;&lt; Modificaci&oacute;n de Cargue Manual &gt;&gt;</td>
         </tr><?
					
					}
			   }
			   $sel_si_tiene_modificacion = traer_fila_row(query_db("select * from t2_verificacion_modificacion_manual where id_item =".$id_item_pecc));
			   if($sel_si_tiene_modificacion[0]>0){
			   ?>
		  <tr>
           <td class="titulos_resumen_alertas" onclick="carga_menu_pecc('../aplicaciones/pecc/validacion_modificacion_manual.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&lt;&lt; Validaci&oacute;n de Modificaci&oacute;n Manual</td>
         </tr>
			   <?
			   }

         if($elaboracion_contrato == 1){
		 ?>
          <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/admin_solo_congelar.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Congelar el proceso</td>
         </tr>
         
         <?
		 
}

//		 if($_SESSION["id_us_session"] == $sel_item[23] or $_SESSION["id_us_session"] == 32 ){
	
	if(vari_si_reempla($sel_item[23]) == "SI"){
		 ?>
          <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/admin_profesionales.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Administraci&oacute;n de Este Proceso</td>
         </tr>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/reemplazos.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Reemplazos</td>
         </tr>
         
         <?
		 
}
         if($_SESSION["id_us_session"] == 32 or (esprofesionalcompras($id_item_pecc)=="SI" and ($sel_item[14]==7 or $sel_item[14]==16))){
			 
			 if($_SESSION["id_us_session"] == 32){
		 ?>
         <tr>
           <td onclick="carga_menu_pecc('../aplicaciones/pecc/admin.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Administraci&oacute;n de Este Proceso</td>
         </tr>
          
         <?
			 }
         if($_SESSION["id_us_session"] == 32){
		 ?>
         <tr>
          <td onclick="carga_menu_pecc('../aplicaciones/pecc/admin_aprobaciones_adjudicacion.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Administraci&oacute;n de Firmas de Adjudicacion</td>
          <tr>
            <td onclick="carga_menu_pecc('../aplicaciones/pecc/admin_aprobaciones.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Administraci&oacute;n de Firmas para el Permiso</td>
         </tr>
         <?
				  }
		 }
		 
		 $muestra = "NO";
		 if($sel_item[14] >= 20 and $sel_item[14] != 31){  
		 
		 
		 
		 

		 if($sel_item[6] == 8){//ordenes de trabajo			 
			 
		 
		 if($_SESSION["id_us_session"] == 18245 and $sel_item[3] == 18245){// rol de tatiana
			 $muestra = "SI";
			 
			 }
		
		if($muestra == "NO" and $_SESSION["id_us_session"] == 32){// rol de admin
			 $muestra = "SI";
			}
			
			
		 }else{
			 
			 $usuario_elaboracion_contrato = traer_fila_row(query_db("select count(*)  from v_seg1 where us_id=".$_SESSION["id_us_session"]. " and id_premiso=32"));
			  if($usuario_elaboracion_contrato[0]>0 and $sel_item[6] <> 7){// rol de tatiana
					 $muestra = "SI";
			 
			 }
			 }

		 
		 if( $muestra == "SI"){
		 ?>
         
         </tr>
            <td onclick="carga_menu_pecc('../aplicaciones/pecc/documentos_generados.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','<?=$div_carga;?>')" style="cursor:pointer">&gt;&gt; Documentos Generados</td>
         </tr>
         <?
		 }
		 }
		 ?>
         
    </table>  
	<?
	$_SESSION["tipo_carga"]="";
	}
	
	function encabezado_comite($id_comite){
		global $c1;
$selec_si_hay_numero = traer_fila_row(query_db("select * from $c1 where id_comite = ".$id_comite.""));

if($selec_si_hay_numero[4]==2){
		  $estado_comi_cabeza= "Estado: En Preparaci&oacute;n";
		  }
	 if($selec_si_hay_numero[4]==1 and $selec_si_hay_numero[10] == 2){
		  $estado_comi_cabeza= "Estado: Finalizado";
		  }
	if($selec_si_hay_numero	[4]==3){
		  $estado_comi_cabeza= "Estado: En Proceso de Aprobaci&oacute;n";
		  }
	if($selec_si_hay_numero[10] != 2){
			$estado_comi_cabeza = $estado_comi_cabeza." - Agregando Solicitudes";
		}

	?>
    <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      
      <tr>
        <td class="titulos_secciones">

        Comit&eacute;: <?=numero_item_pecc($selec_si_hay_numero[6],$selec_si_hay_numero[7],$selec_si_hay_numero[8])?> 
        Fecha: <?=$selec_si_hay_numero[2]?>
        </td>
        <td class="titulos_secciones">
      	<?=$estado_comi_cabeza?>
      </td>
        
      </tr>
      
    </table>
	<?
	}
function encabezado_item_pecc($id_item){
$pi1="t2_pecc";
$pi2="t2_item_pecc";
$g10="t1_trm";
$g1="t1_us_usuarios";
global $pi4;
global $pi6;
global $pi7,$vpeec25;
	$sel_item_funt = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item));
	$id_pecc_fun = $sel_item_funt[1];
	$sel_pecc_funt = traer_fila_row(query_db("select $pi1.id_pecc,$pi1.ano,$pi1.objeto,$g1.nombre_administrador, $g10.valor, $pi1.nombre, $g10.id_trm from $pi1, $g1, $g10 where $pi1.id_pecc = ".$id_pecc_fun." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	$sel_estado = traer_fila_row(query_db("select t1.nombre, t2.nombre, t3.nombre from $pi4 as t1, $pi6 as t2, $pi7 as t3 where t1.t2_nivel_servicio_actividad_id = ".$sel_item_funt[14]." and t1.t2_nivel_servicio_encargado_id = t2.t2_nivel_servicio_encargado_id and t1.t2_nivel_servicio_seccion_id = t3.t2_nivel_servicio_seccion_id"));
	
	if($sel_item_funt[14] == 32){
			if($sel_item_funt[44] == 1){
			$esta_procc = "Finalizado - RECHAZADO";
			}elseif($sel_item_funt[45] == 1){
				$esta_procc = "Finalizado - DECLARADO DESIERTO";
				}else{
				$esta_procc = "Finalizado";
				}
		}else{
			$esta_procc = $sel_estado[0];
			}
			
			
	if($sel_item_funt[30] == 1){
		$esta_procc = "Congelado";
		}
		
		$id_tipo_proceso_pecc = 1;
		if($sel_item[10] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_item[10] == 8){
					$id_tipo_proceso_pecc = 3;
				}
				
				
		$link ="";
		if($sel_item_funt[14] == 2 or $sel_item_funt[14] == 3 or $sel_item_funt[14] == 4 or $sel_item_funt[14] == 5){
			$link = "sondeo.php";
			}
		if($sel_item_funt[14] == 7 or $sel_item_funt[14] == 8 or $sel_item_funt[14] == 9){
			$link = "aprobaciones.php";
			}
		if($sel_item_funt[14] == 10 or $sel_item_funt[14] == 11 or $sel_item_funt[14] == 12 or $sel_item_funt[14] == 13) {
			$link = "negociacion.php";
			}
		if($sel_item_funt[14] == 14 or $sel_item_funt[14] == 15) {
			$sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$id_item.""));
			if($sele_tipo_doc[0]>0){
				$link = "adjudicacion-marco.php";
				}else{
					$link = "adjudicacion.php";
				}
				
			}
		if($sel_item_funt[14] == 16 or $sel_item_funt[14] == 17 or $sel_item_funt[14] == 18){
			$link = "aprobaciones_adjudicacion.php";
			}
			
			
			
			if($link != ""){
				$ajax_cc = "onclick=ajax_carga('../aplicaciones/pecc/".$link."?id_item_pecc=".$id_item."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','contenidos')";
				}

	?>
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
	<?
	if($_SESSION["tipo_carga"]!="1"){ ?>
      <tr>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><strong class='link_volver' style='cursor:pointer;' onclick="ajax_carga('../aplicaciones/pecc/historico.php?tipo_ajax=1&amp;paginas=<?=$_SESSION['paginass']?>&amp;id_pecc=<?=$_SESSION['id_peccs']?>&amp;id_tipo_proceso_pecc=<?=$_SESSION['id_tipo_proceso_peccs']?>&amp;numero1_pecc=<?=$_SESSION['numero1_peccs']?>&amp;numero2_pecc=<?=$_SESSION['numero2_peccs']?>&amp;numero3_pecc=<?=$_SESSION['numero3_peccs']?>&amp;bus_area=<?=$_SESSION['bus_areas']?>&amp;bus_text1=<?=$_SESSION['bus_text1s']?>&amp;bus_text2=<?=$_SESSION['bus_text2s']?>&amp;bus_text3=<?=$_SESSION['bus_text3s']?>&amp;bus_text4=<?=$_SESSION['bus_text4s']?>&amp;bus_text5=<?=$_SESSION['bus_text5s']?>&profesional_cyc=<?=$_SESSION['profesional_cycs']?>&usuario_permiso=<?=$_SESSION['usuario_permisos']?>&estado_busr=<?=$_SESSION['estado_busrs']?>&tipo_contratacion=<?=$_SESSION['tipo_contratacions']?>&preparador_b=<?=$_SESSION['preparador_bs']?>&muestra_finalizados=<?=$_SESSION['muestra_finalizadoss'] ?>&tp_proceso_busca=<?=$_SESSION['tp_proceso_buscas']?>&num_solped_bus=<?=$_SESSION['num_solped_buss']?>&origen_pecc=<?=$_SESSION["origen_pecc_bus"]?>','contenidos')">Volver a la Busqueda&nbsp;&nbsp;&nbsp;</strong></td>

      </tr>
  <?}else{ ?>
       <tr>
        <td ><h1 class="left">Informaci&oacute;n de la Modificaci&oacute;n</h1></td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">
        	<a onclick='limpia_session()' class='waves-effect waves-light btn right' style='background-color: #229BFF; float: right; margin-right: 0% !important;'><i class='material-icons left'>&#xE5CD;</i></a>
      </tr>
		
<?	}
?>
      <tr>
        <td width="35%" >&nbsp;</td>
        <td width="14%" ><strong>Secci&oacute;n:</strong>

            <?
            if(($sel_item_funt[14] == 20 or $sel_item_funt[14] == 21) and $sel_item_funt[4] <> 1){
				echo "Completamiento";
				}else{
				echo $sel_estado[2];
				}
			
			?>
        </td>
        <td width="24%"><strong>Encargado:</strong>
        <?
            if(($sel_item_funt[14] == 12 or $sel_item_funt[14] == 19) and $sel_item_funt[4] <> 1){
				echo "secretario del comite";
				}elseif(($sel_item_funt[14] == 20 or $sel_item_funt[14] == 21 or $sel_item_funt[14] == 6 or $sel_item_funt[14] == 14 or $sel_item_funt[14] == 11 or $sel_item_funt[14] == 12) and $sel_item_funt[4] <> 1){
				echo "Comprador";
				}else{
					echo $sel_estado[1];
					}
				
				
			
			?>
				</td>
        <td width="27%"><strong>Estado: </strong>
            <span class="titulos_resumen_alertas" <?=$ajax_cc?>> 
			<?
			if ($sel_item_funt[4] <> 1){// si es compras
            
				if($sel_item_funt[14] == 20 and $sel_item_funt[4] <> 1){
					echo "Completamiento Adjudicaci&oacute;n - URNA";
					}elseif($sel_item_funt[14] == 21 and $sel_item_funt[4] <> 1){
						echo "Legalizaci&oacute;n del Pedido (recibido del Proveedor)";
						}else{
							echo $esta_procc;
							}
						
			}elseif($sel_item_funt[14] > 20 and $sel_item_funt[14] < 31 and $sel_item_funt[30] <> 1){ // si es servicios
					echo "En Legalizaci&oacute;n";
				}else{
					echo $esta_procc;
					}
				
			if($sel_item_funt[14]==33){// para mostrar la observación y descargar el archivo cuando es eliminado
		//echo "select observacion, adjunto, id_accion_admin from v_reporte_solicitudes_eliminadas  WHERE id_item=".$id_item;
			$detalle_eliminado = traer_fila_row(query_db("select observacion, adjunto, id_accion_admin from v_reporte_solicitudes_eliminadas  WHERE id_item=".$id_item." order by id_accion_admin desc"));
			echo "&nbsp;<br>Observación: ".$detalle_eliminado[0]; ?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$detalle_eliminado[1]?>&n1=<?=$detalle_eliminado[2]?><?=$id_item?>&n3=4" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($detalle_eliminado[1])?>.gif" width="16" height="16" /></a></td>
      <?
	}
			?>
	
            
        </span></td>
      </tr>
      <?
	  $id_comite_ad = traer_fila_row(query_db("select id_comite from t3_comite_relacion_item where id_item = ".$sel_item_funt[0]." and permiso_o_adjudica = 2 order by id_relacion desc"));
	  $id_comite_per = traer_fila_row(query_db("select id_comite from t3_comite_relacion_item where id_item = ".$sel_item_funt[0]." and permiso_o_adjudica = 1 order by id_relacion desc"));
	  
	  if($id_comite_ad[0]>0 or $id_comite_per[0]>0){
		$id_comite_apro = $id_comite_per[0];
		$permiso_ad = 1;
		if($id_comite_ad[0]>0){
			$id_comite_apro = $id_comite_ad[0];
			$permiso_ad = 2;
			}
		  
		  
		  
	  $sel_datos_comite = traer_fila_Row(query_db("select num1, num2, num3 from t3_comite where id_comite = ".$id_comite_apro));
	  ?>
      <tr>
        <td colspan="4" align="left" > <strong style="cursor:pointer" onClick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/comite/aprobacion.php?id_item_consulta_firma=<?=$sel_item_funt[0]?>&id_comite=<?=$id_comite_apro?>&permiso_o_adjudica=<?=$permiso_ad?>","div_carga_busca_sol")'>Click aqu&iacute; para ver la aprobaci&oacute;n del comit&eacute; <?=numero_item_pecc($sel_datos_comite[0],$sel_datos_comite[1],$sel_datos_comite[2])?></strong></td>
      </tr>
      
      
      <?
	  }
	  ?><tr>
        <td colspan="4"  class="titulos_secciones">
        <?
        	if($id_pecc_fun != 1){
		?>
        PECC: <?=$sel_pecc_funt[5]?> - 
        <?
			}
		?>
        ITEM No.: <?=numero_item_pecc($sel_item_funt[16],$sel_item_funt[17],$sel_item_funt[18])?>         - <span style="font-size:12px; color:#666">Contratos Relacionados: <?=contratos_relacionados_solicitud_para_campos($sel_item_funt[0])?></span></td>
      </tr>
   <?
   if($ver=="esto es para bloquear"){
   ?>   
      <tr style="display:none">
        <td colspan="4"  class="titulos_secciones"><table width="600" border="0" align="right" class="tabla_lista_resultados">
          <tr>
            <td width="91" rowspan="2" class="fondo_3"><font size="2">Check List</font></td>
            <td width="67" align="center" class="fondo_3"><font size="1">Solicitante</font></td>
            <td width="119" align="center" class="fondo_3"><font size="1">Profesional de Abastecimiento / Compras</font></td>
            <td width="130" align="center" class="fondo_3"><font size="1">GERENTE DE EQUIPO / JEFE DE EQUIPO</font></td>
            <td width="61" align="center" class="fondo_3"><font size="1">HSSE</font></td>
            <td width="48" align="center" class="fondo_3"><font size="1">LEGAL</font></td>
            <td width="50" align="center" class="fondo_3"><font size="1">FINANZAS</font></td>
          </tr>
          <tr>
            <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="" width="23" height="20" /></td>
            <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="a" width="16" height="16" /></td>
            <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="a" width="16" height="16" /></td>
            <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="a" width="16" height="16" /></td>
            <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="a" width="16" height="16" /></td>
            <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="a" width="16" height="16" /></td>
          </tr>
        </table></td>
      </tr>
      <?
}
	  ?>
    </table>
	<?
	}
	
	function encabezado_item_pecc_imprimir($id_item){
$pi1="t2_pecc";
$pi2="t2_item_pecc";
$g10="t1_trm";
$g1="t1_us_usuarios";
global $pi4;
global $pi6;
global $pi7;
	$sel_item_funt = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item));
	$id_pecc_fun = $sel_item_funt[1];
	$sel_pecc_funt = traer_fila_row(query_db("select $pi1.id_pecc,$pi1.ano,$pi1.objeto,$g1.nombre_administrador, $g10.valor, $pi1.nombre, $g10.id_trm from $pi1, $g1, $g10 where $pi1.id_pecc = ".$id_pecc_fun." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	$sel_estado = traer_fila_row(query_db("select t1.nombre, t2.nombre, t3.nombre from $pi4 as t1, $pi6 as t2, $pi7 as t3 where t1.t2_nivel_servicio_actividad_id = ".$sel_item_funt[14]." and t1.t2_nivel_servicio_encargado_id = t2.t2_nivel_servicio_encargado_id and t1.t2_nivel_servicio_seccion_id = t3.t2_nivel_servicio_seccion_id"));
	
	if($sel_item_funt[14] == 32){
			$esta_procc = "Finalizado";
		}else{
			$esta_procc = $sel_estado[0];
			}
	if($sel_item_funt[30] == 1){
		$esta_procc = "Congelado";
		}
		
	
	?>
    <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
      <tr>
        <td width="35%" >&nbsp;</td>
        <td width="14%" ><strong>Secci&oacute;n:</strong>
            <?=$sel_estado[2]?>
        </td>
        <td width="24%"><strong>Encargado:</strong>
        <?=$sel_estado[1]?></td>
        <td width="27%"><strong>Estado: </strong>
            <span class="titulos_resumen_alertas"> <?=$esta_procc?>
        </span></td>
      </tr>
      <tr>
        <td colspan="4"  class="titulos_secciones">
        <?
        	if($id_pecc_fun != 1){
		?>
        PECC: <?=$sel_pecc_funt[5]?> - 
        <?
			}
		?>
        ITEM No.: <?=numero_item_pecc($sel_item_funt[16],$sel_item_funt[17],$sel_item_funt[18])?></td>
      </tr>
    </table>
	<?
	}
	
	function numero_item_pecc_contrato($numero1, $numero2, $numero3, $numero4, $id_contrato_para_el_numero){
			
			$cuantos_en_numero = strlen($numero3);
			
				if($cuantos_en_numero == 1){
						$numero3 = "000".$numero3;
					}
				if($cuantos_en_numero == 2){
						$numero3 = "00".$numero3;
					}
				if($cuantos_en_numero == 3){
						$numero3 = "0".$numero3;
					}
				if($numero4 != ""){
						$numero4_fin = $numero4;
					}
					
				if($numero2 == "09"){
					$numero2 ="9";
					}
				if($numero2 == "08"){
					$numero2 ="8";
					}
				if($numero2 == "07"){
					$numero2 ="7";
					}
				if($numero2 == "06"){
					$numero2 ="6";
					}
				if($numero2 == "05"){
					$numero2 ="5";
					}
				if($numero2 == "04"){
					$numero2 ="4";
					}
				if($numero2 == "03"){
					$numero2 ="3";
					}
				
						
				$numero4 = str_replace(".","",$numero4);

			$numero = $numero1.$numero2."-".$numero3.$numero4.tipo_bien_servicio_con_contrato($id_contrato_para_el_numero);
			if($numero4 == "CO&M012011" or $numero4 == "CO&M062008" or $numero4 == "GAS0082012" or $numero4 == "GCI0012010" or $numero4 == "GCI0022010" or $numero4 == "GAS0152007"){
				return $numero4;
				}else{
				return $numero;
				}
		}
		
	function numero_item_pecc($numero1, $numero2, $numero3){
			
			$cuantos_en_numero = strlen($numero3);
				if($cuantos_en_numero == 1){
						$numero3 = "000".$numero3;
					}
				if($cuantos_en_numero == 2){
						$numero3 = "00".$numero3;
					}
				if($cuantos_en_numero == 3){
						$numero3 = "0".$numero3;
					}
					
			$numero = $numero1.$numero2."-".$numero3;
			return $numero;
		}
		
	
	function imprime_observacion($id_contrato,$id_complemento,$campo){
		global $co8;
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		$id_complemento_arr = elimina_comillas(arreglo_recibe_variables($id_complemento));//recibe id
		$campo_arr = $campo;//recibe id

		$busca_contrato_obs = "select CAST(observacion AS text) from $co8 where id_contrato = $id_contrato_arr and id_complemento = $id_complemento_arr and campo = '$campo_arr' and estado = 1 order by id desc";
		$sql_con_obs=traer_fila_row(query_db($busca_contrato_obs));
		$esta = $sql_con_obs[0];
		return $esta;
	}
	
	function estado_contrato_retu($id_contrato,$tabla){
		global $est_creacion,$est_abastecimiento,$est_sap,$est_revision,$est_firma_hocol,$est_firma_contratista,$est_poliza,$est_legalizacion,$est_gerente_contrato,$est_finalizado,$est_terminado_finalizado;
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		$busca_contrato_es = "select estado,sel_representante from $tabla where id = $id_contrato_arr";
		$sql_con_es=traer_fila_row(query_db($busca_contrato_es));
		$esta = "";
		
		if($sql_con_es[0]==$est_creacion){
			$esta = "Elaboraci&oacute;n de contrato";			
		}
		
		if($sql_con_es[0]==$est_abastecimiento){
			$esta = "Recibido Abastecimiento";			
		}
		if($sql_con_es[0]==$est_sap){
			$esta = "SAP";			
		}
		if($sql_con_es[0]==$est_revision){
			$esta = "Revisi&oacute;n Legal";			
		}

			
		if($sql_con_es[0]==$est_firma_hocol){
			if($sql_con_es[1]==1){
				$tipo_fir = "Contratista";												
			}
			
			if($sql_con_es[1]==2){
				$tipo_fir = "Hocol";
			}
			$esta = "Firma Representante ".$tipo_fir;			
		}
		if($sql_con_es[0]==$est_firma_contratista){
			if($sql_con_es[1]==2){
				$tipo_fir = "Contratista";												
			}
			if($sql_con_es[1]==1){
				$tipo_fir = "Hocol";
			}
			$esta = "Firma Representante ".$tipo_fir;			
		}
		if($sql_con_es[0]==$est_poliza){
			$esta = "Revisi&oacute;n P&oacute;lizas";			
		}
		
		if($sql_con_es[0]==$est_gerente_contrato){
			$esta = "Gerente Contrato";			
		}
		
		if($sql_con_es[0]==$est_legalizacion){
			$esta = "Legalizaci&oacute;n Final Contrato";			
		}
		
		if($sql_con_es[0]==$est_finalizado){
			$esta = "Legalizado";			
		}
		
		if($sql_con_es[0]==$est_terminado_finalizado){
			$esta = "Contrato Finalizado";			
		}
		
		if($sql_con_es[0]==33){
			$esta = "<strong>Eliminado</strong>";			
		}
		
		return $esta ;
	}
	
	
	
	function estado_contrato_retu_campo($id_contrato,$tabla){
		global $est_creacion,$est_abastecimiento,$est_sap,$est_revision,$est_firma_hocol,$est_firma_contratista,$est_poliza,$est_legalizacion,$est_gerente_contrato,$est_finalizado;
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		$busca_contrato_es = "select estado,sel_representante from $tabla where id = $id_contrato_arr";
		$sql_con_es=traer_fila_row(query_db($busca_contrato_es));
		$esta = "";
		
		if($sql_con_es[0]==$est_creacion){
			$esta = "Elaboracion de contrato";			
		}
		
		if($sql_con_es[0]==$est_abastecimiento){
			$esta = "recibido_abastecimiento";			
		}
		if($sql_con_es[0]==$est_sap){
			$esta = "sap";			
		}
		if($sql_con_es[0]==$est_revision){
			$esta = "revision_legal";			
		}

		
					
		if($sql_con_es[0]==$est_firma_hocol){
			
				$tipo_fir = "_Hocol";
			
			$esta = "firma".$tipo_fir;			
		}
		if($sql_con_es[0]==$est_firma_contratista){
			
				$tipo_fir = "_contratista";												
			
			$esta = "firma".$tipo_fir;			
		}
		if($sql_con_es[0]==$est_poliza){
			$esta = "revision_poliza";			
		}
		if($sql_con_es[0]==$est_gerente_contrato){
			$esta = "legalizacion_final_par";			
		}
		if($sql_con_es[0]==$est_legalizacion){
			$esta = "legalizacion_final";			
		}
		if($sql_con_es[0]==$est_finalizado){
			$esta = "Legalizado";			
		}
		
		return $esta ;
	}
	
	function fecha_estado($tabla,$id_contrato){
		global $est_creacion,$est_abastecimiento,$est_sap,$est_revision,$est_firma_contratista,$est_firma_hocol,$est_poliza,$est_legalizacion,$est_gerente_contrato,$est_finalizado;
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		$busca_contrato_es = "select estado,sel_representante,creacion_sistema,recibido_abastecimiento_e,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_par_e,legalizacion_final_e from $tabla where id = $id_contrato_arr";
		$sql_con_es=traer_fila_row(query_db($busca_contrato_es));
		$esta = "";
		$fecha_imp = "";
		$estado_com = $sql_con_es[0];
		if($estado_com==$est_creacion){
			//$esta = "Elaboracion de contrato";			
			$fecha_imp = $sql_con_es[2];
		}
		
		if($estado_com==$est_abastecimiento){
			//$esta = "Recibido Abastecimiento";	
			$fecha_imp = $sql_con_es[3];		
		}
		if($estado_com==$est_sap){
			//$esta = "SAP";	
			$fecha_imp = $sql_con_es[4];		
		}
		if($estado_com==$est_revision){
			//$esta = "Revision Legal";	
			$fecha_imp = $sql_con_es[5];	
		}

		
			//echo $estado_com." ".$sql_con_es[1]."|";		
		if($estado_com==$est_firma_hocol){
			if($sql_con_es[1]==1){
				//$tipo_fir = "Contratista";		
				$fecha_imp = $sql_con_es[6];										
			}
			
			if($sql_con_es[1]==2){				
				//$tipo_fir = "Hocol";
				$fecha_imp = $sql_con_es[6];
			}
			//$esta = "Firma Representante ".$tipo_fir;			
		}
		if($estado_com==$est_firma_contratista){
			if($sql_con_es[1]==2){
				//$tipo_fir = "Contratista";	
				$fecha_imp = $sql_con_es[7];											
			}
			if($sql_con_es[1]==1){
				//$tipo_fir = "Hocol";
				$fecha_imp = $sql_con_es[7];
			}
			//$esta = "Firma Representante ".$tipo_fir;			
		}
		if($estado_com==$est_poliza){
			//$esta = "Revison Polizas";	
			$fecha_imp = $sql_con_es[8];		
		}
		
		if($estado_com==$est_gerente_contrato){
			//$esta = "Gerente Contrato";
			$fecha_imp = $sql_con_es[9];			
		}
		
		if($estado_com==$est_legalizacion){
			//$esta = "Legalizacion Final Contrato";			
			$fecha_imp = $sql_con_es[10];
		}
		
		
		return $fecha_imp ;
	}
	
	function fecha_estado_anterior($tabla,$id_contrato){
		global $est_creacion,$est_abastecimiento,$est_sap,$est_revision,$est_firma_hocol,$est_firma_contratista,$est_poliza,$est_legalizacion,$est_gerente_contrato,$est_finalizado;
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		$busca_contrato_es = "select estado,sel_representante,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final_par,legalizacion_final from $tabla where id = $id_contrato_arr";
		$sql_con_es=traer_fila_row(query_db($busca_contrato_es));
		$esta = "";
		$fecha_imp = "";
		$estado_com = $sql_con_es[0]-1;
		
		if($estado_com==$est_creacion){
			//$esta = "Elaboracion de contrato";			
			$fecha_imp = $sql_con_es[2];
		}
		
		if($estado_com==$est_abastecimiento){
			//$esta = "Recibido Abastecimiento";	
			$fecha_imp = $sql_con_es[3];		
		}
		if($estado_com==$est_sap){
			//$esta = "SAP";	
			$fecha_imp = $sql_con_es[4];		
		}
		if($estado_com==$est_revision){
			//$esta = "Revision Legal";	
			$fecha_imp = $sql_con_es[5];	
		}

		
		if($estado_com==$est_firma_hocol){
			if($sql_con_es[1]==1){
				//$tipo_fir = "Contratista";		
				$fecha_imp = $sql_con_es[6];										
			}
			
			if($sql_con_es[1]==2){
				//$tipo_fir = "Hocol";
				$fecha_imp = $sql_con_es[6];
			}
			//$esta = "Firma Representante ".$tipo_fir;			
		}
		if($estado_com==$est_firma_contratista){
			if($sql_con_es[1]==2){
				//$tipo_fir = "Contratista";	
				$fecha_imp = $sql_con_es[7];											
			}
			if($sql_con_es[1]==1){
				//$tipo_fir = "Hocol";
				$fecha_imp = $sql_con_es[7];
			}
			//$esta = "Firma Representante ".$tipo_fir;			
		}
		if($estado_com==$est_poliza){
			//$esta = "Revison Polizas";	
			$fecha_imp = $sql_con_es[8];		
		}
		
		if($estado_com==$est_gerente_contrato){
			//$esta = "Gerente Contrato";
			$fecha_imp = $sql_con_es[9];			
		}
		
		if($estado_com==$est_legalizacion){
			//$esta = "Legalizacion Final Contrato";			
			$fecha_imp = $sql_con_es[10];
		}
		
		
		return $fecha_imp ;
	}
	
	function estado_contrato_retu_campo_anterior($id_contrato,$tabla){
		global $est_creacion,$est_abastecimiento,$est_sap,$est_revision,$est_firma_hocol,$est_firma_contratista,$est_poliza,$est_legalizacion,$est_gerente_contrato,$est_finalizado;
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		$busca_contrato_es = "select estado,sel_representante from $tabla where id = $id_contrato_arr";
		$sql_con_es=traer_fila_row(query_db($busca_contrato_es));
		$esta = "";
		$estado_com = $sql_con_es[0]-1;
		
		if($estado_com ==$est_creacion){
			$esta = "Elaboracion de contrato";			
		}
		
		if($estado_com ==$est_abastecimiento){
			$esta = "recibido_abastecimiento";			
		}
		if($estado_com ==$est_sap){
			$esta = "sap";			
		}
		if($estado_com ==$est_revision){
			$esta = "revision_legal";			
		}

		
					
		if($estado_com ==$est_firma_hocol){
			
				$tipo_fir = "_Hocol";
			
			$esta = "firma".$tipo_fir;			
		}
		if($estado_com ==$est_firma_contratista){
			
				$tipo_fir = "_contratista";												
			
			$esta = "firma".$tipo_fir;			
		}
		if($estado_com ==$est_poliza){
			$esta = "revision_poliza";			
		}
		if($estado_com ==$est_gerente_contrato){
			$esta = "legalizacion_final_par";			
		}
		if($estado_com ==$est_legalizacion){
			$esta = "legalizacion_final";			
		}
		if($estado_com ==$est_finalizado){
			$esta = "Legalizado";			
		}
		
		return $esta ;
	}
	
	function estado_contrato_anterior($id_contrato,$tabla){
		global $est_creacion,$est_abastecimiento,$est_sap,$est_revision,$est_firma_hocol,$est_firma_contratista,$est_poliza,$est_legalizacion,$est_gerente_contrato,$est_finalizado;
		
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		$busca_contrato_es = "select estado,sel_representante from $tabla where id = $id_contrato_arr";
		$sql_con_es=traer_fila_row(query_db($busca_contrato_es));
		$estado_anterior = $sql_con_es[0]-1;
		$esta = "";
		
		if($estado_anterior==$est_creacion){
			$esta = "Elaboracion de contrato";			
		}
		
		if($estado_anterior==$est_abastecimiento){
			$esta = "Recibido Abastecimiento";			
		}
		if($estado_anterior==$est_sap){
			$esta = "SAP";			
		}
		if($estado_anterior==$est_revision){
			$esta = "Revision Legal";			
		}

		
	
		if($estado_anterior==$est_firma_hocol){
			if($sql_con_es[1]==1){
				$tipo_fir = "Contratista";												
			}
			
			if($sql_con_es[1]==2){
				$tipo_fir = "Hocol";
			}
			$esta = "Firma Representante ".$tipo_fir;			
		}
		if($estado_anterior==$est_firma_contratista){
			if($sql_con_es[1]==2){
				$tipo_fir = "Contratista";												
			}
			if($sql_con_es[1]==1){
				$tipo_fir = "Hocol";
			}
			$esta = "Firma Representante ".$tipo_fir;			
		}
		if($estado_anterior==$est_poliza){
			$esta = "Revison Polizas";			
		}
		
		if($estado_anterior==$est_gerente_contrato){
			$esta = "Gerente Contrato";			
		}
		
		if($estado_anterior==$est_legalizacion){
			$esta = "Legalizacion Final Contrato";			
		}
		
		if($estado_anterior==$est_finalizado){
			$esta = "Legalizado";			
		}
		
		return $esta ;
	}
	
	function calcula_valor_contrato_saldo($id_item_pecc, $id_contrato, $ano, $campo, $solicitud_aplica_ots, $valor_solicitado){
		$trm_ano = trm_presupuestal($ano);
/*DISPONIBLE POR SOLICITUD*/
	
if($solicitud_aplica_ots==0 or $solicitud_aplica_ots=="") $solicitud_aplica_ots = $id_item_pecc;
		$sel_valores_ampliaciones = query_db("select sum(usd), sum(cop) from t2_reporte_marco_temporal where id_us = ".$_SESSION["id_us_session"]." and id_campo='".$campo."' and ano = '".$ano."' and id_item = '".$solicitud_aplica_ots."'");
		$valor_aprobacion = 0;
		while($s_valor_aprob = traer_fila_db($sel_valores_ampliaciones)){
			$valor_aprobacion = $valor_aprobacion + ($s_valor_aprob[0] + ($s_valor_aprob[1]/$trm_ano));
			}
		$sel_valores_ots = query_db("select sum(usd), sum(cop) from t2_reporte_marco_temporal where id_us = ".$_SESSION["id_us_session"]." and id_campo='".$campo."' and ano = '".$ano."' and id_item_ots_aplica = '".$solicitud_aplica_ots."'");
		$valor_ots = 0;
		while($s_valor_ots = traer_fila_db($sel_valores_ots)){
			$valor_ots = $valor_ots + ($s_valor_ots[0] + ($s_valor_ots[1]/$trm_ano));
			}
		$valor_disponible = $valor_aprobacion-$valor_ots;
		if($valor_solicitado > $valor_disponible){
		$sel_numero_solicitud = traer_fila_row(query_db("select num1, num2, num3 from t2_item_pecc where id_item = ".$solicitud_aplica_ots));
		?><script>
		//alert("No se puede agregar este valor por que la solicitud <?=numero_item_pecc($sel_numero_solicitud[0], $sel_numero_solicitud[1], $sel_numero_solicitud[2])?> la cual esta relacionando no tiene todo el disponible solicitado \n\n Esta solicitando Equivalente USD$: <?=number_format($valor_solicitado, 0)?>, \n Valor disponible es Equivalente USD$: <?=number_format($valor_disponible,0)?>");
      //  window.parent.document.getElementById("cargando_pecc").style.display = "none";
        </script><?
		//exit;
		}
		
		
/*FIN -- DISPONIBLE POR SOLICITUD*/	
		
		$sel_valor_especifico = traer_fila_row(query_db("select sum(eq_usd) from t2_marco_temporal where  id_item =".$id_item_pecc." and id_contrato = ".$id_contrato." and   ano = ".$ano." and campo = ".$campo." and especifico = 'SI' and id_usuario = ".$_SESSION["id_us_session"].""));
		

		$sel_valor_compartido = traer_fila_row(query_db("select sum(eq_usd) from t2_marco_temporal where id_item =".$id_item_pecc." and  id_contrato = ".$id_contrato." and   ano = ".$ano." and campo = ".$campo." and especifico = 'NO' and id_usuario = ".$_SESSION["id_us_session"].""));
					
		  $eq_especifico = $sel_valor_especifico[0];
          $eq_compartido = $sel_valor_compartido[0];
		  
		  $valor_cont_total_eq_cop = $eq_compartido + $eq_especifico;

/*validacion de total de solicitud de aprobacion*/
$entra_validacion_extra = "SI";
if($id_item_pecc ==38){//38 contrato mision temporal
			$entra_validacion_extra = "NO";
			}
if($valor_cont_total_eq_cop > 0 and $entra_validacion_extra == "SI"){//si las anteriores validacion indican que el valor es mayor a 0
$valor_tt = 0;

		$sel_valor_sol_inicial = query_db("select sum(valor_usd), sum(valor_cop), sum(ano) from t2_presupuesto where  t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2");
		while($sel_v_inicial = traer_fila_db($sel_valor_sol_inicial)){
			$valor_tt = $valor_tt + $sel_v_inicial[0] + ($sel_v_inicial[1]/trm_presupuestal($sel_v_inicial[2]));
			}
		$sel_ampliaciones = query_db("select id_item from t2_item_pecc where id_item_peec_aplica = ".$id_item_pecc." and t1_tipo_proceso_id = 7 and estado > 20 and estado <= 32 and estado != 31");
		while($sel_ampl_tt = traer_fila_db($sel_ampliaciones)){
			$sel_valor_ampli = query_db("select sum(valor_usd), sum(valor_cop), sum(ano) from t2_presupuesto where  t2_item_pecc_id = ".$sel_ampl_tt[0]." and permiso_o_adjudica = 1");
			while($sel_v_ampli = traer_fila_db($sel_valor_ampli)){
			$valor_tt = $valor_tt + $sel_v_ampli[0] + ($sel_v_ampli[1]/trm_presupuestal($sel_v_ampli[2]));
			}
		}
		echo $valor_tt;
		if($valor_solicitado>$valor_tt){
			?><script>
		alert("ATENCION: No es posible agregar este valor a esta solicitud debido a que es superior al valor total de las aprobaciones 1");
		window.parent.document.getElementById("cargando_pecc").style.display = "none";
        </script><?
		exit;
		}else{
			
			$valor_tt_ot = 0;
			$sel_ordenes_trabajo = query_db("select id_item from t2_item_pecc where id_item_peec_aplica = ".$id_item_pecc." and t1_tipo_proceso_id = 8 and estado <> 33");
		while($sel_ampl_tt = traer_fila_db($sel_ordenes_trabajo)){
			$sel_valor_ot = query_db("select sum(valor_usd), sum(valor_cop), sum(ano) from t2_presupuesto where  t2_item_pecc_id = ".$sel_ampl_tt[0]." and permiso_o_adjudica = 1");
			while($sel_v_ot = traer_fila_db($sel_valor_ot)){
			$valor_tt_ot = $valor_tt_ot + $sel_valor_ot[0] + ($sel_valor_ot[1]/trm_presupuestal($sel_valor_ot[2]));
			}
		
		}
		
		if(($valor_solicitado+$valor_tt_ot)>$valor_tt){
			?><script>
		alert("ATENCION: No es posible agregar este valor a esta solicitud debido a que es superior al valor total de las aprobaciones 2");
		window.parent.document.getElementById("cargando_pecc").style.display = "none";
        </script><?
		exit;
		}
			
			}
			
			
}
/*FIN validacion de total de solicitud de aprobacion*/
		return $valor_cont_total_eq_cop;
		
		}
		
		function imprime_para_comparar(){
			global $vpeec12;
		global $vpeec6;
		global $vpeec9;
		global $vpeec11;
		global $vpeec10;
			$id_item_pecc = 1;
			$quere_comple = " and t7_contrato_id = 1 and ano = 2013";
			?>
			<table width="100%" border="0" class="tabla_lista_resultados">
  
  <tr >
    <td width="26%" align="center">&nbsp;</td>
    <td width="27%" align="center" class="fondo_3">Numero del Contrato Marco</td>
    <td width="16%" align="center" class="fondo_3">Valor USD$</td>
    <td width="14%" align="center" class="fondo_3">Valor COP$</td>
    <td width="17%" align="center" class="fondo_3">Equivalente USD$</td>
  </tr>
  <tr>
    <td width="26%" rowspan="0" align="center" class="fondo_3">Valor Inicial de los Contratos Marco</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <?
	
	
	
	$valor_inicial_total_usd = 0;
		$valor_inicial_total_cop = 0;
		$valor_inicial_total_eq_cop = 0;
		
		
  	$selec_inicio = query_db("select * from $vpeec6 where id_item = $id_item_pecc $quere_comple order by t7_contrato_id, ano");
	while($se_ini = traer_fila_db($selec_inicio)){
		
		$valor_inicial_total_usd = $valor_inicial_total_usd+$se_ini[3];
		$valor_inicial_total_cop = $valor_inicial_total_cop+$se_ini[4];
		$valor_inicial_total_eq_cop = $valor_inicial_total_eq_cop+$se_ini[5];
		
		$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$se_ini[8]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $se_ini[7];
					
  ?>
  <tr>
   <td>&nbsp;</td>
    <td align="center"><? echo "* ".numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)." - <strong>A&ntilde;o: ".$se_ini[2]."</strong>";?></td>
    <td align="center"><?=number_format($se_ini[3],0)?></td>
    <td align="center"><?=number_format($se_ini[4],0)?></td>
    <td align="center"><?=number_format($se_ini[3]+$se_ini[5],0)?></td>
  </tr>
  
  <?
  }
  ?>
  <tr >
 <td>&nbsp;</td>
    <td align="right"  class="filas_resultados"><strong>Sub Totales:</strong></td>
    <td align="center"  class="filas_resultados"><?=number_format($valor_inicial_total_usd,0)?></td>
    <td align="center"  class="filas_resultados"><strong><?=number_format($valor_inicial_total_cop,0)?></strong></td>
    <td align="center" class="filas_resultados"><strong><?=number_format($valor_inicial_total_usd+$valor_inicial_total_eq_cop,0)?></strong></td>
  </tr>
  
    <tr>
    <td width="26%" rowspan="0" align="center" class="fondo_3">Ampliaci&oacute;n Normales a Contratos Marco</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <?
		$valor_amplia_1_total_usd = 0;
		$valor_amplia_1_total_cop = 0;
		$valor_amplia_1_total_eq_cop = 0;
		
		
  	$selec_inicio = query_db("select * from $vpeec9 where id_item = $id_item_pecc $quere_comple and (equivalente_cop_amplia is not null or amplia_usd is not null or amplia_cop is not null)  order by consecutivo_contrato");
	while($se_ini = traer_fila_db($selec_inicio)){
		
		$valor_amplia_1_total_usd = $valor_amplia_1_total_usd+$se_ini[5];
		$valor_amplia_1_total_cop = $valor_amplia_1_total_cop+$se_ini[6];
		$valor_amplia_1_total_eq_cop = $valor_amplia_1_total_eq_cop+$se_ini[7];
		
		$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$se_ini[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $se_ini[3];
					
  ?>
  <tr>
   <td>&nbsp;</td>
    <td align="center"><? echo "* ".numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)." - <strong>A&ntilde;o: ".$se_ini[4]."</strong>";?></td>
    <td align="center"><?=number_format($se_ini[5],0)?></td>
    <td align="center"><?=number_format($se_ini[6],0)?></td>
    <td align="center"><?=number_format($se_ini[5]+$se_ini[7],0)?></td>
  </tr>
  
  <?
  }
  ?>
  <tr >
 <td>&nbsp;</td>
    <td align="right"  class="filas_resultados"><strong>Sub Totales:</strong></td>
    <td align="center"  class="filas_resultados"><?=number_format($valor_amplia_1_total_usd,0)?></td>
    <td align="center"  class="filas_resultados"><strong><?=number_format($valor_amplia_1_total_cop,0)?></strong></td>
    <td align="center" class="filas_resultados"><strong><?=number_format($valor_amplia_1_total_usd+$valor_amplia_1_total_eq_cop,0)?></strong></td>
  </tr>
  <tr>
    <td rowspan="0" align="center" class="fondo_3">Ampliaciones Compartidas con otros Contratos Marco</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <?
  		$valor_amplia_2_total_usd = 0;
		$valor_amplia_2_total_cop = 0;
		$valor_amplia_2_total_eq_cop = 0;
		
		$selec_los_contratos = query_db("select t2_presupuesto_id, valor_usd, valor_cop, equivalente_cop from $vpeec10 where id_item_peec_aplica = $id_item_pecc $quere_comple group by t2_presupuesto_id, valor_usd, valor_cop, equivalente_cop ");
		
		while ($sele_cont = traer_fila_db($selec_los_contratos)){
		
  	
		
		$valor_amplia_2_total_usd = $valor_amplia_2_total_usd+$sele_cont[1];
		$valor_amplia_2_total_cop = $valor_amplia_2_total_cop+$sele_cont[2];
		$valor_amplia_2_total_eq_cop = $valor_amplia_2_total_eq_cop+$sele_cont[3];
		
		
  ?>
  <tr>
    <td>&nbsp;</td>
    <td align="center">
	<?
    $selec_inicio = query_db("select * from $vpeec10 where t2_presupuesto_id = ".$sele_cont[0].$quere_comple);
	while($se_ini = traer_fila_db($selec_inicio)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$se_ini[8]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $se_ini[7];
	
	 echo "* ".numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)." - <strong>A&ntilde;o: ".$se_ini[2]."</strong><br />";
	}
	?>
    </td>
    <td align="center"><?=number_format($sele_cont[1],0)?></td>
    <td align="center"><?=number_format($sele_cont[2],0)?></td>
    <td align="center"><?=number_format($sele_cont[1]+$sele_cont[3],0)?></td>
  </tr>
  <?
			}
  ?>
  <tr >
    <td>&nbsp;</td>
    <td align="right"  class="filas_resultados"><strong>Sub Totales:</strong></td>
    <td align="center"  class="filas_resultados"><?=number_format($valor_amplia_2_total_usd,0)?></td>
    <td align="center"  class="filas_resultados"><strong>
      <?=number_format($valor_amplia_2_total_cop,0)?>
    </strong></td>
    <td align="center" class="filas_resultados"><strong>
      <?=number_format($valor_amplia_2_total_usd+$valor_amplia_2_total_eq_cop,0)?>
    </strong></td>
  </tr>
  <tr>
    <td align="center"></td>
    <td align="right" class="fondo_3">Valor General Total: </td>
    <td align="center"  class="fondo_3"><?=number_format($valor_inicial_total_usd+$valor_amplia_1_total_usd+$valor_amplia_2_total_usd,0)?></td>
    <td align="center"  class="fondo_3"><?=number_format($valor_inicial_total_cop+$valor_amplia_1_total_cop+$valor_amplia_2_total_cop,0)?></td>
    <td align="center"  class="fondo_3"><?=number_format($valor_inicial_total_usd+$valor_amplia_1_total_usd+$valor_amplia_2_total_usd+$valor_inicial_total_eq_cop+$valor_amplia_1_total_eq_cop+$valor_amplia_2_total_eq_cop,0)?></td>
  </tr>
  <tr>
    <td width="26%" rowspan="0" align="center" class="fondo_3">Ordenes de Trabajo</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <?
		$valor_ot_total_usd = 0;
		$valor_ot_total_cop = 0;
		$valor_ot_total_eq_cop = 0;
  	$selec_inicio = query_db("select t7_contrato_id,ano,consecutivo, creacion_sistema, sum(ot_usd),sum(ot_cop),sum(equivalente_cop) from $vpeec11 where id_item = $id_item_pecc $quere_comple group by t7_contrato_id,ano,consecutivo, creacion_sistema order by t7_contrato_id");
	while($se_ini = traer_fila_db($selec_inicio)){
		
		$valor_ot_total_usd = $valor_ot_total_usd+$se_ini[4];
		$valor_ot_total_cop = $valor_ot_total_cop+$se_ini[5];
		$valor_ot_total_eq_cop = $valor_ot_total_eq_cop+$se_ini[6];
		
		$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$se_ini[3]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $se_ini[2];
					
  ?>
  <tr>
   <td>&nbsp;</td>
    <td align="center"><? echo "* ".numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)." - <strong>A&ntilde;o: ".$se_ini[1]."</strong>";?></td>
    <td align="center"><?=number_format($se_ini[4],0)?></td>
    <td align="center"><?=number_format($se_ini[5],0)?></td>
    <td align="center"><?=number_format($se_ini[4]+$se_ini[6],0)?></td>
  </tr>
  
  <?
  }
  ?>
  <tr >
 <td>&nbsp;</td>
    <td align="right"  class="filas_resultados"><strong>Sub Totales:</strong></td>
    <td align="center"  class="filas_resultados"><?=number_format($valor_ot_total_usd,0)?></td>
    <td align="center"  class="filas_resultados"><strong><?=number_format($valor_ot_total_cop,0)?></strong></td>
    <td align="center" class="filas_resultados"><strong><?=number_format($valor_ot_total_usd+$valor_ot_total_eq_cop,0)?></strong></td>
  </tr>
   
</table>
<table width="100%" border="0" class="tabla_lista_resultados">
  
  <tr>
    <td colspan="5" rowspan="0" align="center" class="fondo_3">Saldo Total Disponible</td>
  </tr>
  <?
	
	
	
				
	
	$selec_contratos_sql = query_db("select * from $vpeec12 where id_item = $id_item_pecc $quere_comple order by t7_contrato_id, ano");
	while($se_contratos = traer_fila_db($selec_contratos_sql)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$se_contratos[4]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $se_contratos[3];
					
							
  ?>

  <tr>
    <td>&nbsp;</td>
    <td align="center"><? echo "* ".numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)." - <strong>A&ntilde;o: ".$se_contratos[2]."</strong>";?></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><? echo number_format(calcula_valor_contrato_saldo($se_contratos[0], $se_contratos[1], $se_contratos[2]),0)?></td>
  </tr>
  <?
  
	}
  ?>
  <tr >
    <td>&nbsp;</td>
    <td align="right"  class="filas_resultados"><strong>Sub Totales:</strong></td>
    <td align="center"  class="filas_resultados"><?=number_format($total_usd,0)?></td>
    <td align="center"  class="filas_resultados"><strong>
      <?=number_format($total_cop,0)?>
    </strong></td>
    <td align="center" class="filas_resultados"><strong>
      <?=number_format($total_equi,0)?>
    </strong></td>
  </tr>
</table>

<?
			}
			
function consecutivo_bl($id_bl){
	$lista_contrato = "select consecutivo,YEAR(creacion_sistema),apellido from t7_contratos_contrato where id = $id_bl";
	$sql_con=traer_fila_row(query_db($lista_contrato));
	
	$cant_cero = 4-strlen($sql_con[0]);
	$cadena_cers = "";
	$tr = 0;
	while($tr<$cant_cero){
		$cadena_cers = $cadena_cers."0";
		$tr=$tr+1;
	}
	return "C".substr($sql_con[1],2,4)."-".$cadena_cers.$sql_con[0]." ".$sql_con[2];
}

function imprime_cabeza_contrato($id_contrato){
	global $co1,$g6;	
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$busca_contrato = "select contratista from $co1 where id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	
	$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$sql_con[0];
	$sel_pro_q=traer_fila_row(query_db($sel_pro));
	
	$busca_contrato_completo = "select * from $co1 where id = $id_contrato_arr";
	$sql_con_com=traer_fila_row(query_db($busca_contrato_completo));
	
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" >
	<tr style="display:none" >
    	<td valign="top" ><img src="../imagenes/botones/aviso_observaciones.png" width="16" height="16" /><strong>&nbsp;&nbsp;ATENCION:&nbsp;&nbsp;</strong><span class="titulos_resumen_alertas">
		
 </span></td>
 	</tr>
    <tr >
    	<td valign="top" class="titulos_secciones" >CONTRATO: 
         <?
    	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sql_con_com[19]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_con_com[2];//consecutivo
		$numero_contrato4 = $sql_con_com[43];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_con_com[0])." - ".$sel_pro_q[3];
		
	?>
		</td>	
	</tr>	
    
</table>
    <?
}

function imprime_cabeza_proveedor($id_proveedor){
	global $co1,$g6;	
	$id_proveedor_arr = elimina_comillas(arreglo_recibe_variables($id_proveedor));
	$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$id_proveedor_arr;
	$sel_pro_q=traer_fila_row(query_db($sel_pro));
	
	$digito = "";
    if(trim($sel_pro_q[2])!=""){
		$digito = "-".$sel_pro_q[2];
	}
	
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" >
	    <tr >
    	<td valign="top" class="titulos_secciones" >PROVEEDOR: <?=$sel_pro_q[1].$digito;?> / <?=$sel_pro_q[3];?></td>	
	</tr>	
    
</table>
    <?
}


function valida_visualiza_contrato($id_usuario){
	global $ts3,$ts5;
	$usuario_jefe = "select distinct(id_usuario) from $ts3 where id_area in (select id_area from v_seg1 where us_id=".$id_usuario. " and id_premiso=9)";
	$sql_usuario_jefe=query_db($usuario_jefe);
	$array_usuario = "";
	$coma = ",";
	while($sql_array_usuarios=traer_fila_row($sql_usuario_jefe)){
		if($array_usuario!=""){
			$coma = ",";
		}
		$array_usuario = $array_usuario.$coma.$sql_array_usuarios[0];		
	}
	
	
	$permisos = " and (gerente in (".$id_usuario. "$array_usuario) or especialista in (".$id_usuario."$array_usuario)) ";
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$id_usuario." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$permisos = "";
	}
	
	$sel_permisos = "select id_area from v_seg1 where us_id=".$id_usuario. " and id_area=1";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$sel_permisos;
		$permisos = "";
	}
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$id_usuario." and id_permiso=12";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$permisos = "";
	}
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$id_usuario." and id_permiso=4";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$permisos = "";
	}
	
	return $permisos;
}


	
	
	
		
	

		
		
		
	
	
function crea_contratos_si_no_funciona($id_item_pecc){
	global $pi2;
	global $v_contra1;	
	global $fecha;
	global $vpeec18;
	global $co1;
	global $pi8;
	global $pi18;
	global $pi12;
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	$saca_ano = explode("-",$fecha);
	$saca_ano_tarifas = $saca_ano[0];
	$saca_ano = $saca_ano[0];
	$saca_ano = $saca_ano[2].$saca_ano[3];
	
	$sele_max_contrato = traer_fila_row(query_db("select max(consecutivo) from $v_contra1 where ano = ".$saca_ano));
	$consecutivo = $sele_max_contrato[0];
		
	
	$sel_contratos = query_db("select t1_proveedor_id,t1_tipo_documento_id, sum(valor_usd), sum(valor_cop), Expr1 from $vpeec18 where t2_item_pecc_id = ".$id_item_pecc." group by t1_proveedor_id,t1_tipo_documento_id, Expr1 order by t1_proveedor_id");
$proveedor=0;
	while ($sel_contras = traer_fila_db($sel_contratos)){
		
		if($sel_contras[1] == 1 or $sel_contras[1] == 6){
			
		if($proveedor != $sel_contras[0]){
		$proveedor = $sel_contras[0];
		$consecutivo = $consecutivo+1;
		}
		
		if($sel_contras[1] == 6){
			$oferta_mercantil=1;
			}else{		
				$oferta_mercantil=0;
			}
			
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$insert_contrato = "insert into $co1 (id_item, consecutivo, objeto, contratista, gerente, monto_usd, monto_cop, creacion_sistema, estado,t1_tipo_documento_id,vigencia_mes, apellido,tipo_bien_servicio, oferta_mercantil) values ($id_item_pecc,$consecutivo, '".$sel_item[9]."',".$sel_contras[0].",".$sel_item[3].",".$sel_contras[2].",".$sel_contras[3].", '$fecha', 1,1,'','".$sel_contras[4]."', '".tipo_bien_servicio_sin_contrato($sel_contras[4])."', '".$oferta_mercantil."')";
	echo $insert_contrato;
	
	$sql_ex=query_db($insert_contrato.$trae_id_insrte);
	$id_ingreso = id_insert($sql_ex);//id del contrato
	
	$consecutivo_con_apellido = $consecutivo.$sel_contras[4];
 crea_antecedente_auto($id_item_pecc, "crea_contrato",$consecutivo_con_apellido);
 
    	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$fecha);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $consecutivo;//consecutivo
		$numero_contrato4 = $sel_contras[4];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$id_contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $id_ingreso);

 
	//CREACION DE TARIFAS
	//$t1,$t4
	$insert_tarifa_contrato = "insert t6_tarifas_contratos (t1_moneda_id, t1_proveedor_id,consecutivo,valor, objeto_contarto,id_contrato) values (1,".$sel_contras[0].",'".$id_contrato_ajus."',0,'".$sel_item[9]."',".$id_ingreso." )";
	$sql_ex=query_db($insert_tarifa_contrato.$trae_id_insrte);
	$id_trifas = id_insert($sql_ex);//id del tarifas
	
	$insert_caomplemento_tarifas = query_db("insert into t6_tarifas_complemento_contrato (tarifas_contrato_id, t6_tarifas_estados_contratos_id) values ($id_trifas,1)");

	
	//FIN CREACION DE TARIFAS
	
	$sele_presu = query_db("select * from $pi8 as t1, $pi18 as t2 where t1.t2_item_pecc_id = $id_item_pecc and t1.permiso_o_adjudica = 2 and t1.t2_presupuesto_id = t2.t2_presupuesto_id and t1_proveedor_id=".$sel_contras[0]." and t2.apellido = '".$sel_contras[4]."'");
	while($s_pres = traer_fila_db($sele_presu)){
			$insert_contra = query_db("insert into $pi12 (t2_presupuesto_id, t7_contrato_id) values (".$s_pres[0].",$id_ingreso)");
		}
	
	}
	}
	$upda = query_db("update $pi2 set aprobado = 1 where id_item=".$id_item_pecc);
	
	
	
	}
function dameFecha($fecha,$dia){   
	list($year,$mon,$day) = explode('-',$fecha);    
	$fecha_otro_formato = date('d/m/Y',mktime(0,0,0,$mon,$day+$dia,$year));   
	list($day1,$mon1,$year1) = explode('/',$fecha_otro_formato);
	     
	return $year1."-".$mon1."-".$day1;
}



/*asignacion de permisos*/
/*----------------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------------*/
$sel_roles_usuaio = query_db("select * from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]);

$creacionsolicitud=0;
$crearsolicitudcomoemulador=0;
$emulaprofesionaldecompras=0;
$creacionordenestrabajo=0;
$agregargerenteordentrabajo=0;
$incluirsolpeddesap=0;
$visualizacionhistoricodesolicitudesporarea=0;
$visualizacionhistoricodesolicitudesglobal=0;
$firmaenelsistemagerentedeitem=0;
$firmaenelsistemacomprador=0;
$firmaenelsistemaprofesional=0;
$gestionaprobaciondesocios=0;
$ingresarfechaderecibidoabastecimiento=0;
$creacionyaperturadecomites=0;
$agregarsolicitudespendientesdecomite=0;
$agregarasistentesalcomite=0;
$agregaranexosenelcomite=0;
$finalizaciondecomite=0;
$ratificaciondecomite=0;
$visualizacionhistoricodecomites=0;
$administraciondefechasdeloscontratos=0;
$congelarydescongelarcontratos=0;
$consultadecontratosporareas=0;
$consultadecontratosporareasemulador=0;
$consultahistoricodecontratosglobal=0;
$revisionycreaciondepolizas=0;
$visualizacionreportesdecontratos=0;
$cargueinicialdetarifas=0;
$ponerenfirmeelcontrato=0;
$ponerenestadoparcialelcontrato=0;
$buscadorporcontratosglobal=0;
$buscadorporcontratosporarea=0;
$reportestiquetesdeserviciogoblal=0;
$reportesreembolsablesglobal=0;
$reportestiquetesporarea=0;
$reportesreembolsablesporarea=0;
$administraciondemunicipios=0;
$consultadetarifasporcontratoglobal=0;
$consultadetarifasporcontratoporarea=0;
$aprobacionesdetarifasporcontrato=0;
$consultadeaprobacionesporcontratoglobal=0;
$consultadeaprobacionesporcontratoporarea=0;
$admindescuentospactadosporcontrato=0;
$admindereembolsablesporcontrato=0;
$adminipcporcontrato=0;
$visualizacionycreaciondereemplazos=0;
$historicodeloscontratosdelproveedor=0;
$creatiquetedeservicio=0;
$historicodetiquete=0;
$inclusiondenuevastarifas=0;
$aprobacionespendientes=0;
$historicodesusaprobaciones=0;
$creardescuentos=0;
$tarifasmaestras=0;
$creaciondeprocesourna=0;
$visualizacionhistoricosdeprocesosurna=0;
$aperturadeurna=0;
$descargadedocumentosurna=0;
$adjudicacionurna=0;
$administraciondeproveedoresurna=0;
$alertasbitacora=0;
$invitacionesencurso=0;
$historicodeinvitacionesurna=0;
$administracionusuariourna=0;
$solicitudsoportetecnicourna=0;
$visualizacionindicadordetiempos=0;
$visualizacionreportesnivelesdeaprobacion=0;
$visualizacionreportedecomite=0;
$visualizacionreportedeauditor=0;
$visualizacionreportedeusuarios=0;
$visualizaciondetalledecontratosmarco=0;
$visualizacionreportedecontratos=0;
$visualizacionreportedecontratosglobal=0;
$visualizacionreportedemodificaciones=0;
$visualizacionreportedecongelados=0;
$visualizacionreportedeconflictointereces=0;
$creaciondeusuario=0;
$modificargerentedecontrato=0;
$modificarprofecionalcyc=0;
$modificarfechaderequerimiento=0;
$modificartiemposespeciales=0;
$cambiarestadodeproceso=0;
$congelarproceso=0;
$eliminaciondesolicitudes=0;
$cambiargestordesocios=0;
$agregarfirmadores=0;
$cambiarfirmadores=0;
$quitarfirmadores=0;
$devolversolicitudalprofesionaldecompras=0;




while($sel_rol_us = traer_fila_db($sel_roles_usuaio)){
	
	if($sel_rol_us[1]==1){
		$consultahistoricodecontratosglobal=1;
		$cargueinicialdetarifas=1;
		$ponerenfirmeelcontrato=1;
		$ponerenestadoparcialelcontrato=1;
		$buscadorporcontratosglobal=1;
		$reportestiquetesdeserviciogoblal=1;
		$reportesreembolsablesglobal=1;
		$administraciondemunicipios=1;
		$consultadetarifasporcontratoglobal=1;
		$consultadeaprobacionesporcontratoglobal=1;
		$admindereembolsablesporcontrato=1;
		$adminipcporcontrato=1;
		$visualizacionycreaciondereemplazos=1;
		$tarifasmaestras=1;
		$visualizacionreportedeusuarios=1;
		}
	if($sel_rol_us[1]==2){
		$visualizacionhistoricodesolicitudesglobal=1;
		$visualizacionhistoricodecomites=1;
		$consultahistoricodecontratosglobal=1;
		$visualizacionreportesdecontratos=1;
		$cargueinicialdetarifas=1;
		$buscadorporcontratosglobal=1;
		$reportestiquetesdeserviciogoblal=1;
		$reportesreembolsablesglobal=1;
		$administraciondemunicipios=1;
		$consultadetarifasporcontratoglobal=1;
		$visualizacionhistoricosdeprocesosurna=1;
		$administraciondeproveedoresurna=1;
		$alertasbitacora=1;
		$visualizacionindicadordetiempos=1;
		$visualizacionreportesnivelesdeaprobacion=1;
		$visualizacionreportedecomite=1;
		$visualizacionreportedeauditor=1;
		$visualizacionreportedeusuarios=1;
		$visualizaciondetalledecontratosmarco=1;
		$visualizacionreportedecontratosglobal=1;
		$creaciondeusuario=1;
		$modificargerentedecontrato=1;
		$modificarprofecionalcyc=1;
		$modificarfechaderequerimiento=1;
		$modificartiemposespeciales=1;
		$cambiarestadodeproceso=1;
		$congelarproceso=1;
		$eliminaciondesolicitudes=1;
		$cambiargestordesocios=1;
		$agregarfirmadores=1;
		$cambiarfirmadores=1;
		$quitarfirmadores=1;
		$devolversolicitudalprofesionaldecompras=1;	
		
		}
		if($sel_rol_us[1]==3){
			$visualizacionhistoricodesolicitudesglobal=1;
			$consultahistoricodecontratosglobal=1;
			$reportestiquetesdeserviciogoblal=1;
			$reportesreembolsablesglobal=1;
			$consultadetarifasporcontratoglobal=1;
			$visualizacionhistoricosdeprocesosurna=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizacionreportedeusuarios=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratosglobal=1;
			}
		if($sel_rol_us[1]==4){
			$descargadedocumentosurna=1;
			$visualizacionindicadordetiempos=1;
		}
		if($sel_rol_us[1]==5){
			$creacionsolicitud=1;
			$creacionordenestrabajo=1;
			$visualizacionhistoricodesolicitudesporarea=1;
			$firmaenelsistemagerentedeitem=1;
			$consultadecontratosporareas=1;
			$buscadorporcontratosporarea=1;
			$reportestiquetesporarea=1;
			$reportesreembolsablesporarea=1;
			$consultadetarifasporcontratoporarea=1;
			$aprobacionesdetarifasporcontrato=1;
			$consultadeaprobacionesporcontratoporarea=1;
			$visualizacionhistoricosdeprocesosurna=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			}
		if($sel_rol_us[1]==6){
			$creacionyaperturadecomites=1;
			$agregarsolicitudespendientesdecomite=1;
			$agregarasistentesalcomite=1;
			$agregaranexosenelcomite=1;
			$finalizaciondecomite=1;
			$visualizacionhistoricodecomites=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizacionreportedeusuarios=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionreportedecontratosglobal=1;
			$visualizacionreportedemodificaciones=1;
			$visualizacionreportedecongelados=1;
			$visualizacionreportedeconflictointereces=1;
		}
		if($sel_rol_us[1]==7){
			$consultahistoricodecontratosglobal=1;
			$revisionycreaciondepolizas=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionreportedecontratosglobal=1;
			}
		if($sel_rol_us[1]==8){
			$visualizacionhistoricodesolicitudesglobal=1;
			$visualizacionhistoricodecomites=1;
			$administraciondefechasdeloscontratos=1;
			$congelarydescongelarcontratos=1;
			$consultahistoricodecontratosglobal=1;
			$visualizacionreportesdecontratos=1;
			$buscadorporcontratosporarea=1;
			$reportestiquetesporarea=1;
			$reportesreembolsablesporarea=1;
			$consultadetarifasporcontratoporarea=1;
			$aprobacionesdetarifasporcontrato=1;
			$consultadeaprobacionesporcontratoporarea=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionreportedecontratosglobal=1;
			
			
				}
		if($sel_rol_us[1]==9){
			$creacionordenestrabajo=1;
			$agregargerenteordentrabajo=1;
			$visualizacionhistoricodesolicitudesglobal=1;
			$ingresarfechaderecibidoabastecimiento=1;
			$consultahistoricodecontratosglobal=1;
		}
		if($sel_rol_us[1]==10){
			$visualizacionhistoricodesolicitudesporarea=1;
			$consultadecontratosporareas=1;
			$buscadorporcontratosporarea=1;
			$reportestiquetesporarea=1;
			$reportesreembolsablesporarea=1;
			$consultadetarifasporcontratoporarea=1;
			$aprobacionesdetarifasporcontrato=1;
			$consultadeaprobacionesporcontratoglobal=1;
			$consultadeaprobacionesporcontratoporarea=1;
			$visualizacionhistoricosdeprocesosurna=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
		}
		if($sel_rol_us[1]==11){
			$creacionordenestrabajo=1;
			$agregargerenteordentrabajo=1;
			$visualizacionhistoricodesolicitudesglobal=1;
			$ingresarfechaderecibidoabastecimiento=1;
			$visualizacionhistoricodecomites=1;
			$consultahistoricodecontratosglobal=1;
			$visualizacionreportesdecontratos=1;
			$visualizacionhistoricosdeprocesosurna=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionreportedecontratosglobal=1;
			}
		if($sel_rol_us[1]==12){
			$visualizacionhistoricodesolicitudesporarea=1;
			$ratificaciondecomite=1;
			$visualizacionhistoricodecomites=1;
			$consultahistoricodecontratosglobal=1;
			$visualizacionhistoricosdeprocesosurna=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
		}
		if($sel_rol_us[1]==13 or $sel_rol_us[1]==2 ){
			$creacionsolicitud=1;
			$creacionordenestrabajo=1;
			$agregargerenteordentrabajo=1;
			$visualizacionhistoricodesolicitudesporarea=1;
			$firmaenelsistemaprofesional=1;
			$gestionaprobaciondesocios=1;
			$visualizacionhistoricodecomites=1;
			$consultahistoricodecontratosglobal=1;
			$visualizacionreportesdecontratos=1;
			$cargueinicialdetarifas=1;
			$ponerenfirmeelcontrato=1;
			$ponerenestadoparcialelcontrato=1;
			$buscadorporcontratosglobal=1;
			$reportestiquetesdeserviciogoblal=1;
			$reportesreembolsablesglobal=1;
			$administraciondemunicipios=1;
			$consultadetarifasporcontratoglobal=1;
			$aprobacionesdetarifasporcontrato=1;
			$consultadeaprobacionesporcontratoglobal=1;
			$admindereembolsablesporcontrato=1;
			$adminipcporcontrato=1;
			$visualizacionycreaciondereemplazos=1;
			$tarifasmaestras=1;
			$creaciondeprocesourna=1;
			$visualizacionhistoricosdeprocesosurna=1;
			$aperturadeurna=1;
			$descargadedocumentosurna=1;
			$adjudicacionurna=1;
			$administraciondeproveedoresurna=1;
			$alertasbitacora=1;
			
			$visualizacionhistoricodecomites=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizacionreportedeusuarios=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionreportedecontratosglobal=1;
			$visualizacionreportedemodificaciones=1;
			$visualizacionreportedecongelados=1;
			$visualizacionreportedeconflictointereces=1;
			}
			if($sel_rol_us[1]==14){
				
				}
			if($sel_rol_us[1]==15){
				$crearsolicitudcomoemulador=1;
				$visualizacionhistoricodesolicitudesporarea=1;
				$consultadecontratosporareasemulador=1;
				}
			if($sel_rol_us[1]==16){
				$creacionsolicitud=1;
				$incluirsolpeddesap=1;
				$visualizacionhistoricodesolicitudesporarea=1;
				}
			if($sel_rol_us[1]==17){
				$emulaprofesionaldecompras=1;
				$creacionordenestrabajo=1;
				$visualizacionhistoricodesolicitudesporarea=1;
				$firmaenelsistemacomprador=1;
				$consultadecontratosporareas=1;
				$consultahistoricodecontratosglobal=1;
				$creaciondeprocesourna=1;
				$visualizacionhistoricosdeprocesosurna=1;
				$aperturadeurna=1;
				$descargadedocumentosurna=1;
				$adjudicacionurna=1;
				$administraciondeproveedoresurna=1;
				$alertasbitacora=1;
				$visualizacionhistoricodecomites=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionindicadordetiempos=1;
			$visualizacionreportesnivelesdeaprobacion=1;
			$visualizacionreportedecomite=1;
			$visualizacionreportedeauditor=1;
			$visualizacionreportedeusuarios=1;
			$visualizaciondetalledecontratosmarco=1;
			$visualizacionreportedecontratos=1;
			$visualizacionreportedecontratosglobal=1;
			$visualizacionreportedemodificaciones=1;
			$visualizacionreportedecongelados=1;
			$visualizacionreportedeconflictointereces=1;
				}
			if($sel_rol_us[1]==18 or $_SESSION["id_us_session"] == 32){
				$creacionsolicitud=1;
				$visualizacionhistoricodesolicitudesporarea=1;
				$firmaenelsistemaprofesional=1;
				$visualizacionhistoricodecomites=1;
				$consultahistoricodecontratosglobal=1;
				$visualizacionreportesdecontratos=1;
				$cargueinicialdetarifas=1;
				$ponerenfirmeelcontrato=1;
				$ponerenestadoparcialelcontrato=1;
				$buscadorporcontratosglobal=1;
				$reportestiquetesdeserviciogoblal=1;
				$reportesreembolsablesglobal=1;
				$administraciondemunicipios=1;
				$consultadetarifasporcontratoglobal=1;
				$aprobacionesdetarifasporcontrato=1;
				$consultadeaprobacionesporcontratoglobal=1;
				$admindereembolsablesporcontrato=1;
				$adminipcporcontrato=1;
				$visualizacionycreaciondereemplazos=1;
				$tarifasmaestras=1;
				$visualizacionhistoricosdeprocesosurna=1;
				$visualizacionindicadordetiempos=1;
				$visualizacionreportesnivelesdeaprobacion=1;
				$visualizacionreportedecomite=1;
				$visualizacionreportedeauditor=1;
				$visualizacionreportedeusuarios=1;
				$visualizaciondetalledecontratosmarco=1;
				$visualizacionreportedecontratosglobal=1;
				$visualizacionindicadordetiempos=1;
				}
				
				if($sel_rol_us[1]==19){
				$visualizacionhistoricodesolicitudesporarea=1;
				$adjudicacionurna=1;
				}
				
				if($sel_rol_us[1]==20){
				$historicodeloscontratosdelproveedor=1;
				$creatiquetedeservicio=1;
				$historicodetiquete=1;
				$inclusiondenuevastarifas=1;
				$aprobacionespendientes=1;
				$historicodesusaprobaciones=1;
				$creardescuentos=1;
				$invitacionesencurso=1;
				$historicodeinvitacionesurna=1;
				$administracionusuariourna=1;
				$solicitudsoportetecnicourna=1;
				}
				
				if($sel_rol_us[1]==21){
					$visualizacionreportedemodificaciones=1;
					$visualizacionreportedecongelados=1;
					$visualizacionreportedecontratosglobal=1;
					$visualizacionreportedecomite=1;
					$visualizacionreportedeauditor=1;
					$visualizaciondetalledecontratosmarco=1;
					$visualizacionreportedecontratos=1;
					$visualizacionreportedeusuarios=1;
					
			}
			if($sel_rol_us[1]==27 or $sel_rol_us[1]==2){
					$visualizacionindicadordetiempos=1;
					$visualizacionreportesnivelesdeaprobacion=1;
					$visualizacionreportedecomite=1;
					$visualizacionreportedeauditor=1;
					$visualizacionreportedeusuarios=1;
					$visualizaciondetalledecontratosmarco=1;
					$visualizacionreportedecontratos=1;
					$visualizacionreportedecontratosglobal=1;
					$visualizacionreportedemodificaciones=1;
					$visualizacionreportedecongelados=1;
					$visualizacionreportedeconflictointereces=1;
			}
	
	
	}




/*----------------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------------*/
/*fin asignacion de permisos*/
?>