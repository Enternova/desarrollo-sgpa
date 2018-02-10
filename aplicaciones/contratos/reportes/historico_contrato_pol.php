<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	
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
	
	if($tipo_contrato_bu!="0"){
		$query_comple = $query_comple." and t1_tipo_documento_id =".$tipo_contrato_bu."";
	}
	
	if($aplica_portales_bu!="0" and $aplica_portales_bu!=""){
		$query_comple = $query_comple." and aplica_portales =".$aplica_portales_bu."";
	}
	
	if($destino_bu!="0" and $destino_bu!=""){
		$query_comple = $query_comple." and destino_id =".$destino_bu."";
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
	
	if($gerente_bu!=""){
		$explode = explode("----,",elimina_comillas_2($gerente_bu));
		$id_gerente = $explode[1];
		$query_comple = $query_comple." and gerente = ".$id_gerente;
	}
	
	if($estado_bu!="0" and $estado_bu!=""){
		if($estado_bu==$est_firma_hocol or $estado_bu==$est_firma_contratista){
			if($estado_bu==$est_firma_hocol){
				$query_comple = $query_comple." and (estado in (".$est_firma_hocol.") and sel_representante = 2 or estado in (".$est_firma_contratista.") and sel_representante = 1)";
			}
			if($estado_bu==$est_firma_contratista){
				$query_comple = $query_comple." and (estado in (".$est_firma_hocol.") and sel_representante = 1 or estado in (".$est_firma_contratista.") and sel_representante = 2)";
			}
			
			
		}else{
			if($estado_bu==101){
				$query_comple = $query_comple." and estado in (".$est_abastecimiento.",".$est_sap.",".$est_revision.",".$est_firma_hocol.",".$est_firma_contratista.",".$est_poliza.",".$est_gerente_contrato.",".$est_legalizacion.")";
			}else{
				$query_comple = $query_comple." and estado = ".$estado_bu;	
			}
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
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 1px solid;  BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  cursor:pointer;
 }
</style>
<?
	$tam_border = 0;
  	if($xls==1){
			$tam_border = 1;
	}
  	?>
<table width="100%" border="<?=$tam_border;?>" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">

<?
  	if($xls!=1){
  	?>
<tr>
 
<td colspan="5" align="left"> <A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/contratos/reportes/historico_contrato_pol.php?xls=1&paginas='+this.value+'&contrato_bu='+document.principal.contrato_bu.value+'&  contratista_bu='+document.principal.contratista_bu.value+'&especialista_bu='+document.principal.especialista_bu.value+'&objeto_bu='+document.principal.objeto_bu.value+'&gerente_bu='+document.principal.gerente_bu.value+'&estado_bu='+document.principal.estado_bu.value+'&tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value+'&vigencia_bu='+document.principal.vigencia_bu.value">Exportar a Excel</A></td>
<td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td colspan="3" align="right">
    
    </td>
  </tr>
  <?
  }
 ?>
  <tr >
    <td width="6%" rowspan="2" align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero Contrato</td>
    <td width="9%" rowspan="2" align="center" class="columna_subtitulo_resultados_oscuro">Objeto</td>
    <td width="19%" rowspan="2" align="center" class="columna_subtitulo_resultados_oscuro">Proveedor</td>
    <td width="20%" rowspan="2" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Inicio</td>
        <td width="20%" rowspan="2" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Fin</td>
    <?
    $sel_toda_poliza = "select nombre from $g7 where estado = 1 order by orden";
	$sql_sel_toda_poliza = query_db($sel_toda_poliza);
	while($ls_tpoliza=traer_fila_row($sql_sel_toda_poliza)){
	?>
    <td colspan="3" align="center" class="columna_subtitulo_resultados_oscuro"><?=$ls_tpoliza[0];?></td>
    <?
	}
	?>
  </tr>
  <tr >
   <?
    $sel_toda_poliza = "select nombre from $g7 where estado = 1 order by orden";
	$sql_sel_toda_poliza = query_db($sel_toda_poliza);
	while($ls_tpoliza=traer_fila_row($sql_sel_toda_poliza)){
	?>
    <td width="3%" align="center" class="columna_subtitulo_resultados_oscuro">Aplica</td>
	<td width="9%" align="center" class="columna_subtitulo_resultados_oscuro">fecha expira poliza</td>
	<td width="14%" align="center" class="columna_subtitulo_resultados_oscuro">aseguradora</td>
    <?
	}
	?>
</tr>
<?
	$permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
	$permisos = $permisos.$query_comple ;
	$permisos = str_replace("especialista","especialista_id",$permisos);
	$permisos = str_replace("gerente","gerente_id",$permisos);
	$permisos = str_replace("contratista","contratista_id",$permisos);
	
	$busca_reportes = "select vc.id,vc.id_item,vc.consecutivo,vc.apellido,vc.t1_tipo_documento_id,vc.objeto,vc.contratista_id,vc.contratista_nit,vc.contratista_digito,vc.contratista,vc.contacto_principal,vc.email1,vc.email2,vc.telefono1,vc.telefono2,vc.gerente_id,vc.gerente,vc.especialista_id,vc.especialista,vc.fecha_inicio,vc.vigencia_mes,vc.aplica_acta_inicio,vc.representante_legal,vc.monto_usd,vc.monto_cop,vc.acta_socios,vc.recibido_poliza,vc.camara_comercio,vc.aplica_acta,vc.ok_fecha,vc.recibo_poliza,vc.sel_representante,vc.creacion_sistema,vc.recibido_abastecimiento,vc.sap_e,vc.sap,vc.revision_legal_e,vc.revision_legal,vc.firma_hocol_e,vc.firma_hocol,vc.firma_contratista_e,vc.firma_contratista,vc.revision_poliza_e,vc.revision_poliza,vc.legalizacion_final_e,vc.legalizacion_final,vc.legalizacion_final_par_e,vc.legalizacion_final_par,vc.fecha_informativa_e,vc.fecha_informativa,vc.estado from $v_contra2 vc where (analista_deloitte <> 1 or analista_deloitte IS NULL) $permisos order by vc.id";

	$sql_re = query_db($busca_reportes);
	while($ls_re=traer_fila_row($sql_re)){
		?>
		<tr>
		  <td>
          <?
          $numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$ls_re[32]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $ls_re[2];//consecutivo
		$numero_contrato4 = $ls_re[3];//apellido
		//echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
		  ?>
          </td>
		  <td><?=$ls_re[5]?></td>
		  
		  <td><?=$ls_re[9]?></td>
		  <td><?=$ls_re[19]?></td>
          <td><?=$ls_re[20]?></td>
          
          	<?
			$sel_toda_poliza = "select id from $g7 where estado = 1 order by orden";
			$sql_sel_toda_poliza = query_db($sel_toda_poliza);
			while($ls_tpoliza=traer_fila_row($sql_sel_toda_poliza)){
				$sel_poliza_aplica = "select id_contrato from $co2 WHERE id_contrato = ".$ls_re[0]." and id_poliza =".$ls_tpoliza[0];
				$sql_poliza_aplica=traer_fila_row(query_db($sel_poliza_aplica));
				$aplica = "";
				if($sql_poliza_aplica[0]>0){
					$aplica = "X";
				}
				?>
		  <td><?=$aplica?></td>
				<?
				$sel_poliza = "select $co3.fecha_fin,$g23.nombre,$co3.tipo_aseguradora,$co3.aseguradora from $co3
	left join $g23 on $co3.tipo_aseguradora =$g23.id WHERE id_contrato = ".$ls_re[0]." and $co3.tipo_poliza = ".$ls_tpoliza[0]." order by fecha_fin desc";
				$sql_contrato_apli=traer_fila_row(query_db($sel_poliza));
				$otro_ase="";
				if($sql_contrato_apli[2]==5){
					$otro_ase="/".$sql_contrato_apli[3];
				}
				?>
				<td><?=$sql_contrato_apli[0]?></td>				
				<td><?=$sql_contrato_apli[1].$otro_ase?></td>
			<?
			}
			?>
                     
		</tr>
		<?
	}
?>
</table>
<?
if($xls==1){
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Polizas.xls"); 
}
?>
