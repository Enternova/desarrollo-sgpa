<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_comite = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));
	
	
	$sele_comite = traer_fila_row(query_db("select * from $c1 where id_comite = ".$id_comite.""));
	
	   
	?>
    
    <table width="187"	 border="0">
  <tr>
    <td><?  echo carga_sub_menu_comite($id_comite); ?></td>
  </tr>
</table>
