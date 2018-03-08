<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));

	 $busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	 $estado_finalizado = $sql_con[23];
	 $es_de_bienes = $sql_con[24];
	
	if($sql_con[11]==3 or $sql_con[11]==6){//muestra menu permitido
	
		$busca_ipc_ac = "select t6_tarifas_ipc_contrato_id, ipc_administracion, nombre_administrador, fecha_creacion, estado from v_tarifas_ipc_contrato where t6_tarifas_contratos_id = $id_contrato_arr  and ipc_administracion = 1 and estado = 1";
		
	$traer_descvuentos_ipc = traer_fila_row(query_db($busca_ipc_ac));

	/*
				<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')">Crear tarifas</li>
				<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas_masivas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')">Crear tarifas masivas</li>			
				<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')">Actualizar tarifas</li>

*/

$creacion_tarifas_pr.= '<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Crear manualmente</li>';
$creacion_tarifas_pr.= '<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas_masivas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Crear masivamente</li>';

$creacion_tarifas_pr_ac.= '<li onClick="muestra_alerta_iformativa_solo_texto(&apos;&apos;,&apos;ALERTA&apos;, &apos;Tenga en cuenta que no puede realizar por esta opci&oacute;n el Incremento de tarifas por IPC&apos;, 20, 5, 12);ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas_actualizar.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Actualizar  manualmente</li>';
$creacion_tarifas_pr_ac.= '<li onClick="muestra_alerta_iformativa_solo_texto(&apos;&apos;,&apos;ALERTA&apos;, &apos;Tenga en cuenta que no puede realizar por esta opci&oacute;n el Incremento de tarifas por IPC&apos;, 20, 5, 12);ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas_actualicar_masivas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Actualizar masivamente</li>';
$actualiza_tarifas_ip='<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas_actualizar_ipc.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Actualizar manualmente</li>';
$actualiza_tarifas_ip_masiva='<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_tarifas_actualicar_masivas_ipc.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Actualizar masivamente</li>';
//$historico_tarifas= '<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/h_tarifas_actualizar.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Historico de tarifas</li>';


$crea_tiquete ='<li  onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_prefactura.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Crear tiquete de servicio</li>';
$historico_tiquetes = '<li  onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/h_prefactura.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Hist&oacute;rico de tiquete</li>';
$crea_reembolsables = '<li  onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_reembolsable.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Crear tiquete reembolsable</li>';
$historico_reembolsables='<li  onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/h_reembolsable.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Hist&oacute;rico de reembolsable</li>';




$historico_aprobacinoes_pv='<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/c_aprobaciones.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer"> Aprobaciones pendientes</li>';
//$historico_aprobacinoes_pv.='<li onClick="ajax_carga(\'../aplicaciones/tarifas/proveedor/h_aprobaciones.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Historico de aprobaciones</li>';


$menu='
<table width="99%" border="0" cellspacing="0" cellpadding="0">
    <td width="9%" ><input type="button" name="button5" class="boton_volver" id="button5" value="  Menu principal de tarifas" onclick="taer_menu(\'menu-tarifas-proveedor.html\',\'contenido_menu\')" /></td>
  </tr>
</table>
<br>
<table width="187" border="0" cellpadding="2" cellspacing="2" >
        <tr>
          <td class="fondo_2">Acciones permitidas</td>
        </tr>
        <tr>
		<td> 
		
	<ul class="menu_lista">';
	
		
	if($estado_finalizado>=10){
		
		$menu.='<li>Creaci&oacute;n tarifas nuevas
			<ul  class="menu_lista_sub">'.$creacion_tarifas_pr.'

			</ul>
		</li>';
	}
		
		$menu.='<li>Actualizaci&oacute;n tarifas actuales<br /> <Span class="letra-descuentos">(No usar para reajuste IPC)</Span>
			<ul  class="menu_lista_sub">';


			if($estado_finalizado>=10)
					$menu.=$creacion_tarifas_pr_ac;
			

		$menu.='</ul>
		</li>';
		
		$menu.='<li>Actualizaci&oacute;n tarifas por IPC
			<ul  class="menu_lista_sub">';


			
			if($traer_descvuentos_ipc[0]>=1){
				if($estado_finalizado>=10)	
					$menu.=$actualiza_tarifas_ip;
					$menu.=$actualiza_tarifas_ip_masiva;
			
			}

		$menu.='</ul>
		</li>';
if($es_de_bienes != "Bienes" and $sql_con[11]!=6){//// si el contrato es de bienes este no debe permitir crear tiketes ni reembolsables ** O SI ES DIFERENTE A CONTRATOS CON EXCEPCION

		$menu.=$historico_tarifas.'<li>Tiquetes de Servicio
			<ul  class="menu_lista_sub">';
			
				if($estado_finalizado>=10)	
		$menu.=$crea_tiquete;
		
		$menu.=$historico_tiquetes	;

			$menu.='</ul>
		</li>';
		
				$busca_reembolsables = "select * from t6_tarifas_reembosables1_contrato where t6_tarifas_contratos_id = ".$sql_con[0]. " and estado = 1 and porcentaje_administracion >=0";
				$busca_ree = traer_fila_row(query_db($busca_reembolsables));
				if($busca_ree[0]>=1){ 
				$menu.=	'<li>Tiquetes de Reembolsables
								<ul  class="menu_lista_sub">';
			
					if($estado_finalizado>=10)
						$menu.=$crea_reembolsables;

						$menu.=$historico_reembolsables;						
				
				$menu.=	'</ul></li>';
				
				}
		

		}// FIN si el contrato es de bienes este no debe permitir crear tiketes ni reembolsables.
			
		
		
		/*$menu.='<li>Aprobaciones de tarifas
			<ul  class="menu_lista_sub">'.$historico_aprobacinoes_pv.'</ul>
		</li>
		';*/
$menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/h_aprobaciones.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Consulta Estado de Tarifas</li>';

$menu.='</table>';

	} //muestra menu permitido
	else
		{ $menu='
<table width="99%" border="0" cellspacing="0" cellpadding="0">
    <td width="9%" ><input type="button" name="button5" class="boton_volver" id="button5" value="  Menu principal de tarifas" onclick="taer_menu(\'menu-tarifas-proveedor.html\',\'contenido_menu\')" /></td>
  </tr>
</table>
<br>
<table width="187" border="0" cellpadding="2" cellspacing="2" >
        <tr>
          <td class="fondo_2">Contrato sin tarifas</td>
        </tr>
		</table>';
		}

$modulo="MODULO: TARIFAS<span class='sub_titulos_modulos_2'><br>ADMINISTRACION TARIFAS POR CONTRATO</span>";	
$alertas="../aplicaciones/tarifas/proveedor/v_contratos.php?id_contrato=".$id_contrato;
	
	echo $menu."$$".$modulo."$$".$alertas;
?>