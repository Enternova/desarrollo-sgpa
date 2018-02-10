<?php
include("../../librerias/lib/@session.php");
verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
$valida_permiso="select * from tseg12_relacion_usuario_rol where id_usuario=".$_SESSION["id_us_session"]." and id_rol_general=6";
  $resultado=traer_fila_row(query_db($valida_permiso));
  $id_sesion=$_SESSION['id_us_session'];
  if($resultado[1]==6){
        $id_tarea = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));
        $sel_tarea=traer_fila_row(query_db("select id_tarea, responsable, cierre, cast(titulo as text) as titulo, num1, num2, num3, fecha_cierre, nums1, nums2, muns3, id_responsable, id_cierre, estado, numt1, numt2, numt3 from $vcomite3 where id_tarea =".$id_tarea));
        $consecutivo_comite=numero_item_pecc($sel_tarea[4],$sel_tarea[5],$sel_tarea[6]);
        $consecutivo_solicitud=numero_item_pecc($sel_tarea[8],$sel_tarea[9],$sel_tarea[10]);
        if($consecutivo_solicitud=="-"){
          $consecutivo_solicitud="";
        }
        $sele_comite = traer_fila_row(query_db("select id_tarea, id_responsable, id_cierre, id_comite, id_solicitud, fecha_apertura, fecha_cierre, cast(titulo as text) as titulo, cast(detalle as text) as detalle, cast(observacion as text) as observacion, estado, num1, num2, num3 from $c6 where id_tarea = ".$id_tarea));
 //paguinacion
$numero_pagi = 30;
if ($pag=="")
  $pag = 1;
else
  $pag = $pag;

$paginador = (($pag-1)*$numero_pagi);
    $li_n_c=traer_fila_row(query_db("select count(*) from $vcomite4 where id_tarea=".$id_tarea));
      $total_r = $li_n_c[0];
      $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
  $proxima = $pag;
else
  $proxima = $pag +1;
  
if($pag==1)
  $anterior = $pag;
else
  $anterior = $pag -1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
    <title>Documento sin t&iacute;tulo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">Edici&oacute;n de Tarea de Comit&eacute; - Resposable: <?=$sel_tarea[1]?>; Encargado de Cierre: <?=$sel_tarea[2]?></td>
  </tr>
</table>
<br />

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<?if($sele_comite[10]==1){//si la taera está abierta da la opción de editar?>
  <tr >
    <td width="15%" align="right"> Usuario Responsable:</td>
    <td width="25%" align="left"><input type="text" name="busca_id_responsable" value="<?=$sel_tarea[1].'----,'.$sel_tarea[11]?>" id="busca_id_responsable" onKeyUp="selecciona_lista()" /></td>
    <td width="5%" align="right"> Encargado Cierre:</td>
    <td width="25%" align="left"><input type="text" name="busca_id_cierre" value="<?=$sel_tarea[2].'----,'.$sel_tarea[12]?>" id="busca_id_cierre" onKeyUp="selecciona_lista()"/></td>
  </tr>
  <tr>
    <td width="" align="right">Fecha de cierre:</td>
    <td width="" align="left"><input type="text" value="<?=$sele_comite[6]?>" name="fecha_cierre" id="fecha_cierre" onmousedown="calendario_sin_hora('fecha_cierre')" /></td>
    <td width="" align="right"><label for="agrega_solicitud">Agregar Solicitud:</label><input type="checkbox" name="agrega_solicitud" id="agrega_solicitud" onclick="valida_grega_solicitud()" /></td>
    <td width="" align="left">
          <input type="text" disabled name="busca_id_solicitud" value="<?=$consecutivo_solicitud?>" id="busca_id_solicitud" onkeypress="selecciona_lista()" value="">
    </td>
  </tr>
  <tr>
    <td align="right">T&iacute;tulo:</td>
    <td align="left"><textarea type="text" name="titulo" id="titulo" value=""><?=utf8_decode($sele_comite[7]);?></textarea></td>
    <td align="right">Comit&eacute;:</td>
    <td align="left"><input type="text" name="busca_id_comite" value="<?=$consecutivo_comite?>"  id="busca_id_comite" disabled onkeypress="selecciona_lista()" value=""></td>
    
  </tr>
  <tr>
    <td colspan="1" align="right">Detalle:</td>
    <td colspan="5" align="left"><textarea name="detalle" id="detalle" cols="100" rows="3"><?=utf8_decode($sele_comite[8]);?></textarea></td>
  </tr>
  <tr>
    <td align="right">Estado:</td>
    <td align="left"><select name="pagij" id="estado">
            <? 
          if($sele_comite[10]==1){
           ?>
            <option value="<?=$sele_comite[10];?>"  <?echo "selected"; ?>>Abierta</option>
          <? } ?>
          <option value="3">Cerrada</option>
          </select></td>
    <td align="right"></td>
    <td align="right"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" name="button" id="button" value="Editar Tarea" class="boton_grabar" onclick="valida_modifica_tarea('<?=$id_tarea?>')" /></td>
    <td align="center"><input type="button" name="button" id="button" value="Volver" class="boton_volver" onclick="ajax_carga('../aplicaciones/comite/historico-tareas-comite.php','contenidos')" /></td>
    <td align="center">
      <input type="button" name="button" id="button" value="Agregar Otra Gesti&oacute;n" class="boton_grabar" onclick="muestra_gestion_tarea_admin()" />
    </td>
  </tr>
  <tr>
    <td colspan="5" align="right">
      <a href="javascript:document.location.assign('../aplicaciones/comite/reporte-gestion-tareas-excel.php?id_tarea='+<?=$id_tarea?>+'&id_us='+<?=$id_sesion?>)"><strong><font size="+1">Generar Reporte  en EXCEL</font></strong> <img src="../imagenes/mime/xlsx.gif"></a>
        
        
        </td>
  </tr>
  <?}else{?>
  <tr>
    <td align="center"><input type="button" name="button" id="button" value="Volver" class="boton_volver" onclick="ajax_carga('../aplicaciones/comite/historico-tareas-comite.php','contenidos')" /></td>
    <td colspan="5" align="right">
      <a href="javascript:document.location.assign('../aplicaciones/comite/reporte-gestion-tareas-excel.php?id_tarea='+<?=$id_tarea?>+'&id_us='+<?=$id_sesion?>)"><strong><font size="+1">Generar Reporte  en EXCEL</font></strong> <img src="../imagenes/mime/xlsx.gif"></a>    
        </td>
  </tr>
  <?}?>
