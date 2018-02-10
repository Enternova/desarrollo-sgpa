<?  include("../lib/@session.php");

date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer



if($_POST["accion"]=="crea_proceso")
	{
	


		$inserta_procesos="insert into $t5 (tp1_id,tp2_id,tp3_id,tp4_id,tp5_id,cd_id_ejecucion,cd_id_entrega_documentos,
		direccion_entrega_documentos, cd_id_entrega_ofertas, direccion_entrega_ofertas, tp6_id, detalle_objeto, 
		tp7_tipo_moneda, cuantia, us_id_contacto, fecha_publicacion, fecha_apertura, fecha_cierre, peso_tecnico, 
		minimo_tecnico_solicitado, peso_economico,consecutivo,apertura_juridica,cierre_juridica, apertura_tecnica, cierre_tecnica,apertura_economica, cierre_economica, fecha_informativa, lugar, fecha_creacion, us_id, fecha_informativa_final, fecha_aclaraciones_2_inicial, fecha_aclaraciones_2_final, fecha_aclaraciones_3_inicial, fecha_aclaraciones_3_final, fecha_preconomica_inicial, fecha_preconomica_final, nueva_fecha_informativa, trm_actual,origen_duplicidad )
		 values (9, $a,$tipo_solicitud, $b, $g, 0,0,'$l',0,'',$c, '$d', $f,  $e, $k,'$h','$i','$j',$p_t,$m_t,0,'".consecutivo_automatico()."' ,'$a_j','$c_j','$a_t','$c_t','$a_e','$c_e', '$fecha_informativa','$direccion_info' , '$fecha $hora', ".$_SESSION["id_us_session"].", '$fecha_informativa_f','$a_j5','$a_j6','$a_j7','$a_j8','$a_e_p', '$c_e_p', '$fecha_reu_info', '$trm_actual',0)";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){
		auditor(20,$id_p,"", "");
		
				$sele_car="select * from pv_contactos where  pv_id = $pv_id_b and estado = 1 ";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
			$crea_relacion = query_db("insert into pro33_relacion_contactos_procesos (pro1_id, pv_contactos_id, principal) 
	values ($id_p,".$ls_c[0].",1 )");

				
				}
		
		
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($auditor_proceso,$id_p,1)");						
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($respo_juridico, $id_p,2)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_tec,$id_p,3)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_ec,$id_p,4)");				
		

		$inserta_defaul_tecnico_cate = query_db("insert into $t12 (proc1_id,rel9_id ,porcentaje ,estado_configuracion) values ($id_p, 2,100,1)");			
		$inserta_defaul_tecnico = query_db("insert into $t91 (in_id,rel10_id ,evaluador1_valoresperado ,termino) values ($id_p, 1,100,2)");			
		$inserta_defaul_comercial = query_db("insert into $t91 (in_id,rel10_id ,evaluador1_valoresperado ,termino) values ($id_p, 8,0,1)");	
		$inserta_defaul_lista_economica = query_db("insert into $t19 (pro1_id,nombre ,requiere_aui) values ($id_p, 'LISTA ITEM ECONOMICO ".consecutivo_automatico()."',0)");	
		$id_lista = id_insert();		
		if($id_lista>=1)
			{
				$inserta_defaul_lista_economica = query_db("insert into $t94 (in_id,evaluador4_nombre ,evaluador4_tipo, orden_aparacion, pro11_id)
				 values ($id_p, 'VALOR UNITARIO ANTES DE IVA','Valor',0,$id_lista)");	
			}
		
		graba_lugar_ejecucion($id_p);

		
		
		?>
        <script> 
		alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_p;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
		alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
        </script>
		<?
		
		
		}
	
	}
     
if($_POST["accion"]=="crea_proveedor")
	{
	echo $proveedor;
		$proveedor = explode("----,",$proveedor);
	
		echo $inserta_procesos="insert into $t7 (pro1_id,pv_id,lectura_proceso,aceptacion_participacion,estado)
		  values ($id_proceso, $proveedor[1],'', 'N/A', 1  )";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){
		auditor(37,$id_proceso,$proveedor[0], $proveedor[1]);
		?>
        <script> 
		alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
		alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
        </script>
		<?
		
		
		}
	
	}	        

