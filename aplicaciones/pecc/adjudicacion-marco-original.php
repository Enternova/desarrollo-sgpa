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


$sel_suario_par_tecnico = traer_fila_row(query_db("select us_id , nombre_administrador from t1_us_usuarios where us_id =".$sel_item[64]));
	if($sel_suario_par_tecnico[0]>0){$nombre_par_tecnico = "-".$sel_suario_par_tecnico[1]."----,".$sel_suario_par_tecnico[0];}
	
	$sel_suario_ger_contrato = traer_fila_row(query_db("select us_id , nombre_administrador from t1_us_usuarios where us_id =".$sel_item[65]));
	if($sel_suario_ger_contrato[0]>0){$nombre_ger_contrato = "-".$sel_suario_ger_contrato[1]."----,".$sel_suario_ger_contrato[0];}		
		
		
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
	
	$accion_usuario = "NO";
	if(verifica_permiso_adjudicacion_usuario($sel_item[14], $sel_item[0]) == "SI"){
			$accion_usuario = "SI";
		}
	
	?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      
    
    
    
    
    
   
    
    
    
    

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<? if ($desde_comite == "SI") echo "<br /><br /><br />";?>
<table width="100%"  border="0" cellpadding="2" cellspacing="2" align="center" <? if ($desde_comite == "SI") {echo 'bgcolor="#FFFFFF" width="95%"';} else {echo 'width="100%"';}?>>
  <tr>
    <td colspan="4" valign="top"><? if($desde_comite == "SI"){?><div align="right">
      <input type="button" value="Cerrar" class="boton_grabar_cancelar" onclick="ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite='+document.principal.id_comite.value, 'contenidos')" style="width:100px;" />
    </div><? }else{ echo encabezado_item_pecc($id_item_pecc);}?></td>
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
          <td width="23%" align="right"><!--Total Equivalente USD$:--></td>
          <td width="13%" align="left"><? //=number_format($total_equivale_usd)?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
</table>
    <br />

      <?
			  }// si no es adjudicacion directa
?>
      <br />

    <table width="100%" border="0">
    <? if($desde_comite != "SI"){?>
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
              <option value="99">Proveedor Creado / Actualizado en Par Servicios</option>
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
            <td align="right"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Proveedor" onclick="muestra_alerta_general_desde_select('graba_presupuesto_nuevo_edicion_adjudicacion_proveedor_marco()', 'Advertencia', 'Aseg&uacute;rese que el proveedor <campo> Adjudicado, fue aprobado previamente para participar en el proceso', 'sele_proveedor')" /></td>
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
        
        <? }else{?><input type="hidden" name="tipo_documento" id="tipo_documento" value="2" /><? }?>
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
              <td width="23%" align="right"><!--Total Equivalente USD$:--></td>
              <td width="13%" align="left"><? //=number_format($total_equivale_usd)?></td>
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
    <br />

