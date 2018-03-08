<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));		
	
	$busca_descuneto = "select t6_tarifas_ipc_contrato_id, ipc_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_ipc_contrato where t6_tarifas_contratos_id = $id_contrato_arr  and ipc_administracion = 1 and estado = 1";
	$traer_descvuentos = traer_fila_row(query_db($busca_descuneto))
	
	
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
     <?=numero_cotnrato_tarifas($id_contrato_arr);?>     
    </span></span>&gt;&gt;  ACTUALIZACION DE TARIFAS</td>
    <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver" id="button5" value="Volver al menu" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','contenidos')" /></td>
  </tr>
</table>

<br />
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" valign="top" class="fondo_2_sub">Seleccione una lista de este contrato</td>
  </tr>

  <tr>
    <td  valign="top">&nbsp;</td>
    <td colspan="2" valign="top" >&nbsp;</td>
  </tr>
    <?
if($lista_existentes==""){//si no  selecciono una lista

$selec_lista = traer_fila_row(query_db("select * from $t12 where tarifas_contrato_id = $id_contrato_arr"));
$lista_existentes = $selec_lista[0];
}//si no  selecciono una lista  
  
  ?>
  <tr>
    <td width="5%" height="22" valign="top" class="fondo_6"><img src="../imagenes/botones/nuevo_descriptor.gif" alt="Nuevo descriptor" width="32" height="32" /></td>
    <td colspan="2" valign="top" class="fondo_6" ><div align="left">SELECCIONE UNA LISTA:
        <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php?id_contrato=<?=$id_contrato;?>&amp;lista_existentes=' + this.value,'carga_acciones_permitidas')">
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
	  
		  if($str_consecutivo_bus!="")
	  	$bus_tarifa_c.= " and consecutivo_tarifa in ($str_consecutivo_bus) ";     


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

$where_general = " tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (1,3,9)  and t6_tarifas_listas_lista_id = $lista_existentes". $bus_tarifa_c;

  $sql_cuenta2 = "select  count(*) from  $v_t_3 where $where_general";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );			

$where_general_cuneta_tarifas_pendientes = " tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (8,9) and t6_tarifas_listas_lista_id = $lista_existentes". $bus_tarifa_c;

  $sql_cuenta_pendites = "select  count(*) from  $v_t_3 where $where_general_cuneta_tarifas_pendientes";
	 $sql_cuenta_pendie=traer_fila_row(query_db($sql_cuenta_pendites));