if($_POST["accion"]=="elimina_proveedor")
	{
	
		$bsca_pro = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $id_elimina "));
		$inserta_procesos="delete from $t7 where pv_id = $id_elimina and  pro1_id = $id_proceso";
		$sql_e = query_db($inserta_procesos);
		auditor(38,$id_proceso,$bsca_pro[0], $id_elimina);
		?>
        <script> 
		alert("El proveedor se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
	
	}	        








if($_POST["accion"]=="crea_archivo")
	{

		
		$verifica_notificacion = traer_fila_row(query_db("select notificacion from $t5 where pro1_id = $id_proceso"));
		
		$inserta_procesos="insert into $t6 (pro1_id,tp8_id,archivo,peso,fecha_carga,estado,origen,tipo_archivo,id_origen)
		  values ($id_proceso, $tipo_archivo,'$anexos_s_name', '$anexos_s_size', '$fecha $hora',1 ,1,'N/A',0 )";
		$sql_e = query_db($inserta_procesos);
		$id_fichero = id_insert();
		if($id_fichero>=1){
				auditor(22,$id_proceso,$anexos_s_name, "");
				if($verifica_notificacion[0]==1)
					alertas_bitacora(6,$id_proceso,0,"Nuevo archivo en el proceso",$id_fichero);
				
		carga_archivo($anexos_s,"pecc/".$id_fichero."_1");
		$cambia_estado = query_db("update $t5 set tp1_id = 2 where pro1_id = $id_proceso");
		
		?>
        <script> 
		alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
		alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
        </script>
		<?
		
		
		}
	
	}

if($_POST["accion"]=="elimina_archivo")
	{
	
		$busca_archivo=traer_fila_row(query_db("select * from $t6 where pro2_id = $id_elimina "));
		$inserta_procesos="delete from $t6 where pro2_id = $id_elimina ";
		$sql_e = query_db($inserta_procesos);
		if($busca_archivo[7]==1)
		unlink(SUE_PATH_ARCHIVOS."pecc/".$id_elimina."_1.txt");
		
		auditor(23,$id_proceso,$busca_archivo[3], "");
		?>
        <script> 
		alert("El archivo se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
	
	}


//---------------------------------------------------------------------------------------------------------------------------------------------------
//generacion de puntos esperados
if($_POST["accion"] == "configura_evaluacion_criterios")
	{
		$suma_categoria=0;
		$suma_criterios=0;
		
		$suma_categoria = array_sum($_POST["valor_catego"]);
		if($suma_categoria==100){//SI LAS CATEGORIAS SUMAN 100%
		
		foreach($_POST["valor_catego"] as $id_categoria => $valor_categoria)
			{ // recorre las categorias

				if($valor_categoria!=""){//verifica que las categorias tengan valores
				$id_categoria_no_borrar.=",".$id_categoria;
				/****************************************
				INGRESO DE CATEGORIAS A LA BASE DE DATOS
				*****************************************/

					$busca_existe = traer_fila_row(query_db("select * from $t12 where  proc1_id = $id_proceso and rel9_id = $id_categoria"));
						if($busca_existe[0]>=1)
							 $inserta_cr="update $t12 set porcentaje=$valor_categoria where evaluador9_id   = $busca_existe[0]";
						else							
							 $inserta_cr="insert into $t12 (proc1_id, rel9_id, porcentaje) values ($id_proceso,$id_categoria,$valor_categoria )";

					$exc=query_db($inserta_cr);
								

				/****************************************
				INGRESO DE CATEGORIAS A LA BASE DE DATOS
				*****************************************/
				
				
						$suma_criterios = array_sum($_POST["valorcriteri_".$id_categoria]);
						if($suma_criterios==100){//SI LOS CRITERIOS SUMAN 100%
				
								foreach($_POST["valorcriteri_".$id_categoria] as $id_criterio => $valor_criterio)
									{ // recorre los criterios
											if($valor_criterio!=""){//verifica que los criterios tengan valores
												$id_criterios_no_borrar.=",".$id_criterio;								
											
											
											$busca_existe = traer_fila_row(query_db("select * from $t91 where  in_id = $id_proceso and rel10_id = $id_criterio"));
											if($busca_existe[0]>=1)
											 $inserta_cr="update $t91 set evaluador1_valoresperado=$valor_criterio where evaluador1_id  = $busca_existe[0]";
											else							
											 $inserta_cr="insert into $t91 (in_id, rel10_id, evaluador1_valoresperado, termino) values ($id_proceso,$id_criterio,$valor_criterio, 2 )";
				
											$exc=query_db($inserta_cr);
											
											
											
																   }//verifica que los criterios tengan valores
																
									}// recorre los criterios
								
						}//SI LOS CRITERIOS SUMAN 100%	
						else{//SI LOS CRITERIOS SUMAN 100% ?>

							<script> 
                            alert("ATENCION\n * Los criterios de las categorías de la evaluación técnica deben sumar el 100%\n * La suma parcial de criterios seleccionados es de <?=$suma_criterios;?>")
							window.parent.document.principal.suma_criterio_<?=$id_categoria;?>.className = "campos_faltantes_fecha"
                            


                            </script>            
            
			            <? exit(); } //SI LAS CRITERIOS NO SUMAN 100% 
						
									
										}//verifica que las categorias tengan valores
			} // recorre las categorias
			
					echo $borra="delete from $t12 where proc1_id = $id_proceso and rel9_id  not in (0 $id_categoria_no_borrar) ";
					$exc=query_db($borra);	

					echo $borra="delete from $t91 where in_id = $id_proceso and rel10_id  not in (0 $id_criterios_no_borrar) and termino = 2 ";
					$exc=query_db($borra);
					
					$cambia_estado = query_db("update $t5 set tp1_id = 2 where pro1_id = $id_proceso");
					?>
                    	<script>
						alert("La evaluación técnica se genero con exito")
						window.parent.ajax_carga('configuracion_criteriostecnicos_<?=$id_vari;?>_2.php','carga_evaluacion')
						</script>
                    
                    
                    <?

			
			}//SI LAS CATEGORIAS SUMAN 100%
			else{//SI LAS CATEGORIAS NO SUMAN 100% ?>

					<script> 
	                    alert("ATENCION\n * Las categorías de la evaluación técnica deben sumar el 100%\n * La suma total de las categorías seleccionadas es de <?=$suma_categoria;?>")
                    </script>            
            
            <?

							
			
			 } //SI LAS CATEGORIAS NO SUMAN 100% 
			
			//echo $suma_criterios;
	

}
//---------------------------------------------------------------------------------------------------------------------------------------------------
//generacion de puntos esperados


//configura campos

if($_POST["accion"] == "configura_evaluacion_campo")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		
		$cambia_cali=query_db("insert into $t94 (in_id, evaluador4_nombre, evaluador4_tipo,orden_aparacion, pro11_id ) values ($id_invitacion, '$n_campo', '$tipo_campo', 0, $id_lista)");
		$id_cargue=id_insert();
		if($id_cargue>=1){
	?>
	 	<script>
			alert("El campo se creo con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');
		</script>
	<?
		} else { ?>		
	 	<script>
			alert("ATENCIÓN: El campo NO se creo")
		</script>
	<?
        		}
		
		}




if($_POST["accion"] == "e_configura_evaluacion_campo")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);
		$cambia_cali="update $t94 set  evaluador4_nombre = '".$_POST["n_e_campo_".$id_campo]."', evaluador4_tipo='".$_POST["t_e_campo_".$id_campo]."' where evaluador4_id = $id_campo";
		$sql_ex = query_db($cambia_cali);
	?>
	 	<script>
			alert("El campo se modifico con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');
		</script>
	<?

		
		}
		
if($_POST["accion"] == "elimina_configura_evaluacion_campo")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);
		echo $cambia_cali="delete from $t94  where evaluador4_id = $id_campo";
		$sql_ex = query_db($cambia_cali);
	?>
	 	<script>
			alert("El campo se elimino con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');
		</script>
	<?

		
		}		

if($_POST["accion"] == "elimina_toda_lista")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);
		echo $cambia_cali="delete from $t95  where in_id = $id_invitacion";
		$sql_ex = query_db($cambia_cali);
	?>
	 	<script>
			alert("La lista se elimino con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>.html','contenidos');
		</script>
	<?

		
		}
//---------------------------------------------------------------------------------------------------------------------------------------------------
//configura campos

//configura articulos

		
if($_POST["accion"] == "configura_evaluacion_articulo")
	{

		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		$cambia_cali=query_db("insert into $t95 (in_id, evaluador5_codigo, evaluador5_detalle,evaluador5_unidad,evaluador5_cantidad,evaluador5_moneda,evaluador5_valor,evaluador5_presupuesto, pro11_id)
		 values ($id_invitacion,'$a_economica', '$b_economica', '$c_economica',$d_economica,'$e_economica','$f_economica','$presupuesto_economica', $id_lista)");
		$id_cargue=id_insert();
		if($id_cargue>=1){
		auditor(24,$id_invitacion,$b_economica, "");
	?>
	 	<script>
			alert("El Producto se creo con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');


		</script>
	<?
		} else { ?>		
	 	<script>
			alert("ATENCIÓN: El Producto NO se creo")
		</script>
	<?
        		}
		
		}



if($_POST["accion"] == "edita_articulos_lista")
	{

		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);

		$busca_anterior = traer_fila_row(query_db("select evaluador5_detalle from $t95 where evaluador5_id  = $id_campo "));
		$cambia_cali="update $t95 set  evaluador5_codigo = '".$_POST["a2_".$id_campo]."', evaluador5_detalle='".$_POST["b2_".$id_campo]."',evaluador5_unidad='".$_POST["c2_".$id_campo]."', evaluador5_cantidad = '".$_POST["d2_".$id_campo]."' , evaluador5_moneda = '".$_POST["e2_".$id_campo]."' where evaluador5_id  = $id_campo";
		$id_cargue=query_db($cambia_cali);
		
		
		auditor(25,$id_invitacion,$busca_anterior[0]." por ".$_POST["b2_".$id_campo], "");

	?>
	 	<script>
			alert("El Producto se modifico con éxito")
		</script>
	<?

		
		}		


if($_POST["accion"] == "elimina_articulo_lista")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);
		$busca_anterior = traer_fila_row(query_db("select evaluador5_detalle from $t95 where evaluador5_id  = $id_campo "));
		auditor(26,$id_invitacion,$busca_anterior[0], "");
		 $cambia_cali="delete from $t95  where evaluador5_id = $id_campo";
		$sql_ex = query_db($cambia_cali);
	?>
	 	<script>
			alert("El bien o servicio se elimino con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');
		</script>
	<?

		
		}


//---------------------------------------------------------------------------------------------------------------------------------------------------
//configura articulos




