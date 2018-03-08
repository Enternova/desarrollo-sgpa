<? include("../lib/@session.php"); 
	verifica_menu("administracion.html");

$menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'">Menu SGPA</td>
        </tr>';
		
       if($_SESSION["id_us_session"] == 1){//para que nunca se muestre
      $menu.=  '<tr>
          <td class="fondo_1"><div align="center">3</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/creacion-item-pecc.php?id_tipo_proceso_pecc=1\',\'contenidos\')">Crear Solicitud-PECC</td>
        </tr>
        <tr>
          <td class="fondo_1" align="center">4</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/creacion-item-pecc.php?id_tipo_proceso_pecc=2\',\'contenidos\')">Ampliar Contrato Marco</td>
        </tr>';
	   }
      $menu.=  '<tr>
          <td class="fondo_1"><div align="center">5</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/historico.php\',\'contenidos\')">Historico PECC</td>
        </tr>
        
        <tr>
          <td class="fondo_1"><div align="center">7</div></td>
          <td class="fondo_2" onclick=window.location.href="../index.php">Salida Segura</td>
        </tr>		
    </table>';

$modulo="MODULO PECC DEL SGPA";	
$alertas="../aplicaciones/pecc/historico.php";
	
	echo $menu."$$".$modulo."$$".$alertas;
	?>
	