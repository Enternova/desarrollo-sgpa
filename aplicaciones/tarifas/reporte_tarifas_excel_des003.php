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

	echo $id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
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
								

  <tr>
    <td height="107" colspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="12" align="left" class="titulo1"><strong>REPORTE DE TARIFAS CONTRATO <?=$sql_con[7];?></strong></td>
  </tr>
<tr >
  <td width="5%" align="center" class="titulo3"><strong><?=TITULO_CONSECUTIVO;?></strong></td>
	<td width="5%" align="center" class="titulo3"><strong><?=TITULO_2;?></strong></td>
	<td width="5%" align="center" class="titulo3"><strong><?=TITULO_3;?></strong></td>
	<td width="5%" align="center" class="titulo3" ><strong><?=TITULO_4;?></strong></td>
	<td width="5%" align="center" class="titulo3" ><strong><?=TITULO_5;?></strong></td>
	<td width="40%" align="center" class="titulo3"><strong><?=TITULO_6;?></strong></td>
    <td width="6%" align="center" class="titulo3"><strong><?=TITULO_7;?></strong></td>
    <td width="6%" align="center" class="titulo3"><strong>Valor actual</strong></td>
    <td width="6%" align="center" class="titulo3"><strong>Nuevo valor</strong></td>
	<td width="11%" align="center" class="titulo3"><strong>Concepto<strong></td>
    <td width="11%" align="center"  class="titulo3"><strong><?=TITULO_9;?></strong></td>
    <td width="7%" align="center"  class="titulo3"><strong><?=TITULO_18;?></strong></td>
    <td width="7%" align="center"  class="titulo3"><strong><?=TITULO_16;?></strong></td>
    <td width="7%" align="center"  class="titulo3"><strong><?=TITULO_17;?></strong></td>
    <td width="7%" align="center"  class="titulo3"><strong><?=TITULO_12;?></strong></td>
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
	  
