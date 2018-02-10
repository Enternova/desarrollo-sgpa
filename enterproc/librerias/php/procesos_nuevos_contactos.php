<?  include("../lib/@session.php");

		function id_insert_sql_ser($sql)
                {
				$tra = mssql_fetch_assoc($sql);
				return $tra['SCOPE_IDENTITY'];
                }	

if($_POST["accion"]=="nuevo_add")
	{
		 $msg ="";
		$verifica_email = comprobar_email($_POST["email_contacto"]);
		
		
		if($_POST["nombre_contacto"]==""){
			$msg .= " * Digite el nombre del contacto ";
			$err_js="forma.nombre_contacto.className = 'campos_faltantes';";
			}
		if($verifica_email=="0"){
			$msg .= " * Digite el email del contacto";
			$err_js.="forma.email_contacto.className = 'campos_faltantes';";
			
			}
		if($_POST["telefono_contacto"]==""){
			$msg .= " * Digite el telefono del contacto  ";	
			$err_js.="forma.telefono_contacto.className = 'campos_faltantes';";	
			
			}
			
		if($msg==""){//si esta dodo digtado
		
		echo  $inserta_procesos="insert into pv_contactos (pv_id, contacto, email, telefono, estado)
		 values ($pv_id_b,'".$_POST["nombre_contacto"]."','".$_POST["email_contacto"]."','".$_POST["telefono_contacto"]."',1)";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();

		$crea_relacion = query_db("insert into pro33_relacion_contactos_procesos (pro1_id, pv_contactos_id, principal) values ($id_invitacion,$id_p,1 )");

		auditor(39,$id_invitacion,"Contacto: ".$_POST["nombre_contacto"].", e-mail: ".$_POST["email_contacto"]." id proveedor: $pv_id_b " , $pv_id_b);
				


		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		//alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/contactos_proceso.php?id_invitacion_pasa=<?=$id_invitacion;?>&pv_id_b=<?=$pv_id_b;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Flatan campos por digitar: <?=$err_js;?>', 20, 10, 18);
		var forma = window.parent.document.principal;
		//alert("ATENCIÓN:\nFlatan campos por digitar")
        </script>
		<?
		
		
		}
		
		} //si esta dodo digtado
		

