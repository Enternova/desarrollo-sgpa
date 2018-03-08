<?  
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
include("../lib/@session.php");
//include("../php/funciones_general_2015.php");
//include("../php/funciones_general.php");
verifica_menu("administracion.html");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

/*?>
<script>
//window.parent.document.getElementById("cargando").style.display=""
</script>
<?*/

if($_POST["accion"]=="graba_objetivos_proceso"){

$sel_si_existe = traer_fila_row(query_db("select * from t2_objetivos_proceso where id_item = ".$_POST["id_item_pecc"]));

$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$_POST["id_item_pecc"]));

if($_POST["permiso_ad_ob_proceso"]==1){			
$permiso_adj=1;
$edicion_datos = "SI";			
}

if($_POST["permiso_ad_ob_proceso"]==2){			
$permiso_adj=2;			
$edicion_datos = "SI";
}


echo $permiso_adj;


if($permiso_adj==1){

$oportunidad="p_oportunidad";
$costo="p_costo";
$calidad="p_calidad";
$optimizar="p_optimizar";
$trazabilidad="p_trazabilidad";
$transparencia="p_transparencia";
$sostenibilidad="p_sostenibilidad";

}

if($permiso_adj==2){

$oportunidad="a_oportunidad";
$costo="a_costo";
$calidad="a_calidad";
$optimizar="a_optimizar";
$trazabilidad="a_trazabilidad";
$transparencia="a_transparencia";
$sostenibilidad="a_sostenibilidad";

}


if($sel_si_existe[0]>0){//update

$insert_into=query_db("update t2_objetivos_proceso set $oportunidad='".$_POST["campo_ob_proceso1"]."', $costo='".$_POST["campo_ob_proceso2"]."',$calidad='".$_POST["campo_ob_proceso3"]."', $optimizar='".$_POST["campo_ob_proceso4"]."', $trazabilidad='".$_POST["campo_ob_proceso5"]."',$transparencia='".$_POST["campo_ob_proceso6"]."', $sostenibilidad='".$_POST["campo_ob_proceso7"]."' where id_item=".$_POST["id_item_pecc"]);
}else{//crear
$insert = "insert into t2_objetivos_proceso (id_item, $oportunidad, $costo, $calidad, $optimizar, $trazabilidad, $transparencia, $sostenibilidad) values ( '".$_POST["id_item_pecc"]."', '".$_POST["campo_ob_proceso1"]."', '".$_POST["campo_ob_proceso2"]."', '".$_POST["campo_ob_proceso3"]."', '".$_POST["campo_ob_proceso4"]."', '".$_POST["campo_ob_proceso5"]."', '".$_POST["campo_ob_proceso6"]."', '".$_POST["campo_ob_proceso7"]."')";

echo $insert;

$insert_into=query_db($insert);
}

?><script>
    window.parent.document.getElementById("div_carga_busca_sol").style.display = 'none'
</script><?
}
?>
<?php
if ($_POST["accion"] == "cambia_valor_item") {
    $id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
    $id_item = elimina_comillas(arreglo_recibe_variables($_POST["id_item_agrega"]));

    $nuevo_valor = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["nue_valor_sol_" . $_POST["id_item_agrega"]]))) + 0;
    $nuevo_valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["nue_valor_sol_" . $_POST["id_item_agrega"] . "_cop"]))) + 0;

    $nuevo_valor = number_format($nuevo_valor, 0, '', '');
    $nuevo_valor_cop = number_format($nuevo_valor_cop, 0, '', '');

    $id_presupuesto = $_POST["id_presupuesto"];
    $valor_usd_dif = elimina_comillas($_POST["valor_usd_dif"]);
    $valor_cop_dif = elimina_comillas($_POST["valor_cop_dif"]);

    $ano = "2016";
    $campo = 1;


    $sel_item = traer_fila_row(query_db("select estado, t1_tipo_proceso_id,id_item_peec_aplica from t2_item_pecc where id_item = " . $id_item));

    if ($sel_item[1] == 1 or $sel_item[1] == 2 or $sel_item[1] == 3) {//si es invitacion o directa
        if ($sel_item[0] == 8) {
            $delete_presupuesto = query_db("delete from t2_presupuesto where t2_item_pecc_id = " . $id_item . " and permiso_o_adjudica = 1");
            $inseert = query_db("insert into t2_presupuesto (t2_item_pecc_id, t1_campo_id, adjunto, valor_usd, valor_cop, ano, permiso_o_adjudica) values ($id_item, $campo, ''," . $nuevo_valor . " , " . $nuevo_valor_cop . ", $ano,1)");
        } else {
            /* ----- Query para guardar nuevo valor por separado, segun la cantidad de proveedores */
            $actualiza = query_db("update t2_presupuesto set t1_campo_id = $campo,  valor_usd = $valor_usd_dif,  valor_cop=$valor_cop_dif, ano=$ano where t2_item_pecc_id = $id_item  and t2_presupuesto_id = $id_presupuesto and permiso_o_adjudica = 2");

            /* ----- Query para sumar las cantidades usd y cop de los nuevos valores del presupuesto de los proveedores */
            $sum_valores = traer_fila_row(query_db("select sum(valor_usd),sum(valor_cop) from t2_presupuesto where t2_item_pecc_id = " . $id_item . " and permiso_o_adjudica = 2"));
            $sum_usd = (int) $sum_valores[0];
            $sum_cop = (int) $sum_valores[1];

            /* ----- Query para guardar la informacion en la tabla t2_comite_realcion_item */
            $actualiza2 = query_db("update $c2 set nuevo_valor_solicitud = $sum_usd, nuevo_valor_solicitud_cop = $sum_cop where id_comite = $id_comite and id_item = $id_item");

//            $sele_cuantas_distribuciones = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = " . $id_item . " and permiso_o_adjudica = 2"));
//            $divide_en = $sele_cuantas_distribuciones[0];
//            if ($divide_en <= 0) {
//                $divide_en = 1;
//            }
//            $valor_distri_usd = $nuevo_valor / $divide_en;
//            $valor_distri_cop = $nuevo_valor_cop / $divide_en;
        }
    } else {// si son solicitudes sin permiso
        if ($sel_item[1] == 6) {// adjudicacion direacta
            $sele_cuantas_distribuciones = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = " . $id_item . " and permiso_o_adjudica = 2"));
            $divide_en = $sele_cuantas_distribuciones[0];
            if ($divide_en <= 0) {
                $divide_en = 1;
            }
            $valor_distri_usd = $nuevo_valor / $divide_en;
            $valor_distri_cop = $nuevo_valor_cop / $divide_en;

            $actualiza = query_db("update t2_presupuesto set t1_campo_id =$campo,  valor_usd = $valor_distri_usd,  valor_cop=$valor_distri_cop, ano=$ano where t2_item_pecc_id = " . $id_item . " and permiso_o_adjudica = 2");
        } else {
            if ($sel_item[1] == 7) {//si es ampliacion

                /* ----------- valida que tenga por lo menos un contrato */
                $tiene_seleccionado = "NO";

                $sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =" . $sel_item[2] . " and t1_tipo_documento_id = 2");
                while ($sel_cont = traer_fila_db($sele_contratos)) {

                    if ($_POST["contra_" . $sel_cont[0] . "_" . $id_item] != "") {
                        $tiene_seleccionado = "SI";
                    }
                }
                if ($tiene_seleccionado == "NO") {
                    ?>
                    <script>
                        alert("Debe Seleccionar aunque sea un contrato");
                    </script><?php
                    exit;
                }

                /* ----------- valida que tenga por lo menos un contrato */

                $delete_presupuesto = query_db("delete from t2_presupuesto where t2_item_pecc_id = " . $id_item);

                $inserta_procesos = "insert into $pi8 (t1_campo_id,t2_item_pecc_id,adjunto,valor_usd,valor_cop, ano, permiso_o_adjudica,destino_final,cargo_contable) values ($campo,$id_item,'','" . $nuevo_valor . "','" . $nuevo_valor_cop . "',$ano,1,'','')";
                $sql_ex = query_db($inserta_procesos . $trae_id_insrte);
                $id_ingreso = id_insert($sql_ex);

                $sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =" . $sel_item[2] . " and t1_tipo_documento_id = 2");
                while ($sel_cont = traer_fila_db($sele_contratos)) {

                    if ($_POST["contra_" . $sel_cont[0] . "_" . $id_item] != "") {
                        $insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (" . $id_ingreso . "," . $sel_cont[0] . ")");
                    }
                }

                $inserta_procesos2 = query_db("insert into $pi8 (t1_campo_id,t2_item_pecc_id,adjunto,valor_usd,valor_cop, ano, permiso_o_adjudica,destino_final,cargo_contable) values ($campo,$id_item,'','" . $nuevo_valor . "','" . $nuevo_valor_cop . "',$ano,2,'','')");
            } else if ($sel_item[1] == 8) {//si es OT
            } else {

                $delete_presupuesto = query_db("delete from t2_presupuesto where t2_item_pecc_id = " . $id_item . " and permiso_o_adjudica = 1");
                $delete_presupuesto = query_db("delete from t2_presupuesto where t2_item_pecc_id = " . $id_item . " and permiso_o_adjudica = 2");

                $inseert = query_db("insert into t2_presupuesto (t2_item_pecc_id, t1_campo_id, adjunto, valor_usd, valor_cop, ano, permiso_o_adjudica) values ($id_item, $campo, ''," . $nuevo_valor . " , " . $nuevo_valor_cop . ", $ano,1)");
                $inseert = query_db("insert into t2_presupuesto (t2_item_pecc_id, t1_campo_id, adjunto, valor_usd, valor_cop, ano, permiso_o_adjudica) values ($id_item, $campo, ''," . $nuevo_valor . " , " . $nuevo_valor_cop . ", $ano,2)");
            }
        }//fin si es adjudicacion de adjudicacion directa
    }//fin si son solicitudes sinpermiso

    if ($actualiza2 != TRUE) {
        $update = query_db("update t3_comite_relacion_item set nuevo_valor_solicitud = '" . $nuevo_valor . "', nuevo_valor_solicitud_cop = '" . $nuevo_valor_cop . "' where id_comite = " . $id_comite . " and id_item = " . $id_item);
    }
    ?>
    <script>
        alert("Se grabo con exito")
    </script>
    <?php
}
?>

<?

if($_POST["accion"]=="graba_cambio_tp_proceso"){
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
$id_item = elimina_comillas(arreglo_recibe_variables($_POST["id_item_agrega"]));
$cambio_tp_proceso = arreglo_recibe_variables($_POST["cambio_tp_proceso_".$_POST["id_item_agrega"]]);

$update =query_db("update t3_comite_relacion_item_relacion_modificaciones set estado = 2 where id_comite = ".$id_comite." and id_item = ".$id_item);

$update =query_db("insert into t3_comite_relacion_item_relacion_modificaciones (id_cambio_comite, id_comite, id_item, estado) values (".$cambio_tp_proceso.", ".$id_comite." , ".$id_item.", 1) ");

$sel_tp_resultado = traer_fila_row(query_db("select id_proceso_resultado, estado_resultado from t3_convinaciones_cambio_proceso where id =".$cambio_tp_proceso));
$actualiza_solicitud = query_db("update t2_item_pecc set t1_tipo_proceso_id = ".$sel_tp_resultado[0].", estado = ".$sel_tp_resultado[1]." where id_item = ".$id_item);

?>
<script>
    alert("Se grabo con exito, Espere a que la pagina se recargue.")
	window.parent.ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite=<?=$id_comite ?>', 'contenidos');
</script>
<?


}

if($_POST["accion"]=="graba_comentario_comite"){
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
$id_item = elimina_comillas(arreglo_recibe_variables($_POST["id_item_agrega"]));
$comentario = arreglo_recibe_variables($_POST["comenta_secretario_".$_POST["id_item_agrega"]]);

$update =query_db("update t3_comite_relacion_item set comentario_secretrario = '".$comentario."' where id_comite = ".$id_comite." and id_item = ".$id_item);
	
	$id_log_presupuesto = log_de_procesos_sgpa(3, 94, 0, $id_comite, 0, 0);//agrega valores
	log_agrega_detalle ($id_log_presupuesto, "Solicitud",$id_item , "t2_item_pecc",1);
	log_agrega_detalle ($id_log_presupuesto, "Comentario del Secretario",$comentario , "",2);

?>
<script>
    alert("Se grabo con exito")
</script>
<?


}

