<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");

$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
$termino_p = arreglo_recibe_variables($termino);
$tipo_ter = $tipo_termino;

 	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_pregunta=traer_fila_row(query_db("select * from $t27 where pro16_id = $id_pregunta"));
	$cambia_estado = query_db("update $t27 set leida  = 2 where pro16_id = $id_pregunta");
	//inicio inc004-18
	 $inserta_visualizacion = query_db("insert into in_ingreso_sistema (us_id, fecha_ingreso, ultima_conexion, ip, session, modulo, pro1_id, pv_id) 
	values ( ".$_SESSION["id_us_session"].", '$fecha $hora','', '".$_SERVER['REMOTE_ADDR']."', '','Detalle a la aclaraci&oacute;n final',$id_invitacion,".$_SESSION["id_proveedor"].")");
	//fin inc004-18
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
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
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="2" class="titulos_procesos">DETALLE DE LA PREGUNTA ACLARATORIA</td>
  </tr>
  <tr>
    <td width="19%" class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Asunto:</strong></div></td>
    <td width="81%"><?=$busca_pregunta[6];?></td>
  </tr>
  <tr class="campos">
    <td class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Pregunta:</strong></div></td>
    <td class="filas_resultados"><?=nl2br($busca_pregunta[7]);?></td>
  </tr>
  <tr>
    <td class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Anexo:</strong></div></td>
    <td><? if($busca_pregunta[9]!=""){?>
      <div align="left"><img src="../imagenes/mime/<?=extencion_archivos($busca_pregunta[9]);?>.gif" onClick="window.parent.location.href='../librerias/php/descarga_documentos_aclaraciones_finales_envio.php?n1=<?=$busca_pregunta[0];?>&n2=<?=$busca_pregunta[9];?>'" ></div>
    <? } ?></td>
  </tr>
  <tr>
    <td class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Fecha de envio:</strong></div></td>
    <td><?=fecha_for_hora($busca_pregunta[4]);?></td>
  </tr>
  <tr>
    <td class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Fecha limite de respuesta:</strong></div></td>
    <td><?=fecha_for_hora($busca_pregunta[5]);?></td>
  </tr>
</table>
<br>
<? if( $busca_pregunta[5]>= $fecha." ".$hora ) { ?>

<table width='95%' border='0' cellspacing='2' cellpadding='2'>
  <tr>
    <td><div align='left' class='titulos_procesos'>ANEXAR NUEVA RESPUESTA DE ACLARACION</div></td>
  </tr>
</table>
<table width='95%' border='0' cellpadding='3' cellspacing='3' class='tabla_borde_azul_fondo_blanco'>
  <tr>
    <td width='385'><strong>Busque el documento que anexara a la aclaracion si lo requeriere:</strong></td>
    <td width='514'><input type='file' name='sube_archivo' id='fileField'></td>
  </tr>
  <tr>
    <td><div align='right'><strong>Observaciones:</strong></div></td>
    <td><label>
      <div align='left'>
        <textarea name='observaciones' id='textarea' cols='60' rows='5'></textarea>
      </div>
    </label></td>
  </tr>
</table>

<? } ?>
<br>
<table width='95%' border='0' cellpadding='2' cellspacing='2' class='tabla_borde_azul_fondo_blanco'>
  <tr>
  	<? if( $busca_pregunta[5]>= $fecha." ".$hora ) { ?>
    <td width='50%'><div align='center'>
      <input name='Submit' type='button' class='buscar' value='Grabar respuesta' onClick='agrega_respuestas_aclaracion_final()'>
    </div></td>
    <? } ?>
	<td width='50%'><div align='center'>
      <input type='button' name='button' id='button' class='cancelar' value='Volver a lista de aclaraciones finales' onClick='ajax_carga("cartelera-aclaraciones-finales_<?=$id_invitacion_pasa;?>.php","contenidos")'>    

    </div></td>
  </tr>
</table>




<br>
<table width="95%" border="0" cellpadding="3" cellspacing="3" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="32" class="titulo_tabla_azul_sin_bordes"><div align="center"><strong>Tipo</strong></div></td>
    <td width="153" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Nombre del Documento</strong></div></td>
    <td width="140" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Fecha</strong></div></td>
    <td width="526" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Observaciones</strong></div></td>
    <td width="99" class="titulo_tabla_azul_sin_bordes"><div align="center"><strong>Acciones</strong></div></td>
  </tr>
  <?

 
			$busca_respo = query_db("select * from ".$t28." where  pro16_id = $id_pregunta");
			while($lc=traer_fila_row($busca_respo)){
			$ext=extencion_archivos($lc[5]);
			if($ext!="")
				{
					$doocumento_tipo ="<img src='../imagenes/mime/".$ext.".gif' title='Tipo Documento'>";
					$nombre_documento = $lc[5];
					$boton_descraga="<a href='javascript:void(0)'> <img src='../imagenes/botones/nuevo_1.png' title='descargar Documento' onclick='javascript:window.parent.location.href=\"../librerias/php/descarga_documentos_alcaraciones.php?id_invitacion=$id_invitacion&tipo_juri_tec=$tipo_juri_tec&n1=".$lc[0]."&n2=".$lc[5]."\"'></a>";
				}
			else{
					$doocumento_tipo ="";
					$nombre_documento ="";
					$boton_descraga="";
			}
			
		?>
  <tr class="administrador_tabla_generales">
    <td><?=$doocumento_tipo;?></td>
    <td><div align="left"><?=$nombre_documento;?></div></td>
    <td><div align="left"><?=fecha_for_hora($lc[3]);?></div></td>
    <td><div align="left"><?=$lc[4];?></div></td>
    <td><?=$boton_descraga;?><? if( $busca_pregunta[5]>= $fecha." ".$hora ) { ?>
      <a href="javascript:elimina_anexo_aclaracion_final(<?=$lc[0];?>)"> <img src="../imagenes/botones/eliminar_c.png" alt="Eliminar Registro"></a>
      <? }  ?>
    </td>
  </tr>
  <? } ?>
</table>
<p>&nbsp;</p>
<p>
  <input type="hidden" name="id_anexo">
  
  <input type="hidden" name="id_pregunta" value="<?=$id_pregunta;?>">
  <input type="hidden" name="id_invitacion"  value="<?=$id_invitacion_pasa;?>">

</p>
</body>
</html>
