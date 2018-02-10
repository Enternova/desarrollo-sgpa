<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	

	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	$trm_actual=trm_presupuestal($sel_item[17]);
	
	$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
	
	$id_item_pecc_marco =$sel_item[26];
	$id_tipo_proceso_pecc = $sel_item[20];
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));

	$edicion_datos_generales = "NO";
	if(verifica_permiso_adjudicacion($sel_item[14], $sel_item[0]) == "SI" or ($sel_item[6]== 15 and ($sel_item[3]==$_SESSION["id_us_session"] or $sel_usu_emulan[0] > 0 ) and $sel_item[14] == 31) ){//el or es para que active la edicion para las modificaciones
			$edicion_datos_generales = "SI";
		}
		
		if($sel_item[4] <> 1){
			$no_contratos = " and t1_tipo_documento_id = 4";
		}	
		
		$tiene_rol_profesional = verifica_usuario_si_tiene_el_permiso(8);
		
		
		if(esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==16){
		 	$edicion_datos_generales = "SI";
		 }
	 
	 // Validacion para solicitudes de modificacion que tienen solicitud relacionada, para que el profesional de compras pueda editar la informacionde la adjudicacion.
	 	if($tiene_rol_profesional == "SI" and $sel_item[6] == 15 and $sel_item[14] == 6){
		 	$edicion_datos_generales = "SI";
		}
	 
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
		 
	 /*SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO reemplaza los anteriores*/
	
	
	
	$busvca_tex = traer_fila_row(query_db("select CAST(a_oportunidad AS TEXT), CAST(a_costo AS TEXT), CAST(a_calidad AS TEXT), CAST(a_optimizar AS TEXT), CAST(a_trazabilidad AS TEXT), CAST(a_transparencia AS TEXT), CAST(a_sostenibilidad AS TEXT) from t2_objetivos_proceso where id_item = ".$id_item_pecc));
	
	
		    if($busvca_tex[0]!="" and $busvca_tex[0]!=" " and $busvca_tex[0]!="  "){$p_oportunidad=$busvca_tex[0];}
			if($busvca_tex[1]!="" and $busvca_tex[1]!=" " and $busvca_tex[1]!="  "){$p_costo=$busvca_tex[1];}
			if($busvca_tex[2]!="" and $busvca_tex[2]!=" " and $busvca_tex[2]!="  "){$p_calidad=$busvca_tex[2];}
			if($busvca_tex[3]!="" and $busvca_tex[3]!=" " and $busvca_tex[3]!="  "){$p_optimizar=$busvca_tex[3];}
			if($busvca_tex[4]!="" and $busvca_tex[4]!=" " and $busvca_tex[4]!="  "){$p_trazabilidad=$busvca_tex[4];}
			if($busvca_tex[5]!="" and $busvca_tex[5]!=" " and $busvca_tex[5]!="  "){$p_transparencia=$busvca_tex[5];}
			if($busvca_tex[6]!="" and $busvca_tex[6]!=" " and $busvca_tex[6]!="  "){$p_sostenibilidad=$busvca_tex[6];}
			
			
			$sel_item_modiicacion = traer_fila_row(query_db("select t1_tipo_proceso_id, estado from t2_item_pecc where id_item =".$sel_item[43]));
		  if(($sel_item_modiicacion[0] == 1 or $sel_item_modiicacion[0]== 2 or $sel_item_modiicacion[0]== 3 or $sel_item_modiicacion[0]== 6) and $sel_item_modiicacion[1] > 14){
			  $la_solicitud_que_modifica="adjudicacion";
			  }
			  
			  
			  /*
			if($sel_item[6]==15 and $la_solicitud_que_modifica!="adjudicacion" and $sel_item[21]==0){//si es permiso y modificaciones
	$busvca_tex_sol_anterior = traer_fila_row(query_db("select CAST(p_oportunidad as TEXT), CAST(p_costo AS TEXT), CAST(p_calidad AS TEXT), CAST(p_optimizar AS TEXT), CAST(p_trazabilidad AS TEXT), CAST(p_transparencia AS TEXT), CAST(p_sostenibilidad AS TEXT) from t2_objetivos_proceso where id_item = ".$sel_item[43]));
	
	$busvca_tex = traer_fila_row(query_db("select CAST(a_oportunidad AS TEXT), CAST(a_costo AS TEXT), CAST(a_calidad AS TEXT), CAST(a_optimizar AS TEXT), CAST(a_trazabilidad AS TEXT), CAST(a_transparencia AS TEXT), CAST(a_sostenibilidad AS TEXT) from t2_objetivos_proceso where id_item = ".$id_item_pecc));
		    if($busvca_tex[0]=="" or $busvca_tex[0]==" " or $busvca_tex[0]=="  " or $busvca_tex[0]== NULL){$p_oportunidad=$busvca_tex_sol_anterior[0]; }
			if($busvca_tex[1]=="" or $busvca_tex[1]==" " or $busvca_tex[1]=="  "){$p_costo=$busvca_tex_sol_anterior[1];}
			if($busvca_tex[2]=="" or $busvca_tex[2]==" " or $busvca_tex[2]=="  "){$p_calidad=$busvca_tex_sol_anterior[2];}
			if($busvca_tex[3]=="" or $busvca_tex[3]==" " or $busvca_tex[3]=="  "){$p_optimizar=$busvca_tex_sol_anterior[3];}
			if($busvca_tex[4]=="" or $busvca_tex[4]==" " or $busvca_tex[4]=="  "){$p_trazabilidad=$busvca_tex_sol_anterior[4];}
			if($busvca_tex[5]=="" or $busvca_tex[5]==" " or $busvca_tex[5]=="  "){$p_transparencia=$busvca_tex_sol_anterior[5];}
			if($busvca_tex[6]=="" or $busvca_tex[6]==" " or $busvca_tex[6]=="  "){$p_sostenibilidad=$busvca_tex_sol_anterior[6];}
			

			$cuente_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2"));
					if($cuente_presu[0]==0){
				
			$sel_presupuesto_soicitud_anteruior = query_db("select * from t2_presupuesto where t2_item_pecc_id = ".$sel_item[43]." and permiso_o_adjudica = 1");
			while($sel_p_anter = traer_fila_db($sel_presupuesto_soicitud_anteruior)){
				$insert = "insert into t2_presupuesto (t2_item_pecc_id, t1_campo_id, valor_usd, valor_cop, ano, permiso_o_adjudica, destino_final, id_item_ots_aplica, cargo_contable) values ('".$id_item_pecc."', '".$sel_p_anter[2]."', '".$sel_p_anter[5]."', '".$sel_p_anter[6]."', '".$sel_p_anter[7]."', 2, '', 0, '".$sel_p_anter[9]."')";
				$sql_ex=query_db($insert.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				
				$insert2 = query_db("insert into t2_presupuesto_proveedor_adjudica (t2_presupuesto_id, t1_proveedor_id, t1_tipo_documento_id, vigencia_mes, apellido) values ('".$id_ingreso."', 15957, 5,0,'')");
				}
				}
			}
			
			if($sel_item[6]==15 and $la_solicitud_que_modifica=="adjudicacion" or $sel_item[21]!=0){//si es adjudicacion y modificaciones
	$busvca_tex_sol_anterior = traer_fila_row(query_db("select CAST(a_oportunidad AS TEXT), CAST(a_costo AS TEXT), CAST(a_calidad AS TEXT), CAST(a_optimizar AS TEXT), CAST(a_trazabilidad AS TEXT), CAST(a_transparencia AS TEXT), CAST(a_sostenibilidad AS TEXT) from t2_objetivos_proceso where id_item = ".$sel_item[43]));
	
	$busvca_tex = traer_fila_row(query_db("select CAST(a_oportunidad AS TEXT), CAST(a_costo AS TEXT), CAST(a_calidad AS TEXT), CAST(a_optimizar AS TEXT), CAST(a_trazabilidad AS TEXT), CAST(a_transparencia AS TEXT), CAST(a_sostenibilidad AS TEXT) from t2_objetivos_proceso where id_item = ".$id_item_pecc));
		    if($busvca_tex[0]=="" or $busvca_tex[0]==" " or $busvca_tex[0]=="  " or $busvca_tex[0]== NULL){$p_oportunidad=$busvca_tex_sol_anterior[0]; }
			if($busvca_tex[1]=="" or $busvca_tex[1]==" " or $busvca_tex[1]=="  "){$p_costo=$busvca_tex_sol_anterior[1];}
			if($busvca_tex[2]=="" or $busvca_tex[2]==" " or $busvca_tex[2]=="  "){$p_calidad=$busvca_tex_sol_anterior[2];}
			if($busvca_tex[3]=="" or $busvca_tex[3]==" " or $busvca_tex[3]=="  "){$p_optimizar=$busvca_tex_sol_anterior[3];}
			if($busvca_tex[4]=="" or $busvca_tex[4]==" " or $busvca_tex[4]=="  "){$p_trazabilidad=$busvca_tex_sol_anterior[4];}
			if($busvca_tex[5]=="" or $busvca_tex[5]==" " or $busvca_tex[5]=="  "){$p_transparencia=$busvca_tex_sol_anterior[5];}
			if($busvca_tex[6]=="" or $busvca_tex[6]==" " or $busvca_tex[6]=="  "){$p_sostenibilidad=$busvca_tex_sol_anterior[6];}
			
			$cuente_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2"));
					if($cuente_presu[0]==0){
				
			$sel_presupuesto_soicitud_anteruior = query_db("select * from t2_presupuesto where t2_item_pecc_id = ".$sel_item[43]." and permiso_o_adjudica = 1");
			while($sel_p_anter = traer_fila_db($sel_presupuesto_soicitud_anteruior)){
				$insert = "insert into t2_presupuesto (t2_item_pecc_id, t1_campo_id, valor_usd, valor_cop, ano, permiso_o_adjudica, destino_final, id_item_ots_aplica, cargo_contable) values ('".$id_item_pecc."', '".$sel_p_anter[2]."', '".$sel_p_anter[5]."', '".$sel_p_anter[6]."', '".$sel_p_anter[7]."', 2, '', 0, '".$sel_p_anter[9]."')";
				$sql_ex=query_db($insert.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				
				$insert2 = query_db("insert into t2_presupuesto_proveedor_adjudica (t2_presupuesto_id, t1_proveedor_id, t1_tipo_documento_id, vigencia_mes, apellido) values ('".$id_ingreso."', 15957, 5,0,'')");
				}
				}
			}
			*/
			
	/*FIN SELECCIONA LOS TEXTOS DE LOS OBJETIVOS DEL PROCESO*/
	