if($_POST["accion"]=="notifica_proveedores")
	{
	
	   $inserta_procesos="update $t5 set notificacion = 1 where  pro1_id = $id_proceso";
		$sql_e = query_db($inserta_procesos);
		$cambia_estado = query_db("update $t5 set tp1_id = 4 where pro1_id = $id_proceso");


			$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
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
				$t7.pro1_id =  $id_proceso and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){// proveedores

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
					envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);
					alertas_bitacora(8,$id_proceso,$lp[0],"",0);
					auditor(27,$id_proceso,"Se envio email", "");
					$graba_correo_pro.="<li>".$lp[4]."</li>";
						
					$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_proceso and pv_id =$lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						
						envia_correos($lp_contactos[0],$asunto,$mensaje_envio,$cabesa);
						auditor(27,$id_proceso,"Se envio email de contacto: ".$lp_contactos[1], "");
						$graba_correo_pro.="<li>".$lp_contactos[0]."</li>";
						
						}//contactos
						
						
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
		alert("La notificación se envio con exito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
	
	}


if($_POST["accion"]=="modifica_proceso_notificado_p")
	{

	$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	$ms ="";
	if($sql_e[22]!=$consecutivo){
		$ms.="Consecutivo:".$consecutivo."<br>";
		
		
		}
	
	if($sql_e[2]!=$a){
		$ms.="Tipo de proceso:".listas_sin_select($tp2,$a,1)."<br>";
				$up.= " , tp2_id='$a'";
				}

	if($sql_e[3]!=$tipo_solicitud){
		$ms.="Tipo de solicitu:".listas_sin_select($tp3,$tipo_solicitud,1)."<br>";
				$up.= " , tp3_id='$tipo_solicitud'";
				}



	if($sql_e[5]!=$g){
		$ms.="Tipo de contrato:".listas_sin_select($tp5,$g,1)."<br>";
		$up.= " , tp5_id='$g'";
				}
		
	if($sql_e[11]!=$c){
		$ms.="Objeto a contratar:".listas_sin_select($tp6,$c,1)."<br>";
		$up.= " , tp6_id='$c'";
				}
	
	if($sql_e[12]!=$d){
		$ms.="Detalle del objeto a contratar:".$d."<br>";
		$up.= " , detalle_objeto='$d'";
				}
	
	if($sql_e[14]!=$e){
		$ms.="Cuantía a contratar:".$e."<br>";
	$up.= " , cuantia='$e'";
				}		
	
	if($sql_e[13]!=$f){
		$ms.="Moneda:".listas_sin_select($tp7,$f,1)."<br>";
		$up.= " , tp7_tipo_moneda='$f'";
				}	
	
	
	$up.= " , fecha_publicacion='$h'";
			
	if($sql_e[17]!=$i){
		$ms.="Fecha de apertura:".$i."<br>";
		$up.= " , fecha_apertura='$i'";
				}	
		
	
	if($sql_e[18]!=$j){
		$ms.="Fecha de cierre:".$j."<br>";
		$up.= " , fecha_cierre='$j'";
		alertas_bitacora(5,$id_proceso,0,"Modifica fecha de cierre:".$j,0);
		auditor(31,$id_proceso,"Modifica fecha de cierre:".$j, "");
		
				}			

	if($sql_e[15]!=$k){
		$ms.="Persona de contacto:".listas_sin_select($t1,$k,1)."<br>";
		$up.= " , us_id_contacto='$k'";
				}			
		
	
	if($sql_e[41]!=$fecha_reu_info){
		$ms.="Fecha y hora reunión informativa:".$fecha_informativa."<br>";
		$up.= " , fecha_informativa='$fecha_informativa'";
		alertas_bitacora(5,$id_proceso,0,"Modifica fecha y hora reunión informativa:".$fecha_informativa,0);
		auditor(32,$id_proceso,"Modifica fecha y hora reunión informativa:".$fecha_informativa, "");
		

				}			
		
	
	if($sql_e[30]!=$direccion_info){
		$ms.="Lugar reunión informativa:".$direccion_info."<br>";
		$up.= " , lugar='$direccion_info'";
				}			
		
		

		$up.= " , peso_tecnico='$p_t'";
		$up.= " , minimo_tecnico_solicitado='$m_t'";						
		$up.= " , apertura_juridica='$a_j'";
		$up.= " , cierre_juridica='$c_j'";
		$up.= " , apertura_tecnica='$a_t'";						
		$up.= " , cierre_tecnica='$c_t'";
		$up.= " , apertura_economica='$a_e'";
		$up.= " , cierre_economica='$c_e'";
		$up.= " , fecha_informativa='$fecha_informativa'";
		$up.= " , direccion_entrega_documentos ='$l'";
		
		$up.= " , fecha_informativa_final='$fecha_informativa_f'";
		$up.= " , fecha_aclaraciones_2_inicial='$a_j5'";
		$up.= " , fecha_aclaraciones_2_final='$a_j6'";						
		$up.= " , fecha_aclaraciones_3_inicial='$a_j7'";
		$up.= " , fecha_aclaraciones_3_final='$a_j8'";
		$up.= " , fecha_preconomica_inicial='$a_e_p'";
		$up.= " , fecha_preconomica_final='$c_e_p'";						
		$up.= " , nueva_fecha_informativa='$fecha_reu_info'";	
		$up.= " , trm_actual='$trm_actual'";			
		
	
	
	
	 $inserta_mo = "insert into $t10 (pro1_id, modificaciones, justificacion, us_id, fecha) values ($id_proceso,'$ms','$justificacion_final', ".$_SESSION["id_us_session"].", '$fecha $hora'   )";
	$insert = query_db($inserta_mo);
	
		 $cambia = "update $t5 set consecutivo = '$consecutivo' $up where pro1_id=$id_proceso";
		$insert = query_db($cambia);

		$dele_obser=query_db("delete from $t11  where pro1_id=$id_proceso");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($auditor_proceso,$id_proceso,1)");						
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($respo_juridico, $id_proceso,2)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_tec,$id_proceso,3)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_ec,$id_proceso,4)");				

		graba_lugar_ejecucion($id_proceso,$_POST["crea_lugar"]);

		$cambia_estado = query_db("update $t5 set tp1_id = 4 where pro1_id = $id_proceso");
		
		?>
	
	
    <script>
		alert("El proceso se modifico con éxito")
	</script>
    <?
	

	
	}
	
	
	
if($_POST["accion"]=="modifica_proceso")
	{
	$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
		$sql_e=traer_fila_row(query_db($busca_procesos));
		$ms ="";
		
		
	

		if($sql_e[18]!=$j){
		$ms="Modificación Fecha de cierre:".$j;
		
				}	
		if($sql_e[29]!=$fecha_informativa){
		$ms="Modificación Fecha y hora reunión informativa:".$fecha_informativa;

				}	

				
		$up.= " , tp3_id='$tipo_solicitud'";
		$up.= " , tp2_id='$a'";
		$up.= " , tp5_id='$g'";
		$up.= " , tp6_id='$c'";
		$up.= " , detalle_objeto='$d'";
		$up.= " , cuantia='$e'";
		$up.= " , tp7_tipo_moneda='$f'";
		$up.= " , fecha_apertura='$i'";
		$up.= " , fecha_cierre='$j'";
		$up.= " , peso_tecnico='$p_t'";
		$up.= " , minimo_tecnico_solicitado='$m_t'";						
		$up.= " , apertura_juridica='$a_j'";
		$up.= " , cierre_juridica='$c_j'";
		$up.= " , apertura_tecnica='$a_t'";						
		$up.= " , cierre_tecnica='$c_t'";
		$up.= " , apertura_economica='$a_e'";
		$up.= " , cierre_economica='$c_e'";
		$up.= " , fecha_informativa='$fecha_informativa'";
		$up.= " , direccion_entrega_documentos ='$l'";

		$up.= " , us_id_contacto='$k'";
		$up.= " , fecha_informativa='$fecha_informativa'";
		$up.= " , lugar='$direccion_info'";
		$up.= " , fecha_informativa_final='$fecha_informativa_f'";
		$up.= " , fecha_aclaraciones_2_inicial='$a_j5'";
		$up.= " , fecha_aclaraciones_2_final='$a_j6'";						
		$up.= " , fecha_aclaraciones_3_inicial='$a_j7'";
		$up.= " , fecha_aclaraciones_3_final='$a_j8'";
		$up.= " , fecha_preconomica_inicial='$a_e_p'";
		$up.= " , fecha_preconomica_final='$c_e_p'";						
		$up.= " , nueva_fecha_informativa='$fecha_reu_info'";	
		$up.= " , trm_actual='$trm_actual'";												





		$cambia = "update $t5 set consecutivo = '$consecutivo' $up where pro1_id=$id_proceso";
		$insert = query_db($cambia);

		$dele_obser=query_db("delete from $t11  where pro1_id=$id_proceso");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($auditor_proceso,$id_proceso,1)");						
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($respo_juridico, $id_proceso,2)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_tec,$id_proceso,3)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_ec,$id_proceso,4)");				
		graba_lugar_ejecucion($id_proceso);						
