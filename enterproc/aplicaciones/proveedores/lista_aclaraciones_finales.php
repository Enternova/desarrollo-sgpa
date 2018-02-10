<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");


$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
$termino_p = arreglo_recibe_variables($termino);
$tipo_ter = $tipo_termino;


	//inco inc004-18
	 $inserta_visualizacion = query_db("insert into in_ingreso_sistema (us_id, fecha_ingreso, ultima_conexion, ip, session, modulo, pro1_id, pv_id) 
	values ( ".$_SESSION["id_us_session"].", '$fecha $hora','', '".$_SERVER['REMOTE_ADDR']."', '','Modulo de cartelera de aclaraciones finales',$id_invitacion,".$_SESSION["id_proveedor"].")");
	//fin inc004-18

 	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

$bus_alertas="select * from $t29 where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." and tp13_id  = 4";
$sql_alert=traer_fila_row(query_db($bus_alertas));
if($sql_alert[0]>=1){

$cambia_estado_alertas = query_db("update $t29 set estado = 2, quien_ingresa ='Proveedor' where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." and tp13_id  = 4 ");

$cambia = query_db("insert into  $t26 (pro1_id,pv_id,us_id, fecha_hora_gestion,detalle_gestion,proxima_llamada,tp14_id) 
		values ($id_invitacion,".$_SESSION["id_proveedor"].",".$_SESSION["id_us_session"].",'$fecha $hora', 'El proveedor visualiza la cartelera final','', 1)");


}



?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body >
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="left" class="titulos_procesos">ACLARACIONES FINALES DEL PROCESO</div></td>
  </tr>
</table>
<table width="95%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="30%" height="26"><strong>Consecutivo del proceso:</strong></td>
    <td width="26%"><div align="left">
      <?=$sql_e[22];?>
    </div></td>
    <td width="22%"><strong>Tipo de proceso:</strong></td>
    <td width="22%"><div align="left">
      <?=listas_sin_select($tp2,$sql_e[2],1);?>
    </div></td>
  </tr>
  <tr>
    <td height="26"><strong>Tipo de contrato:</strong></td>
    <td><div align="left">
      <?=listas_sin_select($tp5,$sql_e[5],1);?>
    </div></td>
    <td><strong>Objeto a contratar:</strong></td>
    <td><div align="left">
      <?=listas_sin_select($tp6,$sql_e[11],1);?>
    </div></td>
  </tr>
  <tr>
    <td height="26"><strong>Detalle y cantidad del objeto a contratar:</strong></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
      
    </div></td>
  </tr>
</table>
<br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="14%" class="columna_titulo_resultados">Alertas</td>
    <td width="35%" class="columna_titulo_resultados">Asunto</td>
    <td width="17%" class="columna_titulo_resultados">Envio</td>
    <td width="16%" class="columna_titulo_resultados">Fecha limite</td>
    <td width="18%" class="columna_titulo_resultados">&nbsp;</td>
  </tr>
  <?
		  	$sele_car="select pro16_id, objeto, fecha_solicitud, razon_social, fecha_limite_respuesta, if(leida=1,'No', 'Si'), anexo from $v7 where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by pv_id, fecha_solicitud desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				
		if($ls_c[6]!="")
			$alerta_ane = "Contiene un anexo, ingrese para descargarlo";	
		else	
			$alerta_ane = "";	
				
  ?>
  <tr class="<?=$class_g;?>">
    <td class="alerta_faltantes"><?=$alerta_ane;?></td>
    <td><?=nl2br($ls_c[1]);?></td>
    <td><div align="left">
      <?=fecha_for_hora($ls_c[2]);?>
    </div></td>
    <td><div align="left">
      <?=fecha_for_hora($ls_c[4]);?>
    </div></td>
    <td><input name="button" type="button" class="buscar" id="button" onClick="ajax_carga('../aplicaciones/proveedores/respuesta_aclaraciones_finales.php?id_pregunta=<?=$ls_c[0];?>&id_invitacion_pasa=<?=$id_invitacion_pasa;?>','contenidos')" value="Ingresar a la pregunta y responder"></td>
  </tr>

  <? 
				  
				 $num_fila_gene++; } ?>
</table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td><div align="center">
      <input name="button2" type="button" class='cancelar' id="button2" onClick="ajax_carga('detalle_invitacion_<?=$id_invitacion_pasa;?>.php','contenidos')" value="Volver a la informaci&oacute;n de la invitaci&oacute;n">
    </div>
        <div align="center"></div></td>
  </tr>
</table>
<br>
<br>
<br>
<p>&nbsp;</p>
<p>
  <input type="hidden" name="id_anexo">
  
  <input type="hidden" name="termino" value="<?=$termino;?>">
  <input type="hidden" name="id_invitacion"  value="<?=$id_invitacion_pasa;?>">
  <input type="hidden" name="tipo_termino"  value="<?=$tipo_termino;?>">
</p>
</body>
</html>
