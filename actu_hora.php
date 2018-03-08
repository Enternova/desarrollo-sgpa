<?  session_start();
	ob_start();
	//include("librerias/lib/@include.php");
    //$numero_get = valida_get();
    //$numer = numero_ingresos_get();
	$fecha = date("Y-m-d");
	$hora = date("H:i:s");	
	echo fecha_for_hora($fecha." ".$hora);
?>

