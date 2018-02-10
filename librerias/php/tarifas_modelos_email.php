<?

$modelo_aporbacion_pendiente_admin_asunto="El contrato tiene tarifas pendientes para su aprobación.";
$modelo_aporbacion_pendiente_admin='
<table width="98%" border="0" cellspacing="2" cellpadding="2" style="border:solid 1px #000000">  <tr>    <td colspan="2"><img src="http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png" width="190" height="56" /></td>   </tr>  
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Proveedor:</strong></div></td>
    <td>----proveedor---</td>
  </tr>
<tr>    <td style="background-color:#999999"><div align="right"><strong>Contrato:</strong></div></td>    
  <td>----contarto--</td>   
</tr>  <tr>    <td width="34%" style="background-color:#999999"><div align="right"><strong>Asunto:</strong></div></td>     
  <td width="66%">El contrato tiene tarifas pendientes para su aprobaci&oacute;n.</td>  
</tr>  <tr>    <td style="background-color:#999999"><div align="right"><strong>URL:</strong></div></td>     <td><a href="http://www.abastecimiento.hocol.com.co/">http://www.abastecimiento.hocol.com.co</a></td>   </tr>
<tr>
  <td style="background-color:#999999"><div align="right"><strong>Usuario que aprueba y envia:</strong></div></td>
  <td>----usuario_envia---</td>
</tr>
<tr>
  <td style="background-color:#999999">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>  <td colspan="2">&nbsp;</td>  
</tr>  
  </table>
';
$modelo_rechazo_pendiente_admin_asunto="Se rechazaron tarifas de este contrato";
$modelo_rechazo_pendiente_admin='
<table width="98%" border="0" cellspacing="2" cellpadding="2" style="border:solid 1px #000000">
  <tr>
    <td colspan="2"><img src="http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png" alt="" width="190" height="56" /></td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Proveedor:</strong></div></td>
    <td>----proveedor---</td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Contrato:</strong></div></td>
    <td>----contarto--</td>
  </tr>
  <tr>
    <td width="34%" style="background-color:#999999"><div align="right"><strong>Asunto:</strong></div></td>
    <td width="66%">Se rechazaron tarifas de este contrato</td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>URL:</strong></div></td>
    <td><a href="http://www.abastecimiento.hocol.com.co/">http://www.abastecimiento.hocol.com.co</a></td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Usuario que aprueba y envia:</strong></div></td>
    <td>----usuario_envia---</td>
  </tr>
  <tr>
    <td style="background-color:#999999">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
';

$modelo_aprobacion_admin_asunto="Aprobación de tarifas, por favor verifique en el sistema las aprobaciones";
$modelo_aprobacion_pendiente_admin='
<table width="98%" border="0" cellspacing="2" cellpadding="2" style="border:solid 1px #000000">
  <tr>
    <td colspan="2"><img src="http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png" alt="" width="190" height="56" /></td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Proveedor:</strong></div></td>
    <td>----proveedor---</td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Contrato:</strong></div></td>
    <td>----contarto--</td>
  </tr>
  <tr>
    <td width="34%" style="background-color:#999999"><div align="right"><strong>Asunto:</strong></div></td>
    <td width="66%">Aprobaci&oacute;n de tarifas, por favor verifique en el sistema las aprobaciones</td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>URL:</strong></div></td>
    <td><a href="http://www.abastecimiento.hocol.com.co/">http://www.abastecimiento.hocol.com.co</a></td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Usuario que aprueba y envia:</strong></div></td>
    <td>----usuario_envia---</td>
  </tr>
  <tr>
    <td style="background-color:#999999">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
';



