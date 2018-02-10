<?  include("../lib/@session.php");
		$query="";
		$query=$q;
		/*$arrcorado=explode('0',$q);
		for($i=0; $i<sizeof($arrcorado); $i++){
			$query=$query.$arrcorado[$i];
		}*/
		 $lista_inci = "select distinct top 15 c.id_comite, c.num1, c.num2,c.num3, c.tipo_comite_extraordinario as tipo, u.nombre_administrador, c.fecha_creacion, (c.num1+CONVERT(VARCHAR(2), c.num2)+'-'+CONVERT(VARCHAR(4),(CASE WHEN(LEN(c.num3))=4 THEN (''+c.num3) WHEN(LEN(c.num3))=3 THEN ('0'+c.num3) WHEN(LEN(c.num3))=2 THEN ('00'+c.num3) WHEN(LEN(c.num3))=1 THEN ('000'+c.num3) else '' end))) from t3_comite as c, t1_us_usuarios as u where c.id_us_crea=u.us_id and c.tipo_comite_extraordinario is not null and (c.num1+CONVERT(VARCHAR(2), c.num2)+'-'+CONVERT(VARCHAR(4),(CASE WHEN(LEN(c.num3))=4 THEN (''+c.num3) WHEN(LEN(c.num3))=3 THEN ('0'+c.num3) WHEN(LEN(c.num3))=2 THEN ('00'+c.num3) WHEN(LEN(c.num3))=1 THEN ('000'+c.num3) else '' end))) like '%$query%' order by c.fecha_creacion desc";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){
			if($lt[4]==1){
				$tipo="Extraordinario";
			}else{
				$tipo="Normal";
			}
			$objeto.= "".$lt[7]."----,".$tipo."----,".$lt[5]."----,".$lt[6]."----,".$lt[0]."----,<remplaza>";
			/*if(strlen($lt[3])==1){
				$objeto.= "".$lt[1].$lt[2]."-000".$lt[3]."----,".$tipo."----,".$lt[5]."----,".$lt[6]."----,".$lt[0]."----,<remplaza>";
			}else if(strlen($lt[3])==2){
				$objeto.= "".$lt[1].$lt[2]."-00".$lt[3]."----,".$tipo."----,".$lt[5]."----,".$lt[6]."----,".$lt[0]."----,<remplaza>";
			}else if(strlen($lt[3])==3){
				$objeto.= "".$lt[1].$lt[2]."-0".$lt[3]."----,".$tipo."----,".$lt[5]."----,".$lt[6]."----,".$lt[0]."----,<remplaza>";
			}else{
				$objeto.= "".$lt[1].$lt[2]."-".$lt[3]."----,".$tipo."----,".$lt[5]."----,".$lt[6]."----,".$lt[0]."----,<remplaza>";
			}*/
			} 
		echo $objeto;
?>