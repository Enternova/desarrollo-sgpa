<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/html; charset=ISO-8859-1');
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
    <td width="91%" class="titulos_secciones">SECCION:<span class="titulos_resaltado_procesos">DETALLE DE DESCUENTOS &gt;&gt; CONTRATO:
      <?=$sql_con[7];?>
      </span></span><br />
      Proveedor:
      <?=$sql_con[6];?>
      <br />
      Objeto del contrato: <span class="tabla_paginador">
        <?=$sql_con[9];?>
      </span></td>
    <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver"  id="button5" value="Volver al menu" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></td>
  </tr>
</table>
</p>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr >
          <td colspan="4" class="fondo_4">Historico de descuentos globales de este contrato</td>
        </tr>
        <tr>
          <td width="14%" class="fondo_3"><div align="center">Fecha de creaci&oacute;n</div></td>
          <td width="66%" class="fondo_3"><div align="center">Detalle</div></td>
          <td width="9%" class="fondo_3">Creado por</td>
          <td width="7%" class="fondo_3">Documento</td>
        </tr>
        
<?
	$busca_descuneto = query_db("select * from $v_t_2 where tarifas_contrato_id = $id_contrato_arr  and estado = 1 order by fecha_creacion desc");
	while($traer_descvuentos = traer_fila_row($busca_descuneto)){

?>
        
        <tr class="filas_resultados">
          <td class="filas_resultados"><?=$traer_descvuentos[5];?></td>
          <td class="filas_resultados"><?=$traer_descvuentos[6];?></td>
          <td class="titulos_resumen_alertas"><?=$traer_descvuentos[3];?></td>
          <td class="titulos_resumen_alertas"><img src="../imagenes/mime/<?=extencion_archivos($traer_descvuentos[7]);?>.gif" width="20" height="20" onClick="window.parent.location.href='../enterproc/librerias/php/descarga_documentos_tarifas_descuentos.php?n1=<?=$traer_descvuentos[0];?>&n2=<?=$traer_descvuentos[7];?>'"/></td>
        </tr>
        <? } ?>
      </table>
<p>&nbsp;</p>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr >
    <td colspan="5" class="fondo_4">Historico de descuentos por tarifas de este contrato</td>
  </tr>
  <tr>
    <td width="12%" class="fondo_3"><div align="center">Categoria</div></td>
    <td width="22%" class="fondo_3"><div align="center">Grupo</div></td>
    <td width="25%" class="fondo_3">Detalle</td>
    <td width="8%" class="fondo_3">Valor</td>
    <td width="33%" class="fondo_3">Observaciones</td>
  </tr>
  <?
	$busca_descuneto = query_db("select categoria,grupo,detalle,valor,observaciones from v_tarifas_con_descuentos where tarifas_contrato_id = $id_contrato_arr ");
	while($traer_descvuentos = traer_fila_row($busca_descuneto)){

?>
  <tr class="filas_resultados">
    <td class="filas_resultados"><?=$traer_descvuentos[0];?></td>
    <td class="filas_resultados"><?=$traer_descvuentos[1];?></td>
    <td class="titulos_resumen_alertas"><?=$traer_descvuentos[2];?></td>
    <td class="titulos_resumen_alertas"><?=$traer_descvuentos[3];?></td>
    <td class="titulos_resumen_alertas"><?=$traer_descvuentos[4];?></td>
  </tr>
  <? } ?>
</table>
<p>&nbsp;</p>
</body>
</html>