$email_notifica_gerente="<font font-size='10' face='arial'>Apreciado Gerente de Contrato<br>----gerente_contrato---<br><br>Las tarifas del contrato  ----contarto-- ---contratista---, cuyo objeto es: ---objeto--- fueron cargadas en la plataforma y avaladas por el Profesional de Abastecimiento que los asesoró en el proceso.<br><br><table border='1' width='80%' style='margin-left: 100px;'><tr><td colspan='2' style='color: #FFFFFF; background: #1f497d; font-family: Arial;' align='center'><strong>Datos Generales Del Contrato</strong></td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Tipo de Contrato:</strong></td><td style='font-family: Arial;'>---tipo_contrato---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Contratista:</strong></td><td style='font-family: Arial;'>---contratista---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gerente del Contrato:</strong></td><td style='font-family: Arial;'>----gerente_contrato---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Profesional / Comprador de Abastecimiento:</strong></td><td style='font-family: Arial;'>----usuario_envia---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gestor de Abastecimiento:</strong></td><td style='font-family: Arial;'>---administrador---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Inicio:</strong></td><td style='font-family: Arial;'>---fecha_inicio---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Fecha de Fin:</strong></td><td style='font-family: Arial;'>---fecha_fin---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Monto:</strong></td><td style='font-family: Arial;'>---monto---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Moneda de Pago:</strong></td><td style='font-family: Arial;'>---moneda_pago---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Informe de HSSE:</strong></td><td style='font-family: Arial;'>---hsse---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Tipo de Aseguramiento:</strong></td><td style='font-family: Arial;'>---tipo_aseguramiento---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Retención en Garantía:</strong></td><td style='font-family: Arial;'>---retencion---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Reajustes:</strong></td><td style='font-family: Arial;'>---reajustes---</td></tr><tr><td style='color: #FFFFFF; background: #1f497d; font-family: Arial;' width='50%'><strong>Gastos Reembolsables:</strong></td><td style='font-family: Arial;'>---gastos---</td></tr></table><br><br>Si desea, puede consultarlas ingresando a la plataforma y realizar su reporte exportándolo a Excel. Adicionalmente, si requiere creación de tarifas nuevas, éstas deben ser cargadas por el contratista y se pueden crear siempre y cuando:<br><br>1.    Tal creación no implique, de ninguna manera, incremento en el valor del contrato.<br>2.    La creación de la(s) tarifa(s) se requiera(n) esencialmente para cumplir con el objeto del mismo del contrato.<br>Estas creaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.<br><br>En cualquier otro caso, la inclusión de tarifas que no cumpla con las condiciones concurrentes y previamente enunciadas, tendrá validez únicamente mediante la suscripción de un otrosí debidamente suscrito por los representantes legales de Las Partes, previa justificación y acuerdo entre éstas, documento que regirá y producirá efectos a partir de su debida suscripción.<br><br>Cordial Saludo,<br><br>---administrador---<br>Gestor de Abastecimiento<br><br>----usuario_envia---<br>----area_profeciona---
</font>";

