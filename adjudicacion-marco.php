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
	
	
	$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
	if(verifica_permiso_adjudicacion($sel_item[14], $sel_item[0]) == "SI" or ($sel_item[6]== 15 and ($sel_item[3]==$_SESSION["id_us_session"] or $sel_usu_emulan[0] > 0 ) and $sel_item[14] == 31)){//el or es para que active la edicion para las modificaciones
			$edicion_datos_generales = "SI";
		}
		
		
		$tiene_rol_profesional = verifica_usuario_si_tiene_el_permiso(8);
		
		
		
if($sel_item[17]==""){
$trm_actual=trm_presupuestal(2015);	
	}else{
$trm_actual=trm_presupuestal($sel_item[17]);
	}
	
	$sel_pecc[0] = $trm_actual;
	
	/*SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO del permiso, para procesos de modificaciones y adhudicaciones con sondeo*/
	
	
	$busvca_tex = traer_fila_row(query_db("select CAST(p_oportunidad as TEXT), CAST(p_costo AS TEXT), CAST(p_calidad AS TEXT), CAST(p_optimizar AS TEXT), CAST(p_trazabilidad AS TEXT), CAST(p_transparencia AS TEXT), CAST(p_sostenibilidad AS TEXT) from t2_objetivos_proceso where id_item = ".$id_item_pecc));
	$p_oportunidad="";
	$p_costo="";
	$p_calidad="";
	$p_optimizar="";
	$p_trazabilidad="";
	$p_transparencia="";
	$p_sostenibilidad="";
	
		    if($busvca_tex[0]!="" and $busvca_tex[0]!=" " and $busvca_tex[0]!="  "){$p_oportunidad=$busvca_tex[0];}
			if($busvca_tex[1]!="" and $busvca_tex[1]!=" " and $busvca_tex[1]!="  "){$p_costo=$busvca_tex[1];}
			if($busvca_tex[2]!="" and $busvca_tex[2]!=" " and $busvca_tex[2]!="  "){$p_calidad=$busvca_tex[2];}
			if($busvca_tex[3]!="" and $busvca_tex[3]!=" " and $busvca_tex[3]!="  "){$p_optimizar=$busvca_tex[3];}
			if($busvca_tex[4]!="" and $busvca_tex[4]!=" " and $busvca_tex[4]!="  "){$p_trazabilidad=$busvca_tex[4];}
			if($busvca_tex[5]!="" and $busvca_tex[5]!=" " and $busvca_tex[5]!="  "){$p_transparencia=$busvca_tex[5];}
			if($busvca_tex[6]!="" and $busvca_tex[6]!=" " and $busvca_tex[6]!="  "){$p_sostenibilidad=$busvca_tex[6];}
			
	/*SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO del permiso, para procesos de modificaciones y adhudicaciones con sondeo*/
		
		/*SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO*/
	
		
	$busvca_tex = traer_fila_row(query_db("select CAST(a_oportunidad AS TEXT), CAST(a_costo AS TEXT), CAST(a_calidad AS TEXT), CAST(a_optimizar AS TEXT), CAST(a_trazabilidad AS TEXT), CAST(a_transparencia AS TEXT), CAST(a_sostenibilidad AS TEXT) from t2_objetivos_proceso where id_item = ".$id_item_pecc));
	$p_oportunidad="";
	$p_costo="";
	$p_calidad="";
	$p_optimizar="";
	$p_trazabilidad="";
	$p_transparencia="";
	$p_sostenibilidad="";
	
		    if($busvca_tex[0]!="" and $busvca_tex[0]!=" " and $busvca_tex[0]!="  "){$p_oportunidad=$busvca_tex[0];}
			if($busvca_tex[1]!="" and $busvca_tex[1]!=" " and $busvca_tex[1]!="  "){$p_costo=$busvca_tex[1];}
			if($busvca_tex[2]!="" and $busvca_tex[2]!=" " and $busvca_tex[2]!="  "){$p_calidad=$busvca_tex[2];}
			if($busvca_tex[3]!="" and $busvca_tex[3]!=" " and $busvca_tex[3]!="  "){$p_optimizar=$busvca_tex[3];}
			if($busvca_tex[4]!="" and $busvca_tex[4]!=" " and $busvca_tex[4]!="  "){$p_trazabilidad=$busvca_tex[4];}
			if($busvca_tex[5]!="" and $busvca_tex[5]!=" " and $busvca_tex[5]!="  "){$p_transparencia=$busvca_tex[5];}
			if($busvca_tex[6]!="" and $busvca_tex[6]!=" " and $busvca_tex[6]!="  "){$p_sostenibilidad=$busvca_tex[6];}
			
	/*FIN SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO*/
	
	
	 // Validacion para solicitudes de modificacion que tienen solicitud relacionada, para que el profesional de compras pueda editar la informacionde la adjudicacion.
	 	if($tiene_rol_profesional == "SI" and $sel_item[6] == 15 and $sel_item[14] == 6){
		 	$edicion_datos_generales = "SI";
		}
	 
	/*SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO del permiso, para procesos de modificaciones y adhudicaciones con sondeo*/
	if($_GET["desde_comite"] == "SI"){//este if es para identificar cuando la consulta biene desde el comite, para modificar los valores directamente por el secretario del comite.
		$desde_comite = "SI";
		$edicion_datos_generales = "SI";
	}
	?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      
    
    
    
    
    
   
    
    
    
    

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<? if ($desde_comite == "SI") echo "<br /><br /><br />";?>
<table  border="0" cellpadding="2" cellspacing="2" align="center" <? if ($desde_comite == "SI") {echo 'bgcolor="#FFFFFF" width="95%"';} else {echo 'width="100%"';}?>>
  <tr>
    <td colspan="4" valign="top"><? if($desde_comite == "SI"){?><div align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display = &quot;none&quot;; ' style="width:100px;" /></div><? }else{ echo encabezado_item_pecc($id_item_pecc);}?></td>
  </tr>
  <tr>
    <td colspan="3" valign="top">
    <?
          if ($edicion_datos_generales == "SI"){
			  if($sel_item[6] <> 6){
		  ?>
    <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="5" align="center"  class="fondo_3">Valor de la solicitud Firmada en el Permiso</td>
        </tr>
      <tr>
    
        <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="24%" align="center" class="fondo_3">&Aacute;rea</td>
        <td width="19%" align="center" class="fondo_3">Valor USD$</td>
        <td width="19%" align="center" class="fondo_3">Valor COP$</td>
        <td width="14%" align="center" class="fondo_3">Ver Adjunto</td>
        </tr>
      <?
	  $sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
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
        <?
			}
		  ?>
        <td align="center"><?=$sel_presu[1]?></td>
        <td align="center"><?=$sel_presu[2]?></td>
        <td align="center" ><?=number_format($sel_presu[4],0)?></td>
        <td align="center"><?=number_format($sel_presu[5],0)?></td>
        <td align="center">
		<? if($sel_presu[3] != " "){?>
		<?=saca_nombre_anexo($sel_presu[3])?>
                  <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" />
                  </a>
                  <?
		}
				  ?></td>
        </tr>
      <?
			}
			$total_equivale_usd = ($valor_total_cop / $trm_actual) +$valor_total_usd ;
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
    <p>
      <?
			  }// si no es adjudicacion directa
