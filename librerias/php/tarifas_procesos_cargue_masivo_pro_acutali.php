<?  include("../lib/@session.php");
	
	verifica_menu("proveedores.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
   require_once 'Excel/reader.php';
   set_time_limit (0);
   
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

   
function elimina_comillas_carge_2($valor){
		$id_subastas_arrglo = str_replace("'", "&quot;", $valor );
		$id_subastas_arrglo = str_replace('"', "&quot;", $id_subastas_arrglo);
//		$id_subastas_arrglo = str_replace('/', "", $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('*', "", $id_subastas_arrglo);
		
		$id_subastas_arrglo = ereg_replace( "á", "&aacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Á", "&Aacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "é", "&eacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "É", "&Eacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "í", "&iacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Í", "&Iacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "ó", "&oacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Ó", "&Oacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "ú", "&uacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Ú", "&Uacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "ñ", "&ntilde;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Ñ", "&Ntilde;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "½", "&frac12;", $id_subastas_arrglo );
		$id_subastas_arrglo = ereg_replace( "”", "&quot;", $id_subastas_arrglo ); 		
		$id_subastas_arrglo = ereg_replace( "’", "&quot;", $id_subastas_arrglo );
		 				
		
		return $id_subastas_arrglo;
}

function valida_numero_texto($valor){

		$id_subastas_arrglo = str_replace(".", "", $valor );
		$id_subastas_arrglo = str_replace(",", ".", $id_subastas_arrglo );
		 				

		return $id_subastas_arrglo;
}


function validar_fecha($fecha){
if (ereg("(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)[0-9]{2}", $fecha)) {
return 1;
} else {
return 2;
}
}	
  
function numerico($valor)
{

$idioma_excel = 1; //español

	$numero_bie = number_format($valor,5);
		if($numero_bie!="0.00")
			$erro_nu = 1;	
		else
			$erro_nu = 2;	

     return $erro_nu;
	 
	
}  
   
   $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id	
	if($_POST["accion"]=="cargue_masivo_tarifas")
		{
$sel_contrato_modulo_contratos = traer_fila_row(query_db("select id_contrato from t6_tarifas_contratos where tarifas_contrato_id = ".$id_contrato_arr));

		$extencion = extencion_archivos($_FILES["carga_tarifas"]["name"]);
		if($extencion!="xls")
			{
			 ?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El archivo que inteta subir debe ser con formato Excel 97 - 2003', 20, 10, 18);
				//alert("Atencion: El archivo que inteta subir debe ser con formato Excel 97 - 2003 ")
				</script>
			<? 
			$id_log = log_de_procesos_sgpa(5, 60, 0, $sel_contrato_modulo_contratos[0], 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Error", "Al intentar cargar la plantilla ocurrio un error que se le reporto al usuario" , "" ,1);
			log_agrega_detalle ($id_log, "Descripcion del Error", "¡ATENCION! La plantilla que intenta subir tiene ¡ERRORES!: El archivo que inteta subir debe ser con formato Excel 97 - 2003" , "" ,2);
			?><script>window.parent.document.getElementById("cargando").style.display="none";window.parent.document.getElementById("cargando_pecc").style.display="none";</script><?
				exit(); 
			} 

			 $busca_tarifas = "select estado_contrato,gerente,t1_tipo_documento_id from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr";
			$sql_busca_tarifas_gerente=traer_fila_row(query_db($busca_tarifas));
			
		if( ($sql_busca_tarifas_gerente[2]==2 ) && ($_POST["aprobacion_secundaria_0"]=="0") ){	
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Seleccione la persona que solicita la actualización', 20, 10, 18);
				//alert("Seleccione la persona que solicita la actualización ")
				</script>
			<? 
			$id_log = log_de_procesos_sgpa(5, 60, 0, $sel_contrato_modulo_contratos[0], 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Error", "Al intentar cargar la plantilla ocurrio un error que se le reporto al usuario" , "" ,1);
			log_agrega_detalle ($id_log, "Error", "Seleccione la persona que solicita la actualización ", "" ,2);

			?><script>window.parent.document.getElementById("cargando").style.display="none";window.parent.document.getElementById("cargando_pecc").style.display="none";</script><?
				exit(); 
				
				
		}


			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1252');
			$data->read($_FILES["carga_tarifas"]["tmp_name"]);

/******VALIDA ERRORES**********************/
/******VALIDA ERRORES**********************/
$err_m = "";
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { // RECORRE LAS FILAS
			

/*********************VALIDA QUE LE ARHIVO CONINCIDA***********************************/
/**************************************************************************************/

  	 $busca_tarifas_contrato = "select * from t6_tarifas_lista where t6_tarifas_lista_id = ".elimina_comillas_carge_2($data->sheets[0]['cells'][$i][1])." and tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes ";
	$sql_ex_lis_existe = traer_fila_row(query_db($busca_tarifas_contrato));

	$valor_excel_anetrior=numerico($data->sheets[0]['cells'][$i][9]);
	
		if($_POST["modi_convencion_0"]=="1")
				$tipo_modificacion_normal_convencion = 5;

			if($_POST["modi_convencion_0"]=="2")
				$tipo_modificacion_normal_convencion = 2;

	if($sql_ex_lis_existe[0]=="")
		$err_m = "* La tarifa en la fila ".$i." no existe";
	

	
/*	elseif(numerico($sql_ex_lis_existe[9])!=$valor_excel_anetrior)
		$err_m = " No debe modificar el valor existente en la fila ".$i." no coicide".$valor_excel_anetrior." r ".$sql_ex_lis_existe[9];		
*/


	if(elimina_comillas_carge_2($data->sheets[0]['cells'][$i][15])=="")
		$err_m = "* La unidad de medida no debe estar vacia o con caracteres de signos Fila ".$i." ";

	$item_oferta_pro = $data->sheets[0]['cells'][$i][14];
	$largocodigo = strlen($item_oferta_pro);
	if(elimina_comillas_carge_2($data->sheets[0]['cells'][$i][14])=="")
		$err_m = "* El ".TITULO_alertas." no debe estar vacia o con caracteres de signos Fila ".$i." ";

	if($largocodigo>=26)
		$err_m = "* El ".TITULO_alertas." de la fila ".$i." contine mas de 25 caracteres";
		
/**************************************************************************************/
/*********************VALIDA QUE LE ARHIVO CONINCIDA***********************************/
/*
			$categoria=$sql_ex_lis_existe[2];
			$grupo=$sql_ex_lis_existe[3];
			if($categoria=="")
				$err_m = " La categoria de la  fila ".$i." no tiene contenido";
*/


			$detalle_descuento_pasa=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][19]);
			if($detalle_descuento_pasa=="")
				$err_m = "* Aplica descuento enla fila ".$i." no tiene contenido";
				
			if( ($detalle_descuento_pasa!="SI") && ($detalle_descuento_pasa!="NO") )
				$err_m = "* -".$detalle_descuento_pasa."- Aplica descuento en la fila ".$i." solo debe digitar SI/NO";
		
			$detalle=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][20]);
			if($detalle=="")
				$err_m = "* Las observaciones de la fila ".$i." no tiene contenido";


			if($data->sheets[0]['cells'][$i][8]=="COP")
			$t1_moneda_id=1;
			elseif($data->sheets[0]['cells'][$i][8]=="USD")
			$t1_moneda_id=2;
			else {
				$err_m = "* El formato de moneda de la fila ".$i." esta errado";			
			}
			

			if($data->sheets[0]['cells'][$i][16]=="COP")
			$t1_moneda_id=1;
			elseif($data->sheets[0]['cells'][$i][16]=="USD")
			$t1_moneda_id=2;
			else {
				$err_m = "* El formato de moneda de la fila ".$i." esta errado";			
			}

			$valor=numerico($data->sheets[0]['cells'][$i][17]);
			if($valor==2)
				$err_m = " El valor de la fila ".$i." esta errado  * El valor no puede cero * El valor no debe llevar formatos numero * El valor no debe llevar formatos de moneda";
			$fecha_inicial=explode('/',$data->sheets[0]['cells'][$i][18]);
			$fecha_inicial=date( "Y-m-d", strtotime($fecha_inicial[2]."-".$fecha_inicial[1]."-".$fecha_inicial[0]) );
			$fecha_final=explode('/',$data->sheets[0]['cells'][$i][21]);
			$fecha_final=date( "Y-m-d", strtotime($fecha_final[2]."-".$fecha_final[1]."-".$fecha_final[0]) );
			//$err_m="inicial=  ".$fecha_inicial." fecha_final = ".$data->sheets[0]['cells'][$i][12]." vigencia = ".$_POST["vigencia_contrato"];
			if($data->sheets[0]['cells'][$i][21]!="" and $fecha_inicial>$fecha_final)
				$err_m.="* La fecha inicio vigencia de la fila ".$i." NO puede ser mayor que la fecha fin vigencia de la fila ".$i;

			if($fecha_inicial>$_POST["vigencia_contrato"])
				$err_m.="* La fecha inicio vigencia de la fila ".$i." NO puede ser mayor que la fecha de vigencia del contrato (".$_POST["vigencia_contrato"].")";

			if($data->sheets[0]['cells'][$i][21]!="" and $fecha_final>$_POST["vigencia_contrato"])
				$err_m.="* La fecha fin vigencia de la fila ".$i." NO puede ser mayor que la fecha de vigencia del contrato (".$_POST["vigencia_contrato"].")";
	
			if($fecha_inicial<$_POST["inicio_contrato"])
				$err_m.="* La fecha inicio vigencia de la fila ".$i." NO puede ser menor que la fecha de inicio del contrato (".$_POST["inicio_contrato"].")";

			if($data->sheets[0]['cells'][$i][21]!="" and $fecha_final<$_POST["inicio_contrato"])
				$err_m.="* La fecha fin vigencia de la fila ".$i." NO puede ser menor que la fecha de inicio del contrato (".$_POST["inicio_contrato"].")";
			$columna_valor_nuevo = $data->sheets[0]['cells'][$i][17];
			
				$valida_formato_tarifa = valida_valor_tarifa($columna_valor_nuevo);
			if($valida_formato_tarifa==2)
				$err_m="* El formato de la fila ".$i."   valor es incorrecto ";	
			
			$valida_valor = number_format($columna_valor_nuevo,5);
			if($valida_valor==0)
				$err_m="* El formato de la fila ".$i."  valor es incorrecto No debe contener formatos ni texto";	
			
			
			$fecha_inicio_vigencia_1 = $data->sheets[0]['cells'][$i][18];
			$fecha_inicio_vigencia_valida = validar_fecha($fecha_inicio_vigencia_1);
			
			if($fecha_inicio_vigencia_1!=""){ //si la fecha esta llena
	
				
			if($fecha_inicio_vigencia_valida==2)
				$err_m = "* La fecha de la fila ".$i." esta errada el formato debe ser dd/mm/yyyy";

				
				}//si la fecha esta llena
				
		
			$fecha_fin_vigencia_1 = $data->sheets[0]['cells'][$i][21];
			$fecha_fin_vigencia_valida = validar_fecha($fecha_fin_vigencia_1);
			
			if($fecha_fin_vigencia_1!=""){ //si la fecha esta llena
				if($fecha_fin_vigencia_valida==2)
					$err_m = "* La fecha fin de vigencia de la fila ".$i." esta errada el formato debe ser dd/mm/yyyy 23432";
				else
					{
								$fecha_fin_vigencia_1_para_validar=suma_dia_fecha_a(0,cambia_formato_fecha($data->sheets[0]['cells'][$i][21]));
								
								if($fecha_inicio_vigencia_1!="")			
									$fecha_inicio_vigencia_para_validar=suma_dia_fecha_a(0,cambia_formato_fecha($data->sheets[0]['cells'][$i][18]));
								else
									$fecha_inicio_vigencia_para_validar=$fecha;
						
								if( $fecha_fin_vigencia_1_para_validar < $fecha_inicio_vigencia_para_validar)
									$err_m = " La fecha fin de vigencia de la fila ".$i." no puede ser menor al la fecha de inicio ";	

						}
				
				}//si la fecha esta llena			
		
		
		if($err_m !="")
			{ ?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: <?=$err_m;?>', 60, 5, 10)
			//alert("Atencion: <?=$err_m;?>")
			</script>
			
			<? 
			$id_log = log_de_procesos_sgpa(5, 60, 0, $sel_contrato_modulo_contratos[0], 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Error", "Al intentar cargar la plantilla ocurrio un error que se le reporto al usuario" , "" ,1);
			log_agrega_detalle ($id_log, "Descripcion del Error", "¡ATENCION! La plantilla que intenta subir tiene ¡ERRORES!: ".$err_m , "" ,2);
	?><script>window.parent.document.getElementById("cargando").style.display="none";window.parent.document.getElementById("cargando_pecc").style.display="none";</script><?
			exit(); } 
				
}//		for errores

echo "aqui";
/******VALIDA ERRORES**********************/
/******VALIDA ERRORES**********************/			


			
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { // RECORRE LAS FILAS

  	 $busca_tarifas_contrato = "select * from t6_tarifas_lista where t6_tarifas_lista_id = ".elimina_comillas_carge_2($data->sheets[0]['cells'][$i][1])." and tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes ";
	$sql_ex_lis_existe = traer_fila_row(query_db($busca_tarifas_contrato));



			$categoria=$sql_ex_lis_existe[2];
			$grupo=$sql_ex_lis_existe[3];
			$codigo_proveedor=$data->sheets[0]['cells'][$i][14];;
			$detalle=$sql_ex_lis_existe[5];
			$unidad_medida=$data->sheets[0]['cells'][$i][15];
			$cantidad=$sql_ex_lis_existe[7];
			$t1_moneda_id=$t1_moneda_id;
			$valor=$data->sheets[0]['cells'][$i][17];
			
			$us_id=$_SESSION["id_us_session"];
			$fecha_creacion=$fecha." ".$hora;
			$tipo_creacion=2;
			$t6_tarifas_estados_tarifas_id=10;//estado provicional
			
			$fecha_inicio_vigencia_1 = $data->sheets[0]['cells'][$i][18];
		
			$fecha_inicio_vigencia_valida = validar_fecha($fecha_inicio_vigencia_1);

			
			if($fecha_inicio_vigencia_1!="")			
				$fecha_inicio_vigencia=cambia_formato_fecha($data->sheets[0]['cells'][$i][18]);//suma_dia_fecha_a(1,cambia_formato_fecha($data->sheets[0]['cells'][$i][17]));
			else
				$fecha_inicio_vigencia=$fecha;
			
			$fecha_final_vigencia_1 = $data->sheets[0]['cells'][$i][21];
			if($fecha_final_vigencia_1!="")			
				$fecha_fin_vigencia=suma_dia_fecha_a(0,cambia_formato_fecha($data->sheets[0]['cells'][$i][21]));
			else
				$fecha_fin_vigencia="0000-00-00";
			
			
			$tarifa_padre=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][1]);		
														
			$t6_tarifas_listas_lista_id=$id_lista;	
			$tipo_modificacion_normal_con = $tipo_modificacion_normal_convencion;
																					
			$detalle_descuento_pasa=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][19]);
			$detalle_observaciones=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][20]);
			
			
			if($_POST["aprobacion_secundaria_0"]!=""){
				$aprobacion_responsable = $_POST["aprobacion_secundaria_0"];
				}
			else { 
				$aprobacion_responsable = $sql_busca_tarifas_gerente[1];
				
				}
			
			$insert_fila = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, ";
			$insert_fila.="t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia, ";
			$insert_fila.="tarifa_padre, fecha_fin_vigencia, t6_tarifas_listas_lista_id,tipo_creacion_modifica,us_aprobacion_actual, creada_luego_firme) values(";			
			$insert_fila.="$id_contrato_arr,'$categoria', '$grupo', '$codigo_proveedor', '$detalle', '$unidad_medida', '$cantidad',  ";
			$insert_fila.="$t1_moneda_id, '$valor', $us_id, '$fecha_creacion', $tipo_creacion, $t6_tarifas_estados_tarifas_id, '$fecha_inicio_vigencia', ";			
		$insert_fila.="$tarifa_padre, '$fecha_fin_vigencia', $t6_tarifas_listas_lista_id,".$tipo_modificacion_normal_con.",".$aprobacion_responsable.",2) ";		
