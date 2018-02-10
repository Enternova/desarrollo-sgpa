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
    <td width="71%" valign="top">
    <?
    	if($sel_item[6] == 4 or $sel_item[6] == 5){
			
				$id_contrato_carr = $sel_item[21];
				if($id_contrato_carr != ""){
				?>
                <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="3" align="center"  class="fondo_3">Valor Inicial del Contrato</td>
        </tr>
      <tr>
    
        <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="24%" align="center" class="fondo_3">&Aacute;rea</td>
        <td width="19%" align="center" class="fondo_3">Valor Equibalente USD$</td>
        </tr>
      <?
	  $sele_presupuesto = query_db("select ano, nombre_campo,eq_usd from $vpeec19 where id_contrato =".$id_contrato_carr);
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[2];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
      <tr class="<?=$clase?>">
       
        <td align="center"><?=$sel_presu[0]?></td>
        <td align="center"><?=$sel_presu[1]?></td>
        <td align="center" ><?=number_format($sel_presu[2],0)?></td>
        </tr><?
			}
			$total_equivale_usd = $total_equivale_usd +$valor_total_usd ;
		?>
      <tr>
        <td colspan="2" align="left"><img src="../imagenes/botones/aviso_observaciones.png" alt="" width="16" height="16" /><strong>ATENCION:</strong><span class="titulos_resumen_alertas">El valor actual del contrato se sumara a esta solicitud para generar el camino que debe tomar en cuanto a firmas en el sistema, firma del comit&eacute; interno y firma de los socios entre otros.	</span></td>
        <td align="center" class="titulos_resumen_alertas"><?=number_format($total_equivale_usd)?></td>
        </tr>
      
    </table>
    
    
                <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
                  <tr>
                    <td colspan="3" align="center"  class="fondo_3">Valor de los Otro Si</td>
                  </tr>
                  <tr>
                    <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
                    <td width="24%" align="center" class="fondo_3">&Aacute;rea</td>
                    <td width="19%" align="center" class="fondo_3">Valor Equibalente USD$</td>
                  </tr>
                  <?
	  $sele_presupuesto = query_db("select ano, nombre_campo,eq_usd from $vpeec24 where id_contrato =".$id_contrato_carr." and t2_item_pecc_id < ".$id_item_pecc);
	$valor_total_usd = 0;
	$valor_total_cop = 0;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[2];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
                  <tr class="<?=$clase?>">
                    <td align="center"><?=$sel_presu[0]?></td>
                    <td align="center"><?=$sel_presu[1]?></td>
                    <td align="center" ><?=number_format($sel_presu[2],0)?></td>
                  </tr>
                  <?
			}
			$total_equivale_usd = $total_equivale_usd +$valor_total_usd ;
		?>
                  <tr>
                    <td colspan="2" align="left">&nbsp;</td>
                    <td align="center" class="titulos_resumen_alertas"><?=number_format($total_equivale_usd)?></td>
                  </tr>
                </table>
<br />
                
                
				<?
				}
		}
?>
    <?
          if ($edicion_datos_generales == "SI"){
		  ?>	<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="6" align="center"  class="fondo_3">Agregar Valor <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
      </tr>
      <tr>
        <td width="20%">
         <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
        <select name="aplica_contrato" id="aplica_contrato" onchange="carga_contratos_sin_valores(this.value,<?=$id_item_pecc?>)">
        	<option value="">Selecci&oacute;n de Contratos</option>
           
           <?
           if($id_tipo_proceso_pecc == 2){
		   ?>
            <option value="0">Uno &oacute; Varios SIN Valores Especificos</option>
            
            <?
		   }
            	$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$id_item_pecc_marco." and t1_tipo_documento_id = 2");
				while($sel_cont = traer_fila_db($sele_contratos)){
					$numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
			?>
            <option value="<?=$sel_cont[0]?>"><?=numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)?></option>
            <?
				}
			?>
        </select>
        <?
			}
		?>
        </td>
        <td width="12%" align="center">
        
          <select name="ano" id="ano">
          
            <option value="0">A&Ntilde;O</option>
			
						
					
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
          </select>
         
          </td>
        <td width="16%"><select name="campo" id="campo">
          <option value="">&Aacute;rea</option>
          <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
        </select></td>
        <td width="14%" align="right">Valor USD$:</td>
        <td width="25%"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        <td width="13%" rowspan="3"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar" onclick="graba_presupuesto_nuevo_edicion()" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="right">Adjunto:</td>
        <td><input name="adjunt_presu" type="file" id="adjunt_presu" size="5" /></td>
        <td align="right">Valor COP$:</td>
        <td><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
      </tr>
      <tr>
        <td colspan="4" align="right"><div id="carga_contratos_aplica"></div></td>
        <td>&nbsp;</td>
        </tr>
    </table>
      <div id="carga_presupuesto">
<?
    }
	
$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
?>
<div id="carga_edita_presupuesto"></div>

<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="7"><div id="carga_edita_presupuesto"></div></td>
  </tr>
  <tr>
    <td colspan="7" align="center"  class="fondo_3">Lista de Valores</td>
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
    <td width="8%" align="center" class="fondo_3">Acciones</td>
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
		?>
    <td align="center"><?
          	$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					echo "* ".numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)."<br />";
			}
		  ?></td>
    <?
			}
		  ?>
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?=$sel_presu[2]?></td>
    <td align="center" ><?=number_format($sel_presu[4],0)?></td>
    <td align="center"><?=number_format($sel_presu[5],0)?></td>
    <td align="center"> <? if($sel_presu[3] != " "){?><?=saca_nombre_anexo($sel_presu[3])?>
                  <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" />
                  </a><? }?></td>
    <td align="center">
    <?
    if ($edicion_datos_generales == "SI"){
	?>
    <img src="../imagenes/botones/editar.jpg" width="14" height="15" alt="Editar" title="Editar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?id_tipo_proceso_pecc='+document.principal.id_tipo_proceso_pecc.value+'&tipo_ajax=6&id_presupuesto=<?=$sel_presu[0]?>&id_item_pecc_marco='+document.principal.id_item_pecc_marco.value,'carga_edita_presupuesto')" style="cursor:pointer">
    
    
    <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto(<?=$sel_presu[0]?>)" />
    <?
	}
	?>
    </td>
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
</div>
</td>
    <td width="29%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
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
