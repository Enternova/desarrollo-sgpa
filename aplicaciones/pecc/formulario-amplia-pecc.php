<?php
include("../../librerias/lib/@session.php");
verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=" . $id_item_pecc));
$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
$id_contrato_pass=elimina_comillas(arreglo_recibe_variables($_GET["id_contrato_pass"]));
$tipo_proceso_get=elimina_comillas(arreglo_recibe_variables($_GET["tipo_proceso"]));
echo $tipo_proceso_get;

$id_gerente=traer_fila_row(query_db("SELECT DISTINCT gerente FROM $co1 WHERE id=".$id_contrato_pass));
$num_ale = rand(0, 99);
$num_ale.= rand(0, 99);
$aleatorio = $fecha . $num_ale . $hora;

if ($id_pecc == 1) {
    $titulo_1 = "";
} else {
    $titulo_1 = " - PECC";
}
$sel_contrato_cualquiera = traer_fila_row(query_db("select id from t7_contratos_contrato where id_item = ".$id_item_pecc));
llena_tabla_temporal_reporte_marco("saldos", $sel_contrato_cualquiera[0]);

$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = " . $_SESSION["id_us_session"]));


$select_data_item = traer_fila_row(query_db("select t2.t1_area_id, t2.nombre, CAST(t1.ob_contrato_adjudica AS text), CAST(t1.objeto_contrato AS text) from $pi2 as t1, $g12 as t2 where t1.id_item=" . $id_item_pecc . " and t1.t1_area_id = t2.t1_area_id"));


if ($id_tipo_proceso_pecc == 2) {
    $valor = 7;
    $titulo_principal = "Informaci&oacute;n General de la Ampliaci&oacute;n";
    $titulo_fecha = "Fecha para cuando se requiere la Ampliaci&oacute;n";
    $tipo_proceso_item = "Ampliaci&oacute;n Contrato Marco";
    $titulo_presupuesto = "Valor de los Contratos Marco para la Ampliaci&oacute;n";
}
if ($id_tipo_proceso_pecc == 3) {
    $valor = 8;
    $titulo_principal = "Informaci&oacute;n General de las Ordenes de Trabajo";
    $titulo_fecha = "Fecha para cuando se requiere la OT";
    $tipo_proceso_item = "Orden de trabajo Contrato Marco";
    $titulo_presupuesto = "Asignaci&oacute;n Presupuestal de Ordenes de Trabajo a Contratos";
}

