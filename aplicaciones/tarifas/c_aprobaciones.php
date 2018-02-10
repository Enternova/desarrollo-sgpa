<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	
	
$comple_filtro = " and us_aprobacion_actual in (".$_SESSION["usuarios_con_reemplazo"].") ";	

if( $tipo_modificacion>=1)			
	$comple_filtro.= " and tipo_creacion_modifica = $tipo_modificacion ";

if( $detalle_ta_b!="")			
	$comple_filtro.= " and detalle like '%$detalle_ta_b%' ";

if( ( $categoria_existentes!="no_apli_b") && ( $categoria_existentes!="")	)
	$comple_filtro.= " and categoria = '$categoria_existentes' ";

if ( $codigo_ta_b!="")
	$comple_filtro.= " and codigo_proveedor like '%$codigo_ta_b%' ";


	
if( ( $grupo__xistente!="no_apli_b")  && ( $grupo__xistente!="")	)
	$comple_filtro.= " and grupo = '$grupo__xistente' ";	
	  if($str_consecutivo_bus!="")
	  	$comple_filtro.= " and consecutivo_tarifa in ($str_consecutivo_bus) ";	


	$factor_b_c = 30;
	$factor_b = 30;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

  $sql_cuenta2 = "select  count(*) from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (2,3) $complemnto_secundarios $comple_filtro";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );			


			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="carga_acciones_permitidas">
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="91%" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> APROBACIONES DE TARIFAS PENDIENTES &gt;&gt; CONTRATO:<?=numero_cotnrato_tarifas($id_contrato_arr);?></span></td>
          <td width="9%" ><input type="button" name="button5" class="boton_volver"  id="button5" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></td>
        </tr>
        <tr>
          <td colspan="2" valign="top" ><? echo encabezado_contrato_tarifas($id_contrato_arr);?></td>
        </tr>
      </table>
      <?
			$busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id in (2,3)  $comple_filtro ";// se quito el $comple_filtro por que si no encuentra nada desaparece los filtros
			$id_ingreso=traer_fila_row(query_db($busca_categorias));
			if($id_ingreso[0]>=1){//si tiene tarifas por aprobar;
			?>
            
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><br />
      <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr >
          <td width="1%" ><img src="../imagenes/botones/si_tiene_aprobaciones.gif" alt=" Historico de tarifas de este contrato pendientes de su aprobaci&oacute;n" title=" Historico de tarifas de este contrato pendientes de su aprobaci&oacute;n" /></td>
          <td width="99%" class="fondo_4">Atenci&oacute;n: <strong>Antes de Aprobar por favor revise con ABASTECIMIENTO el saldo y alcance del contrato, &nbsp;&nbsp;esta modificaci&oacute;n &oacute; inclusi&oacute;n &nbsp;puede requerir Aprobaciones internas</strong></td>
        </tr>
    </table>
      <br />
      <table width="99%" border="0" class="tabla_lista_resultados">
        <tr>
          <td colspan="5" class="fondo_2_sub">Buscador de tarifas</td>
        </tr>
        <tr>
          <td align="right"><?=TITULO_CONSECUTIVO;?>
            :</td>
          <td><input type="text" name="str_consecutivo_bus" id="str_consecutivo_bus" value="<?=$str_consecutivo_bus;?>" /></td>
          <td colspan="3"><?=ayuda_CONSECUTIVO;?></td>
        </tr>
        <tr>
          <td align="right"><strong>
            <?=TITULO_5;?>
          </strong>:</td>
          <td><input type="text" name="codigo_ta_b" id="codigo_ta_b" value="<?=$codigo_ta_b;?>" /></td>
          <td align="right">&nbsp;</td>
          <td id="grupo__xistente3">&nbsp;</td>
          <td id="grupo__xistente3">&nbsp;</td>
        </tr>
        <tr>
          <td width="14%" align="right"><strong>Categoria:</strong></td>
          <td width="24%"><select name="categoria_existentes" id="categoria_existentes" onchange="ajax_carga('../aplicaciones/tarifas/carga_grupos_existentes.php?id_contrato_arr=<?=$id_contrato_arr;?>&amp;categoria_trae=' + this.value,'grupo__xistente')">
            <option value="no_apli_b" >Categorias existentes</option>
            <?
			 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id in (2,3) $comple_filtro ";
					$sql_cate=query_db($busca_categorias);
					while($lista_categoria=traer_fila_row($sql_cate)) {
						if($categoria_existentes==$lista_categoria[0]) $select_c = "selected";
						else $select_c = "";
						
						echo "<option value='".$lista_categoria[0]."' ".$select_c.">".$lista_categoria[0]."</option>";
						
					}

			 ?>
            </select></td>
          <td width="11%" align="right"><strong>Grupo:</strong></td>
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
          <td colspan="5" align="center"><input name="button3" type="button" class="boton_buscar" id="button3" value="      Buscar tarifas      "  onclick="busqueda_paginador_nuevo_tarifas(1,'../aplicaciones/tarifas/c_aprobaciones.php','carga_acciones_permitidas',50)"/></td>
        </tr>
      </table>
      <br />
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="5" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
            <tr>
              <td width="4%"><div align="center">P&aacute;gina</div></td>
              <td width="12%"><select name="pagina" onchange="javascript:busqueda_paginador_nuevo_tarifas(this.value,'../aplicaciones/tarifas/c_aprobaciones.php','carga_acciones_permitidas',12)">
                <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
                <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
                  <?=$i;?>
                  </option>
                <? } ?>
              </select></td>
              <td width="86%"><span class="letra-descuentos">Total de tarifas:
                <?=number_format($sql_cuenta[0],0);?>
              </span></td>
            </tr>
          </table></td>
        </tr>
    </table>
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td>
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              
                <tr>
                  <td width="2%" rowspan="2" class="fondo_3" align="center"><?=TITULO_CONSECUTIVO;?></td>
                  <td width="5%" rowspan="2" class="fondo_3"><div align="center"><?=TITULO_5;?></div></td>
                  <td width="15%" rowspan="2" class="fondo_3"><div align="center"><?=TITULO_6;?></div></td>
                  <td width="3%" rowspan="2" class="fondo_3"><div align="center"><?=TITULO_7;?></div></td>
                  <td width="9%" rowspan="2" class="fondo_3"><div align="center">Valor actual</div></td>
                  <td width="9%" rowspan="2" class="fondo_3"><div align="center">Nuevo valor</div></td>
                  <td width="5%" rowspan="2" class="fondo_3"><div align="center"><?=TITULO_9;?></div></td>
                  <td width="5%" rowspan="2" class="fondo_3"><div align="center">
                    <?=TITULO_18;?>
                  </div></td>
                  <td width="6%" rowspan="2" align="center" class="fondo_3">Concepto</td>
                  <td width="6%" rowspan="2" class="fondo_3"><div align="center">Aprobaci&oacute;n</div></td>
                  <td width="10%" rowspan="2" class="fondo_3"><div align="center">Observaciones / Anexos</div></td>
                  <td colspan="2" class="fondo_3"><div align="center">Ultima aprobaci&oacute;n</div></td>
                  <td width="2%" rowspan="2" class="fondo_3"><div align="center">Detalle de la tarifa</div>                    <div align="center"></div></td>
                </tr>
                <tr>
                  <td width="6%" class="fondo_3"><div align="center">Usuario</div></td>
                  <td width="6%" class="fondo_3"><div align="center">Fecha</div></td>
                </tr>
                <?

		


