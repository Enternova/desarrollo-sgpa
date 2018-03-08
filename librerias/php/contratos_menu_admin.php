<? include("../lib/@session.php"); 
	verifica_menu("administracion.html");

$menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'">Menu SGPA</td>
        </tr>
		
       <tr style="display:none">
          <td class="fondo_1"><div align="center">2</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/contratos/modulo-reportes-general.php\',\'contenidos\')">Hist&oacute;rico Contratos</td>
        </tr>
		
        <tr>
          <td class="fondo_1"><div align="center">2</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/contratos/modulo-historico-contratos.php\',\'contenidos\')">B&uacute;squeda de Contratos</td>
        </tr>
        <tr>
          <td class="fondo_1"><div align="center">3</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/contratos/modulo-reportes-inicio.php\',\'contenidos\')">Reportes</td>
        </tr>';
	
		$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=2823";
		$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
		if($sql_sel_permisos[0]>0 || $_SESSION["id_us_session"]==32){
			$menu=$menu.'		
		 <tr>
          <td class="fondo_1"><div align="center">5</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/contratos/modulo-tarifas-maestras-inicio.php\',\'contenidos\')">Cargar Ejecuci&oacute;n</td>
        </tr>
        
		 <tr>
          <td class="fondo_1"><div align="center">6</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/contratos/evaluador/modulo-evaluador-administrador.php\',\'contenidos\')">Administrar Evaluador</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">7</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/contratos/hse/modulo-historico.php\',\'contenidos\')">Evaluaci&oacute;n HSE</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">8</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/contratos/proveedor/v_proveedor.php\',\'contenidos\')">Proveedor</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">9</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/contratos/proveedor/registro_proveedor.php\',\'contenidos\')">Registro Proveedor</td>
        </tr>
		';
		}
	
		
		
$menu=$menu.'<tr>
          <td class="fondo_1"><div align="center">4</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/alertas_contratos.php\',\'contenidos\')">Vencimiento de Contratos</td>
        </tr></table>';

$modulo="MODULO CONTRATOS DEL SGPA";	
$alertas="../aplicaciones/contratos/modulo-historico-contratos.php";
	
	echo $menu."$$".$modulo."$$".$alertas;