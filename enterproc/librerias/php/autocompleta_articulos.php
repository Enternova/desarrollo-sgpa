<?  include("../lib/@session.php");


		 $lista_inci = "select distinct $l2.lista2_id, $l2.detalle , $l2.codigo  from $l2, $l3  where $l2.estado = 1  and $l3.lista1_id = $l2.lista1_id 
		 and $l3.us_id = ".$_SESSION["id_us_session"]." 
		 and $l2.detalle  like '%$q%' order by $l2.detalle  limit 15";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			$objeto.=$lt[0]."----,Codigo:".$lt[2]."  ".$lt[1]."----,<remplaza>";
		} 
		echo $objeto;
?>