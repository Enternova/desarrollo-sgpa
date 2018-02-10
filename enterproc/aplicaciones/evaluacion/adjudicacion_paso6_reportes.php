<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
   	$id_invitacion = $id_invitacion;
	$id_notificacion = $id_notificacion;
	

	 $busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	$busca_proveedor = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $pv_id"));


$buscar_notificaciones_a = "select * from $t46 where pro27_id = $pro27_id ";
$sql_ex_adjudicados=traer_fila_row(query_db($buscar_notificaciones_a));

$busca_hi_com = "select nombre_administrador, fecha_aceptacion, acepta_terminos, observacion_no_acepta from $vt17 where  pro27_id=$pro27_id order by fecha_aceptacion desc";
$busca_acepta_terminos=traer_fila_row(query_db($busca_hi_com));

				if($busca_acepta_terminos[2]==0) $estado_acep_r="Pendiente";
				elseif($busca_acepta_terminos[2]==1) $estado_acep_r="Si acepta";
				elseif($busca_acepta_terminos[2]==2) $estado_acep_r="No acepta";	
				else $estado_acep_r="";

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>
<body >
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">RESUMEN DE ADJUDICACION</td>
    <td width="17%"><div align="left"><input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/resumen_adjudicacion_urna_reporte.php?id_p=<?=$id_invitacion;?>','carga_detalle_adjudicacion');"></div></td>
  </tr>
  <tr>
    <td >Consecutivo: <strong><?=$sql_e[22];?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td >Proveedor:<strong> <?=$busca_proveedor[0];?></strong></td>
    <td>&nbsp;</td>
  </tr>
 <tr>
    <td >Fecha de notificaci&oacute;n: <strong><?=fecha_for_hora($sql_ex_adjudicados[6]);?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <? if($sql_e[3]==1){ ?>
  <tr>
    <td >Aceptaci&oacute;n de terminios: <span class="letra-descuentos">
      <?=$estado_acep_r;?></span></td>
    <td>&nbsp;</td>
  </tr>  <? } ?>
</table>
</p>


<table width="95%" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td class="titulos_secciones">Carta de terminos y condiciones</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
  <tr>
    <td></td>
  </tr>
  <? 
 
  $cambia_estado_carta = traer_fila_row(query_db("select * from $t45 where pro1_id = $id_invitacion and pv_id = $pv_id and acepta_terminos = 1")); 
$busca_relacion = traer_fila_row(query_db("select * from $t43 where pro1_id = $id_invitacion and pv_id = $pv_id and estado = 1"));

?>

  <tr>
    <td><?=$cambia_estado_carta[4];?></td>
  </tr>