if($_POST["accion"]=="crea_accion_aprobacion"){
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
$id_item_agrega = $_POST["id_item_agrega"];
$observacion = arreglo_recibe_variables($_POST["observacion_".$_POST["id_item_agrega"]]);


$selec_comite = traer_fila_row(query_db("select * from $c1 where id_comite =".$id_comite));
$elim_anteriores = query_db("delete from $c4 where id_comite =".$id_comite." and id_asistente = ".$_POST["asistente_comote"]." and id_item = ".$_POST["id_item_agrega"]);
$insert_aproba = query_db("insert into $c4 (id_comite, id_asistente, id_item, fecha, aprobacion, observacion) values (".$id_comite.",".$_POST["asistente_comote"].",".$_POST["id_item_agrega"].", '$fecha', ".$_POST["accion_comite_usuario_".$_POST["id_item_agrega"]].", '".$observacion."')");
//BUSCA QUE TODOS LOS APROBADORES HALLAN HECHO ACCION
$falta_aprobar = "NO";
$sel_asis = query_db("select * from $c3 where id_comite =".$id_comite." and requiere_aprobacion = 1 ");
while($se_asiss = traer_fila_db($sel_asis)){
$sel_aporr = traer_fila_row(query_db("select count(*) from $c4 where id_asistente =".$se_asiss[0]." and id_item = ".$_POST["id_item_agrega"]));

$cunete_aprobaciones = traer_fila_row(query_db("select count(*) from $c4 where id_comite=".$id_comite." and id_item = ".$_POST["id_item_agrega"]." and (aprobacion = 1 or aprobacion = 4 or aprobacion = 2 or aprobacion = 10)"));//CUENTE LAS APROBACIONES
if($sel_aporr[0]==0 and $cunete_aprobaciones[0] < 4){
$falta_aprobar = "SI";
}

}//BUSCA QUE TODOS LOS APROBADORES HALLAN HECHO ACCION
$pendiente = "NO";
if($falta_aprobar == "NO"){//SI YA APROBARON TODOS ACTUALIZA EL ESTADO DE LA RELACION SOLICTUD
$select_aprobacion = traer_fila_row(query_db("select count(*) from $c4 where id_comite=".$id_comite." and id_item = ".$_POST["id_item_agrega"]." and aprobacion = 3"));//CUENTE LAS APROBACIONES de pendiente

if($select_aprobacion[0]>0){
$pendiente = "SI";
}
if($pendiente == "SI"){
$upda_2 = query_db("update $c2 set estado = 3 where id_comite =".$id_comite." and id_item=".$_POST["id_item_agrega"]."");
}else{
$upda_2 = query_db("update $c2 set estado = 1 where id_comite =".$id_comite." and id_item=".$_POST["id_item_agrega"]."");
}
}
//id_comite
//id_item

$id_log_presupuesto = log_de_procesos_sgpa(3, 95, 0, $id_comite, 0, 0);//agrega valores
	log_agrega_detalle ($id_log_presupuesto, "Solicitud",$_POST["id_item_agrega"], "t2_item_pecc",1);
	log_agrega_detalle ($id_log_presupuesto, "Observacion",$observacion , "",2);
	$accion_nombre="";
	
	if($_POST["accion_comite_usuario_".$_POST["id_item_agrega"]] == 1) $accion_nombre ="Firmar";
	if($_POST["accion_comite_usuario_".$_POST["id_item_agrega"]] == 4) $accion_nombre ="Firmar con Comentarios";
	if($_POST["accion_comite_usuario_".$_POST["id_item_agrega"]] == 2) $accion_nombre ="Pendiente; Sacar de este Comité";
	if($_POST["accion_comite_usuario_".$_POST["id_item_agrega"]] == 10) $accion_nombre ="Rechazar";
	
	log_agrega_detalle ($id_log_presupuesto, "Accion",$accion_nombre , "",3);
?>
<script>
    //window.parent.ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite=<?=$id_comite ?>', 'contenidos');
window.parent.ajax_carga('../aplicaciones/comite/info_firmas.php?id_comite=<?=$id_comite?>&id_item_agrega=<?=$id_item_agrega?>', 'info_firmas<?=$id_item_agrega?>');
</script>
<?

}?>
<?php
if ($_POST["accion"] == "finalizar_acciones_comite") {

$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));

    // FINALIZACION DEL COMITE 
    $selec_comite = traer_fila_row(query_db("select * from $c1 where id_comite =" . $id_comite));

    //CUENTA CUANTAS RELACIONES HACEN FALTA POR APROBACION
    $sele_item_pendientes = traer_fila_row(query_db("select count(*) from $vcomite2 where id_comite =" . $id_comite . " and estado = 2"));

	$query_falta_descarga_comflicto=traer_fila_row(query_db("SELECT count(*) FROM t3_comite_relacion_item WHERE id_comite=".$id_comite." and (descarga_archivo_conflicto != 1 or revisa_archivo_conflicto != 2)"));//revisa que todas las solicitudes tengan revisados los conflictos de interes.
	
    $sum_mayor = 0;
    
    if ($sele_item_pendientes[0] == 0 and $selec_comite[10] == 2 and $query_falta_descarga_comflicto[0]==0) {//SI NO HAY PENDIENTES
        
        $sele_item_pendientes_sql = query_db("select * from $vcomite2 where id_comite =" . $id_comite . " and estado = 1"); //SELECCIONE TODAS LAS SOLICITUDES DEL COMITE

        while ($s_pen = traer_fila_db($sele_item_pendientes_sql)) {

 $id_item_aproba = $s_pen[0];

            $sele_items = traer_fila_row(query_db("select * from $pi2 where id_item = " . $id_item_aproba));
            $estado_actividad_actual = $sele_items[14];
            $permiso_ad = 1;
            if ($estado_actividad_actual == 17) {
                $permiso_ad = 2;
            }
			
			
//             Verifica si algun proceso es mayor a $500.000 y pasara a verificacion de presidente, en caso de que no sea asi se finaliza el item, 
//            if ($s_pen['eq_usd'] >= MONTO_COMITE or $s_pen['nuevo_valor_solicitud'] >= MONTO_COMITE) {
//                $sum_mayor++;
//            }

           //Esta parte es nueva, se preguntarÃ¡ ahora segun tabla t2_presupuesto 

            $sel_presupuesto = traer_fila_row(query_db("select sum(valor_cop), sum(valor_usd) from $pi8 where t2_item_pecc_id = " . $s_pen['id_item'] . " and permiso_o_adjudica = ".$permiso_ad ));

            
                $val_usd = ($sel_presupuesto[0] / trm_presupuestal($s_pen[4])) + $sel_presupuesto[1];
            
            
            if ($val_usd >= MONTO_COMITE) {
                $sum_mayor++;
            }
//echo "select sum(valor_cop), sum(valor_usd) from $pi8 where t2_item_pecc_id = " . $s_pen['id_item'] . " and permiso_o_adjudica = ".$permiso_ad;
//echo "*".$val_usd." - ".MONTO_COMITE." - ".$sum_mayor;
           

            $select_aprobacion = traer_fila_row(query_db("select count(*) from t3_comite_aprobacion where id_comite=" . $id_comite . " and id_item = " . $id_item_aproba . " and (aprobacion = 1 or aprobacion = 4)")); //CUENTE LAS APROBACIONES

            $cuantas_aprobaciones = 10;
            if ($selec_comite[11] == "virtual") {
                $cuantas_aprobaciones = 3;
            }
            if ($selec_comite[11] == "presencial") {
                $cuantas_aprobaciones = 0;
            }

            $select_rechazadas = traer_fila_row(query_db("select count(*) from t3_comite_aprobacion where id_comite=" . $id_comite . " and id_item = " . $id_item_aproba . " and (aprobacion = 2 or aprobacion =10)")); //CUENTE LAS Rechazadas

            if ($select_aprobacion[0] > $cuantas_aprobaciones and $select_rechazadas[0] == 0) {//SI ES APROBADO
                $sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=" . $id_item_aproba . " and actividad_estado_id > " . $estado_actividad_actual));

//echo "aprueba ".$id_item_aproba." estado: ".$estado_item."<br />";

                if ($sel_estado[0] == 19) {
                    $dias_compara = 1500;
                } else {
                    $dias_compara = 0;
                }

                if ($sel_estado[0] == 10) {
                    $sel_estado[0] = 11;
                    agrega_gestion_pecc($id_item_pecc, 10, $fecha, 1500);
                }

                agrega_gestion_pecc($id_item_aproba, $estado_actividad_actual, $fecha, $dias_compara);
                $estado_item = $sel_estado[0];
                $estado_firma = 1;


                if ($estado_item < 10 and $sele_items[6] <> 7 and $sele_items[6] <> 8) {//SI ES EL PERMISO
                    //crea_antecedente_auto($id_item_aproba, "aprueba_permiso", "");
                }

                $sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='" . $id_item_aproba . "'"));

                $sel_que_tipo_proceso = traer_fila_row(query_db("select t1_tipo_proceso_id from $pi2 where id_item=" . $id_item_aproba));
				
				if($sele_items[69]==1){
					$upda_item = query_db("update $pi2 set estado=32 where id_item=".$sele_items[43]);
					}

                if (($sel_que_tipo_proceso[0] == 9 or $sel_que_tipo_proceso[0] == 10 or $sel_que_tipo_proceso[0] == 11 or $sel_que_tipo_proceso[0] == 12 or $sele_tipo_doc_desierto[13] == 4)) {//SI ES emergencia, informativo, caso excepcional
                    $upda_item = query_db("update $pi2 set estado=32, aprobado = 1 where id_item=" . $id_item_aproba);
                    $estado_item = 32;
					declarar_desierto_rene($id_item_aproba);
                }
            } else {//SI NO ES APROBADO
                $estado_firma = 2;
//echo "rechaza ".$id_item_aproba." estado: ".$estado_item."<br />";

                $select_rechazadas_definitiva = traer_fila_row(query_db("select count(*) from $c4 where id_comite=" . $id_comite . " and id_item = " . $id_item_aproba . " and aprobacion =10")); //CUENTE LAS Rechazadas

                $sel_gestiones_max = traer_fila_row(query_db("select max(t2_gestion) from $pi17 where id_item = $id_item_aproba and estado = 1"));
                if ($sel_gestiones_max[0] != "") {
                    $sel_gestiones = traer_fila_row(query_db("select fecha_real from $pi17 where t2_gestion = " . $sel_gestiones_max[0]));
                    $fecha_ini = $sel_gestiones[0];
                    $fecha_fin = $fecha;
                    $dias = dias_habiles_entre_fechas($fecha_ini, $fecha_fin);
                } else {
                    $dias = 0;
                }


                if ($select_rechazadas_definitiva[0] > 0) {//si es rechazada definitivamente
                    $estado_item = 32;
                    $upda_item = query_db("update $pi2 set estado=" . $estado_item . ",  solicitud_rechazada= 1 where id_item=" . $id_item_aproba);
                    $upda_2 = query_db("update $c2 set estado = 10 where id_comite =" . $id_comite . " and id_item=" . $id_item_aproba . "");

                    $desactiva_superior = query_db("update t2_nivel_servicio_gestiones set estado = 3 where id_item = $id_item_aproba and t2_nivel_servicio_actividad_id >=" . $estado_actividad_actual);

                    $agrega_acti_gestion = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado,observacion,devolucion) values ($id_item_aproba, $estado_actividad_actual, " . $_SESSION["id_us_session"] . ", '" . $fecha . "', $dias,2,'" . $ob . "',1)");

                    /* ----- Enviar notificacion por correo a todos los involucrados, Para el comite */
                    envia_email_solicitudes($id_item_aproba, $id_comite);
                } else {

                    agrega_gestion_pecc_atras($id_item_aproba, $estado_actividad_actual, $fecha, 0);
                    $sel_estado = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3 where id_item=" . $id_item_aproba . " and actividad_estado_id < " . $estado_actividad_actual . " and (actividad_estado_id IN (6,14))"));
                    $estado_item = $sel_estado[0];
//cambia_pendiente otras aprobaciones
					
					$sel_todas_las_secuencias = query_db("select * from $pi14 where id_item_pecc =" . $id_item_aproba . " and tipo_adj_permiso =$permiso_ad and id_rol not in (15,10)");

                    while ($sel_sucun = traer_fila_db($sel_todas_las_secuencias)) {
                        $update_aprobas = query_db("update $pi16 set aprobado = 0 where id_secuencia_solicitud = " . $sel_sucun[0] . "");
                    }
//fin cambia aprobaciones
                    $upda_2 = query_db("update $c2 set estado = 4 where id_comite =" . $id_comite . " and id_item=" . $id_item_aproba . "");
                }//si no es rechazada definitivamente
            }//FIN SI LA SOLICITUD NO SE APRUEBA

echo $id_item_aproba."-".$estado_item."*";
			if($estado_item=="" and $estado_actividad_actual==17 and $sel_items[4]<>1){//si es bienes finaliza la solictud
				
				$upda_item = query_db("update $pi2 set estado=32, aprobado = 1 where id_item=" . $id_item_aproba);
				
				}
            if ($estado_item == 19 or ($sel_que_aplica_procurement_contras[1] == 8 and $estado_item == 20)) {//SI YA PASO A SOLICITUD PAR, ENTONCS YA TERMINO
                
				$sel_que_aplica_procurement_contras = traer_fila_row(query_db("select esta_en_e_procurement,t1_tipo_proceso_id from $pi2 where id_item=" . $id_item_aproba));

                if ($sel_que_aplica_procurement_contras[1] == 1 or $sel_que_aplica_procurement_contras[1] == 2 or $sel_que_aplica_procurement_contras[1] == 3 or $sel_que_aplica_procurement_contras[1] == 6) {//SI APLICA EN Contratos
                    $es_marco = verifica_solicitud_marcos($id_item_aproba);
                    if ($es_marco == "NO") {
                        crea_contratos($id_item_aproba);
                    } else {
                        crea_contratos_marco($id_item_aproba);
                    }
                }

                if ($sel_que_aplica_procurement_contras[0] == 1) {//SI APLICA EN EPROCUREMENT
//			crear_en_e_procurement($id_item_aproba);//FUNCION PARA CREARLO EN EPROCUREMENT
                }

                if ($sel_que_aplica_procurement_contras[1] == 4 or $sel_que_aplica_procurement_contras[1] == 5) {//SI ES OTRO SI
                    crea_otro_si($id_item_aproba);
                }
                if ($sel_que_aplica_procurement_contras[1] == 8) {//SI ES OT
                    crea_ots($id_item_aproba);
                }
                if ($sel_que_aplica_procurement_contras[1] == 7) {//SI ES ampliacion
                    crea_ampliacion($id_item_aproba);
                }

                $upda_item = query_db("update $pi2 set estado=20 where id_item=" . $id_item_aproba);
            } //SI YA PASO A SOLICITUD PAR, ENTONCS YA TERMINO
            if ($estado_item != 19) {
                $upda_item = query_db("update $pi2 set estado=" . $estado_item . " where id_item=" . $id_item_aproba);
            }
//pone accion en firmas en el sistema
            $sel_secuencia = traer_fila_row(query_db("select * from $pi14 where id_rol=10 and id_item_pecc=" . $id_item_aproba . " and tipo_adj_permiso =$permiso_ad"));

            $insert = query_db("insert into $pi16 (id_secuencia_solicitud, id_us,fecha, aprobado,observacion) values (" . $sel_secuencia[0] . "," . $selec_comite[1] . ", '$fecha', $estado_firma,'Ver Firmas en el Comit&eacute; No. " . numero_item_pecc($selec_comite[6], $selec_comite[7], $selec_comite[8]) . "')");
//fin pone accion en firmas en el sistema
            ?>
            <script>
                window.parent.ajax_carga('../aplicaciones/comite/historico.php', 'contenidos');
            </script>
            <?php
        }