if($_POST["accion"]=="nuevo_add_relacion")
	{
	
	echo "insert into pro33_relacion_contactos_procesos (pro1_id, pv_contactos_id, principal) 
	values ($id_invitacion,".$_POST["id_elimina"].",1 )";
	$crea_relacion = query_db("insert into pro33_relacion_contactos_procesos (pro1_id, pv_contactos_id, principal) 
	values ($id_invitacion,".$_POST["id_elimina"].",1 )");

		
	}		

if($_POST["accion"]=="elimina_add_relacion")
	{

echo "delete from pro33_relacion_contactos_procesos where pro1_id = $id_invitacion and  pv_contactos_id=$id_elimina";	
	$crea_relacion = query_db("delete from pro33_relacion_contactos_procesos where pro1_id = $id_invitacion and  pv_contactos_id=$id_elimina");

		auditor(42,$id_invitacion,$id_elimina,$id_elimina);	
		
	}		


if($_POST["accion"]=="elimina_contacto_todo")
	{

	$crea_relacion = query_db("delete from pro33_relacion_contactos_procesos where pro1_id = $id_invitacion and  pv_contactos_id=$id_elimina");
	echo $inserta_procesos="update pv_contactos set estado = 2 where pv_contactos_id = $id_elimina";
	$cambia_estado = query_db($inserta_procesos);	

		auditor(43,$id_invitacion,$id_elimina,$id_elimina);	
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El contacto se elimino con éxito', 20, 10, 18);
		//alert("El contacto se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/contactos_proceso.php?id_invitacion_pasa=<?=$id_invitacion;?>&pv_id_b=<?=$pv_id_b;?>','contenidos');
		</script>
        <?

		
	}	


/*******************************************ADJUDICACION CONTACTOS*******************************************/
/*******************************************ADJUDICACION CONTACTOS*******************************************/
if($_POST["accion"]=="nuevo_add_adjudicacion")
	{
		 $msg ="";
		$verifica_email = comprobar_email($_POST["email_contacto"]);

		
		
		if($_POST["nombre_contacto"]==""){
			$msg .= " * Digite el nombre del contacto ";
			$err_js="forma.nombre_contacto.className = 'campos_faltantes';";
			}
		if($verifica_email=="0"){
			$msg .= " * Digite el email del contacto";
			$err_js.="forma.email_contacto.className = 'campos_faltantes';";
			
			}
		if($_POST["telefono_contacto"]==""){
			$msg .= " * Digite el telefono del contacto  ";	
			$err_js.="forma.telefono_contacto.className = 'campos_faltantes';";	
			
			}
			
		if($msg==""){//si esta dodo digtado
		
		echo  $inserta_procesos="insert into pv_contactos (pv_id, contacto, email, telefono, estado)
		 values ($pv_id_b,'".$_POST["nombre_contacto"]."','".$_POST["email_contacto"]."','".$_POST["telefono_contacto"]."',1)";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();

		$crea_relacion = query_db("insert into pro33_relacion_contactos_procesos (pro1_id, pv_contactos_id, principal) values ($id_invitacion,$id_p,1 )");

		auditor(39,$id_invitacion,"Contacto: ".$_POST["nombre_contacto"].", e-mail: ".$_POST["email_contacto"]." id proveedor: $pv_id_b " , $pv_id_b);
				
		$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
		$sql_e_invitacion=traer_fila_row(query_db($busca_procesos));

			if($sql_e_invitacion[2]==16) $ruta = "adjudicacion_contactos_proceso_sm.php";
			else $ruta = "adjudicacion_contactos_proceso.php";

		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		//alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/<?=$ruta;?>?id_invitacion=<?=$id_invitacion;?>&pv_id_b=<?=$pv_id_b;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Flatan campos por digitar: <?=$err_js;?>', 20, 10, 18);
		var forma = window.parent.document.principal;
		//alert("ATENCIÓN:\nFlatan campos por digitar")
        </script>
		<?
		
		
		}
		
		} //si esta dodo digtado
		




if($_POST["accion"]=="elimina_contacto_todo_adj")
	{

	$crea_relacion = query_db("delete from pro33_relacion_contactos_procesos where pro1_id = $id_invitacion and  pv_contactos_id=$id_elimina");
	echo $inserta_procesos="update pv_contactos set estado = 2 where pv_contactos_id = $id_elimina";
	$cambia_estado = query_db($inserta_procesos);	

		auditor(43,$id_invitacion,$id_elimina,$id_elimina);	

		$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
		$sql_e_invitacion=traer_fila_row(query_db($busca_procesos));

			if($sql_e_invitacion[2]==16) $ruta = "adjudicacion_contactos_proceso_sm.php";
			else $ruta = "adjudicacion_contactos_proceso.php";
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El contacto se elimino con éxito', 20, 10, 18);
		//alert("El contacto se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/<?=$ruta;?>?id_invitacion=<?=$id_invitacion;?>&pv_id_b=<?=$pv_id_b;?>','contenidos');
		</script>
        <?

		
	}	
	

/*******************************************ADJUDICACION CONTACTOS*******************************************/
/*******************************************ADJUDICACION CONTACTOS*******************************************/
	
	

if($_POST["accion"]=="notifica_otra_vez_add")
	{


			

			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 5"));
		 	$asunto_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[1] );
			$asunto = str_replace("---consecutivo---",$sql_e[22], $asunto_arrglo );
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---fecha_apertura---',fecha_for_hora($sql_e[17]), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---fecha_cierre---', fecha_for_hora($sql_e[18]), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---objeto_contratar---', listas_sin_select($tp6,$sql_e[11],1), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---detalle_contratar---', $sql_e[12], $id_subastas_arrglo);

			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);

			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $pv_id_b and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){// proveedores
				$graba_correo_pro2="";
					$busca_contrasena="select * from t1_us_usuarios where pv_id = $lp[0]";
					$busca_si_proveedor_cambia_cot= mssql_fetch_row(mssql_query($busca_contrasena));
							

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);

					if($busca_si_proveedor_cambia_cot[12]>=1){
					$id_subastas_arrglo_usuario = str_replace('--contraseña--','Contraseña:', $id_subastas_arrglo_usuario);
					$id_subastas_arrglo_usuario = str_replace('--contra_ingreso--', '321654', $id_subastas_arrglo_usuario);										
					}
					else
					{
					$id_subastas_arrglo_usuario = str_replace('--contraseña--','', $id_subastas_arrglo_usuario);
					$id_subastas_arrglo_usuario = str_replace('--contra_ingreso--', '', $id_subastas_arrglo_usuario);										
					}

					
					
					$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
					$confirma_envio=envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);
					registro_email_enviado_nuevo($id_invitacion, $lp[4], $asunto, $mensaje_envio,$confirma_envio,1,10,$lp[0]);

					$graba_correo_pro.="<li>".$lp[4]."</li>";
					$graba_correo_pro2.=$lp[4].", ";
						
					$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_invitacion and pv_id =$lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						
						envia_correos($lp_contactos[0],$asunto,$mensaje_envio,$cabesa);
						$graba_correo_pro.="<li>".$lp_contactos[0]."</li>";
						$graba_correo_pro2.=$lp_contactos[0].", ";
						registro_email_enviado_nuevo($id_invitacion, $lp_contactos[0], $asunto, $mensaje_envio,$confirma_envio,1,10,$lp[0]);
						
						}//contactos
						
						auditor(27,$id_proceso,$lp[2]." | Se Re - envia email de ".listas_sin_select($tp1,$sql_e[1],1).", e-mail notificados: ".$graba_correo_pro2, "");
						}// provvedores

			/****envio de correo a los contactos*/

