<? header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=Reporte detalle contrato marco total disponible para crear OTs Ops.xls"); header("Pragma: no-cache"); header("Expires: 0");	 
include("../../librerias/lib/@session.php"); 

	
if($eq_moneda == 1 or $eq_moneda == "" or $eq_moneda == 0){
	$moneda = "USD";
	}
if($eq_moneda == 2){
	$moneda = "COP";
	}
	
	
		
	$id_item_pecc_para_reporte = $_GET["id_item_pecc_para_reporte"];
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<style>
@charset "utf-8";
body {
	color:#676767;
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
	font-size:12px;
	margin-top: 2px;
	background:#F8F8F8;
}
.tabla_lista_resultados{  
	margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; 
  BORDER-RIGHT: #cccccc 3px  double; 
  BORDER-TOP: #cccccc 1px solid;  	
  BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  
 }
 
 .estilo_reporte_fondo_verde{
	color:#FFF;
	background-color:#093;
	font-weight: bold;
	
	BORDER-BOTTOM: #F00 0px solid; 
	BORDER-RIGHT: #F00 0px solid; 
	BORDER-TOP: #F00 0px solid;  
	BORDER-LEFT: #F00 0px solid; 
	
	
	}
.fondo_3{ background:#005395; color:#FFFFFF;}

.tabla_paginador{ font-size:14px; color:#666666} 

.filas_resultados_reporte_saldos1{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
.filas_resultados_reporte_saldos2{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 0px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
	

.filas_resultados_blanco{ background:#FFFFFF} 
.filas_resultados{ background:#DBFBDC} 

</style>

</head>

<body>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr><td>
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF" class="tabla_lista_resultados">
    <tr>
      <td><strong>SALDO DEL CONTRATO PARA CREAR ORDENES DE TRABAJO</strong></td>
    </tr>
  </table>
  </td></tr>
  </table>
  
  
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr>
  <td width="100%" align="center"><table width="100%" border="0" class="tabla_lista_resultados">
    <tr >
      <td width="23%" rowspan="2" align="center" class="fondo_3">Numero del Contrato Marco</td>
      <td width="22%" rowspan="2" align="center" class="fondo_3">Contratista</td>
      <td width="14%" rowspan="2" align="center" class="fondo_3">&Aacute;rea</td>
      <td width="5%" rowspan="2" align="center" class="fondo_3">A&ntilde;o</td>
      <td align="center" class="fondo_3">Valor Para Crear Ordenes de Trabajo -<br />
      <strong>Valor para un Contrato Especifico</strong></td>
      <td align="center" class="fondo_3">Valor Para Crear Ordenes de Trabajo -<br /><strong>Valor Compartido entre Varios Contratos</strong></td>
    </tr>
    <tr >
      <td width="18%" align="center" class="fondo_3">Valor Equivalente <?=$moneda?>$</td>
      <td width="18%" align="center" class="fondo_3">Valor Equivalente <?=$moneda?>$</td>
    </tr>
    <?
	$cont = 0;
	
	$delete = query_db("delete from t2_marco_temporal where id_usuario = ".$_SESSION["id_us_session"]." and id_item = ".$id_item_pecc_para_reporte);
	$sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio where id_item =".$id_item_pecc_para_reporte." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
	
if($id_item_pecc_para_reporte==7891){
	$aplica_contrato_nuevo="SI";
	}

/*---esto es para que aparezcala solicitud inicial en disponible especifico o compartido---*/
	$sel_si_es_uno_o_varios_contratos = traer_fila_row(query_db("select top(1) ROW_NUMBER() OVER(ORDER BY t7_contrato_id DESC) AS Row  from v_peec_amplia_real_inicio where id_item =".$id_item_pecc_para_reporte." group by t7_contrato_id order by row desc"));
$selec_tipo_contras = traer_fila_row(query_db("select count(*) from t7_contratos_contrato where id_item = ".$id_item_pecc_para_reporte." and tipo_bien_servicio like '%Bienes%' and estado <> 50"));
	
	if(($sel_si_es_uno_o_varios_contratos[0] == 1 or  $selec_tipo_contras[0]==1 or $aplica_contrato_nuevo=="SI") ){//comentarie este or del if y el query por que no supe para que es (or $selec_tipo_contras[0] > 0)
	$un_contrato = "SI";//Esto es para sumar en el resultado
	if($id_item_pecc_para_reporte == 1149 or $id_item_pecc_para_reporte == 4424 or $id_item_pecc_para_reporte == 5929  or $id_item_pecc_para_reporte ==5441  or $id_item_pecc_para_reporte == 5855  or $id_item_pecc_para_reporte==5936  or $id_item_pecc_para_reporte==9626 or $id_item_pecc_para_reporte==8836){//item que no se pueden agrupar desde el inicio
		$es_especifico = "NO";
		}else{
			$es_especifico = "SI";
			}				
				}else{
					$un_contrato = "NO";//Esto es para sumar en el resultado
					$es_especifico = "NO";
					}
					
					
	if($selec_tipo_contras[0]>0 or $aplica_contrato_nuevo=="SI"){
		$cuente_si_es_la_nueva_adjudicacion=traer_fila_row(query_db("select count(*) from v_peec_amplia_real_inicio_bien_servicio where id_item=".$id_item_pecc_para_reporte));
			if($cuente_si_es_la_nueva_adjudicacion[0]>0 or $aplica_contrato_nuevo=="SI"){
			$sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio_bien_servicio where id_item =".$id_item_pecc_para_reporte." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
				}
		}
/*---FIN esto es para que aparezcala solicitud inicial en disponible especifico o compartido---*/					


	
	while($sel_inio = traer_fila_db($sel_valor_inicial)){
			$eq = $sel_inio[0] + ($sel_inio[1] / trm_presupuestal($sel_inio[3]));
			
					
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc_para_reporte, ".$sel_inio[5].", ".$sel_inio[3].", ".$sel_inio[4].", ".$sel_inio[0].", ".$sel_inio[1].", $eq, '".$es_especifico."', ".$sel_inio[6]." )");
			
		}

	
	$ampliacion = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc_para_reporte." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
		  
		  while($sel_ampl = traer_fila_db($ampliacion)){
			  $eq = $sel_ampl[0] + ($sel_ampl[1] / trm_presupuestal($sel_ampl[3]));
			  $valor_usd_queda_si = 0;
			$valor_cop_queda_si = 0;
			$valor_eq_queda_si =  0;
						
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
						//verifica si ya hay linea en temporal
						$sql_comple = "where id_item =".$id_item_pecc_para_reporte." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
						$sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));
						
							
								$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc_para_reporte, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
								//}
						//fin verifica si ya hay linea en temporal
						
					}else{// ampliaciones presupuesto especifico o no compartido	
					$sql_comple = "where id_item =".$id_item_pecc_para_reporte." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";
					
					$sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
					if($sele_si_ya_tiene_especifico > 0){
						$valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
						$valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
						$valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];
						
						$udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
						}else{
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc_para_reporte, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
					}
			
						}
			  }
	
	/*-------------------------AMPLIACIONES QUE ESTAN EN ESTADO SOCIOS --------------------*/

	$ampliacion_en_socios = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_en_socios where id_item_peec_aplica =".$id_item_pecc_para_reporte." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");

		  
		  while($sel_ampl = traer_fila_db($ampliacion_en_socios)){
			  $eq = $sel_ampl[0] + ($sel_ampl[1] / trm_presupuestal($sel_ampl[3]));
			  $valor_usd_queda_si = 0;
			$valor_cop_queda_si = 0;
			$valor_eq_queda_si =  0;
						
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
						//verifica si ya hay linea en temporal
						$sql_comple = "where id_item =".$id_item_pecc_para_reporte." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
						$sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));
													
								$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc_para_reporte, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
								//}
						//fin verifica si ya hay linea en temporal
						
					}else{// ampliaciones presupuesto especifico o no compartido	
					$sql_comple = "where id_item =".$id_item_pecc_para_reporte." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";
					
					$sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
					if($sele_si_ya_tiene_especifico > 0){
						$valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
						$valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
						$valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];
						
						$udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
						}else{
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc_para_reporte, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
					}
			
						}
			  }
	/*-------------------------AMPLIACIONES QUE ESTAN EN ESTADO SOCIOS --------------------*/
	
	/*-------------------------RECLASIFICACIONES AUMENTA VALOR --------------------*/

	$ampliacion_en_socios = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_reclasificacion where id_item_peec_aplica =".$id_item_pecc_para_reporte." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");

		  
		  while($sel_ampl = traer_fila_db($ampliacion_en_socios)){
			  $eq = $sel_ampl[0] + ($sel_ampl[1] / trm_presupuestal($sel_ampl[3]));
			  $valor_usd_queda_si = 0;
			$valor_cop_queda_si = 0;
			$valor_eq_queda_si =  0;
						
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real_reclasificacion where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
						//verifica si ya hay linea en temporal
						$sql_comple = "where id_item =".$id_item_pecc_para_reporte." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
						$sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));
													
								$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc_para_reporte, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
								//}
						//fin verifica si ya hay linea en temporal
						
					}else{// ampliaciones presupuesto especifico o no compartido	
					$sql_comple = "where id_item =".$id_item_pecc_para_reporte." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";
					
					$sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
					if($sele_si_ya_tiene_especifico > 0){
						$valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
						$valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
						$valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];
						
						$udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
						}else{
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc_para_reporte, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
					}
			
						}
			  }
	/*-------------------------RECLASIFICACIONES AUMENTA VALOR --------------------*/
	//RECLASIFICAICONES DESCUENTA
	$valor_que_falta_restar = 0;
	

		$sel_orden = query_db("select  trm, sum(valor_usd), sum(valor_cop), t1_campo_id, ano, t7_contrato_id from v_peec_valor_ot_real_reclasificacion where id_item_peec_aplica =".$id_item_pecc_para_reporte." group by trm,  t1_campo_id, ano, t7_contrato_id");
		while($or_ot = traer_fila_db($sel_orden)){
			$comple_we = "where  id_item =".$id_item_pecc_para_reporte." and id_contrato = ".$or_ot[5]." and   ano = ".$or_ot[4]." and campo = ".$or_ot[3]." and id_usuario = ".$_SESSION["id_us_session"]."";

			$sel_va_esp = traer_fila_row(query_db("select sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'SI'"));
			
			$valo_solicitado = $or_ot[1]+($or_ot[2]/trm_presupuestal($or_ot[4]));
			
			$valor_disponible = $sel_va_esp[0];
			
			$valo_solicitado = number_format($valo_solicitado,9,'.','');
			$valor_disponible = number_format($valor_disponible,9,'.','');
			$valor_solicitado1 = explode(".",$valo_solicitado);
			$decimal = trim(substr("00".substr($valor_solicitado1[1], 0,2),-2));
			$valor_solicitado2 = $valor_solicitado1[0].".".$decimal."0000000";
			$valo_solicitado = number_format($valor_solicitado2,9,'.','');

			if($valo_solicitado > $valor_disponible){// si es menor el disponible que las OTS
					$update = query_db("update t2_marco_temporal set valor_usd = 0, valor_cop = 0, eq_usd = 0 $comple_we  and especifico = 'SI'");
					
					$valo_solicitado = $valo_solicitado - $valor_disponible;
					
						$sel_agrupo_presupuesto = query_db("select id_presupuesto, sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'NO' group by id_presupuesto order by id_presupuesto");
					while($sel_presu_ag = traer_fila_db($sel_agrupo_presupuesto)){
					$valor_disponible_liinea = $sel_presu_ag[1];
					if($valor_disponible_liinea > 0 and $valor_disponible_liinea >= $valo_solicitado and $valo_solicitado > 0){
						$nuevo_valor_disponible = $valor_disponible_liinea - $valo_solicitado;
							$update = query_db("update t2_marco_temporal set eq_usd = $nuevo_valor_disponible where  id_presupuesto =".$sel_presu_ag[0]);
						$valo_solicitado = $valo_solicitado - $valor_disponible_liinea;
					}else{
						if($valo_solicitado > 0){
						$update = query_db("update t2_marco_temporal set eq_usd = 0 where  id_presupuesto =".$sel_presu_ag[0]);
						$valo_solicitado = $valo_solicitado - $valor_disponible_liinea;
						}	
					}
			
						
					}
					
					//arriba de despapaya los valores origenes
				}else{// Si mayor el disponible que las ots
					$valor_que_disponible_esp = $valor_disponible - $valo_solicitado;
					$update = query_db("update t2_marco_temporal set eq_usd = $valor_que_disponible_esp $comple_we  and especifico = 'SI'");
					}
			
			}
	//FIN RECLASIFICAICONES DESCUENTA
	//order de trabajo
	$valor_que_falta_restar = 0;

		$sel_orden = query_db("select  trm, sum(valor_usd), sum(valor_cop), t1_campo_id, ano, t7_contrato_id from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc_para_reporte." group by trm,  t1_campo_id, ano, t7_contrato_id order by t1_campo_id asc");
		
		while($or_ot = traer_fila_db($sel_orden)){
			$comple_we = "where  id_item =".$id_item_pecc_para_reporte." and id_contrato = ".$or_ot[5]." and   ano = ".$or_ot[4]." and campo = ".$or_ot[3]." and id_usuario = ".$_SESSION["id_us_session"]."";
			

			$sel_va_esp = traer_fila_row(query_db("select sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'SI'"));
			
			$valo_solicitado = $or_ot[1]+($or_ot[2]/trm_presupuestal($or_ot[4]));
			
			$valor_disponible = $sel_va_esp[0];
			
			$valo_solicitado = number_format($valo_solicitado,9,'.','');
			$valor_disponible = number_format($valor_disponible,9,'.','');
			$valor_solicitado1 = explode(".",$valo_solicitado);
			$decimal = trim(substr("00".substr($valor_solicitado1[1], 0,2),-2));
			$valor_solicitado2 = $valor_solicitado1[0].".".$decimal."0000000";
			$valo_solicitado = number_format($valor_solicitado2,9,'.','');

			if($valo_solicitado > $valor_disponible){// si es menor el disponible que las OTS
					$update = query_db("update t2_marco_temporal set  eq_usd = 0 $comple_we  and especifico = 'SI'");
					
					$valo_solicitado = $valo_solicitado - $valor_disponible;
					
						$sel_agrupo_presupuesto = query_db("select id_presupuesto, sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'NO' group by id_presupuesto order by id_presupuesto");
					while($sel_presu_ag = traer_fila_db($sel_agrupo_presupuesto)){
					$valor_disponible_liinea = $sel_presu_ag[1];
					if($valor_disponible_liinea > 0 and $valor_disponible_liinea >= $valo_solicitado and $valo_solicitado > 0){
						$nuevo_valor_disponible = $valor_disponible_liinea - $valo_solicitado;
							$update = query_db("update t2_marco_temporal set eq_usd = $nuevo_valor_disponible where  id_presupuesto =".$sel_presu_ag[0]);
						$valo_solicitado = $valo_solicitado - $valor_disponible_liinea;
						
					}else{
						//if($_SESSION["id_us_session"] == 18186 or $_SESSION["id_us_session"] == 18025){
							if($valor_disponible_liinea < $valo_solicitado and $valo_solicitado > 0){
							$valo_solicitado = $valo_solicitado-$valor_disponible_liinea;
							$update = query_db("update t2_marco_temporal set eq_usd = 0 where  id_presupuesto =".$sel_presu_ag[0]);
							}
						//}else{
							//$update = query_db("update t2_marco_temporal set eq_usd = 0 where  id_presupuesto =".$sel_presu_ag[0]);
							//$valo_solicitado = $valo_solicitado - $valor_disponible_liinea;
							//}
						}					
			
						
					}
					
					//arriba de despapaya los valores origenes
				}else{// Si mayor el disponible que las ots
					$valor_que_disponible_esp = $valor_disponible - $valo_solicitado;					
					$sel_presu_id = traer_fila_row(query_db("select id_presupuesto from t2_marco_temporal $comple_we  and especifico = 'SI' and id_presupuesto > 0 group by id_presupuesto "));					
					if($sel_presu_id[0]>0){
					$update = query_db("update t2_marco_temporal set eq_usd = $valor_que_disponible_esp where  id_presupuesto =".$sel_presu_id[0]);	
						}else{
							$update = query_db("update t2_marco_temporal set eq_usd = $valor_que_disponible_esp $comple_we  and especifico = 'SI'");
							}
					}
			
			}
	//FIN ordenes de trabjado
	
	
	
	$fecha_hoy = date("Y-m-d");
	$cont = 0;

    $sele_contratos = query_db("select id_contrato, ano, campo from t2_marco_temporal where id_item =".$id_item_pecc_para_reporte." and id_usuario = ".$_SESSION["id_us_session"]." group by id_contrato, ano, campo order by id_contrato");
				while($sel_cont = traer_fila_db($sele_contratos)){
					
		  
		  		  
		   $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, contratista, vigencia_mes, estado from $co1 where id = ".$sel_cont[0]));
		  if($sel_contrato[5] <> 50){
			  
		  $fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			$mensaje_alerta="";
			if($sel_contrato[4] <= $fecha_vence){
				$mensaje_alerta = "Este Contrato esta Proximo a Vencer ".$sel_contrato[4];
				}
			if($sel_contrato[5] == 33){
				$mensaje_alerta = "<strong>este contrato esta Eliminado</strong>";
				}
				
		  
		  $sel_proveedor_nombre = traer_fila_row(query_db("select razon_social from $g6 where t1_proveedor_id = ".$sel_contrato[3]));
		  
		  $numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_contrato[0]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[1];
					$numero_contrato4 = $sel_contrato[2];
					
		$sel_valor_especifico = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where  id_item =".$id_item_pecc_para_reporte." and id_contrato = ".$sel_cont[0]." and   ano = ".$sel_cont[1]." and campo = ".$sel_cont[2]." and especifico = 'SI' and id_usuario = ".$_SESSION["id_us_session"].""));
		
		$sel_valor_compartido = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where id_item =".$id_item_pecc_para_reporte." and  id_contrato = ".$sel_cont[0]." and   ano = ".$sel_cont[1]." and campo = ".$sel_cont[2]." and especifico = 'NO' and id_usuario = ".$_SESSION["id_us_session"].""));
					
		  $espesifico_usd = $sel_valor_especifico[0];
		  $espesifico_cop = $sel_valor_especifico[1];
		  if($moneda == "USD"){
		  $eq_especifico = $sel_valor_especifico[2];
		  $eq_compartido = $sel_valor_compartido[2];
		  }
		  if($moneda == "COP"){
			  $trm=trm_presupuestal($sel_cont[1]);
		  $eq_especifico = $sel_valor_especifico[2] * $trm;
		  $eq_compartido = $sel_valor_compartido[2] * $trm;
		  }
		  $compartido_usd =$sel_valor_compartido[0];
		  $compartido_cop = $sel_valor_compartido[1];
          
		 
		 if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  
		  if($un_contrato == "SI"){
			  $eq_especifico= $eq_compartido+$eq_especifico;
			  $eq_compartido = 0;
			  }
	?>
    <tr >
      <td align="center" class="<?=$clase?>"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont[0])?>
        <span class="titulos_resumen_alertas">
          <?=$mensaje_alerta?>
        </span></td>
      <td align="center" class="<?=$clase?>"><?=$sel_proveedor_nombre[0]?></td>
      <td align="center" class="<?=$clase?>"><?=saca_nombre_lista($g15,$sel_cont[2],'nombre','t1_campo_id')?></td>
      <td align="center" class="<?=$clase?>"><?=$sel_cont[1]?></td>
      <td class="<?= $clase ?>"><?= number_format($eq_especifico, 0,"","");?><? $tt_espe = $eq_especifico + $tt_espe ?></td>
      <td class="<?= $clase ?>"><?= number_format($eq_compartido, 0,"","");?> <? $tt_compa = $eq_compartido + $tt_compa ?></td>
    </tr>
    <?
				}//si el contrato no esta eliminado
				}
   ?>
   <tr>
                      <td align="center" >&nbsp;</td>
                      <td align="center" >&nbsp;</td>
                      <td colspan="2" align="center"  >&nbsp;</td>
                      <td >&nbsp;</td>
                      <td >&nbsp;</td>
                    </tr>
  </table></td>
</tr>

</table>




</body>
</html>
