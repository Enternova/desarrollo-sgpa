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
	if(verifica_permiso_adjudicacion($sel_item[14], $sel_item[0]) == "SI" or ($sel_item[6]== 15 and $sel_item[3]==$_SESSION["id_us_session"] and $sel_item[14] == 31)){//el or es para que active la edicion para las modificaciones
			$edicion_datos_generales = "SI";
		}
		
	if($sel_item[4] <> 1){
		$no_contratos = " and t1_tipo_documento_id = 4";
		}	
		
		$tiene_rol_profesional = verifica_usuario_si_tiene_el_permiso(8);
		if(esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==16){
	 $edicion_datos_generales = "SI";
	 }
	 
	 /*SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO del permiso, para procesos de modificaciones y adhudicaciones con sondeo*/
	
	if($sel_item[14]!= 31){
		$permiso_mayor_creacion ="SI";
		}
	
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
	?>
    
    

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="4" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td colspan="3" valign="top">
    <?
	//echo ayuda_alerta("Tipo de Esta Adjudicaci&oacute;n: Declaraci&oacute;n Desierta");
          if ($edicion_datos_generales == "SI"){
			  if($sel_item[6] <> 6){
		  ?>
    <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="5" align="center"  class="fondo_3">Valor de la solicitud Firmada en el Permiso</td>
        </tr>
      <tr>
    
        <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="24%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
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
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
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
<?
			  }// si no es adjudicacion directa
?>
    <br />
    	<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="4" align="center"  class="fondo_3">Crear Adjudicaci&oacute;n - Proveedores con Permiso <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
        </tr>
      <tr>
        <td width="17%" align="right">
        Tipo de Documento:
        </td>
        <td width="23%"><?
        	$sele_tipo_doc = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."'"));
			if($sele_tipo_doc[0]>0){
				echo " <strong>".$sele_tipo_doc[9]."</strong>";
				?><input type="hidden" name="tipo_documento" id="tipo_documento" value="<?=$sele_tipo_doc[13]?>" /><?	
				}else{
		?>
        
        <select name="tipo_documento" id="tipo_documento" onchange="valida_tipo_doc(<?=$id_item_pecc?>, this.value)">
          <option value="">Tipo del Documento</option>
          <?=listas_sin_seleccione($g17, " estado = 1 ".$no_contratos,$_GET["tipo_documento"] ,'nombre', 1);?>
        </select>
        <?
				}
		?></td>
        <td width="22%" align="right">&nbsp;</td>
        <td width="38%" align="left">
        <?
        $fecha_explode = explode("-",$fecha);
		$ano_actual = $fecha_explode[0];
		?>
          <input type="hidden" name="sele_proveedor" id="sele_proveedor" value="15957" />
          <input type="hidden" name="complemto_contrato" id="complemto_contrato" value="" />
          <input name="valor_usd" type="hidden" id="valor_usd" value="0"/>
          <input name="valor_cop" type="hidden" id="valor_cop" value="0"/>
          <input name="ano" type="hidden" id="ano" value="<?=$ano_actual?>" />
          <input type="hidden" name="campo" id="campo" value="1" />
          <input name="vigencia_mes" type="hidden" id="vigencia_mes" value="1" />
          <input name="adjunt_presu" type="hidden" id="adjunt_presu" value="" /></td>
        </tr>
      <tr>
        <td colspan="4" align="right"><div id="carga_otro_proveedor"></div></td>
      </tr>
      <tr>
        <td colspan="4" align="right">
        <? if($sele_tipo_doc[13]<>4){?>
        <input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar Linea para Declarar Desierto" onclick="graba_presupuesto_nuevo_edicion_adjudicacion()" />
        <?
		}
		?>
        </td>
        </tr>
    </table>
      <div id="carga_presupuesto">
<?
    }
	

?>
<div id="carga_edita_presupuesto"></div>

