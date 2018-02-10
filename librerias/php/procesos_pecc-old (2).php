<?  include("../lib/@session.php");
verifica_menu("administracion.html");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
$hora_log = date("G:i:s");
?>
<script>
// window.parent.document.getElementById("cargando").style.display='block'
</script>
<?

/*solo para pruebas borrar*/

if($_POST["accion"]=="graba_gestion_economico"){
	agrega_fimas_urna_virtual($_POST["id_item_pecc"], "12.3");
	}
	
if($_POST["accion"]=="graba_gestion_tecnmmico"){
	agrega_fimas_urna_virtual($_POST["id_item_pecc"], "12.2");
	}

if($_POST["accion"]=="graba_gestion_apertura"){
	agrega_fimas_urna_virtual($_POST["id_item_pecc"], "12.1");
	}
/*solo para pruebas borrar*/



if($_POST["accion"]=="graba_reemplazo"){
	$fecha_desde_cuando = elimina_comillas_2($_POST["fecha_desde_cuando"]);
	$fecha_hasta_cuando = elimina_comillas_2($_POST["fecha_hasta_cuando"]);
	$ob_reemplazo = elimina_comillas_2($_POST["ob_reemplazo"]);
	
	$explode1 = explode("----,",$_POST["usuario_permiso"]);
	$id_usuario_ausente = $explode1[1];
	$explode2 = explode("----,",$_POST["usuario_permiso2"]);
	$id_usuario_reemplza = $explode2[1];
	
	$insert_into = query_db("insert into tseg_reemplazos (id_us, id_reemplazo, observacion, desde_cuando, hasta_cuando, usuario_crea, estado, fecha_creacion) values (".$id_usuario_ausente.", ".$id_usuario_reemplza.", '".$ob_reemplazo."', '".$fecha_desde_cuando."', '".$fecha_hasta_cuando."', ".$_SESSION["id_us_session"].", 1, '".$fecha." ".$hora_log."')");
	
	?><script>
window.parent.ajax_carga('../aplicaciones/pecc/reemplazos.php?id_item_pecc=<?=$_POST["id_item_pecc"]?>&id_tipo_proceso_pecc=<?=$_POST["id_tipo_proceso_pecc"]?>','contenidos');
window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?

}


if($_POST["accion"]=="graba_descarga_conflicto2"){

$filename="listado de conflicto de empleados Hocol ".$fecha." ".$hora_log.".xls";

$update = query_db(" update t2_item_pecc set revision2_conflicto_intereces = 1 where id_item = ".$_POST["id_item_pecc"]);
?><script>
window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones_adjudicacion.php?id_item_pecc=<?=$_POST["id_item_pecc"]?>&id_tipo_proceso_pecc=<?=$_POST["id_tipo_proceso_pecc"]?>','contenidos');
window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
}


if($_POST["accion"]=="graba_descarga_conflicto"){

$filename="listado de conflicto de empleados Hocol ".$fecha." ".$hora_log.".xls";

$update = query_db(" update t2_item_pecc set revision1_conflicto_intereces = 1 where id_item = ".$_POST["id_item_pecc"]);
?><script>
window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones.php?id_item_pecc=<?=$_POST["id_item_pecc"]?>&id_tipo_proceso_pecc=<?=$_POST["id_tipo_proceso_pecc"]?>','contenidos');
window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
}

if($_POST["accion"]=="graba_presupuesto_justificacion"){
$detalle_presupuesto = elimina_comillas_2($_POST["detalle_presupuesto"]);

$update = query_db(" update t2_item_pecc set justificacion_presupuesto = '".$detalle_presupuesto."' where id_item = ".$_POST["id_item_pecc"]);
?><script>
alert("La justificacion del presupuesto se grabo con exito.");
window.parent.ajax_carga('../aplicaciones/administracion/maestra_area_proyecto.php', 'carga_admin');
window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
}



$texto_declara_intereses="Declaro que no tengo conflicto de intereses";
if($_POST["accion"]=="maestra_edita_area_proyecto"){

$nombre = elimina_comillas($_POST["nombre"]);
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd"])));

if($valor_usd==0 or $valor_usd==""){
$valor_usd=99999999999;
}

$insert = query_db("update t1_campo set t1_naturaleza_contratacion_id = '".$_POST["naturaleza"]."', nombre='".$nombre."', estado='".$_POST["estado"]."', valor_socios='".$valor_usd ."' where t1_campo_id = ".$_POST["id"]);
?><script>window.parent.ajax_carga('../aplicaciones/administracion/maestra_area_proyecto.php', 'carga_admin')</script><?
}

if($_POST["accion"]=="maestra_crea_area_proyecto"){

$nombre = elimina_comillas($_POST["nombre"]);
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd"])));

if($valor_usd==0 or $valor_usd==""){
$valor_usd=99999999999;
}

$insert = query_db("insert into t1_campo (t1_naturaleza_contratacion_id, nombre, estado, valor_socios) values ('".$_POST["naturaleza"]."','".$nombre."',1,'".$valor_usd ."')");
?><script>window.parent.ajax_carga('../aplicaciones/administracion/maestra_area_proyecto.php', 'carga_admin')</script><?
}

if($_POST["accion_correo_ot"]=="subir_archivo_correos_ot"){
$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["sele_arch"]["name"];
$campo_file_temp1 = $_FILES["sele_arch"]["tmp_name"];	



if($campo_file_nombre1 != ""){
$rando = rand(0,100000);
$nombre_file1 = "correos_ot"."_".$rando."_".$fecha."_".$campo_file_nombre1;
$copiar = copy($campo_file_temp1,'../../archivo_ot/'.$nombre_file1);

}
?>
<script>alert("El archivo se cargo con exito")</script>
<?
}


if($_POST["accion"]=="cammbio_de_estado_por_admin"){


$update = query_db("update t2_item_pecc set estado = ".$_POST["nuevo_estdo_edita"]." where id_item = ".$_POST["id_item_pecc"]);



$id_log = log_de_procesos_sgpa(2, 42, 63, $_POST["id_item_pecc"], $_POST["estado_item_peec"], $_POST["nuevo_estdo_edita"]);//agrega valores

log_agrega_detalle ($id_log, "Se cambia el estado para terminar las firmas", "" , "",1);
log_agrega_detalle ($id_log, "Se conservan las firmas", "" , "t2_nivel_servicio_actividades",1);


$sele_modificaciones =query_db("select id, tipo_complemento, numero_otrosi from t7_contratos_complemento where id_item_pecc = ".$_POST["id_item_pecc"]);
while($mo=traer_fila_db($sele_modificaciones)){
$delete = query_db("delete from t7_contratos_complemento where id=".$mo[0]);
if($mo[1]==1){
log_agrega_detalle ($id_log, "Se Elimino el OTRO SI", $mo[2] , "",1);
}
if($mo[1]==2){
log_agrega_detalle ($id_log, "Se Elimino la OT", $mo[2] , "",1);
}			
}






?><script>alert("El cambio se realizo con exito")</script><?

}
if($_POST["accion"]=="carga_informacion_sol_informativo"){


$id_item_carga = elimina_comillas(arreglo_recibe_variables($_POST["solicitud_que_carga"]));

$sel_item = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$id_item_carga));

$sel_contra_datos = traer_fila_row(query_db("select t1.t1_area_id, CAST(t1.ob_contrato_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.alcance_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.justificacion_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.recomendacion_adjudica AS text)  COLLATE Cyrillic_General_CI_AI, CAST(objeto_contrato AS text)  COLLATE Cyrillic_General_CI_AI,CAST(alcance AS text)  COLLATE Cyrillic_General_CI_AI,CAST(justificacion AS text)  COLLATE Cyrillic_General_CI_AI,CAST(recomendacion AS text)  COLLATE Cyrillic_General_CI_AI,proveedores_sugeridos from $pi2 as t1 where t1.id_item = ".$id_item_carga));


if($sel_contra_datos[1] =="" or $sel_contra_datos[1] ==" "){
$objeto = $sel_contra_datos[5];
}else{
$objeto = $sel_contra_datos[1];
}
if($sel_contra_datos[2] =="" or $sel_contra_datos[2] ==" "){
$alcance = $sel_contra_datos[6];

}else{
$alcance = $sel_contra_datos[2];
}
if($sel_contra_datos[3] =="" or $sel_contra_datos[3] ==" "){
$justifica = $sel_contra_datos[7];
}else{
$justifica = $sel_contra_datos[3];
}
if($sel_contra_datos[4] =="" or $sel_contra_datos[4]==" "){
$recomenda = $sel_contra_datos[8];
}else{
$recomenda = $sel_contra_datos[4];
}

$alcance = nl2br(imprime_texo_a_js($alcance));
$recomenda = nl2br(imprime_texo_a_js($recomenda));
$justifica = nl2br(imprime_texo_a_js($justifica));
$objeto = nl2br(imprime_texo_a_js($objeto));

?><script>

    window.parent.document.getElementById("solicitud_relacionada_actual").innerHTML = "<font color ='#ff0000'> - Actualmente esta relacionada la Solicitud <?= numero_item_pecc($sel_item[0], $sel_item[1], $sel_item[2]) ?></font> <img src='../imagenes/botones/eliminada_temporal.gif' onClick='valida_tipo_proceso(11)' />"
</script>
<script>window.parent.document.principal.area_usuaria.value = "<?= $sel_contra_datos[0] ?>"</script>
<script>window.parent.document.principal.objeto_contrato.value = "<?= $objeto ?>"</script>
<script>window.parent.document.principal.alcance.value = "<?= $alcance ?>"</script>
<script>//window.parent.document.principal.justificacion.value = "< ?= $justifica ?>"</script>
<script>window.parent.document.principal.recomendacion.value = "<?= $recomenda ?>"</script>
<script> window.parent.document.principal.contratos_normales.value = ""</script>

<script>
    if (window.parent.document.principal.id_item_pecc.value == 0) {
        window.parent.document.principal.proveedores_sugeridos.value = "<?= $sel_contra_datos[9] ?>"
    }

</script><?


}

if($_POST["accion"]=="envio_correo_desde_admin"){

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
envio_correo_ot($id_item_pecc);

?>
<script>
    alert("los correos se enviaron con exito")
</script>
<?


}
if($_POST["accion"]=="finli_amplicion"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));


$upda = query_db("update $pi2 set aprobado = 1, estado = 32 where id_item=".$id_item_pecc);

$id_log = log_de_procesos_sgpa(1, 55, 0, $id_item_pecc, 20, 22);//agrega valores
log_agrega_detalle ($id_log, "Finalizo Solicitud"," La solicitud de ampliacion se finalizo por que el usuario decidio no crear OT y tampoco Otro Si. " , "",1);
log_agrega_detalle ($id_log, "Fecha: ",$fecha , "",2);


?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?

}


if($_POST["accion"]=="crea_otro_si_de_ot"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));

$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
$sel_valor_adjudicacion = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2"));

if($sel_valor_adjudicacion[0]=="" and $sel_valor_adjudicacion[1]==""){
$sel_valor_adjudicacion = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1"));
}
$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
while($sel_presu = traer_fila_db($sele_presupuesto)){




$sel_contr = query_db("select t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
while($sel_apl = traer_fila_db($sel_contr)){

$id_log = log_de_procesos_sgpa(1, 21, 0, $id_item_pecc, 20, 22);//agrega valores
log_agrega_detalle ($id_log, "Fecha: ",$fecha , "",2);


$sele_max_otro_si= traer_fila_row(query_db("select max(numero_otrosi) from $co4  where tipo_complemento = 1"));
$consecutivo = $sele_max_contrato[0]+1;


$crea_otro_si = "insert into $co4 (id_item_pecc,id_contrato, tipo_complemento,alcance,valor,valor_cop,creacion_sistema,estado, numero_otrosi, gerente,eliminado) values ($id_item_pecc,".$sel_apl[0].",1,'".$sel_item[10]."', ".$sel_valor_adjudicacion[0].",".$sel_valor_adjudicacion[1].",'$fecha',15,".$consecutivo.",".$sel_item[3].",0)";

$sql_ex=query_db($crea_otro_si.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);//id del contrato

log_agrega_detalle ($id_log, "Otro Si", $id_ingreso , $co4,1);
log_agrega_detalle ($id_log, "Fecha: ",$fecha , "",2);

}

}




$update_ots = query_db("update t7_contratos_complemento set recibido_abastecimiento = '', recibido_abastecimiento_e = '$fecha' where id_item_pecc = ".$id_item_pecc);


$upda = query_db("update $pi2 set aprobado = 1, estado = 22 where id_item=".$id_item_pecc);
$hora_log = date("G:i:s");
$insrt_gestion_elabora_contra = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado, hora) values ($id_item_pecc,20,18463, '$fecha',0,1,'$hora_log')");



?>
<script>

    alert("El otro si se creo con exito")
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?

}



if($_POST["accion"]=="agrega_quita_correo_ot"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$tipo_agrega_quita_correo_ot = elimina_comillas(arreglo_recibe_variables($_POST["tipo_agrega_quita_correo_ot"]));
$id_correo_relacion = elimina_comillas(arreglo_recibe_variables($_POST["id_correo_relacion"]));

$sel_correo = traer_fila_row(query_db("select * from t2_item_ot_correo where t2_correo_ot_id = ".$id_correo_relacion));


if($tipo_agrega_quita_correo_ot==1){

$inser_relacion = query_db("insert into t2_item_ot_correo_relacion_item (id_correo_envio_ot, id_item) values ($id_correo_relacion, $id_item_pecc)");


$id_log = log_de_procesos_sgpa(2, 5, 60, $id_item_pecc, '', '');//agrega valores
log_agrega_detalle ($id_log, "Correo que Agrego",$sel_correo[1] , "",1);
log_agrega_detalle ($id_log, "Fecha: ",$fecha , "",2);



}else{
$delete = query_db("delete from t2_item_ot_correo_relacion_item where id_item = $id_item_pecc and id_correo_envio_ot =  ".$id_correo_relacion);

$id_log = log_de_procesos_sgpa(2, 5, 61, $id_item_pecc, '', '');//agrega valores
log_agrega_detalle ($id_log, "Correo que Quito",$sel_correo[1] , "",1);
log_agrega_detalle ($id_log, "Fecha: ",$fecha , "",2);

}

}
if($_POST["accion"]=="agrega_correo_ot"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));


$insert ="insert into t2_item_ot_correo (correo, estado, id_us_agrega, fecha,id_proveedor) values ('".$_POST["correo_agrega"]."',1,".$_SESSION["id_us_session"].", '$fecha','".$_POST["id_contratista_ot"]."')";

$sql_ex=query_db($insert.$trae_id_insrte);
$id_correo_ot = id_insert($sql_ex);

$inser_relacion = query_db("insert into t2_item_ot_correo_relacion_item (id_correo_envio_ot, id_item) values ($id_correo_ot, $id_item_pecc)");

$id_log = log_de_procesos_sgpa(2, 5, 60, $id_item_pecc, '', '');//agrega valores
log_agrega_detalle ($id_log, "Correo que Agrego",$_POST["correo_agrega"] , "",1);
log_agrega_detalle ($id_log, "Fecha: ",$fecha , "",2);

?>
<script>alert("El correo se agrego con exito con Exito")
    window.parent.ajax_carga('../aplicaciones/pecc/correos_ot.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?

}
if($_POST["accion"]=="graba_revision_sap"){

$id_item = $_POST["id_item_graba_revision"];

$accion_revision = $_POST["resicion_SAP".$id_item];
$ob_sap = $_POST["ob_sap".$id_item];


$sel_si_tiene = traer_fila_row(query_db("select * from t2_revision_sap where id_item = ".$id_item));
if($sel_si_tiene[0]>0){
$update = query_db("update t2_revision_sap set accion_sap = '".$accion_revision."', ob = '".$ob_sap."' where id_item = ".$id_item);
}else{
$insert = query_db("insert into t2_revision_sap (id_item, accion_sap,ob) values (".$id_item.", '".$accion_revision."','".$ob_sap."')");


}
$id_log = log_de_procesos_sgpa(2, 41, 0, $id_item, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores 

log_agrega_detalle ($id_log, "Accion graba revision SAP",$accion_revision, "",1);
log_agrega_detalle ($id_log, "Observacion",$ob_sap, "",2);

?><script>alert("La revision se grabo con exito")</script><?
}
if($_POST["accion"]=="cambia_profesional_asignado_a_usua"){
$delete = query_db("delete from t2_relacion_usuarios_profesionales where id_usuario = ".$_POST["id_usua"]);
$insert = query_db("insert into t2_relacion_usuarios_profesionales (id_usuario, id_profesional) values (".$_POST["id_usua"].",".$_POST["id_prof"].")");
}



if($_POST["accion"]=="pone_datos_contrato_otro_si_edicion"){

echo $_POST["id_contrato_otro_si"]."prueba";
$explode = explode("----,",$_POST["id_contrato_otro_si"]);
$id_contrato = $explode[1];




$sel_contra_datos = traer_fila_row(query_db("select t1.t1_area_id, CAST(t1.ob_contrato_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.alcance_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.justificacion_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.recomendacion_adjudica AS text)  COLLATE Cyrillic_General_CI_AI, CAST(objeto_contrato AS text)  COLLATE Cyrillic_General_CI_AI,CAST(alcance AS text)  COLLATE Cyrillic_General_CI_AI,CAST(justificacion AS text)  COLLATE Cyrillic_General_CI_AI,CAST(recomendacion AS text)  COLLATE Cyrillic_General_CI_AI, t2.contratista from $pi2 as t1, $co1 as t2 where t1.id_item = t2.id_item and t2.id = ".$id_contrato));

// $sel_contra_datos = traer_fila_row(query_db("select t1.t1_area_id, t1.ob_contrato_adjudica,t1.alcance_adjudica,t1.justificacion_adjudica,t1.recomendacion_adjudica, objeto_contrato,alcance,justificacion,recomendacion, t2.contratista from $pi2 as t1, $co1 as t2 where t1.id_item = t2.id_item and t2.id = ".$id_contrato));

$contratista = traer_nombre_muestra($sel_contra_datos[9], $g6,"razon_social","t1_proveedor_id");

if($sel_contra_datos[1] =="" or $sel_contra_datos[1] ==" "){
$objeto = $sel_contra_datos[5];
}else{
$objeto = $sel_contra_datos[1];
}
if($sel_contra_datos[2] =="" or $sel_contra_datos[2] ==" "){
$alcance = $sel_contra_datos[6];

}else{
$alcance = $sel_contra_datos[2];
}
if($sel_contra_datos[3] =="" or $sel_contra_datos[3] ==" "){
$justifica = $sel_contra_datos[7];
}else{
$justifica = $sel_contra_datos[3];
}
if($sel_contra_datos[4] =="" or $sel_contra_datos[4]==" "){
$recomenda = $sel_contra_datos[8];
}else{
$recomenda = $sel_contra_datos[4];
}

$alcance = nl2br(imprime_texo_a_js($alcance));
$recomenda = nl2br(imprime_texo_a_js($recomenda));
$justifica = nl2br(imprime_texo_a_js($justifica));

?>
<script> window.parent.document.principal.solicitud_que_carga.value = "0";</script>

<script> window.parent.document.principal.area_usuaria.value = "<?= $sel_contra_datos[0] ?>"</script>
<script> window.parent.document.principal.objeto_contrato.value = "<?= $objeto ?>"</script>
<script> window.parent.document.principal.alcance.value = "<?= $alcance ?>"</script>
<script> //window.parent.document.principal.justificacion.value = "< ?= $justifica ?>"</script>
<script> window.parent.document.principal.recomendacion.value = "<?= $recomenda ?>"</script>




<script>window.parent.document.getElementById("solicitud_relacionada_actual").innerHTML = ""</script>

<?
}

if($_POST["accion"]=="pone_datos_contrato_otro_si"){


$explode = explode("----,",$_POST["id_contrato_otro_si"]);
$id_contrato_otro_si1 = $explode[1];

$explode2 = explode("---- ",$id_contrato_otro_si1);
$id_contrato_otro_si = $explode2[0];
$id_contrato_otro_si = str_replace("-","",$id_contrato_otro_si);
$id_contrato_otro_si = str_replace(" ","",$id_contrato_otro_si);
$id_contrato = str_replace(",","",$id_contrato_otro_si);



$sel_contra_datos = traer_fila_row(query_db("select t1.t1_area_id, CAST(t1.ob_contrato_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.alcance_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.justificacion_adjudica AS text)  COLLATE Cyrillic_General_CI_AI,CAST(t1.recomendacion_adjudica AS text)  COLLATE Cyrillic_General_CI_AI, CAST(objeto_contrato AS text)  COLLATE Cyrillic_General_CI_AI,CAST(alcance AS text)  COLLATE Cyrillic_General_CI_AI,CAST(justificacion AS text)  COLLATE Cyrillic_General_CI_AI,CAST(recomendacion AS text)  COLLATE Cyrillic_General_CI_AI, t2.contratista,id_us from $pi2 as t1, $co1 as t2 where t1.id_item = t2.id_item and t2.id = ".$id_contrato));



$sel_ob_contrato = traer_fila_row(query_db("select CAST(objeto AS text) from t7_contratos_contrato where id = ".$id_contrato));
$objeto= $sel_ob_contrato[0];
$contratista = traer_nombre_muestra($sel_contra_datos[9], $g6,"razon_social","t1_proveedor_id");
$gerente_contrato = traer_nombre_muestra($sel_contra_datos[10], $g1,"nombre_administrador","us_id");


if($sel_contra_datos[2] =="" or $sel_contra_datos[2] ==" "){
$alcance = $sel_contra_datos[6];

}else{
$alcance = $sel_contra_datos[2];
}
if($sel_contra_datos[3] =="" or $sel_contra_datos[3] ==" "){
$justifica = $sel_contra_datos[7];
}else{
$justifica = $sel_contra_datos[3];
}
if($sel_contra_datos[4] =="" or $sel_contra_datos[4]==" "){
$recomenda = $sel_contra_datos[8];
}else{
$recomenda = $sel_contra_datos[4];
}


if($sel_item[3] != $_SESSION["id_us_session"]){


}

if($sel_contra_datos[10] != $_SESSION["id_us_session"]){

?><script>
    window.parent.document.getElementById("alerta_no_gerente").innerHTML = "<span class='titulos_resumen_alertas'>Usted no es el gerente del contrato</span>"

</script><?

}

$alcance = nl2br(imprime_texo_a_js($alcance));
$recomenda = nl2br(imprime_texo_a_js($recomenda));
$justifica = nl2br(imprime_texo_a_js($justifica));




?><script>
    window.parent.document.getElementById("solicitud_relacionada_actual").innerHTML = ""
</script>
<script>window.parent.document.principal.solicitud_que_carga.value = "0";</script>
<script> window.parent.document.principal.area_usuaria.value = "<?= $sel_contra_datos[0] ?>";</script>
<script>window.parent.document.principal.objeto_contrato.value = "<?= $objeto ?>";</script>
<script>window.parent.document.principal.proveedores_sugeridos.value = "<?= $contratista ?>";</script>




<script>window.parent.document.principal.alcance.value = "<?= $alcance ?>";</script>
<script>//window.parent.document.principal.justificacion.value = "<?= $justifica ?>";</script>
<script>window.parent.document.principal.recomendacion.value = "<?= $recomenda ?>";</script>


<?


}
if($_POST["accion"]=="graba_info_adjudica"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$campo1 = elimina_comillas_2($_POST["objeto_contrato"]);
$campo2 = elimina_comillas_2($_POST["alcance"]);
$campo3 = elimina_comillas_2($_POST["justificacion"]);
$campo3_2 = elimina_comillas_2($_POST["justificacion2"]);
$campo4 = elimina_comillas_2($_POST["recomendacion"]);
$campo5 = elimina_comillas_2($_POST["objeto_solicitud"]);
$antecedentes = elimina_comillas_2($_POST["antecedentes_texto"]);

$explode = explode("----,",$_POST["contratos_normales"]);
$id_contrato_otro_si1 = $explode[1];

$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

if($sel_item[6]==6 or($sel_item[6]==15 and ($sel_item[14]==31 or $sel_item[14]==6))){

$comple_upda = ", fecha_se_requiere='".$_POST["fecha"]."', t1_tipo_proceso_id='".$_POST["tipo_proceso"]."', t1_area_id='".$_POST["area_usuaria"]."', contrato_id ='".$id_contrato_otro_si1."', id_solicitud_relacionada = '".$_POST["solicitud_que_carga"]."'";

if($_POST["tipo_proceso"] <> 6 and $sel_item[6]==6){
$upda = query_db("update $pi2 set estado = 6 where id_item = ".$id_item_pecc);
}

}


$upda = query_db("update $pi2 set ob_contrato_adjudica = '".$campo1."', alcance_adjudica = '".$campo2."', justificacion_adjudica = '".$campo3."', justificacion_tecnica_ad='".$campo3_2."', recomendacion_adjudica = '".$campo4."', ob_solicitud_adjudica = '".$campo5."', aprobacion_comite_adicional = ".$_POST["req_comite"].", requiere_socios_adicional = '".$_POST["req_socios"]."', antecedentes_adjudicacion = '".$antecedentes."', origen_pecc = '".$_POST["origen_pecc"]."' $comple_upda,req_contra_mano_obra_local_ad='".$_POST["req_contra_mano_obra_local"]."', req_contra_serv_bien_local_ad='".$_POST["req_cont_bien_ser_local"]."' where id_item = ".$id_item_pecc);

echo $_POST["tipo_proceso"];

if($_POST["tipo_proceso"]==6 or $_POST["tipo_proceso"]==15){// si es ad sondeo o modificacion actualiza la informacion del permiso

$upda_permiso = query_db("update $pi2 set objeto_contrato = '".$campo1."', alcance = '".$campo2."', justificacion = '".$campo3."', justificacion_tecnica ='".$campo3_2."', recomendacion = '".$campo4."', objeto_solicitud = '".$campo5."', antecedentes_permiso = '".$antecedentes."' where id_item = ".$id_item_pecc);


}

valida_firmas_que_estan_creadas_permiso($id_item_pecc);

/*VARIABLE SPARA OBJETIVOS DEL PROCESO*/
$grabas_objetivos_proceso="SI";
$id_item_para_grabar_ob_proceso=$id_item_pecc;
$adj_permiso=2;
$tipo_proceso_para_ob_proceso = $_POST["tipo_proceso"];

/* FIN VARIABLE SPARA OBJETIVOS DEL PROCESO*/


?><script>alert("Los Cambios se Realizaron con Exito")
   // window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=< ?= $id_item_pecc ?>&id_tipo_proceso_pecc=< ?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script><?

}


if($_POST["accion"]=="cambios_administrativos_solo_congelar"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$ob1 = arreglo_recibe_variables($_POST["ob1"]);
$ob2 = arreglo_recibe_variables($_POST["ob2"]);
$ob3 = arreglo_recibe_variables($_POST["ob3"]);
$ob4 = arreglo_recibe_variables($_POST["ob4"]);
$ob5 = arreglo_recibe_variables($_POST["ob5"]);
$ob6 = arreglo_recibe_variables($_POST["ob6"]);
$ob7 = arreglo_recibe_variables($_POST["ob7"]);


if($_POST["acci5"] == 1){
$valor_accion = "Congelado";
$a_deloitte = 1;

}else{
$valor_accion = "Activo";
$a_deloitte = 0;

}
//inicio congelado en contratos
$busca_congelado = query_db("select estado,id from $co1 where id_item = $id_item_pecc");
while($sql_busca_congelado=traer_fila_row($busca_congelado)){
$i_regis = "update $co1 set analista_deloitte = ".$a_deloitte.",obs_congelado='".$ob5."' where id =".$sql_busca_congelado[1];
$sql_ex=query_db($i_regis);

$i_regis = "insert into $co11 values (".$sql_busca_congelado[1].",0,".$a_deloitte.",'".date("Y-m-d")."','".$sql_busca_congelado[0]."')";
$sql_ex=query_db($i_regis);
}
//fin congelado en contratos

//inicio congelado en contratos / modificaciones
$busca_congelado_con = query_db("select estado,id,id_contrato from $co4 where id_item_pecc = $id_item_pecc");
while($sql_busca_congelado=traer_fila_row($busca_congelado_con)){
$i_regis = "update $co4 set congelado = ".$a_deloitte.",obs_congelado='".$ob5."' where id =".$sql_busca_congelado[1];
$sql_ex=query_db($i_regis);

$i_regis = "insert into $co11 values (".$sql_busca_congelado[2].",".$sql_busca_congelado[1].",".$a_deloitte.",'".date("Y-m-d")."','".$sql_busca_congelado[0]."')";
$sql_ex=query_db($i_regis);
}
//fin congelado en contratos / modificaciones


$insr5 = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','5. Cambiar el Estado del Proceso', '".$ob5."', '".$valor_accion."',".$id_item_pecc." )");





//ACTUALIZA ITEM
$updat = query_db("update $pi2 set congelado='".$_POST["acci5"]."' where id_item = ".$id_item_pecc);
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

/*--------------- LOG -----------------*/
$id_log = log_de_procesos_sgpa(2, 38, 0, $id_item_pecc, $sel_item[14], $sel_item[14]);//agrega valores
log_agrega_detalle ($id_log, "Estado del Proceso",$valor_accion, "",3);
log_agrega_detalle ($id_log, "Observacion Estado del Proceso",$ob5, "",4);
/*--------------- LOG -----------------*/

?><script>alert("Los Cambios se Realizaron con Exito")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
}

if($_POST["accion"]=="cambios_administrativos_profecionales"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$ob1 = arreglo_recibe_variables($_POST["ob1"]);
$ob2 = arreglo_recibe_variables($_POST["ob2"]);
$ob3 = arreglo_recibe_variables($_POST["ob3"]);
$ob4 = arreglo_recibe_variables($_POST["ob4"]);
$ob5 = arreglo_recibe_variables($_POST["ob5"]);
$ob6 = arreglo_recibe_variables($_POST["ob6"]);
$ob7 = arreglo_recibe_variables($_POST["ob7"]);

$sel_us_admin = traer_fila_row(query_db("select * from $g1 where us_id =".$_SESSION["id_us_session"]));
$sel_us_prof = traer_fila_row(query_db("select * from $g1 where us_id =".$_POST["acci2"]));
$sel_us_gestor_socios_permiso = traer_fila_row(query_db("select * from $g1 where us_id =".$_POST["acci7"]));
$sel_us_gestor_socios_adjudica = traer_fila_row(query_db("select * from $g1 where us_id =".$_POST["acci7"]));



$insr = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','1. Cambiar el Gerente del Contrato', '".$ob1."', '".$_POST["usuario_permiso"]."',".$id_item_pecc." )");

$insr2 = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','2. Cambiar el Profesional de C&C', '".$ob2."', '".$sel_us_prof[1]."',".$id_item_pecc." )");







if($_POST["acci5"] == 1){
$valor_accion = "Congelado";
$a_deloitte = 1;

}else{
$valor_accion = "Activo";
$a_deloitte = 0;

}
//inicio congelado en contratos
$busca_congelado = query_db("select estado,id from $co1 where id_item = $id_item_pecc");
while($sql_busca_congelado=traer_fila_row($busca_congelado)){
$i_regis = "update $co1 set analista_deloitte = ".$a_deloitte.",obs_congelado='".$ob5."' where id =".$sql_busca_congelado[1];
$sql_ex=query_db($i_regis);

$i_regis = "insert into $co11 values (".$sql_busca_congelado[1].",0,".$a_deloitte.",'".date("Y-m-d")."','".$sql_busca_congelado[0]."')";
$sql_ex=query_db($i_regis);
}
//fin congelado en contratos

//inicio congelado en contratos / modificaciones
$busca_congelado_con = query_db("select estado,id,id_contrato from $co4 where id_item_pecc = $id_item_pecc");
while($sql_busca_congelado=traer_fila_row($busca_congelado_con)){
$i_regis = "update $co4 set congelado = ".$a_deloitte.",obs_congelado='".$ob5."' where id =".$sql_busca_congelado[1];
$sql_ex=query_db($i_regis);

$i_regis = "insert into $co11 values (".$sql_busca_congelado[2].",".$sql_busca_congelado[1].",".$a_deloitte.",'".date("Y-m-d")."','".$sql_busca_congelado[0]."')";
$sql_ex=query_db($i_regis);
}
//fin congelado en contratos / modificaciones


$insr5 = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','5. Cambiar el Estado del Proceso', '".$ob5."', '".$valor_accion."',".$id_item_pecc." )");



$explode = explode("----,",$_POST["usuario_permiso"]);
$id_usuario = $explode[1];

//ACTUALIZA ITEM
$updat = query_db("update $pi2 set id_us=".$id_usuario.", id_us_profesional_asignado='".$_POST["acci2"]."', congelado='".$_POST["acci5"]."' where id_item = ".$id_item_pecc);

//ACTUALIZA FIRMAS PROFESIONALES
$sel_secuencia_profesional = query_db(" select id_secuencia_solicitud from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = 8 and estado = 1");
while($sel_secu_prof = traer_fila_db($sel_secuencia_profesional)){
$selec_aprobacion = traer_fila_row(query_db("select count(*) from $pi16 where id_secuencia_solicitud = ".$sel_secu_prof[0]." and aprobado = 1"));
if($selec_aprobacion[0]<=0){
$delete_usuarios = query_db("delete from $pi15 where id_secuencia_solicitud = ".$sel_secu_prof[0]);
$inser_usuario = query_db("insert into $pi15 (id_secuencia_solicitud, id_usuario, estado) values (".$sel_secu_prof[0].",'".$_POST["acci2"]."', 1 ) ");
}

}
//FIN ACTUALIZA FIRMAS PROFESIONALES



/*--------------- LOG -----------------*/
$id_log = log_de_procesos_sgpa(2, 38, 0, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, "Gerente del Item / Solicitante",$id_usuario, "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Observacion Gerente del Item / Solicitante",$ob1, "",2);
log_agrega_detalle ($id_log, "Profesional Designado",$_POST["acci2"], "t1_us_usuarios",2);
log_agrega_detalle ($id_log, "Observacion Profesional Designado",$ob2, "",2);
log_agrega_detalle ($id_log, "Estado del Proceso",$valor_accion, "",3);
log_agrega_detalle ($id_log, "Observacion Estado del Proceso",$ob5, "",3);
/*--------------- LOG -----------------*/

?><script>alert("Los Cambios se Realizaron con Exito")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
}

if($_POST["accion"]=="cambios_administrativos"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$ob1 = arreglo_recibe_variables($_POST["ob1"]);
$ob2 = arreglo_recibe_variables($_POST["ob2"]);
$ob3 = arreglo_recibe_variables($_POST["ob3"]);
$ob4 = arreglo_recibe_variables($_POST["ob4"]);
$ob5 = arreglo_recibe_variables($_POST["ob5"]);
$ob6 = arreglo_recibe_variables($_POST["ob6"]);
$ob7 = arreglo_recibe_variables($_POST["ob7"]);
$ob8 = arreglo_recibe_variables($_POST["ob8"]);

$sel_us_admin = traer_fila_row(query_db("select * from $g1 where us_id =".$_SESSION["id_us_session"]));
$sel_us_prof = traer_fila_row(query_db("select * from $g1 where us_id =".$_POST["acci2"]));
$sel_us_gestor_socios_permiso = traer_fila_row(query_db("select * from $g1 where us_id =".$_POST["acci7"]));
$sel_us_gestor_socios_adjudica = traer_fila_row(query_db("select * from $g1 where us_id =".$_POST["acci7"]));



$insr = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','1. Cambiar el Gerente del Contrato', '".$ob1."', '".$_POST["usuario_permiso"]."',".$id_item_pecc." )");

$insr2 = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','2. Cambiar el Profesional de C&C', '".$ob2."', '".$sel_us_prof[1]."',".$id_item_pecc." )");





$insr3 = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','3. Cambiar Fecha en la que se Requiere el Servicio', '".$ob3."', '".$_POST["fecha"]."',".$id_item_pecc." )");
if($_POST["acci4"] == 1){
$valor_accion = "SI";
$poner_tiempos_especiales="SI";
}else{
$poner_tiempos_especiales="NO";
$valor_accion = "NO";
}
$insr4 = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','4. Poner Tiempos Especiales', '".$ob4."', '".$valor_accion."',".$id_item_pecc." )");

if($_POST["acci5"] == 1){
$valor_accion = "Congelado";
$estado_pro_congela = "Congelado";
$a_deloitte = 1;
}else{
$valor_accion = "Activo";
$estado_pro_congela = "Activo";
$a_deloitte = 0;
}
//inicio congelado en contratos
$busca_congelado = query_db("select estado,id from $co1 where id_item = $id_item_pecc");
while($sql_busca_congelado=traer_fila_row($busca_congelado)){
$i_regis = "update $co1 set analista_deloitte = ".$a_deloitte.",obs_congelado='".$ob5."' where id =".$sql_busca_congelado[1];
$sql_ex=query_db($i_regis);

$i_regis = "insert into $co11 values (".$sql_busca_congelado[1].",0,".$a_deloitte.",'".date("Y-m-d")."','".$sql_busca_congelado[0]."')";
$sql_ex=query_db($i_regis);
}
//fin congelado en contratos

//inicio congelado en contratos / modificaciones
$busca_congelado_con = query_db("select estado,id,id_contrato from $co4 where id_item_pecc = $id_item_pecc");
while($sql_busca_congelado=traer_fila_row($busca_congelado_con)){
$i_regis = "update $co4 set congelado = ".$a_deloitte.",obs_congelado='".$ob5."' where id =".$sql_busca_congelado[1];
$sql_ex=query_db($i_regis);

$i_regis = "insert into $co11 values (".$sql_busca_congelado[2].",".$sql_busca_congelado[1].",".$a_deloitte.",'".date("Y-m-d")."','".$sql_busca_congelado[0]."')";
$sql_ex=query_db($i_regis);
}
//fin congelado en contratos / modificaciones


$insr5 = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','5. Cambiar el Estado del Proceso', '".$ob5."', '".$valor_accion."',".$id_item_pecc." )");

if($_POST["acci6"] == 1){
$valor_accion = "SI Eliminar el Proceso";



}else{
$valor_accion = "NO";
}

$insr6 = "insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item,adjunto) values ('".$sel_us_admin[1]."','$fecha','6. Eliminar Este Proceso', '".$ob6."', '".$valor_accion."',".$id_item_pecc.",'' )";

$sql_ex=query_db($insr6.$trae_id_insrte);
$id_accion_amin = id_insert($sql_ex);

if($_POST["acci6"] == 1){//si es eliminar carga el archivo

$nombre_file1="";
$campo_file_nombre1 = $_FILES["adjunto_para_eliminar"]["name"];
$campo_file_temp1 = $_FILES["adjunto_para_eliminar"]["tmp_name"];	
$sql_comple_elim = ", estado = 33";


if($campo_file_nombre1 != ""){

$nombre_file1 = "elimina_proceso"."_".$id_accion_amin."_".$campo_file_nombre1;
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_accion_amin.$_POST["id_item_pecc"]."_4");
$upda = query_db("update $pi19 set adjunto = '".$nombre_file1."' where id_accion_admin = ".$id_accion_amin);
}	

$id_log = log_de_procesos_sgpa(2, 39, 0, $id_item_pecc, 0, 0);//agrega valores
log_agrega_detalle ($id_log, "Observacion ",$ob6, "",1);

log_agrega_detalle ($id_log, "Adjunto ",'<a href="../../enterproc/librerias/php/descarga_documentos_generales.php?n2='.$nombre_file1.'&n1='.$id_accion_amin.$_POST["id_item_pecc"].'&n3=4" target="grp">'.$nombre_file1.'</a>', "",2);
}else{
$sql_comple_elim = "";
}


$explode = explode("----,",$_POST["usuario_permiso"]);
$id_usuario = $explode[1];



/*elmimian urna virtual*/

if($_POST["acci8"] == 1){
$valor_accion = "SI Eliminar la Urna";	
$sql_comple_elim_urna = ", esta_en_e_procurement = 2";

}else{
$valor_accion = "NO";
$sql_comple_elim_urna = "";
} 

$insr6 = "insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item,adjunto) values ('".$sel_us_admin[1]."','$fecha','8. Eliminar Urna Virtual', '".$ob8."', '".$valor_accion."',".$id_item_pecc.",'' )";

$sql_ex=query_db($insr6.$trae_id_insrte);
$id_accion_amin = id_insert($sql_ex);



if($_POST["acci8"] == 1){

$nombre_file2="";
$campo_file_nombre2 = $_FILES["adjunto_para_eliminar_urna"]["name"];
$campo_file_temp2 = $_FILES["adjunto_para_eliminar_urna"]["tmp_name"];	

if($campo_file_nombre2 != ""){

$nombre_file2 = "elimina_urna"."_".$id_accion_amin."_".$campo_file_nombre1;
$copiar = carga_archivo($campo_file_temp2,'pecc/U'.$id_accion_amin.$_POST["id_item_pecc"]."_4");
$upda = query_db("update $pi19 set adjunto_elim_urna = '".$nombre_file2."' where id_accion_admin = ".$id_accion_amin);
}	

$id_log = log_de_procesos_sgpa(2, 40, 0, $id_item_pecc, 0, 0);//agrega valores
log_agrega_detalle ($id_log, "Observacion ",$ob8, "",1);

log_agrega_detalle ($id_log, "Adjunto ",'<a href="../../enterproc/librerias/php/descarga_documentos_generales.php?n2='.$nombre_file1.'&n1=U'.$id_accion_amin.$_POST["id_item_pecc"].'&n3=4" target="grp">'.$nombre_file2.'</a>', "",2);

}


/*fin elimina urna virtual*/


//ACTUALIZA ITEM
$updat = query_db("update $pi2 set id_us=".$id_usuario.", id_us_profesional_asignado='".$_POST["acci2"]."', tiempos_estandar='".$_POST["acci4"]."', congelado='".$_POST["acci5"]."', fecha_se_requiere='".$_POST["fecha"]."' $sql_comple_elim $sql_comple_elim_urna where id_item = ".$id_item_pecc);

//ACTUALIZA FIRMAS PROFESIONALES
$sel_secuencia_profesional = query_db(" select id_secuencia_solicitud from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = 8 and estado = 1");
while($sel_secu_prof = traer_fila_db($sel_secuencia_profesional)){
$selec_aprobacion = traer_fila_row(query_db("select count(*) from $pi16 where id_secuencia_solicitud = ".$sel_secu_prof[0]." and aprobado = 1"));
if($selec_aprobacion[0]<=0){
$delete_usuarios = query_db("delete from $pi15 where id_secuencia_solicitud = ".$sel_secu_prof[0]);
$inser_usuario = query_db("insert into $pi15 (id_secuencia_solicitud, id_usuario, estado) values (".$sel_secu_prof[0].",'".$_POST["acci2"]."', 1 ) ");
}

}
//FIN ACTUALIZA FIRMAS PROFESIONALES

//ACTUALIZA FIRMAS GESTOR DE SOCIOS
if($_POST["acci7"] <> 0){
$insr7 = query_db("insert into $pi19 (usuario_admin,fecha,detalle,observacion,accion, id_item) values ('".$sel_us_admin[1]."','$fecha','7. Cambiar Gestor de Socios para el Permiso', '".$ob7."', '".$sel_us_gestor_socios_permiso[1]."',".$id_item_pecc." )");

$sel_secuencia_profesional = query_db(" select id_secuencia_solicitud from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = 11 and estado = 1");
while($sel_secu_prof = traer_fila_db($sel_secuencia_profesional)){
$selec_aprobacion = traer_fila_row(query_db("select count(*) from $pi16 where id_secuencia_solicitud = ".$sel_secu_prof[0]." and aprobado = 1"));
if($selec_aprobacion[0]<=0){
$delete_usuarios = query_db("delete from $pi15 where id_secuencia_solicitud = ".$sel_secu_prof[0]);
$inser_usuario = query_db("insert into $pi15 (id_secuencia_solicitud, id_usuario, estado) values (".$sel_secu_prof[0].",'".$_POST["acci7"]."', 1 ) ");
}

}
}
//FIN ACTUALIZA FIRMAS GESTOR DE SOCIOS


$delete_tiempos_estandar = query_db("delete from $pi20 where id_item=".$id_item_pecc);
if($_POST["acci4"] == 1){
$sel_tiempos = query_db("select * from $vpeec21 where id_item = ".$id_item_pecc." order by actividad_estado_id");
while($s_t = traer_fila_db($sel_tiempos)){
$tiempo_no_est = elimina_comillas(arreglo_recibe_variables($_POST["tiem_no_est_".$s_t[1]]));
if($tiempo_no_est == ""){
$tiempo_no_est = 0;
}

$insert_t = query_db("insert into $pi20 (id_item, t2_nivel_servicio_actividad_id, tiempo) values (".$id_item_pecc.",".$s_t[1].",".$tiempo_no_est.")");
}
}


/*--------------- LOG -----------------*/
$id_log = log_de_procesos_sgpa(2, 38, 0, $id_item_pecc, 0, 0);//agrega valores
log_agrega_detalle ($id_log, "Gerente del Item / Solicitante",$id_usuario, "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Observacion Gerente del Item / Solicitante",$ob1, "",2);
log_agrega_detalle ($id_log, "Profesional Designado",$_POST["acci2"], "t1_us_usuarios",3);
log_agrega_detalle ($id_log, "Observacion Profesional Designado",$ob2, "",4);				
log_agrega_detalle ($id_log, "Fecha en la que se Requiere",$_POST["fecha"], "",5);
log_agrega_detalle ($id_log, "Observacion Fecha en la que se Requiere",$ob3, "",5);
log_agrega_detalle ($id_log, "Poner Tiempos Especiales",$poner_tiempos_especiales, "",6);
log_agrega_detalle ($id_log, "Observacion Poner Tiempos Especiales",$ob4, "",6);
log_agrega_detalle ($id_log, "Gestor de Socios",$_POST["acci7"], "t1_us_usuarios",7);
log_agrega_detalle ($id_log, "Observacion Gestor de Socios",$ob7, "",7);				
log_agrega_detalle ($id_log, "Estado del Proceso",$estado_pro_congela, "",8);
log_agrega_detalle ($id_log, "Observacion Estado del Proceso",$ob5, "",9);
/*--------------- LOG -----------------*/

?><script>alert("Los Cambios se Realizaron con Exito")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
}

