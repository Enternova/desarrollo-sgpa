<?
include('../../librerias/PHPMailer_v2.0.0/class.phpmailer.php'); 

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
	
	$sel_permisos_email = query_db("select tsup.id_usuario,t1u.email from ".$g1." t1u left join ".$ts5." tsup on t1u.us_id=tsup.id_usuario  where tsup.id_permiso=26");
	$correo_destino = "";
	$coma = "";
	while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
		if($correo_destino != ""){
			$coma = ",";
		}
		$correo_destino = $correo_destino.$coma.$lista_permisos_email[1];
	}
	
	$conte_tex = "<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Contrato:</strong></div></td>    <td>$consecutivo_imp</td>   </tr>  <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Polizas Completas</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>URL:</strong></div></td>     <td><a href='http://www.abastecimiento.hocol.com.co/'>http://www.abastecimiento.hocol.com.co</a></td>   </tr>  <tr>    <td colspan='2'>&nbsp;</td>  </tr>  <tr>     <td colspan='2'><ul>      <li>Este correo es automatico, por favor no lo responda.</li>      <li>Si su contraseña presenta inconvenientes por favor ingrese a <a href='http://www.abastecimiento.hocol.com.co//recordacion_contrasena.php'>http://www.abastecimiento.hocol.com.co/sgpa/recordacion_contrasena.php </a> y digite el usuario.</li>       <li>Comuniquese al soporte técnico en el teléfono (57 1) 255 0916 Bogotá, Colombia</li>    </ul></td>  </tr>  <tr>    <td>&nbsp;</td>     <td>&nbsp;</td>  </tr></table>";
	
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
		$mail->Send();
		
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
	
	$sel_permisos_email = query_db("select tsup.id_usuario,t1u.email from ".$g1." t1u left join ".$ts5." tsup on t1u.us_id=tsup.id_usuario  where tsup.id_permiso=26");
	$correo_destino = "";
	$coma = "";
	while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
		if($correo_destino != ""){
			$coma = ",";
		}
		$correo_destino = $correo_destino.$coma.$lista_permisos_email[1];
	}
	
	$conte_tex = "<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Contrato:</strong></div></td>    <td>$consecutivo_imp</td>   </tr>  <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Observaciones Polizas </td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>URL:</strong></div></td>     <td><a href='http://www.abastecimiento.hocol.com.co/'>http://www.abastecimiento.hocol.com.co</a></td>   </tr>  <tr>    <td colspan='2'>$sql_bus_obs[3]	</td>  </tr>  <tr>     <td colspan='2'><ul>      <li>Este correo es automatico, por favor no lo responda.</li>      <li>Si su contraseña presenta inconvenientes por favor ingrese a <a href='http://www.abastecimiento.hocol.com.co//recordacion_contrasena.php'>http://www.abastecimiento.hocol.com.co/sgpa/recordacion_contrasena.php </a> y digite el usuario.</li>       <li>Comuniquese al soporte técnico en el teléfono (57 1) 255 0916 Bogotá, Colombia</li>    </ul></td>  </tr>  <tr>    <td>&nbsp;</td>     <td>&nbsp;</td>  </tr></table>";
	
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
		//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
		//$mail->AddCC("ferney.sterling@enternova.net");
		$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
		//$mail->AddBCC($correo_dvrnet2);//copia oculta
		//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
		//$mail->AddAttachment("files/demo.zip", "demo.zip");
		$mail->Body = $cuerpo;
		$mail->AltBody = "SGPA Informaciones";
		$mail->Send();
		
	// FIN Envio_email
}

