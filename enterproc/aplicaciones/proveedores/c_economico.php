<?  include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

    verifica_menu("procesos.html");
	
	$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	$us_cliente = $_SESSION["id_proveedor"];

 	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$inserta_visualizacion = query_db("insert into in_ingreso_sistema (us_id, fecha_ingreso, ultima_conexion, ip, session, modulo, pro1_id, pv_id) 
	values ( ".$_SESSION["id_us_session"].", '$fecha $hora','', '".$_SERVER['REMOTE_ADDR']."', '','Modulo lista de precios',$id_invitacion,".$_SESSION["id_proveedor"].")");


	$busca_listas_creadas = "select count(*),pro11_id,requiere_aui from $t19 where pro1_id = $id_invitacion group by pro1_id";
	$sql_listas = traer_fila_row(query_db($busca_listas_creadas));
	if($sql_listas[0]>=2){
	$id_lista=$id_lista;
	$muestra_listas=1;
	}
	else{
	$id_lista=$sql_listas[1];
	$requiere_aui=$sql_listas[2];
	
	}
	
	
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
	$muestra_cantidad=2;

}


function items_ganadores($nombre_campo,$oferta_vista,$campo_valos,$trm, $busca_campos_moneda_lista_no)
	{
	global $lista_oferentes,$cuenta_proveedores,$id_invitacion,$tabla_economica,$t95,$tipo_busq, $t94, $us_cliente,$t19,$t93,$id_lista;
	
	$busca_campo_subasta_semaforo = traer_fila_row(query_db("select evaluador3_valor from $t93 where in_id = $id_invitacion and evaluador3_termino=4 and peso_evaluacion = $id_lista"));
	$campo_mejor_oferta_semaforo=$busca_campo_subasta_semaforo[0];

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
	
		$busca_valores_ing_semaforo=traer_fila_row(query_db("select sum(w_valor) from $tabla_economica  
		where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $campo_mejor_oferta_semaforo 
		and oferta = $oferta_vista  "));
		if($busca_valores_ing_semaforo[0]!="")
			$campo_semaforo_ingresa = $campo_mejor_oferta_semaforo;
		else
				$campo_semaforo_ingresa = 0;
	
				
					if($busca_valores_ing_valida_campos[0]=="0"){//si el campo tiene valor
										

										if($l_campo[6]=="USD"){
											$total_afectado= (($busca_valores_ing[0] * $l_campo[5] ) * $trm) * 1.16;
											$total_afectado_semaforo = (($busca_valores_ing_semaforo[0] * $l_campo[5] ) * $trm) * 1.16;
											}
										elseif($l_campo[6]=="COP"){
											$total_afectado= ($busca_valores_ing[0] * $l_campo[5] ) * 1.16;
											$total_afectado_semaforo= ($busca_valores_ing_semaforo[0] * $l_campo[5] ) * 1.16;
											}
										else{//si se solicita la cotizacion en MULTIMONEDA
													
													
													$busca_valores_moneda_proveedor=traer_fila_row(query_db("select w_valor from $tabla_economica  
													where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] 
													and evaluador4_id = $busca_campos_moneda_lista[0] and oferta = 1"));
													
													
														if($busca_valores_moneda_proveedor[0]=="COP"){
															$total_afectado= ( $busca_valores_ing[0] * $l_campo[5] )  * 1.16;
															$total_afectado_semaforo= ($busca_valores_ing_semaforo[0] * $l_campo[5] ) * 1.16;
															
															}
				
														if($busca_valores_moneda_proveedor[0]=="USD"){
															$total_afectado= (($busca_valores_ing[0] * $l_campo[5] ) * $trm) * 1.16;
															$total_afectado_semaforo = (($busca_valores_ing_semaforo[0] * $l_campo[5] ) * $trm) * 1.16;
															
															
															}
				
														else{
															$total_afectado= ( $busca_valores_ing[0] * $l_campo[5] )  * 1.16;
															$total_afectado_semaforo= ($busca_valores_ing_semaforo[0] * $l_campo[5] ) * 1.16;
															
															
															}
											
										} //si se solicita la cotizacion en MULTIMONEDA
											
										$total_afectado_final+=$total_afectado;
										$inserta_temporal = "insert into reporte_temp1_$us_cliente values 
										('$id_invitacion','$lista_oferentes[$yy]','$l_campo[9]', '$busca_valores_ing[0]', '$total_afectado','1','$campo_semaforo_ingresa','$total_afectado_semaforo','$l_campo[0]' )";
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
		('$id_invitacion','$lista_oferentes[$yy]',0, 0, '$busca_resultado_sql[0]','2', '','','' )";
		$sql_str=query_db($inserta_temporal);
	
		}//for oferentes
		$cuenta_pasada_para_formula=0;// cuenta para reemplazar formula
}//busca listas
			
			
	}// function

if($busca_campo_subasta_consoli[0]==10){//si tiene subasta consolidada activa

$busca_campo_subasta_consoli = traer_fila_row(query_db("select evaluador3_termino from $t93 where in_id = $id_invitacion and evaluador3_termino=10 "));
/********************************************************************************************/
	/*CREA TABLA TEMPORAL*/	
	$tiene_consolidado=1;
	$sql_tabla="CREATE  TEMPORARY TABLE reporte_temp1_$us_cliente ( pro1_id varchar(50) NOT NULL, pv_id varchar(50) NOT NULL,
		 id_lista varchar(50) NOT NULL, valor varchar(50) NOT NULL, valor_total varchar(50) NOT NULL, tipo_valor varchar(50) NOT NULL, id_item_lista varchar(50) NOT NULL, id_campo_seleccionado varchar(50) NOT NULL, evaluador5_id varchar(50) NOT NULL) " ;		
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



$busca_mejor_oferta_consolidad="select sum(valor_total) as puntaje_final, pv_id from reporte_temp1_$us_cliente where pro1_id = $id_invitacion and tipo_valor = 2 and valor_total>=1 group by pv_id order by puntaje_final desc";
$busca_mejor_oferta_consolidad_proveedor="select sum(valor_total) as puntaje_final from reporte_temp1_$us_cliente where pro1_id = $id_invitacion and tipo_valor = 2 and pv_id = $us_cliente and valor_total>=1";	
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

if($accion_crea=="crea_oferta")
	{
		$busca_valores_ing_oferta=traer_fila_row(query_db("select max(oferta) from $tabla_economica  where pv_id = $us_cliente"));
		$oferta = ($busca_valores_ing_oferta[0]+1);
	}


$numero_pagi = 25;
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



if($oferta<=0)
$oferta=1;
else
$oferta=$oferta;
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="../librerias/js/val_02.js"></script>

<script>





	

</script>
<link href="../css/principal.css" rel="stylesheet" type="text/css">

<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="98%" border="0" cellpadding="0" cellspacing="5">
  <tr> 
      
      <td class="titulos_procesos">  PROPUESTA ECON&Oacute;MICA<br>
      <span class="titulosec1"></span></td>
  </tr>
</table>  
  
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="2" class="columna_titulo_resultados"><strong>Informaci&oacute;n General del Proceso  | Consecutivo del proceso
        <?=$sql_e[22];?>
      </strong></td>
    </tr>
    <tr>
      <td class="columna_subtitulo_resultados"><div align="right"><strong>Estado del proceso:</strong></div></td>
      <td class="texto_paginador_proveedor"><?=listas_sin_select($tp1,$sql_e[1],1);?></td>
    </tr>
    <tr>
      <td width="21%" class="columna_subtitulo_resultados"><div align="right"><strong> Tipo de proceso:</strong></div></td>
      <td width="79%" class="filas_resultados"><strong class="filas_resultados" >
        <?=listas_sin_select($tp2,$sql_e[2],1);?>
      </strong></td>
    </tr>
    <tr>
      <td class="columna_subtitulo_resultados"><div align="right"><strong>Tipo de solicitud:</strong></div></td>
      <td ><strong>
        <?=listas_sin_select($tp3, $sql_e[3], 1);?>
      </strong></td>
    </tr>
    <tr>
      <td class="columna_subtitulo_resultados"><div align="right"><strong>Persona de contacto:</strong></div></td>
      <td class="filas_resultados"><?=listas_sin_select($t1, $sql_e[15], 1);?></td>
    </tr>
    <tr>
      <td class="columna_subtitulo_resultados"><div align="right"><strong>
          <?=$lenguaje_0;?>
        :</strong></div></td>
      <td ><strong>
        <?=$sql_e[12];?>
      </strong></td>
    </tr>
  </table>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="84%"><input name="button2" type="button" class="guardar" id="button2" value="Refrescar la p&aacute;gina" onClick="paginacion_lista(document.principal.pag.value)"></td>
      <td width="16%">
        <input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('detalle_invitacion_<?=$id_invitacion_pasa;?>.php','contenidos')">
   </td>
    </tr>
  </table>
  
  <? if ($muestra_listas==1){ //muestra cuadro de lista por que hay mas de una ?>
<table width="98%" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="81%"><div align="left">
        <p><img src="../imagenes/botones/help.gif" alt="" width="18" height="18"> AYUDA: Para ingresar a las listas de cotizaci&oacute;n , seleccione de las siguiente lista del proceso para cotizar y diligencie los campos solicitados.<br>
        </p>
        </div></td>
    </tr>
    <?
		if($id_lista>=1){
		$busca_listas_creadas = "select * from $t19 where pro11_id = $id_lista";
		$sql_listas = traer_fila_row(query_db($busca_listas_creadas));
		$titulo_lista="Usted esta en la lista: ".$sql_listas[2];
		$requiere_aui=$sql_listas[3];
		}
		else
			$titulo_lista="Por favor seleccione una lista para ofertar";
													
													?>
  </table>
  <br>
  
  
<table width="98%" border="0" align="left" cellpadding="2" cellspacing="2">
<tr>
      <td width="58%" valign="top" class="titulo_tabla_azul_sin_bordes">Lista seleccionada para cotizar</td>
      <td width="42%" class="titulo_tabla_azul_sin_bordes">Listas del proceso para cotizar</td>
    </tr>
    <tr>
      <td valign="top"><div align="center" class="telefono_contacto">
        <?=$titulo_lista;?></div></td>
      <td><table width="95%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="87%"><select name="listas" onChange="ajax_carga(this.value,'contenidos')">
                <option value="../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&tipo_busq=min&id_lista=<?=$ex_listas[0];?>">Seleccione una lista</option>
                <?
					$busca_listas_creadas = "select * from $t19 where pro1_id = $id_invitacion";
					$sql_listas = query_db($busca_listas_creadas);
					while($ex_listas = traer_fila_row($sql_listas)){ 
				?>
              <option value="../aplicaciones/proveedores/c_economico.php?id_invitacion_pasa=<?=$id_invitacion_pasa;?>&termino=2&oferta=1&id_lista=<?=$ex_listas[0];?>"><?=$ex_listas[2];?></option>
                <? } ?>
              </select>
            </td>
          </tr>
      </table></td>
    </tr>
  </table>
<p>&nbsp;</p>
<?  }//muestra cuadro de lista por que hay mas de una ?>
 



   <? if($id_lista!=0){ //si tiene listas creadas
   
  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td width='10%' align='center' class='titulo_tabla_azul_sin_bordes'>".$l_campo[2]."</td>";
	$numero++;
  													} 
	if($campo_mejor_oferta!=""){													
	$titulo_campos.="<td width='15%' align='center' class='titulo_tabla_azul_sin_bordes'>Estado de su Oferta</td>";	$numero+=1;											
	}
	
	$concatena_titulo = ($numero+7);


?>
<div id="acualiza_consolidado_es">
<?=$tabla_semaforo_consolidado;?>
</div>

<?

$busca_campo_subasta = traer_fila_row(query_db("select evaluador3_valor from $t93 where in_id = $id_invitacion and evaluador3_termino=4 and peso_evaluacion = $id_lista"));
$campo_mejor_oferta=$busca_campo_subasta[0];
   
   
   ?>

<br>


<table width="98%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
     <tr>
       <td width="85%" class="tabla_paginador"><div align="right" class="texto_paginador_proveedor"><strong>Numero de p&aacute;ginas en esta lista: <?=$pagina;?></strong></div></td>
       <td width="3%" class="tabla_paginador"><div align="center"><a href="javascript:paginacion_lista(<?=$anterior;?>)"> <img src="../imagenes/botones/arrow-left-16.gif" alt="P&aacute;gina anterior" width="14" height="13"></a></div></td>
       <td width="9%" class="tabla_paginador"><label>
       <select name="select" onChange="javascript:paginacion_lista(this.value)">
         <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
         <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>P&aacute;gina
           <?=$i;?>
         </option>
         <? } ?>
       </select>
       </label></td>
       <td width="3%" class="tabla_paginador"><a href="javascript:paginacion_lista(<?=$proxima;?>)"> <img src="../imagenes/botones/arrow-right-16.gif" alt="P&aacute;gina Siguiente" width="14" height="13"></a></td>
     </tr>
   </table>  
<?
	$cuenta_numero_parte= traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista  and evaluador5_valor !='' "));
	$cuenta_marca= traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista  and evaluador5_presupuesto  !='' "));
	$muestra_campo_par=1;
	$muestra_campo_mar=1;
	$concatena_titulo_suma=0;
	if($cuenta_numero_parte[0]==0){
		$concatena_titulo=($concatena_titulo-1);
		$muestra_campo_par=0;
		$concatena_titulo_suma=1;
		}

	if($cuenta_marca[0]==0){
		$concatena_titulo=($concatena_titulo-1);
		$muestra_campo_mar=0;
		$concatena_titulo_suma+=1;
		}
?>
    
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco_oferente">

     <tr>
       <td width="30" class="titulo_tabla_azul_sin_bordes"><strong><?=$nombre_lista1;?></strong></td>
       <td width="30" class="titulo_tabla_azul_sin_bordes"><strong><?=$nombre_lista2;?></strong></td>
       <td width="30" class="titulo_tabla_azul_sin_bordes"><strong><?=$nombre_lista3;?></strong></td>
       <? if($muestra_cantidad==1){ ?><td width="22" class="titulo_tabla_azul_sin_bordes"><strong><?=$nombre_lista4;?></strong></td>
       <? } ?>
      <? if($muestra_campo_par==1){ ?> <td width="41" class="titulo_tabla_azul_sin_bordes"><strong><?=$nombre_lista6;?></strong></td>
      <? } ?>
      <? if($muestra_campo_mar==1){ ?> <td width="41" class="titulo_tabla_azul_sin_bordes"><strong><?=$nombre_lista7;?></strong></td>
      <? } ?>
	   <td width="22" class="titulo_tabla_azul_sin_bordes"><strong><?=$nombre_lista5;?></strong></td>
	   <?=$titulo_campos;?>
     </tr>
     <?
	 

	
	
  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion and pro11_id = $id_lista  limit $paginador,$numero_pagi ");
	while($l_campo = traer_fila_row($busca_campos)){ 
	$campo_campos=""; 
	
	$campo_formateado=str_replace("id_articulo",$l_campo[0],$campo_campos);
	$valor_proveedor_buscado="";
	$busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo_trae = traer_fila_row($busca_campos_1)){//busca_valor puestos por e proveedor
	$busca_valores_ing=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $us_cliente and oferta = $oferta and evaluador5_id  = $l_campo[0] and evaluador4_id = $l_campo_trae[0]"));
	if($l_campo_trae[3]=="Numerico")
		$campo_campos.="<td ><input type='text' name='campo_pro[$l_campo[0]-$l_campo_trae[0]]' value='$busca_valores_ing[0]' onKeyPress='return acceptNum_punto(event, this.value)'></td>";
	if($l_campo_trae[3]=="Valor"){
		$campo_campos.="<td ><input type='text' name='campo_pro[$l_campo[0]-$l_campo_trae[0]]' value='$busca_valores_ing[0]' onKeyPress='return acceptNum_punto(event, this.value)'></td>";
		
		}

	if($l_campo_trae[3]=="Texto Corto")
		$campo_campos.="<td><input type='text' name='campo_pro[$l_campo[0]-$l_campo_trae[0]]' value='$busca_valores_ing[0]'></td>";
	if($l_campo_trae[3]=="Texto Largo")
		$campo_campos.="<td><textarea name='campo_pro[$l_campo[0]-$l_campo_trae[0]]'>$busca_valores_ing[0]</textarea></td>";
	if($l_campo_trae[3]=="Moneda"){
		$campo_campos.="<td><select name='campo_pro[$l_campo[0]-$l_campo_trae[0]]' id='e2'><option value''>Moneda</option>".listas_selecc_diferente_id($tp7, " nombre != 'MULTIMONEDA' ",$busca_valores_ing[0],'nombre', 1)."</select></td>";
		}

	if($campo_mejor_oferta==$l_campo_trae[0])
		

		$busca_valores_ing_mejor_proveedor=traer_fila_row(query_db("select id_campo_seleccionado from reporte_temp1_$us_cliente  where  evaluador5_id  = $l_campo[0] and id_item_lista = $campo_mejor_oferta and id_campo_seleccionado >=1 and pv_id = $us_cliente"));
		$valor_proveedor_buscado = ($busca_valores_ing_mejor_proveedor[0]*1);
		
		
	} //busca_valor puestos por e proveedor


if($campo_mejor_oferta!=""){

		  	$busca_valores_ing_mejor=traer_fila_row(query_db("select min(id_campo_seleccionado *1) from reporte_temp1_$us_cliente  where  evaluador5_id  = $l_campo[0] and id_item_lista = $campo_mejor_oferta and id_campo_seleccionado >=1 "));
			$cuenta_valores_ing_mejor=traer_fila_row(query_db("select count(*) from reporte_temp1_$us_cliente  where  evaluador5_id  = $l_campo[0] and id_item_lista = $campo_mejor_oferta and id_campo_seleccionado>=1 and id_campo_seleccionado=$busca_valores_ing_mejor[0] "));
			if(($valor_proveedor_buscado>=1) && ($valor_proveedor_buscado<=$busca_valores_ing_mejor[0])){
				if($cuenta_valores_ing_mejor[0]*1==1)
					$campo_campos.="<td align='center'><div align='center' id='sema_".$l_campo[0]."'><img src='../imagenes/botones/SemaforoVerde.gif' alt='Usted tiene la mejor oferta en este articulo hasta el momento'></div></td>";
				else
					$campo_campos.="<td align='center'><div align='center' id='sema_".$l_campo[0]."'><img src='../imagenes/botones/SemaforoAmarilloAnimado.gif' alt='Usted tiene la oferta uno o varios oferentes hasta el momento'></div></td>";						
			}
			else
			$campo_campos.="<td align='center'><div align='center' id='sema_".$l_campo[0]."'><img src='../imagenes/botones/SemaforoRojo.gif' alt='Usted NO tiene la mejor oferta en este articulo hasta el momento'></div></td>";
}		
	?>
     <tr onMouseOver=this.className="tabla_menu_relover"; onMouseOut=this.className="";>
       <td class="divicion_tablas_oferntes"><div align="left"><?=$l_campo[2];?></div>       </td>
       <td class="divicion_tablas_oferntes"><div align="left"><?=$l_campo[3];?></div>       </td>
       <td class="divicion_tablas_oferntes" align="center"><div align="left"><?=$l_campo[4];?></div></td>
       <? if($muestra_cantidad==1){ ?><td  class="divicion_tablas_oferntes" align="center"><div align="left"> <?=$l_campo[5];?></div></td><? } ?>
       <? if($muestra_campo_par==1){ ?><td  class="divicion_tablas_oferntes" align="center"><?=$l_campo[7];?></td><? } ?>
      <? if($muestra_campo_mar==1){ ?> <td  class="divicion_tablas_oferntes" align="center"><?=$l_campo[8];?></td><? } ?>
		<td  class="divicion_tablas_oferntes" align="center"><?=$l_campo[6];?></td>
		<?=$campo_campos;?>
     </tr><? } ?>
     <tr >
       <td >&nbsp;</td>
       <td >&nbsp;</td>
       <td  align="center">&nbsp;</td>
       <? if($muestra_cantidad==1){ ?><td align="center">&nbsp;</td><? } ?>
       <? if($muestra_campo_par==1){ ?><td  align="center">&nbsp;</td><? } ?>
      <? if($muestra_campo_mar==1){ ?><td  align="center">&nbsp;</td><? } ?>
       
       <td align="center">&nbsp;</td>
       
  </tr>
     
     <?
	 $campo_campos="";
	 $busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo_trae = traer_fila_row($busca_campos_1)){//busca_valor puestos por e proveedor
	if($l_campo_trae[3]=="Numerico")
		$campo_campos.="<td >&nbsp;</td>";
	if($l_campo_trae[3]=="Valor"){
//		echo "select * from v_relacion_lista_ofertas  where pro11_id = $id_lista and pv_id = $us_cliente and oferta = $oferta  and evaluador4_id = $l_campo_trae[0]";
		$busca_valores_ing=traer_fila_row(query_db("select sum(w_valor) from v_relacion_lista_ofertas  where pro11_id = $id_lista and pv_id = $us_cliente and oferta = $oferta  and evaluador4_id = $l_campo_trae[0]"));

		$campo_campos.="<td ><div  class='titulos_evaluacion'>$ ".number_format($busca_valores_ing[0],2)."</td>";
		
		}

	if($l_campo_trae[3]=="Texto Corto")
		$campo_campos.="<td>&nbsp;</td>";
	if($l_campo_trae[3]=="Texto Largo")
		$campo_campos.="<td>&nbsp;</td>";
	if($l_campo_trae[3]=="Moneda"){
		$campo_campos.="<td>&nbsp;</td>";
		}
		
		}//while
		?>
     
     <tr onMouseOver=this.className="tabla_menu_relover"; onMouseOut=this.className="";>
       <td colspan="<?=(6-$concatena_titulo_suma);?>" ><div align="right" class="titulos_evaluacion">Valor total de la oferta (Solo de esta lista y de todas las p&aacute;ginas):</div></td>
       <?=$campo_campos;?>
     </tr>
   </table>
