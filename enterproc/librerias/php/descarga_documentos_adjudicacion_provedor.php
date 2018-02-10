<? include("../lib/@session.php");
    //verifica_menu("procesos.html");
   header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=$n2"); 
	header("Content-Transfer-Encoding: binary");


ob_start();

$f1=fopen(SUE_PATH_ARCHIVOS."procesos_adjudicacion_proveedor/".$n1.".txt","rb");
fpassthru($f1);
$cadena = ob_get_contents();
ob_end_clean();
$cd=~$cadena;
echo $cd;
ob_end_flush();

?>