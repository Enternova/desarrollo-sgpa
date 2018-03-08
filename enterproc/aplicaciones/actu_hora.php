<? include("../librerias/lib/@session.php");
		$inserta_conexion=query_db("update $t25 set ultima_conexion='$fecha $hora' where session = '".$_SESSION["session_id"]."'");	
		echo "Fecha y hora actual: ".fecha_for_hora($fecha." ".$hora);
?>

