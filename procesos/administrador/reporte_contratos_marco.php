<? include("../../librerias/lib/@session.php");


$sel_item_contras = query_db("select id_item from t7_contratos_contrato where t1_tipo_documento_id = 2");
while($s_it_con = traer_Fila_db($sel_item_contras)){
$id_item_pecc = $s_it_con[0];
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
}
    ?>