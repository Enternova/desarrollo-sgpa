<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
   
	$id_invitacion = $id_invitacion;
	$id_notificacion = $id_notificacion;
	

	 $busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	$busca_proveedor = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $pv_id"));




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
    <td width="83%" class="titulos_secciones"><span class="titulos_resaltado_procesos_tarifas">RESUMEN DE NO ADJUDICACION</span></td>
    <td width="17%"><div align="left">
      <input name="button2" type="button" class="boton_volver" id="button2" value="Volver  al resumen" onClick="ajax_carga('../enterproc/aplicaciones/evaluacion/resumen_adjudicacion_urna.php?id_p=<?=$id_invitacion;?>&id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')">
    </div></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</p>


<table width="95%" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td class="titulos_resaltado_procesos">Carta de no adjudicaci&oacute;n</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
  <tr>
    <td></td>
  </tr>
  <? 
 
  $cambia_estado_carta = traer_fila_row(query_db("select fecha_envio from $t46 where pro30_id =  $id_notificacion ")); ?>
  <tr>
    <td><p>Bogot&aacute;,
      <?=fecha_for_sin_hora($cambia_estado_carta[0]);?>
    </p>
        <p>&nbsp;</p>
      <p>Se&ntilde;ores<br>
            <strong>
              <?=$busca_proveedor[0];?>
          </strong></p>
      <p>&nbsp;</p>
      <p><strong>REFERENCIA:   INVITACI&Oacute;N A COTIZAR
        <?=$sql_e[22];?>
        </strong></p>
      <p>&nbsp;</p>
      <p>Cordial   Saludo,</p>
      <p>&nbsp;</p>
      <p align="justify">HOCOL S.A.   agradece su participaci&oacute;n en la invitaci&oacute;n de la referencia.  Le informamos que   de acuerdo con los an&aacute;lisis de las propuestas recibidas se decidi&oacute; adjudicarle   el pedido a otra compa&ntilde;&iacute;a. </p>
      <p align="justify">&nbsp;</p>
      <p align="justify">Esperamos   seguir contando con su inter&eacute;s para futuros procesos. </p></td>
  </tr>
</table>
</p>
<p>&nbsp;</p>
<br>
<p><br>
</p>
<br>
<br>
<input type="hidden" name="id_pro27" value="<?=$busca_relacion[0];?>">
<input type="hidden" name="id_notificacion" value="<?=$id_notificacion;?>">
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="pv_id" value="<?=$pv_id;?>">

</body>
</html>
