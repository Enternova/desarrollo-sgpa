<?  include("../lib/@session.php");
date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer

    verifica_menu("procesos.html");

		function id_insert_sql_ser($sql)
                {
				$tra = mssql_fetch_assoc($sql);
				return $tra['SCOPE_IDENTITY'];
                }				

function registro_email_enviado($pro1_id, $email, $asunto_envio, $texto_envio,$enviado,$tipo_envio,$tp17_id){
global $fecha,$hora;

echo $inserta_data = "insert into pro34_registro_correos (us_id, fecha_envio, pro1_id, id_primario_otros_email, id_secundario_otros_email,
 email_envio, asunto_envio, texto_envio, enviado,tipo_envio,tp17_id) values (
".$_SESSION["id_us_session"].",'$fecha $hora', $pro1_id, ".$_SESSION["id_proveedor"].",0,'$email','$asunto_envio','$texto_envio',1,2,12) ";

$in_mail = query_db($inserta_data);


}


//documento del proveedor
if($_POST["accion"] == "anexo_invitacion_proveedor")
	{
$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
	
		$cambia_cali=query_db("insert into $t60 (in_id,pv_id, inv1_nombre,inv1_tamano, inv1_type,in1_fecha,in3_termino) 
		values ($id_invitacion_ar,".$_SESSION["id_proveedor"].",'$sube_archivo_name','$sube_archivo_size','$sube_archivo_type','$fecha $hora','$termino_arc')");
		$id_cargue=id_insert();
		if($id_cargue>=1){// si ingreso el resgitro

		carga_archivo($sube_archivo,"procesos_proveedores/".$id_cargue);
	   $archiv_con = confirma_archivo($sube_archivo_size,"procesos_proveedores/".$id_cargue.".txt");
		
if($archiv_con == 1){// confirma subida de archivos fisicos

	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El anexo se creó con éxito tec jur', 20, 10, 18);
			//alert("El anexo se creó con éxito tec jur")
			window.parent.ajax_carga('detalle_invitacion_<?=$id_invitacion;?>.php','contenidos');

		</script>
	<?
						}// confirma subida de archivos fisicos
						
	else
	{
	?>
	 	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El anexo NO se creó con éxito', 20, 10, 18);
			//alert("El anexo NO se creó con éxito")
		</script>
	<?
	
	
	
	}
	
	}// confirma graba resgitro
		
		}
// fin documentos proveedor

if($_POST["accion"] == "anexo_elimina_proveedor")
	{
		
		
		$cambia_cali=query_db("delete from $t60 where in1_id = $id_anexo");
		elimina_archivo("procesos_proveedores/".$id_anexo.".txt")


	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El anexo se elimino con éxito', 20, 10, 18);
			//alert("El anexo se elimino con éxito")
			window.parent.ajax_carga('detalle_invitacion_<?=$id_invitacion;?>.php','contenidos');

		</script>
	<?
						
		
		}
		

if($_POST["accion"] == "confirma_participa")
	{
$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
	
		$cambia_es = query_db("update $t9 set estado = 0 where pro1_id = $id_invitacion_ar and pv_id = ".$_SESSION["id_proveedor"]);
		$cambia_cali=query_db("insert into $t9 (pro1_id,pv_id, confirmacion,fecha, justificacion, estado, us_id) 
		values ($id_invitacion_ar,".$_SESSION["id_proveedor"].",'$confirmacion','$fecha $hora','$justifica',1,".$_SESSION["id_us_session"].")");
		$id_cargue=id_insert();
		if($id_cargue>=1){// si ingreso el resgitro

			if($confirmacion==1) $confirma_parti_p = "Si participa";
			if($confirmacion==2) $confirma_parti_p = "No participa";

			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_ar";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 7"));
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp5,$sql_e[5],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('--confirma_pa--', $confirma_parti_p, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('--msg_participacion--', $justifica, $id_subastas_arrglo);

		
			  	$busca_provee = traer_fila_row(query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion_ar and $t8.pv_id = $t7.pv_id and $t8.pv_id = ".$_SESSION["id_proveedor"]));
		
			$id_subastas_arrglo_usuario = str_replace("---proveedor---",$busca_provee[2], $id_subastas_arrglo);
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44])");
			while($destinatario = traer_fila_row($busca_dueno)){
			envia_correos($destinatario[0],$asunto,$mensaje_envio,$cabesa);
			$aquien_envia.=$destinatario[0]."<br>";
			registro_email_enviado($id_invitacion_ar, $destinatario[0], $asunto, $mensaje_envio,2,13);
			}


	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La confirmación se creó con éxito', 20, 10, 18);
			//alert("La confirmación se creó con éxito")
			window.parent.ajax_carga('detalle_invitacion_<?=$id_invitacion;?>.php','contenidos');

		</script>
	<?
						}// confirma subida de archivos fisicos
						
	else
	{
	?>
	 	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'La confirmación NO se creó con éxito', 20, 10, 18);
			//alert("Atención:\n La confirmación NO se creó con éxito")
		</script>
	<?
	
	
	
	}
	

		
		}
