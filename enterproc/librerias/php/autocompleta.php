<?  include("../lib/@session.php");


		 $lista_inci = "select distinct  pv_id , razon_social,nit  from pv_proveedores  where estado = 1 and concat(razon_social,nit)  like '%$q%'  order by razon_social  limit 15";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			$objeto.= $lt[1]."----,".$lt[0]."----,".$lt[2]."----,<remplaza>";
		} 
		echo $objeto;
?>