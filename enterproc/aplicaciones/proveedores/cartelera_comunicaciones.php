<? include("../../librerias/lib/@session.php");
  header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';  
    verifica_menu("procesos.html");
  $id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
  
  $busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
  $sql_e=traer_fila_row(query_db($busca_procesos));

	$inserta_visualizacion = query_db("insert into in_ingreso_sistema (us_id, fecha_ingreso, ultima_conexion, ip, session, modulo, pro1_id, pv_id) 
	values ( ".$_SESSION["id_us_session"].", '$fecha $hora','', '".$_SERVER['REMOTE_ADDR']."', '','Modulo de cartelera de comunicados',$id_invitacion,".$_SESSION["id_proveedor"].")");


$bus_alertas="select * from $t29 where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." and tp13_id  = 2";
$sql_alert=traer_fila_row(query_db($bus_alertas));
if($sql_alert[0]>=1){

$cambia_estado_alertas = query_db("update $t29 set estado = 2, quien_ingresa ='Proveedor' where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." and tp13_id  = 2 ");

$cambia = query_db("insert into  $t26 (pro1_id,pv_id,us_id, fecha_hora_gestion,detalle_gestion,proxima_llamada,tp14_id) 
    values ($id_invitacion,".$_SESSION["id_proveedor"].",".$_SESSION["id_us_session"].",'$fecha $hora', 'El proveedor visualiza la cartelera de aclaraciones','', 1)");


}

  $busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

  /*fechas cartelera general*/
    if ( ($fecha." ".$hora >= $sql_e[29]  ) && ($sql_e[34] >= $fecha." ".$hora ) ) 
      $apertura=1;
    elseif ( ($fecha." ".$hora >= $sql_e[35]  ) && ($sql_e[36] >= $fecha." ".$hora ) ) 
      $apertura=1;
    elseif ( ($fecha." ".$hora >= $sql_e[37]  ) && ($sql_e[38] >= $fecha." ".$hora ) ) 
      $apertura=1;
    else
      $apertura=0;
  
    /*fechas cartelera juridico*/
    
      /*fechas cartelera tecnico*/


?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">COMUNICADOS GENERALES</td>
  </tr>
</table>


            <table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2" class="columna_titulo_resultados"><strong>Informaci&oacute;n General del Proceso  | Consecutivo del proceso
                  <?=$sql_e[22];?>
                </strong></td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><div align="right"><strong>Estado del proceso:</strong></div></td>
                <td class="texto_paginador_proveedor"><?=listas_sin_select($tp1,$sql_e[1],1);?></td>
              </tr>
              <tr>
                <td width="21%" class="columna_subtitulo_resultados"><div align="right"><strong> Tipo de proceso:</strong></div></td>
                <td width="79%" class="filas_resultados"><strong class="filas_resultados" >
                  <?=listas_sin_select($tp2,$sql_e[2],1);?>
                </strong></td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><div align="right"><strong>Tipo de solicitud:</strong></div></td>
                <td ><strong>
                  <?=listas_sin_select($tp3, $sql_e[3], 1);?>
                </strong></td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><div align="right"><strong>Persona de contacto:</strong></div></td>
                <td class="filas_resultados"><?=listas_sin_select($t1, $sql_e[15], 1);?></td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><div align="right"><strong>
                    <?=$lenguaje_0;?>
                  :</strong></div></td>
                <td ><strong>
                  <?=$sql_e[12];?>
                </strong></td>
              </tr>
            </table>
            <table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>
      <input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('detalle_invitacion_<?=$id_invitacion_pasa;?>.php','contenidos')">
    </label></td>
  </tr>
</table>
<br>

<br />
<fieldset style="width:98%">
      <legend>Historico de preguntas</legend>
            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="20%" class="titulo_tabla_azul_sin_bordes">Fecha del comunicado</td>
                <td width="4%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                <td width="76%" class="titulo_tabla_azul_sin_bordes">Comunicado</td>
              </tr>
              
              <?
          $sele_car="select * from $t15 where pro1_id = $id_invitacion and tipo_aclaracio  = 2  order by fecha_pregunta desc";
        $sql_ex_c=query_db($sele_car);
        while($ls_c=traer_fila_row($sql_ex_c)){
        $busca_pro = strpos(" incio ".$ls_c[2]."|",$_SESSION["id_proveedor"]."|");
              $complemento_foro="";
      
      if( ($busca_pro>=1) || ($ls_c[6]==1) ){//si es publica o del due�o
  
      if($num_fila_gene%2==0)
        $class_g="campos_blancos_listas";
      else
        $class_g="campos_gris_listas";
        
        if($ls_c[7]==2) { $solicitante = "HOCOL SA"; $complemento_foro = " and pv_id = ".$_SESSION["id_proveedor"]; }
        else $solicitante = "Proveedor";


  ?>
          <tr class="<?=$class_g;?>">
            <td><div align="center"><?=fecha_for_hora($ls_c[3]);?>
              </div></td>
                <td><div align="center"><? if($ls_c[11]!=""){?><div align="center"><img src="../imagenes/mime/<?=extencion_archivos($ls_c[11]);?>.gif" onClick="window.parent.location.href='../librerias/php/descarga_documentos_cartelera_gene.php?n1=<?=$ls_c[0];?>&n2=<?=$ls_c[11];?>'" ></div><? } ?></div></td>
                <td><?=nl2br($ls_c[4]);?></td>
              </tr>
         
              <tr>
                <td colspan="3" id="div_for_<?=$ls_c[0];?>" style="display:none">&nbsp;</td>
              </tr>
          <? 
          
         $num_fila_gene++; } //si es publica o del due�o
         } ?>           
            </table>
</fieldset>            

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_anexo">
<input type="hidden" name="ocu_re">

</body>
</html>
