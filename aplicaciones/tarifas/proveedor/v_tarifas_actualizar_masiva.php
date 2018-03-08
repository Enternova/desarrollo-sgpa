<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));		
	
	$busca_descuneto = "select t6_tarifas_ipc_contrato_id, ipc_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_ipc_contrato where t6_tarifas_contratos_id = $id_contrato_arr  and ipc_administracion = 1 and estado = 1";
	$traer_descvuentos = traer_fila_row(query_db($busca_descuneto));
					
					if($_GET["tipo_creacion"] == 2){//si es modificacion masiva
					$link = "c_tarifas_actualicar_masivas.php";
					}
					if($_GET["tipo_creacion"] == 3){//si es creacion masiva
					$link = "c_tarifas_masivas.php";
					}	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91%" class="titulos_secciones">SECCION:<span class="titulos_resaltado_procesos"> CONTRATO:
      <?=$sql_con[7];?>      
    </span></span>&gt;&gt;  ACTUALIZACION DE TARIFAS</td>
    <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver" id="button5" value="Volver al menu" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualicar_masivas.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></td>
  </tr>
</table>

<br />

  <input type="hidden" name="id_tarifa" />
  <input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">
<br />
<?

if($lista_existentes>=1){//si ya selecciono una lista
$buscar_lista = traer_fila_row(query_db("select * from $t12 where t6_tarifas_listas_lista_id = $lista_existentes"));

?>

 <?=busca_tarifas_aiu($id_contrato_arr,1);?>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><br />
      <br />
<?      
	  if( ($categoria_existentes!="no_apli_b") && ($categoria_existentes!="") )
	  	$bus_tarifa_c = " and categoria = '".elimina_comillas_2($categoria_existentes)."' ";

	  if( ($grupo_existentes!="no_apli_b") && ($grupo_existentes!="") )
	  	$bus_tarifa_c.= " and grupo = '".elimina_comillas_2($grupo_existentes)."' ";

	  if($detalle_ta_b!="")
	  	$bus_tarifa_c.= " and detalle like '%".elimina_comillas_2($detalle_ta_b)."%' ";

	  if($tipo_modificacion>=1)
	  	$bus_tarifa_c.= " and tipo_creacion_modifica = ".$tipo_modificacion;
	  
	     


	 $busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes ";
			$id_ingreso=traer_fila_row(query_db($busca_categorias));
			if($id_ingreso[0]>=1){ //si tiene tarifas
			

	$factor_b_c = 50;
	$factor_b = 50;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

$where_general = " tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (10) and t6_tarifas_listas_lista_id = $lista_existentes". $bus_tarifa_c;

  $sql_cuenta2 = "select  count(*) from  $v_t_3 where $where_general";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );			


       ?>
   
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel='se refiere a tarifas cargadas en el inicio del contrato' />Se refiere a tarifas cargadas en el inicio del contrato, <img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" /> se refiere a tarifas cargadas posteriormente del inicio del contrato</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="columna_titulo_resultados">
    
    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="4%"><div align="left">P&aacute;gina</div></td>
        <td width="12%" align="left">
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo_tarifas_pro(this.value,'../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php','carga_acciones_permitidas',18)">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
            </select>
        </td>
        <td width="84%" align="left" class="letra-descuentos">Total de tarifas: <?=number_format($sql_cuenta[0],0);?></td>
        </tr>
    </table>
   </td>
   </tr>
   </table>

<?

$nobre_categori_impri="";

	 	$busca_categorias = "";
		$nombre_gupo_imprime="";


	 	  $busca_detalle = "select * from (
								select t6_tarifas_lista_id, tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, 
                      tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia, tarifa_padre, fecha_fin_vigencia, t6_tarifas_listas_lista_id, tipo_creacion_modifica, 
                      us_aprobacion_actual, creada_luego_firme , ROW_NUMBER() OVER(ORDER BY categoria, grupo, tarifa_padre, fecha_creacion ) AS rownum from $v_t_3 where $where_general and tipo_creacion_modifica = ".$_GET["tipo_creacion"]."
								) as sub
	where rownum > $inicio and rownum <= $factor_b";
	


		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas
		
