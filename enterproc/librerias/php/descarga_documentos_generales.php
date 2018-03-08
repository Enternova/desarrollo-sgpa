<? include("../lib/@session.php");
	header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=".$_GET["n2"]);//nombre del archivo 
	header("Content-Transfer-Encoding: binary");

ob_start();/*
if($n3!=7 and $n3 !='tarifas_inhabilita' and $n3!=8){
	$f1=fopen(SUE_PATH_ARCHIVOS."pecc/".$n1."_".$n3.".txt","rb");
}elseif($n3=='tarifas_inhabilita'){
	$f1=fopen(SUE_PATH_ARCHIVOS."/tarifas_inhabilitadas/".$n1.".txt","rb");
}elseif($n3==8){
	$f1=fopen(SUE_PATH_ARCHIVOS."pecc/afe_ceco/".$n1."_".$n3.".txt","rb");
		echo SUE_PATH_ARCHIVOS."pecc/afe_ceco/".$n1."_".$n3.".txt";
}else{
	if($n3==7){
		$f1=fopen(SUE_PATH_ARCHIVOS."procesos_contrato/".$n4."_".$n1."_".$n3.".txt","rb");
	}
}
	*/  
	
if($n3=='tarifas_inhabilita'){
	$f1=fopen(SUE_PATH_ARCHIVOS."/tarifas_inhabilitadas/".$n1.".txt","rb");
}elseif($n3==8){
	$f1=fopen(SUE_PATH_ARCHIVOS."pecc/afe_ceco/".$n1."_".$n3.".txt","rb");
}elseif($n3==7){
		$f1=fopen(SUE_PATH_ARCHIVOS."procesos_contrato/".$n4."_".$n1."_".$n3.".txt","rb");
}elseif($n3==10){
		$f1=fopen(SUE_PATH_ARCHIVOS."manual_tarifa/".$n1."_".$n3.".txt","rb");
}else{
	$f1=fopen(SUE_PATH_ARCHIVOS."pecc/".$n1."_".$n3.".txt","rb");
	}


	
fpassthru($f1);
$cadena = ob_get_contents();
ob_end_clean();
$cd=~$cadena;
echo $cd;
ob_end_flush();
auditor(3,$id_invitacion,$n1,'');

?>