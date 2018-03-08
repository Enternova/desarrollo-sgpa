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
	if($aplica_portales_bu!="0" and $aplica_portales_bu!=""){
		$query_comple = $query_comple." and aplica_portales =".$aplica_portales_bu."";
	}
	
	if($destino_bu!="0" and $destino_bu!=""){
		$query_comple = $query_comple." and destino =".$destino_bu."";
	}
	if($tipo_contrato_bu!="0"){
		$query_comple = $query_comple." and t1_tipo_documento_id =".$tipo_contrato_bu."";
	}
	
	if($gerente_bu!=""){
		$explode = explode("----,",elimina_comillas_2($gerente_bu));
		$id_gerente = $explode[1];
		$query_comple = $query_comple." and gerente = ".$id_gerente;
	}
	if($vigencia_bu!="0"){
		$fecha_hoy = getdate();
		if($vigencia_bu==1){
			$query_comple = $query_comple." and vigencia_mes >='".$fecha_hoy["year"]."-".$fecha_hoy["mon"]."-".$fecha_hoy["mday"]."'";
		}
		if($vigencia_bu==2){
			$query_comple = $query_comple." and vigencia_mes <'".$fecha_hoy["year"]."-".$fecha_hoy["mon"]."-".$fecha_hoy["mday"]."'";
		}
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
				$query_comple = $query_comple." and estado in (".$est_creacion.",".$est_abastecimiento.",".$est_sap.",".$est_revision.",".$est_firma_hocol.",".$est_firma_contratista.",".$est_poliza.",".$est_gerente_contrato.",".$est_legalizacion.")";
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

	$permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
	$permisos = $permisos.$query_comple ;

	if($query_env<>""){
		$permisos  = $query_env;
	}
?>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
	<tr class="columna_subtitulo_resultados_oscuro">
	  	<td width="3%">&nbsp;</td>
		<td width="7%">N&uacute;mero Solicitud</td>
	  	<td width="10%">Monto USD</td>
      	<td width="10%">Monto COP</td>
      	<td width="10%">Monto EQUI</td>
      	<td width="10%">Comprometido USD</td>
      	<td width="10%">Comprometido COP</td>
      	<td width="10%">Comprometido EQUI</td>
      	<td width="10%">Saldo USD</td>
      	<td width="10%">Saldo COP</td>
      	<td width="10%">Saldo EQUI</td>
  	</tr>
    
    <?
	$busca_solicitud_marco = "select distinct(id_item) from $co1 where t1_tipo_documento_id = 2 and (analista_deloitte <> 1 or analista_deloitte IS NULL) $permisos";
	$sql_busca_solicitud_marco=query_db($busca_solicitud_marco);
	while($lista_busca_solicitud_marco=traer_fila_row($sql_busca_solicitud_marco)){
	
		$id_item_pecc = $lista_busca_solicitud_marco[0];
		?>
		<?
       $sele_items_historico = "select num1,num2,num3 from $pi2 where id_item=".$id_item_pecc;
        $sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
        
        $sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio where id_item =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
        $eq_total=0;
        $usd_total=0;
        $cop_total=0;
        while($sel_inio = traer_fila_db($sel_valor_inicial)){
            $eq = $sel_inio[0] + ($sel_inio[1] / $sel_inio[2]);
            $usd_total = $sel_inio[0]+$usd_total;
            $cop_total = $sel_inio[1]+$cop_total;
            $eq_total = $eq+$eq_total;
        }
        
        $ampliacion = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
        $eq_total_amp_esp=0;
        $usd_total_amp_esp=0;
        $cop_total_amp_cop=0;
        while($sel_ampl = traer_fila_db($ampliacion)){
            $eq_ampli_espe = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
            $sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
            if($sel_si_esta_compartido[0] == 1){//presupuesto especifica
                $usd_total_amp_esp = $sel_ampl[0]+$usd_total_amp_esp;
                $cop_total_amp_cop = $sel_ampl[1]+$cop_total_amp_cop;
                $eq_total_amp_esp = $eq_ampli_espe+$eq_total_amp_esp;
                $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$sel_ampl[5]));
                $numero_contrato1 = "C";
    
                $separa_fecha_crea = explode("-",$sel_contrato[0]);
                $ano_contra = $separa_fecha_crea[0];
                $numero_contrato2 = substr($ano_contra,2,2);
                $numero_contrato3 = $sel_contrato[1];
                $numero_contrato4 = $sel_contrato[2];
            }//si es AMPLAICION ESPECIFICA
        }//FIN WHILE AMPLIACIONES
        
    
        $ampliacion = query_db("select t2_presupuesto_id, count(*) from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by t2_presupuesto_id");
        $eq_total_amp_esp_no=0;
        $usd_total_amp_esp_no=0;
        $cop_total_amp_cop_no=0;
            while($sel_ampl_no_espe = traer_fila_db($ampliacion)){
                if($sel_ampl_no_espe[1] > 1){//presupuesto comprtido
                    $sel_ampl = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." and t2_presupuesto_id = ".$sel_ampl_no_espe[0]." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id"));
                    $eq_ampli_espe_no = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
                        
                    
                    $usd_total_amp_esp_no = $sel_ampl[0]+$usd_total_amp_esp_no;
                    $cop_total_amp_cop_no = $sel_ampl[1]+$cop_total_amp_cop_no;
                    $eq_total_amp_esp_no = $eq_ampli_espe+$eq_total_amp_esp_no;
                    $num_conta_imp="";
    
                    $sel_contras = query_db("select t7_contrato_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." and t2_presupuesto_id = ".$sel_ampl_no_espe[0]." group by t7_contrato_id");
                    while($sel_contr = traer_fila_db($sel_contras)){
                     $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$sel_contr[0]));
                        $numero_contrato1 = "C";			
                        $separa_fecha_crea = explode("-",$sel_contrato[0]);
                        $ano_contra = $separa_fecha_crea[0];
                        
                        $numero_contrato2 = substr($ano_contra,2,2);
                        $numero_contrato3 = $sel_contrato[1];
                        $numero_contrato4 = $sel_contrato[2];
                        $num_conta_imp = $num_conta_imp."".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)."<br />";
                    }
                }//si es AMPLAICION NO ESPECIFICA
            }//FIN WHILE AMPLIACIONES
        
        //Inicio OT
        $eq_total_ot=0;
        $usd_total_ot=0;
        $cop_total_ot=0;
        $sel_orden = query_db("select id_item from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc." group by id_item");
            while($or_ot_arupa = traer_fila_db($sel_orden)){
                
                    
                    
                    $or_ot = traer_fila_row(query_db("select id_item_peec_aplica, trm, valor_usd, valor_cop, t1_campo_id, ano, t7_contrato_id from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc." and id_item = ".$or_ot_arupa[0]));
                    
                    
                    $eq_ot = $or_ot[2] + ($or_ot[3] / $or_ot[1]);				
                    $usd_total_ot = $or_ot[2]+$usd_total_ot;
                    $cop_total_ot = $or_ot[3]+$cop_total_ot;
                    $eq_total_ot = $eq_ot+$eq_total_ot;
                    
                    $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$or_ot[6]));
                     $numero_contrato1 = "C";
                
                        $separa_fecha_crea = explode("-",$sel_contrato[0]);
                        $ano_contra = $separa_fecha_crea[0];
                        
                        $numero_contrato2 = substr($ano_contra,2,2);
                        $numero_contrato3 = $sel_contrato[1];
                        $numero_contrato4 = $sel_contrato[2];
     
      }
        //FIN OT
      ?>
        <tr>
          <td><font color="#0000FF"><div onclick="carga_detalle_sol(<?=$id_item_pecc;?>)">Detalle</div></font></td>
            <td><?=numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])?></td>
            <td><?=number_format(($usd_total+$usd_total_amp_esp+$usd_total_amp_esp_no),0)?></td>
            <td><?=number_format(($cop_total+$cop_total_amp_cop+$cop_total_amp_cop_no),0)?></td>
            <td><?=number_format(($eq_total+$eq_total_amp_esp+$eq_total_amp_esp_no),0)?></td>
            <td><?=number_format($usd_total_ot, 0)?></td>
            <td><?=number_format($cop_total_ot, 0)?></td>
            <td><?=number_format($eq_total_ot, 0)?></td>
            <td><?=number_format(($usd_total+$usd_total_amp_esp+$usd_total_amp_esp_no)-$usd_total_ot, 0)?></td>
            <td><?=number_format(($cop_total+$cop_total_amp_cop+$cop_total_amp_cop_no)-$cop_total_ot, 0)?></td>
            <td><?=number_format(($eq_total+$eq_total_amp_esp+$eq_total_amp_esp_no)-$eq_total_ot, 0)?></td>
        </tr>
        <tr>
          <td colspan="11" id="detalle_solicitud_<?=$id_item_pecc;?>"></td>
        </tr>
		<?
		if($array_id_item_pecc_env <> ""){
			$coma = ",";
		}
		
		$array_id_item_pecc_env = $array_id_item_pecc_env.$coma.$id_item_pecc;
	}
	
	
	?>
	<input type="hidden" value="<?=$array_id_item_pecc_env;?>" name="array_id_item_pecc_env" id="array_id_item_pecc_env" />
</table>
