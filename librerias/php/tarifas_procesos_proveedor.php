<?  include("../lib/@session.php");

	verifica_menu("proveedores.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php

function extencion_archivos_tarifas($archivo)
	{
	
	$busca_archi = explode(".",$archivo);
	$cua = count($busca_archi);
	$extencion = $busca_archi[$cua-1]; 
	$largo = strlen($archivo);
	$comienzo = ($largo-3);
	$ext = substr($archivo, $comienzo , 3);
	
	return $extencion;
	}

function valida_valor_tarifa_texto($tarifa_v){ 

   //compruebo que los caracteres sean los permitidos 
   $permitidos = "0123456789."; 
   for ($i=0; $i<strlen($tarifa_v); $i++){ 
      if (strpos($permitidos, substr($tarifa_v,$i,1))===false){ 
         return 2; 
      } 
   } 
	   return 1; 
}

	function valida_valor_tarifa($tarifa_v)
		{
			
		$text = $tarifa_v;
		$aparicones_coma= substr_count($text, ',');
		$aparicones_puntos= substr_count($text, '.');
		$apariciones_texto = valida_valor_tarifa_texto($tarifa_v);
		
		if ($aparicones_coma>=1)
			return 2;
		elseif ($aparicones_puntos>=2)
			return 2;	
		elseif ($apariciones_texto==2)
			return 2;						
		else
			return 1;
			
			}


	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER


	if($_POST["accion"]=="elimina_tiquete_temporal"){
		$upta = query_db("update t6_tarifas_proveedor_prefactura set estado =3 where t6_tarifas_proveedor_prefactura_id = ".$_POST["id_pre_elimina"]);
		?><script> 
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/h_prefactura.php?id_contrato=<?=$_POST["id_contrato"];?>','carga_acciones_permitidas');
                    </script><?
		}
	if($_POST["accion"]=="elimina_reembolsable_temporal"){
		$upta = query_db("update t6_tarifas_reembolables_datos set estado =3 where t6_tarifas_reembolables_datos_id = ".$_POST["id_rem_elimina"]);
		?><script> 
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/h_reembolsable.php?id_contrato=<?=$_POST["id_contrato"];?>','carga_acciones_permitidas');
                    </script><?
		}
		
if($_POST["accion"]=="eliminar_cargue_previo"){
					$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato"]));
					
					if($_POST["tipo_creacion"] == 2){//si es modificacion masiva
					$link = "c_tarifas_actualicar_masivas.php";
					}
					if($_POST["tipo_creacion"] == 3){//si es creacion masiva
					$link = "c_tarifas_masivas.php";
					}
					if($_POST["tipo_creacion"] == 5){//si es creacion masiva
					$link = "c_tarifas_actualicar_masivas_ipc.php";
					}					
					
					$update = query_db("update t6_tarifas_lista set t6_tarifas_estados_tarifas_id = 33 where tarifas_contrato_id = ".$id_contrato_arr." and t6_tarifas_estados_tarifas_id in (9,10) and tipo_creacion_modifica in (".$_POST["tipo_creacion"].", 5,4)");
	
					?><script> 
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/<?=$link?>?id_contrato=<?=$_POST["id_contrato"];?>','carga_acciones_permitidas');
                    </script><?
	}
if($_POST["accion"]=="crea_tarifa_manual")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id

			/*verifica si el contrato ya esta en frme o no para porner tipo de creacion*/
			echo $busca_tarifas = "select estado_contrato,gerente,t1_tipo_documento_id, id_contrato from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr";
			$sql_busca_tarifas=traer_fila_row(query_db($busca_tarifas));
		
$busca_consecutivo = "select consecutivo_tarifa from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr order by consecutivo_tarifa desc  ";
$sql_busca_consecutivo = traer_fila_row(query_db($busca_consecutivo));
$serial_consecutivo =($sql_busca_consecutivo[0] + 1);

		
			// $insert.=  " values ($id_contrato_arr,'".elimina_comillas_2($categoria)."','".elimina_comillas_2($grupo)."','".elimina_comillas_2($codigo)."','".elimina_comillas_2($detalle)."', '".elimina_comillas_2($unidad)."','$cantidad','$moneda','$valor', '$id_us_session','$fecha $hora',$tipo_creacion,$estado_tarifa,'$fecha_vigencia',0 ,'0000-00-00',$lista_existentes,3)";
		echo "moneda".$_POST["moneda"]."moneda";
			if($_POST["valor"]=="")
				$error.="* Digite el nuevo valor";	
			if($_POST["moneda"]==0)
				$error.="* Seleccione la moneda";	

			if($_POST["fecha_vigencia"]=="")			
				$error.="* Seleccione el inicio de la vigencia ";	

			if( ($_POST["fecha_vigencia_fin"]!="")	and ($_POST["fecha_vigencia_fin"]<$_POST["fecha_vigencia"])		)
				$error.="* La fecha inicio vigencia NO puede ser mayor que la fecha fin vigencia ";

			if($_POST["fecha_vigencia"]>$_POST["vigencia_contrato"])
				$error.="* La fecha inicio vigencia NO puede ser mayor que la fecha de vigencia del contrato (".$_POST["vigencia_contrato"].")";

			if($_POST["fecha_vigencia_fin"]!="" and $_POST["fecha_vigencia_fin"]>$_POST["vigencia_contrato"])
				$error.="* La fecha fin vigencia NO puede ser mayor que la fecha de vigencia del contrato (".$_POST["vigencia_contrato"].")";
			
			if($_POST["fecha_vigencia"]<$_POST["inicio_contrato"])
				$error.="* La fecha inicio vigencia NO puede ser menor que la fecha de inicio del contrato (".$_POST["inicio_contrato"].")";

			if($_POST["fecha_vigencia_fin"]!="" and $_POST["fecha_vigencia_fin"]<$_POST["inicio_contrato"])
				$err_m.="* La fecha fin vigencia NO puede ser menor que la fecha de inicio del contrato (".$_POST["inicio_contrato"].")";
			

			if($_POST["codigo"]=="")			
				$error.="* Digite el ".TITULO_alertas;	


			if($_POST["observa_soporte_0"]=="")
				$error="* Digite los comentarios de la modificacion ";
			$largo_comentarios = strlen($_POST["observa_soporte_0"]);
			if($largo_comentarios<= 20)
				$error="* Los comentarios de la actualización deben ser mayores a 20 caracteres";
			if($_POST["descuento_uni_0"]=="0")
				$error="* Seleccione si a la tarifa le aplica descuentos";	
		   if($_FILES["anexo_soporte_0"]["name"]=="")
				$error="* Seleccione el anexo soporte";	
			
			$extencion_anexo = strtolower(extencion_archivos_tarifas($_FILES["anexo_soporte_0"]["name"]));
			if( ($extencion_anexo!= "rar") && ($extencion_anexo!= "zip") )
				$error="* El anexo debe ser .zip o .rar |$extencion_anexo|";
			
			$valida_formato_tarifa = valida_valor_tarifa($_POST["valor"]);
			if($valida_formato_tarifa==2)
				$error="* El formato del valor es incorrecto";	
			
			$valida_valor = number_format($_POST["valor"],5);
			if($valida_valor==0)
				$error="* Digite el nuevo valor";	

			if( ($sql_busca_tarifas[2]==2 ) && ($_POST["aprobacion_secundaria_0"]=="0") )	
				$error="* Seleccione la persona que solicita la actualización ";		
			
							
				
			
			
			
			if($error!="")
				{// si tiene errores
					
					?>
                    	<script>
                        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: <?=$error;?>', 60, 5, 10)
							//alert("Verifique la tarifa:\n<?=$error;?>")
                        
                        </script>
                        
                    
                    <?		
					exit();
					
					} //// si tiene errores		



			if($sql_busca_tarifas[0]==3){
				$tipo_creacion = 2;
				$estado_tarifa = 3;
				}
			else{
				$tipo_creacion = 1;
				$estado_tarifa = 1;
				}
			
			if($_POST["aprobacion_secundaria_0"]!=""){
				$aprobacion_responsable = $_POST["aprobacion_secundaria_0"];
				}
			else { 
				$aprobacion_responsable = $sql_busca_tarifas[1];
				
				}
			
			if($_POST["fecha_vigencia_fin"]!="")
				$fecha_fin_vigencia = $_POST["fecha_vigencia_fin"];
			else				
				$fecha_fin_vigencia ="0000-00-00";
			

			 $insert = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia,tarifa_padre,fecha_fin_vigencia, t6_tarifas_listas_lista_id,tipo_creacion_modifica,us_aprobacion_actual,creada_luego_firme, consecutivo_tarifa) ";
			 $insert.=  " values ($id_contrato_arr,'".elimina_comillas_2($categoria)."','".elimina_comillas_2($grupo)."','".elimina_comillas_2($codigo)."','".elimina_comillas_2($detalle)."', '".elimina_comillas_2($unidad)."','$cantidad','$moneda','$valor', '$id_us_session','$fecha $hora',$tipo_creacion,$estado_tarifa,'$fecha_vigencia',0 ,'$fecha_fin_vigencia',$lista_existentes,3,$aprobacion_responsable,2, $serial_consecutivo)";
			$sql_ex=query_db($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){
			
			$update_pone_padre = query_db("update $t3 set tarifa_padre = $id_ingreso where t6_tarifas_lista_id = $id_ingreso");

			foreach($detalle_campo_descriptor as $id_cammpo_descriptor => $valor_campo_descriptor){//for
			
			if($valor_campo_descriptor!=""){//si no esta vacio
			
			 $inser_descr= "insert into $t14 (t6_tarifas_lista_id, t6_tarifas_atributos_id, detalle) values (".$id_ingreso.", $id_cammpo_descriptor, '".elimina_comillas_2($valor_campo_descriptor)."' )";
			$sql_ex_des=query_db($inser_descr);
			
			
			}////si no esta vacio
			
			
			} //fro		
			//cambia estado contrato a parcial
			echo $inserta_aprobacion_secu = "insert into t6_tarifas_aprobadores_secundarios (t6_tarifas_lista_id, us_id, tipo_aprobacion_copia,tarifas_contrato_id, notificado)
			 values ($id_ingreso,".$_POST["aprobacion_secundaria_0"].",1,$id_contrato_arr,1)";
			 $graba_aprobador_secundario=query_db($inserta_aprobacion_secu);
			 
			 if($_POST["copia_0"]==1){//si requiere copias
			echo "aqui".count($_POST["usuario_copia_0"]);
			 foreach($_POST["usuario_copia_0"] as $id_us_copia)
			 	{ // for copia
					echo $inserta_aprobacion_secu = "insert into t6_tarifas_aprobadores_secundarios (t6_tarifas_lista_id, us_id, tipo_aprobacion_copia,tarifas_contrato_id, notificado)
					 values ($id_ingreso,".$id_us_copia.",2,$id_contrato_arr,1)";
					 $graba_aprobador_secundario=query_db($inserta_aprobacion_secu);
				
				
				}// for copia
			 
			 }//si requiere copias
				
				if( ($_POST["observa_soporte_0"]!="") || ($_FILES["anexo_soporte_0"]["name"]!="") ){//si trae anexo o comentario
				
								
																		
									$cambia_soporte = "insert into t6_tarifas_anexos_modifica_tarifas (t6_tarifas_lista_id,observaciones , anexo,descuento) values (
									$id_ingreso,'".$_POST["observa_soporte_0"]."', '".$_FILES["anexo_soporte_0"]["name"]."',".$_POST["descuento_uni_0"].")";
									$sql_cambi_so=query_db($cambia_soporte.$trae_id_insrte);
									
									$id_ingreso_soporte = id_insert($sql_cambi_so);
			
										if($id_ingreso_soporte>=1){//si se creó el soporte
										
											if($_FILES["anexo_soporte_0"]["name"]!=""){//si tiene anexo
												carga_archivo($anexo_soporte_0,"tarifas_ane_modifica/".$id_ingreso_soporte);
												
												
												}//si tiene anexo
										
										}//si se creó el soporte
								
							
				
				}//si trae anexo o comentario			
			$id_contrato_modulo_contrato = $sql_busca_tarifas[3];
			$updat = query_db("update $t4 set t6_tarifas_estados_contratos_id = 2 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_contratos_id <> 3");
			
			$id_log = log_de_procesos_sgpa(5, 56, 0, $id_contrato_modulo_contrato, 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Lista", $lista_existentes , $t12 ,1);
			log_agrega_detalle ($id_log, "Categoria", elimina_comillas_2($categoria) , "",2);
			log_agrega_detalle ($id_log, "Grupo", elimina_comillas_2($grupo) , "",3);
			log_agrega_detalle ($id_log, "Inicio Vigencia", $fecha_vigencia , "",4);
			log_agrega_detalle ($id_log, "Codigo", elimina_comillas_2($codigo) , "",5);
			log_agrega_detalle ($id_log, "Nombre generico del producto / servicio", elimina_comillas_2($detalle) , "",6);
			log_agrega_detalle ($id_log, "Unidad", elimina_comillas_2($unidad) , "",7);
			log_agrega_detalle ($id_log, "Moneda", $moneda , $g5,8);
			log_agrega_detalle ($id_log, "Valor", $valor , "",9);
			log_agrega_detalle ($id_log, "Quien Solicita Crear la Tarifa", $_POST["aprobacion_secundaria_0"] , $g1,10);
			if ($_POST["descuento_uni_0"] == 1) $aplica_des = "SI"; if ($_POST["descuento_uni_0"] == 2) $aplica_des = "NO"; 
			log_agrega_detalle ($id_log, "La tarifa aplica descuento", $aplica_des , "",11);
			log_agrega_detalle ($id_log, "Observaciones", $_POST["observa_soporte_0"] , "",12);
			log_agrega_detalle ($id_log, "Anexo", $_FILES["anexo_soporte_0"]["name"] , "",13);
			

			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito, Se envio para las aprobaciones de Hocol SA', 20, 10, 18);
                    //alert("El proceso se creó con éxito, Se envio para las aprobaciones de Hocol SA")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script>
					 window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó con éxito', 60, 5, 10)
                    //alert("ATENCION:\n *El proceso NO se creó con éxito")
                    </script>
			<?
			}
			
		}




	if($_POST["accion"]=="modificar_tarifas")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id

			/*verifica si el contrato ya esta en frme o no para porner tipo de creacion*/
			$busca_tarifas = "select estado_contrato, gerente,t1_tipo_documento_id from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr";
			$sql_busca_tarifas=traer_fila_row(query_db($busca_tarifas));