if($_POST["accion"]=="firma_sistema_suaurio_adjudica"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_rol_aprueba = elimina_comillas(arreglo_recibe_variables($_POST["id_rol_aprueba"]));
$accion_aprueba = arreglo_recibe_variables($_POST["accion_aprueba_".$id_rol_aprueba]);
$observa = elimina_comillas_2($_POST["observa_".$id_rol_aprueba]);
$accion_aprueba = arreglo_recibe_variables($_POST["accion_aprueba_".$id_rol_aprueba]);

$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

$sel_secuencia = traer_fila_row(query_db("select * from $pi14 where id_rol=".$id_rol_aprueba." and id_item_pecc=".$id_item_pecc." and tipo_adj_permiso =2 and estado = 1"));

if($accion_aprueba == 1){
	$text_conflicto = $texto_declara_intereses."; ";
	}
	
if($_POST["conflito_intere_".$id_rol_aprueba] == 1){
$insert_conflicto = query_db("insert into t2_devolucion_item_conflicto_interes (id_item, id_us, rol, estado_item, devolucion, ob_devolicion, fecha) values ($id_item_pecc,".$_SESSION["id_us_session"].", '$id_rol_aprueba', '".$_POST["estado_item_peec"]."', 1, '".$observa."', '".$fecha."' )");
}

	
$insert = "insert into $pi16 (id_secuencia_solicitud, id_us,fecha, aprobado,observacion) values (".$sel_secuencia[0].",".$_SESSION["id_us_session"].", '$fecha', ".$accion_aprueba.",'".$text_conflicto.$observa."')";
$sql_ex=query_db($insert.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["adjunto_".$id_rol_aprueba]["name"];
$campo_file_temp1 = $_FILES["adjunto_".$id_rol_aprueba]["tmp_name"];	
$campo_file_nombre2 = $_FILES["adjunto2_".$id_rol_aprueba]["name"];
$campo_file_temp2 = $_FILES["adjunto2_".$id_rol_aprueba]["tmp_name"];
if($campo_file_nombre1 != ""){
$nombre_file1 = "firma-sistema-adjudica"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_4");
$upda = query_db("update $pi16 set adjunto1 = '".$nombre_file1."' where id_aprobacion = ".$id_ingreso);
}
if($campo_file_nombre2 != ""){
$nombre_file2 = "firma-sistema-adjudica"."_".$id_ingreso."_".$campo_file_nombre2;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file2);
$copiar = carga_archivo($campo_file_temp2,'pecc/'.$id_ingreso."_5");
$upda = query_db("update $pi16 set adjunto2 = '".$nombre_file2."' where id_aprobacion = ".$id_ingreso);
}

if($accion_aprueba == 2){

$sel_todas_las_secuencias = query_db("select * from $pi14 where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso =2 and id_rol not in (15)  and estado =1");
while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){

$update_aprobas = query_db("update $pi16 set aprobado = 0 where id_secuencia_solicitud = ".$sel_sucun[0]."");
}				
if($id_rol_aprueba == 11){//si es el gestor de socios
$sele_ultimo_comite = traer_fila_row(query_db("select max(id_comite) from $c2 where id_item=".$id_item_pecc." and estado = 1"));
$upda_2 = query_db("update $c2 set estado = 3 where id_comite =".$sele_ultimo_comite[0]." and id_item=".$id_item_pecc."");
}// fin si es el gestor de socios
agrega_gestion_pecc_atras($id_item_pecc, $_POST["estado_item_peec"], $fecha, 0,$observa);
$sel_estado = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3 where id_item=".$id_item_pecc." and actividad_estado_id < ".$_POST["estado_item_peec"]." and (t2_nivel_servicio_encargado_id = 2)"));
$estado_item = $sel_estado[0];
$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc);
$id_log = log_de_procesos_sgpa(2, 15, 40, $id_item_pecc, 16, $estado_item);//agrega valores				
log_agrega_detalle ($id_log, "Usuario que Devolvio el ITEM al Profesional",$_SESSION["id_us_session"] , "t1_us_usuarios",2);
log_agrega_detalle ($id_log, "Fecha",$fecha , "",3);

$sele_contras =query_db("select consecutivo,creacion_sistema, apellido, id from t7_contratos_contrato where id_item = ".$id_item_pecc." and estado=1");
while($mo=traer_fila_db($sele_contras)){
$delete = query_db("delete from t7_contratos_contrato where id=".$mo[3]);

$numero_contrato1 = "C";			
$separa_fecha_crea = explode("-",$mo[1]);
$ano_contra = $separa_fecha_crea[0];					
$numero_contrato2 = substr($ano_contra,2,2);
$numero_contrato3 = $mo[0];
$numero_contrato4 = $mo[2];

$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $mo[3]);
log_agrega_detalle ($id_log, "Se Elimino el CONTRATO, este no se encontraba en legalizacion por eso el numero se podra utilizar en futuros procesos", $num_impri , "",1);
}


$sele_contras =query_db("select consecutivo,creacion_sistema, apellido, id from t7_contratos_contrato where id_item = ".$id_item_pecc." and estado>1");
while($mo=traer_fila_db($sele_contras)){
//$update = query_db("update XXXX t7_contratos_contrato set where id = ".$mo[3]);
$delete = query_db("delete from t7_contratos_contrato where id=".$mo[3]);//esto toca quitarlo por que no se debe eliminar del todo

$numero_contrato1 = "C";			
$separa_fecha_crea = explode("-",$mo[1]);
$ano_contra = $separa_fecha_crea[0];					
$numero_contrato2 = substr($ano_contra,2,2);
$numero_contrato3 = $mo[0];
$numero_contrato4 = $mo[2];

$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $mo[3]);
log_agrega_detalle ($id_log, "Se Elimino el CONTRATO, Este se encontraba en lgalizacion por esto el numero no se podra utilizar en futuros procesos", $num_impri , "",1);
}
}
if($accion_aprueba == 1){
$id_log = log_de_procesos_sgpa(2, 15, 41, $id_item_pecc, 16, 16);//agrega valores
log_agrega_detalle ($id_log, "Usuario que Firmo",$_SESSION["id_us_session"] , "t1_us_usuarios",2);

$sel_todas_las_secuencias = query_db("select * from $pi14 where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol not in (8,15, 10, 11)  and estado =1");
$acabo_firmas="SI";
while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){
$sele_aprobar = traer_fila_row(query_db("select count(*) from $pi16 where id_secuencia_solicitud = ".$sel_sucun[0]." and aprobado = 1"));
if($sele_aprobar[0] == 0){
$acabo_firmas="NO";
}
}

if($acabo_firmas=="SI"){

$id_log = log_de_procesos_sgpa(2, 6, 42, $id_item_pecc, 16, $estado_item);//agrega valores
agrega_gestion_pecc($id_item_pecc, $_POST["estado_item_peec"], $fecha, 0);
$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item_pecc." and actividad_estado_id > ".$_POST["estado_item_peec"]));
$estado_item = $sel_estado[0];

if($sel_item[16]== "B" and ($estado_item == 16 or $estado_item == '')){
$estado_item = 32;
}

if($estado_item != 19){
$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc);
}
			$sel_que_aplica_procurement_contras = traer_fila_row(query_db("select esta_en_e_procurement,t1_tipo_proceso_id from $pi2 where id_item=".$id_item_pecc));

		if($estado_item == 19 or ($sel_que_aplica_procurement_contras[1] == 8 and $estado_item == 20) ){//SI YA PASO A SOLICITUD PAR, ENTONCS YA TERMINO

			if($sel_que_aplica_procurement_contras[1] <> 8){
				/*?><script>alert("Recuerde Realizar la Solicitud a Par Servicios")</script><?*/
			}

		$se_actuali_desierto=="";


$sel_desierto = traer_fila_row(query_db("select count(*) from t2_presupuesto as t1, t2_presupuesto_proveedor_adjudica as t2 where t1.t2_presupuesto_id = t2.t2_presupuesto_id and t1_tipo_documento_id = 4 and t1.t2_item_pecc_id = ".$id_item_pecc));
if($sel_desierto[0]>0 and $sel_desierto[0] <>""){
$update = query_db("update t2_item_pecc set solicitud_desierta = 1, estado=32 where id_item=".$id_item_pecc);
$se_actuali_desierto = "SI";
declarar_desierto_rene($id_item_pecc);
}





if($sel_que_aplica_procurement_contras[1] == 1 or $sel_que_aplica_procurement_contras[1] == 2 or $sel_que_aplica_procurement_contras[1] == 3 or $sel_que_aplica_procurement_contras[1] == 6 and $se_actuali_desierto==""){//SI APLICA EN Contratos

$es_marco = verifica_solicitud_marcos($id_item_pecc);

if($es_marco == "NO"){

crea_contratos($id_item_pecc);
}else{
crea_contratos_marco($id_item_pecc);
}
}

if($sel_que_aplica_procurement_contras[0] == 1){//SI APLICA EN EPROCUREMENT
//crear_en_e_procurement($id_item_pecc);//FUNCION PARA CREARLO EN EPROCUREMENT
}

if($sel_que_aplica_procurement_contras[1] == 4 or $sel_que_aplica_procurement_contras[1] == 5){//SI ES OTRO SI
crea_otro_si($id_item_pecc);
}
if($sel_que_aplica_procurement_contras[1] == 8){//SI ES OT
crea_ots($id_item_pecc);
}
if($sel_que_aplica_procurement_contras[1] == 7){//SI ES ampliacion
crea_ampliacion($id_item_pecc);
}
}//SI YA PASO A SOLICITUD PAR, ENTONCS YA TERMINO
}
}

if($accion_aprueba == 3){

$update = query_db("update t2_item_pecc set solicitud_rechazada = 1, estado=32 where id_item=".$id_item_pecc);

/* ----- Enviar notificacion por correo a todos los involucrados, segun el numero de Item Adjudicacion*/
        
envia_email_solicitudes($id_item_pecc, "usuario");

$id_log = log_de_procesos_sgpa(2, 15, 40, $id_item_pecc, 16, $estado_item);//agrega valores				
log_agrega_detalle ($id_log, "Usuario Rechazo el ITEM",$_SESSION["id_us_session"] , "t1_us_usuarios",2);
log_agrega_detalle ($id_log, "Fecha",$fecha , "",3);


$sele_contras =query_db("select consecutivo,creacion_sistema, apellido, id from t7_contratos_contrato where id_item = ".$id_item_pecc." and estado=1");
while($mo=traer_fila_db($sele_contras)){
$delete = query_db("delete from t7_contratos_contrato where id=".$mo[3]);

$numero_contrato1 = "C";			
$separa_fecha_crea = explode("-",$mo[1]);
$ano_contra = $separa_fecha_crea[0];					
$numero_contrato2 = substr($ano_contra,2,2);
$numero_contrato3 = $mo[0];
$numero_contrato4 = $mo[2];

$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $mo[3]);
log_agrega_detalle ($id_log, "Se Elimino el CONTRATO, este no se encontraba en legalizacion por eso el numero se podra utilizar en futuros procesos", $num_impri , "",1);
}


$sele_contras =query_db("select consecutivo,creacion_sistema, apellido, id from t7_contratos_contrato where id_item = ".$id_item_pecc." and estado=1");
while($mo=traer_fila_db($sele_contras)){
//$update = query_db("update XXXX t7_contratos_contrato set where id = ".$mo[3]);

$numero_contrato1 = "C";			
$separa_fecha_crea = explode("-",$mo[1]);
$ano_contra = $separa_fecha_crea[0];					
$numero_contrato2 = substr($ano_contra,2,2);
$numero_contrato3 = $mo[0];
$numero_contrato4 = $mo[2];

$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $mo[3]);
log_agrega_detalle ($id_log, "Se Elimino el CONTRATO, Este se encontraba en lgalizacion por esto el numero no se podra utilizar en futuros procesos", $num_impri , "",1);
}
}
?>
<script>
window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones_adjudicacion.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?php
}
if($_POST["accion"]=="firma_sistema_suaurio"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_rol_aprueba = elimina_comillas(arreglo_recibe_variables($_POST["id_rol_aprueba"]));		
$accion_aprueba = arreglo_recibe_variables($_POST["accion_aprueba_".$id_rol_aprueba]);
$observa = elimina_comillas_2($_POST["observa_".$id_rol_aprueba]);
$accion_aprueba = arreglo_recibe_variables($_POST["accion_aprueba_".$id_rol_aprueba]);

$sel_secuencia = traer_fila_row(query_db("select * from $pi14 where id_rol=".$id_rol_aprueba." and id_item_pecc=".$id_item_pecc." and tipo_adj_permiso =1 and estado = 1"));

if($accion_aprueba == 1){
	$text_conflicto = $texto_declara_intereses."; ";
	}

if($_POST["conflito_intere_".$id_rol_aprueba] == 1){
$insert_conflicto = query_db("insert into t2_devolucion_item_conflicto_interes (id_item, id_us, rol, estado_item, devolucion, ob_devolicion, fecha) values ($id_item_pecc,".$_SESSION["id_us_session"].", '$id_rol_aprueba', '".$_POST["estado_item_peec"]."', 1, '".$observa."', '".$fecha."' )");
}


$insert = "insert into $pi16 (id_secuencia_solicitud, id_us,fecha, aprobado,observacion) values (".$sel_secuencia[0].",".$_SESSION["id_us_session"].", '$fecha', ".$accion_aprueba.",'".$text_conflicto.$observa."')";
$sql_ex=query_db($insert.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["adjunto_".$id_rol_aprueba]["name"];
$campo_file_temp1 = $_FILES["adjunto_".$id_rol_aprueba]["tmp_name"];	
$campo_file_nombre2 = $_FILES["adjunto2_".$id_rol_aprueba]["name"];
$campo_file_temp2 = $_FILES["adjunto2_".$id_rol_aprueba]["tmp_name"];


if($campo_file_nombre1 != ""){
$nombre_file1 = "firma_sistema"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_4");
$upda = query_db("update $pi16 set adjunto1 = '".$nombre_file1."' where id_aprobacion = ".$id_ingreso);
}
if($campo_file_nombre2 != ""){
$nombre_file2 = "firma_sistema"."_".$id_ingreso."_".$campo_file_nombre2;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file2);
$copiar = carga_archivo($campo_file_temp2,'pecc/'.$id_ingreso."_5");
$upda = query_db("update $pi16 set adjunto2 = '".$nombre_file2."' where id_aprobacion = ".$id_ingreso);
}

if($accion_aprueba == 2){
$sel_todas_las_secuencias = query_db("select * from $pi14 where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso =1 and id_rol not in (15)  and estado =1");
while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){
$update_aprobas = query_db("update $pi16 set aprobado = 0 where id_secuencia_solicitud = ".$sel_sucun[0]);
}				
agrega_gestion_pecc_atras($id_item_pecc, $_POST["estado_item_peec"], $fecha, 0,$observa);
$estado_item = 6;
$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc);
if($id_rol_aprueba == 11){//si es el gestor de socios
$sele_ultimo_comite = traer_fila_row(query_db("select max(id_comite) from $c2 where id_item=".$id_item_pecc." and estado = 1"));
$upda_2 = query_db("update $c2 set estado = 3 where id_comite =".$sele_ultimo_comite[0]." and id_item=".$id_item_pecc."");
}// fin si es el gestor de socios

$id_log = log_de_procesos_sgpa(2, 6, 33, $id_item_pecc, 7, $estado_item);//agrega valores				
log_agrega_detalle ($id_log, "Usuario que Rechazo la Firma",$_SESSION["id_us_session"] , "t1_us_usuarios",2);

}
if($accion_aprueba == 1){
$id_log = log_de_procesos_sgpa(2, 6, 34, $id_item_pecc, 6, 6);//agrega valores
log_agrega_detalle ($id_log, "Usuario que Firmo",$_SESSION["id_us_session"] , "t1_us_usuarios",2);

$sel_todas_las_secuencias = query_db("select * from $pi14 where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso = 1 and id_rol not in (8,15, 10, 11)  and estado =1");
$acabo_firmas="SI";
while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){
$sele_aprobar = traer_fila_row(query_db("select count(*) from $pi16 where id_secuencia_solicitud = ".$sel_sucun[0]." and aprobado = 1"));
if($sele_aprobar[0] == 0){
$acabo_firmas="NO";
echo $acabo_firmas;
}
}



if($acabo_firmas=="SI"){
agrega_gestion_pecc($id_item_pecc, $_POST["estado_item_peec"], $fecha, 0);
$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item_pecc." and actividad_estado_id > ".$_POST["estado_item_peec"]));
$estado_item = $sel_estado[0];



if($estado_item==10){
$estado_item=11;
agrega_gestion_pecc($id_item_pecc, 10, $fecha, 1500);
}


$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc);

$id_log = log_de_procesos_sgpa(2, 6, 35, $id_item_pecc, 6, $estado_item);//agrega valores
}
}

if($accion_aprueba == 3){

$update = query_db("update t2_item_pecc set solicitud_rechazada = 1, estado=32 where id_item=".$id_item_pecc);
envia_email_solicitudes($id_item_pecc, "usuario");

$id_log = log_de_procesos_sgpa(2, 15, 40, $id_item_pecc, 16, $estado_item);//agrega valores				
log_agrega_detalle ($id_log, "Usuario Rechazo el ITEM",$_SESSION["id_us_session"] , "t1_us_usuarios",2);
log_agrega_detalle ($id_log, "Fecha",$fecha , "",3);


}
?>
<script>
window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}
if($_POST["accion"]=="nivel_anterior_sondeo"){

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$observa_atras = arreglo_recibe_variables($_POST["observa_atras"]);
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

$estado_actual = $sel_item[14];
;

agrega_gestion_pecc_atras($id_item_pecc, $estado_actual, $fecha, 0,$observa_atras);
$sel_estado = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3 where id_item=".$id_item_pecc." and actividad_estado_id < ".$estado_actual."  and (t2_nivel_servicio_encargado_id = 1 or t2_nivel_servicio_encargado_id = 2)"));
$estado_item = $sel_estado[0];
if($estado_item == 1){
$estado_item = 31;
}

$update_nivel = query_db("update $pi2 set estado = ".$estado_item." where id_item=".$id_item_pecc);




?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="nivel_anterior_negociacion"){

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$observa_atras = arreglo_recibe_variables($_POST["observa_atras"]);
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

$estado_actual = $sel_item[14];


agrega_gestion_pecc_atras($id_item_pecc, $estado_actual, $fecha, 0,$observa_atras);
$sel_estado = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3 where id_item=".$id_item_pecc." and actividad_estado_id < ".$estado_actual." and actividad_estado_id > 9 and (t2_nivel_servicio_encargado_id = 1 or t2_nivel_servicio_encargado_id = 2)"));
$estado_item = $sel_estado[0];

$update_nivel = query_db("update $pi2 set estado = ".$estado_item." where id_item=".$id_item_pecc);


$id_log = log_de_procesos_sgpa(1, 22, 0, $id_item_pecc, $estado_actual, $estado_item);//agrega valores
log_agrega_detalle ($id_log, "Fecha de Devoluvion", $fecha , "",1);
log_agrega_detalle ($id_log, "Tipo", "devolucion" , "",2);


?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?
}