$sel_si_es_soporte_abas = traer_fila_row(query_db("select count(*) from v_seg1 where id_premiso = 44 and us_id = ".$sel_item[23]));	
	 
	 
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
<? if ($desde_comite == "SI") echo "<br /><br /><br />";
?>

<table width="100%" border="0" cellpadding="2" cellspacing="2" <? if ($desde_comite == "SI") {echo 'bgcolor="#FFFFFF" width="95%"';} else {echo 'width="100%"';}?>>
  <tr>
    <td colspan="4" valign="top"><? if($desde_comite == "SI"){?><div align="right">
      <input type="button" value="Cerrar" class="boton_grabar_cancelar" onclick="ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite='+document.principal.id_comite.value, 'contenidos')" style="width:100px;" />
    </div><? }else{ echo encabezado_item_pecc($id_item_pecc);}?></td>
  </tr>
  	<tr>
    <td colspan="3" valign="top">
    
    <?
  		/***** PARA EL INC-008 *********/
	//INCLUYE EL TIPO DE DOCUMENTO
	//$color_icono="#229BFF";
	//require('muestra_tipo_documento.php');
		//echo ayuda_alerta("Tipo de Esta Adjudicaci&oacute;n: Compra / Contrataci&oacute;n Puntual")
	/***** PARA EL INC-008 *********/
  	?>
    <?
          if ($edicion_datos_generales == "SI" ){
			  if($sel_item[6] <> 6 and $sel_item[6] <> 15 and ($_GET["desde_comite"] != "SI")){
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
	  
	  
	  /*if($sel_presu[1]== 2013){
				$trm_actual=1780;
				}else{
				$trm_actual=1900;
				}
		*/	
			$total_equivale_usd = ($valor_total_cop / $trm_actual) +$valor_total_usd ;
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
<br>
<?
			  }// si no es adjudicacion directa
?>
    <br />

    	<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="4" align="center"  class="fondo_3">Crear Adjudicaci&oacute;n <? if($sel_item[6] <> 6 and $sel_item[6] <> 15){?> - Proveedores con Permiso<? }?> <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
        </tr>
      <tr>
        <td align="right">
        
        Tipo de Documento: </td>
        <td><?
        	$sele_tipo_doc = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."'"));
			if($sele_tipo_doc[0]>0){
				echo " <strong>".$sele_tipo_doc[9]."</strong>";
				?><input type="hidden" name="tipo_documento" id="tipo_documento" value="<?=$sele_tipo_doc[13]?>" /><?	
				}else{
					
					if($sel_item[6]==15){//si es modificacion
		?>
        <select name="tipo_documento" id="tipo_documento" onchange="valida_tipo_doc(<?=$id_item_pecc?>, this.value)">
          <option value="5">Modificaci&oacute;n</option>
        </select>
        <?
					}else{
						//echo $_GET["tipo_documento"];
		?>
        <select name="tipo_documento" id="tipo_documento" onchange="valida_tipo_doc(<?=$id_item_pecc?>, this.value)">
          <option value="">Tipo del Documento</option>
           	<?
	        	if($sel_item[4] <> 1){
	        			
	        		echo listas_sin_seleccione($g17, " estado = 1 and t1_tipo_documento_id not  in (1, 2, 6) ",$_GET["tipo_seleccion"] ,'nombre', 1);
	        	}else{
					
	        		echo listas_sin_seleccione($g17, " estado = 1 ",$_GET["tipo_seleccion"] ,'nombre', 1);
	        	}
	       	?>
        </select>
        <?
					}
				}
		?></td>
        <td width="22%" align="right">Proveedores:</td>
        <td width="38%" align="left">
        <select name="sele_proveedor" id="sele_proveedor" onchange="carga_otros_proveedores_adjudicacion(this.value)">
            <option value="">Selecci&oacute;n de Proveedores</option>
            <option value="99">Proveedor Creado / Actualizado en Par Servicios</option>
            <?	//INC017-18 INICIO AGREGAR ESTADO
            	$sele_contratos = query_db("select $g6.t1_proveedor_id, $g6.razon_social,$g6.estado_parservicios, $g6.creado_actualizado_desde_par from $pi13, $g6 where $pi13.estado='1' and id_item =".$id_item_pecc." and $pi13.id_proveedor = $g6.t1_proveedor_id");
			  	//INC017-18 FIN AGREGAR ESTADO
				while($sel_cont = traer_fila_db($sele_contratos)){
					/***** para el des 083 *****/
					if($sel_cont[3]=="SI"){
						if($sel_cont[2]=="Aceptado Extranjero" or $sel_cont[2]=="Convenios y Pagos" or $sel_cont[2]=="Pendiente por Aprobación" or $sel_cont[2]=="En Proceso" or $sel_cont[2]=="Aceptado"){
							?>
				              <option value="<?=$sel_cont[0]?>">
				                <?=$sel_cont[1]?>
				                </option>
				              <?
	          			}else{
	          				?>
				              <option value="<?=$sel_cont[0]?>" disabled>
				                <?=$sel_cont[1]." ".$sel_cont[2]?>
				                </option>
				              <?
	          			}
          			}else{
          				?>
			              <option value="<?=$sel_cont[0]?>">
			                <?=$sel_cont[1]?>
			                </option>
			            <?
          			}
          			/***** para el des 083 *****/
				}
				
				$sele_proveedores = query_db("select razon_social,t1_proveedor_id from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."' group by razon_social,t1_proveedor_id order by razon_social");
				while($sel_cont = traer_fila_db($sele_proveedores)){
					$estado_provee=traer_fila_row(query_db("select estado_parservicios, creado_actualizado_desde_par from ".$g6." where t1_proveedor_id=".$sel_cont[1]));
					$sel_cont[2]=$estado_provee[0];
					$sel_cont[3]=$estado_provee[1];
					/***** para el des 083 *****/
					if($sel_cont[3]=="SI"){
						if($sel_cont[2]=="Aceptado Extranjero" or $sel_cont[2]=="Convenios y Pagos" or $sel_cont[2]=="Pendiente por Aprobación" or $sel_cont[2]=="En Proceso" or $sel_cont[2]=="Aceptado"){
							?>
				              <option value="<?=$sel_cont[1]?>">
				                <?=$sel_cont[0]?>
				                </option>
				              <?
	          			}else{
	          				?>
				              <option value="<?=$sel_cont[1]?>" disabled>
				                <?=$sel_cont[0]." ".$sel_cont[2]?>
				                </option>
				              <?
	          			}
          			}else{
          				?>
			              <option value="<?=$sel_cont[1]?>">
			                <?=$sel_cont[0]?>
			                </option>
			            <?
          			}
          			/***** para el des 083 *****/
				}
				
			?>
            </select>
        </td>
        </tr>
        
      <tr>
        <td align="right"><?
      /*   if($sel_item[6]==15){//si es modificacion y adjudicacion
				echo "Bienes o Servicios:";
		 }else{*/
			 	echo "Contrato para Bienes o Servicios:";
			// }
		?></td>
        <td align="left"><select name='complemto_contrato' id="complemto_contrato"><option value="0">Seleccione</option><option value="">Servicios</option> <option value="B">Bienes</option></select></td>
        <td align="right">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="right"><?=ayuda_alerta_pequena("El valor debe ser incluido &uacute;nicamente en la moneda de pago");?></td>
        <td align="right">&Aacute;rea:</td>
        <td align="left"><select name="campo" id="campo">
          <option value="">&Aacute;rea/Proyecto</option>
          <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
        </select></td>
        </tr>
      <tr>
        <td width="17%" align="right">Valor USD$:</td>
        <td width="23%" align="left"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        <td align="right">Duraci&oacute;n Meses:</td>
        <td align="left"><input name="vigencia_mes" type="text" id="vigencia_mes" size="3" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        </tr>
      <tr>
        <td align="right">Valor COP$:</td>
        <td align="left"><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        <td align="right">Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
        <td align="left"><input name="adjunt_presu" type="file" id="adjunt_presu" size="5" /></td>
        </tr>
      <tr>
        <td align="right">A&ntilde;o:</td>
        <td align="left"><select name="ano" id="ano">
          <option value="0">A&Ntilde;O</option>
          <?=anos_presupuesto();?>
        </select></td>
        <td align="right">&nbsp;</td>
        <td align="left">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="right"><div id="carga_otro_proveedor"></div></td>
        </tr>
      <tr>
        <td colspan="4" align="right"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar Linea de Adjudicaci&oacute;n" onclick="graba_presupuesto_nuevo_edicion_adjudicacion()" /></td>
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
   
    <td width="24%" align="center" class="fondo_3">Contratista</td>
    <td width="15%" align="center" class="fondo_3">No. Contrato</td>
    <td width="6%" align="center" class="fondo_3">Bien / Servicio</td>
    <td width="8%" align="center" class="fondo_3">Tipo de Documento</td>
  
    <td width="3%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="7%" align="center" class="fondo_3">Vigencia en Meses</td>
    <td width="9%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    <td width="8%" align="center" class="fondo_3">Valor USD$</td>
    <td width="10%" align="center" class="fondo_3">Valor COP$</td>
    <td width="5%" align="center" class="fondo_3">Ver Adjunto</td>
    <td width="5%" align="center" class="fondo_3">Acciones</td>
  </tr>
  <?
 $sql_presu = "select t2_item_pecc_id,razon_social,consecutivo,creacion_sistema,ano,nombre,sum(valor_usd),sum(valor_cop),adjunto,tipo_documento,t1_proveedor_id,t2_presupuesto_id,nit,t1_tipo_documento_id,id_contrato,vigencia_mes,t1_campo_id,Expr1, t1_proveedor_id_2 from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."' group by t2_item_pecc_id,razon_social,consecutivo,creacion_sistema,ano,nombre,adjunto,tipo_documento,t1_proveedor_id,t2_presupuesto_id,nit,t1_tipo_documento_id,id_contrato,vigencia_mes,t1_campo_id,Expr1, t1_proveedor_id_2 order by razon_social, Expr1, ano ";

  $sele_presupuesto = query_db($sql_presu);
  
  
  
  
 
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
		  
		  
		 /*  if($sel_presu[4]== 2013){
				$trm_actual=1780;
				}else{
				$trm_actual=1900;
				}
				*/
				
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
if($sel_presu[13] == 6) echo "Aceptacion de Oferta Mercantil"; elseif($sel_presu[13] == 2) echo "Contrato Marco"; else echo "Contrato Puntual";
				}else{
					
		 $sql_busca_contr =  "select consecutivo, creacion_sistema, apellido from t7_contratos_contrato where id_item = ".$id_item_pecc." and apellido = '".$sel_presu[17]."' and contratista = ".$sel_presu[18]." ";
					$buscar_contrato = traer_fila_row(query_db($sql_busca_contr));
					
					if($buscar_contrato[0]>0){
						 $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$buscar_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $buscar_contrato[0];
					$numero_contrato4 = $buscar_contrato[2];
echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4); 
if($sel_presu[13] == 6) echo "Aceptacion de Oferta Mercantil"; elseif($sel_presu[13] == 2) echo "Contrato Marco"; else echo "Contrato Puntual";
						}else{
							echo "Sin Crear";
						}
					}
		?></td>
    <td align="center"><?=tipo_bien_servicio_sin_contrato(str_replace(".","",$sel_presu[17]))?></td>
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


