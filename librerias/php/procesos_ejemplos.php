<?  include("../lib/@session.php");

	verifica_menu("procesos.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php
	//
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$sql_ex=query_db($sql_texto.$trae_id_insrte);
	//trae id ingreso
	$id_ingreso = id_insert($sql_ex);	// trae el id ubicacion sistem/db_mssql.php

	$id_invitacion_ar = arreglo_recibe_variables($id_invitacion); // descifra la variable enviada
	arreglo_pasa_variables($id_proceso)// pasa pariables cifradas sistem/valida_caracteres.php
	
	carga_archivo($sube_archivo,"procesos_proveedores/".$id_cargue);// funcion carga archivo cifrado, ubicacion sistem/valida_caracteres.php
   	$archiv_con = confirma_archivo($sube_archivo_size,"procesos_proveedores/".$id_cargue.".txt"); // funcion para confirmar carga archivo cifrado, ubicacion sistem/valida_caracteres.php
	elimina_archivo("procesos_proveedores/".$id_anexo.".txt")// elimina archivo, sistem/valida_caracteres.php

	$ext=extencion_archivos($archivo)//trae extencion para mostrar icono del archivo cargado
	//<img src='../imagenes/mime/$ext.gif'>
		
		?>
        <script> 
		alert("El proceso se creó con éxito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_p;?>','contenidos');
		</script>
      
     
	 <script>
//cierra la ventana gris de procesos
 window.parent.document.getElementById("cargando").style.display="none"
 </script>




