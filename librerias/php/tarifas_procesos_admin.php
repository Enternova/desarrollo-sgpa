<?  include("../lib/@session.php");
include("tarifas_modelos_email.php");
header('Content-Type: text/html; charset=ISO-8859-1');
	verifica_menu("administracion.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php

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



if($_POST["accion"]=="carga_nuevo_manual"){
	$update = query_db("update t6_tarifas_manual_usuario_prov set estado = 2");
	$insert = "insert into t6_tarifas_manual_usuario_prov (fecha, hora, id_us_carga, estado) values ('".$fecha."', '".$hora."', '".$_SESSION["id_us_session"]."', 1)";
	$sql_ex=query_db($insert.$trae_id_insrte);
	$id_nuevo_manual = id_insert($sql_ex);
	
	$campo_file_nombre1 = $_FILES["manual_us"]["name"];
	$campo_file_temp1 = $_FILES["manual_us"]["tmp_name"];
	
	if($campo_file_nombre1 != ""){
		$nombre_file1 = "Manual de Usuario V".$id_nuevo_manual.".".extencion_archivos_sgpa($campo_file_nombre1);
		$copiar = carga_archivo($campo_file_temp1,'manual_tarifa/'.$id_nuevo_manual."_10");
		$upda = query_db("update t6_tarifas_manual_usuario_prov set adjunto = '".$nombre_file1."' where id = ".$id_nuevo_manual);

}

				?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El manual se actualizo con Exito', 20, 10, 18);
                    //alert("El manual se actualizo con Exito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/cargue_manualus_proveedor.php','contenidos');
                    </script>
			<?



	}
if($_POST["accion"]=="inhabuilita_tarifa"){
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato"]));
	$t6_tarifas_lista_id=$_POST["t6_tarifas_lista_id"];
	$ob_inhabilita=$_POST["ob_inhabilita"];
	
	$categoria_existentes = $_POST["categoria_existentes"];
	$grupo_existentes = $_POST["grupo_existentes"];
	$codigo_ta_b = $_POST["codigo_ta_b"];
	$detalle_ta_b = $_POST["detalle_ta_b"];
	$lista_existentes = $_POST["lista_existentes"];
	
	$inhablita_tarifa = "insert into t6_tarifas_inhabilitadas (ob_inhabilitada, fecha, us_id, estado) values ('".$ob_inhabilita."', '".$fecha."', ".$_SESSION["id_us_session"].", 1)";
	
	$sql_ex=mssql_query($inhablita_tarifa.$trae_id_insrte);			
			$id_ingreso = id_insert($sql_ex);
	
	
	$nombre_file1="";
	$campo_file_nombre1 = $_FILES["inhabilta_adjunto"]["name"];
	$campo_file_temp1 = $_FILES["inhabilta_adjunto"]["tmp_name"];	
	
	if($campo_file_nombre1 != ""){
		$nombre_file1 = $id_ingreso."_".$campo_file_nombre1;
		//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
		$copiar = carga_archivo($campo_file_temp1,'tarifas_inhabilitadas/'.$id_ingreso);
	}
	$update_tarifa = query_db("update t6_tarifas_inhabilitadas set adjunto_inhabilita = '".$campo_file_nombre1."' where id =".$id_ingreso);
	
$sel_contrato_modulo_contratos = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id = ".$id_contrato_arr));

				
$sel_tarifas = query_db("select t6_tarifas_lista_id from t6_tarifas_lista ids_tarifas where t6_tarifas_lista_id in (0".$_POST["ids_tarifas"].") ");
while($s_t = traer_fila_db($sel_tarifas)){


echo $_POST["inhabilita_tarifa_".$s_t[0]]."<br />";
if($_POST["inhabilita_tarifa_".$s_t[0]] == 2){	//si se selecciono que se debe inhabilitar	

$insrt_relacion = query_db("insert into t6_tarifas_inhabilitadas_relacion (id_tarifas_inhabilitar, t6_tarifas_lista_id) values ($id_ingreso, ".$s_t[0].")");
$update_tarifa = query_db("update t6_tarifas_lista set t6_tarifas_estados_tarifas_id = 11 where t6_tarifas_lista_id =".$s_t[0]);

				
				$id_log = log_de_procesos_sgpa(5, 63, 0, $sel_contrato_modulo_contratos[0], 0, 0);//actualiza general		
				$sel_tarifa_datos = traer_fila_row(query_db("select categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, fecha_inicio_vigencia, fecha_fin_vigencia, t6_tarifas_listas_lista_id from  t6_tarifas_lista where  t6_tarifas_lista_id = ".$s_t[0]));
	 		    log_agrega_detalle ($id_log, "Observacion de la inhabilitacion",$ob_inhabilita, "",1);
				log_agrega_detalle ($id_log, "Adjunto de inhabilitacion",$campo_file_nombre1, "",2);
				log_agrega_detalle ($id_log, "Tarifa que va a inhabilitar", $sel_tarifa_datos[3], "",3);
				log_agrega_detalle ($id_log, "lista", saca_nombre_lista("t6_tarifas_listas_lista",$sel_tarifa_datos[10],'nombre','t6_tarifas_listas_lista_id') , "",4);
				log_agrega_detalle ($id_log, "Categoria", $sel_tarifa_datos[0], "",5);
				log_agrega_detalle ($id_log, "Grupo", $sel_tarifa_datos[1], "",6);
				log_agrega_detalle ($id_log, "codigo del Proveedor", $sel_tarifa_datos[2], "",7);
				log_agrega_detalle ($id_log, "Unidad de medida", $sel_tarifa_datos[4], "",8);
				log_agrega_detalle ($id_log, "Cantidad", $sel_tarifa_datos[5], "",9);
				log_agrega_detalle ($id_log, "Tipo de moneda", saca_nombre_lista("t1_moneda",$sel_tarifa_datos[6],'nombre','t1_moneda_id'), "",10);//hay que poner valor
				log_agrega_detalle ($id_log, "Valor", $sel_tarifa_datos[7], "",11);
				log_agrega_detalle ($id_log, "Fecha de inicio de la vigencia", $sel_tarifa_datos[8], "",12);
				log_agrega_detalle ($id_log, "Fecha de finalizacion de la vigencia", $sel_tarifa_datos[9], "",13);
}
}
				?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La tarifa se inhabilito con Exito', 20, 10, 18);
                    //alert("La tarifa se inhabilito con Exito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/h_tarifas.php?id_contrato=<?=$id_contrato_arr;?>&categoria_existentes=<?=$categoria_existentes;?>&grupo_existentes=<?=$grupo_existentes;?>&codigo_ta_b=<?=$codigo_ta_b;?>&detalle_ta_b=<?=$detalle_ta_b;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?

	}


if($tipo_creaci==1)
	{
		$busca_contrato = traer_fila_row(query_db("select contratista, objeto from t7_contratos_contrato where id = $contrato_a"));
		
	echo $ingresa_tarifa = "insert into t6_tarifas_contratos (t1_moneda_id, t1_proveedor_id, consecutivo, valor, objeto_contarto, id_contrato) values (1, $busca_contrato[0], '$consecu', 0, '$busca_contrato[1]',$contrato_a )";
	
	$sql_ex=mssql_query($ingresa_tarifa.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			

	$ingresa_tarifa = "insert into t6_tarifas_complemento_contrato (tarifas_contrato_id, t6_tarifas_estados_contratos_id) values ($id_ingreso,1)";
	
	$sql_ex=mssql_query($ingresa_tarifa);

			
	
	}
	if($_POST["accion"]=="crea_tarifa_manual")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id

		    if($_POST["valor_creacion"]=="")
				$error="* Digite el nuevo valor";	
			if($_POST["moneda_creacion"]==0)
				$error="* Seleccione la moneda";	
			if($_POST["fecha_vigencia_creacion"]=="")			
				$error="* Seleccione el inicio de la vigencia ";	

			if( ($_POST["fecha_vigencia_creacion_final"]!="") && ($_POST["fecha_vigencia_creacion_final"]<$_POST["fecha_vigencia_creacion"])	)
				{
								$error="* La fecha fin de vigencia NO puede ser menor al la fecha de inicio  ";						
					}
			

			if($_POST["detalle_creacion"]=="")			
				$error="* Digite el detalle de la tarifa ";				
			
			$valida_formato_tarifa = valida_valor_tarifa($_POST["valor_creacion"]);
			$valida_valor = number_format($_POST["valor_creacion"],5);
			
			if($valida_formato_tarifa==2)
				$error="* El formato del valor es incorrecto";	
			if($valida_valor==0)
				$error="* El formato del valor es incorrecto";	

		
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


			/*verifica si el contrato ya esta en frme o no para porner tipo de creacion*/
			$busca_tarifas = "select t6_tarifas_estados_contratos_id from $t4 where tarifas_contrato_id = $id_contrato_arr";
			$sql_busca_tarifas=traer_fila_row(mssql_query($busca_tarifas));
			if($sql_busca_tarifas[0]==3){
				$tipo_creacion = 2;
				$estado_tarifa = 2;
				$stado_contrato_exp = 2;
				}
			elseif($sql_busca_tarifas[0]==6){
				$tipo_creacion = 2;
				$estado_tarifa = 2;
				$stado_contrato_exp = 6;
				}

			else{
				$tipo_creacion = 1;
				$estado_tarifa = 1;
				$stado_contrato_exp = 2;				
				}
			
	$busca_consecutivo = "select consecutivo_tarifa from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr order by consecutivo_tarifa desc  ";
$sql_busca_consecutivo = traer_fila_row(query_db($busca_consecutivo));
$serial_consecutivo =($sql_busca_consecutivo[0] + 1);		

			if( $_POST["fecha_vigencia_creacion_final"]!="") 
				$fecha_fibal_vigencia_t = $_POST["fecha_vigencia_creacion_final"];
			else
				$fecha_fibal_vigencia_t ="0000-00-00";
			

			$insert = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia,tarifa_padre,fecha_fin_vigencia, t6_tarifas_listas_lista_id,tipo_creacion_modifica,us_aprobacion_actual, creada_luego_firme, consecutivo_tarifa) ";
			 $insert.=  " values ($id_contrato_arr,'".elimina_comillas_2($categoria)."','".elimina_comillas_2($grupo)."','".elimina_comillas_2($codigo_creacion)."','".elimina_comillas_2($detalle_creacion)."', '$unidad_creacion','$cantidad_creacion','$moneda_creacion','$valor_creacion', '$id_us_session','$fecha $hora',$tipo_creacion,$estado_tarifa,'$fecha_vigencia_creacion',0 ,'$fecha_fibal_vigencia_t',$lista_existentes,1,0,1,$serial_consecutivo)";
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
			$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = $stado_contrato_exp where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_contratos_id <> 3");
			
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso se NO creó con éxito', 20, 10, 18);
                    //alert("ATENCION:\n *El proceso se NO creó con éxito")
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

	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

$busca_contrato = "select id,id_item,consecutivo,CAST(objeto as TEXT),nit,contratista,contacto_principal,email1,telefono1,gerente,fecha_inicio,vigencia_mes,aplica_acta_inicio,representante_legal,email2,telefono2,especialista,monto_usd,monto_cop,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,t1_tipo_documento_id,acta_socios,recibido_poliza,camara_comercio,ok_fecha,sel_representante,legalizacion_final_par,legalizacion_final_par_e,analista_deloitte,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,area_ejecucion,obs_congelado,aplica_portales,destino,aseguramiento_admin, aplica_garantia, porcentaje, en_que_momento, informe_hse, oferta_mercantil, garantia_seguro
 from $co1 where id = ".$sql_con[13];
	$sql_con2=traer_fila_row(query_db($busca_contrato));
	$sel_pro = "select * from $g6 where t1_proveedor_id=".$sql_con2[5];
	$sel_pro_q=traer_fila_row(query_db($sel_pro));
	$contratista=$sel_pro_q[3];

	$sel_usuario = "select * from $g1 where us_id = $sql_con2[9]";
    $sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
	$nombre_generete_sin_id = $sql_sel_usuario[1];
	$email_generete_sin_id = $sql_sel_usuario[4];	

$usuario_area ="";//esta es la variable para enviar el especialista profesional o comprador
	$sel_usuario = "select * from $g1 where us_id = $sql_con2[16]".$usuario_area;
    $sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
	$nombre_especialista = $sql_sel_usuario[1];
	$email_especialista = $sql_sel_usuario[4];
	$sel_rol_pro_compra = traer_fila_row(query_db("select t1.id, t2.nombre from tseg12_relacion_usuario_rol as t1,  tseg11_roles_general as t2 where t1.id_rol_general = t2.id_rol and id_rol in (17, 13) and t1.id_usuario = ".$sql_con2[16]));
//	$administrador_tarifas = traer_fila_row(query_db("select t1.nombre_administrador, t1.email from $g1 as t1, $ts6 as t2 where t1.us_id=t2.id_usuario and t2.id_rol_general = 1 and t1.estado=1 and t1.us_id <> 32"));
	$administrador_tarifas = traer_fila_row(query_db("select t1.nombre_administrador, t1.email from $g1 as t1  where t1.us_id=17968"));
	if($sel_rol_pro_compra[0]>1){
		$usuario_area = $sel_rol_pro_compra[1];
		}



$copias="";
$copias=$copias.$email_especialista.",".$administrador_tarifas[1];	
$arregla_mensaje = arregla_texto_email_para_enviar_gerente($proveedor_pasa,$contrato_numero,$nombre_especialista,$usuario_area,$nombre_generete_sin_id, $administrador_tarifas[0],$sql_con2[3],$contratista);
$envia_email = envia_notifica_gerente_con_copia($email_generete_sin_id, numero_cotnrato_tarifas_arreglo_fina($id_contrato_arr)." CONFIRMACION TARIFAS EN FIRME ",$arregla_mensaje, $copias);
$envia_email=preg_replace("(\r\n)", "", $envia_email);
/*$envia_email = envia_notifica_gerente($email_especialista, numero_cotnrato_tarifas_arreglo_fina($id_contrato_arr)." Confirmacion tarifas en firme",$arregla_mensaje );
$envia_email = envia_notifica_gerente("diana.davila@hocol.com.co", numero_cotnrato_tarifas_arreglo_fina($id_contrato_arr)." Confirmacion tarifas en firme",$arregla_mensaje );*/
			
			
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    //window.parent.document.getElementById("contenidos").innerHTML = '<?=$envia_email;?>';
					window.parent.taer_menu('../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=<?=$id_contrato?>','contenido_menu');
                    //window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','contenidos');
                    </script>
			<?
			}
			else
			{
			?>
					<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Para poner el contato en firme debe ingresar por lo menos una tarifa', 20, 10, 18);
                    //alert("ATENCION:\n *Para poner el contato en firme debe ingresar por lo menos una tarifa")
                    </script>
			<?
			}
			
		}


