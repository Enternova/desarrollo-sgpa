<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	
	
	$busca_pre_temporal = "select * from $t16 where t6_tarifas_proveedor_prefactura_id = $id_prefactura";
	$sql_busca_temporal_pre_fa=traer_fila_row(query_db($busca_pre_temporal));
	
	$fecha_inicial = $sql_busca_temporal_pre_fa[8];
	$fecha_final = $sql_busca_temporal_pre_fa[9];

			$id_prefactura_general=$sql_busca_temporal_pre_fa[0];
			$consecutivo_factura=$sql_busca_temporal_pre_fa[5];
			$municipio_pre=$sql_busca_temporal_pre_fa[6];
			$proyecto_pre=$sql_busca_temporal_pre_fa[7];

	$busca_tarifas_descuento = traer_fila_row(query_db("select count(*) from $v_t_2 where tarifas_contrato_id = $id_contrato_arr and estado = 1"));		
	
	if($busca_tarifas_descuento[0]>=1) $tiene_descuento=1; else $tiene_descuento=0;

$busca_descuento = traer_fila_row(query_db("select * from $t21ta where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));	

$busca_aiu = traer_fila_row(query_db("select * from t6_tarifas_prefactura_aiu where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));

$aiu_a=$busca_aiu[2];
$aiu_a_p=$busca_aiu[3];
$aiu_i=$busca_aiu[4];
$aiu_i_p=$busca_aiu[5];
$aiu_u=$busca_aiu[6];
$aiu_u_p=$busca_aiu[7];

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
    </span></span>&gt;&gt;  EDICION DE TIQUETE DE SERVICIO</td>
    <td width="9%" class="titulos_secciones">    <input type="button" name="button5" class="boton_volver" id="button5" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/h_prefactura.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas')" /></td>
  </tr>
</table>
<br />
<table width="1300" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_2_sub">Rango de fechas del tiquete de servicio</td>
    <td colspan="2" class="fondo_2_sub">Lugar de ejecuci&oacute;n</td>
  </tr>
  <tr>
    <td valign="top"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td valign="top"><div align="justify"><strong>Buscar tarifas vigentes en este rango de fechas:</strong></div></td>
    <td width="2%"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td width="45%">Seleccione el municipio de ejecuci&oacute;n del servicio<strong>
      <input type="hidden" name="consecutivo_factura2" id="consecutivo_factura2" value="0" />
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top"><span class="fondo_5">ATENCION:</span> Si modifica el municipio, y graba esta informaci&oacute;n perder&aacute; las tarifas digitadas.</td>
  </tr>
  <tr>
    <td width="3%">&nbsp;</td>
    <td width="50%" valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="17%" align="right">Inicial:
          <div align="right"></div></td>
        <td width="30%"><input type="text" name="fecha_inicial" id="fecha_inicial" value="<?=$fecha_inicial;?>"  onmousedown="calendario_sin_hora('fecha_inicial')" /></td>
        <td width="12%" align="right">Final:</td>
        <td width="41%"><input type="text" name="fecha_final" id="fecha_final"  value="<?=$fecha_final;?>" onmousedown="calendario_sin_hora('fecha_final')" /></td>
      </tr>
      <tr>
        <td colspan="4"><p><span class="fondo_5">ATENCION:</span> Si modifica  el rango de fechas, la  informaci&oacute;n que digito ser&aacute; borrada a las tarifas que est&eacute;n fuera de la  vigencia.</p></td>
      </tr>
      <tr>
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="9%"><div align="right">Moneda del Tiquete:</div></td>
            <td width="35%"><select name="tp_moneda" id="tp_moneda">
              <option value="0">Seleccione</option>
              <option value="1" <? if($sql_busca_temporal_pre_fa[17]==1) echo 'selected="selected"';?> >COP</option>
              <option value="2" <? if($sql_busca_temporal_pre_fa[17]==2) echo 'selected="selected"';?>>USD</option>
            </select></td>
          </tr>
          <tr>
        <td colspan="2" style="font-weight: 900; font-size: 14px;"><img src="../imagenes/botones/icono_ayuda.png"></i><font face="roboto" color="#229BFF">Moneda  sobre la cual va a presentar su tiquete de servicio <br />
          &ldquo;SI VA A PRESENTAR SU TIQUETE DE SERVICIO &nbsp;EN LAS DOS MONEDAS DEBE  REALIZAR TIQUETES POR SEPARADO&rdquo;</font></td>
        </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4">
          <table width="98%" border="0">
            <tr class="tabla_lista_resultados">
              <? 
	
		if($sql_con[19]==1) echo '<input name="c_marco" type="hidden" value="2">'; ?>
              <? if($sql_con[19]==2){ echo '<input name="c_marco" type="hidden" value="1">'; ?>
              <td width="50%" align="right"><strong>Seleccione la orden de trabajo:</strong></td>
              <td width="46%" align="left" valign="top"><?
          	 $busca_ordenes = "select * from t7_contratos_complemento where id_contrato = $sql_con[13] and tipo_complemento = 2";
			$sql_ordenes = query_db($busca_ordenes);
			while($ls_orden=traer_fila_row($sql_ordenes)){
					if($sql_busca_temporal_pre_fa[16]==$ls_orden[25])
						$select_list = "selected";
					else $select_list="";
					$option_orden.="<option value='".$ls_orden[25]."' ".$select_list.">".$ls_orden[25]."</option>";
				}
				
		  ?>
                <select name="orden_trabajo">
                  <option value="">Seleccione</option>
                  <?=$option_orden;?>
                </select></td>
              <? } ?>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="4%">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="4"><div align="center">
          <input type="button" name="button3" class="boton_buscar" id="button3" value="Buscar tarifas vigentes en este rango de fechas" onclick="prefactura_temporal(2)" />
        </div></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
    <td valign="top"><select name="municipio_pre" id="municipio_pre"  onchange="ajax_carga('../aplicaciones/tarifas/proveedor/lista_proyectos.php?id_municipio=' + this.value,'carga_acciones_permitidas_municipios')" >
      <?=listas($t18, " estado = 1 ",$municipio_pre,'municipo', 2);?>
    </select>
    <br />
    <?
		$busca_proyectos=traer_fila_row(query_db("select count(*) from $t19 where t6_tarifas_municipios_id = $municipio_pre "));
		if($busca_proyectos[0]>=10) $class_div="scroll_div";
	
	?>
    <div id="carga_acciones_permitidas_municipios" class="<?=$class_div;?>">
 <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td colspan="2"  class="fondo_4">Seleccione los los proyectos donde aplicara las tarifas </td>
        </tr>
        <?
  	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
			$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
			if($busca_proyecto[0]!=""){ $chequeado="checked";
			$crea_titulo_columna.="<td class='fondo_3' width='5%'>".$l_pro[2]."</td>";
			}
			else $chequeado="";
				
$cuenta_atribu++;
  ?>
        <tr>
          <td width="3%"><input type="checkbox" name="ch_proyectos[]" value="<?=$l_pro[0];?>"  <?=$chequeado;?>/></td>
          <td width="97%"><div align="left">&nbsp;&nbsp;<?=$l_pro[2];?></div></td>
        </tr>
        <? } ?>
      </table>
    </div>
</td>
  </tr>
</table>
<br />
<table width="1300" border="0" cellpadding="0" cellspacing="0">
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
      <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/e_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura;?>&amp;lista_existentes=' + this.value,'carga_acciones_permitidas')">
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

<p>
  <?

if($lista_existentes>=1){//si ya selecciono una lista
$buscar_lista = traer_fila_row(query_db("select * from $t12 where t6_tarifas_listas_lista_id = $lista_existentes"));

			}
			
$bus_tarifa_c = " and t1_moneda_id = ".$sql_busca_temporal_pre_fa[17];
  if( ($categoria_existentes_busca!="no_apli_b") && ($categoria_existentes_busca!="") )
	  	$bus_tarifa_c.= " and categoria like '%".elimina_comillas_2(substr($categoria_existentes_busca,0,20))."%' ";		

	  if( ($grupo_existentes_busca!="no_apli_b") && ($grupo_existentes_busca!="") )
	  	$bus_tarifa_c.= " and grupo = '".elimina_comillas_2($grupo_existentes_busca)."' ";

	  if($detalle_ta_b!="")
	  	$bus_tarifa_c.= " and detalle like '%".elimina_comillas_2($detalle_ta_b)."%' ";

	  if($codigo_ta_b!="")
	  	$bus_tarifa_c.= " and codigo_proveedo like '%".elimina_comillas_2($codigo_ta_b)."%' ";


	$busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr";
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

 	 $sql_cuenta2 = "select  count(*) from  $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (1) and fecha_inicio_vigencia <= '$fecha_final' and t6_tarifas_listas_lista_id = $lista_existentes  $bus_tarifa_c";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );		
 
 
	    $nobre_categori_impri="";

	 	$busca_categorias = "";
		$nombre_gupo_imprime="";
 
 ?>
</p>
<input type="hidden" name="id_tarifa" />
<input type="hidden" name="id_an_e" />
<input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">    
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
<input type="hidden" name="id_contrato_pasa_java" value="<?=$id_contrato;?>" />

<input type="hidden" name="id_prefactura" value="<?=$id_prefactura;?>" />
<input type="hidden" name="nueva_busqueda" value="1" />
<input type="hidden" name="tipo_de_grabacion" />

<table width="98%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="fondo_2_sub">Buscador de tarifas</td>
  </tr>
  <tr>
    <td width="7%" align="right"><strong>Categoria:</strong></td>
    
    <td width="26%"><select name="categoria_existentes_busca" id="categoria_existentes_busca" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/grupo_ex.php?id_contrato_arr=<?=$id_contrato_arr;?>&categoria_trae=' + this.value + '&busca=1','grupo__xistente_busca')">
      <option value="no_apli_b" >Categorias existentes</option>
      <?
			 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id in (1,7) and fecha_inicio_vigencia <= '$fecha_final' and t6_tarifas_listas_lista_id = $lista_existentes ";
					$sql_cate=query_db($busca_categorias);
					while($lista_categoria=traer_fila_row($sql_cate)) {
						if($categoria_existentes_busca==$lista_categoria[0]) $select_c = "selected";
						else $select_c = "";
						
						echo "<option value='".$lista_categoria[0]."' ".$select_c.">".$lista_categoria[0]."</option>";
						
					}

			 ?>
    </select></td>
    <td width="16%" align="right"><strong>Grupo:</strong></td>
    <td width="17%" id="grupo__xistente_busca"><select name="grupo_existentes_busca" class="campos_tarifas" id="grupo_existentes_busca" >
      <option value="no_apli_b">Grupos existentes</option>
      <?
	   	if($categoria_existentes_busca_b!="no_apli_b"){
				 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '".elimina_comillas_2($categoria_existentes_busca)."'";
					$sql_cate=query_db($busca_grupos);
					while($lista_grupo_e=traer_fila_row($sql_cate)){
					if(elimina_comillas_2($grupo_existentes_busca)==elimina_comillas_2($lista_grupo_e[0])) $select_c = "selected";
						else $select_c = "";

						echo "<option value='".$lista_grupo_e[0]."' ".$select_c.">".$lista_grupo_e[0]."</option>";
						
					}
						
		}
			 
			 ?>
    </select></td>
    <td width="34%" id="grupo__xistente2">&nbsp;</td>
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
    <td colspan="5" align="center"><input name="button7" type="button" class="boton_buscar" id="button7" value="      Buscar tarifas      "  onclick="javascript:document.principal.pagina.value=1;busqueda_paginador_nuevo_tarifas_pro(1,'../aplicaciones/tarifas/proveedor/e_prefactura.php','carga_acciones_permitidas',<? echo (28+$cuenta_atribu); ?>)"/></td>
  </tr>
</table>
<p>&nbsp; </p>
<br />
 <?=busca_tarifas_aiu($id_contrato_arr,2);?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left"></div></td>
        <td width="7%"><div align="center">P&aacute;gina</div></td>
        <td width="8%"><select name="pagina" onchange="javascript:busqueda_paginador_nuevo_tarifas_pro(this.value,'../aplicaciones/tarifas/proveedor/e_prefactura.php','carga_acciones_permitidas',<? echo (28+$cuenta_atribu); ?>); prefactura_temporal(2, 'NO')">
          <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
          <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
            <?=$i;?>
            </option>
          <? } ?>
        </select></td>
        <td width="7%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
 
 <?


	 	    $busca_detalle = "select * from (
								select  * , ROW_NUMBER() OVER(ORDER BY categoria, grupo, tarifa_padre,fecha_creacion desc) AS rownum from $v_t_3 where  tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (1,7) and fecha_inicio_vigencia <= '$fecha_final' and (fecha_fin_vigencia >= '$fecha_inicial' or fecha_fin_vigencia = '0000-00-00' ) and t6_tarifas_listas_lista_id = $lista_existentes and t6_tarifas_estados_tarifas_id in (1) $bus_tarifa_c
								) as sub
	where rownum > $inicio and rownum <= $factor_b";
	
	


	
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas
		
				if($nobre_categori_impri!=$lista_detalle[2]){//si la categoria es una sola
					 $nombre_boto+=1;
						if(chop($lista_detalle[2])<>""){//si la categoria tiene algo ?>
					<br />
	 
	                       <table width="98%" border="0">
                          <tr>
                            <td class="titulos_secciones" width="10%">Categoria: </td>
                            <td class="titulos_secciones" width="47%"><?=$lista_detalle[2];?></td>
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
                                <td width="52%"><?=$lista_detalle[3];?></td>
                                </tr>
                            </table>
                              <?
								}//si el grupo trae algo	
								
								
								?>
                                
                               <table  width="100%" border=0 cellspacing="2" cellpadding="2"  bgcolor="white" >  
                               <tr>
                                      <td width="1%" class="fondo_3">Obser.</td>
                                      <td  class="fondo_3" width="3%"><div align="center">
                                    <?=TITULO_CONSECUTIVO;?></div></td>
                                      <td  class="fondo_3" width="3%"><div align="center">
                                        <?=TITULO_5;?>
                                      </div></td>
                                      <td width="27%" class="fondo_3"><div align="center">
                                        <?=TITULO_6;?>
                                      </div></td>
                                      <td width="6%" class="fondo_3"><div align="center">
                                        <?=TITULO_4;?>
                                      </div></td>
                                      <td width="11%" class="fondo_3"><div align="center">
                                        <?=TITULO_8;?>
                                      </div></td>
                                      <td width="6%" class="fondo_3"><div align="center"><?=TITULO_9;?></div></td>
                                       <td width="6%" class="fondo_3"><div align="center"><?=TITULO_18;?></div></td>
                                      <?=$crea_titulo_columna;?>
             
					            </tr>
                                
                                
                                <?
								
								
								}//si ya imprimio el grupo
	
	
								
								
		if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';

		$cantidad="";
		$observa="";
	

	$crea_campo_columna="";
