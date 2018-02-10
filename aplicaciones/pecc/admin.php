<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$sel_gerente = traer_fila_row(query_db("select * from $g1 where us_id =".$sel_item[3]));	
	
	$gerente_contrato = "-".$sel_gerente[1]."----,".$sel_gerente[0]."----, ";
	
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
              <td height="43" colspan="4" align="center"  class="fondo_3">Lista de Administraciones Permitidas con su Perfil y Relaci&oacute;n con el Proceso</td>
              </tr>
            <tr>
              <td width="28%" align="center" class="fondo_3">Detalle</td>
              <td width="20%" align="center" class="fondo_3">Encargados</td>
              <td width="28%" align="center" class="fondo_3">Observaci&oacute;n</td>
              <td width="24%" align="center" class="fondo_3">Acci&oacute;n</td>
              </tr>
        
        
          <?
        if($id_tipo_proceso_pecc <> 3){
		?>
            <tr class="<?=$clase?>">
              <td align="left" >1. Cambiar el Gerente del Contrato</td>
              <td></td>
              <td align="center" >
                <textarea name="ob1" id="ob1" cols="45" rows="3"></textarea></td>
              <td align="center" ><input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?=$gerente_contrato ?>"/></td>
              </tr>
         <?
		 }else{
        ?>
         
         <input type="hidden" name="usuario_permiso" id="usuario_permiso" value="<?=$gerente_contrato ?>"/>
         
         <?
		 }
         
		 ?>
              
              
              
            <tr class="filas_resultados">
              <td align="left" >2. Cambiar el Profesional de C&amp;C</td>
              <td align="center" >Administrador General</td>
              <td align="center" ><textarea name="ob2" id="ob2" cols="45" rows="3"></textarea></td>
              <td align="center" ><select name="acci2" id="acci2">
            <option value="">Seleccione el Profesional de C&C Designado</option>
            <?
          $sel_profss = query_db("select us_id, nombre_administrador from $v_seg1 where id_premiso = 8  group by us_id, nombre_administrador");
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
            <option value="<?=$se_prof[0]?>" <? if( $sel_item[23] ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$se_prof[1]?></option>
            <?
		  }
		  ?>
            </select></td>
              </tr>
            <tr class="<?=$clase?>">
              <td align="left" >3. Cambiar Fecha en la que se Requiere el Servicio</td>
              <td align="center" >Administrador General</td>
              <td align="center" ><textarea name="ob3" id="ob3" cols="45" rows="3"></textarea></td>
              <td align="center" ><input name="fecha" type="text" id="fecha" size="5" onchange="valida_fecha_ideal(this)" onmousedown="calendario_sin_hora('fecha')" value="<?=$sel_item[7]?>"/></td>
              </tr>
            <tr class="filas_resultados">
              <td align="left" >4. Poner Tiempos Especiales</td>
              <td align="center" >Administrador General</td>
              <td align="center" ><textarea name="ob4" id="ob4" cols="45" rows="3"></textarea></td>
              <td align="center" ><select name="acci4" id="acci4" onchange="carga_tiempos_no_estandar(this.value,<?=$id_item_pecc?>)">
              <option value="2" selected="selected">NO</option>
              <option value="1" <? if($sel_item[29] == "1") echo 'selected="selected"' ?>>SI</option>
              </select></td>
              </tr>
            <tr class="<?=$clase?>">
              <td colspan="4" align="left" >
              <div id="carga_tiempos">
              <?
              if($sel_item[29] == "1"){
			  ?>
                <table width="100%" border="1" class="tabla_lista_resultados">
                  <tr>
                    <td class="fondo_3">Actividad</td>
                    <td class="fondo_3">Tiempo Estandar</td>
                    <td class="fondo_3">Tiempo no Estandar</td>
                  </tr>
                  <?
                  	$sel_tiempos = query_db("select * from $vpeec21 where id_item = ".$id_item_pecc." order by actividad_estado_id");
					while($s_t = traer_fila_db($sel_tiempos)){
				  ?>
                  <tr>
                    <td><?=$s_t[2]?></td>
                    <td><?=number_format($s_t[3],0)?></td>
                    <td><input type="text" name="tiem_no_est_<?=$s_t[1]?>" id="tiem_no_est_<?=$s_t[1]?>" value="<?=number_format($s_t[4],0)?>" /></td>
                  </tr>
                  <?
					}
				  ?>
                  
                </table>
              <?
			  }
			  ?></div></td>
              </tr>
            <tr class="<?=$clase?>">
              <td align="left" ></td>
              <td align="center" >&nbsp;</td>
              <td align="center" >&nbsp;</td>
              <td align="center" >&nbsp;</td>
              </tr>
              <?php $sel_ob_eliminado = traer_fila_row(query_db("select id_accion_admin,observacion,adjunto from t2_acciones_admin where id_item = $id_item_pecc and accion = 'SI Eliminar el Proceso' order by id_accion_admin desc"));
			  ?>
            <tr class="filas_resultados">
              <td align="left" >6. Eliminar Este Proceso</td>
              <td align="center" >
              <input type="file" name="adjunto_para_eliminar" id="adjunto_para_eliminar" />
              <?=saca_nombre_anexo($sel_ob_eliminado[2])?>
              <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?= $sel_ob_eliminado[2]?>&n1=<?= $sel_ob_eliminado[0]?><?=$id_item_pecc?>&n3=4" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_ob_eliminado[2])?>.gif" width="16" height="16" /></a>
              </td>
              <td align="center" ><textarea name="ob6" id="ob6" cols="45" rows="3"><?= $sel_ob_eliminado[1]?></textarea></td>
              <td align="center" ><select name="acci6" id="acci6">
              <option value="0" selected="selected">Seleccione SI, si desea eliminar este proceso</option>
              <option value="1" >Si Eliminar</option>
              </select></td>
              </tr>
            <tr class="<?=$clase?>">
              <td align="left" >7. Cambiar Gestor de Socios</td>
              <td align="center" >Administrador Genera</td>
              <td align="center" ><textarea name="ob7" id="ob7" cols="45" rows="3"></textarea></td>
              <td align="center" >
              
              <select name="acci7" id="acci7">
                <option value="0">Seleccione el Gestor</option>
                
                <?
          $sel_profss = query_db("select us_id, nombre_administrador from $v_seg1  group by us_id, nombre_administrador order by nombre_administrador asc");
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
                <option value="<?=$se_prof[0]?>" >
                  <?=$se_prof[1]?>
                  </option>
                <?
		  }
		  ?>
              </select></td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="left" >8. Eliminar Urna Virtual</td>
              <td align="center" ><input type="file" name="adjunto_para_eliminar_urna" id="adjunto_para_eliminar_urna" /></td>
              <td align="center" ><textarea name="ob8" id="ob8" cols="45" rows="3"></textarea></td>
              <td align="center" ><? 
			  
			  if($sel_item[28] == 1) {
				  ?><select name="acci8" id="acci8">
                  <option value="0" selected="selected">Seleccione SI, si desea eliminar esta Urna Virtual</option>
                  <option value="1" >Si Eliminar</option>
                  </select><?
				  }else{ echo 'Este Proceso NO se Creo en la Urna Virtual'; ?> <input type="hidden" name="acci8" id="acci8" value="0" /><? } ?></td>
            </tr>
            <tr class="<?=$clase?>">
              <td colspan="2" align="center" >&nbsp;</td>
              <td colspan="2" align="center" ><input type="button" name="button2" id="button2" value="Grabar Cambios Administrativos" class="boton_grabar" onclick="acciones_administrativas()" /></td>
            </tr>
            <tr class="<?=$clase?>">
              <td colspan="3" align="center" >Poner esta solicitud en un estado especifico</td>
              <td align="center" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td colspan="3" align="center" ><?
              if($sel_item[14] <> 31 ){
			  ?>
                <input type="button" name="button3" id="button3" value="Devolver al Profesional encargado, SE BORRAN LAS FIRMAS - y los procesos creados en el modulo de contratos" class="boton_grabar_cancelar" onclick="devolver_item_a_profesional_desde_admin()" />
                <?
			  }
			  ?></td>
              <td align="center" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td colspan="3" align="center" ><input type="button" name="button" id="button" value="Poner en estado de firmas en el sistema para el permiso - se conservan las firman" class="boton_grabar_cancelar" onclick="poner_solicitud_en_estado(7)" /></td>
              <td align="center" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td colspan="3" align="center" ><input type="button" name="button5" id="button5" value="Poner en estado de presentacion a comite para el permiso - se conservan las firman" class="boton_grabar_cancelar" onclick="poner_solicitud_en_estado(8)" /></td>
              <td align="center" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td colspan="3" align="center" ><input type="button" name="button4" id="button4" value="Poner en estado de firmas en el sistema para la adjudicacion - se conservan las firman" class="boton_grabar_cancelar" onclick="poner_solicitud_en_estado(16)" /></td>
              <td align="center" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td colspan="3" align="center" ><input type="button" name="button6" id="button6" value="Poner en estado de presentacion a comite para la adjudicacion - se conservan las firman" class="boton_grabar_cancelar" onclick="poner_solicitud_en_estado(17)" /></td>
              <td align="center" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td colspan="3" align="center" ><input type="button" name="button7" id="button7" value="Poner en para validacion de modificacion manual" class="boton_grabar_cancelar" onclick="" /></td>
              <td align="center" >&nbsp;</td>
            </tr>
           
          </table> 
          
      </td>
      </tr>
      
    </table></td>
    <td width="24%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="nuevo_estdo_edita" id="nuevo_estdo_edita" value="" />
</body>
</html>
