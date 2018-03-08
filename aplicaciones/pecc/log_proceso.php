<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
		
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td width="27%" valign="top">&nbsp;</td>
        <td width="27%" valign="top"><input type="button" name="input2" id="input2" onclick="abrir_ventana('../aplicaciones/reportes/auditor_lista_general_excel.php?id_solicitud=<?=$_GET["id_item_pecc"]?>&id_tipo_proceso_pecc=<?=$_GET["id_tipo_proceso_pecc"]?>')" value="Generar Reporte a Excel"/></td>
      </tr>
      <tr>
        <td width="54%" colspan="2" valign="top"><iframe src="../aplicaciones/reportes/auditor_lista_general.php?id_solicitud=<?=$_GET["id_item_pecc"]?>&id_tipo_proceso_pecc=<?=$_GET["id_tipo_proceso_pecc"]?>&paginas=<?=$_GET["paginas"]?>" width="100%" height="950px" frameborder="0" /> </iframe></td>
      </tr>
      
    </table></td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
</body>
</html>