?>
      </p>
    <table width="100%" border="0">
      <tr>
        <td><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center"  class="fondo_3">Crear Adjudicaci&oacute;n - Tipo de Contrato MARCO</td>
          </tr>
          <tr>
            <td align="right"> Tipo de Documento: </td>
            <td><?
        	$sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$sel_item[0].""));
			if($sele_tipo_doc[0]>0){
				echo " <strong>Contrato Marco</strong>";
				?>
              <input type="hidden" name="tipo_documento" id="tipo_documento" value="2" />
              <?	
				}else{
		?>
              <select name="tipo_documento" id="tipo_documento" onchange="valida_tipo_doc(<?=$id_item_pecc?>, this.value)">
                <option value="">Tipo del Documento</option>
                <?=listas_sin_seleccione($g17, " estado = 1 ",$_GET["tipo_documento"] ,'nombre', 1);?>
              </select>
              <?
				}
		?></td>
          </tr>
          <tr>
            <td colspan="2" align="center"  class="fondo_3">Busque los Proveedores para la Adjucicaci&oacute;n</td>
          </tr>
          <tr>
            <td align="right">Contrato para Bienes o Servicios</td>
            <td align="left"><select name='complemento_num_contra' id="complemento_num_contra">
              <option value="0">Seleccione</option>
              <option value="">Servicios</option>
              <option value="B">Bienes</option>
            </select></td>
          </tr>
          <tr>
            <td width="17%" align="right"> Duraci&oacute;n Meses:</td>
            <td width="23%" align="left"><input name="vigencia_mes" type="text" id="vigencia_mes" size="3" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
          </tr>
          <tr>
            <td align="right">Proveedores:</td>
            <td align="left"><select name="sele_proveedor" id="sele_proveedor" onchange="carga_otros_proveedores(this.value)">
              <option value="">Selecci&oacute;n de Proveedores</option>
              <option value="99">Otro Proveedor sin Permiso</option>
              <?
				
		  
            	$sele_contratos = query_db("select $g6.t1_proveedor_id, $g6.razon_social from $pi13, $g6 where id_item =".$id_item_pecc." and $pi13.id_proveedor = $g6.t1_proveedor_id");
				while($sel_cont = traer_fila_db($sele_contratos)){
					
			?>
              <option value="<?=$sel_cont[0]?>">
                <?=$sel_cont[1]?>
                </option>
              <?
				}
			?>
            </select></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><div id="carga_otro_proveedor"></div></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Proveedor" onclick="graba_presupuesto_nuevo_edicion_adjudicacion_proveedor_marco()" /></td>
          </tr>
        </table></td>
        <td valign="top"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="5" align="center"  class="fondo_3">Lista de Proveedores </td>
            </tr>
          <tr>
            <td width="52%" align="center" class="fondo_3">Proveedor</td>
            <td width="13%" align="center" class="fondo_3">Bien / Servicio</td>
            <td width="13%" align="center" class="fondo_3">No. Contrato</td>
            <td width="15%" align="center" class="fondo_3">Vigencia en Meses</td>
            <td width="7%" align="center" class="fondo_3">Acciones</td>
          </tr>
          <?
  $sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$id_item_pecc."' and t1.t1_proveedor_id =  t2.t1_proveedor_id");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		 	
		 
		
		
				
		?>
          <tr class="<?=$clase?>">
            <td align="center"><?=$sel_presu[1]?></td>
            <td align="center"><?=tipo_bien_servicio_sin_contrato(str_replace(".","",$sel_presu[3]))?></td>
            <td align="center"><?
			
			 $sel_ontrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id_item = $id_item_pecc and contratista = '".$sel_presu[4]."' and apellido = '".$sel_presu[3]."'"));
			 
				if($sel_ontrato[0] != ""){
    			    $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_ontrato[0]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_ontrato[1];
					$numero_contrato4 = $sel_ontrato[2];
					
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
				}else{
					echo "Sin Crear";
					}
		?></td>
            <td align="center"><?=$sel_presu[2]?></td>
            <td align="center"><?
    if ($edicion_datos_generales == "SI"){
	?>
              <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto_adjudica_proveedor_marco(<?=$sel_presu[0]?>)" />
              <?
	}
	?></td>
          </tr>
          <?
			}
			
		?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td width="43%"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center"  class="fondo_3">Seleccione los valores y proveedores para adjudicar</td>
            </tr>
          <tr>
            <td colspan="2" align="right"><strong class='letra-descuentos'>El valor debe ser incluido &uacute;nicamente en la moneda de pago</strong> <img src='../imagenes/botones/aler-interro.gif' width='5'/></td>
          </tr>
          <tr>
            <td width="42%" align="right">Valor USD$:</td>
            <td width="58%" align="left"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
            </tr>
          <tr>
            <td align="right">Valor COP$:</td>
            <td align="left"><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
            </tr>
          <tr>
            <td colspan="2" align="center">
            <?

                        	$sele_contratos = query_db("select t2.id_relacion, t3.razon_social, t2.apellido from t2_presupuesto_proveedor_adjudica as t2, t1_proveedor as t3 where t2.t1_proveedor_id = t3.t1_proveedor_id and t2.t2_item_pecc_id_marco = ".$id_item_pecc);
				?>
                