if($lista_detalle[22]==1)
		{ $tipo_modifica="Normal";
			$class_tipo="tarifas_normal";
		}	
		elseif($lista_detalle[22]==2)
		{ 			
		    $tipo_modifica="Actualizada";
			$class_tipo="tarifas_actualiza";
		}	


		elseif($lista_detalle[22]==3)
		{ 			
			$tipo_modifica="Creacion";
			$class_tipo="tarifas_creacion";
		}	
		

		elseif($lista_detalle[22]==4)
		{ 			
			$tipo_modifica="IPC";
			$class_tipo="tarifas_ipc";
		}			
		
				if($nobre_categori_impri!=$lista_detalle[2]){//si la categoria es una sola
					 $nombre_boto+=1;
						if(chop($lista_detalle[2])<>""){//si la categoria tiene algo ?>
				
                       <table width="98%" border="0">
                          <tr>
                            <td class="titulos_secciones" width="10%">Categoria: <?=$lista_detalle[2];?></td>
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
                                <td width="5%">GRUPO:<?=$lista_detalle[3];?></td>
                              </tr>
                            </table>
                                <?
								
								}//si el grupo trae algo	

						/*$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
									while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
									//$titulos_atributos.="<th width='8%'   class='fondo_3'>".valida_espacio_lista($lista_atr[4])."</th>";
								
									} //lista atributos
									
								*/	
									
									?>  
											
												
									<table border=0 cellspacing="2" cellpadding="2" width="100%" >                	
								
											<tr>
											  <th width="1%" class="fondo_3">&nbsp;</th>
											  <th width="18%" class="fondo_3"><?=TITULO_1;?></th>
											<th  width="4%" class="fondo_3"><?=TITULO_5;?></th>
											<th  class="fondo_3" width="22%"><?=TITULO_6;?></th>
											  
											  <th width="7%" class="fondo_3"><div align="center">
											    <?=TITULO_4;?>
											  </div></th>
											  <th width="4%" class="fondo_3"><?=TITULO_7;?></th>
											  <th width="9%" class="fondo_3"><div align="center">
											    <?=TITULO_8;?>
											  </div></th>
											  <th width="7%" class="fondo_3"><?=TITULO_9;?></th>
											  <th width="6%" class="fondo_3">Modificada</th>
											  <th width="6%" class="fondo_3"><?=TITULO_18;?></th>
											  <th class="fondo_3"  width="6%">Admin</th>
											  <?=$titulos_atributos;?>
											</tr>
											
												 <?
			
			
			
			
							}//si ya imprimio el grupo

