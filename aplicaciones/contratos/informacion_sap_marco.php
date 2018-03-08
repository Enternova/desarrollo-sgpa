<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));

	$busca_contrato = "select * from $co1 where id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	$valor_acumulado_usd = $sql_con[17];
	$valor_acumulado_cop = $sql_con[18];
	
	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$sql_con[19]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sql_con[2];//consecutivo
			$numero_contrato4 = $sql_con[43];//apellido
			$numero_contrato_fin = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_con[0]);
			$numero_contrato_fin = str_replace("-","",$numero_contrato_fin);
			$numero_contrato_fin = str_replace(" ","",$numero_contrato_fin);
			/*
  $lista_poliza_int = "select * from ".$co4." t7c left join ".$g8." t1t on t7c.tipo_complemento = t1t.id left join ".$g9." t1to on t7c.tipo_otrosi = t1to.id left join ".$g5." t1m on t7c.tipo_moneda = t1m.t1_moneda_id  where  id_contrato = $id_contrato_arr and t7c.estado = $est_finalizado";
	$sql_poliza_int=query_db($lista_poliza_int);
	while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		if($lista_poliza_int[2]!=2){
			$valor_acumulado_usd = $valor_acumulado_usd-$lista_poliza_int[8];	
			$valor_acumulado_cop = $valor_acumulado_cop-$lista_poliza_int[32];
		}
	}
	*/
	$busca_ejecucion ="select t7e.id,t7e.id_usuario,t7e.fecha,t7e.mes_corte,t7e.estado,t7ej.id,t7ej.id_cargue,t7ej.id_contrato,t7ej.num_contrato,t7ej.por_ejecucion,t7ej.ejecucion_usd,t7ej.ejecucion_cop from $co9 t7e left join $co10 t7ej on t7ej.id_cargue = t7e.id where t7ej.num_contrato = '$numero_contrato_fin' order by t7e.id desc";
	$sql_busca_ejecucion=traer_fila_row(query_db($busca_ejecucion));
	$mes = $sql_busca_ejecucion[3];
	$valor_ejecutado_usd = $sql_busca_ejecucion[10];
	$valor_ejecutado_cop = $sql_busca_ejecucion[11];
	$porcentaje = $sql_busca_ejecucion[9];
	
	if($mes == 1)
		$imp_mes = "Enero";
	if($mes == 2)
		$imp_mes = "Febrero";
	if($mes == 3)
		$imp_mes = "Marzo";
	if($mes == 4)
		$imp_mes = "Abril";
	if($mes == 5)
		$imp_mes = "Mayo";
	if($mes == 6)
		$imp_mes = "Junio";
	if($mes == 7)
		$imp_mes = "Julio";
	if($mes == 8)
		$imp_mes = "Agosto";
	if($mes == 9)
		$imp_mes = "Septiembre";
	if($mes == 10)
		$imp_mes = "Octubre";
	if($mes == 11)
		$imp_mes = "Noviembre";
	if($mes == 12)
		$imp_mes = "Diciembre";
		
			$cont = 0;
	
$id_item_pecc=$sql_con[1];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?
echo imprime_cabeza_contrato($id_contrato)



