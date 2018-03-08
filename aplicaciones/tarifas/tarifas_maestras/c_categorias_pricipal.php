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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91%" class="titulos_secciones">SECCION: ADMINISTRACION DE CATEGORIAS DE TARIFAS MAESTRAS</td>
    <td width="9%" class="titulos_secciones">&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="23%" class="fondo_2_sub">Creaci&oacute;n de categorias de listas maestras</td>
  </tr>
  <?
 $busca_item = "select  * from $v_t_6 where estado = 1 ";	  
	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){

?>
  <? } ?>
</table>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr>
        <td width="100%">
        
        <table width="99%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="20%"><div align="right"><strong>Categor&iacute;a:</strong></div></td>
            <td width="52%"><input type="text" name="categoria" id="categoria" value="<?=$categoria;?>" /></td>
            </tr>
        </table>           </td>
        </tr>
        
      <tr>
        <td>
        
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="32%">&nbsp;</td>
            <td width="33%"><input name="button2" type="button" class="boton_grabar" id="button2" value="Crear categoria de lista maestra" onclick="crea_categorias_maestras()" /></td>
            <td width="35%"><label></label></td>
          </tr>
        </table>        </td>
      </tr>


    </table>          </td>
  </tr></table>

<br />
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td  valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>
</body>
</html>
