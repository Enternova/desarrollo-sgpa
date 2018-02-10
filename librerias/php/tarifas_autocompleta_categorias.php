<?  include("../lib/@session.php");


		 $lista_inci = "select distinct top 15 t6_tarifas_maestras_categoria_id , nombre  from $t8  where estado = 1 and (nombre  like '%$q%' or nombre  like '%$q2%') group by t6_tarifas_maestras_categoria_id , nombre order by nombre  ";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			$nombre_limpio=str_replace(',', '', $lt[1]);
			$objeto.= $nombre_limpio."----,".$lt[0]."----,<remplaza>";
			} 
		echo $objeto;
?>

