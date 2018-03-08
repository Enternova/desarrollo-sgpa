<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>

<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="div_contenidos_carga">
  <div class="titulos_secciones">SECCION: Historico</div>
  <br />
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
  </table>
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
      <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
        <tr>
          <td width="72%"><div align="left">Procesos encontrados: 3</div></td>
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
      <td width="2%" height="29" class="columna_subtitulo_resultados">&nbsp;</td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">Numero</div></td>
      <td width="9%" class="columna_subtitulo_resultados"><div align="center">Usuario que lo Creo</div></td>
      <td width="6%" class="columna_subtitulo_resultados"><div align="center">Fecha Creaci&oacute;n</div></td>
      <td width="9%" class="columna_subtitulo_resultados">Fecha del Comit&eacute;</td>
      <td width="8%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    </tr>
    <?
    $cont = 0;
    	$sele_comites = query_db("select * from $c1");
		while($sel_proce = traer_fila_db($sele_comites)){
			
			if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
	?>
    <tr class="<?=$clase?>">
      <td ><a href="javascript:ajax_carga('../aplicaciones/comite/edicion-comite.php?id_comite=<?=$sel_proce[0]?>','contenidos')"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
      <td><?=numero_item_pecc($sel_proce[6],$sel_proce[7],$sel_proce[8])?></td>
      <td ><? echo traer_nombre_muestra($sel_proce[1], $g1,"nombre_administrador","us_id")?></td>
      <td><?=$sel_proce[5]?></td>
      <td><?=$sel_proce[2]?></td>
      <td><?
      if($sel_proce[4]==2){
		  echo "En Preparaci&oacute;n";
		  }
	 if($sel_proce[4]==1){
		  echo "Finalizado";
		  }
	if($sel_proce[4]==3){
		  echo "En Proceso de Aprobaci&oacute;n";
		  }
	  ?></td>
    </tr>
    <?
		}
	?>
    <tr class="<?=$class;?>">
      <td colspan="6"></td>
    </tr>
    <tr>
      <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
        <tr>
          <td width="72%"><div align="left">Alertas encontradas: 3</div></td>
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
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
</body>
</html>
