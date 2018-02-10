<? include("../lib/@session.php");
    //verifica_menu("procesos.html");
   header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
/** INICIO PARA EL INCIDENTE DE NO DESCARGAR LOS ARCHIVOS **/
if(file_exists(SUE_PATH_ARCHIVOS."tarifas_reembolsables/".$n1.".txt")){//si el archivo exite para poder descargarlo.
	header("Content-Disposition: attachment; filename=$n2");
}else{//si no existe el archivo original, buscar el archivo de la tarifa original.
	//primero busca los datos para buscar los originales.
	$id_reembolsable_arr=$n3;
	$t6_tarifas_municipios_proyectos_id=$n4;
	$detalle=$n5;
	
	$tarifa_recibida=traer_fila_row_sql_server(query_db_sql_server("SELECT t6_tarifas_reembolables_datos_id, consecutivo, tarifas_contrato_id, numero_ediciones from v_reembolsables_datos where t6_tarifas_reembolables_datos_id=".$id_reembolsable_arr));
	
	$id_documento_original=traer_fila_row_sql_server(query_db_sql_server("SELECT t6_tarifas_reembolables_datos_id, consecutivo, tarifas_contrato_id, numero_ediciones from v_reembolsables_datos where consecutivo=".$tarifa_recibida[1]." and tarifas_contrato_id=".$tarifa_recibida[2]." and numero_ediciones=0"));
	
	
	$busca_lista_ree = traer_fila_row_sql_server(query_db_sql_server("select t6_tarifas_reembolables_datos_detalle_id, anexo from t6_tarifas_reembolables_datos_detalle where t6_tarifas_reembolables_datos_id = ".$id_documento_original[0]." and t6_tarifas_municipios_proyectos_id = $t6_tarifas_municipios_proyectos_id and t6_tarifas_reembolables_categoria_id= ".$detalle.""));
	header("Content-Disposition: attachment; filename=".$busca_lista_ree[1]);
}
/** FIN PARA EL INCIDENTE DE NO DESCARGAR LOS ARCHIVOS **/
	header("Content-Transfer-Encoding: binary");
/** INICIO PARA EL INCIDENTE DE NO DESCARGAR LOS ARCHIVOS **/
if(file_exists(SUE_PATH_ARCHIVOS."tarifas_reembolsables/".$n1.".txt")){//si el archivo exite para poder descargarlo.
	ob_start();

	$f1=fopen(SUE_PATH_ARCHIVOS."tarifas_reembolsables/".$n1.".txt","rb");
	fpassthru($f1);
	$cadena = ob_get_contents();
	ob_end_clean();
	$cd=~$cadena;
	echo $cd;
	ob_end_flush();
}else{//si no existe el archivo original, buscar el archivo de la tarifa original.
	//primero busca los datos para buscar los originales.
	ob_start();

	$f1=fopen(SUE_PATH_ARCHIVOS."tarifas_reembolsables/".$busca_lista_ree[0].".txt","rb");
	fpassthru($f1);
	$cadena = ob_get_contents();
	ob_end_clean();
	$cd=~$cadena;
	echo $cd;
	ob_end_flush();
}

/** FIN PARA EL INCIDENTE DE NO DESCARGAR LOS ARCHIVOS **/
?>