$update_comite = query_db("update $c1 set estado = 1, presidente = 2  where id_comite=" . $id_comite); //ACTUALIZA EL ESTADO A FINALIZADO y como ya no aplica la ratificacion, desde aca se sañta ese paso, si se desea volver a activar lo que se debe hacer es eliminar toda esta linea y YA!

        /* *****  Se cambia esta linea al final del while, para verificar que los items agregados sus valores son mayores o menores de USD 500.000 ****** 
         * *****  Para de esta manera conocer si el estado se cambia a revisar por el presidente (1) presidente (0) o si automaticamente se cierra (1) presidente (2)****** 
         * *****  Estado del presidente se coloca en (2) lo que significa q no requirio verificacion por parte del presidente ****** */
        if($sum_mayor != 0){
            $update_comite = query_db("update $c1 set estado = 1 where id_comite=" . $id_comite); //ACTUALIZA EL ESTADO A VERIFICACION PRESIDENTE
        }else{
            $update_comite = query_db("update $c1 set estado = 1, presidente = 2  where id_comite=" . $id_comite); //ACTUALIZA EL ESTADO A FINALIZADO EN EL COMITE
        }
		
		
		
		
		
		
		/***********--------CONFIGURACION DE CORREO DE CIERRE DE COMITE-------------*************************************************************/
		
		

/**************------------------FIN CIERRE DEL COMITE DE CONTRATOS-----------------********************/
		/***************** PARA EL DES-002-17****************************/
    $num_comite=""; $fecha_comite=""; $tipo_comite=""; $asunto="";
    $inicio_tabla="<span style='font-size:14px; font-family: Arial;'>Gerentes de contrato y Profesionales / Compradores de abastecimiento<br><br>Adjunto estoy enviando el acta del comit&eacute; de contratos con su respectivo resultado. Por favor tener en cuenta las observaciones de los miembros del comit&eacute; y del secretario.<strong><br>Se les recuerda que NO deben iniciar a ejecutar actividades hasta que los tr&aacute;mites contractuales est&eacute;n debidamente formalizados.</strong><br><br>";
    $fin_tabla="<br>Cordial saludo:<br>Secretario del comit&eacute;.<br></span>";
    $query_item="select $c1.id_comite, $c1.fecha, $c1.num1 AS num1_comite, $c1.num2 AS num2_comite, $c1.num3 AS num3_comite, $c1.tipo_comite, $c1.tipo_comite_extraordinario, $c2.estado AS estado_item, $pi2.num1 AS num1_item, $pi2.num2 AS num2_item, $pi2.num3 AS num3_item, $c2.id_item FROM $c2 INNER JOIN $c1 ON $c2.id_comite = $c1.id_comite INNER JOIN $pi2 ON $c2.id_item = $pi2.id_item WHERE $c1.id_comite=$id_comite";
    $query_user="select $c1.id_comite, $c1.fecha, $c1.num1, $c1.num2, $c1.num3, $c1.tipo_comite, $c1.tipo_comite_extraordinario, $c3.rol_aprobacion, $g1.nombre_administrador, $g1.email, $c3.estado, $g1.us_id FROM $g1 INNER JOIN $c1 INNER JOIN $c3 ON $c1.id_comite = $c3.id_comite ON $g1.us_id = $c3.id_us WHERE $c1.id_comite=$id_comite and $c3.requiere_aprobacion <> 2";
    /*******INICO BUSCA LOS PUNTOS DEL COMITE ********************************/
    $sele_comite_uno = traer_fila_row(query_db("select * from $c1 where id_comite =$id_comite"));
  $fecha=strtotime($sele_comite_uno[2]);
  $ano = date("Y", $fecha);
  $mes = date("n", $fecha);
  $desde_cuando_aplica_id_comite_2016=162;  
  $abre_indicador = "NO";
  $bloquea_ratificacion = "";

  if($sele_comite_uno[0] >= $desde_cuando_aplica_id_comite_2016){
    $bloquea_ratificacion = "SI";
    }
  if($sele_comite_uno[0] > $desde_cuando_aplica_id_comite){
    $abre_indicador = "SI";
    }
    
  if($ano >= 2016){
    $bloquea_ratificacion = "SI";
    if($ano > 2016 or ($ano == 2016 and $mes >=04)){
      $abre_indicador = "SI";
      }
      
  }
$inicio_puntos="<table width='100%' border='1' style='font-size:12px; font-family: Arial;'>";
    
    if($mes == 1){
      $mes_muestra = "Enero";
      }
    if($mes == 2){
      $mes_muestra = "Febrero";
      }
    if($mes == 3){
      $mes_muestra = "Marzo";
      }
    if($mes == 4){
      $mes_muestra = "Abril";
      }
    if($mes == 5){
      $mes_muestra = "Mayo";
      }
    if($mes == 6){
      $mes_muestra = "Junio";
      }
    if($mes == 7){
      $mes_muestra = "Julio";
      }
    if($mes == 8){
      $mes_muestra = "Agosto";
      }
    if($mes == 9){
      $mes_muestra = "Septiembre";
      }
    if($mes == 10){
      $mes_muestra = "Actubre";
      }
    if($mes == 11){
      $mes_muestra = "Noviembre";
      }
    if($mes == 12){
      $mes_muestra = "Diciembre";
      }
    $asistentes="";
   /* $sel_asistentes = query_db("select t1.rol_aprobacion, t2.nombre_administrador  from t3_comite_asistentes as t1, t1_us_usuarios as t2 where t1.id_comite = ".$id_comite." and t1.requiere_aprobacion = 1 and t1.id_us = t2.us_id order by t1.orden");
    while($sel_asis = traer_fila_db($sel_asistentes)){
      $asistentes=$asistentes.$sel_asis[0]." - ".$sel_asis[1]."<br />";
      //echo $sel_asis[0]." - ".$sel_asis[1]."<br />';
    }
    $sel_asistentes = query_db("select t1.rol_aprobacion, t2.nombre_administrador  from t3_comite_asistentes as t1, t1_us_usuarios as t2 where t1.id_comite = ".$id_comite." and t1.requiere_aprobacion <> 1 and t1.id_us = t2.us_id order by t1.orden");
    $otros_asistentes="";
    while($sel_asis = traer_fila_db($sel_asistentes)){
      $otros_asistentes=$otros_asistentes.$sel_asis[0]." - ".$sel_asis[1]."<br />";
      //echo $sel_asis[0]." - ".$sel_asis[1]."<br />';
    }*/
    $inicio_puntos=$inicio_puntos."<tr><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Tipo de Proceso </font></td><td colspan='2' align='center' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Informaci&oacute;n de PECC</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Tipo de la Solicitud</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>N&uacute;mero de la Solicitud</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Resultado del Comit&eacute;</font></td>";
    if($bloquea_ratificacion == ""){
    $inicio_puntos=$inicio_puntos."<td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Verificaci&oacute;n del Presidente</font></td>";
    }
    $inicio_puntos=$inicio_puntos."<td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>&Aacute;rea Responsable</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Gerente Solicitud</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Profesional Encargado</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Recomendaci&oacute;n</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Aplica Socios</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>N&uacute;mero de Contrato</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Contratista</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Valor USD</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Valor COP</font></td><td align='center' rowspan='2' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Comentario del Comit&eacute;</font></td></tr><tr style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'><td width='8%' align='center' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>Origen PECC</font></td><td width='8%' align='center' style='background-color:#135798; color:#FFF; font-family: Arial;'><font font-size='8'>L&iacute;nea del PECC</font></td></tr>";