if($_POST["accion"]=="siguiente_nivel"){

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
$estado_actual = $sel_item[14];
$id_tipo_contratacion = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_contratacion"]));


/*reclasificaciones contrato marco*/

if($sel_item[6]==12 and $sel_item[14]==6){
	
		if($sel_item[21]==""){
			?><script>alert("Para poder poner en firme la reclasificacion debe seleccionar un contrato")</script>
            <script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
			<?
			exit;
			}
$sel_tipo_reclasificacion = traer_fila_row(query_db("select t1_tipo_documento_id, id_item from t7_contratos_contrato where id=".$sel_item[21]));

	if($sel_tipo_reclasificacion[0] == 2) {
$sel_valor_1 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from t2_presupuesto where t2_item_pecc_id=".$id_item_pecc." and al_valor_inicial_para_marco is null "));

		$valor_1 = number_format($sel_valor_1[0] + ($sel_valor_1[1]/$trm=trm_presupuestal()), 0);
		$sel_valor_2 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from t2_presupuesto where t2_item_pecc_id=".$id_item_pecc." and al_valor_inicial_para_marco =1 "));
		$valor_2 = number_format($sel_valor_2[0] + ($sel_valor_2[1]/$trm=trm_presupuestal()), 0);
		echo "***".$valor_1." = ".$valor_2;
		if($valor_1 !=$valor_2){
			?><script>alert("Para poder poner en firme la reclasificacion el valor que solicita reclasificar debe ser el mismo que distribuye para reclasificar")</script>
            <script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
			<?
			exit;
			}
	}
}
/*reclasificaciones*/

/*VERIFICA QUE LA FECHA NO SEA MAYOR A LA DEL COMPLETAMIENTO DE LA SOLICITUD*/
if($sel_item[7] < $fecha and $sel_item[14]==6){
	?><script >alert("No se puede poner en firme la solicitud por que la fecha en la que se requiere el servicio / Bien, es anterior a hoy, por favor modifiquela para poder continuar");
			window.parent.document.getElementById("cargando_pecc").style.display = "none";
		</script><?
		exit;
}
/*VERIFICA QUE LA FECHA NO SEA MAYOR A LA DEL COMPLETAMIENTO DE LA SOLICITUD*/

/*VERIFICA SI ES UN OTRO SI QUE SEA OBLIGATORIO EL ANTECEDENTE PARA COMITE*/
if(($sel_item[6]==5 or $sel_item[6]== 7 or $sel_item[6]==15 or $sel_item[6]==16) and $sel_item[14]==6){
	if($sel_item[54]=="" or $sel_item[54]==" " or $sel_item[54]=="  " or $sel_item[54]=="	" or $sel_item[54]=="   "){
		?><script >alert("No se puede poner en firme la solicitud por que es obligatorio incluir el antecedente, el cual se mostrara en el comite");
			window.parent.document.getElementById("cargando_pecc").style.display = "none";
		</script><?
		exit;
		}
	}
/*VERIFICA SI ES UN OTRO SI QUE SEA OBLIGATORIO EL ANTECEDENTE PARA COMITE*/

/*VERIFICA SI ES adjudicacion QUE SEA OBLIGATORIO EL ANTECEDENTE PARA COMITE*/
if(($sel_item[6]==1 or $sel_item[6]== 2 or $sel_item[6]==3 or $sel_item[6]==6 or $sel_item[6]==15) and $sel_item[14]==14){
	if($sel_item[55]=="" or $sel_item[55]==" " or $sel_item[55]=="  " or $sel_item[55]=="	" or $sel_item[55]=="   "){
		?><script >alert("No se puede poner en firme la solicitud por que es obligatorio incluir el antecedente, el cual se mostrara en el comite");
			window.parent.document.getElementById("cargando_pecc").style.display = "none";
		</script><?
		exit;
		}
	}
/*VERIFICA SI ES UN OTRO SI QUE SEA OBLIGATORIO EL ANTECEDENTE PARA COMITE*/


if($sel_item[6]==16 and ($estado_actual>=6 and $estado_actual<16)){// si es servicios menores
		
	$sel_presu = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id =".$id_item_pecc." and permiso_o_adjudica = 1"));
	$valor_solicitud = $sel_presu[0] + ($sel_presu[1]/trm_actual());
	
	if($valor_solicitud <=0 or $valor_solicitud >$_SESSION["valor_maximo_ser_menor"]){
	$text_arr_ser_men1= " > Debe ingresar el valor del servicio menor entre USD$ 1 y ".number_format($_SESSION["valor_maximo_ser_menor"],0).", usted esta solicitando USD$ ".$valor_solicitud." ";
	}
	
	
$sel_proveedores_adjudicad = traer_fila_row(query_db("select * from t2_relacion_proveedor where id_item =".$id_item_pecc." and es_adjudicado = 1"));

$comple_sql_validacion_2500="";

if($estado_actual==13 and $sel_proveedores_adjudicad[0]>0){// si ya es el ultimo pasao para pasar a firmas osea negociacion validar que el proveedor adjudicado tenga disponible
	$comple_sql_validacion_2500 = " and es_adjudicado = 1";
	}
	
	$sel_proveedores = traer_fila_row(query_db("select count(*) from t2_relacion_proveedor where id_item =".$id_item_pecc.""));
	if($sel_proveedores[0]==0){
	$text_arr_ser_men2 = " > Debe ingresar por lo menos un proveedor.";	
		}else{
				$algun_proveedor_arriba_25000="NO";
				$sel_proveedores_lista = query_db("select * from t2_relacion_proveedor where id_item =".$id_item_pecc." ".$comple_sql_validacion_2500);
				while($sel_p_list = traer_fila_db($sel_proveedores_lista)){
					$valores_sm = 0;					
					$valores_sm = explode("*",disponible_serv_menor_ano_atras($sel_p_list[2], $id_item_pecc));
					//[0]=total_comprometido --- [1]=comprometido_sap --- [2]=comprometido_no_sap --- [3]=valor_solicitud_Actual --- [4] Disponible
					echo $valores_sm[4]."<br>";
					if($valores_sm[4] < 0){
						$algun_proveedor_arriba_25000="SI";
						}					
					}
					if($algun_proveedor_arriba_25000 == "SI"){
						$nuevafecha_menos_un_ano = strtotime ( '-1 year' , strtotime ( $fecha ) ) ; 
						$nuevafecha_menos_un_ano =   date ( 'Y-m-j' , $nuevafecha_menos_un_ano );
						
						if($estado_actual==13){// si ya es el ultimo pasao para pasar a firmas osea negociacion validar que el proveedor adjudicado tenga disponible
						$text_arr_ser_men3 = "NO PUEDE CONTINUAR: por que el proveedor adjudicado ".saca_nombre_lista("t1_proveedor",$sel_proveedores_adjudicad[2],'razon_social','t1_proveedor_id')." supera el monto permitido para crear servicios menores de USD$ ".number_format($_SESSION["valor_maximo_ser_menor"],0)." anuales a partir de ".$nuevafecha_menos_un_ano." .";	
						}else{
						$text_arr_ser_men3 = " > Algunos proveedores no tienen disponible para crear servicios menores por favor verificar el reporte en el link 'Proveedores - Reporte Servicios Menores'.";	
						}
						}
	}
		
	/*SI ES NEGOCIACION VERIFICA ESTADO 13*/
if($estado_actual == 13){
$cuantos_roles_aprov= traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol  in (48,45,43,20,9) and estado = 1"));
if($cuantos_roles_aprov[0] <=0){
?><script>alert("Todos los procesos deben tener nivel de aprobacion (I, II, III, IV)")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}
$cuantos_roles= traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol  not in (8,15,10,11) and estado = 1"));
$secuencia_solicitante=0;
$sele_secuencia = query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and estado =1");
while($sel_secu = traer_fila_db($sele_secuencia)){
if($sel_secu[2]==23){
$secuencia_gerente = $sel_secu[0];
}
if($sel_secu[2]==15){
$secuencia_solicitante = $sel_secu[0];
}
$sele_cuanto = traer_fila_row(query_db("select count(*) from $pi15 where id_secuencia_solicitud = ".$sel_secu[0]." and estado = 1"));
if($sele_cuanto[0] <=0){
?>
<script>alert("Uno de los roles no tiene usuarios asignados")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}

}


	if($sel_proveedores_adjudicad[0]==0){
	$text_arr_ser_men4 = "Debe ingresar por lo menos un proveedor ADJUDICADO  -- .";	
		}
		
}
	/*SI ES NEGOCIACION VERIFICA ESTADO 13*/
	}

if($text_arr_ser_men1 != "" or $text_arr_ser_men2 != "" or $text_arr_ser_men3 != "" or $text_arr_ser_men4 != ""){

		
		
		?><script >
			alert("No se puede poner en firme la solicitud por que\n <?=$text_arr_ser_men1?>\n<?=$text_arr_ser_men2?>\n<?=$text_arr_ser_men3?>\n<?=$text_arr_ser_men4?>");
			window.parent.document.getElementById("cargando_pecc").style.display = "none";
		</script><?
		exit;

	}
	
	
	// FIN si es servicios menores
	
	
	




if($estado_actual == 14 or ($sel_item[6]==15 and ($estado_actual == 31 or $estado_actual == 6))){//el or es para que verifique cuando es una modificacion tambien
$text_arr="";
$sele_presupuesto = traer_fila_row(query_db("select count(*) from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."'"));

if($sele_presupuesto[0]<=0){

$sele_presupuesto_marco = traer_fila_row(query_db("select * from $vpeec25 where t2_item_pecc_id ='".$id_item_pecc."'"));
$sele_presupuesto_prove_marco = traer_fila_row(query_db("select count(*) from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$id_item_pecc."' and t1.t1_proveedor_id =  t2.t1_proveedor_id"));


if($sele_presupuesto_marco[0]<=0 or $sele_presupuesto_prove_marco[0]<=0){
$text_arr = "La Adjudicacion esta Incompleta, verifique el presupuesto y los proveedores";
}





if($text_arr <> ""){
?><script>alert("<?= $text_arr ?>")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
exit;
}

}


}


if($estado_actual == 6){
$sel_si_existe_objetivos = traer_fila_row(query_db("select * from t2_objetivos_proceso where id_item = ".$id_item_pecc));

if((($sel_si_existe_objetivos[2]=="" or strlen($sel_si_existe_objetivos[2]) < 20) or ($sel_si_existe_objetivos[3]=="" or strlen($sel_si_existe_objetivos[3]) < 20) or ($sel_si_existe_objetivos[4]==""  or strlen($sel_si_existe_objetivos[4]) < 20) or ($sel_si_existe_objetivos[5]==""  or strlen($sel_si_existe_objetivos[5]) < 20) or ($sel_si_existe_objetivos[6]==""  or strlen($sel_si_existe_objetivos[6]) < 20) or ($sel_si_existe_objetivos[7]==""  or strlen($sel_si_existe_objetivos[7]) < 20) or ($sel_si_existe_objetivos[8]=="" or strlen($sel_si_existe_objetivos[8]) < 20)) and ($sel_item[6]==1 or $sel_item[6]==2 or $sel_item[6]==3 or $sel_item[6]==5 or $sel_item[6]==13 or $sel_item[6]==14 or $sel_item[6]==7 or $sel_item[6]==15) ){
$text_arr_objetivos = "No se puede poner en firme, debe completar los objetivos del proceso, cada uno de estos deben tener por lo menos 20 caracteres.";
}


if($sel_item[50] == ""){


//$text_arr_objetivos = "Debe digitar los conflictos de intereses";

}	
//VERIFICA QUE TENGA PROVEEDORES RELACIONADOS
if($sel_item[6]==1 or $sel_item[6]==2 or $sel_item[6]==3 or $sel_item[6]==17){//si es negociacion o licitacion
	$sel_prove_selecciona = traer_fila_row(query_db("select count(*) from t2_relacion_proveedor where id_item = ".$id_item_pecc." and estado = 1"));
	if($sel_prove_selecciona[0]<=0){
	?><script>alert("Es obligatorio incluir por lo menos un proveedor")</script>
	<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
	exit;						
	}	
}
//FIN VERIFICA QUE TENGA PROVEEDORES RELACIONADOS
}

if($estado_actual == 14){
$sel_si_existe_objetivos = traer_fila_row(query_db("select * from t2_objetivos_proceso where id_item = ".$id_item_pecc));

if(( ($sel_si_existe_objetivos[9]=="" or strlen($sel_si_existe_objetivos[9]) < 20) or ($sel_si_existe_objetivos[10]=="" or strlen($sel_si_existe_objetivos[10]) < 20) or ($sel_si_existe_objetivos[11]=="" or strlen($sel_si_existe_objetivos[11]) < 20) or ($sel_si_existe_objetivos[12]=="" or strlen($sel_si_existe_objetivos[12]) < 20) or ($sel_si_existe_objetivos[13]=="" or strlen($sel_si_existe_objetivos[13]) < 20) or ($sel_si_existe_objetivos[14]=="" or strlen($sel_si_existe_objetivos[14]) < 20) or ($sel_si_existe_objetivos[15]=="" or strlen($sel_si_existe_objetivos[15]) < 20)) and ($sel_item[6]==1 or $sel_item[6]==2 or $sel_item[6]==3 or $sel_item[6]==5 or $sel_item[6]==13 or $sel_item[6]==14 or  $sel_item[6]==7 or $sel_item[6]==15 or $sel_item[6]==6) ){
$text_arr_objetivos = "No se puede poner en firme, debe completar los objetivos del proceso de la Adjudicacion, cada uno de estos deben tener por lo menos 20 caracteres";
}

}

if($text_arr_objetivos <> ""){
?><script>alert("<?= $text_arr_objetivos ?>")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
exit;
}


/*---------tipo de proceso modificaciones*/
if($sel_item[6]==15 and $estado_actual==31){
	echo "acacacaca";
$campo1 = elimina_comillas_2($_POST["objeto_contrato"]);
$campo2 = elimina_comillas_2($_POST["alcance"]);
$campo3 = elimina_comillas_2($_POST["justificacion"]);
$campo3_2 = elimina_comillas_2($_POST["justificacion2"]);
$campo4 = elimina_comillas_2($_POST["recomendacion"]);
$campo5 = elimina_comillas_2($_POST["objeto_solicitud"]);

$oportunidad = elimina_comillas_2($_POST["campos1"]);
$costo_bene = elimina_comillas_2($_POST["campos2"]);
$calidad = elimina_comillas_2($_POST["campos3"]);
$opt_riesgos = elimina_comillas_2($_POST["campos4"]);
$trazabilidad = elimina_comillas_2($_POST["campos5"]);
$transparencia = elimina_comillas_2($_POST["campos6"]);
$sostenibilidad = elimina_comillas_2($_POST["campos7"]);



$comple_upda = ", fecha_se_requiere='".$_POST["fecha"]."', t1_tipo_proceso_id='".$_POST["tipo_proceso"]."', t1_area_id='".$_POST["area_usuaria"]."'";
$upda = query_db("update $pi2 set ob_contrato_adjudica = '".$campo1."', alcance_adjudica = '".$campo2."', justificacion_adjudica = '".$campo3."', justificacion_tecnica_ad='".$campo3_2."', recomendacion_adjudica = '".$campo4."', ob_solicitud_adjudica = '".$campo5."', aprobacion_comite_adicional = ".$_POST["req_comite"].", requiere_socios_adicional = '".$_POST["req_socios"]."' $comple_upda where id_item = ".$id_item_pecc);
$upda_permiso = query_db("update $pi2 set objeto_contrato = '".$campo1."', alcance = '".$campo2."', justificacion = '".$campo3."', justificacion_tecnica ='".$campo3_2."', recomendacion = '".$campo4."', objeto_solicitud = '".$campo5."' where id_item = ".$id_item_pecc);

$update_objetivos = query_db("update t2_objetivos_proceso set p_oportunidad='".$oportunidad."', p_costo='".$costo_bene."', p_calidad='".$calidad."', p_optimizar='".$opt_riesgos."', p_trazabilidad='".$trazabilidad."', p_transparencia='".$transparencia."', p_sostenibilidad='".$sostenibilidad."', a_oportunidad='".$oportunidad."', a_costo='".$costo_bene."', a_calidad='".$calidad."', a_optimizar='".$opt_riesgos."', a_trazabilidad='".$trazabilidad."', a_transparencia='".$transparencia."', a_sostenibilidad='".$sostenibilidad."' where id_item =".$id_item_pecc);

//BUSCA Y SELEECIONA EL PROFESIONAL ENCARGADO
if($sel_item[42] == 0 or $sel_item[42] == ""){
$id_usuario_gerente = $_SESSION["id_us_session"];
}else{
$id_usuario_gerente = $sel_item[42];	
}

$sel_profss_especifico_usuario_area = traer_fila_row(query_db("select id_us_profesional, id_us_prof_compras_corp, id_us_prof_compras_mro, id_us_prof_compras_stok from tseg10_usuarios_profesional where id_area = ".$_POST["area_usuaria"]." and id_us =  '$id_usuario_gerente'"));

$profesional_asig=0;

$el_gerente = saber_gerente_cotrato($id_item_pecc);
$sele_permiso = traer_fila_row(query_db("select * from $v_seg1 where us_id = ".$el_gerente." and id_premiso = 30"));//verificar si es el profesioanl de compras nanky


if($id_tipo_proceso_pecc==1){//profesional de servicios
$profesional_asig= $sel_profss_especifico_usuario_area[0];
}else{//profesional de compras
if($id_tipo_proceso_pecc==2){
$profesional_asig= $sel_profss_especifico_usuario_area[2];
}
if($id_tipo_proceso_pecc==3){
$profesional_asig= $sel_profss_especifico_usuario_area[3];
}
if($id_tipo_proceso_pecc==4){
$profesional_asig= $sel_profss_especifico_usuario_area[1];
}

}


if($profesional_asig>0){
$profesional_seleccionado = $profesional_asig;

}else{

$sele_si_es_profesional = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos where id_usuario=".$_SESSION["id_us_session"]." and id_permiso = 8"));
	if($sele_si_es_profesional[0] > 0){//si el solicitante tiene permiso de profesional
		$profesional_seleccionado = $_SESSION["id_us_session"];
	}
}
$upda_item = query_db("update $pi2 set id_us_profesional_asignado = ".$profesional_seleccionado." where id_item=".$id_item_pecc);
$estado_actual = 1;
/*Verifica los objetivos del proceso*/
$sel_si_existe_objetivos = traer_fila_row(query_db("select * from t2_objetivos_proceso where id_item = ".$id_item_pecc));
if( ($sel_si_existe_objetivos[9]=="" or strlen($sel_si_existe_objetivos[9]) < 20)  or ($sel_si_existe_objetivos[11]=="" or strlen($sel_si_existe_objetivos[11]) < 20)  ){

?><script>alert("No se puede poner en firme, debe completar los objetivos del proceso de la Adjudicacion, cada uno de estos deben tener por lo menos 20 caracteres")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
exit;
}
/* FIN Verifica los objetivos del proceso*/


}
/*---------tipo de proceso modificaciones*/

/*
if(($estado_actual == 6 or $estado_actual == 14)){//si la justificacion comercial es basia
if(($sel_item[12]=="" or $sel_item[12]==" " or $sel_item[12]=="   ") and ($sel_item[33]=="" or $sel_item[33]==" " or $sel_item[33]=="   ")){
$text_arr = "La Adjudicacion esta Incompleta, Digitar la Justificacion Comercial";	
if($text_arr <> ""){
?><script>alert("<?= $text_arr ?>")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
exit;
}
}

}
*/

if($estado_actual == 6 and ($sel_item[6]==8 or $sel_item[6]==7) and solicitud_bienes($sel_item[26]) == "SI"){//si es completamiento y es OT y si incluyer contratos de bienes

if($sel_item[53] == "" or $sel_item[53] == " " or $sel_item[53] == "  " or $sel_item[53] == "	" or $sel_item[53] == "          "){
	$text_arr = "La Adjudicacion esta Incompleta, debe digitar la justificacion del presupuesto";
	}
}



if($estado_actual == 6 and $sel_item[6]==8 and $text_arr == ""){//si es completamiento y es OT
$sel_si_tiene_correos = traer_fila_row(query_db("select count(*) from t2_item_ot_correo_relacion_item where id_item = $id_item_pecc "));
if($sel_si_tiene_correos[0]==0){
$text_arr = "La Adjudicacion esta Incompleta, debe seleccionar por lo menos un correo del contratista para enviar la OT";
}
}

if($text_arr <> ""){
?><script>alert("<?= $text_arr ?>")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
exit;
}

//BUSCA SI TIENE SEGUNDAS FIRMAS PERO NO PRIMERAS
$sele_si_aplica_permiso = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item_pecc." and actividad_estado_id = 7"));
$sele_si_aplica = traer_fila_row(query_db("select * from $vpeec3 where id_item = ".$id_item_pecc." and actividad_estado_id = 16"));
$muestra = "NO";
if($sele_si_aplica_permiso[0] <=0 and $sele_si_aplica[0]>=0 and $estado_actual == 6){
$muestra = "SI";
/*
// Valida si es una modificacion y si tiene una solicitud relacionada, si es asi no debe eliminar el presupuesto de la adjudicacion.
if($sel_item['t1_tipo_proceso_id'] == 15 && $sel_item['id_solicitud_relacionada']){
	//No elimina el presupuesto de la adjudicacion = 2
}else{
	$sel_presu = query_db("delete from $pi8 where t2_item_pecc_id =".$id_item_pecc." and permiso_o_adjudica = 2");
}
	*/
if($sel_item[6] <> 15){//si no es modificacion
	$elimina_reg = query_db("delete from $pi8 where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2");
	$sel_presu = query_db("select * from $pi8 where t2_item_pecc_id =".$id_item_pecc." and permiso_o_adjudica = 1");
	while($se_prees = traer_fila_db($sel_presu)){
	$update_presu = query_db("insert into $pi8 (t2_item_pecc_id,t1_campo_id,aleatorio,adjunto,valor_usd,valor_cop,ano,permiso_o_adjudica) values ('".$se_prees[1]."','".$se_prees[2]."','".$se_prees[3]."','".$se_prees[4]."','".$se_prees[5]."','".$se_prees[6]."','".$se_prees[7]."',2)");
	}
}
}
//fIN BUSCA FIRMAS


if($estado_actual == 6 and $muestra == "NO"){
$secuencia_solicitante=0;
echo "select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1 and id_rol  in (48,45,43,20,9) and estado = 1";
$cuantos_roles_aprov= traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1 and id_rol  in (48,45,43,20,9) and estado = 1"));
if($cuantos_roles_aprov[0] <=0){
?><script>alert("Todos los procesos deben tener nivel de aprobacion (I, II, III, IV)")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}

$cuantos_roles= traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1 and id_rol  not in (8,15,10,11) and estado = 1"));
$sele_secuencia = query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1  and estado =1");
while($sel_secu = traer_fila_db($sele_secuencia)){

if($sel_secu[2]==23){
$secuencia_gerente = $sel_secu[0];
}

if($sel_secu[2]==15){
$secuencia_solicitante = $sel_secu[0];
}

$sele_cuanto = traer_fila_row(query_db("select count(*) from $pi15 where id_secuencia_solicitud = ".$sel_secu[0]." and estado = 1"));
if($sele_cuanto[0] <=0){
?><script>alert("Uno de los roles no tiene usuarios asignados")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}



}

//VERIFICA QUE EL GERENTE DEL ITEM NO SEA EL MISMO JEFE QUE APRUEBA

$sel_usua_solictante = traer_fila_row(query_db("select id_usuario from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = '".$secuencia_solicitante."' "));




$sel_sql_roles_repetidos = traer_fila_row(query_db("select * from $pi14 as t1, t2_agl_secuencia_solicitud_usuario as t2 where t1.id_item_pecc = ".$id_item_pecc." and t1.id_secuencia_solicitud = t2.id_secuencia_solicitud  and t1.tipo_adj_permiso = 1 and t1.id_rol in (9,20,45, 43, 16, 22) and t1.estado = 1 and t2.id_usuario = ".$sel_usua_solictante[0]." AND t2.estado= 1"));


if($sel_sql_roles_repetidos[0]>0){
?><script>alert("Solicitante no puede firmar a su vez como gerente de activo, tampoco como nivel de aprobacion")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
	exit;
}

//FIN VERIFICA QUE EL GERENTE DEL ITEM NO SEA EL MISMO JEFE QUE APRUEBA

//VERIFICA QUE TENGA PROVEEDORES RELACIONADOS	
$sel_prove_selecciona = traer_fila_row(query_db("select count(*) from t2_relacion_proveedor where id_item = ".$id_item_pecc." and estado = 1"));
if($sel_prove_selecciona[0]<=0 and ($sel_item[11] == "" or $sel_item[11] == " ")){
?><script>alert("Es obligatorio incluir por lo menos un proveedor")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;						
}	
//FIN VERIFICA QUE TENGA PROVEEDORES RELACIONADOS



$sel_usuario_gerente_igual_profesioanl = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = '".$secuencia_gerente."' and id_usuario = ".$_SESSION["id_us_session"]));

if($sel_usuario_gerente_igual_profesioanl[0]>0){
$insert_aprobacion = query_db("insert into $pi16 (id_secuencia_solicitud,id_us,fecha,aprobado) values (".$secuencia_gerente.", ".$_SESSION["id_us_session"].",'".$fecha."',1)");	
}



/*----------------validacion de reemplazos----------*/
if($estado_actual == 6 and ($sel_item[6] == 1 or $sel_item[6] == 2 or $sel_item[6] == 3)){
	echo "select t1.id_rol, t2.id_usuario  from t2_agl_secuencia_solicitud as t1, t2_agl_secuencia_solicitud_usuario as t2 where t1.id_item_pecc= ".$sel_item[0]." and  t1.id_secuencia_solicitud = t2.id_secuencia_solicitud and t1.id_rol in (35,45,9,20,43) and t1.tipo_adj_permiso = 1 and t2.estado = 1 and t1.estado = 1";
	$sel_roles_niveles_aprobacion = query_db("select t1.id_rol, t2.id_usuario  from t2_agl_secuencia_solicitud as t1, t2_agl_secuencia_solicitud_usuario as t2 where t1.id_item_pecc= ".$sel_item[0]." and  t1.id_secuencia_solicitud = t2.id_secuencia_solicitud and t1.id_rol in (35,45,9,20,43) and t1.tipo_adj_permiso = 1 and t2.estado = 1 and t1.estado = 1");
}
	if($sel_roles_niveles_aprobacion!=""){
	while($sel_n_apro = traer_fila_db($sel_roles_niveles_aprobacion)){
		$id_solicitante = $sel_item[3];
		if($sel_item[6] == 8){
			$id_solicitante = $sel_item[42];
			}
		if($sel_n_apro[0] == 35 or $sel_n_apro[0] == 45){//jefatura
				$sel_aprobador_correcto = traer_fila_row(query_db("select id_superintendente from tseg14_relacion_usuario_superintendente where id_us = $id_solicitante and id_area = ".$sel_item[5]));				
				if($sel_aprobador_correcto[0]!= 0 and ($sel_aprobador_correcto[0] != $sel_n_apro[1])){
					$texto_declara_intereses.="; El usuario encargado de abastecimiento relaciono un reemplazo en el nivel de aprobacion Jefaura cambio a ".traer_nombre_muestra($sel_aprobador_correcto[0], $g1,"nombre_administrador","us_id")." por ".traer_nombre_muestra($sel_n_apro[1], $g1,"nombre_administrador","us_id").", este fue verificado por el mismo en la cartelera de intranet ";
					}
			}
		if($sel_n_apro[0] == 9){//gerente de area
				$sel_aprobador_correcto = traer_fila_row(query_db("select id_jefe_area from tseg13_relacion_usuario_jefe where id_us = $id_solicitante and id_area = ".$sel_item[5]));				
				if($sel_aprobador_correcto[0]!= 0 and ($sel_aprobador_correcto[0] != $sel_n_apro[1])){
					$texto_declara_intereses.="; El usuario encargado de abastecimiento relaciono un reemplazo en el nivel de aprobacion Gerente de Area cambio a ".traer_nombre_muestra($sel_aprobador_correcto[0], $g1,"nombre_administrador","us_id")." por ".traer_nombre_muestra($sel_n_apro[1], $g1,"nombre_administrador","us_id").", este fue verificado por el mismo en la cartelera de intranet ";
					}
			}
		if($sel_n_apro[0] == 20){//vicepresidente
				$sel_aprobador_correcto = traer_fila_row(query_db("select id_vicepresidente from tseg15_relacion_usuario_vicepresidente where id_us = $id_solicitante and area = ".$sel_item[5]));				
				if($sel_aprobador_correcto[0]!= 0 and ($sel_aprobador_correcto[0] != $sel_n_apro[1])){
					$texto_declara_intereses.="; El usuario encargado de abastecimiento relaciono un reemplazo en el nivel de aprobacion Vicepresidente cambio a ".traer_nombre_muestra($sel_aprobador_correcto[0], $g1,"nombre_administrador","us_id")." por ".traer_nombre_muestra($sel_n_apro[1], $g1,"nombre_administrador","us_id").", este fue verificado por el mismo en la cartelera de intranet ";
					}
			}
		if($sel_n_apro[0] == 43){//director
				$sel_aprobador_correcto = traer_fila_row(query_db("select id_director from tseg15_relacion_usuario_director where id_us = $id_solicitante and id_area = ".$sel_item[5]));				
				if($sel_aprobador_correcto[0]!= 0 and ($sel_aprobador_correcto[0] != $sel_n_apro[1])){
					$texto_declara_intereses.="; El usuario encargado de abastecimiento relaciono un reemplazo en el nivel de aprobacion Director cambio a ".traer_nombre_muestra($sel_aprobador_correcto[0], $g1,"nombre_administrador","us_id")." por ".traer_nombre_muestra($sel_n_apro[1], $g1,"nombre_administrador","us_id").", este fue verificado por el mismo en la cartelera de intranet ";
					}
			}
			
			
		}	
	}
	
	/*----------------FIN -validacion de reemplazos----------*/

$insert_aprobacion = query_db("insert into $pi16 (id_secuencia_solicitud,id_us,fecha,aprobado, observacion) values (".$_POST["id_secuencia"].", ".$_SESSION["id_us_session"].",'".$fecha."',1,'".$texto_declara_intereses."')");

$actualiza_2 = query_db("update $pi14 set por_sistema = 2 where id_item_pecc=".$id_item_pecc." and tipo_adj_permiso = 1");

//se busca el nivel de servicios y se actualiza solo si es el profecional en el estado 6 completamiento

valida_firmas_que_estan_creadas_permiso($id_item_pecc);
$actualiza_2 = query_db("update $pi14 set por_sistema = 2 where id_item_pecc=".$id_item_pecc." and tipo_adj_permiso = 1");



/*$sele_nivel_actual = traer_fila_row(query_db("select * from $vpeec2 where id_item = ".$id_item_pecc.""));			
$update_cambia_nivel_servicio = query_db("update $pi2 set t2_nivel_servicio_id = ".$sele_nivel_actual[1]." where id_item=".$id_item_pecc);
*/
//FIN cambia_nivel y agrega socios y comite si es necesario

}


if($estado_actual == 12 and $_POST["aplica_procurement"] == 1){

$update_aplica_procurement = query_db("update $pi2 set esta_en_e_procurement = '1' where id_item = ".$id_item_pecc);
echo "Se va a crear";
crear_en_e_procurement($id_item_pecc);
echo "Se creo en Urna";

}

if($estado_actual == 12 and $_POST["aplica_procurement"] == 2){

$update_aplica_procurement = query_db("update $pi2 set esta_en_e_procurement = '2' where id_item = ".$id_item_pecc);
echo "Se va a eliminar";
elimina_e_procurement($id_item_pecc)			;
echo "se elimino";

$insert_gestion_urna = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado, observacion, hora) values ($id_item_pecc, '12.1', ".$_SESSION["id_us_session"].", '".$fecha."', '0',1,'No se requiere la creacion en la urna virtual', '".$hora."')");
$insert_gestion_urna = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado, observacion, hora) values ($id_item_pecc, '12.2', ".$_SESSION["id_us_session"].", '".$fecha."', '0',1,'No se requiere la creacion en la urna virtual', '".$hora."')");
$insert_gestion_urna = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado, observacion, hora) values ($id_item_pecc, '12.3', ".$_SESSION["id_us_session"].", '".$fecha."', '0',1,'No se requiere la creacion en la urna virtual', '".$hora."')");
}



if(($estado_actual == 14 and $sel_item[6] == 6) or ($estado_actual == 1 and $sel_item[6] == 15)){
$selec_si_hay_numero = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item = ".$id_item_pecc));
if($selec_si_hay_numero[0] == "" and $selec_si_hay_numero[1] == "" and $selec_si_hay_numero[2] == ""){				


if($id_tipo_contratacion==2 or $id_tipo_contratacion==3 or $id_tipo_contratacion==4){
$numero1 = "B";	
}else{
$numero1 = "S";
}


$fecha_separa = explode("-",$fecha);
$fecha_separa2 = substr($fecha_separa[0],2,4);
$numero2 = $fecha_separa2;
$selec_numero3 = traer_fila_row(query_db("select max(num3) from $pi2 where num2 = '$numero2'"));
$numero3 = $selec_numero3[0]+1;

$upda_item = query_db("update $pi2 set num1='$numero1',num2='$numero2', num3='$numero3' where id_item=".$id_item_pecc);
}			
}