$busca_consecutivo = "select consecutivo_tarifa from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr order by consecutivo_tarifa desc  ";
$sql_busca_consecutivo = traer_fila_row(query_db($busca_consecutivo));
$serial_consecutivo =($sql_busca_consecutivo[0] + 1);

			$valor_tarifa_actualizada = $_POST["valor_tarifa_".$id_tarifa_arr];
			
			if($_POST["valor_tarifa_".$id_tarifa_arr]=="")
				$error.="* Digite el nuevo valor";	
			if($_POST["item_oferta_n_".$id_tarifa_arr]=="")
				$error.="* Digite el ".TITULO_alertas;	
			if($_POST["vigencia_tarifa_".$id_tarifa_arr]=="")
				$error.="* Seleccione el inicio de la vigencia ";	

			if( ($_POST["fin_vigencia_tarifa_".$id_tarifa_arr]!="") and ($_POST["fin_vigencia_tarifa_".$id_tarifa_arr]< $_POST["vigencia_tarifa_".$id_tarifa_arr]))
				$error.="* La fecha inicio vigencia NO puede ser mayor que la fecha fin vigencia";
			if($_POST["vigencia_tarifa_".$id_tarifa_arr]>$_POST["vigencia_contrato"])
				$error.="* La fecha inicio vigencia NO puede ser mayor que la fecha de vigencia del contrato (".$_POST["vigencia_contrato"].")";
			if($_POST["fin_vigencia_tarifa_".$id_tarifa_arr]!="" and $_POST["fin_vigencia_tarifa_".$id_tarifa_arr]>$_POST["vigencia_contrato"])
				$error.="* La fecha fin vigencia NO puede ser mayor que la fecha de vigencia del contrato (".$_POST["vigencia_contrato"].")";
			
			if($_POST["vigencia_tarifa_".$id_tarifa_arr]<$_POST["inicio_contrato"])
				$error.="* La fecha inicio vigencia NO puede ser menor que la fecha de inicio del contrato (".$_POST["inicio_contrato"].")";

			if($_POST["fin_vigencia_tarifa_".$id_tarifa_arr]!="" and $_POST["fin_vigencia_tarifa_".$id_tarifa_arr]<$_POST["inicio_contrato"])
				$err_m.="* La fecha fin vigencia NO puede ser menor que la fecha de inicio del contrato (".$_POST["inicio_contrato"].")";
			
			
			if($_POST["observa_soporte_".$id_tarifa_arr]=="")
				$error.="* Digite los comentarios de la modificacion ";
			$largo_comentarios = strlen($_POST["observa_soporte_".$id_tarifa_arr]);
			if($largo_comentarios<= 20)
				$error.="* Los comentarios de la actualización deben ser mayores a 20 caracteres";
			if($_POST["descuento_uni_".$id_tarifa_arr]=="0")
				$error.="* Seleccione si a la tarifa le aplica descuentos";	
			if($_POST["modi_convencion_".$id_tarifa_arr]=="0")
				$error.="* Seleccione si la modificacion es por Convencion";	

			if($_FILES["anexo_soporte_".$id_tarifa_arr]["name"]=="") 
				$error.="* Seleccione el anexo soporte";

			$extencion_anexo = strtolower(extencion_archivos_tarifas($_FILES["anexo_soporte_".$id_tarifa_arr]["name"]));
			if( ($extencion_anexo!= "rar") && ($extencion_anexo!= "zip") )
				$error="* El anexo debe ser .zip o .rar |$extencion_anexo|";
			
			$valida_formato_tarifa = valida_valor_tarifa($valor_tarifa_actualizada);
			if($valida_formato_tarifa==2)
				$error="* El formato del valor es incorrecto";	
			
			$valida_valor = number_format($valor_tarifa_actualizada,5);
			if($valida_valor==0)
				$error="* Digite el nuevo valor";	



			if( ($sql_busca_tarifas[2]==2 ) && ($_POST["aprobacion_secundaria_".$id_tarifa_arr]=="0") )	
				$error="* Seleccione la persona que solicita la actualización ";		
			
							
				
			
			
			
			if($error!="")
				{// si tiene errores
					
					?>
                    	<script>
                        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: <?=$error;?>', 60, 5, 10)
							//alert("Verifique la tarifa:\n<?=$error;?>")
                        
                        </script>
                        
                    
                    <?		
					exit();
					
					} //// si tiene errores			
			
			
			if($sql_busca_tarifas[0]==3){//si el contrato ya esta en firma
				$tipo_creacion = 1;
				$estado_tarifa = 3;
			

			if($_POST["aprobacion_secundaria_".$id_tarifa_arr]!=""){
				$aprobacion_responsable = $_POST["aprobacion_secundaria_".$id_tarifa_arr];
				}
			else { 
				$aprobacion_responsable = $sql_busca_tarifas[1];
				
				}
			
			$busca_tarifa_padre = traer_fila_row(query_db("select * from $t3 where t6_tarifas_lista_id = $id_tarifa_arr"));

			if($_POST["modi_convencion_".$id_tarifa_arr]=="1")
				$tipo_modificacion_normal_convencion = 5;

			if($_POST["modi_convencion_".$id_tarifa_arr]=="2")
				$tipo_modificacion_normal_convencion = 2;
			
			$cambia_unidad = $busca_tarifa_padre[6];
			$cambia_moneda = $busca_tarifa_padre[8];
			
			if($_POST["unidad_n_".$id_tarifa_arr]!="")
				$cambia_unidad = $_POST["unidad_n_".$id_tarifa_arr];

			if($_POST["moneda_n_".$id_tarifa_arr]>=1)
				$cambia_moneda = $_POST["moneda_n_".$id_tarifa_arr];
			if($_POST["item_oferta_n_".$id_tarifa_arr]!="")
				$item_oferta_proveedor = $_POST["item_oferta_n_".$id_tarifa_arr];
			if($_POST["fin_vigencia_tarifa_".$id_tarifa_arr]!="")
				$fecha_fin_vigencia = $_POST["fin_vigencia_tarifa_".$id_tarifa_arr];
			else				
				$fecha_fin_vigencia ="0000-00-00";
			
			
			
			$insert = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia,tarifa_padre,fecha_fin_vigencia,t6_tarifas_listas_lista_id,tipo_creacion_modifica,us_aprobacion_actual,creada_luego_firme, consecutivo_tarifa) ";
			  $insert.=  " values ($id_contrato_arr,'$busca_tarifa_padre[2]','$busca_tarifa_padre[3]','".$item_oferta_proveedor."','$busca_tarifa_padre[5]', '$cambia_unidad','$busca_tarifa_padre[7]','$cambia_moneda','".$_POST["valor_tarifa_".$id_tarifa_arr]."', '$id_us_session','$fecha $hora',$busca_tarifa_padre[12],$estado_tarifa,'".$_POST["vigencia_tarifa_".$id_tarifa_arr]."',$busca_tarifa_padre[15],'$fecha_fin_vigencia',$lista_existentes,$tipo_modificacion_normal_convencion,".$aprobacion_responsable.",2, $serial_consecutivo)";
			$sql_ex=query_db($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){
				
			$inserta_aprobacion_secu = "insert into t6_tarifas_aprobadores_secundarios (t6_tarifas_lista_id, us_id, tipo_aprobacion_copia,tarifas_contrato_id, notificado)
			 values ($id_ingreso,".$_POST["aprobacion_secundaria_".$id_tarifa_arr].",1,$id_contrato_arr,1)";
			 $graba_aprobador_secundario=query_db($inserta_aprobacion_secu);
			 
			 if($_POST["copia_".$id_tarifa_arr]==1){//si requiere copias
			echo "aqui".count($_POST["usuario_copia_".id_tarifa_arr]);
			 foreach($_POST["usuario_copia_".$id_tarifa_arr] as $id_us_copia)
			 	{ // for copia
					$inserta_aprobacion_secu = "insert into t6_tarifas_aprobadores_secundarios (t6_tarifas_lista_id, us_id, tipo_aprobacion_copia,tarifas_contrato_id, notificado)
					 values ($id_ingreso,".$id_us_copia.",2,$id_contrato_arr,1)";
					 $graba_aprobador_secundario=query_db($inserta_aprobacion_secu);
				
				
				}// for copia
			 
			 }//si requiere copias
				
				if( ($_POST["observa_soporte_".$id_tarifa_arr]!="") || ($_FILES["anexo_soporte_".$id_tarifa_arr]["name"]!="") ){//si trae anexo o comentario
				
								
									echo $cambia_soporte = "insert into t6_tarifas_anexos_modifica_tarifas (t6_tarifas_lista_id,observaciones , anexo,descuento) values (
									$id_ingreso,'".$_POST["observa_soporte_".$id_tarifa_arr]."', '".$_FILES["anexo_soporte_".$id_tarifa_arr]["name"]."',".$_POST["descuento_uni_".$id_tarifa_arr].")";
									$sql_cambi_so=query_db($cambia_soporte.$trae_id_insrte);
									
									$id_ingreso_soporte = id_insert($sql_cambi_so);
			
										if($id_ingreso_soporte>=1){//si se creó el soporte
										
											if($_FILES["anexo_soporte_".$id_tarifa_arr]["name"]!=""){//si tiene anexo
												carga_archivo($_FILES["anexo_soporte_".$id_tarifa_arr]["tmp_name"],"tarifas_ane_modifica/".$id_ingreso_soporte);
												
												
												}//si tiene anexo
										
										}//si se creó el soporte
								
							
				
				}//si trae anexo o comentario
				
			
			/****************************/
			//generacion de email para los parobadores
			/****************************/
			
			
			/****************************/
			//generacion de email para los parobadores
			/****************************/
			$sel_contrato_modulo_contratos = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id = ".$id_contrato_arr));
			$id_log = log_de_procesos_sgpa(5, 59, 0, $sel_contrato_modulo_contratos[0], 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Quien solicita actualizar la tarifa", $_POST["aprobacion_secundaria_".$id_tarifa_arr] , $g1 ,1);
			log_agrega_detalle ($id_log, "Nuevo valor", $_POST["valor_tarifa_".$id_tarifa_arr] , "" ,2);
			log_agrega_detalle ($id_log, "Fecha de inicio de vigencia", $_POST["vigencia_tarifa_".$id_tarifa_arr] , "" ,3);
			if($_POST["descuento_uni_".$id_tarifa_arr] == 1) $apli_desc = "SI"; else $apli_desc = "NO";
			log_agrega_detalle ($id_log, "La tarifa aplica descuento", $apli_desc , "" ,4);
			log_agrega_detalle ($id_log, "Observaciones", $_POST["observa_soporte_".$id_tarifa_arr] , "" ,5);
			log_agrega_detalle ($id_log, "Anexo soporte", $_FILES["anexo_soporte_".$id_tarifa_arr]["name"] , "" ,6);
			
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La tarifa se modificó y se envió para aprobación de Hocol S.A.', 20, 10, 18);
                    //alert("La tarifa se modificó y se envió para aprobación de Hocol S.A.")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó con éxito', 60, 5, 10)
                    //alert("ATENCION:\n *El proceso NO se creó con éxito")
                    </script>
			<?
			}
			
				}//si el contrato ya esta en firma
			else{
			$insert = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia,tarifa_padre,fecha_fin_vigencia,t6_tarifas_listas_lista_id,tipo_creacion_modifica) ";
			echo $insert.=  " values ($id_contrato_arr,'$busca_tarifa_padre[1]','$busca_tarifa_padre[2]','$busca_tarifa_padre[3]','$busca_tarifa_padre[4]', '$busca_tarifa_padre[5]','$busca_tarifa_padre[6]','$busca_tarifa_padre[7]','".$_POST["valor_tarifa_".$id_contrato_arr]."', '$id_us_session','$fecha $hora',$tipo_creacion,$estado_tarifa,'".$_POST["vigencia_tarifa_".$id_contrato_arr]."',$id_contrato_arr,'0000-00-00',$lista_existentes,2 )";
			
				
				$solo_mofifica = "update $t3 set valor='".$_POST["valor_tarifa_".$id_contrato_arr]."', fecha_inicio_vigencia,tarifa_padre";
				
				}
			
			
			
		}
		
	if($_POST["accion"]=="modifica_crea_tarifa_manual")
		{
			
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			
			if($_POST["detalle_m_".$id_tarifa_arr]=="")
				$error="* Digite el detalle ";	
			if($_POST["unidad_tarifa_".$id_tarifa_arr]=="")
				$error="* Digite la unidad de medida  ";	
			if($_POST["moneda_tarifa_".$id_tarifa_arr]=="0")
				$error="* Seleccione la moneda ";	
			if($_POST["valor_tarifa_".$id_tarifa_arr]=="")
				$error="* Digite el valor ";	
			if($_POST["vigencia_tarifa_".$id_tarifa_arr]=="")
				$error="* Seleccione la fecha de inicio de vigencia  ";	
			if($_POST["fecha_vigencia_fin"]!="" and $_POST["fecha_vigencia"]>$_POST["fecha_vigencia_fin"])
				$error="* La fecha inicio vigencia NO puede ser mayor que la fecha fin vigencia";
			if($_POST["fecha_vigencia"]>$_POST["vigencia_contrato"])
				$error="* La fecha inicio vigencia NO puede ser mayor que la fecha de vigencia del contrato (".$_POST["vigencia_contrato"].")";
			if($_POST["fecha_vigencia_fin"]!="" and $_POST["fecha_vigencia_fin"]>$_POST["vigencia_contrato"])
				$error="* La fecha fin vigencia NO puede ser mayor que la fecha de vigencia del contrato (".$_POST["vigencia_contrato"].")";
			
			if($_POST["fecha_vigencia"]<$_POST["inicio_contrato"])
				$error.="* La fecha inicio vigencia NO puede ser menor que la fecha de inicio del contrato (".$_POST["inicio_contrato"].")";

			if($_POST["fecha_vigencia_fin"]!="" and $_POST["fecha_vigencia_fin"]<$_POST["inicio_contrato"])
				$err_m.="* La fecha fin vigencia NO puede ser menor que la fecha de inicio del contrato (".$_POST["inicio_contrato"].")";
			
			
			
			if($error!="")
				{// si tiene errores
					
					?>
                    	<script>
                         window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: <?=$error;?>', 60, 5, 10)
							//alert("Verifique la tarifa:\n<?=$error;?>")
                        
                        </script>
                        
                    
                    <?		
					exit();
					echo $error;
					} //// si tiene errores
			else{ // si no tiene errores
				
				echo $modifica = "update t6_tarifas_lista set codigo_proveedor='".elimina_comillas_2($_POST["codigo_m_".$id_tarifa_arr])."', detalle='".elimina_comillas_2($_POST["detalle_m_".$id_tarifa_arr])."', unidad_medida='".elimina_comillas_2($_POST["unidad_tarifa_".$id_tarifa_arr])."', 
				t1_moneda_id=".$_POST["moneda_tarifa_".$id_tarifa_arr].", valor='".$_POST["valor_tarifa_".$id_tarifa_arr]."', fecha_inicio_vigencia='".$_POST["vigencia_tarifa_".$id_tarifa_arr]."'
				where t6_tarifas_lista_id = $id_tarifa_arr";
				$sql_cambia=query_db($modifica);
				
				if( ($_POST["observa_soporte_".$id_tarifa_arr]!="") || ($_FILES["anexo_soporte_".$id_tarifa_arr]["name"]!="") ){//si trae anexo o comentario
				
					$busca_soporte = traer_fila_row(query_db("select * from t6_tarifas_anexos_modifica_tarifas where t6_tarifas_lista_id = $id_tarifa_arr"));
					if($busca_soporte[0]>=1)
						{//si ya tiene soporte
							
							if($_FILES["anexo_soporte_".$id_tarifa_arr]["name"]!=""){
								$ingresa_anexo=" , anexo = '".$_FILES["anexo_soporte_".$id_tarifa_arr]["name"]."'";
								$borra = $borra=unlink(SUE_PATH_ARCHIVOS."tarifas_ane_modifica/".$busca_soporte[0].".txt");
								carga_archivo($_FILES["anexo_soporte_".$id_tarifa_arr]["tmp_name"],"tarifas_ane_modifica/".$busca_soporte[0]);	
							}
							
							$cambia_soporte = "update t6_tarifas_anexos_modifica_tarifas set observaciones = '".$_POST["observa_soporte_".$id_tarifa_arr]."' $ingresa_anexo where 
							 t6_tarifas_lista_id = $id_tarifa_arr";
							 $sql_cambi_so=query_db($cambia_soporte);
							
							}//si ya tiene soporte
							
							else{//si no tiene soporte
								
									echo $cambia_soporte = "insert into t6_tarifas_anexos_modifica_tarifas (t6_tarifas_lista_id,observaciones , anexo) values (
									$id_tarifa_arr,'".$_POST["observa_soporte_".$id_tarifa_arr]."', '".$_FILES["anexo_soporte_".$id_tarifa_arr]["name"]."')";
									$sql_cambi_so=query_db($cambia_soporte.$trae_id_insrte);
									
									$id_ingreso = id_insert($sql_cambi_so);
			
										if($id_ingreso>=1){//si se creó el soporte
										
											if($_FILES["anexo_soporte_".$id_tarifa_arr]["name"]!=""){//si tiene anexo
												carga_archivo($_FILES["anexo_soporte_".$id_tarifa_arr]["tmp_name"],"tarifas_ane_modifica/".$id_ingreso);
												
												
												}//si tiene anexo
										
										}//si se creó el soporte
								
								}//si no tiene soporte
				
				}//si trae anexo o comentario
				
				
				?>
                    	<script>
                        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La tarifa se modificó', 20, 10, 18);
							//alert("La tarifa se modificó")
		                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                        
                        </script>
                        
                    
                    <?		
				}// si no tiene errores
			
		}