$sel_repor = query_db("select num1, num2, num3, fecha, permiso_o_adjudica, tipo_proceso, Expr1, Expr2, Expr3, estado, area, gerente_solicitud, CAST(objeto_solicitud AS text), Cast(ob_solicitud_adjudica as text), Cast(recomendacion_adjudica as text), cast(recomendacion as text), usd_permiso, cop_permiso, usd_ad, cop_ad, Cast(comentario_secretrario AS text), id_comite, Profesional, t1_tipo_proceso_id, contrato_id, id_item, t1_tipo_contratacion_id, orden, tipo_comite_extraordinario, Expr4, solicitud_rechazada, solicitud_desierta, proveedores_sugeridos, valor_solicitud_comite, presidente, aplica_presidente, verificacion_general_comite, presidente_fecha, campo_contrato_vencimiento,valor_solicitado_eq from vista_reporte_comite where Expr4 <> 33 and id_comite=$id_comite order by num3 asc, valor_solicitud_comite desc");
    $cont=0;
  while($sel_r = traer_fila_db($sel_repor)){
    if($cont == 0){
        $clase= "background:#DBFBDC";
        $cont = 1;
    }else{
        $clase= "";
        $cont = 0;
    }
      $select_info_pecc="SELECT origen_pecc, pecc_linea, pecc_modificado, Cast(pecc_modificado_observacion AS TEXT) AS justificacion FROM v_peec_historico WHERE id_item=$sel_r[25]";
      $result_info_pecc=traer_fila_db(query_db($select_info_pecc));
      $comple_texto_tp_proceso="";
      $res_comi="";
      $rechazado="";
      $desierto="";
      if($sel_r[30]==1){
        $rechazado="SI";
      }
      if($sel_r[31]==1){
        $desierto="SI";
      }        
      $numero_comite = numero_item_pecc($sel_r[0],$sel_r[1],$sel_r[2]);
      $numero_consecut = numero_item_pecc($sel_r[6],$sel_r[7],$sel_r[8]);
	  
	  		$valor_solicitud = explode("---",valor_solicitud($sel_r[25], $sel_r[4]));
	  		$valor_usd=$valor_solicitud[0];
            $valor_cop=$valor_solicitud[1];  
	  
      if($sel_r[4] ==1){
          $nombre_tp = "PERMISO";          
                  
          $fecha_aprueba_ad = "";
          $ob = $sel_r[12];
          $reco = $sel_r[15];
          if($ob == ""){
            $ob = $sel_r[13];
          }
          if($reco == ""){
            $reco = $sel_r[14];
          }            
          $sel_si_socios = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud where id_rol = 11 and tipo_adj_permiso = 1 and estado = 1 and id_item_pecc =".$sel_r[25]));
      }else{
          $nombre_tp = "ADJUDICACI&Oacute;N";
        /*  $valor_usd=$sel_r[18];
          $valor_cop=$sel_r[19];*/
          if($sel_r[9] == 1){
            $fecha_aprueba_ad = $sel_r[3];
          }
          $ob = $sel_r[13];
          $reco = $sel_r[14];
          if($ob == ""){
            $ob = $sel_r[12];
          }
          if($reco == ""){
            $reco = $sel_r[15];
          }
          $sel_si_socios = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud where id_rol = 11 and tipo_adj_permiso = 2 and estado = 1 and id_item_pecc =".$sel_r[25]));
      }// FIN SI ES ADJUDICACION
      if($sel_si_socios[0]>0){//si tiene socios
          $tex_socios = "SI"; 
          $sel_fecha_aprob = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_si_socios[0]));
          if($sel_fecha_aprob[0]>0){
              if($sel_fecha_aprob[4] == 1 or $sel_fecha_aprob[4] == 4){
                  if($sel_r[23]==11){
                    $resultado_socios = "INFORMADO";
                  }else{
                    $resultado_socios = "APROBADO";
                  }
              }else{
                  if($sel_r[23]==11){
                    $resultado_socios = "NO INFORMADO - DEVUELTO AL PROFESIONAL";
                  }else{
                    $resultado_socios = "DEVUELTO AL PROFESIONAL";
                  }
              }
          }else{
              $resultado_socios = "SIN RESPUESTA";
          }
              $fecha_socios = $sel_fecha_aprob[3];
      }else{// si no tiene socios
          $tex_socios = "NO"; 
          $fecha_socios="N/A";
          $resultado_socios = "N/A";    
      }
        
      if($sel_r[9] == 1){
          if($sel_r[23]==11){
              $res_comi = "INFORMADO";
          }else{
              $res_comi = "APROBADO";
          }
      }else{
          if($sel_r[9] == 2){
              $res_comi = "PENDIENTE";
          }else{
              if($sel_r[23]==11){
                  $res_comi = "NO INFORMADO - DEVUELTO AL PROFESIONAL";
              }else{
                  $res_comi = "DEVUELTO AL PROFESIONAL";
              }
          }
      }
      if($sel_r[9] == 10){
          $res_comi="RECHAZADO";
      }
      $comple_texto="";
      if($sel_r[31]==1){
          $res_comi="DECLARADO DESIERTO";
          $comple_texto_tp_proceso="DECLARADO DESIERTO - ";
      }
      if($sel_r[29]==3){
          $res_comi="SIN ACCIONES";
      }
      if($sel_r[26] == 1){
          $text_tipo_solici = "SERVICIO";
      }else{
          $text_tipo_solici = "BIENES";
      }        
      $inicio_puntos=$inicio_puntos."<tr style='".$clase."'>";
      if ($sel_r[28] == 1){
          //$inicio_puntos=$inicio_puntos."EXTRAORDINARIO";
      }else{
          //$inicio_puntos=$inicio_puntos."NORMAL";
      }
      $inicio_puntos=$inicio_puntos."<td align='center' style='font-family: Arial;'><font font-size='8'>".$comple_texto_tp_proceso." ".$sel_r[5]."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>";
      if($result_info_pecc[0]==1){
          $inicio_puntos=$inicio_puntos."Ninguno";
      }
      if($result_info_pecc[0]>1){
          $inicio_puntos=$inicio_puntos.$result_info_pecc[0];
      }
      $inicio_puntos=$inicio_puntos."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>";
      if($result_info_pecc[1]!=""){
          $inicio_puntos=$inicio_puntos.saca_nombre_lista("t1_lineas_pecc",$result_info_pecc[1],"detalle","id");
      }
      $inicio_puntos=$inicio_puntos."</font></td>";
      /*if($result_info_pecc[2]==1){
          $inicio_puntos=$inicio_puntos."SI";
      } 
      if($result_info_pecc[2]==2){
          $inicio_puntos=$inicio_puntos."NO";
      }
      $inicio_puntos=$inicio_puntos."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>";
      if($result_info_pecc[3]!=""){
          $inicio_puntos=$inicio_puntos.$result_info_pecc[3];
      }*/
      $inicio_puntos=$inicio_puntos."<td align='center' style='font-family: Arial;'><font font-size='8'>".$text_tipo_solici."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$numero_consecut."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$res_comi."</font></td>";
      if($bloquea_ratificacion == ""){
          $inicio_puntos=$inicio_puntos."<td align='center' style='font-family: Arial;'><font font-size='8'>";
          if($sel_r["aplica_presidente"] == 1 and $sel_r[21] < 117 ){
              if($sel_r["presidente"]==1){
                  $inicio_puntos=$inicio_puntos."Verificado el ".$sel_r["presidente_fecha"];
              }else{
                  $inicio_puntos=$inicio_puntos."Aun no se ha verificado";
              }
          }else{
              $inicio_puntos=$inicio_puntos."No requiere";
          }
          $inicio_puntos=$inicio_puntos."</font></td>";
      }
      $inicio_puntos=$inicio_puntos."<td align='center' style='font-family: Arial;'><font font-size='8'>".$sel_r[10]."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$sel_r[11]."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$sel_r[22]."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$reco."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$tex_socios."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>";
      $contratista = "";
      $tiene_coma = "";
      $coma_contratista="";
      if($sel_r[23] == 4 or $sel_r[23] == 5 or $sel_r[23] == 11 or $sel_r[23] == 12){
          $sel_contr = query_db("select t1.consecutivo, t1.creacion_sistema, t1.apellido, t2.razon_social from t7_contratos_contrato as t1, t1_proveedor as t2 where t1.contratista = t2.t1_proveedor_id and t1.id = ".$sel_r[24]);
          while($sel_apl = traer_fila_db($sel_contr)){
              $numero_contrato1 = "C";      
              $separa_fecha_crea = explode("-",$sel_apl[1]);
              $ano_contra = $separa_fecha_crea[0];              
              $numero_contrato2 = substr($ano_contra,2,2);
              $numero_contrato3 = $sel_apl[0];
              $numero_contrato4 = $sel_apl[2];              
              $inicio_puntos=$inicio_puntos.numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_r[24]);
              $contratista=  $sel_apl[3];
          }
        
      }        
      if(($sel_r[23] == 1 or $sel_r[23] == 2 or $sel_r[23] == 3 or $sel_r[23] == 6) and $sel_r[4] ==2){ 
          $sel_contr_sql = query_db("select t1.consecutivo, t1.creacion_sistema, t1.apellido, t2.razon_social, t1.id from t7_contratos_contrato as t1, t1_proveedor as t2 where t1.contratista = t2.t1_proveedor_id and t1.id_item = ".$sel_r[25]);
          while($sel_contr = traer_fila_db($sel_contr_sql)){
              $numero_contrato1 = "C";      
              $separa_fecha_crea = explode("-",$sel_contr[1]);
              $ano_contra = $separa_fecha_crea[0];
              
              $numero_contrato2 = substr($ano_contra,2,2);
              $numero_contrato3 = $sel_contr[0];
              $numero_contrato4 = $sel_contr[2];
              if($tiene_coma <> ""){
                  $inicio_puntos=$inicio_puntos.$tiene_coma;
                  $coma_contratista = ", ";
              }else{
                  $tiene_coma = ", ";
              }
              $inicio_puntos=$inicio_puntos.numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_contr[4]);
              $contratista.=  $coma_contratista.$sel_contr[3];
          }
      }
      if($sel_r[23] == 7 or $sel_r[23] == 8){
          $inicio_puntos=$inicio_puntos.contratos_relacionados_solicitud_para_campos_solo_contratos($sel_r[25], "NO");
          $contratista=contratos_relacionados_solicitud_para_campos_solo_proveedores($sel_r[25], "NO");
      }
      $contratis_permi="";
      if(($sel_r[23] == 1 or $sel_r[23] == 2 or $sel_r[23] == 3 or $sel_r[23] == 6) and $sel_r[4] ==1){
          $contratistas_permiso = query_db("select t2.razon_social from t2_relacion_proveedor as t1, t1_proveedor as t2 where t1.id_item = ".$sel_r[25]." and t1.id_proveedor = t2.t1_proveedor_id");
          while ($sel_pro_permiso = traer_fila_db($contratistas_permiso)){
              $contratis_permi = $sel_pro_permiso[0]." - ".$contratis_permi;
          }
          if($contratis_permi == ""){
              $contratis_permi=$sel_r[32];
          }
      }
      $inicio_puntos=$inicio_puntos."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$contratista."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>";
     // $sel_valores_aprobados_en_comite = traer_fila_row(query_db("select valor_solicitado_usd, valor_solicitado_cop,  valor_solicitado_eq from    t3_comite_relacion_item where id_comite=".$sel_r[21]." and id_item=".$sel_r[25]));
     /* $valor_equivalente = ($valor_cop/1780) +($valor_usd);
      if($sel_valores_aprobados_en_comite[0]>0){
          $valor_usd = $sel_valores_aprobados_en_comite[0];
      }
      if($sel_valores_aprobados_en_comite[1]>0){
          $valor_cop = $sel_valores_aprobados_en_comite[1];
      }
      if($sel_valores_aprobados_en_comite[2]>0){
          $valor_equivalente = $sel_valores_aprobados_en_comite[2];
      }*/
      $inicio_puntos=$inicio_puntos.number_format($valor_usd, 0, ",",".")."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".number_format($valor_cop, 0, ",",".")."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>";
      $text_coment = "";
      $sel_comentarios_ind = query_db("select observacion,  id_asistente from  t3_comite_aprobacion where id_comite = ".$sel_r[21]." and id_item = ".$sel_r[25]." and observacion is not null and observacion <> ''");
      while($sel_coment = traer_fila_db($sel_comentarios_ind)){
          $sel_usuario_asistente = traer_fila_row(query_db("select t2.nombre_administrador from t3_comite_asistentes as t1, t1_us_usuarios as t2 where t1.id_asistente = ".$sel_coment[1]." and t1.id_us = t2.us_id"));
          $text_coment = $text_coment." [".$sel_usuario_asistente[0]." - ".$sel_coment[0]."]";
      }
      if($sel_r[20] <> "" and $sel_r[20] <> " " and $sel_r[20] <> " "){
          $text_coment = "[Secretario del Comite - ".$sel_r[20]."] ".$text_coment;
      }
      $inicio_puntos=$inicio_puntos.$text_coment;
      $inicio_puntos=$inicio_puntos."</font></td></tr>";
      $numero_contrato="";
  }
  $inicio_puntos=$inicio_puntos."</table>";
    /******* FIN BUSCA LOS PUNTOS DEL COMITE *********************************/
    //ÉSTAS LÍNEAS DE AQUÍ PARA ABAJO SE DEBEN COLOCAR DONDE SE CIERRE EL COMITÉ
    $para_actualiza = query_db($query_item);// NUMERO, FECHA, TIPO DE COMITE
    while($s_actual = traer_fila_db($para_actualiza)){
        if($num_comite==""){
            $num_comite=numero_item_pecc($s_actual[2],$s_actual[3],$s_actual[4]);
        }
        if($fecha_comite==""){
            $fecha_comite=$s_actual[1];
        }
        if($tipo_comite==""){
            if($s_actual[6]==1){
                $tipo_comite="Extraordinario";
            }else{
                $tipo_comite="Normal";
            }
            
        }
    }
    $asunto="RESULTADO COMITE DE CONTRATOS NUMERO ".$num_comite." DE FECHA ".$fecha_comite;
    $inicio_tabla=str_replace('<-numero_comite->', $num_comite, $inicio_tabla);
    $inicio_tabla=str_replace('<-fecha_comite->', $fecha_comite, $inicio_tabla);
    $inicio_tabla=str_replace('<-tipo_comite->', $tipo_comite, $inicio_tabla);    
    $inicio_puntos=$inicio_puntos.$puntos."</table>";
    $inicio_tabla=$inicio_tabla.$inicio_puntos.$fin_tabla;
    $correos_solicitante=""; $correos_comprador="";
    $nombres_solicitante=""; $nombres_comprador="";
    $para_actualiza = query_db($query_item);// PROFESIONALES Y SOLICITANTES
    $id_us_envio = "0";
    while($s_actual = traer_fila_db($para_actualiza)){
        $query_solicitante="SELECT t.nombre_administrador, t.email, t.us_id FROM $g1 AS t, t2_item_pecc AS p WHERE p.id_us=t.us_id AND p.id_item=$s_actual[11]";
        $solicitante = traer_fila_db(query_db($query_solicitante));
        $id_us_envio.=",".$solicitante[2];
        $query_comprador="SELECT t.nombre_administrador, t.email, t.us_id FROM $g1 AS t, t2_item_pecc AS p WHERE p.id_us_profesional_asignado=t.us_id AND p.id_item=$s_actual[11]";
        $comprador = traer_fila_db(query_db($query_comprador));
        $id_us_envio.=",".$comprador[2];
                
    }
