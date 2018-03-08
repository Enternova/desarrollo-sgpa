<? session_start();
   ob_start();

$ip_conexion_entrate_us = $_SERVER['REMOTE_ADDR'];
$arreglo_serial = md5('Ing4512**--ACC');
$arreglo_serial_enviado = $_POST["serial_actv"];

$serial_del_sistema = "Serial del sistema".$arreglo_serial."<br> Serial recibido2|1	9".$arreglo_serial_enviado;
$accion_ingreso = $_POST["envento_key"];


		function id_insert_sql_ser($sql)
					{
					$tra = mssql_fetch_assoc($sql);
					return $tra['SCOPE_IDENTITY'];
					}	
   
			 $trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]";



$nit_crea = $_POST["nuevo_prove_nit"]; 
$digito_crea=$_POST["nuevo_prove_digito"]; 
$nombre_crea = $_POST["nuevo_prove_nombre"];
$email_crea = $_POST["nuevo_prove_email"]; 
$telefono_crea = $_POST["nuevo_prove_telefono"]; 
$direccion_crea = $_POST["nuevo_prove_direccion"]; 
$pais_crea = $_POST["nuevo_prove_pais"]; 
$dparta_crea = $_POST["nuevo_prove_departamento"]; 
$ciudad_crea = $_POST["nuevo_prove_ciudad"]; 
$estado_crea = $_POST["nuevo_prove_estado"]; 


$cifra_c=md5("Temporal171178**");

$nit_modifica = $_POST["modi_prove_nit"]; 
$nombre_modifica = $_POST["modi_prove_nombre"]; 
$telefono_modifica = $_POST["modi_prove_telefono"]; 
$direccion_modifica = $_POST["modi_prove_direccion"]; 
$pais_modifica = $_POST["modi_prove_pais"]; 
$depart_modifica = $_POST["modi_prove_departamento"]; 
$ciudda_modi = $_POST["modi_prove_ciudad"]; 
$estado_modifica = $_POST["modi_prove_estado"]; 




if($ip_conexion_entrate_us!= "69.64.57.8")
//if($ip_conexion_entrate_us!= "181.56.165.203")
	{
		$error_conexion = "Ingreso de IP invalido";
		//exit();
		}
