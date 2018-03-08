<?  include("../lib/@session.php");
include("tarifas_modelos_email.php");
header('Content-Type: text/html; charset=ISO-8859-1');
	verifica_menu("administracion.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php


	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	
	if($_POST["accion"]=="crea_tarifa_manual")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id

			/*verifica si el contrato ya esta en frme o no para porner tipo de creacion*/
			$busca_tarifas = "select t6_tarifas_estados_contratos_id from $t4 where tarifas_contrato_id = $id_contrato_arr";
			$sql_busca_tarifas=traer_fila_row(mssql_query($busca_tarifas));
			if($sql_busca_tarifas[0]==3){
				$tipo_creacion = 2;
				$estado_tarifa = 2;
				}
			else{
				$tipo_creacion = 1;
				$estado_tarifa = 1;
				}
			
			
			

			$insert = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia,tarifa_padre,fecha_fin_vigencia, t6_tarifas_listas_lista_id,tipo_creacion_modifica,us_aprobacion_actual, creada_luego_firme) ";
			 $insert.=  " values ($id_contrato_arr,'".elimina_comillas_2($categoria)."','".elimina_comillas_2($grupo)."','".elimina_comillas_2($codigo_creacion)."','".elimina_comillas_2($detalle_creacion)."', '$unidad_creacion','$cantidad_creacion','$moneda_creacion','$valor_creacion', '$id_us_session','$fecha $hora',$tipo_creacion,$estado_tarifa,'$fecha_vigencia_creacion',0 ,'0000-00-00',$lista_existentes,1,0,1)";
			$sql_ex=mssql_query($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){
			
			$update_pone_padre = mssql_query("update $t3 set tarifa_padre = $id_ingreso where t6_tarifas_lista_id = $id_ingreso");

			$id_log = log_de_procesos_sgpa(5, 46, 72, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Valor", listas_sin_select($g5,$moneda_creacion,1)." ".number_format($valor_creacion,2), "",1);
			log_agrega_detalle ($id_log, "Detalle",elimina_comillas_2($detalle_creacion), "",1);

			foreach($detalle_campo_descriptor as $id_cammpo_descriptor => $valor_campo_descriptor){//for
			
			if($valor_campo_descriptor!=""){//si no esta vacio
			
			echo $inser_descr= "insert into $t14 (t6_tarifas_lista_id, t6_tarifas_atributos_id, detalle) values (".$id_ingreso.", $id_cammpo_descriptor, '".elimina_comillas_2($valor_campo_descriptor)."' )";
			$sql_ex_des=mssql_query($inser_descr);
			
			
			}////si no esta vacio
			
			
			} //fro			


			
			//cambia estado contrato a parcial
			$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = 2 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_contratos_id <> 3");
			
			?>
					<script> 
                    alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    alert("ATENCION:\n *El proceso se NO creó con éxito")
                    </script>
			<?
			}
			
		}


if($_POST["accion"]=="contrato_en_firme")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
			$busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr";
			$id_ingreso=traer_fila_row(mssql_query($busca_categorias));
			if($id_ingreso[0]>=1){
			
			//cambia estado contrato a parcial
			$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = 3 where tarifas_contrato_id = $id_contrato_arr ");
			
			$id_log = log_de_procesos_sgpa(5, 48, 74, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Estado anterior", "Parcial", "",1);
			log_agrega_detalle ($id_log, "Nuevo Estado","En firme", "",1);
			
			
			?>
					<script> 
                    alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','contenidos');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    alert("ATENCION:\n *Para poner el contato en firme debe ingresar por lo menos una tarifa")
                    </script>
			<?
			}
			
		}


if($_POST["accion"]=="contrato_en_parcial_editado")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
			$busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr";
			$id_ingreso=traer_fila_row(mssql_query($busca_categorias));
			$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = 2 where tarifas_contrato_id = $id_contrato_arr ");
			$id_log = log_de_procesos_sgpa(5, 48, 74, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Estado anterior", "En Firme", "",1);
			log_agrega_detalle ($id_log, "Nuevo Estado","Parcial", "",1);
			
			?>
					<script> 
                    alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','contenidos');
                    </script>
			<?
			
			
			
		}		



	if($_POST["accion"]=="modificar_tarifas")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id

			/*verifica si el contrato ya esta en frme o no para porner tipo de creacion*/
			$busca_tarifas = "select t6_tarifas_estados_contratos_id from $t4 where tarifas_contrato_id = $id_contrato_arr";
			$sql_busca_tarifas=traer_fila_row(mssql_query($busca_tarifas));
			if($sql_busca_tarifas[0]==3){//si el contrato ya esta en firma
				$tipo_creacion = 1;
				$estado_tarifa = 3;
			
			
			$busca_tarifa_padre = traer_fila_row(mssql_query("select * from $t3 where t6_tarifas_lista_id = $id_tarifa_arr"));

	


			$insert = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia,tarifa_padre,fecha_fin_vigencia,t6_tarifas_listas_lista_id,tipo_creacion_modifica) ";
			 $insert.=  " values ($id_contrato_arr,'$busca_tarifa_padre[2]','$busca_tarifa_padre[3]','".$_POST["codigo_m_".$id_tarifa_arr]."','".$_POST["detalle_m_".$id_tarifa_arr]."', '".$_POST["unidad_tarifa_".$id_tarifa_arr]."','".$_POST["cantidad_tarifa_".$id_tarifa_arr]."','".$_POST["moneda_tarifa_".$id_tarifa_arr]."','".$_POST["valor_tarifa_".$id_tarifa_arr]."', '$id_us_session','$fecha $hora',$busca_tarifa_padre[12],$estado_tarifa,'".$_POST["vigencia_tarifa_".$id_tarifa_arr]."',$busca_tarifa_padre[15],'0000-00-00',$lista_existentes,2)";
			$sql_ex=mssql_query($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){


		
			foreach($_POST["detalle_campo_descriptor_modifica_".$id_tarifa_arr] as $id_descriptor => $valor_descripto)
					{
					$arreglo_id_descr = explode("-",$id_descriptor);
							echo $inser_descr= "insert into $t14 (t6_tarifas_lista_id, t6_tarifas_atributos_id, detalle) 
							values (".$id_ingreso.", $arreglo_id_descr[1], '".elimina_comillas_2($valor_descripto)."' )";
							$sql_ex_des=mssql_query($inser_descr);
						}				
			
			/****************************/
			//generacion de email para los parobadores
			/****************************/
			
			
			/****************************/
			//generacion de email para los parobadores
			/****************************/
			
			
			?>
					<script> 
                    alert("El proceso se modifico con exito y se notifico a los responsables de aprobacion")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    alert("ATENCION:\n *El proceso se NO creó con éxito")
                    </script>
			<?
			}
			
				}//si el contrato ya esta en firma
			
			
			
		}
		
		

	if($_POST["accion"]=="modificar_tarifas_parcial")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			
			$busca_tarifa_anterior = traer_fila_row(query_db("select detalle, t1_moneda_id, valor from $t3 where t6_tarifas_lista_id = $id_tarifa_arr "));
				
				echo $solo_mofifica = "update $t3 set codigo_proveedor='".$_POST["codigo_m_".$id_tarifa_arr]."', detalle='".elimina_comillas_2($_POST["detalle_m_".$id_tarifa_arr])."', unidad_medida = '".$_POST["unidad_tarifa_".$id_tarifa_arr]."', cantidad='".$_POST["cantidad_tarifa_".$id_tarifa_arr]."', t1_moneda_id = '".$_POST["moneda_tarifa_".$id_tarifa_arr]."', valor='".$_POST["valor_tarifa_".$id_tarifa_arr]."', fecha_inicio_vigencia= '".$_POST["vigencia_tarifa_".$id_tarifa_arr]."' where t6_tarifas_lista_id = $id_tarifa_arr";
				$sql_que = mssql_query($solo_mofifica);	
				
			$id_log = log_de_procesos_sgpa(5, 47, 73, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Valor anterior", listas_sin_select($g5,$busca_tarifa_anterior[1],1)." ".number_format($busca_tarifa_anterior[2],2), "",1);
 		    log_agrega_detalle ($id_log, "Valor nuevo", listas_sin_select($g5,$_POST["moneda_tarifa_".$id_tarifa_arr],1)." ".number_format($_POST["valor_tarifa_".$id_tarifa_arr],2), "",1);
 		    log_agrega_detalle ($id_log, "Detalle anterior", $busca_tarifa_anterior[0], "",1);
 		    log_agrega_detalle ($id_log, "Detalle nuevo", $_POST["detalle_m_".$id_tarifa_arr], "",1);



				foreach($_POST["detalle_campo_descriptor_modifica_".$id_tarifa_arr] as $id_descriptor => $valor_descripto)
					{
					$arreglo_id_descr = explode("-",$id_descriptor);
					
					$busca_descri=traer_fila_row(mssql_query("select * from $t14 where t6_tarifas_listas_valores_atributos_id = $arreglo_id_descr[0]"));
					if($busca_descri[0]>=1){
					echo $busca_valores = "update $t14 set detalle = '".elimina_comillas_2($valor_descripto)."' where t6_tarifas_listas_valores_atributos_id = $arreglo_id_descr[0]";						
					}
					else{
					echo $busca_valores= "insert into $t14 (t6_tarifas_lista_id, t6_tarifas_atributos_id, detalle) 
					values (".$id_tarifa_arr.", $arreglo_id_descr[1], '".elimina_comillas_2($valor_descripto)."' )";


					}
					
					$sql_que_sed = mssql_query($busca_valores);	
						}
			
					?>
					<script> 
                    alert("El registro se modifica con éxito")
					window.parent.ajax_carga('../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato=<?=$id_contrato_arr;?>&lista_existentes=<?=$id_lista;?>&categoria_existentes=<?=$categoria_existentes;?>&grupo_existentes=<?=$grupo_existentes;?>&codigo_ta_b=<?=$codigo_ta_b;?>&detalle_ta_b=<?=$detalle_ta_b;?>&pagina=<?=$pagina;?>','carga_acciones_permitidas')
                    </script>
			<?

			
			
		}		
		

		

		
		