<table width="98%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
     <tr>
       <td width="85%"><div align="right"><span class="texto_paginador_proveedor"><strong>Numero de p&aacute;ginas en esta lista:
               <?=$pagina;?>
       </strong></span></div></td>
       <td width="3%"><div align="center"><a href="javascript:paginacion_lista(<?=$anterior;?>)"> <img src="../imagenes/botones/arrow-left-16.gif" alt="P&aacute;gina anterior" width="14" height="13"></a></div></td>
       <td width="9%"><label>
         <select name="select2" onChange="javascript:paginacion_lista(this.value)">
           <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
           <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>P&aacute;gina
             <?=$i;?>
           </option>
           <? } ?>
         </select>
       </label></td>
       <td width="3%"><a href="javascript:paginacion_lista(<?=$proxima;?>)"> <img src="../imagenes/botones/arrow-right-16.gif" alt="P&aacute;gina Siguiente" width="14" height="13"></a></td>
     </tr>
   </table>
   <br>
   
   <?
   
   if($requiere_aui==1){
 $busca_aiu="select * from $t24 where pro1_id = $id_invitacion and pv_id = $us_cliente and pro11_id = $id_lista ";
   $sql_aui=traer_fila_row(query_db($busca_aiu));
   ?>
   <table width="98%" border="0" cellspacing="2" cellpadding="2">
     <tr>
       <td colspan="3" class="titulos_procesos">Valores para el calculo del AIU</td>
     </tr>
     <tr>
       <td width="17%"><div align="right">% Administraci&oacute;n:</div></td>
       <td width="19%"><label>
         <input type="text" name="administracion" id="textfield" value="<?=$sql_aui[4];?>">
       </label></td>
       <td width="64%">&nbsp;</td>
     </tr>
     <tr>
       <td><div align="right">% Imprevistos:</div></td>
       <td><input type="text" name="imprevisto" id="textfield2" value="<?=$sql_aui[5];?>"></td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td><div align="right">% Utilidad:</div></td>
       <td><input type="text" name="utilidad" id="textfield3" value="<?=$sql_aui[6];?>"></td>
       <td>&nbsp;</td>
     </tr>
   </table>
   <? } ?>