if($_POST["accion"]=="elimina_crea_tarifa_manual")
		{
			
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			
		
				
				$modifica = "delete from t6_tarifas_lista where t6_tarifas_lista_id = $id_tarifa_arr";
				$sql_cambia=query_db($modifica);
				echo $inserta_aprobacion_secu = "delete from t6_tarifas_aprobadores_secundarios where t6_tarifas_lista_id=$id_tarifa_arr";
				$sql_cambia=query_db($inserta_aprobacion_secu);

						//$borra =unlink(SUE_PATH_ARCHIVOS."tarifas_ane_modifica/".$id_tarifa_arr.".txt");
	
							
							 $cambia_soporte = "delete from  t6_tarifas_anexos_modifica_tarifas where 
							 t6_tarifas_lista_id = $id_tarifa_arr";
							 $sql_cambi_so=query_db($cambia_soporte);				
				
				?>
                    	<script>
                        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La tarifa se eliminó', 20, 10, 18);
							//alert("La tarifa se eliminó")
		                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/<?=$ruta_devuelve;?>.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                        
                        </script>
                        
                    
                    <?		
				
			
		}




if($_POST["accion"]=="elimina_crea_tarifa_manual_anexo")
		{
			
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			
		
				
					$borra =unlink(SUE_PATH_ARCHIVOS."tarifas_ane_modifica/".$id_tarifa_arr.".txt");
	
							
							echo $cambia_soporte = "update t6_tarifas_anexos_modifica_tarifas set anexo = '' where 
							 t6_tarifas_anexos_modifica_tarifas_id = $id_tarifa_arr";
							 $sql_cambi_so=query_db($cambia_soporte);
							 
				
				?>
                    	<script>
                        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El anexo se eliminó', 20, 10, 18);
							//alert("El anexo se eliminó")
		                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/<?=$ruta_devuelve;?>.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                        
                        </script>
                        
                    
                    <?		
				
			
		}

	if($_POST["accion"]=="confirma_creacion")
		{
			
			
				$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			
	
					

			$busca_pre_temporal = "select * from $t16 where t6_tarifas_proveedor_prefactura_id = $id_prefactura";
			$sql_busca_temporal_pre_fa=traer_fila_row(query_db($busca_pre_temporal));

			$busca_max_conse = traer_fila_row(query_db("select max(consecutivo) from $t16 "));
			
			$consecutivo_prefactura = (($busca_max_conse[0]*1)+1);		
			
			if($sql_busca_temporal_pre_fa[0]){
				$id_prefactura_general=$sql_busca_temporal_pre_fa[0];
				$cambia = "update $t16 set municipio= '$municipio_pre',fecha_ini='$fecha_inicial', fecha_fin='$fecha_final', id_listas  = '$arreglo_listas_sel', tipo_aiu='$tipo_aiu', valor_aiu='$valor_aiu' ,tipo_contrato = $c_marco, orden_trabajo = '$orden_trabajo' where t6_tarifas_proveedor_prefactura_id=$id_prefactura ";
				$sql_cambia = query_db($cambia);

					$busca_aiu = traer_fila_row(query_db("select * from t6_tarifas_prefactura_aiu where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));
						if($busca_aiu[0]>=1)
							$cambia_aiu = query_db("update t6_tarifas_prefactura_aiu set aplicacion_admin='$aiu_a', porcentaje_admin='$aiu_a_p', 
							aplicacion_imprevisto='$aiu_i', porcentaje_imprevisto='$aiu_i_p',aplicacion_utilidad='$aiu_u', porcentaje_utilidad='$aiu_u_p', estado=1 where t6_tarifas_proveedor_prefactura_id = $id_prefactura");
						else
							$inserta_aiu = query_db("insert into t6_tarifas_prefactura_aiu (t6_tarifas_proveedor_prefactura_id, aplicacion_admin, porcentaje_admin, aplicacion_imprevisto, porcentaje_imprevisto, aplicacion_utilidad, porcentaje_utilidad, estado) values (
							$id_prefactura,'$aiu_a','$aiu_a_p','$aiu_i','$aiu_i_p','$aiu_u','$aiu_u_p',1)");

					$busca_descuento = traer_fila_row(query_db("select * from $t21ta where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));
					if($busca_descuento[0]>=1)
						$modifica_des = query_db("update $t21ta set descuento='".valida_numero_db($valor_descuento)."', observacion= '$detalle_descuento' where t6_tarifas_proveedor_prefactura_id = $id_prefactura" );
					else
						$ingresa_des = query_db("insert into $t21ta (t6_tarifas_proveedor_prefactura_id, descuento,observacion) values ($id_prefactura,'".valida_numero_db($valor_descuento)."', '$detalle_descuento' )");

				
						$proyectos_existentes=",".$id_proyecto_selecc;
						$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $ch_proyectos"));
							if($busca_proyecto[0]=="")
								$insert_pryecto=query_db("insert into $t20 (t6_tarifas_proyectos_id, t6_tarifas_prefactira_id) values ($ch_proyectos, $id_prefactura)");

				
				 $biorra_proyectos_no_seleccionados = "delete from $t20 where t6_tarifas_proyectos_id not in (0 $proyectos_existentes) and t6_tarifas_prefactira_id = $id_prefactura ";
				$sql_borra = query_db($biorra_proyectos_no_seleccionados);
				}
				
				
			else
			{//si no existe tempero lo crea
			
				$inserta_tem_ge = "insert into $t16 (tarifas_contrato_id, fecha_creacion, us_id, estado, consecutivo, municipio, proyecto, fecha_ini, fecha_fin, id_listas,tipo_aiu,valor_aiu,ediciones, editado, tipo_contrato, orden_trabajo)";
			    $inserta_tem_ge.= " values ($id_contrato_arr, '$fecha $hora', ".$_SESSION["id_us_session"].", 2, '$consecutivo_prefactura','$municipio_pre', '$proyecto_pre','$fecha_inicial','$fecha_final','$arreglo_listas_sel',0,0,0,1,$c_marco,  '$orden_trabajo) ";

					$sql_ex=query_db($inserta_tem_ge.$trae_id_insrte);
					$id_prefactura_general = id_insert($sql_ex);
					$id_prefactura=$id_prefactura_general;
		
						$insert_pryecto=query_db("insert into $t20 (t6_tarifas_proyectos_id, t6_tarifas_prefactira_id) values ($ch_proyectos, $id_prefactura_general)");
		
					
			}//si no existe tempero lo crea
			
			if($id_prefactura_general>=1){ // si existe una prefactura temporal
			
				foreach($cantidad_tarifa as $id_tarifa_padre_pri => $cantidad_digitada)
					{ //foreach
					$tarifa_id_arreg="";
					$id_tarifa = "";
					$id_tarifa_padre = "";
					$proyecto_cantidad="";
					
					
					$tarifa_id_arreg=explode("_",$id_tarifa_padre_pri);
					$id_tarifa = $tarifa_id_arreg[0];
					$id_tarifa_padre = $tarifa_id_arreg[1];
					$proyecto_cantidad=$tarifa_id_arreg[2];
					
						if($cantidad_digitada==""){//si el campo esta vacio aseguramos eliminarla
							$delte_tarifa = query_db("delete from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id= $id_tarifa and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $proyecto_cantidad");
						}//si el campo esta vacio aseguramos eliminarla
						else
							{//si el campo esta con cantidad
								
								 $busca_tarifa_tem="select * from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id= $id_tarifa and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $proyecto_cantidad";
								$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
								if($busca_tari_tem[0]>=1){//si existe se modifica
								$cambia_tem="update $t17 set cantidad=".valida_numero_db($cantidad_digitada).",fecha='$fecha $hora', observaciones= '".$_POST["observaciones_".$id_tarifa]."' where t6_tarifas_proveedor_prefactura_detalle_id=$busca_tari_tem[0]";
								$sql_up=query_db($cambia_tem);
								}//si existe se modifica
								else{//si no existe
								
								$inserta_temp = "insert into $t17 (t6_tarifas_proveedor_prefactura_id, t6_tarifas_lista_id, tarifa_padre, tarifas_contrato_id, cantidad, fecha, estado_tarifa_prefactura, rango_fecha_inicial, rango_fecha_final, observaciones,t6_tarifas_prefactura_proyectos_id)";
								$inserta_temp.=" values ($id_prefactura_general,$id_tarifa, $id_tarifa_padre, $id_contrato_arr, ".valida_numero_db($cantidad_digitada).",'$fecha $hora',2,'$fecha_inicial', '$fecha_final','".$_POST["observaciones_".$id_tarifa]."',$proyecto_cantidad)";
							
								$sql_in=query_db($inserta_temp);
								}//si no existe
							
							if($_FILES["soporte_desc_".$id_tarifa]["name"] !="")
									{
										//echo $_FILES["soporte_desc_".$id_tarifa]["name"]." tarifa ".$id_tarifa."<br>"; tarifas_ane_descue
										
									$busca_observa= "select * from t6_tarifas_proveedor_prefactura_anexos where t6_tarifas_proveedor_prefactura_id = $id_prefactura and t6_tarifas_lista_id = $id_tarifa";
									$bus_ob_ta=traer_fila_row(query_db($busca_observa));
										if($bus_ob_ta[0]>=1)
											{
												echo $update = "update t6_tarifas_proveedor_prefactura_anexos set detalle = '".$_FILES["soporte_desc_".$id_tarifa]["name"]."' where t6_tarifas_proveedor_prefactura_anexos_id = $bus_ob_ta[0]";
												$sql_up_o=query_db($update);
												$borra=unlink(SUE_PATH_ARCHIVOS."tarifas_ane_descue/".$bus_ob_ta[0].".txt");
												carga_archivo($_FILES["soporte_desc_".$id_tarifa]["tmp_name"],"tarifas_ane_descue/".$bus_ob_ta[0]);
												
												
												}
										else
											{
												
												echo $update = "insert into t6_tarifas_proveedor_prefactura_anexos  (t6_tarifas_proveedor_prefactura_id, t6_tarifas_lista_id, detalle) values (
												$id_prefactura , ".$id_tarifa.", '".$_FILES["soporte_desc_".$id_tarifa]["name"]."' )";
												$sql_up_o=query_db($update.$trae_id_insrte);

												$id_prefactura_anexo = id_insert($sql_up_o);
												if($id_prefactura_anexo>=1){// si se crea el anexo en la db
												echo $update = "update t6_tarifas_proveedor_prefactura_anexos set detalle = '".$_FILES["soporte_desc_".$id_tarifa]["name"]."' where t6_tarifas_proveedor_prefactura_anexos_id = $bus_ob_ta[0]";
												$sql_up_o=query_db($update);
												
												carga_archivo($_FILES["soporte_desc_".$id_tarifa]["tmp_name"],"tarifas_ane_descue/".$id_prefactura_anexo);
												} // si se crea el anexo en la db
												
												}
					
																
										
										
										
										}
							
							
							}//si el campo esta con cantidad
					
					
					}//foreach
					
					
								$solo_mofifica = query_db("update $t16 set estado=1 where t6_tarifas_proveedor_prefactura_id = $id_prefactura");
	
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El tiquete de servicio se grabó con exito', 20, 10, 18);
                    //alert("El tiquete de servicio se grabó con exito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/v_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura_general;?>','carga_acciones_permitidas');
                    </script>
			<?			
		
			
			}// si existe una prefactura temporal

			else{//si NO existe una prefactura temporal
			
			?>
					<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creó por favor valide la información', 20, 10, 18);
                    //alert("El proceso NO se creó por favor valide la información")
                   // window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?			
			
			
			}//si NO existe una prefactura temporal
			
		}
			
			
			
			

	if($_POST["accion"]=="confirma_actualizacion")
		{
					$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id

			$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
			$sql_con=traer_fila_row(query_db($busca_contrato));		

		
			
$busca_consecutivo = "select consecutivo_tarifa from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr order by consecutivo_tarifa desc  ";
$sql_busca_consecutivo = traer_fila_row(query_db($busca_consecutivo));
$serial_consecutivo =$sql_busca_consecutivo[0];

		/******	incorpora consecutivos a las tarias pendientes por crear******************/
		
		$busca_id_cargue = "select t6_tarifas_lista_id from t6_tarifas_lista where  t6_tarifas_estados_tarifas_id in (8,9) and tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $id_lista ";
		$sql_exq = query_db($busca_id_cargue);
		while($lista_tar = traer_fila_row($sql_exq)){
			$serial_consecutivo++;
		
			$cambia_estado = "update t6_tarifas_lista set   us_aprobacion_actual= $sql_con[14], creada_luego_firme=2,  consecutivo_tarifa = $serial_consecutivo where t6_tarifas_lista_id = $lista_tar[0]";
				$sql_ca = query_db($cambia_estado);

		}

		/******	incorpora consecutivos a las tarias pendientes por crear******************/



			$solo_mofifica = query_db("update $t3 set t6_tarifas_estados_tarifas_id=3 where t6_tarifas_estados_tarifas_id in (8,9) and tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $id_lista");





		$asunto_msn="SGPA modificacion de tarifas, contrato: ".$sql_con[7];
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPAuth = false; 
		$mail->SMTPSecure = "";
		$mail->Port       = 25; 
		$mail->Username = $correo_autentica_phpmailer; 
		$mail->Password = $contrasena_autentica_phpmailer; 
		$mail->Host = $servidor_phpmailer;
		$mail->From = $correo_from_phpmiler;
		$mail->FromName = $nombre_from_phpmiler;
		$mail->Subject = $asunto_msn;

		
		
$conte_tex = "<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>  
  <tr>
    <td style='background-color:#999999'><div align='right'><strong>Proveedor:</strong></div></td>
    <td>".$sql_con[6]."</td>
  </tr>
<tr>    <td style='background-color:#999999'><div align='right'><strong>Contrato:</strong></div></td>    <td>".$sql_con[7]."</td>   </tr>  <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     
  <td width='66%'>Creaci&oacute;n de tarifas</td>  
</tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>URL:</strong></div></td>     <td><a href='http://www.abastecimiento.hocol.com.co/'>http://www.abastecimiento.hocol.com.co</a></td>   </tr>
<tr>  <td colspan='2'>El proveedor ha modificado una o varias tarifas y estan pendientes para su aprobaci&oacute;n.</td>  
</tr>  
  </table>
";
$cuerpo =$conte_tex;
		

			if($sql_con[19]!=2){//si no es contrato marco lanza notificacion al gerente
				
				
					$busca_sumpletes_responsable = "select us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr and tipo_suplencia = 1 and  estado = 1 and fecha_suplencia >= '$fecha'  ";
					$sql_busca_sumplentes = traer_fila_row(query_db($busca_sumpletes_responsable));
					if($sql_busca_sumplentes[0]>=1)
						$gerente_responsable=$sql_busca_sumplentes[0];
					else
					$gerente_responsable=$sql_con[14];
		
		
					$inserta_responsable = "insert into t6_tarifas_responsables_aprobadores (tarifas_contrato_id, us_id, roll, estado,fecha) values ($id_contrato_arr,$gerente_responsable,'Gerente de contrato',1 ,'$fecha $hora')";
					$inserta_sql = query_db($inserta_responsable );
		
					$busca_nombre_gerente=traer_fila_row(query_db("select * from $g1 where us_id = $gerente_responsable"));
					
					$mail->AddAddress($busca_nombre_gerente[4],$busca_nombre_gerente[1]);
					//$mail->AddAddress("rene.sterling@enternova.net");
					$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
					$mail->Body = $cuerpo;
					$mail->AltBody = "SGPA Informaciones";
					//$mail->Send();					

			} //si no es contrato marco lanza notificacion al gerente			


			elseif($sql_con[19]==2){//si ES contrato marco lanza notificacion al gerente
			
			$busca_aprobadores_su = "select distinct us_id, email, nombre_administrador from v_tarifas_aprobadores_secundaris where tarifas_contrato_id = $id_contrato_arr and notificado = 1 and tipo_aprobacion_copia = 1";
			$sql_busca_aprobadores_secundarios = query_db($busca_aprobadores_su);	
			
				while($ls_secu = traer_fila_row($sql_busca_aprobadores_secundarios))	{//busca lista secundarios
				
					$inserta_responsable = "insert into t6_tarifas_responsables_aprobadores (tarifas_contrato_id, us_id, roll, estado,fecha) values ($id_contrato_arr,$ls_secu[0],'Responsable solicitante',1 ,'$fecha $hora')";
					$inserta_sql = query_db($inserta_responsable );
					
					
					$mail->AddAddress("rene.sterling@enternova.net");
					$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
					$mail->Body = $cuerpo;
					$mail->AltBody = "SGPA Informaciones";
					//$mail->Send();		

			$cambia_estado_aprobadores_su = "update t6_tarifas_aprobadores_secundarios set notificado = 2 where tarifas_contrato_id = $id_contrato_arr and notificado = 1 and tipo_aprobacion_copia = 1 and us_id = $ls_secu[0]";
			$sql_cambia_notificado = query_db($cambia_estado_aprobadores_su);	
			
			echo $ls_secu[1];
				
				}	//busca lista secundarios
			
			}//si ES contrato marco lanza notificacion al gerente

 

	
		



			
			
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se confirmo con éxito y se notifico a los responsables de aprobación', 20, 10, 18);
                    //alert("El proceso se confirmo con éxito y se notifico a los responsables de aprobación.")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
			
		}


	if($_POST["accion"]=="crea_confirma_actualizacion")
		{
					$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id

		
		echo "update $t3 set t6_tarifas_estados_tarifas_id=3 where t6_tarifas_estados_tarifas_id = 9 and tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $id_lista";
			$solo_mofifica = query_db("update $t3 set t6_tarifas_estados_tarifas_id=3 where t6_tarifas_estados_tarifas_id in (8,9) and tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $id_lista");
			
			$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
			$sql_con=traer_fila_row(query_db($busca_contrato));		

		$asunto_msn="SGPA creacion de tarifas, contrato: ".$sql_con[7];
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPAuth = false; 
		$mail->SMTPSecure = "";
		$mail->Port       = 25; 
		$mail->Username = $correo_autentica_phpmailer; 
		$mail->Password = $contrasena_autentica_phpmailer; 
		$mail->Host = $servidor_phpmailer;
		$mail->From = $correo_from_phpmiler;
		$mail->FromName = $nombre_from_phpmiler;
		$mail->Subject = $asunto_msn;

		
		
$conte_tex = "<table width='98%' border='0' cellspacing='2' cellpadding='2' style='border:solid 1px #000000'>  <tr>    <td colspan='2'><img src='http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png' width='190' height='56' /></td>   </tr>  
  <tr>
    <td style='background-color:#999999'><div align='right'><strong>Proveedor:</strong></div></td>
    <td>".$sql_con[6]."</td>
  </tr>
<tr>    <td style='background-color:#999999'><div align='right'><strong>Contrato:</strong></div></td>    <td>".$sql_con[7]."</td>   </tr>  <tr>    <td width='34%' style='background-color:#999999'><div align='right'><strong>Asunto:</strong></div></td>     
  <td width='66%'>Creaci&oacute;n de tarifas</td>  
</tr>  <tr>    <td style='background-color:#999999'><div align='right'><strong>URL:</strong></div></td>     <td><a href='http://www.abastecimiento.hocol.com.co/'>http://www.abastecimiento.hocol.com.co</a></td>   </tr>
<tr>  <td colspan='2'>El proveedor ha creado una o varias tarifas y estan pendientes para su aprobaci&oacute;n.</td>  
</tr>  
  </table>
";
$cuerpo =$conte_tex;
		

			if($sql_con[19]!=2){//si no es contrato marco lanza notificacion al gerente
					$busca_sumpletes_responsable = "select us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr and tipo_suplencia = 1 and  estado = 1 and fecha_suplencia >= '$fecha'  ";
					$sql_busca_sumplentes = traer_fila_row(query_db($busca_sumpletes_responsable));
					if($sql_busca_sumplentes[0]>=1)
						$gerente_responsable=$sql_busca_sumplentes[0];
					else
					$gerente_responsable=$sql_con[14];
		
		
					$inserta_responsable = "insert into t6_tarifas_responsables_aprobadores (tarifas_contrato_id, us_id, roll, estado,fecha) values ($id_contrato_arr,$gerente_responsable,'Gerente de contrato',1 ,'$fecha $hora')";
					$inserta_sql = query_db($inserta_responsable );
		
					$busca_nombre_gerente=traer_fila_row(query_db("select * from $g1 where us_id = $gerente_responsable"));
					
					$mail->AddAddress($busca_nombre_gerente[4],$busca_nombre_gerente[1]);
					$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
					$mail->Body = $cuerpo;
					$mail->AltBody = "SGPA Informaciones";
					$mail->Send();					

			} //si no es contrato marco lanza notificacion al gerente			
			elseif($sql_con[19]==2){//si ES contrato marco lanza notificacion al gerente
			
			$busca_aprobadores_su = "select distinct us_id, email, nombre_administrador from v_tarifas_aprobadores_secundaris where tarifas_contrato_id = $id_contrato_arr and notificado = 1 and tipo_aprobacion_copia = 1";
			$sql_busca_aprobadores_secundarios = query_db($busca_aprobadores_su);	
			
				while($ls_secu = traer_fila_row($sql_busca_aprobadores_secundarios))	{//busca lista secundarios
				
					$inserta_responsable = "insert into t6_tarifas_responsables_aprobadores (tarifas_contrato_id, us_id, roll, estado,fecha) values ($id_contrato_arr,$ls_secu[0],'Responsable solicitante',1 ,'$fecha $hora')";
					$inserta_sql = query_db($inserta_responsable );
					
					
					$mail->AddAddress($ls_secu[1],$ls_secu[2]);
					$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
					$mail->Body = $cuerpo;
					$mail->AltBody = "SGPA Informaciones";
					//$mail->Send();		

			$cambia_estado_aprobadores_su = "update t6_tarifas_aprobadores_secundarios set notificado = 2 where tarifas_contrato_id = $id_contrato_arr and notificado = 1 and tipo_aprobacion_copia = 1 and us_id = $ls_secu[0]";
			$sql_cambia_notificado = query_db($cambia_estado_aprobadores_su);	
			
			echo $ls_secu[1];
				
				}	//busca lista secundarios
			
			}//si ES contrato marco lanza notificacion al gerente

			echo $busca_nombre_gerente[4]."----".$busca_nombre_gerente[1]."<br>";
						echo $busca_nombre_jefe_area[4]."----".$busca_nombre_jefe_area[1]."<br>";
			
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se confirmo con éxito y se notifico a los responsables de aprobación', 20, 10, 18);
                    //alert("El proceso se confirmo con éxito y se notifico a los responsables de aprobación.")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
			
		}



function valida_decimal($valor)
	{
		
	if($valor!=""){
		if($valor>=0)
			return $valor = floatval($valor);
			

		else{
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Valide el valor digitado', 20, 10, 18);
			//alert('Valide el valor digitado')
			window.parent.document.getElementById("cargando").style.display="none"
            </script>
			<?
			exit();
			
		}
	}
			
		
		}
	

	if($_POST["accion"]=="prefactura_temporal")
		{
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			
			$cuenta_proyectos = count($ch_proyectos);
			if($cuenta_proyectos==0) { echo "<script>window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione por lo menos un proyecto', 20, 10, 18);//alert('Seleccione por lo menos un proyecto'); window.parent.document.getElementById('cargando').style.display='none'; </script>";
			
			exit();
			}
			if($_POST["tp_moneda"]==0 or $_POST["tp_moneda"]=="" or $_POST["tp_moneda"]==" "){//VALIDACION PARA EL DES001-18
				?>
				<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione un tipo de moneda', 20, 10, 18);
					window.parent.document.getElementById("tp_moneda").className = "select_faltantes";
					//alert('Seleccione por lo menos un proyecto'); window.parent.document.getElementById('cargando').style.display='none';
				</script>
				<?
				exit();
			}//FIN VALIDACION PARA EL DES001-18
			 $aiu_a_p= valida_decimal($aiu_a_p);
			$aiu_i_p= valida_decimal($aiu_i_p);
			$aiu_u_p= valida_decimal($aiu_u_p);

		echo $aiu_u_p;
			if($muni_selecci>=1)
				$municipio_pre=$muni_selecci;


			$busca_pre_temporal = "select * from $t16 where t6_tarifas_proveedor_prefactura_id = $id_prefactura";
			
			$busca_max_conse = traer_fila_row(query_db("select max(consecutivo) from $t16 "));
			
			
			
			$consecutivo_prefactura = (($busca_max_conse[0]*1)+1);
			$sql_busca_temporal_pre_fa=traer_fila_row(query_db($busca_pre_temporal));
			if($sql_busca_temporal_pre_fa[0]>=1){
				
				$id_prefactura_general=$sql_busca_temporal_pre_fa[0];
				$cambia = "update $t16 set municipio= '$municipio_pre',fecha_ini='$fecha_inicial', fecha_fin='$fecha_final', id_listas  = '$arreglo_listas_sel', tipo_aiu='$tipo_aiu', valor_aiu='$valor_aiu', tipo_contrato = $c_marco, orden_trabajo = '$orden_trabajo', tp_moneda_tiquete = '".$tp_moneda."' where t6_tarifas_proveedor_prefactura_id=$id_prefactura ";
				$sql_cambia = query_db($cambia);
					$busca_aiu = traer_fila_row(query_db("select * from t6_tarifas_prefactura_aiu where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));

							if( ($aiu_a==3) || ($aiu_a==4) ) $aiu_a_p="Null";
							if( ($aiu_i==3) || ($aiu_i==4) ) $aiu_i_p="Null";
							if( ($aiu_u==3) || ($aiu_u==4) ) $aiu_u_p="Null";


						if($busca_aiu[0]>=1){
							$cambia_aiu = query_db("update t6_tarifas_prefactura_aiu set aplicacion_admin='$aiu_a', porcentaje_admin=$aiu_a_p, 
							aplicacion_imprevisto='$aiu_i', porcentaje_imprevisto=$aiu_i_p,aplicacion_utilidad='$aiu_u', porcentaje_utilidad=$aiu_u_p, estado=1 where t6_tarifas_proveedor_prefactura_id = $id_prefactura");
							
							}
						else {
							$inserta_aiu = query_db("insert into t6_tarifas_prefactura_aiu (t6_tarifas_proveedor_prefactura_id, aplicacion_admin, porcentaje_admin, aplicacion_imprevisto, porcentaje_imprevisto, aplicacion_utilidad, porcentaje_utilidad, estado) values (
							$id_prefactura,'$aiu_a',$aiu_a_p,'$aiu_i',$aiu_i_p,'$aiu_u',$aiu_u_p,1)");
							
							
							}
							

					$busca_descuento = traer_fila_row(query_db("select * from $t21ta where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));
					if($busca_descuento[0]>=1)
						$modifica_des = query_db("update $t21ta set descuento='".valida_numero_db($valor_descuento)."', observacion= '$detalle_descuento' where t6_tarifas_proveedor_prefactura_id = $id_prefactura" );
					else
						$ingresa_des = query_db("insert into $t21ta (t6_tarifas_proveedor_prefactura_id, descuento,observacion) values ($id_prefactura,'".valida_numero_db($valor_descuento)."', '$detalle_descuento' )");

				
				foreach($ch_proyectos as $id_proyecto_selecc){//proyectos for
						
						$proyectos_existentes.=",".$id_proyecto_selecc;
						
						$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $id_proyecto_selecc"));
							if($busca_proyecto[0]==""){
								echo "insert into $t20 (t6_tarifas_proyectos_id, t6_tarifas_prefactira_id) values ($id_proyecto_selecc, $id_prefactura)";
								$insert_pryecto=query_db("insert into $t20 (t6_tarifas_proyectos_id, t6_tarifas_prefactira_id) values ($id_proyecto_selecc, $id_prefactura)");
							
							
								
							}
					
				} //proyectos for
			
				
				  $biorra_proyectos_no_seleccionados = "delete from $t20 where t6_tarifas_proyectos_id not in (0 $proyectos_existentes) and t6_tarifas_prefactira_id = $id_prefactura ";
				$sql_borra = query_db($biorra_proyectos_no_seleccionados);
				}
				
				
			else
			{//si no existe tempero lo crea
			
				$inserta_tem_ge = "insert into $t16 (tarifas_contrato_id, fecha_creacion, us_id, estado, consecutivo, municipio, proyecto, fecha_ini, fecha_fin, id_listas,tipo_aiu,valor_aiu,ediciones, editado, tipo_contrato, orden_trabajo, tp_moneda_tiquete)";  
			    $inserta_tem_ge.= " values ($id_contrato_arr, '$fecha $hora', ".$_SESSION["id_us_session"].", 2, '$consecutivo_prefactura','$municipio_pre', '$proyecto_pre','$fecha_inicial','$fecha_final','$arreglo_listas_sel',0,0,0,1,$c_marco,  '$orden_trabajo', '".$tp_moneda."') ";
					$sql_ex=query_db($inserta_tem_ge.$trae_id_insrte);
					$id_prefactura_general = id_insert($sql_ex);
					$id_prefactura=$id_prefactura_general;
		
			foreach($ch_proyectos as $id_proyecto_selecc){//proyectos for
						
						$proyectos_existentes=",".$id_proyecto_selecc;
						$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $id_proyecto_selecc"));
							if($busca_proyecto[0]==""){
								$insert_pryecto=query_db("insert into $t20 (t6_tarifas_proyectos_id, t6_tarifas_prefactira_id) values ($id_proyecto_selecc, $id_prefactura)");
							
							
								
							}		
							
							
			}//proyectos for
					
			}//si no existe tempero lo crea
			
			if($id_prefactura_general>=1){ // si existe una prefactura temporal
			
				foreach($cantidad_tarifa as $id_tarifa_padre_pri => $cantidad_digitada)
					{ //foreach
					$tarifa_id_arreg="";
					$id_tarifa = "";
					$id_tarifa_padre = "";
					$proyecto_cantidad="";
					$id_tarifa_ultima="";
					
					$cantidad_digitada= valida_decimal($cantidad_digitada);
					
					$tarifa_id_arreg=explode("_",$id_tarifa_padre_pri);
					$id_tarifa = $tarifa_id_arreg[0];
					$id_tarifa_padre = $tarifa_id_arreg[1];
					$proyecto_cantidad=$tarifa_id_arreg[2];
					
						if($cantidad_digitada==""){//si el campo esta vacio aseguramos eliminarla
							$delte_tarifa = query_db("delete from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id= $id_tarifa and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $proyecto_cantidad");
						}//si el campo esta vacio aseguramos eliminarla
						else
							{//si el campo esta con cantidad
								
								 $busca_tarifa_tem="select * from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id= $id_tarifa and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $proyecto_cantidad";
								$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
								
								if($busca_tari_tem[0]>=1){//si existe se modifica
								$cambia_tem="update $t17 set cantidad=".valida_numero_db($cantidad_digitada).",fecha='$fecha $hora', observaciones= '".$_POST["observaciones_".$id_tarifa]."' where t6_tarifas_proveedor_prefactura_detalle_id=$busca_tari_tem[0]";
								$sql_up=query_db($cambia_tem);
								}//si existe se modifica
								
								else{//si no existe
								
								$inserta_temp = "insert into $t17 (t6_tarifas_proveedor_prefactura_id, t6_tarifas_lista_id, tarifa_padre, tarifas_contrato_id, cantidad, fecha, estado_tarifa_prefactura, rango_fecha_inicial, rango_fecha_final, observaciones,t6_tarifas_prefactura_proyectos_id)";
								$inserta_temp.=" values ($id_prefactura_general,$id_tarifa, $id_tarifa_padre, $id_contrato_arr, ".valida_numero_db($cantidad_digitada).",'$fecha $hora',2,'$fecha_inicial', '$fecha_final','".$_POST["observaciones_".$id_tarifa]."',$proyecto_cantidad)";
								$sql_in=query_db($inserta_temp);
								}//si no existe
							
								if($_FILES["soporte_desc_".$id_tarifa]["name"] !="")
									{
										//echo $_FILES["soporte_desc_".$id_tarifa]["name"]." tarifa ".$id_tarifa."<br>"; tarifas_ane_descue
										
									$busca_observa= "select * from t6_tarifas_proveedor_prefactura_anexos where t6_tarifas_proveedor_prefactura_id = $id_prefactura and t6_tarifas_lista_id = $id_tarifa";
									$bus_ob_ta=traer_fila_row(query_db($busca_observa));
										if($bus_ob_ta[0]>=1)
											{
												echo $update = "update t6_tarifas_proveedor_prefactura_anexos set detalle = '".$_FILES["soporte_desc_".$id_tarifa]["name"]."' where t6_tarifas_proveedor_prefactura_anexos_id = $bus_ob_ta[0]";
												$sql_up_o=query_db($update);
												$borra=unlink(SUE_PATH_ARCHIVOS."tarifas_ane_descue/".$bus_ob_ta[0].".txt");
												carga_archivo($_FILES["soporte_desc_".$id_tarifa]["tmp_name"],"tarifas_ane_descue/".$bus_ob_ta[0]);
												
												
												}
										else
											{
												
												echo $update = "insert into t6_tarifas_proveedor_prefactura_anexos  (t6_tarifas_proveedor_prefactura_id, t6_tarifas_lista_id, detalle) values (
												$id_prefactura , ".$id_tarifa.", '".$_FILES["soporte_desc_".$id_tarifa]["name"]."' )";
												$sql_up_o=query_db($update.$trae_id_insrte);

												$id_prefactura_anexo = id_insert($sql_up_o);
												if($id_prefactura_anexo>=1){// si se crea el anexo en la db
												echo $update = "update t6_tarifas_proveedor_prefactura_anexos set detalle = '".$_FILES["soporte_desc_".$id_tarifa]["name"]."' where t6_tarifas_proveedor_prefactura_anexos_id = $bus_ob_ta[0]";
												$sql_up_o=query_db($update);
												
												carga_archivo($_FILES["soporte_desc_".$id_tarifa]["tmp_name"],"tarifas_ane_descue/".$id_prefactura_anexo);
												} // si se crea el anexo en la db
												
												}
					
																
										
										
										
										}
							
								
							
							}//si el campo esta con cantidad
					
					
					}//foreach
					
					
					
					foreach($observac as $id_tarifa_padre_pri_ob => $v_observ){//for observaciones
					
						if($v_observ!=""){//si trae observaciones
						$busca_observa= "select * from t6_tarifas_proveedor_prefactura_observaciones where t6_tarifas_proveedor_prefactura_id = $id_prefactura and t6_tarifas_lista_id = $id_tarifa_padre_pri_ob";
						$bus_ob_ta=traer_fila_row(query_db($busca_observa));
							if($bus_ob_ta[0]>=1)
								{
									$update = "update t6_tarifas_proveedor_prefactura_observaciones set detalle = '$v_observ' where t6_tarifas_proveedor_prefactura_observaciones_id = $bus_ob_ta[0]";
									$sql_up_o=query_db($update);
									
									}
							else
								{
									
									echo $update = "insert into t6_tarifas_proveedor_prefactura_observaciones  (t6_tarifas_proveedor_prefactura_id, t6_tarifas_lista_id, detalle) values (
									$id_prefactura , $id_tarifa_padre_pri_ob, '$v_observ')";
									$sql_up_o=query_db($update);
									
									}
					
						}//si trae observaciones
					
					}
					
					//for observaciones
					
					echo "aqui 2".$tipo_de_grabacion;
			if($tipo_de_grabacion==1){//si esta en firme
		
			$solo_mofifica = query_db("update $t16 set estado=1 where t6_tarifas_proveedor_prefactura_id = $id_prefactura");
	
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El tiquete de servicio se grabó con exito', 20, 10, 18);
                    //alert("El tiquete de servicio se grabó con exito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/v_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura_general;?>','carga_acciones_permitidas');
                    </script>
			<?			

			}//si esta en firme
			
			

//				if($tipo_de_grabacion==2 and $_POST["muestra_alerta"] == "SI"){//si esta en temporal		
				if($tipo_de_grabacion==2 and $_POST["muestra_alerta"] != "NO"){//si esta en temporal		
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'Tiquete de servicio se grabó temporalmente', 20, 10, 18);
                    //alert("tiquete de servicio se grabó temporalmente")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/e_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura;?>&pagina=<?=$pagina;?>','carga_acciones_permitidas');
                    </script>
			<?			
		
				
				}//si esta en temporal	
			}// si existe una prefactura temporal

			else{//si NO existe una prefactura temporal
			
			?>
					<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creó por favor valide la información', 20, 10, 18)
                    //alert("El proceso NO se creó por favor valide la información")
                   // window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?			
			
			
			}//si NO existe una prefactura temporal
			
			
		}
	
	if($_POST["accion"]=="elimina_anex")
		{	

//						$busca_observa= "select * from t6_tarifas_proveedor_prefactura_anexos where t6_tarifas_proveedor_prefactura_anexos_id = $id_an_e";
						$borra=query_db("delete from t6_tarifas_proveedor_prefactura_anexos where t6_tarifas_proveedor_prefactura_anexos_id = $id_an_e");
						$borra=unlink(SUE_PATH_ARCHIVOS."tarifas_ane_descue/".$bus_ob_ta[0].".txt");
	
		
		?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El anexo se eliminó del tiquete', 20, 10, 18);
                    //alert("El anexo se eliminó del tiquete.")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/e_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura;?>&pagina=<?=$pagina;?>','carga_acciones_permitidas');
                    </script>
			<?		
		
		}
	
		
/********************************************************************************************************************************
********************************************************************************************************************************
REEMBOLSABLE
********************************************************************************************************************************
*********************************************************************************************************************************/		

	if($_POST["accion"]=="prefactura_reembolsable")
		{
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_reembolsable_porcentaje = elimina_comillas(arreglo_recibe_variables($id_reembolsable_porcentaje_or));//recibe id
			$id_reembolsable_factura = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura_or));//recibe id
			if($_POST["tp_moneda"]==0 or $_POST["tp_moneda"]=="" or $_POST["tp_moneda"]==" "){//VALIDACION PARA EL DES001-18
				?>
				<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione un tipo de moneda.', 20, 10, 18);
					window.parent.document.getElementById("tp_moneda").className = "select_faltantes";
					//alert('Seleccione por lo menos un proyecto'); window.parent.document.getElementById('cargando').style.display='none';
				</script>
				<?
				exit();
			}//FIN VALIDACION PARA EL DES001-18
	
					
			$cuenta_proyectos = count($ch_proyectos);
			if($cuenta_proyectos==0) { echo "<script>window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione por lo menos un proyecto', 20, 10, 18);//alert('Seleccione por lo menos un proyecto'); window.parent.document.getElementById('cargando').style.display='none'; </script>";
			
			exit();
			}



	
			if($muni_selecci>=1)
				$municipio_pre=$muni_selecci;
					

			 $busca_pre_temporal = "select * from $ta23 where t6_tarifas_reembolables_datos_id = $id_reembolsable_factura";
			$sql_busca_temporal_pre_fa=traer_fila_row(query_db($busca_pre_temporal));
			
			if($sql_busca_temporal_pre_fa[0]){
				$id_prefactura_general=$id_reembolsable_factura;
				
				echo $cambia = "update $ta23 set t6_tarifas_reembosables1_contrato_id=$id_reembolsable_porcentaje, municipio= '$municipio_pre',fecha_ini='$fecha_inicial', fecha_fin='$fecha_final', tipo_contrato= $c_marco, orden_trabajo='$orden_trabajo', tp_moneda_tiquete=".$_POST["tp_moneda"]." where t6_tarifas_reembolables_datos_id=$id_prefactura_general ";
				$sql_cambia = query_db($cambia);
				
				$borra_todo_pro = query_db("delete from t6_tarifas_reembolsables_proyectos where t6_tarifas_reembolables_datos_id = $id_prefactura_general");
				foreach($ch_proyectos as $id_proyecto)
					{
						
						$in_p="insert into t6_tarifas_reembolsables_proyectos (t6_tarifas_reembolables_datos_id, t6_tarifas_municipios_proyectos_id) values ($id_prefactura_general, $id_proyecto)";
						$sql_in_pr=query_db($in_p);
						
						$borra_deta.=$id_proyecto.",";
						}

				echo $elimina_detalle = 	query_db("delete from $ta25 where t6_tarifas_reembolables_datos_id = $id_prefactura_general and t6_tarifas_municipios_proyectos_id not in ($borra_deta 0)");

			}
			else
			{//si no existe tempero lo crea
			
				$inserta_tem_ge = "insert into $ta23 (tarifas_contrato_id, t6_tarifas_reembosables1_contrato_id, fecha_creacion, us_id, estado,  municipio, proyecto, fecha_ini, fecha_fin,tipo_contrato,orden_trabajo,consecutivo,editado,numero_ediciones, tp_moneda_tiquete)";
			     $inserta_tem_ge.= " values ($id_contrato_arr, $id_reembolsable_porcentaje, '$fecha $hora', ".$_SESSION["id_us_session"].", 2, '$municipio_pre', '','$fecha_inicial','$fecha_final',$c_marco,'$orden_trabajo',0,0,0, ".$_POST["tp_moneda"].") ";
					$sql_ex=query_db($inserta_tem_ge.$trae_id_insrte);
					$id_prefactura = id_insert($sql_ex);
					$id_prefactura_general=$id_prefactura;
					
				$busca_maximo_item = traer_fila_row(query_db("select max(consecutivo) from $ta23 "));
			 $con_ree = ($busca_maximo_item[0] +1);
					$cambia_consecutivo=query_db("update $ta23 set consecutivo = $con_ree where t6_tarifas_reembolables_datos_id = $id_prefactura_general");
		
				foreach($ch_proyectos as $id_proyecto)
					{
						
						echo $in_p="insert into t6_tarifas_reembolsables_proyectos (t6_tarifas_reembolables_datos_id, t6_tarifas_municipios_proyectos_id) values ($id_prefactura_general, $id_proyecto)";
						$sql_in_pr=query_db($in_p);
						
						
						}
					
			}//si no existe tempero lo crea
			
			if($id_prefactura_general>=1){ // si existe una prefactura temporal
						
			?>
					<script> 
                    //alert("La prefactura se grabó temporalmente")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/e_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=arreglo_pasa_variables($id_prefactura_general);?>','carga_acciones_permitidas');
                    </script>
			<?			
		
			
			}// si existe una prefactura temporal

			else{//si NO existe una prefactura temporal
			
			?>
					<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creó por favor valide la información', 20, 10, 18);
                    //alert("El proceso NO se creó por favor valide la información")
                   // window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?			
			
			
			}//si NO existe una prefactura temporal
			
		}




if($_POST["accion"]=="prefactura_reembolsable_detalle")
		{
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_reembolsable_porcentaje = elimina_comillas(arreglo_recibe_variables($id_reembolsable_porcentaje_or));//recibe id
			$id_reembolsable_factura = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura_or));//recibe id
			
	
				if($_POST["tp_moneda"]==0 or $_POST["tp_moneda"]=="" or $_POST["tp_moneda"]==" "){//VALIDACION PARA EL DES001-18
					?>
					<script>
						window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione un tipo de moneda.', 20, 10, 18);
						window.parent.document.getElementById("tp_moneda").className = "select_faltantes";
						//alert('Seleccione por lo menos un proyecto'); window.parent.document.getElementById('cargando').style.display='none';
					</script>
					<?
					exit();
				}//FIN VALIDACION PARA EL DES001-18		

			
				$inserta_tem_ge = "insert into $ta25 (t6_tarifas_reembolables_datos_id, t6_tarifas_reembolables_categoria_id, fecha_creacion, us_id, valor,  moneda, detalle, factura, anexo,estado,t6_tarifas_municipios_proyectos_id)";
			    $inserta_tem_ge.= " values ($id_reembolsable_factura, $categoria_reem, '$fecha $hora', ".$_SESSION["id_us_session"].", '".valida_numero_db($valor_r)."', ".$_POST["tp_moneda"].",'".elimina_comillas_5($detalle_r)."','".elimina_comillas_5($factura_r)."','$anexo_r_name',1,$proyec_reem) ";
				$sql_ex=query_db($inserta_tem_ge.$trae_id_insrte);
				$id_prefactura = id_insert($sql_ex);
				$id_prefactura_general=$id_prefactura;
			
				if($id_prefactura_general>=1){ // si existe una prefactura temporal
				carga_archivo($anexo_r,"tarifas_reembolsables/".$id_prefactura_general);
						
			?>
					<script> 
                    //alert("La prefactura se grabó temporalmente")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/e_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=arreglo_pasa_variables($id_reembolsable_factura);?>','carga_acciones_permitidas');
                    </script>
			<?			
		
			
			}// si existe una prefactura temporal

			else{//si NO existe una prefactura temporal
			
			?>
					<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creó por favor valide la información', 20, 10, 18);
                    //alert("El proceso NO se creó por favor valide la información")
                   // window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?			
			
			
			}//si NO existe una prefactura temporal
			
		}
		
		
if($_POST["accion"]=="edita_prefactura_reembolsable_detalle")
		{
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_reembolsable_detalle = elimina_comillas(arreglo_recibe_variables($t6_tarifas_reembolables_datos_detalle_id));//recibe id
			$id_reembolsable_factura = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura_or));//recibe id
			
	
			if($_FILES["anexo_r_".$id_reembolsable_detalle]["name"]!=""){
				$anexo_sube =  $_FILES["anexo_r_".$id_reembolsable_detalle]["name"];					
					$graba_archi =",anexo='".$anexo_sube."'";
					$borra=unlink(SUE_PATH_ARCHIVOS."tarifas_reembolsables/".$id_reembolsable_detalle.".txt");
					carga_archivo($_FILES["anexo_r_".$id_reembolsable_detalle]["tmp_name"],"tarifas_reembolsables/".$id_reembolsable_detalle);
			}

				echo $inserta_tem_ge = "update $ta25 set  t6_tarifas_reembolables_categoria_id=".$_POST["categoria_r_".$id_reembolsable_detalle]."
				, valor='".valida_numero_db($_POST["valor_r_".$id_reembolsable_detalle])."', 
				 moneda= ".$_POST["moneda_r_".$id_reembolsable_detalle].", 
				 detalle='".elimina_comillas_5($_POST["detalle_r_".$id_reembolsable_detalle])."', 
				 factura='".elimina_comillas_5($_POST["factura_r_".$id_reembolsable_detalle])."' $graba_archi , t6_tarifas_municipios_proyectos_id = 
				 ".$_POST["proyec_reem_".$id_reembolsable_detalle]." 
				where t6_tarifas_reembolables_datos_detalle_id = $id_reembolsable_detalle";

					$sql_ex=query_db($inserta_tem_ge);
		
			
						
			?>
					<script> 
                    //alert("La prefactura se grabó temporalmente")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/e_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=arreglo_pasa_variables($id_reembolsable_factura);?>','carga_acciones_permitidas');
                    </script>
			<?			
		
			
			
		}
		

