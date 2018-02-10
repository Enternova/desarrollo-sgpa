<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>

<table width="1000" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="99%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td class="titulos_secciones">SECCION: ADMINISTRACION DE LISTAS MAESTRAS</td>
      </tr>
    </table>
    <div id="creacion_otros"></div>
    </td>
    <td width="29%" valign="top">
      <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td class="fondo_2_sub">Acciones permitidas para este modulo.</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias_pricipal.php','creacion_otros');ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_categorias.php','carga_acciones_permitidas')"> &gt;&gt; Administrar categorias maestras</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_listas_maestras.php','creacion_otros');ajax_carga('../aplicaciones/tarifas/tarifas_maestras/c_h_listas_maestras.php','carga_acciones_permitidas')">&gt;&gt; Administrar listas maestras</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/tarifas_maestras/relacion_tarifas_maestras.php?id_contrato=<?=$id_contrato;?>','contenidos')"> &gt;&gt; Relacionar listas mestras con tarifas</td>
        </tr>
        <tr>
          <td class="fondo_2_sub" onclick="ajax_carga('../aplicaciones/tarifas/h_aprobaciones.php','carga_acciones_permitidas')">Reportes</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/c_documentos.php','carga_acciones_permitidas')">&gt;&gt; Proveedores  vs tarifas maestras </td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/c_descuentos.php','carga_acciones_permitidas')">&gt;&gt; Proveedores  vs detalle especifico de tarifas</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/c_comentarios.php','carga_acciones_permitidas')">&gt;&gt; Tarifas  maestras actualizadas</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/frame_reporte.php','carga_acciones_permitidas')">&gt;&gt; Tarifas  maestras contratas por HOCOL SA</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/h_auditoria.php','carga_acciones_permitidas')">&gt;&gt; Listado  de tarifas vs maestras</td>
        </tr>
        <tr>
          <td >&gt;&gt; Consumos  por prefactura tarifas maestras</td>
        </tr>
    </table>      </td>
  </tr>
</table>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td  valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>

</body>
</html>
