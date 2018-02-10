<?

	function listas_sin_seleccione($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			
			$sel_ls = "select * from ".$tabla." where ".$where." order by ".$orden;
			
			$sql_ex_ls=query_db($sel_ls);
			while($ls = traer_fila_db($sql_ex_ls)){
			if($ls[0]==$seleccion){
				$slecciona = "selected";
			}else{
				$slecciona = "";
			}
			
			$option.="<option value='".$ls[0]."' ".$slecciona.">".$ls[$columna_trae]."</option>";
			}
			
			return $option;
		
		}
		
	function listas($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			$option="<option value='0'>Seleccione</option>";
			$sel_ls = "select * from ".$tabla." where ".$where." order by ".$orden;
			
			$sql_ex_ls=query_db($sel_ls);
			while($ls = traer_fila_db($sql_ex_ls)){
			if($ls[0]==$seleccion){
				$slecciona = "selected";
			}else{
				$slecciona = "";
			}
			
			$option.="<option value='".$ls[0]."' ".$slecciona.">".$ls[$columna_trae]."</option>";
			}
			
			return $option;
		
		}
		
	function listas_afuera($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[0]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[$columna_trae]."' ".$slecciona.">".$ls[$columna_trae]."</option>";
			}
			
			return $option;
		
		}	
		
	function listas_afuera_evaluacion($tabla, $where,$seleccion,$orden, $columna_trae, $columna_muestra)
		{
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[2]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[$columna_trae]."' ".$slecciona.">".$ls[$columna_muestra]."</option>";
			}
			
			return $option;
		
		}			
		
	function listas_selecc_diferente_id($tabla, $where,$seleccion,$orden, $columna_trae)
		{
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[$columna_trae]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[$columna_trae]."' ".$slecciona.">".$ls[$columna_trae]."</option>";
			}
			
			return $option;
		
		}			
		
	function listas_sin_select($tabla,$where,$columna_trae)
		{
			
		$sel = "select * from ".$tabla;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[0]==$where)
				$option =$ls[$columna_trae];
			}

			return $option;
		
		}			

function arma_campo_digitacion($tipo_campo,$nombre_campo,$valor_llena){
global $g5;
	if($tipo_campo==1)
		$campo= "<input type='text' name='".$nombre_campo."' value='".$valor_llena."' class='campos_tarifas'";
	if($tipo_campo==3)
		$campo= "<input type='text' name='".$nombre_campo."' value='".$valor_llena."' class='campos_tarifas'";
	if($tipo_campo==5)
		$campo= "<input type='text' name='".$nombre_campo."' value='".$valor_llena."' class='campos_tarifas'";
	if($tipo_campo==4){
		$campo="<select name='.$nombre_campo.' class='select_tarifas'>";
		$campo.= listas($g5, " t1_moneda_id >=1 ",$valor_llena,"nombre", 1);
		$campo.="</select>";
		}
	if($tipo_campo==2)
		$campo= "<textarea cols='45' rows='2' class='textarea_tarifas' id='textarea'>".$valor_llena."</textarea>";
		
	return	$campo;


}
function llena_valor_lista($seleccion,$tabla, $where){
	$sel = "select $seleccion from ".$tabla." where ".$where;
	$sql_ex=traer_fila_row(query_db($sel));
	return $sql_ex[1];
}			

?>