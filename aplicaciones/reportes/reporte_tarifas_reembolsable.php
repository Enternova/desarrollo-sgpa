<?     header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de reembolsables.xls"); 
	header("Content-Transfer-Encoding: binary");


//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");
 
// $complemento_busqueda = " and editado = 1 ";  
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
    <td colspan="5" align="left" class="titulo1"><strong>REPORTE DE REEMBOLSABLES</strong></td>
  </tr>

  <tr>
    <td width="8%" align="center" class="titulo3">Contrato</td>
    <td width="5%" align="center" class="titulo3">Nit</td>
    <td width="23%" align="center" class="titulo3">Proveedor</td>
    <td width="23%" align="center" class="titulo3">Gerente</td>
    <td width="5%" align="center" class="titulo3">Area Usuaria</td>
    <td width="11%" align="center" class="titulo3">Consecutivo reembolsables</td>
    <td width="14%" align="center" class="titulo3"><div align="center">Fecha de creaci&oacute;n</div></td>
    <td width="15%" align="center" class="titulo3"><div align="center">Valor COP</div></td>
    <td width="15%" align="center" class="titulo3"><div align="center">Valor USD</div></td>
    <td width="6%" align="center" class="titulo3">%_admin</td>
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
	
	
 $busca_item = "
select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado,  municipo, consecutivo, editado, numero_ediciones, consecutivo_contreto,razon_social,nombre_administrador,t1_area_id,nit from $v_t_11  where  $complemento_busqueda order by consecutivo desc ";	  

	
//echo $busca_item;

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
						?>
                     
 
  
   <tr>
    <td ><?=$ls_mr[8];?></td>
    <td ><?=$ls_mr[12];?></td>
    <td ><?=$ls_mr[9];?></td>
    <td ><?=$ls_mr[10];?></td>
    <td ><?=saca_nombre_lista($g12,$ls_mr[11],'nombre','t1_area_id');?></td>
    <td >PRE-
      <?=$ls_mr[5];?>
      - <?php $porciones = explode("-", $ls_mr[2]);
	  echo $porciones[0];
	  ?>
     <?=$version;?></td>
    <td ><?=$ls_mr[2];?></td>
    <td ><div align="center"><?=number_format($suma_ti_cop,2);?></div></td>
    <td ><div align="center"><?=number_format($suma_ti_usd,2);?></div></td>
    <td >% <?=$busca_descuneto_im[1];?></td>
  </tr>
  
  <? $num_fila++;
  $suma_ti_cop=0;
  $suma_ti_usd=0;
  } ?>
  
  <tr>  
 
</table>

</body>
</html>