<?
  //error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
  include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	$valida_permiso="select * from $ts6 where id_usuario=".$_SESSION["id_us_session"]." and id_rol_general=6";
  $resultado=traer_fila_row(query_db($valida_permiso));
 
  if($resultado[1]==6){
    $query="select nombre_administrador from $g1 where us_id=".$_SESSION["id_us_session"];
    $nombre_usuario=traer_fila_row(query_db($query));

    //paguinacion
$numero_pagi = 30;
if ($pag=="")
  $pag = 1;
else
  $pag = $pag;

$paginador = (($pag-1)*$numero_pagi);
    $li_n_c=traer_fila_row(query_db("select * from $vcomite4"));
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
<?php
  $query=traer_fila_row(query_db("select count(*) from $c6"));
  //$num_filas=numfilas_db($qurey);
  if($query[0]!=0){?>
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr >
    <td width="15%" align="right"> Usuario Responsable:</td>
    <td width="25%" align="left"><input type="text" name="busca_id_responsable" id="busca_id_responsable" onKeyUp="selecciona_lista()" /></td>
    <td width="5%" align="right"> Encargado Cierre:</td>
    <td width="25%" align="left"><input type="text" name="busca_id_cierre" id="busca_id_cierre" onKeyUp="selecciona_lista()"/></td>
  </tr>
  <tr>
    <td width="" align="right">Fecha de cierre:</td>
    <td width="" align="left"><input type="text" name="fecha_cierre" id="fecha_cierre" onmousedown="calendario_se('fecha_cierre')" /></td>
    <td align="right">Comit&eacute;:</td>
    <td align="left"><input type="text" name="busca_id_comite" id="busca_id_comite" onkeypress="selecciona_lista()"></td>
  </tr>
  <tr>
    <td align="right">T&iacute;tulo:</td>
    <td colspan="7" align="left"><input type="text" name="titulo" id="titulo"/></td>
    <td align="right">Estado:</td>
    <td align="left"><select name="pagij" id="estado">
          <option value="1">Abierta</option>
          <option value="3">Cerrada</option>
          </select></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button" name="button" id="button" value="Buscar" class="boton_grabar" onclick="ajax_carga('../aplicaciones/comite/historico-tareas-comite.php?id_comite=<?=$sele_tareas[0]?>','contenidos');" /></td>
  </tr>
  <td colspan="5" align="right"><a href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/pecc/reportes_historico.php?id_pecc=1&amp;id_tipo_proceso_pecc=&amp;numero1_pecc='+document.principal.numero1_pecc.value+'&amp;numero2_pecc='+document.principal.numero2_pecc.value+'&amp;numero3_pecc='+document.principal.numero3_pecc.value+'&amp;bus_area='+document.principal.bus_area.value+'&amp;bus_text1='+document.principal.bus_text1.value+'&amp;bus_text2='+document.principal.bus_text2.value+'&amp;bus_text3='+document.principal.bus_text3.value+'&amp;bus_text4='+document.principal.bus_text4.value+'&amp;bus_text5='+document.principal.bus_text5.value+'&amp;profesional_cyc='+document.principal.profesional_cyc.value+'&amp;usuario_permiso='+document.principal.usuario_permiso.value+'&amp;estado_busr='+document.principal.estado_busr.value+'&amp;tipo_contratacion='+document.principal.tipo_contratacion.value+'&amp;preparador_b='+document.principal.preparador_b.value+'&amp;muestra_finalizados='+document.principal.muestra_finalizados.value+'&amp;tp_proceso_busca='+document.principal.tp_proceso_busca.value+'&amp;num_solped_bus='+document.principal.num_solped_bus.value+'&amp;origen_pecc='+document.principal.origen_pecc.value"><strong><font size="+1">Generar Reporte Detallado en EXCEL</font></strong> <img src="../imagenes/mime/xlsx.gif"></a>
        
        
        </td>
</table>
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
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Responsable</div></td>
      <td width="9%" align="center" class="columna_subtitulo_resultados">Encargado de Cierre</td>
      <td width="9%" class="columna_subtitulo_resultados"><div align="center">Titulo</div></td>
      <td width="6%" class="columna_subtitulo_resultados"><div align="center">Comite</div></td>
      <td width="9%" class="columna_subtitulo_resultados">Solicitud</td>
      <td width="8%" class="columna_subtitulo_resultados"><div align="center">Fecha de Cierre</div></td>
    </tr>
  <?php
  $cont = 0;
  $sel_proce=query_db("select id_tarea, responsable, cierre, cast(titulo as text) as titulo, num1, num2, num3, fecha_cierre, nums1, nums2, muns3, id_responsable, id_cierre, estado, numt1, numt2, numt3 from $vcomite3");
  while($sele_tareas = traer_fila_db($sel_proce)){
      if($cont == 0){
        $clase= "filas_resultados";
      $cont = 1;
      }else{
        $clase= "";
      $cont = 0;//ajax_carga('../aplicaciones/comite/menu_comite.php?id_comite=<?=$sele_tareas[0]','id_div_sub');
      } ?>
    <tr class="<?=$clase?>">
      <td align="center" ><a href="javascript:ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite=<?=$sele_tareas[0]?>','contenidos');"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
      <td align="center"><?
      if($sele_tareas[13]==1){
        echo "Abierta";
      }else if($sele_tareas[14]==2){
        echo "Cerrada";
      }
      ?></td>
      <td align="center"><?=numero_item_pecc($sele_tareas[14],$sele_tareas[15],$sele_tareas[16]) ?></td>
      <td align="center"><?=$sele_tareas[1] ?></td>
      <td align="center"><?=$sele_tareas[2] ?></td>
      <td align="center"><?=$sele_tareas[3] ?></td>
      <td align="center"><?php 

        $consecutivo_comite=numero_item_pecc($sele_tareas[4],$sele_tareas[5],$sele_tareas[6]);
        echo $consecutivo_comite;
      ?></td>
      <td align="center"><?php
        $consecutivo_solicitud=numero_item_pecc($sele_tareas[8],$sele_tareas[9],$sele_tareas[10]);
        echo $consecutivo_solicitud;
      ?></td>
      <td align="center"><?=$sele_tareas[7] ?></td>
    </tr>
<?  }//fin while?>
</table>
<?}else{?>
  <h3>No tiene tareas creadas a&uacute;n</h3>
<?}//fin if
?>
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
<?}else{//si el usuario logeado no es rol secretario

//paguinacion
$numero_pagi = 30;
if ($pag=="")
  $pag = 1;
else
  $pag = $pag;

$paginador = (($pag-1)*$numero_pagi);
    $li_n_c=traer_fila_row(query_db("select * from $vcomite4 where id_responsable=".$_SESSION['id_us_session']));
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
    <td colspan="7"  class="titulos_secciones">M&oacute;dulo de Tareas de Comit&eacute;</td>
  </tr>
</table>
<br />
<?php
  $query=traer_fila_row(query_db("select count(*) from $vcomite4 where id_responsable=".$_SESSION['id_us_session']));
  //$num_filas=numfilas_db($qurey);
  if($query[0]!=0){?>
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
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Responsable</div></td>
      <td width="9%" align="center" class="columna_subtitulo_resultados">Encargado de Cierre</td>
      <td width="9%" class="columna_subtitulo_resultados"><div align="center">Titulo</div></td>
      <td width="6%" class="columna_subtitulo_resultados"><div align="center">Comite</div></td>
      <td width="9%" class="columna_subtitulo_resultados">Solicitud</td>
      <td width="8%" class="columna_subtitulo_resultados"><div align="center">Fecha de Cierre</div></td>
    </tr>
  <?php
  $cont = 0;
  $sel_proce=query_db("select id_tarea, responsable, cierre, cast(titulo as text) as titulo, num1, num2, num3, fecha_cierre, nums1, nums2, muns3, id_responsable, id_cierre, estado, numt1, numt2, numt3 from $vcomite3 where id_responsable=".$_SESSION['id_us_session']);
  while($sele_tareas = traer_fila_db($sel_proce)){
      if($cont == 0){
        $clase= "filas_resultados";
      $cont = 1;
      }else{
        $clase= "";
      $cont = 0;//ajax_carga('../aplicaciones/comite/menu_comite.php?id_comite=<?=$sele_tareas[0]','id_div_sub');
      } ?>
    <tr class="<?=$clase?>">
      <td align="center" ><a href="javascript:ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite=<?=$sele_tareas[0]?>','contenidos');"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
      <td align="center"><?
      if($sele_tareas[13]==1){
        echo "Abierta";
      }else if($sele_tareas[14]==2){
        echo "Cerrada";
      }
      ?></td>
      <td align="center"><?=numero_item_pecc($sele_tareas[14],$sele_tareas[15],$sele_tareas[16]) ?></td>
      <td align="center"><?=$sele_tareas[1] ?></td>
      <td align="center"><?=$sele_tareas[2] ?></td>
      <td align="center"><?=$sele_tareas[3] ?></td>
      <td align="center"><?php 

        $consecutivo_comite=numero_item_pecc($sele_tareas[4],$sele_tareas[5],$sele_tareas[6]);
        echo $consecutivo_comite;
      ?></td>
      <td align="center"><?php
        $consecutivo_solicitud=numero_item_pecc($sele_tareas[8],$sele_tareas[9],$sele_tareas[10]);
        echo $consecutivo_solicitud;
      ?></td>
      <td align="center"><?=$sele_tareas[7] ?></td>
    </tr>
<?  }//fin while?>
</table>
<?}else{?>
  <h3>No tiene tareas pendientes</h3>
<?}//fin if
?>

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
<?}
?>