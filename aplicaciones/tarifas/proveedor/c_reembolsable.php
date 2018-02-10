<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

				$busca_reembolsables = "select * from t6_tarifas_reembosables1_contrato where t6_tarifas_contratos_id = ".$sql_con[0]. " and estado = 1";
				$busca_ree = traer_fila_row(query_db($busca_reembolsables));
	
	
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
        <?=numero_cotnrato_tarifas($id_contrato_arr);?>
    </span>&gt;&gt;  CREACION TEMPORAL DE REEMBOLSABLES</td>
    <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver" id="button5" value="Volver al detalle del contrato" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','contenidos')" /></td>
  </tr>
</table>
<br />
<table width="99%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_2_sub">Rango de fechas del tiquete de servicio</td>
    <td colspan="2" class="fondo_2_sub">Lugar de ejecuci&oacute;n</td>
  </tr>
  <tr>
    <td valign="top"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td valign="top"><div align="justify"><strong>Buscar tarifas vigentes en este rango de fechas</strong></div></td>
    <td width="2%"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td width="45%">Buscar proyectos por municipio de ejecuci&oacute;n del servicio<strong>
      <input type="hidden" name="consecutivo_factura" id="consecutivo_factura" value="0" />
    </strong></td>
  </tr>
  <tr>
    <td width="3%">&nbsp;</td>
    <td width="50%" valign="top"><table width="87%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="9%"><div align="right"><strong>Inicial:</strong></div></td>
        <td width="35%"><input type="text" name="fecha_inicial" id="fecha_inicial" value="<?=$fecha_inicial;?>"  onmousedown="calendario_sin_hora('fecha_inicial')" /></td>
        <td width="8%" align="right">Final:</td>
        <td width="48%"><input name="fecha_final" type="text"  id="fecha_final" onmousedown="calendario_sin_hora('fecha_final')"  value="<?=$fecha_final;?>" /></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
    <td valign="top"><select name="municipio_pre" id="municipio_pre"  onchange="ajax_carga('../aplicaciones/tarifas/proveedor/lista_proyectos.php?id_municipio=' + this.value,'carga_acciones_permitidas_municipios');document.getElementById('resultado_busqueda_proyecto_clave').innerHTML = ''; " >
      <?=listas($t18, " estado = 1 ",$municipio_pre,'municipo', 2);?>
    </select>
      <div id="carga_acciones_permitidas_municipios"></div>
      <br /></td>
  </tr>
  <tr>
    <td><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td>Debe seleccionar la fecha del Servicio Prestado.</td>
    <td><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td valign="top">Buscar proyectos por palabra clave</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top"><input type="text" name="palabra_clave_proyecto" id="palabra_clave_proyecto" onkeyup="ajax_carga('../aplicaciones/tarifas/proveedor/lista_proyectos_palabra.php?palabra_clave_proyecto=' + this.value,'resultado_busqueda_proyecto_clave')"  /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="9%"><div align="right">Moneda del Tiquete:</div></td>
        <td width="35%"><select name="tp_moneda" id="tp_moneda"><option value="0">Seleccione</option><option value="1">COP</option><option value="2">USD</option></select></td>
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
    <td><table width="98%" border="0">
      <tr class="tabla_lista_resultados">
        <? 
	
		if($sql_con[19]==1) echo '<input name="c_marco" type="hidden" value="2">'; ?>
        <? if($sql_con[19]==2){ echo '<input name="c_marco" type="hidden" value="1">'; ?>
        <td width="45%" align="right"><strong>Seleccione la orden de trabajo:</strong></td>
        <td width="46%" align="left" valign="top"><?
          	 $busca_ordenes = "select * from t7_contratos_complemento where id_contrato = $sql_con[13] and tipo_complemento = 2";
			$sql_ordenes = query_db($busca_ordenes);
			while($ls_orden=traer_fila_row($sql_ordenes)){
					$option_orden.="<option value='".$ls_orden[25]."'>".$ls_orden[25]."</option>";
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
    <td valign="top"><div id="resultado_busqueda_proyecto_clave" >&nbsp;</div></td>
  </tr>


</table>
<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="67%" colspan="4"><div align="center">
      <input type="button" name="button" class="boton_edicion" id="button" value="Grabar reembolsable temporalmente" onclick="reembolsable_temporal()" />
    </div></td>
  </tr>
</table>
<br />

<input type="hidden" name="id_tarifa" />
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
<input type="hidden" name="id_reembolsable_porcentaje_or" value="<?=arreglo_pasa_variables($busca_ree[0]);?>">    
<input type="hidden" name="id_reembolsable_factura_or" value="<?=arreglo_pasa_variables(0);?>" />
<input type="hidden" name="muestra_alerta" id="muestra_alerta" value="SI"  />
</body>
</html>
