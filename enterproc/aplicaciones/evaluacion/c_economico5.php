<?  include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=mysql_fetch_row(query_db($lista_licitaciones));

if($requeire_filtro_proveedores_tecnico_aceptados=="Si"){ //si requierre filtro 
$busca_proveedores_apectados = query_db("select * from $t13 where proc1_id = $id_invitacion");
while($lista_prove_apcet=traer_fila_row($busca_proveedores_apectados))
	{
		if($linvi[20]<=$lista_prove_apcet[5])
			$pv_id_acep_tecnico.=",".$lista_prove_apcet[2];
	
	}
	
	$filtro_provee_aceptados_tec = "and $t7.pv_id  in (0 ".$pv_id_acep_tecnico.")";
	
	} // si requierre filtro 

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">


</head>
<body >

<table width="900" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">Oferta total econ&oacute;mica detallada</td>
    <td width="17%"><div align="left">
      <input name="button3" type="button" class="cancelar" id="button3" value="Volver al menu de reportes" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_economica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">
    </div></td>
  </tr>
</table>
<? 

function items_ganadores($nombre_campo,$oferta_vista,$campo_valos,$trm, $busca_campos_moneda_lista_no)
	{
	global $lista_oferentes,$cuenta_proveedores,$id_invitacion,$tabla_economica,$t95,$tipo_busq, $t94;

    $busca_campos = query_db("select * from $t95 where in_id = $id_invitacion");
	while($l_campo = mysql_fetch_row($busca_campos)){ 
	$campo_campos=""; 
	
	$busca_campos_moneda_lista = mysql_fetch_row(query_db("select * from $t94 where pro11_id = $l_campo[9] and evaluador4_tipo = 'Moneda'"));

	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	$campo_campos="";
	$campo_campos2="";
	

		$busca_valores_ing=mysql_fetch_row(query_db("select sum(w_valor) from $tabla_economica  
		where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id in ($campo_valos) 
		and oferta = $oferta_vista"));	
	
	
					
					if($busca_valores_ing[0]!=""){//si el campo tiene valor
										

										if($l_campo[6]=="USD")
											$total_afectado= (($busca_valores_ing[0] * $l_campo[5] ) * $trm) ;
										elseif($l_campo[6]=="COP")
											$total_afectado= ($busca_valores_ing[0] * $l_campo[5] ) ;
										else{//si se solicita la cotizacion en MULTIMONEDA
													
													$busca_valores_moneda_proveedor=mysql_fetch_row(query_db("select w_valor from $tabla_economica  
													where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] 
													and evaluador4_id = $busca_campos_moneda_lista[0] and oferta = 1"));
													
													
														if($busca_valores_moneda_proveedor[0]=="COP")
															$total_afectado= ( $busca_valores_ing[0] * $l_campo[5] )  ;
				
														if($busca_valores_moneda_proveedor[0]=="USD")
															$total_afectado= (($busca_valores_ing[0] * $l_campo[5] ) * $trm) ;
				
														else
															$total_afectado= ( $busca_valores_ing[0] * $l_campo[5] )  ;
											
											
										} //si se solicita la cotizacion en MULTIMONEDA
											
										
										//$total_afectado=  $l_campo[5] ;										
										$inserta_temporal = "insert into reporte_temp values ('$lista_oferentes[$yy]', '$busca_valores_ing[0]','$oferta_vista', '$total_afectado', '$l_campo[9]')";
										$sql_str=query_db($inserta_temporal);

									}//si el campo tiene valor
		
							
		}//for
		
		}//while
	
	}// function


//-------------------------------------------------------------------------------------------------------------------------------
//ARREGLO PROVEEDORES ACEPTADOS
//-------------------------------------------------------------------------------------------------------------------------------
	 $cuenta_proveedores=0;
	$busca_vaor_tecnica = mysql_fetch_row(query_db("select * from $t93 where in_id = $id_invitacion and evaluador3_termino = 2"));
	 $busca_respo = query_db("select $t7.pro1_id, $t8.razon_social , $t8.nit , $t8.pv_id,$t8.pv_id from $t7,$t8 where $t7.pro1_id  = $id_invitacion and $t8.pv_id = $t7.pv_id $filtro_provee_aceptados_tec ");
		while($lc=mysql_fetch_row($busca_respo))
		{
	
		if($busca_vaor_tecnica[3]>=1)
				{//si tiene evaluacion tecnica
					$bus_his = mysql_fetch_row(query_db("select count($t98.evaluador7_valor), sum($t98.evaluador7_valor)  from $t98,$t91 where $t91.in_id = $id_invitacion 
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



//-------------------------------------------------------------------------------------------------------------------------------
//CAMPOS
//-------------------------------------------------------------------------------------------------------------------------------
	





  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and  evaluador4_tipo  in ('Valor')");
	while($l_campo = mysql_fetch_row($busca_campos)){  
			$campo_imprime_solo_valor.=",".$l_campo[0];
			if($l_campo[3]=="Moneda") $busca_campos_moneda_lista=$l_campo[0];
  													} 
			$campo_imprime_solo_valor = "0".$campo_imprime_solo_valor;													


	$tipo_busq = "min";
		$sql_tabla="CREATE TEMPORARY TABLE reporte_temp ( pv_id varchar(50) NOT NULL,
		valor varchar(50) NOT NULL,oferta varchar(50) NOT NULL,valor_total varchar(50) NOT NULL,  id_lista varchar(50) NOT NULL ) " ;
		$query_crea = query_db($sql_tabla);
													

	items_ganadores($nombre_campo,1,$campo_imprime_solo_valor, $linvi[42], $busca_campos_moneda_lista);

	$busca_lista= query_db("select * from $t19 where pro1_id = $id_invitacion");
	while($ls_t=mysql_fetch_row($busca_lista)){//busca listas





	$select_minimo_lista = mysql_fetch_row(query_db("select  sum(valor_total) as mejor  from reporte_temp where id_lista = $ls_t[0] group by pv_id order by mejor asc"));

	$select_formula = mysql_fetch_row(query_db("select * from pro10_formulas where pro1_id = $id_invitacion and pro11_id = $ls_t[0] and tipo_formula = 2"));
	$formula_aplicada = $select_formula[2];
	if($formula_aplicada!="")
		{
			$agrupa_titu = 3;
		}	
	else
		
		{
			$agrupa_titu = 2;
		}	



?>

<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr  class="administrador_tabla_titulo">
    <td colspan="<?=$agrupa_titu;?>" class="columna_titulo_resultados"><?=$ls_t[2];?></td>
  </tr>
  <tr  class="administrador_tabla_titulo">
    <td width="46%" class="columna_titulo_resultados"><div align="center">Oferente</div></td>
    <td width="27%" class="columna_titulo_resultados"><div align="center">Valor Total</div></td>
   <? 	if($formula_aplicada!=""){ ?>
    <td width="27%" class="columna_titulo_resultados"><div align="center"><?=$select_formula[3];?></div></td>
    <? } ?>
  </tr>

<?


	$cuenta_nu_articulos = mysql_fetch_row(query_db("select count(*) from $t95 where in_id = $linvi[0] and pro11_id = $ls_t[0] "));
	$nombre_ofer = explode(",",$titulos_oferente);
	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	$busca_nu_ofertas = query_db("select distinct oferta from $tabla_economica where  pv_id = $lista_oferentes[$yy]  ");

	$reemplaza_valores="";
	$cuenta_pasada_para_formula=0;// cuenta para reemplazar formula
	while($rr=mysql_fetch_row($busca_nu_ofertas)){//ofertas

	$select = mysql_fetch_row(query_db("select count(*), sum(valor_total) from reporte_temp where pv_id = '$lista_oferentes[$yy]' and oferta = '$rr[0]' and id_lista = $ls_t[0]"));

	$porcentaje_2 = ($select[0]/$cuenta_nu_articulos[0]) * 100;
	
		if($cuenta_pasada_para_formula==0){//si es la primera pasada
		  $reemplaza_valores = str_replace("min",$select_minimo_lista[0],$formula_aplicada);
		   $reemplaza_valores = str_replace("total",$select[1],$reemplaza_valores);			  
		}//si es la primera pasada

		else{//si es la segunda pasada
		  $reemplaza_valores = str_replace("min",$select_minimo_lista[0],$reemplaza_valores);
		   $reemplaza_valores = str_replace("total",$select[1],$reemplaza_valores);			  
		}//si es la segunda pasada
			

		$busca_resultado_sql = mysql_fetch_row(query_db("select $reemplaza_valores "));
		
		
		$cuenta_pasada_para_formula=0;// cuenta para reemplazar formula

?>  

  <tr   onMouseOver=this.className="tabla_menu_relover"; onMouseOut=this.className="";>
    <td><?=$nombre_ofer[$yy];?></td>
    <td align="right"><?=number_format($select[1],0);?></td>
    <? 	if($formula_aplicada!=""){ ?>
    <td align="center"><?=number_format($busca_resultado_sql[0],2);?></td>
    <? } ?>
  </tr>
  
  <? 
  	} //ofertas 

    
   
   } // for oferentes
   
   ?>
</table>
<br>
<?
	} //busca listas





?>

<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr  class="administrador_tabla_titulo">
    <td colspan="<?=$agrupa_titu;?>" class="columna_titulo_resultados"><?=$ls_t[2];?></td>
  </tr>
  <tr  class="administrador_tabla_titulo">
    <td width="46%" class="columna_titulo_resultados"><div align="center">Oferente</div></td>
    <td width="27%" class="columna_titulo_resultados"><div align="center">Valor Total</div></td>
   <? 	if($formula_aplicada!=""){ ?>
    <td width="27%" class="columna_titulo_resultados"><div align="center"><?=$select_formula[3];?></div></td>
    <? } ?>
  </tr>

<?



	$nombre_ofer = explode(",",$titulos_oferente);
	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	$suma_valor_total=0;
	$suma_formula=0;

	
	$busca_lista= query_db("select * from $t19 where pro1_id = $id_invitacion");
	while($ls_t=mysql_fetch_row($busca_lista)){//busca listas


	$select_minimo_lista = mysql_fetch_row(query_db("select  sum(valor_total) as mejor  from reporte_temp where id_lista = $ls_t[0] group by pv_id order by mejor asc"));

	$select_formula = mysql_fetch_row(query_db("select * from pro10_formulas where pro1_id = $id_invitacion and pro11_id = $ls_t[0] and tipo_formula = 2"));
	$formula_aplicada = $select_formula[2];
	if($formula_aplicada!="")
		{
			$agrupa_titu = 3;
		}	
	else
		
		{
			$agrupa_titu = 2;
		}	
	


	$reemplaza_valores="";
	$cuenta_pasada_para_formula=0;// cuenta para reemplazar formula


	$select = mysql_fetch_row(query_db("select count(*), sum(valor_total) from reporte_temp where pv_id = '$lista_oferentes[$yy]'  and id_lista = $ls_t[0]"));


	
		if($cuenta_pasada_para_formula==0){//si es la primera pasada
		  $reemplaza_valores = str_replace("min",$select_minimo_lista[0],$formula_aplicada);
		   $reemplaza_valores = str_replace("total",$select[1],$reemplaza_valores);			  
		}//si es la primera pasada

		else{//si es la segunda pasada
		  $reemplaza_valores = str_replace("min",$select_minimo_lista[0],$reemplaza_valores);
		   $reemplaza_valores = str_replace("total",$select[1],$reemplaza_valores);			  
		}//si es la segunda pasada
			

		$busca_resultado_sql = mysql_fetch_row(query_db("select $reemplaza_valores "));
		
		
		$cuenta_pasada_para_formula=0;// cuenta para reemplazar formula

		$suma_valor_total+=$select[1];
		$suma_formula+=$busca_resultado_sql[0];
} //busca listas 
?>  

  <tr   onMouseOver=this.className="tabla_menu_relover"; onMouseOut=this.className="";>
    <td><?=$nombre_ofer[$yy];?></td>
    <td align="right"><?=number_format($suma_valor_total,0);?></td>
    <? 	if($formula_aplicada!=""){ ?>
    <td align="center"><?=number_format($suma_formula,2);?></td>
    <? } ?>
  </tr>
  
  <? 
		   
   
   } // for oferentes
   
   ?>
</table>
<br>




</body>
</html>
