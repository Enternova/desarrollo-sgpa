<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91%" class="titulos_secciones">SECCION:<span class="titulos_resaltado_procesos"> CONTRATO:
      <?=$sql_con[7];?>
    </span></span>&gt;&gt; CREACION DE DOCUMENTOS ANEXOS</td>
    <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver" id="button5" value="Volver al menu" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','contenidos');ajax_carga('../aplicaciones/tarifas/h_tarifas.php?id_contrato=<?=$id_contrato_arr;?>','carga_acciones_permitidas_inicio')" /></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top">
            <?
   	$busca_premisos = traer_fila_row(query_db("select id_rol from v_relacion_roles_usuarios where us_id = ".$_SESSION["id_us_session"]." and ( id_rol = 1 or id_rol = 13) "));    
	
	 if($busca_premisos[0]>=1) {
	 
	 ?>
    <table width="99%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="3" class="fondo_4">Creaci&oacute;n de descuentos para este contrato</td>
      </tr>
      <tr>
        <td colspan="3" class="fondo_3"><div align="center">Detalle</div></td>
        </tr>
      <tr>
        <td colspan="3"><label>
            <div align="center">
              <textarea name="descuento_detalle" id="descuento_detalle" cols="25" rows="4"></textarea>
            </div>
          </label></td>
        </tr>
      <tr>
        <td width="21%"><div align="right"><strong>Documento soporte:</strong></div></td>
        <td width="21%"><label>
          <input type="file" name="anexo_descuento" id="anexo_descuento" />
        </label></td>
        <td width="58%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><div align="right">
            <input name="button2" type="button" class="boton_grabar" id="button2" value="Enviar nuevo anexo" onclick="crea_anexos_tarifas()" />
        </div></td>
      </tr>
    </table>
      <? } //si tiene descuentos ?>
      <br />
      <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr >
          <td colspan="5" class="fondo_4">Historico de anexos de este contrato</td>
        </tr>
        <tr>
          <td width="14%" class="fondo_3"><div align="center">Fecha de creaci&oacute;n</div></td>
          <td width="66%" class="fondo_3"><div align="center">Detalle</div></td>
          <td width="9%" class="fondo_3">Creado por</td>
          <td width="7%" class="fondo_3">Documento</td>
          <td width="4%" class="fondo_3">&nbsp;</td>
        </tr>
        
<?
	$busca_descuneto = query_db("select * from v_tarifas_anexos where tarifas_contrato_id = $id_contrato_arr  and estado = 1 order by fecha_creacion desc");
	while($traer_descvuentos = traer_fila_row($busca_descuneto)){

?>
        
        <tr class="filas_resultados">
          <td class="filas_resultados"><?=$traer_descvuentos[5];?></td>
          <td class="filas_resultados"><?=$traer_descvuentos[6];?></td>
          <td class="titulos_resumen_alertas"><?=$traer_descvuentos[3];?></td>
          <td class="titulos_resumen_alertas"><img src="../imagenes/mime/<?=extencion_archivos($traer_descvuentos[7]);?>.gif" width="20" height="20" onClick="window.parent.location.href='../enterproc/librerias/php/descarga_documentos_tarifas_anexos.php?n1=<?=$traer_descvuentos[0];?>&n2=<?=$traer_descvuentos[7];?>'"/></td>
          <td class="titulos_resumen_alertas">
                     <?
		     if($busca_premisos[0]>=1) {
	 	 		?>
          <img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar descuento" title="Eliminar descuento" width="16" height="16" />
          <? } ?>
          </td>
        </tr>
        <? } ?>
      </table></td>
  </tr>
</table>

</body>
</html>
