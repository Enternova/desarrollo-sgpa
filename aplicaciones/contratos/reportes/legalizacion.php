<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
		
	$si_muestra_contrato = 1;
	$si_muestra_otrosi = 1;
	$si_muestra_orden_trabajo = 2;
	

	if($c_contrato=="false"){
		$si_muestra_contrato = 0;
	}
	
	if($c_otrosi=="false"){
		$si_muestra_otrosi = 0;
	}

	if($c_orden_trabajo=="false"){
		$si_muestra_orden_trabajo = 0;
	}

	function valida_muestra_contrato_reporte($estado,$estado_bu){
		if($estado_bu=="1"){
			$estado_bu_tex = "Elaboracion de contrato";
		}
		if($estado_bu=="2"){
			$estado_bu_tex = "Recibido Abastecimiento";
		}
		if($estado_bu=="3"){
			$estado_bu_tex = "SAP";
		}
		if($estado_bu=="4"){
			$estado_bu_tex = "Revision Legal";
		}
		if($estado_bu=="5"){
			$estado_bu_tex = "Firma Representante Hocol";
		}
		if($estado_bu=="6"){
			$estado_bu_tex = "Firma Representante Contratista";
		}
		if($estado_bu=="7"){
			$estado_bu_tex = "Revison Polizas";
		}
		if($estado_bu=="8"){
			$estado_bu_tex = "Gerente Contrato";
		}
		if($estado_bu=="9"){
			$estado_bu_tex = "Legalizacion Final Contrato";
		}
		if($estado_bu=="10"){
			$estado_bu_tex = "Legalizado";
		}

		if($estado_bu==101){
			if ($estado!="Elaboracion de contrato" and $estado!="Legalizado"){
				return true;
			}else{
				return false;
			}
		}else{
			//echo $estado." ".$estado_bu_tex;			
			if ($estado==$estado_bu_tex){
				return true;
			}else{
				if($estado_bu=="0"){
					return true;					
				}else{
					return false;
				}
			}
			
		}		
	}
	
	
	$query_comple = "";
	
	if($contratista_bu!=""){
		$explode = explode("----,",elimina_comillas_2($contratista_bu));
		$id_contratista = $explode[1];
		$query_comple = $query_comple." and contratista = ".$id_contratista;
	}
	
	if($especialista_bu!=""){
		$explode = explode("----,",elimina_comillas_2($especialista_bu));
		$id_especialista = $explode[1];
		$query_comple = $query_comple." and especialista = ".$id_especialista;
	}
	
	if($objeto_bu!=""){
		$query_comple = $query_comple." and objeto like '%".$objeto_bu."%'";
	}
	
	if($vigencia_bu!="0"){
		$fecha_hoy = getdate();
		if($vigencia_bu==1){
			$query_comple = $query_comple." and vc.vigencia_mes >='".$fecha_hoy["year"]."-".$fecha_hoy["mon"]."-".$fecha_hoy["mday"]."'";
		}
		if($vigencia_bu==2){
			$query_comple = $query_comple." and vc.vigencia_mes <'".$fecha_hoy["year"]."-".$fecha_hoy["mon"]."-".$fecha_hoy["mday"]."'";
		}
	}
	
	if($tipo_contrato_bu!="0"){
		$query_comple = $query_comple." and t1_tipo_documento_id =".$tipo_contrato_bu."";
	}
	if($aplica_portales_bu!="0" and $aplica_portales_bu!=""){
		$query_comple = $query_comple." and aplica_portales =".$aplica_portales_bu."";
	}
	
	if($destino_bu!="0" and $destino_bu!=""){
		$query_comple = $query_comple." and destino_id =".$destino_bu."";
	}
	if($gerente_bu!=""){
		$explode = explode("----,",elimina_comillas_2($gerente_bu));
		$id_gerente = $explode[1];
		$query_comple = $query_comple." and gerente = ".$id_gerente;
	}
	
	if($estado_bu!="0" and $estado_bu!=""){
		
		if($estado_bu==$est_firma_hocol or $estado_bu==$est_firma_contratista){
			if($estado_bu==$est_firma_hocol){
				$query_comple_es = $query_comple_es." and (vc.estado in (".$est_firma_hocol.") and sel_representante = 2 or estado in (".$est_firma_contratista.") and sel_representante = 1)";
			}
			if($estado_bu==$est_firma_contratista){
				$query_comple_es = $query_comple_es." and (vc.estado in (".$est_firma_hocol.") and sel_representante = 1 or estado in (".$est_firma_contratista.") and sel_representante = 2)";
			}
			
			
		}else{
			if($estado_bu==101){
				$query_comple_es = $query_comple_es." and vc.estado in (".$est_abastecimiento.",".$est_sap.",".$est_revision.",".$est_firma_hocol.",".$est_firma_contratista.",".$est_poliza.",".$est_gerente_contrato.",".$est_legalizacion.")";
			}else{
				$query_comple_es = $query_comple_es." and vc.estado = ".$estado_bu;	
			}
		}
		
	}
	
	$query_comple_es_int = "";
	if($si_muestra_contrato==0){
		$query_comple_es_int = $query_comple_es;
		$query_comple_es = "";
	}else{
		if($si_muestra_otrosi==1 or $si_muestra_orden_trabajo==2){
			$query_comple_es_int = $query_comple_es;
			$query_comple_es = "  and vc.estado = 10 ";
		}
	}
	$query_comple_temp="";
	if($contrato_bu!=""){
		$contrato_bu2 = str_replace("-","",$contrato_bu);
		$contrato_bu2 = str_replace(" ","",$contrato_bu2);
		
		$query_comple_temp = $query_comple_temp." and (consecutivo like '%".$contrato_bu2."%')";
		
		$query_create = "CREATE TABLE #t7_contratos_contrato_temp (id int, consecutivo varchar(50))";
		$sql_contrato=query_db($query_create);
		
		$lista_contrato = "select * from $co1 where estado >= 1".$query_comple.$permisos;
		$sql_contrato=query_db($lista_contrato);
		while($rs_array=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$rs_array[19]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $rs_array[2];//consecutivo
			$numero_contrato4 = $rs_array[43];//apellido
			$numero_contrato_fin = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
			$numero_contrato_fin = str_replace("-","",$numero_contrato_fin);
			$numero_contrato_fin = str_replace(" ","",$numero_contrato_fin);
			
			//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
			$query_create_int = "insert into #t7_contratos_contrato_temp values (".$rs_array[0].",'".$numero_contrato_fin."')";
			$sql_contrato_int=query_db($query_create_int);
		}
		
		$lista_contrato_temp = "select * from #t7_contratos_contrato_temp where id > 0 ".$query_comple_temp;
		$sql_contrato_temp=query_db($lista_contrato_temp);
		
		$array_id_bu = "0";
		while($rs_array_temp=traer_fila_row($sql_contrato_temp)){
			$array_id_bu =  $array_id_bu.",".$rs_array_temp[0];
		}
		
		$query_comple = $query_comple." and id in (".$array_id_bu.")";
	}
	
	
