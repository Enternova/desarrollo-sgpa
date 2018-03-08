<? include("../../librerias/lib/@session.php"); 
	


	
	$id_comite = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));
	
	
	$sele_comite = traer_fila_row(query_db("select * from $c1 where id_comite = ".$id_comite.""));
	
	
	
	$edicion_datos_generales = "NO";
	

	$tiene_permiso_secretrio = "NO";
	$verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 10 and us_id =".$_SESSION["id_us_session"]));
if($verifica_permiso[0]>0  and $sele_comite[4] ==3){
	$tiene_permiso_secretrio = "SI";
}
	
$sel_us_revisa_sap = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 36"));
		if($sel_us_revisa_sap[0]>0){
			$activa_revision_sap = "SI";
		}
		
		
	
	?>


<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="70%" align='center' border="0" cellpadding="2" cellspacing="2" style="background-color:#fff;">
<tr>
  <td align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none";' style="width:100px;" /></td>
</tr>
  <tr>
    <td valign="top"><?=encabezado_comite($id_comite)?> 
    
    </td>
  </tr>
  <tr>
    <td valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
     
      <?
	  $conse_div=0;

      $sel_item_sin_comite = query_db("SELECT * from $vcomite2 where id_item=" . $_GET['id_item'] . " order by orden asc");

if($sel_sin_comi = traer_fila_db($sel_item_sin_comite)){
	$conse_div=$conse_div+1;
	
	  ?>
      <?

	$sel_item = traer_fila_row(query_db("select id_item,CAST(objeto_solicitud AS TEXT), estado, t1_tipo_proceso_id,CAST(alcance AS TEXT),CAST(justificacion AS TEXT),CAST(recomendacion AS TEXT), CAST(ob_solicitud_adjudica AS TEXT),CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada,CAST(justificacion_tecnica AS TEXT),CAST( justificacion_tecnica_ad AS TEXT),CAST( criterios_evaluacion AS TEXT) from $pi2 where id_item=".$sel_sin_comi[0]));

$tipo_proceso = $sel_item[3];
	if($tipo_proceso == 1 or $tipo_proceso == 2 or $tipo_proceso == 3){
$permiso_o_adjudica = $_GET["permiso_o_adjudica"];
	}
	
	if($tipo_proceso <> 1 and $tipo_proceso <> 2 and  $tipo_proceso <> 3){
$permiso_o_adjudica = 2;;
	}
	
				
				$sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$sel_sin_comi[0]."'"));
				
				
				if($sel_item[3]==11){
				  $nombre_firma_1="Informado";
				  $nombre_firma_2="NO Informado";
				  $nombre_firma_3="Informado";
				  $nombre_firma_4="NO Informado";
				  }elseif($sele_tipo_doc_desierto[13]==4){//si es Declaracion Desierta
				  
				  $nombre_firma_1="Declarar Desierto";
				  	$nombre_firma_2="Pendiente; Sacar de este Comit&eacute;";
					$nombre_firma_3="Declarado Desierto";
				  	$nombre_firma_4="Pendiente; Sacar de este Comit&eacute;";
					  
					  }else{
					$nombre_firma_1="Firmar";
				  	$nombre_firma_2="Pendiente; Sacar de este Comit&eacute;";
					$nombre_firma_3="Firmado";
				  	$nombre_firma_4="Pendiente; Sacar de este Comit&eacute;";
					  }
		
		if($sel_item[3] == 11 or $sel_item[3] == 12){
	$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = ".$sel_item[0]." and permiso_o_adjudica = 1"));
	}else{
		$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = ".$sel_item[0]." and permiso_o_adjudica = $permiso_o_adjudica"));
		}	
					  
					  
	$sel_trm = traer_fila_row(query_db(" select valor from t1_trm where id_trm =".$sel_item[14]));
	
	$sele_nivel_anterior = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3  where id_item=".$sel_item[0]." and actividad_estado_id < 7 and  estado = 1"));	
	$sele_datos_actividad = traer_fila_row(query_db("select fecha_real from $vpeec3  where id_item=".$sel_item[0]." and actividad_estado_id = ".$sele_nivel_anterior[0]." and  estado = 1"));
	

		$id_tipo_proceso_pecc = 1;
			if($sel_item[3] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_item[3] == 8){
					$id_tipo_proceso_pecc = 3;
				}



			$objeto_solicitud="";
			$alcance="";
			$justificacion_tecinica="";
			$justificacion_comercial="";
			$criterios_evaluacion="";
			$recomendacion="";
			
