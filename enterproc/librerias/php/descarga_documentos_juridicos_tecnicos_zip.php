<? include("../lib/@session.php");
require_once('zip/pclzip.lib.php');
    //verifica_menu("procesos.html");
   /* header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
	header("Content-Transfer-Encoding: binary");*/

//eliminarDir(SUE_PATH_ARCHIVOS."temp");
//$crea_dire=mkdir(SUE_PATH_ARCHIVOS."temp");


/*

$filename = 'test.zip';

if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {//crear_archivo zip
*/


$busca_respo = query_db("select * from ".$t96." where pv_id = ".$pv_id." and evaluador1_id = $evaluador1_id");
			$suma_archivo_ajuste_chimbo=0;
			while($lc=traer_fila_row($busca_respo)){//busca archivos
			
ob_start();
$f1=fopen(SUE_PATH_ARCHIVOS."procesos_tecnicos/".$lc[0].".txt","rb");
fpassthru($f1);
$cadena = ob_get_contents();
ob_end_clean();
$cd=~$cadena;
fclose($f1);
$f2=fopen(SUE_PATH_ARCHIVOS."temp/".$lc[3],"w");
fwrite($f2,$cd);
	fclose($f2);
	
//echo $cd;

ob_end_flush();

$ListaArchivos_1.="'".SUE_PATH_ARCHIVOS."temp/".$lc[3]."',";

} // busca archivos

/*}//crea .zip
else
 echo 'Error creando '.$filename;
*/

$ListaArchivos_2 = strlen($ListaArchivos_1);
$ListaArchivos=substr($ListaArchivos_1, 0, ($ListaArchivos_2-1) );

echo $ListaArchivos;
$nuevos_archivos = array( $ListaArchivos);

/* Llamamos al metodo para agregar los $nuevos_archivos a vacio.zip */
$archive = new PclZip(SUE_PATH_ARCHIVOS."archive.zip");
//$agregar = $archive->add( $nuevos_archivos , PCLZIP_OPT_ADD_PATH , "subdirectorio" );

 $archive->create("zip/");
                        








//header("Content-Disposition: attachment; filename=$archivo_zip"); 

//auditor($tipo_juri_tec,$id_invitacion,$n2,'');
?>