if($_POST["accion"]=="eliminaprefactura_reembolsable_detalle")
		{
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_reembolsable_detalle = elimina_comillas(arreglo_recibe_variables($t6_tarifas_reembolables_datos_detalle_id));//recibe id
			$id_reembolsable_factura = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura_or));//recibe id
			
	

				echo $inserta_tem_ge = "delete from $ta25 where t6_tarifas_reembolables_datos_detalle_id = $id_reembolsable_detalle";
				$sql_ex=query_db($inserta_tem_ge);
		
			
						
			?>
					<script> 
                    //alert("La prefactura se grabó temporalmente")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/e_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=arreglo_pasa_variables($id_reembolsable_factura);?>','carga_acciones_permitidas');
                    </script>
			<?			
		
			
			
		}		


if($_POST["accion"]=="prefactura_reembolsable_enfirme")
		{
			
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_reembolsable_porcentaje = elimina_comillas(arreglo_recibe_variables($id_reembolsable_porcentaje_or));//recibe id
			$id_reembolsable_factura = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura_or));//recibe id
			
				
				echo $cambia = "update $ta23 set t6_tarifas_reembosables1_contrato_id=$id_reembolsable_porcentaje, estado = 1, municipio= '$municipio_pre',fecha_ini='$fecha_inicial', fecha_fin='$fecha_final', tipo_contrato= $c_marco, orden_trabajo='$orden_trabajo' where t6_tarifas_reembolables_datos_id=$id_reembolsable_factura ";
				$sql_cambia = query_db($cambia);
				
				$borra_todo_pro = query_db("delete from t6_tarifas_reembolsables_proyectos where t6_tarifas_reembolables_datos_id = $id_prefactura_general");
				foreach($ch_proyectos as $id_proyecto)
					{
						
						echo $in_p="insert into t6_tarifas_reembolsables_proyectos (t6_tarifas_reembolables_datos_id, t6_tarifas_municipios_proyectos_id) values ($id_prefactura_general, $id_proyecto)";
						$sql_in_pr=query_db($in_p);
						
						
						}


						
			?>
					<script> 
                    //alert("La prefactura se grabó temporalmente")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/v_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura_or=<?=arreglo_pasa_variables($id_reembolsable_factura);?>','carga_acciones_permitidas');
                    </script>
			<?			
		
			
			
			
		}
		

