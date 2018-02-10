<? include("../lib/@session.php");  
	verifica_menu("administracion.html");

$menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'">Menu SGPA</td>
        </tr>';
        if(permiso_ingreso(61) == "SI"){
		$menu.='<tr>
          <td align="center" class="fondo_1">2</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/indicadores/inicio.php\',\'contenidos\')">Tiempos / Procesos</td>
      </tr>';
		}
		if(permiso_ingreso(62) == "SI"){
	  $menu.='<tr>
          <td align="center" class="fondo_1">3</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_reporte_general.php\',\'contenidos\')">Reporte Niveles Apro.</td>
      </tr>';
		}
		if(permiso_ingreso(63) == "SI"){
	  
	  $menu.='<tr>
          <td align="center" class="fondo_1">4</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_comite.php\',\'contenidos\')">Reporte de Comit&eacute;</td>
      </tr>';
		}
		if(permiso_ingreso(64) == "SI"){
	  $menu.='<tr>
          <td align="center" class="fondo_1">5</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_auditor.php\',\'contenidos\')">Reporte de Auditor</td>
      </tr>';
		}
		if(permiso_ingreso(65) == "SI"){
	  $menu.='<tr>
          <td align="center" class="fondo_1">6</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_usuarios.php\',\'contenidos\')">Reporte de Usuarios</td>
	  </tr>';
		}
			if(permiso_ingreso(66) == "SI"){
	  $menu.='<tr>
          <td align="center" class="fondo_1">7</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_aprobacion_area.php\',\'contenidos\')">Aprobaciones por &Aacute;rea</td>
	  </tr>'; 
		}
		if(permiso_ingreso(67) == "SI"){
      $menu.='<tr>
          <td align="center" class="fondo_1">8</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_saldos_marco.php\',\'contenidos\')">Detalle Contratos Marco</td>
      </tr>';
		}
		if(permiso_ingreso(68) == "SI"){
	 $menu.='<tr>
          <td align="center" class="fondo_1">9</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_contratos.php\',\'contenidos\')">Legalizaci&oacute;n Contractual</td>
      </tr>';
		}
	if(permiso_ingreso(69) == "SI"){
	  
	  $menu.='<tr>
          <td align="center" class="fondo_1">10</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_movimientos_contratos.php\',\'contenidos\')">Antecedentes Contrato</td>
      </tr>';
		
		
		}
		
		if(permiso_ingreso(70) == "SI"){
	$menu.='<tr>
          <td align="center" class="fondo_1">11</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_modificaciones.php\',\'contenidos\')">Eventos a Contrato</td>
      </tr>';	
		}
		
		
		if(permiso_ingreso(71) == "SI"){
		$menu.='<tr>
          <td align="center" class="fondo_1">12</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_congelados.php\',\'contenidos\')">Reportes Congelados</td>
      </tr>';
		}

	  if(permiso_ingreso(72) == "SI"){
	  $menu.='<tr>
	  <td align="center" class="fondo_1">13</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_conflicto_intereces.php\',\'contenidos\')">Conflicto de intereses</td>
      </tr>';
	  }
	if(permiso_ingreso(73) == "SI"){
	  $menu.='<tr>
	  <td align="center" class="fondo_1">14</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_ejecuciones_marco.php\',\'contenidos\')">Ejecuci&oacute;n Cont. Marco</td>
      </tr>';
		}
if(permiso_ingreso(74) == "SI"){
		$menu.='<tr>
          <td align="center" class="fondo_1">15</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/indicadores/legalizacion_inicio.php\',\'contenidos\')">Tiempos de Legalizacion</td>
      </tr>';	
}
if(permiso_ingreso(75) == "SI"){
	  
	  $menu.='<tr>
          <td align="center" class="fondo_1">16</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/reemplazos_inicio.php\',\'contenidos\')">Reemplazos y Ausencias</td>
      </tr>';
}
if(permiso_ingreso(76) == "SI"){
	  
	  $menu.='<tr>
          <td align="center" class="fondo_1">17</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/solicitudes_eliminadas_inicio.php\',\'contenidos\')">Solicitudes Eliminadas</td>
      </tr>';	
}if(permiso_ingreso(77) == "SI"){
	  
	  $menu.='<tr>
          <td align="center" class="fondo_1">18</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_valor_contrato_puntual.php\',\'contenidos\')">Valor Contrato Puntual</td>
      </tr>';
}
if(permiso_ingreso(78) == "SI"){
      $menu.='<tr>
          <td align="center" class="fondo_1">19</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/ans.php\',\'contenidos\')">Reporte ANS</td>
      </tr>';	
	  }

if(permiso_ingreso(79) == "SI"){
		$menu.='<tr>
          <td align="center" class="fondo_1">20</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/inicio_valor_area_proyecto.php\',\'contenidos\')">Aprob. &Aacute;rea/Proyecto</td>
      </tr>';
		}
if(permiso_ingreso(80) == "SI"){
	 $menu.='
      <tr>
          <td align="center" class="fondo_1">21</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/alertas_contratos.php\',\'contenidos\')">Vencimiento Contratos</td>
      </tr>' ;
}
	  $menu.='
      <tr>
          <td align="center" class="fondo_1">22</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/reportes/variacion_tarifas_general.php\',\'contenidos\')">Variaci&oacute;n de Tarifas Global</td>
      </tr>' ;
		if($es_local=="NO"){
      $menu.='<tr>
          <td class="fondo_1">
            <div align="center"></div></td>
           <td class="fondo_2" onclick=window.location.href="../index.php">Salida Segura</td>
        </tr>';	
		}
    $menu.='</table>';

$modulo="MODULO REPORTES DEL SGPA";	
$alertas="../aplicaciones/reportes/inicio_reportes.php";
	
	echo $menu."$$".$modulo."$$".$alertas;
	?>
    
    
	