if($_POST["accion"]=="contrato_en_excepcion_editado"){
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato"]));
			
			$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = 6, ob_estado = '".$_POST["ob_excepcion"]."' where tarifas_contrato_id = $id_contrato_arr ");
			$id_log = log_de_procesos_sgpa(5, 48, 87, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Estado anterior", "Parcial", "",1);
			log_agrega_detalle ($id_log, "Nuevo Estado","Contrato Excepcion", "",1);
			log_agrega_detalle ($id_log, "Observacion",$_POST["ob_excepcion"], "",1);
			
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
					window.parent.taer_menu('../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=<?=$id_contrato?>','contenido_menu');
                    //window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','contenidos');
                    </script>
			<?
		}	

if($_POST["accion"]=="contrato_tarifas_en_excepcion_editado_comentario"){
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato"]));
			
			$updat = mssql_query("update $t4 set  ob_estado = '".$_POST["ob_excepcion_edita"]."' where tarifas_contrato_id = $id_contrato_arr ");
			$id_log = log_de_procesos_sgpa(5, 48, 87, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Modifica Observacion de Excepcion", $_POST["ob_excepcion_edita"], "",1);
			log_agrega_detalle ($id_log, "Estado","Excepcion", "",1);
	
			
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
					window.parent.taer_menu('../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=<?=$id_contrato?>','contenido_menu');
                    //window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','contenidos');
                    </script>
			<?
		}	

if($_POST["accion"]=="contrato_en_excepcion_editado_cambia_esatdo"){
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato"]));
			
	
	$sel_si_tiene_tarifas = traer_fila_row(query_db("select count(*) from t6_tarifas_lista where tarifas_contrato_id =". $id_contrato_arr." and t6_tarifas_estados_tarifas_id = 1"));
	$nuevo_estado = "";
	$estado_queda_contrato = 6;
	
	if($sel_si_tiene_tarifas[0] > 0){//con tarifas
		$nuevo_estado = "En Firme";
		$estado_queda_contrato = 3;
	}else{
		$nuevo_estado = "Sin Tarifas";
		$estado_queda_contrato = 1;
		
	}
	
	
			$updat = mssql_query("update $t4 set  t6_tarifas_estados_contratos_id = ".$estado_queda_contrato.",   ob_estado = '".$_POST["ob_excepcion_edita"]."' where tarifas_contrato_id = $id_contrato_arr ");
			$id_log = log_de_procesos_sgpa(5, 48, 87, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Estado anterior", "Con Excepcion", "",1);
			log_agrega_detalle ($id_log, "Nuevo Estado",$nuevo_estado, "",1);
			log_agrega_detalle ($id_log, "Observacion",$_POST["ob_excepcion_edita"], "",1);
			
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
					window.parent.taer_menu('../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=<?=$id_contrato?>','contenido_menu');
                    //window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','contenidos');
                    </script>
			<?
		}
if($_POST["accion"]=="contrato_en_parcial_editado"){
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($_POST["id_contrato"]));
			echo "update $t4 set t6_tarifas_estados_contratos_id = 2 where tarifas_contrato_id = $id_contrato_arr ";
			$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = 2 where tarifas_contrato_id = $id_contrato_arr ");
			$id_log = log_de_procesos_sgpa(5, 48, 74, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Estado anterior", "Parcial", "",1);
			log_agrega_detalle ($id_log, "Nuevo Estado","Con Excepcion", "",1);
			log_agrega_detalle ($id_log, "Observacion",$_POST["ob_excepcion_edita"], "",1);
			
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
					window.parent.taer_menu('../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=<?=$id_contrato?>','contenido_menu');
                    //window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','contenidos');
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
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se modificó con exito y se notifico a los responsables de aprobacion', 20, 10, 18);
                    //alert("El proceso se modificó con exito y se notifico a los responsables de aprobacion")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato=<?=$id_contrato;?>&categoria=<?=$categoria;?>&grupo=<?=$grupo;?>&fecha_vigencia=<?=$fecha_vigencia;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso se NO creó con éxito', 20, 10, 18);
                    //alert("ATENCION:\n *El proceso se NO creó con éxito")
                    </script>
			<?
			}
			
				}//si el contrato ya esta en firma
			
			
			
		}
		
		

	if($_POST["accion"]=="modificar_tarifas_parcial")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			
			if($_POST["codigo_m_".$id_tarifa_arr]=="")
				{
					?>
                    	<script>
							window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Digite el <?=TITULO_alertas;?>', 20, 10, 18);
							//alert("Digite el <?=TITULO_alertas;?>")
						</script>
                    
                    <?
					exit();
					}
			
			$busca_tarifa_anterior = traer_fila_row(query_db("select detalle, t1_moneda_id, valor from $t3 where t6_tarifas_lista_id = $id_tarifa_arr "));
				
				echo $solo_mofifica = "update $t3 set codigo_proveedor='".$_POST["codigo_m_".$id_tarifa_arr]."', detalle='".elimina_comillas_2($_POST["detalle_m_".$id_tarifa_arr])."', unidad_medida = '".$_POST["unidad_tarifa_".$id_tarifa_arr]."', cantidad='".$_POST["cantidad_tarifa_".$id_tarifa_arr]."', t1_moneda_id = '".$_POST["moneda_tarifa_".$id_tarifa_arr]."', valor='".$_POST["valor_tarifa_".$id_tarifa_arr]."', fecha_inicio_vigencia= '".$_POST["vigencia_tarifa_".$id_tarifa_arr]."', fecha_fin_vigencia ='".$_POST["vigencia_tarifa_final_".$id_tarifa_arr]."' where t6_tarifas_lista_id = $id_tarifa_arr";
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modificó con éxito', 20, 10, 18);
                    //alert("El registro se modificó con éxito")
					window.parent.ajax_carga('../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato=<?=$id_contrato_arr;?>&lista_existentes=<?=$id_lista;?>&categoria_existentes=<?=$categoria_existentes;?>&grupo_existentes=<?=$grupo_existentes;?>&codigo_ta_b=<?=$codigo_ta_b;?>&detalle_ta_b=<?=$detalle_ta_b;?>&pagina=<?=$pagina;?>','carga_acciones_permitidas')
                    </script>
			<?

			
			
		}		
		

		if($_POST["accion"]=="eliminar_tarifas_parcial")
		{
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$id_tarifa_arr = elimina_comillas(arreglo_recibe_variables($id_tarifa));//recibe id
			
			$busca_tarifa_anterior = traer_fila_row(query_db("select detalle, t1_moneda_id, valor from $t3 where t6_tarifas_lista_id = $id_tarifa_arr "));
				
			echo $solo_mofifica = "update $t3 set t6_tarifas_estados_tarifas_id = 8 where t6_tarifas_lista_id = $id_tarifa_arr";
			$sql_que = mssql_query($solo_mofifica);	
				
			$id_log = log_de_procesos_sgpa(5, 47, 73, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Valor anterior", listas_sin_select($g5,$busca_tarifa_anterior[1],1)." ".number_format($busca_tarifa_anterior[2],2), "",1);
 		    log_agrega_detalle ($id_log, "Valor nuevo", listas_sin_select($g5,$_POST["moneda_tarifa_".$id_tarifa_arr],1)." ".number_format($_POST["valor_tarifa_".$id_tarifa_arr],2), "",1);
 		    log_agrega_detalle ($id_log, "Detalle anterior", $busca_tarifa_anterior[0], "",1);
 		    log_agrega_detalle ($id_log, "Detalle nuevo", $_POST["detalle_m_".$id_tarifa_arr], "",1);


					?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La tarifa se ha eliminado con éxito', 20, 10, 18);
                    //alert("La tarifa se ha eliminado con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias.php?id_categoria=<?=$id_ingreso;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó', 20, 10, 18)
                    //alert("ATENCION:\n *El proceso NO se creó")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias.php?id_categoria=<?=$id_categoria;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó', 20, 10, 18)
                    //alert("ATENCION:\n *El proceso NO se creó")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se eliminó con éxito', 20, 10, 18);
                    //alert("El registro se eliminó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se eliminó con éxito', 20, 10, 18);
                    //alert("El registro se eliminó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c2_listas_maestras.php?id_categoria=<?=$categoria_busca[1];?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó', 20, 10, 18)
                    //alert("ATENCION:\n *El proceso NO se creó")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modificó con éxito', 20, 10, 18);
                    //alert("El registro se modificó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se eliminó con éxito', 20, 10, 18);
                    //alert("El registro se eliminó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$lista_existentes;?>','carga_acciones_permitidas');
                    </script>
			<?
			}
			else
			{
			?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó', 20, 10, 18)
                    //alert("ATENCION:\n *El proceso NO se creó")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se eliminó con éxito', 20, 10, 18);
                    //alert("El registro se eliminó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se eliminó con éxito', 20, 10, 18);
                    //alert("El registro se eliminó con éxito")
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
					window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La lista se creo con éxito', 20, 10, 18)
                    //alert("La lista se creo con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modificó con éxito', 20, 10, 18);
                    //alert("El registro se modificó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$id_ingreso;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La lista NO se creo con éxito', 20, 10, 18)
                    //alert("La lista NO se creo con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_descuentos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El registro NO se creo con éxito', 20, 10, 18)
                    //alert("El registro NO se creo con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_documentos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El registro NO se creo con éxito', 20, 10, 18)
                    //alert("El registro NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}	
		
		
		

if($_POST["accion"]=="crea_suplentes_tarifas"){
		$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		
		$cambia_suple = mssql_query("update t6_tarifas_suplentes_aprobadores set  estado = 2 where tarifas_contrato_id = $id_contrato_arr and tipo_suplencia = $roll_suplente");
		
		// Verifica que el suplente no este repetido.
		$selSupleRepetidos = traer_fila_row(query_db("select count(*) from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = $usuario_suplente and estado = 1"));
		
		if($selSupleRepetidos[0] >= 1){// Si esta repetido no guardara.
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* No se puede agregar suplentes repetidos', 20, 10, 18)
		//alert("No se puede agregar suplentes repetidos.")
		</script>
		<?
		die;
		}
		
		$copia_lista = "insert into t6_tarifas_suplentes_aprobadores(t7_contratos_contactos_id,tarifas_contrato_id,us_id,fecha_suplencia,permanente,tipo_suplencia,estado)
		 values (0, $id_contrato_arr,$usuario_suplente, '".$fecha_inicial."',1,$roll_suplente,1)";
		$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
		$id_ingreso = id_insert($sql_ex);
		
		//Segun el rol del suplente que se va a eliminar, se busca la persona encargada desde el comienzo.
		$sel_tarifa_contrato = traer_fila_db(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr"));
		$busca_contrato = "select gerente,especialista,id_item from $co1 where id = $sel_tarifa_contrato[0]";
		
		$sql_con= traer_fila_db(query_db($busca_contrato));
	
		if($roll_suplente==1){
			$usEncargado = $sql_con['gerente'];
			$usEncargadoNombre = "Gerente de contrato";}
		else if($roll_suplente==2){
			$usEncargado = $sql_con['especialista'];
			$usEncargadoNombre = "Profesional de C&C";}
		else if($roll_suplente==3){
				$id_jefe_area = busca_jefe_area_contrato($id_contrato_arr);
		
				$usEncargado = $id_jefe_area;
				$usEncargadoNombre = "Jefe de area";
		}
		
		
	
		// Se actualiza la tabla tarifas lista, para que el nuevo usuario pueda firmar. En caso que no este en la tabla, no modificara la informacion. Esto quiere decir que el ususario que actualmente va a firmar es de otro rol
		$updaTarifasLista = query_db("update t6_tarifas_lista set us_aprobacion_actual = $usuario_suplente where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id = 3 and us_aprobacion_actual = $usEncargado");
		
		// Se actualiza la alerta, para aparezca en su buzon de entrada
		//$updaAlert = query_db("update t6_tarifas_responsables_aprobadores set us_id = $usuario_suplente where tarifas_contrato_id = $id_contrato_arr and us_id = $usEncargado and estado = 1");
		
		
		
	// Se desactiva la alerta del usuario anterior }
	
	$updaAlert = query_db("update t6_tarifas_responsables_aprobadores set estado = 2 where tarifas_contrato_id = $id_contrato_arr and us_id = $usEncargado and estado = 1");
	// Se consulta si el usuario suplente es aprobador actual
	$countAprob = traer_fila_row(query_db("select count(*) from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id = 3 and us_aprobacion_actual = $usuario_suplente"));
	if($countAprob[0] >= 1){// Pregunta si es aprobador actual
	// Se agrega la alerta, para aparezca en su buzon de entrada
	//$updaAlert = query_db("update t6_tarifas_responsables_aprobadores set us_id = $usEncargado where tarifas_contrato_id = $id_contrato_arr and us_id = $sel_usuAnterior[0] and estado = 1");
		$insertAlert = query_db("insert into t6_tarifas_responsables_aprobadores (tarifas_contrato_id,us_id,roll,estado,fecha) values ($id_contrato_arr,$usuario_suplente,'$usEncargadoNombre',1,'$fecha $hora')");
	}
		
		
		
			
		if($id_ingreso>=1){?>
			<script> 
            window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
            window.parent.ajax_carga('../aplicaciones/tarifas/c_suplentes.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
            </script>
		<?
		}
		else {?>
			<script> 
            window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El registro NO se creo con éxito', 20, 10, 18)
                    //alert("El registro NO se creo con éxito")
            </script>
		<?	
	}		
			
}	
		

if($_POST["accion"]=="elimina_suplentes_tarifas"){
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
	$sel_tarifa_contrato = traer_fila_db(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr"));
	$busca_contrato = "select gerente,especialista,id_item from $co1 where id = $sel_tarifa_contrato[0]";
	$sql_con= traer_fila_db(query_db($busca_contrato));
		
	// Primero se busca quien es el usuario que esta actualmente de suplente
	$sel_usuAnterior = traer_fila_db(query_db("select us_id,tipo_suplencia from t6_tarifas_suplentes_aprobadores where t6_tarifas_suplentes_aprobadores_id = $id_suplente"));
	
	// Cambia el estado del suplente
	$cambia_suple = mssql_query("update t6_tarifas_suplentes_aprobadores set  estado = 2 where t6_tarifas_suplentes_aprobadores_id = $id_suplente");
	
	//Segun el rol del suplente que se va a eliminar, se busca la persona encargada desde el comienzo.
	if($sel_usuAnterior[1]==1){
		$usEncargado = $sql_con['gerente'];
		$usEncargadoNombre = "Gerente de contrato";}
	else if($sel_usuAnterior[1]==2){
		$usEncargado = $sql_con['especialista'];
		$usEncargadoNombre = "Profesional de C&C";}
	else if($sel_usuAnterior[1]==3){
			$id_jefe_area = busca_jefe_area_contrato($id_contrato_arr);
	
			$usEncargado = $id_jefe_area;
			$usEncargadoNombre = "Jefe de area";
	}
	
	// Se actualiza la tabla tarifas lista, para que el usuario asignado en el contrato pueda firmar.
	$updaTarifasLista = query_db("update t6_tarifas_lista set us_aprobacion_actual = $usEncargado where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id = 3 and us_aprobacion_actual = $sel_usuAnterior[0]");
	// Se desactiva la alerta del usuario anterior 
	$updaAlert = query_db("update t6_tarifas_responsables_aprobadores set estado = 2 where tarifas_contrato_id = $id_contrato_arr and us_id = $sel_usuAnterior[0] and estado = 1");
	// Se consulta si el usuario por defecto del contrato es aprobador actual
	$countAprob = traer_fila_row(query_db("select count(*) from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id = 3 and us_aprobacion_actual = $usEncargado"));
	if($countAprob[0] >= 1){// Pregunta si es aprobador actual
	// Se agrega la alerta, para aparezca en su buzon de entrada
	//$updaAlert = query_db("update t6_tarifas_responsables_aprobadores set us_id = $usEncargado where tarifas_contrato_id = $id_contrato_arr and us_id = $sel_usuAnterior[0] and estado = 1");
		$insertAlert = query_db("insert into t6_tarifas_responsables_aprobadores (tarifas_contrato_id,us_id,roll,estado,fecha) values ($id_contrato_arr,$usEncargado,'$usEncargadoNombre',1,'$fecha $hora')");
	}
			
	?>
	<script> 
    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se eliminó con éxito', 20, 10, 18);
                    //alert("El registro se eliminó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_reembolsables.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El registro NO se creo con éxito', 20, 10, 18)
                    //alert("El registro NO se creo con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modificó con éxito', 20, 10, 18);
                    //alert("El registro se modificó con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modificó con éxito', 20, 10, 18);
                    //alert("El registro se modificó con éxito")
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
			$cuenta_tarifas = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr"));				
			if($cuenta_tarifas[0]==0){
				$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = 1 where tarifas_contrato_id = $id_contrato_arr ");
				}
				
			$id_log = log_de_procesos_sgpa(5, 53, 80, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Elimina tarifas", "Todas las tarifas de la lista", "",1);
 		    log_agrega_detalle ($id_log, "Nombre de la lista", $busca_nombre_lista[2], "",1);

		?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modificó con éxito', 20, 10, 18);
                    //alert("El registro se modificó con éxito")
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

			$cuenta_tarifas = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr"));				
			if($cuenta_tarifas[0]==0){
				$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = 1 where tarifas_contrato_id = $id_contrato_arr ");
				}				
	
			$id_log = log_de_procesos_sgpa(5, 53, 79, $id_contrato_arr, 0, 0);//actualiza general
 		    log_agrega_detalle ($id_log, "Elimina lista", "Todas las tarifas de la lista", "",1);
 		    log_agrega_detalle ($id_log, "Nombre de la lista", $busca_nombre_lista[2], "",1);


		?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se modificó con éxito', 20, 10, 18);
                    //alert("El registro se modificó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$id_ingreso;?>','carga_acciones_permitidas');
					
                    </script>
			<?
	
			
		}	
		
		
		
if($_POST["accion"]=="crear_proyecto_tarifas")
		{
			
				$id_municipios_arr = elimina_comillas(arreglo_recibe_variables($id_municipios));	
				
				$busca_municipio = traer_fila_row(query_db("select * from t6_tarifas_municipios where t6_tarifas_municipios_id = $id_municipios_arr "));
	
				echo $update_ree = "insert into t6_tarifas_municipios_proyectos (t6_tarifas_municipios_id, proyecto, arreglo, estado) 
				values ($id_municipios_arr,'$proyecto_crea','N/A', 1) ";
				$sql_grupo=mssql_query($update_ree);
				
		
				$id_log = log_de_procesos_sgpa(5, 54, 81, 0, 0, 0);//actualiza general
	 		    log_agrega_detalle ($id_log, "Creación proyecto", $proyecto_crea, "",1);
 			    log_agrega_detalle ($id_log, "Municipio", $busca_municipio[2], "",1);



		?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
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
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/admin/modulo-historico-municipios.php','contenidos');
					
                    </script>
			<?
	
			
		}			



if($_POST["accion"]=="crea_ipc_contrato")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
	$update_ree = traer_fila_row(query_db("select t6_tarifas_contratos_id from  t6_tarifas_convencion_contrato  where t6_tarifas_contratos_id = $id_contrato_arr and convencion_administracion = 1 and estado = 1"));
	if(($update_ree[0]>=1) && ($reembolsable_por==1) )
		{ ?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El contrato tiene habilitada la opción de modificación de tarifas por convención *Desactivela y vuelva a intertarlo', 20, 10, 18)
			window.parent.document.getElementById("cargando").style.display="none"
			//alert("ATENCION:\nEl contrato tiene habilitada la opcion de modificacion de tarifas por convencion\nDesactivela y vuelva a intertarlo.")
			
			</script>
			<?
			exit();
			}
		
	
				$update_ree = mssql_query("update t6_tarifas_ipc_contrato set estado = 2 where t6_tarifas_contratos_id = $id_contrato_arr");
				
				echo $copia_lista = "insert into t6_tarifas_ipc_contrato (t6_tarifas_contratos_id,ipc_administracion,us_creacion,fecha_creacion,estado) values 
				($id_contrato_arr, $reembolsable_por, ".$_SESSION["id_us_session"].",'$fecha $hora', 1)";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
				
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_ipc.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El registro NO se creo con éxito', 20, 10, 18)
                    //alert("El registro NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}	

if($_POST["accion"]=="crea_aiu_contrato")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
				$update_ree = mssql_query("update t6_tarifas_aiu_contrato set estado = 2 where t6_tarifas_contratos_id = $id_contrato_arr");
				
				echo $copia_lista = "insert into t6_tarifas_aiu_contrato (t6_tarifas_contratos_id,aiu_administracion,us_creacion,fecha_creacion,estado) values 
				($id_contrato_arr, $reembolsable_por, ".$_SESSION["id_us_session"].",'$fecha $hora', 1)";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
				
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_aiu.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El registro NO se creo con éxito', 20, 10, 18)
                    //alert("El registro NO se creo con éxito")
                    </script>
			<?
		
			
		}		
			
		}	

if($_POST["accion"]=="crea_convencion_contrato")
		{
			 $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
	
	$update_ree = traer_fila_row(query_db("select t6_tarifas_contratos_id from  t6_tarifas_ipc_contrato  where t6_tarifas_contratos_id = $id_contrato_arr and ipc_administracion = 1 and estado = 1"));
	if(($update_ree[0]>=1) && ($reembolsable_por==1) )
		{ ?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El contrato tiene habilitada la opcion de modificacion de tarifas por IPC *Desactivela y vuelva a intertarlo', 20, 10, 18)
			window.parent.document.getElementById("cargando").style.display="none"
			//alert("ATENCION:\nEl contrato tiene habilitada la opcion de modificacion de tarifas por IPC\nDesactivela y vuelva a intertarlo.")
			
			</script>
			<?
			exit();
			}
	
				$update_ree = mssql_query("update t6_tarifas_convencion_contrato set estado = 2 where t6_tarifas_contratos_id = $id_contrato_arr");
				
				echo $copia_lista = "insert into t6_tarifas_convencion_contrato (t6_tarifas_contratos_id,convencion_administracion,us_creacion,fecha_creacion,estado) values 
				($id_contrato_arr, $reembolsable_por, ".$_SESSION["id_us_session"].",'$fecha $hora', 1)";
				$sql_ex=mssql_query($copia_lista.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);
				
				if($id_ingreso>=1){
			
				
			?>
					<script> 
                    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
                    //alert("El registro se creo con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_convencion.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
                    </script>
			<?
		
		}
		else {
		?>
					<script> 
                    window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El registro NO se creo con éxito', 20, 10, 18)
                    //alert("El registro NO se creo con éxito")
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
				$id_jefe_area = busca_jefe_area_contrato($id_contrato_arr);

					if(isset($id_jefe_area)) $query_jefe_area = ", ".$id_jefe_area;
					
			$busca_datos_del_contrato = "select id_item, gerente, especialista $query_jefe_area from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr";
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

				if($_SESSION["id_us_session"]==$sql_busca_datos_contrato_abrobadores[$aprobaciones_actuales]){
					//SI EL siguiente ES IGUAL AL QUE ESTA APROBADO
					$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones)";
					$inserta_aprobacion.= " values ($id_tarifa,1,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."')"; 
					$sql_inser=mssql_query($inserta_aprobacion);
					
					// Busca si tiene suplente
					$busca_suplentes_etapa_text2 = "select us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr  and fecha_suplencia >= '$fecha' and tipo_suplencia = ($aprobaciones_actuales+1) and  estado = 1  ";
					$busca_suplentes_etapa2 = traer_fila_row(mssql_query($busca_suplentes_etapa_text2));
					if($busca_suplentes_etapa2[0]>=1){//si tiene suplencia
						$siguiente_usuario_aprobador =	$busca_suplentes_etapa2[0];
						$roll_aprobador=$aprobaciones_actuales+1;
					}else{// No tiene suplencia
						$siguiente_usuario_aprobador =	$sql_busca_datos_contrato_abrobadores[($aprobaciones_actuales+1)];
						echo "aqui 2 -- ".$siguiente_usuario_aprobador;
						$roll_aprobador=($aprobaciones_actuales+1);
					}
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
			
if($aprobador_correcto == "NO" and $noplica = "hablar con rene, por que esta validacion se debe incluir nuevamente"){// validacion para que por tarifa se identifique si es o no el probador que corresponde
?><script>
window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Su aprobador no es correcto para algunas de las tarifas que intenta aprobar', 20, 10, 18)
</script><?			
exit;
}
			$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
			$genera_email=0;
			$tarifas_devuieltas="";
			$busca_datos_del_contrato = traer_fila_row(mssql_query("select * from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr"));
			
			/*COMPRUEBA SI ES MARCO O NORMAL*/
				if($busca_datos_del_contrato[19]==1) $numero_aprobaciones_req=3;
				elseif($busca_datos_del_contrato[19]==2) $numero_aprobaciones_req=4;				
			/*COMPRUEBA SI ES MARCO O NORMAL*/	
			$id_us_email_notificaciones_aproba=0;
			$id_us_email_notificaciones_rechaza=0;				
			$id_us_email_notificaciones_aproba = 0;
			$id_us_email_notificaciones_rechaza = 0;	
			$tarifas_devuieltas = "";
			$tarifas_aprobaidas = "";	

		foreach($aprobacion as $id_tarifa => $valor_aprobacion)
				{//inicio for errores anexos
				
					if($valor_aprobacion>=1){//si selecciona un estado
										
						$campo_file_individual = $_FILES["carga_anexo_individula_".$id_tarifa]["name"];
						$tamano_file_individual = $_FILES["carga_anexo_individula_".$id_tarifa]["size"];

						$extencion_anexo = strtolower(extencion_archivos_tarifas($campo_file_individual));
						$tamano_file_temp1_rechazo = ($tamano_file_individual/1024)/1024;
						
					
						if($campo_file_individual !="") 
							{// si trae anexo
							
								if( ($extencion_anexo!= "rar") && ($extencion_anexo!= "zip") )
									{
									?>
											<script>
											window.parent.document.getElementById("cargando_pecc").style.display = "none"
											window.parent.document.getElementById("botones_acciones").style.display=""
											window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El anexo debe ser .zip o .rar |<?=$extencion_anexo;?>|', 20, 10, 18)
											//alert("El anexo debe ser .zip o .rar |<?=$extencion_anexo;?>|")
											
											</script>
										<?
										
										exit();
										}			
									if($tamano_file_temp1_rechazo>=6)
										{
										?>
												<script>
												window.parent.document.getElementById("cargando_pecc").style.display = "none"
												window.parent.document.getElementById("botones_acciones").style.display=""
												window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El anexo no puede ser mayor a 5MB', 20, 10, 18)
												//alert("El anexo no puede ser mayor a 5MG")
			
												</script>
											<?
											
											exit();
											}							
								


							}// si trae anexo



					}
				
				
				}//inicio for errores anexos

						$campo_file_individual = "";
						$tamano_file_individual = "";

						$extencion_anexo = "";
						$tamano_file_temp1_rechazo = 0;



		foreach($aprobacion as $id_tarifa => $valor_aprobacion)
				{//inicio for
				
				
			$verifica_cuantas_firmas_por_usuario="select count(*) from $t7 where t6_tarifas_lista_id = $id_tarifa and us_id = ".$_SESSION["id_us_session"];
			$sql_verifica_cuantas_firmas_por_usuario=traer_fila_row(mssql_query($verifica_cuantas_firmas_por_usuario));		
			
			if (($numero_aprobaciones_req==3) && ($sql_verifica_cuantas_firmas_por_usuario[0]>=2)){
			?>
				<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La aprobación No se pudo realizar', 20, 10, 18)
					//alert("Atención: La aprobación No se pudo realizar")
				</script>
			<?
			exit();
			}
			
			if (($numero_aprobaciones_req==4) && ($sql_verifica_cuantas_firmas_por_usuario[0]>=3)){
			?>
				<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La aprobación No se pudo realizar', 20, 10, 18)
					//alert("Atención: La aprobación No se pudo realizar")
				</script>
			<?
			exit();
			}
				
					if($valor_aprobacion>=1){//si selecciona un estado
					
					
				
						if( ($valor_aprobacion==5) || ($valor_aprobacion==6) ){ // si el steado es devuelto
						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones, id_us_original)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."', '".$_POST["id_us_aprobador_actual"]."')"; 
						$sql_inser=mssql_query($inserta_aprobacion);						
								$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = $valor_aprobacion,us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa";
								$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);		
								
								$tarifas_devuieltas.=",".$id_tarifa;					
						}// si el steado es devuelto
						elseif( $valor_aprobacion==4) { // si el estado es rechazada
							
						$campo_file_individual = $_FILES["carga_anexo_individula_".$id_tarifa]["name"];
						$tamano_file_individual = $_FILES["carga_anexo_individula_".$id_tarifa]["size"];

						$extencion_anexo = strtolower(extencion_archivos_tarifas($campo_file_individual));
						$tamano_file_temp1_rechazo = ($tamano_file_individual/1024)/1024;
						
					
							
							if($_POST["observaciones_".$id_tarifa] == ""){
								
								?><script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Por favor ingresar una observacion en todas las tarifas que desea rechazar', 20, 10, 18)
				//alert("Por favor ingresar una observacion en todas las tarifas que desea rechazar")
								window.parent.document.getElementById("botones_acciones").style.display=""
								</script><? exit;	
							}
							
							
							
							else{
						$id_ingreso_tarifa_base ="";
						


						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones, id_us_original)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."', '".$_POST["id_us_aprobador_actual"]."')"; 
						$sql_inser=mssql_query($inserta_aprobacion.$trae_id_insrte);						
						
						$id_ingreso_tarifa_base = id_insert($sql_inser);
						$campo_file_nombre1_rechazo = "";
						$campo_file_temp1_rechazo = "";

						$campo_file_nombre1_rechazo = $_FILES["carga_anexo_individula_".$id_tarifa]["name"];
						$campo_file_temp1_rechazo = $_FILES["carga_anexo_individula_".$id_tarifa]["tmp_name"];
						echo $campo_file_nombre1_rechazo."rene 1";
					
						$id_ingreso_tarifa_base_anexo="";
						if( ($id_ingreso_tarifa_base>=1) && ($campo_file_nombre1_rechazo !="") )
							{// si trae anexo
								echo $inserta_anexo_primero = "insert into t6_tarifas_aprobaciones_anexos (t6_tarifas_aprobaciones_id, us_id, fecha_cargue, nombre_archivo)
								 values ('".$id_contrato_arr."', ".$_SESSION["id_us_session"].", '$fecha $hora','".elimina_comillas_2($campo_file_nombre1_rechazo)."' )";
								 $inserta_anexo = mssql_query($inserta_anexo_primero.$trae_id_insrte);
								 $id_ingreso_tarifa_base_anexo = id_insert($inserta_anexo);
								 
								 $inserta_relacion_tarifas = "insert into t6_tarifas_aprobaciones_anexos_tarifa (t6_tarifas_aprobaciones_anexos_id, t6_tarifas_lista_id) values
								  (".$id_ingreso_tarifa_base_anexo.",".$id_tarifa.")";

  								 $inserta_anexo_relacion = query_db($inserta_relacion_tarifas);
								
								  $copiar = carga_archivo($campo_file_temp1_rechazo,'tarifas_aprobaciones/'.$id_ingreso_tarifa_base_anexo );
								
								}// si trae anexo

								$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = $valor_aprobacion, us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa";
								$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);	
								$tarifas_devuieltas.=",".$id_tarifa;						
							}
							
						}// si el steado es rechazada

						elseif( $valor_aprobacion==1) { // si el steado es aprobado para enviar email a la siguiente
						
						$id_ingreso_tarifa_base="";
						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones, id_us_original)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."', '".$_POST["id_us_aprobador_actual"]."')"; 
						$sql_inser=mssql_query($inserta_aprobacion.$trae_id_insrte);						
						$id_ingreso_tarifa_base = id_insert($sql_inser);
										
							$busca_aprobaciones_cabia_estado="select count(*) from $t7 where t6_tarifas_lista_id = $id_tarifa and estado_aprobacion = 1 and t6_tarifas_estados_tarifas_id = 1";
							$sql_query_aprobaciones_actuales=traer_fila_row(mssql_query($busca_aprobaciones_cabia_estado));		

						

						$campo_file_nombre1_rechazo = "";
						$campo_file_temp1_rechazo = "";

						$campo_file_nombre1_rechazo = $_FILES["carga_anexo_individula_".$id_tarifa]["name"];
						$campo_file_temp1_rechazo = $_FILES["carga_anexo_individula_".$id_tarifa]["tmp_name"];
					
						echo $campo_file_nombre1_rechazo."rene";
					
						$id_ingreso_tarifa_base_anexo="";
						if( ($id_ingreso_tarifa_base>=1) && ($campo_file_nombre1_rechazo !="") )
							{// si trae anexo
								echo $inserta_anexo_primero = "insert into t6_tarifas_aprobaciones_anexos (t6_tarifas_aprobaciones_id, us_id, fecha_cargue, nombre_archivo)
								 values ('".$id_contrato_arr."', ".$_SESSION["id_us_session"].", '$fecha $hora','".elimina_comillas_2($campo_file_nombre1_rechazo)."' )";
								 $inserta_anexo = mssql_query($inserta_anexo_primero.$trae_id_insrte);
								 $id_ingreso_tarifa_base_anexo = id_insert($inserta_anexo);
								 
								 $inserta_relacion_tarifas = "insert into t6_tarifas_aprobaciones_anexos_tarifa (t6_tarifas_aprobaciones_anexos_id, t6_tarifas_lista_id) values
								  (".$id_ingreso_tarifa_base_anexo.",".$id_tarifa.")";

  								 $inserta_anexo_relacion = mssql_query($inserta_relacion_tarifas);
								
								  $copiar = carga_archivo($campo_file_temp1_rechazo,'tarifas_aprobaciones/'.$id_ingreso_tarifa_base_anexo );
								
								}// si trae anexo
							
							
							if($sql_query_aprobaciones_actuales[0]<$numero_aprobaciones_req){//si NO  ya se cumpliron las aprobaciones
									 $siguiente_aprobador_funcion = pasos_aprobacion_tarifas($numero_aprobaciones_req,$sql_query_aprobaciones_actuales[0],$busca_datos_del_contrato[22],$busca_datos_del_contrato[14]);
									
									$siguiente_aprobador_arrgle =explode("|",$siguiente_aprobador_funcion);
									$siguiente_aprobador=$siguiente_aprobador_arrgle[0];
									$roll_aprobador=$siguiente_aprobador_arrgle[1];
									
									if($roll_aprobador==1) $roll_perfil_inbox = "Gerente de contrato";
									elseif($roll_aprobador==2) $roll_perfil_inbox = "Profesional de C&C";
									elseif($roll_aprobador==3) $roll_perfil_inbox = "Jefe de area";
									
									$cambia_estado_actual=mssql_query("update $t3 set us_aprobacion_actual=$siguiente_aprobador where t6_tarifas_lista_id = $id_tarifa");
									
									
									if($roll_aprobador<=3){//si va hasta el jefe de area
									
									
									
									$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$siguiente_aprobador." and estado = 1"));
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

									
								}//si  NO se cumplieron las aprobaciones
								
							else{//si ya  se cumplieron las aprobaciones	
							 
							$tarifas_aprobaidas.=",".$id_tarifa;	
									$cambia_estado_actual=mssql_query("update $t3 set us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa");
									
									$busca_tarifa_padre = traer_fila_row(mssql_query("select tarifa_padre, fecha_inicio_vigencia from $t3 where t6_tarifas_lista_id = $id_tarifa and tarifa_padre >=1 "));
			
									if($busca_tarifa_padre[0]>=1){//si tiene hijos
									$fecha_finalizacion = resta_dia_fecha(1, $busca_tarifa_padre[1]);
									$cambia_estado_hijos="update $t3 set t6_tarifas_estados_tarifas_id = 7,fecha_fin_vigencia='$fecha_finalizacion' where tarifa_padre = $busca_tarifa_padre[0] and t6_tarifas_estados_tarifas_id = 1 and fecha_fin_vigencia <> '0000-00-00'";
									$sql_cambia_tarifas_hijos=mssql_query($cambia_estado_hijos);
									
			
									$cambia_estado_padres="update $t3 set t6_tarifas_estados_tarifas_id = 7 , fecha_fin_vigencia='$fecha_finalizacion' where t6_tarifas_lista_id = $busca_tarifa_padre[0] and t6_tarifas_estados_tarifas_id = 1 and fecha_fin_vigencia <> '0000-00-00'";
									$sql_cambia_tarifas_padre=mssql_query($cambia_estado_padres);
										
									} //si tiene hijos
			
									$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = '1' where t6_tarifas_lista_id = $id_tarifa";
									$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);
									
							}						
							echo "siguiente".$siguiente_aprobador."siguiente <br>";
					$genera_email++;
					}// si el estado es aprobado para enviar email a la siguiente
					
					}//si selecciona un estado
				
				
				
				}//inicio for
			
		
									
									
				$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where us_aprobacion_actual = ".$_SESSION["id_us_session"]." and t6_tarifas_estados_tarifas_id in (2,3)"));
				if($borra_inbox_cunat_pendientes[0]==0){// si ya no tiene aprobaciones pendientes borra el inbox
				//$borra_inbox=mssql_query("delete from  t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]);
				$borra_inbox=mssql_query("update  t6_tarifas_responsables_aprobadores set estado = 2 where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]);
				}// si ya no tiene aprobaciones pendientes borra el inbox										
	
	
	/*---------- ----------------- -----------------GENERA EMAILS ------------------------- ---------- -------------- --------------*/
							if($tarifas_devuieltas!=""){//si tiene devoluciones genera email
								$busca_usuarios_aprobaciones_ateriores = "select t6_tarifas_lista_id, us_id from t6_tarifas_lista where t6_tarifas_lista_id in (0 $tarifas_devuieltas)";
									$sql_ema_devu = query_db($busca_usuarios_aprobaciones_ateriores);									
									while($busca_tarifas_dev = traer_fila_row($sql_ema_devu)){//busca_email_notificacion
									if($email_proveedor != $busca_tarifas_dev[1]){
									$id_us_email_notificaciones_rechaza= $id_us_email_notificaciones_rechaza.", ".$busca_tarifas_dev[1];//agrega el usuario del Proveedor
									$email_proveedor = $busca_tarifas_dev[1];
									}
									
									$sel_aprobadores = query_db("select us_id from t6_tarifas_aprobaciones where t6_tarifas_lista_id = ".$busca_tarifas_dev[0]." and us_id not in (".$id_us_email_notificaciones_rechaza.")");										
										while ($sel_ap = traer_fila_db($sel_aprobadores)){//selecciona los aprobadores
											$id_us_email_notificaciones_rechaza= $id_us_email_notificaciones_rechaza.", ".$sel_ap[0];
											}
									}//tarifas
					/*ENVIO DE CORREO ELECTRONICO RECHAZO*/
						if($id_us_email_notificaciones_rechaza<> "0"){// si entro a agregar usuario por que era la ultima firma.
							$mail = new PHPMailer();
								$mail->IsSMTP(); 
								$mail->SMTPAuth = false; 
								$mail->SMTPSecure = "";
								$mail->Port = 25; 
								$mail->Username = $correo_autentica_phpmailer; 
								$mail->Password = $contrasena_autentica_phpmailer; 
								$mail->Host = $servidor_phpmailer;
								$mail->From = "abastecimiento@hcl.com.co";
								$mail->FromName = "Bogota, Abastecimiento";
								//$mail->AddAddress("ferney.sterling@enternova.net","Ferney Sterling");
								$sel_con_tar = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id=".$id_contrato_arr));
								$sel_co_mod = traer_fila_row(query_db("select gerente, especialista from t7_contratos_contrato where id = ".$sel_con_tar[0]));
							
							
							$gerente = 0;
							$profesional=0;
							$jefe = 0;
							
							if($sel_co_mod[0] > 0){
								$gerente = $sel_co_mod[0];
								}
							if($sel_co_mod[1] > 0){
								$profesional=$sel_co_mod[1];
								}
							if(busca_jefe_area_contrato($id_contrato_arr) > 0){
								$jefe=busca_jefe_area_contrato($id_contrato_arr);
								}
								
								
							$sele_email_usurios = query_db("select email,nombre_administrador from t1_us_usuarios where us_id in (17968, ".$jefe.", $id_us_email_notificaciones_rechaza, '".$gerente."', '".$profesional."') group by email,nombre_administrador");
								  while($sl_correo = traer_fila_db($sele_email_usurios)){
									  $mail->AddAddress($sl_correo[0],$sl_correo[1]);
								  }
								  
/*seleccion de contrato y datos del mismo*/
	$sel_contrato_modulo = traer_fila_row(query_db("select consecutivo, creacion_sistema, apellido, tipo_bien_servicio, CAST(objeto as TEXT), gerente from t7_contratos_contrato where id = ".$sel_con_tar[0]));
$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sel_contrato_modulo[1]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sel_contrato_modulo[0];//consecutivo
		$numero_contrato4 = $sel_contrato_modulo[2];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contrato_tarifas[0]);
/*seleccion de contrato y datos del mismo*/


								$asunto = " Tarifas rechazadas contrato ".$contrato_ajus;
								$texto_correo = 'Respetados Señores,.<br /><br />Las tarifas del contrato de la referencia "'.$sel_contrato_modulo[4].'", han sido rechazadas por el (la) señor(a) '.saca_nombre_lista($g1,$_SESSION["id_us_session"],'nombre_administrador','us_id').'.  Favor verificar en la plataforma la razón por la cual se rechazaron y proceder lo antes posible a efectuar las modificaciones o correcciones solicitadas<br /><br />Recuerde que el gerente del contrato es el (la) señor(a) '.saca_nombre_lista($g1,$sel_contrato_modulo[5],'nombre_administrador','us_id').'.<br /><br />Cordial saludo, <br />';
								echo "<br /><br /><br />".$asunto;
								echo $texto_correo;

								$mail->Subject = $asunto;
								$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
								$mail->Body = $texto_correo;
								$mail->AltBody = "SGPA Informaciones";
								//$mail->	();
						}
		/*ENVIO DE CORREO ELECTRONICO RECHAZO*/
								
								}//si tiene devoluciones genera email
