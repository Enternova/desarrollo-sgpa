<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$num_ale= rand(0,99);
	$num_ale.= rand(0,99);
	$aleatorio = $fecha.$num_ale.$hora;
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<?
if($id_pecc != 1){
?>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td align="right" ><strong>Seleccione el tipo de proceso que desea crear:</strong></td>
    <td width="21%" align="right" ><select name="id_pecc_seleccion" id="id_pecc_seleccion">
      <?=listas($pi1, " estado = 1 and ano <> 0",$id_pecc ,'ano', 3);?>
    </select></td>
    <td width="34%" ><input name="button5" type="button" class="boton_grabar" id="button5" value="Cargar Formulario" onclick="carga_formulario_pecc_item(document.principal.id_pecc_seleccion.value,<?=$id_tipo_proceso_pecc?>)" /></td>
    <td width="15%" >&nbsp;</td>
  </tr>
</table>

<?
}else{
	?><input type="hidden" name="id_pecc_seleccion" id="id_pecc_seleccion" value="1" /><?
	}
	?>
<div id="carga_formulario"></div>
</body>
</html>
