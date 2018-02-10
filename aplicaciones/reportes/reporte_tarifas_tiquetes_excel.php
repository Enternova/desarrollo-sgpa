<?     header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de tiquetes.xls"); 
	header("Content-Transfer-Encoding: binary");


//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
.titulo1 {
	font-size:24px;
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
<table width="100%" border="1">
  <tr>
    <td height="107" colspan="2" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="7" align="left" class="titulo1"><strong>REPORTE DE TIQUETES</strong></td>
  </tr>
 
  <tr>
    <td align="center" class="titulo3" >Contrato</td>
    <td align="center" class="titulo3">Proveedor</td>
    <td align="center" class="titulo3">Gerente</td>
    <td align="center" class="titulo3">Consecutivo tiquete</td>
    <td align="center" class="titulo3">Creaci&oacute;n Tiquete</td>
    <td width="14%" align="center" class="titulo3"> Inicio Servicio</td>
    <td width="14%" align="center" class="titulo3"> Fin Servicio</td>
    <td width="9%" align="center" class="titulo3">Valor COP</td>
    <td width="9%" align="center" class="titulo3">Valor USD</td>
    <td width="14%" align="center" class="titulo3">Descuento</td>
    <td width="8%" align="center" class="titulo3"><div align="center">Valor Total COP</div></td>
    <td width="8%" align="center" class="titulo3"><div align="center">Valor Total USD</div></td>
    <td align="center" class="titulo3">Proyecto</td>
  </tr>
  <?
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
	$complemento_busqueda.= " and REPLACE(consecutivo_contrato, '-', '') like  '%".str_replace("-","",$b_contrato)."%' ";

if($b_provee!="") 
	$complemento_busqueda.= " and razon_social like  '%$b_provee%' ";

if($b_municipio!="") 
	$complemento_busqueda.= " and municipio like  '%$b_municipio%' ";

if($b_tiquete!="") 
	$complemento_busqueda.= " and consecutivo like  '%$b_tiquete%' ";  
	
	if($con_tiquetes == 1 or $con_tiquetes == 0 or $con_tiquetes == ""){
	$complemento_busqueda = " estado = 1 and t6_tarifas_proveedor_prefactura_id is not null and editado in (1,2)".$complemento_busqueda;
	}
if($con_tiquetes == 2){
	$complemento_busqueda = " t6_tarifas_proveedor_prefactura_id is null ".$complemento_busqueda;
	}
 
   $busca_item = "
select distinct t6_tarifas_proveedor_prefactura_id, tarifas_contrato_id, fecha_creacion, estado, consecutivo, municipio, proyecto, ediciones,editado,consecutivo_contrato, razon_social,gerente, nombre_administrador, fecha_ini, fecha_fin from v_tarifas_reporte_tiquetes where  $complemento_busqueda order by consecutivo desc";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
	
	if($ls_mr[8]==2) $estado="En firme - editado";
	elseif($ls_mr[3]==2) $estado="temporal";
	elseif($ls_mr[3]==1) $estado="En firme";	
	
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
    <td ><?=$ls_mr[9];?></td>
    <td ><?=$ls_mr[10];?></td>
    <td ><?=$ls_mr[12];?></td>
    <td >PRE-<?=$ls_mr[4];?>-<?=$fecha_cre[0];?> <?=$version;?></td>
    <td ><?=$ls_mr[2];?></td>
    <td ><?=$ls_mr[13];?></td>
    <td ><?=$ls_mr[14];?></td>
    <td align="right" ><?=number_format($suma_ti_sin_descuento_cop,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></td>
    <td align="right" ><?=number_format($suma_ti_sin_descuento_usd,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></td>
    <td align="right" ><?=number_format($busca_descuento[2],$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></td>
    <td style="<?=$stilo_excel;?>"  ><div align="center"><?=number_format($suma_ti_cop,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></div></td>
    <td style="<?=$stilo_excel;?>"  ><div align="center"><?=number_format($suma_ti_usd,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></div></td>
    <td><div align="center"><?=$lista_proyectos;?></div></td>
  </tr>
  
  <? $num_fila++;} ?>
</table>
</body>
</html>