?>
<style>
.columna_subtitulo_resultados_oscuro{ height:20px;font-size:14px; color:#FFF; 
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#666 }
 .tabla_lista_resultados{  margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  cursor:pointer;
 }
</style>
<table width="2000" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<?
  	if($xls!=1){
  	?>
<tr>
 
<td colspan="18" align="left">
  
  <A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/contratos/reportes/legalizacion.php?xls=1&paginas='+this.value+'&contrato_bu='+document.principal.contrato_bu.value+'&  contratista_bu='+document.principal.contratista_bu.value+'&especialista_bu='+document.principal.especialista_bu.value+'&objeto_bu='+document.principal.objeto_bu.value+'&gerente_bu='+document.principal.gerente_bu.value+'&estado_bu='+document.principal.estado_bu.value+'&c_contrato='+document.principal.c_contrato.checked+'&c_otrosi='+document.principal.c_otrosi.checked+'&c_orden_trabajo='+document.principal.c_orden_trabajo.checked+'&tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value+'&vigencia_bu='+document.principal.vigencia_bu.value">Exportar a Excel</A></td>
</tr>
  <?
  }
 ?>
<tr >
	<td width="3%" align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero Contrato</td>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Creacion</td>
	<td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Entrega de Recibido abastecimiento </td>
	<td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Area Ejecucion</td>
	<td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Aplica Portales</td>
	<td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Destino</td>
    <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Aseguramiento Administrativo</td>
	<td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Tipo Modificaciones</td>
	<td width="4%" align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero Modificacion</td>
	<td width="7%" align="center" class="columna_subtitulo_resultados_oscuro">Gerente</td>
	<td width="9%" align="center" class="columna_subtitulo_resultados_oscuro">Proveedor</td>
	<td width="7%" align="center" class="columna_subtitulo_resultados_oscuro">Especialista</td>
	<td width="8%" align="center" class="columna_subtitulo_resultados_oscuro">Estado Actual</td>
	<td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Entrega Estado Actual</td>
	<td width="12%" align="center" class="columna_subtitulo_resultados_oscuro">Observaci&oacute;n Estado Actual</td>
	<td width="7%" align="center" class="columna_subtitulo_resultados_oscuro"><p>Estado Anterior</p></td>
	<td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha  Estado Anterior</td>
	<td width="12%" align="center" class="columna_subtitulo_resultados_oscuro">Observaci&oacute;n Estado Anterior</td>
  </tr>
<?
	$permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
	$permisos = $permisos.$query_comple ;
	$permisos = str_replace("especialista","especialista_id",$permisos);
	$permisos = str_replace("gerente","gerente_id",$permisos);
	$permisos = str_replace("contratista","contratista_id",$permisos);
	
	$busca_reportes = "select vc.id,vc.id_item,vc.consecutivo,vc.apellido,vc.t1_tipo_documento_id,vc.objeto,vc.contratista_id,vc.contratista_nit,vc.contratista_digito,vc.contratista,vc.contacto_principal,vc.email1,vc.email2,vc.telefono1,vc.telefono2,vc.gerente_id,vc.gerente,vc.especialista_id,vc.especialista,vc.fecha_inicio,vc.vigencia_mes,vc.aplica_acta_inicio,vc.representante_legal,vc.monto_usd,vc.monto_cop,vc.acta_socios,vc.recibido_poliza,vc.camara_comercio,vc.aplica_acta,vc.ok_fecha,vc.recibo_poliza,vc.sel_representante,vc.creacion_sistema,vc.recibido_abastecimiento,vc.sap_e,vc.sap,vc.revision_legal_e,vc.revision_legal,vc.firma_hocol_e,vc.firma_hocol,vc.firma_contratista_e,vc.firma_contratista,vc.revision_poliza_e,vc.revision_poliza,vc.legalizacion_final_e,vc.legalizacion_final,vc.legalizacion_final_par_e,vc.legalizacion_final_par,vc.fecha_informativa_e,vc.fecha_informativa,vc.estado ,vc.recibido_abastecimiento_e,vc.area_ejecucion,vc.aplica_portales,vc.destino,aseguramiento_admin from $v_contra2 vc where estado <> 0  and (analista_deloitte <> 1 or analista_deloitte IS NULL) $permisos $query_comple_es order by vc.id";

	$sql_re = query_db($busca_reportes);
	while($ls_re=traer_fila_row($sql_re)){
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$ls_re[32]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $ls_re[2];//consecutivo
		$numero_contrato4 = $ls_re[3];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		?>
		<?
        if($si_muestra_contrato == 1 and valida_muestra_contrato_reporte(estado_contrato_retu(arreglo_pasa_variables($ls_re[0]),$co1),$estado_bu)){
		?>
        <tr>
		  <td>
			  <?                
                echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
              ?>
          </td>
		  <td><?=$ls_re[32]?></td>
		  <td><?=$ls_re[51]?></td>
		  <td><?=$ls_re[52]?></td>
		  <td>
		  <?
		  if($ls_re[53]==1)
		  	echo "SI";
		if($ls_re[53]==2)
		  	echo "NO";
		  ?>
          </td>
		  <td><?=$ls_re[54]?></td>
          <td><?=$ls_re[55]?></td>
		  <td></td>
		  <td></td>
		  <td><?=$ls_re[16]?></td>
		  <td><?=$ls_re[9]?></td>
		  <td><?=$ls_re[18]?></td>
		  <td><?=estado_contrato_retu(arreglo_pasa_variables($ls_re[0]),$co1);?></td>
		  <td><?=fecha_estado($co1,$ls_re[0]);?></td>
		  <td><?=imprime_observacion(arreglo_pasa_variables($ls_re[0]),arreglo_pasa_variables(0),estado_contrato_retu_campo(arreglo_pasa_variables($ls_re[0]),$co1));
		  
		  ?></td>
		  <td><?=estado_contrato_anterior(arreglo_pasa_variables($ls_re[0]),$co1);?></td>
		  <td><?=fecha_estado_anterior($co1,$ls_re[0]);?></td>
		  <td><?=imprime_observacion(arreglo_pasa_variables($ls_re[0]),arreglo_pasa_variables(0),estado_contrato_retu_campo_anterior(arreglo_pasa_variables($ls_re[0]),$co1));
		  
		  ?></td>
		</tr>
        <?
		}
		?>
        <?
		
		$busca_modificaciones = "select vc.id,t1_tc.nombre,vc.numero_otrosi,vc.creacion_sistema,vc.recibido_abastecimiento_e from ".$co4." vc left join ".$g8." t1_tc on vc.tipo_complemento = t1_tc.id where eliminado = 0 and (vc.congelado <> 1 or vc.congelado IS NULL) and vc.id_contrato=".$ls_re[0]." and vc.tipo_complemento in (".$si_muestra_otrosi.",".$si_muestra_orden_trabajo.") $query_comple_es_int order by vc.id";
		$sql_modi = query_db($busca_modificaciones);
		while($ls_mo=traer_fila_row($sql_modi)){
			?>
            <tr>
              <td>
               <?                
                echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
              ?>
              </td>
              <td><?=$ls_mo[3]?></td>
              <td><?=$ls_mo[4]?></td>
             <td><?=$ls_re[52]?></td>
             <td><?
		  if($ls_re[53]==1)
		  	echo "SI";
		if($ls_re[53]==2)
		  	echo "NO";
		  ?></td>
             <td><?=$ls_re[54]?></td>
             <td><?=$ls_re[55]?></td>
              <td><?=$ls_mo[1]?></td>
              <td><?=$ls_mo[2]?></td>
              <td><?=$ls_re[16]?></td>
              <td><?=$ls_re[9]?></td>
              <td><?=$ls_re[18]?></td>
              <td><?=estado_contrato_retu(arreglo_pasa_variables($ls_mo[0]),$co4)?></td>
              <td><?=fecha_estado($co4,$ls_mo[0]);?></td>
              <td><?=imprime_observacion(arreglo_pasa_variables($ls_re[0]),arreglo_pasa_variables($ls_mo[0]),estado_contrato_retu_campo(arreglo_pasa_variables($ls_mo[0]),$co4));
              
              ?></td>
              <td><?=estado_contrato_anterior(arreglo_pasa_variables($ls_mo[0]),$co4);?></td>
              <td><?=fecha_estado_anterior($co4,$ls_mo[0]);?></td>
              <td><?=imprime_observacion(arreglo_pasa_variables($ls_re[0]),arreglo_pasa_variables($ls_mo[0]),estado_contrato_retu_campo_anterior(arreglo_pasa_variables($ls_mo[0]),$co4));
              
              ?></td>
            </tr>
            <?
		}
		
				
		?>
		<?
	}
?>
</table>
<?
if($xls==1){
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Legalizacion.xls"); 
}
?>