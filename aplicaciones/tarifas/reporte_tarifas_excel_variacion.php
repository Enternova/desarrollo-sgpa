<?  header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de tarifas.xls"); 
	header("Content-Transfer-Encoding: binary");


//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
	if($id_contrato_arr=="")
		$id_contrato_arr=0;

$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));	
		
	/*$id_log = log_de_procesos_sgpa(6, 42, 60, $id_contrato_arr, 0, 0);//actualiza general
		log_agrega_detalle ($id_log, "Visualiza tarifas del contrato ".$sql_con[7], "", "",1);*/
		
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
		
//$stilo_excel= "mso-number-format:'#.##0,00000'";
		
		function valor_imprime_excel_con_desc($valor){
				  global $formato_numeros_miles;
					 $valor_unido_func=0;
					$valor_arr = explode(".",$valor);
					$unidades =$valor_arr[0];
					$decimales =  $valor_arr[1];
					$valor_unido_func = $unidades.$formato_numeros_miles.$decimales;
					return $valor_unido_func;
				  }
		function formato_fecha($fecha_fun){
				 if($fecha_fun =="0000-00-00"){
					 $fecha_fun="";
					 }
					return $fecha_fun;
				  }
function sel_tipo_modifica($tipo_modifica){
				  $tipo_modifica_nombre="";
				  if($tipo_modifica==1){ $tipo_modifica_nombre="Contractual";
				  }elseif($tipo_modifica==2){ $tipo_modifica_nombre="Actualizada";
				  }elseif($tipo_modifica==3){ $tipo_modifica_nombre="Creacion";
				  }elseif($tipo_modifica==4){$tipo_modifica_nombre="IPC";
				  }elseif($tipo_modifica==5){$tipo_modifica_nombre="Convencion";}
				  return $tipo_modifica_nombre;
				  }		
		function ultima_aprobacion($id_tarifa){
			$sel_aprobacion = traer_Fila_row(query_db("select max(fecha_aprobacion) from t6_tarifas_aprobaciones where t6_tarifas_lista_id = ".$id_tarifa." and t6_tarifas_estados_tarifas_id = 1"));
			return $sel_aprobacion[0];
			}
			
		function indicador_variacion($fecha_inico_vigencia0, $moneda0, $valor_indicador0, $fecha_inico_vigencia1, $moneda1, $valor_indicador1){
			$resultado = "";
			$porcentaje_variacion = 0;
			$valor_variacion = 0;
			
			
			if($moneda0 != $moneda1){
				$resultado = "Cambio de Moneda*0*0";
				}else if($valor_indicador0 != $valor_indicador1){
				
				if($valor_indicador0 > $valor_indicador1){
					$valor_variacion=$valor_indicador0 - $valor_indicador1;
				$porcentaje_variacion=number_format(($valor_variacion / $valor_indicador0)*100,2,",",",");
					$resultado = "<strong><font color='#4A9B1C'>Bajo</font></strong>*<strong><font color='#4A9B1C'>".$porcentaje_variacion."%</font></strong>*<strong><font color='#4A9B1C'>".$valor_variacion."*</font></strong>";
				}else{
					$valor_variacion=$valor_indicador1 - $valor_indicador0;
					
				 	$porcentaje_variacion=number_format(($valor_variacion / $valor_indicador0)*100,2,",",",");

					$resultado = "<strong><font color='#F83309'>Subio</font></strong>*<strong><font color='#F83309'>".$porcentaje_variacion."%</font></strong>*<strong><font color='#F83309'>".$valor_variacion."*</font></strong>";
					}
				
				}else{
					$resultado = "Se Mantuvo*0*0";
					}
			
//			$resultado = $fecha_inico_vigencia0." - ".$moneda0." - ".$valor_indicador0." - ".$fecha_inico_vigencia1." - ".$moneda1." - ".$valor_indicador1;
			return $resultado;
			}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
.titulo1 {
	font-size:24px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}

.titulo4 {
	font-size:20px;
	background-color:#95E77D;
	color:#FFF;
		
}

.titulo5 {
	font-size:20px;
	background-color:#0F6;
	color:#FFF;
		
}


</style>
</head>

<body>
<?

	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
									while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
									$titulos_atributos.="<td class='titulo3'>".valida_espacio_lista($lista_atr[4])."</td>";
								
									} //lista atributos
?>