/*    $para_actualiza = query_db($query_user);// SE BUSCA A LOS APROBADORES PARA ENVIAR EMAIL
    $correos="";
    $nombres="";
    while($s_actual = traer_fila_db($para_actualiza)){
        $correos=$correos.$s_actual[9]."<br>";
        $nombres=$nombres.$s_actual[8]."<br>";
        $id_us_envio.=",".$s_actual[11];
        //$correos=$correos.$s_actual[8]."<br>";
        //$nombres=$nombres.$s_actual[9]."<br>";
    }*/
    $query_comite="SELECT t.nombre_administrador, t.email, t.us_id FROM $g1 AS t, $ts6 AS r WHERE r.id_usuario=t.us_id AND id_rol_general=6";
    $para_actualiza = query_db($query_comite);// SE BUSCA A LOS USUARIOS CON ROL DE COMITE
    $correos_comite="";
    $nombres_comite="";
    while($s_actual = traer_fila_db($para_actualiza)){
        $correos_comite=$correos_comite.$s_actual[1]."<br>";
        $nombres_comite=$nombres_comite.$s_actual[0]."<br>";
        $id_us_envio.=",".$s_actual[2];
    }
    /*$inicio_tabla=$inicio_tabla."<br><br>SOLICITANTES: <br>".$correos_solicitante.$nombres_solicitante."<br><br>COMPRADORES: <br>".$correos_comprador.$nombres_comprador."<br><br>ASISTENTES: <br>".$correos.$nombres."<br><br>ROLES COMITE: <br>".$correos_comite.$nombres_comite;
    //$inicio_puntos=$inicio_puntos.$puntos."</table>";
    sent_mail('jeison.rivera@enternova.net',$asunto,$inicio_tabla);
    sent_mail('abastecimiento@hcl.com.co',$asunto,$inicio_tabla);*/
//    echo $inicio_tabla;
		echo $inicio_tabla;
    sent_mail('pasa_id_us*'.$id_us_envio,$asunto,$inicio_tabla);
/***************** PARA EL DES-002-17*****************************/

		
        
    } else {//FIN SI NO HAY PENDIENTES
		$msg_error = "No se Puede Finalizar este Comit-ampersan-eacute;";
		if($sele_item_pendientes[0] > 0){
			$msg_error.= "* Algunas solicitudes no tienen las firmas completas.";
			
		}
		if($selec_comite[10] != 2){
			$msg_error.= "* En el men-ampersan-uacute; agregar solicitudes, est-ampersan-aacute; activa la opci-ampersan-oacute;n de seguir agregando";
			
		}
			
			
		if($query_falta_descarga_comflicto[0] >0){
			$msg_error.= "* Revise el conflicto de intereses en todas las solicitudes";
			
		}
		
        ?><script>
				 window.parent.muestra_alerta_error_solo_texto('', 'Error', '<?=utf8_encode($msg_error)?>', 40, 5, 12)
				//alert("ALERTA! No se puede finalizar por que algunas solicitudes no tienen las firmas completas,\n O Aun esta agregando solicitudes a este comite")
</script>
        <?php
    }

    /* FIN FINALIZACION DEL COMITE */
}
?>
<?php



if ($_POST["accion"] == "no_verifica_comite_presidente") {

    $id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
    $id_item_agrega = $_POST["id_item_agrega"];
    $update = query_db("update $c2 set comentario_presidente  ='".$_POST["comentario_verifica_presidente_".$id_item_agrega]."', presidente=3 where id_comite = $id_comite and id_item = $id_item_agrega");

	$sel_profesional = traer_fila_row(query_db("select t2.nombre_administrador, t2.email, t1.num1, t1.num2, t1.num3 from t2_item_pecc as t1, t1_us_usuarios as t2 where t1.id_us_profesional_asignado = t2.us_id and t1.id_item = ".$id_item_agrega));
	$sel_num_comite = traer_fila_row(query_db("select num1, num2, num3 from t3_comite where id_comite = ".$id_comite));

	$num_comite = numero_item_pecc($sel_num_comite[0],$sel_num_comite[1],$sel_num_comite[2]);	
	$num_item = numero_item_pecc($sel_profesional[2],$sel_profesional[3],$sel_profesional[4]);
	
	$cuerpo = "Buen Dia, ".$sel_profesional[0]."<br /><br />El presidente a decidido NO verificar la solicitud ".$num_item." que se encuentra a su cargo y se presento en el comi&eacute; ".$num_comite."<br /><br />La observaci&oacute;n que dejo el presidente fue: ".$_POST["comentario_verifica_presidente_".$id_item_agrega]."<br /><br />Por favor para aclarar el punto no responda este correo debido a que este es un correo automatico de SGPA y nadie lo leer&aacute;, para aclararlo por favor comun&iacute;quese con el presidente directamente.";

	$correo_destino=$sel_profesional[1];
	$nombre_destino = $sel_profesional[0];
	$asunto_msn="SGPA No verificacion del presidente ".$consecutivo_imp ;
		
 echo $asunto_msn."<br>".$correo_destino."<br>".$cuerpo;

		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPAuth = false; 
		$mail->SMTPSecure = "";
		$mail->Port       = 25; 
		
		$mail->Username = $correo_autentica_phpmailer; 
		$mail->Password = $contrasena_autentica_phpmailer; 
		$mail->Host = $servidor_phpmailer;
		$mail->From = $correo_from_phpmiler;
		$mail->FromName = $nombre_from_phpmiler;
		
		
		$mail->Subject = $asunto_msn;
		$mail->AddAddress($correo_destino,$nombre_destino);
		//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
		//$mail->AddCC("ferney.sterling@enternova.net");
		$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
		//$mail->AddBCC($correo_dvrnet2);//copia oculta
		//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
		//$mail->AddAttachment("files/demo.zip", "demo.zip");
		$mail->Body = $cuerpo;
		$mail->AltBody = "SGPA Informaciones";
		$mail->Send();

	?>
	<script>
    window.parent.document.getElementById('no_verificado_<?=$id_item_agrega?>').innerHTML = 'Solicitud NO Verificada';
    </script>
	<?

    
}
if ($_POST["accion"] == "verifica_comite_presidente") {

    $id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
    $id_item_agrega = $_POST["id_item_agrega"];
    $vcomite = traer_fila_db(query_db("select num2,permiso_o_adjudica from $vcomite2 where id_comite = $id_comite and id_item = $id_item_agrega"));
	
    // Se cambia estado del presidente = 1, para indicar que la solicitud(item) fue verificada
    $update = query_db("update $c2 set presidente = 1, comentario_presidente  ='".$_POST["comentario_verifica_presidente_".$id_item_agrega]."' where id_comite = $id_comite and id_item = $id_item_agrega");
/*
    $total_item = query_db("select id_item from $c2 where id_comite = $id_comite ");
    $sum_valor = 0;
    while ($t_item = traer_fila_db($total_item)) {
	
	$sel_permiso_ad=traer_fila_row(query_db("select permiso_o_adjudica from t3_comite_relacion_item where id_comite=$id_comite and  id_item =". $t_item[0]));
    $permiso_ad=$sel_permiso_ad[0];
	
    echo "select sum(valor_cop), sum(valor_usd) from $pi8 where t2_item_pecc_id = " . $t_item[0]. " and permiso_o_adjudica = ".$permiso_ad."<br /><br />";
        // Se hace la consulta del presupuesto segun el item a verificar en estado de adjudicacion.
		 $sel_presupuesto = traer_fila_row(query_db("select sum(valor_cop), sum(valor_usd) from $pi8 where t2_item_pecc_id = " . $t_item[0] . " and permiso_o_adjudica = ".$permiso_ad ));

            
                $val_usd = ($sel_presupuesto[0] / trm_presupuestal($vcomite[2])) + $sel_presupuesto[1];
            
			
       
        if ($val_usd >= MONTO_COMITE) {
            $sum_valor++;
        }
    }

    $total_item_presidente = traer_fila_row(query_db("select count(*) from $c2 where id_comite = $id_comite and presidente = 1 "));
echo $sum_valor;
    // Si el numero de solicitudes con valor mayor a MONTO_COMITE es igual a numero de solicitudes con presidente = 1 se procede a verificar todo el comite.
    if ($sum_valor == $total_item_presidente[0]) {
        echo "Comite Verificado";
        $update = query_db("update $c1 set presidente_fecha = '$fecha', presidente = 1 where id_comite=" . $id_comite);
		?><script> alert("Ya termino la verificacion del comite")</script><?
    } else {
        echo "Solicitud Verificada";
    }
	
	*/
	
	$total_item_presidente = traer_fila_row(query_db("select count(*) from $c2 where id_comite = $id_comite and aplica_presidente = 1 "));
	$total_item_verificados = traer_fila_row(query_db("select count(*) from $c2 where id_comite = $id_comite and presidente = 1 "));
echo $sum_valor;
    // Si el numero de solicitudes con valor mayor a MONTO_COMITE es igual a numero de solicitudes con presidente = 1 se procede a verificar todo el comite.
    if ($total_item_verificados[0] == $total_item_presidente[0]) {
        $update = query_db("update $c1 set presidente_fecha = '$fecha', presidente = 1 where id_comite=" . $id_comite);
		?>
    <script>alert("YA TERMINO DE VERIFICAR EL COMITE")</script>
    <?php
    } else {
        echo "Solicitud Verificada";
    }
	
	$selct_comentario = traer_fila_row(query_db("select comentario_presidente from $c2 where id_comite = $id_comite and id_item = $id_item_agrega"));
    ?>
    <script>
       
	   window.parent.document.getElementById('verificaion_presidente_<?=$id_item_agrega?>').innerHTML = 'Solicitud Verificada';
	  // window.parent.document.getElementById('comentario_presidente_<?=$id_item_agrega?>').innerHTML = '<?=$selct_comentario[0]?>';
	   // window.parent.ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite=< ?= $id_comite ?>', 'contenidos');
    </script>
    <?php
}
?>
<?


