<?  include("../lib/@session.php");


		 $lista_inci = "select distinct top 15 t1_proveedor_id , razon_social, nit  from $g6  where estado = 1 and ((razon_social  like '%$q%' or nit  like '%$q%') OR (razon_social  like '%$q2%' or nit  like '%$q2%')) group by t1_proveedor_id , razon_social, nit order by razon_social  ";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			$nombre_limpio=str_replace(',', '', $lt[1]);
			$nombre_limpio2=str_replace(',', '', $lt[2]);
			$objeto.= "".$nombre_limpio." ".$nombre_limpio2."----,".$lt[0]."----,<remplaza>";
			} 
		echo $objeto;
?>