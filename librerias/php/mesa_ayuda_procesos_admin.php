<?  include("../lib/@session.php");
include("tarifas_modelos_email.php");
header('Content-Type: text/html; charset=ISO-8859-1');
	verifica_menu("administracion.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php

if($_POST["accion"]=="novedad_en_firme")
	{
		echo $cambia_estado = "update t10_relacion_usuario_novedada set estado_firme = 2, fecha_firme = '$fecha $hora' where t10_mesa_ayuda_principal_id = $t10_mesa_ayuda_principal_id and us_id = ".$_SESSION["id_us_session"];
		$sql_cambi = query_db($cambia_estado);		
		
		?>
        
        			<script> 
						window.parent.document.getElementById("cargando_noticias_inbox").style.display = "";
						window.parent.document.getElementById("cargando_noticias_inbox").innerHTML = '';
						window.parent.document.getElementById("carga_alertas").style.display = "";
						window.parent.document.getElementById("carga_noticias").innerHTML = '';
						window.parent.ajax_carga("../aplicaciones/mesa-ayuda/noticias_inbox.php","cargando_noticias_inbox");
                    </script>
        
        <?
		
 		
		}

?>

		