if($_POST["accion"]=="edita_comite_info_gen"){
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
/**** PARA EL INCIDENTE DE APERTURA SIN VALIDAR CONFLICTOS DE INTERÉS  ****/
if($_POST["estado_comite_abre_cierra"]==3){//CUANDO SE ABRE A LOS ASISTENTES PARA LA APROBACIÓN
    
	$query_falta_descarga_comflicto=traer_fila_row(query_db("SELECT count(*) FROM t3_comite_relacion_item WHERE id_comite=".$id_comite.""));//revisa que todas las solicitudes tengan revisados los conflictos de interes.
    if($query_falta_descarga_comflicto[0] == 0){
        ?>
            <script>
                window.parent.muestra_alerta_error_solo_texto('', 'Error', '<?=utf8_encode("* Debe relacionar por lo menos una solicitud antes de enviar el e-mail")?>', 40, 5, 12);
                window.parent.ajax_carga('../aplicaciones/comite/edicion-comite.php?id_comite=<?= $id_comite ?>', 'contenidos');
            </script>
        <?
        exit();
    }
	
	$query_falta_descarga_comflicto=traer_fila_row(query_db("SELECT count(*) FROM t3_comite_relacion_item WHERE id_comite=".$id_comite." and (descarga_archivo_conflicto != 1 or revisa_archivo_conflicto != 2)"));//revisa que todas las solicitudes tengan revisados los conflictos de interes.
    if($query_falta_descarga_comflicto[0] >0){
        ?>
            <script>
                window.parent.muestra_alerta_error_solo_texto('', 'Error', '<?=utf8_encode("* Revise el conflicto de intereses en todas las solicitudes")?>', 40, 5, 12);
                window.parent.ajax_carga('../aplicaciones/comite/edicion-comite.php?id_comite=<?= $id_comite ?>', 'contenidos');
            </script>
        <?
        exit();
    }
	$query_falta_asistentes=traer_fila_row(query_db("SELECT count(*) FROM t3_comite_asistentes WHERE id_comite=".$id_comite." and requiere_aprobacion = 1 and estado = 1"));//revisa que todas las solicitudes tengan revisados los conflictos de interes.
    if($query_falta_asistentes[0] <4){
        ?>
            <script>
                window.parent.muestra_alerta_error_solo_texto('', 'Error', '<?=utf8_encode("* Debe seleccionar por lo menos 4 asistentes aprobadores")?>', 40, 5, 12);
                window.parent.ajax_carga('../aplicaciones/comite/edicion-comite.php?id_comite=<?= $id_comite ?>', 'contenidos');
            </script>
        <?
        exit();
    }
	
	
}
/**** PARA EL INCIDENTE DE APERTURA SIN VALIDAR CONFLICTOS DE INTERÉS  ****/
$update = query_db("update $c1 set estado = ".$_POST["estado_comite_abre_cierra"].",fecha='".$_POST["fecha_comite"]."', tipo_comite='".$_POST["tipo_comite_virtual_presencial"]."', presidente_fecha = '$fecha', presidente = '".$_POST["presidente"]."', tipo_comite_extraordinario = '".$_POST["extra_comite"]."', lugar = '".$_POST["lugar_comite"]."', hora= '".$_POST["hora_i"].":".$_POST["minuto_i"].":".$_POST["formato_i"]."' where id_comite=".$id_comite );
/***************** PARA EL DES-002-17*****************************/
if($_POST["estado_comite_abre_cierra"]==3){//CUANDO SE ABRE A LOS ASISTENTES PARA LA APROBACIÓN
    $num_comite=""; $fecha_comite=""; $tipo_comite=""; $asunto="";
    $inicio_tabla="<span style='font-size:14px; font-family: Arial;'>Apreciados miembros de comit&eacute; de contratos<br><br>A continuaci&oacute;n relaciono las solicitudes que ser&aacute;n presentadas en el comit&eacute; <-numero_comite-> en <-lugar-> de fecha y hora <-fecha_comite-> <-hora->.<br>Gerentes de Contrato y Profesionales / Compradores de Abastecimiento: por favor estar pendientes al momento de ser llamados para presentar los solicitudes.<br><br>";
    $puntos="";

    $inicio_puntos="<table width='99%' border='1' cellpadding='2' cellspacing='2' style='margin:1px; border-bottom: #cccccc 3px double; border-right: #cccccc 3px  double; border-top: #cccccc 1px solid; border-left: #cccccc 1px solid;  border-spacing:2px; overflow:scroll; font-size:12px; font-family: Arial;'><tr><td colspan='8' align='center'  style='background:#005395; color:#FFFFFF; '>Lista de las Solicitudes Relacionadas a este Comit&eacute;</td></tr><tr ><td width='8%' align='center' style='background:#005395; color:#FFFFFF; font-family: Arial;'><font >N&uacute;mero de la Solicitud</font></td><td width='10%' align='center' style='background:#005395; color:#FFFFFF; font-family: Arial;'><font >Solicitante</font></td><td width='11%' align='center' style='background:#005395; color:#FFFFFF; font-family: Arial;'><font >&Aacute;rea</font></td><td width='9%' align='center' style='background:#005395; color:#FFFFFF; font-family: Arial;'><font >Tipo de Proceso</font></td><td width='23%' align='center' style='background:#005395; color:#FFFFFF; font-family: Arial;'><font >Objeto Solicitud</font></td><td width='11%' align='center' style='background:#005395; color:#FFFFFF; font-family: Arial;'><font >Valor Origen COP$</font></td><td width='11%' align='center' style='background:#005395; color:#FFFFFF; font-family: Arial;'><font >Valor Origen USD$</font></td><td align='center' style='background:#005395; color:#FFFFFF; font-family: Arial;'><font >Orden</font></td></tr>";

    $fin_tabla="<br>Cordial saludo:<br>Secretario del comit&eacute;.<br><br></span>";
    $query_item="select $c1.id_comite, $c1.fecha, $c1.num1 AS num1_comite, $c1.num2 AS num2_comite, $c1.num3 AS num3_comite, $c1.tipo_comite, $c1.tipo_comite_extraordinario, $c2.estado AS estado_item, $pi2.num1 AS num1_item, $pi2.num2 AS num2_item, $pi2.num3 AS num3_item, $c2.id_item FROM $c2 INNER JOIN $c1 ON $c2.id_comite = $c1.id_comite INNER JOIN $pi2 ON $c2.id_item = $pi2.id_item WHERE $c1.id_comite=$id_comite";
    
	$query_user="select $c1.id_comite, $c1.fecha, $c1.num1, $c1.num2, $c1.num3, $c1.tipo_comite, $c1.tipo_comite_extraordinario, $c3.rol_aprobacion, $g1.nombre_administrador, $g1.email, $c3.estado, $g1.us_id FROM $g1 INNER JOIN $c1 INNER JOIN $c3 ON $c1.id_comite = $c3.id_comite ON $g1.us_id = $c3.id_us WHERE $c1.id_comite=$id_comite";
    /*******INICIO BUSCA LOS PUNTOS DEL COMITE *********************************/
    $cont=0;
    $sel_item_sin_comite = query_db("SELECT * from $vcomite2 where id_comite = " . $id_comite . " and estado <> 3 order by orden asc");
    $lugar_hora = traer_fila_db(query_db("SELECT lugar, hora from $c1 where id_comite = " . $id_comite));
    while ($sel_sin_comi = traer_fila_db($sel_item_sin_comite)) {//INICIO WHILE
        if($cont == 0){
            $clase= "background:#DBFBDC";
            $cont = 1;
          }else{
            $clase= "";
            $cont = 0;
          }
        $sel_item = traer_fila_row(query_db("select id_item,objeto_solicitud, estado, ob_solicitud_adjudica,t1_tipo_proceso_id, es_modificacion from $pi2 where id_item=" . $sel_sin_comi[0]));
        $sele_nivel_anterior = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3  where id_item=" . $sel_item[0] . " and actividad_estado_id < 7 and  estado = 1"));
        $sele_datos_actividad = traer_fila_row(query_db("select fecha_real from $vpeec3  where id_item=" . $sel_item[0] . " and actividad_estado_id = " . $sele_nivel_anterior[0] . " and  estado = 1"));
        
        $id_tipo_proceso_pecc = 1;
        if($sel_item[3] == 7){
                $id_tipo_proceso_pecc = 2;
            }
        if($sel_item[3] == 8){
                $id_tipo_proceso_pecc = 3;
            }
        if($sel_item[2] == 8){
        $permiso_o_adjudica = 1;
        }
        if($sel_item[2] == 17){
        $permiso_o_adjudica = 2;
        }
        if($sel_item[4] == 12){
        $permiso_o_adjudica = 1;
        }
        $puntos=$puntos."<tr style='".$clase."'><td align='center' style='font-family: Arial;'><font font-size='8'> <strong>".numero_item_pecc($sel_sin_comi[3], $sel_sin_comi[4], $sel_sin_comi[5])."</strong></font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$sel_sin_comi[14]."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".$sel_sin_comi[13];
        $puntos=$puntos."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>";
        if ($sel_item[2] == 8) {
        //    echo "Permiso";
            $permi_ad = 1;
        } else {
          //  echo "Adjudicaci&oacute;n";
            $permi_ad = 2;
        }
        if($sel_item[5]==1){ $puntos=$puntos."Modificaci&oacute;n";} else{
            $puntos=$puntos.saca_nombre_lista($g13,$sel_item[4],'nombre','t1_tipo_proceso_id',$sel_item[0]);
        }
        $complemento_reclasificaicon="";
        if($sel_item[4] == 12){
            $complemento_reclasificaicon = " and al_valor_inicial_para_marco is null";  
            $permi_ad=1;
        }
		
      //  $sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from t2_presupuesto where t2_item_pecc_id = " . $sel_sin_comi[0] . " and permiso_o_adjudica = $permi_ad ".$complemento_reclasificaicon));
		
			$valor_solicitud = explode("---",valor_solicitud($sel_item[0], $permiso_o_adjudica));
		
       /* if($sel_sin_comi[4]==""){
            $trm_item=trm_presupuestal(2015); 
        }else{
            $trm_item=trm_presupuestal($sel_sin_comi[4]);
        }*/
        
		
        $puntos=$puntos."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>";
        if($sel_item[3] != "" and $sel_item[3] != " " and $sel_item[3] != "  " and $sel_item[3] != "	"){
            $puntos=$puntos.$sel_item[3];
        }else  {
            $puntos=$puntos.$sel_item[1];
        }
        $puntos=$puntos."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".number_format($valor_solicitud[1], 0)."</font></td><td align='center' style='font-family: Arial;'><font font-size='8'>".number_format($valor_solicitud[0], 0)."</font></td><td width='7%' align='center'>".$sel_sin_comi[8]."</font></td></tr>";
        
    }//FIN DEL WHILE
    /*******FIN BUSCA LOS PUNTOS DEL COMITE *********************************/

    $para_actualiza = query_db($query_item);// NUMERO, FECHA, TIPO DE COMITE
    while($s_actual = traer_fila_db($para_actualiza)){
        if($num_comite==""){
            $num_comite=numero_item_pecc($s_actual[2],$s_actual[3],$s_actual[4]);
        }
        if($fecha_comite==""){
            $fecha_comite=$s_actual[1];
        }
        if($tipo_comite==""){
            if($s_actual[6]==1){
                $tipo_comite="Extraordinario";
            }else{
                $tipo_comite="Normal";
            }
            
        }
    }
	$id_us_envio = "0";
    $asunto="COMITE DE CONTRATOS NUMERO ".$num_comite." DE FECHA ".$fecha_comite;
    $inicio_tabla=str_replace('<-numero_comite->', $num_comite, $inicio_tabla);
    $inicio_tabla=str_replace('<-fecha_comite->', $fecha_comite, $inicio_tabla);
    $inicio_tabla=str_replace('<-tipo_comite->', $tipo_comite, $inicio_tabla);
    $inicio_tabla=str_replace('<-lugar->', $lugar_hora[0], $inicio_tabla);  
    $inicio_tabla=str_replace('<-hora->', $lugar_hora[1], $inicio_tabla);      
    $inicio_puntos=$inicio_puntos.$puntos."</table>";
    $inicio_tabla=$inicio_tabla.$inicio_puntos.$fin_tabla;
    $correos_solicitante=""; $correos_comprador="";
    $nombres_solicitante=""; $nombres_comprador="";
    $para_actualiza = query_db($query_item);// PROFESIONALES Y SOLICITANTES
    while($s_actual = traer_fila_db($para_actualiza)){
        $query_solicitante="SELECT t.nombre_administrador, t.email, t.us_id FROM $g1 AS t, t2_item_pecc AS p WHERE p.id_us=t.us_id AND p.id_item=$s_actual[11]";
        $solicitante = traer_fila_db(query_db($query_solicitante));
        $correos_solicitante=$correos_solicitante.$solicitante[1]."<br>";
        $nombres_solicitante=$nombres_solicitante.$solicitante[0]."<br>";
       // sent_mail(''.$solicitante[1],$asunto.", ".$solicitante[0],$inicio_tabla);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A LOS ASITENTES REALCIONADOS
	   $id_us_envio.=",".$solicitante[2];

        $query_comprador="SELECT t.nombre_administrador, t.email, t.us_id FROM $g1 AS t, t2_item_pecc AS p WHERE p.id_us_profesional_asignado=t.us_id AND p.id_item=$s_actual[11]";
        $comprador = traer_fila_db(query_db($query_comprador));
        $correos_comprador=$correos_comprador.$comprador[1]."<br>";
        $nombres_comprador=$nombres_comprador.$comprador[0]."<br>";
        //sent_mail(''.$comprador[1],$asunto.", ".$comprador[0],$inicio_tabla);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A LOS ASITENTES REALCIONADOS
		$id_us_envio.=",".$comprador[2];
    }
    $para_actualiza = query_db($query_user);// SE BUSCA A LOS APROBADORES PARA ENVIAR EMAIL
    $correos="";
    $nombres="";
    while($s_actual = traer_fila_db($para_actualiza)){//asistentes al comite.
        $correos=$correos.$s_actual[9]."<br>";
        $nombres=$nombres.$s_actual[8]."<br>";
       // sent_mail(''.$s_actual[9],$asunto.", ".$s_actual[8],$inicio_tabla);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A LOS ASITENTES REALCIONADOS
        //$correos=$correos.$s_actual[8]."<br>";
        //$nombres=$nombres.$s_actual[9]."<br>";
		$id_us_envio.=",".$s_actual[11];
    }
    $query_comite="SELECT t.nombre_administrador, t.email, t.us_id  FROM $g1 AS t, $ts6 AS r WHERE r.id_usuario=t.us_id AND id_rol_general=6";
    $para_actualiza = query_db($query_comite);// SE BUSCA A LOS USUARIOS CON ROL DE COMITE
    $correos_comite="";
    $nombres_comite="";
    while($s_actual = traer_fila_db($para_actualiza)){
        $correos_comite=$correos_comite.$s_actual[1]."<br>";
        $nombres_comite=$nombres_comite.$s_actual[0]."<br>";
        //sent_mail(''.$s_actual[1],$asunto.", ".$s_actual[0],$inicio_tabla);//DESCOMENTARIAR PARA QUE SALGA EL CORREO A LOS ASITENTES REALCIONADOS
		$id_us_envio.=",".$s_actual[2];
    }
   // $inicio_tabla=$inicio_tabla."<br><br>SOLICITANTES: <br>".$correos_solicitante.$nombres_solicitante."<br><br>COMPRADORES: <br>".$correos_comprador.$nombres_comprador."<br><br>ASISTENTES: <br>".$correos.$nombres."<br><br>ROLES COMITE: <br>".$correos_comite.$nombres_comite;
    //$inicio_puntos=$inicio_puntos.$puntos."</table>";
    //sent_mail('jeison.rivera@enternova.net',$asunto,$inicio_tabla);
//    echo $inicio_tabla;
	
	echo $inicio_tabla;
    sent_mail('pasa_id_us*'.$id_us_envio,$asunto,$inicio_tabla);
}
/***************** PARA EL DES-002-17*****************************/
if($_POST["estado_comite_abre_cierra"] == 3){//envia los email



}
?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/edicion-comite.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?

}