<br>
   
   <?

		$busca_procesos = "select cierre_economica from $t5 where pro1_id = $id_invitacion";
		$sql_e=traer_fila_row(query_db($busca_procesos));	
	
		if($sql_e[0]>=$fecha." ".$hora){//si esta dentro del tiempo   
   
   
   ?>
   
   <table width="98%" border="0" cellpadding="2" cellspacing="2">
     <tr>
       <td colspan="3"><div align="left">
         <p><img src="../librerias/jquery/menu1/help.gif" alt="Ayuda" width="18" height="18"> Por favor antes de enviar su oferta tenga en cuenta lo siguiente:</p>
         <ul>
           <? if($id_invitacion==9){?><li>Las cantidades estimadas para algunos items estan incluidas en el anexo numero 10 (Cantidad de servicios estimados), para analisis y presentaci&oacute;n de su oferta.</li><? } ?>
           <li>Para enviar su oferta econ&oacute;mica, verifique cuidadosamente la informaci&oacute;n ingresada y presione el bot&oacute;n &quot;Enviar Oferta Economica&quot;.</li>
           <li>Solo se grabara los &iacute;tems digitados en esta p&aacute;gina, una vez  grabado pase a la siguiente p&aacute;gina de esta lista e ingrese su oferta econ&oacute;mica.</li>
         </ul>
         </div></td>
     </tr>
     <tr>
       <td width="39%">&nbsp;</td>
       <td width="18%"><input name="button3" type="button" class="guardar" id="button3" value="Enviar Oferta Econ&oacute;mica" onClick="crea_ofertas()"></td>
       <td width="43%">&nbsp;</td>
     </tr>
     <?

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td align='center' class='titulo_tabla_azul_sin_bordes'>".$l_campo[2]."</td>";
	$numero++;
  													} 
	if($campo_mejor_oferta!=""){													
	$titulo_campos.="<td width='15%' align='center' class='titulo_tabla_azul_sin_bordes'>Estado de su Oferta</td>";	$numero+=1;											
	}
	
	$concatena_titulo = ($numero+5);												
													?>
   </table>
