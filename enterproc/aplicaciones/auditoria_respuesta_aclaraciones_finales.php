<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");

$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
$termino_p = arreglo_recibe_variables($termino);
$tipo_ter = $tipo_termino;

 	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_pregunta=traer_fila_row(query_db("select * from $t27 where pro16_id = $id_pregunta"));

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
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
<table width="95%" border="0" cellpadding="3" cellspacing="3" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="31" class="titulo_tabla_azul_sin_bordes"><div align="center"><strong>Tipo</strong></div></td>
    <td width="145" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Nombre del Documento</strong></div></td>
    <td width="130" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Fecha</strong></div></td>
    <td width="526" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Observaciones</strong></div></td>
    <td width="57" class="titulo_tabla_azul_sin_bordes"><div align="center"><strong>Descargar</strong></div></td>
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
    <td><div align="center">
        <?=$boton_descraga;?></div></td>
  </tr>
  <? } ?>
</table>
<br>
<table width='95%' border='0' cellpadding='2' cellspacing='2' class='tabla_borde_azul_fondo_blanco'>
  <tr>
    <td width='50%'><div align="center">
      <input name="button5" type="button" class="cancelar" id="button5" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/auditoria_aclaraciones_finales.php?pasa=<?=$id_invitacion_pasa;?>','contenidos')">
    </div>
    <div align='center'></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>
  <input type="hidden" name="id_anexo">
  
  <input type="hidden" name="id_pregunta" value="<?=$id_pregunta;?>">
  <input type="hidden" name="id_invitacion"  value="<?=$id_invitacion_pasa;?>">

</p>
</body>
</html>