envia_correos("rene.sterling@parservicios.com","modificacion","prueba",$cabesa);
			
		?>
	
	
    <script>
		alert("El proceso se modifico con éxito")
	</script>
    <?

	}	


/*******************************************************************************************************************************/
//CREACION DE CATEGORIAS
/*******************************************************************************************************************************/

if($accion=="crea_grupo_evaluacion")
	{

				$cambia = query_db("insert into $t89 (cl_id,  rel9_detalle,  rel9_estado,rel9_aspecto, tp6_id ) values (1,'$valorgrupo',1,$termino,0)");
				if($termino==1) $ruta_carga = "configuracion_criterios_".$id_vari."_1.php";
				if($termino==2) $ruta_carga = "configuracion_criteriostecnicos_".$id_vari."_2.php";				
				?>
					<script>
						alert("La categoría se creó exito")
						window.parent.ajax_carga('<?=$ruta_carga;?>','contenidos');
					</script>

				<?

	
	  
	}


if($accion=="crea_criterio_evaluacion")
	{

		
		
		echo "insert into $t90 (rel9_id , rel10_detalle , rel10_estado ) values ($id_elimina, '".$_POST["nombre_criterio_".$id_elimina]."',1 )";
				
				$cambia = query_db("insert into $t90 (rel9_id , rel10_detalle , rel10_estado ) values ($id_elimina, '".$_POST["nombre_criterio_".$id_elimina]."',1 )");
				if($termino==1) $ruta_carga = "configuracion_criterios_".$id_vari."_1.php";
				if($termino==2) $ruta_carga = "configuracion_criteriostecnicos_".$id_vari."_2.php";				
				?>
					<script>
						alert("El criterio se creó exito")
						window.parent.ajax_carga('<?=$ruta_carga;?>','contenidos');
					</script>

				<?

	
	  
	}


/*******************************************************************************************************************************/
//CREACION DE CATEGORIAS
/*******************************************************************************************************************************/



/*******************************************************************************************************************************/
//CONFIGURACION Y ANEXO AL PROCESO CRITERIOS JURIDICOS
/*******************************************************************************************************************************/
if($_POST["accion"] == "configura_evaluacion_criterios_juridicos")
	{
		foreach($_POST["criterio"] as $id_criterio)
			{
				$valor_grupo=$_POST["valorcriteri_$id_criterio"];
				$suma_v+=$valor_grupo;
				$id_criterios.=",".$id_criterio;
			}
		
					echo $borra="delete from $t91 where in_id = $id_proceso and rel10_id  not in (0 $id_criterios) and termino = 1 ";
					$exc=query_db($borra);
					
					foreach($_POST["criterio"] as $id_criterio)
						{// for criterios
							$valor_criterio=$_POST["valorcriteri_$id_criterio"];

							$busca_existe = traer_fila_row(query_db("select * from $t91 where  in_id = $id_proceso and rel10_id = $id_criterio"));
							if($busca_existe[0]>=1)
							echo $inserta_cr="update $t91 set evaluador1_valoresperado=0 where evaluador1_id  = $busca_existe[0]";
							else							
							echo $inserta_cr="insert into $t91 (in_id, rel10_id, evaluador1_valoresperado, termino) values ($id_proceso,$id_criterio,0, 1 )";

							$exc=query_db($inserta_cr);
						}// for criterios
						
				//$cambia_estado = query_db("update $t55 set tp13_id = 12 where in_id = $id_invitacion");

						$cambia_estado = query_db("update $t5 set tp1_id = 2 where pro1_id = $id_proceso");

						?>
	 							<script>
								alert("La evaluación jurídica se genero con exito")
								window.parent.ajax_carga('configuracion_criterios_<?=$id_vari;?>_1.php','contenidos')
							
									
								</script>
							<?
				
				

}
/*******************************************************************************************************************************/
//CONFIGURACION Y ANEXO AL PROCESO CRITERIOS JURIDICOS
/*******************************************************************************************************************************/


if($accion=="activa_campo_subasta")
	{
	$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
	echo "insert into $t93 (in_id, evaluador3_termino,  evaluador3_valor  ) value ($id_invitacion,4,$valor_campo)";
		$borra_anetrios = query_db("delete from $t93 where in_id = $id_invitacion and evaluador3_termino=4 and peso_evaluacion = $id_lista");
		$inserta_campo_subasta = query_db("insert into $t93 (in_id, evaluador3_termino,  evaluador3_valor,peso_evaluacion  ) value ($id_invitacion,4,$valor_campo, $id_lista)");
		?>
        	<script>
				alert("La subasta se activo con éxito")
			</script>
        <?
		
	}

if($accion=="activa_campo_subasta_consolidada")
	{
	$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$borra_anetrios = query_db("delete from $t93 where in_id = $id_invitacion and evaluador3_termino=10 ");
		if($activa_subasta==10)
		$inserta_campo_subasta = query_db("insert into $t93 (in_id, evaluador3_termino,  evaluador3_valor  ) value ($id_invitacion,10,0)");
		?>
        	<script>
				alert("La subasta consolidada se activo con éxito")
			</script>
        <?
		
	}

/*******************************************************************************************************************************/
//EVALUACION JURIDICA
/*******************************************************************************************************************************/

