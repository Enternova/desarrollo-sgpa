<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	//SELECCION DE PERMISO E ITEM
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	$sel_archivo_solped = traer_fila_row(query_db("select * from t2_archivos_sap where id_item = ".$id_item_pecc." and tipo = 'Solped'"));
	$sel_archivo_pedido = traer_fila_row(query_db("select * from t2_archivos_sap where id_item = ".$id_item_pecc." and tipo = 'pedido'"));

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
    <td width="77%" valign="top"><table cellspacing="2" cellpadding="2"  class="tabla_lista_resultados">
      <tr>
        <td colspan="19" align="center" class="fondo_3">LISTA DE MATERIALES DE LA SOLPED</td>
      </tr>
      <tr>
        <td colspan="19" align="right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="right">Numero de Solped:</td>
        <td colspan="3"><?=$sel_archivo_solped[2]?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td colspan="4" align="right">Nombre del Archivo Importado de SAP:</td>
        <td colspan="3"><?=$sel_archivo_solped[5]?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td colspan="4" align="right">Fecha en la que se Importo el Archivo:</td>
        <td colspan="3"><?=$sel_archivo_solped[6][0].$sel_archivo_solped[6][1].$sel_archivo_solped[6][2].$sel_archivo_solped[6][3]."-".$sel_archivo_solped[6][4].$sel_archivo_solped[6][5]."-".$sel_archivo_solped[6][6].$sel_archivo_solped[6][7]?>
          Hora
          <?=$sel_archivo_solped[7][0].$sel_archivo_solped[7][1].":".$sel_archivo_solped[7][2].$sel_archivo_solped[7][3].":".$sel_archivo_solped[7][4].$sel_archivo_solped[7][5]?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td width="107">NOMBRE COMPLETO</td>
        <td width="85">IND.LIBERACION</td>
        <td width="66">IND.CAMBIO</td>
        <td width="54">POSICION</td>
        <td width="68">CLASE DOC</td>
        <td width="66">G.COMPRAS</td>
        <td width="39">TEXTO</td>
        <td width="66">N.MATERIAL</td>
        <td width="46">CENTRO</td>
        <td width="53">ALMACEN</td>
        <td width="50">GERENTE</td>
        <td width="67">G.ARTICULO</td>
        <td width="54">CANTIDAD</td>
        <td width="38">U.MED</td>
        <td width="41">FECHA S.</td>
        <td width="54">ORGANIZ.</td>
        <td width="49">V.TOTAL</td>
        <td width="68">DEN.GRUPO COMPRAS</td>
        <td width="57">MONEDA</td>
      </tr>
      
      <?

      $sel_solped= query_db("select s_pedido, usuario, nombre_completo, ind_liberacion, fecha, hora, transaccion, ind_cambio, s_pedido_2, posicion, clase_doc, g_compras, texto, n_material, centro, almacen, gerente, g_articulo,  cantidad, u_medida, fecha_s, organiz, v_total, mat_proveedor, den_grupo, moneda, id_archivo_sap from t2_archivos_sap_solped where id_archivo_sap=".$sel_archivo_solped[0]);
	  $cont = 0;
	  while($sel_solp = traer_fila_db($sel_solped)){
		  
		  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		
	  ?>
      <tr class="<?=$clase?>">
        <td><?=$sel_solp[2]?></td>
        <td><?=$sel_solp[3]?></td>
        <td><?=$sel_solp[7]?></td>
        <td><?=$sel_solp[9]?></td>
        <td><?=$sel_solp[10]?></td>
        <td><?=$sel_solp[11]?></td>
        <td><?=$sel_solp[12]?></td>
        <td><?=$sel_solp[13]?></td>
        <td><?=$sel_solp[14]?></td>
        <td><?=$sel_solp[15]?></td>
        <td><?=$sel_solp[16]?></td>
        <td><?=$sel_solp[17]?></td>
        <td><?=$sel_solp[18]?></td>
        <td><?=$sel_solp[19]?></td>
        <td><?=$sel_solp[20]?></td>
        <td><?=$sel_solp[21]?></td>
        <td><?=$sel_solp[22]?></td>
        <td><?=$sel_solp[24]?></td>
        <td><?=$sel_solp[25]?></td>
      </tr>
      <?
	  }
	  ?>
  </table>
    <p>&nbsp;</p>
    <table cellspacing="2" cellpadding="2"  class="tabla_lista_resultados">
      <tr>
        <td colspan="14" align="center" class="fondo_3">LISTA DE MATERIALES DEL PEDIDO</td>
        </tr>
      <tr>
        <td colspan="3" align="right">Numero de Compra:</td>
        <td colspan="3"><?=$sel_archivo_pedido[2]?></td>
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
        <td colspan="3"><?=$sel_archivo_pedido[5]?></td>
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
        <td colspan="3"><?=$sel_archivo_pedido[6][0].$sel_archivo_pedido[6][1].$sel_archivo_pedido[6][2].$sel_archivo_pedido[6][3]."-".$sel_archivo_pedido[6][4].$sel_archivo_pedido[6][5]."-".$sel_archivo_pedido[6][6].$sel_archivo_pedido[6][7]?>
          Hora
          <?=$sel_archivo_pedido[7][0].$sel_archivo_pedido[7][1].":".$sel_archivo_pedido[7][2].$sel_archivo_pedido[7][3].":".$sel_archivo_pedido[7][4].$sel_archivo_pedido[7][5]?></td>
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
        <td width="108" align="center">NOMBRE COMPLETO</td>
        <td width="84" align="center">IND LIBERACION</td>
        <td width="65" align="center">IND CAMBIO</td>
        <td width="54" align="center">F. ENTREGA</td>
        <td width="68" align="center">F.COMPRA</td>
        <td width="71" align="center">POSICION</td>
        <td width="55" align="center">CANTIDAD</td>
        <td width="85" align="center">U.MEDIDA</td>
        <td width="126" align="center">N.MATERIAL</td>
        <td width="156" align="center">TEXTO</td>
        <td width="68" align="center">V.BRUTO</td>
        <td width="89" align="center">NOMBRE DE PROVEEDOR</td>
        <td width="77" align="center">NIT</td>
        <td width="52" align="center">MONEDA</td>
      </tr>
       <?

      $sel_pedido = query_db("select doc_compra, usuario, nombre_completo, ind_liberacion, fecha,hora, trans, ind_cambio, f_entrega,doc_compra2, f_compra, proveedor, posicion, cantidad,u_medida, n_material, texto, v_bruto,nombre_proveedor, nit, mat_proveedor, moneda from t2_archivos_sap_pedido where id_archivo_sap=".$sel_archivo_pedido[0]);
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
        <td><?=$sel_so[2]?></td>
        <td><?=$sel_so[3]?></td>
        <td><?=$sel_so[7]?></td>
        <td><?=$sel_so[8]?></td>
        <td><?=$sel_so[10]?></td>
        <td><?=$sel_so[12]?></td>
        <td><?=$sel_so[13]?></td>
        <td><?=$sel_so[14]?></td>
        <td><?=$sel_so[15]?></td>
        <td><?=$sel_so[16]?></td>
        <td><?=$sel_so[17]?></td>
        <td><?=$sel_so[18]?></td>
        <td><?=$sel_so[19]?></td>
        <td><?=$sel_so[21]?></td>
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
