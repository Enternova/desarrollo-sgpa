<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));


$busca_campos_moneda = traer_fila_row(query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  = 'Moneda' and pro11_id = $id_lista"));   


$numero_pagi = 200;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);

		  $li_n_c=traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista "));
		  $total_r = $li_n_c[0];
		  $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
	$proxima = $pag;
else
	$proxima = $pag +1;
	
if($pag==1)
	$anterior = $pag;
else
	$anterior = $pag -1;   

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">


<script>



function paginacion_lista(pagi)
	{
	var forma = document.formulario
			forma.target="";
			forma.action = "c_economico.php";
			forma.pag.value = pagi;
			forma.submit();
	
	}


</script>

</head>
<body >
   <p>

   </p>
   <p>&nbsp; </p>
   
 <br>
      <table width="95%" border="0" cellspacing="2" cellpadding="2">
     <tr>
   	<?
		$busca_listas_creadas = "select * from $t19 where pro1_id = $id_invitacion";
		$sql_listas = query_db($busca_listas_creadas);
		while($ex_listas = traer_fila_row($sql_listas)){ ?>
       <td ><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=<?=$campo_valos;?>&tipo_busq=min&id_lista=<?=$ex_listas[0];?>','carga_evaluacion')"><?=$ex_listas[2];?></a></td>
       <? } ?>
    
     </tr>
   </table>
    <? if($id_lista!=0){ //si tiene listas creadas
	/********************************************************************************************/
	/*CREA TABLA TEMPORAL*/	
	/********************************************************************************************/
	$sql_tabla="CREATE TABLE reporte_temp (";
//	$sql_tabla="CREATE TEMPORARY TABLE reporte_temp (";
	$sql_tabla.="pro1_id varchar(50) NOT NULL, id_lista varchar(50) NOT NULL, pv_id varchar(50) NOT NULL,";
	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista order by evaluador4_id");
	while($l_campo = traer_fila_row($busca_campos)){  //WHILE CAMPOS TABLA
	if($l_campo[3]=="Valor")
		$sql_tabla.="v_original_$l_campo[0] varchar(50) NOT NULL, v_trm_$l_campo[0] varchar(50) NOT NULL, v_cantidad_$l_campo[0] varchar(50) NOT NULL, ";
	else
		$sql_tabla.="c_original_$l_campo[0] text NOT NULL,  ";	
	
	if($l_campo[3]=="Moneda") $busca_campos_moneda_lista=$l_campo[0];
				}//WHILE CAMPOS TABLA
		$sql_tabla.=" lista varchar(50) NOT NULL )  ";				
		//$query_crea = query_db($sql_tabla);		
	/********************************************************************************************/
	/*CREA TABLA TEMPORAL*/	
	/********************************************************************************************/

	/********************************************************************************************/
	/*llena TABLA TEMPORAL*/	
	/********************************************************************************************/

		/********************************************************************************************/
		/*BUSCA PROVEEDORES*/	
		/********************************************************************************************/
	
	
		$busca_respo = query_db("select $t7.pro1_id, $t8.razon_social , $t8.nit , $t8.pv_id,$t8.pv_id from $t7,$t8 where $t7.pro1_id  = $id_invitacion and $t8.pv_id = $t7.pv_id ");
			while($lc=traer_fila_row($busca_respo)){
						$resutado_proveedores.= $lc[4].",";
						$cuenta_proveedores_invitados+=1;
						
						}
						$lista_oferentes_invitados = explode(",",$resutado_proveedores);
						//$lista_oferentes_nombre = explode(",",$resutado_pro_nombre);		


		/********************************************************************************************/
		/*BUSCA PROVEEDORES*/	
		/********************************************************************************************/
	
//	$busca_valores_moneda_proveedor=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $busca_campos_moneda[0] and oferta = 1"));
	$busca_lista_articulos = query_db("select * from $t95 where in_id = $id_invitacion  and pro11_id = $id_lista ");
	while($l_articulos = traer_fila_row($busca_lista_articulos)){ //BUSCA ARTICULOS
			for($pr_in=0;$pr_in<$cuenta_proveedores_invitados;$pr_in++){//for oferentes por cada oferrente ingresa un articulo
			
				$inserta_articulos = query_db("insert into reporte_temp (pro1_id, id_lista, pv_id, lista) values ('$id_invitacion', '$l_articulos[0]', '$lista_oferentes_invitados[$pr_in]' , '$id_lista' )");

					$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista order by evaluador4_id");
					while($lista_campos = traer_fila_row($busca_campos)){  //WHILE CAMPOS TABLA
						$busca_valores_ofertado=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes_invitados[$pr_in] and evaluador5_id  = $l_articulos[0] and evaluador4_id = $lista_campos[0] and oferta = 1"));

						if( ($lista_campos[3]=="Valor") && ($busca_valores_ofertado!="") ){//si el campo es valor
							if($l_articulos[6]=="USD"){//si se solicita la cotizacion en USD
								$update_tem = "update reporte_temp set v_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = ( $busca_valores_ofertado[0] * $linvi[42] ), v_cantidad_$lista_campos[0] = ( ( $busca_valores_ofertado[0] * $linvi[42] ) * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
							} //si se solicita la cotizacion en USD

							elseif($l_articulos[6]=="COP"){//si se solicita la cotizacion en COP
								$update_tem = "update reporte_temp set v_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = '$busca_valores_ofertado[0]', v_cantidad_$lista_campos[0] = (  $busca_valores_ofertado[0] * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
							} //si se solicita la cotizacion en COP

							else{//si se solicita la cotizacion en MULTIMONEDA
									$busca_valores_moneda_proveedor=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes_invitados[$pr_in] and evaluador5_id  = $l_articulos[0] and evaluador4_id = $busca_campos_moneda_lista and oferta = 1"));
										if($busca_valores_moneda_proveedor[0]=="COP")
											$update_tem = "update reporte_temp set v_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = '$busca_valores_ofertado[0]', v_cantidad_$lista_campos[0] = (  $busca_valores_ofertado[0] * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";

										if($busca_valores_moneda_proveedor[0]=="USD")
											$update_tem = "update reporte_temp set v_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = ( $busca_valores_ofertado[0] * $linvi[42] ), v_cantidad_$lista_campos[0] = ( ( $busca_valores_ofertado[0] * $linvi[42] ) * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";

										else
											$update_tem = "update reporte_temp set v_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = '$busca_valores_ofertado[0]', v_cantidad_$lista_campos[0] = (  $busca_valores_ofertado[0] * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
											
							} //si se solicita la cotizacion en MULTIMONEDA

							$sql_ex_ingresa_valores = query_db($update_tem);
								
						}//si el campo es valor
						else
							{//para el resto de campos que no son valores
							
								$update_tem = "update reporte_temp set c_original_$lista_campos[0] = '$busca_valores_ofertado[0]' where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
								$sql_ex_ingresa_valores = query_db($update_tem);
								
							}//para el resto de campos que no son valores
					
					} //WHILE CAMPOS TABLA
			
				
			
			}//for oferentes por cada oferrente ingresa un articulo

	}//BUSCA ARTICULOS

	/********************************************************************************************/
	/*llena TABLA TEMPORAL*/	
	/********************************************************************************************/


	 if($tipo_busq=="")
         	$tipo_busq = "min";
	 /********************formulas aplicadas********************/
				
		$select_formula = traer_fila_row(query_db("select * from pro10_formulas where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula = 1"));
		$formula_aplicada = $select_formula[2];
		
		/********************formulas aplicadas********************/
	$cuenta_proveedores=0;
	$busca_vaor_tecnica = traer_fila_row(query_db("select * from $t93 where in_id = $id_invitacion and evaluador3_termino = 2"));

	$busca_respo = query_db("select $t7.pro1_id, $t8.razon_social , $t8.nit , $t8.pv_id,$t8.pv_id from $t7,$t8 where $t7.pro1_id  = $id_invitacion and $t8.pv_id = $t7.pv_id ");
		while($lc=traer_fila_row($busca_respo)){
		if($busca_vaor_tecnica[3]>=1)
				{//si tiene evaluacion tecnica
	$numero=0;
	$numero_columna_formula=0;

					}//si tiene evaluacion tecnica
					else{//si no tiene tecnica

								if($num_columna_titulo%2==0){
										$class_tc="campos_blancos_listas_evaluador_titulos_campos";
										$class_tp="columna_titulo_resultados_evaluador_titulo_proveedor";
										
										}
									else{
										$class_tc="columna_subtitulo_resultados_economico";
										$class_tp="columna_titulo_resultados_evaluador";
										}
							
									$numero=0;
									$numero_columna_formula=0;
									$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
									while($l_campo = traer_fila_row($busca_campos)){  
									$titulo_campos.="<td  class='".$class_tc."'><strong>".$l_campo[2]."</strong></td>";
									$numero++;
								
										} 									
										
									$num_columna_titulo++;
									
									$titulo_campos.="<td class='".$class_tc."'><strong>Total</strong></td>";	
									$titulo_campos.="<td class='".$class_tc."'><strong>Mejor Oferta</strong></td>";		
									if($formula_aplicada[0]!=""){//verifica si tiene formula y crea el campo
										$numero_columna_formula=1;
										$titulo_campos.="<td class='".$class_tc."'><strong>".$select_formula[3]."</strong></td>";
									} //verifica si tiene formula y crea el campo											
									
									$cuenta_proveedores+=1;
									$resutado_pro.= $lc[4].",";
									$resutado_pro_nombre.= $lc[1].",";
									$titulos_oferente.="<td colspan=".($numero + 2 + $numero_columna_formula)." class='".$class_tp."'>".$lc[1]."</td>"; 
									$cuenta_campos_detalle_item = $numero + 2 + $numero_columna_formula;			
																			}
																			
		
		}	
		
		
		$lista_oferentes = explode(",",$resutado_pro);
		$lista_oferentes_nombre = explode(",",$resutado_pro_nombre);		
		
		$concatena_titulo = ($numero+5);
													?>   
   
   
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco_oferente">
     <tr>
       <td colspan="5"><strong><img src="../librerias/jquery/menu1/help.gif" width="18" height="18">AYUDA:</strong>Seleccione de la siguiente lista la condicion econ&oacute;mica con la cual desea que el sistema le indique la mejor oferta por oferente:</td>
     </tr>
     <tr class="administrador_tabla_titulo">
       <td width="44%"><div align="right"><strong>Seleccione la condici&oacute;n econ&oacute;mica:</strong></div></td>
       <td width="6%"><label>
         <select name="campo_valos" id="select" >
      <?

		 $busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  in ('Valor', 'Numerico') and pro11_id = $id_lista");
			while($l_campo_trae = traer_fila_row($busca_campos_1)){	
			if($campo_valos==$l_campo_trae[0]) $c_sel = "selected"; else $c_sel="";
			 ?>
            <option value='<?=$l_campo_trae[0];?>' <?=$c_sel;?>><?=$l_campo_trae[2];?></option>
            <? } ?>
         </select>
         
         
          
       </label></td>
       <td width="18%"><div align="right"><strong>Parametro de selecci&oacute;n:</strong></div></td>
       <td width="14%"><select name="tipo_busq" id="tipo_busq" >
         <option value='min' <? if($tipo_busq=="min")  echo "selected";?>>Minimo Valor</option>
         <option value='max' <? if($tipo_busq=="max") echo "selected";?>>Maximo Valor</option>
       </select></td>
       <td width="18%"><label>
         <input name="button" type="button" class="buttonverde" id="button" value="Generar Agrupamiento" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=' + document.principal.campo_valos.value + '&tipo_busq=' + document.principal.tipo_busq.value + '&id_lista=<?=$id_lista;?>','carga_evaluacion')">
       </label></td>
     </tr>
   </table>
  
   
   <br>
   <table  border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
     <tr>
       
       <td  colspan="6" class="columna_titulo_resultados_evaluador">TERMINOS ECONOMICOS</td>
       <td  class="columna_titulo_resultados_evaluador">CONSOLIDADO</td>
	   <?=$titulos_oferente;?>
     </tr>
     <tr class='columna_subtitulo_resultados'>
       <td width="1%" class="columna_subtitulo_resultados_economico">&nbsp;</td>

       <td width="1%" class="columna_subtitulo_resultados_economico"><strong>Codigo</strong></td>
       <td width="30%" class="columna_subtitulo_resultados_economico"><strong>detalle</strong></td>
       <td width="2%" class="columna_subtitulo_resultados_economico"><strong>Medida</strong></td>
       <td width="2%" class="columna_subtitulo_resultados_economico"><strong>Cantidad</strong></td>
       <td width="2%" class="columna_subtitulo_resultados_economico"><strong>Moneda</strong></td>

       <td width="2%" class="columna_subtitulo_resultados_economico"><strong>Mejor oferente</strong></td>
	
		<?=$titulo_campos;?>
     </tr>
     <?



  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion  and pro11_id = $id_lista ");
	while($l_campo = traer_fila_row($busca_campos)){ 
	$campo_campos=""; 
	$reemplaza_valores="";
	$campo_campos_consolodado="<td class='divicion_tablas' width='1%'><strong>&nbsp;</strong></td>";
	
 	$busca_ganador=traer_fila_row(query_db("select $tipo_busq(w_valor * 1) from $tabla_economica 
	 where  w_valor>=1 and evaluador5_id  = $l_campo[0] and evaluador4_id = $campo_valos and oferta = 1  group by evaluador5_id "));
	
	$campo_formateado=str_replace("id_articulo",$l_campo[0],$campo_campos);
	
	if($select_formula[4]>=1){
	 	$minimo_formula=traer_fila_row(query_db("select min(w_valor * 1) from $tabla_economica 
	 where  w_valor>=1 and evaluador5_id  = $l_campo[0] and evaluador4_id = $select_formula[4] and oferta = 1  group by evaluador5_id "));
	 echo "select min(w_valor * 1) from $tabla_economica 
	 where  w_valor>=1 and evaluador5_id  = $l_campo[0] and evaluador4_id = $select_formula[4] and oferta = 1  group by evaluador5_id ";
	 }

	if($select_formula[5]>=1)
	 	$maximo_formula=traer_fila_row(query_db("select min(w_valor * 1) from $tabla_economica 
	 where  w_valor>=1 and evaluador5_id  = $l_campo[0] and evaluador4_id = $select_formula[4] and oferta = 1  group by evaluador5_id "));

	
	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	
	  	if($num_columna%2==0)
				$class="campos_blancos_listas_evaluador";
			else
				$class="divicion_tablas";
	$multiplica_cantidad="&nbsp;"; 				
	$campo_campos2="<td class='".$class."' width='1%'><strong><div class='oferta_perdedora'>NO</div></strong></td>";
	$busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	$cuenta_pasada_para_formula=0;// cuenta para reemplazar formula
	$reemplaza_valores=$formula_aplicada;
	while($l_campo_trae = traer_fila_row($busca_campos_1)){
	


	$busca_valores_ing=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $l_campo_trae[0] and oferta = 1"));
	$busca_valores_moneda_proveedor=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $busca_campos_moneda[0] and oferta = 1"));
		

		if($l_campo[6]=="COP") {// si en la lista ponen moneda cop
			$resultado_minimo_formula=$minimo_formula[0];
			$resultado_maximo_formula=$maximo_formula[0];
			$resultado_valor_ingresado=$busca_valores_ing[0];
			}
		elseif($l_campo[6]=="USD") {// si en la lista ponen moneda usd
			$resultado_minimo_formula=($minimo_formula[0]*$linvi[42]);
			$resultado_maximo_formula=($maximo_formula[0]*$linvi[42]);	
			$resultado_valor_ingresado=($busca_valores_ing[0]*$linvi[42]);	
					
			}
		elseif( $busca_valores_moneda_proveedor[0]=="COP") { // si en la lista ponen moneda multimoneda y el provvedor poen cop
			$resultado_minimo_formula=$minimo_formula[0];
			$resultado_maximo_formula=$maximo_formula[0];	
			$resultado_valor_ingresado=$busca_valores_ing[0];
					
			}
		elseif( $busca_valores_moneda_proveedor[0]=="USD") { // si en la lista ponen moneda multimoneda y el provvedor poen usd
			$resultado_minimo_formula=($minimo_formula[0]*$linvi[42]);
			$resultado_maximo_formula=($maximo_formula[0]*$linvi[42]);	
			$resultado_valor_ingresado=($busca_valores_ing[0]*$linvi[42]);						
			}
		else{
			$resultado_minimo_formula=$minimo_formula[0];
			$resultado_maximo_formula=$maximo_formula[0];		
			$resultado_valor_ingresado=$busca_valores_ing[0];
				
			}


	if($busca_valores_ing[0]!=""){ //si el valor ingresado por elproveedor esta lleno
		
		
		if($cuenta_pasada_para_formula==0){//si es la primera pasada
		  $reemplaza_valores = str_replace("min(b".$l_campo_trae[0].")",$resultado_minimo_formula,$formula_aplicada);
		  $reemplaza_valores = str_replace("max(b".$l_campo_trae[0].")",$resultado_maximo_formula,$reemplaza_valores);	
		   $reemplaza_valores = str_replace("b".$l_campo_trae[0],$resultado_valor_ingresado,$reemplaza_valores);			  


		}//si es la primera pasada
		else{//si es la segunda pasada
		  $reemplaza_valores = str_replace("min(b".$l_campo_trae[0].")",$resultado_minimo_formula,$reemplaza_valores);
		  $reemplaza_valores = str_replace("max(b".$l_campo_trae[0].")",$resultado_maximo_formula,$reemplaza_valores);				  
		  $reemplaza_valores = str_replace("b".$l_campo_trae[0],$resultado_valor_ingresado,$reemplaza_valores);
		}//si es la segunda pasada
		
		
			if($l_campo_trae[0]==$campo_valos)
				{
					
					$campo_campos.="<td class='".$class."'>".number_format($busca_valores_ing[0],2)."</td>";
					
					if($busca_valores_moneda_proveedor[0]=="COP")
					$multiplica_cantidad=number_format(($busca_valores_ing[0]*$l_campo[5]),2);
					else
					$multiplica_cantidad=number_format( ( ($busca_valores_ing[0]* $linvi[42]) *$l_campo[5] ),2);
					

					
					if(($busca_valores_ing[0]==$busca_ganador[0]) && ($busca_valores_ing[0]>=1)){
						$campo_campos2="<td class='".$class."' width='1%'><strong><div class='oferta_ganadora'>SI</div> </strong></td>";

						$nobre_proveedor_gan = $lista_oferentes_nombre[$yy];
						$campo_campos_consolodado="<td class='divicion_tablas' width='1%'><strong>".$nobre_proveedor_gan."</strong></td>";
						
						}
					else
						$campo_campos2="<td class='".$class."' width='1%'><strong><div class='oferta_perdedora'>NO</div> </strong></td>";
				}//si entra al campo seleccionado para el mejor valor
			else
				$campo_campos.="<td class='".$class."'>$busca_valores_ing[0]</td>";

		$sin_valor=1;
		} //si el valor ingresado por elproveedor esta lleno
		
		
		else{
		$campo_campos.="<td class='".$class."'>&nbsp;</td>";
		$sin_valor=0;
		}
		$cuenta_pasada_para_formula++;// cuenta para reemplazar formula
		}//while de los campos
		
		


		$busca_resultado_sql = traer_fila_row(query_db("select $reemplaza_valores "));
		
		echo $busca_resultado_sql[0]." - select $reemplaza_valores <br>";

		if($l_campo[6]=="COP") 
			$resultado_formula_final=number_format($busca_resultado_sql[0],0);
		elseif($l_campo[6]=="USD") 
			$resultado_formula_final=number_format($busca_resultado_sql[0] ,2);
		elseif( $busca_valores_moneda_proveedor[0]=="COP") 
			$resultado_formula_final=number_format($busca_resultado_sql[0],0);
		elseif( $busca_valores_moneda_proveedor[0]=="USD") 
			$resultado_formula_final=number_format($busca_resultado_sql[0] ,2);
		else
			$resultado_formula_final=number_format($busca_resultado_sql[0],0);
		
		
		
		 
		 

		$campo_campos.="<td class='".$class."' width='1%'><strong>".$multiplica_cantidad."</strong></td>";
		$campo_campos.=$campo_campos2;
		
		if($formula_aplicada[0]!=""){//verifica si tiene formula y crea el campo
		
		$campo_campos.="<td class='".$class."' width='1%'><strong>".$resultado_formula_final."</strong></td>";
		} //verifica si tiene formula y crea el campo
		
		$num_columna++;
	}//for oferentes


	?>

		<tr onMouseOver=this.className="tabla_menu_relover"; onMouseOut=this.className="";>
		  <td class='divicion_tablas'><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_item_ofertas.php?evaluador5_id=<?=$l_campo[0];?>&evaluador4_id=<?=$campo_valos;?>','detalle_item_2');ingresar_listado('detalle_item')"><img src="../imagenes/botones/b_guardar.gif" width="16" height="16" id="item_<?=$l_campo[0];?>_imagen"></a></td>     


       <td class='divicion_tablas'><?=$l_campo[2];?></td>
       <td class='divicion_tablas'><?=$l_campo[3];?></td>
       <td class='divicion_tablas'><?=$l_campo[4];?></td>
       <td class='divicion_tablas'><?=$l_campo[5];?></td>
       <td class='divicion_tablas'><?=$l_campo[6];?></td>
       <?=$campo_campos_consolodado;?>

		<?=$campo_campos;?>
        <?
			$total_colopsa = ( ($cuenta_campos_detalle_item*$cuenta_proveedores) + 7 );
		?>
     </tr>
		<tr>
		
		  <td id="item_<?=$l_campo[0];?>"  colspan="<?=$total_colopsa;?>"></td>
     </tr>
     <? $num_fila++;} ?>
   </table>

<table width="98%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><label>
          <div align="center">
            <input name="button2" type="button" class="guardar" id="button2" value="Exportar reporte a excel" onClick="window.parent.location.href='../aplicaciones/evaluacion/exporta_c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=<?=$campo_valos;?>&tipo_busq=min'">
            </div>
        </label></td>
      </tr>
    </table>
     <? } //si tiene listas creadas?>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
   <input type="hidden" name="pag" value="<?=$pag;?>">
<input type="hidden" name="oculta_muestra">
</body>
</html>