//  	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
 	 $busca_proyectos="select t6_tarifas_prefactura_proyectos_id, proyecto from v_tarifas_municipio_proyecto_prefactura where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_municipios_id = $municipio_pre order by proyecto";

	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
	//		$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
			//if($busca_proyecto[0]!=""){ //if mal
			$chequeado="checked";
	 		$cantidad="";
			$observa="";
	
					 $busca_tarifa_tem="select * from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id=$lista_detalle[0] and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final'  and t6_tarifas_prefactura_proyectos_id = $l_pro[0] ";
					$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
					$cantidad=$busca_tari_tem[5];
					$observa=$busca_tari_tem[10];


		
			
		
			$crea_campo_columna.="<td ><input name='cantidad_tarifa[".$lista_detalle[0]."_".$lista_detalle[15]."_".$l_pro[0]."]' type='text' id='cantidad_tarifa[".$lista_detalle[0]."_".$lista_detalle[15]."_".$l_pro[0]."]' size='5' value='".$cantidad."' onkeyup='checkDecimals_2(this.name, this.value,this)'/></td>";
			//if mal }
			}
			
		if($lista_detalle[19] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$lista_detalle[19];	
	 ?> 
            
            <tr class="filas_resultados">
              <td align="center"><img src="../imagenes/botones/b_guardar.gif" width="16" height="16" alt="Comentarios a la tarifa" title="Comentarios a la tarifa" onclick="muestra_div_o('observaciones_tarifas_<?=$lista_detalle[0];?>')" /></td>
              <td><div align="<?=alinea_CONSECUTIVO;?>"><?=$lista_detalle[28];?></div></td>
              <td><div align="center">
                <?=$lista_detalle[4];?>
              </div></td>
              <td ><?=$lista_detalle[5];?></td>
              <td><div align="center"><?=$lista_detalle[6];?></div></td>
              <td class="titulos_resumen_alertas"><div align="right">$ <?=decimales_estilo($lista_detalle[9],2);?> 
                <?=$lista_detalle[18];?>
              </div></td>
              <td class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <td class="titulos_resumen_alertas"><?=$fecha_fin_vi;?></td>
             <?=$crea_campo_columna;?>
            </tr>
                        <?
			$busca_observa= "select detalle from t6_tarifas_proveedor_prefactura_observaciones where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id = $lista_detalle[0]";
			$bus_ob_ta_r=traer_fila_row(query_db($busca_observa));

			  $busca_anexo= "select detalle,t6_tarifas_proveedor_prefactura_anexos_id from t6_tarifas_proveedor_prefactura_anexos    where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id = $lista_detalle[0]";
			$bus_an_ta=traer_fila_row(query_db($busca_anexo));
			?>
          
            <tr id="observaciones_tarifas_<?=$lista_detalle[0];?>" style="display:none">
              <td colspan="4"><textarea name="observac[<?=$lista_detalle[0];?>]" cols="45" rows="2" class="campos_tarifas" id="textarea"><?=$bus_ob_ta_r[0];?></textarea><p />
              Si presenta descuentos esta tarifa, desde aqui puede anexar documento de soporte:
              <input name="soporte_desc_<?=$lista_detalle[0];?>" type="file" class="campos_tarifas"/>
              <? if($bus_an_ta[0]!=""){?>
              <br /> <span class="letra-descuentos">Anexo existente para esta tarifa:</span>
              <strong>
              <a href="javascript:void(0)" onclick="javascript:window.parent.location.href='descarga_ane_desc_<?=$bus_an_ta[1];?>.html'"><?=$bus_an_ta[0];?></a>
             
              <img src="../imagenes/botones/b_cancelar.gif" width="16" height="16" title="Eliminar anexo" onclick="elimina_ane_descue(<?=$bus_an_ta[1];?>)" /></strong> 
			  <? } //anexo ?></td>
              <td class="titulos_resumen_alertas"><input name="button2" type="button" class="boton_eliminar" id="button2" value="Cerrar comentario" onclick="oculta_div_o('observaciones_tarifas_<?=$lista_detalle[0];?>')" /></td>
              <td class="titulos_resumen_alertas">&nbsp;</td>
            </tr>
  
            
            
            <?								
								
								
								
								
								
								
								$nombre_gupo_imprime=$lista_detalle[3];
							
							
							if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo cierra tabla
							
							?> </table> <?
							
							}//si ya imprimio el grupo cierra tabla
							
								
						} //todas las tarifas
								?>
                            
                            
                            
                            
     <table width="1300" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_4"><img src="../imagenes/botones/help.gif" width="18" height="18" />
    <? if($tiene_descuento==1) echo "Este contrato tiene descuentos pactos por favor digite el valor total del descuento, en caso de no aplicar digite el valor cero (0) y el comentario de la no aplicación del descuento";
	else echo "Este contrato NO tiene descuentos, sin embargo si desea aplicar un descuento digite el valor total y el comentario del descuento";
	?>
    </td>
    </tr>
  <tr>
    <td width="31%"><div align="right">Digite el valor total del descuento si aplica:</div></td>
    <td width="69%"><input type="text" name="valor_descuento" id="valor_descuento" value="<?=chop($busca_descuento[2]);?>" onkeyup="checkDecimals_2(this.name, this.value,this)" /></td>
  </tr>
  <tr>
    <td><div align="right">Observaciones del descuento:</div></td>
    <td><textarea name="detalle_descuento" id="detalle_descuento" cols="45" rows="5"><?=chop($busca_descuento[3]);?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<input name="aiu_a" type="hidden" value="3" onkeyup="checkDecimals(this.name, this.value,this)" />
