<?
include("../../librerias/lib/@session.php");
verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

$id_comite = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));


$sele_comite = traer_fila_row(query_db("select * from $c1 where id_comite = " . $id_comite . ""));

$edicion_datos_generales = "NO";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
    <title>Documento sin t&iacute;tulo</title>
    <link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
            <td valign="top"><?= encabezado_comite($id_comite) ?>

            </td>
        </tr>

        <tr>
            <!-- Formulario Buscador de solicitudes -->
            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                <tr>
                    <td width="13%" align="right">N&uacute;mero de la Solicitud:</td>
                    <td width="6%" >
                        <? $_SESSION['numero1_peccs'] = $_GET["numero1_pecc"] ?>       
                        <select name="numero1_pecc" id="numero1_pecc">
                            <option value="0" <? if ($_GET["numero1_pecc"] == 0) echo "selected='selected'"; ?>>Todos</option>
                            <option value="S" <? if ($_GET["numero1_pecc"] == "S") echo "selected='selected'"; ?>>S</option>
                            <option value="B" <? if ($_GET["numero1_pecc"] == "B") echo "selected='selected'"; ?>>B</option>
                        </select>
                    </td>
                    <td width="13%">
                        <? $_SESSION['numero2_peccs'] = $_GET["numero2_pecc"] ?>     
                        <select name="numero2_pecc" id="numero2_pecc">
                            <option value="0" <? if ($_GET["numero2_pecc"] == 0) echo "selected='selected'"; ?>> Todos</option>
                            <option value="13" <? if ($_GET["numero2_pecc"] == 13) echo "selected='selected'"; ?>> 13</option>
                            <option value="14" <? if ($_GET["numero2_pecc"] == 14) echo "selected='selected'"; ?>> 14</option>
                            <option value="99" <? if ($_GET["numero2_pecc"] == 99) echo "selected='selected'"; ?>> En Preparaci&oacute;n</option>
                        </select>
                    </td>
                    <td width="10%">
                        <? $_SESSION['numero3_peccs'] = $_GET["numero3_pecc"] ?>
                        <input name="numero3_pecc" type="text" id="numero3_pecc" size="5" maxlength="4" value="<?= $_GET["numero3_pecc"] ?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right">Solicitante:</td>
                    <td colspan="3">
                        <? $_SESSION['usuario_permisos'] = $_GET["usuario_permiso"] ?>       
                        <input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?= $_GET["usuario_permiso"] ?>"/></td>
                </tr>
                <tr>
                    <td align="right">&Aacute;rea Usuaria:</td>
                    <td colspan="3">
                        <? $_SESSION['bus_areas'] = $_GET["bus_area"] ?> 
                        <select name="bus_area" id="bus_area">
                            <?= listas($g12, " estado = 1", $_GET["bus_area"], 'nombre', 1); ?>
                        </select></td>
                </tr>
                <tr>
                    <td align="right">Tipo de Permiso</td>
                    <td>
                        <? $_SESSION['perm_adjud'] = $_GET["perm_adjud"] ?>       
                        <select name="perm_adjud" id="perm_adjud">
                            <option value="" <? if ($_GET["perm_adjud"] == 0) echo "selected='selected'"; ?>>Todos</option>
                            <option value="1" <? if ($_GET["perm_adjud"] == "S") echo "selected='selected'"; ?>>Permiso</option>
                            <option value="2" <? if ($_GET["perm_adjud"] == "B") echo "selected='selected'"; ?>>Adjudicaci&oacute;n</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">Objeto de la Solicitud:</td>
                    <td colspan="3">
                        <? $_SESSION['bus_text5s'] = $_GET["bus_text5"] ?>         
                        <textarea name="bus_text5" id="bus_text5" cols="25" rows="2"><?= $_GET["bus_text5"] ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5" align="center">
                        <input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" 
                               onclick="ajax_carga('../aplicaciones/comite/organiza-items.php?tipo_ajax=1&amp;id_comite=<?= $id_comite ?>&amp;id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&amp;numero1_pecc=' + document.principal.numero1_pecc.value
                                               + '&amp;numero2_pecc=' + document.principal.numero2_pecc.value
                                               + '&amp;numero3_pecc=' + document.principal.numero3_pecc.value
                                               + '&amp;bus_text5=' + document.principal.bus_text5.value
                                               + '&amp;bus_area=' + document.principal.bus_area.value
                                               + '&amp;perm_adjud=' + document.principal.perm_adjud.value
                                               + '&usuario_permiso=' + document.principal.usuario_permiso.value, 'contenidos')" />
                    </td>
                </tr>
            </table>
            <!-- Fin Buscador de solicitudes-->
        </tr>
        
        <?php
		
		/*
            $bandera=false;
            $query="SELECT descarga_archivo_conflicto FROM $c2 WHERE id_comite=$id_comite";
            $res=query_db($query);
            while($result = traer_fila_row($res)){//COMIENZO WHILE                
                if ($result[0]!=1) {
                    $bandera=true;
                }
            }
			
			*/
			
			
			$bandera="Completo";
            $query="SELECT descarga_archivo_conflicto FROM $c2 WHERE id_comite=$id_comite";
            $res=query_db($query);
            while($result = traer_fila_row($res)){//COMIENZO WHILE                
                if ($result[0]==3) {
                    $bandera="Faltan_descarga";
                }
            }
			
            //$result=traer_fila_row(query_db($query));
        if ($bandera=="Faltan_descarga") {//VALIDACIÓN SI DESCARGO EL ARCHIVO DE CONFLICTOS DE INTERÉS while($result=traer_fila_db(query_db($query))){//COMIENZO WHILE?>
        <tr>
            <td>
                <strong>Para poder organizar las solicitudes debe descargar: </strong>
            </td>
            <td>
                <strong onclick="graba_descarga_conflicto3()" style="cursor:pointer"><a href="../archivo_conflicto/conflictos2.xls">Listado de conflicto de empleados Hocol</a></font></strong>
            </td>
        </tr>
        <?}else{
        ?>
        <tr>
            <td valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                    <tr >
                        <td colspan="12" align="center"  class="fondo_3">Lista de las Solicitudes Relacionadas a este Comit&eacute;</td>
                    </tr>
                    <tr >
                        <td width="8%" align="center" class="fondo_3">Numero de la Solicitud</td>
                        <td width="10%" align="center" class="fondo_3">Solicitante</td>
                        <td width="11%" align="center" class="fondo_3">Area</td>
                        <td width="9%" align="center" class="fondo_3">Tipo de Proceso</td>
                        <td width="23%" align="center" class="fondo_3">Objeto Solicitud</td>
                        <td width="11%" align="center" class="fondo_3">Valor Origen COP$</td>
                        <td width="11%" align="center" class="fondo_3">Valor Origen USD$</td>
                        <td width="11%" align="center" class="fondo_3">Fecha de la Ultima Firma</td>
                        <td colspan="2" align="center" class="fondo_3">Orden</td>
                        <td width="4%" align="center" class="fondo_3">&nbsp;</td>
                        <td width="4%" align="center" class="fondo_3">Conflicto Inter&eacute;s</td>
                    </tr>
                    <?
                    /* Parametros busqueda */
                    $numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
                    $numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
                    $numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
                    $explode = explode("----,", $_GET["usuario_permiso"]);
                    $id_usuario = $explode[1];
                    $bus_area = arreglo_recibe_variables($_GET["bus_area"]);
                    $bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
                    $perm_adjud = arreglo_recibe_variables($_GET['perm_adjud']);

                    $completar_filtros = "";

                    if ($numero1_pecc != "0" and $numero1_pecc != "") {
                        $completar_filtros.=" and num1 = '" . $numero1_pecc . "'";
                    }
                    if ($numero2_pecc != "" and $numero2_pecc != 0) {
                        if ($numero2_pecc == 99) {
                            $completar_filtros.=" and (num2 = '' or num2 = ' ' or num2 is NULL)";
                        } else {
                            $completar_filtros.=" and num2 like '%" . $numero2_pecc . "%'";
                        }
                    }
                    if ($numero3_pecc != "" and $numero2_pecc != 99) {
                        $completar_filtros.=" and num3 = '" . $numero3_pecc . "'";
                    }
                    if ($bus_area != 0) {
                        $completar_filtros.=" and t1_area_id = " . $bus_area;
                    }

                    if ($id_usuario <> "") {
                        $completar_filtros.=" and id_us =" . $id_usuario;
                    }

                    if ($perm_adjud != "") {
                        $completar_filtros.=" and permiso_o_adjudica =" . $perm_adjud;
                    }

                    if ($bus_text5 != "") {
                        $completar_filtros.=" and (objeto_solicitud like '%" . $bus_text5 . "%' or ob_solicitud_adjudica like '%" . $bus_text5 . "%')";
                    }
                    /* Fin Parametros busqueda */
                    $cont=0;
                    $sel_item_sin_comite = query_db("SELECT * from $vcomite2 where id_comite = " . $id_comite . " and estado <> 3 $completar_filtros order by orden asc");
                    while ($sel_sin_comi = traer_fila_db($sel_item_sin_comite)) {//INICIO WHILE 
                    
                        $sel_item = traer_fila_row(query_db("select id_item,objeto_solicitud, estado, ob_solicitud_adjudica,t1_tipo_proceso_id, es_modificacion from $pi2 where id_item=" . $sel_sin_comi[0]));
                        $sele_nivel_anterior = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3  where id_item=" . $sel_item[0] . " and actividad_estado_id < 7 and  estado = 1"));
                        $sele_datos_actividad = traer_fila_row(query_db("select fecha_real from $vpeec3  where id_item=" . $sel_item[0] . " and actividad_estado_id = " . $sele_nivel_anterior[0] . " and  estado = 1"));
						
						$id_tipo_proceso_pecc = 1;
            			if($sel_item[3] == 7){
            					$id_tipo_proceso_pecc = 2;
            				}
            			if($sel_item[3] == 8){
            					$id_tipo_proceso_pecc = 3;
            				}
						
                		if($sel_item[2] == 8){
                		$permiso_o_adjudica = 1;
                		}
                		if($sel_item[2] == 17){
                		$permiso_o_adjudica = 2;
                		}
                		
						$valor_solicitud = explode("---",valor_solicitud($sel_item[0], $permiso_o_adjudica));
		
                        ?>
                        <tr >
                            <td align="center">	<strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?= $sel_item[0] ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&permiso_o_adjudica=<?= $permiso_o_adjudica ?>')" style="cursor:pointer"><?= numero_item_pecc($sel_sin_comi[3], $sel_sin_comi[4], $sel_sin_comi[5]) ?> Detalle</strong>

                            </td>
                            <td align="center"><?= $sel_sin_comi[14] ?></td>
                            <td align="center"><?= $sel_sin_comi[13] ?></td>
                            <td align="center"><?
                                
								
								if($sel_item[5]==1){ echo "Modificacion";} else{
								echo saca_nombre_lista($g13,$sel_item[4],'nombre','t1_tipo_proceso_id',$sel_item[0]);
								}
							
							
                              
								
								
                                ?></td>
                            <td align="center"><? if($sel_item[3] != "" and $sel_item[3] != " " and $sel_item[3] != "  " and $sel_item[3] != "	") echo $sel_item[3]; else echo $sel_item[1]; ?></td>
                            <td align="center"> <?= number_format($valor_solicitud[1], 0) ?></td>
                            <td align="center"><?= number_format($valor_solicitud[0], 0) ?></td>
                            <td align="center"><?= $sel_sin_comi[24] ?></td>
                            <td width="7%" align="center"><input name="orden_ordena_<?= $sel_sin_comi[0] ?>" type="text" id="orden_ordena_<?= $sel_sin_comi[0] ?>"  value="<?= $sel_sin_comi[8] ?>" size="2" maxlength="3"  /></td>
                            <td width="4%" align="center"><img src="../imagenes/botones/2.gif" onclick="cambia_oprde_ite_comite(<?= $sel_sin_comi[0] ?>)" /></td>
                            <td align="center">
                                <img src="../imagenes/botones/eliminada_temporal.gif" onclick="quita_comite2('<?=$cont;?>')" />
                                <lablel>Comentarios:</lablel>
                                <textarea style="width: 200px" id="comite_coment<?=$cont;?>" name="comite_coment<?=$cont;?>"></textarea>
                                <input type="hidden" name="id_item_agrega<?=$cont;?>" id="id_item_agrega<?=$cont;?>" value="<?=$sel_item[0]?>">
                            </td>
                            <td width="4%" align="center"><select onchange="graba_conflicto_comite(this.id)" name="<?=$cont;?>" id="<?=$cont;?>">
                            <?php
                                $query="SELECT revisa_archivo_conflicto FROM $c2 WHERE id_item=$sel_item[0] and id_comite=".$id_comite;
                                $result=traer_fila_row(query_db($query));
								
								
                                if ($result[0]==3) {?>
                                    <option value="0">---</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                <? }else if ($result[0]==1){?>
                                    <option value="0">---</option>
                                    <option value="1" <? echo "selected='selected'"?>>Si</option>
                                    <option value="2">No</option>
                                <? }else if ($result[0]==2){?>
                                    <option value="0">---</option>
                                    <option value="1">Si</option>
                                    <option value="2" <? echo "selected='selected'"?>>No</option>
                                <? }
                            ?>
                            
                                
                                
                                
                            </select><input type="hidden" name="idsolicitud<?=$cont;?>" id="idsolicitud<?=$cont;?>" value="<?=$sel_item[0]?>"></td>
                        </tr>

                        <? $cont++;
                    }//FIN DEL WHILE
                    ?>
                    <tr >
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td colspan="6" align="center">&nbsp;</td>
                    </tr>
                </table></td>
        </tr>
        <?
        }//FIN VALIDACIÓN SI DESCARGO EL ARCHIVO DE CONFLICTOS DE INTERÉS
        ?>

        <tr>
            <td valign="top" id="carga_acciones_permitidas">
                <table width="100%" border="0">
                    <tr>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div id="carga_query"></div>
    <input type="hidden" name="id_comite" id="id_comite" value="<?= $id_comite ?>" />
    <input type="hidden" name="id_comite_agrega" id="id_comite_agrega"/>
    <input type="hidden" name="id_item_agrega" id="id_item_agrega" />
    <input type="hidden" name="orden_cambia" id="orden_cambia" />
    <input type="hidden" name="id_relacion" id="id_relacion" />
    <input type="hidden" name="id_solicitud_pasa" id="id_solicitud_pasa" />
    <input type="hidden" name="valor_solicitud_pasa" id="valor_solicitud_pasa" />
    <textarea style="display: none" id="comite_coment" name="comite_coment"></textarea>
</body>
</html>
