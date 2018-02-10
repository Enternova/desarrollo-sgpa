<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato)); 
  $area_default="";
	$id_documento_arr = elimina_comillas(arreglo_recibe_variables($id_documento));
  $sel_id_item=traer_fila_row(query_db("SELECT id_item FROM $co1 WHERE id=$id_contrato_arr"));
  $busca_area_pecc=query_db("SELECT * FROM tabla_contrato_area($sel_id_item[0])");
  while($area=traer_fila_row($busca_area_pecc)){//INICIO WHILE BUSCA_AREA_PECC
    $area_default=$area_default."'".$area[0]."'";
  }//FIN WHILE BUSCA_AREA_PECC
  if ($area_default!=""){
    $area_default=str_replace("''", ", ", $area_default);
    $area_default=str_replace("'", "", $area_default);
  }
  //echo $area_default."<br>";
  $id_gerente=traer_fila_row(query_db("SELECT gerente FROM $co1 WHERE id=$id_contrato_arr"));
   echo $sel_v_usuario_area="SELECT * FROM $v_contra3 WHERE id_usuario=$id_gerente[0] AND id_area NOT IN($area_default)";
    $usuario_area=query_db($sel_v_usuario_area);
    while($area=traer_fila_row($usuario_area)){//INICIO WHILE USUARIO_AREA
      if ($area_default!=""){
        $area_default=$area_default.", '".$area[2]."'";
      }else{
        $area_default=$area_default."'".$area[2]."'";
      }
    }//FIN WHILE USUARIO_AREA
    $contrato_area=query_db("SELECT * FROM $v_contra4 WHERE id_contrato=".$id_contrato_arr);
    while($area=traer_fila_row($contrato_area)){//INICIO WHILE CONTRATO_AREA
      if ($area_default!=""){
        $area_default=$area_default.", '".$area[2]."'";
      }else{
        $area_default=$area_default."'".$area[2]."'";
      }
    }//FIN WHILE CONTRATO_AREA
    if ($area_default!=""){
      $area_default=str_replace("''", ", ", $area_default);
      $area_default=str_replace("'", "", $area_default);
    }
  //echo $area_default."<BR>";
	//echo $id_contrato_arr." gerente ".$_SESSION["id_us_session"]." gerente ".$id_gerente[0]."<br>";  
	
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
echo imprime_cabeza_contrato($id_contrato);
  if($id_gerente[0]==$_SESSION["id_us_session"]){
    echo $area_default;
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
      <td colspan="2" class="fondo_2">Agregar Areas al Contrato</td>
    </tr>
    
    <tr>
      <td align="right" ><strong>Area</strong>:</td>
      <td >         
      <select name="id_area" id="id_area">
        <?
          if ($area_default!=""){
        ?>
         <?=listas($g12, " estado = 1 AND t1_area_id NOT IN($area_default)",0,'nombre', 1);?>
         <?
          }else{
         ?>
          <?=listas($g12, " estado = 1 ",0,'nombre', 1);?>
         <?
          }
         ?>
      </select></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="left"><input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Documento" onclick="graba_contrato_area()"/></td>
        </tr>
</table>
<?
}
?>



  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td width="5%" height="29" class="fondo_3">&nbsp;</td>
          <td width="70%" align="center" class="fondo_3"><div align="center">Area</div></td>
          <td width="15%" align="center" class="fondo_3"><div align="center">Acci&oacute;n</div></td>
        </tr>
      <?
        $busca_area_pecc=query_db("SELECT * FROM tabla_contrato_area($sel_id_item[0])");
        while($area=traer_fila_row($busca_area_pecc)){//INICIO WHILE BUSCA_AREA_PECC
      ?>
          <tr class="filas_resultados">
            <td>&nbsp;&nbsp;</td>
            <td><?=$area[1]?></td>          
            <td>&nbsp;&nbsp;</td>
          </tr>
      <?
        }//FIN WHILE BUSCA_AREA_PECC

        $sel_v_usuario_area="SELECT * FROM $v_contra3 WHERE id_usuario=$id_gerente[0] AND id_area NOT IN($area_item[0]) ORDER BY NOMBRE ASC";
        $usuario_area=query_db($sel_v_usuario_area);
        while($area=traer_fila_row($usuario_area)){//INICIO WHILE USUARIO_AREA
      ?>
        <tr class="filas_resultados">
          <td>&nbsp;&nbsp;</td>
          <td><?=$area[3]?></td>          
          <td>&nbsp;&nbsp;</td>
        </tr>
        <?
        }//FIN WHILE USUARIO_AREA
        /*if ($area_default=""){
          $sel_v_usuario_area="SELECT * FROM $v_contra4 WHERE id_contrato=".$id_contrato_arr;
        }else{
          $sel_v_usuario_area="SELECT * FROM $v_contra4 WHERE id_contrato=".$id_contrato_arr." AND nombre NOT IN($area_default)";
        }*/
        $sel_v_usuario_area="SELECT * FROM $v_contra4 WHERE estado=1 AND id_contrato=".$id_contrato_arr." ORDER BY NOMBRE ASC";
        $usuario_area=query_db($sel_v_usuario_area);
        while($area=traer_fila_row($usuario_area)){//INICIO WHILE CONTRATOS_AREA
      ?>
        <tr class="filas_resultados">
          <td>&nbsp;&nbsp;</td>
          <td><?=$area[3]?></td>          
        <?
          if($id_gerente[0]==$_SESSION["id_us_session"]){
        ?>
        <td>
          <a href="javascript:elimina_contrato_area(<?=$area[6]?>)"><img src="../imagenes/botones/eliminada_temporal.gif" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
        <?
          }else{
        ?>
          <td>&nbsp;&nbsp;</td>
        <?
          }
        ?>
        </tr>
        <?
        }//FIN WHILE CONTRATOS_AREA
        ?>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left">
        <?
              if($sql_com[4] != ""){
        ?>
                <?=saca_nombre_anexo($sql_com[4])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sql_com[4]?>&n1=<?=$sql_com[0]?>&n3=7&n4=doc" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sql_com[4])?>.gif" width="16" height="16" />
                  </a>
                  <?
        }
          ?>
        </td>
      </tr>
      
      
      </table>
<input name="id_documento" type="hidden" value="<?=$id_documento;?>" />
<input name="id_contrato" type="hidden" value="<?=$id_contrato_arr;?>" />
<input name="id_elimina" type="hidden" value="" />

</body>
</html>
