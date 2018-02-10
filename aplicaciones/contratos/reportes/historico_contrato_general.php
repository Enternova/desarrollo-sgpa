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
	
	if($visualiza_con==1){
		$query_comple = $query_comple." and (gerente in (".$_SESSION["id_us_session"]. "$array_usuario) or especialista in (".$_SESSION["id_us_session"]."$array_usuario)) ";
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
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  cursor:pointer;
 }
 .xl65
	{
	mso-style-parent:style0;
	mso-number-format:"\@";
	}
</style>
<style>
.titulo1 {
	font-size:24px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}
</style>
<table width="5000" border="1">

<?
  	if($xls!=1){
  	?>
<?
  }
 ?>
 
  <?
    if($visualiza_con==1){
		if($tipo_contrato_bu == 1){
			$col = 12;
		}
		if($tipo_contrato_bu == 2){
			$col = 16;
		}
		if($tipo_contrato_bu == 0){
			$col = 18;
		}
	}else{
		$col = 8;
	}
	?>
<tr >
  <td colspan="7" rowspan="3" align="center" >&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
  <td colspan="<?=$col;?>" align="left" class="titulo1"><strong>REPORTE CONTRATOS</strong></td>
</tr>
<tr >
  <td colspan="<?=$col;?>" align="left" ><?=$tipo_contrato_bu?></td>
</tr>
<tr >
  <td colspan="<?=$col;?>" align="center" >&nbsp;</td>
  </tr>
<tr >
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero Contrato</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Solicitud</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Es carga Masiva</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Tipo de Proceso</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Profesional asignado a la solicitud</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Area Usuaria</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Tipo Contrato</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Objeto</td>
	<td width="3%" align="center" class="columna_subtitulo_resultados_oscuro">Gerente</td>
	<td width="4%" align="center" class="columna_subtitulo_resultados_oscuro">Proveedor</td>
	<td width="4%" align="center" class="columna_subtitulo_resultados_oscuro">Especialista</td>
	<td width="3%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Inicio</td>
	<td width="3%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha Fin</td>
    <?
    if($visualiza_con==1){
	?>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Monto USD</td>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Monto COP</td>
    <?
    if($tipo_contrato_bu == 0 || $tipo_contrato_bu == 1){
	?>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Saldo SAP USD<font size="-2">(Aplica Contratos Normales)</font></td>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Saldo SAP COP<font size="-2">(Aplica Contratos Normales)</font></td>
    <?
	}
	?>
    <?
    if($tipo_contrato_bu == 0 || $tipo_contrato_bu == 2){
	?>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Espefico USD<font size="-2">(Aplica Contratos Marco)</font></td>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Espefico COP<font size="-2">(Aplica Contratos Marco)</font></td>
    <td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Espefico Equi.<font size="-2">(Aplica Contratos Marco)</font></td>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Compartido USD<font size="-2">(Aplica Contratos Marco)</font></td>
	<td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Compartido COP<font size="-2">(Aplica Contratos Marco)</font></td>
    <td width="6%" align="center" class="columna_subtitulo_resultados_oscuro">Compartido Equi.<font size="-2">(Aplica Contratos Marco)</font></td>
   	<?
	}
	?>
    <?
	}
	?>
	<td width="3%" align="center" class="columna_subtitulo_resultados_oscuro">Estado</td>
	<td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Observaci&oacute;n</td>