<table width="100%" border="0" align="right" class="tabla_lista_resultados" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" class="fondo_3">Proveedor</td>
    <td width="30%" align="center" class="fondo_3">Selecci&oacute;n</td>
  </tr>
<?
				while($sel_cont = traer_fila_db($sele_contratos)){
			
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
				?>
    <tr class="<?=$clase?>">
        <td align="left"><? echo "* ".$sel_cont[1]." <strong>".tipo_bien_servicio_sin_contrato(str_replace(".","",$sel_cont[2]))."</strong><br />"; ?></td>
        <td align="center"><input type="checkbox" name="contra_<?=$sel_cont[0]?>" id="contra_<?=$sel_cont[0]?>" value="<?=$sel_cont[0]?>" /></td>
	</tr>
    			<?				
				}
				?>
</table>
            
            </td>
          </tr>
          <tr>
            <td align="right">A&ntilde;o:</td>
            <td align="left"><select name="ano" id="ano">
              <option value="0">A&Ntilde;O</option>
             <?=anos_presupuesto();?>
            </select></td>
            </tr>
          <tr>
            <td align="right">&Aacute;rea:</td>
            <td align="left"><select name="campo" id="campo">
              <option value="">&Aacute;rea</option>
              <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
            </select></td>
            </tr>
          <tr>
            <td align="right">Adjunto:</td>
            <td align="left"><input name="adjunt_presu" type="file" id="adjunt_presu" size="5" /></td>
            </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar Valor" onclick="graba_presupuesto_nuevo_edicion_adjudicacion_marco()" /></td>
            </tr>
        </table></td>
        <td width="57%" valign="top"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="7" align="center"  class="fondo_3">Valor de la Adjudicaci&oacute;n</td>
            </tr>
          <tr>
            <td width="30%" align="center" class="fondo_3">Proveedor</td>
            <td width="6%" align="center" class="fondo_3">A&ntilde;o</td>
            <td width="17%" align="center" class="fondo_3">&Aacute;rea</td>
            <td width="13%" align="center" class="fondo_3">Valor USD$</td>
            <td width="12%" align="center" class="fondo_3">Valor COP$</td>
            <td width="6%" align="center" class="fondo_3">Ver Adjunto</td>
            <td width="7%" align="center" class="fondo_3">Acciones</td>
          </tr>
          <?

  $sele_presupuesto = query_db("select * from $vpeec25 where t2_item_pecc_id ='".$id_item_pecc."'");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[3];
				$valor_total_cop = $valor_total_cop + $sel_presu[4];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
          <tr class="<?=$clase?>">
            <td align="center">
			
			<?

          	$sel_contr = query_db("select t3.razon_social, t2.apellido from t2_presupuesto_aplica_contrato as t1, t2_presupuesto_proveedor_adjudica as t2, t1_proveedor as t3 where t1.t2_presupuesto_id =".$sel_presu[6]." and t1.t2_proveedor_adjudica = t2.id_relacion and t2.t1_proveedor_id = t3.t1_proveedor_id");
			while($sel_apl = traer_fila_db($sel_contr)){
					
					echo "* ".$sel_apl[0]." <strong>".tipo_bien_servicio_sin_contrato(str_replace(".","",$sel_apl[1]))."</strong><br />";
			}
		  ?></td>
            <td align="center"><?=$sel_presu[1]?></td>
            <td align="center"><?=$sel_presu[2]?></td>
            <td align="center" ><?=number_format($sel_presu[3],0)?></td>
            <td align="center"><?=number_format($sel_presu[4],0)?></td>
            <td align="center"><? if($sel_presu[5] != " " and $sel_presu[5] != "NULL" and $sel_presu[5] != "" ){?>
              <?=saca_nombre_anexo($sel_presu[5])?>
              <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[5]?>&amp;n1=<?=$sel_presu[6]?>&amp;n3=3" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[5])?>.gif" width="16" height="16" /> </a>
              <?
	}
				  ?></td>
            <td align="center"><?
    if ($edicion_datos_generales == "SI"){
	?>
              <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto_adjudica_marco(<?=$sel_presu[6]?>)" />
              <?
	}
	?></td>
          </tr>
          <?
			}
			$total_equivale_usd = ($valor_total_cop / $trm_actual) +$valor_total_usd ;
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
          </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p>