</table>
<div id="respuesta_tarea_admin" style="display: none" align="center">
  <tr>
    <td width="" align="right">Campo de Respuesta:</td>
    <td colspan="3" width="" align="left"><textarea name="detalle_gestion" id="detalle_gestion" cols="100" rows="3"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" name="button" id="button" value="Responder" class="boton_grabar" onclick="responder_gestion(1,'<?=$id_tarea?>')" /></td>
    <td colspan="" align="center"><input type="button" name="button" id="button" value="Archivar Gestion" class="boton_eliminar" onclick="archivar_gestion()" /></td>
    <td align="center"><input type="button" name="button" id="button" value="Volver" class="boton_volver" onclick="oculta_respuesta_tarea_admin()" /></td>
  </tr>
</div>
<div id="genera_gestion_tarea_admin" style="display: none" align="center">
  <tr>
    <td width="" align="right">Gesti&oacute;n:</td>
    <td colspan="3" width="" align="left"><textarea name="detalle_gestion" id="genera_detalle_gestion" cols="100" rows="3"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button" name="button" id="button" value="Guardar" class="boton_grabar" onclick="genera_gestion(1,'<?=$id_tarea?>')" /></td>
    <td align="center"><input type="button" name="button" id="button" value="Volver" class="boton_volver" onclick="oculta_gestion_tarea_admin()" /></td>
  </tr>
</div>
<?php  
    /**************TABLA PARA MOSTRAR LAS GESTIONES DE LA TAREA EN CASO DE SER ADMINISTRADOR*********/
?>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">Detalles de las gestiones de la tarea</td>
  </tr>
