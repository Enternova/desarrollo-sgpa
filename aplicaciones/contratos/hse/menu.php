<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id));
$menu='
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="9%" ><input type="button" name="button5" class="boton_volver" id="button5" value=" Menu principal SGPA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onclick="window.parent.location.href=\'administracion.html\'" /></td>
  	</tr>
	<tr>
		<td><hr></td>
	</tr>
	<tr>
		<td><input type="button" name="button5" class="boton_volver" id="button5" value="  Menu principal de Contratos" onclick="taer_menu(\'menu-contratos.html\',\'contenido_menu\')" /></td>
	</tr>
</table>
<br>
<table width="187" border="0" cellpadding="2" cellspacing="2">
              <tr>
    <td class="fondo_2">Acciones permitidas</td>
  </tr>
              <tr>
			  	<td>
					<ul class="menu_lista">
						<li onclick="ajax_carga(\'../aplicaciones/contratos/hse/v_proveedor.php?id='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')">Informaci&oacute;n General</li>
						<li onclick="ajax_carga(\'../aplicaciones/contratos/hse/c_evaluacion_grupo.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')">Crear Evaluaci&oacute;n</li>						
					</ul>
				</td>               
              </tr>
          </table>';

$modulo="Sistema de gesti&oacute;n y planeaci&oacute;n de abastecimiento SGPA<div >MODULO: CONTRATOS </div>";	
$alertas="../aplicaciones/contratos/hse/v_proveedor.php?id=$id&aplica_log=1";
	
	echo $menu."$$".$modulo."$$".$alertas;
?>