/*---------- ----------------- ----------------- ------------------------- ---------- -------------- --------------*/
							if($tarifas_aprobaidas!=""){//si tiene aprobaciones genera email
								$busca_usuarios_aprobaciones_ateriores = "select t6_tarifas_lista_id, us_id from t6_tarifas_lista where t6_tarifas_lista_id in (0 $tarifas_aprobaidas)";
									$sql_ema_devu = query_db($busca_usuarios_aprobaciones_ateriores);	
									$email_proveedor="";								
									while($busca_tarifas_dev = traer_fila_row($sql_ema_devu)){//busca_email_notificacion
									if($email_proveedor != $busca_tarifas_dev[1]){
									$id_us_email_notificaciones_aproba= $id_us_email_notificaciones_aproba.", ".$busca_tarifas_dev[1];//agrega el usuario del Proveedor
									$email_proveedor = $busca_tarifas_dev[1];
									}
									
									$sel_aprobadores = query_db("select us_id from t6_tarifas_aprobaciones where t6_tarifas_lista_id = ".$busca_tarifas_dev[0]." and us_id not in (".$id_us_email_notificaciones_aproba.")");										
										while ($sel_ap = traer_fila_db($sel_aprobadores)){//selecciona los aprobadores
											$id_us_email_notificaciones_aproba= $id_us_email_notificaciones_aproba.", ".$sel_ap[0];
											}
									}//tarifas
									
					/*ENVIO DE CORREO ELECTRONICO APROBACIONES*/
						if($id_us_email_notificaciones_aproba <> "0"){// si entro a agregar usuario por que era la ultima firma.
							$mail = new PHPMailer();
								$mail->IsSMTP(); 
								$mail->SMTPAuth = false; 
								$mail->SMTPSecure = "";
								$mail->Port = 25; 
								$mail->Username = $correo_autentica_phpmailer; 
								$mail->Password = $contrasena_autentica_phpmailer; 
								$mail->Host = $servidor_phpmailer;
								$mail->From = "abastecimiento@hcl.com.co";
								$mail->FromName = "Bogota, Abastecimiento";
								//$mail->AddAddress("ferney.sterling@enternova.net","Ferney Sterling");
								
								 $sel_con_tar = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id=".$id_contrato_arr));
								$sel_co_mod = traer_fila_row(query_db("select gerente, especialista from t7_contratos_contrato where id = ".$sel_con_tar[0]));
							
							if($sel_co_mod[0] > 0){
								$gerente = $sel_co_mod[0];
								}
							if($sel_co_mod[1] > 0){
								$profesional=$sel_co_mod[1];
								}
							if(busca_jefe_area_contrato($id_contrato_arr) > 0){
								$jefe=busca_jefe_area_contrato($id_contrato_arr);
								}
								
								
							$sele_email_usurios = query_db("select email,nombre_administrador from t1_us_usuarios where us_id in (17968, ".$jefe.", $id_us_email_notificaciones_aproba, '".$gerente."', '".$profesional."') group by email,nombre_administrador");
								  while($sl_correo = traer_fila_db($sele_email_usurios)){
									  $mail->AddAddress($sl_correo[0],$sl_correo[1]);
									  echo $sl_correo[0]."- APRUEBA <br />";
								  }
/*seleccion de contrato y datos del mismo*/
	$sel_contrato_modulo = traer_fila_row(query_db("select consecutivo, creacion_sistema, apellido, tipo_bien_servicio, CAST(objeto as TEXT), gerente from t7_contratos_contrato where id = ".$sel_con_tar[0]));
$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sel_contrato_modulo[1]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sel_contrato_modulo[0];//consecutivo
		$numero_contrato4 = $sel_contrato_modulo[2];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contrato_tarifas[0]);
/*seleccion de contrato y datos del mismo*/

	
								$asunto = " Aprobación tarifas contrato ".$contrato_ajus;
								//SE MODIFICO PARA EL DES098
								$texto_correo = 'Respetados Señores,.<br /><br />Las tarifas del contrato de la referencia, "'.$sel_contrato_modulo[4].'", han sido aprobadas, pueden proceder a elaborar su tiquete de servicio<br /><br />Recuerde que el gerente del contrato es el (la) señor(a) '.saca_nombre_lista($g1,$sel_contrato_modulo[5],'nombre_administrador','us_id').'.<br /><br />Por Favor tener en cuenta: <br />
1.    La creación y/o actualización de tarifas que está efectuando no implica, de ninguna manera, incremento en el valor del contrato. <br />
2.    La creación y/o actualización de la(s) tarifa(s) se requiere(n) esencialmente para cumplir con el objeto del mismo del contrato. <br />
Estas creaciones y/o actualizaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.
								<br /><br />Cordial saludo, <br />';
								echo "<br /><br />".$asunto;
								echo $texto_correo;
								$mail->Subject = $asunto;
								$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
								$mail->Body = $texto_correo;
								$mail->AltBody = "SGPA Informaciones";
								$mail->Send();
						}
		/*ENVIO DE CORREO ELECTRONICO APROBACIONES*/
								
								}//si tiene aprobaciones genera email
								
	/*---------- ----------------- -----------------GENERA EMAILS ------------------------- ---------- -------------- --------------*/									
			
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se termino con éxito', 20, 10, 18);
                    //alert("El proceso se termino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
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
			
		$busca_detalle = query_db(" select   t6_tarifas_lista_id from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (2,3) and us_aprobacion_actual in (".$_SESSION["usuarios_con_reemplazo"].")") ;
		
			
		$id_us_email_notificaciones = 0;
		
						$campo_file_nombre1_rechazo = "";
						$campo_file_temp1_rechazo = "";

						$campo_file_nombre1_rechazo = $_FILES["cargue_anexo_masiva"]["name"];
						$campo_file_temp1_rechazo = $_FILES["cargue_anexo_masiva"]["tmp_name"];
						$tamano_file_temp1_rechazo = $_FILES["cargue_anexo_masiva"]["size"];
						$extencion_anexo = strtolower(extencion_archivos_tarifas($campo_file_nombre1_rechazo));
						
						$tamano_file_temp1_rechazo = ($tamano_file_temp1_rechazo/1024)/1024;
						
						$id_ingreso_tarifa_base_anexo="";
						if($campo_file_nombre1_rechazo !="") 
							{// si trae anexo
							
						
						if( ($extencion_anexo!= "rar") && ($extencion_anexo!= "zip") )
							{
							?>
                                	<script>
									window.parent.document.getElementById("cargando_pecc").style.display = "none"
									window.parent.document.getElementById("botones_acciones").style.display=""
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El anexo debe ser .zip o .rar |<?=$extencion_anexo;?>|', 20, 10, 18)
									//alert("El anexo debe ser .zip o .rar |<?=$extencion_anexo;?>|")
									
									</script>
                                <?
								
								exit();
								}
							
						
						if($tamano_file_temp1_rechazo>=6)
							{
							?>
                                	<script>
									window.parent.document.getElementById("cargando_pecc").style.display = "none"
									window.parent.document.getElementById("botones_acciones").style.display=""
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El anexo no puede ser mayor a 5MB', 20, 10, 18)
									//alert("El anexo no puede ser mayor a 5MG")

									</script>
                                <?
								
								exit();
								}							
							
							
								echo $inserta_anexo_primero = "insert into t6_tarifas_aprobaciones_anexos (t6_tarifas_aprobaciones_id, us_id, fecha_cargue, nombre_archivo)
								 values ('".$id_contrato_arr."', ".$_SESSION["id_us_session"].", '$fecha $hora','".elimina_comillas_2($campo_file_nombre1_rechazo)."' )";
								 $inserta_anexo = mssql_query($inserta_anexo_primero.$trae_id_insrte);
								 $id_ingreso_tarifa_base_anexo = id_insert($inserta_anexo);
								 
							
								
								}// si trae anexo		
		
		
		while($sel_id_tarifa_lista = traer_fila_db($busca_detalle))
				{//inicio for
				$id_tarifa = $sel_id_tarifa_lista[0];
			$verifica_cuantas_firmas_por_usuario="select count(*) from $t7 where t6_tarifas_lista_id = $id_tarifa and us_id in (".$_SESSION["usuarios_con_reemplazo"].")";
			$sql_verifica_cuantas_firmas_por_usuario=traer_fila_row(mssql_query($verifica_cuantas_firmas_por_usuario));		
			
			if ($numero_aprobaciones_req==3 && $sql_verifica_cuantas_firmas_por_usuario[0]>=2){
			?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La aprobación No se pudo realizar', 20, 10, 18)
					//alert("Atención: La aprobación No se pudo realizar")
                window.parent.document.getElementById("cargando_pecc").style.display = "none"
                </script>
			<?
			exit();
			}
			
			if ($numero_aprobaciones_req==4 && $sql_verifica_cuantas_firmas_por_usuario[0]>=3){
			?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La aprobación No se pudo realizar', 20, 10, 18)
				//alert("Atención: La aprobación No se pudo realizar")
				window.parent.document.getElementById("cargando_pecc").style.display = "none"                
                </script>
            <?
            exit();

            }
			echo $valor_aprobacion."--";
			$valor_aprobacion=1; // El valor en 1 para que todas sean aprobadas
			if($valor_aprobacion>=1){//si selecciona un estado
				
				if( $valor_aprobacion==1) { // si el steado es aprobado para enviar email a la siguiente
				$id_ingreso_tarifa_base ="";
										
				$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones, id_us_original)";
				$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".elimina_comillas_2($_POST["observaciones_".$id_tarifa])."', '".$_POST["id_us_aprobador_actual"]."')"; 
				echo $inserta_aprobacion;
		
				$sql_inser=mssql_query($inserta_aprobacion.$trae_id_insrte);						
				$id_ingreso_tarifa_base = id_insert($sql_inser);
									
				$busca_aprobaciones_cabia_estado="select count(*) from $t7 where t6_tarifas_lista_id = $id_tarifa and estado_aprobacion = 1 and t6_tarifas_estados_tarifas_id = 1";
				$sql_query_aprobaciones_actuales=traer_fila_row(mssql_query($busca_aprobaciones_cabia_estado));		
	
					if($id_ingreso_tarifa_base_anexo>=1){//si guardo anexo
					 $inserta_relacion_tarifas = "insert into t6_tarifas_aprobaciones_anexos_tarifa (t6_tarifas_aprobaciones_anexos_id, t6_tarifas_lista_id) values
								  (".$id_ingreso_tarifa_base_anexo.",".$id_tarifa.")";

  								 $inserta_anexo_relacion = mssql_query($inserta_relacion_tarifas);
								
								  $copiar = carga_archivo($campo_file_temp1_rechazo,'tarifas_aprobaciones/'.$id_ingreso_tarifa_base_anexo );


					}//si guardo anexo

		
		
		
		
		
					
					
					if($sql_query_aprobaciones_actuales[0]<$numero_aprobaciones_req){//si NO  ya se cumpliron las aprobaciones
							 $siguiente_aprobador_funcion = pasos_aprobacion_tarifas($numero_aprobaciones_req,$sql_query_aprobaciones_actuales[0],$busca_datos_del_contrato[22],$busca_datos_del_contrato[14]);
							
							$siguiente_aprobador_arrgle =explode("|",$siguiente_aprobador_funcion);
							$siguiente_aprobador=$siguiente_aprobador_arrgle[0];
							$roll_aprobador=$siguiente_aprobador_arrgle[1];
							
							if($roll_aprobador==1) $roll_perfil_inbox = "Gerente de contrato";
							elseif($roll_aprobador==2) $roll_perfil_inbox = "Profesional de C&C";
							elseif($roll_aprobador==3) $roll_perfil_inbox = "Jefe de area";
							
							$cambia_estado_actual=mssql_query("update $t3 set us_aprobacion_actual=$siguiente_aprobador where t6_tarifas_lista_id = $id_tarifa");
							
							
							if($roll_aprobador<=3){//si va hasta el jefe de area
							
							$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$siguiente_aprobador." and estado = 1"));
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
	
							if($busca_tarifa_padre[0]>=1){//si tiene hijos
							$fecha_finalizacion = resta_dia_fecha(1, $busca_tarifa_padre[1]);
							$cambia_estado_hijos="update $t3 set t6_tarifas_estados_tarifas_id = 7,fecha_fin_vigencia='$fecha_finalizacion' where tarifa_padre = $busca_tarifa_padre[0] and t6_tarifas_estados_tarifas_id = 1 and fecha_fin_vigencia <> '0000-00-00'";
							$sql_cambia_tarifas_hijos=mssql_query($cambia_estado_hijos);
							
	
							$cambia_estado_padres="update $t3 set t6_tarifas_estados_tarifas_id = 7 , fecha_fin_vigencia='$fecha_finalizacion' where t6_tarifas_lista_id = $busca_tarifa_padre[0] and t6_tarifas_estados_tarifas_id = 1 and fecha_fin_vigencia <> '0000-00-00'";
							$sql_cambia_tarifas_padre=mssql_query($cambia_estado_padres);
								
							} //si tiene hijos
	
							$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = 1 where t6_tarifas_lista_id = $id_tarifa";
							$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);
							
							

	$sel_aprobadores = query_db("select us_id from t6_tarifas_aprobaciones where t6_tarifas_lista_id = $id_tarifa and us_id not in ($id_us_email_notificaciones)");
	while ($sel_ap = traer_fila_db($sel_aprobadores)){//selecciona los aprobadores
		$id_us_email_notificaciones= $id_us_email_notificaciones.", ".$sel_ap[0];
		}
		$sel_aprobadores = query_db("select us_id from t6_tarifas_lista where t6_tarifas_lista_id = $id_tarifa and us_id not in ($id_us_email_notificaciones)");
	while ($sel_ap = traer_fila_db($sel_aprobadores)){//selecciona el proveedor
		$id_us_email_notificaciones= $id_us_email_notificaciones.", ".$sel_ap[0];
		}
	
	
	
							
							
							
					}						
					echo "siguiente".$siguiente_aprobador."siguiente <br>";
			$genera_email++;
			}// si el steado es aprobado para enviar email a la siguiente
			
			}//si selecciona un estado
		
		}//inicio for			
		
		
		/*ENVIO DE CORREO ELECTRONICO*/
						if($id_us_email_notificaciones<> "0"){// si entro a agregar usuario por que era la ultima firma.
							$mail = new PHPMailer();
								$mail->IsSMTP(); 
								$mail->SMTPAuth = false; 
								$mail->SMTPSecure = "";
								$mail->Port = 25; 
								$mail->Username = $correo_autentica_phpmailer; 
								$mail->Password = $contrasena_autentica_phpmailer; 
								$mail->Host = $servidor_phpmailer;
								$mail->From = "abastecimiento@hcl.com.co";
								$mail->FromName = "Bogota, Abastecimiento";
								//$mail->AddAddress("ferney.sterling@enternova.net","Ferney Sterling");
								
								 $sel_con_tar = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id=".$id_contrato_arr));
								$sel_co_mod = traer_fila_row(query_db("select gerente, especialista from t7_contratos_contrato where id = ".$sel_con_tar[0]));
							
							$sele_email_usurios = query_db("select email,nombre_administrador from t1_us_usuarios where us_id in (17968, ".busca_jefe_area_contrato($id_contrato_arr).", $id_us_email_notificaciones, '".$sel_co_mod[0]."', '".$sel_co_mod[1]."') group by email,nombre_administrador");
								  while($sl_correo = traer_fila_db($sele_email_usurios)){
									  $mail->AddAddress($sl_correo[0],$sl_correo[1]);
									  echo $sl_correo[0]."-<br />";
								  }
								  
/*seleccion de contrato y datos del mismo*/
	$sel_contrato_modulo = traer_fila_row(query_db("select consecutivo, creacion_sistema, apellido, tipo_bien_servicio, CAST(objeto as TEXT), gerente from t7_contratos_contrato where id = ".$sel_con_tar[0]));
$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sel_contrato_modulo[1]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sel_contrato_modulo[0];//consecutivo
		$numero_contrato4 = $sel_contrato_modulo[2];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contrato_tarifas[0]);