if($_POST["accion"]=="craer_categoria_maestra")
		{



			$insert = "insert into $t8 (nombre, estado) ";
			$insert.=  " values ('".elimina_comillas_2($categoria)."',1)";
			$sql_ex=mssql_query($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){
			
			
			
			?>
					<script> 
                    alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias.php?id_categoria=<?=$id_ingreso;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    alert("ATENCION:\n *El proceso NO se creó")
                    </script>
			<?
			}
			
		}	

if($_POST["accion"]=="craer_descriptor_maestra")
		{



			$insert = "insert into $t9 (t6_tarifas_maestras_categoria_id, t1_tipo_campo_digitacion_id, nombre, estado) ";
			echo $insert.=  " values (".elimina_comillas($id_categoria).",".elimina_comillas($_POST["tipo_campo_".$id_categoria]).", '".elimina_comillas_2($_POST["c_descriptor_".$id_categoria])."',1)";
			$sql_ex=mssql_query($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){
			
			?>
					<script> 
                    alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias.php?id_categoria=<?=$id_categoria;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    alert("ATENCION:\n *El proceso NO se creó")
                    </script>
			<?
			}
			
		}	
	

if($_POST["accion"]=="edita_categoria_descritores_maestra")
		{



			$insert = "update  $t8 set nombre = '".elimina_comillas_2($_POST["categoria_h_".$id_categoria])."' where t6_tarifas_maestras_categoria_id = $id_categoria ";
			$sql_ex=mssql_query($insert);
			
			
			foreach($_POST["detalle_descriptor_h_".$id_categoria] as $id_descritor => $detalle_descriptor)
			{
			if( ($detalle_descriptor!="") && ($_POST["tipo_campo_h_".$id_descritor]!=0) ){//si los descripteres no estan vacios
				echo $uodate_des = "update $t9 set nombre = '$detalle_descriptor', t1_tipo_campo_digitacion_id=".$_POST["tipo_campo_h_".$id_descritor]." where t6_tarifas_maestras_descriptores_id = $id_descritor";
				$sql_up_des = mssql_query($uodate_des);			
				} //si los descripteres no estan vacios
			}
			
			
					
			?>
					<script> 
                    alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias.php?id_categoria=<?=$id_categoria;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}			
					