function envia_email_contrato_legalizacion($id_contrato_llega,$id_complemento){
	global $co1,$ts5,$g1,$correo_autentica_phpmailer,$contrasena_autentica_phpmailer,$servidor_phpmailer,$correo_from_phpmiler,$nombre_from_phpmiler,$co4,$pi2,$g8;
	
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
		
	if($id_complemento==0){		
		
		$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$sql_con_com[1];
		$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
		$sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$sql_con_com[1]));
		
		$asunto_msn="SGPA Legalizacion Contrato " ;
		$asunto_int="Legalizaci&oacute;n Contrato " ;
		$cuerpo_men_int = " El Contrato ".$consecutivo_imp;
		$sel_permisos_email = query_db("select t1u.us_id,t1u.email from ".$g1." t1u where t1u.us_id=".$sql_con_com[9]);
		
	}
	
	if($id_complemento>0){
		$bus_complemento = "select t7c.id,t7c.id_item_pecc,t7c.numero_otrosi,t1t.nombre,t7c.gerente from $co4 t7c left join $g8 t1t on t7c.tipo_complemento = t1t.id where t7c.id=$id_complemento";
		$sql_bus_complemento=traer_fila_row(query_db($bus_complemento));		
		
		$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$sql_bus_complemento[1];
		$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
		$sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$sql_bus_complemento[1]));
		
		$asunto_msn="SGPA Legalizacion ".$sql_bus_complemento[3]." # ".$sql_bus_complemento[2] ;
		$asunto_int="Legalizaci&oacute;n ".$sql_bus_complemento[3]." # ".$sql_bus_complemento[2] ;
		$cuerpo_men_int = $sql_bus_complemento[3]." # ".$sql_bus_complemento[2];
		
		$sel_permisos_email = query_db("select t1u.us_id,t1u.email from ".$g1." t1u where t1u.us_id=".$sql_bus_complemento[4]);
	}
	
	
	$correo_destino = "";
	$coma = "";
	while($lista_permisos_email=traer_fila_row($sel_permisos_email)){
		if($correo_destino != ""){
			$coma = ",";
		}
		$correo_destino = $correo_destino.$coma.$lista_permisos_email[1];
	}
	
	$conte_tex = "<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>    <tr>    <td style='background-color:#999999'><div align='right'><strong>Solicitud:</strong></div></td>    <td>".numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])."</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Contrato:</strong></div></td>    <td>$consecutivo_imp</td>   </tr>  <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>$asunto_int </td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>URL:</strong></div></td>     <td><a href='http://www.abastecimiento.hocol.com.co/'>http://www.abastecimiento.hocol.com.co</a></td>   </tr>  <tr>    <td colspan='2'>El Equipo de Abastecimiento informa que $cuerpo_men_int, ya se encuentra legalizada, por tanto la prestaci&oacute;n de los servicios puede iniciar.</td>  </tr>  <tr>     <td colspan='2'><ul>      <li>Este correo es automatico, por favor no lo responda.</li>      <li>Si su contrase&ntilde;a presenta inconvenientes por favor ingrese a <a href='http://www.abastecimiento.hocol.com.co//recordacion_contrasena.php'>http://www.abastecimiento.hocol.com.co/sgpa/recordacion_contrasena.php </a> y digite el usuario.</li>       <li>Comuniquese al soporte t&eacute;cnico en el tel&eacute;fono (57 1) 255 0916 Bogot&aacute;, Colombia</li>    </ul></td>  </tr>  <tr>    <td>&nbsp;</td>     <td>&nbsp;</td>  </tr></table>";
	
	//Envio_email
		//$correo_destino="jose.sterling@enternova.net";
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
		$mail->AddBCC("Nataly.mahecha@achilles.com");
		$mail->AddBCC("Nathaly.mahecha@hcl.com.co");
		$mail->AddBCC("Jennifer.colmenares@hcl.com.co");
		$mail->AddBCC("lina.gomez@achilles.com");
		$mail->AddBCC("Mónica.pinzon@aon.com");
		
		//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
		//$mail->AddAttachment("files/demo.zip", "demo.zip");
		$mail->Body = $cuerpo;
		$mail->AltBody = "SGPA Informaciones";
		$mail->Send();
		
	// FIN Envio_email
}

?>