if($estado_actual == 14 or $estado_actual == 15 or $muestra == "SI" or ($sel_item[6]==15 and ($estado_actual == 31 or $estado_actual == 6))){

if($sel_item[32] == "" or $sel_item[32] == " " or $sel_item[32] == "NULL"  ){
if ($sel_item[6] == 1 or $sel_item[6] == 2 or $sel_item[6] == 3) {
?><script>alert("Debe Digitar la Informacion de Adjudicacion")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}
}

$cuantos_roles_aprov= traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol  in (48,45,43,20,9) and estado = 1"));
if($cuantos_roles_aprov[0] <=0){
?><script>alert("Todos los procesos deben tener nivel de aprobacion (I, II, III, IV)")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}

$cuantos_roles= traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol  not in (8,15,10,11) and estado = 1"));

$secuencia_solicitante=0;
$sele_secuencia = query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and estado =1");
while($sel_secu = traer_fila_db($sele_secuencia)){

if($sel_secu[2]==23){
$secuencia_gerente = $sel_secu[0];
}

if($sel_secu[2]==15){
$secuencia_solicitante = $sel_secu[0];
}
$sele_cuanto = traer_fila_row(query_db("select count(*) from $pi15 where id_secuencia_solicitud = ".$sel_secu[0]." and estado = 1"));
if($sele_cuanto[0] <=0){
?>
<script>alert("Uno de los roles no tiene usuarios asignados")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}
}

//VERIFICA QUE EL GERENTE DEL ITEM NO SEA EL MISMO JEFE QUE APRUEBA

$sel_usua_solictante = traer_fila_row(query_db("select id_usuario from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = '".$secuencia_solicitante."' "));

$ssql_repetidos = "select count(*) from $pi14 as t1, t2_agl_secuencia_solicitud_usuario as t2 where t1.id_item_pecc = ".$id_item_pecc." and t1.id_secuencia_solicitud = t2.id_secuencia_solicitud  and t1.tipo_adj_permiso = 2 and t1.id_rol in (9,20,45, 43, 16, 22) and t1.estado = 1 and t2.id_usuario = ".$sel_usua_solictante[0]." AND t2.estado= 1";
//echo $ssql_repetidos;
$sel_sql_roles_repetidos = traer_fila_row(query_db($ssql_repetidos));
if($sel_sql_roles_repetidos[0]>0){
?><script>alert("Solicitante no puede firmar a su vez como gerente de activo, tampoco como nivel de aprobacion")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
	exit;
}
	
//FIN VERIFICA QUE EL GERENTE DEL ITEM NO SEA EL MISMO JEFE QUE APRUEBA

//$sele_presu_adjudica = traer_fila_row(query_db("select sum(valor_usd+valor_cop) from $pi8 where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2"));

$actualiza_2 = query_db("update $pi14 set por_sistema = 2 where id_item_pecc=".$id_item_pecc." and tipo_adj_permiso = 2");
/*----------------validacion de reemplazos----------*/
if(($estado_actual == 6  and ($sel_item[6] != 1 and $sel_item[6] != 2 and $sel_item[6] != 3 or $estado_actual == 14))){
	echo "adjudicacion";
	$sel_roles_niveles_aprobacion = query_db("select t1.id_rol, t2.id_usuario  from t2_agl_secuencia_solicitud as t1, t2_agl_secuencia_solicitud_usuario as t2 where t1.id_item_pecc= ".$sel_item[0]." and  t1.id_secuencia_solicitud = t2.id_secuencia_solicitud and t1.id_rol in (35,45,9,20,43) and t1.tipo_adj_permiso = 2 and t2.estado = 1 and t1.estado = 1");
}
	if($sel_roles_niveles_aprobacion!=""){
	while($sel_n_apro = traer_fila_db($sel_roles_niveles_aprobacion)){
		$id_solicitante = $sel_item[3];
		if($sel_item[6] == 8){
			$id_solicitante = $sel_item[42];
			}
		if($sel_n_apro[0] == 35 or $sel_n_apro[0] == 45){//jefatura
				$sel_aprobador_correcto = traer_fila_row(query_db("select id_superintendente from tseg14_relacion_usuario_superintendente where id_us = $id_solicitante and id_area = ".$sel_item[5]));				
				if($sel_aprobador_correcto[0]!= 0 and ($sel_aprobador_correcto[0] != $sel_n_apro[1])){
					$texto_declara_intereses.="; El usuario encargado de abastecimiento relaciono un reemplazo en el nivel de aprobacion Jefaura cambio a ".traer_nombre_muestra($sel_aprobador_correcto[0], $g1,"nombre_administrador","us_id")." por ".traer_nombre_muestra($sel_n_apro[1], $g1,"nombre_administrador","us_id").", este fue verificado por el mismo en la cartelera de intranet ";
					}
			}
		if($sel_n_apro[0] == 9){//gerente de area
				$sel_aprobador_correcto = traer_fila_row(query_db("select id_jefe_area from tseg13_relacion_usuario_jefe where id_us = $id_solicitante and id_area = ".$sel_item[5]));				
				if($sel_aprobador_correcto[0]!= 0 and ($sel_aprobador_correcto[0] != $sel_n_apro[1])){
					$texto_declara_intereses.="; El usuario encargado de abastecimiento relaciono un reemplazo en el nivel de aprobacion Gerente de Area cambio a ".traer_nombre_muestra($sel_aprobador_correcto[0], $g1,"nombre_administrador","us_id")." por ".traer_nombre_muestra($sel_n_apro[1], $g1,"nombre_administrador","us_id").", este fue verificado por el mismo en la cartelera de intranet ";
					}
			}
		if($sel_n_apro[0] == 20){//vicepresidente
				$sel_aprobador_correcto = traer_fila_row(query_db("select id_vicepresidente from tseg15_relacion_usuario_vicepresidente where id_us = $id_solicitante and area = ".$sel_item[5]));				
				if($sel_aprobador_correcto[0]!= 0 and ($sel_aprobador_correcto[0] != $sel_n_apro[1])){
					$texto_declara_intereses.="; El usuario encargado de abastecimiento relaciono un reemplazo en el nivel de aprobacion Vicepresidente cambio a ".traer_nombre_muestra($sel_aprobador_correcto[0], $g1,"nombre_administrador","us_id")." por ".traer_nombre_muestra($sel_n_apro[1], $g1,"nombre_administrador","us_id").", este fue verificado por el mismo en la cartelera de intranet ";
					}
			}
		if($sel_n_apro[0] == 43){//director
				$sel_aprobador_correcto = traer_fila_row(query_db("select id_director from tseg15_relacion_usuario_director where id_us = $id_solicitante and id_area = ".$sel_item[5]));				
				if($sel_aprobador_correcto[0]!= 0 and ($sel_aprobador_correcto[0] != $sel_n_apro[1])){
					$texto_declara_intereses.="; El usuario encargado de abastecimiento relaciono un reemplazo en el nivel de aprobacion Director cambio a ".traer_nombre_muestra($sel_aprobador_correcto[0], $g1,"nombre_administrador","us_id")." por ".traer_nombre_muestra($sel_n_apro[1], $g1,"nombre_administrador","us_id").", este fue verificado por el mismo en la cartelera de intranet ";
					}
			}
			
			
		}	
	}
	
	/*----------------FIN -validacion de reemplazos----------*/
$insert_aprobacion = query_db("insert into $pi16 (id_secuencia_solicitud,id_us,fecha,aprobado, observacion) values (".$_POST["id_secuencia"].", ".$_SESSION["id_us_session"].",'".$fecha."',1, '".$texto_declara_intereses."')");

if($estado_actual == 14 or $estado_actual == 6){
$sel_usuario_gerente_igual_profesioanl = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = '".$secuencia_gerente."' and id_usuario = ".$_SESSION["id_us_session"]));				
if($sel_usuario_gerente_igual_profesioanl[0]>0){
$insert_aprobacion = query_db("insert into $pi16 (id_secuencia_solicitud,id_us,fecha,aprobado) values (".$secuencia_gerente.", ".$_SESSION["id_us_session"].",'".$fecha."',1)");	
}
}

}




$sele_siguiente_nivel = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3  where id_item=".$id_item_pecc." and actividad_estado_id > ".$estado_actual." and  (estado = 2 or estado is null)"));
$grabas_estado = "SI";
$esta_actividad_siguiente = $sele_siguiente_nivel[0];

if($esta_actividad_siguiente == 7 or $esta_actividad_siguiente == 16 and $sel_item[6] != 16 and $sel_item[6] != 15){
if($cuantos_roles[0] <=0){
?><script>alert("Todas las Solicitudes que Requieren de Firmas en el Sistema, por lo menos deben requerir una firma");</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}
}

if($esta_actividad_siguiente==10){
$esta_actividad_siguiente=11;
agrega_gestion_pecc($id_item_pecc, 10, $fecha, 0);
}


$update_nivel = query_db("update $pi2 set estado = '".$esta_actividad_siguiente."' where id_item=".$id_item_pecc);

/* -------------------- LOG ---------------------------------*/
if($estado_actual == 6){

if($esta_actividad_siguiente == 7){
$id_log = log_de_procesos_sgpa(2, 6, 34, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, "Usuario que Firmo",$_SESSION["id_us_session"] , "t1_us_usuarios",2);

$id_log = log_de_procesos_sgpa(2, 5, 32, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
$permiso_ad = 1;


}

if($esta_actividad_siguiente >14){

$id_log = log_de_procesos_sgpa(2, 15, 41, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, "Usuario que Firmo",$_SESSION["id_us_session"] , "t1_us_usuarios",2);

$id_log = log_de_procesos_sgpa(2, 13, 39, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
$permiso_ad = 2;

}



$log_sel_firmas_permiso = query_db("select t4.nombre as nombre_rol, t3.nombre_administrador,t1.orden from t2_agl_secuencia_solicitud as t1, t2_agl_secuencia_solicitud_usuario as t2, t1_us_usuarios as t3, tseg2_permisos as t4 where t1.id_item_pecc = $id_item_pecc and t1.id_secuencia_solicitud = t2.id_secuencia_solicitud and t1.estado = 1 and t2.estado = 1 and t3.us_id = t2.id_usuario and t1.id_rol = t4.id_premiso and t1.tipo_adj_permiso = $permiso_ad order by t1.orden");

while($sel_log = traer_fila_db($log_sel_firmas_permiso)){

log_agrega_detalle ($id_log, $sel_log[2]." Firma - ".$sel_log[0],$sel_log[1] , "",$sel_log[2]);
}
}

if($estado_actual == 10){
$id_log = log_de_procesos_sgpa(2, 9, 0, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, " Usuario que Realizo la Accion ",$_SESSION["id_us_session"], "t1_us_usuarios",1);					
}
if($estado_actual == 11){
$id_log = log_de_procesos_sgpa(2, 10, 0, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, " Usuario que Realizo la Accion ",$_SESSION["id_us_session"], "t1_us_usuarios",1);					
}	
if($estado_actual == 12){
if($_POST["aplica_procurement"] == 1){
$accion_log = "SI";
}else{
$accion_log = "NO";
}
$id_log = log_de_procesos_sgpa(2, 11, 0, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, " Usuario que Realizo la Accion ",$_SESSION["id_us_session"], "t1_us_usuarios",1);
log_agrega_detalle ($id_log, " Crear en la Urna Virtual ",$accion_log, "",2);					
}	
if($estado_actual == 13){
$id_log = log_de_procesos_sgpa(2, 12, 0, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, " Usuario que Realizo la Accion ",$_SESSION["id_us_session"], "t1_us_usuarios",1);					
}	
if($estado_actual == 14){
$sel_textos_adjudicacion = traer_fila_row(query_db("select CAST(ob_solicitud_adjudica AS text), CAST(ob_contrato_adjudica AS text), CAST(alcance_adjudica AS text), CAST(justificacion_adjudica AS text), CAST(recomendacion_adjudica AS text), CAST(objeto_solicitud AS text), CAST(objeto_contrato AS text), CAST(alcance AS text), CAST(justificacion AS text), CAST(recomendacion AS text) from $pi2 where id_item=".$id_item_pecc));

if($sel_textos_adjudicacion[0] == "" or $sel_textos_adjudicacion[0] == " " or $sel_textos_adjudicacion[0] == "  "){
$ob = $sel_textos_adjudicacion[5];
}else{
$ob =$sel_textos_adjudicacion[0];
}

if($sel_textos_adjudicacion[1] == "" or $sel_textos_adjudicacion[1] == " " or $sel_textos_adjudicacion[1] == "  "){
$ob_contra = $sel_textos_adjudicacion[6];
}else{
$ob_contra =$sel_textos_adjudicacion[1];
}

if($sel_textos_adjudicacion[2] == "" or $sel_textos_adjudicacion[2] == " " or $sel_textos_adjudicacion[2] == "  "){
$ob_alcance = $sel_textos_adjudicacion[7];
}else{
$ob_alcance =$sel_textos_adjudicacion[2];
}
if($sel_textos_adjudicacion[3] == "" or $sel_textos_adjudicacion[3] == " " or $sel_textos_adjudicacion[3] == "  "){
$ob_justifi = $sel_textos_adjudicacion[8];
}else{
$ob_justifi =$sel_textos_adjudicacion[3];
}

if($sel_textos_adjudicacion[4] == "" or $sel_textos_adjudicacion[4] == " " or $sel_textos_adjudicacion[4] == "  "){
$ob_recomen = $sel_textos_adjudicacion[9];
}else{
$ob_recomen =$sel_textos_adjudicacion[4];
}


$id_log = log_de_procesos_sgpa(2, 13, 0, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, "Objeto de la solicitud",$ob, "",1);
log_agrega_detalle ($id_log, "Objeto del Contrato",$ob_contra, "",2);
log_agrega_detalle ($id_log, "Alcance",$ob_alcance, "",3);
log_agrega_detalle ($id_log, "Justificacion",$ob_justifi, "",4);
log_agrega_detalle ($id_log, "Recomendacion",$ob_recomen, "",5);

$id_log = log_de_procesos_sgpa(2, 13, 39, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores

$log_sel_firmas_permiso = query_db("select t4.nombre as nombre_rol, t3.nombre_administrador,t1.orden from t2_agl_secuencia_solicitud as t1, t2_agl_secuencia_solicitud_usuario as t2, t1_us_usuarios as t3, tseg2_permisos as t4 where t1.id_item_pecc = $id_item_pecc and t1.id_secuencia_solicitud = t2.id_secuencia_solicitud and t1.estado = 1 and t2.estado = 1 and t3.us_id = t2.id_usuario and t1.id_rol = t4.id_premiso and t1.tipo_adj_permiso = 2 order by t1.orden");

while($sel_log = traer_fila_db($log_sel_firmas_permiso)){

log_agrega_detalle ($id_log, $sel_log[2]." Firma - ".$sel_log[0],$sel_log[1] , "",$sel_log[2]);
}


$sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$id_item_pecc.""));
if($sele_tipo_doc[0]>0){//es marco

$sele_presupuesto = query_db("select * from $vpeec25 where t2_item_pecc_id ='".$id_item_pecc."'");

while($sel_presu = traer_fila_db($sele_presupuesto)){
$id_log = log_de_procesos_sgpa(2, 13, 37, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, "Ano",$sel_presu[1], "",4);
log_agrega_detalle ($id_log, "Area / Proyecto",$sel_presu[2], "",6);
log_agrega_detalle ($id_log, "Valor USD$",$sel_presu[3], "",7);
log_agrega_detalle ($id_log, "Valor COP$",$sel_presu[4], "",8);
log_agrega_detalle ($id_log, "Adjunto",$sel_presu[5], "",9);
}
$sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$id_item_pecc."' and t1.t1_proveedor_id =  t2.t1_proveedor_id");

while($sel_presu = traer_fila_db($sele_presupuesto)){
$id_log = log_de_procesos_sgpa(2, 13, 38, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, "Contratista",$sel_presu[1], "",1);
log_agrega_detalle ($id_log, "Complemento",$sel_presu[3], "",2);
log_agrega_detalle ($id_log, "Tipo de Documento","Contrato Marco", "",3);
log_agrega_detalle ($id_log, "Vigencia Meses",$sel_presu[2], "",5);
}

}else{// es normal
$sele_presupuesto = query_db("select t2_item_pecc_id,razon_social,consecutivo,creacion_sistema,ano,nombre,sum(valor_usd),sum(valor_cop),adjunto,tipo_documento,t1_proveedor_id,t2_presupuesto_id,nit,t1_tipo_documento_id,id_contrato,vigencia_mes,t1_campo_id,Expr1 from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."' group by t2_item_pecc_id,razon_social,consecutivo,creacion_sistema,ano,nombre,adjunto,tipo_documento,t1_proveedor_id,t2_presupuesto_id,nit,t1_tipo_documento_id,id_contrato,vigencia_mes,t1_campo_id,Expr1");

while($sel_presu = traer_fila_db($sele_presupuesto)){
$id_log = log_de_procesos_sgpa(2, 13, 36, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, "Contratista",$sel_presu[1], "",1);
log_agrega_detalle ($id_log, "Complemento",$sel_presu[17], "",2);
log_agrega_detalle ($id_log, "Tipo de Documento",$sel_presu[9], "",3);
log_agrega_detalle ($id_log, "Ano",$sel_presu[4], "",4);
log_agrega_detalle ($id_log, "Vigencia Meses",$sel_presu[15], "",5);
log_agrega_detalle ($id_log, "Area / Proyecto",$sel_presu[5], "",6);
log_agrega_detalle ($id_log, "Valor USD$",$sel_presu[6], "",7);
log_agrega_detalle ($id_log, "Valor COP$",$sel_presu[7], "",8);
log_agrega_detalle ($id_log, "Adjunto",$sel_presu[8], "",9);
}
}//fin es normal

}
if($estado_actual == 15){
$id_log = log_de_procesos_sgpa(2, 14, 0, $id_item_pecc, $estado_actual, $esta_actividad_siguiente);//agrega valores
log_agrega_detalle ($id_log, " Usuario que Realizo la Accion ",$_SESSION["id_us_session"], "t1_us_usuarios",1);					
}
/* -------------------- LOG ---------------------------------*/

if($estado_actual == 14){

$actualiza_2 = query_db("update $pi14 set por_sistema = 2 where id_item_pecc=".$id_item_pecc." and tipo_adj_permiso = 2");

valida_firmas_que_estan_creadas_permiso($id_item_pecc);

}//FIN SI ESTADO ACTUAL ES 14



agrega_gestion_pecc($id_item_pecc, $estado_actual, $fecha, 0);
if($sel_item[6] == 15){ $link_envia = "adjudicacion";}else{$link_envia = "edicion-item-pecc";}
?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/<?=$link_envia?>.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?
}


if($_POST["accion"]=="devolver_profesional_desde_administrador"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

if($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 7 or $sel_item[6] == 8 or $sel_item[6] == 9 or $sel_item[6] == 10 or $sel_item[6] == 11 or $sel_item[6] == 12){

$estado_nuevo = 6;
$permiso="1,2";
}else{
if($sel_item[14] == 7  ){
$estado_nuevo = 6;
$permiso="1,2";
}

if($sel_item[14] > 14  ){
$estado_nuevo = 14;
$permiso=2;
}

}



$sel_secuencias = query_db("SELECT id_secuencia_solicitud FROM  t2_agl_secuencia_solicitud WHERE id_item_pecc = $id_item_pecc and id_rol not in (15) and tipo_adj_permiso in ($permiso)");
while($sel_secu = traer_fila_row($sel_secuencias)){

$update_aprobacion = query_db("update  t2_agl_secuencia_solicitud_aprobacion set aprobado = 0 where id_secuencia_solicitud = ".$sel_secu[0]);


}

//elimina si se devuelve		
//		$update_contratos = query_db("update t7_contratos_contrato set XXXX=XXX where id_item = ".$id_item_pecc);
//	$delete_modificaciones = query_db("update t7_contratos_complemento set XXXX=XXX where id_item_pecc=".$id_item_pecc);

$apda_item = query_db("update $pi2 set estado = $estado_nuevo, solicitud_rechazada = 0 where id_item =".$id_item_pecc);
$update_gestiones = query_db("update t2_nivel_servicio_gestiones set estado=2 where id_item = ".$id_item_pecc." and t2_nivel_servicio_actividad_id >= ".$estado_nuevo);

$id_log = log_de_procesos_sgpa(2, 42, 62, $id_item_pecc, $sel_item[14], $estado_nuevo);//agrega valores
log_agrega_detalle ($id_log, "Se devuelve al primer estado del profesional", "" , "t2_nivel_servicio_actividades",1);
log_agrega_detalle ($id_log, "Se cancelan las firmas en el sistema", "" , "",1);
log_agrega_detalle ($id_log, "Se cancelan los contratos o modificaciones creadas", "" , "",1);

}
if($_POST["accion"]=="devolver_solictud_gerente"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$observa_atras = arreglo_recibe_variables($_POST["observa_atras"]);
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

if($sel_item[14] == 6 or $sel_item[14] == 2){
$apda_item = query_db("update $pi2 set estado = 31 where id_item =".$id_item_pecc);
$selec_todas_aprobaciones = query_db("select * from $pi14 where id_item_pecc=".$id_item_pecc."  and estado =1");
while($sel_secuan = traer_fila_db($selec_todas_aprobaciones)){
$apda_item = query_db("update $pi16 set aprobado = 3 where id_secuencia_solicitud =".$sel_secuan[0]);	
}
agrega_gestion_pecc_atras_solicita($id_item_pecc, $sel_item[14], $fecha, 0,$observa_atras);
$id_log = log_de_procesos_sgpa(2, 22, 0, $id_item_pecc, $sel_item[14], 31);//agrega valores
log_agrega_detalle ($id_log, "Observacion", $observa_atras , "t7_contratos_contrato",1);
}
if($sel_item[14] == 15){
$apda_item = query_db("update $pi2 set estado = 14 where id_item =".$id_item_pecc);
$selec_todas_aprobaciones = query_db("select * from $pi14 where id_item_pecc=".$id_item_pecc." and tipo_adj_permiso = 2  and estado =1");
while($sel_secuan = traer_fila_db($selec_todas_aprobaciones)){
$apda_item = query_db("update $pi16 set aprobado = 3 where id_secuencia_solicitud =".$sel_secuan[0]."");	
}
agrega_gestion_pecc_atras_solicita($id_item_pecc, $sel_item[14], $fecha, 0,$observa_atras);
$id_log = log_de_procesos_sgpa(2, 22, 0, $id_item_pecc, $sel_item[14], 14);//agrega valores
log_agrega_detalle ($id_log, "Observacion", $observa_atras , "t7_contratos_contrato",1);
}

if($sel_item[14] == 11){


/*
$apda_item = query_db("update $pi2 set estado = 10 where id_item =".$id_item_pecc);
$selec_todas_aprobaciones = query_db("select * from $pi14 where id_item_pecc=".$id_item_pecc);
while($sel_secuan = traer_fila_db($selec_todas_aprobaciones)){
$apda_item = query_db("update $pi16 set aprobado = 3 where id_secuencia_solicitud =".$sel_secuan[0]);	
}*/
}

?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="elimina_usuario_de_firmas_adjudica"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));

echo "select * from $vpeec15 where id_usuario_aprobador = ".$_POST["id_secuencia"];

$selec_secuencia =traer_fila_row(query_db("select * from $vpeec15 where id_usuario_aprobador = ".$_POST["id_secuencia"]));

$dele_pro_sistem_us = query_db("update $pi14 set por_sistema=2 where id_secuencia_solicitud = ".$selec_secuencia[0]);

$delee = query_db("update $pi15 set estado = 3 where id_secuencia_solicitud = ".$selec_secuencia[0]);


$id_log = log_de_procesos_sgpa(2, 43, 66, $id_item_pecc, 0, 0);//actualiza general			
log_agrega_detalle ($id_log, "Quito la Firma", $selec_secuencia[9], "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Rol", $selec_secuencia[2], "tseg2_permisos",2);
log_agrega_detalle ($id_log, "Secuencia", $selec_secuencia[3], "",2);


?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones_adjudicacion.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}
/*
if($_POST["accion"]=="elimina_usuario_de_firmas"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));

$dele_pro_sistem_us = query_db("update $pi15 set estado = 3 where id_secuencia_solicitud = ".$_POST["id_secuencia"]);		
$dele_pro_sistem = query_db("update $pi14 set estado = 3 where id_secuencia_solicitud = ".$_POST["id_secuencia"]);

?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}*/

if($_POST["accion"]=="elimina_rol_usuario_de_firmas_adjudica"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));



$dele_pro_sistem_us = query_db("update t2_agl_secuencia_solicitud set por_sistema=2, estado = 3 where id_secuencia_solicitud = ".$_POST["id_secuencia"]);

$delee = query_db("update t2_agl_secuencia_solicitud_usuario set estado = 3 where id_secuencia_solicitud = ".$_POST["id_secuencia"]);

$sel_para_log = query_db("select t1.id_rol,t1.orden, t2.id_usuario from t2_agl_secuencia_solicitud as t1,  t2_agl_secuencia_solicitud_usuario as t2 where t1.id_secuencia_solicitud = ".$_POST["id_secuencia"]." and t1.id_secuencia_solicitud = t2.id_secuencia_solicitud");

while($sel_l = traer_fila_db($sel_para_log)){


$id_log = log_de_procesos_sgpa(2, 43, 66, $id_item_pecc, 0, 0);//actualiza general

log_agrega_detalle ($id_log, "Quito la Firma", $sel_l[2], "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Rol", $sel_l[0], "tseg2_permisos",2);
log_agrega_detalle ($id_log, "Secuencia", $sel_l[1], "",2);
}



?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones_adjudicacion.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}
if($_POST["accion"]=="elimina_rol_usuario_de_firmas"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));


$dele_pro_sistem_us = query_db("update $pi14 set por_sistema=2, estado = 3 where id_secuencia_solicitud = ".$_POST["id_secuencia"]);

$delee = query_db("update $pi15 set estado = 3 where t2_agl_secuencia_solicitud = ".$_POST["id_secuencia"]);


$sel_para_log = query_db("select t1.id_rol,t1.orden, t2.id_usuario from t2_agl_secuencia_solicitud as t1,  t2_agl_secuencia_solicitud_usuario as t2 where t1.id_secuencia_solicitud = ".$_POST["id_secuencia"]." and t1.id_secuencia_solicitud = t2.id_secuencia_solicitud");

while($sel_l = traer_fila_db($sel_para_log)){


$id_log = log_de_procesos_sgpa(2, 45, 68, $id_item_pecc, 0, 0);//actualiza general

log_agrega_detalle ($id_log, "Quito la Firma", $sel_l[2], "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Rol", $sel_l[0], "tseg2_permisos",2);
log_agrega_detalle ($id_log, "Secuencia", $sel_l[1], "",2);
}


?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="elimina_usuario_de_firmas"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));

$selec_secuencia =traer_fila_row(query_db("select * from $vpeec15 where id_usuario_aprobador = ".$_POST["id_secuencia"]));

$dele_pro_sistem_us = query_db("update $pi14 set por_sistema=2 where id_secuencia_solicitud = ".$selec_secuencia[0]);

$delee = query_db("update $pi15 set estado = 3 where id_secuencia_solicitud = ".$selec_secuencia[0]);

$id_log = log_de_procesos_sgpa(2, 45, 68, $id_item_pecc, 0, 0);//actualiza general			
log_agrega_detalle ($id_log, "Quito la Firma", $selec_secuencia[9], "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Rol", $selec_secuencia[2], "tseg2_permisos",2);
log_agrega_detalle ($id_log, "Secuencia", $selec_secuencia[3], "",2);


?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="cambia_orden_secuencia"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$actualiza_prosistem = query_db("update $pi14 set por_sistema=2,orden=".$_POST["orden_edita_secua"]."  where id_secuencia_solicitud =".$_POST["id_secuencia"]);

$sele_para_cambiar_orden = query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = ".$_POST["tipo_adj_permiso"]." and orden >= ".$_POST["orden_edita_secua"]." and id_rol not in (15, 8) and id_secuencia_solicitud <> ".$_POST["id_secuencia"]."  and estado =1 order by orden asc");
$orden_actial = $_POST["orden_edita_secua"];
while($sel_firm_orden = traer_fila_db($sele_para_cambiar_orden)){
$orden_actial = $orden_actial+1;

$actualiza_orden = query_db("update $pi14 set orden=".$orden_actial." where id_secuencia_solicitud =".$sel_firm_orden[0]);
}

?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/aprobaciones.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="agrega_aprobacion"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$explode = explode("----,",$_POST["usuario_permiso"]);
$id_usuario = $explode[1];

//if($_POST["rol_encarga_permiso"] <> 18){
$selec_cuantos = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = ".$_POST["tipo_adj_permiso"]." and id_rol=".$_POST["rol_encarga_permiso"]."  and estado =1"));
//}

if($selec_cuantos[0] <> ""){
$id_ingreso = $selec_cuantos[0];
$actualiza_prosistem = query_db("update $pi14 set estado =1, por_sistema=2,orden=".$_POST["orden_permiso"]."  where id_secuencia_solicitud =".$id_ingreso);
}else{
$insert = "insert into $pi14 (id_item_pecc,id_rol,orden,estado,por_sistema,tipo_adj_permiso) values (".$id_item_pecc.", ".$_POST["rol_encarga_permiso"].",".$_POST["orden_permiso"].",1,2,".$_POST["tipo_adj_permiso"].")";	
$sql_ex=query_db($insert.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);
}


$insert_usuario = query_db("insert into $pi15 (id_secuencia_solicitud,id_usuario,estado) values (".$id_ingreso.",".$id_usuario.",1)");


$sele_para_cambiar_orden = query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = ".$_POST["tipo_adj_permiso"]." and orden >= ".$_POST["orden_permiso"]." and id_rol not in (15, 8) and id_secuencia_solicitud <> $id_ingreso  and estado =1 order by orden asc");
$orden_actial = $_POST["orden_permiso"];
while($sel_firm_orden = traer_fila_db($sele_para_cambiar_orden)){
$orden_actial = $orden_actial+1;

$actualiza_orden = query_db("update $pi14 set orden=".$orden_actial." where id_secuencia_solicitud =".$sel_firm_orden[0]);
}


if($_POST["tipo_adj_permiso"] == 1){
$linmk_envia = "aprobaciones";
$id_log = log_de_procesos_sgpa(2, 45, 67, $id_item_pecc, 0, 0);//actualiza general
}
if($_POST["tipo_adj_permiso"] == 2){
$linmk_envia = "aprobaciones_adjudicacion";
$id_log = log_de_procesos_sgpa(2, 43, 65, $id_item_pecc, 0, 0);//actualiza general
}




log_agrega_detalle ($id_log, "Agrega Firma", $id_usuario, "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Rol", $_POST["rol_encarga_permiso"], "tseg2_permisos",2);
log_agrega_detalle ($id_log, "Secuencia", $_POST["orden_permiso"], "",3);

