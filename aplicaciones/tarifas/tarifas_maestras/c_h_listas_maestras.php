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
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><strong>Historico de catecorias creadas</strong></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="center"></div></td>
    <td width="45%" class="columna_subtitulo_resultados">Categoria</td>
    <td width="13%"  class="columna_subtitulo_resultados"><div align="center">N. descritores</div></td>
    <td width="13%" class="columna_subtitulo_resultados"><div align="center">N. tarifas</div></td>
    <td width="16%" class="columna_subtitulo_resultados">N. relaciones</td>
    <td width="11%" class="columna_subtitulo_resultados">&nbsp;</td>
  </tr>
  <?
 $busca_item = "select  * from $v_t_6 where estado = 1 ";	  
	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		$cuenta_descr= traer_fila_row(query_db("select  count(*) from $t9 where t6_tarifas_maestras_categoria_id = $ls_mr[0]  and estado = 1 "));
	                 if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";

?>
  <tr class="<?=$class;?>">
    <td width="2%" class="filas_resultados"><img src="../imagenes/botones/busqueda.gif" alt="Vista previa de la categoria" title="Vista previa de la categoria" width="16" height="16" onclick="ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c2_listas_maestras.php?id_categoria=<?=$ls_mr[0];?>','carga_acciones_permitidas')" /></td>
    <td ><?=$ls_mr[1];?></td>
    <td ><?=number_format($cuenta_descr[0],0);?></td>
    <td ><?=number_format($ls_mr[3],0);?></td>
    <td ><?=number_format($ls_mr[4],0);?></td>
    <td >&nbsp;</td>
  </tr>
<? $num_fila++;
} ?>
</table>


<p>&nbsp;</p>
<p>
  <input type="hidden" name="id_categoria" />
  <input type="hidden" name="id_descritor" />  
</p>
</body>
</html>
