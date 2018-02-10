<? include("../../librerias/lib/@session.php"); 
	
	

	
	 $filename = $_GET["archivo"];
	  $file = "E:/sgpa_files/SAP/PDF/".$_GET["archivo"];
	echo $file;
	
	
header("Content-Description: Descargar imagen");
 header("Content-Disposition: attachment; filename=$filename");
 header("Content-Type: application/force-download");
 header("Content-Length: " . filesize($file));
 header("Content-Transfer-Encoding: binary");
 readfile($file);
 
 
	
	
	?>