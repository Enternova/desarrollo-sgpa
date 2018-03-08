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
    <td width="91%" class="titulos_secciones">SECCION: ADMINISTRACION DE LISTAS DE TARIFAS MAESTRAS</td>
    <td width="9%" class="titulos_secciones">&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="23%" class="fondo_2_sub">Creaci&oacute;n de listas maestras</td>
  </tr>

</table>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr>
        <td width="100%">
        
        <table width="99%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="20%"><div align="right"><strong>Categor&iacute;a:</strong></div></td>
            <td width="52%"><input type="text" name="categoria_busca" id="categoria_busca" value="<?=$categoria_busca;?>" onkeypress="selecciona_lista()"   /></td>
            </tr>
          <tr>
            <td><div align="right">Codigo de la lista:</div></td>
            <td><input type="text" name="codigo_maestro" id="codigo_maestro" /></td>
          </tr>
          <tr>
            <td><div align="right">Grupo de la lista maestra:</div></td>
            <td><input type="text" name="grupo_lista" id="grupo_lista" /></td>
          </tr>
          <tr>
            <td><div align="right"><strong>Detalle de lista maestra:</strong></div></td>
            <td><input type="text" name="detalle_lista" id="detalle_lista" /></td>
          </tr>
        </table>           </td>
        </tr>
        
      <tr>
        <td>
        
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="32%">&nbsp;</td>
            <td width="33%"><input name="button2" type="button" class="boton_grabar" id="button2" value="Crear lista maestra" onclick="crea_lista_maestra()" /></td>
            <td width="35%">            <input name="button" type="button" class="boton_volver" id="button" value="Volver a las categorias" onclick="ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_listas_maestras.php','creacion_otros');ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_h_listas_maestras.php','carga_acciones_permitidas')" />            </td>
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
