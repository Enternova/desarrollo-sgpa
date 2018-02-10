<? include("../../librerias/lib/@session.php"); 
//	verifica_menu("administracion.html");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=plantilla-tarifas-$lista_existentes.xls"); 
	header("Content-Transfer-Encoding: binary");
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));

	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$titulos_atributos.="<td width='200' bgcolor='#999999' valign='top'>".valida_espacio_lista($lista_atr[4])."</td>";
	$titulos_atributos_lista.="<td valign='top'></td>";
	
	} //lista atributos	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

</head>

<body>

<table cellspacing="0" cellpadding="0" border="1">
  <tr>
    <td style="background-color:#C5D9F1; font-size:11px" width="287"  valign="top" ><strong><?=TITULO_2;?>:</strong>
(Este campo es obligatorio).&nbsp; Hace    alusi&oacute;n al Proyecto (VSM,VIM, LLANOS) o Pozo (La Hocha, La Ca&ntilde;ada, Ocelote),    si las tarifas aplican para el territorio nacional colocar    &quot;Corporativo&quot;</td>
    <td style="background-color:#C5D9F1; font-size:11px"  width="549"  valign="top" ><strong><?=TITULO_3;?>:</strong> Este campo es obligatorio siempre y cuando las tarifas tengan una divisi&oacute;n    dentro de ellas y de &eacute;stas se generen diferentes tipos de servicios,    actividades o subgrupos (ej.: n&oacute;mina, tesorer&iacute;a, clase de aceite, ej.:    Terpel, Lumax).&nbsp;&nbsp;</td>
    <td style="background-color:#C5D9F1; font-size:11px" width="170"  valign="top" ><strong><?=TITULO_5;?>:</strong> <?=TITULO_5b;?></td>
    <td style="background-color:#C5D9F1; font-size:11px" width="639"  valign="top" ><strong><?=TITULO_6;?>:</strong> (Este campo es obligatorio).&nbsp; Tipo de    servicio que se est&aacute; prestando.</td>
    <td  style="background-color:#C5D9F1; font-size:11px" width="124"  valign="top" ><strong><?=TITULO_4;?>:</strong> (Este campo es obligatorio).
    Medida utilizada para medir el servicio (ej.: km, gal&oacute;n, d&iacute;a, mes, etc.)    m&aacute;ximo 50 caracteres</td>
    <td style="background-color:#C5D9F1; font-size:11px" width="93"  valign="top" ><strong>Cantidad:</strong> (Este campo es obligatorio).
    Siempre debe ser &ldquo;1&rdquo;</td>
    <td style="background-color:#C5D9F1; font-size:11px" width="191"  valign="top" > <strong><?=TITULO_7;?>:</strong> (Este campo es obligatorio).
    Tipo de moneda con la cual se suscribe el contrato, se debe especificar si    es &ldquo;COP&rdquo; o &ldquo;USD&rdquo;, debe ir siempre en may&uacute;scula.&nbsp;</td>
    <td style="background-color:#C5D9F1; font-size:11px" width="133"  valign="top" > <strong><?=TITULO_8;?>:</strong> (Este campo es obligatorio).
    Valor unitario de cada tarifa. Sin formato y solo n&uacute;meros hasta 5    decimales separados por (.)&nbsp;</td>
    <? if ($_SESSION["tipo_usuario"]==2) { ?>
    <td style="background-color:#C5D9F1; font-size:11px" width="120"  valign="top" ><strong><?=TITULO_9;?></strong><strong>:</strong> (Este campo es obligatorio).
    Fecha a partir de cu&aacute;ndo empiezan a regir las tarifas. Usar formato    dd/mm/yyyy</td>
    <td style="background-color:#C5D9F1; font-size:11px" width="120"  valign="top" ><strong>Aplica Descuento:  </strong>(Este campo es obligatorio).
    Digite &quot;SI&quot; o &quot;NO&quot; en may&uacute;scula.</td>
    <td style="background-color:#C5D9F1; font-size:11px" width="120"  valign="top" ><strong>Observaciones:</strong>
      (Este campo es obligatorio).
    Se debe hacer relaci&oacute;n al documento soporte que se est&aacute; incluyendo al momento del cargue de las tarifas.</td>
  
    <? } ?>
    <td style="background-color:#C5D9F1; font-size:11px" width="120"  valign="top" ><strong>
      <?=TITULO_18;?>
    </strong><strong>:</strong> (Este campo NO es obligatorio).
    En &eacute;ste se especifica la fecha de caducidad de las tarifas con vencimiento diferente a la finalizaci&oacute;n del contrato. Usar formato    dd/mm/yyyy</td>
    <?=$titulos_atributos;?>
  </tr>
  <tr >
    <td  valign="top" style="mso-number-format:'@';font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@';font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@';font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@'; font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@'; font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@'; font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@'; font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@'; font-size:11px"  >&nbsp;</td>
  <? if ($_SESSION["tipo_usuario"]==2) { ?>
    <td  valign="top" style="mso-number-format:'@'; font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@'; font-size:11px"  >&nbsp;</td>
    <td  valign="top" style="mso-number-format:'@';font-size:11px"  >&nbsp;</td>
   
    
    <? } ?>
     <td  valign="top" style="mso-number-format:'@';font-size:11px"  >&nbsp;</td>
    <?=$titulos_atributos_lista;?>
  </tr>
          



</table>

<p>&nbsp;</p>
</body>