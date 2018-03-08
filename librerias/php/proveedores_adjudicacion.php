<?  include("../lib/@session.php");


		 $lista_inci = "select distinct top 15 t1_proveedor_id, razon_social, nit, estado_parservicios  from $g6  where creado_actualizado_desde_par='si' and estado = 1 and ((razon_social  like '%$q%' or nit  like '%$q%') OR (razon_social  like '%$q2%' or nit  like '%$q2%')) group by t1_proveedor_id , razon_social, nit, estado_parservicios order by razon_social  ";
		 $sql_ex=query_db($lista_inci);
		$array2=array();
		$arr=array();
		$i=0;
		while ($lt=traer_fila_row($sql_ex)){
			$array2['id']=$lt[0];
			$array2['nombre']=htmlentities($lt[1]);
			$array2['nit']=htmlentities($lt[2]);
			$array2['estado']=$lt[3];
			$arr[]=$array2;
			//$nombre_limpio=str_replace(',', '', $lt[1]);
			//$nombre_limpio2=str_replace(',', '', $lt[2]);
			//$objeto.= "".$lt[1]." ".$lt[2]."----,".$lt[0]."----,<remplaza>";			
			//$total_sin=array("total_sin"=>$total_sin_leer[0]);
			//$array2[]=$s_actual;
			$i++;
		}
		echo json_encode($arr);
?>