if($_POST["accion"]=="agrega_o_no_mas_item"){
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
$update = query_db("update $c1 set permitir_agregar_item = ".$_POST["agregar_mas_items"]." where id_comite=".$id_comite );


?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/agrega-items.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?

}
if($_POST["accion"]=="quita_asistente"){
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));


$insert = query_db("delete from  $c3 where id_asistente=".$_POST["quita_asistente"]);			
$para_actualiza = query_db("select * from $c3 where id_comite = ".$rol_comite." and estado = 1 and requiere_aprobacion = 1 order by orden asc");
$num = 0;
while($s_actual = traer_fila_db($para_actualiza)){
$num = $num +1;
$updat = query_db("update $c3 set orden = ".$num." where id_asistente = ".$s_actual[0]);
}

?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/asistentes.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="agrega_asistente"){
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
$rol_comite = arreglo_recibe_variables($_POST["rol_comite"]);
$orden_aprueba = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["orden_aprueba"])))+0;
$explode = explode("----,",$_POST["usuario_permiso"]);
$id_usuario = $explode[1];
$sel_si_ya_esta = traer_fila_row(query_db("select * from $c3 where id_comite = ".$id_comite." and id_us = ".$id_usuario." and estado = 1"));

if($_POST["requiere_aprobacion"] == 2){
$rol_comite = "Asistente";
}

if($_POST["requiere_aprobacion"] == 99){
$rol_comite = "Secretario del Comit&eacute;";
}



if($sel_si_ya_esta[0] > 0){
?><script> alert("Este Usuario ya esta en la lista de asistentes")</script><?	
exit;
}else{
$insert = "insert into $c3 (id_comite,requiere_aprobacion,rol_aprobacion,orden,estado,id_us) values (".$id_comite.",".$_POST["requiere_aprobacion"].",'".$rol_comite."',".$orden_aprueba.",1,".$id_usuario.")";
$sql_ex=query_db($insert.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

}	
$para_actualiza = query_db("select * from $c3 where id_comite = ".$id_comite." and estado = 1 and requiere_aprobacion = 1 and id_asistente <> ".$id_ingreso." order by orden asc");

if($orden_aprueba == 1){
$num = 1;	
}else{
$num = 10;
}
while($s_actual = traer_fila_db($para_actualiza)){
$num = $num +1;
$updat = query_db("update $c3 set orden = ".$num." where id_asistente = ".$s_actual[0]);
}

?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/asistentes.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?

$query="update $c2 SET descarga_archivo_conflicto=3, revisa_archivo_conflicto=3 WHERE id_comite=$id_comite";
$result=query_db($query);
}
if($_POST["accion"]=="cambia_orden_asistente"){
$id_relacion = elimina_comillas(arreglo_recibe_variables($_POST["id_relacion"]));
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
$orden_cambia = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["orden_cambia"])));



$insert = query_db("update $c3 set orden=".$orden_cambia." where id_asistente=".$id_relacion);
//
$para_actualiza = query_db("select * from $c3 where id_comite = ".$id_comite." and estado = 1 and requiere_aprobacion = 1 and id_asistente <> ".$id_relacion." order by orden asc");

if($orden_cambia == 1){
$num = 1;	
}else{
$num = 0;
}
while($s_actual = traer_fila_db($para_actualiza)){
$num = $num +1;
$updat = query_db("update $c3 set orden = ".$num." where id_asistente = ".$s_actual[0]);
}



?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/asistentes.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?
}
if($_POST["accion"]=="cambia_orden_comite"){
$id_relacion = elimina_comillas(arreglo_recibe_variables($_POST["id_relacion"]));
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
$id_item_orden_cambia = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["orden_cambia"])));

$numero_orden = $_POST["orden_ordena_".$id_item_orden_cambia];

$sel_item_sin_comite = query_db("SELECT id_item,id_relacion from $vcomite2 where id_comite = ".$id_comite." and id_item <> $id_item_orden_cambia and estado <> 3 order by orden asc");
$num  =1;

$sele_item_orden = traer_fila_row(query_db("SELECT id_relacion from $vcomite2 where id_comite = ".$id_comite." and id_item = $orden_cambia and estado <> 3 order by orden asc"));
$insert = query_db("update $c2 set orden=".$numero_orden." where id_relacion=".$sele_item_orden[0]);

while($sel_sin_comi = traer_fila_db($sel_item_sin_comite)){


if($numero_orden == $num){
$num = $num +1;	
}
echo $numero_orden." - ".$num."<br />";
$insert = query_db("update $c2 set orden=".$num." where id_relacion=".$sel_sin_comi[1]);

$num = $num +1;
}





?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/organiza-items.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?
}
if($_POST["accion"]=="quita_comite"){

$id_item_agrega = elimina_comillas(arreglo_recibe_variables($_POST["id_item_agrega"]));
$comite_coment = arreglo_recibe_variables($_POST["comite_coment"]);


$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));
$insert = query_db("delete from $c2 where id_item=".$id_item_agrega." and id_comite = ".$id_comite."");
//
$selecciona = query_db("select * from $c2 where id_comite = ".$id_comite." order by orden asc");
$comienza = 0;
while($sel = traer_fila_db($selecciona)){
$comienza = $comienza+1;
$upda = query_db("update $c2 set orden =".$comienza." where id_relacion = ".$sel[0]);
}

/* Script para guardar registro de eliminar relacion comite, comentario, fecha y hora*/
$query="insert into $c5 (id_comite, id_item, comentario, fecha_creacion) values ($id_comite, $id_item_agrega, '$comite_coment', '$fecha $hora')";
$insert = query_db($query);
?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/organiza-items.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="agrega_comite_item_todos"){
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));

	                             
 $sel_item_sin_comite = query_db("SELECT * from $vcomite1 where (congelado = 2 or congelado is null) $completar_filtros order by fecha_ultima_firma asc");
$id_log_presupuesto = log_de_procesos_sgpa(3, 90, 0, $id_comite, 0, 0);//agrega valores
	log_agrega_detalle ($id_log_presupuesto, "Comité",$id_comite , "t3_comite",1);
 while($sel_sin_comi = traer_fila_db($sel_item_sin_comite)){
	 
	 /*verifica si la solicitud ya se encuentra relacionado en un comite*/
                    $select_si_ya_esta = traer_fila_row(query_db("select count(*) from t3_comite_relacion_item where id_comite = ".$id_comite." and  id_item = ".$sel_sin_comi[0]));
					$select_si_ya_esta_en_otro_comite = traer_fila_row(query_db("select count(*) from t3_comite_relacion_item as t1, t3_comite as t2 where t1.id_item = ".$sel_sin_comi[0]." and t1.id_comite = t2.id_comite and t2.estado <> 1 "));
	/*FIN verifica si la solicitud ya se encuentra relacionado en un comite*/
if($select_si_ya_esta[0]==0 and $select_si_ya_esta_en_otro_comite[0]==0)
                    {
$id_item_agrega = $sel_sin_comi[0];

$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_agrega));
if($sel_item[14] == 8){
$permiso_o_adjudica = 1;
}
if($sel_item[14] == 17){
$permiso_o_adjudica = 2;
}
$selecciona = query_db("select * from $c2 where id_comite = ".$id_comite." order by orden asc");
$comienza = 0;
while($sel = traer_fila_db($selecciona)){
$comienza = $comienza+1;
$upda = query_db("update $c2 set orden =".$comienza." where id_relacion = ".$sel[0]);
}
$comienza = $comienza+1;
$insert = query_db("insert into $c2 (id_comite,id_item,estado, orden, permiso_o_adjudica, descarga_archivo_conflicto, revisa_archivo_conflicto) values (".$id_comite.",".$id_item_agrega.",2,".$comienza.", ".$permiso_o_adjudica.", 3, 3)");
//$query="update $c2 SET descarga_archivo_conflicto=0, revisa_archivo_conflicto=0 WHERE id_comite=$id_comite";
//$result=query_db($query);
	 
	
	
	log_agrega_detalle ($id_log_presupuesto, "Solicitud",$id_item_agrega , "t2_item_pecc",2);
	}
}
?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/organiza-items.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="agrega_comite_item"){
$id_item_agrega = elimina_comillas(arreglo_recibe_variables($_POST["id_item_agrega"]));
$id_comite_agrega = elimina_comillas(arreglo_recibe_variables($_POST["id_comite_agrega"]));
$id_comite = elimina_comillas(arreglo_recibe_variables($_POST["id_comite"]));

$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_agrega));

if($sel_item[14] == 8){
$permiso_o_adjudica = 1;
}
if($sel_item[14] == 17){
$permiso_o_adjudica = 2;
}


//
$selecciona = query_db("select * from $c2 where id_comite = ".$id_comite." order by orden asc");
$comienza = 0;

