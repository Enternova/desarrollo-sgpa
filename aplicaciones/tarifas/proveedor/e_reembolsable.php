<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_reembolsable_arr = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura));
	
	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

	$busca_reembolsables = "select * from t6_tarifas_reembosables1_contrato where t6_tarifas_contratos_id = ".$sql_con[0]. " and estado = 1";
	$busca_ree = traer_fila_row(query_db($busca_reembolsables));
	
	$busca_item = "select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado, fecha_ini, fecha_fin, t6_tarifas_municipios_id, t6_tarifas_municipios_id,tipo_contrato,orden_trabajo 
	from $v_t_11  where t6_tarifas_reembolables_datos_id =  $id_reembolsable_arr ";	  
	$sql_ex = traer_fila_row(query_db($busca_item));
	$tp_moneda=traer_fila_row(query_db("SELECT tp_moneda_tiquete FROM ".$ta23." WHERE t6_tarifas_reembolables_datos_id =".$id_reembolsable_arr));
	
			$fecha_inicial = $sql_ex[4];
			$fecha_final = $sql_ex[5];

			$municipio_pre=$sql_ex[6];
			$proyecto_pre=$sql_ex[7];
	
	
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
    <td width="91%" class="titulos_secciones">SECCION:<span class="titulos_resaltado_procesos">CONTRATO:
        <?=$sql_con[7];?>
    </span>&gt;&gt;  CREACION TEMPORAL DE REEMBOLSABLES</td>
    <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver" id="button5" value="Volver al detalle del contrato" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','contenidos')" /></td>
  </tr>
