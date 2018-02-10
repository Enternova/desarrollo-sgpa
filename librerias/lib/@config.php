<?	error_reporting("E_ERROR");
	define("TITULO",".::SGPA HOCOL SA - V1");
	define("SUE_PATH", "C:/app_sgpa/sistem_calidad_2018/");
	$fecha = date("Y-m-d");
	//$fecha = $_SESSION["fecha"];
	$hora = date("H:i:s");
	
  define("TITULO_CONSECUTIVO","Consecutivo");

   define("TITULO_1","Origen");   
   define("TITULO_2","Categor&iacute;a");   
   define("TITULO_3","Grupo");   
   define("TITULO_4","Unidad");   
   define("TITULO_5","&Iacute;tem Oferta Proveedor");  
   define("TITULO_alertas","Item Oferta Proveedor");   
   define("TITULO_5b","(Este campo  es obligatorio) N&uacute;mero de referencia (no ingresar descripci&oacute;n, solo n&uacute;meros y/o letras) max 25 caracteres.");   
   define("TITULO_6","Nombre gen&eacute;rico");   
   define("TITULO_7","Moneda");   
   define("TITULO_8","Valor tarifa");                        
   define("TITULO_9","Inicio vigencia");                        
   define("TITULO_10","Modificada");                              
   define("TITULO_11","Atributos");    
   define("TITULO_12","Estado");    
   define("TITULO_13","Cuantas Veces Usada");    
   define("TITULO_14","Concepto");    
   define("TITULO_15","Ver aprobaciones");     
   define("TITULO_16","Fecha de Creaci&oacute;n");    
   define("TITULO_17","Usuario de Creaci&oacute;n");  
   define("TITULO_18","Fin vigencia");     
   
   define("alinea_CONSECUTIVO","center");
   define("ayuda_CONSECUTIVO","NOTA: si require buscar varios consecutivos, digitelos separandolos con una coma (,) EJ: 1,2,3");
   
   	$formato_numeros_miles = ",";
	$formato_numeros_decimales = ".";
$cantidad_decimales=5;
$cantidad_decimales_resto=2;
$stilo_excel = "mso-number-format:'#,##0.00000';";

function decimales_estandar($valor,$tipo)
	{
		global    	$formato_numeros_miles, $formato_numeros_decimales,$cantidad_decimales,$cantidad_decimales_resto;
		
		$arrglo_decimales = number_format($valor,5,$formato_numeros_miles, $formato_numeros_decimales);
		
		
		
		$arrglo_decimales_2 = explode(",",$arrglo_decimales);
		$miles_arrglo = $arrglo_decimales_2[0];
		$decimales_arrg_1 = $arrglo_decimales_2[1];
		$extrae_decimales = substr($decimales_arrg_1,0,$cantidad_decimales_resto);
		
		$decimales_arrg = $extrae_decimales;
		
		$valida_decimales = ($decimales_arrg*1);
			if($valida_decimales>=1)
				return $union_decimales = $miles_arrglo.", ".$decimales_arrg;
			else{
				return $union_decimales = $miles_arrglo.", ".$decimales_arrg;
				//return $union_decimales = $miles_arrglo;
			}
		
	
		}

function decimales_estilo($valor,$tipo)
	{
		global    	$formato_numeros_miles, $formato_numeros_decimales,$cantidad_decimales;
		
		$arrglo_decimales = number_format(($valor),$cantidad_decimales,$formato_numeros_miles, $formato_numeros_decimales);
		$arrglo_decimales_2 = explode(",",$arrglo_decimales);
		$miles_arrglo = $arrglo_decimales_2[0];
		if($tipo==1) $stilo = "decimales_finales";
		if($tipo==2) $stilo = "decimales_finales_peq";		
		
		
		$decimales_arrg = $arrglo_decimales_2[1];
		$valida_decimales = ($decimales_arrg*1);
			if($valida_decimales>=1)
				return $union_decimales = $miles_arrglo.", ".$decimales_arrg;
			else{
				return $union_decimales = $miles_arrglo.", ".$decimales_arrg;
				//return $union_decimales = $miles_arrglo;
			}
		//return $arrglo_decimales;
		
		}

function decimales_estilo_exporta($valor,$tipo)
	{
		global    	$formato_numeros_miles, $formato_numeros_decimales,$cantidad_decimales;
		 $arrglo_decimales = number_format(($valor),$cantidad_decimales);
		$arrglo_decimales_2 = explode(".",$arrglo_decimales);
		$miles_arrglo = $arrglo_decimales_2[0];
		$miles_arrglo = str_replace(',', '.', $miles_arrglo);
		if($tipo==1) $stilo = "decimales_finales";
		if($tipo==2) $stilo = "decimales_finales_peq";		
		
		
		$decimales_arrg = '<span class="'.$stilo.'">'.$arrglo_decimales_2[1].'</span>';
		
		return $union_decimales = $miles_arrglo.",".$decimales_arrg;
		
		}
		
function creacion_consecutvos_tarifas($id_contrato_arr)
	{
		$busca_consecutivo = "select consecutivo_tarifa from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr order by consecutivo_tarifa desc  ";
			$sql_busca_consecutivo = traer_fila_row(query_db($busca_consecutivo));
			$serial_consecutivo = ($sql_busca_consecutivo[0]+1);
			
			return $serial_consecutivo;
		}		

?>