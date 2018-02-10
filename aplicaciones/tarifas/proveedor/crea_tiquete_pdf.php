<? include("../../../librerias/lib/@session.php"); 
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	include("crear_tiquete/genera_pdf.php"); 
?>