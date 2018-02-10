<?php
  include("../../librerias/lib/@session.php");
  verifica_menu("administracion.html");
  header('Content-Type: text/xml; charset=ISO-8859-1');
  echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
  $id_gestion=elimina_comillas(arreglo_recibe_variables($_GET["id_gestion"]));
  $id_tarea = elimina_comillas(arreglo_recibe_variables($_GET["id_tarea"]));
  $sel_tarea=traer_fila_row(query_db("select * from $vcomite4 where id_tarea =".$id_tarea." and estado=3"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
    <title>Documento sin t&iacute;tulo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">Gesti&oacute;n de Tarea de Comit&eacute; - Rsposable: <?=$sel_tarea[2]?>; Encargado de Cierre: <?=$sel_tarea[3]?></td>
  </tr>
</table>
<br />
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr >
    <td width="15%" align="right"> Gesti&oacute;n de tarea:</td>
    <td width="25%" align="left"><textarea disabled cols="100" rows="3"><?=$sel_tarea[9]?></textarea></td>
    <td width="5%" align="right"> Estado:</td>
    <td width="25%" align="left"><textarea disabled cols="100" rows="3">Pendiente.</textarea></td>
  </tr>
  <tr>
    <td width="" align="right">Campo de Respuesta:</td>
    <td colspan="3" width="" align="left"><textarea name="detalle_gestion" id="detalle_gestion" cols="100" rows="3"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button" name="button" id="button" value="Responder" class="boton_grabar" onclick="responder_gestion(1)" /></td>
    <td align="center"><input type="button" name="button" id="button" value="Volver" class="boton_volver" onclick="ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite=<?=$id_tarea?>','contenidos')" /></td>
  </tr>
</table>
<input type="hidden" name="id_gestion" id="id_gestion" value="<?=$id_gestion?>" />
<input type="hidden" name="id_tarea" id="id_tarea" value="<?=$id_tarea?>" />