<?

	function listas($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			$option="<option value='0'>Seleccione</option>";
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[0]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[0]."' ".$slecciona.">".$ls[$columna_trae]."</option>";
			}
			
			return $option;
		
		}
		
	function listas_mayus($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			$option="<option value='0'>Seleccione</option>";
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[0]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[0]."' ".$slecciona.">".strtoupper($ls[$columna_trae])."</option>";
			}
			
			return $option;
		
		}		
		

	function multilistas($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			global $t31;
			$sel = "select tp15_id, concat(nombre,'; ',direccion ) from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			$busca_sel= traer_fila_row(query_db("select * from $t31 where pro1_id = $seleccion and tp15_id = $ls[0]"));
			if($busca_sel[0]>=1)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[0]."' ".$slecciona.">".$ls[1]."</option>";
			}
			
			return $option;
		
		}
		
		
	function listas_afuera($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[0]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[$columna_trae]."' ".$slecciona.">".$ls[$columna_trae]."</option>";
			}
			
			return $option;
		
		}	
		
	function listas_afuera_evaluacion($tabla, $where,$seleccion,$orden, $columna_trae, $columna_muestra)
		{
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[2]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[$columna_trae]."' ".$slecciona.">".$ls[$columna_muestra]."</option>";
			}
			
			return $option;
		
		}			

		
		function listas_afuera_evaluacion_sin_select($tabla, $where,$seleccion,$orden, $columna_trae, $columna_muestra)
		{
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[2]==$seleccion)
				$option = $ls[$columna_muestra];
			
			}
			
			return $option;
		
		}				
	function listas_selecc_diferente_id($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[$columna_trae]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[$columna_trae]."' ".$slecciona.">".$ls[$columna_trae]."</option>";
			}
			
			return $option;
		
		}			
		
	function listas_sin_select($tabla,$where,$columna_trae)
		{
			
		$sel = "select * from ".$tabla;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[0]==$where)
				$option =$ls[$columna_trae];
			}

			return $option;
		
		}			
function nombre_archivo_adjunto($archivo){
		$archivo = str_replace(".","_", $archivo);
		$archivo = str_replace("#","_", $archivo);
		$archivo = str_replace("*","_", $archivo);
		$archivo = str_replace(",","_", $archivo);
		$archivo = str_replace(";","_", $archivo);
		return $archivo;
	}

function extencion_archivos($archivo)
	{
	
	$busca_archi = explode(".",$archivo);
	$cua = count($busca_archi);
	$extencion = $busca_archi[$cua-1]; 
	$largo = strlen($archivo);
	$comienzo = ($largo-3);
	$ext = substr($archivo, $comienzo , 3);
	
	return $extencion;
	}

function carga_archivo($archivo_sube,$ruta){
	$cont1=fread(fopen($archivo_sube,"r"),filesize($archivo_sube));
	$fichero=$archivo_sube;
	ob_start();
	$f1=fopen($fichero,"rb");
	fpassthru($f1);
	$cadena = ob_get_contents();
	ob_end_clean();
	$cd=~$cadena ;
	$f1=fopen(SUE_PATH_ARCHIVOS.$ruta.".txt","w");
	fwrite($f1,$cd);
	fclose($f1);
	}

function confirma_archivo($archivo_sube,$ruta){

$confirma = SUE_PATH_ARCHIVOS.$ruta;
$t_tem = filesize($confirma);
if($t_tem == $archivo_sube)
return 1;
else
return 2;

}

function elimina_archivo($ruta){
$f1=unlink(SUE_PATH_ARCHIVOS.$ruta);

}


function limpia_caracteres_url($texto){

		$forma_text = str_replace(chr(92), "", $texto); 
		return $forma_text;

}

function valida_fecha_vacia($fecha_envia)
	{
		if($fecha_envia=="0000-00-00 00:00:00")	{		$fecha_arreglada = "";			}
		else { 	$fecha_arreglada = $fecha_envia; }
		
	return $fecha_arreglada;
	
	
	}
	
