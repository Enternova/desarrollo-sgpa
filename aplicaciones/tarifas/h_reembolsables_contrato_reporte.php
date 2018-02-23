<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	



$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr   ";
	$sql_con=traer_fila_row(query_db($busca_contrato));	
	   
if($b_proyect!=""){   
   
$select_proyect = "select distinct t6_tarifas_proveedor_prefactura_id from v_tarifas_reporte_detalle_proyecto where proyecto like '%$b_proyect%' ";
$sql_q=query_db($select_proyect);
	while($l_pro=traer_fila_row($sql_q)){
			$lista_proyectos_busca.=$l_pro[0].", ";
			}
			
			$complemento_busqueda.= " and t6_tarifas_proveedor_prefactura_id in ($lista_proyectos_busca 0) ";
			
}

if($gerentes>=1)
	$complemento_busqueda.= " and gerente =  $gerentes ";

	 
	
if($fecha_inicial!="")
	$complemento_busqueda.= " and fecha_creacion between '$fecha_inicial' and '$fecha_final' ";

if($b_contrato!="")
	$complemento_busqueda.= " and consecutivo_contrato like  '%$b_contrato%' ";

if($b_provee!="") 
	$complemento_busqueda.= " and razon_social like  '%$b_provee%' ";

if($b_municipio!="") 
	$complemento_busqueda.= " and municipio like  '%$b_municipio%' ";

if($b_tiquete!="") 
	$complemento_busqueda.= " and consecutivo like  '%$b_tiquete%' ";
	
	
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

 	 $sql_cuenta2 = "select  count(*) from   $v_t_11 where tarifas_contrato_id =  $id_contrato_arr and estado = 1";
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
    <td width="91%" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> HISTORICO DE REEMBOLSABLES &gt;&gt; CONTRATO:
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
    <td colspan="5" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="4%"><div align="center">P&aacute;gina</div></td>
        <td width="12%"><select name="pagina" onchange="javascript:busqueda_paginador_nuevo_tarifas(this.value,'../aplicaciones/tarifas/h_reembolsables_contrato_reporte.php','carga_acciones_permitidas',14)">
          <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
          <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
            <?=$i;?>
            </option>
          <? } ?>
        </select></td>
        <td width="86%"><span class="letra-descuentos">Total de Reembolsables:
            <?=$sql_cuenta[0];?>
        </span></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="12%" align="center" class="columna_subtitulo_resultados">Estado</td>
    <td width="19%" align="center" class="columna_subtitulo_resultados">Gerente</td>
    <td width="22%" align="center" class="columna_subtitulo_resultados">Consecutivo reembolsables</td>
    <td width="18%" align="center" class="columna_subtitulo_resultados"><div align="center">Fecha de creaci&oacute;n</div></td>
    <td width="19%" align="center" class="columna_subtitulo_resultados"><div align="center">Valor COP</div></td>
    <td width="19%" align="center" class="columna_subtitulo_resultados"><div align="center">Valor USD</div></td>
    <td width="10%" align="center" class="columna_subtitulo_resultados">%_admin</td>
  </tr>
  
<?
 $busca_item = "select * from (
select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado,  municipo, consecutivo, editado, numero_ediciones, consecutivo_contreto,razon_social,nombre_administrador, ROW_NUMBER() OVER(ORDER BY t6_tarifas_reembolables_datos_id desc) AS rownum from $v_t_11 where tarifas_contrato_id =  $id_contrato_arr  and estado = 1  ) as sub
where rownum > $inicio and rownum <= $factor_b";	  

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
			

		

		
		$suma_total+=$suma_ti;

$fecha_cre= explode("-",$ls_mr[2]);		
						?>
                     
 
  
   <tr class="<?=$class;?>">
    <td ><a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/tarifas/v_reembolsable.php?id_contrato=<?=arreglo_pasa_variables($ls_mr[1]);?>&id_reembolsable_factura_or=<?=$ls_mr[0];?>&ruta_regreso=1','carga_acciones_permitidas');">
      <?=$estado;?>
     </a></td>
    <td ><?=$ls_mr[10];?></td>
    <td >R-<?=$ls_mr[5];?>-<?=$fecha_cre[0];?> <?=$version;?></td>
    <td ><?=$ls_mr[2];?></td>
    <td ><div align="center"><?=decimales_estandar($suma_ti_cop,2);?></div></td>
    <td ><div align="center"><?=decimales_estandar($suma_ti_usd,2);?></div></td>
    <td ><?
    	if($sql_ex_admin_ree[0]=="-1")
			$valor_admin = "No Aplica";
		else
			$valor_admin = $sql_ex_admin_ree[0]."%";
			
			echo $valor_admin;
	?></td>
  </tr>
  
  <? $num_fila++;
  $suma_ti_cop=0;
  $suma_ti_usd=0;
  } ?>
  
  <tr>
    <td colspan="7" class="columna_titulo_resultados">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="49%" align="right"><input name="button2" type="button" class="boton_buscar" id="button2" value="Exportar a Excel resultado consolidado"  onclick="javascript:exporta_tiquete_reembolsable_contrato()" /></td>
    <td width="51%" align="left"><input name="button2" type="button" class="boton_buscar" id="button4" value="Exportar a Excel resultado detallado"  onclick="javascript:exporta_reembolsables_todos()" /></td>
  </tr>
</table>
<br />
<table width="100%" border="0">
  <tr>
    <td align="center"></td>
  </tr>
</table>
<input type="hidden" name="pre_edita" />
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />



</p>
</body>
</html>