// fin documentos proveedor



if($accion=="agrega_tecnica")
	{
		
		$termino_p = arreglo_recibe_variables($termino);

		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);


	$suma_tamano = "select sum(evaluador6_tamano) from v_reportes_ofertas_enviadas where pro1_id = $id_invitacion_ar and pv_id = ".$_SESSION["id_proveedor"]." ";
	$sql_suma = traer_fila_row(query_db($suma_tamano));
	
	$taman_final_1 = ($sql_suma[0]/1024) / 1024;
	$ofeta_actual_ta = ($sube_archivo_size/1024)/1024;
	$total_con_actual = ($ofeta_actual_ta+$taman_final_1);
	if($total_con_actual>=200)
		{
			?>
            	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El anexo no se cargo, la oferta NO fue enviada\n * LA suma total en MB de sus anexo supera el maximo permitido de 200MB\n * 1) Elimine anexos no solitados\n * 2) Comprimalos y vuelvalos cargar \n * 3) De prioridad a los anexos solicitados por HOCOL', 20, 10, 18);
					//alert("ATENCION: el anexo no se cargo, la oferta NO fue enviada\n LA suma total en MB de sus anexo supera el maximo permitido de 200MB\n 1) Elimine anexos no solitados\n 2) Comprimalos y vuelvalos cargar \n 3) De prioridad a los anexos solicitados por HOCOL")
					 window.parent.document.getElementById("cargando").style.display="none"
				</script>
            
            <?
			
			exit();
			}

			
