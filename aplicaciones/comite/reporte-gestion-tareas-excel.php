<?php
  header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
  header("Content-type: application/force-download");
//  header("Content-type: $tipo");
  header("Content-Disposition: attachment; filename=Reporte de gestión de tareas.xls"); 
  header("Content-Transfer-Encoding: binary");
//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");
  $id_tarea=$_GET["id_tarea"];
  $id_usuario=$_GET["id_us"];
  $valida_permiso="select * from $ts6 where id_usuario=".$id_usuario." and id_rol_general=6";
  $resultado=traer_fila_row(query_db($valida_permiso));
  if($resultado[1]==6){//si el usuario tiene rol de secretario 
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <style>
  .titulo1 {
    font-size:24px;
    color:#135798;
      
  }
  .titulo2 {
    font-size:16px;
      
  }
  .titulo3 {
    font-size:20px;
    background-color:#135798;
    color:#FFF;
      
  }


  </style>
  </head>

  <body>
  <table border=1  width="100%" >
  <tr>
    <td height="107" colspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="24" align="left" class="titulo1"><strong>REPORTE DE GESTI&Oacute;N DE TAREAS DE COMIT&Eacute;</strong></td>
  </tr>
   <tr>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Estado De La Tarea</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Usuario Que Gestion&oacute;</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Fecha</div></td>
      <td width="9%" align="center" class="columna_subtitulo_resultados">Gesti&oacute;n</td>
    </tr>
  <?php
  $cont = 0;
  $query="select estado_tarea, nombre_administrador, fecha_gestion, cast(gestion AS TEXT) as gestion from $vcomite4 where id_tarea=".$id_tarea." order by fecha_gestion desc";
  $sel_proce=query_db($query);

  while($sele_tareas = traer_fila_db($sel_proce)){
      if($cont == 0){
        $clase= "filas_resultados";
      $cont = 1;
      }else{
        $clase= "";
      $cont = 0;//ajax_carga('../aplicaciones/comite/menu_comite.php?id_comite=<?=$sele_tareas[0]','id_div_sub');
      } ?>
    <tr class="<?=$clase?>">
        <?if ($sele_tareas[0]==1) { // Si es 1 la tarea está abierta. ?>
            <td align="center">Abierta</td>
        <?}else if ($sele_tareas[0]==3) { // si es 2 la tarea cerrada ?>
            <td align="center">Cerrada</td>
        <?}?>
      <td align="center"><?=$sele_tareas[1] ?></td>
      <td align="center"><?=$sele_tareas[2] ?></td>
      <td align="center"><?=$sele_tareas[3] ?></td>
    </tr>
<?  }//fin while?>
</table>
</body>
</html>
<? }else{//si el usuario no tiene rol de secretario
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <style>
  .titulo1 {
    font-size:24px;
    color:#135798;
      
  }
  .titulo2 {
    font-size:16px;
      
  }
  .titulo3 {
    font-size:20px;
    background-color:#135798;
    color:#FFF;
      
  }


  </style>
  </head>

  <body>
  <table border=1  width="100%" >
  <tr>
    <td height="107" colspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="24" align="left" class="titulo1"><strong>REPORTE DE GESTI&Oacute;N DE TAREAS DE COMIT&Eacute;</strong></td>
  </tr>
   <tr>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Estado De La Tarea</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Usuario Que Gestion&oacute;</div></td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Fecha</div></td>
      <td width="9%" align="center" class="columna_subtitulo_resultados">Gesti&oacute;n</td>
    </tr>
  <?php
  $cont = 0;
  $query="select estado_tarea, nombre_administrador, fecha_gestion, cast(gestion AS TEXT) as gestion from $vcomite4 where id_tarea=".$id_tarea." and id_responsable=".$id_usuario." order by fecha_gestion desc";
  $sel_proce=query_db($query);

  while($sele_tareas = traer_fila_db($sel_proce)){
      if($cont == 0){
        $clase= "filas_resultados";
      $cont = 1;
      }else{
        $clase= "";
      $cont = 0;//ajax_carga('../aplicaciones/comite/menu_comite.php?id_comite=<?=$sele_tareas[0]','id_div_sub');
      } ?>
    <tr class="<?=$clase?>">
        <?if ($sele_tareas[0]==1) { // Si es 1 la tarea está abierta. ?>
            <td align="center">Abierta</td>
        <?}else if ($sele_tareas[0]==3) { // si es 2 la tarea cerrada ?>
            <td align="center">Cerrada</td>
        <?}?>
      <td align="center"><?=$sele_tareas[1] ?></td>
      <td align="center"><?=$sele_tareas[2] ?></td>
      <td align="center"><?=$sele_tareas[3] ?></td>
    </tr>
<?  }//fin while?>
</table>
</body>
</html>
<? }
?>