<? define('SUE_PATH_ARCHIVOS', "E:/sgpa_files/attfiles/");
//define('SUE_PATH_ARCHIVOS', "D:/attfiles_soft/sgpa/attfiles/");
	


    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=$n2"); 
	header("Content-Transfer-Encoding: binary");

//$busca_anexo= "update t6_tarifas_anexos_modifica_tarifas set anexo = 'anexo.xls'   where t6_tarifas_anexos_modifica_tarifas_id = 1729";
 //$bus_an_ta=traer_fila_row(query_db($busca_anexo));


ob_start();

$f1=fopen(SUE_PATH_ARCHIVOS."tarifas_aprobaciones/".$id_documen.".txt","rb");
fpassthru($f1);
$cadena = ob_get_contents();
ob_end_clean();
$cd=~$cadena;
echo $cd;
ob_end_flush();

?>