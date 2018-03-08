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

			forma.action = "c_economico2.php";
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
      <input name="button" type="button" class="buttonverde" id="button" value="Generar Agrupamiento" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico2.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=' + document.principal.campo_valos.value + '&tipo_busq=' + document.principal.tipo_busq.value,'carga_evaluacion')">
    </label></td>
  </tr>
</table>
<br>
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
								$titulos_oferente.="'".$lc[1]."',"; 
				
																			}
					}//si tiene evaluacion tecnica
					else{//si no tiene tecnica
								$cuenta_proveedores+=1;
								$resutado_pro.= $lc[4].",";
								$titulos_oferente.="'".$lc[1]."',"; 
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

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td  class='titulo_tabla_azul_sin_bordes_reporte'><strong>".$l_campo[2]."</strong></td>";
	$numero++;
	$nombre_campo.=",campo_".$l_campo[0]." text not null";
	$nombre_campo2.=",campo_".$l_campo[0];
	
  													} 


//-------------------------------------------------------------------------------------------------------------------------------
//CAMPOS
//-------------------------------------------------------------------------------------------------------------------------------


		$sql_tabla="CREATE TEMPORARY TABLE reporte_temp ( pv_id varchar(50) NOT NULL,
		codigo varchar(50) NOT NULL,detalle text not null,medida varchar(50) NOT NULL,cantidad varchar(50) NOT NULL,
		moneda varchar(50) NOT NULL,presupuesto varchar(50) NOT NULL,ultima_compra varchar(50) NOT NULL $nombre_campo ) " ;
		$query_crea = query_db($sql_tabla);

		
    $busca_campos = query_db("select * from $t95 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){ 
	$campo_campos=""; 
	
 	$busca_ganador=traer_fila_row(query_db("select $tipo_busq(w_valor*1) from $tabla_economica 
	 where  w_valor>=1 and evaluador5_id  = $l_campo[0] and evaluador4_id = $campo_valos  and oferta = $oferta_vista  group by evaluador5_id "));
	
	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	$campo_campos="";
	$campo_campos2="";
	$busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion");
	while($l_campo_trae = traer_fila_row($busca_campos_1)){//while de los campos
	
	
					$busca_valores_ing=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $l_campo_trae[0] and oferta = $oferta_vista"));
						
						if($busca_valores_ing[0]!=""){//si el campo tiene valor
						$campo_campos.=",'$busca_valores_ing[0]'";
						
								if($l_campo_trae[0]==$campo_valos)
									{//si entra al campo seleccionado para el mejor valor
										
										if(($busca_valores_ing[0]==$busca_ganador[0]) && ($busca_valores_ing[0]>=1)){
											$campo_campos2=",'SI'";
											$total_afectado= number_format(($busca_valores_ing[0] * $l_campo[5] ),2);
											}
										else
											$campo_campos2=",'NO'";
									}//si entra al campo seleccionado para el mejor valor
		
							
						}//si el campo tiene valor
							else
								$campo_campos.=",'&nbsp'";
		
	}//while de los campos
		if($campo_campos2==",'SI'"){
		$arrglo_insertar = $nombre_oferentes[$yy].',"'.$l_campo[2].'","'.$l_campo[3].'","'.$l_campo[4].'","'.$l_campo[5].'","'.$l_campo[6].'"," ","'.$total_afectado.'"'.$campo_campos;		$arrglo_insertar."<br>";
		$inserta_temporal = "insert into reporte_temp values (".$arrglo_insertar.")";
		$sql_str=query_db($inserta_temporal);
		
		}
	}//for oferentes


} 

		$sql_exc = "select distinct pv_id from reporte_temp order by pv_id";
		$query_exc=query_db($sql_exc);
		while($l_p=traer_fila_row($query_exc)){//while general
		
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="administrador_tabla_generales1">
  <tr>
    <td class="administrador_tabla_titulo1"><div align="left"><?=$l_p[0];?></div></td>
  </tr>
</table>

<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td  class='titulo_tabla_azul_sin_bordes_reporte'>CODIGO</td>
    <td class='titulo_tabla_azul_sin_bordes_reporte'>DETALLE</td>
    <td class='titulo_tabla_azul_sin_bordes_reporte'>MEDIDA</td>
    <td class='titulo_tabla_azul_sin_bordes_reporte'>CANTIDAD</td>
    <td class='titulo_tabla_azul_sin_bordes_reporte'>MONEDA</td>

   <td class='titulo_tabla_azul_sin_bordes_reporte'></td>
    <td class='titulo_tabla_azul_sin_bordes_reporte'>V. Total</td>    
    <?=$titulo_campos;?>
  </tr>

<? 
		$sql_exc2 = "select codigo,detalle,medida,cantidad,moneda,presupuesto,ultima_compra $nombre_campo2  from reporte_temp where pv_id = '$l_p[0]' ";
		$query_exc2=query_db($sql_exc2);
		while($l_p2=mysql_fetch_array($query_exc2,MYSQL_ASSOC)){//while general
?>
  <tr>
<? $campos = "<td  class='divicion_tablas'>".implode("<td  class='divicion_tablas'>", $l_p2); $impresion_re = str_replace("<br>","",$campos); echo $impresion_re; ?>
  </tr>
<? } ?>
</table>

<br>
<br>
<? } ?>




</body>
</html>
