<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	set_time_limit (0);





 if($id_lista==""){ // SI TIENE SOLO  UNA LISTA LA MUESTRA DIRECTA
		 $busca_listas_sola = "select * from $t19 where pro1_id = $id_invitacion";
		$sql_listas_sola = traer_fila_row(query_db($busca_listas_sola));
 		$id_lista = $sql_listas_sola[0];
		}

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));


if($requeire_filtro_proveedores_tecnico_aceptados=="Si"){ //si requierre filtro 
$busca_proveedores_apectados = query_db("select * from $t13 where proc1_id = $id_invitacion");
while($lista_prove_apcet=traer_fila_row($busca_proveedores_apectados))
	{
		if($linvi[20]<=$lista_prove_apcet[5])
			$pv_id_acep_tecnico.=",".$lista_prove_apcet[2];
	
	}
	
	$filtro_provee_aceptados_tec = "and $t7.pv_id  in (0 ".$pv_id_acep_tecnico.")";
	
	} // si requierre filtro 

$busca_campos_moneda = traer_fila_row(query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  = 'Moneda' and pro11_id = $id_lista"));   


$numero_pagi = 10;
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



	$nombre_lista1="Codigo";
	$nombre_lista2="Detalle";
	$nombre_lista3="Medida";
	$nombre_lista4="Cantidad";
	$nombre_lista5="Moneda";
	$nombre_lista6="Numero de parte";
	$nombre_lista7="Marca";
	$muestra_cantidad=1;

if($id_invitacion==1){

	$nombre_lista1="Tipo Vehiulo";
	$nombre_lista2="Tipo";
	$nombre_lista3="Capacidad en Toneladas";
	$nombre_lista4="Id";
	$nombre_lista6="Altura hasta Metros";
	$nombre_lista7="&nbsp;";
	$muestra_cantidad=2;

}


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

   	<table width="900" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="83%" class="titulos_evaluacion">Oferta total econ&oacute;mica detallada</td>
        <td width="17%"><div align="left">
            <input name="button3" type="button" class="cancelar" id="button3" value="Volver al menu de reportes" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_economica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">
        </div></td>
      </tr>
    </table>
   	<p>
   	  <?
		$busca_cantidad_listas = "select count(*) from $t19 where pro1_id = $id_invitacion";
		$sql_no_listas = traer_fila_row(query_db($busca_cantidad_listas));

		if($sql_no_listas[0]>=2){// SI TIENE MAS DE UNA LISTA LA MUESTRA DIRECTA

		if($id_lista>=1){
		$busca_listas_creadas = "select * from $t19 where pro11_id = $id_lista";
		$sql_listas = traer_fila_row(query_db($busca_listas_creadas));
		
		$titulo_lista="Usted esta evaluando la lista:<br>".$sql_listas[2];
		}
		else
			$titulo_lista="Por favor seleccione una lista para evaluar";
		
		 ?>
   	  
    </p>
<table width="950" border="0" cellpadding="2" cellspacing="2">
<tr>
        <td width="58%" valign="top" class="titulo_tabla_azul_sin_bordes">Lista seleccionada</td>
        <td width="42%" class="titulo_tabla_azul_sin_bordes">Listas creadas</td>
      </tr>
      <tr>
        <td valign="top"><div align="center"><?=$titulo_lista;?></div></td>
        <td><table width="95%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="87%">
              <select name="listas" onChange="ajax_carga(this.value,'carga_resultados_principales')">
                  <option value="../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&tipo_busq=min&id_lista=<?=$ex_listas[0];?>">Seleccione una lista</option>
                  <?
					$busca_listas_creadas = "select * from $t19 where pro1_id = $id_invitacion";
					$sql_listas = query_db($busca_listas_creadas);
					while($ex_listas = traer_fila_row($sql_listas)){ 
					
					 $busca_campos_1 = traer_fila_row(query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  in ('Valor') and pro11_id = $ex_listas[0]"));
				?>
                  <option value="../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&tipo_busq=min&id_lista=<?=$ex_listas[0];?>&campo_valos=<?=$busca_campos_1[0];?>">
                    <?=$ex_listas[2];?>
                </option>
                  <? } ?>
                </select>              </td>
            </tr>
        </table></td>
      </tr>
    </table>
<br>
      <? 
	  
	  } // SI TIENE MAS DE UNA LISTA LA MUESTRA DIRECTA

 else{ // SI TIENE SOLO  UNA LISTA LA MUESTRA DIRECTA
		 $busca_listas_sola = "select * from $t19 where pro1_id = $id_invitacion";
		$sql_listas_sola = traer_fila_row(query_db($busca_listas_sola));
 		$id_lista = $sql_listas_sola[0];
		}
 	
	  
	  if($id_lista!=0){ //si tiene listas creadas

	$busca_listas_creadas_aui = traer_fila_row(query_db("select * from $t19 where pro11_id = $id_lista"));
	$muestra_aui=$busca_listas_creadas_aui[3];



	if($campo_valos==""){//busca el cpo de evaluacion por dafual
	  $busca_campos_evaluar = traer_fila_row(query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  in ('Valor') and pro11_id = $id_lista "));
	  $campo_valos=$busca_campos_evaluar[0];
	  }
	else $campo_valos=$campo_valos;
	
	/********************************************************************************************/
	/*CREA TABLA TEMPORAL*/	
	/********************************************************************************************/
	//$sql_tabla="CREATE TABLE reporte_temp (";
	$sql_tabla="CREATE TEMPORARY TABLE reporte_temp (";
	$sql_tabla.="pro1_id varchar(50) NULL, id_lista varchar(50)  NULL, pv_id varchar(50)  NULL,";
	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista order by evaluador4_id");
	while($l_campo = mysql_fetch_row($busca_campos)){  //WHILE CAMPOS TABLA
	if($l_campo[3]=="Valor")
		$sql_tabla.="c_original_$l_campo[0] varchar(50) NULL, v_trm_$l_campo[0] varchar(50)  NULL, v_cantidad_$l_campo[0] varchar(50)  NULL, ";
	else
		$sql_tabla.="c_original_$l_campo[0] text  NULL,  ";	
	
	if($l_campo[3]=="Moneda") $busca_campos_moneda_lista=$l_campo[0];
	
	
	
				}//WHILE CAMPOS TABLA
		 $sql_tabla.=" lista varchar(50)  NULL, item_ganador varchar(50)  NULL, pv_nombre text  NULL )  ";				
		$query_crea = query_db($sql_tabla);	
		
$sql_tabla="CREATE TEMPORARY TABLE reporte_temp_11 ( pv_id text  NULL,
		valor_unitario varchar(50)  NULL,valor_total varchar(50) NULL, numero_ganadores varchar(50) NULL,valior_ganafores varchar(50) NULL ) " ;
		$query_crea = query_db($sql_tabla);
			
	/********************************************************************************************/
	/*CREA TABLA TEMPORAL*/	
	/********************************************************************************************/

	/********************************************************************************************/
	/*llena TABLA TEMPORAL*/	
	/********************************************************************************************/

	 /********************formulas aplicadas********************/
		$select_formula = mysql_fetch_row(query_db("select * from pro10_formulas where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula = 1"));
		$formula_aplicada = $select_formula[2];
		/********************formulas aplicadas********************/


		/********************************************************************************************/
		/*BUSCA PROVEEDORES*/	
		/********************************************************************************************/
	
		$numero_columna_formula=0;
				$numero=0;

				
		$busca_respo = query_db("select $t7.pro1_id, $t8.razon_social , $t8.nit , $t8.pv_id,$t8.pv_id from $t7,$t8 where $t7.pro1_id  = $id_invitacion and $t8.pv_id = $t7.pv_id $filtro_provee_aceptados_tec");
			while($lc=mysql_fetch_row($busca_respo)){
				
						$resutado_proveedores.= $lc[4].",";
						$cuenta_proveedores_invitados+=1;
						$cuenta_proveedores+=1;
						$resutado_pro_nombre.= $lc[1].",";
				
						
						//ESTILOS PARA LA COLUMNA DE PROVEEDORES
							if($num_columna_titulo%2==0){
										$class_tc="campos_blancos_listas_evaluador_titulos_campos";
										$class_tp="columna_titulo_resultados_evaluador_titulo_proveedor";
										
										}
									else{
										$class_tc="columna_subtitulo_resultados_economico";
										$class_tp="columna_titulo_resultados_evaluador";
										}
					  //ESTILOS PARA LA COLUMNA DE PROVEEDORES
					  
						  
						  	// COLUMNA DE CAMPOS
								$numero=0;	
									$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista  order by evaluador4_id");
									while($l_campo = mysql_fetch_row($busca_campos)){  
									$titulo_campos.="<th  class='".$class_tc."'><strong>".$l_campo[2]."</strong></th>";
									$numero++;
								
										} 
							// COLUMNA DE CAMPOS
							
							// COLUMNA DE CAMPOS RESTO		
						 
									$titulo_campos.="<th class='".$class_tc."'><strong>Total</strong></th>";	
									$titulo_campos.="<th class='".$class_tc."'><strong>Mejor Oferta</strong></th>";		
									if($formula_aplicada[0]!=""){//verifica si tiene formula y crea el campo
										$numero_columna_formula=1;
										$titulo_campos.="<th class='".$class_tc."'><strong>".$select_formula[3]."</strong></th>";
									} //verifica si tiene formula y crea el campo											
						  // COLUMNA DE CAMPOS RESTO
						  
						  $cuenta_campos_detalle_item = $numero ;
						  
						  // COLUMNA DE PROVEEDORES
						  	$titulos_oferente.="<th colspan=".($numero + 2 + $numero_columna_formula)." class='".$class_tp."'>".$lc[1]."</th>"; 
						  // COLUMNA DE PROVEEDORES

						  
							  $num_columna_titulo++;//PARA CAMBIAR DE ESTILO
						}
						
						
$lista_oferentes_invitados = explode(",",$resutado_proveedores);
						$lista_oferentes= explode(",",$resutado_proveedores);
						$lista_oferentes_nombre = explode(",",$resutado_pro_nombre);		

					$concatena_titulo = ($numero+5);
					
		/********************************************************************************************/
		/*BUSCA PROVEEDORES*/	
		/********************************************************************************************/
	
//	$busca_valores_moneda_proveedor=mysql_fetch_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $busca_campos_moneda[0] and oferta = 1"));
	
$busca_lista_articulos = query_db("select * from $t95 where in_id = $id_invitacion  and pro11_id = $id_lista  ");
	while($l_articulos = mysql_fetch_row($busca_lista_articulos)){ //BUSCA ARTICULOS
			


			
			for($pr_in=0;$pr_in<$cuenta_proveedores_invitados;$pr_in++){//for oferentes por cada oferrente ingresa un articulo
			
			
				$inserta_articulos = query_db("insert into reporte_temp (pro1_id, id_lista, pv_id, lista,pv_nombre) values ('$id_invitacion', '$l_articulos[0]', '$lista_oferentes_invitados[$pr_in]' , '$id_lista','$lista_oferentes_nombre[$pr_in]' )");

					$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista order by evaluador4_id");
					while($lista_campos = mysql_fetch_row($busca_campos)){  //WHILE CAMPOS TABLA
						$busca_valores_ofertado=mysql_fetch_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes_invitados[$pr_in] and evaluador5_id  = $l_articulos[0] and evaluador4_id = $lista_campos[0] and oferta = 1"));

						if( ($lista_campos[3]=="Valor") && ($busca_valores_ofertado!="") ){//si el campo es valor
							if($l_articulos[6]=="USD"){//si se solicita la cotizacion en USD
								$update_tem = "update reporte_temp set c_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = ( $busca_valores_ofertado[0] * $linvi[42] ), v_cantidad_$lista_campos[0] = ( ( $busca_valores_ofertado[0] * $linvi[42] ) * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
									$inser_int_tem = query_db("insert into reporte_temp_11 values ('".$lista_oferentes_nombre[$pr_in]."', '".$busca_valores_ofertado[0]."','".( $busca_valores_ofertado[0] * $linvi[42] )."','1','".( ( $busca_valores_ofertado[0] * $linvi[42] ) * $l_articulos[5] )."' )");						

							
							} //si se solicita la cotizacion en USD

							elseif($l_articulos[6]=="COP"){//si se solicita la cotizacion en COP
								$update_tem = "update reporte_temp set c_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = '$busca_valores_ofertado[0]', v_cantidad_$lista_campos[0] = (  $busca_valores_ofertado[0] * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
								$inser_int_tem = query_db("insert into reporte_temp_11 values ('".$lista_oferentes_nombre[$pr_in]."', '".$busca_valores_ofertado[0]."','".$busca_valores_ofertado[0]."','1','".( $busca_valores_ofertado[0] * $l_articulos[5] )."' )");						

							} //si se solicita la cotizacion en COP

							else{//si se solicita la cotizacion en MULTIMONEDA
									$busca_valores_moneda_proveedor=mysql_fetch_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes_invitados[$pr_in] and evaluador5_id  = $l_articulos[0] and evaluador4_id = $busca_campos_moneda_lista and oferta = 1"));
										if($busca_valores_moneda_proveedor[0]=="COP"){
											$update_tem = "update reporte_temp set c_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = '$busca_valores_ofertado[0]', v_cantidad_$lista_campos[0] = (  $busca_valores_ofertado[0] * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
											$inser_int_tem = query_db("insert into reporte_temp_11 values ('".$lista_oferentes_nombre[$pr_in]."', '".$busca_valores_ofertado[0]."','".$busca_valores_ofertado[0]."','1','".( $busca_valores_ofertado[0] * $l_articulos[5] )."' )");						

											}
										if($busca_valores_moneda_proveedor[0]=="USD"){
											$update_tem = "update reporte_temp set c_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = ( $busca_valores_ofertado[0] * ($linvi[42]*1) ), v_cantidad_$lista_campos[0] = ( ( $busca_valores_ofertado[0] * $linvi[42] ) * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
											$inser_int_tem = query_db("insert into reporte_temp_11 values ('".$lista_oferentes_nombre[$pr_in]."', '".$busca_valores_ofertado[0]."','".( $busca_valores_ofertado[0] * $linvi[42] )."','1','".( ( $busca_valores_ofertado[0] * $linvi[42] ) * $l_articulos[5] )."' )");						
											
											}

										else{
											$update_tem = "update reporte_temp set c_original_$lista_campos[0] = '$busca_valores_ofertado[0]', v_trm_$lista_campos[0] = '$busca_valores_ofertado[0]', v_cantidad_$lista_campos[0] = (  $busca_valores_ofertado[0] * $l_articulos[5] ) where id_lista = $l_articulos[0] and pv_id = $lista_oferentes_invitados[$pr_in] ";
											$inser_int_tem = query_db("insert into reporte_temp_11 values ('".$lista_oferentes_nombre[$pr_in]."', '".$busca_valores_ofertado[0]."','".$busca_valores_ofertado[0]."','1','".( $busca_valores_ofertado[0] * $l_articulos[5] )."' )");						

											}
											
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



	
													?>
<table width="950" border="0" cellpadding="2" cellspacing="2" >
<tr>
       <td colspan="5"><strong><img src="../librerias/jquery/menu1/help.gif" width="18" height="18">AYUDA:</strong>Seleccione de la siguiente lista la condicion econ&oacute;mica con la cual desea que el sistema le indique la mejor oferta por oferente:</td>
     </tr>
     <tr class="administrador_tabla_titulo">
       <td width="28%"><div align="right"><strong>Seleccione la condici&oacute;n econ&oacute;mica:</strong></div></td>
     <td width="16%"><label>
         <select name="campo_valos" id="select" >
      <?

		 $busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  in ('Valor', 'Numerico') and pro11_id = $id_lista");
			while($l_campo_trae = mysql_fetch_row($busca_campos_1)){	
			if($campo_valos==$l_campo_trae[0]) $c_sel = "selected"; else $c_sel="";
			 ?>
            <option value='<?=$l_campo_trae[0];?>' <?=$c_sel;?>><?=$l_campo_trae[2];?></option>
            <? } ?>
         </select>
         
         
          
       </label></td>
       <td width="17%"><div align="right"><strong>Parametro de selecci&oacute;n:</strong></div></td>
       <td width="19%"><select name="tipo_busq" id="tipo_busq" >
         <option value='min' <? if($tipo_busq=="min")  echo "selected";?>>Minimo Valor</option>
         <option value='max' <? if($tipo_busq=="max") echo "selected";?>>Maximo Valor</option>
       </select></td>
     <td width="20%"><label>
         <input name="button" type="button" class="buscar" id="button" value="Generar Agrupamiento" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=' + document.principal.campo_valos.value + '&tipo_busq=' + document.principal.tipo_busq.value + '&id_lista=<?=$id_lista;?>','carga_resultados_principales')">
       </label></td>
     </tr>
</table>
   <br>
<div class="demo_jui">
   <table  border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" id="example" >
   <thead>
     <tr>
       
       <th  colspan="8" class="columna_titulo_resultados_evaluador">TERMINOS ECONOMICOS</th>
       <th  class="columna_titulo_resultados_evaluador">CONSOLIDADO</th>
	   <?=$titulos_oferente;?>
     </tr>
     
     
     
     <tr class='columna_subtitulo_resultados'>
       <th width="1%" class="columna_subtitulo_resultados_economico">&nbsp;</th>

       <th width="1%" class="columna_subtitulo_resultados_economico"><strong><?=$nombre_lista1;?></strong></th>
       <th width="30%" class="columna_subtitulo_resultados_economico"><strong><?=$nombre_lista2;?></strong></th>
       <th width="2%" class="columna_subtitulo_resultados_economico"><?=$nombre_lista3;?></th>
       <th width="2%" class="columna_subtitulo_resultados_economico"><strong><?=$nombre_lista4;?></strong></th>
       <th width="2%" class="columna_subtitulo_resultados_economico"><strong><?=$nombre_lista5;?></strong></th>
        <th width="2%" class="columna_subtitulo_resultados_economico"><strong><?=$nombre_lista6;?></strong></th>
        <th width="2%" class="columna_subtitulo_resultados_economico"><strong><?=$nombre_lista7;?></strong></th>
        <th width="2%" class="columna_subtitulo_resultados_economico"><strong>Mejor oferente</strong></th>
	
		<?=$titulo_campos;?>
     </tr>
     </thead>
     <tbody>
    <?

	 $valida_busca_campos_1 = mysql_fetch_row(query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_id = $campo_valos "));


  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion  and pro11_id = $id_lista  "); //limit  $paginador,$numero_pagi
	while($l_campo = mysql_fetch_row($busca_campos)){ //IMPRIME LIOSTA DE ARICULOS
	$campo_campos=""; 
	$reemplaza_valores="";
	$campo_campos_consolodado="<td class='divicion_tablas' width='1%'><strong>&nbsp;</strong></td>";

if($valida_busca_campos_1[3]=="Valor"){//valida campo formateado con trm
 	$busca_ganador=mysql_fetch_row(query_db("select $tipo_busq(v_trm_$campo_valos * 1) from reporte_temp 
	 where  v_trm_$campo_valos <> '' and id_lista  = $l_campo[0]   group by id_lista "));


	 }
else
	{
 	$busca_ganador=mysql_fetch_row(query_db("select $tipo_busq(c_original_$campo_valos * 1) from reporte_temp 
	 where  c_original_$campo_valos <> '' and id_lista  = $l_campo[0]   group by id_lista "));
	
	}


	if($select_formula[4]>=1){// si en la formula solicitan el valor minimo del articulo de cualquier campo
	 	$minimo_formula=mysql_fetch_row(query_db("select min(v_cantidad_$select_formula[4] * 1) from reporte_temp 
	 where  v_cantidad_$select_formula[4] <> '' and id_lista  = $l_campo[0]   group by id_lista "));
	 } // si en la formula solicitan el valor minimo del articulo de cualquier campo


	if($select_formula[5]>=1) {// si en la formula solicitan el valor maximo del articulo de cualquier campo
	 	$maximo_formula=mysql_fetch_row(query_db("select min(v_cantidad_$select_formula[4] * 1) from reporte_temp 
	 where  v_cantidad_$select_formula[4] <> '' and id_lista  = $l_campo[0]   group by id_lista "));
	 }// si en la formula solicitan el valor maximo del articulo de cualquier campo

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
	while($l_campo_trae = mysql_fetch_row($busca_campos_1)){//RECORRE CAMPOS
		
		$busca_valores_ing=mysql_fetch_row(query_db("select c_original_$l_campo_trae[0] from reporte_temp  where pv_id = $lista_oferentes[$yy] and id_lista  = $l_campo[0] "));
		$busca_valores_moneda_proveedor=mysql_fetch_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $busca_campos_moneda[0] and oferta = 1"));
	
		if($busca_valores_ing[0]!=""){ //si el valor ingresado por elproveedor esta lleno
		
		if($l_campo_trae[3]=="Valor"){//valida campo formateado con trm
			$busca_valores_ing_formateados=mysql_fetch_row(query_db("select c_original_$l_campo_trae[0], v_trm_$l_campo_trae[0], v_cantidad_$l_campo_trae[0] from reporte_temp  where pv_id = $lista_oferentes[$yy] and id_lista  = $l_campo[0] "));


								
								
				if($cuenta_pasada_para_formula==0){//si es la primera pasada
				  $reemplaza_valores = str_replace("min(b".$l_campo_trae[0].")",$minimo_formula[0],$formula_aplicada);
				  $reemplaza_valores = str_replace("max(b".$l_campo_trae[0].")",$maximo_formula[0],$reemplaza_valores);	
				  $reemplaza_valores = str_replace("b".$l_campo_trae[0],$busca_valores_ing_formateados[2],$reemplaza_valores);			  
		
		
				}//si es la primera pasada
				else{//si es la segunda pasada
				  $reemplaza_valores = str_replace("min(b".$l_campo_trae[0].")",$minimo_formula[0],$reemplaza_valores);
				  $reemplaza_valores = str_replace("max(b".$l_campo_trae[0].")",$maximo_formula[0],$reemplaza_valores);				  
				  $reemplaza_valores = str_replace("b".$l_campo_trae[0],$busca_valores_ing_formateados[2],$reemplaza_valores);
				}//si es la segunda pasada
				
		}//valida campo formateado con trm

		if($l_campo[6]=="USD")
				$nuemro_decimales= 2;
		elseif($l_campo[6]=="COP")
				$nuemro_decimales= 0;
		else{//si se solicita la cotizacion en MULTIMONEDA
												
		$busca_valores_moneda_proveedor=mysql_fetch_row(query_db("select w_valor from $tabla_economica  
													where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] 
													and evaluador4_id = $busca_campos_moneda_lista and oferta = 1"));
													
													
														if($busca_valores_moneda_proveedor[0]=="COP")
															$nuemro_decimales= 0;
														if($busca_valores_moneda_proveedor[0]=="USD")
															$nuemro_decimales= 2;
														else
															$nuemro_decimales= 0;
				
			}//si se solicita la cotizacion en MULTIMONEDA												
															
					if($l_campo_trae[0]==$campo_valos)
							{// si es campos seleccionado da formato 
			
								if($l_campo_trae[3]=="Valor"){
								$multiplica_cantidad=number_format($busca_valores_ing_formateados[2],$nuemro_decimales);
								$valor_compara_ganador = $busca_valores_ing_formateados[1];
								}
								else{
								$multiplica_cantidad=number_format($busca_valores_ing[0],$nuemro_decimales);
								$valor_compara_ganador = $busca_valores_ing[0];
								}
											
								$campo_campos.="<td class='".$class."'>".number_format($busca_valores_ing[0],$nuemro_decimales)."</td>";

								
										if(($valor_compara_ganador==$busca_ganador[0]) && ($busca_valores_ing[0]>=1)){// busca_ganador por item
											$campo_campos2="<td class='".$class."' width='1%'><strong><div class='oferta_ganadora'>SI</div> </strong></td>";
											$update_tem = query_db("update reporte_temp set item_ganador = 1 where id_lista = $l_campo[0] and pv_id = $lista_oferentes[$yy] ");

											$nobre_proveedor_gan = $lista_oferentes_nombre[$yy];
											$campo_campos_consolodado="<td class='divicion_tablas' width='1%'><strong>".$nobre_proveedor_gan."</strong></td>";
											
											}// busca_ganador por item
										else
											$campo_campos2="<td class='".$class."' width='1%'><strong><div class='oferta_perdedora'>NO</div> </strong></td>";
							} // si es campos seleccionado da formato 
					elseif($l_campo_trae[3]=="Valor")
								{ //si el campo es valor da formato
									$campo_campos.="<td class='".$class."'>".number_format($busca_valores_ing[0],$nuemro_decimales)."</td>";
								} //si el campo es valor da formato
					else
						{ //si el campo NO es valor da formato
							$campo_campos.="<td class='".$class."'>$busca_valores_ing[0]</td>";
							$sin_valor=1;			
						
						} //si el campo NO es valor da formato
		
								}//si el valor ingresado por elproveedor esta lleno
		else{//si el valor ingresado por elproveedor NO  esta lleno
			$campo_campos.="<td class='".$class."'>&nbsp;</td>";
			$sin_valor=0;
			} //si el valor ingresado por elproveedor NO  esta lleno
			
			$cuenta_pasada_para_formula++;// cuenta para reemplazar formula
	
		}//RECORRE CAMPOS

//echo "select $reemplaza_valores ";
		$busca_resultado_sql = mysql_fetch_row(query_db("select $reemplaza_valores "));
		
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
         <td class='divicion_tablas'><?=$l_campo[7];?>&nbsp;</td>
         <td class='divicion_tablas'><?=$l_campo[8];?>&nbsp;</td>
        <?=$campo_campos_consolodado;?>
		<?=$campo_campos;?>
        <?
			$total_colopsa = ( ($cuenta_campos_detalle_item*$cuenta_proveedores) + 7 );
		?>       
     </tr>
     <? $num_fila++;	
	}//IMPRIME LIOSTA DE ARICULOS
	?>
  	</tbody>
</table>
</div>

<br>
<table width="950" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
<tr>
       <td colspan="5" class="titulo_tabla_azul_sin_bordes">Consolidado de ofertas</td>
     </tr>
     <tr>
       <td width="330" class="columna_subtitulo_resultados"><div align="center">Oferente</div></td>
       <td width="187" class="columna_subtitulo_resultados"><div align="center">Valor total unitario</div></td>
       <td width="132" class="columna_subtitulo_resultados"><div align="center">Valor total</div></td>
       <td width="148" class="columna_subtitulo_resultados"><div align="center">Numero de items ganadores</div></td>
       <td width="121" class="columna_subtitulo_resultados"><div align="center">Valor items ganadores</div></td>
  </tr>
   
   <?

	$busca_proveedores = query_db("select pv_id, sum(c_original_$campo_valos), sum(v_cantidad_$campo_valos), sum(item_ganador) as ganadores, pv_nombre from reporte_temp group by pv_id order by ganadores desc");
	while($res_f=traer_fila_row($busca_proveedores))	{
	
	$suma_ganadores = traer_fila_row(query_db("select sum(v_cantidad_$campo_valos) from reporte_temp where pv_id = $res_f[0] and item_ganador = 1"));
   $busca_aiu="select * from $t24 where pro1_id = $id_invitacion and pv_id = $res_f[0] and pro11_id = $id_lista ";
   $sql_aui=traer_fila_row(query_db($busca_aiu));
 
   $administracion= ($res_f[2]*$sql_aui[4])/100;
   $imprevistos= ($res_f[2]*$sql_aui[5])/100;
   $utilidad= ($res_f[2]*$sql_aui[6])/100;      
   $total_costo_directo = ($res_f[2]+$administracion+$imprevistos+$utilidad);   
   $iva_aiu=($total_costo_directo*16)/100;
   $total_costo=($total_costo_directo+$iva_aiu);

   $administracion_g= ($suma_ganadores[0]*$sql_aui[4])/100;
   $imprevistos_g= ($suma_ganadores[0]*$sql_aui[5])/100;
   $utilidad_g= ($suma_ganadores[0]*$sql_aui[6])/100;      
   $total_costo_directo_g = ($suma_ganadores[0]+$administracion_g+$imprevistos_g+$utilidad_g);   
   $iva_aiu_g=($total_costo_directo_g*16)/100;
   $total_costo_g=($total_costo_directo_g+$iva_aiu_g);

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
   ?> 
    
     <tr class="<?=$class;?>">
       <td><?=$res_f[4];?></td>
       <td><?=number_format($res_f[1],2);?></td>
       <td><?=number_format($res_f[2],2);?></td>
       <td><?=number_format($res_f[3],2);?></td>
       <td><?=number_format($suma_ganadores[0],2);?></td>
     </tr>
<?
 	if($muestra_aui==1){
    $busca_aiu="select * from $t24 where pro1_id = $id_invitacion and pv_id = $res_f[0] and pro11_id = $id_lista ";
   $sql_aui=traer_fila_row(query_db($busca_aiu));
 
   $administracion= ($res_f[2]*$sql_aui[4])/100;
   $imprevistos= ($res_f[2]*$sql_aui[5])/100;
   $utilidad= ($res_f[2]*$sql_aui[6])/100;      
   $total_costo_directo = ($res_f[2]+$administracion+$imprevistos+$utilidad);   
   $iva_aiu=($utilidad*16)/100;
   $total_costo=($total_costo_directo+$iva_aiu);

   $administracion_g= ($suma_ganadores[0]*$sql_aui[4])/100;
   $imprevistos_g= ($suma_ganadores[0]*$sql_aui[5])/100;
   $utilidad_g= ($suma_ganadores[0]*$sql_aui[6])/100;      
   $total_costo_directo_g = ($suma_ganadores[0]+$administracion_g+$imprevistos_g+$utilidad_g);   
   $iva_aiu_g=($utilidad_g*16)/100;
   $total_costo_g=($total_costo_directo_g+$iva_aiu_g);

 ?>     
     <tr >
       <td colspan="5">
       
       <table width="50%" border="0" align="right" cellpadding="4" cellspacing="4" class="tabla_borde_azul_fondo_blanco">
  <tr class="columna_subtitulo_resultados">
    <td>&nbsp;</td>
    <td class="columna_subtitulo_resultados"><div align="center">Porcentaje</div></td>
    <td class="columna_subtitulo_resultados"><div align="center">Total</div></td>
    <td class="columna_subtitulo_resultados"><div align="center">Ganadores</div></td>
  </tr>
  <tr>
       <td width="79%"><div align="right"><strong>Administraci&oacute;n:</strong></div></td>
       <td width="9%"><div align="right">
         <?=number_format($sql_aui[4],2);?>
         %</div></td>
       <td width="4%"><div align="right">
         <?=number_format($administracion,0);?>
       </div></td>
       <td width="3%"><div align="right">
         <?=number_format($administracion_g,0);?>
       </div></td>
     </tr>
     <tr>
       <td><div align="right"><strong>Imprevistos:</strong></div></td>
       <td><div align="right">
         <?=number_format($sql_aui[5],2);?>
         %</div></td>
       <td><div align="right">
         <?=number_format($imprevistos,0);?>
       </div></td>
       <td><div align="right">
         <?=number_format($imprevistos_g,0);?>
       </div></td>
     </tr>
     <tr>
       <td><div align="right"><strong>Utilidad:</strong></div></td>
       <td><div align="right">
         <?=number_format($sql_aui[6],2);?>
         %</div></td>
       <td><div align="right">
         <?=number_format($utilidad,0);?>
       </div></td>
       <td><div align="right">
         <?=number_format($utilidad_g,0);?>
       </div></td>
     </tr>
     <tr>
       <td class="titulos_evaluacion"><div align="right"><strong>Total costo directo</strong></div></td>
       <td class="titulos_evaluacion"><div align="right"></div></td>
       <td class="titulos_evaluacion"><div align="right">
         <?=number_format($total_costo_directo,0);?>
       </div></td>
       <td class="titulos_evaluacion"><div align="right">
         <?=number_format($total_costo_directo_g,0);?>
       </div></td>
     </tr>
     <tr>
       <td><div align="right"><strong>Iva</strong></div></td>
       <td><div align="right">16 
         %</div></td>
       <td><div align="right">
         <?=number_format($iva_aiu,0);?>
       </div></td>
       <td><div align="right">
         <?=number_format($iva_aiu_g,0);?>
       </div></td>
     </tr>
     <tr>
       <td class="titulos_evaluacion"><div align="right"><strong>Total:</strong></div></td>
       <td class="titulos_evaluacion"><div align="right"></div></td>
       <td class="titulos_evaluacion"><div align="right">
         <?=number_format($total_costo,0);?>
       </div></td>
       <td class="titulos_evaluacion"><div align="right">
         <?=number_format($total_costo_g,0);?>
       </div></td>
     </tr>
       </table>       </td>
     </tr>
     <tr  class="<?=$class;?>">
       <td colspan="5" >&nbsp;</td>
     </tr>
     
   <? 
   }//aiu
   $num_fila++; 
   } ?>
</table>

<table width="950" border="0" cellspacing="2" cellpadding="2">
<tr>
        <td><label>
          <div align="center">
            <input name="button2" type="button" class="guardar" id="button2" value="Exportar reporte a excel" onClick="window.parent.location.href='../aplicaciones/evaluacion/exporta_c_economico.php?id_invitacion=<?=$id_invitacion;?>&id_lista=<?=$id_lista;?>&campo_valos=<?=$campo_valos;?>&tipo_busq=min'">
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
