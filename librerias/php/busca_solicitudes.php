<?  include("../lib/@session.php");


//Cyrillic_General_CI_AI - Latin1_CI_AS  quita las tildes
		 $lista_inci = "select top 15 id_item, cast(num1 +''+ num2+'-'+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) from t2_item_pecc  where  cast(num1 +''+ num2+'-'+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%' or  cast(num1 +''+ num2+' '+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%' or  cast(num1 +''+ num2+''+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%' and estado <> 33  ";
		 
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
			
		
			
					$numero_proceso=numero_item_pecc($lt[1],$lt[2],$lt[3]);
			
			
			
			$objeto.= $numero_proceso."----,".$lt[0]."----,<remplaza>";
		} 
		echo $objeto;
?>