<? header("Content-type: application/octet-stream");//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=Reporte de Solicitudes Eliminadas.xls");//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

/*include("../../librerias/lib/@include.php");*/
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");
	

	  

		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$tp_proceso_busca = arreglo_recibe_variables($_GET["tp_proceso_busca"]);
		
		$muestra_finalizados = arreglo_recibe_variables($_GET["muestra_finalizados"]);
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		$bus_area = arreglo_recibe_variables($_GET["bus_area"]);
		$bus_text1 = arreglo_recibe_variables($_GET["bus_text1"]);
		$bus_text2 = arreglo_recibe_variables($_GET["bus_text2"]);
		$bus_text3 = arreglo_recibe_variables($_GET["bus_text3"]);
		$bus_text4 = arreglo_recibe_variables($_GET["bus_text4"]);
		$bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
		$contra_provee = arreglo_recibe_variables($_GET["contra_provee"]);
		$num_solped_bus=arreglo_recibe_variables($_GET["num_solped_bus"]);
		$tipo_contratacion = arreglo_recibe_variables($_GET["tipo_contratacion"]);
		$origen_pecc = arreglo_recibe_variables($_GET["origen_pecc"]);
		
		$fecha1 = arreglo_recibe_variables($_GET["fecha1"]);
		$fecha2 = arreglo_recibe_variables($_GET["fecha2"]);
		$completar_filtros = "";

			
		if($numero1_pecc != "0" and $numero1_pecc != ""){
			$completar_filtros.=" and num1 = '".$numero1_pecc."'";
			}
		if($numero2_pecc != "" and $numero2_pecc != 0){
			if($numero2_pecc == 99){
					$completar_filtros.=" and (num2 = '' or num2 = ' ' or num2 is NULL)";		
				}else{
					$completar_filtros.=" and num2 like '%".$numero2_pecc."%'";
				}
			}
		if($numero3_pecc != "" and $numero2_pecc != 99){
			$completar_filtros.=" and num3 = '".$numero3_pecc."'";
			}

		if($num_solped_bus!=""){
			$completar_filtros.=" and num_solped like '%".$num_solped_bus."%'";
			
		}

		
		if($tp_proceso_busca != 0){
			$completar_filtros.=" and tipo_proceso_id = ".$tp_proceso_busca;
			}
				$areas_in="";
		if($bus_area != 0){
				  if($bus_area == 34){
				  $areas_in = $areas_in.", ".$bus_area.", 24";
			  	  }elseif($bus_area == 35){
				  $areas_in = $areas_in.", ".$bus_area.", 25,20";
				  }elseif($bus_area == 36){
				  $areas_in = $areas_in.", ".$bus_area.", 22,26,32";
				  }elseif($bus_area == 37){
				  $areas_in = $areas_in.", ".$bus_area.", 6";
				  }elseif($bus_area == 38){
				  $areas_in = $areas_in.", ".$bus_area.", 21, 29";
				  }elseif($bus_area == 39){
				  $areas_in = $areas_in.", ".$bus_area.", 12";
				  }elseif($bus_area == 40){
				  $areas_in = $areas_in.", ".$bus_area.", 17";
				  }elseif($bus_area == 41){
				  $areas_in = $areas_in.", ".$bus_area.", 18";
				  }elseif($bus_area == 44){
				  $areas_in = $areas_in.", ".$bus_area.", 1";
				  }elseif($bus_area == 46){
				  $areas_in = $areas_in.", ".$bus_area.", 31";
				  }elseif($bus_area == 47){
				  $areas_in = $areas_in.", ".$bus_area.", 13";
				  }elseif($bus_area == 48){
				  $areas_in = $areas_in.", ".$bus_area.", 7";
				  }elseif($bus_area == 49){
				  $areas_in = $areas_in.", ".$bus_area.", 8";
				  }elseif($bus_area == 50){
				  $areas_in = $areas_in.", ".$bus_area.", 14";
				  }elseif($bus_area == 55){
				  $areas_in = $areas_in.", ".$bus_area.", 5";
				  }else{
		  			$areas_in = $areas_in.", ".$bus_area;
					}
					
			$completar_filtros.=" and t1_area_id in (0".$areas_in.")";
			}
			
		
			
		
		if($bus_text5 != ""){
			$completar_filtros.=" and (objeto_solicitud like '%".$bus_text5."%' or ob_solicitud_adjudica like '%".$bus_text5."%')";
			}
		if($_GET["profesional_cyc"] != 0){
				$completar_filtros.=" and profesional_id =".$_GET["profesional_cyc"];
			}
			
			if($fecha1!=""){
			$completar_filtros.=" and fecha>='".$fecha1."'";
			}
		if($fecha1!=""){
			$completar_filtros.=" and fecha<='".$fecha2."'";
			}
			
			
			
		$explode = explode("----,",$_GET["usuario_permiso"]);
	$id_usuario = $explode[1];	
		
		if($id_usuario <> ""){
			$completar_filtros.=" and solicitante_id =".$id_usuario;
			}
			
			
			if($_GET["paginas"] > 0){
		$pagina = $_GET["paginas"];
		$_SESSION['paginass'] = $_GET["paginas"];
		}else{

			$pagina = 1;
			}
		$registros_pagina=30;		
		$regis_final = $pagina * $registros_pagina;		
		$regis_inicial = ($pagina - 1) * $registros_pagina;
		
		
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>