echo "insert into ".$t96." (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones,evaluador6_fecha ) 
			values (".$_SESSION["id_proveedor"].", $termino_p,'$sube_archivo_name','$sube_archivo_size','$sube_archivo_type','$observaciones', '$fecha $hora' )";
			$inserta_oferta = query_db("insert into ".$t96." (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones,evaluador6_fecha,resultado_evaluacion ) 
			values (".$_SESSION["id_proveedor"].", $termino_p,'$sube_archivo_name','$sube_archivo_size','$sube_archivo_type','$observaciones', '$fecha $hora','' )");
				$id_cargue=id_insert();
					if($id_cargue>=1){// si ingreso el resgitro
						
						if($sube_archivo<>""){//si hay archivo
								carga_archivo($sube_archivo,"procesos_tecnicos/".$id_cargue);
	   							$archiv_con = confirma_archivo($sube_archivo_size,"procesos_tecnicos/".$id_cargue.".txt");
	   
	   
								if($archiv_con == 1){// confirma subida de archivos fisicos
                              	 
								
								 if($tipo_termino==1)
                                  auditor(14,$id_invitacion_ar,$sube_archivo_name, $termino_p);
                              	 if($tipo_termino==2)
                                  auditor(15,$id_invitacion_ar,$sube_archivo_name, $termino_p);
								  
								  ?>
										<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El anexo se creó con éxito', 20, 10, 18);
											//alert("El anexo se creó con éxito")
											window.parent.ajax_carga('oferta_invitacion_tecnica_<?=$id_invitacion;?>_<?=$termino;?>_<?=$tipo_termino;?>.php','contenidos');
										</script>
									<?				}// confirma subida de archivos fisicos
								 else{	?>
											<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El anexo NO se creó con éxito', 20, 10, 18);
												//alert("El anexo NO se creó con éxito")
											</script>
										<?
										}
					
										}//si hay archivo
										
							else{ //si no hay archivo pero se grabo	
							
							 if($tipo_termino==1)
                                  auditor(6,$id_invitacion_ar,$observaciones, $termino_p);
                              	 if($tipo_termino==4)
                                  auditor(7,$id_invitacion_ar,$observaciones, $termino_p);
							
							?>
										<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La oferta se envio con éxito', 20, 10, 18);
											//alert("La oferta se envio con éxito...")
											window.parent.ajax_carga('oferta_invitacion_tecnica_<?=$id_invitacion;?>_<?=$termino;?>_<?=$tipo_termino;?>.php','contenidos');
										</script>
									<?
									  }// si ingreso el resgitro
					 }// si ingreso el resgitro
									  
					  else{ // si ingreso el resgitro
										?>
											<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'La oferta no ingreso al sistema', 20, 10, 18);
												//alert("ATENCIÓN: La oferta no ingreso al sistema")
											</script>
										<?
										}

	
	}    

if($accion=="anexo_elimina_tecnico"){

$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
			$busca_nombre = traer_fila_row(query_db("select * from $t96 where evaluador6_id = $id_anexo "));
			$inserta_oferta = query_db("delete from ".$t96." where evaluador6_id = $id_anexo ");
			elimina_archivo("procesos_tecnicos/".$id_anexo.".txt");
					 if($tipo_termino==1)
                          auditor(10,$id_invitacion_ar,$busca_nombre[3]." tamaño=".$busca_nombre[4]." Observaciones: ".$busca_nombre[6], $busca_nombre[2]);
                     if($tipo_termino==2)
                          auditor(11,$id_invitacion_ar,$busca_nombre[3]." tamaño=".$busca_nombre[4]." Observaciones: ".$busca_nombre[6], $busca_nombre[2]);
								  			
			?>
            <script>
		window.parent.ajax_carga('oferta_invitacion_tecnica_<?=$id_invitacion;?>_<?=$termino;?>_<?=$tipo_termino;?>.php','contenidos');
			</script>

            <?


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
					window.parent.ajax_carga('mi_perfil.html','contenidos');
					
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
					window.parent.ajax_carga('mi_perfil.html','contenidos');
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
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La información se modifico con éxito', 20, 10, 18);
		//alert("La información se modifico con éxito")
		window.parent.ajax_carga('mi_perfil.html','contenidos');
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
					window.parent.ajax_carga('mi_perfil.html','contenidos');
					
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
					window.parent.ajax_carga('mi_perfil.html','contenidos');
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
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El usuario se creo con éxito', 20, 10, 18);
				//alert("El usuario se creo con éxito")
				window.parent.ajax_carga('mi_perfil.html','contenidos');
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
					window.parent.ajax_carga('mi_perfil.html','contenidos');
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

$inserta_us_seql_serv = "update t1_us_usuarios set contrasena='ELIMINADO', contra_temporal='1', estado  = 2  where us_id = $campo_id";
	$sql_e=mssql_query($inserta_us_seql_serv);


$inserta_us = "update $t1 set contrasena='ELIMINADO', contra_temporal='1', estado  = 2  where us_id = $campo_id";
	$sql_e=query_db($inserta_us);
			?>			
            <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El usuario se elimino con éxito', 20, 10, 18);
				//alert("El usuari se elimino con éxito")
				window.parent.ajax_carga('mi_perfil.html','contenidos');
				
			</script>
			<?
}


