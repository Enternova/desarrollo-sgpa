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

$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	



$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr   ";
	$sql_con=traer_fila_row(mssql_query($busca_contrato));	
	   
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
    <td colspan="5" align="left" class="titulo1"><strong>REPORTE DE REEMBOLSABLES CONTRATO <?=$sql_con[7];?></strong></td>
  </tr>
 
  <tr>
    <td width="14%" align="center" class="columna_subtitulo_resultados">Estado</td>
    <td width="17%" align="center" class="columna_subtitulo_resultados">Consecutivo reembolsable</td>
    <td width="21%" align="center" class="columna_subtitulo_resultados">Gerente</td>
    <td width="13%" align="center" class="columna_subtitulo_resultados"><div align="center">Fecha de creaci&oacute;n</div></td>
    <td width="6%" align="center" class="columna_subtitulo_resultados"><div align="center">Valor COP</div></td>
    <td width="6%" align="center" class="columna_subtitulo_resultados"><div align="center">Valor USD</div></td>
    <td width="13%" align="center" class="columna_subtitulo_resultados">%_admin</td>
  </tr>
 <?
 $busca_item = " select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado,  municipo, consecutivo, editado, numero_ediciones, consecutivo_contreto,razon_social,nombre_administrador from $v_t_11 where tarifas_contrato_id =  $id_contrato_arr  and estado = 1 ORDER BY t6_tarifas_reembolables_datos_id desc";

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
    <td ><?=$estado;?></td>
    <td >R-<?=$ls_mr[5];?> - <?=$fecha_cre[0];?>
      <?=$version;?></td>
    <td ><?=$ls_mr[10];?></td>
    <td ><?=$ls_mr[2];?></td>
    <td  style="<?=$stilo_excel;?>"><div align="right"><?=number_format($suma_ti_cop,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></div></td>
    <td  style="<?=$stilo_excel;?>"><div align="right"><?=number_format($suma_ti_usd,$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?></div></td>
    
    <td >%
    <?=$busca_descuneto_im[1];?></td>
  </tr>
  
  <? $num_fila++; 
  $suma_ti=0;
  } ?>
</table>
</body>
</html>