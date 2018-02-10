<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
   
	$id_invitacion = $id_invitacion;
	$id_notificacion = $id_notificacion;
	

	 $busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	$busca_proveedor = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $pv_id"));

if($rut==2)
	$ruta_vuelve="adjudicacion_paso7";
elseif($rut==1)
	$ruta_vuelve="adjudicacion_paso6";
else
	$ruta_vuelve="detalle_invitacion";	


echo $buscar_notificaciones_a = "select * from $t46 where pro27_id = $pro27_id ";
$sql_ex_adjudicados=traer_fila_row(query_db($buscar_notificaciones_a));

$busca_hi_acept= "select nombre_administrador, fecha_aceptacion, acepta_terminos, observacion_no_acepta from $vt17 where  pro27_id=$pro27_id order by fecha_aceptacion desc";
$busca_acepta_terminos=traer_fila_row(query_db($busca_hi_acept));

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
    <td width="17%"><div align="left"><input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/<?=$ruta_vuelve;?>.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$pv_id;?>&id_notificacion=<?=$id_notificacion;?>&pro27_id=<?=$pro27_id_ori;?>','contenidos')"></div></td>
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
    <td >Aceptaci&oacute;n de terminios: <span class="letra-descuentos"><strong>
      <?=$estado_acep_r;?></strong></span></td>
    <td>&nbsp;</td>
  </tr>
  <? } ?>
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
 
  $cambia_estado_carta = traer_fila_row(query_db("select * from $t45 where pro1_id = $id_invitacion and pv_id = $pv_id and pro27_id=$pro27_id")); ?>
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
		  		$busca_relacion = traer_fila_row(query_db("select * from $t43 where pro1_id = $id_invitacion and pv_id = $pv_id and pro27_id=$pro27_id"));

				
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
  	$busca_hi_com = "select nombre_administrador, fecha, pregunta from $vt16 where  pro27_id=$pro27_id order by fecha desc";
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
<? if($sql_e[3]==1){ ?>
</p>
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
  	
	$sql_his_ace=query_db($busca_hi_acept);
	while($ls_foro=traer_fila_row($sql_his_ace)){
	
			if($ls_foro[2]==0) $estado_acep="Pendiente";
				elseif($ls_foro[2]==1) $estado_acep="Si acepta";
				elseif($ls_foro[2]==2) $estado_acep="No acepta";	
				else $estado_acep="";
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
<br>
<input type="hidden" name="id_pro27" value="<?=$busca_relacion[0];?>">
<input type="hidden" name="id_notificacion" value="<?=$id_notificacion;?>">
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="pv_id" value="<?=$pv_id;?>">

</body>
</html>
