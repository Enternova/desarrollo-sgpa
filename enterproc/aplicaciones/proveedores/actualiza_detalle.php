<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");

	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$us_cliente = $_SESSION["id_proveedor"];

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));


function items_ganadores($nombre_campo,$oferta_vista,$campo_valos,$trm, $busca_campos_moneda_lista_no)
	{
	global $lista_oferentes,$cuenta_proveedores,$id_invitacion,$tabla_economica,$t95,$tipo_busq, $t94, $us_cliente,$t19;


	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	$campo_campos="";
	$campo_campos2="";
	$total_afectado_final="";
	$faltan_datos_obligatorios=0;

    $busca_campos = query_db("select * from $t95 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){ 
	$campo_campos=""; 
	


	$busca_campos_moneda_lista = traer_fila_row(query_db("select * from $t94 where pro11_id = $l_campo[9] and evaluador4_tipo = 'Moneda'"));
	

		$busca_valores_ing_valida_campos=traer_fila_row(query_db("select count(w_valor) from $tabla_economica  
		where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id in ($campo_valos) 
		and oferta = $oferta_vista and w_valor = '' "));	

	
	


		$busca_valores_ing=traer_fila_row(query_db("select sum(w_valor) from $tabla_economica  
		where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id in ($campo_valos) 
		and oferta = $oferta_vista  "));	
	
		
	
				
					if($busca_valores_ing_valida_campos[0]=="0"){//si el campo tiene valor
										

										if($l_campo[6]=="USD")
											$total_afectado= (($busca_valores_ing[0] * $l_campo[5] ) * $trm) * 1.16;
										elseif($l_campo[6]=="COP")
											$total_afectado= ($busca_valores_ing[0] * $l_campo[5] ) * 1.16;
										else{//si se solicita la cotizacion en MULTIMONEDA
													
													$busca_valores_moneda_proveedor=traer_fila_row(query_db("select w_valor from $tabla_economica  
													where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] 
													and evaluador4_id = $busca_campos_moneda_lista[0] and oferta = 1"));
													
													
														if($busca_valores_moneda_proveedor[0]=="COP")
															$total_afectado= ( $busca_valores_ing[0] * $l_campo[5] )  * 1.16;
				
														if($busca_valores_moneda_proveedor[0]=="USD")
															$total_afectado= (($busca_valores_ing[0] * $l_campo[5] ) * $trm) * 1.16;
				
														else
															$total_afectado= ( $busca_valores_ing[0] * $l_campo[5] )  * 1.16;
											
											
										} //si se solicita la cotizacion en MULTIMONEDA
											
										$total_afectado_final+=$total_afectado;
										$inserta_temporal = "insert into reporte_temp1_$us_cliente values 
										('$id_invitacion','$lista_oferentes[$yy]','$l_campo[9]', '$busca_valores_ing[0]', '$total_afectado','1' )";
										$sql_str=query_db($inserta_temporal);
										//$total_afectado=  $l_campo[5] ;										

									}//si el campo tiene valor
									else
										{
											$faltan_datos_obligatorios+=1;
										}
		
							
		}//while

									if($faltan_datos_obligatorios>=1)
										{
											$delete_proveedor="delete from reporte_temp1_$us_cliente where pv_id = '$lista_oferentes[$yy]'";
											$sql_ex = query_db($delete_proveedor);
										}
		
		}//for
		
	$busca_lista= query_db("select * from $t19 where pro1_id = $id_invitacion");
	while($ls_t=traer_fila_row($busca_lista)){//busca listas

	$select_minimo_lista = traer_fila_row(query_db("select  sum(valor_total) as mejor  from reporte_temp1_$us_cliente where id_lista = $ls_t[0] group by pv_id order by mejor asc"));

	$select_formula = traer_fila_row(query_db("select * from pro10_formulas where pro1_id = $id_invitacion and pro11_id = $ls_t[0] and tipo_formula = 2"));
	$formula_aplicada = $select_formula[2];
$reemplaza_valores ="";
	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes

	$select = traer_fila_row(query_db("select count(*), sum(valor_total) from reporte_temp1_$us_cliente  where pv_id = '$lista_oferentes[$yy]' and id_lista = $ls_t[0]"));

	

		  $reemplaza_valores = str_replace("min",$select_minimo_lista[0],$formula_aplicada);
		   $reemplaza_valores = str_replace("total",$select[1],$reemplaza_valores);			  
			

		$busca_resultado_sql = traer_fila_row(query_db("select $reemplaza_valores "));
		
		$inserta_temporal = "insert into reporte_temp1_$us_cliente values 
		('$id_invitacion','$lista_oferentes[$yy]',0, 0, '$busca_resultado_sql[0]','2' )";
		$sql_str=query_db($inserta_temporal);
	
		}//for oferentes
		$cuenta_pasada_para_formula=0;// cuenta para reemplazar formula
}//busca listas
			
			
	}// function



$busca_campo_subasta_consoli = traer_fila_row(query_db("select evaluador3_termino from $t93 where in_id = $id_invitacion and evaluador3_termino=10 "));
if($busca_campo_subasta_consoli[0]==10){//si tiene subasta consolidada activa
/********************************************************************************************/
	/*CREA TABLA TEMPORAL*/	
	$sql_tabla="CREATE  TEMPORARY TABLE reporte_temp1_$us_cliente ( pro1_id varchar(50) NOT NULL, pv_id varchar(50) NOT NULL,
		 id_lista varchar(50) NOT NULL, valor varchar(50) NOT NULL, valor_total varchar(50) NOT NULL, tipo_valor varchar(50) NOT NULL ) " ;		
		$query_crea = query_db($sql_tabla);		
	/********************************************************************************************/
	/*CREA TABLA TEMPORAL*/	
	/********************************************************************************************/

//-------------------------------------------------------------------------------------------------------------------------------
//ARREGLO PROVEEDORES ACEPTADOS
//-------------------------------------------------------------------------------------------------------------------------------
	 $cuenta_proveedores=0;
	$busca_vaor_tecnica = traer_fila_row(query_db("select * from $t93 where in_id = $id_invitacion and evaluador3_termino = 2"));
	 $busca_respo = query_db("select $t7.pro1_id, $t8.razon_social , $t8.nit , $t8.pv_id,$t8.pv_id from $t7,$t8 where $t7.pro1_id  = $id_invitacion and $t8.pv_id = $t7.pv_id ");
		while($lc=traer_fila_row($busca_respo))
		{
	
		if($busca_vaor_tecnica[3]>=1)
				{//si tiene evaluacion tecnica
					$bus_his = traer_fila_row(query_db("select count($t98.evaluador7_valor), sum($t98.evaluador7_valor)  from $t98,$t91 where $t91.in_id = $id_invitacion 
					and $t98.pv_id = $lc[4] and $t91.evaluador1_id  = $t98.evaluador1_id group by $t91.in_id"));   
						$operacion_aceptacion = ($bus_his[1]/$bus_his[0]);
							if($operacion_aceptacion>=$busca_vaor_tecnica[3]){//si el proveedor es aceptado
								$cuenta_proveedores+=1;
								$resutado_pro.= $lc[4].",";
								$titulos_oferente.=$lc[1].","; 
				
																			}
					}//si tiene evaluacion tecnica
					else{//si no tiene tecnica
								$cuenta_proveedores+=1;
								$resutado_pro.= $lc[4].",";
								$titulos_oferente.=$lc[1].","; 
						}//si no tiene tecnica
		
		}	

		$lista_oferentes = explode(",",$resutado_pro);
		$nombre_oferentes = explode(",",$titulos_oferente);
//-------------------------------------------------------------------------------------------------------------------------------
//ARREGLO PROVEEDORES ACEPTADOS
//-------------------------------------------------------------------------------------------------------------------------------



$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and  evaluador4_tipo  in ('Valor')");
	while($l_campo = traer_fila_row($busca_campos)){  
			$campo_imprime_solo_valor.=",".$l_campo[0];
			if($l_campo[3]=="Moneda") $busca_campos_moneda_lista=$l_campo[0];
  													} 
			$campo_imprime_solo_valor = "0".$campo_imprime_solo_valor;	


items_ganadores($nombre_campo,1,$campo_imprime_solo_valor, $sql_e[42], $busca_campos_moneda_lista);

$busca_mejor_oferta_consolidad="select sum(valor_total) as puntaje_final, pv_id from reporte_temp1_$us_cliente where pro1_id = $id_invitacion and tipo_valor = 2 group by pv_id order by puntaje_final desc";
$busca_mejor_oferta_consolidad_proveedor="select sum(valor_total) as puntaje_final from reporte_temp1_$us_cliente where pro1_id = $id_invitacion and tipo_valor = 2 and pv_id = $us_cliente";	
$mejor_oferta_total = traer_fila_row(query_db($busca_mejor_oferta_consolidad));
$mejor_oferta_personal = traer_fila_row(query_db($busca_mejor_oferta_consolidad_proveedor));


		if($mejor_oferta_total[1]==$us_cliente)
				$campo_campos_consolidado ="<td align='right' width='30%'><div align='right'><img src='../imagenes/botones/SemaforoVerde.gif' title='Usted tiene la mejor oferta consolidada'></div></td><td align='left'><div align='left'>Usted tiene la mejor oferta consolidada. Ultima vez que refresco la página:".fecha_for_hora($fecha." ".$hora)."</div></td>";
		else
			    $campo_campos_consolidado ="<td align='right' width='20%'><div align='right'><img src='../imagenes/botones/SemaforoRojo.gif' title='Usted NO tiene la mejor oferta consolidada, revise que todos los Items estan diligenciados'></div></td><td align='left'><div align='left'> Usted NO tiene la mejor oferta consolidada, revise que todos los Items esten diligenciados. Ultima vez que refresco la página:".fecha_for_hora($fecha." ".$hora)."</div></td>";

$tabla_semaforo_consolidado='<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco_oferente">
     <tr class="administrador_contenido_celdas">
      '.$campo_campos_consolidado.'
   </table>';
}//si tiene subasta consolidada activa

?>
<?=$tabla_semaforo_consolidado;?>
