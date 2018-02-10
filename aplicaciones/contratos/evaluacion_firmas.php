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
  <td colspan="4" align="center" class="fondo_3" id="fila_crea_evaluacion2">Firmas</td>
</tr>
<tr>
  <td width="12%" align="right" id="fila_crea_evaluacion">Firma:</td>
  <td width="7%" align="left" id="fila_crea_evaluacion"><label for="select"></label>
    <select name="select" id="select">
      <option value="1">SI</option>
      <option value="2">NO</option>
    </select></td>
  <td colspan="2" align="left" id="fila_crea_evaluacion">&nbsp;</td>
</tr>
<tr>
  <td align="right" id="fila_crea_evaluacion3">Observaciones:</td>
  <td colspan="3" align="left" id="fila_crea_evaluacion3"><label for="textarea"></label>
    <textarea name="textarea" id="textarea" cols="10" rows="1"></textarea></td>
  </tr>
<tr>
  <td colspan="4" align="center" id="fila_crea_evaluacion4">&nbsp;</td>
</tr>
<tr>
  <td colspan="4" align="center" class="fondo_3" id="fila_crea_evaluacion5">Historia Firmas</td>
</tr>
<tr class="columna_subtitulo_resultados_mas_oscuro">
  <td align="center" id="fila_crea_evaluacion6">Usuario</td>
  <td align="center" id="fila_crea_evaluacion6">Firma</td>
  <td width="9%" align="center" id="fila_crea_evaluacion6">Estado</td>
  <td width="72%" align="center" id="fila_crea_evaluacion6">Observaciones</td>
</tr>
<tr>
  <td align="center" id="fila_crea_evaluacion9">&nbsp;</td>
  <td align="center" id="fila_crea_evaluacion9">&nbsp;</td>
  <td align="center" id="fila_crea_evaluacion9">&nbsp;</td>
  <td align="center" id="fila_crea_evaluacion9">&nbsp;</td>
</tr>
<tr>
  <td align="center" id="fila_crea_evaluacion10">&nbsp;</td>
  <td align="center" id="fila_crea_evaluacion10">&nbsp;</td>
  <td align="center" id="fila_crea_evaluacion10">&nbsp;</td>
  <td align="center" id="fila_crea_evaluacion10">&nbsp;</td>
</tr>

</table>
<br />


<input name="id_documento" type="hidden" value="<?=$id_documento;?>" />

</body>
</html>
