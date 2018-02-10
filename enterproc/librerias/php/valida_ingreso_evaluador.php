<?  include("../lib/@session.php");
	
			if ((US_INGRESO!="") && (PW_INGRESO!="")){//si estan llenas la credenciales
			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
			
			if($cambi==1)
				{
					$pwd_cambia = md5($_POST["pw_ingreso_nueva"]);
					$busca_usuario_2= " select us_id, contrasena, tipo_usuario,contra_temporal from t1_us_usuarios where usuario  = '".US_INGRESO."' and  estado = 1 ";
					$us_sql_1 = mssql_fetch_row(mssql_query($busca_usuario_2));
					
						if($us_sql_1[0]>=1)
							{
								$cambia = mssql_query("update t1_us_usuarios set contrasena = '$pwd_cambia', contra_temporal=0 where us_id = $us_sql_1[0]");
								//$erro = "update t1_us_usuarios set contrasena = '$pwd_cambia' where us_id = $us_sql_1[0]"
							}
						else{ $erro = "Las credenciales no coinciden con las registradas";
							?>
							<script>
							window.parent.ajax_carga('../aplicaciones/evaluacion/login_acceso.php?id_p=<?=$id_p;?>&erro=<?=$erro;?>','contrase_<?=$id_p;?>');
							</script>
								<? exit();
								}
				}
			
			
			$busca_usuario = " select us_id, contrasena, tipo_usuario,contra_temporal from t1_us_usuarios where usuario  = '".US_INGRESO."' and  estado = 1 ";
			$us_sql = mssql_fetch_row(mssql_query($busca_usuario));

			if($us_sql[3]==1){
			$erro = "Este usuario debe cambiar al contraseña.";
			?>
            
            	<script>
						window.parent.ajax_carga('../aplicaciones/evaluacion/login_acceso.php?id_p=<?=$id_p;?>&erro=<?=$erro;?>&usuario_cambia=<?=US_INGRESO;?>&contra_cambi=<?=PW_INGRESO;?>&cambi=1','contrase_<?=$id_p;?>');
				</script>
            
            <?
			exit();
			}
			

			if($us_sql[0]>=1) 
				{//si el usuario existe
				
				$pwd = md5(PW_INGRESO);
				if($pwd==$us_sql[1]){//valida contarseña
	
					$busca_cuantia = traer_fila_row(query_db("select if(tp7_tipo_moneda=2, (cuantia / 1850), cuantia) as valor, us_id_contacto, us_id, cd_id_entrega_documentos from $t5 where pro1_id = $id_p "));
						if( $us_sql[0]==$busca_cuantia[2]) 
							$permiso_apertura = 1;
						elseif( $us_sql[0]==$busca_cuantia[1]) 
							$permiso_apertura = 1;							
						elseif( $us_sql[0]==$busca_cuantia[3]) 
							$permiso_apertura = 1;
						elseif( $us_sql[2]==1) 
							$permiso_apertura = 1;
						else{
							$erro = "Este proceso require ser abierto por un auditor.";
							$permiso_apertura = 0;
							}
							
						if($permiso_apertura==0){//verifica permisos
							
							
							
						?>
						<script>
						window.parent.ajax_carga('../aplicaciones/evaluacion/login_acceso.php?id_p=<?=$id_p;?>&erro=<?=$erro;?>','contrase_<?=$id_p;?>');
						</script>
							<?
							}
						else{
						$buscar_apertura=traer_fila_row(query_db("select count(*) from pro12_apertura_proceso where pro1_id = $id_p"));
						if($buscar_apertura[0]==0){
							if( ($_SESSION["id_us_session"]!=1) && ($_SESSION["id_us_session"]!=597) ){
									$inserta_r = query_db("insert into pro12_apertura_proceso (pro1_id, us_auditor, us_comprador, us_usuario, fecha_apertura, hora_apertura, lugar_apertura,estado)
									values ($id_p,".$_SESSION["id_us_session"].",".$busca_cuantia[1].",$us_sql[0],'$fecha', '$hora','',1 )"); 

									
									
							}
								}
						
						$sqlbusca_tecnicos = "select count(*) from evaluador1_relacionpreguntas_admin where in_id = $id_p and termino = 2";
						$sqlbusca_tecnicos_ex = traer_fila_row(query_db($sqlbusca_tecnicos));
						if($sqlbusca_tecnicos_ex[0]>=1)
						$busca_tiene_tecnic =1;
						else
						$busca_tiene_tecnic =2;
							
							
						?> <script>
						var forma = window.parent.document.principal
		forma.target="grp_urna_apertura";
			forma.action = "../../librerias/php/funcion_urna_sgpa.php";
			forma.accion.value="graba_gestion_apertura";
			forma.id_item_pecc.value="<?=$busca_cuantia[3];?>"
			forma.contiene_tecnico.value="<?=$busca_tiene_tecnic;?>"
			forma.submit()
			forma.target="";
			forma.action = "";
			forma.accion.value="";
			location.href="";
			
						window.parent.ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_p;?>','contenidos');
						</script> <?


		$busca_procesos = "select * from $t5 where pro1_id = $id_p";
		$sql_e=traer_fila_row(query_db($busca_procesos));	
		
		if($busca_tiene_tecnic==1){
		$busca_tecnico = "select us_id from pro6_observadores_procesos where pro1_id = $id_p and tipo = 2";
		$busca_tecnico_sql =  traer_fila_row(query_db($busca_tecnico));					
		$us_tecnico = ", ".$busca_tecnico_sql[0];
		}
						
		$busca_correo = traer_fila_row(query_db("select * from tp12_tipo_email where tp12_id = 24"));
		$id_subastas_arrglo = str_replace("---consecutivo---",$sql_e[22], $busca_correo[4] );
		$asunto = str_replace("---consecutivo---",$sql_e[22], $busca_correo[1] );
		

		$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44] $us_tecnico)");
		while($destinatario = traer_fila_row($busca_dueno)){
			$confirma_envio=envia_correos($destinatario[0],$asunto,$id_subastas_arrglo,$cabesa);
			registro_email_enviado_nuevo($id_p, $destinatario[0], $asunto, $id_subastas_arrglo,$confirma_envio,1,19,0);
			
			}						
						
			auditor(52,$id_p,"Apertura de ofertas", "");
						
						
						
						exit();
						} 
				}//valida contraseña				
				else{ //valida contarseña
				 	$erro = "Las credenciales no coinciden con las registradas";
				?>
				<script>
				window.parent.ajax_carga('../aplicaciones/evaluacion/login_acceso.php?id_p=<?=$id_p;?>&erro=<?=$erro;?>','contrase_<?=$id_p;?>');
                </script>
					<?
                    }
				
				
				}//si el usuario existe
				
			else
				{// si sel uduario no existe
					$erro = "El usuario no esta invitado en este proceso";
				?>
				<script>
				window.parent.ajax_carga('../aplicaciones/evaluacion/login_acceso.php?id_p=<?=$id_p;?>&erro=<?=$erro;?>','contrase_<?=$id_p;?>');
                </script>
					<?
		
					
				}
		

		}//si estan llenas la credenciales
		
?>