<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	

$complemento_busqueda = " and editado in (1,2) ";

$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr   ";
	$sql_con=traer_fila_row(query_db($busca_contrato));	
	
/*ERREGLO PAGINADOR*/
	
	$factor_b_c = 30;
	$factor_b = 30;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}
 	 $sql_cuenta2 = "select  count(*) from   v_tarifas_reporte_tiquetes where tarifas_contrato_id =  $id_contrato_arr and estado = 1   $complemento_busqueda ";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );

	
/*ERREGLO PAGINADOR*/	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="91%" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> HISTORICO DE TIQUETES DE SERVICIOS &gt;&gt; CONTRATO:
      <?=numero_cotnrato_tarifas($id_contrato_arr);?>
    </span></td>
    <td width="9%" ><input type="button" name="button" class="boton_volver"  id="button" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></td>
  </tr>
  <tr>
    <td colspan="2" ><? echo encabezado_contrato_tarifas($id_contrato_arr);?></td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="12" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="4%"><div align="center">P&aacute;gina</div></td>
        <td width="12%"><select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/h_prefactura_prove.php','contenidos')">
          <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
          <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
            <?=$i;?>
            </option>
          <? } ?>
        </select></td>
        <td width="86%"><span class="letra-descuentos">Total de Tiquetes:
          <?=$sql_cuenta[0];?>
        </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="4%" align="center" class="columna_subtitulo_resultados">Estado</td>
    <td width="8%" align="center" class="columna_subtitulo_resultados">Consecutivo tiquete</td>
    <td width="11%" align="center" class="columna_subtitulo_resultados">Gerente</td>
    <td width="9%" align="center" class="columna_subtitulo_resultados"><div align="center">Fecha de creaci&oacute;n</div></td>
    <td width="8%" align="center" class="columna_subtitulo_resultados">Inicio Servicio</td>
    <td width="6%" align="center" class="columna_subtitulo_resultados">Fin Servicio</td>
    <td width="9%" align="center" class="columna_subtitulo_resultados">Valor COP</td>
    <td width="9%" align="center" class="columna_subtitulo_resultados">Valor USD</td>
    <td width="7%" align="center" class="columna_subtitulo_resultados">Descuento</td>
    <td width="9%" align="center" class="columna_subtitulo_resultados"><div align="center">Valor Total COP</div></td>
    <td width="9%" align="center" class="columna_subtitulo_resultados"><div align="center">Valor Total USD</div></td>
    <td width="15%" align="center" class="columna_subtitulo_resultados"><div align="center">Proyecto</div></td>
  </tr>
  
<?
 $busca_item = "select * from (
select distinct t6_tarifas_proveedor_prefactura_id, tarifas_contrato_id, fecha_creacion, estado, consecutivo, municipio, proyecto, ediciones,editado,consecutivo_contrato, razon_social,gerente, nombre_administrador, ROW_NUMBER() OVER(ORDER BY consecutivo desc, fecha_creacion desc) AS rownum, fecha_ini, fecha_fin  from v_tarifas_reporte_tiquetes where tarifas_contrato_id =  $id_contrato_arr and estado = 1  $complemento_busqueda ) as sub
where rownum > $inicio and rownum <= $factor_b ORDER BY rownum asc";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
	
	if($ls_mr[8]==2) $estado="En firme - editado";
	elseif($ls_mr[3]==2) $estado="temporal";
	elseif($ls_mr[3]==1) $estado="En firme";
	elseif($ls_mr[3]==3) $estado="Eliminado";
	
	$lista_proyectos="";
	$valor_tarifa=0;
	$suma_ti=0;
	$suma_ti_sin_descuento=0;
	$total_admini=0;
	$total_impr=0;
	$total_utilidad	=0;
		
			
  $select_proyect = "select distinct proyecto from v_tarifas_reporte_detalle_proyecto where t6_tarifas_proveedor_prefactura_id = $ls_mr[0]";
$sql_q=query_db($select_proyect);
	while($l_pro=traer_fila_row($sql_q)){
			$lista_proyectos.=$l_pro[0].",<br> ";
			}


			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
			if($ls_mr[7]>=1)
				$version = " V".$ls_mr[7];
			else
								$version = "";

					$valor_tarifa=0;
					$suma_ti=0;
$suma_ti_sin_descuento=0;
	//	echo "select cantidad, valor, t1_moneda_id from v_tarifas_reporte_tiqute_detalle where t6_tarifas_proveedor_prefactura_id = $ls_mr[0]";
			$suma_ti_cop=0;
			$suma_ti_usd=0;
			$suma_ti_sin_descuento_cop = 0;
			$suma_ti_sin_descuento_usd = 0;
			$busca_valores = query_db("select cantidad, valor, t1_moneda_id from v_tarifas_reporte_tiqute_detalle where t6_tarifas_proveedor_prefactura_id = $ls_mr[0]");
			while($l_valores = traer_fila_row($busca_valores)){//valores prefactura
					if($l_valores[2]==1){//si es cop
						$valor_tarifa=($l_valores[0]*$l_valores[1]);
						$suma_ti_cop+=$valor_tarifa;
					}elseif($l_valores[2]==2){//si es usd
						$valor_tarifa=($l_valores[0]*$l_valores[1]);
						$suma_ti_usd+=$valor_tarifa;
					}
					$modeda_tiquete=$l_valores[2];
				
				}//valores prefactura

			$busca_descuento = traer_fila_row(query_db("select * from $t21ta where t6_tarifas_proveedor_prefactura_id = $ls_mr[0]"));

			$suma_ti_sin_descuento_cop = $suma_ti_cop;
			$suma_ti_sin_descuento_usd = $suma_ti_usd;
			if($suma_ti_cop>0){
				$suma_ti_cop = ($suma_ti_cop-$busca_descuento[2]);
			}
			if($suma_ti_usd>0){
				$suma_ti_usd = ($suma_ti_usd-$busca_descuento[2]);
			}
			

			
			 if($modeda_tiquete==1)
			 		$monde_tiquete_arr="COP";
			 if($modeda_tiquete==2)
			 		$monde_tiquete_arr="USD";					
			else					
			 		$monde_tiquete_arr="COP";								
			

