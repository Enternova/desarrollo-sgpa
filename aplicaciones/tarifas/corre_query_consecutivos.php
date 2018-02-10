<? include("../../librerias/lib/@session.php"); 
	
	
	 $busca_tarifas = "select tarifas_contrato_id from t6_tarifas_contratos";
	$sql_contratos = query_db($busca_tarifas);
		while($lista_contartos = traer_fila_row($sql_contratos)){//contratos
			$consecutivo = 1;
				
				 $busca_tarifas = "select t6_tarifas_lista_id from t6_tarifas_lista where tarifas_contrato_id = $lista_contartos[0] order by t6_tarifas_lista_id asc";
				$sql_tarifas= query_db($busca_tarifas);
				while($lista_tarifas = traer_fila_row($sql_tarifas)){//tarifas
				
				 $cambia_conse = "update t6_tarifas_lista set consecutivo_tarifa = $consecutivo where t6_tarifas_lista_id = $lista_tarifas[0]";
				$sql_cons_ca = query_db($cambia_conse);
				
				$consecutivo++;
				
				}//tarifas
					
			
			
			}//contratos
	
	
	
	?>