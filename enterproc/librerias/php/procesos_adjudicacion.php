<?  include("../lib/@session.php");
include('../../../librerias/PHPMailer_v2.0.0/class.phpmailer.php'); 


function envio_correos_php_todos_enuno($asunto_msn,$correo_destino,$cuerpo,$ruta_ar,$nombre_archi){

	echo "Destino funciotn PHP: ".$correo_destino." Asunto: ".$correo_destino."<br>Cuerpo: ".$cuerpo;
$correo_autentica_phpmailer = "abastecimiento@hcl.com.co";
$contrasena_autentica_phpmailer = "Colombia02";
$servidor_phpmailer ="octans.hocol.com.co";
$correo_from_phpmiler = "abastecimiento@hcl.com.co";
$nombre_from_phpmiler = "Bogota, Abastecimiento";	
	
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
			$mail->AddBCC("sgpa-notificaciones@enternova.net","SGPA Informaciones");
			//echo $correo_destino."proveedoruno<br>";
	
		
		$mail->AddAttachment($ruta_ar, $nombre_archi);
		$mail->Body = $cuerpo;
		$mail->AltBody = "SGPA Informaciones";
		$confirma_envio = $mail->Send();	
	echo "Confirmacion de Envio".$confirma_envio;
	    $mail->clearAddresses();
   		$mail->clearAttachments();	
	return $confirma_envio."<br><br>";
	}


function valida_email_envio_correo_limpia_php($email){
	$email = str_replace(" ","", $email);
	return $email;
}

function envio_correos_php($asunto_msn,$correo_destino,$cuerpo,$ruta_ar,$nombre_archi){

	//echo "Destino funciotn PHP: ".$correo_destino." Asunto: ".$correo_destino."<br>Cuerpo: ".$cuerpo;
$correo_autentica_phpmailer = "abastecimiento@hcl.com.co";
$contrasena_autentica_phpmailer = "Colombia02";
$servidor_phpmailer ="octans.hocol.com.co";
$correo_from_phpmiler = "abastecimiento@hcl.com.co";
$nombre_from_phpmiler = "Bogota, Abastecimiento";	
	
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
		

			$mail->AddAddress(valida_email_envio_correo_limpia_php($correo_destino),$nombre);
			$mail->AddBCC("sgpa-notificaciones@enternova.net","SGPA Informaciones");
			//echo $correo_destino."proveedoruno<br>";
	
		
		$mail->AddAttachment($ruta_ar, $nombre_archi);
		$mail->Body = $cuerpo;
		$mail->AltBody = "SGPA Informaciones";
		$confirma_envio = $mail->Send();	
	echo "<br />SE ENVIA EMAIL A LOS CORREOS ELECTRONICOS: -".valida_email_envio_correo_limpia_php($destino)."-<br />".$cuerpo."<br /><br />";
	//echo "Confirmacion de Envio".$confirma_envio;
	    $mail->clearAddresses();
   		$mail->clearAttachments();	
	return $confirma_envio."<br><br>";
	}


