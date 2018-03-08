<?  header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de tarifas.xls"); 
	header("Content-Transfer-Encoding: binary");


include("../../librerias/lib/@include.php");


			
			$pagina_session = $_POST['pagina'];
			$tipo_actuali_b_session = $_POST['tipo_actuali_b'];
			$detalle_tarifa_session = $_POST['detalle_tarifa'];
			$objeto_session = $_POST['objeto'];
			$nu_contrato_session = $_POST['nu_contrato'];
			$proveedor_session = $_POST['proveedor'];
			$roll_gerente_session = $_POST['roll_gerente'];
			$vigencia_contrato_session = $_POST['vigencia_contrato'];
			$codigo_tarifa_session = $_POST['codigo_tarifa'];
			$busca_estado_aprobacion_session = $_POST['busca_estado_aprobacion'];
			$especialista_bu = $_POST['especialista_bu'];
?>

<?
	
	
	
if($nu_contrato!=""){
	
	$id_numero_contrato = str_replace("-", "", $nu_contrato );
	$id_numero_contrato = str_replace(" ", "", $id_numero_contrato);
	
	$complemento =	" and replace(consecutivo,'-','') like '%$id_numero_contrato%'";
	
			
	
}
	
	
if($proveedor!="")
	$complemento.=	" and razon_social like '%$proveedor%'";
if($objeto!="")
	$complemento.=	" and objeto_contarto like '%$objeto%'";		
	
if($especialista_bu!=""){
		$id_especialista = $especialista_bu;
		$complemento = $complemento." and especialista = ".$id_especialista;
	}

if($busca_estado_aprobacion>=1)
	{
	
  $busca_detalle = "	select distinct tarifas_contrato_id from $v_t_3 where creada_luego_firme =2 and t6_tarifas_estados_tarifas_id not in (8,9) and t6_tarifas_estados_tarifas_id = $busca_estado_aprobacion	";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas	
		
			$busca_contratos_ta.=",".$lista_detalle[0];
		
		}//todas las tarifas	
	
		$complemento.= " and tarifas_contrato_id in (0 $busca_contratos_ta) ";
	}

if($tipo_actuali_b>=1)
	{
	
  $busca_detalle = "	select distinct tarifas_contrato_id from $v_t_3 where creada_luego_firme =2 and t6_tarifas_estados_tarifas_id not in (8,9) and tipo_creacion_modifica = $tipo_actuali_b	";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas	
		
			$busca_contratos_ta.=",".$lista_detalle[0];
		
		}//todas las tarifas	
	
		$complemento.= " and tarifas_contrato_id in (0 $busca_contratos_ta) ";
	}


if($codigo_tarifa!="")
	{
	
  $busca_detalle = "	select distinct tarifas_contrato_id from $v_t_3 where codigo_proveedor like '%$codigo_tarifa%' and t6_tarifas_estados_tarifas_id not in (8,9) ";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas	
		
			$busca_contratos_ta.=",".$lista_detalle[0];
		
		}//todas las tarifas	
	
		$complemento.= " and tarifas_contrato_id in (0 $busca_contratos_ta) ";
	}


if($detalle_tarifa!="")
	{
	
  $busca_detalle = "	select distinct tarifas_contrato_id from $v_t_3 where detalle like '%$detalle_tarifa%'  and t6_tarifas_estados_tarifas_id not in (8,9) 	";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas	
		
			$busca_contratos_ta.=",".$lista_detalle[0];
		
		}//todas las tarifas	
	
		$complemento.= " and tarifas_contrato_id in (0 $busca_contratos_ta) ";
	}
	
if($roll_gerente>=1)
	$complemento.=	" and gerente = $roll_gerente";		
	
if($vigencia_contrato==1)
	$complemento.=	" and vigencia_mes >= '$fecha' ";		

if($vigencia_contrato==2)
	$complemento.=	" and vigencia_mes <= '$fecha' ";	
	
if($vigencia_contrato==4)
	$complemento.=	" and estado_contrato = 2 and vigencia_mes >= '$fecha'";
if($vigencia_contrato==5)
	$complemento.=	" and estado_contrato = 1 and vigencia_mes >= '$fecha'";

if($vigencia_contrato==3)
	$complemento.=	" and estado_contrato = 6";		
if($vigencia_contrato==6)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes >= '$fecha'";	
if($vigencia_contrato==7)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes < '$fecha'";		


if($vigencia_contrato==8)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes >= '$fecha' 
	and (select count(*) from  t6_tarifas_lista as h where h.tarifas_contrato_id  = d.tarifas_contrato_id) >= 1";	

if($vigencia_contrato==9)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes >= '$fecha' 
	and (select count(*) from  t6_tarifas_lista as h where h.tarifas_contrato_id  = d.tarifas_contrato_id) =0";	

if($vigencia_contrato==10)
	$complemento.=	" and estado_contrato = 6 and  vigencia_mes < '$fecha' 
	and (select count(*) from  t6_tarifas_lista as h where h.tarifas_contrato_id  = d.tarifas_contrato_id) >= 1";	

if($vigencia_contrato==11)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes < '$fecha'
	and (select count(*) from  t6_tarifas_lista as h where h.tarifas_contrato_id  = d.tarifas_contrato_id) =0";	

	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
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
<br />
<table width="100%" border="1" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  
  <tr>
    <td width="9%" class="titulo3">Estado del Contrato</td>
    <td width="9%" class="titulo3"><div align="center">Contrato</div></td>
    <td width="34%" class="titulo3"><div align="center">Objeto</div></td>
    <td width="33%" class="titulo3"><div align="center">Proveedor</div></td>
    <td width="33%" class="titulo3">Fecha de Inicio</td>
    <td width="33%" class="titulo3">Fecha de Fin</td>
    <td width="33%" class="titulo3">Contrato Congelado</td>
    <td width="33%" class="titulo3">Aplica IPC</td>
 <td width="33%" class="titulo3"><div align="center">Aplica Reembolsables</div></td>
  </tr>
  
<?


$busca_item = "select consecutivo,objeto_contarto,nombre,valor,tarifas_contrato_id,razon_social,monto_usd, monto_cop, id_contrato, ipc, reembolsable, fecha_inicio, vigencia_mes,estado_contrato_general, obs_congelado, analista_deloitte  from $v_t_1 as d where estado_contrato not in (4) and estado_contrato_general not in (50)  $complemento $complet_2  ";	

	$sql_ex22 = query_db($busca_item);
	while($ls_mr = traer_fila_row($sql_ex22)){



	
		
?>  
  
  <tr>
    <td ><? if($ls_mr[13] == 49) { echo "Finalizado";}elseif($ls_mr[13] == 48){ echo "Legalizado";} else { echo "En legalizacion"; }?></td>
    <td ><?=numero_cotnrato_tarifas($ls_mr[4]);?></td>
    <td ><?=$ls_mr[1];?></td>
    <td><?=$ls_mr[5];?></td>
    <td><?=$ls_mr[11];?></td>
    <td><?=$ls_mr[12];?></td>
    <td><? if($ls_mr[15] == 1) echo "Congelado: ".$ls_mr[14]; else ""; ?></td>
    <td><? if($ls_mr[9]==1) echo "Aplica"; else echo "No aplica";?></td>
<td><? if($ls_mr[10]>0) echo $ls_mr[10]; else echo "No aplica";?></td>
  </tr>
  
  <? } ?>
  

</table>

</body>
</html>
