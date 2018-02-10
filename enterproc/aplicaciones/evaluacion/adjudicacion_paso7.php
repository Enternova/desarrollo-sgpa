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
    <td width="83%" class="titulos_secciones">Consecutivo: <strong>
      <?=$sql_e[22];?>
    </strong></td>
    <td width="17%"><div align="left"><input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos')"></div></td>
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
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2">
  
  <tr>
    <td class="titulos_resaltado_procesos">Otras notificaciones</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">

      <tr class="columna_titulo_resultados">
        <td width="13%"><div align="center"><strong>Tipo</strong></div></td>
        <td width="17%"> <div align="center"><strong>Fecha Envio</strong></div></td>
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
				
				if($lp[2]==0) $estado_acep="Pendiente";
				elseif($lp[2]==1) $estado_acep="Si acepta";
				elseif($lp[2]==2) $estado_acep="No acepta";		
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
        <td><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../aplicaciones/evaluacion/<?=$rura_acc;?>.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$pv_id;?>&id_notificacion=<?=$id_notificacion;?>&rut=2','contenidos')"></td>
        </tr>
        
        <? } ?>

    </table></td>
  </tr>
</table>
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
