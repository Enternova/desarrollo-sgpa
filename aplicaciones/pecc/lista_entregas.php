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
    <td width="77%" valign="top"><table width="100%" cellpadding="2" cellspacing="2"  class="tabla_lista_resultados">
      <tr>
        <td colspan="12" align="center" class="fondo_3">LISTA DE ENTREGAS</td>
        </tr>
        
        <?
        $sel_entregas = query_db("select id, nombre_archivo from t2_archivo_sap_entregas where id_item = ".$id_item_pecc." order by nombre_archivo");
		while($se_entre=traer_fila_db($sel_entregas)){
			
			if($nombre_archivo<>$se_entre[1]){
$nombre_archivo = $se_entre[1]
			
		?>
      <tr>
        <td colspan="4" align="right">Nombre del Archivo Importado de SAP:</td>
        <td colspan="3"><?=$nombre_archivo?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr class="fondo_3">
        <td width="107"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">D.MATERIAL</td>
          </tr>
        </table></td>
        <td width="85"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">F.DOCUMEN.</td>
          </tr>
        </table></td>
        <td width="66"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">N.MATERIAL</td>
          </tr>
        </table></td>
        <td width="54"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">CENTRO</td>
          </tr>
        </table></td>
        <td width="68"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">ALMACEN</td>
          </tr>
        </table></td>
        <td width="66"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">POS.COMPRA</td>
          </tr>
        </table></td>
        <td width="39"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">CANTIDAD</td>
          </tr>
        </table></td>
        <td width="66"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">IND.ENTREG</td>
          </tr>
        </table></td>
        <td width="46"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">CLASE MOV.</td>
          </tr>
        </table></td>
        <td width="53"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">N.PEDIDO</td>
          </tr>
        </table></td>
        <td width="50"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">MONEDA</td>
          </tr>
        </table></td>
        <td width="67"><table cellspacing="0" cellpadding="0">
          <tr>
            <td width="80">FECHA REC/MAT</td>
            </tr>
        </table></td>
        </tr>
      
      <?

      $sel_solped= query_db("select * from t2_archivo_sap_entregas_detalle where id_archivo_entrega=".$se_entre[0]);
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
        <td><?=$sel_solp[4]?></td>
        <td><?=$sel_solp[5]?></td>
        <td><?=$sel_solp[6]?></td>
        <td><?=$sel_solp[7]?></td>
        <td><?=$sel_solp[8]?></td>
        <td><?=$sel_solp[9]?></td>
        <td><?=$sel_solp[10]?></td>
        <td><?=$sel_solp[11]?></td>
        <td><?=$sel_solp[12]?></td>
        <td><?=$sel_solp[13]?></td>
        </tr>
      <?
	  }
			}//fin if repetidos
		}//fin whille grande
	  ?>
  </table>
    <p>&nbsp;</p>
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