if($_POST["accion"]=="crea_adjudicacion_proverdor")
	{
		 $msg ="";

		if($_POST["documento_".$pv_id]=="")
			$msg .= " * Digite el documento de adjudicación ";
		if($_POST["fecha_entrega_".$pv_id]=="")
			$msg .= " * Digite la fecha de entrega del bien o servicio ";
		if($_POST["contacto_".$pv_id]=="")
			$msg .= " * Digite el contacto que recibe el bien o servicio  ";		
		if($_POST["pro25_id_".$pv_id]==0)
			$msg .= " * Seleccione la plantilla de lugar de entrega del bien o servicio  ";	
		if($_POST["numeroaprob_".$pv_id]=="")
			$msg .= " * Digite el numero de aprobación para la modificacion de adjudicación ";						
			
		if($msg==""){//si esta dodo digtado
		
		 $inserta_procesos="insert into $t43 (pro1_id,pv_id, fecha, us_id, documento, fecha_entrega,contacto, pro25_id, estado,acepta_terminos,us_id_aceptacion,fecha_aceptacion,ip_aceptacion,observacion_no_acepta,cargo_contable,nuemro_aprobacion)
		 values ($id_invitacion,$pv_id,'$fecha $hora',  ".$_SESSION["id_us_session"].", '".$_POST["documento_".$pv_id]."', '".$_POST["fecha_entrega_".$pv_id]."','".$_POST["contacto_".$pv_id]."',".$_POST["pro25_id_".$pv_id].",1,0,0,'','','','".$_POST["cargo_contable_".$pv_id]."', '".$_POST["numeroaprob_".$pv_id]."')";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){


	
		/* ACCION DE CARTA DE TERMINOS*/
		$cambia_estado_carta = query_db("update $t45 set acepta_terminos = 3 where pro1_id = $id_invitacion and pv_id = $pv_id");
		$busca_carta = traer_fila_row(query_db("select * from $tp12 where tp12_id = 9"));
		$datos_bicacion = traer_fila_row(query_db("select * from $t41 where pro25_id = ".$_POST["pro25_id_".$pv_id]));
			$id_subastas_arrglo = str_replace("---pedido---",$_POST["documento_".$pv_id], $busca_carta[4] );
			$id_subastas_arrglo = str_replace('---proveedor---',$_POST["nombre_provee_".$pv_id], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---fecha_entrega---',$_POST["fecha_entrega_".$pv_id], $id_subastas_arrglo);
			
			$id_subastas_arrglo = str_replace('---cargo_contable---', $_POST["cargo_contable_".$pv_id], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contacto_entrega---', $_POST["contacto_".$pv_id], $id_subastas_arrglo);			
			

	$busca_planti = traer_fila_row(query_db("select distinct pro25_id,  sitio_entrega, direccion_entrega, direccion_destino from $v14 where pro1_id = $id_invitacion and destino_final = 2"));
	$busca_planti_entrega = traer_fila_row(query_db("select distinct pro25_id,  sitio_entrega, direccion_entrega, direccion_destino from $v14 where pro1_id = $id_invitacion and destino_final = 3"));
	$busca_planti_comprador = traer_fila_row(query_db("select distinct nombre, pro25_id from $v14 where pro1_id = $id_invitacion and destino_final = 1"));
	
	if($busca_planti_comprador[1] >= 1 )	{ //si ya selecciono la lista
		
			$id_subastas_arrglo = str_replace('---sitio_entrega---', $busca_planti_entrega[1] , $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---direccion_entrega---', $busca_planti_entrega[2], $id_subastas_arrglo);
			
			$id_subastas_arrglo = str_replace('---destino_final---',$busca_planti[1], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---profecional_compra---', $busca_planti_comprador[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---otra_informacion---',$datos_bicacion[6], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---horio_entrega---',$busca_planti_entrega[3], $id_subastas_arrglo);			
			
			
			} //si ya selecciono la lista


			
			
			$inserta_carta = "insert into $t45  (pro1_id, pv_id, pro27_id, carta, acepta_terminos, fecha_aceptacion, us_id, fecha_visualizacion)
			 values ($id_invitacion, $pv_id,$id_p,'$id_subastas_arrglo',1,'',0,''  )";
			 $sql_carta = query_db($inserta_carta);

		/* ACCION DE CARTA DE TERMINOS*/		


		
		auditor(33,$id_invitacion,$_POST["nombre_provee_".$pv_id], "");
		
		?>
        <script> 
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		//alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso1.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó con éxito', 20, 10, 18);
		//alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
        </script>
		<?
		
		
		}
		
		} //si esta dodo digtado
		
		else
			{
			
					?>
        <script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'ATENCIÓN FALTAN CAMPOS POR DIGITAR: <?=$msg;?>', 20, 10, 18);
		//alert("ATENCIÓN FALTAN CAMPOS POR DIGITAR:\n <?=$msg;?>")
        </script>
		<?
			
			}
	
	}

if($_POST["accion"]=="ed_adjudicacion_proverdor")
	{
		 $msg ="";

		if($_POST["documento_".$pv_id]=="")
			$msg .= " * Digite el documento de adjudicación ";
		if($_POST["fecha_entrega_".$pv_id]=="")
			$msg .= " * Digite la fecha de entrega del bien o servicio ";
		if($_POST["contacto_".$pv_id]=="")
			$msg .= " * Digite el contacto que recibe el bien o servicio  ";		
		if($_POST["pro25_id_".$pv_id]==0)
			$msg .= " * Seleccione la plantilla de lugar de entrega del bien o servicio  ";		
			
		if($msg==""){//si esta dodo digtado
		
		$inserta_procesos_up="update $t43 set estado = 2 where pro1_id=$id_invitacion and pv_id = $pv_id";
		$sql_up=query_db($inserta_procesos_up);

		//$inserta_procesos="insert into $t43 (pro1_id,pv_id, fecha, us_id, documento, fecha_entrega,contacto, pro25_id, estado,acepta_terminos,us_id_aceptacion,fecha_aceptacion,ip_aceptacion,observacion_no_acepta)
		 //values ($id_invitacion,$pv_id,'$fecha $hora',  ".$_SESSION["id_us_session"].", '".$_POST["documento_".$pv_id]."', '".$_POST["fecha_entrega_".$pv_id]."','".$_POST["contacto_".$pv_id]."',".$_POST["pro25_id_".$pv_id].",1,0,0,'','','')";

		$inserta_procesos="insert into $t43 (pro1_id,pv_id, fecha, us_id, documento, fecha_entrega,contacto, pro25_id, estado,acepta_terminos,us_id_aceptacion,fecha_aceptacion,ip_aceptacion,observacion_no_acepta,cargo_contable)
		 values ($id_invitacion,$pv_id,'$fecha $hora',  ".$_SESSION["id_us_session"].", '".$_POST["documento_".$pv_id]."', '".$_POST["fecha_entrega_".$pv_id]."','".$_POST["contacto_".$pv_id]."',".$_POST["pro25_id_".$pv_id].",1,0,0,'','','','".$_POST["cargo_contable_".$pv_id]."')";


		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){
		
	$busca_provee = query_db("update $t37 set pro27_id = $id_p where
				pro1_id =  $id_invitacion and pv_id = $pv_id and pro27_id >= 610 ");
		
		$busca_plantilla_relacion = traer_fila_row(query_db("select count(*) from $t44 where pro1_id=$id_invitacion and pro25_id = ".$_POST["pro25_id_".$pv_id]));
		if($busca_plantilla_relacion[0]==0){//si no tiene plantilla la adjudicacion
		$busca_email = query_db("select * from $t42 where pro25_id = ".$_POST["pro25_id_".$pv_id]);
			while($bus_ema=traer_fila_row($busca_email))
				$insre_ama=query_db("insert into $t44 (pro1_id,pro25_id, email) values ($id_invitacion, ".$_POST["pro25_id_".$pv_id].", '$bus_ema[3]')");
		} //si no tiene plantilla la adjudicacion		
		
		/* ACCION DE CARTA DE TERMINOS*/
		$cambia_estado_carta = query_db("update $t45 set acepta_terminos = 3 where pro1_id = $id_invitacion and pv_id = $pv_id");
		$busca_carta = traer_fila_row(query_db("select * from $tp12 where tp12_id = 9"));
		$datos_bicacion = traer_fila_row(query_db("select * from $t41 where pro25_id = ".$_POST["pro25_id_".$pv_id]));
			$id_subastas_arrglo = str_replace("---pedido---",$_POST["documento_".$pv_id], $busca_carta[4] );
			$id_subastas_arrglo = str_replace('---proveedor---',$_POST["nombre_provee_".$pv_id], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---fecha_entrega---',$_POST["fecha_entrega_".$pv_id], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contacto_entrega---', $_POST["contacto_".$pv_id], $id_subastas_arrglo);
			

			$id_subastas_arrglo = str_replace('---cargo_contable---', $_POST["cargo_contable_".$pv_id], $id_subastas_arrglo);
	
	$busca_planti = traer_fila_row(query_db("select distinct pro25_id,  sitio_entrega, direccion_entrega, direccion_destino from $v14 where pro1_id = $id_invitacion and destino_final = 2"));
	$busca_planti_entrega = traer_fila_row(query_db("select distinct pro25_id,  sitio_entrega, direccion_entrega , direccion_destino from $v14 where pro1_id = $id_invitacion and destino_final = 3"));
	$busca_planti_comprador = traer_fila_row(query_db("select distinct nombre, pro25_id from $v14 where pro1_id = $id_invitacion and destino_final = 1"));
	
	if($busca_planti_comprador[1] >= 1 )	{ //si ya selecciono la lista
		
			$id_subastas_arrglo = str_replace('---sitio_entrega---', $busca_planti_entrega[1] , $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---direccion_entrega---', $busca_planti_entrega[2], $id_subastas_arrglo);
			
			$id_subastas_arrglo = str_replace('---destino_final---',$busca_planti[1], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---profecional_compra---', $busca_planti_comprador[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---otra_informacion---',$datos_bicacion[6], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---horio_entrega---',$busca_planti_entrega[3], $id_subastas_arrglo);						
			
			} //si ya selecciono la lista		
			
			$inserta_carta = "insert into $t45  (pro1_id, pv_id, pro27_id, carta, acepta_terminos, fecha_aceptacion, us_id, fecha_visualizacion)
			 values ($id_invitacion, $pv_id,$id_p,'$id_subastas_arrglo',1,'',0,''  )";
			 $sql_carta = query_db($inserta_carta);

		/* ACCION DE CARTA DE TERMINOS*/		
		
		auditor(35,$id_invitacion,$_POST["nombre_provee_".$pv_id], "");
		
		
		
		?>
        <script> 
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se modifico con éxito', 20, 10, 18);
		//alert("El proceso se modifico con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso1.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se modifico con éxito', 20, 10, 18);
		//alert("ATENCIÓN:\nEl proceso NO se modifico con éxito")
        </script>
		<?
		
		
		}
		
		} //si esta dodo digtado
		
		else
			{
			
					?>
        <script> 
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'ATENCIÓN FALTAN CAMPOS POR DIGITAR: <?=$msg;?>', 20, 10, 18);
		//alert("ATENCIÓN FALTAN CAMPOS POR DIGITAR:\n <?=$msg;?>")
        </script>
		<?
			
			}
	
	}     
	
	
if($_POST["accion"]=="el_adjudicacion_proverdor")
	{
	
		
		$inserta_procesos_up="update $t43 set estado = 3 where pro1_id=$id_invitacion and pv_id = $pv_id";
		$sql_up=query_db($inserta_procesos_up);

	
		auditor(34,$id_invitacion,$_POST["nombre_provee_".$pv_id], "");
		
		
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se elimino con éxito', 20, 10, 18);
		//alert("El proceso se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso1.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
	
	
	}     	


if($_POST["accion"]=="add_email_c")
	{
	
		
		$email_arr= $_POST["nuevo_email".$pv_id];
		
		
		$verifica_email = comprobar_email($email_arr);
		if($verifica_email=="0"){
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el e-mail', 20, 10, 18);
					//alert("Verifique el e-mail")
					 window.parent.document.getElementById("cargando").style.display="none"
					
				</script>
            <?
			exit();
			}

		
		echo $inserta_procesos_up="insert into $t44 (pro1_id, pro25_id, email,grupo,nombre) values ($id_invitacion, $pv_id, '$email_arr','Nuevo Grupo','')  ";
		$sql_up=query_db($inserta_procesos_up);

	
		//auditor(36,$id_invitacion,$email_arr, "");
		
		
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creo con éxito', 20, 10, 18);
		//alert("El proceso se creo con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso2.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
	
	
	}     	

if($_POST["accion"]=="elimi_email_c")
	{
	
		
		
		
		

		$busca_email = traer_fila_row(query_db("select email from $t44 where pro28_id = $pv_id"));
		echo $inserta_procesos_up="delete from $t44 where pro28_id = $pv_id ";
		$sql_up=query_db($inserta_procesos_up);

	
		auditor(36,$id_invitacion,$busca_email[0], "");
		
		
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se eliminio con éxito', 20, 10, 18);
		//alert("El proceso se eliminio con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso2.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
	
	
	}   





if($_POST["accion"]=="elimi_email_todos")
	{
	

		foreach($selec_email as $id_estado => $id_email){
		$busca_email = traer_fila_row(query_db("select email from $t44 where pro28_id = $id_estado"));
		echo $inserta_procesos_up="delete from $t44 where pro28_id = $id_estado ";
		$sql_up=query_db($inserta_procesos_up);

	
		auditor(36,$id_invitacion,$busca_email[0], "");
		
		}
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se eliminio con éxito', 20, 10, 18);
		//alert("El proceso se eliminio con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso2.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
	
	
	}   

if($_POST["accion"]=="crea_archivo_soporte_adj_proveedor")
	{
$id_invitacion_pasa_original = $id_invitacion_pasa;
			$id_invitacion_pasa = $id_invitacion;

		 $inserta_procesos_sopr="insert into $t37 (pro1_id,pv_id,anexo,fecha_cargue,pro27_id)
		  values ($id_invitacion_pasa, $pv_id, '$arc_soporte_name', '$fecha $hora',$pro27_id)";
		$sql_e = query_db($inserta_procesos_sopr);
		$id_fichero = id_insert();
		if($id_fichero>=1){
				//auditor(22,$id_proceso,$anexos_s_name, "");
				$busca_si_tiene_noti = "select * from pro30_adjudicacion_enivio_notificacion where pro27_id = $pro27_id";
				$sql_busca= traer_fila_row(query_db($busca_si_tiene_noti));
				if($sql_busca[0]>=1){//si ya tiene envio
						$busca_provee_lp = traer_fila_row(query_db("select $t8.pv_id, $t8.razon_social,$t8.email from $t8 where
						$t8.pv_id = $pv_id"));
						$cambia_id_envio = "update pro30_adjudicacion_enivio_notificacion set pro27_id = concat(1,'-',pro27_id) where pro27_id = $pro27_id ";
						$sql_query=query_db($cambia_id_envio);
						
						$cambia_id_envio = "update pro27_cierre_proceso_pv set acepta_terminos = 0,	us_id_aceptacion= 0,	fecha_aceptacion='',	ip_aceptacion='',	observacion_no_acepta='' where pro27_id = $pro27_id ";
						$sql_query=query_db($cambia_id_envio);
						auditor(45,$id_invitacion_pasa,$busca_provee_lp[1]." Se carga nuevo documento, se genera nueva adjudicación en estado de envio nuevamente", "");
				}//si ya tiene envio
				
				carga_archivo($arc_soporte,"procesos_adjudicacion_proveedor/".$id_fichero);

				$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_pasa";
				$sql_e_invitacion=traer_fila_row(query_db($busca_procesos));
				if($sql_e_invitacion[2]==16) $ruta = "adjudicacion_anexos_sm.php";
				else $ruta = "adjudicacion_anexos.php";

		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		//alert("El proceso se creó con éxito....")
		window.parent.ajax_carga('../aplicaciones/evaluacion/<?=$ruta;?>?id_invitacion=<?=$id_invitacion_pasa;?>&pv_id=<?=$pv_id;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creó con éxito', 20, 10, 18);
		//alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
        </script>
		<?
		
		
		}
	
	}

if($_POST["accion"]=="elimina_archivo_soporte_adj_proveedor")
	{
	$id_invitacion_pasa_original = $id_invitacion_pasa;
			$id_invitacion_pasa = $id_invitacion;

	
		echo $inserta_procesos="delete from $t37 where pro24_id = $id_anexo ";
		$sql_e = query_db($inserta_procesos);
		unlink(SUE_PATH_ARCHIVOS."procesos_adjudicacion_proveedor/".$id_anexo.".txt");

				$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_pasa";
				$sql_e_invitacion=traer_fila_row(query_db($busca_procesos));
				if($sql_e_invitacion[2]==16) $ruta = "adjudicacion_anexos_sm.php";
				else $ruta = "adjudicacion_anexos.php";
		

		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El archivo se elimino con éxito', 20, 10, 18);
		//alert("El archivo se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/<?=$ruta;?>?id_invitacion=<?=$id_invitacion_pasa;?>&pv_id=<?=$pv_id;?>','contenidos');
		</script>
        <?
	
	}	

if($_POST["accion"]=="canfirma_notificacion")
	{
		
		
		
	$error1="Los siguientes proveedores no se notificaran, para enviar la notificación debe digitar la razón de no envio a cada uno:";
	$error2="Los siguientes proveedores no tiene anexos, para enviar la notificación debe anexar el documento a cada uno:";
	
	$datos_invita=traer_fila_row(query_db("select * from $t5  where pro1_id = $id_invitacion "));

	$error1a=""; // par aadjudicados
	$error2a="";// par aadjudicados
	$cuenta=0;
	$cuenta_no_adjudicados= count($pv_no_adjudicados);
	/**************************************************************************************************************
		RUTINA PARA NO ADJUDICADOS
	**************************************************************************************************************/
		
	if($cuenta_no_adjudicados>=1){// si tiene no adjudicados recoorre el string
		foreach($pv_no_adjudicados as $pv_id_no_adj)
			{ //recorre los proveedores no adjudicados
				
				if ( ($_POST["no_adjudicados_".$pv_id_no_adj]=="") && ($_POST["detalle_no_adjudicados_".$pv_id_no_adj]=="") )
					{ //si el proveedor no se notificara
						$error1a.="<br>".$_POST["nombre_provee_".$pv_id_no_adj];
					} //si el proveedor no se notificara
				elseif ( ($_POST["no_adjudicados_".$pv_id_no_adj]=="") && ($_POST["detalle_no_adjudicados_".$pv_id_no_adj]!="") ) {//si el proveedor si se notificara
				
					$sql_query_no_adj.="($id_invitacion, 0, $pv_id_no_adj, 2, ".$_SESSION["id_us_session"].", '$fecha $hora',3,'".$_POST["detalle_no_adjudicados_".$pv_id_no_adj]."' ),";
					$cuenta++;
					$pv_id_no_notifica.=",".$pv_id_no_adj;//string para buscar email y notificar
					$lista_pro_no_adjudi_no_noti.="<tr><td>".$_POST["nombre_provee_".$pv_id_no_adj]."</td><td>".$_POST["detalle_no_adjudicados_".$pv_id_no_adj]."</td></tr>";					
				} //si el proveedor no se notificara
				
				else{ //si el proveedor si se notificara
				
					$sql_query_no_adj.="($id_invitacion, 0, $pv_id_no_adj, 2, ".$_SESSION["id_us_session"].", '$fecha $hora',1,'".$_POST["detalle_no_adjudicados_".$pv_id_no_adj]."' ),";
					$cuenta++;
					$pv_id_no.=",".$pv_id_no_adj;//string para buscar email y notificar
					$lista_pro_no_adjudi.="<tr><td>".$_POST["nombre_provee_".$pv_id_no_adj]."</td><td>".$_POST["detalle_no_adjudicados_".$pv_id_no_adj]."</td></tr>";
				
				} //si el proveedor si se notificara

			} //recorre los proveedores no adjudicados
			
			if($error1a!="")
				{//si hay errores de no adjudicados
					?>
                    
                    <script>window.parent.document.getElementById("error_no_adj").innerHTML = "<?=$error1;?><?=$error1a;?>";
                     window.parent.document.getElementById("cargando").style.display="none";
                    </script>
                    
                    <?
					return;
					
				}//si hay errores de no adjudicados
			else{ //si NO hay errores de no adjudicados
				
					$largo = strlen($sql_query_no_adj);
					$sql_query_arr = substr($sql_query_no_adj,0, ($largo-1));

					$sql_ex_no_ad = "insert into $t46 (pro1_id, pro27_id, pv_id, tipo_adj_no_adj, us_id, fecha_envio, notificado, observacion_admin) values ".$sql_query_arr;
						
			
			} //si NO hay errores de no adjudicados
			
			}// si tiene no adjudicados recoorre el string

	/**************************************************************************************************************
		RUTINA PARA NO ADJUDICADOS
	**************************************************************************************************************/


	/**************************************************************************************************************
		RUTINA PARA  ADJUDICADOS
	**************************************************************************************************************/
	
//Fer: while para saber los proveedores del proceso, es con instruccion Null, por que quiere decir que no se ha enviado ningun email, no debe tener registro en la tabla pro30_adjudicacion_enivio_notificacion.
		  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado from $v13 where pro1_id =  $id_invitacion and estado = 1 and notificado IS NULL order by razon_social  ");
		
		//por que trae el email de abastecimiento de la tabala tp12_tipo_email, este esta mal, igual la variable no se usa en ningun lado.????????????????????????
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 10"));
		 				
				$proveedor_ad="";
				while($lp = traer_fila_row($busca_provee)){//busca adjudicados---- FER: como que tambien trae los no adjudicados toca verificar??????????
				$cuenta_anexos = traer_fila_row(query_db("select count(*) from $t37 where pro1_id =  $id_invitacion and pv_id = $lp[2] and pro27_id = $lp[0]"));
					if($cuenta_anexos[0]>=1){//si el proveedor tiene anexo ???? FER: Si no se cargan los anexos a la adjudicaicon no se envian los Email???????				
					$proveedor_ad.=$lp[2].",";
						//$sql_query_adj.="($id_invitacion, $lp[0], $lp[2], 1, ".$_SESSION["id_us_session"].", '$fecha $hora',1,'' ),";
						$cuenta++;
						$pv_id_adj.=",".$lp[2];//string para buscar email y notificar
						$lista_pro_adjudi.="<tr><td>".$lp[3]."</td><td>".$lp[4]."</td><td>".$lp[5]."</td><td>".$lp[6]."</td><td align='center'>".listas_sin_select($t41,$lp[7],1)."</td></tr>";
					
				 $sql_query_arr_adj_a = "insert into $t46 (pro1_id, pro27_id, pv_id, tipo_adj_no_adj, us_id, fecha_envio, notificado, observacion_admin) values ($id_invitacion, $lp[0], $lp[2], 1, ".$_SESSION["id_us_session"].", '$fecha $hora',1,'' )";
				$sql_ex_final_si_ad=query_db($sql_query_arr_adj_a);

			//NOTIFICA CARTAS HOCOL POR CADA PROVEEDOR		
				
						//FER: No entiendo para que consulta archivos, si en el email no se envian anexos???????????????????????
						$busca_cuenta_anexos = traer_fila_row(query_db("select pro24_id,anexo from $t37 where pro1_id =  $id_invitacion and pv_id = $lp[2] and pro27_id = $lp[0] order by pro24_id desc"));
						ob_start();
						$f1=fopen(SUE_PATH_ARCHIVOS."procesos_adjudicacion_proveedor/".$busca_cuenta_anexos[0].".txt","rb");
						fpassthru($f1);
						$cadena = ob_get_contents();
						ob_end_clean();
						$cd=~$cadena;
						fclose($f1);
						$f2=fopen(SUE_PATH_ARCHIVOS."procesos_adjudicacion_proveedor/".$busca_cuenta_anexos[1],"w");
						fwrite($f2,$cd);
						fclose($f2);

				// para que es exactamente, el query devuelve VACIO, sera que son las plantillas para bienes????????????????????????????????				
				$busca_planti_email = "select pro28_id , email from $v14 where pro1_id = $id_invitacion ";
				echo  "$ busca_planti_email=".$busca_planti_email."<br><br>";
				$arreglo_email_copiados=query_db($busca_planti_email);
				while($arr_li_copia_email=traer_fila_row($arreglo_email_copiados))
					$emal_copiados_hocol.=$arr_li_copia_email[1]."</br>";
				
				// no entiendo por que el While anterior y el siguiente, utilizan el mismo query y para que???????????
				$graba_correo_pro2="";
				$emal_copiados_hocol_envio="";
				$sql_plan_email = query_db($busca_planti_email);
				while($l_pan_ema=traer_fila_row($sql_plan_email)){//busca plantillas envio	
					$busca_carta_proveedor = "select * from $t45 where pro27_id = $lp[0] and pv_id = $lp[2]";
					echo "$ busca_carta_proveedor= ".$busca_carta_proveedor."<br><br>";
					$sql_texto_carta = traer_fila_row(query_db($busca_carta_proveedor));
					$rr=1;
					echo "<br><br>1. Enviado a: ".$l_pan_ema[1]." Asunto: ".$datos_invita[22];
					//if($id_invitacion != 5328){
					envia_correos($l_pan_ema[1],"Adjudicacion proceso: ".$datos_invita[22],$sql_texto_carta[4],$cabesa);
					//}
					$emal_copiados_hocol_envio.=$l_pan_ema[1].",";
				}
					
					$busca_provee_lp = traer_fila_row(query_db("select $t8.pv_id, $t8.razon_social,$t8.email from $t8 where
				$t8.pv_id = $lp[2]"));
				
						
						//Busca los contactos del proveedor.
				$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_invitacion and pv_id =$busca_provee_lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						
						$graba_correo_pro2.=$lp_contactos[0].", ";
						
						}//contactos
						
						//auditor(27,$id_proceso,$lp[2]." | Se envio email de ".listas_sin_select($tp1,$sql_e[1],1).", e-mail notificados: ".$graba_correo_pro2, "");
						

			

					//echo $sql_texto_carta[4];

					$sql_plan_email = query_db($busca_planti_email);
							while($l_pan_ema=traer_fila_row($sql_plan_email)){//busca plantillas envio	
					$busca_carta_proveedor = "select * from $t45 where pro27_id = $lp[0] and pv_id = $lp[2]";
					echo "$ busca_carta_proveedor= ".$busca_carta_proveedor."<br><br>";
					$sql_texto_carta = traer_fila_row(query_db($busca_carta_proveedor));
					$rr=1;
								echo "<br><br> 2. Envio a: ".$l_pan_ema[1];
					//if($id_invitacion != 5328){
		 $confirma_envio=envio_correos_php("Adjudicacion proceso: ".$datos_invita[22],$l_pan_ema[1]," Email proveedores notificados: ".$busca_provee_lp[2]." ".$graba_correo_pro2."<br> Email usuarios notificados ".$emal_copiados_hocol_envio."<br>".$sql_texto_carta[4],SUE_PATH_ARCHIVOS."procesos_adjudicacion_proveedor/".$busca_cuenta_anexos[1],$busca_cuenta_anexos[1]);
				//	}
		registro_email_enviado_nuevo($id_invitacion, $l_pan_ema[1], "Adjudicacion proceso: ".$datos_invita[22], " Email proveedores notificados: ".$busca_provee_lp[2]." ".$graba_correo_pro2."<br> Email usuarios notificados ".$emal_copiados_hocol_envio."<br>".$sql_texto_carta[4],$confirma_envio,1,6,0);		
				}

					
				$borra_archivo = unlink(SUE_PATH_ARCHIVOS."procesos_adjudicacion_proveedor/".$busca_cuenta_anexos[1]);				

					
					//NOTIFICA CARTAS HOCOL POR CADA PROVEEDOR
						
						echo "<br><br>-------Notifica cartas hocol por cada proveedor-------<br><br>";
					
			$id_subastas_arrglo="";
			$graba_correo_envio_contactos="";
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 10"));
		 	$asunto_2 = "Notificacion de Adjudicacion del proceso: ".$datos_invita[22];
			$id_subastas_arrglo = str_replace('---consecutivo---', $datos_invita[22], $busca_correo[4]);


				$busca_provee_lp = traer_fila_row(query_db("select $t8.pv_id, $t8.razon_social,$t8.email from $t8 where
				$t8.pv_id = $lp[2]"));
				// proveedores
					

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[3], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[6], $id_subastas_arrglo_usuario);				
					
					echo "<br><br> 3. Envio a: ".$busca_provee_lp[2];
					//if($id_invitacion != 5328){
						//Envia email al correo principal del proveedor
					$confirma_envio= envio_correos_php($asunto_2,$busca_provee_lp[2],$id_subastas_arrglo_usuario);
					//}
					registro_email_enviado_nuevo($id_invitacion, $busca_provee_lp[2], $asunto_2, $id_subastas_arrglo_usuario,$confirma_envio,1,6,$busca_provee_lp[0]);
					auditor(46,$id_invitacion,$busca_provee_lp[1]." Proveedor adjudicado ", "");

						$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_invitacion and pv_id =$busca_provee_lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						$graba_correo_envio_contactos.=$lp_contactos[0]."|";
							echo "<br><br> 4. Envio a: ".$lp_contactos[0];
							//if($id_invitacion != 5328){
								//envia Email a los contactos del proveedor
							$confirma_envio=envio_correos_php($asunto_2,$lp_contactos[0],$id_subastas_arrglo_usuario);	
							//}
							registro_email_enviado_nuevo($id_invitacion, $lp_contactos[0], $asunto_2, $id_subastas_arrglo_usuario,$confirma_envio,1,6,$busca_provee_lp[0]);
						
						}//contactos					
				
				
				// proveedores						

					
					
					
					}//si el proveedor tiene anexo				
					
					else{
						$error2a.="<br>".$lp[3];
					}
					
				} //busca adjudicados

				if($error2a!="")
				{//si hay errores de no adjudicados
					?>
                    
                    <script>window.parent.document.getElementById("error_adj").innerHTML = "<?=$error2;?><?=$error2a;?>";
                     window.parent.document.getElementById("cargando").style.display="none";
                    </script>
                    
                    <?
					return;
					
				}//si hay errores de no adjudicados
				
		
	/**************************************************************************************************************
		RUTINA PARA ADJUDICADOS
	**************************************************************************************************************/


	
	$sql_ex_final_no_ad=query_db($sql_ex_no_ad);
	
	
	
	/**************************************************************************************************************
		RUTINA PARA envio de email para hocol sa resumen de l aadjudicacion borrad tem
	
	
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 11"));
		 	$asunto = $busca_correo[1];
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $busca_correo[4]);
			$id_subastas_arrglo = str_replace('---list_proveedores_adj---', $lista_pro_adjudi, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---list_proveedores_no_adj---', $lista_pro_no_adjudi, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---list_proveedores_no_adj_no_notificados---', $lista_pro_no_adjudi_no_noti, $id_subastas_arrglo);			
			
			$busca_planti_email = "select pro28_id , email from $v14 where pro1_id = $id_invitacion ";
				$sql_plan_email = query_db($busca_planti_email);
				while($l_pan_ema=traer_fila_row($sql_plan_email)){//busca plantillas envio	
					
					$rr=1;
					echo $id_subastas_arrglo;
					//envia_correos($l_pan_ema[1],$asunto,$id_subastas_arrglo,$cabesa);
					
					
				
				}
	
	/**************************************************************************************************************
		RUTINA PARA envio de email para hocol sa
	**************************************************************************************************************/

	/**************************************************************************************************************
		RUTINA PARA envio de email para proveedores
	**************************************************************************************************************/

			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 10"));
		 	$asunto_2 = "Notificacion de NO Adjudicacion del proceso: ".$datos_invita[22];
			$id_subastas_arrglo = str_replace('---consecutivo---', $datos_invita[22], $busca_correo[4]);

$proveedor_no_ad="";

	  	$busca_provee = query_db("select $t8.pv_id, $t8.razon_social,$t8.email from $t8 where
				$t8.pv_id in (0 $pv_id_no)");
				while($lp = traer_fila_row($busca_provee)){// proveedores
					$proveedor_no_ad.=$lp[2].",";

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[1], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[2], $id_subastas_arrglo_usuario);				
					
					
					$confirma_envio=envio_correos_php($asunto_2,$lp[2],$id_subastas_arrglo_usuario);
					registro_email_enviado_nuevo($id_invitacion, $lp[2], $asunto_2, $id_subastas_arrglo_usuario,$confirma_envio,1,7,$lp[0]);
					auditor(47,$id_invitacion,$busca_provee_lp[1]." Proveedor NO adjudicado ", "");
				
				}// proveedores	
				
				
	
	/**************************************************************************************************************
		RUTINA PARA envio de email para proveedores
	**************************************************************************************************************/
		if($datos_invita[2]==16){
	/*-------------Envio de Email a los usurios Hocol--------------------*/
	$nombre_pro_ad = "";
	$nombre_pro_no_ad = "";
			
	$sel_proveedores_ad = query_db("select razon_social from pv_proveedores where pv_id in (".$proveedor_ad."0)");	
	while($sel_pro_ad = traer_fila_row($sel_proveedores_ad)){// proveedores
	$nombre_pro_ad.= $sel_pro_ad[0]."<br />";
	}
			
	$sel_proveedores_no_ad = query_db("select razon_social from pv_proveedores where pv_id in (".$proveedor_no_ad."0)");	
	while($sel_pro_ad = traer_fila_row($sel_proveedores_no_ad)){// proveedores
	$nombre_pro_no_ad.= $sel_pro_ad[0]."<br />";
	}	
		
		
		
	$cuerpo_mensaje_hocol ='<p>Buen D&iacute;a</p>
<p>A continuaci&oacute;n el resumen de adjudicaci&oacute;n del proceso de la referencia<br>
</p>
<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td bgcolor="#CCCCCC"><div align="right"><strong>Consecutivo:</strong></div></td>
      <td>'.$datos_invita[22].'</td>
    </tr>
    <tr>
      <td width="20%" bgcolor="#CCCCCC"><div align="right"><strong>Asunto:</strong></div></td>
      <td width="80%">Notificaci&oacute;n de Adjudicaci&oacute;n o No Adjudicaci&oacute;n</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><div align="right"><strong>Proveedor (es) Adjudicado(s):</strong></div></td>
      <td>'.$nombre_pro_ad.'</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC"><p><strong>Proveedor (es) NO Adjudicado</strong><strong>(s):</strong></p></td>
      <td>'.$nombre_pro_no_ad.'</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><div align="right"><strong>Mensaje:</strong></div></td>
      <td>Este correo es automatico, por favor no lo responda.</td>
    </tr>
  </tbody>
</table>';

$asunto_hocol = "ADJUDICACION O NO ADJUDICACION DEL PROCESO ".$datos_invita[22];

$busca_provee = query_db("select email from us_usuarios where us_id in ('".$datos_invita[16]."', 19207, '".$datos_invita[33]."')");//19207 es vedeliveth
				while($lp = traer_fila_row($busca_provee)){
				    $confirma_envio=envio_correos_php($asunto_hocol,$lp[0],$cuerpo_mensaje_hocol);
					registro_email_enviado_nuevo($id_invitacion, $lp[0], $asunto_hocol, $cuerpo_mensaje_hocol,$confirma_envio,1,7,$lp[0]);
					
				}
	/*-------------FIN Envio de Email a los usurios Hocol--------------------*/
		}
		
		
		
		
		
		
		
		
	$cambia_estado_origen=query_db("update $t5 set tp1_id = 5 where pro1_id = $id_invitacion ");
		
				$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
		$sql_e_invitacion=traer_fila_row(query_db($busca_procesos));

			if($sql_e_invitacion[2]==16) $ruta = "adjudicacion_paso4_sm.php";
			else $ruta = "adjudicacion_paso4.php";

		
		
			?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La notificación se envio con éxito', 20, 10, 18);
		//alert("La notificación se envio con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/<?=$ruta;?>?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?

	
	
	}

if($_POST["accion"] == "nuevo_ad_foro")
	{
$id_invitacion_ar =$id_invitacion;
	
		$cambia_es = query_db("insert into $t48 (pro27_id, us_id, tipo_genera_pregunta, pregunta, fecha) values (
		$id_pro27, ".$_SESSION["id_us_session"].", 2, '$observacion_foro','$fecha $hora')");
		$id_p_archivo = id_insert();
			
			$datos_invita=traer_fila_row(query_db("select * from $t5  where pro1_id = $id_invitacion "));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 16"));
		 	$asunto_2 = "Mensaje de foro de adjudicacion: ".$datos_invita[22];
			$id_subastas_arrglo = str_replace('---proceso---', $datos_invita[22], $busca_correo[4]);
			$id_subastas_arrglo = str_replace('---consecutivo---', $datos_invita[22], $id_subastas_arrglo);
			

				$busca_provee_lp = traer_fila_row(query_db("select $t8.pv_id, $t8.razon_social,$t8.email from $t8 where
				$t8.pv_id = $pv_id"));
				// proveedores
					 $id_subastas_arrglo = str_replace('---proveedor---', $busca_provee_lp[1], $id_subastas_arrglo);

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[1], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[2], $id_subastas_arrglo_usuario);				
					
					
					$confirma_envio= envio_correos_php($asunto_2,$busca_provee_lp[2],$id_subastas_arrglo);
					registro_email_enviado_nuevo($id_invitacion, $busca_provee_lp[2], $asunto_2, $id_subastas_arrglo,$confirma_envio,1,11,$busca_provee_lp[0]);

						$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_invitacion and pv_id =$busca_provee_lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						$graba_correo_envio_contactos.=$lp_contactos[0]."|";
							
							$confirma_envio=envio_correos_php($asunto_2,$lp_contactos[0],$id_subastas_arrglo);	
							registro_email_enviado_nuevo($id_invitacion, $lp_contactos[0], $asunto_2, $id_subastas_arrglo,$confirma_envio,1,11,$id_p_archivo."|".$busca_provee_lp[0]);
						//echo $id_subastas_arrglo_usuario;
						}//contactos					
				
				//$confirma_envio= envio_correos_php($asunto_2,"carlos.cock@hcl.com.co",$id_subastas_arrglo);
				//registro_email_enviado_nuevo($id_invitacion, "carlos.cock@hcl.com.co", $asunto_2, $id_subastas_arrglo,$confirma_envio,1,11,$id_p_archivo."|0");
				// proveedores		


	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El comentario se creó con éxito', 20, 10, 18);
			//alert("El comentario se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso6.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$pv_id;?>','contenidos');

		</script>
	<?
						
	

		
		}	


if($_POST["accion"] == "crea_conbina_plantilla")
{

		$borra_conbina = query_db("delete from $t44 where pro1_id = $id_invitacion");

		$busca_email = query_db("select * from $t42 where pro26_id = ".$_POST["sel1"]);
			while($bus_ema=traer_fila_row($busca_email))
				$insre_ama=query_db("insert into $t44 (pro1_id,pro25_id, email, grupo,nombre) values ($id_invitacion, 1, '$bus_ema[3]', '$bus_ema[4]','$bus_ema[2]')");
		
		
		$busca_email = query_db("select * from $t42 where pro25_id = ".$_POST["sel2"]);
			while($bus_ema=traer_fila_row($busca_email))
				$insre_ama=query_db("insert into $t44 (pro1_id,pro25_id, email, grupo,nombre) values ($id_invitacion, ".$_POST["sel3"].", '$bus_ema[3]', '$bus_ema[4]','$bus_ema[2]')");
			

		$busca_email = query_db("select * from $t42 where pro25_id = ".$_POST["sel3"]);
			while($bus_ema=traer_fila_row($busca_email))
				 $insre_ama=query_db("insert into $t44 (pro1_id,pro25_id, email, grupo,nombre) values ($id_invitacion, ".$_POST["sel2"].", '$bus_ema[3]', '$bus_ema[4]','$bus_ema[2]')");

		$busca_email = query_db("select * from $t42 where pro25_id = 25");
			while($bus_ema=traer_fila_row($busca_email))
				 $insre_ama=query_db("insert into $t44 (pro1_id,pro25_id, email, grupo,nombre) values ($id_invitacion, 25, '$bus_ema[3]', '$bus_ema[4]','$bus_ema[2]')");
		

	
		/* ACCION DE CARTA DE TERMINOS*/
	
	$busca_planti = traer_fila_row(query_db("select distinct pro25_id,  sitio_entrega, direccion_entrega, direccion_destino from $v14 where pro1_id = $id_invitacion and destino_final = 2"));
	$busca_planti_entrega = traer_fila_row(query_db("select distinct pro25_id,  sitio_entrega, direccion_entrega,direccion_destino from $v14 where pro1_id = $id_invitacion and destino_final = 3"));
	$busca_planti_comprador = traer_fila_row(query_db("select distinct nombre from $v14 where pro1_id = $id_invitacion and destino_final = 1"));
	
		$busca_carta = query_db("select carta,pro29_id from $t45 where pro1_id = $id_invitacion and acepta_terminos = 1");
		while($trae_c=traer_fila_row($busca_carta)){
		
			$id_subastas_arrglo = str_replace('---sitio_entrega---', $busca_planti_entrega[1] , $trae_c[0]);
			$id_subastas_arrglo = str_replace('---direccion_entrega---', $busca_planti_entrega[2], $id_subastas_arrglo);
			
			$id_subastas_arrglo = str_replace('---destino_final---',$busca_planti[1], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---profecional_compra---', $busca_planti_comprador[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---otra_informacion---',$datos_bicacion[6], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---horio_entrega---',$busca_planti_entrega[3], $id_subastas_arrglo);				
			
			 $inserta_carta = "update $t45 set carta = '$id_subastas_arrglo' where pro29_id = $trae_c[1]";
			 $sql_carta = query_db($inserta_carta);
			 }
			 
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		//alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso2.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
			 

}


if($_POST["accion"] == "crea_contacto_plantilla")
{

	$verifica_email = comprobar_email($con_email);
		if($verifica_email=="0"){
			?>
            	<script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el e-mail', 20, 10, 18);
					//alert("Verifique el e-mail")
					 window.parent.document.getElementById("cargando").style.display="none"
					
				</script>
            <?
			exit();
			}			

	$inste_con = "insert into $t42 (pro25_id, nombre, mail, grupo) values ($pro25_id , '$con_nombre', '$con_email', '$con_grupo')";
	$sql_insert = query_db($inste_con);	
		
			
			 
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		//alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_admin_plantillas_edita.php?id_invitacion=<?=$id_invitacion;?>&pro25_id=<?=$pro25_id;?>','contenidos');
		</script>
        <?
			 

}

if($_POST["accion"] == "elimina_contacto_plantilla")
{

			

	 $inste_con = "delete from $t42 where pro26_id = $id_anexo_elimina";
	$sql_insert = query_db($inste_con);	
		
			
			 
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se elimino con éxito', 20, 10, 18);
		//alert("El proceso se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_admin_plantillas_edita.php?id_invitacion=<?=$id_invitacion;?>&pro25_id=<?=$pro25_id;?>','contenidos');
		</script>
        <?
			 

}


if($_POST["accion"] == "modifica_datos_plantilla")
{

			

	 $inste_con = "update $t41 set nombre_plantilla='$dato1',sitio_entrega='$dato2', direccion_entrega='$dato3', direccion_destino='$dato4'  where pro25_id = $pro25_id";
	$sql_insert = query_db($inste_con);	
		
			
			 
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se modifico con éxito', 20, 10, 18);
		//alert("El proceso se modifico con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_admin_plantillas_edita.php?id_invitacion=<?=$id_invitacion;?>&pro25_id=<?=$pro25_id;?>','contenidos');
		</script>
        <?
			 

}


if($_POST["accion"] == "crea_datos_plantilla")
{

			

	 $inste_con = "insert into $t41 (nombre_plantilla, sitio_entrega, direccion_entrega, destino_final, direccion_destino ,otros_datos) values ('$dato1','$dato2', '$dato3', $dato0, '$dato4', 'N/A')";
	$sql_insert = query_db($inste_con);	
	$id_p = id_insert();
		if($id_p>=1){	
			
			 
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creo con éxito', 20, 10, 18);
		//alert("El proceso se creo con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_admin_plantillas_edita.php?id_invitacion=<?=$id_invitacion;?>&pro25_id=<?=$id_p;?>','contenidos');
		</script>
        <?
			}
			else
				{ ?>
				
				        <script> 
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creo', 20, 10, 18);
		//alert("ATENCION: \N El proceso NO se creo")
		</script>

					
				<? } 

}

if($_POST["accion"] == "elimina_plantilla_total")
{

			

	 $inste_con = "delete from  $t41 where pro25_id = $id_anexo_elimina";
	$sql_insert = query_db($inste_con);	
		
	 $inste_con = "delete from  $t42 where pro25_id = $id_anexo_elimina";
	$sql_insert = query_db($inste_con);	
			
			 
		?>
        <script> 
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se elimino con éxito', 20, 10, 18);
		//alert("El proceso se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_admin_plantillas.php?id_invitacion=<?=$id_invitacion;?>&pro25_id=<?=$pro25_id;?>','contenidos');
		</script>
        <?
			 

}


if($_POST["accion"] == "cierra_adjudica_reporte")
{

	 $estado_adjudi = $_POST["estado_ad_".$pro1_id_pasa];
	$aobservaciones = $_POST["observacion_ad_".$pro1_id_pasa];
	
	if($estado_adjudi==0)
		{ ?>
			<script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione un estado de cierre', 20, 10, 18);
				//alert("Seleccione un estado de cierre");
            	window.parent.document.getElementById("cargando").style.display="none"
             </script>
			<? exit();
			 }
	
	elseif($aobservaciones=='')
		{ ?>
			<script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Digite la observacion', 20, 10, 18);
				//alert("Digite la observacion");
            	window.parent.document.getElementById("cargando").style.display="none"
             </script>
			<?  exit();
			 }
	else
		{
			 $update_adjudicacion = "update pro27_cierre_proceso_pv set acepta_terminos=$estado_adjudi,  us_id_aceptacion = ".$_SESSION["id_us_session"].", fecha_aceptacion='$fecha',ip_aceptacion = '".$_SERVER['REMOTE_ADDR']."', observacion_no_acepta = '$aobservaciones' where pro27_id = $pro1_id_pasa ";
			$sql_ex = query_db($update_adjudicacion);
			?>
            
            <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modifico con exito', 20, 10, 18);
				//alert("El registro se modifico con exito")
				window.parent.document.getElementById('lista_resultado_<?=$pro1_id_pasa;?>').style.display = 'none';
				window.parent.document.getElementById('lista_resultado2_<?=$pro1_id_pasa;?>').style.display = 'none';
			</script>
			<?
			
			}
	
}


if($_POST["accion"] == "nuevo_ad_foro_reporte")
	{
$id_invitacion_ar =$id_invitacion;

	 $estado_adjudi = $_POST["estado_ad_".$pro32id_pasa];
	$aobservaciones = $_POST["observacion_ad_".$pro32id_pasa];


if($estado_adjudi==0)
		{ ?>
			<script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione un estado de cierre', 20, 10, 18);
				//alert("Seleccione un estado de cierre");
            	window.parent.document.getElementById("cargando").style.display="none"
             </script>
			<? exit();
			 }
	
	elseif($aobservaciones=='')
		{ ?>
			<script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Digite la observacion', 20, 10, 18);
				//alert("Digite la observacion");
            	window.parent.document.getElementById("cargando").style.display="none"
             </script>
			<?  exit();
			 }
	else
		{// si no tiene erroe

	
		 $cambia_es = query_db("insert into $t48 (pro27_id, us_id, tipo_genera_pregunta, pregunta, fecha) values (
		$pro1_id_pasa, ".$_SESSION["id_us_session"].", 2, '$aobservaciones','$fecha $hora')");
		$id_p_archivo = id_insert();
		
		if($id_p_archivo>=1){//si el registro se creo
		$update_cambia_estado = "update $t48 set marca_respuesta = 1 where pro27_id = $pro1_id_pasa";
		$sql_update = query_db($update_cambia_estado);
			
			if($estado_adjudi == 1){ //si requiere envio de email
			$datos_invita=traer_fila_row(query_db("select * from $t5  where pro1_id = $id_invitacion "));
			$busca_proveedor = traer_fila_row(query_db("select pv_id from pro27_cierre_proceso_pv where pro27_id = $pro1_id_pasa"));
			$pv_id = $busca_proveedor[0];
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 16"));
		 	$asunto_2 = "Mensaje de foro de adjudicacion: ".$datos_invita[22];
			$id_subastas_arrglo = str_replace('---proceso---', $datos_invita[22], $busca_correo[4]);
			$id_subastas_arrglo = str_replace('---consecutivo---', $datos_invita[22], $id_subastas_arrglo);
			

				$busca_provee_lp = traer_fila_row(query_db("select $t8.pv_id, $t8.razon_social,$t8.email from $t8 where
				$t8.pv_id = $pv_id"));
				// proveedores
					 $id_subastas_arrglo = str_replace('---proveedor---', $busca_provee_lp[1], $id_subastas_arrglo);

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[1], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[2], $id_subastas_arrglo_usuario);				
					
					
					$confirma_envio= envio_correos_php($asunto_2,$busca_provee_lp[2],$id_subastas_arrglo);
					registro_email_enviado_nuevo($id_invitacion, $busca_provee_lp[2], $asunto_2, $id_subastas_arrglo,$confirma_envio,1,11,$busca_provee_lp[0]);

						$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_invitacion and pv_id =$busca_provee_lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						$graba_correo_envio_contactos.=$lp_contactos[0]."|";
							
							$confirma_envio=envio_correos_php($asunto_2,$lp_contactos[0],$id_subastas_arrglo);	
							registro_email_enviado_nuevo($id_invitacion, $lp_contactos[0], $asunto_2, $id_subastas_arrglo,$confirma_envio,1,11,$id_p_archivo."|".$busca_provee_lp[0]);
						echo $id_subastas_arrglo_usuario;
						}//contactos					
				
				// $confirma_envio= envio_correos_php($asunto_2,"carlos.cock@hcl.com.co",$id_subastas_arrglo);
				//registro_email_enviado_nuevo($id_invitacion, "carlos.cock@hcl.com.co", $asunto_2, $id_subastas_arrglo,$confirma_envio,1,11,$id_p_archivo."|0");
				// proveedores		
			}//si requiere envio de email
		}//si el registro se creo

	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El comentario se creó con éxito', 20, 10, 18);
			//alert("El comentario se creó con éxito")
	window.parent.document.getElementById('lista_resultado_<?=$pro32id_pasa;?>').style.display = 'none';
				window.parent.document.getElementById('lista_resultado2_<?=$pro32id_pasa;?>').style.display = 'none';
		</script>
	<?
						
		} // si no tiene erroe

		
	}	

?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>


