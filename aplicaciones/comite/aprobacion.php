<? include("../../librerias/lib/@session.php");
$id_comite = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));

$sele_comite = traer_fila_row(query_db("select * from $c1 where id_comite = " . $id_comite . ""));

$edicion_datos_generales = "NO";
$tiene_permiso_secretrio = "NO";
$verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 10 and us_id =" . $_SESSION["id_us_session"]));
if ($verifica_permiso[0] > 0 and $sele_comite[4] == 3 and $_GET["id_item_consulta_firma"] ==0) {
    $tiene_permiso_secretrio = "SI";
}

$sel_us_revisa_sap = traer_fila_row(query_db("select * from v_seg1 where us_id = " . $_SESSION["id_us_session"] . " and id_premiso = 36"));
if ($sel_us_revisa_sap[0] > 0) {
    $activa_revision_sap = "SI";
}
?>


<head>
    <title>Documento sin t&iacute;tulo</title>
    <link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>
<body>


<?
if($_GET["id_item_consulta_firma"] > 0){
		$comple_sql_consulta_desde_firma= " and id_item = ".$_GET["id_item_consulta_firma"]." ";
		?><table width="70%" border="0" align='center' cellpadding="2" cellspacing="2" style="background-color:#fff;">
  <tr>
    <td align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none";' style="width:100px;" /></td>
  </tr>
  <tr>
    <td align="right">
<?
		}	
?>

    <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
            <td valign="top" ><a name="inicio_comite_href"></a><?= encabezado_comite($id_comite) ?>

            </td>
        </tr>
        <tr>
            <td valign="top">
            
            
            <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                    <?
                    $conse_div = 0;
					
				
	//	echo $comple_sql_consulta_desde_firma;
		
					if($sele_comite[4]==1 and ($_GET["id_item_consulta_firma"] ==0 or $_GET["id_item_consulta_firma"] =="")){
/*agrega si aplica comite paar despues poder ordenar*/
	
	$total_item = query_db("select id_item from $c2 where id_comite =  ".$sele_comite[0]);
    $sum_valor = 0;
    while ($t_item = traer_fila_db($total_item)) {	
	$sel_item_solo_aca = traer_fila_row(query_db("select num2 from t2_item_pecc where id_item =".$t_item[0]));
	$sel_permiso_ad=traer_fila_row(query_db("select permiso_o_adjudica from t3_comite_relacion_item where id_comite=".$sele_comite[0]." and  id_item =". $t_item[0]));
    $permiso_ad=$sel_permiso_ad[0];	
		 $sel_presupuesto = traer_fila_row(query_db("select sum(valor_cop), sum(valor_usd) from $pi8 where t2_item_pecc_id = " . $t_item[0] . " and permiso_o_adjudica = ".$permiso_ad ));            
                $val_usd = ($sel_presupuesto[0] / trm_presupuestal($sel_item_solo_aca[0])) + $sel_presupuesto[1];
            		
       
        if ($val_usd >= MONTO_COMITE) {
            $update = query_db("update $c2 set aplica_presidente = 1, valor_solicitud_comite = '".arregla_numero_db1($val_usd)."' where id_comite = ".$sele_comite[0]." and id_item = ".$t_item[0]);
        }else{
			$update = query_db("update $c2 set aplica_presidente = 2, valor_solicitud_comite = '".arregla_numero_db1($val_usd)."' where id_comite = ".$sele_comite[0]." and id_item = ".$t_item[0]);
			}
    }
	$val_usd=0;
	$sum_valor = 0;			
		/*agrega si aplica comite paar despues poder ordenar*/				
						
						
						$sql_comple_order = "order by valor_solicitud_comite desc";
						}else{
							$sql_comple_order = "order by orden asc";
							}
							

$semaforo=0;
					 $sql_sele_com = "SELECT id_item, id_comite, estado, num1, num2, num3, fecha_se_requiere, eq_usd, orden, id_relacion, permiso_o_adjudica, CAST (comentario_secretrario AS TEXT), nuevo_valor_solicitud, area, nombre_administrador, nuevo_valor_solicitud_cop, objeto_solicitud, ob_solicitud_adjudica, t1_area_id, id_us, presidente, aplica_presidente, CAST(comentario_presidente AS TEXT), CAST(campo_contrato_vencimiento AS TEXT), valor_solicitado_cop, valor_solicitado_usd, valor_solicitado_eq, tipo_proceso, es_modificacion from v_comite_item_agregado where id_comite = " . $id_comite . " and estado <> 3 ".$comple_sql_consulta_desde_firma.$sql_comple_order;
					//echo $sql_sele_com;
							/*
							if($_SESSION["id_us_session"]==32){
								echo $sql_sele_com;
							exit;
							}*/
							
                    $sel_item_sin_comite = query_db($sql_sele_com);
                    while ($sel_sin_comi = traer_fila_db($sel_item_sin_comite)) {
                        
						if ($conse_div==9){$mostrar_volver = "SI";}
						elseif ($conse_div==19){$mostrar_volver = "SI";}
						elseif ($conse_div==29){$mostrar_volver = "SI";}
						elseif ($conse_div==39){$mostrar_volver = "SI";}
						elseif ($conse_div==49){$mostrar_volver = "SI";}
						elseif ($conse_div==59){$mostrar_volver = "SI";}
						elseif ($conse_div==69){$mostrar_volver = "SI";}
						elseif ($conse_div==79){$mostrar_volver = "SI";}
						elseif ($conse_div==89){$mostrar_volver = "SI";}
						elseif ($conse_div==99){$mostrar_volver = "SI";}
						else{$mostrar_volver = "NO";}
						
						
                        $conse_div = $conse_div + 1;
                        $permiso_o_adjudica = $sel_sin_comi[10];
						
                        ?>
                        <?
						
                        $sel_item = traer_fila_row(query_db("select "
                                . "id_item,"
                                . "CAST(objeto_solicitud AS TEXT), "
                                . "estado, "
                                . "t1_tipo_proceso_id,"
                                . "CAST(alcance AS TEXT),"
                                . "CAST(justificacion AS TEXT),"
                                . "CAST(recomendacion AS TEXT), "
                                . "CAST(ob_solicitud_adjudica AS TEXT),"
                                . "CAST(ob_contrato_adjudica AS TEXT),"
                                . "CAST(alcance_adjudica AS TEXT),"
                                . "CAST(justificacion_adjudica AS TEXT),"
                                . "CAST(recomendacion_adjudica AS TEXT),"
                                . "CAST(objeto_contrato AS TEXT), "
                                . "t1_area_id, "
                                . "t1_trm_id,contrato_id, "
                                . "proveedores_sugeridos, "
                                . "id_item_peec_aplica,"
                                . "id_solicitud_relacionada,"
                                . "CAST(justificacion_tecnica AS TEXT),"
                                . "CAST( justificacion_tecnica_ad AS TEXT),"
                                . "CAST( criterios_evaluacion AS TEXT), "
								. "CAST( antecedentes_permiso AS TEXT), "
								. "CAST( antecedentes_adjudicacion AS TEXT), "
								. "convirte_marco, es_modificacion from $pi2 where id_item=" . $sel_sin_comi[0]));


                        $sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='" . $sel_sin_comi[0] . "'"));


                        if ($sel_item[3] == 11) {
                            $nombre_firma_1 = "Informado";
                            $nombre_firma_2 = "NO Informado";
                            $nombre_firma_3 = "Informado";
                            $nombre_firma_4 = "NO Informado";
                        } elseif ($sele_tipo_doc_desierto[13] == 4) {//si es Declaracion Desierta
                            $nombre_firma_1 = "Declarar Desierto";
                            $nombre_firma_2 = "Pendiente; Sacar de este Comit&eacute;";
                            $nombre_firma_3 = "Declarado Desierto";
                            $nombre_firma_4 = "Pendiente; Sacar de este Comit&eacute;";
                        } else {
                            $nombre_firma_1 = "Firmar";
                            $nombre_firma_2 = "Pendiente; Sacar de este Comit&eacute;";
                            $nombre_firma_3 = "Firmado";
                            $nombre_firma_4 = "Pendiente; Sacar de este Comit&eacute;";
                        }

						
						
						
					
										  /*Valores*/
		
		
												$valor_solicitud = explode("---",valor_solicitud($sel_item[0], $permiso_o_adjudica));

												$valor_usd_sol_esp = $valor_solicitud[0];
												$valor_cop_sol_esp = $valor_solicitud[1];


											/*Valores*/
										
                       
                       
                        if ($sel_item[3] == 11) {
                            $sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));
                        } elseif ($sel_item[3] == 5 or $sel_item[3] == 7 or $sel_item[3] == 10) {
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));
                        }elseif ($sel_item[3] == 12 and $sel_item[24] == 3){//si es reclasificacion de contrato marco							
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1 and al_valor_inicial_para_marco = 1"));		
						}elseif ($sel_item[3] == 12 and $sel_item[24] != 3){//si es reclasificacion de contrato puntual							
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));		
							}else{
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = $permiso_o_adjudica"));
							}
						
						if ($sel_item[3] == 12) {
                            
                        }

                        $sel_trm = traer_fila_row(query_db(" select valor from t1_trm where id_trm =" . $sel_item[14]));

                        $sele_nivel_anterior = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3  where id_item=" . $sel_item[0] . " and actividad_estado_id < 7 and  estado = 1"));
                        $sele_datos_actividad = traer_fila_row(query_db("select fecha_real from $vpeec3  where id_item=" . $sel_item[0] . " and actividad_estado_id = " . $sele_nivel_anterior[0] . " and  estado = 1"));


                        $id_tipo_proceso_pecc = 1;
                        if ($sel_item[3] == 7) {
                            $id_tipo_proceso_pecc = 2;
                        }
                        if ($sel_item[3] == 8) {
                            $id_tipo_proceso_pecc = 3;
                        }



                        $objeto_solicitud = "";
                        $alcance = "";
                        $justificacion_tecinica = "";
                        $justificacion_comercial = "";
                        $criterios_evaluacion = "";
                        $recomendacion = "";
						$antecedentes="";