$busca_detalle = "select * from ( select   t6_tarifas_lista_id, tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, 
                      tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia, tarifa_padre, nombre_estado_tarifa, descripcion, moneda, fecha_fin_vigencia, 
                      t6_tarifas_listas_lista_id, nombre, tipo_creacion_modifica, us_aprobacion_actual, creada_luego_firme,consecutivo_tarifa
 , ROW_NUMBER() OVER(ORDER BY fecha_creacion desc) AS rownum from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (2,3) $complemnto_secundarios $comple_filtro ) as sub
	where rownum > $inicio and rownum <= $factor_b  ";			
				
	 	$busca_detalle = "select * from ( select  * from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (2,3) $complemnto_secundarios $comple_filtro  order by fecha_creacion desc";
		

 $busca_detalle = "select * from ( select   t6_tarifas_lista_id, tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia, tarifa_padre, nombre_estado_tarifa, descripcion, moneda, fecha_fin_vigencia, t6_tarifas_listas_lista_id, nombre, tipo_creacion_modifica, us_aprobacion_actual, creada_luego_firme,consecutivo_tarifa, ROW_NUMBER() OVER(ORDER BY fecha_creacion desc) AS rownum from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (2,3) $complemnto_secundarios $comple_filtro ) as sub	where rownum > $inicio and rownum <= $factor_b";
								 
								
								 
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		
		if($lista_detalle[13]==3){
		 $modificada = "NO";
		 $sql_ap=" t6_tarifas_estados_tarifas_id in (1,4)";
			if($lista_detalle[22]==4 or $lista_detalle[22]==2){
				 $busca_tarifa_padre_act=  "select valor from  t6_tarifas_lista where t6_tarifas_lista_id = $lista_detalle[15]";
	 		}else{
				$busca_tarifa_padre_act=  "select valor from $v_t_3 where tarifa_padre = $lista_detalle[15]";
				
			}
			$busca_detalle_padre = traer_fila_row(query_db($busca_tarifa_padre_act));	
		 }
		else{
		$modificada = "SI";
		$sql_ap=" t6_tarifas_estados_tarifas_id in (1,4,5)";
		}
	

	
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
		
		if( ($lista_detalle[19] != '0000-00-00') && ($lista_detalle[19] < $fecha))
				$estado_tarifa_imprime_aprobacio="Vencida";
		else
						$estado_tarifa_imprime_aprobacio="";
	

		if($lista_detalle[19] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$lista_detalle[19]."<br>".$estado_tarifa_imprime_aprobacio;


	$busca_aprobaciones_permite= traer_fila_row(query_db("select * from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]."
	 and estado = 1 "));
	 	
		$busca_aprobaciones= traer_fila_row(query_db("select nombre_administrador, fecha_aprobacion, us_id from $v_t_4 where t6_tarifas_lista_id = $lista_detalle[0] and estado_aprobacion = 1 and estado_aprobacion = 1 order by fecha_aprobacion desc"));
			if($busca_aprobaciones_permite[0]>=1) $suma_apertura_botones=1;
			
	 ?>
                <tr class="filas_resultados">
                  <td align="center"><div align="<?=alinea_CONSECUTIVO;?>"><?=$lista_detalle[25];?></div></td>
                  <td><div align="center"><?=$lista_detalle[4];?></div></td>
                  <td><div align="center"><?=$lista_detalle[5];?></div></td>
                  <td class="titulos_resumen_alertas"><div align="center"><?=$lista_detalle[18];?></div></td>
                  <td class="titulos_resumen_alertas"><div align="center"><?=decimales_estandar($busca_detalle_padre[0],2);?> </div></td>
                  <td class="titulos_resumen_alertas"><div align="center"><?=decimales_estandar($lista_detalle[9],2);?></div></td>
                  <td class="titulos_resumen_alertas"><div align="center"><?=$lista_detalle[14];?></div></td>
                  <td class="titulos_resumen_alertas"><div align="center"><?=$fecha_fin_vi;?></div></td>
                  <td class="titulos_resumen_alertas"><div align="center" class="<?=$class_tipo;?>"><?=$tipo_modifica;?></div></td>
                  <td class="titulos_resumen_alertas"><select name="aprobacion[<?=$lista_detalle[0];?>]" id="aprobacion"><?=listas($t6,$sql_ap ,0,'nombre', 1);?></select></td>
                  <td align="center" class="titulos_resumen_alertas"><textarea name="observaciones_<?=$lista_detalle[0];?>" id="textarea" cols="20" rows="2"></textarea>
                  Agregar Anexo
                    <input type="file" name="carga_anexo_individula_<?=$lista_detalle[0];?>" id="carga_anexo_individula_<?=$lista_detalle[0];?>" /></td>
                  <td class="titulos_resumen_alertas"><?=$busca_aprobaciones[0];?></td>
                  <td class="titulos_resumen_alertas"><?=fecha_for_hora($busca_aprobaciones[1]);?></td>
                  <td class="titulos_resumen_alertas"><img src="../imagenes/botones/b_guardar.gif" alt="ver atibutos de la tarifa" title="ver atibutos de la tarifa" width="16" height="16" onclick="ajax_carga('../aplicaciones/tarifas/reporte_tarfifas_actualizada.php?id_contrato=<?=$id_contrato;?>&id_tarifa=<?=$lista_detalle[0];?>&ruta_apro=2','carga_acciones_permitidas')" /></td>
                </tr>

 <tr class="<?=$class;?>" style="display:none" id="espacio_<?=$lista_detalle[0];?>" >
  
              
            	<td colspan="12">
                

           </td>
           </tr>                
                <? 
				
				$id_us_aprobador_original = $lista_detalle[23];
				}//detalle ?>
              </table>
          <br />
              
          </td>
        </tr>
    </table>
    </td>
  </tr>
</table>

<div id="botones_acciones">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="0%"></td>
    <td width="69%">&nbsp;</td>
    <td align="right">&nbsp;</td>
    </tr>
  <tr>
    <td></td>
    <td align="right" valign="top"><input name="button6" type="button" class="boton_grabar" id="button6" value="Aprobar o Rechazar seg&uacute;n la selecci&oacute;n en cada tarifa" onclick="crear_aprobacion(''); this.onclick=''" /></td>
    <td align="right"><table width="100%" border="0" class="tabla_lista_resultados">
      <tr>
        <td><input name="button" type="button" class="boton_aporbar_tarifa" id="button" value="Aprobar TODAS LAS TARIFAS"  onclick="crear_aprobacion_todos('')"/></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" class="titulo_calendario_real_bien">! Si desea usar la opci&oacute;n de APROBAR TODAS LAS TARIFAS y si requiere incluir un anexo en com&uacute;n para todas, use el siguiente campo para aenexar el documento! <span class="titulo_calendario_real_mal">Solo anexos en formato .ZIP &oacute; .RAR, hasta 5MG</span></td>
            </tr>
          <tr>
            <td width="34%" align="right">Agregar anexo:</td>
            <td width="66%"><input type="file" name="cargue_anexo_masiva" id="cargue_anexo_masiva" /></td>
          </tr>
        </table>
          <br />
          <table width="100%" border="0" class="tabla_lista_resultados">
            <tr>
            <td colspan="2"><input name="button4" type="button" class="boton_rechazar_tarifa" id="button4" value="Rechazar TODAS LAS TARIFAS"  onclick="crear_recahzo_todos()"/></td>
            </tr>
          <tr>
            <td colspan="2"><span class="letra-descuentos">&iexcl;Si desea usar la opci&oacute;n de RECHAZAR TODAS LAS TARIFAS, por favor digitar una observaci&oacute;n en el campo de texto a continuaci&oacute;n, si requiere  anexar un docuemnto soporte, a continuaci&oacute;n puede hacerlo este campo para anexar docuemntos NO es obligatorio! <span class="titulo_calendario_real_mal">Solo anexos en formato .ZIP &oacute; .RAR, hasta 5MG</span></span></td>
            </tr>
          <tr>
            <td colspan="2"><textarea name="ob_general" rows="5" id="ob_general"></textarea></td>
            </tr>
          <tr>
            <td width="34%" align="right">Agregar anexo:</td>
            <td width="66%"><input type="file" name="anexo_rechazo_masivo" id="anexo_rechazo_masivo" /></td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td></td>
    <td height="73" colspan="2" align="right" valign="top"><table width="100%" border="0">
      <tr>
        <td align="center"><input name="button7" type="button" class="boton_buscar" id="button7" value="Exportar a Excel tarifas pendientes de su aprobaci&oacute;n"  onclick="javascript:exporta_tarifas_consulta_des03()" /></td>
      </tr>
    </table></td>
    </tr>
</table>
</div>

<? if($sql_con[19]==2)
	echo '<input type="hidden" name="contrato_marco_si_no" value = "4">';
else
	echo '<input type="hidden" name="contrato_marco_si_no" value = "3">';



}// si tiene tarifas por aprobar ?>


</div>
<input type="hidden" name="id_contrato" id="id_contrato" value="<?=$id_contrato;?>" />
<input type="hidden" name="tipo_reporte" id="tipo_reporte" value="c_aprobaciones" />
<input type="hidden" name="id_us_session_c_apro" id="id_us_session_c_apro" value="<?=$_SESSION["id_us_session"]?>" />
<input type="hidden" name="id_us_aprobador_actual" id="id_us_aprobador_actual" value="<?=$id_us_aprobador_original?>" />

</body>
</html>
