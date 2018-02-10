<? include("../../librerias/lib/@session.php"); 
	//verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="91%" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> CONSULTA DE APROBACIONES &gt;&gt; CONTRATO:
      <?=$sql_con[7];?>
    </span></td>
    <td width="9%" ><span class="titulos_secciones"><input type="button" name="button4" class="boton_volver"  id="button4" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></span></td>
  </tr>
  <?
  if($_SESSION["tipo_usuario"] <> 2){
  ?>
  <tr>
    <td colspan="2" ><? echo encabezado_contrato_tarifas($id_contrato_arr);?></td>
  </tr>
  <?
  }
  ?>
</table>

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
<input type="hidden" name="id_contrato" id="id_contrato" value="<?=$id_contrato;?>" />
  
    <?
if($lista_existentes==""){//si no  selecciono una lista

$selec_lista = traer_fila_row(query_db("select * from $t12 where tarifas_contrato_id = $id_contrato_arr"));
$lista_existentes = $selec_lista[0];
}//si no  selecciono una lista  
  
  ?>
  <tr>
    <td width="5%" height="22" valign="top" class="fondo_6"><img src="../imagenes/botones/nuevo_descriptor.gif" alt="Nuevo descriptor" width="32" height="32" /></td>
    <td colspan="2" valign="top" class="fondo_6" ><div align="left">SELECCIONE UNA LISTA:
        <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/h_aprobaciones.php?id_contrato=<?=$id_contrato;?>&lista_existentes=' + this.value,'carga_acciones_permitidas')">
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

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td class="fondo_5"><strong>Usted ha seleccionado la lista:<?=$buscar_lista[2];?></strong></td>
  </tr>
</table>

  <br />
  <?

 if( ($categoria_existentes!="no_apli_b") && ($categoria_existentes!="") )
	  	$bus_tarifa_c = " and categoria = '".elimina_comillas_2($categoria_existentes)."' ";

	  if( ($grupo_existentes!="no_apli_b") && ($grupo_existentes!="") )
	  	$bus_tarifa_c.= " and grupo = '".elimina_comillas_2($grupo_existentes)."' ";

	  if($detalle_ta_b!="")
	  	$bus_tarifa_c.= " and detalle like '%".elimina_comillas_2($detalle_ta_b)."%' ";

	  if($codigo_ta_b!="")
	  	$bus_tarifa_c.= " and codigo_proveedor like '%".elimina_comillas_2($codigo_ta_b)."%' ";
	  if($str_consecutivo_bus!="")
	  	$bus_tarifa_c.= " and consecutivo_tarifa in ($str_consecutivo_bus) ";
			  