?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><BR />
      
      
      
      
      
      
      
      
      
      <table width="100%" border="0" class="tabla_lista_resultados">

                    <tr >
                        <td width="17%" rowspan="2" align="center" class="fondo_3">Numero del Contrato Marco</td>
                        <td width="12%" rowspan="2" align="center" class="fondo_3">Contratista</td>
                        <td width="12%" rowspan="2" align="center" class="fondo_3">&Aacute;rea</td>
                        <td width="12%" rowspan="2" align="center" class="fondo_3">A&ntilde;o</td>
                        <td align="center" class="fondo_3">Valor Disponible Especifico</td>
                        <td align="center" class="fondo_3">Valor Disponible Compartido</td>
                    </tr>
                    <tr >
                        <td width="12%" align="center" class="fondo_3">Valor Equivalente USD$</td>
                        <td width="18%" align="center" class="fondo_3">Valor Equivalente USD$</td>
                    </tr>
                    <?
                    $cont = 0;

                    $delete = query_db("delete from t2_marco_temporal where id_usuario = ".$_SESSION["id_us_session"]." and id_item = ".$id_item_pecc);

                    $sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio where id_item =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");

                    while($sel_inio = traer_fila_db($sel_valor_inicial)){
                    $eq = $sel_inio[0] + ($sel_inio[1] / trm_presupuestal($sel_inio[3]));
                    $insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_inio[5].", ".$sel_inio[3].", ".$sel_inio[4].", ".$sel_inio[0].", ".$sel_inio[1].", $eq, 'NO', ".$sel_inio[6]." )");

                    }


                    $ampliacion = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");

                    while($sel_ampl = traer_fila_db($ampliacion)){
                    $eq = $sel_ampl[0] + ($sel_ampl[1] / trm_presupuestal($sel_ampl[3]));
                    $valor_usd_queda_si = 0;
                    $valor_cop_queda_si = 0;
                    $valor_eq_queda_si =  0;

                    $sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
                    if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
                    //verifica si ya hay linea en temporal
                    $sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
                    $sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));


                    $insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
                    //}
                    //fin verifica si ya hay linea en temporal

                    }else{// ampliaciones presupuesto especifico o no compartido	
                    $sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";

                    $sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
                    if($sele_si_ya_tiene_especifico > 0){
                    $valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
                    $valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
                    $valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];

                    $udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
                    }else{
                    $insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
                    }

                    }
                    }

                    /*-------------------------AMPLIACIONES QUE ESTAN EN ESTADO SOCIOS --------------------*/

                    $ampliacion_en_socios = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_en_socios where id_item_peec_aplica =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");


                    while($sel_ampl = traer_fila_db($ampliacion_en_socios)){
                    $eq = $sel_ampl[0] + ($sel_ampl[1] / trm_presupuestal($sel_ampl[3]));
                    $valor_usd_queda_si = 0;
                    $valor_cop_queda_si = 0;
                    $valor_eq_queda_si =  0;

                    $sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
                    if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
                    //verifica si ya hay linea en temporal
                    $sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
                    $sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));

                    $insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
                    //}
                    //fin verifica si ya hay linea en temporal

                    }else{// ampliaciones presupuesto especifico o no compartido	
                    $sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";

                    $sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
                    if($sele_si_ya_tiene_especifico > 0){
                    $valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
                    $valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
                    $valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];

                    $udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
                    }else{
                    $insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
                    }

                    }
                    }
                    /*-------------------------AMPLIACIONES QUE ESTAN EN ESTADO SOCIOS --------------------*/
                    //order de trabajo
                    $valor_que_falta_restar = 0;
					$sel_orden = query_db("select  trm, sum(valor_usd), sum(valor_cop), t1_campo_id, ano, t7_contrato_id from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc." group by trm,  t1_campo_id, ano, t7_contrato_id");
					
                    //$sel_orden = query_db("select * from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc);
                    while($or_ot = traer_fila_db($sel_orden)){
                  //  $comple_we = "where  id_item =".$id_item_pecc." and id_contrato = ".$or_ot[8]." and   ano = ".$or_ot[7]." and campo = ".$or_ot[6]." and id_usuario = ".$_SESSION["id_us_session"]."";
					$comple_we = "where  id_item =".$id_item_pecc." and id_contrato = ".$or_ot[5]." and   ano = ".$or_ot[4]." and campo = ".$or_ot[3]." and id_usuario = ".$_SESSION["id_us_session"]."";
                    $sel_va_esp = traer_fila_row(query_db("select sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'SI'"));
					
					$valo_solicitado = $or_ot[1]+($or_ot[2]/trm_presupuestal($or_ot[4]));
                    //$valo_solicitado = $or_ot[9];
                    $valor_disponible = $sel_va_esp[0];

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
                    }					


                    }

                    //arriba de despapaya los valores origenes
                    }else{// Si mayor el disponible que las ots
                    $valor_que_disponible_esp = $valor_disponible - $valo_solicitado;
                    $update = query_db("update t2_marco_temporal set eq_usd = $valor_que_disponible_esp $comple_we  and especifico = 'SI'");
                    }

                    }
                    //FIN ordenes de trabjado

                    $fecha_hoy = date("Y-m-d");
                    $cont = 0;
                    $sele_contratos = query_db("select id_contrato, ano, campo from t2_marco_temporal where id_item =".$id_item_pecc." and id_usuario = ".$_SESSION["id_us_session"]." group by id_contrato, ano, campo order by id_contrato");
                    while($sel_cont = traer_fila_db($sele_contratos)){
                    $mustra_contrato = "SI";


                    $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, contratista, vigencia_mes,analista_deloitte from $co1 where id = ".$sel_cont[0]));

                    $fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
                    $mensaje_alerta="";
                    if($sel_contrato[4] <= $fecha_vence){
                    $mensaje_alerta = "Este Contrato esta Proximo a Vencer ".$sel_contrato[4];
                    }

                    if($sel_contrato[4] < $fecha_hoy or $sel_contrato[5] == 1){// si el contrato esta vencido /  congelado
                    $mustra_contrato = "NO";
                    }

                    if($mustra_contrato == "SI"){
                    $sel_proveedor_nombre = traer_fila_row(query_db("select razon_social from $g6 where t1_proveedor_id = ".$sel_contrato[3]));

                    $numero_contrato1 = "C";

                    $separa_fecha_crea = explode("-",$sel_contrato[0]);
                    $ano_contra = $separa_fecha_crea[0];

                    $numero_contrato2 = substr($ano_contra,2,2);
                    $numero_contrato3 = $sel_contrato[1];
                    $numero_contrato4 = $sel_contrato[2];

                    $sel_valor_especifico = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where  id_item =".$id_item_pecc." and id_contrato = ".$sel_cont[0]." and   ano = ".$sel_cont[1]." and campo = ".$sel_cont[2]." and especifico = 'SI' and id_usuario = ".$_SESSION["id_us_session"].""));

                    $sel_valor_compartido = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where id_item =".$id_item_pecc." and  id_contrato = ".$sel_cont[0]." and   ano = ".$sel_cont[1]." and campo = ".$sel_cont[2]." and especifico = 'NO' and id_usuario = ".$_SESSION["id_us_session"].""));

                    $espesifico_usd = $sel_valor_especifico[0];
                    $espesifico_cop = $sel_valor_especifico[1];
                    $eq_especifico = $sel_valor_especifico[2];
                    $compartido_usd =$sel_valor_compartido[0];
                    $compartido_cop = $sel_valor_compartido[1];
                    $eq_compartido = $sel_valor_compartido[2];

                    if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                    }else{
                    $clase= "";
                    $cont = 0;
                    }
                    ?>
                    <td align="center" class="<?= $clase ?>"><?= numero_item_pecc_contrato($numero_contrato1, $numero_contrato2, $numero_contrato3, $numero_contrato4, $sel_cont[0]) ?> <span class="titulos_resumen_alertas"><?= $mensaje_alerta ?></span></td>
                    <td align="center" class="<?= $clase ?>"><?= $sel_proveedor_nombre[0] ?></td>
                    <td align="center" class="<?= $clase ?>"><?= saca_nombre_lista($g15, $sel_cont[2], 'nombre', 't1_campo_id') ?></td>
                    <td align="center" class="<?= $clase ?>"><?= $sel_cont[1] ?></td>
                    <td class="<?= $clase ?>"><?= number_format($eq_especifico, 0) ?></td>
                    <td class="<?= $clase ?>"><?= number_format($eq_compartido, 0) ?></td>
                    </tr>
                    <?
                    }//fin si no tiene alertas
                    }
                    ?>

                </table>
      
      
      
      
      
      
      
      
      
      
      
      
      
    </td>
  </tr>
</table>

</body>
</html>