if($sql_cuenta_pendie[0]>=1){//se activa si tine tarifas			
			?>

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="2" class="fondo_2_sub" valign="top">Confirmar actualizaci&oacute;n de tarifas</td>
        </tr>
        <tr>
          <td width="4%"><img src="../imagenes/botones/envia_confirmacion.gif" alt="Enviar confirmacion" width="32" height="32" /></td>
          <td width="96%"><span class="fondo_5">ATENCION:</span> <strong>Solo si ya esta seguro de haber terminado la actualizaci&oacute;n de todas las tarifas presione el siguiente bot&oacute;n &quot;Confirmar actualizaci&oacute;n de tarifas&quot;, esta acci&oacute;n notificara a HOCOL SA sobre la atualizaci&oacute;n y porcederan con la validaci&oacute;n y aprobaci&oacute;n; Si no ha terminado no  ejecute el boton siga modificando, el sistema guardara las creaciones incluso si sale del sistema.</strong></td>
        </tr>
        <tr>
          <td colspan="2"><div align="left"><input type="button" name="button" class="boton_email" id="button" value="Confirmar actualizaci&oacute;n de tarifas" onclick="confirma_actualizacion()" /> 
            <span class="letra-descuentos"><strong>Recuerde revisar el saldo del contrato con HOCOL, esta modificaci&oacute;n&nbsp; &oacute; inclusi&oacute;n de tarifas puede requerir Aprobaciones internas.</strong></span></div></td>
        </tr>
      </table>
      <? } // se activa si tine ependinetes ?>
              
      </p>
      <table width="98%" border="0" class="tabla_lista_resultados">
        <tr>
    <td colspan="5" class="fondo_2_sub">Buscador de tarifas</td>
  </tr>
 <tr>
    <td align="right"><?=TITULO_CONSECUTIVO;?>:</td>
    <td><input type="text" name="str_consecutivo_bus" id="str_consecutivo_bus" value="<?=$str_consecutivo_bus;?>" /></td>
    <td colspan="3"><?=ayuda_CONSECUTIVO;?></td>
  </tr>
  <tr>
    <td width="14%" align="right"><strong>Categoria:</strong></td>
    <td width="26%"><select name="categoria_existentes" id="categoria_existentes" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/grupo_ex.php?id_contrato_arr=<?=$id_contrato_arr;?>&categoria_trae=' + this.value,'grupo__xistente')">
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
    <td width="9%" align="right"><strong>Grupo:</strong></td>
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
    <td align="right"><strong>Tipo de modificaci&oacute;n:</strong></td>
    <td><select name="tipo_modificacion" id="tipo_modificacion">
      <option value="0">Seleccione</option>
      <option value="2" <? if($tipo_modificacion==2) echo "selected"; ?>  >Actualizaci&oacute;n</option>
      <option value="3" <? if($tipo_modificacion==3) echo "selected"; ?> >Nuevas</option>
      <option value="4" <? if($tipo_modificacion==4) echo "selected"; ?> >IPC</option>
    </select></td>
    <td align="right"><strong>Detalle:</strong></td>
    <td colspan="2"><input type="text" name="detalle_ta_b" id="detalle_ta_b" value="<?=$detalle_ta_b;?>"/></td>
  </tr>
  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><input name="button" type="button" class="boton_buscar" id="button" value="      Buscar tarifas      "  onclick="javascript:document.principal.pagina.value=1;busqueda_paginador_nuevo_tarifas(1,'../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php','carga_acciones_permitidas',17)"/></td>
  </tr>
