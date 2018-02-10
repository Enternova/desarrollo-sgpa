<?  include("../lib/@session.php");
	
	verifica_menu("proveedores.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
   require_once 'Excel/reader.php';
   set_time_limit (0);
   
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

	$numero_bie = number_format($valor,2);
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
				<script>alert("¡ATENCION! La plantilla que intenta subir tiene ¡ERRORES!: El archivo que inteta subir debe ser con formato Excel 97 - 2003 ")</script>
			<? 
			
			$id_log = log_de_procesos_sgpa(5, 57, 0, $sel_contrato_modulo_contratos[0], 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Error", "Al intentar cargar la plantilla ocurrio un error que se le reporto al usuario" , "" ,1);
			log_agrega_detalle ($id_log, "Descripcion del Error", "¡ATENCION! La plantilla que intenta subir tiene ¡ERRORES!: El archivo que inteta subir debe ser con formato Excel 97 - 2003" , "" ,2);
				exit(); 
			} 


			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1252');
			$data->read($_FILES["carga_tarifas"]["tmp_name"]);

/******VALIDA ERRORES**********************/
/******VALIDA ERRORES**********************/
$err_m = "";
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { // RECORRE LAS FILAS
			
			$detalle=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][4]);
			if($detalle=="")
				$err_m = " El detalle de la fila ".$i." no tiene contenido";
			
			
			$unidad_medida=$data->sheets[0]['cells'][$i][5];
			if($unidad_medida=="")
				$err_m = " La unidad de medida de la fila ".$i." no tiene contenido";			
			$cantidad=$data->sheets[0]['cells'][$i][6];
			if($cantidad!="1")
				$err_m = " La cantidad siempre debe ser 1 error en fila ".$i."";			

			if($data->sheets[0]['cells'][$i][7]=="COP")
			$t1_moneda_id=1;
			elseif($data->sheets[0]['cells'][$i][7]=="USD")
			$t1_moneda_id=2;
			else {
				$err_m = " El formato de moneda de la fila ".$i." esta errado";			
			}
			

			$valor=numerico($data->sheets[0]['cells'][$i][8]);
			if($valor==2)
				$err_m = " El valor de la fila ".$i." esta errado  * El valor no puede cero * El valor no debe llevar formatos numero * El valor no debe llevar formatos de moneda";
			
			$detalle_descuento_pasa=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][10]);
			if($detalle_descuento_pasa=="")
				$err_m = " Aplica descuento en la fila ".$i." no tiene contenido";
				
			if( ($detalle_descuento_pasa!="SI") && ($detalle_descuento_pasa!="NO") )
				$err_m = "-".$detalle_descuento_pasa."- Aplica descuento en la fila ".$i." solo debe digitar SI/NO";
		
			$detalle=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][11]);
			if($detalle=="")
				$err_m = " Las observaciones de la fila ".$i." no tiene contenido";
			
			
			
			$fecha_inicio_vigencia_1 = $data->sheets[0]['cells'][$i][9];
			$fecha_inicio_vigencia_valida = validar_fecha($fecha_inicio_vigencia_1);
			
			if($fecha_inicio_vigencia_1!=""){ //si la fecha esta llena
	
				
			if($fecha_inicio_vigencia_valida==2)
				$err_m = " La fecha de la fila ".$i." esta errada el formato debe ser dd/mm/yyyy ";

				
				}//si la fecha esta llena
				
		
		if($err_m !="")
			{ ?>
			<script>alert("¡ATENCION! La plantilla que intenta subir tiene ¡ERRORES!: <?=$err_m;?>")</script>
			
			<? 
			$id_log = log_de_procesos_sgpa(5, 57, 0, $sel_contrato_modulo_contratos[0], 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Error", "Al intentar cargar la plantilla ocurrio un error que se le reporto al usuario" , "" ,1);
			log_agrega_detalle ($id_log, "Descripcion del Error", "¡ATENCION! La plantilla que intenta subir tiene ¡ERRORES!: ".$err_m , "" ,2);
			exit(); } 
				
}//		for errores

