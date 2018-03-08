<? include("../../../librerias/lib/@session.php");
require_once('../../../librerias/php/zip/pclzip.lib.php');

function elimina_comillas_2_archivos($valor){
$id_subastas_arrglo = str_replace("'", "", $valor );
$id_subastas_arrglo = str_replace('"', '', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace('/', '', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace('*', '', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace('.', '', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace('?', '', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace(',', '', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace('É', 'E', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace('&', '', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace('+', '', $id_subastas_arrglo);
$id_subastas_arrglo = str_replace('´', '', $id_subastas_arrglo);

									$id_subastas_arrglo = str_replace("ñ","n",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("Ñ","n",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("á","a",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("Á","a",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("é","e",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("É","e",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("í","i",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("Í","i",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("ó","o",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("Ó","o",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("ú","u",$id_subastas_arrglo);
									$id_subastas_arrglo = str_replace("Ú","u",$id_subastas_arrglo);
$id_subastas_arrglo = str_replace(" ","_",$id_subastas_arrglo);


return $id_subastas_arrglo;

}

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

$carpeta_q=elimina_comillas_2_archivos($sql_proceso[0]."_aclaraciones");

$carpeta = substr($carpeta_q, 0, 30);

eliminarDir($carpeta);
$crea_dire=mkdir($carpeta);

//$carpeta = "D:/desarrollo/www/sgpa-hocol/enterproc/aplicaciones/evaluacion/descargas_uno/";

 

$busca_provee = query_db("select razon_social, pro16_id  from v_urna_reporte_aclaraciones_finales where pro1_id =  $evaluador1_id and archivo_soporte <> '' GROUP BY razon_social, pro16_id ORDER BY razon_social");
				while($lp = traer_fila_row($busca_provee)){

					if(dir($carpeta."/".valida_url($lp[0]))) {
						$crea_p = 1;
							//$crea_dire_sup_pr=mkdir($carpeta."/".valida_url($lp[0])."/".$lp[1]);
						
						}
						
					else
						$crea_dire_sup_pr=mkdir($carpeta."/".valida_url($lp[0]));
					
				
				}
				

$busca_provee = query_db("select razon_social, pro16_id  from v_urna_reporte_aclaraciones_finales where pro1_id =  $evaluador1_id and archivo_soporte <> '' GROUP BY razon_social, pro16_id ORDER BY razon_social");
				while($lp = traer_fila_row($busca_provee)){

					if(dir($carpeta."/".valida_url($lp[0]))) {
						$crea_p = 1;
							$crea_dire_sup_pr=mkdir($carpeta."/".valida_url($lp[0])."/".$lp[1]);
						
						}

					
				
				}				

$busca_respo = "select razon_social, pro16_id, pro17_id, archivo_soporte  from v_urna_reporte_aclaraciones_finales where pro1_id =  $evaluador1_id and archivo_soporte <> ''  ORDER BY razon_social";
$busca_respo = query_db($busca_respo);
			$suma_archivo_ajuste_chimbo=0;
			while($lc=traer_fila_row($busca_respo)){//busca archivos

			$nombre_archivo_arr_numero = strrpos($lc[3],".");
			$nombre_archivo_arr_priemera_parte = substr($lc[3],0,$nombre_archivo_arr_numero ) ;
			$nombre_archivo_arr_segunda_parte = substr($lc[3],$nombre_archivo_arr_numero,10 ) ;
			
			$arregla_priemra_parte = elimina_comillas_2_archivos($nombre_archivo_arr_priemera_parte);
			

			$union_partes = $arregla_priemra_parte.$nombre_archivo_arr_segunda_parte;	

ob_start();
$f1=fopen(SUE_PATH_ARCHIVOS."procesos_cartelera_final/".$lc[2].".txt","rb");
fpassthru($f1);
$cadena = ob_get_contents();
ob_end_clean();
$cd=~$cadena;
fclose($f1);
$f2=fopen($carpeta."/".valida_url($lc[0])."/".$lc[1]."/".$union_partes,"w");
fwrite($f2,$cd);
	fclose($f2);
//b_end_flush();

} // busca archivos



$archive = new PclZip($carpeta."/".$carpeta.".zip");
//$agregar = $archive->add( $nuevos_archivos , PCLZIP_OPT_ADD_PATH , "subdirectorio" );

 $archive->create($carpeta."/");
                        

$busca_respo = "select razon_social, pro16_id, pro17_id, archivo_soporte  from v_urna_reporte_aclaraciones_finales where pro1_id =  $evaluador1_id and archivo_soporte <> ''  ORDER BY razon_social";
$busca_respo = query_db($busca_respo);
			$suma_archivo_ajuste_chimbo=0;
			while($lc=traer_fila_row($busca_respo)){//busca archivos

			$nombre_archivo_arr_numero = strrpos($lc[3],".");
			$nombre_archivo_arr_priemera_parte = substr($lc[3],0,$nombre_archivo_arr_numero ) ;
			$nombre_archivo_arr_segunda_parte = substr($lc[3],$nombre_archivo_arr_numero,10 ) ;
			
			$arregla_priemra_parte = elimina_comillas_2_archivos($nombre_archivo_arr_priemera_parte);
			

			$union_partes = $arregla_priemra_parte.$nombre_archivo_arr_segunda_parte;	
			
			$borra = unlink($carpeta."/".valida_url($lc[0])."/".$lc[1]."/".$union_partes);
			
			
			}

	header("Location: ".$carpeta."/".$carpeta.".zip");

/*
copy($carpeta."/".$carpeta.".zip",SUE_PATH_ARCHIVOS."descargas_uno/".$carpeta.".zip");
eliminarDir($carpeta);


	header("Location: ../../../../att_sgpa/".$carpeta.".zip");

//auditor($tipo_juri_tec,$id_invitacion,$n2,'');
*/
?>