<?
    }else{
		?><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="5" align="center"  class="fondo_3">Valor de la Adjudicaci&oacute;n Solicitada al Comit&eacute; de Contratos, pero que no fue Aprobada</td>
          </tr>
        
          <tr>
          <?
          if($sel_si_es_especifico[0] > 0){
		  ?>
            <?
            }
			?>
            <td width="9%" align="center" class="fondo_3">A&ntilde;o</td>
            <td width="15%" align="center" class="fondo_3">&Aacute;rea / Proyecto</td>
            <td width="18%" align="center" class="fondo_3">Valor USD$</td>
            <td width="17%" align="center" class="fondo_3">Valor COP$</td>
            <td width="6%" align="center" class="fondo_3">Ver Adjunto</td>
          </tr>
          <?

  $sele_presupuesto = query_db("select * from $vpeec25 where t2_item_pecc_id ='".$id_item_pecc."' order by t1_campo_id, ano");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	//while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[3];
				$valor_total_cop = $valor_total_cop + $sel_presu[4];
				
				
				$trm_aplica = $sel_pecc[0];
				
				

			
			$total_equivale_usd = $total_equivale_usd+(($sel_presu[4] / $trm_aplica) +$sel_presu[3] );
			
			
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
          if($sel_si_es_especifico[0] > 0){//oculta columna de proveedores
		  ?>
            <?
            }//oculta columna de proveedores
			?>
          
            <td align="center">2015</td>
            <td align="center">La Ca&ntilde;ada - Socios</td>
            <td align="center" >0</td>
            <td align="center">6,615,652,989</td>
            <td align="center"><? if($sel_presu[5] != " " and $sel_presu[5] != "NULL" and $sel_presu[5] != "" ){?>
              <?=saca_nombre_anexo($sel_presu[5])?>
              <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[5]?>&amp;n1=<?=$sel_presu[6]?>&amp;n3=3" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[5])?>.gif" width="16" height="16" /> </a>
              <?
	}
				  ?></td>
          </tr>
          <tr class="<?=$clase?>">
            <td align="center">2016</td>
            <td align="center">Corporativo - Socios</td>
            <td align="center" >0</td>
            <td align="center">5,715,652,989</td>
            <td align="center"><? if($sel_presu[5] != " " and $sel_presu[5] != "NULL" and $sel_presu[5] != "" ){?>
              <?=saca_nombre_anexo($sel_presu[5])?>
              <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[5]?>&amp;n1=<?=$sel_presu[6]?>&amp;n3=3" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[5])?>.gif" width="16" height="16" /> </a>
              <?
	}
				  ?></td>
          </tr>
          <?
			//}

			
		?>
        </table><?
        		$sel_si_es_especifico = traer_fila_row(query_db("select count(*) from t2_presupuesto_aplica_contrato as t1, t2_presupuesto_proveedor_adjudica as t2, t1_proveedor as t3 where t2.t2_item_pecc_id_marco =".$id_item_pecc." and t1.t2_proveedor_adjudica = t2.id_relacion and t2.t1_proveedor_id = t3.t1_proveedor_id"));// con el desarrollo que se pueda poner presupuesto especifico es necesario ocultar columna de proveedores para las solicitudes anteriores
		
		?><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="6" align="center"  class="fondo_3">Valor de la Adjudicaci&oacute;n Aprobada por el Comite de Contratos</td>
          </tr>
        
          <tr>
          <?
          if($sel_si_es_especifico[0] > 0){
		  ?>
            <td width="35%" align="center" class="fondo_3">Proveedor</td>
            <?
            }
			?>
            <td width="9%" align="center" class="fondo_3">A&ntilde;o</td>
            <td width="15%" align="center" class="fondo_3">&Aacute;rea / Proyecto</td>
            <td width="18%" align="center" class="fondo_3">Valor USD$</td>
            <td width="17%" align="center" class="fondo_3">Valor COP$</td>
            <td width="6%" align="center" class="fondo_3">Ver Adjunto</td>
          </tr>
          <?

  $sele_presupuesto = query_db("select * from $vpeec25 where t2_item_pecc_id ='".$id_item_pecc."' order by t1_campo_id, ano");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[3];
				$valor_total_cop = $valor_total_cop + $sel_presu[4];
				
				
				$trm_aplica = $sel_pecc[0];
				
				

			
			$total_equivale_usd = $total_equivale_usd+(($sel_presu[4] / $trm_aplica) +$sel_presu[3] );
			
			
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
          if($sel_si_es_especifico[0] > 0){//oculta columna de proveedores
		  ?>
            <td align="center"><?

          	$sel_contr = query_db("select t3.razon_social, t2.apellido from t2_presupuesto_aplica_contrato as t1, t2_presupuesto_proveedor_adjudica as t2, t1_proveedor as t3 where t1.t2_presupuesto_id =".$sel_presu[6]." and t1.t2_proveedor_adjudica = t2.id_relacion and t2.t1_proveedor_id = t3.t1_proveedor_id");
			while($sel_apl = traer_fila_db($sel_contr)){
					
					echo "* ".$sel_apl[0]." <strong>".tipo_bien_servicio_sin_contrato(str_replace(".","",$sel_apl[1]))."</strong><br />";
			}
		  ?></td>
          
          <?
            }//oculta columna de proveedores
			?>
          
            <td align="center"><?=$sel_presu[1]?></td>
            <td align="center"><?=$sel_presu[2]?></td>
            <td align="center" ><?=number_format($sel_presu[3],0)?></td>
            <td align="center"><?=number_format($sel_presu[4],0)?></td>
            <td align="center"><? if($sel_presu[5] != " " and $sel_presu[5] != "NULL" and $sel_presu[5] != "" ){?>
              <?=saca_nombre_anexo($sel_presu[5])?>
              <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[5]?>&amp;n1=<?=$sel_presu[6]?>&amp;n3=3" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[5])?>.gif" width="16" height="16" /> </a>
              <?
	}
				  ?></td>
          </tr>
          <?
			}

			
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
      <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr>
          <td colspan="3" align="center"  class="fondo_3">Lista de Proveedores </td>
        </tr>
        <tr>
          <td width="14%" align="center" class="fondo_3">Contratista</td>
          <td width="6%" align="center" class="fondo_3">No. Contrato</td>
          <td width="8%" align="center" class="fondo_3">Vigencia en Meses</td>
        </tr>
        <?
  $sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$id_item_pecc."' and t1.t1_proveedor_id =  t2.t1_proveedor_id");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
        <tr class="<?=$clase?>">
          <td align="center"><?=$sel_presu[1]?></td>
          <td align="center"><?
				 $sel_ontrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, id from $co1 where id_item = $id_item_pecc and contratista = '".$sel_presu[4]."' and apellido = '".$sel_presu[3]."'"));
		
		
				if($sel_ontrato[0] != ""){
    			    $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_ontrato[0]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_ontrato[1];
					$numero_contrato4 = $sel_ontrato[2];
					
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_ontrato[3])." Contrato Marco";
				}else{
					echo "Sin Crear";
					}
		?></td>
          <td align="center"><?=$sel_presu[2]?></td>
        </tr>
        <?
			}
			
		?>
      </table>
      <?
		}
	?><br />