if($accion=="crea_pregunta_general")
	{
	
			$largo_comentarios = strlen($_POST["pregunta_general"]);
			if($largo_comentarios> 301){
				
				?>
                	
                    <script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'La pregunta NO se envio \n * La pregunta no puede contener mas de 300 caracteres', 20, 10, 18);
						//alert("ATENCION: La pregunta NO se envio \n La pregunta no puede contener mas de 300 caracteres")
						 window.parent.document.getElementById("cargando").style.display="none"
						
					</script>
                
                <?
				exit();
				}

		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		$cambia = query_db("insert into  $t15 (pro1_id ,pv_id ,fecha_pregunta ,pregunta ,us_id ,publica,tipo_aclaracio,tipo_aclaracion_solicitada, anexo ) 
		values ($id_invitacion_ar, ".$_SESSION["id_proveedor"].",'$fecha $hora', '$pregunta_general',".$_SESSION["id_us_session"].",0,$tipo_comunicacion,$tipo_aclaracion_solicitada,'".$_FILES["archi_foro"]["name"]."')");
		$id_p_archivo = id_insert();
		
		if($tipo_comunicacion==1) { 
			$rura_carga = "cartelera-aclaraciones_".$id_invitacion.".php";
			$asunto_arrgledo="Nuevo mensaje de aclaraciones";
			}
		if($tipo_comunicacion==2) { 
					$rura_carga = "cartelera-comunicaciones_".$id_invitacion.".php";		
					$asunto_arrgledo="Nuevo mensaje de Comunicaciones generales";
		}
		
		if($_FILES["archi_foro"]["name"]!=""){			
		   carga_archivo($_FILES["archi_foro"]["tmp_name"],"procesos_cartelera_aclaraciones/".$id_p_archivo);
		   //$archiv_con = confirma_archivo($sube_archivo_size,"procesos_proveedores/".$id_cargue.".txt");
		   }
		
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_ar";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 6"));
		 	$asunto = $busca_correo[1]." ".$sql_e[22];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp5,$sql_e[5],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);

		
			  	$busca_provee = traer_fila_row(query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion_ar and $t8.pv_id = $t7.pv_id and $t8.pv_id = ".$_SESSION["id_proveedor"]));
		
				$id_subastas_arrglo_usuario = str_replace("---proveedor---",$busca_provee[2], $id_subastas_arrglo);
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44])");
			while($destinatario = traer_fila_row($busca_dueno)){
			//envia_correos($destinatario[0],$asunto,$mensaje_envio,$cabesa);
			
			//registro_email_enviado($id_invitacion_ar, $destinatario[0], $asunto, $mensaje_envio,2,3);
				$aquien_envia.=$destinatario[0]."<br>";
			}

		
		?>
      <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La aclaración se envio con éxito', 20, 10, 18);
		//alert("La aclaración se envio con éxito !.")
		window.parent.ajax_carga('<?=$rura_carga;?>','contenidos');
		
	</script>

          <?
	
	}
	
if($accion=="crea_pregunta_general_foro")
	{
	
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		$cambia = query_db("insert into  $t16 (pro7_id,tipo_preg_respuesta ,us_id ,pv_id ,fecha_foro ,foro ,publica,anexo) 
		values ($id_anexo, 1, ".$_SESSION["id_us_session"].", ".$_SESSION["id_proveedor"].",'$fecha $hora', '".$_POST["p_foro_".$id_anexo]."',1,'".$_FILES["archi_foro_".$id_anexo]["name"]."' )");
	
		   $id_p_archivo = id_insert();
		   
			if($_FILES["archi_foro_".$id_anexo]["name"]!=""){			
		   carga_archivo($_FILES["archi_foro_".$id_anexo]["tmp_name"],"procesos_cartelera/".$id_p_archivo);
		   //$archiv_con = confirma_archivo($sube_archivo_size,"procesos_proveedores/".$id_cargue.".txt");
		   }


			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_ar";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 6"));
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp5,$sql_e[5],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);

		
			  	$busca_provee = traer_fila_row(query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion_ar and $t8.pv_id = $t7.pv_id and $t8.pv_id = ".$_SESSION["id_proveedor"]));
		
			$id_subastas_arrglo_usuario = str_replace("---proveedor---",$busca_provee[2], $id_subastas_arrglo);
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44])");
			while($destinatario = traer_fila_row($busca_dueno)){
			//envia_correos($destinatario[0],$asunto,$mensaje_envio,$cabesa);
			
			//registro_email_enviado($id_invitacion_ar, $destinatario[0], $asunto, $mensaje_envio,2,3);
				$aquien_envia.=$destinatario[0]."<br>";
			}

		
		?>
      <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La aclaración se envio con éxito', 20, 10, 18);
		//alert("La aclaración se envio con éxito !")
		window.parent.ajax_carga('../aplicaciones/proveedores/carga_pregunta_foro.php?id_pr_pasa=<?=$id_anexo;?>&complemento_foro=<?=$_POST["complemento_foro_".$id_anexo];?>','div_for_pre_<?=$id_anexo;?>');
		
		
	</script>

          <?
	
	}	