<style>
.fondo_3{ background:#005395; color:#FFFFFF;}
</style>

</head>

<body>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  </table>
  <table width="100%" border="1" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr class="fondo_3">
      <td width="4%" height="29" align="center" class="columna_subtitulo_resultados">Numero</td>
      <td width="5%" align="center" class="columna_subtitulo_resultados">Fecha de Creacion</td>
      <td width="4%" align="center" class="columna_subtitulo_resultados">Tipo de Proceso</td>
      <td width="7%" align="center" class="columna_subtitulo_resultados">Area de la Solicitud</td>
      <td width="9%" align="center" class="columna_subtitulo_resultados">Usuario Solicitante</td>
      <td width="8%" align="center" class="columna_subtitulo_resultados">Responsable en Abastecimiento</td>
      <td width="14%" align="center" class="columna_subtitulo_resultados">Objeto de la Solicitud</td>
      <td width="10%" align="center" class="columna_subtitulo_resultados">Fecha en la que se Elimino</td>
      <td width="10%" align="center" class="columna_subtitulo_resultados">Usuario que Elimino</td>      
      <td width="18%" align="center" class="columna_subtitulo_resultados">Observacion de Eliminacion</td>
      <td width="11%" align="center" class="columna_subtitulo_resultados">Estado Antes de Eliminar</td>
    </tr>
    <?
	




		
		
		
			
						
						
			
	 $sele_items_historico_codigo = "select id_item, num1, num2, num3, fecha_creacion, t1_area_id, area, objeto_solicitud, tipo_proceso_id, tipo_proceso, solicitante, solicitante_id, profesional, profesional_id, preparador, preparador_id, id_accion_admin, fecha, adjunto, usuario_admin,observacion, (select max(t2_nivel_servicio_actividad_id) from t2_nivel_servicio_gestiones where t2_nivel_servicio_gestiones.estado = 1 and t2_nivel_servicio_gestiones.id_item = v_reporte_solicitudes_eliminadas.id_item) as ultima_gestion, ROW_NUMBER()Over(order by fecha desc) As RowNum from v_reporte_solicitudes_eliminadas where id_item > 0  $completar_filtros $comple_sql_histo $comple_sq_us group by id_item, num1, num2, num3, fecha_creacion, t1_area_id, area, objeto_solicitud, tipo_proceso_id, tipo_proceso, solicitante, solicitante_id, profesional, profesional_id, preparador, preparador_id, id_accion_admin, fecha, adjunto, usuario_admin, observacion";




    	$sel_histo_sql = query_db( $sele_items_historico_codigo);

		
		while($sel_para_insert = traer_fila_db($sel_histo_sql)){
			
			
			
			$numero_proceso=numero_item_pecc($sel_para_insert[1],$sel_para_insert[2],$sel_para_insert[3]);		
			
			
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }

 $estado = "";
 
 if($sel_para_insert[1]==""){$estado = 31;}else{
	 
	 if($sel_para_insert[21]>0){
		 if($sel_para_insert[21]== 1){
			 $estado = 6;
			 }else{
		$estado =  $sel_para_insert[21];}
		 }else{
			 $estado = 31;
			 }
	 }
 

 
				  
	?>
    <tr class="<?=$clase?>">
      <td><?=$numero_proceso?></td>
      <td align="center"><?=$sel_para_insert[4]?></td>
      <td><?=$sel_para_insert[9]?></td>
      <td><?=$sel_para_insert[6]?></td>
      <td><?=$sel_para_insert[10]?></td>
      <td><?=$sel_para_insert[12]?></td>
      <td><?=$sel_para_insert[7]?></td>
      <td><?=$sel_para_insert[17]?></td>
      <td><?=$sel_para_insert[19]?></td>
      <td><?=$sel_para_insert[20]?></td>
      <td><?=traer_nombre_muestra($estado, "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
    </tr>
    <?
		}
	?>
  </table>

</body>
</html>
