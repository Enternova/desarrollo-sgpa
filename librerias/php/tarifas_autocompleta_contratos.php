<?  include("../lib/@session.php");


		 $lista_inci = "select distinct top 15 tarifas_contrato_id , consecutivo  from $t1  where consecutivo  like '%$q%' order by consecutivo  ";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			$objeto.= $lt[1]."----,".$lt[0]."----,<remplaza>";
			} 
		echo $objeto;
?>