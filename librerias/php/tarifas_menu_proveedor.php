<? include("../lib/@session.php"); 
	verifica_menu("proveedores.html");

$menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'proveedores.html\'">Menu SGPA</td>
        </tr>

        <tr>
          <td class="fondo_1"><div align="center">4</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/tarifas/proveedor/modulo-historico-contratos.php\',\'contenidos\')">Historico de contratos</td>
        </tr>
	
    </table>';

$modulo="<div >MODULO: TARIFAS ".$texto_modulo_pruebas."</div>";	
$alertas="../aplicaciones/tarifas/proveedor/modulo-historico-contratos.php";
	
	echo $menu."$$".$modulo."$$".$alertas;