?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/<?= $linmk_envia ?>.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?

}
if($_POST["accion"]=="edita_proveedores_sugeridos"){

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$prove_sugiere = elimina_comillas_2($_POST["prove_sugiere"]);

$dele = query_db("update $pi2 set proveedores_sugeridos='".$prove_sugiere."' where id_item = ".$id_item_pecc);

$id_log = log_de_procesos_sgpa(2, 5, 11, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//actualiza general

log_agrega_detalle ($id_log, "Proveedores Sugeridos", $prove_sugiere, "",1);
?>
<script>
    alert("Los Proveedores se Editaron con Exito")
</script>
<?
}

if($_POST["accion"]=="graba_proveedor_elimina"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_proveedor_edita = elimina_comillas(arreglo_recibe_variables($_POST["id_proveedor_edita"]));

$sel_si_elimina = traer_fila_row(query_db("select * from $pi13 where id_relacion_proveedor = ".$_POST["id_elim_proveedor"]));

$dele = query_db("delete from $pi13 where id_relacion_proveedor = ".$_POST["id_elim_proveedor"]);

$id_log = log_de_procesos_sgpa(2, 5, 15, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores
log_agrega_detalle ($id_log, "Proveedor",$sel_si_elimina[2] , "t1_proveedor",1);
log_agrega_detalle ($id_log, "Fecha",$fecha , "",2);
?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="graba_proveedor_edita"){

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_proveedor_edita = elimina_comillas(arreglo_recibe_variables($_POST["id_proveedor_edita"]));
$nombre = elimina_comillas_2($_POST["nom2"]);
$email = elimina_comillas_2($_POST["email2"]);
$dver = elimina_comillas(arreglo_recibe_variables($_POST["dver2"]));
$nit = elimina_comillas(arreglo_recibe_variables($_POST["nit2"]));


$insert = query_db("update $g6 set nit=$nit, digito_verificacion=$dver, razon_social='$nombre' where t1_proveedor_id = ".$id_proveedor_edita);
$insert_correo = query_db("update $g20 set email = '$email' where t1_proveedor_id = ".$id_proveedor_edita);
?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}


if($_POST["accion"]=="graba_proveedor_base_edita_solictante"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));

$id_proveedor = $_POST["id_proveedor_a_relacionar"];


$insert_relacion = query_db("insert into $pi13 (id_item, id_proveedor, permiso_o_adjudica, estado, id_us_crea) values ($id_item_pecc,$id_proveedor,1, 1, ".$_SESSION["id_us_session"]." )");

$id_log = log_de_procesos_sgpa(2, 5, 14, $id_ingreso, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores
log_agrega_detalle ($id_log, "Proveedor",$id_proveedor , "t1_proveedor",1);
log_agrega_detalle ($id_log, "Fecha",$fecha , "",2);


?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?=$id_item_pecc ?>&id_tipo_proceso_pecc=1', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="graba_proveedor_base_nuevo_solictante"){


$insert = "insert into $pi2 (id_pecc,t2_nivel_servicio_id,id_us,t1_tipo_contratacion_id,t1_area_id,t1_tipo_proceso_id,fecha_se_requiere,objeto_solicitud,objeto_contrato,alcance,proveedores_sugeridos,justificacion,recomendacion,estado,t1_trm_id,contrato_id,fecha_creacion,aprobacion_comite_adicional,dondeo_adicional,id_item_peec_aplica, aprobado,t2_pecc_proceso_id,id_us_preparador,num_solped,cargo_contable, destino_ots, duracion_ots,id_gerente_ot,id_solicitud_relacionada,justificacion_tecnica,criterios_evaluacion, convirte_marco, id_proveedor_relacionado) values (1,0,".$_SESSION["id_us_session"].",1,44,16,'','','','','','','',31,1,'0','".$fecha." ".$hora."','2',2,'0',2,1,".$_SESSION["id_us_session"].",'','', '', '',".$_SESSION["id_us_session"].",'0','','','2', '0')";

$sql_ex=query_db($insert.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);


$id_proveedor = $_POST["id_proveedor_a_relacionar"];

$insert_relacion = query_db("insert into $pi13 (id_item, id_proveedor, permiso_o_adjudica, estado, id_us_crea) values ($id_ingreso,$id_proveedor,1, 1, ".$_SESSION["id_us_session"]." )");

$id_log = log_de_procesos_sgpa(2, 5, 14, $id_ingreso, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores
log_agrega_detalle ($id_log, "Proveedor",$id_proveedor , "t1_proveedor",1);
log_agrega_detalle ($id_log, "Fecha",$fecha , "",2);


?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?= $id_ingreso ?>&id_tipo_proceso_pecc=1', 'contenidos');
</script>
<?
}


if($_POST["accion"]=="graba_proveedor_base"){

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$explode = explode("----,",$_POST["proveedores_busca"]);
$id_proveedor = $explode[1];

if($_POST["prove_adjudicado"] == 1){
	$updat = query_db(" update $pi13 set es_adjudicado = 2 where id_item = ".$id_item_pecc);
	}
	
$insert_relacion = query_db("insert into $pi13 (id_item, id_proveedor, permiso_o_adjudica, estado, id_us_crea, es_adjudicado) values ($id_item_pecc,$id_proveedor,1, 1, ".$_SESSION["id_us_session"].", '".$_POST["prove_adjudicado"]."' )");




$id_log = log_de_procesos_sgpa(2, 5, 14, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores
log_agrega_detalle ($id_log, "Proveedor",$id_proveedor , "t1_proveedor",1);
log_agrega_detalle ($id_log, "Fecha",$fecha , "",2);
if($_POST["prove_adjudicado"] == 1){
log_agrega_detalle ($id_log, "Es el proveedor adjudicado", "SI" , "",3);
}

?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}
if($_POST["accion"]=="graba_proveedor_nuevo_solicitante"){
	
	$insert = "insert into $pi2 (id_pecc,t2_nivel_servicio_id,id_us,t1_tipo_contratacion_id,t1_area_id,t1_tipo_proceso_id,fecha_se_requiere,objeto_solicitud,objeto_contrato,alcance,proveedores_sugeridos,justificacion,recomendacion,estado,t1_trm_id,contrato_id,fecha_creacion,aprobacion_comite_adicional,dondeo_adicional,id_item_peec_aplica, aprobado,t2_pecc_proceso_id,id_us_preparador,num_solped,cargo_contable, destino_ots, duracion_ots,id_gerente_ot,id_solicitud_relacionada,justificacion_tecnica,criterios_evaluacion, convirte_marco, id_proveedor_relacionado) values (1,0,".$_SESSION["id_us_session"].",1,44,16,'','','','','','','',31,1,'0','".$fecha." ".$hora."','2',2,'0',2,1,".$_SESSION["id_us_session"].",'','', '', '',".$_SESSION["id_us_session"].",'0','','','2', '0')";

$sql_ex=query_db($insert.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);
$_POST["accion"] = "graba_proveedor";
$_POST["id_item_pecc"] = $id_ingreso;
$_POST["id_tipo_proceso_pecc"] = 1;
	}
	
	
if($_POST["accion"]=="graba_proveedor"){

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$dver = elimina_comillas(arreglo_recibe_variables($_POST["dver"]));
$nit = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["nit"])));
$nombre = elimina_comillas_2($_POST["nom"]);
$email = elimina_comillas_2($_POST["email"]);

$email = str_replace("&#64;", "@",$email);

if($email <> ""){
$verifica_email = comprobar_email($email);

if($verifica_email=="0"){
?><script>alert("Verifique el e-mail")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit();
}
}

if($nit <> "0" and $nit <> ""){
$bsca_si_exi=traer_fila_row(query_db("select * from $g6 where nit='$nit'"));
if($bsca_si_exi[0]>=1){
?><script>alert("El proveedor ya existe verifique el NIT")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit();
}	
}

$cifra_c=md5("321654");




$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
for($i=0;$i<=3;$i++){
$generador = rand(0,34);
$fuente2.= $alfabeto[$generador];
}

if($nit=="" or $nit=="0"){ 
$alfabeto_nit = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
for($i=0;$i<=10;$i++){
$generador_nit = rand(0,34);
$fuente_nit.= $alfabeto[$generador_nit];
}
$nit = $fuente_nit;

}
$inserta_us = "insert into t1_proveedor (nit, digito_verificacion , razon_social , estado)	values ('$nit', '$dver', '$nombre',1)";
echo $inserta_us;
$sql_ex=query_db($inserta_us.$trae_id_insrte);
$id_ingreso_pro = id_insert($sql_ex);

if($id_ingreso_pro>=1){//si se creo el proveedor

$insert_relacion = query_db("insert into $pi13 (id_item, id_proveedor, permiso_o_adjudica, estado, id_us_crea) values ($id_item_pecc,$id_ingreso_pro,1, 1, ".$_SESSION["id_us_session"]." )");
$inserta_email_sgpa=query_db("insert into t1_proveedor_email (t1_proveedor_id, nombre_responsable, email, tipo, estado) values ($id_ingreso_pro, 'PRINCIPAL','$email',1,1)");

$inserta_us = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
values ('$nombre', '$email', '$cifra_c', '$email', '',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
$sql_ex_p=query_db($inserta_us.$trae_id_insrte);
$id_ingreso_pro_us = id_insert($sql_ex_p);

$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
mysql_select_db($dbbase_mys, $link);
$cambia_cali="insert into  pv_proveedores (pv_id,cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
$id_ingreso_pro,0, '$nit', '$nombre', '','$email', '', 1, '' )";
$sql_ex = mysql_query($cambia_cali);

if($id_ingreso_pro_us>=1){//si se creo el usuario		 
$inserta_us = "insert into us_usuarios (us_id,nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
values ($id_ingreso_pro_us,'$nombre', '$email', '$cifra_c', '$email', '',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
$sql_e=mysql_query($inserta_us);

}		 
}////si se creo el proveedor







$id_log = log_de_procesos_sgpa(2, 5, 14, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores
log_agrega_detalle ($id_log, "Proveedor",$id_ingreso_pro , "t1_proveedor",1);

?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="cambia_solcitud_relacionada"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_marco"]));



$insert = query_db("update $pi2 set  id_item_peec_aplica = $id_item_pecc_marco  where id_item = $id_item_pecc");
$dele_presupuesto = query_db("delete from t2_presupuesto where t2_item_pecc_id = $id_item_pecc");



$id_log = log_de_procesos_sgpa(2, 5, 13, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores

log_agrega_detalle ($id_log, "Solicitud Relacionada",$id_item_pecc_marco , $pi2,1);

?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>', 'contenidos');
</script>
<?
}

if($_POST["accion"]=="quitar_solcitud_relacionada"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));

$insert = query_db("update $pi2 set  id_item_peec_aplica = 0  where id_item = $id_item_pecc");

$dele_presupuesto = query_db("delete from t2_presupuesto where t2_item_pecc_id = $id_item_pecc");

$id_log_presupuesto = log_de_procesos_sgpa(2, 5, 12, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores
?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>', 'contenidos');
</script>
<?
}



if($_POST["accion"]=="graba_presupuesto_item_edita_profesional"){
$mensaje = "";
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$fecha_requiere = elimina_comillas_2($_POST["fecha"]);
$us_prof = elimina_comillas_2($_POST["us_prof"]);
$objeto_solicitud = elimina_comillas_2($_POST["objeto_solicitud"]);
$objeto_contrato = elimina_comillas_2($_POST["objeto_contrato"]);
$alcance = elimina_comillas_2($_POST["alcance"]);
$proveedores_sugeridos = elimina_comillas_2($_POST["proveedores_sugeridos"]);
$justificacion = elimina_comillas_2($_POST["justificacion"]);
$justificacion2 = elimina_comillas_2($_POST["justificacion2"]);
$criterios_evaluacion = elimina_comillas_2($_POST["criterios_evaluacion"]);

$recomendacion = elimina_comillas_2($_POST["recomendacion"]);
$id_pecc = elimina_comillas_2($_POST["id_pecc_seleccion"]);
$tipo_graba = elimina_comillas_2($_POST["tipo_graba"]);
$id_trm_aplica = elimina_comillas_2($_POST["id_trm_aplica"]);
$contrato_tro_si = elimina_comillas_2($_POST["contrato_tro_si"]);
$contrato_ot = elimina_comillas_2($_POST["contrato_ot"]);
$estado_actual_del_proceso=elimina_comillas_2($_POST["estado_actual_del_proceso"]);
$contrato_si_aplica =$contrato_tro_si.$contrato_ot;
$id_tipo_proceso_pecc = elimina_comillas_2($_POST["id_tipo_proceso_pecc"]);
$cargo_contable = elimina_comillas_2($_POST["cargo_contable"]);
$destino_ots = elimina_comillas_2($_POST["destino_orden_trabajo"]);
$duracion_ots = elimina_comillas_2($_POST["duracion_orden_trabajo"]);
$solicitud_relacionada = elimina_comillas_2($_POST["solicitud_que_carga"]);
$explode = explode("----,",$_POST["contratos_normales"]);
$conflicto_interes = elimina_comillas_2($_POST["conflicto_intereses"]);
$id_contrato_otro_si1 = $explode[1];
$post_tipo_proceso = $_POST["tipo_proceso"];
$antecedentes_texto = elimina_comillas_2($_POST["antecedentes_texto"]);

$explode_proveedor = explode("----,",$_POST["proveedores_busca"]);
$id_proveedor_relacionado = $explode_proveedor[1];



$explode2 = explode("---- ",$id_contrato_otro_si1);
$id_contrato_otro_si = $explode2[0];
$id_contrato_otro_si = str_replace("-","",$id_contrato_otro_si);
$id_contrato_otro_si = str_replace(" ","",$id_contrato_otro_si);
$id_contrato_otro_si = str_replace(",","",$id_contrato_otro_si);


$explode_gerente = explode("----,",$_POST["usuario_permiso"]);
$id_gerente_ot = $explode_gerente[1];
$num_solped = elimina_comillas_2($_POST["num_solped"]);
if($_POST["tipo_proceso"] == 8){
$id_tipo_proceso_pecc = 3;
}
if($_POST["tipo_proceso"] == 7){
$id_tipo_proceso_pecc = 2;
}


if($_POST["req_comite"] == 1){
$log_requiere_comite_extra = "SI";
$requiere_comite_extra = 1;
}else{
$log_requiere_comite_extra = "NO";
$requiere_comite_extra = 2;
}

if($_POST["conbierte_a_marco"]==1){
$convierte_marco=1;
$tex_log="SI";
}else{
$convierte_marco=2;
$tex_log="NO";
}



/*
$update_elim = query_db("update $pi9 set estado = 33 where t2_item_pecc_id = ".$id_item_pecc." and tipo = 'anexo_importante_comite'");

$tipo_anexo_nombre = "anexo_importante_comite";
$campo_file_nombre = $_FILES["anexo_importante_comite"]["name"];
$campo_file_temp = $_FILES["anexo_importante_comite"]["tmp_name"];
$campo_detalle = "Anexo para el Comite";


$inserta_procesos="insert into $pi9 (t2_item_pecc_id,tipo,detalle,adjunto,estado, id_us) values ('".$id_item_pecc."','".$tipo_anexo_nombre."','".$campo_detalle."','',1,".$_SESSION["id_us_session"].")";
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

$nombre_file = $tipo_anexo_nombre."_".$id_ingreso."_".$campo_file_nombre;
//$copiar = copy($campo_file_temp,'../../attfiles/pecc/'.$nombre_file);
$copiar = carga_archivo($campo_file_temp,'pecc/'.$id_ingreso."_2");

$actualiza_archivo= query_db("update $pi9 set adjunto = '".$campo_file_nombre."' where t2_anexo_id=".$id_ingreso);		

*/

if($_POST["tipo_proceso"] == 12){//si es reclasificacin
$sel_tipo_reclasificacion = traer_fila_row(query_db("select t1_tipo_documento_id, id_item from t7_contratos_contrato where id=".$id_contrato_otro_si));

	if($sel_tipo_reclasificacion[0] == 2) $convierte_marco = 3; $solicitud_relacionada =$sel_tipo_reclasificacion[1]; $comple_update = ", id_item_peec_aplica=".$sel_tipo_reclasificacion[1];

}

$insert = query_db("update $pi2 set id_pecc=$id_pecc,t1_area_id=".$_POST["area_usuaria"].",t1_tipo_proceso_id=".$_POST["tipo_proceso"].",fecha_se_requiere='$fecha_requiere',objeto_solicitud='$objeto_solicitud',objeto_contrato='$objeto_contrato',alcance='$alcance',justificacion='".$justificacion."', justificacion_tecnica='".$justificacion2."',recomendacion='$recomendacion', id_us_profesional_asignado='$us_prof', aprobacion_comite_adicional='".$requiere_comite_extra."', dondeo_adicional='".$_POST["req_sondeo"]."', contrato_id = '$id_contrato_otro_si', cargo_contable = '".$cargo_contable."', destino_ots='".$destino_ots."', duracion_ots='".$duracion_ots."',  t2_pecc_proceso_id = $id_tipo_proceso_pecc, id_gerente_ot = '".$id_gerente_ot."', id_solicitud_relacionada= '".$solicitud_relacionada."', criterios_evaluacion='$criterios_evaluacion', convirte_marco='$convierte_marco', num_solped='".$num_solped."', conflicto_intereses='".$conflicto_interes."', id_proveedor_relacionado='".$id_proveedor_relacionado."', antecedentes_permiso = '".$antecedentes_texto."', origen_pecc = '".$_POST["origen_pecc"]."',req_contra_mano_obra_local='".$_POST["req_contra_mano_obra_local"]."', req_contra_serv_bien_local='".$_POST["req_cont_bien_ser_local"]."', req_crear_otro_si='".$_POST["req_crear_otro_si"]."'  where id_item = $id_item_pecc");

if($post_tipo_proceso == 15){ // Modificacion - clonar informacion de adjudicacion en la nueva solicitud
	$pecc_relacionada = traer_fila_db(query_db("select id_solicitud_relacionada from $pi2 where id_item = $id_item_pecc "));
	if($pecc_relacionada['id_solicitud_relacionada']){
		$id_solicitud_relacionada = $pecc_relacionada['id_solicitud_relacionada'];
		$sel_relacionada = traer_fila_db(query_db("select ob_contrato_adjudica, alcance_adjudica, recomendacion_adjudica,ob_solicitud_adjudica,justificacion_tecnica_ad from $pi2 where id_item = ".$id_solicitud_relacionada));
		$update_mod_adj = query_db("update $pi2 set ob_contrato_adjudica = '$sel_relacionada[ob_contrato_adjudica]',
													alcance_adjudica = '$sel_relacionada[alcance_adjudica]',
													recomendacion_adjudica = '$sel_relacionada[recomendacion_adjudica]',
													ob_solicitud_adjudica = '$sel_relacionada[ob_solicitud_adjudica]',
													justificacion_tecnica_ad = '$sel_relacionada[justificacion_tecnica_ad]' where id_item = $id_item_pecc");
		
		$sel_pres_adj = query_db("select * from $pi8 where t2_item_pecc_id = $id_solicitud_relacionada and permiso_o_adjudica = 2");
		$del_pres_adj = query_db("delete from $pi8 where t2_item_pecc_id = $id_item_pecc and permiso_o_adjudica = 2");
		while($rowSPA = traer_fila_db($sel_pres_adj)){	
			$insert_SPA = "insert into $pi8 (t2_item_pecc_id, t1_campo_id, adjunto, valor_usd, valor_cop, ano, permiso_o_adjudica, destino_final, id_item_ots_aplica, cargo_contable, al_valor_inicial_para_marco) values
						($id_item_pecc,$rowSPA[t1_campo_id],'$rowSPA[adjunto]',$rowSPA[valor_usd],$rowSPA[valor_cop],$rowSPA[ano],$rowSPA[permiso_o_adjudica],'$rowSPA[destino_final]','$rowSPA[id_item_ots_aplica]','$rowSPA[cargo_contable]','$rowSPA[al_valor_inicial_para_marco]')";
			
			$sql_ex=query_db($insert_SPA.$trae_id_insrte);
			$id_ingreso = id_insert($sql_ex);
			$sel_rel_prov = traer_fila_db(query_db("select * from $pi18 where t2_presupuesto_id = $rowSPA[t2_presupuesto_id]"));
			$insert_relacion_proveedor = query_db("insert into $pi18 (t2_presupuesto_id, t1_proveedor_id,t1_tipo_documento_id,vigencia_mes, apellido) values 
												($id_ingreso,$sel_rel_prov[t1_proveedor_id],$sel_rel_prov[t1_tipo_documento_id],$sel_rel_prov[vigencia_mes],'$sel_rel_prov[apellido]')");
		}//end while
	}// end if pecc_relacionada
}//end if modificacion


/*
$nivel_servicio = traer_fila_row(query_db("select t2_nivel_servicio_id from $vpeec2 where id_item=".$id_item_pecc));
$upda_item = query_db("update $pi2 set t2_nivel_servicio_id=".$nivel_servicio[0]." where id_item=".$id_item_pecc);
*/
valida_firmas_que_estan_creadas_permiso($id_item_pecc);

if($_POST["req_sondeo"] == 1){
$log_requiere_sondeo = "SI";
$sele_si_ya_tiene_sondeo = traer_fila_row(query_db("select count(*) from $pi17 where id_item = ".$id_item_pecc." and estado = 1 and t2_nivel_servicio_actividad_id = 3"));

if($sele_si_ya_tiene_sondeo[0] > 0){
$estado_item = 6;
}else{
$insert_gestion_3 = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado,hora,observacion) values (".$id_item_pecc.",3,18463, '".$fecha."',0,1,'".$hora."','Gestion Automatica por el Sistema')");
$estado_item = 4;
}

}else{



$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item_pecc." and t2_nivel_servicio_encargado_id = 2"));
if(esprofesionalcompras($id_item_pecc)=="SI"){
$estado_item = $estado_actual_del_proceso;
}else{
$estado_item = $sel_estado[0];
}

$log_requiere_sondeo = "NO";
}



$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc);

/* -------------------- LOG ---------------------------------*/

$id_log = log_de_procesos_sgpa(2, 5, 7, $id_item_pecc, $_POST["estado_actual_del_proceso"], $estado_item);//actualiza general
if($_POST["origen_pecc"]==0) $pecc_origen_text = "Ninguno"; else $pecc_origen_text = $_POST["origen_pecc"];
log_agrega_detalle ($id_log, "Preparador", $_POST["id_preparador_solicitud"], "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Gerente de Item / Solicitante", $_POST["gerente_contra"], "t1_us_usuarios",2);
log_agrega_detalle ($id_log, "Pecc de Origen",  $pecc_origen_text , "",3);

log_agrega_detalle ($id_log, "Tipo de Proceso", $_POST["tipo_proceso"], "t1_tipo_proceso",4);
log_agrega_detalle ($id_log, "Area", $_POST["area_usuaria"], "t1_area",5);
log_agrega_detalle ($id_log, "Fecha para cuando se Requiere", $fecha_requiere, "",6);
log_agrega_detalle ($id_log, "Profesional Designado", $us_prof, "t1_us_usuarios",6);
log_agrega_detalle ($id_log, "Require Sondeo", $log_requiere_sondeo, "",6);

log_agrega_detalle ($id_log, "Proceso Especial o Anticipo, Requiere Aprobacion Extra del Comite", $log_requiere_comite_extra, "",6);

log_agrega_detalle ($id_log, "Objeto del Contrato", $objeto_contrato, "",8);
log_agrega_detalle ($id_log, "Alcance", $alcance, "",9);
log_agrega_detalle ($id_log, "Justificacion Comercial", $justificacion, "",11);
log_agrega_detalle ($id_log, "Justificacion Tecnica", $justificacion2, "",11);
log_agrega_detalle ($id_log, "Criterios de Evaluacion", $criterios_evaluacion, "",11);
log_agrega_detalle ($id_log, "Recomendacion", $recomendacion, "",12);

if($id_tipo_contratacion <> 1){
log_agrega_detalle ($id_log, "Numero de Solped", $num_solped_comp, "",4);
}			
if($_POST["tipo_proceso"] == 4 or $_POST["tipo_proceso"] == 5 or $_POST["tipo_proceso"] == 11 or $_POST["tipo_proceso"] == 12) {
log_agrega_detalle ($id_log, "Contrato", $id_contrato_otro_si, "t7_contratos_contrato",5);
log_agrega_detalle ($id_log, "Convierte el Contrato a Marco", $tex_log, "",6);
log_agrega_detalle ($id_log, "Solicitud Relacionada", $solicitud_relacionada, "t2_item_pecc",7);
}			
if($_POST["tipo_proceso"] == 8){
log_agrega_detalle ($id_log, "Gerente de OT", $id_gerente_ot, "t1_us_usuarios",3);
log_agrega_detalle ($id_log, "Trabajo a Realizarse Mediante esta OT", $objeto_solicitud, "",7);
log_agrega_detalle ($id_log, "Destino de la OT", $destino_ots, "",13);
log_agrega_detalle ($id_log, "Duracion de la OT", $duracion_ots, "",14);
}else{
log_agrega_detalle ($id_log, "Objeto Solicitud", $objeto_solicitud, "",7);
}

/*VARIABLE SPARA OBJETIVOS DEL PROCESO*/
$grabas_objetivos_proceso="SI";
$id_item_para_grabar_ob_proceso=$id_item_pecc;
		$adj_permiso=1;
/* FIN VARIABLE SPARA OBJETIVOS DEL PROCESO*/
/* -------------------- LOG ---------------------------------*/
?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?

}

if($_POST["accion"]=="graba_solped_compra"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$num_solped = elimina_comillas_2($_POST["num_solped"]);

$insert = query_db("update $pi2 set num_solped = '".$num_solped."', estado = 6 where id_item = $id_item_pecc");
agrega_gestion_pecc($id_item_pecc, 2, $fecha, 0);
?>
<script>
    alert("El numero de solped se grabo con exito");
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');
</script>
<?
}


if($_POST["accion"]=="graba_presupuesto_item_edita"){
$mensaje = "";

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$fecha_requiere = elimina_comillas_2($_POST["fecha"]);
$us_prof = elimina_comillas_2($_POST["us_prof"]);
$objeto_solicitud = elimina_comillas_2($_POST["objeto_solicitud"]);
$objeto_contrato = elimina_comillas_2($_POST["objeto_contrato"]);
$alcance = elimina_comillas_2($_POST["alcance"]);
$proveedores_sugeridos = elimina_comillas_2($_POST["proveedores_sugeridos"]);
$justificacion = elimina_comillas_2($_POST["justificacion"]);
$justificacion2 = elimina_comillas_2($_POST["justificacion2"]);
$criterios_evaluacion = elimina_comillas_2($_POST["criterios_evaluacion"]);
$recomendacion = elimina_comillas_2($_POST["recomendacion"]);
$id_pecc = elimina_comillas_2($_POST["id_pecc_seleccion"]);
$tipo_graba = elimina_comillas_2($_POST["tipo_graba"]);
$id_trm_aplica = elimina_comillas_2($_POST["id_trm_aplica"]);
$contrato_tro_si = elimina_comillas_2($_POST["contrato_tro_si"]);
$contrato_ot = elimina_comillas_2($_POST["contrato_ot"]);
$contrato_si_aplica =$contrato_tro_si.$contrato_ot;
$id_tipo_proceso_pecc = elimina_comillas_2($_POST["id_tipo_proceso_pecc"]);
$id_tipo_contratacion = elimina_comillas_2($_POST["id_tipo_contratacion"]);
$cargo_contable = elimina_comillas_2($_POST["cargo_contable"]);
$destino_ots = elimina_comillas_2($_POST["destino_orden_trabajo"]);
$duracion_ots = elimina_comillas_2($_POST["duracion_orden_trabajo"]);
$num_solped = elimina_comillas_2($_POST["num_solped"]);
$solicitud_relacionada = elimina_comillas_2($_POST["solicitud_que_carga"]);
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
$tipo_proceso = $_POST["tipo_proceso"];

$explode_proveedor = explode("----,",$_POST["proveedores_busca"]);
$id_proveedor_relacionado = $explode_proveedor[1];


$explode = explode("----,",$_POST["contratos_normales"]);
$id_contrato_otro_si1 = $explode[1];

$explode2 = explode("---- ",$id_contrato_otro_si1);
$id_contrato_otro_si = $explode2[0];
$id_contrato_otro_si = str_replace("-","",$id_contrato_otro_si);
$id_contrato_otro_si = str_replace(" ","",$id_contrato_otro_si);
$id_contrato_otro_si = str_replace(",","",$id_contrato_otro_si);

$explode_gerente = explode("----,",$_POST["usuario_permiso"]);
$id_gerente_ot = $explode_gerente[1];

if($_POST["req_comite"] == 1){
$log_requiere_comite_extra = "SI";
$requiere_comite_extra = 1;
}else{
$log_requiere_comite_extra = "NO";
$requiere_comite_extra = 2;
}

if($_POST["conbierte_a_marco"]==1){
$convierte_marco=1;
$tex_log="SI";
}else{
$convierte_marco=2;
$tex_log="NO";
}

$area_usuaria = $_POST["area_usuaria"];
/* * *** validar el Gerente de la OT pertenece a la misma area_usuaria del proyecto **** */
if ($_POST["es_admin_ot"] == "SI" && $_POST["tipo_proceso"] == 8) {// Tipo proceso 8: Ordenes de trabjo
    $validate = traer_fila_row(query_db("select * from $ts3 where id_usuario = $id_gerente_ot and id_area = $area_usuaria"));
    if ($validate) {
        
    } else {
        ?>
        <script>
            alert("ALERTA: El Gerente de la OT no pertenece al \u00e1rea usuaria. ");
            window.parent.document.getElementById("cargando_pecc").style.display = "none";
        </script>
        <?php
        var_dump($validate);
        die;
	}
}

if($_POST["tipo_proceso"] == 12){//si es reclasificacin
$sel_tipo_reclasificacion = traer_fila_row(query_db("select t1_tipo_documento_id, id_item from t7_contratos_contrato where id=".$id_contrato_otro_si));

	if($sel_tipo_reclasificacion[0] == 2) {
		$convierte_marco = 3; $solicitud_relacionada =$sel_tipo_reclasificacion[1]; $comple_update = ", id_item_peec_aplica=".$sel_tipo_reclasificacion[1];
		
		$sel_valor_1 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from t2_presupuesto where t2_item_pecc_id=".$id_item_pecc." and al_valor_inicial_para_marco is null "));
		$valor_1 = number_format($sel_valor_1[0] + ($sel_valor_1[1]/$trm=trm_presupuestal()), 0);
		$sel_valor_2 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from t2_presupuesto where t2_item_pecc_id=".$id_item_pecc." and al_valor_inicial_para_marco =1 "));
		$valor_2 = number_format($sel_valor_2[0] + ($sel_valor_2[1]/$trm=trm_presupuestal()), 0);
		echo "***".$valor_1." = ".$valor_2;
		if($valor_1 !=$valor_2 and $tipo_graba == 2){
			?><script>alert("Para poder poner en firme la reclasificacion el valor que solicita reclasificar debe ser el mismo que distribuye para reclasificar")</script>
            <script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
			<?
			exit;
			}
		
	}

}

$sql_edicion = "update $pi2 set id_pecc=$id_pecc,t1_area_id=".$_POST["area_usuaria"].",t1_tipo_proceso_id=".$_POST["tipo_proceso"].",fecha_se_requiere='$fecha_requiere',objeto_solicitud='$objeto_solicitud',objeto_contrato='$objeto_contrato',alcance='$alcance',justificacion='$justificacion',justificacion_tecnica='$justificacion2',recomendacion='$recomendacion', id_us_profesional_asignado='$us_prof', contrato_id = '$id_contrato_otro_si',aprobacion_comite_adicional='".$requiere_comite_extra."',dondeo_adicional='".$_POST["req_sondeo"]."', id_us = ".$_POST["gerente_contra"].", cargo_contable = '".$cargo_contable."', destino_ots='".$destino_ots."', duracion_ots='".$duracion_ots."', id_gerente_ot = '".$id_gerente_ot."', id_solicitud_relacionada= '".$solicitud_relacionada."', criterios_evaluacion='$criterios_evaluacion', convirte_marco = '$convierte_marco', num_solped='".$num_solped."', id_proveedor_relacionado='".$id_proveedor_relacionado."' ".$comple_update.",req_contra_mano_obra_local='".$_POST["req_contra_mano_obra_local"]."', req_contra_serv_bien_local='".$_POST["req_cont_bien_ser_local"]."', req_crear_otro_si='".$_POST["req_crear_otro_si"]."'  where id_item = $id_item_pecc";

$insert = query_db($sql_edicion);

if($tipo_proceso == 15){
}//end if modificacion


if($tipo_graba == 2){

if($sel_item[14] == 31 and $sel_item[6]==8){//si es completamiento y es OT
$sel_si_tiene_correos = traer_fila_row(query_db("select count(*) from t2_item_ot_correo_relacion_item where id_item = $id_item_pecc "));
if($sel_si_tiene_correos[0]==0){
$text_arr = "No se puede poner en firme, debe seleccionar por lo menos un correo del contratista para enviar la OT";
}




if($text_arr <> ""){
?><script>alert("<?= $text_arr ?>")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?
exit;
}

}//FIN si es completamiento y es OT

/* VALIDA QUE TENGA DISPONIBLE PARA CREAR SOLICITUDES DE SERVICIOS MENORES*/
if($sel_item[6]==16){
	
	$sel_presu = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id =".$id_item_pecc." and permiso_o_adjudica = 1"));
	$valor_solicitud = $sel_presu[0] + ($sel_presu[1]/trm_actual());
	
	if($valor_solicitud <=0 or $valor_solicitud >$_SESSION["valor_maximo_ser_menor"]){
	$text_arr_ser_men= " > Debe ingresar el valor del servicio menor entre USD$ 1 y ".number_format($_SESSION["valor_maximo_ser_menor"],0).", usted esta solicitando USD$ ".$valor_solicitud." ";
	}
	$sel_proveedores = traer_fila_row(query_db("select count(*) from t2_relacion_proveedor where id_item = ".$id_item_pecc." and estado = 1"));
	if($sel_proveedores[0]>0){
		$sel_anexos = traer_fila_row(query_db("select count(*) from t2_anexo where t2_item_pecc_id = ".$id_item_pecc." and estado = 1 and tipo = 'anexo'"));
		if($sel_anexos[0]<=0){
	$text_arr_ser_men2= " > Debe cargar las cotizaciones de los proveedores sugeridos, en el link 'anexos y antecedentes'.";		
			}
		}
				$algun_proveedor_arriba_25000="NO";
				$sel_proveedores_lista = query_db("select * from t2_relacion_proveedor where id_item =".$id_item_pecc);
				while($sel_p_list = traer_fila_db($sel_proveedores_lista)){
					$valores_sm = 0;					
					$valores_sm = explode("*",disponible_serv_menor_ano_atras($sel_p_list[2], $id_item_pecc));
					//[0]=total_comprometido --- [1]=comprometido_sap --- [2]=comprometido_no_sap --- [3]=valor_solicitud_Actual --- [4] Disponible
					if($valores_sm[4] < 0){
						$algun_proveedor_arriba_25000="SI";// hay un proveedor sin disponible
						}					
					}
	if($algun_proveedor_arriba_25000=="SI"){
	$text_arr_ser_men3= " > Algunos proveedores no tienen disponible para crear servicios menores por favor verificar el reporte en el link 'Proveedores - Reporte Servicios Menores'.";		
			}
	
	if($text_arr_ser_men != "" or $text_arr_ser_men2 != "" or $text_arr_ser_men3 != ""){
		?>
		<script>alert("No se puede poner en firme la solicitud por que \n<?=$text_arr_ser_men?>\n<?=$text_arr_ser_men2?>\n<?=$text_arr_ser_men3?>")
        window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
		<?
		exit;
		}

		

}/* FIN VALIDA QUE TENGA DISPONIBLE PARA CREAR SOLICITUDES DE SERVICIOS MENORES*/

}



/*
$nivel_servicio = traer_fila_row(query_db("select t2_nivel_servicio_id from $vpeec2 where id_item=".$id_item_pecc));
$upda_item = query_db("update $pi2 set t2_nivel_servicio_id=".$nivel_servicio[0]." where id_item=".$id_item_pecc);
*/
valida_firmas_que_estan_creadas_permiso($id_item_pecc);	
if($tipo_graba == 1){
$estado_item = 31;
}
if($tipo_graba == 2){
	
	if($tipo_proceso == 12 and $sel_item[49]!=3){// Si es reclasificacion: la solicitud debe ser 0
	$valor_usd = 0;
	$valor_cop = 0;
		$sel_val_presu = query_db("select valor_usd,valor_cop from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc);
		while($rowSVP = traer_fila_db($sel_val_presu)){
			$valor_usd += $rowSVP['valor_usd'];
			$valor_cop += $rowSVP['valor_cop'];
			}
		if($valor_usd == 0 && $valor_cop == 0){
			$ok_presupuesto = "SI";
			}
		else{$ok_presupuesto = "NO";
		?><script>
			alert("ALERTA: Para poder poner en firme las solicitudes tipo (Reclasificacion) el valor de la Solicitud debe tener valores en cero (0) ")
		
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
	window.parent.document.getElementById("cargando_pecc").style.display = "none";
</script>
		<?
		exit;
		}
	}// Fin Si es reclasificacion


$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from v_pecc_estado_actividad where id_item=".$id_item_pecc." and actividad_estado_id not in (1,14)"));

$estado_item = $sel_estado[0];

}

$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc);


$sel_numero1 =traer_fila_row(query_db("select numero, nombre from $pi1 where id_pecc=".$id_pecc));
if($tipo_graba == 1){
$mensaje = "El Item se guardo con Exito en ".$sel_numero1[1];
}
if($tipo_graba == 2){


//BUSCA Y SELEECIONA EL PROFESIONAL ENCARGADO
if($id_gerente_ot == 0 or $id_gerente_ot == ""){
$id_usuario_gerente = $_POST["gerente_contra"];
}else{
$id_usuario_gerente = $id_gerente_ot;	
}



$sel_profss_especifico_usuario_area = traer_fila_row(query_db("select id_us_profesional, id_us_prof_compras_corp, id_us_prof_compras_mro, id_us_prof_compras_stok, id_us_prof_servicios_menores from tseg10_usuarios_profesional where id_area = ".$_POST["area_usuaria"]." and id_us =  '$id_usuario_gerente'"));

$profesional_asig=0;

$el_gerente = saber_gerente_cotrato($id_item_pecc);
$sele_permiso = traer_fila_row(query_db("select * from $v_seg1 where us_id = ".$el_gerente." and id_premiso = 30"));//verificar si es el profesioanl de compras nanky


if($id_tipo_contratacion==1){//profesional de servicios
$profesional_asig= $sel_profss_especifico_usuario_area[0];
}else{//profesional de compras
if($id_tipo_contratacion==2){
$profesional_asig= $sel_profss_especifico_usuario_area[2];
}
if($id_tipo_contratacion==3){
$profesional_asig= $sel_profss_especifico_usuario_area[3];
}
if($id_tipo_contratacion==4){
$profesional_asig= $sel_profss_especifico_usuario_area[1];
}
}

if($sel_item[6]==16){//Si es servicios_menores
	$profesional_asig= $sel_profss_especifico_usuario_area[4];
	}


if($profesional_asig>0){
$profesional_seleccionado = $profesional_asig;

}else{

$sele_si_es_profesional = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos where id_usuario=".$_POST["gerente_contra"]." and id_permiso = 8"));
	if($sele_si_es_profesional[0] > 0){//si el solicitante tiene permiso de profesional
		$profesional_seleccionado = $_POST["gerente_contra"];
	}
}

if( $sele_permiso[0] > 0){//si el gerente es el mismo profesional de compras nanky
$profesional_seleccionado = $el_gerente;
}


/* si es de servicios y es una OT - asigna profesional a paula rojas*/
if($sel_item[6] == 8 and $sel_item[4] == 1){
	$selec_tipo_contras = traer_fila_row(query_db("select count(*) from t7_contratos_contrato where id_item = ".$sel_item[26]." and tipo_bien_servicio = 'Bienes'"));
	if($selec_tipo_contras[0] > 0){
		$profesional_seleccionado = 18433;
		}
}
/* FIN si es de servicios y es una OT - asigna profesional a paula rojas*/

$upda_item = query_db("update $pi2 set id_us_profesional_asignado = ".$profesional_seleccionado." where id_item=".$id_item_pecc);




// FIN BUSCA Y ASIGAN PROFESIONAL
$selec_si_hay_numero = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item = ".$id_item_pecc));
if($selec_si_hay_numero[0] == "" and $selec_si_hay_numero[1] == "" and $selec_si_hay_numero[2] == ""){				


if($id_tipo_contratacion==2 or $id_tipo_contratacion==3 or $id_tipo_contratacion==4){
$numero1 = "B";	
}else if ($sel_item[6]==16){
	$numero1 = "SM";	
	}else{
$numero1 = $sel_numero1[0];	
}


$fecha_separa = explode("-",$fecha);
$fecha_separa2 = substr($fecha_separa[0],2,4);
$numero2 = $fecha_separa2;
$selec_numero3 = traer_fila_row(query_db("select max(num3) from $pi2 where num2 = '$numero2'"));
$numero3 = $selec_numero3[0]+1;

$upda_item = query_db("update $pi2 set num1='$numero1',num2='$numero2', num3='$numero3' where id_item=".$id_item_pecc);
}else{
$numero1=$selec_si_hay_numero[0];
$numero2=$selec_si_hay_numero[1];
$numero3=$selec_si_hay_numero[2];
}
/* verifica si tiene presupuesto*/	
$sel_si_tiene_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc));
if($sel_si_tiene_presu[0]<=0){
$mensaje = "ALERTA: Para poder poner en firme debe ingresar el presupuesto, SGPA tambien recibe valores en cero (0)";

}else{	


$mensaje = "El Item se Creo con Exito en ".$sel_numero1[1]." con Numero: ".numero_item_pecc($numero1,$numero2,$numero3);
if($id_pecc == 1){
if($sel_item[6]<>6){
$etapa_gestion = 1;
}else{
$etapa_gestion = 6;
}
agrega_gestion_pecc($id_item_pecc, $etapa_gestion, $fecha, 0);

$sele_aprobacion = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = $id_item_pecc and id_rol = 15  and estado =1 order by orden asc"));
if($sele_aprobacion[0] > 0){

$insert_aprobacion = query_db("insert into $pi16 (id_secuencia_solicitud,id_us,fecha,aprobado, observacion) values (".$sele_aprobacion[0].", ".$_SESSION["id_us_session"].",'".$fecha."',1, '".$texto_declara_intereses."')");
}



}else{//si es del PECC
agrega_gestion_pecc($id_item_pecc, 14, $fecha, 0);
$sele_aprobacion = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = $id_item_pecc and id_rol = 15  and estado =1 order by orden asc"));
if($sele_aprobacion[0] > 0){

$insert_aprobacion = query_db("insert into $pi16 (id_secuencia_solicitud,id_us,fecha,aprobado) values (".$sele_aprobacion[0].", ".$_SESSION["id_us_session"].",'".$fecha."',1)");
}
}

}/* FIN verifica si tiene presupuesto*/

}