<? if($desde_comite != "SI") { // sI NO BIENE DESDE EL COMITE MUESTRE EL TEXTO DE LA ADJUDIXCACION?>
    <table width="100%" border="0" class="tabla_lista_resultados">
            	<tr>
                    <td colspan="4" align="center"  class="fondo_3" style="height:30px"> Esta solicitud ha sido modificada por las siguientes solicitudes</td>
                <tr>
                <tr>
                    <td align="center"  class="fondo_3" width="20%">N. Solicitud</td>
                    <td align="center"  class="fondo_3" width="60%">Objeto</td>
                    <td align="center"  class="fondo_3" width="20%">Tipo Proceso</td>
                </tr>
                <?php $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where id_solicitud_relacionada = $id_item_pecc");
				while ($rowSR = traer_fila_db($sel_relacionada)){?>
				<tr>
                	<td><?= $rowSR['num1'].$rowSR['num2'].'-'.$rowSR['num3']?></td>
                    <td><?= $rowSR['objeto_solicitud']?></td>
                    <td><?= $rowSR['nombre']?></td>
                </tr>
					<?php }
				?>
            </table>
      </p>
      
    <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <?
        if($sel_item[1] != 1){
		?>
      <?
        }else{
	?>
      <input type="hidden" name="id_pecc_seleccion" id="id_pecc_seleccion" value="1" />
      <?
	}
		
		
		?>
      <?
        	if (($sel_item[6] == 2 or $sel_item[6] == 5 or $sel_item[6] == 7) and $es_profesional_designado == "SI"){
		?>
      <?
			}
        	if ($sel_item[6] == 8 and $es_profesional_designado == "SI"){
		?>
      <?
			}
	  ?>
      <?
      if(($sel_item[6] == 4 or $sel_item[6] == 5)){
	  ?>
      <?
      }else{
				
				?>
      <input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value="0"/>
      <?
				
				}
				
				$sel_textos_adjudicacion = traer_fila_row(query_db("select CAST(ob_solicitud_adjudica AS text), CAST(ob_contrato_adjudica AS text), CAST(alcance_adjudica AS text), CAST(justificacion_adjudica AS text), CAST(recomendacion_adjudica AS text),CAST(justificacion_tecnica_ad AS text),CAST(antecedentes_adjudicacion AS text) from $pi2 where id_item=".$id_item_pecc));
				
				$sel_textos_permiso = traer_fila_row(query_db("select CAST(objeto_solicitud AS text), CAST(objeto_contrato AS text), CAST(alcance AS text), CAST(justificacion AS text), CAST(recomendacion AS text),CAST(justificacion_tecnica AS text), CAST(antecedentes_permiso AS text) from $pi2 where id_item=".$id_item_pecc));
	  ?>
      <tr>
        <td colspan="3" align="center"  class="fondo_3">Informaci&oacute;n de la Adjudicaci&oacute;n</td>
      </tr>
      <tr>
        <td align="right">Proceso Especial o Anticipo, Requiere Aprobaci&oacute;n Extra del Comit&eacute; <img src="../imagenes/botones/help.gif" alt="Seleccione 'SI' si desea que este item vaya al comit&eacute;" title="Seleccione 'SI' si desea que este item vaya al comit&eacute;" width="20" height="20" /></td>
        <td width="22%"><?
        
		$sel_si_es_comite = traer_fila_row(query_db("select COUNT(*) from t2_nivel_servicio, t2_nivel_servicio_tiempos where t2_nivel_servicio.t2_nivel_servicio_id = t2_nivel_servicio_tiempos.t2_nivel_servicio_id and t2_nivel_servicio.t2_nivel_servicio_id = '".$sel_item[2]."' and t2_nivel_servicio_tiempos.t2_nivel_servicio_actividad_id in (8,17)"));
		
		if($sel_si_es_comite[0] > 0 and ($sel_item[24] == 2 or $sel_item[24] == 3)){
			echo "es obligatorio";
			?>
          <input type="hidden" name="req_comite" id="req_comite" value="2" />
          <?
			}else{
		
		if($edicion_datos_generales == "SI"){
		?>
          <select name="req_comite" id="req_comite">
            <option value="2" <? if($sel_item[24] == 2) echo 'selected="selected"'?>  >NO</option>
            <option value="1" <? if($sel_item[24] == 1) echo 'selected="selected"'?>>SI</option>
          </select>
          <?
		}else{
			if($sel_item[24] == 2) echo "NO";
			if($sel_item[24] == 1) echo "SI";
			}
			}
			
		  ?></td>
        <td width="42%"><?
        $sel_si_tiene_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc));
			if($sel_si_tiene_presu[0]<=0){
			echo  "<span class='letra-descuentos'>ALERTA: Para poder ingresar la aprobacion extra de comit&eacute; se debe ingresar el presupuesto, SGPA tambien recibe valores en cero (0)</span>";
            
			}
		?></td>
      </tr>
      <?
  if(($sel_item[6] == 6 or $sel_item[6] == 15) /* and $tiene_rol_profesional == "SI"*/){
  ?>
  
  <tr>
    <td align="right">Tipo de Proceso <img src="../imagenes/botones/help.gif" alt="Indica el tipo de proceso que utilizara para la solicitud." title="Indica el tipo de proceso que utilizara para la solicitud." width="20" height="20" /></td>
    <td colspan="2"> <?
        	if(($sel_item[6] <> 7 and $sel_item[6] <> 8) and $edicion_datos_generales == "SI"){
				
				if($sel_item[4]<>2 and $sel_item[4]<>3 and $sel_item[4]<>4){
					$funti = 'onchange="valida_tipo_proceso_edicion(this)"';
				}
		
		?>
          <select name="tipo_proceso" id="tipo_proceso" >
            <?
			$quita_pone_adjudica_directo = "6,";
            if($tiene_rol_profesional == "SI"){
				$quita_pone_adjudica_directo = "";
				}
			?>
            
            <? 
			if($sel_item[4]==2 or $sel_item[4]==3 or $sel_item[4]==4){
			echo listas($g13, " estado = 1 and t1_tipo_proceso_id  in (1,2,3,9,10,11,15)",$sel_item[6] ,'nombre', 1);	
				}else{
			echo listas($g13, " estado = 1 and t1_tipo_proceso_id not in (".$quita_pone_adjudica_directo."7,8)",$sel_item[6] ,'nombre', 1);
				}
			?>
            
            
           
          </select>
          
          
          
        <?
			}else{
				?><input type="hidden" name="tipo_proceso" id="tipo_proceso" value="<?=$sel_item[6]?>"/><?
				if($sel_item[6] == 8 and $sel_item[4] <> 1){
				echo "Orden de Pedido Contrato Marco/Lista de Precios";
				}else{
				echo saca_nombre_lista($g13,$sel_item[6],'nombre','t1_tipo_proceso_id');	
					}
				if($sel_item[6] == 7 or $sel_item[6] == 8){
					
						$sel_item_ot_apl = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[26]));
						
						echo "<strong> de la solicitud: ".numero_item_pecc($sel_item_ot_apl[0],$sel_item_ot_apl[1],$sel_item_ot_apl[2])." </strong>";
					}
				}
				
				
		?></td>
  </tr>
  <tr>
    <td align="right">Area Usuaria <img src="../imagenes/botones/help.gif" alt="&aacute;rea de este proceso." width="20" height="20"  title="&aacute;rea de este proceso."/></td>
    <td colspan="2"><select name="area_usuaria" id="area_usuaria">
          <?
	  $verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 8 and us_id =".$_SESSION["id_us_session"]));