</table>
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
                      us_aprobacion_actual, creada_luego_firme ,consecutivo_tarifa, ROW_NUMBER() OVER(ORDER BY categoria, grupo, tarifa_padre, fecha_creacion ) AS rownum from $v_t_3 where $where_general
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
											  <th width="1%" class="fondo_3">Origen</th>
											  <th width="5%" class="fondo_3"><?=TITULO_CONSECUTIVO;?></th>
											<th  width="9%" class="fondo_3"><?=TITULO_5;?> 
											  (No ingresar descripci&oacute;n solo  n&uacute;meros y/o letras)</th>
											<th  class="fondo_3" width="25%"><?=TITULO_6;?> 
											  (tipo de servicio y/o Producto que se  est&aacute; prestando)</th>
											  
											  <th width="3%" class="fondo_3"><div align="center">
											    <?=TITULO_4;?>
											  </div></th>
											  <th width="3%" class="fondo_3"><?=TITULO_7;?></th>
											  <th width="10%" class="fondo_3"><div align="center">
											    <?=TITULO_8;?>
											  </div></th>
											  <th width="6%" class="fondo_3"><?=TITULO_9;?></th>
											  <th width="6%" class="fondo_3"><?=TITULO_18;?></th>
                                             
											  <th width="4%" class="fondo_3">Modificada</th>
											  <th width="4%" class="fondo_3">Aprobaci&oacute;n</th>
											  <th class="fondo_3"  width="8%">Admin</th>
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
	
	if($lista_detalle[16] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$lista_detalle[16];	
		
 ?> 
            <input name="cantidad_tarifa_<?=$lista_detalle[0];?>" type="hidden" value="0" class="campos_tarifas" />
            <tr class="<?=$class;?>" >
              <td><?=$tipo_creacion;?></td>
              <td height="30"><div align="<?=alinea_CONSECUTIVO;?>"><?=$lista_detalle[21];?></div></td>
                        <td  align="center" ><?=$lista_detalle[4];?></td>
                        <td ><?=$lista_detalle[5];?></td>

              <td height="30"><div align="center"><?=$lista_detalle[6];?></div></td>
              <td class="titulos_resumen_alertas"><div align="center">
                <?=listas_sin_select($g5,$lista_detalle[8],1);?>
              </div></td>
              
			  <? if($lista_detalle[13]==1){//si es la aprobada{ ?>
              <td class="titulos_resumen_alertas"><div align="right"><?=decimales_estandar($lista_detalle[9],2);?></div></td>
              
              <td   align="center"  class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <td   align="center"  class="titulos_resumen_alertas"><?=$fecha_fin_vi;?></td>
              <td align="center" class="titulos_resumen_alertas"><?=$modificada;?></td>
              <td align="center" class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
              <td class="titulos_resumen_alertas"><input type="button" name="button6" id="button6" value="Actualizar" onclick="muestra_div_o('espacio_<?=$lista_detalle[0];?>')"/></td>
              <? } //si es la aprobada
			  else
			  	{ //si NO es la aprobada ?>
              <td width="1%" class="titulos_resumen_alertas"><div  align="right"><?=decimales_estandar($lista_detalle[9],2);?></div></td>
              <td width="1%"  align="center"  class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <td   align="center"  class="titulos_resumen_alertas"><?=$fecha_fin_vi;?></td>
              <td width="1%"  align="center"  class="titulos_resumen_alertas"><?=$modificada;?></td>
              <td width="1%"  align="center" class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
				<td width="1%"  class="titulos_resumen_alertas">
                <? if($lista_detalle[13]==9){//si es la aprobada{ ?>
                <input type="button" name="button10" id="button10" value="Actualizar" onclick="muestra_div_o('espacio_<?=$lista_detalle[0];?>')"/>
                <? } ?> 

			 <? if($lista_detalle[13]==3){//si es la aprobada{ ?>
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
                    <? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion{ ?>
                    <select name="aprobacion_secundaria_<?=$lista_detalle[0];?>" id="aprobacion_secundaria_<?=$lista_detalle[0];?>" class="campos_tarifas_select">
                    <option value="0">Seleccione</option>
                    <!-- Pone siemopre de primero el gerente del contrato-->
             	 <option value="<?=$sql_con[14]?>"><? echo saca_nombre_lista($g1,$sql_con[14],'nombre_administrador','us_id');?></option>
             <!-- Pone siemopre de primero el gerente del contrato-->
          <? $sel_usuarios = query_db("select $g1.us_id, $g1.nombre_administrador from $g1 where  $g1.estado = 1 and $g1.tipo_usuario <> 2 and $g1.email like '%@hocol.com.co%' order by $g1.nombre_administrador"); 
		  while($sel_us = traer_fila_db($sel_usuarios)){
			  $busca_si_es_profesional = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos where id_usuario = ".$sel_us[0]." and id_permiso in (8,9, 20, 35, 43, 45)"));
			  
			  if($busca_si_es_profesional[0]==0 and ($sel_us[0] <> 17989 and $sel_us[0] <> 23 and $sel_us[0] <> 17 and $sel_us[0] <> 17931 and $sel_us[0] <> 17968 and $sel_us[0] <> 18056 and $sel_us[0] <> 62)){//si no es un profesional de abastecimiento
		  ?>
          <option value="<?=$sel_us[0]?>"><?=$sel_us[1]?></option>
          <?
			  }
		  }
		  ?>
                    </select>
                    <? } else echo listas_sin_select($g1,$busca_secundarios[0],1);
					
					 //si esta pendiente de aprobacion{ ?>                    </td>
                  </tr>
                  <tr>
                    <td align="right"><div align="right"><strong>Desea informarle a alguien adicional la modificaci&oacute;n de la  tarifa:</strong></div></td>
                    <td>
                     <? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion{ ?>
                    <select name="copia_<?=$lista_detalle[0];?>" id="copia_<?=$lista_detalle[0];?>" class="campos_tarifas_select" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/lista_usuarios_copia.php?act_cc=' + this.value + '&id_tarifa_pasa=<?=$lista_detalle[0];?>','carga_usuario_copia_<?=$lista_detalle[0];?>')">
                      <option value="0">Seleccione</option>
                      <option value="1" <? if($busca_secundarios_copia[0]>=1) echo "selected"; ?> >Si</option>
                      <option value="2" <? if($busca_secundarios_copia[0]==0) echo "selected"; ?> >No</option>
                    </select>
                    <? } else { 
					
					if($busca_secundarios_copia[0]>=1) echo "Si"; 
					else echo "No";
					
					}//si esta pendiente de aprobacion{ ?>                    </td>
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
                      <td align="right"><strong>
                      <?=TITULO_5;?> </strong>(No ingresar descripci&oacute;n solo  n&uacute;meros y/o letras) max 25 caracteres</td>
                      <td><input name="item_oferta_n_<?=$lista_detalle[0];?>" type="text" class="campos_tarifas" id="item_oferta_n_<?=$lista_detalle[0];?>" value="<?=$lista_detalle[4];?>" size="5" maxlength="25" /></td>
                  </tr>
                  <tr>
                      <td align="right"><strong><?=TITULO_4;?>:</strong></td>
                      <td><input name="unidad_n_<?=$lista_detalle[0];?>" type="text" class="campos_tarifas" id="unidad_n_<?=$lista_detalle[0];?>" size="5" value="<?=$lista_detalle[6];?>" /></td>
                  </tr>
                  <tr>
                      <td align="right"><strong><?=TITULO_7;?></strong></td>
                      <td><select name="moneda_n_<?=$lista_detalle[0];?>" class="campos_tarifas_select" id="moneda_n_<?=$lista_detalle[0];?>">
                        <?=listas($g5, " t1_moneda_id >=1",$lista_detalle[8],'nombre', 1);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td  width="20%"><div align="right"><strong>Nuevo valor (Hasta 5 decimales):</strong></div></td>
                    <td>
                     <? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
                    <input name="valor_tarifa_<?=$lista_detalle[0];?>" type="text" id="valor_tarifa_<?=$lista_detalle[0];?>"  class="campos_tarifas"  onkeyup='checkDecimals_2(this.name, this.value,this)' onpaste="return false;"/>
                    <? } //si esta pendiente de aprobacion
						else{ echo 		decimales_estandar($lista_detalle[9],2);				} ?>                    </td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Fecha de inicio de vigencia:</strong></div></td>
                    <td><span class="titulos_resumen_alertas">
                    <? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
                    <input name="vigencia_tarifa_<?=$lista_detalle[0];?>" type="text" id="vigencia_tarifa_<?=$lista_detalle[0];?>"  onmousedown="calendario_sin_hora('vigencia_tarifa_<?=$lista_detalle[0];?>')" class="campos_tarifas" /></span>
                    <? } //si esta pendiente de aprobacion
						else{ echo 	$lista_detalle[14];				} ?>                    </td>
                  </tr>
                  <tr>
                    <td><div align="right"><strong>Fecha de fin de vigencia, NO obligatorio<strong></strong>:</strong></div></td>
                    <td><? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
                    <input name="fin_vigencia_tarifa_<?=$lista_detalle[0];?>" type="text" id="fin_vigencia_tarifa_<?=$lista_detalle[0];?>"  onmousedown="calendario_sin_hora('fin_vigencia_tarifa_<?=$lista_detalle[0];?>')" class="campos_tarifas" /></span>
                    <? } //si esta pendiente de aprobacion
						else{ echo 	$lista_detalle[16];				} ?>    </td>
                  </tr>
                  
                  <tr>
                    <td align="right">La tarifa aplica descuento:</td>
                    <td>
                    <? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
                    <select name="descuento_uni_<?=$lista_detalle[0];?>" class="campos_tarifas_select" id="descuento_uni_<?=$lista_detalle[0];?>">
                      <option value="0">Seleccione</option>
                      <option value="1">Si</option>
                      <option value="2">No</option>
                    </select>
                    <? } else { 
				  	
					if($busca_soporte[4]==1) echo "Si";
					else echo "No";
				  
				  } ?>
                    </td>
                  </tr>
                  
                  <? if(busca_tarifas_convenciones($id_contrato_arr,3)==1){ ?>
                  <tr>
                    <td align="right"><strong>Modificaci&oacute;n por convencion:</strong></td>
                    <td><? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
                    <select name="modi_convencion_<?=$lista_detalle[0];?>" class="campos_tarifas_select" id="modi_convencion_<?=$lista_detalle[0];?>">
                      <option value="0">Seleccione</option>
                      <option value="1">Si</option>
                      <option value="2">No</option>
                    </select>
                    
                    <? } else {
						if($lista_detalle[18]==5) echo "Si";
					else echo "No";
						
						} ?></td>
                  </tr>
                  <? } else { ?>
                  	<input type="hidden" name="modi_convencion_<?=$lista_detalle[0];?>" id="modi_convencion_<?=$lista_detalle[0];?>" value="2" />
                    <? } ?>
                  <tr>
    <td width="20%"><div align="right"><strong>Observaciones (Con base en la tarifa que se est&aacute;  cargando):</strong></div></td>
    <td><? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
    <textarea name="observa_soporte_<?=$lista_detalle[0];?>" cols="10" rows="5" class="campos_tarifas" id="textarea"></textarea>
    <? } //si esta pendiente de aprobacion
						else{ echo 	$busca_soporte[2];				} ?>    </td>
    </tr>
 <? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
  <tr>
    <td width="20%" ><div align="right"><strong>Anexo soporte: <span class="titulo_calendario_real_mal">Solo anexos en formato .ZIP &oacute; .RAR</span></strong></div></td>
    <td><input type="file" name="anexo_soporte_<?=$lista_detalle[0];?>" id="fileField" /></td>
    </tr>
  <tr>
  <? } //si esta pendiente de aprobacion?>
    <td  width="20%"><div align="right"><strong>Anexo cargado:</strong></div></td>
    <td><a href="javascript:void(0)" onclick="javascript:window.parent.location.href='../aplicaciones/tarifas/proveedor/descarga_anexo_m.php?id_documen=<?=$busca_soporte[0];?>&n2=<?=$busca_soporte[3];?>'"><?=$busca_soporte[3];?></a> 
    <? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
    <img src="../imagenes/botones/b_cancelar.gif" width="16" height="16" title="Eliminar anexo" onclick="elimina_ane_modifica('<?=arreglo_pasa_variables($busca_soporte[0]);?>')" />
    <? } //si esta pendiente de aprobacion?>    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <? if($lista_detalle[13]==1){//si esta aprobada ?>
    <input type="button" name="button4" class="boton_grabar" id="button4" value="Grabar y confirmar Actualizaci&oacute;n de tarifa" onclick="edita_tarifa('<?=arreglo_pasa_variables($lista_detalle[0]);?>',document.principal.valor_tarifa_<?=$lista_detalle[0];?>.value,'')"/>
   <? } ?>
    <? if($lista_detalle[13]==9){//si no esta en firme ?>
    <input type="button" name="button9" class="boton_grabar" id="button9" value="Editar Actualizaci&oacute;n" onclick="edita_tarifa('<?=arreglo_pasa_variables($lista_detalle[0]);?>',document.principal.valor_tarifa_<?=$lista_detalle[0];?>.value,'')"/>
    <input type="button" name="button9" class="boton_eliminar" id="button9" value="Eliminar Actualizaci&oacute;n" onclick="elimina_creacion_tarifa('<?=arreglo_pasa_variables($lista_detalle[0]);?>')"/>

   <? } ?>
    <? if($lista_detalle[13]==3){//si esta pendiente de aprobacion ?>
    <input name="button2" type="button" class="boton_volver" id="button2" value="Cerrar detalle" onclick="oculta_div_o('espacio_<?=$lista_detalle[0];?>')" />
   <? } ?>
    <? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
    <input name="button8" type="button" class="boton_volver" id="button8" value="Cancelar Actualizaci&oacute;n" onclick="oculta_div_o('espacio_<?=$lista_detalle[0];?>')" />
   <? } ?></td>
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
      

<input type="hidden" name="inicio_contrato" value="<?=$sql_con[20];?>" />
<input type="hidden" name="vigencia_contrato" value="<?=$sql_con[21];?>" />
<input type="hidden" name="ruta_devuelve" value="c_tarifas_actualizar" />
</body>
</html>
