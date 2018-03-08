<?
include('../../librerias/PHPMailer_v2.0.0/class.phpmailer.php'); 
//error_reporting(E_ALL);  // Líneas para mostart errores
	//ini_set('display_errors', '1');  // Líneas para mostart errores
function envia_email_polizas_completas($id_contrato_llega){
	global $co1,$ts5,$g1,$correo_autentica_phpmailer,$contrasena_autentica_phpmailer,$servidor_phpmailer,$correo_from_phpmiler,$nombre_from_phpmiler;
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato_llega));//recibe id
	
	$busca_contrato_completo = "select * from $co1 where id = $id_contrato_arr";
	$sql_con_com=traer_fila_row(query_db($busca_contrato_completo));
	
	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
	$separa_fecha_crea = explode("-",$sql_con_com[19]);//fecha_creacion
	$ano_contra = $separa_fecha_crea[0];					
	$numero_contrato2 = substr($ano_contra,2,2);
	$numero_contrato3 = $sql_con_com[2];//consecutivo
	$numero_contrato4 = $sql_con_com[43];//apellido
	//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
	$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_con_com[0]);
	
	//$sel_permisos_email = query_db("select tsup.id_usuario,t1u.email from ".$g1." t1u left join ".$ts5." tsup on t1u.us_id=tsup.id_usuario  where tsup.id_permiso=26 and t1u.estado = 1");
	
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sel_permisos_email = query_db("select gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sql_con_com[9]. " group by gestor_abastecimiento, email_gestor_abastecimiento");
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	
	$correo_destino = "";
	$coma = "";
	while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
		if($correo_destino != ""){
			$coma = ",";
		}
		$correo_destino = $correo_destino.$coma.$lista_permisos_email[1];
	}
	
	$conte_tex = "<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Contrato:</strong></div></td>    <td>$consecutivo_imp</td>   </tr>  <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Polizas Completas</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>URL:</strong></div></td>     <td><a href='http://www.abastecimiento.hocol.com.co/'>http://www.abastecimiento.hocol.com.co</a></td>   </tr>  </table>";
	
	echo "<br /><br />correo que envia: abastecimiento@hcl.com.co<br />";
		echo "correo al que envia:<br />".$correo_destino;
	//Envio_email
		//$correo_destino="jose.sterling@enternova.net";
		$asunto_msn="SGPA Polizas Completas Contrato ".$consecutivo_imp ;
		$cuerpo =$conte_tex;
		//echo $asunto_msn."<br>";
		//echo $correo_destino."<br>";
		//echo $cuerpo;
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
	//descomentarias 	$mail->Send();
		
	// FIN Envio_email
}
function envia_email_polizas_observacion($id_contrato_llega,$id_obs_poliza){
	global $co1,$ts5,$g1,$correo_autentica_phpmailer,$contrasena_autentica_phpmailer,$servidor_phpmailer,$correo_from_phpmiler,$nombre_from_phpmiler,$co5;
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato_llega));//recibe id
	
	$bus_obs = "select * from $co5 where id = $id_obs_poliza";
	$sql_bus_obs=traer_fila_row(query_db($bus_obs));
	
	$busca_contrato_completo = "select * from $co1 where id = $id_contrato_arr";
	$sql_con_com=traer_fila_row(query_db($busca_contrato_completo));
	
	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
	$separa_fecha_crea = explode("-",$sql_con_com[19]);//fecha_creacion
	$ano_contra = $separa_fecha_crea[0];					
	$numero_contrato2 = substr($ano_contra,2,2);
	$numero_contrato3 = $sql_con_com[2];//consecutivo
	$numero_contrato4 = $sql_con_com[43];//apellido
	//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
	$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_con_com[0]);
	
	//$sel_permisos_email = query_db("select tsup.id_usuario,t1u.email from ".$g1." t1u left join ".$ts5." tsup on t1u.us_id=tsup.id_usuario  where tsup.id_permiso=26 and t1u.estado = 1");
		/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sel_permisos_email = query_db("select gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$busca_contrato_completo[9]." group by gestor_abastecimiento, email_gestor_abastecimiento");
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

	$correo_destino = "";
	$coma = "";
	while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
		if($correo_destino != ""){
			$coma = ",";
		}
		$correo_destino = $correo_destino.$coma.$lista_permisos_email[1];
	}
	
	$conte_tex = "<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Contrato:</strong></div></td>    <td>$consecutivo_imp</td>   </tr>  <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Observaciones Polizas </td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>URL:</strong></div></td>     <td><a href='http://www.abastecimiento.hocol.com.co/'>http://www.abastecimiento.hocol.com.co</a></td>   </tr>  <tr>    <td colspan='2'>$sql_bus_obs[3]	</td>  </tr>  </table>";
	
	//Envio_email
		//$correo_destino="jose.sterling@enternova.net";
		$asunto_msn="SGPA Polizas Observaciones Contrato ".$consecutivo_imp ;
		$cuerpo =$conte_tex;
		//echo $asunto_msn."<br>";
		//echo $correo_destino."<br>";
		//echo $cuerpo;
		
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
		
		echo "<br /><br /> correo que envia: abastecimiento@hcl.com.co<br />";
		echo "correo al que envia:<br />".$correo_destino;
	
	
		//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
		//$mail->AddCC("ferney.sterling@enternova.net");
		$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
		//$mail->AddBCC($correo_dvrnet2);//copia oculta
		//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
		//$mail->AddAttachment("files/demo.zip", "demo.zip");
		$mail->Body = $cuerpo;
		$mail->AltBody = "SGPA Informaciones";
		//descomentarias  $mail->Send();
		
	// FIN Envio_email
}