if($verifica_permiso[0]>0){
	echo listas($g12, " estado = 1",$sel_item[5] ,'nombre', 1);
}else{
      $sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$_SESSION["id_us_session"]." and t1.estado = 1");
	  while($sel_a_usuario = traer_fila_db($sel_areas)){
	  ?>
      <option value="<?=$sel_a_usuario[0]?>" <? if($sel_item[5] == $sel_a_usuario[0]) echo 'selected="selected"'?> ><?=$sel_a_usuario[1]?></option>
      <?
      }
	  
}
	  ?>
        </select></td>
  </tr>
  <tr>
    <td align="right">Fecha en la que se Requiere el Servicio <img src="../imagenes/botones/help.gif" alt="Fecha estimada en la cual requiere la solicitud." title="Fecha estimada en la cual requiere la solicitud." width="20" height="20" /></td>
    <td colspan="2"> <?
if($edicion_datos_generales == "SI"){
?>
        <input name="fecha" type="text" id="fecha" size="5" value="<?=$sel_item[7]?>"  onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha')"  />
<?
}else{
		echo $sel_item[7];
	}
?></td>
  </tr>
  
  
  <?
  }
  ?>
  
  
      <tr>
        <td align="right">Objeto de la Solicitud <img src="../imagenes/botones/help.gif" alt="Actividad o servicio que se desea realizar a trav&eacute;s del contrato." title="Actividad o servicio que se desea realizar a trav&eacute;s del contrato." width="20" height="20" /> </td>
        <td colspan="2"><?
        	if(($sel_item[6] <> 7 and $sel_item[6] <> 8) and $edicion_datos_generales == "SI"){
		?>
          <textarea name="objeto_solicitud" id="objeto_solicitud" cols="25" rows="2"><? if($sel_textos_adjudicacion[0] == "") echo $sel_textos_permiso[0]; else echo $sel_textos_adjudicacion[0];?></textarea>
          <?
			}else{
				if($sel_textos_adjudicacion[0] == "") echo $sel_textos_permiso[0]; else echo $sel_textos_adjudicacion[0];
				}
		?></td>
      </tr>
      <tr>
        <td width="36%" align="right">Objeto del Contrato <img src="../imagenes/botones/help.gif" alt="Describe el objeto conciso del contrato." width="20" height="20" title="Describe el objeto conciso del contrato." /></td>
        <td colspan="2"><?
        	if(($sel_item[6] <> 7 and $sel_item[6] <> 8) and $edicion_datos_generales == "SI"){
		?>
          <textarea name="objeto_contrato" id="objeto_contrato" cols="25" rows="2"><? if($sel_textos_adjudicacion[1] == "") echo $sel_textos_permiso[1]; else echo $sel_textos_adjudicacion[1];?></textarea>
          <?
			}else{
				if($sel_textos_adjudicacion[1] == "") echo $sel_textos_permiso[1]; else echo $sel_textos_adjudicacion[1];
				}
		?></td>
      </tr>
      <tr>
        <td align="right">Alcance <img src="../imagenes/botones/help.gif" alt="Alcance detallado donde se indique el &aacute;rea o &aacute;reas en las cuales se utilizar&aacute; el contrato." title="Alcance detallado donde se indique el &aacute;rea o &aacute;reas en las cuales se utilizar&aacute; el contrato." width="20" height="20" /></td>
        <td colspan="2"><?
        	if(($sel_item[6] <> 7 and $sel_item[6] <> 8) and $edicion_datos_generales == "SI"){
		?>
          <textarea name="alcance" id="alcance" cols="25" rows="2"><? if($sel_textos_adjudicacion[2] == "") echo $sel_textos_permiso[2]; else echo $sel_textos_adjudicacion[2];?></textarea>
          <?
        }else{
				if($sel_textos_adjudicacion[2] == "") echo $sel_textos_permiso[2]; else echo $sel_textos_adjudicacion[2];
				}
		?></td>
      </tr>
      <tr>
        <td align="right">Justificaci&oacute;n T&eacute;cnica <strong><img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
