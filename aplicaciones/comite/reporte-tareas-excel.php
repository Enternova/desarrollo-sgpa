<?php
  header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
  header("Content-type: application/force-download");
//  header("Content-type: $tipo");
  header("Content-Disposition: attachment; filename=Reporte de tareas.xls"); 
  header("Content-Transfer-Encoding: binary");
//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

function numero_item_pecc($numero1, $numero2, $numero3){
      
      $cuantos_en_numero = strlen($numero3);
        if($cuantos_en_numero == 1){
            $numero3 = "000".$numero3;
          }
        if($cuantos_en_numero == 2){
            $numero3 = "00".$numero3;
          }
        if($cuantos_en_numero == 3){
            $numero3 = "0".$numero3;
          }
          
      $numero = $numero1.$numero2."-".$numero3;
      return $numero;
    }

  $id_usuario=$_GET["id_us"];

  $valida_permiso="select * from $ts6 where id_usuario=".$id_usuario." and id_rol_general=6";
  $resultado=traer_fila_row(query_db($valida_permiso));
  $where="";
  $sql_comple="";
  if($_GET["estado"]){
      $sql_comple.= "estado=".$_GET["estado"];
  }
  if($_GET["busca_id_responsable"]){
    $id_res=split('----,',$_GET["busca_id_responsable"]);
    if ($id_res[1]!='undefined') {
      $sql_comple.= " and id_responsable = '".$id_res[1]."'";
    }
  }
  if($_GET["busca_id_cierre"]){
    $id_cierre=split('----,',$_GET["busca_id_cierre"]);
    if ($id_cierre[1]!='undefined') {
      $sql_comple.= " and id_cierre = '".$id_cierre[1]."'";
    }
  }
  if($_GET["fecha_cierre"]){
    $sql_comple.= " and fecha_cierre = '".$_GET["numero3_pecc"]."'";
    }
  if($_GET["busca_id_comite"]){
    $id_comite=split('----,',$_GET["busca_id_comite"]);
    if ($id_cierre[4]!='undefined') {
      $sql_comple.= " and id_comite= ".$id_comite[4];
    }
  }
  if($_GET["titulo"]){
    $sql_comple.= " and titulo like '%".$_GET["titulo"]."%'";
    }
  if ($sql_comple!="") {
    $where=" where ".$sql_comple;
  }

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
    <td colspan="24" align="left" class="titulo1"><strong>REPORTE DE TAREAS DE COMIT&Eacute;</strong></td>
  </tr>
   <tr>
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
  $query="select id_tarea, responsable, cierre, cast(titulo as text) as titulo, num1, num2, num3, fecha_cierre, nums1, nums2, muns3, id_responsable, id_cierre, estado, numt1, numt2, numt3 from $vcomite3 $where";
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
      <td align="center"><?
      if($sele_tareas[13]==1){
        echo "Abierta";
      }else if($sele_tareas[14]==3){
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
    <td colspan="24" align="left" class="titulo1"><strong>REPORTE DE TAREAS DE COMIT&Eacute; USER</strong></td>
  </tr>
   <tr>
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
  if($where==""){
    $query="select id_tarea, responsable, cierre, cast(titulo as text) as titulo, num1, num2, num3, fecha_cierre, nums1, nums2, muns3, id_responsable, id_cierre, estado, numt1, numt2, numt3 from $vcomite3 where id_responsable=".$id_usuario;
  }else{
    
    $query="select id_tarea, responsable, cierre, cast(titulo as text) as titulo, num1, num2, num3, fecha_cierre, nums1, nums2, muns3, id_responsable, id_cierre, estado, numt1, numt2, numt3 from $vcomite3 $where and id_responsable=".$id_usuario;
  }
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
      <td align="center"><?
      if($sele_tareas[13]==1){
        echo "Abierta";
      }else if($sele_tareas[14]==3){
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
</body>
</html>
<? }
?>