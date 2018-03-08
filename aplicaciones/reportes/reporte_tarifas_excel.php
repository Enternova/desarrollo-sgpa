<?     header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte_de_tiquetes.xls"); 
	header("Content-Transfer-Encoding: binary");


//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");

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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>

</head>

<body>



  <?

 if( ($categoria_existentes!="no_apli_b") && ($categoria_existentes!="") )
	  	$bus_tarifa_c = " and categoria = '".elimina_comillas_2($categoria_existentes)."' ";

	  if( ($grupo_existentes!="no_apli_b") && ($grupo_existentes!="") )
	  	$bus_tarifa_c.= " and grupo = '".elimina_comillas_2($grupo_existentes)."' ";

	  if($detalle_ta_b!="")
	  	$bus_tarifa_c.= " and detalle like '%".elimina_comillas_2($detalle_ta_b)."%' ";

	  if($codigo_ta_b!="")
	  	$bus_tarifa_c.= " and codigo_proveedo like '%".elimina_comillas_2($codigo_ta_b)."%' ";
	  
	     


 
 
 $nobre_categori_impri="";

	 	$busca_categorias = "";
		$nombre_gupo_imprime="";


	 	  $busca_detalle = "	select *  from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (1,2,5) and t6_tarifas_listas_lista_id = $lista_existentes   $bus_tarifa_c	";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas
		
				if($nobre_categori_impri!=$lista_detalle[2]){//si la categoria es una sola
					 $nombre_boto+=1;
						if(chop($lista_detalle[2])<>""){//si la categoria tiene algo ?>
<br />
                       <table width="98%" border="0">
                          <tr>
                            <td class="titulos_secciones" width="1%">Categoria: </td>
                            <td class="titulos_secciones" width="47%" align="left"><?=$lista_detalle[2];?></td>
                          </tr>
</table>
                      
                    
						
						
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
                     			
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">

                              <tr>
                                <td width="5%">GRUPO:</td>
                                <td width="52%"><?=$lista_detalle[3];?>
                                </td>
                              </tr>
                            </table>
                            
                                
                                <?
								
								
								
								}//si el grupo trae algo	

						$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
									while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
									$titulos_atributos.="<th  class='fondo_3'>".valida_espacio_lista($lista_atr[4])."</th>";
								
									} //lista atributos
									
									
									
									?>  
											
												
									<table border=0 cellspacing="2" cellpadding="2" width="100%" >                	
								
											<tr>
											<th  class="fondo_3" width="5%">Codigo</th>
											<th  class="fondo_3" width="40%">Nombre_generico_del_producto_/_servicio</th>
											  
											  <th width="5%" class="fondo_3"><div align="center">Unidad </div></th>
											  <th width="6%" class="fondo_3">Moneda</th>
											  <th width="8%" class="fondo_3"><div align="center">Valor_tarifa</div></th>
											  <th width="11%" class="fondo_3">Inicio_vigencia</th>
											  <th width="7%" class="fondo_3">Modificada</th>
											  <th width="8%" class="fondo_3">Aprobaci&oacute;n</th>
											  <?=$titulos_atributos;?>
											</tr>
											
												 <?
			
			
			
			
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
			$estado_tarifa = $cuenta_tarifas_modificadas[1];
			$modificada = "SI (".$cuenta_tarifas_modificadas_nu[0].")";
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			$estado_tarifa = $lista_detalle[16];
			$modificada = "NO";
		}
		

	$ayuda_campo_editar="";
	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$busca_valores = traer_fila_row(query_db("select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]"));
	$ayuda_campo_editar.='<td width="20px">'.$busca_valores[3].'</td>';
	
	} //lista atributos									
		
		
 ?> 

            <tr class="<?=$class;?>" >
                        <td><?=$lista_detalle[4];?></td>
                        <td width="50px"><?=$lista_detalle[5];?></td>

              <td height="30"><div align="center"><?=$lista_detalle[6];?></div></td>
              <td class="titulos_resumen_alertas"><div align="center">
              <?=listas_sin_select($g5,$lista_detalle[8],1);?>
</div></td>
              <td class="titulos_resumen_alertas"><div align="center"><?=number_format($lista_detalle[9],2);?>
              </div></td>
              
              <td class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <td class="titulos_resumen_alertas"><?=$modificada;?></td>
              <td class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>

            <?=$ayuda_campo_editar;?>
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
									  
									  
</p>
		   <p>&nbsp;</p>
</body>
</html>
