<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");

$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
$termino_p = arreglo_recibe_variables($termino);
$tipo_ter = $tipo_termino;




	$busca_pregunta = traer_fila_row(query_db("select nombre, IF(razon_social is NULL, 'Usuario Hocol',razon_social), fecha_envio, asunto_envio, email_envio, pro34_id,texto_envio  from v_auditoria_email where pro34_id = $pro34_id  "));


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
    <td colspan="2" class="titulos_procesos">DETALLE DEL E-MAIL</td>
  </tr>
  <tr>
    <td width="19%" class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Asunto:</strong></div></td>
    <td width="81%"><?=$busca_pregunta[3];?></td>
  </tr>
  <tr class="campos">
    <td class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Email:</strong></div></td>
    <td class="filas_resultados"><?=$busca_pregunta[4];?></td>
  </tr>
  <tr>
    <td class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Proceso:</strong></div></td>
    <td><?=$busca_pregunta[0];?></td>
  </tr>
  <tr>
    <td class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Fecha de envio:</strong></div></td>
    <td><?=fecha_for_hora($busca_pregunta[2]);?></td>
  </tr>
  <tr>
    <td class="tabla_sin_borde_fondo_gris"><div align="right"><strong>Proveedor:</strong></div></td>
    <td><?=$busca_pregunta[1];?></td>
  </tr>
</table>
<table width="98%" border="0" class="tabla_lista_resultados">
  <tr>
    <td class="titulos_procesos">Cuerpo del e-mail</td>
  </tr>
  <tr>
    <td><?=$busca_pregunta[6];?></td>
  </tr>
</table>
<br>
<br>
<table width='95%' border='0' cellpadding='2' cellspacing='2' class='tabla_borde_azul_fondo_blanco'>
  <tr>
    <td width='50%'><div align="center">
      <input name="button5" type="button" class="cancelar" id="button5" value="Volver  al resumen" onClick="volver_listado('contenido_email','detalle_email')">
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