<?
    }else{
		?><table width="100%" border="0" align="center"  class="tabla_lista_resultados" style="display:none">
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
        		$sel_si_es_especifico = traer_fila_row(query_db("select count(*) from t2_presupuesto_aplica_contrato as t1, t2_presupuesto_proveedor_adjudica as t2, t1_proveedor as t3 where t2.t2_item_pecc_id_marco =".$id_item_pecc." and t1.t2_proveedor_adjudica = t2.id_relacion and t2.t1_proveedor_id = t3.t1_proveedor_id and (id_item > 9957)"));// con el desarrollo que se pueda poner presupuesto especifico es necesario ocultar columna de proveedores para las solicitudes anteriores
		
		?><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="6" align="center"  class="fondo_3">Valor de la Adjudicaci&oacute;n del Contrato Marco Aprobada por el Comite de Contratos</td>
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
          <td width="23%" align="right"><!--Total Equivalente USD$:--></td>
          <td width="13%" align="left"><? //=number_format($total_equivale_usd)?></td>
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
          <td width="6%" align="center" class="fondo_3">No. Contrato Marco</td>
          <td width="8%" align="center" class="fondo_3">Vigencia en Meses</td>
        </tr>
        <?
		
		$sele_presupuesto_cuente_cuantos = traer_fila_row(query_db("select count(*) from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$id_item_pecc."' and t1.t1_proveedor_id =  t2.t1_proveedor_id"));
		if($sele_presupuesto_cuente_cuantos[0]==0){
	$sele_presupuesto = query_db("select t1.id, t2.razon_social, 12, t1.apellido, t1.contratista from t7_contratos_contrato as t1, t1_proveedor as t2 where t1.id_item ='".$id_item_pecc."' and t1.contratista = t2.t1_proveedor_id and t1.estado != 50");		
			}else{		
  $sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$id_item_pecc."' and t1.t1_proveedor_id =  t2.t1_proveedor_id");
			}
			
			
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
		  if($sele_presupuesto_cuente_cuantos[0]==0){
			  $sel_ontrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, id from $co1 where id = '".$sel_presu[0]."'"));
		  }else{
				 $sel_ontrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, id from $co1 where id_item = $id_item_pecc and contratista = '".$sel_presu[4]."' and apellido = '".$sel_presu[3]."'"));
		  }
		
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
      <p>&nbsp;</p>
      <table width="200" border="0" class="tabla_lista_resultados">
        <tr class="fondo_3">
          <td align="center">A&Ntilde;O</td>
          <td align="center">TRM</td>
        </tr>
         <tr>
          <td align="center">2013</td>
          <td align="center"><?=number_format(trm_presupuestal(2013),0)?></td>
        </tr>
        <tr>
          <td align="center">2014</td>
          <td align="center"><?=number_format(trm_presupuestal(2014),0)?></td>
        </tr>
        <tr>
          <td align="center">2015</td>
          <td align="center"><?=number_format(trm_presupuestal(2015),0)?></td>
        </tr>
        <tr>
          <td align="center">2016</td>
          <td align="center"><?=number_format(trm_presupuestal(2016),0)?></td>
        </tr>
        <tr>
          <td align="center">2017</td>
          <td align="center"><?=number_format(trm_presupuestal(2017),0)?></td>
        </tr>
      </table>
      <br />

        <?
		}

	?>
     <? if($desde_comite != "SI") { // sI NO BIENE DESDE EL COMITE MUESTRE EL TEXTO DE LA ADJUDIXCACION?>
      <br />

      <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="5" align="center" class="titulo_afe_ceco">Relacione el AFE/ CECO disponible para la adquisici&oacute;n <img src="../imagenes/botones/help.gif" alt="Si no hay cargo contable indicar el estado de aprobaci&oacute;n en el que se encuentra" title="Si no hay cargo contable indicar el estado de aprobaci&oacute;n en el que se encuentra" width="20" height="20" /></td>
    </tr>
  <tr>
  <td width="14%" align="center" class="fondo_3">PROYECTO</td>
    <td width="24%" align="center" class="fondo_3">AFE / CECO</td>
    <td align="center" class="fondo_3" colspan="2" >ADJUNTO</td>
    <td width="10%" class="fondo_3" ></td>
     </tr>
  <?
  $sele_proyectos = query_db("select $g15.nombre, $g15.t1_campo_id from $pi8, $g15 where $pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2 and $g15.t1_campo_id = $pi8.t1_campo_id and (valor_usd > 0 or valor_cop > 0)  group by $g15.nombre, $g15.t1_campo_id");
  $falta_algun_afe_ceco = 0;
  if($edicion_datos_generales == "SI"){ 
		  //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imagenes/botones/aler-interro.gif" height="20" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'."<strong class='letra-descuentos_grande'>Por favor revisar la relaci&oacute;n de AFE / CECO</strong><br />";
		  }
  while($sel_pro = traer_fila_db($sele_proyectos)){
	  
	  $sel_afe_ceco = traer_fila_row(query_db("select id, afe_ceco, adjunto from  t2_relacion_afe_ceco where id_item = '".$id_item_pecc."' and id_campo = '".$sel_pro[1]."' and estado = 1 and permiso_adjudica = 2"));
	  if($sel_afe_ceco[0]<=0){
		  $sel_afe_ceco = traer_fila_row(query_db("select id, afe_ceco, adjunto from  t2_relacion_afe_ceco where id_item = '".$id_item_pecc."' and id_campo = '".$sel_pro[1]."' and estado = 1 and permiso_adjudica = 1"));
		  }
		  
		  	if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
	  
  ?>
  <tr class="<?=$clase?>">
  <td ><?=$sel_pro[0]?></td>
    <td>
	<? if($edicion_datos_generales == "SI" or $accion_usuario == "SI"){?><input type="text" name="afe_ceco_<?=$sel_pro[1]?>" id="afe_ceco_<?=$sel_pro[1]?>" value="<?=$sel_afe_ceco[1]?>" /><? }else{ echo $sel_afe_ceco[1]; } ?>
    
    </td>
    <td width="33%">
	
	<? if($edicion_datos_generales == "SI" or $accion_usuario == "SI"){?><input type="file" name="afe_ceco_adjunto_<?=$sel_pro[1]?>" id="afe_ceco_adjunto_<?=$sel_pro[1]?>" /><? }?> 
    
    </td>
    <td width="19%">
	
	<? if($sel_afe_ceco[2] != ""){   
			  ?>
                <?=saca_nombre_anexo($sel_afe_ceco[2])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_afe_ceco[2]?>&n1=<?=$sel_afe_ceco[0]?>&n3=8" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_afe_ceco[2])?>.gif" width="16" height="16" />
                  </a>
                <?
			  }else{
				  if($edicion_datos_generales == "SI" or $accion_usuario == "SI"){
				  ?><img src="../imagenes/botones/aler-interro.gif" height="16" /> <font color="#FF0000">Falta incluir AFE / CECO</font><?
				  $falta_algun_afe_ceco = $falta_algun_afe_ceco +1;
				  }
			  }?>
              
              </td>
    <td><? if($edicion_datos_generales == "SI" or $accion_usuario == "SI"){?><input type="button" value="Grabar" onclick="graba_afe_ceco_edita_adjudicacion(<?=$sel_pro[1]?>, document.principal.afe_ceco_<?=$sel_pro[1]?>.value, document.principal.afe_ceco_adjunto_<?=$sel_pro[1]?>.value)" /><? } ?></td>
  </tr>
  <?
  }
  ?>
</table>
      <input type="hidden" name="id_campo_afe_ceco" id="id_campo_afe_ceco" />
<input type="hidden" name="falta_algun_afe_ceco" id="falta_algun_afe_ceco" value="<?=$falta_algun_afe_ceco?>" />
       
       <br />
<br />


      <table width="100%" border="0" class="tabla_lista_resultados">
            	<tr>
                    <td colspan="4" align="center"  class="fondo_3"> Esta solicitud ha sido modificada por las siguientes solicitudes</td>
                <tr>
                <tr>
                    <td align="center"  class="fondo_3" width="20%">N. Solicitud</td>
                    <td align="center"  class="fondo_3" width="60%">Objeto</td>
                    <td align="center"  class="fondo_3" width="20%">Estado</td>
                    <td align="center"  class="fondo_3" width="20%">Tipo Proceso</td>
                </tr>
                <?php 
				
				$sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where id_solicitud_relacionada = $id_item_pecc");
				while ($rowSR = traer_fila_db($sel_relacionada)){?>
				<tr>
                	<td><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3'])?></td>
                    <td><?= $rowSR['objeto_solicitud']?></td>
                    <td><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
                    <td><?= $rowSR['nombre']?></td>
                </tr>
					<?php }
				?>
            </table>
     <br />
<br />

<?
$query="SELECT tiene_reembolsable, como_reembolsable FROM $pi2 WHERE id_item=".$id_item_pecc;
$tiene=traer_fila_row(query_db($query));
if ($tiene[0]==1) {//valida si tiene reembolso
  if ($tiene[1]==1) {//Si es por consolidado
    $query="SELECT ano FROM $vpeec18 WHERE t2_item_pecc_id=$id_item_pecc GROUP BY ano";?>
    <table width="40%" border="0" class="tabla_lista_resultados">
      	<tr>
            <td colspan="4" align="center"  class="fondo_3"> Relacione los valores de reembolsable</td>
        </tr>
    	<tr>
            <td align="center"  class="fondo_3" width="30%">A&ntilde;o</td>
            <td align="center"  class="fondo_3" width="60%">Valor Reembolsable</td>
            <td align="center"  class="fondo_3" width="10%">&nbsp;&nbsp;&nbsp;</td>
        </tr>
  <?
  	$excec=query_db($query);
    $cont=0; $cont2=0;
    while ($reslut=traer_fila_db($excec)) {//while
    	if($cont2 == 0){
		  	$clase= "filas_resultados";
			$cont2 = 1;
		  }else{
		  	$clase= "";
			$cont2 = 0;
		  }
		$query="SELECT valor FROM $pi21 WHERE id_item=$id_item_pecc AND ano=$reslut[0]";
		$reslutado=traer_fila_row(query_db($query));
		$valor=number_format($reslutado[0]);
		if ($valor==0) {
			$valor="";
		}
    ?>
    <tr class="<?=$clase?>">
      <td><?=$reslut[0];?></td>
      <td><?if($edicion_datos_generales == "SI"){?><input type="text" name="valor<?=$cont;?>" id="valor<?=$cont;?>" value="<?=$valor?>" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"><?}else{echo $valor;}?></td>
      <td><?if($edicion_datos_generales == "SI"){?><input type="button" value="Grabar" name="<?=$cont;?>" id="<?=$cont;?>" onclick="graba_reembolsable(this.id)"><?}?></td>
      <input type="hidden" id="ano<?=$cont;?>" name="ano<?=$cont;?>" value="<?=$reslut[0];?>">
		<input type="hidden" id="razon<?=$cont;?>" name="razon<?=$cont;?>" value="">
    </tr> 
    <?
      $cont++;
    }//while?>
    </table><br><br>
  <? }elseif ($tiene[1]==2){//si es por proveedor  	
    $query="SELECT razon_social FROM $vpeec18 WHERE t2_item_pecc_id=$id_item_pecc GROUP BY razon_social";?>
    
  <?
	  	$excec=query_db($query);
	    $cont=0;
	    while ($reslut=traer_fila_db($excec)) {//while 1?>
	    <table width="40%" border="0" class="tabla_lista_resultados">
	      	<tr>
	            <td colspan="4" align="center"  class="fondo_3"> Relacione los valores de reembolsable de <?=$reslut[0];?></td>
	        </tr>
	    	<tr>
	            <td align="center"  class="fondo_3" width="30%">A&ntilde;o</td>
	            <td align="center"  class="fondo_3" width="60%">Valor Reembolsable</td>
	            <td align="center"  class="fondo_3" width="10%">&nbsp;&nbsp;&nbsp;</td>
	        </tr>
	    <?	$query="SELECT ano FROM $vpeec18 WHERE t2_item_pecc_id=$id_item_pecc AND razon_social='$reslut[0]' GROUP BY ano";
	    	//echo "<br>".$query."<br>";
	    	$excec2=query_db($query);
	    	$cont2=0;
	    	while ($reslut2=traer_fila_db($excec2)) {//hile 2
		    	if($cont2 == 0){
				  	$clase= "filas_resultados";
					$cont2 = 1;
				  }else{
				  	$clase= "";
					$cont2 = 0;
				  }
				$query="SELECT valor FROM $pi21 WHERE id_item=$id_item_pecc AND proveedor='$reslut[0]' AND ano=$reslut2[0]";
				$reslutado=traer_fila_row(query_db($query));
				$valor=number_format($reslutado[0]);
				if ($valor==0) {
					$valor="";
				}
	    ?>
			    <tr class="<?=$clase?>">
			      <td><?=$reslut2[0];?></td>
			      <td><?if($edicion_datos_generales == "SI"){?><input type="text" name="valor<?=$cont;?>" id="valor<?=$cont;?>" value="<?=$valor?>" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"><?}else{echo $valor;}?></td>
			      <td><?if($edicion_datos_generales == "SI"){?><input type="button" value="Grabar" name="<?=$cont;?>" id="<?=$cont;?>" onclick="graba_reembolsable(this.id)"><?}?></td>
			      <input type="hidden" id="ano<?=$cont;?>" name="ano<?=$cont;?>" value="<?=$reslut2[0];?>">
			      <input type="hidden" id="razon<?=$cont;?>" name="razon<?=$cont;?>" value="<?=$reslut[0];?>">
			    </tr>
	    <?
	    	$cont++;
	    	}//hile 2?>
	    </table><br><br>
	    <? }//while 1
	}//si es por año 
  	
  ?>
<? }//valida si tiene reembolso*/

include("../../aplicaciones/pecc/adjudicacion_info.php");?>
<br />
    <?
if($nomostrar == "NO mostrar"){
/* ----------- VALOR APROBADO VS SOLICTADO ---------------*/
  $id_comite_ad = traer_fila_row(query_db("select id_comite from t3_comite_relacion_item where id_item = ".$id_item_pecc." and permiso_o_adjudica = 2 order by id_relacion desc"));
  $id_comite_per = traer_fila_row(query_db("select id_comite from t3_comite_relacion_item where id_item = ".$id_item_pecc." and permiso_o_adjudica = 1 order by id_relacion desc"));
  $permiso_o_adjudica = 1;
  
	  if($id_comite_ad[0]>0 or $id_comite_per[0]>0){
		$id_comite_apro = $id_comite_per[0];
		$permiso_ad = 1;
		if($id_comite_ad[0]>0){
			$id_comite_apro = $id_comite_ad[0];
			$permiso_ad = 2;
			}	  
	  $sel_datos_comite = traer_fila_Row(query_db("select num1, num2, num3 from t3_comite where id_comite = ".$id_comite_apro));
	  

	  $sel_valores_solicitados = traer_fila_row(query_db("select valor_solicitado_usd, valor_solicitado_cop,  valor_solicitado_eq from  t3_comite_relacion_item where id_item = ".$id_item_pecc." and id_comite = ".$id_comite_apro));
	  
	  
	  
	 if ($sel_item[6] == 11) {
                            $sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));
                        } elseif ($sel_item[6] == 5 or $sel_item[3] == 7) {
					$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));
                        }elseif ($sel_item[6] == 12 and $sel_item[49] == 3){//si es reclasificacion de contrato marco							
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1 and al_valor_inicial_para_marco = 1"));		
						}elseif ($sel_item[6] == 12 and $sel_item[49] != 3){//si es reclasificacion de contrato puntual							
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));		
							}else{
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 2"));
							}
							
			if(($sel_valores_solicitados[0] != $sel_presupuesto[0]) or ($sel_valores_solicitados[1] != $sel_presupuesto[1])){
	  
	?>
    <table width="100%" border="0">
    <tr >
    <td class="titulos_secciones">&nbsp;</td>
  </tr>
  <tr >
    <td class="titulos_secciones">Valor Solicitado Vs Valor Aprobado en el Comit&eacute; <?=numero_item_pecc($sel_datos_comite[0],$sel_datos_comite[1],$sel_datos_comite[2])?></td>
  </tr>
</table>

    <table width="50%" border="0" align="center" class="tabla_lista_resultados">
  
  <tr class="filas_resultados">
    <td width="38%" rowspan="2" align="right">Valor Solicitado:</td>
    <td width="15%" align="right">USD $: </td>
    <td width="47%"><?=number_format($sel_valores_solicitados[0], 0)?></td>
  </tr>
  <tr class="filas_resultados">
    <td align="right">COP $: </td>
    <td><?=number_format($sel_valores_solicitados[1], 0)?></td>
  </tr>
  <tr>
    <td rowspan="2" align="right">Valor Aprobado en el Comit&eacute;:</td>
    <td align="right">USD $: </td>
    <td><?=number_format($sel_presupuesto[0])?></td>
  </tr>
  <tr>
    <td align="right">COP $: </td>
    <td><?=number_format($sel_presupuesto[1])?></td>
  </tr>
    </table>
<table width="100%" border="0">
  <tr >
    <td class="titulos_secciones">&nbsp;</td>
  </tr>
</table>
    
  
  <?
  
			}
	  }
