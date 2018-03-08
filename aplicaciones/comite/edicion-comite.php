<?php
include("../../librerias/lib/@session.php");
verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

$id_comite = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));


$sele_comite = traer_fila_row(query_db("select * from $c1 where id_comite = " . $id_comite . ""));
$hora=$sele_comite[15];
$hora=explode(":", $hora);
$edicion_datos_generales = "NO";
if (verifica_usuario_indicado(10, $sel_item[0]) == "SI") {
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
            <td valign="top"><?= encabezado_comite($id_comite) ?>

            </td>
        </tr>
        <tr>
            <td valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                    <tr >
                        <td width="50%" align="right">Usuario que lo Creo:</td>
                        <td width="42%"><? echo traer_nombre_muestra($sele_comite[1], $g1,"nombre_administrador","us_id")?></td>
                        <td width="8%">&nbsp;</td>
                    </tr>
                    <tr >
                        <td align="right">Fecha de Creaci&oacute;n:</td>
                        <td><?= $sele_comite[5] ?></td>
                        <td>&nbsp;</td>
                    </tr>
                <?
                if($id_comite < 115){
				
				?>    
                    <tr >
                        <td align="right">Verificaci&oacute;n del Presidente:</td>
                        <td><?php
//                            if ($sele_comite[13] == 0 and $_SESSION["id_us_session"] == $presidente and $sele_comite[4] == 1) {
                                ?>
<!--                                <select name="presidente" id="presidente">
                                    <option value="1" <? if($sele_comite[13] == 1) echo 'selected="selected"'?> >Verificado</option>
                                    <option value="0" <? if($sele_comite[13] <> 1) echo 'selected="selected"'?>>Sin Verificar</option>
                                </select>
                                <input name="fff" type="button" value="Grabar Cambios" class="boton_grabar" onclick="graba_verifica_comite()" />-->
                                <?php
//                            } else {
                                if ($sele_comite[13] == 1) {
                                    echo "Verificado el " . $sele_comite[12];
                                }
                                if ($sele_comite[13] == 2) {
                                    echo "No requiere";
                                }
                                if ($sele_comite[13] == 0) {
                                    echo "Sin Verificar";
                                }
//                            }
                            ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    
                    <?
                    }
					?>
                    <tr >
                        <td align="right">Fecha del Comit&eacute;:</td>
                        <td><?php
                            if ($edicion_datos_generales == "SI" and $sele_comite[4] <> 1) {
                                ?>
                                <input name="fecha_comite" type="text" id="fecha_comite" onmousedown="calendario_sin_hora('fecha_comite')" value="<?= $sele_comite[2] ?>" readonly="readonly" />
                                <?php
                            } else {
                                echo $sele_comite[2];
                            }
                            ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr >
                        <td width="25%" align="right">Hora del Comit&eacute;:</td>
                        <?php
                            if ($edicion_datos_generales == "SI" and $sele_comite[4] <> 1) {
                                ?>
                                <td>
                                <table>
                                <tr>
                                <td><select name="hora_i" id="hora_i">
                                    <option value="100" <? if($hora[0]=="100" or $hora[0]=="0" or $hora[0]=="") echo "selected='selected'"; ?>>Seleccione</option>
                                    <option value="01" <? if($hora[0]=="01" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>01</option>
                                    <option value="02" <? if($hora[0]=="02"  and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>02</option>
                                    <option value="03" <? if($hora[0]=="03" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>03</option>
                                    <option value="04" <? if($hora[0]=="04" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>04</option>
                                    <option value="05" <? if($hora[0]=="05" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>05</option>
                                    <option value="06" <? if($hora[0]=="06" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>06</option>
                                    <option value="07"<? if($hora[0]=="07" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>07</option>
                                    <option value="08" <? if($hora[0]=="08" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>08</option>
                                    <option value="09" <? if($hora[0]=="09" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>09</option>
                                    <option value="10" <? if($hora[0]=="10" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>10</option>
                                    <option value="11" <? if($hora[0]=="11" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>11</option>
                                    <option value="12"<? if($hora[0]=="12" and $hora[0]!="0" and $hora[0]!="") echo "selected='selected'"; ?>>12</option>
                                </select></td>
                                 <td><select name="minuto_i" id="minuto_i">
                                    <option value="100" <?if($hora[1]=="100") echo "selected='selected'"; ?>>Seleccione</option>
                                    <?
                                        $min="";
                                        for($i=0; $i<=60; $i++){
                                            if(strlen($i)==1){
                                                $min="0".$i;
                                            }else{
                                                $min=$i;
                                            }
                                    ?>
                                        <option value="<?=(string)$min?>" <?if($hora[1]==(string)$min) echo "selected='selected'"; ?>><?=(string)$min?></option>
                                    <?
                                        }
                                    ?>
                                </select></td>
                                <td><select name="formato_i" id="formato_i">
                                    <option value="100" <?if($hora[2]==100) echo "selected='selected'"; ?>>Seleccione</option><option value="A.M" <?if($hora[2]=="A.M") echo "selected='selected'"; ?>>A.M</option><option value="P.M" <?if($hora[2]=="P.M") echo "selected='selected'"; ?>>P.M</option>
                                </select></td>
                                </tr>
                                </table>
                                </td>
                                <?php
                            } else {?>
                                <td><?=$sele_comite[15];?></td>
                                <td>&nbsp;</td>
                            <?}
                            ?>
                    </tr>
                    <tr >
                        <td align="right">Lugar del Comit&eacute;:</td>
                        <td><?php
                            if ($edicion_datos_generales == "SI" and $sele_comite[4] <> 1) {
                                ?>
                               
                                <select name="lugar_comite" id="lugar_comite">
                                <option value="">Seleccione una Sala.</option>
<option value="Sala Bonga" <? if ($sele_comite[3]=="Sala Bonga") echo 'selected="selected"' ?> >Sala Bonga</option>
<option value="Sala Caballos" <? if ($sele_comite[3]=="Sala Caballos") echo 'selected="selected"' ?>>Sala Caballos</option>
<option value="Sala Carbonera" <? if ($sele_comite[3]=="Sala Carbonera") echo 'selected="selected"' ?>>Sala Carbonera</option>
<option value="Sala CPF" <? if ($sele_comite[3]=="Sala CPF") echo 'selected="selected"' ?>>Sala CPF</option>
<option value="Sala Exploraci&oacute;n" <? if ($sele_comite[3]=="Sala Exploración") echo 'selected="selected"' ?>>Sala Exploraci&oacute;n</option>
<option value="Sala Iguana" <? if ($sele_comite[3]=="Sala Iguana") echo 'selected="selected"' ?>>Sala Iguana</option>
<option value="Sala Mamey" <? if ($sele_comite[3]=="Sala Mamey") echo 'selected="selected"' ?>>Sala Mamey</option>
<option value="Sala Merlin" <? if ($sele_comite[3]=="Sala Merlin") echo 'selected="selected"' ?>>Sala Merlin</option>
<option value="Sala Monserrate" <? if ($sele_comite[3]=="Sala Monserrate") echo 'selected="selected"' ?>>Sala Monserrate</option>
<option value="Virtual" <? if ($sele_comite[3]=="Virtual") echo 'selected="selected"' ?>>Virtual</option>

                                </select>
                                <?php
                            } else {
                                echo $sele_comite[3];
                            }
                            ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php
                    if ($edicion_datos_generales == "SI" and $sele_comite[4] <> 1) {
                        ?>
                        <tr >
                            <td align="right">Estado:</td>
                            <td><select name="estado_comite_abre_cierra" id="estado_comite_abre_cierra">
                                    <option value="3" <? if($sele_comite[4] == 3) echo 'selected="selected"'?> >Abierto a los Asistentes para su Aprobaci&oacute;n</option>
                                    <option value="2" <? if($sele_comite[4] == 2) echo 'selected="selected"'?>>Cerrado a los Asistentes para su Aprobaci&oacute;n</option>
                                </select></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr >
                        <td align="right">Tipo de Comit&eacute;:</td>
                        <td><?php
                            if ($edicion_datos_generales == "SI" and $sele_comite[4] <> 1) {
                                ?>
                                <select name="extra_comite" id="extra_comite">
                                    <option value="2" <? if($sele_comite[14] == 2) echo "selected='selected'";?>  >Normal</option>
                                    <option value="1" <? if($sele_comite[14] == 1) echo "selected='selected'";?>>Extraordinario</option>
                                </select>
                                <?php
                            } else {
                                if ($sele_comite[14] == 1) {
                                    echo "Extraordinario";
                                } else {
                                    echo "Normal";
                                }
                            }
                            ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr >
                        <td align="right">&nbsp;</td>
                        <td><?php
                            if ($edicion_datos_generales == "SI" and $sele_comite[4] <> 1) {
                                ?>
                                <input name="fff" type="button" value="Grabar Cambios" class="boton_grabar" onclick="garba_edita_comite('')" />
                                <?php
                            }
                            ?>
                            &nbsp;
                            <input type="hidden" name="tipo_comite_virtual_presencial" id="tipo_comite_virtual_presencial" value="virtual" /></td>
                        <td>&nbsp;</td>
                    </tr>
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

</body>
</html>