//"select id_item,1, 2, t1_tipo_proceso_id,CAST(alcance AS TEXT),5,6, 7,CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada,19,20,CAST( criterios_evaluacion AS TEXT) from $pi2 where id_item=".$sel_sin_comi[0]
			
			if($sel_item[3]<=3){
			
			if($permiso_o_adjudica == 1){
					$objeto_solicitud=$sel_item[1];
					$alcance=$sel_item[4];
					$justificacion_tecinica=$sel_item[19];
					$justificacion_comercial=$sel_item[5];
					$recomendacion=$sel_item[6];
				}
				
			if($permiso_o_adjudica == 2){
					$objeto_solicitud=$sel_item[7];
					$alcance=$sel_item[9];
					$justificacion_tecinica=$sel_item[20];
					$justificacion_comercial=$sel_item[10];
					$recomendacion=$sel_item[11];
				}
				
			}else{
				if($sel_item[1] == "") $objeto_solicitud=$sel_item[7]; else $objeto_solicitud=$sel_item[1];
				if($sel_item[9] == "") $alcance=$sel_item[4]; else $alcance=$sel_item[9];
				if($sel_item[20] == "") $justificacion_tecinica= $sel_item[19]; else $justificacion_tecinica= $sel_item[20];
				if($sel_item[10] == "") $justificacion_comercial= $sel_item[5]; else $justificacion_comercial= $sel_item[10];
				if($sel_item[11] == "") $recomendacion =  $sel_item[6]; else $recomendacion= $sel_item[11];
				}
			
			
	
	  ?>
      <tr >
        <td align="center"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_aproba_comite">
          <tr >
            <td colspan="5" align="center" class="fondo_3"><strong>Datos de la Solicitud <font size="+2">
              <?=numero_item_pecc($sel_sin_comi[3],$sel_sin_comi[4],$sel_sin_comi[5])?>
            </font> </strong><strong class="titulo_calendario_real_bien" onClick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sel_item[0]?>&amp;id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&amp;conse_div=<?=$conse_div?>&amp;permiso_o_adjudica=<?=$permiso_o_adjudica?>')" > <img src="../imagenes/botones/detalle.png" height="30" /></strong></td>
          </tr>
          <tr >
            <td width="362" align="right"><strong>Objeto de la Solicitud <img src="../imagenes/botones/help.gif" alt="Qu&eacute; se va a contratar" title="Qu&eacute; se va a contratar" width="20" height="20" /></strong></td>
            <td colspan="4" align="left"><? echo $objeto_solicitud;  ?></td>
          </tr>
          <tr class="columna_subtitulo_resultados_letra_normal" >
            <td align="right"><strong>Alcance <img src="../imagenes/botones/help.gif" alt="Para qu&eacute; se contrata
" title="Para qu&eacute; se contrata
"  width="20" height="20" /></strong></td>
            <td colspan="4" align="left"><? echo $alcance ?></td>
          </tr>
          <tr >
            <td align="right"><strong>Valor de esta Solicitud <img src="../imagenes/botones/help.gif" alt="Costo del servicio o suministro a contratar
