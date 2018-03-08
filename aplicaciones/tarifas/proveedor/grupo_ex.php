<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	if($busca==1) { $nombre_campo = "grupo_existentes_busca"; $java_sc = "";}
	else { $nombre_campo = "grupo_existentes"; $java_sc = "document.principal.grupo.value= this.value"; }
?>	
	
<select name="<?=$nombre_campo;?>" id="<?=$nombre_campo;?>" onchange="<?=$java_sc;?>"> 
            <option value="no_apli_b">Grupos existentes.</option>
             <?
				 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$categoria_trae'";
					$sql_cate=query_db($busca_grupos);
					while($lista_categoria=traer_fila_row($sql_cate))
						echo "<option value='".$lista_categoria[0]."'>".$lista_categoria[0]."</option>"
			 
			 ?>
            </select>
            
            