<?  include("../lib/@session.php");
		 $lista_inci = "select distinct top 15  us_id , nombre_administrador  from $g1  where tipo_usuario not in (2) and estado = 1 and tipo_usuario <> 2 and (nombre_administrador  like '%$q%' or nombre_administrador  like '%$q2%') group by us_id, nombre_administrador order by nombre_administrador";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			//$lt[1]=str_replace(',', '', $lt[1]);
			$nombre_limpio=str_replace(',', '', $lt[1]);
			$objeto.= $nombre_limpio."----,".$lt[0]."----,<remplaza>";
		} 
		echo $objeto;
?>

