<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	

	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_item_pecc_marco =$sel_item[26];
	$id_tipo_proceso_pecc = $sel_item[20];
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	$edicion_datos_generales = "NO";
	if(verifica_permiso_pecc($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
		
		
		
	?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      
    
    
    
    
    
   
    
    
    
    

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top">
    
    <?
          if ($edicion_datos_generales == "SI"){
		  ?>
    <div id="carga_presupuesto">
  <?
    }
	
$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $g15.t1_campo_id from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
?>
  <div id="carga_edita_presupuesto"></div>

<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="6" align="center"  class="fondo_3">Lista de Valores de esta Solictud</td>
    </tr>
  <tr>
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td width="16%" align="center" class="fondo_3">Contrato(s) Marco</td>
    <?
			}
		  ?>
    <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="24%" align="center" class="fondo_3">&Aacute;rea</td>
    <td width="19%" align="center" class="fondo_3">Valor USD$</td>
    <td width="19%" align="center" class="fondo_3">Valor COP$</td>
    <td width="14%" align="center" class="fondo_3">Ver Adjunto</td>
    </tr>
  <?
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
  <tr class="<?=$clase?>">
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
				$int_contratos = 0;
		?>
    <td align="center"><?
          	$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					echo "* ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4)."<br />";
			$int_contratos = $int_contratos.",".$sel_apl[3];
			}
		  ?></td>
    <?
			}
			
			$int_anos = $int_anos.",".$sel_presu[1];
			$int_campos = $int_campos.",".$sel_presu[6];
			
		  ?>
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?=$sel_presu[2]?></td>
    <td align="center" ><?=number_format($sel_presu[4],0)?></td>
    <td align="center"><?=number_format($sel_presu[5],0)?></td>
    <td align="center"> <? if($sel_presu[3] != " "){?><?=saca_nombre_anexo($sel_presu[3])?>
                  <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" />
                  </a><? }?></td>
    </tr>
  <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
</table>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr class="titulos_resumen_alertas">
          <td width="23%" align="right">Total Equivalente USD$:</td>
          <td width="13%" align="left"><?=number_format($total_equivale_usd)?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="6" align="center"  class="fondo_3">Crear Devoluciones</td>
  </tr>
  <tr>
    <td width="20%"><?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
      <select name="aplica_contrato" id="aplica_contrato" onchange="carga_contratos_sin_valores(this.value,<?=$id_item_pecc?>)">
        <option value="">Selecci&oacute;n de Contratos</option>
       
       
        <?
		  
            	$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc_marco." and t1_tipo_documento_id = 2 and id_contrato in (0$int_contratos)");
				while($sel_cont = traer_fila_db($sele_contratos)){
					$numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					$numero_contrato4 = $sel_cont[3];
			?>
        <option value="<?=$sel_cont[0]?>">
          <?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)?>
          </option>
        <?
				}
			?>
      </select>
      <?
			}
		?></td>
    <td width="12%" align="center"><select name="ano" id="ano">
      <option value="0">A&Ntilde;O</option>
      <option value="2013">2013</option>
      <option value="2014">2014</option>
      <option value="2015">2015</option>
      <option value="2016">2016</option>
    </select></td>
    <td width="16%"><select name="campo" id="campo">
      <option value="">&Aacute;rea</option>
      <?=listas_sin_seleccione($g15, " estado = 1 and t1_campo_id in (0$int_campos)",0 ,'nombre', 2);?>
    </select></td>
    <td width="14%" align="right">Valor USD$:</td>
    <td width="25%"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
    <td width="13%" rowspan="3"><input name="button2" type="button" class="boton_grabar" id="button2" value="Devolver" onclick="graba_devolucion()" /></td>
  </tr>
  <tr>
    <td align="right">Agregar Anexo:</td>
    <td colspan="2" align="right"><input type="file" name="file1" id="file1" /></td>
    <td align="right">Valor COP$:</td>
    <td><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
  </tr>
  <tr>
    <td colspan="4" align="right"><div id="carga_contratos_aplica"></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" align="center" class="fondo_3">Historico de Devoluciones</td>
    </tr>
  <tr>
    <td width="15%" align="center" class="fondo_3">Contrato(s) Marco</td>
    <td align="center" class="fondo_3">A&ntilde;o</td>
    <td align="center" class="fondo_3">&Aacute;rea</td>
    <td align="center" class="fondo_3">Valor USD$</td>
    <td align="center" class="fondo_3">Valor COP$</td>
    </tr>
  <?
  	$sel_devolucione = query_db("select * from t2_devolucion where id_item = ".$id_item_pecc);
	while($dev = traer_fila_db($sel_devolucione)){
		
		 $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$dev[7]));
		  $numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_contrato[0]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[1];
					$numero_contrato4 = $sel_contrato[2];
  ?>  
  <tr>
    <td align="center"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)?></td>
    <td align="center"><?=$dev[3]?></td>
    <td align="center"><?=saca_nombre_lista($g15,$dev[2],'nombre','t1_campo_id')?></td>
    <td align="center"><?=number_format($dev[4],0)?></td>
    <td align="center"><?=number_format($dev[5],0)?></td>
  </tr>
  <?
	}
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
    </div>
</td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_item_pecc_real" id="id_item_pecc_real" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc_marco" id="id_item_pecc_marco" value="<?=$id_item_pecc_marco?>" />
<input type="hidden" name="id_trm_aplica" id="id_trm_aplica" value="<?=$sel_item[15]?>" />
<input type="hidden" name="id_presupuesto_elimina" id="id_presupuesto_elimina" value="" />
<input type="hidden" name="id_pecc" id="id_pecc" value="<?=$id_pecc?>" />
<?
//imprime_para_comparar();
?>
</body>
</html>
