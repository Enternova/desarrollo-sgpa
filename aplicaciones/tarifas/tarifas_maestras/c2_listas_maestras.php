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
<?
$busca_item = "select  * from $v_t_6 where t6_tarifas_maestras_categoria_id = $id_categoria";	  
	$ls_mr = traer_fila_row(query_db($busca_item));

		
		$cuenta=0;
		$descriptores= query_db("select  * from $t9 where t6_tarifas_maestras_categoria_id = $ls_mr[0] and estado = 1 ");
		while($ls_descri=traer_fila_row($descriptores)){// imprime descriptores
		$titulos_g.= "<td class='columna_subtitulo_resultados' width='110'>".$ls_descri[3]."</td>";
		$cuenta+=1;
		} // imprime descriptores
	?>
  
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="<?=($cuenta+7);?>" class="columna_titulo_resultados">CATEGORIA: <?=strtoupper($ls_mr[1]);?> </td>
  </tr>
  <tr>
    <td colspan="3" class="columna_subtitulo_resultados" width="1" ><div align="center"></div></td>
    <td width="61" class="columna_subtitulo_resultados">Codigo</td>
    <td width="695" class="columna_subtitulo_resultados">Grupo</td>
    <td width="695" class="columna_subtitulo_resultados">Detalle</td>
    <td width="87" class="columna_subtitulo_resultados">N._relaciones</td>
    <?=$titulos_g;?>
  </tr>
 <?
 	
 	$busca_lista="select * from $t10 where t6_tarifas_maestras_categoria_id = $ls_mr[0] and estado = 1";
	$sql_lista=query_db($busca_lista);
	 while($ls_lista=traer_fila_row($sql_lista)){// imprime lista
	 $cuenta_relaciones =traer_fila_row(query_db("select count(*) from $t11 where t6_tarifas_maestras_lista_id =$ls_lista[0] "));
		$tipo_campo_digita="";
		$descriptores= query_db("select  * from $t9 where t6_tarifas_maestras_categoria_id = $ls_mr[0] and estado = 1 ");
		while($ls_descri=traer_fila_row($descriptores)){// imprime descriptores
		$busca_valores = traer_fila_row(query_db("select detalle from $t15 where t6_tarifas_maestras_lista_id = $ls_lista[0] and t6_tarifas_maestras_descriptores_id = $ls_descri[0]"));
		$tipo_campo_digita.="<td >".arma_campo_digitacion($ls_descri[2],"campo_digita_".$ls_lista[0]."[".$ls_descri[0]."]",$busca_valores[0])."</td>";

		} // imprime descriptores

 ?> 
  
  <tr class="filas_resultados">
    <td width="1" class="filas_resultados"><img src="../imagenes/botones/editar.jpg" alt="Editar categoria" title="Editar categoria" width="14" height="15" onclick="edita_lista_maestra(<?=$ls_lista[0];?>)" /></td>
    <td width="1" class="filas_resultados"><img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar categoria"  title="Eliminar categoria" width="16" height="16" onclick="elimina_lista_maestra(<?=$ls_lista[0];?>)" /></td>
    <td width="1" class="filas_resultados"><img src="../imagenes/botones/busqueda.gif" alt="Vista previa de la categoria" title="Vista previa de la categoria" width="16" height="16" /></td>
    <td class="filas_resultados"><input type="text" class="campos_tarifas" value="<?=$ls_lista[2];?>" name="codigo_<?=$ls_lista[0];?>" /></td>
	<td class="filas_resultados"><textarea name="grupo_h_<?=$ls_lista[0];?>" cols="45" rows="2" class="textarea_tarifas" id="grupo_h_<?=$ls_lista[0];?>"><?=$ls_lista[4];?></textarea></td>
    <td class="filas_resultados"><textarea name="lista_h_<?=$ls_lista[0];?>" cols="45" rows="2" class="textarea_tarifas" id="textarea"><?=$ls_lista[3];?></textarea></td>
    <td class="filas_resultados"><?=number_format($cuenta_relaciones[0],0);?></td>    
    <?=$tipo_campo_digita;?>
    <? 
	
	}// si tiene descriores creados
		
	?>
  </tr>
</table>
<br />

<p>&nbsp;</p>
<p>
  <input type="hidden" name="id_categoria" value="<?=$id_categoria;?>" />
  <input type="hidden" name="id_lista" />  
</p>
</body>
</html>
