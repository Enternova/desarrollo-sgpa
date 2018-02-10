<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	
	$sql_comple = "";
	
	if($_GET["numero1_pecc"]<>0){
		$sql_comple.= " and num1 = '".$_GET["numero1_pecc"]."'";
		}
	if($_GET["numero2_pecc"]<>0){
		$sql_comple.= " and num2 = '".$_GET["numero2_pecc"]."'";
		}
	if($_GET["numero3_pecc"]<>0){
		$sql_comple.= " and num3 = '".$_GET["numero3_pecc"]."'";
		}
	if($_GET["tp_comite"]==1){
		$sql_comple = " and (tipo_comite_extraordinario is null or tipo_comite_extraordinario = 2)";
		}
	if($_GET["tp_comite"]==2){
		$sql_comple = " and (tipo_comite_extraordinario =1)";
		}
	if($_GET["estado_proce_comite"]==1){//en preparacion
		$sql_comple = " and estado=2";
		}
	if($_GET["estado_proce_comite"]==2){//en aprobacion
		$sql_comple = " and estado=3";
		}
	if($_GET["estado_proce_comite"]==3){//en verificacion presidente
		$sql_comple = " and estado=1 and presidente = 0";
		}
	if($_GET["estado_proce_comite"]==4){//finaliado
		$sql_comple = " and estado=1 and presidente <> 0";
		}
	
	
		  
		  
		  
	
	if($_GET["paginas"] > 0){
		$pagina = $_GET["paginas"];
		}else{
			$pagina = 1;
			}
		$registros_pagina=30;		
		$regis_final = $pagina * $registros_pagina;		
		$regis_inicial = ($pagina - 1) * $registros_pagina;
		
		
		$cuantos_registros = traer_fila_row(query_db("select count(*) from $c1 where estado <> 33 $sql_comple"));
	  $cunatas_paginas = ($cuantos_registros[0] / $registros_pagina) +1;
	  
	  
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>

<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="div_contenidos_carga">
  <div class="titulos_secciones">SECCION: Hist&oacute;rico</div>
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
  </table>
  <table width="99%" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="28%" align="right">N&uacute;mero de comit&eacute;:</td>
      <td width="13%"><select name="numero1_pecc" id="numero1_pecc">
        <option value="CC">CC</option>
        </select></td>
      <td width="7%"><select name="numero2_pecc" id="numero2_pecc">
        <option value="0" <? if($_GET["numero2_pecc"] == 0) echo "selected='selected'";?>> Todos</option>
        
        
        <?=anos_consulta_ulti_numeros($_GET["numero2_pecc"])?>
        
      </select></td>
      <td width="14%"><input name="numero3_pecc" type="text" id="numero3_pecc" size="5" maxlength="4" value="<?=$_GET["numero3_pecc"]?>" /></td>
      <td width="38%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Estado:</td>
      <td colspan="3"><select name="estado_proce_comite" id="estado_proce_comite">
      <option value="0" <? if($_GET["estado_proce_comite"] == 0) echo "selected='selected'";?>>Todos</option>
        <option value="1" <? if($_GET["estado_proce_comite"] == 1) echo "selected='selected'";?>>En Preparaci&oacute;n</option>
        <option value="2" <? if($_GET["estado_proce_comite"] == 2) echo "selected='selected'";?>>En Aprobaci&oacute;n</option>
       <!-- <option value="3" <?// if($_GET["estado_proce_comite"] == 3) echo "selected='selected'";?>>En Verificaci&oacute;n del Presidente</option>-->
        <option value="4" <? if($_GET["estado_proce_comite"] == 4) echo "selected='selected'";?>>Finalizado</option>
      </select></td>
      <td width="38%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Tipo de Comit&eacute;:</td>
      <td colspan="3"><select name="tp_comite" id="tp_comite">
        <option value="0" <? if($_GET["tp_comite"] == 0) echo "selected='selected'";?>>Todos</option>
        <option value="1" <? if($_GET["tp_comite"] == 1) echo "selected='selected'";?>>Normal</option>
        <option value="2" <? if($_GET["tp_comite"] == 2) echo "selected='selected'";?>>Extraordinario</option>
        </select></td>
      <td width="38%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td width="28%" align="right">&nbsp;</td>
      <td colspan="5" align="center"><input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/comite/historico.php?numero1_pecc='+document.principal.numero1_pecc.value+'&numero2_pecc='+document.principal.numero2_pecc.value+'&numero3_pecc='+document.principal.numero3_pecc.value+'&tp_comite='+document.principal.tp_comite.value+'&estado_proce_comite='+document.principal.estado_proce_comite.value,'contenidos')" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
      <td colspan="7" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
        <tr>
          <td width="72%"><div align="left">
            <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
              <tr>
                <td width="84%" align="right">Paginas:</td>
                <td width="16%" align="right"><?
		  		  
          	
	  

	  
		  ?>
                  <select name="paginas" id="paginas" onchange="ajax_carga('../aplicaciones/comite/historico.php?paginas='+this.value,'contenidos')">
                    <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
                    <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
                      <?=$i?>
                      </option>
                    <? }?>
                  </select></td>
              </tr>
            </table>
          </div></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td width="2%" height="29" class="columna_subtitulo_resultados">&nbsp;</td>
      <td width="5%" class="columna_subtitulo_resultados"><div align="center">N&uacute;mero</div></td>
      <td width="9%" align="center" class="columna_subtitulo_resultados">Tipo del Comit&eacute;</td>
      <td width="9%" class="columna_subtitulo_resultados"><div align="center">Usuario que lo Cre&oacute;</div></td>
      <td width="6%" class="columna_subtitulo_resultados"><div align="center">Fecha Creaci&oacute;n</div></td>
      <td width="9%" class="columna_subtitulo_resultados">Fecha del Comit&eacute;</td>
      <td width="8%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    </tr>
    <?
	$cont = 0;
    	$sele_comites = query_db("select * from (select *,ROW_NUMBER()Over(order by id_comite desc) As RowNum from $c1 where estado <> 33 $sql_comple) as resultado_paginado WHERE RowNum BETWEEN $regis_inicial AND $regis_final");
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
      <td align="center" ><a href="javascript:ajax_carga('../aplicaciones/comite/edicion-comite.php?id_comite=<?=$sel_proce[0]?>','contenidos');ajax_carga('../aplicaciones/comite/menu_comite.php?id_comite=<?=$sel_proce[0]?>','id_div_sub');"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
      <td align="center"><?=numero_item_pecc($sel_proce[6],$sel_proce[7],$sel_proce[8])?></td>
      <td align="center" ><? if ($sel_proce[14] == 1) echo "Extraordinario"; else echo "Normal";?></td>
      <td align="center" ><? echo traer_nombre_muestra($sel_proce[1], $g1,"nombre_administrador","us_id")?></td>
      <td align="center"><?=$sel_proce[5]?></td>
      <td align="center"><?=$sel_proce[2]?></td>
      <td align="center"><?
	  
	  
      if($sel_proce[4]==2){
		  echo "En Preparaci&oacute;n";
		  }
	 if($sel_proce[4]==1){
		 	if($sel_proce[13]==0){
				echo "En Verificaci&oacute;n del Presidente";
				}else{
		  echo "Finalizado";
				}
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
      <td colspan="7"></td>
    </tr>
    <tr>
      <td colspan="7" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
        <tr>
          <td width="72%"><div align="left"></div></td>
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
