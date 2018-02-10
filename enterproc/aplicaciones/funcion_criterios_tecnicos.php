<?
function lista_criterios_seleccion($tipo){	

global $t89,$complemento,$v3 ,$t12,$id_invitacion,$suma_apa_categorias,$t90,$t91,$sql_e;
	

   $lista_licitaciones = "select distinct rel9_id, rel9_detalle from $v3 where  rel9_estado=1 and rel9_aspecto = 2 and ( tp6_id = $id_invitacion or proc1_id = $id_invitacion or cl_id = 100000)";
	$linvi=query_db($lista_licitaciones);
	$num_fila=0;
	while($li=traer_fila_row($linvi)){//imprime categorias
	$valor_categorias=0;
	
  	$bus_his_categorias = traer_fila_row(query_db("select *  from $t12 where proc1_id = $id_invitacion and  rel9_id =$li[0]"));
	$valor_categorias = $bus_his_categorias[3];//porcentaje de la categoria
	$suma_apa_categorias+=$valor_categorias;// porcentaje total de categorias

	
?>
<link href="../css/principal.css" rel="stylesheet" type="text/css">
<table width="99%" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td width="22%" class="columna_subtitulo_resultados"><div align="right"> 
      <?=LENG_557;?>
    </div></td>
    <td width="63%"><strong><?=$li[1];?></strong></td>
    <td width="15%"><div align="right"></div></td>
  </tr>
  <? if($tipo==27){ ?>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right">Porcentaje de la categoria:</div></td>
    <td><input name="valor_catego[<?=$li[0];?>]" type="text" class="re_eco3"  onfocus="document.principal.valor_actual.value = this.value" onchange="suma_valores_tecnicos(this,document.principal.suma_evluacion_total)" value="<?=$valor_categorias;?>" /> </td>
    <td>&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><?=LENG_100;?>:</div></td>
    <td><input name="nombre_criterio_<?=$li[0];?>" type="text" value="<?=$linvi[2];?>" /></td>
    <td><div align="right"><input name="Submit" type="button" class="guardar" onclick="crea_criterios_evaluacion(<?=$li[0];?>,document.principal.nombre_criterio_<?=$li[0];?>)" value="<?=LENG_99;?>" /></div></td>
  </tr>
  <tr>
    <td colspan="3" class="columna_titulo_resultados"><?=LENG_108;?></td>
  </tr>
  <tr>
    <td colspan="3"><table width="99%" border="0" cellspacing="3" cellpadding="3">
      <tr>
        <td width="9%" class="titulo_tabla_azul_sin_bordes">Porcentaje</td>
        <td width="83%" class="titulo_tabla_azul_sin_bordes">Detalle del criterio</td>
        </tr>

   <?
  	$suma_apa=0;
	$valor = "";
	$lista_criterios = "select * from $t90 where rel9_id = $li[0] and rel10_estado=1";
	$linvi_cri=query_db($lista_criterios);


	while($lcri=traer_fila_row($linvi_cri)){//imprime criterios
	$campo_accion="";
	
  	$bus_his = traer_fila_row(query_db("select *  from $t91 where in_id = $id_invitacion and  rel10_id =$lcri[0]"));
	if($bus_his[0]>=1) $valor_sel = "checked";
	else  $valor_sel = "";
	/*si es porcentaje cuadra valores*/
	$valor = $bus_his[3];
	$suma_apa+=$valor;	
	/*si es porcentaje cuadra valores*/	

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
				
	if($tipo==27){//si es porncenje imprime text
		$campo_accion = "<input class='re_eco3' name='valorcriteri_".$li[0]."[".$lcri[0]."]' type='text' onFocus='document.principal.valor_actual.value = this.value' onChange='suma_valores_tecnicos(this,document.principal.suma_criterio_".$li[0].")' value='".$valor."' size='3'>";
	}//si es porncenje imprime text
	if($tipo==26){//si es porncenje imprime text
		$campo_accion = "<input type='checkbox' name='criterio_tecnico[".$lcri[0]."]' value='".$li[0]."' ".$valor_sel." >";
	}//si es porncenje imprime text
	if($tipo==25){//si es porncenje imprime text
		$campo_accion = "<input type='checkbox' name='criterio_tecnico[".$lcri[0]."]' value='".$li[0]."' ".$valor_sel." >";
	}//si es porncenje imprime text

				
?>      
      
      
      <tr class="<?=$class;?>">
        <td><?=$campo_accion;?></td>
        <td><?=$lcri[2];?></td>
        </tr>


         <? $num_fila++;} //imprime criterios
		  
		  
		   ?>  
     <? if($tipo==27){ ?>
      <tr class="<?=$class;?>">
        <td><input name="suma_criterio_<?=$li[0];?>" type="text" class="re_eco3" value="<?=$suma_apa;?>" size="3" readonly="readonly" /></td>
        <td>&nbsp;</td>
        </tr>
     <? } ?>               
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<? } //imprime categorias 
	 
?>



<?
	
	}//final funcion
?>