<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");
	$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	
		/*echo $busca_adjudicacion = "select pro30_id, pro27_id from $vt15 where pro1_id = $id_invitacion  and pv_id = ".$_SESSION["id_proveedor"]." and notificado = 1 and tipo_adj_no_adj = 4";
		$busca_adjudicacion_sql = traer_fila_row(query_db($busca_adjudicacion)); 
		if($busca_adjudicacion_sql[0]>=1) $otros_estados=1;*/
		
		
$busca_alertas_docu = "select evaluador1_id from evaluador1_relacionpreguntas_admin where in_id = $id_invitacion and termino = 1";
$cuenta_criterio = query_db($busca_alertas_docu);
while($busca_criterios_alertas = traer_fila_row($cuenta_criterio))
	{
		$busca_alertas_docu_pro = "select count(*) from evaluador6_relaciondocumentos_proveedor where evaluador1_id = $busca_criterios_alertas[0] and pv_id = ".$_SESSION["id_proveedor"]."";		
		$cuenta_criterio_pro = traer_fila_row(query_db($busca_alertas_docu_pro));
		if($cuenta_criterio_pro[0]==0)
			$falta_alrta_economica = 1;
	
	}	
$busca_alertas_docu = "select evaluador1_id from evaluador1_relacionpreguntas_admin where in_id = $id_invitacion and termino = 2";
$cuenta_criterio = query_db($busca_alertas_docu);
while($busca_criterios_alertas = traer_fila_row($cuenta_criterio))
	{
		$busca_alertas_docu_pro = "select count(*) from evaluador6_relaciondocumentos_proveedor where evaluador1_id = $busca_criterios_alertas[0] and pv_id = ".$_SESSION["id_proveedor"]."";		
		$cuenta_criterio_pro = traer_fila_row(query_db($busca_alertas_docu_pro));
		if($cuenta_criterio_pro[0]==0)
			$falta_alrta_tecnica = 1;
	
	}	



?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos"><strong>ATENCION: SU OFERTA NO HA SIDO ENVIADA A HOCOL SA</strong></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="8" cellspacing="8" class="tabla_lista_resultados">
  <tr>
    <td width="29%"></td>
    <td width="71%"></td>
  </tr>
  <tr>
    <td colspan="2" class="columna_titulo_resultados"><strong>Informaci&oacute;n General del Proceso  | Consecutivo del proceso
        <?=$sql_e[22];?>
    </strong></td>
  </tr>
  <tr>
    <td height="62" align="right" class="filas_resultados"><p class="alerta_faltantes"><strong>ALERTA:</strong></p></td>
    <td><strong class="alerta_faltantes">SU OFERTA NO HA SIDO ENVIADA A HOCOL SA</strong></td>
  </tr>
  <tr>
    <td height="78" align="right" class="filas_resultados"><div class=" alerta_faltantes" align="right"><strong>CAUSA:</strong></div></td>
    <td>
    <? if($falta_alrta_tecnica==1){ ?>
    <strong class="alerta_faltantes">* FALTA COMPLETAR OFERTA TECNICA</strong>
    <? } ?></p>
   <? if($falta_alrta_economica==1){ ?>
    <strong class="alerta_faltantes">* FALTA COMPLETAR OFERTA ECONOMICA</strong>
    <? } ?></td>
  </tr>
  <tr>
    <td align="right" class="filas_resultados"><div class=" alerta_faltantes" align="right"><strong> COMENTARIOS:</strong></div></td>
    <td><p class="texto_paginador_proveedor">Su oferta ser&aacute; enviada autom&aacute;tica &uacute;nicamente cuando usted  termine de cargar por completo los requerimientos T&eacute;cnicos y Econ&oacute;micos por  aparte en los espacios creados.</p>
    <p class="texto_paginador_proveedor">Por favor ingrese a la invitaci&oacute;n --&gt; en la parte  inferior encontrara los botones &quot;Ingrese oferta t&eacute;cnica&quot;,  &quot;Ingrese oferta comerciales&quot; y anexe las ofertas en cada criterio solicitado</p><p class="chat_contacto">&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><p>&nbsp;
      </p>
      <p>
        <input name="button" type="button" class="buscar" id="button" value="Ingresar a la Invitaci&oacute;n" onClick="ajax_carga('detalle_invitacion_<?=arreglo_pasa_variables($id_invitacion);?>.php','contenidos')">
    </p></td>
  </tr>
</table>
<p>&nbsp;</p>
<br>
<br>
<br>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_anexo">
</body>
</html>