//"select id_item,1, 2, t1_tipo_proceso_id,CAST(alcance AS TEXT),5,6, 7,CAST(ob_contrato_adjudica AS TEXT),alcance_adjudica,CAST(justificacion_adjudica AS TEXT),CAST(recomendacion_adjudica AS TEXT),CAST(objeto_contrato AS TEXT), t1_area_id, t1_trm_id,contrato_id, proveedores_sugeridos, id_item_peec_aplica,id_solicitud_relacionada,19,20,CAST( criterios_evaluacion AS TEXT) from $pi2 where id_item=".$sel_sin_comi[0]

                        if ($sel_item[3] <= 3) {

                            if ($permiso_o_adjudica == 1) {
                                $objeto_solicitud = $sel_item[1];
                                $alcance = $sel_item[4];
                                $justificacion_tecinica = $sel_item[19];
                                $justificacion_comercial = $sel_item[5];
                                $recomendacion = $sel_item[6];
                            }

                            if ($permiso_o_adjudica == 2) {
                                $objeto_solicitud = $sel_item[7];
                                $alcance = $sel_item[9];
                                $justificacion_tecinica = $sel_item[20];
                                $justificacion_comercial = $sel_item[10];
                                $recomendacion = $sel_item[11];
								$antecedentes=$sel_item[23];
                            }
                        } else {
                            if ($sel_item[1] == "")
                                $objeto_solicitud = $sel_item[7];
                            else
                                $objeto_solicitud = $sel_item[1];
                            if ($sel_item[9] == "")
                                $alcance = $sel_item[4];
                            else
                                $alcance = $sel_item[9];
                            if ($sel_item[20] == "")
                                $justificacion_tecinica = $sel_item[19];
                            else
                                $justificacion_tecinica = $sel_item[20];
                            if ($sel_item[10] == "")
                                $justificacion_comercial = $sel_item[5];
                            else
                                $justificacion_comercial = $sel_item[10];
                            if ($sel_item[6] == "")
                                $recomendacion = $sel_item[11];
                            else
                                $recomendacion = $sel_item[6];
						    if ($sel_item[23] == "")
                                $antecedentes = $sel_item[22];
                            else
                                $antecedentes = $sel_item[23];
                        }
						
						
						
						if($sel_presupuesto[1] > 0) {
                                        $val_usd = ($valor_cop_sol_esp / trm_presupuestal($sel_sin_comi[4]) + $valor_usd_sol_esp);
                                    }else{
                                        $val_usd = $valor_usd_sol_esp;
                                    }
						
						
						if($sel_sin_comi[23]==""){//si no tiene el valor solicitado ingresarlo
							$update = query_db("update t3_comite_relacion_item set valor_solicitado_cop = '".$valor_cop_sol_esp."', valor_solicitado_usd = '".$valor_usd_sol_esp."', valor_solicitado_eq='".$val_usd."' where id_relacion = ".$sel_sin_comi[9]);
							}
							
							
							
						$sel_valores = traer_fila_row(query_db("select valor_solicitado_usd, valor_solicitado_cop,  valor_solicitado_eq from  t3_comite_relacion_item where id_relacion = ".$sel_sin_comi[9]));
						if ($val_usd < MONTO_COMITE and $sele_comite[4]==1 and $semaforo == 0 and $sele_comite[0]<117) {
							$semaforo=1;
                        ?>
                        
                        
                        <tr >
                          <td colspan="2" align="center" valign="bottom" class="linea_roja_abajo">&nbsp;</td>
                        </tr>
                        <tr >
                          <td width="85%" align="center" valign="bottom" class="tabla_alerta_comite"><strong><font size="+2">
NO REQUIEREN VERIFICACION (SOLICITUDES MENORES DE USD $
  <?=number_format(MONTO_COMITE)?>) </font></strong></td>
                          <td width="15%" align="right" valign="bottom" class="tabla_alerta_comite"><strong ><img src="../imagenes/botones/volver_inicio.png" style="cursor:pointer" onClick="fnGo()"/></strong></td>
                        </tr>
                        
                        
                        <tr >
                          <td colspan="2" align="center" valign="bottom" class="linea_roja_top">&nbsp;</td>
                        </tr>
                        
                        
                        <?
						}
                        $bandera=false;
                        $query="SELECT descarga_archivo_conflicto, revisa_archivo_conflicto FROM t3_comite_relacion_item WHERE id_comite=$id_comite AND id_item=$sel_sin_comi[0]";
                        $result=traer_fila_row(query_db($query));
                        if(($result[0]!=3 && $result[1]!=3) && $result[1]!=1){//  && $result[1]==2SI YA SE VALIDÓ LOS CONFLICTOS DE INTERÉS MUESTRA EL PROCESO, SI NO LO OCULTA HASTA QUE EL SECRETARIO DEL COMITÉ LO VALIDE ($result[0]!=0 && $result[1]!=0) || ($result[0]==NULL && $result[1]==NULL)
						?>
                        <tr ><!-- INICIO TABLA SOLICITUD  -->
                            <td colspan="2" align="center"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_aproba_comite">
                                    <tr >
                                        <td colspan="6" align="center" class="fondo_3"><strong>Datos de la Solicitud <font size="+2">
                                                <?= numero_item_pecc($sel_sin_comi[3], $sel_sin_comi[4], $sel_sin_comi[5]) ?>
                                                </font> </strong>
                                                <? if($_GET["id_item_consulta_firma"] ==0){ ?>
                                                <strong class="titulo_calendario_real_bien" onClick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc-comite.php?id_item_pecc=<?= $sel_item[0] ?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?= $conse_div ?>&permiso_o_adjudica=<?=$permiso_o_adjudica ?>')" > <img src="../imagenes/botones/detalle.png" height="30" /></strong>
                                                <? }?>
                                                
                                                <?
												$faltas_por_el_cambio = "";
                                                 $sel_si_tien_cambios = traer_fila_row(query_db("select * from vista_comite_relacion_cambios_tp where id_comite=".$id_comite."  and  id_item = ".$sel_item[0]));
												 
												if($sel_si_tien_cambios[7]== 1){$faltas_por_el_cambio = "";}
												if($sel_si_tien_cambios[7]== 2){$faltas_por_el_cambio = "Debido a que el tipo de proceso de esta solicitud cambio, por favor relacione el Numero de contrato Relacionado";}
												if($sel_si_tien_cambios[7]== 3){$faltas_por_el_cambio = "Debido a que el tipo de proceso de esta solicitud cambio, por favor relacione el Numero de contrato Relacionado y los antecedentes (texto y adjunto)";}
												if($sel_si_tien_cambios[7]== 4){$faltas_por_el_cambio = "Debido a que el tipo de proceso de esta solicitud cambio, por favor relacione los Proveedores";}
												if($sel_si_tien_cambios[7]== 5){$faltas_por_el_cambio = "Debido a que el tipo de proceso de esta solicitud cambio, por favor relacione los Valores y Proveedores de la Adjudicaci&oacute;n";}
												if($faltas_por_el_cambio!="" and $tiene_permiso_secretrio == "SI"){
													echo "<strong class='letra-descuentos'>".$faltas_por_el_cambio."<strong>";
													}

												?>
                                                </td>
                                    </tr>

                                    <tr >
                                      <td align="right"><strong>Proveedores / Contratistas:</strong></td>
                                      <td colspan="5" align="left"><?php echo contratos_relacionados_comite_solo_proveedores($sel_item[0], $permiso_o_adjudica); ?></td>
                                    </tr>
                                    <tr >
                                      <td align="right"><strong>Contratos y/o Solicitudes :</strong></td>
                                      <td colspan="5" align="left"><?php
                                            if ($sel_item[18] > 0 and $sel_item[3] != 12) {

                                                $sel_umero_relacionada = traer_fila_row(query_db("select num1, num2, num3, id_item from t2_item_pecc where id_item = " . $sel_item[18]));
												/**** PARA EL DESARROLLO DE MOSTRAR LAS MODIFICACIONES *****/
                                                echo "<strong> <a onclick='document.getElementById(&quot;carga_modal_pecc&quot;).style.display=&quot;block&quot;;ajax_carga(&quot;../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$sel_umero_relacionada[3]."&id_tipo_proceso_pecc=1&tipo_carga=99&quot;,&quot;carga_modal_pecc&quot;)' style='cursor:pointer;' > ".numero_item_pecc($sel_umero_relacionada[0],$sel_umero_relacionada[1],$sel_umero_relacionada[2])." </a> </strong> ";
												/**** FIN PARA EL DESARROLLO DE MOSTRAR LAS MODIFICACIONES *****/
							  if($sel_sin_comi[2] == 2 or $sel_sin_comi[23] == ""){//si el estado de la solciitud es pendiente (2) muestre el resultado de la funcion
                                                echo $imprimir_de_funcion = contratos_relacionados_comite_solo_contratos($sel_item[18], $permiso_o_adjudica, $sel_item[0]);
							  }else{//si el estado ya es diferente de pendiente muestre lo que se guardo en la aprobacion
								  echo $sel_sin_comi[23];
								  }
                                            } else {
												if($sel_item[3] == 1 or $sel_item[3] == 2 or $sel_item[3] == 3 or $sel_item[3] == 6){
													echo "";//esto es para evitar que si aun no ha creado contratos no los muestre
													}else{
												
							if($sel_sin_comi[2] == 2 or $sel_sin_comi[23] == ""){//si el estado de la solciitud es pendiente (2) muestre el resultado de la funcion
                                                echo $imprimir_de_funcion = contratos_relacionados_comite_solo_contratos($sel_item[0], $permiso_o_adjudica);
							 }else{//si el estado ya es diferente de pendiente muestre lo que se guardo en la aprobacion
								  echo $sel_sin_comi[23];
								  }
											}
                                            }//si es una solicitud con otra relacionada eje. informativo
											
											
											
											if($sel_sin_comi[2] == 2){
	$uodate_terminacion = query_db("update t3_comite_relacion_item set campo_contrato_vencimiento = '".$imprimir_de_funcion."' where id_relacion = ".$sel_sin_comi[9]);									
											}
											
											
											if($sel_item[18]>0 and $sel_item[25]==1){
//				$sel_item_relacionado = traer_fila_row(query_db("select num1, num2, num3 from $pi2 where id_item=".$sel_item[18]));
				echo "<font color ='#ff0000'> Atenci&oacute;n: Esta solicitud es una modificaci&oacute;n </font>";
				}
				
                                            ?></td>
                                    </tr>
                                    <tr >
                                      <td align="right"><strong>Tipo de Contrato:</strong></td>
                                      <td colspan="5" align="left"><?
									  $tipo_contrato = "";
                                      if($sel_item[3]==5 or $sel_item[3]==4 or $sel_item[3]==10 or $sel_item[3]==15 or $sel_item[3]==11){
										  
						  	$sql_con = traer_fila_row(query_db("select t1_tipo_documento_id, oferta_mercantil from $co1 where id = ".$sel_item[15]));
										if($sel_item[15] > 0){//si tiene relacionado un contrato
										  if($sql_con[0]==1){
												$tipo_contrato = "CONTRATO PUNTUAL";
											}
											if($sql_con[1]==1 and $sql_con[0]==1){
												$tipo_contrato = "ACEPTACION DE OFERTA MERCANTIL";
												}
											if($sql_con[1]==2){
												$tipo_contrato = "CONTRATO MARCO";
											}
										}
										}elseif($sel_item[3]==8 or $sel_item[3]==7){
											  	$tipo_contrato = "CONTRATO MARCO";
											  }
										elseif(($sel_item[3]==1 or $sel_item[3]==2 or $sel_item[3]==3 or $sel_item[3]==6) and $sel_item[2]==17){
								$sele_tipo_doc = traer_fila_row(query_db("select tipo_doc_adjudica from v_pecc_tipo_adjudicacion where id_item =".$sel_item[0].""));	
													$tipo_contrato=$sele_tipo_doc[0];
													if($tipo_contrato ==""){
														$sele_tipo_doc = traer_fila_row(query_db("select tipo_doc_adjudica from v_pecc_tipo_adjudicacion_marco where id_item =".$sel_item[0].""));	
														$tipo_contrato=$sele_tipo_doc[0];
														}
													
													
											  }elseif($sel_item[3]==12){
												  if($sel_item[24]==3){
												  $tipo_contrato = "CONTRATO MARCO";
												  }else{
													  $tipo_contrato = "CONTRATO PUNTUAL";
													  }
												  }
										echo ucwords(strtolower($tipo_contrato));
									  ?></td>
                                    </tr>
                                    <?php
                                        $query="SELECT tiene_reajuste, tiene_reembolsable, req_contra_mano_obra_local_ad, req_contra_serv_bien_local_ad FROM $pi2 WHERE id_item=".$sel_item[0];
                                        $tiene=traer_fila_row(query_db($query));
                                    ?>
                                    <tr>                                       
                                        <td width="231" align="right"><strong>Tiene Reajustes:</strong></td>
                                        <td colspan="5" align="left"><? if($tiene[0]!=NULL){if($tiene[0]==1){echo "Si";}else{echo "No";}}?></td>
                                    </tr>
                                    <tr>                                       
                                        <td width="231" align="right"><strong>Tiene Reembolsables:</strong></td>
                                        <td colspan="5" align="left"><? if($tiene[1]!=NULL){if($tiene[1]==1){echo "Si";}elseif($tiene[1]==2){echo "No";}}?></td>
                                    </tr>
                                    <?
                                    if($tiene[2]==1 || $tiene[2]==2){
                                    ?>
                                        <tr>                                       
                                            <td width="231" align="right"><strong>Requiere contrataci&oacute;n de mano de obra local:</strong></td>
                                            <td colspan="5" align="left"><? if($tiene[2]!=NULL){if($tiene[2]==1){echo "Si";}else{echo "No";}}?></td>
                                        </tr>
                                    <?
                                    }
                                    ?>
                                    <?
                                    if($tiene[3]==1 || $tiene[3]==2){
                                    ?>
                                        <tr>                                       
                                            <td width="231" align="right"><strong>Requiere contrataci&oacute;n de bienes y servicios:</strong></td>
                                            <td colspan="5" align="left"><? if($tiene[3]!=NULL){if($tiene[3]==1){echo "Si";}else{echo "No";}}?></td>
                                        </tr>
                                    <?
                                    }
                                    ?>
                                    <tr >
                                        <td width="231" align="right"><strong>Objeto de la Solicitud <img src="../imagenes/botones/help.gif" alt="Qu&eacute; se va a contratar" title="Qu&eacute; se va a contratar" width="20" height="20" /></strong></td>
                                        <td colspan="5" align="left"><? echo nl2br($objeto_solicitud);  ?></td>
                                    </tr>
                                    <tr class="columna_subtitulo_resultados_letra_normal" >
                                        <td align="right"><strong>Alcance <img src="../imagenes/botones/help.gif" alt="Para qu&eacute; se contrata
                                                                               " title="Para qu&eacute; se contrata
                                                                               "  width="20" height="20" /></strong></td>
                                        <td colspan="5" align="left"><? echo nl2br($alcance) ?></td>
                                    </tr>
                                    
                                  <?
                              //     $sele_antecendete_comite = traer_fila_row(query_db("select count(*) from $pi9 where t2_item_pecc_id = '".$sel_item[0]."' and estado = 1 and tipo = 'antecedente' and antecedente_comite = 1"));
					if($antecedentes!=""){
								  ?>  
                                    <tr >
                                      <td align="right"><strong>Antecedentes</strong><img src="../imagenes/botones/help.gif" alt="Seleccion de Anexos de la revision del item de adjudicacion'" width="20" height="20" /></td>
                                      <td colspan="5" align="left"><? echo $antecedentes;
									  $sl_anexos = traer_fila_row(query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us, antecedente_comite
 from $pi9 where t2_item_pecc_id = '".$sel_item[0]."' and estado = 1 and tipo = 'antecedente' and antecedente_comite = 1"));
 
 if($sl_anexos[0]>0 and $sl_anexos[5] != " "){
	 echo " <br /> <strong>Antecedente Adjunto:</strong> ";
			  ?>
                <?=saca_nombre_anexo($sl_anexos[5])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
                <?
 }
									  ?></td>
                                    </tr>
                               <?
					}// fin antecedentes
					?>     
                               
                                    <tr >
                                        <td align="right"><strong>Valor Solicitado <img src="../imagenes/botones/help.gif" alt="Costo del servicio o suministro a contratar
                                                                                               " title="Costo del servicio o suministro a contratar
                                                                                               "  width="20" height="20" /></strong></td>
                                        <td width="59"   align="right">USD$:</td>
                                        <td width="68" align="left"><?= number_format($sel_valores[0], 0) ?> </td>
                                        <td width="101" align="left" class="">&nbsp;</td>
                                        <td width="238" align="right" valign="top"></td>
                                        <td align="left" valign="top">
                                        </td>
                                    </tr>
                                    <tr  >
                                        <td align="right">&nbsp;</td>
                                        <?php
                                        $q_us = $sel_presupuesto[1] / $sel_trm[0] + $sel_presupuesto[0];
                                        ?>
                                        <td width="59" 	align="right">COP$:</td>
                                        <td align="left"><?= number_format($sel_valores[1], 0) ?></td>
                                        <td align="left" class="">&nbsp;</td>
                                        <td align="right" valign="top">&nbsp;</td>
                                        <td align="right" valign="top"></td>
                                    </tr>
                                    <tr  >
                                      <td rowspan="2" align="right" valign="top" class="columna_subtitulo_resultados_letra_normal"><strong>Valor Aprobado en el Comit&eacute;:</strong></td>
                                      <td   align="right" class="columna_subtitulo_resultados_letra_normal">USD$:</td>
                                      
                                      
                                      <td align="left" class="columna_subtitulo_resultados_letra_normal">
                                      
                                      <?=number_format($valor_usd_sol_esp, 0)?></td>
                                      <td rowspan="2" align="left" >&nbsp;</td>
                                      <td colspan="2" align="left" valign="bottom"></td>
                                    </tr>
                                    <tr  >
                                      <td 	class="columna_subtitulo_resultados_letra_normal"align="right">COP$:                                      </td>
                                      <td align="left" class="columna_subtitulo_resultados_letra_normal"><?=number_format($valor_cop_sol_esp, 0)?></td>
                                      <td colspan="2" align="right" valign="bottom"></td>
                                    </tr>
                                    <tr  >
                                      <td colspan="6" align="right"></td>
                                    </tr>
                                    <tr  >
                                        <td align="right"><strong>Tipo de Proceso <img src="../imagenes/botones/help.gif" alt="Como vamos a adquirir los B&amp;S. (Negociaci&oacute;n directa, Invitaci&oacute;n a Proponer, Otros&iacute;, Emergencia Operacional, Caso Excepcional, Informativo y/o reclasificaci&oacute;n).  Estaba incluido en el PECC"  title="Como vamos a adquirir los B&amp;S. (Negociaci&oacute;n directa, Invitaci&oacute;n a Proponer, Otros&iacute;, Emergencia Operacional, Caso Excepcional, Informativo y/o reclasificaci&oacute;n).  Estaba incluido en el PECC" width="20" height="20" /></strong></td>
                                        <td colspan="5" align="left"><?php
                                            

                                            //echo saca_nombre_lista($g13, $sel_item[3], 'nombre', 't1_tipo_proceso_id'); $tiene[2]
                                            ?>
                                          <table width="98%" border="0" class="tabla_lista_resultados">
                                            <tr class="fondo_3">
                                              <td colspan="2" align="center">PERMISO</td>
                                              <td colspan="2" align="center">ADJUDICACION</td>
                                            </tr>
                                            <tr class="filas_resultados"> 
                                              <?
                                          $culo = "<img src='../imagenes/botones/chulo_sin_fondo.gif' />";
										  if ($sele_tipo_doc_desierto[13] == 4) {
                                             //   echo "Declarar Desierto - ";
                                            }
											$tipo_proceso_muestra =$sel_item[3]; 
										if($sel_sin_comi[27] != "" and $sel_sin_comi[27] > 0){
											$tipo_proceso_muestra = $sel_sin_comi[27];
											}
										  ?>
                                              <td width="3%"><? if($tipo_proceso_muestra == 1 or $tipo_proceso_muestra == 17) {echo $culo;} ?></td>
                                              <td width="47%">Licitaci&oacute;n</td>
                                              <td width="3%"><? if($permiso_o_adjudica == 2 and ($tipo_proceso_muestra == 1 or $tipo_proceso_muestra == 17)) {echo $culo;}?></td>
                                              <td width="47%">Licitaci&oacute;n</td>
                                            </tr>
                                            <tr class="filas_resultados_blanco">
                                              <td><? if($tipo_proceso_muestra == 2 or $tipo_proceso_muestra == 3) {echo $culo;} ?></td>
                                              <td>Negociaci&oacute;n Directa</td>
                                              <td><? if($permiso_o_adjudica == 2 and ($tipo_proceso_muestra == 2 or $tipo_proceso_muestra == 3)) {echo $culo;}?></td>
                                              <td>Negociaci&oacute;n Directa</td>
                                            </tr>
                                            <tr  class="filas_resultados">
                                              <td><? if($tipo_proceso_muestra == 15 or $sel_sin_comi[28] == 1) {echo $culo;} ?></td>
                                              <td>Modificaci&oacute;n</td>
                                              <td><? if($tipo_proceso_muestra == 5 or $tipo_proceso_muestra == 4 or $tipo_proceso_muestra == 13 or $tipo_proceso_muestra == 14 or $tipo_proceso_muestra == 13 or $tipo_proceso_muestra == 7) {echo $culo;} ?></td>
                                              <td>Otro S&iacute; <? if($tipo_proceso_muestra == 7) {echo " - Contrato Marco";} if($tipo_proceso_muestra == 5 or $tipo_proceso_muestra == 4 or $tipo_proceso_muestra == 13 or $tipo_proceso_muestra == 14 or $tipo_proceso_muestra == 13) { echo " - Contrato Puntual";}?></td>
                                            </tr>
                                            <tr class="filas_resultados_blanco">
                                              <td><? if($tipo_proceso_muestra == 12) {echo $culo;} ?></td>
                                              <td>Reclasificaci&oacute;n</td>
                                              <td><? if($tipo_proceso_muestra == 6 or $tipo_proceso_muestra == 18) {echo $culo;} ?></td>
                                              <td>Adjudicaci&oacute;n Directa Con Sondeo</td>
                                            </tr>
                                            <tr  class="filas_resultados">
                                              <td><? if($tipo_proceso_muestra == 11) {echo $culo;} ?></td>
                                              <td>Informativo</td>
                                              <td><? if($tipo_proceso_muestra == 9) {echo $culo;} ?></td>
                                              <td>Caso Excepcional</td>
                                            </tr>
                                            <tr  class="filas_resultados">
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td><? if($tipo_proceso_muestra == 10) {echo $culo;} ?></td>
                                              <td>Emergencia</td>
                                            </tr>
                                      </table></td>
                                    </tr>
                                    <tr  >
                                        <td align="right"><strong>Area Usuaria <img src="../imagenes/botones/help.gif" alt="Qui&eacute;n va a responder y quienes participaron en la aprobaci&oacute;n" title="Qui&eacute;n va a responder y quienes participaron en la aprobaci&oacute;n"  width="20" height="20" /></strong></td>
                                        <td colspan="5" align="left">
                                            <table width="98%" border="0" align="center"  class="tabla_lista_resultados">
                                                <tr class="fondo_3">
                                                    <td width="34%" align="center">Usuario</td>
                                                    <td width="34%" align="center">Area</td>
                                                    <td width="34%" align="center">Observaci&oacute;n</td>
                                                </tr>
                                                <?php
                                                $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = " . $sel_item[0] . " and tipo_adj_permiso = $permiso_o_adjudica and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
                                                $cont = 0;
                                                while ($sel_p_real = traer_fila_db($sel_propuestos_real)) {

                                                    $select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = " . $sel_p_real[0] . " and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = " . $sel_item[0]));
                                                    $select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = " . $sel_item[0] . " and id_rol = " . $sel_p_real[0] . " and tipo_adj_permiso = $permiso_o_adjudica"));

                                                    $edita_permiso = "SI";
                                                    if ($select_si_tiene_acciones[0] > 0 or $sel_p_real[0] == 8 or $sel_p_real[0] == 10) {
                                                        $edita_permiso = "NO";
                                                        $secuencia_profesional_permiso = $select_secuencia[0];
                                                    }

                                                    $sel_real_us_aprueba = traer_fila_row(query_db("select * from $vpeec15 where id_item_pecc = " . $sel_item[0] . " and id_rol = " . $sel_p_real[0] . " and tipo_adj_permiso = $permiso_o_adjudica and estado = 1 and us_id = " . $_SESSION["id_us_session"] . " and id_rol not in (8,15) order by nombre_administrador"));

                                                    $sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = " . $sel_p_real[0] . " and tipo_adj_permiso = $permiso_o_adjudica and id_item_pecc = " . $sel_item[0]));

                                                    $sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = " . $sel_id_apro_ultima[0]));

                                                    $es_aprobador_indicado_aprueba = "NO";
                                                    if ($sel_real_us_aprueba[0] > 0 and $sel_ultima_aprobacion[5] <> 1 and $sel_item[14] == 7) {
                                                        $es_aprobador_indicado_aprueba = "SI";
                                                    }


                                                    if ($cont == 0) {
                                                        $clase = "filas_resultados";
                                                        $cont = 1;
                                                    } else {
                                                        $clase = "";
                                                        $cont = 0;
                                                    }
                                                    ?>
                                                    <tr class="<?= $clase ?>">
                                                        <?php
                                                        if ($es_aprobador_indicado_muestra_colmuna == "SI") {
                                                            ?>
                                                            <?php
                                                        }
                                                        ?>
                                                        <td align="left"><?php
                                                            echo $sel_ultima_aprobacion[6];
                                                            ?></td>
                                                        <td align="center"><?php
													        if ($sel_p_real[0] == 8) {
                                                                echo "Abastecimiento";
                                                            } elseif($sel_p_real[0] == 15 or $sel_p_real[0] == 9 or $sel_p_real[0] == 20){//Si es un solicitante
																
																$sel_area_usuario = traer_fila_row(query_db("select count(*) from tseg3_usuario_areas where id_usuario= ".$sel_ultima_aprobacion[3]." and id_area = ".$sel_item[13]));//cuente para verificar si el area del usuario corresponde con el area de la solicitud
																if($sel_area_usuario[0]>0){
																echo saca_nombre_lista($g12,$sel_item[13],'nombre','t1_area_id');
																}else{
																	$sel_area_usuario = traer_fila_row(query_db("select t1_area.nombre from tseg3_usuario_areas, t1_area where id_usuario = " . $sel_ultima_aprobacion[3] . " and t1_area.t1_area_id = tseg3_usuario_areas.id_area and t1_area.estado = 1"));
																	
																	echo $sel_area_usuario[0];
																}
																
															}else {

                                                                $sel_area_usuario = traer_fila_row(query_db("select t1_area.nombre from tseg3_usuario_areas, t1_area where id_usuario = " . $sel_ultima_aprobacion[3] . " and t1_area.t1_area_id = tseg3_usuario_areas.id_area and t1_area.estado = 1"));

                                                                if ($sel_ultima_aprobacion[3] == 18030) {
                                                                    echo "Perforaci&oacute;n Completamiento y WO";
                                                                } else if ($sel_ultima_aprobacion[3] == 17966) {
                                                                    echo "Vicepresidencia Administraci&oacute;n y Finanzas";
                                                                } else if ($sel_ultima_aprobacion[3] == 17967) {
                                                                    echo "Gerencia Administrativa";
																} else if ($sel_ultima_aprobacion[3] == 9) {
                                                                    echo "Abastecimiento";
                                                                } else {
																	
																	$select_si_es_abastecimient = traer_fila_row(query_db("select count(*) from tseg3_usuario_areas where id_area = 44 and id_usuario = ".$sel_ultima_aprobacion[3]));
																	if($select_si_es_abastecimient[0]>0){
																		echo "Abastecimiento";
																		}else{
		                                                                    echo $sel_area_usuario[0];
																		}
                                                                }
                                                            }
                                                            ?></td>
                                                        <td align="center"><?php
                                                            echo $sel_ultima_aprobacion[11];
                                                            ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = " . $id_item_pecc . " and tipo_adj_permiso = $permiso_o_adjudica and id_rol = 10 group by id_rol, rol,orden order by orden"));
                                                if ($sel_p_real[0] > 0) {
                                                    $select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = " . $sel_p_real[0] . " and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = " . $id_item_pecc));
                                                    $select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = " . $id_item_pecc . " and id_rol = " . $sel_p_real[0] . " and tipo_adj_permiso = $permiso_o_adjudica"));

                                                    $edita_permiso = "NO";
                                                    if ($select_si_tiene_acciones[0] > 0) {
                                                        $edita_permiso = "NO";
                                                        $secuencia_profesional_permiso = $select_secuencia[0];
                                                    }
                                                    ?>
                                                    <?php
                                                }
                                                $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = " . $id_item_pecc . " and tipo_adj_permiso = $permiso_o_adjudica and id_rol = 11 group by id_rol, rol,orden order by orden"));
                                                if ($sel_p_real[0] > 0) {
                                                    $select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = " . $sel_p_real[0] . " and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = " . $id_item_pecc));
                                                    $select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = " . $id_item_pecc . " and id_rol = " . $sel_p_real[0] . " and tipo_adj_permiso = $permiso_o_adjudica"));

                                                    $es_aprobador_indicado_aprueba = "NO";
                                                    if (verifica_usuario_indicado(11, $id_item_pecc) == "SI" and $sel_item[14] == 9) {
                                                        $es_aprobador_indicado_aprueba = "SI";
                                                    }
                                                    ?>
                                                    <?php
                                                }
                                                ?>
                                            </table>

                                        </td>
                                    </tr>
                                    <?
                                    if($sel_item[3] == 2 or $sel_item[3] == "no aplica"){
									?>
                                    <tr class="columna_subtitulo_resultados_letra_normal" >
                                        <td align="right"><strong>N&uacute;mero de sondeo relacionado </strong></td>
                                        <td colspan="5" align="left">&nbsp;</td>
                                    </tr>
                                    
                                    <?
									}
                                    if($justificacion_comercial!= "" and $justificacion_comercial!= " " and $justificacion_comercial!= "   "){
                                    ?>
                                    
                                    <tr >
                                        <td align="right"><strong>Justificaci&oacute;n Comercial <img src="../imagenes/botones/help.gif" alt="Estrategia: La justificaci&oacute;n del tipo de proceso e invitados a participar. Adjudicaci&oacute;n: mejor costo beneficio de la actividad a contratar" title="Estrategia: La justificaci&oacute;n del tipo de proceso e invitados a participar. Adjudicaci&oacute;n: mejor costo beneficio de la actividad a contratar"  width="20" height="20" /></strong></td>
                                        <td colspan="5" align="left"><? echo nl2br($justificacion_comercial) ?></td>
                                    </tr>
                                    <?
					}
									?>
                                    
                                    <tr class="columna_subtitulo_resultados_letra_normal" >
                                        <td align="right"><strong>Justificaci&oacute;n T&eacute;cnica <img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
" title="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
"  width="20" height="20" /></strong></td>
                                        <td colspan="5" align="left"><? echo nl2br($justificacion_tecinica) ?></td>
                                    </tr>
                                    
                                    <tr >
                                        <td align="right"><strong>Criterios de Evaluacion <img src="../imagenes/botones/help.gif" alt="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico" title="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico"  width="20" height="20" /></strong></td>
                                        <td colspan="5" align="left"><?= nl2br($sel_item[21]) ?></td>
                                    </tr>
                                    <tr class="columna_subtitulo_resultados_letra_normal" >
                                        <td align="right"><strong>Recomendaci&oacute;n <img src="../imagenes/botones/help.gif" alt="Acci&oacute;n, valor, contratista/proveedor y vigencia
                                                                                            " title="Acci&oacute;n, valor, contratista/proveedor y vigencia
                                                                                            "  width="20" height="20" /></strong></td>
                                        <td colspan="5" align="left"><?  echo nl2br($recomendacion)?></td>
                                    </tr>
                                    <tr >
                                        <td align="right"><strong>Objeto del Contrato:</strong></td>
                                        <td colspan="5" align="left"><?php
                                            if ($sel_item[8] == "")
                                                echo nl2br($sel_item[12]);
                                            else
                                                echo nl2br($sel_item[8]);
                                                ?></td>
                                    </tr>
                                    <tr class="" >
                                      <td colspan="6" align="center" class="columna_subtitulo_resultados_letra_normal">
                                      
                                      <?
									  
									  $permiso_o_adjudica_obt = $permiso_o_adjudica;
									   $ver_objetivos ="NO";
									  if($sel_item[3]==1 or $sel_item[3]==2 or $sel_item[3]==3 or $sel_item[3]==5 or $sel_item[3]==13 or $sel_item[3]==14 or $sel_item[3]==15 or $sel_item[3]==6 or $sel_item[3]==7){
										  $ver_objetivos ="SI";
										  }
										  
										  
                                      if($ver_objetivos == "SI"){
										  
										  if($permiso_o_adjudica_obt==2 and ($sel_item[3]==4 or $sel_item[3]==5 or $sel_item[3]==13 or $sel_item[3]==14 or $sel_item[3]==7 or $sel_item[3]==8 or $sel_item[3]==9 or $sel_item[3]==10 or $sel_item[3]==11 or $sel_item[3]==12 or $sel_item[3]==15)){
									$permiso_o_adjudica_obt=1;
								}
							if($permiso_o_adjudica_obt==1){	
								$campos_consulta="CAST(p_oportunidad as TEXT), CAST(p_costo AS TEXT), CAST(p_calidad AS TEXT), CAST(p_optimizar AS TEXT), CAST(p_trazabilidad AS TEXT), CAST(p_transparencia AS TEXT), CAST(p_sostenibilidad AS TEXT)";
								}
							if($permiso_o_adjudica_obt==2){			
								$campos_consulta="CAST(a_oportunidad AS TEXT), CAST(a_costo AS TEXT), CAST(a_calidad AS TEXT), CAST(a_optimizar AS TEXT), CAST(a_trazabilidad AS TEXT), CAST(a_transparencia AS TEXT), CAST(a_sostenibilidad AS TEXT)";
								}
								
			$busvca_tex = traer_fila_row(query_db("select $campos_consulta from t2_objetivos_proceso where id_item = ".$sel_item[0]));
			$p_oportunidad=$busvca_tex[0];
			$p_costo=$busvca_tex[1];
			$p_calidad=$busvca_tex[2];
			$p_optimizar=$busvca_tex[3];
			$p_trazabilidad=$busvca_tex[4];
			$p_transparencia=$busvca_tex[5];
			$p_sostenibilidad=$busvca_tex[6];
			
			
			
			
			/*Configuracion de titulos*/
			 $titulo_principal = "Objetivos del Proceso";
		  $titulo1="Oportunidad";
		  $ayuda1="Para cuando se requiere el servicio y que estamos proponiendo para cumplir con la fecha de entrega, y la estrategia que estamos proponiendo nos sirve para cumplir con el objetivo";
		  $titulo2="Costo-Beneficio";
		  $ayuda2="Cual es el criterio que me genera el mejor costo beneficio Ejemplo Tiempo, Evaluaci&oacute;n T&eacute;cnica, otros, Precio.";
		  
		  $titulo3="Calidad";
		  $ayuda3="Que significa calidad para el proceso en espec&iacute;fico?  combinaci&oacute;n de tiempo? Entregable?";
		  
		  $titulo4="Optimizar Transferencia Riesgos";
		  $ayuda4="Identificar los riesgos y escribir como se aseguran o cuales se transfieren y por que medio.  Si no se transfieren explicar el porque";
		  
		  $titulo5="Trazabilidad";// no tiene cambio
		  $ayuda5="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones.";
		  
		  $titulo6="Transparencia";// no tiene cambio
		  $ayuda6="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)";
		  
		  $titulo7="Sostenibilidad";
		  $ayuda7="Como nos estamos asegurando que los compromisos con las comunidades se van a tener encuentra en el proceso";
		  
		  
		  if($sel_item[0] > $id_item_empieza_nuevos_objetivos_proceso){
		  $titulo_principal = "Lineamientos Operador de Bajo Costo + R+S";
		  $titulo1="Bajo Costo";
		  $ayuda1="Est&aacute;ndares acordes a las necesidades del negocio que aseguren rentabilidad y excelencia operacional. Actividades justo lo necesario -fitforpurpose. Proceso de abastecimiento que obtiene el mayor valor posible del mercado.";
		  $titulo2="NO aplica";
		  $ayuda2="NO aplica";
		  
		  $titulo3="Capacidad T&eacute;cnica";
		  $ayuda3="Competencias integrales y aplicaci&oacute;n de tecnolog&iacute;as conectadas con el negocio y fortalecidas a trav&eacute;s de alianzas estrat&eacute;gicas. Informaci&oacute;n como recurso";
		  
		  $titulo4="Gesti&oacute;n de Entorno";
		  $ayuda4="Foco en el desarrollo regional sostenible, alineando intereses de largo plazo. Vinculaci&oacute;n del entorno en los resultados. Operaci&oacute;n sana, limpia, segura y transparente.";
		  
		  $titulo5="Trazabilidad";// no tiene cambio
		  $ayuda5="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones.";
		  
		  $titulo6="Transparencia";// no tiene cambio
		  $ayuda6="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)";
		  
		  $titulo7="Agilidad";
		  $ayuda7="Procesos simplificados y estandarizados. Personal integral y m&oacute;vil, seg&uacute;n los requerimientos del negocio. Oportunidad en adquisici&oacute;n de B&S.";
		  }
			/*fin Configuracion de titulos*/
									  ?>
                                      
                                      <table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF"   class="tabla_lista_resultados">
                                        <tr class="fondo_3">
                                          <td align="center" ><?=$titulo_principal?></td>
                                          <td align="center" >Descripci&oacute;n</td>
                                        </tr>
                                        <?

	  ?>
                                        <tr>
                                          <td width="31%" align="right"><?=$titulo1?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda1?>" width="20" height="20" title="<?=$ayuda1?>" /></td>
                                          <td width="69%" align="left"><? echo nl2br($p_oportunidad); ?></td>
                                        </tr>
                                        <? if($titulo2 != "NO aplica"){?>
                                        <tr>
                                          <td align="right"><?=$titulo2?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda2?>" width="20" height="20" title="<?=$ayuda2?>" /></td>
                                          <td align="left"><? echo nl2br($p_costo); ?></td>
                                        </tr>
                                        <?
										}
										?>
                                        <tr>
                                          <td align="right"><?=$titulo3?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda3?>" width="20" height="20" title="<?=$ayuda3?>" /></td>
                                          <td align="left"><? echo nl2br($p_calidad); ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right"><?=$titulo4?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda4?>" width="20" height="20" title="<?=$ayuda4?>" /></td>
                                          <td align="left"><? echo nl2br($p_optimizar); ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right"><?=$titulo5?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda5?>" width="20" height="20" title="<?=$ayuda5?>" /></td>
                                          <td align="left"><? echo nl2br($p_trazabilidad); ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right"><?=$titulo6?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda6?>" width="20" height="20" title="<?=$ayuda6?>" /></td>
                                          <td align="left"><? echo nl2br($p_transparencia); ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right"><?=$titulo7?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda7?>" width="20" height="20" title="<?=$ayuda7?>" /></td>
                                          <td align="left"><? echo nl2br($p_sostenibilidad); ?></td>
                                        </tr>
                                      </table>
                                      <?
									  }
									  ?>
                                      </td>
                                    </tr>
                                    <tr class="" >
                                        <td align="right"><strong>Comentario del Secretario del Comit&eacute;:</strong></td>
                                        <td colspan="4" align="left"><?php
                                            if ($tiene_permiso_secretrio == "SI") {
                                                ?>
                                                <textarea name="comenta_secretario_<?= $sel_sin_comi[0] ?>" cols="30" id="comenta_secretario_<?= $sel_sin_comi[0] ?>"><?= $sel_sin_comi[11] ?></textarea>
                                                <?php
                                            } else {
                                                echo nl2br($sel_sin_comi[11]);
                                            }
                                            ?></td>
                                        <td width="145" align="left"><?php
                                            if ($tiene_permiso_secretrio == "SI") {
                                                ?>
                                                <input name="sda2" type="button" value="Grabar Comentario" class="boton_grabar" onClick="graba_comentario_comite(<?=$sel_sin_comi[0]?>)" />
                                                <?php
                                            }
                                            ?></td>
                                    </tr>
                                    <?php
                                    if ($tiene_permiso_secretrio == "SI" and $sel_item[3] <> 8) {
                                        ?>
                                        <?php
                                        $style_celda = "border-bottom:#000 2px solid; border-right:#000 2px solid; border-top:#000 2px solid; border-left:#000 2px solid; ";
                                    }
                                    ?>
                                 
                                    <?php
                                            if ($tiene_permiso_secretrio == "SI") {
                                                ?>
                                  
                                        <tr>
                                          <td colspan="6" align="right"><table width="80%" border="0" align="center" class="tabla_lista_resultados">
                                            <tr>
                                              <td align="right"><?

                               $sel_si_puede = traer_fila_row(query_db("select count(*) from t3_convinaciones_cambio_proceso where id_proceso_origen=".$sel_item[3]." and estado_origen = ".$sel_item[2]));
										if($sel_si_puede[0]>0 and $sel_si_tien_cambios[0]==0){
										?>Cambiar el tipo de proceso a: <? }?></td>
                                              <td><?

                               //$sel_si_puede = traer_fila_row(query_db("select count(*) from t3_convinaciones_cambio_proceso where id_proceso_origen=".$sel_item[3]." and estado_origen = ".$sel_item[2]));
										if($sel_si_puede[0]>0 and $sel_si_tien_cambios[0]==0){
										?>
                                                <select name="cambio_tp_proceso_<?=$sel_sin_comi[0]?>" id="cambio_tp_proceso_<?=$sel_sin_comi[0]?>">
                                                  <option value="0">Seleccione si desea cambiar el tipo de proceso</option>
                                                  <? $sel_si_puede_wi = query_db("select * from t3_convinaciones_cambio_proceso where id_proceso_origen=".$sel_item[3]." and estado_origen = ".$sel_item[2]);
										while($sel_tpos_cambio = traer_fila_db($sel_si_puede_wi)){
										?>
                                                  <option value="<?=$sel_tpos_cambio[0]?>"><? echo saca_nombre_lista($g13,$sel_tpos_cambio[3],'nombre','t1_tipo_proceso_id',$sel_item[0]);	if($sel_tpos_cambio[4]==8) echo " Permiso"; if($sel_tpos_cambio[4]==17) echo " Adjudicacion";?></option>
                                                  <?
										}
										  ?>
                                                </select>
                                              <?
										}
										?></td>
                                              <td align="left"><? if($sel_si_puede[0]>0 and $sel_si_tien_cambios[0]==0){ ?><input type="button" name="" value="Cambiar Tipo de Proceso" onClick="graba_cambio_tp_proceso(<?=$sel_sin_comi[0]?>)"  class="boton_grabar"/><? } ?></td>
                                            </tr>
                                            <tr>
                                              <td colspan="3" align="left"><?php

                                            if ($tiene_permiso_secretrio == "SI" and $sel_item[3] <> 8 ) {
                                                if (($sel_item[2] == 8 and ($sel_item[3] ==1 or $sel_item[3] ==2)) or ( $sel_item[3] ==5 or $sel_item[3] ==7 or $sel_item[3] ==9 or $sel_item[3] ==10 or $sel_item[3] ==11 or $sel_item[3] ==12 or $sel_item[3] ==16)) {//si va para asignacion presupuestal
                                                    // Guardar según Invitacion a proponer, negociacion directa, proveedor exclusivo.
                                                    ?>
                                                <input type="button" value="Editar Valores" class="boton_grabar" onClick='window.parent.document.getElementById("carga_edicion_valores_<?=$sel_item[0] ?>").style.display=""; ajax_carga("../aplicaciones/pecc/asignacion-presupuestal.php?id_item_pecc=<?= $sel_item[0] ?>&id_comite=<?=$id_comite ?>&desde_comite=SI", "carga_edicion_valores_<?=$sel_item[0] ?>");'/>
                                                <?php
                                                       }
												if (($sel_item[2] == 17 and ($sel_item[3] ==1 or $sel_item[3] ==2 or $sel_item[3] ==6)) ) {//si va para adjudicacion.
         $sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$sel_item[0].""));
			if($sele_tipo_doc[0]>0){
				$link_adjudicacion = "adjudicacion-marco";
				}else{

					$sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$sel_item[0]."'"));

					if($sele_tipo_doc_desierto[13]==4){
						$link_adjudicacion = "adjudicacion-desierto";
						}else{			
						$link_adjudicacion = "adjudicacion";
						}
				}
												   
												    ?>
                                                <input type="button" value="Editar Valores / Proveedores de Adjudicaci&oacute;n" class="boton_grabar" onClick='window.parent.document.getElementById("carga_edicion_valores_<?=$sel_item[0] ?>").style.display=""; ajax_carga("../aplicaciones/pecc/<?=$link_adjudicacion?>.php?id_item_pecc=<?=$sel_item[0]?>&id_comite=<?=$id_comite?>&desde_comite=SI", "carga_edicion_valores_<?=$sel_item[0] ?>");'/>
                                              <?php
                                                       } 
													   
													   
                                                   }
												   $titulo=""; $link="";
												   if($sel_si_tien_cambios[0]>0){
													   if($sel_si_tien_cambios[7]== 1){$titulo=""; $link="";}
														if($sel_si_tien_cambios[7]== 2){$titulo="Relacionar el numero de contrato"; $link="relacion_contrato_antecedentes-comite";}
														if($sel_si_tien_cambios[7]== 3){$titulo="Relacionar el numero de contrato y antecedentes"; $link="relacion_contrato_antecedentes-comite";}
														if($sel_si_tien_cambios[7]== 4){$titulo="Relacione los proveedores"; $link="";}
														
														if($titulo!=""){
														?><input type="button" value="<?=$titulo?>" class="boton_grabar" onClick='window.parent.document.getElementById("carga_edicion_valores_<?=$sel_item[0] ?>").style.display=""; ajax_carga("../aplicaciones/pecc/<?=$link?>.php?id_item_pecc=<?=$sel_item[0]?>&id_comite=<?=$id_comite?>&desde_comite=SI", "carga_edicion_valores_<?=$sel_item[0] ?>");'/><?
														}
													   }
                                                   ?></td>
                                            </tr>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                          </table></td>
                                        </tr>
                                        <?
                                        }
										?>
                                        <tr>
                                          <td colspan="6"><div id="carga_edicion_valores_<?=$sel_item[0] ?>" style="display:none" class="fondo_rojo">1111</div></td>
                                        </tr>
                                        
                                         
                                        <tr>
                                            <td >&nbsp;</td>
                                          <td colspan="5" ><?
                                     
									  if($sel_si_tien_cambios[0]>0){
										  $estado_origen = "";
										  $estado_resultado="";
										  
										  if($sel_si_tien_cambios[5]==8){
										  	$estado_origen = "Permiso";
										  }
										  if($sel_si_tien_cambios[5]==17){
										  	$estado_origen = "Adjudicacion";
										  }
										  
										  if($sel_si_tien_cambios[6]==8){
										  	$estado_resultado = "Permiso";
										  }
										  if($sel_si_tien_cambios[6]==17){
										  	$estado_resultado = "Adjudicacion";
										  }
										  
										
										  echo "<strong>Esta solicitud cambio de tipo de proceso en este comite: Paso de: ".$sel_si_tien_cambios[2]." - ".$estado_origen.", a ".$sel_si_tien_cambios[3]." - ".$estado_resultado."</strong>";
										  }
									  ?></td>
                              </tr>
                               <?php 
                                    
                                    

                                    if ($val_usd >= MONTO_COMITE and $id_comite < 115) { ?>
                                        <tr>
                                            <td width="231" align="right"><strong>Verificacion del Presidente <img src="../imagenes/botones/help.gif" alt="El presidente debe verificar este proceso para ser finalizado" title="El presidente debe verificar este proceso para ser finalizado" width="20" height="20" /></strong></td>
                                            <td colspan="5" align="left">
                                               
                                              <table width="100%" border="0">
                                                      <tr>
                                                        <td width="24%">
														<div id="verificaion_presidente_<?=$sel_sin_comi[0]?>"> 
														<?php
                                                if ((($sele_comite[13] == 0 or $sele_comite[13] == "") and $sel_sin_comi['presidente'] != 1) and $_SESSION["id_us_session"] == $presidente and $sele_comite[4] == 1) {
                                                    ?>
                                                    <input name="fff" type="button" value="SI Verificar&nbsp;&nbsp;" class="boton_grabar" onClick="graba_verifica_comite_fer(<?= $sel_sin_comi[0]?>)" /><br><br>
<div id="no_verificado_<?=$sel_sin_comi[0]?>">
													<?
                                                    if($sel_sin_comi['presidente'] != 3){
													?>
                                                    <input name="fff" type="button" value="NO Verificar" class="boton_grabar_rojo" onClick="graba_no_verifica_comite(<?= $sel_sin_comi[0]?>, document.principal.comentario_verifica_presidente_<?=$sel_sin_comi[0]?>)" />
                                                    
                                                    <?
													}else{
														echo "Solicitud NO Verificada";
														}
														?>
</div>
														<?
													
                                                } else {
                                                    if ($sele_comite[13] == 1) {
                                                        echo "Verificado el " . $sele_comite[12];
                                                    }
                                                    if ($sele_comite[13] == 2) {
                                                        echo "No requiere";
                                                    }
                                                    if ($sele_comite[13] == 0 and $sel_sin_comi['presidente'] == 1) {
                                                        echo "Solicitud Verificada";
                                                    }
                                                }
                                                ?>
                                                </div>
                                                </td>
                                                        <td width="76%">
														<div id="comentario_presidente_<?=$sel_sin_comi[0]?>">
														<?
                                                         if ((($sele_comite[13] == 0 or $sele_comite[13] == "") and $sel_sin_comi['presidente'] != 1) and $_SESSION["id_us_session"] == $presidente and $sele_comite[4] == 1) {
															 ?>
                                                             Comentario del Presidente
															<textarea name="comentario_verifica_presidente_<?=$sel_sin_comi[0]?>" id="comentario_verifica_presidente_<?=$sel_sin_comi[0]?>"><?=$sel_sin_comi[22]?></textarea>
                                                            
															 <?
														 }else{
															 echo "Comentario del Presidente: ".$sel_sin_comi[22];
															 }
														?>
                                                        </div>
                                                        
                                                        </td>
                                                      </tr>
                                            </table>
                                            
                                            </td>
                                        </tr>
                                    <?php } 
										?>
										 
										
                                    

                                    <?php
                                    if ($tiene_permiso_secretrio == "SI") {
                                        ?>
                                        <tr class="" >
                                            <td colspan="6" align="center" valign="top"><table width="70%" border="0" align="left" class="tabla_lista_resultados">
                                                    <tr>
                                                        <td width="50%" align="right">Detalle del Anexo:</td>
                                                        <td width="50%"><input name="anexo_<?= $sel_item[0] ?>" type="text" id="anexo_<?= $sel_item[0] ?>" value="" size="25"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Seleccione el Anexo:</td>
                                                        <td><input name="adj_anexo_<?= $sel_item[0] ?>" type="file" id="adj_anexo_<?= $sel_item[0] ?>" size="5" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onClick="graba_anexo_edicion(19,<?=$sel_item[0]?>)" /></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr >
                                        <td colspan="6" align="right"><table width="100%" border="0" align="center">
                                                <tr>
                                                    <td width="59%" valign="top">
                                                    
                                                    <div id="info_firmas<?=$sel_sin_comi[0]?>">
                                                    <table width="100%" border="0" class="tabla_lista_resultados">
                                                            <tr class="fondo_3">
                                                                <td colspan="4" align="center">Aprobaciones del Comit&eacute;</td>
                                                            </tr>
                                                            <tr class="fondo_3">
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
                                                            <?php
                                                            $asistentes = query_db("SELECT dbo.t3_comite_asistentes.id_asistente, dbo.t3_comite_asistentes.id_us, dbo.t3_comite_asistentes.id_comite, 
               dbo.t1_us_usuarios.nombre_administrador, dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.rol_aprobacion, 
               dbo.t3_comite_asistentes.orden, dbo.t3_comite_asistentes.estado
FROM  dbo.t1_us_usuarios INNER JOIN
               dbo.t3_comite_asistentes ON dbo.t1_us_usuarios.us_id = dbo.t3_comite_asistentes.id_us
WHERE (dbo.t3_comite_asistentes.estado = 1) and dbo.t3_comite_asistentes.requiere_aprobacion in (1, 99) and dbo.t3_comite_asistentes.id_comite =" . $id_comite . "
ORDER BY dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.id_asistente");
                                                            $cont = 0;
                                                            while ($sel_aproba = traer_fila_db($asistentes)) {

                                                                $sel_ultima_aprobacion = traer_fila_row(query_db("select max(id_aprobacion) from $c4 where id_asistente =  " . $sel_aproba[0] . " and id_item =" . $sel_sin_comi[0]));
                                                                $sel_aprobacion = traer_fila_row(query_db("select id_aprobacion, id_comite, id_asistente, id_item, fecha, aprobacion, CAST(observacion AS TEXT) from $c4 where id_aprobacion =  " . $sel_ultima_aprobacion[0]));
                                                                if ($cont == 0) {
                                                                    $clase = "filas_resultados";
                                                                    $cont = 1;
                                                                } else {
                                                                    $clase = "";
                                                                    $cont = 0;
                                                                }

                                                                $sel_rol = traer_fila_row(query_db("select * from $c3 where id_asistente=" . $sel_aproba[0]));
                                                                ?>
                                                                <tr  class="<?= $clase ?>">
                                                                    <td align="center"><?= $sel_aproba[3] ?></td>
                                                                    <td align="center"><?= $sel_rol[3] ?></td>
                                                                    <td align="center">
																	
																	<? 
																	if($sel_rol[2]== 1){//si requiere aprobacion
																	
																		if ($sel_aprobacion[5] == 1) echo $nombre_firma_3; 
                                                                         if ($sel_aprobacion[5] == 4) echo $nombre_firma_3 . ' con Comentarios' ;
                                                                         if ($sel_aprobacion[5] == 2) echo $nombre_firma_4 ;
                                                                         if ($sel_aprobacion[5] == 10) echo "Rechazado" ;
																		
																	}else{//si no requiere aprobacion
																		echo "No Aplica";
																		}
																		
																		?>


                                                                    </td>
                                                                    <td align="center">
																	 <? if($sel_rol[2] == 99){//si es el secreatrio del comite
																		echo "Declaro que no tengo conflictos de intereses. ".nl2br($sel_sin_comi[11]);
																	}else{																	
																	 echo nl2br($sel_aprobacion[6]);
																	}
																	 
																	 ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>


                                                            <!--  Verificacion del presidente, si y solo si el proceso no tiene una suma mayor a USD 500.000-->






                                                        </table>
                                                        </div>
                                                        </td>
                                                    <td colspan="2" valign="top"><?
													
/*saca contrato si aplica para saber si esta vencido*/
	$alerta_contrato_vencido="";
	if($sel_item[3] == 4 or $sel_item[3] == 5){

		
		$sel_contrato = traer_fila_row(query_db("select vigencia_mes from t7_contratos_contrato where id=".$sel_item[15]));
		if($sel_contrato[0] < $fecha){
			$alerta_contrato_vencido = "ATENCION: El contrato relacionado se encuentra vencido.";
			}
	}
	if($sel_item[3] == 7 or $sel_item[3] == 8){
		 
		
		$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");		
		while($sel_presu = traer_fila_db($sele_presupuesto)){
		$sel_contr = query_db("select t2.vigencia_mes from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." order by t2.id asc");
			while($sel_apl = traer_fila_db($sel_contr)){
				if($sel_apl[0] < $fecha){
			$alerta_contrato_vencido = "ATENCION: El contrato relacionado se encuentra vencido.";
			}	
			}
		}
		}
/*FIN saca contrato si aplica para saber si esta vencido*/
	
													
                                                        if ($sele_comite[4] == 3) {//si ya tiene el estado
                                                            $sel_usuario = traer_fila_row(query_db("select * from $g1 where us_id =  " . $_SESSION["id_us_session"] . ""));

                                                            $sel_asiste_usuario = traer_fila_row(query_db("select id_asistente from $c3 where id_us =  " . $sel_usuario[0] . " and id_comite= " . $id_comite . " and requiere_aprobacion=1"));


                                       $sel_ultima_aprobacion = traer_fila_row(query_db("select max(id_aprobacion) from $c4 where id_asistente =  " . $sel_asiste_usuario[0] . " and id_item =" . $sel_sin_comi[0]));
                                                            if ($sel_asiste_usuario[0] > 0 and $sele_comite[4] == 3) {
                                                                $sel_aprobacion = traer_fila_row(query_db("select * from $c4 where id_aprobacion =  " . $sel_ultima_aprobacion[0]));
                                                                ?>



                                                      <table width="100%" border="0" class="tabla_lista_resultados">
                                                                    <tr>
                                                                        <td width="50%" align="right">Firma  de
                                                                            <?= $sel_usuario[1] ?>
                                                                            :</td>
                                                                        <td width="50%" align="left"><select name="accion_comite_usuario_<?= $sel_sin_comi[0] ?>" id="accion_comite_usuario_<?= $sel_sin_comi[0] ?>">
                                                                                <option value="1" <?php if ($sel_aprobacion[5] == 1) echo 'selected="selected"' ?> >
                                                                                    <?= $nombre_firma_1 ?>
                                                                                </option>
                                                                                <option value="4" <?php if ($sel_aprobacion[5] == 4) echo 'selected="selected"' ?> >
                                                                                    <?= $nombre_firma_1 ?>
                                                                                    con Comentarios</option>
                                                                                <option value="2" <?php if ($sel_aprobacion[5] == 2) echo 'selected="selected"' ?>>
                                                                                    <?= $nombre_firma_2 ?>
                                                                                </option>

                                                                                <option value="10" <?php if ($sel_aprobacion[5] == 10) echo 'selected="selected"' ?>>
                                                                                    Rechazar
                                                                                </option>


                                                                            </select></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="right">Observaci&oacute;n:</td>
                                                                        <td align="left">
                                                                        <textarea name="observacion_<?= $sel_sin_comi[0] ?>" id="observacion_<?= $sel_sin_comi[0] ?>" rows="5"><?= $sel_aprobacion[6] ?></textarea></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" align="center"><input name="sda" type="button" value="Confirmar Acci&oacute;n" class="boton_grabar" onClick="crea_accion_comite_usuario(<?= $sel_item[0] ?>,<?= $sel_asiste_usuario[0] ?>, '<?=$alerta_contrato_vencido?>', document.principal.accion_comite_usuario_<?=$sel_sin_comi[0]?>.value)" /></td>
                                                                    </tr>
                                                                </table>
                                                                <?php
                                                            }
                                                        }//FIN si ya tiene el estado
                                                        if ($activa_revision_sap == "SI" and $sel_item[2] > 19) {
                                                            ?>
                                                            <table width="100%" border="0" class="tabla_lista_resultados">
                                                                <tr class="fondo_3">
                                                                    <td colspan="2" align="center" class="fondo_3">Grabar Revisiones SAP</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="151" align="right">Estado:</td>
                                                                    <td width="465">									<? $sel_si_tiene_revision_sap = traer_fila_row(query_db("select  id, id_item, accion_sap, CAST(ob AS text) from t2_revision_sap where id_item = ". $sel_item[0])); ?>
                                                                        <select name="resicion_SAP<?= $sel_item[0] ?>" id="resicion_SAP<?= $sel_item[0] ?>">
                                                                            <option value="NO Revisado" <?php if ($sel_si_tiene_revision_sap[2] == "NO Revisado") echo 'selected="selected"' ?>>NO Revisado en SAP</option>
                                                                            <option value="Revisado" <?php if ($sel_si_tiene_revision_sap[2] == "Revisado") echo 'selected="selected"' ?> >Revisado en SAP</option>
                                                                            <option value="No Aplica" <?php if ($sel_si_tiene_revision_sap[2] == "No Aplica") echo 'selected="selected"' ?>>NO Aplica Revisi&oacute;n en SAP</option>
                                                                    </select></td>
                                                                </tr>
                                                                <tr>
                                                                  <td align="right">Observaci&oacute;n:</td>
                                                                  <td><textarea name="ob_sap<?=$sel_item[0]?>" id="ob_sap<?=$sel_item[0]?>"><?=$sel_si_tiene_revision_sap[3]?></textarea></td>
                                                                </tr>
                                                                <tr>
                                                                  <td colspan="2" align="right"><input type="button" name="asd2323" value="Grabar la Revisi&oacute;n SAP" onClick="graba_revision_sap(<?= $sel_item[0] ?>)" /></td>
                                                                </tr>
                                                            </table>
                                                            <?php
                                                        }//fin si revision SAP
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td width="21%" align="center" valign="top">
                                                    <? if($_GET["id_item_consulta_firma"] ==0){ ?>
                                                    <strong onClick="ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite=<?= $id_comite ?>', 'contenidos')" style="cursor:pointer"><font color="#FF0000">Actualizar Comit&eacute; </font><img src="../imagenes/botones/2.gif" alt=""  /></strong><? }?></td>
                                                    <td width="20%" align="center" valign="top">
                                                    <?
                                                    if($mostrar_volver == "SI"){
														?><img src="../imagenes/botones/volver_inicio.png" onClick="fnGo()" style="cursor:pointer" /><?
														}
													?>
                                                    </td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr><!-- FIN TABLA SOLICITUD  -->
                        <?php
                        }// FIN SI YA SE VALIDÓ LOS CONFLICTOS DE INTERÉS MUESTRA EL PROCESO, SI NO LO OCULTA HASTA QUE EL SECRETARIO DEL COMITÉ LO VALIDE
                    }
                    ?>
                </table></td>
        </tr>
        <tr>
            <td valign="top" id="carga_acciones_permitidas">

                <table width="100%" border="0">
                    <tr>

                    </tr>
                </table></td>
        </tr>
    </table>
    
    <?
if($_GET["id_item_consulta_firma"] > 0){
	?>
	</td></tr></table>
<?
		}	
?>
    <input type="hidden" name="id_comite" id="id_comite" value="<?= $id_comite ?>" />
    <input type="hidden" name="id_comite_agrega" id="id_comite_agrega"/>
    <input type="hidden" name="id_presupuesto" id="id_presupuesto"/>
    <!-- Campos para guardar nuevos valores de varios proveedores por separado-->
    <input type="hidden" name="valor_usd_dif" id="valor_usd_dif"/>
    <input type="hidden" name="valor_cop_dif" id="valor_cop_dif"/>
    <!-- Fin-->
    <input type="hidden" name="id_item_agrega" id="id_item_agrega" />
    <input type="hidden" name="asistente_comote" id="asistente_comote" />
    <input type="hidden" id="id_item_graba_revision" name="id_item_graba_revision" />
    <input type="hidden" name="tipo_anexo" id="tipo_anexo" />
    <input type="hidden" name="id_item_pecc" id="id_item_pecc" />
    

</body>
</html>