/* -------------------- LOG ---------------------------------*/
if($tipo_graba == 1){
$id_log = log_de_procesos_sgpa(2, 5, 7, $id_item_pecc, $_POST["estado_actual_del_proceso"], $estado_item);//actualiza general
}
if($tipo_graba == 2){
$id_log = log_de_procesos_sgpa(2, 3, 0, $id_item_pecc, $_POST["estado_actual_del_proceso"], $estado_item);//crea general
}

log_agrega_detalle ($id_log, "Preparador", $_POST["id_preparador_solicitud"], "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Gerente de Item / Solicitante", $_POST["gerente_contra"], "t1_us_usuarios",2);
log_agrega_detalle ($id_log, "Tipo de Proceso", $_POST["tipo_proceso"], "t1_tipo_proceso",4);
log_agrega_detalle ($id_log, "Area", $_POST["area_usuaria"], "t1_area",5);
log_agrega_detalle ($id_log, "Fecha para cuando se Requiere", $fecha_requiere, "",6);
log_agrega_detalle ($id_log, "Profesional Designado", $sel_profss[0], "t1_us_usuarios",6);
log_agrega_detalle ($id_log, "Require Sondeo", $log_requiere_sondeo, "",6);

log_agrega_detalle ($id_log, "Proceso Especial o Anticipo, Requiere Aprobacion Extra del Comite", $log_requiere_comite_extra, "",6);

log_agrega_detalle ($id_log, "Objeto del Contrato", $objeto_contrato, "",8);
log_agrega_detalle ($id_log, "Alcance", $alcance, "",9);
log_agrega_detalle ($id_log, "Justificacion Comercial", $justificacion, "",11);
log_agrega_detalle ($id_log, "Justificacion Tecnica", $justificacion2, "",11);
log_agrega_detalle ($id_log, "Criterios de Evaluacion", $criterios_evaluacion, "",11);
log_agrega_detalle ($id_log, "Recomendacion", $recomendacion, "",12);

if($id_tipo_contratacion <> 1){
log_agrega_detalle ($id_log, "Numero de Solped", $num_solped_comp, "",4);
}			
if($_POST["tipo_proceso"] == 4 or $_POST["tipo_proceso"] == 5 or $_POST["tipo_proceso"] == 11 or $_POST["tipo_proceso"] == 12) {
log_agrega_detalle ($id_log, "Contrato", $id_contrato_otro_si, "t7_contratos_contrato",5);
log_agrega_detalle ($id_log, "Convierte el Contrato a Marco", $tex_log, "",6);
log_agrega_detalle ($id_log, "Solicitud Relacionada", $solicitud_relacionada, "t2_item_pecc",7);



}			
if($_POST["tipo_proceso"] == 8){
log_agrega_detalle ($id_log, "Gerente de OT", $id_gerente_ot, "t1_us_usuarios",3);
log_agrega_detalle ($id_log, "Trabajo a Realizarse Mediante esta OT", $objeto_solicitud, "",7);
log_agrega_detalle ($id_log, "Destino de la OT", $destino_ots, "",13);
log_agrega_detalle ($id_log, "Duracion de la OT", $duracion_ots, "",14);
}else{
log_agrega_detalle ($id_log, "Objeto Solicitud", $objeto_solicitud, "",7);
}

/* -------------------- LOG ---------------------------------*/

/*VARIABLE SPARA OBJETIVOS DEL PROCESO*/
$grabas_objetivos_proceso="SI";
$id_item_para_grabar_ob_proceso=$id_item_pecc;
		$adj_permiso=1;
/* FIN VARIABLE SPARA OBJETIVOS DEL PROCESO*/

?>
<script>
    alert("<?= $mensaje ?>");
    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?

}




if($_POST["accion"]=="graba_presupuesto_item"){
$mensaje = "";
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));

$fecha_requiere = elimina_comillas_2($_POST["fecha"]);
$objeto_solicitud = elimina_comillas_2($_POST["objeto_solicitud"]);
$objeto_contrato = elimina_comillas_2($_POST["objeto_contrato"]);
$alcance = elimina_comillas_2($_POST["alcance"]);
$proveedores_sugeridos = elimina_comillas_2($_POST["proveedores_sugeridos"]);
$justificacion = elimina_comillas_2($_POST["justificacion"]);
$justificacion2 = elimina_comillas_2($_POST["justificacion2"]);
$criterios_evaluacion = elimina_comillas_2($_POST["criterios_evaluacion"]);
$recomendacion = elimina_comillas_2($_POST["recomendacion"]);
$id_pecc = elimina_comillas_2($_POST["id_pecc"]);
$tipo_graba = elimina_comillas_2($_POST["tipo_graba"]);
$id_trm_aplica = elimina_comillas_2($_POST["id_trm_aplica"]);
$contrato_tro_si = elimina_comillas_2($_POST["contrato_tro_si"]);
$contrato_ot = elimina_comillas_2($_POST["contrato_ot"]);
$contrato_si_aplica =$contrato_tro_si.$contrato_ot;
$id_item_pecc = elimina_comillas_2($_POST["id_item_pecc"]);
$id_tipo_proceso_pecc = elimina_comillas_2($_POST["id_tipo_proceso_pecc"]);
$id_tipo_contratacion = elimina_comillas_2($_POST["id_tipo_contratacion"]);
$num_solped_comp = elimina_comillas_2($_POST["num_solped"]);
$cargo_contable = elimina_comillas_2($_POST["cargo_contable"]);
$destino_ots = elimina_comillas_2($_POST["destino_orden_trabajo"]);
$duracion_ots = elimina_comillas_2($_POST["duracion_orden_trabajo"]);
$solicitud_relacionada = elimina_comillas_2($_POST["solicitud_que_carga"]);
$tipo_proceso = elimina_comillas_2($_POST["tipo_proceso"]);

$explode_proveedor = explode("----,",$_POST["proveedores_busca"]);
$id_proveedor_relacionado = $explode_proveedor[1];


$explode = explode("----,",$_POST["contratos_normales"]);
$id_contrato_otro_si1 = $explode[1];

$explode2 = explode("---- ",$id_contrato_otro_si1);
$id_contrato_otro_si = $explode2[0];
$id_contrato_otro_si = str_replace("-","",$id_contrato_otro_si);
$id_contrato_otro_si = str_replace(" ","",$id_contrato_otro_si);
$id_contrato_otro_si = str_replace(",","",$id_contrato_otro_si);

$explode_gerente = explode("----,",$_POST["usuario_permiso"]);
$id_gerente_ot = $explode_gerente[1];


$preparador = $_SESSION["id_us_session"];
$gerente_cont = $_POST["gerente_contra"];

if($_POST["req_comite"] == 1){
$log_requiere_comite_extra = "SI";
$requiere_comite_extra = 1;
}else{
$log_requiere_comite_extra = "NO";
$requiere_comite_extra = 2;
}

if($_POST["conbierte_a_marco"]==1){
$convierte_marco=1;
$tex_log="SI";
}else{
$convierte_marco=2;
$tex_log="NO";
}


$area_usuaria = $_POST["area_usuaria"];



/* * *** validar el Gerente de la OT pertenece a la misma area_usuaria del proyecto **** */
if ($_POST["es_admin_ot"] == "SI" && $_POST["tipo_proceso"] == 8) {// Tipo proceso 8: Ordenes de trabjo
    $validate = traer_fila_row(query_db("select * from $ts3 where id_usuario = $id_gerente_ot and id_area = $area_usuaria"));
    if ($validate) {
        
    } else {
        ?>
        <script>
            alert("ALERTA: El Gerente de la OT no pertenece al \u00e1rea usuaria. ");
            window.parent.document.getElementById("cargando_pecc").style.display = "none";
        </script>
        <?php
        var_dump($validate);
        die;
    }
}


if($_POST["tipo_proceso"] == 12){//si es reclasificacin
$sel_tipo_reclasificacion = traer_fila_row(query_db("select t1_tipo_documento_id, id_item from t7_contratos_contrato where id=".$id_contrato_otro_si));

	if($sel_tipo_reclasificacion[0] == 2) $convierte_marco = 3; $solicitud_relacionada =$sel_tipo_reclasificacion[1]; $id_item_pecc = $sel_tipo_reclasificacion[1];

}

$insert = "insert into $pi2 (id_pecc,t2_nivel_servicio_id,id_us,t1_tipo_contratacion_id,t1_area_id,t1_tipo_proceso_id,fecha_se_requiere,objeto_solicitud,objeto_contrato,alcance,proveedores_sugeridos,justificacion,recomendacion,estado,t1_trm_id,contrato_id,fecha_creacion,aprobacion_comite_adicional,dondeo_adicional,id_item_peec_aplica, aprobado,t2_pecc_proceso_id,id_us_preparador,num_solped,cargo_contable, destino_ots, duracion_ots,id_gerente_ot,id_solicitud_relacionada,justificacion_tecnica,criterios_evaluacion, convirte_marco, id_proveedor_relacionado) values ($id_pecc,0,".$gerente_cont.",".$id_tipo_contratacion.",".$_POST["area_usuaria"].",".$_POST["tipo_proceso"].",'$fecha_requiere','$objeto_solicitud','$objeto_contrato','$alcance','$proveedores_sugeridos','$justificacion','$recomendacion',31,$id_trm_aplica,'".$id_contrato_otro_si."','".$fecha." ".$hora."','".$requiere_comite_extra."',2,'".$id_item_pecc."',2,".$id_tipo_proceso_pecc.",$preparador,'".$num_solped_comp."','".$cargo_contable."', '".$destino_ots."', '".$duracion_ots."','".$id_gerente_ot."','".$solicitud_relacionada."','$justificacion2','$criterios_evaluacion','".$convierte_marco."', '".$id_proveedor_relacionado."')";


$sql_ex=query_db($insert.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

$upda_presupuesto = query_db("update $pi8 set t2_item_pecc_id = $id_ingreso where aleatorio='".$aleatorio."'");
$upda_anexos = query_db("update $pi9 set t2_item_pecc_id = $id_ingreso where aleatorio='".$aleatorio."'");
$id_item_pecc = $id_ingreso;

if($tipo_proceso == 15){
	
	
	
	}//end if modificacion


valida_firmas_que_estan_creadas_permiso($id_ingreso);
/*
$nivel_servicio = traer_fila_row(query_db("select t2_nivel_servicio_id from $vpeec2 where id_item=".$id_ingreso));
$upda_item = query_db("update $pi2 set t2_nivel_servicio_id=".$nivel_servicio[0]." where id_item=".$id_ingreso);
*/

if($tipo_graba == 1){
$estado_item = 31;
}
if($tipo_graba == 2){
	
	if($tipo_proceso == 12){// Si es reclasificacion: la solicitud debe ser 0
	$valor_usd = 0;
	$valor_cop = 0;
		$sel_val_presu = query_db("select valor_usd,valor_cop from t2_presupuesto where t2_item_pecc_id = ".$id_ingreso);
		while($rowSVP = traer_fila_db($sel_val_presu)){
			$valor_usd += $rowSVP['valor_usd'];
			$valor_cop += $rowSVP['valor_cop'];
			}
		if($valor_usd == 0 && $valor_cop == 0){
			$ok_presupuesto = "SI";
			}
		else{$ok_presupuesto = "NO";
		?><script>
			alert("ALERTA: Para poder poner en firme las solicitudes tipo (Reclasificacion) el valor de la Solicitud debe tener valores en cero (0) ")
		


    window.parent.ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?= $id_ingreso ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
	window.parent.document.getElementById("cargando_pecc").style.display = "none";
</script>
		<?
		exit;
		}
	}
	
$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_ingreso." and actividad_estado_id not in (1,14)"));
$estado_item = $sel_estado[0];

}
if(($estado_item == 31) and $_POST["tipo_proceso"] == 6){
$estado_item=14;
}


$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_ingreso);


if($tipo_graba == 1){
$mensaje = "El Item se guardo con Exito en ".$sel_numero1[1];
if($_POST["tipo_proceso"] == 6){ // si es adjudicacion directa pone el profesional correspondiente
$upda_item = query_db("update $pi2 set id_us_profesional_asignado = ".$_SESSION["id_us_session"]." where id_item=".$id_ingreso);						
}
}


if($tipo_graba == 2){



$sel_numero1 =traer_fila_row(query_db("select numero, nombre from $pi1 where id_pecc=".$id_pecc));

if($id_tipo_contratacion==2 or $id_tipo_contratacion==3 or $id_tipo_contratacion==4){
$numero1 = "B";	
}else{
$numero1 = $sel_numero1[0];	
}
$fecha_separa = explode("-",$fecha);
$fecha_separa2 = substr($fecha_separa[0],2,4);
$numero2 = $fecha_separa2;
$selec_numero3 = traer_fila_row(query_db("select max(num3) from $pi2 where num2 = '$numero2'"));
$numero3 = $selec_numero3[0]+1;

$upda_item = query_db("update $pi2 set num1='$numero1',num2='$numero2', num3='$numero3' where id_item=".$id_ingreso);


//BUSCA Y SELEECIONA EL PROFESIONAL ENCARGADO
if($id_gerente_ot == 0 or $id_gerente_ot == ""){
$id_usuario_gerente = $_POST["gerente_contra"];
}else{
$id_usuario_gerente = $id_gerente_ot;	
}





$sel_profss_especifico_usuario_area = traer_fila_row(query_db("select id_us_profesional, id_us_prof_compras_corp, id_us_prof_compras_mro, id_us_prof_compras_stok  from tseg10_usuarios_profesional where id_area = ".$_POST["area_usuaria"]." and id_us =  '$id_usuario_gerente'"));

$el_gerente = saber_gerente_cotrato($id_ingreso);
$sele_permiso = traer_fila_row(query_db("select * from $v_seg1 where us_id = ".$el_gerente." and id_premiso = 30"));//verificar si es el profesioanl de compras nanky




if($id_tipo_contratacion==1){//profesional de servicios
$profesional_asig= $sel_profss_especifico_usuario_area[0];
}else{//profesional de compras
if($id_tipo_contratacion==2){
$profesional_asig= $sel_profss_especifico_usuario_area[2];
}
if($id_tipo_contratacion==3){
$profesional_asig= $sel_profss_especifico_usuario_area[3];
}
if($id_tipo_contratacion==4){
$profesional_asig= $sel_profss_especifico_usuario_area[1];
}

}

if($profesional_asig>0){
$profesional_seleccionado = $profesional_asig;

}else{

$sele_si_es_profesional = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos where id_usuario=".$_POST["gerente_contra"]." and id_permiso = 8"));
	if($sele_si_es_profesional[0] > 0){//si el solicitante tiene permiso de profesional
		$profesional_seleccionado = $_POST["gerente_contra"];
	}

}



if( $sele_permiso[0] > 0){//si el gerente es el mismo profesional de compras nanky
$profesional_seleccionado = $el_gerente;
}


$upda_item = query_db("update $pi2 set id_us_profesional_asignado = ".$profesional_seleccionado." where id_item=".$id_ingreso);




// FIN BUSCA Y ASIGAN PROFESIONAL



$mensaje = "El Item se Creo con Exito en ".$sel_numero1[1]." con Numero: ".numero_item_pecc($numero1,$numero2,$numero3);

/* verifica si tiene presupuesto*/

$sel_si_tiene_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$id_ingreso));
if($sel_si_tiene_presu[0]<=0){
?><script>
    alert("ALERTA: Para poder poner en firme debe ingresar el presupuesto, SGPA tambien recibe valores en cero (0) ")
</script><?
}else{
if($id_pecc = 1){
agrega_gestion_pecc($id_ingreso, 1, $fecha, 0);
}else{
agrega_gestion_pecc($id_ingreso, $estado_item, $fecha, 0);
}

}

/* FIN verifica si tiene presupuesto*/


}


if($id_ingreso>=1){

/* -------------------- LOG ---------------------------------*/



if($tipo_graba == 1){			
$id_log = log_de_procesos_sgpa(2, 2, 0, $id_ingreso, "0", $estado_item);//crea general

}
if($tipo_graba == 2){
$id_log = log_de_procesos_sgpa(2, 3, 0, $id_ingreso, "0", $estado_item);//crea general

}

log_agrega_detalle ($id_log, "Preparador", $_SESSION["id_us_session"], "t1_us_usuarios",1);
log_agrega_detalle ($id_log, "Gerente de Item / Solicitante", $_POST["gerente_contra"], "t1_us_usuarios",2);
log_agrega_detalle ($id_log, "Tipo de Proceso", $_POST["tipo_proceso"], "t1_tipo_proceso",4);
log_agrega_detalle ($id_log, "Proceso Especial o Anticipo, Requiere Aprobacion Extra del Comite", $log_requiere_comite_extra, "",4);

log_agrega_detalle ($id_log, "Area", $_POST["area_usuaria"], "t1_area",5);
log_agrega_detalle ($id_log, "Fecha para cuando se Requiere", $fecha_requiere, "",6);
log_agrega_detalle ($id_log, "Profesional designado", $sel_profss[0], "t1_us_usuarios",1);

log_agrega_detalle ($id_log, "Objeto del Contrato", $objeto_contrato, "",8);
log_agrega_detalle ($id_log, "Alcance", $alcance, "",9);
log_agrega_detalle ($id_log, "Proveedores Sugeridos", $proveedores_sugeridos, "",10);
log_agrega_detalle ($id_log, "Justificacion Comercial", $justificacion, "",11);
log_agrega_detalle ($id_log, "Justificacion Tecnica", $justificacion2, "",11);
log_agrega_detalle ($id_log, "Criterios de Evaluacion", $criterios_evaluacion, "",11);
log_agrega_detalle ($id_log, "Recomendacion", $recomendacion, "",12);

if($id_tipo_contratacion <> 1){
log_agrega_detalle ($id_log, "Numero de Solped", $num_solped_comp, "",4);
}			
if($_POST["tipo_proceso"] == 4 or $_POST["tipo_proceso"] == 5 or $_POST["tipo_proceso"] == 11 or $_POST["tipo_proceso"] == 12) {
log_agrega_detalle ($id_log, "Contrato", $id_contrato_otro_si, "t7_contratos_contrato",5);
log_agrega_detalle ($id_log, "Convierte el Contrato a Marco", $tex_log, "",6);
log_agrega_detalle ($id_log, "Solicitud Relacionada", $solicitud_relacionada, "t2_item_pecc",7);
}			
if($_POST["tipo_proceso"] == 8){
log_agrega_detalle ($id_log, "Gerente de OT", $id_gerente_ot, "t1_us_usuarios",3);
log_agrega_detalle ($id_log, "Trabajo a Realizarse Mediante esta OT", $objeto_solicitud, "",7);
log_agrega_detalle ($id_log, "Destino de la OT", $destino_ots, "",13);
log_agrega_detalle ($id_log, "Duracion de la OT", $duracion_ots, "",14);
}else{
log_agrega_detalle ($id_log, "Objeto Solicitud", $objeto_solicitud, "",7);
}


$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id = ".$id_ingreso." and permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");

while($sel_presu = traer_fila_db($sele_presupuesto)){

$solicitud_aplica = $sel_presu[7];
$contratos_aplica="";

if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
$sel_contr = query_db("select t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
while($sel_apl = traer_fila_db($sel_contr)){
$contratos_aplica.= ",".$sel_apl[0];
}
}


$contratos_aplica = "0".$contratos_aplica;

if($tipo_graba == 1){			
$id_log_presupuesto = log_de_procesos_sgpa(2, 2, 1, $id_ingreso, "0", $estado_item);//agrega valores
}
if($tipo_graba == 2){
$id_log_presupuesto = log_de_procesos_sgpa(2, 3, 2, $id_ingreso, "0", $estado_item);//agrega valores
}

if($contratos_aplica <> "0"){
log_agrega_detalle ($id_log_presupuesto, "Contratos Marco Relacionados",$contratos_aplica , "t7_contratos_contrato",1);
}

log_agrega_detalle ($id_log_presupuesto, "Ano",$sel_presu[1] , "",2);
log_agrega_detalle ($id_log_presupuesto, "Area / Proyecto",$sel_presu[2] , "",3);
log_agrega_detalle ($id_log_presupuesto, "Valor USD$",$sel_presu[4] , "",4);
log_agrega_detalle ($id_log_presupuesto, "Valor COP$",$sel_presu[5] , "",5);
log_agrega_detalle ($id_log_presupuesto, "Adjunto",$sel_presu[3] , "",6);

if($id_tipo_contratacion <> 1){
log_agrega_detalle ($id_log_presupuesto, "Destino Fisico", $sel_presu[6], "",5);
log_agrega_detalle ($id_log_presupuesto, "Cargo Contable", $sel_presu[8], "",5);
}

if($_POST["tipo_proceso"] == 8){
log_agrega_detalle ($id_log_presupuesto, "Solicitud a la Cual Aplica la OT", $solicitud_aplica, "t2_item_pecc",5);
}
}

$sele_anexos = query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS TEXT), adjunto, estado, id_us
from $pi9 where t2_item_pecc_id = '".$id_ingreso."' and estado = 1 and (tipo = 'anexo' or tipo = 'antecedente')");
while($sl_anexos = traer_fila_db($sele_anexos)){

if($sl_anexos[3] == 'anexo' and $tipo_graba == 1){
$id_log_anexos = log_de_procesos_sgpa(2, 2, 3, $id_ingreso, "0", $estado_item);//agrega anexos
}
if($sl_anexos[3] == 'anexo' and $tipo_graba == 2){
$id_log_anexos = log_de_procesos_sgpa(2, 3, 5, $id_ingreso, "0", $estado_item);//agrega anexos
}
if($sl_anexos[3] == 'antecedente' and $tipo_graba == 1){
$id_log_anexos = log_de_procesos_sgpa(2, 2, 4, $id_ingreso, "0", $estado_item);//agrega antecedente
}
if($sl_anexos[3] == 'antecedente' and $tipo_graba == 2){
$id_log_anexos = log_de_procesos_sgpa(2, 3, 6, $id_ingreso, "0", $estado_item);//agrega antecedente
}


log_agrega_detalle ($id_log_anexos, "Detalle", $sl_anexos[4], "",1);
log_agrega_detalle ($id_log_anexos, "Adjunto", $sl_anexos[5], "",1);






}

if($tipo_graba == 2){
if($estado_item >= 6 and $estado_item < 14){
echo " * ".$estado_item."asd";
$id_log = log_de_procesos_sgpa(2, 6, 34, $id_ingreso, "0", $estado_item);//agrega valores
log_agrega_detalle ($id_log, "Usuario que Firmo",$_SESSION["id_us_session"] , "t1_us_usuarios",2);
}
if($estado_item >= 14 and $estado_item <> 31){
$id_log = log_de_procesos_sgpa(2, 15, 41, $id_ingreso, "0", $estado_item);//agrega valores
log_agrega_detalle ($id_log, "Usuario que Firmo",$_SESSION["id_us_session"] , "t1_us_usuarios",2);

}
}

/* -------------------- LOG ---------------------------------*/

if($tipo_proceso == 15){
	$link_envia="adjudicacion";
}else{
	$link_envia="edicion-item-pecc";
	}

?>
<script>
    alert("<?= $mensaje ?>");
    window.parent.ajax_carga('../aplicaciones/pecc/<?=$link_envia?>.php?id_item_pecc=<?= $id_ingreso ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&aplica_log=no', 'contenidos');
</script>
<?

/*VARIABLE SPARA OBJETIVOS DEL PROCESO*/
$grabas_objetivos_proceso="SI";
$id_item_para_grabar_ob_proceso=$id_ingreso;
if($_POST["tipo_proceso"] == 6){
	$adj_permiso=2;
	}else{
		$adj_permiso=1;
	}
}
/* FIN VARIABLE SPARA OBJETIVOS DEL PROCESO*/

else{
?>
<script>
    alert("ATENCIԎ:\nEl presupuesto NO se cre󠣯n 깩to")
</script>
<?


}

}


/*GRABA OBJETIVOS DEL PROCESO*/
if($grabas_objetivos_proceso=="SI"){
$campo_ingresa1="";
$campo_ingresa2="";
$campo_ingresa3="";
$campo_ingresa4="";
$campo_ingresa5="";
$campo_ingresa6="";
$campo_ingresa7="";

if($_POST["campos1"] != " " and $_POST["campos1"] != "  " and $_POST["campos1"] != "   "){$campo_ingresa1 = elimina_comillas_2($_POST["campos1"]);}
if($_POST["campos2"] != " " and $_POST["campos2"] != "  " and $_POST["campos2"] != "   "){$campo_ingresa2 = elimina_comillas_2($_POST["campos2"]);}
if($_POST["campos3"] != " " and $_POST["campos3"] != "  " and $_POST["campos3"] != "   "){$campo_ingresa3 = elimina_comillas_2($_POST["campos3"]);}
if($_POST["campos4"] != " " and $_POST["campos4"] != "  " and $_POST["campos4"] != "   "){$campo_ingresa4 = elimina_comillas_2($_POST["campos4"]);}
if($_POST["campos5"] != " " and $_POST["campos5"] != "  " and $_POST["campos5"] != "   "){$campo_ingresa5 = elimina_comillas_2($_POST["campos5"]);}
if($_POST["campos6"] != " " and $_POST["campos6"] != "  " and $_POST["campos6"] != "   "){$campo_ingresa6 = elimina_comillas_2($_POST["campos6"]);}
if($_POST["campos7"] != " " and $_POST["campos7"] != "  " and $_POST["campos7"] != "   "){$campo_ingresa7 = elimina_comillas_2($_POST["campos7"]);}



$sel_si_existe = traer_fila_row(query_db("select * from t2_objetivos_proceso where id_item = ".$id_item_para_grabar_ob_proceso));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_para_grabar_ob_proceso));

if($adj_permiso==1){			
$permiso_adj=1;
$edicion_datos = "SI";			
$oportunidad="p_oportunidad";
$costo="p_costo";
$calidad="p_calidad";
$optimizar="p_optimizar";
$trazabilidad="p_trazabilidad";
$transparencia="p_transparencia";
$sostenibilidad="p_sostenibilidad";
}

if($adj_permiso==2){			
$permiso_adj=2;			
$edicion_datos = "SI";
$oportunidad="a_oportunidad";
$costo="a_costo";
$calidad="a_calidad";
$optimizar="a_optimizar";
$trazabilidad="a_trazabilidad";
$transparencia="a_transparencia";
$sostenibilidad="a_sostenibilidad";

}


if($sel_si_existe[0]>0){//update
$insert_into=query_db("update t2_objetivos_proceso set $oportunidad='".$campo_ingresa1."', $costo='".$campo_ingresa2."',$calidad='".$campo_ingresa3."', $optimizar='".$campo_ingresa4."', $trazabilidad='".$campo_ingresa5."',$transparencia='".$campo_ingresa6."', $sostenibilidad='".$campo_ingresa7."' where id_item=".$id_item_para_grabar_ob_proceso);
}else{//crear
$insert = "insert into t2_objetivos_proceso (id_item, $oportunidad, $costo, $calidad, $optimizar, $trazabilidad, $transparencia, $sostenibilidad) values ( '".$id_item_para_grabar_ob_proceso."', '".$campo_ingresa1."', '".$campo_ingresa2."', '".$campo_ingresa3."', '".$campo_ingresa4."', '".$campo_ingresa5."', '".$campo_ingresa6."', '".$campo_ingresa7."')";
echo $insert;
$insert_into=query_db($insert);

}

if($tipo_proceso_para_ob_proceso==6 or $tipo_proceso_para_ob_proceso==15){// si es ad sondeo o modificacion actualiza la informacion del permiso

$insert_into=query_db("update t2_objetivos_proceso set p_oportunidad='".$campo_ingresa1."', p_costo='".$campo_ingresa2."',p_calidad='".$campo_ingresa3."', p_optimizar='".$campo_ingresa4."', p_trazabilidad='".$campo_ingresa5."',p_transparencia='".$campo_ingresa6."', p_sostenibilidad='".$campo_ingresa7."' where id_item=".$id_item_para_grabar_ob_proceso);

}

?><script>
    window.parent.document.getElementById("div_carga_busca_sol").style.display = 'none'
</script><?
}
/*FIN GRABA OBJETIVOS DEL PROCESO*/

