<?  include("../lib/@session.php");

		 $lista_inci = "select  t6_tarifas_maestras_lista_id , categoria_maestra + ' => ' + sub_categoria_maestra + ' => ' + nombre_lista_maestra  from $v_t_8  where estado_lista = 1 and categoria_maestra + ' => ' + sub_categoria_maestra + ' => ' + nombre_lista_maestra  like '%$q%' order by categoria_maestra, sub_categoria_maestra,  nombre_lista_maestra ";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			$objeto = $lt[1]."----,".$lt[0]."----";
			?>
            <?=$objeto?>
            
		<? } ?>
