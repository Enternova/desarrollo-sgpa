<?php
	include("../lib/@session.php");
	//ini_set('display_errors','On');

//error_reporting(E_ALL | E_STRICT);
	$query="";
	$arrcorado=explode('0',$q);
	for($i=0; $i<sizeof($arrcorado); $i++){//v_pecc_contratos
		$query=$query.$arrcorado[$i];
	}
	$objeto="";
	$fecha_hoy = date("Y-m-d");
	$sel_contratos_marco ="select top 15 id_item, cast(num1 +''+ num2+'-'+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text), objeto_solicitud from t2_item_pecc  where  cast(num1 +''+ num2+'-'+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%' or  cast(num1 +''+ num2+' '+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%' or  cast(num1 +''+ num2+''+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%' and estado <> 33  ";
	$sql_ex=query_db($sel_contratos_marco);
		while ($lt=traer_fila_row($sql_ex)){
			/*if(strlen($lt[3])==1){
				$objeto.= "-".$lt[1].$lt[2]."000".$lt[3]."----,".$lt[5]."----,".$lt[8]."----,"." contrato #:".$lt[4]."----,".$lt[0]."----,<remplaza>";
			}else if(strlen($lt[3])==2){
				$objeto.= "-".$lt[1].$lt[2]."00".$lt[3]."----,".$lt[5]."----,".$lt[8]."----,"." contrato #:".$lt[4]."----,".$lt[0]."----,<remplaza>";
			}else if(strlen($lt[3])==3){
				$objeto.= "-".$lt[1].$lt[2]."0".$lt[3]."----,".$lt[5]."----,".$lt[8]."----,"." contrato #:".$lt[4]."----,".$lt[0]."----,<remplaza>";
			}else{
				$objeto.= "-".$lt[1].$lt[2].$lt[3]."----,".$lt[5]."----,".$lt[8]."----,"." contrato #:".$lt[4]."----,".$lt[0]."----,<remplaza>";
			}*/
			$objeto.=$lt[1]."----,".$lt[2]."  ----,"."  ----,"."  ----,".$lt[0]."----,<remplaza>";
		} 
		echo $objeto;
?>