</table>
<?php
$query=traer_fila_row(query_db("select count(*) from $vcomite4 where id_tarea=".$sele_comite[0]));
  //$num_filas=numfilas_db($qurey);
  if($query[0]!=0){//trae el historico de gestiones de la tarea.
?>
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
    <td colspan="10" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left"></div></td>
        <td width="6%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/edicion-comite-tarea.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
      for($i=1;$i<=$pagina;$i++){
       ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/edicion-comite-tarea.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
    <tr>
      <td width="2%" height="29" class="columna_subtitulo_resultados">&nbsp;</td>
      <td width="3%" class="columna_subtitulo_resultados"><div align="center">Estado Tarea</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Usuario Que Gestion&oacute;</div></td>
      <td width="3%" class="columna_subtitulo_resultados"><div align="center">Fecha</div></td>
      <td width="20%" class="columna_subtitulo_resultados"><div align="center">Gesti&oacute;n</div></td>
    </tr>
  <?php
  $cont = 0;
  $sel_proce=query_db("select id_gestion, id_tarea, responsable, cierre, cast(titulo as text) as titulo, fecha_cierre, id_responsable, id_cierre, estado, cast(gestion as text) asgestion, fecha_gestion, estado_tarea, id_usuario, nombre_administrador, num1, num2, num3 from $vcomite4 where id_tarea=".$id_tarea." order by fecha_gestion desc");
  while($sele_tareas = traer_fila_db($sel_proce)){
      if($cont == 0){
        $clase= "filas_resultados";
      $cont = 1;
      }else{
        $clase= "";
      $cont = 0;//ajax_carga('../aplicaciones/comite/menu_comite.php?id_comite=<?=$sele_tareas[0]','id_div_sub');
      } ?>
    <tr class="<?=$clase?>">
        <?//si la tarea tiene una gestión pendiente se da la posibilidad de responder
            if($sele_tareas[8]==3 AND $sele_tareas[11]==1){
              $id_gestion=$sele_tareas[0];
              $id_tarea=$sele_tareas[1];
            ?>
            <td align="center" ><a href="javascript:muestra_respuesta_tarea_admin();"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
        <?    }else{?>
            <td align="center">&nbsp;</td>
        <?    }//fin de la validacion de responder gestion
        ?>
      <?php
        if ($sele_tareas[11]==1) { // Si es 1 la tarea está abierta. ?>
            <td align="center">Abierta</td>
        <?}else if ($sele_tareas[11]==3) { // si es 2 la tarea cerrada ?>
            <td align="center">Cerrada</td>
        <?}?>
      <td align="center"><?=$sele_tareas[13] ?></td>
      <td align="center"><?=$sele_tareas[10] ?></td>
      <td align="center"><?=utf8_decode($sele_tareas[9]) ?></td>
    </tr>
<?  }//fin while
}//fin if de mostrar gestion tareas de administrador
$sel_tarea=traer_fila_row(query_db("select * from $vcomite4 where id_tarea =".$id_tarea." and estado=3"));
?>
</table>
    <input type="hidden" name="id_comite" id="modifica_tarea" value="<?= $sele_comite[0] ?>" />
    <input type="hidden" name="id_comite" id="modifica_responsable" value="<?= $sele_comite[1] ?>" />
    <input type="hidden" name="id_comite" id="modifica_cierre" value="<?= $sele_comite[2] ?>" />
    <input type="hidden" name="id_comite" id="modifica_comite" value="<?= $sele_comite[3] ?>" />
    <input type="hidden" name="id_comite" id="modifica_solicitud" value="<?= $sele_comite[4] ?>" />

    <input type="hidden" name="id_gestion" id="id_gestion" value="<?=$sel_tarea[0]?>" />
    <input type="hidden" name="id_tarea" id="id_tarea" value="<?=$sel_tarea[1]?>" />
</body>
</html>
<?php }else{ //si no es administrador se habilita sólo gestión de la tarea
    $id_tarea = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));
    $sel_tarea=traer_fila_row(query_db("select * from $vcomite4 where id_tarea =".$id_tarea));
   //paguinacion
$numero_pagi = 30;
if ($pag=="")
  $pag = 1;
else
  $pag = $pag;

$paginador = (($pag-1)*$numero_pagi);
    $li_n_c=traer_fila_row(query_db("select count(*) from $vcomite4 where id_responsable=".$_SESSION['id_us_session']." and id_tarea=".$id_tarea));
      $total_r = $li_n_c[0];
      $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
  $proxima = $pag;
else
  $proxima = $pag +1;
  
if($pag==1)
  $anterior = $pag;
else
  $anterior = $pag -1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
    <title>Documento sin t&iacute;tulo</title>
    <link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">Gesti&oacute;n de Tarea de Comit&eacute; - Resposable: <?=$sel_tarea[2]?>; Encargado de Cierre: <?=$sel_tarea[3]?></td>
  </tr>
  
  <tr>
    <td colspan="5" align="right">
      <a href="javascript:document.location.assign('../aplicaciones/comite/reporte-gestion-tareas-excel.php?id_tarea='+<?=$id_tarea?>+'&id_us='+<?=$id_sesion?>)"><strong><font size="+1">Generar Reporte  en EXCEL</font></strong> <img src="../imagenes/mime/xlsx.gif"></a>
        
        
        </td>
  </tr>
</table>
<br />
<div id="respuesta_tarea_usuario" style="display: none" align="center">
  <tr>
    <td width="" align="right">Campo de Respuesta:</td>
    <td colspan="2" width="" align="left"><textarea name="detalle_gestion" id="detalle_gestion" cols="100" rows="3"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button" name="button" id="button" value="Responder" class="boton_grabar" onclick="responder_gestion(3,'<?=$id_tarea?>')" /></td>

    <td colspan="" align="center"><input type="button" name="button" id="button" value="Archivar Gestion" class="boton_eliminar" onclick="archivar_gestion()" /></td>
    <td align="center"><input type="button" name="button" id="button" value="Volver" class="boton_volver" onclick="oculta_respuesta_tarea()" /></td>
  </tr>
