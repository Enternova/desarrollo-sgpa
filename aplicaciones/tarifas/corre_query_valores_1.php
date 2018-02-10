<? include("../../librerias/lib/@session.php"); 
	
	
	 $busca_tarifas = "select t6_tarifas_lista_id, valor_decimal, valor from t6_tarifas_lista ";
	$sql_contratos = query_db($busca_tarifas);
		while($lista_contartos = traer_fila_row($sql_contratos)){//contratos
	//	$text = $lista_contartos[2] ;
		//$aparicones= substr_count($text, ',');
		//if ($aparicones>=2)
			//echo $lista_contartos[0]." ".$lista_contartos[2]."<br>";
		
		$valor_arreglado_suma += $lista_contartos[2];
		
			$valor_arreglado = number_format($lista_contartos[2],2,",","");
			$valor_arreglado_decimal = number_format($lista_contartos[2],2,".","");
			 $cambni = "update t6_tarifas_lista set valor_decimal_2 = '$valor_arreglado', valor_decimal = $valor_arreglado_decimal where t6_tarifas_lista_id = $lista_contartos[0]  ";			
	//		$sql_quety = query_db($cambni);
//				echo $valor_arreglado." ".number_format($lista_contartos[2],2)."<br>";
			
			
			}//contratos
	
	echo $valor_arreglado_suma;
	
	
	
//echo strlen($text); // 14


	
	?>