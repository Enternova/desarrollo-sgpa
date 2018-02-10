<?  include("../lib/@session.php");
date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer



if($_POST["accion"]=="crea_adjudicacion_proverdor")
	{
		 $msg ="";

		if($_POST["documento_".$pv_id]=="")
			$msg .= " * Seleccione el numero de CONTRATO. OP, OS ";
		if($_POST["fecha_entrega_".$pv_id]=="")
			$msg .= " * Digite la fecha de entrega del bien o servicio ";
		if($_POST["contacto_".$pv_id]=="0")
			$msg .= " * Seleccione el gerente del contrato  ";		
		if($_POST["pro25_id_".$pv_id]==0)
			$msg .= " * Seleccione la plantilla de lugar de entrega del bien o servicio  ";		
		if($_POST["numeroaprob_".$pv_id]=="")
			$msg .= " * Digite el numero de aprobación para la modificacion de adjudicación ";		
			
		if($msg==""){//si esta dodo digtado
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e_invitacion=traer_fila_row(query_db($busca_procesos));
		
		  $inserta_procesos="insert into $t43 (pro1_id,pv_id, fecha, us_id, documento, fecha_entrega,contacto, pro25_id, estado,acepta_terminos,us_id_aceptacion,fecha_aceptacion,ip_aceptacion,observacion_no_acepta,cargo_contable, nuemro_aprobacion)
		 values ($id_invitacion,$pv_id,'$fecha $hora',  ".$_SESSION["id_us_session"].", '".$_POST["documento_".$pv_id]."', '".$_POST["fecha_entrega_".$pv_id]."','".$_POST["contacto_".$pv_id]."',".$_POST["pro25_id_".$pv_id].",1,0,0,'','','','' , '".$_POST["numeroaprob_".$pv_id]."')";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){

	
		/* ACCION DE CARTA DE TERMINOS*/
		$cambia_estado_carta = query_db("update $t45 set acepta_terminos = 3 where pro1_id = $id_invitacion and pv_id = $pv_id");
		$busca_carta = traer_fila_row(query_db("select * from $tp12 where tp12_id = 25"));
			
			$id_subastas_arrglo = str_replace("---consecutivo_proceso---",$sql_e_invitacion[22], $busca_carta[4] );
			$id_subastas_arrglo = str_replace('---proveedor---',$_POST["nombre_provee_".$pv_id], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---objeto_contrato--',$sql_e_invitacion[12], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---documento_adju---',$_POST["documento_".$pv_id], $id_subastas_arrglo);

			$datos_gerente = "select nombre_administrador, email from us_usuarios where us_id = ".$_POST["contacto_".$pv_id];
			$sql_datos_gerente = traer_fila_row(query_db($datos_gerente));

			$datos_comprador = "select nombre_administrador, email from us_usuarios where us_id = ".$sql_e_invitacion[15];
			$sql_datos_comprador = traer_fila_row(query_db($datos_comprador));


			$id_subastas_arrglo = str_replace('---gerente_contrato---',$sql_datos_gerente[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---emial_gerente_contarto---',$sql_datos_gerente[1], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---profecional_compra---',$sql_datos_comprador[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---email_profecional_compra---',$sql_datos_comprador[1], $id_subastas_arrglo);
			
			$inserta_carta = "insert into $t45  (pro1_id, pv_id, pro27_id, carta, acepta_terminos, fecha_aceptacion, us_id, fecha_visualizacion)
			 values ($id_invitacion, $pv_id,$id_p,'$id_subastas_arrglo',1,'',0,''  )";
			 $sql_carta = query_db($inserta_carta);

		/* ACCION DE CARTA DE TERMINOS*/		


		
		auditor(33,$id_invitacion,$_POST["nombre_provee_".$pv_id], "");
		
		?>
        <script>
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso1_sm.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        //window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creó con éxito', 20, 10, 18);
		alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
        </script>
		<?
		
		
		}
		
		} //si esta dodo digtado
		
		else
			{
			
					?>
        <script>
        //window.parent.muestra_alerta_error_solo_texto('', 'Error', 'ATENCIÓN FALTAN CAMPOS POR DIGITAR: <?=$msg;?>', 20, 10, 18);
		alert("ATENCIÓN FALTAN CAMPOS POR DIGITAR:\n <?=$msg;?>")
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

		$inserta_procesos="insert into $t43 (pro1_id,pv_id, fecha, us_id, documento, fecha_entrega,contacto, pro25_id, estado,acepta_terminos,us_id_aceptacion,fecha_aceptacion,ip_aceptacion,observacion_no_acepta,cargo_contable, nuemro_aprobacion) values ($id_invitacion,$pv_id,'$fecha $hora',  ".$_SESSION["id_us_session"].", '".$_POST["documento_".$pv_id]."', '".$_POST["fecha_entrega_".$pv_id]."','".$_POST["contacto_".$pv_id]."',".$pv_id.",1,0,0,'','','','','')";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();

		?>
		<script>console.log("<?=$inserta_procesos?>")</script>
		<?
		if($id_p>=1){
		
		$busca_plantilla_relacion = traer_fila_row(query_db("select count(*) from $t44 where pro1_id=$id_invitacion and pro25_id = ".$_POST["pro25_id_".$pv_id]));
		if($busca_plantilla_relacion[0]==0){//si no tiene plantilla la adjudicacion
		$busca_email = query_db("select * from $t42 where pro25_id = ".$_POST["pro25_id_".$pv_id]);
			while($bus_ema=traer_fila_row($busca_email))
				$insre_ama=query_db("insert into $t44 (pro1_id,pro25_id, email) values ($id_invitacion, ".$_POST["pro25_id_".$pv_id].", '$bus_ema[3]')");
		} //si no tiene plantilla la adjudicacion		
		
		/* ACCION DE CARTA DE TERMINOS*/
		$cambia_estado_carta = query_db("update $t45 set acepta_terminos = 3 where pro1_id = $id_invitacion and pv_id = $pv_id");
		
		$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
		$sql_e_invitacion=traer_fila_row(query_db($busca_procesos));

		
		$busca_carta = traer_fila_row(query_db("select * from $tp12 where tp12_id = 25"));
			
			$id_subastas_arrglo = str_replace("---consecutivo_proceso---",$sql_e_invitacion[22], $busca_carta[4] );
			$id_subastas_arrglo = str_replace('---proveedor---',$_POST["nombre_provee_".$pv_id], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---objeto_contrato--',$sql_e_invitacion[12], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---documento_adju---',$_POST["documento_".$pv_id], $id_subastas_arrglo);

			$datos_gerente = "select nombre_administrador, email from us_usuarios where us_id = ".$_POST["contacto_".$pv_id];
			$sql_datos_gerente = traer_fila_row(query_db($datos_gerente));

			$datos_comprador = "select nombre_administrador, email from us_usuarios where us_id = ".$sql_e_invitacion[15];
			$sql_datos_comprador = traer_fila_row(query_db($datos_comprador));


			$id_subastas_arrglo = str_replace('---gerente_contrato---',$sql_datos_gerente[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---emial_gerente_contarto---',$sql_datos_gerente[1], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---profecional_compra---',$sql_datos_comprador[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---email_profecional_compra---',$sql_datos_comprador[1], $id_subastas_arrglo);	
					
			$inserta_carta = "insert into $t45  (pro1_id, pv_id, pro27_id, carta, acepta_terminos, fecha_aceptacion, us_id, fecha_visualizacion)
			 values ($id_invitacion, $pv_id,$id_p,'$id_subastas_arrglo',1,'',0,''  )";
			 $sql_carta = query_db($inserta_carta);

		/* ACCION DE CARTA DE TERMINOS*/		
		
		auditor(35,$id_invitacion,$_POST["nombre_provee_".$pv_id], "");
		
		
		
		?>
        <script>
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se modifico con éxito', 20, 10, 18);
		alert("El proceso se modifico con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso1_sm.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        //window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se modifico con éxito', 20, 10, 18);
		alert("ATENCIÓN:\nEl proceso NO se modifico con éxito")
        </script>
		<?
		
		
		}
		
		} //si esta dodo digtado
		
		else
			{
			
					?>
        <script>
        //window.parent.muestra_alerta_error_solo_texto('', 'Error', 'ATENCIÓN FALTAN CAMPOS POR DIGITAR: <?=$msg;?>', 20, 10, 18);
		alert("ATENCIÓN FALTAN CAMPOS POR DIGITAR:\n <?=$msg;?>")
        </script>
		<?
			
			}
	
	}     
	
	
if($_POST["accion"]=="el_adjudicacion_proverdor")
	{
	
		
		$inserta_procesos_up="update $t43 set estado = 3 where pro1_id=$id_invitacion and pv_id = ".$pv_id;
		$sql_up=query_db($inserta_procesos_up);

	
		auditor(34,$id_invitacion,$_POST["nombre_provee_".$pv_id], "");
		
		
		
		?>
        <script>
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se elimino con éxito', 20, 10, 18);
		alert("El proceso se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso1_sm.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
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
        //window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el e-mail', 20, 10, 18);
					alert("Verifique el e-mail")
					 window.parent.document.getElementById("cargando").style.display="none"
					
				</script>
            <?
			exit();
			}

		
		echo $inserta_procesos_up="insert into $t44 (pro1_id, pro25_id, email) values ($id_invitacion, $pv_id, '$email_arr')  ";
		$sql_up=query_db($inserta_procesos_up);

	
		//auditor(36,$id_invitacion,$email_arr, "");
		
		
		
		?>
        <script>
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creo con éxito', 20, 10, 18);
		alert("El proceso se creo con éxito")
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
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se eliminio con éxito', 20, 10, 18);
		alert("El proceso se eliminio con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso2.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
	
	
	}   

if($_POST["accion"]=="crea_archivo_soporte_adj_proveedor")
	{
$id_invitacion_pasa_original = $id_invitacion_pasa;
			$id_invitacion_pasa = $id_invitacion;

		echo $inserta_procesos_sopr="insert into $t37 (pro1_id,pv_id,anexo,fecha_cargue,pro27_id)
		  values ($id_invitacion_pasa, $pv_id, '$arc_soporte_name', '$fecha $hora',$pro27_id)";
		$sql_e = query_db($inserta_procesos_sopr);
		$id_fichero = id_insert();
		if($id_fichero>=1){
				//auditor(22,$id_proceso,$anexos_s_name, "");
		carga_archivo($arc_soporte,"procesos_adjudicacion_proveedor/".$id_fichero);

		
		?>
        <script>
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		alert("El proceso se creó con éxito....")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_anexos.php?id_invitacion=<?=$id_invitacion_pasa;?>&pv_id=<?=$pv_id;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        //window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creó con éxito', 20, 10, 18);
		alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
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

		?>
        <script>
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El archivo se elimino con éxito', 20, 10, 18);
		alert("El archivo se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_anexos.php?id_invitacion=<?=$id_invitacion_pasa;?>&pv_id=<?=$pv_id;?>','contenidos');
		</script>
        <?
	
	}	

if($_POST["accion"]=="canfirma_notificacion")
	{
	$error1="Los siguientes proveedores no se notificaran, para enviar la notificación debe digitar la razón de no envio a cada uno:";
	$error2="Los siguientes proveedores no tiene anexos, para enviar la notificación debe anexar el documento a cada uno:";

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


		  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado from $v13 where pro1_id =  $id_invitacion and estado = 1 and notificado IS NULL order by razon_social  ");
				while($lp = traer_fila_row($busca_provee)){//busca adjudicados
				$cuenta_anexos = traer_fila_row(query_db("select count(*) from $t37 where pro1_id =  $id_invitacion and pv_id = $lp[2] and pro27_id = $lp[0]"));
					if($cuenta_anexos[0]>=0){//si el proveedor tiene anexo				
					
						$sql_query_adj.="($id_invitacion, $lp[0], $lp[2], 1, ".$_SESSION["id_us_session"].", '$fecha $hora',1,'' ),";
						$cuenta++;
						$pv_id_adj.=",".$lp[2];//string para buscar email y notificar
						$lista_pro_adjudi.="<tr><td>".$lp[3]."</td></tr>";
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
				else{ //si NO hay errores de no adjudicados

					$largo_adj = strlen($sql_query_adj);
					$sql_query_arr_adj = substr($sql_query_adj,0, ($largo_adj-1));

					 $sql_query_arr_adj_a = "insert into $t46 (pro1_id, pro27_id, pv_id, tipo_adj_no_adj, us_id, fecha_envio, notificado, observacion_admin) values ".$sql_query_arr_adj;
				
				
				} //si NO hay errores de no adjudicados
		
	/**************************************************************************************************************
		RUTINA PARA ADJUDICADOS
	**************************************************************************************************************/


	
	$sql_ex_final_no_ad=query_db($sql_ex_no_ad);
	$sql_ex_final_si_ad=query_db($sql_query_arr_adj_a);
	
	/**************************************************************************************************************
		RUTINA PARA envio de email para proveedores
	**************************************************************************************************************/
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));

			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 10"));
		 	$asunto_2 = $busca_correo[1];
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $busca_correo[4]);


	  	$busca_provee = query_db("select $t8.pv_id, $t8.razon_social,$t8.email from $t8 where
				$t8.pv_id in (0 $pv_id_no $pv_id_adj)");
				while($lp = traer_fila_row($busca_provee)){// proveedores
				$graba_correo_pro2="";
					

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[1], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[2], $id_subastas_arrglo_usuario);				

					$confirma_envio=envia_correos($lp[2],$asunto_2,$id_subastas_arrglo_usuario,$cabesa);
					registro_email_enviado_nuevo($id_invitacion, $lp[2], $asunto_2, $id_subastas_arrglo_usuario,$confirma_envio,1,6,$lp[0]);
					

					$graba_correo_pro.="<li>".$lp[2]."</li>";
					$graba_correo_pro2.=$lp[2].", ";
						
					$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_invitacion and pv_id =$lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						
						$confirma_envio=envia_correos($lp_contactos[0],$asunto_2,$id_subastas_arrglo_usuario,$cabesa);
						registro_email_enviado_nuevo($id_invitacion, $lp_contactos[0], $asunto_2, $id_subastas_arrglo_usuario,$confirma_envio,1,6,$lp[0]);

						$graba_correo_pro.="<li>".$lp_contactos[0]."</li>";
						$graba_correo_pro2.=$lp_contactos[0].", ";
						
						}//contactos
						
						auditor(27,$id_invitacion,$lp[1]." | Se envio email de Adjudicaion - No Adjudicacion, e-mail notificados: ".$graba_correo_pro2, "");
				
				
				}// proveedores	
	
	/**************************************************************************************************************
		RUTINA PARA envio de email para proveedores
	**************************************************************************************************************/
	
	/**************************************************************************************************************
		RUTINA PARA envio de email para hocol sa
	**************************************************************************************************************/
	
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 15"));
		 	$asunto = $busca_correo[1];
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $busca_correo[4]);
			$id_subastas_arrglo = str_replace('--provvedores--', $graba_correo_pro, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---list_proveedores_adj---', $lista_pro_adjudi, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---list_proveedores_no_adj---', $lista_pro_no_adjudi, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---list_proveedores_no_adj_no_notificados---', $lista_pro_no_adjudi_no_noti, $id_subastas_arrglo);			
			
			$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],19207)");
				while($destinatario = traer_fila_row($busca_dueno)){
					
					$rr=1;
					
					$confirma_envio=envia_correos($destinatario[0],$asunto,$id_subastas_arrglo,$cabesa);
					registro_email_enviado_nuevo($id_invitacion, $destinatario[0], $asunto, $id_subastas_arrglo,$confirma_envio,1,6,0);

				
				}
				
				echo $id_subastas_arrglo;
	
	/**************************************************************************************************************
		RUTINA PARA envio de email para hocol sa
	**************************************************************************************************************/


	$cambia_estado_origen=query_db("update $t5 set tp1_id = 5 where pro1_id = $id_invitacion ");
			?>
        <script>
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La notificación se envio con éxito', 20, 10, 18);
		alert("La notificación se envio con éxito..")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_servicios.php?id_invitacion=<?=$id_invitacion;?>','contenidos');
		</script>
        <?

	
	}

if($_POST["accion"] == "nuevo_ad_foro")
	{
$id_invitacion_ar =$id_invitacion;
	
		$cambia_es = query_db("insert into $t48 (pro27_id, us_id, tipo_genera_pregunta, pregunta, fecha) values (
		$id_pro27, ".$_SESSION["id_us_session"].", 2, '$observacion_foro','$fecha $hora')");

echo "insert into $t48 (pro27_id, us_id, tipo_genera_pregunta, pregunta, fecha) values (
		$id_pro27, ".$_SESSION["id_us_session"].", 2, '$observacion_foro','$fecha $hora')";

	?>
	 	<script>
        //window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El comentario se creó con éxito', 20, 10, 18);
			alert("El comentario se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso6.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$pv_id;?>','contenidos');

		</script>
	<?
						
	

		
		}	

?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>