</div>

<div id="genera_gestion_tarea_usuario" style="display: none" align="center">
  <tr>
    <td width="" align="right">Gesti&oacute;n:</td>
    <td colspan="3" width="" align="left"><textarea name="detalle_gestion" id="genera_detalle_gestion" cols="100" rows="3"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button" name="button" id="button" value="Guardar" class="boton_grabar" onclick="genera_gestion(3,'<?=$id_tarea?>')" /></td>
    <td align="center"><input type="button" name="button" id="button" value="Volver" class="boton_volver" onclick="oculta_gestion_tarea()" /></td>
  </tr>
</div>
<div id="respuesta_tarea_usuario" align="center">
    <td colspan="3" align="center"><?if ($sele_tareas[11]==1) {?><input type="button" name="button" id="button" value="Agregar Otra Gesti&oacute;n" class="boton_grabar" onclick="muestra_gestion_tarea()" /><?}?></td>
    <td align="center"><input type="button" name="button" id="button" value="Volver" class="boton_volver" onclick="ajax_carga('../aplicaciones/comite/historico-tareas-comite.php','contenidos')" /></td>
</div>
</table>

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">Detalles de las gestiones de la tarea</td>
  </tr>
<?php
$query=traer_fila_row(query_db("select count(*) from $vcomite4 where id_responsable=".$_SESSION['id_us_session']." and id_tarea=".$id_tarea));
  //$num_filas=numfilas_db($qurey);
  if($query[0]!=0){//trae el historico de gestiones de la tarea.
?>
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
    <td colspan="10" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left"></div></td>
        <td width="6%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tareas-comite.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
      for($i=1;$i<=$pagina;$i++){
       ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/tareas-comite.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
    <tr>
      <td width="2%" height="29" class="columna_subtitulo_resultados">&nbsp;</td>
      <td width="3%" class="columna_subtitulo_resultados"><div align="center">Estado Tarea</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Usuario Que Gestion&oacute;</div></td>
      <td width="3%" class="columna_subtitulo_resultados"><div align="center">Fecha</div></td>
      <td width="20%" class="columna_subtitulo_resultados"><div align="center">Gesti&oacute;n</div></td>
    </tr>
  <?php
  $cont = 0;
  $sel_proce=query_db("select id_gestion, id_tarea, responsable, cierre, cast(titulo as text) as titulo, fecha_cierre, id_responsable, id_cierre, estado, cast(gestion as text) asgestion, fecha_gestion, estado_tarea, id_usuario, nombre_administrador, num1, num2, num3 from $vcomite4 where id_responsable=".$_SESSION['id_us_session']." and id_tarea=".$id_tarea." order by fecha_gestion desc");
  while($sele_tareas = traer_fila_db($sel_proce)){
      if($cont == 0){
        $clase= "filas_resultados";
      $cont = 1;
      }else{
        $clase= "";
      $cont = 0;//ajax_carga('../aplicaciones/comite/menu_comite.php?id_comite=<?=$sele_tareas[0]','id_div_sub');
      } ?>
    <tr class="<?=$clase?>">
        <?//si la tarea tiene una gestión pendiente se da la posibilidad de responder
            if($sele_tareas[8]==1 AND $sele_tareas[11]==1){ ?>
            <td align="center" ><a href="javascript:muestra_respuesta_tarea();"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
        <?    }else{?>
            <td align="center">&nbsp;</td>
        <?    }//fin de la validacion de responder gestion
        ?>
      <?php
        if ($sele_tareas[11]==1) { // Si es 1 la tarea está abierta. ?>
            <td align="center">Abierta</td>
        <?}else if ($sele_tareas[11]==3) { // si es 2 la tarea cerrada ?>
            <td align="center">Cerrada</td>
        <?}?>
      <td align="center"><?=$sele_tareas[13] ?></td>
      <td align="center"><?=$sele_tareas[10] ?></td>
      <td align="center"><?=utf8_decode($sele_tareas[9]); ?></td>
    </tr>
<?  }//fin while
}//fin if
$sel_tarea=traer_fila_row(query_db("select * from $vcomite4 where id_tarea =".$id_tarea." and estado=1"));
?>  </table>
    <input type="hidden" name="id_gestion" id="id_gestion" value="<?=$sel_tarea[0]?>" />
    <input type="hidden" name="id_tarea" id="id_tarea" value="<?=$sel_tarea[1]?>" />
</body>
</html>
<?}

?>