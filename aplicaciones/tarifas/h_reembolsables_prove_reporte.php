<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
//$complemento_busqueda = " and editado = 1 ";  

if($b_proyect!=""){   
   
$select_proyect = "select distinct t6_tarifas_reembolables_datos_id from v_reembolsables_datos where proyecto like '%$b_proyect%' ";
//echo $select_proyect;
$sql_q=query_db($select_proyect);
	while($l_pro=traer_fila_row($sql_q)){
			$lista_proyectos_busca.=$l_pro[0].", ";
			}
			
			$complemento_busqueda.= " and t6_tarifas_reembolables_datos_id in ($lista_proyectos_busca 0) ";
			
}

if($gerentes>=1)
	$complemento_busqueda.= " and gerente =  $gerentes ";

	 
	
if($fecha_inicial!="")
	$complemento_busqueda.= " and fecha_creacion between '$fecha_inicial' and '$fecha_final' ";

if($b_contrato!="")
	$complemento_busqueda.= " and REPLACE(consecutivo_contreto, '-', '') like  '%".str_replace("-","",$b_contrato)."%' ";

if($b_provee!="") 
	$complemento_busqueda.= " and razon_social like  '%$b_provee%' ";

if($b_municipio!="") 
	$complemento_busqueda.= " and municipio like  '%$b_municipio%' ";

if($b_tiquete!="") 
	$complemento_busqueda.= " and consecutivo like  '%$b_tiquete%' ";

if($con_reembolsa == 1 or $con_reembolsa == 0 or $con_reembolsa == ""){
	$complemento_busqueda = " estado = 1 and t6_tarifas_reembolables_datos_id is not null ".$complemento_busqueda;
	}
if($con_reembolsa == 2){
	$complemento_busqueda = " t6_tarifas_reembolables_datos_id is null ".$complemento_busqueda;
	}
	
	
/*ERREGLO PAGINADOR*/
	
	$factor_b_c = 50;
	$factor_b = 50;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	 $sql_cuenta2 = "select  count(*) from   $v_t_11 where  $complemento_busqueda ";
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

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: Reporte de Tiquetes de Reembolsables en Firme, generados por los proveedores</td>
  </tr>
</table>
<br />
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="columna_titulo_resultados">Buscador de reembolsables</td>
  </tr>
  <tr>
    <td width="20%" align="right"><strong>Por contrato:</strong></td>
    <td width="29%"><input type="text" name="b_contrato" id="b_contrato" value="<?=$b_contrato;?>" /></td>
    <td width="15%" align="right"><strong>Por proveedor:</strong></td>
    <td width="25%"><input type="text" name="b_provee" id="b_provee" value="<?=$b_provee;?>" /></td>
    <td width="11%">&nbsp;</td>
  </tr>
  <tr>
    <td height="32" align="right"><strong>Por consecutivo de tiquete:</strong></td>
    <td><input type="text" name="b_tiquete" id="b_tiquete" value="<?=$b_tiquete;?>"/></td>
    <td align="right"><strong>Por gerente:</strong></td>
    <td><select name="gerentes" id="gerentes">
    <option value="0" >Gerente</option>
    
    <?
	

	$busca_item_gerente = "select distinct gerente, nombre_administrador from v_tarifas_reporte_tiquetes where  estado = 1  order by nombre_administrador ";	  
	$sql_ex_g = query_db($busca_item_gerente);
	while($ls_mr_ge=traer_fila_row($sql_ex_g)){
		if($ls_mr_ge[0]==$gerentes) $select = "selected";
		else $select = "";
		echo "<option value='".$ls_mr_ge[0]."' ".$select.">".$ls_mr_ge[1]."</option>";
		
	}
	
	?>
    
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>Fecha inicial de generaci&oacute;n:</strong></td>
    <td><input type="text" name="fecha_inicial" id="fecha_inicial" value="<?=$fecha_inicial;?>"  onMouseOver="calendario_sin_hora(this.name)" readonly="readonly" /> 
    <input type="hidden" name="b_proyect" id="b_proyect"  value="<?=$b_proyect;?>"/></td>
    <td align="right"><strong>Fecha final de generaci&oacute;n:</strong></td>
    <td><input name="fecha_final" type="text"  id="fecha_final" onMouseOver="calendario_sin_hora(this.name)" readonly="readonly"  value="<?=$fecha_final;?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>Contratos con Reembolsables:</strong></td>
    <td><select name="con_reembolsa" id="con_reembolsa">
    <option value="1" <? if($con_reembolsa == 1) echo 'selected="selected"' ?> >Con Reembolsables</option>
    <option value="2" <? if($con_reembolsa == 2) echo 'selected="selected"' ?>>Sin Reembolsables</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center"><input name="button" type="button" class="boton_buscar" id="button" value="Buscar reembolsables" onclick="javascript:busqueda_paginador_nuevo(1,'../aplicaciones/tarifas/h_reembolsables_prove_reporte.php','contenidos')" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="9" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="3%">P&aacute;gina</td>
        <td width="9%"><label>
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/h_reembolsables_prove_reporte.php','contenidos')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
            </select>
        </label></td>
        <td width="88%"><span class="letra-descuentos">Total de Tiquetes de Reembolsables:
            
            <?=$sql_cuenta[0];?>
        </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="9%" align="center" class="columna_subtitulo_resultados">Contrato</td>
    <td width="11%" align="center" class="columna_subtitulo_resultados">Estado</td>
    <td width="22%" align="center" class="columna_subtitulo_resultados">Proveedor</td>
    <td width="18%" align="center" class="columna_subtitulo_resultados">Gerente</td>
    <td width="8%" align="center" class="columna_subtitulo_resultados">Consecutivo reembolsables</td>
    <td width="11%" align="center" class="columna_subtitulo_resultados"><div align="center">Fecha de creaci&oacute;n</div></td>
    <td width="11%" align="center" class="columna_subtitulo_resultados"><div align="center">Valor COP</div></td>
    <td width="11%" align="center" class="columna_subtitulo_resultados"><div align="center">Valor USD</div></td>
    <td width="10%" align="center" class="columna_subtitulo_resultados">%_admin</td>
  </tr>
  