/* ----------- FIN VALOR APROBADO VS SOLICTADO ---------------*/
}
}//FIN SI NO BIENE DESDE EL COMITE
	  ?>
    </td>
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
	
	if ($falta_algun_afe_ceco > 0) {
				   $link ="alert('ATENCION: Para poner en firme la solicitud debe completar la informacion de AFE / CECO')";
				    }else{
						$link = "siguiente_nivel_agl('Esta Seguro de firmar y declarar que no tiene conflicto de intereses?',".$secuencia_profesional_permiso.")";
						} 
						
	?>
    <select name="conflito_intere_sel" id="conflito_intere_sel">
            <option value="0">Seleccione si tiene conflicto de intereses</option>
            <option value="1">SI tiene conflicto de intereses</option>
            <option value="2">NO tiene conflicto de intereses</option>
          </select>
    <input type="button" name="button" id="button" value="Terminar la Revisi&oacute;n de la Adjudicaci&oacute;n" class="boton_grabar" onclick="<?=$link?>" /></td>
    <td rowspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" id="carga_acciones_permitidas2"><input type="button" name="button3" id="button3" value="Devolver al Profesional de C&C" class="boton_grabar_cancelar" onclick="devolver_item_a_gerente_contrato()" /></td>
  </tr>
 <?
		  }
		  
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
<input type="hidden" name="desde_comite" value="<?=$desde_comite?>"/>
<input type="hidden" name="pecc_origen" id="pecc_origen" value="<?=$sel_item[56]?>" />


<?
//imprime_para_comparar();
?>
</body>
</html>
