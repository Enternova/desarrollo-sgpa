<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	
	 $sel_si_tiene_modificacion = traer_fila_row(query_db("select id, id_item, estado_quedara, us_aprueba1, CAST(observacion1 AS text), aprobacion1, us_aprueba2, CAST(observacion2 AS text), aprobacion2, us_aprueba3, CAST(observacion3 AS text),  aprobacion3, CAST(detalle_modificacion AS TEXT), solicitante, pecc, si_observacion_comite, CAST(observacion_comite AS text) from t2_verificacion_modificacion_manual where id_item =".$id_item_pecc));
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="76%" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      
      <tr>
        <td width="54%" valign="top">
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td height="43" colspan="3" align="center"  class="fondo_3">Aprobaciones para publicar la solicitud despues de realizar el ajuste manual</td>
              </tr>
        <?
        if($id_tipo_proceso_pecc <> 3){
		?>
         <?
		 }else{
        ?>
         
         <input type="hidden" name="usuario_permiso" id="usuario_permiso" value="<?=$gerente_contrato ?>"/>
         
         <?
		 }
         
		 ?>
            <tr class="<?=$clase?>">
              <td colspan="3" align="left"><strong class="letra-descuentos">ATENCION:</strong> Toda la Informaci&oacute;n relacionada en esta solicitud es suministrada por el profesional de Abastecimiento / Compras</td>
              </tr>
            <tr class="<?=$clase?>">
              <td align="right" >&nbsp;</td>
              <td colspan="2" align="left" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" ><strong>Estado en el que quedar&aacute; la solicitud despues de la validaci&oacute;n:</strong></td>
              <td colspan="2" align="left" ><?=saca_nombre_lista("t2_nivel_servicio_actividades",$sel_si_tiene_modificacion[2],'nombre','id');?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td width="50%" align="right" ><p>Justificaci&oacute;n de la modificaci&oacute;n manual :</p></td>
              <td colspan="2" align="left" ><?=$sel_si_tiene_modificacion[12]?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >Solicitante del cargue manual</td>
              <td colspan="2" align="left" ><?=saca_nombre_lista($g1,$sel_si_tiene_modificacion[13],'nombre_administrador','us_id');?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >&nbsp;</td>
              <td colspan="2" align="left" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >Verificador de toda la informaci&oacute;n:</td>
              <td colspan="2" align="left" ><?=saca_nombre_lista($g1,$sel_si_tiene_modificacion[3],'nombre_administrador','us_id');?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >Observaci&oacute;n del Verificador:</td>
              <td colspan="2" align="left" ><? if($sel_si_tiene_modificacion[3] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[5]=='') {?><textarea name="ob_aproba_1" id="ob_aproba_1"></textarea><? }else{ echo $sel_si_tiene_modificacion[4];} ?></td>
            </tr>
            
             <? if($sel_si_tiene_modificacion[14] == 1) {//si es una carga masiva de PECC?> 
          
            <tr class="<?=$clase?>">
              <td align="right" > El comit&eacute; realizo observaci&oacute;n:</td>
              <td colspan="2" align="left" >
              <? if($sel_si_tiene_modificacion[3] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[5]=='') {?>
              <select name="si_observacion_comite" id="si_observacion_comite" onchange="activa_filas_modifiaciones_xx(this.value)">
                                              <option value="0" >Seleccione</option>
                                              <option value="2" <? if($sel_si_tiene_modificacion[15] == 2) echo 'selected="selected"'?>>NO</option>
                                              <option value="1" <? if($sel_si_tiene_modificacion[15] == 1) echo 'selected="selected"'?>>SI</option>
                                            </select>
                                            <? } else{ if($sel_si_tiene_modificacion[15] == 1) echo "SI"; if($sel_si_tiene_modificacion[15] == 2) echo "NO"; }?>
              </td>
            </tr>
            <?
             $oculta_ob_xx= 'style="display:none"';
  			if($sel_si_tiene_modificacion[15] == 1	 ){//aplica PECC
				$oculta_ob_xx= '';
			}
			?>
            <tr class="<?=$clase?>" <?=$oculta_ob_xx?> id="textoxx">
              <td align="right"  >Observaci&oacute;n del Comit&eacute;:</td>
              <td colspan="2" align="left" > 
             <? if($sel_si_tiene_modificacion[3] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[5]=='') {?> <textarea name="observacion_comite" id="observacion_comite" cols="45" rows="5"><?=$sel_si_tiene_modificacion[16]?></textarea><? }else{ echo $sel_si_tiene_modificacion[16]; }?></td>
              </tr>
              <?
		  }
			  ?>
            <tr class="<?=$clase?>">
              <td align="right" >Aprobado o Rechazado:</td>
              <td width="18%" align="left" ><? if($sel_si_tiene_modificacion[3] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[5]=='') {?><select name="aproba_1" id="aproba_1"><option value="1">Aprobado</option><option value="2">Rechazado</option></select>
			  <? }else{ 
			  	if($sel_si_tiene_modificacion[5]==1) echo "Aprobado";
				if($sel_si_tiene_modificacion[5]==2) echo "Rechazado";
				} ?></td>
              <td width="32%" align="left" ><? if($sel_si_tiene_modificacion[3] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[5]=='') {?><input type="button" name="" value="Grabar" onclick="graba_valida_modificacion_manual(document.principal.aproba_1.value, document.principal.ob_aproba_1.value, 1, '<?=$sel_si_tiene_modificacion[14]?>')" /><? }?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >&nbsp;</td>
              <td colspan="2" align="left" >&nbsp;</td>
            </tr>
            
            
          <? 

		  if($sel_si_tiene_modificacion[14] != 1) {//si es una carga masiva de PECC?>  
            <tr class="<?=$clase?>">
              <td align="right" >Verificador de toda la informaci&oacute;n:</td>
              <td colspan="2" align="left" ><?=saca_nombre_lista($g1,$sel_si_tiene_modificacion[6],'nombre_administrador','us_id');?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >Observaci&oacute;n del aprobador:</td>
              <td colspan="2" align="left" ><? if($sel_si_tiene_modificacion[6] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[8]=='' and $sel_si_tiene_modificacion[5]==1) {?><textarea name="ob_aproba_2" id="ob_aproba_2"></textarea><? }else{ echo $sel_si_tiene_modificacion[7];} ?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >Aprobado o Rechazado:</td>
              <td align="left" ><? if($sel_si_tiene_modificacion[6] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[8]=='' and $sel_si_tiene_modificacion[5]==1) {?><select name="aproba_2" id="aproba_2"><option value="1">Aprobado</option><option value="2">Rechazado</option></select>
			  <? }else{ 
			  	if($sel_si_tiene_modificacion[8]==1) echo "Aprobado";
				if($sel_si_tiene_modificacion[8]==2) echo "Rechazado";
				} ?></td>
              <td align="left" ><? if($sel_si_tiene_modificacion[6] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[8]=='' and $sel_si_tiene_modificacion[5]==1) {?><input type="button" name="" value="Grabar" onclick="graba_valida_modificacion_manual(document.principal.aproba_2.value, document.principal.ob_aproba_2.value, 2)" /><? }?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >&nbsp;</td>
              <td colspan="2" align="left" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >Aprobador del cargue manual:</td>
              <td colspan="2" align="left" ><?=saca_nombre_lista($g1,$sel_si_tiene_modificacion[9],'nombre_administrador','us_id');?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >Observaci&oacute;n del aprobador:</td>
              <td colspan="2" align="left" ><? if($sel_si_tiene_modificacion[9] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[11]=='' and $sel_si_tiene_modificacion[8]==1) {?><textarea name="ob_aproba_3" id="ob_aproba_3"></textarea><? }else{ echo $sel_si_tiene_modificacion[10];} ?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >Aprobado o Rechazado:</td>
              <td align="left" ><? if($sel_si_tiene_modificacion[9] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[11]=='' and $sel_si_tiene_modificacion[8]==1) {?><select name="aproba_3" id="aproba_3"><option value="1">Aprobado</option><option value="2">Rechazado</option></select>
			  <? }else{ 
			  	if($sel_si_tiene_modificacion[11]==1) echo "Aprobado";
				if($sel_si_tiene_modificacion[11]==2) echo "Rechazado";
				} ?></td>
              <td align="left" ><? if($sel_si_tiene_modificacion[9] == $_SESSION["id_us_session"] and $sel_si_tiene_modificacion[11]=='' and $sel_si_tiene_modificacion[8]==1) {?><input type="button" name="" value="Grabar" onclick="graba_valida_modificacion_manual(document.principal.aproba_3.value, document.principal.ob_aproba_3.value, 3)" /><? }?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >&nbsp;</td>
              <td colspan="2" align="left" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="right" >&nbsp;</td>
              <td colspan="2" align="left" >&nbsp;</td>
            </tr>
            <?
		  }
			?>
           
  </table> 
          
      </td>
      </tr>
      
    </table></td>
    <td width="24%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />

<input type="hidden" name="aprobacion" id="aprobacion" />
<input type="hidden" name="observacion" id="observacion" />
<input type="hidden" name="aprobador" id="aprobador" />
<input type="hidden" name="id_validacion_modificacion" id="id_validacion_modificacion" value="<?=$sel_si_tiene_modificacion[0]?>" />
<input type="hidden" name="estado_debe_quedar" id="estado_debe_quedar" value="<?=$sel_si_tiene_modificacion[2]?>" />


</body>
</html>