<?  $busca_item = "select * from (
select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado,  municipo, consecutivo, editado, numero_ediciones, consecutivo_contreto,razon_social,nombre_administrador, ROW_NUMBER() OVER(ORDER BY t6_tarifas_reembolables_datos_id desc) AS rownum from $v_t_11 where  $complemento_busqueda   ) as sub
where rownum > $inicio and rownum <= $factor_b order by consecutivo desc";
	

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
	
	if($ls_mr[6]==2) $estado="En firme - editado";
	elseif($ls_mr[3]==2) $estado="temporal";
	elseif($ls_mr[3]==1) $estado="En firme";	

	
		$busca_descuneto_im = traer_fila_row(query_db("select t6_tarifas_reembosables1_contrato_id, porcentaje_administracion, nombre_administrador, fecha_creacion, estado from $v_t_9 where t6_tarifas_contratos_id = $ls_mr[1]  order by fecha_creacion desc"));

	if($ls_mr[7]>=1)
				$version = " V".$ls_mr[7];
			else
				$version = "";

			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
			$suma_ti_cop=0;
			$suma_ti_usd=0;
			$busca_valores = query_db("select us_id, valor, moneda from $ta25 where t6_tarifas_reembolables_datos_id = $ls_mr[0]");
			while($l_valores = traer_fila_row($busca_valores)){//valores prefactura
				if($l_valores[2]==1){//si es cop
					$valor_tarifa=($l_valores[1]);
					$suma_ti_cop+=$valor_tarifa;
				}elseif($l_valores[2]==2){//si es usd
					$valor_tarifa=($l_valores[1]);
					$suma_ti_usd+=$valor_tarifa;
				}

				$modeda_tiquete=$l_valores[2];

			}//valores prefactura

	$busca_item = "select porcentaje_administracion
	from $v_t_11  where t6_tarifas_reembolables_datos_id =  $ls_mr[0] ";	  
	$sql_ex_admin_ree = traer_fila_row(query_db($busca_item));

			if($suma_ti_cop>0){
				$arreglo_administracion =  ($suma_ti_cop*$sql_ex_admin_ree[0]) / 100;
				$suma_ti_cop = ($suma_ti_cop+$arreglo_administracion);
			}
			if($suma_ti_usd>0){
				$arreglo_administracion =  ($suma_ti_usd*$sql_ex_admin_ree[0]) / 100;
				$suma_ti_usd = ($suma_ti_usd+$arreglo_administracion);
			}
			 if($modeda_tiquete==1)
			 		$monde_tiquete_arr="COP";
			 if($modeda_tiquete==2)
			 		$monde_tiquete_arr="USD";					
			else					
			 		$monde_tiquete_arr="COP";								
			

		
$fecha_cre= explode("-",$ls_mr[2]);	
		
		$suma_total+=$suma_ti;
						?>
                     
 
  
   <tr class="<?=$class;?>">
    <td >
    <?  if($con_reembolsa != 2) {?>
    <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/tarifas/v_reembolsable.php?id_contrato=<?=arreglo_pasa_variables($ls_mr[1]);?>&id_reembolsable_factura_or=<?=$ls_mr[0];?>&ruta_regreso=2&pagina='+document.principal.pagina.value+'&b_contrato='+document.principal.b_contrato.value+'&b_tiquete='+document.principal.b_tiquete.value+'&b_proyect='+document.principal.b_proyect.value+'&fecha_inicial='+document.principal.fecha_inicial.value+'&fecha_final='+document.principal.fecha_final.value+'&gerentes='+document.principal.gerentes.value+'&b_provee='+document.principal.b_provee.value,'contenidos');">
      <?=$ls_mr[8];?>
     </a>
     <? }else{?>
     <?=$ls_mr[8];?>
     <? }?>
     </td>
    <td ><?=$estado;?></td>
    <td ><?=$ls_mr[9];?></td>
    <td ><?=$ls_mr[10];?></td>
    <td >R-<?=$ls_mr[5];?>-<?=$fecha_cre[0];?> <?=$version;?></td>
    <td ><?=$ls_mr[2];?></td>
	<td><div align="center"><?=decimales_estandar($suma_ti_cop,2)?></div></td>
    <td ><div align="center"><?=decimales_estandar($suma_ti_usd,2)?></div></td>
    <td >
    
    <?
    	if($sql_ex_admin_ree[0]=="-1")
			$valor_admin = "No Aplica";
		else
			$valor_admin = $sql_ex_admin_ree[0]."%";
			
			echo $valor_admin;
	?>
    </td>
  </tr>
  
  <? $num_fila++;
  $suma_ti_cop=0;
  $suma_ti_usd=0;
  } ?>
  
  <tr>
    <td colspan="9" class="columna_titulo_resultados">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="49%" align="right"><input name="button3" type="button" class="boton_buscar" id="button3" value="Exportar resultado consolidado a excel"  onclick="javascript:exporta_reembolsables()" /></td>
    <td width="51%" align="left">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="pre_edita" />
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />


</p>
</body>
</html>
