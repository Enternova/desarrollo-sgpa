<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<div class="titulos_secciones">SECCION: INBOX</div>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="72%"><div align="left">Alertas encontradas: 5</div></td>
        <td width="9%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=10;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="9%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="3%" height="29" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="8%" class="columna_subtitulo_resultados"><div align="center">Contrato</div></td>
    <td width="9%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    <td width="43%" class="columna_subtitulo_resultados"><div align="center">Descripci&oacute;n</div></td>
    <td width="25%" class="columna_subtitulo_resultados"><div align="center">Proveedor / Contratista</div></td>
    <td width="12%" class="columna_subtitulo_resultados"><div align="center">Fecha Creaci&oacute;n</div></td>
  </tr>
  	<?
  	$lista_contrato = "select * from $co1 where estado >= 1";


	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
	
		$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$lista_contrato[5];
		$sel_pro_q=traer_fila_row(query_db($sel_pro));


	?>
  <tr class="filas_resultados">
   	<td >
    <a href="javascript:taer_menu('../aplicaciones/contratos/menu_contrato.php?id=<?=arreglo_pasa_variables($lista_contrato[0]);?>','contenido_menu')"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
  <td><?=consecutivo_bl($lista_contrato[0])?></td>
    	<td ><? estado_contrato(arreglo_pasa_variables($lista_contrato[0]),$co1);?></td>
   	<td><?=$lista_contrato[3];?></td>
   	<td><?=$sel_pro_q[3];?></td>
   	<td><?=$lista_contrato[19];?></td>
  </tr>
	<?
	}
	?>
  	<tr>
    	<td colspan="6" class="columna_titulo_resultados">
        <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
		<tr>
        <td width="72%"><div align="left">Alertas encontradas: 5</div></td>
        <td width="9%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=10;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="9%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