else{// valida si la ip es valida
	
	   include("librerias/lib/@include.php");
	   
	   $error_conexion = "Ingreso de IP OK ";
	   

		
	if($arreglo_serial!=$arreglo_serial_enviado)
		{
			$error_serial = "Serial invalido";
			//exit();
			
			}
	
	else
		{// si el serial es invalido
		
			$error_serial = "Serial OK";
			
			if( ($accion_ingreso!="10001289") && ($accion_ingreso!="20001290")  )	
			
				{
					
					$error_eventio = "Evento key invalido";
				
				//exit();
					}		
				
		else
			{// si los eventos son correctos
			$error_eventio = "Evento key OK";
				
				if($accion_ingreso=="10001289") 
					{// creacion de proveedores
						
		$busca_existente = "select * from t1_proveedor where nit = '$nit_crea'";
		$sql_busca_e = mssql_fetch_row(mssql_query($busca_existente));
		if($sql_busca_e[0]>=1)
			{ // si el proveedor ya existe en la creacion
				
				$cambia_nombre =mssql_query("update t1_proveedor set razon_social = '$nombre_crea', creado_actualizado_desde_par='Si', estado_parservicios = '$estado_crea' where t1_proveedor_id = $sql_busca_e[0]");
			
					$link = mysql_connect("localhost","rene.sterling", "942ASvle*P");
						mysql_select_db("db_enterproc_hocol", $link);
				
				$cambia_cali="update pv_proveedores set razon_social = '$nombre_crea' where pv_id = $sql_busca_e[0]";
				 $sql_ex = mysql_query($cambia_cali);
						 
				$error_creacion = "creación modificacion de proveedor OK: NIT $nit_crea, Nombre: $nombre_crea";

				
				}// si el proveedor ya existe en la creacion
		else
			{// si el proveedor no existe en la creacion
							
		$inserta_us = "insert into t1_proveedor (nit, digito_verificacion , razon_social , estado,creado_actualizado_desde_par,estado_parservicios)	values 
		('$nit_crea', '', '$nombre_crea',1,'Si','$estado_crea')";
		

		$sql_ex=mssql_query($inserta_us.$trae_id_insrte);
		$id_ingreso_pro = id_insert_sql_ser($sql_ex);

			if($id_ingreso_pro>=1){//si se creo el proveedor
   
				 $inserta_email_sgpa=mssql_query("insert into t1_proveedor_email (t1_proveedor_id, nombre_responsable, email, tipo, estado) values ($id_ingreso_pro, 
				'PRINCIPAL','$email_crea',1,1)");						

				$inserta_us = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
				fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
					values ('$nombre_crea', '$email_crea', '$cifra_c', '$email_crea', '0',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
					$sql_ex_p=mssql_query($inserta_us.$trae_id_insrte);
				$id_ingreso_pro_us = id_insert_sql_ser($sql_ex_p);


		$link = mysql_connect("localhost","rene.sterling", "942ASvle*P");
		mysql_select_db("db_enterproc_hocol", $link);
				
	
		$cambia_cali="insert into  pv_proveedores (pv_id,cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
		 $id_ingreso_pro,678, '$nit_crea', '$nombre_crea', '$direccion_crea','$email_crea', '$telefono_crea', 1, '' )";
		 $sql_ex = mysql_query($cambia_cali);
		 
		 	  $inserta_us = "insert into us_usuarios (us_id,nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ($id_ingreso_pro_us,'$nombre_crea', '$email_crea', '$cifra_c', '$email_crea', '0',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
	$sql_e=mysql_query($inserta_us);
	
		$error_creacion = "creación de proveedor OK: NIT $nit_crea, Nombre: $nombre_crea";
	
			}//si se creo el proveedor
	
			else{// si no se crea
				
				$error_creacion = "El proveedor no se creo";
				//exit();

				
				}// si no se crea

			}// si el proveedor no existe en la creacion			
						}// creacion de proveedores
				
				
					if($accion_ingreso=="20001290") 
					{// modificacion de proveedores
				
				
				

		$busca_provee=mssql_fetch_row(mssql_query("select t1_proveedor_id, nit, razon_social from t1_proveedor where nit = '$nit_modifica'"));
		if($busca_provee[0]>=1)
			{
			
			
						$cambia_nombre =mssql_query("update t1_proveedor set razon_social = '$nombre_modifica', creado_actualizado_desde_par='Si', estado_parservicios = '$estado_modifica' where t1_proveedor_id = $busca_provee[0]");
			
						$link = mysql_connect("localhost","rene.sterling", "942ASvle*P");
						mysql_select_db("db_enterproc_hocol", $link);
				
						$cambia_cali="update pv_proveedores set razon_social = '$nombre_modifica' where pv_id = $busca_provee[0]";
						 $sql_ex = mysql_query($cambia_cali);
						 
						 $error_creacion = "El proveedor se modifico OK";
			
			}
			
			else{// si el proveedor no existe
				
					$error_creacion = "El proveedor que intenta modificar no existe";

							$inserta_us = "insert into t1_proveedor (nit, digito_verificacion , razon_social , estado,creado_actualizado_desde_par,estado_parservicios)	values 
							('$nit_modifica', '', '$nombre_modifica',1,'Si','$estado_modifica')";

						$sql_ex=mssql_query($inserta_us.$trae_id_insrte);
						$id_ingreso_pro = id_insert_sql_ser($sql_ex);
				
							if($id_ingreso_pro>=1){//si se creo el proveedor que no exite en la modificacion
										
							$inserta_us = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
							fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
								values ('$nombre_modifica', '$nit_modifica', '$cifra_c', '', '0',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
								$sql_ex_p=mssql_query($inserta_us.$trae_id_insrte);
								$id_ingreso_pro_us = id_insert_sql_ser($sql_ex_p);
	

		$link = mysql_connect("localhost","rene.sterling", "942ASvle*P");
		mysql_select_db("db_enterproc_hocol", $link);
				
	
		$cambia_cali="insert into  pv_proveedores (pv_id,cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
		 $id_ingreso_pro,678, '$nit_modifica', '$nombre_modifica', '$direccion_crea','$email_crea', '$telefono_modifica', 1, '' )";
		 $sql_ex = mysql_query($cambia_cali);
		 
		 	  $inserta_us = "insert into us_usuarios (us_id,nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ($id_ingreso_pro_us,'$nombre_modifica', '$nit_modifica', '$cifra_c', '', '0',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
	$sql_e=mysql_query($inserta_us);
	
		$error_creacion = "creación de proveedor modificado OK: NIT $nit_crea, Nombre: $nombre_crea";


							
							
							}//si se creo el proveedor que no exite en la modificacion
					

					
				}//si el proveedor no existe
				
				
				
					}// modificacion de proveedores
				
				
				
				
				}// si los eventos son correctos	
				
				
			
			
			
			
			}// si el serial es invalido
	
	
	}// valida si la ip es valida


 $insert_log = "insert into Zlog_parservicios (clave, nit, digito_nit, razon_social, email, telefono, direccion, pais, departamento, ciudad, estado_parservcios, ip, fecha_creacion, 
respuesta_ip_valida, respuesta_serial_valido, respuesta_key_valido, string_enviado, respuesta_creacion)
 values ('$accion_ingreso','$nit_crea $nit_modifica','$digito_crea','$nombre_crea $nombre_modifica','$email_crea', '$telefono_crea $telefono_crea', '$direccion_crea $direccion_modifica',
 '$pais_crea $pais_modifica', '$ciudad_crea $ciudda_modi','$dparta_crea $dparta_modifica', '$estado_crea $estado_modifica','$ip_conexion_entrate_us', '$fecha $hora', '$error_conexion', '$error_serial',
 '$error_eventio', '$error_creacion','')";

$sql_ex=mssql_query($insert_log.$trae_id_insrte);

	
echo $error_conexion."</br>";	
echo $error_serial."</br>";
echo $error_eventio."</br>";

echo $error_creacion;
	

?> 