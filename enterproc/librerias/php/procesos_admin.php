<?  include("../lib/@session.php");
date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer


if($_POST["accion"] == "modifica_usuario")
	{
		$pv_id = elimina_comillas($pv_id);
		$verifica_email = comprobar_email($email);
		if($verifica_email=="0"){
			?>
            	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el e-mail', 20, 10, 18);
					//alert("Verifique el e-mail")
					
				</script>
            <?
			exit();
			}
		
		if($g=="si"){
			
			$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
			for($i=0;$i<=8;$i++){
			$generador = rand(0,34);
			$nueva_c.= $alfabeto[$generador];
					}
			$complemento = " , contrasena = md5('".$nueva_c."'), contra_temporal = 1 ";
			$n_contrasena_e=$nueva_c;
		}
		
		if($conta_1!=""){
			$complemento = " , contrasena = md5('".$conta_1."'),  contra_temporal = 1 ";
			$n_contrasena_e=$conta_1;
		}
		
			
	 
		echo  $cambia_cali="update $t1 set  nombre_administrador ='$ap',  email ='$email', telefono ='$dp' , estado ='$fp', tipo_usuario =$perfil  $complemento  where us_id = $pv_id ";
		 $sql_ex = query_db($cambia_cali);

		 
		 if($complemento!=""){
		 
		 	$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 8"));
			
			$id_subastas_arrglo = str_replace("---proveedor---",$usuario_pasa, $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $ap, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $n_contrasena_e, $id_subastas_arrglo);

		 	
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			echo $cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			echo $mensaje_envio = $id_subastas_arrglo;
			echo $email;
			envia_correos($email,$asunto,$mensaje_envio,$cabesa);

			}
		 
	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El usuario se modifico con éxito', 20, 10, 18);
			//alert("El usuario se modifico con éxito")
			window.parent.ajax_carga('../aplicaciones/modifica_usuario.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
		</script>
	<?

		
		}


if($_POST["accion"] == "crea_usuario")
	{
		
		$verifica_email = comprobar_email($email);
		if($verifica_email=="0"){
			?>
            	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el e-mail', 20, 10, 18);
					//alert("Verifique el e-mail")
					
				</script>
            <?
			exit();
			}
			
$busca_usuario = traer_fila_row(query_db("select us_id frm $t1 where usuario = '$usuario_pasa' "));
		if($busca_usuario[0]>=1){
			?>
            	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El usuario ya existe\n * Intente con otro usuario', 20, 10, 18);
					//alert("El usuario ya existe\n Intente con otro usuario")
				</script>
            <?
			exit();
			}
			
		
		if($g=="si"){
			
			$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
			for($i=0;$i<=8;$i++){
			$generador = rand(0,34);
			$nueva_c.= $alfabeto[$generador];
					}
			$complemento = "  md5('".$nueva_c."') ";
			$n_contrasena_e=$nueva_c;
		}
		
		if($conta_1!=""){
			$complemento = "  	md5('".$conta_1."') ";
			$n_contrasena_e=$conta_1;
		}
		
			
		echo  $cambia_cali="insert into $t1 (nombre_administrador, usuario, contrasena, email, telefono, 
		estado, accesos_fallidos, fecha_cambio_contrasena, tipo_usuario, pv_id, pv_principal, contra_temporal)
		values ('$ap', '$usuario_pasa', $complemento , '$email','$dp', '$fp',0,'$fecha $hora',$perfil ,0,0,1)";
		 $sql_ex = query_db($cambia_cali);
			$id_p = id_insert();
				if($id_p>=1){//si se creo
		 
		
		 
		 	$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 8"));
			
			$id_subastas_arrglo = str_replace("---proveedor---",$usuario_pasa, $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $ap, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $n_contrasena_e, $id_subastas_arrglo);

		 	
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			echo $cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			echo $mensaje_envio = $id_subastas_arrglo;
			echo $email;
			envia_correos($email,$asunto,$mensaje_envio,$cabesa);

			
		 
	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El usuario se creo con éxito', 20, 10, 18);
			//alert("El usuario se creo con éxito")
			window.parent.ajax_carga('../aplicaciones/modifica_usuario.php?pv_id=<?=$id_p;?>','contenidos');
		</script>
	<?

		} //si se creo
			else{
?>
	 	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El usuario  No se creo verifique el formulario', 20, 10, 18);
			//alert("El usuario  No se creo verifique el formulario")
		</script>
	<?			
			
			}
		
		}




	
if($_POST["accion"] == "crea_registro")
	{
		
		
			
		echo  $cambia_cali="insert into $tabla 	values (NULL,'$n_resgitro')";
		 $sql_ex = query_db($cambia_cali);
			$id_p = id_insert();
				if($id_p>=1){//si se creo
			
		 
	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
			//alert("El registro se creo con éxito")
			window.parent.ajax_carga('../aplicaciones/admin_maestras.php?tabla=<?=$tabla;?>&campo_id=<?=$campo_id;?>&titulo_maestra=<?=$titulo_maestra;?>','contenidos');
			
		</script>
	<?

		} //si se creo
			else{
?>
	 	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El registro  No se creo verifique el formulario', 20, 10, 18);
			//alert("El registro  No se creo verifique el formulario")
		</script>
	<?			
			
			}
		
		}
		

if($_POST["accion"] == "edita_registro")
	{
		
		
			
		echo  $cambia_cali="update $tabla 	set nombre ='".$_POST["n_".$id_maestra]."' where $campo_id = $id_maestra ";
		 $sql_ex = query_db($cambia_cali);
		 
	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modifico con éxito', 20, 10, 18);
			//alert("El registro se modifico con éxito")
			window.parent.ajax_carga('../aplicaciones/admin_maestras.php?tabla=<?=$tabla;?>&campo_id=<?=$campo_id;?>&titulo_maestra=<?=$titulo_maestra;?>','contenidos');
			
		</script>
	<?

		
		
		}		
		
 ?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>

