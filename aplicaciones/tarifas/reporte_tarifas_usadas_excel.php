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
include("../../librerias/php/funciones_general_2015.php");
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


<table border=1  width="100%" >                	
  <tr>
    <td height="107" colspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="8" align="left" class="titulo1"><strong>REPORTE DE TARIFAS USADAS <?=$sql_con[7];?></strong></td>
  </tr>

<tr>
  <td width="5%" align="center" class="titulo3"><strong><?=TITULO_CONSECUTIVO;?></strong></td>
	<td width="5%" align="center" class="titulo3"><strong><?=TITULO_2;?></strong></td>
	<td width="5%" align="center" class="titulo3"><strong><?=TITULO_3;?></strong></td>
	<td width="5%" align="center" class="titulo3" ><strong><?=TITULO_4;?></strong></td>
	<td width="5%" align="center" class="titulo3" ><strong><?=TITULO_5;?></strong></td>
	<td width="40%" align="center" class="titulo3"><strong><?=TITULO_6;?></strong></td>
    <td width="6%" align="center" class="titulo3"><strong><?=TITULO_7;?></strong></td>
    <td width="8%" align="center" class="titulo3"><strong><?=TITULO_8;?></strong></td>
    <td width="11%" align="center"  class="titulo3"><strong><?=TITULO_9;?></strong></td>
    <td width="11%" align="center"  class="titulo3"><strong><?=TITULO_18;?></strong></td>    
    <td width="7%" align="center"  class="titulo3"><strong><?=TITULO_12;?></strong></td>
    <td  align="center"  class="titulo3"><strong><?=TITULO_13;?></strong></td>
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
	  
 
 $nobre_categori_impri="";

	 	$busca_categorias = "";
		$nombre_gupo_imprime="";



	 	  $busca_detalle = "select *  from v_tarifas_cuantas_veces_usada_final where tarifas_contrato_id = $id_contrato_arr   $bus_tarifa_c	order by cuantas_veces_usada desc";
		

		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas
		
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


	
           if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
							
							
							
	 	$estado_tarifa=$lista_detalle[16];
		
//$estado_tarifa_imprime = saca_nombre_lista("t6_tarifas_estados_tarifas",$lista_detalle[13],'nombre',' t6_tarifas_estados_tarifas_id');

	$ayuda_campo_editar="";
	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$busca_valores = traer_fila_row(query_db("select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]"));
	$ayuda_campo_editar.='<td width="20px">'.$busca_valores[3].'</td>';
	
	} //lista atributos									
		if( ($lista_detalle[19] != '0000-00-00') && ($lista_detalle[19] < $fecha))
			{
			$estado_tarifa="Vencida";
				}

		if($lista_detalle[19] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$lista_detalle[19];
		
		
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
              <td   style="<?=$stilo_excel;?>"  class="titulos_resumen_alertas"><div align="center"><?=number_format($lista_detalle[9],$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?>
              </div></td>
              
              <td class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <td class="titulos_resumen_alertas"><?=$fecha_fin_vi;?></td>
              <td class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
              <td  align="center"><?=$lista_detalle[27];?></td>
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