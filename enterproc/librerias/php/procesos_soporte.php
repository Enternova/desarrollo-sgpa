<?  include("../../../librerias/lib/@session.php");


$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

if($_POST["accion"]=="crea_soporte")
	{
	


		echo $inserta_procesos="insert into help_respuestas (help_id,us_id,fecha,detallle, proxima_llamada)
		 values ($id_soporte, ".$_SESSION["id_us_session"].",'$fecha $hora', '".elimina_comillas_2(htmlentities($pregunta_general))."', '".elimina_comillas_2($h_m_r)."')";
		$sql_ex=query_db($inserta_procesos.$trae_id_insrte);
			
			$id_ingreso = id_insert($sql_ex);
			
			if($id_ingreso>=1){
		
			$update = query_db("update  v_help_principal set resuelto = $efectividad_bita where  help_id = $id_soporte");
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		//alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/c_soporte_tetnico.php?id_soporte_pasa=<?=$id_soporte;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script>
        window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El proceso NO se creó con éxito', 20, 10, 18);
		//alert("ATENCIÓN:\nEl proceso NO se creó con éxito")
        </script>
		<?
		
		
		}
	
	}


?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>