//verifica si es administrador de ordenes de trabajo
$sel_si_es_administrador_de_ots = traer_fila_row(query_db("select * from v_seg1 where us_id =" . $_SESSION["id_us_session"] . " and id_premiso = 33"));
$es_admin_ot = "NO";
if ($sel_si_es_administrador_de_ots[0] > 0 and $id_tipo_proceso_pecc == 3) {
    $es_admin_ot = "SI";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>Documento sin t&iacute;tulo</title>
    <link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
    <table width="100%" border="0">
        <tr>
            <td width="90%" align="right"><img src="../imagenes/botones/aviso_observaciones.png" alt="" width="16" height="16" /> <span class="titulos_resumen_alertas">&iquest;No es la solictud que estaba buscando ?</span></td>
            <td width="10%"><input name="volver_buscar" type="button" value="Volver a Buscar" onclick="document.getElementById('buscardor_solicitud_contrato_marco').style.display = '';
                    document.getElementById('carga_formulario_solicitud').style.display = 'none'" class="boton_buscar" /></td>
        </tr>
    </table>

    <?



    $sel_pecc = traer_fila_row(query_db("select $pi1.id_pecc,$pi1.ano,$pi1.objeto,$g1.nombre_administrador, $g10.valor, $pi1.nombre, $g10.id_trm from $pi1, $g1, $g10 where $pi1.id_pecc = ".$id_pecc." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
    ?>
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
            <td colspan="7"  class="titulos_secciones"><?= $titulo_principal . $titulo_1 ?></td>
        </tr>
    </table>
    <table width="99%" border="0" cellpadding="2" cellspacing="2">
        <tr >
            <td align="right">Tipo de contrataci&oacute;n:</td>
            <td width="27%">Contrataci&oacute;n de Servicios</td>
            <td width="37%" rowspan="8" valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                        <td height="25" align="left" class=""><?= $sel_pecc[2] ?></td>
                    </tr>
                    <?
                    if($id_pecc != 1){
                    ?>
                    <tr>
                        <td align="left">Encargado del PECC: <?= $sel_pecc[3] ?>
                        </td>
                    </tr>
                    <tr class="">
                        <td align="left">A&ntilde;o: <?= $sel_pecc[1] ?></td>
                    </tr>
                    <?
                    }
                    ?>
                    <tr class="">
                        <td align="left">TRM:
                           <?=number_format(trm_presupuestal($sel_pecc[1]))?> </td>
                    </tr>
                </table></td>
        </tr>

        <?
     /*   if($sel_item[3] != $_SESSION["id_us_session"]){
        ?>
        <tr>
            <td colspan="2" align="right"><span class="titulos_resumen_alertas">Usted no es el gerente del contrato</span></td>
        </tr>
        <?
        }*/
        if($sel_usu_emulan[0]>0){
        ?>

        <tr >
            <td align="right">Preparador:</td>
            <td><?= $_SESSION["us_nombre_session"] ?></td>
        </tr>
        <?
        }
        ?>
        <tr >
            <td align="right">
                <?
                if($es_admin_ot == "SI"){
                echo "Solicitante de la OT:";
                }else{
                echo "Gerente del ITEM: ";
                }
                ?>
            </td>
            <td> <?
                if($sel_usu_emulan[0]>0){
					
                ?>
                <select name="gerente_contra" id="gerente_contra">
                    <option value="0">Seleccione el Gerente</option>
                    <?
                    $sel_usu_emula = query_db("select t1.us_id,t1.nombre_administrador from t1_us_usuarios as t1, t2_relacion_usuarios_emulan as t2 where t2.id_us_emula = t1.us_id and t2.id_us = ".$_SESSION["id_us_session"]." and t1.email like '%@hocol.com%' and t1.estado = 1 group by t1.us_id,t1.nombre_administrador");
                    while($sel_us_emu = traer_fila_row($sel_usu_emula)){
                    ?>
                    <option value="<?= $sel_us_emu[0] ?>"><?= $sel_us_emu[1] ?></option>
                    <?
                    }
                    ?>
                </select>
                <?
                }else{
                echo $_SESSION["us_nombre_session"]?><input type="hidden" name="gerente_contra" id="gerente_contra" value="<?= $_SESSION["id_us_session"] ?>" /><?
                }
                ?></td>
        </tr>
        <?

        if($es_admin_ot == "SI"){

        ?>
        <tr >
            <td align="right">Gerente de la OT:</td>
            <td><input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()"/></td>
        </tr>
        <?
        }else{
        ?><input type="hidden" name="usuario_permiso" id="usuario_permiso" value="<?= "es----," . $_SESSION["id_us_session"] . "----," ?>"/><?
			
        }
        ?>
        <tr >
            <td width="36%" align="right">Tipo de Proceso:</td>
            <td>
                <?=$tipo_proceso_item ?>
                <input type="hidden" name="tipo_proceso" id="tipo_proceso" value="<?= $valor ?>" />
            </td>
        </tr>
        <tr>
            <td align="right">&Aacute;rea Usuaria:</td>
            <td>
            <?
				//PARA EL DES 071
			?>
            <select name="area_usuaria" id="area_usuaria">
                <?
                if($id_tipo_proceso_pecc == 3){ //Si es ORden de trabajo a contrato marco***************

                    $area_default="";
                    $area_default2="";
                    $contador=0;
                    $sel_v_usuario_area="SELECT * FROM $v_contra3 WHERE id_usuario=".$id_gerente[0];
                    $usuario_area=query_db($sel_v_usuario_area);
                    while($area=traer_fila_row($usuario_area)){//selecciona todas la areas del gerente de contrato
                        $area_default=$area_default."'".$area[2]."'";
                    }
                    $busca_area_pecc=query_db("SELECT * FROM tabla_contrato_area($id_item_pecc)");
                    while($area=traer_fila_row($busca_area_pecc)){//Selecciona las areas de las solicitudes relacionadas
                        $area_default=$area_default."'".$area[0]."'";
                      }
					 $sel_area_confi_ger="SELECT * FROM $v_contra4 WHERE estado=1 AND id_contrato=".$id_contrato_pass." ORDER BY NOMBRE ASC";
					$area_confi_g=query_db($sel_area_confi_ger);
					while($area=traer_fila_row($area_confi_g)){//Selecciona las areas configuradas por el gerente de contrato
					 $area_default=$area_default."'".$area[2]."'";
					}
                   if ($area_default!=""){
                        $area_default=str_replace("''", ", ", $area_default);
                        $area_default=str_replace("'", "", $area_default);
                    }
                    $sel_v_usuario_area="SELECT * FROM $v_contra3 WHERE id_usuario=".$_SESSION["id_us_session"]." AND id_area IN($area_default)";
                    $usuario_area=query_db($sel_v_usuario_area);
                    while($area=traer_fila_row($usuario_area)){//Busca las areas del gerente de ot / solicitante
                        $contador=$contador+1;
                        ?> <option value="<?=$area[2]?>" <? if($s_areas_ot[0] == $sel_areas_contra_inicial[0]) echo 'selected="selected"'?> ><?=$area[3] ?></option><?
                    }//FIN WHILE USUARIO_AREA
					
                                        if($contador==0){//SI EL USUARIOI NO PERTENECE A LAS AREAS ASSIGNADAS A LA SOLICITUD  ?>
                        <option value='0'>No Tiene Ninguna Area Relacionada para este contrato</option>
                <?  }//SI EL USUARIOI NO PERTENECE A LAS AREAS ASSIGNADAS A LA SOLICITUD
				//FIN Si es ORden de trabajo a contrato marco*************************
                }elseif($id_tipo_proceso_pecc == 2 or saber_si_solicitud_tiene_contratos_de_bienes($sel_item[0]) == "SI"){
				
                ?>
                
                    <?
                    $sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$_SESSION["id_us_session"]." and t1.estado = 1 ");
                    while($sel_a_usuario = traer_fila_db($sel_areas)){
                    ?>
                    <option value="<?= $sel_a_usuario[0] ?>" <? if($sel_item[5] == $sel_a_usuario[0]) echo 'selected="selected"'?> ><?= $sel_a_usuario[1] ?></option>
                    <?
                    }
                    ?>
                    <?
                    }else{
					
					
                    $sel_areas_contra_inicial = traer_fila_row(query_db("select t1.t1_area_id,t1.nombre from $g12 as t1, t2_item_pecc as t2  where t1.t1_area_id = t2.t1_area_id and  t2.id_item = ".$id_item_pecc." group by t1.t1_area_id,t1.nombre"));

					$areas_aplica_ot = $sel_areas_contra_inicial[0];
					
					/*SELECCIONAR SI EL USUARIO LOGUEADO ES UN GERENTE DE LOS CONTRATOS RELACIONADOS.*/
					
					$sel_si_gerente = traer_fila_row(query_db("select count(*) from  t7_contratos_contrato where id_item = ".$id_item_pecc." and gerente = '".$_SESSION["id_us_session"]."'"));
					if($sel_si_gerente[0]>0){
						$sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$_SESSION["id_us_session"]." and t1.estado = 1");
                    while($sel_a_usuario = traer_fila_db($sel_areas)){//selecciona las areas del gerente de contrto
						$areas_aplica_ot = $areas_aplica_ot.",".$sel_a_usuario[0];
						}
						}
					/*SELECCIONAR SI EL USUARIO LOGUEADO ES UN GERENTE DE LOS CONTRATOS RELACIONADOS.*/
					
				  if( $sel_areas_contra_inicial[0] == 16){							
						$areas_aplica_ot = $areas_aplica_ot.",40,41";						                   
                        $no_in = " and t1.t1_area_id not in (40,41)";
                  }elseif($areas_aplica_ot == 24){
 					    $areas_aplica_ot = $areas_aplica_ot.",34";						                   
                        $no_in = " and t1.t1_area_id not in (34)";
			  	  }elseif($areas_aplica_ot == 25 or $areas_aplica_ot == 20){
		   			   $areas_aplica_ot = $areas_aplica_ot.",35";						                   
                        $no_in = " and t1.t1_area_id not in (35)";
				  }elseif($areas_aplica_ot == 22 or $areas_aplica_ot == 26 or $areas_aplica_ot == 32){
					  $areas_aplica_ot = $areas_aplica_ot.",36";						                   
                        $no_in = " and t1.t1_area_id not in (36)";
				  }elseif($areas_aplica_ot == 6){
					  $areas_aplica_ot = $areas_aplica_ot.",37";						                   
                        $no_in = " and t1.t1_area_id not in (37)";				  
				  }elseif($areas_aplica_ot == 21 or $areas_aplica_ot == 29){
					  $areas_aplica_ot = $areas_aplica_ot.",38";						                   
                        $no_in = " and t1.t1_area_id not in (38)";
				  }elseif($areas_aplica_ot == 12){
				  		$areas_aplica_ot = $areas_aplica_ot.",39";						                   
                        $no_in = " and t1.t1_area_id not in (39)";
				  }elseif($areas_aplica_ot == 17){
					  $areas_aplica_ot = $areas_aplica_ot.",40";						                   
                        $no_in = " and t1.t1_area_id not in (40)";
				  }elseif($areas_aplica_ot == 18){
					  $areas_aplica_ot = $areas_aplica_ot.",41";						                   
                        $no_in = " and t1.t1_area_id not in (41)";
				  }elseif($areas_aplica_ot == 1){
					  $areas_aplica_ot = $areas_aplica_ot.",44";						                   
                        $no_in = " and t1.t1_area_id not in (44)";
				  }elseif($areas_aplica_ot == 31){
				  		$areas_aplica_ot = $areas_aplica_ot.",46";						                   
                        $no_in = " and t1.t1_area_id not in (46)";
				 }elseif($areas_aplica_ot == 13){
					   $areas_aplica_ot = $areas_aplica_ot.",47";						                   
                        $no_in = " and t1.t1_area_id not in (47)";
				  }elseif($areas_aplica_ot == 7){
					  	$areas_aplica_ot = $areas_aplica_ot.",48";						                   
                        $no_in = " and t1.t1_area_id not in (48)";
				  }elseif($areas_aplica_ot == 8){
					  	$areas_aplica_ot = $areas_aplica_ot.",49";						                   
                        $no_in = " and t1.t1_area_id not in (49)";
				  }elseif($areas_aplica_ot == 5){
				  		$areas_aplica_ot = $areas_aplica_ot.",55";						                   
                        $no_in = " and t1.t1_area_id not in (55)";
				  }elseif($areas_aplica_ot == 14){
				  		$areas_aplica_ot = $areas_aplica_ot.",50";						                   
                        $no_in = " and t1.t1_area_id not in (50)";
				  }elseif($areas_aplica_ot == 53){
				  		$areas_aplica_ot = $areas_aplica_ot.",60";						                   
                        $no_in = " and t1.t1_area_id not in (60)";
				  }else{
					  $areas_aplica_ot = $areas_aplica_ot.",".$areas_aplica_ot;						                   
                        $no_in = " and t1.t1_area_id not in (".$areas_aplica_ot.")";
					}
					


                        $sel_areas = query_db("select t1.t1_area_id,t1.nombre from $g12 as t1, t2_item_pecc as t2  where t1.t1_area_id = t2.t1_area_id and  t2.id_item_peec_aplica = ".$id_item_pecc." and t1.t1_area_id <> '".$sel_areas_contra_inicial[0]."' $no_in and t2.t1_tipo_proceso_id in (7, 12)	 group by t1.t1_area_id,t1.nombre");
                        while($sel_a_usuario = traer_fila_db($sel_areas)){
						
				  if( $sel_a_usuario[0] == 16){							
						$areas_aplica_ot = $areas_aplica_ot.",40,41,".$sel_a_usuario[0];
                  }elseif($sel_a_usuario[0] == 24){
 					    $areas_aplica_ot = $areas_aplica_ot.",34,".$sel_a_usuario[0];						                   
			  	  }elseif($sel_a_usuario[0] == 25 or $sel_a_usuario[0] == 20){
		   			   $areas_aplica_ot = $areas_aplica_ot.",35,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 22 or $sel_a_usuario[0] == 26 or $sel_a_usuario[0] == 32){
					  $areas_aplica_ot = $areas_aplica_ot.",36,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 6){
					  $areas_aplica_ot = $areas_aplica_ot.",37,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 21 or $sel_a_usuario[0] == 29){
					  $areas_aplica_ot = $areas_aplica_ot.",38,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 12){
				  		$areas_aplica_ot = $areas_aplica_ot.",39,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 17){
					  $areas_aplica_ot = $areas_aplica_ot.",40,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 18){
					  $areas_aplica_ot = $areas_aplica_ot.",41,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 1){
					  $areas_aplica_ot = $areas_aplica_ot.",44,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 31){
				  		$areas_aplica_ot = $areas_aplica_ot.",46,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 13){
					   $areas_aplica_ot = $areas_aplica_ot.",47,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 7){
					  	$areas_aplica_ot = $areas_aplica_ot.",48,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 8){
					  	$areas_aplica_ot = $areas_aplica_ot.",49,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 5){
					  	$areas_aplica_ot = $areas_aplica_ot.",55,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 14){
					  	$areas_aplica_ot = $areas_aplica_ot.",50,".$sel_a_usuario[0];						                   
				  }elseif($sel_a_usuario[0] == 53){
					  	$areas_aplica_ot = $areas_aplica_ot.",60,".$sel_a_usuario[0];						                   
				  }else{
					  $areas_aplica_ot = $areas_aplica_ot.",".$sel_a_usuario[0];
					}
					
							
                        }
						$imprime_prueba = $areas_aplica_ot;	
						
						
						if($es_admin_ot == "SI"){						
						$sel_areas_ot = query_db("select t1_area_id, nombre from t1_area where estado= 1 and (t1_area_id IN (".$areas_aplica_ot."))");
						}else{
							
							  $sel_areas_ot = query_db("select t1.t1_area_id, t1.nombre from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$_SESSION["id_us_session"]." and t1.estado = 1 and t1.t1_area_id in (".$areas_aplica_ot.")");
							  
							//$sel_areas_ot = query_db("select t1_area_id, nombre from t1_area where estado= 1 and (t1_area_id IN (".$areas_aplica_ot."))");
							}
							$si_no_tiene_areas = "<option value='0'>No Tiene Ninguna Area Relacionada para este contrato</option>";
						while($s_areas_ot = traer_fila_db($sel_areas_ot)){
							$si_no_tiene_areas ="";
							?> <option value="<?=$s_areas_ot[0]?>" <? if($s_areas_ot[0] == $sel_areas_contra_inicial[0]) echo 'selected="selected"'?> ><?=$s_areas_ot[1] ?></option><?
						}
						echo $si_no_tiene_areas;
						


                       


                    }
					 ?>
                    </select>
                    <?
					
//echo $imprime_prueba;
                    ?>




            </td>
        </tr>
        <tr>
            <td align="right"><?= $titulo_fecha ?><img src="../imagenes/botones/help.gif" alt="Seleccionar la fecha estimada en la cual requiere la solicitud." title="Seleccionar la fecha estimada en la cual requiere la solicitud.
                                                       " width="20" height="20" /></td>
            <td><input name="fecha" type="text" id="fecha" size="5" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha')"/></td>
        </tr>
        <tr>
            <td align="right">Proceso Especial o Anticipo, Requiere Aprobaci&oacute;n Extra del Comit&eacute;<img src="../imagenes/botones/help.gif" alt="Seleccione 'SI' si desea que este item vaya al comité" title="Seleccione 'SI' si desea que este item vaya al comit&eacute;" width="20" height="20" /></td>
            <td colspan="2"><select name="req_comite" id="req_comite">
                    <option value="2" >NO</option>
                    <option value="1" >SI</option>
                </select></td>
        </tr>
        <tr>
            <td align="right">Objeto del Contrato:</td>
            <td colspan="2">

                <textarea name="objeto_contrato" id="objeto_contrato" cols="25" rows="5"><? if($select_data_item[2]=="") echo $select_data_item[3]; else echo $select_data_item[2];?></textarea>


            </td>
        </tr>
        <tr>
            <td align="right"><? if ($valor == 8){ echo "Trabajo a Realizarse Mediante esta Orden de Trabajo"; $texto_ayuda = "El Contratista se obliga para con la Compa&ntilde;&iacute;a a  ejecutar bajo su exclusivo riesgo y como persona natural o jur&iacute;dica  independiente, con plena autonom&iacute;a administrativa, t&eacute;cnica y directiva y  utilizando sus propios medios, los servicios de ...";}else{ echo "Objeto de la Solicitud";}?><img src="../imagenes/botones/help.gif" alt="Actividad o servicio que se desea realizar a trav&eacute;s del contrato." title="Actividad o servicio que se desea realizar a trav&eacute;s del contrato." width="20" height="20" /></td>
            <td colspan="2"><textarea name="objeto_solicitud" id="objeto_solicitud" cols="25" rows="5"><?= $texto_ayuda ?></textarea></td>
        </tr>
        <? if($valor == 7) {?>
        <tr>
            <td align="right">Alcance<img src="../imagenes/botones/help.gif" alt="Ingresar un alcance detallado donde se indique el Área o áreas en las cuales se utilizará el contrato." title="Ingresar un alcance detallado donde se indique el Área o áreas en las cuales se utilizará el contrato." width="20" height="20" /></td>
            <td colspan="2"><textarea name="alcance" id="alcance" cols="25" rows="4"></textarea>

            </td>
        </tr>
        <?
        }else{
        ?>
        <input type="hidden" name="alcance" id="alcance" value="N/A" />
        <?
        }


        ?>
        <? if($valor == 8) {?>
        <tr>
          <td align="right">Justificaci&oacute;n<strong><img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicación: Razón por la cual se soporta la solicitud desde el punto de vista técnico
                                                                              " title="Estrategia: Prueba de la necesidad.  Adjudicación: Razón por la cual se soporta la solicitud desde el punto de vista técnico
                                                                              "  width="20" height="20" /></strong></td>
          <td colspan="2"><textarea name="justificacion" id="justificacion" cols="25" rows="4"></textarea></td>
        </tr>
         <? 
		   }else{
        ?>
        <input type="hidden" name="justificacion" id="justificacion" value="" />
        <?
        }

		if($valor == 7) {?>
        <tr>
            <td align="right">Justificaci&oacute;n T&eacute;cnica<strong><img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
                                                                              " title="Estrategia: Prueba de la necesidad.  Adjudicación: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
                                                                              "  width="20" height="20" /></strong></td>
            <td colspan="2"><textarea name="justificacion2" id="justificacion2" cols="25" rows="4"></textarea></td>
        </tr>
        <?
        $tex_titulo_justifi = " Comercial";
        }else{
        ?>
        <input type="hidden" name="justificacion2" id="justificacion2" value="N/A" />
        <?
        }
        ?>
        
        <input type="hidden" name="proveedores_sugeridos" id="proveedores_sugeridos" value="N/A" />
        
        <? if($valor == 7) {?>
        <tr>
            <td align="right">Criterios de Evaluacion<img src="../imagenes/botones/help.gif" alt="Valoración Técnico - Económico
                                                          " title="Valoración Técnico - Económico
                                                          " width="20" height="20" /></td>
            <td colspan="2"><textarea name="criterios_evaluacion" id="criterios_evaluacion" cols="25" rows="4"></textarea></td>
        </tr>
        <?
        }else{
        ?>
        <input type="hidden" name="criterios_evaluacion" id="criterios_evaluacion" value="N/A" />
        <?
        }
        ?>
        <tr>
            <td align="right">Recomendaci&oacute;n<img src="../imagenes/botones/help.gif" alt="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." title="Recomendaci&oacute;n sugerida para satisfacer la necesidad del solicitante." width="20" height="20" /></td>
            <td colspan="2"><textarea name="recomendacion" id="recomendacion" cols="25" rows="4"></textarea></td>
        </tr>
        <?
	$titulo4="Gesti&oacute;n de Entorno";
      $ayuda4="Foco en el desarrollo regional sostenible, alineando intereses de largo plazo. Vinculaci&oacute;n del entorno en los resultados. Operaci&oacute;n sana, limpia, segura y transparente.";
      
      $titulo5="Trazabilidad";// no tiene cambio
      $ayuda5="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones.";
      
      $titulo6="Transparencia";// no tiene cambio
      $ayuda6="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)";
      
      $titulo7="Agilidad";
      $ayuda7="Procesos simplificados y estandarizados. Personal integral y m&oacute;vil, seg&uacute;n los requerimientos del negocio. Oportunidad en adquisici&oacute;n de B&S.";
	?>
        <?
        if ($valor == 8){
        ?>
        <tr>
            <td align="right">Destino:</td>
            <td colspan="2"><input name="destino_orden_trabajo" type="text" id="destino_orden_trabajo" value="" size="25" maxlength="55" /></td>
        </tr>
        <?
			if($valor==8){ //si es ot de servicios se piden dos fechas => fecha inicio, fecha fin 
		?>
		<tr>
			<td align="right" ></td>
			<td align="left" colspan="3"><p><img src="../imagenes/botones/icono_ayuda.png"></img>&nbsp;<span style="color: #229BFF; font-family: roboto; font-size: 11pt; font-weight: 900;">Por favor diligenciar la fecha de finalizaci&oacute;n de los trabajos, recuerde que esta no <br />
			</span><span style="color: #229BFF; font-family: roboto; font-size: 11pt; font-weight: 900;">debe ser superior a la fecha de finalizaci&oacute;n del contrato</span></p></td>
		</tr>
        <tr>
            <td align="right">Fecha de Inicio de la OT<img src="../imagenes/botones/help.gif" alt="Seleccionar la fecha de inicio estimada de la ot." title="Seleccionar la fecha de inicio estimada de la ot." width="20" height="20" /></td>
            <td><input name="fecha_inicio_ot" type="text" id="fecha_inicio_ot" size="5" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha_inicio_ot')"/></td>
        </tr>
        <tr>
            <td align="right">Fecha de Finalizaci&oacute;n de la OT<img src="../imagenes/botones/help.gif" alt="Seleccionar la fecha de finalizaci&oacute;n estimada de la ot." title="Seleccionar la fecha de finalizaci&oacute;n estimada de la ot." width="20" height="20" /></td>
            <td><input name="fecha_fin_ot" type="text" id="fecha_fin_ot" size="5" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha_fin_ot')"/></td>
        </tr>
        <?
			}else{ //si no es ot sigue normal
		?>
        <tr>
            <td align="right">Duraci&oacute;n de la Orden de Trabajo:</td>
            <td colspan="2"><input name="duracion_orden_trabajo" type="text" id="duracion_orden_trabajo" value="" size="25" maxlength="55" /></td>
        </tr>
        <?
			}
		?>
        <input type="hidden" name="campos1" id="campos1" value=""/>
        <input type="hidden" name="campos2" id="campos2" value=""/>
        <input type="hidden" name="campos3" id="campos3" value=""/>
        <input type="hidden" name="campos4" id="campos4" value=""/>
        <input type="hidden" name="campos5" id="campos5" value=""/>
        <input type="hidden" name="campos6" id="campos6" value=""/>
        <input type="hidden" name="campos7" id="campos7" value=""/>
        <?
        }else{
        ?>
        <tr>
            <td colspan="3" align="right"><table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF"   class="tabla_lista_resultados">
              <tr>
                <td align="center"  class="fondo_3">Lineamientos Operador de Bajo Costo + R+S</td>
                <td align="center" class="fondo_3">Descripci&oacute;n</td>
              </tr>
              <?
      $edicion_datos="SI";
	  ?>
              <tr>
                <td width="31%" align="right">Bajo Costo <img src="../imagenes/botones/help.gif" alt="Estándares acordes a las necesidades del negocio que aseguren rentabilidad y excelencia operacional. Actividades justo lo necesario -fitforpurpose. Proceso de abastecimiento que obtiene el mayor valor posible del mercado." width="20" height="20" title="Estándares acordes a las necesidades del negocio que aseguren rentabilidad y excelencia operacional. Actividades justo lo necesario -fitforpurpose. Proceso de abastecimiento que obtiene el mayor valor posible del mercado." /></td>
                <td width="69%" align="left"><? if($edicion_datos=="SI") { ?>
                  <textarea name="campos1" id="campos1"><?=$p_oportunidad?></textarea>
                  <? } else {echo $p_oportunidad; }?></td>
              </tr>
              <tr>
                <td align="right">Capacidad T&eacute;cnica <img src="../imagenes/botones/help.gif" alt="Competencias integrales y aplicación de tecnologías conectadas con el negocio y fortalecidas a través de alianzas estratégicas. Información como recurso" width="20" height="20" title="Competencias integrales y aplicación de tecnologías conectadas con el negocio y fortalecidas a través de alianzas estratégicas. Información como recurso" /></td>
                <td align="left"><? if($edicion_datos=="SI") { ?>
                  <textarea name="campos3" id="campos3"><?=$p_calidad?></textarea>
                  <? } else echo $p_calidad; ?></td>
              </tr>
              <tr>
                <td align="right"><?=$titulo4?>
                  <img src="../imagenes/botones/help.gif" alt="<?=$ayuda4?>" width="20" height="20" title="<?=$ayuda4?>" /></td>
                <td align="left"><? if($edicion_datos=="SI") { ?>
                  <textarea name="campos4" id="campos4"><?=$p_optimizar?></textarea>
                  <? } else echo $p_optimizar; ?></td>
              </tr>
              <tr>
                <td align="right"><?=$titulo7?>
                  <img src="../imagenes/botones/help.gif" alt="<?=$ayuda7?>" width="20" height="20" title="<?=$ayuda7?>" /></td>
                <td align="left"><? if($edicion_datos=="SI") { ?>
                  <textarea name="campos7" id="campos7"><?=$p_sostenibilidad?></textarea>
                  <? } else echo $p_sostenibilidad; ?></td>
              </tr>
              <tr>
                <td align="right">&nbsp;</td>
                <td align="left">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <?
		}
		?>
        <tr>
            <td align="right">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td align="right">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" align="right">


            </td>
        </tr>
        <tr>
            <td colspan="3" align="right">
<table width="100%" border="0" class="tabla_lista_resultados">
      <tr >
        <td width="42%" align="right">&nbsp;</td>
        <td width="13%" align="center"><strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc_para_reporte=<?=$id_item_pecc?>&eq_moneda=1&fuera_de_reporte=si','carga_detalle_marcos')">Ver disponible en USD$</strong></td>
        <td width="19%" align="center"><strong  style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc_para_reporte=<?=$id_item_pecc?>&eq_moneda=2&fuera_de_reporte=si','carga_detalle_marcos')">Ver disponible en COP$</strong></td>
        <td width="26%" align="center"><strong onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/reportes/lista_reporte_saldos.php?id_contrato="+document.principal.id_contrato_para_reporte.value,"div_carga_busca_sol")' style="cursor:pointer">Ver Reporte de Contrato Marco Completo</strong></td>
      </tr>
      
    </table>
<div id="carga_detalle_marcos">
<?
$sel_tipo_moneda = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from t2_marco_temporal where id_item =".$id_item_pecc." and id_usuario = ".$_SESSION["id_us_session"]." "));

if($sel_tipo_moneda[0] > 0 and $sel_tipo_moneda[1]>0){
	$eq_moneda = 1;
	}elseif($sel_tipo_moneda[0] > 0){
		$eq_moneda = 1;
		}elseif($sel_tipo_moneda[1] > 0){
			$eq_moneda = 2;		
			}else{
				$eq_moneda = 1;
				}
				$_GET["oculta_session_include"] = "si";
				$_GET["fuera_de_reporte"] = "si";
				$_GET["id_item_pecc_para_reporte"] = $id_item_pecc;
				include('../../aplicaciones/reportes/detalle_reporte_saldos_disponible.php');
?>

                
                </div>
                <table width="100%"> <tr><td align="right"><? if($id_item_pecc == 2984) {?><strong><a href="../imagenes/adicional_documentos/Presupuesto contrato C15-0004 - Antek.xlsx" target="grp">Ver el disponible del contrato C15-0004 por lineas</a></strong><? }?></td></tr></table>
                
          </td>
        </tr>
        <tr>
            <td colspan="3" align="right"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
                    <tr>
                        <td colspan="6" align="center"  class="fondo_3"><?= $titulo_presupuesto ?> <img src="../imagenes/botones/help.gif" alt="Ingresar el monto estimado por Contrato, A&ntilde;o y &Aacute;rea, requerido para la solicitud." title="Ingresar el monto estimado por Contrato, A&ntilde;o y &Aacute;rea, requerido para la solicitud." width="20" height="20" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right">&nbsp;</td>
                      <td align="left"><strong class='letra-descuentos'>El valor debe ser incluido &uacute;nicamente en la moneda de pago</strong> <img src='../imagenes/botones/aler-interro.gif' width='5'/></td>
                      <td width="9%" rowspan="6"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar" onclick="graba_presupuesto_nuevo()" /></td>
                    </tr>
                    <tr>
                        <td width="20%">
                            <div id="aplica_contra_div">
                            
                            <?
							
							?>
                                <select name="aplica_contrato" id="aplica_contrato" onchange="carga_contratos_sin_valores(this.value,<?= $id_item_pecc ?>)" >
                                    <option value="">Selecci&oacute;n de Contratos</option>

                                    <?
                                    if($id_tipo_proceso_pecc == 2){
                                    ?>
                                    <option value="0">Uno &oacute; Varios SIN Valores Especificos</option>

                                    <?
                                    }
									 if($id_tipo_proceso_pecc == 3){
										 $comple_sql = " and (tipo_bien_servicio <> 'Bienes' or tipo_bien_servicio is null)";
										 }
									
                                    $sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc." and t1_tipo_documento_id = 2 $comple_sql");
                                    while($sel_cont = traer_fila_db($sele_contratos)){
                                    $numero_contrato1 = "C";

                                    $separa_fecha_crea = explode("-",$sel_cont[2]);
                                    $ano_contra = $separa_fecha_crea[0];

                                    $numero_contrato2 = substr($ano_contra,2,2);
                                    $numero_contrato3 = $sel_cont[1];
                                    $numero_contrato4 = $sel_cont[3];


                                    $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, contratista, vigencia_mes,analista_deloitte from $co1 where id = ".$sel_cont[0]));

                                    $mustra_contrato = "SI";
                                    $fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
                                    if($sel_contrato[4] < $fecha_hoy or $sel_contrato[5] == 1){// si el contrato esta vencido
                                    $mustra_contrato = "NO";
                                    }

                                    if($mustra_contrato == "SI"){
                                    ?>
                                    <option value="<?= $sel_cont[0] ?>"><?= numero_item_pecc_contrato($numero_contrato1, $numero_contrato2, $numero_contrato3, $numero_contrato4, $sel_cont[0]) ?></option>
                                    <?
                                    }
                                    }
                                    ?>
                                </select>

                            </div>
                        </td>
                        <td width="12%" align="center">

                            <select name="ano" id="ano">

                                <option value="0">A&Ntilde;O</option>
                            

                                <?=anos_presupuesto();?>
                            </select>

                        </td>
                        <td width="16%"><select name="campo" id="campo">
                                <option value="">&Aacute;rea</option>
                                <?= listas_sin_seleccione($g15, " estado = 1 ", 0, 'nombre', 2); ?>
                            </select></td>
                        <td width="16%" align="right">Valor USD$:</td>
                        <td width="27%"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this, this.value.charAt(this.value.length - 1))"/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
                        <td><div id="resetea_presus"><input name="adj_presupuesto" type="file" id="adj_presupuesto" size="5" /></div></td>
                        <td align="right">Valor COP$:<input type="hidden" name="cargo_cota_presu" id="cargo_cota_presu" /></td>
                        <td><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this, this.value.charAt(this.value.length - 1))"/></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="right">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right">&nbsp;</td>
                      <td></td>
                    </tr>

                    <?
                    if($id_tipo_proceso_pecc ==3){
                    ?>
                    <tr>
                      <!--<td align="right">Seleccione la Solicitud a la Cual Aplica:</td>-->
                        <td align="right">N&uacute;mero de la solicitud que gener&oacute; el contrato:</td>
                        <td colspan="4" align="left">
                            <?

                            if($id_item_pecc_marco==312 ){
                            $sl_com="or t2_item_pecc.id_item_peec_aplica = 350";
                            }

                            $sel_sql = "select t2_item_pecc.id_item, t2_item_pecc.num1, t2_item_pecc.num2, t2_item_pecc.num3, t2_item_pecc.objeto_solicitud,t1_trm.valor  from t2_item_pecc, t1_trm where (t2_item_pecc.id_item_peec_aplica = ".$id_item_pecc." $sl_com) and t2_item_pecc.t1_tipo_proceso_id in (7, 12) and (t2_item_pecc.estado >=18 and t2_item_pecc.estado <> 31 and t2_item_pecc.estado <> 33 and t2_item_pecc.estado <> 34)  and t2_item_pecc.t1_trm_id = t1_trm.id_trm";
                            ?>

                            <select name="solicitud_aplica_ots" id="solicitud_aplica_ots">
                            	<option value="">Seleccione la solicitud a la cual desea cargar la Orden de Trabajo</option>
                                <?
                                $valor_eq_ot=0;
								$valor_eq=0;
                                $sel_valor_sol = query_db("select SUM(valor_usd), SUM(valor_cop), ano from t2_presupuesto where t2_item_pecc_id = ".$sel_item[0]." and permiso_o_adjudica = 2 and ano >= 2016 group by ano");	
								while($sel_val = traer_fila_db($sel_valor_sol)){
									$valor_eq = $valor_eq + $sel_val[0] + ($sel_val[1] / trm_presupuestal($sel_val[2]));
									}
									
									 $sel_valor_ot = query_db("select SUM(valor_usd), SUM(valor_cop), ano from t2_presupuesto, t2_item_pecc as t2 
where t2.id_item = t2_presupuesto.t2_item_pecc_id and t2.id_item_peec_aplica = ".$sel_item[0]." and t2.estado <> 33 and id_item_ots_aplica = 0 and permiso_o_adjudica = 1 
and ano >= 2017 and t1_tipo_proceso_id = 8  group by ano");	
								while($sel_ot = traer_fila_db($sel_valor_ot)){
									$valor_eq_ot = $valor_eq_ot + $sel_ot[0] + ($sel_ot[1] / trm_presupuestal($sel_ot[2]));
									}
									
if($valor_eq - $valor_eq_ot > 0){
			
                                ?>
                                <option value="0"><?=numero_item_pecc($sel_item[16], $sel_item[17], $sel_item[18]); ?> - Valor Aprobado Eq USD$: <?= number_format($valor_eq, 0) ?>, Valor En OTs Eq USD$ <?= number_format($valor_eq_ot, 0) ?> </option>
                                <?
}
                                $sel_ampliaciones = query_db($sel_sql);
                                while($sel_apl = traer_fila_db($sel_ampliaciones)){
								
								$valor_eq_ot=0;
								$valor_eq=0;
                                $sel_valor_sol = query_db("select SUM(valor_usd), SUM(valor_cop), ano from t2_presupuesto where t2_item_pecc_id = ".$sel_apl[0]." and permiso_o_adjudica = 1 and ano >= 2017 group by ano");	
								while($sel_val = traer_fila_db($sel_valor_sol)){
									$valor_eq = $valor_eq + $sel_val[0] + ($sel_val[1] / trm_presupuestal($sel_val[2]));
									}
									
                                $sel_valor_ot = query_db("select SUM(valor_usd), SUM(valor_cop), ano from t2_presupuesto, t2_item_pecc as t2 
where t2.id_item = t2_presupuesto.t2_item_pecc_id and t2.estado <> 33 and id_item_ots_aplica = ".$sel_apl[0]." and permiso_o_adjudica = 1 and ano >= 2017  group by ano");	
								while($sel_ot = traer_fila_db($sel_valor_ot)){
									$valor_eq_ot = $valor_eq_ot + $sel_ot[0] + ($sel_ot[1] / trm_presupuestal($sel_ot[2]));
									}

if($valor_eq - $valor_eq_ot > 0){
                                ?>
           <option value="<?= $sel_apl[0] ?>" <? if($_GET["id_item_ampliacion"] == $sel_apl[0]) echo 'selected="selected"'?> ><?= numero_item_pecc($sel_apl[1], $sel_apl[2], $sel_apl[3]) ?> - Valor Aprobado Eq USD$: <?= number_format($valor_eq, 0) ?>, Valor En OTs Eq USD$ <?= number_format($valor_eq_ot, 0) ?></option>
                                <?
                                }
							}
                                ?>
                            </select>

                        </td>
                    </tr>

                    <?
                    }else{
                    ?><input type="hidden" name="solicitud_aplica_ots" id="solicitud_aplica_ots" value="0" /><?
                    }
                    ?>
                    <tr>
                        <td colspan="4" align="right"><div id="carga_contratos_aplica"></div></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
              <div id="carga_presupuesto"><input type="hidden" name="valor_total_js_valida" id="valor_total_js_valida" value="0" /></div>
            </td>
        </tr>
        <tr>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" align="right"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
                    <tr>
                        <td colspan="2" align="center" class="fondo_3">Agregar Anexos <img src="../imagenes/botones/help.gif" alt="Adjuntar archivos o documentos requeridos para soportar o informar en esta solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)." width="20" height="20" title="Adjuntar archivos o documentos requeridos para soportar o informar en esta solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" /></td>
                        <td width="54%" valign="top"></td>
                    </tr>
                    <tr>
                        <td width="21%" align="right">Detalle del Anexo:</td>
                        <td width="25%" align="left"><textarea name="anexo" cols="25" id="anexo"></textarea></td>
                        <td width="54%" rowspan="3" valign="top"><div id="carga_anexos"></div></td>
                    </tr>
                    <tr>
                        <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
                        <td align="left"><input name="adj_anexo" type="file" id="adj_anexo" size="5" /></td>
                    </tr>
                    <tr>
                        <td align="right">&nbsp;</td>
                        <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onclick="graba_anexo(8)" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td width="54%" valign="top">&nbsp;</td>
                    </tr>
                </table></td>
        </tr>
        <tr  style="display:none">
            <td colspan="3" align="right"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
                    <tr>
                        <td align="center" class="fondo_3">Agregar Antecedentes <img src="../imagenes/botones/help.gif" alt="Adjuntar archivos o documentos requeridos para soportar o informar en esta solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" width="20" height="20" title="Adjuntar archivos o documentos requeridos para soportar o informar en esta solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" /></td>
                        <td width="54%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
                                <tr>
                                    <td width="21%" align="right">Detalle del Antecedente:</td>
                                    <td width="25%" align="left"><textarea name="ancedente" cols="25" rows="5" id="ancedente"></textarea></td>
                                </tr>
                                <tr>
                                    <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
                                    <td align="left"><input name="adj_antecedente" type="file" id="adj_antecedente" size="5" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="center"><input name="button3" type="button" class="boton_grabar" id="button3" value="Agregar Antecedente"  onclick="graba_anexo(9)"/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table></td>
                        <td valign="top">



                            <div id="carga_antecedentes"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right" valign="top"><?

                            $id_contrato_carr = $id_item_pecc;
                            if($id_tipo_proceso_pecc == 3 or $id_tipo_proceso_pecc == 2){
                            $solicitudes_antecedentes = 0;

                            $sele_otros_si = query_db("select id_item from $pi2 where id_item_peec_aplica = ".$id_item_pecc);
                            while($sel_item_otros = traer_fila_db($sele_otros_si)){
                            $solicitudes_antecedentes = $solicitudes_antecedentes.", ".$sel_item_otros[0];
                            }

                            $solicitudes_antecedentes = $solicitudes_antecedentes.", ".$id_item_pecc;
                            ?>
                            <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
                                <tr>
                                    <td colspan="3" align="center"  class="fondo_3">Antecedentes de Otras Solicitudes Relacionadas</td>
                                </tr>
                                <tr>
                                    <td width="16%" align="center" class="fondo_3">No.</td>
                                    <td width="57%" align="center" class="fondo_3">Detalle</td>
                                    <td width="27%" align="center" class="fondo_3">Archivo Adjunto</td>
                                </tr>
                                <?
                                $cont = 0;
                                $clase="";
                                $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id in (".$solicitudes_antecedentes.") and estado = 1 and tipo = 'antecedente' order by t2_anexo_id desc");
                                while($sl_anexos = traer_fila_db($sele_anexos)){

                                $sel_numero_item = traer_fila_row(query_db("select num1,num2,num3 from $pi2 where id_item = ".$sl_anexos[1]));

                                if($cont == 0){
                                $clase= "filas_resultados";
                                $cont = 1;
                                }else{
                                $clase= "";
                                $cont = 0;
                                }
                                ?>
                                <tr class="<?= $clase ?>">
                                    <td align="center" ><?= numero_item_pecc($sel_numero_item[0], $sel_numero_item[1], $sel_numero_item[2]) ?></td>
                                    <td align="center" ><?= $sl_anexos[4] ?></td>
                                    <td align="center" ><? if($sl_anexos[5] != " "){?>
                                        <?= saca_nombre_anexo($sl_anexos[5]) ?>
                                        <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?= $sl_anexos[5] ?>&amp;n1=<?= $sl_anexos[0] ?>&amp;n3=2" target="grp"> <img src="../imagenes/mime/<?= saca_extencion_archivo($sl_anexos[5]) ?>.gif" width="16" height="16" /> </a>
                                        <?
                                        }
                                        ?></td>
                                </tr>
                                <?
                                }
                                ?>
                            </table>
                            <?
                            }
                            ?></td>
                    </tr>
                </table></td>
        </tr>
        <?
        if($sel_usu_emulan[0] > 0){
        $testos = "Temporalmente - Debera ponerse en contacto con el gerente del contrato para ponerlo en firme";
        }else{
        $testos = "temporalmente";
        }
        ?>
        <tr>
            <td colspan="2" align="right"><input name="button" type="button" class="boton_grabar" id="button" value="Grabar este proceso en <?= $sel_pecc[5] ?> - <?= $testos ?>" onclick="valida_graba_item(1)" /></td>
            <td>

                <?    if($sel_usu_emulan[0] == 0 and $id_tipo_proceso_pecc == "no mostrar nunca para activar poner solo '2'"){?>
                <select name="conflito_intere_sel" id="conflito_intere_sel">
      <option value="0">Seleccione si tiene conflicto de intereses</option>
      <option value="1">SI tiene conflicto de intereses</option>
      <option value="2">NO tiene conflicto de intereses</option>
    </select>
                <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar este proceso en <?= $sel_pecc[5] ?> y poner en firme" onclick="valida_graba_item(2)"/>
                <?
                }
                ?>

            </td>
        </tr>
    </table>

<input type="hidden" name="aleatorio" id="aleatorio" value="<?= $aleatorio ?>" />
    <input type="hidden" name="id_pecc" id="id_pecc" value="<?= $id_pecc ?>" />
    <input type="hidden" name="tipo_anexo" id="tipo_anexo" />
    <input type="hidden" name="tipo_graba" id="tipo_graba" />
    <input type="hidden" name="id_trm_aplica" id="id_trm_aplica" value="<?= $sel_pecc[6] ?>" />
    <input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?= $id_item_pecc ?>" />
    <input type="hidden" name="id_item_pecc_real" id="id_item_pecc_real" value="0" />
    <input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?= $id_tipo_proceso_pecc ?>" />
    <input type="hidden" name="id_presupuesto_elimina" id="id_presupuesto_elimina" value="" />
    <input type="hidden" name="id_anexo_elimina" id="id_anexo_elimina" value="" />
    <input type="hidden" name="id_tipo_contratacion" id="id_tipo_contratacion" value="1" />
    <input type="hidden" name="es_admin_ot" id="es_admin_ot" value="<?=$es_admin_ot?>" />
    <input type="hidden" name="id_contrato_para_reporte" value="<?=$id_contrato_para_reporte?>"/>
    
</body>
</html>