/*seleccion de contrato y datos del mismo*/

								  
								$asunto = " Aprobación tarifas contrato ".$contrato_ajus;
								//SE MODIFICO PARA EL DES098
								$texto_correo = 'Respetados Señores,.<br /><br />Las tarifas del contrato de la referencia, "'.$sel_contrato_modulo[4].'", han sido aprobadas, pueden proceder a elaborar su tiquete de servicio<br /><br />Recuerde que el gerente del contrato es el (la) señor(a) '.saca_nombre_lista($g1,$sel_contrato_modulo[5],'nombre_administrador','us_id').'.<br /><br />Por Favor tener en cuenta: <br />
1.    La creación y/o modificación de tarifas que está efectuando no implica, de ninguna manera, incremento en el valor del contrato. <br />
2.    La creación y/o modificación de la(s) tarifa(s) se requiere(n) esencialmente para cumplir con el objeto del mismo del contrato. <br />
Estas creaciones y/o modificaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.
								<br /><br />Cordial saludo, <br />';
								echo "<br /><br />".$asunto;
								echo $texto_correo;
								
								$mail->Subject = $asunto;
								$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
								$mail->Body = $texto_correo;
								$mail->AltBody = "SGPA Informaciones";
								$mail->Send();
						}
		/*ENVIO DE CORREO ELECTRONICO*/
							
								
									
		$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where us_aprobacion_actual = ".$_SESSION["id_us_session"]." and t6_tarifas_estados_tarifas_id in (2,3)"));
		if($borra_inbox_cunat_pendientes[0]==0){// si ya no tiene aprobaciones pendientes borra el inbox
		//$borra_inbox=mssql_query("delete from  t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]);
		$borra_inbox=mssql_query("update  t6_tarifas_responsables_aprobadores set estado = 2 where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]);
		}// si ya no tiene aprobaciones pendientes borra el inbox										

										
		if($tarifas_devuieltas!="")
			{//si tiene devoluciones genera email
				
				//$busca_usuarios_aprobaciones_ateriores = "select distinct email from v_tarifas_relacion_usuarios_aprobaciones where t6_tarifas_lista_id in (0 $tarifas_devuieltas)";
				//$sql_ema_devu = query_db($busca_usuarios_aprobaciones_ateriores);
				
		//		while($busca_email_destino = traer_fila_row($sql_ema_devu)){//busca_email_notificacion
			
					//$texto_email_arreglado=arregla_texto_email_para_enviar($busca_datos_del_contrato[6],$busca_datos_del_contrato[7],$_SESSION["us_nombre_session"],$modelo_rechazo_pendiente_admin);
					//registra_correos_enviados_nuevo(5, $id_contrato_arr, 0, 0, $busca_email_destino[0], $modelo_rechazo_pendiente_admin_asunto, $texto_email_arreglado);

			//	}//busca_email_notificacion
			
			}//si tiene devoluciones genera email
			
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se termino con éxito', 20, 10, 18);
                    //alert("El proceso se termino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');
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
			$ob_general = elimina_comillas_2($_POST["ob_general"]);
			
			
									$campo_file_nombre1_rechazo = "";
						$campo_file_temp1_rechazo = "";

						$campo_file_nombre1_rechazo = $_FILES["anexo_rechazo_masivo"]["name"];
						$campo_file_temp1_rechazo = $_FILES["anexo_rechazo_masivo"]["tmp_name"];
						$tamano_file_temp1_rechazo = $_FILES["anexo_rechazo_masivo"]["size"];
						$extencion_anexo = strtolower(extencion_archivos_tarifas($campo_file_nombre1_rechazo));
						$tamano_file_temp1_rechazo = ($tamano_file_temp1_rechazo/1024)/1024;
						
					
						$id_ingreso_tarifa_base_anexo="";
						if($campo_file_nombre1_rechazo !="") 
							{// si trae anexo
							

						if( ($extencion_anexo!= "rar") && ($extencion_anexo!= "zip") )
							{
							?>
                                	<script>
									window.parent.document.getElementById("cargando_pecc").style.display = "none"
									window.parent.document.getElementById("botones_acciones").style.display=""
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El anexo debe ser .zip o .rar |<?=$extencion_anexo;?>|', 20, 10, 18)
									//alert("El anexo debe ser .zip o .rar |<?=$extencion_anexo;?>|")
									
									</script>
                                <?
								
								exit();
								}
							
						
						if($tamano_file_temp1_rechazo>=6)
							{
							?>
                                	<script>
									window.parent.document.getElementById("cargando_pecc").style.display = "none"
									window.parent.document.getElementById("botones_acciones").style.display=""
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El anexo no puede ser mayor a 5MB', 20, 10, 18)
									//alert("El anexo no puede ser mayor a 5MG")

									</script>
                                <?
								
								exit();
								}							
							
							
							
								echo $inserta_anexo_primero = "insert into t6_tarifas_aprobaciones_anexos (t6_tarifas_aprobaciones_id, us_id, fecha_cargue, nombre_archivo)
								 values ('".$id_contrato_arr."', ".$_SESSION["id_us_session"].", '$fecha $hora','".elimina_comillas_2($campo_file_nombre1_rechazo)."' )";
								 $inserta_anexo = mssql_query($inserta_anexo_primero.$trae_id_insrte);
								 $id_ingreso_tarifa_base_anexo = id_insert($inserta_anexo);
								 
							
								
								}// si trae anexo		

			
			
			
			
			$busca_detalle = query_db(" select   t6_tarifas_lista_id from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (2,3) and us_aprobacion_actual in (".$_SESSION["usuarios_con_reemplazo"].")") ;	
		$id_us_email_notificaciones = 0;
		while($sel_id_tarifa_lista = traer_fila_db($busca_detalle))
				{//inicio for
				$id_tarifa = $sel_id_tarifa_lista[0];
				
				$valor_aprobacion=4;
			
				
						$inserta_aprobacion = "insert into $t7 (t6_tarifas_lista_id, t6_tarifas_estados_tarifas_id, us_id, fecha_aprobacion, estado_aprobacion, observaciones, id_us_original)";
						$inserta_aprobacion.= " values ($id_tarifa,$valor_aprobacion,".$_SESSION["id_us_session"].", '$fecha $hora', 1, '".$ob_general."', '".$_POST["id_us_aprobador_actual"]."')"; 
						$sql_inser=mssql_query($inserta_aprobacion);						
								$cambia_estado_actual="update $t3 set t6_tarifas_estados_tarifas_id = $valor_aprobacion, us_aprobacion_actual=0 where t6_tarifas_lista_id = $id_tarifa";
								echo $cambia_estado_actual."<br />";
								$sql_cambia_tarifas_actual=mssql_query($cambia_estado_actual);	
								
		if($id_ingreso_tarifa_base_anexo>=1){//si guardo anexo
					 $inserta_relacion_tarifas = "insert into t6_tarifas_aprobaciones_anexos_tarifa (t6_tarifas_aprobaciones_anexos_id, t6_tarifas_lista_id) values
								  (".$id_ingreso_tarifa_base_anexo.",".$id_tarifa.")";

  								 $inserta_anexo_relacion = mssql_query($inserta_relacion_tarifas);
								
								  $copiar = carga_archivo($campo_file_temp1_rechazo,'tarifas_aprobaciones/'.$id_ingreso_tarifa_base_anexo );


					}//si guardo anexo


					

		$sel_aprobadores = query_db("select us_id from t6_tarifas_lista where t6_tarifas_lista_id = $id_tarifa and us_id not in ($id_us_email_notificaciones)");
	while ($sel_ap = traer_fila_db($sel_aprobadores)){//selecciona el proveedor
		$id_us_email_notificaciones= $id_us_email_notificaciones.", ".$sel_ap[0];
		}
		$sel_aprobadores = query_db("select us_id from t6_tarifas_aprobaciones where t6_tarifas_lista_id = $id_tarifa and us_id not in ($id_us_email_notificaciones)");
	while ($sel_ap = traer_fila_db($sel_aprobadores)){//selecciona los aprobadores
		$id_us_email_notificaciones= $id_us_email_notificaciones.", ".$sel_ap[0];
		}
		
				
				}//inicio for
			
		
									
									
										$borra_inbox_cunat_pendientes = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where us_aprobacion_actual = ".$_SESSION["id_us_session"]." and t6_tarifas_estados_tarifas_id in (2,3)"));
										if($borra_inbox_cunat_pendientes[0]==0){// si ya no tiene aprobaciones pendientes borra el inbox
										$borra_inbox=mssql_query("delete from  t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]);
										}// si ya no tiene aprobaciones pendientes borra el inbox										

									
									
									/*ENVIO DE CORREO ELECTRONICO*/
						if($id_us_email_notificaciones<> "0"){// si entro a agregar usuario por que era la ultima firma.
							$mail = new PHPMailer();
								$mail->IsSMTP(); 
								$mail->SMTPAuth = false; 
								$mail->SMTPSecure = "";
								$mail->Port = 25; 
								$mail->Username = $correo_autentica_phpmailer; 
								$mail->Password = $contrasena_autentica_phpmailer; 
								$mail->Host = $servidor_phpmailer;
								$mail->From = "abastecimiento@hcl.com.co";
								$mail->FromName = "Bogota, Abastecimiento";
								//$mail->AddAddress("ferney.sterling@enternova.net","Ferney Sterling");
								$sel_con_tar = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id=".$id_contrato_arr));
								$sel_co_mod = traer_fila_row(query_db("select gerente, especialista from t7_contratos_contrato where id = ".$sel_con_tar[0]));
							
							$sele_email_usurios = query_db("select email,nombre_administrador from t1_us_usuarios where us_id in (17968, ".busca_jefe_area_contrato($id_contrato_arr).", $id_us_email_notificaciones, '".$sel_co_mod[0]."', '".$sel_co_mod[1]."') group by email,nombre_administrador");
								  while($sl_correo = traer_fila_db($sele_email_usurios)){
									  $mail->AddAddress($sl_correo[0],$sl_correo[1]);
									  echo $sl_correo[0]."-<br />";
								  }
								  
								/*seleccion de contrato y datos del mismo*/
	$sel_contrato_modulo = traer_fila_row(query_db("select consecutivo, creacion_sistema, apellido, tipo_bien_servicio, CAST(objeto as TEXT), gerente from t7_contratos_contrato where id = ".$sel_con_tar[0]));
$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sel_contrato_modulo[1]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sel_contrato_modulo[0];//consecutivo
		$numero_contrato4 = $sel_contrato_modulo[2];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contrato_tarifas[0]);
/*seleccion de contrato y datos del mismo*/


								$asunto = " Tarifas rechazadas contrato ".$contrato_ajus;
								$texto_correo = 'Respetados Señores,.<br /><br />Las tarifas del contrato de la referencia "'.$sel_contrato_modulo[4].'", han sido rechazadas por el (la) señor(a) '.saca_nombre_lista($g1,$_SESSION["id_us_session"],'nombre_administrador','us_id').'.  Favor verificar en la plataforma la razón por la cual se rechazaron y proceder lo antes posible a efectuar las modificaciones o correcciones solicitadas<br /><br />Recuerde que el gerente del contrato es el (la) señor(a) '.saca_nombre_lista($g1,$sel_contrato_modulo[5],'nombre_administrador','us_id').'<br /><br /><br />Cordial saludo, <br />';
								
								echo "<br /><br /><br />".$asunto;
								echo $texto_correo;

								$mail->Subject = $asunto;
								$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
								$mail->Body = $texto_correo;
								$mail->AltBody = "SGPA Informaciones";
								$mail->Send();
						}
		/*ENVIO DE CORREO ELECTRONICO*/
			
							if($tarifas_devuieltas!="")
								{/*si tiene devoluciones genera email
									
									$busca_usuarios_aprobaciones_ateriores = "select distinct email from v_tarifas_relacion_usuarios_aprobaciones where t6_tarifas_lista_id in (0 $tarifas_devuieltas)";
									$sql_ema_devu = query_db($busca_usuarios_aprobaciones_ateriores);
									
									while($busca_email_destino = traer_fila_row($sql_ema_devu)){//busca_email_notificacion
								
										$texto_email_arreglado=arregla_texto_email_para_enviar($busca_datos_del_contrato[6],$busca_datos_del_contrato[7],$_SESSION["us_nombre_session"],$modelo_rechazo_pendiente_admin);
										registra_correos_enviados_nuevo(5, $id_contrato_arr, 0, 0, $busca_email_destino[0], $modelo_rechazo_pendiente_admin_asunto, $texto_email_arreglado);


									}//busca_email_notificacion
								
								*/}//si tiene devoluciones genera email
									
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se termino con éxito', 20, 10, 18);
                    //alert("El proceso se termino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas');

                    </script>
			<?
			
		}

