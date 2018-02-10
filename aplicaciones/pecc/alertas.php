<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	$id_item_pecc = 1;
	$quere_comple = " and t7_contrato_id = 1 and ano = 2013";

	
	if($id_pecc == 1){
	$comple_sql_histo =" and $vpeec2.id_pecc = $id_pecc ";
	}else{
		$comple_sql_histo =" and $vpeec2.id_pecc <> 1 ";
		}
	?>
    
    
    
    
    
    
    
    
    
    
    
    
    
     <?
     
	
	
	
	
	
	
	
	
	?>
    
    
    
    

    
    

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>

<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="div_contenidos_carga">
  <div class="titulos_secciones">SECCION: Alertas</div>
  <br />
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
  </table>
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
      <td colspan="10" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
        <tr>
          <td width="72%"><div align="left">Alertas encontradas: 3</div></td>
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
      <td width="2%" height="29" rowspan="2" class="columna_subtitulo_resultados">&nbsp;</td>
      <td width="5%" rowspan="2" class="columna_subtitulo_resultados"><div align="center">Numero</div></td>
      <td width="9%" rowspan="2" class="columna_subtitulo_resultados"><div align="center">Inicio Estimado</div></td>
      <td width="6%" rowspan="2" class="columna_subtitulo_resultados"><div align="center">Inicio Real</div></td>
      <td width="9%" rowspan="2" class="columna_subtitulo_resultados">Fecha del Requerimiento</td>
      <td width="8%" rowspan="2" class="columna_subtitulo_resultados"><div align="center">Tipo de Proceso</div></td>
      <td width="37%" rowspan="2" class="columna_subtitulo_resultados">Objeto</td>
      <td colspan="3" align="center" class="columna_subtitulo_resultados">Estado</td>
    </tr>
    <tr>
      <td colspan="2" class="columna_subtitulo_resultados">Tipo</td>
      <td width="5%" class="columna_subtitulo_resultados">Dias</td>
    </tr>
    <?
    	$sele_items_historico = query_db("select $vpeec2.id_item,$vpeec2.tipo_contratacion,$vpeec2.tipo_proceso,$pi4.nombre,$vpeec2.num1,$vpeec2.num2,$vpeec2.num3,$vpeec2.fecha_se_requiere,$vpeec2.objeto_solicitud, $vpeec2.t1_tipo_proceso_id from $vpeec2, $pi4 where $vpeec2.estado = $pi4.t2_nivel_servicio_actividad_id ".$comple_sql_histo);
		while($sel_proce = traer_fila_db($sele_items_historico)){
			$id_tipo_proceso_pecc = 1;
			if($sel_proce[9] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_proce[9] == 8){
					$id_tipo_proceso_pecc = 3;
				}
	?>
    <tr class="filas_resultados">
      <td ><a href="javascript:ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sel_proce[0]?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
      <td><?=numero_item_pecc($sel_proce[4],$sel_proce[5],$sel_proce[6])?></td>
      <td >&nbsp;</td>
      <td>&nbsp;</td>
      <td><?=$sel_proce[7]?></td>
      <td><?=$sel_proce[2]?></td>
      <td><?=$sel_proce[8]?></td>
      <td colspan="2"><?=$sel_proce[3]?></td>
      <td>&nbsp;</td>
    </tr>
    <?
		}
	?>
    <tr class="<?=$class;?>">
      <td colspan="6"></td>
      <td id="contrase_<?=$ls[0];?>"></td>
      <td width="6%" id="contrase_<?=$ls[0];?>"></td>
      <td width="13%" id="contrase_<?=$ls[0];?>"></td>
      <td id="contrase_<?=$ls[0];?>"></td>
    </tr>
    <tr>
      <td colspan="10" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
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