<?
		  if($_GET["desde_comite"] != "SI"){
		  ?>

<table width="100%">
	<tr>
	  <td colspan="2" align="center" valign="top" class="fondo_3"><span  style="height:30px">Agrupaci&oacute;n de valores por A&ntilde;o, Proveedor y Area/Proyecto</span></td>
	  </tr>
	<tr>
	  <td width="50%" valign="top"><table width="100%" border="0" class="tabla_lista_resultados">
	    <tr>
	      <td align="center"  class="fondo_3" width="40%">Proveedor</td>
	      <td align="center"  class="fondo_3" width="30%">A&#328;o</td>
	      <td align="center"  class="fondo_3">Total USD</td>
	      <td align="center"  class="fondo_3">Total COP</td>
	      </tr>
	    <?php 
				
				
				$group_presupuesto_ano = query_db("select razon_social,ano,sum(valor_usd) as valor_usd,sum(valor_cop) as valor_cop from $vpeec18 where t2_item_pecc_id = $id_item_pecc  group by razon_social,ano");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_ano)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
	    <tr class="<?=$clase?>">
	      <td><?= $rowGPA['razon_social']?></td>
	      <td align="center"><?= $rowGPA['ano']?></td>
	      <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
	      <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
	      </tr>
	    <?php }?>
	    </table></td>
	  <td width="50%" valign="top"><table width="100%" border="0" class="tabla_lista_resultados">
	    <tr>
	      <td align="center"  class="fondo_3" width="40%">Proveedor</td>
	      <td align="center"  class="fondo_3" width="30%">Area/Proyecto</td>
	      <td align="center"  class="fondo_3">Total USD</td>
	      <td align="center"  class="fondo_3">Total COP</td>
	      </tr>
	    <?php 
                $group_presupuesto_area = query_db("select razon_social,nombre,sum(valor_usd) as valor_usd,sum(valor_cop) as valor_cop from $vpeec18 where t2_item_pecc_id = $id_item_pecc   group by razon_social,nombre");
				
				
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_area)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
	    <tr class="<?=$clase?>">
	      <td><?= $rowGPA['razon_social']?></td>
	      <td><?= $rowGPA['nombre']?></td>
	      <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
	      <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
	      </tr>
	    <?php }?>
	    </table></td>
	  </tr>
	 <!--- PARA EL INC-008 2017 -->
		<tr>
	  <td width="50%" colspan="2" valign="top"><table width="50%" border="0" class="tabla_lista_resultados">
	    <tr>
	      <td align="center"  class="fondo_3" width="40%">Proveedor</td>
	      <td align="center"  class="fondo_3" width="30%">Contrato para Bienes o Servicios</td>
	      <td align="center"  class="fondo_3">Total USD</td>
	      <td align="center"  class="fondo_3">Total COP</td>
	      </tr>
	    <?php 
				
				
				$group_presupuesto_ano = query_db("SELECT t1.razon_social,t3.apellido, t2.valor_usd, t2.valor_cop from $g6 as t1, $pi8 as t2, $pi18 as t3 where t1.t1_proveedor_id=t3.t1_proveedor_id AND t3.t2_presupuesto_id = t2.t2_presupuesto_id and t2.t2_item_pecc_id=$id_item_pecc");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_ano)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
	    <tr class="<?=$clase?>">
	      <td><?= $rowGPA['razon_social']?></td>
	      <td align="center"><? if($rowGPA['apellido']=="B"){ echo "Bien";}else {echo "Servicios";}?></td>
	      <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
	      <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
	      </tr>
	    <?php }?>
	    </table></td>
	  </tr>
	<!--- PARA EL INC-008 2017 -->
    <? if ($desde_comite != "SI") {?>
    <tr>
    	<td colspan="2" align="right"><A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/pecc/reporte_adjudicacion_excel.php?id_item_pecc=<?=$id_item_pecc?>'">Generar Reporte en EXCEL <img src="../imagenes/mime/xlsx.gif"  /></A></td>
    </tr>
    <tr>
      <td colspan="2"><table width="200" border="0" class="tabla_lista_resultados">
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
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
    </tr>
  <tr>
    <td colspan="5" class="titulo_afe_ceco" align="center">Relacione el AFE/ CECO disponible para la adquisici&oacute;n <img src="../imagenes/botones/help.gif" alt="Si no hay cargo contable indicar el estado de aprobaci&oacute;n en el que se encuentra" title="Si no hay cargo contable indicar el estado de aprobaci&oacute;n en el que se encuentra" width="20" height="20" /></td>
  </tr>
  <tr>
  <td width="14%" align="center" class="fondo_3">PROYECTO</td>
    <td width="24%" align="center" class="fondo_3">AFE / CECO</td>
    <td colspan="2" align="center" class="fondo_3">ADJUNTO</td>
    <td width="10%" class="fondo_3">&nbsp;</td>

  </tr>
  <?
  $sele_proyectos = query_db("select $g15.nombre, $g15.t1_campo_id from $pi8, $g15 where $pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 2 and $g15.t1_campo_id = $pi8.t1_campo_id and (valor_usd > 0 or valor_cop > 0)  group by $g15.nombre, $g15.t1_campo_id");
  $falta_algun_afe_ceco = 0;
  if($edicion_datos_generales == "SI"){ 
		  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imagenes/botones/aler-interro.gif" height="20" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'."<strong class='letra-descuentos_grande'>Por favor revisar la relaci&oacute;n de AFE / CECO</strong><br />";
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
  <tr>
  <td class="<?=$clase?>"><?=$sel_pro[0]?></td>
    <td><? if($edicion_datos_generales == "SI" or $accion_usuario == "SI"){?><input type="text" name="afe_ceco_<?=$sel_pro[1]?>" id="afe_ceco_<?=$sel_pro[1]?>" value="<?=$sel_afe_ceco[1]?>" /><? }else{ echo $sel_afe_ceco[1]; } ?></td>
    <td width="<? if($edicion_datos_generales == "SI" or $accion_usuario == "SI"){ echo "33%";}else{ echo"5%";}?>"><? if($edicion_datos_generales == "SI" or $accion_usuario == "SI"){?><input type="file" name="afe_ceco_adjunto_<?=$sel_pro[1]?>" id="afe_ceco_adjunto_<?=$sel_pro[1]?>" /><? }?> </td>
    <td width="19%"><? if($sel_afe_ceco[2] != ""){   
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
			  }?></td>
    <td><? if($edicion_datos_generales == "SI" or $accion_usuario == "SI"){?><input type="button" value="Grabar" onclick="graba_afe_ceco_edita_adjudicacion(<?=$sel_pro[1]?>, document.principal.afe_ceco_<?=$sel_pro[1]?>.value, document.principal.afe_ceco_adjunto_<?=$sel_pro[1]?>.value)" /><? } ?></td>
  </tr>
  <?
  }
  ?>
</table>

<?
								  }
	?>
