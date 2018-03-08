<? include("../lib/@session.php"); 
	verifica_menu("administracion.html");
	
		
 if(verifica_rol_usuario($_SESSION["id_us_session"], 1)=="NO"){
	 $menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'">Menu SGPA</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">2</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/modulo-historico-contratos.php\',\'contenidos\')">Buscador por contratos</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">3</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/modulo-reportes-inicio.php\',\'contenidos\')">Reportes</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">4</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/admin/modulo-historico-municipios.php\',\'contenidos\')">Municipios</td>
        </tr>
		</table>';
	 
 }else{
$menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'">Menu SGPA</td>
        </tr>

        <tr>
          <td class="fondo_1"><div align="center">2</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/modulo-historico-contratos.php\',\'contenidos\')">Buscador por contratos</td>
        </tr>
        
        <tr>
          <td class="fondo_1"><div align="center">3</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/admin/modulo-historico-municipios.php\',\'contenidos\')">Municipios</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">4</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/modulo-reportes-inicio.php\',\'contenidos\')">Reportes</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">5</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/cargue_manualus_proveedor.php\',\'contenidos\')">Adm. Manual Proveedor</td>
        </tr>
		';
		/*<tr>
          <td class="fondo_1"><div align="center">5</div></td>
          <td class="fondo_2" onclick="taer_menu(\'../aplicaciones/tarifas/tarifas_maestras/menu_admin_tarifas.php\',\'contenido_menu\')">Tarifas maestras</td>
        </tr>*/

        
       
 	
 $menu.='</table>';
 }
// <tr>          <td class="fondo_1"><div align="center">7</div></td>          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/modulo-tarifas-maestras-inicio.php\',\'contenidos\')">Buscador de Auditoria</td>        </tr>


$modulo="MODULO TARIFAS DEL SGPA";	
$alertas="../aplicaciones/tarifas/modulo-historico-contratos.php";
	
	echo $menu."$$".$modulo."$$".$alertas;