<?  include("../lib/@session.php");


		 $lista_inci = "select distinct us_id , nombre_administrador  from $t1 where estado = 1 and nombre_administrador  like '%$q%' order by nombre_administrador limit 15";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			$objeto.= $lt[1]."----,".$lt[0]."----,<remplaza>";
		} 
		echo $objeto;
?>