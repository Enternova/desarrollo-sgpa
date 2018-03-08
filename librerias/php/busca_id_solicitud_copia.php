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
	$sel_contratos_marco ="select distinct top 15 id_item, num1,num2,num3,numero_contrato,fecha_crea_contrato,objeto_solicitud, objeto_contrato,area,alcance,justificacion,recomendacion, apellido, razon_social,  fecha_fin_contrato, id_contrato, (num1+CONVERT(VARCHAR(2), num2)+'-'+CONVERT(VARCHAR(4),(CASE WHEN(LEN(num3))=4 THEN (''+num3) WHEN(LEN(num3))=3 THEN ('0'+num3) WHEN(LEN(num3))=2 THEN ('00'+num3) WHEN(LEN(num3))=1 THEN ('000'+num3) else '' end))) as consecutivo from $vpeec4 where id_item > 0 and fecha_fin_contrato>='$fecha_hoy' and (num1+CONVERT(VARCHAR(2), num2)+'-'+CONVERT(VARCHAR(4),(CASE WHEN(LEN(num3))=4 THEN (''+num3) WHEN(LEN(num3))=3 THEN ('0'+num3) WHEN(LEN(num3))=2 THEN ('00'+num3) WHEN(LEN(num3))=1 THEN ('000'+num3) else '' end)))  like '%$q%'";
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
			$objeto.= "-".$lt[16]."----,".$lt[5]."----,".$lt[8]."----,"." contrato #:".$lt[4]."----,".$lt[0]."----,<remplaza>";
		} 
		echo $objeto;
?>