if($estado_busca == 0){ $bus_tarifa_c.= "";}//SI SELECCIONA VER TODAS
if($estado_busca == 1 or $estado_busca == ""){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (2, 3) and (creada_luego_firme = 2 or creada_luego_firme is null)";}//SI SELECCIONA VER LAS PENDIENTES

if($estado_busca == 2){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1, 7) and (creada_luego_firme = 2 or creada_luego_firme is null) ";}//SI SELECCIONA VER LAS APROBADAS POR HOCOL TODAS

if($estado_busca == 21){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1) and (creada_luego_firme = 2 or creada_luego_firme is null) and (fecha_fin_vigencia >= '$fecha' or fecha_fin_vigencia = '0000-00-00' ) ";}//SI SELECCIONA VER LAS APROBADAS POR HOCOL ACTIVAS

if($estado_busca == 22){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1, 7) and (creada_luego_firme = 2 or creada_luego_firme is null) and (fecha_fin_vigencia < '$fecha'  ) ";}//SI SELECCIONA VER LAS APROBADAS POR HOCOL INACTIVAS


if($estado_busca == 3){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (4, 5, 6, 10) and (creada_luego_firme = 2 or creada_luego_firme is null)";}//SI SELECCIONA VER LAS RECHAZADAS / DEVUELTAS
if($estado_busca == 4){ $bus_tarifa_c.= " and (creada_luego_firme = 1)";}//SI SELECCIONA VER LAS CONTRACTUALES
if($estado_busca == 5){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (11)";}//SI SELECCIONA VER LAS INHABILITADAS

//correccion de listado en el inc015-18 inicio
if($estado_busca == 6){ $bus_tarifa_c.= " and t6_tarifas_estados_tarifas_id in (1) and fecha_fin_vigencia < '$fecha' and  fecha_fin_vigencia <> '0000-00-00' ";}//SI SELECCIONA VER VENCIDAS
//correccion de listado en el inc015-18 fin
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

  $sql_cuenta2 = "select  count(*) from  $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_listas_lista_id = $lista_existentes $bus_tarifa_c";

	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );			
			
			?>
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
    <td width="18%" align="right"><strong>Categoria:</strong></td>
    <td width="30%"><select name="categoria_existentes" id="categoria_existentes" onchange="ajax_carga('../aplicaciones/tarifas/carga_grupos_existentes.php?id_contrato_arr=<?=$id_contrato_arr;?>&amp;categoria_trae=' + this.value,'grupo__xistente')">

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
    <td width="13%" align="right"><strong>Grupo:</strong></td>
    <td width="22%" id="grupo__xistente"><select name="grupo_existentes" class="campos_tarifas" id="grupo_existentes" >
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
    <td width="17%" id="grupo__xistente">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>
      <?=TITULO_5;?>
    :</strong></td>
    <td><input type="text" name="codigo_ta_b" id="codigo_ta_b" value="<?=$codigo_ta_b;?>" /></td>
    <td align="right"><strong>Detalle:</strong></td>
    <td colspan="2"><input type="text" name="detalle_ta_b" id="detalle_ta_b" value="<?=$detalle_ta_b;?>"/></td>
  </tr>
  <tr>
    <td align="right"><strong>Estado</strong></td>
    <td><select name="estado_busca" id="estado_busca">
    <option value="0" >Ver Todas las Tarifas</option>
       <option value="1" <? if($estado_busca == 1 or $estado_busca == "") echo "selected"?> >Tarifas Pendientes de Aprobaci&oacute;n</option>
         <option value="2" <? if($estado_busca == 2) echo "selected"?> >Tarifas cargadas por el Contratista (Todas)</option>
         <option value="21" <? if($estado_busca == 21) echo "selected"?> >Tarifas cargadas por el Contratista (Vigentes)</option>
         <option value="22" <? if($estado_busca == 22) echo "selected"?> >Tarifas cargadas por el Contratista (Vencidas)</option>
         <option value="3" <? if($estado_busca == 3) echo "selected"?> >Tarifas Rechazadas por Hocol</option>
         <option value="4" <? if($estado_busca == 4) echo "selected"?> >Tarifas Contractuales Cargadas por Hocol</option>
         <option value="5" <? if($estado_busca == 5) echo "selected"?> >Tarifas Inhabilitadas por Hocol</option>
		<option value="6" <? if($estado_busca == 6) echo "selected"?> >Tarifas Vencidas</option>         
       
      </select></td>
    <td align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><input name="button" type="button" class="boton_buscar" id="button" value="      Buscar tarifas      "  onclick="javascript:document.principal.pagina.value=1;busqueda_paginador_nuevo_tarifas(1,'../aplicaciones/tarifas/h_aprobaciones.php','carga_acciones_permitidas',20)"/></td>
  </tr>
</table>
<p>&nbsp; </p>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel='se refiere a tarifas cargadas en el inicio del contrato' />Se refiere a tarifas cargadas en el inicio del contrato, <img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" /> se refiere a tarifas cargadas posteriormente del inicio del contrato</td>
  </tr>
</table>


<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="columna_titulo_resultados">
    
    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="4%"><div align="center">P&aacute;gina</div></td>
        <td width="12%">
          <select name="pagina" id="pagina" onchange="javascript:busqueda_paginador_nuevo_tarifas(this.value,'../aplicaciones/tarifas/h_aprobaciones.php','carga_acciones_permitidas',50)">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina <?=$i;?> </option>
            <? } ?>
          </select>
        </td>
        <td width="86%"><span class="letra-descuentos">Total de tarifas:
            <?=number_format($sql_cuenta[0],0);?>
        </span></td>
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
								select * , ROW_NUMBER() OVER(ORDER BY categoria, grupo, tarifa_padre, fecha_creacion desc) AS rownum from $v_t_3 where tarifas_contrato_id = $id_contrato_arr   and t6_tarifas_listas_lista_id = $lista_existentes   $bus_tarifa_c
								) as sub
	where rownum > $inicio and rownum <= $factor_b";
	
	if($_SESSION["id_us_session"] == 32)
	{
		//echo $busca_detalle;
	}
	
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
		elseif($lista_detalle[22]==5)
		{ 			
			$tipo_modifica="Convencion";
			$class_tipo="tarifas_ipc";
		}
		
		
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
                                <td width="5%" class="titulos_secciones">Grupo:</td>
                                <td width="52%" class="titulos_secciones"><?=$lista_detalle[3];?>
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
											
												
									<table border="0" cellspacing="2" cellpadding="2" width="100%" >                	
								
											<tr>
																			<th width="3%" class="fondo_3" align="center"><?=TITULO_1;?></th>
											<th width="3%" class="fondo_3" align="center"><?=TITULO_CONSECUTIVO;?></th>
											<th width="13%" class="fondo_3" align="center"><?=TITULO_2;?></th>
											<th width="13%" class="fondo_3" align="center"><?=TITULO_3;?></th>
											<th width="4%" class="fondo_3" align="center"><?=TITULO_4;?></th>
											<th width="4%" class="fondo_3" align="center"><?=TITULO_5;?></th>
											<th width="30%" class="fondo_3" align="center"><?=TITULO_6;?></th>
										    <th width="4%" class="fondo_3" align="center"><?=TITULO_7;?></th>
											<th width="10%" class="fondo_3" align="center"><?=TITULO_8;?></th>
											<th width="6%" class="fondo_3" align="center"><?=TITULO_9;?></th>
                                            <th width="6%" class="fondo_3" align="center"><?=TITULO_18;?></th>
                                            <th width="6%" class="fondo_3" align="center"><?=TITULO_14;?></th>
											<th width="5%" class="fondo_3" align="center"><?=TITULO_12;?></th>
											<th width="5%" class="fondo_3" align="center"><?=TITULO_15;?></th>
											</tr>
											
												 <?
			
			
			
			
							}//si ya imprimio el grupo


					
	if($lista_detalle[22]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';
	
           if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
	 	$estado_tarifa="";
//echo "select t6_tarifas_lista_id, nombre_estado_tarifa from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15]  order by t6_tarifas_lista_id desc";
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
		$anexo="";
	$estado_tarifa_imprime = saca_nombre_lista("t6_tarifas_estados_tarifas",$lista_detalle[13],'nombre',' t6_tarifas_estados_tarifas_id');
	
	
	if( ($lista_detalle[19] != '0000-00-00') && ($lista_detalle[19] < $fecha and ($lista_detalle[13] != 7 and $lista_detalle[13] != 4)))
			{
			$estado_tarifa_imprime="Vencida";
				}

		if($lista_detalle[19] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$lista_detalle[19];
	
	if($lista_detalle[13]==11){
		
		if($lista_detalle[26] != "" and $lista_detalle[26] != " "){
		$anexo='<a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2='.$lista_detalle[26].'&n1='.$lista_detalle[0].'&n3=tarifas_inhabilita" target="grp"><img src="../imagenes/mime/'.saca_extencion_archivo($lista_detalle[26]).'.gif" width="16" height="16" /> '.$lista_detalle[26].'</a>';
        $estado_tarifa_imprime = $estado_tarifa_imprime."; ".$lista_detalle[25]." ".$anexo;
		}
		

		$sel_inhabilita_masivo = traer_fila_row(query_db("select TOP (1) t2.ob_inhabilitada, t2.adjunto_inhabilita, t2.id from t6_tarifas_inhabilitadas_relacion t1,  t6_tarifas_inhabilitadas t2 where t1.id_tarifas_inhabilitar = t2.id  and t1.t6_tarifas_lista_id = ".$lista_detalle[0]." order by t2.id desc"));
		if($sel_inhabilita_masivo[1] != "" and $sel_inhabilita_masivo[1] != " "){
		$anexo='<a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2='.$sel_inhabilita_masivo[1].'&n1='.$sel_inhabilita_masivo[2].'&n3=tarifas_inhabilita" target="grp"><img src="../imagenes/mime/'.saca_extencion_archivo($sel_inhabilita_masivo[1]).'.gif" width="16" height="16" /> '.$sel_inhabilita_masivo[1].'</a>';
		$estado_tarifa_imprime = $estado_tarifa_imprime."; ".$sel_inhabilita_masivo[0]." ".$anexo;
		}
	}

		

	$ayuda_campo_editar="";
	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$busca_valores = traer_fila_row(query_db("select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]"));
	$ayuda_campo_editar.='<td >'.$busca_valores[3].'</td>';
	
	} //lista atributos									
		
		
 ?> 

            <tr class="<?=$class;?>" >
              <td height="30" align="center" ><?=$tipo_creacion;?></td>
              <td align="center" ><div align="<?=alinea_CONSECUTIVO;?>"><?=$lista_detalle[28];?></div></td>
              <td ><?=$lista_detalle[2];?></td>
              <td ><?=$lista_detalle[3];?></td>
              <td ><?=$lista_detalle[6];?></td>
              <td ><?=$lista_detalle[4];?></td>
                        <td ><?=$lista_detalle[5];?></td>

              <td align="center" class="titulos_resumen_alertas"><div align="center">
              <?=listas_sin_select($g5,$lista_detalle[8],1);?>
</div></td>
              <td align="center" class="titulos_resumen_alertas"><div align="center"><?=decimales_estandar($lista_detalle[9],2);?>
              </div></td>
              
              <td align="center" class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
               <td align="center" class="titulos_resumen_alertas"><?=$fecha_fin_vi;?></td>
               <td align="center" class="titulos_resumen_alertas"><div align="center" class="<?=$class_tipo;?>">
                 <?=$tipo_modifica;?>
               </div></td>
              <td align="center" class="titulos_resumen_alertas"><?=$estado_tarifa_imprime;?></td>

            
              <td class="titulos_resumen_alertas"><div align="center"><img src="../imagenes/botones/b_guardar.gif" alt="ver atibutos de la tarifa" title="ver atibutos de la tarifa" width="16" height="16" onclick="ajax_carga('../aplicaciones/tarifas/reporte_tarfifas_actualizada.php?id_contrato=<?=$id_contrato;?>&id_tarifa=<?=$lista_detalle[0];?>&ruta_apro=1&estado_busca='+document.principal.estado_busca.value+'&categoria_existentes='+document.principal.categoria_existentes.value+'&grupo_existentes='+document.principal.grupo_existentes.value+'&codigo_ta_b='+document.principal.codigo_ta_b.value+'&detalle_ta_b='+document.principal.detalle_ta_b.value+'&lista_existentes='+document.principal.lista_existentes.value+'&str_consecutivo_bus='+document.principal.str_consecutivo_bus.value,'carga_acciones_permitidas')" /></div></td>
            </tr>
            
			<tr>
            <td colspan="13">
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
                        
             <td width="9%"></td>
           <? $num_fila++; 							
							
							
							
							
							
							
							
							
							
							
							
							
							
							$nombre_gupo_imprime=$lista_detalle[3];
							
							
							if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo cierra tabla
							
							?> </table> 
<p>
					    <?
							
							}//si ya imprimio el grupo cierra tabla
							
		
		}//todas las tarifas
 
 
 
     } //si ya selecciono una lista ?>
									  
									  
</p>
		<? if($id_ingreso[0]>=1){ ?>
           <table width="100%" border="0">
		     <tr>
		       <td align="center"><input name="button3" type="button" class="boton_buscar" id="button3" value="Exportar resultado a excel"  onclick="javascript:exporta_tarifas_consulta()" /></td>
	         </tr>
</table>

<? } ?>
        <p>&nbsp;</p>
           
           <input type="hidden" name="tipo_reporte" id="tipo_reporte" value="h_aprobaciones" />
           
</body>
</html>
