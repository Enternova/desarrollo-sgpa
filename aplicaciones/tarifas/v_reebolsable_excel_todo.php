<?

  header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");

	header("Content-Disposition: attachment; filename=Reporte de reembolsables.xls"); 
	header("Content-Transfer-Encoding: binary");


include("../../librerias/lib/@config.php");
include("../../librerias/php/funciones_lista.php");
   include(SUE_PATH."global.php");

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_reembolsable_arr = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura_or));
	
	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

	$busca_reembolsables = "select * from t6_tarifas_reembosables1_contrato where t6_tarifas_contratos_id = ".$sql_con[0]. " and estado = 1";
	$busca_ree = traer_fila_row(query_db($busca_reembolsables));
	
	  echo $busca_item = "select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado, fecha_ini, fecha_fin, municipo, municipo ,porcentaje_administracion,consecutivo,tipo_contrato,orden_trabajo
	from $v_t_11  where tarifas_contrato_id =  $id_contrato_arr ";	  
	$sql_ex = traer_fila_row(query_db($busca_item));

		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
.titulo1 {
	font-size:20px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}


</style>
</head>

<body>
<table border=1  width="100%" >                	
  <tr>
    <td height="107" colspan="2" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="8" align="left"><div class="titulo1"><strong><br />
    REPORTE DE REEMBOLSABLES</strong></div><br />Contrato:
    <?=$sql_con[7];?>
    <br /><strong>Objeto del Contrato:</strong>
    <?=$sql_con[9];?>
    <br />
    <br />El contrato es tipo:</strong>
    <? if($sql_ex[10]==1){ echo 'Marco | orden de trabajo:'.$sql_ex[11]; } else echo 'Normal';  ?></td>
  </tr>

<tr >
  <td width="7%" align="center" class="titulo3"><strong>Numero de reebolsable</strong></td>
  <td width="16%" align="center" class="titulo3"><strong>Estado</strong></td>
  <td width="16%" align="center" class="titulo3">Rango de fecha inicial</td>
  <td width="16%" align="center" class="titulo3">Rango de fecha final</td>
  <td width="16%" align="center" class="titulo3">Proyecto</td>
  <td width="16%" align="center" class="titulo3"><strong><?=TITULO_5;?></strong></td>
	<td width="8%" align="center"class="titulo3" ><strong><?=TITULO_2;?></strong></td>
	<td width="27%" align="center" class="titulo3"><div align="center"><strong><?=TITULO_6;?></strong></div></td>
    <td width="5%" align="center" class="titulo3"><div align="center"><strong><strong>No de factura</strong></strong></div></td>
    <td width="5%" align="center"  class="titulo3"><strong>Valor COP</strong></td>
    <td width="5%" align="center"  class="titulo3"><strong>Valor USD</strong></td>
    <td width="5%" align="center"  class="titulo3"><strong>ADMINISTRACION</strong></td>

											</tr>