$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 8"));
		
		$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[4] );
		$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('---fecha_apertura---',fecha_for_hora($sql_e[17]), $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('---fecha_cierre---', fecha_for_hora($sql_e[18]), $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('---objeto_contratar---', listas_sin_select($tp6,$sql_e[11],1), $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('---detalle_contratar---', $sql_e[12], $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace("--provvedores--",$graba_correo_pro, $id_subastas_arrglo );	
								
	 	$asunto_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[1] );
		$asunto = str_replace("---consecutivo---",$sql_e[22], $asunto_arrglo );

		

		$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33])");
		while($destinatario = traer_fila_row($busca_dueno)){
			envia_correos($destinatario[0],$asunto,$id_subastas_arrglo,$cabesa);

			}
			
			
						?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La notificación se envio con exito', 20, 10, 18);
		//alert("La notificación se envio con exito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
	
	}

if($accion=="crea_sub_usuario"){


		$verifica_email = comprobar_email($d);
		if($verifica_email=="0"){
			?>
            	<script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el e-mail', 20, 10, 18);
					//alert("Verifique el e-mail")
				window.parent.ajax_carga('../aplicaciones/modifica_proveedor.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
					
				</script>
            <?
			exit();
			}		


$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
for($i=0;$i<=8;$i++){
$generador = rand(0,34);
$aleatorio.= $alfabeto[$generador];
}


	$cifra_c=md5($aleatorio);	


			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);

	
			
			$busca_usuario="select us_id, usuario from t1_us_usuarios where usuario = '$d'";
			$busca_existe = mssql_fetch_row(mssql_query($busca_usuario));	
			
			if($busca_existe[0]>=1){
			?>
            	<script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El e-mail (Usuario) ya existe', 20, 10, 18);
					//alert("ERROR:\n El e-mail (Usuario) ya existe ")
				window.parent.ajax_carga('../aplicaciones/modifica_proveedor.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
				</script>
            <?
			exit();
			}	
			
			else
				{// si el usuario no existe			
				
				 $busca_usuario = "select count(*) from t1_us_usuarios where pv_id = $pv_id and pv_principal = 0 ";
		 $sql_ex_prin_sqlserver = mssql_fetch_row(mssql_query($busca_usuario));
		 
		 if($sql_ex_prin_sqlserver[0]>=1) $pv_principal = 1;
		 else $pv_principal = 0;
				
						echo $inserta_us_sql_server = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ('$b', '$d', '$cifra_c', '$d', '$e',1,0,'$fecha $hora', 2, ".$pv_id." ,$pv_principal,1)";
				
			$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]";
			$sql_ex=mssql_query($inserta_us_sql_server.$trae_id_insrte);
			$id_ingreso_pro = id_insert_sql_ser($sql_ex);
			
			if($id_ingreso_pro>=1){//si se creo el proveedor

				$inserta_us = "insert into $t1 (us_id, nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
				fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
					values ($id_ingreso_pro, '$b', '$d', '$cifra_c', '$d', '$e',1,0,'$fecha $hora', 2, ".$pv_id." ,$pv_principal,1)";
					$sql_e=query_db($inserta_us);

			auditor(41,$id_invitacion,"Usuario: ".$d.", e-mail: ".$d.", id proveedor: $pv_id_b" , $pv_id_b);

			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 4"));
			
			$id_subastas_arrglo = str_replace("---proveedor---",$bp, $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $d, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $aleatorio, $id_subastas_arrglo);

		 	
		 	$asunto = $busca_correo[1];
			
			$mensaje_envio = $id_subastas_arrglo;
			echo $mensaje_envio;
			
			envia_correos($d,$asunto,$mensaje_envio,$cabesa);    			
			
	?>
            <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El usuario se creo con éxito', 20, 10, 18);
				//alert("El usuario se creo con éxito")
				window.parent.ajax_carga('../aplicaciones/modifica_proveedor.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
			</script>
            
			
			<?			
			
			}//si se creo el proveedor		
			
			else{ // si no se pudo crear
			?>
			
            <script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El usuario NO se creo \n * Verifique el E-mail', 20, 10, 18);
				//alert("El usuario NO se creo \n verifique el E-mail")
				
			</script>
			<?		
			
			}		
				
				
				} // si el usuario no existe
			

  

}


if($accion=="e_sub_usuario"){

		$verifica_email = comprobar_email($_POST["b1_".$campo_id]);
		if($verifica_email=="0"){
			?>
            	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el e-mail', 20, 10, 18);
					//alert("Verifique el e-mail")
					window.parent.ajax_carga('mi_perfil.html','contenidos');
					
				</script>
            <?
			exit();
			}	
			
			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
			
			
			$busca_usuario="select us_id, usuario from t1_us_usuarios where usuario = '".$_POST["b1_".$campo_id]."' and us_id <> ".$campo_id;
			$busca_existe = mssql_fetch_row(mssql_query($busca_usuario));	
			
			if($busca_existe[0]>=1){
			?>
            	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El e-mail (Usuario) ya existe', 20, 10, 18);
					//alert("ERROR:\n El e-mail (Usuario) ya existe ")
					window.parent.ajax_carga('../enterproc/aplicaciones/proveedores/panel_control.php','contenidos');
				</script>
            <?
			exit();
			}	
			
			else
				{// si el usuario no existe			
			

$inserta_us_sql_server = "update t1_us_usuarios set nombre_administrador='".elimina_comillas_2($_POST["a1_".$campo_id])."', usuario='".$_POST["b1_".$campo_id]."' ,email='".$_POST["b1_".$campo_id]."' , telefono  = '".elimina_comillas_2($_POST["c1_".$campo_id])."'
 where us_id = $campo_id";
	$sql_e=mssql_query($inserta_us_sql_server);


echo $inserta_us = "update $t1 set nombre_administrador='".elimina_comillas_2($_POST["a1_".$campo_id])."', usuario='".$_POST["b1_".$campo_id]."' ,email='".$_POST["b1_".$campo_id]."' , telefono  = '".elimina_comillas_2($_POST["c1_".$campo_id])."'
 where us_id = $campo_id";
	$sql_e=query_db($inserta_us);
			?>			
            <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El usuario se modifico con éxito', 20, 10, 18);
				//alert("El usuario se modifico con éxito")
			</script>
			<?
	
	} // si el usuario no existe	

}

	
?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>



