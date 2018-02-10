<?php
  //error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
  include("../../librerias/lib/@session.php"); 
  verifica_menu("administracion.html");
  header('Content-Type: text/xml; charset=ISO-8859-1');
  echo '<?xml version="1.0" encoding="ISO-8859-1"?>'; 
    $query="select nombre_administrador from $g1 where us_id=".$_SESSION["id_us_session"];
    $nombre_usuario=traer_fila_row(query_db($query));
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">Creaci&oacute;n de Tareas de Comit&eacute;</td>
  </tr>
</table>
<br />
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr >
    <td width="15%" align="right"> Usuario Responsable:</td>
    <td width="25%" align="left"><input type="text" name="busca_id_responsable" id="busca_id_responsable" onKeyUp="selecciona_lista()" /></td>
    <td width="5%" align="right"> Encargado Cierre:</td>
    <td width="25%" align="left"><input type="text"  name="busca_id_cierre" id="busca_id_cierre" value="" /></td>
  </tr>
  <tr>
    <td width="" align="right">Fecha de cierre:</td>
    <td width="" align="left"><input type="text" name="fecha_cierre" id="fecha_cierre" onmousedown="calendario_sin_hora('fecha_cierre')" /></td>
    <td width="" align="right"><label for="agrega_solicitud">Agregar Solicitud:</label><input type="checkbox" name="agrega_solicitud" id="agrega_solicitud" onclick="valida_grega_solicitud()" /></td>
    <td width="" align="left">
          <input type="text" disabled name="busca_id_solicitud" id="busca_id_solicitud" onkeypress="selecciona_lista()" value="">
    </td>
  </tr>
  <tr>
    <td align="right">T&iacute;tulo:</td>
    <td align="left"><input type="text" name="titulo" id="titulo"/></td>
    <td align="right">Comit&eacute;:</td>
    <td align="left"><input type="text" name="busca_id_comite" id="busca_id_comite" onkeypress="selecciona_lista()"></td>
    
  </tr>
  <tr>
    <td colspan="1" align="right">Detalle:</td>
    <td colspan="5" align="left"><textarea name="detalle" id="detalle" cols="100" rows="3"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button" name="button" id="button" value="Crear Tarea" class="boton_grabar" onclick="crear_tarea()" /></td>
  </tr>
</table>
<div id="contenidos"></div>
<input type="hidden" name="aleatorio" id="aleatorio" value="<?=$aleatorio?>" />
<input type="hidden" name="id_comite" id="id_comite" value="" />
<input type="hidden" name="id_solicitud" id="id_solicitud" value="" />
<input type="hidden" name="id_comite_agrega" id="id_comite_agrega"/>
<input type="hidden" name="id_item_agrega" id="id_item_agrega" />
<input type="hidden" name="orden_cambia" id="orden_cambia" />
<input type="hidden" name="id_relacion" id="id_relacion" />
<input type="hidden" name="quita_asistente" id="quita_asistente" />
</body>
</html>