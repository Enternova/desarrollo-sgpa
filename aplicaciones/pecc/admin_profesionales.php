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
              <td height="43" colspan="3" align="center"  class="fondo_3">Lista de Administraciones Permitidas con su Perfil y Relaci&oacute;n con el Proceso</td>
              </tr>
            <tr>
              <td width="28%" align="center" class="fondo_3">Detalle</td>
              <td width="28%" align="center" class="fondo_3">Observaci&oacute;n</td>
              <td width="24%" align="center" class="fondo_3">Acci&oacute;n</td>
              </tr>
        <?
        if($id_tipo_proceso_pecc <> 3){
		?>
            <tr class="<?=$clase?>">
              <td align="left" >1. Cambiar el Gerente del Contrato</td>
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
              <td align="left" >2. Cambiar el (Profesional de C&amp;C / Gesti&oacute;n de Abastecimiento)</td>
              <td align="center" ><textarea name="ob2" id="ob2" cols="45" rows="3"></textarea></td>
              <td align="center" ><select name="acci2" id="acci2">
            <option value="">Seleccione el Profesional de C&C Designado</option>
            <?
          $sel_profss = query_db("select us_id, nombre_administrador from $v_seg1 where id_premiso = 8  group by us_id, nombre_administrador");
		  while($se_prof =traer_fila_db($sel_profss)){
			  
			  $nombre_anexo = "Comprador";
			  
			  $sel_si_es_soporte_abas = traer_fila_row(query_db("select count(*) from v_seg1 where id_premiso = 44 and us_id = ".$se_prof[0]));
					  
					  if($sel_si_es_soporte_abas[0] > 0){
						  $nombre_anexo = "Gestion de Abastecimiento";						  
					  }
					  
				$sel_si_es_soporte_abas = traer_fila_row(query_db("select count(*) from v_seg1 where id_premiso = 30 and us_id = ".$se_prof[0]));
					  if($sel_si_es_soporte_abas[0] > 0){
						  $nombre_anexo = "Profesional de C&C";
					  }

		//if($sel_item[4] == 1 and $nombre_anexo == "Comprador"){			  
		//}else{
										  
							  ?>
								<option value="<?=$se_prof[0]?>" <? if( $sel_item[23] ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$nombre_anexo." - ".$se_prof[1]?></option>
								<?
					  //}
		  }
		  ?>
            </select></td>
              </tr>
            <tr class="<?=$clase?>">
              <td align="left" >5. Cambiar el Estado del Proceso</td>
              <td align="center" >
			  <?
              $sel_ob_cnogelado = traer_fila_row(query_db("select observacion from t2_acciones_admin where id_item = $id_item_pecc and accion = 'Congelado' order by id_accion_admin desc"));
				$nom_estado = "".$sel_ob_cnogelado[0];
				
			  ?>
              <?=$nom_estado?>
              
              <textarea name="ob5" id="ob5" cols="45" rows="3"></textarea></td>
              <td align="center" ><select name="acci5" id="acci5">
                <option value="2" selected="selected">Activo</option>
                <option value="1" <? if($sel_item[30] == "1") echo 'selected="selected"' ?>>Congelado</option>
                </select></td>
            </tr>
            <?  
			$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
mysql_select_db($dbbase_mys, $link);
$busca_urna_asociada=mysql_query("SELECT pro1_id, consecutivo FROM pro1_proceso WHERE cd_id_entrega_documentos=$id_item_pecc and tp1_id = 11");
$cuenta_urna=mysql_fetch_row($busca_urna_asociada);

$aplica_fecha_cierre_urna="NO";
			if($sel_item[14] == "12.1" and $sel_item[30] == "1" and $cuenta_urna[0]!=0){ 
			$aplica_fecha_cierre_urna="SI";
			?>
            <tr class="<?=$clase?>">
              <td rowspan="2" >El proceso se congelo mientras la urna virtual se encontraba activa, por lo que es requerido ingresar la nueva fecha de  cierre del proceso:</td>
              <td align="center" ><input name="fecha_i" type="text" class="f_fechas" id="fecha_i" onmousedown="calendario_se('fecha_i')" value="<?=valida_fecha_vacia($sql_e[17]);?>" /></td>
              <td align="center" >&nbsp;</td>
            </tr>
            <tr class="<?=$clase?>">
              <td align="center" >&nbsp;</td>
              <td align="center" >&nbsp;</td>
            </tr>
            <? } ?>
            <tr class="<?=$clase?>">
              <td align="center" >&nbsp;</td>
              <td colspan="2" align="center" ><input type="button" name="button2" id="button2" value="Grabar Cambios" class="boton_grabar" onclick="acciones_administrativas_profesionales()" /></td>
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
<input type="hidden" name="estado_congelado_inicial" id="estado_congelado_inicial" value="<?=$sel_item[30]?>" />
<input type="hidden" name="aplica_fecha_cierre_urna" id="aplica_fecha_cierre_urna" value="<?=$aplica_fecha_cierre_urna?>" />

</body>
</html>
