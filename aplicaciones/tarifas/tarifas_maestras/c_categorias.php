<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_categoria= elimina_comillas($id_categoria);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="23%" class="fondo_2_sub">Historico de categorias</td>
  </tr>
</table>
<?
 $busca_item = "select  * from $v_t_6 where estado = 1 ";	  
	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
	
	$cuenta_descr= traer_fila_row(query_db("select  count(*) from $t9 where t6_tarifas_maestras_categoria_id = $ls_mr[0]  and estado = 1 "));
?>
  
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" width="2%" class="columna_subtitulo_resultados"><div align="center"></div></td>
    <td width="62%" class="columna_subtitulo_resultados">Categoria</td>
    <td width="1%" colspan="<?=$cuenta_descr[0];?>" class="columna_subtitulo_resultados"><div align="center">Descriptores</div></td>
    <td width="1%" class="columna_subtitulo_resultados"><div align="center">Nuevo_descriptor</div></td>
  </tr>
  <tr class="filas_resultados">
    <td width="2%" class="filas_resultados"><img src="../imagenes/botones/editar.jpg" alt="Editar categoria" title="Editar categoria" width="14" height="15" onclick="edita_descriptor_maestras(<?=$ls_mr[0];?>,document.principal.categoria_h_<?=$ls_mr[0];?>)" /></td>
    <td width="2%" class="filas_resultados"><img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar categoria"  title="Eliminar categoria" width="16" height="16" onclick="elimina_descritores_maestra(<?=$ls_mr[0];?>)" /></td>
    <td width="2%" class="filas_resultados"><img src="../imagenes/botones/busqueda.gif" alt="Vista previa de la categoria" title="Vista previa de la categoria" width="16" height="16" /></td>
    <td class="filas_resultados"><textarea name="categoria_h_<?=$ls_mr[0];?>" cols="45" rows="2" class="textarea_tarifas_300" id="textarea"><?=$ls_mr[1];?></textarea>
</td>
   
    <? 
		if($cuenta_descr[0]>=1){// si tiene descriores creados
		$descriptores= query_db("select  * from $t9 where t6_tarifas_maestras_categoria_id = $ls_mr[0] and estado = 1 ");
		while($ls_descri=traer_fila_row($descriptores)){// imprime descriptores
	?>
    
    <td class="filas_resultados">
    
    	<table width="110" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="4%"><img src="../imagenes/botones/help.gif" alt="Nombre del descriptor: <?=$ls_descri[3];?>" width="18" height="18" title="Nombre del descriptor: <?=$ls_descri[3];?>" /></td>
        <td width="96%"><input type="text" name="detalle_descriptor_h_<?=$ls_mr[0];?>[<?=$ls_descri[0];?>]" id="detalle_descriptor_h_<?=$ls_mr[0];?>[<?=$ls_descri[0];?>]" value="<?=$ls_descri[3];?>" /></td>
      </tr>
      <tr>
        <td><img src="../imagenes/botones/help.gif" alt="Tipo de campo del descriptor" width="18" height="18" title="Tipo de campo del descriptor: <?=listas_sin_select($g16,$ls_descri[2],1);?>" /></td>
        <td><select name="tipo_campo_h_<?=$ls_descri[0];?>" id="tipo_campo_h_<?=$ls_mr[0];?>">
            <?=listas($g16, " t1_tipo_campo_digitacion_id >=1",$ls_descri[2],'nombre', 1);?>
            </select>    </td>
      </tr>
      <tr>
        <td colspan="2"><div align="center"><img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar descriptor" width="16" height="16" onclick="elimina_descriptor_maestras(<?=$ls_descri[0];?>,<?=$ls_mr[0];?>)" /></div></td>
        </tr>
    </table>
    
    </td>
    <? } // imprime descriptores
	
	}// si tiene descriores creados
		else echo "<td>&nbsp;</td>"; // si tiene descriores creados
	?>
    
    <td class="titulos_resumen_alertas"><table width="110" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="4%"><img src="../imagenes/botones/help.gif" alt="Nombre del descriptor" width="18" height="18" title="Nombre del descriptor" /></td>
        <td width="96%"><input type="text" name="c_descriptor_<?=$ls_mr[0];?>" id="c_descriptor_<?=$ls_mr[0];?>"/></td>
      </tr>
      <tr>
        <td><img src="../imagenes/botones/help.gif" alt="Tipo de campo del descriptor" width="18" height="18" title="Tipo de campo del descriptor" /></td>
        <td><select name="tipo_campo_<?=$ls_mr[0];?>" id="tipo_campo">
            <?=listas($g16, " t1_tipo_campo_digitacion_id >=1",0,'nombre', 1);?>
            </select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input name="button" type="button" class="boton_grabar" id="button" value="Crear descritor" onclick="crea_descriptor_maestras(<?=$ls_mr[0];?>,document.principal.c_descriptor_<?=$ls_mr[0];?>,document.principal.tipo_campo_<?=$ls_mr[0];?>)" />
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<? } ?>
<p>&nbsp;</p>
<p>
  <input type="hidden" name="id_categoria" />
  <input type="hidden" name="id_descritor" />  
</p>
</body>
</html>