/********************************************************************************************************************************
********************************************************************************************************************************
REEMBOLSABLE
********************************************************************************************************************************
*********************************************************************************************************************************/		


/********************************************************************************************************************************
********************************************************************************************************************************
edita prefactura en firme
********************************************************************************************************************************
*********************************************************************************************************************************/		

if($_POST["accion"]=="edita_prefactura_firme")
	{
		
		 $insert_ed = "insert into t6_tarifas_proveedor_prefactura select tarifas_contrato_id, '$fecha $hora', us_id, 2, consecutivo, municipio, proyecto, fecha_ini, fecha_fin, id_listas, tipo_aiu, valor_aiu, (ediciones+1),1, tipo_contrato, orden_trabajo,tp_moneda_tiquete from t6_tarifas_proveedor_prefactura where t6_tarifas_proveedor_prefactura_id = $pre_edita";
		$sql_ex=query_db($insert_ed.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
				if($id_ingreso>=1){		//si se creó la edicion

		

				$cambio=query_db("update t6_tarifas_proveedor_prefactura set editado = 2 where t6_tarifas_proveedor_prefactura_id = $pre_edita");	
					
				
				$busca_proyectos = query_db("select * from t6_tarifas_prefactura_proyectos where t6_tarifas_prefactira_id = $pre_edita");
				while($l_pro=traer_fila_row($busca_proyectos)){//busca proyectos
				
				 $insert_proyectos = "insert into t6_tarifas_prefactura_proyectos (t6_tarifas_proyectos_id,t6_tarifas_prefactira_id ) values 
					($l_pro[1],$id_ingreso )";
					$sql_ex_proyect=query_db($insert_proyectos.$trae_id_insrte);	
					$id_ingreso_proyecto = id_insert($sql_ex_proyect);
						if($id_ingreso_proyecto>=1){//si ingreso el proyecto
							
							$insert_detalle = "insert into t6_tarifas_proveedor_prefactura_detalle 
							select $id_ingreso,  t6_tarifas_lista_id, tarifa_padre, tarifas_contrato_id, cantidad, fecha, estado_tarifa_prefactura, rango_fecha_inicial, rango_fecha_final, observaciones, $id_ingreso_proyecto from t6_tarifas_proveedor_prefactura_detalle where t6_tarifas_proveedor_prefactura_id = $pre_edita and t6_tarifas_prefactura_proyectos_id = $l_pro[0]";
							$sql_ex=query_db($insert_detalle);
							
							
							}//si ingreso el proyecto
				
				} //busca proyectos
				
	
					
					
				$insert_descuentos = "insert into t6_tarifas_prefactura_descunetos_proveedor 
					select $id_ingreso, descuento, observacion from t6_tarifas_prefactura_descunetos_proveedor where t6_tarifas_proveedor_prefactura_id = $pre_edita";
					$sql_ex=query_db($insert_descuentos);										


				$insert_observ = "insert into t6_tarifas_proveedor_prefactura_observaciones 
					select $id_ingreso, t6_tarifas_lista_id, detalle from t6_tarifas_proveedor_prefactura_observaciones  where t6_tarifas_proveedor_prefactura_id = $pre_edita";
					$sql_ex=query_db($insert_observ);										

				$insert_aui = "insert into t6_tarifas_prefactura_aiu 
					select $id_ingreso, aplicacion_admin, porcentaje_admin, aplicacion_imprevisto, porcentaje_imprevisto, aplicacion_utilidad, porcentaje_utilidad, estado from t6_tarifas_prefactura_aiu where t6_tarifas_proveedor_prefactura_id = $pre_edita";
					$sql_ex=query_db($insert_aui);	
					
			 echo  $busca_anexo= "select t6_tarifas_proveedor_prefactura_anexos_id,t6_tarifas_lista_id,detalle from t6_tarifas_proveedor_prefactura_anexos    where t6_tarifas_proveedor_prefactura_id = $pre_edita";
				$bus_an_ta=query_db($busca_anexo);
				while($busca_anexos=traer_fila_row($bus_an_ta)){
					
				 echo  $ingresa_anexo= "insert into t6_tarifas_proveedor_prefactura_anexos ( t6_tarifas_proveedor_prefactura_id, t6_tarifas_lista_id, detalle) values (
				  $id_ingreso, $busca_anexos[1],'".$busca_anexos[2]."')";
						$sql_ane_des=query_db($ingresa_anexo.$trae_id_insrte);	
						$id_anexos_des = id_insert($sql_ane_des);
							if($id_anexos_des>=1){//si ingreso el anexo
								$copia = copy(SUE_PATH_ARCHIVOS."tarifas_ane_descue/".$busca_anexos[0].".txt",SUE_PATH_ARCHIVOS."tarifas_ane_descue/".$id_anexos_des.".txt");
							
							}//si ingreso el anexo
							
					
					
					}

														
					
			?>
            	<script>
				window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El tiquete de servicos se duplico con exito', 20, 10, 18);
					//alert("El tiquete de servicos se duplico con exito")
					window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/e_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_ingreso;?>','carga_acciones_permitidas')
				</script>
            <?
		
				}//si se creó la edicion
		}

