<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id));
	$id_complemento = elimina_comillas(arreglo_recibe_variables($id_complemento));
	


					$sel_presu = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido,t1_tipo_documento_id, t1_tipo_documento_id, gerente, id from $co1 where id = $id_contrato_arr"));
					$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
					$separa_fecha_crea = explode("-",$sel_presu[0]);//fecha_creacion
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_presu[1];//consecutivo
					$numero_contrato4 = $sel_presu[2];//apellido
					$numero_contrato_final = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_presu[6]);	
					$t1_tipo_documento_id = $sel_presu[3];
					$busca_tarifas = "select tarifas_contrato_id from $t1 where id_contrato =  ".$id_contrato_arr;
					$sql_tarif=traer_fila_row(query_db($busca_tarifas));
					$id_tarifas=$sql_tarif[0];
	

/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sqlAdminContratos = traer_fila_row(query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]." and usuario_gerente =".$sel_presu[5]));
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

		

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
						<li onclick="ajax_carga(\'../aplicaciones/contratos/v_contratos.php?id='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Informaci&oacute;n General</li>
						
						<li onclick="ajax_carga(\'../aplicaciones/contratos/c_poliza.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">P&oacute;lizas</li>
						
						<li onclick="ajax_carga(\'../aplicaciones/contratos/h_complemento.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Eventos al Contrato</li>
						
						<li onclick="ajax_carga(\'../aplicaciones/tarifas/h_tarifas.php?id_contrato='.arreglo_pasa_variables($id_tarifas).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Tarifas</li>
						
						<li onclick="ajax_carga(\'../aplicaciones/contratos/contacto.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Contactos</li>
						
						<li onclick="ajax_carga(\'../aplicaciones/contratos/documento.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Documentaci&oacute;n</li>';
						
						
						$menu.='<li onclick="ajax_carga(\'../aplicaciones/contratos/h_plantilla.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Crear Plantilla Evaluaci&oacute;n</li>
						<li onclick="ajax_carga(\'../aplicaciones/contratos/h_evaluacion.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Hist&oacute;rico Evaluaciones</li>
						<li onclick="ajax_carga(\'aa.php\',\'carga_acciones_permitidas\')">Templates</li>';
						
						
						if($t1_tipo_documento_id==1){
							$menu=$menu.'<li onclick="ajax_carga(\'../aplicaciones/contratos/informacion_sap.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')"  style="cursor:pointer">Ejecuci&oacute;n</li>';
						}
						
						
						
						if($t1_tipo_documento_id==2){
							$menu=$menu.'<li onclick="window.parent.document.getElementById(\'div_carga_busca_sol\').style.display=\'block\';ajax_carga(\'../aplicaciones/reportes/lista_reporte_saldos.php?id_contrato='.$id_contrato_arr.'\',\'div_carga_busca_sol\')"  style="cursor:pointer">Ver reporte contrato marco</li>';
							$menu=$menu.'<li onclick="ajax_carga(\'../aplicaciones/contratos/contrato_area.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')" style="cursor:pointer">Asignaci&oacute;n de Areas a Este Contrato</li>';
						}
						if($sel_presu[4]==1){
						$menu=$menu.'<li onclick="ajax_carga(\'../aplicaciones/contratos/resumen.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')"  style="cursor:pointer">Res&uacute;men</li>';
						}
						
						if($sqlAdminContratos[0]>0 or $_SESSION["id_us_session"]==32){
						$menu=$menu.'<li onclick="ajax_carga(\'../aplicaciones/contratos/admin_contratos.php?id_contrato='.arreglo_pasa_variables($id_contrato_arr).'\',\'carga_acciones_permitidas\')"  style="cursor:pointer">Administración de este proceso</li>';
						}
					$menu=$menu.'</ul>
				</td>               
              </tr>
          </table>';

$modulo="Sistema de gesti&oacute;n y planeaci&oacute;n de abastecimiento SGPA<div >MODULO: CONTRATOS </div>";	
if($id_complemento != 0 and $id_complemento != ""){
	$alertas="../aplicaciones/contratos/c_complemento.php?id=".arreglo_pasa_variables($id_contrato_arr)."&id_complemento=".$id_complemento;//variable DA solo biene con 1 cuando viene del inbox de legal abastecimiento
	
	}else{	
	$alertas="../aplicaciones/contratos/v_contratos.php?id=".arreglo_pasa_variables($id_contrato_arr)."&aplica_log=1&da=".$_GET["da"];//variable DA solo biene con 1 cuando viene del inbox de legal abastecimiento
	}
	
	echo $menu."$$".$modulo."$$".$alertas;
?>