<? include("../lib/@session.php"); 
	verifica_menu("administracion.html");


$verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 10 and  us_id in (".$_SESSION["usuarios_con_reemplazo"].") "));

if($verifica_permiso[0]>0){
	$puede_crear =$puede_crear.'<tr>
          <td class="fondo_1"><div align="center">3</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/comite/creacion-comite-pecc.php\',\'contenidos\');ajax_carga(\'../aplicaciones/comite/menu_comite_blank.php\',\'id_div_sub\')">Crear Comit&eacute; PECC</td>
        </tr>';//queda desabilitado
		
		
        $puede_crear='<tr>
          <td class="fondo_1" align="center">4</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/comite/creacion-comite-solcitudes.php\',\'contenidos\');ajax_carga(\'../aplicaciones/comite/menu_comite_blank.php\',\'id_div_sub\')">Crear Comit&eacute;</td>
        </tr>';
	}
$valida_permiso="select * from $ts6 where id_usuario in (".$_SESSION["usuarios_con_reemplazo"].") and id_rol_general=6";
  $resultado=traer_fila_row(query_db($valida_permiso));
  if($resultado[1]==6){ 
    $crear_tarea='<tr>
          <td class="fondo_1"><div align="center">8</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/comite/crea-tarea-comite.php\',\'contenidos\');ajax_carga(\'../aplicaciones/comite/menu_comite_blank.php\',\'id_div_sub\')">Crear Tarea</td>
        </tr>';
  }
$menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'">Menu SGPA</td>
        </tr>'.$puede_crear.'		
			
      
        <tr>
          <td class="fondo_1"><div align="center">5</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/comite/historico.php\',\'contenidos\');ajax_carga(\'../aplicaciones/comite/menu_comite_blank.php\',\'id_div_sub\')">Hist&oacute;rico de Comites</td>
        </tr>
		 <tr>
          <td align="center" class="fondo_1">6</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_comite.php\',\'contenidos\');ajax_carga(\'../aplicaciones/comite/menu_comite_blank.php\',\'id_div_sub\')">Reporte de Comit&eacute;</td>
      </tr>
	  <tr>
          <td class="fondo_1"><div align="center">7</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/comite/historico-tareas-comite.php\',\'contenidos\');ajax_carga(\'../aplicaciones/comite/menu_comite_blank.php\',\'id_div_sub\')">Hist&oacute;rico de Tareas</td>
        </tr>	
		'.$crear_tarea;
       if($es_local=="NO"){
    $menu.='    <tr>
          <td class="fondo_1"><div align="center">&nbsp;</div></td>
          <td class="fondo_2" onclick=window.location.href="../index.php">Salida Segura</td>
        </tr>	';	
	   }
  $menu.='  </table>

<div id="id_div_sub"></div>
';

$modulo="MODULO COMITE DEL SGPA";	
$alertas="../aplicaciones/comite/historico.php";
	
	echo $menu."$$".$modulo."$$".$alertas;

	?>
	