" title="Costo del servicio o suministro a contratar
"  width="20" height="20" /></strong></td>
            <td width="150"   align="right">USD$:</td>
            <td width="343" align="left"><?=number_format($sel_presupuesto[0],0)?></td>
            <td width="227" align="right" valign="top">&nbsp;</td>
            <td width="156" align="left" valign="top">&nbsp;</td>
          </tr>
          <tr >
            <td align="right">&nbsp;</td>
            <?
    $q_us = $sel_presupuesto[1]/trm_presupuestal($sel_sin_comi[4]) +$sel_presupuesto[0];
	?>
            <td width="150" 	align="right">COP$:</td>
            <td align="left"><?=number_format($sel_presupuesto[1],0)?></td>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          
          <tr>
            <td align="right">&nbsp;</td>
          	<td width="150" align="right">Equivalente en dolares$:
            <td align="left">
			<?= (($sel_presupuesto[1] > 0) ? 
			     number_format($sel_presupuesto[1]/trm_presupuestal($sel_sin_comi[4])+$sel_presupuesto[0],0) :
				 number_format($sel_presupuesto[0],0))?>
            </td>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>            
          </tr>
          <tr class="columna_subtitulo_resultados_letra_normal" >
            <td align="right"><strong>Tipo de Proceso <img src="../imagenes/botones/help.gif" alt="Como vamos a adquirir los B&amp;S. (Negociaci&oacute;n directa, Invitaci&oacute;n a Proponer, Otros&iacute;, Emergencia Operacional, Caso Excepcional, Informativo y/o reclasificaci&oacute;n).  Estaba incluido en el PECC"  title="Como vamos a adquirir los B&amp;S. (Negociaci&oacute;n directa, Invitaci&oacute;n a Proponer, Otros&iacute;, Emergencia Operacional, Caso Excepcional, Informativo y/o reclasificaci&oacute;n).  Estaba incluido en el PECC" width="20" height="20" /></strong></td>
            <td colspan="4" align="left"><?
    
	if($sele_tipo_doc_desierto[13]==4){
		echo "Declarar Desierto - ";
		}
		
	echo saca_nombre_lista($g13,$sel_item[3],'nombre','t1_tipo_proceso_id');
	
	
	?></td>
          </tr>
          <tr >
            <td align="right"><strong>Area Usuaria <img src="../imagenes/botones/help.gif" alt="Qui&eacute;n va a responder y quienes participaron en la aprobaci&oacute;n" title="Qui&eacute;n va a responder y quienes participaron en la aprobaci&oacute;n"  width="20" height="20" /></strong></td>
            <td colspan="4" align="left">
              <table width="98%" border="0" align="center"  class="tabla_lista_resultados">
      <tr class="fondo_desactiva_calendario">
        <td width="34%" align="center">Usuario</td>
        <td width="34%" align="center">Area</td>
        <td width="34%" align="center">Observaci&oacute;n</td>
        </tr>
      <?
			
				
       $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$sel_item[0]." and tipo_adj_permiso = $permiso_o_adjudica and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
		$cont = 0;
		while($sel_p_real = traer_fila_db($sel_propuestos_real)){
			
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = ".$sel_item[0]));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$sel_item[0]." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica"));

			$edita_permiso = "SI";
			if($select_si_tiene_acciones[0] > 0 or $sel_p_real[0] == 8 or $sel_p_real[0] == 10){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				}
			
			$sel_real_us_aprueba = traer_fila_row(query_db("select * from $vpeec15 where id_item_pecc = ".$sel_item[0]." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and estado = 1 and us_id = ".$_SESSION["id_us_session"]." and id_rol not in (8,15) order by nombre_administrador"));
			
			$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and id_item_pecc = ".$sel_item[0]));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
			
			$es_aprobador_indicado_aprueba = "NO";
			if($sel_real_us_aprueba[0]> 0 and $sel_ultima_aprobacion[5] <> 1 and $sel_item[14] == 7){
			$es_aprobador_indicado_aprueba = "SI";
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
        <?
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
        <?
		  }
          	
		  ?>
        <td align="left"><?
          echo $sel_ultima_aprobacion[6];
		  ?></td>
        <td align="center"><?
        
		
		if($sel_p_real[0]==8 or $sel_ultima_aprobacion[3] == 9){
			 echo "Abastecimiento";
			}else{

				$sel_area_usuario=traer_fila_row(query_db("select t1_area.nombre from tseg3_usuario_areas, t1_area where id_usuario = ".$sel_ultima_aprobacion[3]." and t1_area.t1_area_id = tseg3_usuario_areas.id_area"));
				
				if($sel_ultima_aprobacion[3]==18030){
					echo "Perforaci&oacute;n Completamiento y WO";
					}else{
				
				echo $sel_area_usuario[0];
					}
					

				}
		
		?></td>
        <td align="center"><?
         
			  echo $sel_ultima_aprobacion[11];
		
		  ?></td>
        </tr>
      <?
		
        }
		?>
      <?

       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = $permiso_o_adjudica and id_rol = 10 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica"));

			$edita_permiso = "NO";
			if($select_si_tiene_acciones[0] > 0 ){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				}

		?>
      <?
	}
       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = $permiso_o_adjudica and id_rol = 11 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica"));

			$es_aprobador_indicado_aprueba = "NO";
			if(verifica_usuario_indicado(11,$id_item_pecc)=="SI" and $sel_item[14] == 9){
			$es_aprobador_indicado_aprueba = "SI";
				}


		?>
      <?
			}
			
			
		
			
		?>
    </table>
    
            </td>
          </tr>
          <tr class="columna_subtitulo_resultados_letra_normal" >
            <td align="right"><strong>Justificaci&oacute;n T&eacute;cnica <img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
