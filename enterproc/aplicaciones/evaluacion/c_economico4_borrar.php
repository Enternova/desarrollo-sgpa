<?  include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));



$oferta_vista = 1;   

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">

<script>
function calcula_valor()
	{
	var forma = document.formulario

			forma.action = "c_economico4.php";
			forma.submit();

	}



</script>

</head>
<body >
<br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco_oferente">
  <tr>
    <td colspan="5"><strong><img src="../librerias/jquery/menu1/help.gif" width="18" height="18">AYUDA:</strong>Seleccione de la siguiente lista la condicion econ&oacute;mica con la cual desea que el sistema le indique la mejor oferta por oferente:</td>
  </tr>
  <tr class="administrador_tabla_titulo">
    <td width="44%"><div align="right"><strong>Seleccione la condici&oacute;n econ&oacute;mica:</strong></div></td>
    <td width="6%"><label>
      <select name="campo_valos" id="select" >
        <?
		 $busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  in ('Valor', 'Numerico')");
			while($l_campo_trae = traer_fila_row($busca_campos_1)){	
			if($campo_valos==$l_campo_trae[0]) $c_sel = "selected"; else $c_sel="";
			 ?>
        <option value='<?=$l_campo_trae[0];?>' <?=$c_sel;?>>
          <?=$l_campo_trae[2];?>
        </option>
        <? } ?>
      </select>
    </label></td>
    <td width="18%"><div align="right"><strong>Parametro de selecci&oacute;n:</strong></div></td>
    <td width="14%"><select name="tipo_busq" id="tipo_busq">
      <option value='min' <? if($tipo_busq=="min")  echo "selected";?>>Minimo Valor</option>
      <option value='max' <? if($tipo_busq=="max") echo "selected";?>>Maximo Valor</option>
    </select></td>
    <td width="18%"><label>
       <input name="button" type="button" class="buttonverde" id="button" value="Generar Agrupamiento" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico4.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=' + document.principal.campo_valos.value + '&tipo_busq=' + document.principal.tipo_busq.value,'carga_evaluacion')">
    </label></td>
  </tr>
</table>
<br>
   <input type="hidden" name="accion">
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">


<? 
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

//-------------------------------------------------------------------------------------------------------------------------------
//CAMPOS
//-------------------------------------------------------------------------------------------------------------------------------
	
	if($campo_valos=="")
	$campo_buscado = $valor_ini;
	else
	$campo_buscado = $campo_valos;


  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td  class='divicion_tablas'><strong>".$l_campo[2]."</strong></td>";
	$numero++;
	$nombre_campo.=",campo_".$l_campo[0]." text not null";
	$nombre_campo2.=",campo_".$l_campo[0];
	
  													} 
?>

<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr  class="administrador_tabla_titulo">
    <td class="columna_titulo_resultados"><div align="center">Proveedor</div></td>
    <td class="columna_titulo_resultados"><div align="center">Items Solicitados</div></td>
    <td class="columna_titulo_resultados"> <div align="center">Items Cotizados</div></td>
    <td class="columna_titulo_resultados"><div align="center">Items Ganadores</div></td>
    <td class="columna_titulo_resultados"><div align="center">Valor Total Items Ganadores</div></td>
    <td class="columna_titulo_resultados"><div align="center">% Items Cotizados</div></td>
    <td class="columna_titulo_resultados"><div align="center">% Items Ganadores</div></td>
  </tr>

<?

	$tipo_busq = "min";
		$sql_tabla="CREATE TEMPORARY TABLE reporte_temp ( pv_id varchar(50) NOT NULL,
		valor varchar(50) NOT NULL,oferta varchar(50) NOT NULL,valor_total varchar(50) NOT NULL ) " ;
		$query_crea = query_db($sql_tabla);
													