if($accion=="evaluacion_juridica")
	{
	$estado_p="";
	$estado_n="";
		foreach($_POST["evaluacion_juridica"] as $id_evaluacion_enviada => $valor_obtenido)
		{//recorre la evaluacion obtenida
			
			if($valor_obtenido!=0){//si fue calificado
			
				$busca_exite = traer_fila_row(query_db("select * from $t96  where evaluador1_id = $id_evaluacion_enviada and pv_id = $pv_id"));
				if($busca_exite[0]>=1){				
				$cambia_resultado = "update $t96 set resultado_evaluacion = $valor_obtenido where evaluador1_id = $id_evaluacion_enviada and pv_id = $pv_id";
				$sql_ex = query_db($cambia_resultado);
				}
				else
					{
						echo "insert into (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones, evaluador6_fecha, resultado_evaluacion, resultado_evaluacion_afectado) values ($pv_id,$id_evaluacion_enviada, '',0,'','','',$valor_obtenido, '' )";
						$insertar = query_db("insert into $t96 (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones, evaluador6_fecha, resultado_evaluacion, resultado_evaluacion_afectado) values ($pv_id,$id_evaluacion_enviada, '',0,'','','',$valor_obtenido, '' )");
					
					}
				
				if($valor_obtenido==2)
				$estado_n+=1;
				
			}//si fue calificado
			elseif($valor_obtenido==0)
				$estado_p+=1;
			
			
			
		}//recorre la evaluacion obtenida
		
		echo $estado_n;
			if($estado_p>=1)
				$resultado_evaluacion = "pendiente de evaluación";
			elseif($estado_n>=1)	
				$resultado_evaluacion = "No Cumple";
			else
				$resultado_evaluacion = "Cumple";
				
				
			 $busca_evaluacion = "select * from $t13 where proc1_id = $id_invitacion_juri and pv_id = $pv_id";
			$busca_hist = traer_fila_row(query_db($busca_evaluacion));

			if($busca_hist[0]>=1)
				$cambia_evaluacion = query_db("update $t13 set resultado_juridico = '$resultado_evaluacion', observaciones_juridicas= '$obse_juridico' where evaluador10_id = $busca_hist[0]");
			else
				$cambia_evaluacion = query_db("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones)
				values ($id_invitacion_juri, $pv_id, '$resultado_evaluacion', '$obse_juridico', '','',0,'','', '' )");				
		
			?>
            
            <script>
				alert("La evaluación se realizo con éxito");
				window.parent.ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_juridica.php?pasa=<?=arreglo_pasa_variables($id_invitacion_juri);?>','carga_resultados_principales')
			</script>
            
            <?

}

/*******************************************************************************************************************************/
//EVALUACION JURIDICA
/*******************************************************************************************************************************/


/*******************************************************************************************************************************/
//EVALUACION TECNICA
/*******************************************************************************************************************************/

if($accion=="evaluacion_tecnica")
	{
	$estado_p="";
	$estado_n="";
		foreach($_POST["evaluacion_tecnica"] as $id_evaluacion_enviada => $valor_obtenido)
		{//recorre la evaluacion obtenida
			
			if($valor_obtenido!=0){//si fue calificado
			$separa_id_evaluacion_enviada = explode("_",$id_evaluacion_enviada);
			
			$id_criterio = $separa_id_evaluacion_enviada[0];
			$valor_categoria = $separa_id_evaluacion_enviada[1];
			$valor_criterio = $separa_id_evaluacion_enviada[2];
			
			
			$participacion_criterio = ( ($valor_criterio*$valor_obtenido) / 100 );
			
			//echo $id_evaluacion_enviada." ".$participacion_criterio." ".$valor_obtenido."<br>";
				
				$busca_exite = traer_fila_row(query_db("select * from $t96  where evaluador1_id = $id_criterio and pv_id = $pv_id"));
				if($busca_exite[0]>=1){			
				
					$cambia_resultado = "update $t96 set resultado_evaluacion = $valor_obtenido , resultado_evaluacion_afectado = '$participacion_criterio' where evaluador1_id = $id_criterio and pv_id = $pv_id";
					$sql_ex = query_db($cambia_resultado);
					}
				else
					{
						echo "insert into $t96 (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones, evaluador6_fecha, resultado_evaluacion, resultado_evaluacion_afectado) values ($pv_id,$id_evaluacion_enviada, '',0,'','','','$valor_obtenido', '$participacion_criterio' )";
						$insertar = query_db("insert into $t96 (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones, evaluador6_fecha, resultado_evaluacion, resultado_evaluacion_afectado) values ($pv_id,$id_criterio, '',0,'','','','$valor_obtenido', '$participacion_criterio' )");
					
					}
					
			}//si fue calificado
			elseif($valor_obtenido==0)
				$estado_p+=1;
			
			
			
		}//recorre la evaluacion obtenida
		
		
			if($estado_p>=1){
				$resultado_evaluacion = "pendiente de evaluación";
				
				
				
			$busca_evaluacion = "select * from $t13 where proc1_id = $id_invitacion_juri and pv_id = $pv_id";
			$busca_hist = traer_fila_row(query_db($busca_evaluacion));
			
			if($busca_hist[0]>=1)
				$cambia_evaluacion = query_db("update $t13 set resultado_tecnico  = '$resultado_evaluacion', observaciones_tecnico = '$obse_juridico' where evaluador10_id = $busca_hist[0]");
			else
				$cambia_evaluacion = query_db("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones)
				values ($id_invitacion_juri, $pv_id, '', '', '$resultado_evaluacion','$obse_juridico',0,'','', '' )");				
		
			?>
            
            <script>
				alert("La evaluación se realizo con éxito");
				window.parent.ajax_carga('../aplicaciones/evaluacion/evaluacion_tecnica.php?id_invitacion=<?=$id_invitacion_juri;?>&pv_id=<?=$pv_id;?>&calca=1','carga_evaluacion')				
			</script>
            
            <?
			
				}
			else{
				$resultado_evaluacion = "1";
			$busca_evaluacion = "select * from $t13 where proc1_id = $id_invitacion_juri and pv_id = $pv_id";
			$busca_hist = traer_fila_row(query_db($busca_evaluacion));
			
			if($busca_hist[0]>=1)
				$cambia_evaluacion = query_db("update $t13 set resultado_tecnico  = '', observaciones_tecnico = '$obse_juridico' where evaluador10_id = $busca_hist[0]");
			else
				$cambia_evaluacion = query_db("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones)
				values ($id_invitacion_juri, $pv_id, '', '', '','$obse_juridico',0,'','', '' )");				
						
			?>
            
            <script>
				alert("La evaluación se realizo con éxito");
				window.parent.ajax_carga('../aplicaciones/evaluacion/evaluacion_tecnica.php?id_invitacion=<?=$id_invitacion_juri;?>&pv_id=<?=$pv_id;?>&calca=1','carga_evaluacion')
				
			</script>
            
            <?				
				
				}			

}

/*******************************************************************************************************************************/
//EVALUACION TECNICA
/*******************************************************************************************************************************/


if($accion=="volver_publica")
	{
	
		$cambia = query_db("update $t15 set publica = 1 where pro7_id = $id_elimina")

		?>
      <script>
		alert("La aclaración se modifico con éxito")
		window.parent.ajax_carga('cartelera-aclaraciones_<?=$id_invitacion;?>.php','contenidos');
	</script>

          <?
	
	}

if($accion=="volver_privada")
	{
	
		$cambia = query_db("update $t15 set publica = 0 where pro7_id = $id_elimina")

		?>
      <script>
		alert("La aclaración se modifico con éxito")
		window.parent.ajax_carga('cartelera-aclaraciones_<?=$id_invitacion;?>.php','contenidos');
	</script>

          <?
	
	}

if($accion=="crea_pregunta_general_foro")
	{
	
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		$cambia = query_db("insert into  $t16 (pro7_id,tipo_preg_respuesta ,us_id ,pv_id ,fecha_foro ,foro ,publica) 
		values ($id_elimina, 2, ".$_SESSION["id_us_session"].", 0,'$fecha $hora', '".$_POST["p_foro_".$id_elimina]."',1 )");
		
		$busca_pregunta_sie_publica = traer_fila_row(query_db("select * from pro7_cartelera where pro7_id = $id_elimina "));
		if( ($busca_pregunta_sie_publica[6]==0) && ( $busca_pregunta_sie_publica[7]==1) ){
			$busca_proveedor = explode("|",$busca_pregunta_sie_publica[2]);
			$complemto_p=" and $t8.pv_id = $busca_proveedor[0] ";
			$complemto_c=" and pv_id = $busca_proveedor[0] ";
			}
		if( ($busca_pregunta_sie_publica[6]==0) && ($busca_pregunta_sie_publica[7]==2)){
			$busca_proveedor = str_replace("|",",",$busca_pregunta_sie_publica[2]);
			$complemto_p=" and $t8.pv_id in ($busca_proveedor 0) ";
			$complemto_c=" and pv_id  in ($busca_proveedor 0) ";
			}
			
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
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

		
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id $complemto_p");
		
				while($lp = traer_fila_row($busca_provee)){
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					alertas_bitacora(1,$id_invitacion,$lp[0],"Respuesta en la cartelera de aclaraciones / notificaciones",0);
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);		
			
			}
			
			/****envio de correo a los contactos*/
			
				$busca_provee = query_db("select $t30.email_contacto, $t8.razon_social, $t8.email  from $t30,$t8 where
					$t30.pro1_id =  $id_invitacion and  $t8.pv_id = $t30.pv_id $complemto_p");
		
				while($lp = traer_fila_row($busca_provee)){
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			envia_correos($lp[0],$asunto,$mensaje_envio,$cabesa);		
			
			}
			/****envio de correo a los contactos*/
			
			
			
			
		
		?>
      <script>
		alert("La aclaración se envio con éxito")
		window.parent.ajax_carga('cartelera-aclaraciones_<?=$id_invitacion;?>.php','contenidos');
	</script>

          <?
	
	}	

if($accion=="crea_pregunta_general_admin")
	{
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		
		foreach($pv_id_carte as $id_pro){
			$pv_id_p_c.=$id_pro."|";
			$pv_id_p_corr.=$id_pro.",";
			}
	
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		$cambia = query_db("insert into  $t15 (pro1_id ,pv_id ,fecha_pregunta ,pregunta ,us_id ,publica,tipo_aclaracion,tipo_aclaracio,fecha_maxima_respuesta) 
		values ($id_invitacion, '".$pv_id_p_c."','$fecha $hora', '$pregunta_general',".$_SESSION["id_us_session"].",0,2,2,'$h_m_r' )");
		
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 6"));
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp5,$sql_e[5],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('--consecutivo---', $sql_e[22], $id_subastas_arrglo);

		
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t8.pv_id in ($pv_id_p_corr 0)");
		
				while($lp = traer_fila_row($busca_provee)){
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					alertas_bitacora(2,$id_invitacion,$lp[0],"Nueva notificación",0);
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			//echo $lp[4]."<br>".$mensaje_envio;
			
			envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);		
			
			}
			
			/****envio de correo a los contactos*/
			
				$busca_provee = query_db("select $t30.email_contacto, $t8.razon_social, $t8.email  from $t30,$t8 where
					$t30.pro1_id =  $id_invitacion and  $t8.pv_id = $t30.pv_id $complemto_p");
		
				while($lp = traer_fila_row($busca_provee)){
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			envia_correos($lp[0],$asunto,$mensaje_envio,$cabesa);		
			
			}
			/****envio de correo a los contactos*/
			
		
		?>
      <script>
		alert("La aclaración se envio con éxito")
		window.parent.ajax_carga('cartelera-aclaraciones_<?=$id_invitacion;?>.php','contenidos');
	</script>

          <?
	
	}



if($accion=="Guardar_formula")
	{
	
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));


		$select_formula = traer_fila_row(query_db("select * from $t18 where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula = $tipo_formula "));
		
	if($tipo_formula==1){		
		if($select_formula[0]>=1)
			{
				$update = query_db("update $t18 set formula='$formula_1' ,nombre='$nombre_formula' ,min='$formula_2' ,max='$formula_3' where pro10_id = $select_formula[0]");
			
			}
		else
			{

					$update = query_db("insert into $t18 (pro1_id, formula,nombre, min, max, tipo_formula, pro11_id )values ($id_invitacion, '$formula_1','$nombre_formula','$formula_2','$formula_3', $tipo_formula, $id_lista )");
			
			}
		
		}
	else
	{
	
	if($select_formula[0]>=1)
			{
				$update = query_db("update $t18 set formula='$formula_4' ,nombre='$nombre_formula2' ,min='0' ,max='0' where pro10_id = $select_formula[0]");
			
			}
		else
			{

					$update = query_db("insert into $t18 (pro1_id, formula,nombre, min, max, tipo_formula, pro11_id )values ($id_invitacion, '$formula_4','$nombre_formula2','0','0', $tipo_formula, $id_lista )");
			
			}
	
	}
		if($id_lista!=0)
			$ruta = "configuracion_criteriosec_".$id_vari."_".$id_lista.".html";
		else
			$ruta = "configuracion_formulas_".$id_invitacion.".html";
		
		?>
      <script>
		alert("La formula se guardo con éxito")
		window.parent.ajax_carga('<?=$ruta;?>','contenidos');
	</script>

          <?
	
	}	
	
	
if($accion=="elimina_formula")
	{

			$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));


				$update = query_db("delete from $t18  where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula = $tipo_formula ");
		
		  
if($id_lista!=0)
			$ruta = "configuracion_criteriosec_".$id_vari."_".$id_lista.".html";
		else
			$ruta = "configuracion_formulas_".$id_invitacion.".html";
		
		?>
      <script>
		alert("La formula se elimino con éxito")
		window.parent.ajax_carga('<?=$ruta;?>','contenidos');
	</script>

          <?		  
	
	}		


if($_POST["accion"]=="crear_lista")
	{
	
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		echo $inserta_procesos="insert into $t19 (pro1_id,nombre )
		values ($id_invitacion, '$nombre_lista')";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){
		
		
		?>
        <script> 
		alert("El proceso se creó con éxito")
		window.parent.ajax_carga('configuracion_criteriosec_<?=$id_vari;?>_<?=$id_p;?>.html','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
		alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
        </script>
		<?
		
		
		}
	
	}
	
	
if($_POST["accion"]=="editar_lista")
	{
	
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		echo $inserta_procesos="update $t19 set nombre = '$edita_lista', requiere_aui = $requiere_aui where pro11_id = $id_lista ";
		$sql_e = query_db($inserta_procesos);
		?>
        <script> 
		alert("El proceso se edito con éxito")
		window.parent.ajax_carga('configuracion_criteriosec_<?=$id_vari;?>_<?=$id_lista;?>.html','contenidos');
		</script>
        <?
		
		
	}	
	
if($_POST["accion"]=="elimina_lista")
	{
	
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		$inserta_procesos="delete from $t19 where pro11_id = $id_lista ";
		$sql_e = query_db($inserta_procesos);

		$update = query_db("delete from $t18  where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula = $tipo_formula ");
		
		auditor(28,$id_invitacion,"","");
		
		?>
        <script> 
		alert("El proceso se edito con éxito")
		window.parent.ajax_carga('configuracion_criteriosec_<?=$id_vari;?>_<?=$id_lista;?>.html','contenidos');
		</script>
        <?
		
		
	}		



	if($_POST["accion"]=="adjudica_proceso")
	
	{
			$id_invitacion_pasa_original = $id_invitacion_pasa;
			$id_invitacion_pasa = elimina_comillas(arreglo_recibe_variables($id_invitacion_pasa));

	
	/*	foreach($proveedores_sele as $id_proveedor){
			$id_proveedor_seleccionado.=",".$id_proveedor;
		}
		*/
	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion_pasa and $t8.pv_id = $t7.pv_id ");
				while($lp = traer_fila_row($busca_provee))
				$id_proveedor_seleccionado.=",".$lp[0];	
		
		$id_proveedor_seleccionado = "0".$id_proveedor_seleccionado;
		
		if($b==10){// si es dupicacioon
		$cuenta_duplicidades = traer_fila_row(query_db("select count(*) from $t5 where origen_duplicidad = $id_invitacion_pasa"));
		$incremento = ($cuenta_duplicidades[0]+1);

echo		$insert_duli_principal = "insert into $t5 (select '',2,	tp2_id,	tp3_id,	tp4_id,	tp5_id,	cd_id_ejecucion,	cd_id_entrega_documentos,	direccion_entrega_documentos,	cd_id_entrega_ofertas,	direccion_entrega_ofertas,	tp6_id,	detalle_objeto,	tp7_tipo_moneda,	cuantia,	us_id_contacto,	fecha_publicacion,	fecha_apertura,	fecha_cierre,	peso_tecnico,	minimo_tecnico_solicitado,	peso_economico,	concat(consecutivo,' DU - ', $incremento),	apertura_juridica,	cierre_juridica,	apertura_tecnica,	cierre_tecnica,	apertura_economica,	cierre_economica,	fecha_informativa,	lugar,	'0',	fecha_creacion,	us_id,	fecha_informativa_final,	fecha_aclaraciones_2_inicial,	fecha_aclaraciones_2_final,	fecha_aclaraciones_3_inicial,	fecha_aclaraciones_3_final,	fecha_preconomica_inicial,	fecha_preconomica_final,	nueva_fecha_informativa,	trm_actual, $id_invitacion_pasa from $t5
		 where pro1_id = $id_invitacion_pasa)";
		$sql_ex=query_db($insert_duli_principal);
		$id_p = id_insert();
		if($id_p>=1){//si el registro principal se duplico
		
		$duplica_proveedores=query_db("insert into $t7 (select '', $id_p,	pv_id,lectura_proceso,aceptacion_participacion,	estado,observaciones,observaciones_2 from $t7 where pro1_id = $id_invitacion_pasa and pv_id in ($id_proveedor_seleccionado))");
		$duplica_lista_ofertas = query_db("insert into evaluador_economica_proveedor  (select '', t1.evaluador5_id , evaluador4_id  ,pv_id  ,w_valor  ,w_fecha_creacion  ,w_fecha_modifica  ,'$id_p nuevo' from evaluador_economica_proveedor t1, evaluador5_listaarticulos t2 where t2.in_id = $id_invitacion_pasa and t1.evaluador5_id  = t2.evaluador5_id and t1.pv_id in ($id_proveedor_seleccionado) )");
		$duplica_lista_ofertas_historicas = query_db("insert into evaluador_economica_proveedor_historico   (select '', t1.evaluador5_id , evaluador4_id  ,pv_id  ,w_valor  ,w_fecha_creacion  ,w_fecha_modifica  ,'$id_p nuevo' from evaluador_economica_proveedor_historico t1, evaluador5_listaarticulos t2 where t2.in_id = $id_invitacion_pasa and t1.evaluador5_id  = t2.evaluador5_id and t1.pv_id in ($id_proveedor_seleccionado) )");

		$duplica_listas = query_db("select * from pro11_listas_economicas where pro1_id = $id_invitacion_pasa");
			while($busca_lista=traer_fila_row($duplica_listas))
				{
					$inserta_lista = query_db("insert into pro11_listas_economicas (pro1_id, nombre) values($id_p, '$busca_lista[2]')");
					$id_lista = id_insert();
					$duplica_formulas=query_db("insert into pro10_formulas  (select '', $id_p,  formula  ,nombre  ,min  ,max  ,tipo_formula , $id_lista  from pro10_formulas  where pro1_id = $id_invitacion_pasa and  pro11_id=$busca_lista[0])");

					
					$busca_campos = query_db("select * from evaluador4_campos where in_id  = $id_invitacion_pasa and pro11_id  = $busca_lista[0]");
						while($lista_campos=traer_fila_row($busca_campos)){//busca campos de la anterior
							$copia_campos=query_db("insert into evaluador4_campos (in_id,  evaluador4_nombre , evaluador4_tipo , orden_aparacion , pro11_id  ) values 
							($id_p, '$lista_campos[2]', '$lista_campos[3]', '$lista_campos[4]', $id_lista )");
							$id_campo = id_insert();
							$cambia_campo_ofertas=query_db("update evaluador_economica_proveedor set evaluador4_id = $id_campo where oferta = '$id_p nuevo' and evaluador4_id = $lista_campos[0]");
							$cambia_campo_ofertas_historico=query_db("update evaluador_economica_proveedor_historico set evaluador4_id = $id_campo where oferta = '$id_p nuevo' and evaluador4_id = $lista_campos[0]");
							$cambia_formulas=query_db("update pro10_formulas set formula = replace(formula, 'b".$lista_campos[0]."','b".$id_campo."')  where pro1_id  = $id_p and pro11_id  = $id_lista");
							$cambia_formulas=query_db("update pro10_formulas set min = $id_campo where pro1_id  = $id_p and pro11_id  = $id_lista and min = $lista_campos[0] ");
							$cambia_formulas=query_db("update pro10_formulas set max = $id_campo where pro1_id  = $id_p and pro11_id  = $id_lista and max = $lista_campos[0] ");
							}//busca campos de la anterior


					$busca_lista_articulos = query_db("select * from evaluador5_listaarticulos  where in_id  = $id_invitacion_pasa and pro11_id  = $busca_lista[0]");
						while($lista_articulos=traer_fila_row($busca_lista_articulos)){//busca campos de la anterior
							$copia_campos=query_db("insert into evaluador5_listaarticulos (in_id  ,evaluador5_codigo  ,evaluador5_detalle  ,evaluador5_unidad  ,evaluador5_cantidad  ,evaluador5_moneda  ,evaluador5_valor  ,evaluador5_presupuesto  ,pro11_id  ) values 
							($id_p, '$lista_articulos[2]', '$lista_articulos[3]', '$lista_articulos[4]','$lista_articulos[5]', '$lista_articulos[6]','$lista_articulos[7]', '$lista_articulos[8]',$id_lista )");
							$id_lista_articulos = id_insert();
							$cambia_lista_ofertas=query_db("update evaluador_economica_proveedor set evaluador5_id  = $id_lista_articulos, oferta = 1 where oferta = '$id_p nuevo' and evaluador5_id = $lista_articulos[0]");
							$cambia_lista_ofertas_historico=query_db("update evaluador_economica_proveedor_historico set evaluador5_id  = $id_lista_articulos, oferta = 1 where oferta = '$id_p nuevo' and evaluador5_id = $lista_articulos[0]");

							}//busca campos de la anterior



				}
		$cambia_estado_origen=query_db("update $t5 set tp1_id = $b where pro1_id = $id_invitacion_pasa ");
		}//si el registro principal se duplico
		
		}// si es dupicacioon
		else
			{
				$cambia_estado_origen=query_db("update $t5 set tp1_id = $b where pro1_id = $id_invitacion_pasa ");

			
			}			
		
		
	}		

if($_POST["accion_apertura"]=="graba_apertura")
	{
	
		$id_vari=$id_invitacion_apertura;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		
		if($cuantia_pasa>=100000)
			$usuario_firma_gere= "Hugo Fernando Molina Pedroza";
		
				if($responsable_pro==603)
					$usuario_firma= "Viviana Ramirez Medina";
				elseif($responsable_pro==620)
					$usuario_firma= "Viviana Ramirez Medina";
				elseif($responsable_pro==619)
					$usuario_firma= "Viviana Ramirez Medina";
				elseif($responsable_pro==618)
					$usuario_firma= "Viviana Ramirez Medina";
				elseif($responsable_pro==621)
					$usuario_firma= "Javier Acosta";
				elseif($responsable_pro==580)
					$usuario_firma= "Javier Acosta";
				else
					$usuario_firma= "Viviana Ramirez Medina";					
		
		

		$inserta_procesos=query_db("insert into pro12_apertura_proceso (pro1_id, us_auditor, us_comprador, us_usuario, fecha_apertura, hora_apertura, lugar_apertura, estado)
		values ($id_vari,".$_SESSION["id_us_session"].",$responsable_pro,'$usuario_firma','$fecha','$hora','$usuario_firma_gere',1 )");
		$sql_e = query_db($inserta_procesos);

		foreach($proponente as $id_proveedor => $observaciones)
			{
				$observaciones = query_db("update pro3_invitaciones set observaciones = '$observaciones' where pro1_id = $id_vari and pv_id = $id_proveedor ");
			
			}

		foreach($v_proponente as $id_proveedor_v => $observaciones_2)
			{
				$observaciones = query_db("update pro3_invitaciones set observaciones_2 = '$observaciones_2' where pro1_id = $id_vari and pv_id = $id_proveedor_v ");
			
			}

		
		?>
        <script> 
		alert("El proceso se grabo con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_vari;?>','contenidos');
		</script>
        <?
		
		
	}	

if($_POST["accion"]=="confirma_acta_apertura")
	{
	
		$id_vari=$id_invitacion_pasa;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		$inserta_procesos="update pro12_apertura_proceso set estado = 1 where pro1_id=$id_invitacion";
		$sql_e = query_db($inserta_procesos);
	
		
		?>
        <script> 
		alert("El proceso se abrio con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
		
	
	}


if($accion=="crea_bitacora")
	{
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		
		$cambia = query_db("insert into  $t26 (pro1_id,pv_id,us_id, fecha_hora_gestion,detalle_gestion,proxima_llamada,tp14_id) 
		values ($id_invitacion,".$pv_id_b.",".$_SESSION["id_us_session"].",'$fecha $hora', '$pregunta_general','$h_m_r', $efectividad_bita )");
		
		if($nombre_contacto!="")
			$inserta_contacto=query_db("insert into $t30 (pro1_id, pv_id, nombre_contacto, email_contacto, telefono_contacto) values (
			$id_invitacion, $pv_id_b, '$nombre_contacto','$email_contacto', '$telefono_contacto') ");
			
		foreach($alerta_pendientes as $id_alerta_bitacora => $valor)
			{
				if($valor==2)
					$cambia_estado_alerta=query_db("update $t29 set estado = 2, quien_ingresa='Mesa ayuda' where pro18_id = $id_alerta_bitacora");
			
			}	
		
		?>
      <script>
		alert("La bitácora se creo con éxito")
		window.parent.ajax_carga('../aplicaciones/c_bitacora.php?id_invitacion_pasa=<?=$id_invitacion;?>&pv_id_b=<?=$pv_id_b;?>','contenidos');
	</script>

          <?
	
	}

if($accion=="crea_pregunta_aclaracion_final")
	{
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion_pasa);
		
		foreach($pv_id_carte as $id_pro){// busca proveedor for
			
			
		$cambia = query_db("insert into  $t27 (pro1_id ,pv_id ,us_id, fecha_solicitud,fecha_limite_respuesta, objeto, detalle ,leida) 
		values ($id_invitacion_ar, '".$id_pro."',".$_SESSION["id_us_session"].",'$fecha $hora', '$h_m_r','".elimina_comillas_2($asunto_cartelera)."','".elimina_comillas_2($pregunta_general)."',1 )");
		
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

		
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8 where
				 $t8.pv_id = $id_pro");
		
				$lp = traer_fila_row($busca_provee);
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);

			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			
			
			alertas_bitacora(4,$id_invitacion_ar,$lp[0],"Nueva aclaración final",0);
			
			envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);		
			
/****envio de correo a los contactos*/
			
				$lp = traer_fila_row(query_db("select $t30.email_contacto, $t8.razon_social, $t8.email  from $t30,$t8 where
					$t30.pro1_id =  $id_invitacion_ar and  $t8.pv_id = $t30.pv_id and $t30.pv_id = $id_pro order by pro19_id desc"));
		
				echo "select $t30.email_contacto, $t8.razon_social, $t8.email  from $t30,$t8 where
					$t30.pro1_id =  $id_invitacion_ar and  $t8.pv_id = $t30.pv_id and $t30.pv_id = $id_pro";
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			envia_correos($lp[0],$asunto,$mensaje_envio,$cabesa);		
			
			
			/****envio de correo a los contactos*/
			


		}// busca proveedor for
		?>
      <script>
		alert("La aclaración se envio con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/cartelera_aclaraciones_finales.php?pasa=<?=arreglo_pasa_variables($id_invitacion_ar);?>','carga_resultados_principales');
	</script>

          <?
	
	}


if($accion == "crea_proveedor_adentro")
	{
		
		$verifica_email = comprobar_email($email_contacto);
		if($verifica_email=="0"){
			?>
            	<script>
					alert("Verifique el e-mail")
					 window.parent.document.getElementById("cargando").style.display="none"
					
				</script>
            <?
			exit();
			}
		

		
		$bsca_si_exi=traer_fila_row(query_db("select * from $t8 where nit='$ap'"));

		if($bsca_si_exi[0]>=1){
			?>
            	<script>
					alert("El proveedor ya existe")
					 window.parent.document.getElementById("cargando").style.display="none"
					
				</script>
            <?
			exit();
			}		

$cifra_c=md5("321654");
		
$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
$sel_sql = mssql_select_db($dbbase_sql,$link_sql);

		function id_insert_sql_ser($sql)
                {
				$tra = mssql_fetch_assoc($sql);
				return $tra['SCOPE_IDENTITY'];
                }	


 $alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");

for($i=0;$i<=3;$i++){
$generador = rand(0,34);
$fuente2.= $alfabeto[$generador];
}

if($ap=="")
	$ap = $fuente2;

$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]";
echo $inserta_us = "insert into t1_proveedor (nit, digito_verificacion , razon_social , estado)	values ('$ap', '', '$bp',1)";
$sql_ex=mssql_query($inserta_us.$trae_id_insrte);
$id_ingreso_pro = id_insert_sql_ser($sql_ex);

if($id_ingreso_pro>=1){//si se creo el proveedor

		$cambia_cali="insert into  $t8 (pv_id,cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
		 $id_ingreso_pro,$ciuadad, '$ap', '$bp', '$cp','$email_contacto', '$ep', 1, '$g' )";
		 $sql_ex = query_db($cambia_cali);

$inserta_email_sgpa=mssql_query("insert into t1_proveedor_email (t1_proveedor_id, nombre_responsable, email, tipo, estado) values ($id_ingreso_pro, 
'PRINCIPAL','$email_contacto',1,1)");

	  $inserta_us = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ('$bp', '$email_contacto', '$cifra_c', '$email_contacto', '$ep',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
	$sql_ex_p=mssql_query($inserta_us.$trae_id_insrte);
$id_ingreso_pro_us = id_insert_sql_ser($sql_ex_p);
		
if($id_ingreso_pro_us>=1){//si se creo el usuario		
		 
	  $inserta_us = "insert into $t1 (us_id,nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ($id_ingreso_pro_us,'$bp', '$email_contacto', '$cifra_c', '$email_contacto', '$ep',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
	$sql_e=query_db($inserta_us);

}
	
		 $inserta_procesos="insert into $t7 (pro1_id,pv_id,lectura_proceso,aceptacion_participacion,estado)
		  values (".$id_invitacion_pasa_final.", $id_ingreso_pro,'', 'N/A', 1  )";
		$sql_e = query_db($inserta_procesos);
		 
	?>
	 	<script>
			alert("El registro se creo con éxito")
			//window.parent.volver_listado('muestra_cootactos','carga_detalle_pro')
			window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion_pasa_final;?>','contenidos');
		</script>
	<?

		 
}////si se creo el proveedor
		
		else{ //si no se creo el proveedor
	?>
	 	<script>
			alert("ATENCION: El PROVEEDOR NO SE PUDO CREAR VERIFIQUE QUE NO EXISTA")
			return;
		</script>
	<?		
		
		}	//si no se creo el proveedor
		 


		
		}



?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>



