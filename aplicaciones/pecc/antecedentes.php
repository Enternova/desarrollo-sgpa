<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	$edicion_datos_generales = "NO";
	if(verifica_permiso_pecc($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
	$edicion_datos_doc_basica = "NO";
	if(verifica_permiso_doc_basica($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_doc_basica = "SI";
		}
	$es_profesional_designado = verifica_usuario_indicado_solo_si(8,$sel_item[0]);
		
		
		$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
		
		if($sel_usu_emulan[0]>0 and ($sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
		
		 //si es nanky
 if((esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==7) or (esprofesionalcompras($id_item_pecc)=="SI" and $id_tipo_proceso_pecc == 3 and $sel_item[14]==16) or (esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[6]==11 and $sel_item[14]==16 )){
	 $edicion_datos_generales = "SI";
	 }

	/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
if($sel_item[6]==16 and ($sel_item[14] < 16) and $sel_item[23] == $_SESSION["id_us_session"]){
	$edicion_datos_generales = "SI";	
	}
/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
	?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top">
    
    
    <table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td width="54%" valign="top">
        
        <?
          if ($sel_item[3] == $_SESSION["id_us_session"] and $sel_item[14] == 15){
		  ?>
        <table width="100%" border="0" align="center" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center" class="fondo_3">Agregar Anexos de la Revision del ITEM de Adjudicacion<img src="../imagenes/botones/help.gif" alt="Seleccion de Anexos de la revision del item de adjudicacion'" width="20" height="20" /></td>
          </tr>
          <tr>
            <td width="21%" align="right">Detalle del Anexo:</td>
            <td width="25%" align="left"><textarea name="anexo" cols="25" rows="5" id="anexo"></textarea></td>
          </tr>
          <tr>
            <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
            <td align="left"><input name="adj_anexo" type="file" id="adj_anexo" size="5" /></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onClick="graba_anexo_edicion(18)" /></td>
          </tr>
        </table>
        <?
		  }
		?>
        
        
		<?
          if (vari_si_reempla($sel_item[23]) == "SI" and $sel_item[14] <> 6 and $sel_item[14] <> 31 and ($sel_item[6] <> 16 or $sel_item[14]>14)){
		  ?>
        <table width="100%" border="0" align="center" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center" class="fondo_3">Agregar Anexos Extemporaneos<img src="../imagenes/botones/help.gif" alt="Por ser el Profesional Asignado a este proceso puede cargar anexos en cualquier momento, estos anexos quedaran con una marca de 'Anexo Extemporanea'" width="20" height="20" /></td>
          </tr>
          <tr>
            <td align="right">Categor&iacute;a del Anexo</td>
            <td align="left"><select name="ct_anexo" id="ct_anexo">
              <option value="0">Seleccione</option>
              <?
          $categorias_anexos = query_db("select * from t1_categoria_anexos as t1 where estado = 1 and t1_tipo_proceso in  (0,".$sel_item[6].") ");
		  while($ct_anexo = traer_fila_db($categorias_anexos)){
		  ?>
              <option value="<?=$ct_anexo[0]?>" >
                <?=$ct_anexo[1]?>
                </option>
              <?
		  }
		  ?>
            </select></td>
          </tr>
          <tr>
            <td width="21%" align="right">Detalle del Anexo:</td>
            <td width="25%" align="left"><textarea name="anexo" cols="25" rows="5" id="anexo"></textarea></td>
          </tr>
          <tr>
            <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
            <td align="left"><input name="adj_anexo" type="file" id="adj_anexo" size="5" /></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onClick="graba_anexo_edicion(17)" /></td>
          </tr>
        </table>
        <?
		  }
		?>
        
		
		<?
          if ($edicion_datos_generales == "SI"){
		  ?>
        <table width="100%" border="0" align="center" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center" class="fondo_3">Agregar Anexos <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
          </tr>
          <tr>
            <td align="right">Categor&iacute;a del Anexo</td>
            <td align="left"><select name="ct_anexo" id="ct_anexo">
              <option value="0">Seleccione</option>
              <?
          $categorias_anexos = query_db("select * from t1_categoria_anexos as t1 where estado = 1 and t1_tipo_proceso in  (0,".$sel_item[6].") ");
		  while($ct_anexo = traer_fila_db($categorias_anexos)){
		  ?>
              <option value="<?=$ct_anexo[0]?>" >
                <?=$ct_anexo[1]?>
                </option>
              <?
		  }
		  ?>
            </select></td>
          </tr>
          <tr>
            <td width="21%" align="right">Detalle del Anexo:</td>
            <td width="25%" align="left"><textarea name="anexo" cols="25" rows="5" id="anexo"></textarea></td>
          </tr>
          <tr>
            <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
            <td align="left"><input name="adj_anexo" type="file" id="adj_anexo" size="5" /></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onClick="graba_anexo_edicion(8)" /></td>
          </tr>
        </table>
        <?
		  }
		?>
        </td>
      </tr>
      <tr>
        <td width="54%" valign="top"><div id="carga_anexos">
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="4" align="center"  class="fondo_3">Lista de Anexos</td>
              </tr>
            <tr>
              <td width="23%" align="center" class="fondo_3">Categor&iacute;a</td>
              <td width="47%" align="center" class="fondo_3">Detalle de los Anexos</td>
              <td width="23%" align="center" class="fondo_3">Archivo Adjunto</td>
              <td width="7%" align="center" class="fondo_3">Eliminar</td>
              </tr>
            <?
$cont = 0;
  $clase="";
  

	 $comple_anexos_pecc = traer_anexos_pecc($sel_item[56]);
	
  
  $sele_anexos = query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle as text), adjunto, estado, id_us, id_categoria from $pi9 where (t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'anexo') $comple_anexos_pecc");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
            <tr class="<?=$clase?>">
              <td align="center" ><? $sel_catergoria = traer_fila_row(query_db("select * from t1_categoria_anexos where id = ".$sl_anexos[8]));
			  echo $sel_catergoria[1]; ?></td>
              <td align="center" ><?=nl2br($sl_anexos[4])?></td>
              <td align="center" >
                 <? echo saca_nombre_anexo($sl_anexos[5]);
				
				$ext=extencion_archivos_sgpa($sl_anexos[5]);
				$nombre_adjunto = nombre_archivo_adjunto($sl_anexos[5]).".".$ext;//esta fila se reemplaza por el $sl_anexos[5] que esta en el link de descarga
				?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$nombre_adjunto?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
                </td>
              <td align="center" >
              <?
          if ($edicion_datos_generales == "SI" and ($sl_anexos[0] != 49334 and $sl_anexos[0] != 49335 and $sl_anexos[0] != 49336 and $sl_anexos[0] != 49337) and $sl_anexos[8] <> 20){
		  ?>
              <img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onClick="eliminar_anexo_edicion(16, <?=$sl_anexos[0]?>)">
              <?
		  }
			  ?>
              </td>
              </tr>
            <?
}
  ?>
  </table> 
          
        </div></td>
      </tr>
      
    </table>
      <table width="100%" border="0" align="center" class="tabla_lista_resultados">
        <tr>
          <td width="54%">
          <?
          if ($edicion_datos_generales == "ya no aplica"){
		  ?>
          <table width="100%" border="0" align="center" class="tabla_lista_resultados">
            <tr>
              <td colspan="2" align="center" class="fondo_3">Agregar Antecentes <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
            </tr>
            <tr>
              <td width="21%" align="right">Detalle del Antecedente:</td>
              <td width="25%" align="left"><textarea name="ancedente" cols="25" rows="5" id="ancedente"></textarea>
              <input type="hidden" name="para_comite" id="para_comite" value="2" /></td>
            </tr>
            <tr>
              <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
              <td align="left"><input name="adj_antecedente" type="file" id="adj_antecedente" size="5" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="center"><input name="button3" type="button" class="boton_grabar" id="button3" value="Agregar Antecedente"  onclick="graba_anexo_edicion(9)"/></td>
            </tr>
          </table>
          <?
		  }
		  ?>
          </td>
        </tr>
        <tr>
          <td valign="top"><div id="carga_antecedentes"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="3" align="center"  class="fondo_3">Lista de Antecedentes</td>
              </tr>
            <tr>
              <td width="50%" align="center" class="fondo_3">Detalle de los Antecedentes</td>
              <td width="40%" align="center" class="fondo_3">Archivo Adjunto</td>
              <td width="10%" align="center" class="fondo_3">Eliminar</td>
              </tr>
            <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us, antecedente_comite
 from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'antecedente'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
            <tr class="<?=$clase?>">
              <td align="center" ><?=$sl_anexos[4]?></td>
              <td align="center" >
                <?
              if($sl_anexos[5] != " "){
			  ?>
                <?=saca_nombre_anexo($sl_anexos[5])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
                  </a>
                <?
			  }
				  ?>
              </td>
              <td align="center" >
                <?
          if ($edicion_datos_generales == "SI"){
		  ?>
                <img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onClick="eliminar_anexo_edicion(9, <?=$sl_anexos[0]?>)">
                <?
		  }
			  ?>
              </td>
              </tr>
            <?
}
  ?>
</table>
              
          </div>
          </td>
        </tr>
        <tr style="display:none">
          <td valign="top">
          
          <?
		  
          $id_contrato_carr = $sel_item[21];
		  if($id_contrato_carr > 0){
	$solicitudes_antecedentes = 0;

	$solicitud_madre = traer_fila_row(query_db("select id_item from $co1 where id =".$id_contrato_carr));	
	$sele_otros_si = query_db("select id_item from $pi2 where contrato_id = ".$id_contrato_carr." and id_item <> ".$id_item_pecc );
	while($sel_item_otros = traer_fila_db($sele_otros_si)){
		$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$sel_item_otros[0];
		}
	
	$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$solicitud_madre[0];
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
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id in (".$solicitudes_antecedentes.") and estado = 1 and tipo = 'antecedente'");
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
  <tr class="<?=$clase?>">
    <td align="center" ><?=numero_item_pecc($sel_numero_item[0],$sel_numero_item[1],$sel_numero_item[2])?></td>
    <td align="center" ><?=nl2br($sl_anexos[4])?></td>
    <td align="center" >
      <? if($sl_anexos[5] != " "){?>
      <?=saca_nombre_anexo($sl_anexos[5])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
      <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
      </a>
      <?
	}
	?>
    </td>
  </tr>
  <?
}
  ?>
</table>
<?
		  }
?>



        <?
          $id_contrato_carr = $sel_item[26];
		  if($sel_item[26] > 0){
	$solicitudes_antecedentes = 0;


	$sele_otros_si = query_db("select id_item from $pi2 where id_item_peec_aplica = ".$id_contrato_carr);
	while($sel_item_otros = traer_fila_db($sele_otros_si)){
		$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$sel_item_otros[0];
		}
	
	$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$sel_item[26];
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
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id in (".$solicitudes_antecedentes.") and estado = 1 and tipo = 'antecedente'");
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
  <tr class="<?=$clase?>">
    <td align="center" ><?=numero_item_pecc($sel_numero_item[0],$sel_numero_item[1],$sel_numero_item[2])?></td>
    <td align="center" ><?=nl2br($sl_anexos[4])?></td>
    <td align="center" >
      <? if($sl_anexos[5] != " "){?>
      <?=saca_nombre_anexo($sl_anexos[5])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
      <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
      </a>
      <?
	}
	?>
    </td>
  </tr>
  <?
}
  ?>
</table>
<?
		  }
?>
</td>
        </tr>
      </table>      
      </td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_anexo_elimina" id="id_anexo_elimina" value="" />
<input type="hidden" name="tipo_anexo" id="tipo_anexo" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="estado_actual_del_proceso" id="estado_actual_del_proceso" value="<?=$sel_item[14]?>" />
</body>
</html>