$modificada ="";
					
	if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';
	
           if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
	 	if($lista_detalle[13]==1){//si es la aprobada
		$cuenta_tarifas_modificadas=traer_fila_row(query_db("select t6_tarifas_lista_id, nombre_estado_tarifa from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15]  order by t6_tarifas_lista_id desc"));
	 	if($cuenta_tarifas_modificadas[0]>=1){//verifica si tienes otras tarifas creadas en esta tarifa
			$cuenta_tarifas_modificadas_nu=traer_fila_row(query_db("select count(*) from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15] "));	
			//$estado_tarifa = $cuenta_tarifas_modificadas[1];
			$modificada = "SI (".$cuenta_tarifas_modificadas_nu[0].")";
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			
			$modificada = "NO";
		}
		
		} //si es la aprobada
		$estado_tarifa = $lista_detalle[16];
		

	$ayuda_campo_editar="";
	/*$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$busca_valores = traer_fila_row(query_db("select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]"));
	$ayuda_campo_editar.='<td width="1%"><textarea class="campos_tarifas" name="detalle_campo_descriptor_modifica_'.$lista_detalle[0].'['.$busca_valores[0].'-'.$lista_atr[0].']"  cols="5" rows="1" class="textarea_tarifas_300">'.$busca_valores[3].'</textarea>  </td>';
	
	} //lista atributos		
	*/							
		
		
 ?> 
            <input name="cantidad_tarifa_<?=$lista_detalle[0];?>" type="hidden" value="0" class="campos_tarifas" />
            <tr class="<?=$class;?>" >
              <td></td>
              <td height="30"><?=$tipo_creacion;?></td>
                        <td><?=$lista_detalle[4];?></td>
                        <td><?=$lista_detalle[5];?></td>

              <td height="30"><div align="center"><?=$lista_detalle[6];?></div></td>
              <td class="titulos_resumen_alertas"><div align="center">
                <?=listas_sin_select($g5,$lista_detalle[8],1);?>
              </div></td>
              
			  <? if($lista_detalle[13]==1){//si es la aprobada{ ?>
              <td class="titulos_resumen_alertas"><div align="center"><?=$lista_detalle[9];?></div></td>
              
              <td class="titulos_resumen_alertas"><?=$lista_detalle[0];?></td>
              <td class="titulos_resumen_alertas"><?=$modificada;?></td>
              <td class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
              <td class="titulos_resumen_alertas"><input type="button" name="button6" id="button6" value="Modificar" onclick="muestra_div_o('espacio_<?=$lista_detalle[0];?>')"/></td>
              <? } //si es la aprobada
			  else
			  	{ //si NO es la aprobada ?>
              <td width="2%" class="titulos_resumen_alertas"><div align="center"><?=decimales_estilo($lista_detalle[9],2);?></div></td>
              <td width="2%" class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <td width="2%" class="titulos_resumen_alertas"><?=$modificada;?></td>
              <td width="2%" class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
				<td width="2%"  class="titulos_resumen_alertas">


			 <? if($lista_detalle[13]==10){//si es la aprobada{ ?>
                <input type="button" name="button7" id="button7" value="Ver detalle"  onclick="muestra_div_o('espacio_<?=$lista_detalle[0];?>')"/>
               <? } ?>                              </td>

					
					
					
			  <? } //si NO es la aprobada ?>
            </tr>
            
            <tr class="<?=$class;?>" style="display:none" id="espacio_<?=$lista_detalle[0];?>" >
              <td>&nbsp;</td>
              
            	<td colspan="<? echo (11);?>">
                <?
					
					$busca_soporte = traer_fila_row(query_db("select * from t6_tarifas_anexos_modifica_tarifas where t6_tarifas_lista_id = $lista_detalle[0]"));
				
				?>
                <table width="100%" border="0">
                 <? if($sql_con[19]==2){ //si es contrato marco 
				 	$busca_secundarios = traer_fila_row(query_db("select us_id from t6_tarifas_aprobadores_secundarios where t6_tarifas_lista_id = $lista_detalle[0] and tipo_aprobacion_copia = 1"));
				 	$busca_secundarios_copia = traer_fila_row(query_db("select count(*) from t6_tarifas_aprobadores_secundarios where t6_tarifas_lista_id = $lista_detalle[0] and tipo_aprobacion_copia = 2"));

				 ?>
                
                  <tr>
                    <td><div align="right"><strong>Quien solicita actualizar la tarifa:</strong></div></td>
                    <td>
                    <?=listas_sin_select($g1,$busca_secundarios[0],1);?>                    </td>
                  </tr>
                  <tr>
                    <td align="right"><div align="right"><strong>Desea informarle a alguien adicional la modificaci&oacute;n de la  tarifa:</strong></div></td>
                    <td><?	if($busca_secundarios_copia[0]>=1) echo "Si"; 
					else echo "No";
					
					 ?>                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td id="carga_usuario_copia_<?=$lista_detalle[0];?>">                   </td>
                  </tr>
                  <? } //si es contrato marco ?>
                    <tr>
                    <td colspan="2"><?=busca_tarifas_aiu($id_contrato_arr,1);?></td>
                  </tr>
                  <tr>
                    <td  width="20%"><div align="right"><strong>Nuevo valor:</strong></div></td>
                    <td>
                     <?=number_format($lista_detalle[9],2);	?>                    </td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Fecha de inicio de vigencia:</strong></div></td>
                    <td><span class="titulos_resumen_alertas">
                    <?=$lista_detalle[14];?>                    </td>
                  </tr>
                  
                  <tr>
                    <td align="right">La tarifa aplica descuento:</td>
                    <td><?
					if($busca_soporte[4]==1) echo "Si";
					else echo "No";
				  	 ?>
                    </td>
                  </tr>
                  
                  <? if(busca_tarifas_convenciones($id_contrato_arr,3)==1){ ?>
                  <tr>
                    <td align="right"><strong>Modificaci&oacute;n por convencion:</strong></td>
                    <td> <? if($lista_detalle[18]==5) echo "Si";
					else echo "No";
						
						?></td>
                  </tr>
                  <? }   ?>
                  <tr>
    <td width="20%"><div align="right"><strong>Observaciones:</strong></div></td>
    <td><?=$busca_soporte[2];?>    </td>
    </tr>

  <tr>
    <td>&nbsp;</td>
    <td>
    
    <input name="button2" type="button" class="boton_volver" id="button2" value="Cerrar detalle" onclick="oculta_div_o('espacio_<?=$lista_detalle[0];?>')" />
   </td>
    </tr>
</table>

           </td>
           </tr>
           <? $num_fila++; 							
							
							$nombre_gupo_imprime=$lista_detalle[3];
							
							
							if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo cierra tabla
							
							?> </table> 
	  <?
							
							}//si ya imprimio el grupo cierra tabla
							
		
		}//todas las tarifas


 }  //si tiene tarifas
 else { // si no tiene tarifas ?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="fondo_5"><div align="center">Esta lista  no tiene tarifas cargadas hasta el momento</div></td>
  </tr>
</table>    

	
      <? 
 }// si no tiene tarifas
	  
	  } //si ya selecciono una lista ?>
      
      
<input type="hidden" name="ruta_devuelve" value="c_tarifas_actualizar" />
</body>
</html>