function envia_email_contrato_legalizacion($id_contrato_llega,$id_complemento){
	global $co1,$ts5,$g1,$correo_autentica_phpmailer,$contrasena_autentica_phpmailer,$servidor_phpmailer,$correo_from_phpmiler,$nombre_from_phpmiler,$co4,$pi2,$g8,$g6;
	
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato_llega));//recibe id
	
		$busca_contrato_completo = "select id,id_item,consecutivo,objeto,nit,contratista,contacto_principal,email1,telefono1,gerente,fecha_inicio,vigencia_mes,aplica_acta_inicio,representante_legal,email2,telefono2,especialista,monto_usd,monto_cop,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,t1_tipo_documento_id,acta_socios,recibido_poliza,camara_comercio,ok_fecha,sel_representante,legalizacion_final_par,legalizacion_final_par_e,analista_deloitte,apellido,aplica_acta,recibo_poliza,fecha_informativa,fecha_informativa_e,recibido_abastecimiento_e,area_ejecucion from $co1 where id = $id_contrato_arr";
		$sql_con_com=traer_fila_row(query_db($busca_contrato_completo));
		
		$t1_tipo_documento_id = $sql_con_com[34];
		$objeto = $sql_con_com[3];
		
		
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sql_con_com[19]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_con_com[2];//consecutivo
		$numero_contrato4 = $sql_con_com[43];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_con_com[0]);
		
		$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$sql_con_com[5];
		$sel_pro_q=traer_fila_row(query_db($sel_pro));
		$contratista = $sel_pro_q[3];
		
	if($id_complemento==0){		
		
		$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$sql_con_com[1];
		$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
		$sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$sql_con_com[1]));
		
		$asunto_msn="SGPA Legalizacion Contrato " ;
		$asunto_int="Legalizaci&oacute;n Contrato " ;
		$cuerpo_men_int = " El Contrato ".$consecutivo_imp;
		$sel_permisos_email = query_db("select t1u.us_id,t1u.email from ".$g1." t1u where t1u.estado = 1 and t1u.us_id=".$sql_con_com[9]);		
		$id_gerente_para_sacar_gestor_abas = $sql_con_com[9];
	}
	
	if($id_complemento>0){
		$alcance = "";
		$bus_complemento = "select t7c.id,t7c.id_item_pecc,t7c.numero_otrosi,t1t.nombre,t7c.gerente,t7c.alcance,t7c.tipo_complemento from $co4 t7c left join $g8 t1t on t7c.tipo_complemento = t1t.id where t7c.id=$id_complemento";
		$sql_bus_complemento=traer_fila_row(query_db($bus_complemento));		
		$t1_tipo_documento_id = $sql_bus_complemento[6];
		$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$sql_bus_complemento[1];
		$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
		$sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$sql_bus_complemento[1]));
		
		$asunto_msn="SGPA Legalizacion ".$sql_bus_complemento[3]." # ".$sql_bus_complemento[2] ;
		$asunto_int="Legalizaci&oacute;n ".$sql_bus_complemento[3]." # ".$sql_bus_complemento[2] ;
		$cuerpo_men_int = $sql_bus_complemento[3]." # ".$sql_bus_complemento[2];
		
		$sel_permisos_email = query_db("select t1u.us_id,t1u.email from ".$g1." t1u where t1u.estado = 1 and t1u.us_id=".$sql_bus_complemento[4]);
		
		$alcance = $sql_bus_complemento[5];
		$id_gerente_para_sacar_gestor_abas = $sql_bus_complemento[4];
		
		/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sel_permisos_email_gestion_aba = query_db("select gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sql_con_com[16]. " group by gestor_abastecimiento, email_gestor_abastecimiento");
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	
	$correo_destino_abast = "";
	$coma = "";
	while($lista_permisos_email_abas=traer_fila_row($sel_permisos_email_gestion_aba)){
		if($correo_destino_abast != ""){
			$coma = ",";
		}
		$correo_destino2 = $correo_destino2.$coma.$lista_permisos_email_abas[1];
	}
	}
	
	$correo_destino = "";
	$coma = "";
	while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
		if($correo_destino != ""){
			$coma = ",";
		}
		$correo_destino = $correo_destino.$coma.$lista_permisos_email[1];
	}
	
		/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sel_permisos_email_gestion_aba = query_db("select gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sql_con_com[9]. " group by gestor_abastecimiento, email_gestor_abastecimiento");
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	

	$coma = "";
	while($lista_permisos_email_abas=traer_fila_row($sel_permisos_email_gestion_aba)){
		if($correo_destino != ""){
			$coma = ",";
		}
		$correo_destino = $correo_destino.$coma.$lista_permisos_email_abas[1];
	}

	
	
	
	$sel_permisos_email2 = query_db("select t1u.us_id,t1u.email from ".$g1." t1u where t1u.estado = 1 and t1u.us_id=".$sql_con_com[16]);

	$coma = "";
	while($lista_permisos_email2=traer_fila_row($sel_permisos_email2)){
		if($correo_destino2 != ""){
			$coma = ",";
		}
		$correo_destino2 = $correo_destino2.$coma.$lista_permisos_email2[1];
	}

	



	
	$conte_tex = "<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>    <tr>    <td style='background-color:#999999'><div align='right'><strong>Solicitud:</strong></div></td>    <td>".numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])."</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Contrato:</strong></div></td>    <td>$consecutivo_imp</td>   </tr>  <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>$asunto_int </td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>URL:</strong></div></td>     <td><a href='http://www.abastecimiento.hocol.com.co/'>http://www.abastecimiento.hocol.com.co</a></td>   </tr> ";
	if($t1_tipo_documento_id==1){
		$conte_tex = $conte_tex."<tr><td align='right' style='background-color:#999999'><strong>Proveedor:</strong></td><td>".$contratista."</td></tr><tr><td align='right' style='background-color:#999999'><strong>Objeto:</strong></td><td>".$objeto."</td></tr>";
	}
	
	if($t1_tipo_documento_id==2){
		$conte_tex = $conte_tex."<tr><td align='right' style='background-color:#999999'><strong>Objeto Orden de Trabajo:</strong></td><td>".$alcance."</td></tr>";
	}
	
	$conte_tex = $conte_tex."<tr>    <td colspan='2'><br>*El Equipo de Abastecimiento informa que $cuerpo_men_int, ya se encuentra legalizada, por tanto la prestaci&oacute;n de los servicios puede iniciar.<br><br>*Ya es posible cargar las tarifas aplicables al contrato</td>  </tr>  </table>";
	
	
	
	//Envio_email
		//$correo_destino="jose.sterling@enternova.net";
		$cuerpo =$conte_tex;
		//echo $asunto_msn."<br>";
		//echo $correo_destino."<br>";
		//echo $correo_destino2."<br>";
		//echo $cuerpo;
		
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
		
			/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sel_permisos_email = traer_fila_row(query_db("select gestor_abastecimiento, email_gestor_abastecimiento, nombre_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$id_gerente_para_sacar_gestor_abas." group by gestor_abastecimiento, email_gestor_abastecimiento"));
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
		if($sel_permisos_email[0]>0){
			$mail->AddAddress($sel_permisos_email[1],$sel_permisos_email[2]);
		}
		$mail->AddAddress($correo_destino,$nombre);
		$mail->AddAddress($correo_destino2,$nombre);
		//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
		//$mail->AddCC("ferney.sterling@enternova.net");
		$mail->AddAddress("sgpa-notificaciones@enternova.net");//copia oculta
		$mail->AddAddress("Nataly.mahecha@achilles.com");
		$mail->AddAddress("Nathaly.mahecha@hcl.com.co");
		$mail->AddAddress("Jennifer.colmenares@hcl.com.co");
		$mail->AddAddress("lina.gomez@achilles.com");
		
		echo "<br /><br />correo Que envia: abastecimiento@hcl.com.co<br />";
		echo "correo al que envia:<br /> Nataly.mahecha@achilles.com<br />Nathaly.mahecha@hcl.com.co<br />Jennifer.colmenares@hcl.com.co<br />lina.gomez@achilles.com<br />".$correo_destino."<br />".$correo_destino2."<br />".$sel_permisos_email[1];
		
		//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
		//$mail->AddAttachment("files/demo.zip", "demo.zip");
		$mail->Body = $cuerpo;
		$mail->AltBody = "SGPA Informaciones";
		//descomentarias $mail->Send();
	// FIN Envio_email
}
//envia_email_polizas_vence();
function envia_email_polizas_vence(){
	global $correo_autentica_phpmailer,$contrasena_autentica_phpmailer,$servidor_phpmailer,$correo_from_phpmiler,$nombre_from_phpmiler,$co3,$co1,$ts5,$g1,$g7,$co4,$g23,$g6;	
		
		
	//$sel_permisos_email = query_db("select tsup.id_usuario,t1u.email from ".$g1." t1u left join ".$ts5." tsup on t1u.us_id=tsup.id_usuario  where tsup.id_permiso=12 and t1u.estado = 1");
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sel_permisos_email = query_db("select gestor_abastecimiento, email_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$busca_contrato_completo[9]);
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

	$correo_destino_perfil = "";
	$coma = "";
	while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
		if($correo_destino_perfil != ""){
			$coma = ",";
		}
		$correo_destino_perfil = $correo_destino_perfil.$coma.$lista_permisos_email[1];//Correo perfil polizas
	}
	//inicio Faltanto 15 dias
	$fecha_busca = date("Y-m-d",strtotime("+15 day"));	
	$busca_correo = query_db("select distinct (t7c.id)  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id where t7p.fecha_fin = '".$fecha_busca."' and (t7p.fecha_fin < t7c.vigencia_mes and t7c.vigencia_mes != '')");
	while($sql_busca_correo=traer_fila_row($busca_correo)){
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora,t1pr.razon_social as proveedor  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id left join ".$g6." t1pr on t7c.contratista = t1pr.t1_proveedor_id where t7c.id = '".$sql_busca_correo[0]."'");
		$sql_bus_complemento=traer_fila_row($busca_contrato_completo);
			
		$correo_destino_int = $sql_bus_complemento[6];//Correo proveedor
		/*Envio Gerente, Especialista	
		$sel_permisos_email = query_db("select t1u.us_id,t1u.email from ".$g1." t1u where t1u.us_id in (".$sql_bus_complemento[7].",".$sql_bus_complemento[8].")");
		$correo_ger_esp = "";
		$coma = "";
		while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
			if($correo_ger_esp != ""){
				$coma = ",";
			}
			$correo_ger_esp = $correo_ger_esp.$coma.$lista_permisos_email[1];
		}
		*/
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sql_bus_complemento[2]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_bus_complemento[3];//consecutivo
		$numero_contrato4 = $sql_bus_complemento[4];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_bus_complemento[0]);
			
		$conte_tex = "";
		$conte_tex = $conte_tex."<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>    <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Vencimiento Polizas </td>  </tr>    <tr>    <td align='right' style='background-color:#999999'><strong>Numero Contrato</strong></td>    <td>$consecutivo_imp</td>  </tr>  <tr>    <td align='right' style='background-color:#999999'><strong>Objeto</strong></td>    <td>$sql_bus_complemento[5]</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Proveedor:</strong></div></td>     <td>$sql_bus_complemento[18]</td>   </tr> <tr>     <td colspan='2'><font size='+1'> El Equipo de Abastecimiento informa que las siguientes p&oacute;lizas vencer&aacute;n en 15 D&iacute;as, de acuerdo a la Cl&aacute;usula contractual les solicitamos actualizar y presentar las P&oacute;lizas en las oficinas de Hocol S.A. &Aacute;rea de Abastecimiento.</font></td>  </tr><tr> <td colspan='2'>						 <table width='100%'>    		<tr>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Poliza</td>        <td width='12%' align='center' style='background-color:#CCCCCC'># Modificacion</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Moneda</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Valor Asegurado</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha inicio</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha Fin</td>        <td colspan='2' align='center' style='background-color:#CCCCCC'>Aseguradora</td>    </tr>";
			
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id where t7c.id = '".$sql_busca_correo[0]."' and t7p.fecha_fin = '".$fecha_busca."' and (t7p.fecha_fin < t7c.vigencia_mes and t7c.vigencia_mes != '')");
		while($sql_con=traer_fila_row($busca_contrato_completo)){
			if($sql_con[14]==1){
				$tipo_moneda = "COP";
			}
			if($sql_con[14]==2){
				$tipo_moneda = "USD";
			}
			$conte_tex = $conte_tex."<tr>      <td>$sql_con[10]</td>      <td>$sql_con[13]</td>      <td>$tipo_moneda</td>      <td>".valida_numero_imp($sql_con[15])."</td>      <td>$sql_con[11]</td>      <td>$sql_con[12]</td>      <td width='15%'>$sql_con[16]</td>      <td width='13%'>$sql_con[17]</td>    </tr>";
		}
		
		$conte_tex = $conte_tex."</table>    </td>  </tr>    </table>";		
		
		$correo_destino = $correo_destino_perfil;
		if($correo_destino_int!=""){
			$correo_destino = $correo_destino.",".$correo_destino_int;
		}
		if($correo_ger_esp!=""){
			$correo_destino = $correo_destino.",".$correo_ger_esp;
		}
		
		//$correo_destino="jose.sterling@enternova.net";
		$asunto_msn="SGPA Vencimiento Polizas " ;
		$cuerpo = $conte_tex;
		echo $asunto_msn."<br>";
		echo $correo_destino."<br>";
		echo $cuerpo;
		
		//Envio_email
			/*
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
			//descomentarias  $mail->Send();
			*/
		// FIN Envio_email
	}
	//fin Faltanto 15 dias
	
	//inicio Faltanto 10 dias
	$fecha_busca = date("Y-m-d",strtotime("+10 day"));	
	$busca_correo = query_db("select distinct (t7c.id)  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id where t7p.fecha_fin = '".$fecha_busca."' and (t7p.fecha_fin < t7c.vigencia_mes and t7c.vigencia_mes != '')");
	while($sql_busca_correo=traer_fila_row($busca_correo)){
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora,t1pr.razon_social as proveedor  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id left join ".$g6." t1pr on t7c.contratista = t1pr.t1_proveedor_id where t7c.id = '".$sql_busca_correo[0]."'");
		$sql_bus_complemento=traer_fila_row($busca_contrato_completo);
			
		$correo_destino_int = $sql_bus_complemento[6];//Correo proveedor
		/*Envio Gerente, Especialista	
		$sel_permisos_email = query_db("select t1u.us_id,t1u.email from ".$g1." t1u where t1u.us_id in (".$sql_bus_complemento[7].",".$sql_bus_complemento[8].")");
		$correo_ger_esp = "";
		$coma = "";
		while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
			if($correo_ger_esp != ""){
				$coma = ",";
			}
			$correo_ger_esp = $correo_ger_esp.$coma.$lista_permisos_email[1];
		}
		*/
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sql_bus_complemento[2]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_bus_complemento[3];//consecutivo
		$numero_contrato4 = $sql_bus_complemento[4];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_bus_complemento[0]);
			
		$conte_tex = "";
		$conte_tex = $conte_tex."<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>    <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Vencimiento Polizas </td>  </tr>    <tr>    <td align='right' style='background-color:#999999'><strong>Numero Contrato</strong></td>    <td>$consecutivo_imp</td>  </tr>  <tr>    <td align='right' style='background-color:#999999'><strong>Objeto</strong></td>    <td>$sql_bus_complemento[5]</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Proveedor:</strong></div></td>     <td>$sql_bus_complemento[18]</td>   </tr> <tr>     <td colspan='2'><font size='+1'> El Equipo de Abastecimiento informa que las siguientes p&oacute;lizas vencer&aacute;n en 10 D&iacute;as, de acuerdo a la Cl&aacute;usula contractual les solicitamos actualizar y presentar las P&oacute;lizas en las oficinas de Hocol S.A. &Aacute;rea de Abastecimiento.</font></td>  </tr><tr> <td colspan='2'>						 <table width='100%'>    		<tr>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Poliza</td>        <td width='12%' align='center' style='background-color:#CCCCCC'># Modificacion</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Moneda</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Valor Asegurado</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha inicio</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha Fin</td>        <td colspan='2' align='center' style='background-color:#CCCCCC'>Aseguradora</td>    </tr>";
			
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id where t7c.id = '".$sql_busca_correo[0]."' and t7p.fecha_fin = '".$fecha_busca."' and (t7p.fecha_fin < t7c.vigencia_mes and t7c.vigencia_mes != '')");
		while($sql_con=traer_fila_row($busca_contrato_completo)){
			if($sql_con[14]==1){
				$tipo_moneda = "COP";
			}
			if($sql_con[14]==2){
				$tipo_moneda = "USD";
			}
			$conte_tex = $conte_tex."<tr>      <td>$sql_con[10]</td>      <td>$sql_con[13]</td>      <td>$tipo_moneda</td>      <td>".valida_numero_imp($sql_con[15])."</td>      <td>$sql_con[11]</td>      <td>$sql_con[12]</td>      <td width='15%'>$sql_con[16]</td>      <td width='13%'>$sql_con[17]</td>    </tr>";
		}
		
		$conte_tex = $conte_tex."</table>    </td>  </tr>    </table>";		
		
		$correo_destino = $correo_destino_perfil;
		if($correo_destino_int!=""){
			$correo_destino = $correo_destino.",".$correo_destino_int;
		}
		if($correo_ger_esp!=""){
			$correo_destino = $correo_destino.",".$correo_ger_esp;
		}
		
		//$correo_destino="jose.sterling@enternova.net";
		$asunto_msn="SGPA Vencimiento Polizas " ;
		$cuerpo = $conte_tex;
		echo $asunto_msn."<br>";
		echo $correo_destino."<br>";
		echo $cuerpo;
		
		//Envio_email
			/*
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
			//descomentarias  $mail->Send();
			*/
		// FIN Envio_email
	}
	//inicio Faltanto 10 dias
	
	//inicio Faltanto 5 dias Diario
	$fecha_busca = date("Y-m-d",strtotime("+5 day"));	
	$fecha_hoy = date("Y-m-d");	
	$busca_correo = query_db("select distinct (t7c.id)  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id where (t7p.fecha_fin >= '".$fecha_hoy."' and t7p.fecha_fin <= '".$fecha_busca."') and (t7p.fecha_fin < t7c.vigencia_mes and t7c.vigencia_mes != '')");
	while($sql_busca_correo=traer_fila_row($busca_correo)){
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora,t1pr.razon_social as proveedor,t7cc.tipo_complemento  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id left join ".$g6." t1pr on t7c.contratista = t1pr.t1_proveedor_id where t7c.id = '".$sql_busca_correo[0]."'");
		
		$sql_bus_complemento=traer_fila_row($busca_contrato_completo);
			
		$correo_destino_int = $sql_bus_complemento[6];//Correo proveedor
		/*Envio Gerente, Especialista	
		$sel_permisos_email = query_db("select t1u.us_id,t1u.email from ".$g1." t1u where t1u.us_id in (".$sql_bus_complemento[7].",".$sql_bus_complemento[8].")");
		$correo_ger_esp = "";
		$coma = "";
		while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
			if($correo_ger_esp != ""){
				$coma = ",";
			}
			$correo_ger_esp = $correo_ger_esp.$coma.$lista_permisos_email[1];
		}
		*/
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sql_bus_complemento[2]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_bus_complemento[3];//consecutivo
		$numero_contrato4 = $sql_bus_complemento[4];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $sql_bus_complemento[0]);
		
		$imp_titu = "# modificacio&oacute;n";
		if($sql_bus_complemento[19]==2){
			$imp_titu = "Orden de Trabajo";
		}
		$conte_tex = "";
		$conte_tex = $conte_tex."<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>    <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Vencimiento Polizas </td>  </tr>    <tr>    <td align='right' style='background-color:#999999'><strong>Numero Contrato</strong></td>    <td>$consecutivo_imp</td>  </tr>  <tr>    <td align='right' style='background-color:#999999'><strong>Objeto</strong></td>    <td>$sql_bus_complemento[5]</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Proveedor:</strong></div></td>     <td>$sql_bus_complemento[18]</td>   </tr> <tr>     <td colspan='2'><font size='+1'> El Equipo de Abastecimiento informa que las siguientes p&oacute;lizas vencer&aacute;n en los Pr&oacute;ximos 5 D&iacute;as, de acuerdo a la Cl&aacute;usula contractual les solicitamos actualizar y presentar las P&oacute;lizas en las oficinas de Hocol S.A. &Aacute;rea de Abastecimiento.</font></td>  </tr><tr> <td colspan='2'>						 <table width='100%'>    		<tr>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Poliza</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>$imp_titu</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Moneda</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Valor Asegurado</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha inicio</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha Fin</td>        <td colspan='2' align='center' style='background-color:#CCCCCC'>Aseguradora</td>    </tr>";
			
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id where t7c.id = '".$sql_busca_correo[0]."' and (t7p.fecha_fin >= '".$fecha_hoy."' and t7p.fecha_fin <= '".$fecha_busca."') and (t7p.fecha_fin < t7c.vigencia_mes and t7c.vigencia_mes != '')");
		while($sql_con=traer_fila_row($busca_contrato_completo)){
			if($sql_con[14]==1){
				$tipo_moneda = "COP";
			}
			if($sql_con[14]==2){
				$tipo_moneda = "USD";
			}
			$conte_tex = $conte_tex."<tr>      <td>$sql_con[10]</td>      <td>$sql_con[13]</td>      <td>$tipo_moneda</td>      <td>".valida_numero_imp($sql_con[15])."</td>      <td>$sql_con[11]</td>      <td>$sql_con[12]</td>      <td width='15%'>$sql_con[16]</td>      <td width='13%'>$sql_con[17]</td>    </tr>";
		}
		
		$conte_tex = $conte_tex."</table>    </td>  </tr>    </table>";		
		
		$correo_destino = $correo_destino_perfil;
		if($correo_destino_int!=""){
			$correo_destino = $correo_destino.",".$correo_destino_int;
		}
		if($correo_ger_esp!=""){
			$correo_destino = $correo_destino.",".$correo_ger_esp;
		}
		
		//$correo_destino="jose.sterling@enternova.net";
		$asunto_msn="SGPA Vencimiento Polizas " ;
		$cuerpo = $conte_tex;
		echo $asunto_msn."<br>";
		echo $correo_destino."<br>";
		echo $cuerpo;
		
		//Envio_email
			/*
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
			//descomentarias  $mail->Send();
			*/
		// FIN Envio_email
	}
	//inicio Faltanto 5 dias Diario
}
function sent_mail($destino,$asunto,$mensaje_envio) //FUNCION PARA ENVIAR CORREOS
{
	global $correo_autentica_phpmailer,$contrasena_autentica_phpmailer , $servidor_phpmailer;
	$tipo_envio = explode("*",$destino);
	if($tipo_envio[0]=="pasa_id_us"){
		$sql_sel_us = "select nombre_administrador, email from t1_us_usuarios where us_id in (".$tipo_envio[1].",7) and estado = 1 group by nombre_administrador, email";
		$sel_usuario_envio = query_db($sql_sel_us);
		
	

	/*Productivo*/
	$mail = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; 
	$mail->SMTPSecure = "";
	$mail->Port       = 25; 
	$mail->Username = $correo_autentica_phpmailer; 
	$mail->Password = $contrasena_autentica_phpmailer; 
	$mail->Host = $servidor_phpmailer;
	$mail->From = "maria.cock@hocol.com.co";
	$mail->FromName = "COCK, MARIA VICTORIA";
	/*FIN Productivo*/
	
	/*Pruebas
	$mail = new PHPMailer(true);
	$mail->IsSMTP(); 
	$mail->SMTPDebug  = 1;   
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = "ssl";
	$mail->Port       = 465; 
	$mail->Username = "jeison.rivera@enternova.net"; 
	$mail->Password = "RRRj@son12"; 
	$mail->Host = "smtp.gmail.com";
	$mail->From = "jeison.rivera@enternova.net";
	$mail->FromName = "SGPA Notificaciones";
	echo $mensaje_envio;
	/*FIN Pruebas*/
	
	
	
	
	while($sel_usua = traer_fila_db($sel_usuario_envio)){
	
	echo $sel_usua[1]." - ".$sel_usua[0]."<br />";
	
			$mail->AddAddress($sel_usua[1], $sel_usua[0]);
			}



    
    $mail->AddBCC("sgpa-notificaciones@enternova.net","SGPA Informaciones");
	$mail->AddBCC("abastecimiento@hcl.com.co","Bogota, Abastecimiento"); 
    $mail->Subject = $asunto;
    $mail->AltBody = $asunto;
    $mail->MsgHTML($mensaje_envio);  
    $mail->Send();
		
	}else{
	
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
    //$mail->AddAddress($destino, "");
    $mail->AddBCC("sgpa-notificaciones@enternova.net","SGPA Informaciones");
	$mail->AddAddress("abastecimiento@hcl.com.co","Bogota, Abastecimiento"); 
    $mail->From = $correo_emisor;
    $mail->FromName = $nombre_emisor;
    $mail->Subject = $asunto;
    $mail->AltBody = $asunto;
    $mail->MsgHTML($mensaje_envio);  
    $mail->Send();
	}
}
function sent_mail_with_signature($destino,$asunto,$mensaje_envio, $emisor, $nombre_emisor) //FUNCION PARA ENVIAR CORREOS CON FIRMAS PARA EL DES 009 DE LEGALIZACIONES Y CAMBIOS DE GERENTE
{
	$destino2=$destino;
    
	
	//global $correo_autentica_phpmailer,$contrasena_autentica_phpmailer , $servidor_phpmailer;
    $mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug  = 1; 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = "ssl";
	$mail->Port       = 465; 
	$mail->Username = "jeison.rivera@enternova.net";
	$mail->Password = "RRRj@son12"; 
	$mail->Host = "smtp.gmail.com";
	$mail->From = $emisor;
	$mail->FromName = $nombre_emisor;
    $mail->AddReplyTo($emisor, $nombre_emisor);
    $destino=explode(',,', $destino);
	foreach ($destino as $v) {
		if($v!=""){
			/*?><script>alert("este email se enviara a: <?=$v?>")</script><?*/
		    $mail->AddAddress($v, "");
		}
	}
	

    //$mail->AddBCC("sgpa-notificaciones@enternova.net","SGPA Informaciones");
	//$mail->AddAddress("abastecimiento@hcl.com.co","Bogota, Abastecimiento"); 
    $mail->Subject = $asunto;
    $mail->AltBody = $asunto;
    $mail->MsgHTML($mensaje_envio);  
    $mail->Send();

}
?>