<input type="hidden" name="id_campo_afe_ceco" id="id_campo_afe_ceco" />
<input type="hidden" name="falta_algun_afe_ceco" id="falta_algun_afe_ceco" value="<?=$falta_algun_afe_ceco?>" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2"><table width="100%" border="0" class="tabla_lista_resultados">
    	  <tr>
    	    <td colspan="5" align="center"  class="fondo_3" style="height:30px"> Esta solicitud ha sido modificada por las siguientes solicitudes</td>
  	    </tr>
    	  <tr></tr>
    	  <tr>
    	    <td align="center"  class="fondo_3" width="20%">N. Solicitud</td>
    	    <td align="center"  class="fondo_3" width="60%">Objeto</td>
    	    <td align="center"  class="fondo_3" width="20%">Estado</td>
    	    <td align="center"  class="fondo_3" width="20%">Tipo Proceso</td>
  	    </tr>
    	  <?

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, solicitud_rechazada, solicitud_desierta from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where id_solicitud_relacionada = $id_item_pecc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
		if($rowSR[5] == 32){
			if($rowSR[6] == 1){
			$esta_procc = "Finalizado - RECHAZADO";
			}elseif($rowSR[7] == 1){
				$esta_procc = "Finalizado - DECLARADO DESIERTO";
				}else{
				$esta_procc = "Finalizado";
				}
		}else{
			$esta_procc = traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");
			}
					
					?>
    	  <tr>
    	    <td><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3'])?></td>
    	    <td><?= $rowSR['objeto_solicitud']?></td>
    	    <td><? echo $esta_procc;?></td>
    	    <td><?= $rowSR['nombre']?></td>
  	    </tr>
    	  <?php }
				?>
  	  </table></td>
    </tr>
