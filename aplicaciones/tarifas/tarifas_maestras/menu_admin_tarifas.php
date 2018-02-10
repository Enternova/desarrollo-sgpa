<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

$menu='
<table width="99%" border="0" cellspacing="0" cellpadding="0">
    <td width="9%" ><input type="button" name="button5" class="boton_volver" id="button5" value="  Menu principal de tarifas" onclick="taer_menu(\'menu-tarifas.html\',\'contenido_menu\')" /></td>
  </tr>
</table>
<br>
<table width="187" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td class="fondo_2">Acciones permitidas</td>
  </tr>
  <tr>
    <td >
	<ul class="menu_lista">
	<li onclick="ajax_carga(\'../aplicaciones/tarifas/tarifas_maestras/c_categorias_pricipal.php\',\'contenidos\');ajax_carga(\'../aplicaciones/tarifas/tarifas_maestras/c_categorias.php\',\'carga_acciones_permitidas\')">Admin.categorias maestras</li>
	<li onclick="ajax_carga(\'../aplicaciones/tarifas/tarifas_maestras/c_listas_maestras.php\',\'contenidos\');ajax_carga(\'../aplicaciones/tarifas/tarifas_maestras/c_h_listas_maestras.php\',\'carga_acciones_permitidas\')">Admin. listas maestras</li>
	<li onclick="ajax_carga(\'../aplicaciones/tarifas/tarifas_maestras/relacion_tarifas_maestras.php?id_contrato=<?=$id_contrato;?>\',\'contenidos\')">Relacion mestras con tarifas</li>
	</ul>
	</td>
  </tr>
  <tr>
    <td class="fondo_2">Reportes</td>
  </tr>
  <tr>
   <td>
   <ul class="menu_lista">
   <li>Proveedores  vs maestras </li>
	<li>Proveedores  vs descriptores</li>
	<li>Tarifas  maestras actualizadas</li>
	<li>Maestras contratas</li>
	<li>Tarifas vs maestras</li>
 </td>
  </tr>

</table>';

$modulo="Sistema de gesti&oacute;n y planeaci&oacute;n de abastecimiento SGPA<div >MODULO: TARIFAS - <span class='sub_titulos_modulos_1'>ADMINISTRACION TARIFAS MAESTRAS</span></div>";	
$alertas="../aplicaciones/tarifas/tarifas_maestras/relacion_tarifas_maestras.php";
	
	echo $menu."$$".$modulo."$$".$alertas;
?>