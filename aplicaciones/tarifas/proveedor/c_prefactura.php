<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	
	 $busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	
	
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
    </span>&gt;&gt;  CREACION TEMPORAL DE TIQUETE DE SERVICIO</span></td>
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
    <td rowspan="5" valign="top"><select name="municipio_pre" id="municipio_pre"  onchange="ajax_carga('../aplicaciones/tarifas/proveedor/lista_proyectos.php?id_municipio=' + this.value,'carga_acciones_permitidas_municipios') " >
      <?=listas($t18, " estado = 1 ",$municipio_pre,'municipo', 2);?>
    </select>
    <div id="carga_acciones_permitidas_municipios"></div>
    <br />    <div id="resultado_busqueda_proyecto_clave" >&nbsp;</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="9%"><div align="right">Moneda del Tiquete:</div></td>
        <td width="35%"><select name="tp_moneda" id="tp_moneda"><option value="0">Seleccione</option><option value="1">COP</option><option value="2">USD</option></select></td>
        </tr>
      <tr>
        <td colspan="2" style="font-weight: 900; font-size: 14px;"><img src="../imagenes/botones/icono_ayuda.png"></i><font face="roboto" color="#229BFF">Moneda  sobre la cual va a presentar su tiquete de servicio <br />
          &ldquo;SI VA A PRESENTAR SU TIQUETE DE SERVICIO &nbsp;EN LAS DOS MONEDAS DEBE  REALIZAR TIQUETES POR SEPARADO&rdquo;</font></td>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td>Debe seleccionar la fecha del Servicio Prestado.</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="98%" border="0">
      <tr class="tabla_lista_resultados">
        
        <? 
	
		if($sql_con[19]==1) echo '<input name="c_marco" type="hidden" value="2">'; ?>
        <? if($sql_con[19]==2){ echo '<input name="c_marco" type="hidden" value="1">'; ?>
        <td width="50%" align="right"><strong>Seleccione la orden de trabajo:</strong></td>
        <td width="46%" align="left" valign="top">
          <?
       	 $busca_ordenes = "select * from t7_contratos_complemento where id_contrato = $sql_con[13] and tipo_complemento = 2 and estado >=25 and estado < 50";
			$sql_ordenes = query_db($busca_ordenes);
			while($ls_orden=traer_fila_row($sql_ordenes)){
					$option_orden.="<option value='".$ls_orden[25]."'>".$ls_orden[25]."</option>";
				}
				
		  ?>
          
          <select name="orden_trabajo">
          <option value="">Seleccione</option>
          <?=$option_orden;?>
          </select>
          
        </td>
        
        <? } ?>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="4%">&nbsp;</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>



<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="67%" colspan="4"><div align="center">
      <input type="button" name="button" class="boton_edicion" id="button" value="Grabar tiquete de servicio temporalmente" onclick="prefactura_temporal_crea(2)" />
    </div></td>
  </tr>
</table>
<br />

<input type="hidden" name="id_tarifa" />
<input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">    
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
<input type="hidden" name="id_prefactura" value="0" />

    <input type="hidden" name="aiu_a" value="3" />
        <input type="hidden" name="aiu_i" value="3" />
            <input type="hidden" name="aiu_u" value="3" />
            
    <input type="hidden" name="aiu_a_p" value="0" />
        <input type="hidden" name="aiu_i_p" value="0" />
            <input type="hidden" name="aiu_u_p" value="0" />            
            
<input type="hidden" name="tipo_de_grabacion" />
<input type="hidden" name="inicio_contrato" value="<?=$sql_con[20];?>" />
<input type="hidden" name="vigencia_contrato" value="<?=$sql_con[21];?>" /> 
<input type="hidden" name="muestra_alerta" id="muestra_alerta" value="SI"  />
</body>
</html>
