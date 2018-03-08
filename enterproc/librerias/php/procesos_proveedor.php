window.parent.document.getElementById("cargando")<?  include("../lib/@session.php");

echo $_POST["accion"];

		function id_insert_sql_ser($sql)
                {
				$tra = mssql_fetch_assoc($sql);
				return $tra['SCOPE_IDENTITY'];
                }	

if($_POST["accion"] == "modifica_proveedor")
	{
		$pv_id = elimina_comillas($pv_id);
		
		/*$verifica_email = comprobar_email($dp);
		if($verifica_email=="0"){
			?>
            	<script>
					alert("Verifique el e-mail")
					
				</script>
            <?
			exit();
			}
		*/
		if($g=="si"){
			
			$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
			for($i=0;$i<=8;$i++){
			$generador = rand(0,34);
			$nueva_c.= $alfabeto[$generador];
					}
			$nueva_contra=md5($nueva_c);		
			$complemento_sql_server=" , contrasena = '".$nueva_contra."', contra_temporal = 1 ";
			$complemento = " , contrasena = '".$nueva_contra."', contra_temporal = 1 ";
			$n_contrasena_e=$nueva_c;
			
	}
		
		if($conta_1!=""){
			$nueva_contra=md5($conta_1);
			
			$complemento_sql_server=" , contrasena = '".$nueva_contra."', contra_temporal = 1 ";
			$complemento = " , contrasena = '".$nueva_contra."', contra_temporal = 1 ";
			$n_contrasena_e=$conta_1;
			
		}
	
	
			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
		
		 $cambia_cali="update t1_proveedor set  nit='$ap', digito_verificacion = '0', razon_social='$bp', estado='$fp'  where t1_proveedor_id = $pv_id";
		 $sql_ex = mssql_query($cambia_cali);
		 
		 $busca_usuario = "select count(*) from t1_us_usuarios where pv_id = $pv_id and pv_principal = 0 ";
		 $sql_ex_prin_sqlserver = mssql_fetch_row(mssql_query($busca_usuario));
		 
		 $busca_usuario_sec = "select count(*) from t1_us_usuarios where pv_id = $pv_id and pv_principal = 1 ";
		 $sql_ex_prin_sqlserver_sec = mssql_fetch_row(mssql_query($busca_usuario_sec));
		 
 		 $busca_usuario_sec_cambio = "select us_id from t1_us_usuarios where pv_id = $pv_id and pv_principal = 1 and usuario ='$dp' ";
		 $sql_ex_prin_sqlserver_sec_cam = mssql_fetch_row(mssql_query($busca_usuario_sec_cambio));
		 
		 if($sql_ex_prin_sqlserver[0]==1){
				 $cambia_cali="update t1_us_usuarios set  nombre_administrador ='$bp', usuario ='$dp' $complemento ,email ='$dp', telefono ='$ep' , estado ='$fp'   where pv_id = $pv_id and pv_principal = 0";
				 $sql_ex = mssql_query($cambia_cali);
				 
				 echo $cambia_cali="update $t1 set  nombre_administrador ='$bp', usuario ='$dp' $complemento ,email ='$dp', telefono ='$ep' , estado ='$fp'   where pv_id = $pv_id and pv_principal = 0";
				 $sql_ex = query_db($cambia_cali);

		 }
		 elseif( ($sql_ex_prin_sqlserver[0]==0) && ($sql_ex_prin_sqlserver_sec_cam[0]!="") ){
				 $cambia_cali="update top(1) t1_us_usuarios set  nombre_administrador ='$bp', usuario ='$dp' $complemento ,email ='$dp', telefono ='$ep' , estado ='$fp' ,pv_principal = 0  where us_id = $sql_ex_prin_sqlserver_sec_cam[0] ";
				 $sql_ex = mssql_query($cambia_cali);

				 $cambia_cali="update  t1_us_usuarios set  pv_principal = 1  where pv_id = $pv_id and usuario <> '$dp'";
				 $sql_ex = mssql_query($cambia_cali);

				 $cambia_cali="update $t1 set  nombre_administrador ='$bp', usuario ='$dp' $complemento ,email ='$dp', telefono ='$ep' , estado ='$fp'  ,pv_principal = 0  where us_id = $sql_ex_prin_sqlserver_sec_cam[0]";
				 $sql_ex = query_db($cambia_cali);
				 
 				 $cambia_cali="update  $t1  set  pv_principal = 1  where pv_id = $pv_id and usuario <> '$dp'";
				 $sql_ex = query_db($cambia_cali);



		 }

		 elseif( ($sql_ex_prin_sqlserver[0]==0) && ($sql_ex_prin_sqlserver_sec_cam[0]=="") ){
				 echo $cambia_cali="insert into t1_us_usuarios (nombre_administrador, usuario, contrasena ,email ,telefono , estado , accesos_fallidos, fecha_cambio_contrasena, tipo_usuario, pv_id, 
                         pv_principal, contra_temporal, codigo_sap)
						 values ('$bp', '$dp', '".$nueva_contra."','$dp', '$ep', '$fp',0,'$fecha $hora', 2, $pv_id,0,1,'0')";
						 
						 $trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]";
							$sql_ex=mssql_query($cambia_cali.$trae_id_insrte);
							$id_ingreso_pro = id_insert_sql_ser($sql_ex);
			
				 
				 if($id_ingreso_pro>=1){
				 
 				 $cambia_cali_mys="insert into $t1 (us_id, nombre_administrador, usuario, contrasena ,email ,telefono , estado , accesos_fallidos, fecha_cambio_contrasena, tipo_usuario, pv_id, 
                         pv_principal, contra_temporal)
						 values ($id_ingreso_pro,'$bp', '$dp', '".$nueva_contra."','$dp', '$ep', '$fp',0,'$fecha $hora', 2, $pv_id,0,1)";
				 $sql_ex = query_db($cambia_cali_mys);
				 }
		 }


		
			
		 $cambia_cali="update $t8 set  cd_id=$ciuadad, nit='$ap' , razon_social='$bp', direccion='$cp' , email='$dp' ,telefono='$ep' ,estado='$fp'  where pv_id = $pv_id";
		 $sql_ex = query_db($cambia_cali);
		 


	


if($g=="si"){
			
		 	$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 3"));
			$asunto = $busca_correo[1];
			$id_subastas_arrglo = str_replace("---proveedor---",$bp, $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $dp, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $n_contrasena_e, $id_subastas_arrglo);
			$mensaje_envio = $id_subastas_arrglo."<br>";
			
			envia_correos($dp,$asunto,$mensaje_envio,"");	
		}
		
		if($conta_1!=""){
			
		 	$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 3"));
			$asunto = $busca_correo[1];
			$id_subastas_arrglo = str_replace("---proveedor---",$bp, $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $dp, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $n_contrasena_e, $id_subastas_arrglo);
			$mensaje_envio = $id_subastas_arrglo."<br>";
			
			envia_correos($dp,$asunto,$mensaje_envio,"");	
			
		}		
		
			auditor(40,0,"Nombre: ".$bp.", e-mail que registra en esta solicitud de cambio: ".$dp." id proveedor: ".$pv_id , $pv_id);		
		 
	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proveedor se modifico con éxito', 20, 10, 18);
			//alert("El proveedor se modifico con éxito")
			window.parent.ajax_carga('../aplicaciones/modifica_proveedor.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
		</script>
	<?

		
		}
		
 ?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>

