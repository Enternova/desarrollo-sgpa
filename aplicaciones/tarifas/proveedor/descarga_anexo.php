<? include("../../../librerias/lib/@session.php");
//	verifica_menu("proveedores.html");
  $busca_anexo= "select detalle,t6_tarifas_proveedor_prefactura_anexos_id from t6_tarifas_proveedor_prefactura_anexos    where t6_tarifas_proveedor_prefactura_anexos_id = $id_documen";
 $bus_an_ta=traer_fila_row(query_db($busca_anexo));

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=".$bus_an_ta[0]); 
	header("Content-Transfer-Encoding: binary");


ob_start();

$f1=fopen(SUE_PATH_ARCHIVOS."tarifas_ane_descue/".$id_documen.".txt","rb");
fpassthru($f1);
$cadena = ob_get_contents();
ob_end_clean();
$cd=~$cadena;
echo $cd;
ob_end_flush();
?>