</table>




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
  <?}elseif ($tiene[1]==2){//si es por proveedor  	
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

/* ----------- VALOR APROBADO VS SOLICTADO ---------------
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
	  ?>


      </div>
</td>
<? if ($desde_comite != "SI") {?>
    <td width="22%" rowspan="3" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  <? } ?>
  </tr>
   <?
   
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
				   $link ="window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Para poner en firme la solicitud debe completar la informacion de AFE / CECO', 40, 5, 12);";
				    }else{
						$link = "siguiente_nivel_agl('Esta Seguro de firmar y declarar que no tiene conflicto de intereses?',".$secuencia_profesional_permiso.")";
						} 
	?>
      
      <select name="conflito_intere_sel" id="conflito_intere_sel">
        <option value="0">Seleccione si tiene conflicto de intereses</option>
        <option value="1">SI tiene conflicto de intereses</option>
        <option value="2">NO tiene conflicto de intereses</option>
        </select>
      
    <input type="button" name="button" id="button" value="Terminar la Adjudicaci&oacute;n y enviar a las Firmas en el Sistema" class="boton_grabar" onclick="<?=$link?>" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" id="carga_acciones_permitidas2"><input type="button" name="button3" id="button3" value="Devolver al Profesional de C&C" class="boton_grabar_cancelar" onclick="devolver_item_a_gerente_contrato('')" /></td>
  </tr>
 <?
		  }
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

<input type="hidden" name="permiso_ad_ob_proceso" id="permiso_ad_ob_proceso" value="2"/>
<input type="hidden" name="req_socios" id="req_socios" value="<?=$sel_item[51]?>" />

<input type="hidden" name="desde_comite" value="<?=$desde_comite?>"/>
<input type="hidden" name="valor_ano" value=""/>
<input type="hidden" name="valor_valor" value=""/>
<input type="hidden" name="valor_razon_social" value=""/>
<?
//imprime_para_comparar();
?>
<div id="contra_otro_si_convierte_marco"></div>
</body>
</html>
