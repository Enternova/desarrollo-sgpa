<? include("../../librerias/lib/@include.php");

	global $correo_autentica_phpmailer,$contrasena_autentica_phpmailer,$servidor_phpmailer,$correo_from_phpmiler,$nombre_from_phpmiler,$co3,$co1,$ts5,$g1,$g7,$co4,$g23,$g6;	
			
	//inicio Faltanto 15 dias
	$fecha_busca = date("Y-m-d",strtotime("+15 day"));	
	$busca_correo = query_db("select distinct (t7c.id)  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id where t7p.fecha_fin = '".$fecha_busca."' and (t7p.fecha_fin COLLATE Cyrillic_General_CI_AI < t7c.vigencia_mes COLLATE Cyrillic_General_CI_AI and t7c.vigencia_mes != '')");
	while($sql_busca_correo=traer_fila_row($busca_correo)){
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora,t1pr.razon_social as proveedor,t7cc.tipo_complemento  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id left join ".$g6." t1pr on t7c.contratista = t1pr.t1_proveedor_id where t7c.id = '".$sql_busca_correo[0]."'");
		$sql_bus_complemento=traer_fila_row($busca_contrato_completo);
			
		$correo_proveedor = $sql_bus_complemento[6];//Correo proveedor		
		
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sql_bus_complemento[2]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_bus_complemento[3];//consecutivo
		$numero_contrato4 = $sql_bus_complemento[4];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_bus_complemento[0]);
		
		$imp_titu = "# modificacio&oacute;n";
		if($sql_bus_complemento[19]==2){
			$imp_titu = "Orden de Trabajo";
		}
		
		$conte_tex = "";
		$conte_tex = $conte_tex."<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>    <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Vencimiento Polizas </td>  </tr>    <tr>    <td align='right' style='background-color:#999999'><strong>Numero Contrato</strong></td>    <td>$consecutivo_imp</td>  </tr>  <tr>    <td align='right' style='background-color:#999999'><strong>Objeto</strong></td>    <td>$sql_bus_complemento[5]</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Proveedor:</strong></div></td>     <td>$sql_bus_complemento[18]</td>   </tr> <tr>     <td colspan='2'><font size='+1'> El Equipo de Abastecimiento informa que las siguientes p&oacute;lizas vencer&aacute;n en 15 D&iacute;as, de acuerdo a la Cl&aacute;usula contractual les solicitamos actualizar y presentar las P&oacute;lizas en las oficinas de Hocol S.A. &Aacute;rea de Abastecimiento.</font></td>  </tr><tr> <td colspan='2'>						 <table width='100%'>    		<tr>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Poliza</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>$imp_titu</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Moneda</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Valor Asegurado</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha inicio</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha Fin</td>        <td colspan='2' align='center' style='background-color:#CCCCCC'>Aseguradora</td>    </tr>";
			
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id where t7c.id = '".$sql_busca_correo[0]."' and t7p.fecha_fin = '".$fecha_busca."' and (t7p.fecha_fin COLLATE Cyrillic_General_CI_AI < t7c.vigencia_mes COLLATE Cyrillic_General_CI_AI and t7c.vigencia_mes != '')");
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
		
				
		//$correo_destino="jose.sterling@enternova.net";
		$asunto_msn="SGPA Vencimiento Polizas " ;
		$cuerpo = $conte_tex;
		//echo $asunto_msn."<br>";
		//echo $correo_destino."<br>";
		//echo $cuerpo;
		
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
			$mail->AddAddress($correo_proveedor,$nombre);
			//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
			//$mail->AddCC("ferney.sterling@enternova.net");
			$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
			$mail->AddAddress("Nataly.mahecha@achilles.com");
			$mail->AddAddress("Nathaly.mahecha@hcl.com.co");
			$mail->AddAddress("Jennifer.colmenares@hcl.com.co");
			$mail->AddAddress("Jennifer.colmenares@achilles.com");
			$mail->AddAddress("lissette.patino@hcl.com.co");		
			$mail->AddAddress("asistenteaon.bogota@hcl.com.co");
			$mail->AddAddress("pmgbaon.bogota@hcl.com.co");
			$mail->AddAddress("viviana.londono@hcl.com.co");
			//$mail->AddBCC($correo_dvrnet2);//copia oculta
			//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
			//$mail->AddAttachment("files/demo.zip", "demo.zip");
			$mail->Body = $cuerpo;
			$mail->AltBody = "SGPA Informaciones";
			$mail->Send();
			*/
		// FIN Envio_email
	}
	//fin Faltanto 15 dias
	
	//inicio Faltanto 10 dias
	$fecha_busca = date("Y-m-d",strtotime("+10 day"));	
	$busca_correo = query_db("select distinct (t7c.id)  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id where t7p.fecha_fin = '".$fecha_busca."' and (t7p.fecha_fin COLLATE Cyrillic_General_CI_AI < t7c.vigencia_mes COLLATE Cyrillic_General_CI_AI and t7c.vigencia_mes != '')");
	while($sql_busca_correo=traer_fila_row($busca_correo)){
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora,t1pr.razon_social as proveedor,t7cc.tipo_complemento  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id left join ".$g6." t1pr on t7c.contratista = t1pr.t1_proveedor_id where t7c.id = '".$sql_busca_correo[0]."'");
		$sql_bus_complemento=traer_fila_row($busca_contrato_completo);
			
		$correo_proveedor = $sql_bus_complemento[6];//Correo proveedor		
		
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sql_bus_complemento[2]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_bus_complemento[3];//consecutivo
		$numero_contrato4 = $sql_bus_complemento[4];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_bus_complemento[0]);
		$imp_titu = "# modificacio&oacute;n";
		if($sql_bus_complemento[19]==2){
			$imp_titu = "Orden de Trabajo";
		}
		$conte_tex = "";
		$conte_tex = $conte_tex."<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>    <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Vencimiento Polizas </td>  </tr>    <tr>    <td align='right' style='background-color:#999999'><strong>Numero Contrato</strong></td>    <td>$consecutivo_imp</td>  </tr>  <tr>    <td align='right' style='background-color:#999999'><strong>Objeto</strong></td>    <td>$sql_bus_complemento[5]</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Proveedor:</strong></div></td>     <td>$sql_bus_complemento[18]</td>   </tr> <tr>     <td colspan='2'><font size='+1'> El Equipo de Abastecimiento informa que las siguientes p&oacute;lizas vencer&aacute;n en 10 D&iacute;as, de acuerdo a la Cl&aacute;usula contractual les solicitamos actualizar y presentar las P&oacute;lizas en las oficinas de Hocol S.A. &Aacute;rea de Abastecimiento.</font></td>  </tr><tr> <td colspan='2'>						 <table width='100%'>    		<tr>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Poliza</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>$imp_titu</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Moneda</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Valor Asegurado</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha inicio</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha Fin</td>        <td colspan='2' align='center' style='background-color:#CCCCCC'>Aseguradora</td>    </tr>";
			
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id where t7c.id = '".$sql_busca_correo[0]."' and t7p.fecha_fin = '".$fecha_busca."' and (t7p.fecha_fin COLLATE Cyrillic_General_CI_AI < t7c.vigencia_mes COLLATE Cyrillic_General_CI_AI and t7c.vigencia_mes != '')");
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
		
		
		//$correo_destino="jose.sterling@enternova.net";
		$asunto_msn="SGPA Vencimiento Polizas " ;
		$cuerpo = $conte_tex;
		//echo $asunto_msn."<br>";
		//echo $correo_destino."<br>";
		//echo $cuerpo;
		
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
			$mail->AddAddress($correo_proveedor,$nombre);
			//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
			//$mail->AddCC("ferney.sterling@enternova.net");
			$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
			$mail->AddAddress("Nataly.mahecha@achilles.com");
			$mail->AddAddress("Nathaly.mahecha@hcl.com.co");
			$mail->AddAddress("Jennifer.colmenares@hcl.com.co");
			$mail->AddAddress("Jennifer.colmenares@achilles.com");
			$mail->AddAddress("lissette.patino@hcl.com.co");		
			$mail->AddAddress("asistenteaon.bogota@hcl.com.co");
			$mail->AddAddress("pmgbaon.bogota@hcl.com.co");
			$mail->AddAddress("viviana.londono@hcl.com.co");		
			//$mail->AddBCC($correo_dvrnet2);//copia oculta
			//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
			//$mail->AddAttachment("files/demo.zip", "demo.zip");
			$mail->Body = $cuerpo;
			$mail->AltBody = "SGPA Informaciones";
			$mail->Send();
			6
			*/
		// FIN Envio_email
	}
	//inicio Faltanto 10 dias
	
	//inicio Faltanto 5 dias Diario
	$fecha_busca = date("Y-m-d",strtotime("+5 day"));	
	$fecha_hoy = date("Y-m-d");	
	$busca_correo = query_db("select distinct (t7c.id)  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id where (t7p.fecha_fin >= '".$fecha_hoy."' and t7p.fecha_fin <= '".$fecha_busca."') and (t7p.fecha_fin COLLATE Cyrillic_General_CI_AI < t7c.vigencia_mes COLLATE Cyrillic_General_CI_AI and t7c.vigencia_mes != '')");
	
	while($sql_busca_correo=traer_fila_row($busca_correo)){
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora,t1pr.razon_social as proveedor,t7cc.tipo_complemento  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id left join ".$g6." t1pr on t7c.contratista = t1pr.t1_proveedor_id where t7c.id = '".$sql_busca_correo[0]."'");
		
		$sql_bus_complemento=traer_fila_row($busca_contrato_completo);
			
		$correo_proveedor = $sql_bus_complemento[6];//Correo proveedor
		
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sql_bus_complemento[2]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_bus_complemento[3];//consecutivo
		$numero_contrato4 = $sql_bus_complemento[4];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$consecutivo_imp = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_bus_complemento[0]);
		
		$imp_titu = "# modificacio&oacute;n";
		if($sql_bus_complemento[19]==2){
			$imp_titu = "Orden de Trabajo";
		}
		$conte_tex = "";
		$conte_tex = $conte_tex."<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>    <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     <td width='66%'>Vencimiento Polizas </td>  </tr>    <tr>    <td align='right' style='background-color:#999999'><strong>Numero Contrato</strong></td>    <td>$consecutivo_imp</td>  </tr>  <tr>    <td align='right' style='background-color:#999999'><strong>Objeto</strong></td>    <td>$sql_bus_complemento[5]</td>  </tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>Proveedor:</strong></div></td>     <td>$sql_bus_complemento[18]</td>   </tr> <tr>     <td colspan='2'><font size='+1'> El Equipo de Abastecimiento informa que las siguientes p&oacute;lizas vencer&aacute;n en los Pr&oacute;ximos 5 D&iacute;as, de acuerdo a la Cl&aacute;usula contractual les solicitamos actualizar y presentar las P&oacute;lizas en las oficinas de Hocol S.A. &Aacute;rea de Abastecimiento.</font></td>  </tr><tr> <td colspan='2'>						 <table width='100%'>    		<tr>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Poliza</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>$imp_titu</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Tipo Moneda</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Valor Asegurado</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha inicio</td>        <td width='12%' align='center' style='background-color:#CCCCCC'>Fecha Fin</td>        <td colspan='2' align='center' style='background-color:#CCCCCC'>Aseguradora</td>    </tr>";
		$busca_contrato_completo = query_db("select t7c.id,t7c.id_item,t7c.creacion_sistema,t7c.consecutivo,t7c.apellido,t7c.objeto,t7c.email1,t7c.gerente,t7c.especialista,t7p.id as id_poliza,t1p.nombre as tipo_poliza,t7p.fecha_inicio,t7p.fecha_fin,t7cc.numero_otrosi,t7p.tipo_moneda,t7p.valor,t1ta.nombre as tipo_aseguradora,t7p.aseguradora  from ".$co3." t7p  left join ".$co1." t7c on t7p.id_contrato = t7c.id left join ".$g7." t1p on t7p.tipo_poliza = t1p.id left join ".$co4." t7cc on t7p.numero_modificacion = t7cc.id left join ".$g23." t1ta on t7p.tipo_aseguradora = t1ta.id where t7c.id = '".$sql_busca_correo[0]."' and (t7p.fecha_fin >= '".$fecha_hoy."' and t7p.fecha_fin <= '".$fecha_busca."') and (t7p.fecha_fin COLLATE Cyrillic_General_CI_AI < t7c.vigencia_mes COLLATE Cyrillic_General_CI_AI and t7c.vigencia_mes != '')");
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
		
		
		
		//$correo_destino="jose.sterling@enternova.net";
		$asunto_msn="SGPA Vencimiento Polizas " ;
		$cuerpo = $conte_tex;
		//echo $asunto_msn."<br>";
		//echo $correo_destino."<br>";
		//echo $cuerpo;
		
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
			$mail->AddAddress($correo_proveedor,$nombre);
			//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
			//$mail->AddCC("ferney.sterling@enternova.net");
			$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
			$mail->AddAddress("Nataly.mahecha@achilles.com");
			$mail->AddAddress("Nathaly.mahecha@hcl.com.co");
			$mail->AddAddress("Jennifer.colmenares@hcl.com.co");
			$mail->AddAddress("Jennifer.colmenares@achilles.com");
			$mail->AddAddress("lissette.patino@hcl.com.co");		
			$mail->AddAddress("asistenteaon.bogota@hcl.com.co");
			$mail->AddAddress("pmgbaon.bogota@hcl.com.co");	
			$mail->AddAddress("viviana.londono@hcl.com.co");						
			//$mail->AddBCC($correo_dvrnet2);//copia oculta
			//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
			//$mail->AddAttachment("files/demo.zip", "demo.zip");
			$mail->Body = $cuerpo;
			$mail->AltBody = "SGPA Informaciones";
			$mail->Send();
			*/
		// FIN Envio_email
	}
	//inicio Faltanto 5 dias Diario

?>
<script>
function CloseWin(){
window.open('','_parent','');
window.close(); 
}
CloseWin()
</script>