<table border=1  width="100%" >
  <tr >
    <td height="34" colspan="14" align="center"><font color="#135798"><strong><?=$sql_con[7]?>-Lista de las tarifas contractuales y creadas como nuevas tarifas (Tarifas originales)</strong></font></td>
    <td colspan="11" align="center"  class="titulo4">Modificaci&oacute;n 1</td>
    <td colspan="11" align="center"  class="titulo5">Modificaci&oacute;n 2</td>
    <td colspan="11" align="center"  class="titulo4">Modificaci&oacute;n 3</td>
    <td colspan="11" align="center"  class="titulo5">Modificaci&oacute;n 4</td>
    <td colspan="11" align="center"  class="titulo4">Modificaci&oacute;n 5</td>
    <td colspan="11" align="center"  class="titulo5">Modificaci&oacute;n 6</td>
    <td colspan="11" align="center"  class="titulo4">Modificaci&oacute;n 7</td>
    <td colspan="11" align="center"  class="titulo5">Modificaci&oacute;n 8</td>
    <td colspan="11" align="center"  class="titulo4">Modificaci&oacute;n 9</td>
    <td colspan="11" align="center"  class="titulo5">Modificaci&oacute;n 10</td>
    <td colspan="11" align="center"  class="titulo4">Modificaci&oacute;n 11</td>
    <td colspan="11" align="center"  class="titulo5">Modificaci&oacute;n 12</td>
  </tr>
  <tr >
  <td width="2%" height="66" align="center" class="titulo3"><strong><?=TITULO_CONSECUTIVO;?></strong></td>
	<td width="2%" align="center" class="titulo3"><strong><?=TITULO_2;?></strong></td>
	<td width="3%" align="center" class="titulo3"><strong><?=TITULO_3;?></strong></td>
	<td width="2%" align="center" class="titulo3" ><strong><?=TITULO_4;?></strong></td>
	<td width="2%" align="center" class="titulo3" ><strong><?=TITULO_5;?></strong></td>
	<td width="21%" align="center" class="titulo3"><strong><?=TITULO_6;?></strong></td>
    <td width="2%" align="center" class="titulo3"><strong><?=TITULO_7;?></strong></td>
    <td width="3%" align="center" class="titulo3"><strong><?=TITULO_8;?></strong></td>
    <td width="5%" align="center"  class="titulo3"><strong><?=TITULO_9;?></strong></td>
    <td width="2%" align="center"  class="titulo3"><strong><?=TITULO_18;?></strong></td>
    <td width="2%" align="center"  class="titulo3"><strong><?=TITULO_16;?></strong></td>
    <td width="2%" align="center"  class="titulo3"><strong><?=TITULO_17;?></strong></td>
    <td width="3%" align="center"  class="titulo3">Estado</td>
    <td width="3%" align="center"  class="titulo3">Modificada</td>
    <td align="center"  class="titulo4">Consecutivo</td>
    <td align="center"  class="titulo4">Concepto de la Modificaci&oacute;n</td>
    <td align="center"  class="titulo4">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo4">Inicio Vigencia</td>
    <td align="center"  class="titulo4">Fin Vigencia</td>
    <td align="center"  class="titulo4">Moneda</td>
    <td align="center"  class="titulo4">Valor Tarifa</td>
    <td align="center"  class="titulo4">Estado</td>
    <td align="center"  class="titulo4">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Consecutivo</td>
    <td align="center"  class="titulo5">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo5">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo5">Inicio Vigencia</td>
    <td align="center"  class="titulo5">Fin Vigencia</td>
    <td align="center"  class="titulo5">Moneda</td>
    <td align="center"  class="titulo5">Valor Tarifa</td>
    <td align="center"  class="titulo5">Estado</td>
    <td align="center"  class="titulo5">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Consecutivo</td>
    <td align="center"  class="titulo4">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo4">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo4">Inicio Vigencia</td>
    <td align="center"  class="titulo4">Fin Vigencia</td>
    <td align="center"  class="titulo4">Moneda</td>
    <td align="center"  class="titulo4">Valor Tarifa</td>
    <td align="center"  class="titulo4">Estado</td>
    <td align="center"  class="titulo4">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Consecutivo</td>
    <td align="center"  class="titulo5">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo5">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo5">Inicio Vigencia</td>
    <td align="center"  class="titulo5">Fin Vigencia</td>
    <td align="center"  class="titulo5">Moneda</td>
    <td align="center"  class="titulo5">Valor Tarifa</td>
    <td align="center"  class="titulo5">Estado</td>
    <td align="center"  class="titulo5">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Consecutivo</td>
    <td align="center"  class="titulo4">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo4">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo4">Inicio Vigencia</td>
    <td align="center"  class="titulo4">Fin Vigencia</td>
    <td align="center"  class="titulo4">Moneda</td>
    <td align="center"  class="titulo4">Valor Tarifa</td>
    <td align="center"  class="titulo4">Estado</td>
    <td align="center"  class="titulo4">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Consecutivo</td>
    <td align="center"  class="titulo5">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo5">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo5">Inicio Vigencia</td>
    <td align="center"  class="titulo5">Fin Vigencia</td>
    <td align="center"  class="titulo5">Moneda</td>
    <td align="center"  class="titulo5">Valor Tarifa</td>
    <td align="center"  class="titulo5">Estado</td>
    <td align="center"  class="titulo5">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Consecutivo</td>
    <td align="center"  class="titulo4">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo4">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo4">Inicio Vigencia</td>
    <td align="center"  class="titulo4">Fin Vigencia</td>
    <td align="center"  class="titulo4">Moneda</td>
    <td align="center"  class="titulo4">Valor Tarifa</td>
    <td align="center"  class="titulo4">Estado</td>
    <td align="center"  class="titulo4">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Consecutivo</td>
    <td align="center"  class="titulo5">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo5">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo5">Inicio Vigencia</td>
    <td align="center"  class="titulo5">Fin Vigencia</td>
    <td align="center"  class="titulo5">Moneda</td>
    <td align="center"  class="titulo5">Valor Tarifa</td>
    <td align="center"  class="titulo5">Estado</td>
    <td align="center"  class="titulo5">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Consecutivo</td>
    <td align="center"  class="titulo4">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo4">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo4">Inicio Vigencia</td>
    <td align="center"  class="titulo4">Fin Vigencia</td>
    <td align="center"  class="titulo4">Moneda</td>
    <td align="center"  class="titulo4">Valor Tarifa</td>
    <td align="center"  class="titulo4">Estado</td>
    <td align="center"  class="titulo4">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Consecutivo</td>
    <td align="center"  class="titulo5">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo5">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo5">Inicio Vigencia</td>
    <td align="center"  class="titulo5">Fin Vigencia</td>
    <td align="center"  class="titulo5">Moneda</td>
    <td align="center"  class="titulo5">Valor Tarifa</td>
    <td align="center"  class="titulo5">Estado</td>
    <td align="center"  class="titulo5">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Consecutivo</td>
    <td align="center"  class="titulo4">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo4">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo4">Inicio Vigencia</td>
    <td align="center"  class="titulo4">Fin Vigencia</td>
    <td align="center"  class="titulo4">Moneda</td>
    <td align="center"  class="titulo4">Valor Tarifa</td>
    <td align="center"  class="titulo4">Estado</td>
    <td align="center"  class="titulo4">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo4">Valor de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Consecutivo</td>
    <td align="center"  class="titulo5">Concepto de la modificaci&oacute;n</td>
    <td align="center"  class="titulo5">Fecha de Aprobaci&oacute;n</td>
    <td align="center"  class="titulo5">Inicio Vigencia</td>
    <td align="center"  class="titulo5">Fin Vigencia</td>
    <td align="center"  class="titulo5">Moneda</td>
    <td align="center"  class="titulo5">Valor Tarifa</td>
    <td align="center"  class="titulo5">Estado</td>
    <td align="center"  class="titulo5">Indicador de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Porcentaje de Variaci&oacute;n</td>
    <td align="center"  class="titulo5">Valor de Variaci&oacute;n</td>
    <?=$titulos_atributos;?>
  </tr>