if($_POST["accion"]=="elimina_descritores_maestra")
		{

				echo $uodate_des = "update $t9 set estado = 2 where t6_tarifas_maestras_descriptores_id = $id_descritor";
				$sql_up_des = mssql_query($uodate_des);			
			
					
			?>
					<script> 
                    alert("El registro se elimino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias.php?id_categoria=<?=$id_categoria;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}	

if($_POST["accion"]=="elimina_categoria_maestra")
		{

				echo $uodate_des = "update $t8 set estado = 2 where t6_tarifas_maestras_categoria_id = $id_categoria";
				$sql_up_des = mssql_query($uodate_des);			
			
					
			?>
					<script> 
                    alert("El registro se elimino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias.php?id_categoria=<?=$id_categoria;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}			



if($_POST["accion"]=="crea_lista_maestra")
		{


			$categoria_busca = explode("----,",$categoria_busca);
			
			$insert = "insert into $t10 (t6_tarifas_maestras_categoria_id,codigo, nombre, descriptor1, descriptor2,descriptor3,descriptor4,estado) ";
			echo $insert.=  " values (".elimina_comillas($categoria_busca[1]).",'".elimina_comillas_2($_POST["codigo_maestro"])."','".elimina_comillas_2($_POST["detalle_lista"])."','".elimina_comillas_2($_POST["grupo_lista"])."','','','',1)";
			$sql_ex=mssql_query($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){
			
			?>
					<script> 
                    alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c2_listas_maestras.php?id_categoria=<?=$categoria_busca[1];?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    alert("ATENCION:\n *El proceso NO se creó")
                    </script>
			<?
			}
			
		}	

if($_POST["accion"]=="edita_lista_maestra")
		{

				echo $uodate_des = "update $t10 set codigo='".elimina_comillas_2($_POST["codigo_".$id_lista])."', nombre='".elimina_comillas_2($_POST["lista_h_".$id_lista])."',descriptor1= '".elimina_comillas_2($_POST["grupo_h_".$id_lista])."' where t6_tarifas_maestras_lista_id = $id_lista";
				$sql_up_des = mssql_query($uodate_des);			
			
				foreach($_POST["campo_digita_".$id_lista] as $id_atributo => $valor_atributo)
					{
						$busca_atributos="select t6_tarifas_maestras_valores_descriptores_id, detalle from $t15 where t6_tarifas_maestras_lista_id =$id_lista and t6_tarifas_maestras_descriptores_id = $id_atributo ";
						$b_sqk=traer_fila_row(mssql_query($busca_atributos));
						if($b_sqk[0]>=1)
							$cambia_atri = mssql_query("update $t15 set detalle = '$valor_atributo' where t6_tarifas_maestras_valores_descriptores_id = $b_sqk[0]");
						else{
							if($valor_atributo!="")
								{
									$in_atr="insert into $t15 (t6_tarifas_maestras_lista_id, t6_tarifas_maestras_descriptores_id, detalle) values ( ";
									$in_atr.="$id_lista, $id_atributo, '$valor_atributo')";
									$ex_i=mssql_query($in_atr);
								
								}
						
						}
					
					}
			
					
			?>
					<script> 
                    alert("El registro se modifico con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c2_listas_maestras.php?id_categoria=<?=$id_categoria;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}	

if($_POST["accion"]=="elimina_lista_maestra")
		{

				$uodate_des = "update $t10 set estado = 2 where t6_tarifas_maestras_lista_id = $id_lista";
				$sql_up_des = mssql_query($uodate_des);			
					
			?>
					<script> 
                    alert("El registro se elimino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c2_listas_maestras.php?id_categoria=<?=$id_categoria;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}


if($_POST["accion"]=="craer_descriptor_tarifas")
		{


			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			
			$insert = "insert into $t13 (tarifas_contrato_id, t6_tarifas_listas_lista_id, t1_tipo_campo_digitacion_id, nombre,estado) ";
			echo $insert.=  " values (".$id_contrato_arr.",".elimina_comillas($_POST["lista_existentes"]).",".elimina_comillas($_POST["tipo_descriptor"]).", '".elimina_comillas_2($_POST["nombre_nuevo_atributo"])."',1)";
			$sql_ex=mssql_query($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){
			
			?>
					<script> 
                    alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    alert("ATENCION:\n *El proceso NO se creó")
                    </script>
			<?
			}
			
		}	


if($_POST["accion"]=="elimina_descritores_tarifas")
		{

				echo $uodate_des = "update $t13 set estado = 3 where t6_tarifas_atributos_id = $id_descriptor";
				$sql_up_des = mssql_query($uodate_des);			
			
					
			?>
					<script> 
                    alert("El registro se elimino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}	

if($_POST["accion"]=="edita_descritores_tarifas")
		{

				echo $uodate_des = "update $t13 set t1_tipo_campo_digitacion_id = '".$_POST["tipo_descriptor_edita_".$id_descriptor]."', nombre = '".$_POST["nombre_nuevo_atributo_edita_".$id_descriptor]."' where t6_tarifas_atributos_id = $id_descriptor";
				$sql_up_des = mssql_query($uodate_des);			
			
					
			?>
					<script> 
                    alert("El registro se elimino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}			

if($_POST["accion"]=="copiar_descritores_tarifas")
		{
		
		 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id

		echo $destino_lista."rene";
		if($destino_lista==1)
			{ //si se copia la lista en el mismo contrato
				
				$copia_lista = "insert into $t12 (tarifas_contrato_id, nombre) values ($id_contrato_arr, '".elimina_comillas_2($_POST["nuevo_nombre_lista_re"])."')";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){// si la nueva lista se creo
				
				$busca_atributos_ex = mssql_query("select * from $t13 where t6_tarifas_listas_lista_id = ".elimina_comillas($_POST["id_lista"]));
				while($atr_l=traer_fila_row($busca_atributos_ex)){//while atributos
				
					$insert = "insert into $t13 (tarifas_contrato_id, t6_tarifas_listas_lista_id, t1_tipo_campo_digitacion_id, nombre,estado) ";
					echo $insert.=  " values (".$id_contrato_arr.",".$id_ingreso.",".$atr_l[3].", '".$atr_l[4]."',1)";
				
				$sql_ex=mssql_query($insert);
				}//while atributos
				
				}// si la nueva lista se creo
				
			
			} //si se copia la lista en el mismo contrato


		if($destino_lista==2)
			{ //si se copia la lista a otro contrato
				
				$contrato_busca = explode("----,",$tarifas_busca_contratos);
				
				$copia_lista = "insert into $t12 (tarifas_contrato_id, nombre) values ($contrato_busca[1], '".elimina_comillas_2($_POST["nuevo_nombre_lista_re"])."')";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){// si la nueva lista se creo
				
				$busca_atributos_ex = mssql_query("select * from $t13 where estado = 1 and t6_tarifas_listas_lista_id = ".elimina_comillas($_POST["id_lista"]));
				while($atr_l=traer_fila_row($busca_atributos_ex)){//while atributos
				
					$insert = "insert into $t13 (tarifas_contrato_id, t6_tarifas_listas_lista_id, t1_tipo_campo_digitacion_id, nombre,estado) ";
					echo $insert.=  " values (".$contrato_busca[1].",".$id_ingreso.",".$atr_l[3].", '".$atr_l[4]."',1)";
				
				$sql_ex=mssql_query($insert);
				}//while atributos
				
				}// si la nueva lista se creo
				
			
			} //si se copia la lista a otro contrato


			
					
			?>
					<script> 
                    alert("La lista se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}	



if($_POST["accion"]=="modificar_lista_tarifas_lista")
		{

				echo $uodate_des = "update $t12 set nombre = '".elimina_comillas_2($_POST["modifica_nomre"])."' where t6_tarifas_listas_lista_id = $lista_existentes";
				$sql_up_des = mssql_query($uodate_des);			
			
					
			?>
					<script> 
                    alert("El registro se modifico con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?
		
			
		}	
		
		
if($_POST["accion"]=="crear_lista_tarifas_lista")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
				$copia_lista = "insert into $t12 (tarifas_contrato_id, nombre) values ($id_contrato_arr, '".elimina_comillas_2($_POST["nueva_lista_lista"])."')";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
			$id_log = log_de_procesos_sgpa(5, 46, 71, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Creación", "Nueva lista", "",1);
 		    log_agrega_detalle ($id_log, "Nombre de la lista", $_POST["nueva_lista_lista"], "",1);

					
			?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$id_ingreso;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    alert("La lista NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}			

if($_POST["accion"]=="crea_descuentos")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
				echo $copia_lista = "insert into $t2 (tarifas_contrato_id, us_id,fecha_creacion,observaciones,archivo,estado) values ($id_contrato_arr, ".$_SESSION["id_us_session"].",'$fecha $hora', '".$_POST["descuento_detalle"]."','$anexo_descuento_name',1)";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
			if($anexo_descuento!="")
				carga_archivo($anexo_descuento,"tarifas_descuentos/".$id_ingreso)
					
			?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_descuentos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    alert("El registro NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}		

if($_POST["accion"]=="crea_anexos_tarifas")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
				echo $copia_lista = "insert into t6_tarifas_anexos(tarifas_contrato_id, us_id,fecha_creacion,observaciones,archivo,estado) values ($id_contrato_arr, ".$_SESSION["id_us_session"].",'$fecha $hora', '".$_POST["descuento_detalle"]."','$anexo_descuento_name',1)";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
			if($anexo_descuento!="")
				carga_archivo($anexo_descuento,"tarifas_anexos/".$id_ingreso)
					
			?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_documentos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    alert("El registro NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}	
		
		
		

if($_POST["accion"]=="crea_suplentes_tarifas")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
				$cambia_suple = mssql_query("update t6_tarifas_suplentes_aprobadores set  estado = 2 where tarifas_contrato_id = $id_contrato_arr and tipo_suplencia = $roll_suplente");
				$copia_lista = "insert into t6_tarifas_suplentes_aprobadores(t7_contratos_contactos_id,tarifas_contrato_id,us_id,fecha_suplencia,permanente,tipo_suplencia,estado)
				 values (0, $id_contrato_arr,$usuario_suplente, '".$fecha_inicial."',1,$roll_suplente,1)";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
			
					
			?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_suplentes.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    alert("El registro NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}	
		

if($_POST["accion"]=="elimina_suplentes_tarifas")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
				$cambia_suple = mssql_query("update t6_tarifas_suplentes_aprobadores set  estado = 2 where t6_tarifas_suplentes_aprobadores_id = $id_suplente");
			
			
					
			?>
					<script> 
                    alert("El registro se elimino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_suplentes.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
	
		}						
		
		
if($_POST["accion"]=="crea_reembolsable")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
				$update_ree = mssql_query("update $ta22 set estado = 2 where t6_tarifas_contratos_id = $id_contrato_arr");
				
				echo $copia_lista = "insert into $ta22 (t6_tarifas_contratos_id,porcentaje_administracion,us_creacion,fecha_creacion,estado) values 
				($id_contrato_arr, $reembolsable_por, ".$_SESSION["id_us_session"].",'$fecha $hora', 1)";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
				
			?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_reembolsables.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    alert("El registro NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}				

if($_POST["accion"]=="edita_categoria")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			echo $query_ca = "update $t3 set categoria = '".elimina_comillas_2($_POST["categoria_nueva_".$id_nombre_edita])."' where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes and categoria = '".elimina_comillas_2($_POST["categoria_actual_".$id_nombre_edita])."'";
			 $update_ree = mssql_query($query_ca);
				
		?>
					<script> 
                    alert("El registro se modifica con éxito")
					window.parent.ajax_carga('../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato=<?=$id_contrato_arr;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas')
                    </script>
			<?
	
			
		}	
		
if($_POST["accion"]=="edita_grupo")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
				echo $_POST["nueva_categoria_grupo_".$id_nombre_edita];
				
				if($_POST["nueva_categoria_grupo_".$id_nombre_edita]!="") $complemento_sql = " ,categoria='".elimina_comillas_2($_POST["nueva_categoria_grupo_".$id_nombre_edita])."' ";
				
				 echo $update_ree = "update $t3 set grupo = '".elimina_comillas_2($_POST["grupo_nueva_".$id_nombre_edita])."' $complemento_sql where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $id_lista and categoria = '".elimina_comillas_2($_POST["categoria_actual_grupo_".$id_nombre_edita])."' and grupo = '".elimina_comillas_2($_POST["grupo_actual_".$id_nombre_edita])."'";
				$sql_grupo=mssql_query($update_ree);

		?>
					<script> 
                    alert("El registro se modifica con éxito")
					window.parent.ajax_carga('../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato=<?=$id_contrato_arr;?>&lista_existentes=<?=$id_lista;?>','carga_acciones_permitidas')
                    </script>
			<?
	
			
		}				

if($_POST["accion"]=="vaciar_lista_tarifas_lista")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$busca_nombre_lista = traer_fila_row(query_db("select * from t6_tarifas_listas_lista where t6_tarifas_listas_lista_id =".$_POST["id_lista"]));
			 
			 $select_tarifas = "select t6_tarifas_lista_id from t6_tarifas_lista where  t6_tarifas_listas_lista_id = ".$_POST["id_lista"];
			 $sql_busca_tarifas=mssql_query($select_tarifas);
			 while($lista_t=traer_fila_row($sql_busca_tarifas)){//busca tarifas para eliminar descriptores
			 
			 	$borra_des="delete from t6_tarifas_listas_valores_atributos where t6_tarifas_lista_id =  ".$lista_t[0];
				$birra_descri= mssql_query($borra_des);
			 
			 
			 } //busca tarifas para eliminar descriptores
				 
				 echo $update_ree = "delete from  t6_tarifas_lista where  t6_tarifas_listas_lista_id = ".$_POST["id_lista"];
				$sql_grupo=mssql_query($update_ree);
				
			$id_log = log_de_procesos_sgpa(5, 53, 80, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Elimina tarifas", "Todas las tarifas de la lista", "",1);
 		    log_agrega_detalle ($id_log, "Nombre de la lista", $busca_nombre_lista[2], "",1);

		?>
					<script> 
                    alert("El registro se modifica con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$id_ingreso;?>','carga_acciones_permitidas');
					
                    </script>
			<?
	
			
		}	


if($_POST["accion"]=="eliminar_lista_tarifas_lista")
		{
		
					$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$busca_nombre_lista = traer_fila_row(query_db("select * from t6_tarifas_listas_lista where t6_tarifas_listas_lista_id =".$_POST["id_lista"]));

			
			 $select_tarifas = "select t6_tarifas_lista_id from t6_tarifas_lista where  t6_tarifas_listas_lista_id = ".$_POST["id_lista"];
			 $sql_busca_tarifas=mssql_query($select_tarifas);
			 while($lista_t=traer_fila_row($sql_busca_tarifas)){//busca tarifas para eliminar descriptores
			 
			 	$borra_des="delete from t6_tarifas_listas_valores_atributos where t6_tarifas_lista_id =  ".$lista_t[0];
				$birra_descri= mssql_query($borra_des);
			 
			 
			 } //busca tarifas para eliminar descriptores
				 
				$update_ree = "delete from  t6_tarifas_lista where  t6_tarifas_listas_lista_id = ".$_POST["id_lista"];
				$sql_grupo=mssql_query($update_ree);

				$update_ree = "delete from  t6_tarifas_listas_lista where  t6_tarifas_listas_lista_id = ".$_POST["id_lista"];
				$sql_grupo=mssql_query($update_ree);
	
			$id_log = log_de_procesos_sgpa(5, 53, 79, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Elimina lista", "Todas las tarifas de la lista", "",1);
 		    log_agrega_detalle ($id_log, "Nombre de la lista", $busca_nombre_lista[2], "",1);


		?>
					<script> 
                    alert("El registro se modifica con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$id_ingreso;?>','carga_acciones_permitidas');
					
                    </script>
			<?
	
			
		}	
		
		
		
if($_POST["accion"]=="crear_proyecto_tarifas")
		{
			
				$id_municipios_arr = elimina_comillas(arreglo_recibe_variables($id_municipios));	
				
				$busca_municipio = traer_fila_row(query_db("select * from t6_tarifas_municipios where t6_tarifas_municipios_id = $id_municipios_arr "));
	
				echo $update_ree = "insert into t6_tarifas_municipios_proyectos (t6_tarifas_municipios_id, proyecto, arreglo) 
				values ($id_municipios_arr,'$proyecto_crea','N/A') ";
				$sql_grupo=mssql_query($update_ree);
				
		
				$id_log = log_de_procesos_sgpa(5, 54, 81, 0, 0, 0);//actualiza general
	 		    log_agrega_detalle ($id_log, "Creación proyecto", $proyecto_crea, "",1);
 			    log_agrega_detalle ($id_log, "Municipio", $busca_municipio[2], "",1);



		?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/admin/m_municipios.php?id_municipios=<?=$id_municipios;?>&lista_existentes=<?=$id_ingreso;?>','contenidos');
					
                    </script>
			<?
	
			
		}			
 
if($_POST["accion"]=="editar_proyecto_tarifas")
		{
			
	$id_municipios_arr = elimina_comillas(arreglo_recibe_variables($id_municipios));
	 	
			$busca_proyecto = traer_fila_row(query_db("select * from t6_tarifas_municipios_proyectos where t6_tarifas_municipios_proyectos_id = $id_proyecto "));
			$busca_municipio = traer_fila_row(query_db("select * from t6_tarifas_municipios where t6_tarifas_municipios_id = $id_municipios_arr "));

				echo $update_ree = "update t6_tarifas_municipios_proyectos set proyecto= '".$_POST["m_proyecto_".$id_proyecto]."' WHERE t6_tarifas_municipios_proyectos_id = $id_proyecto ";
				$sql_grupo=mssql_query($update_ree);
				
				$id_log = log_de_procesos_sgpa(5, 54, 82, 0, 0, 0);//actualiza general
	 		    log_agrega_detalle ($id_log, "Proyecto anterior", $busca_proyecto[2], "",1);
	 		    log_agrega_detalle ($id_log, "Nuevo proyecto", $_POST["m_proyecto_".$id_proyecto], "",1);
 			    log_agrega_detalle ($id_log, "Municipio", $busca_municipio[2], "",1);


		?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/admin/m_municipios.php?id_municipios=<?=$id_municipios;?>&lista_existentes=<?=$id_ingreso;?>','contenidos');
					
                    </script>
			<?
	
			
		}


if($_POST["accion"]=="editar_municipio_tarifas")
		{
			
	$id_municipios_arr = elimina_comillas(arreglo_recibe_variables($id_municipios));
			$busca_municipio = traer_fila_row(query_db("select * from t6_tarifas_municipios where t6_tarifas_municipios_id = $id_municipios_arr "));
	 	
	
				echo $update_ree = "update t6_tarifas_municipios set municipo= '".$_POST["modifica_municipio"]."' WHERE t6_tarifas_municipios_id = $id_municipios_arr ";
				$sql_grupo=mssql_query($update_ree);

				$id_log = log_de_procesos_sgpa(5, 54, 85, 0, 0, 0);//actualiza general
	 		    log_agrega_detalle ($id_log, "Municipio anterior", $busca_municipio[2], "",1);
	 		    log_agrega_detalle ($id_log, "Nuevo Municipio", $_POST["modifica_municipio"], "",1);

		?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/admin/m_municipios.php?id_municipios=<?=$id_municipios;?>&lista_existentes=<?=$id_ingreso;?>','contenidos');
					
                    </script>
			<?
	
			
		}

if($_POST["accion"]=="crea_municipio_tarifas")
		{
			
	$id_municipios_arr = elimina_comillas(arreglo_recibe_variables($id_municipios));	
	
				echo $update_ree = "insert into t6_tarifas_municipios (proyecto, municipo, estado) 
				values ('','$municipio_crea',1) ";
				$sql_grupo=mssql_query($update_ree);
				$id_log = log_de_procesos_sgpa(5, 54, 84, 0, 0, 0);//actualiza general
	 		    log_agrega_detalle ($id_log, "Creación", "Municipio", "",1);
	 		    log_agrega_detalle ($id_log, "Nuevo Municipio", $_POST["municipio_crea"], "",1);
				


		?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/admin/modulo-historico-municipios.php','contenidos');
					
                    </script>
			<?
	
			
		}			



if($_POST["accion"]=="crea_ipc_contrato")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
				$update_ree = mssql_query("update t6_tarifas_actualiza_ipc set estado = 2 where t6_tarifas_contratos_id = $id_contrato_arr");
				
				echo $copia_lista = "insert into t6_tarifas_actualiza_ipc (t6_tarifas_contratos_id,ipc_administracion,us_creacion,fecha_creacion,estado) values 
				($id_contrato_arr, $reembolsable_por, ".$_SESSION["id_us_session"].",'$fecha $hora', 1)";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
				
			?>
					<script> 
                    alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_ipc.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    alert("El registro NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}	

/***************************************************************************************************************************
**********************CREACION DE APROBACIONES DE TARIFAS**S****************************************************************
/***************************************************************************************************************************/

function pasos_aprobacion_tarifas($aprobaciones_solicitadas,$aprobaciones_actuales,$id_item,$gerente)
	{ //funcion para aprobaciones de tarifas
	
		global $id_contrato_arr, $fecha, $hora,$ts3,$id_tarifa,$t7,$numero_aprobaciones_req;

		if($numero_aprobaciones_req==3)
			$aprobaciones_actuales=($aprobaciones_actuales+1);

			/*BUSCA DATOS DEL CONTRATO Y APROBADORES*/
				$sel_item_area = traer_fila_row(mssql_query("select t1_area_id from t2_item_pecc where id_item= $id_item"));
				$sele_jefe_area = traer_fila_row(mssql_query("select id_jefe_area from tseg13_relacion_usuario_jefe where id_us = ".$gerente." and id_area = ".$sel_item_area[0]));
				
				if($sele_jefe_area[0]==""){
					
				//lo que estaba antes
				$busca_area=traer_fila_row(mssql_query("select  id_area from $ts3 where id_usuario = $sql_con[14]"));
				$busca_jefe_area=traer_fila_row(mssql_query("select us_id from $v_seg1 where id_area = $busca_area[0] and id_premiso = 9"));
				$id_jefe_area =$busca_jefe_area[0];
				
				}else{
					
					$id_jefe_area = $sele_jefe_area[0];
					}

			$busca_datos_del_contrato = "select id_item, gerente, especialista, $id_jefe_area from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr";
			$sql_busca_datos_contrato_abrobadores = traer_fila_row(mssql_query($busca_datos_del_contrato));
			
			/*BUSCA DATOS DEL CONTRATO Y APROBADORES*/
	
	

 $busca_suplentes_etapa_text = "select us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr  and fecha_suplencia >= '$fecha' and tipo_suplencia = $aprobaciones_actuales and  estado = 1  ";
		$busca_suplentes_etapa = traer_fila_row(mssql_query($busca_suplentes_etapa_text));	
			if($busca_suplentes_etapa[0]>=1){//si tiene suplencia
			echo "aqui suplente -- ".$busca_suplentes_etapa[0]."abropacio ".$aprobaciones_actuales;
				if($_SESSION["id_us_session"]==$busca_suplentes_etapa[0]){//SI EL SULPENTE ES IGUAL AL QUE ESTA APROBADO
				
				echo "aqui si es suplente y el je tambien es el mino 0 -- ".$siguiente_usuario_aprobador;
echo "select us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr  and fecha_suplencia >= '$fecha' and tipo_suplencia = ".($aprobaciones_actuales + 1 )." and  estado = 1  ";				
					$busca_suplentes_siguiente_etapa = traer_fila_row(mssql_query("select us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr  and fecha_suplencia >= '$fecha' and tipo_suplencia = ".($aprobaciones_actuales + 1 )." and  estado = 1  "));
						if($busca_suplentes_siguiente_etapa[0]>=1){//si LA SIGUIENTE ETAPA TIENE SUPLENTES tiene suplencia
								$siguiente_usuario_aprobador =	$busca_suplentes_siguiente_etapa[0];	
echo "aqui 0 -- ".$siguiente_usuario_aprobador;
									$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones)";
									$inserta_aprobacion.= " values ($id_tarifa,1,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."')"; 
									$sql_inser=mssql_query($inserta_aprobacion);						
									$roll_aprobador=($aprobaciones_actuales+1);
		
		
						}//si LA SIGUIENTE ETAPA TIENE SUPLENTES tiene suplencia
						
						else { //si LA SIGUIENTE ETAPA NO TIENE SUPLENTES tiene suplencia y es el mismo aprobador
						
								$siguiente_usuario_aprobador =	$busca_suplentes_etapa[0];
								$roll_aprobador=$aprobaciones_actuales;
								
								echo "aqui 1 -- ".$siguiente_usuario_aprobador;
	
						
						} ////si LA SIGUIENTE ETAPA NO TIENE SUPLENTES tiene suplencia y es el mismo aprobador
				
				}//SI EL SULPENTE ES IGUAL AL QUE ESTA APROBADO
			
			else{//SI EL SULPENTE  NO ES IGUAL AL QUE ESTA APROBADO
								
								$siguiente_usuario_aprobador =	$busca_suplentes_etapa[0];
								$roll_aprobador=$aprobaciones_actuales;
								
								echo "aqui 1 0 -- ".$siguiente_usuario_aprobador;
			
			}//SI EL SULPENTE NO ES IGUAL AL QUE ESTA APROBADO
			
			
			}//si tiene suplencia
			
			
			/*************SI NO TIENE SUPLENCIA///////////////////////*/
			else {// ******************* NO tiene suplencia

				if($_SESSION["id_us_session"]==$sql_busca_datos_contrato_abrobadores[$aprobaciones_actuales]){//SI EL siguiente ES IGUAL AL QUE ESTA APROBADO
				
									$siguiente_usuario_aprobador =	$sql_busca_datos_contrato_abrobadores[($aprobaciones_actuales+1)];
	echo "aqui 2 -- ".$siguiente_usuario_aprobador;
									$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones)";
									 $inserta_aprobacion.= " values ($id_tarifa,1,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."')"; 
									$sql_inser=mssql_query($inserta_aprobacion);						
									$roll_aprobador=($aprobaciones_actuales+1);
				
				}//SI EL siguiente ES IGUAL AL QUE ESTA APROBADO
			
			
			else
				{
								$siguiente_usuario_aprobador =	$sql_busca_datos_contrato_abrobadores[$aprobaciones_actuales];
								$roll_aprobador=$aprobaciones_actuales;
	echo "aqui 3 -- ".$siguiente_usuario_aprobador;
				
				}
			
			}// ******************* NO tiene suplencia
			
			/*************SI NO TIENE SUPLENCIA///////////////////////*/
		echo  $inserta_aprobacion;	
	
	return $siguiente_usuario_aprobador."|".$roll_aprobador;
	
	}//funcion para aprobaciones de tarifas




if($_POST["accion"]=="crea_aprobacion")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$genera_email=0;
			$tarifas_devuieltas="";
			$busca_datos_del_contrato = traer_fila_row(mssql_query("select * from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr"));
			
			/*COMPRUEBA SI ES MARCO O NORMAL*/
				if($busca_datos_del_contrato[19]==1) $numero_aprobaciones_req=3;
				elseif($busca_datos_del_contrato[19]==2) $numero_aprobaciones_req=4;				
			/*COMPRUEBA SI ES MARCO O NORMAL*/			
					
		foreach($aprobacion as $id_tarifa => $valor_aprobacion)
				{//inicio for
				
					if($valor_aprobacion>=1){//si selecciona un estado
				
						if( ($valor_aprobacion==5) || ($valor_aprobacion==6) ){ // si el steado es devuelto
						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."')"; 
						$sql_inser=mssql_query($inserta_aprobacion);						
								$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = $valor_aprobacion,us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa";
								$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);		
								
								$tarifas_devuieltas.=",".$id_tarifa;					
						}// si el steado es devuelto
						elseif( $valor_aprobacion==4) { // si el steado es rechazada
						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."')"; 
						$sql_inser=mssql_query($inserta_aprobacion);						
								$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = $valor_aprobacion, us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa";
								$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);	
								$tarifas_devuieltas.=",".$id_tarifa;						
							
						}// si el steado es rechazada

						elseif( $valor_aprobacion==1) { // si el steado es aprobado para enviar email a la siguiente
						
						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."')"; 
						$sql_inser=mssql_query($inserta_aprobacion);						
				
							$busca_aprobaciones_cabia_estado="select count(*) from $t7 where t6_tarifas_lista_id = $id_tarifa and estado_aprobacion = 1 and t6_tarifas_estados_tarifas_id = 1";
							$sql_query_aprobaciones_actuales=traer_fila_row(mssql_query($busca_aprobaciones_cabia_estado));		
							
							
							if($sql_query_aprobaciones_actuales[0]<$numero_aprobaciones_req){//si NO  ya se cumpliron las aprobaciones
									 $siguiente_aprobador_funcion = pasos_aprobacion_tarifas($numero_aprobaciones_req,$sql_query_aprobaciones_actuales[0],$busca_datos_del_contrato[22],$busca_datos_del_contrato[14]);
									
									$siguiente_aprobador_arrgle =explode("|",$siguiente_aprobador_funcion);
									$siguiente_aprobador=$siguiente_aprobador_arrgle[0];
									$roll_aprobador=$siguiente_aprobador_arrgle[1];
									
									if($roll_aprobador==1) $roll_perfil_inbox = "Gerente de contrato";
									elseif($roll_aprobador==2) $roll_perfil_inbox = "Especialista";
									elseif($roll_aprobador==3) $roll_perfil_inbox = "Jefe de area";
									
									$cambia_estado_actual=mssql_query("update $t3 set us_aprobacion_actual=$siguiente_aprobador where t6_tarifas_lista_id = $id_tarifa");
									
									
									if($roll_aprobador<=3){//si va hasta el jefe de area
									
									echo "<br>roll".$roll_aprobador."roll<br>";
									echo "<br>select count(*) from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$siguiente_aprobador;
									
									$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$siguiente_aprobador));
									if($borra_inbox_cunat_pendientes[0]==0){//si no tiene inbox el siguiente

										$inserta_inbox = mssql_query("insert into t6_tarifas_responsables_aprobadores (tarifas_contrato_id, us_id, roll, estado, fecha) values 
										($id_contrato_arr,$siguiente_aprobador,'$roll_perfil_inbox', 1,'$fecha $hora' )");
										$inserta_inbox = mssql_query("insert into t6_tarifas_responsables_aprobadores_copia (tarifas_contrato_id, us_id, roll, estado, fecha) values 	($id_contrato_arr,$siguiente_aprobador,'$roll_perfil_inbox', 1,'$fecha $hora' )");
									
									}//si no tiene inbox el siguiente									

									$busca_email_destino = traer_fila_row(mssql_query("select email from t1_us_usuarios where us_id = $siguiente_aprobador "));
									$cuenta_email_en_cola_pendientes = traer_fila_row(mssql_query("select count(*) from tseg18_registro_email_generados where proceso_id = $id_contrato_arr and email_envio = '".$busca_email_destino[0]."' and enviado = 1"));
									if($cuenta_email_en_cola_pendientes[0]==0){//si no tiene emial el siguiente
										$texto_email_arreglado=arregla_texto_email_para_enviar($busca_datos_del_contrato[6],$busca_datos_del_contrato[7],$_SESSION["us_nombre_session"],$modelo_aporbacion_pendiente_admin);
										registra_correos_enviados_nuevo(5, $id_contrato_arr, 0, 0, $busca_email_destino[0], $modelo_aporbacion_pendiente_admin_asunto, $texto_email_arreglado);
									}//si no tiene emial el siguiente										
									
									}//si va hasta el jefe de area

									
								}//si  NO se cumpliron las aprobaciones
								
							else{//si ya  se cumpliron las aprobaciones	
									$cambia_estado_actual=mssql_query("update $t3 set us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa");
									
									$busca_tarifa_padre = traer_fila_row(mssql_query("select tarifa_padre, fecha_inicio_vigencia from $t3 where t6_tarifas_lista_id = $id_tarifa and tarifa_padre >=1 "));
			
									if($busca_tarifa_padre[0]>=1){//si tiene hojos
									$fecha_finalizacion = resta_dia_fecha(1, $busca_tarifa_padre[1]);
									$cambia_estado_hijos="update $t3 set t6_tarifas_estados_tarifas_id = 7,fecha_fin_vigencia='$fecha_finalizacion' where tarifa_padre = $busca_tarifa_padre[0] and t6_tarifas_estados_tarifas_id = 1";
									$sql_cambia_tarifas_hijos=mssql_query($cambia_estado_hijos);
									
			
									$cambia_estado_padres="update $t3 set t6_tarifas_estados_tarifas_id = 7 , fecha_fin_vigencia='$fecha_finalizacion' where t6_tarifas_lista_id = $busca_tarifa_padre[0] and t6_tarifas_estados_tarifas_id = 1";
									$sql_cambia_tarifas_padre=mssql_query($cambia_estado_padres);
										
									} //si tiene hijos
			
									$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = 1, fecha_fin_vigencia='0000-00-00' where t6_tarifas_lista_id = $id_tarifa";
									$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);
									
							}						
							echo "siguiente".$siguiente_aprobador."siguiente <br>";
					$genera_email++;
					}// si el steado es aprobado para enviar email a la siguiente
					
					}//si selecciona un estado
				
				
				
				}//inicio for
			
		
									
									
										$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where us_aprobacion_actual = ".$_SESSION["id_us_session"]." and t6_tarifas_estados_tarifas_id in (2,3)"));
										if($borra_inbox_cunat_pendientes[0]==0){// si ya no tiene aprobaciones pendientes borra el inbox
										$borra_inbox=mssql_query("delete from  t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]);
										}// si ya no tiene aprobaciones pendientes borra el inbox										

										
							if($tarifas_devuieltas!="")
								{//si tiene devoluciones genera email
									
									$busca_usuarios_aprobaciones_ateriores = "select distinct email from v_tarifas_relacion_usuarios_aprobaciones where t6_tarifas_lista_id in (0 $tarifas_devuieltas)";
									$sql_ema_devu = query_db($busca_usuarios_aprobaciones_ateriores);
									
									while($busca_email_destino = traer_fila_row($sql_ema_devu)){//busca_email_notificacion
								
										$texto_email_arreglado=arregla_texto_email_para_enviar($busca_datos_del_contrato[6],$busca_datos_del_contrato[7],$_SESSION["us_nombre_session"],$modelo_rechazo_pendiente_admin);
										registra_correos_enviados_nuevo(5, $id_contrato_arr, 0, 0, $busca_email_destino[0], $modelo_rechazo_pendiente_admin_asunto, $texto_email_arreglado);

									}//busca_email_notificacion
								
								}//si tiene devoluciones genera email
									
				
			
			
			
		
	
			
			?>
					<script> 
                    alert("El proceso se termino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_aprobaciones.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
			
		}

/***************************************************************************************************************************
**********************CREACION DE APROBACIONES DE TARIFAS**S****************************************************************
/***************************************************************************************************************************/




if($_POST["accion"]=="aprueba_todas_tarifas")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$genera_email=0;
			$tarifas_devuieltas="";
			$busca_datos_del_contrato = traer_fila_row(mssql_query("select * from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr"));
			
			/*COMPRUEBA SI ES MARCO O NORMAL*/
				if($busca_datos_del_contrato[19]==1) $numero_aprobaciones_req=3;
				elseif($busca_datos_del_contrato[19]==2) $numero_aprobaciones_req=4;				
			/*COMPRUEBA SI ES MARCO O NORMAL*/			
					
		foreach($aprobacion as $id_tarifa => $valor_aprobacion)
				{//inicio for
				
				$valor_aprobacion=1;
				
					if($valor_aprobacion>=1){//si selecciona un estado
				
						
						if( $valor_aprobacion==1) { // si el steado es aprobado para enviar email a la siguiente
						
						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."')"; 
						$sql_inser=mssql_query($inserta_aprobacion);						
				
							$busca_aprobaciones_cabia_estado="select count(*) from $t7 where t6_tarifas_lista_id = $id_tarifa and estado_aprobacion = 1 and t6_tarifas_estados_tarifas_id = 1";
							$sql_query_aprobaciones_actuales=traer_fila_row(mssql_query($busca_aprobaciones_cabia_estado));		
							
							
							if($sql_query_aprobaciones_actuales[0]<$numero_aprobaciones_req){//si NO  ya se cumpliron las aprobaciones
									 $siguiente_aprobador_funcion = pasos_aprobacion_tarifas($numero_aprobaciones_req,$sql_query_aprobaciones_actuales[0],$busca_datos_del_contrato[22],$busca_datos_del_contrato[14]);
									
									$siguiente_aprobador_arrgle =explode("|",$siguiente_aprobador_funcion);
									$siguiente_aprobador=$siguiente_aprobador_arrgle[0];
									$roll_aprobador=$siguiente_aprobador_arrgle[1];
									
									if($roll_aprobador==1) $roll_perfil_inbox = "Gerente de contrato";
									elseif($roll_aprobador==2) $roll_perfil_inbox = "Especialista";
									elseif($roll_aprobador==3) $roll_perfil_inbox = "Jefe de area";
									
									$cambia_estado_actual=mssql_query("update $t3 set us_aprobacion_actual=$siguiente_aprobador where t6_tarifas_lista_id = $id_tarifa");
									
									
									if($roll_aprobador<=3){//si va hasta el jefe de area
									
									$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$siguiente_aprobador));
									if($borra_inbox_cunat_pendientes[0]==0){//si no tiene inbox el siguiente

										$inserta_inbox = mssql_query("insert into t6_tarifas_responsables_aprobadores (tarifas_contrato_id, us_id, roll, estado, fecha) values 
										($id_contrato_arr,$siguiente_aprobador,'$roll_perfil_inbox', 1,'$fecha $hora' )");
										$inserta_inbox = mssql_query("insert into t6_tarifas_responsables_aprobadores_copia (tarifas_contrato_id, us_id, roll, estado, fecha) values 	($id_contrato_arr,$siguiente_aprobador,'$roll_perfil_inbox', 1,'$fecha $hora' )");
									
									}//si no tiene inbox el siguiente									

									$busca_email_destino = traer_fila_row(mssql_query("select email from t1_us_usuarios where us_id = $siguiente_aprobador "));
									$cuenta_email_en_cola_pendientes = traer_fila_row(mssql_query("select count(*) from tseg18_registro_email_generados where proceso_id = $id_contrato_arr and email_envio = '".$busca_email_destino[0]."' and enviado = 1"));
									if($cuenta_email_en_cola_pendientes[0]==0){//si no tiene emial el siguiente
										$texto_email_arreglado=arregla_texto_email_para_enviar($busca_datos_del_contrato[6],$busca_datos_del_contrato[7],$_SESSION["us_nombre_session"],$modelo_aporbacion_pendiente_admin);
										registra_correos_enviados_nuevo(5, $id_contrato_arr, 0, 0, $busca_email_destino[0], $modelo_aporbacion_pendiente_admin_asunto, $texto_email_arreglado);
									}//si no tiene emial el siguiente										
									
									}//si va hasta el jefe de area

									
								}//si  NO se cumpliron las aprobaciones
								
							else{//si ya  se cumpliron las aprobaciones	
									$cambia_estado_actual=mssql_query("update $t3 set us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa");
									
									$busca_tarifa_padre = traer_fila_row(mssql_query("select tarifa_padre, fecha_inicio_vigencia from $t3 where t6_tarifas_lista_id = $id_tarifa and tarifa_padre >=1 "));
			
									if($busca_tarifa_padre[0]>=1){//si tiene hojos
									$fecha_finalizacion = resta_dia_fecha(1, $busca_tarifa_padre[1]);
									$cambia_estado_hijos="update $t3 set t6_tarifas_estados_tarifas_id = 7,fecha_fin_vigencia='$fecha_finalizacion' where tarifa_padre = $busca_tarifa_padre[0] and t6_tarifas_estados_tarifas_id = 1";
									$sql_cambia_tarifas_hijos=mssql_query($cambia_estado_hijos);
									
			
									$cambia_estado_padres="update $t3 set t6_tarifas_estados_tarifas_id = 7 , fecha_fin_vigencia='$fecha_finalizacion' where t6_tarifas_lista_id = $busca_tarifa_padre[0] and t6_tarifas_estados_tarifas_id = 1";
									$sql_cambia_tarifas_padre=mssql_query($cambia_estado_padres);
										
									} //si tiene hijos
			
									$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = 1, fecha_fin_vigencia='0000-00-00' where t6_tarifas_lista_id = $id_tarifa";
									$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);
									
							}						
							echo "siguiente".$siguiente_aprobador."siguiente <br>";
					$genera_email++;
					}// si el steado es aprobado para enviar email a la siguiente
					
					}//si selecciona un estado
				
				
				
				}//inicio for
			
		
									
									
										$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where us_aprobacion_actual = ".$_SESSION["id_us_session"]." and t6_tarifas_estados_tarifas_id in (2,3)"));
										if($borra_inbox_cunat_pendientes[0]==0){// si ya no tiene aprobaciones pendientes borra el inbox
										$borra_inbox=mssql_query("delete from  t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]);
										}// si ya no tiene aprobaciones pendientes borra el inbox										

										
							if($tarifas_devuieltas!="")
								{//si tiene devoluciones genera email
									
									$busca_usuarios_aprobaciones_ateriores = "select distinct email from v_tarifas_relacion_usuarios_aprobaciones where t6_tarifas_lista_id in (0 $tarifas_devuieltas)";
									$sql_ema_devu = query_db($busca_usuarios_aprobaciones_ateriores);
									
									while($busca_email_destino = traer_fila_row($sql_ema_devu)){//busca_email_notificacion
								
										$texto_email_arreglado=arregla_texto_email_para_enviar($busca_datos_del_contrato[6],$busca_datos_del_contrato[7],$_SESSION["us_nombre_session"],$modelo_rechazo_pendiente_admin);
										registra_correos_enviados_nuevo(5, $id_contrato_arr, 0, 0, $busca_email_destino[0], $modelo_rechazo_pendiente_admin_asunto, $texto_email_arreglado);

									}//busca_email_notificacion
								
								}//si tiene devoluciones genera email
									
				
			
			
			
		
	
			
			?>
					<script> 
                    alert("El proceso se termino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_aprobaciones.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
			
		}






/***************************************************************************************************************************
**********************CREACION DE APROBACIONES DE TARIFAS**S****************************************************************
/***************************************************************************************************************************/






if($_POST["accion"]=="rechaza_todas_tarifas")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$genera_email=0;
			$tarifas_devuieltas="";
			$busca_datos_del_contrato = traer_fila_row(mssql_query("select * from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr"));
			
			/*COMPRUEBA SI ES MARCO O NORMAL*/
				if($busca_datos_del_contrato[19]==1) $numero_aprobaciones_req=3;
				elseif($busca_datos_del_contrato[19]==2) $numero_aprobaciones_req=4;				
			/*COMPRUEBA SI ES MARCO O NORMAL*/			
					
		foreach($aprobacion as $id_tarifa => $valor_aprobacion)
				{//inicio for
				
				$valor_aprobacion=4;
				
					if($valor_aprobacion>=1){//si selecciona un estado

						if( $valor_aprobacion==4) { // si el steado es rechazada
						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."')"; 
						$sql_inser=mssql_query($inserta_aprobacion);						
								$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = $valor_aprobacion, us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa";
								$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);	
								$tarifas_devuieltas.=",".$id_tarifa;						
						}// si el steado es devuelto
				
						
						
					
					}//si selecciona un estado
				
				
				
				}//inicio for
			
		
									
									
										$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where us_aprobacion_actual = ".$_SESSION["id_us_session"]." and t6_tarifas_estados_tarifas_id in (2,3)"));
										if($borra_inbox_cunat_pendientes[0]==0){// si ya no tiene aprobaciones pendientes borra el inbox
										$borra_inbox=mssql_query("delete from  t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]);
										}// si ya no tiene aprobaciones pendientes borra el inbox										

										
							if($tarifas_devuieltas!="")
								{//si tiene devoluciones genera email
									
									$busca_usuarios_aprobaciones_ateriores = "select distinct email from v_tarifas_relacion_usuarios_aprobaciones where t6_tarifas_lista_id in (0 $tarifas_devuieltas)";
									$sql_ema_devu = query_db($busca_usuarios_aprobaciones_ateriores);
									
									while($busca_email_destino = traer_fila_row($sql_ema_devu)){//busca_email_notificacion
								
										$texto_email_arreglado=arregla_texto_email_para_enviar($busca_datos_del_contrato[6],$busca_datos_del_contrato[7],$_SESSION["us_nombre_session"],$modelo_rechazo_pendiente_admin);
										registra_correos_enviados_nuevo(5, $id_contrato_arr, 0, 0, $busca_email_destino[0], $modelo_rechazo_pendiente_admin_asunto, $texto_email_arreglado);

									}//busca_email_notificacion
								
								}//si tiene devoluciones genera email
									
				
			
			
			
		
	
			
			?>
					<script> 
                    alert("El proceso se termino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_aprobaciones.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
			
		}
?>