</table>
<br />
<table width="99%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_2_sub">Rango de fechas del reembolsable</td>
    <td colspan="2" class="fondo_2_sub">Lugar de ejecuci&oacute;n</td>
  </tr>
  <tr>
    <td valign="top"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td valign="top"><div align="justify"><strong>Seleccione rango de fechas</strong></div></td>
    <td width="2%"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td width="45%">Seleccione el municipio de ejecuci&oacute;n del servicio<strong>
      <input type="hidden" name="consecutivo_factura2" id="consecutivo_factura2" value="0" />
    </strong></td>
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
          <?
  	 $busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	$l_pro=traer_fila_row($sql_q);
	
				

  ?>
          <tr>
            <td><table width="99%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td colspan="2"  class="fondo_4">Seleccione los los proyectos donde aplicara los reembolsables</td>
              </tr>
              <?
  	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
			$busca_proyecto = traer_fila_row(query_db("select * from t6_tarifas_reembolsables_proyectos where t6_tarifas_reembolables_datos_id = $id_reembolsable_arr and t6_tarifas_municipios_proyectos_id = $l_pro[0]"));
			if($busca_proyecto[0]!=""){ $chequeado="checked";
			$crea_titulo_columna.="<td class='fondo_3' width='5%'>".$l_pro[2]."</td>";
			}
			else $chequeado="";
				

  ?>
              <tr>
                <td width="3%"><input type="checkbox" name="ch_proyectos[]" value="<?=$l_pro[0];?>"  <?=$chequeado;?>/></td>
                <td width="97%"><div align="left">&nbsp;&nbsp;
                  <?=$l_pro[2];?>
                </div></td>
              </tr>
              <? } ?>
            </table></td>
          </tr>
        </table>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="9%"><div align="right">Moneda del Tiquete:</div></td>
        <td width="35%">
        <?
			if($tp_moneda[0]==1){
				echo "COP";
			}elseif($tp_moneda[0]==2){
				echo "USD";
			}
		?>
        <input type="hidden" name="tp_moneda" id="tp_moneda" value="<?=$tp_moneda[0];?>">
		</td>
        </tr>
      <tr>
        <td colspan="2" style="font-weight: 900; font-size: 14px;"><i><img src="../imagenes/botones/icono_ayuda.png"></i><font face="roboto" color="#229BFF">&nbsp;Moneda  sobre la cual va a presentar su tiquete de reembolsable <br />
          &ldquo;SI VA A PRESENTAR SU TIQUETE DE REEMBOLSABLE &nbsp;EN LAS DOS MONEDAS, DEBE  REALIZAR TIQUETES POR SEPARADO&rdquo;</font></td>
        </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top"><table width="98%" border="0">
      <tr class="tabla_lista_resultados">
        <? 
	
		if($sql_con[19]==1) echo '<input name="c_marco" type="hidden" value="2">'; ?>
        <? if($sql_con[19]==2){ echo '<input name="c_marco" type="hidden" value="1">'; ?>
        <td width="45%" align="right"><strong>Seleccione la orden de trabajo:</strong></td>
        <td width="46%" align="left" valign="top"><?
          	 $busca_ordenes = "select * from t7_contratos_complemento where id_contrato = $sql_con[13] and tipo_complemento = 2";
			$sql_ordenes = query_db($busca_ordenes);
			while($ls_orden=traer_fila_row($sql_ordenes)){
					if($sql_ex[9]==$ls_orden[25])
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
        <td width="4%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="5%">&nbsp;</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<br />
<br />
<table width="99%" border="0" align="center" class="tabla_lista_resultados">
  <tr>
    <td colspan="7" class="columna_titulo_resultados">CREACION DE ITEM REEMBOLSABLE</td>
  </tr>
  <tr class="columna_subtitulo_resultados">
    <td>Proyecto</td>
    <td>Categor&iacute;a</td>
    <td>Valor</td>
    <td>Detalle</td>
    <td>Factura No.</td>
    <td>Anexo</td>
  </tr>
  <tr>
    <td><select name="proyec_reem" id="proyec_reem" >
      <?=listas("v_tarifas_reembolsables_proyectos", " t6_tarifas_reembolables_datos_id = $id_reembolsable_arr ",0,'proyecto', 4);?>
    </select></td>
    <td><select name="categoria_reem" id="categoria" >
      <?=listas($ta24, " estado = 1 ",0,'detalle', 1);?>
    </select></td>
    <td><input type="text" name="valor_r" id="valor_r" onkeyup='checkDecimals_2(this.name, this.value,this)' onpaste="return false;" /></td>
    <td><textarea name="detalle_r" id="detalle_r" cols="45" rows="2"></textarea></td>
    <td><input type="text" name="factura_r" id="factura_r" /></td>
    <td><input type="file" name="anexo_r" id="anexo_r" /></td>
  </tr>
  <tr>
    <td colspan="7"><input name="button" type="button" class="boton_grabar" id="button" value="Crear item reembolsable"  onclick="crea_item_re()"/></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="99%" border="0" align="center" class="tabla_lista_resultados">
  <tr>
    <td colspan="9" class="columna_titulo_resultados">LISTA DE ITEMS REEMBOLSABLES</td>
  </tr>
  <tr class="columna_subtitulo_resultados">
    <td width="13%">Proyecto</td>
    <td width="15%">Categor&iacute;a</td>
    <td width="7%">Valor</td>
    <td width="5%">Moneda</td>
    <td width="20%">Detalle</td>
    <td width="7%">Factura No.</td>
    <td width="17%">Anexo</td>
    <td colspan="2" align="center">Admin</td>
  </tr>
  
  <?
  	 $busca_lista_ree = "select * from $ta25 where t6_tarifas_reembolables_datos_id = $id_reembolsable_arr";
	$sql_ree = query_db($busca_lista_ree);
	while($l_ree=traer_fila_row($sql_ree)){//lista reembola
  
			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
							
						?>
                     
 
  
   <tr class="<?=$class;?>">
     <td><select name="proyec_reem_<?=$l_ree[0];?>" id="proyec_reem_<?=$l_ree[0];?>" >
       <?=listas("v_tarifas_reembolsables_proyectos", " t6_tarifas_reembolables_datos_id = $id_reembolsable_arr ",$l_ree[11],'proyecto', 4);?>
     </select></td>
    <td><select name="categoria_r_<?=$l_ree[0];?>" id="categoria_reem" >
      <?=listas($ta24, " estado = 1 ",$l_ree[2],'detalle', 1);?>
    </select></td>
    <td><input name="valor_r_<?=$l_ree[0];?>" type="text" class="campos_tarifas" id="valor_r_<?=$l_ree[5];?>" value="<?=$l_ree[5];?>"  onkeyup='checkDecimals_2(this.name, this.value,this)' onpaste="return false;" /></td>
    <td><select name="moneda_r_<?=$l_ree[0];?>" id="moneda2"><?=listas($g5, " t1_moneda_id >=1",$l_ree[6],'nombre', 1);?></select></td>
    <td><textarea name="detalle_r_<?=$l_ree[0];?>" id="textarea2" cols="45" rows="2"><?=$l_ree[7];?></textarea></td>
    <td><input name="factura_r_<?=$l_ree[0];?>" type="text" class="campos_tarifas" id="textfield3" value="<?=$l_ree[8];?>" /></td>
    <td><input name="anexo_r_<?=$l_ree[0];?>" type="file" id="fileField2" /></td>
    <td width="5%"><input type="button" name="button3" id="button3" value="Editar" onclick="edita_item_re('<?=arreglo_pasa_variables($l_ree[0]);?>')" /></td>
    <td width="11%"><input type="submit" name="button4" id="button4" value="Eliminar" onclick="elimina_item_re('<?=arreglo_pasa_variables($l_ree[0]);?>')"/></td>
  </tr>
  <? $num_fila++; } //lista reembola ?>
</table>
<p>&nbsp;</p>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="fondo_2_sub" valign="top">Confirmar de creaci&oacute;n del reembolsable</td>
  </tr>
  <tr>
    <td width="4%"><img src="../imagenes/botones/envia_confirmacion.gif" alt="Enviar confirmacion" width="32" height="32" /></td>
    <td width="96%" colspan="2" align="left"><span class="fondo_5">ATENCION:</span> <strong>Solo si ya esta seguro de haber terminado la creaci&oacute;n del reembolsable, presione el siguiente bot&oacute;n &quot;Confirmar creaci&oacute;n de reembolsable&quot;, esta acci&oacute;n creara el documento ; Si no ha terminado no  ejecute el boton siga seleccionando reembolsables el sistema guardara las creaciones incluso si sale del sistema.</strong></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left">
      <input type="button" name="button2" class="boton_edicion" id="button2" value="Grabar reembolsable temporalmente" onclick="reembolsable_temporal()" />
      <input type="button" name="button6" class="boton_edicion" id="button6" value="Vista previa del reembolsable " onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura_or=<?=$id_reembolsable_factura;?>','carga_acciones_permitidas');" />
    </div></td>
    <td width="25%"><input type="button" name="button2" class="boton_grabar" id="button6" value="Confirmar creaci&oacute;n del reembolsable " onclick="confirma_creacion_reem()" /></td>
  </tr>
</table>
<p><br />
  
  <input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
  <input type="hidden" name="id_reembolsable_porcentaje_or" value="<?=arreglo_pasa_variables($busca_ree[0]);?>">    
  <input type="hidden" name="id_reembolsable_factura_or" value="<?=$id_reembolsable_factura;?>" />
  <input type="hidden" name="t6_tarifas_reembolables_datos_detalle_id"  />
  
</p>
</body>
</html>