if($tipo_reporte == "h_aprobaciones"){	     

if($estado_busca == 0){ $bus_tarifa_c.= "";}//SI SELECCIONA VER TODAS
if($estado_busca == 1 or $estado_busca == ""){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (2, 3) and (creada_luego_firme = 2 or creada_luego_firme is null) and t6_tarifas_listas_lista_id = $lista_existentes";}//SI SELECCIONA VER LAS PENDIENTES
if($estado_busca == 2){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1) and (creada_luego_firme = 2 or creada_luego_firme is null)  and (fecha_fin_vigencia >= '$fecha' or fecha_fin_vigencia = '0000-00-00' ) and t6_tarifas_listas_lista_id = $lista_existentes";}//SI SELECCIONA VER LAS APROBADAS
if($estado_busca == 3){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (4, 5, 6, 10) and (creada_luego_firme = 2 or creada_luego_firme is null) and t6_tarifas_listas_lista_id = $lista_existentes";}//SI SELECCIONA VER LAS RECHAZADAS / DEVUELTAS
if($estado_busca == 4){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1) and (creada_luego_firme = 1) and t6_tarifas_listas_lista_id = $lista_existentes";}//SI SELECCIONA VER LAS RECHAZADAS / DEVUELTAS
if($estado_busca == 5){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (11)";}//SI SELECCIONA VER LAS INHABILITADAS
if($estado_busca == 6){ $bus_tarifa_c.= " and fecha_fin_vigencia < '$fecha' and  fecha_fin_vigencia <> '0000-00-00' ";}//SI SELECCIONA VER VENCIDAS
}
if($tipo_reporte == "h_tarifas"){
	$bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1)  and (fecha_fin_vigencia >= '$fecha' or fecha_fin_vigencia = '0000-00-00' ) and t6_tarifas_listas_lista_id = $lista_existentes ";
}
if($tipo_reporte == "c_aprobaciones"){
	$bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (3) ";
}

 
 
 $nobre_categori_impri="";

	 	$busca_categorias = "";
		$nombre_gupo_imprime="";



		$busca_detalle = "select *  from $v_t_3 where tarifas_contrato_id = $id_contrato_arr   $bus_tarifa_c	order by consecutivo_tarifa ";
		


		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas
			if($lista_detalle[22]==1)
		{ $tipo_modifica="Normal";
		}	
		elseif($lista_detalle[22]==2)
		{ 			
		    $tipo_modifica="Actualizada";
		}	


		elseif($lista_detalle[22]==3)
		{ 			
			$tipo_modifica="Creacion";
		}	
		

		elseif($lista_detalle[22]==4)
		{ 			
			$tipo_modifica="IPC";
		}
			
			
			
		if($lista_detalle[13]==3 and ($lista_detalle[22]==4 or $lista_detalle[22]==2)){
		 			
			
		$busca_tarifa_padre_act=  "select top(1) valor from v_tarifas_lista_estados where tarifa_padre = ".$lista_detalle[15]." and t6_tarifas_estados_tarifas_id = 1 order by consecutivo_tarifa desc";//busque la ultima actualizacion aprobada
			$busca_detalle_padre = traer_fila_row(query_db($busca_tarifa_padre_act));
			if($busca_detalle_padre[0]<=0){
				$busca_tarifa_padre_act=  "select valor from  t6_tarifas_lista where t6_tarifas_lista_id = $lista_detalle[15]";
				$busca_detalle_padre = traer_fila_row(query_db($busca_tarifa_padre_act));
			}
			if($busca_detalle_padre[0]<=0){
				$busca_tarifa_padre_act=  "select top(1) valor from v_tarifas_lista_estados where tarifa_padre = ".$lista_detalle[15]." order by consecutivo_tarifa desc";
				$busca_detalle_padre = traer_fila_row(query_db($busca_tarifa_padre_act));
			}
				
		
				
		 }
			
			

		
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
	 	
		$cuenta_tarifas_modificadas=traer_fila_row(query_db("select t6_tarifas_lista_id, nombre_estado_tarifa from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15]  order by t6_tarifas_lista_id desc"));
	 	if($cuenta_tarifas_modificadas[0]>=1){//verifica si tienes otras tarifas creadas en esta tarifa
			$cuenta_tarifas_modificadas_nu=traer_fila_row(query_db("select count(*) from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15] "));	
			
			$estado_tarifa = $lista_detalle[16];
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			$estado_tarifa = $lista_detalle[16];
			$modificada = "NO";
		}
		
//$estado_tarifa_imprime = saca_nombre_lista("t6_tarifas_estados_tarifas",$lista_detalle[13],'nombre',' t6_tarifas_estados_tarifas_id');
		if( ($lista_detalle[19] != '0000-00-00') && ($lista_detalle[19] < $fecha))
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
		if($busca_detalle_padre[0]!="" and $busca_detalle_padre[0]!=" " and $busca_detalle_padre[0]!=null){
			$valor_unido=0;
			$valor_arr = explode(".",$busca_detalle_padre[0]);
			$unidades =$valor_arr[0];
			$decimales =  $valor_arr[1];
			$valor_unido1 = $unidades.$formato_numeros_miles.$decimales;
		}else{
			$valor_unido1=0;
		}
	?>
                        <td style="<?=$stilo_excel;?>" class="titulos_resumen_alertas"><?=$valor_unido1;?></td>
	<?
		$valor_unido=0;
		$valor_arr = explode(".",$lista_detalle[9]);
		$unidades =$valor_arr[0];
		$decimales =  $valor_arr[1];
		$valor_unido = $unidades.$formato_numeros_miles.$decimales;
	?>
              <td  style="<?=$stilo_excel;?>" class="titulos_resumen_alertas"><div align="center"><?=$valor_unido;?>
              </div></td>
                        <td ><?=$tipo_modifica;?></td>
              
              <td class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <td class="titulos_resumen_alertas"><?=$fecha_fin_vi;?></td>
              <td class="titulos_resumen_alertas"><?=$lista_detalle[11];?></td>
              <td class="titulos_resumen_alertas"><?=$lista_detalle[27];?></td>
              <td class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
              <?=$ayuda_campo_editar;?>
            </tr>
           <? $num_fila++; 							
							
							
							
							
							
							
							
							
							
							
							
							
							
							$nombre_gupo_imprime=$lista_detalle[3];
							
							
							if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo cierra tabla
							
							?> </table> 

<?
							
							}//si ya imprimio el grupo cierra tabla
							
		
		}//todas las tarifas
 
 
 
    // } //si ya selecciono una lista ?>
									  
									  
</body>
</html>