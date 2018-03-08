<? include("../../librerias/lib/@session.php");

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
								. "convirte_marco from $pi2 where id_item=" . $id_item_agrega));
								
								
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
?>

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
ORDER BY dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.orden");
                                                            $cont = 0;
                                                            while ($sel_aproba = traer_fila_db($asistentes)) {

                                                                $sel_ultima_aprobacion = traer_fila_row(query_db("select max(id_aprobacion) from $c4 where id_asistente =  " . $sel_aproba[0] . " and id_item =" . $id_item_agrega));
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
																		echo nl2br($sel_sin_comi[11]);
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