<?

  	$busca_lista_ree = "select * from v_tarifas_reembolsables_excel_todos where tarifas_contrato_id = $id_contrato_arr and estado_datos = 1 order by t6_tarifas_reembolables_datos_id ";
	$sql_ree = query_db($busca_lista_ree);
	while($l_ree=traer_fila_row($sql_ree)){//lista reembola

	$busca_lista_ree_proyecto = "select distinct t6_tarifas_municipios_proyectos_id, proyecto  from v_tarifas_reemblosables_detalle where t6_tarifas_reembolables_datos_id = $l_ree[1] and
	 t6_tarifas_reembolables_datos_detalle_id = $l_ree[0]";
	$sql_ree_poyecto = traer_fila_row(query_db($busca_lista_ree_proyecto));
	
	
		$total+= ($l_ree[5]*1);
	


		$valor_unido_cop=0;
		$valor_unido_usd=0;
		if($l_ree[6]==1){//si es cop
			$valor_arr = explode(".",$l_ree[5]);
			$unidades =$valor_arr[0];
			$decimales =  $valor_arr[1];
			$valor_unido_cop = $unidades.$formato_numeros_miles.$decimales;
		}elseif($l_ree[6]==2){//si es usd
			$valor_arr = explode(".",$l_ree[5]);
			$unidades =$valor_arr[0];
			$decimales =  $valor_arr[1];
			$valor_unido_usd = $unidades.$formato_numeros_miles.$decimales;
		}
		
		
		$valor_unido_2=0;
		$valor_arr_2 = explode(".",$imprime_detalle[7]);
		$unidades_2 =$valor_arr_2[0];
		$decimales_2 =  $valor_arr_2[1];
		$valor_unido_2 = $unidades_2.$formato_numeros_miles.$decimales_2;			
	
		$valor_unido_3=0;
		$valor_arr_3 = explode(".",$sub_total);
		$unidades_3 =$valor_arr_3[0];
		$decimales_3 =  $valor_arr_3[1];
		$valor_unido_3 = $unidades_3.$formato_numeros_miles.$decimales_3;	
	
			$fecha_cre= explode("-",$l_ree[14]);	
			
			if($l_ree[25]>=1)
				$version = " V".$l_ree[25];
			else
				$version = "";

	if($l_ree[24]==2) $estado="En firme - editado";
	elseif($l_ree[16]==2) $estado="temporal";
	elseif($l_ree[16]==1) $estado="En firme";
	if($valor_unido_cop>0){
		$porcentaje=($valor_unido_cop*$sql_ex[8]) / 100;
		$valor_unido_cop=$valor_unido_cop+$porcentaje;
	}
	if($valor_unido_usd>0){
		$porcentaje=($valor_unido_usd*$sql_ex[8]) / 100;
		$valor_unido_usd=$valor_unido_usd+$porcentaje;
	}
	?>
    
    <tr >
  <td width="7%" align="center"><strong>R-<?=$l_ree[23];?>-<?=$fecha_cre[0];?><?=$version;?></strong></td>
  <td width="16%" align="center"><?=$estado;?></td>
  <td width="16%" align="center"><?=$l_ree[19];?></td>
  <td width="16%" align="center"><?=$l_ree[20];?></td>
  <td width="16%" align="center"><?=$sql_ree_poyecto[1];?></td>
  <td width="16%" align="center">0</td>
	<td width="8%" align="center"><?=listas_sin_select($ta24,$l_ree[2],1);?></td>
	<td width="27%" align="center"><?=$l_ree[7];?></td>
    <td width="5%" align="center" ><div align="center"><?=$l_ree[8];?></div></td>
    <td width="5%" align="right" style="<?=$stilo_excel;?>" ><div align="right"><?=number_format($valor_unido_cop,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></div></td>
    <td width="5%" align="right" style="<?=$stilo_excel;?>" ><div align="right"><?=number_format($valor_unido_usd,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></div></td>
    <td width="5%" align="right" style="<?=$stilo_excel;?>" ><div align="right">%<?=$sql_ex[8];?></div></td>

											</tr>


    
    <?
		$valor_total_unido_usd=$valor_total_unido_usd+$valor_unido_usd;
		$valor_total_unido_cop=$valor_total_unido_cop+$valor_unido_cop;
	}

	

			
		$valor_unido_4=0;
		$valor_arr_4 = explode(".",$total);
		$unidades_4 =$valor_arr_4[0];
		$decimales_4 =  $valor_arr_4[1];
		$valor_unido_4 = $unidades_4.$formato_numeros_miles.$decimales_4;	
		

				

		$valor_unido_6=0;
		$valor_arr_6 = explode(".",$subtotal_menos_descuentos);
		$unidades_6 =$valor_arr_6[0];
		$decimales_6 =  $valor_arr_6[1];
		$valor_unido_6 = $unidades_6.$formato_numeros_miles.$decimales_6;			


	?>
          <? 
		$valor_admin = ($total*$sql_ex[8])/100;
		$valor_unido_5=0;
		$valor_arr_5 = explode(".",$valor_admin);
		$unidades_5 =$valor_arr_5[0];
		$decimales_5 =  $valor_arr_5[1];
		$valor_unido_5 =$unidades_5.$formato_numeros_miles.$decimales_5;			
	  	
	   ?>
    <tr >
      <td colspan="9" align="right">&nbsp;</td>
      <td align="center"   style="<?=$stilo_excel;?>">&nbsp;</td>
      <td></td><td></td>
    </tr>
    <!--tr >
      <td colspan="9" align="right">SUB TOTAL :</td>
      <td align="right"   style="<?=$stilo_excel;?>"><span class="columna_subtitulo_resultados_oscuro">
        <?=$valor_unido_4;?></span></td>
    </tr -->
          <? 
		$valor_admin = ($total*$sql_ex[8])/100;
		$valor_unido_5=0;
		$valor_arr_5 = explode(".",$valor_admin);
		$unidades_5 =$valor_arr_5[0];
		$decimales_5 =  $valor_arr_5[1];
		$valor_unido_5 =($unidades_5.$formato_numeros_miles.$decimales_5*1);			
	  	
	   ?>
    <!-- tr >
      <td colspan="9" align="right"> + ADMINISTRACION ( % <?=$sql_ex[8];?>):</td>
      <td align="right" style="<?=$stilo_excel;?>"><span class="columna_subtitulo_resultados_oscuro"><?=decimales_estandar($valor_unido_5,0);?></span></td>
  </tr -->
    <tr >
      <td colspan="9" align="right"><span class="celda_resultados_titulos">TOTAL DEL TIQUETE DE REEMBOLSABLES:</span></td>
      <td align="right"   style="<?=$stilo_excel;?>"><span class="columna_subtitulo_resultados_oscuro">
        <?=number_format($valor_total_unido_cop,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></span></td>
      <td align="right"   style="<?=$stilo_excel;?>"><span class="columna_subtitulo_resultados_oscuro">
        <?=number_format($valor_total_unido_usd,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></span></td>
        <td></td>
  </tr>
									
</table> 

									  
</body>
</html>