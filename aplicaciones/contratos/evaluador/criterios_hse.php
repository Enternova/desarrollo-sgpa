<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
	<tr>
		<td width="50%" valign="top">
            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
             <?
	$lista_poliza_int = "select id,nombre,estado from ".$evf3."  where estado = 1 order by id";
	$sql_poliza_int=query_db($lista_poliza_int);
	while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
	?>    
                <tr>
                    <td  onclick="ajax_carga('../aplicaciones/contratos/evaluador/c_criterio_hse.php?id_plantilla_hse=<?=arreglo_pasa_variables($lista_poliza_int[0]);?>','carga_acciones_permitidas2')">&nbsp;&nbsp;>>&nbsp;<?=$lista_poliza_int[1];?></td>
                </tr>
                 <?
	}
				 ?>
            </table>
        </td>
	</tr>
	<tr>
	  <td valign="top" id="carga_acciones_permitidas2">&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br />
  <br />
</p>
</body>
</html>
