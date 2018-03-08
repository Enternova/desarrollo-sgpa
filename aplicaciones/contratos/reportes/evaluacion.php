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
	
	if($tipo_contrato_bu!="0"){
		$query_comple = $query_comple." and t1_tipo_documento_id =".$tipo_contrato_bu."";
	}
	
	if($aplica_portales_bu!="0" and $aplica_portales_bu!=""){
		$query_comple = $query_comple." and aplica_portales =".$aplica_portales_bu."";
	}
	
	if($destino_bu!="0" and $destino_bu!=""){
		$query_comple = $query_comple." and destino_id =".$destino_bu."";
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
	
	if($gerente_bu!=""){
		$explode = explode("----,",elimina_comillas_2($gerente_bu));
		$id_gerente = $explode[1];
		$query_comple = $query_comple." and gerente = ".$id_gerente;
	}
	
	if($estado_bu!="0" and $estado_bu!=""){
		$query_comple = $query_comple." and estado = ".$estado_bu;
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

	$permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
	$permisos = $permisos.$query_comple ;
	$permisos = str_replace("especialista","especialista_id",$permisos);
	$permisos = str_replace("gerente","gerente_id",$permisos);
	$permisos = str_replace("contratista","contratista_id",$permisos);
	if($query_env<>""){
		$permisos  = $query_env;
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

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
	<?
  	if($xls!=1){
  	?>
<tr>
 
<td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td colspan="2" align="center">

   <A href="javascript:document.location.target='_blank'; document.location.href='../aplicaciones/contratos/reportes/evaluacion.php?xls=1&paginas='+this.value+'&contrato_bu='+document.principal.contrato_bu.value+'&  contratista_bu='+document.principal.contratista_bu.value+'&especialista_bu='+document.principal.especialista_bu.value+'&objeto_bu='+document.principal.objeto_bu.value+'&gerente_bu='+document.principal.gerente_bu.value+'&estado_bu='+document.principal.estado_bu.value+'&tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value">Exportar a Excel</A>
 
 </td>
  </tr>
  <?
  }
 ?>
<tr >
	<td width="7%" align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero Contrato</td>
	<td width="14%" align="center" class="columna_subtitulo_resultados_oscuro">Gerente</td>
	<td width="14%" align="center" class="columna_subtitulo_resultados_oscuro">Proveedor</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Inicio Vigencia</td>
	<td width="11%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Terminacion Vigencia</td>
	<td width="9%" align="center" class="columna_subtitulo_resultados_oscuro"># Evaluaciones al contrato</td>
	<td width="9%" align="center" class="columna_subtitulo_resultados_oscuro"># Evaluaciones Estimadas</td>
    <td width="26%" align="center" class="columna_subtitulo_resultados_oscuro">Pendientes</td>
</tr>
<?
	$query_create = "CREATE TABLE #t7_contratos_evaluaciones (id int,consecutivo varchar(50),gerente varchar(100),proveedor varchar(100),fecha_inicio varchar(100),fecha_terminacion varchar(100),evaluaciones varchar(100),evaluaciones_estimadas varchar(100),pendiente varchar(100))";
	$sql_contrato=query_db($query_create);
		
	
	$busca_reportes = "select vc.id,vc.id_item,vc.consecutivo,vc.apellido,vc.t1_tipo_documento_id,vc.objeto,vc.contratista_id,vc.contratista_nit,vc.contratista_digito,vc.contratista,vc.gerente_id,vc.gerente,vc.especialista_id,vc.especialista,vc.fecha_inicio,vc.vigencia_mes,vc.aplica_acta_inicio,vc.representante_legal,vc.estado,(select sum(CAST(tiempo AS int)) as suma_tiempo from $co4 where id_contrato = vc.id group by id_contrato) as modificaciones_mes,(select COUNT(*) from $ev8 where id_contrato = vc.id and t8_evaluador_contrato.estado=1) as numero_evaluaciones,vc.creacion_sistema from $v_contra2 vc where (analista_deloitte <> 1 or analista_deloitte IS NULL) $permisos order by vc.id";

	$sql_re = query_db($busca_reportes);
	while($ls_re=traer_fila_row($sql_re)){
		$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$ls_re[21]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $ls_re[2];//consecutivo
		$numero_contrato4 = $ls_re[3];//apellido
		$numero_contrato_fin = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
		
		$meses = 0;
		$meses = $ls_re[15]+$ls_re[19];
		
		$fecha_terminacion = "";
		$fecha_terminacion = dameFecha($ls_re[14],$meses);

		
		$fecha_incio = $ls_re[14];

		
		$segundos=strtotime($fecha_terminacion) - strtotime($fecha_incio);
		$diferencia_dias=intval($segundos/60/60/24/30);
		
		$evaluaciones_estimadas = floor($diferencia_dias/6);
		
		//echo $numero_contrato_fin." ".$fecha_incio." ".$fecha_terminacion." ".$diferencia_dias." ".$evaluaciones_estimadas."<br>"; 
		$dif_eva_pem = 0;
		$men_pen = "";
		if($ls_re[20]<$evaluaciones_estimadas){
			$dif_eva_pem = $evaluaciones_estimadas - $ls_re[20];
			$men_pen = $dif_eva_pem." Evaluaciones Parciales";
		}
		
		$query_create_int = "insert into #t7_contratos_evaluaciones values (".$ls_re[0].",'".$numero_contrato_fin."','".$ls_re[11]."','".$ls_re[9]."','".$fecha_incio."','".$fecha_terminacion."','".$ls_re[20]."','".$evaluaciones_estimadas."','".$men_pen."')";
		$sql_contrato_int=query_db($query_create_int);
	}
	
	$busca_reportes_tem = "select * from #t7_contratos_evaluaciones";
	$sql_re = query_db($busca_reportes_tem);
	while($ls_re=traer_fila_row($sql_re)){
		?>
		<tr>
		  <td><?=$ls_re[1]?></td>
		  <td><?=$ls_re[2]?></td>
		  <td><?=$ls_re[3]?></td>
          <td><?=$ls_re[4]?></td>
		  <td><?=$ls_re[5]?></td>
		  <td><?=$ls_re[6]?></td>
          <td><?=$ls_re[7]?></td>
   		  <td><?=$ls_re[8]?></td>
		</tr>
		<?
	}
?>
</table>
<?
if($xls==1){
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Evaluaciones Contratos.xls"); 
}
?>