/********************************************************************************************************************************
********************************************************************************************************************************
edita prefactura en firme
********************************************************************************************************************************
*********************************************************************************************************************************/		




/********************************************************************************************************************************
********************************************************************************************************************************
edita reembolsable en firme
********************************************************************************************************************************
*********************************************************************************************************************************/		

if($_POST["accion"]=="edita_reembolsable_firme")
	{
		
		echo $insert_ed = "insert into t6_tarifas_reembolables_datos
		  select tarifas_contrato_id,t6_tarifas_reembosables1_contrato_id, '$fecha $hora', us_id, 2, municipio, proyecto, fecha_ini, fecha_fin, tipo_contrato, orden_trabajo, consecutivo, 0, (numero_ediciones+1) from t6_tarifas_reembolables_datos where t6_tarifas_reembolables_datos_id = $pre_edita";
		$sql_ex=query_db($insert_ed.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
				if($id_ingreso>=1){		//si se creó la edicion

		

				$cambio=query_db("update t6_tarifas_reembolables_datos set editado = 2 where t6_tarifas_reembolables_datos_id = $pre_edita");	
					
				
				$busca_proyectos = query_db("select * from t6_tarifas_reembolsables_proyectos where t6_tarifas_reembolables_datos_id = $pre_edita");
				while($l_pro=traer_fila_row($busca_proyectos)){//busca proyectos
				
				 $insert_proyectos = "insert into t6_tarifas_reembolsables_proyectos (t6_tarifas_reembolables_datos_id,t6_tarifas_municipios_proyectos_id ) values 
					($id_ingreso,$l_pro[2] )";
					$sql_ex_proyect=query_db($insert_proyectos.$trae_id_insrte);	
					$id_ingreso_proyecto = id_insert($sql_ex_proyect);
						
				} //busca proyectos
				
	
					
					
				$insert_detalle = "insert into t6_tarifas_reembolables_datos_detalle 
					select $id_ingreso, t6_tarifas_reembolables_categoria_id,'$fecha $hora',us_id, valor, moneda, detalle, factura, anexo, estado, t6_tarifas_municipios_proyectos_id from t6_tarifas_reembolables_datos_detalle where t6_tarifas_reembolables_datos_id = $pre_edita";
					$sql_ex=query_db($insert_detalle);										


				
							
					
				

														
					
			?>
            	<script>
				window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El reembolsable de servicos se duplico con exito', 20, 10, 18);
					//alert("El reembolsable de servicos se duplico con exito")
					window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/e_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=$id_ingreso;?>','carga_acciones_permitidas')
				</script>
            <?
		
				}//si se creó la edicion
		}

/********************************************************************************************************************************
********************************************************************************************************************************
edita reembolsable en firme
********************************************************************************************************************************
*********************************************************************************************************************************/		


/********************************************************************************************************************************
********************************************************************************************************************************
IPC
********************************************************************************************************************************
*********************************************************************************************************************************/		



if($_POST["accion"]=="modificar_tarifas_ipc")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			$error="";
			$valida_formato_tarifa = valida_valor_tarifa($_POST["valor_ipc"]);
			
			if($valida_formato_tarifa==2)
				$error="* El formato del valor de IPC es incorrecto";	
			
			$valida_valor = number_format($_POST["valor_ipc"],5);
			if($valida_valor==0)
				$error="* El formato del valor de IPC es incorrecto";	

			foreach($ch as $i_t)
				$tar.=",".$i_t;
			
			if($tar=="")
				$error="* Seleccione las tarifas que actualizara el IPC";	
				

	$extencion_anexo = strtolower(extencion_archivos_tarifas($_FILES["archivo_ipc"]["name"]));
			if( ($extencion_anexo!= "rar") && ($extencion_anexo!= "zip") )
				$error="* El anexo debe ser .zip o .rar |$extencion_anexo|";				
			
			if($error!="")
				{// si tiene errores
					
					?>
                    	<script>
                        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: <?=$error;?>', 60, 5, 10)
							//alert("Verifique la actualización:\n<?=$error?>")
                        
                        </script>
                        
                    
                    <?		
					exit();
					
					} //// si tiene errores		


			
			
			

	
	echo $comple= "and t6_tarifas_lista_id in (0 $tar)";

				$estado_tarifa = 9;
		  if( ($categoria_existentes!="no_apli_b") && ($categoria_existentes!="") )
	  	$bus_tarifa_c = " and categoria = '".elimina_comillas_2($categoria_existentes)."' ";

	  if( ($grupo_existentes!="no_apli_b") && ($grupo_existentes!="") )
	  	$bus_tarifa_c.= " and grupo = '".elimina_comillas_2($grupo_existentes)."' ";

	  if($detalle_ta_b!="")
	  	$bus_tarifa_c.= " and detalle like '%".elimina_comillas_2($detalle_ta_b)."%' ";

	  if($codigo_ta_b!="")
	  	$bus_tarifa_c.= " and codigo_proveedo like '%".elimina_comillas_2($codigo_ta_b)."%' ";		
			
			$busca_todas_tarifas = query_db("select * from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes and t6_tarifas_estados_tarifas_id = 1 $bus_tarifa_c $comple");
			while($busca_tarifa_padre = traer_fila_row($busca_todas_tarifas)){//whie todas tarifas;
			$valor_nuevo_ipc=0;
			$valor_nuevo_ipc = ($busca_tarifa_padre[9]+($busca_tarifa_padre[9]*$valor_ipc)/100);

			 $insert = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia,tarifa_padre,fecha_fin_vigencia,t6_tarifas_listas_lista_id,tipo_creacion_modifica) ";
			 echo $insert.=  " values ($id_contrato_arr,'$busca_tarifa_padre[2]','$busca_tarifa_padre[3]','$busca_tarifa_padre[4]','$busca_tarifa_padre[5]', '$busca_tarifa_padre[6]','$busca_tarifa_padre[7]','$busca_tarifa_padre[8]','".$valor_nuevo_ipc."', '$id_us_session','$fecha $hora',$busca_tarifa_padre[12],$estado_tarifa,'".$_POST["vigencia_IPC"]."',$busca_tarifa_padre[15],'0000-00-00',$lista_existentes,4)";
			$sql_ex=query_db($insert.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){// si ingreso
				
								
								
									 $cambia_soporte = "insert into t6_tarifas_anexos_modifica_tarifas (t6_tarifas_lista_id,observaciones , anexo,descuento) values (
									$id_ingreso,'Incremento de: ".$valor_ipc." | ".$_POST["observaciones_IPC"]."', '".$_FILES["archivo_ipc"]["name"]."', '')";
									$sql_cambi_so=query_db($cambia_soporte.$trae_id_insrte);

									$id_ingreso_soporte = id_insert($sql_cambi_so);
									
									if($id_ingreso_soporte>=1){//si se creó el soporte
										
											if($_FILES["archivo_ipc"]["name"]!=""){//si tiene anexo
												carga_archivo($_FILES["archivo_ipc"]["tmp_name"],"tarifas_ane_modifica/".$id_ingreso_soporte);
												
												
												}//si tiene anexo
										
										}//si se creó el soporte
									
								
							
				
			} // si ingreso
				
				
			} //whie todas tarifas
			
			/****************************/
			//generacion de email para los parobadores
			/****************************/
			
			
			/****************************/
			//generacion de email para los parobadores
			/****************************/
			
			
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La tarifa se modificó,  para enviarla para aprobación por favor presione el botón de confirmación, que aparece al lado izquierdo una vez usted presione el botón aceptar', 20, 10, 18);
                    //alert("La tarifa se modificó,  para enviarla para aprobación por favor presione el botón de confirmación, que aparece al lado izquierdo una vez usted presione el botón aceptar")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualizar_ipc.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
			
			
				
			
			
		}