<br>
<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco_oferente">
  <tr>
    <td width="71%"><p align="left"><img src="../librerias/jquery/menu1/help.gif" alt="Ayuda" width="18" height="18"><strong> </strong>Para cargue masivo desde excel, descargue la plantilla diligencie los requerimientos solicitados y tenga en cuenta:</p>
      <ul>
        <li> No elimine columnas.</li>
        <li>En los requerimientos de valor o num&eacute;rico  NO digite texto</li>
        <li>No ponga formato a los valores digitados</li>
	 <li>Al subir las ofertas masivas guardar formato excel windows 97 / 2003</li>
      </ul>
      <div align="center">
        <input name="button4" type="button" class="calcular" id="button4" value="           Exportar reporte a excel" onClick="window.parent.location.href='exportaexcel_<?=$id_invitacion_pasa;?>_<?=$id_lista;?>.php'">
      </div></td>
  </tr>
  <?

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td align='center' class='titulo_tabla_azul_sin_bordes'>".$l_campo[2]."</td>";
	$numero++;
  													} 
	$titulo_campos.="<td width='15%' align='center' class='titulo_tabla_azul_sin_bordes'>Estado de su Oferta</td>";	$numero+=1;											
	
	$concatena_titulo = ($numero+5);												
													?>
</table>
<br>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco_oferente">
  <tr>
    <td width="33%"><p align="right"><strong><img src="../librerias/jquery/menu1/help.gif" alt="Ayuda" width="18" height="18"> Busque el archivo de excel con la oferta: 
        <label></label>
        <label></label>
    </strong></p>    </td>
    <td width="35%"><div align="center">
      <input type="file" name="archivo_lista" id="archivo_lista">
    </div></td>
    <td width="32%">
      <div align="center">
        <input name="button5" type="button" class="guardar" id="button5" onClick="sube_archivo()" value="Enviar oferta masiva desde excel">
      </div></td>
  </tr>
  <?

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td align='center' class='titulo_tabla_azul_sin_bordes'>".$l_campo[2]."</td>";
	$numero++;
  													} 
	$titulo_campos.="<td width='15%' align='center' class='titulo_tabla_azul_sin_bordes'>Estado de su Oferta</td>";	$numero+=1;											
	
	$concatena_titulo = ($numero+5);												
													?>
</table>


<? 
	}// si esta dentro del tiempo
}// si selecciona lista ?>
   <input type="hidden" name="id_lista" value="<?=$id_lista;?>">
   <input type="hidden" name="pa_requiere_aui" value="<?=$requiere_aui;?>">
   
   <input type="hidden" name="oferta" value="<?=$oferta;?>">
   <input type="hidden" name="pag" value="<?=$pag;?>">
   <input type="hidden" name="accion_crea">
   
<input type="hidden" name="id_invitacion_pasa" value="<?=$id_invitacion_pasa;?>">

   

<? if($tiene_consolidado==1){ ?>
<iframe name="actualiza_consolidado" height="0" width="0" frameborder="0" src="../aplicaciones/proveedores/frame_actualiza_consolidado.php?id_invitacion=<?=$id_invitacion;?>&id_lista=<?=$id_lista;?>&paginador=<?=$paginador;?>&numero_pagi=<?=$numero_pagi;?>"></iframe>
<? } ?>
</body>
</html>
