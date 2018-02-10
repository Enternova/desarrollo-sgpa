<?  include("../lib/@session.php");
	
	verifica_menu("administracion.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php
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
		elseif( ($aparicones_coma>=1) && ($aparicones_puntos>=1)  )	
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
		if($numero_bie!="0.00000")
			$erro_nu = 1;	
		else
			$erro_nu = 2;	

     return $erro_nu;
	 
	
}  
   
   $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//recibe id	
	if($_POST["accion"]=="cargue_masivo_tarifas")
		{

		$extencion = extencion_archivos($_FILES["carga_tarifas"]["name"]);
		if($extencion!="xls")
			{
			 ?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El archivo que inteta subir debe ser con formato Excel 97 - 2003', 20, 10, 18);	
				//alert("Atencion: El archivo que inteta subir debe ser con formato Excel 97 - 2003 ")</script>
			<? 
				exit(); 
			} 

$sel_id_contrato_modulo = traer_fila_row(query_db("select t1.fecha_inicio from t7_contratos_contrato as t1, t6_tarifas_contratos as t2 where t1.id = t2.id_contrato and t2.tarifas_contrato_id =".$id_contrato_arr));

			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1252');
			$data->read($_FILES["carga_tarifas"]["tmp_name"]);

/******VALIDA ERRORES**********************/
/******VALIDA ERRORES**********************/
$err_m = "";
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { // RECORRE LAS FILAS
			
			$detalle=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][4]);
			if($detalle=="")
				$err_m = "* El detalle de la fila ".$i." no tiene contenido";
			
			$unidad_medida=$data->sheets[0]['cells'][$i][5];
			if($unidad_medida=="")
				$err_m = "* La unidad de medida de la fila ".$i." no tiene contenido";	
				
			$codigo_proveedor_valida=elimina_comillas_carge_2($data->sheets[0]['cells'][$i][3]);
			if($codigo_proveedor_valida=="")
				$err_m = "* El ".TITULO_alertas." de la fila ".$i." no tiene contenido";				

			if($data->sheets[0]['cells'][$i][7]=="COP")
			$t1_moneda_id=1;
			elseif($data->sheets[0]['cells'][$i][7]=="USD")
			$t1_moneda_id=2;
			else {
				$err_m = "* El formato de moneda de la fila ".$i." esta errado";			
			}
			
			$columna_valor_nuevo = $data->sheets[0]['cells'][$i][8];

			$valor=numerico($data->sheets[0]['cells'][$i][8]);
			if($valor==2)
				$err_m = "* El valor de la fila ".$i." esta errado  * El valor no puede cero. * El valor no debe llevar formatos numero * El valor no debe llevar formatos de moneda";
			
			$columna_valor_nuevo = $data->sheets[0]['cells'][$i][8];
				$valida_formato_tarifa = valida_valor_tarifa($columna_valor_nuevo);
			if($valida_formato_tarifa==2)
				$err_m="* El formato de la fila ".$i."   valor es incorrecto ";	
			
			$valida_valor = number_format($columna_valor_nuevo,5);
			if($valida_valor==0)
				$err_m="* El formato de la fila ".$i."  valor es incorrecto No debe contener formatos ni texto";	
			
			$fecha_fin_vigencia_1 = $data->sheets[0]['cells'][$i][9];
			$fecha_fin_vigencia_valida = validar_fecha($fecha_fin_vigencia_1);

			
			
			if($fecha_fin_vigencia_1!=""){ //si la fecha esta llena
				if($fecha_fin_vigencia_valida==2)
					$err_m = "* La fecha fin de vigencia de la fila ".$i." esta errada el formato debe ser dd/mm/yyyy ";
				else
					{
								$fecha_inicio_vigencia_para_valida=$sel_id_contrato_modulo[0];
									$fecha_fin_vigencia_1_para_validar=suma_dia_fecha_a(0,cambia_formato_fecha($data->sheets[0]['cells'][$i][9]));
								if( $fecha_fin_vigencia_1_para_validar < $fecha_inicio_vigencia_para_valida)
									$err_m = "* La fecha fin de vigencia de la fila ".$i." no puede ser menor al la fecha de inicio ";	

						}
				
				}//si la fecha esta llena
			
			/*FECHA INICIO VIGENCIA
			$fecha_inicio_vigencia_1 = $data->sheets[0]['cells'][$i][9];
			$fecha_inicio_vigencia_valida = validar_fecha($fecha_inicio_vigencia_1);
			
			if($fecha_inicio_vigencia_1!=""){ //si la fecha esta llena
	
				
			if($fecha_inicio_vigencia_valida==2){
				
				$err_m = " La fecha de la fila ".$i." esta errada el formato debe ser dd/mm/yyyy ";
			}
				
				}//si la fecha esta llena
				*/
				
		
		if($err_m !="")
			{ ?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: <?=$err_m;?>', 60, 5, 10)	
			//alert("Atencion: <?=$err_m;?>")</script>
			
			<? exit(); } 
				
}//		for errores