" title="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
"  width="20" height="20" /></strong></td>
            <td colspan="4" align="left"><? echo $justificacion_tecinica;  ?></td>
          </tr>
          <tr >
            <td align="right"><strong>Justificaci&oacute;n Comercial <img src="../imagenes/botones/help.gif" alt="Estrategia: La justificaci&oacute;n del tipo de proceso e invitados a participar. Adjudicaci&oacute;n: mejor costo beneficio de la actividad a contratar" title="Estrategia: La justificaci&oacute;n del tipo de proceso e invitados a participar. Adjudicaci&oacute;n: mejor costo beneficio de la actividad a contratar"  width="20" height="20" /></strong></td>
            <td colspan="4" align="left"><? echo $justificacion_comercial ?></td>
          </tr>
          <tr class="columna_subtitulo_resultados_letra_normal" >
            <td align="right"><strong>Criterios de Evaluacion <img src="../imagenes/botones/help.gif" alt="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico" title="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico"  width="20" height="20" /></strong></td>
            <td colspan="4" align="left"><?=$sel_item[21]?></td>
          </tr>
          <tr >
            <td align="right"><strong>Recomendaci&oacute;n <img src="../imagenes/botones/help.gif" alt="Acci&oacute;n, valor, contratista/proveedor y vigencia