if($_POST["accion"]=="crear_nuevo_anexo_tarifas")
		{
			echo $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id
		
				
		
	
						$campo_file_nombre1_rechazo = $_FILES["nuevo_anexo_apro"]["name"];
						$campo_file_temp1_rechazo = $_FILES["nuevo_anexo_apro"]["tmp_name"];
						$tamano_file_nombre1_rechazo = $_FILES["nuevo_anexo_apro"]["size"];
						$ofeta_actual_ta = ($tamano_file_nombre1_rechazo/1024)/1024;
						if($ofeta_actual_ta>=6)
							{
								?>
                                	<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El anexo no puede ser mayor a 5MB', 20, 10, 18)
									//alert("El anexo no puede ser mayor a 5MG")
									</script>
                                <?
								exit();
								}
					
						echo $campo_file_nombre1_rechazo."rene";
					
						$id_ingreso_tarifa_base_anexo="";
						if($campo_file_nombre1_rechazo !="") 
							{// si trae anexo
								echo $inserta_anexo_primero = "insert into t6_tarifas_aprobaciones_anexos (t6_tarifas_aprobaciones_id, us_id, fecha_cargue, nombre_archivo)
								 values ('".$id_contrato_arr."', ".$_SESSION["id_us_session"].", '$fecha $hora','".elimina_comillas_2($campo_file_nombre1_rechazo)."' )";
								 $inserta_anexo = mssql_query($inserta_anexo_primero.$trae_id_insrte);
								 $id_ingreso_tarifa_base_anexo = id_insert($inserta_anexo);
											 
										if($id_ingreso_tarifa_base_anexo>=1){//si guardo anexo
											 $inserta_relacion_tarifas = "insert into t6_tarifas_aprobaciones_anexos_tarifa (t6_tarifas_aprobaciones_anexos_id, t6_tarifas_lista_id) values
											  (".$id_ingreso_tarifa_base_anexo.",".$id_tarifa.")";
			
											 $inserta_anexo_relacion = mssql_query($inserta_relacion_tarifas);
											
											  $copiar = carga_archivo($campo_file_temp1_rechazo,'tarifas_aprobaciones/'.$id_ingreso_tarifa_base_anexo );
									
								
								}//si guardo anexo
								
								}// si trae anexo	
			
		echo "<br>".$id_tarifa;
		echo "<br>".$ruta_apro;
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se termino con éxito', 20, 10, 18);
                    //alert("El proceso se termino con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/reporte_tarfifas_actualizada.php?id_contrato=<?=$id_contrato;?>&id_tarifa=<?=$id_tarifa;?>&ruta_apro=<?=$ruta_apro;?>','carga_acciones_permitidas');

                    </script>
			<?
		
		}
		
?>

					<script> 
				 					
window.parent.document.getElementById("cargando_pecc").style.display = "none"
                    </script>