$busca_aiu = traer_fila_row(query_db("select * from t6_tarifas_prefactura_aiu where t6_tarifas_proveedor_prefactura_id = $ls_mr[0]"));

$aiu_a=$busca_aiu[2];
$aiu_a_p=$busca_aiu[3];
$aiu_i=$busca_aiu[4];
$aiu_i_p=$busca_aiu[5];
$aiu_u=$busca_aiu[6];
$aiu_u_p=$busca_aiu[7];


		 if( ($aiu_a==1) || ($aiu_a==2) ) {
			 
			 if($aiu_a==1) $op_a= "+";
			 if($aiu_a==2) $op_a= "-";
			 
			 $porcentaje_a_cop = ($suma_ti_cop*$aiu_a_p)/100;
			 $porcentaje_a_usd = ($suma_ti_usd*$aiu_a_p)/100;
			 $total_admini_cop = $op_a.$porcentaje_a_cop;
			 $total_admini_usd = $op_a.$porcentaje_a_usd;
		 }
	
	
	
	 if( ($aiu_i==1) || ($aiu_i==2) ) {
			 
			 if($aiu_i==1) $op_i= "+";
			 if($aiu_i==2) $op_i= "-";
			 
			 $porcentaje_i_cop = ($suma_ti_cop*$aiu_i_p)/100; 
			 $total_impr_cop = $op_i.$porcentaje_i_cop;
			 $porcentaje_i_usd = ($suma_ti_usd*$aiu_i_p)/100; 
			 $total_impr_usd = $op_i.$porcentaje_i_usd;
	 }
	 
 if( ($aiu_u==1) || ($aiu_u==2) ) {
			 
			 if($aiu_u==1) $op_u= "+";
			 if($aiu_u==2) $op_u= "-";
			 
			$porcentaje_u_cop = ($suma_ti_cop*$aiu_u_p)/100; 
			 $total_utilidad_cop = $op_u.$porcentaje_u_cop;
			 
			 $porcentaje_u_usd = ($suma_ti_usd*$aiu_u_p)/100; 
			 $total_utilidad_usd = $op_u.$porcentaje_u_usd;
			 
 }

		
		$suma_ti_cop = ($suma_ti_cop+	$total_admini_cop+	$total_impr_cop+	$total_utilidad_cop);
		$suma_ti_usd = ($suma_ti_usd+	$total_admini_usd+	$total_impr_usd+	$total_utilidad_usd);	

		
		$suma_ti_sin_descuento_cop=($suma_ti_sin_descuento_cop+	$total_admini_cop+	$total_impr_cop+	$total_utilidad_cop);
		$suma_ti_sin_descuento_usd=($suma_ti_sin_descuento_usd+	$total_admini_usd+	$total_impr_usd+	$total_utilidad_usd);	
		
		$suma_total+=$suma_ti;

$fecha_cre= explode("-",$ls_mr[2]);
							
						?>
                     
 
   <tr class="<?=$class;?>">
    <td ><a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/tarifas/v_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$ls_mr[0];?>&ruta_regreso=1','carga_acciones_permitidas');"><?=$estado;?></a></td>
    <td >PRE-
      <?=$ls_mr[4];?>
-
<?=$fecha_cre[0]?>
<?=$version;?></td>
    <td ><?=$ls_mr[12];?></td>
    <td ><?=$ls_mr[2];?></td>
    <td align="center" ><?=$ls_mr[14];?></td>
    <td align="center" ><?=$ls_mr[15];?></td>
    <td align="right" ><?=number_format($suma_ti_sin_descuento_cop,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></td>
    <td align="right" ><?=number_format($suma_ti_sin_descuento_usd,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></td>
    <td align="right" ><?=number_format($busca_descuento[2],$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></td>
    <td style="<?=$stilo_excel;?>"  ><div align="center"><?=number_format($suma_ti_cop,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></div></td>
    <td style="<?=$stilo_excel;?>"  ><div align="center"><?=number_format($suma_ti_usd,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></div></td>
    <td><div align="center"><?=$lista_proyectos;?></div></td>
  </tr>


  </tr>
  
  <? $num_fila++;} ?>
  
  <tr>
    <td colspan="12" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Tiquetes encontrados: <?=$sql_cuenta[0];?></div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/h_prefactura_prove.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="8%"><label>
          <select name="pagij2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/h_prefactura_prove.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=10;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/h_prefactura_prove.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <td align="center"><input name="button3" type="button" class="boton_buscar" id="button3" value="Exportar a Excel resultado consolidado"  onclick="javascript:exporta_tiquete_contrato()" /> <input name="button2" type="button" class="boton_buscar" id="button2" value="Exportar a Excel resultado detallado"  onclick="javascript:exporta_tiquete_contrato_todo()" /></td>
  </tr>
</table>
<p><input type="hidden" name="pre_edita" />
  <input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
  <input type="hidden" name="id_contrato_arr_pa" value="<?=$id_contrato_arr;?>" />
  
  </p>
</p>
</body>
</html>