" title="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
"  width="20" height="20" /></strong></td>
        <td colspan="2"><?
if($edicion_datos_generales == "SI"){
?>
          <textarea name="justificacion2" id="justificacion2" cols="25" rows="5"><? if($sel_textos_adjudicacion[5] == "") echo $sel_textos_permiso[5]; else echo $sel_textos_adjudicacion[5];?>
      </textarea>
          <?
}else{
			if($sel_textos_adjudicacion[5] == "") echo $sel_textos_permiso[5]; else echo $sel_textos_adjudicacion[5];
			}
		?></td>
      </tr>
  <?
         if($sel_textos_adjudicacion[3] != "" and $sel_textos_adjudicacion[3] != " " and $sel_textos_adjudicacion[3] != "   "){
         ?>
      <tr>
        <td align="right">Justificaci&oacute;n Comercial <img src="../imagenes/botones/help.gif" alt="Indica el porqué se realiza la solicitud y porqué sugiere el Tipo de Proceso solicitado. Principal campo de consulta." title="Indica el porqué se realiza la solicitud y porqué sugiere el Tipo de Proceso solicitado. Principal campo de consulta." width="20" height="20" /></td>
        <td colspan="2">
          <?
			echo $sel_textos_adjudicacion[3];
			
		?></td>
      </tr>
      <?
		 }
      ?>
      <input type="hidden" name="justificacion" id="justificacion" value="<?=$sel_textos_adjudicacion[3]?>" />
      <tr>
        <td align="right">Antecedentes <img src="../imagenes/botones/help.gif" alt="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" title="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" width="20" height="20" /></td>
        <td colspan="2"><?
if($edicion_datos_generales == "SI"){
?>
      <textarea name="antecedentes_texto" id="antecedentes_texto" cols="25" rows="5"><? if($sel_textos_adjudicacion[6] == "") echo $sel_textos_permiso[6]; else echo $sel_textos_adjudicacion[6];?></textarea>
      <?
}else{
	if($sel_textos_adjudicacion[6] == "") echo $sel_textos_permiso[6]; else echo $sel_textos_adjudicacion[6];
	}
		?></td>
      </tr>
      <tr>
        <td align="right">Recomendaci&oacute;n <img src="../imagenes/botones/help.gif" alt="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." width="20" height="20" title="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." /></td>
        <td colspan="2"><?
if($edicion_datos_generales == "SI"){
?>
          <textarea name="recomendacion" id="recomendacion" cols="25" rows="4"><? if($sel_textos_adjudicacion[4] == "") echo $sel_textos_permiso[4]; else echo $sel_textos_adjudicacion[4];?></textarea>
          <?
}else{
	if($sel_textos_adjudicacion[4] == "") echo $sel_textos_permiso[4]; else echo $sel_textos_adjudicacion[4];
	}
		?></td>
      </tr>
      <tr>
        <td colspan="3" align="center"><table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF"   class="tabla_lista_resultados">
          <tr>
            <td align="center"  class="fondo_3">Objetivos del Proceso</td>
            <td align="center" class="fondo_3">Descripci&oacute;n</td>
          </tr>
          <?

	  ?>
          <tr>
            <td width="31%" align="right">Oportunidad <img src="../imagenes/botones/help.gif" alt="Para cuando se requiere el servicio y que estamos proponiendo para cumplir con la fecha de entrega, y la estrategia que estamos proponiendo nos sirve para cumplir con el objetivo." width="20" height="20" title="Para cuando se requiere el servicio y que estamos proponiendo para cumplir con la fecha de entrega, y la estrategia que estamos proponiendo nos sirve para cumplir con el objetivo." /></td>
            <td width="69%" align="left"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos1" id="campos1"><?=$p_oportunidad?></textarea>
              <? } else {echo $p_oportunidad; }?></td>
          </tr>
          <tr>
            <td align="right">Costo-Beneficio <img src="../imagenes/botones/help.gif" alt="Cual es el criterio que me genera el mejor costo beneficio Ejemplo Tiempo, Evaluaci&oan T&eacute;cnica, otros, Precio." width="20" height="20" title="Cual es el criterio que me genera el mejor costo beneficio Ejemplo Tiempo, Evaluaci&oacute;n T&eacute;cnica, otros, Precio." /></td>
            <td align="left"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos2" id="campos2"><?=$p_costo?></textarea>
              <? } else echo $p_costo; ?></td>
          </tr>
          <tr>
            <td align="right">Calidad <img src="../imagenes/botones/help.gif" alt="Que significa calidad para el proceso en espec&iacute;fico?  combinaci&oacute;n de tiempo? Entregable? " width="20" height="20" title="Que significa calidad para el proceso en espec&iacute;fico?  combinaci&oacute;n de tiempo? Entregable? " /></td>
            <td align="left"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos3" id="campos3"><?=$p_calidad?></textarea>
              <? } else echo $p_calidad; ?></td>
          </tr>
          <tr>
            <td align="right">Optimizar Transferencia Riesgos <img src="../imagenes/botones/help.gif" alt="Identificar los riesgos y escribir como se aseguran o cuales se transfieren y por que medio.  Si no se transfieren explicar el porque" width="20" height="20" title="Identificar los riesgos y escribir como se aseguran o cuales se transfieren y por que medio.  Si no se transfieren explicar el porque" /></td>
            <td align="left"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos4" id="campos4"><?=$p_optimizar?></textarea>
              <? } else echo $p_optimizar; ?></td>
          </tr>
          <tr>
            <td align="right">Trazabilidad <img src="../imagenes/botones/help.gif" alt="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones." width="20" height="20" title="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones." /></td>
            <td align="left"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos5" id="campos5"><?=$p_trazabilidad?></textarea>
              <? } else echo $p_trazabilidad; ?></td>
          </tr>
          <tr>
            <td align="right">Transparencia <img src="../imagenes/botones/help.gif" alt="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)" width="20" height="20" title="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)" /></td>
            <td align="left"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos6" id="campos6"><?=$p_transparencia?></textarea>
              <? } else echo $p_transparencia; ?></td>
          </tr>
          <tr>
            <td align="right">Sostenibilidad <img src="../imagenes/botones/help.gif" alt="Como nos estamos asegurando que los compromisos con las comunidades se van a tener encuentra en el proceso" width="20" height="20" title="Como nos estamos asegurando que los compromisos con las comunidades se van a tener encuentra en el proceso" /></td>
            <td align="left"><? if($edicion_datos_generales=="SI") { ?>
              <textarea name="campos7" id="campos7"><?=$p_sostenibilidad?></textarea>
              <? } else echo $p_sostenibilidad; ?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td colspan="2" align="center"><?
