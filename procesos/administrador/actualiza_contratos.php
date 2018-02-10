<? include("../../librerias/lib/@include.php");
//include("../../librerias/lib/@session.php");
exit;/*
$sel_contratos = query_db("select id_contrato, creacion_sistema, recibido_abastecimiento_e, recibido_abastecimiento, firma_contratista_e, firma_contratista, revision_poliza_e, revision_poliza, revision_legal_e, revision_legal, sap_e, sap, firma_hocol_e, firma_hocol, legalizacion_final_e, legalizacion_final, id from t7_contratos_complemento");

while($sel_dato_contrato = traer_fila_db($sel_contratos)){
	$ob = "";
	
	$ob_recibido_abastecimiento=imprime_observacion(arreglo_pasa_variables($sel_dato_contrato[0]),arreglo_pasa_variables($sel_dato_contrato[16]),"recibido_abastecimiento");
	$ob_firma_contratista=imprime_observacion(arreglo_pasa_variables($sel_dato_contrato[0]),arreglo_pasa_variables($sel_dato_contrato[16]),"firma_contratista");
	$ob_revision_poliza=imprime_observacion(arreglo_pasa_variables($sel_dato_contrato[0]),arreglo_pasa_variables($sel_dato_contrato[16]),"revision_poliza");
	$ob_revision_legal=imprime_observacion(arreglo_pasa_variables($sel_dato_contrato[0]),arreglo_pasa_variables($sel_dato_contrato[16]),"revision_legal");
	$ob_sap=imprime_observacion(arreglo_pasa_variables($sel_dato_contrato[0]),arreglo_pasa_variables($sel_dato_contrato[16]),"sap");
	$ob_firma_hocol=imprime_observacion(arreglo_pasa_variables($sel_dato_contrato[0]),arreglo_pasa_variables($sel_dato_contrato[16]),"firma_hocol");
	$ob_legalizacion_final=imprime_observacion(arreglo_pasa_variables($sel_dato_contrato[0]),arreglo_pasa_variables($sel_dato_contrato[16]),"legalizacion_final");
	
	$sql_insert = "insert into t7_relacion_campos_legalizacion_datos (f_fin_creacion_sistema, 
	f_ini_recibido_ini_proceso, f_fin_recibido_ini_proceso, recibido_ini_proceso_ob, 
	f_ini_firma_rep_legal, f_fin_firma_rep_legal, firma_rep_legal_ob, 
	f_ini_revision_polizas, f_fin_revision_polizas, revision_polizas_ob,
	f_ini_rev_legal, f_fin_rev_legal, rev_legal_ob, 
	f_ini_rev_estrategia, f_fin_rev_estrategia, rev_estrategia_ob,
	f_ini_firma_hocol, f_fin_firma_hocol, firma_hocol_ob, 
	f_ini_entrega_doc_contrac, f_fin_entrega_doc_contrac, entrega_doc_contrac_ob, id_modificacion, f_ini_elaboracion,f_fin_elaboracion) values ('".$sel_dato_contrato[1]."', 
	'".$sel_dato_contrato[2]."', '".$sel_dato_contrato[3]."', '".$ob_recibido_abastecimiento."',
	'".$sel_dato_contrato[4]."', '".$sel_dato_contrato[5]."', '".$ob_firma_contratista."',
	'".$sel_dato_contrato[6]."', '".$sel_dato_contrato[7]."', '".$ob_revision_poliza."',
	'".$sel_dato_contrato[8]."', '".$sel_dato_contrato[9]."', '".$ob_revision_legal."',
	'".$sel_dato_contrato[10]."', '".$sel_dato_contrato[11]."', '".$ob_sap."',
	'".$sel_dato_contrato[12]."', '".$sel_dato_contrato[13]."', '".$ob_firma_hocol."',
	'".$sel_dato_contrato[14]."', '".$sel_dato_contrato[15]."', '".$ob_legalizacion_final."', ".$sel_dato_contrato[16].",'".$sel_dato_contrato[1]."','".$sel_dato_contrato[2]."')";
//	echo $sql_insert;
	$insert = query_db($sql_insert);
	}
	*/
?>