echo "aqui";
/******VALIDA ERRORES**********************/
/******VALIDA ERRORES**********************/			

		        $busca_tarifas = "select estado_contrato,gerente,t1_tipo_documento_id from v_tarifas_contratos where tarifas_contrato_id = $id_contrato_arr";
				$sql_busca_tarifas_gerente=traer_fila_row(query_db($busca_tarifas));
			
		if( ($sql_busca_tarifas_gerente[2]==2 ) && ($_POST["aprobacion_secundaria_0"]=="0") ){	
				?>
				<script>alert("Seleccione la persona que solicita la actualización ")</script>
			<? 
				exit(); 
				
				
		}	
			for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) { // RECORRE LAS FILAS
			
			$categoria=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][1]);
			$grupo=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][2]);
			$codigo_proveedor=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][3]);
			$detalle=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][4]);
			$unidad_medida=$data->sheets[0]['cells'][$i][5];
			$cantidad=$data->sheets[0]['cells'][$i][6];
			if($data->sheets[0]['cells'][$i][7]=="COP")
			$t1_moneda_id=1;
			elseif($data->sheets[0]['cells'][$i][7]=="USD")
			$t1_moneda_id=2;
			else $t1_moneda_id=1;
			$valor=$data->sheets[0]['cells'][$i][8];
			
			$us_id=$_SESSION["id_us_session"];
			$fecha_creacion=$fecha." ".$hora;
			$tipo_creacion=2;
			$t6_tarifas_estados_tarifas_id=10;
			$tipo_modificacion_normal_con = 3;
			
			$fecha_inicio_vigencia_1 = $data->sheets[0]['cells'][$i][9];
			$fecha_inicio_vigencia_valida = validar_fecha($fecha_inicio_vigencia_1);
			
			if($fecha_inicio_vigencia_1!="")			
				$fecha_inicio_vigencia=suma_dia_fecha_a(1,cambia_formato_fecha($data->sheets[0]['cells'][$i][9]));
			else
				$fecha_inicio_vigencia=$fecha;
			
				$detalle_descuento_pasa=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][10]);
			$detalle_observaciones=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][11]);
			
			$tarifa_padre=0;		
			$fecha_fin_vigencia="0000-00-00";															
			$t6_tarifas_listas_lista_id=$id_lista;															
								
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
			 $insert_fila.="$tarifa_padre, '$fecha_fin_vigencia', $t6_tarifas_listas_lista_id,$tipo_modificacion_normal_con,".$aprobacion_responsable.",2)";		
			$sql_ex=query_db($insert_fila.$trae_id_insrte);
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){	//si la tarifa se creo			
			
			$cambia_tarifa_padre = query_db("update $t3 set tarifa_padre = $id_ingreso where t6_tarifas_lista_id = $id_ingreso");
			
				$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $id_lista and estado = 1");
					$incrementa_colu=12;
					while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
					$inserta_atributos = "insert into $t14 (t6_tarifas_lista_id, t6_tarifas_atributos_id, detalle) values (";
					$inserta_atributos.="$id_ingreso,$lista_atr[0], '".$data->sheets[0]['cells'][$i][$incrementa_colu]."')";
					$sql_ex=query_db($inserta_atributos);
					
					$incrementa_colu++;
					} //lista atributos	
					
					$inserta_aprobacion_secu = "insert into t6_tarifas_aprobadores_secundarios (t6_tarifas_lista_id, us_id, tipo_aprobacion_copia,tarifas_contrato_id, notificado)
			 values ($id_ingreso,".$aprobacion_responsable.",1,$id_contrato_arr,1)";
			 $graba_aprobador_secundario=query_db($inserta_aprobacion_secu);
					
					if($detalle_descuento_pasa=="SI") $detalle_descuento_pasa_graba = 1;
			else  $detalle_descuento_pasa_graba = 2;
			 $cambia_soporte = "insert into t6_tarifas_anexos_modifica_tarifas (t6_tarifas_lista_id,observaciones , anexo,descuento) values (
									$id_ingreso,'".$detalle_observaciones."', '',".$detalle_descuento_pasa_graba.")";
									$sql_cambi_so=query_db($cambia_soporte.$trae_id_insrte);
									
									$id_ingreso_soporte = id_insert($sql_cambi_so);
			
			}//si la tarifa se creo			
			
			}// RECORRE LAS FILAS

				$id_log = log_de_procesos_sgpa(5, 58, 0, $sel_contrato_modulo_contratos[0], 0, 0);//agrega valores
			log_agrega_detalle ($id_log, "Quien solicita crear la tarifa", $_POST["aprobacion_secundaria_0"] , $g1 ,1);
			$sel_cuantas_tarifas = traer_fila_row(query_db("select count(*) from t6_tarifas_lista where tarifas_contrato_id = ".$id_contrato_arr." and fecha_creacion = '$fecha $hora'"));
			log_agrega_detalle ($id_log, "Numero de tarifas cargadas" , $sel_cuantas_tarifas[0], "" ,2);
					
			?>
					<script> 
                    alert("La plantilla se creó con éxito, favor continuar con el paso 3 para el cargue y envío de sus tarifas para aprobación de Hocol")
                    window.parent.ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_masivas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$id_lista;?>','carga_acciones_permitidas');
                    </script>
			<?
					
		}			


		

?>
<script>
window.parent.document.getElementById("cargando").style.display="none";
</script>