<?

 if( ($categoria_existentes!="no_apli_b") && ($categoria_existentes!="") )
	  	$bus_tarifa_c.= " and categoria = '".elimina_comillas_2($categoria_existentes)."' ";

	  if( ($grupo_existentes!="no_apli_b") && ($grupo_existentes!="") )
	  	$bus_tarifa_c.= " and grupo = '".elimina_comillas_2($grupo_existentes)."' ";

	  if($detalle_ta_b!="")
	  	$bus_tarifa_c.= " and detalle like '%".elimina_comillas_2($detalle_ta_b)."%' ";

	  if($codigo_ta_b!="")
	  	$bus_tarifa_c.= " and codigo_proveedo like '%".elimina_comillas_2($codigo_ta_b)."%' ";
	  if($str_consecutivo_bus!="")
	  	$bus_tarifa_c.= " and consecutivo_tarifa in ($str_consecutivo_bus) ";		
	  
if($tipo_reporte == "h_variacion_tarifas"){	     

if($estado_busca == 0 or $estado_busca == ""){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1, 7) ";}//SI SELECCIONA VER TODAS
if($estado_busca == 1 ){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (2, 3) and (creada_luego_firme = 2 or creada_luego_firme is null) and t6_tarifas_listas_lista_id = $lista_existentes";}//SI SELECCIONA VER LAS PENDIENTES
if($estado_busca == 2){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1) and (creada_luego_firme = 2 or creada_luego_firme is null)  and (fecha_fin_vigencia >= '$fecha' or fecha_fin_vigencia = '0000-00-00' ) and t6_tarifas_listas_lista_id = $lista_existentes";}//SI SELECCIONA VER LAS APROBADAS
if($estado_busca == 3){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (4, 5, 6, 10) and (creada_luego_firme = 2 or creada_luego_firme is null) and t6_tarifas_listas_lista_id = $lista_existentes";}//SI SELECCIONA VER LAS RECHAZADAS / DEVUELTAS
if($estado_busca == 4){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1) and (creada_luego_firme = 1) and t6_tarifas_listas_lista_id = $lista_existentes";}//SI SELECCIONA VER LAS RECHAZADAS / DEVUELTAS
if($estado_busca == 5){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (11)";}//SI SELECCIONA VER LAS INHABILITADAS
if($estado_busca == 6){ $bus_tarifa_c.= " and fecha_fin_vigencia < '$fecha' and  fecha_fin_vigencia <> '0000-00-00' ";}//SI SELECCIONA VER VENCIDAS
}

 
 
 $nobre_categori_impri="";

	 	$busca_categorias = "";
		$nombre_gupo_imprime="";



		$busca_detalle = "select *  from $v_t_3 where tarifas_contrato_id = $id_contrato_arr   $bus_tarifa_c and tipo_creacion_modifica in (1,3) 	order by consecutivo_tarifa ";
		


		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas
		
		
		$fecha_inico_vigencia0=$lista_detalle[14];
		$moneda0=listas_sin_select($g5,$lista_detalle[8],1);
		$valor_indicador0=$lista_detalle[9];
		
				if($nobre_categori_impri!=$lista_detalle[2]){//si la categoria es una sola
					 $nombre_boto+=1;
						if(chop($lista_detalle[2])<>""){//si la categoria tiene algo ?>

                     
                      
                    
						
						
						<? 
						$nombre_gupo_imprime="";
						}//si la categoria tiene algo
		
		 }//si la categoria es una sola
	  		$nobre_categori_impri=$lista_detalle[2];
							
						
						if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo
						
								$titulos_atributos="";
								
								$grupo_edita+=1;
								if(chop($lista_detalle[3])<>""){ //si el grupo trae algo
								?>
                     			

                            
                                
                                <?
								
								
								
								}//si el grupo trae algo	

						$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
									while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
									$titulos_atributos.="<td class='fondo_3'>".valida_espacio_lista($lista_atr[4])."</td>";
								
									} //lista atributos
									
									
			
			
			
			
			
							}//si ya imprimio el grupo


					
	if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';
	
           if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
	 	
	/*	$cuenta_tarifas_modificadas=traer_fila_row(query_db("select t6_tarifas_lista_id, nombre_estado_tarifa from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15]  order by t6_tarifas_lista_id desc"));
	 	if($cuenta_tarifas_modificadas[0]>=1){//verifica si tienes otras tarifas creadas en esta tarifa
			$cuenta_tarifas_modificadas_nu=traer_fila_row(query_db("select count(*) from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15] "));	
			
			$estado_tarifa = $lista_detalle[16];
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			$estado_tarifa = $lista_detalle[16];
			$modificada = "NO";
		}
		*/
//$estado_tarifa_imprime = saca_nombre_lista("t6_tarifas_estados_tarifas",$lista_detalle[13],'nombre',' t6_tarifas_estados_tarifas_id');
		if( ($lista_detalle[19] != '0000-00-00') && ($lista_detalle[19] < $fecha && $estado_tarifa != "Reemplazada"))
			{
			$estado_tarifa="Vencida";

				
				}
		if($lista_detalle[19] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$lista_detalle[19];
			
	$ayuda_campo_editar="";
	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$busca_valores = traer_fila_row(query_db("select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]"));
	$ayuda_campo_editar.='<td width="20px">'.$busca_valores[3].'</td>';
	
	} //lista atributos									
		
		
		
		/*-------------cuantas veces se ha modificado------------------*/
		$sql = "select count(*) from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15] and t6_tarifas_estados_tarifas_id in (1,7)";
		
		
			$cuenta_tarifas_modificadas_nu=traer_fila_row(query_db($sql));
			
			if($cuenta_tarifas_modificadas_nu[0]>=1){//verifica si tienes otras tarifas creadas en esta tarifa
			$estado_tarifa = $cuenta_tarifas_modificadas[1];
			$modificada = "SI (".$cuenta_tarifas_modificadas_nu[0].") ";
			$muestra_ico_deta=1;
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			$estado_tarifa = $lista_detalle[16];
			$modificada = "NO";
		}
		
		/*-------------FIN cuantas veces se ha modificado------------------*/
		
	/*----***********DESDE ACA SE EMPIESA A CALCLAR LAS MODIFICAICONES **********------*/
			  $id_tar_ya_mostrada = $lista_detalle[0];//la tarifa original
			  $conteo_modificaicones =0;
			  	  
				  $consecutivo1="";
				  $tipo_modifica1="";
			  	  $fecha_apro1="";
				  $fecha_inico_vigencia1="";
				  $fecha_inico_fin1="";
				  $moneda1="";
				  $valor1="";
				  $estado1="";
				  $indicador1="";
				  $porcentaje_variacion1="";
				  $indicador_valor1="";
				  
				  $consecutivo2="";
				  $tipo_modifica2="";
			  	  $fecha_apro2="";
				  $fecha_inico_vigencia2="";
				  $fecha_inico_fin2="";
				  $moneda2="";
				  $valor2="";
				  $estado2="";
				  $indicador2="";
				  $porcentaje_variacion2="";
				  $indicador_valor2="";
				  
				  $consecutivo3="";
				  $tipo_modifica3="";
			  	  $fecha_apro3="";
				  $fecha_inico_vigencia3="";
				  $fecha_inico_fin3="";
				  $moneda3="";
				  $valor3="";
				  $estado3="";
				  $indicador3="";
				  $porcentaje_variacion3="";
				  $indicador_valor3="";
				  
				  $consecutivo4="";
				  $tipo_modifica4="";
			  	  $fecha_apro4="";
				  $fecha_inico_vigencia4="";
				  $fecha_inico_fin4="";
				  $moneda4="";
				  $valor4="";
				  $estado4="";
				  $indicador4="";
				  $porcentaje_variacion4="";
				  $indicador_valor4="";
				  
				  $consecutivo5="";
				  $tipo_modifica5="";
			  	  $fecha_apro5="";
				  $fecha_inico_vigencia5="";
				  $fecha_inico_fin5="";
				  $moneda5="";
				  $valor5="";
				  $estado5="";
				  $indicador5="";
				  $porcentaje_variacion5="";
				  $indicador_valor5="";
				  
				  $consecutivo6="";
				  $tipo_modifica6="";
			  	  $fecha_apro6="";
				  $fecha_inico_vigencia6="";
				  $fecha_inico_fin6="";
				  $moneda6="";
				  $valor6="";
				  $estado6="";
				  $indicador6="";
				  $porcentaje_variacion6="";
				  $indicador_valor6="";
				  
				  $consecutivo7="";
				  $tipo_modifica7="";
			  	  $fecha_apro7="";
				  $fecha_inico_vigencia7="";
				  $fecha_inico_fin7="";
				  $moneda7="";
				  $valor7="";
				  $estado7="";
				  $indicador7="";
				  $porcentaje_variacion7="";
				  $indicador_valor7="";
				  
				  $consecutivo8="";
				  $tipo_modifica8="";
			  	  $fecha_apro8="";
				  $fecha_inico_vigencia8="";
				  $fecha_inico_fin8="";
				  $moneda8="";
				  $valor8="";
				  $estado8="";
				  $indicador8="";
				  $porcentaje_variacion8="";
				  $indicador_valor8="";
				  
				  $consecutivo9="";
				  $tipo_modifica9="";
			  	  $fecha_apro9="";
				  $fecha_inico_vigencia9="";
				  $fecha_inico_fin9="";
				  $moneda9="";
				  $valor9="";
				  $estado9="";
				  $indicador9="";
				  $porcentaje_variacion9="";
				  $indicador_valor9="";
				  
				  $consecutivo10="";
				  $tipo_modifica10="";
			  	  $fecha_apro10="";
				  $fecha_inico_vigencia10="";
				  $fecha_inico_fin10="";
				  $moneda10="";
				  $valor10="";
				  $estado10="";
				  $indicador10="";
				  $porcentaje_variacion10="";
				  $indicador_valor10="";
				  
				  $consecutivo11="";
				  $tipo_modifica11="";
			  	  $fecha_apro11="";
				  $fecha_inico_vigencia11="";
				  $fecha_inico_fin11="";
				  $moneda11="";
				  $valor11="";
				  $estado11="";
				  $indicador11="";
				  $porcentaje_variacion11="";
				  $indicador_valor11="";
				  
				  $consecutivo12="";
				  $tipo_modifica12="";
			  	  $fecha_apro12="";
				  $fecha_inico_vigencia12="";
				  $fecha_inico_fin12="";
				  $moneda12="";
				  $valor12="";
				  $estado12="";
				  $indicador12="";
				  $porcentaje_variacion12="";
				  $indicador_valor12="";
				  				  
			  
			  /* modificacion 1*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo1            =$sql_modifica[1];
				  $tipo_modifica1          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro1             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia1   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin1        =formato_fecha($sql_modifica[3]);
				  $moneda1                 =$sql_modifica[4];
				  $valor1                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador1        =$sql_modifica[5];
				  $estado1                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia0, $moneda0, $valor_indicador0, $fecha_inico_vigencia1, $moneda1, $valor_indicador1);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador1              =$calculo_indicador[0];
				  $porcentaje_variacion1   =$calculo_indicador[1];
				  $indicador_valor1        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 1*/
			  
			   /* modificacion 2*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo2            =$sql_modifica[1];
				  $tipo_modifica2          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro2             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia2   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin2        =formato_fecha($sql_modifica[3]);
				  $moneda2                 =$sql_modifica[4];
				  $valor2                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador2        =$sql_modifica[5];
				  $estado2                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia1, $moneda1, $valor_indicador1, $fecha_inico_vigencia2, $moneda2, $valor_indicador2);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador2              =$calculo_indicador[0];
				  $porcentaje_variacion2   =$calculo_indicador[1];
				  $indicador_valor2        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 2*/
			  
			  /* modificacion 3*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo3            =$sql_modifica[1];
				  $tipo_modifica3          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro3             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia3   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin3        =formato_fecha($sql_modifica[3]);
				  $moneda3                 =$sql_modifica[4];
				  $valor3                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador3        =$sql_modifica[5];
				  $estado3                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia2, $moneda2, $valor_indicador2, $fecha_inico_vigencia3, $moneda3, $valor_indicador3);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador3              =$calculo_indicador[0];
				  $porcentaje_variacion3   =$calculo_indicador[1];
				  $indicador_valor3        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 3*/
			  
			  /* modificacion 4*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo4            =$sql_modifica[1];
				  $tipo_modifica4          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro4             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia4   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin4        =formato_fecha($sql_modifica[3]);
				  $moneda4                 =$sql_modifica[4];
				  $valor4                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador4        =$sql_modifica[5];
				  $estado4                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia3, $moneda3, $valor_indicador3, $fecha_inico_vigencia4, $moneda4, $valor_indicador4);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador4              =$calculo_indicador[0];
				  $porcentaje_variacion4   =$calculo_indicador[1];
				  $indicador_valor4        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 4*/
			  
			  /* modificacion 5*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo5            =$sql_modifica[1];
				  $tipo_modifica5          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro5             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia5   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin5        =formato_fecha($sql_modifica[3]);
				  $moneda5                 =$sql_modifica[4];
				  $valor5                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador5        =$sql_modifica[5];
				  $estado5                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia4, $moneda4, $valor_indicador4, $fecha_inico_vigencia5, $moneda5, $valor_indicador5);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador5              =$calculo_indicador[0];
				  $porcentaje_variacion5   =$calculo_indicador[1];
				  $indicador_valor5        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 5*/
			  
			   /* modificacion 6*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo6            =$sql_modifica[1];
				  $tipo_modifica6          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro6             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia6   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin6        =formato_fecha($sql_modifica[3]);
				  $moneda6                 =$sql_modifica[4];
				  $valor6                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador6        =$sql_modifica[5];
				  $estado6                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia5, $moneda5, $valor_indicador5, $fecha_inico_vigencia6, $moneda6, $valor_indicador6);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador6              =$calculo_indicador[0];
				  $porcentaje_variacion6   =$calculo_indicador[1];
				  $indicador_valor6        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 6*/
			  
			  /* modificacion 7*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo7            =$sql_modifica[1];
				  $tipo_modifica7          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro7             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia7   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin7        =formato_fecha($sql_modifica[3]);
				  $moneda7                 =$sql_modifica[4];
				  $valor7                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador7        =$sql_modifica[5];
				  $estado7                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia6, $moneda6, $valor_indicador6, $fecha_inico_vigencia7, $moneda7, $valor_indicador7);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador7              =$calculo_indicador[0];
				  $porcentaje_variacion7   =$calculo_indicador[1];
				  $indicador_valor7        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 7*/
			  
			  /* modificacion 8*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo8            =$sql_modifica[1];
				  $tipo_modifica8          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro8             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia8   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin8        =formato_fecha($sql_modifica[3]);
				  $moneda8                 =$sql_modifica[4];
				  $valor8                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador8        =$sql_modifica[5];
				  $estado8                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia7, $moneda7, $valor_indicador7, $fecha_inico_vigencia8, $moneda8, $valor_indicador8);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador8              =$calculo_indicador[0];
				  $porcentaje_variacion8   =$calculo_indicador[1];
				  $indicador_valor8        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 8*/
			  
			  /* modificacion 9*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo9            =$sql_modifica[1];
				  $tipo_modifica9          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro9             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia9   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin9        =formato_fecha($sql_modifica[3]);
				  $moneda9                 =$sql_modifica[4];
				  $valor9                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador9        =$sql_modifica[5];
				  $estado9                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia8, $moneda8, $valor_indicador8, $fecha_inico_vigencia9, $moneda9, $valor_indicador9);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador9              =$calculo_indicador[0];
				  $porcentaje_variacion9   =$calculo_indicador[1];
				  $indicador_valor9        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 9*/
			  
			  /* modificacion 10*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo10            =$sql_modifica[1];
				  $tipo_modifica10          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro10             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia10   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin10        =formato_fecha($sql_modifica[3]);
				  $moneda10                 =$sql_modifica[4];
				  $valor10                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador10        =$sql_modifica[5];
				  $estado10                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia9, $moneda9, $valor_indicador9, $fecha_inico_vigencia10, $moneda10, $valor_indicador10);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador10              =$calculo_indicador[0];
				  $porcentaje_variacion10   =$calculo_indicador[1];
				  $indicador_valor10        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 10*/
			  
			  /* modificacion 11*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo11            =$sql_modifica[1];
				  $tipo_modifica11          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro11             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia11   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin11        =formato_fecha($sql_modifica[3]);
				  $moneda11                 =$sql_modifica[4];
				  $valor11                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador11        =$sql_modifica[5];
				  $estado11                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia10, $moneda10, $valor_indicador10, $fecha_inico_vigencia11, $moneda11, $valor_indicador11);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador11              =$calculo_indicador[0];
				  $porcentaje_variacion11   =$calculo_indicador[1];
				  $indicador_valor11        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 11*/
			  
			  /* modificacion 12*/
              $sql_modifica = traer_fila_row(query_db("select MIN(t6_tarifas_lista_id), consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id not in ($id_tar_ya_mostrada) and t6_tarifas_estados_tarifas_id in (1,7)  GROUP BY  consecutivo_tarifa, fecha_inicio_vigencia, fecha_fin_vigencia, moneda, valor, nombre_estado_tarifa, tipo_creacion_modifica"));
			  if($sql_modifica[0]>0){
				  $id_tar_ya_mostrada = $id_tar_ya_mostrada.",".$sql_modifica[0];//agrega tarifa de la modificacoin para que no se muestre mas a delante
				  $conteo_modificaicones = $conteo_modificaicones +1;
				  
				  $consecutivo12            =$sql_modifica[1];
				  $tipo_modifica12          = sel_tipo_modifica($sql_modifica[7]);
				  $fecha_apro12             =ultima_aprobacion($sql_modifica[0]);
				  $fecha_inico_vigencia12   =formato_fecha($sql_modifica[2]);
				  $fecha_inico_fin12        =formato_fecha($sql_modifica[3]);
				  $moneda12                 =$sql_modifica[4];
				  $valor12                  =valor_imprime_excel_con_desc($sql_modifica[5]);
				  $valor_indicador12        =$sql_modifica[5];
				  $estado12                 =$sql_modifica[6];
				  $calculo_indicador =indicador_variacion($fecha_inico_vigencia11, $moneda11, $valor_indicador11, $fecha_inico_vigencia12, $moneda12, $valor_indicador12);
				  $calculo_indicador=explode("*",$calculo_indicador);
				  $indicador12              =$calculo_indicador[0];
				  $porcentaje_variacion12   =$calculo_indicador[1];
				  $indicador_valor12        =$calculo_indicador[2];				  
				  
				  }
			  /* modificacion 12*/
			  
			  
			  
		/*----*********** F*I*N *********DESDE ACA SE EMPIESA A CALCLAR LAS MODIFICAICONES **********------*/
 ?> 

            <tr class="<?=$class;?>" >
              <td><?=$lista_detalle[28];?></td>
                        <td><?=$lista_detalle[2];?></td>
                        <td><?=$lista_detalle[3];?></td>
                        <td><?=$lista_detalle[6];?></td>
                        <td><?=$lista_detalle[4];?></td>
                        <td ><?=$lista_detalle[5];?></td>

              <td class="titulos_resumen_alertas"><div align="center">
              <?=listas_sin_select($g5,$lista_detalle[8],1);?>
</div></td>
	<?
		$valor_unido=0;
		$valor_arr = explode(".",$lista_detalle[9]);
		$unidades =$valor_arr[0];
		$decimales =  $valor_arr[1];
		$valor_unido = $unidades.$formato_numeros_miles.$decimales;
	?>
              <td  style="<?=$stilo_excel;?>" class="titulos_resumen_alertas"><div align="center"><?=$valor_unido;?>
              </div></td>
              
              <td class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <td class="titulos_resumen_alertas"><?=$fecha_fin_vi;?></td>
              <td class="titulos_resumen_alertas"><?=$lista_detalle[11];?></td>
              <td class="titulos_resumen_alertas"><?=$lista_detalle[27];?></td>
              <td class="titulos_resumen_alertas"><?=$estado_tarifa;?> </td>
              <td class="titulos_resumen_alertas"><?=$modificada?></td>
              
              
              <td width="3%" align="center"><?=$consecutivo1?></td>
              <td width="3%" align="center"><?=$tipo_modifica1?></td>
              <td width="3%" align="center"><?=$fecha_apro1?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia1?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin1?></td>
              <td width="3%" align="center"><?=$moneda1?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor1?></td>
              <td width="3%" align="center"><?=$estado1?></td>
              <td width="3%" align="center"><?=$indicador1?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion1?></td>
              <td width="3%" align="center"><?=$indicador_valor1?></td>
              
              
              <td width="3%" align="center"><?=$consecutivo2?></td>
              <td width="3%" align="center"><?=$tipo_modifica2?></td>
              <td width="3%" align="center"><?=$fecha_apro2?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia2?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin2?></td>
              <td width="3%" align="center"><?=$moneda2?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor2?></td>
              <td width="3%" align="center"><?=$estado2?></td>
              <td width="3%" align="center"><?=$indicador2?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion2?></td>
              <td width="3%" align="center"><?=$indicador_valor2?></td>
              
              <td width="3%" align="center"><?=$consecutivo3?></td>
              <td width="3%" align="center"><?=$tipo_modifica3?></td>
              <td width="3%" align="center"><?=$fecha_apro3?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia3?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin3?></td>
              <td width="3%" align="center"><?=$moneda3?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor3?></td>
              <td width="3%" align="center"><?=$estado3?></td>
              <td width="3%" align="center"><?=$indicador3?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion3?></td>
              <td width="3%" align="center"><?=$indicador_valor3?></td>
              
              <td width="3%" align="center"><?=$consecutivo4?></td>
              <td width="3%" align="center"><?=$tipo_modifica4?></td>
              <td width="3%" align="center"><?=$fecha_apro4?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia4?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin4?></td>
              <td width="3%" align="center"><?=$moneda4?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor4?></td>
              <td width="3%" align="center"><?=$estado4?></td>
              <td width="3%" align="center"><?=$indicador4?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion4?></td>
              <td width="3%" align="center"><?=$indicador_valor4?></td>
              
              <td width="3%" align="center"><?=$consecutivo5?></td>
              <td width="3%" align="center"><?=$tipo_modifica5?></td>
              <td width="3%" align="center"><?=$fecha_apro5?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia5?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin5?></td>
              <td width="3%" align="center"><?=$moneda5?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor5?></td>
              <td width="3%" align="center"><?=$estado5?></td>
              <td width="3%" align="center"><?=$indicador5?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion5?></td>
              <td width="3%" align="center"><?=$indicador_valor5?></td>
              
              <td width="3%" align="center"><?=$consecutivo6?></td>
              <td width="3%" align="center"><?=$tipo_modifica6?></td>
              <td width="3%" align="center"><?=$fecha_apro6?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia6?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin6?></td>
              <td width="3%" align="center"><?=$moneda6?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor6?></td>
              <td width="3%" align="center"><?=$estado6?></td>
              <td width="3%" align="center"><?=$indicador6?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion6?></td>
              <td width="3%" align="center"><?=$indicador_valor6?></td>
              
              <td width="3%" align="center"><?=$consecutivo7?></td>
              <td width="3%" align="center"><?=$tipo_modifica7?></td>
              <td width="3%" align="center"><?=$fecha_apro7?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia7?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin7?></td>
              <td width="3%" align="center"><?=$moneda7?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor7?></td>
              <td width="3%" align="center"><?=$estado7?></td>
              <td width="3%" align="center"><?=$indicador7?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion7?></td>
              <td width="3%" align="center"><?=$indicador_valor7?></td>
              
              <td width="3%" align="center"><?=$consecutivo8?></td>
              <td width="3%" align="center"><?=$tipo_modifica8?></td>
              <td width="3%" align="center"><?=$fecha_apro8?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia8?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin8?></td>
              <td width="3%" align="center"><?=$moneda8?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor8?></td>
              <td width="3%" align="center"><?=$estado8?></td>
              <td width="3%" align="center"><?=$indicador8?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion8?></td>
              <td width="3%" align="center"><?=$indicador_valor8?></td>
              
              <td width="3%" align="center"><?=$consecutivo9?></td>
              <td width="3%" align="center"><?=$tipo_modifica9?></td>
              <td width="3%" align="center"><?=$fecha_apro9?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia9?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin9?></td>
              <td width="3%" align="center"><?=$moneda9?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor9?></td>
              <td width="3%" align="center"><?=$estado9?></td>
              <td width="3%" align="center"><?=$indicador9?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion9?></td>
              <td width="3%" align="center"><?=$indicador_valor9?></td>
              
              <td width="3%" align="center"><?=$consecutivo10?></td>
              <td width="3%" align="center"><?=$tipo_modifica10?></td>
              <td width="3%" align="center"><?=$fecha_apro10?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia10?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin10?></td>
              <td width="3%" align="center"><?=$moneda10?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor10?></td>
              <td width="3%" align="center"><?=$estado10?></td>
              <td width="3%" align="center"><?=$indicador10?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion10?></td>
              <td width="3%" align="center"><?=$indicador_valor10?></td>
              
              <td width="3%" align="center"><?=$consecutivo11?></td>
              <td width="3%" align="center"><?=$tipo_modifica11?></td>
              <td width="3%" align="center"><?=$fecha_apro11?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia11?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin11?></td>
              <td width="3%" align="center"><?=$moneda11?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor11?></td>
              <td width="3%" align="center"><?=$estado11?></td>
              <td width="3%" align="center"><?=$indicador11?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion11?></td>
              <td width="3%" align="center"><?=$indicador_valor11?></td>
              
			<td width="3%" align="center"><?=$consecutivo12?></td>
              <td width="3%" align="center"><?=$tipo_modifica12?></td>
              <td width="3%" align="center"><?=$fecha_apro12?></td>
              <td width="3%" align="center"><?=$fecha_inico_vigencia12?></td>
              <td width="3%" align="center"><?=$fecha_inico_fin12?></td>
              <td width="3%" align="center"><?=$moneda12?></td>
              <td width="3%" align="center" style="<?=$stilo_excel;?>"><?=$valor12?></td>
              <td width="3%" align="center"><?=$estado12?></td>
              <td width="3%" align="center"><?=$indicador12?></td>
              <td width="3%" align="center"><?=$porcentaje_variacion12?></td>
              <td width="3%" align="center"><?=$indicador_valor12?></td>
            
            
            
            </tr>
           <? $num_fila++; 							
							
							
							
							
							
							
							
							
							
							
							
							
							
							$nombre_gupo_imprime=$lista_detalle[3];
							
							
							if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo cierra tabla
							
							?> </table> 

<p>
  <?
							
							}//si ya imprimio el grupo cierra tabla
							
		
		}//todas las tarifas
 
 
 
    // } //si ya selecciono una lista ?>
              
       <script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>       
</p>
<p>&nbsp;</p>
</body>
</html>