if($accion=="respuesta_final_aclaracion")
	{
	
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		$id_pregunta_ar = $id_pregunta;
		
		$cambia = query_db("insert into  $t28 (pro16_id ,us_id ,fecha_respuesta ,respuesta ,archivo_soporte) 
		values ($id_pregunta_ar, ".$_SESSION["id_us_session"].",'$fecha $hora', '$observaciones','".$_FILES["sube_archivo"]["name"]."')");
		   $id_p_archivo = id_insert();
		   
			if($_FILES["sube_archivo"]["name"]!=""){			
		   carga_archivo($_FILES["sube_archivo"]["tmp_name"],"procesos_cartelera_final/".$id_p_archivo);
		   //$archiv_con = confirma_archivo($sube_archivo_size,"procesos_proveedores/".$id_cargue.".txt");
		   }
		
				
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_ar";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 6"));
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp5,$sql_e[5],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);

		
			  	$busca_provee = traer_fila_row(query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion_ar and $t8.pv_id = $t7.pv_id and $t8.pv_id = ".$_SESSION["id_proveedor"]));
		
			$id_subastas_arrglo_usuario = str_replace("---proveedor---",$busca_provee[2], $id_subastas_arrglo);
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44])");
			while($destinatario = traer_fila_row($busca_dueno)){
				envia_correos($destinatario[0].",sgpa-notificaciones@enternova.net",$asunto,$mensaje_envio,$cabesa);
				registro_email_enviado($id_invitacion_ar, $destinatario[0], $asunto, $mensaje_envio,2,3);
				$aquien_envia.=$destinatario[0]."<br>";
			}

		
		?>
      <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La respuesta se envio con éxito', 20, 10, 18);
		//alert("La respuesta se envio con éxito")
		window.parent.ajax_carga('../aplicaciones/proveedores/respuesta_aclaraciones_finales.php?id_pregunta=<?=$id_pregunta;?>&id_invitacion_pasa=<?=$id_invitacion;?>','contenidos');
		
	</script>

          <?
	
	}


if($accion=="anexo_elimina_aclaracion"){

			$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
			echo "select * from $t28 where pro17_id = $id_anexo ";
			$busca_nombre = traer_fila_row(query_db("select * from $t28 where pro17_id = $id_anexo "));
			$inserta_oferta = query_db("delete from ".$t28." where pro17_id = $id_anexo ");
			elimina_archivo("procesos_cartelera_final/".$id_anexo.".txt");
					
            auditor(30,$id_invitacion_ar,$busca_nombre[5]." Respuesta: ".$busca_nombre[4], $busca_nombre[0]);
                    
								  			
			?>
            <script>
				window.parent.ajax_carga('../aplicaciones/proveedores/respuesta_aclaraciones_finales.php?id_pregunta=<?=$id_pregunta;?>&id_invitacion_pasa=<?=$id_invitacion;?>','contenidos');
			</script>

            <?


}


