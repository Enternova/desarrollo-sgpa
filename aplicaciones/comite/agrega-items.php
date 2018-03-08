<? include("../../librerias/lib/@session.php"); 
verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
$id_comite = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));


$sele_comite = traer_fila_row(query_db("select * from $c1 where id_comite = ".$id_comite.""));

$edicion_datos_generales = "NO";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
<tr>
<td valign="top"><?=encabezado_comite($id_comite)?>

</td>
</tr>
<tr>
<td valign="top">
<?
$sel_item_con_este_comite = traer_fila_row(query_db("SELECT count(*) from $vcomite2 where id_comite = ".$id_comite." and estado <> 3 "));
if($sele_comite[10] <> 2){
if($sel_item_con_este_comite[0]>0){
?>

<img src="../imagenes/botones/aviso_observaciones.png" width="16" height="16" /> Para que se apruebe automaticamente el comit&eacute; debe indicar que ya no va ha agregar mas solicitudes <input name="xxx" type="button" value="Ya no voy a Agregar Mas Solicitudes" class="boton_grabar" onclick="edita_comtite_agrega_item(2)" />

<?
}
?>
</td>
</tr>
<tr>
<td valign="top">

<!-- Formulario Buscador de solicitudes -->
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<tr>
<td width="13%" align="right">N&uacute;mero de la Solicitud:</td>
<td width="6%" >
<? $_SESSION['numero1_peccs'] = $_GET["numero1_pecc"]?>       
<select name="numero1_pecc" id="numero1_pecc">
<option value="0" <? if($_GET["numero1_pecc"] == 0) echo "selected='selected'";?>>Todos</option>
<option value="S" <? if($_GET["numero1_pecc"] == "S") echo "selected='selected'";?>>S</option>
<option value="B" <? if($_GET["numero1_pecc"] == "B") echo "selected='selected'";?>>B</option>
   </select>
</td>
<td width="10%">
<? $_SESSION['numero2_peccs'] = $_GET["numero2_pecc"]?>     
<select name="numero2_pecc" id="numero2_pecc">
<option value="0" <? if($_GET["numero2_pecc"] == 0) echo "selected='selected'";?>> Todos</option>
<option value="13" <? if($_GET["numero2_pecc"] == 13) echo "selected='selected'";?>> 13</option>
<option value="14" <? if($_GET["numero2_pecc"] == 14) echo "selected='selected'";?>> 14</option>
<option value="99" <? if($_GET["numero2_pecc"] == 99) echo "selected='selected'";?>> En Preparaci&oacute;n</option>
</select>
</td>
<td width="13%">
<? $_SESSION['numero3_peccs'] = $_GET["numero3_pecc"]?>
<input name="numero3_pecc" type="text" id="numero3_pecc" size="5" maxlength="4" value="<?= $_GET["numero3_pecc"] ?>" />
</td>
</tr>
<tr>
                        <td align="right">Objeto de la Solicitud:</td>
                        <td colspan="3">
                            <? $_SESSION['bus_text5s'] = $_GET["bus_text5"]?>         
                            <textarea name="bus_text5" id="bus_text5" cols="25" rows="2"><?= $_GET["bus_text5"] ?></textarea></td>
                    </tr>
<tr>
  <td align="right">Tipo ( Permiso / Adjudicaci&oacute;n):</td>
  <td colspan="3"><select name="tipo_permiso" id="tipo_permiso">
    <option value="0" <? if($_GET["tipo_permiso"] == 0) echo "selected='selected'";?>>Todos</option>
    <option value="1" <? if($_GET["tipo_permiso"] == "1") echo "selected='selected'";?>>Permiso</option>
    <option value="2" <? if($_GET["tipo_permiso"] == "2") echo "selected='selected'";?>>Adjudicacion</option>
  </select></td>
</tr>
<tr>
  <td align="right">Profesional / Comprador:</td>
  <td colspan="3"><select name="us_prof" id="us_prof">
            <option value="0">Todos</option>
            <?
          $sel_profss = query_db("select us_id, nombre_administrador from $v_seg1 where id_premiso = 8 and us_id != 32  group by us_id, nombre_administrador");
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
            <option value="<?=$se_prof[0]?>" <? if( $_GET["us_prof"] ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$se_prof[1]?></option>
            <?
		  }
		  ?>
            </select></td>
</tr>
<tr>
  <td align="right">Solicitante:</td>
  <td colspan="3"><input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?=$_GET["usuario_permiso"]?>"/></td>
</tr>
<tr>
  <td align="right">Area Usuaria:</td>
  <td colspan="3"><select name="area_usuaria" id="area_usuaria">
  <option value="0">Todos</option>
          <?
		  
		 	  
	        $sel_areas = query_db("select * from $g12 where estado = 1 ");
	  while($sel_a_usuario = traer_fila_db($sel_areas)){
	  ?>
      <option value="<?=$sel_a_usuario[0]?>" <? if($_GET["area_usuaria"] == $sel_a_usuario[0]) echo 'selected="selected"'?> ><?=$sel_a_usuario[1]?></option>
      <?
      }
	  

	  ?>
        </select></td>
</tr>
<tr>
  <td align="right">Tipo de Proceso:</td>
  <td colspan="3"><select name="tipo_proceso" id="tipo_proceso" >
            <?

			echo listas($g13, " estado = 1 ",$_GET["tipo_proceso"] ,'nombre', 1);	
			?>
            
            
           
          </select></td>
</tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">&nbsp;</td>
                    <td align="center"><input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/comite/agrega-items.php?tipo_ajax=1&amp;id_comite=<?= $id_comite ?>&amp;id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&amp;numero1_pecc=' + document.principal.numero1_pecc.value + '&amp;numero2_pecc=' + document.principal.numero2_pecc.value + '&amp;numero3_pecc=' + document.principal.numero3_pecc.value + '&amp;bus_text5=' + document.principal.bus_text5.value+'&tipo_permiso=' + document.principal.tipo_permiso.value+'&tipo_proceso=' + document.principal.tipo_proceso.value+'&us_prof=' + document.principal.us_prof.value+'&usuario_permiso=' + document.principal.usuario_permiso.value+'&area_usuaria=' + document.principal.area_usuaria.value, 'contenidos')" /></td>
                        <td align="center">&nbsp;</td>
                        <td align="right">
                        
                        <strong style="cursor:pointer" onclick="agregar_comite_todos()">Agregar todas las solicitudes al comite<img src="../imagenes/botones/chulo.jpg" alt="" width="23" height="20"/></strong></td>

                    </tr>
                </table>
                <!-- Fin Buscador de solicitudes-->

  <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                    <tr>
                        <td colspan="7" align="center"  class="fondo_3">Lista de las Solicitudes NO Agendados a Ningun Comit&eacute;</td>
                    </tr>
                    <tr >
                        <td width="10%" align="center" class="fondo_3">N&uacute;mero de la Solicitud</td>
                        <td width="12%" align="center" class="fondo_3">Tipo de Proceso</td>
                        <td width="35%" align="center" class="fondo_3">Objeto Solicitud</td>
                        <td width="12%" align="center" class="fondo_3">Valor Origen COP$</td>
                        <td width="12%" align="center" class="fondo_3">Valor Origen USD$</td>
                        <td width="11%" align="center" class="fondo_3">Fecha de la Ultima Firma</td>
                        <td width="9%" align="center" class="fondo_3">Agregar a este Comi&eacute;</td>
                    </tr>
                    <?

                    /* Parametros busqueda*/
                    $numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
                    $numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
                    $numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
                    $bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);					
					$tipo_permiso = arreglo_recibe_variables($_GET["tipo_permiso"]);
					$tipo_proceso = arreglo_recibe_variables($_GET["tipo_proceso"]);
					
					$area_usuaria = arreglo_recibe_variables($_GET["area_usuaria"]);
					$explode = explode("----,",$_GET["usuario_permiso"]);
					$id_usuario_solicit = $explode[1];
					$us_prof = arreglo_recibe_variables($_GET["us_prof"]);
					
					
                    $completar_filtros = "";

                    if($numero1_pecc != "0" and $numero1_pecc != ""){
                    $completar_filtros.=" and num1 = '".$numero1_pecc."'";
                    }
                    if($numero2_pecc != "" and $numero2_pecc != 0){
                    if($numero2_pecc == 99){
                    $completar_filtros.=" and (num2 = '' or num2 = ' ' or num2 is NULL)";		
                    }else{
                    $completar_filtros.=" and num2 like '%".$numero2_pecc."%'";
                    }
                    }
                    if($numero3_pecc != "" and $numero2_pecc != 99){
                    $completar_filtros.=" and num3 = '".$numero3_pecc."'";
                    }
                    if($bus_text5 != ""){
                    //$completar_filtros.=" and (objeto_solicitud like '%".$bus_text5."%' or ob_solicitud_adjudica like '%".$bus_text5."%')";
                    $completar_filtros.=" and (objeto_solicitud like '%".$bus_text5."%')";
                    }
                    /* Fin Parametros busqueda*/
					
					
					if($tipo_proceso != "0" and $tipo_proceso != ""){
                    $completar_filtros.=" and t1_tipo_proceso_id = '".$tipo_proceso."'";
                    }
					
					if($area_usuaria != "0" and $area_usuaria != ""){
                    $completar_filtros.=" and t1_area_id = '".$area_usuaria."'";
                    }
					if($id_usuario_solicit != "0" and $id_usuario_solicit != ""){
                    $completar_filtros.=" and solicitante = '".$id_usuario_solicit."'";
                    }
					if($us_prof != "0" and $us_prof != ""){
                    $completar_filtros.=" and id_us_profesional_asignado = '".$us_prof."'";
                    }
					

                    $sel_item_sin_comite = query_db("SELECT * from $vcomite1 where (congelado = 2 or congelado is null or congelado = 0) $completar_filtros order by fecha_ultima_firma asc");

                    while($sel_sin_comi = traer_fila_db($sel_item_sin_comite)){
                    $sel_item = traer_fila_row(query_db("select id_item,objeto_solicitud, estado, t1_tipo_proceso_id, ob_solicitud_adjudica, contrato_id, es_modificacion from $pi2 where id_item=".$sel_sin_comi[0]));
				
					
				
                    $sele_nivel_anterior = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3  where id_item=".$sel_item[0]." and actividad_estado_id < 7 and  estado = 1"));	
                    $sele_datos_actividad = traer_fila_row(query_db("select fecha_real from $vpeec3  where id_item=".$sel_item[0]." and actividad_estado_id = ".$sele_nivel_anterior[0]." and  estado = 1"));

                    $select_si_ya_esta = traer_fila_row(query_db("select count(*) from t3_comite_relacion_item where id_comite = ".$id_comite." and  id_item = ".$sel_sin_comi[0]));
					$select_si_ya_esta_en_otro_comite = traer_fila_row(query_db("select count(*) from t3_comite_relacion_item as t1, t3_comite as t2 where t1.id_item = ".$sel_sin_comi[0]." and t1.id_comite = t2.id_comite and t2.estado <> 1 "));

                    if($select_si_ya_esta[0]==0 and $select_si_ya_esta_en_otro_comite[0]==0)
                    {

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

						
						
$muestra_fila=1;

if($muestra_fila == 1){
                    ?>
                    <tr>
                        <td align="center">	
                            <strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?= $sel_item[0] ?>&id_tipo_proceso_pecc=<?= $id_tipo_proceso_pecc ?>&permiso_o_adjudica=<?= $permiso_o_adjudica ?>')" style="cursor:pointer"><?= numero_item_pecc($sel_sin_comi[3], $sel_sin_comi[4], $sel_sin_comi[5]) ?> Detalle</strong>

                        </td>
                        <td align="center"><? 
						if($sel_item[6]==1){ echo "Modificacion";} else{
								echo saca_nombre_lista($g13,$sel_item[3],'nombre','t1_tipo_proceso_id',$sel_item[0]);
								}
								
								?></td>

                        <td align="center"><? if($sel_item[4] != "") echo $sel_item[4]; else echo $sel_item[1]; ?></td>
                        <td align="center"><?= number_format($valor_solicitud[1], 0) ?></td>

                        <td align="center"><?= number_format($valor_solicitud[0], 0) ?></td>
                        <td align="center">
                        <?
						
						echo $sel_sin_comi[14];
                        ?>
                        </td>
                        <td align="center">
                        <?
       /*saca contrato si aplica para saber si esta vencido*/
	$alerta_contrato_vencido="";
	if($sel_item[3] == 4 or $sel_item[3] == 5){

		
		$sel_contrato = traer_fila_row(query_db("select vigencia_mes from t7_contratos_contrato where id=".$sel_item[5]));
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
	
	if($alerta_contrato_vencido != ""){
		echo $alerta_contrato_vencido;
		}else{
						?>
                            <img src="../imagenes/botones/chulo.jpg" width="23" height="20" 
                                 onclick="agregar_comite(<?= $id_comite ?>,<?= $sel_item[0] ?>);
                                    this.onclick = ''" />
                            <?php 
		}
                            $comite_comentario = traer_fila_row(query_db("select * from $c5 where id_item = $sel_item[0]"));
                            if($comite_comentario){
                            ?>
                            <strong align="center" onClick='window.parent.document.getElementById("div_carga_busca_sol").style.display = "block";
                                    ajax_carga("../aplicaciones/comite/pecc/comite-comentarios.php?id_item_pecc=<?= $sel_item[0] ?>&id_comite=<?= $id_comite ?>", "div_carga_busca_sol")'>
                                <img src="../imagenes/mime/rtf.gif" width="20" height="20"/>
                            </strong>
                            <?php }?>
                        </td>
                    </tr>
                    <?
}//fin si muestra fila
                    }
                    }
                    ?>
                </table>
                <?
                }else{
                ?>
<input name="xxx" type="button" value="Agregar Mas Solicitudes" class="boton_grabar" onclick="edita_comtite_agrega_item(1)"/>
                <?
                }
                ?>
            </td>
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
    <input type="hidden" name="id_item_agrega" id="id_item_agrega" />
    <input type="hidden" name="agregar_mas_items" id="agregar_mas_items" />

</body>
</html>
