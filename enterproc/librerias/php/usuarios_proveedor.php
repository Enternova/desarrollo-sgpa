<?  include("../lib/@session.php");
date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer

    verifica_menu("proveedores.html");

		function id_insert_sql_ser($sql)
                {
				$tra = mssql_fetch_assoc($sql);
				return $tra['SCOPE_IDENTITY'];
                }				



if($accion=="cambia_contrasena_1")
	{
	
		$cifra_contrasena = md5($conta_1);

		if($conta_1!=""){
					
			$complemento_sql_server=" , contrasena = '".$cifra_contrasena."' ";
			$complemento = " , contrasena = '".$cifra_contrasena."' ";

			
		}
		
		$verifica_email = comprobar_email($usuario_pro);
		if($verifica_email=="0"){
			?>
            	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Verifique el e-mail', 20, 10, 18);
					//alert("Verifique el e-mail")
					window.parent.ajax_carga('../enterproc/aplicaciones/proveedores/panel_control.php','contenidos');
					
				</script>
            <?
			exit();
			}		
		
			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
			
			$busca_usuario="select us_id, usuario from t1_us_usuarios where us_id <> ".$_SESSION["id_us_session"]." and usuario = '$usuario_pro'";
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
				{
				
					$cambia_sql_server_usuario = "update t1_us_usuarios set usuario = '$usuario_pro' $complemento_sql_server , email = '$usuario_pro', telefono = '".elimina_comillas_2($telefono_pro)."' where us_id = ".$_SESSION["id_us_session"];
					$cambia_sqlserever=mssql_query($cambia_sql_server_usuario);
					
					$cambia_usuarui_mysql = query_db("update $t1 set usuario = '$usuario_pro' $complemento_sql_server , email = '$usuario_pro', telefono = '".elimina_comillas_2($telefono_pro)."' where us_id = ".$_SESSION["id_us_session"]);			
					
					$cambia_proveedor_mysql = query_db("update $t8 set email = '$usuario_pro', telefono='".elimina_comillas_2($telefono_pro)."', celular = '".elimina_comillas_2($movil_pro)."' where pv_id = ".$_SESSION["id_proveedor"]);					
				
				}		
		
		
		?>
            <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La información se modificó con éxito', 20, 10, 18);
		//alert("La información se modificó con éxito")
		window.parent.ajax_carga('../enterproc/aplicaciones/proveedores/panel_control.php','contenidos');
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
					window.parent.ajax_carga('../enterproc/aplicaciones/proveedores/panel_control.php','contenidos');
					
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
					window.parent.ajax_carga('../enterproc/aplicaciones/proveedores/panel_control.php','contenidos');
				</script>
            <?
			exit();
			}	
			
			else
				{// si el usuario no existe			
				
						$inserta_us_sql_server = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ('$b', '$d', '$cifra_c', '$d', '$e',1,0,'$fecha $hora', 2, ".$_SESSION["id_proveedor"]." ,1,1)";
				
			$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]";
			$sql_ex=mssql_query($inserta_us_sql_server.$trae_id_insrte);
			$id_ingreso_pro = id_insert_sql_ser($sql_ex);
			
			if($id_ingreso_pro>=1){//si se creo el proveedor

				$inserta_us = "insert into $t1 (us_id, nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
				fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
					values ($id_ingreso_pro, '$b', '$d', '$cifra_c', '$d', '$e',1,0,'$fecha $hora', 2, ".$_SESSION["id_proveedor"]." ,1,1)";
					$sql_e=query_db($inserta_us);


			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 4"));
			
			$id_subastas_arrglo = str_replace("---proveedor---",$_SESSION["us_nombre_session"], $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $d, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $aleatorio, $id_subastas_arrglo);

		 	
		 	$asunto = $busca_correo[1];
			
			$mensaje_envio = $id_subastas_arrglo;
			
			envia_correos($d,$asunto,$mensaje_envio,$cabesa);    			
			
	?>
            <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El usuario se creo con éxito', 20, 10, 18);
				//alert("El usuario se creo con éxito")
				window.parent.ajax_carga('../enterproc/aplicaciones/proveedores/panel_control.php','contenidos');
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
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El usuario se modificó con éxito', 20, 10, 18);
				//alert("El usuario se modificó con éxito")
			</script>
			<?
	
	} // si el usuario no existe	

}


if($accion=="cambia_con_subusuario"){



$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
for($i=0;$i<=8;$i++){
$generador = rand(0,34);
$aleatorio.= $alfabeto[$generador];
}


	$cifra_c=md5($aleatorio);
	
			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
	
	
	$inserta_us_sql_ser = "update t1_us_usuarios set contrasena='$cifra_c', contra_temporal='1'  where us_id = $campo_id";
	$sql_e=mssql_query($inserta_us_sql_ser);
	
	
	$inserta_us = "update $t1 set contrasena='$cifra_c', contra_temporal='1'  where us_id = $campo_id";
	$sql_e=query_db($inserta_us);
	
	
			$busca_usuario = traer_fila_row(query_db("select usuario from $t1 where us_id = $campo_id"));		
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 1"));
			
			$id_subastas_arrglo = str_replace("---proveedor---",$_SESSION["us_nombre_session"], $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $busca_usuario[0], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $aleatorio, $id_subastas_arrglo);

		 	
		 	$asunto = $busca_correo[1];
			
			$mensaje_envio = $id_subastas_arrglo;
			
			envia_correos($busca_usuario[0],$asunto,$mensaje_envio,$cabesa);   

				
			?>			
            <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'la contraseña se genero con éxito y se envio al e-mail registrado', 20, 10, 18);
				//alert("la contraseña se genero con éxito y se envio al e-mail registrado")
			</script>
			<?
}

if($accion=="elimina_usuario"){


$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);	

$inserta_us_seql_serv = "update t1_us_usuarios set usuario='EL_".$fecha." ".$hora."', contrasena='ELIMINADO', contra_temporal='1', estado  = 2  where us_id = $campo_id";
	$sql_e=mssql_query($inserta_us_seql_serv);


$inserta_us = "update $t1 set usuario='EL_".$fecha." ".$hora."',  contrasena='ELIMINADO', contra_temporal='1', estado  = 2  where us_id = $campo_id";
	$sql_e=query_db($inserta_us);
			?>			
            <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El usuario se eliminó con éxito', 20, 10, 18);
				//alert("El usuari se eliminó con éxito")
				window.parent.ajax_carga('../enterproc/aplicaciones/proveedores/panel_control.php','contenidos');
				
			</script>
			<?
}



 ?>


<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>