function fecha_forsin_hora($fecha_enviada)
	{
		global $fecha, $hora;
		
			$fecha_arr = explode(" ",$fecha_enviada);
			$fecha_arregla = explode("-",$fecha_arr[0]);
				if($fecha_arregla[1]=='01')
					$mes_arre = "Ene";
				if($fecha_arregla[1]=='02')
					$mes_arre = "Feb";
				if($fecha_arregla[1]=='03')
					$mes_arre = "Mar";
				if($fecha_arregla[1]=='04')
					$mes_arre = "Abr";
				if($fecha_arregla[1]=='05')
					$mes_arre = "May";
				if($fecha_arregla[1]=='06')
					$mes_arre = "Jun";
				if($fecha_arregla[1]=='07')
					$mes_arre = "Jul";
				if($fecha_arregla[1]=='08')
					$mes_arre = "Ago";
				if($fecha_arregla[1]=='09')
					$mes_arre = "Sep";
				if($fecha_arregla[1]=='10')
					$mes_arre = "Oct";
				if($fecha_arregla[1]=='11')
					$mes_arre = "Nov";
				if($fecha_arregla[1]=='12')
					$mes_arre = "Dic";
					
					return $fecha_arregla[2]." ".$mes_arre." ".$fecha_arregla[0];
	
	}		

function eliminarDir($carpeta){ 
	
	foreach(glob($carpeta."/*") as $archivos_carpeta) {
	
	  if(is_dir($archivos_carpeta)) eliminarDir($archivos_carpeta); 
	  	else unlink($archivos_carpeta); } 
		
			rmdir($carpeta); 
		}



function fecha_for_sin_hora($fecha_enviada)
	{
		global $fecha, $hora;
		
			$fecha_arr = explode(" ",$fecha_enviada);
			$fecha_arregla = explode("-",$fecha_arr[0]);
				if($fecha_arregla[1]=='01')
					$mes_arre = "Ene";
				if($fecha_arregla[1]=='02')
					$mes_arre = "Feb";
				if($fecha_arregla[1]=='03')
					$mes_arre = "Mar";
				if($fecha_arregla[1]=='04')
					$mes_arre = "Abr";
				if($fecha_arregla[1]=='05')
					$mes_arre = "May";
				if($fecha_arregla[1]=='06')
					$mes_arre = "Jun";
				if($fecha_arregla[1]=='07')
					$mes_arre = "Jul";
				if($fecha_arregla[1]=='08')
					$mes_arre = "Ago";
				if($fecha_arregla[1]=='09')
					$mes_arre = "Sep";
				if($fecha_arregla[1]=='10')
					$mes_arre = "Oct";
				if($fecha_arregla[1]=='11')
					$mes_arre = "Nov";
				if($fecha_arregla[1]=='12')
					$mes_arre = "Dic";
					
					return $fecha_arregla[2]." ".$mes_arre." ".$fecha_arregla[0];
	
	}
function registro_email_enviado_nuevo($pro1_id, $email, $asunto_envio, $texto_envio,$enviado,$tipo,$modulo,$id_primario_otros_email){
global $fecha,$hora;

$arreglo_modulo_pv_id = explode("|",$id_primario_otros_email);
$pv_id_trae = $arreglo_modulo_pv_id[1]; //arreglo id proveedor
$sub_proceso = $arreglo_modulo_pv_id[0];//arreglo id sub proceso carteleras
$cuenta_arr = count($arreglo_modulo_pv_id);
if($cuenta_arr>=2)
	{
		$var1=$pv_id_trae;
		$var2=$sub_proceso;
		
		}
	else{
		$var1=$id_primario_otros_email;
		$var2=0;
		
		}
		

 $inserta_data = "insert into pro34_registro_correos (us_id, fecha_envio, pro1_id, id_primario_otros_email, id_secundario_otros_email,
 email_envio, asunto_envio, texto_envio, enviado,tipo_envio,tp17_id) values (
".$_SESSION["id_us_session"].",'$fecha $hora', $pro1_id, $var1,$var2,'$email','$asunto_envio','$texto_envio','$enviado',$tipo,$modulo) ";

