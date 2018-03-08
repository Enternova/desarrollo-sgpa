<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		


	
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	 $busca_contrato = "select gerente, estado_contrato, especialista from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));		

	$permiso_creacion_tarifas = 0;
	$permiso_ver_suplentes = 0;		
	$permiso_ver_aprobaciones = 0;		
	$permiso_ver_histo_aprobaciones = 0;		
	$permiso_ver_tarifas = 0;
	$permiso_ver_tiquetes = 0;
	$permiso_ver_reembolsables = 0;					
	$permiso_creacion_reembolsables_descu_ipc = 0;


$busca_detalle = "select count(*) from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and us_aprobacion_actual = ".$_SESSION["id_us_session"]." and t6_tarifas_estados_tarifas_id in (2,3)  ";	
$sql_si_tiene_aprobaciones=traer_fila_row(query_db($busca_detalle));
if($sql_si_tiene_aprobaciones[0]>=1){
//	$permiso_ver_suplentes = 1;		
	$permiso_ver_aprobaciones = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;	
}

$busca_sumpletes_responsable = query_db("select tipo_suplencia, us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]." and   estado = 1 and fecha_suplencia >= '$fecha'");
while($sql_suplente=traer_fila_row($busca_sumpletes_responsable)){//while suplentes

	if($sql_suplente[0]==1){//si es gerente_item
	
	$permiso_ver_aprobaciones = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;					

		}

	elseif($sql_suplente[0]==2){//si es gerente_item
	$permiso_creacion_tarifas = 0;
	$permiso_ver_suplentes = 1;		
	$permiso_ver_aprobaciones = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;					
	$permiso_creacion_reembolsables_descu_ipc = 1;

		}

	elseif($sql_suplente[0]==3){//si es gerente_item
	$permiso_ver_suplentes = 1;		
	$permiso_ver_aprobaciones = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;					

		}


} //while suplentes

	
 	$busca_permisos_roles = "select id_rol from v_relacion_roles_usuarios where us_id = ".$_SESSION["id_us_session"];
	$sql_busca_roles_permisos = query_db($busca_permisos_roles);	
	while($lista_permisos=traer_fila_row($sql_busca_roles_permisos)){ // buscador de roles de usuario

	if($lista_permisos[0]==1){//si es admisnirador
	
	$permiso_creacion_tarifas = 1;
	
	$permiso_ver_suplentes = 1;		
	$permiso_ver_aprobaciones = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;					
	$permiso_creacion_reembolsables_descu_ipc = 1;
		}
	elseif($lista_permisos[0]==3){//si es gerente_item
	$permiso_ver_suplentes = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;					

		}		
	elseif($lista_permisos[0]==13 or $lista_permisos[0]==17 or $lista_permisos[0]==4 or $lista_permisos[0]==3 or $lista_permisos[0]==23 or $lista_permisos[0]==8 ){//si es proceciona de c y c
	$permiso_creacion_tarifas = 0;
	$permiso_ver_suplentes = 1;		
	$permiso_ver_aprobaciones = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;					
	$permiso_creacion_reembolsables_descu_ipc = 1;
		}

	elseif($lista_permisos[0]==5){//si es gerente_item
	$permiso_ver_suplentes = 1;		
	$permiso_ver_aprobaciones = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;					

		}

	elseif($sql_con[0]==$_SESSION["id_us_session"]){//si es si es gerente_contrato
	$permiso_ver_aprobaciones = 1;		
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;					

		}		
		
	
	elseif($lista_permisos[0]==21){//si es gestion contratos 
			$permiso_ver_histo_aprobaciones = 1;		
			$permiso_ver_tarifas = 1;
			$permiso_ver_tiquetes = 1;
			$permiso_ver_reembolsables = 1;					

		}		
	elseif($lista_permisos[0]==10){//si jefe de area
			$permiso_ver_aprobaciones = 1;		
			$permiso_ver_histo_aprobaciones = 1;		
			$permiso_ver_tarifas = 1;
			$permiso_ver_tiquetes = 1;
			$permiso_ver_reembolsables = 1;					
		}		
	elseif($lista_permisos[0]==11){//si es legal
			$permiso_ver_histo_aprobaciones = 1;		
			$permiso_ver_tarifas = 1;

		}		
	elseif($lista_permisos[0]==12){//si es prsidente
			$permiso_ver_tarifas = 1;	
		}		

	elseif($lista_permisos[0]==4){//si es comprador
			$permiso_ver_tarifas = 1;
			$permiso_ver_tiquetes = 1;	
		}	

	elseif($lista_permisos[0]==14 or $lista_permisos[0]==2){//si es comprador
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;		
		}
	elseif($lista_permisos[0]==34){//si es auditro de tarifas
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;
	$permiso_ver_reembolsables = 1;		
		}

	elseif($lista_permisos[0]==15){//si es comprador
	$permiso_ver_histo_aprobaciones = 1;		
	$permiso_ver_tarifas = 1;
	$permiso_ver_tiquetes = 1;

		}				

		

	
	
	
	}// buscador de roles de usuario
	




		
	 $busca_responsable_aprobacion = "select * from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]."
	 and estado = 1 ";
	 $sql_respo_ap = traer_fila_row(query_db($busca_responsable_aprobacion));	
	 if( $sql_respo_ap[0]>=1) {
			$permiso_ver_aprobaciones = 1;		
			$permiso_ver_histo_aprobaciones = 1;		
			$permiso_ver_tarifas = 1;

}

if($_SESSION["id_us_session"] != 32){
$permiso_ver_suplentes = 0;
}

$menu='
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>
    <td width="9%" ><table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'" style="cursor:pointer">Menu SGPA</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">2</div></td>
          <td class="fondo_2" onclick="taer_menu(\'menu-tarifas.html\',\'contenido_menu\')" style="cursor:pointer">Buscador por contratos</td>
        </tr>
		
		</table></td>
  </tr>
 </table>
<br>
<table width="187" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td class="fondo_2">Acciones permitidas</td>
  </tr>
  <tr>
    <td >
	 <ul class="menu_lista">';

       	if( ($sql_con[1]==1) or ($sql_con[1]==2 ) && ($permiso_creacion_tarifas==1) ){
		    $menu.='<li>Administrar tarifas
              <ul  class="menu_lista_sub">
                <li onclick="ajax_carga(\'../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Configuraci&oacute;n listas</li>
                <li onclick="ajax_carga(\'../aplicaciones/tarifas/c_tarifas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Crear tarifas manualmente</li>
                <li onclick="ajax_carga(\'../aplicaciones/tarifas/c_tarifas_masivas.php?id_contrato='.$id_contrato.'&yy=1\',\'carga_acciones_permitidas\')" style="cursor:pointer">Crear tarifas masivamente</li>
                <li onclick="ajax_carga(\'../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato='.$id_contrato.'&yy=1\',\'carga_acciones_permitidas\')" style="cursor:pointer">Modificar tarifas</li>             
                          
             
             </ul>
            </li>';
			}
			
			if($permiso_ver_tarifas==1)
            $menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/h_tarifas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Consulta de Tarifas Vigentes</li>';
		   
		   
		   if( ($sql_con[1]==3) && ($permiso_ver_aprobaciones==1))
			   $menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/c_aprobaciones.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Pendientes de su Aprobaci&oacute;n</li>';
		  
		   if( ($sql_con[1]==3 or $sql_con[1]==6) && ($permiso_ver_histo_aprobaciones==1) )
			   $menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/h_aprobaciones.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Consulta Estado de Tarifas</li>';
			
	       	if($permiso_creacion_tarifas==1) {
            $menu.='
            <li onclick="ajax_carga(\'../aplicaciones/tarifas/c_descuentos.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Admin. descuentos pactados</li>
			<li onclick="ajax_carga(\'../aplicaciones/tarifas/c_reembolsables.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Admin. reembolsables</li>
			<li onclick="ajax_carga(\'../aplicaciones/tarifas/c_ipc.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Admin. IPC</li>
			<li onclick="ajax_carga(\'../aplicaciones/tarifas/c_aiu.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Admin. AIU</li>
			<li onclick="ajax_carga(\'../aplicaciones/tarifas/c_convencion.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Admin. Convenci&oacute;n</li>';

}
			 
		   if($permiso_ver_suplentes==1)
			   $menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/c_suplentes.php?id_contrato='.$id_contrato.'&yy=1\',\'carga_acciones_permitidas\')" style="cursor:pointer">Visualizaci&oacute;n de Reemplazos</li> ';

			 
	  // if($activa_permiso_aprobacion==1){
		  
		     if( ($sql_con[1]==3) && ($permiso_ver_tiquetes==1) )
			   $menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/h_prefactura_prove.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Reporte de Tiquetes</li>';
			   
			   
			 if( ($sql_con[1]==3) && ($permiso_ver_reembolsables==1) ){
			   $menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/h_reembolsables_contrato_reporte.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Reporte de Reembolsable</li>';
			   
			 }
			 $menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/h_tarifas_mas_usadas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Reporte de Tarifas Usadas</li>';
			 
			 $sel_area_permitida = traer_fila_row(query_db("select count(*) from tseg3_usuario_areas where id_usuario = ".$_SESSION["id_us_session"]." and id_area in (4, 62)"));

			$sel_area_permitida = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (1, 2, 6, 13, 17, 30)"));

		if($_SESSION["id_us_session"] == 32 or $_SESSION["id_us_session"] == 21107 or $_SESSION["id_us_session"] == 17968 or $sel_area_permitida[0] > 0 )	 {
$menu.='<li onclick="ajax_carga(\'../aplicaciones/tarifas/h_variacion_tarifas.php?id_contrato='.$id_contrato.'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Reporte de Variaci&oacute;n de Tarifas</li>';
		}
		//   }
		   
  $menu.='</td>
  </tr>

</table>';

$modulo="MODULO: TARIFAS <span class='sub_titulos_modulos_2'></span>";	
if($apro_pasa==1)
$alertas="../aplicaciones/tarifas/c_aprobaciones.php?id_contrato=".$id_contrato;
else
$alertas="../aplicaciones/tarifas/v_contratos.php?id_contrato=".$id_contrato;
	
	echo $menu."$$".$modulo."$$".$alertas;
?>