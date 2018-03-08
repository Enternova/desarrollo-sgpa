<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_documento_arr = elimina_comillas(arreglo_recibe_variables($id_documento));
	
	if($id_documento_arr==""){
		$id_documento_arr=0;
	}
	
	$busca_contacto = "select * from $co7 where id = $id_documento_arr";
	$sql_com=traer_fila_row(query_db($busca_contacto));
	
	$busca_contrato_tipo = "select t1_tipo_documento_id from $co1 where id = $id_contrato_arr";
	$sql_tipo=traer_fila_row(query_db($busca_contrato_tipo));
	
	$busca_grupo = "select id,nombre,estado from $evf5 where id = $id_grupo";
	$sql_grupo=traer_fila_row(query_db($busca_grupo));
	
	
	
      if($sql_tipo[0]==2){
	  $col = 2;
	  }else{
		$col = 1; 
		}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?
//echo imprime_cabeza_contrato($id_contrato)
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">

<tr>
  <td colspan="3" align="right" ><span onclick="javascript:document.getElementById('fila_evaluacion_1').style.display = '';document.getElementById('fila_evaluacion_2').innerHTML = ''" style="cursor:pointer">Volver</span></td>
</tr>
<?
if($id_evaluacion != 0){
?>
<tr>
  <td width="16%" align="center" onmouseout="this.className='columna_subtitulo_resultados';" onmouseover="this.className='columna_subtitulo_resultados_oscuro';" class="columna_subtitulo_resultados" ><span onclick="javascript:document.getElementById('fila_crea_evaluacion1').style.display = '';document.getElementById('fila_crea_evaluacion2').innerHTML = '';" style="cursor:pointer">Evaluaci&oacute;n</span></td>
  <td width="16%" align="center" onmouseout="this.className='columna_subtitulo_resultados';" onmouseover="this.className='columna_subtitulo_resultados_oscuro';" class="columna_subtitulo_resultados" > <span onclick="javascript:document.getElementById('fila_crea_evaluacion1').style.display = 'none';ajax_carga('../aplicaciones/contratos/evaluacion_firmas.php?id_evaluacion=1','fila_crea_evaluacion2');" style="cursor:pointer">Firmas</span></td>
  <td width="68%" align="right" >&nbsp;</td>
</tr>
<?
}
?>
<tr>
  <td colspan="3" align="center" id="fila_crea_evaluacion1">
 	 <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
  <td colspan="4" align="center" class="fondo_4"><strong>FORMATO DE CALIFICACI&Oacute;N</strong></td>
</tr>
<tr>
	<td colspan="4" align="center" class="fondo_3">Rango Calificaci&oacute;n <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
  </tr>
<tr>
  <td width="2%" align="left">90</td>
  <td width="2%" align="center">-</td>
  <td width="2%" align="left">100</td>
  <td width="94%" align="left">Excelente</td>
</tr>
<tr>
  <td align="left">80</td>
  <td align="center">-</td>
  <td align="left">89</td>
  <td align="left">Bueno</td>
</tr>
<tr>
  <td align="left">60</td>
  <td align="center">-</td>
  <td align="left">79</td>
  <td align="left">Regular</td>
</tr>
<tr>
  <td align="left">0</td>
  <td align="center">-</td>
  <td align="left">59</td>
  <td align="left">Malo</td>
</tr>
  </table>
  <br />
  	 <table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr class="fondo_3">
    	<td colspan="2" align="left" valign="top"><img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /><?=$sql_grupo[1];?></td>
    	<td width="14%" align="left" valign="top">40% <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
    </tr>
    <tr class="columna_subtitulo_resultados_oscuro">
    	<td width="74%" align="left" valign="top">Pregunta</td>
    	<td width="12%" align="left" valign="top">Peso Pregunta <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
    	<td align="left" valign="top">Calificacion 0-100 <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
  	</tr>
    <?
	$lista_poliza_int = "select id,id_grupo,nombre,estado from ".$evf1."  where estado = 1 and id_grupo = ".$id_grupo." order by id";
	$sql_poliza_int=query_db($lista_poliza_int);
	while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		if($linea_color==0){
							$class_s = "columna_subtitulo_resultados_mas_oscuro";
							$linea_color = 1;
						}else{
							$class_s = "columna_subtitulo_resultados";
							$linea_color = 0;
						}
	?>    
    <tr class="<?=$class_s;?>">
      <td align="left" valign="top"><img src="../imagenes/botones/flecha_a.png" alt="" width="16" height="16" /><?=$lista_poliza_int[2];?></td>
      <td align="left" valign="top">30%</td>
      <td align="left" valign="top"><input type="text" name="calificacion_<?=$lista_poliza_int[0];?>" id="calificacion_<?=$lista_poliza_int[0];?>"  value="" onchange="calcular_valor()"/></td>
    </tr>
    <tr class="<?=$class_s;?>">
      <td align="left" valign="top"><textarea name="observacion_tbg_<?=$re_lista_preguntas[0];?>" id="observacion_tbg_<?=$re_lista_preguntas[0];?>" cols="30" rows="3"></textarea></td>
      <td colspan="2" align="left" valign="top"><input type="file" name="adjunto_tbg_<?=$re_lista_preguntas[0];?>" id="adjunto_tbg_<?=$re_lista_preguntas[0];?>" /></td>
    </tr>
    <?
	}
	?>
    <tr class="filas_resultados">
      <td colspan="2" align="right">Total Calificaci&oacute;n Grupo 
        <?=$sql_grupo[1];?>:</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="right">&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="right"><input type="submit" name="button" id="button" value="Grabar" /></td>
      <td><input type="submit" name="button2" id="button2" value="Enviar a Firmas" /></td>
    </tr>
</table>
  </td>
</tr>
<tr>
  <td colspan="3" align="center" id="fila_crea_evaluacion2">&nbsp;</td>
</tr>

</table>
<br />


<input name="id_documento" type="hidden" value="<?=$id_documento;?>" />

</body>
</html>
