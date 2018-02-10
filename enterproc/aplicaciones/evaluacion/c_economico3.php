<? include("../../librerias/lib/@session.php");

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones)); 

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

			forma.action = "c_economico3.php";
			forma.submit();

	}



</script>

</head>
<body >
 <form name="formulario" method="post" action="" enctype="multipart/form-data" >
   <br>

  <?

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos1.="<td><strong>".$l_campo[2]."</strong></td>";
	$numero_CAMPOS++;
	$numero++;
  													} $concatena_titulo = ($numero+5);
	$titulo_campos=$titulo_campos1."<td><strong>Mejor Oferta</strong></td>";
													
	 $cuenta_proveedores=0;
	$busca_vaor_tecnica = traer_fila_row(query_db("select * from $t93 where in_id = $id_invitacion and evaluador3_termino = 2"));
	$valor_economica = (100-$busca_vaor_tecnica[4]);


	$busca_respo = query_db("select $t7.pro1_id, $t8.razon_social , $t8.nit , $t8.pv_id,$t8.pv_id from $t7,$t8 where $t7.pro1_id  = $id_invitacion and $t8.pv_id = $t7.pv_id ");
		while($lc=traer_fila_row($busca_respo)){
		if($busca_vaor_tecnica[3]>=1)
				{//si tiene evaluacion tecnica
			
			$bus_his = traer_fila_row(query_db("select count($t98.evaluador7_valor), sum($t98.evaluador7_valor)  from $t98,$t91 where $t91.in_id = $id_invitacion 
			and $t98.pv_id = $lc[4] and $t91.evaluador1_id  = $t98.evaluador1_id group by $t91.in_id"));   
						$operacion_aceptacion = ($bus_his[1]/$bus_his[0]);
							if($operacion_aceptacion>=$busca_vaor_tecnica[3]){//si el proveedor es aceptado
									$cuenta_proveedores+=1;
									$resutado_pro.= $lc[4].",";
									$titulos_oferente.="<td colspan=".($numero + 1)." class='administrador_tabla_titulo'>".$lc[1]."</td>"; 
				
																			}
					}//si tiene evaluacion tecnica
					else{//si no tiene tecnica
									$cuenta_proveedores+=1;
									$resutado_pro.= $lc[4].",";
									$titulos_oferente.="<td colspan=".($numero + 1)." class='administrador_tabla_titulo'>".$lc[1]."</td>"; 
				
																			}
																			
		
		}	
		$lista_oferentes = explode(",",$resutado_pro);												
													?>
   <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="administrador_tabla_generales1">
     <tr>
       <td colspan="5"><strong><img src="../../../../librerias/dhtml/menu1/help.gif" width="18" height="18">AYUDA:</strong>Seleccione de la siguiente lista la condicion econ&oacute;mica con la cual desea que el sistema le indique la mejor oferta por oferente:</td>
     </tr>
     <tr class="administrador_tabla_titulo">
       <td width="24%"><div align="right"><strong>Seleccione la condici&oacute;n econ&oacute;mica:</strong></div></td>
       <td width="27%"><label>
         <select name="campo_valos" id="select">
         <?
		 $busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  = 'Numerico'");
			while($l_campo_trae = traer_fila_row($busca_campos_1)){

			
			if($campo_valos==$l_campo_trae[0]) {$c_sel = "selected"; $titulo_campos2 ="<td align='center'><strong>".$l_campo_trae[2]."</strong></td>";} else $c_sel="";
			 ?>
            <option value='<?=$l_campo_trae[0];?>' <?=$c_sel;?>><?=$l_campo_trae[2];?></option>
            <? } ?>
         </select>
       </label></td>
       <td width="18%"><div align="right"><strong>Parametro de selecci&oacute;n:</strong></div></td>
       <td width="14%"><select name="tipo_busq" id="tipo_busq">
         <option value='min' <? if($tipo_busq=="min")  echo "selected";?>>Minimo Valor</option>
         <option value='max' <? if($tipo_busq=="max") echo "selected";?>>Maximo Valor</option>
       </select></td>
       <td width="17%"><label>
         <input name="button" type="button" class="buttonverde" id="button" value="Generar Agrupamiento" onClick="calcula_valor()">
       </label></td>
     </tr>
   </table>
   <br>
<?
//---------------------------------------------------------------------------------------------------------------
//REORTE CONSOLIDADO
//---------------------------------------------------------------------------------------------------------------

if($tipo_busq=="min") $orden = "asc"; else $orden = "desc";

 $sql_maximo_valor="select sum(w_valor) as valor,pv_id from $tabla_economica where $tabla_economica.evaluador4_id = $campo_valos and pv_id in ($resutado_pro 0)
group by pv_id order by valor $orden";

$BUSCA_MAXIMO_VALOR=traer_fila_row(query_db($sql_maximo_valor));
?>   
   
   <table width="100%" border="0" cellpadding="3" cellspacing="3" class="administrador_tabla_generales1">
     <tr>
       <td rowspan="2" class="administrador_tabla_titulo1">OFERENTES</td>
       <td rowspan="2" class="administrador_tabla_titulo1">VALOR ECON&Oacute;MICO ESPERADO</td>
       <td rowspan="2" class="administrador_tabla_titulo1">VALOR ECON&Oacute;MICO OBTENIDO</td>
       <td rowspan="2" class="administrador_tabla_titulo1">PRESUPUESTO</td>
       <td rowspan="2" class="administrador_tabla_titulo1">VALOR ULTIMA COMPRA</td>
       <td class="administrador_tabla_titulo1">CONDICIONES ECON&Oacute;MICAS</td>
     </tr>
     <tr>
       <?=$titulo_campos2;?>
     </tr>
<?
	$busca_proveedores = query_db($sql_maximo_valor);
	while($lista_proveedores_ac=traer_fila_row($busca_proveedores)){
	$busca_nombre_proveedor = traer_fila_row(query_db("select pv_nombre from $t13 where pv_id = $lista_proveedores_ac[1]"));
	//--------------------------------------------------------------------------
	//BUSCA ARTICULOS
  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion");
	$valor_suma_total=0;
	$suma_presupuesto=0;
	$suma_ultima_compra=0;
	
	while($l_campo = traer_fila_row($busca_campos))
		{//LISTA ARTICULOS 
			$campo_campos="";
						$busca_valores_ing=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_proveedores_ac[1] and evaluador5_id  = $l_campo[0] and evaluador4_id = $campo_valos"));
							if($busca_valores_ing[0]!="")
								$valor_suma_total+=$busca_valores_ing[0];							
							else
								$valor_suma_total.="0";
								
								
								$suma_presupuesto+=$l_campo[8];
								$suma_ultima_compra+=$l_campo[7];
		}//LISTA ARTICULOS

						$campo_campos = "<td >".number_format($valor_suma_total,0)."</td>";
						$resultado_obtenido = ($BUSCA_MAXIMO_VALOR[0]/$valor_suma_total) * $valor_economica; 

	//--------------------------------------------------------------------------
	//BUSCA ARTICULOS

	echo"<tr";
		if ($num_fila%2==0) echo " class='administrador_tabla_titulo_sec'"; //si el resto de la división es 0 pongo un color
		else echo "";
    echo ">"; //si el resto de la división NO es 0 pongo otro color 


?>     
 
       <td><?=$busca_nombre_proveedor[0];?></td>
       <td align="center"><?=$valor_economica;?></td>
       <td align="center"><?=number_format($resultado_obtenido,2);?></td>
       <td><?=number_format($suma_presupuesto,0);?></td>
       <td><?=number_format($suma_ultima_compra,0);?></td>
       <?=$campo_campos;?>
     </tr>
     
<? $num_fila++;} ?>     

   </table>

<?
//---------------------------------------------------------------------------------------------------------------
//REORTE CONSOLIDADO
//---------------------------------------------------------------------------------------------------------------

?>   
   
   <br>
   <table  border="0" align="center" cellpadding="2" cellspacing="2" class="administrador_tabla_generales1">
     <tr>
       <td colspan="5"><span class="titulosec1">TERMINOS ECONOMICOS</span></td>
       <?=$titulos_oferente;?>
     </tr>
     <tr class='administrador_tabla_titulo'>
       <td width="8%"><strong>Codigo</strong></td>
       <td width="45%"><strong>detalle</strong></td>
       <td width="10%"><strong>Medida</strong></td>
       <td width="7%"><strong>Cantidad</strong></td>
       <td width="7%"><strong>Moneda</strong></td>
		<?
        for($yy=0;$yy<$cuenta_proveedores;$yy++)
		echo $titulo_campos;
		?>
     </tr>
     <?

	 

  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){ 
	$campo_campos=""; 

 	$busca_ganador=traer_fila_row(query_db("select $tipo_busq(w_valor) from $tabla_economica 
	 where  w_valor>=1 and evaluador5_id  = $l_campo[0] and evaluador4_id = $campo_valos  group by evaluador5_id "));
	
	$campo_formateado=str_replace("id_articulo",$l_campo[0],$campo_campos);
	for($yy=0;$yy<$cuenta_proveedores;$yy++){//for oferentes
	$busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion");
	while($l_campo_trae = traer_fila_row($busca_campos_1)){
	
	
	$busca_valores_ing=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $lista_oferentes[$yy] and evaluador5_id  = $l_campo[0] and evaluador4_id = $l_campo_trae[0]"));
		if($busca_valores_ing[0]!=""){
		$campo_campos.="<td class='divicion_tablas'>$busca_valores_ing[0]</td>";
			if($l_campo_trae[0]==$campo_valos)
				{
					if($busca_valores_ing[0]==$busca_ganador[0])
						$campo_campos2="<td class='divicion_tablas'><strong>SI</strong></td>";
					else
						$campo_campos2="<td class='divicion_tablas'>NO</td>";
				}//si entra al campo seleccionado para el mejor valor
		
		}
		else
		$campo_campos.="<td class='divicion_tablas'>&nbsp;</td>";
		}//while de los campos

		$campo_campos.=$campo_campos2;
	}//for oferentes




	
	echo"<tr";
		if ($num_fila%2==0) echo " class='administrador_tabla_titulo_sec'"; //si el resto de la división es 0 pongo un color
		else echo "";
    echo ">"; //si el resto de la división NO es 0 pongo otro color 
	?>
     
       <td class='divicion_tablas'><?=$l_campo[2];?></td>
       <td class='divicion_tablas'><?=$l_campo[3];?></td>
       <td class='divicion_tablas'><?=$l_campo[4];?></td>
       <td class='divicion_tablas'><?=$l_campo[5];?></td>
       <td class='divicion_tablas'><?=$l_campo[6];?></td>
		<?=$campo_campos;?>
     </tr>
     <? $num_fila++;} ?>
   </table>
   <input type="hidden" name="accion">
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
</form>
<iframe name="grp" width="400" height="400" frameborder="0"></iframe>
</body>
</html>