</tr>
<?
	//$permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
	$permisos = $permisos.$query_comple ;
	$permisos = str_replace("especialista","especialista_id",$permisos);
	$permisos = str_replace("gerente","gerente_id",$permisos);
	$permisos = str_replace("contratista","contratista_id",$permisos);
	
	$busca_reportes = "select vc.id,vc.id_item,vc.consecutivo,vc.apellido,vc.t1_tipo_documento_id,vc.objeto,vc.contratista_id,vc.contratista_nit,vc.contratista_digito,vc.contratista,vc.contacto_principal,vc.email1,vc.email2,vc.telefono1,vc.telefono2,vc.gerente_id,vc.gerente,vc.especialista_id,vc.especialista,vc.fecha_inicio,vc.vigencia_mes,vc.aplica_acta_inicio,vc.representante_legal,vc.monto_usd,vc.monto_cop,vc.acta_socios,vc.recibido_poliza,vc.camara_comercio,vc.aplica_acta,vc.ok_fecha,vc.recibo_poliza,vc.sel_representante,vc.creacion_sistema,vc.recibido_abastecimiento,vc.sap_e,vc.sap,vc.revision_legal_e,vc.revision_legal,vc.firma_hocol_e,vc.firma_hocol,vc.firma_contratista_e,vc.firma_contratista,vc.revision_poliza_e,vc.revision_poliza,vc.legalizacion_final_e,vc.legalizacion_final,vc.legalizacion_final_par_e,vc.legalizacion_final_par,vc.fecha_informativa_e,vc.fecha_informativa,vc.estado, num1, num2, num3, tipo_proceso, area_usuaria, profesional, de_historico from $v_contra2 vc where (analista_deloitte <> 1 or analista_deloitte IS NULL) $permisos order by vc.id";
	

	$sql_re = query_db($busca_reportes);
	while($ls_re=traer_fila_db($sql_re)){
		
		?>
		<tr>
		  <td align="left">
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
		  <td align="left"><?
          $numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		
			echo numero_item_pecc($ls_re["num1"],$ls_re["num2"],$ls_re["num3"]);
		  ?>
          </td>
		  <td align="left"><?=$ls_re["de_historico"]?></td>
		  <td align="left"><?=$ls_re["tipo_proceso"]?></td>
		  <td align="left"><?=$ls_re["profesional"]?></td>
		  <td align="left"><?=$ls_re["area_usuaria"]?></td>
		  <td align="left">
          <?
           if($ls_re[4]==1){
		 	echo "Normal";
		   }
		   if($ls_re[4]==2){
			echo "Contrato Marco";
		   }
		  ?>
          </td>
		  <td align="left"><?=$ls_re[5]?></td>
		  <td align="left"><?=$ls_re[16]?></td>
		  <td align="left"><?=$ls_re[9]?></td>
		  <td align="left"><?=$ls_re[18]?></td>
		  <td align="left"><?=$ls_re[19]?></td>
		  <td align="left"><?=$ls_re[20]?></td>
          <?
	      if($visualiza_con==1){//mis contratos
		  	$monto_imp1 = str_replace(".00","",$ls_re[23]);
			$monto_imp2 = str_replace(".00","",$ls_re[24]);
		  ?>
		  <td align="left" class="xl65"><?=number_format($monto_imp1,0)?></td>
		  <td align="left" class="xl65"><?=number_format($monto_imp2,0)?></td>
          <?
          if($ls_re[4]==1){
			  	//Inicio Informacion SAP
				$valor_acumulado_usd = 0;
				$valor_acumulado_cop = 0;
				$mes = 0;
				$valor_ejecutado_usd = 0;
				$valor_ejecutado_cop = 0;
				$porcentaje = 0;
		
				$valor_acumulado_usd = $ls_re[23];
				$valor_acumulado_cop = $ls_re[24];
				
				$numero_contrato_fin = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
				$numero_contrato_fin = str_replace("-","",$numero_contrato_fin);
				$numero_contrato_fin = str_replace(" ","",$numero_contrato_fin);
				
				$busca_ejecucion ="select t7e.id,t7e.id_usuario,t7e.fecha,t7e.mes_corte,t7e.estado,t7ej.id,t7ej.id_cargue,t7ej.id_contrato,t7ej.num_contrato,t7ej.por_ejecucion,t7ej.ejecucion_usd,t7ej.ejecucion_cop from $co9 t7e left join $co10 t7ej on t7ej.id_cargue = t7e.id where t7ej.num_contrato = '$numero_contrato_fin' order by t7e.id desc";
				$sql_busca_ejecucion=traer_fila_row(query_db($busca_ejecucion));
				$mes = $sql_busca_ejecucion[3];
				$valor_ejecutado_usd = $sql_busca_ejecucion[10];
				$valor_ejecutado_cop = $sql_busca_ejecucion[11];
				$porcentaje = $sql_busca_ejecucion[9];
				//Fin Informacion SAP
			  ?>
             <?
    		  if($tipo_contrato_bu == 1 || $tipo_contrato_bu == 0){
			  ?>
			  <td align="left" class="xl65"><?=valida_numero_imp($valor_acumulado_usd-$valor_ejecutado_usd);?></td>
			  <td align="left" class="xl65"><?=valida_numero_imp($valor_acumulado_cop-$valor_ejecutado_cop);?></td>
              <?
			  }
    		  if($tipo_contrato_bu == 0){
			  ?>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
			  <?
			  }
		  }
			if($ls_re[4]==2){
			/* VALIDACION DE MARCO*/
				$contrato_aplica=$ls_re[0];
				$id_item_pecc=$ls_re[1];
				$cont = 0;
				$delete = query_db("delete from t2_marco_temporal where id_usuario = ".$_SESSION["id_us_session"]." and id_item = ".$id_item_pecc);
	
	$sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio where id_item =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
	
	while($sel_inio = traer_fila_db($sel_valor_inicial)){
			$eq = $sel_inio[0] + ($sel_inio[1] / $sel_inio[2]);
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_inio[5].", ".$sel_inio[3].", ".$sel_inio[4].", ".$sel_inio[0].", ".$sel_inio[1].", $eq, 'NO', ".$sel_inio[6]." )");
			
		}
	
	
	$ampliacion = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
		  
		  while($sel_ampl = traer_fila_db($ampliacion)){
			  $eq = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
			  $valor_usd_queda_si = 0;
			$valor_cop_queda_si = 0;
			$valor_eq_queda_si =  0;
						
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
						//verifica si ya hay linea en temporal
						$sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
						$sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));
						
							
								$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
								//}
						//fin verifica si ya hay linea en temporal
						
					}else{// ampliaciones presupuesto especifico o no compartido	
					$sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";
					
					$sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
					if($sele_si_ya_tiene_especifico > 0){
						$valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
						$valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
						$valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];
						
						$udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
						}else{
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
					}
			
						}
			  }
	
	/*-------------------------AMPLIACIONES QUE ESTAN EN ESTADO SOCIOS --------------------*/

	$ampliacion_en_socios = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_en_socios where id_item_peec_aplica =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");

		  
		  while($sel_ampl = traer_fila_db($ampliacion_en_socios)){
			  $eq = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
			  $valor_usd_queda_si = 0;
			$valor_cop_queda_si = 0;
			$valor_eq_queda_si =  0;
						
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] > 1){//presupuesto comprtido
						//verifica si ya hay linea en temporal
						$sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'NO'  and id_usuario = ".$_SESSION["id_us_session"]."";
						$sel_temp = traer_fila_row(query_db("select * from t2_marco_temporal $sql_comple "));
													
								$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'NO', ".$sel_ampl[6]." )");
								//}
						//fin verifica si ya hay linea en temporal
						
					}else{// ampliaciones presupuesto especifico o no compartido	
					$sql_comple = "where id_item =".$id_item_pecc." and  id_contrato = ".$sel_ampl[5]." and ano = ".$sel_ampl[3]." and campo = ".$sel_ampl[4]." and especifico = 'SI'  and id_usuario = ".$_SESSION["id_us_session"]."";
					
					$sele_si_ya_tiene_especifico = traer_fila_row(query_db("select secuencia, valor_usd, valor_cop, eq_usd from t2_marco_temporal $sql_comple "));	
					if($sele_si_ya_tiene_especifico > 0){
						$valor_usd_queda_si = $sel_ampl[0] + $sele_si_ya_tiene_especifico[1];
						$valor_cop_queda_si = $sel_ampl[1] + $sele_si_ya_tiene_especifico[2];
						$valor_eq_queda_si =  $eq + $sele_si_ya_tiene_especifico[3];
						
						$udpdate = query_db("update t2_marco_temporal set valor_usd=".$valor_usd_queda_si.", valor_cop=".$valor_cop_queda_si.", eq_usd=".$valor_eq_queda_si." $sql_comple");
						}else{
			$insert_temp = query_db("insert into t2_marco_temporal (id_usuario, id_item, id_contrato, ano, campo, valor_usd, valor_cop, eq_usd, especifico, id_presupuesto) values (".$_SESSION["id_us_session"].", $id_item_pecc, ".$sel_ampl[5].", ".$sel_ampl[3].", ".$sel_ampl[4].", ".$sel_ampl[0].", ".$sel_ampl[1].", $eq, 'SI', 0 )");
					}
			
						}
			  }
	/*-------------------------AMPLIACIONES QUE ESTAN EN ESTADO SOCIOS --------------------*/
	//order de trabajo
	$valor_que_falta_restar = 0;
		$sel_orden = query_db("select * from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc);
		while($or_ot = traer_fila_db($sel_orden)){
			$comple_we = "where  id_item =".$id_item_pecc." and id_contrato = ".$or_ot[8]." and   ano = ".$or_ot[7]." and campo = ".$or_ot[6]." and id_usuario = ".$_SESSION["id_us_session"]."";
			$sel_va_esp = traer_fila_row(query_db("select sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'SI'"));
			
			$valo_solicitado = $or_ot[9];
			$valor_disponible = $sel_va_esp[0];

			if($valo_solicitado > $valor_disponible){// si es menor el disponible que las OTS
					$update = query_db("update t2_marco_temporal set valor_usd = 0, valor_cop = 0, eq_usd = 0 $comple_we  and especifico = 'SI'");
					
					$valo_solicitado = $valo_solicitado - $valor_disponible;
					
						$sel_agrupo_presupuesto = query_db("select id_presupuesto, sum(eq_usd) from t2_marco_temporal $comple_we  and especifico = 'NO' group by id_presupuesto order by id_presupuesto");
					while($sel_presu_ag = traer_fila_db($sel_agrupo_presupuesto)){
		
					$valor_disponible_liinea = $sel_presu_ag[1];
					if($valor_disponible_liinea > 0 and $valor_disponible_liinea >= $valo_solicitado and $valo_solicitado > 0){
						$nuevo_valor_disponible = $valor_disponible_liinea - $valo_solicitado;
						$update = query_db("update t2_marco_temporal set eq_usd = $nuevo_valor_disponible where  id_presupuesto =".$sel_presu_ag[0]);
						$valo_solicitado = $valo_solicitado - $valor_disponible_liinea;
					}					
			
						
					}
					
					//arriba de despapaya los valores origenes
				}else{// Si mayor el disponible que las ots
					$valor_que_disponible_esp = $valor_disponible - $valo_solicitado;
					$update = query_db("update t2_marco_temporal set eq_usd = $valor_que_disponible_esp $comple_we  and especifico = 'SI'");
					}
			
			}
	//FIN ordenes de trabjado
	
	$fecha_hoy = date("Y-m-d");
	$cont = 0;
	
	
    $sel_cont = traer_fila_row(query_db("select id_contrato from t2_marco_temporal where id_item =".$id_item_pecc." and id_usuario = ".$_SESSION["id_us_session"]." and id_contrato=".$contrato_aplica." group by id_contrato order by id_contrato"));

				
		$sel_valor_especifico = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where  id_item =".$id_item_pecc." and id_contrato = ".$sel_cont[0]."  and especifico = 'SI' and id_usuario = ".$_SESSION["id_us_session"].""));
		
		$sel_valor_compartido = traer_fila_row(query_db("select sum(valor_usd), sum (valor_cop), sum(eq_usd) from t2_marco_temporal where id_item =".$id_item_pecc." and  id_contrato = ".$sel_cont[0]."  and especifico = 'NO' and id_usuario = ".$_SESSION["id_us_session"].""));
					
		  $espesifico_usd = $sel_valor_especifico[0];
		  $espesifico_cop = $sel_valor_especifico[1];
		  $eq_especifico = $sel_valor_especifico[2];
		  
		  $compartido_usd =$sel_valor_compartido[0];
		  $compartido_cop = $sel_valor_compartido[1];
          $eq_compartido = $sel_valor_compartido[2];
		 
		 	/* FIN VALIDACION DE MARCO*/
   			?>
            	<?
    if($tipo_contrato_bu == 0){
	?>
            	<td align="left">&nbsp;</td>
              	<td align="left">&nbsp;</td>
                <?
	}
	 if($tipo_contrato_bu == 2 || $tipo_contrato_bu == 0){
				?>
              	<td width="1%" align="left" class="xl65"><?=number_format($espesifico_usd,0)?></td>
		  		<td width="1%" align="left" class="xl65"><?=number_format($espesifico_cop,0)?></td>
                <td width="1%" align="left" class="xl65"><?=number_format($eq_especifico,0)?></td>
                <td width="1%" align="left" class="xl65"><?=number_format($compartido_usd,0)?></td>
                <td width="1%" align="left" class="xl65"><?=number_format($compartido_cop,0)?></td>
                <td width="1%" align="left" class="xl65"><?=number_format($eq_compartido,0)?></td>
              	<?
	 }
		  }
		  ?>
          <?
          }//mis contratos
		  ?>
		  <td width="1%" align="left"><?=estado_contrato_retu(arreglo_pasa_variables($ls_re[0]),$co1)?></td>
		  <td width="1%" align="left"><?=imprime_observacion(arreglo_pasa_variables($ls_re[0]),arreglo_pasa_variables(0),estado_contrato_retu_campo(arreglo_pasa_variables($ls_re[0]),$co1))
		  
		  ?></td>
		</tr>
		<?
	}
?>
</table>
<?
//if($xls==1){
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Contratos.xls"); 
//}
?>