" title="Acci&oacute;n, valor, contratista/proveedor y vigencia
"  width="20" height="20" /></strong></td>
            <td colspan="4" align="left"><?  echo $recomendacion?></td>
          </tr>
          <tr class="columna_subtitulo_resultados_letra_normal" >
            <td align="right"><strong>
              Contratos y/o Solicitudes Relacionados:
              </strong></td>
            <td colspan="4" align="left"><?
    
	if($sel_item[18]>0){

	$sel_umero_relacionada = traer_fila_row(query_db("select num1, num2, num3 from t2_item_pecc where id_item = ".$sel_item[18]));
			echo "<strong>".numero_item_pecc($sel_umero_relacionada[0],$sel_umero_relacionada[1],$sel_umero_relacionada[2])."</strong> ";

		echo contratos_relacionados_comite_solo_contratos($sel_item[18],$permiso_o_adjudica);
		
	}else{
	   echo  contratos_relacionados_comite_solo_contratos($sel_item[0],$permiso_o_adjudica);
	}//si es una solicitud con otra relacionada eje. informativo
	?></td>
          </tr>
          <tr >
            <td align="right"><strong>Proveedores / Contratistas Relacionados:</strong></td>
            <td colspan="4" align="left"><?  echo  contratos_relacionados_comite_solo_proveedores($sel_item[0],$permiso_o_adjudica);?></td>
          </tr>
          <tr class="columna_subtitulo_resultados_letra_normal" >
            <td align="right"><strong>Objeto del Contrato:</strong></td>
            <td colspan="4" align="left"><? if($sel_item[8] == "") echo $sel_item[12]; else echo $sel_item[8] ?></td>
          </tr>
          <tr class="" >
            <td align="right"><strong>Comentario del Secretario del Comit&eacute;:</strong></td>
            <td colspan="3" align="left"><?
    if($tiene_permiso_secretrio == "SI"){
	?>
              <textarea name="comenta_secretario_<?=$sel_sin_comi[0]?>" cols="30" id="comenta_secretario_<?=$sel_sin_comi[0]?>"><?=$sel_sin_comi[11]?>
      </textarea>
              <?
	}else{
		echo $sel_sin_comi[11];
		}
	?></td>
            <td align="left"><?
    if($tiene_permiso_secretrio == "SI"){
	?>
              <input name="sda2" type="button" value="Grabar Comentario" class="boton_grabar" onClick="graba_comentario_comite(<?=$sel_sin_comi[0]?>)" />
              <?
	}
	?></td>
          </tr>
          <?
    if($tiene_permiso_secretrio == "SI" and $sel_item[3]<>8 ){
	?>
          <tr >
            <td colspan="5" align="left" class="columna_subtitulo_resultados_letra_normal"> * Si modifica el valor de la solicitud se perder&aacute; la distribuci&oacute;n de la solicitud y pasara a ser &quot;corporativo sin socios&quot; </td>
          </tr>
          <?
	$style_celda = "border-bottom:#000 2px solid; border-right:#000 2px solid; border-top:#000 2px solid; border-left:#000 2px solid; ";
	}
	?>
          <tr class="columna_subtitulo_resultados_letra_normal" >
            <td align="right" valign="top"><strong>Nuevo Valor de la Solicitud:</strong></td>
            <td colspan="2" align="left" style="<?=$style_celda?>"><?
	  $valor_usd_coo="";
	  $valor_cop_coo="";
	  
	  if($sel_sin_comi[12] == ""){
			$valor_usd_coo == "";
			}else{
				$valor_usd_coo = number_format($sel_sin_comi[12],0);
				}
				
				
		if($sel_sin_comi[15] == ""){
			$valor_cop_coo == "";
			}else{
				$valor_cop_coo = number_format($sel_sin_comi[15],0);
				}
				
    if($tiene_permiso_secretrio == "SI"  and $sel_item[3]<>8){
		

		
		
		
	?>
              <table width="100%" border="0">
                <tr>
                  <td width="18%" align="right">USD$:</td>
                  <td width="82%"><input name="nue_valor_sol_<?=$sel_sin_comi[0]?>" id="nue_valor_sol_<?=$sel_sin_comi[0]?>"  onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" value="<?=$valor_usd_coo?>" size="30" /></td>
                </tr>
                <tr>
                  <td align="right">COP$:</td>
                  <td><input name="nue_valor_sol_<?=$sel_sin_comi[0]?>_cop" id="nue_valor_sol_<?=$sel_sin_comi[0]?>_cop"  onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" value="<?=$valor_cop_coo?>" size="30" /></td>
                </tr>
              </table>
              <?

    
	if($sel_item[3] == 7){// si es ampliacion carga los contratos
	
	$sele_presupuesto_contras_aplicas = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = " . $_GET['permiso_o_adjudica'] . " and $g15.t1_campo_id = $pi8.t1_campo_id");
	$id_contras_de_solis="0";
	
	while($sel_presu_apica_contra = traer_fila_db($sele_presupuesto_contras_aplicas)){
		$sel_contr = query_db("select t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu_apica_contra[0]);
		

			while($sel_apl_cctra = traer_fila_db($sel_contr)){
				$id_contras_de_solis=$id_contras_de_solis.",".$sel_apl_cctra[0];
				
				
			}
	}

		if($id_contras_de_solis <> "0"){
			$comple_contras_sql_apli = " and id_contrato in ($id_contras_de_solis)";
			}else{
			$comple_contras_sql_apli="";
			}
		
      $sele_contratos_mar_ampli = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$sel_item[17]." and t1_tipo_documento_id = 2 $comple_contras_sql_apli");
				?>
              <table width="100%" border="0" align="right" class="tabla_lista_resultados" cellpadding="2" cellspacing="2">
                <tr class="fondo_titulu_calendario">
                  <td width="70%" align="center">Numero del Contrato Marco</td>
                  <td width="30%" align="center">Selecci&oacute;n</td>
                </tr>
                <?
				while($sel_cont_mar_ampli = traer_fila_db($sele_contratos_mar_ampli)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_cont_mar_ampli[2]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont_mar_ampli[1];
					$numero_contrato4 = $sel_cont_mar_ampli[3];

				?>
                <tr>
                  <td align="center"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_cont_mar_ampli[0])?></td>
                  <td align="center"><input type="checkbox" name="contra_<?=$sel_cont_mar_ampli[0]?>_<?=$sel_sin_comi[0]?>" id="contra_<?=$sel_cont_mar_ampli[0]?>_<?=$sel_sin_comi[0]?>" value="<?=$sel_cont_mar_ampli[0]?>" /></td>
                </tr>
                <?				
				}
				?>
              </table>
              <?
	}//fin si es ampliacion cargua contratos
	
	
	
	}else{
		if($sel_sin_comi[12]<>""){
		echo "USD$: ".$valor_usd_coo."<br />";
		echo "COP$: ".$valor_cop_coo;
		}
		}
	?></td>
            <td align="left" valign="bottom"><?
    if($tiene_permiso_secretrio == "SI"  and $sel_item[3]<>8){
	?>
              <input name="sda3" type="button" value="Grabar Nuevo Valor" class="boton_grabar" onClick="graba_nuevo_valor(<?=$sel_sin_comi[0]?>, document.principal.nue_valor_sol_<?=$sel_sin_comi[0]?>_cop.value, document.principal.nue_valor_sol_<?=$sel_sin_comi[0]?>.value)" />
              <?
	}
	?></td>
            <td align="left">&nbsp;</td>
          </tr>            
          <tr >
            <td colspan="5" align="right"><table width="100%" border="0" align="center">
              <tr>
                <td width="60%" valign="top"><table width="100%" border="0" class="tabla_lista_resultados">
                  <tr class="fondo_titulu_calendario">
                    <td colspan="4" align="center">Aprobaciones del Comit&eacute;</td>
                    </tr>
                  <tr class="fondo_titulu_calendario">
                    <td width="37%" align="center">Usuario</td>
                    <td width="19%" align="center">Rol</td>
                    <td width="19%" align="center">Firma</td>
                    <td width="44%" align="center">Observaci&oacute;n</td>
                  </tr>
                  <tr>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                  </tr>
                  <?
      $asistentes = query_db("SELECT dbo.t3_comite_asistentes.id_asistente, dbo.t3_comite_asistentes.id_us, dbo.t3_comite_asistentes.id_comite, 
               dbo.t1_us_usuarios.nombre_administrador, dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.rol_aprobacion, 
               dbo.t3_comite_asistentes.orden, dbo.t3_comite_asistentes.estado
FROM  dbo.t1_us_usuarios INNER JOIN
               dbo.t3_comite_asistentes ON dbo.t1_us_usuarios.us_id = dbo.t3_comite_asistentes.id_us
WHERE (dbo.t3_comite_asistentes.estado = 1) and dbo.t3_comite_asistentes.requiere_aprobacion = 1 and dbo.t3_comite_asistentes.id_comite =".$id_comite."
ORDER BY dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.orden");
$cont = 0;
		while($sel_aproba = traer_fila_db($asistentes)){
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select max(id_aprobacion) from $c4 where id_asistente =  ".$sel_aproba[0]." and id_item =".$sel_sin_comi[0]));
			$sel_aprobacion = traer_fila_row(query_db("select * from $c4 where id_aprobacion =  ".$sel_ultima_aprobacion[0]));
			if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  
		  $sel_rol = traer_fila_row(query_db("select * from $c3 where id_asistente=".$sel_aproba[0]));
	  ?>
                  <tr  class="<?=$clase?>">
                    <td align="center"><?=$sel_aproba[3]?></td>
                    <td align="center"><?=$sel_rol[3]?></td>
                    <td align="center"><? if($sel_aprobacion[5] == 1) echo $nombre_firma_3; ?>
                      <? if($sel_aprobacion[5] == 4) echo $nombre_firma_3.' con Comentarios'?>
                      <? if($sel_aprobacion[5] == 2) echo $nombre_firma_4?>
                      <? if($sel_aprobacion[5] == 10) echo "Rechazado"?>
                      
                      
                      </td>
                    <td align="center"><?=$sel_aprobacion[6]?></td>
                  </tr>
                  <?
}
	  ?>
                </table></td>
                
              </tr>

            </table></td>
          </tr>
        </table></td>
      </tr>
      <?
}

 
		?>
    </table></td>
  </tr>
<tr>
  <td align="right">
  <?


 
		?>
  <input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"' style="width:100px;" /></td>
</tr>  
</table>


</body>
</html>



