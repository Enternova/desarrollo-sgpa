<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	//SELECCION DE PERMISO E ITEM
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	

	$sel_archivo_pedido = traer_fila_row(query_db("select * from t2_servicios_menores_sap where id_item = ".$id_item_pecc." and estado = 1"));

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top"><p>&nbsp;</p>
    <table cellspacing="2" cellpadding="2"  class="tabla_lista_resultados">
      <tr>
        <td colspan="14" align="center" class="fondo_3">LISTA DE SERVICIOS DE LA ORDEN DE PEDIDO</td>
        </tr>
      <tr>
        <td colspan="3" align="right">Numero de Compra:</td>
        <td colspan="3"><?=$sel_archivo_pedido[4]?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="right">Nombre del Archivo Importado de SAP:</td>
        <td colspan="3"><?=$sel_archivo_pedido[3]?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="right">Fecha en la que se Importo el Archivo:</td>
        <td colspan="3"><?=$sel_archivo_pedido[3][14].$sel_archivo_pedido[3][15].$sel_archivo_pedido[3][16].$sel_archivo_pedido[3][17]."-".$sel_archivo_pedido[3][18].$sel_archivo_pedido[3][19]."-".$sel_archivo_pedido[3][20].$sel_archivo_pedido[3][21]?>
          Hora
          <?=$sel_archivo_pedido[3][23].$sel_archivo_pedido[3][24].":".$sel_archivo_pedido[3][25].$sel_archivo_pedido[3][26].":".$sel_archivo_pedido[3][27].$sel_archivo_pedido[3][28]?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr class="fondo_3">
        <td width="108" align="center">FECHA DOC</td>
        <td width="84" align="center">CLA DOC</td>
        <td width="65" align="center">NIT PROVEEDOR</td>
        <td width="54" align="center">NOMBRE PROVEEDOR</td>
        <td width="68" align="center">DESCRIPCION PEDIDO</td>
        <td width="71" align="center">GTE CONTRTO</td>
        <td width="55" align="center">GRUPO COMPRA</td>
        <td width="85" align="center">ORG COMPRAS</td>
        <td width="126" align="center">MONPED</td>
        <td width="156" align="center">MONTO PEDIDO</td>
        <td width="68" align="center">VALOR USD</td>
        <td width="89" align="center">TRM</td>
        <td width="77" align="center">NOMBRE CREADOR</td>
        <td width="52" align="center">NOMBRE APROBADOR</td>
      </tr>
       <?

      $sel_pedido = query_db(" SELECT  id, id_proveedor, id_item, nombre_archivo, doc_compra, fecha_doc, cla_doc, nit_proveedor, nombre_proveedor, descripcion_pedido, gte_contrato,                          grupo_compra, org_compras, monped, monto_pedido, valor_usd, trm_pedido, mat_proveedor, usu_creador, nombre_us_creador, ind_liberacion,                          usu_aprobador, nombre_usu_aprobador, estado from t2_servicios_menores_sap where id_item = ".$id_item_pecc." and estado = 1");
	  $cont = 0;
	  while($sel_so = traer_fila_db($sel_pedido)){
		  
		  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		
	  ?>
      <tr class="<?=$clase?>">
        <td><?=$sel_so[5]?></td>
        <td><?=$sel_so[6]?></td>
        <td><?=$sel_so[7]?></td>
        <td><?=$sel_so[8]?></td>
        <td><?=$sel_so[9]?></td>
        <td><?=$sel_so[10]?></td>
        <td><?=$sel_so[11]?></td>
        <td><?=$sel_so[12]?></td>
        <td><?=$sel_so[13]?></td>
        <td><?=number_format($sel_so[14],0,"","")?></td>
        <td><?=$sel_so[15]?></td>
        <td><?=$sel_so[16]?></td>
        <td><?=$sel_so[17]?></td>
        <td><?=$sel_so[28]?></td>
      </tr>
      <?
	  }
	  ?>
    </table>
    <p>&nbsp;</p>
    <p><br />
    </p></td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="id_elimian_firma" id="id_elimian_firma" value="" />
<input type="hidden" name="tipo_adj_permiso" id="tipo_adj_permiso" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_secuencia" id="id_secuencia" value="" />
<input type="hidden" name="orden_edita_secua" id="orden_edita_secua" value="" />
<input type="hidden" name="id_rol_aprueba" id="id_rol_aprueba" value="" />
<input type="hidden" name="estado_item_peec" id="estado_item_peec" value="<?=$sel_item[14]?>" />
</body>
</html>