if($_POST["accion"]=="elimina_anexo_edicion"){
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_anexo_elimina = elimina_comillas(arreglo_recibe_variables($_POST["id_anexo_elimina"]));
$id_tipo_proceso_pecc = elimina_comillas_2($_POST["id_tipo_proceso_pecc"]);

$sele_anexo = traer_fila_row(query_db("select * from $pi9 where t2_anexo_id=".$id_anexo_elimina));

//$delete_anexo = query_db("delete from $pi9 where t2_anexo_id=".$id_anexo_elimina);

$update_elim = query_db("update $pi9 set estado = 33 where t2_anexo_id = ".$id_anexo_elimina);

if($sele_anexo[3] == "anexo"){
$link_devuelve = "antecedentes";
$log_sub_ventana = 25;
}
if($sele_anexo[3] == "antecedente"){
$link_devuelve = "antecedentes";
$log_sub_ventana = 26;
}
if($sele_anexo[3] == "doc_basico"){
$link_devuelve = "negociacion";
$log_sub_ventana = 27;
}
if($sele_anexo[3] == "doc_ensamble"){
$link_devuelve = "negociacion";
$log_sub_ventana = 30;
}
if($sele_anexo[3] == "basicosondeo"){
$link_devuelve = "sondeo";
$log_sub_ventana = 28;
}
if($sele_anexo[3] == "ensamblesondeo"){
$link_devuelve = "sondeo";
$log_sub_ventana = 31;
}
if($sele_anexo[3] == "ob_ots"){
$link_devuelve = "ob_ots";
$log_sub_ventana = 29;
}



$id_log = log_de_procesos_sgpa(2, 5, $log_sub_ventana, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores
log_agrega_detalle ($id_log, "Detalle",$sele_anexo[4] , "",1);
log_agrega_detalle ($id_log, "Adjunto",$sele_anexo[5] , "",2);

?>
<script>
    //window.parent.ajax_carga('../aplicaciones/pecc/antecedentes.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>','contenidos');
    window.parent.ajax_carga('../aplicaciones/pecc/<?= $link_devuelve ?>.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');

</script>
<?
}
if($_POST["accion"]=="elimina_anexo"){
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$id_anexo_elimina = elimina_comillas(arreglo_recibe_variables($_POST["id_anexo_elimina"]));
if($_POST["tipo_anexo"] == 8){
$div = "carga_anexos";
$tipo_anexo_nombre = "anexo";
$campo_file_nombre = $_FILES["adj_anexo"]["name"];
$campo_file_temp = $_FILES["adj_anexo"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["anexo"]);
}
if($_POST["tipo_anexo"] == 9){
$tipo_anexo_nombre = "antecedente";
$div = "carga_antecedentes";
$campo_file_nombre = $_FILES["adj_antecedente"]["name"];
$campo_file_temp = $_FILES["adj_antecedente"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["ancedente"]);
}

//$selecciona_para_eliminar_archivo = traer_fila_row(query_db("select adjunto from $pi9 where t2_anexo_id=".$id_anexo_elimina));

//$elim = unlink("../../attfiles/pecc/".$selecciona_para_eliminar_archivo[0]);

//		$delete_anexo = query_db("delete from $pi9 where t2_anexo_id=".$id_anexo_elimina);
$update_elim = query_db("update $pi9 set estado = 33 where t2_anexo_id = ".$id_anexo_elimina);


?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=8&tipo_anexo=<?= $_POST["tipo_anexo"] ?>&aleatorio=<?= $aleatorio ?>&id_pecc=<?= $_POST["id_pecc"] ?>', '<?= $div ?>');

</script>
<?
}


if($_POST["accion"]=="graba_anexo_nuevo_edicion")
{

$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_tipo_proceso_pecc = elimina_comillas_2($_POST["id_tipo_proceso_pecc"]);
$antecedentes_para_comite = elimina_comillas(arreglo_recibe_variables($_POST["para_comite"]));
if($antecedentes_para_comite != 1){
	$antecedentes_para_comite=2;
	}

if($_POST["tipo_anexo"] == 8){
$div = "carga_anexos";
$tipo_anexo_nombre = "anexo";
$campo_file_nombre = $_FILES["adj_anexo"]["name"];
$campo_file_temp = $_FILES["adj_anexo"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["anexo"]);
$link_devuelve = "antecedentes";
$log_sub_ventana = 16;
}
if($_POST["tipo_anexo"] == 9){
$tipo_anexo_nombre = "antecedente";
$div = "carga_antecedentes";
$campo_file_nombre = $_FILES["adj_antecedente"]["name"];
$campo_file_temp = $_FILES["adj_antecedente"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["ancedente"]);
$link_devuelve = "antecedentes";
$log_sub_ventana = 24;
}
if($_POST["tipo_anexo"] == 10){
$tipo_anexo_nombre = "doc_basico";
$campo_file_nombre = $_FILES["adj_doc_basico"]["name"];
$campo_file_temp = $_FILES["adj_doc_basico"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["doc_basico"]);
$link_devuelve = "negociacion";
$log_sub_ventana = 17;
}
if($_POST["tipo_anexo"] == 11){
$tipo_anexo_nombre = "doc_ensamble";
$campo_file_nombre = $_FILES["adj_doc_ensamble"]["name"];
$campo_file_temp = $_FILES["adj_doc_ensamble"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["doc_ensamble"]);
$link_devuelve = "negociacion";
$log_sub_ventana = 18;
}
if($_POST["tipo_anexo"] == 12){
$tipo_anexo_nombre = "basicosondeo";
$campo_file_nombre = $_FILES["adj_doc_basico"]["name"];
$campo_file_temp = $_FILES["adj_doc_basico"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["doc_basico"]);
$link_devuelve = "sondeo";
$log_sub_ventana = 19;
}
if($_POST["tipo_anexo"] == 13){
$tipo_anexo_nombre = "ensamblesondeo";
$campo_file_nombre = $_FILES["adj_doc_ensamble"]["name"];
$campo_file_temp = $_FILES["adj_doc_ensamble"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["doc_ensamble"]);
$link_devuelve = "sondeo";
$log_sub_ventana = 20;
}
if($_POST["tipo_anexo"] == 14){
$div = "carga_anexos";
$tipo_anexo_nombre = "anexo_adjudicacion";
$campo_file_nombre = $_FILES["adj_anexo"]["name"];
$campo_file_temp = $_FILES["adj_anexo"]["tmp_name"];
if($datosExtemporaneos == "NO"){$campo_detalle = elimina_comillas_2($_POST["anexo"]);}
else{$campo_detalle = "Anexo Extemporaneo, cargado por el profesional designado el ".$fecha." - ".elimina_comillas_2($_POST["anexo"]);}
$link_devuelve = "anexos_adjudicacion";
$log_sub_ventana = 21;
}
if($_POST["tipo_anexo"] == 15){
$div = "carga_comunicados";
$tipo_anexo_nombre = "comu_devol_emuladores";
$campo_file_nombre = "";
$campo_file_temp = "";
$campo_detalle = elimina_comillas_2($_POST["comunicados"]);
$link_devuelve = "comunicados_devoluciones";
$log_sub_ventana = 22;
}

if($_POST["tipo_anexo"] == 16){
$div = "carga_comunicados";
$tipo_anexo_nombre = "ob_ots";
$campo_file_nombre = "";
$campo_file_temp = "";
$campo_detalle = elimina_comillas_2($_POST["comunicados"]);
$link_devuelve = "ob_ots";
$log_sub_ventana = 23;
}

if($_POST["tipo_anexo"] == 17){
$div = "carga_anexos";
$tipo_anexo_nombre = "anexo";
$campo_file_nombre = $_FILES["adj_anexo"]["name"];
$campo_file_temp = $_FILES["adj_anexo"]["tmp_name"];
$campo_detalle = "Anexo Extemporaneo, cargado por el profesional designado el ".$fecha." - ".elimina_comillas_2($_POST["anexo"]);
$link_devuelve = "antecedentes";
$log_sub_ventana = 69;
}

if($_POST["tipo_anexo"] == 18){
$div = "carga_anexos";
$tipo_anexo_nombre = "anexo";
$campo_file_nombre = $_FILES["adj_anexo"]["name"];
$campo_file_temp = $_FILES["adj_anexo"]["tmp_name"];
$campo_detalle = "Anexo de la Revision del item de adjudicacion, cargado por el gerente del ITEM el ".$fecha." - ".elimina_comillas_2($_POST["anexo"]);
$link_devuelve = "antecedentes";
$log_sub_ventana = 69;
}


if($_POST["tipo_anexo"] == 19){
$div = "carga_anexos";
$tipo_anexo_nombre = "anexo";
$campo_file_nombre = $_FILES["adj_anexo_".$id_item_pecc]["name"];
$campo_file_temp = $_FILES["adj_anexo_".$id_item_pecc]["tmp_name"];

$campo_detalle = "Anexo cargado desde el comite, cargado por el Secretario del comite el ".$fecha." - ".elimina_comillas_2($_POST["anexo_".$id_item_pecc]);
$link_devuelve = "NO";
$log_sub_ventana = 69;
}

$tabla_guarda=$pi9;
if($_POST["tipo_anexo"] == 20){
$div = "carga_anexos";
$tipo_anexo_nombre = "gestion_admin";
$campo_file_nombre = $_FILES["adj_anexo"]["name"];
$campo_file_temp = $_FILES["adj_anexo"]["tmp_name"];
$campo_detalle = "Gestion Administrativa, ".$fecha." - ".elimina_comillas_2($_POST["anexo"]);
$link_devuelve = "gestion_admin";
$log_sub_ventana = 86;
$tabla_guarda="t2_anexo_admin";

if($_POST["finaliza_solicitud_legal"] == "SI"){
	$campo_detalle = "Legal - Finaliza la Solicitud y Anula los documentos Contractuales relacionados, ".$fecha." - ".elimina_comillas_2($_POST["anexo"]);
	$update = query_db("update t2_item_pecc set estado = 32 where id_item = ".$id_item_pecc);
	$update_comple = query_db("update t7_contratos_complemento set eliminado = 1, estado = 50 where id_item_pecc = ".$id_item_pecc);
	

	$sel_contras = query_db("select id from t7_contratos_contrato where id_item = ".$id_item_pecc);
	while($sel_cont = traer_fila_db($sel_contras)){

	$update_contrato = query_db("update t7_contratos_contrato set estado = 50 where id = ".$sel_cont[0]);
	$insert_ob = query_db("insert into t7_acciones_admin (id_contrato, id_usuario, observacion, fecha, detalle) values (".$sel_cont[0].", '".$_SESSION["id_us_session"]."', '".$campo_detalle."', '".$fecha."', '1. Eliminar Contrato')");
	}
	
	}
}

$inserta_procesos="insert into $tabla_guarda (t2_item_pecc_id,tipo,detalle,adjunto,estado, id_us) values ('".$id_item_pecc."','".$tipo_anexo_nombre."','".$campo_detalle."','',1,".$_SESSION["id_us_session"].")";










//echo $inserta_procesos;
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);


if($id_ingreso>=1){
if($campo_file_nombre != ""){
$campo_file_nombre = str_replace("á","a",$campo_file_nombre);
$campo_file_nombre = str_replace("Á","a",$campo_file_nombre);
$campo_file_nombre = str_replace("é","e",$campo_file_nombre);
$campo_file_nombre = str_replace("É","e",$campo_file_nombre);
$campo_file_nombre = str_replace("í","i",$campo_file_nombre);
$campo_file_nombre = str_replace("Í","i",$campo_file_nombre);
$campo_file_nombre = str_replace("ó","o",$campo_file_nombre);
$campo_file_nombre = str_replace("�","o",$campo_file_nombre);
$campo_file_nombre = str_replace("ú","u",$campo_file_nombre);
$campo_file_nombre = str_replace("Ú","u",$campo_file_nombre);
$campo_file_nombre = str_replace("ñ","n",$campo_file_nombre);
$campo_file_nombre = str_replace("�'","n",$campo_file_nombre);
$campo_file_nombre = str_replace("&","",$campo_file_nombre);

$nombre_file = $tipo_anexo_nombre."_".$id_ingreso."_".$campo_file_nombre;
//$copiar = copy($campo_file_temp,'../../attfiles/pecc/'.$nombre_file);
$copiar = carga_archivo($campo_file_temp,'pecc/'.$id_ingreso."_2");

$actualiza_archivo= query_db("update $tabla_guarda set adjunto = '".$campo_file_nombre."' where t2_anexo_id=".$id_ingreso);
}

$id_log = log_de_procesos_sgpa(2, 5, $log_sub_ventana, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores
log_agrega_detalle ($id_log, "Detalle",$campo_detalle , "",1);
log_agrega_detalle ($id_log, "Fecha ",$fecha , "",1);
log_agrega_detalle ($id_log, "Adjunto",$campo_file_nombre , "",2);

if($link_devuelve=="NO"){
?>      <script> alert("El anexo se cargo correctamente por favor actualizar el comite")</script>
<?
}else{
?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/<?= $link_devuelve ?>.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>', 'contenidos');

</script>
<?
}
}
else{
?>
<script>
    alert("ATENCIԎ:\nEl Anexo NO se cre󠣯n 깩to")
</script>
<?


}

}	        

if($_POST["accion"]=="graba_anexo_nuevo")
{
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));



if($_POST["tipo_anexo"] == 8){
$div = "carga_anexos";
$tipo_anexo_nombre = "anexo";
$campo_file_nombre = $_FILES["adj_anexo"]["name"];
$campo_file_temp = $_FILES["adj_anexo"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["anexo"]);
}
if($_POST["tipo_anexo"] == 9){
$tipo_anexo_nombre = "antecedente";
$div = "carga_antecedentes";
$campo_file_nombre = $_FILES["adj_antecedente"]["name"];
$campo_file_temp = $_FILES["adj_antecedente"]["tmp_name"];
$campo_detalle = elimina_comillas_2($_POST["ancedente"]);
}

$inserta_procesos="insert into $pi9 (aleatorio,tipo,detalle,adjunto,estado, id_us) values ('".$aleatorio."','".$tipo_anexo_nombre."','".$campo_detalle."','',1,".$_SESSION["id_us_session"].")";
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

echo $campo_file."fer";


if($id_ingreso>=1){
if($campo_file_nombre != ""){

$campo_file_nombre = str_replace("á","a",$campo_file_nombre);
$campo_file_nombre = str_replace("Á","a",$campo_file_nombre);
$campo_file_nombre = str_replace("é","e",$campo_file_nombre);
$campo_file_nombre = str_replace("É","e",$campo_file_nombre);
$campo_file_nombre = str_replace("í","i",$campo_file_nombre);
$campo_file_nombre = str_replace("Í","i",$campo_file_nombre);
$campo_file_nombre = str_replace("ó","o",$campo_file_nombre);
$campo_file_nombre = str_replace("�","o",$campo_file_nombre);
$campo_file_nombre = str_replace("ú","u",$campo_file_nombre);
$campo_file_nombre = str_replace("Ú","u",$campo_file_nombre);
$campo_file_nombre = str_replace("ñ","n",$campo_file_nombre);
$campo_file_nombre = str_replace("�'","n",$campo_file_nombre);

$nombre_file = $tipo_anexo_nombre."_".$id_ingreso."_".$campo_file_nombre;
//$copiar = copy($campo_file_temp,'../../attfiles/pecc/'.$nombre_file);
$copiar = carga_archivo($campo_file_temp,'pecc/'.$id_ingreso."_2");

$actualiza_archivo= query_db("update $pi9 set adjunto = '".$nombre_file."' where t2_anexo_id=".$id_ingreso);
}

?>
<script>
    window.parent.ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=8&tipo_anexo=<?= $_POST["tipo_anexo"] ?>&aleatorio=<?= $aleatorio ?>&id_pecc=<?= $_POST["id_pecc"] ?>', '<?= $div ?>');
    window.parent.document.principal.anexo.value = ""
    window.parent.document.principal.adj_anexo.value = ""
    window.parent.document.principal.ancedente.value = ""
    window.parent.document.principal.adj_antecedente.value = ""

    window.parent.resetea_anexos.innerHTML = '<input name="adj_anexo" type="file" id="adj_anexo" size="5" />';
    window.parent.resetea_antecedente.innerHTML = '<input name="adj_antecedente" type="file" id="adj_antecedente" size="5" />';
</script>
<?
}
else{
?>
<script>
    alert("ATENCIԎ:\nEl Anexo NO se cre󠣯n 깩to")
</script>
<?


}

}	        


if($_POST["accion"]=="graba_presupuesto_nuevo_edita_adjudica_marco")
{
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd"])))+0;
$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop"])))+0;		
$valor_cop = number_format($valor_cop,0,'','');
$valor_usd = number_format($valor_usd,0,'','');

$vigencia_mes = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["vigencia_mes"])))+0;
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_marco"]));
$nombre = elimina_comillas_2($_POST["nom3"]);
$email = elimina_comillas_2($_POST["email3"]);
$dver = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["dver3"])));
$nit = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["nit3"])));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
$sele_trm = traer_fila_row(query_db("select valor from $g10 where id_trm=".$sel_item[15]));

$valor_adjudica = $valor_usd + ($valor_cop/$sele_trm[0]);


/* ----------- valida que tenga por lo menos un contrato*/
$tiene_seleccionado = "NO";

$sele_contratos = query_db("select t2.id_relacion, t3.razon_social, t2.apellido from t2_presupuesto_proveedor_adjudica as t2, t1_proveedor as t3 where t2.t1_proveedor_id = t3.t1_proveedor_id and t2.t2_item_pecc_id_marco = ".$id_item_pecc);
while($sel_cont = traer_fila_db($sele_contratos)){

if($_POST["contra_".$sel_cont[0]] != "") {
$tiene_seleccionado = "SI";
}
}
if($tiene_seleccionado == "NO"){
?><script>

    alert("Debe Seleccionar aunque sea un contrato");
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?					
exit;
}

/* ----------- valida que tenga por lo menos un contrato*/

$sele_suma_presu_adjudica = traer_fila_row(query_db("select sum(valor_usd)+ (sum(valor_cop)/".$sele_trm[0].") from $pi8 where t2_item_pecc_id = $id_item_pecc and permiso_o_adjudica = 2 and ano = ".$_POST["ano"]));


$inserta_procesos="insert into $pi8 (t1_campo_id,t2_item_pecc_id,adjunto,valor_usd,valor_cop, ano, permiso_o_adjudica, aleatorio) values (".$_POST["campo"].",'".$id_item_pecc."','','".$valor_usd."','".$valor_cop."',".$_POST["ano"].",2, 'marco')";
echo $inserta_procesos;
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

$sele_contratos = query_db("select t2.id_relacion, t3.razon_social, t2.apellido from t2_presupuesto_proveedor_adjudica as t2, t1_proveedor as t3 where t2.t1_proveedor_id = t3.t1_proveedor_id and t2.t2_item_pecc_id_marco = ".$id_item_pecc);
while($sel_cont = traer_fila_db($sele_contratos)){

if($_POST["contra_".$sel_cont[0]] != "") {
$insert_aplica_pro = query_db("insert into t2_presupuesto_aplica_contrato (t2_presupuesto_id, t2_proveedor_adjudica) values (".$id_ingreso.", ".$_POST["contra_".$sel_cont[0]].")");
}
}


$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["adjunt_presu"]["name"];
$campo_file_temp1 = $_FILES["adjunt_presu"]["tmp_name"];	


if($campo_file_nombre1 != ""){

$nombre_file1 = "presupuesto-adjudica"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_3");
$upda = query_db("update $pi8 set adjunto = '".$nombre_file1."' where t2_presupuesto_id = ".$id_ingreso);
}


if($id_ingreso>=1){

if($_POST["desde_comite"] == "SI"){?>
	<script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion-marco.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc?>&desde_comite=<?=$_POST["desde_comite"]?>', 'carga_edicion_valores_<?=$id_item_pecc?>');</script>
	<? }else{?>
<script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion-marco.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');</script>
<? } ?>

<script>

    

</script>
<?
}
else{
?>
<script>
    alert("ATENCIԎ:\nEl presupuesto NO se cre󠣯n 깩to")
</script>
<?


}

}


if($_POST["accion"]=="graba_presupuesto_nuevo_edita_adjudica_proveedor_marco")
{
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd"])))+0;
$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop"])))+0;
$valor_cop = number_format($valor_cop,0,'','');
$valor_usd = number_format($valor_usd,0,'','');
$vigencia_mes = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["vigencia_mes"])))+0;
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_marco"]));
$nombre = elimina_comillas_2($_POST["nom3"]);
$email = elimina_comillas_2($_POST["email3"]);
$dver = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["dver3"])));
$nit = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["nit3"])));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
$sele_trm = traer_fila_row(query_db("select valor from $g10 where id_trm=".$sel_item[15]));

$valor_adjudica = $valor_usd + ($valor_cop/$sele_trm[0]);

//seleccione si existe el proveedor
$explode = explode("----,",$_POST["proveedores_busca"]);
$id_proveedor_bus = $explode[1];
if($id_proveedor_bus == ""){
$id_proveedor_bus = 0;
}
$sele_si_exis = traer_fila_row(query_db("select * from $pi18 where t2_item_pecc_id_marco = $id_item_pecc and (t1_proveedor_id = $id_proveedor_bus or t1_proveedor_id = ".$_POST["sele_proveedor"].") and apellido = '".$_POST["complemento_num_contra"]."'"));

//fin si existe el proveedor
if($sele_si_exis[0]>0){
?><script>alert("El Proveedor ya esta Vinculado a esta Solicitud, cambie el Complemento");
    window.parent.document.getElementById("cargando_pecc").style.display = "none";</script><?
exit;
}else{//SI NO EXISTE


if($_POST["sele_proveedor"] == 99){// SI ES SIN PERMISO
if($_POST["proveedores_busca"] !=""){//SI ES DE LA BASE DE DATOS
$explode = explode("----,",$_POST["proveedores_busca"]);
$id_proveedor = $explode[1];
}else{//SI HAY QUE CREAR UNO NUEVO
$id_proveedor = crea_proveedor_en_dos_db($nit, $nombre, $email);

}				
}else{//SI ES CON PERMISO
$id_proveedor =  $_POST["sele_proveedor"];
}

$insert_relacion_prooveddor = query_db("insert into $pi18 (t2_presupuesto_id, t1_proveedor_id,t1_tipo_documento_id,vigencia_mes, apellido, t2_item_pecc_id_marco) values (0,$id_proveedor,".$_POST["tipo_documento"].",".$vigencia_mes.", '".$_POST["complemento_num_contra"]."', '".$id_item_pecc."')");

}//FIN SI NO EXISTE


?>

<script>

    window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion-marco.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');

</script>
<?
}


if($_POST["accion"]=="graba_presupuesto_nuevo_edita_adjudica")
{
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd"])))+0;
$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop"])))+0;
$valor_cop = number_format($valor_cop,0,'','');
$valor_usd = number_format($valor_usd,0,'','');
$vigencia_mes = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["vigencia_mes"])))+0;
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_marco"]));
$nombre = elimina_comillas_2($_POST["nom3"]);
$email = elimina_comillas_2($_POST["email3"]);
$dver = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["dver3"])));
$nit = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["nit3"])));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
$sele_trm = traer_fila_row(query_db("select valor from $g10 where id_trm=".$sel_item[15]));

$valor_adjudica = $valor_usd + ($valor_cop/$sele_trm[0]);

//seleccione si existe el proveedor
$explode = explode("----,",$_POST["proveedores_busca"]);
$id_proveedor_bus = $explode[1];
if($id_proveedor_bus == ""){
$id_proveedor_bus = 0;
}

/*
$sele_si_exis = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id = $id_item_pecc and (t1_proveedor_id = $id_proveedor_bus or t1_proveedor_id = ".$_POST["sele_proveedor"].")"));

//fin si existe el proveedor
if($sele_si_exis[0]>0){
$actualiza_presu = query_db("update $pi8 set valor_usd = $valor_usd+".$sele_si_exis[6].", valor_cop= $valor_cop+".$sele_si_exis[7]." where t2_presupuesto_id = ".$sele_si_exis[11]);
$id_ingreso=1;
}else{//SI NO EXISTE
*/


$inserta_procesos="insert into $pi8 (t1_campo_id,t2_item_pecc_id,adjunto,valor_usd,valor_cop, ano, permiso_o_adjudica) values (".$_POST["campo"].",'".$id_item_pecc."','','".$valor_usd."','".$valor_cop."',".$_POST["ano"].",2)";
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);
$id_ingreso = id_insert($sql_ex);

$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["adjunt_presu"]["name"];
$campo_file_temp1 = $_FILES["adjunt_presu"]["tmp_name"];	


if($campo_file_nombre1 != ""){

$nombre_file1 = "presupuesto-adjudica"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_3");
$upda = query_db("update $pi8 set adjunto = '".$nombre_file1."' where t2_presupuesto_id = ".$id_ingreso);
}

if($_POST["sele_proveedor"] == 99){// SI ES SIN PERMISO
if($_POST["proveedores_busca"] !=""){//SI ES DE LA BASE DE DATOS
$explode = explode("----,",$_POST["proveedores_busca"]);
$id_proveedor = $explode[1];
}else{//SI HAY QUE CREAR UNO NUEVO
$email = str_replace("&#64;", "@",$email);
$id_proveedor = crea_proveedor_en_dos_db($nit, $nombre, $email);
}				
}else{//SI ES CON PERMISO
$id_proveedor =  $_POST["sele_proveedor"];
}

$insert_relacion_prooveddor = query_db("insert into $pi18 (t2_presupuesto_id, t1_proveedor_id,t1_tipo_documento_id,vigencia_mes, apellido) values ($id_ingreso,$id_proveedor,".$_POST["tipo_documento"].",".$vigencia_mes.",'".$_POST["complemto_contrato"]."')");

//}//FIN SI NO EXISTE
if($id_ingreso>=1){



if($_POST["tipo_documento"]==4){




?><script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion-desierto.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');</script><?
}else{
	if($_POST["desde_comite"] == "SI"){?>
	<script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc?>&desde_comite=<?=$_POST["desde_comite"]?>', 'carga_edicion_valores_<?=$id_item_pecc?>');</script>
	<? }else{?>
<script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');</script>
<? } ?>

<script></script><?
}

if($_POST["desde_comite"] != "SI") valida_firmas_que_estan_creadas_permiso($id_item_pecc);


/*quita las firmas actualizando a que son por el sistema*/
if($sel_item[14]<>7 and $sel_item[14]<>16){
$update = query_db("update  t2_agl_secuencia_solicitud set  por_sistema = 1 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2");
}


}		else{
?>
<script>
    alert("ATENCIԎ:\nEl presupuesto NO se cre󠣯n 깩to")
</script>
<?


}

}


if($_POST["accion"]=="graba_presupuesto_nuevo")
{


$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd"])))+0;
$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop"])))+0;
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$destino_presu = elimina_comillas_2($_POST["destino_presu"]);
$cargo_cota_presu = elimina_comillas_2($_POST["cargo_cota_presu"]);
$id_item_ots_aplica = elimina_comillas(arreglo_recibe_variables($_POST["solicitud_aplica_ots"]));

/* ----------- valida que tenga por lo menos un contrato*/
if($_POST["aplica_contrato"] == 0 and $id_tipo_proceso_pecc == 2){
$tiene_seleccionado = "NO";
$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$_POST["id_item_pecc"]." and t1_tipo_documento_id = 2");
while($sel_cont = traer_fila_db($sele_contratos)){

if($_POST["contra_".$sel_cont[0]] != "") {
$tiene_seleccionado = "SI";
}
}
if($tiene_seleccionado == "NO"){
?><script>

    alert("Debe Seleccionar aunque sea un contrato");
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?					
exit;
}
}

/* ----------- valida que tenga por lo menos un contrato*/

//echo number_format(11211254784125417,2,'','');
$valor_cop = number_format($valor_cop,0,'','');
$valor_usd = number_format($valor_usd,0,'','');


if($id_tipo_proceso_pecc == 3){
$sele_trm = traer_fila_row(query_db("select valor from $g10 where id_trm=".$_POST["id_trm_aplica"]));
$selec_presupuesto_ano = traer_fila_row(query_db("select sum(t1.valor_usd),sum(t1.valor_cop) from $pi8 as t1, $pi12 as t2 where aleatorio = '".$aleatorio."' and permiso_o_adjudica = 1 and ano = ".$_POST["ano"]." and t1.t2_presupuesto_id = t2.t2_presupuesto_id AND t2.t7_contrato_id = ".$_POST["aplica_contrato"]." and t1.t1_campo_id = ".$_POST["campo"]." group by t2.t7_contrato_id, t1.ano, t1.t1_campo_id"));
$valor_solicitado =($selec_presupuesto_ano[1] / trm_presupuestal($_POST["ano"])) + $selec_presupuesto_ano[0];
$valor_solicitado = $valor_solicitado +$valor_usd +($valor_cop/trm_presupuestal($_POST["ano"]));
//echo $valor_solicitado;

$valor_disponible = calcula_valor_contrato_saldo($id_item_pecc,$_POST["aplica_contrato"],$_POST["ano"], $_POST["campo"]);

//echo $valor_disponible;
$valor_solicitado = number_format($valor_solicitado,9,'.','');
$valor_disponible = number_format($valor_disponible,9,'.','');

$valor_solicitado1 = explode(".",$valor_solicitado);
$decimal = trim(substr("00".substr($valor_solicitado1[1], 0,2),-2));
$valor_solicitado2 = $valor_solicitado1[0].".".$decimal."0000000";
$valor_solicitado = number_format($valor_solicitado2,9,'.','');
/*
echo $valor_disponible." - ".$valor_solicitado;

?><script>alert("El Presupuesto Supera al Disponible\n Presupuesto Disponible: Equivalente USD$<?= $valor_disponible ?>\n Presupuesto Solicitado: Equivalente USD$ <?= $valor_solicitado ?>\n ")
    window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
<?					exit;
*/	

/*aca es la creacion*/
if(  $valor_disponible < $valor_solicitado){

?><script>alert("El Presupuesto Supera al Disponible\n Presupuesto Disponible: Equivalente USD$ <?= number_format($valor_disponible, 2) ?>\n Presupuesto Solicitado: Equivalente USD$ <?= number_format($valor_solicitado, 2) ?>\n ")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}

}

$inserta_procesos="insert into $pi8 (t1_campo_id,aleatorio,adjunto,valor_usd,valor_cop, ano, permiso_o_adjudica,destino_final,id_item_ots_aplica,cargo_contable) values (".$_POST["campo"].",'".$aleatorio."','','".$valor_usd."','".$valor_cop."',".$_POST["ano"].",1,'".$destino_presu."','".$id_item_ots_aplica."','".$cargo_cota_presu."')";
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);

$id_ingreso = id_insert($sql_ex);




if($_POST["aplica_contrato"] == 0){


$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$_POST["id_item_pecc"]." and t1_tipo_documento_id = 2");
while($sel_cont = traer_fila_db($sele_contratos)){

if($_POST["contra_".$sel_cont[0]] != "") {
$insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (".$id_ingreso.",".$sel_cont[0].")");
}
}

}else{
$insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (".$id_ingreso.",".$_POST["aplica_contrato"].")");
}



if($id_ingreso>=1){

$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["adj_presupuesto"]["name"];
$campo_file_temp1 = $_FILES["adj_presupuesto"]["tmp_name"];	


if($campo_file_nombre1 != ""){
$nombre_file1 = "presupuesto-permiso"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_3");
$upda = query_db("update $pi8 set adjunto = '".$nombre_file1."' where t2_presupuesto_id = ".$id_ingreso);
}


$valor_contrato_aplica = 0;

if($_POST["id_tipo_proceso_pecc"] == 2){
$valor_contrato_aplica = "";
}
?>

<script>

    window.parent.ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=3&aleatorio=<?= $aleatorio ?>&id_pecc=<?= $_POST["id_pecc"] ?>&id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_tipo_contratacion=<?= $_POST["id_tipo_contratacion"] ?>', 'carga_presupuesto');
    window.parent.ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "carga_contratos_aplica")


    window.parent.document.principal.campo.value = ""
    window.parent.document.principal.valor_usd.value = ""
    window.parent.document.principal.valor_cop.value = "";
    window.parent.document.principal.aplica_contrato.value = "<?= $valor_contrato_aplica ?>";

    window.parent.document.getElementById("resetea_presus").innerHTML = ''
    window.parent.document.getElementById("resetea_presus").innerHTML = '<input name="adj_presupuesto" type="file" size="5" />'

</script>
<?

if($_POST["id_tipo_proceso_pecc"] == 3){
$sel_contra = traer_fila_row(query_db("select consecutivo, creacion_sistema, apellido, id from t7_contratos_contrato where id = ".$_POST["aplica_contrato"]));

$numero_contrato1 = "C";			
$separa_fecha_crea = explode("-",$sel_contra[1]);
$ano_contra = $separa_fecha_crea[0];					
$numero_contrato2 = substr($ano_contra,2,2);
$numero_contrato3 = $sel_contra[0];
$numero_contrato4 = $sel_contra[2];

$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra[3]);
echo $num_impri;

?>
<script>

//         window.parent.document.aplica_contra_div.innerHTML="< ?=$num_impri?><input type='text' name='aplica_contrato' id='aplica_contrato' value ='< ?=$_POST["aplica_contrato"]?>'";

    window.parent.document.getElementById("aplica_contra_div").innerHTML = "Contrato de OT: <?= $num_impri ?><input type='hidden' name='aplica_contrato' id='aplica_contrato' value ='<?= $_POST["aplica_contrato"] ?>' />";

</script>
<?
}
}
else{
?>
<script>
    alert("ATENCIԎ:\nEl presupuesto NO se cre󠣯n 깩to")
</script>
<?


}

}