function arregla_texto_email_para_enviar($proveedor_pasa,$contrato_pasa,$usuario_envia,$modelo_carta)
	{
	
			$id_subastas_arrglo = str_replace("----proveedor---",$proveedor_pasa, $modelo_carta );
			$id_subastas_arrglo = str_replace("----contarto--", $contrato_pasa, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("----usuario_envia---",$usuario_envia, $id_subastas_arrglo);
			return $id_subastas_arrglo;
	}


function numero_cotnrato_tarifas_arreglo_fina($id_contrato_tarifas){

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
		return $contrato_ajus;
	}


function arregla_texto_email_para_enviar_gerente($proveedor_pasa,$contrato_pasa,$usuario_envia,$usuario_area,$gerente_contrato, $nombre_administrador_tarifas, $objeto, $contratista)
	{
	
			global $email_notifica_gerente,$id_contrato_arr;
			$modelo_carta = $email_notifica_gerente;
			$sel_contrato_tarifas = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id=".$id_contrato_arr));
			$sql_con2=traer_fila_row(query_db("select * from t7_contratos_contrato where id=".$sel_contrato_tarifas[0]));
			$tipo_contrato="";
			if($sql_con2[34]==1){
		 	
				if($sql_con2[57]==1){
					$tipo_contrato= "ACEPTACION DE OFERTA MERCANTIL";
				}else{
					$tipo_contrato= "CONTRATO PUNTUAL";
					}

			 }else{
				$tipo_contrato="CONTRATO MARCO";
			 }
			$gerente_contrato=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$sql_con2[9]));
			$monto_cop=valida_numero_imp($sql_con2[18]);
			$monto_usd=valida_numero_imp($sql_con2[17]);
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
			$hse=$_POST['info_hse'];
			if($hse=="NO")$hse="No Aplica";
			$id_aseguramiento=$sql_con2[53];
			$query="select nombre from t1_tipo_aseguramiento_admin where id=$id_aseguramiento";
			$aseguramiento=$gerente_antiguo=traer_fila_row(query_db($query));
			$aplica_garantia=$sql_con2[55];
			$garantia="";
			if($aplica_garantia==1){
				$garantia="Si ";
				if($sql_con2[56]==5){
					$garantia=$garantia."5% ";
				}
				if($sql_con2[56]==1){
					$garantia=$garantia."1% ";
				}
				if($sql_con2[57]==1){
					$garantia=$garantia."Parcial.";
				}
				if($sql_con2[57]==2){
					$garantia=$garantia."Al Liquidar el contrato.";
				}
			}else{
				$garantia="No Aplica";
			}
			$id_contrato_tarifas=traer_fila_row(query_db("select * from t6_tarifas_contratos where id_contrato = ".$sql_con2[0]));
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
			$sql_maestra2=traer_fila_row(query_db($busca_maestra2));
			$id_subastas_arrglo = str_replace("----proveedor---",$proveedor_pasa, $modelo_carta );
			$id_subastas_arrglo = str_replace("----contarto--",  numero_cotnrato_tarifas_arreglo_fina($id_contrato_arr)." ", $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("----usuario_envia---",$usuario_envia, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("----area_profeciona---",$usuario_area, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("----gerente_contrato---",$gerente_contrato[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---administrador---",$nombre_administrador_tarifas, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---contratista---",$contratista, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---objeto---",$objeto, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---tipo_contrato---",$tipo_contrato, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---fecha_inicio---",$sql_con2[10], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---fecha_fin---",$sql_con2[11], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---monto---","COP $".$monto_cop."<br>USD $".$monto_usd, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---hsse---",$hse, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---tipo_aseguramiento---",$aseguramiento[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---retencion---",$garantia, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---moneda_pago---",$moneda_pago, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---reajustes---",$reajustes, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace("---gastos---",$reembolsables, $id_subastas_arrglo);

			return $id_subastas_arrglo;
	}



function envia_notifica_gerente($destino_m, $asunto,$mensaje )
	{
		
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPAuth = false; 
		$mail->SMTPSecure = "";
		$mail->Port       = 25; 
		$mail->SMTPDebug = 2;
		
		$mail->Username = $correo_autentica_phpmailer; 
		$mail->Password = $contrasena_autentica_phpmailer; 
		$mail->Host = $servidor_phpmailer;
		$mail->From = $correo_from_phpmiler;
		$mail->FromName = $nombre_from_phpmiler;
		
			$ausunto_m=$asunto;
			$body_m=$mensaje;
			$destino_m=$destino_m;
		
			
			$mail->AltBody = "SGPA Informaciones";
			$mail->AddAddress($destino_m); // Esta es la dirección a donde enviamos.
			$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
			//$mail->AddAddress("sterlingrene@gmail.com"); // Esta es la dirección a donde enviamos.
		
		
			$mail->IsHTML($body_m); // El correo se envía como HTML
			$mail->Subject = $ausunto_m; // Este es el titulo del email. Vamos el asunto.
			$body = utf8_decode($message); // El utf8_decode puede no ser necesario.
			$mail->Body = $body_m; // Mensaje a enviar. Yo aquí uso la plantilla que te comentaba.
			$mail->AltBody =  $message; // Texto sin html. Yo aquí uso la plantilla que te comentaba.
			$mail->Send();

		
		}
function envia_notifica_gerente_con_copia($destino_m, $asunto,$mensaje, $copias)
	{//para la modificacion del des-031
	
	/**----------productivo -------------------------*/
	global $correo_autentica_phpmailer,$contrasena_autentica_phpmailer , $servidor_phpmailer;
    $mail = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; 
	$mail->SMTPSecure = "";
	$mail->Port       = 25; 
	$mail->Username = $correo_autentica_phpmailer; 
	$mail->Password = $contrasena_autentica_phpmailer; 
	$mail->Host = $servidor_phpmailer;
	$mail->From = "abastecimiento@hcl.com.co";
	$mail->FromName = "Bogota, Abastecimiento";
	$mail->AddBCC("sgpa-notificaciones@enternova.net","SGPA Informaciones");
	$mail->AddAddress("abastecimiento@hcl.com.co","Bogota, Abastecimiento"); 
	/**----------FIN productivo -------------------------*/
	
	
		$ausunto_m=$asunto;
		$body_m=$mensaje;
		$destino_m=$destino_m;
	
		
		$mail->AltBody = "SGPA Informaciones";
		$mail->AddAddress($destino_m); // Esta es la dirección a donde enviamos.
		$copias=explode(',', $copias);
		foreach ($copias as $v) {
		    $mail->AddAddress("".$v);//copias de email
		    $copias2=$copias2.$v.",";
		}
		$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
		//$mail->AddAddress("sterlingrene@gmail.com"); // Esta es la dirección a donde enviamos.
	
	
		$mail->IsHTML($body_m); // El correo se envía como HTML
		$mail->Subject = $ausunto_m; // Este es el titulo del email. Vamos el asunto.
		$body = utf8_decode($message); // El utf8_decode puede no ser necesario.
		$mail->Body = $body_m; // Mensaje a enviar. Yo aquí uso la plantilla que te comentaba.
		$mail->AltBody =  $message; // Texto sin html. Yo aquí uso la plantilla que te comentaba.
		$mail->Send();
		/*/return $asunto.'<br><br><br><br>'.$mensaje;
		?>
			<script>
				alert('remitente: <?=$correo_from_phpmiler?> para: <?=$destino_m?> copias a: <?=$copias2?>');
			</script>
		<?*/
	}


function registra_correos_enviados_nuevo($modulo_id, $proceso_id, $id_primario_otros_email, $id_secundario_otros_email, $email_envio, $asunto_envio, $texto_envio)
	{
		global  $fecha, $hora;	
		  $inserta_registro="insert into tseg18_registro_email_generados (tseg1_modulo_id, us_id, fecha_envio, proceso_id, id_primario_otros_email, id_secundario_otros_email, email_envio, asunto_envio, texto_envio, enviado, leido,respuesta_server)
			values ($modulo_id,".$_SESSION["id_us_session"].",'$fecha $hora',$proceso_id, $id_primario_otros_email, $id_secundario_otros_email,'$email_envio', '$asunto_envio', '$texto_envio',1,1,'S-E') ";
		$sql_in = query_db($inserta_registro);
		}	

function envia_email_generados_tarifas()
	{



		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPAuth = false; 
		$mail->SMTPSecure = "";
		$mail->Port       = 25; 
		$mail->SMTPDebug = 2;
		
		$mail->Username = $correo_autentica_phpmailer; 
		$mail->Password = $contrasena_autentica_phpmailer; 
		$mail->Host = $servidor_phpmailer;
		$mail->From = $correo_from_phpmiler;
		$mail->FromName = $nombre_from_phpmiler;
		




	$busca_procesos_sin_envio = "select   * from tseg18_registro_email_generados where enviado = 1 order by fecha_envio asc";
			$sql_busca_sin_envio = mssql_query($busca_procesos_sin_envio );	
			
			while($sql_e=mssql_fetch_row($sql_busca_sin_envio)){//while proveedores sin enviio
			$mensaje_envio ="";
			$ratifica_estado = mssql_fetch_row(mssql_query("select enviado from tseg18_registro_email_generados where tseg10_id =$sql_e[0] "));
			
				$ausunto_m="";
				$body_m="";
				$destino_m="";

			if($ratifica_estado[0]==1){//ratifica estado no enviado
			
			
		 	$asunto = $sql_e[8];
			$mensaje=$sql_e[9];
			echo $mensaje."<br>";


	$ausunto_m=$asunto;
	$body_m=$mensaje;
	$destino_m=$sql_e[7];

	//$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
	$mail->AltBody = "SGPA Informaciones";
    $mail->AddAddress($destino_m); // Esta es la dirección a donde enviamos.
    //$mail->AddAddress("sterlingrene@gmail.com"); // Esta es la dirección a donde enviamos.


    $mail->IsHTML($body_m); // El correo se envía como HTML
    $mail->Subject = $ausunto_m; // Este es el titulo del email. Vamos el asunto.
    $body = utf8_decode($message); // El utf8_decode puede no ser necesario.
    $mail->Body = $body_m; // Mensaje a enviar. Yo aquí uso la plantilla que te comentaba.
    $mail->AltBody =  $message; // Texto sin html. Yo aquí uso la plantilla que te comentaba.
    //$mail->Send();

   
    if($mail->Send()){ // Envía el correo.
			$cambia_estado_envio_prop = mssql_query("update tseg18_registro_email_generados set enviado = 2, respuesta_server='' where tseg10_id =$sql_e[0] ");
    }
	else{

			$cambia_estado_envio_prop = mssql_query("update tseg18_registro_email_generados set enviado = 3, respuesta_server='".$mail­>ErrorInfo."'  where tseg10_id =$sql_e[0] ");
	
    }
						
	
    $mail->clearAddresses();
    	
    $mail->clearAttachments();				
				
						
						
						
			} //ratifica estado no enviado
			


			}//while proveedores sin enviio

		
		
		}
		