<input name="aiu_a_p" type="hidden" value="<?=$aiu_a_p;?>" onkeyup="checkDecimals(this.name, this.value,this)" />
<input name="aiu_i" type="hidden" value="3" onkeyup="checkDecimals(this.name, this.value,this)" />
<input name="aiu_i_p" type="hidden" value="<?=$aiu_i_p;?>" onkeyup="checkDecimals(this.name, this.value,this)" />
<input name="aiu_u" type="hidden" value="3" onkeyup="checkDecimals(this.name, this.value,this)" />
<input name="aiu_u_p" type="hidden" value="<?=$aiu_u_p;?>" onkeyup="checkDecimals(this.name, this.value,this)" />
<br />
<table width="1300" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="fondo_2_sub" valign="top">Confirmar de creaci&oacute;n del tiquete      </td>
  </tr>
  <tr>
    <td width="4%"><img src="../imagenes/botones/envia_confirmacion.gif" alt="Enviar confirmacion" width="32" height="32" /></td>
    <td width="96%" colspan="2" align="left"><span class="fondo_5">ATENCION:</span> <strong>Solo si ya esta seguro de haber terminado la selecci&oacute;n de tarifas para el tiquete de servicio, presione el siguiente bot&oacute;n &quot;Confirmar creaci&oacute;n de tiquete de servicio&quot;, esta acci&oacute;n creara el documento de tiquete de servicio; Si no ha terminado no  ejecute el boton siga seleccionando tarifas el sistema guardara las creaciones incluso si sale del sistema.</strong></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left"><input type="button" name="button4" class="boton_edicion" id="button4" value="Grabar tiquete de servicio temporalmente" onclick="prefactura_temporal(2, 'SI')" /><input type="button" name="button6" class="boton_edicion" id="button6" value="Vista previa del tiquete de servicio" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura;?>','carga_acciones_permitidas');" /></div></td>
    <td width="25%"><input type="button" name="button" class="boton_grabar" id="button" value="Confirmar creaci&oacute;n de tiquete de servicio" onclick="confirma_creacion(<?=$tiene_descuento;?>,1)" /></td>
  </tr>
</table>                            
          
        

<? } else { ?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><strong><img src="../imagenes/botones/help.gif" alt="El contrato no tiene tarifas cargadas hasta el momento" width="18" height="18" title="El contrato no tiene tarifas cargadas hasta el momento" /></strong> El contrato no tiene tarifas cargadas hasta el momento</td>
  </tr>
</table>

 <?
 } // si no tiene tarifas
 
 ?>


<input type="hidden" name="muestra_alerta"  />

</body>
</html>