$in_mail = query_db($inserta_data);


}

function consecutivo_automatico_sondeo(){//funcion crear_cinsecutivo
global $requiere_consecutivo_automatico, $formato_consecutivo_automatico,$t5,$separador_consecutivo_automatico;
//echo "select consecutivo from $t5 where tp2_id = 2 and cd_id_entrega_documentos =0 order by pro1_id desc";
$busca_consecutivo=traer_fila_row(query_db("select consecutivo from $t5 where tp2_id = 30 and cd_id_entrega_documentos =0 and origen_duplicidad = 0 order by pro1_id desc"));
$ultimo_conse_arr = explode("-",$busca_consecutivo[0]);//eltimo consecutivo
$ano_consecutivo = substr(date("Y"), 2, 2);//ultimos digitos del año
//$ultimo_conse_arr[0];
//echo $ultimo_conse_arr[0];

if($ultimo_conse_arr[0]=="Sondeo".$ano_consecutivo){
$numero_cons = $ultimo_conse_arr[1]; //nuemro texto consecutivo ej 0001
$convertir_cumero = ($numero_cons*1 );//convertor en numero
$largo_consecu = strlen($convertir_cumero);//largo del consecutivo convertido en numero
$arreglo_string_con = str_repeat(0,(4-$largo_consecu)); // llena de ceros a la izaquierda
$incrementa_consectivo = ($convertir_cumero+1);
$ultimo_conse =$arreglo_string_con_fin = "Sondeo".$ano_consecutivo."-".$arreglo_string_con.$incrementa_consectivo; // arma consecutivo "SO".date("Y")."-".($ultimo_conse_arr[2]+1);
}
else
$ultimo_conse = "Sondeo".$ano_consecutivo."-0001";


return $ultimo_conse;
}//funcion crear_cinsecutivo

function consecutivo_automatico_compra_crudo(){//funcion crear_cinsecutivo
global $requiere_consecutivo_automatico, $formato_consecutivo_automatico,$t5,$separador_consecutivo_automatico;
//echo "select consecutivo from $t5 where tp2_id = 2 and cd_id_entrega_documentos =0 order by pro1_id desc";
$busca_consecutivo=traer_fila_row(query_db("select consecutivo from $t5 where tp2_id = 31 and cd_id_entrega_documentos =0 order by pro1_id desc"));
$ultimo_conse_arr = explode("-",$busca_consecutivo[0]);//eltimo consecutivo
$ano_consecutivo = substr(date("Y"), 2, 2);//ultimos digitos del año
//$ultimo_conse_arr[0];
//echo $ultimo_conse_arr[0];

if($ultimo_conse_arr[0]=="CRUD".$ano_consecutivo){
$numero_cons = $ultimo_conse_arr[1]; //nuemro texto consecutivo ej 0001
$convertir_cumero = ($numero_cons*1 );//convertor en numero
$largo_consecu = strlen($convertir_cumero);//largo del consecutivo convertido en numero
$arreglo_string_con = str_repeat(0,(4-$largo_consecu)); // llena de ceros a la izaquierda
$incrementa_consectivo = ($convertir_cumero+1);
$ultimo_conse =$arreglo_string_con_fin = "CRUD".$ano_consecutivo."-".$arreglo_string_con.$incrementa_consectivo; // arma consecutivo "SO".date("Y")."-".($ultimo_conse_arr[2]+1);
}
else
$ultimo_conse = "CRUD".$ano_consecutivo."-0001";


return $ultimo_conse;
}//funcion crear_cinsecutivo
	
	
	
	function llena_lista_sondeos()
		{
			
			$campo = '<input name="llena_lista_sondeos_l" type="text" id="llena_lista_sondeos_l" size="50" onkeypress="selecciona_lista()" />';
			
			
			}
	
		
?>