if($_POST["accion"]=="graba_presupuesto_nuevo2")
{


$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd2"])))+0;
$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop2"])))+0;
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$destino_presu = elimina_comillas_2($_POST["destino_presu2"]);
$cargo_cota_presu = elimina_comillas_2($_POST["cargo_cota_presu2"]);
$id_item_ots_aplica = elimina_comillas(arreglo_recibe_variables($_POST["solicitud_aplica_ots2"]));



$inserta_procesos="insert into $pi8 (t1_campo_id,aleatorio,adjunto,valor_usd,valor_cop, ano, permiso_o_adjudica,destino_final,id_item_ots_aplica,cargo_contable,al_valor_inicial_para_marco) values (".$_POST["campo2"].",'".$aleatorio."','','".$valor_usd."','".$valor_cop."',".$_POST["ano2"].",1,0,0,0,1)";
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);


$id_ingreso = id_insert($sql_ex);






if($id_ingreso>=1){

$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1="";

$campo_file_nombre1 = $_FILES["adj_presupuesto2"]["name"];
$campo_file_temp1 = $_FILES["adj_presupuesto2"]["tmp_name"];	

echo $campo_file_nombre1;
if($campo_file_nombre1 != ""){
$nombre_file1 = "presupuesto-permiso"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_3");

$upda = query_db("update $pi8 set adjunto = '".$nombre_file1."' where t2_presupuesto_id = ".$id_ingreso);



}


$valor_contrato_aplica = 0;


?>

<script>

    window.parent.ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=carga_valor_actual_contra&aleatorio=<?= $aleatorio ?>&id_pecc=<?= $_POST["id_pecc"] ?>&id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_tipo_contratacion=<?= $_POST["id_tipo_contratacion"] ?>', 'carga_presupuesto2');
    window.parent.ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "carga_contratos_aplica")


    window.parent.document.principal.campo2.value = ""
    window.parent.document.principal.valor_usd2.value = ""
    window.parent.document.principal.valor_cop2.value = "";
    window.parent.document.principal.aplica_contrato2.value = "<?= $valor_contrato_aplica ?>";

    window.parent.document.getElementById("resetea_presus2").innerHTML = ''
    window.parent.document.getElementById("resetea_presus2").innerHTML = '<input name="adj_presupuesto2" type="file" size="5" />'


</script>
<?


}
else{
?>
<script>
    alert("ATENCIԎ:\nEl presupuesto NO se cre󠣯n 깩to")
</script>
<?


}

}	  


if($_POST["accion"]=="graba_presupuesto_nuevo_edita_contrato_ini")
{
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd2"])))+0;

$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop2"])))+0;
$valor_cop = number_format($valor_cop,0,'','');
$valor_usd = number_format($valor_usd,0,'','');

$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_marco"]));

$id_item_ots_aplica = elimina_comillas(arreglo_recibe_variables($_POST["solicitud_aplica_ots"]));







$inserta_procesos="insert into $pi8 (t1_campo_id,t2_item_pecc_id,adjunto,valor_usd,valor_cop, ano, permiso_o_adjudica,destino_final, id_item_ots_aplica, cargo_contable, al_valor_inicial_para_marco) values (".$_POST["campo2"].",'".$id_item_pecc."','','".$valor_usd."','".$valor_cop."',".$_POST["ano2"].",1,'".$destino_presu."','".$id_item_ots_aplica."', '".$cargo_cota_presu."',1)";
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);

$id_ingreso = id_insert($sql_ex);

$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["adjunt_presu2"]["name"];
$campo_file_temp1 = $_FILES["adjunt_presu2"]["tmp_name"];	


if($campo_file_nombre1 != ""){
$nombre_file1 = "presupuesto-permiso"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_3");
$upda = query_db("update $pi8 set adjunto = '".$nombre_file1."' where t2_presupuesto_id = ".$id_ingreso);
}

if($_POST["aplica_contrato2"] == 0){


$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$_POST["id_item_pecc_marco"]." and t1_tipo_documento_id = 2");
while($sel_cont = traer_fila_db($sele_contratos)){

if($_POST["contra_".$sel_cont[0]] != "") {
$insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (".$id_ingreso.",".$sel_cont[0].")");
}
}

}else{
$insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (".$id_ingreso.",".$_POST["aplica_contrato2"].")");
}



if($id_ingreso>=1){

if($_POST["desde_comite"] != "SI") valida_firmas_que_estan_creadas_permiso($id_item_pecc);

if($valor_contrato_aplica == ""){
$valor_contrato_aplica = 0;
}




/* -------------------- LOG ---------------------------------*/
$contratos_aplica="";



$contratos_aplica = "0".$contratos_aplica;


$id_log_presupuesto = log_de_procesos_sgpa(2, 5, 8, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores


if($contratos_aplica <> "0"){
log_agrega_detalle ($id_log_presupuesto, "Contratos Marco Relacionados",$contratos_aplica , "t7_contratos_contrato",1);
}
$sel_campo = traer_fila_row(query_db("select nombre from t1_campo where t1_campo_id = ".$_POST["campo"]));
log_agrega_detalle ($id_log_presupuesto, "Ano",$_POST["ano"] , "",2);
log_agrega_detalle ($id_log_presupuesto, "Area / Proyecto",$sel_campo[0] , "",3);
log_agrega_detalle ($id_log_presupuesto, "Valor USD$",$valor_usd , "",4);
log_agrega_detalle ($id_log_presupuesto, "Valor COP$",$valor_cop , "",5);
log_agrega_detalle ($id_log_presupuesto, "Adjunto",$nombre_file1 , "",6);






/* -------------------- LOG ---------------------------------*/

if($_POST["desde_comite"] == "SI"){?>
	<script>window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc?>&desde_comite=<?=$_POST["desde_comite"]?>', 'carga_edicion_valores_<?=$id_item_pecc?>');</script>
	<? }else{?>
<script>window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc ?>', 'contenidos');</script>
<? } ?>




<script>

  
    //window.parent.ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=3&id_pecc=< ?=$_POST["id_pecc"]?>&id_tipo_proceso_pecc=< ?=$_POST["id_tipo_proceso_pecc"]?>&id_item_pecc=< ?=$id_item_pecc?>','carga_presupuesto');

    //window.parent.ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0","carga_contratos_aplica")

    window.parent.document.principal.campo.value = ""
    window.parent.document.principal.valor_usd.value = ""
    window.parent.document.principal.valor_cop.value = "";
    window.parent.document.principal.aplica_contrato.value = "<?= $valor_contrato_aplica ?>";

</script>
<?
}
else{
?>
<script>
    alert("ATENCIԎ:\nEl presupuesto NO se cre󠣯n 깩to")
</script>
<?


}

}


if($_POST["accion"]=="graba_presupuesto_nuevo_edita")
{
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd"])))+0;
$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop"])))+0;
$valor_cop = number_format($valor_cop,0,'','');
$valor_usd = number_format($valor_usd,0,'','');

$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_marco"]));
echo $id_item_pecc."-----";
$id_item_ots_aplica = elimina_comillas(arreglo_recibe_variables($_POST["solicitud_aplica_ots"]));



$destino_presu = elimina_comillas_2($_POST["destino_presu"]);
$cargo_cota_presu = elimina_comillas_2($_POST["cargo_cota_presu"]);

$sel_item = traer_fila_row(query_db("select * from t2_item_pecc where id_item = ".$id_item_pecc));
/* ------------- VALIDACIONES DE SERVICIOS MENORES ------------------- */
if($sel_item[6]==16){
			$sel_presu = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id =".$id_item_pecc." and permiso_o_adjudica = 1"));
				$valor_solicitud = ($sel_presu[0]+$valor_usd) + (($sel_presu[1]+$valor_cop)/trm_actual());
				
				if($valor_solicitud <=0 or $valor_solicitud >$_SESSION["valor_maximo_ser_menor"]){
				?><script>alert(" > Debe ingresar el valor del servicio menor entre USD$ 1 y <?=number_format($_SESSION["valor_maximo_ser_menor"],0);?>, usted esta solicitando USD$ <?=number_format($valor_solicitud, 2)?>"); window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
				exit;
				}
				
				$algun_proveedor_arriba_25000="NO";
							$sel_proveedores_lista = query_db("select * from t2_relacion_proveedor where id_item =".$id_item_pecc." ".$comple_sql_validacion_2500);
							while($sel_p_list = traer_fila_db($sel_proveedores_lista)){
								$valores_sm = 0;					
								$valores_sm = explode("*",disponible_serv_menor_ano_atras($sel_p_list[2], $id_item_pecc));
								//[0]=total_comprometido --- [1]=comprometido_sap --- [2]=comprometido_no_sap --- [3]=valor_solicitud_Actual --- [4] Disponible
								echo $valores_sm[4]." - ".($valor_usd + ($valor_usd + number_format($valor_cop/trm_actual())))." TRM".trm_actual()."<br>";
								if($valores_sm[4] - ($valor_usd + number_format($valor_cop/trm_actual())) < 0){
									$algun_proveedor_arriba_25000="SI";
									}					
								}
								if($algun_proveedor_arriba_25000 == "SI"){
									?><script>alert(" > No se puede agregar este valor por que hay proveedores que no cuentan con este disponible, por favor verificar disponibilidad en el link 'Proveedores - Reporte Servicios Menores'"); window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
									exit;
									}
}
/* ------------- VALIDACIONES DE SERVICIOS MENORES ------------------- */

/* ----------- valida que tenga por lo menos un contrato*/
if($_POST["aplica_contrato"] == 0 and $id_tipo_proceso_pecc == 2){
$tiene_seleccionado = "NO";

$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$_POST["id_item_pecc_marco"]." and t1_tipo_documento_id = 2");
while($sel_cont = traer_fila_db($sele_contratos)){

if($_POST["contra_".$sel_cont[0]] != "") {
$tiene_seleccionado = "SI";
}
}
if($tiene_seleccionado == "NO"){
?><script>

    alert("Debe Seleccionar aunque sea un contrato");
    window.parent.document.getElementById("cargando_pecc").style.display = "none"
</script><?					
exit;
}
}

/* ----------- valida que tenga por lo menos un contrato*/

if($sel_item[6] == 12){//si es reclasificacin
$sel_tipo_reclasificacion = traer_fila_row(query_db("select t1_tipo_documento_id, id_item from t7_contratos_contrato where id=".$sel_item[21]));
}

if($id_tipo_proceso_pecc == 3 or ($sel_item[6]==12 and $sel_tipo_reclasificacion[0] == 2)){
$sele_trm = traer_fila_row(query_db("select valor from $g10 where id_trm=".$_POST["id_trm_aplica"]));

$selec_presupuesto_ano = traer_fila_row(query_db("select sum(t1.valor_usd),sum(t1.valor_cop) from $pi8 as t1, $pi12 as t2 where t2_item_pecc_id = '".$id_item_pecc."' and ano = ".$_POST["ano"]." and permiso_o_adjudica = 1 and t1.t2_presupuesto_id = t2.t2_presupuesto_id AND t2.t7_contrato_id = ".$_POST["aplica_contrato"]." and t1.t1_campo_id = ".$_POST["campo"]." group by t2.t7_contrato_id, t1.ano"));
$valor_solicitado =($selec_presupuesto_ano[1] / trm_presupuestal($_POST["ano"]))+ $selec_presupuesto_ano[0];
$valor_solicitado = $valor_solicitado +$valor_usd +($valor_cop/trm_presupuestal($_POST["ano"]));

//$valor_disponible = calcula_valor_contrato_saldo($id_item_pecc_marco,$_POST["aplica_contrato"],$_POST["ano"]);
$valor_disponible = calcula_valor_contrato_saldo($id_item_pecc_marco,$_POST["aplica_contrato"],$_POST["ano"], $_POST["campo"]);



//echo $valor_disponible;
$valor_solicitado = number_format($valor_solicitado,9,'.','');
$valor_disponible = number_format($valor_disponible,9,'.','');

$valor_solicitado1 = explode(".",$valor_solicitado);
$decimal = trim(substr("00".substr($valor_solicitado1[1], 0,2),-2));
$valor_solicitado2 = $valor_solicitado1[0].".".$decimal."0000000";
$valor_solicitado = number_format($valor_solicitado2,9,'.','');



if( $valor_disponible < $valor_solicitado){

?><script>alert("El presupuesto Supera al Disponible\n Presupuesto Disponible: Equivalente USD$<?= number_format($valor_disponible, 0) ?>\n Presupuesto Solicitado: Equivalente USD$ <?= number_format($valor_solicitado, 0) ?>")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>
<?
exit;
}

}

$inserta_procesos="insert into $pi8 (t1_campo_id,t2_item_pecc_id,adjunto,valor_usd,valor_cop, ano, permiso_o_adjudica,destino_final, id_item_ots_aplica, cargo_contable) values (".$_POST["campo"].",'".$id_item_pecc."','','".$valor_usd."','".$valor_cop."',".$_POST["ano"].",1,'".$destino_presu."','".$id_item_ots_aplica."', '".$cargo_cota_presu."')";
$sql_ex=query_db($inserta_procesos.$trae_id_insrte);

$id_ingreso = id_insert($sql_ex);

$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["adjunt_presu"]["name"];
$campo_file_temp1 = $_FILES["adjunt_presu"]["tmp_name"];	


if($campo_file_nombre1 != ""){
$nombre_file1 = "presupuesto-permiso"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_3");
$upda = query_db("update $pi8 set adjunto = '".$nombre_file1."' where t2_presupuesto_id = ".$id_ingreso);
}

if($_POST["aplica_contrato"] == 0){


$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$_POST["id_item_pecc_marco"]." and t1_tipo_documento_id = 2");
while($sel_cont = traer_fila_db($sele_contratos)){

if($_POST["contra_".$sel_cont[0]] != "") {
$insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (".$id_ingreso.",".$sel_cont[0].")");
}
}

}else{
$insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (".$id_ingreso.",".$_POST["aplica_contrato"].")");
}



if($id_ingreso>=1){

if($_POST["desde_comite"] != "SI") valida_firmas_que_estan_creadas_permiso($id_item_pecc);


$valor_contrato_aplica = 0;

if($_POST["id_tipo_proceso_pecc"] == 2){
$valor_contrato_aplica = "";
}


/* -------------------- LOG ---------------------------------*/
$contratos_aplica="";

if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
$sel_contr = query_db("select t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$id_ingreso);
while($sel_apl = traer_fila_db($sel_contr)){
$contratos_aplica.= ",".$sel_apl[0];
}
}


$contratos_aplica = "0".$contratos_aplica;


$id_log_presupuesto = log_de_procesos_sgpa(2, 5, 8, $id_item_pecc, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores


if($contratos_aplica <> "0"){
log_agrega_detalle ($id_log_presupuesto, "Contratos Marco Relacionados",$contratos_aplica , "t7_contratos_contrato",1);
}
$sel_campo = traer_fila_row(query_db("select nombre from t1_campo where t1_campo_id = ".$_POST["campo"]));
log_agrega_detalle ($id_log_presupuesto, "Ano",$_POST["ano"] , "",2);
log_agrega_detalle ($id_log_presupuesto, "Area / Proyecto",$sel_campo[0] , "",3);
log_agrega_detalle ($id_log_presupuesto, "Valor USD$",$valor_usd , "",4);
log_agrega_detalle ($id_log_presupuesto, "Valor COP$",$valor_cop , "",5);
log_agrega_detalle ($id_log_presupuesto, "Adjunto",$nombre_file1 , "",6);

if($_POST["id_tipo_contratacion"] <> 1){
log_agrega_detalle ($id_log_presupuesto, "Destino Fisico", $destino_presu, "",5);
log_agrega_detalle ($id_log_presupuesto, "Cargo Contable", $cargo_cota_presu, "",5);
}

if($id_tipo_proceso_pecc == 3){
log_agrega_detalle ($id_log_presupuesto, "Solicitud a la Cual Aplica la OT", $_POST["solicitud_aplica_ots"], "t2_item_pecc",5);
}




/* -------------------- LOG ---------------------------------*/

if($_POST["desde_comite"] == "SI"){?>
	<script>window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc?>&desde_comite=<?=$_POST["desde_comite"]?>', 'carga_edicion_valores_<?=$id_item_pecc?>');</script>
	<? }else{?>
<script>window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc ?>', 'contenidos');</script>
<? } ?>


<script>
    //window.parent.ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=3&id_pecc=< ?=$_POST["id_pecc"]?>&id_tipo_proceso_pecc=< ?=$_POST["id_tipo_proceso_pecc"]?>&id_item_pecc=< ?=$id_item_pecc?>','carga_presupuesto');

    //window.parent.ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0","carga_contratos_aplica")

    window.parent.document.principal.campo.value = ""
    window.parent.document.principal.valor_usd.value = ""
    window.parent.document.principal.valor_cop.value = "";
    window.parent.document.principal.aplica_contrato.value = "<?= $valor_contrato_aplica ?>";

</script>
<?
}
else{
?>
<script>
    alert("ATENCIԎ:\nEl presupuesto NO se cre󠣯n 깩to")
</script>
<?


}

}


if($_POST["accion"]=="elimina_presupuesto_adjudica_marco"){
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_presupuesto_elimina = elimina_comillas(arreglo_recibe_variables($_POST["id_presupuesto_elimina"]))+0;;
echo "delete from $pi8 where t2_presupuesto_id=".$id_presupuesto_elimina;
$elimina_presupuesto = query_db("delete from $pi8 where t2_presupuesto_id=".$id_presupuesto_elimina);
$elimina_presupuesto = query_db("delete from $pi12 where t2_presupuesto_id=".$id_presupuesto_elimina);
$elimina_presupuesto = query_db("delete from $pi18 where t2_presupuesto_id=".$id_presupuesto_elimina);

if($_POST["desde_comite"] == "SI"){?>
	<script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion-marco.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc?>&desde_comite=<?=$_POST["desde_comite"]?>', 'carga_edicion_valores_<?=$id_item_pecc?>');</script>
	<? }else{?>
<script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion-marco.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');</script>
<? } ?>

<script>
    


</script>
<?
}


if($_POST["accion"]=="elimina_presupuesto_adjudica_proveedor_marco"){
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_presupuesto_elimina = elimina_comillas(arreglo_recibe_variables($_POST["id_presupuesto_elimina"]))+0;;

$elimina_presupuesto = query_db("delete from $pi18 where id_relacion=".$id_presupuesto_elimina);

?>

<script>
    window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion-marco.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');


</script>
<?
}
if($_POST["accion"]=="elimina_presupuesto_adjudica"){
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
$id_presupuesto_elimina = elimina_comillas(arreglo_recibe_variables($_POST["id_presupuesto_elimina"]))+0;;
echo "delete from $pi8 where t2_presupuesto_id=".$id_presupuesto_elimina;
$elimina_presupuesto = query_db("delete from $pi8 where t2_presupuesto_id=".$id_presupuesto_elimina);
$elimina_presupuesto = query_db("delete from $pi12 where t2_presupuesto_id=".$id_presupuesto_elimina);
$elimina_presupuesto = query_db("delete from $pi18 where t2_presupuesto_id=".$id_presupuesto_elimina);

$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
if($sel_item[14]<>7 and $sel_item[14]<>16){
$update = query_db("update  t2_agl_secuencia_solicitud set  por_sistema = 1 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2");
}

if($_POST["desde_comite"] == "SI"){?>
	<script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc?>&desde_comite=<?=$_POST["desde_comite"]?>', 'carga_edicion_valores_<?=$id_item_pecc?>');</script>
	<? }else{?>
<script>window.parent.ajax_carga('../aplicaciones/pecc/adjudicacion.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');</script>
<? } ?>
<script>
    


</script>
<?
}
if($_POST["accion"]=="elimina_presupuesto"){
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc_real = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_real"]));
$id_presupuesto_elimina = elimina_comillas(arreglo_recibe_variables($_POST["id_presupuesto_elimina"]))+0;;
$selecciona_para_eliminar_archivo = traer_fila_row(query_db("select adjunto from $pi8 where t2_presupuesto_id=".$id_presupuesto_elimina));
/* -------------------- LOG ---------------------------------*/
$sel_presu = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_presupuesto_id = ".$id_presupuesto_elimina." and permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));


$solicitud_aplica = $sel_presu[7];
$contratos_aplica="";

if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
$sel_contr = query_db("select t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
while($sel_apl = traer_fila_db($sel_contr)){
$contratos_aplica.= ",".$sel_apl[0];
}
}


$contratos_aplica = "0".$contratos_aplica;


$id_log_presupuesto = log_de_procesos_sgpa(2, 5, 10, $id_item_pecc_real, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores


if($contratos_aplica <> "0"){
log_agrega_detalle ($id_log_presupuesto, "Contratos Marco Relacionados",$contratos_aplica , "t7_contratos_contrato",1);
}

log_agrega_detalle ($id_log_presupuesto, "Ano",$sel_presu[1] , "",2);
log_agrega_detalle ($id_log_presupuesto, "Area / Proyecto",$sel_presu[2] , "",3);
log_agrega_detalle ($id_log_presupuesto, "Valor USD$",$sel_presu[4] , "",4);
log_agrega_detalle ($id_log_presupuesto, "Valor COP$",$sel_presu[5] , "",5);
log_agrega_detalle ($id_log_presupuesto, "Adjunto",$sel_presu[3] , "",6);

if($_POST["id_tipo_contratacion"] <> 1){
log_agrega_detalle ($id_log_presupuesto, "Destino Fisico", $sel_presu[6], "",5);
log_agrega_detalle ($id_log_presupuesto, "Cargo Contable", $sel_presu[8], "",5);
}

if($id_tipo_proceso_pecc == 3){
log_agrega_detalle ($id_log_presupuesto, "Solicitud a la Cual Aplica la OT", $solicitud_aplica, "t2_item_pecc",5);
}

/* -------------------- LOG ---------------------------------*/
$elimina_presupuesto = query_db("delete from $pi8 where t2_presupuesto_id=".$id_presupuesto_elimina);
$elimina_presupuesto = query_db("delete from $pi12 where t2_presupuesto_id=".$id_presupuesto_elimina);
$elim = unlink("../../attfiles/pecc/".$selecciona_para_eliminar_archivo[0]);

if($_POST["desde_comite"] != "SI") valida_firmas_que_estan_creadas_permiso($id_item_pecc_real);	



if($_POST["desde_comite"] == "SI"){?>
	<script>window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc?>&desde_comite=<?=$_POST["desde_comite"]?>', 'carga_edicion_valores_<?=$id_item_pecc_real?>');</script>
	<? }else{?>
<script>    window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal.php?id_tipo_proceso_pecc=<?= $_POST["id_tipo_proceso_pecc"] ?>&id_item_pecc=<?= $id_item_pecc_real ?>', 'contenidos');</script>
<? } ?>

<script>




</script>
<?
}

if($_POST["accion"]=="devolucion_presupuesto")
{

$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd"])))+0;
$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop"])))+0;		
$valor_cop = number_format($valor_cop,0,'','');
$valor_usd = number_format($valor_usd,0,'','');

$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));

$sele_presu_actual = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop), trm from v_peec_valor_ot_real where id_item = ".$id_item_pecc." and t1_campo_id = ".$_POST["campo"]." and ano = ".$_POST["ano"]." and t7_contrato_id = ".$_POST["aplica_contrato"]."  group by trm"));

$valor_actual_item = $sele_presu_actual[0]+($sele_presu_actual[1]/$sele_presu_actual[2]);
$valor_a_devolver = $valor_usd + ($valor_cop / $sele_presu_actual[2]);

if($valor_actual_item < $valor_a_devolver){//	se quierre devolver mas de lo disponible
?><script>alert("El valor que intenta devolver supera al actual")</script><?
}else{



$insert = query_db("insert into t2_devolucion (id_item, id_campo, ano, valor_usd, valor_cop, trm, id_contrato) values ($id_item_pecc,".$_POST["campo"].", ".$_POST["ano"].", ".$valor_usd .", ".$valor_cop .", ".$sele_presu_actual[2].",".$_POST["aplica_contrato"].")");
}

?>

<script>
    window.parent.ajax_carga('../aplicaciones/pecc/asignacion-presupuestal-devolucion.php?id_item_pecc=<?= $id_item_pecc ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>', 'contenidos');

</script>
<?


}	  



if($_POST["accion"]=="graba_presupuesto_edita")
{
$id_presupuesto = elimina_comillas(arreglo_recibe_variables($_POST["id_presupuesto"]));
$aleatorio = elimina_comillas(arreglo_recibe_variables($_POST["aleatorio"]));
$valor_usd = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_usd_edita"])))+0;
$valor_cop = elimina_comillas(arreglo_recibe_variables(arregla_numero_db1($_POST["valor_cop_edita"])))+0;

$valor_cop = number_format($valor_cop,0,'','');
$valor_usd = number_format($valor_usd,0,'','');
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));



$id_item_pecc_real = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_real"]));

echo $id_item_pecc_marco;
echo $id_item_pecc;

if ($id_item_pecc_real > 0){
$comple_sql_presu = " t2_item_pecc_id = '".$id_item_pecc_real."'";
$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc_marco"]));
}else{
$comple_sql_presu = " aleatorio = '".$aleatorio."'";
$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
}
if($id_tipo_proceso_pecc == 3){
$sele_trm = traer_fila_row(query_db("select valor from $g10 where id_trm=".$_POST["id_trm_aplica"]));


$selec_presupuesto_ano = traer_fila_row(query_db("select sum(t1.valor_usd),sum(t1.valor_cop) from $pi8 as t1, $pi12 as t2 where $comple_sql_presu and ano = ".$_POST["ano_edita"]." and  permiso_o_adjudica = 1 and t1.t2_presupuesto_id = t2.t2_presupuesto_id and t1.t2_presupuesto_id <> ".$id_presupuesto." and t2.t7_contrato_id = ".$_POST["aplica_contrato_edita"]." group by  t1.ano"));

$valor_solicitado =($selec_presupuesto_ano[1] / $sele_trm[0])+ $selec_presupuesto_ano[0];
$valor_solicitado = $valor_solicitado +$valor_usd +($valor_cop/$sele_trm[0]);
$valor_disponible = calcula_valor_contrato_saldo($id_item_pecc,$_POST["aplica_contrato"],$_POST["ano"], $_POST["campo"]);

//echo $valor_disponible;
$valor_solicitado = number_format($valor_solicitado,9,'.','');
$valor_disponible = number_format($valor_disponible,9,'.','');

$valor_solicitado1 = explode(".",$valor_solicitado);
$decimal = trim(substr("00".substr($valor_solicitado1[1], 0,2),-2));
$valor_solicitado2 = $valor_solicitado1[0].".".$decimal."0000000";
$valor_solicitado = number_format($valor_solicitado2,9,'.','');

if( $valor_disponible < $valor_solicitado){

?><script>alert("El presupuesto Supera al Disponible\n Presupuesto Disponible: Equivalente USD$<?= number_format($valor_disponible, 0) ?>\n Presupuesto Solicitado: Equivalente USD$ <?= number_format($valor_solicitado, 0) ?>")</script>
<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script><?
exit;
}

}

$inserta_procesos="update $pi8  set t1_campo_id=".$_POST["campo_edita"].",aleatorio='".$aleatorio."',valor_usd='".$valor_usd."',valor_cop='".$valor_cop."', ano=".$_POST["ano_edita"]." where t2_presupuesto_id=".$id_presupuesto;	 
$sql_ex=query_db($inserta_procesos);



$id_ingreso = $id_presupuesto;
$delete_contratos = query_db("delete from $pi12 where t2_presupuesto_id = ".$id_ingreso);

if($_POST["aplica_contrato_edita"] == 0){


$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$_POST["id_item_pecc"]." and t1_tipo_documento_id = 2");
while($sel_cont = traer_fila_db($sele_contratos)){

if($_POST["contra_".$sel_cont[0]."_edita"] != "") {
$insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (".$id_ingreso.",".$sel_cont[0].")");
}
}

}else{
$insert = query_db("insert into $pi12 (t2_presupuesto_id,t7_contrato_id) values (".$id_ingreso.",".$_POST["aplica_contrato_edita"].")");
}



if($id_ingreso>=1){

$nombre_file1="";
$nombre_file2="";
$campo_file_nombre1 = $_FILES["adj_presupuesto_edita"]["name"];
$campo_file_temp1 = $_FILES["adj_presupuesto_edita"]["tmp_name"];	


if($campo_file_nombre1 != ""){
$selecciona_para_eliminar_archivo = traer_fila_row(query_db("select adjunto from $pi8 where t2_presupuesto_id=".$id_presupuesto));
$elim = unlink("../../attfiles/pecc/".$selecciona_para_eliminar_archivo[0]);				
$nombre_file1 = "presupuesto-permiso"."_".$id_ingreso."_".$campo_file_nombre1;
//$copiar = copy($campo_file_temp1,'../../attfiles/pecc/'.$nombre_file1);
$copiar = carga_archivo($campo_file_temp1,'pecc/'.$id_ingreso."_3");
$upda = query_db("update $pi8 set adjunto = '".$nombre_file1."' where t2_presupuesto_id = ".$id_ingreso);
}

$valor_contrato_aplica = 0;

if($_POST["id_tipo_proceso_pecc"] == 2){
$valor_contrato_aplica = "";
}
valida_firmas_que_estan_creadas_permiso($id_item_pecc_real);



/* -------------------- LOG ---------------------------------*/
$contratos_aplica="";

if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
$sel_contr = query_db("select t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$id_ingreso);
while($sel_apl = traer_fila_db($sel_contr)){
$contratos_aplica.= ",".$sel_apl[0];
}
}


$contratos_aplica = "0".$contratos_aplica;


$id_log_presupuesto = log_de_procesos_sgpa(2, 5, 9, $id_item_pecc_real, $_POST["estado_actual_del_proceso"], $_POST["estado_actual_del_proceso"]);//agrega valores


if($contratos_aplica <> "0"){
log_agrega_detalle ($id_log_presupuesto, "Contratos Marco Relacionados",$contratos_aplica , "t7_contratos_contrato",1);
}
$sel_campo = traer_fila_row(query_db("select nombre from t1_campo where t1_campo_id = ".$_POST["campo_edita"]));
log_agrega_detalle ($id_log_presupuesto, "Ano",$_POST["ano_edita"] , "",2);
log_agrega_detalle ($id_log_presupuesto, "Area / Proyecto",$sel_campo[0] , "",3);
log_agrega_detalle ($id_log_presupuesto, "Valor USD$",$valor_usd , "",4);
log_agrega_detalle ($id_log_presupuesto, "Valor COP$",$valor_cop , "",5);
log_agrega_detalle ($id_log_presupuesto, "Adjunto",$nombre_file1 , "",6);





/* -------------------- LOG ---------------------------------*/
?>

<script>

    window.parent.ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=3&aleatorio=<?= $aleatorio ?>&id_pecc=<?= $_POST["id_pecc"] ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&id_item_pecc=<?= $id_item_pecc ?>', 'carga_presupuesto');
    window.parent.ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "carga_edita_presupuesto")


</script>
<?
}
else{
?>
<script>
    alert("ATENCIԎ:\nEl presupuesto NO se Edito con 깩to")
</script>

<?


}

}	        


if($accion == "crea_proveedor_adentro")
{

$verifica_email = comprobar_email($email_contacto);

if($verifica_email=="0"){
?>
<script>
    alert("Verifique el e-mail")
    window.parent.document.getElementById("cargando").style.display = "none"

</script>
<?
exit();
}

$bsca_si_exi=traer_fila_row(query_db("select * from $g6 where nit='$ap'"));
if($bsca_si_exi[0]>=1){
?>
<script>
    alert("El proveedor ya existe")
    window.parent.document.getElementById("cargando").style.display = "none"

</script>
<?
exit();
}		

$cifra_c=md5("321654");



$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");

for($i=0;$i<=3;$i++){
$generador = rand(0,34);
$fuente2.= $alfabeto[$generador];
}

if($ap=="")
$ap = $fuente2;


$inserta_us = "insert into t1_proveedor (nit, digito_verificacion , razon_social , estado)	values ('$ap', '', '$bp',1)";
$sql_ex=query_db($inserta_us.$trae_id_insrte);
$id_ingreso_pro = id_insert($sql_ex);

if($id_ingreso_pro>=1){//si se creo el proveedor
$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
mysql_select_db($dbbase_mys, $link);

$cambia_cali="insert into  pv_proveedores (pv_id,cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
$id_ingreso_pro,$ciuadad, '$ap', '$bp', '$cp','$email_contacto', '$ep', 1, '$g' )";
$sql_ex = mysql_query($cambia_cali);

$inserta_email_sgpa=query_db("insert into t1_proveedor_email (t1_proveedor_id, nombre_responsable, email, tipo, estado) values ($id_ingreso_pro, 
'PRINCIPAL','$email_contacto',1,1)");

$inserta_us = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
values ('$bp', '$email_contacto', '$cifra_c', '$email_contacto', '$ep',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
$sql_ex_p=query_db($inserta_us.$trae_id_insrte);
$id_ingreso_pro_us = id_insert_sql_ser($sql_ex_p);

if($id_ingreso_pro_us>=1){//si se creo el usuario		

$inserta_us = "insert into us_usuarios (us_id,nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
values ($id_ingreso_pro_us,'$bp', '$email_contacto', '$cifra_c', '$email_contacto', '$ep',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
$sql_e=mysql_query($inserta_us);

}


?>
<script>
    alert("El registro se creo con 깩to")
    //window.parent.volver_listado('muestra_cootactos','carga_detalle_pro')
    window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?= $id_invitacion_pasa_final; ?>', 'contenidos');
</script>
<?


}////si se creo el proveedor

else{ //si no se creo el proveedor
?>
<script>
    alert("ATENCION: El PROVEEDOR NO SE PUDO CREAR VERIFIQUE QUE NO EXISTA")
            return;
</script>
<?		

}	//si no se creo el proveedor




}?>

<script>window.parent.document.getElementById("cargando_pecc").style.display = "none"</script>