</table>
</p>
<? if($sql_e[3]==1){ ?>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td class="titulos_secciones">Orden de pedido</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
    <td width="45%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
    <td width="30%" class="titulo_tabla_azul_sin_bordes">Fecha cargue</td>
    <td width="9%" class="titulo_tabla_azul_sin_bordes">Descargar</td>
  </tr>
  <?
		  		

				
				$busca_provee = query_db("select * from $t37 where
				pro1_id =  $id_invitacion and pv_id = $pv_id and pro27_id = $busca_relacion[0]");
				while($lp = traer_fila_row($busca_provee)){
			    $ext=extencion_archivos($lp[3]);
			  
					  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
    <td><img src="../imagenes/mime/<?=$ext;?>.gif"></td>
    <td><?=$lp[3];?></td>
    <td><?=fecha_for_hora($lp[4]);?></td>
    <td><div align="center"><img src="../imagenes/botones/editar_c.png" width="16" height="16" alt="descargar documento" title="descargar documento" onClick="window.parent.location.href='../librerias/php/descarga_documentos_adjudicacion_provedor.php?n1=<?=$lp[0];?>&n2=<?=$lp[3];?>'" /></div></td>
  </tr>
  <? $num_fila++;} ?>
</table>
<? } ?>
<p>&nbsp;</p>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_subtitulo_resultados">FORO DE PREGUNTAS Y ACLARACIONES: si usted ya reviso el documento anexo con el pedido y presenta inconsistencias o tiene preguntas o aclaraciones u otras dudas envielas al proveedor por este foro</td>
  </tr>
  <tr>
    <td colspan="2" class="columna_titulo_resultados">Nuevo comentario:</td>
  </tr>
  <tr>
    <td width="77%"><textarea name="observacion_foro" id="observacion_foro" cols="45" rows="3"></textarea></td>
    <td width="23%"><input type="button" name="button4" class="guardar" id="button4" value="Enviar comentario" onClick="comentario_adjudicacion()"></td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="columna_subtitulo_resultados">Historico de comentarios</td>
  </tr>
  <tr>
    <td width="22%" class="columna_titulo_resultados">Usuario</td>
    <td width="13%" class="columna_titulo_resultados">Fecha de envio</td>
    <td width="65%" class="columna_titulo_resultados">Comentario</td>
  </tr>
  
  <?
  	$busca_hi_com = "select nombre_administrador, fecha, pregunta from $vt16 where pro27_id = $busca_relacion[0] order by fecha desc";
	$sql_his=query_db($busca_hi_com);
	while($ls_foro=traer_fila_row($sql_his)){
  ?>
  <tr>
    <td><?=$ls_foro[0];?></td>
    <td><?=$ls_foro[1];?></td>
    <td><?=$ls_foro[2];?></td>
  </tr>
  <? } ?>
</table>
<p><br>
</p>
<? if($sql_e[3]==1){ ?>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_subtitulo_resultados">Estado de aceptaci&oacute;n del pedido por parte del proveedor</td>
  </tr>
  <tr>
    <td width="24%" class="columna_titulo_resultados">Usuario</td>
    <td width="15%" class="columna_titulo_resultados">Fecha de envio</td>
    <td width="8%" class="columna_titulo_resultados">Aceptaci&oacute;n</td>
    <td width="53%" class="columna_titulo_resultados">Comentario</td>
  </tr>
  <?
  	$busca_hi_com = "select nombre_administrador, fecha_aceptacion, acepta_terminos, observacion_no_acepta from $vt17 where pro27_id = $busca_relacion[0] order by fecha_aceptacion desc";
	$sql_his=query_db($busca_hi_com);
	while($ls_foro=traer_fila_row($sql_his)){
	
	

if($ls_foro[2]==0) $estado_acep="Pendiente";
				else
					{
						$busca_estado_ad = "select * from tp18_estados_adjudicacion where tp18_id = $ls_foro[2]";
						$sql_ex_estado = traer_fila_row(query_db($busca_estado_ad ));
						$estado_acep = $sql_ex_estado[1]; 
					}				
  ?>
  <tr>
    <td><?=$ls_foro[0];?></td>
    <td><?=fecha_for_hora($ls_foro[1]);?></td>
    <td><?=$estado_acep;?></td>
    <td><?=$ls_foro[3];?></td>
  </tr>
  <? } ?>
</table>
 <? } ?>
<br>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td class="titulos_resaltado_procesos">Otras notificaciones</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr class="columna_titulo_resultados">
        <td width="13%"><div align="center"><strong>Tipo</strong></div></td>
        <td width="17%"><div align="center"><strong>Fecha Envio</strong></div></td>
        <td width="7%"><div align="center"><strong>Documento</strong></div></td>
        <td width="6%"><div align="center"><strong>Acepta</strong></div></td>
        <td width="13%" ><div align="center"><strong>Visualizaci&oacute;n</strong></div></td>
        <td width="41%"><div align="center"><strong>comentarios</strong></div></td>
        <td width="3%"><div align="center"><strong>Ver</strong></div></td>
      </tr>
      <?
	   		  	$busca_provee = query_db("select pro30_id, pro27_id, if(tipo_adj_no_adj=1,'Adjudicado','No adjudicado') as adj, fecha_envio,documento, acepta_terminos, observacion_admin,tipo_adj_no_adj from $vt15 where
				pro1_id = $id_invitacion and pv_id = $pv_id and pro30_id <> $id_notificacion order by fecha_envio desc ");
				while($lp = traer_fila_row($busca_provee)){
				
				$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));
				
				if($lp[5]==0) $estado_acep="Pendiente";
				elseif($lp[5]==1) $estado_acep="Si acepta";
				elseif($lp[5]==2) $estado_acep="No acepta";		
				else $estado_acep="N/A";
				
				if($lp[7]==1)
					$rura_acc="adjudicacion_paso8_adj";
				elseif($lp[7]==2)
					$rura_acc="adjudicacion_paso8_no_adj";
	   
	   ?>
      <tr>
        <td><?=$lp[2];?></td>
        <td><?=fecha_for_hora($lp[3]);?></td>
        <td><?=$lp[4];?></td>
        <td><?=$estado_acep;?></td>
        <td><?=fecha_for_hora($visualizacion[0]);?></td>
        <td><?=$lp[6];?></td>
        <td><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../aplicaciones/evaluacion/<?=$rura_acc;?>.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$pv_id;?>&id_notificacion=<?=$id_notificacion;?>&rut=1&pro27_id=<?=$lp[1];?>&pro27_id_ori=<?=$pro27_id;?>','contenidos')"></td>
      </tr>
      <? } ?>
    </table></td>
  </tr>
</table>
<br>
<input type="hidden" name="id_pro27" value="<?=$busca_relacion[0];?>">
<input type="hidden" name="id_notificacion" value="<?=$id_notificacion;?>">
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="pv_id" value="<?=$pv_id;?>">

</body>
</html>