echo "aqui";
/******VALIDA ERRORES**********************/
/******VALIDA ERRORES**********************/			

	$busca_consecutivo = "select consecutivo_tarifa from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr order by consecutivo_tarifa desc  ";
$sql_busca_consecutivo = traer_fila_row(query_db($busca_consecutivo));
$serial_consecutivo =($sql_busca_consecutivo[0] + 1);	
			
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { // RECORRE LAS FILAS
			
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
			$tipo_creacion=1;
			$t6_tarifas_estados_tarifas_id=1;
			
			
			
			$fecha_inicio_vigencia=$sel_id_contrato_modulo[0];
			/*
			$fecha_inicio_vigencia_1 = $data->sheets[0]['cells'][$i][9];
			$fecha_inicio_vigencia_valida = validar_fecha($fecha_inicio_vigencia_1);
			if($fecha_inicio_vigencia_1!="")			
				$fecha_inicio_vigencia=suma_dia_fecha_a(1,cambia_formato_fecha($data->sheets[0]['cells'][$i][9]));
			else
				$fecha_inicio_vigencia=$fecha;
			*/
			$tarifa_padre=0;		
			$fecha_final_vigencia_1 = $data->sheets[0]['cells'][$i][9];
			if($fecha_final_vigencia_1!="")			
				$fecha_fin_vigencia=suma_dia_fecha_a(0,cambia_formato_fecha($data->sheets[0]['cells'][$i][9]));
			else
				$fecha_fin_vigencia="0000-00-00";
																		
			$t6_tarifas_listas_lista_id=$id_lista;															
																					
			
			$insert_fila = "insert into $t3 (tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, ";
			$insert_fila.="t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia, ";
			$insert_fila.="tarifa_padre, fecha_fin_vigencia, t6_tarifas_listas_lista_id,tipo_creacion_modifica,us_aprobacion_actual, creada_luego_firme, consecutivo_tarifa) values(";			
			$insert_fila.="$id_contrato_arr,'$categoria', '$grupo', '$codigo_proveedor', '$detalle', '$unidad_medida', '$cantidad',  ";
			$insert_fila.="$t1_moneda_id, '$valor', $us_id, '$fecha_creacion', $tipo_creacion, $t6_tarifas_estados_tarifas_id, '$fecha_inicio_vigencia', ";			
			 $insert_fila.="$tarifa_padre, '$fecha_fin_vigencia', $t6_tarifas_listas_lista_id,1,0,1,$serial_consecutivo)";		
			$sql_ex=query_db($insert_fila.$trae_id_insrte);
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){	//si la tarifa se creo			
			
			$serial_consecutivo++;
			
			$cambia_tarifa_padre = query_db("update $t3 set tarifa_padre = $id_ingreso where t6_tarifas_lista_id = $id_ingreso");
			
				$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $id_lista and estado = 1");
					$incrementa_colu=9;
					while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
					$inserta_atributos = "insert into $t14 (t6_tarifas_lista_id, t6_tarifas_atributos_id, detalle) values (";
					$inserta_atributos.="$id_ingreso,$lista_atr[0], '".$data->sheets[0]['cells'][$i][$incrementa_colu]."')";
					$sql_ex=query_db($inserta_atributos);
					
					$incrementa_colu++;
					} //lista atributos	
			
			}//si la tarifa se creo			
			
			}// RECORRE LAS FILAS
			$busca_tarifas = "select t6_tarifas_estados_contratos_id from $t4 where tarifas_contrato_id = $id_contrato_arr";
			$sql_busca_tarifas=traer_fila_row(mssql_query($busca_tarifas));
			
			if($sql_busca_tarifas[0]==6)
				$stado_contrato_exp = 6;
			else
				$stado_contrato_exp = 2;				
				

			$updat = query_db("update $t4 set t6_tarifas_estados_contratos_id = $stado_contrato_exp where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_contratos_id <> 3");

					
			?>
					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    window.parent.ajax_carga('../aplicaciones/tarifas/c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=<?=$id_lista;?>','carga_acciones_permitidas');
                    </script>
			<?
					
		}			


	if($_POST["accion"]=="crea_relacion_uno_umo")
		{
			echo $tarifa_seleccionada;
		
			if($_POST["tarifa_maestra_uni_".$tarifa_seleccionada]!=""){
			$tarifa_maestra_arrgle = explode("----,",$_POST["tarifa_maestra_uni_".$tarifa_seleccionada]);
			$tarifa_maestra_id = $tarifa_maestra_arrgle[1];
				}

			elseif($_POST["busca_tarifas_maestras_p"]!=""){
			$tarifa_maestra_arrgle = explode("----,",$busca_tarifas_maestras_p);
			$tarifa_maestra_id = $tarifa_maestra_arrgle[1];
				}
			else
			$tarifa_maestra_id = 0;
			
			$inserta_ta = "insert into $t11 (t6_tarifas_maestras_lista_id, t6_tarifas_lista_padre_id, estado_relacion, us_id_relacion, fecha_relacion)";
			echo  $inserta_ta.=" values ($tarifa_maestra_id,$tarifa_seleccionada, 2,".$_SESSION["id_us_session"].", '$fecha $hora')";
			$in= query_db($inserta_ta);
			
		}

	if($_POST["accion"]=="elimina_relacion_uno_umo")
		{
		 $busca_relaciones = traer_fila_row(query_db("select * from $t11 where t6_tarifas_lista_padre_id = $tarifa_seleccionada order by t6_tarifas_maestras_relacion_tarifas_id desc")); 
		 if($busca_relaciones[3]==1)
			{
				$inserta_ta = query_db("update $t11 set estado_relacion= 3 where us_id_relacion = ".$_SESSION["id_us_session"]." and t6_tarifas_lista_padre_id = $tarifa_seleccionada");
			?>
 					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La relación se eliminó temporalmente hasta que usted la confirme', 20, 10, 18);
                    //alert("El relación se eliminó temporalmente hasta que usted la confirme")
                    window.parent.busqueda_paginador_nuevo(window.parent.document.principal.pagina.value,'../aplicaciones/tarifas/tarifas_maestras/relacion_tarifas_maestras.php','contenidos');
                    </script>
            
            <?
			
			}
			else{
			echo $inserta_ta = "delete from $t11 where t6_tarifas_lista_padre_id = $tarifa_seleccionada";
			$in= query_db($inserta_ta);
			}
			
		}

	if($_POST["accion"]=="confirmar_tarifas_relacion")
		{
			
			$inserta_ta = "delete from $t11 where us_id_relacion = ".$_SESSION["id_us_session"]." and estado_relacion = 3";
			$in= query_db($inserta_ta);

			$inserta_ta = "update $t11 set estado_relacion= 1 where us_id_relacion = ".$_SESSION["id_us_session"]." and estado_relacion = 2 and t6_tarifas_maestras_lista_id <> 0";
			$in= query_db($inserta_ta);
			
			?>
 					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    window.parent.busqueda_paginador_nuevo(window.parent.document.principal.pagina.value,'../aplicaciones/tarifas/tarifas_maestras/relacion_tarifas_maestras.php','contenidos');
                    </script>
            
            <?
			
		}
		

	if($_POST["accion"]=="borra_historico_tarifas")
		{
			
			$inserta_ta = "delete from $t11 where us_id_relacion = ".$_SESSION["id_us_session"]." and estado_relacion = 2";
			$in= query_db($inserta_ta);
			
			?>
 					<script>
					window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
                    //alert("El proceso se creó con éxito")
                    window.parent.busqueda_paginador_nuevo(window.parent.document.principal.pagina.value,'../aplicaciones/tarifas/tarifas_maestras/relacion_tarifas_maestras.php','contenidos');
                    </script>
            
            <?
			
		}		

?>
<script>
window.parent.document.getElementById("cargando").style.display="none";
</script>