function items_ganadores($nombre_campo,$oferta_vista,$campo_valos)
	{
	global $lista_oferentes,$cuenta_proveedores,$id_invitacion,$tabla_economica,$t95,$tipo_busq;

		
	
    $busca_campos = query_db("select * from $t95 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){ 
	$campo_campos=""; 
	
 	$busca_ganador=traer_fila_row(query_db("select $tipo_busq(w_valor*1) from $tabla_economica 
	 where  w_valor>=1 and evaluador5_id  = $l_campo[0] and evaluador4_id = $campo_valos  and oferta = $oferta_vista  group by evaluador5_id "));

	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	$campo_campos="";
	$campo_campos2="";
	
		$busca_valores_ing=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $campo_valos and oferta = $oferta_vista"));	
	
	
					if($busca_valores_ing[0]!=""){//si el campo tiene valor
										
										if(($busca_valores_ing[0]==$busca_ganador[0]) && ($busca_valores_ing[0]>=1)){
										$total_afectado= ($busca_valores_ing[0] * $l_campo[5] );
										//$total_afectado=  $l_campo[5] ;										
										$inserta_temporal = "insert into reporte_temp values ('$lista_oferentes[$yy]', '$busca_valores_ing[0]','$oferta_vista', '$total_afectado')";
										$sql_str=query_db($inserta_temporal);
										}
									}//si entra al campo seleccionado para el mejor valor
		
							
		}//for
		
		}//while
	
	}

	items_ganadores($nombre_campo,1,$campo_valos);

	$strCat = "<categories>";

	$cuenta_nu_articulos = traer_fila_row(query_db("select count(*) from $t95 where in_id = $linvi[0]"));
	$nombre_ofer = explode(",",$titulos_oferente);
	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	$busca_nu_ofertas = query_db("select distinct oferta from $tabla_economica where evaluador4_id = $campo_buscado and pv_id = $lista_oferentes[$yy]  ");




	while($rr=traer_fila_row($busca_nu_ofertas)){//ofertas
	$busca_nu_arti = traer_fila_row(query_db("select count(*), sum(w_valor) from $tabla_economica where evaluador4_id = $campo_buscado and pv_id = $lista_oferentes[$yy] and w_valor >=1 and oferta = $rr[0]"));
	$porcentaje = ($busca_nu_arti[0]/$cuenta_nu_articulos[0]) * 100;

	$select = traer_fila_row(query_db("select count(*), sum(valor_total) from reporte_temp where pv_id = '$lista_oferentes[$yy]' and oferta = '$rr[0]'"));

	$porcentaje_2 = ($select[0]/$cuenta_nu_articulos[0]) * 100;
	
	/*$strXML .="<dataset seriesName=' $nombre_ofer[$yy] oferta $rr[0] ' showValues='0'>";
	$strXML .= "<category label='Item Cotizados'/>";
	$strCat .= "<category label='Item Ganados'/>";

	$strXML .= "<set value='" . $porcentaje . "' />";
	$strXML .= "<set value='" . $porcentaje_2 . "' />";*/
	
	$strXML_ultima .= "<set label='" . $nombre_ofer[$yy]." oferta ".$rr[0] . "' value='" . number_format($porcentaje,2) . "' isSliced='" . $slicedOut . "' " . $strLink . " />";

	$strXML_ultima2.= "<set label='" . $nombre_ofer[$yy]." oferta ".$rr[0] . "' value='" . number_format($porcentaje_2,2) . "' isSliced='" . $slicedOut . "' " . $strLink . " />";
	
	//$strXML .="</dataset>";
?>  

  <tr   onMouseOver=this.className="tabla_menu_relover"; onMouseOut=this.className="";>
    <td><?=$nombre_ofer[$yy];?></td>
    <td align="center"><?=$cuenta_nu_articulos[0];?></td>
    <td align="center"><?=$busca_nu_arti[0];?></td>
    <td align="right"><?=$select[0];?></td>
    <td align="right"><?=number_format($select[1],0);?></td>
    <td align="center"><?=number_format($porcentaje,2);?> % </td>
    <td align="center"><?=number_format($porcentaje_2,2);?> %</td>
  </tr>
  
  <? 
  	} //ofertas 
	echo "<tr><td colspan='6'></td></tr>";
    
   
   } 
   
   //	$strCat .= "</categories>";
	//echo $strXML_datos= $strCat.$strXML;
		$strXML_datos =  $strXML_ultima;
		$strXML_datos2=  $strXML_ultima2;
   
   
   ?>
</table>




</body>
</html>