echo $insert_fila;
		 $insert_fila.$trae_id_insrte;
		 
		 echo $insert_fila;
		$sql_ex=query_db($insert_fila.$trae_id_insrte);
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){	//si la tarifa se creo			
			
			//$cambia_tarifa_padre = query_db("update $t3 set tarifa_padre = $id_ingreso where t6_tarifas_lista_id = $id_ingreso");
			//$cambia_tarifa_padre = query_db("update $t3 set fecha_fin_vigencia = '$fecha' where t6_tarifas_lista_id = $tarifa_padre");
			
			$inserta_aprobacion_secu = "insert into t6_tarifas_aprobadores_secundarios (t6_tarifas_lista_id, us_id, tipo_aprobacion_copia,tarifas_contrato_id, notificado)
			 values ($id_ingreso,".$aprobacion_responsable.",1,$id_contrato_arr,1)";
			 $graba_aprobador_secundario=query_db($inserta_aprobacion_secu);
			
			if($detalle_descuento_pasa=="SI") $detalle_descuento_pasa_graba = 1;
			else  $detalle_descuento_pasa_graba = 2;
			 $cambia_soporte = "insert into t6_tarifas_anexos_modifica_tarifas (t6_tarifas_lista_id,observaciones , anexo,descuento) values (
									$id_ingreso,'".$detalle_observaciones."', '',".$detalle_descuento_pasa_graba.")";
									$sql_cambi_so=query_db($cambia_soporte.$trae_id_insrte);
									
									$id_ingreso_soporte = id_insert($sql_cambi_so);
			
										
										
										
			
			
				$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $id_lista and estado = 1");
					$incrementa_colu=14;
					while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
					$inserta_atributos = "insert into $t14 (t6_tarifas_lista_id, t6_tarifas_atributos_id, detalle) values (";
					$inserta_atributos.="$id_ingreso,$lista_atr[0], '".$data->sheets[0]['cells'][$i][$incrementa_colu]."')";
					//$sql_ex=query_db($inserta_atributos);
					
					$incrementa_colu++;
					} //lista atributos	
			
			}//si la tarifa se creo			
			
			}// RECORRE LAS FILAS

			$id_log = log_de_procesos_sgpa(5, 61, 0, $sel_contrato_modulo_contratos[0], 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Quien solicita crear la tarifa", $_POST["aprobacion_secundaria_0"] , $g1 ,1);
			$sel_cuantas_tarifas = traer_fila_row(query_db("select count(*) from t6_tarifas_lista where tarifas_contrato_id = ".$id_contrato_arr." and fecha_creacion = '$fecha $hora'"));
			log_agrega_detalle ($id_log, "Numero de tarifas cargadas" , $sel_cuantas_tarifas[0], "" ,2);
					
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La plantilla se modifico con éxito, favor continuar con el paso 3 para el cargue y envío de sus tarifas para aprobación de Hocol', 20, 10, 18);
                    //alert("La plantilla se modifico con éxito, favor continuar con el paso 3 para el cargue y envío de sus tarifas para aprobación de Hocol")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualicar_masivas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$id_lista;?>','carga_acciones_permitidas');
                    </script>
			<?
					
		}			


		

?>
<script>
window.parent.document.getElementById("cargando").style.display="none";
window.parent.document.getElementById("cargando_pecc").style.display="none";
</script>
