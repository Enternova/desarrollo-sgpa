<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");
	$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	$id_notificacion = $id_notificacion;
	
	$id_invitacion = $id_invitacion;
	 $busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$pv_id = $_SESSION["id_proveedor"];

	$inserta_visita = "insert into $t47  (pro30_id, us_id, fecha_lectura, ip_lectura) values ($id_notificacion, ".$_SESSION["id_us_session"].",'$fecha $hora','".$_SERVER['REMOTE_ADDR']."')";
	$sql_ingre=query_db($inserta_visita);
?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>
<body >
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">RESUMEN DEL ENVIO</td>
    <td width="17%"><div align="left"><input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="window.parent.location.href='procesos.html'"></div></td>
  </tr>
</table>
</p>


<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
  <tr>
    <td></td>
  </tr>
  <? 
 
  $cambia_estado_carta = traer_fila_row(query_db("select * from $t45 where pro1_id = $id_invitacion and pv_id = $pv_id and acepta_terminos = 1")); ?>
  <tr>
    <td><?=$cambia_estado_carta[4];?></td>
  </tr>
</table>
</p>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
    <td width="45%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
    <td width="30%" class="titulo_tabla_azul_sin_bordes">Fecha cargue</td>
    <td width="9%" class="titulo_tabla_azul_sin_bordes">Descargar</td>
  </tr>
  <?
		  		$busca_relacion = traer_fila_row(query_db("select * from $t43 where pro1_id = $id_invitacion and pv_id = $pv_id and estado = 1"));

				
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
<p>&nbsp;</p>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_subtitulo_resultados">FORO DE PREGUNTAS Y ACLARACIONES: si usted ya reviso el documento anexo con el pedido y presenta inconsistencias o tiene preguntas o aclaraciones u otras dudas envielas a HOCOL por este foro</td>
  </tr>
  <tr>
    <td colspan="2" class="columna_titulo_resultados">Nuevo comentario:</td>
  </tr>
  <tr>
    <td width="77%"><textarea name="observacion_foro" id="observacion_foro" cols="45" rows="3"></textarea></td>
    <td width="23%"><input type="button" name="button4" class="guardar" id="button4" value="Enviar comentario" onclick="comentario_adjudicacion()"></td>
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
<table width="95%" border="0" align="center" cellpadding="4" cellspacing="4" class="tabla_blanca">
  <tr>
    <td width="50%"><div align="justify">Si ya reviso el documento anexo con el pedido y esta decauerdo, por favor presione el bot&oacute;n &quot;Aceptar terminos y condiciones del pedido&quot;</div></td>
    <td width="50%"><input type="button" name="button" id="button" value="Aceptar terminos y condiciones del pedido" class="guardar" onclick="confirma_terminos_condici()"></td>
  </tr>
</table>

<br>
<br>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="50%"><div align="justify">Si ya reviso el documento anexo con el pedido y esta definiotivamente no esta decauerdo, por favor digite la inconformidad y presione el bot&oacute;n &quot;No aceptar terminos y condiciones del pedido&quot;</div></td>
    <td width="50%"><textarea name="observacion_no_acepta" id="observacion_no_acepta" cols="50" rows="5"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="button" name="button3" id="button3" value="No aceptar terminos y condiciones del pedido" class="guardar" onclick="noconfirma_terminos_condici()"></td>
  </tr>
</table>
<input type="hidden" name="id_pro27" value="<?=$busca_relacion[0];?>">
<input type="hidden" name="id_notificacion" value="<?=$id_notificacion;?>">
<input type="hidden" name="id_invitacion_pasa" value="<?=$id_invitacion_pasa;?>">

</body>
</html>
