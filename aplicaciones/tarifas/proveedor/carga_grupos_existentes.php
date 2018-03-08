<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
?>	
	
<select name="grupo_existentes" id="grupo_existentes" onchange="document.principal.grupo.value= this.value"> 
            <option>Grupos existentes.</option>
             <?
				 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$categoria_trae'";
					$sql_cate=query_db($busca_grupos);
					while($lista_categoria=traer_fila_row($sql_cate))
						echo "<option value='".$lista_categoria[0]."'>".$lista_categoria[0]."</option>"
			 
			 ?>
            </select>
            
            