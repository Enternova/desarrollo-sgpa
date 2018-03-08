<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/html; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		


	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));	
	
	if($sql_con[11]==2) $java_script="edita_tarifa_parcial";
	else $java_script="edita_tarifa";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> MODIFICAR  TARIFAS &gt;&gt; CONTRATO:
      <?=numero_cotnrato_tarifas($id_contrato_arr);?>
    </span></td>
    <td width="13%" ><span class="titulos_secciones"><input type="button" name="button2" class="boton_volver"  id="button2" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></span></td>
  </tr>
  <tr>
    <td width="25%" ><div align="right"><strong><span class="titulos_resaltado_subtitulos_tarifas">Proveedor:</span></strong></div></td>
    <td colspan="2" ><span class="titulos_resaltado_subtitulos_contenidostarifas">
      <?=$sql_con[6];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" ><div align="right"><strong><span class="titulos_resaltado_subtitulos_tarifas">Objeto del contrato:</span></strong></div></td>
    <td colspan="2" ><span class="titulos_resaltado_subtitulos_contenidostarifas">
      <?=$sql_con[9];?>
    </span></td>
  </tr>
</table>
<br />
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" valign="top" class="fondo_2_sub">Seleccione una lista de este contrato</td>
  </tr>

  <tr>
    <td  valign="top">&nbsp;</td>
    <td colspan="2" valign="top" >&nbsp;</td>
  </tr>
<input type="hidden" name="id_tarifa" />
<input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">
<input type="hidden" name="id_nombre_edita">
  
    <?
if($lista_existentes==""){//si no  selecciono una lista

$selec_lista = traer_fila_row(query_db("select * from $t12 where tarifas_contrato_id = $id_contrato_arr"));
$lista_existentes = $selec_lista[0];
}//si no  selecciono una lista  
  
  ?>
  <tr>
    <td width="5%" height="22" valign="top" class="fondo_6"><img src="../imagenes/botones/nuevo_descriptor.gif" alt="Nuevo descriptor" width="32" height="32" /></td>
    <td colspan="2" valign="top" class="fondo_6" ><div align="left">SELECCIONE UNA LISTA:
        <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=' + this.value,'carga_acciones_permitidas')">
          <?=listas($t12, " tarifas_contrato_id = $id_contrato_arr",$lista_existentes,'nombre', 2);?>
          </select>
    </div></td>
  </tr>
  <tr>
    <td valign="top"><div align="right"></div></td>
    <td width="2%" valign="top"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td width="93%" valign="top"><div align="justify"><strong>Seleccione la lista a la que desea configurar descriptores o modificar las propiedades de la misma.</strong></div></td>
  </tr>  
</table>

<br />
<?