<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="11"><div id="carga_edita_presupuesto"></div></td>
  </tr>
  <tr>
    <td colspan="11" align="center"  class="fondo_3">Valor de la Adjudicaci&oacute;n</td>
  </tr>
  <tr>
   
    <td width="14%" align="center" class="fondo_3">Contratista</td>
    <td width="6%" align="center" class="fondo_3">No. Contrato</td>
    <td width="7%" align="center" class="fondo_3">Complemento</td>
    <td width="7%" align="center" class="fondo_3">Tipo de Documento</td>
  
    <td width="6%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="8%" align="center" class="fondo_3">Vigencia en Meses</td>
    <td width="18%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    <td width="9%" align="center" class="fondo_3">Valor USD$</td>
    <td width="9%" align="center" class="fondo_3">Valor COP$</td>
    <td width="9%" align="center" class="fondo_3">Ver Adjunto</td>
    <td width="14%" align="center" class="fondo_3">Acciones</td>
  </tr>
  <?

  $sele_presupuesto = query_db("select t2_item_pecc_id,razon_social,consecutivo,creacion_sistema,ano,nombre,sum(valor_usd),sum(valor_cop),adjunto,tipo_documento,t1_proveedor_id,t2_presupuesto_id,nit,t1_tipo_documento_id,id_contrato,vigencia_mes,t1_campo_id,Expr1 from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."' group by t2_item_pecc_id,razon_social,consecutivo,creacion_sistema,ano,nombre,adjunto,tipo_documento,t1_proveedor_id,t2_presupuesto_id,nit,t1_tipo_documento_id,id_contrato,vigencia_mes,t1_campo_id,Expr1");
  
 
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				
				
				$valor_total_usd = $valor_total_usd + ($sel_presu[6]);
				$valor_total_cop = $valor_total_cop + ($sel_presu[7]);
				
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
				if($sel_presu[2] != ""){
    			    $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_presu[3]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_presu[2];
					$numero_contrato4 = $sel_presu[17];
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
				}else{
					echo "Sin Crear";
					}
		?></td>
    <td align="center"><?=$sel_presu[17]?></td>
    <td align="center"><?=$sel_presu[9]?></td>
    
    <td align="center"><?=$sel_presu[4]?></td>
    <td align="center"><?=$sel_presu[15]?></td>
    <td align="center"><?=$sel_presu[5]?></td>
    <td align="center" ><?=number_format($sel_presu[6],0)?></td>
    <td align="center"><?=number_format($sel_presu[7],0)?></td>
    <td align="center">
	<? if($sel_presu[8] != " " and $sel_presu[8] != "NULL" and $sel_presu[8] != "" ){?>
	<?=saca_nombre_anexo($sel_presu[8])?>
                  <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[8]?>&n1=<?=$sel_presu[11]?>&n3=3" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[8])?>.gif" width="16" height="16" />
                  </a>
                  <?
	}
				  ?>
            </td>
    <td align="center">
    <?
    if ($edicion_datos_generales == "SI"){
	?>
    <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto_adjudica(<?=$sel_presu[11]?>)" />
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
          <td width="23%" align="right"><!--Total Equivalente USD$:--></td>
          <td width="13%" align="left"><? //=number_format($total_equivale_usd)?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
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

      </div>
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
	?>
    
    <select name="conflito_intere_sel" id="conflito_intere_sel">
            <option value="0">Seleccione si tiene conflicto de intereses</option>
            <option value="1">SI tiene conflicto de intereses</option>
            <option value="2">NO tiene conflicto de intereses</option>
          </select>
    <input type="button" name="button" id="button" value="Declarar Desierto y enviar a las Firmas en el Sistema" class="boton_grabar" onclick="siguiente_nivel_agl('Esta Seguro de firmar y declarar que no tiene conflicto de intereses?',<?=$secuencia_profesional_permiso?>)" /></td>
    <td rowspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" id="carga_acciones_permitidas2"><input type="button" name="button3" id="button3" value="Devolver al Profesional de C&C" class="boton_grabar_cancelar" onclick="devolver_item_a_gerente_contrato('')" /></td>
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
<input type="hidden" name="pecc_origen" id="pecc_origen" value="<?=$sel_item[56]?>" />
<input type="hidden" name="permiso_ad_ob_proceso" id="permiso_ad_ob_proceso" value="2"/>


<?
//imprime_para_comparar();
?>
</body>
</html>
