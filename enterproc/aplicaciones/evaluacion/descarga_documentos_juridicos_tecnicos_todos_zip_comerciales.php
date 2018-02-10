<? include("../../librerias/lib/@session.php");
require_once('../../librerias/php/zip/pclzip.lib.php');


 function downloadFile($fileUrl){


	// get file size	
	if (substr($fileUrl,0,4)=='http') {
        $fileSize = array_change_key_case(get_headers($fileUrl, 1),CASE_LOWER);
        if ( strcasecmp($fileSize[0], 'HTTP/1.1 200 OK') != 0 ) { $fileSize = $fileSize['content-length'][1]; }
        else { $fileSize = $fileSize['content-length']; }
    } else { $fileSize = @filesize($fileUrl); }
 
	// download file
	$ctype="application/octet-stream";
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-Type: $ctype");
 
	header("Content-Disposition: attachment; filename=\"".basename($fileUrl)."\";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".$fileSize);
	readfile("$fileUrl");
	exit();
 
}

    //verifica_menu("procesos.html");

	
		
	 $busca_procesos = "select consecutivo from $t5 where pro1_id = $evaluador1_id";
	$sql_proceso=traer_fila_row(query_db($busca_procesos));

$carpeta=$sql_proceso[0]."_comerciales";

eliminarDir(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta);
$crea_dire=mkdir(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta);

$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $evaluador1_id and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
				
				//eliminarDir(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta."/".valida_url($lp[2]);
				$crea_dire_sup_pr=mkdir(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta."/".valida_url($lp[2]));
				
				}


$busca_respo = query_db("select evaluador6_id, evaluador6_nombre,razon_social from ".$v10." where pro1_id = $evaluador1_id and termino = 1");
			$suma_archivo_ajuste_chimbo=0;
			while($lc=traer_fila_row($busca_respo)){//busca archivos
			
ob_start();
$f1=fopen(SUE_PATH_ARCHIVOS."procesos_tecnicos/".$lc[0].".txt","rb");
fpassthru($f1);
$cadena = ob_get_contents();
ob_end_clean();
$cd=~$cadena;
fclose($f1);
$f2=fopen(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta."/".valida_url($lc[2])."/".$lc[1],"w");
fwrite($f2,$cd);
	fclose($f2);
//b_end_flush();

} // busca archivos



$archive = new PclZip(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta."/".$carpeta.".zip");
//$agregar = $archive->add( $nuevos_archivos , PCLZIP_OPT_ADD_PATH , "subdirectorio" );

 $archive->create(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta."/");
                        

$busca_respo = query_db("select evaluador6_id, evaluador6_nombre,razon_social from ".$v10." where  pro1_id = $evaluador1_id and termino = 2");
			$suma_archivo_ajuste_chimbo=0;
			while($lc=traer_fila_row($busca_respo)){//busca archivos
			
			//$borra = unlink(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta."/".valida_url($lc[2])."/".$lc[1]);
			
			}



downloadFile(SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta."/".$carpeta.".zip");

//auditor($tipo_juri_tec,$id_invitacion,$n2,'');
?>