if($_POST["accion"] == "confirma_terminos")
	{
$id_invitacion_ar = arreglo_recibe_variables($id_invitacion_pasa);
	
		$cambia_es = query_db("update $t43 set acepta_terminos = 1,us_id_aceptacion=".$_SESSION["id_us_session"].",	fecha_aceptacion='$fecha $hora',	ip_aceptacion ='".$_SERVER['REMOTE_ADDR']."' where pro27_id = $id_pro27");
		auditor(48,$id_invitacion_ar,"El proveedor acepta los terminos de la adjudicacion ", "");



	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La confirmación se creó con éxito', 20, 10, 18);
			//alert("La confirmación se creó con éxito ")
			window.parent.location.href='procesos.html'

		</script>
	<?
						
	

		
		}

if($_POST["accion"] == "confirma_terminos_no")
	{
$id_invitacion_ar = arreglo_recibe_variables($id_invitacion_pasa);
	
		$cambia_es = query_db("update $t43 set acepta_terminos = 2,us_id_aceptacion=".$_SESSION["id_us_session"].",	fecha_aceptacion='$fecha $hora',	ip_aceptacion ='".$_SERVER['REMOTE_ADDR']."', observacion_no_acepta='".elimina_comillas_2($observacion_no_acepta)."' where pro27_id = $id_pro27");
		auditor(49,$id_invitacion_ar,"El proveedor NO acepta los terminos de la adjudicacion | comentarios de la accion:".elimina_comillas_2($observacion_no_acepta), "");


	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La confirmación se creó con éxito', 20, 10, 18);
			//alert("La confirmación se creó con éxito")
			window.parent.location.href='procesos.html'

		</script>
	<?
						
	

		
		}		
		