if($edicion_datos_generales == "SI"){
?>
          
          
           <?
        if( ($sel_item[14] == 31 and $sel_item[6]==15) and $edicion_datos_generales == "SI" and $es_preparador <> "SI"){
		?> 
        <table>
        <tr>
        <td>
        <input type="button" name="button4" id="button4" value="Grabar Informaci&oacute;n Temporalmente" class="boton_grabar" onclick="grabar_informacion_adjudicacion()" />
        </td>
        <td>
        <select name="conflito_intere_sel" id="conflito_intere_sel">
      <option value="0">Seleccione si tiene conflicto de intereses</option>
      <option value="1">SI tiene conflicto de intereses</option>
      <option value="2">NO tiene conflicto de intereses</option>
    </select>
        <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar este proceso y poner en firme" onclick="siguiente_nivel_agl('Esta Seguro de firmar y declarar que no tiene conflicto de intereses?','0')"/>
        </td>
        </tr>
        </table>
        <?
		}else{
		?>
        <input type="button" name="button4" id="button4" value="Grabar Informaci&oacute;n de la Adjudicaci&oacute;n" class="boton_grabar" onclick="grabar_informacion_adjudicacion()" />
          <?
		}
}
?></td>
      </tr>
    </table>
    <br /></td>
    <td width="22%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
   <?
          if ($edicion_datos_generales == "SI"){
		  ?>
 <?
		  }
 ?>
 <?
 $accion_usuario = "NO";
	if(verifica_permiso_adjudicacion_usuario($sel_item[14], $sel_item[0]) == "SI"){
			$accion_usuario = "SI";
		}
          if ($accion_usuario == "SI"){
		  ?>
  <tr>
    <td width="10%" align="right" valign="top" id="carga_acciones_permitidas">Observaci&oacute;n de la Devoluci&oacute;n:</td>
    <td width="23%" align="center" valign="top" id="carga_acciones_permitidas"><textarea name="observa_atras" rows="5" id="observa_atras"></textarea></td>
    <td width="45%" rowspan="2" align="center" valign="top" id="carga_acciones_permitidas">
    <?
    $select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$sel_item[0]." and id_rol = 15 and tipo_adj_permiso = 2"));
	$secuencia_profesional_permiso = $select_secuencia[0];
	?>
    <select name="conflito_intere_sel" id="conflito_intere_sel">
            <option value="0">Seleccione si tiene conflicto de intereses</option>
            <option value="1">SI tiene conflicto de intereses</option>
            <option value="2">NO tiene conflicto de intereses</option>
          </select>
    <input type="button" name="button" id="button" value="Terminar la Revisi&oacute;n de la Adjudicaci&oacute;n" class="boton_grabar" onclick="siguiente_nivel_agl('Esta Seguro de firmar y declarar que no tiene conflicto de intereses?',<?=$secuencia_profesional_permiso?>)" /></td>
    <td rowspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" id="carga_acciones_permitidas2"><input type="button" name="button3" id="button3" value="Devolver al Profesional de C&C" class="boton_grabar_cancelar" onclick="devolver_item_a_gerente_contrato()" /></td>
  </tr>
 <?
		  }
		  }//FIN SI NO BIENE DESDE EL COMITE
 ?>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_item_pecc_real" id="id_item_pecc_real" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc_marco" id="id_item_pecc_marco" value="<?=$id_item_pecc_marco?>" />
<input type="hidden" name="id_trm_aplica" id="id_trm_aplica" value="<?=$sel_item[15]?>" />
<input type="hidden" name="id_presupuesto_elimina" id="id_presupuesto_elimina" value="" />
<input type="hidden" name="id_pecc" id="id_pecc" value="<?=$id_pecc?>" />
<input type="hidden" name="id_secuencia" id="id_secuencia" value="" />
<input type="hidden" name="id_tipo_contratacion" id="id_tipo_contratacion" value="<?=$sel_item[4]?>" />

<input type="hidden" name="campo_ob_proceso1" id="campo_ob_proceso1"/>
<input type="hidden" name="campo_ob_proceso2" id="campo_ob_proceso2"/>
<input type="hidden" name="campo_ob_proceso3" id="campo_ob_proceso3"/>
<input type="hidden" name="campo_ob_proceso4" id="campo_ob_proceso4"/>
<input type="hidden" name="campo_ob_proceso5" id="campo_ob_proceso5"/>
<input type="hidden" name="campo_ob_proceso6" id="campo_ob_proceso6"/>
<input type="hidden" name="campo_ob_proceso7" id="campo_ob_proceso7"/>
<input type="hidden" name="req_socios" id="req_socios" value="<?=$sel_item[51]?>" />
<input type="hidden" name="permiso_ad_ob_proceso" id="permiso_ad_ob_proceso" value="2"/>
<?
//imprime_para_comparar();
?>
</body>
</html>
