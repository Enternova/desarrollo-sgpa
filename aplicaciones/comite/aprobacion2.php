<? include("../../librerias/lib/@session.php");
$id_comite = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));

$sele_comite = traer_fila_row(query_db("select * from $c1 where id_comite = " . $id_comite . ""));

$edicion_datos_generales = "NO";
$tiene_permiso_secretrio = "NO";
$verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 10 and us_id =" . $_SESSION["id_us_session"]));
if ($verifica_permiso[0] > 0 and $sele_comite[4] == 3) {
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

    <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
            <td valign="top" ><a name="inicio_comite_href"></a><?= encabezado_comite($id_comite) ?>

            </td>
        </tr>
        <tr>
            <td valign="top">
            
            
            <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                    <?php
                    $conse_div = 0;
					
					if($sele_comite[4]==1){
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
							
		if($_SESSION["id_us_session"]==32){
			//exit;
			}
$semaforo=0;
                    $sel_item_sin_comite = query_db("SELECT id_item, id_comite, estado, num1, num2, num3, fecha_se_requiere, eq_usd, orden, id_relacion, permiso_o_adjudica, comentario_secretrario, nuevo_valor_solicitud, area, nombre_administrador, nuevo_valor_solicitud_cop, objeto_solicitud, ob_solicitud_adjudica, t1_area_id, id_us, presidente, aplica_presidente, CAST(comentario_presidente AS TEXT) from v_comite_item_agregado where id_comite = " . $id_comite . " and estado <> 3 ".$sql_comple_order);
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
                        <?php
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
                                . "alcance_adjudica,"
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
                                . "CAST( criterios_evaluacion AS TEXT) from $pi2 where id_item=" . $sel_sin_comi[0]));


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

                        if ($sel_item[3] == 11 or $sel_item[3] == 12) {
                            $sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));
                        } else {
                            $sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = $permiso_o_adjudica"));
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
                            if ($sel_item[11] == "")
                                $recomendacion = $sel_item[6];
                            else
                                $recomendacion = $sel_item[11];
                        }
						
						
						
						if($sel_presupuesto[1] > 0) {
                                        $val_usd = ($sel_presupuesto[1] / trm_presupuestal($sel_sin_comi[4]) + $sel_presupuesto[0]);
                                    }else{
                                        $val_usd = ($sel_presupuesto[0]);
                                    }
									
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
						?>
                        <tr >
                            <td colspan="2" align="center"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_aproba_comite">
                                    <tr >
                                        <td colspan="5" align="center" class="fondo_3"><strong>Datos de la Solicitud <font size="+2">
                                                <?= numero_item_pecc($sel_sin_comi[3], $sel_sin_comi[4], $sel_sin_comi[5]) ?>
                                                </font> </strong><strong class="titulo_calendario_real_bien" onClick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?= $sel_item[0] ?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?= $conse_div ?>&permiso_o_adjudica=<?=$permiso_o_adjudica ?>')" > <img src="../imagenes/botones/detalle.png" height="30" /></strong></td>
                                    </tr>

                                    <tr >
                                        <td width="413" align="right"><strong>Objeto de la Solicitud <img src="../imagenes/botones/help.gif" alt="Qu&eacute; se va a contratar" title="Qu&eacute; se va a contratar" width="20" height="20" /></strong></td>
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
                                        <td width="171"   align="right">USD$:</td>
                                        <td width="349" align="left"><?= number_format($sel_presupuesto[0], 0) ?></td>
                                        <td colspan="2" rowspan="6" align="right" valign="top">&nbsp;</td>
                                    </tr>
                                    <tr >
                                        <td align="right">&nbsp;</td>
                                        <?php
                                        $q_us = $sel_presupuesto[1] / $sel_trm[0] + $sel_presupuesto[0];
                                        ?>
                                        <td width="171" 	align="right">COP$:</td>
                                        <td align="left"><?= number_format($sel_presupuesto[1], 0) ?></td>
                                    </tr>

                                    <tr>
                                        <td align="right">&nbsp;</td>
                                        <td width="171" align="right">Equivalente en dolares$:
                                        <td align="left">
                                            
                                            <?=
                                            (($sel_presupuesto[1] > 0) ?
                                                    number_format($sel_presupuesto[1] / trm_presupuestal($sel_sin_comi[4]) + $sel_presupuesto[0], 0) :
                                                    number_format($sel_presupuesto[0], 0))
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                      <td align="right">&nbsp;</td>
                                      <td align="right">                                    
                                      <td align="left">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td align="right">&nbsp;</td>
                                      <td align="right">                                    
                                      <td align="left">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td align="right">&nbsp;</td>
                                      <td align="right">                                    
                                      <td align="left">&nbsp;</td>
                                    </tr>
                                    <tr class="columna_subtitulo_resultados_letra_normal" >
                                        <td align="right"><strong>Tipo de Proceso <img src="../imagenes/botones/help.gif" alt="Como vamos a adquirir los B&amp;S. (Negociaci&oacute;n directa, Invitaci&oacute;n a Proponer, Otros&iacute;, Emergencia Operacional, Caso Excepcional, Informativo y/o reclasificaci&oacute;n).  Estaba incluido en el PECC"  title="Como vamos a adquirir los B&amp;S. (Negociaci&oacute;n directa, Invitaci&oacute;n a Proponer, Otros&iacute;, Emergencia Operacional, Caso Excepcional, Informativo y/o reclasificaci&oacute;n).  Estaba incluido en el PECC" width="20" height="20" /></strong></td>
                                        <td colspan="4" align="left"><?php
                                            

                                            //echo saca_nombre_lista($g13, $sel_item[3], 'nombre', 't1_tipo_proceso_id');
                                            ?>
                                          <table width="52%" border="0" class="tabla_lista_resultados">
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
										  ?>
                                              <td width="5%"><? if($sel_item[3] == 1 or $sel_item[3] == 17) {echo $culo;} ?></td>
                                              <td width="45%">Licitaci&oacute;n</td>
                                              <td width="5%"><? if($permiso_o_adjudica == 2 and ($sel_item[3] == 1 or $sel_item[3] == 17)) {echo $culo;}?></td>
                                              <td width="45%">Licitaci&oacute;n</td>
                                            </tr>
                                            <tr class="filas_resultados_blanco">
                                              <td><? if($sel_item[3] == 2 or $sel_item[3] == 3) {echo $culo;} ?></td>
                                              <td>Negociaci&oacute;n Directa</td>
                                              <td><? if($permiso_o_adjudica == 2 and ($sel_item[3] == 2 or $sel_item[3] == 3)) {echo $culo;}?></td>
                                              <td>Negociaci&oacute;n Directa</td>
                                            </tr>
                                            <tr  class="filas_resultados">
                                              <td><? if($sel_item[3] == 15) {echo $culo;} ?></td>
                                              <td>Modificaci&oacute;n</td>
                                              <td><? if($sel_item[3] == 5 or $sel_item[3] == 4 or $sel_item[3] == 13 or $sel_item[3] == 14 or $sel_item[3] == 13 or $sel_item[3] == 7) {echo $culo;} ?></td>
                                              <td>Otro S&iacute; <? if($sel_item[3] == 7) {echo " - Contrato Marco";} if($sel_item[3] == 5 or $sel_item[3] == 4 or $sel_item[3] == 13 or $sel_item[3] == 14 or $sel_item[3] == 13) { echo " - Contrato Normal";}?></td>
                                            </tr>
                                            <tr class="filas_resultados_blanco">
                                              <td><? if($sel_item[3] == 12) {echo $culo;} ?></td>
                                              <td>Reclasificaci&oacute;n</td>
                                              <td><? if($sel_item[3] == 6 or $sel_item[3] == 18) {echo $culo;} ?></td>
                                              <td>Adjudicaci&oacute;n Directa Con Sondeo</td>
                                            </tr>
                                            <tr  class="filas_resultados">
                                              <td><? if($sel_item[3] == 11) {echo $culo;} ?></td>
                                              <td>Informativo</td>
                                              <td><? if($sel_item[3] == 9) {echo $culo;} ?></td>
                                              <td>Caso Excepcional</td>
                                            </tr>
                                            <tr  class="filas_resultados">
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td><? if($sel_item[3] == 10) {echo $culo;} ?></td>
                                              <td>Emergencia</td>
                                            </tr>
                                        </table></td>
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
                                                            } else {

                                                                $sel_area_usuario = traer_fila_row(query_db("select t1_area.nombre from tseg3_usuario_areas, t1_area where id_usuario = " . $sel_ultima_aprobacion[3] . " and t1_area.t1_area_id = tseg3_usuario_areas.id_area"));

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
                                    if($justificacion_comercial!= "" and $justificacion_comercial!= " " and $justificacion_comercial!= "   "){
                                    ?>
                                    <tr >
                                        <td align="right"><strong>Justificaci&oacute;n Comercial <img src="../imagenes/botones/help.gif" alt="Estrategia: La justificaci&oacute;n del tipo de proceso e invitados a participar. Adjudicaci&oacute;n: mejor costo beneficio de la actividad a contratar" title="Estrategia: La justificaci&oacute;n del tipo de proceso e invitados a participar. Adjudicaci&oacute;n: mejor costo beneficio de la actividad a contratar"  width="20" height="20" /></strong></td>
                                        <td colspan="4" align="left"><? echo $justificacion_comercial ?></td>
                                    </tr>
                                    <?
					}
									?>
                                    
                                    <tr >
                                        <td align="right"><strong>Justificaci&oacute;n T&eacute;cnica <img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
" title="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
"  width="20" height="20" /></strong></td>
                                        <td colspan="4" align="left"><? echo $justificacion_tecinica ?></td>
                                    </tr>
                                    
                                    <tr class="columna_subtitulo_resultados_letra_normal" >
                                        <td align="right"><strong>Criterios de Evaluacion <img src="../imagenes/botones/help.gif" alt="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico" title="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico"  width="20" height="20" /></strong></td>
                                        <td colspan="4" align="left"><?= $sel_item[21] ?></td>
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
                                        <td colspan="4" align="left"><?php
                                            if ($sel_item[18] > 0) {

                                                $sel_umero_relacionada = traer_fila_row(query_db("select num1, num2, num3 from t2_item_pecc where id_item = " . $sel_item[18]));
                                                echo "<strong>" . numero_item_pecc($sel_umero_relacionada[0], $sel_umero_relacionada[1], $sel_umero_relacionada[2]) . "</strong> ";

                                                echo contratos_relacionados_comite_solo_contratos($sel_item[18], $permiso_o_adjudica);
                                            } else {
                                                echo contratos_relacionados_comite_solo_contratos($sel_item[0], $permiso_o_adjudica);
                                            }//si es una solicitud con otra relacionada eje. informativo
                                            ?></td>
                                    </tr>
                                    <tr >
                                        <td align="right"><strong>Proveedores / Contratistas Relacionados:</strong></td>
                                        <td colspan="4" align="left"><?php echo contratos_relacionados_comite_solo_proveedores($sel_item[0], $permiso_o_adjudica); ?></td>
                                    </tr>
                                    <tr class="columna_subtitulo_resultados_letra_normal" >
                                        <td align="right"><strong>Objeto del Contrato:</strong></td>
                                        <td colspan="4" align="left"><?php
                                            if ($sel_item[8] == "")
                                                echo $sel_item[12];
                                            else
                                                echo $sel_item[8]
                                                ?></td>
                                    </tr>
                                    <tr class="" >
                                      <td colspan="5" align="center">
                                      
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
									  ?>
                                      
                                      <table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF"   class="tabla_lista_resultados">
                                        <tr>
                                          <td align="center"  class="fondo_desactiva_calendario">Objetivos del Proceso</td>
                                          <td align="center" class="fondo_desactiva_calendario">Descripci&oacute;n</td>
                                        </tr>
                                        <?

	  ?>
                                        <tr>
                                          <td width="31%" align="right">Oportunidad <img src="../imagenes/botones/help.gif" alt="Para cuando se requiere el servicio y que estamos proponiendo para cumplir con la fecha de entrega, y la estrategia que estamos proponiendo nos sirve para cumplir con el objetivo." width="20" height="20" title="Para cuando se requiere el servicio y que estamos proponiendo para cumplir con la fecha de entrega, y la estrategia que estamos proponiendo nos sirve para cumplir con el objetivo." /></td>
                                          <td width="69%" align="left"><? echo $p_oportunidad; ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right">Costo-Beneficio <img src="../imagenes/botones/help.gif" alt="Cual es el criterio que me genera el mejor costo beneficio Ejemplo Tiempo, Evaluaci&oacute;n T&eacute;cnica, otros, Precio." width="20" height="20" title="Cual es el criterio que me genera el mejor costo beneficio Ejemplo Tiempo, Evaluaci&oacute;n T&eacute;cnica, otros, Precio." /></td>
                                          <td align="left"><? echo $p_costo; ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right">Calidad <img src="../imagenes/botones/help.gif" alt="Que significa calidad para el proceso en espec&iacute;fico?  combinaci&oacute;n de tiempo? Entregable? " width="20" height="20" title="Que significa calidad para el proceso en espec&iacute;fico?  combinaci&oacute;n de tiempo? Entregable? " /></td>
                                          <td align="left"><? echo $p_calidad; ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right">Optimizar Transferencia Riesgos <img src="../imagenes/botones/help.gif" alt="Identificar los riesgos y escribir como se aseguran o cuales se transfieren y por que medio.  Si no se transfieren explicar el porque" width="20" height="20" title="Identificar los riesgos y escribir como se aseguran o cuales se transfieren y por que medio.  Si no se transfieren explicar el porque" /></td>
                                          <td align="left"><? echo $p_optimizar; ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right">Trazabilidad <img src="../imagenes/botones/help.gif" alt="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones." width="20" height="20" title="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones." /></td>
                                          <td align="left"><? echo $p_trazabilidad; ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right">Transparencia <img src="../imagenes/botones/help.gif" alt="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)" width="20" height="20" title="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)" /></td>
                                          <td align="left"><? echo $p_transparencia; ?></td>
                                        </tr>
                                        <tr>
                                          <td align="right">Sostenibilidad <img src="../imagenes/botones/help.gif" alt="Como nos estamos asegurando que los compromisos con las comunidades se van a tener encuentra en el proceso" width="20" height="20" title="Como nos estamos asegurando que los compromisos con las comunidades se van a tener encuentra en el proceso" /></td>
                                          <td align="left"><? echo $p_sostenibilidad; ?></td>
                                        </tr>
                                      </table>
                                      <?
									  }
									  ?>
                                      </td>
                                    </tr>
                                    <tr class="" >
                                        <td align="right"><strong>Comentario del Secretario del Comit&eacute;:</strong></td>
                                        <td colspan="3" align="left"><?php
                                            if ($tiene_permiso_secretrio == "SI") {
                                                ?>
                                                <textarea name="comenta_secretario_<?= $sel_sin_comi[0] ?>" cols="30" id="comenta_secretario_<?= $sel_sin_comi[0] ?>"><?= $sel_sin_comi[11] ?>
                                                </textarea>
                                                <?php
                                            } else {
                                                echo $sel_sin_comi[11];
                                            }
                                            ?></td>
                                        <td align="left"><?php
                                            if ($tiene_permiso_secretrio == "SI") {
                                                ?>
                                                <input name="sda2" type="button" value="Grabar Comentario" class="boton_grabar" onClick="graba_comentario_comite(<?= $sel_sin_comi[0] ?>)" />
                                                <?php
                                            }
                                            ?></td>
                                    </tr>
                                    <?php
                                    if ($tiene_permiso_secretrio == "SI" and $sel_item[3] <> 8) {
                                        ?>
                                        <tr >
                                            <td colspan="5" align="left" class="columna_subtitulo_resultados_letra_normal"> * Si modifica el valor de la solicitud se perder&aacute; la distribuci&oacute;n de la solicitud y pasara a ser &quot;corporativo sin socios&quot; </td>
                                        </tr>
                                        <?php
                                        $style_celda = "border-bottom:#000 2px solid; border-right:#000 2px solid; border-top:#000 2px solid; border-left:#000 2px solid; ";
                                    }
                                    ?>
                                    <tr class="columna_subtitulo_resultados_letra_normal" >
                                        <td align="right" valign="top"><strong>Nuevo Valor de la Solicitud:</strong></td>
                                        <td colspan="2" align="left" style="<?= $style_celda ?>"><?php
                                            //var_dump($sel_item[3]);
                                            $valor_usd_coo = "";
                                            $valor_cop_coo = "";

                                            if ($sel_sin_comi[12] == "") {
                                                $valor_usd_coo == "";
                                            } else {
                                                $valor_usd_coo = number_format($sel_sin_comi[12], 0);
                                            }


                                            if ($sel_sin_comi[15] == "") {
                                                $valor_cop_coo == "";
                                            } else {
                                                $valor_cop_coo = number_format($sel_sin_comi[15], 0);
                                            }

                                            if ($tiene_permiso_secretrio == "SI" and $sel_item[3] <> 8) {
                                                ?>
                                                <table width="100%" border="0">

                                                    <?php
                                                    if ($sel_item[3] == 1 || $sel_item[3] == 2 || $sel_item[3] == 3) {
                                                        ?>
                                                        <tr>
                                                            <td width="18%" align="right">USD$:</td>
                                                            <td width="82%"> <?= $valor_usd_coo ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right">COP$:</td>
                                                            <td><?= $valor_cop_coo ?></td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <td width="18%" align="right">USD$:</td>
                                                            <td width="82%"><input name="nue_valor_sol_<?= $sel_sin_comi[0] ?>" id="nue_valor_sol_<?= $sel_sin_comi[0] ?>"  onkeyup="puntitos(this, this.value.charAt(this.value.length - 1))" value="<?= $valor_usd_coo ?>" size="30" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right">COP$:</td>
                                                            <td><input name="nue_valor_sol_<?= $sel_sin_comi[0] ?>_cop" id="nue_valor_sol_<?= $sel_sin_comi[0] ?>_cop"  onkeyup="puntitos(this, this.value.charAt(this.value.length - 1))" value="<?= $valor_cop_coo ?>" size="30" /></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                                <?php
                                                if ($sel_item[3] == 7) {// si es ampliacion carga los contratos
                                                    $sele_presupuesto_contras_aplicas = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='" . $sel_item[0] . "' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
                                                    $id_contras_de_solis = "0";

                                                    while ($sel_presu_apica_contra = traer_fila_db($sele_presupuesto_contras_aplicas)) {
                                                        $sel_contr = query_db("select t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =" . $sel_presu_apica_contra[0]);


                                                        while ($sel_apl_cctra = traer_fila_db($sel_contr)) {
                                                            $id_contras_de_solis = $id_contras_de_solis . "," . $sel_apl_cctra[0];
                                                        }
                                                    }

                                                    if ($id_contras_de_solis <> "0") {
                                                        $comple_contras_sql_apli = " and id_contrato in ($id_contras_de_solis)";
                                                    } else {
                                                        $comple_contras_sql_apli = "";
                                                    }

                                                    $sele_contratos_mar_ampli = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =" . $sel_item[17] . " and t1_tipo_documento_id = 2 $comple_contras_sql_apli");
                                                    ?>
                                                    <table width="100%" border="0" align="right" class="tabla_lista_resultados" cellpadding="2" cellspacing="2">
                                                        <tr class="fondo_titulu_calendario">
                                                            <td width="70%" align="center">Numero del Contrato Marco</td>
                                                            <td width="30%" align="center">Selecci&oacute;n</td>
                                                        </tr>
                                                        <?php
                                                        while ($sel_cont_mar_ampli = traer_fila_db($sele_contratos_mar_ampli)) {
                                                            $numero_contrato1 = "C";
                                                            $separa_fecha_crea = explode("-", $sel_cont_mar_ampli[2]);
                                                            $ano_contra = $separa_fecha_crea[0];
                                                            $numero_contrato2 = substr($ano_contra, 2, 2);
                                                            $numero_contrato3 = $sel_cont_mar_ampli[1];
                                                            $numero_contrato4 = $sel_cont_mar_ampli[3];
                                                            ?>
                                                            <tr>
                                                                <td align="center"><?= numero_item_pecc_contrato($numero_contrato1, $numero_contrato2, $numero_contrato3, $numero_contrato4, $sele_contratos_mar_ampli[0]) ?></td>
                                                                <td align="center"><input type="checkbox" name="contra_<?= $sel_cont_mar_ampli[0] ?>_<?= $sel_sin_comi[0] ?>" id="contra_<?= $sel_cont_mar_ampli[0] ?>_<?= $sel_sin_comi[0] ?>" value="<?= $sel_cont_mar_ampli[0] ?>" /></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </table>
                                                    <?php
                                                }//fin si es ampliacion carga contratos
                                            } else {
                                                if ($sel_sin_comi[12] <> "") {
                                                    echo "USD$: " . $valor_usd_coo . "<br />";
                                                    echo "COP$: " . $valor_cop_coo;
                                                }
                                            }
                                            ?></td>
                                        <td align="left" valign="bottom"><?php
                                            if ($tiene_permiso_secretrio == "SI" and $sel_item[3] <> 8) {
                                                if ($sel_item[3] == 1 || $sel_item[3] == 2 || $sel_item[3] == 3) {
                                                    // Guardar según Invitacion a proponer, negociacion directa, proveedor exclusivo.
                                                    ?>
                                                                   
                                                    <input type="button" value="Guardar uno a uno" class="boton_grabar windowPopup" onClick='window.parent.document.getElementById("div_carga_busca_sol").style.display = "block";
                                                                   ajax_carga("../aplicaciones/comite/pecc/valor_solicitud.php?id_item_pecc=<?= $sel_item[0] ?>&id_comite=<?= $id_comite ?>", "div_carga_busca_sol");'
                                                            />
                                                           <?php
                                                       } else {
                                                           ?>
                                                    <input name="sda3" type="button" value="Grabar Nuevo Valor" class="boton_grabar" 
                                                           onClick="graba_nuevo_valor(<?= $sel_sin_comi[0] ?>, document.principal.nue_valor_sol_<?= $sel_sin_comi[0] ?>_cop.value, document.principal.nue_valor_sol_<?= $sel_sin_comi[0] ?>.value)" />
                                                           <?php
                                                       }
                                                   }
                                                   ?></td>
                                        <td align="left">&nbsp;</td>
                                    </tr>
                                    
                                    
                                    <?php 
                                    
                                    

                                    if ($val_usd >= MONTO_COMITE) { ?>
                                        <tr>
                                            <td width="413" align="right"><strong>Verificacion del Presidente <img src="../imagenes/botones/help.gif" alt="El presidente debe verificar este proceso para ser finalizado" title="El presidente debe verificar este proceso para ser finalizado" width="20" height="20" /></strong></td>
                                            <td colspan="4" align="left">
                                               
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
                                    <?php } else{
										?>
										 <tr>
                                            <td width="413" align="right"><strong>Verificacion del Presidente <img src="../imagenes/botones/help.gif" alt="El presidente debe verificar este proceso para ser finalizado" title="El presidente debe verificar este proceso para ser finalizado" width="20" height="20" /></strong></td>
                                            <td colspan="4" align="left">No Requiere</td>
                                        </tr>
										<?php
										
										} ?>
                                    

                                    <?php
                                    if ($tiene_permiso_secretrio == "SI") {
                                        ?>
                                        <tr class="" >
                                            <td colspan="5" align="center" valign="top"><table width="70%" border="0" align="left" class="tabla_lista_resultados">
                                                    <tr>
                                                        <td width="50%" align="right">Detalle del Anexo:</td>
                                                        <td width="50%"><input name="anexo_<?= $sel_item[0] ?>" type="text" id="anexo_<?= $sel_item[0] ?>" value="" size="25"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right">Seleccione el Anexo:</td>
                                                        <td><input name="adj_anexo_<?= $sel_item[0] ?>" type="file" id="adj_anexo_<?= $sel_item[0] ?>" size="5" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onClick="graba_anexo_edicion(19,<?= $sel_item[0] ?>)" /></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr >
                                        <td colspan="5" align="right"><table width="100%" border="0" align="center">
                                                <tr>
                                                    <td width="59%" valign="top">
                                                    
                                                    <div id="info_firmas<?=$sel_sin_comi[0]?>">
                                                    <table width="100%" border="0" class="tabla_lista_resultados">
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
                                                            <?php
                                                            $asistentes = query_db("SELECT dbo.t3_comite_asistentes.id_asistente, dbo.t3_comite_asistentes.id_us, dbo.t3_comite_asistentes.id_comite, 
               dbo.t1_us_usuarios.nombre_administrador, dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.rol_aprobacion, 
               dbo.t3_comite_asistentes.orden, dbo.t3_comite_asistentes.estado
FROM  dbo.t1_us_usuarios INNER JOIN
               dbo.t3_comite_asistentes ON dbo.t1_us_usuarios.us_id = dbo.t3_comite_asistentes.id_us
WHERE (dbo.t3_comite_asistentes.estado = 1) and dbo.t3_comite_asistentes.requiere_aprobacion in (1, 99) and dbo.t3_comite_asistentes.id_comite =" . $id_comite . "
ORDER BY dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.orden");
                                                            $cont = 0;
                                                            while ($sel_aproba = traer_fila_db($asistentes)) {

                                                                $sel_ultima_aprobacion = traer_fila_row(query_db("select max(id_aprobacion) from $c4 where id_asistente =  " . $sel_aproba[0] . " and id_item =" . $sel_sin_comi[0]));
                                                                $sel_aprobacion = traer_fila_row(query_db("select * from $c4 where id_aprobacion =  " . $sel_ultima_aprobacion[0]));
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
																		echo $sel_sin_comi[11];
																	}else{																	
																	 echo $sel_aprobacion[6];
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
                                                    <td colspan="2" valign="top"><?php
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
                                                                        <textarea name="observacion_<?= $sel_sin_comi[0] ?>" id="observacion_<?= $sel_sin_comi[0] ?>"><?= $sel_aprobacion[6] ?></textarea></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" align="center"><input name="sda" type="button" value="Confirmar Acci&oacute;n" class="boton_grabar" onClick="crea_accion_comite_usuario(<?= $sel_item[0] ?>,<?= $sel_asiste_usuario[0] ?>)" /></td>
                                                                    </tr>
                                                                </table>
                                                                <?php
                                                            }
                                                        }//FIN si ya tiene el estado
                                                        if ($activa_revision_sap == "SI" and $sel_item[2] > 19) {
                                                            ?>
                                                            <table width="100%" border="0" class="tabla_lista_resultados">
                                                                <tr class="fondo_3">
                                                                    <td colspan="2" align="center" class="fondo_titulu_calendario">Grabar Revisiones SAP</td>
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
                                                    <td width="21%" align="center" valign="top"><strong onClick="ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite=<?= $id_comite ?>', 'contenidos')"><font color="#FF0000">Actualizar Comit&eacute; </font><img src="../imagenes/botones/2.gif" alt=""  /></strong></td>
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
                        </tr>
                        <?php
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
    <input type="hidden" name="tipo_anexo" id="tipo_anexo" /><input type="hidden" id="id_item_pecc" name="id_item_pecc" />

</body>
</html>