if($_POST["accion"] == "nuevo_ad_foro")
	{
$id_invitacion_ar = arreglo_recibe_variables($id_invitacion_pasa);
	
		$cambia_es = query_db("insert into $t48 (pro27_id, us_id, tipo_genera_pregunta, pregunta, fecha) values (
		$id_pro27, ".$_SESSION["id_us_session"].", 2, '$observacion_foro','$fecha $hora')");
$id_p_archivo = id_insert();
			$datos_invita=traer_fila_row(query_db("select * from $t5  where pro1_id = $id_invitacion_ar "));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 16"));
		 	$asunto_2 = "Mensaje de foro de adjudicacion del proveedor: ".$datos_invita[22];
			$id_subastas_arrglo = str_replace('---proceso---', $datos_invita[22], $busca_correo[4]);
			$id_subastas_arrglo = str_replace('---consecutivo---', $datos_invita[22], $id_subastas_arrglo);
			

				$busca_provee_lp = traer_fila_row(query_db("select $t8.pv_id, $t8.razon_social,$t8.email from $t8 where
				$t8.pv_id = ".$_SESSION["id_proveedor"]));
				// proveedores
					echo $id_subastas_arrglo = str_replace('---proveedor---', $busca_provee_lp[1], $id_subastas_arrglo);

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[1], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[2], $id_subastas_arrglo_usuario);				
					
					
						echo "aqui".$id_p_archivo."aqui";			
		if($datos_invita[3]==1){				
				//envia_correos("carlos.cock@hcl.com.co",$asunto_2,$id_subastas_arrglo,$cabesa);
				//registro_email_enviado($id_invitacion_ar, "carlos.cock@hcl.com.co", $asunto_2, $id_subastas_arrglo,2,12);
				// proveedores	
		}

	?>
	 	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El comentario se creó con éxito', 20, 10, 18);
			//alert("El comentario se creó con éxito")
			window.parent.ajax_carga('../aplicaciones/proveedores/adjudicacion_paso1.php?id_invitacion_pasa=<?=arreglo_pasa_variables($id_invitacion_ar);?>&id_notificacion=<?=$id_notificacion;?>&pro27_id=<?=$id_pro27;?>','contenidos')

		</script>
	<?
						
	

		
		}				
// fin documentos proveedor

if($accion=="envia_soporte")
	{
	

		
		
		
		
			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
			
		$error_soporte="";
		$razon_social=elimina_comillas_2($_POST["razon_social"]);
		$contacto=elimina_comillas_2($_POST["nombre_solicita"]);
		$telefono=elimina_comillas_2($_POST["telefono"]);
		$email=elimina_comillas_2($_POST["email"]);
		$ciuadad=elimina_comillas_2($_POST["ciuadad"]);
		$mensaje=elimina_comillas_2($_POST["mensaje"]);
		echo $verifica_email = comprobar_email($email);
			
			if($razon_social==""){ $error_soporte.="* Digite: Nombre / Raz&oacute;n social"; }
			elseif($tp17_id=="0"){ $error_soporte.="* Seleccione el tipo de soporte requerido"; }
			elseif($contacto==""){ $error_soporte.="* Digite: el nombre de la persona de contacto"; }
			elseif($telefono==""){ $error_soporte.="* Digite: el tel&eacute;fono de la persona de contacto"; }
			elseif($ciuadad=="0"){ $error_soporte.="* Seleccione una ciudad"; }
			elseif($mensaje=="") { $error_soporte.="* Digite: Mensaje de soporte"; }			
			elseif($verifica_email==0){ $error_soporte.="* Valide el e-mail"; }			
			echo $error_soporte;
			
			if($error_soporte!="")
			{
			?>
            	<script>
            window.parent.muestra_alerta_error_solo_texto('', 'Error', '<?=$error_soporte;?>', 20, 10, 18);
					//alert("ERROR: <?=$error_soporte;?> ")
					
				</script>
            <?				
				
				}
			else{
				
					echo $inserta_soporte ="insert into help_solicitudes (razon_social, nombre_solicita, telefono, cd_id, email, mensaje, tp17_id, fecha, ip, resuelto,pv_id) values ('$razon_social','$contacto','$telefono',$ciuadad,'$email','$mensaje',$tp17_id,'$fecha $hora','".$_SERVER['REMOTE_ADDR']."',1,$pv_id)";
					$sql_ex =  mssql_query($inserta_soporte);
				
				$error_soporte="El mensaje se envio, en breve un ingeniero se contactara con  usted";
				envia_correos("mesa-ayuda@enternova.net","Nuevo soporte tecnico HOCOL SA","Por favor ingrese al sistema de HOCOL SA y revise las solicitudes de soporte","");

				
		$razon_social="";
		$nombre_solicita="";
		$telefono="";
		$email="";
		$ciuadad="";
		$depart="";
		$pais="";
		$tp17_id="";
		$mensaje="";

				
						

			?>
            	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El mensaje se envio, en breve un ingeniero se contactara con  usted', 20, 10, 18);
					//alert("El mensaje se envio, en breve un ingeniero se contactara con  usted ")
					window.parent.ajax_carga('mi_soporte_tecnico.html','contenidos');
				</script>
            <?

}	
	
	}



if($_POST["accion"]=="crea_soporte")
	{
	

		
			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
			
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
			
		echo $inserta_procesos="insert into help_respuestas (help_id,us_id,fecha,detallle, proxima_llamada)
		 values ($id_soporte, ".$_SESSION["id_us_session"].",'$fecha $hora', '".elimina_comillas_2($pregunta_general)."', '".elimina_comillas_2($h_m_r)."')";
		$sql_ex=mssql_query($inserta_procesos.$trae_id_insrte);
				envia_correos("mercadeo1@subastasycomercio.com","Nuevo soporte tecnico HOCOL SA","Por favor ingrese al sistema de HOCOL SA y revise las solicitudes de soporte","");
		
		
			$update = mssql_query("update  help_solicitudes set resuelto = $efectividad_bita where  help_id = $id_soporte");
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creó con éxito', 20, 10, 18);
		//alert("El registro se creó con éxito")
		window.parent.ajax_carga('soporte_detallado_<?=$id_soporte;?>.html','contenidos');
		</script>
        <?

	
	}


 ?>


<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>