if($lista_existentes>=1){//si ya selecciono una lista
$buscar_lista = traer_fila_row(query_db("select * from $t12 where t6_tarifas_listas_lista_id = $lista_existentes"));


?>

<table width="99%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td class="fondo_5"><strong>Usted ha seleccionado la lista:<?=$buscar_lista[2];?></strong></td>
  </tr>
</table>

<br />
      <br />
      <?
	  
	  if( ($categoria_existentes!="no_apli_b") && ($categoria_existentes!="") )
	  	$bus_tarifa_c = " and categoria = '".elimina_comillas_2($categoria_existentes)."' ";

	  if( ($grupo_existentes!="no_apli_b") && ($grupo_existentes!="") )
	  	$bus_tarifa_c.= " and grupo = '".elimina_comillas_2($grupo_existentes)."' ";

	  if($detalle_ta_b!="")
	  	$bus_tarifa_c.= " and detalle like '%".elimina_comillas_2($detalle_ta_b)."%' ";

	  if($codigo_ta_b!="")
	  	$bus_tarifa_c.= " and codigo_proveedo like '%".elimina_comillas_2($codigo_ta_b)."%' ";
	  if($str_consecutivo_bus!="")
	  	$bus_tarifa_c.= " and consecutivo_tarifa in ($str_consecutivo_bus) ";  
	     


	 $busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes ";
			$id_ingreso=traer_fila_row(query_db($busca_categorias));
			if($id_ingreso[0]>=1){ 
			

	$factor_b_c = 50;
	$factor_b = 50;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

  $sql_cuenta2 = "select  count(*) from  $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (1,2,5) and t6_tarifas_listas_lista_id = $lista_existentes $bus_tarifa_c";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );			
			
			?>
<table width="99%" border="0" align="center" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="fondo_2_sub">Buscador de tarifas</td>
  </tr>
  <tr>
    <td align="right"><?=TITULO_CONSECUTIVO;?>:</td>
    <td><input type="text" name="str_consecutivo_bus" id="str_consecutivo_bus" value="<?=$str_consecutivo_bus;?>" /></td>
    <td colspan="3"><?=ayuda_CONSECUTIVO;?></td>
  </tr>
  
  <tr>
    <td width="7%" align="right"><strong>Categoria:</strong></td>
    <td width="26%"><select name="categoria_existentes" id="categoria_existentes" onchange="ajax_carga('../aplicaciones/tarifas/carga_grupos_existentes.php?id_contrato_arr=<?=$id_contrato_arr;?>&categoria_trae=' + this.value,'grupo__xistente')">
      <option value="no_apli_b" >Categorias existentes</option>
      <?
			 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes";
					$sql_cate=query_db($busca_categorias);
					while($lista_categoria=traer_fila_row($sql_cate)) {
						if($categoria_existentes==$lista_categoria[0]) $select_c = "selected";
						else $select_c = "";
						
						echo "<option value='".$lista_categoria[0]."' ".$select_c.">".$lista_categoria[0]."</option>";
						
					}

			 ?>
    </select></td>
    <td width="16%" align="right"><strong>Grupo:</strong></td>
    <td width="17%" id="grupo__xistente"><select name="grupo_existentes" class="campos_tarifas" id="grupo_existentes" >
      <option value="no_apli_b">Grupos existentes</option>
       <?
	   	if($categoria_existentes!="no_apli_b"){
				 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '".elimina_comillas_2($categoria_existentes)."'";
					$sql_cate=query_db($busca_grupos);
					while($lista_grupo_e=traer_fila_row($sql_cate)){
					if(elimina_comillas_2($grupo_existentes)==elimina_comillas_2($lista_grupo_e[0])) $select_c = "selected";
						else $select_c = "";

						echo "<option value='".$lista_grupo_e[0]."' ".$select_c.">".$lista_grupo_e[0]."</option>";
						
					}
						
		}
			 
			 ?>
  </select></td>
    <td width="34%" id="grupo__xistente">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>Codigo:</strong></td>
    <td><input type="text" name="codigo_ta_b" id="codigo_ta_b" value="<?=$codigo_ta_b;?>" /></td>
    <td align="right"><strong>Detalle:</strong></td>
    <td colspan="2"><input type="text" name="detalle_ta_b" id="detalle_ta_b" value="<?=$detalle_ta_b;?>"/></td>
  </tr>
  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><input name="button" type="button" class="boton_buscar" id="button" value="      Buscar tarifas      "  onclick="javascript:document.principal.pagina.value=1;busqueda_paginador_nuevo_tarifas(1,'../aplicaciones/tarifas/c_modificar_tarifas.php','carga_acciones_permitidas',14)"/></td>
  </tr>
</table>
<br />
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel='se refiere a tarifas cargadas en el inicio del contrato' />Se refiere a tarifas cargadas en el inicio del contrato, <img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" /> se refiere a tarifas cargadas posteriormente del inicio del contrato</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="columna_titulo_resultados">
    
    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="4%"><div align="left">P&aacute;gina</div></td>
        <td width="12%" align="left">
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo_tarifas(this.value,'../aplicaciones/tarifas/c_modificar_tarifas.php','carga_acciones_permitidas',14)">
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

<? } else { // si no tiene tarifas ?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="fondo_5"><div align="center">Esta lista  no tiene tarifas cargadas hasta el momento</div></td>
  </tr>
</table>


 <?
 } // si no tiene tarifas
 
 
 	
 
 
 $nobre_categori_impri="";

	 	$busca_categorias = "";
		$nombre_gupo_imprime="";


	 	  $busca_detalle = "select * from (
								select  t6_tarifas_lista_id, tarifas_contrato_id, categoria, grupo, codigo_proveedor, CONVERT(TEXT, detalle) as detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, 
                      tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia, tarifa_padre, nombre_estado_tarifa, descripcion, moneda, fecha_fin_vigencia, 
                      t6_tarifas_listas_lista_id, nombre, tipo_creacion_modifica, us_aprobacion_actual, creada_luego_firme, consecutivo_tarifa
 , ROW_NUMBER() OVER(ORDER BY categoria, grupo, fecha_creacion desc) AS rownum from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (1,2,5) and t6_tarifas_listas_lista_id = $lista_existentes $bus_tarifa_c
								) as sub
	where rownum > $inicio and rownum <= $factor_b";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas
		
				if($nobre_categori_impri!=$lista_detalle[2]){//si la categoria es una sola
					 $nombre_boto+=1;
						if(chop($lista_detalle[2])<>""){//si la categoria tiene algo ?>
					<br />
                       <table width="99%" border="0">
                        <tr>
                            <td class="titulos_secciones" width="10%">Categoria: </td>
                            <td class="titulos_secciones" width="47%"><input type="text" name="categoria_nueva_<?=$nombre_boto;?>" id="textfield" value="<?=$lista_detalle[2];?>" /></td>
                            <td  class="titulos_secciones" width="43%"><input name="categoria_<?=$nombre_boto;?>" type="button" class="boton_edicion" value="Editar categoria" onclick="edita_categoria(<?=$nombre_boto;?>)" />
                            <input type="hidden" name="categoria_actual_<?=$nombre_boto;?>" id="categoria_actual_<?=$nombre_boto;?>"  value="<?=$lista_detalle[2];?>" /></td>
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
                     			
                                <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">

                              <tr>
                                <td width="5%">GRUPO:</td>
                                <td width="52%"><input type="text" name="grupo_nueva_<?=$grupo_edita;?>"value="<?=$lista_detalle[3];?>" />
                                  <input type="hidden" name="grupo_actual_<?=$grupo_edita;?>" value="<?=$lista_detalle[3];?>" />
                                   <input type="hidden" name="categoria_actual_grupo_<?=$grupo_edita;?>"  value="<?=$lista_detalle[2];?>" />
                                  </td>
                                <td width="12%">Mover a categoria:</td>
                                <td width="19%" align="right"><input type="text" name="nueva_categoria_grupo_<?=$grupo_edita;?>" /></td>
                                <td width="12%"><input name="grupo_<?=$grupo_edita;?>" type="button" class="boton_edicion" value="Editar grupo" onclick="edita_grupo(<?=$grupo_edita;?>)" /></td>
                              </tr>
                            </table>
                            
                                
<?
								
								
								
								}//si el grupo trae algo	

						$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
									while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
									$titulos_atributos.="<th  class='fondo_3'>".valida_espacio_lista($lista_atr[4])."</th>";
								
									} //lista atributos
									
									
									
									?>  
											
												
									<table width="99%" border=0 cellpadding="2" cellspacing="2" bgcolor="white" id="datos2" >                	
								
						  <tr>
											<th width="3%" class="fondo_3"><?=TITULO_1;?></th>
                                            <th  class="fondo_3" width="3%"><?=TITULO_CONSECUTIVO;?></th>
                                            <th  class="fondo_3"><?=TITULO_4;?></th>
											<th  class="fondo_3"><?=TITULO_5;?></th>
											<th  class="fondo_3"><?=TITULO_6;?></th>
											  
											  <th width="6%" class="fondo_3"><?=TITULO_7;?></th>
											  <th width="8%" class="fondo_3"><div align="center">
											    <?=TITULO_8;?>
											  </div></th>
											  <th width="11%" class="fondo_3"><?=TITULO_9;?></th>
                                              <th width="11%" class="fondo_3"><?=TITULO_18;?></th>
											  <th width="7%" class="fondo_3">Modificada</th>
											  <th width="8%" class="fondo_3">Aprobaci&oacute;n</th>
											  <th colspan="3" class="fondo_3">Administrar</th>
											 
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
			//$estado_tarifa = $cuenta_tarifas_modificadas[1];
			$modificada = "SI (".$cuenta_tarifas_modificadas_nu[0].")";
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			
			$modificada = "NO";
		}
		
		$estado_tarifa = $lista_detalle[16];
		

	$ayuda_campo_editar="";
	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$busca_valores = traer_fila_row(query_db("select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]"));
	$ayuda_campo_editar.='<td><textarea name="detalle_campo_descriptor_modifica_'.$lista_detalle[0].'['.$busca_valores[0].'-'.$lista_atr[0].']"  cols="25" rows="1" class="textarea_tarifas_300">'.$busca_valores[3].'</textarea>  </td>';
	
	} //lista atributos									
		
		
 ?> 
            <input name="cantidad_tarifa_<?=$lista_detalle[0];?>" type="hidden" value="0" class="campos_tarifas" />
            <tr class="<?=$class;?>" >
                                      <td height="30"><?=$tipo_creacion;?></td>
                                      <td><div align="<?=alinea_CONSECUTIVO;?>"><?=$lista_detalle[25];?></div></td>
                                      <td><input name="unidad_tarifa_<?=$lista_detalle[0];?>" type="text" class="campos_tarifas" value="<?=$lista_detalle[6];?>" size="5" /></td>
                                      
                        <td><input name="codigo_m_<?=$lista_detalle[0];?>" type="text" id="codigo" size="2"  value="<?=$lista_detalle[4];?>" /></td>
                        <td><textarea name="detalle_m_<?=$lista_detalle[0];?>" id="detalle" cols="25" rows="1" class="textarea_tarifas_300"><?=$lista_detalle[5];?></textarea></td>

              <td class="titulos_resumen_alertas"><div align="center"><select name="moneda_tarifa_<?=$lista_detalle[0];?>" id="moneda"><?=listas($g5, " t1_moneda_id  >= 1",$lista_detalle[8],'nombre', 1);?></select></div></td>
              <td class="titulos_resumen_alertas"><div align="center">
                <input name="valor_tarifa_<?=$lista_detalle[0];?>" type="text" id="valor_tarifa_<?=$lista_detalle[0];?>" value="<?=$lista_detalle[9];?>" class="campos_tarifas" onkeyup='checkDecimals_2(this.name, this.value,this)' onpaste="return false;"/>
              </div></td>
              
              <td class="titulos_resumen_alertas"><input name="vigencia_tarifa_<?=$lista_detalle[0];?>" type="text" id="vigencia_tarifa_<?=$lista_detalle[0];?>" value="<?=$lista_detalle[14];?>" onmousedown="calendario_sin_hora('vigencia_tarifa_<?=$lista_detalle[0];?>')" class="campos_tarifas" /></td>
			  <td class="titulos_resumen_alertas"><input name="vigencia_tarifa_final_<?=$lista_detalle[0];?>" type="text" id="vigencia_tarifa_final_<?=$lista_detalle[0];?>" value="<?=$lista_detalle[19];?>" onmousedown="calendario_sin_hora('vigencia_tarifa_final_<?=$lista_detalle[0];?>')" class="campos_tarifas" /></td>
              <td class="titulos_resumen_alertas"><?=$modificada;?></td>
              <td class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
              <td width="2%" class="titulos_resumen_alertas"><img src="../imagenes/botones/editar.jpg" alt="Editar tarifa" title="Editar tarifa" width="14" height="15" onclick="<?=$java_script;?>('<?=arreglo_pasa_variables($lista_detalle[0]);?>',document.principal.valor_tarifa_<?=$lista_detalle[0];?>)" /></td>
              <td width="2%" class="titulos_resumen_alertas"><img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar tarifa" title="Eliminar tarifa" width="16" height="16" /></td>
              <td width="2%" class="titulos_resumen_alertas"><? if($titulos_atributos!=""){ ?><img src="../imagenes/botones/busqueda.gif" alt="ver atributos de esta tarifa" title="ver atributos de esta tarifa" width="16" height="16" onclick="muestra_div_o('lisat_detalle_atributo_<?=$lista_detalle[0];?>')" /><? } ?></td>

           
            </tr>
            
	<tr>
            <td colspan="10">
            <div  id="lisat_detalle_atributo_<?=$lista_detalle[0];?>" style="display:none" >
                        <table border="1" width="100%">
						<tr>
                        <?=$titulos_atributos;?>
                        </tr>
                        <tr>            
                        	<?=$ayuda_campo_editar;?>
                        </tr>
                        </table>
                        <br />
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input type="button" name="button2" class="boton_volver" id="button2" value="Cerrar atributos" onclick=" oculta_div_o('lisat_detalle_atributo_<?=$lista_detalle[0];?>')" /></td>
  </tr>
</table>

                        </div>             </td>
           <? $num_fila++; 							
							
							
							
							
							
							
							
							
							
							
							
							
							
							$nombre_gupo_imprime=$lista_detalle[3];
							
							
							if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo cierra tabla
							
							?> </table> <?
							
							}//si ya imprimio el grupo cierra tabla
							
		
		}//todas las tarifas
 
 
 
     } //si ya selecciono una lista ?>
     
     

</body>
</html>