while($sel = traer_fila_db($selecciona)){
$comienza = $comienza+1;

$upda = query_db("update $c2 set orden =".$comienza." where id_relacion = ".$sel[0]);
}
$comienza = $comienza+1;
$insert = query_db("insert into $c2 (id_comite,id_item,estado, orden, permiso_o_adjudica, descarga_archivo_conflicto, revisa_archivo_conflicto) values (".$id_comite_agrega.",".$id_item_agrega.",2,".$comienza.", ".$permiso_o_adjudica.", 3, 3)");
//$id=id_insert($insert);
////$query="update $c2 SET descarga_archivo_conflicto=0, revisa_archivo_conflicto=0 WHERE id_relacion=$id";
//$result=query_db($query);
	
	
	$id_log_presupuesto = log_de_procesos_sgpa(3, 89, 0, $id_comite_agrega, 0, 0);//agrega valores
	
	log_agrega_detalle ($id_log_presupuesto, "Comité",$id_comite_agrega , "t3_comite",1);
	log_agrega_detalle ($id_log_presupuesto, "Solicitud",$id_item_agrega , "t2_item_pecc",2);
	
?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/agrega-items.php?id_comite=<?= $id_comite ?>', 'contenidos');
</script>
<?
}
if($_POST["accion"]=="crear_comite"){
$lugar = arreglo_recibe_variables($_POST["lugar"]);
//

$fecha_separa = explode("-",$fecha);
$fecha_separa2 = substr($fecha_separa[0],2,4);
$numero2 = $fecha_separa2;
$numero1 = "CC";
$selec_si_hay_numero = traer_fila_row(query_db("select max(num3) from $c1 where num2 = '".$numero2."'"));
if($selec_si_hay_numero[0] == "" or $selec_si_hay_numero[0] == 0){
$numero3 = 1;
}else{
$numero3 = $selec_si_hay_numero[0]+1;
}


$insert = "insert into $c1 (id_us_crea, fecha, lugar, estado, fecha_creacion, num1,num2,num3,tipo_pecc_item,permitir_agregar_item, tipo_comite,tipo_comite_extraordinario) values (".$_SESSION["id_us_session"].",'".$_POST["fecha_comite"]."', '".$lugar."',2,'$fecha','".$numero1."','".$numero2."','".$numero3."',1,1,'".$_POST["tipo_comite_virtual_presencial"]."','".$_POST["extra_comite"]."')";

$sql_ex=query_db($insert.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

$id_log_presupuesto = log_de_procesos_sgpa(3, 88, 0, $id_ingreso, 0, 0);//agrega valores
	log_agrega_detalle ($id_log_presupuesto, "Fecha del Comité",$_POST["fecha_comite"] , "",1);
	log_agrega_detalle ($id_log_presupuesto, "Tipo de Comité",$_POST["extra_comite"] , "",2);
	
?>
<script>
    window.parent.ajax_carga('../aplicaciones/comite/edicion-comite.php?id_comite=<?= $id_ingreso ?>', 'contenidos');
    window.parent.ajax_carga('../aplicaciones/comite/menu_comite.php?id_comite=<?= $id_ingreso ?>', 'id_div_sub');
</script>
<?
}
if($_POST["accion"]=="crear_tarea"){
    
    /*
$id_item_agrega = elimina_comillas(arreglo_recibe_variables($_POST["id_item_agrega"]));// este es para los IDs
$comite_coment = arreglo_recibe_variables($_POST["comite_coment"]); //este es para los textos

generar consecutivos
$fecha_separa = explode("-",$fecha);
$fecha_separa2 = substr($fecha_separa[0],2,4);
$numero2 = $fecha_separa2;
$numero1 = "CC";
$selec_si_hay_numero = traer_fila_row(query_db("select max(num3) from $c1 where num2 = '".$numero2."'"));
if($selec_si_hay_numero[0] == "" or $selec_si_hay_numero[0] == 0){
$numero3 = 1;
}else{
$numero3 = $selec_si_hay_numero[0]+1;
}

*/  
    $fecha=date('Y-m-d');
    $fecha_separa = explode("-",$fecha);
    $fecha_separa2 = substr($fecha_separa[0],2,4);
    $numero2 = $fecha_separa2;
    $numero1 = "T";
    $selec_si_hay_numero = traer_fila_row(query_db("select max(num3) from $c6 where num2 = '".$numero2."'"));
    if($selec_si_hay_numero[0] == "" or $selec_si_hay_numero[0] == 0){
    $numero3 = 1;
    }else{
    $numero3 = $selec_si_hay_numero[0]+1;
    }
    $id_responsable=elimina_comillas($_POST['id_responsable']);
    $id_cierre=elimina_comillas($_POST['id_cierre']);;
    $id_comite=elimina_comillas($_POST['id_comite']);
    $id_solicitud=elimina_comillas($_POST['id_solicitud']);
    $fecha_apertura=date("Y-m-d H:i:s");
    $fecha_cierre=$_POST['fecha_cierre'];
    $titulo=arreglo_recibe_variables($_POST['titulo']);
    $detalle=arreglo_recibe_variables($_POST['detalle']);
    $seguimiento=arreglo_recibe_variables($_POST['seguimiento']);
    $estado=$_POST['estado'];
    if($id_solicitud==""){
        $insert="insert into $c6 (id_responsable, id_cierre, id_comite, id_solicitud, fecha_apertura, fecha_cierre, titulo, detalle, observacion, estado, num1, num2, num3) values (".$id_responsable.", ".$id_cierre."., ".$id_comite.", NULL, '".$fecha_apertura."', '".$fecha_cierre."', '".$titulo."', '".$detalle."', '".$seguimiento."', ".$estado.", '".$numero1."', '".$numero2."', ".$numero3.")";
    }else{
        $insert="insert into $c6 (id_responsable, id_cierre, id_comite, id_solicitud, fecha_apertura, fecha_cierre, titulo, detalle, observacion, estado, num1, num2, num3) values (".$id_responsable.", ".$id_cierre."., ".$id_comite.", ".$id_solicitud.", '".$fecha_apertura."', '".$fecha_cierre."', '".$titulo."', '".$detalle."', '".$seguimiento."', ".$estado.", '".$numero1."', '".$numero2."', ".$numero3.")";
    }
    $sql_ex=query_db($insert);
    $fecha=date('Y-m-d');
    $fecha_separa = explode("-",$fecha);
    $fecha_separa2 = substr($fecha_separa[0],2,4);
    $numero2 = $fecha_separa2;
    $numero1 = "GT";
    $selec_si_hay_numero = traer_fila_row(query_db("select max(num3) from $c7 where num2 = '".$numero2."'"));
    if($selec_si_hay_numero[0] == "" or $selec_si_hay_numero[0] == 0){
    $numero3 = 1;
    }else{
    $numero3 = $selec_si_hay_numero[0]+1;
    }
    $select_id_tarea="select id_tarea from $c6 where fecha_apertura='".$fecha_apertura."' and id_responsable=".$id_responsable." and id_comite=".$id_comite." and id_cierre=".$_SESSION["id_us_session"]." and fecha_cierre='".$fecha_cierre."'";
    $id=traer_fila_row(query_db($select_id_tarea));
    $insert="insert into $c7 (id_tarea, gestion, fecha_gestion, estado, id_usuario, num1, num2, num3) values (".$id[0].",'Tarea: ".$titulo."; detalle: ".$detalle."', '".$fecha_apertura."', 1, ".$id_cierre.", '".$numero1."', '".$numero2."', ".$numero3.")";
    $sql_ex=query_db($insert);
    if ($sql_ex) {
        echo "si";
    }else{
        echo "no";
    }
}
if($_POST["accion"]=="editar_tarea"){
    $id_responsable=elimina_comillas($_POST['id_responsable']);
    $id_cierre=elimina_comillas($_POST['id_cierre']);
    $id_comite=elimina_comillas($_POST['id_comite']);
    $id_solicitud=elimina_comillas($_POST['id_solicitud']); 
    $fecha_cierre=$_POST['fecha_cierre'];
    $titulo=arreglo_recibe_variables($_POST['titulo']);
    $detalle=arreglo_recibe_variables($_POST['detalle']);
    $seguimiento=arreglo_recibe_variables($_POST['seguimiento']);
    $estado=$_POST['estado']; $id_tarea=$_POST['id_tarea'];
    if($id_solicitud==""){
        $insert="update $c6 set id_responsable=".$id_responsable.", id_cierre=".$id_cierre.", id_comite=".$id_comite.", id_solicitud=NULL, fecha_cierre='".$fecha_cierre."', titulo='".$titulo."', detalle='".$detalle."', observacion='".$seguimiento."', estado=".$estado." where id_tarea=".$id_tarea;
    }else{
        $insert="update $c6 set id_responsable=".$id_responsable.", id_cierre=".$id_cierre.", id_comite=".$id_comite.", id_solicitud=".$id_solicitud.", fecha_cierre='".$fecha_cierre."', titulo='".$titulo."', detalle='".$detalle."', observacion='".$seguimiento."', estado=".$estado." where id_tarea=".$id_tarea;
    }
    
    echo $insert;
    $sql_ex=query_db($insert);
    if ($sql_ex) {
        echo "si";
    }else{
        echo "no";
    }
}
if($_POST["accion"]=="gestion_tarea"){
    $id_gestion=$_POST['id_gestion']; $id_tarea=$_POST['id_tarea'];
    $estado=$_POST['estado']; $detalle=$_POST['gestion'];
    $update="update $c7 set estado=2 where id_gestion=".$id_gestion;
    $id_usuario=$_SESSION["id_us_session"];
    echo $update;
    $sql_ex=query_db($update);
    $fecha_apertura=date("Y-m-d H:i:s");
    $sql_ex=query_db($insert);
    $fecha=date('Y-m-d');
    $fecha_separa = explode("-",$fecha);
    $fecha_separa2 = substr($fecha_separa[0],2,4);
    $numero2 = $fecha_separa2;
    $numero1 = "GT";
    $selec_si_hay_numero = traer_fila_row(query_db("select max(num3) from $c7 where num2 = '".$numero2."'"));
    if($selec_si_hay_numero[0] == "" or $selec_si_hay_numero[0] == 0){
    $numero3 = 1;
    }else{
    $numero3 = $selec_si_hay_numero[0]+1;
    }
    $insert="insert into $c7 (id_tarea, gestion, fecha_gestion, estado, id_usuario, num1, num2, num3) values (".$id_tarea.",'".$detalle."', '".$fecha_apertura."', ".$estado.", ".$id_usuario.", '".$numero1."', '".$numero2."', ".$numero3.")";
    echo $insert;
    $sql_ex=query_db($insert);
    if ($sql_ex) {
        echo "si";
    }else{
        echo "no";
    }
}
if($_POST["accion"]=="archivar_tarea"){
    $id_gestion=elimina_comillas($_POST['id_gestion']); 
    $update="update $c7 set estado=2 where id_gestion=".$id_gestion;
    $sql_ex=query_db($update);
    if ($sql_ex) {
        echo "si";
    }else{
        echo "no";
    }
}
if($_POST["accion"]=="genera_gestion_tarea"){
    $estado=$_POST['estado'];
    $id_tarea=$_POST['id_tarea'];
    $detalle=arreglo_recibe_variables($_POST['gestion']);
     $fecha=date('Y-m-d');
    $fecha_separa = explode("-",$fecha);
    $fecha_separa2 = substr($fecha_separa[0],2,4);
    $numero2 = $fecha_separa2;
    $numero1 = "GT";
    $selec_si_hay_numero = traer_fila_row(query_db("select max(num3) from $c7 where num2 = '".$numero2."'"));
    if($selec_si_hay_numero[0] == "" or $selec_si_hay_numero[0] == 0){
    $numero3 = 1;
    }else{
    $numero3 = $selec_si_hay_numero[0]+1;
    }
    $id_usuario=$_SESSION["id_us_session"];
    $fecha_apertura=date("Y-m-d H:i:s");
    $insert="insert into $c7 (id_tarea, gestion, fecha_gestion, estado, id_usuario, num1, num2, num3) values (".$id_tarea.",'".$detalle."', '".$fecha_apertura."', ".$estado.", ".$id_usuario.", '".$numero1."', '".$numero2."', ".$numero3.")";
    echo $insert;
    $sql_ex=query_db($insert);
    if ($sql_ex) {
        echo "si";
    }else{
        echo "no";
    }
}

?>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>