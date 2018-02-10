<? include("../../../librerias/lib/@session.php"); 
//	verifica_menu("administracion.html");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=plantilla-tarifas-$lista_existentes.xls"); 
	header("Content-Transfer-Encoding: binary");
	
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));

	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$titulos_atributos.="<td width='200' bgcolor='#999999' valign='top'>".valida_espacio_lista($lista_atr[4])."</td>";
	
	} //lista atributos	
	
	
	
?>

<table cellspacing="0" cellpadding="0" border="1">
  <tr>
    <td width="83" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong>N&uacute;mero</strong>: (No se pueden modificar los datos de esta columna)</td>
    <td width="287" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong><?=TITULO_2;?></strong>: (No se pueden modificar los datos de esta columna)</td>
    <td width="549" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong><?=TITULO_3;?>:</strong> (No se pueden modificar los datos de esta columna)</td>
    <td width="170" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong><?=TITULO_5;?>:</strong> (No se pueden modificar los datos de esta columna)</td>
    <td width="527" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong><?=TITULO_6;?>:</strong>(No se pueden modificar los datos de esta columna)</td>
    <td width="124" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong><?=TITULO_4;?>:</strong> (No se pueden modificar los datos de esta columna)</td>
    <td width="93" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong>Cantidad</strong>: (No se pueden modificar los datos de esta columna)</td>
    <td width="191" style="background-color:#C5D9F1; font-size:11px" valign="top" > <strong><?=TITULO_7;?>:</strong> (No se pueden modificar los datos de esta columna)&nbsp;</td>
    <td width="133" style="background-color:#C5D9F1; font-size:11px" valign="top" > <strong><?=TITULO_8;?></strong>: (No se pueden modificar los datos de esta columna) </td>
    <td width="120" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong><?=TITULO_9;?>:</strong> (No se pueden modificar los datos de esta columna)</td>
    <td width="120" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong>Aplica    Descuento</strong>: (No se pueden modificar los datos de esta columna)</td>
    <td width="135" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong>Observaciones</strong>: (No se pueden modificar los datos de esta columna)</td>
    <td width="133" style="background-color:#C5D9F1; font-size:11px" valign="top" > <strong>Porcentaje de IPC</strong>: (Este campo es obligatorio). Debe ser de 0 a 10 con m&aacute;ximo cinco (5) decimales separados por punto (.) sin el signo %</td>
    <td width="120" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong><?=TITULO_9;?>:
      </strong>(Este campo es obligatorio).
      Fecha a partir de cu&aacute;ndo empiezan a regir las tarifas. Usar formato    dd/mm/yyyy</td>
    <td width="135" style="background-color:#C5D9F1; font-size:11px" valign="top" ><strong>Observaciones:</strong> (Este campo es obligatorio).
      Se debe hacer relaci&oacute;n al documento soporte que se est&aacute; incluyendo al    momento del cargue de las tarifas.</td>
  </tr>
  
 
  </tr>
  
  <?
  	$busca_tarifas_contrato = "select t6_tarifas_lista_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, t1_moneda_id, valor, fecha_inicio_vigencia from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes and t6_tarifas_estados_tarifas_id = 1";
	$sql_ex_lis = query_db($busca_tarifas_contrato);
	while($lista_tarifas = traer_fila_row($sql_ex_lis)){//inicio lista
	$moneda_t="";
	if($lista_tarifas[6]==1) $moneda_t = "COP";
	else $moneda_t = "USD";
	
	
			 $cambia_soporte = "select descuento, observaciones from  t6_tarifas_anexos_modifica_tarifas where t6_tarifas_lista_id = $lista_tarifas[0]";
									$sql_cambi_so=traer_fila_row(query_db($cambia_soporte));	
	
  ?>
  <tr>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" ><?=$lista_tarifas[0];?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$lista_tarifas[1];?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$lista_tarifas[2];?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$lista_tarifas[3];?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$lista_tarifas[4];?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$lista_tarifas[5];?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top">1</td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$moneda_t;?></td>
    <td style="<?=$stilo_excel;?> background-color:#8DB4E2; font-size:11px" valign="top"><?=number_format($lista_tarifas[7],$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$lista_tarifas[8];?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$sql_cambi_so[0];?></td>
    <td style="mso-number-format:'@';background-color:#8DB4E2; font-size:11px" valign="top"><?=$sql_cambi_so[1];?></td>
    <td style="mso-number-format:'@'; font-size:11px" valign="top">&nbsp;</td>
    <td style="mso-number-format:'@'; font-size:11px" valign="top">&nbsp;</td>
    <td style="mso-number-format:'@'; font-size:11px" valign="top">&nbsp;</td>
  </tr>
  
    <? } //inicio lista  ?>
</table>