if($_POST["accion"]=="confirma_actualizacion_masiva")
		{
			
			
		if($estado_tarifa_padre == "aun inactiva rene activar por favor"){//si la tarifa padre tiene un estado diferente a aprobado no permita continuar con la actualizacion de tarifas	
			?>
        	<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'La modificación que intenta cargar no concuerda con las tarifas vigentes de su contrato, por favor descargue la plantilla de actualización de tarifas nuevamente del SGPA', 20, 10, 18);
			//alert("El anexo no puede pesar mas de 5 MB <?=number_format($valida_tamano,0);?>")
			</script>
        <?
		exit;
		}
		
			
if($_FILES["anexo_soporte_0"]["name"]!=""){//si tiene anexo

$tamano_anexo = $_FILES["anexo_soporte_0"]["size"];
$valida_tamano = ($tamano_anexo/1024)/1024;
if(number_format($valida_tamano,0)>=5)
	{
		?>
        	<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El anexo no puede pesar mas de 5 MB <?=number_format($valida_tamano,0);?>', 20, 10, 18);
			//alert("El anexo no puede pesar mas de 5 MB <?=number_format($valida_tamano,0);?>")
			</script>
        <?
		exit();
		}

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));

/* BUSCA GERENTE DE CONTRATO PARA QUE SEA ACTUALIZADO*/
	$buscar_datos_contrato = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id =". $id_contrato_arr));
	$id_contrato_modulo = $buscar_datos_contrato[0];
	$busca_gerente_contrato = traer_fila_row(query_db("select gerente from t7_contratos_contrato where id=".$id_contrato_modulo));
/* FIN BUSCA GERENTE DE CONTRATO PARA QUE SEA ACTUALIZADO*/
$busca_consecutivo = "select consecutivo_tarifa from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr order by consecutivo_tarifa desc  ";
$sql_busca_consecutivo = traer_fila_row(query_db($busca_consecutivo));
$serial_consecutivo =$sql_busca_consecutivo[0];

	 $busca_id_cargue = "select t6_tarifas_lista_id from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id = 10 and t6_tarifas_listas_lista_id = $id_lista ";
		$sql_exq = query_db($busca_id_cargue);
		$cuantas_tarifas = 0;
		while($lista_tar = traer_fila_row($sql_exq)){
			$cuantas_tarifas= $cuantas_tarifas+1;
			$serial_consecutivo++;
				carga_archivo($anexo_soporte_0,"tarifas_ane_modifica/".$lista_tar[0]);
				$cambia_estado = "update t6_tarifas_anexos_modifica_tarifas set anexo = '".$_FILES["anexo_soporte_0"]["name"]."' where  t6_tarifas_lista_id = $lista_tar[0]";
				$sql_ca = query_db($cambia_estado);

		
				$cambia_estado = "update t6_tarifas_lista set t6_tarifas_estados_tarifas_id = 3, consecutivo_tarifa = $serial_consecutivo where t6_tarifas_lista_id = $lista_tar[0] and t6_tarifas_estados_tarifas_id = 10";
				$sql_ca = query_db($cambia_estado);

/*ASEGURAR QUE TODAS LAS TARIFAS QUE SE CARGUEN QUEDEN AUNQUE SEA CON LA APROBACION INICAL DEL GERENTE*/
				$actualiza_gerente = "update t6_tarifas_lista set us_aprobacion_actual = $busca_gerente_contrato[0] where t6_tarifas_lista_id = $lista_tar[0] AND (us_aprobacion_actual IS NULL OR us_aprobacion_actual ='' OR us_aprobacion_actual = 0) and t6_tarifas_estados_tarifas_id = 3";
				echo $actualiza_gerente;
				$sql_actualiza_gerente = query_db($actualiza_gerente);
/* FIN ASEGURAR QUE TODAS LAS TARIFAS QUE SE CARGUEN QUEDEN AUNQUE SEA CON LA APROBACION INICAL DEL GERENTE*/

	}
	
				$id_log = log_de_procesos_sgpa(5, 62, 0, $buscar_datos_contrato[0], 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Anexo", $_FILES["anexo_soporte_0"]["name"] , "" ,1);
				log_agrega_detalle ($id_log, "Numero de tarifas que puso en firme" , $cuantas_tarifas, "" ,2);
			
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'Las tarifas se crearon/modificaron y se enviaron para aprobación de Hocol S.A.', 20, 10, 18);
                    //alert("Las tarifas se crearon/modificaron y se enviaron para aprobación de Hocol S.A.")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
}//archivo lleno

}//funcion



if($_POST["accion"]=="confirma_actualizacion_masiva_ipc")
		{
if($_FILES["anexo_soporte_0"]["name"]!=""){//si tiene anexo

$tamano_anexo = $_FILES["anexo_soporte_0"]["size"];
$valida_tamano = ($tamano_anexo/1024)/1024;
if(number_format($valida_tamano,0)>=5)
	{
		?>
        	<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El anexo no puede pesar mas de 5 MB <?=number_format($valida_tamano,0);?>', 20, 10, 18);
			//alert("El anexo no puede pesar mas de 5 MB <?=number_format($valida_tamano,0);?>")
			</script>
        <?
		exit();
		}

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));

/* BUSCA GERENTE DE CONTRATO PARA QUE SEA ACTUALIZADO*/
	$buscar_datos_contrato = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id =". $id_contrato_arr));
	$id_contrato_modulo = $buscar_datos_contrato[0];
	$busca_gerente_contrato = traer_fila_row(query_db("select gerente from t7_contratos_contrato where id=".$id_contrato_modulo));
/* FIN BUSCA GERENTE DE CONTRATO PARA QUE SEA ACTUALIZADO*/
$busca_consecutivo = "select consecutivo_tarifa from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr order by consecutivo_tarifa desc  ";
$sql_busca_consecutivo = traer_fila_row(query_db($busca_consecutivo));
$serial_consecutivo =$sql_busca_consecutivo[0];

	 $busca_id_cargue = "select t6_tarifas_lista_id from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id = 9 and t6_tarifas_listas_lista_id = $id_lista ";
		$sql_exq = query_db($busca_id_cargue);
		$cuantas_tarifas = 0;
		while($lista_tar = traer_fila_row($sql_exq)){
			$cuantas_tarifas= $cuantas_tarifas+1;
			$serial_consecutivo++;
				carga_archivo($anexo_soporte_0,"tarifas_ane_modifica/".$lista_tar[0]);
				$cambia_estado = "update t6_tarifas_anexos_modifica_tarifas set anexo = '".$_FILES["anexo_soporte_0"]["name"]."' where  t6_tarifas_lista_id = $lista_tar[0]";
				$sql_ca = query_db($cambia_estado);

		
				$cambia_estado = "update t6_tarifas_lista set t6_tarifas_estados_tarifas_id = 3, consecutivo_tarifa = $serial_consecutivo where t6_tarifas_lista_id = $lista_tar[0] and t6_tarifas_estados_tarifas_id = 9";
				$sql_ca = query_db($cambia_estado);

/*ASEGURAR QUE TODAS LAS TARIFAS QUE SE CARGUEN QUEDEN AUNQUE SEA CON LA APROBACION INICAL DEL GERENTE*/
				$actualiza_gerente = "update t6_tarifas_lista set us_aprobacion_actual = $busca_gerente_contrato[0] where t6_tarifas_lista_id = $lista_tar[0] AND (us_aprobacion_actual IS NULL OR us_aprobacion_actual ='' OR us_aprobacion_actual = 0) and t6_tarifas_estados_tarifas_id = 3";
				echo $actualiza_gerente;
				$sql_actualiza_gerente = query_db($actualiza_gerente);
/* FIN ASEGURAR QUE TODAS LAS TARIFAS QUE SE CARGUEN QUEDEN AUNQUE SEA CON LA APROBACION INICAL DEL GERENTE*/

	}
	
				$id_log = log_de_procesos_sgpa(5, 62, 0, $buscar_datos_contrato[0], 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Anexo", $_FILES["anexo_soporte_0"]["name"] , "" ,1);
				log_agrega_detalle ($id_log, "Numero de tarifas que puso en firme" , $cuantas_tarifas, "" ,2);
			
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'Las tarifas se modificaron,  Se envio para las aprobaciones de Hocol SA', 20, 10, 18);
                    //alert("Las tarifas se modificaron,  Se envio para las aprobaciones de Hocol SA")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
}//archivo lleno

}//funcion


/********************************************************************************************************************************
********************************************************************************************************************************
IPC
********************************************************************************************************************************
*********************************************************************************************************************************/		

?>

